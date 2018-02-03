<?php
/**
 * 学员笔记控制器类notes
 */
class NotesController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $q = $this->input->get('q');
        $stardateline = '';
        $enddateline = '';
        $begintime = $this->input->get('begintime');
        if(!empty($begintime)) {
           $stardateline = strtotime($begintime);
        }
        $endtime = $this->input->get('endtime');
        if(!empty($endtime)) {
            $enddateline = strtotime($endtime);
            if($enddateline > 0)
                $enddateline = $enddateline + 86400;
        }
        $notemodel = $this->model('Note');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['stardateline'] = $stardateline;
        $queryarr['enddateline'] = $enddateline;
        $notes = $notemodel->getnotelistbycrid($queryarr);
        $count = $notemodel->getnotelistcountbycrid($queryarr);
        $pagestr = show_page($count);
        $this->assign('q', $q);
        $this->assign('begintime', $begintime);
        $this->assign('endtime', $endtime);
        $this->assign('notes', $notes);
        $this->assign('pagestr', $pagestr);
        $this->display('troomv2/notes');
    }
}
