<?php
/**
 * 学校学生我的作业相关控制器 MycourseController
 */
class MyexamController extends CControl {
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			if($roominfo['isschool'] == 7 && $check != 1) {
				$folderid = $this->input->get('folderid');
				$perparam = array('crid'=>$roominfo['crid']);
				if(!empty($folderid) && is_numeric($folderid))
					$perparam['folderid'] = $folderid;
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
			$this->assign('check',$check);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->_assignCheckUrl();
    }
	public function index(){
		$this->display('college/myexam');
		$this->_updateuserstate();
	}
	/**
	*我的作业(所有作业)
	*/
	public function all() {
		$queryarr = parsequery();
		$domain = $this->uri->uri_domain();
		$roominfo = Ebh::app()->room->getcurroom();
		$requireFolderid = intval($this->input->get('folderid'));
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		if(!empty($folderid)){
			$queryarr['folderid'] = $folderid;
		}

		$isapple = $this->_isApple();
		$user = Ebh::app()->user->getloginuser();
		if($isapple) {
			$key = $this->getKey($user);
			$this->assign('isapple',$isapple);
			$this->assign('key',$key);
		}
		//检测是否开通了新版本作业，未开通的话作业用老数据
        $newExamPower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
        if ($newExamPower && $requireFolderid) {
            $this->display('college/myexamv2_all');
            $this->_updateuserstate();
            exit();
        }
		$exammodel = $this->model('Exam');
		
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);
		if($domain == 'lcyhg'){
			$classids = $classesmodel->getClassidsByUid($roominfo['crid'],$user['uid']);
		}
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$examdate = $this->input->get('ed');
		
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		if(isset($classids)){
			$queryarr['classids'] = $classids;
		}else{
			$queryarr['classid'] = $myclass['classid'];
		}
		$tid = $this->uri->uri_attr(0);
		if(!empty($tid)){
			$queryarr['tid'] = intval($tid);
		}
		if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
			$queryarr['grade'] = $myclass['grade'];
			$queryarr['district'] = $myclass['district'];
		}
		//$queryarr['filteranswer'] = 1;
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
		$queryarr['anstatus'] = 1;
		$exams = $exammodel->getExamListByMemberid($queryarr);
		//echo $exams;
		//var_dump($exams);die;
		// foreach ($exams as $key =>$exam) {
		// 	if(isset($exam['count']) && isset($exam['stunum'])){
		// 		if($exam['classid'] == 0){
		// 			unset($exams[$key]['count']);
		// 		}else{
		// 			$exams[$key]['stunum'] = $exams[$key]['count'];
		// 			unset($exams[$key]['count']);
		// 		}
		// 	}
		// }
		//注入权限信息(注入之后itemid大于0的就表示没有权限)
		$exams = $this->_premissionInsert($exams);
		$count = $exammodel->getExamcountByMemberid($queryarr);
		$pagestr = show_page($count,$queryarr['pagesize']);
		
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('college/myexam_all');
		$this->_updateuserstate();
	}
	/**
	* 我做过的作业
	*/
	public function my() {
		$domain = $this->uri->uri_domain();
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);
		if($domain == 'lcyhg'){
			$classids = $classesmodel->getClassidsByUid($roominfo['crid'],$user['uid']);
		}
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		if(!empty($folderid)){
			$queryarr['folderid'] = $folderid;
		}
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		if(isset($classids)){
			$queryarr['classids'] = $classids;
		}else{
			$queryarr['classid'] = $myclass['classid'];
		}
		if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
			$queryarr['grade'] = $myclass['grade'];
			$queryarr['district'] = $myclass['district'];
		}
		$queryarr['hasanswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		$queryarr['type'] = array(0,2);
		$queryarr['astatus'] = 1;
		$exams = $exammodel->getExamListByMemberid($queryarr);
		//var_dump($exams);die;
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count);
		$isapple = $this->_isApple();
		if($isapple) {
			$key = $this->getKey($user);
			$this->assign('isapple',$isapple);
			$this->assign('key',$key);
		}
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('college/myexam_my');
	}
	/**
	* 我的作业草稿箱
	*/
	public function box() {
		$domain = $this->uri->uri_domain();
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);
		if($domain == 'lcyhg'){
			$classids = $classesmodel->getClassidsByUid($roominfo['crid'],$user['uid']);
		}	
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		if(!empty($folderid)){
			$queryarr['folderid'] = $folderid;
		}
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		if(isset($classids)){
			$queryarr['classids'] = $classids;
		}else{
			$queryarr['classid'] = $myclass['classid'];
		}
		if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
			$queryarr['grade'] = $myclass['grade'];
			$queryarr['district'] = $myclass['district'];
		}
		$queryarr['astatus'] = 0;
		$queryarr['hasanswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		$queryarr['type'] = array(0,2);
		$exams = $exammodel->getExamListByMemberid($queryarr);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count);
		$isapple = $this->_isApple();
		if($isapple) {
			$key = $this->getKey($user);
			$this->assign('isapple',$isapple);
			$this->assign('key',$key);
		}
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('college/myexam_box');
	}
	/**
	*更新新作业用户状态时间
	*/
	private function _updateuserstate() {
		 //更新评论用户状态时间
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $typeid = 1;
		$userstatelib = Ebh::app()->lib('Userstate');
		$userstatelib->updateUserstate($roominfo['crid'], $user['uid'],$typeid);
	}
	/*
	获取做作业，已做作业，草稿箱，错题本数量
	*/
	public function getcountinfo(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$errormodel = $this->model('Errorbook');
		$count['myerrorbook'] = $errormodel->myscherrorbooklistcount($param);
		$param['classid'] = $myclass['classid'];
		$exammodel = $this->model('exam');
		$param['filteranswer'] = 1;
		$count['all'] = $exammodel->getExamListCountByMemberid($param);
		unset($param['filteranswer']);
		$param['hasanswer'] = 1;
		$count['my'] = $exammodel->getExamListCountByMemberid($param);
		$param['astatus'] = 0;
		$count['box'] = $exammodel->getExamListCountByMemberid($param);
		
		echo json_encode($count);
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

		//学校的收费课程(服务包中)免费课需要开通了，所以修改获取收费课的课程
		$roomfolderlist = $userpermodel->getPayItemByCrid($roominfo['crid'],1);
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
