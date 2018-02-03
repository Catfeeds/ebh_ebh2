<?php
/*
后台登录控制器
*/
class LoginController extends CControl{
	public function index(){
		$username = $this->input->post('admin_username');
			$password = $this->input->post('admin_password');
			$status = array('code'=>0,'message'=>'','returnurl'=>'');
			$usermodel = $this->model('user');
			$user = $usermodel->login($username,$password);
			$returnurl = trim($this->input->post('returnurl'));
			
			if(false==Ebh::app()->lib('Verify')->check($this->input->post('seccode'))){
				$status['code'] = 0;
				$status['message'] = '验证码错误';
				$status['returnurl'] = geturl('admin');
				echo json_encode($status);
				exit; 
			}
			if(!empty($user)){
				
				$uid = $user['uid'];
				$pwd = $user['password'];
				$auth = authcode("$pwd\t$uid",'ENCODE');
				$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
                
				if($user['groupid']>1 && $user['groupid']<7)
				{
					$status['code'] = 0;
					$status['message'] = '您所在的用户组不允许进行后台管理操作';
					$status['returnurl'] = geturl('admin');
					echo json_encode($status);
				}
				else
				{
					$status['code'] = 1;
					$status['message'] = '登录成功';
					$status['returnurl'] = $returnurl == '' ? geturl('admin') : $returnurl;
					$this->input->setcookie('auth',$auth,$cookietime);
					$this->input->setcookie('lasttime',$user['lastlogintime']);
					$this->input->setcookie('lastip',$user['lastloginip']);
					
					echo json_encode($status);
				}
			}
			else{
				$status['message'] = '账号或密码输入不正确。';
                echo json_encode($status);
				return;
			}
	}


}