<?php
/*
用户
*/
class UserController extends AdminControl{

	/*
	判断用户名是否已经存在
	*/
	public function exists(){
		$user = $this->model('user');
		$param['username'] = $this->input->get('username');
		if($user->exists($param['username']))
			echo 1;
		else
			echo 0;
	}
	/**
	 *修改用户密码视图分配
	 *@author zkq
	 *请求地址格式为 /admin/user/changepassword.html?tag=xxx&uid=111&returnurl=x.html 其中tag为模块名称
	 */
	public function changepassword(){
		$uid = intval($this->input->get('uid'));
		$tag = $this->input->get('tag');
		$returnurl = $this->input->get('returnurl');
		$userinfo = $this->model('user')->getuserbyuid($uid);
		$groupinfo = $this->model('groups')->getInfoByGroupid($userinfo['groupid']);
		$formhash = formhash($userinfo['uid']);
		$info = array(
			'tag'=>$tag,
			'token'=>createToken(),
			'returnurl'=>$returnurl,
			'formhash'=>$formhash,
			'userinfo'=>$userinfo,
			'groupinfo'=>$groupinfo,
			);
		$this->assign('info',$info);
		$this->display('admin/changepassword');
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
				if(strlen($password)>12||strlen($forpassword)<6){
					$this->goback('密码长度不对,必须为6-12位');
				}
			}else{
				$this->goback('密码未修改!',$returnurl);
			}
			if(preg_match("/^[012]$/",$rec['status'])==0){
				$this->goback('参数被篡改,编辑失败',$returnurl);
			}
			$param = array(
				'password'=>$password,
				'status'=>intval($rec['status']),
				);
			if($this->model('user')->update($param,intval($uid))===false){
				$this->goback('操作失败!',$returnurl);
			}else{
				$this->goback('操作成功!',$returnurl);
			}
		}else{
			$this->goback('参数被篡改,编辑失败',$returnurl);
		}
	}
	/**
	 *操作成功或者失败时的回调函数
	 *@author zkq
	 *@param String $note
	 *@param String $returnurl
	 *用来跳转到相关页面
	 */
	private function goback($note='操作成功!',$returnurl = '/admin.html'){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
}
?>