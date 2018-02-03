<?php $this->display('common/forget_header')?>
<style>
	.txtktb{
		color:#000;
	}
	.hit{
		color:#999;
	}
	.yantes{width:87px;}
	.sjzhts {width:385px;}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js"></script>

<form id="forgetform" method="post"  autocomplete="off" >
<input type="hidden" name="forget" value="1" />
<input type="hidden" name="ajax" value="1" />

<div class="awmbg" >
  <div class="main lidtgd">

<div class="retpassword">
	<div class="title">找回密码</div>
	<div class="repawlist">
		<ul>
			<li class="emails"><a class="cur" href="/forget.html">通过邮箱找回密码</a></li>
			<li class="phone"><a href="/forget/mobile.html">通过手机找回密码</a></li>
		</ul>
	</div>
</div>
	
	<div class="yznr">
		<div class="sjzhts" id="msginfo"  style="display:none">手机号码验证成功，请输入新密码</div>
		<div class="clear"></div>
        <div class="lidet" >
            <span class="gkswey">请输入您的注册邮箱：</span>
            <input id="email" class="txtktb" type="text" x_hit="请输入您的注册邮箱" x_func="checkemails" value="" name="email">
            <p  id="email_msg"></p>
        </div>
        <div class="clear"></div>
        <div class="lidet">
            <span class="gkswey">验证码：</span>
            <input id="verify" class="yantes txtktb" type="text" value="" x_hit="请输入验证码" x_func="checkemailcode" name="emailcode">
            <a href="javascript:void(0)" onclick="updatesecode()" class="rtikjgh" style="text-decoration: none;">
            <img id="img_seccode" style="width:92px;height:34px;" src="/verify/getcode.html" />
            <span class="landstma">换一张</span></a>
            <p   id="verify_msg"></p>
        </div>
		<div class="clear"></div>
        <div style="margin-left:140px;">
        	<a href="javascript:void(0)" onclick="sendmail()" class="ieurgrs" id="searchpwd">找回密码</a>
            <a class="ieurgrs" id="loginemail" href="javascript:;" target="_blank" style="display:none">登录邮箱</a>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
  <div style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/fotbottg.jpg) no-repeat;margin:0 auto;width:820px;height:16px; position: relative; top: -1px;"></div>
 </div> 
 </form>

<script>
var _xform = new xForm({
	domid:'forgetform',
	errorcss:'cuotic',
	okcss:'zhengtic',
	showokmsg:false
});
window.onkeyup = function(_e){
	var e = _e?_e:window.event; // 获取有效的事件对象
	if( e.keyCode == 13 ) // 按下的是否是回车键
	{
		sendmail();
	}
}
function checkemails(obj){
	obj.res = -1;
	var email = _xform.getdata().email;
	if(email==''){
		obj.msg = '请输入邮箱！';
		return false;
	}else{
		var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(!emailreg.test(email)){
			obj.msg = '请填写有效的E-mail地址';
			return false;
		}else{
			$.ajax({
				type:"POST",
				url:'<?=geturl('forget/checkemail')?>',
			    data: { 'email': email },
			    async:false,
                success: function (data) {
                    if (data != 1) {
                    	obj.msg = '该邮箱尚未绑定,请更换一个,重新再试！';
						return false;
					}else{
						obj.res = 0;						
					}
				}
			});
		}
	}
}

function checkemailcode(obj){
	obj.res = -1;
	var code = _xform.getdata().emailcode;
	if(code==''){
		obj.msg = '请输入验证码！';
		return false;
	}
	$.ajax({
		url:"<?=geturl('verify/checkcode')?>",
		data:{'code':code},
		async:false,
		success:function(data){
			if(data=='1' || data==true){
				obj.res = 0;
			}
			else{
				obj.msg = '验证码不正确！';
			}
		}
	});
}


/**
 * 更新验证码
 */
function updatesecode(){
	$("#img_seccode").attr('src',"/verify/getcode.html"+'?'+Math.random());
}

var flag = 0;
function sendmail(){
	if(flag == 1){
		return;
	}
	if(!_xform.check()){
		return;
	}
	flag = 1;
	$("#msginfo").show();
	$("#msginfo").text("邮件发送中，请稍等...");
	$.ajax({
		url:"<?=geturl('forget')?>",
		type:'post',
		data:_xform.getdata(),
		dataType:'json',
		success:function(data){
			if(data.status == 0){
				$('#searchpwd').hide();
				$("#loginemail").show();
				$("#loginemail").attr("href","http://"+gotoEmail(_xform.getdata().email));
				$("#msginfo").text("密码将发送到您的邮箱，请注意查收！");
			}else{
				$("#msginfo").text(data.msg);
			}
			flag = 0;
		}
	});
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
</script>
<?php $this->display('common/site_footer')?>
