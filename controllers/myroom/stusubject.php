<?php
/**
 * 学校学生学习课程控制器 StusubjectController
 */
class StusubjectController extends CControl {
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
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo',$roominfo);
        $this->display('myroom/stusubject');
		// $this->_updateuserstate();
    }
	/**
	*我的课程
	*/
	public function mycourse() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$foldermodel = $this->model('Folder');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		if(!empty($myclass['classid']))
			$queryarr['classid'] = $myclass['classid'];
		else{
			header('Location:'.geturl('myroom/stusubject/allcourse'));
			exit;
		}
		if(!empty($myclass['grade']))
			$queryarr['grade'] = $myclass['grade'];
		$queryarr['pagesize'] = 15;
		$queryarr['order'] = ' coursewarenum desc';
		$folders = $foldermodel->getClassFolder($queryarr);
		$count = $foldermodel->getClassFolderCount($queryarr);
		$pagestr = show_page($count,15);
		$from = 1;	//表示我的课程
		$this->assign('from',$from);
		$this->assign('pagestr',$pagestr);
		$this->assign('folders',$folders);
		$this->assign('roominfo',$roominfo);
		$this->display('myroom/mycourse');
		
	}
	/**
	*全校课程
	*/
	public function allcourse() {
		$roominfo = Ebh::app()->room->getcurroom();
		$foldermodel = $this->model('Folder');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['pagesize'] = 1000;
		$queryarr['nosubfolder'] = 1;
		$queryarr['needpower'] = 1;
		$folders = $foldermodel->getfolderlist($queryarr);
		if($roominfo['isschool'] == 7) {	//收费分成学校，则未开通或已过期的课程，就显示阴影和开通按钮
			$user = Ebh::app()->user->getloginuser();
			/*
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			$roomfolderlist = $userpermodel->getPayItemByCridWithFolder($roominfo['crid']);
			$folderlist = array();
			foreach($roomfolderlist as $k=>$myfolder) {
				$myfolder['haspower'] = 0;
				$myfolder['payurl'] = '';
				if($myfolder['fprice'] == 0) {
					$myfolder['haspower'] = 1;
				}
				$folderlist[$myfolder['itemid']] = $myfolder;
			}
			$ofolderidstr = '';	//如果有权限的课程没有在当前页的课程内，则需要单独加上
			foreach($myfolderlist as $myfolder1) {	//看看哪些有权限
				if(isset($folderlist[$myfolder1['itemid']])) {
					$folderlist[$myfolder1['itemid']]['haspower'] = 1;
				}/* else {
					if(empty($ofolderidstr)) {
						$ofolderidstr = $myfolder1['folderid'];
					} else {
						$ofolderidstr = $ofolderidstr.','.$myfolder1['folderid'];
					}
				}
			}
			// if(!empty($ofolderidstr)) {
				// $oqueryarr = array('folderid'=>$ofolderidstr);
				// $ofolderlist = $foldermodel->getfolderlist($oqueryarr);
				// if(!empty($ofolderlist)) {
					// foreach($ofolderlist as $ofolder) {
						// $ofolder['haspower'] = 1;
						// $folderlist[$ofolder['folderid']] = $ofolder;
					// }
				// }
			// }
			foreach($roomfolderlist as $myfolder2) {
				if(isset($folderlist[$myfolder2['folderid']])) {
					if($folderlist[$myfolder2['folderid']]['haspower'] == 0) {	//没有权限，则加上链接
						$checkurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$myfolder2['itemid'];	//购买url
						if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
							$checkurl = '/classactive/bank.html';
						}
						$folderlist[$myfolder2['folderid']]['payurl'] = $checkurl;
					}
				}
			}
			
			$folders = array();
			foreach($folderlist as $folder){
				if($folder['haspower']){
					if(empty($folders[$folder['pid']]))
						$folders[$folder['pid']] = array($folder);
					else
						$folders[$folder['pid']][] = $folder;
				}
			}
			*/
			//获取服务包
			$spmodel = $this->model('PayPackage');
			$thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
			$splist = array();
			$spidlist = '';
			//将结果数组以pid为下标排列,并记录pid合集字符串
			foreach($thelist as $mysp) {
				$splist[$mysp['pid']] = $mysp;
				$splist[$mysp['pid']]['itemlist'] = array();
				if(empty($spidlist)) {
					$spidlist = $mysp['pid'];
				} else {
					$spidlist .= ','.$mysp['pid'];
				}
			}
			///////开通的课程
			$folders = $splist;
			if(!empty($spidlist)) {
				$pitemmodel = $this->model('PayItem');
				$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>0);
				$itemlist = $pitemmodel->getItemFolderList($itemparam);
				if(!empty($itemlist)) {
					foreach($itemlist as $myitem) {
						if(isset($folders[$myitem['pid']])) {
							$folders[$myitem['pid']]['itemlist'][] = $myitem;
						}
					}
				}
			}
			$mylist = array();
			if(!empty($user) && $user['groupid'] == 6) {
				$userpermodel = $this->model('Userpermission');
				$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
				$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
				foreach($myfolderlist as $myfolder) {
					$mylist[$myfolder['folderid']] = $myfolder;
				}
			}
			foreach($folders as $k=>$package){
				$showpack = false;
				foreach($package['itemlist'] as $l=>$folder){
					if($folder['fprice']==0 || isset($mylist[$folder['folderid']]))
						$showpack = true;
					else
						unset($folders[$k]['itemlist'][$l]);
				}
				if($showpack == false)
					unset($folders[$k]);
			}
			
			
			///////////未开通的课程
			if(!empty($spidlist)) {
				$pitemmodel = $this->model('PayItem');
				$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'i.pid,f.displayorder','uid'=>$user['uid'],'crid'=>$roominfo['crid'],'power'=>0);
				$itemlist = $pitemmodel->getItemFolderListNotPaid($itemparam);
				// var_dump($itemlist);
				if(!empty($itemlist)) {
					foreach($itemlist as $myitem) {
						$itemurl = empty($roominfo['fulldomain']) ? $roominfo['domain'].'.'.$this->uri->curdomain : $roominfo['fulldomain'];
						$myitem['payurl'] = 'http://'.$itemurl.'/ibuy.html?itemid='.$myitem['itemid'].'&sid='.$myitem['sid'];
						if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
							$myitem['payurl'] = '/classactive/bank.html';
						}
						if(isset($splist[$myitem['pid']])) {
							$splist[$myitem['pid']]['itemlist'][] = $myitem;
						}
						
					}
				}
			}
			// var_dump($splist);
			$this->assign('splist',$splist);
		}
		$count = $foldermodel->getcount($queryarr);
		// $pagestr = show_page($count,15);
		$from = 0;	//表示全校课程
		$this->assign('from',$from);
		// $this->assign('pagestr',$pagestr);
		$this->assign('folders',$folders);
		$this->assign('roominfo',$roominfo);
		$this->display('myroom/mycourse');
	}
	/**
	*全校教师
	*/
	public function allteachers() {
		$roominfo = Ebh::app()->room->getcurroom();
		$foldermodel = $this->model('Folder');
		$teachers = $foldermodel->getTeacherFolderList(array('crid'=>$roominfo['crid'],'power'=>'0'));
		$this->assign('teachers',$teachers);
		$this->display('myroom/allteachers');
	}
	/**
	*课程详情（课件列表页）
	*/
	public function view() {

		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$from = $this->uri->uri_attr(0);	//课程来源。空为全校课程 1为我的课程 2为全校教师
        $this->assign('uid', $user['uid']);
        $folderid = $this->uri->itemid;
		
        $subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 100;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
		$this->assign('count',$count);
        $pagestr = show_page($count,$pagesize);
        $sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			$viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
			if(!empty($viewnum))
				$course['viewnum'] = $viewnum;
            $sectionlist[$course['sid']][] = $course;
        }
		//获取直播课信息
		$onlinelist = array();
		$onlinesource = '';
		if($roominfo['isschool'] == 7) {	//目前只针对收费学校开放直播课
			$check = 1;
			$key = '';
			//针对isschool为7并且价格不为0的情况还要判断是否有课程权限
			if($folder['fprice'] > 0 && $roominfo['isschool'] == 7) {
				$perparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid);
				$check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
				if($check != 1) {
					$payitem = Ebh::app()->room->getUserPayItem($perparam);
					$this->assign('payitem',$payitem);
					if(!empty($payitem)) {
						$checkurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$payitem['itemid'];	//购买url
						$this->assign('checkurl',$checkurl);
					}
				}
				
			}
			if($check == 1) {
				$key = $this->_getOnlineKey();
				//$key = urlencode($key);
			}
			$this->assign('check',$check);
			$this->assign('key',$key);
			$onlinemodel = $this->model('Onlinecourse');
			$onlineparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'limit'=>200);
			if(!empty($q))
				$onlineparam['q'] = $q;
			$onlinelist = $onlinemodel->getListByFolder($onlineparam);
			$serverUtil = Ebh::app()->lib('ServerUtil');
			$onlinesource = $serverUtil->getOnlineSource();
		}
		$this->assign('onlinesource',$onlinesource);
		$this->assign('onlinelist',$onlinelist);
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getfolderfavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		
		foreach($sectionlist as $k=>$section){
			$queryarr['sid'] = $k;
			$sectioncount = $coursemodel->getfolderseccoursecount($queryarr);
			$sectionlist[$k][0]['sectioncount'] = $sectioncount;
		}
		
		//服务包限制时间,用于判断往期课件
		$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$limitdate = $pmodel->getFirstLimitDate(array('folderid'=>$folderid,'uid'=>$user['uid']));
			$this->assign('limitdate',$limitdate['firstday']);
		}
		
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('from',$from);
		$this->assign('q',$q);
        $this->assign('sectionlist', $sectionlist);
        $this->assign('pagestr', $pagestr);

        $cwsmod = $this->input->get('cwsmod');
        $cwsmodkey = 'cwsmod_crid_'.$roominfo['crid'];
        if(empty($cwsmod)){
        	$cwsmod = $this->input->cookie($cwsmodkey);
        }else{
        	$this->input->setcookie($cwsmodkey,$cwsmod,86400);
        }
        if(!empty($cwsmod)){
        	$this->assign('cwsmod',$cwsmod);
        	$this->input->setcookie($cwsmodkey,$cwsmod,864000);
        	if($cwsmod == 'grid'){
        		//获取播放课件播放记录
	        	$playlogs = $this->getPlayList($folderid);
	        	$this->assign('playlogs',$playlogs);
				$this->display('myroom/stusubject_view_new_block');
        	}else{
        		$this->display('myroom/stusubject_view_new');
        	}
        }else if( !empty($folder) && !empty($folder['coursewarelogo'])){
        	//获取播放课件播放记录
        	$playlogs = $this->getPlayList($folderid);
        	$this->assign('playlogs',$playlogs);
            $this->assign('cwsmod','list');
            $this->display('myroom/stusubject_view_new');
        }else{

            $this->assign('cwsmod','grid');
            $this->display('myroom/stusubject_view_new_block');
        }
	}
	/**
	*更新新作业用户状态时间
	*/
	private function _updateuserstate() {
		//更新新课程用户状态时间
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
        $statemodel = $this->model('Userstate');
        $typeid = 2;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
	}
	
	/*
	获取我的课程，全校课程，全校教师，听课笔记数量
	*/
	public function getcountinfo(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$foldermodel = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$count['allcourse'] = $foldermodel->getcount($param);
		$teacher = $this->model('teacher');
		$count['allteachers'] = $teacher->getroomteachercount($roominfo['crid'],array());
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$notemodel = $this->model('note');
		$param['uid'] = $user['uid'];
		$count['notes'] = $notemodel->getnotelistcountbyuid($param);
		$favoritemodel = $this->model('favorite');
		$count['favorite'] = $favoritemodel->getcoursefavoritelistcount($param);
		if($roominfo['isschool']!='7'){
			$param['classid'] = $myclass['classid'];
			$param['grade'] = $myclass['grade'];
			$count['mycourse'] = $foldermodel->getClassFolderCount($param);
		}
		//最新课程
		$statemodel = $this->model('Userstate');
		$subtime = $statemodel->getsubtime($roominfo['crid'],$user['uid'],2);
		$coursemodel = $this->model('Courseware');
		$count['newcourse'] = $coursemodel->getnewcourselistcount(array('crid'=>$roominfo['crid'],'subtime'=>$subtime));
		echo json_encode($count);
	}
	
	/*
	最新课程
	*/
	public function newcourse(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cwmodel = $this->model('courseware');
		$user = Ebh::app()->user->getloginuser();
		//开通课程的id
		if($roominfo['isschool']==7){
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid']);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}else{
			$foldermodel = $this->model('folder');
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
			$paramf['crid'] = $roominfo['crid'];
			$paramf['classid'] = $myclass['classid'];
			$paramf['limit'] = 100;
			if(!empty($myclass['grade'])){
				$paramf['grade'] = $myclass['grade'];
				$myfolderlist = $foldermodel->getClassFolderWithoutTeacher($paramf);
			}else{
				$myfolderlist = $foldermodel->getClassFolder($paramf);
			}
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}
		$param['crid'] = $roominfo['crid'];
		$param['limit'] = 200;
		$param['order'] = 'rc.cwid desc';
		$param['power'] = 0;
		$cwlist = $cwmodel->getnewcourselist($param);
		$newcwlist = array();
		
		$redis = Ebh::app()->getCache('cache_redis');
		
		//以cwid倒序取的数据.
		//按时间排序,有submitat取submitat,没有submitat取dateline.
		$cwcount = count($cwlist);
		for($i=0;$i<$cwcount;$i++){
			for($j=$i;$j<$cwcount;$j++){
				$date1 = !empty($cwlist[$i]['submitat'])?$cwlist[$i]['submitat']:$cwlist[$i]['dateline'];
				$date2 = !empty($cwlist[$j]['submitat'])?$cwlist[$j]['submitat']:$cwlist[$j]['dateline'];
				if($date1<$date2){
					$temp = $cwlist[$i];
					$cwlist[$i] = $cwlist[$j];
					$cwlist[$j] = $temp;
				}
			}
		}
		// var_dump($cwlist);
		foreach($cwlist as $cw){
			$viewnum = $redis->hget('coursewareviewnum',$cw['cwid']);
			if(!empty($viewnum))
				$cw['viewnum'] = $viewnum;
			$cw['dateline'] = !empty($cw['submitat'])?$cw['submitat']:$cw['dateline'];
			$dayis = date('Y-m-d',$cw['dateline']);
			if($dayis == date('Y-m-d'))
				$dayis = 'z今天';
			elseif($dayis == date('Y-m-d',SYSTIME+86400))
				$dayis = 'y明天';
			elseif($dayis == date('Y-m-d',SYSTIME-86400))
				$dayis = 'x昨天';
			$newcwlist[$dayis][] = $cw;
		}
		//今天->明天->昨天->[日期]->[日期]...排序
		krsort($newcwlist);
		
		//取前50条
		$showcount = 50;
		$ncwcount = 0;
		$daycount = 0;
		$daylimit = 30; //离列表顶端课件30天的
		$timelimit = $daylimit*86400;
		$topdate = 0;
		foreach($newcwlist as $k=>$daylist){
			if(empty($topdate))
				$topdate = $daylist[0]['dateline'];
			$daycount++;
			foreach($daylist as $l=>$cw){
				$ncwcount++;
				if($ncwcount == $showcount){
					array_splice($newcwlist[$k],$l+1);
					break;
				}
			}
			if($topdate-$daylist[0]['dateline']>$timelimit && $daycount>1){
				array_splice($newcwlist,$daycount-1);
				break;
			}
			if($ncwcount == $showcount){
				array_splice($newcwlist,$daycount);
				break;
			}
		}
		//服务包限制时间,用于判断往期课件
		$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$datelist = $pmodel->getFirstLimitDate(array('crid'=>$roominfo['crid'],'uid'=>$user['uid']));
			$folderdate = array();
			foreach($datelist as $date){
				$folderdate[$date['folderid']] = $date['firstday'];
			}
			$this->assign('folderdate',$folderdate);
		}
		$this->assign('newcwlist',$newcwlist);
		$this->assign('roominfo',$roominfo);
		$this->display('myroom/newcourse');
		$this->_updateuserstate();
	}
	
	/*
	某一天的课件
	*/
	public function daycourse(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$cwmodel = $this->model('courseware');
		$cwdate = $this->input->get('d');
		if(!empty($cwdate)) {	
			$cwtime = strtotime($cwdate);
			if($cwtime !== FALSE) {
				$queryarr['truedatelinefrom'] = $cwtime;
				$queryarr['truedatelineto'] = $cwtime + 86400;
			} else {
				$cwdate = '';
			}
		}
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['limit'] = 100;
		//开通课程的id
		if($roominfo['isschool']==7){
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid']);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$queryarr['folderids'] = rtrim($folderids,',');
			}
		}else{
			$foldermodel = $this->model('folder');
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
			$param['crid'] = $roominfo['crid'];
			$param['classid'] = $myclass['classid'];
			if(!empty($myclass['grade']))
				$param['grade'] = $myclass['grade'];
			$param['pagesize'] = 100;
			$myfolderlist = $foldermodel->getClassFolder($param);
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$queryarr['folderids'] = rtrim($folderids,',');
			}
		}
		$queryarr['power'] = '0';
		$cwlist = $cwmodel->getnewcourselist($queryarr);
		$newcwlist[$cwdate] = $cwlist;
		$this->assign('day',$cwdate);
		$this->assign('newcwlist',$newcwlist);
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->display('myroom/newcourse');
	}
	
	/**
	*生成直播课对应的key，主要用于直播课权限验证
	*/
	private function _getOnlineKey() {
		$clientip = $this->input->getip();
        $ktime = SYSTIME;
        $auth = $this->input->cookie('auth');
        $sauth = authcode($auth, 'DECODE');
        @list($password, $uid) = explode("\t", $sauth);
        $skey = "$password\t$uid\t$clientip\t$ktime";
        $key = authcode($skey, 'ENCODE');
		return $key;
	}

	//获取课程播放总记录
	private function getPlayList($folderid = 0){
		$user = Ebh::app()->user->getloginuser();
		$param = array(
			'uid'=>$user['uid'],
			'folderid'=>$folderid,
			'limit'=>10000
		);
		$playlist = $this->model('playlog')->getList($param);
		if(!empty($playlist)){
			$playlist = $this->_modifyKeys($playlist,'cwid','cwid');
		}
		return $playlist;
	}

	/**
	 *将索引数组变成关联数组
	*/
	private function _modifyKeys($arrs = array(),$filedName,$prefix = ''){
		$returnArr = array();
		foreach ($arrs as $arr) {
			$key = $prefix.'_'.$arr[$filedName];
			$returnArr[$key] = $arr;
		}
		return $returnArr;
	}
}
