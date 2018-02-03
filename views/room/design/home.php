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
	<meta name="viewport" content="width=1200, user-scalable=yes"/>
    <meta name="description" content="<?= empty($systemsetting['metadescription']) ? $roominfo['summary'] : $systemsetting['metadescription']?>" />
    <?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
    <?php }?>
    <title><?=$roominfo['crname']?><?=!empty($systemsetting['subtitle']) ?' - '. $systemsetting['subtitle'] : ''?></title>
    <link rel="stylesheet" href="http://static.ebanhui.com/design/css/kissui.css">
    <link rel="stylesheet" href="http://static.ebanhui.com/design/css/scrollanim.min.css">
    <link rel="stylesheet" href="http://static.ebanhui.com/design/css/common.css">
  	<link rel="stylesheet" href="http://static.ebanhui.com/design/css/module.css">
  	<script src="http://static.ebanhui.com/design/js/jquery-1.11.1.min.js"></script> 
  	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" />
    <script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20160614001"></script>
    <script type="text/javascript" charset="utf-8" src="http://api.map.baidu.com/api?v=2.0&ak=H8Y9OO2Gt8C584uRpzC4LED4"></script>

  <style>     
    body {
      background-color: <?=$settings->bg;?>; /*page.bg*/
      <?php if(isset($settings->bgImage)){?>
        background-image: <?=$settings->bgImage->backgroundImage;?>;
        background-size: <?=$settings->bgImage->backgroundSize;?>;
        background-repeat: <?=$settings->bgImage->backgroundRepeat;?>;
        background-attachment: <?=$settings->bgImage->backgroundAttachment;?>;
      <?php } ?>
      background-position: top center
    } 
    .module a[href]:hover{
      <?php if(isset($settings->fontHover)){?>
        color:<?=$settings->fontHover;?>;
      <?php } ?>
    } 

    .content {
      width: <?=$settings->width;?>; /*page.width*/
      height: <?=$settings->height;?>; /*page.height*/
      background-color: <?=$settings->pg;?>; /*page.pg*/
      <?php if(isset($settings->pgImage)){?>
        background-image: <?=$settings->pgImage->backgroundImage;?>;
        background-size: <?=$settings->pgImage->backgroundSize;?>;
        background-repeat: <?=$settings->pgImage->backgroundRepeat;?>;
        background-attachment: <?=$settings->pgImage->backgroundAttachment;?>;
      <?php } ?>
      background-position: top center
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
  var loginUrl = '<?=geturl('room/design/getajaxhtml')?>';
  var did = <?=!empty($did) ? $did : 0?>;
  </script>
</head>
<body>
  <div class="content">
    <div class="head">
      <!-- /*module.top*/ -->
      <?=$head?>
      <!-- /*module.top*/ -->
    </div>
    <div class="middle">
      <!-- /*module.body*/ -->
      <?=$body?>
      <!-- /*module.body*/ -->
    </div> 
    <div class="foot">
      <!-- /*module.foot*/ -->
      <?=$foot?>
      <!-- /*module.foot*/ -->
    </div>
  </div>
  <!--尾部!-->
<?php
$room = Ebh::app()->room->getcurroom();
$icp = '浙B2-20160787&nbsp;&nbsp;Copyright &copy; 2011-'.date('Y').' ebh.net All Rights Reserved';
if(!empty($room) && !empty($room['icp']))
	$icp = $room['icp'];
?>
<div style="clear:both;"></div>
<div class="fldty">
<div style="text-align:center">
  <span style="color:#666"><?= $icp ?></span>&nbsp;&nbsp;    <br>
    <br>
</div>
</div>
<!-- 统计代码开始 -->
<?php
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
	echo $systemsetting['analytics'];
} else {
	EBH::app()->lib('Analytics')->get('baidu');
}
?>
<!-- 统计代码结束 -->
</body><!-- 
<script src="http://g.alicdn.com/mtb/ctrl-mjlogger/1.0.7/mjlogger.js"></script> -->
<script type="text/javascript" charset="utf-8" src="http://static.ebanhui.com/design/js/home.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.ebanhui.com/design/js/player.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.ebanhui.com/design/js/scrollanim.min.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.ebanhui.com/design/js/main.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.ebanhui.com/design/js/city.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
</html>