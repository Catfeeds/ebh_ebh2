<?php
	class ChannelController extends AdminControl{
		public function index(){
			$position = $this->input->get('position');
			$position = empty($position)?1:$position;
			$channelList = getTree($this->model('category')->getCategoriesByParam(array('position'=>$position)));
			$this->assign('position',$position);
			$this->assign('category',$channelList);
			$this->display('admin/channel');
		}
		public function add(){
			$position = $this->input->get('position');
			$this->assign('position',$position);
			$this->assign('op','insert');
			$this->assign('token',createToken());
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->display('admin/channel_add');
		}
	}