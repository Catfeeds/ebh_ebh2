<script type='text/javascript'>
	$.post('/admin/module/getModuleListAjax.html',{selected:"<?=$data['selected']?>"},function(message){
				$("#<?=$data['tag']?>").append(message);
			},
			'html'
		);
</script>