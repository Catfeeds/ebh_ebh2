<?php
/**
 * 在线组卷控制器类ExampaperController
 */
class ExampaperController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $crid = $roominfo['crid'];
        $this->assign('crid', $crid);
        $this->display('troomv2/exampaper');
    }
    /**
     * 组卷记录
     */
    public function paperrecord() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $crid = $roominfo['crid'];
        $queryarr = parsequery();
        $queryarr['crid'] = $crid;
        $queryarr['uid'] = $user['uid'];
        $papermodel = $this->model('Paper');
        $papers = $papermodel->getPaperList($queryarr);
        $count = $papermodel->getPaperCount($queryarr);
        $page_str = show_page($count);
        $this->assign('crid', $crid);
        $this->assign('papers', $papers);
        $this->assign('page_str', $page_str);
        $this->display('troomv2/paperrecord');
    }
    /**
     * 删除组卷
     */
    public function del() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $crid = $roominfo['crid'];
        $pid = $this->input->post('pid');
        if(empty($pid) || !is_numeric($pid)) {
            echo 'fail';
            exit;
        }
        $papermodel = $this->model('Paper');
        $paper = $papermodel->getPaper($pid);
        if(empty($paper) || $paper['uid'] != $user['uid']) {
            echo 'fail';
            exit;
        }
        $result = $papermodel->delPaper($pid);
        if($result) {
            echo 'success';
            exit;
        }
        echo 'fail';
    }
}
