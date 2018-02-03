<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">代理商管理 -  批量生成代理商</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/agent.html">浏览代理商</a></td>
            <td ><a href="/admin/agent/add.html" class="add">添加代理商</a></td>
            <td ><a href="/admin/agent/batchadd.html" class="add">批量生成代理商</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/agent/_batchadd.html" onsubmit="return $(this).form('validate')" >
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tbody>
<tr>
	<th>生成模式<em>*</em><p>分两张模式：一种是只要生成一个代理商，另一种为可批量生成多个代理商</p></th>
	<td><input name="addtype" type="radio" value="oneadd" checked="checked" id="oneadd" />
		<label for="oneadd">单条添加</label>&nbsp;&nbsp;
		<input name="addtype" type="radio" value="manyadd" id="manyadd" />
		<label for="manyadd">批量添加</label>
	</td>
</tr>
<tr>
	<th>生成数量<em>*</em><p>生成代理商的数量</p></th>
	<td>
		<input type="text" name="num" id="num" onblur="$(this).val($.trim($(this).val()))" value="1" readonly="readonly" >
	</td>
</tr>
<tr><th>上级代理商<p></p></th><td>
<div><input disabled="disabled" value="" id="username">
	<input type="button" id="drop" value="选择" /></div>
<input type="hidden" name="upid" id="mediaid"  value="" /></td>
</tr>
</tbody>
</table>
<div id="dd"></div>
<div class="buttons">
<input type="submit" name="batchsubmit" value="提交保存" class="submit">
<input type="reset"	 name="batchreset" value="重置">
</div>
<script type="text/javascript">
$.extend($.fn.validatebox.defaults.rules, {    
    num: {    
        validator: function(value,param){ 
            return  /^[1-9]+[0-9]*$/.test(value);    
        },    
        message: '生成数量必须为正整数!'   
    }   
}); 
	$(function(){
	$("#drop").click(function(){
		$('#dd').dialog({    
		    title: '选择用户',
		    width:Math.ceil($(document).width()/2),
		    height:Math.ceil($(document).height()/2)+100,    
		    closed: false,    
		    cache: false,    
		    href: '/admin/agent/lite.html',
		    modal: true,
		    shadow:true   
		}); 
	});
});
$('#manyadd,#oneadd').click(function(){
	if($('#manyadd').prop('checked')){
		$('#num').removeAttr('readonly');
	}else{
		$('#num').attr('readonly','readonly');
		$('#num').val(1);
	}
});
$(function(){
	$('#num').validatebox({    
	    required: true,
	    validType:'num',
	    missingMessage:'生成数目不能为空'  
	});  
});
$('#')
</script>
</body>
<?php $this->display('admin/footer');?>