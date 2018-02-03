<?php
/**
 * 体质健康学年表
 */
	class SchoolyearModel extends CModel{
		/**
		 * 审核网校下某学年是否存在
		 */
		public function checkSchoolYear($crid,$syname){
			if(empty($crid) || empty($syname)){
				return false;
			}
			$sql = 'select `syid` from `ebh_school_year` where crid = '. intval($crid) .' and syname = '.$this->db->escape($syname);
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 添加学年信息
		 */
		public function addSchoolYear($crid,$syname){
			if(empty($crid) || empty($syname)){
				return false;
			}
			$param = array();
			$param['syname'] = $this->db->escape_str($syname);//防止sql注入
	        $param['crid'] = intval($crid);//防止sql注入
	        return $this->db->insert('ebh_school_year',$param);
		}
		/**
		 * 根据crid获取网校下对应的学年列表
		 */
		public function getSchoolYearList($crid){
			if(empty($crid)){
				return false;
			}
			$sql = 'select syid,syname,status from `ebh_school_year` where crid = '. intval($crid) .' order by syid';
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 根据syid将对应的学年状态改为1
		 */
		public function changeStatusBySyid($syid){
			if(empty($syid)){
				return false;
			}
			return $this->db->update('ebh_school_year',array('status'=>'1','dateline'=>SYSTIME),array('syid'=>intval($syid)));
		}
		/**
		 * 根据syid来确定对应的学年的状态码
		 */
		public function checkStatusBySyid($syid){
			if(empty($syid)){
				return false;
			}
			$sql = 'select status from `ebh_school_year` where syid ='. intval($syid) .' limit 0,1';
			return $this->db->query($sql)->row_array();
		}
		/**
		 * 获取前6个的学年
		 */
		public function getSchoolYearListByStr($str){
			if(empty($str)){
				return false;
			}
			$sql = 'select syname,syid from `ebh_school_year` where syid in('.$str.') and status = 1 order by dateline desc limit 6';
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 根据syid获取学年信息
		 */
		public function getSchoolYearInfoBySyid($syid){
			if(empty($syid)){
				return false;
			}
			$sql = 'select syname from `ebh_school_year` where syid ='.intval($syid);
			return $this->db->query($sql)->row_array();
		}
	}
?>