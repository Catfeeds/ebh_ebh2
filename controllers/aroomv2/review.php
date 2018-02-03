<?php
class ReviewController extends CControl{
	public function __construct() {
        parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getloginuser();
		$this->assign('user',$this->user);
    }
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $review = $this->model('review');
        $param = parsequery();
        $param['crid'] = $roominfo['crid'];
        // $param['uid'] = $user['uid'];
		$param['status'] = 1;
        $reviews = $review->getreviewlistbycrid($param);
        $reviewcount = $review->getreviewlistcountbycrid($param);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
        $this->assign('roominfo',$roominfo);
        $this->assign('reviews', $reviews);
		$this->assign('reviewcount',$reviewcount);
        $this->assign('user', $user);
		$this->display('aroomv2/review');
	}
	
	public function classcourse_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cwid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
        $this->assign('course', $course);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('user',$user);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo', $roominfo);
        $this->display('aroomv2/review_classcourse');
	}

	/*
	屏蔽评论
	*/
	public function shield(){
		$cwid = $this->input->post('cwid');
		$logid = $this->input->post('logid');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if ($cwid === NULL || !is_numeric($cwid) || $logid === NULL || !is_numeric($logid)) {
            echo 'fail';
            exit();
        }
		//屏蔽评论的课件的所在当前学校查询
		$param['crid'] = $roominfo['crid'];
		$param['cwid'] = $cwid;
		$reviewmodel = $this->model('review');
		$count = $reviewmodel->getByCridCount($param);
		if($count>0){
			$param = array('uid' => $user['uid'], 'cwid' => $cwid, 'logid'=>$logid);
			$reviewmodel = $this->model('review');
			$result = $reviewmodel->upShield($param);
			if ($result) {
				$coursemodel = $this->model('Courseware');	//减少课件评论数
				$coursemodel->editreviewnum($cwid);
				echo json_encode(array('status'=>1));
				exit();
			} else {
				echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
				exit();
			}
		}else{
			echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
			exit();
		}
	}
	
	public function view(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $review = $this->model('review');
        $param = parsequery();
        $param['crid'] = $roominfo['crid'];
        $param['stuid'] = $this->uri->itemid;
		$param['status'] = 1;
        $reviews = $review->getreviewlistbycrid($param);
        $reviewcount = $review->getreviewlistcountbycrid($param);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
        $this->assign('roominfo',$roominfo);
        $this->assign('reviews', $reviews);
		$this->assign('reviewcount',$reviewcount);
        $this->assign('user', $user);
		$this->display('aroomv2/review');
	}
}
?>