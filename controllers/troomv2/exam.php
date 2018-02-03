<?php
/**
 * 教师网校在线测评(在线作业)控制器类 of exam
 */
class ExamController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $exammodel = $this->model('Exam');
        $exams = $exammodel->getexamlist($queryarr);
        $count = $exammodel->getexamlistcount($queryarr);
        $pagestr = show_page($count);
        $this->assign('exams', $exams);
        $this->assign('pagestr', $pagestr);
        $this->display('troomv2/exam');
    }
    /**
     * 批阅作业
     */
    public function all() {
        $roominfo = Ebh::app()->room->getcurroom();
        $menuid = $this->uri->uri_attr(0);
        if($menuid != 1)    //1为已批阅,0为待批阅
            $menuid = 0;    
        $q = $this->input->get('q');
        $name = $this->input->get('name');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['name'] = $name;
        if($menuid == 1) {
            $user = Ebh::app()->user->getloginuser();
            $queryarr['tid'] = $user['uid'];
        }
        $exammodel = $this->model('Examanswer');
        $exams = $exammodel->getexamanswers($queryarr);
        $count = $exammodel->getexamanswerscount($queryarr);
        $pagestr = show_page($count);
        $this->assign('exams', $exams);
        $this->assign('pagestr', $pagestr);
        $this->assign('q', $q);
        $this->assign('name', $name);
        $this->assign('menuid', $menuid);
        $this->display('troomv2/exam_all');
    }
    /**
     *删除作业 
     */
    public function del() {
        $eid = $this->input->post('eid');
        $cwid = $this->input->post('cwid');
        if(!empty($eid) && is_numeric($eid) && !empty($cwid) && is_numeric($cwid)) {
            $roominfo = Ebh::app()->room->getcurroom();
            $exammodel = $this->model('Exam');
            $afrows = $exammodel->delexam($roominfo['crid'],$cwid,$eid);
            if($afrows > 0) {
                $coursemodel = $this->model("Courseware");
                $coursemodel->addexamnum($cwid,-1);
                echo 'success';
            } else {
                echo 'fail';
            }
        }
    }
}
