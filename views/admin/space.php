<?php
$this->display('admin/header');
?>
<body>
    
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">原创空间管理 -  原创空间列表</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="#">浏览原创空间作品信息</a></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
    <form id="ck" onsubmit="return _search();">
    	<table cellspacing="0" cellpadding="0" class="toptable"><tr><td>        &nbsp;&nbsp;<label>账号: <input type="text" name="username" id="username" value="" size="20" />
</label>
&nbsp;&nbsp;<label>关键字: <input type="text" name="q" id="searchkey" value="" size="20" />
</label>
<label>&nbsp;&nbsp;置顶：
<select name='top'>
<option value="">全部</option>
        <option value="1" >置顶Ⅰ</option>
        <option value="2" >置顶Ⅱ</option>
        <option value="3" >置顶Ⅲ</option>
        </select>
        </label>
        <label>&nbsp;&nbsp;精华：
        <select name='best'>
        <option value="">全部</option>
        <option value="1" >精华Ⅰ</option>
        <option value="2" >精华Ⅱ</option>
        <option value="3" >精华Ⅲ</option>
        </select>
        </label>
        <label>&nbsp;&nbsp;热门：
        <select name='hot'>
        <option value="">全部</option>
        <option value="1" >热门Ⅰ</option>
        <option value="2" >热门Ⅱ</option>
        <option value="3" >热门Ⅲ</option>
        </select>
        </label>
        	
<input type="submit" name="selectsubmit" value="查询" class="submit">
</td></tr>
</table>
</form>
<script type="text/javascript">
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
        $(".bigpic,#listtable .sn a").lightBox();
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_module">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.id+'" /></td>');
        if(v.image){
            row.push('<td class="sn">'+'<a href="<?= $showpath ?>'+v.image+'" title="'+v.title+'"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></a>'+'</td>')
        }else{
            row.push('<td class="sn"></td>');
        }
        row.push('<td class="title">'+v.title+'</td>');
        row.push('<td class="username">'+v.username+'</td>');
        if(v.ispublic==1){
        	row.push('<td class="ispublic">公开</td>');
        }else{
        	row.push('<td class="ispublic">不公开</td>');
        }
        
        row.push('<td class="score">'+v.score+'</td>');
        row.push('<td class="votenum">'+v.votenum+'</td>');
        row.push('<td class="reviewnum">'+v.reviewnum+'</td>');
        row.push('<td class="top">'+v.top+'</td>');
        row.push('<td class="best">'+v.best+'</td>');
        row.push('<td class="hot">'+v.hot+'</td>');
        row.push('<td>'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="order" width="4%"><input style="width: 40px;" name="order['+v.id+']" value="'+v.displayorder+'"/></td>');
        row.push('<td class="nowrap" >[<a href="<?= $showpath ?>'+v.image+'" title="'+v.title+'" class="bigpic">大图</a>]&nbsp;[<a href=/admin/space/edit.html?id='+v.id+'>编辑</a>]&nbsp;[<a href="#" onclick="destroy('+v.id+')">删除</a>]&nbsp;</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th class="sn"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></th>
<th fieldname="i.title" width="21%">文件名称</th>
<th fieldname="i.username" width="12%">账号</th>
<th fieldname="i.ispublic" width="5%">是否公开</th>
<th fieldname="i.score">当前得分</th>
<th fieldname="i.votenum" width="5%">投票数</th>
<th fieldname="i.reviewnum" width="5%">评论数</th>

<th fieldname="i.top" width="6%">置顶</th>
<th fieldname="i.best" width="6%">精华</th>
<th fieldname="i.hot" width="7%">热门</th>
<th fieldname="i.dateline" width="15%">添加时间</th>
<th fieldname="i.displayorder" width="5%">排序号</th>
<th>操作</th>
</tr>
<tbody class="moduletbody" id="listtable">
</tbody>
</table>
<form onsubmit="return whatOp();">
<table cellspacing="0" cellpadding="0" width="100%"  class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input type="checkbox" name="chkall" id="ckhead"><label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label for="noop">不操作</label>
<input type="radio" name="operation" value="top" id="top"><label for="top">置顶</label>
<input type="radio" name="operation" value="hot" id="hot"><label for="hot">热门</label>
<input type="radio" name="operation" value="best" id="best"><label for="best">精华</label>
<input type="radio" name="operation" value="del" id="del"><label for="del">删除</label>
<input type="radio" name="operation" value="moveorder" id="moveorder"><label for="moveorder">排序</label>
</th></tr>
<tr id="divnoop" style="display:none"><td></td><td></td></tr>
<tr id="divtop" style="display:none">
<th>置顶</th>
<td><input name="optop" type="radio" value="0" checked />非置顶&nbsp;&nbsp;<input name="optop" type="radio" value="1" />置顶I&nbsp;&nbsp;<input name="optop" type="radio" value="2" />置顶II&nbsp;&nbsp;<input name="optop" type="radio" value="3" />置顶III&nbsp;&nbsp;</td>
</tr>
<tr id="divhot" style="display:none">
<th>热门</th>
<td><input name="ophot" type="radio" value="0" checked />非热门&nbsp;&nbsp;<input name="ophot" type="radio" value="1" />热门I&nbsp;&nbsp;<input name="ophot" type="radio" value="2" />热门II&nbsp;&nbsp;<input name="ophot" type="radio" value="3" />热门III&nbsp;&nbsp;</td>
</tr>
<tr id="divbest" style="display:none">
<th>精华</th>
<td><input name="opbest" type="radio" value="0" checked />非精华&nbsp;&nbsp;<input name="opbest" type="radio" value="1" />精华I&nbsp;&nbsp;<input name="opbest" type="radio" value="2" />精华II&nbsp;&nbsp;<input name="opbest" type="radio" value="3" />精华III&nbsp;&nbsp;</td>
</tr>
<tr id="divdel" style="display:none">
<th>删除</th>
<td><input name="opdel" type="radio" value="0" checked />直接删除&nbsp;&nbsp;</td>
</tr>
</table>
<div id="pp"></div>
<div class="buttons">
<input type="submit" name="crsubmit" value="提交保存"  class="submit">
<input type="reset" name="listreset" value="重置">
</div>
</form>
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
    $.post("/admin/space/getListAjax.html",
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
function destroy(id){
    if (id){
        $.messager.confirm('确认','确定要删除该作品么？',function(r){
            if (r){
                $.post('/admin/space/del.html',{id:id},function(result){
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
}
		

//批量按钮点击展现子选项
$(function(){
    $(":radio[name='operation']").click(function(){
        var showDiv = 'div'+$(this).attr('value');
        if(showDiv=='divnoop'){
            $("tr[id^=div]").hide();
            return;
        }
        $("tr[id^=div]").hide();
        $('#'+showDiv).show();

    });
});
    //批量操作路由器
function whatOp(){
    var opTag = $(":radio[name='operation']:checked").val();
    if(opTag=='noop'){
        return false;
    }
    var op = opTag+'All';
    eval(op+'(opTag)');
    return false;
}
 //批量操作处理器
function moveorderAll(){
	var ckboxs = $(":checkbox[name='item[]']:checked");
    var idAndOrder='';
    $.each(ckboxs,function(i,v){
        idAndOrder+=';'+(v.value+','+$("input[name='order["+v.value+"]']").val());
    });
    $.post('/admin/space/moveorderAll.html',{idAndOrder:idAndOrder},function(message){
        return _note(message);
    });
    return false;
}

function delAll(){
    $.messager.confirm('确认对话框', '您确定要删除选中项吗？', function(r){
        if (r){
            var ckboxs = $(":checkbox[name='item[]']:checked");
            var res='';
            $.each(ckboxs,function(i,v){
                res+=';'+v.value;
            });
            $.post('/admin/space/delAll.html',{ids:res},function(message){
                return _note(message);
            });
        }else{
            return false;
        }
    });
    return false;
    
}

var topAll=bestAll=hotAll=function(op){
    var ckboxs = $(":checkbox[name='item[]']:checked");
    var res='';
    $.each(ckboxs,function(i,v){
        res+=';'+v.value;
    });
    var tag = $(":radio[name=op"+op+"]:checked").val();
    //op为best,top,hot用来标识置顶，精华，热门操作;
    //tag为0,1,2,3其中一个数字，用来标识置顶，精华，热门级别
    //res为选中的条目id 格式为 ;id1;id2;id3
    $.post('/admin/space/bthAll.html',{op:op,tag:tag,ids:res},function(message){
        return _note(message);
    });
    return false;
}


$("#ckhead").click(function(){
    $("input[name='item[]']").prop('checked',$("#ckhead").prop('checked'));
});

function _note(message){
    if(message){
            $.messager.show({
                title: "操作提示",
                msg: "批量操作成功!",
                showType: 'slide',
                timeout: 1000
            });
            $('.pagination-page-list').trigger('change');
            $("#ckhead").prop('checked',false);
            return false;
        }else{
            $.messager.show({
                title: "操作提示",
                msg: "批量操作失败!",
                showType: 'slide',
                timeout: 1000
            });
            $('.pagination-page-list').trigger('change');
            $("#ckhead").prop('checked',false);
            return false;
        }
}
</script>
<style type="text/css">
    #fm{
        margin:0;
        padding:10px 30px;
    }
    .ftitle{
        font-size:14px;
        font-weight:bold;
        padding:5px 0;
        margin-bottom:10px;
        border-bottom:1px solid #ccc;
    }
    .fitem{
        margin-bottom:5px;
    }
    .fitem label{
        display:inline-block;
        width:80px;
    }
</style>
</body>
<?php
$this->display('admin/footer');
?>