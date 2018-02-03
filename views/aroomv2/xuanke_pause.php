<?php if(in_array($activity['status'],array(3,5)) && !empty($rule) && SYSTIME>=$rule['start_t'] && SYSTIME<=$rule['end_t']){?>			
<div class="hdjsckanbtn"><a href="javascript:void(0)" class="tzdel tzadd" id="pausebtn" curstatus="<?=$activity['ispause']?>" xkid="<?=$activity['xkid']?>"><?=$activity['ispause']?'继续选课':'暂停选课'?></a></div>
<?php }?>
<script>
$('#pausebtn').click(function(){
	var ispause = 1-parseInt($(this).attr('curstatus'));
	var xkid = $(this).attr('xkid');
	$.ajax({
		url:'/aroomv2/xuanke/xuanke/edit.html',
		type:'post',
		data:{xkid:xkid,ispause:ispause,pauseonly:1},
		success:function(data){
			location.reload(true);
		}
	})
});
</script>