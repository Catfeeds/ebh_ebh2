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
			header('location:'.geturl('troom/classsubject/'.$folderid));
			exit;
		}
		$foldermodel = $this->model('Folder');
        $folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
		$this->assign('imgarr',$this->getimages());
		$this->display('troom/folder_add');
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
			header('location:'.geturl('troom/classsubject/'.$folderid));
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
		header('location:'.geturl('troom/classsubject/'.$folderid));
	}
}

?>