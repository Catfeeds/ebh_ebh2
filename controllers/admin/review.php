<?php
/*
评论控制器
*/
class ReviewController extends AdminControl{

	public function index(){
		$this->display('admin/review');
	}
	public function getlist($init=0){
		$review = $this->model('review');
		
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $review -> getreviewcount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$reviewlist = $review -> getreviewlist($pagination);
		
		if(!$init)
		{
			$reviewlist[] = $pagination;
			echo json_encode($reviewlist);
		}
		else
		{
			$this->assign('reviewlist',json_encode($reviewlist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','review');
		}
	}
	
	public function getListAjax(){
		$query = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$queryArr['q'] = $query;
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$list = $this->model('review')->getreviewlist($queryArr);
		$total = $this->model('review')->getreviewcount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	/*
	删除 ajax
	*/
	public function del(){
		$review = $this->model('review');
		$logid = $this->input->post('logid');
		$param = array('logid'=>$logid);
		echo json_encode(array('success'=>$review->deletereview($param)));
	}
	
}
?>