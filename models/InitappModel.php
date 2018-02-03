<?php
/*
初始化app列表
*/
class InitappModel extends CModel{
	public function getapplist(){
		$sql = 'select cid,crid,appstr from ebh_custommessages where `index`=1';
		// echo $sql;
		return $this->db->query($sql)->list_array();
		
	}
	
	public function updateappstr($param){
		
		if(isset($param['appstr']))
			$setarr['appstr'] = $param['appstr'];
		$wherearr = array('crid'=>$param['crid'],'`index`'=>1);
			// var_dump($wherearr);
		$row = $this->db->update('ebh_custommessages',$setarr,$wherearr);
			return $row;
		
	}
	
	public function insertappstr($withoutcrids){
		$sql = 'select crid from ebh_classrooms where crid not in('.$withoutcrids.')';
		$crlist = $this->db->query($sql)->list_array();
		$newapp[0]['img'] = 'http://img.ebanhui.com/ebh/2015/11/24/14483495643740.png';
		$newapp[0]['title'] = '网络学校电视版下载';
		$newapp[0]['url'] = 'http://soft.ebh.net/ebh_tv.apk';
		
		$newapp[1]['img'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/app_jiazhang.png';
		$newapp[1]['title'] = '家长监控平台';
		$newapp[1]['url'] = 'http://jiazhang.ebh.net';
		
		$newapp[2]['img'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/app_suoping.png';
		$newapp[2]['title'] = '锁屏浏览器';
		$newapp[2]['url'] = 'http://soft.ebh.net/ebhbrowser.exe';
		
		$newapp[3]['img'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/app_app.png';
		$newapp[3]['title'] = 'APP应用';
		$newapp[3]['url'] = '/intro/app.html';
		
		$appstr = serialize($newapp);
		// $appstr = 'a:1:{i:0;a:3:{s:3:"img";s:56:"http://img.ebanhui.com/ebh/2015/11/24/14483495643740.png";s:5:"title";s:27:"网络学校电视版下载";s:3:"url";s:30:"http://soft.ebh.net/ebh_tv.apk";}}';
		$insertsql = 'insert into ebh_custommessages (crid,`index`,custommessage,appstr) values ';
		foreach($crlist as $cr){
			$crid = $cr['crid'];
			$t = "($crid,1,'','$appstr'),";
			$insertsql.= $t;
		}
		$insertsql = rtrim($insertsql,',');
		$res = $this->db->query($insertsql);
		echo '<br>'.$this->db->affected_rows().'个网校添加成功';
	}
}
?>