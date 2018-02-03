<?php
if (! defined ( 'IN_EBH' )) {
	exit ( 'Access Denied' );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>e板会管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<link href="http://static.ebanhui.com/ebh/admin/skins/orange/images/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/admin/include/admin.js"></script>
</head>


<frameset rows="90,*" frameborder="no" border="0" framespacing="0" id="bodyframeset">
  <frame src="?action=toolbar" name="topframe" scrolling="No" id="topframe" title="topframe" />
  <frameset id="mainframeset" cols="200,*" frameborder="no" border="0" framespacing="0">
    <frame src="?action=sidemenu&upaction=settings" name="leftframe" scrolling="yes" noresize id="leftframe" title="leftframe" />
    <frame src="?action=main" name="mainframe" id="mainframe" title="mainframe" />
  </frameset>
</frameset>
<noframes>
<body>


<?php
$this->display('admin/footer');
?>