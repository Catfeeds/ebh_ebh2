<?php
	class SpecialModel extends CModel{
		public function getList($param=array()){
			$whereArr = array();
			$sql = 'select s.sid,s.title,s.catid,s.banner,s.thumb,s.description,s.seokeywords,s.navigation,s.urlrule,s.tplmain,s.tplhead,s.tplfoot,c.name from ebh_specials s left join ebh_categories c on s.catid = c.catid ';
			if(!empty($param['searchkey'])){
				$whereArr[] = 's.title like "%'.$param['searchkey'].'%"';
			}
			if(!empty($whereArr)){
				$sql.= ' WHERE '.implode('AND',$whereArr);
			}
			if(!empty($param['order'])){
				$sql.=' order by '.$param['order'];
			}else{
				$sql.=' order by sid desc ';
			}
			if(!empty($param['limit'])){
				$sql.=' limit '.$param['limit'];
			}			
			return $this->db->query($sql)->list_array();
			
		}

		public function getCount($param=array()){
			$whereArr = array();
			$sql = 'select count(*) count from ebh_specials s ';
			if(!empty($param['searchkey'])){
				$whereArr[] = 's.title like \'%'.$param['searchkey'].'%\'';
			}
			if(!empty($whereArr)){
				$sql.= ' WHERE '.implode('AND',$whereArr);
			}
			return $this->db->query($sql)->row_array();
		}

		public function getOneSpecialBySid($sid){
			$sql = 'select s.*,c.name from ebh_specials s join ebh_categories c on s.catid = c.catid where s.sid = '.intval($sid).' limit 1';
			return $this->db->query($sql)->row_array();
		}

		public function op($param=array()){
			$setArr = array();
			$setArr['title'] = empty($param['title'])?'':$param['title'];
			$setArr['catid'] = empty($param['catid'])?'':$param['catid'];
			$setArr['banner'] = empty($param['banner']['upfilepath'])?'':$param['banner']['upfilepath'];
			$setArr['thumb'] = empty($param['thumb']['upfilepath'])?'':$param['thumb']['upfilepath'];
			$setArr['description'] = empty($param['description'])?'':$param['description'];
			$navigation = array();
			if(!empty($param['subject'])){
				$navigation['subject']=$param['subject'];
			}
			if(!empty($param['address'])){
				$navigation['address']=$param['address'];
			}
			if(!empty($param['order'])){
				$navigation['order']=$param['order'];
			}
			if(!empty($navigation)){
				$setArr['navigation'] = serialize($navigation);
			}
			$setArr['seokeywords'] = empty($param['seokeywords'])?'':$param['seokeywords'];
			$setArr['urlrule'] = empty($param['urlrule'])?'':$param['urlrule'];
			$setArr['tplmain'] = empty($param['tplmain'])?'':$param['tplmain'];
			$setArr['tplhead'] = empty($param['tplhead'])?'':$param['tplhead'];
			$setArr['tplfoot'] = empty($param['tplfoot'])?'':$param['tplfoot'];
			if($param['op']=='add'){
				if($this->db->insert('ebh_specials',$setArr)===false){
					return false;
				}
			}else{
				if(intval($param['sid']>0)){
					if($this->db->update('ebh_specials',$setArr,array('sid'=>intval($param['sid'])))===false){
						return false;
					}
				}
			}
		}

		public function del($sid){
			if($this->db->delete('ebh_specials','sid='.intval($sid))!=-1){
				return true;
			}else{
				return false;
			}
		}
	}