<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="http://static.ebanhui.com/ebh/tpl/default/css/base.css?v=20150417" type="text/css" rel="stylesheet">
		<link href="http://static.ebanhui.com/ebh/tpl/2012/css/logmi.css?v=20150417" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
		<link href="http://static.ebanhui.com/ebh/tpl/default/css/home.css?v=20150417" rel="stylesheet" type="text/css" />
		<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css?v=20150417" rel="stylesheet" type="text/css" />
		<title>用户登录</title>
		<style>
			*{
				padding: 0;
				margin: 0;
				font-family: "微软雅黑";
			}
			html{
				width: 100%;
				height: 100%;
			}
			body{
				width: 100%;
				height: 100%;
			}
			.container{
				width: 100%;
				height: 100%;
				min-height: 960px!important;
				position: relative; 
				background: #0f97f9 url(http://static.ebanhui.com/ebh/tpl/2016/images/bg_17_7_27.png) no-repeat;
			}
			.kgrewfbafen{
				width: 100%;
			    height: 760px;
			    margin: 0 auto;
			    background: url(http://static.ebanhui.com/ebh/tpl/2016/images/zhu1_17_7_27.png) no-repeat;
			    position: relative;
			    background-position: 338px 164px;
			}
			.gierg{
				width: 100%;
				height: 760px;
			    background: url(http://static.ebanhui.com/ebh/tpl/2016/images/qiu_17_7_27.png) no-repeat;
			    position: relative;
			    background-position:90px 121px;
			}
			.kgrewfmag{
				width: 1200px;
				margin: 0 auto;
				height: 760px;
				position: relative;
			}
			.kgrewf{
				width: 423px;
				height: 488px;
				border-radius: 10px;
				background: #e7f2fd;
				border: none;
				top: 170px;
				right: 0px;
				padding: 0;
				
			}
			
			#form1{
				margin: 0 45px;
			}
			
			.footer p{
				margin-top: 200px;
			}
			.usercss{
				font-size: 25px;
				color: #0c80e8;
				text-align: center;
				margin-top: 70px;
			}
			.klouery,.rgkegd{
				background: none;
				-webkit-appearance: none;
				-moz-appearance: none;
				-o-appearance: none;
				appearance: none;
				outline:none;
				width: 100%;
				text-indent: 0px;
    			font-weight: 500;
				font-size: 16px;
			    color: #c3c9ce;
			    margin-top: 0;
			}
			
			.borbottom{
				display: block;
				width: 100%;
				height: 0;
				border-bottom: 1px solid #93999e;
			}
			.dengls{
				width: 330px;
				height: 44px;
				background: #0c80e8;
				color: #fff;
				font-size: 20px;
				line-height: 44px;
				border-radius: 22px;
				margin-top: 20px;
				border:0;outline:none;
			}
			.newuserbut{
				color: #61a1ed;
				font-size: 16px;
			}
			a.newuserbut:visited {
			    color: #61a1ed;
			    text-decoration: none;
			}
			.jmima{
				font-size: 16px;
				text-align: right;
			}
			@keyframes move_wave {
			    0% {
			        transform: translateX(0) translateZ(0) scaleY(1)
			    }
			    50% {
			        transform: translateX(-25%) translateZ(0) scaleY(0.55)
			    }
			    100% {
			        transform: translateX(-50%) translateZ(0) scaleY(1)
			    }
			}
			.waveWrapper {
			    overflow: hidden;
			    position: absolute;
			    left: 0;
			    right: 0;
			    bottom: 0;
			    /*top: 0;*/
			   	height: 140px;
			    margin: auto;
			}
			.waveWrapperInner {
			    position: absolute;
			    width: 100%;
			    overflow: hidden;
			    height: 100%;
			    bottom: -1px;
			    /*background-image: linear-gradient(to top, #0f95f7 20%, #0f95f7 80%);*/
			}
			.bgTop {
			    z-index: 15;
			    opacity: 0.5;
			}
			.bgToptop{
				position: absolute;
			    width: 100%;
			    overflow: hidden;
			    height: 100%;
			    bottom: -1px;
				z-index: 20;
			}
			.bgToptops{
				position: absolute;
			    width: 100%;
			    overflow: hidden;
			    height: 100%;
			    bottom: -1px;
				z-index: 20;
			}
			.bgToptop p{
				line-height: 230px;
				text-align: center;
				color: #7a7a7a;
			}
			.bgToptops p{
				line-height: 260px;
				text-align: center;
				color: #7a7a7a;
			}
			.bgMiddle {
			    z-index: 10;
			    opacity: 0.75;
			}
			.bgBottom {
			    z-index: 5;
			}
			.wave {
			    position: absolute;
			    left: 0;
			    width: 200%;
			    height: 100%;
			    background-repeat: repeat no-repeat;
			    background-position: 0 bottom;
			    transform-origin: center bottom;
			}
			.waveTop {
			    background-size: 50% 100px;
			}
			.waveAnimation .waveTop {
			  animation: move-wave 3s;
			   -webkit-animation: move-wave 3s;
			   -webkit-animation-delay: 1s;
			   animation-delay: 1s;
			}
			
			.waveMiddle {
			    background-size: 50% 120px;
			}
			.waveAnimation .waveMiddle {
			    animation: move_wave 10s linear infinite;
			}
			.waveBottom {
			    background-size: 50% 100px;
			}
			.waveAnimation .waveBottom {
			    animation: move_wave 15s linear infinite;
			}
			.footer{
				width: 100%;
				height: 200px;
				position: absolute;
				bottom:0px;
				text-align: center;
				color: #fff;
				font-size: 12px;
			}
			.gkergjs{
				height: 92px;
			}
			.blurclassuser{
				background: url(http://static.ebanhui.com/ebh/tpl/2016/images/user_17_7_271.png) no-repeat;
				background-position: 5px 12px;
			}
			.blurclassmima{
				background: url(http://static.ebanhui.com/ebh/tpl/2016/images/mima1_17_7_27.png) no-repeat;
				background-position: 5px 12px;
			}
			.blurclass{
				background: url(http://static.ebanhui.com/ebh/tpl/2016/images/deng2_17_7_27.png) no-repeat;
				
			}
			.focusclassuser{
				background: url(http://static.ebanhui.com/ebh/tpl/2016/images/user_17_7_27.png) no-repeat;
				background-position: 5px 12px;
			}
			.focusclassmima{
				background: url(http://static.ebanhui.com/ebh/tpl/2016/images/mima_17_7_27.png) no-repeat;
				background-position: 5px 12px;
			}
			.focusclass{
				background: url(http://static.ebanhui.com/ebh/tpl/2016/images/deng1_17_7_27.png) no-repeat;
			}
			.login_mid .tips_close{
				right: 23px;
			}
			.klouery, .rgkegd{
				color: #666;
			}
			#form1 .left-icon{
				width: 30px;
				height: 42px;
				float: left;
			}
			#form1 .right{
				width: 300px;
				height: 42px;
				float: left;
			}
			.usernamecont{
				display: block;
				height: 42px;
				margin-top: 20px;
			}
			.passwordcont{
				display: block;
				height: 42px;
				margin-top: 20px;
			}
			
			#useriocn,#passwordiocn{
				width: 30px;
				height: 42px;
				display: block;
			}
			input:-webkit-autofill {
				-webkit-box-shadow: 0 0 0px 1000px #e7f2fd inset;
				
			}
			.errorLayer .login_top{
				background: none;
				height: 0;
			}
			.errorLayer .login_mid {
			    background: #e7f2fd;
			    overflow: hidden;
			    padding: 8px 10px;
			    position: relative;
			    border: 1px solid #cccccc;
			    border-radius: 3px;
			    box-shadow: 0 0 8px 0 rgba(232, 237, 250, .6), 0 2px 4px 0 rgba(232, 237, 250, .5);
			}
			.errorLayer .login_bot{
				background: none;
			}
	         /*下箭头*/
        .bottom{
            width:20px;
            height:20px;
            position:absolute;
            left: 30px;
    		top: 41px;
            z-index: 2;/*兼容ie8-*/
            background: none;
        }
        .bottom-arrow1,.bottom-arrow2{
            width:0;
            height:0;
            display:block;
            position:absolute;
            left:0;
            top:0;
            z-index: 5;/*兼容ie8-*/
            border-bottom:10px transparent dashed;
            border-left:10px transparent dashed;
            border-right:10px transparent dashed;
            border-top:10px #e7f2fd solid;
            overflow:hidden;
        }
        .bottom-arrow1{
            top:1px;/*重要*/
            border-top:10px #cccccc solid;
        }
        .bottom-arrow2{
            border-top:10px #e7f2fd solid;
        }
		</style>
	</head>

	<body style="background:#ffffff">

		<div class="brituh container">
			<div class="gierg">
				<div class="kgrewfbafen">
				<div class="kgrewfmag">	
				<div class="kgrewf">
					
					<p class="usercss">用户登录</p>
					<?php
$url = geturl('slogin') . '?inajax=1&returnurl=' . $this->input->get('returnurl');
?>
						<form id="form1" method="post" name="form1" action="<?= $url ?>" onsubmit="form_submit(); return false;">
							<div class="usernamecont">
								<div class="left-icon">
									<i class="blurclassuser" id="useriocn"></i>
								</div>
								<div class="right">
									<input type="hidden" name="loginsubmit" value="1" />
									<input name="username" type="text" id="username" placeholder="手机号/邮箱"  value="" class="klouery "  />
								</div>
							</div>
							<i class="borbottom"></i>
							<div class="passwordcont">
								<div class="left-icon">
									<i class="blurclassmima" id="passwordiocn"></i>
								</div>
								<div class="right">
									<input name="password" type="password" id="password" placeholder="密码"  value="" class="rgkegd">
								</div>
							</div>
							
							
							<i class="borbottom"></i>
							<div class="gkergw">
								<input type="checkbox" name="cookietime" class="blurclass" value="1" />自动登录
								<!--<a href="/forget.html">忘记密码？</a>-->
							</div>
							<div class="gkergjs">
								<input class="dengls" type="submit" name="button" id="button" value="登录" />
								<!--<input class="gehger" type="button" id="button" value="" onclick="location.href='/register.html'" />-->
							</div>
							<div class="gkergjs">
								<a style="float: left;" class="newuserbut" href="#" onclick="location.href='/register.html'">新用户注册</a>
								<a style="float: right;" class="jmima" href="/forget.html">忘记密码？</a>
								<!--<input class="gehger" type="button" id="button" value="新用户注册" onclick="location.href='/register.html'" />-->
							</div>
							<!--<div style="width:270px;" class="qtlol">
								<span style="color:#999;height: 20px;line-height: 20px;">用其他账号登录：</span>
								<a style="width:auto;display: block;line-height: 20px;text-decoration: none;cursor: pointer;" href="/otherlogin/qq.html">
									<img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg?v=20150417">
									<span style="color:#999;float:left;">QQ登录</span>
								</a>
								<a style="width:auto;display: block;line-height: 20px;text-decoration: none;cursor: pointer;" href="/otherlogin/sina.html">
									<img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0925.jpg?v=20150417">
									<span style="color:#999;float:left;">新浪微博登录</span>
								</a>
							</div>-->
						</form>
						<div id="mod_login_tip" class="errorLayer" style="visibility: visible; position: absolute; left: 72px; z-index: 1010; display:none;">
							<div class="login_top"></div>
							<div class="login_mid">
								<div id="mod_login_close" class="tips_close">x</div>
								<div class="conn">
									<p id="mod_login_title" class="bigtxt"></p>
								</div>
							</div>
							<div class="login_bot">
								<div class="arrow-bottom arrow-box" >
							        <b class="bottom"><i class="bottom-arrow1"></i><i class="bottom-arrow2"></i></b>
							    </div>
							</div>
						</div>
					</div>
					</div>
				</div>

			</div>
			<div class="waveWrapper waveAnimation">
			<div class="bgToptop">
			    <p>
			    	<?php
$room = Ebh::app()->room->getcurroom();
$icp = '浙B2-20160787&nbsp;&nbsp;Copyright &copy; 2011-'.date('Y').' ebh.net All Rights Reserved';
if(!empty($room) && !empty($room['icp']))
	$icp = $room['icp'];
?>
			    	<?= $icp ?></p>
			  </div>
			  <div class="bgToptops">
			  	<p>
			  	<?php debug_info();?>
<!-- 统计代码开始 -->
<?php
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
	echo $systemsetting['analytics'];
} else {
	EBH::app()->lib('Analytics')->get('baidu');
}
?>  </p>
			  </div>
			  <div class="waveWrapperInner bgTop">
			    <div class="wave waveTop" style="background-image: url('http://static.ebanhui.com/ebh/tpl/2016/images/wave_top_17_7_27.png')"></div>
			  </div>
			  <div class="waveWrapperInner bgMiddle">
			    <div class="wave waveMiddle" style="background-image: url('http://static.ebanhui.com/ebh/tpl/2016/images/wave_top_17_7_271.png')"></div>
			  </div>
			  <div class="waveWrapperInner bgBottom">
			    <div class="wave waveBottom" style="background-image: url('http://static.ebanhui.com/ebh/tpl/2016/images/wave_top_17_7_272.png')"></div>
			  </div>
			</div>
			
		</div>
		<script>
			$(function() {
				$("#mod_login_close").click(function() {
					$("#mod_login_tip").fadeOut();
				});
				$(".lefad .toptu .biantu,.lefad .toptu .maitu,.lefad .bottomtu .biantu,.lefad .bottomtu .maitu,.lefad .bottomtu .biantu2,.lefad .toptu,.lefad .bottomtu ").hover(function() {
						$(this).addClass("hover-trigger");
						$(this).siblings().stop().animate({
							opacity: '0.5'
						}, 1000);
					},
					function() {
						$(this).removeClass("hover-trigger ");
						$(this).siblings().stop().animate({
							opacity: '1'
						}, 1000);
					});
					
				$('#username').focus(function(){
					$('#useriocn').removeClass('blurclassuser').addClass('focusclassuser')
				})
				$('#username').blur(function(){
					$('#useriocn').removeClass('focusclassuser').addClass('blurclassuser')
				})
				$('#password').focus(function(){
					$('#passwordiocn').removeClass('blurclassmima').addClass('focusclassmima')
				})
				$('#password').blur(function(){
					$('#passwordiocn').removeClass('focusclassmima').addClass('blurclassmima')
				})
			});
			//错误提示
			function tipname_message(message, high) {
				if($("#mod_login_tip").is(":visible")) {
					$("#mod_login_tip").animate({
						"top": high
					}, " slow", "swing", function() {
						$("#mod_login_tip").fadeOut("fast", function() {
							$("#mod_login_title").text(message);
							$("#mod_login_tip").fadeIn("slow");
						});
					});
				} else {
					$("#mod_login_title").text(message);
					$("#mod_login_tip").css("top", high).fadeIn("slow");
				}
			}

			function form_submit() {
				//清空之前错误提示
				$("#mod_login_tip").fadeOut();
				if($('#username').val() == '' || $('#username').val() == '') {
					tipname_message('帐号不能为空', 81);
					//alert('用户名不能为空');
					$('#username').focus();
					return;
				}
				
				if($("#password").val() == '') {
					tipname_message('密码不能为空', 145);
					$('#password').focus();
					return;
				}
				var url = '<?= geturl('slogin').'?inajax=1&returnurl='.(($this->input->get('returnurl') == NULL) ? '' : urlencode($this->input->get('returnurl'))).'&type='.$this->input->get('type') ?>';
				$.ajax({
					url: url,
					data: $("#form1").serialize(),
					type: 'POST',
					dataType: 'json',
					success: function(json) {
						if(json['code'] == 1) {
							if((json['durl'] != undefined) && (json['durl'] !='')) {
								dosso(json['durl'], json["returnurl"]);
							} else {
								location.href = json["returnurl"];
							}
						} else {
							tipname_message(json["message"], 65);
						}
						return false;
					}
				});
			}

			function dosso(durl, returnurl, callback) {
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
				img.onload = function() { //图片下载完毕时异步调用callback函数。
					
					if(returnurl != undefined && returnurl != "") {
						location.href = returnurl;
					} else if(typeof(callback) == 'function') {
						callback();
					}
				};
			}
		</script>
<!--尾部!-->

<div style="clear:both;"></div>
<!--<div class="fldty">
<div style="text-align:center">
  <span style="color:#666"><?= $icp ?></span>&nbsp;&nbsp;    <br>
    <br>
</div>
</div>-->

<!-- 统计代码结束 -->
</body>
</html>