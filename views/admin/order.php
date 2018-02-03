<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<style type="text/css">
.ftitle{
    font-size:14px;
    font-weight:bold;
    padding:5px 0;
    margin-bottom:10px;
    border-bottom:1px solid #ccc;
}
.fitem{
    margin-bottom:5px;
}
.fitem label{
    display:inline-block;
    width:80px;
    vertical-align:top;
	font-size:13px;
}
.fitem_input{width:400px;}
</style>
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>积分订单 - 订单列表</h1></td>
        <td class="actions">
        </td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">

</table>
</form>
<script type="text/javascript">
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }
    function _renderRow(k,v){
    	var status_text = '';
    	if (v.type == 1){
    		if (v.status == 1)
    			status_text = '兑换成功';
    	}
    	else{
    		if (v.status == 1)
    			status_text = '未发放';
    		else if(v.status == 2)
    			status_text = '已发放';
    		else if(v.status == 2)
    			status_text = '已完成';
    	}
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td><span style=\'color:red\'>'+v.username+'</span></td>');
        row.push('<td>&nbsp;'+v.crname+'</td>');
        row.push('<td><span>'+v.realname+'</span></td>');
        row.push('<td>'+getformatdate(v.dateline)+'</td>');
        row.push('<td>'+v.productname+'</td>');
		row.push('<td class="op">'+v.credit+'</td>');
		row.push('<td class="op">'+status_text+'</td>');
        row.push('<td class="op">&nbsp;&nbsp;');
        if (v.type != 1)
        	row.push('[<a href="javascript:void(0)" onclick="setstatus('+v.oid+','+v.status+',\''+v.expressname+'\',\''+v.expressNo+'\',\''+v.remark+'\')">设置状态</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showorder(\''+v.name+'\',\''+v.address+'\',\''+v.postcode+'\',\''+v.phone+'\')">查看</a>]');
        row.push('</td>');
        
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th width="10%" >账号</th>
<th width="15%" >平台</th>
<th width="10%" >姓名</th>
<th width="15%" >时间</th>
<th width="15%" >产品名称</th>
<th >所需积分</th>
<th >状态</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
</tbody>
</table>

<div id="pp"></div>
<br>

<div id="dlg-status" class="easyui-dialog" style="width:580px;height:330px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
    <div class="ftitle">发放状态</div>
    <form id="form_status" method="post">
		<div class="fitem">
            <label>状态：</label>
			<label><input type="radio" value="1" name="status" />未发放</label>
			<label><input type="radio" value="2" name="status" />已发放</label>
			<input type="hidden" name="oid" id="oid"/>
        </div>
		<div class="fitem">
            <label>快递公司：</label>
            <input type="text" name="expressname" id="expressname" class="fitem_input"/>
        </div>
        <div class="fitem">
            <label>快递单号：</label>
            <input type="text" name="expressNo" id="expressNo" class="fitem_input" />
        </div>
		<div class="fitem">
            <label>备注：</label>
			<textarea name="remark" id="remark" style="width:400px; height:90px;"></textarea>
        </div>
    </form>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="savestatus()" id="savebtn">保存</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-status').dialog('close')">取消</a>
</div>

<div id="dlg-order" class="easyui-dialog" style="width:580px;height:330px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons2">
    <div class="ftitle">收件人信息</div>
    <form id="form_order" method="post">
		<div class="fitem">
            <label>收件人：</label>
            <input name="name" readonly="readonly" class="fitem_input" />
        </div>
        <div class="fitem">
            <label>收货地址：</label>
            <input name="address" readonly="readonly" class="fitem_input" />
        </div>
        <div class="fitem">
            <label>邮政编码：</label>
            <input name="postcode" readonly="readonly" class="fitem_input" />
        </div>
        <div class="fitem">
            <label>电话：</label>
            <input name="phone" readonly="readonly" class="fitem_input" />
        </div>
        
    </form>
</div>
<div id="dlg-buttons2">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg-order').dialog('close')">关闭</a>
</div>
</body>
<script type="text/javascript">
$(function(){
    $(".pagination-page-list").trigger('change');
});
function _search(){
	$('#pp').pagination({pageNumber:1});
	$(".pagination-page-list").trigger('change');
	return false;
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        
        $.post("/admin/order/getListAjax.html",
            {pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
        return false;
    }
});
$("#chkall").click(function(){
    $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});
function setstatus(oid,ostatus,expressname,expressNo,remark) {
	$('#savebtn').attr("disabled",false);
	$("#oid").val(oid);
	$('input[name="status"]').eq(ostatus-1).prop("checked",true);
	$('#form_status').form('load',{expressname:expressname,expressNo:expressNo});
	$("#remark").val(remark);
	$('#dlg-status').dialog('open').dialog('setTitle','设置状态');
	$("#dlg-status").dialog("move",{top:$(document).scrollTop() + ($(window).height()-330) * 0.5});
}
function savestatus() {
	var oid = $("#oid").val();
	var status = $("input[name='status']:checked").val();
	var expressname = $("#expressname").val();
	var expressNo = $("#expressNo").val();
	var remark = $("#remark").val();
	$('#savebtn').attr("disabled",true);
	$.ajax({
		url:'/admin/order/setstatus.html',
		type:'post',
		data:{oid:oid,status:status,expressname:expressname,expressNo:expressNo,remark:remark},
		success:function(result){
			$('#dlg-status').dialog('close');
			if (result==1){
				$(".pagination-page-list").trigger('change');
				$.messager.show({
                    timeout:1000,
                    title: '成功',
                    msg: '设置成功'
                });
            } else {
				$.messager.show({
                    title: '错误',
                    msg: '设置失败'
                });
            }
		}
	});
}
function showorder(name,address,postcode,phone) {
	$('#form_order').form('load',{name:name,address:address,postcode:postcode,phone:phone});
	$('#dlg-order').dialog('open').dialog('setTitle','查看订单');
	$("#dlg-order").dialog("move",{top:$(document).scrollTop() + ($(window).height()-330) * 0.5});
}
</script>
<?php
$this->display('admin/footer');
?>