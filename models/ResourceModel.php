<?php
class ResourceModel extends CFreeResourceModel{
    /**
	 * 获取资源树
	 */
	public function getTreeList($version_id = 0, $tree_deep = 0, $parent_id = 0) {
		$tree_list = array();
		$sql = 'SELECT `tree_id`,`tree_type`,`version_id`,`name`,`tree_deep`,`has_child` FROM res_resourcetree';
		
		if(!empty($version_id))
		{
			$whereArr[] = 'version_id=' . intval($version_id);	
		}
		$tree_deep = (intval($tree_deep) > 0) ? $tree_deep : 0;
		$whereArr[] = 'tree_deep=' . intval($tree_deep);
		if(!empty($parent_id))
		{
			$whereArr[] = "tree_id like '" . $this->freeresourcedb->escape_str($parent_id) . "%'";
		}
		if(!empty($whereArr)){
			$sql .= ' WHERE ' . implode(' AND ',$whereArr);
		}
		$sql .= ' ORDER BY tree_id';
				
		$tree_list = $this->freeresourcedb->query($sql)->list_array();
		
		return $tree_list;
	}

	// 获取知识掌握列表
	public function getKnowledgelevelList() {
		$knowledgelevelList = array();
		$sql = 'SELECT `tree_id`,`name` FROM res_resourcetree WHERE tree_type=1 ORDER BY tree_id';
		$list_array = $this->freeresourcedb->query($sql)->list_array();
		foreach($list_array as $value)
		{
			$konwledgelevelList[$value['tree_id']] = $value['name'];
		}
		return $konwledgelevelList;
	}
	
	// 获取资源类型
	public function getRestypeList() {
		$restypeList = array();
		$sql = 'SELECT `tree_id`,`name` FROM res_resourcetree WHERE tree_type=2 ORDER BY tree_id';
		$list_array = $this->freeresourcedb->query($sql)->list_array();
		foreach($list_array as $value)
		{
			$restypeList[$value['tree_id']] = $value['name'];
		}
		return $restypeList;
	}
	
	/**
	 * 获取教材版本信息
	 */	
	public function getVersionList() {
        $sql = 'SELECT * FROM res_resourceversion';		
		return $this->freeresourcedb->query($sql)->list_array();
	}
	
	/**
	 * 根据versionid获取分类信息
	 */
	public function getOneByVersionid($version_id = -1){
		$sql = 'SELECT version_id,version_name,resource_count FROM res_resourceversion WHERE version_id =' . intval($version_id) . ' LIMIT 1';
		return $this->freeresourcedb->query($sql)->row_array();
	}
	
	/**
	 * 获得列表
	 */
	public function getList($param) {
	    $sql = 'SELECT resid, title, viewnum, downloadnum FROM res_resource';
		if(!empty($param['resversionid']))
		{
			$whereArr[] = 'resversionid=' . intval($param['resversionid']);
		}
		if(!empty($param['exttype']))
		{
			switch ($param['exttype'])
			{
				case 1:
				    $whereArr[] = "resfileext in ('ppt','PPT','pptx','PPTX')";
					break;
				case 2:
				    $whereArr[] = "resfileext in ('doc','DOC','docx','DOCX')";
					break;
				case 3:
				    $whereArr[] = "resfileext in ('swf','applet')";
					break;
				case 4:
				    $whereArr[] = "resfileext in ('jpg','gif','bmp','jpeg','png','JPG','GIF','BMP','JPEG','PNG')";
					break;
				case 5:
				    $whereArr[] = "resfileext in ('mp4','avi','mpg','mpeg','rmvb','asf','wmv','wma','flv','mp3','wav','wma','mid')";
					break;
				case 6:
				    $whereArr[] = "resfileext in ('txt','htm','html','pdf','PDF')";
					break;				
			}
		}
		if(!empty($param['ressubjectid']))
		{
			$whereArr[] = "ressubjectid like '" . $this->freeresourcedb->escape_str($param['ressubjectid']) . "%'";
			if(!empty($param['q'])){
				$whereArr[] = 'title like \'%' . $this->freeresourcedb->escape_str($param['q']).'%\'';
			}
		}
		if(!empty($whereArr)){
			$sql .= ' WHERE ' . implode(' AND ',$whereArr);
		}		
		$sql .= ' ORDER BY resid DESC';		
		if(!empty($param['limit'])){
			$sql .= ' LIMIT ' . $param['limit'];
		}

		return $this->freeresourcedb->query($sql)->list_array();
	}
	
	/**
	 * 通过缓存获取列表
	 */	 
	public function getListCached($param) {
		$list = array();
		$versionid = empty($param['resversionid']) ? 0 : $param['resversionid'];
		$subjectid = empty($param['ressubjectid']) ? 0 : $param['ressubjectid'];
		$exttype = empty($param['exttype']) ? 0 : intval($param['exttype']);
		$page = empty($param['page']) ? 0 : intval($param['page']);
		
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = $versionid . ':' . $subjectid . ':' . $exttype . ':' . $page;//key由“版本:学科:类型:页数”组成
		
		//搜索关键字为空时，从缓存读取。否则，从数据库查询。
		if (empty($param['q']))
		{
			$list = $redis->hget('resourcelist', $redis_key, true);
			if ($list === false)
			{
				$list = $this->getList($param);
				if ($list !== false)
				{
					$redis->hset('resourcelist', $redis_key, $list);//数组会自动序列化后保存
				}
			}
		}
		else
		{
			$list = $this->getList($param);
		}

		return $list;		
	}

	/**
	 * 获得记录总数
	 */	
	public function getListCount($param) {
	    $sql = 'SELECT count(*) AS count FROM res_resource';
		if(!empty($param['resversionid']))
		{
			$whereArr[] = 'resversionid=' . intval($param['resversionid']);
		}
		if(!empty($param['exttype']))
		{
			switch ($param['exttype'])
			{
				case 1:
				    $whereArr[] = "resfileext in ('ppt','PPT','pptx','PPTX')";
					break;
				case 2:
				    $whereArr[] = "resfileext in ('doc','DOC','docx','DOCX')";
					break;
				case 3:
				    $whereArr[] = "resfileext in ('swf','applet')";
					break;
				case 4:
				    $whereArr[] = "resfileext in ('jpg','gif','bmp','jpeg','png','JPG','GIF','BMP','JPEG','PNG')";
					break;
				case 5:
				    $whereArr[] = "resfileext in ('mp4','avi','mpg','mpeg','rmvb','asf','wmv','wma','flv','mp3','wav','wma','mid')";
					break;
				case 6:
				    $whereArr[] = "resfileext in ('txt','htm','html','pdf','PDF')";
					break;				
			}
		}
		if(!empty($param['ressubjectid']))
		{
			$whereArr[] = "ressubjectid like '" . $this->freeresourcedb->escape_str($param['ressubjectid']) . "%'";
			if(!empty($param['q'])){
				$whereArr[] = 'title like \'%' . $this->freeresourcedb->escape_str($param['q']).'%\'';
			}
		}
		if(!empty($whereArr)){
			$sql .= ' WHERE ' . implode(' AND ',$whereArr);
		}
		$row = $this->freeresourcedb->query($sql)->row_array();
		return $row['count'];		
	}
	
	/**
	 * 通过缓存获取记录总数
	 */	 
	public function getListCountCached($param) {
		$count = 0;
		$versionid = empty($param['resversionid']) ? 0 : $param['resversionid'];
		$subjectid = empty($param['ressubjectid']) ? 0 : $param['ressubjectid'];
		$exttype = empty($param['exttype']) ? 0 : intval($param['exttype']);
		
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = $versionid . ':' . $subjectid . ':' . $exttype;//key由“版本:学科:类型”组成
		
		//搜索关键字为空时，从缓存读取。否则，从数据库查询。
		if (empty($param['q']))
		{
			$count = $redis->hget('resourcelistcount', $redis_key);
			if ($count === false)
			{
				$count = $this->getListCount($param);
				if ($count !== false)
				{
					$redis->hset('resourcelistcount', $redis_key, $count);
				}
			}
		}
		else
		{
			$count = $this->getListCount($param);
		}
		return $count;		
	}


	//获取一条记录
	public function getOneByResid($resid) {
		$row = $this->freeresourcedb->query('SELECT * FROM res_resource WHERE resid=' . intval($resid))->row_array();
		return $row; 		
	}
	
	//更新浏览数
	public function setviewnum($resid, $num = 1) {
		$where = 'resid=' . $resid;
        $setarr = array('viewnum' => $num);
        $this->freeresourcedb->update('res_resource', array(), $where, $setarr);
	}
	
	//下载数加1
	public function incrDownloadNum($resid) {
		//从缓存获取下载计数
		$redis = Ebh::app()->getCache('cache_redis');
		$download_num = $redis->hget('resourcedownloadnum', $resid);
		if ($download_num !== false)
		{
			$redis->hIncrBy('resourcedownloadnum', $resid);			
			$download_num++;
			if ($download_num % 10 == 0)
			{
				$where = 'resid=' . intval($resid);
				$setarr = array('downloadnum' => $download_num);
				$this->freeresourcedb->update('res_resource', array(), $where, $setarr);
			}
		}
		else
		{
			//从数据库读取
			$resource = $this->freeresourcedb->query('SELECT downloadnum FROM res_resource WHERE resid=' . intval($resid))->row_array();
			if ($resource !== false)
			{
				$download_num = $resource['downloadnum'] + 1;
				$redis->hset('resourcedownloadnum', $resid, $download_num);
			}
			else
			{
				return false;
			}
		}
		
		return $download_num;
	}
	
	//获取缓存中的下载计数
	public function getDownloadNumCache($resid) {
		$redis = Ebh::app()->getCache('cache_redis');
		return $redis->hget('resourcedownloadnum', $resid);
	}

}