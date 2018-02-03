<?php
/**
 * 微信授权model类
 */
class OpenwxModel extends CModel{

	/**
	 * 检测是否存在
	 */
	public function checkexist($openid){
		$sql = "select count(*) count from ebh_openwxs where openid = '{$openid}' and del = 0";
		$row = $this->db->query($sql)->row_array();
		return ($row['count']>0) ? true : false;
	}

	/**
	 * 获取授权用户
	 */
	public function getOneByOpenid($openid){
		$sql = "select u.realname,u.face,u.uid,u.password,u.lastlogintime,u.lastloginip from ebh_openwxs wx
				left join ebh_users u on u.uid = wx.uid
				where wx.openid ='$openid' and wx.del = 0
				";
		return $this->db->query($sql)->row_array();
	}
	
	/**
	 * 新增加一条记录
	 */
	public function add($param ){
		$setarr = array();
		if(!empty($param['nickname'])){
			$setarr['nickname'] =$param['nickname'];
		}
		if(!empty($param['uid'])){
			$setarr['uid'] =$param['uid'];
		}
		if(!empty($param['unionid'])){
			$setarr['unionid'] =$param['unionid']; 
		}
		if(!empty($param['openid'])){
			$setarr['openid'] =$param['openid'];
		}
		if(!empty($param['sex'])){
			$setarr['sex'] =$param['sex'];
		}
		if(!empty($param['headimgurl'])){
			$setarr['headimgurl'] =$param['headimgurl'];
		}
		if(!empty($param['dateline'])){
			$setarr['dateline'] =$param['dateline'];
		}
		if(isset($param['del'])){
			$setarr['del'] =$param['del'];
		}
		
		return $this->db->insert('ebh_openwxs',$setarr);
	}
	
	
}
