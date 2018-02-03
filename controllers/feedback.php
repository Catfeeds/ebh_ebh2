<?php
/*
听课反馈
*/
class FeedbackController extends CControl{
	public function view(){
		$cwid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		//反馈记录
		$fbmodel = $this->model('feedback');
		$fblist = $fbmodel->getFeedbackList($param);
		//课件信息
		$coursemodel = $this->model('Courseware');
		$course = $coursemodel->getcoursedetail($cwid);
		$this->assign('course',$course);
		//如果反馈过,则显示结果,否则显示提交页面
		if(!empty($fblist)){
			$param2['cwid'] = $cwid;
			$fblistall = $fbmodel->getFeedbackList($param2);
			$this->assign('fblist',$fblistall);
			$feedbacknames = array('听懂','一知半解','听不懂');
			$difficultynames = array('容易','一般','较难');
			$qualitynames = array('很好','不错','一般','声音不佳','图像不佳');
			$levelnames = array('很精彩','还不错','一般般','有气无力');
			foreach($fblistall as $fb){
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
			$this->display('common/feedback_view');
		}else{
			$this->display('common/feedback_submit');
		}
	}
	public function add(){
		$postarr = $this->input->post();
		if(empty($postarr['cwid']) || !is_numeric($postarr['cwid'])){
			echo '非法提交';
			exit;
		}
		$user = Ebh::app()->user->getloginuser();
		//未登录跳转到结果页面
		if(empty($user)){
			// header('location:/feedback/'.$postarr['cwid'].'.html');
			echo 0;
			exit;
		}
		$fbmodel = $this->model('feedback');
		$param['cwid'] = $postarr['cwid'];
		$param['uid'] = $user['uid'];
		
		$fblist = $fbmodel->getFeedbackList($param);
		//如果反馈过,则显示结果,否则显示提交页面
		if(empty($fblist)){
			$param['feedback'] = $postarr['feedback'];
			$param['difficulty'] = $postarr['difficulty'];
			$param['quality'] = $postarr['quality'];
			$param['level'] = $postarr['level'];
			$param['text'] = h($postarr['text']);
			$fbmodel->add($param);
			echo 1;
			exit;
		}
		echo 0;
		// header('location:/feedback/'.$postarr['cwid'].'.html');
			
	}
	
	public function isfeedback_view(){
		$cwid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		$fbmodel = $this->model('feedback');
		$fblist = $fbmodel->getFeedbackList($param);
		if(empty($fblist))
			echo 0;
		else
			echo 1;
	}
}
?>