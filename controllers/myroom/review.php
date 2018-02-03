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
        $this->display('myroom/review');
    }

    /**
	*删除评论
	*/
    public function del(){
        $logid = $this->input->post('logid');
        if($logid !== NULL && $logid > 0){
            $user = Ebh::app()->user->getloginuser();
            $reviewmodel = $this->model('Review');
            $review = $reviewmodel->getReviewByLogid($logid);
            if($review['uid'] == $user['uid']){
                if($reviewmodel->deletereview(array('logid'=>$logid))){
                    $queryarr['pagesize'] = 10;
                    $queryarr['cwid'] = intval($this->input->post('cwid'));
                    $queryarr['page'] = 1;
                    //清空第一页的缓存
                    $reviewkey = $this->cache->getcachekey('course_review',$queryarr);
                    $this->cache->remove($reviewkey);

                    //用户评论后被删除则同时删除对应评论所得学分记录
			        $conf = Ebh::app()->getConfig()->load('othersetting');
                    $roominfo = Ebh::app()->room->getcurroom();
			        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
			        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
			        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
			        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
                    $res = '';
                    if($is_newzjdlr){
                        $res = $this->afterDeleteReview($logid);
                    }
                    echo json_encode(array('status'=>1,'msg'=>'评论删除成功'.$res));
                }else{
                    echo json_encode(array('status'=>0,'msg'=>'删除失败'));
                }
            }else{
                echo json_encode(array('status'=>0,'msg'=>'删除失败'));
            }

        }else{
            echo json_encode(array('status'=>0,'msg'=>'删除失败'));
        }
    }
    /**
     * 新评论回复 无限极
     */
    public function reply(){
        $type = $this->input->post('type');
        $reviewmodel = $this->model('Review');
        if(NULL !== $type && $type == 'courseware_reply'){
            $user = Ebh::app()->user->getloginuser();
            $upid = $this->input->post('upid');
            $toid = $this->input->post('toid');
            if($toid == $user['uid']){
                echo json_encode(array('status'=>0,'msg'=>'你不能回复自己的评论'));
                exit;
            }
            if(!is_numeric($upid) || $upid <= 0) {
                echo json_encode(array('status'=>0,'msg'=>'没有指定回复的评论'));
                exit;
            }
            $msg = $this->input->post('msg');
            if(empty($msg)) {
                echo json_encode(array('status'=>0,'msg'=>'回复内容不能为空'));
                exit;
            }
            $upReview = $reviewmodel->getReviewByLogid($upid);
            if(!$upReview){
                echo json_encode(array('status'=>0,'msg'=>'回复的内容不存在'));
                exit;
            }
            if($upReview['toid'] != $user['uid'] && $upReview['upid'] != 0){
                echo json_encode(array('status'=>0,'msg'=>'你没有权限回复该内容'));
                exit;
            }
            $this->checkSensitive($msg);



            $fromip = $this->input->getip();

            $param = array('uid'=>$user['uid'],'toid'=>$toid,'opid'=>8192,'type'=>$type,'subject'=>$msg,'credit'=>0,'upid'=>$upid,'value'=>0,'fromip'=>$fromip,'dateline'=>time());


            $param['audit'] = 1;//暂时设置回复默认通过
            $result = $reviewmodel->insert($param);

            echo json_encode(array('status'=>1,'msg'=>'回复成功','logid'=>$result));

        }elseif(NULL !== $type && $type == 'courseware_reply_son'){
            $user = Ebh::app()->user->getloginuser();
            $upid = $this->input->post('upid');
            $toid = $this->input->post('toid');
            if($toid == $user['uid']){
                echo json_encode(array('status'=>0,'msg'=>'你不能回复自己的评论'));
                exit;
            }
            if(!is_numeric($upid) || $upid <= 0) {
                echo json_encode(array('status'=>0,'msg'=>'没有指定回复的评论'));
                exit;
            }
            $msg = $this->input->post('msg');
            if(empty($msg)) {
                echo json_encode(array('status'=>0,'msg'=>'回复内容不能为空'));
                exit;
            }
            $upReview = $reviewmodel->getReviewByLogid($upid);
            if(!$upReview){
                echo json_encode(array('status'=>0,'msg'=>'回复的内容不存在'));
                exit;
            }
            if($upReview['toid'] != $user['uid'] && $upReview['uid'] != $user['uid']){
                echo json_encode(array('status'=>0,'msg'=>'你没有权限回复该内容'));
                exit;
            }

            $this->checkSensitive($msg);



            $fromip = $this->input->getip();

            $param = array('uid'=>$user['uid'],'toid'=>$toid,'opid'=>8192,'type'=>$type,'subject'=>$msg,'credit'=>0,'upid'=>$upid,'value'=>0,'fromip'=>$fromip,'dateline'=>time());


            $param['audit'] = 1;//暂时设置回复默认通过
            $result = $reviewmodel->insert($param);

            echo json_encode(array('status'=>1,'msg'=>'回复成功','logid'=>$result));
        }else{
            echo json_encode(array('status'=>0,'msg'=>'回复失败'));
        }


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
		$this->display('myroom/review_student');
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
		$this->display('myroom/review_teacher');
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
			$this->checkSensitive($msg);
			// $matstr = '/<img src\="http:\/\/static\.ebanhui\.com\/ebh\/tpl\/default\/images\/(\S{1,2})\.gif">/is';
			// while(preg_match($matstr,$msg,$mat)){
				// $msg=str_replace($mat[0],'[emo'.$mat[1].']',$msg);
			// }
			
			$user = Ebh::app()->user->getloginuser();
			$fromip = $this->input->getip();
			$roominfo = Ebh::app()->room->getcurroom();
			$param = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'toid'=>$cwid,'opid'=>8192,'type'=>$type,'subject'=>$msg,'score'=>intval($score),'credit'=>0,'upid'=>0,'value'=>0,'fromip'=>$fromip,'dateline'=>time());
			//读取缓存中评论过滤设置，修改评论审核状态
			if(!empty($msg)){
                $audit = $this->changeReviewAudit($roominfo['crid'],$msg);
                if(!empty($audit) && ($audit == 1)){
                    $param['audit'] = 1;    //评论字数大于评论过滤设置的数量，则设置当前评论状态为已通过
                }
            }

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
            //为评论记录添加学分
            if ($result > 0){
		        $conf = Ebh::app()->getConfig()->load('othersetting');
		        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
		        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
		        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
		        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
                if($is_newzjdlr) {
                    $this->afterReviewAdd($result, $param);
                }
            }
		}
    }
    /**
     * 用户评论视频后可获得学分
     */
    public function afterReviewAdd($result,$param){
        $reviewparam = $param;
        $reviewparam['type'] = 3;
        $reviewparam['reviewid'] = intval($result);
        $reviewparam['cwid'] = intval($param['toid']);
        $reviewparam['wordslength'] = mb_strlen($param['subject'],'utf8');
        $apiServer = Ebh::app()->getApiServer('ebh');
        $apiServer->reSetting()->setService('Classroom.Score.addOneScore')->addParams($reviewparam)->request();
    }
    /**
     * 用户评论被删除则同时删除对应评论所得学分记录
     */
    public function afterDeleteReview($logid){
        $reviewparam = array();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $reviewparam['type'] = 3;
        $reviewparam['logid'] = intval($logid);
        $reviewparam['crid'] = $roominfo['crid'];
        $reviewparam['uid'] = $user['uid'];
        $apiServer = Ebh::app()->getApiServer('ebh');
        $res = $apiServer->reSetting()->setService('Classroom.Score.deleteScore')->addParams($reviewparam)->request();
        if(isset($res['status'])){
//            if($res['status']==1){
//                $ret = $apiServer->reSetting()->setService('Classroom.Score.doOneScoreSync')->addParams($reviewparam)->request();
//                if($ret){ return ','.$res['msg'].',该用户评论学分同步成功!';}
//            }
            return ','.$res['msg'];
        }
    }
    /**
     * 对添加或编辑的问题的标题和内容进行敏感词验证
     */
    public function checkSensitive($title){
        //获取国土的网校配置,如果是国土，不进行验证
        $roominfo = Ebh::app()->room->getcurroom();
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $appsetting['zjdlsensitive'] =  !empty($appsetting['zjdlsensitive'])? 1 : 0;//浙江国土是否开通关键字过滤
        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);
        if (($is_zjdlr || $is_newzjdlr) && !$appsetting['zjdlsensitive']) {//国土网校则执行
            return '';
        }

        require(LIB_PATH."SimpleDict.php");
        if(!file_exists(LIB_PATH."sensitive.cache")){
			SimpleDict::make(LIB_PATH."sensitive.dat",LIB_PATH."sensitive.cache");
        }
        $dict = new SimpleDict(LIB_PATH."sensitive.cache");
        $title =  preg_replace("/\s/","",$title);
        $result = $dict->search($title);
        $resultarr= array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $resultarr[] =  $value['value'];
            }
            echo json_encode(array('status'=>-1,'Sensitive'=>$resultarr));
            exit;
        }
    }

    //当评论过滤设置开启，字数超过设置的数量，评论审核状态默认为已通过
    private function changeReviewAudit($crid,$msg){
        $audit = 0;         //评论审核状态（1已通过）
        if(empty($crid) || empty($msg)){
            return $audit;
        }
        $conf = Ebh::app()->getConfig()->load('othersetting');
        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        $is_zjdlr = ($crid == $conf['zjdlr']) || (in_array($crid,$conf['newzjdlr']));
        if($is_zjdlr){      //判断是否国土的评论
            $redis = Ebh::app()->getCache('cache_redis');
            $redis_key = 'reviewfilter_' . $crid;
            $filterinfo = $redis->get($redis_key);//读取缓存中评论过滤的设置
            if(!empty($filterinfo)) {           //评论审核的过滤设置是否存在
                $filter = json_decode($filterinfo, true);
                //过滤设置已开启
                if(isset($filter['isfilter']) && ($filter['isfilter'] == 1) && isset($filter['reviewnum']) && is_numeric($filter['reviewnum'])){
                    $msg = preg_replace_callback('/\[([a-z_]+)(\d+)\]/is',  function() { return 1;},$msg);
                    $length = mb_strlen($msg,'utf8');       //获取当前评论的字数
                    if($length < $filter['reviewnum']){    //比较大小，小于设置的字数，则当前评论状态修改为已通过
                        $audit = 1;
                    }
                }
            }
        }
        return $audit;
    }
}
