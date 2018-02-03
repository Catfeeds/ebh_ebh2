<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>教师分组导入</title>
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
</head>
<body>
	<?php
		$groups = array('语文','数学','英语','物理','化学','生物','政治','历史','地理','通用技术','信息技术','音乐','体育','美术');
	?>
	<form action="<?=geturl('tgimport')?>" method="post" >
		<?= $Upcontrol->upcontrol('xls',4,null,'temp');?><br />
		<input type="checkbox" name="d" value="1"> 默认分组:语文,数学,英语,物理,化学,生物,政治,历史,地理,通用技术,信息技术,音乐,体育,美术<br /><br />
		<input type="submit" value="开始导入">
	</form>
</body>
</html>