<?php
/*锁屏控制器*/
class SlockController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        $this->roominfo = $roominfo = Ebh::app()->room->getcurroom();
        $this->user = $user = Ebh::app()->user->getloginuser();
        $this->assign('user',$user);
    }

	public function index(){
		$uid = $this->user['uid'];
		$crid = $this->roominfo['crid'];
		$param = parsequery();
		$param['uid'] = $uid;
		$param['crid'] = $crid;
		$param['limit'] = 1000;
		//获取有效的锁屏
		$valideList = $this->model('slock')->getValidSlockList($param);
		if(!empty($valideList)){
			$valideList = EBH::app()->lib('UserUtil')->init($valideList,array('uid'),true);
			$param['lockid_not_in'] = $this->_getFieldArr($valideList,'lockid');
		}
		//获取非有效的锁屏
		unset($param['limit']);
		$slockList = $this->model('slock')->getList($param);
		$slockList = EBH::app()->lib('UserUtil')->init($slockList,array('uid'),true);
		$slockListCount = $this->model('slock')->getListCount($param);
		$pagestr = show_page($slockListCount,$param['pagesize']);

		$lockid_a = $this->_getFieldArr($valideList,'lockid');
		$lockid_b = $this->_getFieldArr($slockList,'lockid');
		$lockids = array_merge($lockid_a,$lockid_b);
		$target_db = $this->model('slock')->getLockTarget($lockids);

		$this->assign('valideList',$valideList);
		$this->assign('slockList',$slockList);
		$this->assign('pagestr',$pagestr);
		$this->assign('target_db',$target_db);

        $this->display('troom/slock');
	}

	public function add(){
		$rec = $this->input->post('param');
		if(!empty($rec)){
			parse_str($rec,$querystr);
			$param = $this->getParam($querystr);
			$cgInfo = $this->getCGInfo($querystr);
			$param['classes'] = $cgInfo;
			$slockModel = $this->model('slock');
			$res = $slockModel->addLock($param);
			$ret = array('status'=>0,'msg'=>'添加成功');
			if(empty($res)){
				$ret['status'] = 1;
				$ret['msg'] = '添加失败';
			}
			echo json_encode($ret);
			exit;
		}else{
			$classes = $this->_getClasses();
			$grades = $this->_getGrades();
			$this->assign('classes',$classes);
			$this->assign('grades',$grades);
	        $this->display('troom/slock_add');	
		}
	}

	public function edit(){
       	$rec = $this->input->post('param');
		if(!empty($rec)){
			parse_str($rec,$querystr);
			$param = $this->getParam($querystr);
			$cgInfo = $this->getCGInfo($querystr);
			$lockid = $querystr['lockid'];
			if(!$this->_checkPower($lockid)){
				$ret['status'] = -1;
				$ret['msg'] = '没有修改权限';
				echo json_encode($ret);
				exit;
			}
			if(!is_numeric($lockid) || $lockid <=0 ){
				$ret['status'] = 1;
				$ret['msg'] = '修改失败,锁屏id不正确';
			}
			$param['lockid'] = $lockid;
			$param['classes'] = $cgInfo;
			$slockModel = $this->model('slock');
			$res = $slockModel->editLock($param);
			$ret = array('status'=>0,'msg'=>'修改成功');
			if(empty($res)){
				$ret['status'] = 2;
				$ret['msg'] = '修改失败';
			}
			echo json_encode($ret);
			exit;
		}else{
			$lockid = $this->input->get('lockid');
			if(!$this->_checkPower($lockid)){
				echo '没有修改权限';
				exit;
			}
			if(!is_numeric($lockid) || $lockid <=0 ){
				echo '锁屏id不正确';
				exit;
			}
			$lockInfo = $this->model('slock')->getDetail($lockid);
			$classes = $this->_getClasses();
			$grades = $this->_getGrades();
			if($lockInfo['flag'] == 1){//按年级
				foreach ($lockInfo['classes'] as $lclass) {
					$key = 'g_'.$lclass['grade'].'_'.$lclass['district'];
					if(array_key_exists($key, $grades)){
						$grades[$key]['checked'] = 1;
					}
				}
			}else{//按班级
				foreach ($lockInfo['classes'] as $lclass) {
					$key = 'c_'.$lclass['classid'];
					if(array_key_exists($key, $classes)){
						$classes[$key]['checked'] = 1;
					}
				}
			}
			$this->assign('slock',$lockInfo['slock']);
			$this->assign('flag',$lockInfo['flag']);
			$this->assign('classes',$classes);
			$this->assign('grades',$grades);
	        $this->display('troom/slock_edit');	
		}
	}

	//删除锁屏记录
	public function delete(){
		$lockid = $this->input->post('lockid');
		$ret = array();
		if(!$this->_checkPower($lockid)){
			$ret['status'] = -1;
			$ret['msg'] = '没有删除权限';
			echo json_encode($ret);
			exit;
		}
		$res = $this->model('slock')->delLock($lockid);
		if(empty($res)){
			$ret['status'] = -2;
			$ret['msg'] = '删除失败';
			echo json_encode($ret);
			exit;
		}else{
			$ret['status'] = 0;
			$ret['msg'] = '删除成功';
			echo json_encode($ret);
			exit;
		}
	}

	public function view(){
		$lockid = $this->uri->itemid;
		if(!is_numeric($lockid) || $lockid <=0 ){
			echo '锁屏id不正确';
			exit;
		}
		$lockInfo = $this->model('slock')->getDetail($lockid);
		$classes = $this->_getClasses();
		$grades = $this->_getGrades();
		if($lockInfo['flag'] == 1){//按年级
			foreach ($lockInfo['classes'] as $lclass) {
				$key = 'g_'.$lclass['grade'].'_'.$lclass['district'];
				if(array_key_exists($key, $grades)){
					$grades[$key]['checked'] = 1;
				}
			}
		}else{//按班级
			foreach ($lockInfo['classes'] as $lclass) {
				$key = 'c_'.$lclass['classid'];
				if(array_key_exists($key, $classes)){
					$classes[$key]['checked'] = 1;
				}
			}
		}
		$this->assign('slock',$lockInfo['slock']);
		$this->assign('flag',$lockInfo['flag']);
		$this->assign('classes',$classes);
		$this->assign('grades',$grades);
        $this->display('troom/slock_view');	
	}

	private function _getClasses(){
		if(!empty($this->classes)){
			return $this->classes;
		}
		$roominfo = $this->roominfo;
		$user = $this->user;
		if($roominfo['uid'] == $user['uid']){
			$classes = $this->model('classes')->getClasses(array('crid'=>$roominfo['crid']));
		}else{
			$classes = $this->model('classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		}
		$ret = array();
		foreach ($classes as $class) {
			$key = 'c_'.$class['classid'];
			$ret[$key] = $class;
		}
		$this->classes = $ret;			
		return $ret;
	}

	private function _getGrades(){
		if(!empty($this->grades)){
			return $this->grades;
		}
		if(empty($this->classes)){
			$this->_getClasses();
		}
		$grademap = Ebh::app()->getConfig()->load('grademap');
		$classes = $this->classes;
		$ret = array();
		foreach ($classes as $class) {
			if($class['grade'] == 0){
				continue;
			}
			$key = 'g_'.$class['grade'].'_'.$class['district'];
			if(!array_key_exists($key, $ret)){
				$gradename = $grademap[$class['grade']];
				if($class['district']){
					$gradename.='(第二校区)';
				}
				$gradeInfo = array('gradename'=>$gradename,'grade'=>$class['grade'],'district'=>$class['district']);
				$ret[$key] = $gradeInfo;
			}
		}
		$this->grades = $ret;
		return $ret;
	}

	private function getParam($param = array()){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $param = safeHtml($param);
		$returnParam = array();
		$returnParam['crid'] = $roominfo['crid'];
		$returnParam['title'] = $param['title'];
		$returnParam['uid'] = $user['uid'];
		$returnParam['startdate'] = strtotime($param['cdate']);
		$returnParam['enddate'] = strtotime($param['enddate']);
		$classes = empty($param['classes'])?array():$param['classes'];
		$grades = empty($param['grades'])?array():$param['grades'];
		$returnParam['target'] = intval($param['flag']);
		if(empty($classes)&&empty($grades)){
			return false;
		}
		return $returnParam;
	}

	/**
	 *获取班级列表或者年级列表
	 */
	private function getCGInfo($param = array()){
		$returnParam = array();
		$flag = $param['flag'];
		if($flag==1){
			foreach ($param['grades'] as $pvalue) {
				list($grade,$district) = explode(':',$pvalue);
				$returnParam[] = array('grade'=>$grade,'classid'=>0,'district'=>$district);
			}
		}else{
			foreach ($param['classes'] as $pvalue) {
				list($classid,$grade,$district) = explode(':',$pvalue);
				$returnParam[] = array('grade'=>0,'classid'=>$classid,'district'=>0);
			}
		}
		return $returnParam;
	}

	//权限校验
	private function _checkPower($lockid = 0){
		if(!is_numeric($lockid) || ($lockid <=0) ){
			return false;
		}
		$uid = $this->user['uid'];
		$slock = $this->model('slock')->getSimpleDetail($lockid);
		if(empty($slock) || ($slock['uid']!=$uid)){
			return false;
		}
		return true;
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
}
