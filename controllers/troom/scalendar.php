<?php
/**
 * 学生监察控制器
 */
class ScalendarController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $classid = $this->uri->uri_attr(0); //班级编号
        $type = $this->uri->uri_attr(1);    //类型，1 听课笔记 2 学生作业 3学生记录 4查看错题集
        $typename = '';
        if($type == 1)
            $typename = '听课笔记';
        else if($type == 2)
            $typename = '学生作业';
        else if($type == 3)
            $typename = '学生记录';
        else if($type == 4)
            $typename = '查看错题集';
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $classmodel = $this->model('Classes');
        $classlist = $classmodel->getTeacherClassList($roominfo['crid'],$user['uid']);
        if(is_numeric($classid)) {
            $queryarr['classid'] = $classid;
        }
        $classidlist = '';
        $clist = array();   //classid为key和classname为value的数组
        foreach ($classlist as $c) {
            if(empty($classidlist))
                $classidlist = $c['classid'];
            else
                $classidlist .= ','.$c['classid'];
            $clist[$c['classid']] = $c['classname'];
        }
        if(!empty($classidlist))
            $queryarr['classidlist'] = $classidlist;
        $students = false;
        $pagestr = '';
        if(!empty($classidlist)) {
            $students = $classmodel->getClassStudentList($queryarr);
            $count = $classmodel->getClassStudentCount($queryarr);
            $pagestr = show_page($count);
            for($i = 0; $i < count($students); $i ++) {
                $students[$i]['classname'] = $clist[$students[$i]['classid']];
            }
        }
        
        $this->assign('classid', $classid);
        $this->assign('type', $type);
        $this->assign('typename', $typename);
        $this->assign('classlist', $classlist);
        $this->assign('q', $q);
        $this->assign('students', $students);
        $this->assign('pagestr', $pagestr);
        $this->display('troom/scalendar');
    }
    public function view() {
        $type = $this->uri->uri_attr(0);    //类型，1 听课笔记 2 学生作业 3学生记录 4查看错题集
        $studentid = $this->uri->itemid;
        if(empty($studentid) || !is_numeric($studentid))
            exit();
        $typename = '';
        if($type == 1)
            $typename = '听课笔记';
        else if($type == 2)
            $typename = '学生作业';
        else if($type == 3)
            $typename = '学生记录';
        else if($type == 4)
            $typename = '查看错题集';
        $usermodel = $this->model('User');
        $student = $usermodel->getuserbyuid($studentid);
     
        $this->assign('type', $type);
        $this->assign('typename', $typename);
        $this->assign('student', $student);
        $this->display('troom/scalendar_view');
    }
    public function detail() {
        $user = Ebh::app()->user->getloginuser();
        $uid = $this->input->post('uid');
        $type = $this->input->post('type');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $result = array('examcount'=>array(),'subjectcount'=>array(),'askcount'=>array(),'errorcount'=>array(),'listencount'=>array());
        if($uid == NULL || !is_numeric($uid) || $type == NULL || $startDate == NULL || $endDate == NULL) {
            echo json_encode($result);
            return;
        }
        $startDate = explode("-", $startDate);
	$endDate = explode("-", $endDate);
	$startDate = mktime(0,0,0,$startDate[1],$startDate[2],$startDate[0]);
	$endDate = mktime(0,0,0,$endDate[1],$endDate[2],$endDate[0])+24*3600;
        $exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
        $param = array('uid'=>$uid,'tid'=>$user['uid'],'startDate'=>$startDate,'endDate'=>$endDate,'crid'=>$roominfo['crid']);
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
}
