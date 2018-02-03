<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>主贴管理 - 主贴列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/posts.html">主贴列表</a></td>
			<td  class="active"><a href="/admin/posts/detail.html">主贴详情</a></td>
			<td ><a href="/admin/posts/add.html" class="add">添加主贴</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>主贴标题</th><td><?=$posts['subject']?></td></tr>
<tr><th>主贴内容</th><td><?=$posts['content']?></td></tr>
<tr><th>所属老师</th><td><?=$posts['username']?></td></tr>
<tr><th>所属教室</th><td><?=$posts['crname']?></td></tr>
<tr><th>发布时间</th><td><?php echo date('Y-m-d H:i:s',$posts['dateline']);?></td></tr>
<tr><th>帖子状态</th><td><?php if($posts['status']==1){echo '屏蔽';}else{echo '正常';}?></td></tr>
<tr><th>标签</th><td><?=$posts['tag']?></td></tr>
</table>
<div class="buttons">
<input type="reset"	 name="valuereset" value="返回" onclick='window.location.href="/admin/posts.html"'>
 
</div><br>
<div id="footer">
	<span>Zhejiang Svnlan Technologies 2011. </span>
</div>
</body>

<?php $this->display('admin/footer');?>