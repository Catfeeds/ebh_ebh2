<?php
	$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>会员服务记录 - 学习记录</h1></td>
	</tr>
</table>

</script>


<form method="GET" id="ck" onsubmit="return _search()">

<table cellspacing="2" cellpadding="2" class="helptable"><tbody><tr><td><ul>
<li>关键字搜索，目前支持:事件描述的模糊搜索。</li>
</ul></td></tr></tbody></table><table cellspacing="0" cellpadding="0" class="toptable">
<tr><td>
<label>日期：</label>
<input type="text" id="begintime" name="begintime" value="" size="20" onfocus="$(this).datetimebox()" /> - 
<input type="text" id="endtime" name="endtime" value="" size="20" onfocus="$(this).datetimebox()" />

<label>关键字: </label><input type="text" name="searchkey" id="searchkey" value="" size="20" />
<input type="submit" name="selectsubmit" value="查询" class="submit">
</td></tr>
</table>
</form>

<form method="post" name="listform" id="theform" action="" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tbody class="agentbody"><tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.uid" width="10%">点播人</th>
<th fieldname="i.toid">点播课程</th>
<th fieldname="i.opname">产生费用</th>
<th fieldname="i.fromip">操作IP</th>
<th fieldname="i.[dateline]">提交日期</th>
</tr>
</tbody>
<script type="text/javascript">
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_logs" />'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.chargeid+'" /></td>');
        row.push('<td class="uid">'+v.username+'</td>');
        row.push('<td class="title" nowrap>'+v.title+'</td>');
        row.push('<td class="price">'+v.price+'</td>');
        row.push('<td class="fromip">'+v.fromip+'</td>');
        row.push('<td class="datetime" nowrap>'+getformatdate(v.dateline)+'</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<tbody class="moduletbody"> 
</tbody>
</table>
<div id="pp"></div>
<table cellspacing="0" cellpadding="0" width="100%"  class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input type="checkbox" name="chkall" id="chkall" onclick="#"><label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label for="noop">不操作</label>
</th></tr>
<tr id="divnoop" style="display:none"><td></td><td></td></tr>
</table>


<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>

</form>
<script type='text/javascript'>
	$.fn.datetimebox.defaults.formatter = function(date){
      var y = date.getFullYear();
      var m = date.getMonth()+1;
      var d = date.getDate();
      var h = date.getHours();
      var f = date.getMinutes();
      return y+'-'+m+'-'+d+' '+h+':'+f;
    }
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
        $.post("/admin/study/getListAjax.html",
            {query:query,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                // $('#dd').datagrid({'data':message});
                _render(message);
            }
            );
        return false;
    }
    });

</script>
<br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>

	
<?php 
	$this->display('admin/footer')
?>