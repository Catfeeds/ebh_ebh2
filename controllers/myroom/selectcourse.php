<?php
/**
 * 在线选课控制器
 */
class SelectcourseController extends CControl {
	public function __construct(){
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
	 * 选课列表
	 */
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$q = $this->input->get('q');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['nosubfolder'] = 1;
		$myclass = $this->model('classes')->getClassByUid($roominfo['crid'],$user['uid']);
		if(!empty($myclass['grade'])) {
			$param['mygrade'] = $myclass['grade'];
		}
		$param['order'] = 'f.displayorder asc,f.folderid desc';
		$courselist = $this->model('selectcourse')->getCourseList($param);
		$coursecount = $this->model('selectcourse')->getCourseCount($param);

		//已报名课程信息
		$regcourse = $this->model('selectcourse')->getRegCourse(array(
			'uid'=>$user['uid'],
			'crid'=>$roominfo['crid']
		));
		//报名时间
		$regtime = $this->model('selectcourse')->getRegTime($roominfo['crid']);

		$pagestr = show_page($coursecount);
		$this->assign('q',$q);
		$this->assign('pagestr',$pagestr);
		$this->assign('courselist',$courselist);
		$this->assign('regcourse',$regcourse);
		$this->assign('regtime',$regtime);
		$this->assign('roominfo',$roominfo);
		$this->display('myroom/selectcourse');
	}

	/**
	 * 报名操作
	 */
	public function regcourse() {
		$folderid = $this->input->post('folderid');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();

		//检查报名时间
		$this->_checkregtime();

		//检查报名人数
		$coursedetail = $this->model('selectcourse')->getCourseDetail($folderid);
		//报名人数已满
		if ($coursedetail['regnum'] >= $coursedetail['admitnum'])
		{
			echo json_encode(array('code' => 0, 'message' => '该课程报名人数已满，请选择其他课程！'));
			exit;
		}

		//检查报名年级
		$myclass = $this->model('classes')->getClassByUid($roominfo['crid'],$user['uid']);
		if(!empty($myclass['grade'])) {
			if (!empty($coursedetail['allowgrade']) && strpos($coursedetail['allowgrade'], ','.$myclass['grade'].',') === FALSE ){
				echo json_encode(array('code' => 0, 'message' => '您的年级不符合该课程报名要求！'));
				exit;
			}
		}

		$param['folderid'] = $folderid;
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$res = $this->model('selectcourse')->regCourse($param);
		if ($res !== false)
		{
			echo json_encode(array('code' => 1, 'message' => '报名成功'));
			exit;
		}
		else
		{
			echo json_encode(array('code' => 0, 'message' => '报名失败'));
			exit;
		}
	}

	/**
	 * 取消报名操作
	 */
	public function unregcourse() {
		$code = 0;
		$message = '取消报名失败';
		$folderid = $this->input->post('folderid');
		$user = Ebh::app()->user->getloginuser();

		//检查报名时间
		$this->_checkregtime();

		$regcourse = $this->model('selectcourse')->getRegCourse(array(
			'uid' => $user['uid'],
			'folderid' => $folderid
		));
		if (empty($regcourse))
		{
			echo json_encode(array('code' => 0, 'message' => '取消报名失败！'));
			exit;
		}

		$res = $this->model('selectcourse')->unRegCourse(array(
			'uid' => $user['uid'],
			'folderid' => $folderid
		));
		if ($res !== false)
		{
			echo json_encode(array('code' => 1, 'message' => '取消报名成功'));
			exit;
		}
		else
		{
			echo json_encode(array('code' => 0, 'message' => '取消报名失败'));
			exit;
		}

	}

	/**
	 * ajax获取课程详情
	 */
	public function getdetail() {
		$folderid = $this->input->post('folderid');
		$coursedetail = $this->model('selectcourse')->getCourseDetail($folderid);
		if (!empty($coursedetail))
		{
			echo json_encode(array('code' => 1, 'course_name' => $coursedetail['foldername'], 'course_summary' => $coursedetail['summary']));
			exit;
		}
		else
		{
			echo json_encode(array('code' => 0));
			exit;
		}
	}

	/**
	 * 验证报名时间
	 */
	public function _checkregtime() {
		$roominfo = Ebh::app()->room->getcurroom();
		$regtime = $this->model('selectcourse')->getRegTime($roominfo['crid']);
		if (empty($regtime['begintime']) || $regtime['begintime'] > SYSTIME)
		{
			echo json_encode(array('code' => 0, 'message' => '报名未开始！'));
			exit;
		}
		elseif (!empty($regtime['endtime']) && $regtime['endtime'] < SYSTIME)
		{
			echo json_encode(array('code' => 0, 'message' => '报名已结束！'));
			exit;
		}
	}
}