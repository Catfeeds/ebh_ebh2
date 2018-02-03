<?php
/**
 * 网校配置model
 * @author Eker
 *
 */
class RoomconfigModel extends CModel{
	private $redis = null;
	public function __construct(){
		parent::__construct();
		$this->redis = Ebh::app()->getCache('cache_redis');
		define('KEY_PREFIX', '_room_config_');
	}
	
	/**
	 * 追加配置
	 * @param unknown $param
	 * @param unknown $crid
	 */
	public function appendConfig($param,$crid){
		$sql = 'select * from ebh_room_configs where crid = '.$crid.' and del = 0';
		$row = $this->db->query($sql)->row_array();
		if(!empty($row)){
			$jsonObj = json_decode($row['json_str']);
			foreach ($param as $key => $val){
				$jsonObj->$key = $val;
			}
			$json_str = json_encode($jsonObj);
			$ret =$this->updateConfig(array('json_str'=>$json_str), $crid);
		}else{
			$ret = $this->addConfig($param, $crid);
		}
		return $ret > 0 ? $json_str : false;
	}
	
	/**
	 * 获取网校配置
	 * @param unknown $crid
	 */
	public function  getConfig($crid){
		$jsonObj = false;
		$key =  KEY_PREFIX.$crid;
		$json_str = $this->redis->get($key);
		if(empty($json_str)){
			$sql = 'select * from ebh_room_configs where crid = '.$crid.' and del = 0';
			$row = $this->db->query($sql)->row_array();
			$json_str = $row['json_str'];
		}
		if(!empty($json_str)){
			$jsonObj = json_decode($json_str);
		}
		return $jsonObj;
	}
	
	/**
	 * 重置配置
	 * @param unknown $crid
	 */
	public function resetConfig($crid){
		$ck = $this->db->delete('ebh_room_configs',array('crid'=>$crid));
		if($ck){
			$key =  KEY_PREFIX.$crid;
			$this->redis->del($key);
		}
		return ;
	}
	
	/**
	 *修改配置 
	 * @param unknown $crid
	 */
	public function updateConfig($param,$crid){
		$setArr = array();
		if(empty($param)||!is_array($param)||intval($crid)<=0){
			return false;
		}
		if($param['json_str']){
			$setArr['json_str'] = $this->db->escape_str($param['json_str']);
		}
		$where = array('crid'=>$crid,'del'=>0);
		$ret = $this->db->update('ebh_room_configs',$setArr,$where);
		if($ret > 0){
			$key = KEY_PREFIX.$crid;
			$value = $param['json_str'];
			$this->redis->set($key,$value,0);
		}
		return $ret;
	}
	
	/**
	 * 添加配置
	 * @param unknown $param
	 * @param unknown $crid
	 */
	public function addConfig($param,$crid){
		$setArr = array();
		if(empty($param)||!is_array($param)||intval($crid)<=0){
			return false;
		}
		if($param['json_str']){
			$setArr['json_str'] = $this->db->escape_str($param['json_str']);
		}
		$setArr['crid'] = $crid;
		$ret = $this->db->insert('ebh_room_configs',$setArr);
		if($ret > 0){
			$key = KEY_PREFIX.$crid;
			$value = $param['json_str'];
			$this->redis->set($key,$value,0);
		}
		return $ret;
	}
	
}
?>