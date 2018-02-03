<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title></title>
</head>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/zjdfysxy.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=2016050630"/>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/drag/style.css?v=201605206">

<style>
html {background:#f9f9f9;}
.see{ background: #fff;display: inline-block;left: 10px;margin-top:10px;width: 960px;line-height:2;}
.see .title{ font-size:24px; color:#333; text-align:center;}
.see .p1s{ font-size:14px; line-height:24px; padding-top:15px; text-indent:24px;}
#actor p{
	display:none!important;
}
.navlie {
	width: 920px;
	color: #555;
	height: 220px;
	float: left;
	padding: 10px 20px ;
	}
	.navlie .navlietit {
	height: 42px;
	line-height: 42px;
	border-bottom: dashed 1px #e7e7e7;
	font-size: 20px;
	font-family: "Microsoft YaHei";
	font-weight: bold;
}
.martopbtm {
	margin: 10px 0;
}
.navlie img {
	float: left;
}
.navlie .tiwes {
	width: 775px;
	margin-left: 15px;
	float: left;
	font-size: 14px;
	display: inline;
	line-height: 1.8;
}
.yuedubtn {
	float: right;
	font-size: 14px;
	display: block;
	width: 60px;
	margin-right: 10px;
	height: 24px;
	line-height: 24px;
	background: url(http://static.ebanhui.com/portal/images/quanico.jpg) no-repeat left center;
	padding-left: 20px;
}
.ppp{
	padding-left:20px;
}
</style>

<body>
<?php $this->display('shop/drag/topbar');?>
	
    <div class="banner" style="background:none;height:auto">
	<?php
		$this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 960, '_height' => 'auto', 'default' => 'http://static.ebanhui.com/ebh/tpl/default/images/toptuad0411.jpg'));
		?>
	</div>
	
	<div class="clear"></div>
	
		<?php $navlib = Ebh::app()->lib('Navigator');
		$navigatorlist = $navlib->getnavigator();
		?>
	<div style="width:960px; margin:0 auto;">
		<div class="see">
		
			<div class="ppp"><p class="p1s"><?=stripslashes(!empty($custommessage[0])?$custommessage[0]['custommessage']:'')?></p></div>
			<!--
			<div class="kehtty">
				<div class="lefrrts">
					<ul>
						<li class="lietreed">
							<a class="kuerbe jisrts" href="#">联系我们</a>
						</li>
						<li class="lietreed">
							<a class="kuerbe" href="#">新闻中心</a>
						</li>
						<li class="lietreed">
							<a class="kuerbe" href="#">合作伙伴</a>
						</li>
						<li class="lietreed">
							<a class="kuerbe" href="#">友情链接</a>
						</li>
						<li class="lietreed">
							<a class="kuerbe" href="#">意见反馈</a>
						</li>
						<li class="lietreed">
							<a class="kuerbe" href="#">常见问题</a>
						</li>
					</ul>
				</div>
				<div class="rishtgd">
					
				</div>
			</div>-->
			<?php if(!empty($navigatorlist)){
				foreach($navigatorlist as $nav){
					if($nav['code'] == $navcode){
						$ncode = strlen($itemid)==1?('0'.$itemid):$itemid;
						if(!empty($nav['subnav'])){
							$frameurl = '';?>
						<div class="kehtty">
							<div class="lefrrts">
								<ul>
							<?php $ks = 0;
							foreach($nav['subnav'] as $subnav){
								if($subnav['subavailable']){
									$scode = preg_replace('/n\d+s/','',$subnav['subcode']);
									// $scode = strlen($scode)==1?('0'.$scode):$scode;
									// if(empty($frameurl))
										// $frameurl = '/navcm/s/'.$ncode.$scode.'.html';
									?>
								<li class="lietreed">
								<a class="kuerbe <?=$s==$scode?'jisrts':''?>" href="/navcm/<?=$itemid?>.html?s=<?=$scode?>"> <?=$subnav['subnickname']?></a>
								</li>
								<?php $ks++;}
								}?>
								</ul>
							</div>
							<div class="rishtgd">
								<?php 
									if(!empty($itemview))
										$this->display('shop/drag/dyinformation_view_sub');
									elseif(!empty($newslistsub))
										$this->display('shop/drag/custommessage_sub');
								?>
								
							</div>
						</div>		
						<?php
						}
						break;
					}
				}
			}?>
			<ul>
			<?php foreach($newslist as $news){
				$newsurl = geturl('dyinformation/'.$news['itemid']);
				?>
				<li class="navlie">
				<h2 class="navlietit"><a title="<?= $news['subject']?>" href="<?= $newsurl?>" target="_blank"><?= shortstr($news['subject'],50)?></a></h2>
				<p class="martopbtm">发表于：<?= date('Y-m-d H:i:s',$news['dateline'])?>  阅读(<?= $news['viewnum']?>)次  </p>
				<a href="<?= $newsurl ?>" target="_blank"><img width="130px" height="98px" src="<?=empty($news['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$news['thumb']?>" /></a>
				<p class="tiwes"><?= shortstr($news['note'],350)?></p>
				<a href="<?= $newsurl ?>" class="yuedubtn" target="_blank">阅读全文</a>
				</li>
			<?php }?>
			</ul>
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
$('.kuerbe').click(function(){
	$('.kuerbe').removeClass('jisrts');
	$(this).addClass('jisrts');
});

</script>
<!--增加客服系统sta-->
<div class="clear"></div>
<div class="kfxt">
    <?php $this->display('shop/drag/kf')?>
</div>
<!--增加客服系统end-->

<?php $this->display('common/footer')?>
