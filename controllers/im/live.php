<?php
class LiveController extends CControl{
    public function index(){
        $input = EBH::app()->getInput();
        $key = $input->get('key');

        $key = base64_decode($key);
        @list($password, $uid,$ip,$time,$cwid) = explode("\t",authcode($key, 'DECODE'));

        //if($user['groupid'])

        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
        if($uid<= 0 || $course['uid'] != $uid){
            echo 'auth error';exit;
        }
        $usermodel = $this->model('user');
        $user = $usermodel->getuserbyuid($uid);

        $this->assign('user',$user);
        $notice = $coursemodel->getNotice($cwid);


        $course['notice'] = $notice;
		$this->assign('course',$course);
        $this->assign('key',$key);
        $this->assign('cwid',$cwid);
        $this->display('im/live');
    }


    public function run(){  
        $input = EBH::app()->getInput();
        $key = $input->get('key');
        $this->assign('key',$key);
        $this->display('im/live_run');
    }
}