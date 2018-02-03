<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="keywords" content="<?=$this->get_keywords()?>" />
		<meta name="description" content="<?=$this->get_description()?>" />
		<title>用户注册</title>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newreg/css/reg.css">
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	</head>
	<style>
	.username_msg,.password_msg,.passwordconfirm_msg,.name_msg,.verify_msg{
		display:none;
	}
	</style>
	<body>
		<div class="backs">
			<div class="register">
				<div class="tongtit">用户注册</div>
				<form id="registerform" method="post" action="" >
				<div class="ister">
					<div class="isterdiv">
						<span class="isterspan">账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</span>
						<input class="istertxts" id="username" needcheck="1" title="请输入账号" placeholder="由6-20位英文、数字且字母开头组成" value="" name="username" type="text">
						<p id="" class="username_msg zhengtic"></p>
						<p id="" class="username_msg cuotic cuotic0">请输入帐号名称</p>
						<p id="" class="username_msg cuotics cuotic1">6-20位以字母开头<br>且不包含特殊字符</p>
						<p id="" class="username_msg cuotic cuotic2"><font color="red">用户名已被占用，<a style='text-decoration:none;' href='<?=geturl('login')?>'>登录？</a></font></p>
					</div>
					<div class="isterdiv">
						<span class="isterspan">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</span>
						<input class="istertxts" id="password" needcheck="1" title="请输入密码" placeholder="请输入6-16位密码" value="" name="password" type="password">
						<p id="" class="password_msg zhengtic"></p>
						<p id="" class="password_msg cuotic cuotic0">请输入用户密码</p>
						<p id="" class="password_msg cuotic cuotic1">密码位数不正确</p>
					</div>
					<div class="isterdiv">
						<span class="isterspan">确认密码</span>
						<input class="istertxts" id="passwordconfirm" needcheck="1" title="请再次输入密码" placeholder="再次输入密码" value="" name="" type="password">
						<p id="" class="passwordconfirm_msg zhengtic"></p>
						<p id="" class="passwordconfirm_msg cuotic cuotic0">请再次输入用户密码</p>
						<p id="" class="passwordconfirm_msg cuotic cuotic1">两次密码不一致</p>
					</div>
					<div class="isterdiv">
						<span class="isterspan">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span>
						<input class="istertxts" id="realname" needcheck="1" title="请输入姓名" placeholder="与身份证姓名一致" value="" name="realname" type="text">
						<p id="" class="name_msg cuotic zhengtic"></p>
						<p id="" class="name_msg cuotic cuotic0">姓名不能为空</p>
						<p id="" class="name_msg cuotic cuotic1">姓名不符合规范</p>
					</div>
					<div class="isterdiv">
						<span class="isterspan">验&nbsp;&nbsp;证&nbsp;&nbsp;码</span>
						<input class="yantess istertxts" id="verify" needcheck="1" title="请输入验证码"  placeholder="请输入验证码" value="" name="verify" type="text">
						<a class="yaned" href="javascript:void(0)" onclick="updatesecode()">
							<img id="img_seccode" style="width:90px;height:40px;" src="/verify/getcode.html">
							<span class="landstma">换一张</span>
						</a>
						<p id="" class="verify_msg zhengtic"></p>
						<p id="" class="verify_msg cuotic cuotic0">验证码不能为空</p>
						<p id="" class="verify_msg cuotic cuotic1">验证码不正确</p>
					</div>
					<div class="isterdiv">
						<span class="isterspan">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别</span>
						<label>
							<input id="user_add_sex0" class="sexadd" checked="checked" value="0" name="sex" type="radio">
							<span class="span2">男</span>
						</label>
						<label>
							<input id="user_add_sex1" class="sexadd" value="1" name="sex" style="margin-left:40px;" type="radio">
							<span class="span2">女</span>
						</label>
					</div>
					<div class="clear"></div>					
					<div class="mt35">
						<input class="logbtn" value="立即注册" type="button" onclick="doregist()">
					</div>
				</div>
				</form>
			</div>
			<?php $this->display('common/newtemplate/animation');?>
		</div>
<script type="text/javascript">
function updatesecode(){
	$("#img_seccode").attr('src',"/verify/getcode.html"+'?'+Math.random());
	return ;
}
// $('#username').blur(function(){
	// checkusername();
// });
// $('#password').blur(function(){
	// checkpassword();
// });
// $('#passwordconfirm').blur(function(){
	// checkpasswordconfirm();
// });
// $('#realname').blur(function(){
	// checkrealname();
// });
// $('#verify').blur(function(){
	// checkverify();
// });
$('input[needcheck=1]').blur(function(){
	eval('check'+$(this).attr('id')+'()');
})
function checkusername(){
	var username = $('#username').val();
	if (username == '') {
		$('.username_msg').hide();
		$('.username_msg.cuotic0').css('display','inline');
		return false;
	} else {
		var namereg = /^[a-zA-Z][a-z0-9A-Z_]{5,19}$/;
		if(!username.match(namereg)){
			$('.username_msg').hide();
			$('.username_msg.cuotic1').css('display','inline');
			return false;
		} else {
			var res = false;
			$.ajax({
				type:"POST",
				url:'<?=geturl('register/checkusername')?>',
				data:{'username':username},
				dataType:'json',
				async:false,
				success:function(json){
					if(json.code==1){
						$('.username_msg').hide();
						$('.username_msg.cuotic2').css('display','inline');
						res = false;
					}else{
						$('.username_msg').hide();
						$('.username_msg.zhengtic').css('display','inline');
						res = true;
					}
				}
			});
			return res;
		}
	}
}
function checkpassword(){
	var password = $('#password').val();
	if (password == '') {
		$('.password_msg').hide();
		$('.password_msg.cuotic0').css('display','inline');
		return false;
	} else if (password.length < 6 || password.length > 16 ) {
		$('.password_msg').hide();
		$('.password_msg.cuotic1').css('display','inline');
		return false;
	} else {
		$('.password_msg').hide();
		$('.password_msg.zhengtic').css('display','inline');
		return true;
	}
}

function checkpasswordconfirm(){
	var password = $('#password').val();
	var password2 = $('#passwordconfirm').val();
	if (password2 == '') {
		$('.passwordconfirm_msg').hide();
		$('.passwordconfirm_msg.cuotic0').css('display','inline');
		return false;
	} else if (password != password2){
		$('.passwordconfirm_msg').hide();
		$('.passwordconfirm_msg.cuotic1').css('display','inline');
		return false;
	} else {
		$('.passwordconfirm_msg').hide();
		$('.passwordconfirm_msg.zhengtic').css('display','inline');
		return true;
	}
}
function checkrealname(){
	var realname = $('#realname').val();
	if(realname == ''){
		$('.name_msg').hide();
		$('.name_msg.cuotic0').css('display','inline');
		return false ;
	}
	var patrn = /^[\u4E00-\u9FA5\uF900-\uFA2D]+$/;
	if (!patrn.exec(realname)){
		$('.name_msg').hide();
		$('.name_msg.cuotic1').css('display','inline');
		return false;
	} else {
		$('.name_msg').hide();
		$('.name_msg.zhengtic').css('display','inline');
		return true;
	}
}
function checkverify(){
	var code = $('#verify').val();
	if(code == ""){
		$('.verify_msg').hide();
		$('.verify_msg.cuotic0').css('display','inline');
		return false;
	}
	var ret = false;
	$.ajax({
		url:"<?=geturl('verify/checkcode')?>",
		data:{'code':code},
		async:false,
		success:function(data){
			if(data=='1' || data==true){
				$('.verify_msg').hide();
				$('.verify_msg.zhengtic').css('display','inline');
				ret = true;
			}
			else{
				$('.verify_msg').hide();
				$('.verify_msg.cuotic1').css('display','inline');
				ret = false;
			}
		}
	});
	return ret;
}
function doregist(){
	var ret = true;
	$.each($('input[needcheck=1]'),function(k,v){
		if(!eval('check'+$(this).attr('id')+'()')){
			ret = false;
		}
	});
	if(!ret){
		return;
	}else{
		datas = {
			username: $("#username").val(),
			password: $('#password').val(),
			realname: $("#realname").val(),
			sex: $('input[name=sex]:checked').val()
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
<?php
$this->display('common/newtemplate/footer');
?>