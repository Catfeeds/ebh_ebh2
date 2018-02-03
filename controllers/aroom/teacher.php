<?php
/*
学校教师
*/
class TeacherController extends CControl{
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
        //Ebh::app()->room->checkteacher();
	}
	public function index(){
		$user = Ebh::app()->user->getAdminLoginUser();
		$roominfo = Ebh::app()->room->getcurroom();
		$teacher = $this->model('teacher');
		$param = parsequery();
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],$param);
		$teachercount = $teacher->getroomteachercount($roominfo['crid'],$param);
		$pagestr = show_page($teachercount);
		$this->assign('pagestr',$pagestr);
		$this->assign('user',$user);
		$this->assign('room',$roominfo);
		$this->assign('search',$param['q']);
		$this->assign('roomteacherlist',$roomteacherlist);
		$this->display('aroom/teacher');
	}
	
	public function add(){
		if($this->input->post()){
			$checkonly = $this->input->post('checkonly');
			$loginuser = Ebh::app()->user->getAdminLoginUser();
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
						if(!empty($classlist)){
							$code = 2;
							$message = '该用户已经在这个教室';
						}elseif(!$checkonly){
							$teacher = $this->model('teacher');
							$param['tid'] = $teacherinfo['uid'];
							$param['crid'] = $roominfo['crid'];
							$param['status'] = 1;
							$param['dateline'] = SYSTIME;
							$param['role'] = 1;
							$teacher->addroomteacher($param);

							//更新SNS网校用户缓存
							$snslib = Ebh::app()->lib('Sns');
							$snslib->updateRoomUserCache(array('crid'=>$roominfo['crid'],'uid'=>$teacherinfo['uid']));
							//同步SNS数据(用户网校操作)
							$snslib->do_sync($teacherinfo['uid'], 4);
							Ebh::app()->lib('xNums')->add('user');
        					Ebh::app()->lib('xNums')->add('teacher');
							header('location:'.geturl('aroom/teacher'));


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
					header('location:'.geturl('aroom/teacher'));
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
			$this->display('aroom/teacher_add');
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
			Ebh::app()->lib('xNums')->add('teacher',-1);
			//删除缓存
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
		$this->display('aroom/teacher_edit');
	}
	
	public function edit(){
		$teacher = $this->model('teacher');
		$param['uid'] = $this->input->post('uid');
		$param['realname'] = $this->input->post('realname');
		$param['mobile'] = $this->input->post('mobile');
		$teacher->editteacher($param);
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
		header('location:'.geturl('aroom/teacher'));
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
		fastcgi_finish_request();
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
		
		$this->display('aroom/teacher_input');

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
		
		$classarr = array();//初始化需要更新班级用户缓存的列表
		for($i=0;$i<$teanum;$i++){
			$classtarr[$i]['uid'] = $fromuid + $i;
			$foldertarr[$i]['uid'] = $fromuid + $i;
			//需要更新网校用户缓存的列表
			$roomtarr[] = array('crid' => $crid, 'uid' => $fromuid + $i);
			//需要更新网校用户缓存的列表
			foreach ($classtarr[$i]['classidarr'] as $classid)
			{
				$classarr[] = array('classid' => $classid, 'uid' => $fromuid + $i);
			}
		}
		$classes->addTeacherToClass($classtarr);
		$folder->addTeacherToFolder($foldertarr,$crid);

		$snslib = Ebh::app()->lib('Sns');
		$snslib->updateClassUserCacheM($classarr);//更新班级用户缓存
		$snslib->updateRoomUserCacheM($roomtarr);//更新网校用户缓存
		Ebh::app()->lib('xNums')->add('user',$teanum);
        Ebh::app()->lib('xNums')->add('teacher',$teanum);
		$result['rowcount'] = $rowcount;

		//同步SNS数据(用户网校操作)
		for($i=0;$i<$teanum;$i++){
			$snslib->do_sync($fromuid + $i, 4);
		}

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
}
?>