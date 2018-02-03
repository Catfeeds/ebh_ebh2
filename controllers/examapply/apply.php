<?php
/*
	考试申请
	*/
class ApplyController extends CControl{
	public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();

		//获取省列表
		$provinces = $this->model('cities')->getCitiesByCode(5, null);
		$this->assign('provinces', $provinces);

		$apply = $this->model('examapply')->getOneApply(array('uid'=>$user['uid'], 'crid'=>$roominfo['crid']));
		$this->assign('apply', $apply);

		if (!empty($apply) && ($apply['status'] == 1 || $apply['status'] == 0))
		{
			$this->display('examapply/apply_view');
		}
		else
		{
			$this->display('examapply/apply');
		}
	}

	public function getCities() {
		$citycode = $this->input->post('citycode');
		$citycode = empty($citycode) ? null : $citycode;
		$cities = $this->model('cities')->getCitiesByCode(1,$citycode);
		$_html = '';
		foreach ($cities as $city){
			$_html .= '<a href="javascript:void(0)" vid="' . $city['citycode'] . '">' . $city['cityname'] . '</a>';
		}
		echo $_html;
	}

	public function add(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();

		$param['applyid'] = $this->input->post('applyid');
		$param['photo'] = $this->input->post('photo');
		$param['realname'] = $this->input->post('realname');
		$param['namespell'] = $this->input->post('namespell');
		$param['sex'] = $this->input->post('sex');
		$param['birthyear'] = $this->input->post('birthyear');
		$param['birthmonth'] = $this->input->post('birthmonth');
		$param['idcard'] = $this->input->post('idcard');
		$param['mobile'] = $this->input->post('mobile');
		$param['email'] = $this->input->post('email');
		$param['address'] = $this->input->post('address');
		$param['citycode'] = $this->input->post('citycode');
		$param['zipcode'] = $this->input->post('zipcode');
		$param['schoolname'] = $this->input->post('schoolname');
		$param['major'] = $this->input->post('major');
		$param['stuid'] = $this->input->post('stuid');
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];

		//check
		//idcard
		if (!preg_match('/(^\d{15}$)|(^\d{17}(\d|X|x)$)/', $param['idcard']))
		{
			echo json_encode(array('status' => -1, 'msg' => '身份证号码错误'));
			exit;
		}
		//mobile
		if (!preg_match('/^1\d{10}$/', $param['mobile']))
		{
			echo json_encode(array('status' => -2, 'msg' => '手机号码错误'));
			exit;
		}
		//email
		if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $param['email']))
		{
			echo json_encode(array('status' => -3, 'msg' => '电子邮箱错误'));
			exit;
		}
		//zipcode
		if (!preg_match('/^\d{6}$/', $param['zipcode']))
		{
			echo json_encode(array('status' => -4, 'msg' => '邮政编码错误'));
			exit;
		}


		if (empty($param['applyid']))
		{
			$result = $this->model('examapply')->addapply($param);
		}
		else
		{
			$result = $this->model('examapply')->editapply($param);
		}
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0, 'msg' => '提交失败'));
			exit;
		}
	}

	/**
	 * 撤销申请
	 */
	public function cancel(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param['applyid'] = $this->input->post('applyid');
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];

		$result = $this->model('examapply')->cancelapply($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0, 'msg' => '撤销失败'));
			exit;
		}

	}

}
?>