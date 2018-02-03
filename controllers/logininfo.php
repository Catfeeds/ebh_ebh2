<?php
/**
*登录信息
*/
class LogininfoController extends CControl{
	public function index(){
		$client = $this->input->getClient();
		if(empty($client)){
			$client = array();
		}
		$screen = '';
		if(NULL !== $this->input->cookie('sc'))
			$screen = $this->input->cookie('sc');
		$client['screen'] = $screen;
		
		$client['ismobile'] = in_array($client['system'], array('iPad','iPhone','Android')) ? 1 : 0;

		//查询城市
		$iplib = Ebh::app()->lib('IPaddress');
		$client['ip'] = '101.69.252.186';
		$address = $iplib->find($client['ip']);//101.69.252.186
		if(!empty($address)){
			// var_dump($address);
			$client['pcityname'] = $address[1];
			$client['cityname'] = $address[2];
		}
		
		//查询网络提供商
		$ispmodel = $this->model('Isp');
		$isp = $ispmodel->getIspType($client['ip']);
		$isparr = array('0'=>'未知',
						'1'=>'电信宽带',
						'2'=>'联通宽带',
						'3'=>'移动宽带',
						'4'=>'教育网',
						'5'=>'铁通宽带',
						'6'=>'网通宽带',
						'7'=>'长城宽带',
						'8'=>'中科网宽带',
						'9'=>'广电宽带',
						'10'=>'方正宽带',
						'11'=>'中邦宽带',
						'12'=>'华数宽带(杭州)',
						'13'=>'珠江宽带',
						'14'=>'油田宽带',
						'15'=>'东南宽带',
						'16'=>'金桥网宽带',
						'17'=>'盈联宽带',
						'18'=>'有线宽带',);
		if(!empty($isp)){
			$client['isp'] = $isp;
			$client['ispname'] = empty($isparr[$isp])?'未知':$isparr[$isp];
		}
		echo json_encode($client);
	}
}