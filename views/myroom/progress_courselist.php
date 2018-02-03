<?php
$this->display('myroom/page_header');
?>
<style type="text/css">
.kejian {
	width: 786px;
	float: left;
	border:solid 1px #cdcdcd;
	margin-top:15px;
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
	width: 131px;
	float: left;
	margin-left:24px;
	_margin-left:12px;
	margin-top: 8px;
	display:inline;
	position:relative;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 128px;
	height: 28px;
	display: block;
	margin:5px 0 8px 4px;
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

.piaoyin {
    background: url(http://static.ebanhui.com/ebh/tpl/default/images/kezhet2.png) no-repeat;
    height: 159px;
    left: 1px;
    position: absolute;
    top: 24px;
    width: 114px;
}
.ertie {
	background:#4f8df0;
	height:23px;
	line-height:23px;
	float:left;
	text-indent:5px;
	margin-top:135px;
}
.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}
a.progressTaga:hover{color:black;text-decoration:none;}
</style>


<body>
<div class="ter_tit"> 当前位置 > <a href="<?=geturl('myroom/analysis')?>">学习分析表</a> > 课程学习进度 </div>
<div class="lefrig">

<div class="kejian">
<?php if(!empty($folders)){?>
<ul class="liss">

<?php 
foreach($folders as $folder){?>
<li class="danke">
<div style="border: 1px solid #e2e2e2;height: 182px;width: 114px;">
<a href="<?=geturl('myroom/progress/'.$folder['folderid'])?>">
<img width="114" height="159" border="0" src="<?=empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img']?>" style="opacity: 1;">
</a>
</div>
<a href="<?=geturl('myroom/progress/'.$folder['folderid'])?>" class="progressTaga">
<div class="piaoyin">
<span style="position:absolute;width:100px;top:138px;left:5px"><?=empty($folder['percent'])?0:$folder['percent']?>%</span>
<span class="ertie" style="width:<?=empty($folder['percent'])?0:$folder['percent']?>%;color:<?=empty($folder['percent'])?'#000':'#fff'?>;"></span>
</div></a>
<span class="spne">
<a href="<?=geturl('myroom/progress/'.$folder['folderid'])?>"><?=$folder['foldername']?>(<?=$folder['coursewarenum']?>)</a>
</span>
</li>
<?php }?>
</ul>
<?php }else{?>
<div style="padding-left:15px; padding-top:4px; font-size:14px;">没有找到相关记录</div>
<?php }?>
</div>

</div>
<?=$pagestr?>
</body>
</html>
