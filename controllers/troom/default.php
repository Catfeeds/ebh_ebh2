<?php

/**
 * 教师后台首页入口控制器
 */
class DefaultController extends CControl {

    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }

    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('room', $roominfo);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
        $roommodel = $this->model('Classroom');
        $roomlist = $roommodel->getroomlistbytid($user['uid']);
        $this->assign('roomlist', $roomlist);
        //加载菜单模块信息
        $code = 'troom';
        $catmodel = $this->model('Category');
        $curcat = $catmodel->getCatByCode($code);
        $upid = $curcat['catid'];
        $subcat = $catmodel->getCatlistByUpid($upid, NULL, NULL, 1);
        $modulelist = array();
        $modulepower = $roominfo['modulepower'];
        $modulepowerarr = explode(',', $modulepower);
        //需要在学校平台显示的模块
        $schoolcatarr = array('classsubject', 'classexam', 'classstudent', 'teaexam', 'review', 'myask', 'stuexam', 'online','myonline', 'mysetting', 'exampaper', 'tastulog', 'statisticanalysis', 'teachingplan', 'reslibs','weixin','iaclassroom','tools','notify','classpaper','survey');
        //不需要在网校平台显示的模块
        $noinroomcatarr = array('classsubject', 'classexam', 'classstudent', 'teaexam', 'stuexam', 'exampaper', 'tastulog', 'statisticanalysis', 'reslib','weixin');
        if ($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {  //学校模块
            foreach ($subcat as $catitem) {
				if($roominfo['crid'] == 10420 && $catitem['code'] == 'review') {
					continue;
				}
                if ($catitem['system'] == 1 && in_array($catitem['code'], $schoolcatarr)) {
                    $modulelist[] = $catitem;
                    continue;
                }
                if ($catitem['system'] == 0 && in_array($catitem['catid'], $modulepowerarr) && in_array($catitem['code'], $schoolcatarr)) {
                    $modulelist[] = $catitem;
                    continue;
                }
				
            }
        } else {    //网校模块
            foreach ($subcat as $catitem) {
                if ($catitem['system'] == 1 && !in_array($catitem['code'], $noinroomcatarr)) {
                    $modulelist[] = $catitem;
                    continue;
                }
                if ($catitem['system'] == 0 && in_array($catitem['catid'], $modulepowerarr) && !in_array($catitem['code'], $noinroomcatarr)) {
                    $modulelist[] = $catitem;
                    continue;
                }
            }
        }
        $this->assign('modulelist', $modulelist);

        //学生云盘是否开启
        $moduleyunpan = array();
        $studentmodulelist = $this->model('appmodule')->getstudentmodule(array('crid'=>$roominfo['crid'],'available'=>1,'modulecode'=>'yunpan','order'=>'displayorder','limit'=>1));
        if (!empty($studentmodulelist)){
        	$moduleyunpan = $studentmodulelist[0];
			$moduleyunpan['url'] = str_replace(array('[crid]','[domain]','[uid]'), array($roominfo['crid'],$roominfo['domain'],$user['uid']), $moduleyunpan['url']);
        }
		$this->assign('moduleyunpan', $moduleyunpan);

        //加载全科模块信息
        $rpmodel = $this->model('Roompermission');
        $roompers = $rpmodel->getModulesByCrid($roominfo['crid']);
        $this->assign('roompers', $roompers);
        $helpcrid = 10372;  //帮助网校的crid
        $helpcid = 1561;    //帮助网校的课程编号，教师和学生不同
		 //资料完成百分比
        $percent = $this->getpercent($user);
        $this->assign('percent',$percent);

        $this->assign('helpcrid', $helpcrid);
        $this->assign('helpcid', $helpcid);

        $this->display('troom/index');
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
