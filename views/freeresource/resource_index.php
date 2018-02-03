<?php $this->display('common/header')?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/ztree/css/zTreeStyle.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ztree/jquery.ztree.core-3.5.js"></script>
<SCRIPT type="text/javascript">
	<!--
	var setting = {
		data: {
			simpleData: {
				enable: true,
				rootPId: 0
			}
		},
		
		async: {
			enable: true,
			url:"/freeresource/resource/getnodes.html",
			autoParam:["id", "level=lv"],
			otherParam:{"versionId":<?=$versionInfo['version_id']?>}
		}
	};

	var zNodes =<?=$zNodes?>;

	$(document).ready(function(){
		$.fn.zTree.init($("#resource_tree"), setting, zNodes);
	});
	//-->
</SCRIPT>

<div class="footer">
<div class="lstgjy" style="margin:10px 0 0 0">
<div class="ter_res_tit"> 当前位置 > <?=$navStr?> </div>
<div class="kegsds">
<div class="dfkgfvs">
<h2 class="rgedds"><?=$versionInfo['version_name']?></h2>
<div class="gerkgjd">            
    <ul id="resource_tree" class="ztree">
    </ul>
</div>
</div>
<div class="righsdk">
	<iframe onload="resetmain()" id="mainFrame" name="mainFrame" scrolling="no" width=100% height=600px frameborder=0 src="/freeresource/resource/showlist-1-0-0-<?=$versionInfo['version_id']?>-0-0.html"></iframe>

</div>
</div>

</div>
</div>

<script type="text/javascript">
var resetmain = function(){
	var mainFrame = document.getElementById("mainFrame");
	if(mainFrame.contentWindow.window.document.documentElement && mainFrame.contentWindow.window.document.body){
		var iframeHeight = Math.min(mainFrame.contentWindow.window.document.documentElement.scrollHeight, mainFrame.contentWindow.window.document.body.scrollHeight)+50;
	}else{
		var iframeHeight = 665;
	}
	iframeHeight = iframeHeight<665?665:iframeHeight;
	$(mainFrame).height(iframeHeight);
}
</script>

<?php $this->display('common/footer');?>