<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>用户管理 - 修改密码</h1></td>
		<td class="actions">
		</td>
	</tr>
</table>
<form id="pwdform" method="post" action="/admin/innerchangepwd/_changepassword.html" >
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="formhash" value="<?=$formhash?>">
<input type="hidden" name="uid" value="<?=$user['uid']?>">
<input type="hidden" name="returnurl" value="/admin/innerchangepwd.html">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>所属分组</th><td><?=$groupInfo['groupname']?></td></tr><tr>
<th>登录名<em>＊</em></th><td><input type="text" readonly="readonly" value="<?=$user['username']?>" ></td></tr>
<tr><th>密码<p>为空则不修改密码 密码长度为6-18位</p></th><td><input type="password" name="password" value="" id="password"  /></td></tr>
<tr><th>重复密码<p>为空则不修改密码 密码长度为6-18位</p></th><td><input type="password" name="forpassword" id="forpassword" value=""  /></td></tr>

<!-- <tr><th>所属分组<em>＊</em></th>
	<td>
<?php $this->display('admin/groupcombo');?>
</td></tr> -->
<tr><th>是否锁定</th><td>
<input type="radio" disabled=disabled name="status" value="1" <?php if($user['status']==1){echo 'checked=checked';}?> />正常
<input type="radio" disabled=disabled name="status" value="0" <?php if($user['status']==0){echo 'checked=checked';}?> />锁定
</td></tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit " >
<input type="reset"	 name="valuereset" value="重置" class="reset">
</div>
</form>
</div>
<script type="text/javascript">
	$(function(){
		$("#pwdform").submit(function(){
			var pwd1 = $("#password").val();
			var pwd2 = $("#forpassword").val();
			if((pwd1=='')&&(pwd2==''))return true;
			if(pwd1.length>18||pwd1.length<6){
				alert('密码长度必须为6-18之间');
				return false;
			}
			if(pwd1!=pwd2){
				alert('两次密码不一致');
				return false;
			}
		}); 
	});
</script>
</body>
<?php $this->display('admin/footer');?>