<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/lnclass.css" />
<script src="http://static.ebanhui.com/draw/plugins/jquery/jquery-1.9.1.min.js"></script>
<title>无标题文档</title>
</head>

<body style="background:#f3f3f3;">
<div class="hustdt">
	<div class="lsirns">
        <div class="jhiostr"><?= $title ?></div>
        <a class="tsirigbtn" href="javascript:submit();">提交</a>
        <div class="husira">
        	<!-- <iframe scrolling="" name="iframeSon" marginheight="0" marginwidth="0" frameborder="0" width="970" height="800" src="http://ss.ebh.net/drawingboard.html?imgsrc=<?= $question['options']['urlpath'] ?>"></iframe> -->
        	<!-- <iframe scrolling="" marginheight="0" marginwidth="0" frameborder="0" width="970" height="800" src="http://ss.ebh.net/drawingboard.html?uid=23&qid=24&crid=48&icid=45"></iframe> -->
            <iframe scrolling="" name="iframeSon" marginheight="0" marginwidth="0" frameborder="0" width="970" height="800" src="http://ss.ebh.net/drawingboard.html?imgsrc=<?= $imgsrc ?>"></iframe>
    	</div>
    </div>
</div>
<script type="text/javascript">
	function submit(){
         // $('#nav-edit-clear').click();
		window.frames["iframeSon"].document.getElementById('saveImg').click();
        window.frames["iframeSon"].document.getElementById('nav-edit-clear').click();
	}
</script>
</body>
</html>
