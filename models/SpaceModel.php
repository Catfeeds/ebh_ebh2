<?php
/*
原创空间
*/
class SpaceModel extends CModel{
	/*
	原创列表
	@param array $param
	@return array
	*/
	public function getspacelist($param){
		$sql = 'select uu.id,uu.title,u.username,uu.ispublic,uu.score,uu.votenum,uu.reviewnum,uu.top,uu.best,uu.hot,uu.dateline,uu.displayorder,uu.image,uu.title
			from ebh_useruploads uu 
			join ebh_users u on uu.uid = u.uid ';
		if(!empty($param['uid']))
			$wherearr[] = 'u.uid = '.$param['uid'];
		if(!empty($param['username']))
			$wherearr[]= 'u.username like"%'.$param['username'].'%"';
		if(!empty($param['q']))
			$wherearr[] = ' ( uu.title like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(!empty($param['hot'])){
			$wherearr[] =' uu.hot='.intval($param['hot']);
		}
		if(!empty($param['top'])){
			$wherearr[] =' uu.top='.intval($param['top']);
		}
		if(!empty($param['best'])){
			$wherearr[] =' uu.best='.intval($param['best']);
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.=' order by uu.id desc';
		if(!empty($param['limit'])){
			$sql.= ' limit ' . $param['limit'];
		}else{
			$sql.=' limit 20 ';
		}
			
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
	}
	/*
	原创数量
	@param array $param
	@return int
	*/
	public function getspacecount($param){
		$sql = 'select count(*) count from ebh_useruploads uu join ebh_users u on uu.uid = u.uid';
		if(!empty($param['uid']))
			$wherearr[] = 'u.uid = '.$param['uid'];
		if(!empty($param['username']))
			$wherearr[]= 'u.username like"%'.$param['username'].'%"';
		if(!empty($param['q']))
			$wherearr[] = ' ( uu.title like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(!empty($param['hot'])){
			$wherearr[] =' uu.hot='.intval($param['hot']);
		}
		if(!empty($param['top'])){
			$wherearr[] =' uu.top='.intval($param['top']);
		}
		if(!empty($param['best'])){
			$wherearr[] =' uu.best='.intval($param['best']);
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	删除
	@param array $param
	@return bool
	*/
	public function deletespaceitem($param){
		if(!empty($param['uid']))
			$wherearr['uid'] = $param['uid'];
		$wherearr['id'] = $param['id'];
		return $this->db->delete('ebh_useruploads',$wherearr);
	}
	/*
	详情
	@param int $id
	@return array
	*/
	public function getspacedetail($id){
		$sql = 'select uu.id,uu.uid,uu.title,u.username,u.sex,u.face,uu.ispublic,uu.data,uu.image,uu.top,uu.best,uu.hot,uu.displayorder,uu.dateline
			from ebh_useruploads uu
			join ebh_users u on uu.uid = u.uid 
			where id='.$id;
		return $this->db->query($sql)->row_array();
	}
	/*
	详情(用于大厅原创空间的我要评论)
	*/
	public function getspacedetails($param){
		$sql = 'select uu.id,uu.title,u.username,u.sex,u.face,u.realname,uu.ispublic,uu.image,uu.top,uu.best,uu.hot,uu.displayorder,uu.dateline,uu.score,uu.good,uu.general,uu.bad,uu.votenum 
			from ebh_useruploads uu
			join ebh_users u on uu.uid = u.uid ';
		$wherearr = array();
		if (!empty($param['id'])) {
			$wherearr[] = 'uu.id = '.$param['id']; 
		}
		if (!empty($param['ispublic'])) {
			$wherearr[] = 'uu.ispublic = '.$param['ispublic']; 
		}
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY id desc';
        }

		return $this->db->query($sql)->row_array();
	}
	/*
	编辑
	@param array $param
	@return int
	*/
	public function editspace($param){
		if(isset($param['title']))
			$setarr['title'] = $param['title'];
		if(isset($param['top']))
			$setarr['top'] = $param['top'];
		if(isset($param['hot']))
			$setarr['hot'] = $param['hot'];
		if(isset($param['best']))
			$setarr['best'] = $param['best'];
		if(isset($param['displayorder']))
			$setarr['displayorder'] = $param['displayorder'];
		if(isset($param['ispublic']))
			$setarr['ispublic'] = $param['ispublic'];
		if(isset($param['score']))
			$setarr['score'] = $param['score'];
		if(isset($param['votenum']))
			$setarr['votenum'] = $param['votenum'];
		if(isset($param['reviewnum']))
			$setarr['reviewnum'] = $param['reviewnum'];
		if(isset($param['good']))
			$setarr['good'] = $param['good'];
		if(isset($param['general']))
			$setarr['general'] = $param['general'];
		if(isset($param['bad']))
			$setarr['bad'] = $param['bad'];
		if(empty($param['id']))
			return FALSE;
		if(empty($setarr))
			return FALSE;
		$wherearr = array('id'=>$param['id']);
		$result = $this->db->update('ebh_useruploads',$setarr,$wherearr);
		return $result;
	}
	/**
     * 获取原创空间useruploads列表
     * @param array $param 条件参数
     * @return array spacelist
     */
    public function getuploadslist($param = array()) {
        $sql = 'SELECT up.*,u.username,u.sex,u.face,u.dateline,u.realname from ebh_useruploads up join ebh_users u on (up.uid = u.uid) ';
        $wherearr = array();
        if (!empty($param['id'])){
    		$wherearr[] = 'id = '.$param['id']; 
    	}
    	if (!empty($param['uid'])){
    		$wherearr[] = 'u.uid = '.$param['uid']; 
    	}
    	if (!empty($param['catid'])){
    		$wherearr[] = 'catid = '.$param['catid']; 
    	}
		if (isset($param['ispublic'])){
    		$wherearr[] = 'ispublic = '.$param['ispublic']; 
    	}
//    	if (!empty($param['title'])){
//    		$wherearr[] = 'title like  \'%'.$param['title'].'%\''; 
//    	}
    	if (!empty($param['q'])){
    		$wherearr[] = '(title like  \'%'.$this->db->escape_str($param['q']).'%\' or username like  \'%'.$this->db->escape_str($param['q']).'%\' )'; 
    	}
    	if (!empty($param['uidlist'])){	//用户编号的组合，如 10029,10030
    		$wherearr[] = 'uid in  ('.$param['uidlist'].')'; 
    	}
    	if (!empty($param['username'])){
    		$wherearr[] = 'username like  \'%'.$param['username'].'%\''; 
    	}
    	if (!empty($param['best'])) {
			$wherearr[] = 'best = '.$param['best']; 
		}
		if (!empty($param['hot'])) {
			$wherearr[] = 'hot = '.$param['hot']; 
		}
		if (!empty($param['top'])) {
			$wherearr[] = 'top = '.$param['top']; 
		}
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
          //  $sql .= ' ORDER BY up.displayorder';
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
        return $this->db->query($sql)->list_array();
    }
	/**
     * 获取原创空间useruploads列表
     * @param array $param 条件参数
     * @return array spacelist
     */
    public function getuploadslistcount($param = array()) {
		$count = 0;
        $sql = 'SELECT count(*) count from ebh_useruploads up join ebh_users u on (up.uid = u.uid) ';
        $wherearr = array();
        if (!empty($param['id'])){
    		$wherearr[] = 'id = '.$param['id']; 
    	}
    	if (!empty($param['uid'])){
    		$wherearr[] = 'u.uid = '.$param['uid']; 
    	}
    	if (!empty($param['catid'])){
    		$wherearr[] = 'catid = '.$param['catid']; 
    	}
		if (isset($param['ispublic'])){
    		$wherearr[] = 'ispublic = '.$param['ispublic']; 
    	}
//    	if (!empty($param['title'])){
//    		$wherearr[] = 'title like  \'%'.$param['title'].'%\''; 
//    	}
    	if (!empty($param['q'])){
    		$wherearr[] = '(title like  \'%'.$this->db->escape_str($param['q']).'%\' or username like  \'%'.$this->db->escape_str($param['q']).'%\' )'; 
    	}
    	if (!empty($param['uidlist'])){	//用户编号的组合，如 10029,10030
    		$wherearr[] = 'uid in  ('.$param['uidlist'].')'; 
    	}
    	if (!empty($param['username'])){
    		$wherearr[] = 'username like  \'%'.$param['username'].'%\''; 
    	}
    	if (!empty($param['best'])) {
			$wherearr[] = 'best = '.$param['best']; 
		}
		if (!empty($param['hot'])) {
			$wherearr[] = 'hot = '.$param['hot']; 
		}
		if (!empty($param['top'])) {
			$wherearr[] = 'top = '.$param['top']; 
		}
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        $countrow = $this->db->query($sql)->row_array();
		if(!empty($countrow))
			$count = $countrow['count'];
        return $count;
    }


	/**
	 *简单的删除方法
	 *@author zkq
	 *@param array $where 或者 String $where
	 *@return bool
	 */
	public function _delete($where=null){
		if(empty($where)){
			return false;
		}
		if($this->db->delete('ebh_useruploads',$where)>0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 *简单的修改方法
	 *@author zkq
	 *@param array $param
	 *@param array $where 或者 String $where
	 *@return bool
	 */
	public function _update($param=array(),$where=null){
		if(empty($where)||empty($param)){
			return false;
		}
		if($this->db->update('ebh_useruploads',$param,$where)>0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 *简单的执行方法
	 *@author zkq
	 *@param String $sql
	 *@return bool
	 */
	public function _query($sql){
		$sql = $this->db->escape_str($sql);
		if($this->db->query($sql)===false){
			return false;
		}else{
			return true;
		}
	}
	/**
	*根据原创编号获取原创简单信息
	*@param int id 原创编号
	*/
	public function getSimpleById($id) {
		$sql = "select u.score,u.reviewnum,u.votenum,u.good,u.general,u.bad from ebh_useruploads u where u.id=$id";
		return $this->db->query($sql)->row_array();
	}
	/**
	 * 获取原创投票后新添加的分值
	 * $vote string  评论类型(1.good 很好,2.general 一般,3.bad 很差)
	 * $oldscore decima 原来得分
	 * @return 返回添加的得分
	 */    
    public function getNewAddScore($vote,$oldscore){
    	if($vote=='good'){
    		$fraction = 1;
    	}elseif($vote=='general'){
    		$fraction = 0.7;
    	}else{
    		$fraction = 0.3;
    	}
    	$result = '';
    	if($oldscore>=6 && $oldscore<7){
    		$result = $fraction/10;
    	}elseif($oldscore>=7 && $oldscore<8){
    		$result = $fraction/20;
    	}elseif($oldscore>=8 && $oldscore<9){
    		$result = $fraction/70;
    	}elseif($oldscore>=9 && $oldscore<=10){
    		$result = $fraction/100;
    	}
    	return $result;
    }
}
?>