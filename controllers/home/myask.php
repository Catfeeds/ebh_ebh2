<?php

/**
 * 学生我的答疑控制器类 MyaskController
 */
class MyaskController extends CControl {

    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
    }
    /**
     * 问题详情
     */
    public function view() {
        $qid = $this->uri->itemid;
        if (is_numeric($qid)) {
            $editor = Ebh::app()->lib('UMEditor');
            $param = parsequery();
			$param['qid'] = $qid;
			$param['pagesize'] = 10;
            $askmodel = $this->model('Askquestion');
            $user = Ebh::app()->user->getloginuser();
            //人气数+1
            $askmodel->addviewnum($qid);
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
            $answers = $askmodel->getdetailanswersbyqid($param);
            $count = $askmodel->getdetailanswerscountbyqid($qid);
            $pagestr = show_page($count);
            $this->assign('ask', $ask);
            $this->assign('answers', $answers);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->display('home/myask_view');
        }
    }
}
