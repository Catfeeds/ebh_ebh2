<?php
/**
 * 审核billchecksmodel类
 */
class BillchecksModel extends CModel{
	
	/**
	 * 检查课件是否属于该老师
	 */
	public function checkattachpermisson($attid,$uid){
		$sql = "select count(a.attid) count from ebh_attachments a left join ebh_billusers u on u.crid =a.crid where a.attid = $attid and u.uid = $uid ";
		$count  = $this->db->query($sql)->row_array();
		if(!empty($count)&&$count['count']>0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 检查附件是否属于该老师
	 */
	public function checkcoursewarepermisson($cwid,$uid){
		$sql = "select count(c.cwid) count from ebh_coursewares c left join ebh_roomcourses r on r.cwid = c.cwid left join ebh_billusers u on u.crid =r.crid  where c.cwid = $cwid and u.uid = $uid ";
		$count  = $this->db->query($sql)->row_array();
		if(!empty($count)&&$count['count']>0){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 审核处理
	 */
	public function check($param){
		$toid = $param['toid'];
		$role = $param['role'];
		$type = $param['type'];
		if(empty($toid)){return false;}

		//检查是否持存在
		$sql = "select count(*) as count from ebh_billchecks where toid = {$toid} and type = {$type}";
		$row = $this->db->query($sql)->row_array();

		if($row['count']>0){
			//更新
			if($role=='admin'){//管理员审核
				$setArr['admin_uid'] = $param['admin_uid'];
				$setArr['admin_status'] = $param['admin_status'];
				$setArr['admin_remark'] = htmlentities($param['admin_remark']);
				$setArr['admin_ip'] = $param['admin_ip'];
				$setArr['admin_dateline'] = SYSTIME;
			}elseif($role=='teach'){//教师审核
				$setArr['teach_uid'] = $param['teach_uid'];
				$setArr['teach_status'] = $param['teach_status'];
				$setArr['teach_remark'] = $param['teach_remark'];
				$setArr['teach_ip'] = $param['teach_ip'];
				$setArr['teach_dateline'] = SYSTIME;
			}

			$this->db->update("ebh_billchecks",$setArr,array('toid'=>$toid,'type'=>$type));
		}else{
			//添加
			if($role=='admin'){//管理员审核
				$data = array(
					'toid'=>$toid,
					'type'=>$type,
					'admin_uid'=>$param['admin_uid'],
					'admin_status'=>$param['admin_status'],
					'admin_remark'=>htmlentities($param['admin_remark']),
					'admin_ip'=>$param['admin_ip'],
					'admin_dateline'=>SYSTIME
				);
			}elseif($role=='teach'){//教师审核
				$data = array(
					'toid'=>$toid,
					'type'=>$type,
					'teach_uid'=>$param['teach_uid'],
					'teach_status'=>$param['teach_status'],
					'teach_remark'=>$param['teach_remark'],
					'teach_ip'=>$param['teach_ip'],
					'teach_dateline'=>SYSTIME
				);
			}

			$this->db->insert("ebh_billchecks",$data);
		}

		//修改课件状态
		if ($type == 1)
		{
			if($param['teach_status']==1 || $param['admin_status']==1){
				$this->db->update('ebh_coursewares', array('status'=>1), array('cwid'=>$toid));
			}
			elseif($param['teach_status']==2 || $param['admin_status']==2){
				$this->db->update('ebh_coursewares', array('status'=>-2), array('cwid'=>$toid));
			}
		}

		return true;
	}

	/*
	教师做出改动时,修改数据,比如编辑课件时,将teach_status改为0
	*/
	public function updateTeacher($param){
		if(empty($param['toid']) || empty($param['type']))
			exit;
		if(isset($param['teach_status']))
			$setArr['teach_status'] = $param['teach_status'];
		$whereArr['toid'] = $param['toid'];
		$whereArr['type'] = $param['type'];
		$this->db->update('ebh_billchecks',$setArr,$whereArr);
		
			
	}

	/**
	 * 获取审核详情
	 * @param  array $param 参数
	 * @return array        审核详情
	 */
	public function getCheckDetail($param){
		if (empty($param['toid']) || empty($param['type']))
			return false;
		$sql = 'SELECT teach_status,teach_remark,teach_dateline FROM ebh_billchecks WHERE toid=' . intval($param['toid']) . ' AND type=' . intval($param['type']);
		return $this->db->query($sql)->row_array();
	}

    /**
     * @param $bparam
     * 修改域名和解除绑定后，修改审核的状态
     */
	public function  editstatus($bparam){
        if (empty($bparam['crid']))
            return false;
        $whereArr['toid'] = $bparam['crid'];
        $whereArr['type'] = $bparam['type'];
        if(isset($bparam['admin_status'])){
            $setArr['admin_status'] = $bparam['admin_status'];
        }
        if(isset($bparam['admin_remark'])){
            $setArr['admin_remark'] = $bparam['admin_remark'];
        }
        if(isset($bparam['teach_status'])){
            $setArr['teach_status'] = $bparam['teach_status'];
        }
        if(isset($bparam['teach_remark'])){
            $setArr['teach_remark'] = $bparam['teach_remark'];
        }

         $this->db->update('ebh_billchecks',$setArr,$whereArr);
    }
//获取域名审核后的详情
    public function getdomainCheckDetail($param){
        if (empty($param['toid']) || empty($param['type']))
            return false;
        $sql = 'SELECT admin_status ,teach_status FROM ebh_billchecks WHERE toid=' . intval($param['toid']) . ' AND type=' . intval($param['type']);
        //print_r($sql);die;
        return $this->db->query($sql)->row_array();
    }
}
