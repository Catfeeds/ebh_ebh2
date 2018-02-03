<?php
/*
签到
*/
class Sign{
	public function getSignStatus($param){
		$continuous = 0;
		$signed = 0;
		$monnum = 0;
		$credit = Ebh::app()->model('credit');
		$data['uid'] = $param['uid'];
		$data['crid'] = $param['crid'];
		$signlog = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Member.User.signList')->addParams($data)->request();
		// $signlog = $credit->getSignLog($signparam);
		if(!empty($signlog)){
			$lastsign = $signlog[0]['dateline'];
			$lastdate = strtotime(Date('Y-m-d',$lastsign));
			$today = strtotime('today');
			
			if($lastdate>=$today){//今天已签到
				$signed = 1;				
			}else{//今天未签到
				
			}
			$lastdate = $today;
				// var_dump($lastdate);
			$thismonth = Date('Y-m',SYSTIME);
			foreach($signlog as $sign){
				if($thismonth == Date('Y-m',$sign['dateline'])){
                    $monnum ++;
                }
				$date = strtotime(Date('Y-m-d',$sign['dateline']));
				if($lastdate-$date == 86400 || $lastdate == $date ){
					$lastdate = $date;
					$continuous ++;
				} /* else {
					break;
				} */
			}
		}
		return array('signed'=>$signed,'continuous'=>$continuous,'monnum'=>$monnum);
	}

	/*
	记录到签到表
	*/
	public function addSignLog(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$data['crid'] = $roominfo['crid'];
		$data['uid'] = $user['uid'];
		$data['ip'] = Ebh::app()->getInput()->getip();
		//查询citycode
		$iplib = Ebh::app()->lib('IPaddress');
		$address = $iplib->find($data['ip']);//101.69.252.186
		$llmodel = Ebh::app()->model('loginlog');
		if(!empty($address) && $address[0] == '中国'){
			$cityname = empty($address[2])?$address[1]:$address[2];
			$city = $llmodel->getCityByName($cityname);
			if(!empty($city)){
				$spcityarr = array('11','12','31','50');
				if(in_array($city['citycode'],$spcityarr)){//直辖市,编号加01
					$city['citycode'] = $city['citycode'].'01';
				}
					//同时记录省市编号
				$data['citycode'] = $city['citycode'];
				$data['parentcode'] = substr($city['citycode'],0,2);
			}
		}
		
		Ebh::app()->getApiServer('ebh')->reSetting()->setService('Member.User.sign')->addParams($data)->request();
	}
}
?>