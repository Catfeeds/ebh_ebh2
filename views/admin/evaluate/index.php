<?php $this->display('admin/header');?>
<style>
.pagination-info{
	float:left;
	padding-left:50px;
}
</style>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>量表管理</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="javascript:;">所有量表</a></td>
			<td ><a href="/admin/evaluate/add.html" class="add">添加量表</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>

    <div id="toolbar">
	<table cellspacing="0" cellpadding="0" class="toptable">
		<tr><td>
		<label>关键字: </label>
		<input id="search-input" type="text" onkeypress="presstosearch(event);"/>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
		</td></tr>
	</table>
	</div>
    <table id="dg" cellspacing="0" cellpadding="0" style="width:80%;margin-left:10px"   class="listtable">
		<tbody class="reviewtbody">
			<tr>
			<th>序号</th>
			<th>选择</th>
			<th fieldname="i.title" width="8%">量表名称</th>
			<th fieldname="i.descr" width="30%">量表简介</th>
			<th fieldname="i.tutor" width="40%">量表导语</th>
			<th fieldname="i.logo" width="15%">配图</th>
			<th fieldname="i.total">试题总数量</th>
			<th fieldname="i.nums">每道题选项数</th>
			<th width="6%">操作</th>
			</tr>
		</tbody>
		<tbody class="moduletbody">
			<tr class="tr_review" >
			</tr>
		</tbody>
	</table>
<span id="pp" style="margin-left:10px"></span> 

<script type="text/javascript">
	$(function(){
        $(".pagination-page-list").trigger('change');
    });
    function _search(){
        $(".pagination-page-list").trigger('change');
        return false;
    }
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_review" />'];
        row.push('<th>'+(k+1)+'</th>');
        row.push('<td><input type="checkbox" name="item[]" value="'+v.eid+'" /></td>');
        row.push('<td>'+v.title+'</td>');
        row.push('<td>'+v.descr+'</td>');
        row.push('<td>'+v.tutor+'</td>');
        row.push('<td  nowrap><img src="'+v.logo+'" style="height:120px;width:120px" /></td>');
        row.push('<td>'+v.nums+'</td>');
        row.push('<td>'+v.total+'</td>');
        row.push('<td class="op"> [<a href="/admin/evaluate/edit.html?eid='+v.eid+'" >修改</a>] [<a href="/admin/questions.html?eid='+v.eid+'" >问题</a>] [<a href="/admin/refer.html?eid='+v.eid+'" >评语</a>] [<a href="javascript:;" onclick="del('+v.eid+')">删除</a>] </td>');
        row.push('</tr>');
        return row.join('');
    }

	$('#pp').pagination({
		pageSize:20,
		onSelectPage:function(pageNumber, pageSize){
			var query = $("#search-input").val()
			$.post("/admin/evaluate/getevaluatelistajax.html",
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
		function del(eid){
            if (eid){
                $.messager.confirm('确认','确定要删除该评论么？',function(r){
                    if (r){
                        $.post('/admin/evaluate/del.html',{eid:eid},function(result){
                            if (result.success){
								$.messager.show({
                                    title: '成功',
                                    msg: '删除成功',
									timeout:2000
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

	</script>
</body>
<?php
$this->display('admin/footer');
?>