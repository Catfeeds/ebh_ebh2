<form id="ck">
    <table cellspacing="0" cellpadding="0" class="toptable"><tr><td>
    <label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
    <span>
    <input type="button" onclick="return _search()" value="搜索"/>
    </td></tr>
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
        var row = ['<tr style="cursor:pointer" tid='+v.tid+' tsummary="'+v.tsummary+'" crname="'+v.crname+'" crid="'+v.crid+'" onclick="_getTInfo(this,\''+v.tname+'\')">'];
        row.push('<td>'+v.tname+'</td>');
        row.push('<td>'+v.crname+'</td>');
        row.push('<td>'+getformatdate(v.dateline)+'</td>');
		row.push('<td>'+v.status+'</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>


<div style="margin-left:auto;margin-right:auto;width:100%">
<table align="center" border="1" cellspacing="0" cellpadding="0" class="listtable">
<tr>
<td>服务期名称</td>
<td>所属平台</td>
<td>添加时间</td>
<td>状态</td>
</tr>
<tbody class='moduletbody'>
</tbody>
</table>
<div id="pp"></div>
<script type="text/javascript">
$(function(){
    $.post("/admin/spterm/getListAjax.html",
            {query:'',pageNumber:1,pageSize:10},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
    return false;
});
function _search(){
   $('#pp').pagination({pageNumber:1});
   $(".pagination-page-list").trigger('change');
   return false;
}
$('#pp').pagination({
    pageSize:10,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#searchkey').val();
        $.post("/admin/spterm/getListAjax.html",
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
function _getTInfo(e,tname){
    $('#tname').val(tname);
	var tid = $(e).attr('tid');
    $('#tid').val(tid);
	
	$('#tname').focus();
    $('.panel-tool-close').trigger('click');
	try{
		$('#mediaid').val($(e).attr('crid'));
		$('#crname').val($(e).attr('crname'));
	}catch(err){
	}
}
</script>