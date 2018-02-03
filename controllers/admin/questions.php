<?php
//测评问题控制器
class QuestionsController extends AdminControl{
	private $model = null;
	public function __construct(){
		parent::__construct();
		$this->model = $this->model("Evaluate");
	}
	
	//测评问题
	public function index(){
		$eid = intval($this->input->get('eid'));
		$evaluates = $this->model->getallevaluates();
		$this->assign("evaluates", $evaluates);
		
		if(!empty($eid)){
			$row = $this->model->getevaluatelist(array('eid'=>$eid));
			$questions = $this->model->getquestionsbyeid($eid);
		}else{
			$row = array();
		}
		
		$questions = $this->model->getquestionsbyeid($eid);
		$this->assign('row', @$row[0]);
		$this->assign('questions', @$questions);
		$this->display('admin/evaluate/questions');
	}
	
	//添加/修改一条测评问题
	public function addone(){
		$post = $this->input->post();
		$qid = intval($this->input->post('qid'));
		
		$data = array(
				'qtitle'=>$post['qtitle'],
				'sort'=>intval($post['sort']),
				'eid'=>intval($post['eid']),
				'qitemstr' =>serialize($post['itemarr']),
		);
		
		if($qid>0){
			//修改
			$ck = $this->model->editquestion($data,$qid);
		}else{
			//添加
			$ck = $this->model->addquestion($data);
		}

		echo json_encode(array('code'=>($ck>0)?true:false,'qid'=>$ck));
		exit(0);
	}
	
	//删除一个问题
	public function delone(){
		$post = $this->input->post();
		$qid = intval($post['qid']);
		$ck = $this->model->delquestion($qid);
		echo json_encode(array('code'=>($ck>0)?true:false));
		exit(0);
	}
}
?>