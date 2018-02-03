<?php
	/*在线直播控制器*/
	class MyonlineController extends CControl{
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

		/**
		 *我的直播
		 */
		public function index(){
			$roominfo = Ebh::app()->room->getcurroom();
	        $user = Ebh::app()->user->getloginuser();
	        $this->assign('user',$user);
	        $param = parsequery();
	        $this->assign('q',$param['q']);
	        $param['pagesize'] = 10;
	        $param['tid'] = $user['uid'];
	        $param['crid'] = $roominfo['crid'];
	        $param['folderinfo'] = true;
			$onlineCourseModel = $this->model('onlinecourse');
			$courseList = $onlineCourseModel->getList($param);
			$this->assign('courseList',$courseList);
			$count = $onlineCourseModel->getListCount($param);
			$pagestr = show_page($count,10);
       		$this->assign('pagestr',$pagestr);
       		$key = $this->_getOnlineKey();
			$this->assign('key',$key);
			$this->display('troom/myonline_my');
		}
		// /**
		//  *所有直播
		//  */
		// public function all(){
		// 	$roominfo = Ebh::app()->room->getcurroom();

	 //        $user = Ebh::app()->user->getloginuser();
	 //        $q = $this->input->get('q');
	 //        $param = parsequery();
	 //        $this->assign('q',$param['q']);
	 //        $param['pagesize'] = 10;
	 //        $param['crid'] = $roominfo['crid'];
	 //        $param['folderinfo'] = true;
		// 	$onlineCourseModel = $this->model('onlinecourse');
		// 	$courseList = $onlineCourseModel->getList($param);
		// 	$this->assign('courseList',$courseList);
		// 	$count = $onlineCourseModel->getListCount($param);
  //      		$pagestr = show_page($count,10);
  //      		$this->assign('pagestr',$pagestr);
		// 	$this->display('troom/myonline_all');
		// }
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
				$folderlist = $this->model('folder')->getTeacherFolderList1(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'limit'=>100,'power'=>'0,1'));
				$this->assign('folderlist',$folderlist);
				$this->display('troom/myonline_add');
			}else{
				parse_str($rec,$querystr);
				$param = $this->getParam($querystr);
				if($param!==false){
					$onlineCourseModel = $this->model('onlinecourse');
					$id = $onlineCourseModel->_insert($param);
					if($id<1){
						echo 0;exit;
					}
					//更新课程课件数目
					$this->_updateCourseNum($param['folderid'],1);
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
				$flag = $onlinecourseinfo['target'];
				$this->assign('flag',$flag);
				
				$user = Ebh::app()->user->getloginuser();
				$roominfo = Ebh::app()->room->getcurroom();
				$teacherModel = $this->model('teacher');
				$attr = "name=auid";
				$hidden = $user['uid'];
				$teacherSelect = $teacherModel->getSchoolTeacherSelect($roominfo['crid'],$attr,$onlinecourseinfo['auid'],$hidden);
				$this->assign('teacherSelect',$teacherSelect);
				$op = $this->input->get('op');
				if($op == 'view'){
					$folderinfo = $this->model('folder')->getfolderbyid($onlinecourseinfo['folderid']);
					$folderlist = array($folderinfo);
					$this->assign('folderlist',$folderlist);
					$this->display('troom/myonline_view');
				}else{
					$folderlist = $this->model('folder')->getTeacherFolderList1(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'limit'=>100,'power'=>'0,1'));
					$this->assign('folderlist',$folderlist);
					$this->display('troom/myonline_edit');
				}
			}else{
				parse_str($rec,$querystr);
				$id = intval($querystr['id']);
				$this->checkSPower($id);
				$param = $this->getParam($querystr);
				if($param!==false){
					//将原来直播对应的课程课件减去
					$onlineCourseModel = $this->model('onlinecourse');
					$onlinecourseinfo = $onlineCourseModel->getOneById($id);
					$this->_updateCourseNum($onlinecourseinfo['folderid'],-1);

					$onlineCourseModel = $this->model('onlinecourse');
					$effectnum = $onlineCourseModel->_update($param,array('id'=>$id));
					
					if($effectnum===false){
						echo 0;exit;
					}
					//将现在的课程对应的课件加1
					$this->_updateCourseNum($param['folderid'],1);
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
			$onlinecourseinfo = $onlineCourseModel->getOneById($id);
			if($onlineCourseModel->_delete($param)>0){
				//更新课程课件数目
				$this->_updateCourseNum($onlinecourseinfo['folderid'],-1);
				echo 1;exit;
			}else{
				echo 0;exit;
			}
			
		}

		
		private function getParam($param = array()){
			$roominfo = Ebh::app()->room->getcurroom();
	        $user = Ebh::app()->user->getloginuser();
	        $param = safeHtml($param);
			$returnParam = array();
			$returnParam['auid'] = intval($param['auid']);
			$returnParam['crid'] = $roominfo['crid'];
			$returnParam['title'] = $param['title'];
			$returnParam['tid'] = $user['uid'];
			$username = empty($user['realname'])?$user['username']:$user['realname'];
			$returnParam['tname'] = empty($param['tname'])?$username:$param['tname'];
			$returnParam['cdate'] = strtotime($param['cdate']);
			$returnParam['ctime'] = $param['ctime'];
			$returnParam['summary'] = empty($param['summary'])?'':$param['summary'];
			$returnParam['maxnum'] = empty($param['maxnum'])?100:$param['maxnum'];
			$returnParam['folderid'] = intval($param['folderid']);
			$returnParam['dateline'] = time();
			$returnParam['target'] = 2;
			if(empty($returnParam['folderid'])){
				return false;
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

		/**
		 *判断直播课是否属于该教室
		 */
		private function checkROwner($id){
			$roominfo = Ebh::app()->room->getcurroom();
			return $this->model('onlinecourse')->ifInClassroom($id,$roominfo['crid']);
				
		}

		/**
		 *进入直播课
		 */
		public function enter(){
			$oid = $this->input->post('id');
			$oid = intval($oid);
			$info = array();
			if(empty($oid)){
				$info['status'] = -1;
				$info['msg'] = '直播课编号有误!';
				$info['online'] = array();
			}else{
				if(false===$this->checkROwner($oid)){
					$info['status'] = -2;
					$info['msg'] = '课程不属于该教室!';
					$info['online'] = array();
				}else{
					$info['status'] = 1;
					$info['msg'] = '查询成功!';
					$detail = $this->model('onlinecourse')->getList(array('id'=>$oid,'folderinfo'=>1,'limit'=>1));
					$info['online'] = $detail[0];
				}
			}
			header("Content-Type = 'application/json;charset=UTF-8'");
			echo json_encode($info);
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

		/**
		 *更新对应的课程课件数目
		 *
		 */
		private function _updateCourseNum($folderid=0,$num=1){
			$folderModel = $this->model('folder');
			$folderModel->addcoursenum($folderid,$num);
		}

	}
