<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript">
        if (self != top) {
            top.location.href = "/";
        }
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?= empty($systemsetting['metakeywords']) ? $roominfo['crlabel'] : $systemsetting['metakeywords'] ?>" />
	<!-- 微信端 过来查看 允许缩放 -->
	<meta name="viewport" content="width=1200, user-scalable=<?=(is_weixin()==true)?"yes":"no"?>" />
    <meta name="description" content="<?= empty($systemsetting['metadescription']) ? $roominfo['summary'] : $systemsetting['metadescription']?>" />
    <?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
    <?php }?>
    <title><?=!empty($title) ? $title : '子页面标题'?><?=!empty($systemsetting['subtitle']) ?' - '. $systemsetting['subtitle'] : ''?></title>
    <link rel="stylesheet" href="http://static.ebanhui.com/design/css/common.css">
  	<link rel="stylesheet" href="http://static.ebanhui.com/design/css/module.css">
  	<script src="http://static.ebanhui.com/design/js/jquery-1.11.1.min.js"></script> 
  	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" />
    <script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20160614001"></script>
  <style>
    body {
      background-color: <?=$settings->bg;?>; /*page.bg*/
    } 
    .content {
      width: <?=$settings->width;?>; /*page.width*/
      height: <?=$settings->height;?>; /*page.height*/
      background: <?=$settings->pg;?>; /*page.pg*/
    }
    .head {
      height: <?=$settings->top;?>; /*page.top*/
    }
    .middle {
      height: <?=$settings->body;?>; /*page.body*/
    }
    .foot {
      height: <?=$settings->foot;?>; /*page.foot*/
    }
  </style>
  <script>
	//全部变量设置
	var islogin = <?=!empty($user) ? 1 : 0?>;
	var lguser  = <?=!empty($user) ? json_encode($user) : '{}';?>;
	var roominfo = <?=!empty($roominfo) ? json_encode($roominfo):'{}'?>;
  </script>
</head>
<body>
  <div class="content">
    <div class="head">
      <!-- /*module.top*/ -->
      <?=$head?>
      <!-- /*module.top*/ -->
    </div>