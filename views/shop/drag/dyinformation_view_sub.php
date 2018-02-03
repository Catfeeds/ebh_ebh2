
<style>
.seedysub{ background: #fff;display: inline-block;left: 10px;padding: 10px 20px 20px;margin-top:10px;width: 710px;}
.seedysub .titled{ font-size:26px; color:#333; text-align:center;font-family:"微软雅黑", sans-serif}
.seedysub .p1s{ font-size:14px; line-height:24px; padding-top:15px; text-indent:24px;margin-top:30px}
#actor p{
	display:none!important;
}
.timeb{float:left;margin-left:300px;line-height:30px;margin-right:10px;display:inline-block;color:#999}
.timeb span{margin-left:10px}
</style>


	<div style="width:750px; margin:0 auto;">
		<div class="seedysub">
			
			<div class="titled"><?=$itemview['subject']?></div>
			<div style="text-align:center;width:100%;float:left">
				<div class="timeb">
					<span>时间：<?=Date('Y-m-d H:i',$itemview['dateline'])?></span>
					<span>人气：<?=$itemview['viewnum']+1?></span>
				</div>
				<!-- Baidu Button BEGIN -->
				<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
			<!-- Baidu Button END -->
			</div>
			
			<div><p class="p1s"><?=stripslashes($itemview['message'])?></p></div>
		</div>
	</div>
<script>
(function(){
	$('.seedysub img').css('max-width','700px');
	$('.seedysub img').attr('width','');
	$('.seedysub img').attr('height','');
})();
</script>
	
