<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
        <link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" />
        <link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css" rel="stylesheet" />
        <link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<!--[if gte ie 5.5000]>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript">
$(document).ready(function(){$("#oldpwd").val('');});
$(function(){ 	
	    $("#menudiv ul").hover(function(){
			$(this).addClass("hover");
		},function(){
			$(this).removeClass("hover");
		})
	})
</script>

<script type="text/javascript">
var boldpwd = false;
var bnewpwd = false;
var bconfirmpwd = false;
function chkoldpwd(oldpwd){
	if(oldpwd == ""){
		$("#oldpwd1").html("请输入原密码！");
		$("#opasstip").hide();
		boldpwd = false;
	}else{
		$.ajax({
			url:"<?= geturl('teacher/setting/checkoldpassword') ?>",
			type:'post',
			data:{'oldpwd':oldpwd},
			success:function(data){
				if (data==0) {
					$("#oldpwd1").html("原密码输入有误！");
					$("#opasstip").hide();
					boldpwd = false;
				}else{
					$("#oldpwd1").html("");
					$("#opasstip").show();
					boldpwd = true;
				}
			}
		});
	}
	
}
function chknewpwd(newpwd){
	if(newpwd.length < 6 ){
		$("#newpwd1").html("密码位数不能低于6位！");
		$("#newpasstip").hide();
		bnewpwd = false;
	}else{
		$.ajax({
			url:"<?= geturl('teacher/setting/checknewpassword') ?>",
			type:'post',
			data:{'newpwd':newpwd},
			success:function(data){
				if (data==1) {
					$("#newpwd1").html("新密码不能和原密码一样！");
					$("#newpasstip").hide();
					bnewpwd = false;
				}else{
					$("#newpwd1").html("");
					$("#newpasstip").show();
					bnewpwd = true;
				}
			}
		});
	}
}
function chkconfirmnewpwd(confirmnewpwd){
	if(confirmnewpwd == ""){
		$("#confirmnewpwd1").html("请输入确认密码！");
		$("#newpassstip").hide();
		bconfirmpwd = false;
	}else if(confirmnewpwd != $("#newpwd").val()){
		$("#confirmnewpwd1").html("两次密码输入不一致！");
		$("#newpassstip").hide();
		bconfirmpwd = false;
	}else{
		$("#confirmnewpwd1").html("");
		$("#newpassstip").show();
		bconfirmpwd = true;
	}
}
function submit_check(){
	chkoldpwd($("#oldpwd").val());
	chknewpwd($("#newpwd").val());
	var newpwd = $("#newpwd").val();
	var oldpwd = $("#oldpwd").val();
	chkconfirmnewpwd($("#confirmnewpwd").val());
	if(boldpwd  && bnewpwd && bconfirmpwd){
		$.ajax({
			url:"<?= geturl('teacher/setting/updatepass') ?>",
			type:'post',
			data:{'newpwd':newpwd,'oldpwd':oldpwd},
			success:function(data){
				if (data==0) {
					$("#newpwd1").html("新密码不能和原密码一样！");
					$("#newpasstip").hide();
					bnewpwd = false;
				}else{
					$("#newpwd1").html("");
					$("#newpasstip").show();
					bnewpwd = true;
					$.showmessage({
                        img : 'success',
                        message:'密码修改成功',
                        title:'修改密码',
						callback :function(){
                                 //document.location.href = "/login.html?returnurl=/troom.html";
                               window.top.location.href = "/login.html?returnurl=/aroomv2.html";
                            }
						});
				}
			}
		});
	}else{
		return false;
	}
}
</script>

<form name="changepwd" method="post" action="<?= geturl('teacher/setting/updatepass') ?>">
<input type="hidden" name="action" value="teacher" />
<input type="hidden" name="op" value="passedit" />
<div class="tmiddle" style="width:788px;">
	<div class="ter_tit" style="position: relative;">
	当前位置 > 个人信息 > 修改密码
	</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
			<?php $this->display('teacher/simple_menu'); ?>
			<div class="tab_box" style="border:none;">
			<div class="ecenter">
					<div class="edit_pwd_tips" style="width:766px;float:left;">
									<div class="edit_pwd_tips_tit">密码管理</div>
									<p>密码由6-18位字符组成，为了您的账号安全，建议不要使用全数字、全字母或连续字符作为密码。</p>
									</div>
			
			<table class="pwd_tab" width="100%">
			<tbody>
  				<tr>
				    <th><span class="star">&nbsp;当前密码： </span></th>
				    <td>
				    	<input class="uipt w295" id="oldpwd" name="oldpwd" value="" type="password" onblur="chkoldpwd(this.value)" maxlength="18" />
				    	<em class="error" id="oldpwd1"></em>
				    	<span id="opasstip" class="ts2">请输入您当前的登录密码。</span>
				    </td>
			  	</tr>
				<tr>
			    	<th><span class="star">&nbsp;新 密 码：</span></th>
			    <td>
					<input class="uipt w295" type="password" id="newpwd" name="newpwd" onblur="chknewpwd(this.value)" maxlength="18" />
					<em class="error" id="newpwd1"></em>
					<span id="newpasstip" class="ts2">密码长度为6-18位，建议英文和数字组合。</span>
				</td>
			  	</tr>
			  	<tr>
			    	<th><span class="star">&nbsp;确认密码：</span></th>
			    	<td>
			    		<input class="uipt w295" type="password" id="confirmnewpwd" name="confirmnewpwd" onblur="chkconfirmnewpwd(this.value)" maxlength="18" />
			    		<em class="error" id="confirmnewpwd1"></em>
			    		<span id="newpassstip" class="ts2">再次输入您的新密码。</span>
			    	</td>
			  </tr>
			  <tr>
			    <th></th>
			    <td class="pt15">
			    	<input class="lanbtn" style="cursor:pointer;" name="submit" type="button" onclick="submit_check()" value="保 存" />
			  </tr>
			</tbody>
			</table>
			</div>
			</div>
		 	</div>
	  </div>
	   <div class="clear"></div>
</form>
        </body>
</html>