<?php

/**
 * 课件相关的
 * @author eker
 * @time 2016年5月30日11:39:28
 */
class CourserelevantController extends CControl {
	private $check = 1;
	public function __construct() {
		parent::__construct();
		Ebh::app()->room->checkteacher();
		$folderid = $this->input->get('folderid');
		$this->assign("folderid", intval($folderid));
		
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		
		$user = Ebh::app()->user->getloginuser();
		$this->assign("user", $user);
/* 		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		} */
		$this->check = $check;
	}
	
	
	/**
	 * 课程介绍
	 */
	public function introduce(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$folderid = $this->input->get('folderid');
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		if(!empty($folder['introduce']))
			$folder['introduce'] = unserialize($folder['introduce']);
		$this->assign('folder',$folder);
		$this->assign('index',2);
		$this->display('troomv2/courserelevant_introduce');
	}
	
	/**
	 * 任课老师
	 */
	public function teacher(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$q = $this->input->get('q');
		//$aq = $this->input->get('aq');
		//$folderid = $this->input->get('fid');
		$requireFolderid = $this->input->get('folderid');
		if(!is_numeric($requireFolderid) || $requireFolderid < 0){
			echo '课程不存在,请刷新页面重试';
			exit();
		}
		if(!empty($requireFolderid)){
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
			$this->assign('index',3);
		}
		//$cwid = $this->input->get('cwid');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['folderid'] = $requireFolderid;
		$param['q'] = $q;
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getcourseteacher($param);

		//java数据服务器地址,取新作业的数据
		$newExamPower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($newExamPower) {
			$param['ttype'] = 'FOLDER';
			$param['tid'] = $requireFolderid;
			$dataserver = EBH::app()->getConfig('dataserver')->load('dataserver');
	        $servers = $dataserver['servers'];
	        //随机抽取一台服务器
	        $target_server = $servers[array_rand($servers,1)];
			$url = 'http://'.$target_server.'/exam/telist';
		}
        
		foreach ($teacher as $k=>$arr) {
			$param['uid'] = $arr['tid'];
			//$param['folderid'] = $requireFolderid;
			//讲课(课件数)
			$coursewaremodel = $this->model('courseware');
			$coursewarecount = $coursewaremodel->getTcoursecount($param);
			$teacher[$k]['coursewarecount'] =  $coursewarecount['count'];
			//总课时
			$teacher[$k]['coursewarecwlength'] =  $coursewarecount['cwlength'];

			//作业数量
			if ($newExamPower) {//开通新作业就用新作业的页面
				$param['status'] = 1;
				$param['size'] = 1;
				$param['k'] = authcode(json_encode(array('uid'=>$arr['tid'],'crid'=>$roominfo['crid'],'t'=>SYSTIME)),'ENCODE');
				$postParam = json_encode($param);
				$postRet = do_post($url,$postParam,FALSE,TRUE);
				$examcount = $postRet->datas->pageInfo->totalElement;
			} else {
				$examodel = $this->model('exam');
				$examcount = $examodel->getTexamcount($param);
			}
			$teacher[$k]['examcount'] = $examcount;

			//解答数量
			$askcountmodel = $this->model('askquestion');
			$askcount = $askcountmodel->getaskcountbyanswers($param);
			$teacher[$k]['askcount'] =  $askcount;
			//评论
			$param['rev'] = 'rev';
			$reviewmodel = $this->model('review');
			$reviewcount = $reviewmodel->getreviewcount($param);
			$teacher[$k]['reviewcount'] =  $reviewcount;
			//积分
			$classmodel = $this->model('Classes');
			$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
			foreach($clconfig as $clevel){
				if($arr['credit']>=$clevel['min'] && $arr['credit']<=$clevel['max']){
					$teacher[$k]['jifen_data'] = $clevel['title'];
				}
			}
				
		}
		$this->assign('teacher',$teacher);
		$this->assign('q',$q);
		//var_dump($teacher);
		//exit;
		$this->display('troomv2/courserelevant_teacher');
	}
	
	/**
	 * 相关作业
	 */
	public function exam(){
		$folderid = intval($this->input->get('folderid'));
		if($folderid <= 0){
			exit();
		}
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);

		$newExamPower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($newExamPower) {//开通新作业就用新作业的页面
			$this->assign('roominfo',$roominfo);
            $this->assign('examPower',1);
            $this->assign('index',4);
            $this->display('troomv2/courserelevant_exam');
            exit();
		}
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$examdate = $this->input->get('ed');
		$queryarr = parsequery();
		$queryarr['pagesize'] = 10;
		
		
		$queryarr['folderid'] = $folderid;
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['classid'] = $myclass['classid'];
		$queryarr['filteranswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		if(!empty($examdate)) {	//过滤答题时间
			unset($queryarr['filteranswer']);
			$examtime = strtotime($examdate);
			if($examtime !== FALSE) {
				$queryarr['ebegindate'] = $examtime;
				$queryarr['eenddate'] = $examtime + 86400;
			} else {
				$examdate = '';
			}
		}
		$queryarr['type'] = array(0,2);
		
		
		$exams = $exammodel->getExamListByMemberid($queryarr);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		//echo '<pre>';
		//var_dump($exams);
		$pagestr = show_page($count,$queryarr['pagesize']);
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('examPower','');
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
		$this->assign('index',4);
		
		//$this->display('college/myexam_all');
		$this->display('troomv2/courserelevant_exam');
	}
	
	/**
	 * 互动答疑
	 */
	public function  interact(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$q = $this->input->get('q');
		$askdate = $this->input->get('d');
		$aq = $this->input->get('aq');
		$folderid = $this->input->get('fid');
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		//var_dump($folder);
		$cwid = $this->input->get('cwid');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['shield'] = 0;
		$queryarr['aq'] = $aq;
		$queryarr['cwid'] = intval($cwid);
		$folderid = intval($folderid);
		if(!empty($folderid)){
			$queryarr['folderid'] = $folderid;
		}
		if(!empty($askdate)) {	//过滤提问时间
			$asktime = strtotime($askdate);
			if($asktime !== FALSE) {
				$queryarr['abegindate'] = $asktime;
				$queryarr['aenddate'] = $asktime + 86400;
			} else {
				$askdate = '';
			}
		}
		$askmodel = $this->model('Askquestion');
		$asks = $askmodel->getallasklist($queryarr);
		$count = $askmodel->getallaskcount($queryarr);
		$pagestr = show_page($count);
		
		$key = $this->_getplaykey();
		//更新评论用户状态时间
		$statemodel = $this->model('Userstate');
		$typeid = 2;
		$statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
		
		$this->assign('asks', $asks);
		$this->assign('pagestr', $pagestr);
		$this->assign('user', $user);
		$this->assign('crid', $roominfo['crid']);
		$this->assign('q', $q);
		$this->assign('aq', $aq);
		$this->assign('key', $key);
		$this->assign('index',5);
		
		//$this->display('college/myask_all');
		
		
		
		$this->display('troomv2/courserelevant_interact');
		$this->_updateuserstate();
		
	}
	
	/**
	 * 资料下载
	 */
	public function attachment(){

		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$requireFolderid = $this->input->get('folderid');
		if(!is_numeric($requireFolderid) || $requireFolderid < 0){
			echo '课程不存在,请刷新页面重试';
			exit();
		}
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		$q = $this->input->get('q');
		$queryarr = parsequery();
		$queryarr['folderid'] = $folderid;
		$attmodel = $this->model('attachment');
		$attlist = $attmodel->getAttachByFolderid($queryarr);
		EBH::app()->helper('fileico');
		foreach ($attlist as $k=>$att) {
			$attlist[$k]['csize'] = $this->getsize($att['size']);
			$attlist[$k]['ico'] = format_ico($att['suffix']);
		}
		$this->assign('attlist',$attlist);
		
		$serverutil = Ebh::app()->lib('ServerUtil');
		$source = $serverutil->getCourseSource();
		$this->assign('source',$source);
		
		$this->assign('q', $q);
		$this->assign('index',6);
		
		if($folder['fprice'] >= 0 && $roominfo['isschool'] == 7) {
//			$perparam = array('crid'=>$roominfo['crid'],'folderid'=>$folder['folderid']);
			if($this->check == 1) {	//判断是否是该学校老师
                $roomlist = $this->model('classroom')->getroomlistbytid($user['uid']);
                if(!empty($roomlist)){
                    foreach($roomlist as $room){
                        $roomids[] = $room['crid'];
                    }
                }
                if(in_array($roominfo['crid'],$roomids)){
                    $this->check = 1;
                }else{
                    $this->check = -1;
                }
//				$this->check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
		
			}
			$this->assign('check',intval($this->check));
		}
        $this->assign('roominfo',$roominfo);
		
		//$this->display('college/attachment');
		
		$this->display('troomv2/courserelevant_attachment');
	}
	
	/**
	 * 调查问卷
	 */
	public function survey(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		
		$param['folderid'] = $this->input->get('folderid');
		$folder = $this->model('folder')->getfolderbyid($param['folderid']);
		$this->assign('folder',$folder);
		
		$param['crid'] = $roominfo['crid'];
		$param['ispublish'] = 1;
		$param['answered'] = true;//是否已回答
		$param['uid'] = $user['uid'];
		$surveylist = $this->model('survey')->getSurveyList($param);
		$surveycount = $this->model('survey')->getSurveyCount($param);
		$pagestr = show_page($surveycount);
		
		$this->assign('pagestr',$pagestr);
		$this->assign('surveylist',$surveylist);
		$this->assign('index',7);
		
		//var_dump($surveylist);
		//$this->display('college/survey_list');
		$this->display('troomv2/courserelevant_survey');
		
	}
	
	//大小处理
	private function getsize($bsize){
		$size = "0字节";
		if (!empty($bsize))
		{
			$gsize = $bsize / (1024 * 1024 * 1024);
			$msize = $bsize / (1024 * 1024);
			$ksize = $bsize / 1024;
			if ($gsize > 1)
			{
				$size = round($gsize,2) . "G";
			}
			else if($msize > 1)
			{
				$size = round($msize,2) . "M";
			}
			else if($ksize > 1)
			{
	
				$size = round($ksize,0) . "K";
			}
			else
			{
				$size = $bsize . "字节";
			}
		}
		return $size;
	}
	/**
	 *获取播放器提问和播放器回答所需的key值
	 */
	private function _getplaykey() {
		$clientip = $this->input->getip();
		$ktime = SYSTIME;
		$auth = $this->input->cookie('auth');
		$sauth = authcode($auth, 'DECODE');
		@list($password, $uid) = explode("\t", $sauth);
		$skey = $ktime . '\t' . $uid . '\t' . $password . '\t' . $clientip;
		$key = authcode($skey, 'ENCODE');
		return $key;
	}
	/**
	 *更新新作业用户状态时间
	 */
	private function _updateuserstate() {
		//更新评论用户状态时间
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$statemodel = $this->model('Userstate');
		$typeid = 4;
		$statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
	}
	/**
	 *权限信息注入
	 */
	private function _premissionInsert($examlist = array()){
	
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
	
		$newexamlist = array();
		if($roominfo['isschool'] != 7){
			foreach ($examlist as $cw) {
				$cw['itemid'] = 0;
				$newexamlist[] = $cw;
			}
			return $examlist;
		}
		$userpermodel = $this->model('Userpermission');
		$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
		//我已经购买的课程
		$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
		$myfolderlist = $this->_modifyKeys($myfolderlist);
		//学校的收费课程
		$hideschoolfree = true; //全校免费不属于收费课程
		$notFreeFolderList = $this->model('folder')->getNotFreeFolderList($crid,$hideschoolfree);
		$notFreeFolderList = $this->_modifyKeys($notFreeFolderList);
	
		//学校的收费课程(服务包中)
		$roomfolderlist = $userpermodel->getPayItemByCrid($roominfo['crid']);
		$roomfolderlist = $this->_modifyKeys($roomfolderlist);
		//顺便将包信息分配到页面用于根据folderid获取包名
		$this->assign('iteminfo',$roomfolderlist);
	
		//没有购买的学校收费课程
		$notBuyFolderList = array();
		foreach ($notFreeFolderList as $nkey => $notFreeFolder) {
			if(!array_key_exists($nkey, $myfolderlist)){
				$notBuyFolderList[$nkey] = $notFreeFolder;
			}
		}
		foreach ($examlist as $cw) {
			$key = 'f_'.$cw['folderid'];
			if(array_key_exists($key, $notBuyFolderList)){
				if(array_key_exists($key, $roomfolderlist)){
					$cw['itemid'] = intval($roomfolderlist[$key]['itemid']);
				}else{
					$cw['itemid'] = 0; //如果是收费课程但是不在服务包里面的也视为免费
				}
			}else{
				$cw['itemid'] = 0;
			}
			$newexamlist[] = $cw;
		}
		$this->_assignCheckUrl();
		return $newexamlist;
	}
	
	/**
	 *将索引数组变成关联数组
	 */
	private function _modifyKeys($somelist = array()){
		$returnArr = array();
		foreach ($somelist as $some) {
			$key = 'f_'.$some['folderid'];
			$returnArr[$key] = $some;
		}
		return $returnArr;
	}
	
	/**
	 *分配购买地址
	 */
	private function _assignCheckUrl(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$checkurl = '/ibuy.html?itemid=';
		$this->assign('_checkurl',$checkurl);
	}
	/**
	 *return new valid user token key
	 */
	private function getKey($user) {
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}
	/**
	 *判断当前是否为Apple系统产品浏览器
	 */
	private function _isApple() {
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if (strpos($useragent, 'ipad') !== FALSE || stripos($useragent, 'iphone') !== FALSE)
			return TRUE;
		return FALSE;
	}
}