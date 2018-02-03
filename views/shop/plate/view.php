<?php if (!empty($varpool['design'])) { ?>
    <style type="text/css">
        .denser{margin:0 !important;}
    </style>
<?php } ?>
<div style="width:1200px; margin:1px auto;">
		<div class="see" style="min-height:800px;_height:800px;">

			<div class="titled"><?=$varpool['subject']?></div>
<div style="text-align:center;width:100%;float:left;margin:10px 0;">
    <div class="timeb" style="float: none;margin: 0;display: inline;">
        <span>时间：<?=Date('Y-m-d H:i',$varpool['dateline'])?></span>
        <span>阅读：<?=$varpool['viewnum']+1?></span>
    </div>
    <!-- Baidu Button BEGIN -->
    <!-- <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a></div>
    <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script> -->
    <!-- Baidu Button END -->
</div>

<div>
<?php if(empty($varpool['isinternal']) || !empty($varpool['isroomuser'])){//非内部用户不可见?>
<p class="p1s"><?=stripslashes($varpool['message'])?></p>
<?php } else {?>
    <div style="text-align: center;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/qsinformation.png"></div>
<?php }?>
</div>
	<div>

		<?php if(!empty($varpool['attachlist']) && (empty($varpool['isinternal']) || !empty($varpool['isroomuser']))){//非内部用户不可见
			foreach($varpool['attachlist'] as $attach){?>
			<div style="display:block;"><a style="color:#338bff" href="<?=$attach['source']?>attach.html?attid=<?=$attach['attid']?>&itemid=<?=$varpool['itemid']?>&type=dyinformation"><?=$attach['filename']?></a></div>

		<?php }
		}?>
	</div>
</div>
</div>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>