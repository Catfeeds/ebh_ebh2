<?php
/**
 *学生互动课堂控制器
 */
class IaclassroomController extends CControl{
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

		$IaLogsModel = $this->model('iaclassroomlog');
		$param = parsequery();
		//获取这个学生所在该校所属的班级
		$classesModel = $this->model('classes');
		$stuClassInfo = $classesModel->getClassByUid($roominfo['crid'],$user['uid']);
		if(empty($stuClassInfo)){
			exit;
		}
		$classTeacherList = $classesModel->getClassTeacherByClassid($stuClassInfo['classid']);
		if(empty($classTeacherList)){
			exit;
		}
		$tidArr = array();
		foreach ($classTeacherList as $classTeacher) {
			array_push($tidArr, $classTeacher['uid']);
		}
		$tid_in = '('.implode(',', $tidArr).')';
		$param = array_merge(array(
				'crid'=>$roominfo['crid'],
				'uid'=>$user['uid'],
				'tid_in'=>$tid_in,
				'classid'=>$stuClassInfo['classid'],
				'order'=>'ic.icid desc'
				),$param);
		$ialogs = $IaLogsModel->getList($param);
		$ialogs = EBH::app()->lib('UserUtil')->setFaceSize('50_50')->init($ialogs,array('uid'),true);
		$ialogsCount = $IaLogsModel->getListCount($param);
		$pagestr = show_page($ialogsCount,$param['pagesize']);
		$this->assign('q',$param['q']);
		$this->assign('ialogs',$ialogs);
		$this->assign('pageStr',$pagestr);
		$this->display('myroom/iaclassroom');
	}

	public function answer(){
		$user = Ebh::app()->user->getloginuser();
		$data = array(
			'uid'=>$user['uid'],
			'icid'=>$this->input->post('icid'),
			'FileName'=>$this->input->post('FileName')
		);
		$up_config = Ebh::app()->getConfig()->load('upconfig');
		$iroom_config = $up_config['iroom'];
		$post_url = $iroom_config['posturl_for_answer'];
		$res = do_post($post_url,$data);
		log_message('post_url:'.$post_url);
		echo $res;
	}
}