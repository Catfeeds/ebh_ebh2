<?php
/**
 * 收藏Model类
 * Author: songpeng
 * Date: 2017/04/28
 * 
 */
class CollectModel extends CModel {

    /**
     *根据用户uid、crid查询用户收藏夹信息
     *查询ebh_collect表
     *@return  课程编号数组
     */
    public function getCollectInfoByUid($uid,$crid){     
        $retarr  =  false;
        $sql = "SELECT `itemid` FROM `ebh_collects` WHERE `uid` = " . intval($uid) . " AND `crid` =" . intval($crid) . "  ";
        $rows = $this->db->query($sql)->list_array('itemid');
        if(!empty($rows)){
            $retarr =  array_keys($rows);
        }
        return $retarr;
    }
    /**
     *根据用户uid、crid查询用户收藏夹信息
     *@return  唯一编号itemid数组
     */
    public function getCollectItemidByUid($uid,$crid){ 
        $retarr = false;
        $sql = "SELECT `itemid` FROM `ebh_collects` WHERE `uid` = " . intval($uid) . " AND `crid` = " .intval($crid) . " ";
        $rows = $this->db->query($sql)->list_array('itemid');
        if(!empty($rows)){
            $retarr = array_keys($rows);
        }
        return  $retarr;
    }
	/**
	 *收藏列表的增加
	 *@param  $uid,$crid,$folderid,$itemis
     *
	 */
	public function add($param=array()){
	    $setarr = array();
	    $ret = false;
	    if(!empty($param['uid'])){
	        $setarr['uid'] = intval($param['uid']);
	    }
	    if(!empty($param['crid'])){
	        $setarr['crid'] = intval($param['crid']);
	    }
	    if(!empty($param['folderid'])){
	        $setarr['folderid'] = intval($param['folderid']);
	    }
	    if(!empty($param['itemid'])){
	        $setarr['itemid'] = intval($param['itemid']);
	    }
	    
	    if(!empty($setarr)){
	       $ret = $this->db->insert('ebh_collects',$setarr);
	    }
	    
    	return $ret;
    }
    /**
     *收藏列表的删除
     *@param  $uid,$crid,$folderid 
     *
     */
    public function del($uid,$crid,$folderid){
        $where = array(
            'uid'=>$uid,
            'folderid'=>$folderid,
            'crid'=>$crid
        );
        return  $this->db->delete('ebh_collects',$where);
    }
    /**
     *查询收藏列表
     *@param  $uid,$crid,$folderi 
     *
     */
    public function check($uid,$crid,$folderid){
    	$ret = false;
        $sql = "SELECT count(1) as count FROM `ebh_collects` WHERE `uid` = $uid AND `folderid` = $folderid AND `crid` = $crid ";
    	$row = $this->db->query($sql)->row_array();
    	if(!empty($row['count'])){
    	    $ret = true;
    	}
    	return $ret;
    }

    
}