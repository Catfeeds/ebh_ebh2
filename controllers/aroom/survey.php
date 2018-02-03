<?php
class SurveyController extends CControl{
	public function __construct(){
		parent::__construct();
        $this->haspower = Ebh::app()->room->checkRoomControl();
		//Ebh::app()->room->checkteacher();
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$smodel = $this->model('survey');
		$surveylist = $smodel->getSurveyList(array('crid'=>$roominfo['crid']));
		$this->assign('surveylist',$surveylist);
		$this->display('aroom/survey');
	}
	
	public function add(){
		$smodel = $this->model('survey');
		$roominfo = Ebh::app()->room->getcurroom();
		if(NULL == $this->input->post()){
			$folder = $this->model('folder');
			$param['crid'] = $roominfo['crid'];
			$param['folderlevel'] = 1;
			$param['nosubfolder'] = 1;
			$param['limit'] = 1000;
			$courselist = $folder->getfolderlist($param);
			$this->assign('courselist',$courselist);
			$this->display('aroom/survey_add');
		}else{
			$param['crid'] = $roominfo['crid'];
			$param['title'] = $this->input->post('title');
			$param['content'] = serialize($this->input->post('content'));
			$param['type'] = $this->input->post('relatetype');
			if($param['type'] == 1){
				$param['folderid'] = $this->input->post('folderid');
			}elseif($param['type'] == 2){
				$param['folderid'] = $this->input->post('folderid');
				$param['cwid'] = $this->input->post('cwid');
				$survey = $smodel->getSurveyByCwid($param['cwid'],0);
				if(!empty($survey)){
					echo '该课下已有问卷,不能继续添加';
					exit;
				}
			}
			$res = $smodel->add($param);
			if(false !== $res) {
				echo 1;
				updateRoomCache($roominfo['crid'],'survey');
			} else
				echo 0;
		}
	}
	public function edit(){
		$smodel = $this->model('survey');
		$roominfo = Ebh::app()->room->getcurroom();
		if(NULL == $this->input->post()){
			$sid = $this->input->get('sid');
			$survey = $smodel->getSurveyDetail(array('crid'=>$roominfo['crid'],'sid'=>$sid));
			$survey['content'] = unserialize($survey['content']);
			
			//关联信息
			$relateinfo = array();
			if(!empty($survey['type'])){
				$foldermodel = $this->model('folder');
				$folder = $foldermodel->getfolderbyid($survey['folderid']);
				$relateinfo['folderid'] = $folder['folderid'];
				$relateinfo['foldername'] = $folder['foldername'];
				
				if($survey['type'] == 1){
					
				}elseif($survey['type'] == 2){
					$cwmodel = $this->model('courseware');
					$cw = $cwmodel->getSimplecourseByCwid($survey['cwid']);
					$relateinfo['cwid'] = $cw['cwid'];
					$relateinfo['title'] = $cw['title'];
				}
			}
			//课程列表
			$folder = $this->model('folder');
			$param['crid'] = $roominfo['crid'];
			$param['folderlevel'] = 1;
			$param['nosubfolder'] = 1;
			$param['limit'] = 1000;
			$courselist = $folder->getfolderlist($param);
			$this->assign('survey',$survey);
			$this->assign('courselist',$courselist);
			$this->assign('relateinfo',$relateinfo);
			
			$this->display('aroom/survey_edit');
		}else{
			$post = $this->input->post();
			$param['title'] = $post['title'];
			$param['content'] = serialize($post['content']);
			$param['crid'] = $roominfo['crid'];
			$param['sid'] = $post['sid'];
			$param['type'] = $post['relatetype'];
			if($param['type'] == 1){
				$param['folderid'] = $this->input->post('folderid');
			}elseif($param['type'] == 2){
				$param['folderid'] = $this->input->post('folderid');
				$param['cwid'] = $this->input->post('cwid');
				$survey = $smodel->getSurveyByCwid($param['cwid'],0);
				if(!empty($survey) && $survey['sid'] != $param['sid']){
					echo '该课下已有问卷,不能继续添加';
					exit;
				}
			}
			$res = $smodel->edit($param);
			if($res!=0)
				$smodel->delanswers(array('sid'=>$param['sid']));
			if(false !== $res){
				echo 1;
				updateRoomCache($roominfo['crid'],'survey');
			}
			else
				echo 0;
		}
	}
	
	// public function edit_view(){
		
		// $sid = $this->uri->itemid;
		
		// $roominfo = Ebh::app()->room->getcurroom();
		// $survey = $smodel->getSurveyDetail(array('crid'=>$roominfo['crid'],'sid'=>$sid));
		// $survey['content'] = unserialize($survey['content']);
		// $this->assign('survey',$survey);
		// $this->display('aroom/survey_edit');
	// }
	
	public function delete(){
		$sid = $this->input->post('sid');
		if(!is_numeric($sid))
			return false;
		$roominfo = Ebh::app()->room->getcurroom();
		$smodel = $this->model('survey');
		$res = $smodel->delete(array('sid'=>$sid,'crid'=>$roominfo['crid']));
		if(false != $res)
			echo 1;
		updateRoomCache($roominfo['crid'],'survey');
		else
			echo 0;
	}
	
	/*
	选择课件
	*/
	public function box_cw_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		if(in_array($roominfo['crid'],$cridarr['noteacher']))
			$this->assign('needsubfolder',false);
        $user = Ebh::app()->user->getAdminLoginUser();
        $this->assign('uid', $user['uid']);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		$queryarr['status'] = 1;
		// $queryarr['uid'] = $user['uid'];
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
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
        $this->assign('from',1);
        $this->assign('pagestr', $pagestr);
        //分配folderid
        $this->assign('folderid',$folderid);
        //分配教室信息
        $this->assign('roominfo',$roominfo);
        
        $this->display('aroom/survey_cwbox');
	}
	
	/*
	统计
	*/
	public function stat(){
		$sid = $this->input->get('sid');
		$roominfo = Ebh::app()->room->getcurroom();
		$smodel = $this->model('survey');
		$survey = $smodel->getSurveyDetail(array('crid'=>$roominfo['crid'],'sid'=>$sid));
		$survey['content'] = unserialize($survey['content']);
		
		if(!empty($survey))
			$answerlist = $smodel->getAnswers(array('sid'=>$sid));
		foreach($answerlist as $answers){
			$answerarr = unserialize($answers['answers']);
			foreach($answerarr as $k=>$answer){
				// $survey['content'][$k]
				if(empty($survey['content'][$k]['answer'][$answer[0]]))
					$survey['content'][$k]['answer'][$answer[0]] = 1;
				else
					$survey['content'][$k]['answer'][$answer[0]] ++;
				
			}
		}
		
		$this->assign('survey',$survey);
		$this->display('aroom/survey_stat');
	}
}
?>