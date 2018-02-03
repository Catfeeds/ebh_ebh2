<?php
class InnerchangepwdController extends CControl{
	private $loginuser = null;
	private $groupInfo = null;
	public function index(){
		$this->checkuser();
		$formhash = formhash($this->loginuser['uid']);
		$token = createToken();
		$this->assign('token',$token);
		$this->assign('user',$this->loginuser);
		$this->assign('groupInfo',$this->groupInfo);
		$this->assign('formhash',$formhash);
		$this->display('admin/innerchangepwd');
	}

	/**
	 *后台当前用户修改密码时的权限验证
	 */
	private function checkuser(){
		$this->loginuser = $user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			$this->redirect();
		}
		$this->groupInfo = $groupInfo = $this->model('groups')->getInfoByGroupid($user['groupid']);
		$groupType = $groupInfo['type'];
		if($groupType!='staff'){
			$this->redirect();
		}
	}

	/**
	 *跳转到后台登录页面
	 */
	public function redirect($url = '/admin.html'){
		header('Location:'.$url);
		exit;
	}

	/**
	 *修改用户密码数据处理
	 *@author zkq
	 *POST传值
	 *$this->input->post() 格式: array{'uid'=>11111,'token'=>22222,'formhash'=>33333,'status'=>1,'password'=>3333}
	 *该方法用来处理由changepassword视图页面传过来的参数
	 *@return 跳转到由post中returnurl所指定的地址	
	 *
	 */
	public function _changepassword(){
		$rec = $this->input->post();
		$returnurl = $rec['returnurl'];
		if(checkToken($rec['token'])==false){
			$this->goback('请勿重复提交!',$returnurl);
		}
		$uid = $rec['uid'];
		if($uid==0){
			$this->goback('操作失败!',$returnurl);
		}
		$formhash = $rec['formhash'];
		if(formhash($uid)==$formhash){
			$password = $rec['password'];
			$forpassword = $rec['forpassword'];
			if(!empty($password)){
				if($password!=$forpassword){
					$this->goback('两次密码不一致,编辑失败',$returnurl);
				}
				if(strlen($password)>18||strlen($forpassword)<6){
					$this->goback('密码长度不对,必须为6-18位');
				}
			}else{
				$this->goback('密码未修改!',$returnurl);
			}
			$param = array(
				'password'=>$password,
				// 'status'=>intval($rec['status']),
				'uid'=>intval($rec['uid'])
				);
			if($this->model('staff')->editstaff($param)===false){
				$this->goback('操作失败!',$returnurl);
			}else{
				$this->goback('操作成功!',$returnurl);
			}
		}else{
			$this->goback('参数被篡改,编辑失败',$returnurl);
		}
	}
	/**
	 *操作成功或者失败之后的跳转页面
	 */
	public function goback($note="操作成功,正在努力为您跳转...",$returnurl="/admin/staff.html"){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
}
