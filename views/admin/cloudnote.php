<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1 style="width:550px;">教室管理 -  云教育留言</h1></td>
    <td class="actions" >
      
    
    </td>
  </tr>
</table>
<form id="ck">
<input type="hidden" name="status" id="status" value="" />
<div id="newslisttab">
	<ul>
		<li class=active><a href="#" status=''>全部留言</a></li>
		<li class=><a href="#" status='0'>待处理</a></li>
		<li class=><a href="#" status='1'>已处理</a></li>
		<li class=><a href="#" status='2'>不处理</a></li>
		<li class=><a href="#" status='3'>已删除</a></li>
 	</ul>
</div>
</form>
<script type="text/javascript">
	var statusinfo=['待处理','已处理','不处理','已删除']
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="uid">'+v.uid+'</td>');
        row.push('<td class="realname">'+v.realname+'</td>');
        row.push('<td >'+v.email+'</td>');
        row.push('<td>'+v.phone+'</td>');
        row.push('<td>'+v.qq+'</td>');
        row.push('<td>'+v.citycode+'</td>');
        row.push('<td>'+v.cityname+'</td>');
        row.push('<td>'+v.address+'</td>');
        // row.push('<td>'+v.message+'</td>');
        if(v.message){
        	if(v.message.replace(/<[^>].*?>/g,"").length>16){
		 		row.push('<td class="content">'+v.message.replace(/<[^>].*?>/g,"").substr(0,16)+'...</td>');
			}else{
				row.push('<td class="content">'+v.message.replace(/<[^>].*?>/g,"").substr(0,16)+'</td>');
			}
        }else{
        	row.push('<td></td>');
        }

        row.push('<td class="status">'+statusinfo[v.status]+'</td>');
        if(v.dateline){
        	row.push('<td align="center">'+getformatdate(v.dateline)+'</td>');
        }else{
        	row.push('<td align="center"></td>');
        }
        if(v.verifydateline>0){
        	row.push('<td align="center">'+getformatdate(v.verifydateline)+'</td>');
        }else{
        	row.push('<td align="center"></td>');
        }
        if(v.status==0){
 			row.push('<td class="nowrap" >[<a href="/admin/cloudnote/detail.html?noteid='+v.noteid+'">查看</a>][<a href="#" onclick="return changestatus('+v.noteid+',1)">处理</a>][<a href="#">删除</a>]&nbsp;</td>');
        }else if(v.status==1||v.status==2){
        	 row.push('<td class="nowrap" >[<a href="/admin/cloudnote/detail.html?noteid='+v.noteid+'">查看</a>]<span style="color:#ccc">[处理]</span>[<a href="#">删除</a>]&nbsp;</td>');
        }else{
        	 row.push('<td class="nowrap" >[<a href="/admin/cloudnote/detail.html?noteid='+v.noteid+'">查看</a>]<span style="color:#ccc">[处理]</span><span style="color:#ccc">[删除]</span>&nbsp;</td>');
        }
       
        row.push('</tr>');
        return row.join('');
    }
</script>
<form method="post" name="listform" id="theform" action="#"  >
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th fieldname="i.uid" >用户编号</th>
<th fieldname="i.realname" >真实姓名</th>
<th >邮箱</th>
<th >电话</th>
<th >QQ</th>
<th >城市编号</th>
<th >城市信息</th>
<th >详细地址</th>
<th >留言信息</th>
<th fieldname="i.statusname">状态</th>
<th fieldname="i.dateline" width="10%">留言时间</th>
<th fieldname="i.verifydateline" width="10%">处理时间</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
	
</tbody>
</table>
<div id="pp"></div>
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input id="noop" name="optype" type="radio" value="0" checked /><label for="noop">不操作</label>&nbsp;&nbsp;
</th></tr>
</table>
<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>

</form>
</body>
<script type="text/javascript">
$(function(){
    $(".pagination-page-list").trigger('change');
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
function _search(){
   $('#pp').pagination({pageNumber:1});
   $(".pagination-page-list").trigger('change');
   return false;
}
$('#pp').pagination({
    pageSize:10,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#ck').serialize();
        $.post("/admin/cloudnote/getListAjax.html",
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
function changestatus(noteid,status){
    if (noteid){
        $.post('<?php echo geturl('admin/cloudnote/editcloudnote');?>',
			{noteid:noteid,status:status},
			function(result){
                    if (result==1){
                    	$.messager.show({    // show error message
                            title: '操作提示',
                            msg: '处理成功!'
                        });
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
</script>
<?php $this->display('admin/footer');?>