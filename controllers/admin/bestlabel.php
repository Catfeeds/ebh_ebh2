<?php
/*精品课堂的标签
*/
class BestlabelController extends CControl{
	/*
	获得标签列表
	*/
	public function getListAjax(){
		$queryArr['q'] = $this->inject_check($this->input->post('query'));
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		//$offset=max(($pageNumber-1)*$pageSize,0);
		//$queryArr['limit']=$offset.','.$pageSize;
		$queryArr['sid'] = intval($this->input->post('sid'));
		$list = $this->model('Bestlabels')->getLabelList($queryArr);
		echo json_encode($list);
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