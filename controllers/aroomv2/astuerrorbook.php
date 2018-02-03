<?php 
class AstuerrorbookController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getloginuser();
		$this->assign('user',$this->user);
	}
	
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		
		$roomuser = $this->model('roomuser');
		$classid = $this->uri->uri_attr(0);
		$param['classid']=0;
		if(is_numeric($classid))
			$param['classid'] = $classid;
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);
		$errorbook = $this->model('errorbook');
		$errorlist = $errorbook->getSchoolErrorBookList($param);
		$errorcount= $errorbook->getSchoolErrorBookCount($param);
		// var_dump($errorlist);
		$this->assign('errorcount',$errorcount);
		$this->assign('errorlist',$errorlist);
		$this->assign('roomdetail',$roomdetail);
		$this->assign('classid',$classid);
		$this->assign('page',$param['page']);
		$this->assign('pagesize',$param['pagesize']);
		$this->assign('search',$param['q']);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->display('aroomv2/astuerrorbook');
	}
}
?>