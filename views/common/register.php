<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$this->get_title()?></title>
<meta name="keywords" content="<?=$this->get_keywords()?>" />
<meta name="description" content="<?=$this->get_description()?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<style>
	.txtktb{
		color:#000;
	}
	.hit{
		color:#999;
	}
</style>
</head>

<body>
<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg) repeat; height:auto;">

<div class="topebroll">
<div style="width:1000px; margin:0 auto; position:relative">
<div class="toplogo">
<a href="/"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/login511.jpg" /></a>
</div>
</div>
</div>
<div class="mains ludyg">
<!--改版后的注册!-->
<div class="etgiegs"><h2 class="dgkrgs">用户注册</h2></div>
<form id="registerform" method="post" action="" >
	<div class="etgiegs">
		<span class="retigd">账号：</span>
		<input id="username" class="txtktb" type="text" x_func="chkname"  x_hit="由6-20位英文、数字且字母开头组成"  value="" name="username">
		<p id="username_msg"></p>
	</div>
	<div class="etgiegs">
		<span class="retigd">密码：</span>
		<input id="password" class="txtktb" type="password" x_hit="请输入6-16位密码" x_func="chkpwd" value="" name="password">
		<p id="password_msg"></p>
	</div>
	<div class="etgiegs">
		<span class="retigd">确认密码：</span>
		<input id="password2" class="txtktb" type="password" x_hit="再次输入密码" x_func="chkpwd2" value="" name="password2">
		<p id="password2_msg"></p>
	</div>
	<!--<div class="etgiegs">
		<span class="retigd">邮箱：</span>
		<input id="email" class="txtktb" type="text" x_hit="常用邮箱用于找回密码" x_func="chkemail" value="" name="email">
		<p id="email_msg"></p>
	</div>-->
	<!--<div class="etgiegs">
		<span class="retigd">手机号码：</span>
		<input id="mobile" class="txtktb" type="text" x_hit="请输入手机号" x_func="chkmobile" value="" name="mobile">
	</div>-->
	<div class="etgiegs">
		<span class="retigd">姓名：</span>
		<input id="realname" class="txtktb" type="text" x_hit="与身份证姓名一致" x_func="chkrealname" value="" name="realname">
		<p id="realname_msg"></p>
	</div>
	
	<div class="etgiegs">
		<span class="retigd">验证码：</span>
		<input id="verify" class="yantes txtktb" type="text" x_hit="请输入验证码" x_func="checkcode" value="" name="verify">
		<a href="javascript:void(0)" onclick="updatesecode()" class="rtikjgh"><img id="img_seccode" style="width:92px;height:34px;" src="/verify/getcode.html" /><span class="landstma">换一张</span></a>
		<p id="verify_msg"></p>
	</div>
	<div class="etgiegs">
		<span class="retigd">性别：</span>
		<label>
		<input id="user_add_sex0" class="sexadd" type="radio" checked="checked" value="0" name="sex">
		<span class="span2" style=" color: #545454;font-size:18px;line-height:30px;">男</span>
		</label>
		<label>
		<input id="user_add_sex1" class="sexadd" type="radio" value="1" name="sex" style="margin-left:40px;">
		<span class="span2" style=" color: #545454;font-size:18px;line-height:30px;">女</span>
		</label>
	</div>
</form>
<a href="javascript:void(0)" onclick="doregist();" class="zhurtbtn"></a>


</div>
<div class="footlintbg"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/doot511.jpg" width="828" height="16" />
</div>
</div>
<script type="text/javascript">

function chkname(obj){
	var username = _xform.getdata().username;
	if (username == '') {
		obj.res = -1;
		obj.msg = '请输入帐号名称！';
		return false;
	} else {
		var namereg = /^[a-zA-Z][a-z0-9A-Z_]{5,19}$/;
		if(!username.match(namereg)){
			obj.res = -1;
			obj.msg = '6-20位以字母开头且不包含特殊字符！';
			return false;
		} else {
			$.ajax({
				type:"POST",
				url:'<?=geturl('register/checkusername')?>',
				data:{'username':username},
				dataType:'json',
				async:false,
				success:function(json){
					if(json.code==1){
						obj.res = -1;
						obj.msg = "<font color=red>用户名已被占用，<a style='text-decoration:none;' href='<?=geturl('login')?>'>登录？</a></font>";
						obj.ishtml = 1;
					}else{
						obj.res = 0;
						obj.msg = '用户名可用！';
					}
				}
			});
		}
	}
}

function chkpwd(obj){
	var password = _xform.getdata().password;
	obj.res = -1;
	if (password == '') {
		obj.msg = '请输入用户密码！';
	} else if (password.length < 6 || password.length > 16 ) {
		obj.msg = '密码位数不正确。';
	} else {
		obj.res = 0;
	}
}

function chkpwd2(obj){
	var password = _xform.getdata().password;
	var password2 = _xform.getdata().password2;
	obj.res = -1;
	if (password == '') {
		obj.msg = '请输入用户密码！';
	} else if (password2.length < 6) {
		obj.msg = '密码位数不正确。';
	} else {
		obj.res = 0;
	}
	if(obj.res == -1){
		return;
	}
	if(password == password2){
		obj.res = 0;
	}else{
		obj.res = -1;
		obj.msg = "两次密码不一致";
	}
}

function checkcode(obj){
	var code = _xform.getdata().verify;
	obj.res = -1;
	if(code == ""){
		obj.msg = "验证码不能为空";
		return;
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
				obj.msg = "验证码不正确！";
			}
		}
	});
}
function chkemail(obj){
	obj.res = -1;
	var email = _xform.getdata().email;
	if(email == ""){
		obj.msg = "邮箱地址不能为空";
		return false;
	}else{
		var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(!emailreg.test(email)){
			obj.msg = "请填写有效的E-mail地址。";
			return false;
		}else{
			$.ajax({
				type:"POST",
				url:'<?=geturl('register/checkemail')?>',
				data:{'email':email},
				dataType:'json',
				async:false,
				success:function(json){
					if(json.code==1){
						obj.msg = "邮箱已被占用！";
					}else{
						obj.res = 0;
						obj.msg = "邮箱可用！";
					}
				}
			})
		}
	}
}

function chkmobile(obj){
	var mobile = $('#mobile').val();
	obj.res = -1;
	if(mobile == '' || mobile == '请输入手机号'){
		obj.msg = '请输入手机号';
		obj.res = -1;
	}else{
		if(_xform.getdata().mobile!=null){
			var ret = _xform.xCheck(this,'isTel');
			if(!ret){
				obj.msg = '手机号码填写不正确';
				return false;
			}
			obj.res = 0;
		}
	}
}

function chkrealname(obj){
	var data = _xform.getdata();
	var realname = data.realname;
	if(!realname){
		obj.res = -1;
		obj.msg = '姓名不能为空';
		return;
	}
	if(_xform.xCheck(this,'isRealname')){
		obj.res = 0;
	}else{
		obj.res = -1;
		obj.msg = '姓名不符合规范';
	}
}

var _xform = new xForm({
	domid:'registerform',
	errorcss:'cuotic',
	okcss:'zhengtic',
	showokmsg:false
});

function updatesecode(){
	$("#img_seccode").attr('src',"/verify/getcode.html"+'?'+Math.random());
	return ;
}

function doregist(){
	var ret = _xform.check();
	if(!ret){
		return;
	}else{
		datas = {
			username: $("#username").val(),
			password: $('#password').val(),
			realname: $("#realname").val(),
			sex: 1
		};
		$.ajax({
			type:"post",
			url:"/register.html",
			data:datas,
			async:false,
			success:function(data){
				window.location.href = "/";
			},
			error:function(data){
				console.log(data);
			}
		});
	}
//	$("#registerform").submit();
}

</script>
<?php $this->display('common/site_footer')?>