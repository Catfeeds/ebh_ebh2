<?php
 $this->display('admin/header');
?>
<body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr>
            <td><h1>广告管理 - 广告列表</h1></td>
            <td class="actions">
                <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
                <tbody><tr>
                <td class="active"><a href="/admin/pads.html">浏览广告</a></td>
                <td><a href="/admin/pads/add.html" class="add">添加广告</a></td>
                </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table>
<div id="newslisttab">
<ul>
    <li class="active"><a href="/admin/pads/index.html" >所有状态</a></li>

    <li class="" status=2><a href="/admin/pads/index.html">锁定状态</a></li>

    <li class="" status=1><a href="/admin/pads/index.html">正常状态</a></li>
</ul>
  
</div>
<form method="GET" action="#"  id='ck' onsubmit="return _search()">
    <input type="hidden" name ="status" id="status" value="" /> 
    <input type="hidden" name="order" value="a.lastpost desc"/>
<table cellspacing="0" cellpadding="0" class="toptable">
        <tbody><tr><td>
        <?=$pselect2?>
        
        &nbsp;&nbsp;
        <?=$pselect?>
        开始时间：<input type="text" value="" name='begintime1' onfocus="$(this).datebox({});" id="begintime1" /> - <input type="text" value="" onfocus="$(this).datebox({});" name='begintime2' id='begintime2'  />
        结束时间：<input type="text" value="" name='endtime1' onfocus="$(this).datebox({});" id="endtime1" /> - <input type="text" value="" onfocus="$(this).datebox({});" name='endtime2' id='endtime2'  />

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
<th class="sn"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></th>
<th fieldname="i.name" width="25%">标题</th>
<th fieldname="i.type">投放栏目</th>
<th fieldname="i.identifier">状态</th>
<th fieldname="i.[lang]"><a style="text-decoration: underline;" href="#">开始时间</a></th>
<th fieldname="i.[lang]"><a style="text-decoration: underline;" href="#">结束时间</a></th>
<th fieldname="i.[lang]"><a style="text-decoration: underline;" href="#">修改时间</a></th>
<th fieldname="i.order" width="2%">排列顺序</th>
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
        row.push('<td class="sn">'+'<input type="checkbox" name="ckbox[]" value='+v.aid+'>'+
                '<input type="hidden" name="aid[]" value="'+v.aid+'">'+'</td>');

        if(v.thumb){
            row.push('<td class="sn">'+' <a href="'+v.thumb+'" title="'+v.subject+'"><img src="http://static.ebanhui.com/ebh/images/base/image.gif"></a>'+'</td>');
        }else{
            row.push('<td class="sn"></td>');
        }
        // if(v.lock==1){
            // row.push('<td class="name">'+'<a href="/'+v.code+'/'+v.aid+'.html" target="_blank" style="color:gray">'+v.subject+'</a>'+'</td>');
        // }else{
            row.push('<td class="name">'+'<a href="/'+v.linkurl+'" target="_blank">'+v.subject+'</a><br />'+v.typename+'</td>');
        // }
        
 
       
        row.push('<td class="type">'+v.catename+'</td>');
        if(v.status==1){
            row.push('<td class="identifier">正常</td>');
        }else{
            row.push('<td class="identifier">锁定</td>');
        }
        
        row.push('<td class="visible">'+getformatdate(v.begintime)+'</td>');
        row.push('<td class="visible">'+getformatdate(v.endtime)+'</td>');  
        row.push('<td class="visible">'+getformatdate(v.lastpost)+'</td>');
        
        row.push('<td class="order" width="5%">'+'<input type="text" style="width: 40px;" name="order['+v.aid+']" value="'+v.displayorder+'">'+'</td>');
      
        row.push('<td class="op">'+'<a href='+'/admin/pads/edit.html?aid='+v.aid+'>'+'[编辑]'+'</a>'+'&nbsp;&nbsp;<a href="javascript:return false" onclick="return del('+v.aid+')" aid='+v.aid+'>'+'[删除]'+'</a>'+'</td>');
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
<input type="radio" name="operation" value="del" id="del"><label for="del">删除</label>
<input type="radio" name="operation" value="plock" id="plock"><label for="plock">锁定</label>
<input type="radio" name="operation" value="punlock" id="punlock"><label for="punlock">解锁</label>
<input type="radio" name="operation" value="movecategory" id="movecategory"><label for="movecategory">移动广告</label>
<input type="radio" name="operation" value="moveorder" id="moveorder"><label for="moveorder">排序</label>
</th></tr>
<tr id="divnoop" style="display:none"><td></td><td></td></tr>

<tr id="divdel" style="display:none">
<th>删除</th>
<td><input name="opdel" type="radio" value="3" checked=checked>直接删除&nbsp;&nbsp;</td>
</tr>
<tr id="divmovecategory" style="display:none">
<th>移动广告</th>
<td id="targetCate">
    <?=$pselect3?>
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
        $('#begintime1,#endtime1,#begintime2,#endtime2').trigger('focus');
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
        $.post("/admin/pads/getListAjax.html",
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



    function del(aid){
            $.messager.prompt('确认','请输入验证码'+aid,function(data){    
                if (data==aid){    
                    $.post('/admin/pads/delete.html',
                        {aid:aid},
                        function(message){
                            if(message>0){
                               
                                $.messager.show({
                                    title: "操作提示",
                                    msg: "删除成功！",
                                    showType: 'slide',
                                    timeout: 300
                                });
                                $('.pagination-page-list').trigger('change');
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
        $.post('/admin/pads/sortopAll.html',{param:res},
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
                $.post('/admin/pads/deleteAll.html',{param:res},
                    function(message){
                        if(message>0){
                           $.messager.show({
                                title: "操作提示",
                                msg: "批量删除成功!！",
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
        $.post('/admin/pads/movecategoryAll.html',{param:res,targetCate:targetCate},
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
        $.post('/admin/pads/changeStatus.html',{param:res,status:2},
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
        $.post('/admin/pads/changeStatus.html',{param:res,status:1},
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

</script>
<?php 
    $this->display('admin/footer');
?>

