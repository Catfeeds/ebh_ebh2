<?php $this->display('myroom/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
			<div class="ter_tit">
	当前位置 > <a href="<?= geturl('myroom/survey') ?>" >调查问卷</a> > 问卷列表
</div>
<div class="lefrig">

		<table class="datatab" width="100%">
<thead class="tabhead">
<tr>
<th>名称</th>
<th>类型</th>
<th>时间</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php if(!empty($surveylist)){
		foreach($surveylist as $survey){?>
		<tr>
		<td width="200px"><?=$survey['title']?></td>
		<td width="200px"><?=$survey['type']?></td>
		<td width="120px"><?=Date('Y-m-d H:i:s',$survey['dateline'])?></td>
		<td width="100px"><a class="liuibtn" href="/myroom/survey/doit.html?sid=<?=$survey['sid']?>">答卷</a> </td>
		</tr>
	
		<?php }
}?>
</tbody>
</table>

</div>


	<script type="text/javascript">
	
	</script>

<?php $this->display('myroom/page_footer'); ?>