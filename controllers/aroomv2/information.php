<?php
/**
 *信息管理
 */
class InformationController extends CControl{
	private $haspower = NULL;
    private $baseurl;
	public function __construct(){
		parent::__construct();
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $this->baseurl = $upconfig['pic']['showpath'];
		$this->haspower = Ebh::app()->room->checkRoomControl();
		$this->assign('haspower',$this->haspower);
	}
	public function index(){
		$this->display('aroomv2/information');
	}
	//评论管理
	public function review(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$conf = Ebh::app()->getConfig()->load('othersetting');
        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
        $review = $this->model('review');
        $param = parsequery();
        $param['crid'] = $roominfo['crid'];
        // $param['uid'] = $user['uid'];
		$param['status'] = 1;
		$startdate = $this->input->get('sdate');
		$enddate = $this->input->get('edate');
		$param['startdate'] = strtotime($startdate);
		$param['enddate'] = empty($enddate)?'':strtotime($enddate)+86400;
		$q = $this->input->get('q');
		$param['shield'] = $q;
		if ($is_zjdlr) {
			$status = true;
		} else {
			$status = false;
		}
        $reviews = $review->getreviewlistbycrid($param, $status);
        $reviewcount = $review->getreviewlistcountbycrid($param, $status);

		$this->assign('orireviews', $reviews);
		$reviews = parseEmotion($reviews);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('q',$q);
		$this->assign('emotionarr',getEmotionarr());
        $this->assign('roominfo',$roominfo);
        $this->assign('reviews', $reviews);
		$this->assign('reviewcount',$reviewcount);
        $this->assign('user', $user);


		if ($is_zjdlr) {// 国土资源厅
			$this->display('aroomv2/information_reviews');
		} else {
			$this->display('aroomv2/information_review');
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
	/*
	取消屏蔽
	*/
	public function cancleshield(){
		$cwid = $this->input->post('cwid');
		$logid = $this->input->post('logid');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if ($cwid === NULL || !is_numeric($cwid) || $logid === NULL || !is_numeric($logid)) {
            echo 'fail';
            exit();
        }
		//评论的课件所在当前学校查询
		$param['crid'] = $roominfo['crid'];
		$param['cwid'] = $cwid;
		$reviewmodel = $this->model('review');
		$count = $reviewmodel->getByCridCount($param);
		if($count>0){
			$param = array('uid' => $user['uid'], 'cwid' => $cwid, 'logid'=>$logid);
			$reviewmodel = $this->model('review');
			$result = $reviewmodel->cancleShield($param);
			if ($result) {
				$coursemodel = $this->model('Courseware');	//增加课件评论数
				$coursemodel->editreviewnum($cwid,-1);
				echo json_encode(array('status'=>1));
				exit();
			} else {
				echo json_encode(array('status'=>0,'msg'=>'取消屏蔽失败'));
				exit();
			}
		}else{
			echo json_encode(array('status'=>0,'msg'=>'取消屏蔽失败'));
			exit();
		}
	}
	/*---------------------------------------------------*/
	//答疑
	public function ateaask(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$askquestion = $this->model('askquestion');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['pagesize'] = 10;
		//$param['auid'] = $this->input->get('auid');
		//$param['ansuid'] = $user['uid'];
		$startdate = $this->input->get('sdate');
		$enddate = $this->input->get('edate');
		$param['startdate'] = strtotime($startdate);
		$param['enddate'] = empty($enddate)?'':strtotime($enddate)+86400;
		$asklistcount = $askquestion->getaskquestioncount($param);//所有问题数量

		$has = $this->input->get('has');
		$param['has'] = $has;
		$asklist = $askquestion->getaskquestionlist($param);//可按时间段查询的问题列表

		$askcount = $askquestion->getaskquestioncount($param);//可按时间段查询的问题数量
		$pagestr = show_page($askcount,$param['pagesize']);

		$param['hasbest'] = 1;
		$askanswered = $askquestion->getaskquestioncount($param);//已解决数
		
		$this->assign('asklist',$asklist);
		$this->assign('askcount',$askcount);
		$this->assign('asklistcount',$asklistcount);
		$this->assign('pagestr', $pagestr);
		$this->assign('askanswered',$askanswered);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		//$this->assign('auid',$auid);
		$this->assign('has',$has);
		$this->display('aroomv2/information_ateaask');
	}
	//详情
	public function ateaask_view(){
		$qid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
        if (is_numeric($qid)) {
			$editor = Ebh::app()->lib('UMEditor');
			$param = parsequery();
			$param['qid'] = $qid;
			$param['pagesize'] = 10;
			$askmodel = $this->model('Askquestion');
			$askmodel->addviewnum($qid);
			$user = Ebh::app()->user->getloginuser();
			$ask = $askmodel->getdetailaskbyqid($qid, $user['uid'],$crid);
			if(empty($ask)){
				//$url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题不存在或已删除";
                //echo '<a href="'. $url.'">返回</a>';
				echo '<a href="javascript:history.back();">返回</a>';
                exit;
			}else if(!empty($ask) && $ask['shield']==1){
				//$url = getenv("HTTP_REFERER");
				header("Content-type:text/html;charset=utf-8");
				echo "问题被屏蔽，无法查看";
				//echo '<a href="'. $url.'">返回</a>';
				echo '<a href="javascript:history.back();">返回</a>';
				exit;
			}
			$answers = $askmodel->getdetailanswers($param);
			$count = $askmodel->getdetailanswerscount($qid);
			$pagestr = show_page($count);
			$this->assign('ask', $ask);
			$this->assign('answers', $answers);
			$this->assign('pagestr', $pagestr);
			$this->assign('user', $user);
			$this->assign('qid', $qid);
			$this->assign('editor', $editor);
			$this->display('aroomv2/information_ateaask_view');
		}
	}
	/**
     * 关注获取消关注问题
     */
    public function addfavorit() {
        $qid = $this->input->post('qid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $flag = $this->input->post('flag');
        $param = array('uid' => $user['uid'], 'qid' => $qid);
        $askmodel = $this->model('Askquestion');
        if ($flag == 1) {
            $result = $askmodel->addfavorit($param);
        } else {
            $result = $askmodel->delfavorit($param);
        }
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }
	/**
     * 添加感谢
     */
    public function addthank() {
        $qid = $this->input->post('qid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
		$reviewmodel = $this->model('Review');
		$logparam =  array('uid'=>$user['uid'],'toid'=>$qid,'opid'=>1,'type'=>'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次投票
			echo 'thatday';
			exit();
		}
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addthank($qid);
        if ($result > 0) {
			$logparam['message'] = '回答感谢';
			$logparam['fromip'] = $this->input->getip();
			$reviewmodel->insertlog($logparam);
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }
	/**
     * 添加回答的感谢
     */
    public function addthankanswer() {
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$reviewmodel = $this->model('Review');
		$logparam =  array('uid'=>$user['uid'],'toid'=>$aid,'opid'=>1,'type'=>'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次投票
			echo 'thatday';
			exit();
		}
        $param = array('qid' => $qid, 'aid' => $aid);
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addthankanswer($param);
        if ($result > 0) {
			$logparam['message'] = '回答感谢';
			$logparam['fromip'] = $this->input->getip();
			$reviewmodel->insertlog($logparam);
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }
	
	/**
     * 添加回答
     */
    public function addanswer() {
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
        $param = array();
        $param['qid'] = $qid;
        $param['uid'] = $user['uid'];
        $param['message'] = $this->input->post('message');
		if(!isset($param['message']))
			return false;
		else{
			$param['message'] = h($param['message']);
		}
        $param['audiosrc'] = $this->input->post('audio');
        $param['audioname'] = substr( $param['audiosrc'] , strrpos($param['audiosrc'] , '/')+1 );
        $param['imagename'] = $this->input->post('imagename');
        $param['imagesrc'] = $this->input->post('imagesrc');
        $param['attname'] = $this->input->post('attname');
        $param['attsrc'] = $this->input->post('attsrc');
        $param['fromip'] = $this->input->getip();
        $param['cwid'] = intval($this->input->post('cwid'));
        $param['cwsource'] = $this->input->post('cwsource');
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addanswer($param);
        if ($result > 0) {
            echo 'success';
            fastcgi_finish_request();
            Ebh::app()->lib('PushUtils')->PushAskToStudent($qid);//信鸽推送
            Ebh::app()->lib('ThirdPushUtils')->PushAskToStudent($qid);//第三方推送
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
            $upparam = array(
                'qid'=>$qid,
                'uid'=>$ask['uid'],
                'lastansweruid'=>$user['uid']
            );
            $askmodel->update($upparam);
            if($ask['tid'] == $user['uid']){
               $askmodel->setAnswered($qid,1);
               //短信发送
               EBH::app()->lib('SMS')->run($qid,$user['uid'],2);
            }
            //新回答通过私信告诉提问人
            $msglib = Ebh::app()->lib('EMessage');
			$type = 2; //答疑新回答
			$lastmsg = $msglib->getLastUnReadMessage($ask['uid'],$qid,$type);
			$uname = empty($user['realname']) ? $user['username'] : $user['realname'];
			if(empty($lastmsg)) {	//如果当前的答疑私信没有未读的，则直接添加消息
				$title = $ask['title'];
				$msg = $title;
				$msglib->sendMessage($user['uid'],$uname,$ask['uid'],$qid,$type,$msg);
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
            exit();
        }
        echo 'fail';
        exit();
    }
/*
	设置最佳答案
	*/
	public function setbest(){
		$qid = $this->input->post('qid');
		$aid = $this->input->post('aid');
        $user = Ebh::app()->user->getloginuser();
		if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$param = array('uid' => $user['uid'], 'qid' => $qid, 'aid'=>$aid);
		$askmodel = $this->model('Askquestion');
		$result = $askmodel->setBestT($param);
		if ($result) {
            echo 'success';
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>14,'aid'=>$aid));
            exit();
        } else {
            echo 'fail';
            exit();
        }
	}
	
	  /**
     * 删除我的提问
     */
    public function delask() {
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $ask = $askmodel->getaskbyqid($qid);
        if (empty($ask) || $ask['crid'] != $roominfo['crid'] || $ask['uid'] != $user['uid']) {
            echo 'fail';
            exit();
        }
        //删除回答对应的文件
//        $answerlist = $askmodel->getanswersbyqid($qid);
//        foreach($answerlist as $myanswer) {
//            
//        }
        $result = $askmodel->delask($qid);
        if ($result) {
			if(!empty($roominfo['crid'])){
				//更新答疑数
				$roommodel = $this->model('Classroom');
				$roommodel->addasknum($roominfo['crid'],-1);
			}
            echo 'success';
            exit();
        } else {
            echo 'fail';
            exit();
        }
    }

 /**
     * 删除解答
     */
    public function delanswer() {
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $param = array('qid' => $qid, 'aid' => $aid, 'uid' => $user['uid']);
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->delanswer($param);
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

	/*
	(取消)屏蔽回答
	*/
	public function ashield(){
		$qid = $this->input->post('qid');
		$aid = $this->input->post('aid');
		$user = Ebh::app()->user->getloginuser();
		if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$shield = $this->input->post('shield');
		$param = array('uid' => $user['uid'], 'qid' => $qid, 'aid'=>$aid, 'shield'=>$shield);
		$askmodel = $this->model('Askquestion');
		$result = $askmodel->upShield($param);
		if ($result) {
			$res = $askmodel->updateanswercount($qid,$shield);
			if($res){
				 echo json_encode(array('status'=>1));
				 exit();
			}else{
				echo json_encode(array('status'=>0,'msg'=>'操作失败'));
				exit();
			}
            echo json_encode(array('status'=>1));
            exit();
		} else {
			echo json_encode(array('status'=>0,'msg'=>'操作失败'));
            exit();
        }
	}

	//(取消)屏蔽问题
	public function qshield(){
		$qid = $this->input->post('qid');
		$shield = $this->input->post('shield');
		if($shield == 1){
			$scount = -1;
		}elseif($shield == 0){
			$scount = 1;
		}
		$user = Ebh::app()->user->getloginuser();
		if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$param = array('qid' => $qid, 'shield' => $shield, 'crid' => $crid);
		$askmodel = $this->model('Askquestion');
		$askuid = $askmodel->getaskuidbyqid($qid);
		$result = $askmodel->upQshield($param);
		if ($result) {
            echo json_encode(array('status'=>1));
            fastcgi_finish_request();
			//同步SNS数据(当屏蔽问题时问题数-1,取消屏蔽时问题数+1)
			Ebh::app()->lib('Sns')->do_sync($askuid, $scount);
            exit();
		} else {
			echo json_encode(array('status'=>0,'msg'=>'操作失败'));
            exit();
        }
	}


	/*----------------------------------------------------------*/
	//广告管理
	public function ad(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
			$param = parsequery();
			$param['in'] = "(256,258,1093)";
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$ads = $this->model('item')->getSimpleList($param);
			$adsCount = $this->model('item')->getSimpleListCount($param);
			$catlist = $this->model('category')->getSimpleCatBycatids(array('catids'=>'256,258,1093'));
			$cates = array();
			foreach ($catlist as $item){
				$cates[$item['catid']] = $item['name'];
			}
			$this->assign('cates', $cates);
			$this->assign('show_page',show_page($adsCount));
			$this->assign('ads',$ads);
		}
		$this->assign('tag',$tag);
		$this->display('aroomv2/information_ad');
	}
	public function ad_add(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
		}
		$catlist = $this->model('category')->getSimpleCatBycatids(array('catids'=>'256,258,1093'));
		if($this->input->post()){
			$rec = safeHtml($this->input->post(),array('message'));
			$this->check_advertisement($rec);
			$param['subject']=$rec['subject'];
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['catid'] = $rec['catid'];
			$param['itemurl'] = $rec['itemurl'];
			$param['channel'] = 702;
			if ($param['itemurl'] == ''){
				$param['itemurl'] = '#';
			}elseif(strpos($param['itemurl'],'javascript:') !== false){
				$param['itemurl'] = '';
			}else{
			$regexurl='/^.*?\.com\//';
			$itemurl = preg_replace($regexurl, "", $param['itemurl']);
			}

			$param['folder'] = $rec['folder'];
			$userinfo = Ebh::app()->user->getAdminLoginUser();
			$param['uid'] = $userinfo['uid'];
			$param['thumb'] = $rec['thumb']['upfilepath'];
			
			if($this->model('item')->_insert($param)===true){
				foreach($catlist as $cat){
					if($cat['catid'] == $param['catid']){
						$code = $cat['code'];
						break;
					}
				}
				// log_message($code);
				$param = array('crid'=>$roominfo['crid'] ,'code'=>$code,'folder'=>2,'limit'=>'0,5');
				$roomadkey = $this->cache->getcachekey('ad',$param);
				$this->cache->remove($roomadkey);
				echo 'success';
				updateRoomCache($roominfo['crid'],'item');
				exit;
			}else{
				echo 'fail';exit;
			}
		}
		
		$this->assign('catlist',$catlist);
		$Upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('Upcontrol',$Upcontrol);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('tag',$tag);
		$this->display('aroomv2/information_ad_add');
	}

	public function ad_edit(){
		$catlist = $this->model('category')->getSimpleCatBycatids(array('catids'=>'256,258,1093'));
		// var_dump($catlist);
		if($this->input->get('itemid')){
			$itemid = intval($this->input->get('itemid'));
			$ad = $this->model('item')->getDetailByItemId($itemid);
			$roominfo = Ebh::app()->room->getcurroom();
			if($ad['crid']==$roominfo['crid']){
				$this->assign('ad',$ad);
			}else{
				echo 'fail';exit;
			}
			$this->assign('catlist',$catlist);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$this->display('aroomv2/information_ad_edit');
			exit;
		}
		if($this->input->post()){
			$rec = safeHtml($this->input->post(),array('message'));
			$this->check_advertisement($rec);
			$param['subject']=$rec['subject'];
		
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['catid'] = $rec['catid'];
			$param['itemurl'] = $rec['itemurl'];
			if ($param['itemurl'] == ''){
				$param['itemurl'] = '#';
			}elseif(strpos($param['itemurl'],'javascript:') !== false){
				$param['itemurl'] = '';
			}else{
			$regexurl='/^.*?\.com\//';
			$itemurl = preg_replace($regexurl, "", $param['itemurl']);
			}

			$param['folder'] = $rec['folder'];
			$userinfo = Ebh::app()->user->getAdminLoginUser();
			$param['uid'] = $userinfo['uid'];
			$param['thumb'] = $rec['thumb']['upfilepath'];
			$where = array('itemid'=>intval($rec['itemid']));
			if($this->model('item')->_update($param,$where)!==false){
				$code = '';
				foreach($catlist as $cat){
					if($cat['catid'] == $param['catid']){
						$code = $cat['code'];
						break;
					}
				}
				// log_message($code);
				$param = array('crid'=>$roominfo['crid'] ,'code'=>$code,'folder'=>2,'limit'=>'0,5');
				$roomadkey = $this->cache->getcachekey('ad',$param);
				$this->cache->remove($roomadkey);
				echo 'success';
				updateRoomCache($roominfo['crid'],'item');
				exit;
			}else{
				echo 'fail';exit;
			}
		}
		
	}
	
	public function del(){
		$itemid = intval($this->input->post('itemid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$advertisement = $this->model('item')->getDetailByItemId($itemid);
		$catlist = $this->model('category')->getSimpleCatBycatids(array('catids'=>'256,258,1093'));
		if(!empty($advertisement['itemid'])&&$advertisement['crid']==$roominfo['crid']){
			if($this->model('item')->delById($itemid)!==false){
				$code = '';
				foreach($catlist as $cat){
					if($cat['catid'] == $advertisement['catid']){
						$code = $cat['code'];
						break;
					}
				}
				$param = array('crid'=>$roominfo['crid'] ,'code'=>$code,'folder'=>2,'limit'=>'0,5');
				$roomadkey = $this->cache->getcachekey('ad',$param);
				$this->cache->remove($roomadkey);
				echo 'success';
				updateRoomCache($roominfo['crid'],'item');
			}else{
				echo 'fali';
			}
		}

	}
	
	private function check_advertisement($param){
		$message = array();
		$message['code'] = true;
		if(!in_array($param['op'],array('edit','add'))){
			$message['code'] = false;
			$message[] = '操作数被篡改!';
		}
		if(strlen($param['subject'])<2){
			$message['code'] = false;
			$message[] = '广告标题长度不对!';
		}
		if(!in_array($param['catid'],array(256,258,1093))){
			$message['code'] = false;
			$message[] = '广告分类被篡改或者没有选择!';
		}
		if(!in_array($param['folder'],array(1,2))){
			$message['code'] = false;
			$message[] = '广告状态被篡改!';
		}

		if($message['code']===false){
			$this->goback(implode('\r\n',$message),geturl('aroom/information/advertisement'));
		}
	}
	/*----------------------------------------------------------------------------*/
	//公告设置
	public function datasetting(){
		$sendmodel = $this->model('Sendinfo');
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$sendlist = $sendmodel->getSendList($queryarr);
		$count = $sendmodel->getSendCount($queryarr);
		$pagestr = show_page($count);
		$this->assign('sendlist',$sendlist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/information_datasetting');
	}
	/**
	*删除公告
	*/
	public function delsend() {
		$roominfo = Ebh::app()->room->getcurroom();
		$infoid = $this->input->post('infoid');
		if(is_numeric($infoid) && $infoid > 0) {
			$sendmodel = $this->model('Sendinfo');
			$afrows = $sendmodel->del(array('crid'=>$roominfo['crid'],'infoid'=>$infoid));
			if($afrows > 0) {
				echo 'success';
				updateRoomCache($roominfo['crid'],'sendinfo');
			} else {
				echo 'fail';
			}
		}
	}
	/**
	* 添加公告
	*/
	public function datasetting_add() {
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
			$this->display('aroomv2/information_datasetting_add');
		}
	}
	/**
	*修改公告
	*/
	public function datasetting_edit() {
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
					$editor = Ebh::app()->lib('UMEditor');
					$this->assign('send',$send);
					$this->assign('editor',$editor);
					$this->display('aroomv2/information_datasetting_edit');
				}
			}
		}
	}
	/*---------------------------------------------------------------------*/
	//资讯管理
	public function datainfor(){
		$tag = $this->uri->uri_attr(0);
		$newsmodel = $this->model('news');
		if(empty($tag)){
			$tag = 'about';
		}
		$param = parsequery();
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		// $param['catid'] = 686;
		$param['navcode'] = $this->input->get('navcode');
		$startdate = $this->input->get('sdate');
		$enddate = $this->input->get('edate');
		$param['startdate'] = strtotime($startdate);
		$param['enddate'] = empty($enddate)?'':strtotime($enddate)+86400;
		$news = $newsmodel->getnewslist($param);
		$newsCount = $newsmodel->getnewscount($param);
		$this->assign('news',$news);
		$this->assign('pagestr',show_page($newsCount));
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('tag',$tag);
		$this->assign('navcode',$param['navcode']);
		$this->assign('roominfo',$roominfo);
		$this->getNavigator();
		$this->display('aroomv2/information_datainfor');
	}
	/*添加资讯*/
	public function datainfor_add(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
		}
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()){
			$rec = safeHtml($this->input->post(),array('message'));
			$this->check_information($rec);
			$param['subject']=$rec['subject'];
			$param['crid'] = $roominfo['crid'];
			$param['note'] = $rec['note'];
			$param['message'] = $rec['message'];
			// $param['catid'] = '686';
			$userinfo = Ebh::app()->user->getAdminLoginUser();
			$param['uid'] = $userinfo['uid'];
			$param['status'] = $rec['status'];
			$param['dateline'] = SYSTIME;
			$param['thumb'] = $rec['thumb'];
			$param['navcode'] = empty($rec['navcode'])?'news':$rec['navcode'];
			if($this->model('news')->_insert($param)==false){
				echo 'fail';
				exit;
			}else{
				echo 'success';
				updateRoomCache($roominfo['crid'],'news');
				exit;
			}
		}
		$Upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('Upcontrol',$Upcontrol);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('tag',$tag);
		$this->assign('roominfo',$roominfo);
		$this->getNavigator();
		$this->display('aroomv2/information_datainfor_add');
	}
	/*修改资讯*/
	public function datainfor_edit(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
		}
		
		if($this->input->get('itemid')){
			$roominfo = Ebh::app()->room->getcurroom();
			$itemid = intval($this->input->get('itemid'));
			$information = $this->model('news')->getNewsDetail(array('crid'=>$roominfo['crid'],'itemid'=>$itemid));
			if($information['crid']==$roominfo['crid']){
				$this->assign('information',$information);
			}else{
				header("Content-type:text/html;charset=utf-8");
				echo '<script>alert("非法操作!")</script>';
				echo '<script>location.href="'.geturl('aroomv2/information/datainfor').'"</script>';
				exit;
			}
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('tag',$tag);
		$this->assign('roominfo',$roominfo);
		$this->getNavigator();

		
		$this->display('aroomv2/information_datainfor_edit');
		exit;
		}
		if($this->input->post()){
			$rec = safeHtml($this->input->post(),array('message'));
			$this->check_information($rec);
			$param['subject']=$rec['subject'];
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['note'] = $rec['note'];
			$param['message'] = $rec['message'];
			// $param['catid'] = '686';
			$param['thumb'] = $rec['thumb'];
			$userinfo = Ebh::app()->user->getAdminLoginUser();
			$param['uid'] = $userinfo['uid'];
			$param['status'] = $rec['status'];
			// $param['dateline'] = SYSTIME;
			$param['navcode'] = empty($rec['navcode'])?'news':$rec['navcode'];
			$where = array('itemid'=>intval($rec['itemid']));
			if($this->model('news')->_update($param,$where)!==false){
				echo 'success';
				updateRoomCache($roominfo['crid'],'news');
				exit;
			}else{
				echo 'fail';
				exit;
			}
		}
	}
	/*删除资讯*/
	public function deldata(){
		$itemid = intval($this->input->post('itemid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$information = $this->model('news')->getNewsDetail(array('crid'=>$roominfo['crid'],'itemid'=>$itemid));
		if(!empty($information['itemid'])&&$information['crid']==$roominfo['crid']){
			if($this->model('news')->delById($itemid)!==false){
				echo 'success';
				updateRoomCache($roominfo['crid'],'news');
			}else{
				echo 'fali';
			}
		}

	}
	/*资讯详情*/
	public function datainfor_view(){
		$itemid = intval($this->input->get('itemid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$information = $this->model('news')->getNewsDetail(array('crid'=>$roominfo['crid'],'itemid'=>$itemid));
		$this->assign('information',$information);
		$this->display('aroomv2/information_datainfor_view');
	}
	private function check_information($param){
		$message = array();
		$message['code'] = true;
		if(!in_array($param['op'],array('edit','add'))){
			$message['code'] = false;
			$message[] = '操作数被篡改!';
		}
		if(strlen($param['subject'])<2){
			$message['code'] = false;
			$message[] = '资讯标题长度不对!';
		}
		if(!in_array($param['status'],array(1,0))){
			$message['code'] = false;
			$message[] = '资讯状态被篡改!';
		}
		if(mb_strlen($param['note'],'UTF-8')>250||mb_strlen($param['note'],'UTF-8')<5){
			$message['code'] = false;
			$message[] = '资讯摘要长度不对!';
		}
		if(empty($param['message'])){
			$message['code'] = false;
			$message[] = '资讯内容长度不对!';
		}
		if($message['code']===false){
			$this->goback(implode('\r\n',$message),geturl('aroom/datasetting/information'));
		}
	}
	/*---------------------------------------------------------------------*/
	//通知列表
	public function astunotice(){
		$roominfo = Ebh::app()->room->getcurroom();
		$notice = $this->model('notice');
		$param = parsequery();
		$param['ntype'] = '1,2,3,5';
		$param['crid'] = $roominfo['crid'];
		$noticelist = $notice->getnoticelist($param);
		$noticecount = $notice->getnoticelistcount($param);
		$this->assign('noticecount',$noticecount);
		$this->assign('noticelist',$noticelist);
		$this->display('aroomv2/information_astunotice');
	}
	
	public function astunotice_send(){
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
				Ebh::app()->lib('ThirdPushUtils')->PushNotice(intval($res));//第三方推送
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
			$this->display('aroomv2/information_astunotice_send');
		}
	}
	public function astunotice_edit_view(){
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
		$this->display('aroomv2/information_astunotice_edit');
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
			echo json_encode($res);
		}
	}
	//删除
	public function delast(){
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

	// 管理人员审核评论
	public function manageraudit(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
        $conf = Ebh::app()->getConfig()->load('othersetting');
        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
		if ($is_zjdlr) {
			if ($roominfo['uid'] == $user['uid']) {
				$logid = intval($this->input->post('logid'));
				$audit = intval($this->input->post('audit'));
				$review = $this->model('review');
				$status = $review->editaudit($logid, $audit);
				if ($status) {
					echo json_encode(array('status'=>1));
				} else {
					echo json_encode(array('status'=>0));
				}
			}
		}
	}
	
	/*
	应用管理
	*/
	public function app(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crmodel = $this->model('classroom');
		$res = $crmodel->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>1));
		if(!empty($res[0]))
			$custommessage = $res[0];
		// var_dump($custommessage);
		$applist = array();
		if(!empty($custommessage))
			$applist = unserialize($custommessage['appstr']);
		// var_dump($appstr);
		$this->assign('applist',$applist);
		$this->display('aroomv2/information_app');
	}
	
	/*
	保存应用
	*/
	public function saveapp(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crmodel = $this->model('classroom');
		$indexarr = $this->input->post('index');
		$postarr = $this->input->post();
		
		$applist = array();
		if(!empty($indexarr)){
			foreach($indexarr as $k=>$index){
				$applist[$k]['img'] = $postarr['img'.$index]['upfilepath'];
				$applist[$k]['title'] = empty($postarr['title'.$index])?'':$postarr['title'.$index];
				$url = empty($postarr['url'.$index])?'':$postarr['url'.$index];
				if(substr($url,0,7) != 'http://' && substr($url,0,8) != 'https://')
					$url = 'http://'.$url;
				$applist[$k]['url'] = $url;
			}
		}
		
		$appstr = serialize($applist);
		$crmodel->editcustommessage(array('crid'=>$roominfo['crid'],'index'=>1,'appstr'=>$appstr));
		updateRoomCache($roominfo['crid'],'custommessage');
		header('Location: /aroomv2/information/app.html');
	}
	
	/*
	获取资讯分类（导航）
	*/
	private function getNavigator(){
		$roominfo = Ebh::app()->room->getcurroom();
		$nlist = Ebh::app()->getConfig()->load('roomnav');
		// $this->assign('defaultnav',array_keys($navigatorlist));
		$crmodel = $this->model('classroom');
		$roomnav = $crmodel->getNavigator($roominfo['crid']);
		$navigatorlist = array();
		if(!empty($roomnav)){
			$navigatordata = unserialize($roomnav);
			$navigatorarr = $navigatordata['navarr'];
			// var_dump($navigatorarr);
			foreach($navigatorarr as $nav){
				$temp = $nav;
				if($temp['code'] != 'news' && in_array($temp['code'],array_keys($nlist)))
					;
				else{
					array_push($navigatorlist,$temp);
				}
			}
		}
		//var_dump($navigatorlist);
		$this->assign('navigatorlist',$navigatorlist);
	}

    /**
     * 将封面图的相对路径转换为绝对路径
     * @param $url 图片网址
     * @return bool|string
     */
	public function _show_plate_news_img($url) {
        if (empty($url)) {
            return false;
        }
        if (stripos($url, 'http://') === false) {
            $filename = explode('.', $url);
            $ret = sprintf("%s%s_th.%s", $this->baseurl, $filename[0], $filename[1]);
            $start = stripos($ret, 'http://');
            $ret = substr($ret, $start);
            return $ret;
        }
        return $url;
    }
}