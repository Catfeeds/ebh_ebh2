<?php
/**
 * 班级（单位）学分
 */
class CreditController extends CControl {
	public function __construct() {
		parent::__construct();
		Ebh::app()->room->checkteacher();
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$orderType = intval($this->input->get('order'));
		$classid = intval($this->input->get('classid'));
		$param = parsequery();
        $api = Ebh::app()->getApiServer('ebh');
        $classes = $api->reSetting()
            ->setService('Organization.ClassTeacher.getClassesForTeacher')
            ->addParams('uid', $user['uid'])
            ->addParams('crid', $roominfo['crid'])
            ->request();
        if (empty($classes)) {
            $classid = 0;
        } else {
            if (!isset($classes[$classid])) {
                $firstClass = reset($classes);
                $classid = $firstClass['classid'];
            }
        }
        $count = 0;
        if ($classid > 0) {
            $params = array(
                'classid' => $classid,
                'orderType' => $orderType,
                'page' => $param['page'],
                'pagesize' => $param['pagesize']
            );
            $ret = $api->reSetting()
                ->setService('Member.Score.rank')
                ->addParams($params)
                ->request();
            $this->assign('students', $ret['students']);
            $count = $ret['count'];
        }
        $pagestr = show_page($count, $param['pagesize']);
        $this->assign('pagestr', $pagestr);
        $this->assign('cid', $classid);
        $this->assign('orderType', $orderType);
        $this->assign('classes', $classes);
		$this->display('troomv2/credit');
	}

}