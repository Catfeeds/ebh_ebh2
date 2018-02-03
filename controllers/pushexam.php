<?php
/**
 *处理作业推送请求控制器
 */
class PushexamController extends CControl{
	public function index(){
		$eidstr = $this->input->post('eid');
		if(empty($eidstr)){
			return;
		}
		$user = $this->_getLoginUser();
		if(empty($user) || ($user['groupid'] != 5) ){//只有教师才有权限推送作业
			log_message("非法用户推送作业信息eid:".$eidstr);
			return;
		}
		
		$eidArr = explode(':', $eidstr);
		foreach ($eidArr as  $eid) {
			if(is_numeric($eid) && ($eid > 0) ){
				$res = Ebh::app()->lib('PushUtils')->PushExamToStudent($eid);//向学生推送作业
				Ebh::app()->lib('ThirdPushUtils')->PushExamToStudent($eid);//向学生推送作业
			}
		}
	}

	/**
	*根据key获取当前用户
	*/
	private function _getLoginUser() {
		$auth = $this->input->post('k');
		$usermodel = $this->model('user');
        if (!empty($auth)) {
            @list($password, $uid,$ip,$time) = explode("\t", authcode($auth, 'DECODE'));
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            return $user;
        }
        return FALSE;
	}
}