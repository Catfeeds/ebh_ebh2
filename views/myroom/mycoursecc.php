<?php $this->display('myroom/page_header'); ?>
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/drag.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
<style type="text/css">
.kejian {
	width: 786px;
	background:#fff;
	border: 1px solid #dcdcdc;
	float: left;
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian .liss {
	width: 786px;
	float:left;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	position: relative;
	margin-top: 8px;
	margin-left:11px;
	display:inline;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 128px;
	display: block;
	margin-left: 4px;
	color: #0033ff;
	float:left;
	overflow: hidden;
	height:38px;
	word-wrap: break-word;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg) no-repeat center center;
	margin-bottom: 8px;
}

.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}
.piaoyin {
	position: absolute;
	top:6px;
	left:9px;
	width:114px;
	height:159px;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/diceng.png) no-repeat;
}
.piaoyin .tuslick {
	width:114px;
	height:135px;
	display:block;
}
.piaoyin .btnxlick {
	width:114px;
	height:24px;
	display:block;
}
</style>
<div class="ter_tit">
	当前位置 > 高考冲刺
</div>
<div class="lefrig">
	<div class="kejian" style="margin-top:10px;">
		<div class="other_room_tit"><h2>我的课程</h2></div>
		<?php if(!empty($folders)) { ?>
			<?php if($roominfo['isschool'] != 7 ) { ?>
			<ul class="liss">
			<?php foreach($folders as $folder) { 
			$folderurl =geturl('myroom/stusubjectcc/'.$folder['folderid']);
			?>
				<li class="danke">
				<div class="showimg"><a href="<?= $folderurl ?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
				<span class="spne"><a href="<?= $folderurl ?>"><?= $folder['foldername']?>(<?= $folder['coursewarenum']?>)</a></span>
				</a>
				</li>
			<?php } ?>
			</ul>
			<?php } else { ?>
			<ul class="liss">
			<?php 
			$folderi = 0;
			foreach($folders as $folder) { 
			$folderurl = geturl('myroom/stusubjectcc/'.$folder['folderid']);
			if($folder['haspower'] == 1 && empty($folder['payurl'])) {
				$folderi ++;
				?>

					<li class="danke">
					<div class="showimg"><a href="<?= $folderurl ?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
					<span class="spne"><a href="<?= $folderurl ?>"><?= $folder['foldername']?>(<?= $folder['coursewarenum']?>)</a></span>
					</a>
					</li>
				<?php } ?>
			<?php } ?>
			</ul>
			<?php 
				if($folderi < count($folders)) { 
				?>
<ul class="liss" <?= $folderi > 0 ?'style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/folderline.png) no-repeat top left;padding-top:10px;"' : '' ?>>
				<?php 
					foreach($folders as $folder) { 
						if($folder['haspower'] == 1 && empty($folder['payurl']))
							continue;
						$folderurl = geturl('myroom/stusubjectcc/'.$folder['folderid']);
				?>
					<li class="danke">
					<div class="showimg"><a href="<?= $folder['payurl'] ?>" target="_blank" title="点击立即开通"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
						<div class="piaoyin">
							<a href="<?= $folder['payurl'] ?>" target="_blank" title="点击立即开通" class="tuslick"></a>
							<a class="btnxlick" href="<?= $folder['payurl'] ?>" target="_blank" title="点击立即开通"></a>
						</div>
					<span class="spne"><a href="<?= $folderurl ?>"><?= $folder['foldername']?>(<?= $folder['coursewarenum']?>)</a></span>
					</a>
					</li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<?= $pagestr ?>
		<?php } else { ?>
			<div style="padding-left:15px; padding-top:4px; font-size:14px;">没有找到相关记录</div>
		<?php } ?>
		
		<div style="clear:both;"></div>
	</div>
</div>
<?php $this->display('myroom/page_footer'); ?>