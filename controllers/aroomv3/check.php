<?php
/**
 * 各种审核接口
 */
class CheckController extends ARoomV3Controller {

	/**
	 *课件审核
	 */
	public function getCourseList(){
		$parameters = $this->buildPostParam();
		$parameters['authkey'] = $this->_getauthkey();
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.coursewareList')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 *附件审核
	 */
	public function attachment(){
		$parameters = $this->buildPostParam();
		$parameters['authkey'] = $this->_getauthkey();
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.attachment')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 *云盘审核
	 */
	public function pan(){
		$parameters = $this->buildPostParam();
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.panList')->addParams($parameters)->request();
		if (!empty($result['list'])) {
			foreach ($result['list'] as &$value) {
				$value['k'] = $this->_getpankey($value['fileid']);
			}
		}
		$this->renderjson('0','',$result);
	}

	/**
	 *新作业
	 */
	public function homeworkv2(){
		$parameters = $this->buildPostParam();
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.homeworkv2')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 *详情
	 */
	public function view(){
		$get = $this->input->get();
		$parameters['cwid'] = empty($get['cwid'])?0:intval($get['cwid']);
		$parameters['attid'] = empty($get['attid'])?0:intval($get['attid']);
		$parameters['eid'] = empty($get['eid'])?0:intval($get['eid']);
		$parameters['fileid'] = empty($get['fileid'])?0:intval($get['fileid']);
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.view')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 *审核接口
	 */
	public function checkprocess(){
		$post = $this->input->post();
		$parameters['toid'] = empty($post['toid'])?0:intval($post['toid']);
		$parameters['ip'] = getip();
		$parameters['teach_status'] = empty($post['teach_status'])?0:intval($post['teach_status']);
		$parameters['type'] = empty($post['type'])?0:intval($post['type']);
		$parameters['teach_remark'] = empty($post['teach_remark'])?'':$post['teach_remark'];
		$parameters['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.checkprocess')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 *多个审核接口
	 */
	public function multcheckprocess(){
		$post = $this->input->post();
		$parameters['ids'] = empty($post['ids'])?'':$post['ids'];
		$parameters['ip'] = getip();
		$parameters['teach_status'] = empty($post['teach_status'])?0:intval($post['teach_status']);
		$parameters['type'] = empty($post['type'])?0:intval($post['type']);
		$parameters['teach_remark'] = empty($post['teach_remark'])?'':$post['teach_remark'];
		$parameters['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.multcheckprocess')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 *撤销接口
	 */
	public function revoke(){
		$post = $this->input->post();
		$parameters['toid'] = empty($post['toid'])?0:intval($post['toid']);
		$parameters['status'] = empty($post['status'])?0:intval($post['status']);
		$parameters['teach_status'] = empty($post['teach_status'])?0:intval($post['teach_status']);
		$parameters['type'] = empty($post['type'])?0:intval($post['type']);
		$parameters['teach_remark'] = empty($post['teach_remark'])?'':$post['teach_remark'];
		$parameters['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.revoke')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 *审核作业
	 */
	public function checkexam(){
		$post = $this->input->post();
		$parameters['toid'] = empty($post['toid'])?0:intval($post['toid']);
		$parameters['ip'] = getip();
		$parameters['teach_status'] = empty($post['teach_status'])?0:intval($post['teach_status']);
		$parameters['type'] = empty($post['type'])?0:intval($post['type']);
		$parameters['teach_remark'] = empty($post['teach_remark'])?'':$post['teach_remark'];
		$parameters['subject'] = empty($post['subject'])?'':$post['subject'];
		$parameters['uid'] = $this->user['uid'];
		$parameters['examuid'] = $post['uid'];
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.checkexam')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 * 删除处理
	 *
	 */
	public function delprocess(){
		$post = $this->input->post();
		$parameters['toid'] = empty($post['toid'])?0:intval($post['toid']);
		$parameters['type'] = empty($post['type'])?0:intval($post['type']);
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Data.delprocess')->addParams($parameters)->request();
		$this->renderjson('0','',$result);
	}

	/**
	 * 生成加密字符串
	 * @return string
	 */
	protected function _getauthkey(){
		$user = Ebh::app()->user->getAdminLoginUser();
		$password = $user['password'];
		$ip = $this->input->getip();
		$uid = $user['uid'];
		$keyStr = "$password\t$uid\t$ip";
		$encodestr =  authcode($keyStr,'ENCODE');	
		
		return urlencode($encodestr);
		
	}

	/**
	 * 生成云盘加密字符串
	 * @return string
	 */
	protected function _getpankey($fileid){
		$appid = 'kfsystem';
		$ip= $this->input->getip();
		$time = SYSTIME;
		$keyStr = "$appid\t$fileid\t$ip\t$time";
		$encodestr =  authcode($keyStr,'ENCODE');
		return urlencode($encodestr);
	}

	/**
	 *统一的post参数构建
	 */
	public function buildPostParam() {
		$get = $this->input->get();
		$parameters = $this->getPageInfo();
		if (!empty($get['q'])) {
			$parameters['q'] = $get['q'];
		}
		if (isset($get['cat'])) {
			$parameters['cat'] = intval($get['cat']);
		}
		if (isset($get['teach_status'])) {
			$parameters['teach_status'] = intval($get['teach_status']);
		}
		$parameters['crid'] = $this->roominfo['crid'];
		return $parameters;
	}
}
