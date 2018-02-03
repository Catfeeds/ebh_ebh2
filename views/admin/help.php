<?php
$this->display('admin/header');
?>
<body>
    
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr>
            <td><h1>帮助管理 - 帮助列表</h1></td>
            <td class="actions">
                <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
                <tbody><tr>
                <td class="active"><a href="/admin/help.html">浏览帮助</a></td>
                <td><a href="/admin/help/add.html" class="add">添加帮助</a></td>
                </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table>
<div id="newslisttab">
<ul>
    <li class="active" folder=0><a href="/admin/help/index.html" >所有状态</a></li>

    <li class="" folder=1><a href="/admin/help/index.html">待审箱</a></li>

    <li class="" folder=2><a href="/admin/help/index.html">发布箱</a></li>
</ul>
  
</div>
<?php $in = 'c.catid in(691,692,693,694,695,789,790,791,792,793,794,795,796,797,798,799,800,801,802,804,805,806,807,808,809,810,861,862,863,864,883,884,931,932,811,812,813,814,815,816,817,818,819,820,821,822,823,824,825,826,827,836,828,837,829,838,830,839)'; ?>  
<form method="GET" action="#"  id='ck' onsubmit="return _search()">
    <input type="hidden" name="action" value="ad" />
    <input type="hidden" name="folder" id="folder" value="<?=$folder?>" /> 
    <input type="hidden" name="displayorder" value="i.lastpost desc"/>
    <input type="hidden" name="type" value="news" /> 
    <input type="hidden" name="in" value="<?=$in?>">
<table cellspacing="0" cellpadding="0" class="toptable">
        <tbody><tr><td>
        <select name="catid" id='category'>
        <option value="691" selected="true">所有分类</option>
        <?php $this->widget('category_widget',array('where'=>$in,'tag'=>'category')); ?>
        </select>

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
        
  
        
        <label>关键字: </label><input id="search-input" type="text" name="searchkey" value=""/>
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
<!-- <th fieldname="i.note">投放频道</th> -->
<th fieldname="i.type">分类</th>
<th fieldname="i.identifier">置顶</th>
<th fieldname="i.[top]">精华</th>
    <th fieldname="i.[hot]">热门</th>
<th fieldname="i.[lang]">来源</th>
    <th fieldname="i.order" width="2%">排列顺序</th>
<th fieldname="i.[lang]"><a style="text-decoration: underline;" title="点击排序" href="#">发布时间</a></th>
<th width="8%">操作</th>
</tr>
</tbody>
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
        if(v.folder==1){
            row.push('<td class="name">'+'<a href="/'+v.code+'/'+v.itemid+'.html" target="_blank" style="color:gray">'+v.subject+'</a>'+'</td>');
        }else{
            row.push('<td class="name">'+'<a href="/'+v.code+'/'+v.itemid+'.html" target="_blank">'+v.subject+'</a>'+'</td>');
        }
        
        // if(v.channel){
        //         row.push('<td class="identifier">'+v.channel+'<br></td>');
        // }else{
        //         row.push('<td class="identifier"><br></td>');
        // }
            
       
        row.push('<td class="type">'+v.fenlei+'</td>');
        row.push('<td class="identifier">'+v.top+'</td>');
        row.push('<td class="system">'+v.best+'</td>');
        row.push('<td class="system">'+v.hot+'</td>');
        row.push('<td class="visible">'+v.source.substr(0,v.source.indexOf(','))+'</td>');
        row.push('<td class="order" width="5%">'+'<input type="text" style="width: 40px;" name="order['+v.itemid+']" value="'+v.displayorder+'">'+'</td>');
        row.push('<td class="visible">'+getformatdate(v.lastpost)+'</td>');
        row.push('<td class="op">'+'<a href='+'/admin/items/add.html?type=help&itemid='+v.itemid+'>'+'[编辑]'+'</a>'+'&nbsp;&nbsp;<a href="javascript:return false" onclick="return del('+v.itemid+')" itemid='+v.itemid+'>'+'[删除]'+'</a>'+'</td>');
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
<input type="radio" name="operation" value="movecategory" id="movecategory"><label for="movecategory">移动帮助</label>
<input type="radio" name="operation" value="moveorder" id="moveorder"><label for="moveorder">排序</label>
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
<td><input name="opdel" type="radio" value="1" checked="">隐藏帮助<b>(帮助进入待审箱,状态:1)</b>&nbsp;&nbsp;<input name="opdel" type="radio" value="0">直接删除&nbsp;&nbsp;</td>
</tr>
<tr id="divmovecategory" style="display:none">
<th>移动帮助</th>
<td>
    <select name="category2" id="category2"> 
     <?php $this->widget('category_widget',array('where'=>$in,'tag'=>'category2','selected'=>'')); ?>
    </select>
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
    pageSize:20,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#ck').serialize();
        $.post("/admin/items/getListAjax.html",
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



    function del(itemid){
            $.messager.prompt('确认','请输入验证码'+itemid,function(data){    
                if (data==itemid){    
                    $.post('/admin/items/del.html',
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
        var opTag = $(":radio[name='operation']:checked").val()
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
        $.post('/admin/items/moveorderAll.html',{param:res},
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
                var tag = $(":radio[name=opdel]:checked").val();
                $.post('/admin/items/delAll.html',{param:res,tag:tag},
                    function(message){
                        if(message==1){
                            if(tag==1){
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "批量隐藏成功!！",
                                    showType: 'slide',
                                    timeout: 1000
                                });
                            }else{
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "批量删除成功!！",
                                    showType: 'slide',
                                    timeout: 1000
                                });
                            }
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
        $.post('/admin/items/bthAll.html',{param:res,bth:op,tag:tag},
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
    
    function movecategoryAll(){
        var ckboxs = $(":checkbox[name='ckbox[]']:checked");
        var res='';
        $.each(ckboxs,function(i,v){
            res+=';'+v.value;
        });
        var itemCategory = $('#category2').val();
        $.post('/admin/items/movecategoryAll.html',{param:res,itemCategory:itemCategory},
            function(message){
                if(message==1){
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
        $('#newslisttab li').click(function(){
            $('#newslisttab li').attr('class','');
            $(this).attr('class','active');
            $("#folder").val($(this).attr('folder'));
            $('.pagination-page-list').trigger('change');
            return false;
        });
    });

    $("#ckhead").click(function(){
        $("input[name='ckbox[]']").prop('checked',$("#ckhead").prop('checked'));
    });

</script>
<?php 
    $this->display('admin/footer');
?>

