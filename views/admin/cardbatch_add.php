<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">充值卡批次管理 -  <?=$op=='edit'?'修改':'查看'?>批次</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/cardbatch.html">浏览充值卡批次</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/cardbatch/changeInfo.html">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<input type="hidden" name="bid" value="<?=$oneInfo['bid']?>" />
<input type="hidden" name="token" value="<?=$token?>">

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

<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>充值卡批次号</th><td><?=$oneInfo['bname']?></td></tr>
<tr><th>创建的帐户</th><td><?=$oneInfo['uidname']?></td></tr>
<tr><th>创建时间</th><td><?=date('Y-m-d',$oneInfo['dateline'])?></td></tr>
<tr><th>最后修改的账户名</th><td><?=$oneInfo['lastmodifiedname']?></td></tr>
<tr><th>最后修改时间</th><td><?=date('Y-m-d',$oneInfo['lastmodified'])?></td></tr>
<tr><th>面值</th><td><?=$oneInfo['price']?></td></tr>
<tr>
	<th>状态</th>
	<?php if($op=='view'){?>
	<td><?php if($oneInfo['status']==-1){echo '锁定';}else{echo '正常';}?></td>
	<?php }else{?>
	<td>
		<select name="status">
			<option <?php if($oneInfo['status']==-1){echo 'selected=selected';}?> value="-1">锁定</option>
			<option <?php if($oneInfo['status']==0){echo 'selected=selected';}?>>正常</option>
		</select>
	</td>
	<?php }?>
</tr>
<tr><th>所属代理商</th><td>
<?=$agentSelect?>
</td></tr>
<tr><th>该批次下的所有卡号</th><td><a href="/admin/card.html?bname=<?=$oneInfo['bname']?>">点击此处查看</a></td></tr>

</table>
<div class="buttons">
	<?php if($op=='view'){?>
		<input type="reset"	 name="valuereset" value="返回" onclick='window.location.href="/admin/cardbatch.html"'>
	<?php }else{?>
		<input type="submit" name="valuesubmit" value="提交保存" class="submit">
		<input type="reset" name="valuereset" value="重置">
	<?php }?>
</div>
</form><br>
</body>

<?php $this->display('admin/footer');?>