<?php
/**
 * 课程目录模型
 */
class SchcatalogModel extends CModel
{
	/**
	 * 获取课程目录树形列表
	 * @param  integer $crid 网校编号
	 * @return array       课程目录树形列表
	 */
	public function getList($crid)
	{
		$sql = 'SELECT catalogid,catalogname,pid,displayorder FROM ebh_schcatalogs WHERE crid=' . intval($crid);
		$sql.=' order by pid,displayorder,catalogid ';

		$list = $this->db->query($sql)->list_array();

		return $list;
	}

	/**
	*判断给定目录名称是否存在
	*/
	public function catalog_exists($catalogname,$crid=0,$pid=0,$catalogid=0) {
		if(empty($catalogid)) {
			$sql = 'select catalogid from ebh_schcatalogs c where c.crid='.intval($crid).' and c.pid='.intval($pid)." and c.catalogname='".$this->db->escape_str($catalogname)."'";
		} else {
			$sql = 'select catalogid from ebh_schcatalogs c where c.crid='.intval($crid).' and c.pid='.intval($pid).' and c.catalogid !='.intval($catalogid)." and c.catalogname='".$this->db->escape_str($catalogname)."'";
		}
		$item = $this->db->query($sql)->list_array();
		return empty($item)?false:true;
	}

	/**
	*添加目录信息
	*/
	public function insert($param = array(),$returnid = false) {
		$setarr = array ();
		if(empty($param['catalogname']))
			return false;
		if (!empty($param['pid'])) {
			$setarr['pid'] = intval($param['pid']);
			$upitem = $this->getcatalogbyid($param['pid']);
			if(!empty($upitem)) {
				$setarr['level'] = $upitem['level'] + 1;
				$setarr['catalogpath'] = $upitem['catalogpath'];
			}
		}
		if (! empty( $param['catalogname'] )) {
			$setarr['catalogname'] =  $param['catalogname'] ;
		}
		if (! empty( $param['crid'] )) {
			$setarr['crid'] =  intval($param['crid']) ;
		}
		if (! empty( $param['uid'] )) {
			$setarr['uid'] =  intval($param['uid']) ;
		}
		if (!empty($param['displayorder'])){
			$setarr['displayorder'] =  intval($param['displayorder']) ;
		}
		$catalogid = $this->db->insert('ebh_schcatalogs', $setarr);

		if($catalogid) {
			$this->fixcatalogpath($catalogid);
		}
		return $catalogid;
	}

	/**
	*更新目录信息
	*/
	function update($param,$catalogid) {
		$setarr = array ();
		if (!empty( $param['catalogname'] )) {
			$setarr['catalogname'] =  $param['catalogname'] ;
		}
		if (!empty($param['crid'])){
			$setarr['crid'] =  intval($param['crid']) ;
		}
		if (!empty( $param['uid'])) {
			$setarr['uid'] =  intval($param['uid']) ;
		}
		if (isset($param['pid'])){
			$setarr['pid'] =  intval($param['pid']) ;
		}
		if (! empty ( $param['level'] )) {
			$setarr['level'] =  intval($param['level']) ;
		}
		if (!empty ($param['catalogpath'])){
			$setarr['catalogpath'] =  $param['catalogpath'] ;
		}
		if (!empty ($param['displayorder'])){
			$setarr['displayorder'] =  intval($param['displayorder']) ;
		}
		if(empty($setarr) || empty($catalogid))
			return false;
		$wherearr = array('catalogid'=>$catalogid);
		$result = $this->db->update('ebh_schcatalogs',$setarr,$wherearr);
		if(empty($param['catalogpath'])){
			$catalogpath = $this->fixcatalogpath($catalogid);
		}
		$curcatalog = $this->getcatalogbyid($catalogid);
		if(!empty($curcatalog)){
			$this->_updatechildren($curcatalog['catalogid'],$curcatalog['level'],$curcatalog['catalogpath']);
		}
		return $result;
	}

	/**
	*获取目录信息
	*/
	public function getcatalogbyid($catalogid) {
		if(empty($catalogid))
			return false;
		$sql = 'select c.* from ebh_schcatalogs c where c.catalogid='.$catalogid;
		return $this->db->query($sql)->row_array();
	}
	/**
	*根据catalogid删除目录
	*/
	public function delete_byid($catalogid) {
		$sql = 'select catalogid from ebh_schcatalogs where pid='.$catalogid;
		$children = $this->db->query($sql)->list_array();
		if(!empty($children)) {	//不能删除有子集的目录
			return -1;
		}
		$where = array('catalogid'=>$catalogid);
		$this->db->delete('ebh_schcatalogs', $where);
		$this->db->delete('ebh_schcatalogfolders', $where);
		return 1;
	}

	//根据目录id批量将其排序加1
	function incorder($catalogidArr){
		$wherearr = ' catalogid in ('.implode(',', $catalogidArr).')';
        $setarr = array('displayorder' => 'displayorder+1');
        $afrows = $this->db->update('ebh_schcatalogs', array(), $wherearr, $setarr);
        return $afrows;
	}

	/**
	 *递归升级子目录的level和catalogpath
	 *$pid 父级id
	 *$level 父级level
	 *$catalogpath 父级catalogpath
	 */
	private function _updatechildren($pid = 0,$level = 0,$catalogpath = ''){
		$sql = 'select catalogid from ebh_schcatalogs where pid = '.$pid;
		$children = $this->db->query($sql)->list_array();
		if(empty($children)){
			return;
		}
		foreach ($children as $child) {
			$this->db->update('ebh_schcatalogs', array('level'=>$level+1,'catalogpath'=>$catalogpath.'/'.$child['catalogid']), array('catalogid'=>$child['catalogid']));
			$this->_updatechildren($child['catalogid'],$level+1,$catalogpath.'/'.$child['catalogid']);
		}
	}

	//根据catalogid递归获取正确的catalogpath
	private function _fixcatalogpath($catalogid = 0){
		$path = '';
		$curcatalog = $this->getcatalogbyid($catalogid);
		//获取父节点
		$pcatalog = $this->getcatalogbyid($curcatalog['pid']);
		if(!empty($pcatalog)){
			$path = $this->_fixcatalogpath($pcatalog['catalogid']).$path;
		}
		if(empty($catalogid)){
			$catalogid = '';
		}
		return $path.'/'.$catalogid;
	}
	//根据catalogip修正catalogpath
	public function fixcatalogpath($catalogid = 0){
		if(empty($catalogid)){
			return;
		}
		$catalogpath = $this->_fixcatalogpath($catalogid);
		$level = substr_count($catalogpath,'/');
		$setarr = array(
			'catalogpath'=>$catalogpath,
			'level'=>$level
		);
		$wherearr = array(
			'catalogid'=>$catalogid
		);
		return $this->db->update('ebh_schcatalogs',$setarr,$wherearr);
	}

	/**
	 * 选择课程
	 */
	public function choosecourse($param){

		if(!empty($param['catalogid'])){
			$wherearr['catalogid'] = $param['catalogid'];
			//return $wherearr;
			$this->db->delete('ebh_schcatalogfolders',$wherearr);
		}

		if (!empty($param['folderids']))
		{
			$sql = 'INSERT INTO ebh_schcatalogfolders (catalogid,folderid,crid) VALUES ';
			$folderidarr = explode(',',$param['folderids']);
			foreach($folderidarr as $folderid){
				$sql .= '(' . $param['catalogid'] . ',' . $folderid . ',' . $param['crid'] . '),';
			}
			$sql = rtrim($sql, ',');

			return $this->db->query($sql);
		}
	}

	/**
	 * 获取目录关联的课程
	 * @param  array $param  参数包含crid和catalogid
	 * @return mix            目录列表
	 */
	public function getcatalogcourses($param) {
		$wherearr = array();
		if (empty($param['crid']))
			return false;
		else
			$wherearr[] = 'cf.crid=' . intval($param['crid']);
		if (!empty($param['catalogid']))
			$wherearr[] = 'cf.catalogid=' . intval($param['catalogid']);

		$sql = 'SELECT cf.catalogid,cf.folderid,f.foldername FROM ebh_schcatalogfolders cf LEFT JOIN ebh_folders f ON cf.folderid=f.folderid';
		if(!empty($wherearr))
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);

		return $this->db->query($sql)->list_array();
	}

	public function delcourse($catalogid, $folderid) {
		if (empty($catalogid) || empty($folderid))
		{
			return false;
		}
		$wherearr['catalogid'] = $catalogid;
		$wherearr['folderid'] = $folderid;
		$this->db->delete('ebh_schcatalogfolders', $wherearr);
	}

	/**
	*更新目录名称
	*/
	function editname($param,$catalogid) {
		$setarr = array ();
		if (isset( $param['catalogname'] )) {
			$setarr['catalogname'] =  $param['catalogname'] ;
		}
		if (!empty ($param['uid'])){
			$setarr['uid'] =  intval($param['uid']) ;
		}
		if(empty($setarr) || empty($catalogid))
			return FALSE;
		$wherearr = array();
		$wherearr['catalogid'] = $catalogid;
		$wherearr['crid'] = $param['crid'];
		$result = $this->db->update('ebh_schcatalogs',$setarr,$wherearr);
		return $result;
	}
}