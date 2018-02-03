<?php
	$this->display('admin/header');
?>

	<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">产品管理 -  产品列表</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="/admin/product.html">浏览产品</a></td>
			<td ><a href="/admin/product/add.html" class="add">添加产品</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form id='ck' onsubmit="return _search()">
<input type="hidden" name="action" value="product" />
<table cellspacing="0" cellpadding="0" class="toptable"><tr><td>
<label>产品号关键字: </label><input type="text" name="productno" id="productno" value="" size="20" />
<input type="submit" name="selectsubmit" value="查询" class="submit">
</td></tr>
</table>
</form>


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
     	row.push('<td class="productno">'+v.productno+'</td>');
     	row.push('<td class="productname">'+v.productname+'</td>');
     	row.push('<td class="brand">'+v.brand+'</td>');
     	row.push('<td class="marketprice">'+v.marketprice+'</td>');
     	row.push('<td class="memberprice" >'+v.memberprice+'</td>');
     	row.push('<td class="credit" >'+v.credit+'</td>');
     	row.push('<td class="stockqty">'+v.stockqty+'</td>');
     	if(v.type==1){
     		row.push('<td class="type">虚拟产品</td>');
     	}else{
     		row.push('<td class="type">实物产品</td>');
     	}
     	if(v.status==1){
     		row.push('<td class="status">已下架</td>');
     	}else if(v.status==-1){
     		row.push('<td class="status">已删除</td>');
     	}else{
     		row.push('<td class="status">正常</td>');
     	}
     	if(v.status==1){
     		row.push('<td class="nowrap" >[<a href="/admin/product/getOneProduct.html?productid='+v.productid+'">详情</a>]&nbsp;[<a href="/admin/product/add.html?productid='+v.productid+'">编辑</a>]&nbsp;[<a href="#" onclick="return _del('+v.productid+')">删除</a>]&nbsp;[<a href="#" onclick="return changestatus('+v.productid+',0)" >正常</a>]</td>');
     	}else{
     		row.push('<td class="nowrap" >[<a href="/admin/product/getOneProduct.html?productid='+v.productid+'">详情</a>]&nbsp;[<a href="/admin/product/add.html?productid='+v.productid+'">编辑</a>]&nbsp;[<a href="#" onclick="return _del('+v.productid+')">删除</a>]&nbsp;[<a href="#" onclick="return changestatus('+v.productid+',1)" >下架</a>]</td>');
     	}
     	
        row.push('</tr>');
        return row.join('');
    }
</script>
<form method="post" name="listform" id="theform" action="#"  >
<input type="hidden" name="formhash" value="52b016b0" /><table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th fieldname="i.productno">产品号</th>
<th fieldname="i.productname">产品名称</th>
<th fieldname="i.brand">品牌名称</th>
<th fieldname="i.marketprice">市场价</th>
<th fieldname="i.memberprice" width="12%">会员价</th>
<th fieldname="i.credit" width="12%">兑换积分</th>
<th fieldname="i.stockqty" width="20%">库存数量</th>
<th fieldname="i.type">类型</th>
<th fieldname="i.status">状态</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">
</tbody>
</table><table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input id="chkall" type="checkbox" name="chkall" onclick=""><label for="chkall">全选</label>
<input id="noop" name="optype" type="radio" value="0" checked /><label for="noop">不操作</label>&nbsp;&nbsp;
</th></tr>
</table>
<div id="pp"></div>

<div class="buttons">
<input type="submit" name="productsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>

</form><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
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
	    $.post("/admin/product/getListAjax.html",
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

	function changestatus(productid,status){
		$.post('/admin/product/changestatus.html',
				{productid:productid,status:status},
				function(message){
					if(message==true){
						$(".pagination-page-list").trigger('change');
					}
				}
			)
		return false;
	}
	function _del(productid){
		$.post('/admin/product/_delete.html',
				{productid:productid},
				function(message){
					if(message==true){
						$(".pagination-page-list").trigger('change');
					}
				}
			)
		return false;
	}
</script>

<?php 
	$this->display('admin/footer');
?>