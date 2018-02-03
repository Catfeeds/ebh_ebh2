<?php

/*
 *新版作业预览，存入缓存
 */
class CacheController extends CControl {
	private $user = NULL;	//当前用户
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        $this->user = Ebh::app()->user->getloginuser();
    }

    public function index() {
    	$uid = $this->user['uid'];
		if (empty($uid)) {
			echo 'need login';
			exit();
		}
		$op = $this->input->get('op');
		$redis = Ebh::app()->getCache('cache_redis');
		if ($op == 'set') {
			$cachekey = $this->cache->getcachekey('examv2',array('key'=>uniqid(),'uid'=>$uid));
			$data = $this->input->post('data',FALSE);
			$res = $redis->set($cachekey,serialize($data),60);
			if($res){
				echo $cachekey;
			}else{
				echo 0;
			}	
		}else if($op == 'get'){
			$cachekey = $this->input->get('cachekey');
			if(empty($cachekey)){
				echo json_encode(array());exit;
			}
			$res = $redis->get($cachekey);
			if(!empty($res)){
				echo json_encode(unserialize($res));
			}else{
				echo json_encode(array());
			}
		}
    }


}
