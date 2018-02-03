<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>安全中心</title>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newreg/css/reg.css">
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>

	</head>
	<style>
	.password_msg,.passwordconfirm_msg{
		display:none
	}
	</style>
	<body>
		<div class="backs">
			<div class="register">
				<div class="tongtit">安全中心</div>
				<div class="mss">
					<div class="clear"></div>
					<div class="mt45">
					<form id="resetform" name="resetform">
						<input type="hidden" name="doreset" value="1" />
						<div class="showno">
							<?php if($flag){?>
							<input type="hidden" name="codekey" value="<?=$codekey?>" />
							<div class="isterdiv">
								<span class="isterspan">新密码</span>
								<input class="istertxts" needcheck="1" placeholder="请输入6~16位的新密码" value="" id="password" name="pwd" type="password">
								<p id="" class="password_msg zhengtic"></p>
								<p id="" class="password_msg cuotic cuotic0">请输入密码</p>
								<p id="" class="password_msg cuotic cuotic1">密码位数不正确</p>
							</div>
							<div class="isterdiv mt40">
								<span class="isterspan">确认密码</span>
								<input class="istertxts" needcheck="1" placeholder="请再次输入新密码" value="" id="passwordconfirm" type="password">
								<p id="" class="passwordconfirm_msg zhengtic"></p>
								<p id="" class="passwordconfirm_msg cuotic cuotic0">请再次输入密码</p>
								<p id="" class="passwordconfirm_msg cuotic cuotic1">两次密码不一致</p>
							</div>
							<div class="clear"></div>					
							<div class="mt45">
								<input class="logbtn" value="确 认" onclick="myset()" type="button">
							</div>
							<?php } else {?>
							<div class="isterdiv" style="height: auto;">
								<img class="ml70" src="http://static.ebanhui.com/ebh/tpl/newreg/images/emailico.png" />
								<p class="tisize">验证失败，请重新操作，<span class="selan" id="nums">3s</span>后直接跳转</p>
							</div>
							<div class="clear"></div>					
							<div class="mt45">
								<a class="logbtn" id="doback" href="/forget.html">验证邮箱</a>
							</div>
							<script type="text/javascript">
							var nums = 3;
							var timer = setInterval(function(){
								$("#nums").text(nums+'s');
								nums--;
								if(nums<=0){
									clearInterval(timer);
									var href = $("#doback").attr("href");
									location.href = href;
									//$("#doback").trigger("click");
									}
								},800);
							</script>
							<?php }?>
						</div>
					</form>
					</div>
				</div>
			</div>
			<?php $this->display('common/newtemplate/animation');?>
		</div>
<script>
$('input[needcheck=1]').blur(function(){
	eval('check'+$(this).attr('id')+'()');
});
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
	}else {
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
	} else if (password == password2){
		$('.passwordconfirm_msg').hide();
		$('.passwordconfirm_msg.zhengtic').css('display','inline');
		return true;
	}else{
		$('.passwordconfirm_msg').hide();
		$('.passwordconfirm_msg.cuotic1').css('display','inline');
		return false;
	}
}
function checkform(not){
	var notstr = '';
	var ret = true;
	if(not && not.length>0){
		notstr = ':not('+not+')'
	}
	$.each($('input[needcheck=1]'+notstr),function(k,v){
		if(!eval('check'+$(this).attr('id')+'()')){
			ret = false;
		}
	});
	return ret;
}
function myset(){
	var ret = checkform();
	if(!ret){
		return false;
	}
	$.ajax({
		type:"POST",
		url:'<?=geturl('forget/reset')?>',
	    data: $('#resetform').serialize(),
	    dataType:'json',
	    async:false,
        success: function (json) {
            if (json.code) {
				//修改成功
				$.showmessage({
					img		 :'success',
					message  :"恭喜您,密码设置成功",
					title    :'消息通知',
					callback  :function(){
						//console.log(json);
						if(json['durl'] != undefined) {
							dosso(json['durl'],json["backurl"]);
						} else {
							location.href = json["backurl"];
						}
					}      
				});
			}else{
				//修改失败		
				$.showmessage({
					img		 :'error',
					message  :"密码设置失败,不能与旧密码相同,请刷新后重试",
					title    :'消息通知'
				});				
			}
		}
	});
}

//同步登陆
function dosso(durl,returnurl,callback) {
	var img = new Image();
	img.src = durl;
	$(img).appendTo("body");
	if(img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
		if(returnurl != undefined && returnurl != "") {
			location.href = returnurl;
		} else if(typeof(callback) == 'function') {
			callback();
		}
		return; // 直接返回，不用再处理onload事件
	}
	img.onload = function () { //图片下载完毕时异步调用callback函数。
		if(returnurl != undefined && returnurl != "") {
			location.href = returnurl;
		} else if(typeof(callback) == 'function') {
			callback();
		}
	};
}
</script>
<?php
$this->display('common/newtemplate/footer');
?>