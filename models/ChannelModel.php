<?php
	class ChannelModel extends CModel{
		public function getListCourseWare(){
			$sql = "select * from ebh_categories where type='courseware' and position = 1 order by displayorder asc";
			$query = $this->db->query($sql);
			if($query){
				return $query->list_array();
			}else{
				return false;
			}
			
		}

		public function getChannelByCatId($catid){
			$catid = intval($catid);
			$sql = 'select c.name from ebh_categories c where catid = '.$catid .' limit 1';
			$res = $this->db->query($sql)->row_array();
			if(is_array($res)){
				return $res['name'];
			}else{
				return false;
			}
		}
	}