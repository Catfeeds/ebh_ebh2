<?php $this->display('myroom/page_header'); ?>
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/drag.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
<style type="text/css">
.kejian {
	width: 786px;
	border: 1px solid #dcdcdc;
	float: left;
	background:#fff;
	margin-top:15px;
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
	width: 146px;
	float: left;
	position: relative;
	margin-top: 8px;
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

.showimg {float:left;}
.showimg img {border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:;}
.hover .showimg img { border:1px solid;}
.showimg .hover{border: 1px solid ;}
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
		当前位置 > <a href="<?= geturl('myroom/stusubject') ?>">学习课程</a> > <?php if($from == 1) { ?>我的课程<?php } else { ?>全校课程<?php } ?>

</div>
</div>
<div class="lefrig">
	<div class="kejian" style="margin-top:10px;<?=$roominfo['isschool'] != 7?'':'background:none;border:none'?>">
		<?php if($roominfo['isschool'] != 7 ) { ?>
		<div class="other_room_tit"><h2><?php if($from == 1) { ?>我的课程<?php } else { ?>全校课程<?php } ?></h2>

		<a class="" href="/myroom/favorite.html?from=<?= $from?>" style="background:url(http://static.ebanhui.com/ebh/tpl/2014/images/meidian150124.jpg) no-repeat scroll left center;
    display: block;height: 27px;line-height: 27px;margin: 0 10px;padding-left: 25px;width: 40px;	
	float: right;margin-right: 25px;margin-top: -30px;"/>收藏夹</a>

		</div>
		<?php }?>
		<?php if(!empty($folders)) { ?>
			<?php if($roominfo['isschool'] != 7 ) { ?>
			<ul class="liss">
			<?php foreach($folders as $folder) { 
			$folderurl = empty($from) ? geturl('myroom/stusubject/'.$folder['folderid']):geturl('myroom/stusubject/'.$folder['folderid'].'-0-0-0-'.$from);
			?>
				<li class="danke" style="margin-left:11px;">
				<div class="showimg"><a href="<?= $folderurl ?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
				<span class="spne"><a href="<?= $folderurl ?>"><?= $folder['foldername']?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></a></span>
				</a>
				</li>
			<?php } ?>
			</ul>
			<?=$pagestr?>
			<?php } else { 
				$i=0;
				foreach($folders as $k=>$package){
			?>
			<div class="kejian" style="margin-top:10px;">
			<div class="other_room_tit"><h2><?=$package['pname']?></h2>
			<?php if($i==0){ ?>
			<a class="" href="/myroom/favorite.html?from=<?= $from?>" style="background:url(http://static.ebanhui.com/ebh/tpl/2014/images/meidian150124.jpg) no-repeat scroll left center;
    display: block;height: 27px;line-height: 27px;margin: 0 10px;padding-left: 25px;width: 40px;	
	float: right;margin-right: 25px;margin-top: -30px;"/>收藏夹</a><?php } ?>
			</div>
			<ul class="liss">
			<?php 
			$folderi = 0;
			$hasArr = array();
			foreach($package['itemlist'] as $folder) { 
			if(!in_array($folder['folderid'],$hasArr)){
			$folderurl = empty($from) ? geturl('myroom/stusubject/'.$folder['folderid']):geturl('myroom/stusubject/'.$folder['folderid'].'-0-0-0-'.$from);
				$folderi ++;
				?>

					<li class="danke" style="margin-left:11px; _margin-left:2px;height:220px;">
					<div class="showimg"><a href="<?= $folderurl ?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
					<span class="spne"><a href="<?= $folderurl ?>"><?= $folder['foldername']?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></a></span>
					</a>
					</li>
			<?php $hasArr[]= $folder['folderid'];}} ?>
			</ul>
			</div>
			<?php $i++;}?>
			</div>
			<?php } ?>
			
		<?php } elseif(empty($splist)) { ?>
			<div style="padding-left:15px; padding-top:4px; font-size:14px;">没有找到相关记录</div>
		<?php } ?>

		<?php  
			if($roominfo['isschool'] == 7 && !empty($splist)){?>
		<div class="kejian unopen" style="margin-top:10px;">
		<a name="classactive" style="display：none"></a>
<ul class="liss" <?= ( !empty($folderi) && $folderi > 0) ?'style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/folderline.png) no-repeat top left;padding-top:10px;"' : '' ?>>
				<div class="work_mes" style="width:786px;margin-bottom:10px">
					<ul>
				<?php 
					$idx = 0;
					$curp = 0;
					foreach($splist as $h=>$package){
						if(count($package['itemlist'])>0){
				?>
					<li class="<?=($idx==0)?'workcurrent':''?> packagetab" onclick="showpackage(<?=$h?>)"><a href="javascript:void(0)"><span><?=$package['pname']?></span></a></li>
						
			
				<?php $idx++;
						if($curp == 0)
						$curp=$h;
				}
				}?>
					</ul>
				</div>
				<?php 
					foreach($splist as $j=>$package){ ?>
					<div class="package package<?=$j?>" style="<?=($curp!=$j)?'display:none;':''?>">
					<?php 
					foreach($package['itemlist'] as $k=>$folder) {
						
						$folderurl = empty($from) ? geturl('myroom/stusubject/'.$folder['folderid']):geturl('myroom/stusubject/'.$folder['folderid'].'-0-0-0-'.$from);
				?>
					<li class="danke" style="margin-left:11px; _margin-left:2px;height:220px;">
					<div class="showimg"><a href="<?= $folder['payurl'] ?>" target="_blank" title="点击立即开通"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
						<div class="piaoyin">
							<a href="<?= $folder['payurl'] ?>" target="_blank" title="点击立即开通" class="tuslick"></a>
							<a class="btnxlick" href="<?= $folder['payurl'] ?>" target="_blank" title="点击立即开通"></a>
						</div>
					<span class="spne"><a href="<?= $folderurl ?>"><?= $folder['foldername']?><?=!empty($folder['coursewarenum'])?'('.$folder['coursewarenum'].')':''?></a></span>
					</a>
					</li>
					<?php } ?>
					</div>
					<?php }?>
				
				</ul>
				</div>
	<?php }?>
		
		<div style="clear:both;"></div>
	</div>
</div>
<script>
<!--
<?php 
if($roominfo['isschool'] == 7 ){?>
$(function(){
	parent.refresh('stusubject');
	// if($('.work_mes ul li').length<2)
		// $('.work_mes').hide();
	if(<?=$curp?> == 0){
		$('.unopen').hide();
	}
});
$('.packagetab').click(function(){
	$('.workcurrent').removeClass('workcurrent');
	$(this).addClass('workcurrent');
	parent.resetmain();
});
function showpackage(pid){
	$('.package').hide();
	$('.package'+pid).show();
}
<?php }?>
//-->
</script>
<?php $this->display('myroom/page_footer'); ?>