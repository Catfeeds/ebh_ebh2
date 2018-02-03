<?php
/*
roommodule数据更新
*/
class Temp_roommoduleModel extends CModel{
    /**
     * 获取网校权限列表
     */
    public function getList($param=array()){
        $sql = 'select r.moduleid,r.crid,a.modulename_t,r.available,r.tors,a.system from ebh_roommodules r
			join ebh_appmodules a on r.moduleid=a.moduleid';
        return $this->db->query($sql)->list_array();
    }
	public function _insert($param){
		
		$moduledisplay = array(
			'1'=>1,//主页
			'2'=>2,//授课
			'3'=>3,//作业
			'5'=>4,//答疑
			'16'=>5,//题库
			'18'=>6,//数据中心
			'6'=>7 //空间
			
		);
		$sql = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder,tors) values ';
		foreach($param as $k=>$module){
			$crid = $module['crid'];
			$moduleid = $module['moduleid'];
			$nickname = '';
			$available = $module['system']?1:$module['available'];
			$displayorder = empty($moduledisplay[$moduleid])?(100+$k):$moduledisplay[$moduleid];
			$tors = 1;
			$sql.= "($crid,$moduleid,'$nickname',$available,$displayorder,$tors),";
			
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}
	/*
	增加,改动为系统模块
	*/
	public function addsystem($moduleid){
		$sql = 'select crid,max(displayorder) displayorder from ebh_roommodules group by crid';
		$crlist = $this->db->query($sql)->list_array();
		
		$sql = 'select crid from ebh_roommodules where moduleid='.$moduleid;
		$notaddlist = $this->db->query($sql)->list_array();
		foreach($notaddlist as $cr){
			$notaddarr[$cr['crid']] = 1;
		}
		
		$sql = 'insert into ebh_roommodules (crid,moduleid,nickname,available,displayorder,tors) values ';
		foreach($crlist as $cr){
			if(empty($notaddarr[$cr['crid']])){
				$crid = $cr['crid'];
				
				$nickname = '';
				$available = 1;
				$displayorder = $cr['displayorder']+1;
				$sql.= "($crid,$moduleid,'$nickname',$available,$displayorder,0),";
				$sql.= "($crid,$moduleid,'$nickname',$available,$displayorder,1),";
			}
		}
		$sql = rtrim($sql,',');
		// var_dump();
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
    
}
?>