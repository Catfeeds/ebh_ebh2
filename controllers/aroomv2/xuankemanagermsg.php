<?php
/**
 * Created by PhpStorm.
 * User: app
 * Date: 2016/7/18
 * Time: 11:19
 */
class XuankemanagermsgController extends CControl {
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $aid = intval($this->input->get('xkid'));
        $xuanke = $this->model('xuanke');
        $activity = $xuanke->getXuanke(array(
            'xkid' => $aid,
            'crid' => $roominfo['crid']
        ));
        if (!$activity) {
            header("location:/aroomv2/xuanke.html");
        }
        $xuankemsg = $this->model('Xuankemsg');
        $list = $xuankemsg->readManagerMsg($aid);
		$rule = $xuanke->getRule(array('xkid'=>$aid));
		$this->assign('rule',$rule);
        $this->assign('activity', $activity);
        $this->assign('messages', $list);
        $this->display('aroomv2/manager_msgs');
    }
}