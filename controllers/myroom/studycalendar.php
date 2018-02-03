<?php
/**
 * 学生监察控制器
 */
class StudycalendarController extends CControl {
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
    public function index() {
        $this->display('myroom/studycalendarl');
    }
	/**
	*学生学习记录
	*/
	public function studylog() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$playmodel = $this->model('Playlog');
		$queryarr = parsequery();
		$q = $this->input->get('q');
		$d = $this->input->get('d');
		if(!empty($d)) {
			$startDate = strtotime($d);
			if($startDate !== FALSE) {
				$endDate = $startDate + 86400;
				$queryarr['startDate'] = $startDate;
				$queryarr['endDate'] = $endDate;
			}
		}
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$queryarr['totalflag'] = 0;
		$playlogs = $playmodel->getList($queryarr);
		$count = $playmodel->getListCount($queryarr);
		$pagestr = show_page($count);
		$this->assign('roominfo',$roominfo);
		$this->assign('q',$q);
		$this->assign('d',$d);
		$this->assign('playlogs',$playlogs);
		$this->assign('pagestr',$pagestr);
		$this->display('myroom/studylog');
	}
	/**
	*学习记录数
	*/
    public function detail() {
        $user = Ebh::app()->user->getloginuser();
        $type = $this->input->post('type');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $result = array('examcount'=>array(),'subjectcount'=>array(),'askcount'=>array(),'errorcount'=>array(),'listencount'=>array());
        if($type === NULL || empty($startDate) || empty($endDate)) {
            echo json_encode($result);
            return;
        }
		$startDate = strtotime($startDate);
		$endDate = strtotime($endDate);
		if($startDate === FALSE || $endDate === FALSE) {
			echo json_encode($result);
            return;
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$endDate = $endDate + 86400;
        $param = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'startDate'=>$startDate,'endDate'=>$endDate);
		$exammodel = $this->model('Exam');
		if ($type == 0) {	//获取所有记录
			$result['listencount'] = $exammodel->getNoteCount($param);//听课笔记
            $result['examcount'] = $exammodel->getExamCountByDate($param);	//做作业记录
			$param['totalflag'] = 0;
            $result['subjectcount'] = $exammodel->getStudyCount($param);	//学习记录
            $result['askcount'] = $exammodel->getAskCount($param);//查看答疑答题
		}
        if ($type == 1) {   //听课笔记记录
            $result['listencount'] = $exammodel->getNoteCount($param);//听课笔记
        } else if ($type == 2) {    //学生作业记录
            $result['examcount'] = $exammodel->getExamCountByDate($param);
        } else if ($type == 3) {    //学生学习记录
			$param['totalflag'] = 0;
            $result['subjectcount'] = $exammodel->getStudyCount($param);
        } else if ($type == 4) {    //学生错题集记录
            $result['errorcount'] = $exammodel->getErrorCount($param);//查看错题集
        }
        echo json_encode($result);
    }
	/**
	*时长秒转换成字符显示
	*/
	function getltimestr($ltime) {
		if(empty($ltime))
			return '';
		$h = intval($ltime / 3600); 
		$m = intval(($ltime - $h * 3600)/60);
		$s = $ltime -$h * 3600 - $m*60;
		$str = $h.':'.str_pad($m,2,'0',STR_PAD_LEFT).':'.str_pad($s,2,'0',STR_PAD_LEFT);

		return $str;
	}
}
