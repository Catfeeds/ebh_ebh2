<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>模块管理 - 网校应用模块权限列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="<?php echo geturl('admin/task');?>">浏览</a></td>
            <td ><a id="addbtn" href="javascript:void(0)" onclick="showaddin('/admin/appmodule/classroomedit.html','修改权限')" class="add">修改权限</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>


<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">
<tbody><tr><td>
    <label>关键字: <input type="text" name="q" id="searchkey" value="" size="20">
    <input type="submit" name="selectsubmit" onclick="return _search()" value="查询" class="submit">
</td></tr></tbody>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.crid+'" /></td>');
        row.push('<td class=username><span style=\'color:red\'>'+v.crname+'</span></td>');
        row.push('<td class="realname"><span style=\'color:red\'>'+v.domain+'</span></td>');
        
        row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/appmodule/classroomedit.html?crid='+v.crid+'\',\'选择模块\')">模块权限</a>]&nbsp;&nbsp;[<a href="/admin/menu.html?crid='+v.crid+' ">菜单管理</a>]</td>');
        
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="40%" >网校名称</th>
<th width="30%" >域名</th>
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
        var query = $('#searchkey').val();
		$.post("/admin/appmodule/getListAjaxPermission.html",
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


function delmodule(itemid){
	if (itemid){
		$.messager.confirm('确认','确定要删除该模块么？',function(r){
			if (r){
				$.post('/admin/task/del.html',{id:itemid},function(result){
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

    var closedialog = function (){
        $("#crwrap").dialog('close');
    }
function showaddin(url,title){
    
	height = 700;
	width = 800;
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