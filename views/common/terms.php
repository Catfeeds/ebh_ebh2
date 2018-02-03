<?php
$this->display('common/siteinfo_header');
?>
<style>
 .dizhi {
	margin-top:10px;
	width:350px;
	display:inline;
}
.dizhi .h2top {
	font-size:14px;
	font-weight:bold;
}
.dizhi li {
	line-height:24px;
}
</style>
	  <div class="pageright">
	    <div class="pagetit"><img src="http://static.ebanhui.com/ebh/tpl/default/images/terms.png"  /></div>
		<div class="pagecont">
			<div class="pagebt">全球领先的网络在线资源有偿分享增值服务平台</div>
			<div class="pw">
			<?= $itemsite[0]['message']?>
		  </div>
		</div>
	  </div>
	</div>
	<div class="pagebot"></div>
</div>
<?php
$this->display('common/siteinfo_footer');
?>