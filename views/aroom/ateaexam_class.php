<?php $this->display('aroom/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

	<div class="ter_tit">
		当前位置 > 教师所教班级
		</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">该教师所教班级共有 <span style="color:blue;font-weight:bold;"><?=count($classlist)?></span> 个.
<a class="tfanhui" href="<?=geturl('aroom/ateaexam')?>" style="left: 640px;_top:13px;position: absolute;width:90px;">返回上一页</a>
</div>
<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>
<th>班级名称</th>
<th>人数</th>
<th>作业数</th>
<th>试题数</th>
<th>最近作业</th>
<th></th>
</tr>
</thead>
<tbody>
	
	<?php if(!empty($classlist)){
		$sumarr = array('stunum'=>0,'examnum'=>0,'quenum'=>0);
		foreach($classlist as $cl){
		$sumarr['stunum']+=$cl['stunum'];
		$sumarr['examnum']+=$cl['count'];
		$sumarr['quenum']+=$cl['quescount'];
	?>
		<tr>
			<td width="20%"><?=$cl['classname']?></td>
			<td width="15%"><?=$cl['stunum']?></td>
			<td width="15%"><?=!empty($cl['count'])?$cl['count']:'0'?></td>
			<td width="15%"><?=!empty($cl['quescount'])?$cl['quescount']:'0'?></td>
			<td width="20%"><?=empty($cl['lastexamdate'])?'无':Date('Y-m-d H:i:s',$cl['lastexamdate'])?></td>
			<td width="20%"><a href="<?=geturl('aroom/ateaexam/class/exam/'.$cl['classid'].'-0-0-0-'.$uid)?>" class="previewBtn" title="班级作业">班级作业</a></td>
		</tr>
		<?php }?>
		
		<tr>
			<td width="20%">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=count($classlist)?></span>&nbsp;班</td>
			<td width="15%">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$sumarr['stunum']?></span>&nbsp;人</td>
			<td width="15%">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$sumarr['examnum']?></span>&nbsp;</td>
			<td width="15%">计：&nbsp;<span style="color:blue;font-weight:bold;"><?=$sumarr['quenum']?></span>&nbsp;</td>
			<td width="20%"></td>
			<td width="20%"></td>
		</tr>
		<?php }else{?>

		<tr><td colspan="6" align="center">暂无记录</td></tr>
		<?php }?>
	
</tbody>
</table>
</div>
<?php $this->display('aroom/page_footer')?>
