<?php $this->display('common/header')?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<style>
	.zhengque {
		 line-height: 24px; 
	}
	.ui-widget-header{
		border:0;
	}
</style>
<div class="wrapper weltuyl" style="overflow:hidden;background:#fff;">
	<div class="toptitnew">
		<a href="/" target="_blank">首页</a>
		> <a href="/lottery.html">积分计划</a> > 积分兑换
	</div>
	<h3 class="xiaobiao" style="margin:20px 0 15px 0;">常见问题</h3>
	<div class="eltmu">
		<ul>
		<li class="kren"><a target="_blank" href="/help/2089.html">e板会积分如何查询，有什
		么用途？</a></li>
		<li class="rtkere"><a target="_blank" href="/help/2090.html">积分兑换有哪些需要注意的
		地方吗？</a></li>
		<li class="enfrsct"><a target="_blank" href="/help/2091.html">积分抽奖及兑换礼品的规则
		是什么？</a></li>
		</ul>
	</div>
	<div class="letty">
		<img style="width:355px;height:203px;" src="<?=$product['image']?>">
	</div>
	<div class="wetin">
		<h2 class="rttre"><?=$product['productname']?></h2>
		<p>原　　价：　￥<?=$product['marketprice']?></p>
		<p>积　　分：　<span style="font-size:18px;font-weight:bold;color:#ff4e00;"><?=$product['credit']?></span> 积分</p>
		<p>已 兑 换：　<span id="sellqty"><?=$product['sellqty']?></span>件</p>
		<p>库　　存：　<span id="stockqty"><?=$product['stockqty']?></span>件</p>
		<div class="fonly">
			 <?php if(empty($user)){ ?>
			  	  <a href="javascript:void(0);"  id="duihuan" class="sethuan">立即兑换</a>
			  <?php }else{ ?>
			  	 <?php if($product['stockqty']>0){ ?>
					  <?php if($user['credit'] < $product['credit']){ ?>
					  	<a href="javascript:void(0);" onclick="alert('很抱歉，您当前的积分不足,兑换(<?= $product['productname']?>)需要<?= $product['credit']?>积分!');" class="sethuan">立即兑换</a>
					  <?php }else{ ?>
					  	<a href="javascript:void(0);" onclick="exchange(<?= $product['productid']?>,<?= $product['type']?>);" class="sethuan">立即兑换</a>
					  <?php } ?>
				 <?php }else{ ?>
				  	  <a href="javascript:void(0);" onclick="alert('库存不足！')" class="sethuan">立即兑换</a>
				 <?php } ?>
			  <?php } ?>

		</div>
	</div>
	<div class="erkutt">
		<h2 class="tjreh"><span class="erktlt" >&nbsp;礼品介绍</span></h2>
		<p style="text-indent:25px;line-height:1.8;margin-top:10px;float:left;width:1000px;"><?=$product['message']?></p>
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
  		<div id='score' style="display: none;">
				<div class="tswin" id="receiving" style="width:420px;">
					<p class="jiming" style="color:#5e5e5e;">请填写地址作为礼品的收货地址!</p>
					
					<table border="0" cellpadding="0"  class="intmis">
					  <tr>
					    <td width="70" align="right">姓名：</td>
					    <td colspan="3">
					    	<input class="inpkur" type="text" id="name" name="name" onblur="cnull('name');" maxlength="15" />
							<em class="error" id="name_msg"></em>
					    </td>
					  </tr>
					  <tr>
					    <td width="70" align="right" valign="top">地址：</td>
					    <td colspan="3">
					    	<input class="inpkur" style="width:295px;" type="text" id="address" name="address" onblur="cnull('address')" maxlength="60" />
							<em class="error" id="address_msg"></em>
					    </td>
					  </tr>
					  <tr>
					    <td width="70" align="right">手机：</td>
					    <td width="130">
					    	<input class="inpkur" type="text" id="phone" name="phone" onblur="cphone()" maxlength="15" />
							<em class="error" id="phone_msg"></em> 
						</td>
						<td width="50" align="right">邮编：</td>
					    <td>
							<input class="inpkur" type="text" id="postcode" name="postcode" onblur="cpostcode()" maxlength="6" />
				  			<em class="error" id="postcode_msg"></em>
					    </td>
					  </tr>
					</table>
					
					<input style="margin-top:10px;" class="queren" id="scoresubmit" type="submit" name="Submit" value="确认" />
				</div>
				<div class="tswin" id="confirm" style="display: none;width:420px;font-size:14px;">
					<p class="xinxi" style="height:auto;line-height:24px;">您确定要用<span class="zilan"></span>积分兑换原价<span class="zideng"></span>的<span id="pname"></span>？</p>
					<table width="400" border="0" cellpadding="0" style="color:#5e5e5e;">
					  <tr>
					    <td width="125" align="right" valign="top">地址：</td>
					    <td colspan="3"><label id="saddress"></label></td>
					  </tr>
					  <tr>
					    <td width="125" align="right">姓名：</td>
					    <td colspan="3"><label id="sname"></label></td>
					  </tr>
					  <tr>
					    <td width="125" align="right">手机：</td>
					    <td><label id="sphone"></label></td>
    					<td width="125" align="right">邮编：</td>
					    <td><label id="scode"></label></td>
					  </tr>
					</table>
					
					<input class="queren" type="submit" style="margin-top:10px;" id="confirmexchange" name="Submit" value="确认兑换" />
					<input class="quxiao" type="submit" style="margin-top:10px;" name="Submit2" onclick="H.get('score').exec('close');" value="取消兑换" />
					
				</div>
				
				<div class="tswin" id="virtual" style="display: none;width:310px;font-size:14px;">
					<p class="xinxi" style="width:350px;height:auto;line-height:24px;margin-bottom:8px;">您确定要兑换<?= $product['productname']?>？</p>
					<table width="375" border="0" cellpadding="0" style="color:#5e5e5e;">
					  <tr>
					    <td width="125" align="right" valign="top">产品名称：</td>
					    <td width="250" align="left"><label><?= $product['productname']?></label></td>
					  </tr>
					  <tr>
					    <td width="125" align="right">平　　台：</td>
					   
					    <td width="150" align="left"><label><?= $roomvalue['crname']?></label></td>
					  </tr>
					  <tr>
					    <td width="125" align="right">原　　价：</td>
					    <td width="150" align="left"><label><?= $product['marketprice']?></label></td>
					  </tr>
					  <tr>
					    <td width="125" align="right">积　　分：</td>
					    <td width="150" align="left"><label><?= $product['credit']?></label></td>
					  </tr>
					</table>
					
					<input class="queren" type="submit" style="margin-top:10px;margin-left: 77px;" id="conversion" name="Submit" value="确认兑换" />
					<input class="quxiao" type="submit" style="margin-top:10px;" name="Submit2" onclick="H.get('score').exec('close');" value="取消兑换" />
					
				</div>
				
				<div id="message" style="display:none;">
					<div class="fenx">
                         <div class="js_share" align="right">
                         	<!-- Baidu Button BEGIN -->
						   <!--  <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="margin-left:25px;">
						        <span class="bds_more">分享到：</span>
						        <a class="bds_qzone"></a>
						        <a class="bds_tsina"></a>
						        <a class="bds_tqq"></a>
						        <a class="bds_renren"></a>
								<a class="shareCount"></a>
						    </div> -->
                        </div>
						<p id="mmsg" ></p>
						<p class="jiming" id="res" style="float:left;"></p>
						<input style="float:left;margin-top:10px;" class="queren" type="submit" name="Submit" onclick="H.get('score').exec('close');" value="确认" />
					</div>
				</div>
				
				<div id="virtualmessage" style="display:none;">
					<div class="fenx">
                         <div class="js_share" align="right"><!-- Baidu Button BEGIN -->
						   <!--  <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="margin-left:25px;">
						        <span class="bds_more">分享到：</span>
						        <a class="bds_qzone"></a>
						        <a class="bds_tsina"></a>
						        <a class="bds_tqq"></a>
						        <a class="bds_renren"></a>
								<a class="shareCount"></a> -->
						    </div>
                        </div>
						<p id="vmsg"></p>
						<p class="jiming" id="resmsg" style="float:left;"></p>
						<input style="float:left; margin-left:115px;" class="queren" type="submit" name="Submit" onclick="H.get('score').exec('close');" value="确认" />
					</div>
				</div>
				
		</div>
</div>


<script type="text/javascript">
$("#duihuan").click(function(){
	$.loginDialog($(this).attr("name"));
});
function exchange(id,type)
{
	if($("#stockqty").html()=="0"){
		alert("商品库存不足！");
		return;
	}
	if(type==1){
		$('input:text').each(function(){
			$(this).val('');
		});
		$('em').each(function(){
			$(this).html('');
		});
		$('#message').hide();
		$("#confirm").hide();
		$("#receiving").hide();
		$("#virtualmessage").hide();
		H.get('score').exec('show')
		$('#virtual').show();
		$('#oid').val(id);
		var ieset = navigator.userAgent;
	}else{
		$('input:text').each(function(){
			$(this).val('');
		});
		$('em').each(function(){
			$(this).html('');
		});
		$('#message').hide();
		$("#confirm").hide();
		
		H.get('score').exec('show')
		$('#receiving').show();
		$('#oid').val(id);
		var ieset = navigator.userAgent;
	}
}


$(function(){
	H.create(new P({
		title:'提示',
		id:'score',
		content:$("#score")[0],
		easy:true,
		padding:10,
		width:400
	}),'common');
});

function cnull(type){
	var val = $("#"+type).val();
	if(val==''){
		$("#"+type+"_msg").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png">');
		return false;
	}else{
		$("#"+type+"_msg").html('<img src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" class="cue">');
		return true;
	}
}
function cphone(){
	var phone = $("#phone").val();
	var phonereg = /^(1[3-9]{1}[0-9]{9})$/;
	if(phone=='' || !phonereg.test(phone)){
		$("#phone_msg").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png">');
		return false;
	}else{
		$("#phone_msg").html('<img src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" class="cue">');
		return true;
	}
}

function cpostcode(){
	var postcode = $("#postcode").val();
	var postcodereg = /^[0-9][0-9]{5}$/;
	if(postcode == "" || !postcodereg.test(postcode)){
		$("#postcode_msg").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png">');
		return false;
	}else{
		$("#postcode_msg").html('<img src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" class="cue">');
		return true;
	}
}

$(function(){
	$("#scoresubmit").click(function(){
		if(cnull('name')!=true || cnull('address')!=true || cphone()!=true || cpostcode()!=true){
			return false;
		}
		var name = $("#name").val();
		var phone = $("#phone").val();
		var address = $("#address").val();
		var postcode = $("#postcode").val();
		$("#sname").html(name);
		$("#sphone").html(phone);
		$("#saddress").html(address);
		$("#scode").html(postcode);
		$(".zilan").html('<?= $product['credit']?>');
		$(".zideng").html('<?= $product['marketprice']?>');
		$("#pname").html('<?= $product['productname']?>');
		$("#receiving").hide();
		$("#confirm").show();
	});
	$("#confirmexchange").click(function(){
		var name = $("#name").val();
		var phone = $("#phone").val();
		var address = $("#address").val();
		var postcode = $("#postcode").val();
		$.ajax({
			url:"<?= geturl('score/submitorders')?>",
			type:'post',
			data:{'pid':'<?= $product['productid']?>','productname':'<?= $product['productname']?>','name':name,'phone':phone,'address':address,'postcode':postcode,'type':'<?= $product['type']?>','op':'submitorders','inajax':1},
			dataType:'json',
			success:function(_json){
				if(_json.result!='success'){
					updateData(_json.sellqty,_json.stockqty);
					$("#confirm").hide();
					$("#mmsg").addClass('cuo');
					$("#mmsg").html(_json.pname+'兑换失败！');
					if(_json.result=='error2'){
						$("#res").html(_json.msg);
					}else{
						$("#res").html('你兑换礼品失败，请稍后再试。');
					}
					$("#message").show();
				}else{
					updateData(_json.sellqty,_json.stockqty);
					$("#confirm").hide();
					$("#mmsg").addClass('zhengque');
					$("#mmsg").html(_json.pname+'兑换成功！');
					$("#res").html('你兑换的礼品已保存在我的积分兑换明细中，<a href="<?= geturl('home/score/record')?>" target="_blank" style="font-weight:bold; color:#000;">点击查看</a>');
					$("#message").show();
				}
			}
		});
	});

	$("#conversion").click(function(){
		$.ajax({
			url:"<?= geturl('score/submitorders')?>",
			type:'post',
			data:{'pid':'<?= $product['productid']?>','type':'<?= $product['type']?>','productname':'<?= $product['productname']?>','days':'<?= $product['days']?>','op':'submitorders','inajax':1},
			dataType:'json',
			success:function(_json){
				if(_json.result!='success'){
					updateData(_json.sellqty,_json.stockqty);
					$("#virtual").hide();
					$("#vmsg").addClass('cuo');
					$("#vmsg").html(_json.pname+'兑换失败！');
					if(_json.result=='error2'){
						$("#resmsg").html(_json.msg);
					}else{
						$("#resmsg").html('你兑换礼品失败，请稍后再试。');
					}
					
					$("#virtualmessage").show();
				}else{
					updateData(_json.sellqty,_json.stockqty);
					$("#virtual").hide();
					$("#vmsg").addClass('zhengque');
					$("#vmsg").html(_json.pname+'兑换成功！');
					$("#resmsg").html('你兑换的礼品已保存在我的积分兑换明细中，<a href="<?= geturl('home/score/record')?>" target="_blank" style="font-weight:bold; color:#000;">点击查看</a>');
					$("#virtualmessage").show();
				}
			}
		});
	});
});
function updateData(sellqty,stockqty){
	$("#sellqty").html(sellqty);
	$("#stockqty").html(stockqty);
}
</script>
<?php $this->display('common/footer')?>