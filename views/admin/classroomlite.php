<?php
$this->display('admin/header');
?>
<body>
    <div id="tname" style="text-align:center"><p style="font-size:20px;font-weight:bold;">人工开通平台</p></div>

<div>
    &nbsp;&nbsp;登录名:&nbsp;&nbsp;<span style="font-weight:bolder;color:red;font-size:18px;"><?=$userinfo['username']?></span>&nbsp;&nbsp;真实姓名:&nbsp;&nbsp;<span style="font-weight:bolder;color:red;font-size:18px;"><?=$userinfo['realname']?></span>&nbsp;&nbsp;性别 : <span style="font-size:16px;color:red;font-weight:bolder;"><?=$userinfo['sex']==1?'女':'男'?></span>&nbsp;&nbsp;支付合计: <span style="font-size:16px;color:red;font-weight:bolder;" id='totalmoney'>0.00</span><br /><br />
       <hr style="width:98%;"></hr><br />
       <input type="hidden" name='uid' id="uid" value="<?=$userinfo['uid']?>" />
    <div style="height:150px;overflow-y:scroll">
        <form class="manopen" tag=0>
        
        </form>
    </div>
</div>
<br />&nbsp;&nbsp;<a class="easyui-linkbutton"  onclick="return submitAll()">批量提交</a>&nbsp;&nbsp;<a class="easyui-linkbutton"  onclick="return resetAll()">批量取消</a>
<br /><br />
<!-- <hr style="width:98%;"></hr><br /> -->
<form id="ckk">
    <input type="hidden" name="notfree" value=1 />
        &nbsp;&nbsp;<span style="font-weight:bolder;font-family:'楷体';color:red;font-size:16px;">请先搜索需要开通的网校</span>&nbsp;&nbsp;
        <span id="toolbar">
            <input style="width:200px;" id="search-input" type="text" name="q" onkeypress="presstosearch(event);"/>
            <a href="javascript:void(0)" id="ssearch" class="easyui-linkbutton" iconCls="icon-search" onclick="return __search()" >搜索</a>
        </span>
    </form>
    <br />
<script type="text/javascript">
    function __render(_data){
        $(".classlite").html('');
        $.each($(_data),function(k,v){
            $(__renderRow(k,v)).appendTo(".classlite");
        });
    }

    function __renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        row.push('<td><input name="crids" tag='+v.crid+' onclick="renderForm('+v.crid+',\''+v.crname+'\',\''+v.crprice+'\')" type="checkbox" value="" /></td>');
        row.push('<td class="crname">'+v.crname+'</td>');
        row.push('<td class="nickname">'+v.username+'</td>');
        row.push('<td class="domain">'+v.domain+'</td>');
        row.push('<td class="agentname">'+(v.crprice||'')+'</td>');
        row.push('<td class="begindate">'+getformatdate(v.begindate).substr(0,10)+'</td>');
        row.push('<td class="enddate">'+getformatdate(v.enddate).substr(0,10)+'</td>');
        // if(v.status==1){
        // 	row.push('<td class="status">正常</td>');
        // }else{
        // 	row.push('<td class="status">锁定</td>');
        // }

        
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>选择</th>
<th fieldname="i.crname">网校名</th>
<th fieldname="i.nickname">教师名</th>
<th fieldname="i.domain">域名</th>
<th filedname="i.agentname">年费</th>
<th fieldname="i.begindate" width="10%">开始时间</th>
<th fieldname="i.enddate" width="10%">结束时间</th>
<!-- <th fieldname="i.status" width="5%">状态</th> -->
</tr>
<tbody class="classlite">

</tbody>
</table>

<div id="ppp"></div>

<script type="text/javascript">
$(function(){
    init();
});
$(function(){
    $("#newslisttab a").click(function(){
        $('#status').val($(this).attr('status'));
        $("#newslisttab li").prop('class','');
        $(this).parent('li').prop('class','active');
        $(".pagination-page-list").trigger('change');
        return false;
    });

});
function __search(){
   $('#ppp').pagination({pageNumber:1});
   $(".pagination-page-list").trigger('change');
   return false;
}
$('#ppp').pagination({
    pageSize:5,
    pageList:[5],
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#ckk').serialize();
        $.post("/admin/classroom/getListAjax.html",
            {query:query,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#ppp').pagination('refresh',message.shift());
                 __render(message);
                 // $("input[tag="+crid+"]").prop('checked')
                 $("form.manopen").each(function(index,obj){
                    $("input[tag="+$(obj).attr('tag')+"]").prop('checked','checked')
                 });
                
            }
            );
        return false;
    }
});

function init(){
   $('#ppp').pagination({
    pageSize:5,
    pageList:[5],
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#ckk').serialize();
        $.post("/admin/classroom/getListAjax.html",
            {query:query,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#ppp').pagination('refresh',message.shift());
                 __render(message);

                
            }
            );
        return false;
    }
}); 
    $(".pagination-page-list").trigger('change');
}

		
function dosearch(){
	$.get('<?php echo geturl('admin/classroom/getlist');?>',{'param[q]':$("#search-input").val(),'param[notfree]':1},function(data){
		var data = eval(data);
		data.pop();
		__render(data);
	}
	);
}

function getcrid(crid,crname){
    $("#crname").val(crname);
    $("#crid").val(crid);
}

function check(uid,crid,money,month,crname){
    var errorInfo = new Array();
    var uidstatus = $.isNumeric(uid)&&(uid>0);
    var cridtatus = $.isNumeric(crid)&&(crid>0);
    var moneystatus = $.isNumeric(money)&&(money>=0);
    var monthstatus = $.isNumeric(month)&&(month>0);
    if(!uidstatus){
        errorInfo.push('网校:'+crname+'用户选择有误!');
    }
   
    if(!moneystatus){
        errorInfo.push('网校:'+crname+'支付金额填写有误!');
    }
    if(money>10000000){
       errorInfo.push('网校:'+crname+'支付金额单次不能超过10000000!');
       moneystatus=false;
    }
    if(!monthstatus){
        errorInfo.push('网校:'+crname+'开通时长填写有误!');
    }
    if(!cridtatus){
        errorInfo.push('网校:'+crname+'网校选择有误!');
    }
    if(uidstatus&&cridtatus&&monthstatus&&moneystatus){
        return 1;
    }else{
        return errorInfo.join("\r\n");
    }
   
}
function manopensubmit(uid,crid,money,month,crname,type){

    //字段校验判断。。。。。。
    var status = check(uid,crid,money,month,crname);
    if(status!=1){
        alert(status);
        return false;
    }
    $.post('/admin/classactive/manualnotify.html',
            {uid:uid,month:month,crid:crid,money:money,type:type},
            function(d){
                if(d==1){
                    changeStatus(crid,"开通成功");
                }else{
                    changeStatus(crid,"开通失败");
                }
            }
        );
    // $('.panel-tool-close').trigger('click');
    return false;
}

function changeStatus(crid,info){
   var context = $("form[tag="+crid+"]");
   $("a.tj",context).attr("onclick","success()").html(info);
   $("a.tj",context).attr("status","1");
   $("a.qx",context).remove();
   $("input[tag="+crid+"]").prop('checked',false);
}
function success(){
    alert('操作已成功!请勿重复提交!');
    return false;
}
function renderForm(crid,crname,crprice){
   if($("input[tag="+crid+"]").prop('checked')){
        $("form[tag="+crid+"]").remove();
        addForm(crid,crname,crprice);
        getTotalMoney();
    }else{
        $("form[tag="+crid+"]").remove();
        getTotalMoney();
    }
     
}


function addForm(crid,crname,crprice){
    var formdata = '<form class="manopen" tag='+crid+'>';
       formdata+='<input type="hidden" name="crid" value="'+crid+'"/>';
       formdata+='<input type="hidden" value="'+crprice+'"/>';
       formdata+='&nbsp;&nbsp;开通网校:&nbsp;&nbsp;<input type="text" value="'+crname+'" style="width:200px;"  name="crname"  disabled=disabled />';
       formdata+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年费 : <span style="display:inline-block;width:40px;">'+crprice+'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;开通时长:&nbsp;&nbsp;<select onchange="getMoney(this,\''+crprice+'\')" name="month">';
       // formdata+='<span>年费:'+crprice+'</span>';
       formdata+='<option value=0>请选择</option>';
       formdata+='<?php for ($i=1; $i <= 12; $i++) {?>';
       formdata+='<option value="<?=$i?>"><?=$i?>个月</option>';
       formdata+='<? }php?>';
       formdata+='</select>';
       formdata+='&nbsp;&nbsp;&nbsp;支付金额:&nbsp;&nbsp;<input onchange="getTotalMoney();" style="width:60px;" type="text" name="money" >&nbsp;&nbsp;元';
       formdata+='<input type="hidden" name="remoney" >';
       formdata+='&nbsp;&nbsp;<a class="tj" style="cursor:pointer"   onclick="return submitForm(this)">提交</a>';
       formdata+='&nbsp;&nbsp;<a class="qx" style="cursor:pointer"   onclick="return delForm('+crid+')">取消</a>';
       formdata+='&nbsp;&nbsp;测试:<input type="checkbox" class="cs" style="cursor:pointer"   onclick="cstest(this,0)" />';
       formdata+='<input type="hidden" name="type" value="4">';
       formdata+='</form>';
       var formcname = 'manopen_'+crid;
       $("form.manopen:last").after(formdata);
}

function delForm(crid){
    $("form[tag="+crid+"]").remove();
    $("input[tag="+crid+"]").prop('checked',false);
    getTotalMoney();
}


function getMoney(e,crprice){
    var totalprice = $(e).val()*crprice/12;
    if(!crprice){
       $(e).siblings('input[name$=money]').val('0.00');
    }else{
       $(e).siblings('input[name$=money]').val(totalprice.toFixed(2));
    }
    getTotalMoney();
}

function cstest(e,crprice){
    var totalprice = $(e).val()*crprice/12;
    if($(e).prop('checked')){
      if(!crprice){
         $(e).siblings('input[name=money]').val('0.00');
         $(e).siblings('input[name=type]').val(5);
      }else{
         $(e).siblings('input[name=money]').val(totalprice.toFixed(2));
         $(e).siblings('input[name=type]').val(5);
      }
    }else{
        if(!crprice){
         $(e).siblings('input[name=money]').val($(e).siblings('input[name=remoney]').val());
         $(e).siblings('input[name=type]').val(4);
      }else{
         $(e).siblings('input[name=money]').val($(e).siblings('input[name=remoney]').val());
         $(e).siblings('input[name=type]').val(4);
      }
    }
    
    getTotalMoney();
}

function submitForm(e){
   var context = $(e).parent('form');
   var crname = $('input[name=crname]',context).val();
   var crid = $('input[name=crid]',context).val();
   var money = $('input[name=money]',context).val();
   var remoney = $('input[name=remoney]',context).val();
   var month = $('select[name=month]',context).val();
   var type = $('input[name=type]',context).val();
   var uid = $('#uid').val();
   var status = check(uid,crid,money,month,crname);
    if(status!=1){
        alert(status);
        return false;
   }
   if(((money*100 - remoney*100)!=0)&&(type==4)){
    // '网校: '+crname+' 开通金额与所交金额不符,应该为 : '+remoney+'元'
    $.messager.confirm('提示信息','网校:<span style="color:red;font-weight:bolder"> '+crname+' </span><br />开通金额与所交金额不符<br />填写金额为:<strong style="color:red;">'+money+'元</strong><br /><span style="margin-left:42px;">应该为</span> : <span style="color:red;font-weight:bolder">'+remoney+'元</span><br /><span style="margin-left:42px;">您确定要提交吗？</span>',function(r){
        if(r){
           manopensubmit(uid,crid,money,month,crname,type);
        }else{
           return false;
        }
    });
   }else{
     manopensubmit(uid,crid,money,month,crname,type);
   }
   
   return false;
}

function submitAll(){
    $("a.tj[status!=1]").trigger('click');
}

function resetAll(){
     $("form.manopen[tag!=0]").remove();
     $(":checkbox").prop('checked',false);
     getTotalMoney();
     return false;
}

function getTotalMoney(){
  var moneyinput = $("form.manopen[tag!=0] input[name=money]");
  var totalmoney = 0;
  moneyinput.each(function(index,obj){
    totalmoney+=$(obj).val()*100;
  });
  $("#totalmoney").text((totalmoney/100).toFixed(2));
}

function cs(crid){
  getMoney(this,crid,0);
}
</script>
    
</body>
<?php
$this->display('admin/footer');
?>