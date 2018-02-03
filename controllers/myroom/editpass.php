<?php
class EditpassController extends CControl{
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
		if($this->input->post()!=null){
			$user = Ebh::app()->user->getloginuser();
			$member = $this->model('member');
			if($user['password']==md5($this->input->post('oldpassword'))){
				$param['password'] = $this->input->post('password');
				$param['uid'] = $user['uid'];
				$res = $member->editmember($param);
				if($res){
					echo 1;
				}
			}
		}else{
			$this->display('myroom/editpass');
		}
	}
	
	public function checkoldpassword(){
		$user = Ebh::app()->user->getloginuser();
		if($user['password']==md5($this->input->post('oldpassword')))
			echo 1;
		else echo 0;
	}
}

?>