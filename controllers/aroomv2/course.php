<?php
/*
学校课程
*/
class CourseController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	/*
	 * 课程管理
	*/
	public function index(){
		$user = Ebh::app()->user->getAdminLoginUser();
		$roominfo = Ebh::app()->room->getcurroom();
		$systemModel = $this->model('Systemsetting');
		$sys = $systemModel->getSetting($roominfo['crid']);
		$this->assign('sys',$sys);
		$this->assign('room',$roominfo);
		$this->display('aroomv2/coursemanger');
	}
	/*
	 * 本校课程管理
	*/
	public function courses(){
		$roominfo = Ebh::app()->room->getcurroom();
		$modulecredit = $this->model('appmodule')->getstudentmodule(array('crid'=>$roominfo['crid'],'available'=>1,'modulecode'=>'mycredit','order'=>'displayorder','limit'=>1));
		$this->assign('modulecredit',$modulecredit);
		$this->assign('ischecktype', $roominfo['checktype']);
		$this->assign('room',$roominfo);
		$this->display('aroomv2/course');
	}
	

	public function courselist() {
        $roominfo = Ebh::app()->room->getcurroom();
        $folder = $this->model('folder');
        $param = parsequery();
        $param['crid'] = $roominfo['crid'];
        $param['folderlevel'] = 1;
        $param['nosubfolder'] = 1;
        $q = trim($this->input->get('q'));
        $param['order'] = 'f.displayorder asc,f.folderid desc';

        $cwmodel = $this->model('courseware');
        $loading = $this->input->get('loading');
        if ($loading !== null) {
            //模拟加载延时
            //sleep(1);
            $this->assign('loading', true);
            $param['page'] = max(1, intval($this->input->get('page')));
        }

        if ($roominfo['isschool'] == 7) {
            //分层网校课程＝服务项,从服务项中获取课程ID，相同课程的服务取新的服务项
            $pid = intval($this->input->get('pid'));
            $sid = $this->input->get('sid');
            $condition = array();
            if ($sid !== null) {
                $sid = intval($sid);
                if ($sid > 0) {
                    $pay_sort = $this->model('Paysort')->getSortdetail($sid);
                    if (!empty($pay_sort)) {
                        $this->assign('pay_sort', $pay_sort);
                        $condition['sid'] = intval($sid);
                        $condition['pid'] = $pay_sort['pid'];
                    }
                } else {
                    $this->assign('pay_sort', array('sid' => 0, 'sname' => '未分类'));
                }
            }
            if ($pid > 0) {
                $pay_package = $this->model('PayPackage')->getPackByPid($pid);
                if (!empty($pay_package)) {
                    $this->assign('pid', $pid);
                    $condition['pid'] = $pid;
                    $this->assign('pay_package', $pay_package);
                }
            }
            if (!empty($q)) {
                $condition['q'] = $q;
            }
            $courselist = $folder->getFolderWithItem($roominfo['crid'], $condition, $param);
            if ($loading === null && count($courselist) >= $param['pagesize']) {
                $this->assign('loadmore', true);
            }
        } else {
            $courselist = $folder->getfolderchapterlist($param);
            $coursecount = $folder->getcount($param);

        }
        if (!empty($courselist)) {
            foreach($courselist as $k=>$course){
                // $subfolder = $folder->getSubFolder($roominfo['crid'],$course['folderid']);
                $param2['crid'] = $roominfo['crid'];
                $param2['folderid'] = $course['folderid'];
                $param2['status'] = 1;
                $cws = $cwmodel->getfolderseccoursecount($param2);
                $cridarr = Ebh::app()->getConfig()->load('subfolder');
                if(empty($cws) && in_array($roominfo['crid'],$cridarr))
                    $courselist[$k]['hassub']=1;
                //获取版本id
                if(empty($course['chapterpath']))
                    $courselist[$k]['versionid'] = 0;
                else{
                    $temparr = explode('/', $course['chapterpath']);
                    $courselist[$k]['versionid'] = $temparr[1];
                }
                $courselist[$k]['chapterfullname'] = !empty($course['chapterpath']) ? $this->model('mychapter')->getfullname($course['chapterpath']) : '';
            }
        }

        // var_dump($courselist);

        $teacher = $this->model('teacher');
        $roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],array('limit'=>1000));

        $teachername = array();
        foreach ($roomteacherlist as $value) {
            $teachername[$value['uid']] = empty($value['realname']) ? $value['username'] : $value['realname'];
        }

        $courseteacherlist = $teacher->getcourseteacherlist($roominfo['crid']);
        $course = array();
        //处理课程拥有的教师
        foreach($courseteacherlist as $ct){
            if(!empty($course[$ct['folderid']]['teacherids'])){
                $course[$ct['folderid']]['teacherids'].= ','.$ct['tid'];
                if (isset($teachername[$ct['tid']])) {
                    $course[$ct['folderid']]['teachers'].= '、'.$teachername[$ct['tid']];
                }
            }
            else{
                $course[$ct['folderid']]['teacherids'] = $ct['tid'];
                if (isset($teachername[$ct['tid']])) {
                    $course[$ct['folderid']]['teachers'] = $teachername[$ct['tid']];
                }
            }
        }

        $tempcount = !empty($courselist) ? count($courselist) : 0;
        for($i=0;$i<$tempcount;$i++){
            if(!empty($course[$courselist[$i]['folderid']]['teacherids'])){
                $courselist[$i]['teacherids'] = $course[$courselist[$i]['folderid']]['teacherids'];
                $courselist[$i]['teachers'] = $course[$courselist[$i]['folderid']]['teachers'];
            }
            else
                $courselist[$i]['teacherids'] = '';
        }
        // var_dump($courselist);
        if ($roominfo['isschool'] != 7) {
            $pagestr = show_page($coursecount, $param['pagesize']);
            $this->assign('pagestr',$pagestr);
        }

        $versionlist = $this->model('mychapter')->getversionlist($roominfo['crid']);
        $this->assign('versionlist', $versionlist);

        $this->assign('q',$q);
        $this->assign('room',$roominfo);
        $this->assign('roomteacherlist',$roomteacherlist);
        $this->assign('courselist',$courselist);
        $this->display('aroomv2/course_list');
    }
	
	public function add(){
		if($this->input->post()){
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getAdminLoginUser();
			$folder = $this->model('folder');
			$param['crid'] = $roominfo['crid'];
			$param['order'] = 'folderid asc';
			$roomfolder = $folder->getfolderlist($param);
			$param['folderlevel'] = 2;
			$param['upid'] = 0;
			$param['img'] = $this->input->post('img');
			$param['foldername'] = $this->input->post('foldername');
			// $param['displayorder'] = $this->input->post('displayorder');
			$param['summary'] = $this->input->post('summary');
			$param['uid'] = $user['uid'];
			$param['speaker'] = $this->input->post('speaker');
			$param['detail'] = h($this->input->post('detail'));
			if($roominfo['isschool'] == 7) {
				$isfree = $this->input->post('isfree');
				if(!empty($isfree)) {
					$param['fprice'] = 0;
				}else{
					$param['fprice'] = 1;
				}
			}
			if(NULL !== $this->input->post('coursewarelogo')) {
				$param['coursewarelogo'] = 1;
			}else{
				$param['coursewarelogo'] = 0;
			}
			if(NULL !== $this->input->post('isschoolfree')) {
				$param['isschoolfree'] = 1;
			}else{
				$param['isschoolfree'] = 0;
			}
			$param['showmode'] = $this->input->post('showmode');//课件显示方式
			$param['folderpath'] = $roomfolder[0]['folderpath'];
			$param['grade'] = $this->input->post('grade');
			$param['power'] = $this->input->post('power');
			$displayorder = $folder->getCurdisplayorder(array('crid'=>$roominfo['crid'],'folderlevel'=>2));
			if($displayorder == null)
				$param['displayorder'] = 200;
			else
				$param['displayorder'] = $displayorder - 1;
			if($roominfo['iscollege']) {	//如果是大学版，则处理学分等信息
				$credit = intval($this->input->post('credit'));	//学分
				$creditmode = intval($this->input->post('creditmode'));	//学分获取方式，如按学习进度，则获取课程和作业占比，按累计时长则设置累计需要时长
				if($creditmode == 1) {
					$credittime = intval($this->input->post('credittime'));
					$credittime = $credittime * 60;	//换算成秒
					$param['credittime'] = $credittime;
				} else {
					$coursecredit = intval($this->input->post('coursecredit'));
					if($coursecredit < 0)
						$coursecredit = 0;
					$examcredit = intval($this->input->post('examcredit'));
					if($examcredit < 0)
						$examcredit = 0;
					if(($coursecredit + $examcredit) < 100) {
						$coursecredit = 100 - $examcredit;
					}
					$param['creditrule'] = $coursecredit.':'.$examcredit;
				}
				$playmode = intval($this->input->post('playmode'));
				$isremind = intval($this->input->post('isremind'));
				$remindtime = $this->input->post('remindtime');
				$remindmsg = $this->input->post('remindmsg');
				$remindtimestr = ''; //多个提醒时间以逗号,隔开
				$remindmsgstr = '';	//多个提醒文字以井号#隔开
				if(!empty($remindtime) && count($remindtime)>0) {
					foreach($remindtime as $remindt) {
						if(is_numeric($remindt) && $remindt > 0) {
							if($remindtimestr == '')
								$remindtimestr = $remindt*60;
							else
								$remindtimestr = $remindtimestr.','.$remindt*60;	
						}
					}
				}
				if(!empty($remindmsg) && count($remindmsg)>0) {
					$remindmsgstr = implode('#',$remindmsg);
				}
				$param['credit'] = $credit;
				$param['creditmode'] = $creditmode;
				$param['playmode'] = $playmode;
				$param['isremind'] = $isremind;
				$param['remindtime'] = $remindtimestr;
				$param['remindmsg'] = $remindmsgstr;
				$param['coursewarelogo'] = 1;
			}
			$pid = $this->input->post('pid');
			$isajax = $this->input->post('isajax');
			if(!empty($pid) && !empty($isajax)){//新版添加课程,判断所选服务包/分类 是否还存在
				$this->checkSp($roominfo);
			}
			$folderid = $folder->addfolder($param);
			if(!empty($folderid) && !empty($isajax)){//新版添加课程,同时添加服务项
				$this->addPayitem($roominfo,$folderid);
				// updateRoomCache($roominfo['crid'],'payitem');
			}
			/**写日志开始**/
			$message = '开设课程 '.$param['foldername'];
			Ebh::app()->lib('LogUtil')->add(
				array(
					'toid'=>$param['crid'],
					'message'=>$message,
					'opid'=>1,
					'type'=>'classroom'
					)
			);
			/**写日志结束**/
			if(empty($isajax))
				header('location:'.geturl('aroomv2/course/courselist'));
		}else{
			$roominfo = Ebh::app()->room->getcurroom();
			$folder = $this->model('folder');
			$param['crid'] = $roominfo['crid'];
			
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$this->assign('imgarr',$this->getimages());
			$this->assign('roominfo',$roominfo);
			if($roominfo['isschool'] != 7)
				$this->display('aroomv2/course_add');
			else
				$this->display('aroomv2/course_add_new');
		}
	}
	
	/*
	新版添加课程,判断所选服务包/分类 是否还存在
	*/
	private function checkSp($roominfo){
		$pid = $this->input->post('pid');
		$pname = $this->input->post('pname');
		$sid = $this->input->post('sid');
		$sname = $this->input->post('sname');
		$spmodel = $this->model('Paypackage');
		$checkarr = array('crid'=>$roominfo['crid'],'pid'=>$pid);
		$res = $spmodel->hasCheck($checkarr);
		$addavailable = true;
		if(empty($res['pid'])){//服务包被删除
			$msg = '所选分类 [name] 已不存在';
			$idtype = 'sp';
			$status = false;
			$addavailable = false;
		}elseif(!empty($sid)){//分类被删除
			$sortmodel = $this->model('Paysort');
			$checkarr = array('crid'=>$roominfo['crid'],'pid'=>$pid,'sid'=>$sid);
			$res = $sortmodel->hasCheck($checkarr);
			if(empty($res)){
				$msg = '所选二级分类 [name] 已不存在';
				$idtype = 'sort';
				$status = false;
				$addavailable = false;
			}
		}
				
		if($addavailable == false){
			echo json_encode(array('msg'=>$msg,'idtype'=>$idtype,'status'=>$status));
			exit;
		}
	}
	/*
	新版添加课程,同时添加服务项
	*/
	private function addPayitem($roominfo,$folderid){
		$itemarr['pid'] = $this->input->post('pid');
		$itemarr['sid'] = $this->input->post('sid');
		$itemarr['iname'] = $this->input->post('foldername');
		$itemarr['isummary'] = $this->input->post('summary');
		$itemarr['crid'] = $roominfo['crid'];
		$itemarr['folderid'] = $folderid;
		$isfree = $this->input->post('isfree');
		$itemarr['iprice'] = empty($isfree)?intval($this->input->post('fprice')):0;
		
		$roomdetail = $this->model('classroom')->getdetailclassroom($roominfo['crid']);
		if(!empty($roomdetail['profitratio'])){//按总后台设置的分成比例
			$profitratio = unserialize($roomdetail['profitratio']);
			$compercent = $profitratio['company']/100;
			$roompercent = 1-$compercent;
		}else{
			$compercent = 0.3;
			$roompercent = 0.7;
		}
		$itemarr['comfee'] = round($itemarr['iprice']*$compercent,2);
		$itemarr['roomfee'] = $itemarr['iprice'] - $itemarr['comfee'];
		$itemarr['view_mode'] = max(intval($this->input->post('view_mode')), 0);
		$monthorday = array('imonth','iday');
		$bywhich = $this->input->post('bywhich');
		$itemarr[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);
		$pimodel = $this->model('Payitem');
		$res = $pimodel->add($itemarr);
		if(empty($res)){
			log_message('添加folderid:'.$folderid.' 的服务项失败');
		}else{
			echo json_encode(array('status'=>true));
		}
	}
	
	/*
	新版编辑课程,同时编辑服务项
	*/
	private function editPayitem($roominfo,$folderid){
		$pimodel = $this->model('Payitem');
		$iteminfo = $pimodel->getLastItemByFolderid($folderid,$roominfo['crid']);
		$itemarr['itemid'] = $iteminfo['itemid'];
		$itemarr['pid'] = $this->input->post('pid');
		$itemarr['sid'] = $this->input->post('sid');
		$itemarr['iname'] = $this->input->post('foldername');
		$itemarr['isummary'] = $this->input->post('summary');
		$itemarr['crid'] = $roominfo['crid'];
		$itemarr['folderid'] = $folderid;
		$isfree = $this->input->post('isfree');
		$itemarr['iprice'] = empty($isfree)?intval($this->input->post('fprice')):0;
		if($iteminfo['roomfee'] == 0 && $iteminfo['comfee'] == 0){//上一次没有分成信息,按照总后台设置的分成比例来
			$roomdetail = $this->model('classroom')->getdetailclassroom($roominfo['crid']);
			if(!empty($roomdetail['profitratio'])){
				$profitratio = unserialize($roomdetail['profitratio']);
				$compercent = $profitratio['company']/100;
				$roompercent = 1-$compercent;
			}else{
				$compercent = 0.3;
				$roompercent = 0.7;
			}
		}else{//上一次有分成信息,按上一次的比例来
			$compercent = $iteminfo['comfee']/$iteminfo['iprice'];
			$roompercent = 1-$compercent;
		}
		$itemarr['comfee'] = round($itemarr['iprice']*$compercent,2);
		$itemarr['roomfee'] = $itemarr['iprice'] - $itemarr['comfee'];
		
		$itemarr['view_mode'] = max(intval($this->input->post('view_mode')), 0);
		$monthorday = array('imonth','iday');
		$bywhich = $this->input->post('bywhich');
		$itemarr[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);
		
		$res = $pimodel->edit($itemarr);
		if($res === FALSE){
			log_message('编辑folderid:'.$folderid.' 的服务项失败');
		}else{
			echo json_encode(array('status'=>true));
		}
	}
	
	public function edit_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$folderid = $this->uri->itemid;
		$coursedetail = $folder->getfolderbyid($folderid);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('imgarr',$this->getimages());
		$this->assign('roominfo',$roominfo);
		if($roominfo['isschool'] == 7){ //新版课程编辑服务项信息
			$pimodel = $this->model('Payitem');
			$payitem = $pimodel->getLastItemByFolderid($folderid,$roominfo['crid']);
			if(!empty($payitem)){
				$coursedetail = array_merge($coursedetail,$payitem);
			}
		}
		$this->assign('coursedetail',$coursedetail);
		if(!empty($payitem)){
			$this->display('aroomv2/course_edit_new');
		}else{
			$this->display('aroomv2/course_edit');
		}
	}
	/*
	选择课程任课教师
	*/
	public function chooseteacher(){
		$folder = $this->model('folder');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['folderid'] = $this->input->post('courseid');
		//$param['teacherids'] = $this->input->post('teacherids');
		$param['crid'] = $roominfo['crid'];
		//教师id处理
		$teacherids = $this->input->post('teacherids');
		$tidArr = $this->_filterTeacher($teacherids);
		$tids = implode(',',$tidArr);
		$param['teacherids'] = $tids;
		$folder->chooseteacher($param);
		echo 1;
		/**写日志开始**/
		fastcgi_finish_request();
		$message = '将教师 [ '.$param['teacherids'].' ] 设置为课程教师';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['folderid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'folder'
				)
		);
		/**写日志结束**/
	}

	/**
	 *教师参数处理,剔除非本校的教师,返回合法的教师id数组
	 *@param String $tids 格式 tid1,tid2,tid3
	 *@return Array 
	 */
	private function _filterTeacher($tids){
		$roominfo = Ebh::app()->room->getcurroom();
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],array('limit'=>1000));
		//所有在该校的教师id数组
		$trueTidArr = $this->_getFieldArr($roomteacherlist,'uid');
		$tidArr = explode(',', $tids);
		return array_intersect($trueTidArr,$tidArr);
	}

	/**
	 *获取二维数组指定的字段集合
	 */
	private function _getFieldArr($param = array(),$filedName=''){
		
		$reuturnArr = array();

		if(empty($filedName)||empty($param)){
			return $reuturnArr;
		}

		foreach ($param as $value) {
			array_push($reuturnArr, $value[$filedName]);
		}

		return $reuturnArr;
	}
	
	public function del(){
		$folder = $this->model('folder');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['folderid'] = intval($this->input->post('folderid'));
		$param['crid'] = $roominfo['crid'];
        $folder_detail = $folder->getfolderbyid($param['folderid'], $roominfo['crid']);
        if (empty($folder_detail) || $folder_detail['coursewarenum'] > 0) {
            echo json_encode(array('code'=>0,'message'=>'删除失败'));
            exit();
        }

        $res = $folder->deletecourse($param, $roominfo['isschool'] == 7);
        if($res) {
            echo json_encode(array('code'=>1,'message'=>'删除成功'));
        } else {
            echo json_encode(array('code'=>0,'message'=>'删除失败'));
        }


		/**写日志开始**/
		fastcgi_finish_request();
		$message = json_encode($param);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['folderid'],
				'message'=>$message,
				'opid'=>4,
				'type'=>'folder'
				)
		);
		/**写日志结束**/
	}
	public function edit(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$folderid = intval($this->input->post('folderid'));
		if(empty($folderid))
			return false;
		$param['folderid'] = $folderid;
		$param['foldername'] = $this->input->post('foldername');
		$param['summary'] = $this->input->post('summary');
		$param['img'] = $this->input->post('img');
		$param['speaker'] = $this->input->post('speaker');
		$param['detail'] = h($this->input->post('detail'));
		if(NULL !== $this->input->post('grade')) {
			$param['grade'] = intval($this->input->post('grade'));
		}
		$param['power'] = $this->input->post('power');
		if($roominfo['isschool'] == 7) {
			$isfree = $this->input->post('isfree');
			if(!empty($isfree)) {
				$param['fprice'] = 0;
			}else{
				$param['fprice'] = 1;
			}
		}
		if(NULL !== $this->input->post('coursewarelogo')) {
			$param['coursewarelogo'] = 1;
		}else{
			$param['coursewarelogo'] = 0;
		}
		if(NULL !== $this->input->post('isschoolfree')) {
			$param['isschoolfree'] = 1;
		}else{
			$param['isschoolfree'] = 0;
		}
		$param['showmode'] = $this->input->post('showmode');//课件显示方式
		$param['displayorder'] = $this->input->post('displayorder');
		if($roominfo['iscollege']) {	//如果是大学版，则处理学分等信息
			$credit = intval($this->input->post('credit'));	//学分
			$creditmode = intval($this->input->post('creditmode'));	//学分获取方式，如按学习进度，则获取课程和作业占比，按累计时长则设置累计需要时长
			if($creditmode == 1) {
				$credittime = intval($this->input->post('credittime'));
				$credittime = $credittime * 60;	//换算成秒
				$param['credittime'] = $credittime;
			} else {
				$coursecredit = intval($this->input->post('coursecredit'));
				if($coursecredit < 0)
					$coursecredit = 0;
				$examcredit = intval($this->input->post('examcredit'));
				if($examcredit < 0)
					$examcredit = 0;
				if(($coursecredit + $examcredit) < 100) {
					$coursecredit = 100 - $examcredit;
				}
				$param['creditrule'] = $coursecredit.':'.$examcredit;
			}
			$playmode = intval($this->input->post('playmode'));
			$isremind = intval($this->input->post('isremind'));
			$remindtime = $this->input->post('remindtime');
			$remindmsg = $this->input->post('remindmsg');
			$remindmsg = $this->input->post('remindmsg');
			$remindtimestr = '';
			if(!empty($remindtime) && count($remindtime)>0) {
				foreach($remindtime as $remindt) {
					if(is_numeric($remindt) && $remindt > 0) {
						if($remindtimestr == '')
							$remindtimestr = $remindt*60;
						else
							$remindtimestr = $remindtimestr.','.$remindt*60;	//多个提醒时间以逗号,隔开
					}
				}
			}
			if(!empty($remindmsg) && count($remindmsg)>0) {
				$remindmsgstr = implode('#',$remindmsg);					//多个提醒文字以井号#隔开
			}
			$param['credit'] = $credit;
			$param['creditmode'] = $creditmode;
			$param['playmode'] = $playmode;
			$param['isremind'] = $isremind;
			$param['remindtime'] = empty($remindtimestr)?'':$remindtimestr;
			$param['remindmsg'] = empty($remindmsgstr)?'':$remindmsgstr;
			$param['coursewarelogo'] = 1;
		}
		$pid = $this->input->post('pid');
		$isajax = $this->input->post('isajax');
		if(!empty($pid) && !empty($isajax)){//新版添加课程,判断所选服务包/分类 是否还存在
			$this->checkSp($roominfo);
		}
		$res = $folder->editcourse($param);
		if($res !== FALSE && !empty($isajax)){
			$this->editPayitem($roominfo,$folderid);
		}
		
		/**写日志开始**/
		$message = '['.implode(',', $param).']';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['folderid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'folder'
				)
		);
		/**写日志结束**/
		if(empty($isajax))
			header('location:'.geturl('aroomv2/course/courselist'));
		
	}
	
	public function getimages(){
        $roominfo = Ebh::app()->room->getcurroom();
        if ($roominfo['template'] == 'plate') {
            $pre_path = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/';
			$imgcount = 96;
        } else {
            $pre_path = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimg/';
			$imgcount = 92;
        }

		$imgarr = array();
		for($i=1;$i<=$imgcount;$i++){
			$imgarr[] = $pre_path.$i.'.jpg'; 
		}
		$imgarr[] = $pre_path.'guwen.jpg';
		return $imgarr;
	}
	
	/**
	 * 
	 * @param int $n 用来指定分页的页码
	 */
	//用来产生课程管理封面图片的接口
	public function getCoverImg(){
	    $n = $this->input->get('pagenum');
	    //$n = $_GET['pagenum'];
	    $coverimgmodel = $this->model('Folder');
	    $imgres = $coverimgmodel->selectimg( $n );
	    $data = array();
	    for($i=0;$i<count($imgres);$i++){
	        $data[] = $imgres[$i]['img'];
	    }
	    if($data){
	        $res['code'] = 0;
	        $res['message'] = '图片加载成功'; 
	        $res['data'] = $data;
	       /*  echo "<pre>";
	        var_dump($res);die; */
	        echo json_encode($res);
	    }else{
	        $res['code'] = 1;
	        $res['message'] = '图片加载失败'; 
	        echo json_encode($res);
	    }
	}
	
	//ebhp课件弹出页面
	public function view() {
        $cwid = $this->uri->itemid;
		if(!is_numeric($cwid))
			exit();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course))
			exit();
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		$user = Ebh::app()->user->getloginuser();
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('user',$user);
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
		} else {
			$course['m3u8url'] = '';
		}
        $this->assign('course', $course);
		$this->assign('source',$source);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		if($type != 'flv' && $course['ism3u8'] == 1) {
			$type = 'flv';
		}
		$this->assign('type',$type);
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'limit'=>'0,100');
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamlistbycwid($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		
		$this->assign('exams',$exams);
		//获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
		//获取课件下的评论记录
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('roominfo', $roominfo);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
        $this->display('aroomv2/course_view');
    }
	/*
	查看课程下课件列表
	*/
	public function cwlist_view(){
		$folderid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['folderid'] = $folderid;
		$param['crid'] = $roominfo['crid'];
		$param['status'] = 1;
		$cwmodel = $this->model('courseware');
		$cwlist = $cwmodel->getfolderseccourselist($param);
		$cwcount = $cwmodel->getfolderseccoursecount($param);
		$pagestr = show_page($cwcount);
		$this->assign('cwlist',$cwlist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/course_cwlist');
		
	}
	/*
	删除课件
	*/
	public function delcw() {
		$cwid = intval($this->input->post('courseid'));
		if($cwid <= 0) {
			$arr = array('status'=>-1,'msg'=>'非法参数');
			echo json_encode($arr);
			exit();
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$coursemodel = $this->model('Courseware');
		$course = $coursemodel->getcoursedetail($cwid);
		if(empty($course)) {
			$arr = array('status'=>-1,'msg'=>'课件不存在');
			echo json_encode($arr);
			exit();
		} else {
			if($roominfo['crid'] != $course['crid']) {
				$arr = array('status'=>-1,'msg'=>'无权操作');
				echo json_encode($arr);
				exit();
			}
			$queryarr = array('cwid'=>$cwid);
			$result = $coursemodel->editcourseware(array('cwid'=>$cwid,'status'=>-3));
			if($result) {
	            $foldermodel = $this->model('Folder');
				$folderid = $course['folderid'];
				$folder = $foldermodel->getfolderbyid($folderid);
				$folderlevel = $folder['folderlevel'];
				while($folderlevel>1){
					$foldermodel->addcoursenum($folderid,-1);
					$folder = $foldermodel->getfolderbyid($folder['upid']);
					$folderlevel = $folder['folderlevel'];
					$folderid = $folder['folderid'];
				}
	            
	            $roommodel = $this->model('Classroom');
	            $roommodel->addcoursenum($roominfo['crid'],-1);
	            $teachermodel = $this->model('Teacher');
	            $teachermodel->addcoursenum($course['uid'],-1);
	            echo json_encode(array('status'=>1,'msg'=>"删除成功"));
	        } else {
	            echo json_encode(array('status'=>-1,'msg'=>"删除失败，请联系管理员或稍后再试"));
	        }
		}

	}
	public function sub_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid,1);
		$this->display('aroomv2/course_sub');
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
	上移下移课程
	*/
	public function move(){
		$roominfo = Ebh::app()->room->getcurroom();
		$foldermodel = $this->model('folder');
        if ($roominfo['isschool'] == 7) {
            $pid = intval($this->input->post('pid'));
            $sid = intval($this->input->post('sid'));
            $folderid = intval($this->input->post('folderid'));
            $flag = intval($this->input->post('flag'));
            if ($pid < 1 || $sid < 0 || $folderid < 1) {
                echo 0;
                exit();
            }
            $ret = $foldermodel->changeOrder(array(
                'pid' => $pid,
                'sid' => $sid,
                'folderid' => $folderid,
                'is_increase' => $flag == 1
            ), $roominfo['crid']);
            echo intval($ret);
            exit();
        }

        $folderid = $this->input->post('folderid');
        $flag = $this->input->post('flag');
		if($flag == 1){
			$res = $foldermodel->moveit(array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'compare'=>'<','order'=>'displayorder desc,folderid asc'));
		}else{
			$res = $foldermodel->moveit(array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'compare'=>'>','order'=>'displayorder asc,folderid asc'));
		}
		
		if($res)
			echo 1;
		else
			echo 0;
	}
	
	/*
	课程介绍
	*/
	public function introduce_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		if(!is_numeric($folderid))
			exit;
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		if(!empty($folder['introduce']))
			$folder['introduce'] = unserialize($folder['introduce']);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor', $editor);
		$this->assign('folder',$folder);
		$this->assign('roominfo',$roominfo);
		$this->display('aroomv2/course_introduce');
	}
	
	/*
	课程介绍添加模块弹出框
	*/
	public function introduce_add_view(){
		$folderid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
        $roommodel = $this->model('Classroom');
        $myroom = $roommodel->getdetailclassroom($roominfo['crid']);
        $editor = Ebh::app()->lib('UMEditor');
        $this->assign('editor', $editor);
        $this->assign('myroom', $myroom);
		$this->assign('folderid',$folderid);
		$this->display('aroomv2/course_introduce_add');
	}
	
	public function introduce_save(){
		$folderid = $this->input->post('folderid');
		if(!is_numeric($folderid))
			exit;
		$roominfo = Ebh::app()->room->getcurroom();
		$introducearr = $this->input->post('introducearr');
		$param['introduce'] = serialize($introducearr);
		$param['folderid'] = $folderid;
		$param['crid'] = $roominfo['crid'];
		$fmodel = $this->model('folder');
		$res = $fmodel->editcourse($param);
		if($res != false){
			echo 'success';
		}
		
	}

	/**
	 * 关联知识点
	 */
	public function selectchapter() {
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['folderid'] = $this->input->post('folderid');
		$param['chapterid'] = $this->input->post('chapterid');
		$result = $this->model('folder')->selectchapter($param);
		if ($result !== FALSE)
			echo '1';
		else
			echo '0';
	}
}