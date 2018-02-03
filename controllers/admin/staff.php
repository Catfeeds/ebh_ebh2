<?php
/*
内部用户
*/
class StaffController extends AdminControl{
	
	public function index(){
		// $this->getlist(1);
		$this->display('admin/staff');
	}
	public function getlist($init=0){
		
		$staff = $this->model('staff');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $staff -> getstaffcount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$stafflist = $staff -> getstafflist($pagination);
		for($i = 0; $i < count($stafflist); $i ++) {
			$thestaff = $stafflist[$i];
			unset($thestaff['uid']);
		}
		if(!$init){
			$stafflist[] = $pagination;
			echo json_encode($stafflist);
		}
		else{
			$this->assign('stafflist',json_encode($stafflist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','staff');
		}
		
		
	}
	public function getListAjax(){
		$query = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$queryArr['q'] = $query;
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$list = $this->model('staff')->getstafflist($queryArr);
		$total = $this->model('staff')->getstaffcount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	/*
	添加内部用户
	*/
	public function add(){
		if($this->input->post())
		{
			$staff = $this->model('staff');
			$param = array();
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$groupid = $this->input->post('groupid');
			$flag = TRUE;
			if(!is_numeric($groupid) || $groupid <= 0)
				$flag = FALSE;
			if(empty($username) || empty($password)) {
				$flag = FALSE;
			} else if(strlen(trim($username)) < 6 || strlen(trim($password)) < 6){
				$flag = FALSE;
			}
			$param['username'] = trim($username);
			$param['password'] = trim($password);
			$param['groupid'] = $groupid;
			$param['status'] = 1;
			if($flag && $staff->addstaff($param)>0){
				$this->goback();
			}else{
				$this->goback('操作失败!');
			}
		}
		else{
			$this->display('admin/staff_add');
		}
	}
	/*
	staff用户组
	*/
	public function getgroup(){
		$staff = $this->model('staff');
		$grouplist = $staff->getgrouplist();
		echo json_encode($grouplist);
	}
	/*
	修改 ajax;
	*/
	public function editstaff(){
		$staff = $this->model('staff');
		$param = $this->input->post();
		
		echo $staff->editstaff($param);
	}
	/**
	 *操作成功或者失败之后的跳转页面
	 */
	public function goback($note="操作成功,正在努力为您跳转...",$returnurl="/admin/staff.html"){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}

}
?>