<?php
$this->display('admin/header');
?>
<body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>年卡管理</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td  class="active"><a href="/admin/yearcard.html">浏览年卡</a></td>
            <td ><a href="/admin/yearcard/add.html" class="add">添加年卡</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">
    <tbody>
        <tr><td>
        <label>城市：</label>
        <?php $this->widget('cities_widget') ?>
        <label></label>
        <label>激活码: </label>
        <input type="text" name="q" id="searchkey" value="" size="20">
        
        <label for="catid">所属学校</label>
        <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
        <input type="button" id="drop" value="选择" />
        <input type="button" id="clear" value="清除" />
        <input type="hidden" name="crid" id="mediaid"  value="0" />　　

        <input type="submit" name="filtersubmit" value="GO">
        </td></tr>
    </tbody>
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
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.cardid+'" /></td>');
        row.push('<td class="name">'+v.cardpass+'</td>');
        row.push('<td class="name">'+v.cardnumber+'</td>');
        row.push('<td class="name">'+(v.city||'')+'</td>');
        row.push('<td class="name">'+v.crname+'</td>');
        if(v.time==6){
            row.push('<td class="name">半年</td>');
        }else if(v.time==12){
            row.push('<td class="name">一年</td>');
        }
        
        row.push('<td class="type">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="identifier">'+getformatdate(v.period)+'</td> ');
        if(v.status==1){
            row.push('<td class="name">已激活</td>');
        }else{
            row.push('<td class="name">未激活</td>');
        }
       
        row.push('<td align="center" class="op">[<a onclick="destroy('+v.cardid+')" href="#">删除</a>]</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
    <table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
    <tr>
    <th>序号</th>
    <th>选择</th>
    <th fieldname="i.card" width="20%">编号（卡号）</th>
    <th fieldname="i.name" width="20%">激活码</th>
    <th fieldname="i.type" width="15%">城市</th>
    <th fieldname="i.identifier"  width="10%">所属同步学堂</th>
    <th fieldname="i.identifier"  width="10%">时长</th>
    <th fieldname="i.identifier"  width="10%">生成时间</th>
    <th fieldname="i.identifier"  width="10%">过期时间</th>
    <th fieldname="i.identifier"  width="10%">状态</th>
    <th>操作</th>
    </tr>
    <tbody class="moduletbody">

    </tbody>
    </table>
<form onsubmit="return whatOp();">
    <table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
        <tbody><tr><th width="12%">批量操作</th><th>
        <input type="checkbox" name="ckhead" id="ckhead"><label for="ckhead">全选</label>
        <input type="radio" name="operation" value="noop" checked="" id="noop"><label for="noop">不操作</label><input type="radio" name="operation" value="delete" id="delete"><label for="delete">删除</label>
        </th></tr>
        <tr id="divnoop" style="display: none;"><td></td><td></td></tr>
        </tbody>
    </table>
<div id="pp"></div>
<div class="buttons">
    <input type="submit" name="listsubmit" value="提交保存" class="submit">
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
            $.post("/admin/yearcard/getListAjax.html",
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

		
    function destroy(cardid){
        if (cardid){
            $.messager.confirm('确认','确定要删除该年卡么？',function(r){
                if (r){
                    $.post('<?php echo geturl('admin/yearcard/del');?>',{cardid:cardid},function(result){
                        if (result.success){
							$.messager.show({    
                                timeout:2000,
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
		
	$("#ckhead").click(function(){
        $("input[name='item[]']").prop('checked',$("#ckhead").prop('checked'));
    });
    //批量操作路由器
    function whatOp(){
        var opTag = $(":radio[name='operation']:checked").val();
        var op = opTag+'All';
        eval(op+'(opTag)');
        return false;
    }
    function deleteAll(){
        var ckboxs = $(":checkbox[name='item[]']:checked");
                var res='';
                $.each(ckboxs,function(i,v){
                    res+=';'+v.value;
                });
        $.post('/admin/yearcard/delAll.html',{param:res},function(message){
            if(message=='success'){
                $.messager.show({
                        title:'提示消息',
                        msg:'删除成功!',
                        timeout:1000,
                        showType:'slide'
                    });
                    $("#ckhead").prop('checked',false);
                    $(".pagination-page-list").trigger('change');
            }else{
                $.messager.show({
                        title:'提示消息',
                        msg:'删除失败!',
                        timeout:1000,
                        showType:'slide'
                    });
            }
        });
        //res 格式为 ;id;id;id
        return false;
        
    }
    function noopAll(){
        return false;
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
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
<script>
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