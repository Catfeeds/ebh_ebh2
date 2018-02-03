<?php
	class ResourcesController extends AdminControl{
		//添加资源分类
		public function addType(){
			$this->assign('op','insert');
			$this->assign('type','resources');
			$this->assign('token',createToken());
			$this->display('admin/resources_addType');
		}
		//添加资源
		public function add(){
			$this->assign('op','add');
			$this->assign('token',createToken());
			$this->assign('type','resources');
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$this->display('admin/resources_add');
		}
		//资源列表
		public function showlist(){
			$this->assign('op','list');
			$this->assign('type','resources');
			$this->display('admin/resources_list');
		}
	}