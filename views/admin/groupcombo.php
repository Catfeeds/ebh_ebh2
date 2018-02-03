<select name="groupid" id="groupid">
</select>
<script>
$(function(){
			$.ajax({
				url:'<?php echo geturl('admin/staff/getgroup');?>',
				type:'GET',
				success:function(data){
					var datas = eval('('+data+')'); 
					for(var i=0;i<datas.length;i++){
						$("#groupid").append("<option value='"+datas[i]['groupid']+"'>"+ datas[i]['groupname']+ "</option>");  
					}
					
				},
				error:function(){
					alert();
				}
			});
		})
</script>