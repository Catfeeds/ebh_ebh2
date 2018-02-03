<?php
/**
 * 教师评论控制器类ReviewController
 */
class ReviewController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $reviewmodel = $this->model('Review');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        if($roominfo['uid'] != $user['uid'])
            $queryarr['uid'] = $user['uid'];
		$emotionarr = array('微笑','害羞','调皮','偷笑','送花','大笑','跳舞','飞吻','安慰','抱抱','加油','胜利','强','亲亲','花痴','露齿笑','查找','呼叫','算账','财迷','好主意','鬼脸','天使','再见','流口水','享受');
		$queryarr['status'] = 1;
        $reviews = $reviewmodel->getreviewlistbycrid($queryarr);
        $count = $reviewmodel->getreviewlistcountbycrid($queryarr);
		$matstr = '/\[emo(\S{1,2})\]/is';
		$emotioncount = count($emotionarr);
		$subject = '';
		foreach($reviews as $k=>$review){
			$subject = $review['subject'];
			preg_match_all($matstr,$subject,$mat);
			foreach($mat[0] as $l=>$m){
				$imgnumber = intval($mat[1][$l]);
				if($imgnumber<$emotioncount)
				$reviews[$k]['subject']=str_replace($m,'<img src="http://static.ebanhui.com/ebh/tpl/default/images/'.$imgnumber.'.gif">',$reviews[$k]['subject']);
			
			}
		}
        $pagestr = show_page($count);
        
       
        $this->assign('roominfo',$roominfo);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->display('troom/review');
		$this->_updateuserstate();
    }
    /**
     * 评论回复
     */
    public function reply() {
        $logid = $this->input->post('logid');
        $toid = $this->input->post('toid');
        $repcontent = $this->input->post('repcontent');
        $result = array('status'=>0,'msg'=>'回复评论失败,请刷新页面重试');
        if(NULL !== $logid && is_numeric($logid) || NULL !== $toid && is_numeric($toid) && NULL != $repcontent) {
            $user = Ebh::app()->user->getloginuser();
            $reviewmodel = $this->model('Review');
			//回复评论的课件是不是本校的课件
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['cwid'] = $this->input->post('toid');
			$count = $reviewmodel->getByCridCount($param);
			if($count>0){
				$param = array('logid'=>$logid,'replysubject'=>$repcontent,'toid'=>$toid,'uid'=>$user['uid'],'opid'=>8192,'type'=>'courseware','credit'=>0,'value'=>0,'replyuid'=>$user['uid'],'replydateline'=>time());
				$param['fromip'] = $this->input->getip();
				$result = $reviewmodel->update($param);
				if($result !== FALSE)
					$result = array('status'=>1,'msg'=>'回复评论成功');
			}
        }
        echo json_encode($result);
    }
	/**
	*更新评论用户状态时间
	*/
	private function _updateuserstate() {
		 //更新评论用户状态时间
		 $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $statemodel = $this->model('Userstate');
        $typeid = 3;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
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

				//新评论通过私信告诉主讲教师
				$course = $coursemodel->getcoursedetail($cwid);
				if ($course['uid'] != $user['uid'])
				{
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
				}

			} else {
				echo json_encode(array('status'=>0,'msg'=>'评论失败'));
			}
		}
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
			$param = array('uid' => $user['uid'], 'logid'=>$logid);
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

	/*
	取消屏蔽
	*/
	public function cancleshield(){
		$cwid = $this->input->post('cwid');
		$logid = $this->input->post('logid');
		$user = Ebh::app()->user->getloginuser();
		if ($cwid === NULL || !is_numeric($cwid) || $logid === NULL || !is_numeric($logid)) {
            echo 'fail';
            exit();
        }
		$param = array('uid' => $user['uid'], 'cwid' => $cwid, 'logid'=>$logid);
		$reviewmodel = $this->model('review');
		$result = $reviewmodel->cancleShield($param);
		if ($result) {
			$coursemodel = $this->model('Courseware');	//增加课件评论数
			$coursemodel->editreviewnum($cwid,-1);
            echo json_encode(array('status'=>1));
            exit();
		} else {
			echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
            exit();
        }
	}
}
