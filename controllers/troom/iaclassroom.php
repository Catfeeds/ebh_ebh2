<?php
/**
 *互动课堂控制器
 */
class IaclassroomController extends CControl{
	public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $this->assign('roominfo',$roominfo);
        $this->assign('user',$user);
	}
	public function index(){
		$this->display('troom/iaclassroom_nav');
	}
	public function view(){

		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();

		//组织参数
		$iaclassroomModel = $this->model('iaclassroom');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$offset = max(($param['page']-1)*$param['pagesize'],0);
		$param['limit'] = $offset.','.$param['pagesize'];

		$iaList = $iaclassroomModel->getList($param);
		$iaListCount = $iaclassroomModel->getListCount($param);
		$pagestr = show_page($iaListCount,$param['pagesize']);

		$this->assign('q',$param['q']);
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->assign('iaList',$iaList);
		$this->assign('pagestr',$pagestr);
		$this->display('troom/iaclassroom');
	}
	/**
	 *添加一条记录
	 */
	public function add(){
		$rec = $this->input->post();
		if(empty($rec)){
			//获取教师所教班级信息
			$classes = $this->_getTeachClassInfo();
			$this->assign('classes',$classes);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->display('troom/iaclassroom_add');
		}else{
			$result = array();
			$param = $this->_getParam($rec);
			if(empty($param)){
				echo 0;exit;
			}
			$iaclassroomModel = $this->model('iaclassroom');
			if(!empty($rec['icid'])){
				//编辑
				$icid = intval($rec['icid']);
				if($this->_checkPower($icid) == false){
					echo 0;exit;
				}
				$where = array('icid'=>$icid);
				$res = $iaclassroomModel->_update($param,$where);
				if($res>0){
					//获取班级信息
					$classidArr = $this->_getClassidArr($rec);
					
					//删除互动关联的班级信息
					$iaclassroomModel->deleteClassInfo($where);

					if(!empty($classidArr)){
						//班级信息写入关联表
						$this->saveClassInfo($classidArr,$icid);
					}
				}
				echo $res;
			}else{
				//添加
				$res = $iaclassroomModel->_insert($param);
				if($res>0){//关联表写入
					//获取班级信息
					$classidArr = $this->_getClassidArr($rec);
					if(!empty($classidArr)){//选择班级则写入关联表
						$this->saveClassInfo($classidArr,$res);
					}
				}
				
				echo $res;
			}
			
		}
		
	}

	public function edit(){
		$icid = intval($this->uri->uri_attr(0));
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        if($this->_checkPower($icid)==false){
        	//没有权限或者互动已经删除
        	$this->display('troom/iaclassroom');
        	exit;
        }
        $param = array(
        	'icid'=>$icid,
        	'uid'=>$user['uid'],
        	'limit'=>1
        );
        $iaclassroomModel = $this->model('iaclassroom');
        $ia= $iaclassroomModel->getIa($param);
        $Upcontrol = Ebh::app()->lib('UpcontrolLib');

        //获取教师所教班级信息
		$classes = $this->_getTeachClassInfo();
		//获取互动关联的班级
		$iaclasses = $iaclassroomModel->getClassInfo($icid);
		$iaclasses = $this->_getFieldArr($iaclasses,'classid');

		$this->assign('iaclasses',$iaclasses);
		$this->assign('classes',$classes);
		$this->assign('Upcontrol',$Upcontrol);
        $this->assign('ia',$ia);
		$this->display('troom/iaclassroom_edit');
	}

	/**
	 *获取互动答题列表
	 */
	public function detail(){
		$icid = intval($this->uri->uri_attr(0));
		if(empty($icid)){
			show_404();
			exit;
		}
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        //获取互动详情
        $param_ia = array(
        	'uid'=>$user['uid'],
        	'icid'=>$icid
        );
        $iaclassroomModel = $this->model('iaclassroom');
        $ia= $iaclassroomModel->getIa($param_ia);
        if(empty($ia)){
        	show_404();
			exit;
        }
        $this->assign('ia',$ia);

        //获取互动关联的班级信息
		$filteredClasses = $this->_getReClassesInfo($icid);

		//筛选出需要获取答题的学生uid
		$stuAll = $this->_getStuInfo($filteredClasses);
		$stuid_in = $this->_getFieldArr($stuAll,'uid');
		if(empty($stuid_in)){
			show_404();
			exit;
		}
        $param_ialog = array(
        	'tid'=>$user['uid'],
        	'icid'=>$icid,
        	'stuid_in'=>'('.implode(',', $stuid_in).')'
        );
		$iaclassroomlogModel = $this->model('iaclassroomlog');
		$answerList = $iaclassroomlogModel->getAnswerList($param_ialog);
		//获取班级学生的数量之和
		$stunumAll = count($stuid_in);

		$this->assign('stunumAll',$stunumAll);
		$this->assign('classes',$filteredClasses);
		$this->assign('answerList',$answerList);
		$this->assign('notop',true);
		$this->display('troom/iaclassroom_detail');
	}
	/**
	 *删除一条记录
	 */
	public function deleteAjax(){
		$icid = intval($this->input->post('icid'));
		$chkres = $this->_checkPower($icid);
		if($chkres == false){
			echo 0;exit;
		}
		$param = array('icid'=>$icid);
		//删除互动
		$iaclassroomModel = $this->model('iaclassroom');
		$effrows = $iaclassroomModel->_delete($param);
		//删除互动下面的答疑
		$iaclassroomlogModel = $this->model('iaclassroomlog');
		$iaclassroomlogModel->_delete($param);
		//删除互动关联的班级信息
		$iaclassroomModel->deleteClassInfo($param);

		echo $effrows;
	}
	/**
	 *获取并且组织POST参数
	 */
	private function _getParam($param = array()){
		$returnArr = array();
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        if(empty($param['title'])){
        	return $returnArr;
        }
        $title = h($param['title']);
        $resource = !empty($param['thumb']['upfilepath'])?$param['thumb']['upfilepath']:"";
      	$returnArr = array(
      		'uid'=>$user['uid'],
      		'crid'=>$roominfo['crid'],
      		'title'=>$title,
      		'dateline'=>time(),
      		'resource'=>$resource,
      		'fromip'=>$this->input->getip()
      	);
      	return $returnArr;
	}
	/**
	 *获取POST传递过来的classid信息
	 *
	 */
	private function _getClassidArr($param = array()){
		$returnArr = array();

		//获取教师所有班级
		$classes = $this->_getTeachClassInfo();
		$classes = $this->_getFieldArr($classes,'classid');

		if(!empty($param['classes'])){
			//将非法班级剔除
			$returnArr = array_intersect($classes,$param['classes']);
		}else{//没传递班级默认所有班级
			
		}
		return $returnArr;
	}

	/**
	 *检测当前用户是否是该互动的所有者
	 */
	private function _checkPower($icid){
		$icid = intval($icid);
		if(empty($icid)){
			return false;
		}
		$user = Ebh::app()->user->getloginuser();
		$iaclassroomModel = $this->model('iaclassroom');
		$param = array(
			'uid'=>$user['uid'],
			'icid'=>$icid
		);
		$iaInfo = $iaclassroomModel->getIa($param);
		return !empty($iaInfo)?true:false;
	}

	/**
	 *ajax获取答疑列表
	 */
	public function getDetailAjax(){
		$icid = $this->input->post('icid');
        $user = Ebh::app()->user->getloginuser();
        if(empty($user)){
        	echo json_decode(array());exit;
        }
         //获取互动关联的班级信息
		$filteredClasses = $this->_getReClassesInfo($icid);
		//获取班级所有的学生数目字段
		$stunumArr = $this->_getFieldArr($filteredClasses,'stunum');
		if(empty($stunumArr)){
			show_404();
			exit;
		}

		//筛选出需要获取答题的学生uid
		$stuAll = $this->_getStuInfo($filteredClasses);
		$stuid_in = $this->_getFieldArr($stuAll,'uid');
		if(empty($stuid_in)){
			show_404();
			exit;
		}
		if(is_array($stuid_in)) {
			$stuid_in = '('.implode(',',$stuid_in).')';
		}
        $param_ialog = array(
        	'tid'=>$user['uid'],
        	'icid'=>$icid,
        	'stuid_in'=>$stuid_in
        );
		$iaclassroomlogModel = $this->model('iaclassroomlog');
		$answerList = $iaclassroomlogModel->getAnswerList($param_ialog);
		echo json_encode($answerList);
	}

	//关联表写入数据
	public function saveClassInfo($classidArr = array(),$icid = 0){
		if(empty($classidArr) || empty($icid)){
			return;
		}
		$iaclassroomModel = $this->model('iaclassroom');
		$user = Ebh::app()->user->getloginuser();
		foreach ($classidArr as $classid) {
			$iaclassroomModel->saveClassInfo(array('icid'=>$icid,'classid'=>$classid));
		}
	}

	//获取老师所在学校的所教的班级信息
	private function _getTeachClassInfo(){
		$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
		$classesModel = $this->model('classes');
		return  $classesModel->getTeacherClassList($roominfo['crid'],$user['uid']);
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
	 *获取互动关联班级信息
	 */
	private function _getReClassesInfo($icid = 0){
		//获取互动关联的班级信息
		$filteredClasses = array();
		$iaclassroomModel = $this->model('iaclassroom');
		$reclasses = $iaclassroomModel->getClassInfo($icid);
		if(!empty($reclasses)){
			$reclasses = $this->_getFieldArr($reclasses,'classid');
			//获取老师所教班级
			$classes = $this->_getTeachClassInfo();
		
			foreach ($classes as $class) {
				if(in_array($class['classid'], $reclasses)){
					$filteredClasses[] = $class;
				}
			}
		}else{
			//获取老师所教班级
			$filteredClasses = $this->_getTeachClassInfo();
		}
		return $filteredClasses;
	}

	//获取需要回答的学生的信息数组
	private function _getStuInfo($classes = array()){
		if(empty($classes)){
			return ;
		}
		//筛选出需要获取答题的学生uid
		$classidlist = $this->_getFieldArr($classes,'classid');
		$classesModel = $this->model('classes');
		$param = array(
			'classidlist'=>implode(',', $classidlist),
			'limit'=>10000
		);
		$stuAll = $classesModel->getClassStudentList($param);
		return $stuAll;
	}

}