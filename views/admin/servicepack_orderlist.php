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
        <td><h1>服务订单管理 - 服务订单列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="<?php echo geturl('admin/sporder');?>">订单列表</a></td>
			<td><a href="<?php echo geturl('admin/sporder/input');?>">批量开通</a></td>
                <td><a href="<?=geturl('admin/sporder/btachremove')?>">批量删除</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td>
	按订单类型搜索：
	<select id="needtype" name="needtype" onchange="_search()">
		<option value="0">课程</option>
		<option value="1">课件</option>
	</select>
	按支付状态搜索: <select id="status" name="status" onchange="_search()">
		<option value="">不选</option>
		<option value="0">未支付</option>
		<option value="1">已支付</option>
	</select>
        <label>开通方式:</label>
        <span id="">
        <select  name="payfrom" id="payfrom" onchange="_search()">
        <option value="">开通方式</option>
        <option value="1" >年卡开通</option>
        <option value="2" >快钱开通</option>
        <option value="3" >支付宝开通</option>
        <option value="4" >人工开通</option>
        <option value="5" >内部测试</option>
        <option value="6" >农行支付</option>
        <option value="7" >银联支付</option>
        <option value="8" >余额支付</option>
        <option value="9" >微信支付</option>
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
   var payfrom = ['','年卡开通','快钱开通','支付宝','人工开通','内部测试','农行支付','银联支付','余额支付','微信支付','批量删除'];
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
		row.push('<td class="mobile">'+(v.crname||'精品课堂')+'</td>');
        row.push('<td class="nickname">'+(v.totalfee||'')+'</td>');
        row.push('<td class="payfrom" align="center">'+(v.payfrom != 11 ? payfrom[v.payfrom] : '批量删除')+'</td>');
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
        var openmenue = '';
        if(v.payfrom==6||v.payfrom==7){
            openmenue = '&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return  omenue('+v.orderid+')">订单查看</a>]';
        }
        if(v.refunded!=2&&v.status==1&&!v.refund){
            row.push('<td class="op">&nbsp;&nbsp;[<a onclick="showorderview('+v.orderid+')" href="javascript:void(0)">详情</a>]&nbsp;&nbsp;[<a href="#" onclick="return delorder('+v.orderid+')" >删除</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return refund('+v.orderid+',\''+v.ordername+'\',\''+v.username+'\',\''+v.totalfee+'\')" >退款</a>]'+openmenue+'</td>');
        }else{
            row.push('<td class="op">&nbsp;&nbsp;[<a onclick="showorderview('+v.orderid+')" href="javascript:void(0)">详情</a>]'+openmenue+'</td>');
            
        }
        
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
<div class="buttons"><input type="submit" name="listsubmit"
value="提交保存" class="submit"> <input type="reset"
name="listreset" value="重置"></div>
<br>
<!-- ============ -->
<div id="user-window" title="退款窗口">  
    <div>  
        <form id="refund" method="post">  
            <table>
                <input type="hidden" name="orderid" id="orderid" />
                <tr>  
                    <td>买家信息：</td>  
                    <td name="username"></td>  
                </tr>

                <tr>  
                    <td>订单名称：</td>  
                    <td name="ordername"></td>  
                </tr> 

                
                <tr>  
                    <td>已付金额：</td>  
                    <td name="totalfee" ></td>  
                </tr>

                <tr style="">  
                    <td>是否退款：</td>  
                    <td><input type="checkbox" id="real" name='real'  /></td>  
                </tr> 

                <tr>  
                    <td>退款金额：</td>  
                    <td><input name="money" id="money"></input></td>  
                </tr>
            </table>  
        </form>  
    </div>  
    <div style="padding:15px;">  
        <a style="margin-left:90px;" href="javascript:void(0)" onclick="return refundsubmit()" id="btn-save" icon="icon-save">提交</a>  
        <a style="margin-left:40px;" href="javascript:void(0)" onclick="return closerefund()" id="btn-cancel" icon="icon-cancel">取消</a>  
    </div>  
</div>   
<!-- =================== -->
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
		var needtype = $('#needtype').val();
        $.post("/admin/sporder/getListAjax.html",
            {query:query,status:status,payfrom:payfrom,crid:crid,needtype:needtype,pageNumber:pageNumber,pageSize:pageSize},
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


function delorder(orderid){
    if (orderid){
        $.messager.confirm('确认','确定要删除该服务项么？',function(r){
            if (r){
                $.post('/admin/sporder/del.html',{orderid:orderid},function(result){
                    if (result.success){
                        $.messager.show({    
                            timeout:800,
                            title: '成功',
                            msg: '删除成功'
                        });
                    } else {

                        $.messager.show({   
                            title: 'Error',
                            msg: result.msg
                        });
                    }
                },'json');

            }
        });
    }
}
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
    //手动订单数据提交处理
   
}
function showsp(){
	alert();
}

function refundsubmit(){
    if($("#refund").form('validate')){
        var orderid = $("#orderid").val();
        var money = $("#money").val();
        var real = $("#real").prop('checked')?1:0;
        $.post('/admin/ibuy/refund.html',{orderid:orderid,money:money,real:real},function(result){
                    if (result.status==1){
                        alert('退款成功')
                        $.messager.show({    
                            timeout:800,
                            title: '成功',
                            msg: '退款成功'
                        });

                       closerefund();
                        $(".pagination-page-list").trigger('change');
                    } else {
                        alert('退款失败, '+result.msg)
                        $.messager.show({   
                            title: 'Error',
                            msg: result.msg
                        });
                        closerefund();
                         $(".pagination-page-list").trigger('change');
                    }
        },'json');
    }
}

function refund(orderid,ordername,username,totalfee){
    if (orderid){
      udialog(orderid,ordername,username,totalfee);
    }
    return false;
}
$(function(){
     win = $('#user-window').window({  
        closed:true  
    });
});
function udialog(orderid,ordername,username,totalfee){
    check(totalfee);
    $('#btn-save,#btn-cancel').linkbutton();  
    win = $('#user-window').window({
        title:'退款',
        width:500,
        height:280,
        modal:true,
        resizable:false,    
        closed:false,
        collapsible:false,
        minimizable:false,
        maximizable:false  
    });  
    form = win.find('form');
    form.find('td[name=username]').html(username); 
    form.find('td[name=ordername]').html(ordername); 
    form.find('td[name=totalfee]').html(totalfee);
    form.find('input[name=orderid]').val(orderid);
    form.find('#money').val(totalfee);
    form.find('#money').attr('readonly',true);
    form.find('#money').focus();
    totalfee = totalfee; 
};

$.extend($.fn.validatebox.defaults.rules, {
    money: {
        validator: function(value, param){
            return value <= param[0];
        },
        message: '金额不能超过已付金额!'
    }
});
function check(totalfee){
    $('#money').validatebox({    
        required: true,    
        validType: 'money['+totalfee+']',
        missingMessage:'金额不能为空'  
    });  
}
function closerefund(){
    $('#refund').find('#money').val('');
    $('.panel-tool-close').trigger('click');
}

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

    function omenue(orderid){
        var info = new Object();
        info.orderid = orderid;
        $.post('/admin/ibuy/getOrder.html',{orderid:orderid},function(result){
              rendmenue(result);
        });
        return false;
    }
    /**
     *生成订单详情页面
     */
    function rendmenue(info){
         $('#showmenue')
            .html(info)
            .show()
            .dialog({
                title:'订单明细',
                width:500,
                height:300
            })
    }

    function showorderview(orderid){
        var url = '/admin/sporder/'+orderid+'.html';
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