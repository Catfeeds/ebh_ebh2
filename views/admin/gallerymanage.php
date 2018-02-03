<?php
$this->display('admin/header');
?>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>主页装扮 -分类管理</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class=""><a href="javascript:void(0)" onclick="showedit('/admin/gallery/addgallerys.html','添加分类')" class="add">添加分类</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="0" class="toptable">
</table>
</form>
<script type="text/javascript">
	var order = 1;
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
        order = 1
    }
    function _renderRow(k,v){
        var row = ['<tr class="tr_module_" style="background-color:#EEEEEE">'];
        var ischeck = (v.ishide==1)?'':'checked';
        row.push('<th class="sn">'+(order++)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.aid+'" /></td>');
		row.push('<td class="" align="left">'+(v.alname)+'</td>');
		row.push('<td class="">'+(v.nums)+'</td>');
		row.push('<td class=""><input type="checkbox" '+ischeck+' disabled/></td>');
		row.push('<td class="">'+(v.displayorder)+'</td>');
        row.push('<td class=""></td>');
        row.push('</tr>');
        if(v.children){
        	var value = v.children;
	        for (var i = 0; i < value.length; i++) {
	        	var ischeck = (value[i].ishide==1)?'':'checked';
		        row.push('<tr class="tr_module_">');
		        row.push('<th class="sn">'+(order++)+'</th>');
		        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+value[i].aid+'" /></td>');
				row.push('<td class="" align="left">&nbsp;&nbsp;&nbsp;&nbsp;|----'+(value[i].alname)+'</td>');
				row.push('<td class="">'+(value[i].nums)+'</td>');
				row.push('<td class=""><input type="checkbox" '+ischeck+' disabled/></td>');
				row.push('<td class="">'+(value[i].displayorder)+'</td>');
		        row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showedit(\'/admin/gallery/editgallerys.html?aid='+value[i].aid+'\',\'修改分类\')">修改</a>]'
		        +'&nbsp;&nbsp;[<a href="#" onclick="return delitem('+value[i].paid+','+value[i].aid+')" >删除</a>]</td>');
		        row.push('</tr>');
	      	}
        }
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="50%" >分类名称</th>
<th width="10%" >图片数量</th>
<th width="10%" >是否显示</th>
<th width="12%" >排序</th>
<th >操作</th>
</tr>
<tbody class="moduletbody" style="text-align:center;">
</tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr id="divnoop" style="display: none">
<td></td>
<td></td>
</tr>
</table>
<div id="pp" style="display: none;"></div>
<br>
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
        $.post("/admin/gallery/getgallerys.html",
            {q:query},
            function(message){
                message = JSON.parse(message);
                 _render(message.data);
            }
            );
        return false;
    }
});


function delitem(paid,aid){
	if(paid==0){
		$.messager.show({   
	       title: 'Error',
	       msg: '类型无法删除'
	   });
		return false;
	}
    if (aid){
        $.messager.confirm('确认','确定要删除该分类么？',function(r){
            if (r){
               $.post('/admin/gallery/delgallerys.html',{paid:paid,aid:aid},function(result){
                   if (result.code==0){
                       $.messager.alert('成功',result.msg,'info');
                       $('.pagination-page-list').trigger('change');
                   } else {
                   		$.messager.alert('Error',result.msg,'info');
                   }
               },'json');
            }
        });
    }
    return false;
}
function showedit(url,title){
	height = 240;
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