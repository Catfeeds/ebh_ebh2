<?php
/*
帮助
*/
class HelpModel extends CModel{
	/*
	帮助列表
	@param array $param
	@return array
	*/
	public function gethelplist($param){
		$sql = 'select i.itemid,i.subject,i.dateline,i.best,i.hot,i.top,c.name,i.note from ebh_items i , ebh_categories c ';
		$wherearr[] = ' i.catid=c.catid and c.type=\'news\' and i.catid in (691,692,693,694,695,789,790,791,792,793,794,795,796,797,798,799,800,801,802,804,805,806,807,808,809,810,861,862,863,864,883,884,931,932,811,812,813,814,815,816,817,818,819,820,821,822,823,824,825,826,827,836,828,837,829,838,830,839)';
		if(!empty($param['q']))
			$wherearr[] = ' (i.subject like \'%'. $this->db->escape_str($param['q']) .'%\' or c.name like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(!empty($param['catid'])) {
            $wherearr[] = 'i.catid='.$param['catid'];
        }
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$sql.=' order by itemid desc';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
	}
	/*
	帮助数量
	@param array $param
	@return int
	*/
	public function gethelpcount($param){
		$sql = 'select count(*) count from ebh_items i , ebh_categories c ';
		$wherearr[] = ' i.catid=c.catid and c.type=\'news\' and i.catid in (691,692,693,694,695,789,790,791,792,793,794,795,796,797,798,799,800,801,802,804,805,806,807,808,809,810,861,862,863,864,883,884,931,932,811,812,813,814,815,816,817,818,819,820,821,822,823,824,825,826,827,836,828,837,829,838,830,839)';
		if(!empty($param['q']))
			$wherearr[] = ' (i.subject like \'%'. $this->db->escape_str($param['q']) .'%\' or c.name like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(!empty($param['catid'])) {
            $wherearr[] = 'i.catid='.$param['catid'];
        }
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		//var_dump($sql);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	帮助详情
	@itemid by id
	*/
	public function getitembyid($param){
		$sql = 'SELECT subject,message from ebh_items ';
		$wherearr = array();
        if (!empty($param['itemid']))
            $wherearr[] = 'itemid=' . $param['itemid'];
		if (!empty($param['catid']))
            $wherearr[] = 'catid=' . $param['catid'];
		if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
		return $this->db->query($sql)->row_array();
	}

}

?>