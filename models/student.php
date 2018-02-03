<?php
/*
学校学生
*/
class StudentController extends CControl{
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
	}
	public function index(){
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
		$this->display('aroomv2/student_classlist');
		
	}
	public function list_view(){
		
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
		$classlist = $classes->getroomClassList($roominfo['crid']);
		// var_dump($param);
		$pagestr = show_page($roomusercount);
		$this->assign('classid',$classid);
		$this->assign('pagestr',$pagestr);
		$this->assign('search',$param['q']);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->assign('roomuserlist',$roomuserlist);
		$this->display('aroomv2/student_list');
	}
	
	public function edit(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $this->input->post('uid');
		$param['cnname'] = $this->input->post('realname');
		$param['sex'] = $this->input->post('sex');
		$param['birthdate'] = strtotime($this->input->post('birthdate'));
		$param['oldclassid'] = $this->input->post('oldclassid');
		$param['classid'] = $this->input->post('classid');
		$param['email'] = $this->input->post('email');
		$param['mobile'] = $this->input->post('mobile');
		$member = $this->model('member');
		$member->editmember($param);
		$roomuser = $this->model('roomuser');
		$res = $roomuser->editstudent($param);
		if(isset($res))
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
				if($userinfo['groupid'] != 6){
					$code = 0;
					$message = '不允许添加教师账号';
				}else{
					$roomuser = $this->model('roomuser');
					$roomuserlist = $roomuser->getroomuserdetail($roominfo['crid'],$userinfo['uid']);
					if(!empty($roomuserlist)){
						$code = 0;
						$message = '该用户已经在该教室内';
					}elseif(!$checkonly){
						$member = $this->model('member');
						$param['crid'] = $roominfo['crid'];
						$param['uid'] = $userinfo['uid'];
						$param['cnname'] = $this->input->post('realname');
						$param['sex'] = $this->input->post('sex');
						$param['birthdate'] = strtotime($this->input->post('birthdate'));
						$param['mobile'] = $this->input->post('mobile');
						$param['email'] = $this->input->post('email');
						$roomuser->insert($param);
						$param['classid'] = $this->input->post('classid');
						$classes = $this->model('classes');
						$classes->addclassstudent($param);
						echo 1;
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
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $this->input->post('uid');
		$roomuser = $this->model('roomuser');
		
		$studentdetail = $roomuser->getaroomstudentdetail($param['crid'],$param['uid']);
		$param['classid'] = $studentdetail['classid'];
		$classes = $this->model('classes');
		$res = $classes->deletestudent($param);
		
		if($res)
		echo json_encode(array('code'=>1,'message'=>'删除成功'));
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
	}
	
	
	public function input(){
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
		$roominfo = Ebh::app()->room->getcurroom();
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
		$this->display('aroomv2/student_input');
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
	//	姓名	登录账号	性别	班级
		$realnamecol = 0;
		$usernamecol = 0;
		$sexcol = 0;
		$classcol = 0;
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
				} else if($colval == '班级') {
					$classcol = $j;
				} else if($colval == '密码') {
					$passwordcol = $j;
				} else if($colval == '学校名称') {
					$schoolnamecol = $j;
				}
			}
			if(!empty($realnamecol) && !empty($usernamecol) && !empty($sexcol) && !empty($classcol)) {	//找到标题行
				$titlerownum = $i;
				break;
			}
		}
		if($titlerownum == 0) {
			$result['errormsg'] = '文件内容不正确，请按照系统提供的导入模板格式进行上传。必须包含带有 姓名/登录账号/性别/班级 字段的标题行。';
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
		
		if($realnamecol == 0)
			$realnamecol_err = 1;
		if($usernamecol == 0)
			$usernamecol_err = 1;
		if($sexcol == 0)
			$sexcol_err = 1;
		if($classcol == 0)
			$classcol_err = 1;
		if(empty($passwordcol))
			$passwordcol_err = 1;
		if(empty($schoolnamecol))
			$schoolnamecol_err = 1;
		for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			$realname = empty($realnamecol_err)?$reader->sheets[0]['cells'][$i][$realnamecol]:'';
			$realname = trim($realname);
			$username = empty($usernamecol_err)?$reader->sheets[0]['cells'][$i][$usernamecol]:'';
			$username = trim($username);
			$sex = empty($sexcol_err)?$reader->sheets[0]['cells'][$i][$sexcol]:'';
			$sex = trim($sex);
			$classname = empty($classcol_err)?$reader->sheets[0]['cells'][$i][$classcol]:'';
			$classname = trim($classname);
			$password = empty($passwordcol_err)?$reader->sheets[0]['cells'][$i][$passwordcol]:'';
			$password = trim($password);
			$schoolname = empty($schoolnamecol_err)?$reader->sheets[0]['cells'][$i][$schoolnamecol]:'';
			$schoolname = trim($schoolname);
			if(empty($realname) || empty($username) || empty($sex) || empty($classname)) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，姓名、登录账号、性别、班级不能为空，请修改文件后重新上传';
				break;
			}
			if(!isset($classnamelist[$classname])) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，'.$classname.' 还不存在，请先添加班级。';
				break;
			}
			if(strlen($realname) > 30 || strlen($username) > 20) {
				$result['errormsg'] = '第 '.$i.' 行 姓名或登录账号太长，请调整。';
				break;
			}
			if(!preg_match('/^[a-zA-Z_][a-z0-9A-Z_]{5,19}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-20位英文、数字、“_”的组合字符，必须以英文字母打头，请调整。';
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
			$userlist[$username] = array('rownum'=>$i,'realname'=>$realname,'username'=>$username,'sex'=>$sex,'classid'=>$classnamelist[$classname]['classid'],'password'=>$password,'schoolname'=>$schoolname);
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
		
		$member = $this->model('member');
		$classes = $this->model('classes');
		$roomuser = $this->model('roomuser');
		$userpass = '123456';	//默认密码123456
		$creditmodel = $this->model('credit');
		$credit = $creditmodel->getCreditRuleInfo(1);
		$uarr = array();
		$classarr = array();
		$roomarr = array();
		foreach($userlist as $iuser) {	//导入数据
			$username = $iuser['username'];
			$realname = $iuser['realname'];
			$sex = $iuser['sex'];
			$classid = $iuser['classid'];
			$schoolname = $iuser['schoolname'];
			//插入用户信息
			// $uid = $member->addmember(array('username'=>$username,'password'=>$userpass,'realname'=>$realname,'sex'=>$sex,'dateline'=>SYSTIME));
			if(!empty($iuser['password']))
				$userpass = $iuser['password'];
			$uarr[] = array('username'=>$username,'password'=>$userpass,'realname'=>$realname,'sex'=>$sex,'dateline'=>SYSTIME,'credit'=>$credit,'schoolname'=>$schoolname);
			$classarr[] = array('classid'=>$classid,'crid'=>$crid);
			$roomarr[] = array('crid'=>$crid,'cnname'=>$realname,'sex'=>$sex);
			//插入用户班级信息
			// $classes->addclassstudent(array('uid'=>$uid,'classid'=>$classid,'crid'=>$crid));
			//插入用户平台信息
			// $roomid = $roomuser->insert(array('crid'=>$crid,'uid'=>$uid,'cnname'=>$realname,'sex'=>$sex));
		}
		$stunum = count($uarr);
		$fromuid = $member->addMultipleMembers($uarr);
		$creditmodel->addRegLogs($fromuid,$stunum);
		for($i=0;$i<$stunum;$i++){
			$classarr[$i]['uid'] = $fromuid + $i;
			$roomarr[$i]['uid'] = $fromuid + $i;
		}
		$classes->addMultipleStudent($classarr);
		$roomuser->addMultipleStudent($roomarr);
		
		
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
			
			if(strlen($realname) > 30 || strlen($username) > 16) {
				$result['errormsg'] = '第 '.$i.' 行 姓名或登录账号太长，请调整。';
				break;
			}
			if(!preg_match('/^[a-z0-9A-Z_]{6,16}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-16位英文、数字、“_”的组合字符，请调整。';
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
		$usernamearr = $user->getUserlistByUsernameOnScb($usernameinlist);
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
			
			if(empty($username) || empty($classname)) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，登录账号、班级不能为空，请修改文件后重新上传';
				break;
			}
			if(!isset($classnamelist[$classname])) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，'.$classname.' 还不存在，请先添加班级。';
				break;
			}
			
			if(!preg_match('/^[a-z0-9A-Z_]{6,16}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-16位英文、数字、“_”的组合字符，请调整。';
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
		$classes->studentUpgrade($param,$userlist);
		
		
		
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
}
?>