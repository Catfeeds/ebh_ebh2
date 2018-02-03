<?php
/**
*Ⱥ�ļ������б�ҳ��
*/
class QunfilesController extends CControl {
    /**
	*�����ļ��б�
	*/
	public function index() {
		$user = Ebh::app()->user->getloginuser();
        if(empty($user))
			exit();
		$qunid = $this->uri->uri_attr(0);	//Ⱥ���
		if (!is_numeric($qunid)) {
			exit();
		}
		$filelist = array();
		$imfilemodel = $this->model('Imfile');
		$haspower = $imfilemodel->checkpermission($user['uid'],$qunid);
		if($haspower) {
			
			$filelist = $imfilemodel->getListByQunid(array('qunid'=>$qunid));
		}
		$icons = array('mp3'=>'mp3ico.png','exe'=>'exeico.png','rar'=>'yasuoico.png','zip'=>'yasuoico.png','mp4'=>'mp4ico.png','txt'=>'wenbenico.png','doc'=>'wordico.png','docx'=>'wordico.png','xls'=>'xlsico.png','xlsx'=>'xlsico.png','ppt'=>'pptico.png','pptx'=>'pptico.png','jpg'=>'picico.png','png'=>'picico.png','gif'=>'picico.png','ebh'=>'ebhico.png');		//�ļ����Ͷ�Ӧ��ͼ������
		$this->assign('icons',$icons);
		$this->assign('filelist',$filelist);
		$this->assign('user',$user);
		$this->display('common/qunfiles');
    }
	/**
	*ɾ���ļ�
	*/
	public function del() {
		$user = Ebh::app()->user->getloginuser();
		$fileid = $this->input->post('id');
		if(!is_numeric($fileid) || $fileid <= 0) {	//�����Ƿ�
			echo 0;
			exit();
		}	
		$imfilemodel = $this->model('Imfile');
		$file = $imfilemodel->getfilebyid($fileid);
		if($file['uid'] != $user['uid']) {	//��Ȩ��
			echo 0;
			exit();
		}
		$result = $imfilemodel->delete($fileid);
		delfile('qunfile',$file['url']);	//ɾ���ļ�
		if($result) {
			echo 1;
			exit();
		}
		echo 0;

	}
	/**
	*�����ļ�
	*/
	public function down_view() {
		$user = Ebh::app()->user->getloginuser();
		$fileid = $this->uri->itemid;
		$imfilemodel = $this->model('Imfile');
		$file = $imfilemodel->getfilebyid($fileid);
		$haspower = $imfilemodel->checkpermission($user['uid'],$file['qunid']);	//�ж�����Ȩ��
		if($haspower) {
			$imfilemodel->adddownnum($fileid);	//���ش�����1
			getfile('qunfile',$file['url'],$file['name']);
		}
	}
}
?>