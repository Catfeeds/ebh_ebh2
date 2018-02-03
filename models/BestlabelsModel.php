<?php
class BestlabelsModel extends CModel{
	/*
	通过条件筛选，获取标签列表
	*/
	public function getLabelList($param){
		$sql = 'select l.id,l.label from ebh_best_labels l';
		$wherearr = array();
		if(isset($param['sid']))
			$wherearr[].='l.sid='.$param['sid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}

	/*
	添加标签
	*/
	public function addlabel($param) {
		if(!empty($param['label'])){
				$setarr['label'] = $param['label'];
		}
		if(!empty($param['sid'])){
			$setarr['sid'] = $param['sid'];
		}
		$id = $this->db->insert('ebh_best_labels',$setarr);
		return $id;
	}

	/*
	当精品课堂选择了所属标签时，添加两者的关系表
	*/
	public function additemlabel($param) {
		if(!empty($param['label'])){
				$setarr['label'] = $param['label'];
		}
		if(!empty($param['itemid'])){
			$setarr['itemid'] = $param['itemid'];
		}
		$id = $this->db->insert('ebh_best_itemlabels',$setarr);
		return $id;
	}

	/*
	通过所属的多个itemid和label名删除标签
	*/
	public function delLabelItems($labelname, $ids) {
		$sql = "delete from ebh_best_itemlabels where label='{$labelname}' and itemid in ($ids)";
		$this->db->query($sql);
	}

	/*
	通过所属itemid和label名删除标签与精品课堂关系表
	*/
	public function delitemlabel($param) {
		if(!empty($param['label'])){
				$setarr['label'] = $param['label'];
		}
		if(!empty($param['itemid'])){
			$setarr['itemid'] = $param['itemid'];
		}
		$mes = $this->db->delete('ebh_best_itemlabels', $setarr);
		return $mes;
	}

	/*
	通过sid获取标签
	*/
	public function getLabelBySid($sid){
		if(!empty($sid)){
			$sql = 'select label,id from `ebh_best_labels` where `sid` = '.$sid;
			return $this->db->query($sql)->list_array();
		}
		return false;
	}

	/*
	通过id删除标签
	*/
	function dellabel($id) {
		$arr = array('id' => $id);
		$mes = $this->db->delete('ebh_best_labels', $arr);
		return $mes;
	}

	/*
	通过id更新标签名
	*/
	function updatelabel($param,$id) {
		if(isset($param['label'])){
				$setarr['label'] = $param['label'];
		}
		return $this->db->update('ebh_best_labels',$setarr,array('id'=>$id));
	}

	/*
	通过sid检测该分类下是否存在相同的标签名
	*/
	public function check($sid, $label) {
		$sql = 'select id from ebh_best_labels where sid ='. $sid . ' and label ='.'\''. $label. '\'';
		return $this->db->query($sql)->list_array();
	}

}
?>