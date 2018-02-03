<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>用户登录</title>
		<meta name="keywords" content="<?= $this->get_keywords() ?>" />
		<meta name="description" content="<?= $this->get_description() ?>" />
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newreg/css/reg.css">
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
	</head>
	<body>
<?php
$url = geturl('login') . '?inajax=1&returnurl=' . $this->input->get('returnurl');
?>
		<div class="backs">
			<div class="register">
				<div class="tongtit">用户登录</div>
				<div class="login">
				<form id="form1" method="post" name="form1" action="<?= $url ?>" onsubmit="form_submit(); return false;">
					<input type="hidden" name="loginsubmit" value="1" />
					<input type="hidden" name="sharp" value="<?=$sharp?>"/>
					<input type="hidden" name="cookietime" id="cookietime" value="1" />
					<div>
						<div class="logdiv">
							<span class="userico fl"></span>
							<input class="loginput fl" name="username" id="username" tabindex="1" title="请输入用户名" value="" placeholder="账号" type="text">
						</div>
						<p id="" class="username_msg zhengtic" style="display:none"></p>
						<p id="" class="username_msg cuotic" style="display:none">用户名不能为空！</p>
					</div>
					<div class="clear"></div>
					<div>
						<div class="logdiv">
							<span class="passico fl"></span>
							<input class="loginput fl" name="password" id="password" tabindex="2" title="请输入密码" value="" placeholder="密码" type="password">
						</div>
						<p id="" class="password_msg zhengtic" style="display:none"></p>
						<p id="" class="password_msg cuotic cuotic0" style="display:none">密码不能为空！</p>
						<p id="" class="password_msg cuotic cuotic1" style="display:none">用户名或密码错误</p>
					</div>
					<div class="clear"></div>
					<div class="logmind">
						<a class="logchoose" href="javascript:;" id="remember">下次自动登录</a>
					</div>

					 <?php 
		                //获取网校的配置
		                $systemsetting = Ebh::app()->room->getSystemSetting();
		                $isbanregister = empty($systemsetting['isbanregister']) ? 0 : 1;//禁用注册
		                $isbanthirdlogin = empty($systemsetting['isbanthirdlogin']) ? 0 : 1;//禁用第三方登入
		            ?>
		           
					<div class="clear"></div>
					<div class="mt30">
						<input class="logbtn" value="登录" type="submit">
					</div>
					<div class="clear"></div>
					<div class="mt35">
					<?php if (!$isbanregister) {?>
						<a href="<?=geturl('register')?>" class="fl sizead">立即注册</a>
					<?php }?>
						<a href="<?= geturl('forget')?>" class="fl ml180 sizead" <?php if($isbanregister) { echo 'style="margin-left:136px;"';} ?>>忘记密码</a>						
					</div>
					<?php if (!$isbanthirdlogin) {?>
					<div class="clear"></div>
					<div class="mt30">
						<a class="mr80" href="<?=geturl('otherlogin/qq')?><?=($this->input->get('returnurl'))?"?returnurl=".urlencode($this->input->get('returnurl')):""?>">
							<img src="http://static.ebanhui.com/ebh/tpl/newreg/images/qqico.jpg">
						</a>
						<a class="mr80" href="<?=geturl('otherlogin/wx')?><?=($this->input->get('returnurl'))?"?returnurl=".urlencode($this->input->get('returnurl')):""?>">
							<img src="http://static.ebanhui.com/ebh/tpl/newreg/images/weixinico.jpg">
						</a>	
						<a href="<?=geturl('otherlogin/sina')?><?=($this->input->get('returnurl'))?"?returnurl=".urlencode($this->input->get('returnurl')):""?>">
							<img src="http://static.ebanhui.com/ebh/tpl/newreg/images/sianico.jpg">
						</a>					
					</div>
					 <?php }?>
				</form>
				</div>
			</div>
			
			<?php $this->display('common/newtemplate/animation');?>
		</div>
<script language="javascript">
<!--
$(function(){
	//下次自动登录
	$("#remember").toggle(function(){
		$(this).removeClass("logchoose");
		$("#cookietime").val("0");
	},function(){
		$(this).addClass("logchoose");
		$("#cookietime").val("1");
	});
	initPlaceholder();
	checkiframe();
});
/**
 * 防止登录页面被iframe嵌套
 */
function checkiframe(){
	if (self == top) {
		var theBody = document.getElementsByTagName('body')[0];
		theBody.style.display = "block";
	} else {
		top.location = self.location;
	}
}

//初始化placeholder
function initPlaceholder(){
	var n = "placeholder" in $("<input>")[0];
	if(!n){
		$(".logdiv input").each(function(){
			var s = $(this);
			var o = s.prev(".placeholder");
			var i = function() {
				0 == s.val().length ? o.show() : o.hide()
			};
			if (0 == o.length) {
				o = $('<span>');
				o.addClass("placeholder").html(s.attr("placeholder")).attr("unselectable", "on");
				s.before(o).attr("data-placeholder", s.attr("placeholder"));
				s[0].removeAttribute("placeholder");

				s.bind("focus", function(){
					$(this).parent().removeClass("errorts").addClass("shuru");
					$(this).prev(".placeholder").hide();
				});
				s.bind("blur", function(){
					$(this).parent().removeClass("shuru");
					$(this).val().length == 0 ? $(this).prev(".placeholder").show() : $(this).prev(".placeholder").hide();
				});
				s.bind("input propertychange", function() {
					$(this).prev(".placeholder").hide();
				});
			}
			var h = 3,
				p = setInterval(function() {
					--h <= 0 && clearInterval(p), i()
				}, 300);
			i()
		});
	}
}
$('#username').blur(function(){
	checkusername();
});
$('#password').blur(function(){
	checkpassword();
});
function checkusername(){
	if ($('#username').val() == '' || $('#username').val() == '用户名'){
		$('.username_msg').hide();
		$('.username_msg.cuotic').show();
		return false;
	} else {
		$('.username_msg').hide();
		$('.username_msg.zhengtic').show();
		return true;
	}
}
function checkpassword(){
	if ($("#password").val() == ''){
		$('.password_msg').hide();
		$('.password_msg.cuotic0').show();
		return false;
	} else {
		$('.password_msg').hide();
		$('.password_msg.zhengtic').show();
		return true;
	}
}
function form_submit(){
	// $('#username_msg').hide();
	// $('#password_msg').hide();
	// $('#userNpass_msg').hide();
	if((checkusername()&&checkpassword())){
		
	} else {
		return ;
	}
	// return;
	var url = '<?= geturl('login').'?inajax=1&returnurl='.(($this->input->get('returnurl') == NULL) ? '' : urlencode($this->input->get('returnurl'))).'&type='.$this->input->get('type') ?>';
	var screen = (window.screen.width || 0) + "x" + (window.screen.height || 0);
	var data = $("#form1").serialize();
	data += '&screen='+screen;
	$.ajax({
		url:url,
		data:data,
		type:'POST',
		dataType:'json',
		success	:function(json){
			if (json['code'] == 1){
				if((json['durl'] != undefined) && (json['durl'] !='')) {
					dosso(json['durl'],json["returnurl"]);
				} else {
					location.href = json["returnurl"];
				}
			} else{
				$('.password_msg').hide();
				$('.password_msg.cuotic1').show();
				$("#password").parent().addClass("errorts");
			}
			return false;
		}
	});
}
function dosso(durl,returnurl,callback) {
	window.allimgcount = 0;
	window.curimgcount = 0;
	var durls = durl.split(',');
	window.allimgcount = durls.length;
	for(var i = 0; i < durls.length; i ++) {
		var idurl = durls[i];
		var img = new Image();
		img.src = idurl+"&" + Math.random();
		$(img).appendTo("body");
		if(img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
			window.curimgcount ++;
			if(window.allimgcount == window.curimgcount && returnurl != undefined && returnurl != "") {
				location.href = returnurl;
			} else if(typeof(callback) == 'function') {
				callback();
			}
			return; // 直接返回，不用再处理onload事件
		}
		img.onload = function () { //图片下载完毕时异步调用callback函数。
			window.curimgcount ++;
			if(window.allimgcount == window.curimgcount && returnurl != undefined && returnurl != "") {
				location.href = returnurl;
			} else if(typeof(callback) == 'function') {
				callback();
			}
		};
	}
}
//-->
</script>
<?php
$this->display('common/newtemplate/footer');
?>
