<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 */
class DefaultController extends CControl{

    public function __construct(){
        parent::__construct();
        Ebh::app()->room->checkRoomControl();
        $this->user = Ebh::app()->user->getloginuser();
        $this->assign('user',$this->user);
    }
    public function index(){
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = '';//浏览器
        $browser_ver = '';//版本
        if(preg_match('/MSIE\s([^\s|;]+)/i',$agent,$regs)){  
            $browser = 'Internet Explorer';  
            $browser_ver = substr($regs[1],0,1);  
        }
        if($browser == 'Internet Explorer'){
            if($browser_ver == '9' || $browser_ver == '8' || $browser_ver == '7' || $browser_ver == '6'){
                $this->display('aroomv3/nocompatible');exit;
            }
        }
        $roomInfo = Ebh::app()->room->getcurroom();
        //验证是否是企业培训类网校
        $roomtype =Ebh::app()->room->getRoomType();
        if($roomtype=='edu'){
            header("Location:/aroomv3.html");
            exit;
        }
        $apiServer = Ebh::app()->getApiServer('ebh');
        $ret = $apiServer->reSetting()
            ->setService('Aroomv3.Room.seo')
            ->addParams('crid', $roomInfo['crid'])->request();
        $roomInfo['subtitle'] = $ret['subtitle'];
        $roomInfo['favicon'] = $ret['favicon'];
        $this->assign('roominfo',$roomInfo);
        $this->display('comaroomv3/index');
    }



}