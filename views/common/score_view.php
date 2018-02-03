<?php
$this->display('common/header');
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<script src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

<?php $product = $productvalue; ?>
<div class="main">
<div class="detlef">
<h2 class="titxiang" style="font-weight: bold;">积分兑换注意事项</h2>
<ul>
<li class="detico1">
<p>表示按商品原价基础上打折
后的价格进行积分兑换</p>
</li>
<li class="detico2">
<p>表示积分限时限量退出的特
价商品</p>
</li>
<li class="detico3">
<p>表示此物品为专柜正品，质量保证</p>
</li>
</ul>
</div>
<div class="detrig">
<h2 class="titxiang">
积分兑换 > 详情 > <a href="#" style="color:#ff4e00;"><?= $product['productname']?></a>
</h2>
<div class="xqtu">
  <img width="219px;" height="120px;" src="<?= getThumb($product['image'],'220_120','http://static.ebanhui.com/ebh/tpl/default/images/nopic.gif')?>"  />
</div>
  <div class="rigxq">
  <h1><?= $product['productname']?></h1>
  <p>原价：<span style="text-decoration: line-through;">￥<?= $product['marketprice']?></span></p>
  <p><span style="float:left;margin-top:12px;">积分：</span><span class="jfsize"><?= $product['credit']?></span>积分</p>

  
	  <?php if(empty($user)){ ?>
	  	  <a href="javascript:;"  id="duihuan" class="yuebtn"></a>
	  <?php }else{ ?>
	  	 <?php if($product['stockqty']>0){ ?>
			  <?php if($user['credit'] < $product['credit']){ ?>
			  	<a href="javascript:;" onclick="alert('积分不足,兑换(<?= $product['productname']?>)需要<?= $product['credit']?>积分!');" class="yuebtn"></a>
			  <?php }else{ ?>
			  	<a href="javascript:;" onclick="exchange(<?= $product['productid']?>,<?= $product['type']?>);" class="yuebtn"></a>
			  <?php } ?>
		 <?php }else{ ?>
		  	  <a href="javascript:;" onclick="alert('库存不足！')" class="yuebtn"></a>
		 <?php } ?>
	  <?php } ?>

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
					<p class="xinxi">您确定要用<span class="zilan"></span>积分兑换原价<span class="zideng"></span>的<span id="pname"></span>？</p>
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
					<input class="quxiao" type="submit" style="margin-top:10px;" name="Submit2" onclick="$('#score').dialog('close');" value="取消兑换" />
					
				</div>
				
				<div class="tswin" id="virtual" style="display: none;width:310px;font-size:14px;">
					<p class="xinxi" style="width:350px;">您确定要兑换<?= $product['productname']?>？</p>
					<table width="375" border="0" cellpadding="0" style="color:#5e5e5e;">
					  <tr>
					    <td width="125" align="right" valign="top">产品名称：</td>
					    <td width="250" align="left"><label><?= $product['productname']?></label></td>
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
					<input class="quxiao" type="submit" style="margin-top:10px;" name="Submit2" onclick="$('#score').dialog('close');" value="取消兑换" />
					
				</div>
				
				<div id="message" style="display:none;">
					<div class="fenx">
                         <div class="js_share" align="right"><!-- Baidu Button BEGIN -->
						    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="margin-left:25px;">
						        <span class="bds_more">分享到：</span>
						        <a class="bds_qzone"></a>
						        <a class="bds_tsina"></a>
						        <a class="bds_tqq"></a>
						        <a class="bds_renren"></a>
								<a class="shareCount"></a>
						    </div>
                        </div>
						<p id="mmsg" ></p>
						<p class="jiming" id="res" style="float:left;"></p>
						<input style="float:left;margin-top:10px;" class="queren" type="submit" name="Submit" onclick="$('#score').dialog('close');" value="确认" />
					</div>
				</div>
				
				<div id="virtualmessage" style="display:none;">
					<div class="fenx">
                         <div class="js_share" align="right"><!-- Baidu Button BEGIN -->
						    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="margin-left:25px;">
						        <span class="bds_more">分享到：</span>
						        <a class="bds_qzone"></a>
						        <a class="bds_tsina"></a>
						        <a class="bds_tqq"></a>
						        <a class="bds_renren"></a>
								<a class="shareCount"></a>
						    </div>
                        </div>
						<p id="vmsg"></p>
						<p class="jiming" id="resmsg" style="float:left;"></p>
						<input style="float:left; margin-left:115px;" class="queren" type="submit" name="Submit" onclick="$('#score').dialog('close');" value="确认" />
					</div>
				</div>
				
		</div>
<script type="text/javascript" id="bdshare_js" data="type=tools" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();
</script>
  <div class="detming">
  <span style="margin-right:30px;">已经兑换：<span class="sizcolo"><?= $product['sellqty']?></span>件</span> 库存：<span class="sizcolo"><?= $product['stockqty']?></span>件
<p style="margin-top:5px;">服务：<span class="sizcolo">免费包邮</span></p>
  </div>
  </div>
  <div class="shuom">
  <ul style="height:33px; border-bottom:solid 1px #cdcdcd;">
  <li class="xuanz">
  <a href="#">礼品介绍</a>
  </li>

  </ul>
  <div class="xiaxiang">
 <?php if($product['type']==0){?>
<p>商品全称：<?= $product['productname']?></p>
<p>商品产地：杭州</p>
<p>商品毛重：<?= $product['weight']?></p>
<p>1.品牌：<?= $product['brand']?></p>
<p>类型：<?= $product['type']==0?'实物产品':'虚拟产品'?></p>
<p>型号：<?= $product['productno']?></p>
<p>2.规格：<?= $product['specification']?></p>
<p>3.特性：<?= $product['special']?></p>
<?php } ?>
<p><?= $product['message']?></p>
  </div>
  </div>
</div>
<div class="detlef" style="margin-top:10px;">
<h2 class="titxiang" style="font-weight: bold;">常见问题</h2>
<ul>
<li class="detico4">
<p><a class="colo" href="http://www.ebanhui.com/help/1396.html">e板会积分兑换操作步骤介
绍</a></p>
</li>
<li class="detico5">
<p><a class="colo" href="http://www.ebanhui.com/help/1397.html">e板会积分实物礼品配送方
式及到货周期</a></p>
</li>
<li class="detico6">
<p><a class="colo" href="http://www.ebanhui.com/help/1398.html">e板会积分兑换实物后，可
以退换货么？</a></p>
</li>
</ul>
</div>
</div>

<div style="clear:both;"></div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.dialog.js"></script>
<script type="text/javascript">
$("#duihuan").click(function(){
	$.loginDialog($(this).attr("name"));
});
function exchange(id,type)
{
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
		$('#score').dialog("open");
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
		
		$('#score').dialog("open");
		$('#receiving').show();
		$('#oid').val(id);
		var ieset = navigator.userAgent;
	}
}


$(function(){
//	buttons = {"取消": function() { $(this).dialog("close");   },"确定": function() {if(submit_check(document.getElementById('upform'))) document.getElementById('upform').submit();}};
	$('#score').dialog({
		autoOpen: false,
//		buttons:buttons,
		title:'提示',
		width: 440,
		height: 213,
		resizable:false,
		type:'post',
		modal: true//模式对话框
	});
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
					$("#confirm").hide();
					$("#mmsg").addClass('cuo');
					$("#mmsg").html(_json.pname+'兑换失败！');
					$("#message").show();
				}else{
					$("#confirm").hide();
					$("#mmsg").addClass('zhengque');
					$("#mmsg").html(_json.pname+'兑换成功！');
					$("#res").html('你兑换的礼品已保存在我的积分兑换明细中，<a href="<?= geturl('member/score/record')?>" target="_blank" style="font-weight:bold; color:#000;">点击查看</a>');
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
					$("#virtual").hide();
					$("#vmsg").addClass('cuo');
					$("#vmsg").html(_json.pname+'兑换失败！');
					$("#resmsg").html('你兑换礼品失败，请稍后再试。');
					$("#virtualmessage").show();
				}else{
					$("#virtual").hide();
					$("#vmsg").addClass('zhengque');
					$("#vmsg").html(_json.pname+'兑换成功！');
					$("#resmsg").html('你兑换的礼品已保存在我的积分兑换明细中，<a href="<?= geturl('member/score/record')?>" target="_blank" style="font-weight:bold; color:#000;">点击查看</a>');
					$("#virtualmessage").show();
				}
			}
		});
	});
});
</script>
<?php
	$this->display('common/player');
    $this->display('common/footer');
?>