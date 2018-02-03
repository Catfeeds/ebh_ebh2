<?php $this->display('admin/header') ?>
<?php
$this->display('admin/header');
?>
<body>
    
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr>
            <td><h1>资讯管理 - 资讯列表</h1></td>
            <td class="actions">
                <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
                <tbody><tr>
                <td><a href="<?php echo geturl('admin/resources/add')?>" class="add">添加资源</a></td>
                <td class="active"><a href="<?php echo geturl('admin/resources/showlist')?>">资源管理</a></td>
                </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table>

<form method="GET" action="#"  id='ck' onsubmit="return _search()">
    <input type="hidden" name="action" value="ad" />
    <input type="hidden" name="folder" id="folder" value="<?=$folder?>" /> 
    <input type="hidden" name="displayorder" value="i.lastpost desc"/>
    <input type="hidden" name="type" value="resources" /> 
    <table cellspacing="0" cellpadding="0" class="toptable">
        <tbody>
            <tr><td>
                <select name="catid" id='category'>
                <option value="0" selected="true">所有分类</option>        
                <?php $this->widget('category_widget',array('where'=>array('type'=>'resources'),'tag'=>'category')); ?>
                </select>
            <label>关键字: </label><input id="search-input" type="text" name="searchkey" value=""/>
            <input id ='search' type="submit" onclick="return _search();" value="GO" />
            </td></tr>
        </tbody>
    </table>
</form>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>

<form method="post" name="listform" id="theform" action="" onsubmit="return whatOp();">
<table cellspacing="0" cellpadding="0" width="100%" class="listtable" id="listtable">
<tbody><tr class="">
<th>序号</th>
<th>选择</th>
<th class="sn"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></th>
<th fieldname="i.name">标题</th>
<th fieldname="i.thumb">资源链接</th>
<th fieldname="i.message">资源说明</th>
<th>操作</th>
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

        if(v.thumb){
            row.push('<td class="sn">'+' <a href="'+v.thumb+'" title="'+v.subject+'"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></a>'+'</td>');
        }else{
            row.push('<td class="sn"></td>');
        }
        if(v.folder==1){
            row.push('<td class="name">'+'<a href="/'+v.code+'/'+v.itemid+'.html" target="_blank" style="color:gray">'+v.subject+'</a><br/>'+v.fenlei+'</td>');
        }else{
            row.push('<td class="name">'+'<a href="/'+v.code+'/'+v.itemid+'.html" target="_blank">'+v.subject+'</a><br />'+v.fenlei+'</td>');
        }
        row.push('<td><a target="_blank" href="'+v.thumb+'">'+v.thumb+'</a></td>');
        if(v.message){
        	row.push('<td>'+v.message+'</td>');
        }else{
        	row.push('<td></td>');
        }
        row.push('<td class="op" width="8%">'+'<a href='+'/admin/items/add.html?type=<?=$type?>&itemid='+v.itemid+'>'+'[编辑]'+'</a>'+'&nbsp;&nbsp;<a href="javascript:return false" onclick="return del('+v.itemid+')" itemid='+v.itemid+'>'+'[删除]'+'</a>'+'</td>');
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
<input type="radio" name="operation" value="del" id="del"><label for="del">删除</label>
</th></tr>

<tr id="divdel" style="display:none">
<th>删除</th>
<td><input name="opdel" type="radio" value="0">直接删除&nbsp;&nbsp;</td>
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


<?php $this->display('admin/footer');?>