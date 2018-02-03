<?php
/*
viewnum缓存测试
*/
class ViewnumtestController extends CControl{
	public function index(){
		
		$stime = microtime(true);
		$redis = Ebh::app()->getCache('cache_redis');
		
		$etime = microtime(true);
		// echo $etime-$stime;
		
		$aa = $redis->hget('coursewareviewnum');
		// var_dump($aa);
		$this->display('common/viewnumtest');
	}
	public function getallviewnum(){
		$redis = Ebh::app()->getCache('cache_redis');
		$type = $this->input->post('type');
		$viewnum = $redis->hget($type.'viewnum');
		echo json_encode(array($viewnum,count($viewnum)));
	}
	public function getallviewnumdb(){
		$foldermodel = $this->model('folder');
		$viewnumlist = $foldermodel->getViewnumWithCW();
		echo json_encode(array($viewnumlist,count($viewnumlist)));
	}
	public function getviewnum(){
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$redis = Ebh::app()->getCache('cache_redis');
		$viewnum = $redis->hget($type.'viewnum',$id);
		$themodel = $this->model($type);
		if($type == 'courseware'){
			$result = $themodel->getSimplecourseByCwid($id);
		}elseif( $type=='folder' ){
			$result = $themodel->getfolderbyid($id);
		}
		echo json_encode(array($viewnum,$result['viewnum']));
	}
	public function updateviewnum(){
		$stime = microtime(true);
		$redis = Ebh::app()->getCache('cache_redis');
		$type = $this->input->post('type');
		$viewnum = $redis->hget($type.'viewnum');
		$themodel = $this->model($type);
		if($type == 'courseware'){
			$afrows = $themodel->setMultiViewnum($viewnum);
		}elseif($type == 'folder'){
			$afrows = $themodel->setMultiViewnum($viewnum);
		}
		// $redis->del('coursewareviewnum');
		
		$etime = microtime(true);
		
		echo json_encode(array($etime-$stime,$afrows));
		
		// var_dump($viewlist);
	}
	public function clearcache(){
		$redis = Ebh::app()->getCache('cache_redis');
		$type = $this->input->post('type');
		$redis->del($type.'viewnum');
	}
	public function setcache2folder(){
		$stime = microtime(true);
		$redis = Ebh::app()->getCache('cache_redis');
		
		$type = $this->input->post('type');
		$foldermodel = $this->model('folder');
		$viewnumlist = $foldermodel->getViewnumWithCW();
		$todolist = array();
		foreach($viewnumlist as $f){
			$cacheviewnum = $redis->hget($type.'viewnum',$f['folderid']);
			if(empty($cacheviewnum) || $f['cwviewnum']<$cacheviewnum){
				$todolist[$f['folderid']] = $f['cwviewnum'];
			}else{
				$redis->hset($type.'viewnum',$f['folderid'],$f['cwviewnum']);
			}
			
		}
		$afrows = $foldermodel->setMultiViewnum($todolist);
		// $redis->del('coursewareviewnum');
		
		$etime = microtime(true);
		
		echo json_encode(array($etime-$stime,$afrows));
	}
	
	
	public function setcache(){
		$stime = microtime(true);
		$redis = Ebh::app()->getCache('cache_redis');
		$cwidfrom = $this->input->post('cwidfrom');
		$cwidto = $this->input->post('cwidto');
		$type = $this->input->post('type');
		$viewnum = $this->input->post('viewnum');
		$viewnum = empty($viewnum)?1:$viewnum;
		$count = 0;
		if(!empty($cwidfrom)){
			for($i = $cwidfrom;$i<=$cwidto;$i++){
				// for($j=0;$j<$viewnum;$j++){
					// $redis->hIncrBy($type.'viewnum',$i);
				// }
				$redis->hIncrBy($type.'viewnum',$i,$viewnum);
				$count++;
			}
		}
		// $redis->del('coursewareviewnum');
		
		$etime = microtime(true);
		
		echo json_encode(array($etime-$stime,$count));
	}
	public function setitemcache(){
		$stime = microtime(true);
		$itemidfrom = intval($this->input->post('itemidfrom'));
		$itemidto = intval($this->input->post('itemidto'));
		$viewnumfrom = intval($this->input->post('viewnumfrom'));
		$viewnumto = intval($this->input->post('viewnumto'));
		$count = 0;
		if ($itemidfrom <= 0 || $itemidto <= 0 || $viewnumfrom == 0 || $viewnumto == 0) {	//非法
			$etime = microtime(true);
			echo json_encode(array($etime-$stime,$count));
			exit();
		}
		for($i = $itemidfrom; $i <= $itemidto; $i ++) {
			$viewnum = $viewnumfrom;
			if ($viewnumto > $viewnumfrom) {
				$viewnum = mt_rand($viewnumfrom,$viewnumto);
			}
			$sresult = $this->setItem($i,$viewnum);
			if ($sresult) {
				$count ++;
			}

		}
		
		$etime = microtime(true);
		
		echo json_encode(array($etime-$stime,$count));
	}
	private function setItem($itemid,$viewnum) {
		$redis = Ebh::app()->getCache('cache_redis');
		$payitemmodel = $this->model('Payitem');
		$itemdetail = $payitemmodel->geSimpletItemByItemid($itemid);
		if (empty($itemdetail))
			return FALSE;
		$folderid = $itemdetail['folderid'];
		$redis->hIncrBy('folderviewnum',$folderid,$viewnum);
		return TRUE;
	}
	
}
?>