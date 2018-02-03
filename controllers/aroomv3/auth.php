<?php
/**
 * 管理员切换到教师处理
 */
class AuthController extends CControl{
    public function __construct(){
        $verifyCode = 0;
        $checkRoom = Ebh::app()->room->checkRoomControlV3($verifyCode);
        $this->user = Ebh::app()->user->getAdminLoginUser();
        if(!$checkRoom){
           echo 'permission error!';
           echo '<script>setTimeout("window.location.href=\'/\';",3000);</script>';
           exit;
        }
    }

    /**
     * 切换到教师后台
     */
    public function toteacher(){
        $user = Ebh::app()->user->getAdminLoginUser();
        //var_dump($user);die;
        if(!empty($user)){
            $url  = '/aroom/umanager/teacher.html?s='.urlencode(authcode($user['uid'],'ENCODE'));
        }else{
            $url = '/login.html';
        }
        header("Location:".$url);
        exit;
    }
}
