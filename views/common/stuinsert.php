<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<body>
从ID：<input type="text" id="idfrom" value="1"/> 开始<br/><br/>

导入　<input type="text" id="idnum" value="1000"/>条数据<br/><br/>
<input type="button" onclick="submit()" value="开始导入"/>
<div id="errors">
</div>
</body>
<script>
function submit(){
	var idfrom = $('#idfrom').val();
	var idnum = $('#idnum').val();
	$.ajax({
		url:'/stuinsert/insert.html?idfrom='+idfrom+'&idnum='+idnum+'&rand='+Math.random(),
		success:function(data){
			
			result = eval('('+data+')');
			$('#errors').html('');
			$('#errors').append(result.timespent+'<br/>');
			
			$.each(result.errors,function(k,v){
				
				$('#errors').append(v+'<br/>');
			});
				
		}
	});
	
}
</script>
</html>