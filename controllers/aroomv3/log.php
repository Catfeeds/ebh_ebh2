<?php
/**
 * 操作日志.
 * Author: ckx
 */
class LogController extends ARoomV3Controller{
    public function logList(){
		$data['crid'] = $this->roominfo['crid'];
		$data['starttime'] = $this->input->get('starttime');
		$data['endtime'] = $this->input->get('endtime');
		$data['q'] = $this->input->get('q');
		$data['pagesize'] = $this->input->get('pagesize');
		$data['page'] = $this->input->get('page');
		$data['detailtype'] = $this->input->get('detailtype');
        //当前网校类型
        $roomtype =Ebh::app()->room->getRoomType();
        if(!empty($roomtype)){
            $data['roomtype'] = $roomtype;
        }
		$loglist = $this->apiServer->reSetting()->setService('Aroomv3.Log.list')->addParams($data)->request();
        //根据ip查询城市名称
        if(!empty($loglist['loglist'])){
            $iplib = Ebh::app()->lib('IPaddress');
            foreach ($loglist['loglist'] as &$logs){
                $address = $iplib->find($logs['fromip']);//101.69.252.186
                if(!empty($address) && $address[0] == '中国') {
                    $logs['pcityname'] = empty($address[1]) ? $address[0] : $address[1];
                    $logs['cityname'] = empty($address[2]) ? (empty($address[1]) ? $address[0] : $address[1]) : $address[2];
                }
            }
        }
		$this->renderjson('',0,$loglist);
	}
	
	public function typeList(){
        //当前网校类型
        $roomtype =Ebh::app()->room->getRoomType();
        if(!empty($roomtype)){
            $data = array();
            $data['roomtype'] = $roomtype;
        }
		$typelist = $this->apiServer->reSetting()->setService('Aroomv3.Log.typeList')->addParams($data)->request();
		$this->renderjson('',0,$typelist);
	}
}