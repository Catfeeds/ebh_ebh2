<?php
class OnlineController extends CControl{
	/**
	 *我的直播
	 */
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
	public function index(){
		//基本信息获取
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();

        //获取用户所在的班级的信息
        $classesModel = $this->model('classes');
        $classInfo = $classesModel->getClassByUid($roominfo['crid'],$user['uid']);
        $classid = $classInfo['classid'];
        $grade = $classInfo['grade'];
        if(empty($grade)){
            $grade = 0;
        }
        $district = $classInfo['district'];
        if(empty($district)){
            $district = 0;
        }
        $param = parsequery();
        $param = array_merge(array(
        	'classid'=>$classid,
        	'grade'=>$grade,
        	'district'=>$district,
        	'crid'=>$roominfo['crid']
        ),$param);

        $onlinecourseModel = $this->model('onlinecourse');
        $courseList = $onlinecourseModel->getStuOnline($param);
        $courseListCount = $onlinecourseModel->getStuOnlineCount($param);
        $this->assign('courseList',$courseList);
        //获取用户有权限的直播
		$this->assign('roominfo',$roominfo);
        $this->assign('user',$user);
        $this->assign('q',$param['q']);
		$pagestr = show_page($courseListCount,$param['pagesize']);
   		$this->assign('pagestr',$pagestr);
   		$key = $this->_getOnlineKey();
		//$key = urlencode($key);
		$this->assign('key',$key);
		$this->display('myroom/myonline_my');
	}

	/**
	*生成直播课对应的key，主要用于直播课权限验证
	*/
	private function _getOnlineKey() {
		$clientip = $this->input->getip();
        $ktime = SYSTIME;
        $auth = $this->input->cookie('auth');
        $sauth = authcode($auth, 'DECODE');
        @list($password, $uid) = explode("\t", $sauth);
        $skey = "$password\t$uid\t$clientip\t$ktime";
        $key = authcode($skey, 'ENCODE');
		return $key;
	}
}