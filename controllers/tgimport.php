<?php
/**
 *教师组导入
 *用学校管理员登录(先用学校管理员登录,要不然学校管理员没有编辑组的权限)
 */
class TgimportController extends CControl{
	public function index(){
		$postData = $this->input->post();
		if(empty($postData)){
			$this->_view();
			return;
		}
		
		$this->_init();//初始化
		$this->_getData();//从xls文件读取教师分组信息
		$this->_run();//运行导入
	}
	/**
	 *初始化
	 */
	private function _init(){
		set_time_limit(0);
		$this->data = array();
		$this->fields_map = array(
			'realname'=>2,
			'mobile'=>3,
			'groupname'=>1
		);
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(empty($roominfo) || empty($user)){
			echo '不在学校里或者没有登录';
			exit;
		}
		$this->crid = $roominfo['crid'];
		$this->uid = $user['uid'];
		$default = $this->input->post('d');
		if(!empty($default)){
			$this->groups = array('语文','数学','英语','物理','化学','生物','政治','历史','地理','通用技术','信息技术','音乐','体育','美术');
		}
		$postData = $this->input->post();
		$upfilepath = explode(',',$postData['xls']['upfilepath']);
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$this->filepath = $_UP['attachment']['savepath'].$upfilepath[1];
	}
	
	private function _getData(){
		$reader = Ebh::app()->lib('PhpExcelReader');
		$reader->setOutputEncoding('UTF-8');
		$r = $reader->read($this->filepath);
		if($r === false) {	//不支持的文件格式
			$result['errormsg'] = '不支持的文件格式';
			return false;
		}
		$tmparr = array();
		for ($i = 2; $i <= $reader->sheets[0]['numRows']; $i++) {
			foreach ($this->fields_map as $fieldsName => $fieldValue) {
				$fvalue = !empty($reader->sheets[0]['cells'][$i][$fieldValue])?$reader->sheets[0]['cells'][$i][$fieldValue]:"";
				$tmparr[$fieldsName] = trim($fvalue);
			}
			array_push($this->data, $tmparr);
		}
	}

	private function _run(){
		if(empty($this->groups)){
			$groupnames = $this->_getFieldArr($this->data,'groupname');
			$this->groups = array_unique($groupnames);
		}
		//创建并且获取分组信息
		$this->groupsInfo = $this->_createGroup();
		if(empty($this->groupsInfo)){
			echo '组信息写入出错!';
			exit;
		}
		//获取教师用户信息
		$teacherModel = $this->model('teacher');
		$teachers = $teacherModel->getroomteacherlist($this->crid,array('limit'=>10000));
		//并入用户uid
		$this->data = $this->_merageTeacherInfo($teachers);

		//并入用户组信息
		$this->data = $this->_merageGroupInfo();

		//将教师添加到组
		$this->_addTeacherToGroup();

		//教师手机号修复
		$this->_fixTeacherMobile();

		echo 'ok';
	}

	private function _createGroup(){
		$tGroupsModel = $this->model('tgroups');
		//先删除组信息
		$whereArr = array(
			'crid'=>$this->crid
		);
		$tGroupsModel->_delete($whereArr);
		foreach ($this->groups as $gkey => $gvalue) {
			$param = array(
				'crid'=>$this->crid,
				'uid'=>$this->uid,
				'groupname'=>$gvalue,
				'displayorder'=>$gkey
			);
			$tGroupsModel->_insert($param);
		}
		return $tGroupsModel->getList(array('crid'=>$this->crid,'limit'=>1000));
	}

	//提取用户对应的信息合并
	private function _merageTeacherInfo($teachers){
		$newTeachers = array();
		foreach ($this->data as $dvalue) {
			foreach ($teachers as $teacher) {
				$realname1 = preg_replace("/\s/", "", $dvalue['realname']);
				$realname2 = preg_replace("/\s/", "", $teacher['realname']);
				if($realname1 == $realname2){
					$dvalue['uid'] = intval($teacher['uid']);
					$newTeachers[] = $dvalue;
					break;
				}
			}
		}
		return $newTeachers;
	}

	//将教师添加到组
	private function _addTeacherToGroup(){
		$params = $this->_getTgroupParam();
		$tgModel = $this->model('teachergroups');
		//先删除教师分组
		$whereArr = array(
			'crid'=>$this->crid
		);
		$tgModel->_delete($whereArr);
		foreach ($params as $param) {
			$tgModel->chooseTeachers($param);
		}
	}

	private function _merageGroupInfo(){
		$newTeachers = array();
		foreach ($this->data as $dvalue) {
			foreach ($this->groupsInfo as $group) {
				if($dvalue['groupname'] == $group['groupname']){
					$dvalue['groupid'] = intval($group['groupid']);
					$newTeachers[] = $dvalue;
					break;
				}
			}
		}
		return $newTeachers;
	}

	/**
	 *获取教师组信息参数,用于添加教师到组
	 */
	private function _getTgroupParam(){
		$this->tGroupParam = array();
		foreach ($this->data as $dvalue) {
			$key = 'groupid_'.$dvalue['groupid'];
			if(!array_key_exists($key, $this->tGroupParam)){
				$this->tGroupParam[$key] = array('groupid'=>$dvalue['groupid'],'crid'=>$this->crid,'tids'=>array());
			}
			$this->tGroupParam[$key]['tids'][] = $dvalue['uid'];
		}
		return $this->tGroupParam;
	}

	/**
	 *教师手机号补全
	 */
	private function _fixTeacherMobile(){
		$teacherModel = $this->model('teacher');
		foreach ($this->data as $dvalue) {
			$teacherModel->editteacher($dvalue);
		}
	}
	/**
	 *获取二维数组指定的字段集合
	 */
	private function _getFieldArr($param = array(),$filedName=''){
		
		$reuturnArr = array();

		if(empty($filedName)||empty($param)){
			return $reuturnArr;
		}

		foreach ($param as $value) {
			array_push($reuturnArr, $value[$filedName]);
		}

		return $reuturnArr;
	}

	private function _view(){
		$Upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('Upcontrol',$Upcontrol);
		$this->display('common/tgimport');
	}
}
?>