<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript">
<!--
	var sitecpurl ='#getsitecpurl()#';
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<style type="text/css">
.xiatop {
	width:960px;
	margin:10px auto;
	height:130px;
}
.rigsse {
	width:835px;
	margin-left:20px;
	display:inline;
	float:left;
}

.rigsse .kichtss {
    color: #107AC0;
    font-size: 20px;
    font-weight: bold;
}
.wensize {
	color:#2AA0E6;
	text-indent:25px;
	line-height:1.8;
	margin-top:5px;
	font-size:14px;
	font-weight:bold;
}
.botlink {
    background: none repeat scroll 0 0 #f7f7f7;
    border-bottom: 1px solid #e2e2e2;
    border-top: 1px solid #e2e2e2;
    height: 645px;
    margin:0 auto;
    position: relative;
	text-align:center;
}
.lilie {
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bgdiy0923.jpg) no-repeat 20px 0px;
	width:965px;
	margin:0 auto;
	padding-top:35px;
	position:relative;
}
.botlink li {
	width:140px;
	float:left;
	margin-right:90px;
	height:25px;
	text-align: left;
	padding-left:10px;
	margin-top: 5px;
}
.botlink li a.asds
{
	text-decoration: underline;
	color:#000;
}
.botlink li img {
	float:left;
}
.wenxz {
	color:#9e9e9e;
	width:100px;
	margin-top:8px;
	word-wrap: break-word;
	text-align:left;
}
.titbiaot {
	color:#1b6ea6;
	width:80px;
	height:26px;
	text-align: left;
	position: absolute;
	top:5px;
	left:0px;
	font-size: 14px;
}

.titaaa {
    color: #1B6EA6;
    height: 26px;
    width: 100%;
	text-align: left;
	float:left;
	font-size: 14px;
}
</style>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>

<title><?= $room['crname'] ?></title>
</head>
<?php $this->display('common/public_header'); ?>
<body>
<div class="xiatop">
<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface']?>
<img src="<?= $logo?>" width="102" height="102" style="float:left;"/>
<div class="rigsse">
<h2 class="kichtss"><?= $room['crname']?></h2>
<p class="wensize"><?= $room['summary']?></p>
</div>
</div>
<div class="botlink">
<div style="width:960px;margin:0 auto;">
	<div class="lilie" style="width:960px;float:left;">
	<div class="titbiaot">幼儿园:</div>
		<ul class="list_fltwo" >
			<li>
			<a class="asds" href="http://plyy.ebanhui.com" title="平罗一幼"> 平罗一幼 </a>
			</li>
			<li>
			<a class="asds" href="http://pley.ebanhui.com" title="平罗二幼"> 平罗二幼 </a>
			</li>
			<li>
			<a class="asds" href="http://plsy.ebanhui.com" title="平罗三幼"> 平罗三幼 </a>
			</li>
			<li>
			<a class="asds" href="http://tlye.ebanhui.com" title="陶乐镇幼儿园"> 陶乐镇幼儿园 </a>
			</li>
		</ul>
	
	</div>
	<div style="width:960px;float:left;">
	<div class="titaaa">小学:</div>
		<ul class="list_fltwo" >
			<li>
			<a class="asds" href="http://cgyx.ebanhui.com" title="平罗县城关镇第一小学"> 平罗县城关镇第一小学 </a>
			</li>
			<li>
			<a class="asds" href="http://cgex.ebanhui.com" title="平罗县城关二小"> 平罗县城关二小 </a>
			</li>
			<li>
			<a class="asds" href="http://plsx.ebanhui.com" title="平罗县城关第四小学"> 平罗县城关第四小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plwx.ebanhui.com" title="平罗县城关第五小学"> 平罗县城关第五小学 </a>
			</li>
			<li>
			<a class="asds" href="http://pltx.ebanhui.com" title="平罗县太西小学"> 平罗县太西小学 </a>
			</li>
			<li>
			<a class="asds" href="http://cgqx.ebanhui.com" title="平罗县城关第七小学"> 平罗县城关第七小学 </a>
			</li>
			<li>
			<a class="asds" href="http://cgbx.ebanhui.com" title="平罗县城关第八小学"> 平罗县城关第八小学 </a>
			</li>
			<li>
			<a class="asds" href="http://txex.ebanhui.com" title="平罗县城关镇太西二小"> 平罗县城关镇太西二小 </a>
			</li>
			<li>
			<a class="asds" href="http://plxj.ebanhui.com" title="平罗县新建小学"> 平罗县新建小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plyf.ebanhui.com" title="平罗县姚伏小学"> 平罗县姚伏小学 </a>
			</li>
			<li>
			<a class="asds" href="http://pltf.ebanhui.com" title="平罗县通伏小学"> 平罗县通伏小学 </a>
			</li>
			<li>
			<a class="asds" href="http://pltj.ebanhui.com" title="平罗县团结小学"> 平罗县团结小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plmc.ebanhui.com" title="平罗县马场小学"> 平罗县马场小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plxc.ebanhui.com" title="平罗县新潮小学"> 平罗县新潮小学 </a>
			</li>
			<li>
			<a class="asds" href="http://qkyf.ebanhui.com" title="平罗县渠口逸夫九年制小学部"> 平罗县渠口逸夫九年制... </a>
			</li>
			<li>
			<a class="asds" href="http://plqk.ebanhui.com" title="平罗县渠口小学"> 平罗县渠口小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plly.ebanhui.com" title="平罗县庙湖小学"> 平罗县庙湖小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plhy.ebanhui.com" title="平罗县红阳小学"> 平罗县红阳小学 </a>
			</li>
			<li>
			<a class="asds" href="http://tzsjq.ebanhui.com" title="平罗县头闸镇邵家桥小学"> 平罗县头闸镇邵家桥小学 </a>
			</li>
			<li>
			<a class="asds" href="http://tzhg.ebanhui.com" title="平罗县头闸镇红岗小学"> 平罗县头闸镇红岗小学 </a>
			</li>
			<li>
			<a class="asds" href="http://pldl.ebanhui.com" title="平罗县东灵小学"> 平罗县东灵小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plxl.ebanhui.com" title="平罗县西灵小学"> 平罗县西灵小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plsl.ebanhui.com" title="平罗县胜利小学"> 平罗县胜利小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plty.ebanhui.com" title="平罗县统一小学"> 平罗县统一小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plbf.ebanhui.com" title="平罗县宝丰小学"> 平罗县宝丰小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plqz.ebanhui.com" title="平罗县渠中小学"> 平罗县渠中小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plhb.ebanhui.com" title="平罗县惠北小学"> 平罗县惠北小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plth.ebanhui.com" title="平罗县通惠小学"> 平罗县通惠小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plxr.ebanhui.com" title="平罗县西润小学"> 平罗县西润小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plgz.ebanhui.com" title="宁夏平罗县高庄小学"> 宁夏平罗县高庄小学 </a>
			</li>
			<li>
			<a class="asds" href="http://tjxx.ebanhui.com" title="平罗县同进小学"> 平罗县同进小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plyg.ebanhui.com" title="平罗县银光小学"> 平罗县银光小学 </a>
			</li>
			<li>
			<a class="asds" href="http://pldf.ebanhui.com" title="平罗县东风小学"> 平罗县东风小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plhw.ebanhui.com" title="平罗县惠威小学"> 平罗县惠威小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plcg.ebanhui.com" title="平罗县崇岗中心学校"> 平罗县崇岗中心学校 </a>
			</li>
			<li>
			<a class="asds" href="http://plrqg.ebanhui.com" title="平罗汝箕沟小学"> 平罗汝箕沟小学 </a>
			</li>
			<li>
			<a class="asds" href="http://tlyx.ebanhui.com" title="平罗县陶乐第一小学"> 平罗县陶乐第一小学 </a>
			</li>
			<li>
			<a class="asds" href="http://tlex.ebanhui.com" title="平罗县陶乐第二小学"> 平罗县陶乐第二小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plhyz.ebanhui.com" title="平罗县红崖子小学"> 平罗县红崖子小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plwdz.ebanhui.com" title="平罗县五堆子小学"> 平罗县五堆子小学 </a>
			</li>
			<li>
			<a class="asds" href="http://plskl.ebanhui.com" title="平罗县三棵柳小学"> 平罗县三棵柳小学 </a>
			</li>
			<li>
			<a class="asds" href="http://cghm.ebanhui.com" title="平罗县城关回民小学"> 平罗县城关回民小学 </a>
			</li>
			<li>
			<a class="asds" href="http://ybwdz.ebanhui.com" title="平罗县红瑞燕宝小学"> 平罗县红瑞燕宝小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szswxxx.ebanhui.com" title="平罗县五香小学"> 平罗县五香小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szscgyfxx.ebanhui.com" title="平罗县城关第六小学"> 平罗县城关第六小学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsgzzx.ebanhui.com" title="平罗县高庄中心小学"> 平罗县高庄中心小学 </a>
			</li>
		</ul>
	
	</div>
	<div style="width:960px;float:left;">
	<div class="titaaa">中学:</div>
		<ul class="list_fltwo">
			<li>
			<a class="asds" href="http://plwz.ebanhui.com" title="平罗县第五中学"> 平罗县第五中学 </a>
			</li>
			<li>
			<a class="asds" href="http://plsz.ebanhui.com" title="平罗县第四中学"> 平罗县第四中学 </a>
			</li>
			<li>
			<a class="asds" href="http://plqiz.ebanhui.com" title="平罗县第七中学"> 平罗县第七中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsyfzx.ebanhui.com" title="平罗县姚伏中学"> 平罗县姚伏中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsqkxx.ebanhui.com" title="平罗县渠口九年制学校"> 平罗县渠口九年制学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szstzzx.ebanhui.com" title="平罗县头闸中学"> 平罗县头闸中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsbfhmzx.ebanhui.com" title="平罗县宝丰回民初级中学"> 平罗县宝丰回民初级中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szslsxx.ebanhui.com" title="灵沙九年制学校"> 灵沙九年制学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szsdlzx.ebanhui.com" title="平罗县第六中学"> 平罗县第六中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szszcxx.ebanhui.com" title="平罗县周城九年制学校"> 平罗县周城九年制学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szsshxx.ebanhui.com" title="沙湖 九年制学校"> 沙湖九年制学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szshqqxx.ebanhui.com" title="平罗县黄渠桥九年制学校"> 平罗县黄渠桥九年制学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szscgxx.ebanhui.com" title="平罗县崇岗九年制学校"> 平罗县崇岗九年制学校 </a>
			</li>
			<li>
			<a class="asds" href="http://szshmgjzx.ebanhui.com" title="平罗县回民高级中学"> 平罗县回民高级中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szshmzx.ebanhui.com" title="平罗县回民中学"> 平罗县回民中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szstlzx.ebanhui.com" title="平罗县陶乐中学"> 平罗县陶乐中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsplzx.ebanhui.com" title="平罗中学"> 平罗中学 </a>
			</li>
			<li>
			<a class="asds" href="http://szsplzy.ebanhui.com" title="平罗县职业教育中心"> 平罗县职业教育中心 </a>
			</li>
		</ul>
	
	</div>

</div>
</div>
   <?php
    $this->display('common/footer');
    ?>