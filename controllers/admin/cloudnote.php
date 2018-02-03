<?php
/*
云平台留言
*/
class CloudnoteController extends AdminControl{
	
	public function index(){
		// $this->getList(1);
		$this->display('admin/cloudnote');
	}
	// public function getlist($init=0){
	// 	$cloudnote = $this->model('cloudnote');
	// 	$pagination = $this->input->get('param');
	// 	$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
	// 	$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
	// 	$pagination['total'] = $cloudnote -> getcloudnotecount($pagination);
	// 	$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
	// 	$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
	// 	$cloudnotelist = $cloudnote -> getcloudnotelist($pagination);
		
	// 	if(!$init){
	// 		$cloudnotelist[] = $pagination;
	// 		//$cloudnotelist[] = $where;
	// 		echo json_encode($cloudnotelist);
	// 	}
	// 	else{
	// 		$this->assign('cloudnotelist',json_encode($cloudnotelist));
	// 		$this->assign('pagination',$pagination);
	// 		//$this->assign('where',$where);
	// 		$this->assign('ctrl','cloudnote');
	// 	}
	// }
	/**
	 *获取留言列表,用于后台教室管理->云教育平台留言的列表显示
	 *@author zkq
	 *@date 2014-04-22
	 *注:替代了ckx的getlist方法
	 */
	public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$CNModel = $this->model('cloudnote');
			$total = $CNModel->getcloudnotecount($queryArr);
			$CNList = $CNModel->getcloudnotelist($queryArr);
			array_unshift($CNList,array('total'=>$total));
			echo json_encode($CNList);
	}
	/*
	修改 ajax
	*/
	public function editcloudnote(){
		$cloudnote = $this->model('cloudnote');
		$param = $this->input->post();
		echo $cloudnote->editcloudnote($param);
	}
	/**
	 *根据noteid获取单条的留言信息
	 *@author zkq
	 */
	public function detail(){
		$noteid = intval($this->input->get('noteid'));
		$oneInfo = $this->model('cloudnote')->getOne($noteid);
		$this->assign('c',$oneInfo);
		$this->display('admin/cloudnote_detail');
	}	
}
?>