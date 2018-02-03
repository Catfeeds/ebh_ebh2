<?php
	/*在线直播控制器*/
	class OnlineController extends CControl{
	    public function __construct() {
	        parent::__construct();
	        Ebh::app()->room->checkteacher();
	        $roominfo = Ebh::app()->room->getcurroom();
	        $user = Ebh::app()->user->getloginuser();
	        $this->assign('roominfo',$roominfo);
	        $this->assign('user',$user);
	        $pos = $this->input->get('pos');
	       	$this->assign('pos',$pos);
	    }
		public function allcourse(){
			$roominfo = Ebh::app()->room->getcurroom();

	        $user = Ebh::app()->user->getloginuser();
	        $q = $this->input->get('q');
	        $param = parsequery();
	        $this->assign('q',$param['q']);
	        $param['pagesize'] = 10;
	        $param['crid'] = $roominfo['crid'];
			$onlineCourseModel = $this->model('onlinecourse');
			$courseList = $onlineCourseModel->getList($param);
			$this->assignClassInfo();
			$this->assign('courseList',$courseList);
			$count = $onlineCourseModel->getListCount($param);
       		$pagestr = show_page($count,10);
       		$key = $this->_getOnlineKey();
			$this->assign('roominfo',$roominfo);
       		$this->assign('key',$key);
       		$this->assign('pagestr',$pagestr);
			$this->display('troom/online_all');
		}
		/**
		 *我的直播
		 */
		public function index(){
			$this->display('troom/onlinechoose');
		}
		public function my(){
			$roominfo = Ebh::app()->room->getcurroom();
	        $user = Ebh::app()->user->getloginuser();
	        $classid = $this->input->get('classid');
	        $grade = $this->input->get('grade');
	        $param = parsequery();
	        $this->assign('q',$param['q']);
	        $param['pagesize'] = 10;
	        $param['classid'] = intval($classid);
	        $param['grade'] = intval($grade);
	        $check = empty($classid)?$grade:$classid;
	        $this->assign('check',$check);
	        $param['crid'] = $roominfo['crid'];
	        $param['tid'] = $user['uid'];
			$onlineCourseModel = $this->model('onlinecourse');
			$courseList = $onlineCourseModel->getList($param);
			$this->assignClassInfo();
			$this->assign('courseList',$courseList);
			$count = $onlineCourseModel->getListCount($param);
			$pagestr = show_page($count,10);
       		$this->assign('pagestr',$pagestr);
       		$key = $this->_getOnlineKey();
       		$this->assign('key',$key);
			$this->assign('roominfo',$roominfo);
			$this->display('troom/online_my');
		}
		/**
		 *添加直播
		 */
		public function add(){
			$rec = $this->input->post('param');
			if(empty($rec)){
				$user = Ebh::app()->user->getloginuser();
				$roominfo = Ebh::app()->room->getcurroom();
				$teacherModel = $this->model('teacher');
				$attr = "name=auid";
				$hidden = $user['uid'];
				$teacherSelect = $teacherModel->getSchoolTeacherSelect($roominfo['crid'],$attr,-1,$hidden);
				$this->assign('teacherSelect',$teacherSelect);
				$this->assignClassInfo();
				$this->display('troom/online_add');
			}else{
				parse_str($rec,$querystr);
				$param = $this->getParam($querystr);
				$cginfo = $this->getCGInfo($querystr);
				if(($param!==false)&&($cginfo!==false)){
					$onlineCourseModel = $this->model('onlinecourse');
					$id = $onlineCourseModel->_insert($param);
					if($id<1){
						echo 0;exit;
					}
					$Onlinecourse_classesModel = $this->model('Onlinecourse_classes');
					foreach ($cginfo as $cg) {
						$cg['oid'] = $id;
						$Onlinecourse_classesModel->_insert($cg);
					}
					echo 1;exit;
				}
			}
			
		}
		/**
		 *编辑直播
		 **/
		public function edit(){
			$rec = $this->input->post('param');
			if(empty($rec)){
				$id = $this->input->get('id');
				$op = $this->input->get('op');
				if($op!='view'){
					$this->checkSPower($id);
				}
				$onlineCourseModel = $this->model('onlinecourse');
				$onlinecourseinfo = $onlineCourseModel->getOneById($id);
				$this->assign('onlinecourseinfo',$onlinecourseinfo);
				$classorgradeModel = $this->model('onlinecourse_classes');
				$classorgradeList = $classorgradeModel->getList(array('oid'=>$id));
				$classes = $this->getpclass($onlinecourseinfo['tid']);
				$grades = $this->getgrade();
				$o1 = $this->getGradeCateInfo($grades);
				$o2 = $this->getGradeCateInfo($classorgradeList);
				// $flag = $this->getFlag($o1,$o2);
				$flag = $onlinecourseinfo['target'];
				$selectedgrades = $o2;
				$selectedclasses = array();
				foreach ($classorgradeList as  $value) {
					$selectedclasses[] = $value['classid'];
				}
				$this->assign('selectedclasses',$selectedclasses);
				$this->assign('selectedgrades',$o2);
				$this->assign('flag',$flag);
				$this->assignClassInfo($onlinecourseinfo['tid']);
				$user = Ebh::app()->user->getloginuser();
				$roominfo = Ebh::app()->room->getcurroom();
				$teacherModel = $this->model('teacher');
				$attr = "name=auid";
				$hidden = $user['uid'];
				$teacherSelect = $teacherModel->getSchoolTeacherSelect($roominfo['crid'],$attr,$onlinecourseinfo['auid'],$hidden);
				$this->assign('teacherSelect',$teacherSelect);
				$op = $this->input->get('op');
				if($op == 'view'){
					$this->display('troom/online_view');
				}else{
					$this->display('troom/online_edit');
				}
			}else{
				parse_str($rec,$querystr);
				$id = intval($querystr['id']);
				$this->checkSPower($id);
				$param = $this->getParam($querystr);
				$cginfo = $this->getCGInfo($querystr);
				if(($param!==false)&&($cginfo!==false)){
					$onlineCourseModel = $this->model('onlinecourse');
					$effectnum = $onlineCourseModel->_update($param,array('id'=>$id));
					
					if($effectnum===false){
						echo 0;exit;
					}
					$onlinecourse_classesModel = $this->model('onlinecourse_classes');
					$onlinecourse_classesModel->delByOid($id);
					foreach ($cginfo as $cg) {
						$cg['oid'] = $id;
						$onlinecourse_classesModel->_insert($cg);
					}
					echo 1;exit;
				}
			}
			
		}
		/**
		 *删除直播
		 */
		public function delete(){
			$id = $this->input->post('id');
			$this->checkPower($id);
			$param = array('id'=>intval($id));
			$onlineCourseModel = $this->model('onlinecourse');
			$onlinecourse_classesModel = $this->model('onlinecourse_classes');
			$onlinecourse_classesModel->delByOid($id);
			echo $onlineCourseModel->_delete($param);
		}

		//直播时，得到班级列表
		private function getpclass($uid=0){
			$roominfo = Ebh::app()->room->getcurroom();
			if(empty($uid)){
				$user = Ebh::app()->user->getloginuser();
	        	$uid = $user['uid'];
			}
	        $crid = $roominfo['crid'];
			$onlineCourseModel = $this->model('onlinecourse');
			return $onlineCourseModel->getpclass($uid,$crid);
		}

		//获取年级表
		private function getgrade(){
			$roominfo = Ebh::app()->room->getcurroom();
			$crid = $roominfo['crid'];
			return $this->model('classes')->getAllGrades($crid);
		}

		//分配班级或者年级信息
		private function assignClassInfo($tid=0){
				$classes = $this->getpclass($tid);
				$allGrades  = $this->getgrade();
				// $o1 = $this->getGradeCateInfo($allGrades);
				$o1 = $this->getGradeCateInfo($classes);
				$grades = $o1;
				$this->assign('classes',$classes);
				$this->assign('grades',$grades);
		}

		private function getParam($param = array()){
			$roominfo = Ebh::app()->room->getcurroom();
	        $user = Ebh::app()->user->getloginuser();
	        $param = safeHtml($param);
			$returnParam = array();
			$returnParam['auid'] = $param['auid'];
			$returnParam['crid'] = $roominfo['crid'];
			$returnParam['title'] = $param['title'];
			$returnParam['tid'] = $user['uid'];
			$username = empty($user['realname'])?$user['username']:$user['realname'];
			$returnParam['tname'] = empty($param['tname'])?$username:$param['tname'];
			$returnParam['cdate'] = strtotime($param['cdate']);
			$returnParam['ctime'] = $param['ctime'];
			$returnParam['summary'] = empty($param['summary'])?'':$param['summary'];
			$returnParam['maxnum'] = empty($param['maxnum'])?100:$param['maxnum'];
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
			$roominfo = Ebh::app()->room->getcurroom();
			$classesModel = $this->model('classes');
			$classes = $this->getgrade();
			$o1 = $this->getGradeCateInfo($classes);
			$returnParam = array();
			$flag = $param['flag'];
			if($flag==1){
				$user = Ebh::app()->user->getloginuser();
				foreach ($param['grades'] as $grade) {
					foreach ($o1[$grade]['classid'] as $classid) {
						$returnParam[] = array('classid'=>$classid,'grade'=>$o1[$grade]['grade'],'crid'=>$roominfo['crid'],'district'=>$o1[$grade]['district']);
					}
				}
			}else{
				foreach ($param['classes'] as $pvalue) {
					list($classid,$grade,$district) = explode(':',$pvalue);
					$returnParam[] = array('classid'=>$classid,'grade'=>$grade,'crid'=>$roominfo['crid'],'district'=>$district);
				}
			}
			return $returnParam;
		}

		/**
		 *判断当前用户是否有权限操作指定的直播客
		 *
		 */
		private function checkPower($id){
			$user = Ebh::app()->user->getloginuser();
			$onlineCourseModel = $this->model('onlinecourse');
			if(false===($hasPower = $onlineCourseModel->hasPower($user['uid'],$id,1))){
				echo '<script>alert("您无权操作该直播课!");history.back();</script>';
				exit;
			}
		}
		/**
		 *判断当前用户是否有权限操作指定的直播客(过期也代表没有权限)
		 *
		 */		
		private function checkSPower($id){
			$user = Ebh::app()->user->getloginuser();
			$onlineCourseModel = $this->model('onlinecourse');
			if(false===($hasPower = $onlineCourseModel->hasPower($user['uid'],$id,-1))){
				echo '<script>alert("您无权操作该直播课或者该直播课程已经过期!");history.back();</script>';
				exit;
			}
		}

		//将老师所教的班级按照年级分组,记录每组的班级数目以及班级classid（classid数组）
		private function getGradeCateInfo($classinfo){
			$gradeReflection = array(
					'1'=>'一年级','2'=>'二年级','3'=>'三年级','4'=>'四年级','5'=>'五年级',
					'6'=>'六年级','7'=>'初一','8'=>'初二','9'=>'初三','10'=>'高一',
					'11'=>'高二','12'=>'高三',
					);
			$tmp = array();
			$roominfo = Ebh::app()->room->getcurroom();
			$crid = $roominfo['crid'];
			if($crid==10420){
				$districtname = array('','(下沙校区)','(吴山校区)');
			}else{
				$districtname = array('','','(校区二)');
			}
			foreach ($classinfo as $cv) {
				if(empty($cv['grade'])){continue;}
				$keyname = $cv['grade'].':'.$cv['district'];
				if(array_key_exists($keyname, $tmp)){
					$tmp[$keyname]['num'] +=1;
					$tmp[$keyname]['classid'][]=$cv['classid'];
				}else{
					$tmp[$keyname]['num'] = 1;
					$tmp[$keyname]['grade']=$cv['grade'];
					$tmp[$keyname]['gradename'] = $gradeReflection[$cv['grade']].$districtname[$cv['district']];
					$tmp[$keyname]['district'] = $cv['district'];
					$tmp[$keyname]['classid'][]=$cv['classid'];
				}
			}
			return $tmp;
		}
		
		//$o1总信息库,$o2课件信息库 返回值:0表示按教室,1表示按年级
		private function getFlag($o1,$o2){
			$flag = 1;
			if(empty($o2)){
				return 0;
			}
			foreach ($o2 as $key => $value) {
				if(!array_key_exists($key,$o1))return 0;
				if($o1[$key]['num']!=$value['num']){
					$flag = 0;break;
				}
			}
			return $flag;
		}

		/**
		*生成直播课对应的key，主要用于直播课权限验证
		*/
		private function _getOnlineKey() {
			$clientip = $this->input->getip();
	        $ktime = SYSTIME;
	        $auth = $this->input->cookie('auth');
	        $sauth = authcode($auth, 'DECODE');
	        @list($password, $uid) = explode("\t", $sauth);
	        $skey = "$password\t$uid\t$clientip\t$ktime";
	        $key = authcode($skey, 'ENCODE');
			return $key;
		}
	}