<?php
/**
 *介绍页面控制器
 */
class IntroController extends CControl{
	var $title;
	public function __construct() {
        parent::__construct();
        $this->title = $this->get_title();	//默认介绍页面的title都从config.php文件中读取
		$this->assign('title', $this->title);
    }
	//云教学平台介绍界面
	public function cloudplatform(){
		$this->display('common/cloudplatform');
	}  
	//APP应用介绍页面
	public function app(){
		$room = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
        $this->assign('room', $room);
		$this->assign('user', $user);
		$this->display('common/app');
	}	
	//APP应用介绍页面
	public function examsystem(){
		$this->display('common/examsystem');
	}
 	
 	//e板会网校能做什么？
	public function schoolfunction(){
		$this->assign('title','e板会网校能做什么？');
		$this->display('common/schoolfunction');
	}
	//创建网校，开启云教学时代！
	public function schoolcreate(){
		$this->assign('title','创建网校，开启云教学时代！');
		$this->display('common/schoolcreate');
	}
	//什么是e板会网校？
	public function schooliswhat(){
		$serverutil = Ebh::app()->lib('ServerUtil');
		$m3u8source = $serverutil->getM3u8CourseSource();
		$key = '33sdfasfasd';
		$cwid = 31103;	//写死课件ID
		$m3u8url = "$m3u8source?k=$key&id=$cwid&.m3u8";
		$this->assign('m3u8url',$m3u8url);
		$this->assign('title','什么是e板会网校？');
		$this->display('common/schooliswhat');
	}
	//开通网校协议
	public function schagreement(){
		$this->assign('title','创建网校协议');
		$this->display('common/schagreement');
	}
	//传统培训机构
	public function tradition(){
		$this->display('common/ad_tradition');
	}
	//企业政府培训
	public function enterprise(){
		$this->display('common/ad_enterprise');
	}
	//学校培训
	public function schooltrain(){
		$this->display('common/ad_schooltrain');
	}
	//招商
	public function business(){
		$this->display('common/ad_business');
	}
	//屏幕直播介绍页面
	public function livesystem(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/livesystem');
	}
	//互动课堂介绍
	public function interaction(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/interaction');
	}
	//作业系统介绍
	public function homework(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/homework');
	}
	//微校通讯介绍
	public function connection(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/connection');
	}
	//网校云盘介绍
	public function cloud(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/cloud');
	}
	//互动答疑介绍
	public function interactquer(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/interactquer');
	}
	//社区圈子介绍
	public function community(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/community');
	}
	//网校商城介绍
	public function schoolshop(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/schoolshop');
	}
	//ebh网校关闭或过期提示页
	public function restricted(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('common/restricted');
	}
}