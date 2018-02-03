<?php
/**
 * ItemModel类对应ebh_items 表
 */
class ItemModel extends CModel{
    /**
     * 获取item列表
     * @param array $param 条件参数
     * @return array itemlist
     */
    public function getitemlist($param = array()) {
        if(!empty($param['type'])&&$param['type']=='ad'){
            //广告分类则连接上ebh_ads表用于查询广告有效投放时间
           $sql = 'SELECT i.itemid,i.lastpost,i.catid,i.subject,i.attachment,i.thumb,i.dateline,i.fromurl,i.itemurl,i.note,i.displayorder,i.message,i.hot,i.best,i.top,i.channel,c.code,i.folder,i.source,c.name as fenlei,cc.name as pindao,a.begintime,a.endtime from ebh_items i '.
                'join ebh_categories c on (c.catid = i.catid) left join ebh_categories as cc on i.channel = cc.catid  join ebh_ads a on a.itemid = i.itemid ';
        }else{
             $sql = 'SELECT i.itemid,i.lastpost,i.catid,i.subject,i.message,i.attachment,i.thumb,i.dateline,i.fromurl,i.itemurl,i.note,i.displayorder,i.hot,i.best,i.top,i.channel,c.code,i.folder,i.source,c.name as fenlei,cc.name as pindao from ebh_items i '.'join ebh_categories c on (c.catid = i.catid) left join ebh_categories as cc on i.channel = cc.catid ';
        }
		
        $wherearr = array();
        if(!empty($param['in'])){
            $wherearr[] = $param['in'];
        }
        if(!empty($param['catid'])) {
            if(!is_array($param['catid'])){
                $wherearr[] = 'i.catid ='.$param['catid'];
            }else{
                $param['catid'] = '('.implode(',',$param['catid']).')';
                $wherearr[] = 'i.catid in '.$param['catid'];
            }
        }
        if(!empty($param['type'])) {
            $wherearr[] = 'c.type=\''.$param['type'].'\'';
        }
		if(!empty($param['crid'])) {
            $wherearr[] = 'i.crid='.$param['crid'];
        }
        if(!empty($param['channel'])) {
            $wherearr[] = 'i.channel like \'%'.$param['channel'].'%\'';
        }
        if(!empty($param['folder'])) {
            $wherearr[] = 'i.folder='.$param['folder'];
        }
        if(!empty($param['address_qu'])) {
            $wherearr[] = 'i.citycode=\''.$param['address_qu'].'\'';
        }elseif(!empty($param['address_shi'])){
            $wherearr[] = 'i.citycode=\''.$param['address_shi'].'\'';
         }elseif(!empty($param['address_sheng'])){
            $wherearr[] = 'i.citycode=\''.$param['address_sheng'].'\'';
        }
        if(!empty($param['begintime'])){
            $wherearr[]='a.begintime>'.$param['begintime'];
        }
        if(!empty($param['endtime'])){
            $wherearr[]='a.endtime<'.$param['endtime'];
        }
        if(!empty($param['crid'])) {
            $wherearr[] = 'i.crid='.$param['crid'];
        }
        if(!empty($param['best'])) {
            $wherearr[] = 'i.best='.$param['best'];
        }
		 //广告类型
    	if(!empty($param['code'])){
       		if($param['code'])
       		$wherearr[]= 'c.code =\'' .$param['code'].'\' ';
       	}

        if(!empty($param['top'])) {
            $wherearr[] = 'i.top='.$param['top'];
        }
        if(!empty($param['hot'])) {
            $wherearr[] = 'i.hot='.$param['hot'];
        }
        if(!empty($param['searchkey'])) {
            $wherearr[] = '(i.subject like \'%'.$this->db->escape_str($param['searchkey']).'%\''.'or i.message like \'%'.$this->db->escape_str($param['searchkey']).'%\')';
        }
        
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY i.displayorder';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        // echo $sql;exit;
        return $this->db->query($sql)->list_array();
    }

	public function gethotnews($params){
		$sql = 'SELECT i.itemid,i.catid,i.subject,i.dateline,i.citycode,i.displayorder,i.itemurl,c.name FROM ebh_items i,ebh_categories c ';
		$wherearr = array();
		 if (!empty($params['catid'])) {
            $wherearr[] = ' i.catid=c.catid and i.catid = ' . $params['catid']  ;
        }
		 if (!empty($params['hot'])) {
            $wherearr[] = ' i.hot in (' . $params['hot'] . ') ';
        }
		 if (!empty($params['citycode'])) {
        	$wherearr[] = 'i.citycode like \''.$params['citycode'].'%\'';
        }
		 if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($params['displayorder'])) {
            $sql .= ' ORDER BY '.$params['displayorder'];
        } else {
            $sql .= ' ORDER BY i.displayorder';
        }
        if(!empty($params['limit'])) {
            $sql .= ' limit '. $params['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
	}
	//帮助中心
//	public function helpviews($param){
//		$sql = 'SELECT i.subject,i.note,i.catid,i.hot,i.best,i.top,i.channel,c.name FROM ebh_2012.ebh_items i,ebh_2012.ebh_categories c WHERE i.catid=c.catid AND i.itemid=1438 AND i.catid=796 ORDER BY i.itemid desc LIMIT 0,1';
//		$wherearr = array();
//		return $this->db->query($sql)->list_array();
//	}

    //同上，用于获取total条数，用于分页显示
    public function getitemlistCount($param = array()) {
        if(!empty($param['type'])&&$param['type']=='ad'){
            $sql = 'SELECT count(*) count from ebh_items i '.'join ebh_categories c on (c.catid = i.catid) join ebh_ads a on i.itemid = a.itemid ';
        }else{
            $sql = 'SELECT count(*) count from ebh_items i '.'join ebh_categories c on (c.catid = i.catid) ';
        }
        
        $wherearr = array();
        if(!empty($param['in'])){
            $wherearr[] = $param['in'];
        }
        if(!empty($param['catid'])) {
            if(!is_array($param['catid'])){
                $wherearr[] = 'i.catid ='.$param['catid'];
            }else{
                $param['catid'] = '('.implode(',',$param['catid']).')';
                $wherearr[] = 'i.catid in '.$param['catid'];
            }
        }
        if(!empty($param['type'])) {
            $wherearr[] = 'c.type=\''.$param['type'].'\'';
        }
        if(!empty($param['channel'])) {
            $wherearr[] = 'i.channel like \'%'.$param['channel'].'%\'';
        }
        if(!empty($param['folder'])) {
            $wherearr[] = 'i.folder='.$param['folder'];
        }
        if(!empty($param['address_qu'])) {
            $wherearr[] = 'i.citycode=\''.$param['address_qu'].'\'';
        }elseif(!empty($param['address_shi'])){
            $wherearr[] = 'i.citycode=\''.$param['address_shi'].'\'';
         }elseif(!empty($param['address_sheng'])){
            $wherearr[] = 'i.citycode=\''.$param['address_sheng'].'\'';
        }
        if(!empty($param['begintime'])){
            $wherearr[]='a.begintime>'.strtotime($param['begintime']);
        }
        if(!empty($param['endtime'])){
            $wherearr[]='a.endtime<'.strtotime($param['endtime']);
        }
        if(!empty($param['crid'])) {
            $wherearr[] = 'i.crid='.$param['crid'];
        }
        if(!empty($param['best'])) {
            $wherearr[] = 'i.best='.$param['best'];
        }
        if(!empty($param['top'])) {
            $wherearr[] = 'i.top='.$param['top'];
        }
        if(!empty($param['hot'])) {
            $wherearr[] = 'i.hot='.$param['hot'];
        }
        if(!empty($param['searchkey'])) {
             $wherearr[] = 'i.subject like \'%'.$this->db->escape_str($param['searchkey']).'%\''.'or i.message like \'%'.$this->db->escape_str($param['searchkey']).'%\'';
        }
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }

        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }
    /**
     * 根据相关条件查询相关item信息;
     * @param int $itemid
     * @return array
     */
    public function getItemByItemid($itemid){
        $sql = 'select i.*,c.position,c.system,c.visible,c.opvalue,a.begintime,a.endtime,cr.crname from ebh_items i join ebh_categories c on i.catid = c.catid left join ebh_ads a on a.itemid = i.itemid left join ebh_classrooms cr on cr.crid = i.crid where i.itemid='.$itemid.' limit 1';
        return $this->db->query($sql)->row_array();

    }


    /**
     * item的增加编辑操作
     * @param arary $paramarr
     * @return bool
     */
    function op($paramarr = array())
    {   
        if (is_array($paramarr)) {
            $paramarr = safeHtml($paramarr,array('message'));
            if(empty($paramarr['subject'])){
                return false;
            }
            $setarr = array();
            if (intval($paramarr["category"])) {
                //TODO分类存不存在
                $setarr["catid"] = $paramarr["category"];
            } else {
                return false;
            }
            if (!empty($paramarr["subject"])) {
                $setarr["subject"] = myiconv($paramarr["subject"]);
            } else {
                return false;
            }
            if (intval($paramarr["uid"])) {
                //TODO判断用户存不存在
                $setarr["uid"] = $paramarr["uid"];
            } else {
                return false;
            }

            $setarr["displayorder"] = empty($paramarr["displayorder"]) ? 0 : intval($paramarr["displayorder"]);
            $setarr["subjectstyle"] = empty($paramarr["subjectstyle"]) ? "" : $paramarr["subjectstyle"];
            $setarr["crid"] = empty($paramarr["crid"]) ? "" : intval($paramarr["crid"]);
            $setarr["message"] = !isset($paramarr["message"]) ? "" : myiconv($paramarr["message"]);
            $setarr["note"] = !isset($paramarr["note"]) ? "" : myiconv($paramarr["note"]);
            if(isset($paramarr['channel'])&&count($paramarr["channel"])>0){
                $setarr['channel']=implode(',',$paramarr['channel']);
            }
            $setarr["source"] = isset($paramarr["source"]) ? $paramarr["source"].','.$paramarr['sourcekey']:"";
            $setarr["fromurl"] = empty($paramarr["fromurl"]) ? "" : myiconv($paramarr["fromurl"]);
            if(isset($paramarr['thumb'])&&!empty($paramarr['thumb']['upfilepath'])){
                $setarr['thumb'] = $paramarr['thumb']['upfilepath'];
            }
            if(isset($paramarr['attachment'])&&is_array($paramarr['attachment'])){
                if(strpos($paramarr['attachment']['upfilepath'],',')!==false){
                    $attachmetninfo=explode(',',$paramarr['attachment']['upfilepath']);
                    $setarr['attachment']=$attachmetninfo[1];
                }else{
                    $setarr['attachment']=$paramarr['attachment']['upfilepath'];
                }
                
                
            }
            $setarr["attachlock"] = empty($paramarr["attachlock"]) ? 0 : intval($paramarr["attachlock"]);
            $setarr["author"] = empty($paramarr["author"]) ? "" : myiconv($paramarr["author"]);
            $setarr["viewnum"] = empty($paramarr["viewnum"]) ? 0 : intval($paramarr["viewnum"]);
            $setarr["folder"] = empty($paramarr["folder"]) ? 0 : intval($paramarr["folder"]);
            $setarr["itemurl"] = empty($paramarr["itemurl"]) ? "" : myiconv($paramarr["itemurl"]);
            $setarr["tag"] = empty($paramarr["tag"]) ? "" : myiconv($paramarr["tag"]);
            $setarr['top'] = empty($paramarr["top"]) ? 0 : intval($paramarr["top"]);
            $setarr["best"] = empty($paramarr["best"]) ? 0 : intval($paramarr["best"]);
            $setarr["hot"] = empty($paramarr["hot"]) ? 0 : intval($paramarr["hot"]);
            $setarr['lastpost'] = time();
            $setarr['dateline'] = empty($paramarr['dateline'])?time():strtotime($paramarr['dateline']);
            if(isset($paramarr['address_qu'])&&!empty($paramarr['address_qu'])) {
                $setarr["citycode"] = $paramarr['address_qu'];
            }elseif(isset($paramarr['address_shi'])&&!empty($paramarr['address_shi'])){
                $setarr["citycode"] = $paramarr['address_shi'];
             }elseif(isset($paramarr['address_sheng'])&&!empty($paramarr['address_sheng'])){
                $setarr["citycode"] = $paramarr['address_sheng'];
            }
            if(trim($paramarr['op'])=='add'){
                $result = $this->db->insert("ebh_items", $setarr);
                if($paramarr['type']=='ad'){
                    if($result!==false){
                        $settime['itemid'] = $result;
                        $settime['begintime'] = empty($paramarr["begintime"]) ? time() : strtotime($paramarr["begintime"]);
                        $settime['endtime'] = empty($paramarr["endtime"]) ? time() : strtotime($paramarr["endtime"]);
                        $sql = 'insert into ebh_ads (itemid,begintime,endtime) values('.$settime['itemid'].','.$settime['begintime'].','.$settime['endtime'].')';
                        $result = $this->db->simple_query($sql);
                      
                    }
                    
                }
                
            }else{
                if($paramarr['itemid']!==false){
                    $result = $this->db->update("ebh_items", $setarr,array('itemid'=>$paramarr['itemid']));
                    if($paramarr['type']=='ad'){
                        if($result!==false){
                            $settime['itemid'] = $paramarr['itemid'];
                            $settime['begintime'] = empty($paramarr["begintime"]) ? time() : strtotime($paramarr["begintime"]);
                            $settime['endtime'] = empty($paramarr["endtime"]) ? time() : strtotime($paramarr["endtime"]);
                            $sql = 'update ebh_ads set begintime='.$settime['begintime'].',endtime='.$settime['endtime'].' where itemid = '.$settime['itemid'].' limit 1';
                            $result = $this->db->simple_query($sql);
                        }
                    
                    }
                }
                
            }
            if($result!==false){
                return true;
            }
            
        } else {
            return false;
        }
    }

    /**
     * 根据itemid删除对应条目;
     * @param int $itemid
     * @return bool
     */

    public function delById($itemid=null){
        if(!is_null($itemid)){
            if($this->db->delete('ebh_items','itemid='.intval($itemid))!==false){
                return true;
            }else{
                return false;
            }
        }

    }
    /**
     * 根据相关条件批量排序;
     * @param arary $params
     * @return bool
     * 格式$params=array(itemid1=>displayorder1,itemid2=>displayorder2,.....) 其中itemid和displayorder为int类型
     */
    public function moveorderAll($params){
        $isOk=true;
        foreach ($params as $key => $value) {
            if($this->db->update('ebh_items',array('displayorder'=>$value),array('itemid'=>$key))===false){
                $isOk = false;
            }
        }
        return $isOk;
    }
    /**
     * 置顶，精华，热门操作;
     * @param int $items
     * @param array $kv
     * @return bool
     * $items = array(itemid1,itemid2,itemid3...)
     * $kv = array('hot'=>1);array('best'=>2);array('top'=>3)等
     */
    public function bthAll($items,$kv){
        $isOk=true;
        foreach ($items as $value) {
            if($this->db->update('ebh_items',$kv,array('itemid'=>$value))===false){
                $isOk=false;
            }
        }
        return $isOk;
    }
    /**
     * 根据相关条件删除或者隐藏信息,默认隐藏;
     * @param arary $params
     * @param int $tag
     * @return bool
     * $params = array(itemid1,itemid2,itemid3,.....);
     * $tag = 0 或者 $tag = 1;0表示直接删除,1表示影藏该条数据
     */
    public function delAll($params,$tag=1){
        $tag = intval($tag);
        //操作数检测防
        if(!in_array($tag,array(0,1),true))return false;
        //$params 为itemid 数组
        $isOk=true;
        if($tag==0){
            //直接删除
            foreach ($params as $v) {
                if($this->delById($v)===false){
                $isOk = false;
                }
            }
        }else{
            //隐藏
            foreach ($params as $v) {
                if(false===$this->db->update('ebh_items',array('folder'=>1),array('itemid'=>$v))){
                $isOk = false;
                }
            }
        }
        return $isOk;
    }
    /**
     * 根据相关条件将相关的item移动到对应的分类下面;
     * @param arary $param
     * @param int $itemCategory
     * @return bool
     * $param =array(itemid1,itemid2,...)
     * $itemCategory = 2;itemCategory的值为int类型
     * 
     */ 
    public function movecategoryAll($param,$itemCategory){
        $isOk=true;
        $itemCategory = intval($itemCategory);
        foreach ($param as $value) {
            if($this->db->update('ebh_items',array('catid'=>$itemCategory),array('itemid'=>$value))===false){
                $isOk=false;
            }
        }
        return $isOk;
    }
	public function getitemmath($param){
		$sql = 'SELECT i.subject,c.name FROM ebh_items i,ebh_categories c ';
//        $wherearr = array();
//        if(!empty($param['catid'])) {
//            $catids = implode(",", $catid);
//			echo $catids;
//			$wherearr[] = 'i.catid in ( ' .$catids . ')';
//        }
		
 //       $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['order'])) {
            $sql .= ' ORDER BY '.$param['order'];
        } else {
            $sql .= ' ORDER BY f.displayorder';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
	}

	public function getitemzwx($param){
		$sql = 'SELECT i.subject,c.name,i.itemid,i.dateline,i.note,i.viewnum,i.thumb FROM ebh_items i,ebh_categories c ';
        $wherearr = array();
		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid  = ' .$param['crid'];
	    }
		if(!empty($param['folder'])) {
			$wherearr[] = 'i.folder = ' .$param['folder'];
	    }
		if(!empty($param['catid'])) {
			$wherearr[] = ' i.catid=c.catid and i.catid = ' .$param['catid'];
	    }
		$sql .= ' WHERE '.implode(' AND ', $wherearr);
		if(!empty($param['order'])) {
			$sql .= ' ORDER BY '.$param['order'];
		} else {
			$sql .= ' ORDER BY i.displayorder';
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
	*资讯详情
	*/
	public function getitemdetail($itemid){
		$sql = 'SELECT subject,dateline,message,note,source,viewnum,tag FROM ebh_items ';
		$wherearr = array();
		if (!empty($itemid)) {
            $wherearr[] = ' itemid = '.$itemid ;
        }
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        return $this->db->query($sql)->row_array();
	}
	/**
     * 添加资讯的查看数
     * @param int $itemid
     * @param int $num
     */
    public function addviewnum($itemid, $num = 1) {
        $where = 'itemid=' . $itemid;
        $setarr = array('viewnum' => 'viewnum+' . $num);
        $this->db->update('ebh_items', array(), $where, $setarr);
    }
	/**
	*stores的关于我们及师资团队
	*/
	public function getadit($param){
		$sql = 'SELECT i.subject,i.catid,c.name,i.message,i.note,i.thumb FROM ebh_items i,ebh_categories c ';
		$wherearr = array();
		if (!empty($param['crid'])) {
            $wherearr[] = ' i.crid = '.$param['crid'] ;
        }
		if (!empty($param['catid'])) {
            $wherearr[] = ' i.catid=c.catid and i.catid = '.$param['catid'] ;
        }
		if (!empty($param['type'])) {
            $wherearr[] = 'c.type=\''.$param['type'].'\'';
        }
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY i.displayorder';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
	}
	/**
	*页面公共底部查询
	*/
public function getitemslink($type){
		$sql = 'SELECT i.subject,i.itemurl,c.caturl,c.code FROM ebh_items i,ebh_categories c where i.catid=c.catid and c.type = \''.$type.'\' order by i.displayorder limit 0,20';
        return $this->db->query($sql)->list_array();
	}

    /**
     *获取item列表(不链接category表)
     *@param array $param
     *@return array
     */
    public function getSimpleList($param=array()){
        $sql = 'select i.* from ebh_items i ';
        $param = $this->db->escape_str($param);
        $whereArr = array();
        if(!empty($param['catid'])){
            $whereArr[] = 'i.catid='.$param['catid'];
        }
        if(!empty($param['in'])){
            $whereArr[] = 'i.catid in'.$param['in'];
        }
        if(!empty($param['crid'])){
            $whereArr[] = 'i.crid='.$param['crid'];
        }
		if (!empty($param['startdate'])){
			$whereArr[]= 'i.dateline>='.$param['startdate'];
		}
		if (!empty($param['enddate'])){
			$whereArr[]= 'i.dateline<='.$param['enddate'];
		}
        if(!empty($param['q'])){
            $whereArr[] = 'i.subject like \'%'.$param['q'].'%\'';
        }
        if(!empty($whereArr)){
            $sql.=' WHERE '.implode(' AND ',$whereArr);
        }
        if(empty($param['order'])){
            $sql.=' order by itemid desc ';
        }
        if(!empty($param['limit'])){
            $sql.= ' limit '.$param['limit'];
        }else{
            $offset = max(0,($param['page']-1)*$param['pagesize']);
            $limit = $offset.','.$param['pagesize'];
            $sql.=' limit '.$limit;
        }
        return $this->db->query($sql)->list_array();
    }
    /**
     *获取item列表数目(不链接category表)
     *@param array $param 
     *@return int
     */
    public function getSimpleListCount($param=array()){
        $sql = 'select count(*) count from ebh_items i';
        $param = $this->db->escape_str($param);
        $whereArr = array();
        if(!empty($param['catid'])){
            $whereArr[] = 'i.catid='.$param['catid'];
        }
        if(!empty($param['in'])){
            $whereArr[] = 'i.catid in'.$param['in'];
        }
        if(!empty($param['crid'])){
            $whereArr[] = 'i.crid='.$param['crid'];
        }
		if (!empty($param['startdate'])){
			$whereArr[]= 'i.dateline>='.$param['startdate'];
		}
		if (!empty($param['enddate'])){
			$whereArr[]= 'i.dateline<='.$param['enddate'];
		}
        if(!empty($param['q'])){
            $whereArr[] = 'i.subject like \'%'.$param['q'].'%\'';
        }
		if(isset($param['folder']))
			$whereArr[] = 'i.folder in ('.$param['folder'].')';
        if(!empty($whereArr)){
            $sql.=' WHERE '.implode(' AND ',$whereArr);
        }
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }
    /**
     *根据itemid获取对应的单条信息
     *@param int $itemid
     *@return array
     */
    public function getDetailByItemId($itemid){
        $sql = 'select i.* from ebh_items i WHERE i.itemid='.$itemid;
        return $this->db->query($sql)->row_array();
    }
    /**
     *简单的增加一条item记录
     *@param array $param
     *@return bool
     */
    public function _insert($param=array()){
        $param=$this->db->escape_str($param);
        $param['lastpost'] = time();
        $itemid = $this->db->insert('ebh_items',$param);
        if($itemid>0){
            return true&&$this->updateADs($itemid);
        }else{
            return false;
        }
    }
    /**
     *简单的修改一条item记录
     *@param array $param
     *@param array $where
     *@return bool
     */
    public function _update($param = array(),$where = array()){
        $param=$this->db->escape_str($param);
        $where = $this->db->escape_str($where);
        if(empty($param)||empty($where)){
            return false;
        }
		$afrows = $this->db->update('ebh_items', $param, $where);
        return $afrows;
    }

     /**
     *判断对应的Item是否存在
     *@param  int itemid
     *@return bool
     */
    public function ifExitFindByItemid($itemid=0){
        $sql = 'select * from ebh_items where itemid='.intval($itemid);
        $res = $this->db->query($sql)->row_array();
        if(empty($res)){
            return true;
        }else{
            return false;
        }
    }
    /**
     *根据参数获取单条item记录
     *@param array $param
     *@return array
     */
    public function getOneByParam($param=array()){
        $sql = 'select i.* from ebh_items i';
        $whereArr = array();
        if(!empty($param['catid'])){
            $whereArr[] = 'i.catid = '.$param['catid'];
        }
        if(!empty($param['crid'])){
            $whereArr[] = 'i.crid = '.$param['crid'];
        }
        if(!empty($param['itemid'])){
            $whereArr[] = 'i.itemid = '.$param['itemid'];
        }
        if(!empty($whereArr)){
            $sql.=' WHERE '.implode(' AND ',$whereArr);
        }
        $sql.=' limit 1 ';
        return $this->db->query($sql)->row_array();
    }

    public function updateADs($itemid){
        //$sql = 'insert into ebh_ads set itemid = '.$itemid;
        $sql = 'insert into ebh_ads (itemid,begintime,endtime) values ('.$itemid.','.time().','.(time()+3600*24*365).')'; 
        return $this->db->query($sql);
    }

    /**
     *获取免费试听课件信息
     *
     */
    public function getFree($num = 4){
         $sql = 'SELECT i.itemid,i.subject,i.thumb,i.itemurl,u.username,u.realname from ebh_items i join ebh_users u on i.uid = u.uid where  i.channel = \'1008\' AND i.folder=2 ORDER BY i.displayorder limit 0,'.$num;
         return $this->db->query($sql)->list_array();
    }

    /**
     *简单的增加一条item记录
     *@param array $param
     *@return bool
     */
    public function addone($param=array()){
        $param=$this->db->escape_str($param);
        $itemid = $this->db->insert('ebh_items',$param);
        if($itemid>0){
            return true;
        }else{
            return false;
        }
    }
}
