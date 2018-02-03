<?php
/**
 * 分享码生产构造器
 * Author: eker
 * Email: eker-huang@outlook.com
 */
class ShareController extends CControl {
    private $user = null;
    private $room = null;
    
    public function __construct(){
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $this->baseurl = $upconfig['pic']['showpath'];
        $uid = intval($this->input->post('uid'));
        $crid = intval($this->input->post('crid'));
        if ($uid > 0) {
            $this->user['uid'] = $uid;
        } else {
            $this->user = Ebh::app()->user->getloginuser();
        }
        if ($crid > 0) {
            $this->room['crid'] = $crid;
        } else {
            $this->room = Ebh::app()->room->getcurroom();
        }
    }
    
    /**
     * 获取分销key
     * 分销加密key组成方式
     * coursetype%itemid%folderid%crid%sourcecrid%providercrid%uid%ip%dateline
     * 
     * coursetype说明:
     * 1>.school 作为网校整体分享过来的链接,针对所有付费购买课程,itemid=0
     * 2>.local 本网校自己的服务项,针对本次课程 itemid>0
     * 3>.third 作为第三方来源的课程,针对本次课程 itemid>0
     * 4>.select 企业选课过来的服务项,针对本次课程 itemid>0
     */
    public function getsharekey($itemid=0,$crid=0,$from='course'){
        $args = func_get_args();
        //var_dump($args);
        if(!empty($args[0]) && is_array($args[0])){
            $arg = $args[0];
            $itemid = $arg['itemid'];
            $crid = $arg['crid'];
            if(!empty($arg['from'])){
                $from = $arg['from'];
            }
        }
        $user  = $this->user;
        if(!empty($user)){
            if($from=='school'){//网校分享key
                $coursetype = 'school';
                $itemid = 0;
                $folderid = 0;
                $sourcecrid = 0;
                $providercrid = 0;
            }elseif($from=='course'){//课程分享key
                $sharecourse = $this->model("Schsource")->getcourse($itemid,$crid);
                //var_dump($sharecourse);
                $coursetype = $sharecourse['coursetype'];
                $folderid = $sharecourse['folderid'];
                $sourcecrid = $sharecourse['sourcecrid'];
                $providercrid = !isset($sharecourse['providercrid'])?'':$sharecourse['providercrid'];
            }
 
            $uid = $user['uid'];
            $dateline = SYSTIME;
            $ip = getip();
            
            $str = $coursetype.'%'.$itemid.'%'.$folderid.'%'.$crid.'%'.$sourcecrid.'%'.$providercrid.'%'.$uid.'%'.$ip.'%'.$dateline;
            //log_message($str);
            $sharekey = authcode($str, 'ENCODE');
        }else{
            $sharekey = 0;
        }
        
        return urlencode($sharekey);
    }
    
    
    
    /**
     * 获取分享码key
     */
    public function getsharekeyajax(){
        $post = $this->input->post();
        $roominfo = $this->room;
        $crid = intval($roominfo['crid']);
        $itemid = !empty($post['itemid']) ? intval($post['itemid']) : 0;
        $user = $this->user;
        if(empty($user)){
            renderjson(1,'用户未登录',null);
        }
        if($crid<=0 || $itemid<0){
            renderjson(1,'网校不存在或者参数非法',null);
        }
        $coursesharekey = $this->getsharekey($itemid,$crid,'course');
        $schoolsharekey = $this->getsharekey(0,$crid,'school');
        renderjson(0,'成功获取分享码',array('coursesharekey'=>$coursesharekey,'schoolsharekey'=>$schoolsharekey));
    }
}