<?php $this->display('home/page_header'); ?>

<script src="http://static.ebanhui.com/ebh/js/AC_RunActiveContent.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/portal/css/ebhportal.css">
<div class="weltuyl  lefrig" style="width:780px;height:1100px; border:none;">
<div style="margin-left:100px">
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
</div>

<div class="rudfkt" style="*margin-top:-500p;margin-right:230px">
<?php if(!empty($user)){?>
	<p style="font-weight:bold;"><?=empty($user['realname'])?$user['username']:$user['realname']?>，您好</p>
	<p style="font-weight:bold;">您当前的积分为<span id="credit" style="color:red;"><?=$user['credit']?></span>分</p>
<?php }?>
<a class="etlet" href="<?=geturl('home/score/description')?>">如何赚取更多积分>></a> 
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
</div>
<script>
	//抽奖成功后的回调函数/改变网页的用户积分显示
	function callPage(credit){
		$("#credit").html(credit);
	}
</script>
