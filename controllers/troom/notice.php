<?php
/**
 * 学校通知控制器类 NoticeController
 */
class NoticeController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
	/**
	* 已发送通知列表
	*/
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$myclasslist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classlist = array();
		foreach($myclasslist as $myclass) {
			$classlist[$myclass['classid']] = $myclass;
		}
		$noticemodel = $this->model('Notice');
		$param = parsequery();
		$param['type'] = '1';
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$notices = $noticemodel->getnoticelist($param);
		$count = $noticemodel->getnoticelistcount($param);
		$pagestr = show_page($count);
		$this->assign('classlist',$classlist);
		$this->assign('notices',$notices);
		$this->assign('pagestr',$pagestr);
        $this->display('troom/notice');
    }
	/*通知详情*
	*
	*/
	public function view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$noticeid = $this->uri->itemid;
		$noticemodel = $this->model('Notice');
		$param = array('crid'=>$roominfo['crid'],'noticeid'=>$noticeid);
		$notice = $noticemodel->getNoticeDetail($param);
		if(!empty($notice)) {
			$noticemodel->addviewnum($noticeid);
			if(!empty($notice['attid'])){
				$attmodel = $this->model('attachment');
				$attfile = $attmodel->getAttachByIdForNotice($notice['attid']);
				$this->assign('attfile',$attfile);
			}
			$this->assign('notice',$notice);
			$this->display('troom/notice_view');
		}
	}
	/**
	* 收到的通知
	*/
	public function receive() {
		$roominfo = Ebh::app()->room->getcurroom();
		$noticemodel = $this->model('Notice');
		$param = parsequery();
		$param['ntype'] = '1,2';
		$param['crid'] = $roominfo['crid'];
		$notices = $noticemodel->getnoticelist($param);
		$count = $noticemodel->getnoticelistcount($param);
		$pagestr = show_page($count);
		$this->assign('notices',$notices);
		$this->assign('pagestr',$pagestr);
		$this->display('troom/notice_receive');
	}
	/**
	*发送通知
	*/
	public function send() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$noticeto = $this->input->post('noticeto');
		$p = $this->input->post();
		if(NULL !== $noticeto) {	//处理表单
			$noticetitle = $this->input->post('noticetitle');
			$noticecontent = $this->input->post('noticecontent');
			if(empty($noticetitle) || empty($noticecontent) || !is_array($noticeto)) {
				echo 0;
				exit();
			}
			foreach($noticeto as $cid) {
				if(!is_numeric($cid) || $cid <= 0) {
					echo 0;
					exit();
				}
			}
			$cids = implode(',',$noticeto);
			$param = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'title'=>$noticetitle,'message'=>$noticecontent,'ntype'=>4,'cids'=>$cids,'type'=>1);
			$noticemodel = $this->model('Notice');
			$result = $noticemodel->addNotice($param);
			if($result > 0) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			$editor = Ebh::app()->lib('UMEditor');
			$classes = $this->model('classes');
			$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
			$this->assign('editor',$editor);
			$this->assign('classlist',$classlist);
			$this->display('troom/notice_send');
		}
	}
	/**
	*删除通知
	*/
	public function del() {
		$roominfo = Ebh::app()->room->getcurroom();
		$noticeid = $this->input->post('nid');
		if(!is_numeric($noticeid) || $noticeid <= 0) {
			echo 0;
			exit();
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'],'noticeid'=>$noticeid);
		$noticemodel = $this->model('Notice');
		$result = $noticemodel->deleteNotice($param);
		if($result > 0)
			echo 1;
		else
			echo 0;
	}
	public function edit_view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$noticeid = $this->uri->itemid;
		$noticemodel = $this->model('Notice');
		$param = array('crid'=>$roominfo['crid'],'noticeid'=>$noticeid);
		$notice = $noticemodel->getNoticeDetail($param);
		if(!empty($notice)) {
			$classes = $this->model('classes');
			$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$this->assign('classlist',$classlist);
			$this->assign('notice',$notice);
			$this->display('troom/notice_edit');
		}
		
	}
	/**
	*编辑通知提交表单处理
	*/
	public function edit() {
		$noticeid = $this->input->post('noticeid');
		if(!is_numeric($noticeid) || $noticeid <= 0) {
			echo 0;
			exit();
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$noticeto = $this->input->post('noticeto');
		$noticetitle = $this->input->post('noticetitle');
		$noticecontent = $this->input->post('noticecontent');
		if(empty($noticetitle) || empty($noticecontent) || !is_array($noticeto)) {
			echo 0;
			exit();
		}
		foreach($noticeto as $cid) {
			if(!is_numeric($cid) || $cid <= 0) {
				echo 0;
				exit();
			}
		}
		$cids = implode(',',$noticeto);
		$param = array('noticeid'=>$noticeid,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'title'=>$noticetitle,'message'=>$noticecontent,'cids'=>$cids);
		$noticemodel = $this->model('Notice');
		$result = $noticemodel->updateNotice($param);
		if($result !== FALSE) {
			echo 1;
		} else {
			echo 0;
		}
	}
}
