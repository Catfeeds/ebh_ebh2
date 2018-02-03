<?php

/**
 * User: ckx
 * 点名系统设置
 */
class RollcallController extends ARoomV3Controller {
	/**
	 *设置信息 
	 */
	public function settings(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$settings = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.settings')->addParams($param)->request();
		$this->renderjson(0,'',$settings);
	}
	
	/*
	保存信息
	*/
	public function upsettings(){
		$param = $this->input->post();
		if(!isset($param['minusernum']) &&!isset($param['addusertime']) && !isset($param['calltime'])){
			$this->renderjson(1,'参数错误');
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Rollcall.updateSettings')->addParams($param)->request();
		if($res === FALSE){
			$this->renderjson(1,'保存失败');
		} else {
			$this->renderjson(0,'保存成功');
		}
	}
}