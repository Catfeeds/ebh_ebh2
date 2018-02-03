<!DOCTYPE html>
<html>
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?= empty($systemsetting['metakeywords']) ? $roominfo['crlabel'] : $systemsetting['metakeywords'] ?>" />
	  <!-- 微信端 过来查看 允许缩放 -->
    <!-- 公共手机自适应 -->
    <script type="text/javascript" src="http://static.ebanhui.com/design/wapdesign/js/mobile.js"></script>  
    <!-- 公共手机自适应 -->  
    <meta name="description" content="<?= empty($systemsetting['metadescription']) ? $roominfo['summary'] : $systemsetting['metadescription']?>" />
    <?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
    <?php }?>
    <title><?=$roominfo['crname']?><?=!empty($systemsetting['subtitle']) ?' - '. $systemsetting['subtitle'] : ''?></title>
    <!-- 公共css,js -->
    <link rel="stylesheet" href="http://static.ebanhui.com/design/wapdesign/css/common.css?version=20160614001">
  	<link rel="stylesheet" href="http://static.ebanhui.com/design/wapdesign/css/module.css?version=20160614001">
  	<script src="http://static.ebanhui.com/design/js/jquery-1.11.1.min.js"></script> 
    <!-- 公共css,js -->
  <style>
    .content {      
      height: <?=$settings->height;?>rem; /*page.height*/
      background-color: <?=$settings->pg;?>; /*page.pg*/
      <?php if(isset($settings->pgImage)){?>
        background-image: <?=$settings->pgImage->backgroundImage;?>;
        background-size: <?=$settings->pgImage->backgroundSize;?>;
        background-repeat: <?=$settings->pgImage->backgroundRepeat;?>;
        background-attachment: <?=$settings->pgImage->backgroundAttachment;?>;
      <?php } ?>
      background-position: top center;
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
  <!-- 公共头部 -->
  <div class="comHead" style="z-index:100;position: fixed;top: 0;left:0;width: 10rem;height: <?=$settings->top;?>rem;">
    <?=$head?>
  </div>
  <!-- 公共头部 -->
  <!-- 主体 -->
  <div class="content">
    <?=$body?>
  </div>
  <!-- 主体 -->
  <!-- 公共尾部 -->
  <div class="comFoot" style="z-index:100;position: fixed;bottom:0;left:0;width: 10rem;height: <?=$settings->foot;?>rem;">
    <?=$foot?>
  </div>
  <!-- 公共尾部 -->
<!-- 统计代码开始 -->
<?php
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
	echo $systemsetting['analytics'];
} else {
	EBH::app()->lib('Analytics')->get('baidu');
}
?>
<!-- 统计代码结束 -->
</body>
<!-- console.log -->
<!-- <script src="http://g.alicdn.com/mtb/ctrl-mjlogger/1.0.7/mjlogger.js"></script> -->
<!-- 公共尾部js -->
<script src="http://static.ebanhui.com/design/wapdesign/js/module.js?v=1236"></script>
<!-- 公共尾部js -->
<!-- <script src="http://static.ebanhui.com/design/js/main.js"></script>
<script src="http://static.ebanhui.com/design/js/home.js"></script>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script> -->
</html>