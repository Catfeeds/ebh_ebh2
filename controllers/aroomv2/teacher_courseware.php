<?php $this->display('aroomv2/page_header')?>
<body>
<div>
<div class="ter_tit">
<?php 
$rurl = $this->input->get('rurl');
$rrurl = $this->input->get('rrurl');
?>
	<?php 
	if($rurl == 'aroomv2/teacher/teacherlist'){?>
		当前位置 > <a href="<?=geturl('aroomv2/report')?>">统计分析</a> > <a href="<?=geturl('aroomv2/teacher/viewnav')?>"> 教师查看 </a> > <a href="<?=geturl('aroomv2/teacher/teacherlist')?>"> 教师列表 </a> > 课件查看
	<?php }else{?>
		当前位置 > <a href="<?=geturl('aroomv2/report')?>">统计分析</a> > <a href="<?=geturl('aroomv2/report/teacher')?>"> 教师统计 </a> > 课件查看
		<?php }?>
	</div>
<div class="coursewareview">
	<table cellpadding="0" cellspacing="0" class="tables">
    	<tr class="second">
        	<td colspan="6" style="padding:0!important;">
            	<div class="teacher fl">教师</div>
				<?php 
					$face = getthumb($tuser[0]['face'],'50_50');
					if(empty($face))
						$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($tuser[0]['sex'])?'t_man_50_50.jpg':'t_woman_50_50.jpg');?>
                <div class="xingming_p fl"><img src="<?=$face?>" class="fl" style="padding-right:5px;"><?=$tuser[0]['realname']?>(<?=empty($tuser[0]['sex'])?'男':'女'?>)<br /><?=$tuser[0]['username']?></div>
				<ul style="padding-top:5px;">
                	<li class="fl"><b style="font-size:13px;">课程>></b></li>
					<?php $selfolderid = $this->input->get('selfolderid');
						
					?>
                    <li class="fl"><a href="<?=geturl('aroomv2/teacher/courseware/'.$tuser[0]['uid'])?>?rurl=<?=$rurl?>&rrurl=<?=$rrurl?>" class="<?=empty($selfolderid)?'select':''?>">不限</a></li>
					<?php
					foreach($folderlist as $folder){
					?>
                    <li class="fl"><a href="<?=geturl('aroomv2/teacher/courseware/'.$tuser[0]['uid'])?>?rurl=<?=$rurl?>&selfolderid=<?=$folder['folderid']?>&rrurl=<?=$rrurl?>" class="<?=$selfolderid==$folder['folderid']?'select':''?>"><?=$folder['foldername']?></a></li>
                    <?php }?>
                </ul>
                <div class="clear"></div>
            </td> 
        </tr>
		
        <tr class="first">
            <td width="289">课件名称</td>
            <td width="117">发布时间</td>
            <td width="41">大小</td>
            <td width="99">时长</td>
            <td width="49">人气</td>
            <td width="119">查看</td>
            </tr>
		<?php 
		if(!empty($cwlist)){
			$viewnumlib = Ebh::app()->lib('Viewnum');
						
			foreach($cwlist as $cw){
				$cwsize = round($cw['cwsize']/1024/1024,1);
			$viewnum = $viewnumlib->getViewnum('courseware',$cw['cwid']);
			$arr = explode('.',$cw['cwurl']);
			$type = $arr[count($arr)-1];
			$target = '';
			$coursetype = 'classcourse';
			if(in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm'))){
				$target = '_blank';
				$coursetype = 'classcourseflv';
			}
			?>
        <tr>
            <td width="289" style=""><b><?=$cw['title']?></b><br /><div style='width:280px;' title="<?=$cw['summary']?>"><?=shortstr($cw['summary'],40)?></div></td>
            <td width="117"><?=Date('Y-m-d H:i:s',$cw['truedateline'])?></td>
            <td width="41"><?=$cwsize?>M</td>
            <td width="99"><?=secondToStr($cw['cwlength'])?></td>
            <td width="49"><?=empty($viewnum)?$cw['viewnum']:$viewnum?></td>
            <td width="119"><a target="<?=$target?>" href="<?=geturl('aroomv2/teacher/'.$coursetype.'/view-1-0-0-'.$cw['cwid'])?>">查看</a>&nbsp;&nbsp;&nbsp;<a href="<?=geturl('aroomv2/teacher/cwstudylog/'.$cw['cwid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">学习监控</a></td>
        </tr>
		<?php }
		}else{?>
		<tr><td colspan="6" style='text-align:center'>暂无课件</td></tr>
		<?php }?>
    </table>
    <div class="button2 fr"><a href="/<?=$rurl?>.html?rurl=<?=$rrurl?>">返 回</a></div>
	<?=$pagestr?>
</div>
</body>
</html>
