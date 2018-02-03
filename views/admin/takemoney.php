<?php
	$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>取现管理</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/takemoney.html">浏览取现记录</a></td>
			<!-- <td ><a href="admin.php?token=a885db0d477d7071&action=takemoney&op=add" class="add"></a></td> -->
			</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" class="helptable"><tr><td><ul>
	<li>您可以根据账号,银行卡号,备注,真实姓名等进行模糊查找。</li>
</ul></td></tr></table><div id="newslisttab">
<ul>
<li class="active" tag="all"><a href="#" onclick='return _review(this,"all")'>全部</a></li>
<li class="" tag="0"><a href="#" onclick='return _review(this,0)'>已提交</a></li>
<li class="" tag="1"><a href="#" onclick='return _review(this,1)'>已审核</a></li>
<li class="" tag="2"><a href="#" onclick='return _review(this,2)'>已完成</a></li>
<li class="" tag="-1"><a href="#" onclick='return _review(this,-1)'>已撤销</a></li>
</ul>
</div>
<form method="GET" id="ck" onsubmit="return _search()"> 
<table cellspacing="0" cellpadding="0" class="toptable">
<tr><td>
<label>关键字: </label><input type="text" name=keyname id="keyname" value='' size="20" />
        &nbsp;&nbsp;<select id="status" name="status">
        <option value="all">全部</option>
        <option value="0" >已提交</option>
        <option value="1" >已审核</option>
        <option value="2" >已完成</option>
        <option value="-1" >已撤销</option>
        </select>
        <input type="submit" name="filtersubmit" value="GO">
</td></tr>
</table>

</form>
<script type="text/javascript">
	function getFormateBankNumber(num){
		var numArr = num.split('');
		var len = numArr.length;
		var newnum = '';
		for(var i =1;i<=len;i++){
			newnum+=numArr[i-1];
			if(i%4==0){
				newnum+=' ';
			}
		}
		return newnum;
	}
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_module_" />'];
        row.push('<th rowspan="2" class="sn">'+(k+1)+'</th>');
        row.push('<td rowspan="2"  class="sn" style="text-align: center;"><input type="checkbox" name="item[]" value="'+v.takeid+'" /></td>');
        row.push('<td class="name" style="text-align: center;">'+v.username+'</td>');
        row.push('<td class="name" style="text-align: center;">'+v.realname+'</td>');
        row.push('<td class="type" style="text-align: center;">'+v.money+'</td>');
        row.push('<td class="type" style="text-align: center;">'+v.message+'</td>');
        row.push('<td class="identifier" style="text-align: center;">'+getformatdate(v.applydateline)+'</td>');
        if(v.lockdateline!=0){
        	row.push('<td class="identifier" style="text-align: center;">'+getformatdate(v.lockdateline)+'</td>');
        }else{
        	row.push('<td class="identifier" style="text-align: center;">未审核</td>');
        }
       	if(v.complatedateline!=0){
       		row.push('<td class="identifier" style="text-align: center;">'+getformatdate(v.complatedateline)+'</td>');
       	}else{
       		row.push('<td class="identifier" style="text-align: center;">未完成</td>');
       	}
       	var status = {'_0':'已提交','_1':'已审核','_2':'成功','_-1':'已撤销','_all':'全部'};
        row.push('<td class="type" style="text-align: center;">'+status["_"+v.status]+'</td>');
        if(v.status==0){
        	row.push('<td align="center" class="op">[<a href="#" onclick="return op('+v.takeid+',1)">审核</a>][<a href="#" onclick="return op('+v.takeid+',-1)">撤销</a>]</td>');
        }else{
        	var status = {'_0':'已提交','_1':'已审核','_2':'已完成','_-1':'已撤销','_all':'全部'};
        	if(v.status==1){
        		row.push('<td align="center" class="op">[<a href="#" onclick="return op('+v.takeid+',2)">完成</a>][<a href="#" onclick="return op('+v.takeid+',-1)">撤销</a>]</td>');
        	}else{
        		row.push('<td align="center" class="op">['+status["_"+v.status]+']</td>');
        	}
        	
        }
        row.push('</tr>');
        row.push('<tr><td colspan="11" style=" height:50px;"><span style="text-align:right;font-size: 18px;font-weight: bold;">银行卡号：</span><span style="font-size: 20px;font-weight: bold;color:#ff0000;">【'+getFormateBankNumber(v.card)+'】</span>&nbsp;&nbsp;<span style="text-align:right;font-size: 18px;font-weight: bold;">所属银行：</span><span style="font-size: 20px;color:#666666;">【'+v.bankname+'】</span>&nbsp;&nbsp;<span style="text-align:right;font-size: 18px;font-weight: bold;">开户姓名：</span><span style="font-size: 20px;color:#666666;">【'+v.cardname+'】</span></td></tr>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<form name="listform" id="theform"><table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.name" width="10%">帐号</th>
<th fieldname="i.name" width="10%">真实姓名</th>
<th fieldname="i.name" width="10%">取现金额</th>
<th fieldname="i.name" width="20%">备注</th>
<th fieldname="i.name" width="10%">申请时间</th>
<th fieldname="i.name" width="10%">审核时间</th>
<th fieldname="i.name" width="10%">完成时间</th>
<th fieldname="i.name" width="10%">状态</th>
<th style="width:10%">操作</th>
</tr>
<tbody class="moduletbody">
	
</tbody>
</table>
<div id="pp"></div>

<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>
</form>
<br>
<div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
<script type="text/javascript">
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
    $.post("/admin/takemoney/getListAjax.html",
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
function op(takeid,status){
	$.messager.confirm('确认对话框', '请再次确定操作!', function(r){
		if (r){
		    $.post('/admin/takemoney/op.html',{takeid:takeid,status:status},function(message){
		    	if(message==1){
		    		$.messager.show({
						title:'操作提示',
						msg:'操作成功',
						timeout:1000,
						showType:'slide'
					});
					$(".pagination-page-list").trigger('change');
					return false;
		    	}else{
		    		$.messager.show({
						title:'操作提示',
						msg:'操作失败',
						timeout:1000,
						showType:'slide'
					});
					return false;
		    	}
		    });
		}else{
			return false;
		}
	});
	return false;
}
function _review(e,status){
	$('#newslisttab ul li').removeClass('active');
	$(e).parent('li').addClass('active');
	$("#status option[value='"+status+"']").prop('selected',false);
	$("#status option[value='"+status+"']").prop('selected','selected');
	$(".pagination-page-list").trigger('change');
	return false;
}
$(function(){
	$("#status").change(function(){
		$('#newslisttab ul li').removeClass('active');
		$('#newslisttab ul li[tag='+$(this).val()+']').addClass('active');
		$(".pagination-page-list").trigger('change');
		return false;
	});
});
</script>
</body>

<?php
	$this->display('admin/footer');
?>