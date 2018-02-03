<?php
/**
*群文件共享列表页面
*/
class QunfilesController extends CControl {
    /**
	*共享文件列表
	*/
	public function index() {
		$user = Ebh::app()->user->getloginuser();
        if(empty($user))
			exit();
		$qunid = $this->uri->uri_attr(0);	//群编号
		if (!is_numeric($qunid)) {
			exit();
		}
		$filelist = array();
		$imfilemodel = $this->model('Imfile');
		$haspower = $imfilemodel->checkpermission($user['uid'],$qunid);
		if($haspower) {
			
			$filelist = $imfilemodel->getListByQunid(array('qunid'=>$qunid));
		}
		$icons = array('mp3'=>'mp3ico.png','exe'=>'exeico.png','rar'=>'yasuoico.png','zip'=>'yasuoico.png','mp4'=>'mp4ico.png','txt'=>'wenbenico.png','doc'=>'wordico.png','docx'=>'wordico.png','xls'=>'xlsico.png','xlsx'=>'xlsico.png','ppt'=>'pptico.png','pptx'=>'pptico.png','jpg'=>'picico.png','png'=>'picico.png','gif'=>'picico.png','ebh'=>'ebhico.png');		//文件类型对应的图标名称
		$this->assign('icons',$icons);
		$this->assign('filelist',$filelist);
		$this->assign('user',$user);
		$this->display('common/qunfiles');
    }
	/**
	*删除文件
	*/
	public function del() {
		$user = Ebh::app()->user->getloginuser();
		$fileid = $this->input->post('id');
		if(!is_numeric($fileid) || $fileid <= 0) {	//参数非法
			echo 0;
			exit();
		}	
		$imfilemodel = $this->model('Imfile');
		$file = $imfilemodel->getfilebyid($fileid);
		if($file['uid'] != $user['uid']) {	//无权限
			echo 0;
			exit();
		}
		$result = $imfilemodel->delete($fileid);
		delfile('qunfile',$file['url']);	//删除文件
		if($result) {
			echo 1;
			exit();
		}
		echo 0;

	}
	/**
	*下载文件
	*/
	public function down_view() {
		$user = Ebh::app()->user->getloginuser();
		$fileid = $this->uri->itemid;
		$imfilemodel = $this->model('Imfile');
		$file = $imfilemodel->getfilebyid($fileid);
		$haspower = $imfilemodel->checkpermission($user['uid'],$file['qunid']);	//判断下载权限
		if($haspower) {
			$imfilemodel->adddownnum($fileid);	//下载次数加1
			getfile('qunfile',$file['url'],$file['name']);
		}
	}
}
?>