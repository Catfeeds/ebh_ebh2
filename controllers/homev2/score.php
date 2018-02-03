<?php
/*
学员积分
*/
class ScoreController extends CControl{
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		Ebh::app()->user->checkUserLogin($this->user ,true);
		$this->assign('user',$this->user);
		$this->getassigintop();
	}
	public function index(){
		header("location:/homev2/score/routinetask.html");
	}
	/*
	常规任务页面
	*/
	public function routinetask(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		
		$task = $this->model('task');
		$roommodel = $this->model('Classroom');
		
		$tasklist = $task->getmembertasklist($this->user['uid']);
		$ids = '';
		//任务id集合
		for($i=0;$i<count($tasklist);$i++){
			$ids.= $tasklist[$i]['id'].',';
		}
		$ids = rtrim($ids,',');
		//根据id集合获取完成数
		$activelist = $task->getactivecount($ids,$this->user['uid']);
		foreach($activelist as $ac){
			$idcountarr[$ac['id']] = $ac['count'];
		}
		foreach($tasklist as $k=>$task){
			$tasklist[$k]['isactive'] = empty($idcountarr[$task['id']])?0:$idcountarr[$task['id']];
		}
		
		$roomuser = $this->model('roomuser');
		
		if(!empty($room)){
			$charge = ($room['isschool'] == 6 || $room['isschool'] == 7) ? true : false;	//是否为收费平台
			$check = $roommodel->checkstudent($user['uid'], $room['crid'],$charge);
			$this->assign('check',$check);
		}

		//echo '<pre>';
		//var_dump($check);
		
		$this->assign('room',$room);
		$this->assign('tasklist',$tasklist);

		$this->display('homev2/routinetask');
	}
	/*
	积分明细页面
	*/
	public function credit(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
		$this->assign('user',$user);
		$credit = $this->model('credit');
		$param = parsequery();
		$param['pagesize'] = 15;
		$param['toid'] = $this->user['uid'];
		$creditlist = $credit->getcreditlist($param);
		$creditcount = $credit->getusercreditcount($param);
		$this->assign('creditlist',$creditlist);
		$this->assign('creditcount',$creditcount);
		$this->assign('pagesize',$param['pagesize']);
		
		$this->display('homev2/credit');
	}
	/*
	兑换记录页面
	*/
	public function record(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
		$this->assign('user',$user);
		$credit = $this->model('credit');
		$param = parsequery();
		$param['uid'] = $this->user['uid'];
		$orderlist = $credit->getOrderList($param);
		$ordercount= $credit->getOrderCount($param);
		$this->assign('ordercount',$ordercount);
		$this->assign('orderlist',$orderlist);
		$this->display('homev2/record');
	}
	/*
	积分说明页面
	*/
	public function description(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
		$this->assign('user',$user);
		$this->display('homev2/description');
	}
	
	/**
	* 完成作业,添加积分
	*/
	public function examfinish(){
		$eid = $this->input->get('eid');
		$title = $this->input->get('title');
		$credit = $this->model('credit');
		$credit->addCreditlog(array('ruleid'=>7,'detail'=>$title,'eid'=>$eid));
	}
	
	public function lottery(){
		exit;//积分兑换不做处理
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
		$this->assign('user',$user);
		$this->display('homev2/lottery_nav');
	}
	
	public function lottery_lucky(){
		exit;//积分兑换不做处理
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);

		//获取抽奖信息列表,用于滚动显示用户中奖信息
		$creditModel = $this->model('credit');
		$lotterylogs = $creditModel->getLotteryLogs();
		$lotterylogs = $this->_formatProducts($lotterylogs);
		$this->assign('lotterylogs',$lotterylogs);

		$this->display('homev2/lottery');
	}
	
	
	/*
	积分兑换的产品列表
	*/
	public function lottery_exchange(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);
        $productmodel = $this->model('product');
		$param = array('status'=>0,'limit'=>'0,16','order'=>'p.displayorder asc,p.productid desc');
		$productList = $productmodel->getList($param);
		
        $this->assign('productList', $productList);
		$this->display('homev2/exchange');
	}
	public function lottery_exchange_des(){
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
        $this->assign('user', $user);
		$this->display('homev2/exchange_des');
	}
	
	private function _formatProducts($param = array()){
		$returnArr = array();
		$_map = array(
			'1'=>'20积分，表示很高兴！',
			'2'=>'10积分，表示很高兴！',
			'3'=>'IPAD AIR一台，表示很激动！',
			'4'=>'手绘板一台，表示十分激动！',
			'5'=>'微课大师软件一份，表示很激动！',
			'6'=>'XBOX游戏机一套，表示很很喜欢！',
			'7'=>'100元充值卡一张，表示很高兴！',
			'8'=>'500元充值卡一张，表示非常高兴！'
		);
		foreach ($param as $product) {
			array_key_exists($product['productid'],$_map) && ($product['productname'] = $_map[$product['productid']]) && ($returnArr[] = $product);
		}
		return $returnArr;
	}
	
    /**
     * 获取top信息
     */
    public function getassigintop(){
    	$user = $this->user;
    	//uri
    	$this->assign('controller',$this->uri->uri_control());
    	$this->assign('action',$this->uri->uri_method());
        $clinfo = array();
        $clinfo['title']='';
    	if($user['groupid']==5){//老师
    		//积分等级
    		$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
    		foreach($clconfig as $clevel){
    			if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
    				$clinfo['title'] = $clevel['title'];
    				if($user['credit']<=500){
    					$clinfo['percent'] = 50*intval($user['credit'])/500;
    				}elseif($user['credit']<=3000){
    					$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
    				}elseif($user['credit']<=10000){
    					$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
    				}else{
    					$clinfo['percent'] = 100;
    				}
    				break;
    			}
    		}
    	}elseif($user['groupid']==6){//学生
    		//积分等级
    		$clconfig = Ebh::app()->getConfig()->load('creditlevel');
    		foreach($clconfig as $clevel){
    			if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
    				$clinfo['title'] = $clevel['title'];
    				if($user['credit']<=500){
    					$clinfo['percent'] = 50*intval($user['credit'])/500;
    				}elseif($user['credit']<=3000){
    					$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
    				}elseif($user['credit']<=10000){
    					$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
    				}else{
    					$clinfo['percent'] = 100;
    				}
    				break;
    			}
    		}
    	}
    	$this->assign('clinfo',$clinfo);
    	//完成度百分比
    	$percent = Ebh::app()->user->getpercent($this->user);
    	$this->assign('percent',$percent);
    	
    	//粉丝
    	$snsmodel = $this->model('Snsbase');
    	$mybaseinfo = $snsmodel->getbaseinfo($this->user['uid']);
    	$myfanscount = max(0,$mybaseinfo['fansnum']);
    	//关注
    	$myfavoritcount = max(0,$mybaseinfo['followsnum']);
    	$this->assign('myfanscount',$myfanscount);
    	$this->assign('myfavoritcount',$myfavoritcount);
    }
}
?>