<?php
/*
开通
*/
class OpencountController extends AdminControl{

	public function index(){
		// $this->getlist(1);
		$this->display('admin/opencount');
	}
	// public function getlist($init=0){
	// 	$opencount = $this->model('opencount');
	// 	$pagination = $this->input->get('param');
	// 	$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
	// 	$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
	// 	$pagination['total'] = $opencount -> getopencountcount($pagination);
	// 	$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
	// 	$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
	// 	$opencountlist = $opencount -> getopencountlist($pagination);
		
	// 	if(!$init)
	// 	{
	// 		$opencountlist[] = $pagination;
	// 		echo json_encode($opencountlist);
	// 	}
	// 	else
	// 	{
	// 		$this->assign('opencountlist',json_encode($opencountlist));
	// 		$this->assign('pagination',$pagination);
	// 		$this->assign('ctrl','opencount');
	// 	}
	// }
	/**
	 *获开通记录列表,不解释
	 */
	public function getListAjax(){
		$param = safeHtml($this->input->post());
		$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
		$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
		$offset = max(0,($pageNumber-1)*$pageSize);
		parse_str($param['query'],$queryArr);
		$queryArr['limit'] = $offset.','.$pageSize;
		$queryArr['begintime']=strtotime($queryArr['begintime']);
		$queryArr['endtime']=strtotime($queryArr['endtime']);
		$PModel = $this->model('opencount');
		$total = $PModel->getopencountcount($queryArr);
		$PList = $PModel->getopencountlist($queryArr);
		array_unshift($PList,array('total'=>$total));
		echo json_encode($PList);
	}
}
?>