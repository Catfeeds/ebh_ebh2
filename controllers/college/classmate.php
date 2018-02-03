<?php

/**
 * 学生我的同学控制器类 ClassmateController
 */
class ClassmateController extends CControl {

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
        $roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo',$roominfo);
        $user = Ebh::app()->user->getloginuser();
        
        $classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$this->assign('myclass',$myclass);
		$students = array();
		if(!empty($myclass)) {
			$queryarr = parsequery();
			$queryarr['classid'] = $myclass['classid'];
			$queryarr['pagesize'] = 100;
			$students = $classmodel->getClassStudentList($queryarr);
			$count = $classmodel->getClassStudentCount($queryarr);
		}else{
			$count = 0;
			$queryarr['pagesize'] = 10;
		}

		$pagestr = show_page($count,$queryarr['pagesize']);
		$this->assign('pagestr',$pagestr);
		$this->assign('students',$students);
        $this->display('college/classmate');
    }

	// 在线状态的同学
	public function online() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$name = $this->input->get('name');
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$this->assign('myclass',$myclass);
		$students = array();
		if(!empty($myclass)) {
			$queryarr = parsequery();
			$queryarr['classid'] = $myclass['classid'];
			$queryarr['pagesize'] = 30;
			if ($name && $name != '请输入关键字') $queryarr['q'] = $name;
			$domain = !empty($roominfo['domain']) ? $roominfo['domain'] : '';
        $conf = Ebh::app()->getConfig()->load('othersetting');
        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
			if ($is_zjdlr) {// 国土资源厅
				$onLimeTime = time();
				$redis = Ebh::app()->getCache('cache_redis');
				$classStudentsInfo = $redis->hget($domain);
				arsort($classStudentsInfo);// 按登录先后排序
				$uidArr = array(-1);
				if (!empty($classStudentsInfo) && is_array($classStudentsInfo)) {
					foreach ($classStudentsInfo as $k => $v) {
						if (!empty($k) && !empty($v) && $v >= $onLimeTime) {
							$uidArr[] = $k;
						}
					}
				}

				// 在线的同学不包括自己
				$key = array_search($user['uid'], $uidArr);
				if (!empty($key)) {
					unset($uidArr[$key]);
				}
				$queryarr['uids'] = $uidArr;
			}

			$students = $classmodel->getClassStudentList($queryarr);

			// 我的同学 按登录先后排序
			$studentsArr = array();
			if ($is_zjdlr && !empty($uidArr) && !empty($students)) {
				foreach($uidArr as $val) {
					foreach($students as $v) {
						if ($val == $v['uid']) {
							$studentsArr[] = $v;
							break;
						}
					}
				}
				$students = $studentsArr;
			}

			$count = $classmodel->getClassStudentCount($queryarr);
		}else{
			$count = 0;
			$queryarr['pagesize'] = 30;
		}

		$pagestr = show_page($count, $queryarr['pagesize']);
		$this->assign('pagestr',$pagestr);
		$this->assign('students',$students);
		$this->display('college/onclassmate');
	}
}
