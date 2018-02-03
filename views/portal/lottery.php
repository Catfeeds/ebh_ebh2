<?php $this->display('common/header');?>

<script src="http://static.ebanhui.com/ebh/js/AC_RunActiveContent.js" type="text/javascript"></script>

<div class="wrapper">
<div class="toptitnew">
<a href="/" target="_blank">首页</a>
> 积分计划
</div>
<div class="weltuyl">
<h2 class="jewtit"><img src="http://static.ebanhui.com/portal/images/xyunbtn.jpg" /></h2>

<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','620','height','540','src','/static/flash/plateGame','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/static/flash/plateGame' ); //end AC code
</script>
<noscript>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="620" height="540">
  <param name="movie" value="/static/flash/plateGame.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="opaque">
  <embed src="/static/flash/plateGame.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="620" height="540"></embed>
</object>
</noscript>
<div class="rudfkt" style="*margin-top:-500p;">
<?php if(!empty($user)){?>
	<p style="font-weight:bold;"><?=empty($user['realname'])?$user['username']:$user['realname']?>，您好</p>
	<p style="font-weight:bold;">您当前的积分为<span id="credit" style="color:red;"><?=$user['credit']?></span>分</p>
<?php }?>
<a class="etlet" href="<?=geturl('home/score/description')?>" target="_blank">如何赚取更多积分>></a> 
<p class="sryhht">看看谁中奖了</p>

<div class="gunwen">
<div id="maq" style="overflow:hidden;width:275px;height:275px;" align="center">
		<div id="mtext">
			<table id=table1 cellSpacing=0 cellPadding=0 width="100%" border=0>
				<tbody>
					<?php foreach ($lotterylogs as  $lotterylog){?>
					<tr>
						<td>
							<table id=table2 cellSpacing=0 cellPadding=0 width="100%" border=0>
								<tbody>		 
									<tr>
										<td height="24">
											<p><span style="font-weight:bold;color:red;"><?=empty($lotterylog['realname'])?$lotterylog['username']:$lotterylog['realname']?></span>&nbsp;&nbsp;抽中了<?=$lotterylog['productname']?></p>											
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
<div id="m0"></div>
</div>
<script>
	var speed=40  //调整滚动速度
	m0.innerHTML=mtext.innerHTML
	function Marquee(){
		if(m0.offsetTop-maq.scrollTop<=0){
			maq.scrollTop-=mtext.offsetHeight
		}else{
			maq.scrollTop++
		}
	}
	var MyMar=setInterval(Marquee,speed)
	maq.onmouseover=function() {clearInterval(MyMar)}
	maq.onmouseout=function() {MyMar=setInterval(Marquee,speed)}
</script>

</div>
</div>
<h2 class="jewtit">
<img src="http://static.ebanhui.com/portal/images/jfenlibtn.jpg">
</h2>
<div class="tewoly">
<ul>
<?php foreach ($productList as $productkey => $product) {?>
	<li class="elyjrt" <?php if($productkey%3==1){echo 'style="margin-left:25px;margin-right:25px;"';}?> >
		<?php if(!empty($user)){?>
		<a target="_blank" href="<?=geturl('lottery/exchange/'.$product['productid'])?>"><img style="width:312px;height:182px;" src="<?=$product['image']?>"></a>
		<a target="_blank" href="<?=geturl('lottery/exchange/'.$product['productid'])?>"><h3 class="rtketi"><?=$product['productname']?></h3></a>
		<?php }else{?>
		<a target="_blank" href="javascript:void(0)" onclick="tologinn('/login.html?returnurl=__url__');"><img style="width:312px;height:182px;" src="<?=$product['image']?>"></a>
		<a target="_blank" href="javascript:void(0)" onclick="tologinn('/login.html?returnurl=__url__');"><h3 class="rtketi"><?=$product['productname']?></h3></a>
		<?php }?>
		<p class="rtjry"><span style="color:#ee7b3d;"><?=$product['credit']?>积分</span> | 原价：<?=$product['marketprice']?>元</p>
		<?php if(empty($user)){?>
			<a target="_blank" href="javascript:void(0)" onclick="tologinn('/login.html?returnurl=__url__');" class="yuekds">兑 换</a>
		<?php }else{?>
			<a target="_blank" href="<?=geturl('lottery/exchange/'.$product['productid'])?>" class="yuekds">兑 换</a>
		<?php }?>
	</li>
<?php }?>
</ul>
</div>
<h2 class="jewtit" style="margin:10px 0;">
<img src="http://static.ebanhui.com/portal/images/hdongbtn.jpg">
</h2>
<div class="eotle">
<h3 class="h3tit">1.抽奖活动</h3>
<p><span class="shspan">活动时间：</span> 即日起长期有效</p>
<h4 class="h4tit">抽奖规则：</h4>
<p>1.抽奖以公平公正为原则，只要是e板会的注册会员就可免费参加，每抽奖一次需消费20积分。</p>
<p>2.点击“立即抽奖”按钮开始抽奖，根据指针最终指向的位置获得相应的奖品或积分。</p>
<p>3.本奖品不可折现，亦不可转让，奖品以实物为准（图片仅供参考）。</p>
<p>4.中奖商品/产品，如非质量问题，概不退换。</p>
<p>5.无论是否中奖，您参加抽奖所用的积分，在点击“立即抽奖”之后，即刻扣除，不可退回。</p>
<p>6.如遇不可抗力因素，本次活动因故无法进行时，e板会有权决定取消、终止、修改或暂停本活动。</p>
<h4 class="h4tit">兑换方式：</h4>
<p>1.中奖之后，如果您所获得的是积分奖品，则立即发放到抽奖账户；如果您所获得的是实物奖品，则需在7个工作日内联系我们，我们核对中奖信息</p>
<p>  无误后，将在7个工作日内发放奖品。奖品邮寄费用须由中奖者承担（快递到付）。</p>
<p>2.在规定时间内，中奖者没有联系联系我们，将视为自行放弃领奖。</p>
<p>3.中奖者请仔细核对个人资料，正确填写联系地址，如果由于中奖者资料填写错误导致奖品不能送达，此礼品将不会再次发放。</p>
<h4 class="h4tit">温馨提示：</h4>
<p>1.凡有各种作弊刷分行为的获奖用户，一律取消获奖资格。我们也希望广大e板会用户都能够互相监督，共同创建一个公正、公平、公开的抽奖环境！</p>
<p>2.浙江新盛蓝科技有限公司在中华人民共和国法律规定范围内对本次活动具有解释权！</p>
<h3 class="h3tit">2.积分换礼品活动规则</h3>
<p><span class="shspan">活动时间：</span>即日起长期有效</p>
<h4 class="h4tit">抽奖规则：</h4>
<p>1.本积分兑换活动以公平公正为原则，凡e板会注册会员均可参与积分兑换。</p>
<p>2.当注册会员使用积分兑换礼品成功后，系统将即时的扣减会员相应积分。</p>
<p>3.兑换礼品时，根据个人的积分情况换取不同的礼品或商品；礼品数量有限，兑完为止。</p>
<p>4.本活动礼品不可折现或转让他人，兑换礼品图片文字仅供参考，请以实物为准。</p>
<p>5.因活动参与者没有仔细阅读活动规则、个人信息填写不准确等造成的损失和后果，须由本人承担。</p>
<p>6.如遇不可抗力因素，本次活动因故无法进行时，e板会有权决定取消、修改或暂停活动。</p>
<h4 class="h4tit">兑换方式：</h4>
<p>1.兑换成功后，请在5~10个工作日内与我们联系核实信息，联系EQ客服或拨打客服热线（具体联系方式见下方）。</p>
<p>2.经我们核实无误后，将于5~10个工作日内安排发货。物流方式采用顺丰快递+保价，邮费与保价费均为到付。</p>
<p>3.兑换礼品订单一旦生成若无质量问题，将不予办理礼品退换货。</p>
<p>4.在规定时间内，兑换者没有联系联系我们，将视为自行放弃兑换，积分不予退还。</p>
<h4 class="h4tit">温馨提示：</h4>
<p>1.各项积分兑换的产品、标准及兑换规则均以当时最新公告或目录为准。</p>
<p>2.积分礼品兑换属感恩回馈活动，将不提供发票。</p>
<p>3.本次活动最终解释权归浙江新盛蓝科技有限公司所有。</p>
<h3 class="h3tit">3.联系我们：</h3>
<div class="lianst">
<ul>
<li class="qqiclian">
<a class="ekrtu" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1808609435&amp;site=qq&amp;menu=yes""  target="_blank" class="ekrtu"></a>
</li>
<li class="kficlian">
<p class="boldd">客服电话</p>
0571-87757303
</li>
<li class="wxiclian">
<p class="boldd">微信</p>
客服账号：e板会
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
<script>
	//抽奖成功后的回调函数/改变网页的用户积分显示
	function callPage(credit){
		$("#credit").html(credit);
	}
</script>
<?php $this->display('common/footer');?>