<?php
/*
日志
*/
class LogController extends AdminControl{

	public function index(){
		
	}
	public function system(){
		$this->getlist(1,'system');
		$this->display('admin/log_system');
	}
	public function agent(){
		$this->getlist(1,'agent');
		$this->display('admin/log_agent');
	}
	public function getlist($init=0,$type='system'){
		$log = $this->model('log');
		$pagination = $this->input->get('param');
		$pagination['type'] = $pagination['type']?$pagination['type']:'ad';
		$pagination['pagesize'] = !empty($pagination['pagesize'])?$pagination['pagesize']:20;
		$pagination['pagenumber'] = !empty($pagination['pagenumber'])?$pagination['pagenumber']:1;
		if($type=='system')
			$pagination['total'] = $log -> getsystemlogcount($pagination);
		else if($type=='agent')
			$pagination['total'] = $log -> getagentlogcount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		if($type=='system')
			$loglist = $log -> getsystemloglist($pagination);
		else if($type=='agent')
			$loglist = $log -> getagenloglist($pagination);
		if(!$init)
		{
			$loglist[] = $pagination;
			echo json_encode($loglist);
		}
		else
		{
			$this->assign('loglist',json_encode($loglist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','log');
		}
	}
	public function del(){
		$logid = $this->input->post('logid');
		$res = $this->model('log')->deleteByLogId($logid);
		echo $res;
	}
}
?>