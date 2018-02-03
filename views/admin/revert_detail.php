<?php
	$this->display('admin/header');
?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>主贴评论管理 - 评论列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/revert.html">评论列表</a></td>
			<td  class="active"><a href="#">评论详情</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>主贴标题</th><td><?=$r['subject']?></td></tr>
<tr><th>主贴内容</th><td><?=$r['content']?></td></tr>
<tr><th>所属老师</th><td><?=$r['teacher']?></td></tr>
<tr><th>所属教室</th><td><?=$r['crname']?></td></tr>
<tr><th>发布时间</th><td><?php echo date('Y-m-d H:i:s',$r['rtime']);?></td></tr>
<tr><th>帖子状态</th><td><?php if($r['status']==1){echo '屏蔽状态';}else{echo '正常状态';}?></td></tr>
<tr><th>回复用户</th><td><?=$r['username']?></td></tr>
<tr><th>回复时间</th><td><?php echo date('Y-m-d H:i:s',$r['rtime']);?></td></tr>
<tr><th>回复内容</th><td><p><?=$r['rcontent']?></p></td></tr>
<input type="hidden" name="rid" value="<?=$r['rid']?>" />
</table>
<div class="buttons">
<input type="reset"	 name="valuereset" value="返回" onclick='window.location.href="/admin/revert.html"'>
 
</div><br>
<div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
	

<?php 
	$this->display('admin/footer');
?>