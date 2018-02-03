<?php $this->display('aroomv2/page_header')?>
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/drag.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<style type="text/css">
.kejian {
	width: 786px;
	border: 1px solid #dcdcdc;
	float: left;
	background:#fff;
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
	margin-left:11px;
	display:inline;
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
	overflow: hidden;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(/static/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}

.showimg {float:left;}
.showimg img { border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg img { border:1px solid ;}
.showimg .hover{border: 1px solid ;}

</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(function(){
		$(".showimg").parent().hover(function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			//$(".showimg").parent().not(this).find("img").stop().animate({opacity:'1'},1000);
			$(this).addClass("hover");
		},function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			//$(".showimg").parent().not(this).find("img").stop().animate({opacity:'1'},1000);
			$(this).removeClass("hover");
		});

	});
//-->
</SCRIPT>
<div class="ter_tit">
		当前位置 > 学校所有课程
		
		</div>
	<div class="lefrig">
	<div class="kejian" style="margin-top:10px;">
	<div class="other_room_tit"><h2>学校共有课程 <span style="color:#0709FE"><?=$coursecount?></span> 个</h2></div>
	<?php if(!empty($courselist)){
	?>
	<ul class="liss">
	<?php foreach($courselist as $cl){
		$furl = geturl('aroomv2/allcourses/'.$cl['folderid'].'-0-0-0');
	?>
	<li class="danke">
	<div class="showimg"><a href="<?=$furl?>"><img src="<?=empty($cl['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$cl['img']?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?=$furl?>"><?=$cl['foldername']?>(<?=$cl['coursewarenum']?>)</a></span>
	</a>
	</li>
	<?php }?>
	</ul>
	<?php }else{?>
	<div style="padding-left:15px; padding-top:4px; font-size:14px;">没有找到相关记录</div>
	<?php }?>
	<div style="clear:both;"></div>
	</div>
	<?=$pagestr?>
<div style="clear:both;"></div>
</div>
</div>