<?php
/*
学校后台
*/
class DefaultController extends CControl{
	public $user = null;
	//是否有控制权限，1为管理权限，2为父级权限只能查看
	private $haspower = NULL;
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
		$this->assign('haspower',$this->haspower);
		$this->user = Ebh::app()->user->getAdminLoginUser();
		$this->assign('user',$this->user);
		
	}
	public function index(){
		$user = Ebh::app()->user->getAdminLoginUser();
		$roominfo = Ebh::app()->room->getcurroom();
        $this->assign('room', $roominfo);
		$roommodel = $this->model('classroom');
		$roomlist = $roommodel->getroomlistbytid($this->user['uid']);
		$this->assign('roomlist', $roomlist);

		if($this->haspower == 2) {
			$catlist = array(array('code'=>'tlist','codepath'=>'aroom/tlist','name'=>'教师列表','visible'=>1),array('code'=>'clist','codepath'=>'aroom/clist','name'=>'课程列表','visible'=>1),array('code'=>'cllist','codepath'=>'aroom/cllist','name'=>'班级列表','visible'=>1),array('code'=>'slist','codepath'=>'aroom/slist','name'=>'学生列表','visible'=>1));
		} else {
			$code = 'aroom';
			$catmodel = $this->model('category');
			$curcat = $catmodel->getCatByCode($code);
			$upid = $curcat['catid'];
			$catlist = $catmodel->getCatlistByUpid($upid,NULL,NULL,1);
		}
		//资料完成百分比
		$editor = Ebh::app()->lib('UMEditor');
        $this->assign('editor', $editor);
        $percent = $this->getpercent($user);
        $this->assign('percent',$percent);
		$this->assign('teachermenu',$catlist);
		$this->display('aroomv2/index');
	}
	 public function getpercent($user){
    	$pc = 50;
    	if($user['face'])
    		$pc+=10;
    	$mmodel = $this->model('Member');
    	$info = $mmodel->getfullinfoT($user['uid']);
    	unset($info['uid'],$info['realname'],$info['face']);
    	foreach($info as $value){
    		if(!empty($value))
    			$pc+=2;
    	}
    	if($pc>100){$pc=100;}
    	return $pc;
    }
}
?>