<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=1200, user-scalable=no" name="viewport"/>
    <title>e板会-互动答疑</title>
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
	margin-top:16px;
}
</style>
</head>
<body>
<?php $this->display('common/newheader');?>
<div class="interactquertops">
</div>
<div class="mainjs">
    <a class="ebhintro" href="http://svnlan.ebh.net/course/85495.html" target="_blank">
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/hddy2.jpg" />
    </a>
    <div class="rishtdt">
    	<h2 class="titrise">互动答疑能做什么？</h2>
		<p class="prits">互动答疑是网络学习中必不可少的一部分，他完美模拟了现实场景中的课后答疑过程，甚至比线下场景更加高效，是辅助性很强的功能模块。</p>
        <p class="prits">通常学生提出问题由助教或者同学进行针对性的回答，在答疑过程中教师与学生，学生与学生的互动性较强，可以实现一对一或者一对多的直接交流。</p>
        <p class="prits">交流过程形式自由，支持文字、图片、表情、画板、语音等各类形式意义，使交流过程生动有趣，不再单调。并且模块中还引入了积分、红包、佣金等游戏规则。</p>
		<p class="prits">目的在于发挥网络学校中20%的优秀学生去帮助80%热爱学习的学生。让学习无处不在，让学习形式不再是枯燥的被动接受。</p>
    </div>
</div>
<div class="queshrites easingobj">
	<div class="nsireshis quensireshis">
        <h2 class="titbsce">适用场景</h2>
        <div class="shrsre1s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景一</p>
                <p class="chst2s">课堂答疑</p>
                <p class="chst3s">将有限的课堂空间转移至无限的网络中,</p>
                <p class="chst3s">让每一位学生都有表达想法的机会</p>
            </div>
        </div>
        <div class="shrsre2s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景二</p>
                <p class="chst2s">课后答疑</p>
                <p class="chst3s">将有限的课堂时间转移至无限的网络中,</p>
                <p class="chst3s">让45分钟延长至随时随地可以提问、解答</p>
            </div>
        </div>
        <div class="shrsre3s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">场景三</p>
                <p class="chst2s">互助百科</p>
                <p class="chst3s">不仅仅局限于课堂知识，</p>                
                <p class="chst3s">可以将你的任何问题发布上去，总能遇到可以解决你问题的同学</p>
            </div>
        </div>
    </div>
</div>

<div class="zhusre easingobj" style="height:380px;">
	<div class="cnasrse">
    	<h2 class="zhusertit">使用案例</h2>
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/hddy03.jpg" />
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
