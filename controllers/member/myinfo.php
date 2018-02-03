<?php
	class MyinfoController extends CControl{
		public function index(){
			$user = Ebh::app()->user->getloginuser();
			if(!empty($user)){
				if($user['groupid'] == 6){
					$memberInfo = $this->model('member')->getmemberdetail($user['uid']);
					$this->assign('memberInfo',$memberInfo);
					$this->display('member/myinfo');
				}else{
					$teacherInfo = $this->model('teacher')->getteacherdetail($user['uid']);
					$this->assign('teacherInfo',$teacherInfo);
					$this->display('teacher/myinfo');
					
				}
			}
		}
		public function view(){
			$uid = intval($this->uri->lastsegment());
			$user = $this->model('user')->getuserbyuid($uid);
			if($user['groupid'] == 6){
				$memberInfo = $this->model('member')->getmemberdetail($uid);
				$this->assign('memberInfo',$memberInfo);
				$this->display('member/myinfo');
			}else{
				$teacherInfo = $this->model('teacher')->getteacherdetail($uid);
				$this->assign('teacherInfo',$teacherInfo);
				$this->display('teacher/myinfo');
			}
		}
	}
?>