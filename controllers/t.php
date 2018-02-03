<?php
class TController extends CControl {
	public function index() {
//		$this->testredis();
//		$this->testredis2();
		$this->folder();
	}
	public function folder() {
		$folderids = 3327;
		$upmodel = $this->model('Userpermission');
		$param = array('folderids'=>$folderids,'filteruser'=>'12211,12218','crid'=>10439);
		$folder = $upmodel->getFolderUserList($param);
		var_dump($folder);
		$folder = $upmodel->getFolderUserCount($param);
		var_dump($folder);
	}
	public function c() {
		$count = 3;
		if(NULL !== $this->input->get('count')) {
			$count = intval($this->input->get('count'));
			if($count <= 0) {
				$count = 3;
			}
		}
		$t = time();
		$tarr = array();
		for($i = 0; $i < $count; $i++) {
			$tarr[] = $t+mt_rand(10,10000);
		}
		var_dump($tarr);
	}
	public function wait(){
		echo 'is wait';
	}
	public function testredis() {
		$redis = Ebh::app()->getCache('cache_redis');
		$key = 'reskey';
		$itemkey = 'a1';
		$itemvalue = '123';
		$expire = 10;
//		$redis->hSet($key,$itemkey,$itemvalue);
//		$redis->expire($key,$expire);

		$value = $redis->hGet($key,$itemkey);
		echo "the redis value is ".$value;
	}
	public function testredis2() {
		$redis = Ebh::app()->getCache('cache_redis');
//		$key = 'reskey';
		$itemkey = 'a2';
		$itemvalue = '1234';
		$expire = 10;
//		$redis->set($itemkey,$itemvalue);
//		$redis->expire($itemkey,$expire);

		$value = $redis->get($itemkey);
		echo "the redis value is ".$value;
	}
}