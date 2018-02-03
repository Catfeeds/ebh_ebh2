	<?php if (!empty($foot) &&!empty($settings['foot'])) {?>
		<!-- 公共尾部 -->	
		<style>
			.mui-content  {
				overflow: hidden;
				margin-bottom: <?=$settings['foot'];?>rem;
			}
		</style>	
		<div class="comFoot" style="z-index:100;position: fixed;bottom:0;left:0;width: 10rem;height: <?=$settings['foot'];?>rem;">
			<?=$foot?>
		</div>		
		<!-- 公共尾部 -->
		<!-- 公共尾部js -->
		<script src="http://static.ebanhui.com/design/wapdesign/js/module.js?v=1236"></script>
		<!-- 公共尾部js -->
	<?php }?>
</div>
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
<!-- 头部有的尾部没有的情况 -->
<?php if(empty($settings['foot']) && !empty($settings['top'])){?>
<!-- 公共尾部js -->
<script src="http://static.ebanhui.com/design/wapdesign/js/module.js?v=1236"></script>
<!-- 公共尾部js -->
<?php }?>

<!-- 头部有的尾部没有的情况 -->
<?php if(!empty($settings['foot']) && empty($settings['top'])){?>
<!-- 公共尾部js -->
 	<link rel="stylesheet" href="http://static.ebanhui.com/design/wapdesign/css/common.css?version=20160614001">
    <link rel="stylesheet" href="http://static.ebanhui.com/design/wapdesign/css/module.css?version=20160614001">
    <!-- 公共手机自适应 -->
    <script type="text/javascript" src="http://static.ebanhui.com/design/wapdesign/js/mobile.js"></script><!-- 公共尾部js -->
<?php }?>
<script type="text/javascript">
//解决添加侧滑后a标签链接点击没反应问题
mui('.mui-scroll-wrapper').on('tap','a' ,function(){location.href = this.getAttribute('href')})
mui.init();
	 //侧滑容器父节点
	var offCanvasWrapper = mui('#offCanvasWrapper');
	 //主界面容器
	var offCanvasInner = '';
	if (offCanvasWrapper.length > 0)
	{
		offCanvasInner = offCanvasWrapper[0].querySelector('.mui-inner-wrap');
	}
	 //菜单容器
	var offCanvasSide = document.getElementById("offCanvasSide");
	if (!mui.os.android) {
		var spans = document.querySelectorAll('.android-only');
		for (var i = 0, len = spans.length; i < len; i++) {
			spans[i].style.display = "none";
		}
	}
	 //移动效果是否为整体移动
	var moveTogether = false;
	 //侧滑容器的class列表，增加.mui-slide-in即可实现菜单移动、主界面不动的效果；
	var classList = '';
	if (offCanvasWrapper.length > 0)
	{
		classList = offCanvasWrapper[0].classList;
	}
	 //变换侧滑动画移动效果；
	mui('.mui-input-group').on('change', 'input', function() {
		if (this.checked && offCanvasWrapper.length > 0) {
			offCanvasSide.classList.remove('mui-transitioning');
			offCanvasSide.setAttribute('style', '');
			classList.remove('mui-slide-in');
			classList.remove('mui-scalable');
			switch (this.value) {
				case 'main-move':
					if (moveTogether) {
						//仅主内容滑动时，侧滑菜单在off-canvas-wrap内，和主界面并列
						offCanvasWrapper[0].insertBefore(offCanvasSide, offCanvasWrapper[0].firstElementChild);
					}
					break;
				case 'main-move-scalable':
					if (moveTogether) {
						//仅主内容滑动时，侧滑菜单在off-canvas-wrap内，和主界面并列
						offCanvasWrapper[0].insertBefore(offCanvasSide, offCanvasWrapper[0].firstElementChild);
					}
					classList.add('mui-scalable');
					break;
				case 'menu-move':
					classList.add('mui-slide-in');
					break;
				case 'all-move':
					moveTogether = true;
					//整体滑动时，侧滑菜单在inner-wrap内
					if (offCanvasInner != '')
					{
						offCanvasInner.insertBefore(offCanvasSide, offCanvasInner.firstElementChild);
					}
					break;
			}
			offCanvasWrapper.offCanvas().refresh();
		}
	});
	 //主界面和侧滑菜单界面均支持区域滚动；
	mui('#offCanvasSideScroll').scroll();
	mui('#offCanvasContentScroll').scroll();
	 //实现ios平台原生侧滑关闭页面；
	if (mui.os.plus && mui.os.ios) {
		mui.plusReady(function() { //5+ iOS暂时无法屏蔽popGesture时传递touch事件，故该demo直接屏蔽popGesture功能
			plus.webview.currentWebview().setStyle({
				'popGesture': 'none'
			});
		});
	}
	mui.init({
	swipeBack: true //启用右滑关闭功能
});
mui('.mui-scroll-wrapper').scroll();
mui('body').on('shown', '.mui-popover', function(e) {
	//console.log('shown', e.detail.id);//detail为当前popover元素
});
mui('body').on('hidden', '.mui-popover', function(e) {
	//console.log('hidden', e.detail.id);//detail为当前popover元素
});

</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/loginlog.js" crid="<?php if(!empty($rid)){echo $rid;}else{echo '10194';} ?>" id="loginlogjs"></script>
</html>
