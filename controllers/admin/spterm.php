<?php
/*
服务期
*/
class SptermController extends AdminControl{
	public function index(){
		$this->display('admin/servicepack_termlist');
	}
	public function getListAjax(){
		$queryArr['q'] = $this->input->post('query');
		$queryArr['crid'] = $this->input->post('crid');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$list = $this->model('Payterm')->getTermList($queryArr);
		$total = $this->model('Payterm')->getTermListCount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	public function add(){
		if($this->input->post()){
			$param['tname'] = $this->input->post('tname');
			$param['crid'] = $this->input->post('crid');
			$param['tsummary'] = $this->input->post('tsummary');
			$param['tdisplayorder'] = $this->input->post('sid');
			
			$ptmodel = $this->model('Payterm');
			$res = $ptmodel->add($param);
			if(isset($res)){
				$note[] = '确定并关闭';
				$rurl[] = '/admin/spterm.html';
				$note[] = '继续添加';
				$rurl[] = '/admin/spterm/add.html?crid='.$param['crid'];
				$note[] = '添加服务包到该服务期下';
				$rurl[] = '/admin/servicepack/add.html?tid='.$res;
				$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
			}
			else
				$this->goback('添加失败!',$returnurl);
		}else{
			$crid = $this->input->get('crid');
			if(!empty($crid)){
				$crmodel = $this->model('classroom');
				$roomdetail = $crmodel->getclassroomdetail($crid);
				$this->assign('roomdetail',$roomdetail);
			}
			$this->display('admin/servicepack_termadd');
		}
	}
	public function edit(){
		$ptmodel = $this->model('Payterm');
		if($this->input->post()){
			$param['tid'] = $this->input->post('tid');
			$param['tname'] = $this->input->post('tname');
			$param['crid'] = $this->input->post('crid');
			$param['tsummary'] = $this->input->post('tsummary');
			$param['tdisplayorder'] = $this->input->post('tdisplayorder');
			$ptmodel = $this->model('Payterm');
			$res = $ptmodel->edit($param);
			$returnurl = '/admin/spterm.html';
			if(isset($res)){
				$note[] = '确定并关闭';
				$rurl[] = '/admin/spterm.html';
				$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
			}
			else
				$this->goback('添加失败!',$returnurl);
		}else{
			$tid = $this->input->get('tid');
			$termdetail = $ptmodel->getTermByTid($tid);
			$this->assign('termdetail',$termdetail);
			$this->display('admin/servicepack_termedit');
		}
	}
	
	public function del(){
		$ptmodel = $this->model('Payterm');
		$tid = $this->input->post('tid');
		echo json_encode(array('success'=>$ptmodel->deleteterm($tid)));
		
	}
	
	public function view(){
		$tid = $this->input->get('tid');
		$ptmodel = $this->model('payterm');
		$termdetail = $ptmodel->getTermByTid($tid);
		$this->assign('termdetail',$termdetail);
		$this->display('admin/servicepack_termview');
	}
	
	public function changestatus(){
		$param['tid'] = $this->input->post('tid');
		$param['status']= $this->input->post('status');
		$ptmodel = $this->model('payterm');
		$result = $ptmodel->edit($param);
		if($result != false)
			echo 1;
	}
	
	public function goback($note="操作成功,正在努力跳转中...",$returnurl="/admin/spterm.html"){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
	
	public function search(){
		$this->display('admin/servicepack_termsearch');
	}
	
}