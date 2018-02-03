<?php
if (! defined ( 'IN_EBH' )) {
	exit ( 'Access Denied' );
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="width=1000, user-scalable=no" name="viewport"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<?php $v=getv();?>
<link href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/drtu.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/pageztree.css<?=$v?>">

<script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>

<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/common.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/quebase.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/quefix.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/sinchoiceque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/mulchoice.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/truefalseque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/textque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/textline.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/fillque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/audio.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/subjective.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/render.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/wordque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/jquery.base64.js<?=$v?>"></script>


<script  src="http://static.ebanhui.com/exam/newjs/achor.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/ebh/js/JSON.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/newjs/json2.js<?=$v?>"></script>


<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/js/jquery/showmessage/css/default/showmessage.css<?=$v?>" />  
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/jquery/showmessage/jquery.showmessage.js<?=$v?>"></script>
<!-- 引入ztree -->
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css<?=$v?>" type="text/css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.excheck-3.5.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js<?=$v?>"></script>