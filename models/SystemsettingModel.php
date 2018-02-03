<?php
/**
 * 系统设置模型
 */
class SystemsettingModel extends CModel {
	/**
	 * 获取系统设置信息
	 */
	public function getSetting($crid) {
		$sql = 'SELECT * FROM ebh_systemsettings WHERE crid=' . intval($crid);
		$row = $this->db->query($sql)->row_array();
		if (empty($row)) {
			$row = array(
				'crid' => $crid,
				'metakeywords' => '',
				'metadescription' => '',
				'favicon' => '',
				'faviconimg' => '',
				'ipbanlist' => '',
				'analytics' => '',
				'limitnum' => 0,
				'service' => 0,
				'opservicetime' => 0,
				'opserviceuid' => 0,
				'iscollect' => 0,
				'discounts' => '', 
			    'subtitle'=>''
			);
		}
		return $row;
	}

	/**
	 * 根据条件插入或更新
	 */
	public function update($param){
		$setarr = array();
		if(!empty($param['crid'])){
			$setarr['crid'] = $param['crid'];
		}
		if(isset($param['metakeywords'])){
			$setarr['metakeywords'] = $param['metakeywords'];
		}
		if(isset($param['metadescription'])){
			$setarr['metadescription'] = $param['metadescription'];
		}
		if(!empty($param['faviconimg'])){
			$setarr['faviconimg'] = $param['faviconimg'];
		}
		if(!empty($param['favicon'])){
			$setarr['favicon'] = $param['favicon'];
		}
		if(isset($param['ipbanlist'])){
			$setarr['ipbanlist'] = $param['ipbanlist'];
		}
		if(isset($param['analytics'])){
			$setarr['analytics'] = $param['analytics'];
		}
		if(isset($param['limitnum'])){
			$setarr['limitnum'] = $param['limitnum'];
		}
		if(isset($param['service'])){
			$setarr['service'] = $param['service'];
		}
		if(!empty($param['opservicetime'])){
			$setarr['opservicetime'] = $param['opservicetime'];
		}
		if(!empty($param['opserviceuid'])){
			$setarr['opserviceuid'] = $param['opserviceuid'];
		}
		if (!empty($param['crid']))
			$row = $this->db->query('SELECT * FROM ebh_systemsettings WHERE crid=' . intval($param['crid']))->row_array();
		//插入或更新
		if(!empty($row)){
			unset($setarr['crid']);
			return $this->db->update('ebh_systemsettings',$setarr,array('crid'=>$param['crid']));	
		}else{
			return $this->db->insert('ebh_systemsettings',$setarr);
		}
	}    


	public function getRefuse($crid){
		$crid = (int) $crid;
        $sql = "SELECT `refuse_stranger`,`mobile_register`,`review_interval`,`post_interval`,`limitnum` 
                FROM `ebh_systemsettings` 
                WHERE `crid`=$crid LIMIT 1";
        return $this->db->query($sql)->row_array();
	}
	
}