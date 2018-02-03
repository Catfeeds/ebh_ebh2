<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
.tables td{
	text-align: center;
}
</style>
<div class="ter_tit">
    当前位置 &gt; <a href="<?=geturl('aroomv2/course')?>">课程管理</a> &gt; <a href="<?=geturl('aroomv2/course/courses')?>">本校课程</a> &gt; 学分设置
</div>
<div class="mt15">
	<table cellpadding="0" cellspacing="0" class="tables">
		<tr class="first">
			<td>年级</td>
			<td>达标学分</td>
			<td>操作</td>
		</tr>
		<?php foreach ($gradeList as $key => $grade) {?>
		<?php
			$gradeScore = array_key_exists($key, $gradeScoreList)?$gradeScoreList[$key]['score']:0;
		?>
		<tr class="">
			<td width="200"><?=$grade?></td>
			<td width="300">
				<input  maxlength=6 size=10 style="text-align:center" type="text" value="<?=$gradeScore?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=(this.value>0?this.value:0)" /></td>
			<td width="200">
				<a title="提交" onclick="showGradeEditor(this,<?=$key?>)">提交</a>
			</td>
		</tr>
		<?php }?>
	</table>
</div>

<!--删除消息-->
<div id="delte" class="tanchukuang" style="display:none;height:130px;">
    <div class="tishi" style="height:70px;line-height: 45px;"><span>您确定要修改吗？</span></div>
    <input type="hidden" name="score" id="score" value="" />
    <input type="hidden" name="grade" id="grade" value="" />
</div>
<script>
function showGradeEditor(e,grade){
	var score = $(e).parents('tr').find('input').val();
	$("#score").val(score);
	$("#grade").val(grade);
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
		//$.confirm("操作提示","确定要修改吗？", function(r) {
			score = $("#score").val();
			grade = $("#grade").val();
			$.ajax({
				type	:'POST',
				url		:"<?= geturl('aroomv2/schcredit/editAjax')?>",
				data	:{'score':score,'grade':grade},
				dataType:'text',
				success	:function(res){
					if(res>0){
						$.showmessage({message:'修改成功！'});
					}else{
						$.showmessage({message:'修改失败！'});
					}
				}
			});
		//});
			H.get('delte').exec('close');
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			// location.reload();
			H.get('delte').exec('close');
			return false;
		}
	});

	if(!H.get('delte')){
		H.create(new P({
			id : 'delte',
			title: '操作提示',
			easy:true,
			width:420,
			padding:5,
			button:button,
			content:$('#delte')[0]
		}),'common').exec('show');
		
	}else{
		H.get('delte').exec('show');
	}
	}
</script>
<?php $this->display('aroomv2/page_footer'); ?>