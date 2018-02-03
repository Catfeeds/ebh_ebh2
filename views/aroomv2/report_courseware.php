<?php $this->display('aroomv2/page_header')?>
<body>
<div class="ter_tit">
		当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/report/course.html">课程查看</a> > 课件查看
	</div>
<div class="coursewareview">
	<table cellpadding="0" cellspacing="0" class="tables" >
        <tr   class="first">
            <td width="282" >课件名称</td>
            <td width="124">发布时间</td>
            <td width="39">大小</td>
            <td width="98">时长</td>
            <td width="47">人气</td>
            <td width="124">查看</td>
        </tr>
		<?php 
		$rurl = $this->input->get('rurl');
		if(!empty($cwlist)){
			$viewnumlib = Ebh::app()->lib('Viewnum');
		$sumsize = 0;
		$sumviewnum = 0;
		$sumlength = 0;
		foreach($cwlist as $cw){
			$face = getthumb($cw['face'],'50_50');
			if(empty($face))
				$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($cw['sex'])?'t_man_50_50.jpg':'t_woman_50_50.jpg');
			$cwsize = round($cw['cwsize']/1024/1024,1);
			$viewnum = $viewnumlib->getViewnum('courseware',$cw['cwid']);
			$viewnum = empty($viewnum)?$cw['viewnum']:$viewnum;
			$arr = explode('.',$cw['cwurl']);
			$type = $arr[count($arr)-1];
			$target = '_blank';
//			$coursetype = 'classcourse';
//			if(empty($cw['cwurl']) || in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov'))){
//				$target = '_blank';
				$coursetype = 'course';
			//}
			$sumsize += $cw['cwsize'];
			$sumviewnum += $viewnum;
			$sumlength += $cw['cwlength'];
			?>
        <tr >
			
			<td width="282"><div><img src="<?=$face?>" style="height:50px; width:50px; float:left;display:inline;"><div><p style="float:left;display:inline;padding-left:5px; width:225px;word-wrap: break-word;font-size:14px;height:35px; overflow:hidden;"><b ><?=$cw['title']?></b></p><p style="float:left;display:inline;padding-left:5px; width:225px;word-wrap: break-word;font-size:14px;height:23px; overflow:hidden; font-size:12px; color:#808080;"><?=$cw['realname']?>(<?=$cw['username']?>)</p></div></div></td>
			<td width="124"><?=Date('Y-m-d H:i:s',$cw['dateline'])?></td>
			<td width="39"><?=$cwsize?>M</td>
			<td width="98"><?=secondToStr($cw['cwlength'])?></td>
			<td width="47"><?=$viewnum?></td>
			<td width="124"><a target="<?=$target?>" href="<?=geturl('troomv2/'.$coursetype.'/view-1-0-0-'.$cw['cwid'])?>">查看</a>&nbsp;&nbsp;<a href="<?=geturl('aroomv2/teacher/cwstudylog/'.$cw['cwid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">学习监控</a></td>
		</tr>
		
        <?php }?>
		<tr>
            <td width="282" colspan="2"><b>合计:</b></td>
            <td width="39"><?=round($sumsize/1024/1024,1)?>M</td>
            <td width="98"><?=secondToStr($sumlength)?></td>
            <td width="47" colspan="2"><?=$sumviewnum?></td>
        </tr>
		<?php }else{?>
		<tr><td colspan="6" style='text-align:center'>暂无课件</td></tr>
        <?php }?>
    </table>
    <div class="button2 fr"><a href="/<?=$rurl?>.html">返 回</a></div>
    <?=$pagestr?>
</div>
</body>
</html>
