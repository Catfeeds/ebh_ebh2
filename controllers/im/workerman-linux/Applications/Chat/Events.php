<?php
use GatewayWorker\Lib\Gateway;
use \Workerman\Autoloader;
use \GatewayWorker\Lib\Db;
require_once __DIR__ . '/../../Workerman/Autoloader.php';
require_once __DIR__ . '/../../Common/user.php';
Autoloader::setRootPath(__DIR__);
class Events
{
    public static $user = array();
    public static function onWorkerStart($businessWorker)
    {   //服务准备就绪
        echo "Worker_socket_ready\n";
    }

    public static function onConnect($client_id)
    {
        //当客户端链接上时触发，这里可以做 session  域名来源排除 ，安全过滤等
        $data['client_id'] = $client_id;
        Gateway::sendToClient($client_id,json_encode($data));
	    echo "user connect\n";
        
    }
    public static function onMessage($client_id, $message){

        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";
        $data = json_decode($message,true);
        switch($data['type']){
            case 'login':
                if($data['auth'] != ''){
                    $user = getloginuser($data['auth']);
                    if($user){
                        echo "用户校验成功,开始执行登录操作:Uid:".$user['uid']."\n";
                        $clients =  Gateway::getClientIdByUid($user['uid']);

                        var_dump($clients);
                        echo "\n";

                        /*if(count($clients) == 0){
                            //如果已绑定的client_id为空 则进行绑定
                            Gateway::bindUid($client_id, $user['uid']);
                        }*/

                        Gateway::bindUid($client_id, $user['uid']);


                        self::$user = $user;
                        self::$user['avatar'] = getavater($user,'78_78');
                        //将用户的基础信息存入session
                        $_SESSION['user'] = array(
                            'uid'   =>  $user['uid'],
                            'avatar'    =>  getavater($user,'78_78'),
                            'realname'  =>  $user['realname']
                        );

                        // 转播给当前房间的所有客户端，xx进入聊天室 message {type:login, client_id:xx, name:xx}
                        $new_login_message = array(
                            'type'  =>  $data['type'],
                            'client_id' =>  $client_id,
                            'name'  =>  $user['realname'],
                            'avatar'    =>  self::$user['avatar'],
                            'time'  =>  date('Y-m-d H:i:s')
                        );



                        // 获取房间内所有用户列表
                        $clients_list = Gateway::getClientSessionsByGroup($data['room_id']);

                        foreach($clients_list as $tmp_client_id=>$item)
                        {
                            $clients_list[$tmp_client_id] = $item['user']['realname'];
                        }
                        $clients_list[$client_id] = $user['realname'];

                        $new_login_message['client_list'] = $clients_list;
                        Gateway::sendToGroup($data['room_id'], json_encode($new_login_message));
                        Gateway::joinGroup($client_id,$data['room_id']);
                        $_SESSION['room_id'] = $data['room_id'];

                        $new_login_message['type'] = 'flush_client';
                        Gateway::sendToClient($client_id,json_encode($new_login_message));
                        var_dump($clients_list);
                    }else{
                        echo "用户校验失败踢出客户端\n";
                        Gateway::closeClient($client_id);
                    }
                }else{
                    //没有收到校验字符串 直接提出客户端

                    echo "用户校验失败踢出客户端\n";
                    Gateway::closeClient($client_id);
                }
                break;
            // 客户端发言 message: {type:say, to_client_id:xx, content:xx}
            case 'say':
                if($data['to_client_id'] == 'all'){
                    $new_message = array(
                        'type'=>'say',
                        'from_client_id'=>$client_id,
                        'from_client_name' =>self::$user['realname'],
                        'from_client_avatar'=>self::$user['avatar'],
                        'to_client_id'=>'all',
                        'content'=>nl2br(htmlspecialchars($data['content'])),
                        'time'=>date('Y-m-d H:i:s'),
                    );
                    Gateway::sendToGroup($_SESSION['room_id'] ,json_encode($new_message));

                }else{
                    //处理私聊
                }
                break;
        }
    }
     
    /*public static function onMessage($client_id, $message)
    {   

        $data = json_decode($message, true);
        switch ($data['type']) {
            case 'connect':
                //客户端连接服务器进行身份校验
                if($data['content']['auth'] != ''){
                    $user = getloginuser($data['content']['auth']);
                    if($user){
                        //获取该UID绑定的client_id
                        echo $user['uid']."\n";
                        $clients =  Gateway::getClientIdByUid($user['uid']);
                        var_dump($clients);
                        echo "\n";
                        if(count($clients) == 0){
                            //如果已绑定的client_id为空 则进行绑定
                            Gateway::bindUid($client_id, $user['uid']);

                        }

                        Gateway::joinGroup($client_id,101);
                        self::$user = $user;
                    }else{
                        Gateway::closeClient($client_id);
                    }
                }
                break;
            case 'chatMessage':
                //处理聊天事件
                $msg['username'] = $data['content']['mine']['username'];
                $msg['avatar'] = $data['content']['mine']['avatar'];
                $msg['id'] = $data['content']['mine']['id'];
                $msg['content'] = $data['content']['mine']['content'];
                $msg['type'] = $data['content']['to']['type'];
                $chatMessage['type'] = 'getMessage';
                $chatMessage['content'] = $msg;

                //处理单聊
                if ($data['content']['to']['type'] == 'friend') {
                    echo Gateway::isUidOnline($data['content']['to']['id']);
                    if(Gateway::isUidOnline($data['content']['to']['id'])){
                        Gateway::sendToUid($data['content']['to']['id'], json_encode($chatMessage));
                    }else{
                        $noonline['type'] = 'noonline';
                        Gateway::sendToClient($client_id, json_encode($noonline));
                    }
                } else {
                    //处理群聊
                    $msg['username'] = $data['content']['mine']['username'];
                    $msg['avatar'] = $data['content']['mine']['avatar'];
                    $msg['id'] = $data['content']['to']['id'];
                    $msg['content'] = $data['content']['mine']['content'];
                    $msg['type'] = $data['content']['to']['type'];

                    $chatMessage['type'] = 'getMessage';
                    $chatMessage['content'] = $msg;
                    $chatMessage['from_uid'] = $data['content']['mine']['id'];
                    Gateway::sendToGroup($data['content']['to']['id'],json_encode($chatMessage));
                }
                break;
        }
        
       
    }*/
    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {    

        //有用户离线时触发 并推送给全部用户

        
    }
}