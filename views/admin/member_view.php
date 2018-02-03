<?php
$this->display('admin/header');
?>
<body>
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr><th>真实姓名</th><td><?php echo $memberdetail['realname']?></td></tr>
<tr><th>用户昵称</th><td><?php echo $memberdetail['nickname']?></td></tr>
<tr><th>性　　别</th><td><?php echo $memberdetail['sex']?"女":"男"?></td></tr>
<tr><th>出生日期</th><td><?php echo date('Y-m-d',$memberdetail['birthdate'])?></td></tr>
<tr><th>电话号码</th><td><?php echo $memberdetail['phone']?></td></tr>
<tr><th>手机号码</th><td><?php echo $memberdetail['mobile']?></td></tr>
<tr><th>电子邮箱</th><td><?php echo $memberdetail['email']?></td></tr>
<tr><th>ＱＱ号码</th><td><?php echo $memberdetail['qq']?></td></tr>
<tr><th>M  S  N</th><td><?php echo $memberdetail['msn']?></td></tr>
<tr><th>出生地</th><td><?php echo $memberdetail['native']?></td></tr>
<tr><th>居住城市</th><td>
<?php 
$this->widget('cities_widget',array('citycode'=>$memberdetail['citycode']));
?>
</td></tr>
<tr><th>详细地址</th><td><?php echo $memberdetail['address']?></td></tr>
<tr><th>个人头像</th><td><img alt="" width="90px" height="90px" border="1" src="<?php echo $memberdetail['face']?>"></td></tr>
<tr><th>自我介绍</th><td><?php echo $memberdetail['profile']?></td></tr>
<tr><th>积　　分</th><td><?php echo $memberdetail['credit']?></td></tr>


</table>
<div style="text-align:center;margin-top:10px;">
<a href="javascript:void(0)" class="easyui-linkbutton"  onclick="history.go(-1)" >返回</a>
</div>
</body>
<?php
$this->display('admin/footer');
?>