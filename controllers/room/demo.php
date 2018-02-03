<?php
/**
 * 网校装扮
 * Author: eker
 * Email: eker-huang@outlook.com
 */
class DemoController extends CControl {
    private $user;
    private $room;
    
    public function __construct(){
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        $this->room = Ebh::app()->room->getcurroom();
    }
    
    public function index(){
        $user = $this->user;
        $room = $this->room;
        $apiServer = Ebh::app()->getApiServer('ebh');
        $roomtype = Ebh::app()->room->getRoomType();
        $systemsetting = Ebh::app()->room->getSystemSetting();
        
        $ret = $apiServer->reSetting()
        ->setService('Classroom.Design.getdesign')
        ->addParams('crid', $room['crid'])
        ->addParams('roomtype', $roomtype)
        ->request();
        
 
        $foot = $ret['data']['foot'];
        $head = $ret['data']['head'];
        $body = $ret['data']['body'];
        $settings = $ret['data']['settings'];
        if(!empty($settings)){
            $settings = stripslashes($settings);
            //$settings = stripslashes($settings);
            $settings = json_decode($settings);
        }
        
        $this->assign('foot', stripslashes($foot));
        $this->assign('head', stripslashes($head));
        $this->assign('body', stripslashes($body));
        $this->assign('settings', $settings);
        $this->assign('systemsetting', $systemsetting);
        
        //用户登录信息 -- 判断是不是网校管理员
        if(!empty($user) && !empty($room)){
            if($room['uid'] == $user['uid']){
                $user['isadmin'] = 1;
            }else{
                $user['isadmin'] = 0;
            }
            //处理显示用户名
            $showname = !empty($user['realname']) ? shortstr($user['realname'], 8, ''): shortstr($user['username'], 8, '');
            $user['showname'] = $showname;
        }
        $this->assign('user', $user);
        $this->assign('roominfo', $room);
        
        
        
        $this->display('room/design/demo');
    }
    
}