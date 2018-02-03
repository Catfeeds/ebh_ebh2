<?php
/*
后台权限
*/
class AdminControl extends CControl{
    public  $user; 
    protected $apiServer;
    protected $roominfo;
	public function __construct(){
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		parent::__construct();
		$user = Ebh::app()->user->getloginuser();

		if(empty($user)){
			$this->widget('note_widget',array('note'=>'权限不足','returnurl'=>'javascript:void()'));
			exit;
		}else{
		    $this->user = $user;
		}
		
		$cparr = explode('/',$this->uri->codepath);
		//管理平台adminv2
// 		if(!empty($cparr[0])){
// 		    $this->checkadminv2($this->user);
// 		    return ;
// 		}
		
		$permission = $this->model('permission');
		$param['groupid'] = $user['groupid'];
		$param['controller'] = $cparr[1];
		$res = $permission->haspermission($param);
		if(!$res){
			$this->widget('note_widget',array('note'=>'权限不足','returnurl'=>'javascript:void(0);'));
			exit;
		}
		
		$this->roominfo = Ebh::app()->room->getcurroom();
		$this->apiServer = Ebh::app()->getApiServer('ebh');
	}
	
	/**
	 * 验证权限
	 */
	private function checkadminv2($user){
	    $user  = $this->user;
	    //仅仅验证公司用户+系统系统管理员
	    if(in_array($user['groupid'], array(1,7))===FALSE){
	        $this->widget('note_widget',array('note'=>'权限不足','returnurl'=>'javascript:void(0);'));
	        exit;
	    }
	    return  TRUE;
	}
}
?>