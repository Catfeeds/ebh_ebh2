<?php
/**
 * 教师评论控制器类ReviewController
 */
class ReviewController extends CControl {
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	/*
	*评论交流
	*/
	 public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$crid = $roominfo['crid'];
		$reviewmodel = $this->model('review');
		$q = $this->input->get('q');
		$params = parsequery();
		$params['crid'] = $crid;
		$params['uid'] = $user['uid'];
		$params['displayorder'] = 'r.logid desc';
		$params['pagesize'] = 10;
		$params['q'] = $q;
		$params['rev'] = 1;
		$params['replysubject'] = 1;
		$params['status'] = 1;
		$count = $reviewmodel->getReviewCount($params);
		$this->assign('count', $count);
        $this->display('college/review');
    }

	/*
	*学生评论
	*/
	public function student(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$crid = $roominfo['crid'];
		$reviewmodel = $this->model('review');
		$q = $this->input->get('q');
		$params = parsequery();
		$params['crid'] = $crid;
		$params['uid'] = $user['uid'];
		$params['displayorder'] = 'r.logid desc';
		$params['pagesize'] = 10;
		$params['q'] = $q;
		$params['status'] = 1;
		$reviews = $reviewmodel->getReviewListByUid($params);
		$params['rcrid'] = 1;
		$count = $reviewmodel->getreviewcount($params);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$pagestr = show_page($count,10);

		$this->assign('reviews', $reviews);
		$this->assign('pagestr', $pagestr);
		$this->assign('count', $count);
		$this->assign('roominfo', $roominfo);
		$this->assign('user', $user);
		$this->display('college/review_student');
	}

	/*
	*老师回复
	*/
	public function teacher(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$crid = $roominfo['crid'];
		$reviewmodel = $this->model('review');
		$q = $this->input->get('q');
		$params = parsequery();
		$params['crid'] = $crid;
		$params['uid'] = $user['uid'];
		$params['displayorder'] = 'r.logid desc';
		$params['pagesize'] = 10;
		$params['q'] = $q;
		$params['rev'] = 1;
		$params['status'] = 1;
		$params['replysubject'] = 1;
		//$params['upid'] = 0;
		$reviews = $reviewmodel->getReviewListByUid($params);
		$count = $reviewmodel->getreviewcount($params);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$pagestr = show_page($count,10);
		$this->assign('pagestr', $pagestr);
		$this->assign('reviews', $reviews);
		$this->assign('count', $count);
		$this->assign('roominfo', $roominfo);
		$this->assign('user', $user);
		$this->display('college/review_teacher');
	}

    /**
     * 添加评论
     */
    public function add() {
		$type = $this->input->post('type');
		if(NULL !== $type && $type == 'courseware') {
			$cwid = $this->input->post('cwid');
			$msg = $this->input->post('msg');
			$score = $this->input->post('mark');

			if(!is_numeric($cwid) || $cwid <= 0) {
				echo json_encode(array('status'=>0,'msg'=>'没有指定课件'));
				exit;
			}
			if(empty($msg)) {
				echo json_encode(array('status'=>0,'msg'=>'评论不能为空'));
				exit;
			}
			// $matstr = '/<img src\="http:\/\/static\.ebanhui\.com\/ebh\/tpl\/default\/images\/(\S{1,2})\.gif">/is';
			// while(preg_match($matstr,$msg,$mat)){
				// $msg=str_replace($mat[0],'[emo'.$mat[1].']',$msg);
			// }
			$msg = htmlspecialchars($msg);
			$user = Ebh::app()->user->getloginuser();
			$fromip = $this->input->getip();
			$param = array('uid'=>$user['uid'],'toid'=>$cwid,'opid'=>8192,'type'=>$type,'subject'=>$msg,'score'=>intval($score),'credit'=>0,'upid'=>0,'value'=>0,'fromip'=>$fromip,'dateline'=>time());
			$reviewmodel = $this->model('Review');
			$result = $reviewmodel->insert($param);
			if($result > 0) {
				$coursemodel = $this->model('Courseware');	//增加课件评论数
				$coursemodel->addreviewnum($cwid);
				echo json_encode(array('status'=>1,'msg'=>'评论成功'));
				
				fastcgi_finish_request();
				//清除评论前五页缓存
				for($i = 1;$i<=5; $i++){
					$queryarr = array(
						'pagesize'=>10,
						'cwid'=>intval($cwid),
						'page'=>$i
					);
					$reviewkey = $this->cache->getcachekey('course_review',$queryarr);
	    			$res = $this->cache->remove($reviewkey);
	    			if(!$res){//缓存没有5页，跳出循环
	    				break;
	    			}
				}

				//新评论通过私信告诉主讲教师
				$course = $coursemodel->getcoursedetail($cwid);
				$msglib = Ebh::app()->lib('EMessage');
				$msgtype = 4; //新评论
				$lastmsg = $msglib->getLastUnReadMessage($course['uid'], $cwid, $msgtype);
				$uname = empty($user['realname']) ? $user['username'] : $user['realname'];
				if(empty($lastmsg)) {	//如果当前的答疑私信没有未读的，则直接添加消息
					$msglib->sendMessage($user['uid'], $uname, $course['uid'], $cwid, $msgtype, $course['title']);
				} else {	//否则更新消息即可
					$ulist = $lastmsg['ulist'];
					parse_str($ulist,$uarr);
					if(!isset($uarr[$user['uid']])) {
						if(empty($ulist)) {
							$ulist = $user['uid'].'='.$uname;
						} else {
							$ulist .= '&'.$user['uid'].'='.$uname;
						}
						$lastmsg['ulist'] = $ulist;
						$lastmsg['dateline'] = SYSTIME;
						$msglib->updateMessage($lastmsg);
					}
				}

			} else {
				echo json_encode(array('status'=>0,'msg'=>'评论失败'));
			}
		}
    }

	/*
	*删除评论
	*/
	public function delreview(){
		$logid = $this->input->post('logid');
        if ($logid === NULL || !is_numeric($logid)) {
            echo 'fail';
            exit();
        }
		$user = Ebh::app()->user->getloginuser();
		$param = array(
				'logid'=>$logid,
				'uid'=>$user['uid']
			);
        $reviewmodel = $this->model('Review');
        $result = $reviewmodel->deletereview($param);
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
	}
	/**
	 * 国土资源厅评论展示
	 */
	public function showReview(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['pagesize'] = 20;
		$param['type'] = 'courseware';
		$param['opid'] = 8192;
		$param['audit'] = 1;
		$cwmodel = $this->model('courseware');
		$cwlist = $cwmodel->getcourselist(array('crid'=>$roominfo['crid'],'limit'=>10000));
		$cwidarr = array();
		if(!empty($cwlist)){
			foreach ($cwlist as $list) {
				$cwidarr[] = $list['cwid'];
			}
		}
		$param['toidarr'] = $cwidarr;
		$param['ql'] = $param['q'];
		unset($param['q']);
		$reviewmodel = $this->model('Review');
		$reviewlist = $reviewmodel->getreviewlist($param);
		if(!empty($reviewlist)){
			$cwarr = array();
			$uidarr = array();
			foreach ($reviewlist as $rlist) {
				if(!in_array($rlist['toid'],$cwarr)){
					$cwarr[] = $rlist['toid'];
				}
				if(!in_array($rlist['uid'],$uidarr)){
					$uidarr[] = $rlist['uid'];
				}
			}
			if(!empty($cwarr)){
				$folderlist = $cwmodel->getFolderinfoByCwid($cwarr);
				$courselist = $cwmodel->getCwinfoListRewardByCwid(implode(',',$cwarr));
				$classlist = $this->model('classes')->getClassInfoByCrid($roominfo['crid'],$uidarr);
				if(!empty($folderlist) && !empty($classlist) && !empty($courselist)){
					foreach ($reviewlist as &$rwlist) {
						foreach ($folderlist as $flist) {
							if($rwlist['toid'] == $flist['cwid']){
								$rwlist['foldername'] = $flist['foldername'];
							}
						}
						foreach ($classlist as $clist) {
							if($rwlist['uid'] == $clist['uid']){
								$rwlist['classname'] = $clist['classname'];
							}
						}
						foreach ($courselist as $cwlist) {
							if($rwlist['toid'] == $cwlist['cwid']){
								$rwlist['title'] = $cwlist['title'];
							}
						}
					}
				}
			}
		}
		$reviewlist = parseEmotion($reviewlist);
		$reviewcount = $reviewmodel->getreviewcount($param);
		$pagestr = show_page($reviewcount,$param['pagesize']);
		//国土资源厅
        $conf = Ebh::app()->getConfig()->load('othersetting');
        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
        $this->assign('is_zjdlr',$is_zjdlr);
        $this->assign('is_newzjdlr',$is_newzjdlr);
		$this->assign('reviewlist',$reviewlist);
		$this->assign('pagestr',$pagestr);
		$this->assign('q',$param['ql']);
		$this->display('college/review_gt');
	}
}
