<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/zzys.css<?=getv()?>" type="text/css" rel="stylesheet">
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
<style>
.lefkty{
	font-family:微软雅黑;
	background:#fff;
	padding-top:15px;
}
.lefkty em{
	line-height:28px;
	margin-left:195px;
	position:relative;
}
.lefkty em font{
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/error.png) no-repeat left center;
	display:inline-block;
	height:18px;
	padding-left:21px;
	line-height:18px;
}
.lefkty em font.right1s{
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/right1.png) no-repeat left center;
	position:absolute;
	right: -335px;
    top: -30px;
}
.required{
	color:#f80000;
	font-size:14px;
}
label .span2{
	font-size:14px;
}
.placeholder{
	color:#999;
	font-size:12px;
}
.pwd-place {
	position: absolute;
	top: 0;
	left: 211px;
	width: 100%;
	height: 100%;
	font-size: 12px;
	line-height:28px;
	color:#999;
	display:none;
}
.input-item {
	position: relative;
}
.codebox1,.codebox2{
	width:93px;
	height: 28px;
	float: left;
	border: 1px solid #ccc;
	border-left: none;
	background: #F2F2F2;
	text-align: center;
	line-height: 28px;
	color: #333;
}
.codebox1{
	cursor: pointer;
}
.codebox2 .codeboxnum{
	float: left;
	width: 20px;
	height: 28px;
}
.codebox2 .codeboxtext{
	float: left;
	height: 28px;
} 
.codehide{
	display: none;
}
.departmentul{
	display: none;
	width: 303px;
	border: 1px solid #ccc;
	border-top: 0 none;
	background-color: white;
	max-height: 210px;
	overflow-y: auto;
	position: absolute;
	left: 205px;
	top: 31px;
	z-index:99;
}
.departmentul li{
	width: 100%;
	height: 29px;
	border-bottom: 1px solid #ccc;
	line-height: 29px;
	text-indent: 10px;
	color: #666;
	cursor: pointer;
}
</style>
</head>
<body>
<!--<form id="register" name="register" action="/register.html" method="post" onsubmit="return CheckPost();">-->
<form id="register" name="register">	
	<div class="lefkty">
		<div class="option-1">
		<span class="headesedit"><span class="required">* </span>用户名：</span>
		<input id="username" class="txtbox-1" type="text" onblur="chkname(this.value)" name="username" placeholder="请输入6-20位英文、数字且字母开头的组合字符" >
		<div style="clear:both;"></div>
		<em id="name1" style="font-style:normal; padding-left:10px"></em>
	</div>
	<div class="option-1  input-item">
		<span class="headesedit"><span class="required">* </span>密码：</span>
		<input id="password" class="txtbox-1" type="password" onblur="chkpwd(this.value)" maxlength="16" name="password" placeholder="请输入6-16位字符，区分大小写">
		<span class="pwd-place"></span>
		<div style="clear:both;"></div>
		<em id="pwd1" style="font-style:normal; padding-left:10px"></em>
	</div>
	<div class="option-1 input-item">
		<span class="headesedit"><span class="required">* </span>确认密码：</span>
		<input type="password" class="txtbox-1" name="password2" maxlength="16" id="password2" onblur="chkrpwd(this.value)" placeholder="请再次输入您的密码，以便确认您的输入正确" />
		<span class="pwd-place"></span>
		<div style="clear:both;"></div>
		<em id="pwd2" style="font-style:normal; padding-left:10px"></em>
	</div>

	<div class="option-1" id="securityemail" style="display:none">
		<span class="headesedit"><span class="required">* </span>邮箱：</span>
		<input id="email" class="txtbox-1" type="text" name="email" onblur="chkemail(this.value)" placeholder="您的常用邮箱地址，便于您找回密码使用" />
		<div style="clear:both;"></div>
		<em id="email1" style="font-style:normal; padding-left:10px"></em>
	</div>
	<div class="option-1">
		<span class="headesedit">姓名：</span>
		<input id="realname" class="txtbox-1" type="text" onblur="chkrealname(this.value)" name="realname" placeholder="请输入您的姓名" />
		<div style="clear:both;"></div>
		<em id="rne" style="font-style:normal; padding-left:10px"></em>
	</div>
	<div class="option-1" id="schoolbox">
		<span class="headesedit">学校：</span>
		<input id="schoolname" class="txtbox-1" type="text" onblur="chkshool(this.value)" name="schoolname" placeholder="请输入您的学校名称" />
		<div style="clear:both;"></div>
		<em id="schn" style="font-style:normal; padding-left:10px"></em>
	</div>
	
	<div class="option-1" id="departmentbox" style="position: relative;display: none;">
		<span class="headesedit"><span class="required">* </span><span class="departmentTxt">部门：</span></span>
		<input id="department" class="txtbox-1" type="text" onblur="chkdepartment(this.value)" name="department" placeholder="请输入您的单位或部门" />
		<div style="clear:both;"></div>
		<em id="departmentbe" style="font-style:normal; padding-left:10px"></em>
		<ul class="departmentul">
			
		</ul>
	</div>
	
	<div class="option-1" id="decodebox" style="display: none;">
		<span class="headesedit"><span class="required">* </span><span class="codeTxt">部门编号：</span></span>
		<input id="departmentcode" class="txtbox-1" type="text" onblur="chkdepartmentcode(this.value)" name="departmentcode" placeholder="请输入您的单位编号或部门编号" />
		<div style="clear:both;"></div>
		<em id="codebe" style="font-style:normal; padding-left:10px"></em>
	</div>
	
	<div class="option-1" id="securityphone" style="display:none">
		<span class="headesedit"><span class="required">* </span>手机号：</span>
		<input id="mobile" class="txtbox-1" type="text" onblur="chkmobile(this.value)" name="mobile" placeholder="请输入您的电话" />
		<div style="clear:both;"></div>
		<em id="mbe" style="font-style:normal; padding-left:10px"></em>
	</div>
	<div class="option-1" id="securitycode" style="display:none">
		<span class="headesedit"><span class="required">* </span>验证码：</span>
		<input style="width:205px" id="authcode" class="txtbox-1" type="text" onblur="chkCode(this.value)" name="authcode" placeholder="请输入验证码" />
		<span class="codebox1" id="codebox">获取验证码</span>
		<span class="codebox2 codehide" id="codeboxno"><span class="codeboxnum" id="codeboxnum"></span><span class="codeboxtext">s后重新发送</span></span>
		<div style="clear:both;"></div>
		<em id="aut" style="font-style:normal; padding-left:10px"></em>
	</div>
	
	<div class="option-1" style="height:45px;">
		<span class="headesedit">性别：</span>
		<label class="checked" toid="user_add_sex0">
			<input id="user_add_sex0" class="sexadd" type="radio" checked="checked" value="0" name="sex" style="margin-left:20px;">
			<span class="span2" style="line-height:30px;">男</span>
		</label>
		<label toid="user_add_sex1" style="margin-left: 55px;">
			<input id="user_add_sex1" class="sexadd" type="radio" value="1" name="sex" style="margin-left:55px;">
			<span class="span2" style="line-height:30px;">女</span>
		</label>
		</em>
	</div>
	<input id="after" class="ckbox" type="checkbox" value="" checked="" style="display:none">
	<span style="color:#4b4949; float:left; margin-top:12px;display:none">我已阅读并同意
		<a target="_blank" href="/agreement.html">《e板会用户服务条款》</a>
	</span>
	<div class="retis retis1s">
		<input id="submit" class="enrool1s" type="button" onclick="CheckPost()" onmouseout="this.className='enrool1s'" onmouseover="this.className='ligth1s'" value="立即注册">
	</div>
	<div class="option-1 option1s">
		已有账号？<a class="etres1s" href="javascript:void(0)" onclick="showlogin()">马上登录</a>
	</div>
	<div class="dsfdl" style="display:none;"></div>
	<div class="qtlol qtlolqww" style="display:none;">
		<a href="javascript:void(0);" onclick="otherlogin('qq')" class="qqbtn"></a>
		<a href="javascript:void(0);" onclick="otherlogin('wx')" class="wxbtn"></a>
		<a href="javascript:void(0);" onclick="otherlogin('sina')" class="wbbtn"></a>
	</div>

	</div>
		<input type="hidden" value="/" name="returnurl"/>
</form>
</body>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20160523001"></script>
<script>
var ifphone = false;
var isdepartment = false;
var codeid = "";
var phonenum;
var phonename;
$.ajax({
    url: '/register/getbindstatus.html',
    async: false,
    dataType: 'json',
    type: 'get',
    success: function(data){
        if(data.error_code == 0){
        	//是否显示手机验证
           	if(data.data.mobile_register == 1){
				ifphone = true;
              	$('#securityphone').show();
              	$('#securitycode').show();
           	}else{
           		ifphone = false;
              	$('#securityphone').hide();
              	$('#securitycode').hide();
           	}
           	//是否显示第三方登录
           	if(data.data.isbanthirdlogin == 1){
        		$(".dsfdl").hide();
        		$(".qtlol").hide();
        	}else{
        		$(".dsfdl").show();
        		$(".qtlol").show();
        	}
           	
           	//企业版注册
			if(data.data.isenterprise){
				$("#schoolbox").hide();
				if(data.data.isdepartment == 1){
					isdepartment = true;
	              	$('#departmentbox').show();
	              	$('#decodebox').show();
	           	}else{
	           		isdepartment = false;
	              	$('#departmentbox').hide();
	              	$('#decodebox').hide();
	           	}
			}else{//网校版注册
				$("#schoolbox").show();
				$('#departmentbox').hide();
	            $('#decodebox').hide();
			}
			
           	if(data.data.crid == 14303){ //贵州电力
           		$(".departmentTxt").html("会员单位：");
           		$(".codeTxt").html("会员编号：");
           	}else{
           		$(".departmentTxt").html("部门：");
           		$(".codeTxt").html("部门编号：");
           	}
        }else{
            console.log("接口错误")
        }
    },
    error: function(data) {
        ifheight = 600;
        console.log(data);
    }
});
var $codebox = $("#codebox");
var $codeboxno = $("#codeboxno");
var $codeboxnum = $("#codeboxnum");
var codenum = 60;
$codebox.click(function(){
	var mobile = $.trim($("#mobile").val());
	chkmobile(mobile);
	if(mobileava){
		$.ajax({
			async: true,
			url:'/register/getsmscode.html',
			type:'post',
			dataType:'json',
			data:{'mobile':mobile},
			success:function(json){
				json.status = parseInt(json.status);
				if(json.status == 0){
					$codeboxnum.html(codenum);
					$codebox.addClass("codehide");
					$codeboxno.removeClass("codehide");
					var countdowntime = setInterval(function(){
						codenum--;
						$codeboxnum.html(codenum);
						if(codenum <= 0){
							codenum = 60;
							$codebox.removeClass("codehide");
							$codeboxno.addClass("codehide");
							clearInterval(countdowntime);
						}
					},1000);
				}else{
					$("#mbe").html("<font color=red>该手机号已注册，请换个手机号再试试！</font>");
					$(".mobile2").css("border","1px solid red");
					return false;
				}
			},
			error:function(){
				console.log('服务器返回错误!!!');
			}
		});	
	}else{
		return false;
	}
});




$(function(){	
	$("input").focus(function(){
		$(this).css("border","1px solid #5e96f5");
	});
});
$(function() {
	$('label').click(function(){
		var radioId = $(this).attr('toid');
		$('label').removeAttr('class') && $(this).attr('class', 'checked');
		$('input[type="radio"]').removeAttr('checked') && $('#' + radioId).attr('checked', 'checked');
	});
});
function showlogin(){
	try{
		window.parent.registerWindow.close();
	} catch(e){
		parent.H.get('artdialogreg').exec('close');
	}
	
	if($('#nowregister',parent.document).length>0){
		//课程介绍页面
	} else {
		try{
			parent.$.loginDialogSmall();
		} catch(e){
			parent.$.loginDialog();
		}
	}
//	parent.art.dialog({id: 'artdialogreg'}).close();
}

function CheckPost(){
	$('input[placeholder],textarea[placeholder]').each(function(){
		var that = $(this),
			text= that.attr('placeholder');
		if(that.val() === text){
			that.val('');
		}
	});
	var username = $("#username");
	phonename = username.val();
	var password = $("#password");
	var password2 = $("#password2");
	var passcode = $("#passcode");
	var after = $("#after");
	var schoolname = $('#schoolname');
	var realname = $('#realname');
	
	var email = $("#email");
	var mobile = $('#mobile');
	var authcode = $('#authcode');
	
	var departmentcode = $("#departmentcode");
	var department = $("#department");
	
	
	//帐号验证
	chkname(username.val());
	chkpwd(password.val());
	chkrpwd(password2.val());
	chkshool(schoolname.val());
	chkrealname(realname.val());
	chkdepartment(department.val());
	chkdepartmentcode(departmentcode.val());
	
	if(ifphone == true){
//		chkemail(email.val());
		chkmobile(mobile.val());
		chkCode(authcode.val());
		phonenum = mobile.val();
//		if($("#email").val()==''){
//			email = false;
//		}else{
//			if(emailava){
//				email = true;
//			}else{
//				email = false;
//			}
//		}
		
		if(mobileava){
			mobile = true;
		}else{
			mobile = false;
		}
		
		if(chkcodeava){
			chkcode = true;
		}else{
			chkcode = false;
		}
		
		var htmlphone = '<div>'
		htmlphone += '<div style="font-weight: 900;width:450px;height:70px;padding-left:50px;background:url(http://static.ebanhui.com/ebh/tpl/default/images/greengou.gif) left center no-repeat;font-size:18px;">'
		htmlphone += '<p style="margin-left:20px;">恭喜您，注册成功！您的网校登录账号是:</p>'
		htmlphone += '<p id="phoneaccount" style="color: #ff9900;margin-left:20px;">'+phonename+'</p>'
		htmlphone += '<p style="margin-left:20px;">也可以通过已绑定手机号:<span style="color: #ff9900;">'+phonenum+'</span>进行登录！</p>'  
		htmlphone += '</div>'
		
		htmlphone += '<p style="margin: 20px 0 0 70px;color:#ccc;font-size:12px;">为了您的账号安全，建议您立即进行<span style="color:#ff0000;">安全设置</span></p>'
		htmlphone += '<a href="/homev2/safety/index.html" style="margin:30px 0 0 70px;display:inline-block;font-size:20px;color:#fff;width:152px;height:42px;line-height:42px;text-align:center;background:#0099ff;">立即设置</a>'
		htmlphone += '<a href="/myroom.html" style="margin:30px 0 0 70px;display:inline-block;font-size:20px;color:#333;width:152px;height:42px;line-height:42px;text-align:center;background:#d7d7d7;">进入学习</a>'
		htmlphone += '</div>';
		
	}else{
		var htmlphone1 = '<div>'
		htmlphone1 += '<div style="font-weight: 900;width:450px;height:70px;padding-left:50px;background:url(http://static.ebanhui.com/ebh/tpl/default/images/greengou.gif) left center no-repeat;font-size:18px;">'
		htmlphone1 += '<p style="margin-left:20px;">恭喜您，注册成功！您的网校登录账号是:</p>'
		htmlphone1 += '<p id="phoneaccount" style="color: #ff9900;margin-left:20px;">'+phonename+'</p>'
		htmlphone1 += '<p style="margin-left:20px;">也可以通过<a href="/homev2/safety/index.html" style="color:#ff0000;text-decoration:underline;">绑定手机号</a>来进行登录！</p>'  
		htmlphone1 += '</div>'
		htmlphone1 += '<p style="margin: 20px 0 0 70px;color:#ccc;font-size:12px;">为了您的账号安全，建议您立即进行<span style="color:#ff0000;">安全设置</span></p>'
		htmlphone1 += '<a href="/homev2/safety/index.html" style="margin:30px 0 0 70px;display:inline-block;font-size:20px;color:#fff;width:152px;height:42px;line-height:42px;text-align:center;background:#0099ff;">立即设置</a>'
		htmlphone1 += '<a href="/myroom.html" style="margin:30px 0 0 70px;display:inline-block;font-size:20px;color:#333;width:152px;height:42px;line-height:42px;text-align:center;background:#d7d7d7;">进入学习</a>'
		htmlphone1 += '</div>';
	}
	
	if(usernameava){
		username = true;
	}else{
		username = false;
	}
	
	if(passwordava){
		password = true;
	}else{
		password = false;
	}
	
	if(passwordcava){
		password2 = true;
	}else{
		password2 = false;
	}
	
	if(schoolnameava){
		schoolname = true;
	}else{
		schoolname = false;
	}
	
	if(realnameava){
		realname = true;
	}else{
		realname = false;
	}
	var sex;
	if($("#user_add_sex0").is(':checked')){
		sex = 0;
	}else if($("#user_add_sex1").is(':checked')){
		sex = 1;
	}
	
	var ajaxdatas = {};
	if(isdepartment){
		if(ifphone == true){
			if(username&&password&&password2&&schoolname&&realname&&mobile&&chkcode&&departmentcodeava){
				ajaxdatas = {
					'username': $("#username").val(),
					'password': $('#password').val(),
					'email': $("#email").val(),
					'realname': $("#realname").val(),
					'schoolname': $("#schoolname").val(),
					'mobile': $("#mobile").val(),
					'sex': sex,
					'department' : $("#department").val(),
					'departmentid' : codeid
				};
			}else{
				return false;
			}
		}else{
			if(username&&password&&password2&&schoolname&&realname&&departmentcodeava){
				ajaxdatas = {
					'username': $("#username").val(),
					'password': $('#password').val(),
					'realname': $("#realname").val(),
					'schoolname': $("#schoolname").val(),
					'sex': sex,
					'department' : $("#department").val(),
					'departmentid' : codeid
				};
			}else{
				return false;
			}
		}
	}else{
		if(ifphone == true){
			if(username&&password&&password2&&schoolname&&realname&&mobile&&chkcode){
				ajaxdatas = {
					'username': $("#username").val(),
					'password': $('#password').val(),
					'email': $("#email").val(),
					'realname': $("#realname").val(),
					'schoolname': $("#schoolname").val(),
					'mobile': $("#mobile").val(),
					'sex': sex
				};
			}else{
				return false;
			}
		}else{
			if(username&&password&&password2&&schoolname&&realname){
				ajaxdatas = {
					'username': $("#username").val(),
					'password': $('#password').val(),
					'realname': $("#realname").val(),
					'schoolname': $("#schoolname").val(),
					'sex': sex
				};
			}else{
				return false;
			}	
		}
	}
	$.ajax({
		type:"post",
		url:"/register.html",
		async:false,
		dataType:'json',
		data:ajaxdatas,
		success:function(json){
			window.parent.registerWindow.close();
			top.dialog({
			  	title:'注册成功',
			  	content:ifphone?htmlphone:htmlphone1,
			  	width: 500,
			  	height:	200,
			  	onclose:function(){
			  		window.location.href = "/";
			  	}
			}).showModal();
		},
		error:function(json){}
	});
}

var usernameava;
function chkname(username){
	usernameava = false;
	if (username == '') {
		$("#name1").html("<font color=red>用户名不能为空</font>");
		$("#username").css("border","1px solid red");
	} else {
		var namereg = /^[a-zA-Z][a-z0-9A-Z_]{5,19}$/;
		if(!username.match(namereg)){
			$("#name1").html("<font color=red>6-20位以字母开头且不包含特殊字符！</font>");
			$("#username").css("border","1px solid red");
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
						$("#name1").html("<font color=red>用户名已被占用，<a style='text-decoration:none;color:#5e96f5;' href='javascript:void(0)' onclick='showlogin()'>登录？</a></font>");
						$("#username").css("border","1px solid red");
					}else{
						$("#name1").html("<font class='right1s'></font>");
						$("#username").css("border","1px solid #5e96f5");
						usernameava = true;
					}
				}
			});
		}
	}
}
var schoolnameava;
function chkshool(schoolname){
	schoolnameava = true;
	if ($.trim(schoolname) == '') {
		$("#schoolname").css("border","1px solid #dcdcdc");
	} else {
		$("#schn").html("<font class='right1s'></font>");
		$("#schoolname").css("border","1px solid #5e96f5");
	}
}
var passwordava;
function chkpwd(password){
	passwordava = false;
	if (password == '') {
		$("#pwd1").html("<font color=red>密码不能为空</font>");
		$("#password").css("border","1px solid red");
	} else if (document.getElementById('password').value.length < 6) {
		$("#pwd1").html("<font color=red>密码位数不正确，请重新输入</font>");
		$("#password").css("border","1px solid red");
	} else if($('#password').val().indexOf(' ') != -1){
		$("#pwd1").html("<font color=red>密码中不能包含空格，请重新输入</font>");
		$("#password").css("border","1px solid red");
	}else {
		$("#pwd1").html("<font class='right1s'></font>");
		$("#password").css("border","1px solid #5e96f5");
		passwordava = true;
	}
}
var passwordcava;
function chkrpwd(password2){
	passwordcava = false;
	if (password2 == '') {
		$("#pwd2").html("<font color=red>请再次输入您的密码</font>");
		$("#password2").css("border","1px solid red");
	} else if (document.getElementById('password').value != password2){
		$("#pwd2").html("<font color=red>两次密码输入不一致，请重新输入</font>");
		$("#password2").css("border","1px solid red");
	} else {
		$("#pwd2").html("<font class='right1s'></font>");
		$("#password2").css("border","1px solid #5e96f5");
		passwordcava = true;
	}
}
function checkcode(){
	var code = $('#passcode').val();
	var flag = false;
	$.ajax({
		url:"<?=geturl('verify/checkcode')?>",
		data:{'code':code},
		async:false,
		success:function(data){
			if(data=='1' || data==true){
				$("#passcode1").html("");
				flag = true;
			}
			else{
				$("#passcode1").html("<font color=#FF0000>验证码不正确！</font>");
			}
		}
	});return flag;
}
var emailava;
function chkemail(email){
	emailava = false;
	if(email == ""){
		$("#email1").html("<font color=#FF0000>邮箱不能为空</font>");
		$("#email").css("border","1px solid red");
		return false;
	}else{
		var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(!emailreg.test(email)){
			$("#email1").html("<font color=#FF0000>请填写有效的邮箱地址</font>");
			$("#email").css("border","1px solid red");
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
						$("#email1").html("<font color=red>邮箱已被占用</font>");
						$("#email").css("border","1px solid red");
					}else{
						$("#email1").html("<font class='right1s'></font>");
						$("#email").css("border","1px solid #5e96f5");
						emailava = true;
					}
				}
			})
		}
	}
}
var realnameava;
function chkrealname(realname){
	realnameava = true;
	var reg = /^[\u4E00-\uFA29\uE7C7-\uE7F3\s]{1,20}$/;
	if ($.trim(realname) == '') {
		$("#realname").css("border","1px solid #dcdcdc");
	} else if(!reg.test(realname)){
		$("#rne").html("<font color=red>请填写真实的姓名！</font>");
		$("#realname").css("border","1px solid red");
		realnameava = true;
	} else {
		$("#rne").html("<font class='right1s'></font>");
		$("#realname").css("border","1px solid #5e96f5");
	}
}


var scrollnum = 1,isajax = true;
//点击空白部分隐藏智能搜索栏
$(document).click(function(event){
	var $departmentul = $(".departmentul");
	var $department = $('#department');
	if(!$departmentul.is(event.target) && $departmentul.has(event.target).length === 0 && !$department.is(event.target) && $department.has(event.target).length === 0){
		$departmentul.hide();
	}
	scrollnum = 1;
	isajax = true;
});

//li事件委托
$(".departmentul").on("click","li",function(){
	$('#department').val($(this).html());
	$(".departmentul").hide();
	scrollnum = 1;
	isajax = true;
});

$(".departmentul").scroll(function(){
  	var viewH =$(this).height(),//可见高度
 	contentH =$(this).get(0).scrollHeight,//内容高度
 	scrollTop =$(this).scrollTop();//滚动高度
	if(scrollTop/(contentH -viewH) == 1){ //到达底部95%时,加载新内容
		scrollnum++;
		if(isajax){
			$.ajax({
				type:"GET",
				url:'/dept.html',
				data:{'deptname':$('#department').val(),'number':8*scrollnum},
				dataType:'json',
				async:true,
				success:function(json){
					if(json.errno == 0){
						var datas = json.data;
						if(datas.length){
							$(".departmentul").empty();
							var oli = "";
							for(var i=0;i<datas.length;i++){
								oli += "<li>"+datas[i]+"</li>"
							}
							$(".departmentul").append(oli);
							$(".departmentul").show();
						}else{
							$(".departmentul").hide();
						}
						
						if(datas.length < (8*scrollnum)){
							isajax = false;
						}
					}
				},
				error:function(){
					console.log("接口错误！");
				}
			});
		}
    }
});
 
//监听输入框，显示智能搜索框
$('#department').bind('input propertychange', function() {
	searchdepartment($(this).val());
});
function searchdepartment(val){
	if(val){
		$.ajax({
			type:"GET",
			url:'/dept.html',
			data:{'deptname':val,'number':8},
			dataType:'json',
			async:true,
			success:function(json){
				if(json.errno == 0){
					var datas = json.data;
					if(datas.length){
						$(".departmentul").empty();
						var oli = "";
						for(var i=0;i<datas.length;i++){
							oli += "<li>"+datas[i]+"</li>"
						}
						$(".departmentul").append(oli);
						$(".departmentul").show();
					}else{
						$(".departmentul").hide();
					}
				}
			},
			error:function(){
				console.log("接口错误！");
			}
		});
	}else{
		$(".departmentul").hide();
	}
}
function chkdepartment(department){
	if(department == ""){
		$("#departmentbe").html("<font color=red>请填写部门！</font>");
		$("#department").css("border","1px solid red");
	}else{
		$("#departmentbe").html("");
		$("#department").css("border","1px solid #5e96f5");
	}
}



var departmentcodeava;
function chkdepartmentcode(departmentcode){
	departmentcodeava = false;
	if(departmentcode == ''){
		$("#codebe").html("<font color=red>请填写部门编号！</font>");
		$("#departmentcode").css("border","1px solid red");
	}else{
		if ($('#department').val() == "") {
			$("#codebe").html("<font color=red>请先填写部门！</font>");
			$("#departmentcode").css("border","1px solid red");
			$("#departmentcode").val('');
		} else {
			$.ajax({
				type:"GET",
				url:'/dept/verify.html',
				data:{'code':departmentcode,'deptname':$("#department").val()},
				dataType:'json',
				async:false,
				success:function(json){
					if(json.errno == 0){
						$("#codebe").html("<font class='right1s'></font>");
						$("#departmentcode").css("border","1px solid #5e96f5");
						departmentcodeava = true;
						codeid = json.data;
					}else{
						$("#codebe").html("<font color=red>"+json.msg+"</font>");
						$("#departmentcode").css("border","1px solid red");
					}
				},
				error:function(){
					console.log("接口错误！");
				}
			});
		}
	}
}



var mobileava;
function chkmobile(mobile){
	mobileava = false;
	var reg = /^1[3-8]{1}\d{9}$/; 
	if ($.trim(mobile) == '') {
		$("#mbe").html("<font color=red>请填写手机号！</font>");
		$("#mobile").css("border","1px solid red");
	} else if(!reg.test(mobile)){
		$("#mbe").html("<font color=red>请填写正确的手机号！</font>");
		$("#mobile").css("border","1px solid red");
		mobileava = false;
	} else {
		$("#mbe").html("<font class='right1s'></font>");
		$("#mobile").css("border","1px solid #5e96f5");
		mobileava = true;
	}
}



var chkcodeava;
function chkCode(authcode){  //验证码
	chkcodeava = false;
	if ($.trim(authcode) == '') {
		$("#aut").html("<font color=red>请填写手机验证码！</font>");
		$("#authcode").css("border","1px solid red");
	} else {
		//这里的验证码 还需要做对比
		$.ajax({
			type:"POST",
			url:'/register/smscheck.html',
			data:{'smscode':authcode,'mobile':$("#mobile").val()},
			dataType:'json',
			async:false,
			success:function(json){
				if(json.status == 0){
					$("#aut").html("<font class='right1s'></font>");
					$("#authcode").css("border","1px solid #5e96f5");
					chkcodeava = true;
				}else{
					$("#aut").html("<font color=red>验证码错误！</font>");
					$("#authcode").css("border","1px solid red");
				}
			},
			error:function(){
				console.log("接口错误！");
			}
		});
	}
}






function revalidate(){
	var date = new Date();
	$("#validate").attr("src","<?=geturl('verifycode/getCode')?>?"+date.getTime());
}
function otherlogin(w){
	var href = top.location.href;
	var returnurl = encodeURIComponent(href);
	parent.location.href="/otherlogin/"+w+".html?returnurl="+returnurl;
}

function placeholder(){
	function isPlaceholer(){
		var input = document.createElement("input");
		return "placeholder" in input;
	}
	if( isPlaceholer()==false && !('placeholder' in document.createElement('input')) ){
		$('.pwd-place').click(function(){
			$(this).hide();
			$(this).prev('input').focus();
		})
		$('input[placeholder],textarea[placeholder]').each(function(){
			var that = $(this),
					text= that.attr('placeholder');
			if(that.val()===""){
				if(that.attr("type") == "password"){
					$el = that.next('.pwd-place');
					$el.html(text);
					$el.show();
				}else {
					that.val(text).addClass('placeholder');
				}
			}
			that.focus(function(){
				$el = that.next('.pwd-place');
				if($el.html() == text){
					$el.html("");
					$el.hide();
				}
				if(that.val()===text) {
					that.val("").removeClass('placeholder');
				}
			}).blur(function(){
				$el = that.next('.pwd-place');
				if(that.val()==="") {
					if (that.attr("type") == "password") {
						$el.html(text);
						$el.show();
					}else {
						that.val(text).addClass('placeholder');
					}
				}
			}).closest('form').submit(function(){
				if(that.val() === text){
					that.val('');
				}
			});
		});
	}
}
$(document).ready(function() {
	placeholder();
});
</script>
</html>
