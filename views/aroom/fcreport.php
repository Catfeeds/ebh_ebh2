<?php $this->display('aroom/page_header')?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<div class="ter_tit">
		当前位置 > 课程课件统计
		</div>
	<div class="lefrig">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;background:#fff;">本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个
<div class="tiezitoolss">
<a class="excelbtn" href = "/aroom/report/fcexcel.html"> 导出excel</a>
</div>
</div>

<div id="p_fct" style="display:none;"><div id="fct"></div></div>

<table class="datatab" width="100%">
<thead class="tabhead">
<tr>
<th>课程名称</th>
<th>任课教师</th>
<th>课件数量</th>
</tr>
</thead>
<tbody>

	<?php if(!empty($courselist)){
		$coursenum = 0;//$teachernum = 0;
		foreach($courselist as $cl){
		$coursenum += $cl['coursewarenum'];
		// $teachernum += $cl['teachernum'];
	?>
		<tr>
		<td width="200px"><?=!empty($cl['foldername'])?$cl['foldername']:''?></td>
		<td width="400px"><?=!empty($cl['teachers'])?$cl['teachers']:''?></td>
		<td width="100px"><?=!empty($cl['coursewarenum'])?$cl['coursewarenum']:'0'?></td>
		</tr>
	<?php }?>
	<tr>
		<td width="200px">合计：&nbsp;<span style="color:blue;font-weight:bold;"><?=count($courselist)?></span>&nbsp;个课程</td>
		<td width="400px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$teachernum?></span>&nbsp;个教师</td>
		<td width="100px">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$coursenum?></span>&nbsp;个</td>
		</tr>
	<?php }else{?>

	<tr><td colspan="4" align="center">暂无记录</td></tr>
	<?php }?>

</tbody>
</table>
</div>
<?php $this->display('aroom/page_footer')?>
