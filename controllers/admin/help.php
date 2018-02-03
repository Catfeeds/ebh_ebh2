<?php
/*
后台帮助控制器
*/
class HelpController extends AdminControl{

	public function index(){
			$this->assign('type','news');
			$folder=$this->input->get('folder');
			$this->assign('folder',intval($folder));
			$this->display('admin/help');
	}
	//后台增加help入口
	public function add(){
			$this->assign('type','help');
			$this->assign('token',createToken());
			$itemid = $this->input->get('itemid');
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			if(empty($itemid)){
				$this->assign('op','add');
			}else{
				$this->assign('itemid',$itemid);
				$this->assign('op','edit');
			}
			
			$this->display('admin/help_add');
	}
}

?>