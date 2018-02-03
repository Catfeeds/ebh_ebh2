<?php $this->display('admin/header');?>
<div>
    &nbsp;&nbsp;登录名:&nbsp;&nbsp;<span style="font-weight:bolder;color:red;font-size:18px;"><?=$userinfo['username']?></span>&nbsp;&nbsp;真实姓名:&nbsp;&nbsp;<span style="font-weight:bolder;color:red;font-size:18px;"><?=$userinfo['realname']?></span>&nbsp;&nbsp;性别 : <span style="font-size:16px;color:red;font-weight:bolder;"><?=$userinfo['sex']==1?'女':'男'?></span>&nbsp;&nbsp;支付合计: <span style="font-size:16px;color:red;font-weight:bolder;" id='totalmoney'>0.00</span><br /><br />
       <hr style="width:100%;"></hr><br />
       <input type="hidden" name='uid' id="uid" value="<?=$userinfo['uid']?>" />
    <div style="height:150px;overflow-y:scroll">
        <form class="manopen" tag=0>
        
        </form>
    </div>
</div>
<br />&nbsp;&nbsp;<a  class="easyui-linkbutton"  onclick="return getSubmitInfo()">批量提交</a>&nbsp;&nbsp;<a class="easyui-linkbutton"  onclick="return resetAll()">批量取消</a>

<form id="ck">
    <table cellspacing="0" cellpadding="0" class="toptable"><tr>
     <td  width=500px;>
                 <label for="catid">所属学校</label>
                <input type="text" class="w300" readonly="readonly" value="<?=$crname?>" id="crname" name="crname">
                <input type="button" id="drop" value="选择" />
                <input type="button" id="clear" value="清除" />
                <input type="hidden" name="crid" id="mediaid"  value="<?=$crid?>" />
    </td>
    <td>
    <label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
    <input type="button" onclick="return _search()" value="搜索"/>
    </td></tr>
    </table>
</form>
<script type="text/javascript">
    var payfrom = ['','年卡开通','快钱开通','支付宝','人工开通','内部测试开通','农行支付开通','银联支付开通','余额支付开通','微信支付开通'];
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr style="cursor:pointer"  itemid='+v.itemid+' iname="'+v.iname+'" >'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input tag='+v.itemid+' type="checkbox" name="ckbox[]" value="'+v.itemid+'" onclick="renderForm('+v.itemid+',\''+v.iname+'\',\''+v.iprice+'\',\''+v.folderid+'\',\''+v.crid+'\',\''+v.imonth+'\',\''+v.iday+'\')" /></td>');
        if(v.hasbuy==1){
           row.push('<td><span style="color:#ff0000;font-weight:bolder;">'+v.iname+' </span> ( '+v.paytime+' '+(payfrom[v.payfrom]||'未知方式开通')+' )</td>');
        }else{
          row.push('<td>'+v.iname+'</td>');
        }
        if(v.sname){
          row.push('<td>'+v.pname+' <span style="color:#ff0000;font-weight:bolder;">[ '+v.sname+' ]</span>'+'</td>');
        }else{
          row.push('<td>'+v.pname+'</td>');
        }
        row.push('<td>'+v.crname+'</td>');
        row.push('<td class="nickname">'+(v.iprice||'')+'</td>');
        row.push('<td class="i.dateline">'+((v.imonth>0)?v.imonth+'月':v.iday+'天')+'</td>');
        row.push('<td>'+getformatdate(v.dateline)+'</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>


<div style="margin-left:auto;margin-right:auto;width:100%">
<table align="center" border="1" cellspacing="0" cellpadding="0" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<td>服务项名称</td>
<td>所属服务包 [ 分类 ] </td>
<td>所属平台</td>
<td>价格</td>
<td>持续时间</td>
<td>添加时间</td>
</tr>
<tbody class='moduletbody'>
</tbody>
</table>
<div id="pp"></div>
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
<script type="text/javascript">
var hasSubmitAll = false;
$(function(){
  _search();
    return false;
});
function _search(){
   $('#pp').pagination({pageNumber:1});
   $(".pagination-page-list").trigger('change');
   return false;
}
$('#pp').pagination({
    pageSize:50,
    pageList:[50],
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#searchkey').val();
        var crid = $('#mediaid').val();
        $.post("/admin/spitem/getListAjax.html",
            {query:query,crid:crid,pageNumber:pageNumber,pageSize:pageSize,uid:<?=$userinfo['uid']?>,hasbuy:1},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
        return false;
    }
});

function renderForm(itemid,iname,iprice,folderid,crid,imonth,iday){
   if($("input[tag="+itemid+"]").prop('checked')){
        $("form[tag="+itemid+"]").remove();
        addForm(itemid,iname,iprice,folderid,crid,imonth,iday);
        getTotalMoney();
    }else{
        $("form[tag="+itemid+"]").remove();
        getTotalMoney();
    }
     
}
function addForm(itemid,iname,iprice,folderid,crid,imonth,iday){
    var formdata = '<form class="manopen" tag='+itemid+'>';
       formdata+='<input type="hidden" name="itemid" value="'+itemid+'"/>';
       formdata+='<input type="hidden" name="crid" value="'+crid+'"/>';
       formdata+='<input type="hidden" name="folderid" value="'+folderid+'"/>';
       formdata+='<input type="hidden" name="iprice" value="'+iprice+'"/>';
       formdata+='<input type="hidden" name="imonth" value="'+imonth+'"/>';
       formdata+='<input type="hidden" name="iday" value="'+iday+'"/>';
       formdata+='&nbsp;&nbsp;开通服务:&nbsp;&nbsp;<input type="text" value="'+iname+'" style="width:200px;"  name="iname"  disabled=disabled />';
       formdata+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;费用 : <span style="display:inline-block;width:40px;">'+iprice+'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select style="display:none" onchange="getMoney(this,\''+iprice+'\')" name="month">';
       formdata+='<option value="1" select=select>1个</option>';
       formdata+='</select>';
       formdata+='&nbsp;&nbsp;&nbsp;支付金额:&nbsp;&nbsp;<input onchange="getTotalMoney();" style="width:60px;" type="text" name="money" >&nbsp;&nbsp;元';
       formdata+='<input type="hidden" name="remoney" >';
       formdata+='&nbsp;&nbsp;<a class="tj" style="cursor:pointer"   onclick="return submitForm(this)">提交</a>';
       formdata+='&nbsp;&nbsp;<a class="qx" style="cursor:pointer"   onclick="return delForm('+itemid+')">取消</a>';
       formdata+='&nbsp;&nbsp;测试:<input type="checkbox" class="cs" style="cursor:pointer"   onclick="cstest(this,0)" />';
       formdata+='<input type="hidden" name="type" value="4">';
       formdata+='</form>';
       var formcname = 'manopen_'+itemid;
       $("form.manopen:last").after(formdata);
       $monthObj = $("form.manopen[tag='"+itemid+"'] select[name=month]");
       getMoney($monthObj,iprice);

}

function delForm(itemid){
    $("form[tag="+itemid+"]").remove();
    $("input[tag="+itemid+"]").prop('checked',false);
    getTotalMoney();
}

function getTotalMoney(){
  var moneyinput = $("form.manopen[tag!=0] input[name=money]");
  var totalmoney = 0;
  moneyinput.each(function(index,obj){
    totalmoney+=$(obj).val()*100;
  });
  $("#totalmoney").text((totalmoney/100).toFixed(2));
}

function getMoney(e,crprice){
    var totalprice = $(e).val()*crprice;
    if(!crprice){
       $(e).siblings('input[name$=money]').val('0.00');
    }else{
       $(e).siblings('input[name$=money]').val(totalprice.toFixed(2));
    }
    getTotalMoney();
}

function cstest(e,crprice){
    var totalprice = $(e).val()*crprice;
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
   var iname = $('input[name=iname]',context).val();
   var itemid = $('input[name=itemid]',context).val();
   var crid = $('input[name=crid]',context).val();
   var money = $('input[name=money]',context).val();
   var remoney = $('input[name=remoney]',context).val();
   var month = $('select[name=month]',context).val();
   var type = $('input[name=type]',context).val();
   var uid = $('#uid').val();
   var folderid = $('input[name=folderid]',context).val();
   var imonth = $('input[name=imonth]',context).val()*month;
   var iday = $('input[name=iday]',context).val()*month;
   var status = check(uid,itemid,money,month,iname);
    if(status!=1){
        alert(status);
        return false;
   }
   if(((money*100 - remoney*100)!=0)&&(type==4)){
    // '服务: '+iname+' 开通金额与所交金额不符,应该为 : '+remoney+'元'
    $.messager.confirm('提示信息','服务:<span style="color:red;font-weight:bolder"> '+iname+' </span><br />开通金额与所交金额不符<br />填写金额为:<strong style="color:red;">'+money+'元</strong><br /><span style="margin-left:42px;">应该为</span> : <span style="color:red;font-weight:bolder">'+remoney+'元</span><br /><span style="margin-left:42px;">您确定要提交吗？</span>',function(r){
        if(r){
           manopensubmit(uid,itemid,money,month,iname,type,folderid,crid,imonth,iday);
        }else{
           return false;
        }
    });
   }else{
     manopensubmit(uid,itemid,money,month,iname,type,folderid,crid,imonth,iday);
   }
   
   return false;
}

function getSubmitInfo(){
  if(hasSubmitAll==true){
    return success();
  }
  $forms = $("form.manopen[tag!=0]");
  var dataStroage = new Array();
  var res = null;
  $.each($forms,function(i,n){
    if((res=getSubmitFormInfo(n))!=false){
      dataStroage.push(res);
    }
  });
  $.post('/admin/ibuy/manualnotify_all.html',{dataStroage:dataStroage},function(res){
    eval('res='+res);
    $.each(res,function(i,n){
      if(n>0){
        changeStatus(i,'开通成功');
        _search();
      }else{
        changeStatus(i,'开通失败');
        _search();
      }
    });
  });
  hasSubmitAll = true;
}

//获取表单信息
function getSubmitFormInfo(e){
   var dataStroage = new Object();
   var context = $(e);
   var iname = $('input[name=iname]',context).val();
   var itemid = $('input[name=itemid]',context).val();
   var crid = $('input[name=crid]',context).val();
   var money = $('input[name=money]',context).val();
   var remoney = $('input[name=remoney]',context).val();
   var month = $('select[name=month]',context).val();
   var type = $('input[name=type]',context).val();
   var uid = $('#uid').val();
   var folderid = $('input[name=folderid]',context).val();
   var imonth = $('input[name=imonth]',context).val()*month;
   var iday = $('input[name=iday]',context).val()*month;
   var status = check(uid,itemid,money,month,iname);
    if(status!=1){
        alert(status);
        return false;
   }
   // if(((money*100 - remoney*100)!=0)&&(type==4)){
   //  // '服务: '+iname+' 开通金额与所交金额不符,应该为 : '+remoney+'元'
   //  $.messager.confirm('提示信息','服务:<span style="color:red;font-weight:bolder"> '+iname+' </span><br />开通金额与所交金额不符<br />填写金额为:<strong style="color:red;">'+money+'元</strong><br /><span style="margin-left:42px;">应该为</span> : <span style="color:red;font-weight:bolder">'+remoney+'元</span><br /><span style="margin-left:42px;">您确定要提交吗？</span>',function(r){
   //      if(r){
   //        dataStroage.uid = uid;
   //        dataStroage.itemid = itemid;
   //        dataStroage.money = money;
   //        dataStroage.month = month;
   //        dataStroage.iname = iname;
   //        dataStroage.type = type;
   //        dataStroage.folderid = folderid;
   //        dataStroage.crid = crid;
   //        dataStroage.imonth = imonth;
   //        dataStroage.iday = iday;
   //        dataStroage.number = 1;
   //      }
   //  });
   // }else{
        dataStroage.uid = uid;
        dataStroage.itemid = itemid;
        dataStroage.money = money;
        dataStroage.month = month;
        dataStroage.iname = iname;
        dataStroage.type = type;
        dataStroage.folderid = folderid;
        dataStroage.crid = crid;
        dataStroage.imonth = imonth;
        dataStroage.iday = iday;
        dataStroage.number = 1;
   // }
   return dataStroage;
}

function submitAll(){
    $("a.tj[status!=1]").trigger('click');
}

function resetAll(){
     $("form.manopen[tag!=0]").remove();
     $(":checkbox").prop('checked',false);
     getTotalMoney();
     hasSubmitAll = false;
     return false;
}

function check(uid,itemid,money,month,iname){
    var errorInfo = new Array();
    var uidstatus = $.isNumeric(uid)&&(uid>0);
    var itemidtatus = $.isNumeric(itemid)&&(itemid>0);
    var moneystatus = $.isNumeric(money)&&(money>=0);
    var monthstatus = $.isNumeric(month)&&(month>0);
    if(!uidstatus){
        errorInfo.push('服务:'+iname+'用户选择有误!');
    }
   
    if(!moneystatus){
        errorInfo.push('服务:'+iname+'支付金额填写有误!');
    }
    if(money>10000000){
       errorInfo.push('服务:'+iname+'支付金额单次不能超过10000000!');
       moneystatus=false;
    }
    if(!monthstatus){
        errorInfo.push('服务:'+iname+'开通时长填写有误!');
    }
    if(!itemidtatus){
        errorInfo.push('服务:'+iname+'服务选择有误!');
    }
    if(uidstatus&&itemidtatus&&monthstatus&&moneystatus){
        return 1;
    }else{
        return errorInfo.join("\r\n");
    }
   
}

function manopensubmit(uid,itemid,money,month,iname,type,folderid,crid,imonth,iday){

    //字段校验判断。。。。。。
    var status = check(uid,itemid,money,month,iname);
    if(status!=1){
        alert(status);
        return false;
    }
    $.post('/admin/ibuy/manualnotify.html',
            {uid:uid,number:month,itemid:itemid,money:money,type:type,folderid:folderid,crid:crid,omonth:imonth,oday:iday},
            function(d){
                if(d==1){
                    changeStatus(itemid,"开通成功");
                    _search();
                }else{
                    changeStatus(itemid,"开通失败");
                    _search();
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

//学校选择弹出窗口
function showcr(){
        var url = '/admin/classroom/roomselect.html?isschool=7';
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
        _search();
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
    } 
</script>