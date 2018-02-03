<?php
/*
服务包分类
*/
class SpsortController extends AdminControl{
	public function getListAjax(){
		$queryArr['q'] = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$queryArr['pid'] = $this->input->post('pid');
		$list = $this->model('Paysort')->getSortList($queryArr);
		$total = $this->model('Paysort')->getSortCount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	public function add(){
		$sortdata = $this->input->post('sortdata');
		parse_str($sortdata,$param);
		$sortmodel = $this->model('Paysort');
		$res = $sortmodel->add($param);
		if(!empty($res))
			echo 1;
		else
			echo 0;
	}
	public function edit(){
		$sortdata = $this->input->post('sortdata');
		parse_str($sortdata,$param);
        if (empty($param['ishide'])) {
            $param['ishide'] = 0;
        }
		if(empty($param['showbysort']))
			$param['showbysort'] = 0;
		if(empty($param['showaslongblock']))
			$param['showaslongblock'] = 0;
		$sortmodel = $this->model('Paysort');
		$res = $sortmodel->edit($param);
		if($res!==false)
			echo 1;
		else
			echo 0;
	}
	
	public function getDetail(){
		$sid = $this->input->post('sid');
		$sortmodel = $this->model('Paysort');
		$sortdetail = $sortmodel->getSortdetail($sid);
		echo json_encode($sortdetail);
	}
	
	public function del(){
		$sid = $this->input->post('sid');
		$sortmodel = $this->model('Paysort');
        $db = Ebh::app()->getDb();
        $db->begin_trans();
        $sortmodel->del($sid);
        if ($db->trans_status() === false) {
            $db->rollback_trans();
            echo json_encode(array('success'=>false,'msg'=>'删除失败'));
            exit();
        }
        $sortmodel->setItemSidToZero($sid);
        if ($db->trans_status() === false) {
            $db->rollback_trans();
            echo json_encode(array('success'=>false,'msg'=>'删除失败'));
            exit();
        }
        $db->commit_trans();
        echo json_encode(array('success'=>true,'msg'=>'成功'));
	}
}