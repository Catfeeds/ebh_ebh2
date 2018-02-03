<?php
/*
汇款单模型
*/
class OrdercashModel extends CModel{
	public function add($param) {
		if(empty($param))
			return FALSE;
		$setarr = array();
		if(!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
		if(!empty($param['imgpath']))
			$setarr['imgpath'] = $param['imgpath'];
		if(!empty($param['contact']))
			$setarr['contact'] = $param['contact'];
		if(!empty($param['remark']))
			$setarr['remark'] = $param['remark'];
		if(!empty($param['itemids']))
			$setarr['itemids'] = $param['itemids'];
		if(!empty($param['dateline']))
			$setarr['dateline'] = $param['dateline'];
		if(!empty($param['status']))
			$setarr['status'] = $param['status'];
		if(!empty($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(!empty($param['ip']))
			$setarr['ip'] = $param['ip'];
		if(!empty($param['remit']))
			$setarr['remit'] = $param['remit'];
		$result = $this->db->insert('ebh_ordercash',$setarr);
		return $result;
	}
}