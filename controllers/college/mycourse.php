<?php
/**
 * 学校学生学习课程课件相关控制器 MycourseController
 */
class MycourseController extends CControl {
	private $check = 1;
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			$this->check = $check;
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	/**
	*课程详情（课件列表页）
	*/
	public function view() {
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$roominfo = Ebh::app()->room->getcurroom();
		$from = $this->uri->uri_attr(0);	//来源，0或空为全校课程 1 为我的课程 2 为教师课程
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course) || $course['status']!=1)
			exit();

		if($roominfo['domain'] == 'rqzx' && $this->check == 1 && $course['fprice'] > 0) {	//永康一中特殊处理IP 如果是已经付费的并且是非免费课件，则限制IP
			$checkip = $this->checkAllowIp();
			$this->assign('checkip',$checkip);
		}
		//添加课件查看数
		// $coursemodel->addviewnum($cwid);
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		
		$user = Ebh::app()->user->getloginuser();
		//针对isschool为7并且价格不为0的情况还要判断是否有课程权限
		if($course['fprice'] > 0 && $roominfo['isschool'] == 7) {
			$perparam = array('crid'=>$roominfo['crid'],'folderid'=>$course['folderid']);
			if($this->check == 1) {	//有学校权限，那就判断是否有课程权限
				$this->check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
			}
			$this->assign('check',$this->check);
			if($this->check != 1) {
				$payitem = Ebh::app()->room->getUserPayItem($perparam);
				$this->assign('payitem',$payitem);
				if(!empty($payitem)) {
					$checkurl = '/ibuy.html?itemid='.$payitem['itemid'];	//购买url
					if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
						$checkurl = '/classactive/bank.html';
					}
					$this->assign('checkurl',$checkurl);
				}
			}
		} 
		if($course['fprice'] == 0 && $roominfo['isschool'] == 7) {	//如果免费课程，则直接能播放
			$this->check = 1;
			$this->assign('check',$this->check);
		}
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;

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
		} else if($course['isrtmp'] == 1 && $type != 1) {	//rtmp特殊处理 
			$rtmpsource = $serverutil->getRtmpCourseSource();
			if(!empty($rtmpsource)) {
				$key = $this->getKey($user);
				$cwurl = $course['cwurl'];
				$key = urlencode($key);
				$rtmpurl = "$rtmpsource?k=$key&id=$cwid/flv:$cwurl";
				$course['rtmpurl'] = $rtmpurl;
			}
		} else {
			$course['m3u8url'] = '';
		}
        $this->assign('course', $course);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
		$queryarr['status'] = 1;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $reviewcount = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($reviewcount);
		
		$askmodel = $this->model('askquestion');
		$askcount = $askmodel->getRequiredAnswersCount(array('cwid'=>$cwid));
		$this->assign('askcount',$askcount);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$isfree = 0;
		$this->assign('isfree',$isfree);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('user',$user);
		$this->assign('from',$from);
        $this->assign('reviews', $reviews);
		$this->assign('reviewcount',$reviewcount);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		if($type != 'flv' && $course['ism3u8'] == 1) {
			$type = 'flv';
		}
		$this->assign('type',$type);

		//做笔记
		$upcontrol = Ebh::app()->lib('UpcontrolLib');
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('upcontrol', $upcontrol);
		$this->assign('editor', $editor);
		$param = array();
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		$notemodel = $this->model('note');
		$mynote = $notemodel->getFlashNoteBycwid($param);//获取笔记
		$this->assign('mynote', $mynote);

		//单个课件下的作业
		/*$exammodel  = $this->model('exam');
		$cwid = $this->uri->itemid;
		$param = array('cwid'=>$cwid,'stuid'=>$user['uid'],'status'=>1,'limit'=>'0,100');
		if($roominfo['isschool']==2){
			$examlist = $exammodel->getexamonlinelist($param);
		}else{
			$examlist = $exammodel->getschexamlistbycwid($param);
			$examlist = $this->_filterSchexams($examlist);
		}
		$this->assign('examlist', $examlist);*/
		
		//调查问卷
		$surveymodel = $this->model('survey');
		$survey = $surveymodel->getSurveyByCwid($cwid,$user['uid']);
		
		
		$this->assign('survey',$survey);
		if($type == 'flv' || $type == 'mp3'){

			$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
			$is_iphone = (strpos($agent, 'iphone')) ? true : false;
	        $is_android = (strpos($agent, 'android')) ? true : false;
	        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
	        
			if($is_iphone || $is_android || $is_ipad){
				$this->display('myroom/course_mobile');
			}else{
				$this->display('myroom/course');
			}
		}else{
			$this->display('college/mycourse_view');
		}
	}
	
	//ajax的评论分页
	function getajaxpage(){
		$queryarr['pagesize'] = 10;
        $queryarr['cwid'] = intval($this->input->post('cwid'));
		$queryarr['page'] = intval($this->input->post('page'));
		//优先取缓存
		$reviewkey = $this->cache->getcachekey('course_review',$queryarr);
    	$reviewlist = $this->cache->get($reviewkey);
    	if(!empty($reviewlist)){
    		echo json_encode($reviewlist);
    		exit;
    	}
    	Ebh::app()->getDb()->set_con(0);//读取主数据库
		$reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//数据格式化 时间和头像缩略图
		foreach($reviews as &$review){
			$review['dateline'] = date('Y-m-d H:i:s', $review['dateline']);
			if ($review['sex'] == 1){
				if($review['groupid']==5){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
				}else{
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
				}
			}else{
				if($review['groupid']==5){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
				}else{
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
				}
			}
			$face = empty($review['face']) ? $defaulturl : $review['face'];
			$face = getthumb($face, '50_50');			
			$review['face'] =$face;
		}

		$reviewlist = array("reviews"=>$reviews,'pagestr'=>$pagestr,'count'=>$count);
		$this->cache->set($reviewkey,$reviewlist,60);
		//json输出
		echo json_encode($reviewlist);
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
		$multipage = '<div class="pages"><div class="listPage">';
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
	 *按课程布置的作业筛选为当前用户有权限的作业
	 */
	private  function _filterSchexams($schexamlist = array()){
		
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();

		$classModel = $this->model('classes');
		$myclass = $classModel->getClassByUid($roominfo['crid'],$user['uid']);
		
		if(empty($myclass)){
			return array();
		}
		$newSchexamList = array();
		foreach ($schexamlist as $schexam) {
			if($schexam['classid'] == $myclass['classid']){
				$newSchexamList[] = $schexam;
				continue;
			}

			if(!empty($myclass['grade'])) {
				if($myclass['grade'] == $schexam['grade'] && $myclass['district'] == $schexam['district']){
					$newSchexamList[] = $schexam;
					continue;
				}
			}
		}
		return $newSchexamList;
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

	/*
	*提交笔记
	*/
	public function addnote(){
		$cwid = $this->input->post('cwid');
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array();
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		$notemodel = $this->model('note');
		$mynote = $notemodel->getFlashNoteBycwid($param);//获取笔记
		$param['ftext'] = $this->input->post('message');
		$param['crid'] = $roominfo['crid'];
		
		if(empty($mynote)){//新增笔记
			$res = $notemodel->addFlashNote($param);
		}else{//修改笔记
			$res = $notemodel->editFlashNote($param);
		}
		if($res !== false)
			echo 'success';
		else
			echo 'error';
	}
	
	/*
	课件相关问题列表
	*/
	public function linkask(){
		$cwid = $this->input->post('cwid');
		if(!is_numeric($cwid))
			exit;
		$param['cwid'] = $cwid;

		//从缓存取第一页数据
		$linkedquestionskey = $this->cache->getcachekey('linkedquestionskey',array('cwid'=>intval($cwid),'page'=>1,'pagesize'=>10));
	    $linkedquestions = $this->cache->get($linkedquestionskey);
	    if(!empty($linkedquestions)){
	    	echo json_encode($linkedquestions);
	    	exit;
	    }
	    Ebh::app()->getDb()->set_con(0);//主数据库读取，防止数据来不及同步
		$askmodel = $this->model('askquestion');
		// $linkedquestions['list'] = $askmodel->getRequiredAnswers($param);
		// $linkedquestions['list'] = EBH::app()->lib('UserUtil')->init($linkedquestions['list'],array('uid','tid','lastansweruid'),true);
		// $linkedquestions['count'] = $askmodel->getRequiredAnswersCount($param);
		$param['shield'] = 0;
		$linkedquestions['list'] = $askmodel->getallasklist($param);
        $linkedquestions['count'] = $askmodel->getallaskcount($param);
		
		foreach($linkedquestions['list'] as $akey=>$avalue) { 
			if(!empty($avalue['face'])){
				$linkedquestions['list'][$akey]['face'] = getthumb($avalue['face'],'50_50');
			}else{
				if($avalue['sex']==1){
					if($avalue['groupid']==5){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
					}else{
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					}
				}else{
					if($avalue['groupid']==5){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
					}else{
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					}
				}
											
				$linkedquestions['list'][$akey]['face'] = getthumb($defaulturl,'50_50');
			}
		}
		//第一页60s
		$this->cache->set($linkedquestionskey,$linkedquestions,60);
		echo json_encode($linkedquestions);
	}

	 /*
     *ajax获取对应的课件下的作业
     */
    public function getCwidExamsAjax() {
        $cwid = intval($this->input->post('cwid'));
        if (!$cwid) {
            exit(0);
        }
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        //获取课件下的作业记录
        $exammodel  = $this->model('exam');
		$param = array('cwid'=>$cwid,'stuid'=>$user['uid'],'status'=>1,'limit'=>'0,100');
		if($roominfo['isschool']==2){
			$examlist = $exammodel->getexamonlinelist($param);
		}else{
			$examlist = $exammodel->getschexamlistbycwid($param);
			$examlist = $this->_filterSchexams($examlist);
		}
        echo json_encode($examlist);
    }

	/**
	*验证IP
	*/
	private function checkAllowIp() {
		$limittime = 10800;	//限制3小时
		$user = Ebh::app()->user->getloginuser();
		$curip = $this->input->getip();
		$allowip = $user['allowip'];
		$curtime = SYSTIME;
		$usermodel = $this->model('User');
		if(empty($allowip)) {
			$userparam = array('allowip'=>$curip);
			$usermodel->update($userparam,$user['uid']);
			return TRUE;
		} else {
			if($curip != $allowip) {	//如果允许的IP和当前IP不同，则跳转到等待页面
				$limitmodel = $this->model('Limitlog');
				$limitparam = array('uid'=>$user['uid'],'fromip'=>$curip,'isfinish'=>0);
				$mylog = $limitmodel->getLogByIp($limitparam);
				if(empty($mylog)) {	//不存在，则新生成记录
					$limitparam['startdate'] = $curtime;
					$limitmodel->addlog($limitparam);
				} else {
					if(($curtime - $mylog['startdate']) >= $limittime) {	//等待时间够了，则更新
						$userparam = array('allowip'=>$curip);
						$usermodel->update($userparam,$user['uid']);
						$limitparam['isfinish'] = 1;
						$limitparam['enddate'] = $curtime;
						$limitmodel->update($limitparam,$mylog['logid']);
						return TRUE;
					}
				}
//				$url = '/safe.html';
//				header("Location: $url");
//				exit();
				return FALSE;
			}
			return TRUE;
		}
	}
}
