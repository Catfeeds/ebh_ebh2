<?php

/**
 * 用户信息控制器类 UserstateController
 * 主要处理用户最新的待批作业数，答疑数，评论数等
 */
class UserstateController extends CControl {

    public function __construct() {
        parent::__construct();
        $user = Ebh::app()->user->getloginuser();
        if (empty($user)) {
            echo json_encode(array());
            exit;
        }
    }
    /*
     * 获取根据type和时间对应的用户需处理的记录数
     */
    public function index() {
		$callback = $this->input->get('callback');
		if (empty($callback))
		{
			$type = $this->input->post('type'); //需要查看的类型
		}
		else
		{
			$type = $this->input->get('type'); //需要查看的类型
		}
        if ($type !== NULL) {
            $typecounts = array();
            if (is_numeric($type)) {
                $typecounts[$type] = $this->_gettypecount($type);
            } else if (is_array($type)) {
                foreach ($type as $typeid) {
                    if (is_numeric($typeid)) {
                        $typecounts[$typeid] = $this->_gettypecount($typeid);
                    }
                }
            }
			if(!empty($callback)){
				echo $callback.'('.json_encode($typecounts).')';//jsonp响应
			}else{
				echo json_encode($typecounts);
			}
        }
    }
    /**
     * 根据分类获取该分类和用户状态时间下的记录数
     * @param type $type
     * @return int 记录数
     */
    private function _gettypecount($type) {
        $count = 0;
        $domain = $this->uri->uri_domain();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$crid = $roominfo['crid'];
		$uid = $user['uid'];
        $statemodel = $this->model('Userstate');
		//上一次访问时间，先取缓存
		$userstatelib = Ebh::app()->lib('Userstate');
		$subtime = $userstatelib->getCache_subtime($crid,$uid,$type);
		if(empty($subtime) && $type != 8){//8活动，没有用到subtime
			$subtime = $statemodel->getsubtime($roominfo['crid'],$user['uid'],$type);
		}
		$myclass = $this->model('Classes')->getClassByUid($roominfo['crid'],$user['uid']);
		if($domain == 'lcyhg'){
			$classesmodel = $this->model('Classes');
			$classids = $classesmodel->getClassidsByUid($roominfo['crid'],$user['uid']);
		}
        if($type == 1) {    //新作业
            $exammodel = $this->model('Exam');
            if($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
				$examparam = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'type'=>array(0,2),'anstatus'=>1);
				if(isset($classids)){
					$examparam['classids'] = $classids;
				}else{
					$examparam['classid'] = $myclass['classid'];
				}
				if(!empty($myclass['grade'])){
					$examparam['grade'] = $myclass['grade'];
					$examparam['district'] = $myclass['district'];
				}
                $count = $exammodel->getExamcountByMemberid($examparam);
            } else if ($roominfo['isschool'] == 2) {
                $count = $exammodel->getnewexamcountbytime($roominfo['crid'],$user['uid'],$subtime);
            }
        } else if($type == 2) { //新课件
            $coursemodel = $this->model('Courseware');
            $callback = $this->input->get('callback');
			$folderids = $this->input->post('folderids');
			if (!empty($callback) || !isset($folderids)){
				$folderids = $this->_getfolderids();
			}
            $count = $coursemodel->getnewcourselistcount(array('crid'=>$roominfo['crid'],'subtime'=>$subtime,'folderids'=>$folderids));
        } else if($type == 780) { //直播课
            $onlinemodel = $this->model('Onlinecourse');
            $count = $onlinemodel->getnewcourselistcount(array('crid'=>$roominfo['crid'],'subtime'=>$subtime));
        } else if($type == 4) { //最新答疑
            $askmodel = $this->model('Askquestion');
			//数量先获取缓存
			$count = $userstatelib->getCache_count($crid,$uid,$type);
			if($count === FALSE){
				$count = $askmodel->getnewaskcountbytime($roominfo['crid'],$subtime);
				$userstatelib->setCache_count($crid,$uid,$type,$count);
			}
        } else if($type == 5){ //通知
            $noticemodel = $this->model('Notice');
            if(empty($subtime)){
                $subtime = strtotime('1970');
            }
            $count = $noticemodel->getNewNoticeCountByTime($roominfo['crid'],$subtime);
            $statemodel->insert($roominfo['crid'],$user['uid'],$type,time());
        } else if($type == 7) {    //新试卷
            $exammodel = $this->model('Exam');
            if($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
				$examparam = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'subtime'=>$subtime,'type'=>1);
				if(!empty($myclass['classid']))
					$examparam['classid'] = $myclass['classid'];
				if(!empty($myclass['grade']))
					$examparam['grade'] = $myclass['grade'];
                $count = $exammodel->getExamListCountByMemberid($examparam);
            } else if ($roominfo['isschool'] == 2) {
                $count = $exammodel->getnewexamcountbytime($roominfo['crid'],$user['uid'],$subtime);
            }
        }else if($type == 8){ //正在进行中的活动
        	$count = $this->getActivitycount();
        }
        return $count;
    }
	
	/*
	//课程下新课件
	*/
	public function folder(){
        $roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$folderids = $this->input->post('folderids');
		if (empty($folderids) || empty($user)) {
			echo json_encode(array());
			exit;
		}
        $statemodel = $this->model('Userstate');
		$foldermodel = $this->model('folder');
        $subtime = $statemodel->getfoldersubtime(array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'typeid'=>6,'folderids'=>$folderids));
		$foldersubtime = array();
		foreach($subtime as $s){
			$foldersubtime[$s['folderid']] = $s['subtime'];
		}
		// var_dump($foldersubtime);
		$folders = explode(',',$folderids);
		foreach($folders as $folderid){
			if(!empty($foldersubtime[$folderid]))
				$fsarr[$folderid] = $foldersubtime[$folderid];
			else
				$fsarr[$folderid] = 0;
		}
		// var_dump($folderids);
		$count = $foldermodel->getnewcourselistcount(array('crid'=>$roominfo['crid'],'subtimes'=>$fsarr));
		echo json_encode($count);
		// var_dump($count);
			// foreach(){
			// }
		
	}

	/**
	 * 获取用户的课程编号
	 * @return string 课程编号以,分隔
	 */
	public function _getfolderids() {
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		
		if($roominfo['isschool'] != 7){
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
			$foldermodel = $this->model('Folder');
			$queryarr = parsequery();
			$queryarr['crid'] = $roominfo['crid'];
			if(!empty($myclass['classid']))
				$queryarr['classid'] = $myclass['classid'];
			else{
				return '';
			}
			if(!empty($myclass['grade']))
				$queryarr['grade'] = $myclass['grade'];
			$queryarr['pagesize'] = 100;
			$queryarr['order'] = '  displayorder asc,folderid desc';
			$folders = $foldermodel->getClassFolder($queryarr);
			if(!empty($folders)){
				$folderids = '';
				foreach($folders as $folder){
					$folderids.= $folder['folderid'].',';
				}
				//folderid集合字符串
				$folderids = rtrim($folderids,',');
			
			}
		}elseif($roominfo['isschool'] == 7) {	//收费分成学校，则未开通或已过期的课程，就显示阴影和开通按钮
			$user = Ebh::app()->user->getloginuser();
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
					if($folder['fprice']==0 || isset($mylist[$folder['folderid']])){
						$showpack = true;
						if(empty($folderids))
							$folderids = $folder['folderid'];
						else
							$folderids .= ','.$folder['folderid'];
					}
					else
						unset($folders[$k]['itemlist'][$l]);
				}
				if($showpack == false)
					unset($folders[$k]);
			}
		}

		
		return empty($folderids)?'':$folderids;
	}
	/**
	 * 获得正在进行中的活动
	 */
	public function getActivitycount(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(!empty($user) && !empty($roominfo)){
			$classModel = $this->model('classes');
			$classids = $classModel->getClassidsByUid($roominfo['crid'],$user['uid']);//学生对应的classid
			if($roominfo['isschool'] == 7){
				$foldModel = $this->model('folder');
				$freefold = $foldModel->getfreefolderList($roominfo['crid']);//免费课的folderid
				$permModel = $this->model('Userpermission');
				$perfold = $permModel->getfolderListByUid($roominfo['crid'],$user['uid']);
				$folderlist = array_merge($freefold,$perfold);
			}else{
				$classidstr = '';
				if(!empty($classids)){
					$classidstr = implode(',',$classids);
				}
				$foldlist1 = array();
				$foldlist2 = array();
				$classroom = $classModel->getclassroombyclassid($roominfo['crid'],$classidstr);
					if(!empty($classroom)){
						$grade = '';
						foreach ($classroom as $class) {
							if(!empty($class['grade'])){
								$grade.=$class['grade'].',';
							}
						}
						if(!empty($grade)){
							$grade = rtrim($grade,',');
						}
						
						if(!empty($grade)){
							$foldModel = $this->model('folder');
							$foldlist1 = $foldModel->getfolderListByGrade($roominfo['crid'],$grade);//根据年级获取folderid
						}else{
							$classModel = $this->model('classes');
							$teacherid = $classModel->getteacheridByclassid($classidstr);
							$teacheridstr = '';
							if(!empty($teacherid)){
								foreach ($teacherid as $key => $value) {
								$teacheridstr.=$value['uid'].',';
								}
								$teacheridstr = rtrim($teacheridstr,',');
							}
							$foldModel = $this->model('folder');
							$foldlist2 = $foldModel->getfolderListByuid($roominfo['crid'],$teacheridstr);
						}
				}

				if (is_array($foldlist1) && is_array($foldlist2)) {
					$folderlist = array_merge($foldlist1,$foldlist2);
				} elseif (is_array($foldlist1)) {
					$folderlist = $foldlist1;
				} elseif (is_array($foldlist2)) {
					$folderlist = $foldlist2;
				} else {
					$folderlist = array();
				}

			}	
		}
		$acmodel = $this->model('activity');
		$param = parsequery();
		$page = !empty($param['page'])?$param['page']:1;
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$param['order'] = SYSTIME.'<endtime+86400 desc,pdateline is not null desc,date desc';
		$aclist = $acmodel->getStudentActivity($param);
		if(!empty($aclist)){
		    foreach ($aclist as $key =>$ac) {
		        if($ac['type'] == 1){
		            $cla = array();
		            $cla = explode(',',$ac['tidstr']);
		            $list = $this->getSameArray($cla,$classids);
		            if(empty($list)){
		                unset($aclist[$key]);
		            }
		        }
		        if($ac['type'] == 2){
		            $fld = explode(',',$ac['tidstr']);
		            if(!empty($fld)){
		                foreach ($fld as $k => $value) {
		                    $fld1[$k] = array('folderid'=>$value);
		                }
		                $list = $this->getSameArray($fld1,$folderlist);
		                if(empty($list)){
		                    unset($aclist[$key]);
		                }
		            }
		        }
		    }
		    $aclist1 = array();
		    foreach ($aclist as $acl) {
		        if($acl['endtime'] + 86400 > SYSTIME){
		            $aclist1[] = $acl;
		        }
		    }
		    
		    return count($aclist1);
		}else{
		    return 0;
		}
	}
	/**
         * [getSameArray 获得两个二维数组的交集]
         * @param  [type] $arr1 [description]
         * @param  [type] $arr2 [description]
         * @return [type]       [description]
         */
        private function getSameArray($arr1,$arr2){
        	$nearr = array();
        	if(!is_array($arr1) || !is_array($arr2)){
        		return false;
        	}
        	foreach ($arr1 as $value){  
				    foreach ($arr2 as $val){  
				        if($value==$val){  
				            $nearr[]=$value;  
				        }  
				    }  
				}
				return $nearr;
        }
}
