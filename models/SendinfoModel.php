<?php
/**
 * SendinfoModel���Ӧebh_sendinfo ��
 * Ŀǰ������У��ѧУ��������
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
	*���ݽ��ұ�Ż�ȡ���ҹ���
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
	*���ݽ��ұ�Ż�ȡ���ҹ����¼��
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
	*ɾ������
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
	*���ݱ�Ż�ȡ��������
	*@param int $infoid ������
	*/
	public function getSendById($infoid) {
		$sql = "SELECT s.infoid,s.toid,s.dateline,s.message FROM ebh_sendinfo s WHERE s.infoid=$infoid"; 
		return $this->db->query($sql)->row_array();
	}
	/**
	*���ɹ����¼
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
	*���ݱ�Ÿ��¹�����Ϣ
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