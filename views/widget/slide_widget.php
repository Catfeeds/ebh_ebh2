
<style>
.top {
    width: 100%;
    height: 320px;
    overflow: hidden;
    margin: 0 auto;
	opacity: 1; 
	background: url('<?=$data['imgprestr']?>1<?=$data['imgafterstr']?>')  no-repeat center #65d1ff;
}
</style>
<div class="lsitrs" style="background-color:#57ccff">
<div id="IndexBanner" class="top main_banner1"  style="">
	<div class="slider" >
	<a href="http://www.ebh.net/createroom.html" target="_blank" class="kusrer"></a>
		
		
     </div>
</div>
	<div class="slide-point-box">
		<?php for($i=0;$i<$data['imgcount'];$i++){?>
			<span data-index="<?=$i+1?>" class="<?=$i==0?'cur-point':''?>"></span>
		<?php }?>
		</div>
</div>

<script>
var linkarr = new Array('','http://www.ebh.net/createroom.html','http://www.ebh.net/intro/business.html','http://www.ebh.net/intro/schooltrain.html','http://www.ebh.net/intro/tradition.html','http://www.ebh.net/intro/enterprise.html');
var colorarr = new Array('','#57ccff','#57ccff','#57ccff','#57ccff','#57ccff');

var timer ;
var BodyHeight,BodyWidth;
	var yon = 0;                    
	var xon = 0;
	var step = 1;
	var Hoffset = 0;                    
	var Woffset = 0; 
	var imgcount = <?=$data['imgcount']?>;
	$(function(){
		timer = setInterval(function(){rotateBanner(1)},5000);
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
			$(this).css("background", "url(<?=$data['imgprestr']?>"+_img+"<?=$data['imgafterstr']?>) no-repeat center ").animate({opacity: 1},300);
			$(this).parent().css('background-color',colorarr[_img]);
			$('.kusrer').attr('href',linkarr[_img]);
		});
		
		$('.slide-point-box span').removeClass('cur-point');
		$('.slide-point-box span[data-index='+_img+']').addClass('cur-point');
		
	}
	// end
	$('.slide-point-box span').click(function(){
		rotateBanner($(this).attr('data-index')-_img);
		clearInterval(timer);
		timer = setInterval(function(){rotateBanner(1)},5000);
	});
</script>