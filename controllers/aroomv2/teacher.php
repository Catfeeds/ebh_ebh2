<?php
/*
学校教师
*/
class TeacherController extends CControl{
	public function __construct(){
		parent::__construct();
        Ebh::app()->room->checkRoomControl();
	}
	public function index(){
		$this->display('aroomv2/teacher');
//		$user = Ebh::app()->user->getloginuser();
//		$roominfo = Ebh::app()->room->getcurroom();
//		$teacher = $this->model('teacher');
//		$param = parsequery();
//		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],$param);
//		$teachercount = $teacher->getroomteachercount($roominfo['crid'],$param);
//		$pagestr = show_page($teachercount);
//		$this->assign('pagestr',$pagestr);
//		$this->assign('user',$user);
//		$this->assign('room',$roominfo);
//		$this->assign('search',$param['q']);
//		$this->assign('roomteacherlist',$roomteacherlist);
//		$this->display('aroomv2/teacher');
	}
	//教师分组列表
	public function groups(){
		$roominfo = Ebh::app()->room->getcurroom();
		//获取分组列表
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$tgroupsModel = $this->model('tgroups');
		$groupsList = $tgroupsModel->getList($param);
		$this->assign('groupsList',$groupsList);

		//获取分组列表和处理相关分页
		$groupsListCount = $tgroupsModel->getListCount($param);
		$pagestr = show_page($groupsListCount,$param['pagesize']);
		$this->assign('pagestr',$pagestr);

		//获取教室教师列表
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],array('limit'=>1000));
		$this->assign('roomteacherlist',$roomteacherlist);

		//获取教师和组关联信息
		$teachergroups = $this->_getRoomGroupsInfo();
		$this->assign('teachergroups',$teachergroups);

		$this->display('aroomv2/teacher_groups');
	}
	/**
	 *添加分组页面显示
	 */
	public function addGroup(){
		$this->display('aroomv2/tgroups_groups');
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
		$this->display('aroomv2/teacher_manages');
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
		
		$code = 1;
		$message = '该用户已修改';
		$arr = array('code'=>$code,'message'=>$message);
		echo json_encode($arr);exit;
		//数据库处理结果反馈
//		if(!empty($effrows)){
//			$status['status'] = 1;
//			$status['msg'] = '操作成功';
//			echo json_encode($status);
//		}else{
//			$status['status'] = 0;
//			$status['msg'] = '操作失败';
//			echo json_encode($status);
//		}

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
		$roominfo = Ebh::app()->room->getcurroom();
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
				'toid'=>$roominfo['crid'],
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
		$roominfo = Ebh::app()->room->getcurroom();
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
			'crid'=>$roominfo['crid']
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
				'toid'=>$roominfo['crid'],
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
		$roominfo = Ebh::app()->room->getcurroom();
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
				'crid'=>$roominfo['crid']
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
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
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
		$paramArr['rec']['crid'] = $roominfo['crid'];
		$paramArr['rec']['uid'] = $user['uid'];
		return $paramArr;
	}
	/**
	 *参数检测
	 */
	private function _checkParam($param = array()){
		$returnArr = array('status'=>1,'rec'=>array());
		$param['groupname'] = h($param['groupname']);
		$param['displayorder'] = empty($param['displayorder'])?0:intval($param['displayorder']);
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
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(empty($groupid)){
			$groupid = intval($this->uri->itemid);
		}
		$param = array(
			'groupid'=>intval($groupid),
			'crid'=>$roominfo['crid'],
			'uid'=>$user['uid']
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
		$roominfo = Ebh::app()->room->getcurroom();
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],array('limit'=>1000));
		//所有在该校的教师id数组
		$trueTidArr = $this->_getFieldArr($roomteacherlist,'uid');
		$tidArr = explode(',', $tids);
		return array_intersect($trueTidArr,$tidArr);
	}

	/**
	 *获取学校分组和分组对应的教师
	 */
	private function _getRoomGroupsInfo(){
		$roominfo = Ebh::app()->room->getcurroom();
		$tgModel = $this->model('teachergroups');
		$param = array(
			'crid'=>$roominfo['crid']
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

/*-------------------------------------------------------------------------------*/
	//教师管理
    public function	manages(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$teacher = $this->model('teacher');
		$param = parsequery();
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],$param);
		$teachercount = $teacher->getroomteachercount($roominfo['crid'],$param);
		$pagestr = show_page($teachercount);
		$this->assign('pagestr',$pagestr);
		$this->assign('user',$user);
		$this->assign('room',$roominfo);
		$this->assign('q',$param['q']);
		$this->assign('roomteacherlist',$roomteacherlist);
		$this->display('aroomv2/teacher_manages');
	}
	//添加教师
	public function add(){
		if($this->input->post()){
			$checkonly = $this->input->post('checkonly');
			$loginuser = Ebh::app()->user->getloginuser();
			$roominfo = Ebh::app()->room->getcurroom();
			$user = $this->model('user');
			$code = 0;
			$message = '';
			$username = $this->input->post('tname');
			$exists = $user->exists($username);



			if(!empty($exists)){
				$teacherinfo = $user->getuserbyusername($username);
				if($teacherinfo['groupid']==5){
					if($teacherinfo['uid'] == $loginuser['uid']){
						$code = 2;
						$message = '不能添加自己';
					}else{
						$classes = $this->model('classes');
						$classlist = $classes->getTeacherClassList($roominfo['crid'],$teacherinfo['uid']);
						//print_r($classlist);
						if(!empty($classlist)){
							$code = 2;
							$message = '该用户已经在这个教室';
						}elseif(!$checkonly){
							$teacher = $this->model('teacher');
							$param['tid'] = $teacherinfo['uid'];
							$param['crid'] = $roominfo['crid'];
							$param['status'] = 1;   
							$param['cdateline'] = SYSTIME;
							$param['role'] = 1;
							$teacher->addroomteacher($param);
							$code = 1;
							$message = '该用户已添加';
							$arr = array('code'=>$code,'message'=>$message);
							echo json_encode($arr);
							fastcgi_finish_request();

							//更新SNS网校用户缓存
							$snslib = Ebh::app()->lib('Sns');
							$snslib->updateRoomUserCache(array('crid'=>$roominfo['crid'],'uid'=>$teacherinfo['uid']));
							//同步SNS数据(用户网校操作)
							$snslib->do_sync($teacherinfo['uid'], 4);
							//header('location:'.geturl('aroomv2/teacher'));
							Ebh::app()->lib('xNums')->add('user');
        					Ebh::app()->lib('xNums')->add('teacher');
						}
					}
				}
				else{
					$code = 2;
					$message = '该用户不允许被添加';
				}
					
			}else{
				if(!$checkonly){
					$param['username'] = $username;
					$param['password'] = $this->input->post('pwd');
					$param['realname'] = $this->input->post('realname');
					$param['mobile'] = $this->input->post('mobile');
					$param['sex'] = $this->input->post('sex');
					$param['dateline'] = SYSTIME;
					$teacher = $this->model('teacher');
					$tid = $teacher->addteacher($param);
					
					$param['tid'] = $tid;
					$param['crid'] = $roominfo['crid'];
					$param['status'] = 1;
					$param['cdateline'] = SYSTIME;
					$param['role'] = 1;
					$teacher->addroomteacher($param);
                    //将注册信息记录到日志
                    if($tid){
                        $logdata = array();
                        $logdata['crid']= $param['crid'];
                        $logdata['uid']=$tid;
                        $logdata['logtype'] = 2;
                        $registerloglib=Ebh::app()->lib('RegisterLog');
                        $registerloglib->addOneRegisterLog($logdata);
                    }

					$code = 1;
					$message = '该新用户已添加';
					$arr = array('code'=>$code,'message'=>$message);
					echo json_encode($arr);
					fastcgi_finish_request();
					/**写日志开始**/
					Ebh::app()->lib('LogUtil')->add(
						array(
							'toid'=>$tid,
							'message'=>'添加教师'.$param['realname'],
							'opid'=>1,
							'type'=>'teacher'
							)
					);
					/**写日志结束**/

					//更新SNS网校用户缓存
					$snslib = Ebh::app()->lib('Sns');
					$snslib->updateRoomUserCache(array('crid'=>$roominfo['crid'],'uid'=>$tid));
					//同步SNS数据(用户网校操作)
					$snslib->do_sync($tid, 4);
					Ebh::app()->lib('xNums')->add('user');
        			Ebh::app()->lib('xNums')->add('teacher');
					//header('location:'.geturl('aroomv2/teacher'));
				}
				$code = 1;
				$message = '请为新用户设置密码';
				//
			}
			if($checkonly){
				$arr = array('code'=>$code,'message'=>$message);
				echo json_encode($arr);
			}
		}else{
			$this->display('aroomv2/teacher_manages');
		}
	}
	
	/*
	删除学校内教师
	*/
	public function deleteroomteacher(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['tid'] = $this->input->post('tid');
		$param['crid'] = $roominfo['crid'];
		$classlist = $this->model('classes')->getTeacherClassList($param['crid'], $param['tid']);
		$teacher = $this->model('teacher');
		$res = $teacher->deleteroomteacher($param);
		if($res)
			echo json_encode(array('code'=>1,'message'=>'删除成功'));
		else
			echo json_encode(array('code'=>0,'message'=>'删除失败'));

		/**写日志开始**/
		fastcgi_finish_request();
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['tid'],
				'message'=>'删除教师(tid:'.$param['tid'].')',
				'opid'=>4,
				'type'=>'teacher'
				)
		);
		/**写日志结束**/

		if($res){
			//删除缓存
			Ebh::app()->lib('xNums')->add('teacher',-1);
			$snslib = Ebh::app()->lib('Sns');
			$snslib->delRoomUserCache(array('crid'=>$param['crid'],'uid'=>$param['tid']));
			if (!empty($classlist))
			{
				foreach ($classlist as $class)
				{
					$snslib->delClassUserCache(array('classid'=>$class['classid'],'uid'=>$param['tid']));
				}
			}
			//同步SNS数据(用户网校操作)
			$snslib->do_sync($param['tid'], 4);
		}
	}
	
	public function edit_view(){
		$teacher = $this->model('teacher');
		$uid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$teacherdetail = $teacher->getroomteacherdetail($uid,$crid);
		if(empty($teacherdetail)){
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "该教师不存在或已删除";
                echo '<a href="'. $url.'">返回</a>';
                exit;
            }
		$this->assign('teacherdetail',$teacherdetail);
		$this->display('aroomv2/teacher_manages');
	}
	
	public function edit(){
		$teacher = $this->model('teacher');
		$param['uid'] = $this->input->post('uid');
		$param['realname'] = $this->input->post('realname');
		$param['sex'] = $this->input->post('sex');
		$param['mobile'] = $this->input->post('mobile');
		$teacher->editteacher($param);
		$code = 1;
		$message = '该用户已修改';
		$arr = array('code'=>$code,'message'=>$message);
		echo json_encode($arr);exit;
		/**写日志开始**/
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['uid'],
				'message'=>json_encode($param),
				'opid'=>2,
				'type'=>'teacher'
				)
		);
		/**写日志结束**/
		//header('location:'.geturl('aroomv2/teacher_manages'));
	}
	
	/*
	修改密码
	*/
	public function editpass(){
		$param['uid'] = $this->input->post('uid');
		//教师id处理(教师id是否存在本校的教师列表里)
		$tid = $this->_filterTeacher($param['uid']);
		if(!empty($tid)){
			$param['password'] = $this->input->post('password');
			$teacher = $this->model('teacher');
			$res = $teacher->editteacher($param);
			echo isset($res);
		}
		/**写日志开始**/
		//fastcgi_finish_request();
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['uid'],
				'message'=>'修改密码',
				'opid'=>2,
				'type'=>'teacher'
				)
		);
		/**写日志结束**/
	}
	public function input(){//var_dump($this->input->post());exit;
		if($this->input->post()){
		$errormsg = '';
		$inputresult = array('result'=>false,'hasresult'=>false,'errormsg'=>$errormsg);
		if(empty($_FILES) || empty($_FILES['inputfile']) || empty($_FILES['inputfile']['tmp_name'])) {
			$errormsg = '错误：请选择要上传的文件';
		} else if(is_uploaded_file($_FILES['inputfile']['tmp_name']) && $this->checkupload($_FILES['inputfile'])) {
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$up_type = 'temp';
			$destination_folder="/uploads/";
			if(!empty($_UP[$up_type]['savepath'])){
				$destination_folder = $_UP[$up_type]['savepath'];
			}
			$dest_path  = $this->getdirurl($destination_folder);	
			$path_info = pathinfo($_FILES['inputfile']['name']);
			$file_extension = $path_info["extension"];
			$tmpname = time().'_'.mt_rand().'.'.$file_extension;
			$filesavepath = $destination_folder.$dest_path.$tmpname;
			if(move_uploaded_file($_FILES['inputfile']["tmp_name"], $filesavepath)) {
				$roominfo = Ebh::app()->room->getcurroom();
				$iresult = $this->inputteacher($filesavepath,$roominfo['crid']);
				if(!empty($iresult['errormsg']) || !empty($iresult['erroritems'])) {	//导入不成功
					$inputresult['result'] = false;
					$inputresult['hasresult'] = true;
					$errormsg = empty($iresult['errormsg'])?'':$iresult['errormsg'];
					$inputresult['erroritems'] = empty($iresult['erroritems'])?'':$iresult['erroritems'];
				} else {
					$inputresult['result'] = true;
					$inputresult['hasresult'] = true;
					$inputresult['rowcount'] = $iresult['rowcount'];
				}
			}
		} else {
			$errormsg = '错误：只允许上传xls格式文件，且文件小于5M';
		}
		// $_SGLOBAL['tpl_folder'] = 'aroom';
		$inputresult['errormsg'] = $errormsg;
		$this->assign('inputresult',$inputresult);

			/**写日志开始**/
			Ebh::app()->lib('LogUtil')->add(
				array(
					'toid'=>$roominfo['crid'],
					'message'=>'批量导入教师['.(!empty($inputresult['result'])?'成功':'失败').']',
					'opid'=>1,
					'type'=>'classroom'
					)
			);
			/**写日志结束**/
		}
		
		$this->display('aroomv2/manage');

	}
	/*
	 * 获取存储附件路径
	 */
	function getdirurl($dest_folder = '') {
		$timestamp=time();
		$destination_folder=empty($dest_folder)?("/uploads/"):$dest_folder;
	//以天存档
		$yearpath=Date('Y', $timestamp)."/";
		$monthpath=$yearpath.Date('m', $timestamp)."/";
		$dayspath = $monthpath.Date('d', $timestamp)."/";
		if(!file_exists($destination_folder))
		mkdir($destination_folder);
		if(!file_exists($destination_folder.$yearpath))
		mkdir($destination_folder.$yearpath);
		if(!file_exists($destination_folder.$monthpath))
		mkdir($destination_folder.$monthpath);
		if(!file_exists($destination_folder.$dayspath))
		mkdir($destination_folder.$dayspath);
		return  ltrim($dayspath,'.');
		
	}
	/**
	*导入教师
	*步骤如下：
	*1，判断excel格式
	2，获取excel标题栏信息
	3，
	*/
	function inputteacher($filepath,$crid) {
		$user = $this->model('user');
		$teacher = $this->model('teacher');
		$roomteacher = $this->model('roomteacher');

		$result = array('result'=>false);
		
		$reader = Ebh::app()->lib('PhpExcelReader');
		
		$reader->setOutputEncoding('UTF-8');
		$r = $reader->read($filepath);
		if($r === false) {	//不支持的文件格式
			$result['errormsg'] = '不支持的文件格式';
			return $result;
		}
		$rowcount = 0;	//导入行数
		$titlerownum = 1;
	//	教师姓名	登录账号	密码	联系方式
		$realnamecol = 0;
		$usernamecol = 0;
		$passwordcol = 0;
		$mobilecol = 0;
		$sexcol = 0;
		$schoolnamecol = 0;
		for ($i = 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $reader->sheets[0]['numCols']; $j++) {	//找到标题行
				$colval = trim($reader->sheets[0]['cells'][$i][$j]);
				$colval = str_replace(' ','',$colval);
				if($colval == '教师姓名') {
					$realnamecol = $j;
				} else if($colval == '登录账号') {
					$usernamecol = $j;
				} else if($colval == '密码') {
					$passwordcol = $j;
				} else if($colval == '联系方式') {
					$mobilecol = $j;
				} else if($colval == '所教班级') {
					$classescol = $j;
				} else if($colval == '所教课程') {
					$coursescol = $j;
				} else if($colval == '性别') {
					$sexcol = $j;
				} else if($colval == '学校名称'){
					$schoolnamecol = $j;
				}
			}
			if(!empty($realnamecol) && !empty($usernamecol) && !empty($passwordcol) && !empty($mobilecol)) {	//找到标题行
				$titlerownum = $i;
				break;
			}
		}
		if($titlerownum == 0) {
			$result['errormsg'] = '文件内容不正确，请按照系统提供的导入模板格式进行上传。';
			return $result;
		}
		
		$userlist = array();	//先取出教师用户列表

		$usernameinlist = '';	//以字符串形式获取用户名连接符，如user01,user02
		
		if($realnamecol == 0)
			$realnamecol_err = 1;
		if($usernamecol == 0)
			$usernamecol_err = 1;
		if($passwordcol == 0)
			$passwordcol_err = 1;
		if($mobilecol == 0)
			$mobilecol_err = 1;
		$uniqueclasses = array();
		$uniquecourses = array();
		for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			if(!empty($reader->sheets[0]['cells'][$i])){
			$realname = empty($realnamecol_err)?$reader->sheets[0]['cells'][$i][$realnamecol]:'';
			$realname = trim($realname);
			$username = empty($usernamecol_err)?$reader->sheets[0]['cells'][$i][$usernamecol]:'';
			$username = trim($username);
			$password = empty($passwordcol_err)?$reader->sheets[0]['cells'][$i][$passwordcol]:'';
			$password = trim($password);
			$mobile = empty($mobilecol_err)&&!empty($reader->sheets[0]['cells'][$i][$mobilecol])?$reader->sheets[0]['cells'][$i][$mobilecol]:'';
			$mobile = trim($mobile);
			$classes = !empty($classescol)&&!empty($reader->sheets[0]['cells'][$i][$classescol])?$reader->sheets[0]['cells'][$i][$classescol]:'';
			$classes = trim($classes);
			$courses = !empty($coursescol)&&!empty($reader->sheets[0]['cells'][$i][$coursescol])?$reader->sheets[0]['cells'][$i][$coursescol]:'';
			$courses = trim($courses);
			$sex = !empty($sexcol)&&!empty($reader->sheets[0]['cells'][$i][$sexcol])?$reader->sheets[0]['cells'][$i][$sexcol]:'';
			$sex = trim($sex);
			$schoolname = !empty($schoolnamecol)&&!empty($reader->sheets[0]['cells'][$i][$schoolnamecol])?$reader->sheets[0]['cells'][$i][$schoolnamecol]:'';
			$schoolname = trim($schoolname);
			if(empty($realname) || empty($username) || empty($password)) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，教师姓名、登录账号、密码不能为空，请修改文件后重新上传';
				break;
			}
		
			if(strlen($realname) > 30 || strlen($username) > 16) {
				$result['errormsg'] = '第 '.$i.' 行 姓名或登录账号太长，请调整。';
				break;
			}
			if(!preg_match('/^[a-zA-Z_][a-z0-9A-Z_]{5,16}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-16位英文、数字、“_”的组合字符，且首字母不能为数字，请调整。';
				break;
			}
			if(strlen($password) < 6 || strlen($password) > 16 || $password == '123456') {
				$result['errormsg'] = '第 '.$i.' 行 账号密码不能为123456。且长度6-16位，区分大小写。';
				break;
			}
			if(strlen($mobile) > 25) {
				$result['errormsg'] = '第 '.$i.' 行 联系方式太长，请不要超过25个字符';
				break;
			}
			if(trim($sex) == '女')
				$sex = 1;
			else
				$sex = 0;
			$realname = str_replace('\'','',$realname);
			$username = str_replace('\'','',$username);
			$schoolname = str_replace('\'','',$schoolname);
			if (isset($userlist[$username])) {
				$preuser = $userlist[$username];
				$prerow = $preuser['rownum'];
				$result['errormsg'] = '第 '.$prerow.' 与 '.$i.' 行 登录账号重复，请调整。';
				break;
			}
			$mobile = str_replace('\'','',$mobile);
			
			$classarr = array();
			if(!empty($classes)){
				$classes = str_replace('，',',',$classes);
				$classarr = explode(',',$classes);
				foreach($classarr as $class){
					if(empty($uniqueclasses[$class]))
						$uniqueclasses[$class] = 0;
				}
			}
			
			$coursearr = array();
			if(!empty($courses)){
				$courses = str_replace('，',',',$courses);
				$coursearr = explode(',',$courses);
				foreach($coursearr as $course){
					if(empty($uniquecourse[$course]))
						$uniquecourses[$course] = 0;
				}
			}
			if(empty($usernameinlist))
				$usernameinlist = '\''.$username.'\'';
			else
				$usernameinlist .= ','. '\''.$username.'\'';
			$userlist[$username] = array('rownum'=>$i,'realname'=>$realname,'username'=>$username,'password'=>$password,'mobile'=>$mobile,'classes'=>$classarr,'courses'=>$coursearr,'sex'=>$sex,'schoolname'=>$schoolname);
			$rowcount ++;
			
			}
			
		}
		if (!empty($result['errormsg'])) {
			return $result;
		}
		if (empty($usernameinlist)) {
			$result['errormsg'] = '读取文件过程出错，若文件记录数过大，您可以将文件分拆后再上传。';
			return $result;
		}
		$usernamearr = $user->getuserlistbyusername($usernameinlist);
		if(!empty($usernamearr)) {	//重复账号判断
			$result['erroritems'] = array();
			foreach($usernamearr as $uname) {
				if(isset($userlist[$uname['username']])) {
					$result['erroritems'][] = '第 '.$userlist[$uname['username']]['rownum'].' 行 账号 '.$uname['username'].' 已存在';
				}
			}
			// return $result;
		}
		$classes = $this->model('classes');
		foreach($uniqueclasses as $k=>$v){
			$res = $classes->getClassByClassname(array('crid'=>$crid,'classname'=>$k));
			
			if(empty($res)){
				foreach($userlist as $ul){
					if(in_array($k,$ul['classes']))
						$result['erroritems'][] = '第 '.$ul['rownum'].' 行 班级 '.$k.' 不存在';
				}
			}else{
				$uniqueclasses[$k] = $res['classid'];
			}
		}
		$folder = $this->model('folder');
		foreach($uniquecourses as $k=>$v){
			$res = $folder->getFolderByFoldername(array('crid'=>$crid,'foldername'=>$k));
			
			if(empty($res)){
				foreach($userlist as $ul){
					if(in_array($k,$ul['courses']))
						$result['erroritems'][] = '第 '.$ul['rownum'].' 行 课程 '.$k.' 不存在';
				}
			}else{
				$uniquecourses[$k] = $res['folderid'];
			}
		}
		if(!empty($result['erroritems'])){
			return $result;
		}
		
		//导入数据开始
		$tarr = array();
		$roomtarr = array();
		$classtarr = array();
		$foldertarr = array();
		foreach($userlist as $iuser) {	//导入数据
			$username = $iuser['username'];
			$realname = $iuser['realname'];
			$password = $iuser['password'];
			$sex = $iuser['sex'];
			$mobile = $iuser['mobile'];
			$schoolname = $iuser['schoolname'];
			// $param = array('username'=>$username,'realname'=>$realname,'password'=>$password,'mobile'=>$mobile);
			//生成教师账号
			// $tid = $teacher->addteacher($param);
			
			$tarr[] = array('username'=>$username,'realname'=>$realname,'password'=>$password,'mobile'=>$mobile,'sex'=>$sex,'schoolname'=>$schoolname);
			
			//生成教师教室关联关系
			// $param['tid'] = $tid;
			$param['status'] = 1;
			$param['crid'] = $crid;
			$param['cdateline'] = SYSTIME;
			
			// $inresult = $teacher->addroomteacher($param);
			
			// foreach($iuser['classes'] as $class){
				// $param['classid'] = $uniqueclasses[$class];
				// $classes->addTeacherToClass($param);
			// }
			// foreach($iuser['courses'] as $course){
				// $param['folderid'] = $uniquecourses[$course];
				// $folder->addTeacherToFolder($param);
			// }
			$temparr = array();
			foreach($iuser['classes'] as $class){
				$temparr[] = $uniqueclasses[$class];
			}
			$temparr2 = array();
			foreach($iuser['courses'] as $course){
				$temparr2[] = $uniquecourses[$course];
			}
			$classtarr[]['classidarr'] = $temparr;
			$foldertarr[]['folderidarr'] = $temparr2;
		}

		$teanum = count($tarr);
		$fromuid = $teacher->addMultipleTeachers($tarr,$crid);

		for($i=0;$i<$teanum;$i++){
			$classtarr[$i]['uid'] = $fromuid + $i;
			$foldertarr[$i]['uid'] = $fromuid + $i;
		}
        //将批量注册信息记录到日志
        if($fromuid){
            $logdatas = array();
            for($i=0;$i<$teanum;$i++) {
                $logdatas[$i]['crid'] = $crid;
                $logdatas[$i]['uid'] = $foldertarr[$i]['uid'];
                $logdatas[$i]['logtype'] = 2;
            }
            $registerloglib=Ebh::app()->lib('RegisterLog');
            $registerloglib->addMultipleRegisterLog($logdatas);
        }
		$classes->addTeacherToClass($classtarr);
		$folder->addTeacherToFolder($foldertarr,$crid);
		Ebh::app()->lib('xNums')->add('user',$teanum);
        Ebh::app()->lib('xNums')->add('teacher',$teanum);

		$result['rowcount'] = $rowcount;
		//生成数据
		return $result;
	}
	
	/**
	*检测导入的excel文件内容是否合法
	*/
	function checkupload($up) {
		$MAX_FILENAME_LENGTH = 260;
		$max_file_size_in_bytes = 5242880;				// 5M
		$allow_extensions = array('xls'); //only allow excel file extension
		$valid_chars_regex = '.A-Z0-9_-';				// file name allow characters
		
		if (empty($up)) {
			return false;
		} else if (isset($up["error"]) && $up["error"] != 0) {
			return false;
		} else if (!isset($up["tmp_name"]) || !@is_uploaded_file($up["tmp_name"])) {
			return false;
		} else if (!isset($up['name'])) {
			return false;
		}
		$file_size = @filesize($up["tmp_name"]);
		if (!$file_size)
			$file_size = 128;
		if (!$file_size || $file_size > $max_file_size_in_bytes) {
			return false;
		}
		if ($file_size <= 0) {
			return false;
		}
		$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($up['name']));
		if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
			return false;
		}
		$path_info = pathinfo($up['name']);
		$file_extension = $path_info["extension"];
		if(!in_array($file_extension,$allow_extensions))
			return false;
		return true;
	}
	
	/*
	教师任课班级
	*/
	public function classes_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$classesmodel = $this->model('classes');
		$classlist = $classesmodel->getTeacherClassList($roominfo['crid'],$uid);
		
		$this->assign('tuser',$tuser);
		$this->assign('classlist',$classlist);
		$this->display('aroomv2/teacher_classes');
	}
	
	/*
	教师的课程
	*/
	public function course_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$param['uid'] = $uid;
		$foldermodel = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['limit'] = 100;
		$folderlist = $foldermodel->getTeacherFolderList1($param);
		$this->assign('folderlist',$folderlist);
		$this->assign('tuser',$tuser);
		$this->display('aroomv2/teacher_course');
	}
	
	/*
	教师的课件列表
	*/
	public function courseware_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		//课程列表
		$param['uid'] = $uid;
		$param['crid'] = $roominfo['crid'];
		$param['limit'] = 100;
		$foldermodel = $this->model('folder');
		$folderlist = $foldermodel->getTeacherFolderList1($param);
		
		$param = parsequery();
		$param['uid'] = $uid;
		$param['uids'] = $uid;
		$param['crid'] = $roominfo['crid'];
		$cwmodel = $this->model('courseware');
		$param['folderid'] = $this->input->get('selfolderid');
		$cwcountlist = $cwmodel->getTeachersCWCount($param);
		$cwcount = $cwcountlist[0]['cwnum'];
		$param['order'] = ' truedateline desc';
		$cwlist = $cwmodel->getTeacherCoursewares($param);
		
		
		$pagestr = show_page($cwcount);
		$this->assign('folderlist',$folderlist);
		$this->assign('pagestr',$pagestr);
		$this->assign('tuser',$tuser);
		$this->assign('cwlist',$cwlist);
		$this->display('aroomv2/teacher_courseware');
	}
	
	/*
	提问给教师的
	*/
	public function askme_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $uid;
		$param['limit'] = 100;
		$foldermodel = $this->model('folder');
		$folderlist = $foldermodel->getTeacherFolderList1($param);
		
		$askmodel = $this->model('askquestion');
		$param['tid'] = $uid;
		unset($param['uid']);
		unset($param['limit']);
		$param['folderid'] = $this->input->get('selfolderid');
		if(!empty($startdate)){
			$param['abegindate'] = strtotime($startdate);
		}
		if(!empty($enddate)){
			$param['aenddate'] = strtotime($enddate)+86400;
		}
		$asklist = $askmodel->getallasklist($param);
		$askcount = $askmodel->getallaskcount($param);
		$pagestr = show_page($askcount);
		$param['tids'] = $uid;
		$param['startdate'] = $param['abegindate'];
		$param['enddate'] = $param['aenddate'];
		$asksstate = $askmodel->getTeacherAnsweredList($param);
		$askstate['asknum'] = empty($asksstate[0]['asknum'])?0:$asksstate[0]['asknum'];
		$askstate['bestnum'] = empty($asksstate[0]['bestnum'])?0:$asksstate[0]['bestnum'];
		$this->assign('askstate',$askstate);
		$this->assign('pagestr',$pagestr);
		$this->assign('asklist',$asklist);
		$this->assign('folderlist',$folderlist);
		$this->assign('tuser',$tuser);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->display('aroomv2/teacher_askme');
		
		
	}
	
	/*
	教师回答
	*/
	public function answer_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $uid;
		$param['uids'] = $uid;
		$param['limit'] = 100;
		//课程列表
		$foldermodel = $this->model('folder');
		$folderlist = $foldermodel->getTeacherFolderList1($param);
		$param['folderid'] = $this->input->get('selfolderid');
		//回答列表以及数量
		unset($param['limit']);
		$askmodel = $this->model('askquestion');
		$answerlist = $askmodel->getAnswerListByDistinctQid($param);
		$answercount = $askmodel->getAnswerCountByDistinctQid($param);
		$answercount = $answercount[0]['answernum'];
		//回答总数
		if(empty($param['folderid']))
			$totalanswercount = $answercount;
		else{
			unset($param['folderid']);
			$totalanswercount = $askmodel->getAnswerCountByDistinctQid($param);
			$totalanswercount = $totalanswercount[0]['answernum'];
		}
		$pagestr = show_page($answercount);
		$this->assign('totalanswercount',$totalanswercount);
		$this->assign('pagestr',$pagestr);
		$this->assign('answerlist',$answerlist);
		$this->assign('tuser',$tuser);
		$this->assign('folderlist',$folderlist);
		$this->display('aroomv2/teacher_answer');
	}
	
	/*
	教师收到的评论
	*/
	public function review_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $uid;
		
        $review = $this->model('review');
		$reviewlist = $review->getreviewlistbycrid($param);
        $reviewcount = $review->getreviewlistcountbycrid($param);
		$pagestr = show_page($reviewcount);
		$reviewlist = parseEmotion($reviewlist);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('reviewlist', $reviewlist);
		$this->assign('pagestr',$pagestr);
		$this->assign('tuser',$tuser);
		$this->display('aroomv2/teacher_review');
	}
	
	/*
	教师查看
	*/
	public function teacherlist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$teachermodel = $this->model('teacher');
		$param = parsequery();
		$crid = $roominfo['crid'];
		$teacherlist = $teachermodel->getroomteacherlist($crid,$param);
		$teachercount = $teachermodel->getroomteachercount($crid,$param);
		$pagestr = show_page($teachercount);
		$q = $this->input->get('q');
		$this->assign('q',$q);
		$this->assign('teacherlist',$teacherlist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/teacher_list');
	}
	
	/*
	教师查看导航页
	*/
	public function viewnav(){
		$this->display('aroomv2/teacher_viewnav');
	}
	
	/*
	课件的学习监控
	*/
	public function cwstudylog_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid))
			exit;
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['cwid'] = $cwid;
		$playlogmodel = $this->model('playlog');
		$playloglist = $playlogmodel->getLogsByCwid($param);
		$playlogcount = $playlogmodel->getLogsCountByCwid($param);
		$cwmodel = $this->model('courseware');
		$cwinfo = $cwmodel->getcoursewaredetail($cwid);
		$this->assign('cwinfo',$cwinfo);
		$pagestr = show_page($playlogcount);
		$this->assign('playloglist',$playloglist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/courseware_studylog');
	}
	
	/*
	教师作业
	*/
	public function exam_view(){
		$uid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$exammodel = $this->model('exam');
		$param = parsequery();
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');
		$param['starttime'] = strtotime($startdate);
		$param['endtime'] = strtotime($enddate);
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $uid;
		$examlist = $exammodel->getschexamlist($param);
		$examcount = $exammodel->getschexamlistcount($param);
		// var_dump($examlist);
		$pagestr = show_page($examcount);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('pagestr',$pagestr);
		$this->assign('examlist',$examlist);
		$this->display('aroomv2/exam_list');
	}
	
	/*
	课件详情
	*/
	public function classcourse_view() {
		$roominfo = Ebh::app()->room->getcurroom();
        $cwid = $this->uri->itemid;
        if(empty($cwid)){
        	$cwid = intval($this->uri->uri_attr(0));
        }
        $recuid = intval($this->uri->uri_attr(1));
		$user = Ebh::app()->user->getloginuser();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		$source = '';
		if(!empty($course)) {	//生成课件所在服务器地址
			$serverutil = Ebh::app()->lib('ServerUtil');
			$source = $serverutil->getCourseSource();
			if(!empty($source)) {
				$course['cwsource'] = $source;
			}
		}
        $this->assign('course', $course);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
		//单个课件下的作业
		$exammodel  = $this->model('exam');
		if(!empty($recuid)){
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$recuid,'limit'=>'0,100');
		}else{
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'limit'=>'0,100');
		}
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamonlinelist($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		$this->assign('exams',$exams);
		//课件评论
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		//$pagestr = $this->_show_page($count,1,10);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('roominfo', $roominfo);
		$this->assign('user',$user);
        $this->assign('reviews', $reviews);
		$this->assign('pagestr', $pagestr);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		$this->assign('type',$type);
		if($type == 'flv'){
			$this->display('troom/course_view');
		}else{
			$this->display('troom/classcourse_view');
		}
    }
	
	/*
	flv类型课件详情
	*/
	public function classcourseflv_view() {
        $cwid = $this->uri->itemid;
        if(empty($cwid)){
        	$cwid = intval($this->uri->uri_attr(0));
        }
        $recuid = intval($this->uri->uri_attr(1));
		if(!is_numeric($cwid))
			exit();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course) || $course['status']!=1)
			exit();
			
		//课件人气
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		
		$user = Ebh::app()->user->getloginuser();
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('user',$user);

		$type = $this->input->get('type');	//如果type为1则表示普通播放，即不采用m3u8方式播放
		$ifover5 = (SYSTIME - $course['dateline']) > 120 ? TRUE : FALSE;	//如果课件时间上传已经超过5分钟，则基本上已经处理成m3u8并且文件已经存好。
		if($course['ism3u8'] == 1 && $type != 1 && $course['dateline'] && $ifover5) {	//rtmp特殊处理 
			if($roominfo['domain'] == 'jx') {
				$m3u8source = $serverutil->getZKM3u8CourseSource();
			} else {
				$m3u8source = $serverutil->getM3u8CourseSource();
			}
			if(!empty($m3u8source)) {
				$murl = $course['m3u8url'];
				$key = $this->getKey($user,$murl,$cwid);
				$key = urlencode($key);
				$m3u8url = "$m3u8source?k=$key&id=$cwid&.m3u8";
				$course['m3u8url'] = $m3u8url;
			}
		} else {
			$course['m3u8url'] = '';
		}

        $this->assign('course', $course);
		$this->assign('source',$source);
		if(!empty($recuid)){
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$recuid,'limit'=>'0,100');
		}else{
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'limit'=>'0,100');
		}
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamlistbycwid($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		$this->assign('exams',$exams);
		//获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
		$queryarr['status'] = 1;
        $queryarr['cwid'] = $cwid;
		$queryarr['type'] = 'shield';
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
		//获取课件下的评论记录
		$reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $reviewcount = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($reviewcount);
		$this->assign('reviewcount',$reviewcount);
		$askmodel = $this->model('askquestion');
		$askcount = $askmodel->getRequiredAnswersCount(array('cwid'=>$cwid,'shield'=>0));
		$this->assign('askcount',$askcount);
		//$pagestr = $this->_show_page($count,1,10);
		$arr = explode('.',$course['cwurl']);
		$ext = $arr[count($arr)-1];
		if($ext != 'flv' && $course['ism3u8'] == 1) {
			$ext = 'flv';
		}
		$this->assign('ext',$ext);
		$reviews = parseEmotion($reviews);
		$subtitle = $course['title'];
		$this->assign('subtitle',$subtitle);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('roominfo', $roominfo);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
        $this->display('troom/course_view');
    }
	
	/**
	*生成包含用户信息的key，目前主要
	*/
	private function getKey($user,$cwurl='',$id=0) {
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time\t$cwurl\t$id";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}
}
?>