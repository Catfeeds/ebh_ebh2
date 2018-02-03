<?php
class NewsModel extends CModel{
    /**
     * 资讯列表
     * @param $param 查询参数
     * @param string $path 父级路径
     * @return mixed
     */
	public function getnewslist($param, $path = ''){
		$sql = ' select itemid,subject,navcode,note,message,dateline,thumb,thumb_mobile,viewnum,status,attid,isinternal from ebh_news';
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if(isset($param['status']))
			$wherearr[] = 'status='.$param['status'];
		if(!empty($param['startdate']))
			$wherearr[] = 'dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[] = 'dateline<='.$param['enddate'];
		if (!empty($path)) {
		    $wherearr[] = 'navcode regexp \'^'.$path.'(s[0-9]+)?$\'';
		    $param['order'] = 'prank desc,itemid desc';
        } else if (!empty($param['navcode'])) {
            $wherearr[] = 'navcode=\'' . $param['navcode'] . '\'';
            if (preg_match('/^n\d+s\d+$/', $param['navcode'])) {
                $param['order'] = 'rank desc,itemid desc';
            } else {
                $param['order'] = 'prank desc,itemid desc';
            }
        }


        if (isset($param['q']) && $param['q'] != '') {
		    $wherearr[] = '`subject` like '.$this->db->escape('%'.$param['q'].'%');
        }

		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		
		
		$sql .= ' ORDER BY '.(empty($param['order']) ? 'itemid desc': $param['order']);
        
		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
		} else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
		// echo $sql;
		return $this->db->query($sql)->list_array();
	}
    /**
     * 资讯数量
     * @param $param 查询参数
     * @param string $path 父级路径
     * @return mixed
     */
	public function getnewscount($param, $path = ''){
		$sql = 'select count(*) count from ebh_news ';
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if(isset($param['status']))
			$wherearr[] = 'status='.$param['status'];
		if(!empty($param['startdate']))
			$wherearr[] = 'dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[] = 'dateline<='.$param['enddate'];
        if (empty($path)) {
            if(!empty($param['navcode']))
                $wherearr[] = 'navcode=\''.$param['navcode'].'\'';
        } else {
            $wherearr[] = 'navcode like \''.$path.'%\'';
        }
        if (isset($param['q']) && $param['q'] != '') {
            $wherearr[] = '`subject` like '.$this->db->escape('%'.$param['q'].'%');
        }
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	
	/*
	新增一个资讯
	*/
	public function _insert($param=array()){
		$param = $this->db->escape_str($param);
		$itemid = $this->db->insert('ebh_news',$param);
		if($itemid>0){
			return true;
		}else{
			return false;
		}
	}
	/*
	编辑一个资讯
	*/
	public function _update($param = array(),$where = array()){
		$param=$this->db->escape_str($param);
		$where = $this->db->escape_str($where);
		if(empty($param)||empty($where)){
			return false;
		}
		$afrows = $this->db->update('ebh_news', $param, $where);
		return $afrows;
	}
	
	/*
	删除一个资讯
	*/
	public function delById($itemid=null){
		if(!is_null($itemid)){
			if($this->db->delete('ebh_news','itemid='.intval($itemid))!==false){
				return true;
			}else{
				return false;
			}
		}

	}
	/*
	获取资讯详情
	*/
	public function getNewsDetail($param){
	    if (empty($param['itemid']) || empty($param['crid'])) {
	        return false;
        }
        $itemid = (int) $param['itemid'];
        $crid = (int) $param['crid'];
		$sql = "select itemid,navcode,subject,message,note,thumb,crid,uid,viewnum,dateline,status,displayorder,attid,isinternal from ebh_news where itemid=$itemid and crid=$crid";
		return $this->db->query($sql)->row_array();
	}
	
	/*
	增加人气
	*/
	public function addviewnum($itemid, $num = 1) {
        $where = 'itemid=' . $itemid;
        $setarr = array('viewnum' => 'viewnum+' . $num);
        $this->db->update('ebh_news', array(), $where, $setarr);
    }
	
}
?>