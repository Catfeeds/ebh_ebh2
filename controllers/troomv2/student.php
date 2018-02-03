<?php

/**
 * 网校教师后台学生管理控制器类StudentController
 */
class StudentController extends CControl {

    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }

    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $rumodel = $this->model('Roomuser');
        $queryarr = parsequery();
        $q = $this->input->get('q');
        $queryarr['crid'] = $roominfo['crid'];
        $students = $rumodel->getroomuserlist($queryarr);
        $count = $rumodel->getroomusercount($queryarr);
        $pagestr = show_page($count);
        $this->assign('students', $students);
        $this->assign('pagestr', $pagestr);
        $this->assign('q', $q);
        $this->display('troomv2/student');
    }

    /**
     * 更新学员资料
     */
    public function upinfo() {
        $memid = $this->input->post('memid');
        $result = array('status' => 0);
        if ($memid !== NULL && is_numeric($memid)) {
            $roominfo = Ebh::app()->room->getcurroom();
            //判断权限
            if ($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7)    //学校教师后台不具备直接修改学生密码功能
                return FALSE;
            $roommodel = $this->model('Classroom');
            $checkstu = $roommodel->checkstudent($memid, $roominfo['crid']);
            if ($checkstu == -1) {   //不在此平台无权限
                return FALSE;
            }
            $newpwd = $this->input->post('newpwd');
            if ($newpwd !== NULL) {  //修改密码
                $confirmpwd = $this->input->post('confirmnewpwd');
                if ($newpwd != $confirmpwd || empty($newpwd) || strlen($newpwd) < 6) {
                    $result['msg'] = '参数不正确';
                    echo json_encode($result);
                    exit();
                }
                $usermodel = $this->model('User');
                $uparam = array('password' => $newpwd);
                $afrows = $usermodel->update($uparam, $memid);
                if ($afrows !== FALSE) {
                    $result['status'] = 1;
                    $result['msg'] = '修改成功';
                    echo json_encode($result);
                    exit();
                }
            }
            $rcmodel = $this->model('Roomuser');
            $status = $this->input->post('status');
            if ($status !== NULL && is_numeric($status)) {  //修改状态
                $rcparam = array('crid' => $roominfo['crid'], 'uid' => $memid, 'cstatus' => $status);
                $afrows = $rcmodel->update($rcparam);
                if ($afrows !== FALSE) {
                    $result['status'] = 1;
                    $result['msg'] = '修改成功';
                    echo json_encode($result);
                    exit();
                }
            }
            $type = $this->input->post('type');
            if ($type == 'del') {    //删除学员
                $rcparam = array('crid' => $roominfo['crid'], 'uid' => $memid);
                $afrows = $rcmodel->del($rcparam);
                if ($afrows !== FALSE) {
                    $result['status'] = 1;
                    $result['msg'] = '删除成功';
                    echo json_encode($result);
                    exit();
                }
            } else if ($type == 'addtime') { //添加学习时间(1年)
                $rcparam = array('crid' => $roominfo['crid'], 'uid' => $memid);
                $ruser = $rcmodel->getroomuserdetail($roominfo['crid'], $memid);
                $enddate = $ruser['enddate'];
                if (!empty($enddate)) {
                    $rcparam['enddate'] = strtotime("next year", $enddate);
                } else {
                    $rcparam['begindate'] = SYSTIME;
                    $rcparam['enddate'] = strtotime("next year");
                }
                $afrows = $rcmodel->update($rcparam);
                if ($afrows > 0) {   //处理bill订单数据
                }
                if ($afrows !== FALSE) {
                    $result['status'] = 1;
                    $result['msg'] = '修改成功';
                    echo json_encode($result);
                    exit();
                }
            }
        }
    }

    /**
     * 学员审核
     */
    public function check() {
        $roominfo = Ebh::app()->room->getcurroom();
        $applys = $this->input->post('apply');
        $agree = $this->input->post('agree');
        if($applys === NULL) { //显示
            $q = $this->input->get('q');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['status'] = 0;
            $applymodel = $this->model('Apply');
            $applys = $applymodel->getapplylist($queryarr);
            $count = $applymodel->getapplycount($queryarr);
            $pagestr = show_page($count);
            $this->assign('applys', $applys);
            $this->assign('pagestr', $pagestr);
            $this->assign('q', $q);
            $this->display('troomv2/student_check');
        } else {    //提交表单处理
            if(!empty($applys) && is_array($applys) && ($agree == -1 || $agree == 1)) {
                foreach($applys as $applyid) {  //验证提交的id是否合法
                    if(!is_numeric($applyid)) {
                        return FALSE;
                    }
                }
                $applyids = implode(',', $applys);
                $applymodel = $this->model('Apply');
                if($agree == 1) {   //同意
                    $aparam = array('crid'=>$roominfo['crid'],'applyids'=>$applyids,'status'=>0);
                    $applylist = $applymodel->getapplysbyids($aparam);
                    $rumodel = $this->model('Roomuser');
                    $roommodel = $this->model('Classroom');
                    $result = TRUE;
                    foreach($applylist as $apply) {
                        if(empty($apply['memberid']))
                            continue;
                        $ruparam = array('crid'=>$roominfo['crid'],'uid'=>$apply['memberid'],'cnname'=>$apply['realname'],'mobile'=>$apply['phone'],'email'=>$apply['email']);
                        $rresult = $rumodel->insert($ruparam);
                        if($rresult !== FALSE)
                            $roommodel->addstunum($roominfo['crid']);
                        else {
                            $result = FALSE;
                            break;
                        }
                    }
                }
                if($agree == 1 && !$result) {
                    echo 'fail';
                    exit;
                }
                $param = array('crid'=>$roominfo['crid'],'applyids'=>$applyids,'status'=>$agree,'verifydateline'=>SYSTIME);
                $result = $applymodel->update($param);
                if($result) {
                    echo 'success';
                } else
                    echo 'fail';
            }
        }
    }

    /**
     * 开通统计
     */
    public function opencount() {
        $roominfo = Ebh::app()->room->getcurroom();
        $q = $this->input->get('q');
        $payfrom = $this->input->get('payfrom');
        if(!empty($payfrom) && !is_numeric($payfrom))
            $payfrom = '';
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
        $paymodel = $this->model('Payment');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['stardateline'] = $stardateline;
        $queryarr['enddateline'] = $enddateline;
        $queryarr['payfrom'] = $payfrom;
        $myopenlist = $paymodel->getopenlistbycrid($queryarr);
        $count = $paymodel->getopenlistcountbycrid($queryarr);
        $pagestr = show_page($count);
        $this->assign('q', $q);
        $this->assign('payfrom', $payfrom);
        $this->assign('begintime', $begintime);
        $this->assign('endtime', $endtime);
        $this->assign('myopenlist', $myopenlist);
        $this->assign('pagestr', $pagestr);
        $this->display('troomv2/student_opencount');
    }

    /**
     * 添加学员 
     */
    public function add() {
        $username = $this->input->post('sname');
        if ($username === NULL) {
            $this->display('troomv2/student_add');
        } else {  //提交表单
            $result = FALSE;
            $usermodel = $this->model('User');
            $suser = $usermodel->getuserbyusername($username);
            $roominfo = Ebh::app()->room->getcurroom();
            $pwd = $this->input->post('pwd');
            $realname = $this->input->post('cnname');
            $sex = $this->input->post('sex');
            $birthday = $this->input->post('birthday');
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            if (!empty($birthday))
                $birthday = strtotime($birthday);
            $memparam = array('username' => $username, 'password' => $pwd, 'realname' => $realname, 'birthdate' => $birthday, 'sex' => $sex, 'mobile' => $mobile, 'email' => $email);
            if (empty($suser)) {
                $memmodel = $this->model('Member');
                $uid = $memmodel->addmember($memparam);
                if ($uid !== FALSE) {
                    $rumodel = $this->model('Roomuser');
                    $memparam['crid'] = $roominfo['crid'];
                    $memparam['uid'] = $uid;
                    $memparam['begindate'] = SYSTIME;
                    $memparam['enddate'] = strtotime('+1 year', SYSTIME);
                    $memparam['birthday'] = $birthday;
                    $afrows = $rumodel->insert($memparam);
                    if ($afrows !== FALSE) {
                        $result = TRUE;
                    }
                }
            } else {
                $roommodel = $this->model('Classroom');
                $checkresult = $roommodel->checkstudent($suser['uid'], $roominfo['crid']);
                if ($checkresult == -1) {    //该学员不存在教室中
                    $rumodel = $this->model('Roomuser');
                    $memparam['crid'] = $roominfo['crid'];
                    $memparam['uid'] = $suser['uid'];
                    $memparam['begindate'] = SYSTIME;
                    $memparam['enddate'] = strtotime('+1 year', SYSTIME);
                    $memparam['birthday'] = $birthday;
                    $afrows = $rumodel->insert($memparam);
                    if ($afrows !== FALSE) {
                        $result = TRUE;
                    }
                }
            }
            if ($result) {
                //添加教室的学生数
                $roommodel = $this->model('Classroom');
                $roommodel->addstunum($roominfo['crid']);
                //添加成功后需要处理ebh_biils订单表/暂留
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0));
            }
        }
    }

    /**
     * 检测学员username是否存在
     */
    public function checkname() {
        $username = $this->input->post('sname');
        if ($username !== NULL) {
            $code = 0;
            $message = '';
            $roominfo = Ebh::app()->room->getcurroom();
            $usermodel = $this->model('User');
            $suser = $usermodel->getuserbyusername($username);
            if (empty($suser)) { //用户名还不存在
                $code = 2;
                $message = '请为新用户设置密码';
            } else if ($suser['groupid'] != 6) { //学生以外账号不允许添加
                $code = 0;
                $message = '不允许添加教师账号';
            } else {
                $roommodel = $this->model('Classroom');
                $checkresult = $roommodel->checkstudent($suser['uid'], $roominfo['crid']);
                if ($checkresult != -1) {    //该学员已存在教室中
                    $code = 0;
                    $message = '该用户已经在该教室内';
                } else {
                    $code = 1;
                    $message = '';
                }
            }
            echo json_encode(array('code' => $code, 'message' => $message));
        }
    }
    /**
     * 查看学生详情
     */
    public function view() {
        $memberid = $this->uri->itemid;
        if(empty($memberid) || !is_numeric($memberid))
            return FALSE;
        $membermodel = $this->model('Member');
        $member = $membermodel->getmemberdetail($memberid);
        $this->assign('member', $member);
        $this->display('troomv2/student_view');
    }
	
	//学生列表
	public function list_view(){
		$roomuser = $this->model('roomuser');
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->itemid;
		
		if(is_numeric($classid))
			$param['classid'] = $classid;
		
		$roomuserlist = $roomuser->getaroomstudentlist($param);
		$roomusercount = $roomuser->getaroomstudentcount($param);
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);
		// var_dump($param);
		$pagestr = show_page($roomusercount);
		$this->assign('classid',$classid);
		$this->assign('pagestr',$pagestr);
		$this->assign('search',$param['q']);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->assign('roomuserlist',$roomuserlist);
		$this->display('troomv2/student_list');
	}

	/*
	修改密码
	*/
	public function editpass(){
		$param['uid'] = $this->input->post('uid');
		$param['password'] = $this->input->post('password');
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
