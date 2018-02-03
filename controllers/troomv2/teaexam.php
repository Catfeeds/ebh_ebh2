<?php
/**
 * 教师我的题库控制器TeaexamController
 */
class TeaexamController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $crid = $roominfo['crid'];
        $this->assign('crid', $crid);
        $this->display('troomv2/teaexam');
    }
}
