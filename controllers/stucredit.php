<?php
class StucreditController extends CControl{
	public function index(){
		$this->display('common/stucredit');
		
	}
	
	public function viewcache(){
		// $roominfo = Ebh::app()->room->getcurroom();
		$redis = Ebh::app()->getCache('cache_redis');
		// for($i=1429027200;$i<=1431619200;$i=$i+86400){
			// $dayarr[Date('Y/m/d',$i)] = rand(0,12);
		// }
		// $redis->hset('credit',$roominfo['crid'],$dayarr);
		// $redis->hdel('credit',$roominfo['crid']);
		// var_dump($dayarr);
		var_dump($redis->hget('credit'));
	}
	
	public function clearcache(){
		$redis = Ebh::app()->getCache('cache_redis');
		$cachelist = $redis->hget('credit');
		foreach($cachelist as $k=>$cache){
			$redis->hdel('credit',$k);
		}
		// 
	}
	
	public function setcache(){
		$randfrom = $this->input->post('randfrom');
		$randto = $this->input->post('randto');
		for($i=1429027200;$i<=1431619200;$i=$i+86400){
			$dayarr[Date('Y/m/d',$i)] = rand($randfrom,$randto);
		}
		$redis = Ebh::app()->getCache('cache_redis');
		$roominfo = Ebh::app()->room->getcurroom();
		$redis->hset('credit',$roominfo['crid'],$dayarr);
	}
	
	public function recountcache(){
		$redis = Ebh::app()->getCache('cache_redis');
		$cachelist = $redis->hget('credit');
		$rumodel = $this->model('roomuser');
		$creditmodel = $this->model('credit');
		$param['datefrom'] = strtotime('today')-86400*30;
		$param['dateto'] = strtotime('today'); 
		$rulelist = $creditmodel->getCreditRuleList(array('action'=>'+'));
		$ruleids = '';
		foreach($rulelist as $rule){
			if($rule['ruleid'] != 29)
			$ruleids.= empty($ruleids)?$rule['ruleid']:','.$rule['ruleid'];
		}
		$param['ruleids'] = $ruleids;
		$param['group'] = ' d ';
		foreach($cachelist as $k=>$cache){
			$oldcache = unserialize($cache);
			
			$rulist = $rumodel->getUserListWhoLoged($k);
			$uids = '';
			foreach($rulist as $ru){
				$uids.= $ru['uid'].',';
			}
			$param['uids'] = rtrim($uids,',');
			
			$crcclist = $creditmodel->getCreditComingList($param);//全校积分记录
			$creditcache = array();
			foreach($crcclist as $crcredit){
				$creditcache[Date('Y/m/d',$crcredit['dateline'])] = $crcredit['sumcredit'];
			}
			if(!empty($oldcache[Date('Y/m/d',SYSTIME)]))
				$creditcache[Date('Y/m/d',SYSTIME)] = $oldcache[Date('Y/m/d',SYSTIME)];
			// var_dump($param);
			$redis->hset('credit',$k,$creditcache);
		}
	}
}
?>