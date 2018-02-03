<?php $this->display('common/site_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/open.css" rel="stylesheet" type="text/css" />
<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg) repeat-y scroll 0 0; height:auto;">
<div class="main"><div class="aed"><p>欢迎开通【<?= $roominfo['crname'] ?>】服务</p></div>
  <div class="slst"><p style="	font-weight: bold;padding-top: 15px;padding-left: 35px; color:#666666">帐号开通流程： </p>
  <form method="post" action="/sitecp.php?action=classactive" onsubmit="return checkform()">
   <input type="hidden" name="op" value="firststep">
    <label>
    <input class="tianxie" style="cursor:pointer" type="button" name="tianxie" value="1、填写个人资料" />
    <img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />    </label>
    <label>
    <input class="xuanze" style="cursor:pointer" type="button" name="xuanze" value="2、选择开通方式" />
	<img src="http://static.ebanhui.com/ebh/tpl/2012/images/tubiao.png" width="7" height="9" />
    </label>
    <label>
    <input class="kaitong" style="cursor:pointer" type="button" name="kaitong" value="3、开通成功" />
    </label>
 <div class="fot"><div class="xinxi"><p style="color:#015cab; font-size:14px; font-weight: bold; line-height:51px; margin-left:30px;">帐号信息<span style="color:#666; font-weight:normal; font-size:12px; margin-left:5px;">(如果已经注册e板会的用户，请选择“有”输入您已注册的账户；没有请选择“无”输入您要注册的账号及密码)</span></p></div>
 <div class="feled" style="padding-top:20px; padding-left:86px; _margin-left:1px; padding-bottom:10px;">
 <label>是否有e板会帐号：</label>
 <input id="isuser" onclick="isuserf(1);" type="radio" name="isuser" value="1" /><label for="isuser">有</label>&nbsp;&nbsp;&nbsp;&nbsp;
 <input id="unuser" onclick="isuserf(0);" type="radio" name="isuser" value="0" checked="checked" /><label for="unuser">无</label>
 </div>
 <div class="feld">
 <span style="color:#FF0000">* </span>e板会帐号：
 <input class="truename" type="text" id="username" onblur="checkname()" name="username" maxlength="16" style="font-size: 16px;font-weight: bold;"/>
 </div>
 <div id="usernametip" class="kaitongtishi"></div>
 <div style="clear:both;"></div>
  <div id="passdiv" class="feld">
 <label>
<span style="color:#FF0000">* </span>密码：
 <input class="truename" type="password" onchange="passwordchecku();"  id="password" name="password" maxlength="16" />
 </label>
 </div>
  <div id="passwordtip" class="kaitongtishi"></div>
  <input id="getBtn" style="cursor:pointer;margin-left: 320px;margin-bottom:20px;" type="button" name="button" class="next" value="下一步" />
  <div class="feld" id="passagaindiv">
 <label>
<span style="color:#FF0000">*</span>确认密码：
 <input class="truename" type="password" onchange="passwordagaincheck();" id="passwordagain" name="passwordagain" maxlength="16" />
 </label>
 </div>
 <div id="passwordagaintip" class="kaitongtishi"></div>
 <div id="more">
 <img style="padding-top:5px; padding-bottom:10px;" src="http://static.ebanhui.com/ebh/tpl/2012/images/ziliao1.gif" />
 <div class="feld"> <label>
 <span style="color:#FF0000">*</span> 真实姓名：
 <input class="truename" type="text" id="truename" onchange="emptychange('truename','truenametip','请填写您的真实姓名。');" name="truename" maxlength="20" />
 </label>
 </div>
 <div id="truenametip" class="kaitongtishi"></div>
 <div class="feleds">
 <label>性别：</label>
   <input type="radio" id="male" name="sex" value="0" checked="checked" /><label for="male">男</label>&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="radio"  id="female" name="sex" value="1" /><label for="female">女</label>
 </div>
  <div class="feld"> <label>出生年月：
 <input class="truename" type="text" name="birthday" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'});" id="birthday" />
 </label>
 </div>
   <div class="feld"> <label>手机号码：
 <input class="truename" type="text" onchange="mobchange();" id="mobile" name="mobile" maxlength="11" />
 </label>
 </div>
 <div id="mobiletip" class="kaitongtishi"></div>
   <div class="feld"> <label>电子邮箱：
 <input class="truename" type="text" id="email" name="email" onblur="checkemail()" maxlength="30"/>
 </label>
 </div>

 </div>
 </div>
 <input type="hidden" id="echeckresult" value="0"/>
 <input type="hidden" id="ucheckresult" value="0"/>
  <input id="nextbtn" style="cursor:pointer;margin-left: 320px;" type="submit" name="submit" class="next" value="下一步" />
  </form>
  </div>
   <?php $this->display('common/site_right'); ?>
</div>
  <div class="footlintbg">
<img width="970" height="16" src="http://static.ebanhui.com/ebh/tpl/2012/images/doot5111.jpg">
</div>
</div>
<div style="clear:both;"></div>
<script defer="defer">
$(function(){

	$("#getBtn").click(function(){
		if($.trim($("#username").val()).length==0){
			$("#usernametip").html("请输入e板会帐号。").css("color","#ff0000");
			$("#usernametip").show();
			$("#username").focus();
		}else if($.trim($("#password").val()).length==0){
			$("#passwordtip").html("请输入密码。").css("color","#ff0000");
			$("#passwordtip").show();
			$("#password").focus();
			return false;
		}else{
			passwordcheck();
//			$("#more").show();
//			$(".fot").css("height","550px");
//			$(".slst").css("height","720px");
//			$("#nextbtn").show();
		}
	});
	$("#usernametip").html("请填写6-16位以字母开头且不能包含特殊字符。").css("color","#666666").show();
	$("#passwordtip").html("请输入长度大于6位的密码。").css("color","#666666").show();
	
	if($("#unuser").attr("checked")==false){
		//$("#passdiv").hide();
		$("#passagaindiv").hide();
		$("#passwordtip").css("color","#666666").html("请输入您的帐号密码。");
		$("#passwordtip").hide();
		$("#getBtn").show();
		$("#more").hide();
		$(".fot").css("height","auto");
		$(".slst").css("height","auto");
		$("#nextbtn").hide();
		
	}else{
		//$("#passdiv").show();
		$("#getBtn").hide();
		$(".fot").css("height","550px");
		$(".slst").css("height","720px");
		$("#passagaindiv").show();
		$("#more").show();
		$("#passwordtip").html("请输入长度大于6位的密码。").css("color","#666666").show();
		$("#nextbtn").show();
	}
	$("#address_qu").live("change",function(){
		if($("#address_qu").val()!=""){
			$("#zonetip").html("");
			$("#mobiletip").hide();
		}else{
			$("#zonetip").html("请选择您所在的区。");
			$("#mobiletip").show();
		}
	});
	
});

function isuserf(t){
	if(t==1){
		//$("#passdiv").hide();
		$("#usernametip").hide();
		$("#passagaindiv").hide();
		$("#getBtn").show();
		$("#passwordtip").css("color","#666666").html("请输入您的帐号密码。");
		$("#passwordtip").show();
		$("#more").hide();
		$(".fot").css("height","auto");
		$(".slst").css("height","auto");
		$("#nextbtn").hide();
	}else{
		//$("#passdiv").show();
		$("#more").show();
		$("#getBtn").hide();
		$("#passagaindiv").show();
		$("#username").val("");
		$("#passwordtip").html("请输入长度大于6位的密码。").css("color","#666666").show();
		$(".fot").css("height","550px");
		$(".slst").css("height","720px");
		$("#nextbtn").show();
	}
}
function checkform(){
	if($.trim($("#username").val()).length==0){
		$("#usernametip").html("请输入e板会帐号。").css("color","#ff0000");
		$("#usernametip").show();
		$("#username").focus();
		return false;
	}
	if($("#ucheckresult").val()=="3"){
		$("#usernametip").html("请填写6-16位以字母开头且不能包含特殊字符！").css("color","#ff0000");
		$("#usernametip").show();
		$("#username").focus();
		return false;
	}
	if($("#unuser").attr("checked")==true){
		if($.trim($("#password").val()).length==0){
			$("#passwordtip").html("请输入密码。").css("color","#ff0000");
			$("#passwordtip").show();
			$("#password").focus();
			return false;
		}
		if($.trim($("#password").val()).length<6){
			$("#passwordtip").html("请输入长度大于6位的密码。").css("color","#ff0000");
			$("#passwordtip").show();
			$("#password").focus();
			return false;
		}
		if($.trim($("#passwordagain").val()).length==0){
			$("#passwordagaintip").html("请再次输入密码。");
			$("#passwordagaintip").show();
			$("#passwordagain").focus();
			return false;
		}
		if($.trim($("#passwordagain").val()).length<6){
			$("#passwordagaintip").html("请输入长度大于6位的密码。");
			$("#passwordagaintip").show();
			$("#passwordagain").focus();
			return false;
		}
		if($.trim($("#passwordagain").val())!=$.trim($("#password").val())){
			$("#passwordagaintip").html("两次密码不一致。");
			$("#passwordagaintip").show();
			$("#password").focus();
			$("#passwordagain").val("");
			$("#password").val("");
			return false;
		}
	
	}
	if($.trim($("#truename").val()).length==0){
		$("#truenametip").html("请输入您的真实姓名。");
		$("#truenametip").show();
		$("#truename").focus();
		return false;
	}
	if($.trim($("#mobile").val()).length!=0){
		var emailval=$.trim($("#mobile").val());
		if(!isMobile(emailval)){
			$("#mobiletip").html("请填写您正确的手机号码。");
			$("#mobiletip").show();
			$("#mobile").focus();
			return false;
		}
	
	}
	if($.trim($("#email").val()).length!=0){
		var emailval=$.trim($("#email").val());
		if(!isEmail(emailval)){
			$("#emailtip").html("请填写您正确的邮箱。");
			$("#emailtip").show();
			$("#email").focus();
			return false;
		}
	}
	if($("#ucheckresult").val()=="2"&&$("#unuser").attr("checked")==true){
		$("#usernametip").html("该账号已被占用，请更换账号。");
		$("#usernametip").show();
		$("#username").focus();
		return false;
	}
	if($("#echeckresult").val()=="2"){
		$("#emailtip").html("该邮箱已被占用，请更换邮箱。");
		$("#emailtip").show()
		$("#email").focus();
		return false;
	}

}
function checkname(){

	var username=$.trim($("#username").val());
	if($("#unuser").attr("checked")==true){
		var namereg = /^[a-zA-Z_][a-z0-9A-Z_]{5,15}$/;
		var nameok=false;
		if(username!=""&&!username.match(namereg)){
			$("#ucheckresult").val("3");
			$("#usernametip").html("请填写6-16位以字母开头且不能包含特殊字符！").css("color","#ff0000");
			$("#usernametip").show();
		} else {
			if(username!="")
			{
				$.ajax({
					type:"GET",
					url:'#getsitecpurl()#?action=member&op=check',
					data:'key=username&inajax=1&value='+username,
					dataType:'json',
					success:function(json){
						if(json.code==1){
							$("#usernametip").html("账号已被占用，请重新填写。").css("color","#ff0000");
							$("#usernametip").show();
						//	$("#username").focus();
							$("#ucheckresult").val("2");
						}else{
							$("#usernametip").html("");
							$("#usernametip").hide();
							$("#ucheckresult").val("0");
						}
					}
				});
			}else{
				$("#usernametip").html("请填写6-16位以字母开头且不能包含特殊字符！").css("color","#666666");
			}
		}
	}else{
		if(username!=""){
			$("#usernametip").html("");
			//$("#usernametip").hide();
		}else{
			$("#usernametip").html("请输入e板会帐号。").css("color","#ff0000");
			$("#usernametip").show();
		}
	}
}

function checkemail(){
	var email=$.trim($("#email").val());
	if($("#unuser").attr("checked")==true){
		if((email!="")&&isEmail(email)){
			$.ajax({
				type:"GET",
				url:'#getsitecpurl()#?action=member&op=check',
				data:'key=email&inajax=1&value='+email,
				dataType:'json',
				success:function(json){
					if(json.code==1){
						$("#emailtip").html("邮箱已被占用，请重新填写。");
						$("#emailtip").show();
						$("#email").focus();
						$("#echeckresult").val("2");
					}else{
						$("#emailtip").html("");
						$("#emailtip").hide();
						$("#echeckresult").val("0");
					}
				}
			});
		}else{
			if(email!=""){
				$("#emailtip").html("请填写正确的邮箱。");
				$("#emailtip").show();
			}else{
				$("#emailtip").html("");
				$("#emailtip").hide();
			}
		}
	}else{
		if(email!=""){
			if(isEmail(email)){
				$("#emailtip").html("");
				$("#emailtip").hide();
			}else{
				$("#emailtip").html("请填写正确的邮箱。");
				$("#emailtip").show();
			}
		}else{
			$("#emailtip").html("");
			$("#emailtip").hide();
		}
	}
}
function isEmail(str){
    var reg = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    return reg.test(str);
}
function isMobile(str){
	var reg=/^1\d{10}$/;
	return reg.test(str);
}

function passwordchecku(){

	if($("#unuser").attr("checked")==true){
		if($.trim($("#password").val()).length==0){
			$("#passwordtip").html("请输入密码。").css("color","red");
			$("#passwordtip").show();
			$("#password").focus();
			return false;
		}
		else if($.trim($("#password").val()).length<6){
			$("#passwordtip").html("请输入长度大于6位的密码。").css("color","red");
			$("#passwordtip").show();
			$("#password").focus();
			return false;
		}else{
			$("#passwordtip").html("").css("color","#666666");
			$("#passwordtip").hide();
		}

	}else{}
}
function passwordcheck(){
	if($("#unuser").attr("checked")==true){
		if($.trim($("#password").val()).length==0){
			$("#passwordtip").html("请输入密码。");
			$("#passwordtip").show();
			$("#password").focus();
			return false;
		}
		else if($.trim($("#password").val()).length<6){
			$("#passwordtip").html("请输入长度大于6位的密码。");
			$("#passwordtip").show();
			$("#password").focus();
			return false;
		}else{
			$("#passwordtip").html("");
			$("#passwordtip").hide();
		}

	}else{
		var passwordval=$.trim($("#password").val());
		if(passwordval.length!=0&&$("#username").val()!=""){
			
			$.ajax({
				type:"POST",
				url:'#getsitecpurl()#?action=classactive&op=getuserinfo',
				data:{'username':$("#username").val(),'password':passwordval},
				dataType:'json',
				success:function(json){
					if(json.status==1){
						$("#passwordtip").html("");
						$("#passwordtip").hide();
						$("#truename").val("dontset");
//						if(json.userinfo.sex=="1"){
//							$("#female").attr("checked","checked");
//						}else{
//							$("#male").attr("checked","checked");
//						}
//						$("#birthday").val(json.userinfo.birthday);
//						$("#mobile").val(json.userinfo.mobile);
//						$("#email").val(json.userinfo.email);
//						$("#addressval").val(json.userinfo.address);
						$("#nextbtn").click();
					}else{
						$("#passwordtip").css("color","#ff0000");
						$("#passwordtip").html(json.msg);
						$("#passwordtip").show();
						
					}
				}
			});
			
		}
		
	}
	
}
function passwordagaincheck(){
	if($.trim($("#passwordagain").val()).length==0){
		$("#passwordagaintip").html("请再次输入密码。");
		$("#passwordagaintip").show();
		$("#passwordagain").focus();
		return false;
	}
	else if($.trim($("#passwordagain").val()).length<6){
		$("#passwordagaintip").html("请输入长度大于6位的密码。");
		$("#passwordagaintip").show();
		$("#passwordagain").focus();
		return false;
	}
	else if($.trim($("#passwordagain").val())!=$.trim($("#password").val())){
		$("#passwordagaintip").html("两次密码不一致。");
		$("#passwordagaintip").show();
		$("#password").focus();
		$("#passwordagain").val("");
		$("#password").val("");
		return false;
	}else{
		$("#passwordagaintip").html("");
		$("#passwordagaintip").hide();
	}
}

function mobchange(){
	if($.trim($("#mobile").val()).length!=0){
		if(!isMobile($.trim($("#mobile").val()))){
			$("#mobiletip").html("请输入正确手机号码。");
			$("#mobiletip").show();
		}else{
			$("#mobiletip").html("");
			$("#mobiletip").hide();
		}

		
	}else{
		$("#mobiletip").html("");
		$("#mobiletip").hide();
	}	
}
function emptychange(objid,tipid,msg){
	var obj=$.trim($("#"+objid).val());
	if(obj.length==0){
		$("#"+tipid).html(msg);
		$("#"+tipid).show()
	}else{
		$("#"+tipid).hide()
	}
}
</script>
<?php $this->display('common/site_footer'); ?>