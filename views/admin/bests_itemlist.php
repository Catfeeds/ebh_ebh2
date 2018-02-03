<?php
$this->display('admin/header');
?>
<style type="text/css">
    .listtable td {
    text-align: center;
}
td.nickname{
    width: 200px;
    line-height: 29px;
}
</style>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>精品课堂管理 - 精品课列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="<?php echo geturl('admin/jingpin');?>">浏览</a></td>
            <td ><a id="addbtn" href="javascript:void(0)" onclick="showaddin('/admin/jingpin/addsort.html','添加分类')" class="add">添加分类</a>
            </td>
            <td ><a id="addbtn1" href="javascript:void(0)" onclick="showaddin('/admin/jingpin/add.html','添加精品课堂')" class="add">添加精品课堂</a>
            </td>  
             <td ><a id="addbtn2" href="javascript:void(0)" onclick="showaddin('/admin/jingpin/editlabel.html','修改分类及标签(请先选择对应的分类)')" class="add">修改分类及标签</a>
            </td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td>
	
	<label >所属学校</label>
        <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
        <input type="button" id="drop" value="选择" />
        <input type="button" id="clear" value="清除" />
        <input type="hidden" name="crid" id="mediaid"  value="0" />
	<label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="_search()" >搜索</a>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.uid+'" /></td>');
        row.push('<td class=username><span style=\'color:red\'>'+v.iname+'</span></td>');
        //row.push('<td class="realname"><a href="javascript:showsp('+v.pid+')">'+(v.pname||'')+'</a></td>');
		//row.push('<td class="mobile"><a href="javascript:showst('+v.tid+')">'+(v.tname||'')+'</a></td>');
		row.push('<td class="mobile">'+(v.crname||'')+'</td>');
        row.push('<td class="nickname">'+(v.iprice||'')+'</td>');
        
		
        row.push('<td class="i.dateline">'+((v.imonth>0)?v.imonth+'月':v.iday+'天')+'</td>');
		row.push('<td class="status">'+getformatdate(v.dateline)+'</td>');
       
        row.push('<td class="op">&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/jingpin/view.html?itemid='+v.itemid+'\',\'精品课堂\')">详情</a>]&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showaddin(\'/admin/jingpin/edit.html?itemid='+v.itemid+'\',\'编辑精品课堂\')">编辑</a>]&nbsp;&nbsp;[<a href="#" onclick="return checkHasBuy('+v.itemid+')" >删除</a>]</td>');
        
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th width="5%" >序号</th>
<th width="5%" >选择</th>
<th width="10%" >精品课堂名称</th>
<th width="12%" >所属学校</th>
<th width="10%" >价格</th>
<th width="10%" >持续时间</th>
<th width="10%" >创建日期</th>

<th width="10%" >操作</th>
</tr>
<tbody class="moduletbody">
</tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
<th width="12%">批量操作</th>
<th><input type="checkbox" name="chkall" id="chkall" >
<label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label
for="noop">不操作</label></th>
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
<br>
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
</body>
<script type="text/javascript">
var addurl = '/admin/jingpin/add.html';
var s_pid = 0;
var s_crid = 0;
$(function(){
    $(".pagination-page-list").trigger('change');
	s_crid = $('#mediaid').val();
	//$('#addbtn').attr('onclick',"showaddin('/admin/jingpin/add.html?','添加精品课堂')");
});
function _search(){
	$('#pp').pagination({pageNumber:1});
	$(".pagination-page-list").trigger('change');
	s_crid = $('#mediaid').val();
	return false;
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#searchkey').val();
		var providercrid = $('#mediaid').val();
        $.post("/admin/jingpin/getListAjax.html",
            {query:query,providercrid:providercrid,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                
            }
            );
        return false;
    }
});

function checkHasBuy(itemid) {
     $.ajax({
            type: "POST",
            url: "/admin/jingpin/checkHasBuy.html",
            data: {
                itemid:itemid
            },
            dataType: "json",
            success: function(data) {
                if(data.hasbuy == 1){
                     var mess = '该课程已经有人报名，不能被删除！！！';
                     alert(mess);
                     return false;
                    }
                else {
                    delitem(itemid);
                }
            },
            error: function(jqXHR){     
               alert("发生错误：" + jqXHR.status); 
               return true; 
            }    
                            
        });
}

function delitem(itemid){
    if (itemid){
        $.messager.confirm('确认','没人报名！！！确定要删除该精品课堂么？',function(r){
            if (r){
                $.post('/admin/jingpin/del.html',{itemid:itemid},function(result){
                    if (result.success){
                        $.messager.show({    
                            timeout:800,
                            title: '成功',
                            msg: '删除成功'
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
    return false;
}
$("#chkall").click(function(){
    $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});


$('#drop').click(function(){
       showcr();  
    });
function showcr(){
        var url = '/admin/classroom/roomselect.html';
        var width = $(window).width();
        var height = $(window).height();
        $('#cr')
        .attr('width',width/5*3)
        .attr('height',height/5*3)
        .attr('src',url);
        $('#crwrap').show();
        $('#crwrap').dialog({    
            title: '请选择教室', 
            closed: false,    
            cache: false,   
            modal: true   
        });
        return false;
    }
	$('#clear').click(function(){
        $('#mediaid').val("");
        $('#crname').val("");
		_search();
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
    }
function showaddin(url,title){
    
	height = 666;
	width = 800;
	var html = '<iframe scrolling="auto" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'"></iframe>';
	artDialog({
		title : title,
		width : width,
		height : height,
		content : html,
		padding : 10,
		resize : false,
		lock : true,
		opacity : 0.2,
		
	});
}
</script>
<?php
$this->display('admin/footer');
?>