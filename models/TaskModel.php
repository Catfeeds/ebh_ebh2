<?php
/*
任务
*/
class TaskModel extends CModel{
	/*
	获取任务列表
	@param array $param
	@return array
	*/
	public function gettasklist($param){
		$sql = 'select t.id,t.name,t.image,t.url,t.type,t.description,t.reward,t.displayorder,i.rulename from ebh_tasks t left join ebh_creditrules i on t.ruleid = i.ruleid';
		
		
		$sql.=' order by displayorder';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
		
	}
	/*
	获取任务总数
	@param array $param
	@return int
	*/
	public function gettaskcount($param){
		$sql = 'select count(*) count from ebh_tasks t ';
		
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	详情
	@param int $id
	@return array
	*/
	public function gettaskdetail($id){
		$sql = 'select * from ebh_tasks where id='.$id;
		return $this->db->query($sql)->row_array();
	}
	/*
	添加
	@param array $param
	@return int
	*/
	public function addtask($param){
		if(!empty($param['name']))
			$setarr['name']=$param['name'];
		if(!empty($param['image']))
			$setarr['image']=$param['image'];
		if(!empty($param['url']))
			$setarr['url']=$param['url'];
		if(!empty($param['description']))
			$setarr['description']=$param['description'];
		if(!empty($param['reward']))
			$setarr['reward']=$param['reward'];
		if(!empty($param['ruleid']))
			$setarr['ruleid']=$param['ruleid'];
		if(!empty($param['displayorder']))
			$setarr['displayorder']=$param['displayorder'];
		if(isset($param['type']))
			$setarr['type']=$param['type'];
		$res = $this->db->insert('ebh_tasks',$setarr);
		return $res;
	}
	/*
	删除
	@param int $id
	@return bool
	*/
	public function deletetask($id){
		$sql = 'delete t.* from ebh_tasks t where id='.$id;
		return $this->db->simple_query($sql);
	}
	/*
	编辑
	@param array $param
	@return int
	*/
	public function edittask($param){
		if(!empty($param['name']))
			$setarr['name']=$param['name'];
		if(!empty($param['image']))
			$setarr['image']=$param['image'];
		if(!empty($param['url']))
			$setarr['url']=$param['url'];
		if(!empty($param['description']))
			$setarr['description']=$param['description'];
		if(!empty($param['reward']))
			$setarr['reward']=$param['reward'];
		if(!empty($param['ruleid']))
			$setarr['ruleid']=$param['ruleid'];
		if(!empty($param['displayorder']))
			$setarr['displayorder']=$param['displayorder'];
		if(isset($param['type']))
			$setarr['type']=$param['type'];
		$wherearr = 'id='.$param['id'];
		return $this->db->update('ebh_tasks',$setarr,$wherearr);
	}
	
	/*
	会员的任务
	*/
	public function getmembertasklist(){
		$sql = 'select t.id,t.name,t.image,t.url,t.type,t.description,t.reward,t.displayorder,i.rulename from ebh_tasks t left join ebh_creditrules i on t.ruleid = i.ruleid';
		$wherearr[] = ' t.type>0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.=' order by displayorder';
		//echo $sql;
		return $this->db->query($sql)->list_array();
	}
	/*
	任务完成次数，用于判断任务是否完成、是否达到每天任务上限
	@param int $id 任务编号
	@param int $uid
	@return 积分表中会员关于该任务的记录数
	*/
	public function getactivecount($id,$uid){
		if($id == 5){
			$sql = 'select t.id,count(*) count from ebh_creditlogs c 
			left join ebh_tasks t on c.ruleid in (10,11)
			where t.id in ('.$id.') and c.toid = '.$uid;
		}else{
			$sql = 'select t.id,count(*) count from ebh_creditlogs c 
			left join ebh_tasks t on c.ruleid = t.ruleid
			where t.id in ('.$id.') and c.toid = '.$uid;
		}
		$sql.= ' group by t.id';
		// echo $sql;
		$count = $this->db->query($sql)->list_array();
		return $count;
	}
}
?>