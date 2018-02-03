<?php
 $this->display('admin/header');
?>
<body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr>
            <td><h1>文章管理 - 文章列表</h1></td>
            <td class="actions">
                <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
                <tbody><tr>
                <td class="active"><a href="/admin/particles.html">浏览文章</a></td>
                <td><a href="/admin/particles/add.html" class="add">添加文章</a></td>
                </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table>
<div id="newslisttab">
<ul>
    <li class="active"><a href="/admin/particles/index.html" >所有状态</a></li>

    <li class="" status=2><a href="/admin/particles/index.html">锁定状态</a></li>

    <li class="" status=1><a href="/admin/particles/index.html">正常状态</a></li>
</ul>
  
</div>
<form method="GET" action="#"  id='ck' onsubmit="return _search()">
    <input type="hidden" name ="status" id="status" value="" /> 
    <input type="hidden" name="order" value="i.lastpost desc"/>
    <input type="hidden" name="type" value="news" /> 
<table cellspacing="0" cellpadding="0" class="toptable">
        <tbody><tr><td>
        <?=$pselect?>
        
        &nbsp;&nbsp;
       
        <select name="top" id="select_top">
        <option value="0">非置顶</option>
        <option value="1">置顶Ⅰ</option>
        <option value="2">置顶Ⅱ</option>
        <option value="3">置顶Ⅲ</option>
        </select>
        <select name="best" id="select_best">
        <option value="0">非精华</option>
        <option value="1">精华Ⅰ</option>
        <option value="2">精华Ⅱ</option>
        <option value="3">精华Ⅲ</option>
        </select>
        <select name="hot" id="select_hot">
        <option value="0">非热门</option>
        <option value="1">热门Ⅰ</option>
        <option value="2">热门Ⅱ</option>
        <option value="3">热门Ⅲ</option>
        </select>
        
  
        
        <label>关键字: </label><input id="search-input" type="text" name="q" value=""/>
        <a href="javascript:void(0)" id ='search' class="easyui-linkbutton" iconCls="icon-search" onclick="return _search();" >搜索</a>
        </td></tr></tbody>
</table>
</form>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>

<form method="post" name="listform" id="theform" action="" onsubmit="return whatOp();">

<table cellspacing="0" cellpadding="0" width="100%" class="listtable" id="listtable">
<tbody><tr class="">
<th>序号</th>
<th>选择</th>
<th class="sn"><img src="http://static.ebanhui.com/ebh/images/base/haveattach.gif"></th>
<th class="sn"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></th>
<th fieldname="i.name" width="25%">标题</th>
<th fieldname="i.type">分类</th>
<th fieldname="i.identifier">置顶</th>
<th fieldname="i.identifier">热门</th>
<th fieldname="i.identifier">精华</th>
<th fieldname="i.identifier">状态</th>
<th fieldname="i.[lang]">来源</th>
    <th fieldname="i.order" width="2%">排列顺序</th>
<th fieldname="i.[lang]"><a style="text-decoration: underline;" href="#">发布时间</a></th>
<th fieldname="i.[lang]"><a style="text-decoration: underline;" href="#">修改时间</a></th>
<th width="8%">操作</th>
</tr>
</tbody>
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
<script type="text/javascript">
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
        $("#listtable .sn a").lightBox();
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn">'+'<input type="checkbox" name="ckbox[]" value='+v.itemid+'>'+
                '<input type="hidden" name="itemid[]" value="'+v.itemid+'">'+'</td>');
        if(v.attachment){
            row.push('<td class="sn">'+'<img src="http://static.ebanhui.com/ebh/images/base/haveattach.gif" />'+'</td>');
        }else{
            row.push('<td class="sn"></td>');
        }
        
        if(v.thumb){
            row.push('<td class="sn">'+' <a href="'+v.thumb+'" title="'+v.subject+'"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></a>'+'</td>');
        }else{
            row.push('<td class="sn"></td>');
        }
        // if(v.lock==1){
            // row.push('<td class="name">'+'<a href="/'+v.code+'/'+v.itemid+'.html" target="_blank" style="color:gray">'+v.subject+'</a>'+'</td>');
        // }else{
            row.push('<td class="name">'+'<a href="/news/'+v.itemid+'.html" target="_blank">'+v.subject+'</a>'+'</td>');
        // }
        
 
       
        row.push('<td class="type">'+v.name+'</td>');
        row.push('<td class="identifier">'+v.top+'</td>');
        row.push('<td class="identifier">'+v.hot+'</td>');
        row.push('<td class="identifier">'+v.best+'</td>');
        if(v.status==1){
            row.push('<td class="identifier">正常</td>');
        }else{
            row.push('<td class="identifier">锁定</td>');
        }
        
        if(!v.source){
            row.push('<td class="visible"></td>');
        }else{
            row.push('<td class="visible">'+v.source.substr(0,v.source.indexOf(','))+'</td>');
        }
        
        row.push('<td class="order" width="5%">'+'<input type="text" style="width: 40px;" name="order['+v.itemid+']" value="'+v.displayorder+'">'+'</td>');
        row.push('<td class="visible">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="visible">'+getformatdate(v.lastpost)+'</td>');
        row.push('<td class="op">'+'<a href='+'/admin/particles/edit.html?itemid='+v.itemid+'>'+'[编辑]'+'</a>'+'&nbsp;&nbsp;<a href="javascript:return false" onclick="return del('+v.itemid+')" itemid='+v.itemid+'>'+'[删除]'+'</a>'+'&nbsp;&nbsp;<a href="javascript:void(0)" onclick="push('+v.itemid+')" itemid='+v.itemid+'>'+'[推送]'+'</a>'+'</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<tbody class="moduletbody">
</tbody>
</table>

</form>
<form method="post" name="listform" id="theform" action="" onsubmit="return whatOp();">
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tbody><tr><th width="12%">批量操作</th><th>
<input type="checkbox" name="chkall" id="ckhead" onclick=""><label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked="" id="noop"><label for="noop">不操作</label>
<input type="radio" name="operation" value="top" id="top"><label for="top">置顶</label>
<input type="radio" name="operation" value="hot" id="hot"><label for="hot">热门</label>
<input type="radio" name="operation" value="best" id="best"><label for="best">精华</label>
<input type="radio" name="operation" value="del" id="del"><label for="del">删除</label>
<input type="radio" name="operation" value="plock" id="plock"><label for="plock">锁定</label>
<input type="radio" name="operation" value="punlock" id="punlock"><label for="punlock">解锁</label>
<input type="radio" name="operation" value="movecategory" id="movecategory"><label for="movecategory">移动文章</label>
<input type="radio" name="operation" value="moveorder" id="moveorder"><label for="moveorder">排序</label>
<!-- <input type="radio" name="operation" value="push" id="push"><label for="push">推送</label> -->
</th></tr>
<tr id="divnoop" style="display:none"><td></td><td></td></tr>
<tr id="divtop" style="display:none">
<th>置顶</th>
<td><input name="optop" type="radio" value="0" checked="">非置顶&nbsp;&nbsp;<input name="optop" type="radio" value="1">置顶I&nbsp;&nbsp;<input name="optop" type="radio" value="2">置顶II&nbsp;&nbsp;<input name="optop" type="radio" value="3">置顶III&nbsp;&nbsp;</td>
</tr>
<tr id="divhot" style="display:none">
<th>热门</th>
<td><input name="ophot" type="radio" value="0" checked="">非热门&nbsp;&nbsp;<input name="ophot" type="radio" value="1">热门I&nbsp;&nbsp;<input name="ophot" type="radio" value="2">热门II&nbsp;&nbsp;<input name="ophot" type="radio" value="3">热门III&nbsp;&nbsp;</td>
</tr>
<tr id="divbest" style="display:none">
<th>精华</th>
<td><input name="opbest" type="radio" value="0" checked="">非精华&nbsp;&nbsp;<input name="opbest" type="radio" value="1">精华I&nbsp;&nbsp;<input name="opbest" type="radio" value="2">精华II&nbsp;&nbsp;<input name="opbest" type="radio" value="3">精华III&nbsp;&nbsp;</td>
</tr>
<tr id="divdel" style="display:none">
<th>删除</th>
<td><input name="opdel" type="radio" value="3" checked=checked>直接删除&nbsp;&nbsp;</td>
</tr>
<tr id="divmovecategory" style="display:none">
<th>移动文章</th>
<td id="targetCate">
    <?=$pselect2?>
</td>
</tr>
</tbody></table>
<span id="pp"></span> 
<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">

</div>
   
</form>

<script>
	$(function(){
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
        $.post("/admin/particles/getListAjax.html",
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



    function del(itemid){
            $.messager.prompt('确认','请输入验证码'+itemid,function(data){    
                if (data==itemid){    
                    $.post('/admin/particles/delete.html',
                        {itemid:itemid},
                        function(message){
                            eval('message='+message);
                            if(message['success']==true){
                                $('.pagination-page-list').trigger('change');
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "删除成功！",
                                    showType: 'slide',
                                    timeout: 300
                                });
                                return false;
                            }else{
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "删除失败！",
                                    showType: 'slide',
                                    timeout: 300
                                });
                                $('.pagination-page-list').trigger('change');
                                return false;
                            }
                        }
                        );   
                }else{
                    
                    $.messager.alert('提示','验证码不正确!');
                    return false;
                    
                }    
            });  
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
    })

    //批量操作路由器
    function whatOp(){
        var opTag = $(":radio[name='operation']:checked").val();
        if(opTag=="push"){
            return false;
        }
        var op = opTag+'All';
        eval(op+'(opTag)');
        return false;
    }
    //批量操作处理器
    function moveorderAll(){
        var ckboxs = $(":checkbox[name='ckbox[]']:checked");
        var res='';
        $.each(ckboxs,function(i,v){
            res+=';'+(v.value+','+$("input[name='order["+v.value+"]']").val());
        });
        $.post('/admin/particles/sortopAll.html',{param:res},
            function(message){
                if(message==1){
                    $.messager.show({
                                    title: "操作提示",
                                    msg: "批量排序成功!",
                                    showType: 'slide',
                                    timeout: 1000
                                });
                    $('.pagination-page-list').trigger('change');
                }else{
                     $.messager.show({
                                    title: "操作提示",
                                    msg: "批量排序失败！",
                                    showType: 'slide',
                                    timeout: 1000
                                });
                }
                
            });

        return false;
    }

    function delAll(){
        $.messager.confirm('确认','您确认想要删除所选记录吗？',function(r){
            if(r){
                var ckboxs = $(":checkbox[name='ckbox[]']:checked");
                var res='';
                $.each(ckboxs,function(i,v){
                    res+=';'+v.value;
                });
                $.post('/admin/particles/deleteAll.html',{param:res},
                    function(message){
                        if(message==1){
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "批量隐藏成功!！",
                                    showType: 'slide',
                                    timeout: 1000
                                });
                        }
                        $('.pagination-page-list').trigger('change');
                    });

                return false;
            }else{
                return false;
            }
        });
        
    }

    var topAll=bestAll=hotAll=function(op){
        var ckboxs = $(":checkbox[name='ckbox[]']:checked");
        var res='';
        $.each(ckboxs,function(i,v){
            res+=';'+v.value;
        });
        var tag = $(":radio[name=op"+op+"]:checked").val();
        $.post('/admin/particles/bth.html',{param:res,bth:op,level:tag},
            function(message){
                $.messager.show({
                    title: "操作提示",
                    msg: "批量成功!！",
                    showType: 'slide',
                    timeout: 800
                });
                $('.pagination-page-list').trigger('change');
        });
        return false;
    }
    
    function noopAll(){
        return false;
    }

    function movecategoryAll(){
        var ckboxs = $(":checkbox[name='ckbox[]']:checked");
        var res='';
        $.each(ckboxs,function(i,v){
            res+=';'+v.value;
        });
        var targetCate = $('#targetCate select[name=catid]').val();
        $.post('/admin/particles/movecategoryAll.html',{param:res,targetCate:targetCate},
            function(message){
                if(message>0){
                    $.messager.show({
                                    title: "操作提示",
                                    msg: "批量移动成功!",
                                    showType: 'slide',
                                    timeout: 1000
                                });
                    $('.pagination-page-list').trigger('change');
                }else{
                     $.messager.show({
                                    title: "操作提示",
                                    msg: "批量移动失败！",
                                    showType: 'slide',
                                    timeout: 1000
                                });
                }
                $('.pagination-page-list').trigger('change');
        });
        return false;
    }
    $(function(){
        $('.pagination-page-list').change(function(){
            $('#ckhead').prop('checked',false);
        });
    });
    function plockAll(){
        var ckboxs = $(":checkbox[name='ckbox[]']:checked");
        var res='';
        $.each(ckboxs,function(i,v){
            res+=';'+v.value;
        });
        $.post('/admin/particles/changeStatus.html',{param:res,status:2},
            function(message){
                $.messager.show({
                    title: "操作提示",
                    msg: "批量锁定成功!！",
                    showType: 'slide',
                    timeout: 800
                });
                $('.pagination-page-list').trigger('change');
        });
        return false;
    }
    function punlockAll(){
        var ckboxs = $(":checkbox[name='ckbox[]']:checked");
        var res='';
        $.each(ckboxs,function(i,v){
            res+=';'+v.value;
        });
        $.post('/admin/particles/changeStatus.html',{param:res,status:1},
            function(message){
                $.messager.show({
                    title: "操作提示",
                    msg: "批量解锁成功!！",
                    showType: 'slide',
                    timeout: 800
                });
                $('.pagination-page-list').trigger('change');
        });
        return false;
    }
    $(function(){
        $('#newslisttab li').click(function(){
            $('#newslisttab li').attr('class','');
            $(this).attr('class','active');
			if($(this).attr('status')==undefined)
				$("#status").removeAttr('name');
			else{
				$("#status").attr('name','status');
				$("#status").val($(this).attr('status'));
			}
            $('.pagination-page-list').trigger('change');
            return false;
        });
    });

    $("#ckhead").click(function(){
        $("input[name='ckbox[]']").prop('checked',$("#ckhead").prop('checked'));
    });

    function push(itemid){
       return showcr(itemid);
    }

    
    function showcr(itemid){
        var url = '/admin/classroom/classroomforpush.html?itemid='+itemid;
        var width = $(window).width();
        var height = $(window).height();
        $('#cr')
        .attr('width',width/5*4)
        .attr('height',height/5*4)
        .attr('src',url);
        $('#crwrap').show();
        $('#crwrap').dialog({    
            title: '请选择教室', 
            closed: false,    
            cache: false,   
            modal: true   
        });
        // $('#win').window('refresh', );  
        return false;
    }
    var closedialog = function (){
        $("#crwrap").dialog('close');
    } 
</script>
<?php 
    $this->display('admin/footer');
?>

