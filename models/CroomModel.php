<?php
/*
地区后台相关
*/
class CroomModel extends CModel{
	/**
	*统计本平台下所管理的学校的总信息
	*/
	public function getAllroonInfo($param){
		$returnarr = array('crnum'=>0,'teanum'=>0,'stunum'=>0,'coursenum'=>0,'examnum'=>0,'asknum'=>0);
		$sql = 'SELECT cr.crid,cr.teanum,cr.stunum,cr.coursenum from ebh_classrooms cr';
		if(!empty($param['filtercrid']))
			$wherearr[] = 'crid <> '.$param['filtercrid'];
		if(!empty($param['filtercontrol']))
			$wherearr[] = 'isschool <> 5';
		if(!empty($param['citycode']))
			$wherearr[] = 'citycode like \''.$param['citycode'].'%\'';
		if(empty($wherearr)) {
			return $returnarr;
		}
		$sql.= ' where '.implode(' AND ',$wherearr);
		
		$crlist = '';
		$allroomlist = $this->db->query($sql)->list_array();
		foreach($allroomlist as $al){
			if(empty($crlist))
				$crlist = $al['crid'];
			else
				$crlist .= ',' . $al['crid'];
			$returnarr['crnum'] ++;
			$returnarr['teanum'] = $returnarr['teanum'] + $al['teanum'];
			$returnarr['stunum'] = $returnarr['stunum'] + $al['stunum'];
			$returnarr['coursenum'] = $returnarr['coursenum'] + $al['coursenum'];
		}
		
		if(!empty($crlist)) {
			//求所有学校作业数
			$examsql = 'select count(*) examnum from ebh_schexams where crid in (' . $crlist . ') ';
			$examinfo = $this->db->query($examsql)->row_array();
			if(!empty($examinfo))
				$returnarr['examnum'] = $examinfo['examnum'];
			//求所有学校答疑提问数
			$asksql = 'select count(*) asknum from ebh_askquestions where crid in (' . $crlist .')';
			$askinfo = $this->db->query($asksql)->row_array();
			if(!empty($askinfo))
				$returnarr['asknum'] = $askinfo['asknum'];
		}
		return $returnarr;
	}
	/**
	*根据条件获取城市列表
	*/
	public function getCityList($param){
		$returnarr = array();
		$sql = 'select citycode,cityname from ebh_cities';
		$wherearr = array();
		if(!empty($param['citycode']))
			$wherearr[] = 'citycode=\''.$param['citycode'].'\'';
		if(!empty($param['upcode'])) {
			$uplen = strlen($param['upcode']);
			$curlen = $uplen + 2;
			$wherearr[] = '(citycode like \''.$param['upcode'].'%\' and length(citycode)='.$curlen.')';
		}
		if(empty($wherearr))
			return $returnarr;
		$sql.= ' where '.implode(' and ',$wherearr).' order by citycode asc';
		$returnarr = $this->db->query($sql)->list_array();
		
		return $returnarr;
	}
	
	/**
	*获取所在地区内教室列表
	*/
	public function getClassRoomList($param = array()) {
		global $_SGLOBAL, $_SC, $_SGET;
		$sqlarr = $wherearr = array(); $returnarr = array();
		$sqlarr ['select'] = 'SELECT cr.crid,cr.crname,cr.cface,cr.summary,cr.teanum,cr.stunum,cr.coursenum,cr.domain';
		$sqlarr ['from'] = 'FROM ebh_classrooms cr';
		if(!empty($param['filtercrid']))
			$wherearr[] = 'crid <> '.$param['filtercrid'];
		if(!empty($param['filtercontrol']))
			$wherearr[] = 'isschool <> 5';
		if(!empty($param['citycode']))
			$wherearr[] = 'citycode like \''.$param['citycode'].'%\'';
		if(!empty($param['q']))
			$wherearr[] = 'crname like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(empty($wherearr)) {
			return $returnarr;
		}
		$sqlarr ['where'] = ' WHERE ' . implode ( ' AND ', $wherearr );
		$sqlarr ['order'] = 'ORDER BY ' . (!empty($param ['order'])?$param['order'] : 'cr.crid desc ');
		if(!empty($param['limit']))
			$sqlarr['limit'] = ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sqlarr['limit'] = ' limit ' . $start . ',' . $pagesize;
		}
		$sqlstring = implode (' ',$sqlarr);
		// $listcount = 1;
		
		// if($listcount){
			$listarr = $this->db->query($sqlstring)->list_array();
		// }
		$crlist = '';
		$crarray = array();
		foreach($listarr as $la){
		// while($la = $_SGLOBAL['db']->fetch_array($listarr)) {
			$la['examnum'] = 0;
			$la['asknum'] = 0;
			$crarray[$la['crid']] = $la;
			if(empty($crlist))
				$crlist = $la['crid'];
			else
				$crlist .= ',' . $la['crid'];
		}
		if(!empty($crlist)) {
			//求学校作业数
			$examsql = 'select crid,count(*) examnum from ebh_schexams where crid in (' . $crlist . ') group by crid ';
			
			$examlist = $this->db->query($examsql)->list_array();
			foreach($examlist as $el){
			// while($examrow = $_SGLOBAL['db']->fetch_array($examquery)) {
				if(!empty($crarray[$el['crid']]))
					$crarray[$el['crid']]['examnum'] = $el['examnum'];
			}
			//求学校答疑提问数
			$asksql = 'select crid,count(*) asknum from ebh_askquestions where crid in (' . $crlist .') group by crid ';
			$asklist = $this->db->query($asksql)->list_array();
			foreach($asklist as $al){
			// while($askrow = $_SGLOBAL['db']->fetch_array($askquery)) {
				if(!empty($crarray[$al['crid']]))
					$crarray[$al['crid']]['asknum'] = $al['asknum'];
			}
			foreach($crarray as $cr) {
				$returnarr[] = $cr;
			}
		}
		return $returnarr;
	}
	/*
	所在地区教室数量
	*/
	public function getClassroomCount($param){
		$wherearr = array();
		$sqlarr ['from'] = 'FROM ebh_classrooms cr';
		if(!empty($param['filtercrid']))
			$wherearr[] = 'crid <> '.$param['filtercrid'];
		if(!empty($param['filtercontrol']))
			$wherearr[] = 'isschool <> 5';
		if(!empty($param['citycode']))
			$wherearr[] = 'citycode like \''.$param['citycode'].'%\'';
		if(!empty($param['q']))
			$wherearr[] = 'crname like \'%'.$this->db->escape_str($param['q']).'%\'';
		$sqlarr ['where'] = ' WHERE ' . implode ( ' AND ', $wherearr );
		$sql = 'SELECT COUNT(*) count ' . $sqlarr ['from'] . $sqlarr ['where'];
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
}
?>