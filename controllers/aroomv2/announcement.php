<?php
	class AnnouncementController extends CControl{
		public function index(){
			$roominfo = Ebh::app()->room->getcurroom();
			$announcement = $this->model('sendinfo');
			$param = parsequery();
			$param['crid'] = $roominfo['crid'];
			$announcementlist = $announcement->getSendList($param);
			$announcementcount = $announcement->getSendCount($param);
			$this->assign('announcementcount',$announcementcount);
			$this->assign('announcementlist',$announcementlist);
			$pagestr = show_page($announcementcount);
		    $this->assign('pagestr',$pagestr);
			$this->display('aroomv2/announcement');
		}

		public function delsend(){
			$roominfo = Ebh::app()->room->getcurroom();
			$param = array();
			$param['crid'] = $roominfo['crid'];
			$param['infoid'] = $this->input->post('infoid');
			$sendinfo = $this->model('sendinfo');
			$res = $sendinfo->del($param);
			if($res==1){
				echo 'success';
				updateRoomCache($roominfo['crid'],'sendinfo');
			}else{
				echo 'error';
			}
		}

		/**
		* 添加公告
		*/
		public function add() {
			$message = $this->input->post('message');
			if(NULL !== $message) {	//处理表单
				$roominfo = Ebh::app()->room->getcurroom();
				$param = array('crid'=>$roominfo['crid'],'message'=>$message);
				$sendmodel = $this->model('Sendinfo');
				$infoid = $sendmodel->insert($param);
				if($infoid > 0) {
					echo 'success';
					updateRoomCache($roominfo['crid'],'sendinfo');
				} else {
					echo 'fail';
				}
			} else {
				$this->display('aroomv2/announcement_add');
			}
		}
		/**
		*修改公告
		*/
		public function edit() {
			$infoid = $this->input->post('infoid');
			if(NULL !== $infoid) {	//处理表单提交
				$roominfo = Ebh::app()->room->getcurroom();
				$message = $this->input->post('message');
				if(empty($message)) {
					echo 'fail';
					exit();
				}
				$sendmodel = $this->model('Sendinfo');
				$param = array('crid'=>$roominfo['crid'],'infoid'=>$infoid,'message'=>$message);
				$afrows = $sendmodel->update($param);
				if($afrows !== FALSE) {
					echo 'success';
					updateRoomCache($roominfo['crid'],'sendinfo');
				} else 
					echo 'fail';
			} else {	//显示
				$infoid = $this->uri->uri_attr(0);
				if(is_numeric($infoid) && $infoid > 0) {
					$sendmodel = $this->model('Sendinfo');
					$send = $sendmodel->getSendById($infoid);
					if(!empty($send)) {
						$this->assign('send',$send);
						$this->display('aroomv2/announcement_edit');
					}
				}
			}
		}
	}