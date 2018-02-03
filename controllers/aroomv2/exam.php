<?php
//作业
class ExamController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$exammodel = $this->model('exam');
		$param = parsequery();
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');
		$param['starttime'] = strtotime($startdate);
		$param['endtime'] = strtotime($enddate);
		$param['crid'] = $roominfo['crid'];
		$examlist = $exammodel->getschexamlist($param);
        foreach($examlist as &$exam){
            if(!empty($exam['grade'])){
                $gradenum = $this->model('classroom')->getStudentsCountByGrade(array('crid'=>$roominfo['crid'],'grade'=>$exam['grade']));
                $exam['stunum'] = $gradenum;
            }
        }
		$examcount = $exammodel->getschexamlistcount($param);
		// var_dump($examlist);
		$pagestr = show_page($examcount);
		$this->assign('q',$param['q']);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('pagestr',$pagestr);
		$this->assign('examlist',$examlist);
		$this->display('aroomv2/exam_list');
	}
}
?>