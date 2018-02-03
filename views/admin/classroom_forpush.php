<?php
$this->display('admin/header');
?>
<body>
<form id="ck">
<div id="toolbar">
	<input id="search-input" type="text" name="q" onkeypress="presstosearch(event);"/>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="return _search()" >搜索</a>
</div>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.crid+'" /></td>');
        row.push('<td class="crname">'+v.crname+'</td>');
        row.push('<td class="nickname">'+v.nickname+'</td>');
        row.push('<td class="domain">'+v.domain+'</td>');
        row.push('<td class="agentname">'+(v.agentname||'')+'</td>');
        row.push('<td class="maxnum">'+v.maxnum+'</td>');
        row.push('<td class="begindate">'+getformatdate(v.begindate).substr(0,10)+'</td>');
        row.push('<td class="enddate">'+getformatdate(v.enddate).substr(0,10)+'</td>');
        if(v.status==1){
        	row.push('<td class="status">正常</td>');
        }else{
        	row.push('<td class="status">锁定</td>');
        }
       
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.crname">网校名</th>
<th fieldname="i.nickname">教师名</th>
<th fieldname="i.domain">域名</th>
<th filedname="i.agentname">代理商</th>
<th fieldname="i.maxnum" width="10%">网校容量</th>
<th fieldname="i.begindate" width="10%">开始时间</th>
<th fieldname="i.enddate" width="10%">结束时间</th>
<th fieldname="i.status" width="5%">状态</th>
</tr>
<tbody class="moduletbody">
<tr class="tr_module" />
<th class="sn">1</th>
<td class="sn"><input type="checkbox" name="item[]" value="10398" /></td>
<td class="crname">某之</td>
<td class="nickname">u</td>
<td class="domain">zxc</td>
<td class="agentname"></td>
<td class="maxnum">100</td>
<td class="begindate">2014-04-09</td>
<td class="enddate">2015-04-09</td>
<td class="status">正常</td>
<td class="displayorder"><input type="input" width="30" name="displayorder[]" value="0" /></td> <td class="nowrap" >[<a href="#">添加子网校</a>][<a href="#">详情</a>] [<a href="#">编辑</a>] [<a href="#">删除</a>] [<a href="#" >锁定</a>]&nbsp;
</td>
</tr>
</tbody>
</table>

<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tbody><tr><th width="12%">批量操作</th><th>
<input id="chkall" type="checkbox" name="chkall"><label for="chkall">全选</label>
<input id="noop" name="optype" type="radio" value="0" checked=""><label for="noop">不操作</label>
</th></tr>
</tbody></table>
<div id="pp"></div>
<div class="buttons">
<input type="submit" name="crsubmit" value="提交保存" onclick="push()" class="submit">
<input type="reset" name="listreset" value="重置">
</div>
<script type="text/javascript">
$(function(){
    $(".pagination-page-list").trigger('change');
});
$(function(){
    $("#newslisttab a").click(function(){
        $('#status').val($(this).attr('status'));
        $("#newslisttab li").prop('class','');
        $(this).parent('li').prop('class','active');
        $(".pagination-page-list").trigger('change');
        return false;
    });

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
        $.post("/admin/classroom/getListAjax.html",
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

		
function dosearch(){
	$.get('<?php echo geturl('admin/classroom/getlist');?>',{'param[q]':$("#search-input").val()},function(data){
		var data = eval(data);
		data.pop();
		_render(data);
	}
	);
}

$("#chkall").click(function(){
    $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});

function push(){
    var ckboxs = $(":checkbox[name='item[]']:checked");
    var res='';
    $.each(ckboxs,function(i,v){
        res+=';'+v.value;
    });
    if(res!=""){
        $.post('/admin/particles/push.html',{crids:res,itemid:<?=$itemid?>},
            function(message){
                if(message>0){
                    $.messager.alert("操作提示", "操作成功！", "info", function () {
                         parent.window.closedialog();
                    });
                }else{
                   $.messager.alert("操作提示", "操作失败！", "info", function () {
                         parent.window.closedialog();
                    });
                }
               
        });
    }
}
</script>
    
</body>
<?php
$this->display('admin/footer');
?>