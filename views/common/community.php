<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=1200, user-scalable=no" name="viewport"/>
    <title>e板会-社区圈子</title>
    <meta name="keywords" content="<?=empty($seoInfo['keyword'])?$this->get_keywords():$seoInfo['keyword']?>" />
    <meta name="description" content="<?=empty($seoInfo['description'])?$this->get_description():$seoInfo['description']?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/ebh2/css/ebhtop.css<?=getv()?>" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/ebh2/css/intro.css<?=getv()?>" />
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/common.js<?=getv()?>" type="text/javascript"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
    <script src="http://static.ebanhui.com/ebh/js/jquery.superslide.2.1.1.js" type="text/javascript"></script>
<style>
.rishtdt .prits{
	margin-top:40px;
}
</style>
</head>
<body>
<?php $this->display('common/newheader');?>
<div class="communitytops">
</div>
<div class="mainjs">
    <a class="ebhintro" href="javascript:void(0)" style="cursor:default;">
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/community02.jpg" />
    </a>
    <div class="rishtdt">
    	<h2 class="titrise" style="margin-top:30px;">社区圈子能做什么？</h2>
		<p class="prits">兴趣爱好交流，让互不相识的人通过相同的兴趣爱好通过圈子进行交流、进步。</p>
        <p class="prits">通过圈子进行人脉扩展，助力事业发展。</p>
		<p class="prits">通过圈子可以进行资源整合，需求尽在掌握，可以进行精准营销。</p>
    </div>
</div>
<div class="community easingobj">
	<div class="nsireshis comtey">
        <h2 class="titbsce">适用场景</h2>
        <div class="shrsre1s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景一</p>
                <p class="chst2s">结交更多具有<br />相同爱好的好友</p>
                <p class="chst3s">通过某一个圈子，互不认识的人因为相同的爱好成为朋友，互相交流，共同进步。</p>
            </div>
        </div>
        <div class="shrsre2s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景二</p>
                <p class="chst2s">通过圈子组织活动</p>
                <p class="chst3s">再也不用担心没人一起进行户外活动了，通过圈子发布活动，时间、地点、人员一目了然。兴趣相同，活动变得更有趣味。</p>
            </div>
        </div>
        <div class="shrsre3s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景三</p>
                <p class="chst2s">通过圈子找到一些<br />生意上的合作伙伴</p>
                <p class="chst3s">每个圈子都有准确的定位，通过圈子可以在结交朋友的同时扩展人脉，从而在生意上达到合作，成为生意上的合作伙伴。</p>                
            </div>
        </div>
    </div>
</div>

<div class="zhusre easingobj" style="height:380px;">
	<div class="cnasrse">
    	<h2 class="zhusertit">使用案例</h2>
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/community07.jpg" />
    </div>
</div>
<div class="falsrfe">
    <div class="ebhcode"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/code.png" /><span>微信公众号“e板会”</span></div>
    <div class="ebhapp"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/code1.png" /><span>“e板会”-APP</span></div>
    <div class="srzrder">
        <ul>
            <li class="lsrret">浙江省杭州市江干区钱江新城五星路188号荣安大厦25F</li>
            <li class="ewtser">0571-87757303</li>
            <li class="reyrde">
                <a target="_blank" href="<?=geturl('about')?>">关于</a>&nbsp;&nbsp;&nbsp;
                <a target="_blank" href="<?=geturl('conour')?>">业务联系</a>
            </li>
        </ul>
    </div>
    <div class="fldty">
        <div style="text-align:center">
            <span style="color:#555">
            <i></i>
            浙公网安备 33010602003467号
            </span>
            <a href="http://www.miibeian.gov.cn/" target="_blank" style="color:#555">浙B2-20160787</a>
            <span style="color:#555">Copyright © 2011-<?=date('Y')?> ebh.net All Rights Reserved </span></span>
            <br>
        </div>
    </div>
</div>

<?php EBH::app()->lib('Analytics')->get('baidu','www_ebh')?>
</body>
</html>
