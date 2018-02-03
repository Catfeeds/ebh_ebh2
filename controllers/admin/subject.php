<?php
/*
科目
*/
class SubjectController extends AdminControl{
	
	public function index(){
		$this->getlist(1);
		$this->display('admin/subject');
	}
	public function getlist($init=0){
		$subject = $this->model('subject');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $subject -> getsubjectcount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$subjectlist = $subject -> getsubjectlist($pagination);
		
		if(!$init){
			$subjectlist[] = $pagination;
			echo json_encode($subjectlist);
		}
		else{
			$this->assign('subjectlist',json_encode($subjectlist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','subject');
		}
	}
	/*
	删除 ajax
	*/
	public function del(){
		$subject = $this->model('subject');
		$subjectid = $this->input->post('subjectid');
		echo json_encode(array('success'=>$subject->deletesubject($subjectid)));
	}
	/*
	修改 ajax
	*/
	public function editsubject(){
		$subject = $this->model('subject');
		$param = $this->input->post();
		echo $subject -> editsubject($param);
	}
	/*
	添加 ajax
	*/
	public function addsubject(){
		$subject = $this->model('subject');
		$param = $this->input->post();
		$res = $subject -> addsubject($param);
		if($res)
			echo 1;
	}
}
?>