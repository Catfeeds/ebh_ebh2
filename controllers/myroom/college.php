<?php
class CollegeController extends CControl {
	private $openedcourse = array();//已开通课程
	private $zjdlr_word_folderid = '';//国土非视频课件的课程id
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
       }

	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo', $roominfo);
        $user = Ebh::app()->user->getloginuser();
		$roomcache = Ebh::app()->lib('Roomcache');
        $this->assign('user', $user);
		//班级-课程关联
		$classmodel = $this->model('Classes');
		$classcoursesmodel = $this->model('Classcourses');
		if($roominfo['domain'] == 'lcyhg'){//绿城育华 一个学生可以多个班级
			$needlist = TRUE;
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid'],$needlist);
			$myclassidarr = array_column($myclass,'classid');
			$myclassid = implode($myclassidarr,',');
			$noticeclassid = $myclassidarr[0];
		}else{
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
			$myclassid = empty($myclass['classid']) ? 0 : $myclass['classid'];
			$noticeclassid = $myclassid;
		}	
		
		//获取通知
		$noticeparam = array('crid'=>$roominfo['crid'],'classid'=>$noticeclassid,'ntype'=>'1,3,4,5','limit'=>'0,6','needgrade'=>true,'needdistrict'=>true);
		$notices = $roomcache->getCache($roominfo['crid'],'other',$noticeparam);
		if($notices === FALSE){
			$noticemodel = $this->model('Notice');
			$notices = $noticemodel->getnoticelist($noticeparam);
			$roomcache->setCache($roominfo['crid'],'other',$noticeparam,$notices,120);
		}
		$this->assign('notices', $notices);
		
		
		
		$foldermodel = $this->model('Folder');
		$classcoursesmodel = $this->model('Classcourses');

		if($roominfo['isschool'] != 7){//普通学校课程
			//班级-课程关联
			$classfolderskey = array('name'=>'classfolders','classid'=>$myclassid);
			$classfolders = $roomcache->getCache($roominfo['crid'],'other',$classfolderskey);
			if($classfolders === FALSE){
				$classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
				$roomcache->getCache($roominfo['crid'],'other',$classfolderskey,$classfolders,30);
			}
			$folderids = '';
			$folders  = array();
			if(!empty($classfolders)){//获取课程基础信息
				foreach ($classfolders as $fd){
					$folderids.= $fd['folderid'].',';
				}
				$folderids = rtrim($folderids,',');
				$folderparam = array('limit'=>1000,'folderid'=>$folderids,'needpower'=>true);
				$folders = $roomcache->getCache($roominfo['crid'],'other',$folderparam);
				if($folders === FALSE){
					$folders = $foldermodel->getfolderlist($folderparam);
					$roomcache->setCache($roominfo['crid'],'other',$folderparam,$folders,30);
				}
			}
			//没有班级-课程关联的 按老策略，老师的课程
			if(empty($folderids)){
				$queryarr = parsequery();
				$queryarr['crid'] = $roominfo['crid'];
				
				if(!empty($myclassid))
					$queryarr['classid'] = $myclassid;
				else{
					header('Location:'.geturl('myroom/college/allcourse'));
					exit;
				}
				
				$queryarr['pagesize'] = 6;
				$queryarr['order'] = ' displayorder asc,folderid desc';
				
				if(!empty($myclass['grade'])){
					$queryarr['grade'] = $myclass['grade'];
					$folders = $roomcache->getCache($roominfo['crid'],'other',$queryarr);
					if($folders === FALSE){
						$folders = $foldermodel->getClassFolderWithoutTeacher($queryarr);
						$roomcache->setCache($roominfo['crid'],'other',$queryarr,$folders,30);
					}
				}else{
					$folders = $roomcache->getCache($roominfo['crid'],'other',$queryarr);
					if($folders === FALSE){
						$folders = $foldermodel->getClassFolder($queryarr);
						$roomcache->setCache($roominfo['crid'],'other',$queryarr,$folders,30);
					}
				}
				$folderids = array_column($folders,'folderid');
				if(!is_array($folderids)){
					$folderids = array($folderids);
				}
				$folderids = implode(',',$folderids);
			}
			
		}elseif($roominfo['isschool'] == 7) {	//收费分成学校，则未开通或已过期的课程，就显示阴影和开通按钮
			$splist = array();
			$folderids = '';
			$folders = $this->notopened($roominfo,$user,$splist,$folderids);
			// var_dump($splist)
			// $this->assign('splist',$splist);
		}
		
		
		//调查问卷信息
		$surveys = $this->model('survey')->getSurveyList(array(
			'crid' => $roominfo['crid'],
			'type' => 1,
			'ispublish' => 1,
			'answered' => true,
			'uid' => $user['uid'],
			'limit' => 3
			));
		$this->assign('surveys', $surveys);
		
        $conf = Ebh::app()->getConfig()->load('othersetting');
		$conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
		if(!$is_zjdlr){//除了国土，所有的都用这个啦
			$more = $this->input->get('more');
			$this->getCreditList($user['uid'],$roominfo['crid'],$more);
			$this->newcourse($roominfo,$user);
			$this->assign('more',$more);
			$this->display('college/index_enterprise');
			return;
		}
		
		//单课收费的课件
		if($roominfo['template'] == 'plate' && $roominfo['isschool'] == 7){
			$this->index_mycws();
		}

		if(!empty($folders)){
			//国土改总分逻辑
			$folders = $this->modifyZjdrSchoolScore($folders,$roominfo,$folderids);
			
			//学习信息加入folders数组中
			if($is_zjdlr && !$is_newzjdlr){
				$pmodel = $this->model('progress');
				$param['folderid'] = $folderids;
				
				//课程集合下的视频课件
				$param['limit'] = 10000;
				if(!empty($param['folderid']))
					$coursewarelist = $pmodel->getCWByFolderid($param);
				// var_dump($coursewarelist);
				
				if(!empty($coursewarelist)){//学习信息加入folders数组中
					$this->studyinfo_old($folders,$coursewarelist,$param,$roominfo,$user,$folderids);
				}
			} else {
				$this->studyinfo($folders,$roominfo,$user,$folderids);
			}
		}

		if($is_zjdlr){//国土资源专有
			$this->newcourse_gt($roominfo);
			//积分排名
			$creditmodel = $this->model('credit');
			$ranklist = $creditmodel->getRankList(array('crid'=>$roominfo['crid'],'limit'=>8));
			$this->assign('ranklist',$ranklist);
			//班级排名
			$crankparam = array('crid'=>$roominfo['crid'],'limit'=>8);
			$classranklist = $roomcache->getCache($roominfo['crid'],'other',$crankparam);	//班级积分 临时缓存，不在后台自动做更新
			if (empty($classranklist)) {
				$isAvg = true; // 是否国土资源厅
				$classranklist = $creditmodel->getClassCreditList($crankparam, $isAvg);
				$roomcache->setCache($roominfo['crid'],'other',$crankparam,$classranklist,300);
			}
			$this->assign('classranklist',$classranklist);
		}
		// var_dump($folders);
		
		
		//判断用户是否有购买记录
		$oparr = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'status'=>1);
		$paycount = $this->model("Payorder")->getOrderCount($oparr);
		$this->assign('paycount',$paycount);
		
		$this->assign('folders',$folders);
		$folderids = empty($folderids)?'':$folderids;
		$this->assign('folderids',$folderids);

		if ($is_zjdlr) {
			$reviewmodel = $this->model('Review');
			$reviews = $reviewmodel->getTheLatestReview($roominfo['crid'], 5);
			$this->assign('orireviews', $reviews);
			$reviews = parseEmotion($reviews);
			$this->assign('reviews', $reviews);
            $this->assign('iszjdlr',$is_zjdlr);
            $this->assign('isnewzjdlr',$is_newzjdlr);

			$this->display('college/index_gt');
		}else {
			$this->display('college/index');
		}
		
		debug_info();
	}
	
	public function more(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$rumodel = $this->model('roomuser');
		$roomcount = $rumodel->getroomcount($user['uid']);

		$ammodel = $this->model('appmodule');
        //更多模块
        $modulelist = $ammodel->getmodulelist(array('system'=>1,'limit'=>100,'tors'=>'0,2'), true);
        $custom_modulelist = $ammodel->getRoomSet(array('crid'=>$roominfo['crid'],'order'=>'displayorder','limit'=>100,'tors'=>'0,2'), true);

        if (!empty($custom_modulelist)) {
            foreach ($custom_modulelist as $moduleid => $custom_moduleitem) {
                $modulelist[$moduleid] = $custom_moduleitem;
            }
            unset($custom_modulelist);
        }

        $modulelist = array_filter($modulelist, function($module) {
            return (!isset($module['available']) || !empty($module['available']))
                && !empty($module['ismore']) && empty($module['showmode']);
        });
        if (!empty($modulelist)) {
            //模块排序
            $displayorders = array_column($modulelist, 'displayorder');
            $moduleids = array_keys($modulelist);
            array_multisort($displayorders, SORT_ASC, SORT_NUMERIC,
                $moduleids, SORT_ASC, SORT_NUMERIC, $modulelist);
            unset($displayorders, $moduleids);
            $room_type = Ebh::app()->room->getRoomType();
            $room_type = ($room_type == 'com') ? 1 : 0;
            foreach ($modulelist as &$module){
                if(!empty($room_type)){
                    $module['modulename'] = str_replace('我的班级','我的部门',$module['modulename']);
                    $module['nickname'] = !empty($module['nickname']) ? str_replace('我的班级','我的部门',$module['nickname']) : '';
                    $module['modulename'] = str_replace('我的同学','我的同事',$module['modulename']);
                    $module['nickname'] = !empty($module['nickname']) ? str_replace('我的同学','我的同事',$module['nickname']) : '';
                }
            }
        }

		$this->assign('user',$user);
		$this->assign('modulelist', $modulelist);
		$this->assign('roomcount',$roomcount);
		$this->assign('room',$roominfo);
		$this->display('college/more');
	}
	
	public function study(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$this->getCwpay($roominfo,$user,true);//单课收费的课件
		//获取modulename
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'study','tors'=>0,'crid'=>$roominfo['crid']));
		$foldermodel = $this->model('Folder');
		//全校免费课程
		if($roominfo['isschool'] == 7){
			$schoolfreelist = $foldermodel->getfolderlist(array('crid'=>$roominfo['crid'],'isschoolfree'=>1,'limit'=>1000));
			$rumodel = $this->model('roomuser');
			$userin = $rumodel->getroomuserdetail($roominfo['crid'],$user['uid']);
            //过滤服务项中的课程
            if (!empty($userin) && !empty($schoolfreelist)) {
                $folderid_arr = array_column($schoolfreelist, 'folderid');
                $folderid_arr = $this->model('Payitem')->getItemListByFolderIds($folderid_arr);
                foreach ($schoolfreelist as $k => $item) {
                    if (in_array($item['folderid'], $folderid_arr)) {
                        unset($schoolfreelist[$k]);
                    }
                }
            }
			if(!empty($userin)) {
                $this->assign('userin', $userin);
                $this->assign('schoolfreelist',$schoolfreelist);
            }

            $survey_id = $this->_need_survery($roominfo['crid'], $user);
            $this->assign('survey_id', $survey_id);
		}

		
		$folderids = '';
		$folders = array();
		if($roominfo['isschool'] != 7){
			//班级-课程关联
			$classmodel = $this->model('Classes');
			$classcoursesmodel = $this->model('Classcourses');
			if($roominfo['domain'] == 'lcyhg'){//绿城育华 一个学生可以多个班级
				$needlist = TRUE;
				$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid'],$needlist);
				
				$myclassidarr = array_column($myclass,'classid');
				$myclassid = implode($myclassidarr,',');
				$classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
				
			}else{
				$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
				$myclassid = empty($myclass['classid']) ? 0 : $myclass['classid'];
				$classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
			}
			if(!empty($classfolders)){//获取课程基础信息
				foreach ($classfolders as $fd){
					$folderids.= $fd['folderid'].',';
				}
				$folderids = rtrim($folderids,',');
				$folderparam = array('limit'=>1000,'folderid'=>$folderids,'needpower'=>true);
				$folders = $foldermodel->getfolderlist($folderparam);
			}
			
			//没有关联的，按老策略，老师的课程
			if(empty($folderids)){
				$queryarr = parsequery();
				$queryarr['crid'] = $roominfo['crid'];
				if(!empty($myclassid))
					$queryarr['classid'] = $myclassid;
				else{
					// header('Location:'.geturl('myroom/college/allcourse'));
					// exit;
				}
				
				if(!empty($queryarr['classid'])){
					if(!empty($myclass['grade']))
						$queryarr['grade'] = $myclass['grade'];
					$queryarr['pagesize'] = 1000;
					$queryarr['order'] = '  displayorder asc,folderid desc';
					$folders = $foldermodel->getClassFolder($queryarr);
				}
				$folderids = array_column($folders,'folderid');
				if(!is_array($folderids)){
					$folderids = array($folderids);
				}
				$folderids = implode(',',$folderids);
			}

			//国土改总分逻辑
			$folders = $this->modifyZjdrSchoolScore($folders,$roominfo,$folderids);
		}
		
		if(1) {	//收费分成学校，则未开通或已过期的课程，就显示阴影和开通按钮
			$splist = array();
			$spfolders = $this->notopened($roominfo,$user,$splist,$folderids);
			
			// 遍历出已购买的课程 ID
			$folderidArrr = array();
			if (!empty($spfolders)) {
				foreach ($spfolders as $key => $val) {
					if(!empty($val['itemlist'])) {
						foreach ($val['itemlist'] as $k => $v) {
							if (!empty($v['folderid'])) {
								$folderidArrr[] = $v['folderid'];
							}
						}
					}
					if (!empty($val['folderid'])) {
							$folderidArrr[] = $val['folderid'];
					}
				}
			}

			//学生后台，未购买的课程去掉重复的，已购买的隐藏（逻辑：遍历课程，依次将课程 id 放入到一个数组，如果该课程id数组中已存在则是重复的，删除）
            //可见的未购买服务项
            $vis_items = array();
			if (!empty($splist)) {
				foreach ($splist as $key => $val) {
					if(!empty($val['itemlist'])) {
						foreach ($val['itemlist'] as $k => $v) {
							if (in_array($v['folderid'],$folderidArrr)) {
							    /*if ($roominfo['crid'] != 12859) {
                                    unset($splist[$key]['itemlist'][$k]);
                                }*/
							} else {
								$folderidArrr[] = $v['folderid'];
                                $vis_items[$v['sid']] = $v['sid'];
							}
						}
					}
					if (!empty($val['folderid'])) {
						if (in_array($val['folderid'],$folderidArrr)) {
							unset($splist[$key]);
						} else {
							$folderidArrr[] = $val['folderid'];
                            $vis_items[$v['sid']] = $v['sid'];
						}
					}
				}
			}
			$vis_items = array_filter($vis_items, function($vis_item) {
               return $vis_item > 0;
            });
            $pay_sorts_model = $this->model('Paysort');
            $vis_sorts = $pay_sorts_model->getSortPackedList($vis_items);
			unset($vis_items);
            if (!empty($vis_sorts)) {
                $sid_arr = array_keys($vis_sorts);
                $sort_price_arr = $pay_sorts_model->sortsCountPrice($sid_arr);
                if (!empty($sort_price_arr)) {
                    foreach ($sort_price_arr as $pitem) {
                        if ($pitem['cannotpay'] == 1) {
                            $vis_sorts[$pitem['sid']]['cannotpay'] = 1;
                            continue;
                        }
                        if ($pitem['isschoolfree'] == 0) {
                            if (!isset($vis_sorts[$pitem['sid']]['all_price'])) {
                                $vis_sorts[$pitem['sid']]['all_price'] = 0;
                            }
                            $vis_sorts[$pitem['sid']]['all_price'] += $pitem['iprice'];
                        }
                    }
                }
                $vis_sorts = array_filter($vis_sorts, function($isort) {
                    return isset($isort['all_price']) && $isort['all_price'] > 0 || !empty($isort['cannotpay']);
                });
            }
            if (Ebh::app()->room->getRoomType() == 'edu') {
                $apiServer = Ebh::app()->getApiServer('ebh');
                $classinfo = $apiServer->reSetting()
                    ->setService('Member.User.getStudentClassInfo')
                    ->addParams('crid', $roominfo['crid'])
                    ->addParams('uid', $user['uid'])
                    ->request();
                $classid = $grade = 0;
                if (!empty($classinfo)) {
                    $classid = $classinfo['classid'];
                    $grade = $classinfo['grade'];
                }
                $tfolderids = array();
                foreach ($splist as $group) {
                    if (empty($group['itemlist'])) {
                        continue;
                    }
                    foreach ($group['itemlist'] as $item) {
                        $tfolderids[$item['folderid']] = $item['folderid'];
                    }
                }
                $folderTargets = $apiServer->reSetting()
                    ->setService('Aroomv3.Course.getCourseTargets')
                    ->addParams('crid', $roominfo['crid'])
                    ->addParams('folderids', implode(',', $tfolderids))
                    ->request();
                unset($tfolderids);
                if (!empty($folderTargets)) {
                    $folderTargets = array_filter($folderTargets, function($target) use($grade, $classid) {
                       if (empty($target['targets'])) {
                           return false;
                       }
                       $grade = 0 - $grade;
                       $targets = explode(',', $target['targets']);
                       $targets = array_flip($targets);
                       if (isset($targets[$classid]) || isset($targets[$grade])) {
                           return false;
                       }
                       return true;
                    });
                    $tfolderids = array_keys($folderTargets);
                    if (!empty($tfolderids)) {
                        $tfolderids = array_flip($tfolderids);
                        array_walk($splist, function(&$sp, $index, $tfolderids) {
                            if (empty($sp['itemlist'])) {
                                return;
                            }
                            $len = count($sp['itemlist']);
                            $sp['itemlist'] = array_filter($sp['itemlist'], function($item) use($tfolderids) {
                                return !isset($tfolderids[$item['folderid']]);
                            });

                            if (empty($sp['itemlist'])) {
                                unset($sp['sorts']);
                                return;
                            }
                            if ($len == count($sp['itemlist'])) {
                                return;
                            }
                            $sids = array_column($sp['itemlist'], 'sid');
                            $sids[-1] = -1;
                            $sids = array_flip($sids);

                            $sp['sorts'] = array_intersect_key($sp['sorts'], $sids);
                            $key = key($sp['sorts']);
                            if ($key == -1 && count($sp['sorts']) < 3) {
                                unset($sp['sorts'][$key]);
                                $key = key($sp['sorts']);
                            }
                            if ($key == -1) {
                                next($sp['sorts']);
                                $key = key($sp['sorts']);
                            }
                            $sp['csid'] = $key;
                        }, $tfolderids);
                        $splist = array_filter($splist, function($sp) {
                            return !empty($sp['itemlist']);
                        });
                    }
                }
            }

            $this->assign('vis_sorts', $vis_sorts);
			$this->assign('splist',$splist);
		}
		
		
		$other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);

		//学习进度等
		if(!empty($folders) || !empty($spfolders)){
			//课程集合下的视频课件
			if($is_zjdlr && !$is_newzjdlr){
				$pmodel = $this->model('progress');
				$param['folderid'] = $folderids;
				
				//课程集合下的视频课件
				$param['limit'] = 10000;
				if(!empty($param['folderid']))
					$coursewarelist = $pmodel->getCWByFolderid($param);
				// var_dump($coursewarelist);
				
				if(!empty($coursewarelist)){//学习信息加入folders数组中
					$this->studyinfo_old($folders,$coursewarelist,$param,$roominfo,$user,$folderids,'spfolders',$spfolders);
				}
			} else {
				$this->studyinfo($folders,$roominfo,$user,$folderids,'spfolders',$spfolders);
			}

		}
		$this->newcourse($roominfo,$user);//最新课程
		$this->assign('roominfo',$roominfo);
		$this->_updateuserstate(2);
		$this->assign('folderids',empty($folderids)?'':$folderids);
        $this->assign('folders',empty($folders)?array():$folders);
		$this->assign('spfolders',$spfolders);
		$this->display('college/courselist');
	}

    public function study2(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $courseServer = Ebh::app()->lib('CourseServer');
        $courseServer->init($roominfo['crid'], $user['uid'], array('allsort' => 1), $roominfo['iscollege']);
        //我开通的课程
        $myCourseList = $courseServer->getMyCourseList(true);
        //单课收费的课件
        //本校课程服务
        $schoolCourseList = $courseServer->getSchoolPackageList();
        //企业选课服务（公共课程）
        $sourceCourseList = $courseServer->getSourcePackList();
        $this->assign('myCourseList', $myCourseList);
        $this->assign('schoolCourseList', $schoolCourseList);
        $this->assign('sourceCourseList', $sourceCourseList);
        $this->display('/college/courselist2');



        //单课收费的课件

        $this->getCwpay($roominfo,$user,true);//单课收费的课件
        //获取modulename
        $mnlib = Ebh::app()->lib('Modulename');
        $mnlib->getmodulename($this,array('modulecode'=>'study','tors'=>0,'crid'=>$roominfo['crid']));
        $foldermodel = $this->model('Folder');
        //全校免费课程
        if($roominfo['isschool'] == 7){
            $schoolfreelist = $foldermodel->getfolderlist(array('crid'=>$roominfo['crid'],'isschoolfree'=>1,'limit'=>1000));
            $rumodel = $this->model('roomuser');
            $userin = $rumodel->getroomuserdetail($roominfo['crid'],$user['uid']);
            //过滤服务项中的课程
            if (!empty($userin) && !empty($schoolfreelist)) {
                $folderid_arr = array_column($schoolfreelist, 'folderid');
                $folderid_arr = $this->model('Payitem')->getItemListByFolderIds($folderid_arr);
                foreach ($schoolfreelist as $k => $item) {
                    if (in_array($item['folderid'], $folderid_arr)) {
                        unset($schoolfreelist[$k]);
                    }
                }
            }
            if(!empty($userin)) {
                $this->assign('userin', $userin);
                $this->assign('schoolfreelist',$schoolfreelist);
            }

            $survey_id = $this->_need_survery($roominfo['crid'], $user);
            $this->assign('survey_id', $survey_id);
        }


        $folderids = '';
        if($roominfo['isschool'] != 7){
            //班级-课程关联
            $classmodel = $this->model('Classes');
            $classcoursesmodel = $this->model('Classcourses');
            if($roominfo['domain'] == 'lcyhg'){//绿城育华 一个学生可以多个班级
                $needlist = TRUE;
                $myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid'],$needlist);

                $myclassidarr = array_column($myclass,'classid');
                $myclassid = implode($myclassidarr,',');
                $classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);

            }else{
                $myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
                $myclassid = empty($myclass['classid']) ? 0 : $myclass['classid'];
                $classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
            }
            if(!empty($classfolders)){//获取课程基础信息
                foreach ($classfolders as $fd){
                    $folderids.= $fd['folderid'].',';
                }
                $folderids = rtrim($folderids,',');
                $folderparam = array('limit'=>1000,'folderid'=>$folderids,'needpower'=>true);
                $folders = $foldermodel->getfolderlist($folderparam);
            }

            //没有关联的，按老策略，老师的课程
            if(empty($folderids)){
                $queryarr = parsequery();
                $queryarr['crid'] = $roominfo['crid'];
                if(!empty($myclassid))
                    $queryarr['classid'] = $myclassid;
                else{
                    // header('Location:'.geturl('myroom/college/allcourse'));
                    // exit;
                }
                if(!empty($queryarr['classid'])){
                    if(!empty($myclass['grade']))
                        $queryarr['grade'] = $myclass['grade'];
                    $queryarr['pagesize'] = 1000;
                    $queryarr['order'] = '  displayorder asc,folderid desc';
                    $folders = $foldermodel->getClassFolder($queryarr);
                }
            }
        }

        if(1) {	//收费分成学校，则未开通或已过期的课程，就显示阴影和开通按钮
            $splist = array();
            $spfolders = $this->notopened($roominfo,$user,$splist,$folderids);

            // 遍历出已购买的课程 ID
            $folderidArrr = array();
            if (!empty($spfolders)) {
                foreach ($spfolders as $key => $val) {
                    if(!empty($val['itemlist'])) {
                        foreach ($val['itemlist'] as $k => $v) {
                            if (!empty($v['folderid'])) {
                                $folderidArrr[] = $v['folderid'];
                            }
                        }
                    }
                    if (!empty($val['folderid'])) {
                        $folderidArrr[] = $val['folderid'];
                    }
                }
            }

            //学生后台，未购买的课程去掉重复的，已购买的隐藏（逻辑：遍历课程，依次将课程 id 放入到一个数组，如果该课程id数组中已存在则是重复的，删除）
            //可见的未购买服务项
            $vis_items = array();
            if (!empty($splist)) {
                foreach ($splist as $key => $val) {
                    if(!empty($val['itemlist'])) {
                        foreach ($val['itemlist'] as $k => $v) {
                            if (in_array($v['folderid'],$folderidArrr)) {
                                /*if ($roominfo['crid'] != 12859) {
                                    unset($splist[$key]['itemlist'][$k]);
                                }*/
                            } else {
                                $folderidArrr[] = $v['folderid'];
                                $vis_items[$v['sid']] = $v['sid'];
                            }
                        }
                    }
                    if (!empty($val['folderid'])) {
                        if (in_array($val['folderid'],$folderidArrr)) {
                            unset($splist[$key]);
                        } else {
                            $folderidArrr[] = $val['folderid'];
                            $vis_items[$v['sid']] = $v['sid'];
                        }
                    }
                }
            }
            $vis_items = array_filter($vis_items, function($vis_item) {
                return $vis_item > 0;
            });
            $pay_sorts_model = $this->model('Paysort');
            $vis_sorts = $pay_sorts_model->getSortPackedList($vis_items);
            unset($vis_items);
            if (!empty($vis_sorts)) {
                $sid_arr = array_keys($vis_sorts);
                $sort_price_arr = $pay_sorts_model->sortsCountPrice($sid_arr);
                if (!empty($sort_price_arr)) {
                    foreach ($sort_price_arr as $pitem) {
                        if ($pitem['cannotpay'] == 1) {
                            $vis_sorts[$pitem['sid']]['cannotpay'] = 1;
                            continue;
                        }
                        if ($pitem['isschoolfree'] == 0) {
                            if (!isset($vis_sorts[$pitem['sid']]['all_price'])) {
                                $vis_sorts[$pitem['sid']]['all_price'] = 0;
                            }
                            $vis_sorts[$pitem['sid']]['all_price'] += $pitem['iprice'];
                        }
                    }
                }
                $vis_sorts = array_filter($vis_sorts, function($isort) {
                    return isset($isort['all_price']) && $isort['all_price'] > 0 || !empty($isort['cannotpay']);
                });
            }


            $this->assign('vis_sorts', $vis_sorts);
            $this->assign('splist',$splist);
        }

        //学习进度等
        if(!empty($folders) || !empty($spfolders)){
            //课程集合下的视频课件
            if(!empty($folderids)){
                $pmodel = $this->model('progress');
                $param['folderid'] = $folderids;

                $param['limit'] = 10000;

                $coursewarelist = $pmodel->getCWByFolderid($param);
                $cwids = '';
            }

            if(!empty($coursewarelist)){
                $this->studyinfo($folders,$coursewarelist,$param,$roominfo,$user,$folderids,'spfolders',$spfolders);
            }
        }
        $this->assign('roominfo',$roominfo);
        $this->_updateuserstate(2);
        $this->assign('folderids',empty($folderids)?'':$folderids);
        $this->assign('folders',empty($folders)?array():$folders);


        $this->assign('spfolders',$spfolders);
        $this->display('college/courselist');
    }
	
	/*
	课件列表
	*/
	public function study_cwlist_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$api = Ebh::app()->getApiServer('ebh');
		$classid = $api->reSetting()
            ->setService('Member.User.getStudentClassId')
            ->addParams('uid', $user['uid'])
            ->addParams('crid', $roominfo['crid'])
            ->request();
        $other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);

		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 3000;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
		if (!empty($classid)) {
		    $queryarr['classids'] = $classid;
        }
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid,$roominfo['crid']);
		$this->assign('folder',$folder);
		
		//是否开通了新作业
		$newExamPower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
        if ($newExamPower) {
            $this->assign('examPower',1);
        }
        $param = parsequery();
        $param['pagesize'] = 100;
		if(empty($folder['playmode']) || empty($queryarr['q'])){
            $queryarr = array_merge($queryarr, $param);
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
		else{
            $queryarr = array_merge($queryarr, $param);
			$searchedcwlist = $coursemodel->getfolderseccourselist($queryarr);
			unset($queryarr['q']);
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
		if (!empty($cwlist)) {
		    $lostTeachers = array_filter($cwlist, function($cw) {
		        return empty($cw['username']);
            });
		    if (!empty($lostTeachers)) {
		        $crids = array_column($lostTeachers, 'crid');
		        $admins = $this->model('Classroom')->getAdmins($crids);
		        array_walk($cwlist, function(&$item, $k, $args) {
		            if (!empty($item['username'])) {
		                return;
                    }
                    $item['uid'] = $args[$item['crid']]['uid'];
                    $item['username'] = $args[$item['crid']]['username'];
                    $item['realname'] = $args[$item['crid']]['realname'];
                    $item['sex'] = $args[$item['crid']]['sex'];
                    $item['face'] = $args[$item['crid']]['face'];
                    $item['groupid'] = 5;
                }, $admins);
            }
        }
		$cwcout = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($cwcout, $param['pagesize']);
	    $this->assign('pagestr', $pagestr);
		
		if(!empty($cwlist)){
		
		$cwids = '';
		$cwarr = array();
		foreach($cwlist as $cw){
			$cwids.= $cw['cwid'].',';
			$cwarr[] = $cw['cwid'];
		}
		$cwids = rtrim($cwids,',');

		
		if($is_zjdlr){
			$cwuserlist = $coursemodel->getcwuserlist($cwarr);
            $student_id_arr = array();
    		if(!empty($cwuserlist)){
    			foreach ($cwlist as &$cu) {
    				foreach ($cwuserlist as $cwulist) {
    					if($cwulist['cwid'] == $cu['cwid']){
    						$cu['cwuid'] = $cwulist['uid'];
    						$cu['cwface'] = $cwulist['face'];
    						$cu['cwgroupid'] = $cwulist['groupid'];
    						$cu['cwusername'] = $cwulist['username'];
    						$cu['cwsex'] = $cwulist['sex'];
    						$cu['cwrealname'] = $cwulist['realname'];
    						$cu['cwtoid'] = $cwulist['toid'];
                            $student_id_arr[] = $cu['cwuid'];
    					}

    				}
    			}
    		}
    		$student_id_arr = array_unique($student_id_arr);
            if (!empty($student_id_arr)) {
                $student_classes = $this->model('Classes')->getClassInfoByUserids($student_id_arr, $roominfo['crid']);
                $this->assign('student_classes', $student_classes);
            }

    		$default_author = $this->model('User')->getuserbyuid($roominfo['uid']);
            $this->assign('default_author', !empty($default_author['realname']) ? $default_author['realname'] : $default_author['username']);
            $this->assign('other_config', $other_config);
		}
		//计算播放进度
		$useSum = $is_zjdlr ? TRUE : FALSE;
		$cwprogress = $this->_getProgress($user['uid'],$cwids,$useSum);
		foreach($cwlist as $k=>$cw){
			if(!empty($cwprogress[$cw['cwid']]))
				$cwlist[$k]['percent'] = $cwprogress[$cw['cwid']];
			else
				$cwlist[$k]['percent'] = 0;
		}
		// var_dump($cwlist);
		}
		
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getfolderfavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		
		$sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($cwlist as $k=>$course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			if(($k-1)>=0 && $cwlist[$k-1]['sid'] == $course['sid']){
				if($cwlist[$k-1]['percent'] != 100 || !empty($cwlist[$k-1]['disabled'])){
					$cwlist[$k]['disabled'] = true;
					$course['disabled'] = true;
				}
				
			}
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
		
		
		if(!empty($q) && $folder['playmode']){//搜索时按序播放
			// $lastsid = 0;
			$resultSection = array();
			if(!empty($searchedcwlist)){//搜索结果不为空
				foreach($searchedcwlist as $cw){
					if(!empty($cw['sid']))
						$sid = $cw['sid'];
					else
						$sid = 0;
					$resultSection[] = $sid; 
					if(!isset($lastsid))
						$lastsid = $sid;
					if($lastsid != $sid){
						//删除上一个目录末尾多余的数据
						for($i=$sectionj[$lastsid];$i<$nsectioncount[$lastsid];$i++){
							unset($sectionlist[$lastsid][$i]);
						}
						$lastsid = $sid;
					}
					if(empty($nsectioncount[$sid]))
						$nsectioncount[$sid] = count($sectionlist[$sid]);
					// var_dump($nsectioncount);
					if(empty($sectionj[$sid]))
						$sectionj[$sid] = 0;
					
					// var_dump($sectionj[$sid]);
					
					for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
						//删除与搜索结果不符的内容
						if($cw['cwid'] != $sectionlist[$sid][$i]['cwid']){
							// echo $sectionlist[$sid][$i]['cwid'];
							unset($sectionlist[$sid][$i]);
						}else{
							$sectionj[$sid] = $i+1;
							break;
						}
					}
					
				}
				
				for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
					unset($sectionlist[$sid][$i]);
				}
				foreach($sectionlist as $k=>$section){
					if(!in_array($k,$resultSection)){
						unset($sectionlist[$k]);
					}
				}
			}else{
				$sectionlist = array();
			}
			// var_dump($searchedcwlist);
		}
		//服务包限制时间,用于判断往期课件
		$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$limitdate = $pmodel->getFirstLimitDate(array('folderid'=>$folderid,'uid'=>$user['uid']));
			$this->assign('limitdate',$limitdate['firstday']);
		}
		//处理服务项权限，如果ptype非0 则可以打开课件详情页
		$itemid = 0;
		$haspower = 0;	//是否课件查看权限
        $free = false;
        $sid = 0;
		if(NULL !== $this->input->get('itemid')) {
			$itemid = intval($this->input->get('itemid'));
			$pitemmodel = $this->model('Payitem');
			$itemdetail = $pitemmodel->geSimpletItemByItemid($itemid);
			if(!empty($itemdetail) && $itemdetail['folderid'] == $folderid && ($itemdetail['ptype'] > 1)) {	//课程对应服务项有课程查看权限
				$haspower = 1;
			}
			if (!empty($itemdetail) && $itemdetail['iprice'] == 0 && $itemdetail['cannotpay'] == 0) {
                $free = true;
            }
            if (!empty($itemdetail['sid'])) {
                $sid = $itemdetail['sid'];
            }
		}
		if ($folder['isschoolfree'] == 1) {
            $free = true;
        }
        if ($sid > 0) {
            $paysort_prices = $this->model('Paysort')->sortsCountPrice(array($sid));
            if (!empty($paysort_prices)) {
                $all_price = 0;
                foreach ($paysort_prices as $paysort_price) {
                    if ($paysort_price['cannotpay'] == 1) {
                        $free = false;
                        break;
                    }
                    if ($paysort_price['isschoolfree'] == 0) {
                        $all_price += $paysort_price['iprice'];
                    }
                }
                if ($all_price > 0) {
                    $free = false;
                }
            }
        }


		//start 确定课程能否免费开通
        // end  确定课程能否免费开通
		$this->assign('iszjdlr',$is_zjdlr);
		$this->assign('isnewzjdlr',$is_newzjdlr);
		$this->assign('itemid',$itemid);
		$this->assign('haspower',$haspower);
		$this->assign('sectionlist',$sectionlist);
		$this->assign('myfavorite',$myfavorite);
        $this->assign('free', $free);
		$this->assign('q',$q);
		$this->assign('cwlist',$cwlist);
        $this->assign('folderid', $folderid);
		$this->_updateuserstate(6,$folderid);
		$this->display('college/cwlist');
	}
	/**
	 * @param  $cwids 课件编号组合，以逗号隔开，如12938,12950
	 * @param  $useSum bool 是否用持续时间总和来计算完成百分比
	 * @return $return array
	 */
	private function _getProgress($uid,$cwids,$useSum = FALSE) {
		$apiServer = Ebh::app()->getApiServer('ebh');
		$data = array('uid'=>$uid,'cwids'=>$cwids);
		//通过接口方式调用学习记录
		$loglist = $apiServer->reSetting()->setService('Study.Log.list')->addParams($data)->request();
		$list = array();
		foreach ($loglist as $cwid => $log) {
		    $totalltime = !empty($log['totalltime'] ) ? $log['totalltime'] : 0;
			$percent = empty($log['ctime']) ? 0 : ($useSum ? $totalltime / $log['ctime'] : $log['ltime'] / $log['ctime']);
			if ($percent > 0.9)
				$percent = 1;
			$percent = floor($percent * 100);
			$list[$cwid] = $percent;
		}
		return $list;
	}
	/*
	全校课程
	*/
	public function allcourse(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$foldermodel = $this->model('Folder');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['pagesize'] = 1000;
		$queryarr['nosubfolder'] = 1;
		$queryarr['needpower'] = 1;
		$folders = $foldermodel->getfolderlist($queryarr);
		if(!empty($folders)){
			if($roominfo['isschool'] != 7){
				$folderids = '';
				foreach($folders as &$folder){
					$folderids.= $folder['folderid'].',';
				}
				//folderid集合字符串
				$folderids = rtrim($folderids,',');

				//国土改课程总分逻辑,修改后返回课程的字段
				$folders = $this->modifyZjdrSchoolScore($folders,$roominfo,$folderids);
				$this->studyinfo($folders,$roominfo,$user,$folderids);
				
			}
			
		}
		$this->assign('all',true);
		$this->assign('folders',$folders);
		$this->assign('roominfo',$roominfo);
		$this->display('college/courselist');
	}
	
	/**
	*全校教师
	*/
	public function allteachers() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$foldermodel = $this->model('Folder');
		$teachers = $foldermodel->getTeacherFolderList(array('crid'=>$roominfo['crid'],'power'=>'0'));
		$this->assign('teachers',$teachers);
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->display('college/allteachers');
	}
	
	
	private function _updateuserstate($typeid,$folderid=0) {
		//更新新课程用户状态时间
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$userstatelib = Ebh::app()->lib('Userstate');
		$userstatelib->updateUserstate($roominfo['crid'],$user['uid'],$typeid,$folderid);
	}
	
	/*
	课程介绍与课件列表
	*/
	public function study_introduce_view(){
		$roominfo = Ebh::app()->room->getcurroom();
        $other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
		$user = Ebh::app()->user->getloginuser();
        $api = Ebh::app()->getApiServer('ebh');
        $classid = $api->reSetting()
            ->setService('Member.User.getStudentClassId')
            ->addParams('uid', $user['uid'])
            ->addParams('crid', $roominfo['crid'])
            ->request();
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
        $param = parsequery();
        $param['pagesize'] = 100;

		$queryarr['pagesize'] = $param['pagesize'];
        $queryarr['page'] = $param['page'];
		$queryarr['status'] = 1;

        if (!empty($classid)) {
            $queryarr['classids'] = $classid;
        }
		
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('folder',$folderid);
		if(!empty($folder['introduce']))
			$folder['introduce'] = unserialize($folder['introduce']);
		$this->assign('folder',$folder);
		
		
		if(empty($folder['playmode']) || empty($queryarr['q'])){
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		} else{
			$searchedcwlist = $coursemodel->getfolderseccourselist($queryarr);
			unset($queryarr['q']);
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
        $cwcout = $coursemodel->getfolderseccoursecount($queryarr);
        $this->assign('cwcount',$cwcout);
        $pagestr = show_page($cwcout, $param['pagesize']);
        $this->assign('pagestr', $pagestr);
		if(!empty($cwlist)){
            $cwids = '';
            foreach($cwlist as $cw){
                $cwids.= $cw['cwid'].',';
            }
            $cwids = rtrim($cwids,',');
            $param['cwid'] = $cwids;
            $param['uid'] = $user['uid'];
            $pmodel = $this->model('progress');
            if($is_zjdlr){//国土资源的，获取进度按累计时长
                $progresslist = $pmodel->getFolderProgressByCwid_cwsum($param);
            }else{//其他按最长一次听课时间
                $progresslist = $pmodel->getFolderProgressByCwid($param);
            }
            foreach($progresslist as $k=>$p){
                if($p['percent']*100>=90){
                    $cwprogress[$p['cwid']] = 100;
                }
                else{
                    $cwprogress[$p['cwid']] = floor($p['percent']*100);
                }
            }
            foreach($cwlist as $k=>$cw){
                if(!empty($cwprogress[$cw['cwid']]))
                    $cwlist[$k]['percent'] = $cwprogress[$cw['cwid']];
                else
                    $cwlist[$k]['percent'] = 0;
            }
            // var_dump($cwlist);
		}
		
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getfolderfavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		
		$sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($cwlist as $k=>$course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			if(($k-1)>=0 && $cwlist[$k-1]['sid'] == $course['sid']){
				if($cwlist[$k-1]['percent'] != 100 || !empty($cwlist[$k-1]['disabled'])){
					$cwlist[$k]['disabled'] = true;
					$course['disabled'] = true;
				}
				
			}
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

		if(!empty($q) && $folder['playmode']){//搜索时按序播放
			// $lastsid = 0;
			$resultSection = array();
			if(!empty($searchedcwlist)){//搜索结果不为空
				foreach($searchedcwlist as $cw){
					if(!empty($cw['sid']))
						$sid = $cw['sid'];
					else
						$sid = 0;
					$resultSection[] = $sid; 
					if(!isset($lastsid))
						$lastsid = $sid;
					if($lastsid != $sid){
						//删除上一个目录末尾多余的数据
						for($i=$sectionj[$lastsid];$i<$nsectioncount[$lastsid];$i++){
							unset($sectionlist[$lastsid][$i]);
						}
						$lastsid = $sid;
					}
					if(empty($nsectioncount[$sid]))
						$nsectioncount[$sid] = count($sectionlist[$sid]);
					// var_dump($nsectioncount);
					if(empty($sectionj[$sid]))
						$sectionj[$sid] = 0;
					
					// var_dump($sectionj[$sid]);
					
					for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
						//删除与搜索结果不符的内容
						if($cw['cwid'] != $sectionlist[$sid][$i]['cwid']){
							// echo $sectionlist[$sid][$i]['cwid'];
							unset($sectionlist[$sid][$i]);
						}else{
							$sectionj[$sid] = $i+1;
							break;
						}
					}
					
				}
				
				for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
					unset($sectionlist[$sid][$i]);
				}
				foreach($sectionlist as $k=>$section){
					if(!in_array($k,$resultSection)){
						unset($sectionlist[$k]);
					}
				}
			}else{
				$sectionlist = array();
			}
			// var_dump($searchedcwlist);
		}
		//服务包限制时间,用于判断往期课件
		$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$limitdate = $pmodel->getFirstLimitDate(array('folderid'=>$folderid,'uid'=>$user['uid']));
			$this->assign('limitdate',$limitdate['firstday']);
		}
        $this->assign('pagestr', $pagestr);
		$this->assign('sectionlist',$sectionlist);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('q',$q);
		$this->assign('cwlist',$cwlist);
		$this->_updateuserstate(6,$folderid);
		$this->assign('roominfo',$roominfo);
		$this->display('college/cwlist_introduce');
	}
	
	/*
	课程介绍与摘要
	*/
	public function study_introduce_undercourse_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 100;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
		
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		// $viewnumlib = Ebh::app()->lib('Viewnum');
		// $viewnumlib->addViewnum('folder',$folderid);
		if(!empty($folder['introduce']))
			$folder['introduce'] = unserialize($folder['introduce']);
		$this->assign('folder',$folder);
		$this->display('college/cwlist_introduce_undercourse');
	}

	/**
	 * 学习数统计
	 */
	public function studycount(){
		$studycount = array();
		$folderid = $this->input->post('folderid');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();

		//作业数
		$exampower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($exampower) {//判断有没有开通新的作业
			$studycount['examnum'] = Ebh::app()->runAction('college/examv2','unfishCount',$folderid);
		} else {
			$myclass = $this->model('classes')->getClassByUid($roominfo['crid'], $user['uid']);
			$queryarr = array();
			if (!empty($folderid)){
				$queryarr['folderid'] = $folderid;
			}
			$queryarr['uid'] = $user['uid'];
			$queryarr['crid'] = $roominfo['crid'];
			$queryarr['classid'] = $myclass['classid'];
			if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
				$queryarr['grade'] = $myclass['grade'];
				$queryarr['district'] = $myclass['district'];
			}
			$queryarr['filteranswer'] = 1;
			$queryarr['type'] = array(0,2);
			$studycount['examnum'] = $this->model('exam')->getExamListCountByMemberid($queryarr);
		}
		

		//回答数
		$queryarr = array();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
		$queryarr['qshield'] = 0;
		$queryarr['notmyquestion'] = 1;
		$queryarr['folderid'] = $folderid;
		$studycount['asknum'] = $this->model('askquestion')->getaskcountbynoanswers($queryarr);

		//调查问卷数
		$param = array();
		$param['folderid'] = $folderid;
		$param['crid'] = $roominfo['crid'];
		$param['ispublish'] = 1;
		$param['uid'] = $user['uid'];
		$studycount['surveynum'] = $this->model('survey')->getUnAnsweredCount($param);

		//超过99的计99
		$studycount['examnum'] = empty($studycount['examnum']) ? 0 : $studycount['examnum'];
		$studycount['examnum'] = $studycount['examnum'] > 99 ? 99 : $studycount['examnum'];
		$studycount['asknum'] = empty($studycount['asknum']) ? 0 : $studycount['asknum'];
		$studycount['asknum'] = $studycount['asknum'] > 99 ? 99 : $studycount['asknum'];
		$studycount['surveynum'] = empty($studycount['surveynum']) ? 0 : $studycount['surveynum'];
		$studycount['surveynum'] = $studycount['surveynum'] > 99 ? 99 : $studycount['surveynum'];
		echo json_encode($studycount);
	}
	
	//最新课程
	public function newcourse($roominfo,$user){
		$cwmodel = $this->model('courseware');
		//开通课程的id

		$myfolderlist = $this->openedcourse;
		if(!empty($myfolderlist)){
			$folderids = '';
			foreach($myfolderlist as $folder){
				$folderids .= $folder['folderid'].',';
			}
			$param['folderids'] = rtrim($folderids,',');
		}

		if($roominfo['isschool']!=7){
			$roomcache = Ebh::app()->lib('Roomcache');
			$foldermodel = $this->model('folder');
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
			
			if(empty($myclass)){
				$myclass['classid'] = 0;
			}
			
			$paramf['crid'] = $roominfo['crid'];
			$paramf['classid'] = $myclass['classid'];
			$paramf['limit'] = 100;
			if(!empty($myclass['grade'])){
				$paramf['grade'] = $myclass['grade'];
				$myfolderlist = $roomcache->getCache($roominfo['crid'],'other',$paramf);
				if($myfolderlist !== FALSE){
					$myfolderlist = $foldermodel->getClassFolderWithoutTeacher($paramf);
					$roomcache->setCache($roominfo['crid'],'other',$paramf,$myfolderlist,30);
				}
			}else{
				$myfolderlist = $roomcache->getCache($roominfo['crid'],'other',$paramf);
				if($myfolderlist !== FALSE){
					$myfolderlist = $foldermodel->getClassFolder($paramf);
					$roomcache->setCache($roominfo['crid'],'other',$paramf,$myfolderlist,30);
				}
			}
			if(!empty($myfolderlist)){
				$folderids = isset($folderids)?$folderids:'';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}
		// var_dump($param['folderids']);
		// $param['crid'] = $roominfo['crid'];
		$newcwlist = array();
		$todaylist = array();
        $api = Ebh::app()->getApiServer('ebh');
        $classid = $api->reSetting()
            ->setService('Member.User.getStudentClassId')
            ->addParams('uid', $user['uid'])
            ->addParams('crid', $roominfo['crid'])
            ->request();
		$systemsetting = $api->reSetting()
            ->setService('Aroomv3.Room.othersetting')
            ->addParams('crid', $roominfo['crid'])
            ->request();
			//最新课程分页数
		$pagesize = empty($systemsetting['newcwpagesize'])?20:$systemsetting['newcwpagesize'];
		
		if(!empty($param['folderids'])){
			$param['status'] = 1;
			$param['limit'] = 300;
			$param['order'] = 'c.truedateline asc';
			$param['truedatelineto'] = strtotime('today')+86400*7;//七天内
			$param['truedatelinefrom'] = strtotime('today');
			$param['power'] = 0;
            if (!empty($classid)) {
                $param['classids'] = $classid;
            }
			$cwlist = $cwmodel->getnewcourselist($param);

			$redis = Ebh::app()->getCache('cache_redis');
			
			$totaycourses = array();
			foreach($cwlist as $cw){
				$viewnum = $redis->hget('coursewareviewnum',$cw['cwid']);
				if(!empty($viewnum))
					$cw['viewnum'] = $viewnum;
				// $cw['dateline'] = !empty($cw['submitat'])?$cw['submitat']:$cw['dateline'];
				$dayis = date('Y-m-d',$cw['truedateline']);
				if($dayis == date('Y-m-d'))
					$dayis = 'z今天';
				elseif($dayis == date('Y-m-d',SYSTIME+86400))
					$dayis = 'y明天';
				elseif($dayis == date('Y-m-d',SYSTIME-86400))
					$dayis = 'x昨天';
				$newcwlist[$dayis][] = $cw;
			}
			if(!empty($newcwlist['z今天'])){
			    //今天的单独处理下
			    $totaycourses = $newcwlist['z今天'];
			    $todaylist = $this->sortTodayCourse($totaycourses);
			    unset( $newcwlist['z今天']);
			    //array_merge
			    $newcwlist['z今天'] = array_merge_recursive($todaylist['staring'],$todaylist['coming'],$todaylist['expired']);
			}
			//正在上课->即将开课->已结束（今天）->明天->昨天->[日期]->[日期]...排序
			krsort($newcwlist);
		}
		$this->assign('newcwlist',$newcwlist);
		$this->assign('pagesize',$pagesize);
		$this->assign('listcount',count($cwlist));
		//企业版的最新课件最多显示５个
		// $maxCwCount = Ebh::app()->room->getRoomType() == 'com' ? 5 : PHP_INT_MAX;
		// $this->assign('maxCwCount', $maxCwCount);
		//$this->assign('todaylist',$todaylist);
	}
	
	
	/**
	 * 今天的课程 排序处理 
	 * 按照 正在上课->即将开课->已结束
	 */
	private function sortTodayCourse($courselist){
	    $todaylist = array('staring'=>array(),'coming'=>array(),'expired'=>array());
	    if(empty($courselist))
	        return false;
	    foreach ($courselist as $course){
	        $starttime = $course['truedateline'];//开始时间
	        $cwlenth = $course['cwlength'];//课件时长
	        $nowtime = SYSTIME;//当前时间
	        if($nowtime <= $starttime){
	            //即将开始
	            $course['todaysort'] = 'coming';
	            $todaylist['coming'][] = $course;
	        }elseif(!empty($cwlenth) && ($nowtime>=$starttime) && (($starttime+$cwlenth) >= $nowtime) && (empty($course['endat']) || $course['endat']>=$nowtime)){
	            //正在上课
	            $course['todaysort'] = 'staring';
	            $todaylist['staring'][] = $course;
	        }elseif($nowtime > ($starttime+$cwlenth) || (!empty($course['endat']) && $nowtime>$course['endat'])){
	            //已结束
	            $course['todaysort'] = 'expired';
	            $todaylist['expired'][] = $course;
	        }
	    }
	    
	    return $todaylist;
	}
	
	/*
	国土的最新课程
	*/
	private function newcourse_gt($roominfo){
		$cwmodel = $this->model('courseware');
		$param['limit'] = 8;
		$param['crid'] = $roominfo['crid'];
		$param['order'] = 'c.cwid desc';
        $conf = Ebh::app()->getConfig()->load('othersetting');
		$param['folderids'] = $conf['lecture'];
		$cwlist = $cwmodel->getnewcourselist($param);
		if(!empty($cwlist)){
			$cwarr = array();
			foreach ($cwlist as $cw) {
				$cwarr[] = $cw['cwid'];
			}
			$cwinfo = $cwmodel->getcwuserlist($cwarr);
			if(!empty($cwinfo)){
				foreach ($cwinfo as $cwi) {
					foreach ($cwlist as &$clist) {
						if($clist['cwid'] == $cwi['cwid']){
							$clist['cwuid'] = $cwi['uid'];
							$clist['cwtoid'] = $cwi['toid'];
							$clist['cwface'] = $cwi['face'];
							$clist['cwusername'] = $cwi['username'];
							$clist['cwrealname'] = $cwi['realname'];
						}
					}
				}
			}
		}
		// var_dump($cwlist);
		$this->assign('newcwlist',$cwlist);
	}
	
	/*
	未开通的课程
	*/
	private function notopened($roominfo,$user,&$splist,&$folderids){
		$roomcache = Ebh::app()->lib('Roomcache');
		$spmodel = $this->model('PayPackage');
		$spparam = array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'itype asc,displayorder asc,pid desc','limit'=>1000);
        $thelist = $spmodel->getsplist($spparam);
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
			$spfolders = $splist;
			if(!empty($spidlist)) {
				$pitemmodel = $this->model('PayItem');
				$itemparam = array('limit'=>1000,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>0);
				/*$itemlist = $roomcache->getCache($roominfo['crid'],'payitem',$itemparam);
				if($itemlist === FALSE) {
					$itemlist = $pitemmodel->getItemFolderList($itemparam);
					$roomcache->setCache($roominfo['crid'],'payitem',$itemparam,$itemlist,120);	//服务项缓存120秒
				}*/
                $itemlist = $pitemmodel->getItemFolderList($itemparam);
				if(!empty($itemlist)) {
					foreach($itemlist as $myitem) {
						if(isset($spfolders[$myitem['pid']])) {
							$spfolders[$myitem['pid']]['itemlist'][] = $myitem;
						}
					}
				}
			}
			$mylist = array();
			if(!empty($user) && $user['groupid'] == 6) {
				$userpermodel = $this->model('Userpermission');
				$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
				$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
				$this->openedcourse = $myfolderlist;
				foreach($myfolderlist as $myfolder) {
					$mylist[$myfolder['folderid']] = $myfolder;
				}
			}

			//var_dump($spfolders);
			foreach($spfolders as $k=>$package){
				$showpack = false;
				foreach($package['itemlist'] as $l=>$folder){
					if(/*$folder['fprice']==0 || */isset($mylist[$folder['folderid']])/* || $folder['iprice'] ==0*/){
						$showpack = true;
						if(empty($folderids))
							$folderids = $folder['folderid'];
						else
							$folderids .= ','.$folder['folderid'];
					}
					else
						unset($spfolders[$k]['itemlist'][$l]);
				}
				if($showpack == false)
					unset($spfolders[$k]);
			}
			///////////未开通的课程
			if(!empty($spidlist)) {
				$pitemmodel = $this->model('PayItem');
				$itemparam = array('limit'=>1000,'pidlist'=>$spidlist,'displayorder'=>'i.pid,f.displayorder','uid'=>$user['uid'],'crid'=>$roominfo['crid'],'power'=>0);
				$itemlist = $pitemmodel->getItemFolderListNotPaid($itemparam, false);
				//print_r($itemlist);exit;
				if(!empty($itemlist)) {
				    $sids = array_column($itemlist, 'sid');
				    $sorts = $this->model('PaySort')->getSortPackedList($sids);
					foreach($itemlist as &$myitem) {
                        if (empty($myitem['sid']) || $myitem['sid'] == '0') {
                            if (!isset($splist[$myitem['pid']]['sorts'][0])) {
                                $splist[$myitem['pid']]['sorts'][0] = array(
                                    'sid' => 0,
                                    'sname' => '其他',
                                    'pid' => $myitem['pid'],
                                    'sdisplayorder' => 2147483648
                                );
                            }
                        } else {
                            if (!isset($splist[$myitem['pid']]['sorts'][$myitem['sid']]) && isset($sorts[$myitem['sid']])) {
                                $splist[$myitem['pid']]['sorts'][$myitem['sid']] = $sorts[$myitem['sid']];
                            }
                            if (!empty($splist[$myitem['pid']]['sorts'][$myitem['sid']]['showbysort']) && $splist[$myitem['pid']]['sorts'][$myitem['sid']]['showbysort'] == '1') {
                                if (isset($splist[$myitem['pid']]['sorts'][$myitem['sid']]['list'])) {
                                    $index = $splist[$myitem['pid']]['sorts'][$myitem['sid']]['list'];
                                    if (empty($splist[$myitem['pid']][$index]['coursewarenum'])) {
                                        $splist[$myitem['pid']][$index]['coursewarenum'] = 0;
                                    }
                                    $splist[$myitem['pid']][$index]['coursewarenum'] += $myitem['coursewarenum'];
                                    continue;
                                }
                                $splist[$myitem['pid']]['sorts'][$myitem['sid']]['list'] = count($splist[$myitem['pid']]['itemlist']);
                                if (!empty($sorts[$myitem['sid']]['showaslongblock']) && $sorts[$myitem['sid']]['showaslongblock'] == '1') {
                                    $myitem['foldername'] = $myitem['iname'] = $sorts[$myitem['sid']]['sname'];
                                    $myitem['img'] = $sorts[$myitem['sid']]['imgurl'];
                                    $myitem['iprice'] = 1;
                                }
                            }
                        }

                        $myitem['payurl'] = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$myitem['itemid'].'&sid='.$myitem['sid'];
                        if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
                            $myitem['payurl'] = '/classactive/bank.html';
                        }
                        if(!empty($myitem['ptype'])) {	//服务项权限非0情况下，则可以看课件列表
                            $myitem['payurl'] = '';
                        }
                        if(isset($splist[$myitem['pid']])) {
                            $splist[$myitem['pid']]['itemlist'][] = $myitem;
                        }
					}
				}
			}
			if (!empty($splist)) {
			    //二级分类增加全部分类、排序
                array_walk($splist, function(&$spitem) {
                    if (empty($spitem['sorts'])) {
                        return;
                    }
                    if (count($spitem['sorts']) == 1) {
                        $init = reset($spitem['sorts']);
                        $spitem['csid'] = $init['sid'];
                        return;
                    }
                    $sids = array_column($spitem['itemlist'], 'sid');
                    $sids = array_flip($sids);
                    foreach ($spitem['sorts'] as $sid => $checkitem) {
                        if (!isset($sids[$sid])) {
                            unset($spitem['sorts'][$sid]);
                        }
                    }
                    if (count($spitem['sorts']) > 1) {
                        $spitem['sorts'][-1] = array(
                            'sid' => -1,
                            'sname' => '全部',
                            'sdisplayorder' => -1,
                            'pid' => $spitem['pid']
                        );
                    }

                    $sids = array_column($spitem['sorts'], 'sid');
                    $sids = array_map('intval', $sids);
                    $sdisplayorders = array_column($spitem['sorts'], 'sdisplayorder');
                    $sdisplayorders = array_map('intval', $sdisplayorders);
                    array_multisort($sdisplayorders, SORT_ASC, SORT_NUMERIC, $sdisplayorders,
                        $sids, SORT_DESC, SORT_NUMERIC, $spitem['sorts']);
                    $tmp = $spitem['sorts'];
                    $spitem['sorts'] = array();
                    foreach ($tmp as $titem) {
                        $spitem['sorts'][$titem['sid']] = $titem;
                    }
                    foreach ($spitem['sorts'] as $s) {
                        if ($s['sid'] > -1) {
                            $spitem['csid'] = $s['sid'];
                            break;
                        }
                    }
                });
            }//print_r($splist);exit;
		return $spfolders;
	}
	
	/*
	学习信息加入folders数组中
	*/
	private function studyinfo(&$folders=array(),$roominfo,$user,$folderids,$foldertype = 'folders',&$spfolders=array()){
		$pmodel = $this->model('progress');
		$foldermodel = $this->model('folder');


		//课程集合下的视频课件
		if(!empty($folderids)){
			$coursewarelist = $pmodel->getCWByFolderid(array('folderid'=>$folderids,'limit'=>10000));
			$foldercwlist = array();
			foreach($coursewarelist as $cw){
				$foldercwlist[$cw['folderid']][] = $cw;
			}
			
		}
		//print_r($folderids);exit;
		/*
		$cwids = '';
				//cwid=>folderid对应数组
				$cwidfolderidlist =array();
				$countlist = $pmodel->getFolderProgressCountByFolderid($param);
				foreach($countlist as $f){
					$foldercwcount[$f['folderid']] = $f['count'];
				}
				foreach($coursewarelist as $cw){
					$cwids.= $cw['cwid'].',';
					$cwidfolderidlist[$cw['cwid']] = $cw['folderid'];
				}
				// var_dump($cwidfolderidlist);
				$cwids = rtrim($cwids,',');
				$param['cwid'] = $cwids;
				$param['uid'] = $user['uid'];
				*/
				//根据cwid获取进度,添加到对应 课程进度 数组中
		$folderprogress = array();
		$other_config = Ebh::app()->getConfig()->load('othersetting');
		$other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
		$other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
		$is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
		$is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);

		//是国土的情况下获取国土的非视频课件得分
		if ($is_newzjdlr||$is_zjdlr) {
			if (!empty($this->zjdlr_word_folderid)) {
				$word_folderids = substr($this->zjdlr_word_folderid, 0,-1);
				$coursemodels = $this->model('Roomcourse');
				$word_folder_scores = $coursemodels->getFoldersScore($word_folderids,$roominfo['crid'],$user['uid']);//获取国土的非视频课总得分
				if (!empty($word_folder_scores)) {//构建非视频课课程id和总学分的映射
					foreach ($word_folder_scores as $key => $value) {
						$word_folder_scores_map[$value['folderid']] = $value['score'];
					}
				}
			}
		}

		$useSum = $is_zjdlr ? TRUE : FALSE;
				//if($is_zjdlr){//国土资源的，获取进度按累计时长
					//$progresslist = $pmodel->getFolderProgressByCwid_cwsum($param);
				//}else{//其他按最长一次听课时间
					//$progresslist = $pmodel->getFolderProgressByCwid($param);
				//}
		$apiServer = Ebh::app()->getApiServer('ebh');
		$sdata = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'folderids'=>$folderids);
		$scorelist = $apiServer->reSetting()->setService('Classroom.Score.folderScore')->addParams($sdata)->request();
				
				/* -----------------按累计时长的暂时不计
				//根据cwid获取听课时长总合,添加到对应 课程时长 数组中
				$foldersumtime = array();
				$sumtimelist = $pmodel->getCourseSumTime($param);
				foreach($sumtimelist as $s){
					$folderid = $cwidfolderidlist[$s['cwid']];
					if(empty($foldersumtime[$folderid]))
						$foldersumtime[$folderid] = $s['sumtime'];
					else
						$foldersumtime[$folderid] += $s['sumtime'];
				}
				
				/* ------------------作业学分暂时不计
				//作业完成情况
				$examcreditlist = $foldermodel->getUserFolderExamCredit(array('uid'=>$user['uid'],'folderid'=>$folderids));
				foreach($examcreditlist as $examcredit){
					$folderid = $examcredit['folderid'];
					if(empty($foldercredit[$folderid]['exam']))
						$foldercredit[$folderid]['exam'] = $examcredit['examcredit'];
					else
						$foldercredit[$folderid]['exam'] += $examcredit['examcredit'];
				}
				//作业总数
				$countlist = $foldermodel->getFolderExamCount(array('folderid'=>$folderids));
				// var_dump($countlist);
				foreach($countlist as $f){
					$folderexamcount[$f['folderid']] = $f['count'];
				}*/

				//课程进度数组计算结果记录到课程列表的进度字段
		if($roominfo['isschool'] != 7 && !empty($folders)){
			foreach($folders as $k=>$folder){
				// var_dump($folder);exit;
				$folderid = $folder['folderid'];
				$folders[$k]['creditget'] = empty($scorelist[$folderid])?0:$scorelist[$folderid]['sumscore'];
				if (!empty($word_folder_scores_map[$folderid])) {
					$folders[$k]['creditget'] = $word_folder_scores_map[$folderid];
				}
				// if(empty($folder['credit']) || empty($folder['cwcredit']) || empty($folder['cwpercredit'])
						// || $folder['credit'] == 0 || $folder['cwcredit'] == 0 || $folder['cwpercredit'] == 0 ){//新版学分信息不完整时
						if(!empty($foldercwlist[$folderid])){//课程的视频课件
							$cwids = array_column($foldercwlist[$folderid],'cwid');
							$cwids = implode(',',$cwids);
							// var_dump($cwids);
							$cwprogress = $this->_getProgress($user['uid'],$cwids,$useSum);
							// var_dump($cwprogress);
							$percent = array_sum($cwprogress)/count($cwprogress);
							$folders[$k]['percent'] = round($percent,2);
						} else {
							$folders[$k]['percent'] = 0;
						}
				// } else {
					// $folders[$k]['percent'] = empty($scorelist[$folderid]) || empty($folder['credit'])?0:round($scorelist[$folderid]['sumscore']/$folder['credit']*100,2);
				// }
				$folders[$k]['sumtime'] = 0;//累计时长
			}
		}
		$f = $$foldertype;
        $schoolType = call_user_func(array(Ebh::app()->lib('UserUtil'), 'getRoomInfo'), 'type');//获取网校类型
        $param = array();
        $param['crid'] = $roominfo['crid'];//获取网校crid
        $param['uid'] = $user['uid'];//获取用户id
        $param['folderids'] = $folderids;

        $folderList = $apiServer->reSetting()->setService('Study.FolderLog.get')->addParams($param)->request();
		if(($foldertype =='folders' && $roominfo['isschool']==7) || ($foldertype=='spfolders'&&!empty($$foldertype))){
			foreach($f as $k=>$package){
				foreach($package['itemlist'] as $l=>$folder){
					// var_dump($folder);exit;
					$folderid = $folder['folderid'];
					$f[$k]['itemlist'][$l]['creditget'] = empty($scorelist[$folderid])?0:$scorelist[$folderid]['sumscore'];

					// if(empty($folder['credit']) || empty($folder['cwcredit']) || empty($folder['cwpercredit'])
						// || $folder['credit'] == 0 || $folder['cwcredit'] == 0 || $folder['cwpercredit'] == 0 ){//新版学分信息不完整时
						if(!empty($foldercwlist[$folderid]) ){//课程的视频课件
                            $currFolder = isset($folderList[$folderid]) ? $folderList[$folderid] : array();//取当前课程数组
                            if (!empty($currFolder)) {
                                $cwlength = isset($currFolder['cwlength']) ? $currFolder['cwlength'] : 0;
                                if ($schoolType == 2) {
                                    //国土处理方式
                                    $totalltime = isset($currFolder['totalltime']) ? $currFolder['totalltime'] : 0;
                                    $percent    = $cwlength == 0 ? 0 : $totalltime / $cwlength * 100;
                                } else {
                                    //非国土的处理方式
                                    $ltime   = isset($currFolder['ltime']) ? $currFolder['ltime'] : 0;
                                    $percent = $cwlength == 0 ? 0 : $ltime / $cwlength * 100;

                                }

                            } else {
                                $percent = 0;
                            }
							//$percent = array_sum($cwprogress)/count($cwprogress);
							$f[$k]['itemlist'][$l]['percent'] = round($percent,2);
						} else {
							$f[$k]['itemlist'][$l]['percent'] = 0;
						}
					// } else {
						// $f[$k]['itemlist'][$l]['percent'] = empty($scorelist[$folderid]) || empty($folder['credit'])?0:round($scorelist[$folderid]['sumscore']/$folder['credit']*100,2);
					// }
					$f[$k]['itemlist'][$l]['sumtime'] = 0;//累计时长
				}
			}
		}
		if($foldertype == 'folders')
			$folders = $f;
		elseif($foldertype == 'spfolders')
			$spfolders = $f;
		
	}

    /**
     * 显示发布时间
     * @param $timepan
     * @return string
     */
    public function format_date($timepan) {
        if (date('Y-m-d', $timepan) == date('Y-m-d')) {
            return '今天';
        }
        return date('Y-m-d', $timepan);
    }
	
	/*
	单课收费的课件,$showmylist=true 表示我开通的，false表示未开通的
	*/
	private function getCwpay($roominfo,$user,$showmylist = false){
		if($roominfo['template'] != 'plate' || $roominfo['isschool'] != 7)
			return false;
		$upmodel = $this->model('userpermission');
		$paidcws = $upmodel->getUserPayCwList(array('crid'=>$roominfo['crid'],
												'uid'=>$user['uid'],
												'filterdate'=>true));
		
		$cwmodel = $this->model('courseware');
		$param = array('crid'=>$roominfo['crid'],
						'freeorder'=>'f.displayorder,f.folderid,r.cdisplayorder,cw.cwid desc',
						'cwpay'=>1,
						'power'=>0,
						'limit'=>1000);
		$cwlist = $cwmodel->getfolderseccourselist($param);
		if(!empty($paidcws) || $showmylist){
			$paidcwids = array_column($paidcws,'cwid');
			foreach($cwlist as $k=>$cw){
				if(in_array($cw['cwid'],$paidcwids) == !$showmylist){//首页显示开通的，学习页显示未开通的
					unset($cwlist[$k]);
					continue;
				}
			}
			
			$this->assign('paidcws',count($paidcws));
			if($showmylist && !empty($paidcwids)){//首页
				$cwids = implode(',',$paidcwids);
				//学习进度
				$progresslist = $this->model('progress')->getFolderProgressByCwid(array('cwid'=>$cwids,'uid'=>$user['uid']));
				$cwarr = array();
				foreach($cwlist as $k=>$cw){
					$cwarr[$cw['cwid']] = $cw;
				}
				foreach($progresslist as $progress){
					$cwarr[$progress['cwid']]['percent'] = $progress['percent'];
				}
				$this->assign('cwlist',$cwarr);
				return ;
			}
		}
		$thelist = !empty($cwarr)?$cwarr:$cwlist;
		$viewnumlib = Ebh::app()->lib('Viewnum');
		foreach($thelist as $k=>$cw){
			$viewnum = $viewnumlib->getViewnum('courseware',$cw['cwid']);
			if(!empty($viewnum))
				$thelist[$k]['viewnum'] = $viewnum;
		}
		$folderidarr = array_column($thelist,'folderid');
		if(!empty($folderidarr)){//查询课程下课件数
			$foldernumarr = $this->getfoldernum($folderidarr,false);
			$this->assign('foldernumarr',$foldernumarr);
		}
		if(!empty($cwlist))
			$this->assign('cwpay',true);
		$this->assign('cwlist',$thelist);
	}
	
	/*
	学习，我的课件
	*/
	public function study_mycws(){
		//课件数据
		$this->getMyCwList($cwlist,$cwcount);
		$this->assign('cwlist',$cwlist);
		$queryarr = parsequery();
		$this->assign('q',$queryarr['q']);
		$pagestr = show_page($cwcount,10);
		$this->assign('pagestr',$pagestr);
		$this->display('college/cwlist_my');
	}
	/*
	首页，我的课件
	*/
	private function index_mycws(){
		//课件数据
		$this->getMyCwList($cwlist,$cwcount);
		$this->assign('cwlist',$cwlist);
	}
	/*
	我开通的课件列表,数据处理
	*/
	private function getMyCwList(&$cwlist,&$cwcount,$pagesize = 10){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		
		$upmodel = $this->model('userpermission');
		$paidcws = $upmodel->getUserPayCwList(array('crid'=>$roominfo['crid'],
												'uid'=>$user['uid'],
												'filterdate'=>true));
												
		$cwmodel = $this->model('courseware');
		$cwids = implode(',',array_column($paidcws,'cwid'));//开通的课件
		// var_dump($progresslist);
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['cwids'] = $cwids;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['freeorder'] = 'folderid desc,cw.cwid desc';
		if(!empty($cwids)){
			$cwflist = $cwmodel->getfolderseccourselist($queryarr);
			$cwcount = $cwmodel->getfolderseccoursecount($queryarr);
			
		}
		if(!empty($cwflist)){//查询课程下课件数
			$foldernumarr = $this->getfoldernum(array_column($cwflist,'folderid'),true);
			$this->assign('foldernumarr',$foldernumarr);
		}
		$cwlist = array();
		$viewnumlib = Ebh::app()->lib('Viewnum');
		if(!empty($cwflist)){
			foreach($cwflist as $cw){//以cwid为下标,从缓存加入人气字段
				$viewnum = $viewnumlib->getViewnum('courseware',$cw['cwid']);
				if(!empty($viewnum))
					$cw['viewnum'] = $viewnum;
				$cwlist[$cw['cwid']] = $cw;
			}
		}
		//学习进度
		if(!empty($cwids)){
			$progresslist = $this->model('progress')->getFolderProgressByCwid(array('cwid'=>$cwids,'uid'=>$user['uid']));
			foreach($progresslist as $progress){
				if(isset($cwlist[$progress['cwid']]))
					$cwlist[$progress['cwid']]['percent'] = $progress['percent'];
			}
		}
		$this->assign('my',true);
	}
	
	/*
	单课收费的详情
	*/
	public function getcwpaydetail(){
		$cwid = $this->input->get('cwid');
		$cwdetail = $this->model('courseware')->getcwpay($cwid);
		if(!empty($cwdetail)){
			getcwlogo($cwdetail,$playimg,$cwdetail['showimg']);
			if(strstr($cwdetail['showimg'],'kustgd2.png'))
				$cwdetail['showimg'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png';
			$cwdetail['iname'] = $cwdetail['title'];
			echo json_encode($cwdetail);
		}
	}
	/*
	单课收费,获取课程下的课件数
	*/
	private function getfoldernum($folderidarr,$my = false){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$folderids = implode(',',$folderidarr);
		$param['folderids'] = $folderids;
		$param['uid'] = $user['uid'];
		$param['my'] = $my;
		$param['crid'] = $roominfo['crid'];
		$foldernumarr = $this->model('courseware')->getFolderCwpayCount($param);
		$farr = array();
		foreach($foldernumarr as $folder){
			$farr[$folder['folderid']] = $folder['count'];
		}
		return $farr;
		// var_dump($foldernumarr);
	}

    /**
     * 需要填写问卷ID
     * @param $crid
     * @param $user
     * @return bool
     */
    private function _need_survery($crid, $user) {
        $otherconfig = Ebh::app()->getConfig()->load('othersetting');
        if (!empty($otherconfig['survey_crids']) && is_array($otherconfig['survey_crids']) && in_array($crid, $otherconfig['survey_crids'])) {
            $survey_model = $this->model('Survey');
            $survey_id = $survey_model->getSurveyIdBeforeBuy($crid);
            if (empty($survey_id)) {
                return false;
            }
            if (empty($user)) {
                return $survey_id;
            }
            if ($user['groupid'] == 5) {
                return false;
            }
            $answered = $survey_model->answered($survey_id, $user['uid']);
            if (!$answered) {
                return $survey_id;
            }
        }
        return false;
    }
	
	/*
	 *积分列表
	 */
	private function getCreditList($uid,$crid,$more){
		$credit = $this->model('credit');
		$param['pagesize'] = empty($more)?20:200;
		$param['toid'] = $uid;
		// $param['crid'] = $crid;
		$creditlist = $credit->getcreditlist($param);
		$creditarr = array();
		$today = Date('Y-m-d',SYSTIME);
		foreach($creditlist as $credit){
			$date = Date('Y-m-d',$credit['dateline']);
			$credit['date'] = ($date == $today) ? '今天':($date == date('Y-m-d',strtotime($today)-86400) ? '昨天':$date);
			$creditarr[$date][] = $credit;
		}
		// var_dump($creditarr);
		$this->assign('creditlist',$creditarr);
	}
	
	
	/*
	学习信息加入folders数组中
	*/
	private function studyinfo_old(&$folders=array(),$coursewarelist,$param,$roominfo,$user,$folderids,$foldertype = 'folders',&$spfolders=array()){
		$pmodel = $this->model('progress');
		$foldermodel = $this->model('folder');
		$cwids = '';
				//cwid=>folderid对应数组
				$cwidfolderidlist =array();
				$countlist = $pmodel->getFolderProgressCountByFolderid($param);
				foreach($countlist as $f){
					$foldercwcount[$f['folderid']] = $f['count'];
				}
				foreach($coursewarelist as $cw){
					$cwids.= $cw['cwid'].',';
					$cwidfolderidlist[$cw['cwid']] = $cw['folderid'];
				}
				// var_dump($cwidfolderidlist);
				$cwids = rtrim($cwids,',');
				$param['cwid'] = $cwids;
				$param['uid'] = $user['uid'];
				
				//根据cwid获取进度,添加到对应 课程进度 数组中
				$folderprogress = array();
				$other_config = Ebh::app()->getConfig()->load('othersetting');
				$is_zjdlr = !empty($other_config['zjdlr']) && $other_config['zjdlr'] == $roominfo['crid'];
				if($is_zjdlr){//国土资源的，获取进度按累计时长
					$progresslist = $pmodel->getFolderProgressByCwid_cwsum($param);
				}else{//其他按最长一次听课时间
					$progresslist = $pmodel->getFolderProgressByCwid($param);
				}
				// var_dump($cwidfolderidlist);
				foreach($progresslist as $p){
					$folderid = $cwidfolderidlist[$p['cwid']];
					if($p['percent']*100>=90){
						$folderprogress[$folderid][] = 100;
						// var_dump($p);
						if(empty($foldercredit[$folderid]['study'])){//听课完成的数量
							$foldercredit[$folderid]['study'] = 1;
							
						}
						else
							$foldercredit[$folderid]['study'] += 1;
					}
					else
						$folderprogress[$folderid][] = $p['percent']*100;
				}
				//根据cwid获取听课时长总合,添加到对应 课程时长 数组中
				$foldersumtime = array();
				$sumtimelist = $pmodel->getCourseSumTime($param);
				foreach($sumtimelist as $s){
					$folderid = $cwidfolderidlist[$s['cwid']];
					if(empty($foldersumtime[$folderid]))
						$foldersumtime[$folderid] = $s['sumtime'];
					else
						$foldersumtime[$folderid] += $s['sumtime'];
				}
				// var_dump($folderprogress);
				// exit;
				
				//作业完成情况
				$examcreditlist = $foldermodel->getUserFolderExamCredit(array('uid'=>$user['uid'],'folderid'=>$folderids));
				foreach($examcreditlist as $examcredit){
					$folderid = $examcredit['folderid'];
					if(empty($foldercredit[$folderid]['exam']))
						$foldercredit[$folderid]['exam'] = $examcredit['examcredit'];
					else
						$foldercredit[$folderid]['exam'] += $examcredit['examcredit'];
				}
				//作业总数
				$countlist = $foldermodel->getFolderExamCount(array('folderid'=>$folderids));
				// var_dump($countlist);
				foreach($countlist as $f){
					$folderexamcount[$f['folderid']] = $f['count'];
				}

				//课程进度数组计算结果记录到课程列表的进度字段
				if($roominfo['isschool'] != 7 && !empty($folders)){
					foreach($folders as $k=>$folder){
						$folderid = $folder['folderid'];
						if(!empty($folderprogress[$folderid])){
							$folders[$k]['percent'] = floor(array_sum($folderprogress[$folderid])/$foldercwcount[$folderid]);
							if(empty($foldercwcount[$folderid])){
								$folders[$k]['studyfinishpercent'] = 0;
							}else{
								$fscredit = empty($foldercredit[$folderid]['study'])?0:$foldercredit[$folderid]['study'];
								$folders[$k]['studyfinishpercent'] = $fscredit/$foldercwcount[$folderid];
							}
							if(empty($folderexamcount[$folderid])){
								$folders[$k]['examscorepercent'] = 0;
							}else{
								$fecredit = empty($foldercredit[$folderid]['exam'])?0:$foldercredit[$folderid]['exam'];
								$folders[$k]['examscorepercent'] = $fecredit/$folderexamcount[$folderid];
							}
							
							if(empty($folder['creditrule'])){
								$creditrule[0] = 100;
								$creditrule[1] = 0;
							}else{
								$creditrule = explode(':',$folder['creditrule']);
							}
							// var_dump($creditrule);
							$folders[$k]['creditget'] = round($folder['credit']*($creditrule[0]*$folders[$k]['studyfinishpercent']+$creditrule[1]*$folders[$k]['examscorepercent'])/100,2);
							
						}
						else{
							$folders[$k]['percent'] = 0;
							$folders[$k]['creditget'] = 0;
						}
						
						if(!empty($foldersumtime[$folderid])){
							$folders[$k]['sumtime'] = $foldersumtime[$folderid];
						}else{
							$folders[$k]['sumtime'] = 0;
						}
						
					}
				}
				$f = $$foldertype;
				if(($foldertype =='folders' && $roominfo['isschool']==7) || ($foldertype=='spfolders'&&!empty($$foldertype))){
					foreach($f as $k=>$package){
						foreach($package['itemlist'] as $l=>$folder){
							$folderid = $folder['folderid'];
							if(!empty($folderprogress[$folderid])){
								$f[$k]['itemlist'][$l]['percent'] = floor(array_sum($folderprogress[$folderid])/$foldercwcount[$folderid]);
								if(empty($foldercwcount[$folderid])){
									$f[$k]['itemlist'][$l]['studyfinishpercent'] = 0;
								}else{
									$fscredit = empty($foldercredit[$folderid]['study'])?0:$foldercredit[$folderid]['study'];
									$f[$k]['itemlist'][$l]['studyfinishpercent'] = $fscredit/$foldercwcount[$folderid];
								}
								if(empty($folderexamcount[$folderid])){
									$f[$k]['itemlist'][$l]['examscorepercent'] = 0;
								}else{
									$fecredit = empty($foldercredit[$folderid]['exam'])?0:$foldercredit[$folderid]['exam'];
									$f[$k]['itemlist'][$l]['examscorepercent'] = $fecredit/$folderexamcount[$folderid];
								}
								
								if(empty($folder['creditrule'])){
									$creditrule[0] = 100;
									$creditrule[1] = 0;
								}else{
									$creditrule = explode(':',$folder['creditrule']);
								}
								// var_dump($creditrule);
								
								$f[$k]['itemlist'][$l]['creditget'] = round($folder['credit']*($creditrule[0]*$f[$k]['itemlist'][$l]['studyfinishpercent']+$creditrule[1]*$f[$k]['itemlist'][$l]['examscorepercent'])/100,2);
								
							}
							else{
								$f[$k]['itemlist'][$l]['percent'] = 0;
								$f[$k]['itemlist'][$l]['creditget'] = 0;
							}
							
							if(!empty($foldersumtime[$folderid])){
								$f[$k]['itemlist'][$l]['sumtime'] = $foldersumtime[$folderid];
							}else{
								$f[$k]['itemlist'][$l]['sumtime'] = 0;
							}
						}
					}
				}
				if($foldertype == 'folders')
					$folders = $f;
				elseif($foldertype == 'spfolders')
					$spfolders = $f;
				
	}

    /****
     * 获取学习进度和学习资源比例
     * @return mixed
     */
    private function getProgressAndRate($uid,$crid){

        $res =  Ebh::app()
            ->getApiServer('ebh')
            ->reSetting()
            ->setService('Study.Center.getProgressAndRate')
            ->addParams('uid',$uid)
            ->addParams('crid',$crid)
            ->request();
        return $res;

	}

    /**
     * 加载学习进度模板
     */
    public function studyProgress()
    {
    	//获取modulename 标题名称
        $mnlib = Ebh::app()->lib('Modulename');
        $roominfo = Ebh::app()->room->getcurroom();
        $mnlib->getmodulename($this,array('modulecode'=>'study','tors'=>0,'crid'=>$roominfo['crid']));
        $this->display('college/studyProgress');
    }
    /***
     * 获取学习进度和学习资源比例
     *
     */
    public function getProgressAndRatetoJson()
    {
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $res =  Ebh::app()
            ->getApiServer('ebh')
            ->reSetting()
            ->setService('Study.Center.getProgressAndRate')
            ->addParams('uid',$user['uid'])
            ->addParams('crid',$roominfo['crid'])
            ->request();
        if($res == false){
            renderjson(1,'服务器繁忙,请稍后再试');
        }else{
            $res['realName'] = $user['realname']?$user['realname']:$user['username'];
            renderjson(0,'获取成功',$res);
        }
    }

    /**
     *修改国土的课程学分总分，获得非视频课word课程id
     *国土课程学分之前等于最高的设置的分数，改为课件总数乘以单课件得分
     */
    public function modifyZjdrSchoolScore($folders,$roominfo,$folderids) {
    	//获取国土的网校配置
    	$appsetting = Ebh::app()->getConfig()->load('othersetting');
		$appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
		$appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
		$is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
		$is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);
		if ($is_zjdlr || $is_newzjdlr) {//国土网校则执行
			//获取所有的课程的课件
			$cwlist = $this->model('Roomcourse')->getCwlistByFolderids($folderids,$roominfo['crid']);
			$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov');//视频课的课件文件名
			if(!empty($cwlist)) {
				//获取学分的配置
				$systemsetting = Ebh::app()->room->getSystemSetting();//获取系统学分设置
        		$creditrule = json_decode($systemsetting['creditrule'],true);
        		$noteScore = $creditrule['notvideo']['single'];//非视频课的单课分数
        		//考虑到国土课程比较少，循环覆盖修改之前已经有的学分
        		foreach ($cwlist as $cvalue) {
        			$cwlist_map[$cvalue['folderid']] = $cvalue;
        		}
        		foreach ($folders as &$fvalue) {
        			if (isset($cwlist_map[$fvalue['folderid']])) {
        				if (in_array(substr(strrchr($cwlist_map[$fvalue['folderid']]['cwurl'], '.'), 1),$mediatype)) {//此处判断是否视频课
							$fvalue['credit'] = sprintf('%.1f', (float)$fvalue['cwpercredit']*$fvalue['coursewarenum']);//改为课件总数乘以单课件得分
						} else if (!empty($cwlist_map[$fvalue['folderid']]['cwurl'])) {
							$fvalue['credit'] = sprintf('%.1f', (float)$noteScore*$fvalue['coursewarenum']);////改为课件总数乘以单课件得分
							$this->zjdlr_word_folderid .= $fvalue['folderid'].',';//非视频课记录id，为了之后构造非视频课学习分数
						}
        			}
        		}
			}
		}
		return $folders;
    }
}