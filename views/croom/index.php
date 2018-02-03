<?php $mainurl = geturl('croom/creport');
	$this->display('croom/room_header');?>
<script type="text/javascript">
<!--
var resetmain = function(){
	var mainFrame = document.getElementById("mainFrame");
	var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+50;
	iframeHeight = iframeHeight<665?665:iframeHeight;
	$(mainFrame).height(iframeHeight);
}

$(function(){
	var myroomitem_li =$(".menulist li");
	myroomitem_li.hover(function(){
		$(this).addClass("itemcurr");
	},function(){
		$(this).removeClass("itemcurr");
	})
});


//-->
</script>
<div class="wrap">
<div class="cmain clearfix">
<?php $this->display('croom/room_left')?>
	<div class="cright">
			<iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width=100% height=100% frameborder=0 src="<?=$mainurl?>"></iframe>
	</div>
	</div>
<div id="dialogdiv" style="display:none">
<iframe width="100%" height="100%" frameborder="0" src="about:blank" id="dislog" name="dialog"></iframe>
</div>
<div class="clear"></div>
</div>
<?php $this->display('common/footer_two')?>