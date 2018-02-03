<?php

/**
 * ������ҳ��
 */
class OverController extends CControl {
    public function index() {
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		if(empty($user) || $user['groupid'] != 6) {
			header("Location: /");
			exit();
		}
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($roominfo)) {
			header("Location: /");
			exit();
		}
		$this->assign('room',$roominfo);
		$this->display('common/over');
	}
}
?>
