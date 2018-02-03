<?php
/**
 * 网校学生我的教室 MyroomController
 */
class MyroomController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkstudent();
    }
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$rumodel = $this->model('Roomuser');
		$userdetail = $rumodel->getroomuserdetail($roominfo['crid'],$user['uid']);
		//我已选课程
		$foldermodel = $this->model('Folder');
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$queryarr['filternum'] = 1;
		$queryarr['haschoose'] = 1;
		$queryarr['limit'] = '0,20';
		$folders = $foldermodel->getmemberfolderlist($queryarr);
		$haschoose = 1;
		if(empty($folders)) {
			$queryarr['haschoose'] = 0;
			$folders = $foldermodel->getmemberfolderlist($queryarr);
			$haschoose = 0;
		}
		$this->assign('folders',$folders);
		$this->assign('haschoose',$haschoose);
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->assign('userdetail',$userdetail);
		$this->display('myroom/myroom');
    }
}
