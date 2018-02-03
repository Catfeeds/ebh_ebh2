<?php $this->display('troomv2/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
<style type="text/css">
.kejian {
	width: 788px;
	background:#fff;
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
	margin-left:11px;
	display:inline;
	margin-top: 8px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 128px;
	height: 20px;
	display: block;
	margin-bottom: 8px;
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
.showimg img { background-color:#FFFFFF; border:1px solid #efefef; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}

</style>
<script type="text/javaScript">
<!--
var searchText = "请输入您要搜索的课件名称";

	$(function(){
		initsearch("searchvalue",searchText);
		$(".showimg").parent().hover(function(){
			$(this).siblings().find("img").stop().animate({opacity:'0.3'},1000);
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
			var url = "<?= geturl('troomv2/fullcourse/lists-1-0-0-'.$moduleid)?>?q="+encodeURIComponent(search);
			location.href=url;
		});
	});
//-->
</script>


<div class="ter_tit">
	当前位置 > 全科复习
<div class="diles">
	<input name="search" class="newsou" id="searchvalue" value="" type="text" />
	<input type="button" class="soulico" id="searchbutton" name="searchbutton" value="">
</div>
</div>
<div class="lefrig" style="margin-top:15px;">

	<div class="kejian">
	<?php if(!empty($folders)) { ?>
	<div class="other_room_tit"><h2 style="width:580px;float:left;_margin-top:5px;">所有课程</h2></div>
	<ul class="liss">
	<?php foreach($folders as $folder) { ?>
	<li class="danke">
	<div class="showimg"><a href="<?= geturl('troomv2/fullcourse/lists-1-0-0-'.$moduleid.'-'.$folder['folderid'])?>"><img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('troomv2/fullcourse/lists-1-0-0-'.$folder['folderid'].'-'.$moduleid)?>"><?= $folder['foldername']?>(<?= $folder['coursewarenum']?>)</a></span>
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
<?=$pagestr?>
<div style="clear:both;"></div>
</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>