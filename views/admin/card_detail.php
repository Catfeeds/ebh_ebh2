<?php $this->display('admin/header');?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1 style="width:550px;">充值卡管理 -  <?=$op=='view'?'查看':'修改'?>充值卡</h1></td>
		<td class="actions" >
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/card.html">浏览充值卡</a></td>
			<td ><a href="/admin/card/add.html" class="add">生成充值卡</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/card/changeInfo.html">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<input type="hidden" name="token" value="<?=$token?>" />
<input type="hidden" name="cardid" value="<?=$oneCard['cardid']?>">
<input type="hidden" name="price" value="<?=$oneCard['price']?>">
<?php $statusinfo = array('-1'=>'锁定','0'=>'正常','1'=>'已充值');?>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>充值卡卡号</th><td><?=$oneCard['cardno']?></td></tr>
<tr><th>所属批次号</th><td><?=$oneCard['bname']?></td></tr>
<tr><th>卡号面值</th><td><?=$oneCard['price']?></td></tr>
<tr><th>生成时间</th><td><?=date('Y-m-d',$oneCard['dateline'])?></td></tr>
<tr><th>充值时间</th><td><?php if(empty($oneCard['uid'])){echo '未充值';}else{echo date('Y-m-d',$oneCard['usedateline']);}?></td></tr>
<tr><th>最后修改时间</th><td><?php if(!empty($oneCard['lastmodified'])){echo date('Y-m-d',$oneCard['lastmodified']);}?></td></tr>
<tr><th>所充值的账号</th><td><?php if(!empty($oneCard['uid'])){echo $oneCard['username'];}else{echo '未充值';}?></td></tr>
<tr><th>状态</th>
	<td>
	<?php if($op=='view'||$oneCard['status']==1){?>
	<?=$statusinfo[$oneCard['status']]?>
	<?php }else{?>
		<select name="statusedit" disabled="disbaled">
		<option value="-1" <?php if($oneCard['status']==-1){echo 'selected=selected';}?> >锁定</option>
		<option value="0" <?php if($oneCard['status']==0){echo 'selected=selected';}?>>正常</option>
		</select>
	<?php }?>
	</td>
</tr>
<tr><th>防伪验证码</th><td><?=$oneCard['cardpwd']?></td></tr>
<tr><th>所属代理商</th><td>
	<?=$agentSelect?>
</td></tr>
<tr><th>创建的用户</th><td>admin</td></tr>
</table><div class="buttons">
<?php if($op=='view'){?>
<input type="reset"	 name="valuereset" value="返回" onclick='window.location.href="/admin/card.html"'>
<?php }else{?>
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset" name="valuereset" value="重置">
<?php }?>
</div>
</form><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>

<?php $this->display('admin/footer');?>