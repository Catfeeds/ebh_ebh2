<?php
/*
评论控制器
*/
EBH::app()->helper('portal');
class PreviewsController extends AdminControl{

	public function index(){
		$this->display('admin/previews');
	}
	
	public function getListAjax(){
		$query = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$queryArr['q'] = $query;
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$previewsModel = $this->model('previews');
		$previewsList = $previewsModel->getList($queryArr);
		$uidArr = array();
		foreach ($previewsList as  $review) {
			$uidArr[] = $review['uid'];
		}
		if(!empty($uidArr)){
			$userModel = $this->model('user');
			$userinfo = $userModel->getUserInfoByUid($uidArr);
			$previewsList =  visualLink(array($previewsList,$userinfo),array('uid','uid'));
		}
		
		$previewsCount = $previewsModel->getListCount($queryArr);
		array_unshift($previewsList, array('total'=>$previewsCount));
		echo json_encode($previewsList);
	}
	/*
	删除 ajax
	*/
	public function delOneAjax(){
		$previewsModel = $this->model('previews');
		$reviewid = $this->input->post('reviewid');
		echo $previewsModel->_delete(intval($reviewid));
	}
	/**
	 *修改单条评论状态
	 */
	public function changeOneStatus(){
		$reviewid = $this->input->post('reviewid');
		$status = $this->input->post('status');
		$param = array('status'=>intval($status));
		$where = array('reviewid'=>intval($reviewid));
		echo $this->model('previews')->_update($param,$where);
	}
	/**
	 *批量删除
	 *
	 */
	public function deleteAll(){
		$rec = $this->input->post();
		$param = $rec['param'];
		$previewsModel = $this->model('previews');
		$param = ltrim($param,';');
		$in = '('.str_replace(';',',',$param).')';
		
		$res = $previewsModel->_delete($in);
		if($res>0){
			echo 1;
		}else{
			echo 0;
		}
		
	}
	/**
	*批量改变状态
	*/
	public function changeStatus(){
		$rec = $this->input->post();
		$status = intval($rec['status']);
		if(!in_array($status,array(1,2))){
			echo 0;exit;
		}
		$reviews = str_replace(';',',',ltrim($rec['param'],';'));
		$in = '('.$reviews.')';
		$param = array('status'=>$status);
		$where = ' reviewid in '.$in;
		echo $this->model('previews')->_update($param,$where);
	}
}
?>