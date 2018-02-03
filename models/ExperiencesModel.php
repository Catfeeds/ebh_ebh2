<?php
/**
 * 过往经历模型
 */
class ExperiencesModel extends CModel {


	/**
	 * 获取某个用户的经历列表
	 * @param  integer $uid 用户编号
	 * @return array      经历列表
	 */
	public function getList($uid)
	{
		if(empty($uid))
		{
			return false;
		}
		$sql = 'SELECT expid,begindate,enddate,description FROM ebh_experiences WHERE uid=' . intval($uid) . ' ORDER BY expid DESC';
		return $this->db->query($sql)->list_array();
	}

	/**
	 * 获取一条经历
	 * @param  integer $expid 经历编号
	 * @return array        经历详情
	 */
	public function getOne($expid)
	{
		$sql = 'SELECT * FROM ebh_experiences WHERE expid=' . intval($expid);
		return $this->db->query($sql)->row_array();
	}

	/**
	 * 添加经历
	 * @param  array $param
	 * @return integer        经历编号
	 */
	public function addExperience($param)
	{
		if(empty($param['uid']) || empty($param['begindate']) || empty($param['enddate']) || empty($param['description']))
		{
			return false;
		}

		$setarr = array();
		if (!empty($param['uid']))
		{
			$setarr['uid'] = $param['uid'];
		}
		if (!empty($param['begindate']))
		{
			$setarr['begindate'] = $param['begindate'];
		}
		if (!empty($param['enddate']))
		{
			$setarr['enddate'] = $param['enddate'];
		}
		if (!empty($param['description']))
		{
			$setarr['description'] = $param['description'];
		}
		$expid = $this->db->insert('ebh_experiences', $setarr);
		return $expid;
	}

	/**
	 * 编辑经历
	 * @param  array $param
	 * @return integer        经历编号
	 */
	public function editExperience($param)
	{
		if(empty($param['expid']))
		{
			return false;
		}

		$setarr = array();
		if (!empty($param['begindate']))
		{
			$setarr['begindate'] = $param['begindate'];
		}
		if (!empty($param['enddate']))
		{
			$setarr['enddate'] = $param['enddate'];
		}
		if (!empty($param['description']))
		{
			$setarr['description'] = $param['description'];
		}
		$wherearr = array('expid'=>$param['expid']);
		return $this->db->update('ebh_experiences',$setarr,$wherearr);
	}

	/**
	 * 删除经历
	 * @param  integer $expid 经历编号
	 * @return mix     影响记录数
	 */
	public function delExperience($expid){
		if(empty($expid))
		{
			return false;
		}
		return $this->db->delete('ebh_experiences','expid=' . intval($expid));
	}
}
?>