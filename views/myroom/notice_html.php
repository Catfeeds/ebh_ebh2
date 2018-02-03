<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport"  content="user-scalable=no">
	<link rel="stylesheet" type="text/css" href="/static/tpl/default/css/base.css" />
	<link rel="stylesheet" type="text/css" href="/static/tpl/default/css/E_ClassRoom.css" />
	<link rel="stylesheet" type="text/css" href="/static/tpl/default/css/tzds.css" />
	<script type="text/javascript" src="/static/js/jquery.js"></script>
	<title>学生通知查看</title>
	<style type="text/css">
		html {background:#f5f5f5;}
	</style>
	<style type='text/css' media='print'>
		.bottali {display: none;}
		.reviewnoitce {display: none;}
	</style>
</head>

<body>
	<div class="waimg">
		<img class="reviewnoitce" style="float:left;" src="/static/tpl/default/images/tongzhitou0114.jpg" />
		<div class="mseng">
			<h2 class="rlyop"></h2>
			<p class="stimes">发送时间：</p>
			<div style="padding:0 30px;"><p class="twotsne"></p></div>
			<div class="bottali" style="text-align:center;">
				<a href="javascript:;" class="huangbbtn printnotice">打 印</a>
				<a href="javascript:;" onclick="window.close()" class="lanbbtn">关 闭</a>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(".printnotice").click(function(){
			window.document.title="打印通知";
			window.print();
		});
	</script>
</body>
</html>