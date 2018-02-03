<?php
/**
 *学校教师分组
 */
class TgroupsController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		Ebh::app()->room->checkteacher();
		$this->roominfo = Ebh::app()->room->getcurroom();
		$this->user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$this->roominfo);
	}
	/**
	 *分组列表页
	 */
	public function index(){
		//获取分组列表
		$param = parsequery();
		$param['crid'] = $this->roominfo['crid'];
		$tgroupsModel = $this->model('tgroups');
		$groupsList = $tgroupsModel->getList($param);
		$this->assign('groupsList',$groupsList);

		//获取分组列表和处理相关分页
		$groupsListCount = $tgroupsModel->getListCount($param);
		$pagestr = show_page($groupsListCount,$param['pagesize']);
		$this->assign('pagestr',$pagestr);

		//获取教室教师列表
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getroomteacherlist($this->roominfo['crid'],array('limit'=>1000));
		$this->assign('roomteacherlist',$roomteacherlist);

		//获取教师和组关联信息
		$teachergroups = $this->_getRoomGroupsInfo();
		$this->assign('teachergroups',$teachergroups);

		$this->display('aroomv2/tgroups');
	}
	/**
	 *添加分组页面显示
	 */
	public function addGroup(){
		$this->display('aroomv2/tgroups_add');
	}

	/**
	 *编辑分组页面显示
	 */
	public function editGroup_view(){
		//打开编辑页面之前判断权限
		$tgroupsModel = $this->model('tgroups');
		$group = $this->_checkPower();
		if(empty($group)){//无权限或者记录不存在
			show_404();exit;
		}
		$this->assign('group',$group);
		$this->display('aroomv2/tgroups_edit');
	}
	/**
	 *编辑或添加分组
	 */
	public function editGroupAjax(){
		//获取页面传过来的信息
		$rec = $this->input->post();

		//如果是修改则判断权限
		if(!empty($rec) && !empty($rec['groupid'])){
			$groupid = intval($rec['groupid']);
			$oldGroupDetail = $this->_checkPower($rec['groupid']);
			if($oldGroupDetail == false){
				show_404();exit;
			}
		}
		//处理页面传过来的参数
		$filteredParam = $this->_getParam($rec);

		//对处理后的参数进行判断
		$status = array();
		if($filteredParam['status']==0){
			$status['status'] = 0;
			$status['msg'] = $filteredParam['msg'];
			echo json_encode($status);
			exit;
		}
		//获取处理后的页面传过来的数据
		$param = $filteredParam['rec'];
		$tgroupsModel = $this->model('tgroups');

		if(!empty($groupid)){//修改，组织where参数
			$where = array(
				'groupid'=>$groupid
			);
			$effrows = $tgroupsModel->_update($param,$where);
		}else{//添加分组
			$effrows = $tgroupsModel->_insert($param);
		}
		
		//数据库处理结果反馈
		if(!empty($effrows)){
			$status['status'] = 1;
			$status['msg'] = '操作成功';
			echo json_encode($status);
		}else{
			$status['status'] = 0;
			$status['msg'] = '操作失败';
			echo json_encode($status);
		}

		/**写日志开始**/
		fastcgi_finish_request();
		if(empty($groupid)){
			$message = "添加学科分组 ".$param['groupname'];
			$opid = 1;
		}else{
			$message = "修改学科分组 ".$param['groupname'];
			$opid = 2;
		}
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['crid'],
				'message'=>$message,
				'opid'=>$opid,
				'type'=>'classroom'
				)
		);
		/**写日志结束**/
	}

	/**
	 *删除分组
	 */
	public function delGroupAjax(){
		$status = array();
		$groupid = $this->input->post('groupid');
		if(empty($groupid)){
			$status['status'] = 0;
			$status['msg'] = '删除失败！';
			echo json_encode($status);
			exit;
		}
		$groupDetail = $this->_checkPower($groupid);
		if(empty($groupDetail)){
			$status['status'] = 0;
			$status['msg'] = '权限验证失败，当前用户不是该分组的创建者！';
			echo json_encode($status);
			exit;
		}

		$effrows = $this->_delGroup($groupid);
		if($effrows>0){
			$status['status'] = 1;
			$status['msg'] = '删除成功！';
			echo json_encode($status);
		}else{
			$status['status'] = 0;
			$status['msg'] = '删除失败，请稍后再试！';
			echo json_encode($status);
		}

		/**写日志开始**/
		fastcgi_finish_request();
		$groupname = !empty($groupDetail['groupname'])?$groupDetail['groupname']:$groupid;
		$message = '删除学科分组 [ '.$groupname.' ] '.$status['msg'];
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$this->roominfo['crid'],
				'message'=>$message,
				'opid'=>4,
				'type'=>'classroom'
				)
		);
		/**写日志结束**/
	}

	/**
	 *分组添加教师
	 */
	public function addTeacherAjax(){
		$groupid = $this->input->post('groupid');
		$groupid = intval($groupid);

		$groupDetail = $this->_checkPower($groupid);
		if(empty($groupDetail)){
			$status['status'] = 0;
			$status['msg'] = '权限验证失败，当前用户不是该分组的创建者，或者分组不存在！';
			echo json_encode($status);
			exit;
		}

		//教师id处理
		$tids = $this->input->post('teacherids');
		$tidArr = $this->_filterTeacher($tids);

		//数据库参数处理
		$param = array(
			'groupid'=>$groupid,
			'tids'=>$tidArr,
			'crid'=>$this->roominfo['crid']
		);
		$effrows = $this->model('teachergroups')->chooseTeachers($param);
		if(!empty($effrows)){
			$status['status'] = 1;
			$status['msg'] = '操作成功';
			echo json_encode($status);
		}else{
			$status['status'] = 0;
			$status['msg'] = '操作失败';
			echo json_encode($status);
		}

		/**写日志开始**/
		fastcgi_finish_request();
		$groupname = !empty($groupDetail['groupname'])?$groupDetail['groupname']:$groupid;
		$message = '将教师 [ '.implode(',', $tidArr).' ] 设置为分组 [ '.$groupname.' ] 成员操作成功';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$this->roominfo['crid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'classroom'
				)
		);
		/**写日志结束**/
	}

	/**
	 *分组删除教师
	 */
	public function telTeacherAjax(){

	}
 	/**
 	 *分组删除
 	 */
	private function _delGroup($groupid = 0){
		$param = array(
			'groupid'=>$groupid
		);
		$tgroupsModel = $this->model('tgroups');
		$res = $tgroupsModel->_delete($param);
		if(!empty($res)){
			//删除分组下面关联的教师
			$teachergroupsModel = $this->model('teachergroups');
			//参数组织
			$param = array(
				'groupid'=>$groupid,
				'crid'=>$this->roominfo['crid']
			);
			$teachergroupsModel->_delete($param);
		}
		return $res;
	}

	/**
	 *获取父级分组下面的所有子分组
	 *无限级删除获取id合集预留
	 */
	private function _getChildren($groupid = 0){

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

	/**
	 *参数获取
	 */
	private function _getParam($param = array()){
		$paramArr = array('status'=>1);
		$param = $this->_checkParam($param);

		if($param['status'] ==0){
			$paramArr['status'] = 0;
			$paramArr['msg'] = $param['msg'];
			return $paramArr;
		}
		
		$paramArr['rec']['groupname'] = $param['rec']['groupname'];
		$paramArr['rec']['displayorder'] = $param['rec']['displayorder'];
		$paramArr['rec']['summary'] = $param['rec']['summary'];
		$paramArr['rec']['crid'] = $this->roominfo['crid'];
		$paramArr['rec']['uid'] = $this->user['uid'];
		return $paramArr;
	}
	/**
	 *参数检测
	 */
	private function _checkParam($param = array()){
		$returnArr = array('status'=>1,'rec'=>array());
		$param['groupname'] = h($param['groupname']);
		$param['displayorder'] = intval($param['displayorder']);
		$param['summary'] = h($param['summary']);

		if(empty($param['groupname']) || mb_strlen($param['groupname'],'UTF8')>=20 ){
			$returnArr['status'] = 0;
			$returnArr['msg'] = '分组名称不符合规范！';
			return $returnArr;
		}
		$returnArr['rec']['groupname'] = $param['groupname'];

		if($param['displayorder'] < 0){
			$returnArr['status'] = 0;
			$returnArr['msg'] = '排序不符合规范！';
			return $returnArr;
		}
		$returnArr['rec']['displayorder'] = $param['displayorder'];

		if(!empty($param['summary']) && mb_strlen($param['summary'],'UTF8')>=256 ){
			$returnArr['status'] = 0;
			$returnArr['msg'] = '分组介绍不符合规范！';
			return $returnArr;
		}
		$returnArr['rec']['summary'] = $param['summary'];

		$returnArr['rec']['upid'] = 0;

		return $returnArr;
	}
	/**
	 *权限检测
	 */
	private function _checkPower($groupid = 0){
		if(empty($groupid)){
			$groupid = intval($this->uri->itemid);
		}
		$param = array(
			'groupid'=>intval($groupid),
			'crid'=>$this->roominfo['crid'],
			'uid'=>$this->user['uid']
		);
		$tgroupsModel = $this->model('tgroups');
		$detail = $tgroupsModel->getGroupDetail($param);
		if(empty($detail)){
			return false;
		}
		return $detail;
	}

	/**
	 *教师参数处理,剔除非本校的教师,返回合法的教师id数组
	 *@param String $tids 格式 tid1,tid2,tid3
	 *@return Array 
	 */
	private function _filterTeacher($tids){
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getroomteacherlist($this->roominfo['crid'],array('limit'=>1000));
		//所有在该校的教师id数组
		$trueTidArr = $this->_getFieldArr($roomteacherlist,'uid');
		$tidArr = explode(',', $tids);
		return array_intersect($trueTidArr,$tidArr);
	}

	/**
	 *获取学校分组和分组对应的教师
	 */
	private function _getRoomGroupsInfo(){
		$tgModel = $this->model('teachergroups');
		$param = array(
			'crid'=>$this->roominfo['crid']
		);
		$tgroupsList = $tgModel->getList($param);
		$infoArr = array();
		foreach ($tgroupsList as $tgroup) {
			$key1 = 'groupid_tid_'.$tgroup['groupid'];
			$key2 = 'groupid_tname_'.$tgroup['groupid'];
			if(!array_key_exists($key1, $infoArr)){
				$infoArr[$key1] = array();
				$infoArr[$key1][]=$tgroup['tid'];
				$infoArr[$key2][]= !empty($tgroup['realname'])?$tgroup['realname']:$tgroup['username'];

			}else{
				$infoArr[$key1][]=$tgroup['tid'];
				$infoArr[$key2][]= !empty($tgroup['realname'])?$tgroup['realname']:$tgroup['username'];
			}
		}
		return $infoArr;
	}
}