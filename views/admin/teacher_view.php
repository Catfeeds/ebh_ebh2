<?php
$this->display('admin/header');
?>
<body>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<input type="hidden" name="uid" value="<?php echo $teacherdetail['uid']?>"/>
<tr><th>真实姓名</th><td><input type="text" class="w150" name="realname"  value="<?php echo $teacherdetail['realname'];?>" /></td></tr>
<tr><th>用户昵称</th><td><input type="text" class="w150" name="nickname"   maxlength="25" value="<?php echo $teacherdetail['nickname'];?>" /></td></tr>

<tr><th>电话号码</th><td><input type="text" class="w150" name="phone" value="<?php echo $teacherdetail['phone'];?>" /></td></tr>
<tr><th>手机号码</th><td><input type="text" class="w150" name="mobile" value="<?php echo $teacherdetail['mobile'];?>" maxlength="11" /></td></tr>
<tr><th>城市</th>
<td>
<?php
$this->widget('cities_widget',array('citycode'=>$teacherdetail['citycode']));
?>
</td></tr>
<tr><th>个人简介</th><td><textarea cols="55" rows="3"  name="profile"><?php echo $teacherdetail['profile'];?></textarea></td></tr>
<tr><th>详细地址</th><td><input type="text" class="w150" name="address" value="<?php echo $teacherdetail['address'];?>" /></td></tr>
<tr><th>年龄</th><td>
<input type="text" class="w150" name="vitae[age]" value="<?php echo $teacherdetail['vitae']['age'];?>" />
</td></tr>
<tr><th>个人头像</th><td>
<img alt="" width="90px" height="90px" border="1" src="">
<input type="hidden" name="face" value="$value[face]" />
</td></tr>
<tr><th>详细介绍</th><td>
<input type="text" class="w150" name="vitae[message]" value="<?php echo $teacherdetail['vitae']['message'];?>" />
</td></tr>

<tr><th>标签</th><td><input type="text" class="w150" name="tag" value="<?php echo $teacherdetail['tag'];?>" /></td></tr>
<tr><th>教龄</th><td><input type="text" class="w150" name="schoolage" value="<?php echo $teacherdetail['schoolage'];?>" /></td></tr>
</table>
<a href="javascript:void(0)" class="easyui-linkbutton"  onclick="history.go(-1)" >返回</a>

</body>
<?php
$this->display('admin/footer');
?>