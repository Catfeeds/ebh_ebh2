<?php
/**
 * 微校通设置
 */
class EthsettingController extends CControl {
	public function __construct(){
		parent::__construct();
        Ebh::app()->room->checkRoomControl();
	}
	/**
	 * 菜单
	 */
	public function index() {
		$this->display('aroomv2/ethsetting');
	}

	/**
	 * 设置
	 */
	public function setting() {
		$roominfo = Ebh::app()->room->getcurroom();
		$config = $this->model('Eth')->getConfigByCrid($roominfo['crid']);

		$this->assign('config', $config);
		$this->assign('roominfo', $roominfo);
		$this->display('aroomv2/ethsetting_setting');
	}

	/**
	 * 保存设置
	 */
	public function savesetting() {
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$wxt = Ebh::app()->getConfig()->load('wxt');

		$param['phone'] = $this->input->post('phone');
		$param['marks'] = $this->input->post('marks');
		$param['appID'] = $this->input->post('appID');
		$param['appsecret'] = $this->input->post('appsecret');

		$param['token'] = $wxt['token'];
		$param['server_url'] = 'http://' . $wxt['domain'] . '/server.html';
		$param['domain'] = $wxt['domain'];

		$param['crid'] = $crid;
		$param['ebhcode'] = $this->_getebhcode($crid);
		$param['tempid'] = $this->input->post('tempid');

		$result = $this->model('Eth')->saveSetting($param);

		//验证
		if ($result){
			$url = 'http://'.$wxt['domain'].'/server/check.html?k=' . urlencode(authcode($crid, 'ENCODE'));
			$ret = do_post($url, array(), FALSE);
		}

		if (!empty($ret)){
			if ($ret->code == 1){
				$this->model('Eth')->saveSetting(array('crid'=>$crid,'isvalid'=>1));
				echo json_encode(array('code'=>1,'msg'=>'配置成功'));
				exit;
			} else {
				echo json_encode(array('code'=>0,'msg'=>$ret->msg));
				exit;
			}
		}
		echo json_encode(array('code'=>0,'msg'=>'配置失败'));
		exit;

	}

	/**
	 * 生成菜单
	 */
	public function makemenu() {
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$wxt = Ebh::app()->getConfig()->load('wxt');
		$url = 'http://'.$wxt['domain'].'/server/menu.html?k=' . urlencode(authcode($crid, 'ENCODE'));
		$ret = do_post($url, array(), FALSE);
		if (!empty($ret)){
			if ($ret->code == 1){
				$this->model('Eth')->saveSetting(array('crid'=>$crid,'ismenu'=>1));
				echo json_encode(array('code'=>1,'msg'=>'创建成功'));
				exit;
			} else {
				echo json_encode(array('code'=>0,'msg'=>$ret->msg));
				exit;
			}
		}
		echo json_encode(array('code'=>0,'msg'=>'创建失败'));
		exit;
	}

	/**
	 * 帮助
	 */
	public function help() {
		$this->user = Ebh::app()->user->getAdminLoginUser();
		$this->assign('user',$this->user);
		$roominfo = Ebh::app()->room->getcurroom();
        $this->assign('room', $roominfo);
		$roommodel = $this->model('classroom');
		$roomlist = $roommodel->getroomlistbytid($this->user['uid']);
		$this->assign('roomlist', $roomlist);
		$this->display('aroomv2/ethsetting_help');
	}

	private function _getebhcode($crid){
		$key = 'ebh'.$crid;
    	return  md5(sha1($key));
	}

}