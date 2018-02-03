<form id="ck">
    <table cellspacing="0" cellpadding="0" class="toptable"><tr><td>
	<label>只列出当前学校</label><input type="checkbox" id="onlycur" checked="checked" onclick="_search()"/>
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
        var row = ['<tr style="cursor:pointer" pid='+v.pid+' summary="'+v.summary+'" crname="'+v.crname+'" crid="'+v.crid+'" comfeepercent="'+v.comfeepercent+'"   roomfeepercent="'+v.roomfeepercent+'" providerfeepercent="'+v.providerfeepercent+'" onclick="_getTInfo(this,\''+v.pname+'\')">'];
        row.push('<td>'+v.pname+'</td>');
        row.push('<td>'+v.crname+'</td>');
        row.push('<td>'+getformatdate(v.dateline)+'</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>


<div style="margin-left:auto;margin-right:auto;width:100%">
<table align="center" border="1" cellspacing="0" cellpadding="0" class="listtable">
<tr>
<td>服务包名称</td>
<td>所属平台</td>
<td>添加时间</td>
</tr>
<tbody class='moduletbody'>
</tbody>
</table>
<div id="pp"></div>
<script type="text/javascript">
$(function(){
	var crid = <?=$currentcrid?>;
    $.post("/admin/servicepack/getListAjax.html",
            {query:'',pageNumber:1,pageSize:10,crid:crid},
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
		var crid = 0;
		if($('#onlycur').prop('checked')){
			crid = <?=$currentcrid?>;
		}
        $.post("/admin/servicepack/getListAjax.html",
            {query:query,pageNumber:pageNumber,pageSize:pageSize,crid:crid},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
        return false;
    }
});
function _getTInfo(e,pname){
    $('#pname').val(pname);
	var oldcrid = $('#mediaid').val();
	var crid = $(e).attr('crid');
	var pid = $(e).attr('pid');
    $('#crid').val(crid);
    $('#pid').val(pid);
	
	$('#mediaid').val(crid);
	$('#crname').val($(e).attr('crname'));
	
	$('#isummary').val($(e).attr('summary'));
	if(oldcrid != crid){
		showfolder(crid);
	}
	showsort(pid);
	comfeepercent = $(e).attr('comfeepercent');
	roomfeepercent = $(e).attr('roomfeepercent');
	providerfeepercent = $(e).attr('providerfeepercent');
	$('#pname').focus();
    $('.panel-tool-close').trigger('click');
}
</script>