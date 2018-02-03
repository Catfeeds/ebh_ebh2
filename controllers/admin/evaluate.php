<?php
//测评量表控制器
class EvaluateController extends AdminControl{
	private $model = null;
	public function __construct(){
		parent::__construct();
		$this->model = $this->model("Evaluate");
	}
	
	//量表列表
	public function index(){

		$this->display('admin/evaluate/index');
	}
	//ajax获取测评量表
	function getevaluatelistajax(){
		$query = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$queryArr['q'] = $query;
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$queryArr['del']=0;
		$list = $this->model->getevaluatelist($queryArr);
		$total = $this->model->getevaluatecount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	//量表添加
	public function add(){
		$post = $this->input->post();
		if($post['dopost']=="add"){
			$nums = intval($post['nums']);
			$data = array(
				'title'	=>$post['title'],
				'tutor'	=>$post['tutor'],
				'descr'	=>$post['descr'],
				'logo'	=>$post['up']['upfilepath'],
				'nums' 	=>$nums,
				'total'	=>intval($post['total']),		
			);
			
			if($nums>0){
				$item = array();
				for($i=0;$i<$nums;$i++){
					$item[] =array(
						'item'=> $post['item'][$i],
						'score'=>$post['score'][$i]
					);
				}
				$data['itemstr'] = serialize($item);
			}
			
			
			$ck = $this->model->addevaluate($data);
			if($ck>0){
				$this->showmessage('量表添加成功 \n请继续添加问题',"/admin/questions.html?eid=$ck");
			}else{
				$this->showmessage('量表添加失败',"go");
			}
			
		}else{
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->display('admin/evaluate/add');
		}

	}
	//量表修改
	public function edit(){
		$post = $this->input->post();
		if($post['dopost']=="edit"){
			//var_dump($post);exit;
			$nums = intval($post['nums']);
			$data = array(
					'title'	=>$post['title'],
					'tutor'	=>$post['tutor'],
					'descr'	=>$post['descr'],
					'nums' 	=>$nums,
					'total'	=>intval($post['total']),
			);
			
			if($nums>0){
				$item = array();
				for($i=0;$i<$nums;$i++){
					$item[] =array(
							'item'=> $post['item'][$i],
							'score'=>$post['score'][$i]
					);
				}
				$data['itemstr'] = serialize($item);
			}
			
			$eid= intval($this->input->post('eid'));
			if(!empty($post['up'])){
				$data['logo'] = $post['up']['upfilepath'];
			}
			$ck = $this->model->editevaluate($data,$eid);
			//var_dump($ck);exit;
			if($ck>0){
				$this->showmessage('量表修改成功',geturl("admin/evaluate"));
			}else{
				$this->showmessage('量表修改失败',"go");
			}
				
		}else{
			$eid= intval($this->input->get('eid'));
			$evaluates = $this->model->getevaluatelist(array('eid'=>$eid));
			$this->assign("evaluate", @$evaluates[0]);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->display('admin/evaluate/edit');
		}	
	}
	
	//量表删除
	public function del(){
		$eid = intval($this->input->post('eid'));
		$ck = $this->model->editevaluate(array('del'=>1),$eid);
		echo json_encode(array('success'=>($ck>0)?true:false));
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