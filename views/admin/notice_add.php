<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>公告管理 - 发布公告</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/notice.html">查看公告</a></td>
			<td  class="active"><a href="/admin/notice/add.html">发布公告</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/notice/handle.html">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="formhash" value="<?=$formhash?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>用户组<em>*</em><p>可以查看公告的用户组。</p></th><td>
	<?=$grouplist?>
</td></tr>
<tr>
	<th>公告内容<p></p></th>
	<td><textarea class="w300" name="message" cols="50" rows="10"> <?=$groupinfo['message']?> </textarea></td>
</tr>
<input type="hidden" name="logid" value="<?=$groupinfo['logid']?>"></input>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
 
</div>
</form><br>
</body>

<?php $this->display('admin/footer');?>