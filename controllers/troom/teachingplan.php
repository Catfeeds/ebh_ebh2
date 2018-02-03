<?php
class TeachingplanController extends CControl{
	public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
	public function index(){
		$this->display('troom/teachingplan');
	}
	
	public function add(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()){
			$param['content'] = $this->input->post('content');
			$param['title'] = $this->input->post('title');
			$param['dateline'] = SYSTIME;
			$param['crid'] = $roominfo['crid'];
			$param['uid'] = $user['uid'];
			$tplan = $this->model('teachingplan');
			$res = $tplan->addTeachingplan($param);
			if($res)
				echo 1;
			else
				echo 0;
		}else{
			$editor = Ebh::app()->lib('UMEditor');
			
			$this->assign('user',$user);
			$this->assign('editor',$editor);
			$this->display('troom/teachingplan_add');
		}
	}
	/*
	教案管理页面
	*/
	public function manage(){
		$tplan = $this->model('teachingplan');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$tplanlist = $tplan->getTeachingplanList($param);
		$tplancount= $tplan->getTeachingplanCount($param);
		if(!empty($tplanlist)){
			foreach($tplanlist as $key=>$tl){
				$tparam['uid'] = $user['uid'];
				$tparam['tpid'] = $tl['tpid'];
				$attlist = $tplan->getTeachingplanAttachList($tparam);
				$tplanlist[$key]['attlist'] = $attlist;
			}
		}
		// var_dump($tplanlist);
		$this->assign('search',$param['q']);
		$this->assign('tplanlist',$tplanlist);
		$this->assign('tplancount',$tplancount);
		$this->display('troom/teachingplan_manage');
	}
	
	public function view(){
		$tplan = $this->model('teachingplan');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$param['tpid'] = $this->uri->itemid;
		$tplandetail = $tplan->getTeachingplanDetail($param);
		$tplandetail['realname'] = $user['realname'];
		$this->assign('tplandetail',$tplandetail);
		$this->display('troom/teachingplan_view');
	}
	
	public function edit_view(){
		$tplan = $this->model('teachingplan');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()){
			$param['content'] = $this->input->post('content');
			$param['title'] = $this->input->post('title');
			$param['dateline'] = SYSTIME;
			$param['crid'] = $roominfo['crid'];
			$param['uid'] = $user['uid'];
			$param['tpid'] = $this->input->post('tpid');
			$res = $tplan->editTeachingplan($param);
			if(isset($res))
				echo 1;
			else
				echo 0;
		}
		else{
			
			$param['crid'] = $roominfo['crid'];
			$param['uid'] = $user['uid'];
			$param['tpid'] = $this->uri->itemid;
			$tplandetail = $tplan->getTeachingplanDetail($param);
			$tplandetail['realname'] = $user['realname'];
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$this->assign('tplandetail',$tplandetail);
			$this->display('troom/teachingplan_edit');
		}
		
		
	}
	
	/*
	删除附件
	*/
	public function deleteattach(){
		$tplan = $this->model('teachingplan');
		$user = Ebh::app()->user->getloginuser();
		$param['uid'] = $user['uid'];
		$param['tpid'] = $this->input->post('tpid');
		$param['attid'] = $this->input->post('attid');
		$this->deletefile($param);
		$res = $tplan->deleteTeachingplanAttach($param);
		if($res)
			echo 1;
		else
			echo 0;
	}
	
	/*
	删除教案
	*/
	public function deletetplan(){
		$tplan = $this->model('teachingplan');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param['uid'] = $user['uid'];
		$param['tpid'] = $this->input->post('tpid');
		$param['crid'] = $roominfo['crid'];
		$this->deletefile($param);
		$res = $tplan->deleteTeachingplan($param);
		if($res)
			echo 1;
		else
			echo 0;
		
	}
	
	/*
	上传附件
	*/
	public function uploadtplanattach(){
		if($this->input->post()){
			$user = Ebh::app()->user->getloginuser();
			$param['url'] = $this->input->post('url');
			$param['name'] = $this->input->post('name');
			$param['tpid'] = $this->input->post('tpid');
			$param['uid'] = $user['uid'];
			$tplan = $this->model('teachingplan');
			$res = $tplan->addTeachingplanAttach($param);
			if($res)
				echo 1;
			else
				echo 0;
		}else{
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$this->assign('_UP',$_UP);
			$this->display('troom/uploadtplanattach');
		}
	}
	
	/*
	删除对应附件文件
	*/
	private function deletefile($param){
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$tplan = $this->model('teachingplan');
		$files = $tplan->getTeachingplanAttachList($param);
		foreach($files as $file)
		{
			if(file_exists($_UP['tplanatt']['savepath'].$file['url'])){
				unlink($_UP['tplanatt']['savepath'].$file['url']);
			}
		}
	}
	
	public function downloadatt(){
		$tplan = $this->model('teachingplan');
		$user = Ebh::app()->user->getloginuser();
		$param['uid'] = $user['uid'];
		$param['tpid'] = $this->input->get('tpid');
		$param['attid'] = $this->input->get('attid');
		$files = $tplan->getTeachingplanAttachList($param);
		if(!empty($files[0])){
			getfile('tplanatt',$files[0]['url'],$files[0]['name']);
		}
	}
}
?>