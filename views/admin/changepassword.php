<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>用户管理 - 修改密码</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td ><a href="/admin/<?=$info['tag']?>.html">浏览用户</a></td>
			<td ><a href="/admin/<?=$info['tag']?>/add.html" class="add">添加用户</a></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<form id="pwdform" method="post" action="/admin/user/_changepassword.html" >
<input type="hidden" name="formhash" value="<?=$info['formhash']?>" />
<input type="hidden" name="uid" value="<?=$info['userinfo']['uid']?>" />
<input type="hidden" name="returnurl" value="<?=$info['returnurl']?>" />
<input type="hidden" name="token" value="<?=$info['token']?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>所属分组</th><td><?=$info['groupinfo']['groupname']?></td></tr><tr>
<th>登录名<em>＊</em></th><td><input type="text" readonly="readonly" value="<?=$info['userinfo']['username']?>" ></td></tr>
<tr><th>密码<p>为空则不修改密码</p></th><td><input type="password" name="password" value="" id="password"  /></td></tr>
<tr><th>重复密码<p>为空则不修改密码</p></th><td><input type="password" name="forpassword" id="forpassword" value=""  /></td></tr>

<tr><th>所属分组<em>＊</em></th><td>
	<select name="groupid" disabled>
		<option value="<?=$info['groupinfo']['groupid']?>" selected ><?=$info['groupinfo']['groupname']?></option>
	</select></td></tr>
<tr><th>是否锁定</th><td>
<?php if($info['tag']=='agent'){?>
<input type="radio" name="status" value="2" <?php if($info['userinfo']['status']==2){echo 'checked=checked';}?> />未激活
<?php }?>
<input type="radio" name="status" value="1" <?php if($info['userinfo']['status']==1){echo 'checked=checked';}?> />正常
<input type="radio" name="status" value="0" <?php if($info['userinfo']['status']==0){echo 'checked=checked';}?> />锁定
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
			if(pwd1.length>12||pwd1.length<6){
				alert('密码长度必须为6-12之间');
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