<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=1200, user-scalable=no" name="viewport"/>
    <title>e板会-网校商城</title>
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
<div class="schoolshoptops">
</div>
<div class="mainjs">
    <a class="ebhintro" href="javascript:void(0)" style="cursor:default;">
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/shop02.jpg" />
    </a>
    <div class="rishtdt">
    	<h2 class="titrise" style="margin-top:30px;">网校商城可以做什么？</h2>
		<p class="prits">学员可以把闲置的一些学习用具、辅导资料或者一些服务销售给有需要的同学。</p>
        <p class="prits">老师可以把自己写的书发布到网校商城里面，让学生直接进行购买。</p>
        <p class="prits">商家可以把一些商品有针对性的植入到相应的网校。</p>
    </div>
</div>
<div class="schoolshop easingobj">
	<div class="nsireshis shopcj">
        <h2 class="titbsce">适用场景</h2>
        <div class="shrsre1s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景一</p>
                <p class="chst2s">二手商品交易</p>
                <p class="chst3s">即将毕业，以前花大价钱买的辅导材料，学习用具等产品可以以较低的价格销售给低年级的学弟、学妹们，双方都能受惠。</p>
            </div>
        </div>
        <div class="shrsre2s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景二</p>
                <p class="chst2s">答疑服务交易</p>
                <p class="chst3s">学习好的同学可以帮其他学生回答问题，适量收费，体现自己的价值。既能帮助他人，自己也获取相应报酬。
</p>
            </div>
        </div>
        <div class="shrsre3s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景三</p>
                <p class="chst2s">商家新品发布</p>
                <p class="chst3s">根据每个网校的受众群体不同，发布适合各种不同群体的商品供学员选择。帮助商家扩展业务。</p>
            </div>
        </div>
    </div>
</div>

<div class="zhusre easingobj" style="height:380px;">
	<div class="cnasrse">
    	<h2 class="zhusertit">使用案例</h2>
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/shop07.jpg" />
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
