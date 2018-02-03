<?php
/*
学校班级
*/
class ClassesController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	
	/*
	班级学生导航页
	*/
	public function student(){
		$this->display('aroomv2/classstudent');
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
		$classheadteacher = array();
		foreach($classlist as $class){
			$classheadteacher[$class['classid']] = $class['headteacherid'];
		}
		$class = array();
		//处理班级拥有的教师
		foreach($classteacherlist as $ct){
			if(isset($classheadteacher[$ct['classid']]) && $classheadteacher[$ct['classid']] == $ct['uid']){
				$temp_realname = '<span title="班主任"><img src="http://static.ebanhui.com/ebh/tpl/default/images/icon_star_2.gif" style="top:1px" />'.$ct['realname'].'</span>';
			}
			else
			{
				$temp_realname = $ct['realname'];
			}
			if(!empty($class[$ct['classid']]['teacherids'])){
				$class[$ct['classid']]['teacherids'].= ','.$ct['uid'];
				$class[$ct['classid']]['teachers'].= '，'.$temp_realname;
			}
			else{
				$class[$ct['classid']]['teacherids'] = $ct['uid'];
				$class[$ct['classid']]['teachers'] = $temp_realname;
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
		$this->assign('roominfo',$roominfo);
		$this->assign('roomteacherlist',$roomteacherlist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/classes');
	}
	public function add(){
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()){
			$param['crid'] = $roominfo['crid'];
			$param['classname'] = $this->input->post('classname');
			$param['grade'] = intval($this->input->post('grade'));
			$classes = $this->model('classes');
			$class = $classes->addclass($param);
			if($class != false)
				echo 1;
			/**写日志开始**/
			$message = '['.implode(',', $param).']';
			Ebh::app()->lib('LogUtil')->add(
				array(
					'toid'=>$param['crid'],
					'message'=>$message,
					'opid'=>4,
					'type'=>'classroom'
					)
			);
			/**写日志结束**/
		}
		else{
			$this->assign('roominfo',$roominfo);
			$this->display('aroomv2/classes_add');
		}
	}
	/*
	班级名是否存在
	*/
	public function classnameexists(){
		$classes = $this->model('classes');
		$param['classname'] = $this->input->post('classname');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
					
		if($classes->classnameexists($param)){
			echo 1;
		}else{
			echo 0;
		}
	}
	/*
	修改班级页面
	*/
	public function edit_view(){
		$classes = $this->model('classes');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['classid'] = $this->uri->itemid;
		$classdetail = $classes->getclassdetail($param);
		$this->assign('classdetail',$classdetail);
		$this->assign('roominfo',$roominfo);
		$this->display('aroomv2/classes_edit');
	}
	
	/*
	删除
	*/
	public function deleteclass(){
		$roominfo = Ebh::app()->room->getcurroom();
		
		$param['classid'] = $this->input->post('classid');
		$classes = $this->model('classes');
		$class = $classes->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$param['classid']));
		$count = $classes->getSchoolClassCount($roominfo['crid'],99,array());
		if($count['count'] <= 1 ){
			echo json_encode(array('code'=>0,'message'=>'删除失败,班级数不能少于1个！'));
			exit();
		}
		if(!empty($class) && $class['stunum'] == 0){
			$res = $classes->deleteclass($param);
			if(!empty($res))
				echo json_encode(array('code'=>1,'message'=>'删除成功'));
		}
		elseif($class['stunum'] > 0)
			echo json_encode(array('code'=>0,'message'=>'该班级下还有学生，不能删除！'));
		
		
		/**写日志开始**/
		fastcgi_finish_request();
		$message = '['.implode(',', $param).']'.(empty($res)?'删除失败':'删除成功');
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['classid'],
				'message'=>$message,
				'opid'=>4,
				'type'=>'class'
				)
		);
		/**写日志结束**/

		//删除SNS班级用户缓存
		if($res)
		{
			$snslib = Ebh::app()->lib('Sns');
			$snslib->delClassUserCacheAll(array('classid' => $param['classid']));
		}
	}
	
	public function edit(){
		$classes = $this->model('classes');
		$param = $this->input->post();
		$result = $classes->editclass($param);
		if($result !== false)
		echo 1;
		/**写日志开始**/
		$message = '编辑班级 '.(!empty($result)?'成功':'失败').'[ '.implode(',', $param).' ] ';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['classid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'class'
				)
		);
		/**写日志结束**/

		//var_dump($this->input->post());
	}
	/**
	 * 导入班级
	 */
	public function input(){
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
					$iresult = $this->inputclasses($filesavepath,$roominfo['crid']);
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
		$this->assign('roominfo',$roominfo);
		if(intval($this->input->get('aroomv')) == 3){
			$this->display('aroomv3/classes_input');
		}else{
			$this->display('aroomv2/classes_input');
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
	function inputclasses($filepath,$crid) {
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
		$sexcol = 0;
		$classcol = 0;
		for ($i = 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $reader->sheets[0]['numCols']; $j++) {	//找到标题行
				$colval = trim($reader->sheets[0]['cells'][$i][$j]);
				$colval = str_replace(' ','',$colval);
				if($colval == '教师') {
					$realnamecol = $j;
				} else if($colval == '账号') {
					$usernamecol = $j;
				} else if($colval == '教学班名称') {
					$classcol = $j;
				}
			}
			if(!empty($realnamecol) && !empty($usernamecol) && !empty($classcol)) {	//找到标题行
				$titlerownum = $i;
				break;
			}
		}
		if($titlerownum == 0) {
			$result['errormsg'] = '文件内容不正确，请按照系统提供的导入模板格式进行上传。必须包含带有 教学班名称,教师,账号 字段的标题行。';
			return $result;
		}
		$usernameinlist = '';
		$usernamearr = array();
		if($realnamecol == 0)
			$realnamecol_err = 1;
		if($usernamecol == 0)
			$usernamecol_err = 1;
		if($classcol == 0)
			$classcol_err = 1;
		for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			$realname = empty($realnamecol_err)?(isset($reader->sheets[0]['cells'][$i][$realnamecol])?$reader->sheets[0]['cells'][$i][$realnamecol]:''):'';
			$realname = trim($realname);
			$username = empty($usernamecol_err)?(isset($reader->sheets[0]['cells'][$i][$usernamecol])?$reader->sheets[0]['cells'][$i][$usernamecol]:''):'';
			$username = trim($username);
			$classname = empty($classcol_err)?(isset($reader->sheets[0]['cells'][$i][$classcol])?$reader->sheets[0]['cells'][$i][$classcol]:''):'';
			$classname = trim($classname);
			$password = '123456';
			$schoolname = '绿城育华';
			if(empty($realname) && empty($username) && empty($classname)) {	//这些字段为空 则认为是空行
				continue;
			}
			if(empty($realname) || empty($username) || empty($classname)) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，教师、账号、教学班名称不能为空，请修改文件后重新上传';
				break;
			}
			if(strlen($realname) > 30 || strlen($username) > 20) {
				$result['errormsg'] = '第 '.$i.' 行 姓名或登录账号太长，请调整。';
				break;
			}
			if(!preg_match('/^[a-z0-9A-Z][a-z0-9A-Z_]{5,19}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-20位英文、数字的组合字符，请调整。';
				break;
			}
			if (isset($datalist[$classname])) {
				$pdata = $datalist[$classname];
				$prerow = $pdata['rownum'];
				$result['errormsg'] = '第 '.$prerow.' 与 '.$i.' 行 教学班名称重复，请调整。';
				break;
			}
			$realname = str_replace('\'','',$realname);
			$username = str_replace('\'','',$username);
			$usernamearr[]  = '\''.$username.'\'';
			if(empty($classnameinlist))
				$classnameinlist = '\''.$classname.'\'';
			else
				$classnameinlist .= ','. '\''.$classname.'\'';
			$datalist[$classname] = array('rownum'=>$i,'realname'=>$realname,'username'=>$username,'sex'=>0,'classname'=>$classname,'password'=>$password,'schoolname'=>$schoolname);
			$rowcount ++;
		}
		if (!empty($result['errormsg'])) {
			return $result;
		}
		if (empty($classnameinlist)) {
			$result['errormsg'] = '读取文件过程出错，若文件记录数过大，您可以将文件分拆后再上传。';
			return $result;
		}
		$userex = array();
		$userexr = array();
		$userarr = array();
		if(!empty($usernamearr)){
			$usermodel = $this->model('user');
			$usernamearr = array_unique($usernamearr);
			$usernamelist = implode($usernamearr,',');
			$userex = $usermodel->getUserinfoByUsername($usernamelist);
			foreach ($userex as $us) {
				$userexr[$us['username']] = $us;
				$userarr[] = $us['username'];
			}
		}
		$classes = $this->model('classes');
		$classnamearr = $classes->getclasslistbyclassname($crid,$classnameinlist);
		if(!empty($classnamearr)) {	//重复账号判断
			$result['erroritems'] = array();
			foreach($classnamearr as $class) {
				if(isset($datalist[$class['classname']])) {
					$result['erroritems'][] = '第 '.$datalist[$class['classname']]['rownum'].' 行 班级 '.$class['classname'].' 已存在';
				}
			}
			return $result;
		}
		
		//导入数据开始
		$member = $this->model('member');
		$classes = $this->model('classes');
		$roomtuser = $this->model('roomteacher');
		$teacherm = $this->model('teacher');
		
		$tuarr = array();
		$troomarr = array();
		$teachers = array();
		$classarr = array();
		$classteachers = array();
		foreach($datalist as $iuser) {	//导入数据
			$username = $iuser['username'];
			$realname = $iuser['realname'];
			$schoolname = $iuser['schoolname'];
			$userpass = $iuser['password'];
			$classname = $iuser['classname'];
			$rownum = $iuser['rownum'];
			if(!isset($tuarr[$username])){
				$tuarr[$username] = array(
										'username'=>$username,
										'password'=>$userpass,
										'realname'=>$realname,
										'dateline'=>SYSTIME,
										'schoolname'=>$schoolname,
										'classname'=>array($classname),
										'groupid'=>5,
										'sex'=>0,
										'rownum'=>$rownum
									);
				$troomarr[$username] = array('crid'=>$crid,'status'=>1,'role'=>1);
			}else{
				$tuarr[$username]['classname'][] = $classname;
			}
			$classarr[] = array('crid'=>$crid,'classname'=>$classname,'stunum'=>0,'dateline'=>SYSTIME);
			
		}
		$tuarrother = array();
		$j = 1;
		foreach ($tuarr as $key => $uex) {
			if(!in_array($key,$userarr)){
				$tuarrother[$j] = $uex;
			}else{
				$uex['uid'] = $userexr[$key]['uid'];
				$userready[$j] = $uex;
			}
			$j++;
		}
		if(!empty($userready)){
			$theroomteacher = $roomtuser->getTeachersByIds(array_column($userready,'uid'),$crid);
			foreach($theroomteacher as $roomteacher){
				$roomteacherarr[$roomteacher['uid']] = $roomteacher;
			}
			
			$result['erroritems'] = array();
			foreach($userready as $user){
				if(empty($roomteacherarr[$user['uid']])){
					$result['erroritems'][] = '第 '.$user['rownum'].' 行 教师'.$user['username'].' 已存在,但不是本校的老师';
				}
			}
			if(!empty($result['erroritems']))
				return $result;
			
		}
		
		$classcount = count($classarr);
		//批量导入班级
		$fromclassid = $classes->addMulticlasses($classarr);
		$offset = $member->getAutoIncrementOffset();	//获取数据库自增增量

		$classlist = array();
		for($i=0;$i<$classcount;$i++){
			$classid = $fromclassid + $i*$offset;
			$classlist[$classarr[$i]['classname']] = $classid;
		}
		
		//批量导入教师用户
		
		
		if(!empty($tuarrother)){
			$fromuid = $member->addMultipleMembers($tuarrother);
		
			$i = 0;
			foreach ($tuarrother as $key=>$val){
				$troomarr[$val['username']]['tid'] = $fromuid + $i*$offset;
				$teachers[$val['username']]['teacherid'] = $fromuid + $i*$offset;
				$teachers[$val['username']]['realname'] = $val['realname'];
				$teachers[$val['username']]['sex'] = 0;
				$teachers[$val['username']]['nickname'] = '';
				foreach ($val['classname'] as $cname){
					$classid = $classlist[$cname];
					$classteachers[] = array('uid'=>$troomarr[$val['username']]['tid'],'classid'=>$classid,'folderid'=>0);
				}
				$i++;
			}
		}
		if(!empty($userready)){
			foreach ($userready as $key => $val) {
				$uid = $val['uid'];
				foreach ($val['classname'] as $cname){
					$classid = $classlist[$cname];
					$classteachers[] = array('uid'=>$uid,'classid'=>$classid,'folderid'=>0);
				}
			}
		}
		$roomtuser->addMultipleTeacher($troomarr);
		$teacherm->addMultipleTeacher($teachers);
		$classes->addMultiTeacherClasses($classteachers);
		
		
		
		$result['rowcount'] = $rowcount;
		
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
	选择教师
	*/
	public function chooseteacher(){
		$classes = $this->model('classes');
		$param['classid'] = $this->input->post('classid');
		//$param['teacherids'] = $this->input->post('teacherids');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];

		//check classid
		$classdetail = $classes->getclassdetail($param);
		if (empty($classdetail)){
			echo '0';
			exit;
		}

		//获得修改前该班级的教师列表
		$ctlist = $classes->getClassTeacherByClassid($param['classid']);
		
		//教师id处理
		$teacherids = $this->input->post('teacherids');
		$tidArr = $this->_filterTeacher($teacherids);
		$tids = implode(',',$tidArr);
		$param['teacherids'] = $tids;
		$classes->chooseteacher($param);

		//班主任id处理
		$headteacherid = $this->input->post('headteacherid');
		if (!empty($headteacherid) && in_array($headteacherid, $tidArr)){
			$param['headteacherid'] = $headteacherid;
		} else {
			$param['headteacherid'] = 0;
		}
		$classes->chooseheadteacher($param);
		echo 1;
		/**写日志开始**/
		fastcgi_finish_request();
		$message = '选择教师 [ '.implode(',', $param).' ] ';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['classid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'class'
				)
		);
		/**写日志结束**/

		//SNS班级用户缓存更新
		$snslib = Ebh::app()->lib('Sns');
		if (!empty($ctlist))
		{
			$snslib->delClassUserCacheM($ctlist);
		}

		$idarr = explode(',',$param['teacherids']);
		$ctarr = array();
		foreach ($idarr as $id)
		{
			if (!empty($id))
			{
				$ctarr[] = array('classid'=>$param['classid'], 'uid'=>$id);
			}
		}
		if (!empty($ctarr))
		{
			$snslib->updateClassUserCacheM($ctarr);
		}
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

	/*
	获取学校教师
	*/
	public function getroomteachers(){
		$teacher = $this->model('teacher');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['q'] = $this->input->get('q');
		$param['pagesize'] = 1000;
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],$param);
		echo json_encode($roomteacherlist);
	}
	
	/*
	初始化班级
	*/
	public function initclass(){
		// var_dump($this->input->post());
		$classid = $this->input->post('classid');
		if(!is_numeric($classid))
			exit;
		$roominfo = Ebh::app()->room->getcurroom();
		$classesmodel = $this->model('classes');
		$classdetail = $classesmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
		if(empty($classdetail))
			exit;
		$count = $classesmodel->getClassStudentCount(array('classid'=>$classid));		
		$uidarr = $classesmodel->getClassStudentUid($classid);
		$flag = false;
		if($count == $roominfo['stunum']){
			array_shift($uidarr);
			$flag = true;
		}
		$uids = '';
		$cslist = array();//需要删除缓存的学生列表
		$result = false;
		$param = array('classid'=>$classid);
		if(!empty($uidarr)){
			foreach($uidarr as $uid){
				$uids.= $uid['uid'].',';
				$cslist[] = array(
					'classid' => $classid,
					'crid' => $roominfo['crid'],
					'uid' => $uid['uid']
				);
			}
			$uids = rtrim($uids,',');
			
			$param['stunum'] = count($uidarr);
			$param['crid'] = $roominfo['crid'];
			$param['uids'] = $uids;
			// var_dump($param);
			$result = $classesmodel->deleteMultiStudentFromClass($param,$flag);
		}
		if(!empty($result))
			echo 1;
		else
			echo 0;

		/**写日志开始**/
		fastcgi_finish_request();
		$message = '初始化班级 '.(!empty($result)?'成功':'失败').'[ '.implode(',', $param).' ] ';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['classid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'class'
				)
		);
		/**写日志结束**/

		if(!empty($result))
		{
			$snslib = Ebh::app()->lib('Sns');
			//删除班级用户缓存，删除网校用户缓存
			$snslib->delClassUserCacheM($cslist);
			$snslib->delRoomUserCacheM($cslist);

			//调用SNS同步接口，类型为4用户网校操作
			foreach ($cslist as $cs)
			{
				$snslib->do_sync($cs['uid'], 4);
			}
		}
	}
	
}
?>