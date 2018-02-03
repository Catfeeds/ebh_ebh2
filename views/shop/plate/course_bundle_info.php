<?php $this->display('shop/plate/headernew');?>
<style>

/*跨webview需要手动指定位置*/

.mui-plus header.mui-bar {
	display: none!important;
}
.mui-plus .mui-bar-nav~.mui-content {
	padding: 0!important;
}

.mui-plus .plus{
	display: inline;
}

.plus{
	display: none;
}

#topPopover {
	position: fixed;
	top: 16px;
	right: 6px;
}
#topPopover .mui-popover-arrow {
	left: auto;
	right: 6px;
}
span.mui-icon {
	font-size: 14px;
	color: #007aff;
	margin-left: -15px;
	padding-right: 10px;
}
.mui-popover {
	height: 300px;
}
.mui-content .mui-table-view:after {
	background:#fff;
}
.mui-table-view.mui-grid-view .mui-table-view-cell {
	text-align:left;
}
.mui-table-view:after ,.mui-table-view:before{height:0px}
.mui-pull-bottom-tips {
	text-align: center;
	background-color: #efeff4;
	font-size: 15px;
	line-height: 40px;
	color: #777;
}
.mui-table-view .mui-view-cell {
	border-bottom:solid 1px #ddd;
}
#mainscroll .mui-table-view-cell:after {background:#ddd;}
.mui-bar a:hover {text-decoration:none;}
.mui-preview-image.mui-fullscreen {
	position: fixed;
	z-index: 20;
	background-color: #000;
}
.mui-preview-header,
.mui-preview-footer {
	position: absolute;
	width: 100%;
	left: 0;
	z-index: 10;
}
.mui-preview-header {
	height: 44px;
	top: 0;
}
.mui-preview-footer {
	height: 50px;
	bottom: 0px;
}
.mui-preview-header .mui-preview-indicator {
	display: block;
	line-height: 25px;
	color: #fff;
	text-align: center;
	margin: 15px auto 4;
	width: 70px;
	background-color: rgba(0, 0, 0, 0.4);
	border-radius: 12px;
	font-size: 16px;
}
.mui-preview-image {
	display: none;
	-webkit-animation-duration: 0.5s;
	animation-duration: 0.5s;
	-webkit-animation-fill-mode: both;
	animation-fill-mode: both;
}
.mui-preview-image.mui-preview-in {
	-webkit-animation-name: fadeIn;
	animation-name: fadeIn;
}
.mui-preview-image.mui-preview-out {
	background: none;
	-webkit-animation-name: fadeOut;
	animation-name: fadeOut;
}
.mui-preview-image.mui-preview-out .mui-preview-header,
.mui-preview-image.mui-preview-out .mui-preview-footer {
	display: none;
}
.mui-zoom-scroller {
	position: absolute;
	display: -webkit-box;
	display: -webkit-flex;
	display: flex;
	-webkit-box-align: center;
	-webkit-align-items: center;
	align-items: center;
	-webkit-box-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	left: 0;
	right: 0;
	bottom: 0;
	top: 0;
	width: 100%;
	height: 100%;
	margin: 0;
	-webkit-backface-visibility: hidden;
}
.mui-zoom {
	-webkit-transform-style: preserve-3d;
	transform-style: preserve-3d;
}
.mui-slider .mui-slider-group .mui-slider-item img {
	width: auto;
	height: auto;
	max-width: 100%;
	max-height: 100%;
}
.mui-android-4-1 .mui-slider .mui-slider-group .mui-slider-item img {
	width: 100%;
}
.mui-android-4-1 .mui-slider.mui-preview-image .mui-slider-group .mui-slider-item {
	display: inline-table;
}
.mui-android-4-1 .mui-slider.mui-preview-image .mui-zoom-scroller img {
	display: table-cell;
	vertical-align: middle;
}
.mui-preview-loading {
	position: absolute;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	display: none;
}
.mui-preview-loading.mui-active {
	display: block;
}
.mui-preview-loading .mui-spinner-white {
	position: absolute;
	top: 50%;
	left: 50%;
	margin-left: -25px;
	margin-top: -25px;
	height: 50px;
	width: 50px;
}
.mui-preview-image img.mui-transitioning {
	-webkit-transition: -webkit-transform 0.5s ease, opacity 0.5s ease;
	transition: transform 0.5s ease, opacity 0.5s ease;
}
@-webkit-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@keyframes fadeIn {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@-webkit-keyframes fadeOut {
	0% {
		opacity: 1;
	}
	100% {
		opacity: 0;
	}
}
@keyframes fadeOut {
	0% {
		opacity: 1;
	}
	100% {
		opacity: 0;
	}
}
p img {
	max-width: 100%;
	height: auto;
}
.mui-input-row.fot_box {
	background:#fff;
	margin-top:10px;
	float: left;
}
.mui-card .mui-control-content {
	padding: 10px;
}
.mui-control-content {
	
}
.mui-table-view-cell:after {
	background: #e3e3e3;
}
#item1 .mui-table-view-cell:after {
	background:none;
}
.mui-bar-nav~.mui-content.mui-scroll-wrapper .mui-scrollbar-vertical {top:0;}
.mui-scrollbar-vertical {
	    top: 0;
}
.mui-bar-nav~.mui-content .mui-pull-top-pocket {
    top: 0px;
}
.mui-input-row.fot_box p {
	font-size:unset;
    margin: 0;
    color:unset;
}
.mbaobtn {
    background: #FF6600;
    float: right;
    color: #fff;
    font-size: 14px;
    height: 42px;
    line-break: 42px;
    width: 117px;
    text-align: center;
}
.nobaobtn {
    background: #FF6600;
    float: right;
    color: #fff;
    font-size: 14px;
    height: 42px;
    line-break: 42px;
    width: 117px;
    text-align: center;
}
.cantpaybtn {
    background: #ccc;
    float: right;
    color: #fff;
    font-size: 14px;
    height: 42px;
    line-break: 42px;
    width: 100px;
    text-align: center;
}
.cannotpay{
    background-color:#c8c7cc;
}
.botbst {
    position: fixed;
    height: 42px;
    line-height: 40px;
    left: 0px;
    bottom: 0px;
    border-top: solid 1px #cdcdcd;
    width: 100%;
    background: #fff;
    z-index: 3;
}
.freestatus {
	font-size:14px;
	white-space: normal;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 2;
	word-wrap:break-word
}
.mui-media-body {font-size:17px;}
.huiser ,.other-1 {font-size:17px;}
</style>
	<!--主界面部分-->
	<div class="mui-inner-wrap">
		<div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper" style="background-color:#fff;top:<?php if(!empty($settings['top'])) { echo $settings['top'];}else { echo 0;}?>rem;"">
		<div id="pullrefresh" class=" mui-scroll-wrapper">
			<div class="mui-scroll" style="top:0px;padding-bottom:80px;">
					<div class="mui-input-row align_box">
						<img  src="<?php
						$cover = $data['cover'];
            echo htmlspecialchars($cover, ENT_COMPAT);
            ?>" data-preview-src="<?php echo htmlspecialchars($cover, ENT_COMPAT);?>" data-preview-group="1" />
					</div>
					<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-primary">
						<a class="mui-control-item" id="showOnepic" href="#item1">
						介绍
						</a>
						<a class="mui-control-item mui-active" id="showSecpic"  href="#item2">
						目录
						</a>
					</div>
					<div id="item1" class="mui-control-content">
								<ul class="mui-table-view">
									<li>
											<div style="padding: 0 20px;">
												<h2 class="kuwres"><?php echo $data['name'];?></h2>
												<span class="ketebn">人气：<?php echo $data['views'];?></span>
												<span class="kheter">总课时：<?php echo $data['coursecount'];?>课时</span>
												<div class="lectureteach">
													<p title="<?php echo $data['remark'];?>"><?php echo $data['remark'];?></p>
													<span>课程介绍</span>
												</div>
										</div>
									</li>
									<li>
										<div class="mui-input-row fot_box" style="padding:15px;">
											<?php echo $data['detail'];?>
										</div>
									</li>
								</ul>
					</div>
					<div id="item2" class="mui-control-content mui-active">
						<div >
								<ul class="mui-table-view" id="content-panel">
								<?php if (!empty($data['courses'])) {
									foreach ($data['courses'] as $value) {
								?>
								<li class="mui-table-view-cell"><img class="mui-media-object mui-pull-left" style="max-width: 100px;height: 62px;" src="<?php echo $value['img'];?>"><div class="mui-media-body mui-ellipsis"><?php echo $value['iname'];?><p class="mui-ellipsis freestatus"><?php echo $value['summary'];?></p></div></li>

								<?php }}?>
									
								</ul>
						</div>
					</div>
				</div>
			</div>
		
		</div>
			<?php if(empty($data['permission'])) {?>
			<div class="botbst" style="bottom:<?php if(!empty($settings['foot'])) { echo $settings['foot'];}else { echo 0;}?>rem;">
				<?php if(!empty($data['islimit']) && $data['limitnum']>0){
					//限制了报名人数的
					$color = $data['opencount'] == $data['limitnum']?'#66cc00':'#FF0000';
					?>
					<p class="huiser"><span class="redsrt"><span class="font16">￥</span><?php echo $data['bprice'];?></span></p>
					<p class="huiser">已报名:<span style="color:<?=$color?>;"><?=$data['opencount']?></span>/<?=$data['limitnum']?></p>
				<?php } else {?>
				<p class="huiser">平台使用费<span class="redsrt"><span class="font16">￥</span><?php echo $data['bprice'];?></span></p>
				<?php }?>
				
				<?php if(isset($openstatus) && empty($openstatus)) {?>
					<span class="cantpaybtn">立即报名</span>
				<?php } elseif($data['bprice']!=0) {?>
					<span class="baobtn<?php if (!empty($data['cannotpay'])) { ?> cannotpay<?php } ?>">立即报名</span>
				<?php } else{?>
					<span class="mbaobtn<?php if (!empty($data['cannotpay'])) { ?> cannotpay<?php } ?>">免费开通</span>
				<?php } ?>

			</div>
			<?php } else{?>
				<div class="botbst" style="bottom:<?php if(!empty($settings['foot'])) { echo $settings['foot'];}else { echo 0;}?>rem;">
					<span class="nobaobtn">进入学习</span>
				</div>
			<?php }?>
		<!-- off-canvas backdrop -->
		<div class="mui-off-canvas-backdrop"></div>

		<div class="mui-backdrop mui-active" id="showqcode" style="display: none;"><img style="position: absolute;right: 25%;left: 25%;bottom: 25%;height: 200px;width: 200px;top: 25%;" id="qcode" src=""></div>
		</div>
	</div>
		<script src="../static/mui/js/mui.zoom.js"></script>
		<script src="../static/mui/js/mui.previewimage.js"></script>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/raphael-2.1.0-min.js'></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/qrcodesvg.js'></script>
		<script>

		$('.nobaobtn').on('tap',function(){
			window.location.href="http://wap.ebh.net/myroom/folder.html";
		});
		$('.baobtn').on('tap',function(){
		    if ($(this).hasClass('cannotpay')) {
		        return false;
            }
			window.location.href="http://wap.ebh.net/ibuy/<?php echo $data['bid'];?>.html?bundled=1&client=1&crid=<?php echo $roomInfo['crid'];?>";
		});
		$('.mbaobtn').on('tap',function(){
            if ($(this).hasClass('cannotpay')) {
                return false;
            }
			window.location.href="http://wap.ebh.net/ibuy/<?php echo $data['bid'];?>.html?bundled=1&client=1&crid=<?php echo $roomInfo['crid'];?>";
		});
		var _w = parseInt($(window).width());//获取浏览器的宽度
		$(".mui-input-row img").each(function(i){
		    var img = $(this);
		    var realWidth;//真实的宽度
		    var realHeight;//真实的高度
		        //这里做下说明，$("<img/>")这里是创建一个临时的img标签，类似js创建一个new Image()对象！
		        $("<img/>").attr("src", $(img).attr("src")).load(function() {
		        realWidth = this.width;
		        realHeight = this.height;
		        //如果真实的宽度大于浏览器的宽度就按照100%显示
		        if(realWidth>=_w){
		            $(img).css("width","100%").css("height","auto");
		        }
		        else{//如果小于浏览器的宽度按照原尺寸显示
		            $(img).css("width",realWidth+'px').css("height",realHeight+'px');
		        } 
		    });
		});	

</script>
		<div id="__mui_previewimage" class="mui-slider mui-preview-image mui-fullscreen"><div class="mui-preview-header"><span class="mui-preview-indicator"></span></div><div class="mui-slider-group"></div><div class="mui-preview-footer mui-hidden"></div><div class="mui-preview-loading"><span class="mui-spinner mui-spinner-white"></span></div></div>
<?php $this->display('shop/plate/footers');?>
