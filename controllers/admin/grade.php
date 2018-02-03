<?php
/*
年级
*/
class GradeController extends AdminControl{

	public function index(){
		$this->getlist(1);
		$this->display('admin/grade');
	}
	public function getlist($init=0){
		$grade = $this->model('grade');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $grade -> getgradecount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$gradelist = $grade -> getgradelist($pagination);
		
		if(!$init){
			$gradelist[] = $pagination;
			echo json_encode($gradelist);
		}
		else{
			$this->assign('gradelist',json_encode($gradelist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','grade');
		}
	}
	/*
	修改 ajax
	*/
	public function editgrade(){
		$grade = $this->model('grade');
		$param = $this->input->post();
		echo $grade->editgrade($param);
		
	}
	/*
	添加
	*/
	public function addgrade(){
		$grade = $this->model('grade');
		$param = $this->input->post();
		$res = $grade->addgrade($param);
		if($res)
		echo 1;
	}
	/*
	删除 ajax
	*/
	public function del(){
		$grade = $this->model('grade');
		$gradeid = $this->input->post('gradeid');
		echo json_encode(array('success'=>$grade->deletegrade($gradeid)));
	}
}
?>