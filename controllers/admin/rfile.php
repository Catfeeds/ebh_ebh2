<?php
/*
资源分享 文件
*/
class RfileController extends AdminControl{

	public function index(){
		$this->getlist(1);
		$this->display('admin/rfile');
	}
	public function getlist($init=0){
		$rfile = $this->model('rfile');
		
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $rfile -> getrfilecount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$rfilelist = $rfile -> getrfilelist($pagination);
		
		if(!$init)
		{
			$rfilelist[] = $pagination;
			echo json_encode($rfilelist);
		}
		else
		{
			$this->assign('rfilelist',json_encode($rfilelist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','rfile');
		}
	}
	/*
	添加文件
	*/
	public function add(){
		if($this->input->post()){
			$rfile = $this->model('rfile');
			$param = $this->input->post();
			$res = $rfile->addrfile($param);
			var_dump($res);
		}else{
			$this->display('admin/rfile_add');
		}
	}
	public function edit(){
		$rfile = $this->model('rfile');
		if($this->input->post()){
			$param = $this->input->post();
			echo $rfile->editrfile($param);
		}else{
			$rid = $this->input->get('rid');
			$rfiledetail = $rfile->getrfiledetail($rid);
			$this->assign('rfiledetail',$rfiledetail);
			$this->display('admin/rfile_edit');
		}
	}
	/*
	详情
	*/
	public function view(){
		$rfile = $this->model('rfile');
		$rid = $this->input->get('rid');
		$rfiledetail = $rfile->getrfiledetail($rid);
		$this->assign('rfiledetail',$rfiledetail);
		$this->display('admin/rfile_view');
	}
	/*
	修改 ajax
	*/
	public function editrfile(){
		$rfile = $this->model('rfile');
		$param = $this->input->post();
		echo $rfile -> editrfile($param);
	}
	/*
	删除 ajax
	*/
	public function del(){
		$rfile = $this->model('rfile');
		$rid = $this->input->post('rid');
		echo json_encode(array('success'=>$rfile->deleterfile($rid)));
	}
} 
?>