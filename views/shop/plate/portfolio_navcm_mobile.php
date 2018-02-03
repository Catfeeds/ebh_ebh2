<?php $this->display('shop/plate/headernew');?>
<?php if (empty($inner_data['sublist']) && empty($inner_data['list'])) { ?>
<style type="text/css">
.denser{margin:0 !important;}
.see {
    background: #fff;
    display: inline-block;
    padding: 10px;
	width:100%;
}
.see .titled {
    font-size: 26px;
    color: rgb(51, 51, 51);
    text-align: center;
    font-family: 微软雅黑;
	word-wrap: break-word;
	line-height: 30px;
}
.timeb {
    line-height: 30px;
    display: inline-block;
    color: #999;
}
.timeb span {
    margin-left: 10px;
}
.mui-input-row img {
	margin: 0 auto;
    display: block;
}
.mui-input-row {
    word-wrap: break-word;
}
    </style>
<div style="width:100%; margin:0 auto;">
        <div class="see" style="min-height:550px;">
<div class="mui-input-row"><p class="p1s"><?=stripslashes($inner_data['custommessage'])?></p></div>
</div>
</div>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>
<script type="text/javascript">
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
<?php } ?>

<?php if (!empty($inner_data['sublist']) || !empty($inner_data['list'])) { ?>
<script src="http://static.ebanhui.com/wap/js/swiper.min.js"></script>
<style>
/*跨webview需要手动指定位置*/
img.rebarimg{width:110px;height:110px;border-radius:100%;}

.xairet {line-height:1.7;margin:0 15px;text-indent:25px;overflow:hidden; text-overflow:ellipsis;display:-webkit-box; -webkit-box-orient:vertical;-webkit-line-clamp:3; }
.rigtyle{height:40px;line-height:40px;padding-left:20px;}
.rigtyle.pro{font-size:14px;color:#8f8f94;}
.mui-plus header.mui-bar {
	display: none!important;
}
.mui-plus .mui-bar-nav~.mui-content {
	padding: 0!important;
}
    span.mui-icon {
        font-size: 14px;
        color: #007aff;
        margin-left: -15px;
        padding-right: 10px;
    }
    .mui-popover {
        height: 140px;
    }
    .mui-table-view.mui-grid-view .mui-table-view-cell {
        text-align:left;
    }
    .mui-off-canvas-wrap .mui-bar-nav {
        top: 0;
        -webkit-box-shadow: 0 1px 6px #ccc;
        box-shadow: 0 1px 6px #ccc;
    }
    .mui-control-content {
        background-color: white;
        min-height: 215px;
    }
    .mui-control-content .mui-loading {
        margin-top: 50px;
    }
    .mui-bar-nav~.mui-content .mui-slider.mui-fullscreen {
        top:45px;
    }
    .mui-table-view-cell.mui-collapse .mui-table-view .mui-table-view-cell {
        padding-left: 15px;
    }
    .mui-table-view-cell.mui-collapse .mui-table-view .mui-table-view-cell:after {
        left:0px;
    }
    .mui-table-view:after {height:auto;}
    .mui-table-view-cell.mui-collapse.mui-active .mui-table-view-cell>a:not(.mui-btn).mui-active{margin-left:-31px;padding-left:31px}
    .mui-table-view .mui-media-object {max-width:70px;}
    .mui-scroll {
        z-index:10;
        padding-bottom:40px;
    }
    .mui-bar-nav~.mui-content.mui-scroll-wrapper .mui-scrollbar-vertical {top:84px;}
    .mui-table-view:before {height:0px;}
    .mui-media-body.teacher{padding:35px 0 0 0;}
	.mui-content {background:#efeff4 !important;}
	#topNav .active {border-bottom: solid 2px #007aff;}
#topNav .swiper-slide {line-height:1;height:39px;margin:0;}
#topNav .swiper-slide span {font-size:16px;}
#topNav .swiper-wrapper .swiper-slide {line-height:38px;}
.swiper-container-free-mode>.swiper-wrapper {
	width: 5000px;
}
</style>
<div>
	<div id="topNav" class="swiper-container">
		<div class="swiper-wrapper">

		<?php if (!empty($inner_data['subnav'])) { ?>
            <?php foreach ($inner_data['subnav'] as $subnav) { ?>
                <div class="swiper-slide <?php if ($subnav['index'] == $inner_data['subid']) { echo '  active'; } ?>"><a style="color:#666" href="<?=htmlspecialchars($subnav['url'], ENT_COMPAT)?>"><span><?=$subnav['subnickname']?></span></a></div>
            <?php } ?>
		<?php } ?>
	
		</div>
	</div>
	<div class="mui-table-view" style="background:none;">
				<div class="mui-content" id="content-panel">

				</div>
				<p id="showNoData" style="text-align:center;display:none;">没有更多啦！</p>
	</div>
</div>
<script type="text/javascript">
		var page = 0;
		var allAdd = 0;
		var s = <?php $s=intval($this->input->get('s'));echo $s;?>;
		var itemid = <?=$itemid?>;
		$(window).scroll(function () {
			var scrollTop = $(this).scrollTop();
			var scrollHeight = $(document).height();
			var windowHeight = $(this).height();
			if (scrollTop + windowHeight == scrollHeight) {
			pullupRefresh();
		  //此处是滚动条到底部时候触发的事件，在这里写要加载的数据，或者是拉动滚动条的操作

		//var page = Number($("#redgiftNextPage").attr('currentpage')) + 1;
		//redgiftList(page);
		//$("#redgiftNextPage").attr('currentpage', page + 1);

			}
		});
	    /**
	     * 上拉加载具体业务实现
	     */
	    function pullupRefresh(swiper) {
			if (allAdd)
			{
				return false;
			}
	        $.ajax({
	            url: '/room/portfolio/navcm.html',
	            type: 'get',
	            data: { 'page': ++page,'itemid':itemid,'s':s},
	            dataType: 'json',
	            success: function(ret) {
	                if (ret) {
						var list = [];
						list = ret.sublist || ret.list;
						var len = list.length;
						var htmlfrage = '';
						var con = false;
							for(var i = 0; i < len; i++) {
								var time2 = new Date(list[i].dateline * 1000).Format("yyyy-MM-dd hh:mm:ss");
								if (list[i].thumb_mobile) {
									var thumb='<div class="mui-card-header mui-card-media" style="height:40vw;background:url('+list[i].thumb_mobile+') no-repeat top center;"></div>';
								} else {
									if (list[i].thumb)
									{
										var pattern = new RegExp('_243_144');
										var thhou = list[i].thumb.replace(pattern,'');
										var thumb='<div class="mui-card-header mui-card-media" style="height:40vw;background:url('+thhou+') no-repeat top center;"></div>';
									} else {
										var thumb='';
									}
								}
								
								if(list[i].isinternal == '1'){
									htmlfrage += '<div class="mui-card"><div style="position:absolute;z-index:2"><img style="height: 45px;" src="http://static.ebanhui.com/ebh/tpl/2016/images/nbinformation.png"></div><a target="_blank" href="/dyinformation/'+list[i].itemid+'.html?itemid='+itemid+'">'+thumb+'<div class="mui-card-content"><div class="mui-card-content-inner"><p style="color: #333;padding-left: 35px;">'+list[i].subject+'</p><p>'+time2+'<span style="margin-left:20px;">阅读 <span style="color:#ffaf28;">'+list[i].viewnum+'</span> 次</span></p></div></div></a></div>';
								}else{
									htmlfrage += '<div class="mui-card"><a target="_blank" href="/dyinformation/'+list[i].itemid+'.html?itemid='+itemid+'">'+thumb+'<div class="mui-card-content"><div class="mui-card-content-inner"><p style="color: #333;">'+list[i].subject+'</p><p>'+time2+'<span style="margin-left:20px;">阅读 <span style="color:#ffaf28;">'+list[i].viewnum+'</span> 次</span></p></div></div></a></div>';
								}
								
							}
						if (swiper)
						{
							$("#content-panel").html('');
						}
						$("#content-panel").append(htmlfrage);
						s = ret.subid || 0;
	                }
					if (!ret || list.length == 0)
					{
						allAdd = 1;
						$('#showNoData').show();
					}
	                //mui('#pullrefresh').pullRefresh().endPullupToRefresh(!ret || list.length == 0);
	            }
	        });
	    }
	    	//两个滚动加载显示开关
	   		 mui('.mui-scroll-wrapper').scroll({
				indicators:false
			});
			mui.init({
				swipeBack: true, //启用右滑关闭功能
			});

//手机版头部滑动导航
var mySwiper = new Swiper('#topNav', {
	freeMode: true,
	freeModeMomentumRatio: 0.5,
	slidesPerView: 'auto',
});
swiperWidth = mySwiper.container[0].clientWidth
maxTranslate = mySwiper.maxTranslate();
maxWidth = -maxTranslate + swiperWidth / 2
$(".swiper-container").on('touchstart', function(e) {
	e.preventDefault()
})
mySwiper.on('tap', function(swiper, e) {
	e.preventDefault()
	slide = swiper.slides[swiper.clickedIndex]
	slideLeft = slide.offsetLeft
	slideWidth = slide.clientWidth
	slideCenter = slideLeft + slideWidth / 2
	// 被点击slide的中心点
	mySwiper.setWrapperTransition(300)
	if (slideCenter < swiperWidth / 2) {
		mySwiper.setWrapperTranslate(0)
	} else if (slideCenter > maxWidth) {
		mySwiper.setWrapperTranslate(maxTranslate)
	} else {
		nowTlanslate = slideCenter - swiperWidth / 2
		mySwiper.setWrapperTranslate(-nowTlanslate)
	}
	$("#topNav  .active").removeClass('active')
	$("#topNav .swiper-slide").eq(swiper.clickedIndex).addClass('active');
	
	var href =$(slide).find('a').attr('href');
	s = href.split("=")[1];
	page = 0;
	allAdd = 0;
	$('#showNoData').hide();
	pullupRefresh(1);
	
})
//转换时间格式
Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
$(function(){
	pullupRefresh();
});
<?php } ?>
</script>
<?php $this->display('shop/plate/footers');?>