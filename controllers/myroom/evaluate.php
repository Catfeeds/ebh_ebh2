<?php
class EvaluateController extends CControl {
	private $user =null;
	private $evaluate = null;
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkstudent();
		$this->user = Ebh::app()->user->getloginuser();
		$this->evaluate = EBH::app()->getConfig()->load('evaluate');
	}
	//自我测评
	public function index(){
		$user= $this->user;
		$this->assign("user", $user);
		$this->display('evaluate/evaluate_index');
	}
	
	/*
	 学习动机,0
	*/
	public function dongji(){
		$user = $this->user;
		$mentalmodel = $this->model('Mentaltest');
		$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>0));
		if(!empty($result)){
			header('Location: /myroom/evaluate/result.html?ttype=0');
			exit;
		}
		$evaluate_dongji = $this->evaluate['dongji'];
		$this->assign('evaluate_dongji',$evaluate_dongji);
		$this->assign("type", "dongji");
		$this->display('evaluate/evaluate_tpl');
	}

	/*
	 心态,1
	*/
	public function xintai(){
		$user = $this->user;
		$mentalmodel = $this->model('Mentaltest');
		$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>1));
		if(!empty($result)){
			header('Location: /myroom/evaluate/result.html?ttype=1');
			exit;
		}
		$evaluate_xintai = $this->evaluate['xintai'];
		$this->assign("type", "xintai");
		$this->assign('evaluate_xintai',$evaluate_xintai);
		$this->display('evaluate/evaluate_tpl');
	}

	/*
	 焦虑,2
	*/
	public function jiaolv(){
		$user = $this->user;
		$mentalmodel = $this->model('Mentaltest');
		$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>2));
		if(!empty($result)){
			header('Location: /myroom/evaluate/result.html?ttype=2');
			exit;
		}
		$evaluate_jiaolv = $this->evaluate['jiaolv'];
		$this->assign("type", "jiaolv");
		$this->assign('evaluate_jiaolv',$evaluate_jiaolv);
		$this->display('evaluate/evaluate_tpl');
	}

	/*
	 升学,3
	*/
	public function shengxue(){
		$user = $this->user;
		$mentalmodel = $this->model('Mentaltest');
		$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>3));
		if(!empty($result)){
			header('Location: /myroom/evaluate/result.html?ttype=3');
			exit;
		}
		$evaluate_shengxue = $this->evaluate['shengxue'];
		$this->assign("type", "shengxue");
		$this->assign('evaluate_shengxue',$evaluate_shengxue);
		$this->display('evaluate/evaluate_tpl');
	}
	
	public function result(){
		$user = $this->user;
		$mentalmodel = $this->model('Mentaltest');
		if($this->input->post() != NULL ){
			$post = $this->input->post();
			$testtype = $this->input->get('ttype');
			$result = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>$testtype));
			$abcArr = array('A'=>0,'C'=>1,'E'=>2,'I'=>3,'R'=>4,'S'=>5);
			if(empty($result)){
				foreach($post as $k=>$value){
					$qid = ltrim($k,'q');
					$selectarr[$qid] = intval($value);
					// var_dump($value);
				}
				$score = array_sum(array_values($selectarr));
				if($testtype == 3){
						
					$evaluate_shengxue = $this->evaluate['shengxue'];
					foreach($evaluate_shengxue['types'] as $type=>$questions){
						$result[$type] = 0;
						foreach($questions as $qid){
							$result[$type]+= empty($selectarr[$qid])?0:intval($selectarr[$qid]);
						}
					}
					$max = 0;
					$score = 0;
					foreach($result as $type=>$sum){
						if($sum>$max){
							$max = $sum;
							$score = $abcArr[$type];
						}
					}
				}
				$answers = serialize($selectarr);
				// var_dump($answers);
				$row = $mentalmodel->insert(array('answers'=>$answers,'uid'=>$user['uid'],'testtype'=>$testtype,'score'=>$score));
			}
			header('Location: /myroom/evaluate/result.html?ttype='.$testtype);
		}
		else{
			$testtype = $this->input->get('ttype');
			if(empty($testtype))
				$testtype = 0;
			$ttypearr = array(
					0=>'dongji',
					1=>'xintai',
					2=>'jiaolv',
					3=>'shengxue'
			);
			$questions = $this->evaluate[$ttypearr[$testtype]];
			$answerArr = $mentalmodel->getAnswers(array('uid'=>$user['uid'],'testtype'=>$testtype));
			// var_dump($answerArr);
			// $asd = str_replace('\"','',$answerArr['answers']);
			// var_dump($asd);
			// var_dump(unserialize($answerArr['answers']));
			if(empty($answerArr)){
				header('Location: /myroom/evaluate/'.$ttypearr[$testtype].'.html');
				exit;
			}
				
			// $answers = unserialize($answerArr['answers']);
			// foreach($mentalquestion['types'] as $type=>$questions){
			// $result[$type] = 0;
			// foreach($questions as $qid){
			// $result[$type]+= empty($answers[$qid])?0:intval($answers[$qid]);
			// }
			// }
				
			$this->assign('score',$answerArr['score']);
			$this->assign('type',$ttypearr[$testtype]);
			if($testtype == 3)
				$this->display('evaluate/evaluate_'.$ttypearr[$testtype].'_result_'.$answerArr['score']);
			else
				$this->display('evaluate/evaluate_'.$ttypearr[$testtype].'_result');
		}
	}

}