<?php
/*
学校课程
*/
class CourseController extends CControl{
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
		//Ebh::app()->room->checkteacher();
	}
	
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$courselist = $folder->getfolderlist($param);
		$cwmodel = $this->model('courseware');
		foreach($courselist as $k=>$course){
			// $subfolder = $folder->getSubFolder($roominfo['crid'],$course['folderid']);
			$param2['crid'] = $roominfo['crid'];
			$param2['folderid'] = $course['folderid'];
			$param2['status'] = 1;
			$cws = $cwmodel->getfolderseccoursecount($param2);
			$cridarr = Ebh::app()->getConfig()->load('subfolder');
			if(empty($cws) && in_array($roominfo['crid'],$cridarr))
				$courselist[$k]['hassub']=1;
		}
		// var_dump($courselist);
		$coursecount = $folder->getcount($param);
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],array('limit'=>1000));
		
		$courseteacherlist = $teacher->getcourseteacherlist($roominfo['crid']);
		$course = array();
		//处理课程拥有的教师
		foreach($courseteacherlist as $ct){
			if(!empty($course[$ct['folderid']]['teacherids'])){
				$course[$ct['folderid']]['teacherids'].= ','.$ct['tid'];
				$course[$ct['folderid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$course[$ct['folderid']]['teacherids'] = $ct['tid'];
				$course[$ct['folderid']]['teachers'] = $ct['realname'];
			}
		}
		
		$tempcount = count($courselist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($course[$courselist[$i]['folderid']]['teacherids'])){
				$courselist[$i]['teacherids'] = $course[$courselist[$i]['folderid']]['teacherids'];
				$courselist[$i]['teachers'] = $course[$courselist[$i]['folderid']]['teachers'];
			}
			else
				$courselist[$i]['teacherids'] = '';
		}
		// var_dump($courselist);
		$pagestr = show_page($coursecount);
		$this->assign('room',$roominfo);
		$this->assign('roomteacherlist',$roomteacherlist);
		$this->assign('pagestr',$pagestr);
		$this->assign('courselist',$courselist);
		$this->display('aroom/course');
	}
	
	public function add(){
		if($this->input->post()){
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getAdminLoginUser();
			$folder = $this->model('folder');
			$param['crid'] = $roominfo['crid'];
			$param['order'] = 'folderid asc';
			$roomfolder = $folder->getfolderlist($param);
			$param['folderlevel'] = 2;
			$param['upid'] = 0;
			$param['img'] = $this->input->post('img');
			$param['foldername'] = $this->input->post('foldername');
			$param['displayorder'] = $this->input->post('displayorder');
			$param['summary'] = $this->input->post('summary');
			$param['uid'] = $user['uid'];
			$param['speaker'] = $this->input->post('speaker');
			$param['detail'] = h($this->input->post('detail'));

			if($roominfo['isschool'] == 7) {
				if(NULL !== $this->input->post('isfree')) {
					$param['fprice'] = 0;
				}else{
					$param['fprice'] = 1;
				}
			}
			if(NULL !== $this->input->post('coursewarelogo')) {
				$param['coursewarelogo'] = 1;
			}else{
				$param['coursewarelogo'] = 0;
			}
			$param['folderpath'] = $roomfolder[0]['folderpath'];
			$param['grade'] = $this->input->post('grade');
			$folder->addfolder($param);

			/**写日志开始**/
			$message = '开设课程 '.$param['foldername'];
			Ebh::app()->lib('LogUtil')->add(
				array(
					'toid'=>$param['crid'],
					'message'=>$message,
					'opid'=>1,
					'type'=>'classroom'
					)
			);
			/**写日志结束**/

			header('location:'.geturl('aroom/course'));
		}else{
			$roominfo = Ebh::app()->room->getcurroom();
			$folder = $this->model('folder');
			$param['crid'] = $roominfo['crid'];
			
			// $roomfolder = $folder->getfolderlist($param);
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$this->assign('imgarr',$this->getimages());
			$this->assign('roominfo',$roominfo);
			$this->display('aroom/course_add');
		}
	}
	
	public function edit_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$folderid = $this->uri->itemid;
		$coursedetail = $folder->getfolderbyid($folderid);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('imgarr',$this->getimages());
		$this->assign('coursedetail',$coursedetail);
		$this->assign('roominfo',$roominfo);
		$this->display('aroom/course_edit');
	}
	/*
	选择课程任课教师
	*/
	public function chooseteacher(){
		$folder = $this->model('folder');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['folderid'] = $this->input->post('courseid');
		$param['teacherids'] = $this->input->post('teacherids');
		$param['crid'] = $roominfo['crid'];
		//var_dump($param);
		$folder->chooseteacher($param);
		echo 1;
		/**写日志开始**/
		fastcgi_finish_request();
		$message = '将教师 [ '.$param['teacherids'].' ] 设置为课程教师';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['folderid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'folder'
				)
		);
		/**写日志结束**/
	}
	
	public function del(){
		$folder = $this->model('folder');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['folderid'] = $this->input->post('folderid');
		$param['crid'] = $roominfo['crid'];
		$res = $folder->deletecourse($param);
		if($res)
		echo json_encode(array('code'=>1,'message'=>'删除成功'));
		else
		echo json_encode(array('code'=>0,'message'=>'删除失败'));

		/**写日志开始**/
		fastcgi_finish_request();
		$message = json_encode($param);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['folderid'],
				'message'=>$message,
				'opid'=>4,
				'type'=>'folder'
				)
		);
		/**写日志结束**/
	}
	public function edit(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderid'] = $this->input->post('folderid');
		$param['foldername'] = $this->input->post('foldername');
		$param['summary'] = $this->input->post('summary');
		$param['img'] = $this->input->post('img');
		$param['speaker'] = $this->input->post('speaker');
		$param['detail'] = h($this->input->post('detail'));
		$param['grade'] = intval($this->input->post('grade'));
		
		if($roominfo['isschool'] == 7) {
			if(NULL !== $this->input->post('isfree')) {
				$param['fprice'] = 0;
			}else{
				$param['fprice'] = 1;
			}
		}
		if(NULL !== $this->input->post('coursewarelogo')) {
			$param['coursewarelogo'] = 1;
		}else{
			$param['coursewarelogo'] = 0;
		}
		$param['displayorder'] = $this->input->post('displayorder');
		$folder->editcourse($param);
		/**写日志开始**/
		$message = '['.implode(',', $param).']';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['folderid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'folder'
				)
		);
		/**写日志结束**/
		header('location:'.geturl('aroom/course'));
		
	}
	
	public function getimages(){
		$pre_path = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimg/';
		$imgarr = array();
		for($i=1;$i<=92;$i++){
			$imgarr[] = $pre_path.$i.'.jpg'; 
		}
		$imgarr[] = $pre_path.'guwen.jpg';
		return $imgarr;
	}
	//ebhp课件弹出页面
	public function view() {
        $cwid = $this->uri->itemid;
		if(!is_numeric($cwid))
			exit();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course))
			exit();
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		$user = Ebh::app()->user->getAdminLoginUser();
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('user',$user);
		$type = $this->input->get('type');	//如果type为1则表示普通播放，即不采用m3u8方式播放
		$ifover5 = (SYSTIME - $course['dateline']) > 120 ? TRUE : FALSE;	//如果课件时间上传已经超过5分钟，则基本上已经处理成m3u8并且文件已经存好。
		if($course['ism3u8'] == 1 && $type != 1 && $ifover5) {	//rtmp特殊处理 
			if($roominfo['domain'] == 'jx') {
				$m3u8source = $serverutil->getZKM3u8CourseSource();
			} else {
				$m3u8source = $serverutil->getM3u8CourseSource();
			}
			if(!empty($m3u8source)) {
				$murl = $course['m3u8url'];
				$key = $this->getKey($user,$murl,$cwid);
				$key = urlencode($key);
				$m3u8url = "$m3u8source?k=$key&id=$cwid&.m3u8";
				$course['m3u8url'] = $m3u8url;
			}
		} else {
			$course['m3u8url'] = '';
		}
        $this->assign('course', $course);
		$this->assign('source',$source);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		if($type != 'flv' && $course['ism3u8'] == 1) {
			$type = 'flv';
		}
		$this->assign('type',$type);
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'limit'=>'0,100');
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamlistbycwid($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		
		$this->assign('exams',$exams);
		//获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
		//获取课件下的评论记录
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('roominfo', $roominfo);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
        $this->display('aroom/course_view');
    }
	
	public function sub_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid,1);
		$this->display('aroom/course_sub');
	}
	/**
	*生成包含用户信息的key，目前主要
	*/
	private function getKey($user,$cwurl='',$id=0) {
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time\t$cwurl\t$id";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}
}
?>