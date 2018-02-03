<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$itemview['subject']?></title>
</head>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=2015121401"/>

<style>
html {background:#f9f9f9;}
.see{ background: #fff;border: 1px solid #e2e2e2;display: inline-block;left: 10px;padding: 10px 20px 20px;margin-top:10px;width: 919px;}
.see .titled{ font-size:26px; color:#333; text-align:center;font-family:"微软雅黑", sans-serif}
.see .p1s{ font-size:14px; line-height:24px; padding-top:15px; text-indent:24px;margin-top:30px}
#actor p{
	display:none!important;
}
.timeb{float:left;margin-left:300px;line-height:30px;margin-right:10px;display:inline-block;color:#999}
.timeb span{margin-left:10px}
</style>

<body>
<?php $this->display('shop/drag/topbar');?>

    <div class="banner" style="background:none;height:auto">
	<?php
		$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 960, '_height' => 'auto', 'default' => 'http://static.ebanhui.com/ebh/tpl/default/images/toptuad0411.jpg'));
		?>
	</div>
		<?php $navlib = Ebh::app()->lib('Navigator');
		$navlib->getnavigator();
		?>
	<div style="clear:both;"></div>
	<div style="width:960px; margin:0 auto;">
		<div class="see">

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
var tologin = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
	var toregister = function(url){
		url = url.replace('__url__',encodeURIComponent(location.href));
		location.href=url;
	}
</script>

<?php $this->display('common/footer')?>
