<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>主贴管理 - 主贴列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/posts.html">主贴列表</a></td>
			<td ><a href="/admin/posts/detail.html">主贴详情</a></td>
			<td ><a href="/admin/posts/add.html" class="add">添加主贴</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form method="post" action="/admin/posts/handle.html">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="postsid" value="<?=$posts['postsid']?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>主贴标题</th><td><input type="text" class="w150" name="subject"  value="<?=$posts['subject']?>" /></td></tr>
<tr><th>主贴内容</th><td>
	<?php $editor->createEditor('content',"100%","300px",$posts['content']); ?>
</td></tr>
<tr><th>标签</th><td><input type="text" class="w150" name="tag"  value="<?=$posts['tag']?>" /><em>多个标签用逗号隔开，例如：上海，杭州</em></td></tr>
<?php $this->widget('bth_widget',array('hot'=>$posts['hot'],'top'=>$posts['top'],'best'=>$posts['best']));?>
</table></table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
 
</div><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>


<?php $this->display('admin/footer');?>