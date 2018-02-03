<?php
class FeedbackController extends CControl{
	public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
	
	public function courses() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classsubjectmodel = $this->model('Classsubject');
        $page = $this->uri->page;
        $subjectlist = $classsubjectmodel->getsubjectlistbytid($roominfo['crid'],$user['uid']);
        $this->assign('subjectlist', $subjectlist);
       
        $this->display('troomv2/feedback_course');
    }
	
	public function view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		if(in_array($roominfo['crid'],$cridarr['noteacher']))
			$this->assign('needsubfolder',false);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $fbmodel = $this->model('feedback');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		$queryarr['status'] = 1;
        $courses = $fbmodel->getCWList($queryarr);
        $count = $fbmodel->getCWCount($queryarr);
        $pagestr = show_page($count);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
        $this->assign('sectionlist', $sectionlist);
        $this->assign('pagestr', $pagestr);
        $this->assign('folderid',$folderid);
        $this->assign('roominfo',$roominfo);
        
        $this->display('troomv2/feedback_courseware');
	}
	
	public function courses_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo', $roominfo);
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user', $user);
		
		$cwid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$param['cwid'] = $cwid;
		
		//顶部统计
		$topcount = Ebh::app()->lib('Topcount');
		$uidstr = $topcount->getTopcount($cwid,$this);
		//反馈记录
		$fbmodel = $this->model('feedback');
		$param['uids'] = $uidstr;
		$fblist = $fbmodel->getFeedbackList($param);
		//var_dump($fblist);
		//课件信息
		$coursemodel = $this->model('Courseware');
		$course = $coursemodel->getcoursedetail($cwid);
		$redis = Ebh::app()->getCache('cache_redis');
		$viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
		if(!empty($viewnum))
			$course['viewnum'] = $viewnum;
		$this->assign('course',$course);
		
		//如果反馈过,则显示结果,否则显示提交页面
		if(!empty($fblist)){
			$this->assign('fblist',$fblist);
			$feedbacknames = array('听懂','一知半解','听不懂');
			$difficultynames = array('容易','一般','较难');
			$qualitynames = array('很好','不错','一般','声音不佳','图像不佳');
			$levelnames = array('很精彩','还不错','一般般','有气无力');
			foreach($fblist as $fb){
				if(empty($data_feedback[$feedbacknames[$fb['feedback']]]))
					$data_feedback[$feedbacknames[$fb['feedback']]] = 1;
				else
					$data_feedback[$feedbacknames[$fb['feedback']]]++;
				if(empty($data_difficulty[$difficultynames[$fb['difficulty']]]))
					$data_difficulty[$difficultynames[$fb['difficulty']]] = 1;
				else
					$data_difficulty[$difficultynames[$fb['difficulty']]]++;
				if(empty($data_quality[$qualitynames[$fb['quality']]]))
					$data_quality[$qualitynames[$fb['quality']]] = 1;
				else
					$data_quality[$qualitynames[$fb['quality']]]++;
				if(empty($data_level[$levelnames[$fb['level']]]))
					$data_level[$levelnames[$fb['level']]] = 1;
				else
					$data_level[$levelnames[$fb['level']]]++;
			}
			
			
			$datacol_feedback = array(
				'caption' => '',
				'datas' => json_encode($data_feedback)
			);
			$datacol_difficulty = array(
				'caption' => '',
				'datas' => json_encode($data_difficulty)
			);
			$datacol_quality = array(
				'caption' => '',
				'datas' => json_encode($data_quality)
			);
			$datacol_level = array(
				'caption' => '',
				'datas' => json_encode($data_level)
			);
			$this->assign('feedback',$datacol_feedback);
			$this->assign('difficulty',$datacol_difficulty);
			$this->assign('quality',$datacol_quality);
			$this->assign('level',$datacol_level);
			
			$chart = Ebh::app()->lib('ChartLib');
			$this->assign('chart',$chart);
			$this->display('troomv2/feedback_view');
		}else{
			$this->assign("nodata", 1);
			$this->display('troomv2/feedback_view');
		}
	}

	/*
	*所有课程的听课反馈列表
	*/
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();

        $folder = $this->model('folder');
        $courses = $folder->getSubFolders($roominfo['crid']);
		$arr = array();
		foreach($courses as $cour){
			$arr[] = intval($cour['folderid']);
		}

		$this->assign("folders",$arr);
		$this->assign('courses',$courses);
        $this->assign('roominfo',$roominfo);
        
        $this->display('troomv2/feedback');
	}

}

?>