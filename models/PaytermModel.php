<?php
/*
服务期
*/
class PaytermModel extends CModel{
	public function getTermList($param){
		$sql = 'select t.tid,t.tname,t.status,t.tdisplayorder,t.dateline,cr.crname,t.crid from ebh_pay_terms t join ebh_classrooms cr on cr.crid=t.crid';
		
		if(isset($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(t.tname like \'%'.$q.'%\' or cr.domain like \'%'.$q.'%\' or cr.crname like \'%'.$q.'%\')';
		}
		if(!empty($param['crid'])) {
			$wherearr[] = 't.crid='.$param['crid'];
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order'])){
			$sql.= ' order by '.$param['order'];
		}else{
			$sql.= ' order by t.tid desc';
		}
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
		$termlist = $this->db->query($sql)->list_array();
		return $termlist;
	}
	
	public function getTermListCount($param){
		$sql = 'select count(*) count from ebh_pay_terms t join ebh_classrooms cr on cr.crid=t.crid';
		if(isset($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(t.tname like \'%'.$q.'%\' or cr.domain like \'%'.$q.'%\' or cr.crname like \'%'.$q.'%\')';
		}
		if(!empty($param['crid'])) {
			$wherearr[] = 't.crid='.$param['crid'];
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr); 
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	public function add($param){
		$sptarr['tname'] = $param['tname'];
		$sptarr['crid'] = $param['crid'];
		if(!empty($param['tsummary']))
			$sptarr['tsummary'] = $param['tsummary'];
		if(isset($param['tdisplayorder']))
			$sptarr['tdisplayorder'] = $param['tdisplayorder'];
		$sptarr['status'] = 1;
		$sptarr['dateline'] = SYSTIME;
		
		return $this->db->insert('ebh_pay_terms',$sptarr);
	}
	
	public function edit($param){
		if(empty($param['tid']))
			exit;
		if(!empty($param['tname']))
			$sptarr['tname'] = $param['tname'];
		if(!empty($param['crid']))
			$sptarr['crid'] = $param['crid'];
		if(isset($param['tsummary']))
			$sptarr['tsummary'] = $param['tsummary'];
		if(isset($param['tdisplayorder']))
			$sptarr['tdisplayorder'] = $param['tdisplayorder'];
		if(isset($param['status']))
			$sptarr['status'] = $param['status'];
		
		return $this->db->update('ebh_pay_terms',$sptarr,'tid='.$param['tid']);
	}
	
	public function getTermByTid($tid){
		$sql = 'select t.tid,t.tname,t.status,t.tdisplayorder,t.crid,cr.crname,t.tsummary,cr.summary from ebh_pay_terms t join ebh_classrooms cr on t.crid=cr.crid where t.tid='.$tid;
		return $this->db->query($sql)->row_array();
		
	}
	
	public function deleteterm($tid){
        $tid = (int) $tid;
        $ret = $this->db->query("SELECT `pid` FROM `ebh_pay_packages` WHERE `tid`=$tid")->row_array();
        if (empty($ret['pid'])) {
            return false;
        }
		return $this->db->delete('ebh_pay_terms','tid='.$tid);
	}
	
}