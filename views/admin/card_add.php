<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">充值卡管理 -  添加充值卡</h1></td>
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
<form method="post" action="/admin/card/handle.html">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="formhash" value="<?=$formhash?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>生成模式<em>*</em><p>分两张模式：一种是只要生成一个充值卡，另一种为可批量生成多个充值卡</p></th>
<td><input name="addtype" type="radio" value="oneadd" checked="checked" />单条添加&nbsp;&nbsp;<input name="addtype" type="radio" value="manyadd" />批量添加</td></tr>
<tr><th>生成数量<em>*</em><p>生成充值卡的数量</p></th><td><input type="text" name="num" id="num" value="1" readonly="readonly" ></td></tr>
<tr><th>卡的面值<em>*</em><p>向卡里充值的面值</p></th><td>
<!-- <?=$priceSelect?> -->
<select name="price" id="price">
	<option value="0">全部</option>
	<option value="100.00">100</option>
	<option value="200.00">200</option>
	<option value="500.00">500</option>
	<option value="1000.00">1000</option>
</select>
&nbsp;￥</td></tr>
<tr><th>所属代理商<p></p></th><td>
	<?=$agentSelect?>
</td></tr>
</table><div class="buttons">
<input type="submit" name="nextsubmit" value="保存并继续" class="submit">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
 
</div>
</form><br>
<script type="text/javascript">
$(function(){
	$("input[name=addtype]").change(function(){
	if($("input[name=addtype]:checked").val()=='oneadd'){
	$("#num").val("1").attr("readonly","readonly");
	}else{
	$("#num").val("1").removeAttr("readonly");
	}
	});
});
</script>
</body>

<?php $this->display('admin/footer');?>