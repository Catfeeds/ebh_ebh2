<?php
/*
 *绿城育华学校学生控制器
*/
class LcyhstuController extends CControl{
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
	}
	public function index(){
		$classes = $this->model('classes');
		$roominfo = Ebh::app()->room->getcurroom();
		
		$page = intval($this->uri->uri_page());
		$pagesize = 20;
		$limit = max(0,($page - 1)) * $pagesize . ','.$pagesize;
		$classlist = $classes->getroomClassList($roominfo['crid'],0,$limit);
		$classcount = $classes->getroomclasscount($roominfo['crid']);
		$teacher = $this->model('teacher');
		$classteacherlist = $teacher->getclassteacherlist($roominfo['crid']);
		
		$class = array();
		//处理班级拥有的教师
		foreach($classteacherlist as $ct){
			if(!empty($class[$ct['classid']]['teacherids'])){
				$class[$ct['classid']]['teacherids'].= ','.$ct['uid'];
				$class[$ct['classid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$class[$ct['classid']]['teacherids'] = $ct['uid'];
				$class[$ct['classid']]['teachers'] = $ct['realname'];
			}
		}
		$tempcount = count($classlist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($class[$classlist[$i]['classid']]['teacherids'])){
				$classlist[$i]['teacherids'] = $class[$classlist[$i]['classid']]['teacherids'];
				$classlist[$i]['teachers'] = $class[$classlist[$i]['classid']]['teachers'];
			}
			else
				$classlist[$i]['teacherids'] = '';
		}
		$this->assign('classlist',$classlist);
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],array('limit'=>1000));
		$pagestr = show_page($classcount,$pagesize);
		$this->assign('room',$roominfo);
		$this->assign('roomteacherlist',$roomteacherlist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/lcyhstu_classlist');
	}
	public function list_view(){
		
		$roomuser = $this->model('roomuser');
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->input->get('classid');
		
		if(is_numeric($classid))
			$param['classid'] = $classid;
		
		$roomuserlist = $roomuser->getaroomstudentlist($param);
		$roomusercount = $roomuser->getaroomstudentcount($param);
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);
		// var_dump($param);
		$pagestr = show_page($roomusercount);
		$this->assign('classid',$classid);
		$this->assign('pagestr',$pagestr);
		$this->assign('search',$param['q']);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->assign('roomuserlist',$roomuserlist);
		$this->display('aroomv2/lcyhstu_list');
	}
	
	public function edit(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $this->input->post('uid');
		$param['cnname'] = $this->input->post('realname');
		$param['sex'] = $this->input->post('sex');
		$param['birthdate'] = strtotime($this->input->post('birthdate'));
		$param['email'] = $this->input->post('email');
		$param['mobile'] = $this->input->post('mobile');
		$member = $this->model('member');
		$member->editmember($param);
		echo 1;
		
		/**写日志开始**/
		$message = json_encode($param);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['crid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'roomuser'
				)
		);
		/**写日志结束**/
		//var_dump($param);
		// header('location:'.geturl('aroomv2/student/list/'.$param['classid']));		
	}
	
	public function edit_view(){
		$roomuser = $this->model('roomuser');
		$classes = $this->model('classes');
		$roominfo = Ebh::app()->room->getcurroom();
		$classlist = $classes->getroomClassList($roominfo['crid']);
		$uid = $this->uri->itemid;
		$studentdetail = $roomuser->getaroomstudentdetails($roominfo['crid'],$uid);
		$this->assign('studentdetail',$studentdetail);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->display('aroomv2/student_edit');
	}
	
	public function add(){
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()){
			$checkonly = $this->input->post('checkonly');
			
			$user = $this->model('user');
			$code = 1;
			$message = '';
			$username = $this->input->post('username');
			$exists = $user->exists($username);
			if(!empty($exists)){
				$userinfo = $user->getuserbyusername($username);
				$classes = $this->model('classes');
				$existsarr = $classes->existstu(intval($this->input->post('classid')),$userinfo['uid']);
				if($userinfo['groupid'] != 6){
					$code = 0;
					$message = '不允许添加教师账号';
				}else if(!empty($existsarr)){
					$code = 0;
					$message = '您添加账户已存在';
				}else{
					$roomuser = $this->model('roomuser');
					$roomuserlist = $roomuser->getroomuserdetail($roominfo['crid'],$userinfo['uid']);
					if(!$checkonly){
						$member = $this->model('member');
						$param['crid'] = $roominfo['crid'];
						$param['uid'] = $userinfo['uid'];
						$param['cnname'] = $this->input->post('realname');
						$param['sex'] = $this->input->post('sex');
						$param['birthdate'] = strtotime($this->input->post('birthdate'));
						$param['mobile'] = $this->input->post('mobile');
						$param['email'] = $this->input->post('email');
						//不存在就插入
						if(empty($roomuserlist)){
							$roomuser->insert($param);
						}
						$param['classid'] = $this->input->post('classid');
						$classes->addclassstudent($param);
						echo 1;
						
						fastcgi_finish_request();
						//更新SNS的学校学生、班级学生缓存
						Ebh::app()->lib('xNums')->add('user');
						$snslib = Ebh::app()->lib('Sns');
						$snslib->updateClassUserCache(array('classid'=>$param['classid'],'uid'=>$param['uid']));
						$snslib->updateRoomUserCache(array('crid'=>$param['crid'],'uid'=>$param['uid']));
						
						/**新增学生课程权限开始**/
						if($roominfo['isschool'] != 7){
							$classCourseModel = $this->model('Classcourses');
							$userpermissionModel = $this->model('Userpermission');
							$folderids = $classCourseModel->getfolderidsbyclassid($param['classid']);
							if(!empty($folderids)){
								foreach ($folderids as $folder){
									$fids[] = $folder['folderid'];
								}
								$param['itemid'] = 0;
								$param['folderids'] = $fids;
								$param['crid'] = $param['crid'];
								$param['uid'] = $param['uid'];
								$param['type'] = 2;
								$param['classid'] = $param['classid'];
								$param['dateline'] = SYSTIME;
								$userpermissionModel->mutifAddPermission($param);
							}
						}
						/**新增学生课程权限结束**/
						
						/**写日志开始**/
						$message = json_encode($param);
						Ebh::app()->lib('LogUtil')->add(
						array(
						'toid'=>$param['crid'],
						'message'=>$message,
						'opid'=>1,
						'type'=>'roomuser'
								)
						);
						/**写日志结束**/
						
						//调用SNS同步接口，类型为4用户网校操作
						$snslib->do_sync($userinfo['uid'], 4);
					}else{
						$code = 1;
						$message = '可以添加该用户';
					}
				}
			}else{
				if(!$checkonly){
					$member = $this->model('member');
					$param['username'] = $this->input->post('username');
					$param['password'] = $this->input->post('password');
					$param['realname'] = $this->input->post('realname');
					$param['sex'] = $this->input->post('sex');
					$param['birthdate'] = strtotime($this->input->post('birthdate'));
					$param['mobile'] = $this->input->post('mobile');
					$param['email'] = $this->input->post('email');
					$param['dateline'] = SYSTIME;
					
					$uid = $member->addmember($param);
					$this->model('credit')->addCreditlog(array('uid'=>$uid,'ruleid'=>1));
					$roomuser = $this->model('roomuser');
					$param['crid'] = $roominfo['crid'];
					$param['uid'] = $uid;
					$param['cnname'] = $this->input->post('realname');
					$roomuser->insert($param);
					$param['classid'] = $this->input->post('classid');
					$classes = $this->model('classes');
					$classes->addclassstudent($param);
					echo 1;
					fastcgi_finish_request();
					Ebh::app()->lib('xNums')->add('user');
					//更新SNS的学校学生、班级学生缓存
					$snslib = Ebh::app()->lib('Sns');
					$snslib->updateClassUserCache(array('classid'=>$param['classid'],'uid'=>$uid));
					$snslib->updateRoomUserCache(array('crid'=>$param['crid'],'uid'=>$uid));
					
					/**新增学生课程权限开始**/
					if($roominfo['isschool'] != 7){
						$classCourseModel = $this->model('Classcourses');
						$userpermissionModel = $this->model('Userpermission');
						$folderids = $classCourseModel->getfolderidsbyclassid($param['classid']);
						if(!empty($folderids)){
							foreach ($folderids as $folder){
								$fids[] = $folder['folderid'];
							}
							$param['itemid'] = 0;
							$param['folderids'] = $fids;
							$param['crid'] = $param['crid'];
							$param['uid'] = $param['uid'];
							$param['type'] = 2;
							$param['classid'] = $param['classid'];
							$param['dateline'] = SYSTIME;
							$userpermissionModel->mutifAddPermission($param);
						}
					}
					/**新增学生课程权限结束**/
					
					/**写日志开始**/
					$message = json_encode($param);
					Ebh::app()->lib('LogUtil')->add(
						array(
							'toid'=>$param['crid'],
							'message'=>$message,
							'opid'=>1,
							'type'=>'roomuser'
							)
					);
					/**写日志结束**/

					//调用SNS同步接口，类型为4用户网校操作
					$snslib->do_sync($uid, 4);
				}
				$code = 2;
				$message = '请为新用户设置密码';
			}
			
			if($checkonly){
				$arr = array('code'=>$code,'message'=>$message);
				echo json_encode($arr);
			}
		}else{
			$classes = $this->model('classes');
			$classlist = $classes->getroomClassList($roominfo['crid']);
			$this->assign('classlist',$classlist);
			$classid = $this->uri->uri_attr(0);
			$this->assign('classid',$classid);
			$this->display('aroomv2/student_add');
		}
	}
	/*
	修改密码
	*/
	public function editpass(){
		$param['uid'] = $this->input->post('uid');
		$param['password'] = $this->input->post('password');
		$member = $this->model('member');
		$res = $member->editmember($param);
		echo isset($res);
		/**写日志开始**/
		fastcgi_finish_request();
		$message = json_encode($param);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['uid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'member'
				)
		);
		/**写日志结束**/
	}
	
	public function del(){
		$param['uid'] = intval($this->input->post('uid'));
		$param['classid'] = intval($this->input->post('classid'));
		$classes = $this->model('classes');
		$res = $classes->deletestudent($param);
		if($res)
		{
			//删除缓存
			$snslib = Ebh::app()->lib('Sns');
			$snslib->delClassUserCache(array('classid'=>$param['classid'],'uid'=>$param['uid']));
			
			/**移除用户课程权限开始**/
			if($roominfo['isschool'] != 7){
				$userpermissionModel = $this->model('Userpermission');
				$userpermissionModel->removeStudentPermission(array(),array($param['uid']),2,$param['classid']);
			}
			/**移除用户课程权限结束**/
			
			echo json_encode(array('code'=>1,'message'=>'删除成功'));
		}
		
		else
		echo json_encode(array('code'=>0,'message'=>'删除失败'));
		
		/**写日志开始**/
		fastcgi_finish_request();
		$message = ' [ '.(empty($res)?'删除失败':'删除成功').' ] '.json_encode($param);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['crid'],
				'message'=>$message,
				'opid'=>4,
				'type'=>'roomuser'
				)
		);
		/**写日志结束**/

		if($res){
			//调用SNS同步接口，类型为4用户网校操作
			$snslib->do_sync($param['uid'], 4);
			Ebh::app()->lib('xNums')->add('user',-1);
		}
	}


	public function input(){
		if($this->input->post()){
		$errormsg = '';
		$inputresult = array('result'=>false,'hasresult'=>false,'errormsg'=>$errormsg);
		$roominfo = Ebh::app()->room->getcurroom();
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
				$iresult = $this->inputstudent($filesavepath,$roominfo['crid']);
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

		/**写日志开始**/
		$message = '批量导入：'.json_encode($inputresult);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$roominfo['crid'],
				'message'=>$message,
				'opid'=>1,
				'type'=>'roomuser'
				)
		);
		/**写日志结束**/

		$this->assign('inputresult',$inputresult);
		}
		if(intval($this->input->get('aroomv')) == 3){
			$this->display('aroomv3/lcyhgstu_input');
		}else{
			$this->display('aroomv2/lcyhgstu_input');
		}
		
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
	*导入学生
	*步骤如下：
	*1，判断excel格式
	*2，获取excel标题栏信息
	*3，
	*/
	function inputstudent($filepath,$crid) {
		set_time_limit(0);
		
		$roominfo = Ebh::app()->room->getcurroom();
		
		$result = array('result'=>false);
		
		$reader = Ebh::app()->lib('PhpExcelReader');
		
		$reader->setOutputEncoding('UTF-8');
		$r = $reader->read($filepath);
		if($r === false) {	//不支持的文件格式
			$result['errormsg'] = '不支持的文件格式';
			return $result;
		}
		$rowcount = 0;	//导入行数
		$titlerownum = 0;
		//姓名	登录账号	性别	班级
		$realnamecol = 0;
		$usernamecol = 0;
		$classcol = 0;
		for ($i = 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $reader->sheets[0]['numCols']; $j++) {	//找到标题行
				$colval = trim($reader->sheets[0]['cells'][$i][$j]);
				$colval = str_replace(' ','',$colval);
				if($colval == '姓名') {
					$realnamecol = $j;
				} else if($colval == '学号') {
					$usernamecol = $j;
				} else if($colval == '教学班') {
					$classcol = $j;
				}
			}
			if(!empty($realnamecol) && !empty($usernamecol) && !empty($classcol)) {	//找到标题行
				$titlerownum = $i;
				break;
			}
		}
		if($titlerownum == 0) {
			$result['errormsg'] = '文件内容不正确，请按照系统提供的导入模板格式进行上传。必须包含带有 姓名/学号/教学班 字段的标题行。';
			return $result;
		}
		$classes = $this->model('classes');
		$classlist = $classes->getRoomClassList($crid);
		if(empty($classlist)) {
			$result['errormsg'] = '您还没有创建任何班级，请先添加班级。';
			return $result;
		}
		$classlist = array_combine(array_column($classlist, 'classname'), $classlist);
		$userlist = array();
		if($realnamecol == 0)
			$realnamecol_err = 1;
		if($usernamecol == 0)
			$usernamecol_err = 1;
		if($classcol == 0)
			$classcol_err = 1;
		for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
		    if (!isset($reader->sheets[0]['cells'][$i][$realnamecol]) || !isset($reader->sheets[0]['cells'][$i][$usernamecol]) || !isset($reader->sheets[0]['cells'][$i][$classcol])) {
		        continue;
            }
			$realname = empty($realnamecol_err)?$reader->sheets[0]['cells'][$i][$realnamecol]:'';
			$realname = trim($realname);
			$username = empty($usernamecol_err)?$reader->sheets[0]['cells'][$i][$usernamecol]:'';
			$username = trim($username);
			$classname = empty($classcol_err)?$reader->sheets[0]['cells'][$i][$classcol]:'';
			$classname = trim($classname);
			$password = '123456';
			$schoolname = '绿城育华';
			if(empty($realname) && empty($username) && empty($classname)) {	//这些字段为空 则认为是空行
				continue;
			}
			if(empty($realname) || empty($username) || empty($classname)) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，姓名、登录账号、性别、班级不能为空，请修改文件后重新上传';
				break;
			}
			if(!isset($classlist[$classname])) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，'.$classname.' 还不存在，请先添加班级。';
				break;
			}
			if(strlen($realname) > 30 || strlen($username) > 20) {
				$result['errormsg'] = '第 '.$i.' 行 姓名或登录账号太长，请调整。';
				break;
			}
			if(!preg_match('/^[a-zA-Z][a-z0-9A-Z_]{5,19}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-20位英文、数字的组合字符，必须以英文字母打头，请调整。';
				break;
			}
			$realname = str_replace('\'','',$realname);
			$username = str_replace('\'','',$username);
			if(empty($usernameinlist))
				$usernameinlist = '\''.$username.'\'';
			else
				$usernameinlist .= ','. '\''.$username.'\'';
			$userIndex = strtolower($username);
			if(!isset($userlist[$userIndex])){
				$userlist[$userIndex] = array(
											'rownum' => $i,
											'realname' => $realname,
											'username' => $username,
											'sex'=> 0,
											'classid'=>array($classlist[$classname]['classid']),
											'password'=>$password,
											'schoolname'=>$schoolname
										);
			} else {
                $userlist[$userIndex]['classid'][] = $classlist[$classname]['classid'];
			}
			$rowcount++;
		}
		if (!empty($result['errormsg'])) {
			return $result;
		}
		if (empty($usernameinlist)) {
			$result['errormsg'] = '读取文件过程出错，若文件记录数过大，您可以将文件分拆后再上传。';
			return $result;
		}
		$user = $this->model('user');
		$usernamearr = $user->getuserlistbyusername($usernameinlist);
		if(!empty($usernamearr)) {	//重复账号判断
			$result['erroritems'] = array();
			foreach($usernamearr as $uname) {
				if(isset($userlist[strtolower($uname['username'])])) {
					$result['erroritems'][] = '第 '.$userlist[strtolower($uname['username'])]['rownum'].' 行 账号 '.$uname['username'].' 已存在';
				}
			}
			return $result;
		}
		//导入数据开始
		$member = $this->model('member');
		$roomuser = $this->model('roomuser');
		$creditmodel = $this->model('credit');
		$credit = $creditmodel->getCreditRuleInfo(1);
		$uarr = array();
		$classarr = array();
		$roomarr = array();
		$stunum = count($userlist);
		foreach($userlist as $iuser) {	//导入数据
			$tclassids = $iuser['classid'];
			$username = $iuser['username'];
			$realname = $iuser['realname'];
			$sex = $iuser['sex'];
			$schoolname = $iuser['schoolname'];
			$userpass = $iuser['password'];
			$uarr[] = array('username'=>$username,'password'=>$userpass,'realname'=>$realname,'sex'=>$sex,'dateline'=>SYSTIME,'credit'=>$credit,'schoolname'=>$schoolname,'classids'=>$tclassids);
			$roomarr[] = array('crid'=>$crid,'cnname'=>$realname,'sex'=>$sex);
		}
		$fromuid = $member->addMultipleMembers($uarr);
		$creditmodel->addRegLogs($fromuid,$stunum);
		
		$i = 0;
		foreach ($uarr as $user){
			$roomarr[$i]['uid'] = $fromuid + $i;
			$roomarr[$i]['mobile'] = '';
			$myclassids = array_unique($user['classids']);  
			foreach ($myclassids as $iclassid){
				$classarr[] = array('uid'=>$fromuid + $i,'classid'=>$iclassid,'crid'=>$crid);
			}
			$i++;
		}
		$classes->addMultipleStudent($classarr);
		$roomuser->addMultipleStudent($roomarr);
		$result['rowcount'] = $rowcount;
		
		$snslib = Ebh::app()->lib('Sns');
		$snslib->updateClassUserCacheM($classarr);
		$snslib->updateRoomUserCacheM($roomarr);
		//同步班级学生课程权限
		foreach($classarr as $cr){
			$iclass[$cr['classid']][] = $cr['uid'];	
		}
		$dateline = SYSTIME;
		if(!empty($iclass) && $roominfo['isschool'] !=7){
			$classcourseModel = $this->model('Classcourses');
			$userpermissionModel = $this->model('Userpermission');
			foreach ($iclass as $key=>$tclass){
				$folders = $classcourseModel->getfolderidsbyclassid($key);
				$afids = array();
				if(!empty($folders)){
					foreach ($folders as $fd){
						$afids[] = $fd['folderid'];
					}
					//依次将班级课程权限添加至用户权限表
					$aparam['folderids'] = $afids;
					$aparam['crid'] = $crid;
					$aparam['classid'] = $key;
					$aparam['dateline'] = $dateline;
					$aparam['uids'] = $tclass;
					$aparam['type'] = 2;
					$aparam['itemid'] = 0;
					$userpermissionModel->mutiImportPermission($aparam);
				}
			}
		}
        //同步SNS数据(用户网校操作)
        for($i=0;$i<$stunum;$i++){
            $snslib->do_sync($fromuid + $i, 4);
        }
        Ebh::app()->lib('xNums')->add('user',$stunum);

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
	可查询导入
	*/
	public function input_scb(){
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['isschool']!='7')
			exit;
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
				
				$iresult = $this->inputstudent_scb($filesavepath,$roominfo['crid']);
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
		
		$inputresult['errormsg'] = $errormsg;
		/**写日志开始**/
		$message = '可查询账号导入：'.json_encode($inputresult);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$roominfo['crid'],
				'message'=>$message,
				'opid'=>1,
				'type'=>'roomuser'
				)
		);
		/**写日志结束**/
		$this->assign('inputresult',$inputresult);
		}
		$this->display('aroomv2/student_input_scb');
	}
	
	private function inputstudent_scb($filepath,$crid){
		$result = array('result'=>false);
		
		$reader = Ebh::app()->lib('PhpExcelReader');
		
		$reader->setOutputEncoding('UTF-8');
		$r = $reader->read($filepath);
		if($r === false) {	//不支持的文件格式
			$result['errormsg'] = '不支持的文件格式';
			return $result;
		}
		$rowcount = 0;	//导入行数
		$titlerownum = 0;
	//	姓名	登录账号	性别	学校
		$realnamecol = 0;
		$usernamecol = 0;
		$sexcol = 0;
		$classroomcol = 0;
		for ($i = 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $reader->sheets[0]['numCols']; $j++) {	//找到标题行
				$colval = trim($reader->sheets[0]['cells'][$i][$j]);
				$colval = str_replace(' ','',$colval);
				if($colval == '姓名') {
					$realnamecol = $j;
				} else if($colval == '登录账号') {
					$usernamecol = $j;
				} else if($colval == '性别') {
					$sexcol = $j;
				} else if($colval == '学校') {
					$classroomcol = $j;
				} else if($colval == '密码') {
					$passwordcol = $j;
				}
			}
			if(!empty($realnamecol) && !empty($usernamecol) && !empty($sexcol) && !empty($classroomcol)) {	//找到标题行
				$titlerownum = $i;
				break;
			}
		}
		if($titlerownum == 0) {
			$result['errormsg'] = '文件内容不正确，请按照系统提供的导入模板格式进行上传。必须包含带有 姓名/登录账号/性别/学校 字段的标题行。';
			return $result;
		}
		
		$userlist = array();
		
		$usernameinlist = '';
		
		if($realnamecol == 0)
			$realnamecol_err = 1;
		if($usernamecol == 0)
			$usernamecol_err = 1;
		if($sexcol == 0)
			$sexcol_err = 1;
		if($classroomcol == 0)
			$classroomcol_err = 1;
		for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			$realname = empty($realnamecol_err)?$reader->sheets[0]['cells'][$i][$realnamecol]:'';
			$realname = trim($realname);
			$username = empty($usernamecol_err)?$reader->sheets[0]['cells'][$i][$usernamecol]:'';
			$username = trim($username);
			$sex = empty($sexcol_err)?$reader->sheets[0]['cells'][$i][$sexcol]:'';
			$sex = trim($sex);
			$crname = empty($classroomcol_err)?$reader->sheets[0]['cells'][$i][$classroomcol]:'';
			$crname = trim($crname);
			$password = !empty($passwordcol)&&!empty($reader->sheets[0]['cells'][$i][$passwordcol])?$reader->sheets[0]['cells'][$i][$passwordcol]:'';
			$password = trim($password);
			if(empty($realname) || empty($username) || empty($sex) || empty($crname)) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，姓名、登录账号、性别、学校不能为空，请修改文件后重新上传';
				break;
			}
			
			if(strlen($realname) > 30 || strlen($username) > 20) {
				$result['errormsg'] = '第 '.$i.' 行 姓名或登录账号太长，请调整。';
				break;
			}
			if(!preg_match('/^[a-zA-Z][a-z0-9A-Z_]{5,19}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-20位英文、数字的组合字符,并且必须以字母开头，请调整。';
				break;
			}
			if(trim($sex) == '女')
				$sex = 1;
			else
				$sex = 0;
			$realname = str_replace('\'','',$realname);
			$username = str_replace('\'','',$username);
			if (isset($userlist[$username])) {
				$preuser = $userlist[$username];
				$prerow = $preuser['rownum'];
				$result['errormsg'] = '第 '.$prerow.' 与 '.$i.' 行 登录账号重复，请调整。';
				break;
			}
			if(empty($usernameinlist))
				$usernameinlist = '\''.$username.'\'';
			else
				$usernameinlist .= ','. '\''.$username.'\'';
			$userlist[$username] = array('rownum'=>$i,'realname'=>$realname,'username'=>$username,'sex'=>$sex,'crname'=>$crname,'password'=>$password);
			$rowcount ++;
		}
		if (!empty($result['errormsg'])) {
			return $result;
		}
		if (empty($usernameinlist)) {
			$result['errormsg'] = '读取文件过程出错，若文件记录数过大，您可以将文件分拆后再上传。';
			return $result;
		}
		$user = $this->model('user');
		$usernamearr = $user->getUserlistByUsernameOnScb($usernameinlist,$crid);
		if(!empty($usernamearr)) {	//重复账号判断
			$result['erroritems'] = array();
			foreach($usernamearr as $uname) {
				if(isset($userlist[$uname['username']])) {
					$result['erroritems'][] = '第 '.$userlist[$uname['username']]['rownum'].' 行 账号 '.$uname['username'].' 已存在';
				}
			}
			return $result;
		}
		//导入数据开始
		$uarr = array();
		foreach($userlist as $iuser) {	//导入数据
			$username = $iuser['username'];
			$realname = $iuser['realname'];
			$sex = $iuser['sex'];
			$crname = $iuser['crname'];
			$password = $iuser['password'];
			//插入用户信息
			// $uid = $member->addmember(array('username'=>$username,'password'=>$userpass,'realname'=>$realname,'sex'=>$sex,'dateline'=>SYSTIME));
			$uarr[] = array('username'=>$username,'realname'=>$realname,'sex'=>$sex,'crname'=>$crname,'crid'=>$crid,'password'=>$password);
			
		}
		$user->addToScb($uarr);
		$roommodel = $this->model('classroom');
		$roommodel->editclassroom(array('crid'=>$crid,'showusername'=>1));
		$result['rowcount'] = $rowcount;
		//生成数据
		return $result;
	}
	
	/*
	升班
	*/
	public function input_upgrade(){
		$roominfo = Ebh::app()->room->getcurroom();
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
				
				$iresult = $this->inputstudent_upgrade($filesavepath,$roominfo['crid']);
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
		
		$inputresult['errormsg'] = $errormsg;
		
		/**写日志开始**/
		$message = '升班导入：'.json_encode($inputresult);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$roominfo['crid'],
				'message'=>$message,
				'opid'=>1,
				'type'=>'roomuser'
				)
		);
		/**写日志结束**/

		$this->assign('inputresult',$inputresult);
		}
		$this->display('aroomv2/student_input_upgrade');
	}
	
	function inputstudent_upgrade($filepath,$crid) {
		$roominfo = Ebh::app()->room->getcurroom();
		
		$result = array('result'=>false);
		
		$reader = Ebh::app()->lib('PhpExcelReader');
		
		$reader->setOutputEncoding('UTF-8');
		$r = $reader->read($filepath);
		if($r === false) {	//不支持的文件格式
			$result['errormsg'] = '不支持的文件格式';
			return $result;
		}
		$rowcount = 0;	//导入行数
		$titlerownum = 0;
	//	姓名	登录账号	班级
		$usernamecol = 0;
		$classcol = 0;
		for ($i = 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $reader->sheets[0]['numCols']; $j++) {	//找到标题行
				$colval = trim($reader->sheets[0]['cells'][$i][$j]);
				$colval = str_replace(' ','',$colval);
				if($colval == '登录账号') {
					$usernamecol = $j;
				} else if($colval == '班级') {
					$classcol = $j;
				} 
			}
			if( !empty($usernamecol) && !empty($classcol)) {	//找到标题行
				$titlerownum = $i;
				break;
			}
		}
		if($titlerownum == 0) {
			$result['errormsg'] = '文件内容不正确，请按照系统提供的导入模板格式进行上传。必须包含带有 登录账号/班级 字段的标题行。';
			return $result;
		}
		$classes = $this->model('classes');
		$classlist = $classes->getRoomClassList($crid);
		if(empty($classlist)) {
			$result['errormsg'] = '您还没有创建任何班级，请先添加班级。';
			return $result;
		}
		$classnamelist = array();
		$userlist = array();
		foreach($classlist as $myclass) {
			$classnamelist[$myclass['classname']] = $myclass;
		}
		$usernameinlist = '';
		
		if($usernamecol == 0)
			$usernamecol_err = 1;
		if($classcol == 0)
			$classcol_err = 1;
		for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			
			$username = empty($usernamecol_err)?$reader->sheets[0]['cells'][$i][$usernamecol]:'';
			$username = trim($username);
			$classname = empty($classcol_err)?$reader->sheets[0]['cells'][$i][$classcol]:'';
			$classname = trim($classname);
			
			if(empty($username) && empty($classname)) {	//全部为空 以空行处理，跳过不处理
				continue;
			}
			if(empty($username) || empty($classname)) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，登录账号、班级不能为空，请修改文件后重新上传';
				break;
			}
			if(!isset($classnamelist[$classname])) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，'.$classname.' 还不存在，请先添加班级。';
				break;
			}
			
			if(!preg_match('/^[a-zA-Z][a-z0-9A-Z_]{5,19}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-20位英文、数字的组合字符，并且必须以字母开头，请调整。';
				break;
			}
			
			$username = str_replace('\'','',$username);
			if (isset($userlist[$username])) {
				$preuser = $userlist[$username];
				$prerow = $preuser['rownum'];
				$result['errormsg'] = '第 '.$prerow.' 与 '.$i.' 行 登录账号重复，请调整。';
				break;
			}
			if(empty($usernameinlist))
				$usernameinlist = '\''.$username.'\'';
			else
				$usernameinlist .= ','. '\''.$username.'\'';
			$userlist[$username] = array('rownum'=>$i,'username'=>$username,'classid'=>$classnamelist[$classname]['classid']);
			$rowcount ++;
		}
		if (!empty($result['errormsg'])) {
			return $result;
		}
		if (empty($usernameinlist)) {
			$result['errormsg'] = '读取文件过程出错，若文件记录数过大，您可以将文件分拆后再上传。';
			return $result;
		}
		$user = $this->model('user');
		$usernamearr = $user->getuserlistbyusername($usernameinlist);
		foreach($usernamearr as $uname) {
			$unaskey[$uname['username']] = $uname['username'];
		}
		
		$noexistsflag = 0;
		foreach($userlist as $k=>$u){
			if(empty($unaskey[$k])){
				$noexistsflag = 1;
				$result['erroritems'][] = '第 '.$userlist[$k]['rownum'].' 行 账号 '.$k.' 不存在';
				unset($userlist[$k]);
			}
		}
		$param['usernames'] = $usernameinlist;
		$param['crid'] = $crid;
		
		$rumodel = $this->model('roomuser');
		$roomuserlist = $rumodel->getRoomuserByUsername($param);
		$notinroomflag = 0;
		foreach($roomuserlist as $ru) {
			$runaskey[$ru['username']] = $ru['username'];
			$userlist[$ru['username']]['uid'] = $ru['uid'];
		}
		// var_dump($runaskey);
		foreach($userlist as $k=>$u){
			if(empty($runaskey[$k])){
				$notinroomflag = 1;
				$result['erroritems'][] = '第 '.$userlist[$k]['rownum'].' 行 账号 '.$k.' 不在当前学校下';
			}
		}
		if(!empty($noexistsflag) || !empty($notinroomflag))
			return $result;
		
		
		//导入数据
		
		$classes = $this->model('classes');
		$classes->studentUpgrade($param,$userlist,$roominfo['isschool']);
		
		
		
		$result['rowcount'] = $rowcount;
		//生成数据
		return $result;
	}
	
	/*
	获取学生开通课程
	*/
	public function getstuinfo(){
		$uid = $this->input->post('uid');
		$roominfo = Ebh::app()->room->getcurroom();
		$rumodel = $this->model('roomuser');
		$stuinfo = $rumodel->getstucourse(array('crid'=>$roominfo['crid'],'uid'=>$uid));
		echo json_encode($stuinfo);
	}
	
	/*
	ip解绑
	*/
	public function unbind(){
		$uid = $this->input->post('uid');
		if(empty($uid) || !is_numeric($uid))
			exit;
		$usermodel = $this->model('user');
		$usermodel->update(array('allowip'=>''),$uid);
		$rumodel = $this->model('limitlog');
		$setarr['enddate'] = SYSTIME;
		$setarr['finishfrom'] = 1;
		$setarr['isfinish'] = 1;
		$status = $rumodel->updateByWhere($setarr,array('uid'=>$uid,'isfinish'=>0));
		if($status !== false)
			echo 1;
	}
	
	/*
	学生查看导航页
	*/
	public function viewnav(){
		$this->display('aroomv2/student_viewnav');
	}
	
	/*
	统计分析,学生查看,班级列表
	*/
	public function view(){
		$classes = $this->model('classes');
		$roominfo = Ebh::app()->room->getcurroom();
		$classlist = $classes->getroomClassList($roominfo['crid']);
		$teacher = $this->model('teacher');
		$classteacherlist = $teacher->getclassteacherlist($roominfo['crid']);
		
		$class = array();
		//处理班级拥有的教师
		foreach($classteacherlist as $ct){
			if(!empty($class[$ct['classid']]['teacherids'])){
				$class[$ct['classid']]['teacherids'].= ','.$ct['uid'];
				$class[$ct['classid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$class[$ct['classid']]['teacherids'] = $ct['uid'];
				$class[$ct['classid']]['teachers'] = $ct['realname'];
			}
		}
		$tempcount = count($classlist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($class[$classlist[$i]['classid']]['teacherids'])){
				$classlist[$i]['teacherids'] = $class[$classlist[$i]['classid']]['teacherids'];
				$classlist[$i]['teachers'] = $class[$classlist[$i]['classid']]['teachers'];
			}
			else
				$classlist[$i]['teacherids'] = '';
		}
		$this->assign('classlist',$classlist);
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],array('limit'=>1000));
		$this->assign('room',$roominfo);
		$this->assign('roomteacherlist',$roomteacherlist);
		$this->display('aroomv2/student_viewclasslist');
	}
	/*
	统计分析,学生查看,学生列表
	*/
	public function view_list_view(){
		$roomuser = $this->model('roomuser');
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->itemid;
		
		if(is_numeric($classid))
			$param['classid'] = $classid;
		
		$roomuserlist = $roomuser->getaroomstudentlist($param);
		$roomusercount = $roomuser->getaroomstudentcount($param);
		$classes = $this->model('classes');
		// $classlist = $classes->getroomClassList($roominfo['crid']);
		// var_dump($param);
		$pagestr = show_page($roomusercount);
		$this->assign('classid',$classid);
		$this->assign('pagestr',$pagestr);
		$this->assign('search',$param['q']);
		$this->assign('room',$roominfo);
		// $this->assign('classlist',$classlist);
		$this->assign('roomuserlist',$roomuserlist);
		$this->display('aroomv2/student_viewlist');
	}

	//学生积分类别
	public function creditlevel(){
		$roominfo = Ebh::app()->room->getcurroom();
      //  $user = Ebh::app()->user->getloginuser();
        
        $classmodel = $this->model('Classes');
		$clconfig = Ebh::app()->getConfig()->load('creditlevel');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['pagesize'] = 100;
		$param['order'] = 'credit desc';
		$students = $classmodel->getAllstudent($param);
		foreach($students as $skey=>$svalue){
			foreach($clconfig as $clevel){
				if($svalue['credit']>=$clevel['min'] && $svalue['credit']<=$clevel['max']){
					$students[$skey]['jifen_data'] = $clevel['title'];
				}
			} 
		}
		$count = $classmodel->getAllstudentcount($param);
		$pagestr = show_page($count,$param['pagesize']);
		$this->assign('pagestr',$pagestr);
		$this->assign('students',$students);
		$this->display('aroomv2/student_creditlevel');
	}
	/*
	学生学分统计
	*/
	public function schcreditreport(){
		$roomuser = $this->model('roomuser');
		$roominfo = Ebh::app()->room->getcurroom();

		//获取当前学校的类型
		$type = $roominfo['grade'];

		//判断学校的类型是否合法
		if(!in_array($type, array(0,1,7,10))){
			show_404();
			exit;
		}

		$roomdetail = $this->_getRoomDetail();

		//根据学校类型获取学校年级列表
		$_SG = Ebh::app()->getConfig()->load('schoolgrade');
		$gradeList = $_SG[$type];

		$this->assign('gradeList',$gradeList);

		//组织参数
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->uri_attr(0);
		$grade = $this->uri->uri_attr(1);
		if(is_numeric($classid)&&$classid>0){
			$uids = $this->_getClassStu($classid);
			if(!empty($uids)){
				$param['uid_in'] = $uids;
			}else{
				$param['uid_in'] = array(-1);
			}
		}

		if(is_numeric($grade)&&$grade>0){
			$uids = $this->_getGradeStu($grade);
			if(!empty($uids)){
				$param['uid_in'] = $uids;
			}else{
				$param['uid_in'] = array(-1);
			}
		}
		$param['order'] = 'score desc';
		$offset = max(($param['page']-1)*$param['pagesize'],0);
		$param['limit'] = $offset.','.$param['pagesize'];
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);

		$schcreditlogmodel = $this->model('schcreditlog');
		$schcreditlog = $schcreditlogmodel->getTotalList($param);
		$schcreditlogCount = $schcreditlogmodel->getTotalListCount($param);
		$pageStr = show_page($schcreditlogCount,$param['pagesize']);
		$this->assign('pageStr',$pageStr);
		$this->assign('schcreditlog',$schcreditlog);
		$this->assign('classid',$classid);
		$this->assign('grade',$grade);
		$this->assign('classlist',$classlist);
		$this->assign('roomdetail',$roomdetail);
		$this->assign('q',$param['q']);
		$this->display('aroomv2/student_schcreditreport');
	}

	//获取指定班级下面所有的学生uid数组
	private function _getClassStu($classid = 0){
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array(
			'classid'=>$classid,
			'crid'=>$roominfo['crid'],
			'limit'=>2000
		);
		$classModel = $this->model('classes');
		$studentsList = $classModel->getClassStudentList($param);
		return $this->_getFields($studentsList,'uid');
	}

	//获取指定年级下面所有的学生uid数组
	private function _getGradeStu($grade = 0){
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array(
			'crid'=>$roominfo['crid'],
			'grade'=>$grade,
			'limit'=>2000
		);
		$classModel = $this->model('classes');
		$classlist = $classModel->getClasses($param);
		if(empty($classlist)){
			return;
		}
		$classArr =  $this->_getFields($classlist,'classid');
		$param2 = array(
			'crid'=>$roominfo['crid'],
			'classidlist'=>implode(',',$classArr),
			'limit'=>2000
		);
		$studentsList = $classModel->getClassStudentList($param2);
		return $this->_getFields($studentsList,'uid');
	}
	/**
	 *获取二维数组指定字段合集
	 */
	private function _getFields($dataList = array(),$fieldName = ''){
		$returnArr = array();
		if(empty($fieldName)||empty($dataList)){
			return $returnArr;
		}
		foreach ($dataList as $data) {
			array_push($returnArr, $data[$fieldName]);
		}
		return $returnArr;
	}

	//获取学校详情
	private function _getRoomDetail(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['limit'] = '0,1000';
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		return $roomdetail;
	}

	/**
	 * 学分获取统计导出excel
	 */
	public function schcreditlogexcel(){
		$filename = "学生学分统计";
		$titleArr = array("学生账号","学生姓名"," 年级 "," 班级 ","获取学分","达标学分");
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array(
			'crid'=>$roominfo['crid'],
			'order'=>'cs.grade asc,cs.classid asc,score desc',
			'limit'=>100000
		);
		$schcreditlogmodel = $this->model('schcreditlog');
		$schcreditlogList = $schcreditlogmodel->getTotalList($param);

		//获取学生所在年级对应的合格学分
		$schcreditModel = $this->model('schcredit');
		$gradeScoreList = $schcreditModel->getScoreList(array('crid'=>$roominfo['crid']));
		$gradeScoreList = $this->_formatGradeScore($gradeScoreList);
		//根据学校类型获取学校年级列表
		$type = $roominfo['grade'];
		$_SG = Ebh::app()->getConfig()->load('schoolgrade');
		$gradeList = $_SG[$type];

		$dataArr = array();//存储数据
		foreach ($schcreditlogList as $tl) {
			$classname = $tl['classname'];
			$score = is_null($tl['score'])?0:$tl['score'];
			$gradename = empty($gradeList[$tl['grade']])?"":$gradeList[$tl['grade']];
			$username = $tl['username'];
			$realname = $tl['realname'];
			$okscore = empty($gradeScoreList[$tl['grade']]['score'])?0:$gradeScoreList[$tl['grade']]['score'];
			array_push($dataArr,array($username,$realname,$gradename,$classname,$score,$okscore));
		}

		$this->_exportExcel($titleArr,$dataArr,"FFFFFFFF",$filename);
	}	

	/**
	 * 导出excel
	 * @param Array array("编号",'用户名','性别'....)
	 * @param Array array('1','李华','男'...)
	 * @param String rgbColor
	 * @param String execl文件名称
	 *
	 */
	protected  function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$name,$manuallywidth=array()){
		$objPHPExcel = Ebh::app()->lib('PHPExcel');
		
		// 以下是一些设置 ，什么作者  标题啊之类的
		$objPHPExcel->getProperties()
					->setTitle("数据EXCEL导出")
					->setSubject("数据EXCEL导出")
					->setDescription("备份数据")
					->setKeywords("excel")
					->setCategory("result file");
	
		// 设置列表标题
		if(is_array($titleArr)){
			$str = "A";
			foreach($titleArr as $k=>$v){
				$p = $str++.'1';//列A1,B1,C1,D1
				if(empty($manuallywidth))
				$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
				$pt = $objPHPExcel->getActiveSheet()->getStyle($p);
				
				$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				$pt->getFont()->setSize(14);
				$pt->getFont()->setBold(true);
				
				//$pt->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置列填充模式 solid
				$pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
				//$pt->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//设置列边宽
				$objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
			}
		}
		//传值
		if(is_array($dataArr)){
			foreach ($dataArr as $k=>$v) {
				$str = "A";
				foreach($titleArr as $kt=>$vt){
					$p = $str.($k+2);//从第二列填充内容 A22,B22...A33 B33
					$pt = $objPHPExcel->getActiveSheet();
					if(empty($manuallywidth))
					$pt->getColumnDimension($str)->setAutoSize(true);//单元格每项内容自适应
					if(is_numeric($v[$kt])){
						if(empty($manuallywidth))
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);//A列头标题自适应
						$pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
						$pt->getColumnDimension($str)->setWidth(20);//设置单元格宽度
						$pt->setCellValue($p, $v[$kt].' ');//填充内容
					}else{
						$pt->setCellValue($p, $v[$kt]);
					}
						
					$str++;
				}
			}
		}
		if(!empty($manuallywidth)){
			$str = 'A';
			foreach($manuallywidth as $width){
				$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
				$str++;
			}
		}
		//exit(0);
		// 输出下载文件 到浏览器
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
			$name = urlencode($name);
		} else {
			$name = str_replace(' ', '', $name);
		}
		
		$filename  = $name.".xls";//文件名,带格式
		
		header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
		header('Content-Type:application/x-msexecl;name="'.$name.'"');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		$objWriter->save('php://output');
	}

	public function _formatGradeScore($gradescoreList = array()){
		$returnArr = array();
		if(empty($gradescoreList)){
			return $returnArr;
		}
		foreach ($gradescoreList as  $gradescore) {
			$returnArr[$gradescore['grade']] = $gradescore;
		}
		return $returnArr;
	}

}
?>