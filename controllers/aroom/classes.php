<?php
/*
学校班级
*/
class ClassesController extends CControl{
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
		//Ebh::app()->room->checkteacher();
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
		$this->display('aroom/classes');
	}
	public function add(){
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()){
			$param['crid'] = $roominfo['crid'];
			$param['classname'] = $this->input->post('classname');
			$param['grade'] = intval($this->input->post('grade'));
			$classes = $this->model('classes');
			$classes->addclass($param);
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
			header('location:'.geturl('aroom/classes'));
		}
		else{
			$this->assign('roominfo',$roominfo);
			$this->display('aroom/classes_add');
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
		$this->display('aroom/classes_edit');
	}
	
	/*
	删除
	*/
	public function deleteclass(){
		$param['classid'] = $this->input->post('classid');

		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$classes = $this->model('classes');
		//查看该班级是否存在于本学校
		$result = $classes->getroomClassList($crid,$param['classid']);
		if(!empty($result)){
			$res = $classes->deleteclass($param);
			if($res)
				echo json_encode(array('code'=>1,'message'=>'删除成功'));
			else
				echo json_encode(array('code'=>0,'message'=>'删除失败'));
		}else{
			echo json_encode(array('code'=>0,'message'=>'删除失败,请刷新后重试!'));
		}
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

		header('location:'.geturl('aroom/classes'));
		//var_dump($this->input->post());
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

		//获得修改前该班级的教师列表
		$ctlist = $classes->getClassTeacherByClassid($param['classid']);
		//教师id处理
		$teacherids = $this->input->post('teacherids');
		$tidArr = $this->_filterTeacher($teacherids);
		$tids = implode(',',$tidArr);
		$param['teacherids'] = $tids;
		$classes->chooseteacher($param);
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
		$uidarr = $classesmodel->getClassStudentUid($classid);
		$uids = '';
		$cslist = array();//需要删除缓存的学生列表
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
		$param['classid'] = $classid;
		// var_dump($param);
		$result = $classesmodel->deleteMultiStudentFromClass($param);
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