<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 */
class ReportController extends ARoomV3Controller{
    /*
     * 教师统计
     */
    public function teacher(){
        $groupid = $this->input->get('groupid');
        $classid = $this->input->get('classid');
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
        $q = $this->input->get('q');
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $export = intval($this->input->get('export'));
        $parameters['pagesize'] = $pageArr['pagesize'];
        if($export > 0){
            $parameters['pagesize'] = 100000;
        }
        $parameters['p'] = $pageArr['pagenum'];
        if ($this->roominfo['property'] == 3) {
            $parameters['isenterprise'] = 1;
        }
        if(!empty($groupid)){
            $parameters['groupid'] = $groupid;
        }
        if(!empty($classid)){
            $parameters['classid'] = $classid;
        }
        if(!empty($starttime)){
            $parameters['starttime'] = $starttime;
        }
        if(!empty($endtime)){
            $parameters['endtime'] = $endtime;
        }
        if(!empty($q)){
            $parameters['q'] = $q;
        }

        $result = $this->apiServer->reSetting()->setService('Aroomv3.Report.teacher')->addParams($parameters)->request();
        if($export > 0){
            $titleData = array('教师账号','班级','签到次数','登录次数','课程','录播课','直播课','作业','题库','答疑','评论');
			$exportData = array();
            foreach($result['list'] as $list){
                $exportData[] = array(
                    $list['realname'].'('.$list['username'].')',
                    $list['class'],
                    $list['signnum'],
                    $list['logincount'],
                    $list['foldernum'],
                    $list['videocoursenum'],
                    $list['livecoursenum'],
                    $list['examnum'],
                    $list['examquesnum'],
                    $list['answernum'],
                    $list['reviewnum']

                );
            }
            $filename = '教师统计';
			if($this->roominfo['property'] == 3){
				$titleData = array('账号','班级','签到','登录','课程','录播课','直播课','作业','题库','答疑','评论');
				$filename = '统计';
			}
            $widtharr = array(30,30,8,8,8,10,10,8,8,8,8);
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);

            exit;
        }
        $this->renderjson(0,'',$result);
    }

    /**
     * 教师课件统计
     */
    public function teacher_coursewares(){
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
        $q = $this->input->get('q');
        $folderid = $this->input->get('folderid');
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $export = intval($this->input->get('export'));
        if($export > 0){
            $parameters['pagesize'] = 100000;
        }
        if(!empty($folderid)){
            $parameters['folderid'] = intval($folderid);
        }

        if(!empty($starttime)){
            $parameters['starttime'] = $starttime;
        }
        if(!empty($endtime)){
            $parameters['endtime'] = $endtime;
        }
        if(!empty($q)){
            $parameters['q'] = $q;
        }

        $result = $this->apiServer->reSetting()->setService('Aroomv3.Report.tCoursewares')->addParams($parameters)->request();
        if($export > 0){
            $titleData = array('教师账号','课程','课件名称','发布时间','大小','时长','学习次数','附件','评论','点赞');
            $exportData = array();

            foreach($result['list'] as $list){
                foreach ($list['course'] as $course){
                    if ($course['cwlength'] <= 0) {
                        continue;
                    }
                    $exportData[] = array(
                        $list['realname'].'('.$list['username'].')',
                        $list['foldername'],
                        $course['title'],
                        date('Y-m-d H:i:s',$course['dateline']),
                        (string)(round($course['cwsize']/1024/1024,2)).'M',
                        $this->timeFormat($course['cwlength']),
                        $course['study_count'],
                        $course['attachments_count'],
                        $course['reviewnum'],
                        $course['zannum'],

                    );
                }
            }
            $filename = '教师课件统计';
			if($this->roominfo['property'] == 3){
				$titleData = array('账号','课程','课件名称','发布时间','大小','时长','学习次数','附件','评论','点赞');
				$filename = '课件统计';
			}
            $widtharr = array(30,30,30,10,10,30,5,5,5,5,5);
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);

            exit;
        }
        $this->renderjson(0,'',$result);


    }

    /**
     * 班级课程统计
     */
    public function class_folder(){
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
        $q = $this->input->get('q');
        $folderid = $this->input->get('folderid');
        $classid = $this->input->get('classid');
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $isenterprise = Ebh::app()->room->getRoomType() == 'com' ? 1 : 0;
        $parameters['isenterprise'] = intval($this->input->get('isenterprise')) == 1 ? 1 : $isenterprise;
        if ($this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $parameters['uid'] = $this->user['uid'];
        }
        $export = intval($this->input->get('export'));
        if($export > 0){
            $parameters['pagesize'] = 100000;
        }
        if(!empty($folderid)){
            $parameters['folderid'] = intval($folderid);
        }

        if(!empty($classid)){
            $parameters['classid'] = intval($classid);
        }

        if(!empty($starttime)){
            $parameters['starttime'] = $starttime;
        }
        if(!empty($endtime)){
            $parameters['endtime'] = $endtime;
        }
        if(!empty($q)){
            $parameters['q'] = $q;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Report.classFolder')->addParams($parameters)->request();
        //print_r($result);exit;
        if($export > 0){
            $titleData = array('班级名称','学生总数','课程名称','任课教师','学习人数','学习次数','学次总时间','未学习人数');
            $exportData = array();
            foreach($result['list'] as $list){
                $exportData[] = array(
                    $list['classname'],
                    $list['stunum'],
                    $list['foldername'],
                    $list['teachername'],
                    $list['peoplenum'],
                    $list['studynum'],
                    $this->timeFormat($list['studytime']),
                    $list['stunum']-$list['peoplenum'],

                );
            }
            $filename = '班级课程统计';
			if($this->roominfo['property'] == 3){
				$titleData = array('部门','员工人数','课程名称','关联讲师','学习人数','学习次数','学次总时间','未学习人数');
				$filename = '部门课程统计';
			}
            $widtharr = array(30,12,30,30,12,12,30,16);
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);

            exit;
        }
        $this->renderjson(0,'',$result);
    }

    /**
     * 网校学生统计
     */
    public function student(){
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
        $q = $this->input->get('q');
        $classid = $this->input->get('classid');
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $export = intval($this->input->get('export'));
        if($export > 0){
            $parameters['pagesize'] = 100000;
        }
        if(!empty($classid)){
            $parameters['classid'] = intval($classid);
        }
        $isenterprise = Ebh::app()->room->getRoomType() == 'com' ? 1 : 0;
        $parameters['isenterprise'] = intval($this->input->get('isenterprise')) == 1 ? 1 : $isenterprise;
        if ($this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $parameters['uid'] = $this->user['uid'];
        }

        if(!empty($starttime)){
            $parameters['starttime'] = $starttime;
        }
        if(!empty($endtime)){
            $parameters['endtime'] = $endtime;
        }
        if(!empty($q)){
            $parameters['q'] = $q;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Report.student')->addParams($parameters)->request();
        if($export > 0){
            $titleData = array('学生帐号','所在班级','学分','学时','积分','签到','登录','学习记录','作业','答疑','评论');
            $exportData = array();
            foreach($result['list'] as $list){
                $exportData[] = array(
                    $list['realname'].'('.$list['username'].')',
                    $list['classname'],
                    $list['totalscore'],
                    $list['ltime'],
                    $list['credit'],
                    $list['sign_count'],
                    $list['logincount'],
                    $list['study_count'],
                    $list['exam_count'],
                    $list['ask_count'],
                    $list['review_count'],

                );
            }
            $filename = '学生统计';
			if($this->roominfo['property'] == 3){
				$titleData = array('帐号','所属部门','学分','学时','积分','签到次数','登录次数','学习记录','作业记录','答疑记录','评论记录');
				$filename = '员工统计';
			}
            $widtharr = array(30,40,16,16,16,16,16,16,16,16,16);
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);

            exit;
        }
        $this->renderjson(0,'',$result);
    }

    /**
     * 学生课程统计
     */
    public function student_folder(){
        $uid = intval($this->input->get('uid'));
        if($uid <= 0){
            $this->renderjson(1,'参数错误');
        }

        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $parameters['uid'] = $uid;
        $export = intval($this->input->get('export'));
        if($export > 0){
            $parameters['pagesize'] = 100000;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Report.studentFolder')->addParams($parameters)->request();

        if($export > 0){
            $titleData = array('学生帐号','所在班级','课程','学习时间','学习次数');
            $exportData = array();
            foreach($result['list'] as $list){
                $exportData[] = array(
                    $list['realname'].'('.$list['username'].')',
                    $list['classname'],
                    $list['foldername'],
                    $this->timeFormat($list['studytime']),
                    $list['study_count'],

                );
            }
            $filename = '学生课程统计';
			if($this->roominfo['property'] == 3){
				$titleData = array('帐号','所属部门','课程','学习时间','学习次数');
				$filename = '课程统计';
			}
            $widtharr = array(30,30,30,30,30);
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);

            exit;
        }

        $this->renderjson(0,'',$result);
    }

    /**
     * 学生课件统计
     */
    public function student_course(){
        $uid = intval($this->input->get('uid'));
        $folderid = intval($this->input->get('folderid'));
        if($uid <= 0 || $folderid <= 0){
            $this->renderjson(1,'参数错误');
        }

        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $parameters['uid'] = $uid;
        $parameters['folderid'] = $folderid;
        $export = intval($this->input->get('export'));
        if($export > 0){
            $parameters['pagesize'] = 100000;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Report.studentCourse')->addParams($parameters)->request();

        if($export > 0){
            $titleData = array('学生帐号','所在班级','课程','课件名称','课件时长','学习持续时间','学习次数','首次学习时间','末次学习时间');
            $exportData = array();
            foreach($result['list'] as $list){
                $exportData[] = array(
                    $list['realname'].'('.$list['username'].')',
                    $list['classname'],
                    $list['foldername'],
                    $list['title'],
                    $this->timeFormat($list['ctime']),
                    $this->timeFormat($list['ltime']),
                    $list['study_count'],
                    date('Y-m-d H:i:s',$list['startdate']),
                    date('Y-m-d H:i:s',$list['lastdate']),


                );
            }
            $filename = '学生学习记录';
			if($this->roominfo['property'] == 3){
				$titleData = array('帐号','所属部门','课程','课件名称','课件时长','学习持续时间','学习次数','首次学习时间','末次学习时间');
				$filename = '学习记录';
			}
            $widtharr = array(30,30,30,30,30,30,5,30,30);
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);

            exit;
        }
        $this->renderjson(0,'',$result);
    }
	
	/*
	课程列表
	*/
	public function roomCourse(){
		$data['page'] = 0;
		$data['pagesize'] = 1000;
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['roominfo'] = $this->roominfo;
		
		$isbytime = $this->input->get('isbytime');
		$totalcourselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseList')->addParams($data)->request();
		$courselist = $totalcourselist['courselist'];
		$folderids = array_column($courselist,'folderid');
		$folderids = implode(',',$folderids);
		if(!empty($folderids)){
			$dataf['folderids'] = $folderids;
			$dataf['crid'] = $this->roominfo['crid'];
			$courseteacherlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseTeacherList')->addParams($dataf)->request();
			
			$course = array();
			
			//课件数量
			$datacw['crid'] = $this->roominfo['crid'];
			$datacw['folderid'] = $folderids;
			$datacw['needgroup'] = 1;
			$cwcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwCount')->addParams($datacw)->request();
			
			//获取课程的学习人数，学习次数，学习总时长
			$studylist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyList')->addParams($dataf)->request();
			
			//评论数,点赞数,查询导出页面用
			
			$dataf['folderid'] = $folderids;
			$reviewcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.reviewCount')->addParams($dataf)->request();
			$zancountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.zanCount')->addParams($dataf)->request();
			
			$tempcount = !empty($courselist) ? count($courselist) : 0;
			for($i=0;$i<$tempcount;$i++){
				$folderid = $courselist[$i]['folderid'];
				
				$courselist[$i]['studynum'] = !empty($studylist[$folderid])?$studylist[$folderid]['count']:0;
				$courselist[$i]['coursewarenum'] = !empty($cwcountlist[$folderid])?$cwcountlist[$folderid]['count']:0;
				$courselist[$i]['reviewnum'] = !empty($reviewcountlist[$folderid])?$reviewcountlist[$folderid]['count']:0;
				$courselist[$i]['zannum'] = !empty($zancountlist[$folderid])?$zancountlist[$folderid]['count']:0;
                $courselist[$i]['usernum'] = !empty($studylist[$folderid]['usernum'])?$studylist[$folderid]['usernum']:0;
                $courselist[$i]['ltimetotal'] = !empty($studylist[$folderid]['ltimetotal']) ? date("H:i:s",$studylist[$folderid]['ltimetotal']) : '00:00:00';
				
			}
			
			// var_dump($cwcountlist);
		}
		
		$titleData = array('课程列表','课件数','学习总人数','学习总人次','学习总时长','评论数','点赞数');
		$exportData = array();
		foreach($courselist as $course){
			$exportData[] = array(
				$course['foldername'],
				$course['coursewarenum'],
				$course['usernum'],
				$course['studynum'],
				$course['ltimetotal'],
				$course['reviewnum'],
				$course['zannum'],
			);
		}
		$filename = '课程统计';
		$widtharr = array(30,15,15,15,15,15,15);
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);

		
	}
	
	/*
	登录日志
	*/
	public function loginLog(){
		$data['crid'] = $this->roominfo['crid'];
		$data['starttime'] = $this->input->get('starttime');
		$data['endtime'] = $this->input->get('endtime');
		$data['q'] = $this->input->get('q');
		$data['citycode'] = $this->input->get('citycode');
		$data['screen'] = $this->input->get('screen');
		$data['groupid'] = $this->input->get('groupid');
		$newuser = $this->input->get('newuser');
		$system = $this->input->get('system');
		if(!empty($system)){
			$sarr = explode(',',$system);
			if(count($sarr) == 2){
				$data['system'] = $sarr[0];
				$data['browser'] = $sarr[1];
			}
		}
		if(!empty($newuser) && !empty($data['starttime']) && !empty($data['endtime'])){//只查询新加入学生
			$onlynewuser = TRUE;
			$uidlist = $this->apiServer->reSetting()->setService('Aroomv3.Student.uidList')->addParams($data)->request();
			if(!empty($uidlist)){
				$data['uids'] = implode(',',array_column($uidlist,'uid'));
			} else {
				$titleData = array('姓名','登录时间','省份','城市','设备','浏览器','联系方式','用户意向');
				$filename = '新用户登录日志';
				$widtharr = array(15,20,15,15,15,15,15,15);
				$this->_exportExcel($titleData,array(),'FFFFFFFF',$filename,$widtharr);
			}
		}
		$page = $this->input->get('page');
		$pagesize = 100000;
		$data['page'] = empty($page)?0:$page;
		$data['pagesize'] = empty($pagesize)?20:$pagesize;
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.list')->addParams($data)->request();
		if(!empty($list['loglist'])){
			$codes = array_column($list['loglist'],'citycode');
			$rdata['codes'] = implode(',',$codes);
			if(!empty($rdata)){
				$cities = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.regionList')->addParams($rdata)->request();
			}
			if(!empty($cities)){
				foreach($list['loglist'] as $k=>$log){
					if(!empty($cities[$log['citycode']])){
						$list['loglist'][$k]['cityname'] = $cities[$log['citycode']]['cityname'];
						$list['loglist'][$k]['pcityname'] = $cities[$log['citycode']]['pcityname'];
					}
				}
			}
		}
		
		if(!empty($onlynewuser)){//新用户登录数据
			$titleData = array('姓名','登录时间','省份','城市','设备','浏览器','联系方式','用户意向');
			$exportData = array();
			foreach($list['loglist'] as $log){
				$intentionstr = $log['intention']==1?'有意向':($log['intention']==2?'没有意向':'未选择');
				$exportData[] = array(
					$log['realname'],
					Date('Y-m-d H:i:s',$log['dateline']),
					empty($log['pcityname'])?'':$log['pcityname'],
					empty($log['cityname'])?'':$log['cityname'],
					$log['system'],
					$log['browser'],
					$log['mobile'],
					$intentionstr
				);
			}
			$widtharr = array(15,20,15,15,15,15,15,15);
			$filename = '新用户登录日志';
		} else {
			$titleData = array('账号','姓名','登录时间','地域','ip','设备来源','分辨率','登录类型');
			$exportData = array();
			foreach($list['loglist'] as $log){
				$cityarr = array();
				if(!empty($log['pcityname'])){
					$cityarr[] = $log['pcityname'];
				}
				if(!empty($log['cityname'])){
					$cityarr[] = $log['cityname'];
				}
				if($this->roominfo['property'] == 3){
					$typestring = $log['groupid']==5?'讲师':'员工';
				} else {
					$typestring = $log['groupid']==5?'老师':'学生';
				}
				$exportData[] = array(
					$log['username'],
					$log['realname'],
					Date('Y-m-d H:i:s',$log['dateline']),
					implode('-',$cityarr),
					$log['ip'],
					$log['system'].'-'.$log['browser'],
					$log['screen'],
					$typestring
				);
			}
			$widtharr = array(15,15,20,20,15,20,15,15);
			$filename = '登录日志';
		}
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
	}
	
	/*
	地域分布列表
	*/
	public function distributeList(){
		$data['crid'] = $this->roominfo['crid'];
		$data['starttime'] = $this->input->get('starttime');
		$data['endtime'] = $this->input->get('endtime');
		// $data['citycode'] = $this->input->get('citycode');
		$citycode = $this->input->get('citycode');
		if(!empty($citycode)){//只有城市
			$data['citycode'] = $citycode;
			$this->cityonly($data);
			return;
		}
		
		$provincelist = $this->getDistributeList($data);
		$data['allcities'] = 1;
		$citylist = $this->getDistributeList($data);
		// var_dump($provincelist);
		// var_dump($citylist);
		$exportData = array();
		foreach($provincelist as $province){
			foreach($citylist as $city){
				if($province['parentcode'] == $city['parentcode']){
					$exportData[] = array(
						$province['cityname'],
						$province['count'],
						$province['percent'].'%',
						$city['cityname'],
						$city['count'],
						$city['percent'].'%',
						$city['ipcount'],
						$city['signcount']
					);
				}
			}
		}
		$titleData = array('省份','登录人次','占比','城市(地级市)','登录人次','登录占比','IP数','签到数');
		$widtharr = array(15,15,15,18,15,15,15,15);
		$filename = '地区分布';
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
	}
	
	/*
	 *地区列表
	*/
	private function getDistributeList($data){
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.distributeList')->addParams($data)->request();
		
		if(!empty($list)){
			$countarr = array_column($list,'count');
			$sum = array_sum($countarr);
			$codetype = empty($data['allcities'])&&empty($data['citycode'])?'parentcode':'citycode';
			$citycodearr = array_column($list,$codetype);
			$codes = implode(',',$citycodearr);
			//地域信息
			$cities = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.regionList')->addParams(array('codes'=>$codes))->request();
			
			// 签到信息
			if($codetype == 'citycode'){
				$data['codes'] = $codes;
				$signlist = $this->apiServer->reSetting()->setService('Aroomv3.Loginlog.signList')->addParams($data)->request();
			}
			
			$sortarr = array();
			foreach($list as $k=>$region){
				$citycode = $region[$codetype];
				$list[$k]['cityname'] = $cities[$citycode]['cityname'];
				$list[$k]['pcityname'] = $cities[$citycode]['pcityname'];
				$list[$k]['signcount'] = empty($signlist[$citycode])?0:$signlist[$citycode]['count'];
				$percent = round($region['count']/$sum,4)*100;
				$list[$k]['percent'] = $percent;
				$sortarr[] = $region['count'];
			}
			array_multisort($sortarr,SORT_DESC,$list);
			
		}
		return $list;
	}
	
	/*
	 *只有城市的地区分布
	*/
	private function cityonly($data){
		$citylist = $this->getDistributeList($data);
		foreach($citylist as $city){
			$exportData[] = array(
				$city['cityname'],
				$city['count'],
				$city['percent'].'%',
				$city['ipcount'],
				$city['signcount']
			);
		}
		$titleData = array('城市(地级市)','登录人数','登录占比','IP数','签到数');
		$widtharr = array(18,15,15,15,15);
		$filename = '地区分布';
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
	}
	
	/*
	 * 课件学习统计
	*/
	public function classCwStats(){
		$data['crid'] = $this->roominfo['crid'];
		$data['pagesize'] = 10000;
		$data['starttime'] = $this->input->get('starttime');
		$data['endtime'] = $this->input->get('endtime');
		$data['classid'] = $this->input->get('classid');
		$data['itemid'] = $this->input->get('itemid');
		$data['q'] = $this->input->get('q');
		$data['isreport'] = 1;
		
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Courseware.classCwStudyStats')->addParams($data)->request();
		$exportData = array();
		if(!empty($list['cwlist'])){
			$studylist = $list['studylist'];
			foreach($list['cwlist'] as $cw){
				foreach($cw['userlist'] as $user){
					$cwuidkey = $cw['cwid'].'_'.$user['uid'];
					$studycount = empty($studylist[$cwuidkey])?'-':$studylist[$cwuidkey]['studycount'];
					$ltime = empty($studylist[$cwuidkey])?'-':$this->changeTimeType($studylist[$cwuidkey]['ltime']);
					$startdate = empty($studylist[$cwuidkey])?'-':Date('Y-m-d H:i:s',$studylist[$cwuidkey]['startdate']);
					$lastdate = empty($studylist[$cwuidkey])?'-':Date('Y-m-d H:i:s',$studylist[$cwuidkey]['lastdate']);
					$exportData[] = array(
						$cw['classname'],
						$cw['usercount'],
						$cw['iname'],
						$cw['title'],
						$cw['realname'],
						$cw['studyusercount'],
						$cw['studycount'],
						$this->changeTimeType($cw['ltime']),
						$cw['usercount']-$cw['studyusercount'],
						$user['realname'],
						$studycount,
						$ltime,
						$startdate,
						$lastdate,
					);
				}
			}
		}
		$titleData = array('班级名称','学生总数','课程名称','课件名称','任课教师','学习人数','学习次数','学习总时间','未学习人数','学生姓名','学习次数','学习持续时间','首次学习时间','末次学习时间');
		$widtharr = array(15,15,30,30,15,15,15,15,15,15,15,15,25,25);
		$filename = '课件学习统计';
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
		
	}
	
	/*
	 * 学生信息。班级，注册地，末次登录等
	*/
	public function studentBase(){
		$parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = 100000;
        $parameters['q'] = $this->input->get('q');
        $t = $this->input->get('t');
        $isenterprise = Ebh::app()->room->getRoomType() == 'com' ? 1 : 0;
        $parameters['isenterprise'] = intval($this->input->get('isenterprise')) == 1 ? 1 : $isenterprise;
        if ($t == 1) {
            $parameters['isenterprise'] = 1;
        }
        $parameters['issimple'] = 1;
        if ($this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $parameters['uid'] = $this->user['uid'];
        }
        $classid = intval($this->input->get('classid'));
        if($classid > 0){
            $parameters['classid'] = $classid;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Student.list')->addParams($parameters)->request();
		$exportData = array();
		if(!empty($result['list'])){
			$userlist = $result['list'];
			if ($parameters['isenterprise'] == 1 && !empty($userlist)) {
				array_walk($userlist, function(&$student, $k, $root) {
                    if(!empty($student['path'])){
                        $student['path'] = trim($student['path'], '/');
                        $student['path'] = substr(strstr($student['path'], '/'), 1);
                        $student['path'] = preg_replace('/\//', '>', $student['path']);
                        $student['path'] = urldecode($student['path']);
                    }
				}, $this->roominfo['crname']);
			}
			foreach($userlist as $user){
				$cityarr = array();
				if(!empty($user['pcityname'])){
					$cityarr[] = $user['pcityname'];
				}
				if(!empty($user['cityname'])){
					$cityarr[] = $user['cityname'];
				}
				$exportData[] = array(
                    $user['username'],
					$user['realname'],
					$parameters['isenterprise'] == 1 ?(!empty($user['path'])?$user['path']:''):(!empty($user['classname'])?$user['classname']:''),
					empty($user['dateline'])?'':DATE('Y-m-d  H:i:s',$user['dateline']),
					empty($user['mobile'])?$user['smobile']:$user['mobile'],
					$user['email']
				);
			}
		}
		$widtharr = array(15,15,20,20,20,15,15,15,30);
		$titleData = array('账号','学生姓名','所在班级','注册时间','电话','邮箱');
		$filename = '学生统计';
		
		if($parameters['isenterprise']){
			$titleData = array('账号','员工姓名','所在部门','注册时间','电话','邮箱');
			$filename = '员工统计';
		}
		if ($t == '1') {
            $titleData = array('账号','学员姓名','所在单位','注册时间','电话','邮箱');
            $filename = '学员统计';
        }
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
	}
	
	/*
	课件的学习详情
	*/
	public function studyDetail(){
		$data['crid'] = $this->roominfo['crid'];
		$data['cwid'] = $this->input->get('cwid');
		
		
		$cw = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwDetail')->addParams($data)->request();
		if($cw['status'] != 1){
			$this->renderjson(1,'无权查看');
		}
		
		$data['pagesize'] = 10000;
		$totallist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyDetail')->addParams($data)->request();
		$studylist = $totallist['studylist'];
		
		$exportData = array();
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
				$exportData[] = array(
					$userlist['userlist'][$uid]['realname'].'('.$userlist['userlist'][$uid]['username'].')',
					$userlist['classlist'][$uid]['classname'],
					$cw['foldername'],
					$cw['title'],
					$this->changeTimeType($study['ctime']),
					$this->changeTimeType($study['ltime']),
					$study['count'],
					Date('Y-m-d H:i:s',$study['startdate']),
					Date('Y-m-d H:i:s',$study['lastdate']),
				);
			}
		}
		if($this->roominfo['property'] ==3 && $this->roominfo['isschool'] == 7){
			$classtitle = '所属部门';
		} else {
			$classtitle = '所属班级';
		}
		$titleData = array('账号',$classtitle,'课程','课件名称','课件时长','学习持续时间','学习次数','首次学习时间','末次学习时间');
		$widtharr = array(20,20,20,20,20,20,20,20,20);
		$filename = '课件《'.$cw['title'].'》学习数据';
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
	}

    /*
    课程的学习详情
    */
    public function studyDetailByFolderid(){
        $data['crid'] = $this->roominfo['crid'];
        $data['folderid'] = intval($this->input->get('folderid'));
        $data['cwid'] = 0;//全部课件
        $foldername = $this->input->get('foldername');
        if (empty($foldername)) {
            $foldername = '导出的课程';
        }
        if (empty($data['folderid'])) {
            $this->renderjson(1,'folderid无权查看');
        }
        
        $data['pagesize'] = 10000;
        $totallist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyDetail')->addParams($data)->request();
        $studylist = $totallist['studylist'];
        //var_dump($totallist);exit;
        
        $exportData = array();
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
                $exportData[] = array(
                    $userlist['userlist'][$uid]['realname'].'('.$userlist['userlist'][$uid]['username'].')',
                    $userlist['classlist'][$uid]['classname'],
                    $foldername,
                    $study['title'],
                    $this->changeTimeType($study['ctime']),
                    $this->changeTimeType($study['ltime']),
                    $study['count'],
                    Date('Y-m-d H:i:s',$study['startdate']),
                    Date('Y-m-d H:i:s',$study['lastdate']),
                );
            }
        }
        if($this->roominfo['property'] ==3 && $this->roominfo['isschool'] == 7){
            $classtitle = '所属部门';
        } else {
            $classtitle = '所属班级';
        }
        $titleData = array('账号',$classtitle,'课程','课件名称','课件时长','学习持续时间','学习次数','首次学习时间','末次学习时间');
        $widtharr = array(20,20,20,20,20,20,20,20,20);
        $filename = '课程《'.$foldername.'》学习数据';
        $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
    }
	
	/*
	订单列表
	*/
	public function orderList(){
		$param = $this->input->get();
		$param['isreport'] = 1;
		$param['crid'] = $this->roominfo['crid'];
		$param['payfrom'] = !isset($param['payfrom'])?"all":$param['payfrom'];
		//交易排序
		// if($param['sort']==1){
			// $param['order'] = ' o.totalfee ASC';
		// }elseif($param['sort']==2){
			// $param['order'] = ' o.totalfee DESC';
		// }else{
			$param['order'] = ' o.orderid DESC';
		// }
		
		$param['money'] = empty($param['money'])?-1:intval($param['money']);
		$list =  $this->apiServer->reSetting()->setService('Aroomv3.Settlement.payOrderList')->addParams($param)->request();
		$IPaddress =Ebh::app()->lib('IPaddress');
		$payfromarr = array(
			1=>'年卡',
			2=>'快钱',
			3=>'支付宝',
			4=>'人工开通',
			5=>'内部测试',
			6=>'农行支付',
			7=>'银联支付',
			8=>'余额支付',
			9=>'微信支付',
			10=>'兑换码'
		);
		$exportData = array();
		foreach($list['list'] as $order){
			$newip = !empty($order['ip']) && ($order['ip']!='127.0.0.1') ? $order['ip'] : $order['payip'];
			if(!empty($newip) && ($newip !='127.0.0.1')){
				$iprow = $IPaddress->find($order['ip']);
				@ $order['ipaddr'] = $iprow[1].$iprow[2]." [".$newip."]";
			}else{
				$order['ipaddr'] = '未知IP';
			}
			$exportData[] = array(
				$order['realname'].'('.$order['username'].')',
				$order['ordername'],
				empty($order['providercrname'])?'--':$order['providercrname'],
				$order['pname'],
				empty($order['ordernumber'])?'--':$order['ordernumber'],
				$order['ipaddr'],
				Date('Y-m-d H:i:s',$order['dateline']),
				$payfromarr[$order['payfrom']],
				$order['totalfee'],
			);
		}
		$titleData = array('账号','订单名称','资源来自','课程主类','订单号(卡号)','归属地','下单时间','开通方式','金额');
		$filename = '订单记录';
		$widtharr = array(20,20,15,15,15,30,20,15,15);
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
		
	}
	
	/*
	课程开通人员列表
	*/
	public function openList(){
		$itemid = $this->input->get('itemid');
		$bid = $this->input->get('bid');
		if((empty($itemid) && empty($bid)) || $this->roominfo['isschool'] != 7){
			exit;
		}
		$data['itemid'] = $itemid;
		$data['bid'] = $bid;
		$data['crid'] = $this->roominfo['crid'];
		
		$openlist = $this->apiServer->reSetting()->setService('Classroom.Item.openList')->addParams($data)->request();
		$exportData = array();
		foreach($openlist['list'] as $user){
			$exportData[] = array(
				$user['username'],
				$user['realname'],
				$user['classname'],
				Date('Y-m-d H:i:s',$user['dateline']),
			);
		}
		$classtitle = Ebh::app()->room->getroomtype() == 'com'?'所在部门':'所在班级';
		$titleData = array('账号','姓名',$classtitle,'报名时间');
		$filename = $openlist['name'];
		$widtharr = array(20,20,20,20);
		$this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
	}
	
	/*
	时间转换
	*/
	function changeTimeType($seconds){
		if ($seconds > 3600){
			$hours = intval($seconds/3600);
			$minutes = $seconds % 3600;
			$time = $hours.":".gmstrftime('%M:%S', $minutes);
		}else{
			$time = gmstrftime('%H:%M:%S', $seconds);
		}
		return $time;
	}
    /**
     * 导出excel
     * @param Array array("编号",'用户名','性别'....)
     * @param Array array('1','李华','男'...)
     * @param String rgbColor
     * @param String execl文件名称
     *
     */
    protected  function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$name,$manuallywidth=array()){

        set_time_limit(0);
        $objPHPExcel = Ebh::app()->lib('PHPExcel');

        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'1';//列A1,B1,C1,D1
                if(empty($manuallywidth))
                    $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);

                //$pt->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置列填充模式 solid
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                //$pt->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//设置列边宽
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }
        //传值
        if(is_array($dataArr)){
            foreach ($dataArr as $k=>$v) {
                $str = "A";
                foreach($titleArr as $kt=>$vt){
                    $p = $str.($k+2);//从第二列填充内容 A22,B22...A33 B33
                    $pt = $objPHPExcel->getActiveSheet();
                    if(empty($manuallywidth))
                        $pt->getColumnDimension($str)->setAutoSize(true);//单元格每项内容自适应
                    if(is_numeric($v[$kt])){
                        if(empty($manuallywidth))
                            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);//A列头标题自适应
                        $pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
                        $pt->getColumnDimension($str)->setWidth(20);//设置单元格宽度
                        $pt->setCellValue($p, $v[$kt].' ');//填充内容
                    }else{
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

    private function timeFormat($seconds){
        /*if($time > 60){
            return (round($time/60,2)).'分钟';
        }else{
            return $time.'秒';
        }*/

        /*if ($seconds > 3600){
            $hours = intval($seconds/3600);
            $minutes = $seconds % 3600;
            $time = $hours.":".gmstrftime('%M分%S秒', $minutes);
        }else{
            $time = gmstrftime('%H时%M分%S秒', $seconds);
        }
        return $time;*/

        return gmdate('H小时i分钟s秒', $seconds);
    }


}