<?php
/**
 * 操作日志
 */
class OperationLog{
	/**
     * 添加操作日志
     * *@param $toid 被操作的id 被编辑的课程id,被添加的学生id 等
     * @param param['type'] 类型,addcourse,editcourse,addstudent 等,见/config/logdescription.php
     * @return 操作日志logid
	 */
    public function addLog($param,$type){
        if(empty($param) || empty($type)){
            return FALSE;
        }
        $courseAddLog = array('addcourse','delcourse','editcourse');//课程添加、编辑和删除操作成功后记录操作日志
        $cwAddLog = array('addcw','delcw','editcw');//课件添加、编辑和删除操作成功后记录操作日志
        //学生(员工)或教师(讲师)操作成功后记录操作日志
        $userAddLog= array('addstudent','delstudent','studentpass','lockstudent','unlockstudent','addteacher','delteacher','teacherpass','lockteacher','unlockteacher');
        $multiuserAddLog= array('multistudent','multiteacher');//批量导入学生(员工)/教师(讲师)操作成功后记录操作日志
		$systemAddLog = array('changeisshare','setsharepercent');//通用分销比例
		$userShareAddLog = array('addusershare','editusershare','delusershare');//用户分销比例
		$examAddLog = array('addexam','editexam','delexam');//发布、编辑、删除作业
        $designAddLog = array('adddesign','editdesign','deldesign','savedesign','choosedesign','canceldesign');//添加、编辑、删除、保存、启用、取消首页装扮
        $reviewAddLog = array('shieldreview','unshieldreview','auditreview','unauditreview'); //屏蔽、取消屏蔽,审核通过、审核不通过评论
        $myAddLog = array(
            'addnotice','editnotice','delnotice',   //通知消息添加、编辑、删除成功后记录操作日志
            'addnews','editnews','delnews',         //资讯添加、编辑、删除成功后记录操作日志
            'editmessage',                          //编辑公告
            'shieldask','unshieldask'               //屏蔽、取消屏蔽问题
        );

        $this->apiServer = Ebh::app()->getApiServer('ebh');
        $param['type'] = $type;
        if(in_array($type,$userAddLog)){
            return $this->userAddLog($param);//用户
        }elseif(in_array($type,$multiuserAddLog)){
            return $this->multiuserAddLog($param);//批量导入
        }elseif(in_array($type,$courseAddLog)){
            return $this->courseAddLog($param);//课程
        }elseif(in_array($type,$cwAddLog)){
            return $this->cwAddLog($param);//课件
        }elseif(in_array($type,$systemAddLog)){
			return $this->systemAddLog($param);
		}elseif(in_array($type,$userShareAddLog)){//分销
            return $this->userShareAddLog($param);
        }elseif(in_array($type,$examAddLog)){//作业
            return $this->examAddLog($param);
		}elseif(in_array($type,$designAddLog)){//装扮
            return $this->designAddLog($param);
        }elseif(in_array($type,$reviewAddLog)){//评论
            return $this->reviewAddLog($param);
        }elseif(in_array($type,$myAddLog)){//（添加、编辑、删除）等同类型操作
            return $this->myAddLog($param);
        }else{
            return FALSE;
        }
    }

    /**
     * 课程添加、编辑和删除操作成功后记录操作日志
     */
    protected function courseAddLog($param){
        $logsparam = $this->getLogsParam();
        if(empty($param['toid'])  || empty($logsparam['clientuid']) || empty($logsparam['crid'])){
            return FALSE;
        }
        if($param['type']=='addcourse'){//添加课程成功后记录操作日志
            if(empty($param['foldername'])){
                return FALSE;
            }
            $logsparam['iname'] = $param['foldername'];
            $logsparam['iprice'] = isset($param['iprice']) ? $param['iprice'] : 0;
        }elseif($param['type']=='editcourse'){//编辑课程成功后记录操作日志
            if(empty($param['foldername']) || empty($param['foldernameold']) || !isset($param['iprice'])  || !isset($param['ipriceold'])){
                return FALSE;
            }
            $logsparam['inameold'] = $param['foldernameold'];
            $logsparam['iname'] = $param['foldername'];
            $logsparam['ipriceold'] = $param['ipriceold'];
            $logsparam['iprice'] = $param['iprice'];
        }elseif($param['type']=='delcourse'){//删除课程成功后记录操作日志
            if(empty($param['foldername'])){
                return FALSE;
            }
            $logsparam['iname'] = $param['foldername'];
        }else{
            return FALSE;
        }
        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }
    /**
     * 课件添加、编辑和删除操作成功后记录操作日志
     */
    protected function cwAddLog($param){
        $logsparam = $this->getLogsParam();
        if(empty($param['toid'])  || empty($logsparam['clientuid']) || empty($logsparam['crid'])){
            return FALSE;
        }
        if($param['type']=='addcw'){//课件添加成功后记录操作日志
            if(empty($param['foldername']) || empty($param['title']) || !isset($param['cprice'])){
                return FALSE;
            }
            $logsparam['iname'] = $param['foldername'];
            $logsparam['title'] = $param['title'];
            $logsparam['iprice'] = $param['cprice'];
        }elseif($param['type']=='editcw'){//课件编辑成功后记录操作日志
            if(empty($param['foldername']) || empty($param['title']) || empty($param['titleold']) || !isset($param['ipriceold']) || !isset($param['cprice'])){
                return FALSE;
            }
            $logsparam['iname'] = $param['foldername'];
            $logsparam['title'] = $param['title'];
            $logsparam['titleold'] = $param['titleold'];
            $logsparam['ipriceold'] = $param['ipriceold'];
            $logsparam['iprice'] = $param['cprice'];
        }elseif($param['type']=='delcw'){//课件删除成功后记录操作日志
            if(empty($param['foldername']) || empty($param['title'])){
                return FALSE;
            }
            $logsparam['iname'] = $param['foldername'];
            $logsparam['title'] = $param['title'];
        }else{
            return FALSE;
        }
        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }

    /**
     * 批量导入学生(员工)/教师(讲师)操作成功后记录操作日志
     */
    protected function multiuserAddLog($param){
        if(empty($param['users']) || empty($param['usercount']) || empty($param['toid'])){
            return FALSE;
        }
        $logsparam = $this->getLogsParam();
        if(empty($logsparam['clientuid']) || empty($logsparam['crid'])){
            return FALSE;
        }
        $users = $param['users'];
        $logsparam['usercount'] = $param['usercount'];
        $usernames = array_column($users,'realname');
        if(!empty($usernames)){
            if(count($usernames)>=8){
                $usernames = array_slice($usernames,0,8);
            }
            $usernames = implode(',',$usernames);
            $logsparam['usernames'] = $usernames;
        }
        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }

    /**
     * 学生(员工)或教师(讲师)添加、删除、重置密码、禁用和解禁的操作成功后记录操作日志
     */
    protected function userAddLog($param){
        $logsparam = $this->getLogsParam();
        if(empty($param['toid'])  || empty($logsparam['clientuid']) || empty($logsparam['crid'])){
            return FALSE;
        }

        $logtype= array('addstudent','delstudent','addteacher','delteacher');//添加或删除用户
        if(in_array($param['type'],$logtype)){
            if(!empty($param['username']) && !empty($param['realname'])){
                $logsparam['username'] = $param['username'];
                $logsparam['realname'] = $param['realname'];
                $logsparam['sex'] = !empty($param['sex']) ? '女' : '男';
                $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
                $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
                if(!empty($ret)){
                    return $ret;//成功记录操作日志返回logid
                }
            }else{
                return FALSE;
            }
        }

        if(($param['type']=='lockstudent' || $param['type']=='lockteacher') && !isset($param['status'])){//禁用
            return FALSE;
        }
        if(($param['type']=='unlockstudent' || $param['type']=='unlockteacher') && empty($param['status'])){//解禁
            return FALSE;
        }
        if($param['type']=='studentpass' || $param['type']=='teacherpass'){//重置密码
            if(!isset($param['password'])){
                return FALSE;
            }
            $logsparam['password'] = $param['password'];
        }

        $teacherarr= array('teacherpass','lockteacher','unlockteacher');
        if(in_array($param['type'],$teacherarr)){//获取教师（讲师）账号、姓名和性别
            $userinfo = $this->apiServer->reSetting()
                ->setService('Aroomv3.Teacher.detail')
                ->addParams(array('crid'=>$logsparam['crid'],'uid'=>$param['toid']))
                ->request();
        }else{//获取学生（员工）账号、姓名和性别
            $userinfo = $this->apiServer->reSetting()
                ->setService('Aroomv3.Student.getRoomuser')
                ->addParams(array('crid'=>$logsparam['crid'],'uid'=>$param['toid']))
                ->request();
        }
        if(empty($userinfo['username']) || empty($userinfo['realname'])){
            return FALSE;
        }
        $logsparam['username'] = $userinfo['username'];
        $logsparam['realname'] = $userinfo['realname'];
        $logsparam['sex'] = !empty($userinfo['sex']) ? '女' : '男';

        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }
	
	/**
	*系统设置(aroomv3)
	*/
	protected function systemAddLog($param){
        $logsparam = $this->getLogsParam();
		if($param['type'] == 'changeisshare'){
			$logsparam['changestatus'] = $param['changestatus'];
		} elseif($param['type'] == 'setsharepercent'){
			$logsparam['sharepercent'] = $param['sharepercent'];
		}
		$param['logsparam'] = !empty($logsparam) ? $logsparam : array();
		$ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
	}

    /**
     * 用户分销比例添加、编辑和删除操作成功后记录操作日志
     * $userShareAddLog = array('addusershare','editusershare','delusershare');//用户分销比例
     */
    protected function userShareAddLog($param){
        $logsparam = $this->getLogsParam();
        if(empty($param['toid'])  || empty($logsparam['clientuid']) || empty($logsparam['crid'])){
            return FALSE;
        }
        if(in_array($param['type'],array('editusershare','delusershare'))){
            $userinfo = $this->apiServer->reSetting()->setService('Member.User.getUserByUid')->addParams(array('uid'=>$param['toid']))->request();
            if(!empty($userinfo['username']) && !empty($userinfo['realname']) && isset($userinfo['sex'])){
                $logsparam['username'] = $userinfo['username'];
                $logsparam['realname'] = $userinfo['realname'];
                $logsparam['sex'] = !empty($userinfo['sex']) ? '女' : '男';
            }
        }
        if($param['type']=='addusershare'){//添加成功后记录操作日志
            if (!isset($param['percent']) || empty($param['count']) || empty($param['uids'])) {
                return FALSE;
            }else{
                $logsparam['percent'] = $param['percent'];
                $logsparam['count'] = $param['count'];
                $userinfo = $this->apiServer->reSetting()->setService('Member.User.getUserByUids')->addParams(array('uids'=>$param['uids']))->request();
                if(!empty($userinfo['data']) && is_array($userinfo['data'])){
                    $usernames = array_column($userinfo['data'],'username');
                    if(!empty($usernames) && is_array($usernames)){
                        if(count($usernames)>=8){
                            $usernames = array_slice($usernames,0,8);
                        }
                        $logsparam['usernames'] = implode(',',$usernames);
                    }
                }
            }
        }elseif($param['type']=='editusershare') {//编辑成功后记录操作日志
            if (!isset($param['newpercent']) || !isset($param['oldpercent']) || empty($logsparam['username']) || empty($logsparam['realname'])) {
                return FALSE;
            }else{
                $logsparam['newpercent'] = $param['newpercent'];
                $logsparam['oldpercent'] = $param['oldpercent'];
            }
        }elseif ($param['type']=='delusershare'){//删除成功后记录操作日志
            if (!isset($param['percent']) || empty($logsparam['username']) || empty($logsparam['realname'])) {
                return FALSE;
            }else{
                $logsparam['percent'] = $param['percent'];
            }
        }else{
            return FALSE;
        }
        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }

    /**
     * 作业添加、编辑和删除操作成功后记录操作日志
     */
    protected function examAddLog($param){
        $logsparam = $this->getLogsParam();
        if(empty($param['toid'])  || empty($logsparam['clientuid']) || empty($logsparam['crid']) || empty($logsparam['username'])){
            return FALSE;
        }
        if(in_array($param['type'],array('addexam','editexam','delexam'))){//作业添加、编辑、删除成功后记录操作日志
            if(empty($param['title'])){
                return FALSE;
            }
            $logsparam['title'] = h($param['title']);
        }else{
            return FALSE;
        }
        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }

    /**
     * 首页装扮添加、编辑、删除、保存、启用操作成功后记录操作日志
     */
    protected function designAddLog($param){
        $logsparam = $this->getLogsParam();
        if(empty($param['toid'])  || empty($logsparam['clientuid']) || empty($logsparam['crid'])){
            return FALSE;
        }
        if(in_array($param['type'],array('adddesign','editdesign','deldesign','savedesign','choosedesign','canceldesign'))){//首页装扮添加、编辑、删除、保存、启用、取消操作成功后记录操作日志
            if(empty($param['title']) || empty($param['clientType'])){
                return FALSE;
            }
            $logsparam['title'] = h($param['title']);
            $logsparam['clientType'] = h($param['clientType']);
            if($param['type']=='editdesign') {//记录首页装扮编辑操作时需要提供原装扮名称
                if(empty($param['oldtitle'])){
                    return FALSE;
                }
                $logsparam['oldtitle'] = h($param['oldtitle']);
            }
        }else{
            return FALSE;
        }
        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }

    /**
     * 添加、编辑和删除操作成功后记录操作日志
     */
    protected function myAddLog($param){
        $logsparam = $this->getLogsParam();
        if(empty($param['toid'])  || empty($logsparam['clientuid']) || empty($logsparam['crid'])){
            return FALSE;
        }
        $myoperation = array(
            'addnotice','editnotice','delnotice',   //通知消息添加、编辑、删除成功后记录操作日志
            'addnews','editnews','delnews',         //资讯添加、编辑、删除成功后记录操作日志
            'editmessage',                          //编辑公告
            'shieldask','unshieldask'               //屏蔽、取消屏蔽问题
            );
        $editoperation = array('editnotice','editnews');//编辑通知、资讯
        if(in_array($param['type'],$myoperation)){//添加、编辑、删除操作成功后记录操作日志
            if(empty($param['title'])){
                return FALSE;
            }
            $logsparam['title'] = h($param['title']);
            if(in_array($param['type'],$editoperation)) {//记录编辑的操作时需要提供原名称(不含编辑公告)
                if(empty($param['oldtitle'])){
                    return FALSE;
                }
                $logsparam['oldtitle'] = h($param['oldtitle']);
            }
        }else{
            return FALSE;
        }
        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }

    /**
     * 屏蔽、取消屏蔽的评论操作成功后记录操作日志
     */
    protected function reviewAddLog($param){
        $logsparam = $this->getLogsParam();
        if(empty($param['toid'])  || empty($logsparam['clientuid']) || empty($logsparam['crid'])){
            return FALSE;
        }
        $shieldoperation = array('shieldreview','unshieldreview','auditreview','unauditreview'); //屏蔽、取消屏蔽,审核通过、审核不通过评论
        if(in_array($param['type'],$shieldoperation)){//操作成功后记录操作日志
            //根据评论编号获取评论和课程,课件详情
            $detail = $this->apiServer->reSetting()
                ->setService('Classroom.Reviews.getDetailByLogid')
                ->addParams(array('logid'=>$param['toid'],'crid'=>$logsparam['crid']))
                ->request();
            if(empty($detail['title']) || empty($detail['foldername']) || empty($detail['username']) || empty($detail['realname'])){
                return FALSE;
            }
            $logsparam['username'] = $detail['username'];
            $logsparam['realname'] = $detail['realname'];
            $logsparam['iname'] = $detail['foldername'];
            $logsparam['title'] = $detail['title'];
        }else{
            return FALSE;
        }
        $param['logsparam'] = !empty($logsparam) ? $logsparam : array();
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.Log.addLog')->addParams($param)->request();
        if(!empty($ret)){
            return $ret;//成功记录操作日志返回logid
        }
    }
	
    //返回记录操作日志所需参数登陆账号clientid,网校类型roomtype和网校crid
    private function getLogsParam(){
        $roominfo = Ebh::app()->room->getcurroom();
        $roomtype = Ebh::app()->room->getRoomType();
        $user = Ebh::app()->user->getloginuser();
        $logsparam = array();
        if(!empty($roominfo['crid'])){
            $logsparam['crid'] = $roominfo['crid'];
        }
        if(!empty($roomtype)){
            $logsparam['roomtype'] = $roomtype;
        }
        if(!empty($user['uid'])){
            $logsparam['clientuid'] = $user['uid'];
        }
        if(!empty($user['username'])){
            $logsparam['username'] = $user['username'];
        }
        return $logsparam;
    }
}