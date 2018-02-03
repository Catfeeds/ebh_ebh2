<?php 
class SurveyController extends CControl{
	public function __construct(){
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
		$param['crid'] = $roominfo['crid'];
		$param['ispublish'] = 1;
		$param['answered'] = true;//是否已回答
		$param['uid'] = $user['uid'];
		$surveylist = $this->model('survey')->getSurveyList($param);
		$surveycount = $this->model('survey')->getSurveyCount($param);
		$pagestr = show_page($surveycount);

		$this->assign('pagestr',$pagestr);
		$this->assign('surveylist',$surveylist);
		$this->display('myroom/survey_list');
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

		//是否做过该问卷
		$surveyanswer = $this->model('survey')->ifAnswered(array('sid'=>$sid,'uid'=>$user['uid']));
		if(!empty($surveyanswer)){
			echo '您已回答过该问卷，请不要重复回答。';
			exit;
		}

		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);

		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
			$cwmodel = $this->model('courseware');
			$cw = $cwmodel->getSimplecourseByCwid($survey['cwid']);
			$relateinfo = array('type'=>'课件','title'=>$cw['title']);
		}
		$this->assign('relateinfo',$relateinfo);
		$this->assign('survey',$survey);
		$this->display('myroom/survey_fill');

	}

	/**
	 * 填表保存
	 */
	public function fillsave() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param['sid'] = $this->input->post('sid');
		$param['uid'] = $user['uid'];

		//是否做过该问卷
		$surveyanswer = $this->model('survey')->ifAnswered(array('sid'=>$param['sid'],'uid'=>$param['uid']));
		if(!empty($surveyanswer)){
			echo json_encode(array('status' => -1));
			exit;
		}

		//判断当前时间是否在开放时间内
		$survey = $this->model('survey')->getSurveyDetail(array('sid'=>$param['sid'],'crid'=>$roominfo['crid']));
		if (!empty($survey) && !empty($survey['startdate']) && !empty($survey['enddate'])){
			if ($survey['startdate'] > SYSTIME || $survey['enddate'] < SYSTIME){
				echo json_encode(array('status' => -1));
				exit;
			}
		}

		parse_str($this->input->post('answer'), $answerArr);
		//获取所有问题列表
		$survey_question = $this->model('survey')->getQuestionList($param['sid']);

		//组合答案
		$answer = array();
		$checked_option = array();
		if (!empty($survey_question))
		{
			foreach ($survey_question as $question) {
				if (!empty($answerArr['answer_'.$question['qid']])){
                    if ($question['type'] == 3 || $question['type'] == 4 || $question['type'] == 113) {
                        $answer[$question['qid']] = h($answerArr['answer_'.$question['qid']]);
                        continue;
                    }
                    if (is_array($answerArr['answer_'.$question['qid']])) {
                        foreach ($answerArr['answer_' . $question['qid']] as $value) {
                            $answer[$question['qid']][] = $value;
                        }
                    }
				}
			}
		}

		$result = $this->model('survey')->addanswer($answer,$param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}
	}


	public function answer_view() {
		$sid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(!is_numeric($sid))
			return false;

		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);
		$answer = $this->model('survey')->getOneAnswer($sid, $user['uid']);

		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
			$cwmodel = $this->model('courseware');
			$cw = $cwmodel->getSimplecourseByCwid($survey['cwid']);
			$relateinfo = array('type'=>'课件','title'=>$cw['title']);
		}
		$this->assign('relateinfo',$relateinfo);
		$this->assign('survey',$survey);
		$this->assign('answer',$answer);
		$this->display('myroom/survey_answer');

	}

	public function stat_view() {
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);

		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
			$cwmodel = $this->model('courseware');
			$cw = $cwmodel->getSimplecourseByCwid($survey['cwid']);
			$relateinfo = array('type'=>'课件','title'=>$cw['title']);
		}

		$this->assign('survey',$survey);
		$this->assign('relateinfo', $relateinfo);
		$this->display('myroom/survey_stat');

	}
}
?>