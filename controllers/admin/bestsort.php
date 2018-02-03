<?php
/*
精品课堂分类
*/
class BestsortController extends CControl{
	/*
	通过psid获得子分类列表
	*/
	public function getListAjax(){
		$queryArr['q'] = $this->inject_check($this->input->post('query'));
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		
		$offset=max(($pageNumber-1)*$pageSize,0);
		//$queryArr['limit']=$offset.','.$pageSize;
		$queryArr['psid'] = intval($this->input->post('psid'));
		$list = $this->model('Bestsorts')->getSortList($queryArr);
		echo json_encode($list);
	}
	/*
	ajax通过sid得到分类
	*/
	public function getsortbysid(){
		$sortmodel = $this->model('Bestsorts');
		$sid =  intval($this->input->post('sid'));
		$res = $sortmodel->getSortBysid($sid);
		echo json_encode($res);
	}
	
	/**
     * [inject_check 通过正则匹配字符串中是否存在sql关键字]
     * @param  [type] $sql_str [description]
     * @return [type]          [description]
     */
    private function inject_check($sql_str){     
    	if(!preg_match('/select|insert|and|or|update|delete|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/',$sql_str)) {
    		return $sql_str;
    	} else {
    		echo '出现非法字符';exit;
    	}
	}	
}
?>