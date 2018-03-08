<?php
/**
 * 调查问卷
 */
class SurveyController extends CControl {
	public function __construct() {
		parent::__construct();
		Ebh::app()->room->checkteacher();
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['ispublish'] = 1;
		$param['filteruid'] = $user['uid'];
        $param['untype'] = 3;
		$surveylist = $this->model('survey')->getSurveyList($param);
        foreach($surveylist as &$v){
            $user = $this->model('user')->getuserbyuid($v['uid']);
            $v['realname'] = $user['realname'];
        }
		$surveycount = $this->model('survey')->getSurveyCount($param);
		$pagestr = show_page($surveycount);

        $classname = $this->model('appmodule')->getClassnameByCode(array('modulecode'=>'survey'));
        $this->assign('classname',$classname['classname']);
		$this->assign('pagestr',$pagestr);
		$this->assign('surveylist',$surveylist);
		$this->assign('user',$user);
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'survey','tors'=>1,'crid'=>$roominfo['crid']));
		$this->display('troomv2/survey');
	}

	public function my(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['teacherid'] = $user['uid'];
        $param['untype'] = 3;
		$surveylist = $this->model('survey')->getSurveyList($param);
		$surveycount = $this->model('survey')->getSurveyCount($param);
		$pagestr = show_page($surveycount);

        $classname = $this->model('appmodule')->getClassnameByCode(array('modulecode'=>'survey'));

        $this->assign('classname',$classname['classname']);
		$this->assign('pagestr',$pagestr);
		$this->assign('surveylist',$surveylist);
		$this->assign('user',$user);
		//获取modulename
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'survey','tors'=>1,'crid'=>$roominfo['crid']));
		$this->display('troomv2/survey_my');
	}

	public function add(){
		$roominfo = Ebh::app()->room->getcurroom();
		//课程列表
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$param['limit'] = 1000;
		$courselist = $this->model('folder')->getfolderlist($param);
		//编辑器
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor', $editor);

        //选课问卷
        $get = $this->input->get();
        if(!empty($get['xkid'])){
            $this->assign('xkid',$get['xkid']);
        }else{
            $this->assign('xkid',0);
        }
		$this->assign('courselist',$courselist);
        $this->assign('roominfo',$roominfo);
		$this->display('troomv2/survey_add');
	}

	/**
	 * 保存问卷
	 */
	public function save(){
		$param['sid'] = $this->input->post('sid');
		$param['etype'] = $this->input->post('etype');
		$param['eid'] = $this->input->post('eid');
		$param['content'] = $this->input->post('content');
		//保存前先检查权限(管理员是否对该问卷所属学校有权限)
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->save($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1, 'content' => $param['content']));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}
	}

	/**
	 * 创建新问卷
	 */
	public function create(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();

		$title = $this->input->post('title');
		$content = $this->input->post('content');
        $xkid = $this->input->post('xkid');
		//创建问卷主体内容
        if(!empty($xkid)){
            $param['xkid'] = $xkid;
            $param['uid'] = $user['uid'];
            $param['crid'] = $roominfo['crid'];
            $param['pagesize'] = 10000;
            $courselist = $this->model('xuanke')->getCourseList($param);
            $errormsg = array();

            foreach($courselist as $course){
                $survey = $this->model('survey')->getSurveyByCid(array('cid'=>$course['cid']));
                if(!empty($survey)){
                    /*$errormsg[]=$course['coursename'].'已有问卷,不能继续添加';
                    echo '已有问卷不能添加';
                    exit();*/
                    continue;
                }
                $param['title'] = $title;
                $param['uid'] = $user['uid'];
                $param['type'] = 3;
                $param['allowview'] = 0;
                $param['allowanonymous'] = $this->input->post('allowanonymous');
                $startdate = $this->input->post('startdate');
                $param['startdate'] = empty($startdate) ? 0 : strtotime($startdate);
                $enddate = $this->input->post('enddate');
                $param['enddate'] = empty($enddate) ? 0 : strtotime($enddate);//+86399;
                if ($startdate <= 0 || $enddate <=0 || $startdate > $enddate) {
                    echo 0;
                    exit;
                }
                $param['crid'] = $roominfo['crid'];
                $param['ispublish'] = 1;
                $param['folderid'] = 0;
                $param['cwid'] = 0;
                $param['cid'] = $course['cid'];
                $sid = $this->model('survey')->add($param);
                foreach($content as $value){
                    $new_question = $this->model('survey')->addQuestion(array('sid'=>$sid, 'type'=>$value['type'], 'title'=>$value['title']));
                    if($value['type'] != 4 && is_array($value['item'])){
                        foreach ($value['item'] as $item) {
                            $this->model('survey')->addOption(array('sid' => $new_question['sid'], 'qid' => $new_question['qid'], 'content' => $item));
                        }
                    }
                }
                if(false === $sid) {
                    $errormsg[] = $course['coursename'] . '发布失败';
                }
            }
            $this->model('xuanke')->fbxk(array('status'=>8,'survey_time'=>time()),array('xkid'=>$xkid));
            echo 1;
        }else{
        	//设置问卷信息
            $param['title'] = $title;
            $param['uid'] = $user['uid'];
            //type类型 0网校主页,1学生学习主页,2相关课件页,3选课问卷,4开通课程前的问卷,5登录前问卷,6开通服务后问卷
            $param['type'] = $this->input->post('relatetype');
            $param['allowview'] = $this->input->post('allowview');
            $param['allowanonymous'] = $this->input->post('allowanonymous');
			$startdate = $this->input->post('startdate');
			$param['startdate'] = empty($startdate) ? 0 : strtotime($startdate);
			$enddate = $this->input->post('enddate');
			$param['enddate'] = empty($enddate) ? 0 : strtotime($enddate);
            $param['crid'] = $roominfo['crid'];
            $param['ispublish'] = 1;
            $param['folderid'] = 0;
            $param['cwid'] = 0;
            if($param['type'] == 2){
                $param['folderid'] = $this->input->post('folderid');
                $param['cwid'] = $this->input->post('cwid');
                $survey = $this->model('survey')->getSurveyByCwid($param['cwid'],0);
                if(!empty($survey)){
                    echo '该课下已有问卷,不能继续添加';
                    exit;
                }
            }
            //首次登录问卷判断班级信息是否填写
            if(!empty($param['type']) && ($param['type'] == 5)){
                $isroomclass = $this->input->post('isroomclass');   //0全校,1指定年级/班级(存于缓存)
                $classids = $this->input->post('classids');         //班级id集
                if(!empty($classids) && is_array($classids)){
                    $classids = array_filter($classids, function($classid) {
                        return is_numeric($classid) && ($classid>0);
                    });
                }
                $isroomclass = (!empty($isroomclass) && ($isroomclass==1)) ? 1 : 0;
                $classids = !empty($classids) ? $classids : array();
                if(($isroomclass == 1) && empty($classids)){//当登录前问卷有指定年级/班级,班级id集不能为空
                    echo '请选择年级/班级信息';
                    exit;
                }
            }
            //创建开通服务后问卷时,需要判断开通服务的课程信息是否填写完整
            if(!empty($param['type']) && ($param['type'] == 6)){
                if(empty($param['startdate']) || empty($param['enddate'])){//问卷必须填写开始和结束时间
                    echo '请选择开通服务调查问卷的开始和结束时间';
                    exit;
                }
                $folderids = $this->input->post('folderids');         //课程id集
                if(!empty($folderids) && is_array($folderids)){     //过滤数组
                    $folderids = array_filter($folderids, function($folderid) {
                        return is_numeric($folderid) && ($folderid>0);
                    });
                }
                $folderids = !empty($folderids) ? $folderids : array();
                if(empty($folderids)){  //课程id集不能为空
                    echo '请选择开通服务的课程信息';
                    exit;
                }
            }

            $sid = $this->model('survey')->add($param);
            foreach($content as $value){
                $new_question = $this->model('survey')->addQuestion(array('sid'=>$sid, 'type'=>$value['type'], 'title'=>$value['title']));
                if($value['type'] != 4 && is_array($value['item'])){
                    foreach ($value['item'] as $item) {
                        $this->model('survey')->addOption(array('sid' => $new_question['sid'], 'qid' => $new_question['qid'], 'content' => $item));
                    }
                }
            }
            if(false !== $sid){
                echo 1;
                fastcgi_finish_request();
                //创建登录前首次问卷,添加到缓存
                if(!empty($roominfo['crid']) && !empty($param['type']) && $param['type']==5){
                    $redis = Ebh::app()->getCache('cache_redis');
                    $redis_key = 'loginsurvey_' . $roominfo['crid'];
                    if(!empty($param['startdate'])){
                        if(!empty($param['enddate'])){
                            $timeout = intval($param['enddate']) - SYSTIME;
                            if($timeout>0){
                                $surveydata = json_encode(array('crid'=>$roominfo['crid'],'sid'=>$sid,'timeout'=>$timeout,'isroomclass'=>$isroomclass,'classids'=>$classids));
                                $redis->set($redis_key,$surveydata,$timeout);//添加网校id到缓存中，调查问卷有效期为$timeout
                            }
                        }else{
                            $surveydata = json_encode(array('crid'=>$roominfo['crid'],'sid'=>$sid,'timeout'=>0,'isroomclass'=>$isroomclass,'classids'=>$classids));
                            $redis->set($redis_key,$surveydata);//添加网校id到缓存中,有效期永久有效
                        }
                    }
                }
                //创建开通服务后问卷,添加到缓存
                if(!empty($roominfo['crid']) && !empty($param['type']) && $param['type']==6){
                    if(!empty($param['startdate']) && !empty($param['startdate'])){
                        $redis = Ebh::app()->getCache('cache_redis');
                        $timeout = intval($param['enddate']) - SYSTIME;
                        if($timeout>0){
                            foreach ($folderids as $folderid){
                                $surveydata = json_encode(array('crid'=>$roominfo['crid'],'sid'=>$sid,'startdate'=>$startdate,'enddate'=>$enddate,'folderid'=>$folderid));
                                $redis_key = 'payitemsurvey_' . $roominfo['crid'].'_'.$folderid;    //开通服务后问卷的缓存
                                $redis->set($redis_key,$surveydata,$timeout);   //添加到缓存中，调查问卷有效期为$timeout
                            }
                        }
                    }
                }
            }else{
                echo '发布失败';
            }
        }
	}

	public function publish(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param['sid'] = $this->input->post('sid');
        $xkid = $this->input->post('xkid');
        if(empty($xkid)){
            $param['type'] = $this->input->post('relatetype');
        }else{
            $param['type'] = 3;
        }
		$param['allowview'] = $this->input->post('allowview');
		$param['allowanonymous'] = $this->input->post('allowanonymous');
		$startdate = $this->input->post('startdate');
		$param['startdate'] = empty($startdate) ? 0 : strtotime($startdate);
		$enddate = $this->input->post('enddate');
		$param['enddate'] = empty($enddate) ? 0 : strtotime($enddate);
		$param['crid'] = $roominfo['crid'];
		$param['ispublish'] = 1;
		$param['folderid'] = 0;
		$param['cwid'] = 0; 

		//检查该问卷是否是属于当前用户
		$survey = $this->model('survey')->getSurveyDetail(array('sid'=>$param['sid'],'crid'=>$param['crid']));
		if (empty($survey) || $survey['uid'] != $user['uid']){
			echo '发布失败';
			exit;
		}

		if($param['type'] == 2){
			$param['folderid'] = $this->input->post('folderid');
			$param['cwid'] = $this->input->post('cwid');
			$survey = $this->model('survey')->getSurveyByCwid($param['cwid'],0);
			if(!empty($survey) && $survey['sid'] != $param['sid']){
				echo '该课下已有问卷,不能继续添加';
				exit;
			}
		}
        if($param['type'] == 5){
            echo '登录前问卷,不能编辑和重新发布';
            exit;
        }
        if($param['type'] == 6){
            echo '开通服务后问卷,不能编辑和重新发布';
            exit;
        }
        $res = $this->model('survey')->edit($param);
        if(false !== $res){
            echo 1;
		}else{
            echo '发布失败';
        }
	}

	/**
	 * 编辑
	 */
	public function edit_view(){
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);
		//检查该问卷是否是属于当前用户
		if (empty($survey) || $survey['uid'] != $user['uid']){
			exit;
		}
		//如果有回答的，删除所有回答,并且重置所有选项计数
		if (!empty($survey['answernum']))
		{
			$this->model('survey')->delanswers(array('sid'=>$survey['sid']));
			$this->model('survey')->resetOptionCount(array('sid'=>$survey['sid']));
		}
		//编辑前将发布状态改为0,回答数改为0
		$this->model('survey')->edit(array('sid'=>$sid,'crid'=>$roominfo['crid'],'ispublish'=>0,'answernum'=>0));

		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($survey['folderid']);
			$relateinfo['folderid'] = $folder['folderid'];
			$relateinfo['foldername'] = $folder['foldername'];

			$cwmodel = $this->model('courseware');
			$cw = $cwmodel->getSimplecourseByCwid($survey['cwid']);
			$relateinfo['cwid'] = $cw['cwid'];
			$relateinfo['title'] = $cw['title'];
		}

        //选课问卷
        $get = $this->input->get();
        if(!empty($get['xkid'])){
            $this->assign('xkid',$get['xkid']);
        }else{
            $this->assign('xkid',0);
        }

		//课程列表
		$courselist = $this->model('Classsubject')->getsubjectlistbytid($roominfo['crid'],$user['uid']);
		//编辑器
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor', $editor);

		$this->assign('courselist',$courselist);
		$this->assign('relateinfo',$relateinfo);
		$this->assign('survey', $survey);
		$this->display('troomv2/survey_edit');
	}

	/**
	 * 预览问卷
	 */
	public function preview_view(){
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);
		$this->assign('survey', $survey);
		$this->display('aroomv2/survey_preview');
	}

	/**
	 * 添加问题
	 */
	public function addquestion(){
		$param['sid'] = $this->input->post('sid');
		$param['type'] = $this->input->post('type');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$this->_checkprivilege($param['sid']);
		$new_question = $this->model('survey')->addQuestion($param);
		if ($new_question !== FALSE)
		{
			//添加两个选项
			$new_optionlist = array();
			for ($i=0; $i <2 ; $i++) {
				$new_option = $this->model('survey')->addOption(array('sid' => $new_question['sid'], 'qid' => $new_question['qid']));
				if (!empty($new_option))
				{
					$new_optionlist[] = $new_option;
				}
			}

			echo json_encode(array('status' => 1, 'question' => $new_question, 'optionlist' => $new_optionlist));
			exit;
		}

		echo json_encode(array('status' => 0));
		exit;
	}

	public function deletequestion(){
		$param['qid'] = $this->input->post('qid');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$question = $this->model('survey')->getOneQuestion($param['qid']);
		$param['sid'] = $question['sid'];
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->deleteQuestion($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 移动问题
	 */
	public function movequestion(){
		$param['qid'] = $this->input->post('qid');
		$param['direction'] = $this->input->post('direction');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$question = $this->model('survey')->getOneQuestion($param['qid']);
		$param['sid'] = $question['sid'];
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->moveQuestion($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 添加选项
	 */
	public function addoption(){
		$param['qid'] = $this->input->post('qid');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$question = $this->model('survey')->getOneQuestion($param['qid']);
		$param['sid'] = $question['sid'];
		$this->_checkprivilege($param['sid']);
		$new_option = $this->model('survey')->addOption($param);
		if ($new_option !== FALSE)
		{
			$new_option['type'] = $question['type'];
			echo json_encode(array('status' => 1, 'option' => $new_option));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 删除选项
	 */
	public function deleteoption(){
		$param['sid'] = $this->input->post('sid');
		$param['opid'] = $this->input->post('opid');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->deleteOption($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 移动选项
	 */
	public function moveoption(){
		$param['sid'] = $this->input->post('sid');
		$param['opid'] = $this->input->post('opid');
		$param['direction'] = $this->input->post('direction');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->moveOption($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 获得问卷回答数
	 */
	function getanswernum(){
		$param['sid'] = $this->input->post('sid');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$survey = $this->model('survey')->getSurveyDetail($param);
		echo empty($survey['answernum']) ? 0 : $survey['answernum'];
	}
	/**
	 * 检查权限(管理员是否对该问卷所属学校是否有权限)
	 * @param  integer $sid 问卷编号
	 */
	public function _checkprivilege($sid) {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$check = $this->model('survey')->checkEdit(array('sid' => $sid, 'crid' => $roominfo['crid'], 'uid' => $user['uid']));
		if ( ! $check)
		{
			echo json_encode(array('status' => 0));
			exit;
		}
	}

	public function delete(){
		$sid = $this->input->post('sid');
		if(!is_numeric($sid))
			return false;
		$roominfo = Ebh::app()->room->getcurroom();
        if(empty($roominfo['crid'])){
            return false;
        }
		$user = Ebh::app()->user->getloginuser();
        $apiServer = Ebh::app()->getApiServer('ebh');
        $surveyinfo = $apiServer->reSetting()->setService('Classroom.Survey.getLastSurvey')->addParams(array('crid' =>$roominfo['crid'],'type'=>5))->request();
		$smodel = $this->model('survey');
		$res = $smodel->delete(array('sid'=>$sid,'crid'=>$roominfo['crid'],'uid'=>$user['uid']));
		if(false != $res){
            echo 1;
            fastcgi_finish_request();
            //如果删除的最新一条登录前首次问卷，则删除缓存
            if(!empty($surveyinfo['sid']) && ($surveyinfo['sid']==$sid)){
                $redis = Ebh::app()->getCache('cache_redis');
                $redis_key = 'loginsurvey_' . $roominfo['crid'];
                $redis->remove($redis_key);//删除缓存中网校id
            }
        }else{
            echo 0;
        }
	}
	
	/*
	选择课件
	*/
	public function box_cw_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		
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
		$queryarr['status'] = 1;
		$queryarr['uid'] = $user['uid'];
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
        $this->assign('sectionlist', $sectionlist);
        $this->assign('from',1);
        $this->assign('pagestr', $pagestr);
        //分配folderid
        $this->assign('folderid',$folderid);
        //分配教室信息
        $this->assign('roominfo',$roominfo);
        
        $this->display('aroomv2/survey_cwbox');
	}
	
	/*
	统计
	*/
	public function stat_view(){
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);

		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
			$cwmodel = $this->model('courseware');
			$cw = $cwmodel->getSimplecourseByCwid($survey['cwid']);
			$relateinfo = array('type'=>'课件','title'=>$cw['title']);
		}

		$this->assign('survey',$survey);
		$this->assign('relateinfo', $relateinfo);
		$this->display('troomv2/survey_stat');
	}

	//上传图片页面
	public function uploadimage() {
		$upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('upcontrol', $upcontrol);
		$this->display('aroomv2/survey_uploadimage');
	}

    //弹出网校的班级/年级列表框
    public function addClass() {
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->display('troomv2/survey_addclass');
    }

	//获取网校的班级列表（根据网校/年级）
	public function getRoomList() {
	    $param = array();
        $roomlist = array();
		$post = $this->input->post();
        $roominfo = Ebh::app()->room->getcurroom();
        $param['crid'] = $roominfo['crid'];
        if(($post['k'] != null) && ($post['k'] != '')){
            $param['k'] = h($post['k']);
        }
        if(!empty($post['grade'])){
            $param['grade'] = intval($post['grade']);//年级
        }
        $ret = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Classes.getRoomList')->addParams($param)->request();
        if(!empty($ret) && is_array($ret)){
            $roomlist = $ret;
        }
        return  renderjson(0, '查询成功', $roomlist);
	}

    //弹出课程列表框
    public function addCourse() {
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->display('troomv2/survey_addcourse');
    }
}
?>