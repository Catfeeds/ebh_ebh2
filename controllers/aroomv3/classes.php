<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 */
class ClassesController extends ARoomV3Controller{

    /**
     * 读取班级列表
     */
    public function lists(){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $roomType = Ebh::app()->room->getRoomType();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $parameters['q'] = $this->input->get('q');
        $parameters['roomType'] = $roomType;
        if ($this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $parameters['uid'] = $this->user['uid'];
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Classes.list')->addParams($parameters)->request();
        $this->renderjson(0,'',$result);
    }

    /**
     * 添加班级
     */
    public function add(){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['classname'] = trim($this->input->post('classname'));
        if(empty($parameters['classname'])){
            $this->renderjson(1,'班级名称不能为空');
        }
        $grade = max(0, intval($this->input->post('grade')));
        if ($grade > 0) {
            if ($this->roominfo['grade'] == 1 && ($grade < 1 || $grade > 6)) {
                $this->renderjson(1,'年级设置错误');
            }
            if ($this->roominfo['grade'] == 7 && ($grade < 7 || $grade > 9)) {
                $this->renderjson(1,'年级设置错误');
            }
            if ($this->roominfo['grade'] == 9 && ($grade < 1 || $grade > 9)) {
                $this->renderjson(1,'年级设置错误');
            }
            if ($this->roominfo['grade'] == 10 && ($grade < 10 || $grade > 12)) {
                $this->renderjson(1,'年级设置错误');
            }
        }
        $parameters['grade'] = $grade;
        $isExists = $this->apiServer->reSetting()->setService('Aroomv3.Classes.isExists')->addParams($parameters)->request();
        if($isExists){
            $this->renderjson(1,'该班级已存在');
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Classes.add')->addParams($parameters)->request();

        /**写日志开始**/
        $message = '['.implode(',', $parameters).']';
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['crid'],
                'message'=>$message,
                'opid'=>4,
                'type'=>'classroom'
            )
        );
        /**写日志结束**/
        if($result > 0){
            $this->renderjson(0,'添加成功');
        }else{
            $this->renderjson(1,'添加失败,请稍后在试或联系管理员');
        }
    }

    /**
     * 修改班级信息
     * 接收的参数
     * classid->班级ID
     * classname->班级名称
     */
    public function edit(){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $classid = $this->input->post('classid');
        if($classid <= 0){
            $this->renderjson(1,'参数错误');
        }
        $parameters['classid'] = $classid;

        $classname = $this->input->post('classname');
        $parameters['classname'] = trim($classname);
        if(empty($parameters['classname'])){
            $this->renderjson(1,'班级名称不能为空');
        }

        $grade = max(0, intval($this->input->post('grade')));
        if ($grade > 0) {
            if ($this->roominfo['grade'] == 1 && ($grade < 1 || $grade > 6)) {
                $this->renderjson(1,'年级设置错误');
            }
            if ($this->roominfo['grade'] == 7 && ($grade < 7 || $grade > 9)) {
                $this->renderjson(1,'年级设置错误');
            }
            if ($this->roominfo['grade'] == 9 && ($grade < 1 || $grade > 9)) {
                $this->renderjson(1,'年级设置错误');
            }
            if ($this->roominfo['grade'] == 10 && ($grade < 10 || $grade > 12)) {
                $this->renderjson(1,'年级设置错误');
            }
            $parameters['grade'] = $grade;
        }

        $isExists = $this->apiServer->reSetting()->setService('Aroomv3.Classes.isExists')->addParams($parameters)->request();
        if($isExists){
            $this->renderjson(1,'该班级已存在');
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Classes.edit')->addParams($parameters)->request();
        /**写日志开始**/
        $message = '编辑班级 '.($result !== false ?'成功':'失败').'[ '.implode(',', $parameters).' ] ';
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['classid'],
                'message'=>$message,
                'opid'=>2,
                'type'=>'class'
            )
        );
        /**写日志结束**/
        if($result === false){
            $this->renderjson(1,'修改失败,请稍后在试或联系管理员');
        }else{
            $this->renderjson(0,'修改成功');
        }
    }



    public function del(){
        $classid = intval($this->input->post('classid'));
        if($classid <= 0){
            $this->renderjson(1,'参数错误');
        }
        $parameters = array();
        $parameters['classid'] = $classid;
        $classes = $this->apiServer->reSetting()->setService('Aroomv3.Classes.detail')->addParams($parameters)->request();
        $count = $this->apiServer->reSetting()->setService('Aroomv3.Classes.getSchoolClassCount')->addParams(array('crid'=>$this->roominfo['crid']))->request();
        if($count < 1){
            $this->renderjson(1,'删除失败,班级数不能少于1个！');
        }

        //微信创建用户归属 默认网络班级 是不允许删除
        $appconfig = Ebh::app()->getConfig()->load('appsetting');
        $democlassid = $appconfig['democlassid'];
        if(!empty($democlassid) && $classid==$democlassid){
            $this->renderjson(1,'该班级不允许删除!');
        }
        
        if(!empty($classes) && $classes['stunum'] == 0){
            $result = $this->apiServer->reSetting()->setService('Aroomv3.Classes.del')->addParams($parameters)->request();


            /**写日志开始**/
            $message = '['.implode(',', $parameters).']'.(empty($res)?'删除失败':'删除成功');
            Ebh::app()->lib('LogUtil')->add(
                array(
                    'toid'=>$parameters['classid'],
                    'message'=>$message,
                    'opid'=>4,
                    'type'=>'class'
                )
            );
            /**写日志结束**/


            if($result > 0){
                $this->renderjson(0,'删除成功');
            }else{
                $this->renderjson(1,'删除失败');
            }
        }elseif($classes['stunum'] > 0){
            $this->renderjson(1,'该班级下还有学生，不能删除！');
        }
    }

    /**
     * 添加班级任课教师
     */
    public function add_classes_teacher(){
        $classid = intval($this->input->post('classid'));
        if($classid <= 0){
            $this->renderjson(1,'参数错误');
        }
        $parameters = array();
        $parameters['classid'] = $classid;
        $classes = $this->apiServer->reSetting()->setService('Aroomv3.Classes.detail')->addParams($parameters)->request();

        if(empty($classes)){
            $this->renderjson(1,'指定班级不存在');
        }

        //获得修改前该班级的教师列表
        $ctlist = $this->apiServer->reSetting()->setService('Aroomv3.Classes.getClassTeacherByClassid')->addParams($parameters)->request();

        $tids = $this->input->post('tids');
        $tids = explode(',',$tids);
        $addTids = $this->filterTeacher($tids);
        $parameters['tids'] = $addTids;
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Classes.setClassesTeacher')->addParams($parameters)->request();

        $headteacherid = $this->input->post('headteacherid');
        if (!empty($headteacherid) && in_array($headteacherid, $addTids)){
            $parameters['headteacherid'] = $headteacherid;
        } else {
            $parameters['headteacherid'] = 0;
        }

        $result = $this->apiServer->reSetting()->setService('Aroomv3.Classes.setHeadTeacherId')->addParams($parameters)->request();

        $this->renderjson(0,'设置成功',array(),false);
        /**写日志开始**/
        fastcgi_finish_request();
        $parametersCpy = $parameters;
        $parametersCpy['tids'] = implode(',', $parametersCpy['tids']);
        $message = '选择教师 [ '.implode(',', $parametersCpy).' ] ';
        unset($parametersCpy);
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['classid'],
                'message'=>$message,
                'opid'=>2,
                'type'=>'class'
            )
        );
        /**写日志结束**/
        //SNS班级用户缓存更新
        $snslib = Ebh::app()->lib('Sns');
        if (!empty($ctlist))
        {
            $snslib->delClassUserCacheM($ctlist);
        }

        //$idarr = explode(',',$parameters['tids']);
        $ctarr = array();
        foreach ($parameters['tids'] as $id)
        {
            if (!empty($id))
            {
                $ctarr[] = array('classid'=>$parameters['classid'], 'uid'=>$id);
            }
        }
        if (!empty($ctarr))
        {
            $snslib->updateClassUserCacheM($ctarr);
        }
    }


    /**
     * 过滤教师 移除非本网校教师ID
     */
    private function filterTeacher($tids){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['pagesize'] = 1000;
        $parameters['simple'] = 1; //表示不分页，全部查询出
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.list')->addParams($parameters)->request();
        $roomTids = array();
        foreach($result['list'] as $teacher){
            $roomTids[] = $teacher['uid'];
        }


        return array_intersect($roomTids,$tids);

    }

    /**
     * 升班操作
     */
    public function change(){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $classes = $this->apiServer->reSetting()->setService('Aroomv3.Classes.getClasses')->addParams($parameters)->request();
        if (empty($classes)) {
            $this->renderjson(1,'升班失败');
        }

        $sourceid = intval($this->input->post('sourceid'));
        $r_ctype = intval($this->input->post('ctype'));
        $r_pid = intval($this->input->post('pid'));
        $r_classid = intval($this->input->post('classid'));
        $classid_arr = $this->input->post('classids');
        $r_starttime = $this->input->post('starttime');
        $r_endtime = $this->input->post('endtime');

        if ($r_ctype == 1 && ($r_classid < 1 || $sourceid < 1 || !key_exists($r_classid, $classes))) {
            $r_classid = 0;
            $this->renderjson(1,'升班目标班级无效');
        }

        if ($r_ctype == 2 && ($sourceid < 1 || $r_starttime < 1 || $r_endtime < 1 || $r_starttime > $r_endtime || $r_endtime < SYSTIME || empty($classid_arr))) {
            $this->renderjson(1,'日期或目标班级设置错误');
        }

        if ($r_ctype == 1 && $r_classid > 0) {
            $r_classname = $classes[$r_classid]['classname'];
            $r_class_arr = array();
        }

        if ($r_ctype == 2 && !empty($classid_arr)) {
            $keys = array_flip($classid_arr);
            $r_class_arr = array_intersect_key($classes, $keys);
            $r_classid = 0;
            $r_classname = '';
        }

        if ($r_ctype == 1) {
            $parameters = array();
            $parameters['type'] = $r_ctype;
            $parameters['crid'] =  $this->roominfo['crid'];
            $parameters['sourceid'] = $sourceid;
            $parameters['uid'] = $this->user['uid'];
            $parameters['classid'] = $r_classid;
        } else {

            $parameters = array();
            $parameters['type'] = $r_ctype;
            $parameters['crid'] =  $this->roominfo['crid'];
            $parameters['sourceid'] = $sourceid;
            $parameters['uid'] = $this->user['uid'];
            $parameters['starttime'] = $r_starttime;
            $parameters['endtime'] = $r_endtime;
            $parameters['classids'] = $classid_arr;
            $parameters['pid'] = $r_pid;
        }

        $result = $this->apiServer->reSetting()->setService('Aroomv3.Classes.changeClass')->addParams($parameters)->request();
        if($result){
            $this->renderjson(0,'配置成功');
        }else{
            $this->renderjson(1,'配置失败');
        }
    }

    /**
     * 读取指定班级升班配置
     */
    public function get_change_info(){
        $classid = $this->input->post('classid');
        if($classid <= 0){
            $this->renderjson(1,'参数错误');
        }
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['classid'] = $classid;
        $parameters['uid'] = $this->user['uid'];

        $changePlan = $this->apiServer->reSetting()->setService('Aroomv3.Classes.getChangePlan')->addParams($parameters)->request();

        if($changePlan){
            $this->renderjson(0,'',$changePlan);
        }else{
            $this->renderjson(1,'未配置自主升班');
        }
    }
}
