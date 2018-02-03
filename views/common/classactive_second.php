<?php $this->display('common/site_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/cloudlist.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/open.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/minded.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/joinlc.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/cloud.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<style>
.main .slst .fmiat .fash LI{
	margin-right:20px;
}
</style>
<script type="text/javascript">
$(function(){
	$("#yearcard").click(function(){
		$("#cardnumberdiv").show();
		$("#cardpassdiv").show();
		$("#kuaiqiandiv").hide();
		
	});
	$("#kuaiqian").click(function(){
		$("#cardnumberdiv").hide();
		$("#cardpassdiv").hide();
		$("#kuaiqiandiv").show();
		
	});
	$("#alipay").click(function(){
		$("#cardnumberdiv").hide();
		$("#cardpassdiv").hide();
		$("#kuaiqiandiv").show();
		
	});
	$("#abcpay").click(function(){
		$("#cardnumberdiv").hide();
		$("#cardpassdiv").hide();
		$("#kuaiqiandiv").show();
		
	});
	$("#abcallpay").click(function(){
		$("#cardnumberdiv").hide();
		$("#cardpassdiv").hide();
		$("#kuaiqiandiv").show();
		
	});
	$(".rdtime").click(function(){
		$("#lastdate").text("服务时长从即日起至"+CurentTime($(this).val())+"为止。");
	});
	if($("#yearcard").attr("checked")==false){
		$("#cardnumberdiv").hide();
		$("#cardpassdiv").hide();
		$("#kuaiqiandiv").show();
	}else{
		$("#cardnumberdiv").show();
		$("#cardpassdiv").show();
		$("#kuaiqiandiv").hide();
	}

	
	$("#activeBtn").click(function(){
		if($("#agreement").attr("checked") !=true) {
			alert("请先阅读并同意《e板会用户支付协议》。");
			return;
		}
		if($("#yearcard").attr("checked")==true){//年卡充值

			if($.trim($("#cardnumber").val()).length==0){
				$("#cardtip").html("请输入年卡卡号。");
				$("#cardtip").show();
				$("#cardnumber").focus();
			}
			else if($.trim($("#cardpass").val()).length==0){
				$("#passtip").html("请输入年卡密码。");
				$("#passtip").show();
				$("#cardpass").focus();
			}else{
				$.ajax({
					type:"POST",
					url:'<?= geturl('classactive/cardactive') ?>',
					data:{'cardnumber':$.trim($("#cardnumber").val()),'cardpass':$.trim($("#cardpass").val())},
					dataType:'text',
					success:function(data){
						if(data=='success'){
							window.location.href='<?= geturl('classactive/success') ?>';
						}else{
							alert(data);
						}
					}
				});

			}
			
		}
		else if($("#alipay").attr("checked")==true){
			var month=0;
			var chargevalue=0;
			var val=$('input:radio[name="time"]:checked').val();
	            if(val==null||val==''){
	                alert("对不起,请先选择开通时长。");
	                return false;
	            }else{
	            	month=val;
	            	chargevalue=$('input:radio[name="time"]:checked').attr("chargevalue");
	            	if(confirm("您的账号为：<?= $user['username'] ?>\n"+"您的充值金额为："+chargevalue)){
						$("#payform").empty();
						$("#payform").append('<form id="kqPay" target="_blank" name="kqPay" method="post" action="/classactive/alipay.html"></form>');
						$("#kqPay").append('<input type="hidden" name="total_fee" value='+chargevalue+' />');
						$("#kqPay").append('<input type="hidden" name="month" value='+month+' />');
						$("#kqPay").submit();
						$("#yearcard").attr("disabled","false");
						$("#kuaiqian").attr("disabled","false");
						$("#alipay").attr("disabled","false");
						$(".rdtime").each(function(){
							$(this).attr("disabled","false");
    					});
						$("#kuaiqianmsg").show();
						$("#payBtnLabel").hide();
					}
					

			    }
		}else if($("#abcpay").attr("checked")==true || $("#abcallpay").attr("checked")==true){
			var month=0;
			var chargevalue=0;
			var val=$('input:radio[name="time"]:checked').val();
	            if(val==null||val==''){
	                alert("对不起,请先选择开通时长。");
	                return false;
	            }else{
	            	month=val;
	            	chargevalue=$('input:radio[name="time"]:checked').attr("chargevalue");
					var payurl = "/classactive/abcpay.html";
					if($("#abcallpay").attr("checked")==true)
						payurl = "/classactive/abcallpay.html";

	            	if(confirm("您的账号为：<?= $user['username'] ?>\n"+"您的充值金额为："+chargevalue)){
						$("#payform").empty();
						$("#payform").append('<form id="kqPay" target="_blank" name="kqPay" method="post" action="'+payurl+'"></form>');
						$("#kqPay").append('<input type="hidden" name="total_fee" value='+chargevalue+' />');
						$("#kqPay").append('<input type="hidden" name="month" value='+month+' />');
						$("#kqPay").submit();
						$("#yearcard").attr("disabled","false");
						$("#kuaiqian").attr("disabled","false");
						$("#alipay").attr("disabled","false");
						$(".rdtime").each(function(){
							$(this).attr("disabled","false");
    					});
						$("#kuaiqianmsg").show();
						$("#payBtnLabel").hide();
					}
					

			    }
		}
		else{
			//快钱充值
			var month=0;
			var chargevalue=0;
			var val=$('input:radio[name="time"]:checked').val();
	            if(val==null||val==''){
	                alert("对不起,请先选择开通时长。");
	                return false;
	            }else{
	            	month=val;
	            	chargevalue=$('input:radio[name="time"]:checked').attr("chargevalue");
					if(confirm("您的账号为：<?= $user['username'] ?>\n"+"您的充值金额为："+chargevalue)){
						$("#payform").empty();
						$("#payform").append('<form id="kqPay" target="_blank" name="kqPay" method="post" action="/classactive/kuaiqian.html"></form>');
						$("#kqPay").append('<input type="hidden" name="total_fee" value='+chargevalue+' />');
						$("#kqPay").append('<input type="hidden" name="month" value='+month+' />');
						$("#kqPay").submit();
						
						$("#yearcard").attr("disabled","false");
	    							$("#kuaiqian").attr("disabled","false");
	    							$("#alipay").attr("disabled","false");
	    							$(".rdtime").each(function(){
	    								$(this).attr("disabled","false");
			    					});
	    							$("#kuaiqianmsg").show();
	    							$("#payBtnLabel").hide();
					}

		        }
	        }
		
	});
		
});
function emptychange(objid,tipid,msg){
	var obj=$.trim($("#"+objid).val());
	if(obj.length==0){
		$("#"+tipid).html(msg);
		$("#"+tipid).show()
	}else{
		$("#"+tipid).hide()
	}
}
function CurentTime(addtime)
{ 
    var now =new Date((new Date().getFullYear()), new Date().getMonth()+parseInt(addtime), new Date().getDate(), new Date().getHours(), new Date().getMinutes(), new Date().getSeconds());
    var year = now.getFullYear();       //年
    var month = now.getMonth() + 1;     //月
    var day = now.getDate();            //日
    var clock = year + "-";
    if(month < 10)
        clock += "0";
   
    clock += month + "-";
   
    if(day < 10)
        clock += "0";
       
    clock += day + " ";
    return(clock); 
} 
</script>
<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg) repeat-y scroll 0 0; height:auto;">
<div class="main" style="height:580px;">
<div class="aed"><p>欢迎开通【<?= $roominfo['crname'] ?>】服务</p></div>
  <div class="slst"><p style="	font-weight: bold;padding-top: 15px;padding-left: 35px; color:#666666">帐号开通流程： </p>
    <label>
    <input class="tianxie1" style="cursor:pointer" type="submit" name="tianxie" value="1、填写个人资料" />
    <img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />    </label>
    <label>
    <input class="xuanze1" style="cursor:pointer" type="submit" name="xuanze" value="2、选择开通方式" />
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />
    </label>
    <label>
    <input class="kaitong" style="cursor:pointer" type="submit" name="kaitong" value="3、开通成功" />
    </label>
	<div class="fmiat">
   <div class="feld">
 <label>
 e板会帐号：
 <input name="username" id="username" type="text" class="username" readonly="readonly" value="<?= $user['username'] ?>"  style="color:#999999;padding:0px;font-size: 16px;font-weight: bold; padding-left:5px;" />
 </label>
 </div>
 <p style="padding-left: 65px;">请选择您的开通方式：</p>

<div class="fash">
 <ul>
 <li class="alipay">
   <input id="alipay" name="payway" type="radio" value="radiobutton" checked="checked"/><label for="alipay">
   支付宝</label>
 </li>
 <li class="abc">
   <input id="abcpay" name="payway" type="radio" value="radiobutton" /><label for="abcpay">
   农行直通车</label></li>
 <li class="money">
   <input id="abcallpay" name="payway" type="radio" value="radiobutton" /><label for="abcallpay">
   银联</label></li>
 <li class="card">
   <input id="yearcard" name="payway" type="radio" value="radiobutton" /><label for="yearcard">
   年卡</label>
   </li>
 <li style="margin-right:0px">
   <a href="/classactive/bank.html" target="_blank" style="color:red">银行转账</a>
   </li>
 </ul>
 </div>


 <!-- 申请加入教室 -->
<div id="join2" name="join2" style="display:none " >
<div class="classconfirm" id="joinform2" >
	<form action="" method="post" id="sform2" name="sform2" onsubmit="return checkform('rname','mobile','email')">
		<input type="hidden" id="crid2" name="crid" value="<?= $roominfo['crid'] ?>" />
    	<input type="hidden" id="teacherid2" name="teacherid" />
			<div class="joinlc">
				<p class="tit_cue">请填写您真实的和人信息，带*号的内容必须填写。</p>
				<ul>
				
				<li class="current fifx">
				<span>*</span><em>姓&nbsp;名：</em>
				<input type="text" class="txt_box" name="rname2" maxlength="25"  id="rname2" onblur="" value="" />
				<span id="rnamemsg"></span></li>
				
				<li class="current fify">
				<span>*</span><em>邮&nbsp;箱：</em>
				<input type="text" class="txt_box" name="email2" maxlength="60"  id="email2" onblur="" value=""  />
				<span id="emailmsg"></span></li>
				<li class="current fifz">
				<span></span><em class="em2">手&nbsp;机：</em>
				<input type="text" class="txt_box" name="mobile" maxlength="11" onblur=""  id="mobile2" value=""/>
				<span id="mobilemsg"></span>
				</li>
				
				<li class="current fifc">
				<span></span><em class="em2">Q&nbsp;&nbsp;&nbsp;Q：</em>
				<input type="text" class="txt_box" name="qq" id="qq2" maxlength="15"  value=""/>
				</li>
				
				<li class="currs fifa">
				<span style=""></span><em style="margin-left: 35px;*margin-left: 27px;_margin-left:25px;_margin-right:3px;font-size: 14px;">留&nbsp;言：</em>
				<textarea id="remarks2" name="remarks" class="txt_duobox"></textarea>
				</li>
				</ul>
				<p class="sadew">
				  <input id="sendbtn2" type="button" class="operate" name="Submit" value="确&nbsp;&nbsp;认" />
				  <input type="button" name="Submit2" class="cancer" onclick="$('#join2').dialog('close');" value="取&nbsp;&nbsp;消" />
				</p>
			</div>
			
	
		
	</form>
</div>
	<div id="joinmessage2" style="display:none;align:center;" >
    </div>
</div>

<?php
$sylist = array(10437,10439,10441,10442,10443,10465,10511,10464,10465,10466,10512,10513);
?>
 <div id="cardnumberdiv" class="fal">
 <label>
 年卡卡号：
 <input class="kauser"  onchange="emptychange('cardnumber','cardtip','请输入年卡卡号。');" type="text" id="cardnumber" name="cardnumber" />
 </label>
 <span id="cardtip" style="color:#ff0000;display:none;"></span>
 </div>
  <div  id="cardpassdiv" class="fal">
 <label>
年卡密码：
 <input class="kapwd" type="password"  onchange="emptychange('cardpass','passtip','请输入年卡密码。');" id="cardpass" name="cardpass" />
 </label>
  <span id="passtip" style="color:#ff0000;;display:none;"></span>
 </div>
 <div id="kuaiqiandiv" style="display:none;" class="fele">
  <label>开通服务时长：</label>

   <label>
   <?php if(in_array($roominfo['crid'],$sylist)) { ?>
   <input name="time" class="rdtime" type="radio" value="3" chargevalue="<?= $roominfo['crprice']/4 ?>" checked="checked"/> 
   3个月（<span style="color:#FF0000"><?= $roominfo['crprice']/4 ?></span>元）<span style="text-decoration: line-through;">原价<?=$roominfo['crprice']/2?>元</span> 
   <?php } else { ?>
   <input name="time" class="rdtime" type="radio" value="12" chargevalue="<?= $roominfo['crprice'] ?>"  checked="checked"/> 
   12个月（<span style="color:#FF0000"><?= $roominfo['crprice'] ?></span>元）<span style="text-decoration: line-through;">原价<?=$roominfo['crprice']*2?>元</span> 
   <?php } ?>
      </label>

   <label id="lastdate"></label>
 </div>
 <div id="kuaiqianmsg" style="display:none;">
 <img src="http://static.ebanhui.com/ebh/tpl/2012/images/xiantiao.gif" />
 <p style="padding-left:90px; padding-top:5px;"> 尊敬的客户：</p>
 <p>您的开通请求已经提交,请您继续在快钱网站上完成相关操作步骤。</p>
 <p>支付成功后，您可以用账号<span style="color:#075d80;">&nbsp;<?= $user['username'] ?>&nbsp;</span>登录到<?= $roominfo['crname'] ?>。&nbsp;<a style="color:#A11714;" href="<?= 'http://'.$_SERVER['HTTP_HOST'] ?>">[立即登录]</a></p>
 <p style="color:#a11512;">若支付网页没有自动弹出，请点击<a style="color:#0c630e;" href="javascript:void(0);" onclick="$('#activeBtn').click()">这里</a>进入网银，继续完成网上支付。谢谢！</p>
 </div>
 <div class="czxy" style="padding-left:66px;padding-top:10px;">
	<input name="agreement" id="agreement" type="checkbox" value="1" checked="checked" />
	<label for="agreement" style="font-weight:bold;">我已阅读并同意《<a href="<?= geturl('agreement/payment') ?>" target="_blank" style="color:#00AEE7;">e板会用户支付协议</a>》
	</label>
 </div>
 <label id="payBtnLabel">
 <input id="activeBtn" style="cursor:pointer; margin-top:20px;" class="anniu" type="button" name="button" value="确认开通" />
 </label>
	</div>
   <label>
  <input style="cursor:pointer" type="submit" name="step" class="step" onclick="history.go(-1);" value="上一步" />
  </label>
	</div>
	<div style="display:none" id="payform"></div>
 <?php $this->display('common/site_right'); ?>
  </div>
  <div class="footlintbg">
<img width="970" height="16" src="http://static.ebanhui.com/ebh/tpl/2012/images/doot5111.jpg">
</div>
</div>

<script type="text/javascript">


$(function(){
	var buttons = {};
	$("#join2").dialog({
		autoOpen: false,
		resizable:false,
		title:"申请加入教室",
		buttons:buttons,
		width: 550,
		height:470,
		modal: true,
		open:function(){
			$('#remarks2').val('');
		},
		beforeclose:function(){
			$( "#join2" ).dialog( "option", "buttons",buttons);
			$("#joinform2").css('display','block');
			$("#joinmessage2").css('display','none');
		}
		});
		$("#sendbtn2").click(function(){
			if(checkform2('rname','mobile','email')){
				
				var crid = $("#crid2").val();
				var rname = $("#rname2").val();
				var mobile = $("#mobile2").val();
				var email = $("#email2").val();
				var qq = $("#qq2").val();
				var teacherid = '';
				var remarks = $("#remarks2").val();

				$("#joinmessage2").html("正在发送请求");
				$("#joinform2").hide();
				$("#joinmessage2").show();
				$.ajax({
					url:"#getsitecpurl()#?action=member",
					type:'post',
					data:{'crid':crid,'rname':rname,'mobile':mobile,'email':email,'teacherid':teacherid,'qq':qq,'remarks':remarks,'op':'application','inajax':1},
					dataType:'text',
					success:function(msgs){
						if(msgs!=''){
							//$("#join").dialog("close");
							//$("#dialogmsg").dialog('open');

							$("#joinmessage2").html('<div style=" width:74px; height:62px; float:left; display:inline; margin-top:100px; margin-left:70px;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/access_bg.png" width="74" height="62" /></div><div style=" width:305px; float:left; display:inline; margin-top:100px; margin-left:10px;"><b style="font-size:14px;">'+msgs+'</b><p>3秒关闭</p><div class="skip"><a style="cursor:pointer;" onclick="javascript:$(\'#join2\').dialog(\'close\');">立即关闭。</a></div></div>');
							buttons = $( "#join2" ).dialog( "option", "buttons" );
							//$("#dialogmsg").html('<span style="color:red">'+msg+'</span>');
							$( "#join2" ).dialog( "option", "buttons", [    ]);
							$("#op"+$("#join2").data('crid')+"2").html('<input type="button" name="button" class="yisq" value="" />');
							setTimeout(function(){$("#join2").dialog('close')},3000);
						
						}
					}
				})
			}
		});
	
	});

//	var showdialog2 = function(crid,crname){
//		$("#crid2").val(crid);
//		$("#join2").dialog('option','title',"申请加入"+crname);
//		$("#join2").data('crid',crid);
//		$("#join2").dialog('open');
//	}

	function checkrname2(rname){
		if(rname ==""){
			$("#rnamemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png" />');
			return false;
		}
		$("#rnamemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" />');
		return true;
		
	}
function checkmobile2(mobile){
	if(mobile!=''){
		var ab = /^(1[3-9]{1}[0-9]{9})$/;
		if(!ab.test(mobile)){
			$("#mobilemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png" />');
			return false;
		}	
		$("#mobilemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" />');	
	}
	return true;
}
function checkemail2(email){
	if(email == ""){
		$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png" />');
		return false;
	}else{
		var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(!emailreg.test(email)){
			$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/error.png" />');
			return false;
		}
	}
	$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2012/images/righttip.png" />');
	return true;
}

function checkform2(rname,mobile,email){
	var rname = $("#"+rname+"2").val();
	var email = $("#"+email+"2").val();
	if(checkrname2(rname)!=true||checkemail2(email)!=true){
		return false;
	}
	return true;
}
</script>
  <div style="clear:both;"></div>
<?php $this->display('common/site_footer'); ?>