<?php
$this->display('admin/header');
?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1 style="width:550px;">课件管理 -  课件列表</h1></td>
        <td class="actions" >
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td ><a href="/admin/courseware.html">浏览课件信息</a></td>
            <td ><a href="/admin/courseware/add.html" class="add">添加课件</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form id='ck' onsubmit="return _search()">
<input type="hidden" id="status" name="status" value="" />
<div id="newslisttab">
<ul>
<li class=active><a href="#">所有状态</a></li>
<li class=><a href="#" status="0">待审箱</a></li>
<li class=><a href="#" status="1">已审箱</a></li>
<li class=><a href="#" status="-1">退审箱</a></li>
<li class=><a href="#" status="-2">禁用箱</a></li>
<li class=><a href="#" status="-3">已删除</a></li>
  </ul>
</div><table cellspacing="0" cellpadding="0" class="toptable"><tr><td>        
<select name="catid" id="catid">
        <option value="0" >所有分类</option>
        <?php $this->widget('category_widget',array('where'=>array('position'=>'1'),'tag'=>'catid'));?>
        </select>&nbsp;&nbsp;<label>关键字: <input type="text" name="q" id="searchkey" value="" size="20" />
</label>
<label>&nbsp;&nbsp;置顶：
<select name='top'>
    <option value="">全部</option>
    <option value="0">非置顶</option>
    <option value="1">置顶Ⅰ</option>
    <option value="2">置顶Ⅱ</option>
    <option value="3">置顶Ⅲ</option>
</select>
</label>
<label>&nbsp;&nbsp;精华：
<select name='best'>
    <option value="">全部</option>
    <option value="0">非精华</option>
    <option value="1">精华Ⅰ</option>
    <option value="2">精华Ⅱ</option>
    <option value="3">精华Ⅲ</option>
</select>
</label>
<label>&nbsp;&nbsp;热门：
<select name='hot'>
    <option value="">全部</option>
    <option value="0">非热门</option>
    <option value="1">热门Ⅰ</option>
    <option value="2">热门Ⅱ</option>
    <option value="3">热门Ⅲ</option>
</select>
</label>
&nbsp;&nbsp;

<input type="submit" name="selectsubmit" value="查询" class="submit">
</td></tr>
</table>
</form>


<script type="text/javascript">
    var _status={'_-1':'已退审','_0':'待审核','_1':'正常','_-2':'已禁用','_-3':'已删除'};
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.cwid+'" />');
        row.push('<td class="title">'+v.title+'</th>');
        row.push('<td class="title">'+(v.sub_title||'')+'</th>');
        row.push('<td class="realname">'+v.realname+'</td>');
        row.push('<td class="catname">'+(v.name||'')+'</td>');
        row.push('<td class="price">'+v.price+'</td>');
        row.push('<td class="top">'+(v.top||'')+'</td>');
        row.push('<td class="best">'+(v.best||'')+'</td>');
        row.push('<td class="hot">'+(v.hot||'')+'</td>');
        row.push('<td>'+(getformatdate(v.dateline)||'')+'</td>');
        row.push('<td class="viewnum">'+v.viewnum+'</td>');
        row.push('<td class="status">'+_status['_'+v.status]+'</td>');
        row.push('<td class="nowrap" >');
        row.push('[<a href="javascript:void(0)" onclick="study(\''+v.cwsource+'\','+v.cwid+',\''+v.title+'\','+v.status+')">播放</a>]');
        row.push('&nbsp;[<a href="/admin/courseware/view.html?crid='+v.cwid+'">详情</a>]&nbsp;[<a href="/admin/courseware/edit.html?crid='+v.cwid+'">编辑</a>]&nbsp;[<a href="#" onclick="return destroy('+v.cwid+')">删除</a>]&nbsp;');
        if(v.status==1){
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',0)">锁定</a>]&nbsp;');
         }else if(v.status==0||v.status==-1){
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">审核</a>]&nbsp;');
         }else if(v.status==-2){
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">解禁</a>]&nbsp;');
         }else if(v.status==-3){
            row.push('[<a href="#" onclick="return changestatus('+v.cwid+',1)">恢复</a>]&nbsp;');
         }
       
        row.push('</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.title" width="21%">课件标题</th>
<th fieldname="i.sub_title" width="20%">课件副标题</th>
<th fieldname="i.realname">所属教师</th>
<th fieldname="i.catname" width="12%">所属分类</th>
<th fieldname="i.price" width="5%">价格</th>

<th fieldname="i.price" width="6%">置顶</th>
<th fieldname="i.price" width="6%">精华</th>

<th fieldname="i.price" width="7%">热门</th>
<th fieldname="i.dateline" width="15%">添加时间</th>
<th fieldname="i.viewnum" width="3%">点播数</th>
<th fieldname="i.status" width="12%">状态</th>
<th>操作</th>
</tr>
<tbody class="moduletbody"></tbody>
</table>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input id="chkall" type="checkbox" name="chkall"><label for="chkall">全选</label>
<input id="noop" name="optype" type="radio" value="0" checked /><label for="noop">不操作</label>&nbsp;&nbsp;
</th></tr>
</table>
<div id="pp"></div>
<div class="buttons">
<input type="submit" name="crsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>

</body>
<script type="text/javascript">
$(function(){
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
        $.post("/admin/courseware/getListAjax.html",
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

$(function(){
    $("#newslisttab a").click(function(){
        $('#status').val($(this).attr('status'));
        $("#newslisttab li").prop('class','');
        $(this).parent('li').prop('class','active');
        $(".pagination-page-list").trigger('change');
        return false;
    });
});
function changestatus(cwid,status){
    if (cwid){
        $.post('<?php echo geturl('admin/courseware/editcourseware');?>',
            {cwid:cwid,status:status},
            function(result){
                    if (result==1){
                      $('.pagination-page-list').trigger('change');
                    } else {
                        $.messager.show({    // show error message
                            title: 'Error',
                            msg: result
                        });
                    }
            });
    }
    return false;
}
function destroy(cwid){
    if (cwid){
        $.messager.confirm('确认','确定要删除该课件么？',function(r){
            if (r){
                $.post('<?php echo geturl('admin/courseware/del');?>',{cwid:cwid},function(result){
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
                            msg: result.errorMsg
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
</script>
<?php
$this->display('admin/footer');
?>