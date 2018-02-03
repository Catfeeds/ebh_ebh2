<?php
class AstunoticeController extends CControl{
	//是否有控制权限，1为管理权限，2为父级权限只能查看
	private $haspower = NULL;
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
		$this->assign('haspower',$this->haspower);
		$this->user = Ebh::app()->user->getloginuser();
		$this->assign('user',$this->user);
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$notice = $this->model('notice');
		$param = parsequery();
		$param['ntype'] = '1,2,3,5';
		$param['crid'] = $roominfo['crid'];
		$noticelist = $notice->getnoticelist($param);
		$noticecount = $notice->getnoticelistcount($param);
		$this->assign('noticecount',$noticecount);
		$this->assign('noticelist',$noticelist);
		$this->display('aroomv2/astunotice');
	}
	
	public function send(){
		if($this->haspower != 1)
			return FALSE;
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()){
			$user = Ebh::app()->user->getloginuser();
			$roominfo = Ebh::app()->room->getcurroom();
			$param['title'] = $this->input->post('noticetitle');
			$param['message'] = $this->input->post('noticecontent');
			$param['crid'] = $roominfo['crid'];
			$param['uid'] = $user['uid'];
			$param['ntype'] = $this->input->post('noticeto');
			
			if($param['ntype']==5 && is_array($this->input->post('grade')))
				$param['grades'] = implode(',',$this->input->post('grade'));
			$districtselected = $this->input->post('districtselected');
			if(!empty($districtselected) && is_array($this->input->post('district')))
				$param['districts'] = implode(',',$this->input->post('district'));
			// var_dump($param);
			$upfile = $this->input->post('up');
			if(!empty($upfile['upfilename'])){
				$att['filename'] = $upfile['upfilename'];
				$att['size'] = $upfile['upfilesize'];
				$f = explode(',',$upfile['upfilepath']);
				$att['source'] = $f[0];
				$att['url'] = $f[1];
				$att['status'] = 1;
				$fileInfo = explode('.',$att['filename']);
				$att['suffix'] = end($fileInfo);
				$att['title'] = $att['filename'];
				$att['uid'] = $user['uid'];
				$attmodel = $this->model('attachment');
				$attid = $attmodel->insert($att);
				$param['attid'] = $attid;
			}
			
			$notice = $this->model('notice');
			$res = $notice->addnotice($param);
			if($res){
				echo json_encode(array('status'=>1));
				fastcgi_finish_request();
				Ebh::app()->lib('PushUtils')->PushNotice(intval($res));//信鸽推送
				Ebh::app()->lib('ThirdPushUtils')->PushNotice(intval($res));//向学生推送作业
			}
			else
				echo json_encode(array('status'=>0));

		}else{
			$editor = Ebh::app()->lib('UMEditor');
			$upcontrol = Ebh::app()->lib('UpcontrolLib');
			$crmodel = $this->model('classroom');
			$crdetail = $crmodel->getdetailclassroom($roominfo['crid']);
			if(!empty($crdetail['districts'])){
				$districtarr = explode(',',$crdetail['districts']);
				$this->assign('districtarr',$districtarr);
			}
			$this->assign('upcontrol',$upcontrol);
			$this->assign('editor',$editor);
			$this->assign('roominfo',$roominfo);
			$this->display('aroomv2/astunotice_send');
		}
	}
	public function edit_view(){
		$upcontrol = Ebh::app()->lib('UpcontrolLib');
		$notice = $this->model('notice');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['noticeid'] = $this->uri->itemid;
		$noticedetail = $notice->getnoticedetail($param);
		$attmodel = $this->model('attachment');
		$attchdetail = $attmodel->getAttachByIdForNotice($noticedetail['attid']);
		$attfile['upfilename'] = $attchdetail['filename'];
		$attfile['upfilesize'] = $attchdetail['size'];
		$attfile['upfilepath'] = $attchdetail['source'].','.$attchdetail['url'];
		$editor = Ebh::app()->lib('UMEditor');
		$crmodel = $this->model('classroom');
		$crdetail = $crmodel->getdetailclassroom($roominfo['crid']);
		if(!empty($crdetail['districts'])){
			$districtarr = explode(',',$crdetail['districts']);
			$this->assign('districtarr',$districtarr);
		}
		$this->assign('roominfo',$roominfo);
		$this->assign('upcontrol',$upcontrol);
		$this->assign('editor',$editor);
		$this->assign('attfile',$attfile);
		$this->assign('noticedetail',$noticedetail);
		$this->display('aroomv2/astunotice_edit');
	}
	public function edit(){
		if($this->haspower != 1)
			return FALSE;
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()){
			$user = Ebh::app()->user->getloginuser();
			$roominfo = Ebh::app()->room->getcurroom();
			$param['title'] = $this->input->post('noticetitle');
			$param['message'] = $this->input->post('noticecontent');
			$param['crid'] = $roominfo['crid'];
			$param['uid'] = $user['uid'];
			$param['noticeid'] = $this->input->post('noticeid');
			$param['ntype'] = $this->input->post('noticeto');
			
			if($param['ntype']==5 && is_array($this->input->post('grade')))
				$param['grades'] = implode(',',$this->input->post('grade'));
			else
				$param['grades'] = '';
			$districtselected = $this->input->post('districtselected');
			if(!empty($districtselected) && is_array($this->input->post('district')))
				$param['districts'] = implode(',',$this->input->post('district'));
			else
				$param['districts'] = '';
			// var_dump($param);
			$upfile = $this->input->post('up');
			if(!empty($upfile['upfilename'])){
				$att['filename'] = $upfile['upfilename'];
				$att['size'] = $upfile['upfilesize'];
				$f = explode(',',$upfile['upfilepath']);
				$att['source'] = $f[0];
				$att['url'] = $f[1];
				$att['status'] = 1;
				$att['suffix'] = end(explode('.',$att['filename']));
				$att['title'] = $att['filename'];
				$att['uid'] = $user['uid'];
				$attmodel = $this->model('attachment');
				$attid = $attmodel->insert($att);
				$param['attid'] = $attid;
			}
			
			$notice = $this->model('notice');
			$res = $notice->updateNotice($param);
			if($res)
				echo json_encode(array('status'=>1));
			else
				echo json_encode(array('status'=>0));
		}
	}
	public function del(){
		$notice = $this->model('notice');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['noticeid'] = $this->input->post('nid');
		$res = $notice->deletenotice($param);
		if($res)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
	}
}
?>