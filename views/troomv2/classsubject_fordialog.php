<?php $this->display('troomv2/page_header'); ?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
<style type="text/css">
body{
	background-color: #fff;
	overflow-x: hidden;
}
.kejian {
	width: 786px;
	background:#fff;
	float:left;
	/*border: 1px solid #dcdcdc;*/
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
	height: 218px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 140px;
	height: 36px;
	overflow: hidden;
	word-wrap: break-word;
	display: block;
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

.showimg { float:left;}
.showimg img {border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg img { border:1px solid ;}
.showimg .hover{border: 1px solid;}


.noke {
	height: 480px;
	width: 744px;
	float: left;
	border: 1px solid #cdcdcd;
}
.noke p {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/nokejianico.jpg) no-repeat;
	height: 120px;
	margin-top: 90px;
	margin-left: 170px;
	padding-left: 140px;
	font-size: 16px;
	padding-top: 30px;
    width: 307px;
}
.noke span {
	color: #e94f29;
}


</style>

<div class="lefrig" style="padding-bottom:0;">

<div class="kejian">
	<?php if(!empty($subjectlist)) { ?>
	<div class="other_room_tit" style="border:0"><h2 style="width:580px;float:left;_margin-top:5px;font-weight:bolder;color:#333;">请选择课程进入</h2></div>
	<ul class="liss">
	<?php foreach($subjectlist as $subject) { ?>
	<li class="danke">
	<div class="showimg"><a href="javascript:void(0)" onclick="showLinkListDialog(<?=$subject['folderid']?>)"><img src="<?= empty($subject['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subject['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="javascript:void(0)" onclick="showLinkListDialog(<?=$subject['folderid']?>)"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)</a></span>
	</a>
	</li>
	<?php } ?>
	</ul>
	<?php } else { ?>
	<div style="padding-left:15px; padding-top:4px; font-size:14px;">
		没有找到相关记录
	</div>
	<?php } ?>
</div>
<?=$pagestr?>
</div>
</div>
<script>
	function showLinkListDialog(folderid){
		parent.window.showLinkListDialog(folderid);
	}
</script>
<?php $this->display('troomv2/page_footer'); ?>