<?php
/**
 * 云盘管理控制器
 */
class YunpanController extends CControl {
	public function __construct(){
		parent::__construct();
        Ebh::app()->room->checkRoomControl();
	}

	/**
	 * 云盘文件列表
	 */
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['role'] = 'teach';
		$status = $this->input->get('status');
		if ($status == 1){//未审核
			$param['cat'] = 0;
		} elseif ($status == 2){//已通过
			$param['teach_status'] = 1;
			$param['cat'] = -1;
		} elseif ($status == 3){//未通过
			$param['teach_status'] = 2;
			$param['cat'] = -1;
		} else {
			$param['cat'] = -1;
		}
		$startdate = $this->input->get('sdate');
		$enddate = $this->input->get('edate');
		$param['startdate'] = strtotime($startdate);
		$param['enddate'] = empty($enddate)?'':strtotime($enddate)+86400;

		$filelist = $this->model('yunpan')->getFileList($param);
		$filecount = $this->model('yunpan')->getFileCount($param);
		$uid_array = array();
		$users = array();
		foreach($filelist as $value)
		{
			$uid_array[] = $value['uid'];
		}
		$users = $this->model('user')->getUserArray($uid_array);
		foreach($filelist as $key => $value)
		{
			$filelist[$key]['username'] = $users[$value['uid']]['username'];
			$filelist[$key]['realname'] = $users[$value['uid']]['realname'];
			$filelist[$key]['size'] = $this->_format_bytes($value['size']);
			$filelist[$key]['k'] = $this->_getpankey($value['fileid']);
			$filelist[$key]['teach_status'] = empty($value['teach_status']) ? 0 : $value['teach_status'];
			$filelist[$key]['teach_reamrk'] = empty($value['teach_reamrk']) ? '' : $value['teach_reamrk'];
		}

		$pagestr = show_page($filecount);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('status', $status);
		$this->assign('filelist', $filelist);
		$this->assign('pagestr', $pagestr);
		$this->display('aroomv2/yunpan');
	}

	/**
	 * 获取文件审核详情
	 * @return [type] [description]
	 */
	public function getfile(){
		$fileid = $this->input->post('fileid');
		$file = $this->model('yunpan')->getFileById($fileid);
		if (!empty($file)){
			$userinfo = $this->model('user')->getuserbyuid($file['uid']);
			if (!empty($userinfo)){
				$file['username'] = $userinfo['username'];
				$file['realname'] = $userinfo['realname'];
				$file['size'] = $this->_format_bytes($file['size']);
				$file['dateline'] = date("Y-m-d H:i:s", $file['dateline']);
				$file['teach_dateline'] = date("Y-m-d H:i:s", $file['teach_dateline']);
			}
			echo json_encode(array('code'=>1, 'file'=>$file));
		}
		else{
			echo json_encode(array('code'=>0));
		}
	}
	/**
	 * 审核
	 */
	public function checkprocess(){
		$user = Ebh::app()->user->getloginuser();
		$toid = $this->input->post('toid');
		$roominfo = Ebh::app()->room->getcurroom();
		//验证文件所属学校
		$file = $this->model('yunpan')->getOneFile(array('fileid'=>$toid, 'crid'=>$roominfo['crid']));
		if (empty($file)) {
			echo json_encode(array('code'=>0));
			exit;
		}

		$teach_status = $this->input->post('teach_status');
		$teach_remark = $this->input->post('teach_remark');
		$teach_remark = empty($teach_remark) ? '' : $teach_remark;
		$param = array(
			'role'			=> 'teach',
			'teach_uid' 	=> $user['uid'],
			'teach_status'	=> $teach_status,
			'teach_remark'	=> $teach_remark,
			'toid'			=> $toid,
			'teach_ip'		=> getip(),
			'type'			=> 11
		);
		$res = $this->model('yunpan')->check($param);
		if($res !== FALSE)
			echo json_encode(array('code'=>1));
		else
			echo json_encode(array('code'=>0));

	}



	//计算文件大小，转换成B,KB,MB,GB,TB格式
	function _format_bytes($size) {
		if ($size == 0) return 0;
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
		return round($size, 2) . $units[$i];
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
}