<?php
/**
 * 体质测试excel表信息model
 */
class ExcelsourcesModel extends CModel{
	/**
	 * 读取excel表信息
	 */
	public function getExcelByFid($fid){
		if(empty($fid)){
			return false;
		}
		$sql = 'select filepath,filesuffix from `ebh_excel_sources` where fid ='.intval($fid);
		return $this->db->query($sql)->row_array();
	}
}
?>