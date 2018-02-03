<?php
class FolderController extends CControl{
	public function __construct(){
		parent::__construct();
        Ebh::app()->room->checkteacher();
	}
	public function index(){
		
	}
	public function add_view(){
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr['folderid'] = $folderid;
		$queryarr['status'] = 1;
        $cwcount = $coursemodel->getfolderseccoursecount($queryarr);
		if($cwcount>0){
			header('location:'.geturl('troomv2/classsubject/'.$folderid));
			exit;
		}
		$foldermodel = $this->model('Folder');
        $folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
		$this->assign('imgarr',$this->getimages());
		$this->display('troomv2/folder_add');
	}
	public function getimages(){
		$pre_path = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimg/';
		$imgarr = array();
		for($i=1;$i<=72;$i++){
			$imgarr[] = $pre_path.$i.'.jpg'; 
		}
		$imgarr[] = $pre_path.'guwen.jpg';
		return $imgarr;
	}
	
	public function add(){
		$post = $this->input->post();
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $post['folderid'];
		$foldermodel = $this->model('Folder');
		$coursemodel = $this->model('Courseware');
        $queryarr['folderid'] = $folderid;
		$queryarr['status'] = 1;
        $cwcount = $coursemodel->getfolderseccoursecount($queryarr);
		if($cwcount>0){
			header('location:'.geturl('troomv2/classsubject/'.$folderid));
		}
		$subfolderlist = $foldermodel->getSubFolder($roominfo['crid'],$folderid);
		
		
		
		$user = Ebh::app()->user->getloginuser();
		$param['crid'] = $roominfo['crid'];
		
		$folder = $foldermodel->getfolderbyid($folderid);
		$param['folderlevel'] = $folder['folderlevel']+1;
		$param['upid'] = $folder['folderid'];
		$param['img'] = $this->input->post('img');
		$param['foldername'] = $this->input->post('foldername');
		$param['displayorder'] = $this->input->post('displayorder');
		$param['summary'] = $this->input->post('summary');
		$param['uid'] = $user['uid'];
		$param['folderpath'] = $folder['folderpath'];
		$foldermodel->addfolder($param);
		header('location:'.geturl('troomv2/classsubject/'.$folderid));
	}

	/*
	api用的获取学校下全部的课程，包括不是该老师的
	*/
	public function tFolderAjax() {
		$crid = $this->input->post('crid');
		if(!is_numeric($crid) || $crid < 0) {
			$this->renderJson("10001","crid参数丢失");
		}
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			$this->renderJson("10001","用户未登录");
		}
		$folderList = $this->model('folder')->getfolder($crid,$user['uid']);
		$this->renderJson("0","",$folderList);
	}

	/*
	api用的获取该教师任课的全部课程
	*/
	public function erFolderAjax() {
		$crid = $this->input->post('crid');
		if(!is_numeric($crid) || $crid < 0) {
			$this->renderJson("10001","crid参数丢失");
		}
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			$this->renderJson("10001","用户未登录");
		}
		// 获取教师所在学校的课程
        $folderModel = $this->model('folder');
        $teacherFolderList = $folderModel->getTeacherFolderList(array('uid'=>$user['uid'],'crid'=>$crid,'power'=>'0,1'));
        $folderList = array();
        if(!empty($teacherFolderList)){
            $tmp = array_pop($teacherFolderList);
            $folderList = $tmp['folder'];
        }
		$this->renderJson("0","",$folderList);
	}

	/*
	 *请求id获取folder名
	 */
	public function getFolderByid() {
		$folderid = $this->input->post('folderid');
		if (empty($folderid))
			exit();
		$foldermodel = $this->model('Folder');
        $folder = $foldermodel->getfolderbyid($folderid);
        echo  $folder['foldername'];
	}

	/*
	返回的参数
	*/
    private function renderJson($errCode = 0,$errMsg = "",$datas = array() ,$ifexit = true) {
        echo json_encode(array('errCode'=>$errCode,'errMsg'=>$errMsg,'datas'=>$datas));
        if($ifexit) {
            exit;
        }
    }

}

?>