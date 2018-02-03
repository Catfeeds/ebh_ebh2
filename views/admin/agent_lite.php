<?php $this->display('admin/header');?>
<body id="main">
<form id='ck'>
<input type="hidden" name="action" value="usertreatment">
<table cellspacing="0" cellpadding="0" class="toptable"><tr><td>
<label>姓名关键字: </label><input type="text" name="searchkey" id="searchkey" value="" size="20" />
<span>
<input type="button" onclick="return _search();" value="搜索">
</td></tr>
</table>
</form>
<div class="main">

<script type="text/javascript">
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr style="cursor:pointer;" onclick="_getAgent(\''+v.username+'\','+v.agentid+')">'];
        row.push('<td>'+v.username+'</td>');
        row.push('<td>'+v.realname+'</td>');
        row.push('<td>'+(v.moblie||'无')+'</td>');
        row.push('<td>'+(v.address||'无')+'</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<table align="center" border="1" cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<td>账号</td>
<td>真实姓名</td>
<td>手机号码</td>
<td>地址</td>
</tr>
<tr style="cursor:pointer;" onclick="_getAgent('顶级代理',0)" class="">
<td>0</td>
<td>顶级代理</td>
<td>0</td>
<td>0</td>
</tr>
<tbody class="moduletbody">

</tbody>
</table>
<div id="pp"></div>
<script>

$(function(){
	    var query = $('#ck').serialize();
	    $.post("/admin/agent/getListAjax.html",
	        {query:query,pageNumber:1,pageSize:10},
	        function(message){
	            message = JSON.parse(message);
	            $('#pp').pagination('refresh',message.shift());
	             _render(message);
	            

	        }
	        );
	    return false;
});
function _search(){
    $(".pagination-page-list").trigger('change');
    return false;
}

$('#pp').pagination({
pageSize:10,
onSelectPage:function(pageNumber, pageSize){
    var query = $('#ck').serialize();
    $.post("/admin/agent/getListAjax.html",
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
function _getAgent(username,agentid){
	$("#username").val(username);
    $("#mediaid").val(agentid);
	$('#dd').dialog('close');
}
</script>
</body>
<?php $this->display('admin/footer');?>