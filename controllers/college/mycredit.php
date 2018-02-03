<?php
/**
 *学生学分获取统计
 */
class MycreditController extends CControl{
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
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$SchcreditlogModel = $this->model('schcreditlog');

		$param = parsequery();
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$offset = max(($param['page']-1)*$param['pagesize'],0);
		$param['limit'] = $offset.','.$param['pagesize'];

		//获取学生学分获取记录
		$creditlogList = $SchcreditlogModel->getList($param);
		$creditlogListCount = $SchcreditlogModel->getListCount($param);

		//获取学生总的学分
		$totalScore = $SchcreditlogModel->getTotalScore($param);
		if(empty($totalScore)){
			$totalScore = 0;
		}

		//获取学生所在班级信息
		$classModel = $this->model('classes');
		$stuClassInfo = $classModel->getClassByUid($roominfo['crid'],$user['uid']);
		$grade = $stuClassInfo['grade'];
		//获取学生所在年级对应的合格学分
		$schcreditModel = $this->model('schcredit');
		$gradeScoreList = $schcreditModel->getScoreList(array('crid'=>$roominfo['crid'],'grade'=>$grade));
		$stuOkScore = empty($gradeScoreList[0])?0:$gradeScoreList[0]['score'];

		//获取分页
		$pageStr = show_page($creditlogListCount,$param['pagesize']);

		$this->assign('creditlogList',$creditlogList);
		$this->assign('pageStr',$pageStr);
		$this->assign('totalScore',$totalScore);
		$this->assign('stuOkScore',$stuOkScore);		
		$this->display('college/mycredit');
	}
}