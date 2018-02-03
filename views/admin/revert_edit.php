<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>主贴评论管理 - 评论列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/revert.html">评论列表</a></td>
			<td ><a href="/admin/revert/detail.html">评论详情</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/revert/handle.html">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>回复内容</th><td>
	<?php $editor->createEditor('rcontent',"100%","300px",$r['rcontent']); ?>
</td></tr>
<input type="hidden" name="rid" value="<?=$r['rid']?>" />
</table></table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
 
</div><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>

<?php $this->display('admin/footer'); ?>