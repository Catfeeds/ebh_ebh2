<?php
/**
 * SendinfoModel类对应ebh_sendinfo 表
 * 目前用于网校和学校公告数据
 */
class SendinfoModel extends CModel{
	public function getsend($toid,$type){
		$sql = 'SELECT * FROM ebh_sendinfo ';
		$wherearr = array();
		if (!empty($toid)) {
            $wherearr[] = ' toid = '.$toid ;
        }
		if (!empty($type)) {
            $wherearr[] = ' type = \'' .$type .'\'';
        }
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        return $this->db->query($sql)->row_array();
	}
	/**
	*根据教室编号获取教室公告
	*/
	public function getSendList($param) {
		if(empty($param['crid']))
			return FALSE;
		$sql = 'SELECT s.infoid,s.toid,s.dateline,s.message FROM ebh_sendinfo s';
		$wherearr = array();
		$wherearr[] = 's.toid='.$param['crid'];
		$wherearr[] = 's.type=\'announcement\'';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' ORDER BY '.$param['order'];
		else
			$sql .= ' ORDER BY s.infoid DESC ';
		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
		} else {
			if (empty($queryarr['page']) || $queryarr['page'] < 1)
				$page = 1;
			else
				$page = $queryarr['page'];
			$pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据教室编号获取教室公告记录数
	*/
	public function getSendCount($param) {
		$count = 0;
		if(empty($param['crid']))
			return $count;
		$sql = 'SELECT count(*) count FROM ebh_sendinfo s';
		$wherearr = array();
		$wherearr[] = 's.toid='.$param['crid'];
		$wherearr[] = 's.type=\'announcement\'';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
	/**
	*删除公告
	*/
	public function del($param) {
		if(empty($param['infoid']) && empty($param['crid']))
			return FALSE;
		$wherearr = array();
		if(!empty($param['infoid']))
			$wherearr['infoid'] = $param['infoid'];
		if(!empty($param['crid']))
			$wherearr['toid'] = $param['crid'];
		return $this->db->delete('ebh_sendinfo',$wherearr);
	}
	/**
	*根据编号获取公告详情
	*@param int $infoid 公告编号
	*/
	public function getSendById($infoid) {
		$sql = "SELECT s.infoid,s.toid,s.dateline,s.message FROM ebh_sendinfo s WHERE s.infoid=$infoid"; 
		return $this->db->query($sql)->row_array();
	}
	/**
	*生成公告记录
	*/
	public function insert($param) {
		$setarr = array();
		if(!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
		if(!empty($param['crid']))
			$setarr['toid'] = $param['crid'];
		if(!empty($param['type']))
			$setarr['type'] = $param['type'];
		else 
			$setarr['type'] = 'announcement';
		$setarr['dateline'] = SYSTIME;
		if(!empty($param['message']))
			$setarr['message'] = $param['message'];
		$infoid = $this->db->insert('ebh_sendinfo',$setarr);
		return $infoid;
	}
	/**
	*根据编号更新公告信息
	*/
	public function update($param) {
		if(empty($param['infoid']))
			return FALSE;
		$wherearr = array('infoid'=>$param['infoid']);
		if(!empty($param['crid']))
			$wherearr['toid'] = $param['crid'];
		$setarr = array();
		if(!empty($param['message'])) {
			$setarr['message'] = $param['message'];
		}
		if(empty($setarr))
			return FALSE;
		$afrows = $this->db->update('ebh_sendinfo',$setarr,$wherearr);
	}
}
?>