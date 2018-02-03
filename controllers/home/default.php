<?php
/**
 * 个人中心
 */
class DefaultController extends CControl {
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
    public function index() {
    	$roominfo = Ebh::app()->room->getcurroom();
    	$this->assign('room', $roominfo);
    	$user = Ebh::app()->user->getloginuser();
    	$this->assign('user', $user);
    	$roommodel = $this->model('Classroom');
    	$roomlist = $roommodel->getroomlistbyuid($user['uid']);
    	$this->assign('roomlist', $roomlist);
		//var_dump($roominfo);	
		$roomuser = $this->model('roomuser');
		$roomcount = $roomuser->getroomcount($user['uid']);
		$this->assign('roomcount',$roomcount);
    	$this->assign('roominfo',$roominfo);
    	$percent = $this->getpercent($user);
    	$this->assign('percent',$percent);
    	$this->display("home/index");
    }
    
    public function getpercent($user){
    	$pc = 50;
    	if($user['face'])
    		$pc+=10;
    	$mmodel = $this->model('Member');
    	$info = $mmodel->getfullinfo($user['uid']);
    	unset($info['memberid'],$info['realname'],$info['face']);
    	foreach($info as $value){
    		if(!empty($value))
    			$pc+=2;
    	}
    	if($pc>100){$pc=100;}
    	return $pc;
    }
}
