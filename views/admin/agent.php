<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">代理商管理 -  代理商列表</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="/admin/agent.html">浏览代理商</a></td>
            <td ><a href="/admin/agent/add.html" class="add">添加代理商</a></td>
            <td ><a href="/admin/agent/batchadd.html" class="add">批量生成代理商</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form id="ck" action="#" onsubmit="return _search()" >
<table cellspacing="0" cellpadding="0" class="toptable">
<tr><td><label>关键字: </label><input type="text" name="searchkey" id="searchkey" value="" size="20" />
<input type="submit" name="selectsubmit" value="查询" class="submit">
</td></tr>
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
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.agentid+'" /></td>');
        row.push('<td class="username">'+v.username+'</td>');
        row.push('<td class="mobile">'+(v.mobile||"无")+'</td>');
        if(v.citycode){
        	var cityname = getcityname(v.citycode);
        	row.push('<td class="address">'+cityname+'</td>');
        }else{
        	row.push('<td class="address"></td>');
        }
        var status = ['锁定用户','正常用户','未激活用户'];
        row.push('<td class="status">'+(status[v.status]||'')+'</td>');
        if(v.status==1){
        	row.push('<td class="nowrap" >[<a href="/admin/agent/detail.html?agentid='+v.agentid+'">详情</a>]&nbsp;[<a href="/admin/agent/add.html?op=edit&agentid='+v.agentid+'">编辑</a>]&nbsp;[<a href="/admin/agent/add.html?upid='+v.agentid+'&upname='+v.username+'">添加下级代理</a>]&nbsp;[<a href="/admin/user/changepassword.html?tag=agent&returnurl=/admin/agent.html&uid='+v.agentid+'">修改登录密码</a>]<br>[<a href="#" onclick="return _del('+v.agentid+')">删除</a>]&nbsp;[<a href="#" onclick="return changestatus('+v.agentid+',0)">锁定</a>]&nbsp;</td>');
        }else if(v.status==0){
        	 row.push('<td class="nowrap" >[<a href="/admin/agent/detail.html?agentid='+v.agentid+'">详情</a>]&nbsp;[<a href="/admin/agent/add.html?op=edit&agentid='+v.agentid+'">编辑</a>]&nbsp;[<a href="/admin/agent/add.html?upid='+v.agentid+'&upname='+v.username+'">添加下级代理</a>]&nbsp;[<a href="/admin/user/changepassword.html?tag=agent&returnurl=/admin/agent.html&uid='+v.agentid+'">修改登录密码</a>]<br>[<a href="#" onclick="return _del('+v.agentid+')">删除</a>]&nbsp;[<a href="#" onclick="return changestatus('+v.agentid+',1)">激活</a>]&nbsp;</td>');
        }else{
        	 row.push('<td class="nowrap" >[<a href="/admin/agent/detail.html?agentid='+v.agentid+'">详情</a>]&nbsp;[<a href="/admin/agent/add.html?op=edit&agentid='+v.agentid+'">编辑</a>]&nbsp;[<a href="/admin/agent/add.html?upid='+v.agentid+'&upname='+v.username+'">添加下级代理</a>]&nbsp;[<a href="/admin/user/changepassword.html?tag=agent&returnurl=/admin/agent.html&uid='+v.agentid+'">修改登录密码</a>]<br>[<a href="#" onclick="return _del('+v.agentid+')">删除</a>]&nbsp;[等待激活]&nbsp;</td>');
        }
       
        row.push('</tr>');
        return row.join('');
    }
</script>
<form method="post" name="listform" id="theform" action="#"  >
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.username">登录名</th>
<th fieldname="i.mobile" width="12%">手机号码</th>
<th fieldname="i.phone" style="display:none;">联系电话</th>
<th fieldname="i.fax" style="display:none;">传真</th>
<th fieldname="i.address" width="20%">地址</th>
<th fieldname="i.status">用户状态</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
<tr class="tr_module" />

</tbody>
</table><table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input id="chkall" type="checkbox" name="chkall"><label for="chkall">全选</label>
<input id="noop" name="optype" type="radio" value="0" checked /><label for="noop">不操作</label>
</th></tr>
</table>

<div id="pp"></div>
<div class="buttons">
<input type="submit" name="agentsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>

</form>
</body>
<script>

$(function(){
    $("#begintime,#endtime").trigger('focus');
    $(".pagination-page-list").trigger('change');
});
function _search(){
    $(".pagination-page-list").trigger('change');
    return false;
}

$('#pp').pagination({
pageSize:10,
onSelectPage:function(pageNumber, pageSize){
    var query = $('#ck').serialize();
    $.post("/admin/agent/getListAjax.html",
        {query:query,pageNumber:pageNumber,pageSize:pageSize},
        function(message){
            message = JSON.parse(message);
            $('#pp').pagination('refresh',message.shift());
             _render(message);
            

        }
        );
    return false;
}
});

function changestatus(agentid,status){
	$.post('/admin/agent/changestatus.html',
			{agentid:agentid,status:status},
			function(message){
				if(message){
					$(".pagination-page-list").trigger('change');
				}else{
					alert('失败!');
				}
			}
		);
	return false;
}

function _del(agentid){
	$.messager.prompt('提示信息', '请输入验证码 : '+agentid, function(r){
		if (r==agentid){
			$.post('/admin/agent/deleteByagentid.html',{agentid:agentid},function(message){
				if(message==1){
					$.messager.show({
						title:'提示消息',
						msg:'删除成功!',
						timeout:1000,
						showType:'slide'
					});
					$(".pagination-page-list").trigger('change');

				}else{
					$.messager.show({
						title:'提示消息',
						msg:'删除失败!',
						timeout:1000,
						showType:'slide'
					});

				}
			});	
		}else{
			$.messager.alert('提示','验证码不正确!');
                return false;
		}
	});

	return false;
}
function getcityname(citycode){

	return $.ajax({ 
		url: "/admin/cities/getAddrText.html",
		type:"post",
		data:{citycode:citycode},
		async:false,
  	}).responseText;
}

$("#chkall").click(function(){
    $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});
   //批量按钮点击展现子选项
$(function(){
   $(":radio[name='operation']").click(function(){
       var showDiv = 'div'+$(this).attr('value');
       if(showDiv=='divnoop'){
           $("tr[id^=div]").hide();
           return;
       }
       $("tr[id^=div]").hide();
   $('#'+showDiv).show();
    });
});
</script>
<?php $this->display('admin/footer');?>