<?php
	class TakemoneyController extends AdminControl{
		public function index(){
			$status = $this->input->get('status');
			$this->assign('status',intval($status));
			$this->display('admin/takemoney');
		}

		public function getListAjax(){
			$param = safeHtml($this->input->post());
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?10:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$TMModel = $this->model('takemoneylog');
			$TMList = $TMModel->getList($queryArr);
			$total = $TMModel->getCount($queryArr);
			array_unshift($TMList,array('total'=>$total));
			echo json_encode($TMList);
		}
		public function op(){
			$takeid = $this->input->post('takeid');
			$status = intval($this->input->post('status'));
			if(!in_array($status,array(-1,1,2))){
				echo 0;
				exit;
			}
			echo $this->model('takemoneylog')->op($takeid,$status); //=1表示成功
		}
	}
?>