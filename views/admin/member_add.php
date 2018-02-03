<?php
$this->display('admin/header');
?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>会员管理 - 添加会员</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td ><a href="/admin/member.html">浏览会员</a></td>
            <td  class="active"><a href="/admin/member/add.html" class="add">添加会员</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<form method="post" action="/admin/member/add.html" onsubmit="return $(this).form('validate')">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>登录名<em>*</em><p>会员用户的账号。</p></th>
    <td><input name="username" id="username" class="easyui-validatebox w300" required="true" validType="username['#form_member input[name=username]']" missingMessage="请输入6-12用户名" /></td>
</tr>
<tr>
    <th>密码<em>*</em><p>请输入会员登录时的密码。</p></th>
    <td><input id="password" name="password" class="easyui-validatebox w300" required="true" validType="length[6,12]" missingMessage="请输入6-12位密码" invalidMessage="请输入6-12位密码" type="password"></td>
</tr>
<tr>
    <th>重复密码<em>*</em><p>请再次输入会员登录时的密码。</p></th>
    <td> <input name="confirm" class="easyui-validatebox w300" required="true" validType="equalPwd['#password']" missingMessage="请重复密码" invalidMessage="密码不匹配" type="password"></td>
</tr>

<tr>
    <th>真实姓名</th>
    <td><input type="text" class="w300" maxlength="50" name="realname"></td>
</tr>
<tr>
    <th>用户昵称</th>
    <td><input type="text" class="w300" name="nickname"   maxlength="25" /></td>
</tr>
<tr>
    <th>性　　别</th>
    <td>
        <input type="radio" name="sex" checked="checked" value="0">男
        <input type="radio" name="sex" value="1" >女
    </td>
</tr>
<tr>
    <th>出生日期</th>
    <td><input type="text"  id="birthdate" name="birthdate" class="w300" onfocus="$(this).datebox({});" value="<?php $memberdetail['birthdate']=empty($memberdetail['birthdate'])?time():$memberdetail['birthdate']; echo date("Y-m-d",$memberdetail['birthdate']) ?>">
    </td>
</tr>
<tr><th>电话号码</th><td><input type="text" name="phone" class="w300" ></td></tr>
<tr><th>手机号码</th><td><input type="text" name="mobile" class="w300" maxlength="11"></td></tr>
<tr><th>电子邮箱</th><td><input type="text" name="email" class="w300" ></td></tr>
<tr><th>ＱＱ号码</th><td><input type="text" name="qq" class="w300" ></td></tr>
<tr><th>M  S  N</th><td><input type="text" name="msn" class="w300" ></td></tr>
<tr><th>出生地</th><td><input type="text" name="native" class="w300" ></td></tr>
<tr>
    <th>居住城市</th>
    <td><?php $this->widget('cities_widget')?></td>
</tr>
<tr>
    <th>详细地址</th>
    <td><input type="text" name="address" class="w300" ></td>
</tr>
<tr>
    <th>个人头像</th>
    <td>
        <?php
            $Upcontrol->upcontrol('face',1,array(),'pic');
        ?>
    </td>
</tr>
<tr>
    <th>自我介绍</th>
    <td><textarea cols="55" rows="3" name="profile" ></textarea></td>
</tr>
</table>
</table>
<div class="buttons">
<input type="submit" name="nextsubmit" value="保存并继续" class="submit">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">
 
</div>
</body>
<script type="text/javascript">
    $(function(){
        $("#birthdate").trigger('focus');
        $("#username").blur(function(){
            $(this).val($(this).val().replace(/\s+/g,''));
        });
    });
</script>
<?php
$this->display('admin/footer');
?>