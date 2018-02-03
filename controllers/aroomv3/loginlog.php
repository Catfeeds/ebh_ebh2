<?php
/**
 * ebh2.
 * Author: ckx
 */
class LoginlogController extends ARoomV3Controller{
    public function logList(){
		$data['crid'] = $this->roominfo['crid'];
		$data['starttime'] = $this->input->get('starttime');
		$data['endtime'] = $this->input->get('endtime');
		$data['q'] = $this->input->get('q');
		$data['citycode'] = $this->input->get('citycode');
		$data['screen'] = $this->input->get('screen');
		$data['groupid'] = $this->input->get('groupid');
		$newuser = $this->input->get('newuser');
		$iorder = $this->input->get('iorder');
		$system = $this->input->get('system');
		if(!empty($system)){//字符串 系统,浏览器
			$sarr = explode(',',$system);
			if(count($sarr) == 2){
				$data['system'] = $sarr[0];
				$data['browser'] = $sarr[1];
			}
		}
		if(!empty($newuser) && !empty($data['starttime']) && !empty($data['endtime'])){//只查询新加入学生
			$uidlist = $this->apiServer->reSetting()->setService('Aroomv3.Student.uidList')->addParams($data)->request();
			if(!empty($uidlist)){
				$data['uids'] = implode(',',array_column($uidlist,'uid'));
			} else {
				$this->renderjson('',0,array());
			}
		}
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		$data['page'] = empty($page)?0:$page;
		$data['pagesize'] = empty($pagesize)?20:$pagesize;
		if($iorder !== NULL){//意向排序
			$data['order'] = $iorder == 0?'intention asc':'intention desc';
		}
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.list')->addParams($data)->request();
		if(!empty($list['loglist'])){//地域信息
			$codes = array_column($list['loglist'],'citycode');
			$rdata['codes'] = implode(',',$codes);
			if(!empty($rdata)){
				$cities = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.regionList')->addParams($rdata)->request();
			}
			if(!empty($cities)){
				foreach($list['loglist'] as $k=>$log){
					if(!empty($cities[$log['citycode']])){
						$list['loglist'][$k]['cityname'] = $cities[$log['citycode']]['cityname'];
						$list['loglist'][$k]['pcityname'] = $cities[$log['citycode']]['pcityname'];
					}
				}
			}
		}
		// var_dump($citycode);
		$this->renderjson('',0,$list);
	}
	
	// public function regionList(){
		// $data['pcode'] = intval($this->input->get('pcode'));
		// $list = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.regionList')->addParams($data)->request();
		// $this->renderjson('',0,$list);
	// }
	
	/*
	设备列表
	*/
	public function clientList(){
		$data['crid'] = $this->roominfo['crid'];
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.clientList')->addParams($data)->request();
		$this->renderjson('',0,$list);
	}
	
	/*
	分辨率列表
	*/
	public function screenList(){
		$data['crid'] = $this->roominfo['crid'];
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.screenList')->addParams($data)->request();
		$this->renderjson('',0,$list);
	}
	
	/*
	地域分布列表
	*/
	public function distributeList(){
		$data['crid'] = $this->roominfo['crid'];
		$data['starttime'] = $this->input->get('starttime');
		$data['endtime'] = $this->input->get('endtime');
		$data['citycode'] = $this->input->get('citycode');
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.distributeList')->addParams($data)->request();
		if(!empty($list)){
			$countarr = array_column($list,'count');
			$sum = array_sum($countarr);
			$codetype = empty($data['citycode'])?'parentcode':'citycode';
			$citycodearr = array_column($list,$codetype);
			$codes = implode(',',$citycodearr);
			//地域信息
			$cities = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.regionList')->addParams(array('codes'=>$codes))->request();
			
			// 签到信息
			if($codetype == 'citycode'){
				$data['codes'] = $codes;
				$signlist = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.signList')->addParams($data)->request();
			}
			$sortarr = array();
			foreach($list as $k=>$region){
				$code = $region[$codetype];
				$list[$k]['cityname'] = $cities[$code]['cityname'];
				$percent = round($region['count']/$sum,4)*100;
				$list[$k]['percent'] = $percent;
				$list[$k]['signcount'] = empty($signlist[$code])?0:$signlist[$code]['count'];
				$sortarr[] = $region['count'];
			}
			
			array_multisort($sortarr,SORT_DESC,$list);
		}
		$this->renderjson('',0,$list);
	}
	
	/*
	选择意向,loginlog做,弊端update多条数据;roomuser做,弊端删除后没有数据
	*/
	public function chooseIntention(){
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->input->post('uid');
		$data['intention'] = $this->input->post('intention');
		if($data['intention'] !== NULL && !in_array($data['intention'],array(0,1,2))){
			$data['intention'] = 1;
		}
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.chooseIntention')->addParams($data)->request();
		if($res !== FALSE){
			$this->renderjson('操作成功',0);
		} else {
			$this->renderjson('操作失败',1);
		}
	}
}