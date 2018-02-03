<?php
/**
 * 教师选择教室控制器
 * 一般用户教师在大厅登录后的返回页面
 */
class ChooseController extends CControl {
	public function index() {
		$user = Ebh::app()->user->getloginuser();
		if(empty($user) || $user['groupid'] != 5) {
			header("Location: /");
			return;
		}
		$roommodel = $this->model('Classroom');
		$roomlist = $roommodel->getTVroomlist();
		$this->assign('user',$user);
		$this->assign('roomlist',$roomlist);
		$this->display('aroomv2/choose');
	}
}