<?php
$this->display('admin/header');
?>
    <body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>账号列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
                <tr>
                    <td  class="active"><a href="/admin/license.html">浏览账号</a></td>
                    <td ><a href="/admin/license/add.html" class="add">生成账号</a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<form id="ck" onsubmit="return _search()">
    <table cellspacing="0" cellpadding="0" class="toptable">
        <tbody>
        <tr><td>
                <label>登录账号</label>
                <input type="text" name="username" id="searchkey" value="" size="20">
                <input type="reset" id="clear" value="清除" />
                <input type="hidden"  id="mediaid"  value="0" />　　
                <input type="submit" name="filtersubmit" value="搜索">
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
        row.push('<td class="name" id="uid">'+v.uid+'</td>');
        row.push('<td class="name" id="username">'+v.username+'</td>');
        row.push('<td class="name">'+(v.classname||"")+'</td>');
        row.push('<td class="name" id="initpwd">'+(v.telephone||"")+'</td>');
        if(v.sex==0){
            row.push('<td class="name">男</td>');
        }else{
            row.push('<td class="name">女</td>');
        }
        row.push('<td class="type">'+getformatdate(v.dateline)+'</td>');
        row.push('<td align="center" class="op">[<a  href="/admin/license/oneExport.html?uid='+v.uid+'">导出许可证</a>]</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
    <tr>
        <th>序号</th>
        <!--<th>选择</th>-->
        <th fieldname="i.card" width="8%">UID</th>
        <th fieldname="i.card" width="20%">登录账号</th>
        <th fieldname="i.name" width="20%">班级</th>
        <!--<th fieldname="i.type" width="15%">姓名</th>-->
        <th fieldname="i.identifier"  width="10%">初始密码</th>
        <th fieldname="i.identifier"  width="10%">性别</th>
        <th fieldname="i.identifier"  width="12%">生成时间</th>
        <th>操作</th>
    </tr>
    <tbody class="moduletbody">

    </tbody>
</table>
<form onsubmit="return whatOp();">
    <div id="pp"></div>
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
            $.post("/admin/license/getListAjax.html",
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