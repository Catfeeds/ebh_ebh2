<?php
/**
*登录日志
*/
class LoginlogController extends CControl{
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$ak = $this->input->cookie('ak');
		$auth = $this->input->cookie('auth');
		//管理员进入学生/老师账号，不记日志
		if(empty($user) || ($user['groupid'] != 5 && $user['groupid'] != 6) || (!empty($ak) && $ak != $auth)){
			exit;
		}
		// $roominfo = Ebh::app()->room->getcurroom();
		$crid = $this->input->get('crid');
		$sessioncrid = $this->input->cookie('sessioncrid');
		$cridarr = empty($sessioncrid)?array():explode(',',$sessioncrid);
		if(!empty($crid) && !empty($user) && (empty($cridarr) || !in_array($crid,$cridarr))){
			$client = $this->input->getClient();
			if(empty($client)){
				$client = array();
			}
			$screen = '';
			if(NULL !== $this->input->cookie('sc'))
				$screen = $this->input->cookie('sc');
			$client['screen'] = $screen;
			$client['crid'] = $crid;
			$client['uid'] = $user['uid'];
			if(strtolower($client['browser']) == 'ie'){
				if(!empty($client['vendor'])){//ie内核的其他浏览器不记版本
					$client['broversion'] = '';
				}
				$client['browser'] = $client['browser'].$client['broversion'];
			}
			if(!empty($client['vendor'])){
				if(strtolower($client['browser']) == 'chrome'){//chrome内核的其他浏览器不记版本
					$client['broversion'] = '';
				}
				$client['browser'] = $client['vendor'];
				// $client['']
			}
			$client['ismobile'] = in_array($client['system'], array('iPad','iPhone','Android')) ? 1 : 0;

			//查询citycode
			$iplib = Ebh::app()->lib('IPaddress');
			$address = $iplib->find($client['ip']);//101.69.252.186
			$llmodel = $this->model('Loginlog');
			if(!empty($address) && $address[0] == '中国'){
				$cityname = empty($address[2])?$address[1]:$address[2];
				$city = $llmodel->getCityByName($cityname);
				if(!empty($city)){
					$spcityarr = array('11','12','31','50');
					if(in_array($city['citycode'],$spcityarr)){//直辖市,编号加01
						$city['citycode'] = $city['citycode'].'01';
					}
					//同时记录省市编号
					$client['citycode'] = $city['citycode'];
					$client['parentcode'] = substr($city['citycode'],0,2);
				}
			}
			//查询网络提供商
			$ispmodel = $this->model('Isp');
			$isp = $ispmodel->getIspId($client['ip']);
			if(!empty($isp)){
				$client['isp'] = $isp;
			}
			$llmodel->addLog($client);
			
			echo 'callback'.'('.json_encode(array('domain'=>$this->uri->curdomain)).')';
		}
	}
}