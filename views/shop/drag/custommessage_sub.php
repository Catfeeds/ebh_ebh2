
<style>
.seecmsub{ background: #fff;display: inline-block;left: 10px;padding: 10px 20px 20px;margin-top:10px;width: 720px;line-height:2;}
.seecmsub .title{ font-size:24px; color:#333; text-align:center;}
#actor p{
	display:none!important;
}
.navliesub {
	width: 710px;
	clear: #555;
	height: 220px;
	float: left;
	}
.navliesub .navlietit {
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
.navliesub img {
	float: left;
}
.navliesub .tiwes {
	width: 560px;
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
</style>

	
	<div style="width:750px; margin:0 auto;">
		<div class="seecmsub">
		
			<?php if(!empty($navigatorlist)){
				foreach($navigatorlist as $nav){
					if($nav['code'] == $navcode){
						if(!empty($nav['subnav'])){
							foreach($nav['subnav'] as $subnav){
						?>
						<a href=""> <?=$subnav['subnickname']?></a>
							<?php }
						}
						break;
					}
				}
			}?>
			<ul>
			<?php foreach($newslistsub as $news){
				$newsurl = geturl('dyinformation/'.$news['itemid']);
				?>
				<li class="navliesub">
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
