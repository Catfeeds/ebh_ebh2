<?php
$this->display('common/header');
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.main .topjf .loghou {
	width:180px;
	height:190px;
	border:solid 1px #cdcdcd;
	background:url(http://static.ebanhui.com/ebh/tpl/2012/images/loghoubg1116.jpg) repeat-x;
	float:left;
}
.main .topjf .loghou .lotop {
	height: 90px;
	width: 170px;
	margin-top: 10px;
	margin-left: 10px;
}
.main .topjf .loghou .lotop .adtux {
	width:78px;
	height:78px;
	padding:1px;
	border:solid 1px #cdcdcd;
	margin-right: 15px;
	float: left;
}
.main .topjf .loghou .lotop .riglo {
	float: left;
	width: 65px;
	margin-top: 20px;
}
.main .topjf .loghou a.logsbtn {
	background:#3bb6fa;
	display: block;
	height: 32px;
	line-height:32px;
	width: 125px;
	color:#fff;
	text-decoration: none;
	font-size:16px;
	font-weight:bold;
	text-align:center;
	margin-left:25px;
	margin-top:10px;
	margin-bottom:10px;
}
.main .topjf .loghou a.logsbtn:hover {
	background:#18a8f7;
}
.main .topjf .loghou .lotop h2 {
	font-size: 14px;
	font-weight: bold;
	word-wrap:break-word;
}
.main .topjf .loghou .lotop p {
	color: #d10101;
	font-size: 14px;
}
.main .topjf .loghou .botsiz {
	height: 25px;
	width: 160px;
	border: 1px solid #e2ceb3;
	text-align: center;
	line-height: 25px;
	margin-left: 10px;
}
</style>

<div class="main">
<div class="topjf">

<?php if(empty($user)){?>
	<div class="logos">
	<?php $reurl="javascript:tologinn('/login.html?returnurl=__url__');"?>
	<a href="<?= $reurl?>" class="logobtn">登录查看我的信息</a>
	<p>&bull;查询积分余额、交易记录</p>
	<p>&bull;参加积分体验、兑换活动</p>
	</div>
<?php }else{
		$sex = empty($user['sex']) ? 'man' : 'woman';
		$type = $user['groupid'] == 5 ? 't' : 'm';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
		$face = empty($user['face']) ? $defaulturl : $user['face'];
		$facethumb = getthumb($face,'78_78');
 ?>
	<div class="loghou">
	<div class="lotop">
	<div class="adtux"><img src="<?= $facethumb ?>" width="78" height="78" /></div>
	<div class="riglo"><h2><?= $user['username']?></h2>
	<p><span><?= $user['credit']?></span><img src="http://static.ebanhui.com/ebh/tpl/2012/images/logico1116.jpg" /></p>
	<a href="<?= geturl('member/score/record')?>" style="color:#459ec8;">积分明细></a></div>
	</div>
	<a href="<?= geturl('member/score/routinetask')?>" class="logsbtn">积分任务</a>
	<p class="botsiz">连续登录可获得更多积分</p>
	</div>
<?php } ?>


<div class="adtop"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/addtop1106.jpg" /></div>
<div class="feature">
	<h2>e板会积分</h2>
	<ul>
	<li class="ejf1">
		<h3>学习返积分</h3>
		<p>在e板会平台学习，可返积分
		快来学习吧！</p>
	</li>
	<li class="ejf2">
		<h3>任务赚取</h3>
		<p>做个调查，参与活动，
		轻点鼠标赚积分。</p>
	</li>
	<li class="ejf3">
		<h3>积分抵现</h3>
		<p>积分可以当钱花，
		50积分=1元。</p>
	</li>
	<li class="ejf4">
	<h3>积分换购</h3>
	<p>用积分可以换购e板会产品。</p>
	</li>
	<li class="ejf5">
	<h3>爱心积分</h3>
	<p>e板会学员积分是回馈给学员
	的优惠政策。</p>
	</li>
	</ul>
</div>
<div class="jian">
	<ul>
		<li>
			<div class="kuimg"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/jftu11061.jpg" /></div>
			<span>海量优秀课件
			轻松兑换学习</span>
		</li>
		<li>
			<div class="kuimg"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/jftu11062.jpg" /></div>
			<span>学习返积分
			小积分大乐趣</span>
		</li>
		<li>
			<div class="kuimg"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/jftu11063.jpg" /></div>
			<span>打折再返积分
			尽享双重优惠</span>
		</li>
	</ul>
</div>
<div class="whywen">
<div class="titbiao">
	<ul style="width:265px;">
		<li class="whyjf3" style="float: left;margin-left:2px;">
			<span>如何获得</span>
		</li>

	</ul>
</div>
	<div class="xianq">
		<p>e板会积分是赠送给用户的虚拟货币。用户通过日常操作、参加活动、购买e板会产品等可获得积分，并可用积分来兑换学习体验券、软硬件产品，甚至学习年卡。</p>
	</div>
</div>
</div>

	<div class="fotyue">
		<div class="yuedi">
			<h2 class="yuehuan">礼品兑换</h2>
		</div>
		<ul>
			<?php foreach($productlist as $sv){ ?>
			<li>
				<div class="tuku"><a href="<?= geturl('score/'.$sv['productid'])?>"><img width="219px;" height="120px;" src="<?= !empty($sv['image'])?$sv['image']:'http://static.ebanhui.com/ebh/tpl/default/images/nopic.gif'?>" /></a></div>
				<h3><a href="<?= geturl('score/'.$sv['productid'])?>"><?= $sv['productname']?></a></h3>
				<p><span style="color:#ee7b3d;"><?= $sv['credit']?>积分</span> | 原价：<span><?= $sv['marketprice']?>元</span></p>
					<a class="score" href="<?= geturl('score/'.$sv['productid'])?>">立即兑换</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>
<div style="clear:both;"></div>
<?php
    $this->display('common/footer');
?>