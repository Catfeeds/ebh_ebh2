<?php 
	$this->display('admin/header');
?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>主贴管理 - 主贴列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="/admin/posts.html">主贴列表</a></td>
			<td ><a href="/admin/posts/detail.html">主贴详情</a></td>
			<td ><a href="/admin/posts/add.html" class="add">添加主贴</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">
<tr>
<td><label>关键字: </label><input type="text" name="searchkey" id="searchkey" value="" size="20" />
开始时间：<input type="text" value="" name='begintime' onfocus="$(this).datebox({});" id="begintime" />
-<input type="text" value="" onfocus="$(this).datebox({});" name='endtime' id='endtime'  /> 
帖子状态：<select name="status" id="status"><option value="" selected="selected">状态选择</option>
<option value="0">正常帖子</option>
<option value="1">屏蔽帖子</option></select>
<input type="submit" name="selectsubmit" value="查询" class="submit"> (关键字包括：标题，电子教室)
</td>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.postsid+'" /></td>');
        row.push('<td class="subject">'+v.subject+'</td>');
        if(v.content){
        	if(v.content.replace(/<[^>].*?>/g,"").length>26){
	        	row.push('<td class="content">'+v.content.replace(/<[^>].*?>/g,"").substr(0,26)+'...</td>');
	        }else{
	        	row.push('<td class="content">'+v.content.replace(/<[^>].*?>/g,"").substr(0,26)+'</td>');
	        }
        }else{
        	row.push('<td  class="content"></td>');
        }

        if(v.crname){
        	row.push('<td class="crname">'+v.crname+'</td>');
        }else{
        	row.push('<td class="crname"></td>');
        }
        row.push('<td class="">'+getformatdate(v.dateline)+'</td>');
        if(v.status==1){
        	row.push('<td class="status">屏蔽状态</td>');
        }else{
        	row.push('<td class="status">正常状态</td>');
        }
        if(v.status==1){
        	row.push('<td class="op">&nbsp;&nbsp;[<a href="/admin/posts/detail.html?postsid='+v.postsid+'">详情</a>]&nbsp;&nbsp;[<a href=/admin/posts/add.html?postsid='+v.postsid+'>编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.postsid+',0)" >恢复正常</a>]&nbsp;&nbsp;[<a href="#" onclick="return _del('+v.postsid+')" >删除</a>]</td>');
        }else{
        	row.push('<td class="op">&nbsp;&nbsp;[<a href="/admin/posts/detail.html?postsid='+v.postsid+'">详情</a>]&nbsp;&nbsp;[<a href=/admin/posts/add.html?postsid='+v.postsid+'>编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.postsid+',1)" >屏蔽此贴</a>]&nbsp;&nbsp;[<a href="#" onclick="return _del('+v.postsid+')" >删除</a>]</td>');
        }    
        
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="10%">标题</th>
<th width="30%">内容</th>
<th width="15%">所属教室</th>
<th width="13%">发布时间</th>
<th width="6%">帖子状态</th>
<th width="15%">操作</th>
</tr>
<tbody class="moduletbody">
</tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
	<th width="12%">批量操作</th>
	<th>
		<input type="checkbox" name="chkall" id="chkall" onclick="#">
		<label for="chkall">全选</label>
		<input type="radio" name="operation" value="noop" checked id="noop">
		<label for="noop">不操作</label>
	</th>
</tr>
<tr id="divnoop" style="display: none">
<td></td>
<td></td>
</tr>
</table>
<div id="pp"></div>
<div class="buttons"><input type="submit" name="listsubmit" value="提交保存" class="submit"> 
	<input type="reset" name="listreset" value="重置"></div>
</form><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
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
    $.post("/admin/posts/getListAjax.html",
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

function changestatus(postsid,status){
	$.post('/admin/posts/changestatus.html',
			{postsid:postsid,status:status},
			function(message){
				if(message==1){
					$(".pagination-page-list").trigger('change');
				}else{
					alert('失败!');
				}
			}
		);
	return false;
}

function _del(postsid){
	$.messager.prompt('提示信息', '请输入验证码 : '+postsid, function(r){
		if (r==postsid){
			$.post('/admin/posts/deleteByPostsId.html',{postsid:postsid},function(message){
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
</script>

<?php 
	$this->display('admin/footer');
?>