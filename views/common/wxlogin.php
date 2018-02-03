<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/else.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<title>微信扫码绑定</title>
</head>

<body>
<div class="long">
<div style="width:960px; margin:0 auto; position:relative;">
<a class="alogo" href="http://www.ebanhui.com/"></a></div>
</div>
<div class="main">
<h2 class="titelse">连接绑定微信账号</h2>
<div class="navrs">
<i><img src="<?=$ulogo?>" /></i>
<p>亲爱的<span><?=$uname?></span>,欢迎您通过微信扫码登录e板会！</p>
<p>将为你创建一个e板会帐号，请设置帐号：</p>
</div>

<form action="<?=geturl('otherlogin/associate')?>" method="post" onsubmit="return checkform('csina')">
	<input type="hidden" name="op" value="cwx" />
	<input type="hidden" name="openid" value="<?=$openid?>" />
	<input type="hidden" name="sex" value="<?=$sex?>" />
	<input type="hidden" name="unionid" value="<?=$unionid?>" />
	<input type="hidden" name="nickname" value="<?=$uname?>" />
	<input type="hidden" name="face" value="<?=$ulogo?>" />
	
	<div class="user">
		<p>帐&nbsp;号：</p>
	  <input class="kuang" type="text" id="cusername" name="cusername" value="" />
	  <em id="cusername_msg"></em>
	</div>
	<div class="user">
		<p>密&nbsp;码：</p>
	  <input class="kuang" type="password" id="cpassword" name="cpassword" value="" />
	  <em id="cpassword_msg"></em>
	</div>
	<input type="submit" id="createsina" class="chuangjbtn" value="确认创建" />
</form>

<p class="guanl">已经有e板会帐号了,<a onclick="opendiv()" href="javascript:;"><span>请设置关联</span></a></p>
<form name="associate" id="associate" style="display:none" action="<?=geturl('otherlogin/associate')?>" method="post" onsubmit="return checkform('asina')">
	<input type="hidden" name="op" value="awx" />
	<input type="hidden" name="openid" value="<?=$openid?>" />
	<input type="hidden" name="sex" value="<?=$sex?>" />
	<input type="hidden" name="unionid" value="<?=$unionid?>" />
	<input type="hidden" name="nickname" value="<?=$uname?>" />
	<input type="hidden" name="face" value="<?=$ulogo?>" />
	
	<div class="user" style="_margin-left: 33px;">
	  <p>帐&nbsp;号：</p><input class="kuang" type="text" id="ausername" name="ausername" value="" />
	  <span id="ausername_msg"></span>
	</div>
	<div class="user" style="_margin-left: 33px;">
	  <p>密&nbsp;码：</p><input class="kuang" id="apassword" name="apassword" type="password" value="" />
	  <span id="apassword_msg"></span>
	</div>
	<input type="submit" class="querenbtn" value="确认"/>
</form>

<p class="guanzhu"><span style="float:left;">关注e板会官方微博账号：</span><a href="http://e.weibo.com/ebanhui" style="float:left;" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/guanzhuebh0917.jpg" /></a></p>
<div class="fotsle">操作完成后您就可以通过微信扫码授权登录或账号直接登录e板会啦~</div>
</div>
<script type="text/javascript">
	function opendiv(){
		if(document.associate.style.display == "none" ){
			document.associate.style.display = "block" ;
		}else{
			document.associate.style.display = "none" ;
		}
	}
	$(function(){
		//创建账号-用户名
		$("#cusername").blur(function(){
			checkcname(this);
		});
		//创建账号-密码
		$("#cpassword").blur(function(){
			checkcpwd(this);
		});
		//检测绑定账号-用户名
		$("#ausername").blur(function(){
			checkaname(this);
		});
		//检测绑定账号-密码
		$("#apassword").blur(function(){
			checkapwd(this);
		});
	});
	//创建账号-用户名
	function checkcname(_this){
		var _value = '';
		if(typeof(_this) == 'object'){
			_value = $(_this).val();
		}else{
			_value = $("#"+_this).val();
		}
		if(_value == ''){
			$("#cusername_msg").html("<span class='cuowu'>对不起，请输入帐号！</span>");
			return false;
		}else if(!_value.match(/^[a-zA-Z_][a-z0-9A-Z_]{5,15}$/)){
			$("#cusername_msg").html("<span class='gantan'>6~18个字符，包括字母、数字、下划线，字母开头！</span>");
			return false;
		}else{
			var result = false;
			$.ajax({
				type:"post",
				url:"<?=geturl('otherlogin/checkusername')?>",
				dataType:'json',
				data:{'username':_value},
				async:false,
				success:function(_json){
					if(_json.code == 0){
						$("#cusername_msg").html("<span class='cuowu'>"+_json.message+"</span>");
						result = false;
					}else{
						$("#cusername_msg").html("<span class='zhengq'>"+_json.message+"</span>");
						result = true;
					}
				}
			});
			return result;
		}
	}
	//创建账号-密码
	function checkcpwd(_this){
		var _value = '';
		if(typeof(_this) == 'object'){
			_value = $(_this).val();
		}else{
			_value = $("#"+_this).val();
		}
		if(_value == ''){
			$("#cpassword_msg").html("<span class='cuowu'>请设置密码！</span>");
			return false;
		}else if(_value.length < 6){
			$("#cpassword_msg").html("<span class='gantan'>密码长度至少6位！</span>");
			return false;
		}else{
			$("#cpassword_msg").html("<span class='zhengq'></span>");
			return true;
		}
	}
	//检测绑定账号-用户名
	function checkaname(_this){
		var _value = '';
		if(typeof(_this) == 'object'){
			_value = $(_this).val();
		}else{
			_value = $("#"+_this).val();
		}
		if(_value == ''){
			$("#ausername_msg").attr('class','cuowu');
			$("#ausername_msg").html('对不起，请输入帐号！');
			return false;
		}else if(!_value.match(/^[a-zA-Z_][a-z0-9A-Z_]{5,15}$/)){
			$("#ausername_msg").attr('class','gantan');
			$("#ausername_msg").html('6~16个字符，包括字母、数字、下划线，字母开头！');
			return false;
		}else{
			var result = false;
			$.ajax({
				type:"post",
				url:"<?=geturl('otherlogin/checkusername')?>",
				dataType:'json',
				data:{'ttype':'associatewx','username':_value},
				async:false,
				success:function(_json){
					if(_json.code == 0){
						$("#ausername_msg").attr('class','cuowu');
						$("#ausername_msg").html(_json.message);
						result = false;
					}else{
						$("#ausername_msg").attr('class','zhengq');
						$("#ausername_msg").html("");
						result = true;
					}
				}
			});
			return result;
		}
	}
	//检测绑定账号-密码
	function checkapwd(_this){
		var _value = '';
		if(typeof(_this) == 'object'){
			_value = $(_this).val();
		}else{
			_value = $("#"+_this).val();
		}
		if(_value == ''){
			$("#apassword_msg").attr('class','cuowu');
			$("#apassword_msg").html('对不起，请设置密码！');
			return false;
		}else if(_value.length < 6){
			$("#apassword_msg").attr('class','gantan');
			$("#apassword_msg").html('密码长度至少6位！');
			return false;
		}else{
			var result = false;
			var uname = $('#ausername').val();
			$.ajax({
				type:"post",
				url:"<?=geturl('otherlogin/checkusername')?>",
				dataType:'json',
				data:{'ttype':'detectpwd','password':_value,'username':uname},
				async:false,
				success:function(_json){
					if(_json.code == 0){
						$("#apassword_msg").attr('class','cuowu');
						$("#apassword_msg").html(_json.message);
						result = false;
					}else{
						$("#apassword_msg").attr('class','zhengq');
						$("#apassword_msg").html('');
						result = true;
					}
				}
			});
			return result;
		}
	}

	function checkform(type){
		if(type=='csina'){
			if(checkcname('cusername') && checkcpwd('cpassword')){
				return true;
			}
			return false;
		}else{
			if(checkaname('ausername') && checkapwd('apassword')){
				return true;
			}
			return false;
		}
	}
</script>
</body>
</html>
