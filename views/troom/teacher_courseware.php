<?php $this->display('troom/page_header')?>
<body>
<div>
<div class="ter_tit">
<?php 
$rurl = $this->input->get('rurl');
$rrurl = $this->input->get('rrurl');
?>
	<?php 
	if($rurl == 'troom/teacher/teacherlist'){?>
		当前位置 > <a href="<?=geturl('troom/report')?>">统计分析</a> > <a href="<?=geturl('troom/teacher/viewnav')?>"> 教师查看 </a> > <a href="<?=geturl('troom/teacher/teacherlist')?>"> 教师列表 </a> > 课件查看
	<?php }else{?>
		当前位置 > <a href="/troom/statisticanalysis.html">查询统计</a> > <a href="/troom/statisticanalysis/teach.html"> 教师统计 </a> > 课件查看
		<?php }?>
	</div>
<div class="coursewareview">
	<table cellpadding="0" cellspacing="0" class="tables">
    	<tr class="second">
        	<td colspan="6">
            	<div class="teacher fl"><b style="font-size:16px;">教师:</b></div>				
                <div class="xingming_p fl" style="font-size:16px;"> <?=$tuser[0]['realname']?>　(<?=empty($tuser[0]['sex'])?'男':'女'?>)　<?=$tuser[0]['username']?></div>
				<ul style="padding-top:5px;">
					<?php $selfolderid = $this->input->get('selfolderid');
						
					?>
                    <li class="fl"><a href="<?=geturl('troom/teacher/courseware/'.$tuser[0]['uid'])?>?rurl=<?=$rurl?>&rrurl=<?=$rrurl?>" class="<?=empty($selfolderid)?'select':''?>">不限</a></li>
					<?php
					foreach($folderlist as $folder){
					?>
                    <li class="fl"><a href="<?=geturl('troom/teacher/courseware/'.$tuser[0]['uid'])?>?rurl=<?=$rurl?>&selfolderid=<?=$folder['folderid']?>&rrurl=<?=$rrurl?>" class="<?=$selfolderid==$folder['folderid']?'select':''?>"><?=$folder['foldername']?></a></li>
                    <?php }?>
                </ul>
                <div class="clear"></div>
            </td> 
        </tr>
		
        <tr class="first">
            <td width="260">课件名称</td>
            <td width="117">发布时间</td>
            <td width="41">大小</td>
            <td width="99">时长</td>
            <td width="49">人气</td>
            <td width="139">查看</td>
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
			if(empty($cw['cwurl']) || in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov'))){
				$target = '_blank';
				$coursetype = 'classcourseflv';
			}
			?>
        <tr>
            <td width="260" style=""><b><?=$cw['title']?></b><br /><div style='width:255px;' title="<?=$cw['summary']?>"><?=shortstr($cw['summary'],40)?></div></td>
            <td width="117"><?=Date('Y-m-d H:i:s',$cw['truedateline'])?></td>
            <td width="41"><?=$cwsize?>M</td>
            <td width="99"><?=secondToStr($cw['cwlength'])?></td>
            <td width="49"><?=empty($viewnum)?$cw['viewnum']:$viewnum?></td>
            <td width="139"><a target="<?=$target?>" href="<?=geturl('troom/teacher/'.$coursetype.'/view-1-0-0-'.$cw['cwid'])?>">查看</a>&nbsp;&nbsp;&nbsp;<a href="<?=geturl('troom/teacher/cwstudylog/'.$cw['cwid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">学习监控</a></td>
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
