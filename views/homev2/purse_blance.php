<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<style type="text/css">
.etrtud {
	height:120px;
}
.diste {
	float:left;
	width:200px;
	text-align:center;
	height:95px;
	overflow: hidden;
	line-height:1.8;
	font-size:16px;
	padding:0 10px;
}
</style>
<div class="divcontent">
    <div class="jetke">
<?php $this->display('homev2/purse_menu');?>
        <div class="etrtud">
        	<p class="eswtty">
			<!--您当前的账户余额：<span class="jashot">￥<?=intval($user['balance'])?></span><span class="wttuh">.<?php $tmp = explode('.',$user['balance']);echo count($tmp) > 1 ? end($tmp) : '00';?></span><?php if($unaccount){ ?><span class="ejtghe">未到账￥<?=$unaccount?>元</span><?php } ?>-->
			<div class="diste">
				<p class="jashot"><?=intval($user['balance']+$user['freezebalance'])?><span class="wttuh">.<?php $tmp = explode('.',$user['balance']+$user['freezebalance']);echo count($tmp) > 1 ? end($tmp) : '00';?></span></p>
				<p>当前账户余额</p>
			</div>
			<div class="diste" style="border-left:solid 1px #e3e3e3;border-right:solid 1px #e3e3e3;">
				<p class="jashot"><?=intval($user['freezebalance'])?><span class="wttuh">.<?php $tmp = explode('.',$user['freezebalance']);echo count($tmp) > 1 ? end($tmp) : '00';?></span></p>
				<p>冻结金额</p>
			</div>
			<div class="diste">
				<p class="jashot"><?=intval($user['balance'])?><span class="wttuh">.<?php $tmp = explode('.',$user['balance']);echo count($tmp) > 1 ? end($tmp) : '00';?></span></p>
				<p>可提现金额</p>
			</div>
			</p>
            <?php if($user['groupid']==6){?><a href="http://pay.ebh.net" class="zsitbtn" target="_blank" style="margin-top:28px;">充值</a><?php }?>
           	<a href="javascript:;" class="sedynbtn" style="margin-top:28px;">提现</a>
        </div>
        <?php if(!empty($coupon)){ ?>
        <!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
		<?php $room_type = Ebh::app()->room->getRoomType();$room_type = $room_type == 'com' ? 1 : 0;?>	
        <div class="ksttru" style="display: <?=($room_type==1) ? "none":"block"?>;">
        	<span class="wtryng">我的优惠码<span id="mycoupon" class="wtryts"><?=$coupon['code']?></span><a href="javascript:;" class="stryf">复制</a></span>
			<div class="share-bar"></div>
        </div>
<script type="text/javascript">
$('.share-bar').share({
	url: 'http://www.ebh.net/coupon.html?code=<?=$coupon['code']?>',
	source: 'e板会',
	title: '优惠专享！网校优惠任你拿！',
	description: '分享学习，分享快乐！我从<?=$coupon['crname']?>获得了优惠码：<?=$coupon['code']?>，开通任意课程服务都能享受优惠价哦，一起来吧！',
	summary: '好友使用你的优惠码购买课程，尊享网校优惠！你也可以获得现金奖励哦！快快行动吧！',
	image: 'http://static.ebanhui.com/ebh/tpl/2016/images/ebh_coupon.jpg',
	sites: ['qzone','wechat','weibo']
});
</script>
        <?php }else{ ?>
         <div class="etktue">
        	<h2 class="ektyui">您没有购买过任何课程，暂时没有优惠码</h2>
        	<p class="ketsts">请前往<a href="/" class="ethry">www.ebh.net</a>搜索您需要开通的网校服务，</p>
            <p class="ketsts">在任意网校成功开通服务后即可获得属于您的终生优惠码。</p>
        </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/zeroclipboard/dist/ZeroClipboard.js"></script>
<script language="javascript">
$(function(){
	var mybalance = "<?=$user['balance']?>";//可提现余额
	
	//配置swf文件的路径
	ZeroClipboard.config({swfPath: "http://static.ebanhui.com/ebh/js/zeroclipboard/dist/ZeroClipboard.swf"});
	//创建客户端
	var client = new ZeroClipboard( $('.stryf') );
    	client.on( 'ready', function(event) {
	        client.on( 'copy', function(event) {
		      var txt = $('#mycoupon').html();
	          event.clipboardData.setData('text/plain', txt);
	        } );
	        client.on( 'aftercopy', function(event) {
		     // alert('复制成功！');
			  var d = dialog({
				  title:"信息提示",
				  content:"复制成功！",
				  width:300,
				  cancel:false,
				  okValue:"确定",
				  ok:function(){}
			  });
			  d.showModal();
	          // console.log('Copied text to clipboard: ' + event.data['text/plain']);
	        } );
      	} );
    	client.on( 'error', function(event) {
        	// console.log( 'ZeroClipboard error of type "' + event.name + '": ' + event.message );
        	ZeroClipboard.destroy();
      	} );

		$('.sedynbtn').on('click',function(){
			if(parseFloat(mybalance) < 1){
				/*H.create(new P({
			        title:'提示信息',
			        id:'tiptxmessage',
			        content:$('#tsmessage'),
			        easy:true
			    })).exec('show');*/
				top.dialog({
			        skin:"ui-dialog2-tip",
			        width:350,
			        content: "<div class='FPic'></div><p>可提现余额少于1元，不能提现</p>",	
					onshow:function () {
						var that=this;
						setTimeout(function() {
							that.close().remove();
						}, 1000);
					}
				}).showModal();
			}else{
				location.href = '/homev2/purse/applycash.html';
			}
		})
})
</script>
<?php $this->display('homev2/footer');?>