<?php
$this->display('admin/header');
?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>会员管理 - 编辑会员</h1></td>
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
<form method="post" action="/admin/member/edit.html" onsubmit="return $(this).form('validate')">
<input type="hidden" name="uid" value="<?=$memberdetail['uid']?>"/>
<input type="hidden" name="token" value="<?=$token?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>"/>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
    <th>真实姓名</th>
    <td><input type="text" class="w300" maxlength="50" name="realname" value="<?=$memberdetail['realname']?>" /></td>
</tr>
<tr>
    <th>用户昵称</th>
    <td><input type="text" class="w300" name="nickname"   maxlength="25"  value="<?=$memberdetail['nickname']?>" /></td>
</tr>
<tr>
    <th>性　　别</th>
    <td>
        <input type="radio" name="sex"  <?php if($memberdetail['sex']==0){echo 'checked=checked';}?> value="0">男
        <input type="radio" name="sex"  <?php if($memberdetail['sex']==1){echo 'checked=checked';}?> value="1" >女
    </td>
</tr>
<tr>
    <th>出生日期</th>
    <td><input type="text"  id="birthdate" name="birthdate" class="w300" onfocus="$(this).datebox({});" value="<?php $memberdetail['birthdate']=empty($memberdetail['birthdate'])?time():$memberdetail['birthdate']; echo date("Y-m-d",$memberdetail['birthdate']) ?>">
    </td>
</tr>
<tr><th>电话号码</th><td><input type="text" name="phone" class="w300" value="<?=$memberdetail['phone']?>"></td></tr>
<tr><th>手机号码</th><td><input type="text" name="mobile" class="w300" maxlength="11" value="<?=$memberdetail['mobile']?>"></td></tr>
<tr><th>电子邮箱</th><td><input type="text" name="email" class="w300" value="<?=$memberdetail['email']?>"></td></tr>
<tr><th>ＱＱ号码</th><td><input type="text" name="qq" class="w300" value="<?=$memberdetail['qq']?>"></td></tr>
<tr><th>M  S  N</th><td><input type="text" name="msn" class="w300" value="<?=$memberdetail['msn']?>" ></td></tr>
<tr><th>出生地</th><td><input type="text" name="native" class="w300" value="<?=$memberdetail['native']?>" ></td></tr>
<tr>
    <th>居住城市</th>
    <td><?php $this->widget('cities_widget',array('citycode'=>$memberdetail['citycode']));?></td>
</tr>
<tr>
    <th>详细地址</th>
    <td><input type="text" name="address" class="w300" value="<?=$memberdetail['address']?>" ></td>
</tr>
<tr>
    <th>个人头像</th>
    <td>
        <?php
            if(empty($memberdetail['face'])){
                $Upcontrol->upcontrol('face',1,array(),'pic');
              }else{
                $Upcontrol->upcontrol('face',1,array('upfilepath'=>$memberdetail['face']),'pic');
            }
        ?>
    </td>
</tr>
<tr>
    <th>自我介绍</th>
    <td><textarea cols="55" rows="3" name="profile" ><?=$memberdetail['profile']?></textarea></td>
</tr>
</table>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"  name="valuereset" value="重置">
 
</div>
</body>
<script type="text/javascript">
$(function(){
    $('#birthdate').trigger('focus');
});
</script>
<?php
$this->display('admin/footer');
?>