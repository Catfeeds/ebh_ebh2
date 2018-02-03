<?php
/**
 * 教室功能权限模块Model类RoompermissionModel
 * 主要用于获取教室所拥有的权限，如全科复习等
 */
class RoompermissionModel extends CModel{
    /**
     * 根据教室编号获取教室拥有的权限模块列表
     * @param int $crid教室编号
     * @return list
     */
    public function getModulesByCrid($crid) {
        $sql = "SELECT cr.crid,cr.crname from ebh_roompermissions rp join ebh_classrooms cr on (rp.moduleid=cr.crid) where rp.crid=$crid and rp.moduletype=1";
        return $this->db->query($sql)->list_array();
    }
	/**
     * 验证某教室是否对某个模块有权限
     * @param int $crid教室编号
	 * @param int $moduleid 模块编号
     * @return boolean TRUE表示有权限
     */
	public function checkmodule($crid,$moduleid) {
		$checkresult = FALSE;
		$sql = "SELECT COUNT(*) count FROM ebh_roompermissions rp WHERE rp.crid=$crid AND rp.moduleid=$moduleid";
		$row = $this->db->query($sql)->row_array();
		if(!empty($row) && $row['count']>0)
			$checkresult = TRUE;
		return $checkresult;
	}

}
