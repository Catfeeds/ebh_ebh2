<?php
	class TakemoneylogModel extends CModel{
		public function getList($param = array()){
			$sql = 'select t.takeid,t.money,t.status,t.applydateline,t.lockdateline,t.complatedateline,t.message,t.card,t.cardname,t.bankname,u.username,u.realname from ebh_takemoneylog t join ebh_users u on t.uid = u.uid ';
			$whereArr = array();
			if(isset($param['status'])&&$param['status']!='all'){
				$whereArr[] = ' t.status='.intval($param['status']);
			}
			if(!empty($param['keyname'])){
				$like = ' t.message like \'%'.$param['keyname'].'%\' ';
				$like.= 'or u.realname like \'%'.$param['keyname'].'%\' ';
				$like.= 'or t.card like \'%'.$param['keyname'].'%\' ';
				$like.= 'or u.username like \'%'.$param['keyname'].'%\' ';
				$whereArr[] = $like;
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ', $whereArr);
			}

			if(!empty($param['order'])){
				$sql.=' order by '.$param;
			}else{
				$sql.=' order by t.applydateline desc';
			}
			if(!empty($param['limit'])){
				$sql.=' limit '.$param['limit'];
			}else{
				$sql.=' limit 20 ';
			}
			$res = $this->db->query($sql)->list_array();
			return $res;
		}

		public function getCount($param = array()){
			$sql = 'select count(t.takeid) count from ebh_takemoneylog t join ebh_users u on t.uid = u.uid ';
			$whereArr = array();
			if(isset($param['status'])&&$param['status']!='all'){
				$whereArr[] = ' t.status='.intval($param['status']);
			}
			if(!empty($param['keyname'])){
				$like = ' t.message like \'%'.$param['keyname'].'%\' ';
				$like.= 'or u.realname like \'%'.$param['keyname'].'%\' ';
				$like.= 'or t.card like \'%'.$param['keyname'].'%\' ';
				$like.= 'or u.username like \'%'.$param['keyname'].'%\' ';
				$whereArr[] = $like;
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ', $whereArr);
			}
			$res = $this->db->query($sql)->row_array();
			if($res!==false){
				return $res['count'];
			}else{
				return 0;
			}
		}

		public function op($takeid=null,$status=null){
			if(is_null($takeid)||is_null($status)){
				return  0;
			}else{
				switch ($status) {
					case 1:
					case -1:
						return  $this->db->update('ebh_takemoneylog',array('status'=>$status,'lockdateline'=>time()),array('takeid'=>$takeid));
						break;
					case 2:
						return  $this->db->update('ebh_takemoneylog',array('status'=>$status,'complatedateline'=>time()),array('takeid'=>$takeid));
						break;
					default:
						return 0;
						break;
				}
				
			}
		}
	}
?>