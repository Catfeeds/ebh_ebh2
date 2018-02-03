<select name="crid" id="crid">
       <option value="">选择同步学堂</option>
</select>
<script>
	$(function(){
		var _html = $("#crid").html();
		$.post('/admin/classroomMenue/getCrList.html',
				{checked:'<?php echo @$CR['selected'] ?>'},
				function(message){
				$("#crid").html(_html+message);	
				}
			);
	});
</script>