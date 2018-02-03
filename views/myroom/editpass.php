<?php
$this->display('myroom/page_header');
?>
<div class="topbaad">
<div class="user-main clearfix">
	
	
	<div class="ter_tit" style="position: relative;">
	当前位置 > 修改密码
	</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:786px;">
	

<div class="center">

<form method="post" action="<?=geturl('myroom/editpass')?>" name="changpwd" onsubmit="return chkform();">
<table class="userdata" style="width:600px;" border="0" cellspacing="0" cellpadding="0">
<tbody>
  <tr>
    <th style="width:80px;"><span class="star" style="width:20px;margin:0;padding:0;"></span><span style="float:left;width:65px;">当前密码：</span></th>
    <td style="height:35px"><input class="ipt" type="password" id="oldpassword" name="oldpassword" onblur="chkoldpwd(this.value)" /><em style="font-style:normal;padding-left: 15px" id="oldpassword1" ></em></td> 	
  </tr>
  <tr><th></th><td style="height:18px"><p class="txt-info">请输入您当前的登录密码</p></td></tr>
    
	<tr>
    <th style="width:80px;"><span class="star" style="width:20px;margin:0;padding:0;"></span><span style="float:left;width:65px;">新 密 码：</span></th>
    <td style="height:35px">
	<input class="ipt" type="password" id="password" name="password" onblur="password2(this.value)" maxlength="18"/>
	<em style="font-style:normal;padding-left: 15px" id="password1" ></em></td>
  </tr>
   <tr><th></th><td style="height:18px"><p class="txt-info">密码长度为6-18位，建议英文和数字组合</p></td></tr>
  	<tr>
    <th style="width:80px;"><span class="star" style="width:20px;margin:0;padding:0;"></span><span style="float:left;width:65px;">确认密码：</span></th>
    <td style="height:35px">
	<input class="ipt" type="password" id="passwordtrue" name="passwordtrue" onblur="truepassword(this.value)" maxlength="18"/>
	<em style="font-style:normal;padding-left: 15px" id="truepassword1" ></em>
    </td>
  </tr>
   <tr><th></th><td style="height:18px"><p class="txt-info">再次输入您的新密码</p></td></tr>
  <tr>
    <th></th>
    <td class="pt15"><input class="huangbtn pointer" type="button" onclick="editpass()" value="确认修改" />
  </tr>
 </tbody>
</table>
</form>
</div>
<div class="clear"></div>
<script type="text/javascript">
var old = true;
var newpassword = true;
var newpasswordtrue = true;
function chkoldpwd(oldpassword,nochecktrue){
	if(oldpassword == ""){
		$("#oldpassword1").html("<font color=red>请输入原密码！</font>");
		old = false;
		return;
	}
	if(nochecktrue)
		return;
	$.ajax({
		url:"<?=geturl('myroom/editpass/checkoldpassword')?>",
		type:'post',
		data:{'oldpassword':oldpassword},
		success:function(data){
			if (data==0) {
				$("#oldpassword1").html("<font color=red>原密码输入有误，请重新输入!</font>");
				old = false;
				return;
			}else{
				old = true;
				$("#oldpassword1").html("");
			}
		}
	});
}
function password2(password){
	newpassword = true;
	if(password == ""){
		$("#password1").html("<font color='red'>请输入新密码！</font>");
		newpassword = false;
		return;
	}
	if(password.length < 6 ){
		$("#password1").html("<font color='red'>密码不能低于6位！</font>");
		newpassword = false;
		return;
	}
	$("#password1").html("");
}
function truepassword(passwordtrue){
	newpasswordtrue = true;
	if(passwordtrue == ""){
		$("#truepassword1").html("<font color=red>请输入确认密码！</font>");
		newpasswordtrue = false;
		return;
	}
	if(passwordtrue.length < 6 ){
		$("#truepassword1").html("<font color=red>密码不能低于6位！</font>");
		newpasswordtrue = false;
		return;
	}
	 if(document.getElementById('password').value  != passwordtrue){
		$("#truepassword1").html("<font color=red>两次密码输入不一致！</font>");
		newpasswordtrue = false;
		return;
	}	
	$("#truepassword1").html("");
}
function chkform(){

	var oldpassword = $("#oldpassword").val();
	var password = $("#password").val();
	var passwordtrue = $("#passwordtrue").val();
	chkoldpwd(oldpassword,true);
	password2(password);
	truepassword(passwordtrue);
	// alert(old+":"+newpassword+":"+newpasswordtrue);
	if(!(old && newpassword && newpasswordtrue)){
		return false;
	}
	return true;
}

function editpass(){
	var password = $('#password').val();
	var oldpassword = $('#oldpassword').val();
	if(!chkform())
		return ;
	$.ajax({
		url:'/myroom/editpass.html',
		type:'post',
		data:{'password':password,'oldpassword':oldpassword},
		success:function(data){
			alert('密码修改成功,重新登录');
			parent.location.href = '/myroom.html';
		}
	});
}
</script>
</div>
</div>
</div>
<?php
$this->display('myroom/page_footer');
?>