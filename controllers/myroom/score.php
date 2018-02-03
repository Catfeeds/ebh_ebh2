<?php
/*
学员积分
*/
class ScoreController extends CControl{
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
	}
	/*
	常规任务页面
	*/
	public function routinetask(){
		$task = $this->model('task');
		$tasklist = $task->getmembertasklist($this->user['uid']);
		for($i=0;$i<count($tasklist);$i++){
			$tasklist[$i]['isactive'] = $task->getactivecount($tasklist[$i]['id'],$this->user['uid']);
		}
		$roomuser = $this->model('roomuser');
		// $roomlist = $roomuser->getroomlist($this->user['uid']);
		// if(!empty($roomlist))
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
		//var_dump($tasklist);
		$this->assign('tasklist',$tasklist);
		
		$this->display('myroom/routinetask');
	}
	/*
	积分明细页面
	*/
	public function credit(){
		$credit = $this->model('credit');
		$param = parsequery();
		$param['pagesize'] = 15;
		$param['toid'] = $this->user['uid'];
		$creditlist = $credit->getcreditlist($param);
		$creditcount = $credit->getusercreditcount($param);
		$this->assign('creditlist',$creditlist);
		$this->assign('creditcount',$creditcount);
		$this->assign('pagesize',$param['pagesize']);
		
		$this->display('myroom/credit');
	}
	/*
	兑换记录页面
	*/
	public function record(){
		$credit = $this->model('credit');
		$param = parsequery();
		$param['uid'] = $this->user['uid'];
		$orderlist = $credit->getOrderList($param);
		$ordercount= $credit->getOrderCount($param);
		$this->assign('ordercount',$ordercount);
		$this->assign('orderlist',$orderlist);
		$this->display('myroom/record');
	}
	/*
	积分说明页面
	*/
	public function description(){
		
		$this->display('myroom/description');
	}
}
?>