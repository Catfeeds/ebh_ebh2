<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>兑换礼品</title>
</head>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js"></script>

<style>
.gift_list{ border-left:none; border-right:none; border-top:none;}
.gift_son{border-left:none; border-right:none; border-bottom:none;}
</style>

<body>
	<div class="lefrig"style="margin-top:15px; background:#fff;">
		<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
			<ul>
				 <li class="workcurrent"><a href="<?=geturl('home/score/lottery/exchange')?>" style="font-size:16px;line-height: 33px;border:none;"><span>兑换礼品</span></a></li>
				 <li><a href="<?=geturl('home/score/lottery/exchange_des')?>" style="font-size:16px;"><span>兑换说明</span></a></li>
			</ul>
		</div>
		<?php $i=0;
		foreach ($productList as $productkey => $product) {?>
        <div class="clear"></div>
        <div class="gift_son" <?=$i==0?'style="border-top:none"':''?>>
        	<div class="gift_son1 first">
            	<div class="gift_son1_l fl">
                <img src="<?=$product['image']?>" />
                </div>
                <div class="gift_son1_r fr" style="text-align:center;">
                	<h3 class="mt15"><?=$product['productname']?></h3>
                    <p style="height: 22px;line-height:22px;"><span class='span1'><?=$product['credit']?>积分</span> |  原价：<?=$product['marketprice']?>元</p>
                    <p class="p1"><?=shortstr($product['summary'],280)?></p>
					<div class="duihuan fr">
					<?php if($product['stockqty']>0){ ?>
						<?php if($user['credit'] < $product['credit']){ ?>
					  	<a href="javascript:void(0);" onclick="alert('很抱歉，您当前的积分不足,兑换(<?= $product['productname']?>)需要<?= $product['credit']?>积分!');" class="sethuan">兑 换</a>
						<?php }else{ ?>
					  	<a href="javascript:void(0);" marketprice="<?=$product['marketprice']?>" credit="<?=$product['credit']?>" productname="<?=$product['productname']?>" onclick="exchange(<?= $product['productid']?>,<?= $product['type']?>);" class="exchangebtn<?=$product['productid']?>">兑 换</a>
						<?php } ?>
					<?php }else{ ?>
						<a href="javascript:void(0);" onclick="alert('库存不足！')" class="sethuan">兑 换</a>
					<?php } ?>
					</div>
                </div>
            </div>
            
        </div>
		<?php ++$i;}?>
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
					<p class="xinxi" style="width:350px;height:auto;line-height:24px;margin-bottom:8px;">您确定要兑换<label class="labelproductname"></label>？</p>
					<table width="375" border="0" cellpadding="0" style="color:#5e5e5e;">
					  <tr>
					    <td width="125" align="right" valign="top">产品名称：</td>
					    <td width="250" align="left"><label class="labelproductname"></label></td>
					  </tr>
					  <tr>
					    <td width="125" align="right">平　　台：</td>
					   
					    <td width="150" align="left"><label class="labelcrname"></label></td>
					  </tr>
					  <tr>
					    <td width="125" align="right">原　　价：</td>
					    <td width="150" align="left"><label class="labelmarketprice"></label></td>
					  </tr>
					  <tr>
					    <td width="125" align="right">积　　分：</td>
					    <td width="150" align="left"><label class="labelcredit"></label></td>
					  </tr>
					</table>
					<input class="queren" type="submit" style="margin-top:10px;margin-left: 77px;" id="conversion" name="Submit" value="确认兑换" />
					<input class="quxiao" type="submit" style="margin-top:10px;" name="Submit2" onclick="H.get('score').exec('close');" value="取消兑换" />
				</div>
				
				<div id="message" style="display:none;">
					<div class="fenx">
                         <div class="js_share" align="right">
                        </div>
						<p id="mmsg" ></p>
						<p class="jiming" id="res" style="float:left;"></p>
						<input style="float:left;margin-top:10px;" class="queren" type="submit" name="Submit" onclick="H.get('score').exec('close');" value="确认" />
					</div>
				</div>
				
				<div id="virtualmessage" style="display:none;">
					<div class="fenx">
                         <div class="js_share" align="right">
						    </div>
                        </div>
						<p id="vmsg"></p>
						<p class="jiming" id="resmsg" style="float:left;"></p>
						<input style="float:left; margin-left:115px;" class="queren" type="submit" name="Submit" onclick="H.get('score').exec('close');" value="确认" />
					</div>
				</div>
				
		</div>
		
	<script>
	var pid;
function exchange(id,type)
{
	pid=id;
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
		$('.labelproductname').html($('.exchangebtn'+id).attr('productname'));
		$('.labelmarketprice').html($('.exchangebtn'+id).attr('marketprice'));
		$('.labelcredit').html($('.exchangebtn'+id).attr('credit'));
		H.get('score').exec('show');
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
		$("#virtualmessage").hide();
		$("#confirm").hide();
		$('#virtual').hide();
		H.get('score').exec('show');
		$('#receiving').show();
		$('#oid').val(id);
		var ieset = navigator.userAgent;
	}
}


$(function(){
	H.create(new P({
		id:'score',
		title:'提示',
		width:450,
		height:263,
		easy:true,
		padding:5,
		content:$("#score")[0]
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
		$(".zilan").html($('.exchangebtn'+pid).attr('credit'));
		$(".zideng").html($('.exchangebtn'+pid).attr('marketprice'));
		$("#pname").html($('.exchangebtn'+pid).attr('productname'));
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
			data:{'pid':pid,'name':name,'phone':phone,'address':address,'postcode':postcode},
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
			data:{'pid':pid},
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
</body>
</html>
