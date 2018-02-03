<?php
/*
修改密码
*/
class EditpassController extends CControl{
	public function index(){
		
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$spclassroom = array(10420);//首次登录需要改密码的学校
		$sppassword = array(md5('123456'),md5('hzsz11'));//需要修改的密码
		if(!empty($user) && in_array($roominfo['crid'],$spclassroom)){
			$toosimple = in_array($user['password'],$sppassword);
				if(!$toosimple)
			$res = $this->model('classroom')->checkforfirstlogin($user,$roominfo['crid']);
			if($toosimple || !empty($res)){
				if($this->input->post()!=null){
					$usermodel = $this->model('user');
					$param['password'] = $this->input->post('password');
					$param['lastlogintime'] = SYSTIME;
					$param['logincount'] = 1;
					$param['lastloginip'] = getip();
					$usermodel->update($param,$user['uid']);
				}else{
					$this->assign('room',$roominfo);
					$this->assign('user',$user);
					$this->display('common/editpass');
				}
			}else{
				header('location:/');
			}
		}else{
			header('location:/');
		}
		
	}
	
}
?>