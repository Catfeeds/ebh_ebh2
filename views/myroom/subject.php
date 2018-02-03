<?php $this->display('myroom/page_header'); ?>

<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/drag.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
<style type="text/css">
.kejian {
	width: 748px;
	border: 1px solid #dcdcdc;
	float: left;
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-top: 8px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 128px;
	height: 40px;
	overflow: hidden;
	display: block;
	margin-left: 4px;
	line-height: 20px;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}

.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}

</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
var tips = '请输入您要搜索的课件名称';
	$(function(){
		initsearch('searchvalue',tips);
		$(".showimg").parent().hover(function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			$(this).addClass("hover");
		},function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			$(this).removeClass("hover");
		});

		$("#searchbutton").click(function(){
			var search = $('#searchvalue').val();
			if($('#searchvalue').val()=='请输入您要搜索的课件名称'){
				search='';
			}
			var url = "<?= geturl('myroom/course') ?>?q="+encodeURIComponent(search);
			location.href=url;
		});
	});
//-->
</SCRIPT>


<div class="ter_tit">
	当前位置 > 所有课程
</div>
<div class="lefrig">

<div class="annuato">
		<span style="float:left;height:22px;line-height:22px;">关键字：</span>
		<input type="text" name="search" id="searchvalue" value="<?= $q ?>" style="width:350px;height:20px; float:left;line-height:22px; font-size:14px;padding-left: 5px;color:#CDCDCD;border:solid 1px #cdcdcd;">
		<input class="souhuang " id="searchbutton" type="button" name="searchbutton" value="搜索" />
		</div>

<?php if(!empty($folderschoose)) { ?>
	<div class="kejian">
	<div class="other_room_tit"><h2 style="width:630px;float:left;"><?php if(!empty($q)) { ?>搜索结果(已选择的课程)<?php } else { ?>我已选择的课程<?php }?></h2><a class="lanbtn100" href="<?= geturl('myroom/subject/choose') ?>" style="margin-top:2px! important;">我要选课</a></div>
	<ul class="liss">
	<?php foreach($folderschoose as $folder) { ?>
	<li class="danke" style="margin-left:4px; _margin-left:2px;">
	<div class="showimg"><a href="<?= geturl('myroom/subject/'.$folder['folderid']) ?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('myroom/subject/'.$folder['folderid']) ?>"><?= $folder['foldername'].'('.$folder['coursewarenum'].')' ?></a></span>
	</a>
	</li>
	<?php } ?>
	</ul>
	<div style="clear:both;"></div>
	</div>
<?= $pagestr ?>

	<?php if(!empty($foldersnochoose)) { ?>
	<div class="kejian">
	<div class="other_room_tit"><h2 style="width:630px;float:left;"><?php if(!empty($q)) { ?>搜索结果(未选择的课程)<?php } else { ?>我未选择的课程<?php } ?></h2><a class="lanbtn100" href="<?= geturl('myroom/subject/choose') ?>" style="margin-top:2px! important;">我要选课</a></div>

	<ul class="liss">
	<?php foreach($foldersnochoose as $folder) { ?>
	<li class="danke" style="float:left;width:133px;margin-left:15px;margin-top:15px;margin-bottom:15px;background: url(http://static.ebanhui.com/ebh/tpl/default/images/point.jpg) no-repeat left center;padding-left: 10px;">
	<a href="<?= geturl('myroom/subject/'.$folder['folderid']) ?>"><?= $folder['foldername'].'('.$folder['coursewarenum'].')' ?></a></span>
	</a>
	</li>
	<?php } ?>
	</ul>
	<div style="clear:both;"></div>
	</div>
	<?php } ?>
<?php } else { ?>

	<div class="kejian">
	<?php if(!empty($foldersnochoose)) { ?>
	<div class="other_room_tit"><h2 style="width:630px;float:left;"><?php if(!empty($q)) { ?>搜索结果<?php } else { ?>所有课程<?php } ?></h2><a class="lanbtn100" href="<?= geturl('myroom/subject/choose') ?>" style="margin-top:2px! important;">我要选课</a></div>
	<ul class="liss">
	<?php foreach($foldersnochoose as $folder) { ?>
	<li class="danke" style="margin-left:4px; _margin-left:2px;">
	<div class="showimg"><a href="<?= geturl('myroom/subject/'.$folder['folderid']) ?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('myroom/subject/'.$folder['folderid'])?>"><?= $folder['foldername'].'('.$folder['coursewarenum'].')' ?></a></span>
	</a>
	</li>
	<?php } ?>
	</ul>
	<?php } else { ?>
	<div style="padding-left:15px; padding-top:4px; font-size:14px;">
		没有找到相关记录
	</div>
	<?php } ?>
	<div style="clear:both;"></div>
</div>
<?php } ?>
<div style="clear:both;"></div>
<?php $this->display('myroom/page_footer'); ?>