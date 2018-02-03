<?php
/*
评论控制器
*/
class AskanswerController extends CControl{

	public function index(){
		// 获取分类select控件
		$selectUtil = EBH::app()->lib('SelectUtil');
		$catlist = $selectUtil->getAskCatSelect('name = catid id = catid');
		$this->assign('selectobj',$catlist);
		$qid = $this->input->get('qid');
		$qid = empty($qid)?0:$qid;
		$this->assign('qid',$qid);
		$title = $this->input->get('title');
		$title = empty($title)?'':$title;
		$this->assign('xtitle',$title);
		$this->display('admin/askanswer');
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
		$queryArr['catid'] = $catidArr;
		$questionModel = $this->model('askquestion');
		$askquestionList = $questionModel->getAnswersByParam($queryArr);
		$askquestionCount = $questionModel->getAnswersByParamCount($queryArr);
		array_unshift($askquestionList, array('total'=>$askquestionCount));
		echo json_encode($askquestionList);
	}
	/*
	删除 ajax
	*/
	public function delOneAjax($aid=0,$qid=0,$uid=0){
		$tag = 0;
		if(empty($qid)){
			$tag = 1;
			$qid = (int)$this->input->post('qid');
			$aid = (int)$this->input->post('aid');
			$uid = (int)$this->input->post('uid');
		}
		$param = array('qid'=>$qid,'aid'=>$aid,'uid'=>$uid);
		$questionModel = $this->model('askquestion');
		if($questionModel->delanswer($param)){
			if(empty($tag)){
				return 1;
			}else{
				echo 1;
			}
			
		}else{
			if(empty($tag)){
				return 1;
			}else{
				echo 0;
			}
			
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
		$param = ltrim($param,';');
		$delcount = 0;
		$paramArr = explode(';',$param);
		foreach ($paramArr as  $aInfo) {
			$tmp = explode(',', $aInfo);
			if($this->delOneAjax($tmp[0],$tmp[1],$tmp[2])){
				$delcount+=1;
			}
		}
		if($delcount>0){
			echo 1;
		}else{
			echo 0;
		}
	}
	
}
?>