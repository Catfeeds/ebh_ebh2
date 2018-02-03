<?php
/*
年卡控制器
*/
class YearcardController extends AdminControl{
	
	public function index(){
		$this->getlist(1);
		$this->display('admin/yearcard');
	}
	public function getlist($init=0){
		$yearcard = $this->model('yearcard');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $yearcard -> getyearcardcount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$yearcardlist = $yearcard -> getyearcardlist($pagination);
		
		if(!$init)
		{
			$yearcardlist[] = $pagination;
			echo json_encode($yearcardlist);
		}
		else
		{
			$this->assign('yearcardlist',json_encode($yearcardlist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','yearcard');
		}
		
	}

	public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['citycode'] = max($queryArr['address_sheng'],$queryArr['address_shi'],$queryArr['address_qu']);
			$queryArr['limit'] = $offset.','.$pageSize;
			$YearCardModel = $this->model('yearcard');
			$total = $YearCardModel->getyearcardcount($queryArr);
			$yearCard = $YearCardModel->getyearcardlist($queryArr);
			array_unshift($yearCard,array('total'=>$total));
			echo json_encode($yearCard);
	}
	/*
		添加年卡
	*/
	public function add(){
		if($this->input->post()){
			$yearcard = $this->model('yearcard');
			$param = $this->input->post();
			$res = $yearcard->addyearcard_new($param);
			header('Location:'.geturl('admin/yearcard'));
		}
		else{
			$this->display('admin/yearcard_add');
		}
	}
	/*
	删除 ajax
	*/
	public function del(){
		$yearcard = $this->model('yearcard');
		$cardid = $this->input->post('cardid');
		echo json_encode(array('success'=>$yearcard->deleteyearcard($cardid)));
	}

	/**
	 *批量删除年卡
	 *
	*/
	public function delAll(){
		$param = ltrim($this->input->post('param'),';');
		$yearcardArr = explode(';',$param);
		array_walk_recursive($yearcardArr,array(__CLASS__,'toInt'));
		$in = '('.implode(',',$yearcardArr).')';
		$sql = 'delete from ebh_yearcards where cardid in '.$in;
		if($this->model('yearcard')->_query($sql)>0){
			echo 'success';
		}else{
			echo 'fail';
		}
	}

	/**
	 *将字符串转换为int类型,增加安全性
	 *
	*/
	public static function toInt(&$s){
		$s = intval($s);
	}
}
?>