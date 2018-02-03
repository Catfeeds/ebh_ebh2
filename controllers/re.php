<?php
/**
 * redis测试
 */
class ReController extends CControl {
	var $redis = NULL;
    public function __construct(){
        parent::__construct();
        $this->redis = Ebh::app()->getCache('cache_redis');
    }
    public function index(){
		$msg = '<a href="re/ihash.html">ihash</a><br />';
		$msg .= '<a href="re/ikey.html">ikey</a><br />';
		$msg .= '<a href="re/rhash.html">rhash</a><br />';
		$msg .= '<a href="re/rkey.html">rkey</a><br />';
		$this->assign('msg',$msg);
		$this->display("common/re");
    }
	public function ihash() {
		$hashkey = 'ihash';
		$hashitem = 'ihash_';
		for($i = 0; $i < 100000; $i++) {
			$hashitemvalue = $hashitem.$i.mt_rand(1,100000);
			$this->redis->hset($hashkey,$hashitem.$i,$hashitemvalue);
		}
		$msg = "测试插入hset 10万记录时间<br />";
		$this->assign('msg',$msg);
		$this->display("common/re");
	}
	public function ikey() {
		$hashkey = 'ikey_';
		for($i = 0; $i < 100000; $i++) {
			$keyvalue = $hashkey.$i.mt_rand(1,100000);
			$this->redis->set($hashkey.$i,$keyvalue);
		}
		$msg = "测试插入set 10万记录时间<br />";
		$this->assign('msg',$msg);
		$this->display("common/re");
	}
	public function rhash() {
		$hashkey = 'ihash';
		$msg = "测试读取10条rhash记录时间<br />";
		for($i = 0; $i < 10; $i ++) {
			$hashitem = 'ihash_'.mt_rand(1,100000);
			$itemvalue = $this->redis->hget($hashkey,$hashitem);
			$msg .= "${hashitem}:${itemvalue} <br />";
		}
		$this->assign('msg',$msg);
		$this->display("common/re");
	}
	public function rkey() {
		$hashkey = 'ikey_';
		$msg = "测试读取10条key记录时间<br />";
		for($i = 0; $i < 10; $i ++) {
			$key = $hashkey.mt_rand(1,100000);
			$value = $this->redis->get($key);
			$msg .= "${key}:${value} <br />";
		}
		$this->assign('msg',$msg);
		$this->display("common/re");
	}
	public function uhash() {
		$hashkey = 'ihash';
		$msg = "测试update10条uhash记录时间<br />";
		for($i = 0; $i < 10; $i ++) {
			$hashitem = 'ihash_'.mt_rand(1,100000);
			$keyvalue = $hashitem.'_uuu';
			$this->redis->hset($hashkey,$hashitem,$keyvalue);
			$msg .= "${hashitem}:${keyvalue} <br />";
		}
		$this->assign('msg',$msg);
		$this->display("common/re");
	}
	public function ukey() {
		$hashkey = 'ikey_';
		$msg = "测试update10条ukey记录时间 <br />";
		for($i = 0; $i < 10; $i++) {
			$key = $hashkey.mt_rand(1,100000);
			$keyvalue = $key.mt_rand(1,100000).'_uuu';
			$this->redis->set($key,$keyvalue);
			$msg .= "${key}:${keyvalue} <br />";
		}
		
		$this->assign('msg',$msg);
		$this->display("common/re");
	}
	public function dhash() {
		$hashkey = 'ihash';
		$msg = "测试删除hash记录时间<br />";
		$itemvalue = $this->redis->hdel($hashkey);
		$this->assign('msg',$msg);
		$this->display("common/re");
	}
	public function dkey() {

	}

}
?>
