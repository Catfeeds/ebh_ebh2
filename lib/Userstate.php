<?php 
/**
 * 用户信息 Userstate 缓存
 * 点击时间的hash 
		key:ebh_userstate_subtime , 
		field:$crid_$uid_$typeid 或 $crid_$uid_$typeid_$folderid
 * 最新数量的hash 
		key:ebh_userstate_count_$crid_$typeid(便于更新整个网校的某个数据) , 
		field:$uid 或 $uid_$folderid
 */
class Userstate {
	const USERSTATE_PRE = 'ebh_userstate_';
	private $redis;
	public function __construct(){
		
		$this->redis = Ebh::app()->getCache('cache_redis');
	}
	/**
	 * 获取点击时间缓存
	 * @param $crid
	 * @param $uid
	 * @param $typeid
	 * @return mixed
	 */
	public function getCache_subtime($crid,$uid,$typeid,$folderid=0){
		$redis_key = $this->getRedisKey('subtime');
		$redis_field = $crid.'_'.$uid.'_'.$typeid;
		if($typeid==6 && !empty($folderid)){//课程下的新课件
			$redis_field.='_'.$folderid;
		}
		return $this->redis->hget($redis_key,$redis_field);
	}
	
	/**
	 * 设置点击时间缓存
	 * @param $crid
	 * @param $uid
	 * @param $typeid
	 * @param $value
	 */
	public function setCache_subtime($crid,$uid,$typeid,$folderid=0){
		$redis_key = $this->getRedisKey('subtime');
		$redis_field = $crid.'_'.$uid.'_'.$typeid;
		if($typeid==6 && !empty($folderid)){//课程下的新课件
			$redis_field.='_'.$folderid;
		}
		$this->redis->hset($redis_key,$redis_field,SYSTIME);
	}
	
	/**
	 * 清除缓存
	 * @param $crid
	 * @param $uid
	 * @param $typeid
	 */
	public function clearCache_subtime($crid,$uid,$typeid){
		$redis_key = $this->getRedisKey('subtime');
		$redis_field = $crid.'_'.$uid.'_'.$typeid;
		$this->redis->hdel($redis_key);
	}
	
	/**
	 * 更新点击时间缓存
	 * @param $typeid
	 * @param $uid
	 * @param $typeid
	 */
	public function updateUserstate($crid,$uid,$typeid,$folderid=0){
		$lasttime = $this->getCache_subtime($crid,$uid,$typeid,$folderid);//上一次点击时间
		$this->setCache_subtime($crid,$uid,$typeid,$folderid);
		
		if(empty($lasttime) || SYSTIME-$lasttime>=86400){//超过一天，写入数据库
			$statemodel = Ebh::app()->model('Userstate');
			$statemodel->insert($crid,$uid,$typeid,SYSTIME,$folderid);
		}
		//清除数量缓存
		$this->clearCache_count($crid,$uid,$typeid,$folderid);
	}
	
	/**
	 * 获取数量缓存
	 * @param $typeid
	 * @param $uid
	 * @param $typeid
	 */
	public function getCache_count($crid,$uid,$typeid,$folderid=0){
		$redis_key = $this->getRedisKey('count_'.$crid.'_'.$typeid);
		$redis_field = $uid;
		if($typeid==6 && !empty($folderid)){//课程下的新课件
			$redis_field.='_'.$folderid;
		}
		
		return $this->redis->hget($redis_key,$redis_field);
	}
	
	/**
	 * 设置数量缓存
	 * @param $typeid
	 * @param $uid
	 * @param $typeid
	 */
	public function setCache_count($crid,$uid,$typeid,$count,$folderid=0){
		$redis_key = $this->getRedisKey('count_'.$crid.'_'.$typeid);
		$redis_field = $uid;
		if($typeid==6 && !empty($folderid)){//课程下的新课件
			$redis_field.='_'.$folderid;
		}
		$this->redis->hset($redis_key,$redis_field,$count);
	}
	
	/**
	 * 清除数量缓存
	 * @param $crid
	 * @param $typeid
	 */
	public function clearCache_count($crid,$uid=0,$typeid,$folderid=0){
		$redis_key = $this->getRedisKey('count_'.$crid.'_'.$typeid);
		$redis_field = null;
		if(!empty($uid)){
			$redis_field = $uid;
			if($typeid==6 && !empty($folderid)){//课程下的新课件
				$redis_field.='_'.$folderid;
			}
		}
		// var_dump($redis_field);
		$this->redis->hdel($redis_key,$redis_field);
	}
	
	private function getRedisKey($name){
		return self::USERSTATE_PRE.$name;
	}
}
?>