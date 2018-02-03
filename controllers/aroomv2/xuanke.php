<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/15
 * Time: 10:15
 */
class XuankeController extends CControl
{
    private $timeRange;
    public function __construct()
    {
        parent::__construct();
        $_timeRange = Ebh::app()->getConfig()->load('othersetting');
        $roominfo = Ebh::app()->room->getcurroom();
        if (isset($_timeRange['time_rangs'][$roominfo['crid']])) {
            $this->timeRange = $_timeRange['time_rangs'][$roominfo['crid']];
        } else if (isset($_timeRange['time_rangs'][0])) {
            $this->timeRange = $_timeRange['time_rangs'][0];
        } else {
            $this->timeRange = array(
                0 => '上午', 1 => '下午'
            );
        }
        $this->assign('timeRange', $this->timeRange);
    }
    public function index(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param = parsequery();
        $param['crid'] = $roominfo['crid'];
        $param['uid'] = $user['uid'];
        $xuankelist = $this->model('xuanke')->getList($param);
        foreach($xuankelist as &$xuanke){
            if($xuanke['status']<3){
                if($xuanke['starttime']>time()){
                    $xuanke['statusmsg']='等待课程申报';
                }elseif($xuanke['endtime']<time()){
                    $xuanke['statusmsg']='申报结束';
                }else{
                    $xuanke['statusmsg']='申报中';
                }
            }elseif($xuanke['status']==3){
                $rule1 = $this->model('xuanke')->getRule(array('xkid'=>$xuanke['xkid'],'step'=>1));
                if($rule1['end_t']<time()){
                    $xuanke['statusmsg']='第一轮选课结束';
                }else{
                    $xuanke['statusmsg']='第一轮选课进行中';
                }
            }elseif($xuanke['status']==5){
                $rule2 = $this->model('xuanke')->getRule(array('xkid'=>$xuanke['xkid'],'step'=>2));
                if($rule2['end_t']<time()){
                    $xuanke['statusmsg']='第二轮选课结束';
                }else{
                    $xuanke['statusmsg']='第二轮选课进行中';
                }
            }elseif($xuanke['status']==7){
                $xuanke['statusmsg']='结果已公布';
            }elseif($xuanke['status']==8){
                $date = $this->model('xuanke')->getSurveyTime($xuanke['xkid']);
                if($date['enddate']<SYSTIME){
                    $xuanke['statusmsg']='课程评价结束';
                }else{
                    $xuanke['statusmsg']='课程评价进行中';
                }
            }
        }
        $xuankecount = $this->model('xuanke')->getListCount($param);
        $pagestr = show_page($xuankecount,$param['pagesize']);
        $this->assign('pagestr',$pagestr);
        $this->assign('xuankelist',$xuankelist);
        $this->display('aroomv2/xuanke');
    }

    //删除选课活动
    public function xuanke_del(){
        log_message('到这了');
        $post = $this->input->post();
        $xkid = !empty($post['xkid']) ? intval($post['xkid']) : 0;
        log_message($xkid);
        if(!empty($xkid)){
            $res = $this->model('xuanke')->delxk($xkid);
            if($res){
                echo json_encode(array('status'=>1, 'msg'=>'success'));
                exit;
            }
        }
        echo json_encode(array('status'=>0, 'msg'=>'error'));
    }

    //添加选课活动
    public function xuanke_add(){
        $post = $this->input->post();
        if(empty($post)){
            $this->display('aroomv2/xuanke_add');
        }else{
            $roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getAdminLoginUser();
            $param['uid'] = $user['uid'];
            $param['crid'] = $roominfo['crid'];
            $param['name'] = $post['activityname'];
            $param['explains'] = $post['summary'];
            $param['starttime'] = strtotime($post['starttime']);
            $param['endtime'] = strtotime($post['endtime']);
            $param['datetime'] = SYSTIME;
            $res = $this->model('xuanke')->add($param);
            if($res){
                echo json_encode(array('status'=> 1, 'msg'=>'success'));
            }
        }
    }

    //删除课程
    public function del(){
        $post = $this->input->post();
        if(!empty($post)){
            $param['status'] = 0;
            $where['cid'] = $post['cid'];
            $param['failedmsg'] = $post['msg'];
            $course = $this->model('xuanke')->getCourse(array('cid'=>$post['cid']));
            $where['xkid'] = $course['xkid'];
//            $param['failedmsg']=$post['msg'];
            if($post['delactive']==1){
                $res = $this->model('xuanke')->delCourse($param,$where);
            }else{
                $res = $this->model('xuanke')->saveCourse($param,$where);
            }
            if($res){
                if($res==2){
                    echo json_encode(array('status'=>2, 'msg'=>'活动课程全被删除，活动已删除'));
                }else{
                    $this->model('xuankemsg')->reportFail($course['xkid'],$course['uid'],$course['cid'],$post['msg']);
                    echo json_encode(array('status'=>1, 'msg'=>'删除课程成功'));
                }
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'error'));
            }
        }else{
            echo json_encode(array('status'=>0, 'msg'=>'error'));
        }
    }

    //选课活动修改
    public function xuanke_edit(){
        $post = $this->input->post();
        $roominfo = Ebh::app()->room->getcurroom();
        if(!empty($post)){
            $where['xkid'] = $post['xkid'];
            unset($post['xkid']);
			if(empty($post['pauseonly'])){
				$post['datetime'] = SYSTIME;
				$post['starttime'] = strtotime($post['starttime']);
				$post['endtime'] = strtotime($post['endtime']);
			} else {
				unset($post['pauseonly']);
			}
            $res = $this->model('xuanke')->fbxk($post,$where);
            if($res){
                echo json_encode(array('status'=>1, 'msg'=>'success'));
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'error'));
            }
        }else{

            $get = $this->input->get();
            $param['xkid'] = $get['xkid'];
            $param['crid'] = $roominfo['crid'];
            $xuanke = $this->model('xuanke')->getXuanke($param);
            $this->assign('xkid',$get['xkid']);
            $this->assign('xuanke',$xuanke);
            $this->display('aroomv2/xuanke_edit');
        }
    }

    //选课查看
    public function gosee(){
        $roominfo = Ebh::app()->room->getcurroom();
        $get = $this->input->get();
        $get['crid'] = $roominfo['crid'];
        $xuanke = $this->model('xuanke')->getXuanke($get);
        $this->assign('xkid',$get['xkid']);
        $this->assign('xuanke',$xuanke);
        $this->display('aroomv2/xuanke_gosee');
    }

    //课程列表
    public function courselist(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param = parsequery();
        $param['xkid'] = $get['xkid'];
        $param['crid'] = $roominfo['crid'];
        $param['uid'] = $user['uid'];
        $xuanke = $this->model('xuanke');
        $param['pagesize'] = 20;
        $courselist = $xuanke->getCourseList($param);
        $count = $xuanke->getCourseCount($param);
        $pagestr = show_page($count, $param['pagesize']);
//        p($courselist);die;
        $grade = Ebh::app()->getConfig()->load('grademap');
        foreach($courselist as &$course){
            if($course['range_type']==1){
                $grademsg = array();
                $ids = explode(',',$course['range_args']);
                $ids = array_unique($ids);
                foreach($ids as $id){
                    $grademsg[]=$grade[$id];
                }
                $course['rangemsg'] = implode('、',$grademsg);
            }
            if($course['range_type']==2){
                $classmsg = array();
                $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
                foreach($classinfo as $v){
                    $classmsg[]=$v['classname'];
                }
                $classmsg = array_unique($classmsg);
                $course['rangemsg'] = implode('、',$classmsg);

            }

            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            $tmp = json_decode($course['images']);
            $images = array();
            foreach($tmp as $item) {
                $path_info = pathinfo($item);
                $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                $images[$thumb] = $image_server . $item;
            }
            $course['images'] = $images;
        }
        $get['crid'] = $roominfo['crid'];
        $xuanke = $this->model('xuanke')->getXuanke($get);

        $this->assign('xuanke',$xuanke);
        $this->assign('xkid',$get['xkid']);
        $this->assign('courselist',$courselist);
        $this->assign('pagestr', $pagestr);
		$activity = $this->model('xuanke')->getXuanke(array('xkid' => $get['xkid'],'crid' => $roominfo['crid']));
		$rule = $this->model('xuanke')->getRule(array('xkid'=>$get['xkid']));
		$this->assign('rule',$rule);
        $this->assign('activity', $xuanke);
        $this->display('aroomv2/xuanke_courselist');
    }

    //活动详情
    public function view(){
        $roominfo = Ebh::app()->room->getcurroom();
        $get = $this->input->get();
        $get['crid'] = $roominfo['crid'];
        $xuanke = $this->model('xuanke')->getXuanke($get);
        $this->assign('xkid',$get['xkid']);
        $this->assign('xuanke',$xuanke);
		
		$activity = $this->model('xuanke')->getXuanke(array('xkid' => $get['xkid'],'crid' => $roominfo['crid']));
		$rule = $this->model('xuanke')->getRule(array('xkid'=>$get['xkid']));
		$this->assign('rule',$rule);
        $this->assign('activity', $activity);
        $this->display('aroomv2/xuanke_view');
    }

    //报名结果
    public function baoming(){
        $get = $this->input->get();

        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param['xkid'] = $get['xkid'];
        $param['crid'] = $roominfo['crid'];
        $xuanke = $this->model('xuanke')->getXuanke($param);
        $this->assign('xuanke',$xuanke);

        $param['uid'] = $user['uid'];

        $param['pagesize'] = 10000;
        $courselist = $this->model('xuanke')->getCourseList($param);//获取课程列表


        $this->assign('courselist',$courselist);
        $this->assign('xkid',$get['xkid']);
		$activity = $this->model('xuanke')->getXuanke(array('xkid' => $get['xkid'],'crid' => $roominfo['crid']));
		$rule = $this->model('xuanke')->getRule(array('xkid'=>$get['xkid']));
		$this->assign('rule',$rule);
        $this->assign('activity', $xuanke);
        $this->display('aroomv2/xuanke_baoming');
    }

    //报名结果按学生
    public function baoming_students(){
        $get=$this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $xuanke = $this->model('xuanke')->getXuanke(array('xkid'=>$get['xkid'],'crid'=>$roominfo['crid']));
        $this->assign('xuanke',$xuanke);

        $params = parsequery();
        if(isset($get['grade'])){
            $params['grade']=$get['grade'];
        }
        if(!empty($get['classid'])){
            $params['classid']=$get['classid'];
        }
        $params['crid'] = $roominfo['crid'];
        $params['xkid'] = $get['xkid'];
        $params['group'] = ' group by s.uid';
        $params['order'] = ' order by s.cid';
        if(isset($get['unsign'])&&$get['unsign']==1){
            $params['limit']=10000;
        }
        $studentlist = $this->model('xuanke')->getStudentList($params);
        unset($params['limit']);
        $params['group'] = 'uid';

        $studentcount = $this->model('xuanke')->getStudentCount($params);

        if(isset($get['unsign'])&&$get['unsign']==1){
            if(!empty($studentlist)){
                foreach($studentlist as $student){
                    $unuid[] = $student['uid'];
                }
            }
            if(!empty($unuid)){
                $params['unuid'] = implode(',',$unuid);
            }
            $studentlist = $this->model('xuanke')->getStudentList_all($params);
            $studentcount = $this->model('xuanke')->getStudentList_all_count($params);
            $studentcount = $studentcount['count'];
            $this->assign('unsign',1);
        }
//        p($studentlist);die;
        //获取班级或年级学生列表


        //学校年级
        $grade = $this->model('classes')->getRoomGrade(array('crid'=>$roominfo['crid']));
        $this->assign('grade',$grade);

        if(isset($get['grade'])){
            $param['grade']=$get['grade'];
            $this->assign('gradeid',$get['grade']);
            $this->assign('show',$get['grade']);
        }else{
            $this->assign('gradeid',-1);
            $this->assign('show',-1);
        }
//        $param['classids']=$get['classid'];
        $param['crid']=$roominfo['crid'];
        $classes = $this->model('classes')->getClassListByGrade($param);
        $this->assign('classes',$classes);
        $pagestr = show_page($studentcount,$params['pagesize']);

        $this->assign('pagestr',$pagestr);

        if(!empty($get['unsign'])){
            $this->assign('unsign',$get['unsign']);
        }else{
            $this->assign('unsign',0);
        }
        if(!empty($get['classid'])){
            $this->assign('classid',$get['classid']);
        }else{
            $this->assign('classid',-1);
        }
        $this->assign('studentlist',$studentlist);
        $this->assign('xkid',$get['xkid']);
		
		
		$rule = $this->model('xuanke')->getRule(array('xkid'=>$get['xkid']));
		$this->assign('rule',$rule);
        $this->assign('activity', $xuanke);
        $this->display('aroomv2/xuanke_baoming_students');
    }

    //查看申报课程
    public function reportcourse(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param = parsequery();
        $param['uid'] = $user['uid'];
        $param['xkid'] = $get['xkid'];
        $param['crid'] = $roominfo['crid'];
        $param['pagesize'] = 20;
        $xuanke = $this->model('xuanke');
        $courselist = $xuanke->getCourseList($param);//获取课程列表
        while(empty($courselist)) {
            if ($param['page'] < 2) {
                break;
            }
            $param['page'] = $param['page'] - 1;
            $courselist = $xuanke->getCourseList($param);
        }
        $count = $xuanke->getCourseCount($param);
        $pagestr = show_page($count, $param['pagesize']);
        foreach($courselist as &$course){
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            $tmp = json_decode($course['images']);
            $images = array();
            foreach($tmp as $item) {
                $path_info = pathinfo($item);
                $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                $images[$thumb] = $image_server . $item;
            }
            $course['images'] = $images;
        }
        $this->assign('courselist',$courselist);
        $this->assign('pagestr',$pagestr);
        $get['crid'] = $roominfo['crid'];
        $xuanke = $this->model('xuanke')->getXuanke($get);
        $this->assign('xuanke',$xuanke);
        $this->display('aroomv2/xuanke_reportcourse');
    }

    //申报课程设置
    public function course_set(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param = parsequery();
        $param['uid'] = $user['uid'];
        $param['xkid'] = $get['xkid'];
        $param['crid'] = $roominfo['crid'];
        $xuanke = $this->model('xuanke');
        $param['pagesize'] = 20;
        if ($this->input->get('ap') !== null) {
            $param['ap'] = intval($this->input->get('ap'));
            $this->assign('ap', $param['ap']);
        }
        $courselist = $xuanke->getCourseList($param);//获取课程列表
        $count = $xuanke->getCourseCount($param);
        $pagestr = show_page($count, $param['pagesize']);
        $grade = Ebh::app()->getConfig()->load('grademap');
        foreach($courselist as &$course){
            $grademsg=array();
            $classmsg=array();
            if($course['range_type']==1){
                $ids = explode(',',$course['range_args']);
                $ids = array_unique($ids);
                foreach($ids as $id){
                    $grademsg[]=$grade[$id];
                }
                $course['rangemsg'] = $grademsg;
            }
            if($course['range_type']==2){
                $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
                foreach($classinfo as $v){
                    $classmsg[]=$v['classname'];
                }
                $classmsg = array_unique($classmsg);
                $course['rangemsg'] = $classmsg;
            }
        }

        $this->assign('courselist',$courselist);

        $get['crid'] = $roominfo['crid'];
        $xuanke = $this->model('xuanke')->getXuanke($get);
        $this->assign('pagestr',$pagestr);
        $this->assign('xuanke',$xuanke);
        $this->display('aroomv2/xuanke_course_set');
    }

    //申报结束课程设置
    public function reportcoursefinish_set(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param = parsequery();
        $param['xkid'] = $get['xkid'];
        $param['crid'] = $roominfo['crid'];
        $xuanke_model = $this->model('xuanke');
        $xuanke = $xuanke_model->getXuanke($param);//选课活动详情
        $param['uid'] = $user['uid'];
        $param['pagesize'] = 20;
        if ($this->input->get('ap') !== null) {
            $param['ap'] = intval($this->input->get('ap'));
            $this->assign('ap', $param['ap']);
        }
        $courselist = $this->model('xuanke')->getCourseList($param);//课程列表
        $count = $xuanke_model->getCourseCount($param);
        $pagestr = show_page($count, $param['pagesize']);
        $grade = Ebh::app()->getConfig()->load('grademap');
        $grade[0]='其他班级';
        foreach($courselist as &$course){
            $grademsg=array();
            $classmsg=array();
            if($course['range_type']==1){
                $ids = explode(',',$course['range_args']);
                $ids = array_unique($ids);
                foreach($ids as $id){
                    $grademsg[]=$grade[$id];
                }
                $course['rangemsg'] = $grademsg;
            }
            if($course['range_type']==2){
                $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
                foreach($classinfo as $v){
                    $classmsg[]=$v['classname'];
                }
                $classmsg = array_unique($classmsg);
                $course['rangemsg'] = $classmsg;
            }
        }

        $class = $this->model('classes');
        $classes = $class->getClasses(array(
            'crid' => $roominfo['crid']
        ));
        $grade_class = array();
        foreach($classes as $item) {
            if(!array_key_exists($item['grade'], $grade_class)) {
                $grade_class[$item['grade']] = array();
            }
            $grade_class[$item['grade']][] = $item;
        }
        krsort($grade_class,SORT_NUMERIC);
        unset($classes);

        $this->assign('grade_class',$grade_class);
        $this->assign('xuanke',$xuanke);
        $this->assign('xkid',$get['xkid']);
        $this->assign('courselist',$courselist);
        $this->assign('pagestr', $pagestr);
        $this->display('aroomv2/xuanke_reportcoursefinish_set');
    }

    //申报结束课程列表
    public function reportcoursefinish_list(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param = parsequery();
        $param['pagesize'] = 20;
        $param['xkid'] = $get['xkid'];
        $param['crid'] = $roominfo['crid'];
        $xuanke = $this->model('xuanke')->getXuanke($param);//选课活动详情

        $param['uid'] = $user['uid'];
        $courselist = $this->model('xuanke')->getCourseList($param);
        $count = $this->model('xuanke')->getCourseCount($param);
        $pagestr = show_page($count, $param['pagesize']);

        $coursecount = count($courselist);
        foreach($courselist as &$course){
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            $tmp = json_decode($course['images']);
            $images = array();
            foreach($tmp as $item) {
                $path_info = pathinfo($item);
                $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                $images[$thumb] = $image_server . $item;
            }
            $course['images'] = $images;
        }

        $this->assign('count',$coursecount);
        $this->assign('xuanke',$xuanke);
        $this->assign('courselist',$courselist);
        $this->assign('xkid',$get['xkid']);
        $this->assign('pagestr', $pagestr);
        $this->display('aroomv2/xuanke_reportcoursefinish_list');
    }

    //申报结束选课规则
    public function reportcourserule(){
        $post = $this->input->post();
        if(empty($post)){
            $get = $this->input->get();
            $roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getAdminLoginUser();
            $param['xkid'] = $get['xkid'];
            $param['step'] = 1;
            $rule = $this->model('xuanke')->getRule($param);
            $param['crid'] = $roominfo['crid'];

            $xuanke = $this->model('xuanke')->getXuanke($param);//选课活动详情

            $param['uid'] = $user['uid'];

            $this->assign('xuanke',$xuanke);
            $this->assign('rule',$rule);
            $this->assign('xkid',$get['xkid']);
            $this->display('aroomv2/xuanke_reportcourserule');
        }else{
            $post = safeHtml($post);
            $post['start_t'] = strtotime($post['start_t']);
            $post['end_t'] = strtotime($post['end_t']);
            $rule = $this->model('xuanke')->getRule(array('xkid'=>$post['xkid'],'step'=>1));
            if(empty($rule)){
                $res = $this->model('xuanke')->addRule($post);
                if($res){
                    echo json_encode(array('status'=>1, 'msg'=>'success'));
                }else{
                    echo json_encode(array('status'=>0, 'msg'=>'error'));
                }
            }else{
                $where['xkid'] = $post['xkid'];
                $where['id'] = $rule['id'];
                $post['start_t'] = $rule['start_t']+1;//防止不修改保存报错
                unset($post['xkid']);
                $res = $this->model('xuanke')->saveRule($post,$where);
                if($res){
                    echo json_encode(array('status'=>1, 'msg'=>'success'));
                }else{
                    echo json_encode(array('status'=>0, 'msg'=>'error'));
                }
            }
        }
    }
    //ajax获取课程详情
    public function getcourse(){
        $roominfo = Ebh::app()->room->getcurroom();
        $post = $this->input->post();
        if(empty($post['cid'])){
            echo json_encode(0);
        }
        $xuanke = $this->model('xuanke');
        $course = $xuanke->getCourse($post);
        if(!empty($course['realname'])){
            $course['name'] = $course['realname'];
        }else{
            $course['name'] = $course['username'];
        }
        $course['coursename'] = shortstr($course['coursename'],60);
        $course['starttime'] = date('Y-m-d',$course['starttime']);
        $course['endtime'] = date('Y-m-d',$course['endtime']);
        $grade = Ebh::app()->getConfig()->load('grademap');
        $grade[0] = '其他班级';
        if($course['range_type']==1){
            $ids = explode(',',$course['range_args']);
            $ids = array_unique($ids);
            $grademsg = array();
            foreach($ids as $id){
                $grademsg[$id]=$grade[$id];
            }
            $course['rangemsg'] = $grademsg;
        }
        if($course['range_type']==2){
            $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
            $classmsg = array();
            foreach($classinfo as $v){
                $classmsg[$v['classid']]=$v['classname'];
            }
            $classmsg = array_unique($classmsg);
            $course['rangemsg'] = $classmsg;
        }
        $html = '';
        if(!empty($course['rangemsg'])){
            foreach($course['rangemsg'] as $k=>$msg){
                $html .= '
                <li class="lantewu">
                <a class="languan" href="javascript:void(0)"></a>
                '.$msg.'
                <input type="hidden" class="v" name="range_args[]" value="'.$k.'" />
                </li>
            ';
            }
        }
        if(empty($html)){
            $html = '
                <li class="lantewu" onclick="" xid="class_45">全校学生</li>
            ';
        }
        $course['html'] = $html;
        if(!empty($course)){
            $initStudents = $xuanke->getStudentList(array('cid'=> $course['cid'], 'status'=>2, 'crid' => $roominfo['crid'], 'xkid' => $course['xkid']));
            $course['initStudents'] = $initStudents;
            echo json_encode($course);
        }else{
            echo json_encode(0);
        }
    }

    //保存课程设置
    public function save_course(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $post = $this->input->post();
        if(empty($post) || empty($post['cid'])){
            echo json_encode(array('errno' => 1, 'msg' => '非法访问'));
        }else{
            $cid = intval($this->input->post('cid'));
            $xuanke = $this->model('xuanke');
            $course = $xuanke->getCourse(array('cid' => $cid, 'status' => 1));
            if (empty($course)) {
                echo json_encode(array('error'=>1, 'msg'=>'参数错误'));
                exit();
            }
            $post['starttime'] = strtotime($post['starttime']);
            $post['endtime'] = strtotime($post['endtime']);
            $post['datetime'] = SYSTIME;
            if(!empty($post['range_args'])){
                $post['range_args'] = implode(',',$post['range_args']);
            }
            if(empty($post['range_args'])){
                $post['range_type']=0;
            }
            $cid = $where['cid'] = $post['cid'];
            unset($post['cid']);
            if (isset($post['ap'])) {
                $aps = array_keys($this->timeRange);
                if (!in_array($post['ap'], $aps)) {
                    unset($post['ap']);
                }
            }
            if (isset($post['studentids'])) {
                $studentids = $this->input->post('studentids');
                if (is_array($studentids)) {
                    $studentids = array_filter($studentids, function($studentid) {
                        return is_numeric($studentid) && $studentid > 0;
                    });
                    $studentids = array_map('intval', $studentids);
                } else if (is_numeric($studentids)){
                    $studentids = array(intval($studentids));
                }
                if (!empty($studentids)) {
                    //查询学生的报名状态
                    if (count($studentids) > $post['classnum']) {
                        echo json_encode(array(
                            'errno' => 1,
                            'msg' => '选择的学生超过名额限制'
                        ));
                        exit;
                    }
                    $studentReports = $xuanke->checkStudentReportStatus($studentids, $course['xkid'], $roominfo['crid']);
                    if (!empty($studentReports)) {
                        $studentReports = array_map(function($studentReport) {
                            $studentReport['ap'] = explode(',', $studentReport['ap']);
                            $studentReport['cid'] = explode(',', $studentReport['cid']);
                            return $studentReport;
                        }, $studentReports);
                        $st1 = $st2 = $msg = array();
                        foreach ($studentReports as $report) {
                            if ($cid > 0 && !empty($report['cid']) && in_array($cid, $report['cid']) && $course['ap'] == $post['ap']) {
                                continue;
                            }
                            $showname = !empty($report['realname']) ? $report['realname'] : $report['username'];
                            if (in_array($post['ap'], $report['ap'])) {
                                $st2[] = $showname;
                                continue;
                            }
                            if (count($report['ap']) > 1) {
                                $st1[] = $showname;
                            }
                        }
                        if (!empty($st1)) {
                            $msg[] = implode(',', $st1).'报名已达到上限';
                        }
                        if (!empty($st2)) {
                            $msg[] = implode(',', $st2).'已报名上课时间与本次冲突';
                        }
                        if (!empty($msg)) {
                            echo json_encode(array(
                                'errno' => 1,
                                'msg' => implode(';', $msg)
                            ));
                            exit;
                        }
                    }
                    $studentClass = $xuanke->getClassnameForStudents($studentids, $roominfo['crid']);
                    $post['studentids'] = array_flip($studentids);
                    array_walk($post['studentids'], function(&$student, $k, $userData) {
                        $student = array(
                            'classname' => isset($userData['studentClass'][$k]) ? $userData['studentClass'][$k]['classname'] : '',
                            'tid' => isset($userData['reports'][$k]) ? $userData['reports'][$k]['tid'] : $userData['uid']
                        );
                    }, array(
                        'studentClass' => $studentClass,
                        'uid' => $user['uid'],
                        'reports' => $studentReports
                    ));
                }
            }
            $res = $xuanke->saveCourse($post,$where, $course['xkid']);
            if($res){
                echo json_encode(array('errno'=>0));
            }else{
                echo json_encode(array('errno'=>1, 'msg'=>'设置课程失败，请稍后再试或联系管理员'));
            }
        }
    }

    //发布选课
    public function fbxk(){
        $post = $this->input->post();

        if(isset($post['step'])&&$post['step']==2){//第二轮//R99698
            //验证

            $roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getAdminLoginUser();
            $params['crid'] = $roominfo['crid'];
            $params['uid'] = $user['uid'];
            $params['xkid'] = $post['xkid'];
            $coureslist = $this->model('xuanke')->getCourseList($params);
            if(!empty($coureslist)){//为空不能发布
                $i=0;
                foreach($coureslist as $course){
                    if($course['studentsnum']>$course['classnum']){
                        echo json_encode(array('status'=>0, 'msg'=>'班级报名人数不能多于班级名额限制'));
                        exit();
                    }
                    if($course['status']==2){
                        $this->model('xuankemsg')->finishBeforehand($course['xkid'],$course['uid'],$course['cid']);
                    }
                    if($course['studentsnum']==$course['classnum']){
                        $this->model('xuankemsg')->finishBeforehand($course['xkid'],$course['uid'],$course['cid']);
                        $this->model('xuanke')->saveCourse(array('status'=>2),array('cid'=>$course['cid']));
                        $i++;
                    }
                }

                $coursecount = $this->model('xuanke')->getCourseCount(array('crid'=>$roominfo['crid'],'xkid'=>$post['xkid']));
                if($coursecount==$i){
                    $param['finish_time'] = SYSTIME;
                    $param['status'] = 7;//所有课程人数报满,直接发布结果
                    $msg = '发布结果成功';
                }else{
                    if(empty($post['remark'])||empty($post['start_t'])||empty($post['end_t'])){
                        echo json_encode(array('status'=>0, 'msg'=>'请完善信息'));
                        exit();
                    }
                    if($post['start_t']>$post['end_t']){
                        echo json_encode(array('status'=>0, 'msg'=>'请输入正确的日期'));
                        exit();
                    }
                    $param['second_t'] = SYSTIME;
                    $param['status'] = $post['status'];
                    $msg = '发布选课成功';
                }
                $where['xkid'] = $post['xkid'];
                $res2 = $this->model('xuanke')->fbxk($param,$where);//发布选课
                if($res2){
                    unset($post['status']);
                    $post['start_t'] = strtotime($post['start_t']);
                    $post['end_t'] = strtotime($post['end_t']);
                    $rule = $this->model('xuanke')->getRule(array('xkid'=>$post['xkid'],'step'=>1));
                    $post['max_sign_count'] = $rule['max_sign_count'];
                    $this->model('xuanke')->addRule($post);
                    echo json_encode(array('status'=>1, 'msg'=>$msg));
                }else{
                    echo json_encode(array('status'=>0, 'msg'=>'error2'));
                }
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'error1'));
            }




//            }else{
//                $where['xkid'] = $post['xkid'];
//                $where['step'] = $post['step'];
//                $where['id'] = $rule['id'];
//                unset($post['xkid']);
//                unset($post['step']);
//                $res1 = $this->model('xuanke')->saveRule($post,$where);
//                $res2 = $this->model('xuanke')->fbxk($param,array('xkid'=>$where['xkid']));
//                if($res1&&$res2){
//                    echo json_encode(array('status'=>1, 'msg'=>'success'));
//                }else{
//                    echo json_encode(array('status'=>0, 'msg'=>'error'));
//                }
//            }
        }else{
            $where['xkid'] = $post['xkid'];
            $rule = $this->model('xuanke')->getRule(array('xkid'=>$post['xkid'],'step'=>1));
            if(empty($rule)){
                echo json_encode(array('status'=>0, 'msg'=>'请添加规则后再发布选课'));
                exit();
            }
            $roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getAdminLoginUser();
            $coureslist = $this->model('xuanke')->getCourseList(array('xkid'=>$post['xkid'],'crid'=>$roominfo['crid'],'uid'=>$user['uid']));
            if(empty($coureslist)){
                echo json_encode(array('status'=>0, 'msg'=>'没有课程不能发布'));
                exit();
            }
            unset($post['xkid']);
            $post['first_t'] = SYSTIME;
            $model = $this->model('xuanke');
            $res = $model->fbxk($post,$where);
            $model->batchUpdateTime($rule['xkid'], $rule['start_t']);
            if($res){
                echo json_encode(array('status'=>1, 'msg'=>'success'));
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'发布失败'));
            }
        }

    }

    //第一轮选课查看列表
    public function firstcondition(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param = parsequery();
        $param['pagesize'] = 1000;
        $param['xkid'] = $get['xkid'];
        $param['uid'] = $user['uid'];
        $param['crid'] = $roominfo['crid'];
        $courselist = $this->model('xuanke')->getCourseList($param);
        if(!empty($courselist)){
            if(empty($get['step'])){
                foreach($courselist as &$course){
                    $course['isup']=4;
                }
            }else{
                $i=0;
                foreach($courselist as $course){
                    if($course['classnum']==$course['studentsnum']){
                        $i++;
                    }
                }
            }
            if(!empty($i)){
                if($i==count($courselist)){
                    $this->assign('finish',1);
                }else{
                    $this->assign('finish',0);
                }
            }else{
                $this->assign('finish',0);
            }

        } else {
            $this->assign('finish', 0);
        }
        $xuanke = $this->model('xuanke')->getXuanke(array('xkid'=>$get['xkid'],'crid'=>$roominfo['crid']));
        $this->assign('xuanke',$xuanke);

        if(!empty($get['step'])){
            $this->assign('step',$get['step']);
        }else{
            $this->assign('step',0);
        }
        $this->assign('xkid',$get['xkid']);
        $this->assign('courselist',$courselist);
        $this->display('aroomv2/xuanke_firstcondition');
    }
    //选课查看明细
    public function condition_detail(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $roomlist = $this->model('classroom')->getroomlistbytid($user['uid']);
        $this->assign('roomlist', $roomlist);
        $this->assign('user',$user);
        $this->assign('room',$roominfo);

        $param['cid'] = $get['cid'];
        $course = $this->model('xuanke')->getCourse($param);

        //显示限制名称
        $grade = Ebh::app()->getConfig()->load('grademap');
        if($course['range_type']==1){
            $ids = explode(',',$course['range_args']);
            $ids = array_unique($ids);
            $grademsg = array();
            foreach($ids as $id){
                $grademsg[]=$grade[$id];
            }
            $course['rangemsg'] = implode('、',$grademsg);
        }
        if($course['range_type']==2){
            $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
            $classmsg = array();
            foreach($classinfo as $v){
                $classmsg[]=$v['classname'];
            }
            $classmsg = array_unique($classmsg);
            $course['rangemsg'] = implode('、',$classmsg);
        }
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $image_server = $_UP['xk']['showpath'];
        $tmp = json_decode($course['images']);
        $images = array();
        foreach($tmp as $item) {
            $path_info = pathinfo($item);
            $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
            $images[$thumb] = $image_server . $item;
        }
        $course['images'] = $images;

//        if($course['status']!=2){
//            $param['bout'] = empty($get['bout'])?1:$get['bout'];
//        }
        $param['crid'] = $roominfo['crid'];
        $param['group'] = ' group by s.uid ';
        $course['student'] = $this->model('xuanke')->getStudentList($param);

//        $count = $this->model('xuanke')->getCourseCount($param);
//
//        $pagestr = show_page($count,$param['pagesize']);
//
//        $this->assign('pagestr',$pagestr);
        if(!empty($get['step'])){
            $this->assign('step',$get['step']);
        }
        if(!empty($get['xkid'])){
            $this->assign('xkid',$get['xkid']);
        }
        $this->assign('course',$course);
        $this->display('aroomv2/xuanke_condition_view');
    }

    //选课调整
    public function condition_set(){
        $post = $this->input->post();
        $user = Ebh::app()->user->getAdminLoginUser();
        if(empty($post)){
            $get = $this->input->get();
            $roominfo = Ebh::app()->room->getcurroom();
            $roomlist = $this->model('classroom')->getroomlistbytid($user['uid']);
            $this->assign('roomlist', $roomlist);
            $this->assign('user',$user);
            $this->assign('room',$roominfo);
            $param['cid'] = $get['cid'];

            $course = $this->model('xuanke')->getCourse($param);

            $grade = Ebh::app()->getConfig()->load('grademap');
            if($course['range_type']==1){
                $ids = explode(',',$course['range_args']);
                $ids = array_unique($ids);
                $grademsg = array();
                foreach($ids as $id){
                    $grademsg[]=$grade[$id];
                }
                $course['rangemsg'] = implode('、',$grademsg);
            }
            if($course['range_type']==2){
                $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
                $classmsg = array();
                foreach($classinfo as $v){
                    $classmsg[]=$v['classname'];
                }
                $classmsg = array_unique($classmsg);
                $course['rangemsg'] = implode('、',$classmsg);
            }

            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            $tmp = json_decode($course['images']);
            $images = array();
            foreach($tmp as $item) {
                $path_info = pathinfo($item);
                $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                $images[$thumb] = $image_server . $item;
            }
            $course['images'] = $images;

            if(!empty($get['bout'])){
                $param['bout'] = $get['bout'];
                $this->assign('bout',$get['bout']);//区别轮次
                $this->assign('condition','secondcondition');//完成调整跳转
            }else{
                $param['bout'] = 1;
                $this->assign('bout',1);
                $this->assign('condition','firstcondition');
            }
            $param['crid'] = $roominfo['crid'];
            $param['group'] = ' group by s.uid';
            $course['student'] = $this->model('xuanke')->getStudentList($param);
//p($course);die;

            $this->assign('cid',$get['cid']);
            $this->assign('course',$course);
//            if($course['status']==2||$course['isup']==2){//完成调整不能编辑
//                $this->display('aroomv2/xuanke_condition_view');
//            }else{
            $this->display('aroomv2/xuanke_condition_set');
//            }
        }else{
            $param['status'] = 0;
            $param['tid'] = $user['uid'];
            $param['uptime'] = SYSTIME;
            $param['failmsg'] = $post['failmsg'];
            unset($post['failmsg']);
            if(is_array($post['uid'])){
                $res = $this->model('xuanke')->updateStudents_mult($param,$post,$post['bout']);//批量
            }else{
                $res = $this->model('xuanke')->updateStudents($param,$post,$post['bout']);
            }
            if($res){
                echo json_encode(array('status'=>1, 'msg'=>'success'));
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'error'));
            }
        }
    }

    //课程完成调整
    public function upfinish(){
        $post = $this->input->post();
        $classnum = $post['classnum'];
        unset($post['classnum']);
        if (empty($post['cid'])) {
            echo json_encode(array('status'=>0, 'msg'=>'error'));
        }
        $studentnum = $this->model('xuanke')->getStudentCount(array('cid' => $post['cid']));
        if($studentnum>$classnum){
            echo json_encode(array('status'=>0, 'msg'=>'error'));
        }else{
            if($post['bout']==1){
                $param['isup'] = 2;
                $param['firstnum'] = $studentnum;
            }else{
                $param['isup'] = 5;
                $param['secondnum'] = $studentnum;
            }
            if($studentnum==$classnum){
                $param['status'] = 2;

            }
            $param['studentsnum'] = $studentnum;
            $res = $this->model('xuanke')->saveCourse($param,array('cid'=>$post['cid']));
            if($res !== false){
                echo json_encode(array('status'=>1, 'msg'=>'success'));
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'error'));
            }
        }
    }

    //第二轮选课查看列表
    public function secondcondition(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param = parsequery();
        $param['pagesize'] = 1000;
        $param['xkid'] = $get['xkid'];
        $param['uid'] = $user['uid'];
        $param['crid'] = $roominfo['crid'];
        $courselist = $this->model('xuanke')->getCourseList($param);
        if(empty($get['step'])){
            foreach($courselist as &$course){
                $course['isup']=6;
            }
        }
//        p($courselist);die;

        $xuanke = $this->model('xuanke')->getXuanke(array('xkid'=>$get['xkid'],'crid'=>$roominfo['crid']));
        $this->assign('xuanke',$xuanke);

        if(!empty($get['step'])){//区分查看和调整
            $this->assign('step',$get['step']);
        }else{
            $this->assign('step',0);
        }
        $this->assign('xkid',$get['xkid']);
        $this->assign('courselist',$courselist);
        $this->display('/aroomv2/xuanke_secondcondition');
    }

    //第二轮添加学生
    public function secondcondition_set(){
        $post = $this->input->post();
        $user = Ebh::app()->user->getAdminLoginUser();
        $roominfo = Ebh::app()->room->getcurroom();
        $xuanke = $this->model('xuanke');
        if(empty($post)){
            $this->input->setCookie('refer','',-1);
            $get = $this->input->get();
            $roomlist = $this->model('classroom')->getroomlistbytid($user['uid']);
            $this->assign('roomlist', $roomlist);
            $this->assign('user',$user);
            $this->assign('room',$roominfo);
            $this->assign('crid',$roominfo['crid']);
            $param['cid'] = $get['cid'];
            $course = $this->model('xuanke')->getCourse($param);

            //显示限制名称
            $grade = Ebh::app()->getConfig()->load('grademap');
            if($course['range_type']==1){
                $ids = explode(',',$course['range_args']);
                $ids = array_unique($ids);
                $grademsg = array();
                foreach($ids as $id){
                    $grademsg[]=$grade[$id];
                }
                $course['rangemsg'] = implode('、',$grademsg);

                $vArr = array(
                    1=> '一年级',
                    2 => '二年级',
                    3=> '三年级',
                    4 => '四年级',
                    5=> '五年级',
                    6 => '六年级',
                    7 => '初一',
                    8 => '初二',
                    9 => '初三',
                    10 => '高一',
                    11 => '高二',
                    12 => '高三'
                );
                $aArr = explode(',', $course['range_args']);
                $tmp = array();
                $vTmp = array();
                foreach($aArr as $item) {
                    if(array_key_exists($item, $vArr)) {
                        $tmp[] = $vArr[$item];
                        $vTmp[] = $item;
                    }
                }
                $classes = $xuanke->getCourseClasses($roominfo['crid'], 1, $vTmp);
            }
            if($course['range_type']==2){
                $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
                $classmsg = array();
                foreach($classinfo as $v){
                    $classmsg[]=$v['classname'];
                }
                $classmsg = array_unique($classmsg);
                $course['rangemsg'] = implode('、',$classmsg);




                $classx = $this->model('classes');
                $classArr = $classx->getClassList($roominfo['crid'], $course['range_args']);
                $tmp = array();
                $vTmp = array();
                foreach($classArr as $item) {
                    $tmp[] = $item['classname'];
                    $vTmp[] = $item['classid'];
                }
                $classes = $xuanke->getCourseClasses($roominfo['crid'], 2, $vTmp);

            }
            if($course['range_type'] == 0) {
                $classes = $xuanke->getCourseClasses($roominfo['crid'], 0, null);
            }
            //图片
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            $tmp = json_decode($course['images']);
            $images = array();
            foreach($tmp as $item) {
                $path_info = pathinfo($item);
                $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                $images[$thumb] = $image_server . $item;
            }
            $course['images'] = $images;

            $class = $this->model('classes');
            $grade_class = array();
            foreach($classes as $item) {
                if(!array_key_exists($item['grade'], $grade_class)) {
                    $grade_class[$item['grade']] = array();
                }
                $grade_class[$item['grade']][] = $item;
            }
            krsort($grade_class,SORT_NUMERIC);
            unset($classes);

            //学生列表
            $param['crid'] = $roominfo['crid'];
            $param['group'] = ' group by s.uid ';
            $course['student'] = $this->model('xuanke')->getStudentList($param);
//p($course);die;
            $this->assign('cid',$get['cid']);
            $this->assign('course',$course);
            $this->assign('bout',2);
            $this->assign('grade_class', $grade_class);

//            if($course['status']==2||$course['isup']==5){//完成调整不能编辑
//                $this->display('aroomv2/xuanke_condition_view');
//            }else{
                $this->display('/aroomv2/xuanke_secondcondition_set');
//            }
        }else{
//            p($post);die;
            $uidarr = $post['uidarr'];
            $param['xkid'] = $post['xkid'];
            $param['cid'] = $post['cid'];
            $param['bout'] = 2;//只有第二轮可以添加
            $param['tid'] = $user['uid'];
            $param['uptime'] = SYSTIME;
            $param['sign_time'] = SYSTIME;
            $param['status'] = 2;//被老师添加
            $errormsg = array();
            foreach($uidarr as $uid){
                $studentname = $this->model('user')->getuserbyuid($uid);
                $student = $this->model('xuanke')->getStudentByUid(array('uid'=>$uid,'cid'=>$post['cid']));
                if(empty($student)){
                    $param['uid'] = $uid;
                    $classname = $this->model('xuanke')->getClassInfo($uid,$roominfo['crid']);
                    $param['classname'] = $classname['classname'];
                    $course = $this->model('xuanke')->getCourse(array('cid'=>$post['cid']));
                    $is_signed = $this->model('xuanke')->is_signed(array(
                        'xkid'=>$param['xkid'],
                        'cid'=>$course['cid'],
                        'uid'=> $uid));
                    if($course['classnum']>$course['studentsnum'] && !$is_signed){
                        $res = $this->model('xuanke')->addStudents($param);
                    }else{
                        $res = 0;
                    }
                }else{
                    $res = 0;
                }
                if(!$res){
                    $errormsg[] = empty($studentname['realname'])?$studentname['username']:$studentname['realname'];
                }else{
                    $this->model('xuanke')->saveCourse(array('studentsnum'=>$course['studentsnum']+1),array('cid'=>$course['cid']));
                }
            }
            if(empty($errormsg)){
                echo json_encode(array('status'=>1, 'msg'=>'success'));
            }else{
                $errormsg = implode(',',$errormsg);
                echo json_encode(array('status'=>0, 'msg'=>'以下学生添加失败: '.$errormsg.'<p>失败原因:名额已满</p>'));
            }
        }
    }

    //整个刷新跳转
    public function jump(){
        $get = $this->input->get();
        $this->input->setcookie('refer','aroomv2/xuanke/secondcondition_set.html?cid='.$get['cid']);
        header("location:/aroomv2.html");
    }

    //发布结果
    public function fbjg(){
        $post = $this->input->post();
        if(!empty($post)){
            $user = Ebh::app()->user->getAdminLoginUser();
            $roominfo = Ebh::app()->room->getcurroom();
            $params['uid'] = $user['uid'];
            $params['crid'] = $roominfo['crid'];
            $params['xkid'] = $post['xkid'];
            $xuanke = $this->model('xuanke');
            //$xuanke->adjustSignCount($post['xkid']);
            $courselist = $xuanke->getCourseList($params);
            if(!empty($courselist)){
                foreach($courselist as $course){
                    if($course['studentsnum']>$course['classnum']){
                        echo json_encode(array('status'=>0, 'msg'=>'课程报名人数不能大于名额限制'));
                        exit();
                    }
                }
                $param['status'] = 7;
                $param['finish_time'] = SYSTIME;
                $res = $this->model('xuanke')->fbxk($param,$post);
                if($res){
                    echo json_encode(array('status'=>1, 'msg'=>'success'));
                }else{
                    echo json_encode(array('status'=>0, 'msg'=>'发布失败'));
                }
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'课程不能为空'));
            }
        }else{
            echo json_encode(array('status'=>0, 'msg'=>'参数有误'));
        }
    }

    //报名结束查看结果
    public function final_view(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $roomlist = $this->model('classroom')->getroomlistbytid($user['uid']);
        $this->assign('roomlist', $roomlist);
        $this->assign('user',$user);
        $this->assign('room',$roominfo);

        $param['cid'] = $get['cid'];
        $course = $this->model('xuanke')->getCourse($param);

        //显示限制名称
        $grade = Ebh::app()->getConfig()->load('grademap');
        if($course['range_type']==1){
            $ids = explode(',',$course['range_args']);
            $ids = array_unique($ids);
            $grademsg = array();
            foreach($ids as $id){
                $grademsg[]=$grade[$id];
            }
            $course['rangemsg'] = implode('、',$grademsg);
        }
        if($course['range_type']==2){
            $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
            $classmsg = array();
            foreach($classinfo as $v){
                $classmsg[]=$v['classname'];
            }
            $classmsg = array_unique($classmsg);
            $course['rangemsg'] = implode('、',$classmsg);
        }

        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $image_server = $_UP['xk']['showpath'];
        $tmp = json_decode($course['images']);
        $images = array();
        foreach($tmp as $item) {
            $path_info = pathinfo($item);
            $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
            $images[$thumb] = $image_server . $item;
        }
        $course['images'] = $images;
        $param['crid'] = $roominfo['crid'];
        $param['group'] = ' group by s.uid';
        $course['student'] = $this->model('xuanke')->getStudentList($param);
        $this->assign('course',$course);

        $this->display('aroomv2/xuanke_final_view');
    }

    //学生查看页面
    public function student_view(){

        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $roomlist = $this->model('classroom')->getroomlistbytid($user['uid']);
        $this->assign('roomlist', $roomlist);
        $this->assign('user',$user);
        $this->assign('room',$roominfo);

        $xuanke = $this->model('xuanke')->getXuanke(array('xkid'=>$get['xkid'],'crid'=>$roominfo['crid']));
        $this->assign('xuanke',$xuanke);


        $param['uid'] = $get['uid'];
        $param['xkid'] = $get['xkid'];
        $courselist = $this->model('xuanke')->getStudentCourseList($param);//获取学生该活动所有课程

        foreach($courselist as &$course){

            $course_t = $this->model('xuanke')->getCourse(array('cid'=>$course['cid']));
            $course['username_t'] = $course_t['username'];
            $course['realname_t'] = $course_t['realname'];

            //显示限制名称
            $grade = Ebh::app()->getConfig()->load('grademap');
            if($course['range_type']==1){
                $ids = explode(',',$course['range_args']);
                $ids = array_unique($ids);
                $grademsg = array();
                foreach($ids as $id){
                    $grademsg[]=$grade[$id];
                }
                $course['rangemsg'] = implode('、',$grademsg);
            }
            if($course['range_type']==2){
                $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course['range_args']);
                $classmsg = array();
                foreach($classinfo as $v){
                    $classmsg[]=$v['classname'];
                }
                $classmsg = array_unique($classmsg);
                $course['rangemsg'] = implode('、',$classmsg);
            }

            //图片
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            $tmp = json_decode($course['images']);
            $images = array();
            foreach($tmp as $item) {
                $path_info = pathinfo($item);
                $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                $images[$thumb] = $image_server . $item;
            }
            $course['images'] = $images;
        }

        $name = empty($courselist[0]['realname'])?$courselist[0]['username']:$courselist[0]['realname'];

        $this->assign('name',$name);

        $this->assign('courselist',$courselist);
        $this->display('aroomv2/xuanke_student_view');
    }

    //查看评价
    public function assess(){
        $get = $this->input->get();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $param['xkid'] = $get['xkid'];
        $param['crid'] = $roominfo['crid'];
        $param['uid'] = $user['uid'];
        $xuanke = $this->model('xuanke')->getXuanke(array('xkid'=>$get['xkid'],'crid'=>$roominfo['crid']));
        $this->assign('xuanke',$xuanke);
        $param['pagesize'] = 10000;
        $courselist = $this->model('xuanke')->getCourseList($param);
        foreach($courselist as &$course){
            $survey = $this->model('survey')->getSurveyByCid(array('cid'=>$course['cid']));
            $course['sid'] = $survey['sid'];
            $course['s_starttime'] = $survey['startdate'];
            $course['s_endtime'] = $survey['enddate'];
            $course['answernum'] = $survey['answernum'];
        }
        $this->assign('xkid',$get['xkid']);
        $this->assign('courselist',$courselist);
        $this->display('aroomv2/xuanke_assess');
    }

    /**
     * 导出学生
     */
    public function exportexcel() {
        $xkid = intval($this->input->get('xkid'));
        $cid = intval($this->input->get('cid'));
        if($xkid > 0 && $cid > 0) {
            $this->_export_course_students($xkid, $cid);
            exit;
        }

        $classid = intval($this->input->get('classid'));
        if ($xkid > 0 && $classid > 0) {
            $this->_export_class_students($xkid, $classid);
            exit;
        }

        echo '导出失败';
        exit;
    }

    /**
     * 导出课程学生
     * @param $xkid
     * @param $cid
     */
    private function _export_course_students($xkid, $cid) {
        $xuanke = $this->model('xuanke');
        $coursename = $xuanke->getCourseName($xkid, $cid);
        if($coursename == false) {
            echo '导出失败';
            exit;
        }

        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            '学生帐号',
            '姓名',
            '班级',
            '报名时间'
        );
        $name = "选课《" .$coursename . "》学生列表";
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);


        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';//列A1,B1,C1,D1
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
		$roominfo = Ebh::app()->room->getcurroom();
        $dataArr = $xuanke->getStudentsForExcel(array(
            'xkid' => $xkid,
            'cid' => $cid,
			'crid'=>$roominfo['crid'],
        ));
        $column_count = count($titleArr);

        //传值
        if(is_array($dataArr)){
            foreach ($dataArr as $index => $row) {
                $str = "A";
                for($i = 0; $i < $column_count; $i++) {
                    $p = $str . ($index + 3);
                    if ($str == 'A') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['username']);
                        $str++;
                        continue;
                    }
                    if ($str == 'B') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['realname']);
                        $str++;
                        continue;
                    }
                    if ($str == 'C') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['classname']);
                        $str++;
                        continue;
                    }
                    if ($str == 'D') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, empty($row['sign_time'])?'--':Date('Y-m-d H:i:s',$row['sign_time']));
                        $str++;
                        continue;
                    }
                }
            }
        }
//return;
        /*if(!empty($manuallywidth)){
            $str = 'A';
            foreach($manuallywidth as $width){
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
                $str++;
            }
        }*/
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

    
	/*
	AB类的按学生导出
	*/
	private function _export_class_students($xkid, $classid) {
        $roominfo = Ebh::app()->room->getcurroom();
		
        $xuanke = $this->model('xuanke');

        $classname = $xuanke->getClassName($roominfo['crid'], $classid);
        if($classname == false) {
            echo '导出失败';
            exit;
        }

        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");
		
        
		$titleArr1 = array(
            'A2'=>'姓名',
            'B2'=>'课程数量'
        );
		if(count($this->timeRange) == 3){
			$titleArr2 = array(
				'C'=>'A类课程',
				'F'=>'B类课程',
				'I'=>'AB类课程'
			);
		} else {
			$titleArr2 = array(
				'C'=>$this->timeRange[0],
				'F'=>$this->timeRange[1]
			);
			
		}
		$titleArr3 = array(
			'C'=>'课程名称',
			'D'=>'上课时间',
			'E'=>'教室'
		);
		
        $name = $classname;
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->mergeCells("A1:B1");
		$pt = $objPHPExcel->getActiveSheet()->getStyle($p);
		$objPHPExcel->getActiveSheet()->setCellValue($p, $name);
		$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
		$pt->getFont()->setSize(20);
		$pt->getFont()->setBold(true);
		
		foreach($titleArr1 as $index=>$cname){
			$pt = $objPHPExcel->getActiveSheet()->getStyle($index);
			$objPHPExcel->getActiveSheet()->setCellValue($index, $cname);
			$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$pt->getFont()->setSize(16);
			$pt->getFont()->setBold(true);
		}
		foreach($titleArr2 as $index=>$cname){
			$mergestr = $index.'1:'.chr(ord($index)+2).'1';
			$objPHPExcel->getActiveSheet()->mergeCells($mergestr);
			$pindex = $index.'1';
			$pt = $objPHPExcel->getActiveSheet()->getStyle($pindex);
			$objPHPExcel->getActiveSheet()->setCellValue($pindex, $cname);
			$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
			$pt->getFont()->setSize(16);
			$pt->getFont()->setBold(true);
		}
		for($i=0;$i<count($titleArr2);$i++){
			foreach($titleArr3 as $index=>$cname){
				$pindex = chr(ord($index)+3*$i).'2';
				// var_dump($pindex);exit;
				$pt = $objPHPExcel->getActiveSheet()->getStyle($pindex);
				$objPHPExcel->getActiveSheet()->setCellValue($pindex,$cname);
				$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				$pt->getFont()->setSize(16);
				$pt->getFont()->setBold(true);
			}
		}

        $dataArr = $xuanke->getClassStudents($xkid, $roominfo['crid'], $classid);
        // print_r($dataArr);exit;
        
        //传值
        if(is_array($dataArr)){
            foreach ($dataArr as $index => $row) {
				$rownum = $index + 3;
                $uname = (!empty($row['realname']) ? $row['realname'] : '').'('.$row['username'].')';
				$pindex = 'A'.$rownum;
				$objPHPExcel->getActiveSheet()->setCellValueExplicit($pindex, $uname, PHPExcel_Cell_DataType::TYPE_STRING);
				
				$count = !empty($row['courses']) ? count($row['courses']) : 0;
				$pindex = 'B'.$rownum;
				$objPHPExcel->getActiveSheet()->setCellValueExplicit($pindex, $count, PHPExcel_Cell_DataType::TYPE_STRING);
				
				if(!empty($row['courses'])){
					foreach($row['courses'] as $course){
						$p1 = chr(ord('C')+$course['ap']*3).$rownum;
						$p2 = chr(ord('D')+$course['ap']*3).$rownum;
						$p3 = chr(ord('E')+$course['ap']*3).$rownum;
						$objPHPExcel->getActiveSheet()->setCellValueExplicit($p1, $course['coursename'], PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->setCellValueExplicit($p2, $course['classtime'], PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->setCellValueExplicit($p3, $course['place'], PHPExcel_Cell_DataType::TYPE_STRING);
					}
				}
            }
        }

        for($str = 'A' ;$str<= 'L';$str++){	
			if($str == 'B'){
				$width = 15;
			} else {
				$width = 20;
			}
            $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
        }
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
     * 统计
     */
    public function stat_view() {
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

        $this->assign('notop', true);
        $this->assign('survey',$survey);
        $this->assign('relateinfo', $relateinfo);
        $this->display('aroomv2/xuanke_survey_stat');

    }
    
    
    /**
     *导出选课汇总
     */
    public function exportxuanke(){
        $get = $this->input->get();
        $xkid = intval($get['xkid']);
        if($xkid<=0){
            echo 'fail';
            exit;
        }
        
        $roominfo = Ebh::app()->room->getcurroom();
        $crid = $roominfo['crid'];
        //查询所有班级信息
        $classModel = $this->model("Classes");
        $classes = $classModel->getClasses(array('crid'=>$crid));
        $classes = array_coltokey($classes,'classid');
        //获取所有班级的学生列表
        $classidarr = array_column($classes, 'classid');
        $count = $classModel-> getClassStudentCount(array('classidlist'=>implode(",", $classidarr)));
        $classstudent = $classModel->getClassStudentList(array('classidlist'=>implode(",", $classidarr),'limit'=>'0,'.$count));
        
        //查询所有学生的选课信息
        $xuankemodel = $this->model("Xuanke");
        $sparam = array('crid'=>$crid,'xkid'=>$xkid,'orderby'=>'xs.classname DESC');
        $xuankelist = $xuankemodel->getxklist($sparam);
        
        if(!empty($classstudent)){
            foreach ($classstudent as &$student){
                $hasxuankelist = array();
                foreach ($xuankelist as $xuanke){
                    
                    if($student['uid'] == $xuanke['uid']){
                        
                        $hasxuankelist[] = array('cid'=>$xuanke['cid'],'coursename'=>$xuanke['coursename']);
                    }
                }
                
                $student['hasxuankelist'] = $hasxuankelist;
            }
        }
        //var_dump($classstudent);die;
        $titleArr = array("编号","班级","姓名","账号","性别","已选课");
        $dataArr = array();
        foreach ($classstudent as $key=>$student){
            $newdata = array(
                $key+1,
                $classes[$student['classid']]['classname'],
                $student['realname'],
                $student['username'],
                ($student['sex'] == 1)?"女":"男",
                $this->gethasxuankeformatestr($student['hasxuankelist'])
            );
            $dataArr[] = $newdata;
        }
        $name = '选课记录表';
        $this->_exportExcel($titleArr, $dataArr, 'FF808080',$name);
    }
    
    /**
     * 选课字符串格式化
     * @param unknown $arr
     */
    protected function gethasxuankeformatestr($arr){
        $str = '';
        if(!empty($arr)){
            foreach($arr as $item){
                $str.=$item['coursename']."\n";
            }
        }
        return $str;
    }
    
	/*
	 *导出全部学生选课情况
	 *
	*/
	public function exportexcelall(){
		$xkid = $this->input->get('xkid');
		if(empty($xkid)){
			exit;
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");
		$titleArr1 = array(
            'A1'=>'姓名',
            'B1'=>'所在班级',
            'C1'=>'课程数量'
        );
		if(count($this->timeRange) == 3){
			$titleArr2 = array(
				'D'=>'A类课程',
				'G'=>'B类课程',
				'J'=>'AB类课程'
			);
		} else {
			$titleArr2 = array(
				'D'=>$this->timeRange[0],
				'G'=>$this->timeRange[1]
			);
			
		}
		$titleArr3 = array(
			'D'=>'课程名称',
			'E'=>'上课时间',
			'F'=>'教室'
		);
		
		
        $objPHPExcel->getActiveSheet()->mergeCells("A1:A2");
        $objPHPExcel->getActiveSheet()->mergeCells("B1:B2");
        $objPHPExcel->getActiveSheet()->mergeCells("C1:C2");
		foreach($titleArr1 as $index=>$name){
			$pt = $objPHPExcel->getActiveSheet()->getStyle($index);
			$objPHPExcel->getActiveSheet()->setCellValue($index, $name);
			$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$pt->getFont()->setSize(16);
			$pt->getFont()->setBold(true);
		}
		foreach($titleArr2 as $index=>$name){
			$mergestr = $index.'1:'.chr(ord($index)+2).'1';
			$objPHPExcel->getActiveSheet()->mergeCells($mergestr);
			$pindex = $index.'1';
			$pt = $objPHPExcel->getActiveSheet()->getStyle($pindex);
			$objPHPExcel->getActiveSheet()->setCellValue($pindex, $name);
			$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
			$pt->getFont()->setSize(16);
			$pt->getFont()->setBold(true);
		}
		for($i=0;$i<count($titleArr2);$i++){
			foreach($titleArr3 as $index=>$name){
				$pindex = chr(ord($index)+3*$i).'2';
				// var_dump($pindex);exit;
				$pt = $objPHPExcel->getActiveSheet()->getStyle($pindex);
				$objPHPExcel->getActiveSheet()->setCellValue($pindex,$name);
				$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				$pt->getFont()->setSize(16);
				$pt->getFont()->setBold(true);
			}
		}
		
		$xuankemodel = $this->model('Xuanke');
		
		$userlist = $xuankemodel->getExportDataAll($roominfo['crid'],$xkid);
        // $dataArr = array();
		// var_dump($userlist);exit;
		if(is_array($userlist)){
			$index = 0;
            foreach ($userlist as $uid => $row) {
				$rownum = $index + 3;
                $uname = (!empty($row['realname']) ? $row['realname'] : '').'('.$row['username'].')';
				$pindex = 'A'.$rownum;
				$objPHPExcel->getActiveSheet()->setCellValueExplicit($pindex, $uname, PHPExcel_Cell_DataType::TYPE_STRING);
				
				$classname = !empty($row['classname']) ? $row['classname'] : '';
				$pindex = 'B'.$rownum;
				$objPHPExcel->getActiveSheet()->setCellValueExplicit($pindex, $classname, PHPExcel_Cell_DataType::TYPE_STRING);
				
				
				$count = !empty($row['xk']) ? count($row['xk']) : 0;
				$pindex = 'C'.$rownum;
				$objPHPExcel->getActiveSheet()->setCellValueExplicit($pindex, $count, PHPExcel_Cell_DataType::TYPE_STRING);
				
				if(!empty($row['xk'])){
					foreach($row['xk'] as $course){
						$p1 = chr(ord('D')+$course['ap']*3).$rownum;
						$p2 = chr(ord('E')+$course['ap']*3).$rownum;
						$p3 = chr(ord('F')+$course['ap']*3).$rownum;
						$objPHPExcel->getActiveSheet()->setCellValueExplicit($p1, $course['coursename'], PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->setCellValueExplicit($p2, $course['classtime'], PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->setCellValueExplicit($p3, $course['place'], PHPExcel_Cell_DataType::TYPE_STRING);
					}
				}
				$index ++;
            }
        }
		
		for($str = 'A' ;$str<= 'L';$str++){	
			if($str == 'B'){
				$width = 15;
			} else {
				$width = 20;
			}
            $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
        }
		// 输出下载文件 到浏览器
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		$name = '报名结果 '.Date('Y-m-d',SYSTIME);
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

    /**
     * 更改活动状态
     */
    public function ajax_pause_activity() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $xkid = intval($this->input->post('xkid'));
        if ($xkid < 1) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '缺少参数'
            ));
            exit();
        }
        $s = intval($this->input->post('s')) > 0 ? 1 : 0;
        $model = $this->model('xuanke');
        $user = Ebh::app()->user->getAdminLoginUser();
        $ret = $model->pauseActivity($xkid, $user['uid'], $s);
        if (empty($ret)) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '未做修改'
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => 0
        ));
        exit();
    }
}