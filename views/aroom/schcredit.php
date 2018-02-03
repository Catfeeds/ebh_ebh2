<?php $this->display('aroom/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
	.datatab th,.datatab td{
		text-align: center;
	}
</style>
<div class="ter_tit">
	当前位置 > 学分设置
</div>
<div class="lefrig" style="margin-top:10px;">
	<table class="datatab" width="100%">
		<thead class="tabhead">
			<tr class="">
				<th>年级</th>
				<th>达标学分</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($gradeList as $key => $grade) {?>
			<?php
				$gradeScore = array_key_exists($key, $gradeScoreList)?$gradeScoreList[$key]['score']:0;
			?>
			<tr class="">
				<td width="200px"><?=$grade?></td>
				<td width="300px">
					<input  maxlength=6 size=10 style="text-align:center" type="text" value="<?=$gradeScore?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=(this.value>0?this.value:0)" /></td>
				<td width="200px">
					<a class="workBtn" style="margin-left:65px;width:80px;" title="提交" onclick="showGradeEditor(this,<?=$key?>)">提  交</a>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<script>
	$(function(){

	});
	function showGradeEditor(e,grade){
		var purl = "<?= geturl('aroom/schcredit/editAjax')?>";
		var score = $(e).parents('tr').find('input').val();
		$.confirm("操作提示","确定要修改吗？", function(r) {
			$.ajax({
				type	:'POST',
				url		:purl,
				data	:{'score':score,'grade':grade},
				dataType:'text',
				success	:function(res){
					if(res>=0){
						$.showmessage({message:'修改成功！'});
					}else{
						$.showmessage({message:'修改失败！'});
					}
				}
			});
		});
	}
</script>
<?php $this->display('myroom/page_footer'); ?>