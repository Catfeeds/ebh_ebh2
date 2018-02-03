<?php
class SurveyController extends CControl{
	public function __construct() {
		parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
	}

	/**
	 * 问卷列表
	 */
	public function surveylist(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$get = $this->input->get();
		$param['folderid'] = !empty($get['folderid']) ? intval($get['folderid']) : 0;
		$param['q'] = isset($get['q']) ? h($get['q']) : '';
		$roominfo['crid'] = !empty($roominfo['crid']) ? intval($roominfo['crid']) : 0;
        $param['uid'] = !empty($user['uid']) ? intval($user['uid']) : 0;
        $param['showlist'] = !empty($get['showlist']) ? intval($get['showlist']) : 0;

		$param['crid'] = intval($roominfo['crid']);
		$param['pagesize'] = 50;    //设置每页显示50条数据
		$param['ispublish'] = 1;
		$param['answered'] = true;  //是否已回答
        $param['untype'] = 3;       //不看选课问卷

        $apiServer = Ebh::app()->getApiServer('ebh');
        $totalsurveylist = $apiServer->reSetting()->setService('Classroom.Survey.surveyList')->addParams($param)->request();
        $surveylist = $totalsurveylist['surveylist'];
        $surveycount = $totalsurveylist['surveycount'];

        $folder = $apiServer->reSetting()->setService('Classroom.Survey.getFolderById')->addParams($param)->request();
        $this->assign('folder',$folder);
        $pagestr = show_page($surveycount,$param['pagesize']);
        if(!empty($get['notop']) && ($get['notop']==1)){
            $this->assign('notop',true);
        }
        $this->assign('q',$param['q']);
		$this->assign('showlist',$param['showlist']);
		$this->assign('pagestr',$pagestr);
		$this->assign('surveylist',$surveylist);
		$this->display('college/survey_list');
	}

	/**
	 * 填写问卷
	 */
	public function fill_view() {
		$sid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(!is_numeric($sid))
			return false;
        $param = array();
        $param['uid'] = intval($user['uid']);
        $param['sid'] = intval($sid);
		//是否做过该问卷
        $apiServer = Ebh::app()->getApiServer('ebh');
        $surveyanswer = $apiServer->reSetting()->setService('Classroom.Survey.ifAnswered')->addParams($param)->request();
		if(!empty($surveyanswer)){
            header("Content-type: text/html; charset=utf-8");
			echo '您已回答过该问卷，请不要重复回答。';
			exit;
		}
        $param['crid'] = intval($roominfo['crid']);
        $survey = $apiServer->reSetting()->setService('Classroom.Survey.getOne')->addParams($param)->request();
        if(!empty($survey['cid'])){
            $param['cid'] = intval($survey['cid']);
            $course  = $apiServer->reSetting()->setService('Classroom.Survey.getCourse')->addParams($param)->request();
            $survey['xkid'] = intval($course['xkid']);
        }
        if(empty($survey)){
            show_404();
            exit;
        }
		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
            $param['cwid']=intval($survey['cwid']);
            $cw = $apiServer->reSetting()->setService('Classroom.Survey.getSimpleInfoById')->addParams($param)->request();
			$relateinfo = array('type'=>'课件','title'=>$cw['title']);
		}
		$this->assign('room', $roominfo);
		$this->assign('user', $user);
		$this->assign('notop', true);
		$this->assign('roominfo', $roominfo);
		$this->assign('relateinfo',$relateinfo);
		$this->assign('survey',$survey);
		$this->display('college/survey_fill');

	}

	/**
	 * 查看回答
	 */
	public function answer_view() {
		$sid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(!is_numeric($sid))
			return false;

        $param = array();
        $param['crid'] = intval($roominfo['crid']);
        $param['uid'] = intval($user['uid']);
        $param['sid'] = $sid;
        $apiServer = Ebh::app()->getApiServer('ebh');
        $survey = $apiServer->reSetting()->setService('Classroom.Survey.getOne')->addParams($param)->request();
        $answer = $apiServer->reSetting()->setService('Classroom.Survey.getOneAnswer')->addParams($param)->request();
        if(empty($survey)){
            show_404();
            exit;
        }
		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
            $param['cwid'] = intval($survey['cwid']);
            $cw = $apiServer->reSetting()->setService('Classroom.Survey.getSimpleInfoById')->addParams($param)->request();
			$relateinfo = array('type'=>'课件','title'=>$cw['title']);
		}
		$this->assign('room', $roominfo);
		$this->assign('user', $user);
		$this->assign('notop', true);
		$this->assign('relateinfo',$relateinfo);
		$this->assign('survey',$survey);
		$this->assign('answer',$answer);
		$this->display('college/survey_answer');

	}

	/**
	 * 统计
	 */
	public function stat_view() {
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
        $param = array();
        $param['crid'] = intval($roominfo['crid']);
        $param['sid'] = intval($sid);
        $apiServer = Ebh::app()->getApiServer('ebh');
        $survey = $apiServer->reSetting()->setService('Classroom.Survey.getOne')->addParams($param)->request();
        if(empty($survey)){
            show_404();
            exit;
        }
		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
            $param['cwid'] = intval($survey['cwid']);
            $cw = $apiServer->reSetting()->setService('Classroom.Survey.getSimpleInfoById')->addParams($param)->request();
			$relateinfo = array('type'=>'课件','title'=>$cw['title']);
		}
		$this->assign('room', $roominfo);
		$this->assign('user', $user);
		$this->assign('notop', true);
		$this->assign('survey',$survey);
		$this->assign('relateinfo', $relateinfo);
		$this->display('college/survey_stat');

	}
}