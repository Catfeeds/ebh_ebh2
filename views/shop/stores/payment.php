<?php $this->display('shop/stores/stores_header'); ?>
<?php $this->display('shop/stores/contacts_common'); ?>

<div class="rigbian">
<h2 class="htitg">付款金额</h2>
<p class="fukjiage">
原价：
<span style="text-decoration: line-through;">￥<?= $room['crprice']*2?></span>
元
<span style="color:red;margin-left:10px;">现价：</span>
<strong style="font-weight:bold;color:red;">
￥
<span><?= $room['crprice']*1?></span>
元
</strong>
</p>
<h2 class="htitg">付款方式</h2>

<div class="zhuyis">
<h3 style="color:#3c96dc;font-size:14px;font-weight:bold;height:30px;line-height:30px;">支付注意事项</h3>
<div style="color:#777777">
<?php if(!empty($conpayment[0]['message'])){?>
<?= $conpayment[0]['message']?>
<?php }else{ ?>
<p>1、在线购买</p>
<p style="margin-left: 18px;">点击“立即购买”，根据提示操作即可。</p>
<p style="margin-top:4px;">2、转账汇款</p>
<p >（1）下述“转账汇款”页中显示的为本网校官方转账汇款的唯一接受账号；</p>
<p >（2）汇款时填写请填写“真实姓名”，并备注“e板会账号”；</p>
<p >（3）汇款后，请保存好“汇款底单”，并及时通知本网校的销售方（详见<a style="cursor:pointer;text-decoration:none; " href="<?= geturl('contacts')?>">“联系方式”</a>页面），以备尽快开通权限，</p><p style="margin-left:30px;">保护您的权益。</p>
<p >（4）注意：银行电汇凭证上须有银行加盖的转讫章；邮局回执上应有邮局日戳。</p>
<?php } ?>
</div>
</div>
<div class="fotxuan">
<div class="fttit">
<div class="neidi"></div>
<ul style="margin-top:-37px;">

<?php if($conpaylist['isschool']==4){ ?>
<li id="lizx" class="xiandeng" onclick="reshow('lizx')"><a href="javascript:;">学点购买</a></li>
<?php }else{ ?>
<li id="lizx" class="xiandeng" onclick="reshow('lizx')"><a href="javascript:;">在线购买</a></li>
<?php } ?>
<li id="lizz" onclick="reshow('lizz')"><a href="javascript:;">转账汇款</a></li>
</ul>
</div>

<?php if($conpaylist['isschool']==4){ 
		  if(empty($user)){
			 $cloudaddurl="/sitecp.php?action=classrbalance";
		  }else{
			if($user['groupid'] == 6){
				$cloudaddurl="/sitecp.php?action=classrbalance";
			}else{
				$cloudaddurl="javascript:alert('对不起，您是教师账号，不可以进行学点购买。');";
			}
		  }
	}else{ 
		if(empty($user)){
			$cloudaddurl="/classactive.html";
		}else{
			if($user['groupid'] == 6){
				$cloudaddurl="/classactive.html";
			}else{
				$cloudaddurl="javascript:alert('对不起，您是教师账号，不可以进行在线购买。');";
			}	
		}
} ?>
<div class="xianei" id="divzx">
<a href="<?= $cloudaddurl?>"><img src="http://static.ebanhui.com/ebh/citytpl/stores/images/goumai0109.jpg" /></a>
</div>

<?php 
	$bankarr = unserialize($conpaylist['bankcard']);
	$bank[1]='中国银行';
	$bank[2]='农业银行';
	$bank[3]='建设银行';
	$bank[4]='招商银行';
	$bank[5]='交通银行';
	$bank[6]='工商银行';
	$bank[7]='杭州银行';
	$bank[8]='华夏银行';
	$bank[9]='北京银行';
	$bank[10]='浙商银行';
	$bank[11]='中信实业银行';
	$bank[12]='杭州联合银行';
	$bank[13]='中国民生银行';
	$bank[14]='中国光大银行';
	$bank[15]='上海浦东发展银行';
	$bank[16]='中国邮政储蓄银行';
?>
<?php if(!empty($bankarr)){?>
<div class="hide" id="divzz">
<ul>
	<?php foreach($bankarr as $v){?>
		<li>
		<div class="lefyhico">
		<img src="http://static.ebanhui.com/ebh/citytpl/stores/images/bank<?= $v['bank']?>.jpg" />
		</div>
		<div class="rigxiang">
		<p class="wenzi" style="font-weight:bold" >银行：<?= $bank[$v['bank']]?></p>
		<p class="wenzi">卡号：<?= $v['card']?></p>
		<p class="wenzi">户名：<?= $v['username']?></p>
		</div>
		</li>

	<?php } ?>
</ul>

</div>
<?php }else{ ?>
<div id="divwu" class="hide">
<img src="http://static.ebanhui.com/ebh/citytpl/stores/images/wuxinxi.jpg" />
</div>

<?php } ?>

</div>
</div>

</div>
<div class="fltkuang"></div>
</div>
<div style="text-align:center;clear:both;">
<?php
	$this->display('common/footer');
?>
</div>

<script type="text/javascript">
<!--
function reshow(id) {
	  var showliid = '#lizx';
      var hidliid = '#lizz';
      var showdiv = '#divzx';
      var hiddiv = '#divzz';
	  var hiddiv = '#divwu';
      if (id != "lizx") {
         $('#lizx').removeClass('xiandeng');
         $('#lizz').addClass('xiandeng');
         $('#divzx').removeClass('xianei');
         $('#divzx').addClass('hide');
         $('#divzz').removeClass('hide');
         $('#divzz').addClass('xianei');
			 if($('#divwu').hasClass('hide')){
				$('#divwu').removeClass('hide');
				$('#divwu').addClass('show');
			 }
         }
      if (id != "lizz") {//在线购买
         $('#lizz').removeClass('xiandeng');
         $('#lizx').addClass('xiandeng');
         $('#divzz').removeClass('xianei');
         $('#divzz').addClass('hide');
         $('#divzx').removeClass('hide');
         $('#divzx').addClass('xianei');
			 if($('#divwu').hasClass('show')){
				$('#divwu').removeClass('show');
				$('#divwu').addClass('hide');
			 }
         }
  }
//-->
</script>