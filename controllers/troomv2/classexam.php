<?php
/**
 * 班级作业控制器类ClassexamController
 */
class ClassexamController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        
    }
    public function index() {
        $get = $this->input->get();
    	$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user',$user);
        $param = parsequery();
//        $classmodel = $this->model('Classes');
//        $classes = $classmodel->getTeacherClassList($roominfo['crid'],$user['uid']);
//        $gradeids='';
//        $classids='';
//        foreach($classes as $class){
//            if(empty($classids)){
//                $classids=$class['classid'];
//            }else{
//                $classids.=','.$class['classid'];
//            }
//            if(!empty($class['grade'])){
//                if(empty($gradeids)){
//                    $gradeids=$class['grade'];
//                }else{
//                    $gradeids.=','.$class['grade'];
//                }
//            }
//        }
//        //获取教师课程
//        $folderlist = $this->model('folder')->getTeacherFolderList(array('crid'=>$roominfo['crid'],'uid'=>$user['uid']));
//        $folderids = array();
//        foreach($folderlist[$user['uid']]['folder'] as $folder){
//           $folderids[]=$folder['folderid'];
//        }
//        $folderids = implode(',',$folderids);
//        $param['folderid'] = $folderids;
        $param['crid'] = $roominfo['crid'];
//        $param['grade'] = $gradeids;
        $param['tid'] = $user['uid'];
        $param['q'] = $get['q'];
//        $param['district'] = 1;
//        $param['classid'] = $classids;
//        $param['grade'] = $gradeids;
        $param['all'] = 1;
        $cexamslist = $this->model('exam')->getschexamlist($param);
        if(!empty($cexamslist)){
            foreach($cexamslist as &$cexam){
                if(!empty($cexam['grade'])) {
                    $param['grade'] = $cexam['grade'];
                    $classes = $this->model('classes')->getClasses($param);
                    $classesname = '';
                    foreach($classes as $k=>$v){
                        if(empty($classesname)){
                            $classesname .= $v['classname'];
                        }else{
                            $classesname .= '、'.$v['classname'];
                        }
                    }
                    $cexam['classname_t'] = $classesname;
                    $grade = Ebh::app()->getconfig()->load('grademap');
                    foreach($grade as $k=>$v){
                        if($k==$cexam['grade']){
                            $cexam['classname'] = $v;
                            break;
                        }
                    }
                }
            }
        }
        $count = $this->model('exam')->getschexamlistcount($param);
        $pagestr = show_page($count);

        $this->assign('q',$get['q']);
        $this->assign('cexamslist',$cexamslist);
//        p($cexamslist);die;
        $this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		//获取modulename
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'myexam','tors'=>1,'crid'=>$roominfo['crid']));
		$this->display('troomv2/classexam');
    }
	/*
	*批改作业
	*/
	public function cor(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classmodel = $this->model('Classes');
        $param = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'type'=>0);
        $cexams = $classmodel->getTeacherclassexam($param);

        $this->assign('cexams', $cexams);
        $this->display('troomv2/classexam_cor');
		$this->_updateuserstate();
	}
	/**
	*班级作业对应的具体班级
	*/
	public function my() {
		$classid = $this->uri->uri_attr(0);
		if(is_numeric($classid) && $classid > 0) {
			$roominfo = Ebh::app()->room->getcurroom();
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
			if(empty($myclass))
				exit;
			$exammodel = $this->model('Exam');
			$param = parsequery();
			$param['crid'] = $roominfo['crid'];
			$param['classid'] = $classid;
			$param['type'] = array(0,2); //作业
			if(!empty($myclass['grade'])) {	//加上年级作业信息
				$param['grade'] = $myclass['grade'];
				$param['district'] = $myclass['district'];
			}
			$user = Ebh::app()->user->getloginuser();
			$param['uid'] = $user['uid'];
			$exams = $exammodel->getschexamlist($param);
			$count = $exammodel->getschexamlistcount($param);
			$pagestr = show_page($count);
			$this->assign('exams',$exams);
			$this->assign('pagestr',$pagestr);
			$this->assign('roominfo',$roominfo);
			$this->assign('uid',$user['uid']);
			$this->assign('myclass',$myclass);
			$this->display('troomv2/classexam_my');
		}
	}

    /**
     * 年级作业对应的作业批阅
     */
    public function all_g() {
        $classid = $this->uri->uri_attr(0);
        $eid = $this->uri->uri_attr(1);
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $exammodel = $this->model('Exam');
        $classmodel = $this->model('Classes');
        $myexam = $exammodel->getschexambyeid($eid);
        if(empty($myexam))
            exit();
        $classes = $classmodel->getClasses(array('crid'=>$roominfo['crid'],'grade'=>$myexam['grade']));
        if(empty($classid)){
            $classid = '';
            foreach($classes as &$class){
                if(empty($classid)){
                    $classid = $class['classid'];
                }else{
                    $classid .= ','.$class['classid'];
                }
            }
        }else{
            $myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
            $this->assign('classid',$classid);
            if(empty($myclass))
                exit();
        }
        if(empty($classid) || !is_numeric($eid) || $eid <= 0 ) {
            exit();
        }
        $sort = $this->uri->sortmode;
//        $myclass['classid'] = 0;
        $param = array();
        if(isset($get['status'])&&$get['status']==1){
            $param['eastatus'] = $get['status'];
        }
        $param['eid'] = $eid;
        $param['classid'] = $classid;
        if(!empty($myexam['grade'])) {
            $param['grade'] = $myexam['grade'];
            $param['district'] = $myexam['district'];
        }
        $param['limit'] = 1000;
        $param['order'] = '`status` desc';
        if($sort == 1) {	//按答题用时倒叙排序
            $param['order'] .= ',ea.completetime desc';
        } else if ($sort == 2) {
            $param['order'] .= ',ea.completetime';
        } else if ($sort == 3) {
            $param['order'] .= ',ea.totalscore desc';
        } else if ($sort == 4) {
            $param['order'] .= ',ea.totalscore';
        }
        if(!empty($myexam['grade'])) {
            $answers = array();
//            if($get['status']!=2){
            $param['crid'] = $roominfo['crid'];
            $answerlist = $exammodel->getschexamanswerlistbygrade($param);
            foreach($answerlist as $myanswer) {
                $answers[$myanswer['uid']] = $myanswer;
            }
//        }
            //需要加上未答的学生列表
            if($get['status']!=1){
                $studentlist = $classmodel->getClassStudentList(array('classid'=>$classid,'limit'=>'1000'));
                if($get['status']==2){//单独拿出未提交作业学生
//                p($answers);die;
                    foreach($studentlist as $mystudent) {
                        if(!isset($answers[$mystudent['uid']])) {
                            $unanswers[$mystudent['uid']] = array('aid'=>'','face'=>$mystudent['face'],'sex'=>$mystudent['sex'],'totalscore'=>0,'remark'=>'','username'=>$mystudent['username'],'realname'=>$mystudent['realname']);
                        }
                    }
                    $answers = $unanswers;
                }else{
                    foreach($studentlist as $mystudent) {
                        if(!isset($answers[$mystudent['uid']])) {
                            $answers[$mystudent['uid']] = array('aid'=>'','face'=>$mystudent['face'],'sex'=>$mystudent['sex'],'totalscore'=>0,'remark'=>'','username'=>$mystudent['username'],'realname'=>$mystudent['realname']);
                        }
                    }
                }
            }
        } else {
            if(isset($get['status'])&&$get['status']==2){
                $param['eastatus'] = 2;
            }
            $answers = $exammodel->getschexamanswerlistbyeid($param);
        }
        //获取已答数
        $answercount = 0;
        foreach($answers as $myanswer) {
            if(!empty($myanswer['aid']) && !empty($myanswer['status'])) {
                $answercount ++;
            }
        }
        $myexam['answercount'] = $answercount;
        //批阅人数
        $correctcount = $exammodel->getRoomExamCount($classid,$eid,1);
        $myexam['correctcount'] = $correctcount;
        //年级名称
        $grade = Ebh::app()->getconfig()->load('grademap');
        foreach($grade as $k=>$v){
            if($k==$myexam['grade']){
                $myexam['gradename'] = $v;
                break;
            }
        }
//        $this->assign('cuur',$_GET['cuur']);
        $this->assign('status',$get['status']);
        $this->assign('sort',$sort);
        $this->assign('myexam',$myexam);
        $this->assign('answers',$answers);
        $this->assign('roominfo',$roominfo);
        $this->assign('classes',$classes);
        $this->assign('myclass',$myclass);
        $this->display('troomv2/classexam_all_g');
    }

	/**
	*班级作业对应的作业批阅
	*/
	public function all() {
		$classid = $this->uri->uri_attr(0);
		$eid = $this->uri->uri_attr(1);
        $get = $this->input->get();
		if(!is_numeric($classid) || $classid <= 0 || !is_numeric($eid) || $eid <= 0 ) {
			exit();
		}
		$sort = $this->uri->sortmode;
		$roominfo = Ebh::app()->room->getcurroom();
		$classmodel = $this->model('Classes');
        //获取班级详情
		$myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
		if(empty($myclass))
			exit();
		$exammodel = $this->model('Exam');
		$myexam = $exammodel->getschexambyeid($eid);
		if(empty($myexam))
			exit();
		$param = array();
        //区分是否提交作业
        if(isset($get['status'])&&$get['status']==1){
            $param['eastatus'] = $get['status'];
        }
		$param['eid'] = $eid;
		$param['classid'] = $classid;
//		if(!empty($myclass['grade'])) {
//			$param['grade'] = $myclass['grade'];
//		}
		$param['limit'] = 1000;
		$param['order'] = '`status` desc';
		if($sort == 1) {	//按答题用时倒叙排序
			$param['order'] .= ',ea.completetime desc';
		} else if ($sort == 2) {
			$param['order'] .= ',ea.completetime';
		} else if ($sort == 3) {
			$param['order'] .= ',ea.totalscore desc';
		} else if ($sort == 4) {
			$param['order'] .= ',ea.totalscore';
		}
		if(!empty($myclass['grade'])) {
            $answers = array();
//            if($get['status']!=2){
			$param['crid'] = $roominfo['crid'];
			$answerlist = $exammodel->getschexamanswerlistbygrade($param);
			foreach($answerlist as $myanswer) {
				$answers[$myanswer['uid']] = $myanswer;
			}
//        }
			//需要加上未答的学生列表
            if($get['status']!=1){
			    $studentlist = $classmodel->getClassStudentList(array('classid'=>$classid,'limit'=>'1000'));
                if($get['status']==2){//单独拿出未提交作业学生
    //                p($answers);die;
                    foreach($studentlist as $mystudent) {
                        if(!isset($answers[$mystudent['uid']])) {
                            $unanswers[$mystudent['uid']] = array('aid'=>'','face'=>$mystudent['face'],'sex'=>$mystudent['sex'],'totalscore'=>0,'remark'=>'','username'=>$mystudent['username'],'realname'=>$mystudent['realname']);
                        }
                    }
                    $answers = $unanswers;
                }else{
                    foreach($studentlist as $mystudent) {
                        if(!isset($answers[$mystudent['uid']])) {
                            $answers[$mystudent['uid']] = array('aid'=>'','face'=>$mystudent['face'],'sex'=>$mystudent['sex'],'totalscore'=>0,'remark'=>'','username'=>$mystudent['username'],'realname'=>$mystudent['realname']);
                        }
                    }
                }
            }
		} else {
            if(isset($get['status'])&&$get['status']==2){
                $param['eastatus'] = 2;
            }
			$answers = $exammodel->getschexamanswerlistbyeid($param);
		}
		//获取已答数
		$answercount = 0;
		foreach($answers as $myanswer) {
			if(!empty($myanswer['aid']) && !empty($myanswer['status'])) {
				$answercount ++;
			}
		}
		$myexam['answercount'] = $answercount;
		//批阅人数
		$correctcount = $exammodel->getRoomExamCount($classid,$eid,1);
		$myexam['correctcount'] = $correctcount;
		$this->assign('status',$get['status']);
		$this->assign('sort',$sort);
		$this->assign('myexam',$myexam);
		$this->assign('answers',$answers);
		$this->assign('roominfo',$roominfo);
		$this->assign('myclass',$myclass);
		$this->display('troomv2/classexam_all');
	}

    /**
     *年级作业对应的作业批阅
     */
    public function all_g2(){
        $classid = $this->uri->uri_attr(0);
        $eid = $this->uri->uri_attr(1);
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $exammodel = $this->model('Exam');
        $classmodel = $this->model('Classes');
        $myexam = $exammodel->getschexambyeid($eid);
        if(empty($myexam))
            exit();

        //获取年级下班级id
        $classes = $classmodel->getClasses(array('crid'=>$roominfo['crid'],'grade'=>$myexam['grade']));
        $classids = array();
        foreach($classes as $class){
            $classids[]=$class['classid'];
        }
        $classidstr = implode(',',$classids);


        $param = array();
        $param['eid'] = $eid;
        $param['classid'] = $classid;
        if(!empty($myexam['grade'])) {
            $param['grade'] = $myexam['grade'];
        }
        $param['order'] = '`status` desc';

        $sort = $this->uri->sortmode;
        if($sort == 1) {	//按答题用时倒叙排序
            $param['order'] .= ',sa.completetime desc';
        } else if ($sort == 2) {
            $param['order'] .= ',sa.completetime';
        } else if ($sort == 3) {
            $param['order'] .= ',sa.totalscore desc';
        } else if ($sort == 4) {
            $param['order'] .= ',sa.totalscore';
        }

        //已答列表
        $answerslist = $this->model('exam')->getHomeworkAnswer($param);
        foreach($answerslist as $myanswer) {
            $answers[$myanswer['uid']] = $myanswer;
        }

        //未答学生列表
        $studentlist = $classmodel->getClassStudentList(array('classid'=>$classidstr,'limit'=>'10000'));
        $unanswers=array();
        foreach($studentlist as $student){
            if(!isset($answers[$student['uid']])){
                $unanswers[$student['uid']]=$student;
            }
        }

        //是否提交作业参数
        if(isset($get['status'])){
            $status = $get['status'];
        }else{
            $status = 0;
        }
        //显示不同条件学生列表
        if($status==1){
            $list=$answers;
        }elseif($status==2){
            $list=$unanswers;
        }else{
            if(empty($answers)){
                $list = $unanswers;
            }elseif(empty($unanswers)){
                $list = $answers;
            }else{
                $list = array_merge($answers,$unanswers);
            }
        }

        //年级名称
        $grade = Ebh::app()->getconfig()->load('grademap');
        foreach($grade as $k=>$v){
            if($k==$myexam['grade']){
                $myexam['gradename'] = $v;
                break;
            }
        }
        $this->assign('list',$list);
//        $this->assign('cuur',$_GET['cuur']);
        $this->assign('status',$get['status']);
        $this->assign('sort',$sort);
        $this->assign('myexam',$myexam);
        $this->assign('answers',$answers);
        $this->assign('roominfo',$roominfo);
        $this->assign('classes',$classes);
        $this->display('troomv2/classexam_all_g2');
    }

    /**
     *班级作业对应的作业批阅
     */
    public function all2(){
        $classid = $this->uri->uri_attr(0);
        $eid = $this->uri->uri_attr(1);
        $get = $this->input->get();

        //是否提交作业参数
        if(isset($get['status'])){
            $status = $get['status'];
        }else{
            $status = 0;
        }
        if(!is_numeric($classid) || $classid <= 0 || !is_numeric($eid) || $eid <= 0 ) {
            exit();
        }
        $sort = $this->uri->sortmode;
        $roominfo = Ebh::app()->room->getcurroom();
        $classmodel = $this->model('Classes');

        //获取班级详情
        $myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
        if(empty($myclass))
            exit();
        $exammodel = $this->model('Exam');
        $myexam = $exammodel->getschexambyeid($eid);
        if(empty($myexam))
            exit();

        $param = array();
        //区分是否提交作业
        if(isset($get['status'])&&$get['status']==1){
            $param['eastatus'] = $get['status'];
        }
        $param['eid'] = $eid;
        $param['classid'] = $classid;
        $param['order'] = 'sa.`status` desc';
        $param['crid'] = $roominfo['crid'];

        if($sort == 1) {	//按答题用时倒叙排序
            $param['order'] .= ',sa.completetime desc';
        } else if ($sort == 2) {
            $param['order'] .= ',sa.completetime';
        } else if ($sort == 3) {
            $param['order'] .= ',sa.totalscore desc';
        } else if ($sort == 4) {
            $param['order'] .= ',sa.totalscore';
        }

        //已答列表
        $answerslist = $this->model('exam')->getHomeworkAnswer($param);
        foreach($answerslist as $myanswer) {
            $answers[$myanswer['uid']] = $myanswer;
        }

        //未答列表
        $studentlist = $classmodel->getClassStudentList(array('classid'=>$classid,'limit'=>'1000'));
        $unanswers=array();
        foreach($studentlist as $student){
            if(!isset($answers[$student['uid']])){
                $unanswers[$student['uid']]=$student;
            }
        }

        //显示不同条件学生列表
        if($status==1){
            $list=$answers;
        }elseif($status==2){
            $list=$unanswers;
        }else{
            if(empty($answers)){
                $list = $unanswers;
            }elseif(empty($unanswers)){
                $list = $answers;
            }else{
                $list = array_merge($answers,$unanswers);
            }
        }


        $this->assign('list',$list);
        $this->assign('status',$get['status']);
        $this->assign('sort',$sort);
        $this->assign('myexam',$myexam);
        $this->assign('answers',$answers);
        $this->assign('roominfo',$roominfo);
        $this->assign('myclass',$myclass);
        $this->display('troomv2/classexam_all2');
    }
	
	/**
	 * 教师批量批阅作业
	 * 
	 */
	public function correct(){
		$dopost = $this->input->post('dopost');
		$classmodel = $this->model('Classes');
		$exammodel = $this->model('Exam');
		if($dopost=='correct'){//批量批改
			$post = $this->input->post();
			$startscore = $post['startscore'];
			$endscore = $post['endscore'];
			$aidarr = $post['aidarr'];
			$eid = $post['eid'];
			//var_dump(is_numeric( $startscore <= 0));
			//form验证
			if(!is_numeric($startscore) || $startscore < 0 || !is_numeric($endscore) || $endscore < 0
				|| !is_numeric($eid) || $eid <= 0 ||!preg_match('/\d+(,\d+)*$/',$aidarr)) {
				exit(0);
			}
			
			$user = Ebh::app()->user->getloginuser();
			$param = array(
				'tid' => $user['uid'],
				'aidarr'=>$aidarr,
				'startscore'=>$startscore,
				'endscore'=>$endscore,
				'eid'=>	$eid,
				'remark'=>	$post['remark']		
			);
			
			$nums = $exammodel->correctRoomExam($param);
			$code = ($nums>0)?true:false;
			echo json_encode(array('code'=>$code,'nums'=>$nums));
			exit(0);
		}
	}
	/**
	*更新待批作业用户状态时间
	*/
	private function _updateuserstate() {
		 //更新评论用户状态时间
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $statemodel = $this->model('Userstate');
        $typeid = 1;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
	}
	/**
	*删除作业
	*/
	public function del() {
		$eid = $this->input->post('eid');
		if(is_numeric($eid) && $eid > 0) {
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getloginuser();
			$param = array('eid'=>$eid,'crid'=>$roominfo['crid'],'uid'=>$user['uid']);
			$exammodel = $this->model('Exam');
			$examanswermodel = $this->model('Examanswer');
			$examanserlist = $examanswermodel->getexamanswerlist($eid);//获取所有回答记录
			$afrows = $exammodel->delschexambyeid($param);
			if($afrows > 0)
			{
				echo 1;
				fastcgi_finish_request();
				foreach ($examanserlist as $examanswer)
				{
					//同步SNS数据(学生作业数减1)
					Ebh::app()->lib('Sns')->do_sync($examanswer['uid'], -3);
				}
				//同步SNS数据(教师作业数减1)
				Ebh::app()->lib('Sns')->do_sync($user['uid'], -3);
			}	
			else
				echo 0;
		} else {
			echo 0;
		}
	}
	//老师删除某个学生的已做作业
	public function deleteanswer(){
		$aid = $this->input->post('aid');
		$eid = $this->input->post('eid');
		$uid = $this->input->post('uid');
		$param1 = array(
			'aid'=>intval($aid),
			'uid'=>intval($uid)
			);
		if(false!=($this->model('examanswer')->deleteOne($param1))){
			$this->model('exam')->decAnswerCount($eid);
			$errormodel = $this->model('Errorbook');
			$param2 = array(
					'exid'=>intval($eid),
					'uid' =>intval($uid)
					);
			$errormodel->deletebyExidAndUid($param2);

			echo 1;
			fastcgi_finish_request();
			//同步SNS数据(当删除作业时，学生作业数减1)
			Ebh::app()->lib('Sns')->do_sync($uid, -3);
		}else{
			echo 0;	
		}
	}

	/*
	*作业批阅导出excel
	*/
	public function examexcel(){
		$titleArr = array("账号","姓名","答题时间","用时","得分","评语","答题");

		$roominfo = Ebh::app()->room->getcurroom();
		$classid = $this->uri->uri_attr(0);
		$eid = $this->uri->uri_attr(1);
		if(!is_numeric($classid) || $classid <= 0 || !is_numeric($eid) || $eid <= 0 ) {
			exit();
		}
		$sort = $this->uri->sortmode;
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
		if(empty($myclass))
			exit();
		$exammodel = $this->model('Exam');
		$myexam = $exammodel->getschexambyeid($eid);
		$filename = $myexam['title'];
		$param = array();
		$param['eid'] = $eid;
		$param['classid'] = $classid;
		if(!empty($myclass['grade'])) {
			$param['grade'] = $myclass['grade'];
			$param['district'] = $myclass['district'];
		}
		$param['limit'] = 100;
		if($sort == 1) {	//按答题用时倒叙排序
			$param['order'] = 'ea.completetime desc';
		} else if ($sort == 2) {
			$param['order'] = 'ea.completetime';
		} else if ($sort == 3) {
			$param['order'] = 'ea.totalscore desc';
		} else if ($sort == 4) {
			$param['order'] = 'ea.totalscore';
		}
		if(!empty($myclass['grade'])) {
			$param['crid'] = $roominfo['crid'];
			$answerlist = $exammodel->getschexamanswerlistbygrade($param);
			$answers = array();
			foreach($answerlist as $myanswer) {
				$answers[$myanswer['uid']] = $myanswer;
			}
			//需要加上未答的学生列表
			$studentlist = $classmodel->getClassStudentList(array('classid'=>$classid,'limit'=>'1000'));
			foreach($studentlist as $mystudent) {
				if(!isset($answers[$mystudent['uid']])) {
					$answers[$mystudent['uid']] = array('aid'=>'','sex'=>$mystudent['sex'],'totalscore'=>0,'remark'=>'','username'=>$mystudent['username'],'realname'=>$mystudent['realname']);
				}
			}
		} else {
			$answers = $exammodel->getschexamanswerlistbyeid($param);
		}

		$dataArr = array();//存储数据
		foreach($answers as $tl){
			$rl = (empty($tl['realname'])?$tl['username']:$tl['realname']).'('.($tl['sex']==1?'女':'男').')';
			$ts = (empty($tl['dateline'])|| $tl['status']==0)?'':(date('Y-m-d H:i',$tl['dateline']));
			$qs = (!empty($tl['aid']) && $tl['status']!=0)?ceil($tl['completetime']/60).' 分钟':'';
			$tt = round($tl['totalscore'],2);
			$rm = $tl['remark'];
			$st = (!empty($tl['aid']) && $tl['status']!=0)?'已提交':'未提交';
			array_push($dataArr,array($tl['username'],$rl,$ts,$qs,$tt,$rm,$st));
		}
	//var_dump($dataArr);
		$this->_exportExcel($titleArr,$dataArr,"FFFFFFFF",$filename);
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
				//$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
				$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth(20);//设置列宽
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
					//$pt->getColumnDimension($str)->setAutoSize(true);//单元格每项内容自适应
					$pt->getColumnDimension($str)->setWidth(20);//单元格每项内容宽度
					if(is_numeric($v[$kt])){
						if(empty($manuallywidth))
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);//A列头标题自适应
						$pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
						$pt->getColumnDimension($str)->setWidth(20);//设置单元格宽度
						$pt->setCellValue($p, $v[$kt].' ');//填充内容
					}else{
						$pt->setCellValue($p, $v[$kt]);
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
	*班级作业对应的具体班级
	*/
	public function todayexams() {
		$classid = intval($this->uri->uri_attr(0));
        $classmodel = $this->model('Classes');
		$roominfo = Ebh::app()->room->getcurroom();
        $param = parsequery();
        $param['crid'] = $roominfo['crid'];
        $d = $this->input->get('d');
        if(empty($d)){
        	$d = date('Y-m-d',time());
        }
        $starttime = strtotime($d);
        $endtime = $starttime+3600*24;
        $param['starttime'] = $starttime;
        $param['endtime'] = $endtime;
		if($classid>0){
            $param['classid'] = $classid;
            $myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
            if(!empty($myclass['grade'])) { //加上年级作业信息
                $grade = $param['grade'] = $myclass['grade'];
                $district = $param['district'] = $myclass['district'];
            }
            if(empty($myclass))
            exit;
        }else{
            $myclass['classname'] = "所有班级";
            $param['classid'] = 0;
        }
        $user = Ebh::app()->user->getloginuser();
        $classList = $classmodel->getTeacherClassList($roominfo['crid'],$user['uid']);

        $classDb = array();
        $gradeDb = array();
        $gradeClassDb = array();
        $gradeClassMapDb = array();
        if(!empty($classList)){
            foreach ($classList as $class) {
                $classDb['c_'.$class['classid']] = $class;
                if($class['grade'] > 0){
                    $key = 'g_'.$class['grade'].'_'.$class['district'];
                    if(!array_key_exists($key, $gradeDb)){
                        $gradeDb[$key] = array('stunum'=>$class['stunum'],'grade'=>$class['grade'],'district'=>$class['district']);
                    }else{
                        $gradeDb[$key]['stunum']+=$class['stunum'];
                    }
                    if(empty($gradeClassDb[$class['grade'].'_'.$class['district']])){
                        $gradeClassDb[$class['grade'].'_'.$class['district']] = array();
                        $gradeClassMapDb[$class['grade'].'_'.$class['district']] = array();
                    }
                    $gradeClassDb[$class['grade'].'_'.$class['district']][] = '<a href="/troomv2/classexam/todayexams-0-0-0-'.$class['classid'].'.html?d='.$d.'">'.$class['classname'].'</a>';
                	$gradeClassMapDb[$class['grade'].'_'.$class['district']][] = $class['classid'];
                }
            }
        }
        $this->assign('classDb',$classDb);
        $this->assign('gradeDb',$gradeDb);
        $this->assign('gradeClassDb',$gradeClassDb);
        $this->assign('gradeClassMapDb',$gradeClassMapDb);
        $grademap = Ebh::app()->getConfig()->load('grademap');
        $this->assign('grademap',$grademap);
        $param['uid'] = $user['uid'];
        $param['tid'] = $user['uid'];
       
		$exammodel = $this->model('Exam');
		

		$exams = $exammodel->getschexamlist($param);
		$count = $exammodel->getschexamlistcount($param);
		$pagestr = show_page($count);

		$coursewareList = array();
		$coursewareDb = array();
        $cwids = array();
		if(!empty($exams)){
			foreach ($exams as $exam) {
				if(!empty($exam['cwid'])){
					$cwids[] = $exam['cwid'];
				}
			}
			$cwids = array_unique($cwids);
		}
		$coursewareList = $this->model('courseware')->getCourseListByCwids($cwids);
		if(!empty($coursewareList)){
			foreach ($coursewareList as $courseware) {
				$key = 'cw_'.$courseware['cwid'];
				$coursewareDb[$key] = $courseware;
			}
		}
		$this->assign('coursewareDb',$coursewareDb);
        $this->assign('curclassid',$classid);
		$this->assign('exams',$exams);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('uid',$user['uid']);
		$this->assign('myclass',$myclass);
		$this->assign('d',$d);
		$this->display('troomv2/classexam_today');
	}

	//修改作业类型
	public function changeType(){
		$eid = $this->input->post('eid');
        $res  = array(
        	'status'=>0,
        	'msg'=>'修改成功'
        );

        if(empty($eid) || !is_numeric($eid)){
        	$res['status'] = 1;
        	$res['msg'] = '参数不正确';
        	echo json_encode($res);
        	exit();
        }

        $user = Ebh::app()->user->getloginuser();
        
        if(empty($user)){
        	$res['status'] = 2;
        	$res['msg'] = '用户未登录';
        	echo json_encode($res);
        	exit();
        }

        $exam = $this->model('Exam')->getschexambyeid($eid);
        
        if(empty($exam)){
        	$res['status'] = 3;
        	$res['msg'] = '作业不存在';
        	echo json_encode($res);
        	exit();
        }

        if($exam['uid'] != $user['uid']){
        	$res['status'] = 4;
        	$res['msg'] = '您没有修改权限';
        	echo json_encode($res);
        	exit();
        }

        $type = 0;
        if($exam['type'] == 0){
        	$type = 1;
        }else if($exam['type'] == 1){
        	$type = 0;
        }else if($exam['type'] == 2){
        	$type = 3;
        }else if($exam['type'] == 3){
        	$type = 2;
        }
        $setarr = array(
        	'type'=>$type
        );
        $where = array(
        	'eid'=>$eid,
        	'uid'=>$user['uid']
        );
        
        $db = Ebh::app()->getDb();
        $effect_rows = $db->update('ebh_schexams',$setarr,$where);
        if($effect_rows != 1){
        	$res['status'] = 5;
        	$res['msg'] = '作业类型没有被修改';
        }
        echo json_encode($res);
	}

    /**
     * 错题集
     */
    public function errors(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classes = $this->model('classes');
        $param = parsequery();
        $q = $this->input->get('q');
        $param['crid'] = $roominfo['crid'];
        $classid = $this->uri->uri_attr(0);
        if(!is_numeric($classid) || $classid < 0)
            $classid = 0;

        $folderid = intval($this->uri->uri_attr(1));
        if(!is_numeric($folderid) || $folderid < 0){
            $folderid = 0;
        }
        $classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
        if(!empty($classlist)) {
            $infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
            foreach($classlist as $class) {
                if($classid == $class['classid']) {
                    $infalg = TRUE;
                    break;
                }
                if(empty($classidlist))
                    $classidlist = $class['classid'];
                else
                    $classidlist = $classidlist.','.$class['classid'];
            }
            if($infalg)
                $param['classid'] = $classid;
            else
                $param['classid'] = $classidlist;
            $param['tid'] = $user['uid'];
            $param['folderid'] = $folderid;
            $param['order'] = 'e.eid desc,er.eid desc';
            $errormodel = $this->model('Errorbook');
            $errors = $errormodel->getSchErrorBookListByClassid($param);
//            p($errors);die;
            $count = $errormodel->getSchErrorBookListCountByClassid($param);
            $pagestr = show_page($count);
        } else {
            $notes = array();
            $pagestr = '';
        }
        // 获取教师所在学校的课程
        $folderModel = $this->model('folder');
        $teacherFolderList = $folderModel->getTeacherFolderList(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'power'=>'0,1'));
        $folderList = array();
        if(!empty($teacherFolderList)){
            $tmp = array_pop($teacherFolderList);
            $folderList = $tmp['folder'];
        }
        $this->assign('folderList',$folderList);
        $this->assign('pagesize',$param['pagesize']);
        $this->assign('pagestr',$pagestr);
        $this->assign('roominfo',$roominfo);
        $this->assign('classid',$classid);
        $this->assign('folderid',$folderid);
        $this->assign('q',$q);
        $this->assign('classlist',$classlist);
        $this->assign('errors',$errors);
        $this->display('troomv2/errors');
    }

    /**
     * 作业错题排行
     */
    public function classerrorbook() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classmodel = $this->model('classes');
        $param = parsequery();
        $q = $this->input->get('q');
        $param['crid'] = $roominfo['crid'];
        $classid = $_GET['classid'];
        if(is_numeric($classid) && $classid > 0){
            $param['classid'] = $classid;
        }elseif(is_numeric($_GET['grade'])&&$_GET['grade']>0){
            $classes = $classmodel->getClasses(array('crid'=>$roominfo['crid'],'grade'=>$_GET['grade']));
            if(empty($classid)){
                $classid = '';
                foreach($classes as &$class){
                    if(empty($classid)){
                        $classid = $class['classid'];
                    }else{
                        $classid .= ','.$class['classid'];
                    }
                }
                $param['classid'] = $classid;
                $this->assign('gradeid',$_GET['grade']);//错题查看用
            }
        }

//        $classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
//        if(!empty($classlist)) {
//            $classidlist = '';
//            $infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
//            foreach($classlist as $class) {
//                if($classid == $class['classid']) {
//                    $infalg = TRUE;
//                    break;
//                }
//                if(empty($classidlist))
//                    $classidlist = $class['classid'];
//                else
//                    $classidlist = $classidlist.','.$class['classid'];
//            }
//            if($infalg)
//                $param['classid'] = $classid;
//            else
//                $param['classid'] = $classidlist;
//        }
        $errorbook = $this->model('errorbook');
        if(!empty($_GET['eid'])){
            $param['eid'] = $_GET['eid'];
        }
        $title = $errorbook->getSchexamsByEid($_GET['eid']);
        $this->assign('title',$title);
//        p($param);die;
        $errorlist = $errorbook->getSchoolErrorBookList($param);
        $count= $errorbook->getSchoolErrorBookCount($param);
        $pagestr = show_page($count);
        // var_dump($errorlist);
        $this->assign('errorlist',$errorlist);
        $this->assign('pagesize',$param['pagesize']);
        $this->assign('pagestr',$pagestr);
        $this->assign('classid',$classid);
        $this->assign('q',$q);
        $this->assign('room',$roominfo);
//        $this->assign('classlist',$classlist);
        $this->display('troomv2/classerrorbook');
    }

}
