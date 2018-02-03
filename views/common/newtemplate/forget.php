<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>安全中心</title>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newreg/css/reg.css">
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	</head>
	<style>
	.mobile_msg,.verify_msg,.code_msg,.email_msg,.pwdti{
		display:none
	}
	</style>
	<body>
		<div class="backs">
			<div class="register">
				<div class="tongtit">安全中心</div>
				<div class="mss">
					<div class="repic">
						<a href="javascript:;" class="emaillock cur" findtype="email">邮箱</a>
						<a href="javascript:;" class="cellock" findtype="mobile">手机</a>
					</div>
					<div class="clear"></div>
					<div class="mt45">
						<div class="showno diffblocks email" >
							<div class="isterdiv">
								<p class="showinfo_email pwdti"></p>
								<span class="isterspan">邮箱号码</span>
								<input class="istertxts" id="email" needcheck="1" title="请输入您的注册邮箱" placeholder="请输入您的注册邮箱" value="" name="email" type="text">
								<p id="" class="email_msg zhengtic"></p>
								<p id="" class="email_msg cuotic cuotic0">请输入邮箱</p>
								<p id="" class="email_msg cuotic cuotic1">请填写有效的E-mail地址</p>
								<p id="" class="email_msg cuotic cuotic2">该邮箱尚未绑定,请更换后再试</p>
							</div>
							<div class="isterdiv mt40">
								<span class="isterspan">验&nbsp;&nbsp;证&nbsp;&nbsp;码</span>
								<input class="yantess istertxts" id="code" needcheck="1" title="请输入验证码"  placeholder="请输入验证码" value="" name="emailcode" type="text">
								<a class="yaned" href="javascript:void(0)" onclick="updatesecode()">
									<img id="img_seccode" style="width:90px;height:40px;" src="/verify/getcode.html">
									<span class="landstma">换一张</span>
								</a>
								<p id="" class="code_msg zhengtic"></p>
								<p id="" class="code_msg cuotic cuotic0">请输入验证码</p>
								<p id="" class="code_msg cuotic cuotic1">验证码不正确</p>
							</div>
							<div class="clear"></div>					
							<div class="mt45">
								<input class="logbtn" id="searchpwd" value="找回密码" type="button" onclick="sendmail()">
								<input class="logbtn" style="display:none" id="loginemail" value="进入邮箱" type="button" onclick="tomail()">
							</div>
						</div>
						<div class="showno diffblocks mobile" style="display: none;">
							<div class="isterdiv">
								<p class="showinfo_mobile pwdti"></p>
								<span class="isterspan">手机号码</span>
								<input class="istertxts" id="mobile" needcheck="1" title="请输入您的手机号" placeholder="请输入您的手机号" value="" name="mobile" type="text">
								<p id="" class="mobile_msg zhengtic"></p>
								<p id="" class="mobile_msg cuotic cuotic0">请输入手机号</p>
								<p id="" class="mobile_msg cuotic cuotic1">请输入有效的手机号</p>
								<p id="" class="mobile_msg cuotic cuotic2">该手机号尚未绑定,请更换后再试</p>
							</div>
							<div class="isterdiv mt40">
								<span class="isterspan">验&nbsp;&nbsp;证&nbsp;&nbsp;码</span>
								<input class="yantess istertxts" id="verify" needcheck="1" title="请输入验证码"  placeholder="请输入验证码" value="" name="emailcode" type="text">
								<a id="getcode" class="sendyzms ml35" href="javascript:;" onclick="getcode()">点击发送</a>
								<p id="" class="verify_msg zhengtic"></p>
								<p id="" class="verify_msg cuotic cuotic0">请输入验证码</p>
								<p id="" class="verify_msg cuotic cuotic1">请输入6位验证码</p>
								<p id="" class="verify_msg cuotic cuotic2">请先点击发送</p>
							</div>
							<div class="clear"></div>					
							<div class="mt45">
								<input class="logbtn" value="找回密码" onclick="dofind()" type="button">
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->display('common/newtemplate/animation');?>
		</div>
	</body>
<script type="text/javascript">

<?php if(!empty($mobile)){?>
$(function(){
	$('.repic a[findtype=mobile]').click();
})
<?php }?>
$(".repic a").click(function(){
	$('.cur').removeClass('cur');
	var findtype = $(this).attr('findtype');
	$('.diffblocks').hide();
	$('.diffblocks.'+findtype).show();
	$(this).addClass('cur');
});
		
function updatesecode(){
	$("#img_seccode").attr('src',"/verify/getcode.html"+'?'+Math.random());
}
$('input[needcheck=1]').blur(function(){
	eval('check'+$(this).attr('id')+'()');
})
function checkemail(){
	var email = $('#email').val();
	if(email==''){
		$('.email_msg').hide();
		$('.email_msg.cuotic0').css('display','inline');
		return false;
	}else{
		var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(!emailreg.test(email)){
			$('.email_msg').hide();
			$('.email_msg.cuotic1').css('display','inline');
			return false;
		}else{
			var ret = false;
			$.ajax({
				type:"POST",
				url:'<?=geturl('forget/checkemail')?>',
			    data: { 'email': email },
			    async:false,
                success: function (data) {
                    if (data != 1) {
                    	$('.email_msg').hide();
						$('.email_msg.cuotic2').css('display','inline');
						ret = false;
					}else{
						$('.email_msg').hide();
						$('.email_msg.zhengtic').css('display','inline');
						ret = true;						
					}
				}
			});
			return ret;
		}
	}
}

function checkcode(){
	
	var code = $('#code').val();
	if(code==''){
		$('.code_msg').hide();
		$('.code_msg.cuotic0').css('display','inline');
		return false;
	}
	var ret = false;
	$.ajax({
		url:"<?=geturl('verify/checkcode')?>",
		data:{'code':code},
		async:false,
		success:function(data){
			if(data=='1' || data==true){
				$('.code_msg').hide();
				$('.code_msg.zhengtic').css('display','inline');
				ret = true;
			}
			else{
				$('.code_msg').hide();
				$('.code_msg.cuotic1').css('display','inline');
				ret = false;
			}
		}
	});
	return ret;
}
function getdata(){
	var formdata = $('input[needcheck=1]:visible');
	var data = {};
	$.each(formdata,function(k,v){
		if($.trim($(v).val()) == $(v).attr('placeholder')){
			data[$(v).attr('name')] = "";
		}else{
			data[$(v).attr('name')] = $.trim($(v).val());
		}
	});
	data['forget'] = 1;
	data['ajax'] = 1;
	return data;
}
var flag = 0;
function sendmail(){
	if(flag == 1){
		return;
	}
	var email = checkemail();
	var code = checkcode();
	if(!(email && code)){
		return ;
	}
	flag = 1;
	$(".showinfo_email").text("邮件发送中，请稍等...");
	$(".showinfo_email").show();
	$.ajax({
		url:"<?=geturl('forget')?>",
		type:'post',
		data:getdata(),
		dataType:'json',
		success:function(data){
			if(data.status == 0){
				$('#searchpwd').hide();
				$("#loginemail").show();
				$("#loginemail").attr("href","http://"+gotoEmail(getdata().email));
				$(".showinfo_email").text("密码将发送到您的邮箱，请注意查收！");
			}else{
				$(".showinfo_email").text(data.msg);
			}
			flag = 0;
		}
	});
}

function tomail(){
	window.open($('#loginemail').attr('href'));
}

//功能：根据用户输入的Email跳转到相应的电子邮箱首页
function gotoEmail($mail) {
    $t = $mail.split('@')[1];
    $t = $t.toLowerCase();
    if ($t == '163.com') {
        return 'mail.163.com';
    } else if ($t == 'vip.163.com') {
        return 'vip.163.com';
    } else if ($t == '126.com') {
        return 'mail.126.com';
    } else if ($t == 'qq.com' || $t == 'vip.qq.com' || $t == 'foxmail.com') {
        return 'mail.qq.com';
    } else if ($t == 'gmail.com') {
        return 'mail.google.com';
    } else if ($t == 'sohu.com') {
        return 'mail.sohu.com';
    } else if ($t == 'tom.com') {
        return 'mail.tom.com';
    } else if ($t == 'vip.sina.com') {
        return 'vip.sina.com';
    } else if ($t == 'sina.com.cn' || $t == 'sina.com') {
        return 'mail.sina.com.cn';
    } else if ($t == 'tom.com') {
        return 'mail.tom.com';
    } else if ($t == 'yahoo.com.cn' || $t == 'yahoo.cn') {
        return 'mail.cn.yahoo.com';
    } else if ($t == 'tom.com') {
        return 'mail.tom.com';
    } else if ($t == 'yeah.net') {
        return 'www.yeah.net';
    } else if ($t == '21cn.com') {
        return 'mail.21cn.com';
    } else if ($t == 'hotmail.com') {
        return 'www.hotmail.com';
    } else if ($t == 'sogou.com') {
        return 'mail.sogou.com';
    } else if ($t == '188.com') {
        return 'www.188.com';
    } else if ($t == '139.com') {
        return 'mail.10086.cn';
    } else if ($t == '189.cn') {
        return 'webmail15.189.cn/webmail';
    } else if ($t == 'wo.com.cn') {
        return 'mail.wo.com.cn/smsmail';
    } else if ($t == '139.com') {
        return 'mail.10086.cn';
    } else {
        return '';
    }
};


var timer = null;//计时器
var flag = false;//手机号验证通过标识
var iswait = false;//等待标识
var nums = 60;//计时器等待60s
var sendsms = false;//短信发送标识


//获取验证码
function getcode(){
	var mobile = $('#mobile').val();
	if(mobile!='' && /^1[0-9]{10}$/.test(mobile)){
		if(iswait){
			return false;
		}
		if(!flag){
			return false;
		}
		$("#getcode").addClass('hui');
		$("#mobile").prop("disabled",true);
		$("#mobile").addClass('huibg');
		timer = setInterval(function(){
			if(nums <= 0){
				iswait = false;
				$("#getcode").removeClass('hui');
				$("#getcode").html("重新发送");
				$("#mobile").prop("disabled",false);
				$("#mobile").removeClass('huibg');
					
				clearInterval(timer);
				nums = 60;
			}else{
				iswait = true;
				$("#getcode").html(nums+' s');
				nums-- ;
			}
		},800);

		sendsmscode();
	}else{
		$('#mobile').trigger('blur');
	};
}


//调用短信接口,发送短信
function sendsmscode(){
	var mobile = $.trim($("#mobile").val());
	$.ajax({
		async: false,
		url:'/forget/getsmscode.html',
		type:'post',
		dataType:'json',
		data:{'mobile':mobile,'check':true},
		success:function(json){
			response = json ; 
			if(!response.status){//发送成功
				sendsms = true;
				$('.showinfo_mobile').html(response.msg);
				$('.showinfo_mobile').show();
			}else{//发送失败
				setTimeout(function(){
					clearInterval(timer);
					iswait = false;
					sendsms = false;
					nums = 60;
					
					$('.showinfo_mobile').html(response.msg);
					$('.showinfo_mobile').show();
				},800);
			}
		},
		error:function(){
			alert('服务器返回错误!!!');
		}		

	});
}

function checkmobile(){
	var mobile = $('#mobile').val();
	if(mobile==''){
		flag = false;
		$('.mobile_msg').hide();
		$('.mobile_msg.cuotic1').css('display','inline');
		return false;
	}else{
		var reg = /^1[0-9]{10}$/;
		if(!reg.test(mobile)){
			flag = false;
			$('.mobile_msg').hide();
			$('.mobile_msg.cuotic1').css('display','inline');
			return false;
		}else{
			var ret = false;
			$.ajax({
				type:"POST",
				url:'<?=geturl('forget/checkmobile')?>',
			    data: { 'mobile': mobile },
			    dataType:'json',
			    async:false,
                success: function (json) {
                    if (!json.code) {
                    	flag = false;
						ret = false;
                    	$('.mobile_msg').hide();
						$('.mobile_msg.cuotic2').css('display','inline');
					}else{
						ret = true;
						flag = true;
						$('.mobile_msg').hide();
						$('.mobile_msg.zhengtic').css('display','inline');
					}
				}
			});
			return ret;
		}
	}
}

function checkverify(){
	var code = $('#verify').val();
	if(code==''){
		$(".verify_msg").hide();
		$(".verify_msg.cuotic0").css('display','inline');
		return false;
	}
	var regsms = /^\d{6}$/;
    if(!regsms.test(code)){
    	$(".verify_msg").hide();
		$(".verify_msg.cuotic1").css('display','inline');
		return false;
    }else{
    	$(".verify_msg").hide();
		$(".verify_msg.zhengtic").css('display','inline');
		return true;
    }
}

//找回密码
function dofind(){
	var cmobile = checkmobile();
	var cverify = checkverify();
	if(!(cmobile && cverify)){
		return ;
	}
	if(!sendsms){
		$(".verify_msg").hide();
		$(".verify_msg.cuotic2").css('display','inline');
		return;
	}
	var mobile = $('#mobile').val();
	var verify = $('#verify').val();
	
	$.ajax({
		url:"<?=geturl('forget/sms_check')?>",
		type:'post',
		data:{'mobile':mobile,'smscode':verify},
		dataType:'json',
		success:function(json){
			if(!json.status){
				//验证成功
				location.href="/forget/mobile_reset.html?codekey="+json.attr.codekey;
			}else{
				//验证失败
				$('.showinfo_mobile').text(json.msg);
				$('.showinfo_mobile').show();
			}
		}
	});
	
}
</script>
<?php
$this->display('common/newtemplate/footer');
?>