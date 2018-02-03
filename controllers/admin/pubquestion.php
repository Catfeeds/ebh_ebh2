<?php
/*
公共题库
*/
class PubquestionController extends AdminControl{

	public function index(){
		$this->getlist(1);
		$this->display('admin/pubquestion');
	}
	public function getlist($init=0){
		$pubquestion = $this->model('pubquestion');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $pubquestion -> getpubquestioncount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$pubquestionlist = $pubquestion -> getpubquestionlist($pagination);
		
		if(!$init){
			$pubquestionlist[] = $pagination;
			echo json_encode($pubquestionlist);
		}
		else{
			$this->assign('pubquestionlist',json_encode($pubquestionlist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','pubquestion');
		}
	}
	/*
	删除 ajax
	*/
	public function del(){
		$pubquestion = $this->model('pubquestion');
		$aqid = $this->input->post('aqid');
		echo json_encode(array('success'=>$pubquestion->deletepubquestion($aqid)));
	}
}
?>