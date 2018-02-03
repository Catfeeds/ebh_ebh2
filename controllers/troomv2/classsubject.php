<?php
/**
 * 班级课程控制类
 */
class ClasssubjectController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        
    }
	public function index(){
		$this->display('troomv2/classsubject_nav');
	}
    /**
     * 班级课程
     */
    public function courses() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        //获取modulename
        $mnlib = Ebh::app()->lib('Modulename');
        $mnlib->getmodulename($this,array('modulecode'=>'study','tors'=>1,'crid'=>$roominfo['crid']));
        $this->assign('roominfo',$roominfo);
        if($roominfo['property'] == 3){
            $this->display('troomv2/classsubject_enterprise');
            exit;
        }
        //获取请求参数
        $params['pid']      = $this->input->request('pid');
        $params['sid']      = $this->input->request('sid');
        $params['p']        = $this->input->request('p');
        $params['listRows'] = $this->input->request('listRows');
        $params['orderBy']  = $this->input->request('orderBy');


        //是否国土
        if($this->getschoolType() == 2 || $this->getschoolType() == 4){
            $classsubjectmodel = $this->model('Classsubject');
            $page = $this->uri->page;
            $subjectlist = $classsubjectmodel->getsubjectlistbytid($roominfo['crid'],$user['uid']);

            $this->assign('subjectlist', $subjectlist);
            $folderids = '';
            $subjectlistByFolderid = array();
            foreach($subjectlist as $subject){
                $subject['pname'] = '其他课程';
                $subjectlistByFolderid[$subject['folderid']] = $subject;
                $folderids.= $subject['folderid'].',';
            }
            $folderids = rtrim($folderids,',');
            $folderByPid = array();
            if(!empty($folderids)){
                $packagemodel = $this->model('Paypackage');
                $packages = $packagemodel->getPackByFolderid(array('folderids'=>$folderids,'crid'=>$roominfo['crid']));
                // var_dump($packages);
                foreach($packages as $package){
                    if(empty($folderByPid[$package['pid']]))
                        $folderByPid[$package['pid']] = array($package);
                    else
                        $folderByPid[$package['pid']][] = $package;
                    //unset($subjectlistByFolderid[$package['folderid']]);
                }
                sort($subjectlistByFolderid);
                $folderByPid[0] = $subjectlistByFolderid;
            }
            //重新排列课程数组下标  从0开始
            foreach($folderByPid as $ks =>$folderArr){
                $nArr = array();
                if(!empty($folderArr)){
                    foreach($folderArr as $itemArr){
                        $nArr[] = $itemArr;
                    }
                    $folderByPid[$ks] = $nArr;
                }else{
                    unset($folderByPid[$ks]);
                }
            }
            $this->assign('folderbypid',$folderByPid);
            $this->assign('school_type',$this->getschoolType());
            //var_dump($folderByPid);exit;
            $this->display('troomv2/classsubject');
            exit;
        }
        $this->apiServer    = Ebh::app()->getApiServer('ebh');//获取ebhservie对象
        $params['crid']     = $roominfo['crid'];
        $params['uid']      = $user['uid'];
        $folderByPid = $this->apiServer
            ->reSetting()
            ->setService('CourseService.Course.getCourseClass')
            ->addParams($params)
            ->request();
        if($params['pid'] == 0){
            if($folderByPid){
                $temp          = reset($folderByPid);
                $params['pid'] = $temp['pid'];
            }
        }
        $subjectlist                = $this->apiServer
            ->reSetting()
            ->setService('CourseService.Course.teacherCourseList')
            ->addParams($params)
            ->request();

        $subjectlist = isset($subjectlist['list'])?$subjectlist['list']:array();
        if($subjectlist){//有课程处理方式

            $folderids = array_column($subjectlist,'folderid');
            $dataf['folderids'] = implode(',',$folderids);

            $dataf['folderid'] = $dataf['folderids'];
            $dataf['crid']       = $roominfo['crid'];
            $cwlengthlist                = $this->apiServer
                ->reSetting()
                ->setService('Aroomv3.Course.cwlengthCountToFolderid')
                ->addParams($dataf)
                ->request();

            $reviewcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.reviewCount')->addParams($dataf)->request();
            $zancountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.zanCount')->addParams($dataf)->request();
            $studylist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyList')->addParams($dataf)->request();
            foreach ($subjectlist as &$item) {

                $item['fabulous']   = isset($zancountlist[$item['folderid']]) ? $zancountlist[$item['folderid']]['count'] : 0;
                $item['comment']    = isset($reviewcountlist[$item['folderid']]) ? $reviewcountlist[$item['folderid']]['count'] : 0;
                $item['popularity'] = isset($studylist[$item['folderid']]) ? $studylist[$item['folderid']]['count'] : 0;
                $item['timeLength'] = isset($cwlengthlist[$item['folderid']]) ? $cwlengthlist[$item['folderid']]['count'] : 0;

            }

         
            //排序处理
            switch ($params['orderBy']){
                case 1:
                    $params['orderBy'] = array('credit','SORT_DESC');
                    break;
                case 2:
                    $params['orderBy'] = array('credit','SORT_ASC');
                    break;
                case 3:
                    $params['orderBy'] = array('timeLength','SORT_DESC');

                    break;
                case 4:
                    $params['orderBy'] = array('timeLength','SORT_ASC');
                    break;
                case 5:
                    $params['orderBy'] = array('popularity','SORT_DESC');
                    break;
                case 6:
                    $params['orderBy'] = array('popularity','SORT_ASC');
                    break;
                case 7:
                    $params['orderBy'] = array('fabulous','SORT_DESC');
                    break;
                case 8:
                    $params['orderBy'] = array('fabulous','SORT_ASC');
                    break;
                case 9:
                    $params['orderBy'] = array('comment','SORT_DESC');
                    break;
                case 10:
                    $params['orderBy'] = array('comment','SORT_ASC');
                    break;
                case 11:
                    $params['orderBy'] = array('price','SORT_DESC');
                    break;
                case 12:
                    $params['orderBy'] = array('price','SORT_ASC');
                    break;
                case 13:
                    $params['orderBy'] = array('number','SORT_DESC');
                    break;
                case 14:
                    $params['orderBy'] = array('number', 'SORT_ASC');
                    break;
            }
            if (is_array($params['orderBy']) && $subjectlist)
                $subjectlist = arraySequence($subjectlist, $params['orderBy'][0], $params['orderBy'][1]);
        }
        foreach ($subjectlist as &$item) {
            $item['timeLength'] = getTimeToString($item['timeLength']);
        }
        $this->assign('subjectlist', $subjectlist);
        $this->assign('folderbypid', $folderByPid);
        $this->display('troomv2/classsubject');
    }
	/**
	*班级课程详情页（课件列表）
	*/
    public function view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$foldermodel = $this->model('folder');
		$other_config = Ebh::app()->getConfig()->load('othersetting');
		$other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
		$other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
		$is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
		$is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
		$folder = $foldermodel->getfolderbyid($folderid);
		if(!in_array($folder['power'],array(0,1))){
			show_404();
			exit;
		}
		if($folder['crid'] != $roominfo['crid']){//不是本校的课程
			$item = $this->model('payitem')->getLastItemByFolderid($folderid,$roominfo['crid']);
			if(empty($item)){//也不是本校的服务项
				$this->assign('nopermission',true);
			}
		}
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		if(in_array($roominfo['crid'],$cridarr['noteacher']))
			$this->assign('needsubfolder',false);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		if(empty($roominfo['checktype'])){
			$queryarr['status'] = '1';
		}else{
			$queryarr['status'] = '0,1,-2';
		}
		//教师只显示自己发布的课件
		$otherset = Ebh::app()->getApiServer('ebh')->reSetting()
        ->setService('Aroomv3.Room.othersetting')
        ->addParams(array('crid'=>$roominfo['crid']))->request();
		if(!empty($otherset['cwlistonlyself'])){
			$queryarr['uid'] = $user['uid'];
			
		}
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        if($is_zjdlr){//国土资源厅课件列表显示的讲课人处理
        	$cwarr = array();
        	if(!empty($courses)){
        		foreach ($courses as $c) {
        			$cwarr[] = $c['cwid'];
        		}
        		$cwuserlist = $coursemodel->getcwuserlist($cwarr);
        		if(!empty($cwuserlist)){
        			foreach ($courses as &$cu) {
        				foreach ($cwuserlist as $cwulist) {
        					if($cwulist['cwid'] == $cu['cwid']){
        						$cu['cwuid'] = $cwulist['uid'];
        						$cu['cwface'] = $cwulist['face'];
        						$cu['cwgroupid'] = $cwulist['groupid'];
        						$cu['cwusername'] = $cwulist['username'];
        						$cu['cwsex'] = $cwulist['sex'];
        						$cu['cwrealname'] = $cwulist['realname'];
        						$cu['cwtoid'] = $cwulist['toid'];
        					}
        				}
        			}
        		}
        	}
        }
        $pagestr = show_page($count);
        $sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
		$cwids = '';
        foreach($courses as $course) {
			$cwids .= $course['cwid'].',';
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			if(!empty($course['cwpay']))
				$course['paytime'] = !empty($course['cmonth'])?($course['cmonth'].'个月'):($course['cday'].'日');
			$viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
			if(!empty($viewnum))
				$course['viewnum'] = $viewnum;
            $sectionlist[$course['sid']][] = $course;


        }
		foreach($sectionlist as $k=>$section){
			$queryarr['sid'] = $k;
			$sectioncount = $coursemodel->getfolderseccoursecount($queryarr);
			$sectionlist[$k][0]['sectioncount'] = $sectioncount;
		}
        //学习进度
        if($roominfo['isschool'] == 7){
			$uidstr = '';
			if($folder['isschoolfree']==1 || $folder['fprice'] == 0){//免费
				if(empty($folder['grade'])){
					$grade = -1;
				}else{
					$grade = $folder['grade'];
				}
				$classmodel = $this->model('Classes');
				$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade);
				if(!empty($userlist)){
					foreach($userlist as $uiditem) {
						if(empty($uidstr)) {
							$uidstr = $uiditem['uid'];
						} else {
							$uidstr .= ','.$uiditem['uid'];
						}
					}
					$userscount = count($userlist);//总人数
				}
			}else{
				$upmodel = $this->model('Userpermission');
				$uidlist = $upmodel->getUserIdListByFolder($folderid);
				if(!empty($uidlist)) {
					foreach($uidlist as $uiditem) {
						if(empty($uidstr)) {
							$uidstr = $uiditem['uid'];
						} else {
							$uidstr .= ','.$uiditem['uid'];
						}
					}
					$userlist = $upmodel->getUserAndClassListByUidStr($roominfo['crid'],$folderid,$uidstr,''	);
					$userscount = count($userlist);
				}
			}
		}else{
			$grade = $folder['grade'];
			$classmodel = $this->model('Classes');
			if(!empty($grade)) {//按年级
				$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade);
				
			}else{//按班级
				$classlist = $classmodel->getTeacherClassList($roominfo['crid'],$folder['uid']);
				$classids = '';
				foreach ($classlist as $c) {
					$classids .= $c['classid'].',';
				}
				$classids = rtrim($classids,',');
				$userlist = $classmodel->getClassStudentList(array('classidlist'=>$classids,'limit'=>1000));
			
			}
			if(!empty($userlist)){
				foreach($userlist as $uiditem) {
					if(empty($uidstr)) {
						$uidstr = $uiditem['uid'];
					} else {
						$uidstr .= ','.$uiditem['uid'];
					}
				}
			}
			$userscount = count($userlist);
		}
		$cwids = rtrim($cwids,',');
		$plmodel = $this->model('Playlog');
		// var_dump($cwids);
		if(!empty($cwids) && !empty($uidstr)){
			$playloglist = $plmodel->getCWStudynumByUidStr(array('cwids'=>$cwids,'uids'=>$uidstr));
			$playlogarr = array();
			foreach($playloglist as $log){
				$playlogarr[$log['cwid']] = $log['count'];
			}
			
			foreach($sectionlist as &$v){
				foreach($v as &$value){
					$logcount = empty($playlogarr[$value['cwid']])?0:$playlogarr[$value['cwid']];
					$studynum = min(100,empty($logcount)?0:ceil($logcount/$userscount*100));
					$value['studynum'] = $studynum;
				}	
			}
		}

		//新作业权限
		$exampower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($exampower) {
			$this->assign('exampower',1);
		} else {
			$this->assign('exampower',0);
		}
		if (!empty($queryarr['q']))
			$this->assign('q',$queryarr['q']);
		$this->assign('iszjdlr',$is_zjdlr);
		$this->assign('isnewzjdlr',$is_newzjdlr);
        $this->assign('sectionlist', $sectionlist);
        $this->assign('page', $pagestr);
        //分配folderid
        $this->assign('folderid',$folderid);
        //分配教室信息
        $this->assign('roominfo',$roominfo);
        //分配作业信息
        
        //检测是否有发布直播权限
		$ammodel = $this->model('appmodule');
		$live = $ammodel->getstudentmodule(array('crid'=>$roominfo['crid'],'modulecode'=>'live','limit'=>1,'tors'=>'1','showmode'=>1));
		$live = empty($live[0]) ? array() : $live[0];
		$this->assign('live',$live);
        $this->assign('haslive',!empty($live));
        //二维码生成配置
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $qrcodeconf = !empty($upconfig['qrcode']['server'][0]) ? $upconfig['qrcode']['server'][0] :'http://up.ebh.net/qrcode.html';
        $this->assign('qrcodeconf',$qrcodeconf);
        $this->display('troomv2/classsubject_view_new');
    }

	
	/*
	某一天的课件
	*/
	public function daycourse(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$coursemodel = $this->model('Courseware');
		
		$cwdate = $this->input->get('d');
        $queryarr = parsequery();
		if(!empty($cwdate)) {	
			$cwtime = strtotime($cwdate);
			if($cwtime !== FALSE) {
				$queryarr['startDate'] = $cwtime;
				$queryarr['endDate'] = $cwtime + 86400;
			} else {
				$cwdate = '';
			}
		}
        $queryarr['uid'] = $user['uid'];
		$queryarr['limit'] = 1000;
		$queryarr['status'] = '0,1,-2';
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['power'] = '0,1';
        $courses = $coursemodel->getfolderseccourselist($queryarr);
		// $this->assign('');
		// var_dump($queryarr);
		$sectionlist = array();
		foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		$this->assign('roominfo',$roominfo);
        $this->assign('sectionlist', $sectionlist);
		$this->display('troomv2/daycourse');
	}
	
	/*
	设置定时发布
	*/
	public function setcwtiming(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cwmodel = $this->model('courseware');
		$submitat = $this->input->post('submitat');
		$endat = $this->input->post('endat');
		$cwid = $this->input->post('cwid');
		$param['submitat'] = strtotime($submitat);
		if($param['submitat'] == 0 ){
			$simplecw = $cwmodel->getSimplecourseByCwid($cwid);
			$param['truedateline'] = $simplecw['dateline'];
		}else{
			$param['truedateline'] = $param['submitat'];
		}
		$param['endat'] = strtotime($endat);
		$where['cwid'] = $cwid;
		
		$where['crid'] = $roominfo['crid'];
		
		echo $cwmodel->update($param,$where);
	}
	
	public function moveup(){
		$cwid = $this->input->post('cwid');
		$cwmodel = $this->model('courseware');
		$res = $cwmodel->moveit(array('cwid'=>$cwid,'compare'=>'<','order'=>'cdisplayorder desc'));
		if($res)
			echo 1;
		else
			echo 0;
	}
	public function movedown(){
		$cwid = $this->input->post('cwid');
		$cwmodel = $this->model('courseware');
		$res = $cwmodel->moveit(array('cwid'=>$cwid,'compare'=>'>','order'=>'cdisplayorder asc'));
		if($res)
			echo 1;
		else
			echo 0;
	}

	/**
	 * 获取审核详情
	 */
	public function getcheckdetail() {
		$param['toid'] = $this->input->post('toid');
		$param['type'] = 1;//课件
		$checkdetail = $this->model('billchecks')->getCheckDetail($param);
		if ($checkdetail)
		{
			$result['code'] = 1;
			if ($checkdetail['teach_status'] == 1)
				$result['teach_status'] = '已通过';
			elseif ($checkdetail['teach_status'] == 2)
				$result['teach_status'] = '未通过';
			$result['teach_remark'] = $checkdetail['teach_remark'];
			$result['teach_dateline'] = date("Y-m-d H:i:s", $checkdetail['teach_dateline']);
			echo json_encode($result);
		}
		else
		{
			echo json_encode(array('code' => 0));
		}
	}
	
	/*
	课程统计分析,所有课程
	*/
	public function coursecount(){
		$roominfo = Ebh::app()->room->getcurroom();
		$rcmodel = $this->model('roomcourse');
		
		$livecount = $rcmodel->getRoomcourseCount(array('crid'=>$roominfo['crid'],'islive'=>1));//直播课
		$attcount = $rcmodel->getRoomcourseCount(array('crid'=>$roominfo['crid'],'isatt'=>1));//附件课
		$allcount = $rcmodel->getRoomcourseCount(array('crid'=>$roominfo['crid']));//全部
		$flvcount['count'] = $allcount['count'] - $livecount['count'] - $attcount['count'];
		$this->assign('countset',array('livecount'=>$livecount['count'],'attcount'=>$attcount['count'],'flvcount'=>$flvcount['count']));
		
		
		$this->display('troomv2/coursecount');
	}
	
	/*
	单课程统计分析,课件
	*/
	public function coursecount_cw(){
		$folderid = $this->input->get('folderid');
		$this->assign('folderid',$folderid);
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
		$roominfo = Ebh::app()->room->getcurroom();
		$rcmodel = $this->model('roomcourse');
		$livecount = $rcmodel->getRoomcourseCount(array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'islive'=>1));//直播课
		$attcount = $rcmodel->getRoomcourseCount(array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'isatt'=>1));//附件课
		$allcount = $rcmodel->getRoomcourseCount(array('crid'=>$roominfo['crid'],'folderid'=>$folderid));//全部
		$cwlengthsum = $allcount['lengthsum'];
		$flvcount['count'] = $allcount['count'] - $livecount['count'] - $attcount['count'];
		$this->assign('countset',
					array(
							'livecount'=>$livecount['count'],
							'attcount'=>$attcount['count'],
							'flvcount'=>$flvcount['count'],
							'allcount'=>$allcount['count'],
							'alllength'=>$cwlengthsum
						)
					);
		
		
		
		//课件人气
		$viewnumlist = $rcmodel->getCwviewnumList(array('crid'=>$roominfo['crid'],'folderid'=>$folderid));
		$redis = Ebh::app()->getCache('cache_redis');
		$maxviewnum = -1;
		$minviewnum = 9999999;
		if(!empty($viewnumlist)){
			foreach($viewnumlist as $k=>&$cw){
				$viewnum = $redis->hget('coursewareviewnum',$cw['cwid']);
				$cw['viewnum'] = max(empty($viewnum)?0:$viewnum,$cw['viewnum']);
				if($cw['viewnum']>$maxviewnum){
					$maxviewnum = $cw['viewnum'];
					$maxindex = $k;
				}
				if($cw['viewnum']<$minviewnum){
					$minviewnum = $cw['viewnum'];
					$minindex = $k;
				}
			}
		}
		
		$this->assign('maxviewnum',$viewnumlist[$maxindex]);
		$this->assign('minviewnum',$viewnumlist[$minindex]);
		$this->assign('roominfo',$roominfo);
		$this->display('troomv2/coursecount_cw');
	}
	
	/*
	课程,作业统计
	*/
	public function coursecount_exam(){
		$folderid = $this->input->get('folderid');
		$this->assign('folderid',$folderid);
		$foldermodel = $this->model('folder');
		
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo',$roominfo);
		$page = $this->input->get('page');
		$pagesize = 15;

		$exampower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($exampower) {//判断有没有开通新的作业，新作业操作
			$folder = $foldermodel->getfolderbyid($folderid);
			$this->assign('folder',$folder);
			$this->display('troomv2/coursecount_examv2');
		} else {//老作业的操作
			$rcmodel = $this->model('roomcourse');
			$examcount = $rcmodel->getFolderExamCount(array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'type'=>0));
			$this->assign('examcount',$examcount);
			$examlist = $rcmodel->getFolderExamList(array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'type'=>0,'page'=>$page,'pagesize'=>$pagesize));
			$eidstr = '';
			foreach($examlist as $exam){
				$eidstr .= $exam['eid'].',';
			}
			
			if(!empty($eidstr)){//有作业
				$eidstr = rtrim($eidstr,',');
				$percentlist = $rcmodel->getScorePercentByeid($eidstr);
				if(!empty($percentlist)){//有学生做作业
					$maxpercent = -1;
					$minpercent = 999;
					foreach($percentlist as $k=>$pl){
						$percent = round($pl['percent'],2)*100;
						$pl['percent'] = $percent;
						if($percent>$maxpercent){
							$maxpercent = $percent;
							$maxeid = $pl['eid'];
						}
						if($percent<$minpercent){
							$minpercent = $percent;
							$mineid = $pl['eid'];
						}
						$percentarr[$pl['eid']] = $pl;
					}
					
					// $this->assign('maxpercent',$percentlist[$maxindex]);
					// $this->assign('minpercent',$percentlist[$minindex]);
				}
				
				//没人做的作业补0
				foreach($examlist as $el){
					$eid = $el['eid'];
					if(empty($percentarr[$eid])){
						$mineid = $eid;
						$el['percent'] = 0;
						$percentarr[$eid] = $el;
						if(empty($maxeid))
							$maxeid = $eid;
					}
				}
				
			}
			if($page){
				echo json_encode(array('count'=>$examcount,'percentarr'=>$percentarr));
			}else{
				$this->assign('percentarr',$percentarr);
				$this->assign('mineid',$mineid);
				$this->assign('maxeid',$maxeid);
				$folder = $foldermodel->getfolderbyid($folderid);
				$this->assign('folder',$folder);
				$this->display('troomv2/coursecount_exam');
			}
		}
	}
	/*
	课程,答疑统计
	*/
	public function coursecount_ask(){
		$folderid = $this->input->get('folderid');
		
		$date = $this->input->get('date');
		$bywhat = $this->input->get('bywhat');
		
		$rcmodel = $this->model('roomcourse');
		if(!empty($date)){//ajax部分
			$param['folderid'] = $folderid;
			$param['startdate'] = $date;
			$param['enddate'] = strtotime('+1 '.$bywhat,$date);
			$param['mdstr'] = $bywhat=='month'?",DATE_FORMAT(FROM_UNIXTIME(dateline) ,'%e') as $bywhat":",DATE_FORMAT(FROM_UNIXTIME(dateline) ,'%c') as $bywhat";
			$param['order'] = "$bywhat";
			$param['group'] = "$bywhat";
			$askcount = $rcmodel->getFolderAskCount($param);//提问数按月or日分组
			$param['mdstr'] = $bywhat=='month'?",DATE_FORMAT(FROM_UNIXTIME(a.dateline) ,'%e') as $bywhat":",DATE_FORMAT(FROM_UNIXTIME(a.dateline) ,'%c') as $bywhat";
			$answercount = $rcmodel->getFolderAnswerCount($param);//回答数按月or日分组
			$askarr = array();
			$answerarr = array();
			foreach($askcount as $ask){
				$askarr[$ask[$bywhat]] = intval($ask['count']);
			}
			foreach($answercount as $answer){
				$answerarr[$answer[$bywhat]] = intval($answer['count']);
			}
			
			if($bywhat == 'year'){//按年查看
				$catarr = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
				for($i=1;$i<=12;$i++){
					if(empty($askarr[$i]))
						$askarr[$i] = 0;
					if(empty($answerarr[$i]))
						$answerarr[$i] = 0;
				}
			}else{//按月查看
				$days = Date('t', mktime(0,0,0,Date('m',$date),1,Date('Y',$date)));
				// cal_days_in_month(CAL_GREGORIAN,Date('m',$date),Date('Y',$date));
				for($i=1;$i<=$days;$i++){
					if(empty($askarr[$i]))
						$askarr[$i] = 0;
					if(empty($answerarr[$i]))
						$answerarr[$i] = 0;
					$catarr[] = "$i";
				}
			}
			ksort($askarr);
			ksort($answerarr);
			// var_dump($catarr);
			echo json_encode(
					array('cats'=>$catarr,
							'datas'=>array(
								'ask'=>array_values($askarr),
								'answer'=>array_values($answerarr)
								)
						)
				);
			// var_dump($answerarr);
		}else{
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($folderid);
			$this->assign('folder',$folder);
			$roominfo = Ebh::app()->room->getcurroom();
			$askcount = $rcmodel->getFolderAskCount(array('folderid'=>$folderid));
			$answercount = $rcmodel->getFolderAnswerCount(array('folderid'=>$folderid));
			$this->assign('roominfo',$roominfo);
			$this->assign('askcount',$askcount);
			$this->assign('answercount',$answercount);
			$this->assign('folderid',$folderid);
			$this->display('troomv2/coursecount_ask');
		}
		
	}
	
	/*
	学分统计
	*/
	public function coursecount_credit(){
		$folderid = $this->input->get('folderid');
		$folder = $this->model('folder')->getfolderbyid($folderid);
		$classid = $this->input->get('classid');
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['property'] != 3 || empty($classid) || empty($folder)){
			exit;
		}
		$param['classid'] = $classid;
		$param['crid'] = $roominfo['crid'];
		$list = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Enterprise.subDepartment')->addParams($param)->request();
		$userscount = 0;
		$userlist = array();
		$totalcredit = 0;
		if($list !== FALSE){
			$classidarr = array_column($list,'classid');
			$classidarr[] = $classid;//加上本部门
			$classids = implode(',',$classidarr);
			$param['classids'] = $classids;
			$userlist = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Enterprise.subDeptUsers')->addParams($param)->request();
			$uidstr = implode(',',array_column($userlist,'uid'));
			$userscount = count($userlist);
		
		}
		if(!empty($folder['credit']) && !empty($uidstr)){
			if($folder['creditmode'] == 0){//按比例,暂时不计作业,即课件占比100%
				$cwcount = $this->model('courseware')->getfolderseccoursecount(array('folderid'=>$folderid,'status'=>1,'ism3u8'=>1));
				$playloglist = $this->model('playlog')->getFolderFinishedByUidStr(array('folderid'=>$folderid,'uidstr'=>$uidstr));
				// var_dump($playloglist);
			} else {//按累计时长
				$playloglist = $this->model('playlog')->getFolderStudyByUidStr(array('folderid'=>$folderid,'uidstr'=>$uidstr));
				$creditarr = array();
				$usernamearr = array();
			}
		}
		foreach($userlist as $k=>&$user){
			$uid = $user['uid'];
			if($folder['creditmode'] == 0){
				$user['foldercredit'] = empty($playloglist[$uid])||empty($cwcount)?0:($playloglist[$uid]['count']/$cwcount*$folder['credit']);
			} else {
				$user['foldercredit'] = empty($playloglist[$uid]) || empty($folder['credittime'])?0:($playloglist[$uid]['ltime']/$folder['credittime']*$folder['credit']);
			}
			$user['foldercredit'] = $user['foldercredit']>$folder['credit']?$folder['credit']:round($user['foldercredit'],2);
			$totalcredit += $user['foldercredit'];
			$creditarr[$k] = $user['foldercredit'];
			$usernamearr[$k] = $user['username'];
		}
		array_multisort($creditarr, SORT_DESC, $usernamearr , SORT_ASC , $userlist);
		$this->assign('totalcredit',$totalcredit);
		$this->assign('userlist',$userlist);
		$this->assign('userscount',$userscount);
		$this->assign('roominfo',$roominfo);
		$this->assign('folderid',$folderid);
		$this->assign('folder',$folder);
		$this->display('troomv2/coursecount_credit');
	}
	/*
	课程,互动统计,
	//////////////////////////暂无
	
	public function coursecount_iclass(){
		$folderid = $this->input->get('folderid');
		
		$rcmodel = $this->model('roomcourse');
		$year = $this->input->get('y');
		if(!empty($year)){
			
		}else{
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($folderid);
			$this->assign('folder',$folder);
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('folderid',$folderid);
			// $rcmodel->getFolderIclassroom();
		}
		
		$this->display('troomv2/coursecount_iclass');
		
	}*/

	/**
	 *设置网校的课件的试听时长
	 */
	public function setcwLooktime() {
		$init = intval($this->input->post('init'));
		$cwid = intval($this->input->post('cwid'));
		$looktime = intval($this->input->post('looktime'));
		$data = array();//返回给前端的数据
		if (!$cwid) {
			$code = -1;
			$msg = 'no cwid input';
		} else if (!$init) {//不存在就是添加
			$roominfo = Ebh::app()->room->getcurroom();
			$cwmodel = $this->model('courseware');
			$param['looktime'] = $looktime;
			$where['cwid'] = $cwid;
			$where['crid'] = $roominfo['crid'];
			if ($cwmodel->update($param,$where)) {
				$code = 1;
				$msg = 'success';
				$data = array('update' => 1);
			} else {
				$code = 0;
				$msg = 'failed';
				$data = array('update' => -1);
			}
		} else {
			$data = $this->model('courseware')->getSimpleInfoByCwid($cwid);
			if ($data) {
			 	$code = 1;
				$msg = 'success';
			} else {
				$code = -5;
				$msg = 'no data';
			}	
		}
		$this->outJson($code, $msg, $data);
	}

	/**
	 *输出接口封装函数
	 *@param int   $code 输出的code
	 *@param str   $msg  提示信息
	 *@param array $data 数据
	 *@param int   $exit 是否退出 
	 */
	public function outJson($code=0,$msg='',$data=array(),$exit=0) {
		echo json_encode(array('code'=>$code,'msg'=>$msg,'data'=>$data));
		if ($exit)
			exit;
	}

    /**
     * @describe:教师授课-学生排名
     * @User:tzq
     * @Date:2017/11/27
     * @param int $folderid 课程id
     * @return
     */
	public function studentRanking()
    {
        $params['folderid'] = $this->input->request('folderid');
        $params['orderBy']  = $this->input->request('orderBy');
        $params['school_type'] = $this->getschoolType();
        $roominfo = Ebh::app()->room->getcurroom();
        $params['crid']     = $roominfo['crid'];
        if (0 >= $params['folderid']) {
            renderjson(1, '课程id参数错误');
        }
        $this->apiServer = Ebh::app()->getApiServer('ebh');//获取ebhservie对象

        $ret = $this->apiServer
            ->reSetting()
            ->setService('CourseService.Course.getCreditSore')
            ->addParams($params)
            ->request();
        if ($ret === false) {

            renderjson(1, '缺少必须的参数!');
        } else if (is_string($ret)) {
            renderjson(1, $ret);
        } else {
            renderjson(0, '教师授课-学生排名列表', $ret);
        }
    }

    /**
     * @describe:教师授课-文件统计
     * @User:tzq
     * @Date:2017/11/27
     * @param int $folderid 课程id
     * @return
     */
    public function fileCount(){
        $params['folderid'] = intval($this->input->request('folderid'));
        $roominfo           = Ebh::app()->room->getcurroom();
        $params['crid']     = $roominfo['crid'];
        //log_message(json_encode($params));
        if (0 >= $params['folderid']) {
            $this->renderjson(1, '课程id参数不正确');
        }
        $this->apiServer = Ebh::app()->getApiServer('ebh');//获取ebhservie对象
        $ret             = $this->apiServer
            ->reSetting()
            ->setService('Aroomv3.Course.fileCount')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            renderjson(1, 'Api接口繁忙!');
        } else {
            renderjson(0, '查询成功', $ret);
        }
//        $roominfo        = Ebh::app()->room->getcurroom();
//        $params['folderid'] = $this->input->request('folderid');
//        $params['crid']     = $roominfo['crid'];
//        if (0 >= $params['folderid']) {
//            renderjson(1, '课程id参数错误');
//        }
//        $this->apiServer = Ebh::app()->getApiServer('ebh');//获取ebhservie对象
//
//        $ret = $this->apiServer
//            ->reSetting()
//            ->setService('CourseService.Course.getFileCount')
//            ->addParams($params)
//            ->request();
//        if ($ret === false) {
//
//            renderjson(1, '缺少必须的参数!');
//        } else if (is_string($ret)) {
//            renderjson(1, $ret);
//        } else {
//            $dataf['folderids'] = $params['folderid'];
//            $dataf['folderid']  = $dataf['folderids'];
//            $dataf['crid']      = $roominfo['crid'];
//            $reviewcountlist    = $this->apiServer->reSetting()->setService('Aroomv3.Course.reviewCount')->addParams($dataf)->request();
//            $zancountlist       = $this->apiServer->reSetting()->setService('Aroomv3.Course.zanCount')->addParams($dataf)->request();
//            $studylist          = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyList')->addParams($dataf)->request();
//            $ret['zan']         = isset($zancountlist[$params['folderid']]) ? $zancountlist[$params['folderid']]['count'] : 0;
//            $ret['reNum']       = isset($reviewcountlist[$params['folderid']]) ? $reviewcountlist[$params['folderid']]['count'] : 0;
//            $ret['creditNum']   = isset($studylist[$params['folderid']]) ? $studylist[$params['folderid']]['count'] : 0;
//            renderjson(0, '教师授课-文件统计', $ret);
//        }
    }

    /**
     * @describe:教师授课-文件统计
     * @User:tzq
     * @Date:2017/11/28
     */
    public function classsubjectStat(){

        $this->display('troomv2/classsubject_stat');
    }

    /**
     * @describe:教师授课-学生排名
     * @User:tzq
     * @Date:2017/11/28
     */
    public function classsubjectRank(){
        $this->display('troomv2/classsubject_rank');
    }

    /**
     * @describe:获取网校类型
     * @User:tzq
     * @Date:2017/12/5
     * @return int
     */
    private function getschoolType(){
        $roominfo = Ebh::app()->room->getcurroom();
        $property                 = isset($roominfo['property']) ? $roominfo['property'] : 0;
        $isschool                 = isset($roominfo['isschool']) ? $roominfo['isschool'] : 0;
        $other_config             = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr']    = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr                 = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'], $other_config['newzjdlr']));
        $is_newzjdlr              = in_array($roominfo['crid'], $other_config['newzjdlr']);
        if ($property == 3 && $isschool == 7) {
            $type = 1;//企业版
        } elseif ($is_newzjdlr || $is_zjdlr) {
            $type = 2;//国土版
        } elseif($isschool == 3) {
            $type = 4;//租赁版
        }else{
            $type = 3;//其他版本 教育版或租赁版
        }
        return $type;

    }

    /**
     * @describe:获取课程列表
     * @Author:tzq
     * @Date:2018/01/18
     */
    public function getFolderList(){
        $roominfo          = Ebh::app()->room->getcurroom();
        $user              = Ebh::app()->user->getloginuser();
        $apiServer         = Ebh::app()->getApiServer('ebh');//获取ebhservie对象
        $params['crid']    = $roominfo['crid'];
        $params['uid']     = $user['uid'];
        $params['pid']     = $this->input->request('pid');
        $params['orderBy'] = $this->input->request('orderBy');
        $folderByPid    = $apiServer
            ->reSetting()
            ->setService('CourseService.Course.getCourseClass')
            ->addParams($params)
            ->request();
        if ($params['pid'] == 0) {
            if ($folderByPid) {
                $temp          = reset($folderByPid);
                $params['pid'] = $temp['pid'];
            }
        }
        $subjectlist = $apiServer
            ->reSetting()
            ->setService('CourseService.Course.teacherCourseList')
            ->addParams($params)
            ->request();

        $subjectlist = isset($subjectlist['list']) ? $subjectlist['list'] : array();
        if ($subjectlist) {//有课程处理方式

            $folderids          = array_column($subjectlist, 'folderid');
            $dataf['folderids'] = implode(',', $folderids);

            $dataf['folderid'] = $dataf['folderids'];
            $dataf['crid']     = $roominfo['crid'];
            $cwlengthlist      = $apiServer
                ->reSetting()
                ->setService('Aroomv3.Course.cwlengthCountToFolderid')
                ->addParams($dataf)
                ->request();

            $reviewcountlist = $apiServer->reSetting()->setService('Aroomv3.Course.reviewCount')->addParams($dataf)->request();
            $zancountlist    = $apiServer->reSetting()->setService('Aroomv3.Course.zanCount')->addParams($dataf)->request();
            $studylist       = $apiServer->reSetting()->setService('Aroomv3.Course.studyList')->addParams($dataf)->request();
            foreach ($subjectlist as &$item) {

                $item['fabulous']   = isset($zancountlist[$item['folderid']]) ? $zancountlist[$item['folderid']]['count'] : 0;
                $item['comment']    = isset($reviewcountlist[$item['folderid']]) ? $reviewcountlist[$item['folderid']]['count'] : 0;
                $item['popularity'] = isset($studylist[$item['folderid']]) ? $studylist[$item['folderid']]['count'] : 0;
                $item['timeLength'] = isset($cwlengthlist[$item['folderid']]) ? $cwlengthlist[$item['folderid']]['count'] : 0;

            }
            //排序处理
            switch ($params['orderBy']) {
                case 1:
                    $params['orderBy'] = array('credit', 'SORT_DESC');
                    break;
                case 2:
                    $params['orderBy'] = array('credit', 'SORT_ASC');
                    break;
                case 3:
                    $params['orderBy'] = array('timeLength', 'SORT_DESC');

                    break;
                case 4:
                    $params['orderBy'] = array('timeLength', 'SORT_ASC');
                    break;
                case 5:
                    $params['orderBy'] = array('popularity', 'SORT_DESC');
                    break;
                case 6:
                    $params['orderBy'] = array('popularity', 'SORT_ASC');
                    break;
                case 7:
                    $params['orderBy'] = array('fabulous', 'SORT_DESC');
                    break;
                case 8:
                    $params['orderBy'] = array('fabulous', 'SORT_ASC');
                    break;
                case 9:
                    $params['orderBy'] = array('comment', 'SORT_DESC');
                    break;
                case 10:
                    $params['orderBy'] = array('comment', 'SORT_ASC');
                    break;
                case 11:
                    $params['orderBy'] = array('price', 'SORT_DESC');
                    break;
                case 12:
                    $params['orderBy'] = array('price', 'SORT_ASC');
                    break;
                case 13:
                    $params['orderBy'] = array('number', 'SORT_DESC');
                    break;
                case 14:
                    $params['orderBy'] = array('number', 'SORT_ASC');
                    break;
            }
            if (is_array($params['orderBy']) && $subjectlist)
                $subjectlist = arraySequence($subjectlist, $params['orderBy'][0], $params['orderBy'][1]);
        }
        foreach ($subjectlist as &$item) {
            $item['timeLength'] = getTimeToString($item['timeLength']);
        }
        renderJson(0,'课程列表',$subjectlist);
    }

}
