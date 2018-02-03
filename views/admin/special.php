<?php
	$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>专题管理 - 专题列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="/admin/special.html">浏览专题</a></td>
			<td ><a href="/admin/special/add.html" class="add">添加专题</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="GET" action="/admin/special/op.html" id="ck" onsubmit="return _search()">
<input type="hidden" name="action" value="special" /> 
<input type="hidden" name="op" value="search" /> 
<table cellspacing="0" cellpadding="0" class="toptable">
<tr>
<td><label>关键字: </label><input type="text" name="searchkey"
id="searchkey" value="" size="20" /> <input type="submit"
name="selectsubmit" value="查询" class="submit"><label>
关键字(标题)</label></td>
</tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>选择</th>
<th>ID</th>
<th>标题</th>
<th>类型</th>
<th>操作</th>
</tr>
<tbody class="moduletbody" id="moduletbody">
<script type='text/javascript'>
	function _render(_data){
		$("#moduletbody").html('');
		$.each(_data,function(k,v){
			$(_renderRow(k,v)).appendTo("#moduletbody");
		});
	}
	function _renderRow(k,v){
		var row = ['<tr class="tr_module">'];
		row.push('<input type="hidden" name="sid" value="'+v.sid+'">');
		row.push('<td align="center" style="width: 10px"><input type="checkbox" name="item[]" value="'+v.sid+'"></td>');
		row.push('<td align="center" style="width: 20px">'+v.sid+'</td>');
		row.push('<td align="center" style="width: 150px">'+v.title+'</td>');
		row.push('<td align="center" style="width: 50px">'+v.name+'</td>');
		row.push('<td style="width: 150px;text-align: center;">[<a href="/admin/special/detail.html?sid='+v.sid+'">详情</a>]&nbsp;&nbsp;[<a href="/admin/special/add.html?op=edit&sid='+v.sid+'">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="_del('+v.sid+')">删除</a>]</td>');
		row.push('</tr>');
		return row.join('');
	}
</script>
</tbody>
</table>
<div id="pp"></div>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
<th width="12%">批量操作</th>
<th><input type="checkbox" name="chkall" id="chkall"
onclick="checkall(this.form, 'members')"><label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label
for="noop">不操作</label></th>
</tr>
<tr id="divnoop" style="display: none">
<td></td>
<td></td>
</tr>
</table>
<script type="text/javascript">
	$('#pp').pagination({
		pageSize:10,
		onSelectPage:function(pageNumber, pageSize){
		    var query = $('#ck').serialize();
		    $.post("/admin/special/getListAjax.html",
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
	$(function(){
		$(".pagination-page-list").trigger('change');
	});
	function _search(){
	    $(".pagination-page-list").trigger('change');
	    return false;
	}
	function _del(sid){
            $.messager.prompt('确认','请输入验证码'+sid,function(data){    
                if (data==sid){    
                    $.post('/admin/special/del.html',
                        {sid:sid},
                        function(message){
                            if(message==1){
                                $('.pagination-page-list').trigger('change');
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "删除成功！",
                                    showType: 'slide',
                                    timeout: 300
                                });
                                return false;
                            }else{
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "删除失败！",
                                    showType: 'slide',
                                    timeout: 300
                                });
                                $('.pagination-page-list').trigger('change');
                                return false;
                            }
                        }
                        );   
                }else{
                    
                    $.messager.alert('提示','验证码不正确!');
                    return false;
                    
                }    
            });  


            
       }
</script>
<br>
<div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
<?php 
	$this->display('admin/footer');
?>