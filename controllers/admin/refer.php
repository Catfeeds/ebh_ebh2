<?php
//测评参考项
class ReferController extends AdminControl{
	private $model = null;
	public function __construct(){
		parent::__construct();
		$this->model = $this->model("Evaluate");
	}
	
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
		
		$refers = $this->model->getrefersbyeid($eid);
		$this->assign('row', @$row[0]);
		$this->assign('refers', @$refers);
		$this->assign('eid', @$eid);
		$this->display("admin/evaluate/refers");
	}
	//评语添加
	public function add(){
		$eid = intval($this->input->get('eid'));
		$post = $this->input->post();
		$posteid = intval($post['eid']);
		if(!empty($eid)||!empty($posteid)){
			if($post['dopost']=="add" ){
				$data = array(
					'eid'=>$post['eid'],
					'startscore'=>$post['startscore'],
					'endscore'=>$post['endscore'],
					'keystr'=>$post['keystr'],	
					'keyitemstr'=>$post['keyitemstr'],
					'remarks'=>$post['remarks'],
				);
				$ck = $this->model->addrefer($data);
				if($ck>0){
					$this->showmessage("评语添加成功","/admin/refer.html?eid=$posteid");
				}else{
					$this->showmessage("评语添加失败","go");
				}
				exit(0);
			}else{
				$editor = Ebh::app()->lib('UMEditor');
				$this->assign('editor',$editor);
				$row = $this->model->getevaluatelist(array('eid'=>$eid));
				$this->assign('row', @$row[0]);
				$this->assign('eid', @$eid);
		
				$this->display("admin/evaluate/refer_add");
			}
		}else{
			$this->showmessage("请选择所属量表","go");
			exit(0);
		}
	}
	
	
	//评语删除
	public function del(){
		$rid = intval($this->input->post('rid'));
		$ck = $this->model->delrefer($rid);
		echo json_encode(array('success'=>($ck>0)?true:false));
		exit(0);
	}
	
	//评语编辑
	public function edit(){
		$rid = intval($this->input->get('rid'));
		$eid = intval($this->input->get('eid'));
		$post = $this->input->post();
		if($post['dopost']=="edit"){
			$rid = intval($this->input->post('rid'));
			$data = array(
					'eid'=>$post['eid'],
					'startscore'=>$post['startscore'],
					'endscore'=>$post['endscore'],
					'keystr'=>$post['keystr'],
					'keyitemstr'=>$post['keyitemstr'],
					'remarks'=>$post['remarks'],
			);
			$ck = $this->model->editrefer($data,$rid);
			if($ck>0){
				$this->showmessage("评语修改成功","/admin/refer.html?eid={$post['eid']}");
			}else{
				$this->showmessage("评语修改失败","go");
			}
			exit(0);
		}else{
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$row = $this->model->getevaluatelist(array('eid'=>$eid));
			$this->assign('row', @$row[0]);
			$this->assign('eid', @$eid);
			$refer = $this->model->getreferrow(array('rid'=>$rid));
			//var_dump($refer);
			$this->assign('refer', $refer);
			$this->display("admin/evaluate/refer_edit");
		}
	}
	
	//选择题号
	public function questions(){
		$eid = intval($this->input->get('eid'));
		$str = $this->input->get('str');
		$questions = $this->model->getquestionsbyeid($eid);
		$this->assign("questions", $questions);
		$this->assign("str", $str);
		$this->display("admin/evaluate/refer_questions");
	}
	
	/**
	 * 消息输出
	 * @param unknown $message
	 * @param string $url
	 */
	protected function showmessage($message,$url="/"){
		header("Content-type:text/html;charset=utf-8");
		$str =  '<script>alert("'.$message.'");';
		if($url=='go'){
			$str.="history.go('-1');</script>";
		}else{
			$str.="location.href='".$url."';</script>";
		}
		echo $str;
	}
}
?>