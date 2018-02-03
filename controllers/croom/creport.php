<?php
class CreportController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkteacher();
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getclassroomdetail($roominfo['crid']);
		$croom = $this->model('croom');
		$param = parsequery();
		$scitycode = $this->uri->uri_attr(0);
		if(!is_numeric($scitycode))
			$scitycode = '';
		$param['filtercrid'] = $roominfo['crid'];
		$param['filtercontrol'] = 1;
		$param['citycode'] = $scitycode?$scitycode:$roomdetail['citycode'];
		$curcity = $croom->getCityList($param);
		$curcity = empty($curcity)?'':$curcity[0];
		$this->assign('curcity',$curcity);
		$reportinfo = $croom->getAllroonInfo($param);
		$classroomlist = $croom->getClassroomList($param);
		$classroomcount = $croom->getClassroomCount($param);
		// var_dump($classroomlist);
		$this->assign('classroomlist',$classroomlist);
		$this->assign('classroomcount',$classroomcount);
		// var_dump($classroomcount);
		unset($param['citycode']);
		$param['upcode'] = $roomdetail['citycode'];
		
		$citylist = $croom->getCityList($param);
		$this->assign('scitycode',$scitycode);
		$this->assign('citycode',$roomdetail['citycode']);
		$this->assign('q',$param['q']);
		$this->assign('citylist',$citylist);
		$this->assign('reportinfo',$reportinfo);
		$this->display('croom/creport');
	}
}
?>