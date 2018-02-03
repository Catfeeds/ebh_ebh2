<?php
/*
答疑
*/
class AskquestionController extends AdminControl{
	
	public function index(){
		$this->getList(1);
		$this->display('admin/askquestion');
	}
	public function getList($init=0){
		$askquestion = $this->model('askquestion');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = isset($pagination['pagesize'])?$pagination['pagesize']:20;
		$pagination['pagenumber'] = isset($pagination['pagenumber'])?$pagination['pagenumber']:1 ;
		$pagination['total'] = $askquestion -> getaskquestioncount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		
		$askquestionlist = $askquestion -> getaskquestionlist($pagination);
		
		if(!$init)
		{
			$askquestionlist[] = $pagination;
			echo json_encode($askquestionlist);
		}
		else{
			$this->assign('askquestionlist',json_encode($askquestionlist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','askquestion');
		}
	}
	/*
	删除 ajax
	*/
	public function del(){
		$askquestion = $this->model('askquestion');
		$qid = $this->input->post('qid');
		echo json_encode(array('success'=>$askquestion->deleteaskquestion($qid)));
	}
}
?>