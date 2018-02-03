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
        $reviews = $reviewmodel->getReviewListByCridOnRecUrsion($queryarr);
        $count = $reviewmodel->getreviewlistcountbycrid($queryarr);
		$matstr = '/\[emo(\S{1,2})\]/is';
		$emotioncount = count($emotionarr);
		$subject = '';
/*		foreach($reviews as $k=>$review){
			$subject = $review['subject'];
			preg_match_all($matstr,$subject,$mat);
			foreach($mat[0] as $l=>$m){
				$imgnumber = intval($mat[1][$l]);
				if($imgnumber<$emotioncount)
				$reviews[$k]['subject']=str_replace($m,'<img src="http://static.ebanhui.com/ebh/tpl/default/images/'.$imgnumber.'.gif">',$reviews[$k]['subject']);

			}
		}*/
        $pagestr = show_page($count);

        $this->assign('roominfo',$roominfo);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->display('troomv2/review');
		$this->_updateuserstate();
    }

    /**
     * 通过ajax进行私信的发送
     */

    public function sendmsgAjax(){
        $toid = $this->input->post('tid');
        $toid = trim($toid,',');
        $toidarr = array();
        $toidarr = array_unique(explode(',',$toid));
        $msg = h($this->input->post('msg'));
        $user = Ebh::app()->user->getloginuser();
        //内容不超过500个字符
        if(strlen($msg) <= 0 || mb_strlen($msg, 'UTF8') > 500)
        {
            echo '0';
            exit;
        }
        foreach ($toidarr as $key => $toid) {
            if($toid <= 0)
            {
                echo '0';
                exit;
            };
            //发送信息
            if (!empty($user))
            {
                $fromid = $user['uid'];
                $fromname = empty($user['realname']) ? $user['username'] : $user['realname'];
                Ebh::app()->lib('EMessage')->sendMessage($fromid,$fromname,$toid,0,3,$msg);
            }
        }
        echo '1';
        exit;
    }

    //ajax的评论分页
    function getajaxpage(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $queryarr['pagesize'] = 10;
        $queryarr['crid'] = $roominfo['crid'];
        if($roominfo['uid'] != $user['uid']){
            $queryarr['uid'] = $user['uid'];
        }
        $queryarr['page'] = $this->input->post('page');
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCridOnRecUrsion($queryarr);
        $count = $reviewmodel->getreviewlistcountbycrid($queryarr);
        $pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);
        $reviews = parseEmotion($reviews);
        $this->assign('emotionarr',getEmotionarr());

        //json输出
        echo json_encode(array("reviews"=>$reviews,'pagestr'=>$pagestr,'count'=>$count));
    }

    /**
     * 获取分页html代码
     *	重写common下的show_page函数
     * @param int $listcount总记录数
     * @param int $pagesize分页大小
     * @return string
     */
    private function _show_page($listcount, $curpage,$pagesize = 20) {
        //print_r($listcount.$curpage.$pagesize);
        $pagecount = @ceil($listcount / $pagesize);

        if ($curpage > $pagecount) {
            $curpage = $pagecount;
        }
        if ($curpage < 1) {
            $curpage = 1;
        }
        //这里写前台的分页
        $centernum = 10; //中间分页显示链接的个数
        $multipage = '<div class="pages" style="padding-top:0px;"><div class="listPage">';
        if ($pagecount <= 1) {
            $back = '';
            $next = '';
            $center = '';
            //	$gopage = '';
        } else {
            $back = '';
            $next = '';
            $center = '';
//			$gopage = '<input id="gopage" maxpage="' . $pagecount . '" onblur="if($(this).val()>' . $pagecount . '){$(this).val(' .
//					$pagecount . ')}" type="text" size="3" value="" onfocus="this.select();"  onkeyup="this.value=this.value.replace(/\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\D/g,\'\')"><a id="page_go" >跳转</a>';
            if ($curpage == 1) {
                for ($i = 1; $i <= $centernum; $i++) {
                    if ($i > $pagecount) {
                        break;
                    }
                    if ($i != $curpage) {
                        $center .= '<a >' . $i . '</a>';
                    } else {
                        $center .= '<a class="none">' . $i . '</a>';
                    }
                }
                $next .= '<a  id="next">下一页&gt;&gt;</a>';
            } elseif ($curpage == $pagecount) {
                $back .= '<a  id="next">&lt;&lt;上一页</a>';
                for ($i = $pagecount - $centernum + 1; $i <= $pagecount; $i++) {
                    if ($i < 1) {
                        $i = 1;
                    }
                    if ($i != $curpage) {
                        $center .= '<a>' . $i . '</a>';
                    } else {
                        $center .= '<a class="none">' . $i . '</a>';
                    }
                }
            } else {
                $back .= '<a  id="next">&lt;&lt;上一页</a>';
                $left = $curpage - floor($centernum / 2);
                $right = $curpage + floor($centernum / 2);
                if ($left < 1) {
                    $left = 1;
                    $right = $centernum < $pagecount ? $centernum : $pagecount;
                }
                if ($right > $pagecount) {
                    $left = $centernum < $pagecount ? ($pagecount - $centernum + 1) : 1;
                    $right = $pagecount;
                }
                for ($i = $left; $i <= $right; $i++) {
                    if ($i != $curpage) {
                        $center .= '<a >' . $i . '</a>';
                    } else {
                        $center .= '<a class="none">' . $i . '</a>';
                    }
                }
                $next .= '<a  id="next">下一页&gt;&gt;</a>';
            }
        }
        $multipage .= $back . $center . $next . '</div></div>';
        $multipage .= '<script type="text/javascript">' . "\n"
            . '$(function(){' . "\n"
            . '$("#gopage").keypress(function(e){' . "\n"
            . 'if (e.which == 13){' . "\n"
            . '$(this).next("#page_go").click()' . "\n"
            . 'cancelBubble(this,e);' . "\n"
            . '}' . "\n"
            . '})' . "\n"
            . '})</script>';
        return $multipage;

    }

    /**
     * 评论回复
     */

    /*
    public function reply() {
        $logid = $this->input->post('logid');
        $toid = $this->input->post('toid');
        $repcontent = $this->input->post('repcontent');
        $result = array('status'=>0,'msg'=>'回复评论失败,请刷新页面重试');
        if(NULL !== $logid && is_numeric($logid) || NULL !== $toid && is_numeric($toid) && NULL != $repcontent) {
        	$this->checkSensitive($repcontent);
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
    }*/

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
                    echo json_encode(array('status'=>1,'msg'=>'删除成功'));
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

			$this->checkSensitive($msg);
			$user = Ebh::app()->user->getloginuser();
			$fromip = $this->input->getip();
			$param = array('uid'=>$user['uid'],'toid'=>$cwid,'opid'=>8192,'type'=>$type,'subject'=>$msg,'score'=>intval($score),'credit'=>0,'upid'=>0,'value'=>0,'fromip'=>$fromip,'dateline'=>time());
            //读取缓存中评论过滤设置，修改评论审核状态
            if(!empty($msg)){
                $roominfo = Ebh::app()->room->getcurroom();
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
				echo json_encode(array('status'=>1,'msg'=>'评论成功','logid'=>$result));

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

	/**
     * 对添加或编辑的问题的标题和内容进行敏感词验证
     */
    public function checkSensitive($title){
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
