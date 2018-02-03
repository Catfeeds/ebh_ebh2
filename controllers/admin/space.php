<?php
/*
原创空间
*/
class SpaceController extends AdminControl{
	
	public function index(){
		// $this->getlist(1);
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$uptype = 'space';
		$showpath = $_UP[$uptype]['imagepath'];
		$this->assign('showpath',$showpath);
		$this->display('admin/space');
	}
	// public function getlist($init=0){
	// 	$space = $this->model('space');
		
	// 	$pagination = $this->input->get('param');
	// 	$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
	// 	$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
	// 	$pagination['total'] = $space -> getspacecount($pagination);
	// 	$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
	// 	$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
	// 	$spacelist = $space -> getspacelist($pagination);
		
	// 	if(!$init)
	// 	{
	// 		$spacelist[] = $pagination;
	// 		echo json_encode($spacelist);
	// 	}
	// 	else
	// 	{
	// 		$this->assign('spacelist',json_encode($spacelist));
	// 		$this->assign('pagination',$pagination);
	// 		$this->assign('ctrl','space');
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
		$SModel = $this->model('space');
		$total = $SModel->getspacecount($queryArr);
		$SList = $SModel->getspacelist($queryArr);
		array_unshift($SList,array('total'=>$total));
		echo json_encode($SList);
	}
	/*
	删除 ajax
	*/
	public function del(){
		
		$space = $this->model('space');
		$param['id'] = $this->input->post('id');
		echo json_encode(array('success'=>$space->deletespaceitem($param)));
	
	}
	/*
	编辑
	*/
	public function edit(){
		$space = $this->model('space');
		if($this->input->post()){
			$param = $this->input->post();
			//var_dump($param);
			if($space->editspace($param)>0){
				$this->widget('note_widget',array('note'=>'编辑成功!','returnurl'=>'/admin/space.html'));
			}else{
				$this->widget('note_widget',array('note'=>'编辑失败!','returnurl'=>'/admin/space.html'));
			}
		}else{
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$uptype = 'space';
			$showpath = $_UP[$uptype]['imagepath'];
			$this->assign('showpath',$showpath);
			$id = $this->input->get('id');
			$spacedetail = $space->getspacedetail($id);
			$this->assign('spacedetail',$spacedetail);
			$this->display('admin/space_edit');
		}
	}
	/**
	 *根据id串批量删除
	 *@param String $ids
	 *@author zkq
	 *@return bool
	 *POST传值
	 *$ids格式为;id;id;id格式
	 */
	public function delAll(){
		$ids = ltrim($this->input->post('ids'),';');
		$idsArr = explode(';',$ids);
		//为了安全,将id传转为数字数组
		array_walk_recursive($idsArr,array(__CLASS__,'toInt'));
		$where = 'id='.ltrim(implode(' or id =',$idsArr),' or ');
		echo $this->model('space')->_delete($where);
	}
	/**
	 *批量修改精华,置顶,热门等级
	 *@param String $ids
	 *@param String $op
	 *@param int $tag
	 *@author zkq
	 *@return bool
	 *POST传值
	 *$ids格式为;id;id;id格式;$op为best,hot,top中的一个,$tag为best,hot,top等级0,1,2,3
	 */
	public function bthAll(){
		$op = trim($this->input->post('op'));
		$tag = intval($this->input->post('tag'));
		$ids = ltrim($this->input->post('ids'),';');
		//hot,top,best
		$idsArr = explode(';',$ids);
		//为了安全,将id传转为数字数组
		array_walk_recursive($idsArr,array(__CLASS__,'toInt'));
		$where = 'id='.ltrim(implode(' or id =',$idsArr),' or ');
		$param=array($op=>$tag);
		echo $this->model('space')->_update($param,$where);
	}
	/**
	 *
	 *
	 *
	 *
	 *注:inAndOrder格式为;id,order;id,order
	 */
	public function moveorderAll(){
		$idAndOrder = ltrim($this->input->post('idAndOrder'),';');
		$idAndOrderArr= explode(';',$idAndOrder);
		$ids = array();
		$wt='';
		foreach ($idAndOrderArr as  $iv) {
			$temp = explode(',',$iv);
			$temp[0]=intval($temp[0]);
			$ids[]=$temp[0];
			$wt.=' WHEN '.$temp[0].' THEN '.intval($temp[1]);
		}
		
		$ids = '('.implode(',',$ids).')';
		$sql = 'UPDATE ebh_useruploads SET displayorder = CASE id'.$wt.' END WHERE id IN '.$ids;
		echo $this->model('space')->_query($sql);

	}
	private static function toInt(&$param){
		$param =  intval($param);
	}
}
?>