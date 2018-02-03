<?php
/**
 * 点名系统
 */
class RollcallController extends CControl{
	public function __construct(){
        parent::__construct();
        Ebh::app()->room->checkteacher();
		$this->apiServer = Ebh::app()->getApiServer('ebh');
		$this->roominfo = Ebh::app()->room->getcurroom();
		$this->user = Ebh::app()->user->getloginuser();
	}
	
	
	public function index(){
		$this->display('troomv2/rollcall');
	}
	
	/*
	上课列表
	*/
	public function lists(){
		$data['crid'] = $this->roominfo['crid'];
		$data['pagesize'] = $this->input->get('pagesize');
		$data['page'] = $this->input->get('page');
		$data['q'] = $this->input->get('q');
		$data['rid'] = $this->input->get('rid');
		$data['uid'] = $this->user['uid'];
		$cwlist = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.list')->addParams($data)->request();
		$this->renderjson(0,'',$cwlist);
	}
	
	
	/*
	新添上课
	*/
	public function add(){
		$param = $this->input->post();
		if(!empty($param)){
			$param['crid'] = $this->roominfo['crid'];
			$param['uid'] = $this->user['uid'];
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.add')->addParams($param)->request();
			if(!empty($res)){
				$this->renderjson(0,'成功');
			} else {
				$this->renderjson(1,'失败');
			}
		} else {
			$this->display('troomv2/rollcall_add');
		}
	}
	
	/*
	去报名
	*/
	public function addUser(){
		if($this->input->post()){
			$param['rid'] = $this->input->post('rid');
			$param['uids'] = $this->input->post('uids');
			$param['uid'] = $this->user['uid'];
			$param['crid'] = $this->roominfo['crid'];
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.addUser')->addParams($param)->request();

			if(!empty($res)){
				$this->renderjson(0,'成功');
			} else {
				$this->renderjson(1,'失败');
			}
		} else {
			$this->display('troomv2/rollcall_adduser');
		}
	}
	
	/*
	编辑
	*/
	public function edit(){
		$param = $this->input->post();
		if(!empty($param)){
			$param['crid'] = $this->roominfo['crid'];
			$param['uid'] = $this->user['uid'];
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.edit')->addParams($param)->request();
			if($res !== FALSE){
				$this->renderjson(0,'成功');
			} else {
				$this->renderjson(1,'失败');
			}
		} else {
			$this->display('troomv2/rollcall_edit');
		}
	}
	
	/*
	删除
	*/
	public function del(){
		$param['rid'] = $this->input->post('rid');
		if(!empty($param['rid'])){
			$param['crid'] = $this->roominfo['crid'];
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.del')->addParams($param)->request();
			if(!empty($res)){
				$this->renderjson(0,'成功');
			} else {
				$this->renderjson(1,'失败');
			}
		}
	}
	
	/*
	点名
	*/
	public function call(){
		$param = $this->input->post();
		if(!empty($param)){
			$param['crid'] = $this->roominfo['crid'];
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.call')->addParams($param)->request();
			if($res !== FALSE){
				$this->renderjson(0,'成功');
			} else {
				$this->renderjson(1,'失败');
			}
		} else {
			$this->display('troomv2/rollcall_call');
		}
	}
	
	/*
	需点名的学生列表
	*/
	public function rollList(){
		$param = $this->input->get();
		$param['crid'] = $this->roominfo['crid'];
		if(empty($param['rid'])){
			$this->renderjson(1,'参数不正确');
		}
		$rolllist = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.rollList')->addParams($param)->request();
		$this->renderjson(0,'',$rolllist);
	}
	
	/*
	全局统计
	*/
	public function statsAll(){
		$classid = $this->input->get('classid');
		if(empty($classid)){
			$this->renderjson(1,'请选择班级');
		}
		$param['classid'] = $classid;
		$param['crid'] = $this->roominfo['crid'];
		$userlist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.subDeptUsers')->addParams($param)->request();
		$usercount = count($userlist);
		if(!empty($userlist)){
			$userarr = array();
			foreach($userlist as $user){
				$userarr[$user['uid']] = $user;
				$uids[] = $user['uid'];
			}
			$uids = implode(',',$uids);
			$stats = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.stats')->addParams(array('crid'=>$param['crid'],'uids'=>$uids))->request();
			// $this->renderjson(0,'',$stats);
			$userlist = $stats['userlist'];
			$uniqueuserlist = array();
			foreach($userlist as &$user){
				$uid = $user['uid'];
				$user['realname'] = empty($userarr[$uid]['realname'])?'':$userarr[$uid]['realname'];
				$user['username'] = empty($userarr[$uid]['username'])?'':$userarr[$uid]['username'];
				$user['uncalledcount'] = $user['totalcount'] - $user['calledcount'];
				$user['calledpercent'] = $user['totalcount'] == 0?0:($user['calledcount']/$user['totalcount']);
				if(isset($uniqueuserlist[$uid])){
					$uniqueuserlist[$uid]['totalcount'] += $user['totalcount'];
					$uniqueuserlist[$uid]['calledcount'] += $user['calledcount'];
				} else {
					$uniqueuserlist[$uid]['totalcount'] = $user['totalcount'];
					$uniqueuserlist[$uid]['calledcount'] = $user['calledcount'];
				}
			}
			foreach($uniqueuserlist as &$uuser){
				$uuser['calledpercent'] = $uuser['totalcount'] == 0?0:($uuser['calledcount']/$uuser['totalcount']);
			}
			$rcount = empty($stats['rcount'])?0:intval($stats['rcount']);
			$totalcount = empty($stats['totalcount'])?0:intval($stats['totalcount']);
			$calledpercentarr = array_column($uniqueuserlist,'calledpercent');
			$calledpercent = round(array_sum($calledpercentarr)/$usercount*100,2);
			$hotcw = empty($stats['hotcw'])?array():$stats['hotcw'];
		} else{
			$rcount = 0;//上课次数
			$totalcount = 0;//总到课数
			$calledpercent = 0;//平均到课比
			$hotcw = array();//最受欢迎的课
		}
		$this->renderjson(0,'',array('userlist'=>$userlist,'usercount'=>$usercount,'rcount'=>$rcount,'totalcount'=>$totalcount,'calledpercent'=>$calledpercent,'hotcw'=>$hotcw));
	}
    /**
    *网校学习状态总览
    */
    public function classroomStatus(){
        $usernum = 0;//网校总人数
        $cwcount = 0;//总学习次数
        $calledcount = 0;//总学习人次
        $percent = 0;//平均到课率
        $param['crid'] = $this->roominfo['crid'];
        $info = $this->apiServer->reSetting()->setService('Classroom.Classroom.detail')->addParams($param)->request();
        if(!empty($info)){ $usernum = $info['data']['teanum'] + $info['data']['stunum']; }
        $rinfo = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.classroomStatus')->addParams($param)->request();
        $cwcount = !empty($rinfo['cwcount']) ? $rinfo['cwcount'] : 0;
        $calledcount = !empty($rinfo['calledcount']) ? $rinfo['calledcount'] : 0;
        $percent = !empty($rinfo['percent']) ? $rinfo['percent'] : 0;
        $this->renderjson(0,'',array('usernum'=>$usernum,'cwcount'=>$cwcount,'calledcount'=>$calledcount,'percent'=>$percent));
    }
    /**
    *上课列表，返回当前部门及子部门上课详情
    */
    public function classLists(){
        $param['crid'] = $this->roominfo['crid'];
        $post = $this->input->post();
        $param['classid'] = !empty($post['classid']) ? intval($post['classid']) : 0;
        $param['pagesize'] = !empty($post['pagesize']) ? intval($post['pagesize']) : 30;
        $param['page'] = !empty($post['page']) ? intval($post['page']) : 0;
        if(!empty($post['begintime'])){ $param['begintime'] = strtotime($post['begintime']); }
        if(!empty($post['lasttime'])){ $param['lasttime'] = strtotime($post['lasttime']); }
        if(isset($post['q'])){ $param['q'] = h($post['q']); }
        if(!empty($post['rids'])){ $param['rids'] = h($post['rids']); }
        $classids = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.subDepartment')->addParams($param)->request();
        if(!empty($classids)){
            $param['classids'] = $classids;
        }
        $cwlist = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.classList')->addParams($param)->request();
        if(!empty($cwlist)){
            $this->renderjson(0,'',$cwlist);
        }else{
            $this->renderjson(1,'未查到上课列表详情');
        }
    }
	/**
     * json格式输出
     * @param number $code 状态标识 0 成功 1 失败
     * @param string $msg 输出消息
     * @param array $data 数组参数数组
     * @param string $exit 是否结束退出
     */
    private function renderjson($code=0,$msg="",$data=array(),$exit=true){
        $arr = array(
            'code'=>(intval($code) ===0) ? 0 : intval($code),
            'msg'=>$msg,
            'data'=>$data
        );
        echo json_encode($arr);
        if($exit){
            exit();
        }
    }
}
?>