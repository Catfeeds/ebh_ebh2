<?php $this->display('admin/header');?>
	<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>专题管理 - 专题列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/special.html">浏览专题</a></td>
			<td ><a href="/admin/special/add.html" class="add">添加专题</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>	
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
	<tr><th>专题分类</th><td><?=$s['name']?></td></tr>
	<tr><th>专题标题</th><td><?=$s['title']?></td></tr>
	<tr><th>横幅图片</th><td>
	<img alt="" width="90px" height="90px" border="1" src="<?=$s['banner']?>">
	<br></td></tr>
	<tr><th>缩略图</th><td>
	<img alt="" width="90px" height="90px" border="1" src="<?=$s['thumb']?>">
	<br></td></tr>
	<tr><th>专题URL</th><td><?=$s['urlrule']?></td></tr>
	<tr><th>专题导语概要</th><td><?=$s['description']?></td></tr>
	<tr><th>SEO关键字</th><td><?=$s['seokeywords']?></td></tr>
	<tr><th>添加专题自定义导航</th><td>

	<table cellpadding="0" cellspacing="0" border="0" class="maintable">
	<tbody>
		<?php 
			$nav = unserialize($s['navigation']);$count=count($nav['subject']);$i=0;
			for($i=0;$i<$count;$i++){
				echo '<tr>';
				echo '<th style="width: 30px">标题:</th><td>'.$nav['subject'][$i].'</td>';
				echo '<th style="width: 30px">地址:</th><td>'.$nav['address'][$i].'</td>';
				echo '<th style="width: 30px">排序:</th><td>'.$nav['order'][$i].'</td>';
				echo '</tr>';
			}
		?>
	</tbody>
	</table>
</td></tr>
<tr><th>专题内容模板</th><td><label><?=$s['tplmain']?>.html.php</label></td></tr>
<tr><th>专题头部模板</th><td><label><?=$s['tplhead']?>.html.php</label></td></tr>
<tr><th>专题脚部模板</th><td><label><?=$s['tplfoot']?>.html.php</label></td></tr>
</table><div class="buttons">
<input type="reset"	 name="valuereset" value="返回" onclick=''>
 
</div><br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
	
<?php $this->display('admin/footer');?>