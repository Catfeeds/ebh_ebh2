<?php
/**
 * 班级课程控制类
 */
class ClasssubjectController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        
    }
	public function index(){
		$this->display('troom/classsubject_nav');
	}
    /**
     * 班级课程
     */
    public function courses() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classsubjectmodel = $this->model('Classsubject');
        $page = $this->uri->page;
        $subjectlist = $classsubjectmodel->getsubjectlistbytid($roominfo['crid'],$user['uid']);
        $this->assign('subjectlist', $subjectlist);
		$folderids = '';
		$subjectlistByFolderid = array();
		foreach($subjectlist as $subject){
			$subject['pname'] = '其他课程';
			$subjectlistByFolderid[$subject['folderid']] = $subject;
			$folderids.= $subject['folderid'].',';
		}
		$folderids = rtrim($folderids,',');
		$folderByPid = array();
		if(!empty($folderids)){
			$packagemodel = $this->model('Paypackage');
			$packages = $packagemodel->getPackByFolderid(array('folderids'=>$folderids,'crid'=>$roominfo['crid']));
			// var_dump($packages);
			foreach($packages as $package){
				if(empty($folderByPid[$package['pid']]))
					$folderByPid[$package['pid']] = array($package);
				else
					$folderByPid[$package['pid']][] = $package;
				unset($subjectlistByFolderid[$package['folderid']]);
			}
			sort($subjectlistByFolderid);
			$folderByPid[0] = $subjectlistByFolderid;
		}
		// var_dump($folderByPid);
		$this->assign('roominfo',$roominfo);
		$this->assign('folderbypid',$folderByPid);
        $this->display('troom/classsubject');
    }
	/**
	*班级课程详情页（课件列表）
	*/
    public function view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		if(!in_array($folder['power'],array(0,1))){
			show_404();
			exit;
		}
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		if(in_array($roominfo['crid'],$cridarr['noteacher']))
			$this->assign('needsubfolder',false);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		if(empty($roominfo['checktype'])){
			$queryarr['status'] = '1';
		}else{
			$queryarr['status'] = '0,1,-2';
		}
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count);
        $sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			$viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
			if(!empty($viewnum))
				$course['viewnum'] = $viewnum;
            $sectionlist[$course['sid']][] = $course;
        }
		foreach($sectionlist as $k=>$section){
			$queryarr['sid'] = $k;
			$sectioncount = $coursemodel->getfolderseccoursecount($queryarr);
			$sectionlist[$k][0]['sectioncount'] = $sectioncount;
		}
        $this->assign('sectionlist', $sectionlist);
        $this->assign('page', $pagestr);
        //分配folderid
        $this->assign('folderid',$folderid);
        //分配教室信息
        $this->assign('roominfo',$roominfo);
        //分配作业信息
        
        //检测是否有发布直播权限
		$ammodel = $this->model('appmodule');
		$live = $ammodel->getstudentmodule(array('crid'=>$roominfo['crid'],'modulecode'=>'live','limit'=>1,'tors'=>'1','showmode'=>1));
        $live[0] = !empty($live[0]) ? $live[0] : array();
		$this->assign('live',$live[0]);
        $this->assign('haslive',!empty($live[0]));
        
       //var_dump($sectionlist);
        $this->display('troom/classsubject_view_new');
    }

	
	/*
	某一天的课件
	*/
	public function daycourse(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$coursemodel = $this->model('Courseware');
		
		$cwdate = $this->input->get('d');
        $queryarr = parsequery();
		if(!empty($cwdate)) {	
			$cwtime = strtotime($cwdate);
			if($cwtime !== FALSE) {
				$queryarr['startDate'] = $cwtime;
				$queryarr['endDate'] = $cwtime + 86400;
			} else {
				$cwdate = '';
			}
		}
        $queryarr['uid'] = $user['uid'];
		$queryarr['limit'] = 1000;
		$queryarr['status'] = '0,1,-2';
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['power'] = '0,1';
        $courses = $coursemodel->getfolderseccourselist($queryarr);
		// $this->assign('');
		// var_dump($queryarr);
		$sectionlist = array();
		foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		$this->assign('roominfo',$roominfo);
        $this->assign('sectionlist', $sectionlist);
		$this->display('troom/daycourse');
	}
	
	/*
	设置定时发布
	*/
	public function setcwtiming(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cwmodel = $this->model('courseware');
		$submitat = $this->input->post('submitat');
		$endat = $this->input->post('endat');
		$cwid = $this->input->post('cwid');
		$param['submitat'] = strtotime($submitat);
		if($param['submitat'] == 0 ){
			$simplecw = $cwmodel->getSimplecourseByCwid($cwid);
			$param['truedateline'] = $simplecw['dateline'];
		}else{
			$param['truedateline'] = $param['submitat'];
		}
		$param['endat'] = strtotime($endat);
		$where['cwid'] = $cwid;
		
		$where['crid'] = $roominfo['crid'];
		
		echo $cwmodel->update($param,$where);
	}
	
	public function moveup(){
		$cwid = $this->input->post('cwid');
		$cwmodel = $this->model('courseware');
		$res = $cwmodel->moveit(array('cwid'=>$cwid,'compare'=>'<','order'=>'cdisplayorder desc'));
		if($res)
			echo 1;
		else
			echo 0;
	}
	public function movedown(){
		$cwid = $this->input->post('cwid');
		$cwmodel = $this->model('courseware');
		$res = $cwmodel->moveit(array('cwid'=>$cwid,'compare'=>'>','order'=>'cdisplayorder asc'));
		if($res)
			echo 1;
		else
			echo 0;
	}

	/**
	 * 获取审核详情
	 */
	public function getcheckdetail() {
		$param['toid'] = $this->input->post('toid');
		$param['type'] = 1;//课件
		$checkdetail = $this->model('billchecks')->getCheckDetail($param);
		if ($checkdetail)
		{
			$result['code'] = 1;
			if ($checkdetail['teach_status'] == 1)
				$result['teach_status'] = '已通过';
			elseif ($checkdetail['teach_status'] == 2)
				$result['teach_status'] = '未通过';
			$result['teach_remark'] = $checkdetail['teach_remark'];
			$result['teach_dateline'] = date("Y-m-d H:i:s", $checkdetail['teach_dateline']);
			echo json_encode($result);
		}
		else
		{
			echo json_encode(array('code' => 0));
		}
	}
}
