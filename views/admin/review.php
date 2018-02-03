<?php
$this->display('admin/header');
?>
<body>
    <div id="toolbar">
	<table cellspacing="0" cellpadding="0" class="toptable">
		<tr><td>
		<label>关键字: </label>
		<input id="search-input" type="text" onkeypress="presstosearch(event);"/>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
		</td></tr>
	</table>
	</div>
    <table id="dg" cellspacing="0" cellpadding="0" width="100%"  class="listtable">
		<tbody class="reviewtbody">
			<tr>
			<th>序号</th>
			<th>选择</th>
			<th fieldname="i.username" width="8%">评论人</th>
			<th fieldname="i.toid" width="8%">评论对象</th>
			<th fieldname="i.message" width="40%">评论内容</th>
			<th fieldname="i.dp" width="15%">点评</th>
			<th fieldname="i.fromip">操作IP</th>
			<th fieldname="i.dateline">提交日期</th>
			<th width="6%">操作</th>
			</tr>
		</tbody>
		<tbody class="moduletbody">
			<tr class="tr_review" />
			<th class="sn">1</th>
			<td class="sn"><input type="checkbox" name="item[]" value="243837" /></td>
			<td class="uid">xs00047</td>
			<td class="toid"></td>
			<td class="message">33333</td>
			<td class="dp" nowrap>描述：分/内容：分/态度：0分/综合：4分</td>
			<td class="fromip">192.168.0.151</td>
			<td class="datetime">2014-01-27 17:00:34</td>
			<td class="op">[<a href="#">编辑</a>] [<a href="#" >删除</a>]</td>
			</tr>
		</tbody>
	</table>


	<span id="pp"></span> 
	<?php
	// $this->display('admin/pagination');
	?>
	
    
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
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.logid+'" /></td>');
        row.push('<td class="username">'+v.username+'</td>');
        row.push('<td class="tousername">'+v.type+'</td>');
        row.push('<td class="message">'+v.subject+'</td>');
        row.push('<td class="dp" nowrap>描述：分/内容：分/态度：0分/综合：4分</td>');
        row.push('<td class="fromip">'+v.fromip+'</td>');
        row.push('<td class="datetime">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="op">[<a href="javascript:;" onclick="del('+v.logid+')">删除</a>]</td>');
        row.push('</tr>');
        return row.join('');
    }

		$('#pp').pagination({
		pageSize:20,
		onSelectPage:function(pageNumber, pageSize){
			var query = $("#search-input").val()
			$.post("/admin/review/getListAjax.html",
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
		function del(logid){
            if (logid){
                $.messager.confirm('确认','确定要删除该评论么？',function(r){
                    if (r){
                        $.post('/admin/review/del.html',{logid:logid},function(result){
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