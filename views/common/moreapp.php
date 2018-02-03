<?php $this->display('common/header');?>
<script type="text/javascript" src="http://static.ebanhui.com/pan/js/slideBox.js"></script>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/money.css?v=20160408" />
<style>
.top {
    width: 100%;
    height: 320px;
    overflow: hidden;
    margin: 0 auto;
	opacity: 1; 
	background:url('http://static.ebanhui.com/ebh/tpl/2016/images/toplad1.jpg?v=20160408001')  no-repeat center;
}
.lsitrs{
	height:320px;
}
</style>
<div class="lsitrs">
<div id="IndexBanner" class="top main_banner1"  style="">
	<div class="slider" >
	<a href="http://www.ebh.net/createroom.html" target="_blank" class="stntrs"></a>
		
		
     </div>
</div>
	<div class="slide-point-box">
			<span data-index="1" class="cur-point"></span>
			<span data-index="2" class=""></span>
		</div>
</div>

<div class="kshut">
	<div class="heyrty">
    	<h2 class="ksthry"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/tiatwar1.jpg?v=20160405001" /></h2>
        <ul>
        	<li class="ksfets">
            	<a href="http://intro.ebh.net" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur1.jpg?v=20160405001" /></a>
            </li>
        	<li class="ksfets">
            	<a href="http://www.ebh.net/intro/livesystem.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur2.jpg?v=20160405001" /></a>
            </li>
        	<li class="ksfets">
            	<a href="http://soft.ebh.net/ebhbrowser.exe"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur3.jpg?v=20160405001" /></a>
            </li>
        	<li class="ksfets">
            	<a href="http://pan.ebh.net/" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur4.jpg?v=20160405001" /></a>
            </li>
        	<li class="ksfets">
            	<a href="http://jiazhang.ebh.net/" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur5.jpg?v=20160405001" /></a>
            </li>
        	<li class="ksfets">
            	<a href="http://www.ebh.net/intro/app.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur6.jpg?v=20160405001" /></a>
            </li>
        	<li class="ksfets">
            	<a href="http://www.ebh.net/freeresource.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur7.jpg?v=20160405001" /></a>
            </li>
            <!-- 精品课程 -->
            <li class="ksfets">
            	<a href="http://www.ebh.net/ke.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/jingpinicon.jpg?v=20160607001" /></a>
            </li>
        </ul>
    	<h2 class="ksthry"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/tiatwar2.jpg?v=20160405001" /></h2>
        <ul>
        	<li class="ksfets">
            	<a href="http://pay.ebh.net/ipay.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur8.jpg?v=20160405001" /></a>
            </li>
        	<li class="ksfets">
            	<a href="http://www.ebh.net/coupon.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur9.jpg?v=20160405001" /></a>
            </li>
			<li class="ksfets">
            	<a href="http://www.ebh.net/intro/schooliswhat.html
" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/nettur10.jpg?v=20160408001" /></a>
            </li>
            <li class="ksfets">
            	<a href="http://www.ebh.net/eth.html" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/weitong.jpg" /></a>
            </li>
        </ul>
    </div>
</div>
<script language="JavaScript">
    //定时器
	var timer ;
var BodyHeight,BodyWidth;
	var yon = 0;                    
	var xon = 0;
	var step = 1;
	var Hoffset = 0;                    
	var Woffset = 0; 
	var imgcount = 2;
	$(function(){
		timer = setInterval(function(){rotateBanner(1)},5000);
		// $(".slider_menu").hover(function(){
			// clearInterval(timer);
		// }, function(){
			// timer = setInterval(function(){rotateBanner(1)},5000);
		// });
       // BodyHeight=parseInt(document.body.clientHeight);
       // BodyWidth=parseInt(document.body.clientWidth);
            //alert(BodyWidth);
	});
	// begin:首页视觉区效果
	var _img = 1;
	function rotateBanner(step){
		_img+=step;
		if (_img>imgcount) {
			_img=1;
		} else if (_img<=0) {
			_img=imgcount;
		}
		$("#IndexBanner").stop().animate({opacity: 0},300, function(){
			$(this).css("background-image", "url(http://static.ebanhui.com/ebh/tpl/2016/images/toplad"+_img+".jpg?v=20160405001)").animate({opacity: 1},300);
		});
		
		$('.slide-point-box span').removeClass('cur-point');
		$('.slide-point-box span[data-index='+_img+']').addClass('cur-point');
		// $(".slider").stop().animate({backgroundPositionY: 99}, 300, function(){
			// $(this).css("background-image", "url(images/bar_0"+_img+".png)").animate({backgroundPositionY: 0}, 200);
		// });
	}
	// end
	$('.slide-point-box span').click(function(){
		rotateBanner($(this).attr('data-index')-_img);
		// $('.slide-point-box span').removeClass('cur-point');
		// $(this).addClass('cur-point');
		clearInterval(timer);
		timer = setInterval(function(){rotateBanner(1)},5000);
	});
</script>
<?=$this->display('common/footer');?>
