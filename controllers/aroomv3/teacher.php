<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 * 教师控制器
 */
class TeacherController extends ARoomV3Controller{

    /**
     * 读取教师列表
     */
    public function lists(){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $parameters['q'] = $this->input->get('q');
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.list')->addParams($parameters)->request();
        $this->renderjson(0,'',$result);
    }
	
	/**
     * 删除教师
     * 
	 */
	public function del(){
		$param['crid'] = $this->roominfo['crid'];
		$param['uid'] = $this->input->post('uid');
		if($this->roominfo['uid'] == $param['uid']){
			$result = FALSE;
		} else {
            $userinfo = array();
            $userinfo = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.detail')->addParams($param)->request();
			$result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.del')->addParams($param)->request();
		}
        if($result !== FALSE){
            $this->renderjson(0,'操作成功',array(),false);
            fastcgi_finish_request();	//操作成功，则直接返回前端输出
            $userinfo['toid'] = intval($param['uid']);
            Ebh::app()->lib('OperationLog')->addLog($userinfo, 'delteacher');//操作成功记录到操作日志
		} else {
			$this->renderjson(1,$this->roominfo['uid'] == $param['uid'] ? '无法删除管理员' : '操作失败');
		}
	}
	
    /**
     * 修改教师信息
     * 接收的参数
     * realname->真实姓名
     * mobile->联系电话
     * sex->性别
     */
    public function edit(){
        $parameters = array();
        $tid = $this->input->post('tid');
        if($tid <= 0){
            $this->renderjson(1,'参数错误');
        }
        $parameters['tid'] = $tid;

        $realname = $this->input->post('realname');
        $mobile = $this->input->post('mobile');
        $sex = $this->input->post('sex');

        if(!empty($realname)){
            $parameters['realname'] = $realname;
        }
        //if(!empty($mobile)){
        $parameters['mobile'] = $mobile;
        //}
        if(!empty($sex) || $sex !== null){
            $parameters['sex'] = intval($sex);
        }

        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.edit')->addParams($parameters)->request();
        if (isset($parameters['mobile'])) {
            $effect = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.updateMobile')
                ->addParams('mobile', trim($parameters['mobile']))
                ->addParams('tid', $tid)
                ->addParams('crid', $this->roominfo['crid'])
                ->request();
        }

        /**写日志开始**/
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['tid'],
                'message'=>json_encode($parameters),
                'opid'=>2,
                'type'=>'teacher'
            )
        );
        /**写日志结束**/
        if($result === false || (isset($effect) && $effect ==false)){
            $this->renderjson(1,'修改失败,请稍后在试或联系管理员');
        }else{
            $this->renderjson(0,'修改成功');
        }
    }

    /**
     * 修改指定教师密码
     * 接收的参数
     * tid->教师ID
     * password->新密码
     */
    public function edit_pass(){

        $tid = $this->input->post('tid');
        if($tid <= 0){
            $this->renderjson(1,'参数错误');
        }
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['uid'] = $tid;
        $teacherIsExists = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.isExists')->addParams($parameters)->request();

        if(!$teacherIsExists){
            $this->renderjson(1,'权限不足');
        }
        $parameters = array();
        $parameters['tid'] = $tid;
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['password'] = $this->input->post('password');
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.edit')->addParams($parameters)->request();
        /**写日志开始**/
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['tid'],
                'message'=>'修改密码',
                'opid'=>2,
                'type'=>'teacher'
            )
        );
        /**写日志结束**/
        if($result === false){
            $this->renderjson(1,'重置密码失败,请稍后在试或联系管理员');
        }else{
            $this->renderjson(0,'重置密码成功',array(),false);
            fastcgi_finish_request();	//操作成功，则直接返回前端输出
            Ebh::app()->lib('OperationLog')->addLog(array('toid'=>$tid,'password'=>$parameters['password']),'teacherpass');//操作成功记录到操作日志
        }

    }

    /**
     * 教师添加
     *
     * 接收的参数
     * tname->用户名
     * pwd->密码
     * realname->真实姓名
     * mobile->联系电话
     * sex->性别
     */
    public function add(){
        $username = $this->input->post('tname');
        if(empty($username)){
            $this->renderjson(1,'用户名必须填写');
        }
        if (preg_match("/[\x7f-\xff]/", $username)) {
            $this->renderjson(1,'用户名不能存在中文');
        }
        $parameters = array();
        $parameters['username'] = $username;
        $teacherinfo = $this->apiServer->reSetting()->setService('Member.User.getUserByUsername')->addParams($parameters)->request();
        if($teacherinfo){
            if($teacherinfo['groupid'] == 5){
                if($teacherinfo['uid'] == $this->user['uid']){
                    $this->renderjson(1,'不能添加自己');
                }else{
                    $parameters = array();
                    $parameters['crid'] = $this->roominfo['crid'];
                    $parameters['uid'] = $teacherinfo['uid'];
                    $teacherIsExists = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.uidIsExists')->addParams($parameters)->request();
                    if(!empty($teacherIsExists)){
                        $this->renderjson(1,'该教师在本网校或其他网校已存在');
                    }else{
                        $parameters = array();
                        $parameters['tid'] = $teacherinfo['uid'];
                        $parameters['crid'] = $this->roominfo['crid'];
                        $parameters['status'] = 1;
                        $parameters['cdateline'] = SYSTIME;
                        $parameters['role'] = 1;
                        //会员已存在 向网校添加教师信息
                        $res = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.addRoomTeacher')->addParams($parameters)->request();
                        if($res !== FALSE){
                            $this->renderjson(0,'操作成功',array(),false);
                            fastcgi_finish_request();	//操作成功，则直接返回前端输出
                            $parameters['username'] = $username;
                            $parameters['toid'] = $teacherinfo['uid'];
                            $parameters['realname'] = h($this->input->post('realname'));
                            $parameters['sex'] = intval($this->input->post('sex'));
                            if(isset($parameters['realname']) && isset($parameters['sex'])){
                                Ebh::app()->lib('OperationLog')->addLog($parameters,'addteacher');//操作成功记录到操作日志
                            }
                            //更新SNS网校用户缓存
                            $snslib = Ebh::app()->lib('Sns');
                            $snslib->updateRoomUserCache(array('crid'=>$this->roominfo['crid'],'uid'=>$teacherinfo['uid']));
                            //同步SNS数据(用户网校操作)
                            $snslib->do_sync($teacherinfo['uid'], 4);
                            //header('location:'.geturl('aroomv2/teacher'));
                            Ebh::app()->lib('xNums')->add('user');
                            Ebh::app()->lib('xNums')->add('teacher');
                        }
                    }

                }
            }else{
                $this->renderjson(1,'该用户不允许被添加');
            }

        }else{
            //用户不存在。新增用户
            $parameters = array();
            $parameters['username'] = $username;
            $parameters['password'] = $this->input->post('pwd');
            if(empty($parameters['password'])){
                $this->renderjson(1,'密码必须填写');
            }
            $parameters['realname'] = $this->input->post('realname');
            if(empty($parameters['realname'])){
                $this->renderjson(1,'真实姓名必须填写');
            }

            $parameters['sex'] = intval($this->input->post('sex'));
            //添加会员 并向网校添加教师
            $tid = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.add')->addParams($parameters)->request();
            $parameters = array();
            $parameters['tid'] = $tid;
            $parameters['crid'] = $this->roominfo['crid'];
            $parameters['status'] = 1;
            $parameters['cdateline'] = SYSTIME;
            $parameters['role'] = 1;
            $parameters['mobile'] = $this->input->post('mobile');
            $this->apiServer->reSetting()->setService('Aroomv3.Teacher.addRoomTeacher')->addParams($parameters)->request();
            //将注册信息记录到日志
            if($tid){
                $this->renderjson(0,'操作成功',array(),false);
                fastcgi_finish_request();	//操作成功，则直接返回前端输出
                $logdata = array();
                $logdata['uid']=$tid;
                $logdata['crid']=$parameters['crid'];
                $logdata['logtype'] = 2;
                $registerloglib=Ebh::app()->lib('RegisterLog');
                $registerloglib->addOneRegisterLog($logdata);

                $logdata['toid'] = $tid;
                $logdata['username'] = $username;
                $logdata['realname'] = h($this->input->post('realname'));
                $logdata['sex'] = intval($this->input->post('sex'));
                if(isset($logdata['realname']) && isset($logdata['sex'])){
                    Ebh::app()->lib('OperationLog')->addLog($logdata,'addteacher');//操作成功记录到操作日志
                }

                //更新SNS网校用户缓存
                $snslib = Ebh::app()->lib('Sns');
                $snslib->updateRoomUserCache(array('crid'=>$this->roominfo['crid'],'uid'=>$tid));
                //同步SNS数据(用户网校操作)
                $snslib->do_sync($tid, 4);
                Ebh::app()->lib('xNums')->add('user');
                Ebh::app()->lib('xNums')->add('teacher');
            }
        }
    }


    /**
     * 教师身份进入
     */
    public function login(){
        $tid = $this->input->get('tid');

        if($tid <=0){
            exit;
        }
        $url  = '/aroom/umanager/teacher.html?s='.urlencode(authcode($tid,'ENCODE'));

        header("Location:".$url);exit;
    }


    /**---------------------------教研组-------------------------------**/
    /**
     * 读取教研组列表
     */
    public function groups(){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.groups')->addParams($parameters)->request();
        $this->renderjson(0,'',$result);
    }

    /**
     * 添加教研组
     */
    public function add_groups(){
        $post = $this->input->post();

        if(empty($post['groupname']) || mb_strlen($post['groupname'],'UTF8')>=20 ){
            $this->renderjson(1,'分组名称不符合规范');
        }

        if(!empty($post['summary']) && mb_strlen($post['summary'],'UTF8')>=256 ){
            $this->renderjson(1,'分组介绍不符合规范');
        }

        $parameters = array();
        $parameters['groupname'] = $post['groupname'];
        $parameters['summary'] = $post['summary'];
        $parameters['upid'] = 0;
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['uid'] = $this->user['uid'];
        $parameters['displayorder'] = 0;
        $isExists = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.groupExists')->addParams($parameters)->request();
        if($isExists){
            $this->renderjson(1,'该教研组已存在');
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.addGroups')->addParams($parameters)->request();

        /**写日志开始**/

        $message = "添加学科分组 ".$parameters['groupname'];
        $opid = 1;

        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['crid'],
                'message'=>$message,
                'opid'=>$opid,
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
     * 编辑教研组
     */
    public function edit_groups(){
        $post = $this->input->post();

        if(intval($post['groupid']) <= 0){
            $this->renderjson(1,'参数错误');
        }

        if(empty($post['groupname']) || mb_strlen($post['groupname'],'UTF8')>=20 ){
            $this->renderjson(1,'分组名称不符合规范');
        }

        if(!empty($post['summary']) && mb_strlen($post['summary'],'UTF8')>=256 ){
            $this->renderjson(1,'分组介绍不符合规范');
        }

        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['groupid'] = intval($post['groupid']);
        $parameters['groupname'] = $post['groupname'];
        $parameters['summary'] = $post['summary'];

        $isExists = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.groupExists')->addParams($parameters)->request();
        if($isExists){
            $this->renderjson(1,'该教研组已存在');
        }
        $groupsDetail = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.getGroupsDetail')->addParams($parameters)->request();
        if(empty($groupsDetail)){
            $this->renderjson(1,'信息不存在');
        }
        if($groupsDetail['crid'] != $this->roominfo['crid'] || $groupsDetail['uid'] != $this->user['uid']){
            $this->renderjson(1,'你无权修改此教研组');
        }

        /**写日志开始**/

        $message = "修改学科分组 ".$parameters['groupname'];
        $opid = 2;

        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['crid'],
                'message'=>$message,
                'opid'=>$opid,
                'type'=>'classroom'
            )
        );
        /**写日志结束**/

        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.editGroups')->addParams($parameters)->request();

        if($result === false){
            $this->renderjson(1,'修改失败');
        }else{
            $this->renderjson(0,'修改成功');
        }

    }

    /**
     * 删除教研组
     */
    public function del_groups(){
        $post = $this->input->post();

        if(intval($post['groupid']) <= 0){
            $this->renderjson(1,'删除失败');
        }

        $parameters = array();
        $parameters['groupid'] = intval($post['groupid']);

        $groupsDetail = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.getGroupsDetail')->addParams($parameters)->request();
        if(empty($groupsDetail)){
            $this->renderjson(1,'删除失败');
        }
        if($groupsDetail['crid'] != $this->roominfo['crid'] || $groupsDetail['uid'] != $this->user['uid']){
            $this->renderjson(1,'你无权删除此教研组');
        }
        $parameters['crid'] = $this->roominfo['crid'];
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.delGroups')->addParams($parameters)->request();

        /**写日志开始**/
        $groupname = !empty($groupDetail['groupname'])?$groupDetail['groupname']:$parameters['groupid'];
        $message = '删除学科分组 [ '.$groupname.' ] '.$result;
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$this->roominfo['crid'],
                'message'=>$message,
                'opid'=>4,
                'type'=>'classroom'
            )
        );
        /**写日志结束**/

        if($result > 0){
            $this->renderjson(0,'删除成功');
        }else{
            $this->renderjson(1,'删除失败');
        }
    }

    /**
     * 教研组增加教师
     */
    public function add_groups_teacher(){
        $post = $this->input->post();

        if(intval($post['groupid']) <= 0){
            $this->renderjson(1,'参数错误');
        }
        $parameters = array();
        $parameters['groupid'] = intval($post['groupid']);
        $groupsDetail = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.getGroupsDetail')->addParams($parameters)->request();

        if(empty($groupsDetail)){
            $this->renderjson(1,'分组不存在');
        }

        if($groupsDetail['crid'] != $this->roominfo['crid'] || $groupsDetail['uid'] != $this->user['uid']){
            $this->renderjson(1,'权限验证失败，当前用户不是该分组的创建者，或者分组不存在！');
        }

        //教师id处理
        $tids = $this->input->post('tids');
        $tids = explode(',',$tids);
        $addTids = $this->filterTeacher($tids);
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['tids'] = $addTids;

        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.setGroupsTeacher')->addParams($parameters)->request();


        /**写日志开始**/
        $groupname = !empty($groupDetail['groupname'])?$groupDetail['groupname']:$parameters['groupid'];
        $message = '将教师 [ '.implode(',', $addTids).' ] 设置为分组 [ '.$groupname.' ] 成员操作成功';
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$this->roominfo['crid'],
                'message'=>$message,
                'opid'=>2,
                'type'=>'classroom'
            )
        );
        /**写日志结束**/
        if($result === false){
            $this->renderjson(1,'修改失败,请稍后在试或联系管理员');
        }else{
            $this->renderjson(0,'修改成功');
        }
    }

    /**
     * 过滤教师 移除非本网校教师ID
     */
    private function filterTeacher($tids){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['pagesize'] = 1000;
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.list')->addParams($parameters)->request();
        $roomTids = array();
        foreach($result['list'] as $teacher){
            $roomTids[] = $teacher['uid'];
        }


        return array_intersect($roomTids,$tids);

    }
    /**
     * 禁用/解禁教师
     */
    public function activate() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }

        if ($this->input->post('uid') === null) {
            $this->renderjson(1, '缺少参数');
        }
        $uid = intval($this->input->post('uid'));
        if ($uid == $this->user['uid'] || $uid == $this->roominfo['uid']) {
            $this->renderjson(1, '操作失败');
        }
        $status = intval($this->input->post('status'));
        if (!in_array($status, array(0, 1, 2))) {
            $this->renderjson(1, '参数错误');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Teacher.activate')
            ->addParams(array(
                'crid' => $this->roominfo['crid'],
                'status' => $status,
                'uid' => $uid
            ))->request();

        if (!empty($ret)) {
            $this->renderjson(0,'操作成功',array(),false);
            fastcgi_finish_request();	//操作成功，则直接返回前端输出
            if(isset($status) && in_array($status, array(0, 1))){//0禁用,1解禁
                Ebh::app()->lib('OperationLog')->addLog(array('status' => $status,'toid' => $uid),(!empty($status)?'unlockteacher':'lockteacher'));//操作成功记录到操作日志
            }
        }
        $this->renderjson(1, '操作失败');
    }
	
	/*
	教师详情，编辑用
	*/
	public function detail(){
		$uid = $this->input->get('uid');
		$param['crid'] = $this->roominfo['crid'];
		$param['uid'] = $uid;
		if(empty($uid)){
			$this->renderjson(0,'获取失败');
		}
		$detail = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.detail')->addParams($param)->request();
        $this->renderjson(0,'',$detail);
	}
}