<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">充值卡管理 -  充值卡列表</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="/admin/card.html">浏览充值卡</a></td>
			<td ><a href="/admin/card/add.html" class="add">生成充值卡</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form id="ck" onsubmit="return _search()">
<table cellspacing="0" cellpadding="0" class="toptable">
<tr>
<td>
<label>卡号：</label><input type="text" name="searchkey" id="searchkey" value="" size="20" />（支持模糊查询）
<label>批次号：</label><input type="text" name="bname" id="bname" value="<?=$bname?>" size="20" />&nbsp;&nbsp;
<label>面值: </label>
<select name="price">
<option value="">全部</option>
<option value="100">100</option>
<option value="200">200</option>
<option value="500">500</option>
<option value="1000">1000</option>
</select>&nbsp;&nbsp;
<label>状态：</label><select name="status">
<option value="">请选择</option>
<option  value="0">正常</option>
<option  value="-1">已锁</option>
<option  value="1">已用</option>
</select>&nbsp;&nbsp;
<label>代理商: </label>
<?=$agentSelect?>
<label>创建时间范围：</label>
<input type="text" id="begindateline" name="begindateline" value="" size="20" maxlength="10" onfocus="" /> ~
<input type="text" id="enddateline" name="enddateline" value="" size="20" maxlength="10" onfocus="" />&nbsp;&nbsp;
<label>充值时间范围：</label>
<input type="text" id="beginusedateline" name="beginusedateline" value="" size="20" maxlength="10" onfocus="" /> ~
<input type="text" id="endusedateline" name="endusedateline" value="" size="20" maxlength="10" onfocus="" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="selectsubmit" value="  查询  " class="submit">
</td>
</tr>
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
    	if(v.status==1){
    		var row = ['<tr class="tr_module_ darkrow5">'];
    	}else{
    		var row = ['<tr class="tr_module_">'];
    	}
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.cardid+'" /></td>');
        row.push('<td>'+v.cardno+'</td>');
        row.push('<td>'+v.cardpwd+'</td>');
        row.push('<td>'+v.bname+'</td>');
        row.push('<td>'+v.price+'</td>');
        row.push('<td>'+getformatdate(v.dateline)+'</td>');
        if(v.status==1){
        	row.push('<td>'+getformatdate(v.usedateline)+'</td>');
        	row.push('<td>'+v.username+'</td>');
        	
        }else{
        	row.push('<td>未充值</td>');
        	row.push('<td>未充值</td>');
        }
      	var status={'_-1':'已锁','_0':'正常','_1':'已充值'};
        row.push('<td>'+status["_"+v.status]+'</td>');
        row.push('<td>'+v.seocode+'</td>');
        var ops={'_0':'锁定','_-1':'解锁','_1':'已用'}
        if(v.status==1){
        	 row.push('<td class="op">[<a href="/admin/card/detail.html?op=view&cardid='+v.cardid+'">查看</a>]&nbsp;&nbsp;[修改]&nbsp;&nbsp;[已用]&nbsp;&nbsp;[<a href="#" onclick="return _del('+v.cardid+')">删除</a>]</td>');
        	row.push('</tr>');	
        }else{
        	row.push('<td class="op">[<a href="/admin/card/detail.html?op=view&cardid='+v.cardid+'">查看</a>]&nbsp;&nbsp;[<a href="/admin/card/detail.html?op=edit&cardid='+v.cardid+'">修改</a>]&nbsp;&nbsp;[<a href="#" onclick="return changestatus('+v.status+','+v.cardid+')">'+ops["_"+v.status]+'</a>]&nbsp;&nbsp;[<a href="#" onclick="return _del('+v.cardid+')">删除</a>]</td>');
        	row.push('</tr>');
        }
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%" class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="cardno">卡号</th>
<th fieldname="cardno">密码</th>
<th fieldname="bname">批次号</th>
<th fieldname="price">面值</th>
<th fieldname="dateline">创建时间</th>
<th filedname="usedateline">充值时间</th>
<th filedname="uid">充值的会员</th>
<th filedname="status">状态</th>
<th filedname="seocode">防伪验证码</th>
<th filedname="caozuo">操作</th>
</tr>
<tbody class="moduletbody"></tbody>
</table>
<form onsubmit="return doWhat()">
<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr>
<th width="12%">批量操作</th>
<th><input id="ckhead" type="checkbox" name="ckhead"><label
for="chkall">全选</label>
<input id="noop" name="optype" type="radio" value="noop" checked /><label for="noop">不操作</label>&nbsp;&nbsp;
<input id="sortop" name="optype" type="radio" value="-1" /> <label for="sortop">锁定</label>
<input id="sortop" name="optype" type="radio" value="0" /> <label for="sortop">解锁</label>
</th>
</tr>
</table>
<div id="pp"></div>
<div class="buttons"><input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置"></div>

</form><br>
<script>
$(function(){
    $("#begindateline,#enddateline,#beginusedateline,#endusedateline").focus(function(){
    	$(this).datebox({showSeconds:false});
    });
    $("#begindateline,#enddateline,#beginusedateline,#endusedateline").trigger('focus');
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
    $.post("/admin/card/getListAjax.html",
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
function doWhat(){
	var status = $(":radio[name=optype]:checked").val();
	if(status=='noop'){
		return false;
	}
	$("#ckhead").prop('checked',false);
	var cards = $(":checkbox[name='item[]']:checked");
	var cardsid=[];
	$.each(cards,function(k,v){
		cardsid.push(v.value);
	});
	$.post('/admin/card/changeStatus.html',{status:status,cardsid:cardsid.join(' ')},function(message){
		if(message){
                    $.messager.show({
                        title: "操作提示",
                        msg: "操作成功!！",
                        showType: 'slide',
                        timeout: 1000
                     });
                }else{
                     $.messager.show({
                        title: "操作提示",
                        msg: "操作失败,可能选中项中存在已使用充值卡!",
                        showType: 'slide',
                        timeout: 4000
                     });
                }
                $('.pagination-page-list').trigger('change');
	});
	return false;
}

function changestatus(status,cardid){
	if(status==-1){
		status=0;
	}else{
		status=-1;
	}
	$.post('/admin/card/changeStatus.html',{status:status,cardsid:cardid},function(message){
		$('.pagination-page-list').trigger('change');
	});
	return false;
}
function _del(cardid){
        $.messager.prompt('确认','请输入验证码'+cardid,function(data){    
            if (data==cardid){    
                $.post('/admin/card/delOne.html',
                    {cardid:cardid},
                    function(message){
                        if(message==true){
                            $('.pagination-page-list').trigger('change');
                            $.messager.show({
                                title: "操作提示",
                                msg: "删除成功！",
                                showType: 'slide',
                                timeout: 500
                            });
                            return false;
                        }else{
                            $.messager.show({
                                title: "操作提示",
                                msg: "删除失败！",
                                showType: 'slide',
                                timeout: 500
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
$("#ckhead").click(function(){
    $(":checkbox[name='item[]']").prop('checked',$("#ckhead").prop('checked'));
});
</script>
</body>

<?php $this->display('admin/footer');?>