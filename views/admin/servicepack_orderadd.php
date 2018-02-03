<?php
$this->display('admin/header');
?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>服务订单管理 - 添加服务订单</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td ><a href="/admin/sporder.html">浏览</a></td>
            <td  class="active"><a href="/admin/sporder/add.html" class="add">添加服务订单</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form method="post" action="/ibuy/alipay.html" onsubmit="return $(this).form('validate')">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">

<tr>
    <th>所属学校<em>*</em><p>请选择所订服务项。</p></th>
    <td>
	<input type="text" class="w300" readonly="readonly" id="iname" name="iname">
	<input type="button" id="drop" value="选择" />
	<input type="button" id="clear" value="清除" />
	<input type="hidden" name="itemid[]" id="itemid" />
	</td>
</tr>


</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">

</div>
<div id="dialog"></div>  
</body>
<script type="text/javascript">
    $(function(){
        $("#birthdate").trigger('focus');
        $("#username").blur(function(){
            $(this).val($(this).val().replace(/\s+/g,''));
        });
    });
	function changedm(type){
		if(type==0){
			$('#byd_input').attr('disabled',true);
			$('#bym_input').attr('disabled',false);
			$('#byd_input').val('');
		}else if(type==1){
			$('#byd_input').attr('disabled',false);
			$('#bym_input').attr('disabled',true);
			$('#bym_input').val('');
		}
	}
	$('#drop').click(function(){
		$('#dialog').dialog({    
	    title: '选择服务项',    
	    width:Math.ceil($(document).width()/2),
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/spitem/servicepack_itemsearch.html',    
	    modal: true   
		});
		$("#ck").trigger('click');    
	});
	$('#clear').click(function(){
		$('#mediaid').val("");
		$('#crname').val("");
	});
</script>
<?php
$this->display('admin/footer');
?>