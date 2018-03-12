<?php
class ImController extends CControl{
    private $user = null;
    public function __construct(){
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        if(empty($this->user)){
            header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
            exit;
        }
        $this->assign('user',$this->user);
    }

    public function index(){

        $input = EBH::app()->getInput();
        $auth = $input->cookie('auth');

        $this->assign('auth',$auth);
        $this->display('im/index');
    }

    public function room(){
        $this->display('im/room');
    }
	
	/*
	获取历史记录（班主任随机提问）
	*/
	public function getHistory(){
		$cwid = $this->input->post('cwid');
		$uid = $this->input->post('uid');
		$user = Ebh::app()->user->getloginuser();
		// var_dump($user);
		// $cwid = 127564;
		// $uid = 14195;
		if(empty($cwid) || empty($uid)){
			// exit;
		}
		$uids = array($user['uid']);
		$uid>$user['uid']?array_push($uids,$uid):array_unshift($uids,$uid);
		
		$redis_name = 'ebh_chathistory_'.$cwid;
		$redis_key = implode('_',$uids);//uid1_uid2 小的在前
		// var_dump($redis_key);
		$redis = Ebh::app()->getCache('cache_redis');
		$history = $redis->hGet($redis_name,$redis_key);
		if(empty($history)){
			$history = json_encode(array());
		}
		echo $history;
	}
}