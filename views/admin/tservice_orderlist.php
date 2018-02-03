<?php
$this->display('admin/header');
?>
<style>
    #user-window{
        width: 480px;
        height: 300px;
    }
    #refund {
        width: 380px;
        padding-left: 100px;
        margin-top: 20px;
    }
    #refund tr{
        height: 30px;
    }
</style>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>教师服务项管理 - 服务订单列表</h1></td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td>
	按支付状态搜索: <select id="status" name="status" onchange="_search()">
		<option value="">不选</option>
		<option value="0">未支付</option>
		<option value="1">已支付</option>
	</select>
        <label>开通方式:</label>
        <span id="">
        <select  name="payfrom" id="payfrom" onchange="_search()">
        <option value="">开通方式</option>
        <option value="1" >支付宝开通</option>
        <option value="2" >微信支付开通</option>
        <option value="3" >农行直通车开通</option>
        <option value="4" >中国银联开通</option>
        </select>
        </span>
		
        <label for="catid">所属学校</label>
        <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
        <input type="button" id="drop" value="选择" />
        <input type="button" id="clear" value="清除" />
        <input type="hidden" name="crid" id="mediaid"  value="0" />
      <label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
	</td>

</tr>
</table>
</form>
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>

<div id="showmenue" style="display:none">
    <table>
        <tr>
            <td>1</td><td>111111111</td>
        </tr> 
        <tr>
            <td>2</td><td>222222222</td>
        </tr>

    </table>
</div>
<script type="text/javascript">
	var payfrom = ['','支付宝','微信支付','农行直通车','中国银联'];
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }
    function _renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.orderid+'" /></td>');
        row.push('<td class=username><span style=\'color:red\'>'+v.ordername+'</span></td>');
        row.push('<td class="realname">'+(v.username||'')+'</td>');
        row.push('<td class="realname">'+(v.realname||'')+'</td>');
		row.push('<td class="mobile">'+(v.crname||'')+'</td>');
        row.push('<td class="nickname">'+(v.totalfee||'')+'</td>');
        row.push('<td class="payfrom" align="center">'+payfrom[v.payfrom]+'</td>');
        row.push('<td class="nickname" align="center">'+(v.sourceid>0?'退款账单':'购买订单')+'</td>');
        if(v.sourceid>0){
            var status = (v.status==0)?'退款失败':'退款成功';
        }else{
            var status = (v.status==0)?'未支付':'已支付';
            
            if((v.refunded==2)){
                status+='(已退款)';
            }else if(v.refunded==1){
                status+='(等待退款)';
            }
        }
        row.push('<td class="" align="center">'+status+'</td>');
		row.push('<td class="" align="center">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="op">&nbsp;&nbsp;[<a onclick="showorderview('+v.orderid+')" href="javascript:void(0)">详情</a>]</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="10%" >订单名称</th>
<th width="10%" >用户名</th>
<th width="10%" >真实姓名</th>
<th width="12%" >所属学校</th>
<th width="10%" >总金额</th>
<th >付款方式</th>
<th >订单类型</th>
<th >状态</th>
<th >下单日期</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
</tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
<th width="12%">批量操作</th>
<th><input type="checkbox" name="chkall" id="chkall" >
<label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label
for="noop">不操作</label></th>
</tr>
<tr id="divnoop" style="display: none">
<td></td>
<td></td>
</tr>
</table>
<div id="pp"></div>
</body>
<script type="text/javascript">
var quee = 1;
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
        var curquee = ++quee;
        var query = $('#searchkey').val();
		var status = $('#status').val();
        var payfrom = $('#payfrom').val();
        var crid = $('#mediaid').val();
        $.post("/admin/torder/getListAjax.html",
            {query:query,status:status,payfrom:payfrom,crid:crid,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                if(curquee!=quee){
                    return;
                }
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

function manualopen(uid,username){
	$("#uid").val(uid);
    $('#dd').dialog({    
        title: '选择用户',
        width:Math.ceil($(document).width())-100,
        height:Math.ceil($(document).height()-100),    
        closed: false,    
        cache: false,    
        href: '/admin/classroom/lite.html?uid='+uid+'&username='+username,
        modal: true,
        shadow:true   
    });
    $('#ssearch').trigger('click');
    return false;
}
function showsp(){
	alert();
}
$(function(){
     win = $('#user-window').window({  
        closed:true  
    });
});
function showcr(){
        var url = '/admin/classroom/roomselect.html';
        var width = $(window).width();
        var height = $(window).height();
        $('#cr')
        .attr('width',width/5*3)
        .attr('height',height/5*3)
        .attr('src',url);
        $('#crwrap').show();
        $('#crwrap').dialog({    
            title: '请选择教室', 
            closed: false,    
            cache: false,   
            modal: true   
        });
        // $('#win').window('refresh', );  
        return false;
    }
    $('#drop').click(function(){
       showcr();  
    });
    $('#clear').click(function(){
        $('#mediaid').val("");
        $('#crname').val("");
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
    }
    //查看订单详情
    function showorderview(orderid){
        var url = '/admin/torder/'+orderid+'.html';
        $("#orderinfo").attr('src',url);
        H.create(new P({
            id:'orderview',
            title:'订单明细',
            content:$("#orderwrap")[0],
            easy:true,
            padding:20
        })).exec('show');
    }
    function rmorderview(){
        H.remove('orderview');
    }
</script>
<script src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<div id="orderwrap">
<iframe id="orderinfo" width=720px height=460px src="" frameborder="0"></iframe>
</div>
<?php
$this->display('admin/footer');
?>