<?php
/*
评论控制器
*/
class QuestionController extends CControl{

	public function index(){
		$selectUtil = EBH::app()->lib('SelectUtil');
		// 获取分类select控件
		$catlistSelect = $selectUtil->getAskCatSelect('name = catid id = catid');
		$this->assign('selectobj',$catlistSelect);
		$this->display('admin/question');
	}
	
	public function getListAjax(){
		$query = $this->input->post('query');
		parse_str($query,$queryArr);
		$pageSize = $this->input->post('pageSize');
		$pageNumber = $this->input->post('pageNumber');
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$subcatArr = $this->model('category')->getCatlistByUpid(intval($queryArr['catid']),5,null);
		$catidArr = array(intval($queryArr['catid']));
		foreach ($subcatArr as  $svalue) {
			$catidArr[] = $svalue['catid'];
		}
		unset($queryArr['catid']);
		$queryArr['catidlist'] = implode(',',$catidArr);
		$queryArr['crid'] = intval($queryArr['crid']);
		$questionModel = $this->model('askquestion');
		$askquestionList = $questionModel->getaskquestionlist($queryArr);
		$askquestionCount = $questionModel->getaskquestioncount($queryArr);
		array_unshift($askquestionList, array('total'=>$askquestionCount));
		echo json_encode($askquestionList);
	}
	/*
	删除 ajax
	*/
	public function delOneAjax($qid=0){
		if(empty($qid)){
			$qid = $this->input->post('qid');
		}
		$questionModel = $this->model('askquestion');
		if($questionModel->delask(intval($qid))){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	/**
	 *批量删除
	 *
	 */
	public function deleteAll(){
		$rec = $this->input->post();
		$param = $rec['param'];
		$questionModel = $this->model('askquestion');
		$param = ltrim($param);
		$qidArr = explode(';',$param);
		$delcount = 0;
		foreach ($qidArr as  $qid) {
			if($this->delOneAjax($qid)){
				$delcount+=1;
			}
		}
		$res = $delcount==count($qidArr)?1:0;
		if($res>0){
			echo 1;
		}else{
			echo 0;
		}
		
	}
	
}
?>