<form id="ck">
<table  cellpadding="0" cellspacing="0" border="0" width="100%" class="listtable">
	<tr>
		<td>选择</td>
		<td>问题</td>
		<td>得分</td>
		<td>排序</td>
	</tr>
	<?php if($questions){foreach($questions as $question){?>
		<tr>
			<td><input type="checkbox" value="<?=$question['qid']?>" name="qid[]" class="qitem" /></td>
			<td><?=$question['qtitle']?></td>
			<td><?=$question['score']?></td>
			<td><?=$question['sort']?></td>
		</tr>
	<?php }}else{?>
	<?php } ?>
</table>

    <div style="left:100px;bottom:30px;position: absolute">
    <input type="button" value="保存" onclick="_save()" />
    <input type="button" value="取消" onclick="_close()" />
    </div>
</form>




<script type="text/javascript">
$(function(){
	var str = '<?=$str?>';
	if(str!=''){
		var arr = str.split(";");
		$.each($(".qitem"),function(k,v){
			var qid = $(v).val();
			if($.inArray(qid,arr)>=0){
				$(v).attr("checked",true);
				}
			});
		}
})
function _close(){
    $('.panel-tool-close').trigger('click');
}

function _save(){
	var arr = [];
	$(".qitem").each(function(k,v){
		if($(v).is(":checked")){
			arr.push($(v).val());
			}
		});
	var str = arr.join(";");
	//alert(str)
	if(str!=''){
		$("#keyitemstr").val(str);
	}
	_close();
}
 </script>