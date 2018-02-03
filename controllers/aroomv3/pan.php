<?php
/**
 * 网校云盘分配空间情况控制器
 */
class PanController extends ARoomV3Controller {

	/**
	 *获取网校云盘总体情况表
	 */
	public function getPanInfo() {
		if (empty($this->roominfo['crid'])) {
			$this->renderjson(-2,'no crid',array());
		}
		$panModel = $this->model('pan');
		$res = $panModel->getClassroomPaninfo($this->roominfo['crid']);
		if ($res) {
			$maxsize = $panModel->getMaxCridPanUsesize($this->roominfo['crid']);//某用户最大的使用量
			$res['maxsize']= ceil($maxsize['maxsize']/1048576);//单位兆
			$res['totalpansize'] = floor($res['totalpansize']/1048576);//单位兆
			$res['usepansize'] = ceil($res['usepansize']/1048576);//单位兆
			$res['defaultpansize'] = ceil($res['defaultpansize']/1048576);//单位兆
			if ($res['defaultpansize'] == 0) {
				$res['defaultpansize'] = 1024;
			}
			$this->renderjson(0,'success',$res);
		} else {
			$this->renderjson(-1,'false',array());
		}
	}

	/**
	 *网校管理后台分配每个学生默认的云盘使用量
	 */
	public function setPanInfo() {
		if (empty($this->roominfo['crid'])) {
			$this->renderjson(-2,'no crid',array());
		}
		$param['defaultpansize'] = intval($this->input->post('defaultpansize'));
		$param['crid'] = $this->roominfo['crid'];
		$res = $this->model('pan')->setClassroomPaninfo($param);
		if ($res == 1) {
			$this->renderjson(0,'success',$res);
		} elseif ($res == -1) {//某用户最大使用量已经超过这个了
			$this->renderjson(-1,'某用户最大使用量已经超过这个了',array());
		} else if ($res == 0) {
			$this->renderjson(-1,'容量已经超过最大的1000G',array());
		} else if ($res == -3){
			$this->renderjson(-1,'设置的不能比分配到的大',array());
		} else {
			$this->renderjson(-1,'false',array());
		}
	}

	/**
	 *获取已分配的用户列表
	 */
	public function getUserPanInfos() {
		$parameters = array();
        $parameters['crid'] = $crid = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $parameters['q'] = $this->input->get('q');
        $forWho = $this->input->get('forwho');
        if ($forWho == 'Teacher') {
        	$serviceUrl = 'Aroomv3.Teacher.list';
        } else {
        	$serviceUrl = 'Aroomv3.Student.list';
        }
        $result = $this->apiServer->reSetting()->setService($serviceUrl)->addParams($parameters)->request();
        if (empty($result['list'])) {
        	$this->renderjson(-2,'no people',array());
        } else {
        	$uidStr = '';
        	foreach ($result['list'] as $key => $value) {
        		$uidStr .= intval($value['uid']).',';
        	}
        	$user_pan_infos = $this->model('pan')->getCridPanUserinfos(substr($uidStr, 0,-1),$crid);
        	if ($user_pan_infos) {
        		foreach ($user_pan_infos as $value) {
        			$userlist[$value['uid']] = $value;
        		}
        		foreach ($result['list'] as &$rvalue) {
        			if (isset($userlist[$rvalue['uid']])) {
        				$rvalue['filesize'] = round($userlist[$rvalue['uid']]['filesize']/1073741824,1);
        			} else {
        				$rvalue['filesize'] = 0;
        			}
        		}
        	} else {
        		foreach ($result['list'] as &$rvalue) {
    				$rvalue['filesize'] = 0;
        		}
        	}
        }
        $this->renderjson(0,'',$result);
	}

	/**
	 *某网校删除用户后对应的云盘记录删除，网校的云盘数据修改
	 */
	public function delUserpan() {
		$uid = intval($this->input->post('uid'));
		$crid = $this->roominfo['crid'];
		if (!$uid) {
			$this->renderjson(-3,'no uid',array());
		}
		if (empty($this->roominfo['crid'])) {
			$this->renderjson(-2,'no crid',array());
		}
		$panModel = $this->model('pan');
		$res = $panModel->delUserpanModel(array('crid' => $crid, 'uid' => $uid));
		if ($res) {
			$this->renderjson(0,'success',array());
		} else {
			$this->renderjson(-1,'false',array());
		}
	}

	

}