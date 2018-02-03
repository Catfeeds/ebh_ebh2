<div class="w300 h200" id="operationList"></div>
<script type='text/javascript'>
	$.post('/admin/operation/getOpSimpleList.html',{opvalue:"<?=$data['opvalue']?>",position:"<?=$data['position']?>"},function(message){
		$('#operationList').html(message);
	});
</script>