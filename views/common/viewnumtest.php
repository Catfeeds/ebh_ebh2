<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<style>
.notenough{
	background:yellow;
}
</style>

<body>
<br/>
<br/>
<input type="text" value="courseware" id="type"> type:courseware,folder等
<br/>
<br/>
<div>
<input type="text" id="cwid">
<input type="button" value="查看课件的viewnum" onclick="getviewnum()">
<span id="numspan"></span>
</div>
<br/>
<div>
<input type="button" value="同步所有viewnum到数据库" onclick="updateviewnum()">
<input type="button" value="清空缓存" onclick="clearcache()">
</div>
<br/>
<div>
<input type="text" id="cwidfrom"> - <input type="text" id="cwidto">
加<input type="text" style="width:50px" id="viewnum">viewnum
<input type="button" value="设置从id到id的缓存viewnum+1" onclick="setcache()">
</div>

<div>
<br />
<br />
<span style="color:red;font-size:18px;">以下是服务项修改：</span><br />

服务项ID从 <input type="text" id="itemidfrom"> - <input type="text" id="itemidto">
加<input type="text" style="width:50px" id="viewnumfrom"> - <input type="text" style="width:50px" id="viewnumto">viewnum
<input type="button" value="设置服务项缓存viewnum+数值范围随机" onclick="setitemcache()">
</div>


<br/>
<br/>

<input type="button" value="获取数据库sum(cw)的viewnum" onclick="getviewnumdb()">
<input type="button" value="同步不足的folder" onclick="setcache2folder()">

<br/>
<br/>
总计缓存:<span id="total" style="margin-right:100px"></span>		总计数据库:<span id="totaldb"></span>
<br/>
<br/>
<table border="1" id="allviewnumtable" style="float:left;margin-right:100px">

</table>

<table border="1" id="allviewnumtabledb">

</table>

</body>
<script>
function getviewnum(){
	$('#total')[0].innerText = '';
	$('#allviewnumtable').html('');
	$('#numspan').html('');
	var id = $('#cwid').val();
	var type = $('#type').val();
	var url = '/viewnumtest/getviewnum.html';
	var all = 0;
	if(id == ''){
		url = '/viewnumtest/getallviewnum.html';
		all = 1;
	}
	$.ajax({
		url : url,
		type : 'post',
		data : {'id':id,'type':type},
		success : function(data){
			var varr = JSON.parse(data);
			if(all==0)
				$('#numspan').html('id:'+id+'&nbsp;&nbsp;缓存viewnum:'+varr[0]+'&nbsp;&nbsp;数据库viewnum:'+varr[1]);
			else{
				console.log(varr[0]);
				$('#allviewnumtable').html('<th>id</th><th>viewnum</th>');
				$('#total')[0].innerText = varr[1];
				$.each(varr[0],function(k,v){
					$('#allviewnumtable').append('<tr><td>'+k+'</td><td>'+v+'</td></tr>');
				})
				
			}
		}
	})
}
function getviewnumdb(){
	var url = '/viewnumtest/getallviewnumdb.html';
	$.ajax({
		url : url,
		type : 'post',
		success : function(data){
			var varr = JSON.parse(data);
			
				console.log(varr);
				$('#allviewnumtabledb').html('<th>id</th><th>cw viewnum</th><th>folder viewnum</th>');
				$('#totaldb')[0].innerText = varr[1];
				$.each(varr[0],function(k,v){
					if(parseInt(v.cwviewnum)>parseInt(v.viewnum)){
						$('#allviewnumtabledb').append('<tr class="notenough"><td>'+v.folderid+'</td><td>'+v.cwviewnum+'</td><td>'+v.viewnum+'</td></tr>');
					}else{
					$('#allviewnumtabledb').append('<tr><td>'+v.folderid+'</td><td>'+v.cwviewnum+'</td><td>'+v.viewnum+'</td></tr>');
					}
				})
				
			
		}
	})
}
function updateviewnum(){
	var type = $('#type').val();
	$.ajax({
		url : '/viewnumtest/updateviewnum.html',
		type : 'post',
		data : {'type':type},
		success : function(data){
			var varr = JSON.parse(data);
			alert('执行时间：'+varr[0]+'\n\n有效数据：'+varr[1]);
		}
	});
}
function clearcache(){
	var type = $('#type').val();
	$.ajax({
		url : '/viewnumtest/clearcache.html',
		type : 'post',
		data : {'type':type},
		success : function(data){
			location.reload(true);
		}
	});
}
function setcache(){
	var cwidfrom = $('#cwidfrom').val();
	var cwidto = $('#cwidto').val();
	var viewnum = $('#viewnum').val();
	var type = $('#type').val();
	$.ajax({
		url : '/viewnumtest/setcache.html',
		data : {cwidfrom:cwidfrom,cwidto:cwidto,viewnum:viewnum,type:type},
		type : 'post',
		success : function(data){
			var varr = JSON.parse(data);
			alert('执行时间：'+varr[0]+'\n\n有效数据：'+varr[1]);
		}
	});
}
function setcache2folder(){
	var type = $('#type').val();
	$.ajax({
		url : '/viewnumtest/setcache2folder.html',
		type : 'post',
		data : {type:type},
		success : function(data){
			var varr = JSON.parse(data);
			alert('执行时间：'+varr[0]+'\n\n有效数据：'+varr[1]);
		}
	});
}
function setitemcache(){
	var itemidfrom = $('#itemidfrom').val();
	var itemidto = $('#itemidto').val();
	var viewnumfrom = $('#viewnumfrom').val();
	var viewnumto = $('#viewnumto').val();
	$.ajax({
		url : '/viewnumtest/setitemcache.html',
		data : {itemidfrom:itemidfrom,itemidto:itemidto,viewnumfrom:viewnumfrom,viewnumto:viewnumto},
		type : 'post',
		success : function(data){
			var varr = JSON.parse(data);
			alert('执行时间：'+varr[0]+'\n\n有效数据：'+varr[1]);
		}
	});
}
</script>
</html>