<?php $this->display('aroom/page_header')?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<div class="ter_tit">
		当前位置 > 班级作业统计
		</div>
	<div class="lefrig">

<div class="annuato" style="line-height:28px;padding-left:20px;background:#fff;position: relative;">本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个
<div class="tiezitoolss">
<a class="excelbtn" href = "/aroom/report/ceexcel.html"> 导出excel</a>
</div>
</div>

<table class="datatab" width="100%">
<thead class="tabhead">
<tr>
<th>班级名称</th>
<th>任课教师</th>
<th>班级人数</th>
<th>作业数</th>
<th>试题数</th>
</tr>
</thead>
<tbody>

	<?php if(!empty($classlist)){
		$examnum = 0;
		$quescount = 0;
		foreach($classlist as $cl){
		$examnum += $cl['count'];
		$quescount += $cl['quescount'];
	?>
		<tr>
		<td width="180px"><?=$cl['classname']?></td>
		<td width="450px"><span style="width:370px;word-wrap: break-word;float:left;"><?=!empty($cl['teachers'])?$cl['teachers']:''?></span></td>
		<td width="60px"><?=$cl['stunum']?></td>
		<td width="60px"><?=empty($cl['count'])?'0':$cl['count']?></td>
		<td width="60px"><?=empty($cl['quescount'])?'0':$cl['quescount']?></td>
		</tr>
		<?php }?>

		<tr>
		<td width="180px">合计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;班</td>
		<td width="450px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$teachernum?></span>&nbsp;教师</td>
		<td width="60px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;</td>
		<td width="60px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$examnum?></span>&nbsp;</td>
		<td width="60px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$quescount?></span>&nbsp;</td>
		</tr>
	<?php }else{?>

	<tr><td colspan="5" align="center">暂无记录</td></tr>
	<?php }?>

</tbody>
</table>
</div>
<?php $this->display('aroom/page_footer')?>