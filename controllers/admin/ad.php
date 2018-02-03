<?php
    /**
     * 广告控制器,主要用于视图跳转,基本上没什么用，相关功能集成在item控制器;
     * @param arary $where
     * @return array
     */
	class AdController extends AdminControl{
		public function index(){
			$this->assign('type','ad');
			$folder=$this->input->get('folder');
			$this->assign('folder',intval($folder));
			$this->display('admin/ad');
		}
		public function add(){
			$this->assign('type','ad');
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
			
			$this->display('admin/ad_add');
		}
	}
?>