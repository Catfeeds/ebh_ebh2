<?php $this->display('admin/header'); ?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>主贴评论管理 - 评论列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="#">评论列表</a></td>
			<td ><a href="#">评论详情</a></td>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.rid+'" /></td>');
        row.push('<td class="subject">'+(v.subject||"")+'</td>');
        row.push('<td class="crname">'+(v.crname||"")+'</td>');
        row.push('<td class="username">'+(v.username||"")+'</td>');
        if(v.rcontent.replace(/<[^>].*?>/g,"").length>26){
        	row.push('<td class="rcontent">'+v.rcontent.replace(/<[^>].*?>/g,"").substr(0,26)+'...</td>');
        }else{
        	row.push('<td class="rcontent">'+v.rcontent.replace(/<[^>].*?>/g,"").substr(0,26)+'</td>');
        }
        row.push('<td class="rtime">'+getformatdate(v.rtime)+'</td>');
        if(v.status==1){
        	row.push('<td class="status">屏蔽状态</td>');
        }else{
        	row.push('<td class="status">正常状态</td>');
        }
        if(v.status==1){
        	row.push('<td class="op">&nbsp;&nbsp;[<a href="/admin/revert/detail.html?rid='+v.rid+'">详情</a>]&nbsp;&nbsp;[<a href=/admin/revert/edit.html?rid='+v.rid+'>编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.rid+',0)" >恢复正常</a>]&nbsp;&nbsp;[<a href="#" onclick="return _del('+v.rid+')" >删除</a>]</td>');
        }else{
        	row.push('<td class="op">&nbsp;&nbsp;[<a href="/admin/revert/detail.html?rid='+v.rid+'">详情</a>]&nbsp;&nbsp;[<a href=/admin/revert/edit.html?rid='+v.rid+'>编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.rid+',1)" >屏蔽回贴</a>]&nbsp;&nbsp;[<a href="#" onclick="return _del('+v.rid+')" >删除</a>]</td>');
        }    
	    row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th width="10%">主贴标题</th>
<th width="15%">所属教室</th>
<th>回帖用户</th>
<th width="25%">回帖内容</th>
<th width="13%">回帖时间</th>
<th width="6%">帖子状态</th>
<th width="20%">操作</th>
</tr>
<tbody class="moduletbody"><tr class="tr_module_1" />
<th class="sn">1</th>
<td class="sn"><input type="checkbox" name="item[]" value="1" /></td>
<td class="subject"></td>
<td class="crname"></td>
<td class="username"></td>
<td class="rcontent">大家有什么问题可以在此主题提出。</td>
<td class="rtime">2012-01-09 11:12:18</td>
<td class="status">正常状态</td>
<td class="op">
&nbsp;&nbsp;[<a href="#">详情</a>]
&nbsp;&nbsp;[<a href="#">编辑</a>]
&nbsp;&nbsp;[<a href="#" >屏蔽回贴</a>]
&nbsp;&nbsp;[<a href="#" onclick="#" >删除</a>]
</td>
</tr>

</tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
<th width="12%">批量操作</th>
<th><input type="checkbox" name="chkall" id="chkall" onclick="#"><label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label for="noop">不操作</label></th>
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
    $.post("/admin/revert/getListAjax.html",
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

function changestatus(rid,status){
	$.post('/admin/revert/changestatus.html',
			{rid:rid,status:status},
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

function _del(rid){
	$.messager.prompt('提示信息', '请输入验证码 : '+rid, function(r){
		if (r==rid){
			$.post('/admin/revert/deleteByrid.html',{rid:rid},function(message){
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

<?php $this->display('admin/footer');?>