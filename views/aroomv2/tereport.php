<?php $this->display('aroomv2/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<style>
.tabhead th{
	font-weight:normal;
}
</style>
	<div class="ter_tit">
		当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/teacher/viewnav.html">教师查看</a> > 教师作业统计
		</div>
	<div class="lefrig">
	<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;background:#fff; margin-top:15px;">本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个
	<div class="tiezitoolss">
	<a class="workBtns workBtns-1" href = "/aroom/report/teexcel.html"> 导出excel</a>
	</div>
	</div>


<table class="datatab" width="100%">
<thead class="tabhead">
<tr style="">
<th>用户名</th>
<th>教师姓名</th>
<th>布置作业</th>
<th>布置试题</th>
</tr>
</thead>
<tbody>

	<?php if(!empty($teacherlist)){
		$coursenum = 0;
		$quesnum = 0;
		foreach($teacherlist as $tl){
		$coursenum += $tl['count'];
		$quesnum += $tl['quescount'];
	?>
	<tr>
		<td width="200px"><?=$tl['username']?></td>
		<td width="200px"><?=$tl['realname']?></td>
		<td width="100px"><?=empty($tl['count'])?'0':$tl['count']?></td>
		<td><?=empty($tl['quescount'])?'0':$tl['quescount']?></td>
	</tr>
	<?php }?>
	<tr>
		<td width="200px">合计</td>
		<td width="200px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=count($teacherlist)?></span>&nbsp;个教师</td>
		<td width="100px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$coursenum?></span>&nbsp;个</td>
		<td colspan="1">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$quesnum?></span>&nbsp;个</td>
	</tr>
	<?php }else{?>
	<tr><td colspan="3" align="center">暂无记录</td></tr>
	<?php }?>
</tbody>
</table>
</div>
<?php $this->display('aroomv2/page_footer')?>