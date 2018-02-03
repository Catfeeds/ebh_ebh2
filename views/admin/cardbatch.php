<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">充值卡批次管理 -  批次列表</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="admin.php?token=5b344bc40f3bc04f&action=cardbatch">浏览充值卡批次</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">
<tr>
<td>
<label>批次号：</label><input type="text" name="searchkey" id="searchkey" value="" size="20" />&nbsp;&nbsp;
<label>面值: </label><?=$priceSelect?>&nbsp;&nbsp;
<label>状态：</label><select name="status">
<option value="">请选择</option>
<option  value="0">正常</option>
<option  value="-1">已锁</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label>代理商: </label>
<?=$agentSelect?>
<br />
<label>创建时间范围：</label>
<input type="text" id="begindateline" name="begindateline" value="" size="20" maxlength="10" onfocus="" /> ~
<input type="text" id="enddateline" name="enddateline" value="" size="20" maxlength="10" onfocus="" />&nbsp;&nbsp;
<label>最后修改时间范围：</label>
<input type="text" id="beginlastmodified" name="beginlastmodified" value="" size="20" maxlength="10" onfocus="" /> ~
<input type="text" id="endlastmodified" name="endlastmodified" value="" size="20" maxlength="10" onfocus="" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" name="selectsubmit" value="  查询  " class="submit">（支持模糊查询）
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
    	var row=['<tr class="tr_module_1 " />'];
    	row.push('<th class="sn">'+(k+1)+'</th>');
    	row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.bid+'" /></td>');
    	row.push('<td>'+v.bname+'</td>');
    	row.push('<td>'+v.uidname+'</td>');
    	row.push('<td>'+getformatdate(v.dateline)+'</td>');
    	row.push('<td>'+(v.lastmodifiedname||'')+'</td>');
    	if(v.lastmodified>0){
    		row.push('<td>'+getformatdate(v.lastmodified)+'</td>');
    	}else{
    		row.push('<td></td>');
    	}
    	
    	row.push('<td>'+v.price+'</td>');
    	if(v.status==-1){
    		row.push('<td>锁定</td>');
    	}else{
    		row.push('<td>正常</td>');
    	}
    	
    	row.push('<td>'+(v.agentidname||'')+'</td>');
    	row.push('<td class="op">[<a href="/admin/cardbatch/detail.html?op=view&bid='+v.bid+'">查看</a>]&nbsp;&nbsp;[<a href="/admin/cardbatch/detail.html?op=edit&bid='+v.bid+'">修改</a>]&nbsp;&nbsp;');
    	if(v.status==-1){
    		row.push('[<a href="#" onclick="changestatus(0,'+v.bid+')"><span>解锁</span></a>]');
    	}else{
    		row.push('[<a href="#" onclick="changestatus(-1,'+v.bid+')"><span>锁定</span></a>]');
    	}
    	
    	row.push('&nbsp;&nbsp;[<a href="/admin/card.html?bname='+v.bname+'">查看列表</a>]</td>');
    	row.push('</tr>');
        return row.join('');
    }
</script>
<form method="post" name="listform" id="theform" action="">
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="bname">批次号</th>
<th fieldname="uid">创建批次的帐户名</th>
<th filedname="dateline">创建时间</th>
<th fieldname="lastmodifieduid">最后修改的账户名</th>
<th filedname="lastmodified">最后修改时间</th>
<th filedname="price">面值</th>
<th filedname="status">状态</th>
<th filedname="agentid">代理商</th>
<th filedname="caozuo">操作</th>
</tr>
<tbody class="moduletbody"></tbody>
</table>
<div id="pp"></div>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
<th width="12%">批量操作</th>
<th><input id="chkall" type="checkbox" name="chkall" onclick="#">
	<label for="chkall">全选</label>
	<input id="noop" name="optype" type="radio" value="0" checked /><label for="noop">不操作</label>&nbsp;&nbsp;
	<input id="sortop" name="optype" type="radio" value="lock" /> <label for="sortop">锁定</label>
	<input id="sortop" name="optype" type="radio" value="unlock" /> <label for="sortop">解锁</label>
</th>
</tr>
</table><br>
<script>
$(function(){
    $("#begindateline,#enddateline,#beginlastmodified,#endlastmodified").focus(function(){
    	$(this).datebox({showSeconds:false});
    });
    $("#begindateline,#enddateline,#beginlastmodified,#endlastmodified").trigger('focus');
    $(".pagination-page-list").trigger('change');
});
function _search(){
	$('#pp').pagination({pageNumber:1});
    $(".pagination-page-list").trigger('change');
    return false;
}

$('#pp').pagination({
pageSize:10,
onSelectPage:function(pageNumber, pageSize){
    var query = $('#ck').serialize();
    $.post("/admin/cardbatch/getListAjax.html",
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
function changestatus(status,bid){
	$.post('/admin/cardbatch/changeStatus.html',{status:status,bid:bid},function(message){
		$('.pagination-page-list').trigger('change');
	});
	return false;
}
</script>
</body>

<?php $this->display('admin/footer');?>