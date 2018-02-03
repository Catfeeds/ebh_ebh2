<?php
/**
 *创建网校成功之后通知配置文件
 *
 */
$snotify = array();
$snotify['sendmsg'] = false;//为false表示不发送短信提醒,为true表示发送短信提醒
$snotify['sendemail'] = false; //为false表示不发送邮件提醒,为true表示发送邮件提醒
$snotify['mobiles'] = array('13757168928','13003686138','13916195845','15306535621','15858282857'); //将要发送的手机号码数组
$snotify['emails'] = array(
	array('email'=>'6488479@qq.com','username'=>'靳小红'),
	array('email'=>'304445279@qq.com','username'=>'刘小勇'),
	array('email'=>'huxinliang20@163.com','username'=>'胡心良'),
	array('email'=>'892357903@qq.com','username'=>'陈峥'),
	array('email'=>'970548653@qq.com','username'=>'管杨敏')
); //将要发送的邮箱数据
return $snotify;
?>
