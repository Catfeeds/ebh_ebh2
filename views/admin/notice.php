<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>公告管理 - 公告列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="/admin/notice.html">查看公告</a></td>
			<td ><a href="/admin/notice/add.html">发布公告</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="POST"  id="ck" onsubmit="return _search()">
<input type="hidden" name="type" value="group" />
<table cellspacing="2" cellpadding="2" class="helptable">
<tbody>
    <tr><td>
        <ul>
            <li>关键字搜索，目前支持: 公告内容的模糊搜索。</li>
        </ul>
    </td></tr>
</tbody>
</table>
<table cellspacing="0" cellpadding="0" class="toptable">
<tr><td><label></label>
<?=$grouplist?>
<label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
<input type="submit" name="selectsubmit" value="查询" class="submit">
</td></tr>
</table>
</form>
<script type="text/javascript">
    var toname = {  '_0':'所有用户组',
                    '_1':'公司用户',
                    '_2':'代理商',
                    '_3':'省级代理商',
                    '_4':'媒体中心',
                    '_5':'教师',
                    '_6':'会员',
                    '_7':'系统管理员',
                    '_10':'课件审核',
                    '_11':'客服部',
                    '_12':'资讯管理',
                    '_13':'代理商',
                    '_14':'财务结算'
                }
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.logid+'" /></td>');
        row.push('<td class="uid">'+v.username+'</td>');
        row.push('<td class="toid">'+toname["_"+v.toid]+'</td>');
        row.push('<td class="message">【发布公告】  '+v.message+'</td>');
        row.push('<td class="fromip">'+v.fromip+'</td>');
        row.push('<td class="datetime">'+getformatdate(v.dateline)+'</td>');
        row.push('<td class="op">[<a href="/admin/notice/add.html?groupid='+v.toid+'&logid='+v.logid+'">修改</a>] [<a href="#" onclick="return _del('+v.logid+')">删除</a>]</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<form method="post" name="listform" id="theform" action="" onsubmit="#">
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tbody class="systembody">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.uid" width="10%">操作人</th>
<th fieldname="i.toid" width="10%">公告对象</th>
<th fieldname="i.message" width="50%">公告内容</th>
<th fieldname="i.fromip">操作IP</th>
<th fieldname="i.[dateline]">提交日期</th>
<th>操作</th>
</tr>
</tbody>
<tbody class="moduletbody"></tbody>
</table>
</form>
<form method="post" name="listform" id="theform" onsubmit="return whatOp();">
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tbody><tr><th width="12%">批量操作</th><th>
<input type="checkbox" name="chkall" id="ckhead" onclick=""><label for="chkall">全选</label>
<input type="radio" name="operation" value="del" id="del"><label for="del">删除</label>
</th></tr>


</tbody></table>
<span id="pp"></span> 
<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">

</div>
   
</form>
<br>
<script>
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
    $.post("/admin/notice/getListAjax.html",
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

$("#ckhead").click(function(){
    $("input[name='item[]']").prop('checked',$("#ckhead").prop('checked'));
});
//批量操作路由器
function whatOp(){
    var opTag = $(":radio[name='operation']:checked").val()
    if(!opTag){
        return false;
    }
    var op = opTag+'All';
    eval(op+'(opTag)');
    return false;
}
function _del(logid){
        $.messager.prompt('确认','请输入验证码'+logid,function(data){    
            if (data==logid){    
                $.post('/admin/notice/delone.html',
                    {logid:logid},
                    function(message){
                        if(message==true){
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
function delAll(){
    $.messager.confirm('确认','您确认想要删除所选记录吗？',function(r){
        if(r){
            var ckboxs = $(":checkbox[name='item[]']:checked");
            var res='';
            $.each(ckboxs,function(i,v){
                res+=';'+v.value;
            });
            $.post('/admin/notice/delAll.html',{param:res},
                function(message){
                    if(message==true){
                        $.messager.show({
                                title: "操作提示",
                                msg: "批量删除成功!！",
                                showType: 'slide',
                                timeout: 1000
                        });
              
                    }else{
                        $.messager.show({
                                title: "操作提示",
                                msg: "批量删除失败!！",
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
</script>
</body>

<?php $this->display('admin/footer');?>