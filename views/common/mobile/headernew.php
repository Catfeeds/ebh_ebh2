<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?=!empty($roominfo['crname']) ? $roominfo['crname'] : empty($roomdetail['crname'])?$roominfo['crname']:$roomdetail['crname']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

<!--标准mui.css-->
<link href="/static/mui/css/mui.min.css?v=2017060901" rel="stylesheet">
<!--App自定义的css-->
<link href="/static/mui/css/app.css?version=20180112001" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/static/mui/css/mui.picker.min.css" />
<?php if (!empty($head)) {?>
    <link rel="stylesheet" href="http://static.ebanhui.com/design/wapdesign/css/common.css?version=20160614001">
    <link rel="stylesheet" href="http://static.ebanhui.com/design/wapdesign/css/module.css?version=20160614001">
    <!-- 公共手机自适应 -->
    <script type="text/javascript" src="http://static.ebanhui.com/design/wapdesign/js/mobile.js"></script>  
    <!-- 公共手机自适应 --> 
<?php }?>
<script src="/static/mui/js/mui.min.js"></script>
<style>
.mui-bar a:hover {text-decoration:none;}
.mui-slider .mui-slider-group .mui-slider-item img { width:auto; }
<?php if(!empty($showlimit)){?>
.popflat {
    position: absolute;
    top: 22px;
    left: 65px;
    opacity: 1;
    background-color: rgba(51, 51, 51, 0.9);
    border-radius: 2px;
    overflow: hidden;
    position: absolute;
    z-index: 9999;
    color: #fff;
    min-width: 170px;
    height:83px;
    line-height:2;
    font-size: 13px;
    text-align: center;
    padding:15px 15px;
	border-radius:10px;
	font-weight:bold;
}
<?php }?>
</style>
<script src="http://static.ebanhui.com/wap/js/jquery/jquery-1.11.0.min.js"></script>
<script src="http://static.ebanhui.com/wap/js/common.js?version=2017081801"></script>
<script src="http://static.ebanhui.com/wap/js/validate.js?version=2015013101"></script>
<script src="http://static.ebanhui.com/wap/js/ajaxload.js?version=20150316001"></script>
<script src="http://static.ebanhui.com/wap/js/jquery.rotate.min.js"></script>
<script src="http://static.ebanhui.com/wap/js/angular.min.js"></script>
<script type="text/javascript">
        //在页面未加载完毕之前显示的loading Html自定义内容

        var _LoadingHtml = '<div id="loadingDiv" style="position:absolute;left:0;width:100%;height:100%;top:0;opacity:1;filter:alpha(opacity=100);z-index:10000;"><div style="position: absolute; cursor1: wait; left:0px; top:0; width: 100%; height: 100%; background: #fff url(http://static.ebanhui.com/wap/images/loading.gif) no-repeat center; font-family:\'Microsoft YaHei\';"></div></div>';

        //呈现loading效果

        document.write(_LoadingHtml);

        //监听加载状态改变

        document.onreadystatechange = completeLoading;

        //加载状态为complete时移除loading效果

        function completeLoading() {

            if (document.readyState == "complete") {

                var loadingMask = document.getElementById('loadingDiv');

                loadingMask.parentNode.removeChild(loadingMask);

            }

        }
<?php if(!empty($showlimit)){?>

$(function(){
	mui.alert('系统检测到您的账号已在其他多个设备登录，为了您的账号安全，系统已经限制您在新设备登录。如有疑问，请联系网校管理员<?=empty($crphone)?'':$crphone?>。', function() {
		location.href = '/myroom/school.html';
	});
})
<?php }?>

</script>
</head>
<body>
<div class="mui-content " style="background:#fff;">
    <?php if (!empty($head) && !empty($settings['top'])) {?>
      <!-- 公共头部 -->
      <div class="headBox" style="height:  <?=$settings['top'];?>rem;">
           <div class="comHead" style="z-index:100;position: fixed;top: 0;left:0;width: 10rem;height: <?=$settings['top'];?>rem;">
            <?=$head?>
           </div>
      </div>
      <!-- 公共头部 -->
    <?php } ?>