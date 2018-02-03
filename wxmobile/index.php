<?php

/**
*手机端微信接口
*/

//重新加载框架起动文件
define('IN_EBH', TRUE);
define('S_ROOT', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('IS_DEBUG', FALSE);  //是否开启调试状态
date_default_timezone_set('Asia/Shanghai');
$config = S_ROOT.'config/config.php';
require S_ROOT.'system/core/runtime.php';
Ebh::createIndexApplication($config)->run();
$wechatObj = Ebh::app()->lib('WechatCallback');//得到微信扩展类的实例
if(!empty($_GET["echostr"]) && !empty($_GET['signature'])) {	//验证接口配置
	if($wechatObj->checkSignature()){
		echo $_GET["echostr"];
	}
	exit;
}
//$wechatObj->cretemenu();exit;	//创建菜单，只执行一次
$postobj = $wechatObj->parsedata();

if (!empty($postobj)) {
	//log_message(json_encode($postobj));exit;
	if(!empty($postobj->MsgType) && $postobj->MsgType == 'event' && !empty($postobj->Event)) {	//事件处理
		if($postobj->Event == 'subscribe') {	//订阅事件处理
			$wechatObj->subscribe($postobj);
		} else if($postobj->Event == 'unsubscribe') {	//取消订阅事件
			$wechatObj->unsubscribe($postobj);exit;
		} else if($postobj->Event == 'CLICK') {	//点击事件
			if($postobj->EventKey == 'vbind') {	//绑定
				$wechatObj->vbind($postobj);
			} else if($postobj->EventKey == 'VABOUT') {
				$wechatObj->about($postobj);
			}
		}
	}

	if(!empty($postobj->MsgType) && $postobj->MsgType == 'text' && !empty($postobj->Content)) {	//消息处理
		$wechatObj->sendReplyToClassMsg($postobj);
	}
}



?>