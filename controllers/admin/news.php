<?php
    /**
     * 新闻控制器,主要用于视图跳转,基本上没什么用，相关功能集成在item控制器;
     * @param arary $where
     * @return array
     */
	class NewsController extends AdminControl{
		
		//新闻列表页面跳转，分配一下类型和显示类型
		public function index(){
			$this->assign('type','news');
			$folder=$this->input->get('folder');
			$this->assign('folder',intval($folder));
			$this->display('admin/news');
		}
		//跳转到新闻视图
		public function add(){
			$this->assign('type','news');
			$this->assign('token',createToken());
			$itemid = $this->input->get('itemid');
			$editor = Ebh::app()->lib('UMEditor');
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->assign('editor',$editor);
			if(empty($itemid)){
				$this->assign('op','add');
			}else{
				$this->assign('itemid',$itemid);
				$this->assign('op','edit');
			}
			
			$this->display('admin/news_add');
		}
	}
?>