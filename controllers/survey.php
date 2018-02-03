<?php
/**
 * 调查问卷
 */
class SurveyController extends CControl {

	function view() {
		$sid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(!is_numeric($sid))
			return false;

		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);
		if (empty($survey)) {
		    header('Location:/');
		    exit();
        }
		//print_r($survey);exit;
		if (empty($user)){
			//判断是否允许匿名投票
			if (empty($survey['allowanonymous'])){
				$url = geturl('login') . '?returnurl=' . geturl('survey/'.$sid);
				header("Location: $url");
				exit;
			}
		}
		else {
			//是否做过该问卷
			$surveyanswer = $this->model('survey')->ifAnswered(array('sid'=>$sid,'uid'=>$user['uid']));
			if(!empty($surveyanswer)){
                $return_url = trim($this->input->get('return'));
                if (!empty($return_url) && $return_url != 'blank') {
                    header('Location:'.$return_url);
                    exit();
                }
				echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
				echo '<title>'.strip_tags($survey['title']).'</title>';
				echo '您已回答过该问卷，请不要重复回答。';
				exit;
			}
		}
        $return_url = trim($this->input->get('return'));
		if (!empty($return_url)) {
            $return_url = urldecode($return_url);
            $this->assign('return', $return_url);
        }
		$this->assign('roominfo', $roominfo);

		$survey['top_questions'] = array_filter($survey['questionlist'], function($question) {
		   return in_array($question['type'], array(111, 112, 113));
        });
		if (!empty($survey['top_questions'])) {
		    $survey['questionlist'] = array_diff_key($survey['questionlist'], $survey['top_questions']);
        }
		$this->assign('survey',$survey);

		$this->display('college/survey_view');

	}

	/**
	 * 填表保存
	 */
	public function fillsave() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param['sid'] = $this->input->post('sid');
		$param['uid'] = empty($user) ? 0 : $user['uid'];

		$survey = $this->model('survey')->getSurveyDetail(array('sid'=>$param['sid'], 'crid'=>$roominfo['crid']));
		//判断是否允许匿名投票
		if (empty($user)){
			if (empty($survey['allowanonymous'])){
				echo json_encode(array('status' => -2));
				exit;
			}
		}
		else {
			//是否做过该问卷
			$surveyanswer = $this->model('survey')->ifAnswered(array('sid'=>$param['sid'],'uid'=>$param['uid']));
			if(!empty($surveyanswer)){
				echo json_encode(array('status' => -1));
				exit;
			}
		}

		parse_str($this->input->post('answer'), $answerArr);

//print_r($answerArr);exit();
		//获取所有问题列表
		$survey_question = $this->model('survey')->getQuestionList($param['sid']);
        //print_r($answerArr);print_r($survey_question);exit;
		//组合答案
		$answer = array();
		$checked_option = array();
		if (!empty($survey_question))
		{
			foreach ($survey_question as $question) {
				if (!empty($answerArr['answer_'.$question['qid']]))
				{
				    if ($question['type'] == 3 || $question['type'] == 4 || $question['type'] == 113) {
				        $answer[$question['qid']] = h($answerArr['answer_'.$question['qid']]);
				        continue;
                    }
				    if (is_array($answerArr['answer_'.$question['qid']])) {
                        foreach ($answerArr['answer_'.$question['qid']] as $value)
                        {
                            if ($question['type'] == 11 && $value == '0') {
                                $o = new stdClass();
                                $o->id = $answerArr['f_answer_o_'.$question['qid']];
                                $o->value = $answerArr['f_answer_'.$question['qid']];
                                $answer[$question['qid']] = $o;
                                continue;
                            }
                            $answer[$question['qid']][] = $value;
                        }
                    }
				}
			}
		}
		$result = $this->model('survey')->addanswer($answer,$param);
        //print_r($answer);
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

	/**
	 * 统计
	 */
	public function stat_view() {
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);
		//如果问卷是开通课程前的问卷(填空题)，不允许查看结果
		if (empty($survey['allowview']) || $survey['type'] == 4){
			echo '该调查问卷不允许查看统计结果。';
			exit;
		}
		$this->assign('survey',$survey);
		$this->display('college/survey_stat');

	}
}
