<?php
	class StudyController extends AdminControl{
		public function index(){
			$this->display('admin/study');
		}
		public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$ChargeModel = $this->model('studylog');
			$total = $ChargeModel->getListCount($queryArr);
			$ChargeList = $ChargeModel->getList($queryArr);
			array_unshift($ChargeList,array('total'=>$total));
			echo json_encode($ChargeList);
		}
	}
?>