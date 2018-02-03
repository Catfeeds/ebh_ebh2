<?php
/**
 * 学校学生收藏相关控制器 FavoriteController
 */
class FavoriteController extends CControl {
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
	
	/**
	*我的收藏/收藏的课件
	*/
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$favoritemodel = $this->model('Favorite');
		$myfavorites = $favoritemodel->getcoursefavoritelist($queryarr);
		$uids = array_column($myfavorites,'uid');
		if(!empty($uids)){
			$teacherlist = $this->model('Teacher')->getroomteacherlist($roominfo['crid'],array('uids'=>$uids,'pagesize'=>$queryarr['pagesize']));
			$teacherarr = array();
			foreach($teacherlist as $teacher){
				$teacherarr[$teacher['uid']] = $teacher;
			}
			$this->assign('teacherarr',$teacherarr);
		}
		$count = $favoritemodel->getcoursefavoritelistcount($queryarr);
		$pagestr = show_page($count);
		$from = $this->input->get('from');
		$this->assign('from',$from);
		$this->assign('roominfo',$roominfo);
		$this->assign('myfavorites',$myfavorites);
		$this->assign('pagestr',$pagestr);
		$this->assign('user', $user);
		$mnlib = Ebh::app()->lib('Modulename');
        $mnlib->getmodulename($this,array('modulecode'=>'study','tors'=>0,'crid'=>$roominfo['crid']));
		$this->display('myroom/favorite_course');
	}
	/**
	*收藏的课程
	*/
	public function subject() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$favoritemodel = $this->model('Favorite');
		$myfavorites = $favoritemodel->getfolderfavoritelist($queryarr);
		$count = $favoritemodel->getfolderfavoritelistcount($queryarr);
		$pagestr = show_page($count);
		$from = $this->input->get('from');
		$this->assign('from',$from);
		$this->assign('roominfo',$roominfo);
		$this->assign('myfavorites',$myfavorites);
		$this->assign('pagestr',$pagestr);
        $this->assign('user', $user);
		$mnlib = Ebh::app()->lib('Modulename');
        $mnlib->getmodulename($this,array('modulecode'=>'study','tors'=>0,'crid'=>$roominfo['crid']));
		$this->display('myroom/favorite_subject');
	}
	/**
	*课程收藏
	*/
	public function add() {
		$folderid = $this->input->post('folderid');
		$cwid = $this->input->post('cwid');
		$type = $this->input->post('type');
		if(NULL !== $type && (is_numeric($folderid) || is_numeric($cwid))) {
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getloginuser();
			$title = $this->input->post('title');
			$url = $this->input->post('url');
			$type = $this->input->post('type');
			$param = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'title'=>$title,'url'=>$url,'type'=>$type);
			if($type == 1) 
				$param['cwid'] = $cwid;
			else 
				$param['folderid'] = $folderid;
			$favoritemodel = $this->model('Favorite');
			$result = $favoritemodel->insert($param);
			if($result > 0) {
				echo 'success';
			}
		}
	}
	/**
	*删除收藏
	*/
	public function del() {
		$fid = $this->input->post('fid');
		if(is_numeric($fid) && $fid > 0) {
			$user = Ebh::app()->user->getloginuser();
			$favoritemodel = $this->model('Favorite');
			$result = $favoritemodel->deleteByUid($user['uid'],$fid);
			if($result) {
				echo 'success';
			} 
		}
	}

}
