<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>模块管理 - 应用模块列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="<?php echo geturl('admin/task');?>">浏览</a></td>
            <td ><a id="addbtn" href="javascript:void(0)" onclick="showaddin('/admin/appmodule/add.html','添加模块')" class="add">添加模块</a></td>
            </tr>
            </table>
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
		// var typearr = new Array("不显示","新手任务","日常任务","每日任务");
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.moduleid+'" /></td>');
        row.push('<td class=username><span style=\'color:red\'>'+v.modulename+'</span></td>');
        row.push('<td class="realname"><span style=\'color:red\'>'+v.modulecode+'</span></td>');
		row.push('<td class="mobile"><span >'+v.url+'</span></td>');
		row.push('<td class="mobile">'+v.system+'</td>');
        row.push('<td class="nickname">'+v.classname+'</td>');
        
		
        row.push('<td class="i.dateline">'+v.tors+'</td>');
		row.push('<td class="status">'+v.isfree+'</td>');
		row.push('<td class="status">'+v.logo+'</td>');
		row.push('<td class="status">'+v.target+'</td>');
        row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/appmodule/edit.html?moduleid='+v.moduleid+'\',\'编辑模块\')">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return delmodule('+v.moduleid+')" >删除</a>]');
        if(v.system ==0){
            row.push('&nbsp;&nbsp;[<a href="/admin/appmodule/viewmodel.html?moduleid='+v.moduleid+'">查看</a>]');
            row.push('&nbsp;&nbsp;[<a href="javascript:;" onclick="return removeSet('+v.moduleid+')">删除模块配置</a>]');
        }else{
			//row.push('&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="return initsys('+v.moduleid+')">应用到各网校</a>]');
		}
        row.push('</td></tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="10%" >模块名称</th>
<th width="10%" >模块编码</th>
<th width="17%" >跳转地址</th>
<th width="10%" >是否系统模块</th>
<th width="10%" >classname</th>
<th >老师还是学生</th>
<th >免费</th>
<th >logo</th>
<th >页面打开方式</th>
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
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
<!--
<div id="dd"></div>
<div id="ddcontent">确定要将该系统模块应用到所有网校么？	</div>
<div id="ddbuttons">
	<a href="#" class="easyui-linkbutton">应用</a>
	<a href="#" class="easyui-linkbutton">应用并添加到更多</a>
	<a href="javascript:void(0)" onclick="$('#dd').dialog('close');" class="easyui-linkbutton">取消</a>
</div>
-->
</body>
<script type="text/javascript">


var addurl = '/admin/task/add.html';
var s_pid = 0;
var s_crid = 0;
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
        
        $.post("/admin/appmodule/getListAjax.html",
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


function delmodule(itemid){
    if (itemid){
        $.messager.confirm('确认','确定要删除该模块么？',function(r){
            if (r){
                $.post('/admin/appmodule/del.html',{moduleid:itemid},function(result){
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
function initsys(itemid){
    if (itemid){
		
        $.messager.confirm('确认','确定要将该系统模块应用到所有网校么？',function(r){
            if (r){
                $.post('/admin/appmodule/initsys.html',{moduleid:itemid},function(result){
                    if (result.success){
                        $.messager.show({    
                            timeout:800,
                            title: '成功',
                            msg: '操作成功'
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
		
		
		// $('#dd').dialog({
			// width: 400,
			// height: 200,
			// title:'确认',
			// content:$('#ddcontent'),
			// buttons:$('#ddbuttons')
		// });
    }
    return false;
}
function removeSet(itemid) {
    if (itemid) {
        $.messager.confirm('确认','确定要将所有网校的该模块设置删除吗？',function(r){
            if (r){
                $.post('/admin/appmodule/remove_module_set.html',{moduleid:itemid},function(result){
                    if (result.success){
                        $.messager.show({
                            timeout:800,
                            title: '成功',
                            msg: '操作成功'
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

    var closedialog = function (){
        $("#crwrap").dialog('close');
    }
function showaddin(url,title){
    
	height = 550;
	width = 900;
	var html = '<iframe scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
	artDialog({
		title : title,
		width : width,
		height : height,
		content : html,
		padding : 10,
		resize : false,
		lock : true,
		opacity : 0.2,
		
	});
}
</script>
<?php
$this->display('admin/footer');
?>