<?php
/*
 班级课程控制器
*/
class ClasscoursesController extends CControl{
	private $user = array();
	private $roominfo = array();
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getloginuser();
		$this->roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo',$this->roominfo);
		$this->assign('user',$this->user);
	}
	public function index(){
		$roominfo = $this->roominfo;
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);
		$classcoursesModel = $this->model('Classcourses');
		//获取已选课程
		$selectedfolderlist = $classcoursesModel->getfolders(array('crid'=>$roominfo['crid'],'limit'=>1000));
		foreach ($selectedfolderlist as $sfolder){
			$selectedfids[$sfolder['classid']][] = $sfolder['folderid'];
			$selectedfname[$sfolder['classid']][] = $sfolder['foldername']; 
		}
		foreach ($classlist as $key=>$cl){
			if(isset($selectedfids[$cl['classid']])){
				$classlist[$key]['sfids'] = implode(',', $selectedfids[$cl['classid']]);
				$classlist[$key]['sfname'] = implode(',',$selectedfname[$cl['classid']]);
			}else{
				$classlist[$key]['sfids'] = '';
				$classlist[$key]['sfname'] = '';
			}
		}
		//获取本校所有课程
		$folderModel = $this->model('Folder');
		$folderlist = $folderModel->getfolderlist(array('crid'=>$roominfo['crid'],'folderlevel'=>1,'nosubfolder'=>1,'limit'=>5000));	
		$this->assign('classlist',$classlist);
		$this->assign('selectedfolderlist',$selectedfolderlist);
		$this->assign('folderlist',$folderlist);
		$this->display('aroomv2/classcourses');		
	}
	//保存班级课程
	public function savefolder(){
		$classid = intval($this->input->post('classid'));
		$folderids = $this->input->post('folderids');
		if($classid<=0){
			echo json_encode(array('code'=>-1,'msg'=>'参数错误！'));
			exit;
		}
		if(!is_array($folderids)){
			echo json_encode(array('code'=>-2,'msg'=>'参数错误！'));
			exit;
		}
		$folderids = array_unique($folderids);
		//获取已有的课程folderid
		$model = $this->model('Classcourses');
		$hfolderids = $model->getfolderidsbyclassid($classid);
		$harr = array();
		if(!empty($hfolderids)){
			foreach ($hfolderids as $folder){
				$harr[] = $folder['folderid'];
			}
		}	
		$delfids = array_diff($harr, $folderids);
		$addfids = array_diff($folderids, $harr);
		if(!empty($delfids)){
			$result_1 = $model->delete(array('classid'=>$classid,'folderidstr'=>implode(',',$delfids)));
			if(!$result_1){
				log_message('删除班级课程出错，delfids:'.var_export($delfids,true));
			}
		}
		if(!empty($addfids)){
			$result_2 = $model->add(array('classid'=>$classid,'folderids'=>$addfids));
			if(!$result_2){
				log_message('添加班级课程出错，addfids:'.var_export($addfids,true));
			}
		}
		echo json_encode(array('code'=>0,'msg'=>'保存成功'));
		
		fastcgi_finish_request();
		//新增、移除学生课程权限
		$this->dopermission($delfids,$addfids,$classid);
	}
	//清空班级课程
	public function clearall(){
		$roominfo = $this->roominfo;
		$classid = intval($this->input->post('classid'));
		if($classid <=0){
			echo json_encode(array('code'=>-1,'msg'=>'参数错误'));
			exit;
		}
		//查询关联fid
		$classmodel = $this->model('Classcourses');
		$courses = $classmodel->getfolders(array('crid'=>$roominfo['crid'],'classid'=>$classid));
		if(empty($courses)){
			echo json_encode(array('code'=>-2,'msg'=>'没有可清空的课程'));
			exit;	
		}
		foreach($courses as $course){
			$dfids[] = $course['folderid'];
		}
		$param['classid'] = $classid;
		$param['folderids'] = $dfids;
		$param['type'] = 2;
		$param['crid'] = $roominfo['crid'];
		$result = $classmodel->clearAllCourses($param);
		echo json_encode(array('code'=>$result ? 0 : -3,'msg'=>$result ? '清空成功' : '清空失败'));
	}
	//处理用户权限
	private function dopermission($delfids = array(),$addfids = array(),$classid = 0){
		if((empty($delfids) && empty($addfids)) || empty($classid)){
			return true;
		}
		$roominfo = $this->roominfo;
		$queryarr['classid'] = $classid;
		$queryarr['limit'] = 500;
		$classesModel = $this->model('Classes');
		$stdlist = $classesModel->getClassStudentList($queryarr);
		$uids = array();
		if(!empty($stdlist)){
			foreach ($stdlist as $std){
				$uids[] = $std['uid'];
			}	
		}
		$userpmodel = $this->model('UserPermission');
		if(!empty($uids)){
			//移除学生用户权限
			if(!empty($delfids)){
				$userpmodel->removeStudentPermission($delfids,$uids,2,$classid);
			}
			//新增用户课程权限
			if(!empty($addfids)){
				//获取已添加过的课程权限
				$permissions = $userpmodel->permissionAdded(array('uidstr'=>implode(',', $uids),'fidstr'=>implode(',',$addfids),'type'=>2,'classid'=>$classid));
				$ruids = array();
				if(!empty($permissions)){
					foreach ($permissions as $p){
						$ruids[] = $p['uid'];
					}
				}
				$uids = array_diff($uids, $ruids);
				$dateline = SYSTIME;
				foreach ($addfids as $fid){
					$param['itemid'] = 0;
					$param['uids'] = $uids;
					$param['classid'] = $classid;
					$param['type'] = 2;
					$param['crid'] = $roominfo['crid'];
					$param['folderid'] = $fid;
					$param['dateline'] = $dateline;
					$result = $userpmodel->mutiAddPermission($param);
					if(!$result){
						log_message('增加用户课程权限失败，uids:'.$param['uids'].",folderid:".$param['folderid'].",classid:".$param['classid'].",crid:".$param['crid']);
					}
				}
			}
		}
		return true;
	} 
}