<?php
/*
课程
*/
class CourseController extends ARoomV3Controller{
	/*
	课程分类
	*/
	public function courseSort(){
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		//$data['showbysort'] = $this->input->get('showbysort');
		$splist = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.spList')->addParams($data)->request();
		$pids = implode(',',array_keys($splist));
		$data['pids'] = $pids;
		$sortlist = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.sortList')->addParams($data)->request();
		$isstats = $this->input->get('isstats');
		$childrenname = empty($isstats)?'sorts':'children';
		foreach($sortlist as $sort){
			$pid = $sort['pid'];
			if(isset($splist[$pid][$childrenname])){
				$splist[$pid][$childrenname][] = $sort;
			} else {
				$splist[$pid][$childrenname] = array($sort);
			}
		}
		$this->renderjson(0,'',array_values($splist));
	}
	
	
	/*
	添加服务包
	*/
	public function addSp(){
		$data['pname'] = $this->input->post('pname');
		if(trim($data['pname']) == ''){
			$this->renderjson(1,'名称不能为空');
		}
			
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.spNameCheck')->addParams($data)->request();
		
		if(!empty($result)){
			$this->renderjson(1,'已有该分类名称');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.addSp')->addParams($data)->request();
		
		if($result !== FALSE){
			updateRoomCache($this->roominfo['crid'],'paypackage');
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	添加分类
	*/
	public function addSort(){
		$data['sname'] = $this->input->post('sname');
		if(trim($data['sname']) == ''){
			$this->renderjson(1,'名称不能为空');
		}
		$data['pid'] = $this->input->post('pid');
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.sortNameCheck')->addParams($data)->request();
		if(!empty($result)){
			$this->renderjson(1,'已有该分类名称');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.addSort')->addParams($data)->request();
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	保存服务包名称
	*/
	public function saveSpName(){
		$data['pid'] = $this->input->post('pid');
		$data['pname'] = $this->input->post('pname');
		if(trim($data['pname']) == ''){
			$this->renderjson(1,'名称不能为空');
		}
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.spNameCheck')->addParams($data)->request();
		
		if(!empty($result) && $result['pid'] != $data['pid']){
			$this->renderjson(1,'已有该分类名称');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.saveSpName')->addParams($data)->request();
		if($result !== FALSE){
			updateRoomCache($this->roominfo['crid'],'paypackage');
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	保存服务包名称
	*/
	public function saveSortName(){
		$data['pid'] = $this->input->post('pid');
		$data['sid'] = $this->input->post('sid');
		$data['sname'] = $this->input->post('sname');
		if(trim($data['sname']) == ''){
			$this->renderjson(1,'名称不能为空');
		}
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.sortNameCheck')->addParams($data)->request();
		
		if(!empty($result) && $result['sid'] != $data['sid']){
			$this->renderjson(1,'已有该分类名称');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.saveSortName')->addParams($data)->request();
		
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/**
	 * 更改服务包的排序
	 */
	public function changeSpOrder() {
		$data['pid'] = $this->input->post('pid');
		$data['isup'] = $this->input->post('isup');
	
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.changeSpOrder')->addParams($data)->request();
		updateRoomCache($this->roominfo['crid'],'paypackage');
		$this->renderjson(0,'',$result);
		
	}

	/**
	 * 更改服务包下分类的排序
	 */
	public function changeSortOrder() {
		$data['pid'] = $this->input->post('pid');
		$data['sid'] = $this->input->post('sid');
		$data['isup'] = $this->input->post('isup');
		
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.changeSortOrder')->addParams($data)->request();
		$this->renderjson(0,'',$result);
	}
	
	
	/*
	删除服务包
	*/
	public function deleteSp(){
		$data['pid'] = $this->input->post('pid');
		
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.deleteSp')->addParams($data)->request();
		updateRoomCache($this->roominfo['crid'],'paypackage');
		$this->renderjson(0,'',$result);
	}
	
	/*
	删除分类
	*/
	public function deleteSort(){
		$data['pid'] = $this->input->post('pid');
		$data['sid'] = $this->input->post('sid');
		
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.deleteSort')->addParams($data)->request();
		$this->renderjson(0,'',$result);
	}
	
	/*
	课程列表
	*/
	public function courseList(){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        $q = $this->input->get('q');
        $unfit = $this->input->get('unfit');//查询其他课程（无效的数据）
        $page = empty($page)?1:$page;

        $pagesize = empty($pagesize)?20:$pagesize;
        $data['q'] = isset($q) ? htmlspecialchars($q) : '';
        $data['crid'] = $this->roominfo['crid'];
        $data['starttime'] = $this->input->get('starttime');
        $data['endtime'] = $this->input->get('endtime');
        $orderBy = $this->input->get('orderBy');
        $orderBy = intval($orderBy);
		$needoc = $this->input->get('needoc');//是否查询开通人数
        if(empty($unfit)){//正常数据
            $pid = $this->input->get('pid');
            $sid = $this->input->get('sid');
            /*$this->roominfo['pid'] = empty($pid)?'':$pid;
            $this->roominfo['sid'] = empty($sid)?'':$sid;*/
            $this->roominfo['pid'] = intval($pid);
            if ($pid > 0 && $sid !== null) {
                $this->roominfo['sid'] = intval($sid);
            }
            $data['uid'] = $this->user['uid'];
            $data['roominfo'] = $this->roominfo;
            $data['issimple'] = $this->input->get('issimple');
            $data['page']     = 1;
            $data['pagesize'] = 100000;

            $isbytime = $this->input->get('isbytime');
            $totalcourselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseList')->addParams($data)->request();
        } else {//无效数据
            $totalcourselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.unfitCourseList')->addParams($data)->request();
        }
        $courselist = $totalcourselist['courselist'];
        if(!empty($courselist)){
            $folderids = array_column($courselist,'folderid');
            $folderids = implode(',',$folderids);
			$itemids = array_column($courselist,'itemid');
			$itemids = implode(',',$itemids);
        }
        if(!empty($folderids) && empty($data['issimple'])){
            $dataf['folderids'] = $folderids;
            $dataf['crid'] = $this->roominfo['crid'];
            $courseteacherlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseTeacherList')->addParams($dataf)->request();
            foreach ($courseteacherlist as &$v){
                if(empty($v['face'])){
                    $v['face'] = $v['sex']==0?'http://static.ebanhui.com/ebh/tpl/default/images/t_man_50_50.jpg':'http://static.ebanhui.com/ebh/tpl/default/images/t_woman_50_50.jpg';
                }
            }
            $courselength = $this->apiServer->reSetting()->setService('Aroomv3.Course.getFolderidMsg')->addParams($dataf)->request();


            $course = array();
            //处理课程拥有的教师
            foreach($courseteacherlist as $ct){
                if(empty($course[$ct['folderid']])){
                    $course[$ct['folderid']] = array($ct);
                }else{
                    $course[$ct['folderid']][]= $ct;
                }
            }
            //课件数量
            $datacw['crid'] = $this->roominfo['crid'];
            $datacw['folderid'] = $folderids;
            $datacw['needgroup'] = 1;
            $datacw['starttime'] = $data['starttime'];
            $datacw['endtime'] = $data['endtime'];
            $cwcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwCount')->addParams($datacw)->request();

            //获取课程的学习总人数，学习总人次，学习总时长
            $dataf['starttime'] = $data['starttime'];
            $dataf['endtime'] = $data['endtime'];
            $studylist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyList')->addParams($dataf)->request();
            $isbytime =  true;//开启查询点赞和评论
            //评论数,点赞数,查询导出页面用
            if(!empty($isbytime)){
                $dataf['folderid'] = $folderids;
                $reviewcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.reviewCount')->addParams($dataf)->request();
                $zancountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.zanCount')->addParams($dataf)->request();
            }
			//查询课程开通人数
			if(!empty($itemids) && !empty($needoc)){
				$ocdata['itemid'] = $itemids;
				$ocdata['crid'] = $this->roominfo['crid'];
				$ocdata['islist'] = TRUE;
				$opencount = $this->apiServer->reSetting()->setService('Classroom.Item.openCount')->addParams($ocdata)->request();
			}
            $tempcount = !empty($courselist) ? count($courselist) : 0;
            for($i=0;$i<$tempcount;$i++){
                $folderid = $courselist[$i]['folderid'];

                $courselist[$i]['cwlength'] = !empty($courselength[$folderid]['cwlength']) ? $courselength[$folderid]['cwlength'] : 0;

                $courselist[$i]['credit'] = !empty($courselength[$folderid]['credit'])&&$courselength[$folderid]['credit']>0 ? $courselength[$folderid]['credit'] : 0;


                $courselist[$i]['teachers'] = isset($course[$folderid]) ? $course[$folderid] : array();

                $courselist[$i]['studynum'] = !empty($studylist[$folderid]) ? $studylist[$folderid]['count'] : 0;

                $courselist[$i]['coursewarenum'] = !empty($cwcountlist[$folderid]) ? $cwcountlist[$folderid]['count'] : 0;

                $courselist[$i]['usernum'] = !empty($studylist[$folderid]['usernum'])?$studylist[$folderid]['usernum']:0;
                $courselist[$i]['ltimetotal'] = !empty($studylist[$folderid]['ltimetotal'])?$studylist[$folderid]['ltimetotal']:0;


                $courselist[$i]['reviewnum'] = !empty($reviewcountlist[$folderid]) ? $reviewcountlist[$folderid]['count'] : 0;
                $courselist[$i]['zannum']    = !empty($zancountlist[$folderid]) ? $zancountlist[$folderid]['count'] : 0;

                $courselist[$i]['fprice'] = (empty($courselist[$i]['fprice']) || $courselist[$i]['fprice'] == 0) ? 0 : 1;
				
				$itemid = empty($courselist[$i]['itemid'])?0:$courselist[$i]['itemid'];
				if(isset($opencount) && !empty($itemid)){
					$courselist[$i]['opencount'] = empty($opencount[$itemid])?0:$opencount[$itemid]['opencount'];
				}
            }

        }
        //排序处理
        switch ($orderBy){
            case 1:
                $orderBy = array('credit','SORT_DESC');


                break;
            case 2:
                $orderBy = array('credit','SORT_ASC');

                break;
            case 3:
                $orderBy = array('cwlength','SORT_DESC');

                break;
            case 4:
                $orderBy = array('cwlength','SORT_ASC');

                break;
            case 5:
                $orderBy = array('studynum','SORT_DESC');

                break;
            case 6:
                $orderBy = array('studynum','SORT_ASC');


                break;
            case 7:
                $orderBy = array('zannum','SORT_DESC');

                break;
            case 8:
                $orderBy = array('zannum','SORT_ASC');

                break;
            case 9:
                $orderBy = array('reviewnum','SORT_DESC');

                break;
            case 10:
                $orderBy = array('reviewnum','SORT_ASC');

                break;
            case 11:
                $orderBy = array('iprice','SORT_DESC');


                break;
            case 12:
                $orderBy = array('iprice','SORT_ASC');

                break;
            case 13:
                $orderBy = array('coursewarenum','SORT_DESC');


                break;
            case 14:
                $orderBy = array('coursewarenum','SORT_ASC');

                break;


        }
        if(is_array($orderBy) && $courselist){//排序
            $courselist =  arraySequence($courselist,$orderBy[0],$orderBy[1]);
        }
        $totalcourselist['coursecount'] = count($courselist);
        //分页处理
        if(!empty($courselist)){
            $start = ($page-1)*$pagesize;//计算开始下标
            $end   = $start+$pagesize-1;
            foreach ($courselist as $key=>$item) {
                if($key < $start || $key>$end){
                    unset($courselist[$key]);
                }
            }
        }
        sort($courselist);
        $totalcourselist['courselist'] = $courselist;
        if (!empty($totalcourselist['courselist']) && $this->roominfo['template'] == 'plate') {
            array_walk($totalcourselist['courselist'], function(&$course) {
                $course['img'] = show_plate_course_cover($course['img']);
                if(!empty($course['img']))
                $course['cover'] = preg_replace('/_\d+_\d+/', '', $course['img']);
				if(!empty($course['cwlength'])){
					$course['cwlength'] = getTimeToString($course['cwlength']);
				}
                if (empty($course['img'])) {
                    $course['img'] = '';
                    $course['cover'] = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
                    return;
                }
                if (strpos($course['img'], 'course_cover_default') !== false) {
                    $course['cover'] = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
                    return;
                }
            });

        }else{
            if (!empty($totalcourselist['courselist'])) {
                array_walk($totalcourselist['courselist'], function(&$course) {
                    $course['cover'] = preg_replace('/_\d+_\d+/', '', $course['img']);
					if(!empty($course['cwlength'])){
						$course['cwlength'] = getTimeToString($course['cwlength']);
					}
                    if (empty($course['img'])) {
                        $course['img'] = '';
                        $course['cover'] = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
                        return;
                    }
                    $course['img'] = show_plate_course_cover($course['img']);
                    if (strpos($course['img'], 'course_cover_default') !== false) {
                        $course['cover'] = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
                        return;
                    }
                });
            }
        }
        $this->renderjson(0,'',$totalcourselist);
	}
	
	/*
	课程选择老师
	*/
	public function chooseTeacher(){
		$data['tids'] = $this->input->post('tids');
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['folderid'] = $this->input->post('folderid');
		if(empty($data['folderid'])){
			$this->renderjson(1,'参数错误');
		}
			
		if(!empty($data['tids'])){
			$tidarr = $this->apiServer->reSetting()->setService('Aroomv3.Course.filterTeacher')->addParams($data)->request();
			// var_dump($data);
			$data['tids'] = implode(',',$tidarr);
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Course.chooseTeacher')->addParams($data)->request();
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
		
		/**写日志开始**/
		// fastcgi_finish_request();
		// $message = '将教师 [ '.$param['teacherids'].' ] 设置为课程教师';
		// Ebh::app()->lib('LogUtil')->add(
			// array(
				// 'toid'=>$param['folderid'],
				// 'message'=>$message,
				// 'opid'=>2,
				// 'type'=>'folder'
				// )
		// );
		/**写日志结束**/
	}
	/*
	课程详情
	*/
	public function courseDetail(){
		$data['folderid'] = $this->input->get('folderid');
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['roominfo'] = $this->roominfo;
		$coursedetail = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseDetail')->addParams($data)->request();
		if(!empty($coursedetail)){
			$coursedetail['isschool'] = $this->roominfo['isschool'];
			$coursedetail['remindarr'] = array();
			if(!empty($coursedetail['remindmsg'])){ //课程提醒
				$remindmsg = explode('#',$coursedetail['remindmsg']);
				$remindtime = explode(',',$coursedetail['remindtime']);
				foreach($remindmsg as $k=>$rmsg){
					$coursedetail['remindarr'][] = array('remindmsg'=>$rmsg,'remindtime'=>$remindtime[$k]/60);
				}
			}
			$coursedetail['fprice'] = $coursedetail['fprice']==0?0:1;
			$coursedetail['credittime'] = intval($coursedetail['credittime']/60);
			if(!empty($coursedetail['introduce'])){//课程介绍
				$coursedetail['introduce'] = unserialize($coursedetail['introduce']);
			} 
			if(empty($coursedetail['introduce'])){
				$coursedetail['introduce'] = array();
			}
		}
		if(!empty($coursedetail) || $this->roominfo['isschool'] == 7){//加入服务项信息
			$payitem = $this->apiServer->reSetting()->setService('Aroomv3.Course.payitemDetail')->addParams($data)->request();
			if(!empty($payitem)){
				$coursedetail = array_merge($coursedetail,$payitem);
				$coursedetail['summary'] = $coursedetail['isummary'];
				$coursedetail['foldername'] = $coursedetail['iname'];
			}
		}
		$this->renderjson(0,'',$coursedetail);
	}
	/*
	编辑课程
	*/
	public function edit(){
		$data = $this->input->post('data');
		if(empty($data))
			$data = $this->input->post();
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['roominfo'] = $this->roominfo;
		if (Ebh::app()->room->getRoomType() == 'com') {
            unset($data['targets']);
        }

        $payiteminfo = $this->apiServer->reSetting()
            ->setService('Aroomv3.Course.payitemDetail')
            ->addParams(array('crid'=>$data['crid'],'folderid'=>$data['folderid']))->request();
        $folder = $result = $this->apiServer->reSetting()->setService('Classroom.Folder.getFolderById')->addParams($data)->request();
		
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Course.edit')->addParams($data)->request();
		
        if($result !== FALSE){
            $redis = Ebh::app()->getCache('cache_redis');
            $redis->del('ebh_plate-platform-'.$this->roominfo['crid']);
            $this->renderjson(0,'操作成功',array(),false);
            fastcgi_finish_request();	//操作成功，则直接返回前端输出
            $param = array();
            $param['toid'] = !empty($data['folderid']) ? intval($data['folderid']) : 0;
            $param['foldernameold'] = !empty($payiteminfo['iname']) ? $payiteminfo['iname'] : (!empty($folder['foldername']) ? $folder['foldername'] : '');
            $param['foldername'] = !empty($data['foldername']) ? h($data['foldername']) : '';
            $param['ipriceold'] = isset($payiteminfo['iprice']) ? intval($payiteminfo['iprice']) : 0;
            $param['iprice'] = !empty($data['fprice']) ? intval($data['iprice']) : 0;
            if(($param['ipriceold'] != $param['iprice']) || ($param['foldernameold'] != $param['foldername'])){
                Ebh::app()->lib('OperationLog')->addLog($param,'editcourse');//操作成功记录到操作日志
            }
			if(!empty($result['folderid'])){
				$result = $this->apiServer->reSetting()->setService('Aroomv3.Course.doStudyCredit')->addParams(array('folderid'=>$result['folderid'],'crid'=>$data['crid']))->request();
			}
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	/*
	开设课程
	*/
	public function add(){
		$data = $this->input->post('data');
		if(empty($data))
			$data = $this->input->post();
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['roominfo'] = $this->roominfo;
        if (Ebh::app()->room->getRoomType() == 'com') {
            unset($data['targets']);
        }
		
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Course.add')->addParams($data)->request();
		
        if($result !== FALSE){
            $redis = Ebh::app()->getCache('cache_redis');
            $redis->del('ebh_plate-platform-'.$this->roominfo['crid']);
            $this->renderjson(0,'操作成功',array(),false);
            fastcgi_finish_request();	//操作成功，则直接返回前端输出
            $data['toid'] = $result;
            Ebh::app()->lib('OperationLog')->addLog($data,'addcourse');//操作成功记录到操作日志
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	
	
	
	/*
	课程介绍保存
	*/
	public function introduceSave(){
		$data['folderid'] = intval($this->input->post('folderid'));
		$data['introduce'] = serialize($this->input->post('introducearr'));
		$data['crid'] = $this->roominfo['crid'];
		if(empty($data['folderid'])) {
			$this->renderjson(1,'参数不正确');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Course.introduceSave')->addParams($data)->request();
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	查看课件列表
	*/
	public function cwList(){
        $data['folderid'] = intval($this->input->get('folderid'));
        if(empty($data['folderid'])){
            $this->renderjson(0,'参数错误');
        }
        $issimple = $this->input->get('issimple');
        $data['crid'] = $this->roominfo['crid'];
        $crid = intval($this->input->get('crid'));
        if ($crid > 0) {
            $data['crid'] = $crid;
        }
        $sourceid = $this->input->get('sourceid');
        $s = trim($this->input->get('s'));
        if(!empty($sourceid)){//检查企业选课信息
            $data['sourceid'] = $sourceid;
            $selitems = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.selItems')->addParams($data)->request();
            $folderids = array_column($selitems,'folderid');
            foreach($selitems as $item){
                $scrid = $item['crid'];
                $sourcecrid = $item['sourcecrid'];
                break;
            }
            if(!empty($selitems) && $scrid == $data['crid'] && in_array($data['folderid'],$folderids)){
                $data['crid'] = $sourcecrid;//符合条件,将crid设为来源的crid
            } else {
                $this->renderjson(0,'',array('cwlist'=>array(),'cwcount'=>0));
            }
        }
        if(empty($issimple)){//获取章节目录
            $sectionlist = $this->apiServer->reSetting()->setService('Aroomv3.Section.sectionList')->addParams($data)->request();
            $sectionlist[] = array('sid'=>0,'sname'=>'其他');
            foreach($sectionlist as $section){
                $sectionarr[$section['sid']] = $section;
            }
        }
        $pagesize = intval($this->input->get('pagesize'));
        $page = intval($this->input->get('page'));
        $data['page'] = empty($page)?0:$page;
        $data['pagesize'] = empty($issimple)?(empty($pagesize)?20:$pagesize):1000;
        $data['videoonly'] = $this->input->get('videoonly');//只列出视频课件，ism3u8=1
        $orderBy           = $this->input->request('orderBy');
        $orderBy           = intval($orderBy);
        $sid = $this->input->get('sid');
        if (!empty($s)) {
            $data['s'] = $s;
        }
        if ($sid !== null && $sid != '') {
            $data['sid'] = $sid;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwList')->addParams($data)->request();
        $cwids = array_column($result['cwlist'],'cwid');
        if(!empty($cwids)){
            //获取课件的评论，人气，价格
            $params['cwids'] = implode(',', $cwids);
            $cw_list         = $this->apiServer->reSetting()->setService('Aroomv3.Course.getCoursesMsg')->addParams($params)->request();
        }
        //加入老师信息
        if(!empty($result['cwlist']) && empty($issimple)){
            $uidarr = array_column($result['cwlist'],'uid');
            $udata = array('uids'=>implode(',',$uidarr));

            $teacherarr = $this->apiServer->reSetting()->setService('Aroomv3.Course.teacherList')->addParams($udata)->request();
            // var_dump($teacherarr);
            $redis = Ebh::app()->getCache('cache_redis');
            foreach($result['cwlist'] as $k=>&$cw){
                $uid = $cw['uid'];
                $cw['price'] = isset($cw_list[$cw['cwid']]) ? $cw_list[$cw['cwid']]['price'] : 0;
                //$cw['viewnum'] = isset($cw_list[$cw['cwid']]) ? $cw_list[$cw['cwid']]['viewnum'] : 0;
                $cw['cwlength'] = isset($cw_list[$cw['cwid']]) ? $cw_list[$cw['cwid']]['cwlength'] : 0;//
                $cw['reviewnum'] = isset($cw_list[$cw['cwid']]) ? $cw_list[$cw['cwid']]['reviewnum'] : 0;
                $cw['cmonth'] = isset($cw_list[$cw['cwid']]) ? $cw_list[$cw['cwid']]['cmonth'] : 0;
                $cw['cday'] = isset($cw_list[$cw['cwid']]) ? $cw_list[$cw['cwid']]['cday'] : 0;
                //$cw['zanNum'] = isset($cw_list[$cw['cwid']]) ? $cw_list[$cw['cwid']]['zanNum'] : 0;
                $cw['creditnum'] = isset($cw_list[$cw['cwid']]) ? $cw_list[$cw['cwid']]['creditnum'] : 0;
                if(isset($teacherarr[$uid])){
                    $result['cwlist'][$k]['user'] = $teacherarr[$uid];
                }
                $viewnum = $redis->hget('coursewareviewnum',$cw['cwid']);
                if(!empty($viewnum)){
                    $cw['viewnum'] = $viewnum;
                }
                $arr = explode('.',$cw['cwurl']);
                $type = $arr[count($arr)-1];
                $result['cwlist'][$k]['type'] = $type;


                if(!empty($sectionarr[$cw['sid']])){
                    $sectionarr[$cw['sid']]['cwlist'][] = $result['cwlist'][$k];
                } else {
                    $sectionarr[0]['cwlist'][] = $result['cwlist'][$k];
                }
            }

        }

        if(empty($issimple)){
            foreach($sectionarr as $k=>$section){
                if(empty($section['cwlist'])){
                    unset($sectionarr[$k]);
                }
            }
            $cwlist = array_values($sectionarr);
        } else {
            $cwlist = $result;
        }
        if ($sid !== null && $sid != '') {
            foreach ($cwlist as $k => $item) {
                if ($item['sid'] != $sid) {
                    unset($cwlist[$k]['cwlist']);
                }
            }
        }


        /**处理排序
         * 1 时长高到低
         * 2 时长低到高
         * 3 学习次数高到低
         * 4 学习次数低到高
         * 5 点赞数高到低
         * 6 点赞数低到高
         * 7 评论数高到低
         * 8 评论数低到高
         * 9 课件售价高到低
         * 10 课件售价低到高
         */

        switch ($orderBy){
            case 1:
                $orderBy = array('cwlength','SORT_DESC');
                break;
            case 2:
                $orderBy = array('cwlength','SORT_ASC');
                break;
            case 3:
                $orderBy = array('creditnum','SORT_DESC');

                break;
            case 4:
                $orderBy = array('creditnum','SORT_ASC');
                break;
            case 5:
                $orderBy = array('zannum','SORT_DESC');
                break;
            case 6:
                $orderBy = array('zannum','SORT_ASC');
                break;
            case 7:
                $orderBy = array('reviewnum','SORT_DESC');
                break;
            case 8:
                $orderBy = array('reviewnum','SORT_ASC');
                break;
            case 9:
                $orderBy = array('price','SORT_DESC');
                break;
            case 10:
                $orderBy = array('price','SORT_ASC');
                break;


        }
        foreach ($cwlist as &$item) {

            if(isset($item['cwlist']) && is_array($item['cwlist']) && is_array($orderBy)){
                $item['cwlist'] = arraySequence($item['cwlist'],$orderBy[0],$orderBy[1]);
                // log_message(json_encode($item['cwlist']));
            }
            if(isset($item['cwlist']) && is_array($item['cwlist'])){
                foreach ($item['cwlist'] as &$value){
                    $value['cwlength'] = getTimeToString($value['cwlength']);
                }
            }
        }

        if (!empty($cwlist)) {
            array_walk($cwlist, function(&$list) {
                if (empty($list['cwlist'])) {
                    return;
                }
                array_walk($list['cwlist'], function(&$item) {
                    if (empty($item['logo'])) {
                        $item['cover'] = $item['thumb'];
                        return;
                    }
                    $item['cover'] = preg_replace_callback('/(?:_\d+_\d+\.)|(?:_th\.)/', function($matches) {
                        return '.';
                    }, $item['logo']);
                });
            });
        }

        $this->renderjson(0,'',array('cwlist'=>$cwlist,'cwcount'=>$result['cwcount']));
	}
	
	/*
	课程浏览
	*/
	public function browse(){
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['issimple'] = 1;//简单数据
		$splist = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.spList')->addParams($data)->request();
		$pids = array_keys($splist);
		$data['pids'] = implode(',',$pids);
		$sortlist = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.sortList')->addParams($data)->request();
		$courselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.itemList')->addParams($data)->request();
		$folderids = array_column($courselist,'folderid');
		unset($data['pids']);
		$data['folderid'] = implode(',',$folderids);
		$data['pagesize'] = 1000;
		$data['page'] = 1;
		
		$cwlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwList')->addParams($data)->request();
		$cwlist = $cwlist['cwlist'];
		foreach($cwlist as $cw){
			$folderid = $cw['folderid'];
			if(isset($courselist[$folderid])){
				$courselist[$folderid]['chidren'][] = $cw;
			}
		}
		foreach($courselist as $course){
			$sid = $course['sid'];
			$pid = $course['pid'];
			if($sid != 0){//有分类的
				if(isset($sortlist[$sid])){
					$sortlist[$sid]['chidren'][] = $course;
				}
			} else {//没有分类直接在服务包下的
				if(isset($splist[$pid])){
					$splist[$pid]['chidren'][] = $course;
				}
			}
		}
		foreach($sortlist as $sort){
			$pid = $sort['pid'];
			if(isset($splist[$pid])){
				$splist[$pid]['sortlist'][] = $sort;
			}
		}
		
		$this->renderjson(0,'',array_values($splist));
	}
	
	/*
	班级课程列表
	*/
	public function classCourse(){
		$data['isstats'] = $this->input->post('isstats');//是否是统计用的班级课程关联
		$data['crid'] = $this->roominfo['crid'];
		$classids = $this->input->post('classids');
		$idarr = explode(',',$classids);
		$idarr = array_filter($idarr, function($classid) {
		   return is_numeric($classid);
        });
		if (empty($idarr)) {
            $this->renderjson(1,'参数不正确');
            exit();
        }
		/*foreach($idarr as $classid){
			if(!is_numeric($classid)){
				$this->renderjson(1,'参数不正确');
			}
		}*/
		$data['classids'] = $classids;
		$courselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.classCourseList')->addParams($data)->request();
		$coursearr = array();
		if(!empty($courselist)){
			foreach($courselist as $course){
				$classid = $course['classid'];
				$coursearr[$classid][] = $course;
			}
		}
		
		$itemarr = array();
		if($this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3 && empty($data['isstats'])){//企业选课
			$itemlist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.classItemList')->addParams($data)->request();
			if(!empty($itemlist)){
				foreach($itemlist as $item){
					$classid = $item['classid'];
					$itemarr[$classid][] = $item;
				}
			}
		}
		$classarr['courselist'] = $coursearr;
		$classarr['itemlist'] = $itemarr;
		$this->renderjson(0,'',$classarr);
	}
	
	
	
	/*
	保存班级课程
	*/
	public function saveClassCourse(){
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['classid'] = $this->input->post('classid');
		$data['inherit'] = intval($this->input->post('inherit'));
		$folderids = $this->input->post('folderids');
		if(empty($folderids)){
			$folderids = array();
		}
		$data['isclear'] = $this->input->post('isclear');//是否清空操作
		
		$detail = $this->apiServer->reSetting()->setService('Aroomv3.Classes.detail')->addParams(array('classid'=>$data['classid']))->request();
		if(empty($detail) || $detail['crid'] != $data['crid'] ){
			$this->renderjson(1,'没有权限');
		}
        $data['isenterprise'] = Ebh::app()->room->getRoomType() == 'com' ? 1 : 0;
		if(empty($data['isclear'])){//不是清空操作
			if(empty($data['classid']) || !is_array($folderids)){
				$this->renderjson(1,'参数不正确');
			}
			$data['classids'] = $data['classid'];
			//班级已选的课程列表
			// $courselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.classCourseList')->addParams($data)->request();
			
			$data['pagesize'] = 2000;
			//班级学生 ，权限用
			$studentlist = $this->apiServer->reSetting()->setService('Aroomv3.Student.list')->addParams($data)->request();
			$data['uids'] = array_column($studentlist['list'],'uid');
			
			//班级教师 ，权限用
			$teacherlist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.deptTeacherList')->addParams($data)->request();
			if(!empty($teacherlist)){
				$tids = array_column($teacherlist,'uid');
				$data['uids'] = array_merge($data['uids'],$tids);
			}
			
			$data['folderids'] = array_unique($folderids);
		} else {
			if(empty($data['classid'])){
				$this->renderjson(1,'参数不正确');
			}
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Course.saveClassCourse')->addParams($data)->request();
		$data['itemids'] = $this->input->post('itemids');
		if($this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3 && (empty($data['itemids']) || is_array($data['itemids']))){//企业选课
			$this->apiServer->reSetting()->setService('Aroomv3.Schsource.saveClassitem')->addParams($data)->request();
		}
		if(!empty($result)){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	删除课程
	*/
	public function del(){
		$data['folderid'] = intval($this->input->post('folderid'));
		$data['crid'] = $this->roominfo['crid'];
		$data['isschool'] = $this->roominfo['isschool'];
		if(empty($data['folderid'])){
			$this->renderjson(1,'参数错误');
		}
		
		$cwcount = $result = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwCount')->addParams($data)->request();
        $folder = $result = $this->apiServer->reSetting()->setService('Classroom.Folder.getFolderById')->addParams($data)->request();

		if(!empty($cwcount) && $cwcount>0){
			$this->renderjson(2,'有课件不能删除');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Course.del')->addParams($data)->request();
        if(!empty($result)){
            $redis = Ebh::app()->getCache('cache_redis');
            $redis->del('ebh_plate-platform-'.$this->roominfo['crid']);
            $this->renderjson(0,'操作成功',array(),false);
            fastcgi_finish_request();	//操作成功，则直接返回前端输出
            if(!empty($folder['foldername'])){
                Ebh::app()->lib('OperationLog')->addLog(array('toid' => $data['folderid'],'foldername' => $folder['foldername']),'delcourse');//操作成功记录到操作日志
            }
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	
	/*
	删除课件
	*/
	public function delCw() {
		$cwid = intval($this->input->post('cwid'));
		if($cwid <= 0) {
			$this->renderjson(1,'参数不正确');
		}
		$data['cwid'] = $cwid;
		$data['crid'] = $this->roominfo['crid'];
		$cw = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwDetail')->addParams($data)->request();
		if(empty($cw)) {
			$this->renderjson(1,'课件不存在');
		} else {
			if($this->roominfo['crid'] != $cw['crid']) {
				$this->renderjson(1,'无权操作');
			}
			$queryarr = array('cwid'=>$cwid,'crid'=>$data['crid']);
			$result = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwDel')->addParams($queryarr)->request();
            if($result !== FALSE) {
                $this->renderjson(0,'操作成功',array(),false);
                fastcgi_finish_request();	//操作成功，则直接返回前端输出
                $param = array();
                $param['toid'] = $cwid;
                $param['foldername'] = !empty($cw['foldername']) ? $cw['foldername'] : '';
                $param['title'] = !empty($cw['title']) ? $cw['title'] : '';
                Ebh::app()->lib('OperationLog')->addLog($param,'delcw');//操作成功记录到操作日志
	        } else {
	            $this->renderjson(1,'操作失败');
	        }
		}
	}
	
	/*
	课件的学习详情
	*/
	public function studyDetail(){
		$data['crid'] = $this->roominfo['crid'];
		$data['cwid'] = $this->input->get('cwid');
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		$data['page'] = empty($page)?0:$page;
		$data['pagesize'] = empty($pagesize)?20:$pagesize;
		$data['q'] = empty($q)?'':htmlspecialchars($q);
		$cw = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwDetail')->addParams($data)->request();
		if($cw['status'] != 1){
			$this->renderjson(1,'无权查看');
		}
		$totallist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyDetail')->addParams($data)->request();
		$studylist = $totallist['studylist'];
		if(!empty($studylist)){
			$studylist = array_values($studylist);
			$uids = array_column($studylist,'uid');
			$datauser['uids'] = implode(',',$uids);
			$datauser['crid'] = $data['crid'];
			$userlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyUsers')->addParams($datauser)->request();
			foreach($studylist as $k=>$study){
				$uid = $study['uid'];
				if(!empty($userlist['userlist'][$uid])){
					$studylist[$k]['user'] = $userlist['userlist'][$uid];
				}
				if(!empty($userlist['classlist'][$uid])){
					$studylist[$k]['class'] = $userlist['classlist'][$uid];
				}
				$studylist[$k]['cwdetail'] = $cw;
			}
		}
		$totallist['studylist'] = $studylist;
		$redis = Ebh::app()->getCache('redis_cache');
		$redis->incr('studyDetail');
		$viewnum = $redis->get('studyDetail');
		$totallist['viewnum'] = $viewnum;
		$this->renderjson(0,'',$totallist);
	}

    /**
     * 热门课程
     */
	public function hotCourseList() {
	    $num = intval($this->input->get('num'));
	    if ($num < 1) {
	        $num = 4;
        }
        $data = array(
            'crid' => $this->roominfo['crid'],
            'num' => $num
        );
        $courseList = $this->apiServer->reSetting()->setService('Aroomv3.Course.hotCourseList')->addParams($data)->request();
        if (!empty($courseList)) {
            $redis = Ebh::app()->getCache('cache_redis');
            array_walk($courseList, function(&$v, $k, $redis) {
                $viewnum = $redis->hget('folder'.'viewnum', $v['folderid']);
                if (!empty($viewnum)) {
                    $v['viewnum'] = $viewnum;
                }
            }, $redis);
            $viewnumArr = array_column($courseList, 'viewnum');
            array_multisort($viewnumArr, SORT_NUMERIC, SORT_DESC, $courseList);
            if (count($courseList) > $num) {
                $courseList = array_slice($courseList, 0, $num);
            }
            //处理课程封面
            $upconfig = Ebh::app()->getConfig()->load('upconfig');
            $baseUrl = '';
            if (!empty($upconfig['pic']['showpath'])) {
                $baseUrl = rtrim($upconfig['pic']['showpath'], '/').'/';
            }
            array_walk($courseList, function(&$v, $k, $baseUrl) {
                if ($v['viewnum'] > 10000) {
                    $v['viewnum'] = round($v['viewnum'] / 10000, 2).'万';
                }
                if (empty($v['img'])) {
                    $v['img'] = 'http://static.ebh.net/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg';
                    return;
                }
                if (stripos($v['img'], 'http://') === 0) {
                    return;
                }
                if (stripos($v['img'], '/static/tpl/default/images/folderimg') === 0) {
                    $v['img'] = str_replace('/static/tpl/default/images/folderimg',
                        'http://static.ebh.net/ebh/tpl/default/images/folderimgs', $v['img']);
                    return;
                }
                $v['img'] = $baseUrl.ltrim($v['img'], '/');
            }, $baseUrl);
        }
        $this->renderjson(0, '', $courseList);
    }

    /**
     * 课程封面图库
     */
    public function getCourseCoverList() {
        $pageinfo = $this->getPageInfo();
        $pagesize = max(1, $pageinfo['pagesize']);
        $pagenum = max(1, $pageinfo['pagenum']);
        $offset = ($pagenum - 1) * $pagesize;
        $maxOffset = min($offset + $pagesize, 218);
        $coverArr = array();
        for($i = $offset + 1; $i <= $maxOffset; $i++) {
            $coverArr[] = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/'.$i.'_247_147.jpg';
        }
        if (count($coverArr) < $pagesize) {
            $coverArr[] = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/guwen_247_147.jpg';
        }

        $this->renderjson(0, '', array('count' => 218, 'covers' => $coverArr));
    }


	/*
	 * 课件学习统计,单课件
	*/
	public function cwStudyList(){
		$data['crid'] = $this->roominfo['crid'];
		$data['classid'] = $this->input->get('classid');
		$data['cwid'] = $this->input->get('cwid');
		$data['starttime'] = $this->input->get('starttime');
		$data['endtime'] = $this->input->get('endtime');
		if(empty($data['classid']) || empty($data['cwid'])){
			$this->renderjson(1,'参数不正确');
		}
		$detail = $this->apiServer->reSetting()->setService('Aroomv3.Classes.detail')->addParams(array('classid'=>$data['classid']))->request();
		if(empty($detail) || $detail['crid'] != $data['crid'] ){
			$this->renderjson(1,'没有权限');
		}
		$userlist = $this->apiServer->reSetting()->setService('Aroomv3.Courseware.cwStudyList')->addParams($data)->request();
		$this->renderjson(0,'',$userlist);
	}

    /**
     * 移动修改章节下课件排序号
     */
	public function rankCoursewareInSection() {
	    $cwid = intval($this->input->post('cwid'));
	    $step = intval($this->input->post('step'));
	    if ($cwid < 1 || $step == 0) {
	        $this->renderjson(1, '参数错误');
        }
	    $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.rankCoursewareInSection')
            ->addParams(array(
                'crid'=>$this->roominfo['crid'],
                'cwid' => $cwid,
                'step' => $step
            ))
            ->request();
	    if ($ret === false) {
	        $this->renderjson(1, '排序失败');
        }
        $this->renderjson(0, '');
    }

    /**
     * 移动修改课程排序号
     */
    public function rankCourse() {
	    $folderid = intval($this->input->post('folderid'));
	    $step = intval($this->input->post('step'));
	    $scope = intval($this->input->post('scope'));
	    if ($folderid < 1 || $step == 0) {
	        $this->renderjson(1, '参数错误');
        }
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.rankCourse')
            ->addParams(array(
                'crid' => $this->roominfo['crid'],
                'folderid' => $folderid,
                'scope' => $scope,
                'step' => $step
            ))
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '排序失败');
        }
        $this->renderjson(0, '');
    }

    /**
     * 批量排序课件
     */
    public function batchRankCoursewares() {
        $ranks = $this->input->post('ranks');
        $folderid = intval($this->input->post('folderid'));
        if (empty($ranks) && !is_array($ranks)) {
            $this->renderjson(1, '未做修改');
        }
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.batchRankCoursewares')
            ->addParams(array(
                'crid'=>$this->roominfo['crid'],
                'ranks' => $ranks,
                'folderid' => $folderid
            ))
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '排序失败');
        }
        $this->renderjson(0, '');
    }

    /**
     * 批量设置课程的排序号，明确设置排序值的课程的优先级高于未指定值的课程,排序从1开始
     */
    public function batchRankCourses() {
        $ranks = $this->input->post('folderid');
        if (empty($ranks) && !is_array($ranks)) {
            $this->renderjson(1, '未做修改');
        }
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.batchRankCourses')
            ->addParams(array(
                'crid'=>$this->roominfo['crid'],
                'ranks' => $ranks
            ))
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '排序失败');
        }
        $this->renderjson(0, '');
    }

    /**
     * 导入课程/课件排序excel表格
     */
    public function exportRank() {
        $type = intval($this->input->post('type'));
        if (!in_array($type, array(1, 2)) || empty($_FILES['tpl'])) {
            $this->renderjson(1, '参数错误');
        }
		$reader = Ebh::app()->lib('PhpExcelReader');
        $reader->setOutputEncoding('UTF-8');
        $r = $reader->read($_FILES['tpl']['tmp_name']);
        if($r === false) {	//不支持的文件格式
            $this->renderjson(1, '不支持的导入文件格式');
        }

        if ($type == 2) {
            //课程排序
            $packageColumn = $sortColumn = $courseColumn = $grankColumn = $prankColumn = $srankColumn = $titlerownum = 0;
            for ($i = 1; $i <= $reader->sheets[0]['numRows']; $i++) {
                $packageColumn = $sortColumn = $courseColumn = $grankColumn = $prankColumn = $srankColumn = 0;
                for ($j = 1; $j <= $reader->sheets[0]['numCols']; $j++) {	//找到标题行
                    $colval = trim($reader->sheets[0]['cells'][$i][$j]);
                    $colval = str_replace(' ','',$colval);
                    if($colval == '课程主类') {
                        $packageColumn = $j;
                    } else if($colval == '课程子类') {
                        $sortColumn = $j;
                    } else if ($colval == '课程名称') {
                        $courseColumn = $j;
                    } else if ($colval == '全局排序') {
                        $grankColumn = $j;
                    } else if ($colval == '主类排序') {
                        $prankColumn = $j;
                    } else if($colval == '子类排序') {
                        $srankColumn = $j;
                    }
                }
                if($packageColumn > 0 && $sortColumn > 0 && $courseColumn > 0 && $grankColumn > 0 && $prankColumn > 0 && $srankColumn > 0) {	//找到标题行
                    $titlerownum = $i;
                    break;
                }
            }
            if ($titlerownum == 0) {
                $this->renderjson(1, '导入文件格式错误');
            }
            $ranks = array();
            for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
                $rank = array();
                $err = '';
                if (!empty($reader->sheets[0]['cells'][$i][$packageColumn])) {
                    $rank['pname'] = trim($reader->sheets[0]['cells'][$i][$packageColumn]);
                } else {
                    //$err = '格式错误，第'.$i.'行，课程主类不能为空';
                    break;
                }
                if (isset($reader->sheets[0]['cells'][$i][$sortColumn])) {
                    $rank['sname'] = trim($reader->sheets[0]['cells'][$i][$sortColumn]);
                } else {
                    //$err = '格式错误，第'.$i.'行，课程子类未设置';
                    break;
                }
                if (!empty($reader->sheets[0]['cells'][$i][$courseColumn])) {
                    $rank['foldername'] = trim($reader->sheets[0]['cells'][$i][$courseColumn]);
                } else {
                    //$err = '格式错误，第'.$i.'行，课程名称不能为空';
                    break;
                }
                if (isset($reader->sheets[0]['cells'][$i][$grankColumn]) || !is_numeric($reader->sheets[0]['cells'][$i][$grankColumn])) {
                    $rank['grank'] = trim($reader->sheets[0]['cells'][$i][$grankColumn]);
                } else {
                    //$err = '格式错误，第'.$i.'行，全局排序号格式错误，请输入正整数';
                    break;
                }
                if (isset($reader->sheets[0]['cells'][$i][$prankColumn]) || !is_numeric($reader->sheets[0]['cells'][$i][$prankColumn])) {
                    $rank['prank'] = trim($reader->sheets[0]['cells'][$i][$prankColumn]);
                } else {
                    //$err = '格式错误，第'.$i.'行，主类排序号格式错误，请输入正整数';
                    break;
                }
                if (isset($reader->sheets[0]['cells'][$i][$srankColumn]) || !is_numeric($reader->sheets[0]['cells'][$i][$srankColumn])) {
                    $rank['srank'] = trim($reader->sheets[0]['cells'][$i][$srankColumn]);
                } else {
                    //$err = '格式错误，第'.$i.'行，子类排序号格式错误，请输入正整数';
                    break;
                }
                if ($err != '') {
                    $this->renderjson(1, $err);
                }
                $ranks[] = $rank;
            }
            $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.batchRankCourses')
                ->addParams(array(
                    'crid'=>$this->roominfo['crid'],
                    'ranks' => $ranks,
                    'fromexcel' => 1
                ))
                ->request();
            if ($ret === false) {
                $this->renderjson(1, '排序失败');
            }
            $this->renderjson(0, '');
        }

        if ($type == 1) {
            //课件排序
            $sectionColumn = $titleColumn = $rankColumn = $titlerownum = 0;
            for ($i = 1; $i <= $reader->sheets[0]['numRows']; $i++) {
                $sectionColumn = $titleColumn = $rankColumn = 0;
                for ($j = 1; $j <= $reader->sheets[0]['numCols']; $j++) {	//找到标题行
                    $colval = trim($reader->sheets[0]['cells'][$i][$j]);
                    $colval = str_replace(' ','',$colval);
                    if($colval == '章节') {
                        $sectionColumn = $j;
                    } else if($colval == '课件名称') {
                        $titleColumn = $j;
                    } else if($colval == '排序') {
                        $rankColumn = $j;
                    }
                }
                if($sectionColumn > 0 && $titleColumn > 0 && $rankColumn > 0) {	//找到标题行
                    $titlerownum = $i;
                    break;
                }
            }
            if ($titlerownum == 0) {
                $this->renderjson(1, '导入文件格式错误');
            }
            $ranks = array();
            for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
                $rank = array();
                $err = '';
                if (isset($reader->sheets[0]['cells'][$i][$sectionColumn])) {
                    $rank['sname'] = trim($reader->sheets[0]['cells'][$i][$sectionColumn]);
                } else {
                    $err = '格式错误，第'.$i.'行，章节名称未设置';
                }
                if (!empty($reader->sheets[0]['cells'][$i][$titleColumn])) {
                    $rank['title'] = trim($reader->sheets[0]['cells'][$i][$titleColumn]);
                } else {
                    $err = '格式错误，第'.$i.'行，课件标题不能为空';
                }
                if (isset($reader->sheets[0]['cells'][$i][$rankColumn])) {
                    $rank['rank'] = trim($reader->sheets[0]['cells'][$i][$rankColumn]);
                } else {
                    $err = '格式错误，第'.$i.'行，课件排序未设置';
                }
                if ($err != '') {
                    $this->renderjson(1, $err);
                }
                $ranks[] = $rank;
            }
            $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.batchRankCoursewares')
                ->addParams(array(
                    'crid'=>$this->roominfo['crid'],
                    'ranks' => $ranks,
                    'fromexcel' => 1
                ))
                ->request();
            if ($ret === false) {
                $this->renderjson(1, '排序失败');
            }
            $this->renderjson(0, '');
        }
    }

    /**
     * 导出课程排序模板，预先导出原有的排序值
     */
    public function importCourseRankTpl() {
        $pid = intval($this->input->get('pid'));
        $sid = $this->input->get('sid');
        $params = array(
            'crid'=>$this->roominfo['crid'],
            'pid' => $pid
        );
        if ($sid !== null) {
            $params['sid'] = $sid;
        }
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.importCourseRankTpl')
            ->addParams($params)
            ->request();
        if (empty($ret)) {
            header('location:http://static.ebanhui.com/ebh/file/batch_rank_courses_tpl.xls');
            exit();
        }
        $name = '课程排序模板';
        $objPHPExcel = Ebh::app()->lib('PHPExcel');

        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $titleArr = array(
            'pname' => '课程主类',
            'sname' => '课程子类',
            'foldername' => '课程名称',
            'grank' => '全局排序',
            'prank' => '主类排序',
            'srank' => '子类排序');
        $titleColor="FF000000";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'1';//列A1,B1,C1,D1,E1,F1
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }
        //传值
        if(is_array($ret)){
            foreach ($ret as $k=>$v) {
                $str = "A";
                foreach($titleArr as $kt=>$vt){
                    $p = $str.($k+2);//从第二列填充内容 A22,B22...A33 B33
                    $pt = $objPHPExcel->getActiveSheet();
                    if(is_numeric($v[$kt])){
                        $pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $pt->getColumnDimension($str)->setWidth(12);//设置单元格宽度
                        $pt->setCellValue($p, $v[$kt].' ');//填充内容
                    }else{
                        $pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                        $pt->getColumnDimension($str)->setWidth(42);//设置单元格宽度
                        $pt->setCellValue($p, ' '.$v[$kt]);
                    }

                    $str++;
                }
            }
        }
        if(!empty($manuallywidth)){
            $str = 'A';
            foreach($manuallywidth as $width){
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
                $str++;
            }
        }
        //exit(0);
        // 输出下载文件 到浏览器
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }
    /**
     * 导出课件排序模板，预先导出原有的排序值
     */
    public function importCoursewareRankTpl() {
        $folderid = intval($this->input->get('folderid'));
        if ($folderid < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $sid = $this->input->get('sid');
        $s = trim($this->input->get('s'));
        $params = array(
            'crid' => $this->roominfo['crid'],
            'folderid' => $folderid
        );
        if ($sid !== NULL && $sid != '') {
            $params['sid'] = intval($sid);
        }
        if (!empty($s)) {
            $params['s'] = $s;
        }
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.importCoursewareRankTpl')
            ->addParams($params)
            ->request();
        if (empty($ret)) {
            header('location:http://static.ebanhui.com/ebh/file/batch_rank_coursewares_tpl.xls');
            exit();
        }
        $name = '课件排序模板';
        $objPHPExcel = Ebh::app()->lib('PHPExcel');

        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        $titleArr = array(
            'sname' => '章节',
            'title' => '课件名称',
            'cdisplayorder' => '排序');
        $titleColor="FF000000";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'1';//列A1,B1,C1
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }
        //传值
        if(is_array($ret)){
            foreach ($ret as $k=>$v) {
                $str = "A";
                foreach($titleArr as $kt=>$vt){
                    $p = $str.($k+2);//从第二列填充内容 A22,B22...A33 B33
                    $pt = $objPHPExcel->getActiveSheet();
                    if(is_numeric($v[$kt])){
                        $pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
                        $pt->getColumnDimension($str)->setWidth(8);//设置单元格宽度
                        $pt->setCellValue($p, $v[$kt].' ');//填充内容
                    }else{
                        $pt->getColumnDimension($str)->setWidth(42);//设置单元格宽度
                        $pt->setCellValue($p, ' '.$v[$kt]);
                    }

                    $str++;
                }
            }
        }
        if(!empty($manuallywidth)){
            $str = 'A';
            foreach($manuallywidth as $width){
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
                $str++;
            }
        }
        //exit(0);
        // 输出下载文件 到浏览器
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }

    /**
     * 获取价格大于０的零售课程
     */
    public function singleValueableCourseList() {
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.singleValueableCourseList')
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 网校课程分层统计
     */
    public function courseCategory() {
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseCategory')
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 企业选课课程列表
     */
    public function schCourse() {
        $sourcecrid = intval($this->input->get('sourcecrid'));
        if ($sourcecrid < 1) {
            $this->renderjson(1, '缺少参数');
            exit();
        }
        $pid = intval($this->input->get('pid'));
        $sid = $this->input->get('sid');
        $page = intval($this->input->get('page'));
        $pagesize = intval($this->input->get('pagesize'));
        $params = array(
            'crid' => $this->roominfo['crid'],
            'sourcecrid' => $sourcecrid,
            'pid' => $pid
        );
        if ($pid > 0 && $sid !== null) {
            $params['sid'] = intval($sid);
        }
        $search = trim($this->input->get('s'));
        if ($search != '') {
            $params['search'] = $search;
        }
        if ($page > 0 || $pagesize > 0) {
            $params['page'] = $page;
            $params['pagesize'] = $pagesize;
        }
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Course.schCourse')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret);
    }


    /**
     * @describe:获取网校课程主类
     * @User:tzq
     * @Date:2017/11/21
     * @param 无
     * @return json
     */
    public function getClass(){
        $roomInfo = $this->roominfo;
        $params['crid'] = $roomInfo['crid'];
        $ret   = $this->apiServer->reSetting()
            ->setService('Aroomv3.Course.getClass')
            ->addParams($params)
            ->request();
        if($ret === false){
            $this->renderjson(1,'Api接口繁忙!');
        }else{
            $this->renderjson(0,'查询成功',$ret);
        }
    }

    /**
     * @describe:获取网校课程列表
     * @User:tzq
     * @Date:2017/11/21
     * @param int     $pid      课程主类id 0 为全部 非0为要筛选的主类
     * @param int     $sid      课程子类id
     * @param string  $q        课程名称
     * @param int     $page     当前页码
     * @param int     $pagesize 每页显示条数
     * @param int     $orderBy  排序
     * 0 默认排序
     * 1 学分从高到低
     * 2 学分从低到高
     * 3 时长从高到低
     * 4 时长从低到高
     * 5 人气从高到低
     * 6 人气从低到高
     * 7 点赞从高到低
     * 8 点赞从低到高
     * 9 评论从高到低
     * 10 评论从低到高
     * 11 价格从高到低
     * 12 价格从低到高
     * 13 课件数从高到低
     * 14 课件数从低到高
     * @return json
     */
    public function getCourseData(){
        $page = $this->input->get('page');
        $pagesize = $this->input->get('pagesize');
        $q = $this->input->get('q');
        $unfit = $this->input->get('unfit');//查询其他课程（无效的数据）
        $data['page'] = empty($page)?0:$page;
        $data['pagesize'] = empty($pagesize)?20:$pagesize;
        $data['q'] = isset($q) ? htmlspecialchars($q) : '';
        $data['crid'] = $this->roominfo['crid'];
        $data['starttime'] = $this->input->get('starttime');
        $data['endtime'] = $this->input->get('endtime');
        $orderBy         = $this->input->request('orderBy');
        $orderBy         = intval($orderBy);
        if(empty($unfit)){//正常数据
            $pid = $this->input->get('pid');
            $sid = $this->input->get('sid');
            /*$this->roominfo['pid'] = empty($pid)?'':$pid;
            $this->roominfo['sid'] = empty($sid)?'':$sid;*/
            $this->roominfo['pid'] = intval($pid);
            if ($pid > 0 && $sid !== null) {
                $this->roominfo['sid'] = intval($sid);
            }
            $data['uid'] = $this->user['uid'];
            $data['roominfo'] = $this->roominfo;
            $data['issimple'] = $this->input->get('issimple');

            $isbytime = $this->input->get('isbytime');
            $totalcourselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseList')->addParams($data)->request();
        } else {//无效数据
            $totalcourselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.unfitCourseList')->addParams($data)->request();
        }
        $courselist = $totalcourselist['courselist'];
        if(!empty($courselist)){
            $folderids = array_column($courselist,'folderid');
            $folderids = implode(',',$folderids);
        }
        if(!empty($folderids) && empty($data['issimple'])){
            $dataf['folderids'] = $folderids;
            $dataf['crid'] = $this->roominfo['crid'];
            $courseteacherlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseTeacherList')->addParams($dataf)->request();

            $courselength = $this->apiServer->reSetting()->setService('Aroomv3.Course.getFolderidMsg')->addParams($dataf)->request();

            //获取课程时长，点赞，评论，学分 用课程id做条件筛选
            $course = array();
            //处理课程拥有的教师
            foreach($courseteacherlist as $ct){
                if(empty($course[$ct['folderid']])){
                    $course[$ct['folderid']] = array($ct);
                }else{
                    $course[$ct['folderid']][]= $ct;
                }
            }
            //课件数量
            $datacw['crid'] = $this->roominfo['crid'];
            $datacw['folderid'] = $folderids;
            $datacw['needgroup'] = 1;
            $datacw['starttime'] = $data['starttime'];
            $datacw['endtime'] = $data['endtime'];
            $cwcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwCount')->addParams($datacw)->request();

            //学习数量
            $dataf['starttime'] = $data['starttime'];
            $dataf['endtime'] = $data['endtime'];
            $studylist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyList')->addParams($dataf)->request();

            //评论数,点赞数,查询导出页面用
            if(!empty($isbytime)){
                $dataf['folderid'] = $folderids;
                $reviewcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.reviewCount')->addParams($dataf)->request();
                $zancountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.zanCount')->addParams($dataf)->request();
            }

            $tempcount = !empty($courselist) ? count($courselist) : 0;
            for($i=0;$i<$tempcount;$i++){
                $folderid = $courselist[$i]['folderid'];
                if(isset($courselength[$folderid])){
                    $courselist[$i]['cwlength'] = isset($courselength[$folderid]['cwlength'])?$courselength[$folderid]['cwlength']:0;
                }
                if(!empty($course[$folderid])){
                    $courselist[$i]['teachers'] = $course[$folderid];
                }
                $courselist[$i]['studynum'] = !empty($studylist[$folderid])?$studylist[$folderid]['count']:0;
                $courselist[$i]['coursewarenum'] = !empty($cwcountlist[$folderid])?$cwcountlist[$folderid]['count']:0;

                if(!empty($isbytime)){
                    $courselist[$i]['reviewnum'] = !empty($reviewcountlist[$folderid])?$reviewcountlist[$folderid]['count']:0;
                    $courselist[$i]['zannum'] = !empty($zancountlist[$folderid])?$zancountlist[$folderid]['count']:0;
                }
                $courselist[$i]['fprice'] = (empty($courselist[$i]['fprice']) || $courselist[$i]['fprice']==0)?0:1;
            }

        }
        //排序处理
        switch ($orderBy){
            case 1:
                $orderBy = array('credit','SORT_DESC');
                $params['orderBy'] = ' ORDER BY  credit DESC';

                break;
            case 2:
                $orderBy = array('credit','SORT_DESC');

                break;
            case 3:
                $orderBy = array('cwlength','SORT_DESC');

                break;
            case 4:
                $orderBy = array('cwlength','SORT_ASC');

                break;
            case 5:
                $orderBy = array('viewnum','SORT_DESC');

                break;
            case 6:
                $orderBy = array('viewnum','SORT_ASC');


                break;
            case 7:
                $orderBy = array('zannum','SORT_DESC');

                break;
            case 8:
                $orderBy = array('zannum','SORT_ASC');

                break;
            case 9:
                $orderBy = array('reviewnum','SORT_DESC');

                break;
            case 10:
                $orderBy = array('reviewnum','SORT_DESC');

                break;
            case 11:
                $orderBy = array('iprice','SORT_ASC');


                break;
            case 12:
                $orderBy = array('iprice','SORT_ASC');

                break;
            case 13:
                $orderBy = array('coursewarenum','SORT_DESC');


                break;
            case 14:
                $orderBy = array('coursewarenum','SORT_ASC');

                break;


        }
        if(is_array($orderBy)){//排序
            $courselist =  arraySequence($courselist,$orderBy[0],$orderBy[1]);
        }
        $totalcourselist['courselist'] = $courselist;

        if (!empty($totalcourselist['courselist']) && $this->roominfo['template'] == 'plate') {
            array_walk($totalcourselist['courselist'], function(&$course) {
                $course['img'] = empty($course['img'])?'':show_plate_course_cover($course['img']);
            });
        }


        $this->renderjson(0,'',$totalcourselist);
        //
        $roomInfo          = $this->roominfo;
        $params['crid']    = $roomInfo['crid'];
        $params['q']       = trim($this->input->request('q'));
        $params['pid']     = intval($this->input->request('pid'));
        $params['sid']     = intval($this->input->request('sid'));
        $params['orderBy'] = intval($this->input->request('orderBy'));
        $params['curr'] = intval($this->input->request('page')) ;
        $params['curr'] = $params['curr'] > 0?$params['curr']:1;
        $params['listRows'] = intval($this->input->request('pagesize')) ;
        $params['listRows'] = $params['listRows']>0?$params['listRows']:20 ;
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Course.getCourseData')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, 'Api接口繁忙!');
        } else {
            $this->renderjson(0, '查询成功', $ret);
        }
    }

    /**
     * @describe:获取指定课程教师头像地址
     * @User:tzq
     * @Date:2017/11/21
     * @param string $foldersid   课程id 多个用,号隔开，后台attache字段获取
     * @return json
     */
    public function getTeacherHead(){
        $folders = trim($this->input->request('folderid'));
        if (0 >= $folders) {
            $this->renderjson(1, '课程参数不正确');
        }
        $params['folderid'] = $folders;
        $ret               = $this->apiServer
            ->reSetting()
            ->setService('Aroomv3.Course.getTeacherHead')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, 'Api接口繁忙!');
        } else {
            $this->renderjson(0, '查询成功', $ret);
        }

    }

    /**
     * @describe:课程-学生排名
     * @User:tzq
     * @Date:2017/11/22
     * @param int $folderid  课程id
     * @param int  $orderBY  排序
     * 1 积分从高到低
     * 2 积分从低到高
     * 3 学分从高到低
     * 4 学分从低到高
     * 5 学时从高到低
     * 6 学时从低到高
     * @return array/null
     */
    public function courseStudentSort(){
        $params['folderid'] = $this->input->request('folderid');
        $params['school_type'] = $this->getschoolType();
        $params['crid'] = $this->roominfo['crid'];
        if(0 >= $params['folderid']){
            $this->renderjson(1,'课程参数不正确');
        }
        $params['orderBy']  = $this->input->request('orderBy');
        $ret               = $this->apiServer
            ->reSetting()
            ->setService('Aroomv3.Course.courseStudentSort')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, 'Api接口繁忙!');
        } else {
            $this->renderjson(0, '查询成功', $ret);
        }

    }

    /**
     * @describe:学生排名-获取学生学分和注册地址与班级
     * @User:tzq
     * @Date:2017/11/23
     * @param string $attach 附加字段参数用于获取缓存
     */
    public function getCoreClass(){
        $params['attach'] = $this->input->get('attach');
        if (empty($params['attach'])) {
            $this->renderjson(1, '缺少必须参数(attach)');
        }
        $ret = $this->apiServer
            ->reSetting()
            ->setService('Aroomv3.Course.getCoreClass')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, 'Api接口繁忙!');
        } else {
            $this->renderjson(0, '查询成功', $ret);
        }
    }
    /**
     * @describe:课程-文件统计
     * @User:tzq
     * @Date:2017/11/23
     * @param int $folderid 课程id
     * @return json/array
     */
    public function fileCount(){
        $params['folderid'] = intval($this->input->request('folderid'));
        $params['crid']     = $this->roominfo['crid'];
        //log_message(json_encode($params));
        if (0 >= $params['folderid']) {
            $this->renderjson(1, '课程id参数不正确');
        }
        $ret = $this->apiServer
            ->reSetting()
            ->setService('Aroomv3.Course.fileCount')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, 'Api接口繁忙!');
        } else {
            $this->renderjson(0, '查询成功', $ret);
        }

    }
    /**
     * @describe:获取网校类型
     * @User:tzq
     * @Date:2017/12/5
     * @return int
     */
    private function getschoolType(){
        $property                 = isset($this->roominfo['property']) ? $this->roominfo['property'] : 0;
        $isschool                 = isset($this->roominfo['isschool']) ? $this->roominfo['isschool'] : 0;
        $other_config             = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr']    = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr                 = ($this->roominfo['crid'] == $other_config['zjdlr']) || (in_array($this->roominfo['crid'], $other_config['newzjdlr']));
        $is_newzjdlr              = in_array($this->roominfo['crid'], $other_config['newzjdlr']);
        if ($property == 3 && $isschool == 7) {
            $type = 1;//企业版
        } elseif ($is_newzjdlr || $is_zjdlr) {
            $type = 2;//国土版
        } else {
            $type = 3;//其他版本 教育版或租赁版
        }
        return $type;

    }
	
	/*
	报名信息
	*/
	public function openList(){
		$itemid = $this->input->get('itemid');
		$bid = $this->input->get('bid');
		if((empty($itemid) && empty($bid)) || $this->roominfo['isschool'] != 7){
			$this->renderjson(0,'',array());
		}
		$data['itemid'] = $itemid;
		$data['bid'] = $bid;
		$data['crid'] = $this->roominfo['crid'];
		$openlist = $this->apiServer->reSetting()->setService('Classroom.Item.openList')->addParams($data)->request();
		$this->renderjson(0,'',$openlist);
	}
}
