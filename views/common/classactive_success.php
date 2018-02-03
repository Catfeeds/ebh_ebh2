<?php $hideebhinfo = false;
if($roominfo['domain'] == 'jx'){
	$hideebhinfo = true;
	$this->assign('title','开通【'.$itemlist[0]['crname'].'】服务');
}
$this->assign('hideebhinfo',$hideebhinfo)
?>
<?php $this->display('common/site_header');?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/open.css" rel="stylesheet" type="text/css" />
<style>
.main .slst .suc{border:none;}
.main .slst .suc .dengl {background: url(http://static.ebanhui.com/ebh/tpl/2016/images/anniu1.png) no-repeat;height: 30px;width: 110px;}
.hqyhm{color:#ff4444;font-size:24px;font-family: Microsoft Yahei;text-align: center;}
.hqyhm a{color:#999;font-size:14px; padding-left:5px;}
.hqyhm a:hover{color:#17a8f7;}
.fxz{width:405px; margin:0 auto;}
.fxz .title{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/fxz.png) no-repeat; height:12px; margin-top:30px;}
.fxlist{width:235px; margin:0 auto;}
.fxlist ul li{float:left;display:inline;}
.fxlist .social-share a{height: 37px;width: 37px;display: block;float:left;}
.fxlist a.icon-qzone{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktkj.png) no-repeat;}
.fxlist a.icon-qzone:hover{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktkjhover.png) no-repeat;}
.fxlist a.icon-wechat{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktwx.png) no-repeat;margin-left:60px;}
.fxlist a.icon-wechat:hover{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktwxhover.png) no-repeat;}
.fxlist a.icon-weibo{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktwb.png) no-repeat;margin-left:60px;}
.fxlist a.icon-weibo:hover{background: url(http://static.ebanhui.com/ebh/tpl/2016/images/ktwbhover.png) no-repeat;}
p.tishis{color:#626262; line-height:24px; padding-top:20px; padding-left:72px;}
p.tishis a{color:#17a8f7;}
.main .slst .suc{height:145px;}
.help{width: auto;border-right: none;height: auto;float: none;}
</style>
<!-- 引入分享代码 -->
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>

<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg) repeat-y scroll 0 0; height:auto;">
<div class="main" <?php if($roominfo['domain']=='xsyz'){echo 'style="height:auto;overflow:hidden;"';}else{echo 'style="height:500px;overflow:hidden;"';}?>>
<div class="aed"><p>欢迎开通<?=$hideebhinfo?'':'e板会'?>【<?= $roominfo['crname']?>】服务</p></div>
  <div class="slst" <?php if($roominfo['domain']=='xsyz'){echo 'style="height:auto;padding-bottom:65px;"';}else{echo 'style="height:420px;"';}?>><p style="font-weight: bold;padding-top: 15px;padding-left: 35px; color:#666666">帐号开通流程： </p>
    <label>
    <input class="tianxie2" style="cursor:pointer" type="submit" name="tianxie" value="1、填写个人资料" />
    <img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />    </label>
    <label>
    <input class="xuanze" style="cursor:pointer" type="submit" name="xuanze" value="2、选择开通方式" />
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />
    </label>
    <label>
    <input class="kaitong2" style="cursor:pointer" type="submit" name="kaitong" value="3、开通成功" />
    </label>
	<?php if($roominfo['domain']=='xsyz'){?>
			<div class="suc" style="height:auto"><p style="padding-top:80px;">您好 <?= $user['username'] ?> ，您已成功开通<?= $roominfo['crname']?>服务。</p>
			      <p style="line-height:3">现在您可以点击<label>
					  	<input style="cursor:pointer;margin:0;" type="button" onclick="window.location.href='/myroom.html'?>'" name="dengl" class="dengl"  value="马上学习" />
				  </label> 进入学习中心。</p>
				  <!--添加的内容-->
				  <?php if(!empty($coupon)){ ?>
				  <div style="width:910px; margin:0 auto;">
				  	<div class="hqyhm">恭喜您获得优惠码：<span id="couponcode"><?=$coupon['code']?></span><a class="stryf" href="javascript:;">复制</a></div>
						<div class="fxz">
							<div class="title"></div>
							<div class="fxlist">
								<div class="share-bar"></div>
							</div>
						</div>
						<p class="tishis"><span style="color:#ff4d4d; padding-right:5px;">*</span>您可以将此优惠码分享给朋友。您的朋友使用该优惠码开通服务时，可以获得相应的价格优惠；同时，您也将获得等额的现金奖励，奖励金额将直接存入“<a href="/homev2/purse.html">我的钱包</a>”中，可用于下次开通服务或直接提现。</p>
				  	</div>
				  	<?php } ?>
				  	<div style="text-align:center;margin:40px 0 80px 0;"><img src="http://static.ebanhui.com/ebh/tpl/xsyz/xsyz.png"></div>
			</div>
			</div>
	<?php }else{?>
			<div class="suc"><p style="padding-top:50px;">您好 <?= $user['username'] ?> ，您已成功开通<?= $roominfo['crname']?>服务。</p>
			     <p style="line-height:3">现在您可以点击<label>
					  	<input style="cursor:pointer;margin:0;" type="button" onclick="window.location.href='<?= '/myroom.html'?>'" name="dengl" class="dengl"  value="马上学习" />
				  </label> 进入学习中心。</p>
			</div>
			<!--添加的内容-->
			<?php if(!empty($coupon)){ ?>
			<div style="width:910px; margin:0 auto;">
				<div class="hqyhm">恭喜您获得优惠码：<span id="couponcode"><?=$coupon['code']?></span><a class="stryf" href="javascript:;">复制</a></div>
				<div class="fxz">
					<div class="title"></div>
					<div class="fxlist">
						<div class="share-bar"></div>
					</div>
				</div>
				<p class="tishis"><span style="color:#ff4d4d; padding-right:5px;">*</span>您可以将此优惠码分享给朋友。您的朋友使用该优惠码开通服务时，可以获得相应的价格优惠；同时，您也将获得等额的现金奖励，奖励金额将直接存入“<a target="_blank" href="/homev2/purse.html">我的钱包</a>”中，可用于下次开通服务或直接提现。</p>
			</div>
			<?php } ?>
			</div>
	<?php }?>
</div>
  <div class="footlintbg">
<img width="970" height="16" src="http://static.ebanhui.com/ebh/tpl/2012/images/doot5111.jpg">
</div>
</div>
<div style="clear:both;"></div>
<!-- 引入复制组件 -->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/zeroclipboard/dist/ZeroClipboard.js"></script>
<script language="javascript">
$(function(){
	//配置swf文件的路径
	ZeroClipboard.config({swfPath: "http://static.ebanhui.com/ebh/js/zeroclipboard/dist/ZeroClipboard.swf"});
	//创建客户端
	var client = new ZeroClipboard( $('.stryf') );
    	client.on( 'ready', function(event) {
	        client.on( 'copy', function(event) {
		      var txt = $.trim($('#couponcode').html());
	          event.clipboardData.setData('text/plain', txt);
	        } );
	        client.on( 'aftercopy', function(event) {
		      alert('复制成功！');
	          // console.log('Copied text to clipboard: ' + event.data['text/plain']);
	        } );
      	} );
    	client.on( 'error', function(event) {
        	// console.log( 'ZeroClipboard error of type "' + event.name + '": ' + event.message );
        	ZeroClipboard.destroy();
      	} );

    	$('.share-bar').share({
    		url: 'http://www.ebh.net/coupon.html?code=<?=$coupon['code']?>',
    		source: 'e板会',
    		title: '优惠专享！网校优惠任你拿！',
    		description: '分享学习，分享快乐！我从<?=$coupon['crname']?>获得了优惠码：<?=$coupon['code']?>，开通任意课程服务都能享受优惠价哦，一起来吧！',
    		summary: '好友使用你的优惠码购买课程，尊享网校优惠！你也可以获得现金奖励哦！快快行动吧！',
    		image: 'http://static.ebanhui.com/ebh/tpl/2016/images/ebh_coupon.jpg',
    		sites: ['qzone','wechat','weibo']
    	});
})
</script>
<?php $this->display('common/site_footer'); ?>