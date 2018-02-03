<?php $this->display('troomv2/page_header')?>
<body>
<div>
<div class="ter_tit">
		当前位置 > <a href="/troomv2/statisticanalysis.html">查询统计</a> > <a href="/troomv2/statisticanalysis/teach.html"> 教师统计 </a> > 课程查看
	</div>
<div class="coursecheck">
	<table cellpadding="0" cellspacing="0" class="tables">
		<tr  class="second">
        	<td  colspan="4">
            	<div>
                	<div class="teacher fl"><b style="font-size:16px;">教师:</b></div>
                    <div class="xingming_p fl" style="font-size:16px;"><?=$tuser[0]['realname']?>　(<?=empty($tuser[0]['sex'])?'男':'女'?>)　<?=$tuser[0]['username']?></div>
                </div>
            </td>
        </tr>
		<tr  class="first">
			<td width="295">课程名称</td>
			<td width="139">课件数</td>
			<td width="153">人气</td>
			<td width="151">查看</td>
			</tr>
		<?php 
			$rrurl = $this->input->get('rurl');
			// $rurl = $this->input->get('rurl');
			$rurl = $this->uri->path;
		foreach($folderlist as $folder){
			$viewnumlib = Ebh::app()->lib('Viewnum');
			$viewnum = $viewnumlib->getViewnum('folder',$folder['folderid']);
			$viewnum = empty($viewnum)?$folder['viewnum']:$viewnum;
			
			?>
		<tr>
			<td width="295"><b><?=$folder['foldername']?></b><br /></td>
			<td width="139"><?=$folder['coursewarenum']?></td>
			<td width="153"><?=$viewnum?></td>
			<td width="151"><a href="<?=geturl('troomv2/teacher/courseware/'.$this->uri->itemid).'?rurl='.$rurl.'&selfolderid='.$folder['folderid'].'&rrurl='.$rrurl?>">查看</a></td>
		</tr>
        <?php }?>
	</table>
    <div class="button2 fr"><a href="<?=empty($rrurl)?geturl('troomv2/report/teacher'):'/'.$rrurl.'.html'?>">返 回</a></div>
</div>
</body>
</html>
