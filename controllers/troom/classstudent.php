<?php
/**
 * 班级学生控制器类ClassstudentController
 */
class ClassstudentController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classmodel = $this->model('Classes');
        $classlist = $classmodel->getTeacherClassList($roominfo['crid'],$user['uid']);
        $cid = $this->uri->uri_attr(0);
        $q = $this->input->get('q');
        $queryarr = parsequery();
        if(is_numeric($cid)) {
            $queryarr['classid'] = $cid;
        }
        $classidlist = '';
        $clist = array();   //classid为key和classname为value的数组
        $headclass = array();//headclass为该老师任班主任的班级
        foreach ($classlist as $c) {
            if(empty($classidlist))
                $classidlist = $c['classid'];
            else
                $classidlist .= ','.$c['classid'];
            $clist[$c['classid']] = $c['classname'];

            if($c['headteacherid'] == $user['uid'])
            	$headclass[] = $c['classid'];
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
        $this->assign('classlist', $classlist);
        $this->assign('cid', $cid);
        $this->assign('q', $q);
        $this->assign('students', $students);
        $this->assign('headclass', $headclass);
        $this->assign('pagestr', $pagestr);
        $this->display('troom/classstudent');
    }

	/*
	修改密码
	*/
	public function editpass(){
		$param['uid'] = $this->input->post('uid');
		$param['password'] = $this->input->post('password');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取classid并检查当前老师是不是班主任，是班主任才可以重置密码。
		$myclass = $this->model('classes')->getClassByUid($roominfo['crid'],$param['uid']);
		if (empty($myclass) || $myclass['headteacherid'] != $user['uid']){
			echo '0';
			exit;
		}

		$member = $this->model('member');
		$res = $member->editmember($param);
		echo isset($res);
		/**写日志开始**/
		fastcgi_finish_request();
		$message = json_encode($param);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['uid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'member'
				)
		);
		/**写日志结束**/
	}
}
