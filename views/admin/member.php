<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>会员管理 - 会员列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="<?php echo geturl('admin/member');?>">浏览会员</a></td>
            <td ><a href="<?php echo geturl('admin/member/add');?>" class="add">添加会员</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td><label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
    <input type="hidden" name="aq" id="selecttype" value="1">
    <input type="submit" name="aq" value="精准查询" class="submit" onclick="$('#selecttype').val(1)" />
    <input type="submit"  value="模糊查询" class="submit" onclick="$('#selecttype').val(0)" />
    <label>
关键字（精准查询仅包括:登录名 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;模糊查询包括:登录名、真实姓名、昵称。）</label></td>
</tr>
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
        row.push('<td class=username><span style=\'color:red\'>'+v.username+'</span></td>');
        row.push('<td class="realname">'+(v.realname||'')+'</td>');
        row.push('<td class="mobile">'+(v.mobile||'')+'</td>');
        row.push('<td class="email">'+(v.email||'')+'</td>');
        if(v.citycode){
            row.push('<td class="address">'+getcityname(v.citycode)+'</td>');
        }else{
            row.push('<td class="address"></td>');
        }
		row.push('<td class="i.schoolname">'+v.schoolname+'</td>');
		row.push('<td class="i.logincount">'+v.logincount+'</td>');
		row.push('<td class="i.credit">'+v.credit+'</td>');
        row.push('<td class="i.dateline">'+getformatdate(v.dateline)+'</td>');
		var regip = v.regip == null ? '' : v.regip;
        row.push('<td class="i.regip">'+ regip +'</td>');
		row.push('<td class="i.lastlogintime">'+getformatdate(v.lastlogintime)+'</td>');
		var lastloginip = v.lastloginip == null ? '' : v.lastloginip;
        row.push('<td class="i.lastloginip">'+ lastloginip || ''+'</td>');
        if(v.status==1){
            row.push('<td class="status">正常用户</td>');
            row.push('<td class="op">&nbsp;&nbsp;[<a href="/admin/member/view.html?uid='+v.uid+'">详情</a>]&nbsp;&nbsp;[<a href="/admin/member/edit.html?uid='+v.uid+'">编辑</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return changestatus('+v.uid+',0)" >锁定</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return destroyuser('+v.uid+')" >删除</a>]&nbsp;&nbsp;[<a href="/admin/user/changepassword.html?tag=member&amp;returnurl=/admin/member.html&uid='+v.uid+'">修改密码</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return openserver('+v.uid+',\''+v.username+'\')">开通服务</a>]</td>');
        }else{
            row.push('<td class="status">锁定用户</td>');
            row.push('<td class="op">&nbsp;&nbsp;[<a href="/admin/member/view.html?uid='+v.uid+'">详情</a>]&nbsp;&nbsp;[<a href="/admin/member/edit.html?uid='+v.uid+'">编辑</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return changestatus('+v.uid+',1)" >解锁</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return destroyuser('+v.uid+')" >删除</a>]&nbsp;&nbsp;[<a href="/admin/user/changepassword.html?tag=member&amp;returnurl=/admin/member.html&uid='+v.uid+'">修改密码</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return openserver('+v.uid+',\''+v.username+'\')">开通服务</a>]</td>');
        }
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="8%" fieldname="i.username">登录名</th>
<th width="8%" fieldname="i.realname">真实姓名</th>
<th fieldname="i.mobile">手机号</th>
<th width="10%" fieldname="i.email">电子邮箱</th>
<th fieldname="i.citycode">居住地</th>
<th fieldname="i.schoolname">学校</th>
<th fieldname="i.logincount">登陆次数</th>
<th fieldname="i.credit">积分</th>
<th fieldname="i.dateline">注册日期</th>
<th fieldname="i.regip">注册时ip</th>
<th fieldname="i.lastlogintime">最后登陆时间</th>
<th fieldname="i.lastloginip">最后登录ip</th>
<th fieldname="i.status">用户状态</th>
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
<div id="winwrap" style="display:none">
    <iframe id="win" ></iframe>
</div>
</body>
<script type="text/javascript">
var quee = 1;
$(function(){
    $(".pagination-page-list").trigger('change');
	//$(".pagination").hide();
});
function _search(){
    $("#searchkey").val($.trim($("#searchkey").val()));
    if($("#searchkey").val() == ''){
        alert("请输入查询关键字");
        return false;
    }
    $('#pp').pagination({pageNumber:1});
    $(".pagination-page-list").trigger('change');
    return false;
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#ck').serialize();
        var curquee = ++quee;
        $.post("/admin/member/getListAjax.html",
            {query:query,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                if(curquee!=quee){
                    return;
                }
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
        return false;
    }
});
function getcityname(citycode){

    return $.ajax({ 
        url: "/admin/cities/getAddrText.html",
        type:"post",
        data:{citycode:citycode},
        async:false,
    }).responseText;
}
function changestatus(uid,status){
    if (uid){
        $.post('<?php echo geturl('admin/member/editmember');?>',
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
    return false;
}
function destroyuser(uid){
    if (uid){
        $.messager.confirm('确认','确定要删除该会员么？',function(r){
            if (r){
                $.post('/admin/member/del.html',{uid:uid},function(result){
                    if (result.success){
                        $.messager.show({    
                            timeout:800,
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
    return false;
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



function openserver(uid,username){
        var url = '/admin/spitem/servicepack_itemsearch_formember.html?uid='+uid+'&username='+username;
        var width = $(window).width();
        var height = $(window).height();
        $('#win')
        .attr('width',width/5*4)
        .attr('height',height/5*4)
        .attr('src',url);
        $('#winwrap').show();
        $('#winwrap').dialog({
            title:"开通服务",    
            closed: false,    
            cache: false,   
            modal: true   
        });
        // $('#win').window('refresh', );  
        return false;
    }
    var closedialog = function (){
        $("#crwrap").dialog('close');
    } 
</script>
<?php
$this->display('admin/footer');
?>