<?php
$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1 style="width:550px;">教师管理 -  教师列表</h1></td>
        <td class="actions" >
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="/admin/teacher.html">浏览教师</a></td>
            <td ><a href="/admin/teacher/add.html" class="add">添加教师</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
<input type="hidden" name="op" value="search" />
<table cellspacing="0" cellpadding="0" class="toptable"><tr><td>
<label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.uid+'" /></td>');
        row.push('<td class="username">'+v.username+'</td>');
        row.push('<td class="realname">'+(v.realname||'')+'</td>');
        row.push('<td class="nickname">'+(v.nickname||'')+'</td>');
        row.push('<td class="agency">'+(v.agency||'')+'</td>');
        row.push('<td class="agentname">'+(v.agentname||'')+'</td>');
        row.push('<td class="mobile" >'+v.mobile+'</td>');
        if(v.citycode){
            var cityname = getcityname(v.citycode);
            row.push('<td class="address">'+cityname+'</td>');
        }else{
            row.push('<td class="address"></td>');
        }
        if(v.status==1){
             row.push('<td class="status">正常</td>');
         }else{
             row.push('<td class="status">锁定</td>');
         }
        row.push('<td class="nowrap" >');
        row.push('[<a href="/admin/teacher/view.html?uid='+v.uid+'">详情</a>]&nbsp;[<a href="/admin/teacher/edit.html?uid='+v.uid+'">编辑</a>]&nbsp;[<a href="/admin/user/changepassword.html?tag=teacher&amp;returnurl=/admin/teacher.html&amp;uid='+v.uid+'">修改登录密码</a>]<br>[<a href="#" onclick="return destroyuser('+v.uid+')">删除</a>]&nbsp;');
        if(v.status==1){
            row.push('[<a href="#" onclick="changestatus('+v.uid+',0)">锁定</a>]&nbsp;');
        }else{
            row.push('[<a href="#" onclick="changestatus('+v.uid+',1)">解锁</a>]&nbsp;');
        }
        
        row.push('</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.username">登录名</th>
<th fieldname="i.realname">姓名</th>
<th fieldname="i.nickname">昵称</th>
<th fieldname="i.agency">组织机构</th>
<th fieldname="i.agentname">所属代理商</th>
<th fieldname="i.mobile" width="12%">手机号码</th>
<th fieldname="i.address" width="20%">地址</th>
<th fieldname="i.status">用户状态</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">

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

</body>
<script type="text/javascript">
$(function(){
//    $(".pagination-page-list").trigger('change');
$(".pagination").hide();
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
function _search(){
	if($.trim($("#searchkey").val()) == "") {
		alert("请输入教师账号或姓名进行查询。");
		return false;
	}
   $('#pp').pagination({pageNumber:1});
   $(".pagination-page-list").trigger('change');
   return false;
}
$('#pp').pagination({
    pageSize:10,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#ck').serialize();
        $.post("/admin/teacher/getListAjax.html",
            {query:query,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
				$(".pagination-num").parent().next().html('<span style="padding-right:6px;">页</span>');
				$(".pagination-last").hide();
                $(".pagination-info").hide();
            }
            );
        return false;
    }
});
function destroyuser(uid){
    if (uid){
        $.messager.confirm('确认','确定要删除该教师么？',function(r){
            if (r){
                $.post('<?php echo geturl('admin/teacher/del');?>',{uid:uid},function(result){
                    if (result.success){
                        $.messager.show({    
                            timeout:2000,
                            title: '成功',
                            msg: '删除成功'
                        });
                        $('.pagination-page-list').trigger('change');
                    } else {
                        $.messager.show({   
                            title: 'Error',
                            msg: result
                        });
                    }
                },'json');
            }
        });
    }
}
function changestatus(uid,status){
    if (uid){
        $.post('<?php echo geturl('admin/teacher/editteacher');?>',
            {uid:uid,status:status},
            function(result){
                    if (result==1){
                    
                       $('.pagination-page-list').trigger('change');
                    } else {
                        $.messager.show({    // show error message
                            title: 'Error',
                            msg: result
                        });
                    }
            });
    }
}
$("#chkall").click(function(){
    $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});
function getcityname(citycode){

    return $.ajax({ 
        url: "/admin/cities/getAddrText.html",
        type:"post",
        data:{citycode:citycode},
        async:false,
    }).responseText;
}
</script>
<?php
$this->display('admin/footer');
?>