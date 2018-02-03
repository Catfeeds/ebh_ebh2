<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 */
class StudentController extends ARoomV3Controller{

    /**
     * 修改学生信息
     */
    public function edit(){
        $uid = intval($this->input->post('uid'));
        if($uid <= 0){
            $this->renderjson(1,'用户不存在');
        }
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['uid'] = $uid;

        $cnname = $this->input->post('realname');
        $mobile = $this->input->post('mobile') ? $this->input->post('mobile') : '';
        $sex = $this->input->post('sex');
        $birthdate = $this->input->post('birthdate');
        $email = $this->input->post('email') ? $this->input->post('email') : '';

        $oldclassid = $this->input->post('oldclassid');
        $classid = $this->input->post('classid');
        if(!empty($cnname)){
            $parameters['cnname'] = $cnname;
        }
        //if(!empty($mobile)){
        $parameters['mobile'] = $mobile;
        //}
        if(!empty($email)){
            $parameters['email'] = $email;
            $emailExists = $this->apiServer->reSetting()->setService('Member.User.emailExists')->addParams($parameters)->request();
            if($emailExists){
                $this->renderjson(1,'邮箱已存在');
            }
        }
        if(!empty($sex) || $sex !== null){
            $parameters['sex'] = intval($sex);
        }
        if(!empty($birthdate) || $birthdate !== null){
            $parameters['birthdate'] = $birthdate;
        }

        if((!empty($classid) || $classid !== null) && !empty($oldclassid) || $oldclassid !== null){
            $parameters['classid'] = intval($classid);
            $parameters['oldclassid'] = intval($oldclassid);
        }

        if (!empty($parameters['classid']) && $this->roominfo['property'] == 3) {
            /*$isLastDeptment = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.isLastDept')->addParams('classid', $parameters['classid'])->request();
            if (!$isLastDeptment) {
                $this->renderjson(1,'员工只能添加到底层部门上');
            }*/
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Student.edit')->addParams($parameters)->request();


        $this->renderjson(0,'修改成功',array(),false);
        //更新SNS的班级学生缓存
        $snslib = Ebh::app()->lib('Sns');
        $snslib->delClassUserCache(array('classid'=>$parameters['oldclassid'],'uid'=>$parameters['uid']));
        $snslib->updateClassUserCache(array('classid'=>$parameters['classid'],'uid'=>$parameters['uid']));
        //todo 未修改为服务层
        if($this->roominfo['isschool'] != 7 || $this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3){
            //变更学生课程权限
            $classcoursesModel = $this->model('Classcourses');
            $userpermissionModel = $this->model('Userpermission');
            
            $oldfolders = $classcoursesModel->getfolderidsbyclassid($parameters['oldclassid']);
            $newfolders = $classcoursesModel->getfolderidsbyclassid($parameters['classid']);
            

            if(!empty($oldfolders)){
                foreach ($oldfolders as $folder){
                    $dfids[] = $folder['folderid'];
                }
                //删除旧班级课程权限
                $userpermissionModel->removeStudentPermission($dfids,array($parameters['uid']),2,$parameters['oldclassid']);
            }
            if(!empty($newfolders)){
                foreach($newfolders as $folder){
                    $afids[] = $folder['folderid'];
                }
                //新增班级课程权限
                $aparam['itemid'] = 0;
                $aparam['uid'] = $parameters['uid'];
                $aparam['folderids'] = $afids;
                $aparam['crid'] = $parameters['crid'];
                $aparam['type'] = 2;
                $aparam['classid'] = $parameters['classid'];
                $aparam['dateline'] = SYSTIME;
				$aparam['property'] = $this->roominfo['property'];
                $userpermissionModel->mutifAddPermission($aparam);
            }
        }
		//企业选课用户权限
		if($this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3){
			$data['crid'] = $this->roominfo['crid'];
			$data['classids'] = $parameters['classid'];
			$data['classid'] = $parameters['classid'];
			$itemlist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.classItemList')->addParams($data)->request();
				
			//删除老的班级数据,增加新的
			$data['uids'] = array($parameters['uid']);
			$data['oldclassid'] = $parameters['oldclassid'];
			$this->apiServer->reSetting()->setService('Aroomv3.Schsource.delUserPermision')->addParams($data)->request();
			if(!empty($itemlist)){
				$data['itemlist'] = $itemlist;
				$this->apiServer->reSetting()->setService('Aroomv3.Schsource.addUserPermision')->addParams($data)->request();
			}
		}

        /**写日志开始**/
        $message = json_encode($parameters);
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['crid'],
                'message'=>$message,
                'opid'=>2,
                'type'=>'roomuser'
            )
        );

;
    }

    /**
     * 添加学生
     */
    public function add(){
        $post = $this->input->post();
        $username = $post['username'];
        if(empty($username)){
            $this->renderjson(1,'用户名必须填写');
        }
        if (preg_match("/[\x7f-\xff]/", $username)) {
            $this->renderjson(1,'用户名不能存在中文');
        }
        if(intval($post['classid']) <= 0){
            $this->renderjson(1,($this->roominfo['property'] == 3 ? '部门' : '班级').'必须选择');
        }
        if(empty($post['realname'])){
            $this->renderjson(1,($this->roominfo['property'] == 3 ? '员工' : '学生').'真实姓名必须填写');
        }
        /*if(empty($post['mobile'])){
            $this->renderjson(1,($this->roominfo['property'] == 3 ? '员工' : '学生').'学生联系方式必须填写');
        }*/
        /*if(empty($post['email'])){
            $this->renderjson(1,'学生邮箱必须添加');
        }*/
        /*if ($this->roominfo['property'] == 3) {
            $isLastDeptment = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.isLastDept')->addParams('classid', $post['classid'])->request();
            if (!$isLastDeptment) {
                $this->renderjson(1,'员工只能添加到底层部门上');
            }
        }*/

        $parameters = array();
        $parameters['username'] = $username;
        $userinfo = $this->apiServer->reSetting()->setService('Member.User.getUserByUsername')->addParams($parameters)->request();

        if($userinfo){
            if($userinfo['groupid'] != 6){
                $this->renderjson(1,'不允许添加'.($this->roominfo['property'] == 3 ? '讲师': '教师').'账号');
            }
            $parameters = array();
            $parameters['crid'] = $this->roominfo['crid'];
            $parameters['uid'] = $userinfo['uid'];
            $roomUserInfo  = $this->apiServer->reSetting()->setService('Aroomv3.Student.detail')->addParams($parameters)->request();
            if(!empty($roomUserInfo)){
                $this->renderjson(1,'该用户已经在该网校内');
            }

            $parameters = array();
            $parameters['crid'] = $this->roominfo['crid'];
            $parameters['uid'] = $userinfo['uid'];
            $parameters['cnname'] = $post['realname'];
            $parameters['sex'] = intval($post['sex']);
            $parameters['birthdate'] = empty($post['birthdate']) ? 0 : strtotime($post['birthdate']);
            $parameters['mobile'] = $post['mobile'] ? $post['mobile'] : '';
            $parameters['email'] = isset($post['email'])? $post['email'] : '';

            $this->apiServer->reSetting()->setService('Aroomv3.Student.add')->addParams($parameters)->request();

            $parameters['classid'] = intval($post['classid']);

            $this->apiServer->reSetting()->setService('Aroomv3.Classes.addClassStudent')->addParams($parameters)->request();

            $this->renderjson(0,'添加成功',array(),false);


            fastcgi_finish_request();
            $parameters['username'] = $username;
            $parameters['realname'] = h($post['realname']);
            $parameters['toid'] = $parameters['uid'];
            Ebh::app()->lib('OperationLog')->addLog($parameters,'addstudent');//操作成功记录到操作日志
            //更新SNS的学校学生、班级学生缓存
            Ebh::app()->lib('xNums')->add('user');
            $snslib = Ebh::app()->lib('Sns');
            $snslib->updateClassUserCache(array('classid'=>$parameters['classid'],'uid'=>$parameters['uid']));
            $snslib->updateRoomUserCache(array('crid'=>$parameters['crid'],'uid'=>$parameters['uid']));

            /**新增学生课程权限开始**/
            if($this->roominfo['isschool'] != 7 || ($this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3)){
                //todo 未改用服务层调用
                $classCourseModel = $this->model('Classcourses');
                $userpermissionModel = $this->model('Userpermission');
                $folderids = $classCourseModel->getfolderidsbyclassid($parameters['classid']);
                if(!empty($folderids)){
                    foreach ($folderids as $folder){
                        $fids[] = $folder['folderid'];
                    }
                    $param['itemid'] = 0;
                    $param['folderids'] = $fids;
                    $param['crid'] = $parameters['crid'];
                    $param['uid'] = $parameters['uid'];
                    $param['type'] = 2;
                    $param['classid'] = $parameters['classid'];
                    $param['dateline'] = SYSTIME;
					$param['property'] = $this->roominfo['property'];
                    $userpermissionModel->mutifAddPermission($param);
                }
            }
			//企业选课用户权限
			if($this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3){//企业选课
				$data['crid'] = $this->roominfo['crid'];
				$data['classids'] = $parameters['classid'];
				$data['classid'] = $parameters['classid'];
				$itemlist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.classItemList')->addParams($data)->request();
				if(!empty($itemlist)){
					$data['uids'] = array($parameters['uid']);
					$data['itemlist'] = $itemlist;
					$this->apiServer->reSetting()->setService('Aroomv3.Schsource.addUserPermision')->addParams($data)->request();
				}
			}
            /**新增学生课程权限结束**/

            /**写日志开始**/
            $message = json_encode($parameters);
            Ebh::app()->lib('LogUtil')->add(
                array(
                    'toid'=>$parameters['crid'],
                    'message'=>$message,
                    'opid'=>1,
                    'type'=>'roomuser'
                )
            );
            /**写日志结束**/

            //调用SNS同步接口，类型为4用户网校操作
            $snslib->do_sync($userinfo['uid'], 4);
        }else{
            //不存在用户
            if(empty($post['password'])){
                $this->renderjson(2,'请为新用户设置密码');
            }
            $parameters = array();
            $parameters['username'] = $username;
            $parameters['password'] = $post['password'];
            $parameters['realname'] = $post['realname'];
            $parameters['sex'] = $post['sex'];
            $parameters['birthdate'] = empty($post['birthdate']) ? 0 : strtotime($post['birthdate']);
            $parameters['mobile'] = $post['mobile'] ? $post['mobile'] : '';
            $parameters['email'] = isset($post['email'])? $post['email'] : '';

            if (!empty($parameters['email'])) {
                $emailExists = $this->apiServer->reSetting()->setService('Member.User.emailExists')->addParams($parameters)->request();
                if($emailExists){
                    $this->renderjson(1,'邮箱已存在');
                }
            }

            $uid = $this->apiServer->reSetting()->setService('Member.User.add')->addParams($parameters)->request();
            if (is_scalar($uid)) {
                $uid = intval($uid);
                if ($uid < 1) {
                    $this->renderjson(1,'添加用户失败');
                }
            } else {
                if (empty($uid['status'])) {
                    $this->renderjson(1,$uid['msg']);
                }
                $uid = intval($uid['status']);
            }
            //todo 未更改为服务层
            $this->model('credit')->addCreditlog(array('uid'=>$uid,'ruleid'=>1));
            $parameters['crid'] = $this->roominfo['crid'];
            $parameters['uid'] = $uid;
            $parameters['cnname'] = $post['realname'];
            $this->apiServer->reSetting()->setService('Aroomv3.Student.add')->addParams($parameters)->request();

            $parameters['classid'] = intval($post['classid']);

            $this->apiServer->reSetting()->setService('Aroomv3.Classes.addClassStudent')->addParams($parameters)->request();
            $this->renderjson(0,'添加成功',array(),false);
            fastcgi_finish_request();
            //新用户注册时记录注册信息到日志
            if($uid){
                $logdata = array();
                $logdata['uid']=$parameters['uid'];
                $logdata['crid']=$parameters['crid'];
                $logdata['logtype'] = 2;
                $registerloglib=Ebh::app()->lib('RegisterLog');
                $registerloglib->addOneRegisterLog($logdata);
                $parameters['toid'] = $uid;
                Ebh::app()->lib('OperationLog')->addLog($parameters,'addstudent');//操作成功记录到操作日志
            }
            Ebh::app()->lib('xNums')->add('user');
            //更新SNS的学校学生、班级学生缓存
            $snslib = Ebh::app()->lib('Sns');
            $snslib->updateClassUserCache(array('classid'=>$parameters['classid'],'uid'=>$uid));
            $snslib->updateRoomUserCache(array('crid'=>$parameters['crid'],'uid'=>$uid));

            /**新增学生课程权限开始**/
            //todo 未修改为服务层
            if($this->roominfo['isschool'] != 7 || ($this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3)){
                $classCourseModel = $this->model('Classcourses');
                $userpermissionModel = $this->model('Userpermission');
                $folderids = $classCourseModel->getfolderidsbyclassid($parameters['classid']);
                

                if(!empty($folderids)){
                    foreach ($folderids as $folder){
                        $fids[] = $folder['folderid'];
                    }
                    $param['itemid'] = 0;
                    $param['folderids'] = $fids;
                    $param['crid'] = $parameters['crid'];
                    $param['uid'] = $parameters['uid'];
                    $param['type'] = 2;
                    $param['classid'] = $parameters['classid'];
                    $param['dateline'] = SYSTIME;
					$param['property'] = $this->roominfo['property'];
                    $userpermissionModel->mutifAddPermission($param);
                }
            }
			//企业选课用户权限
			if($this->roominfo['isschool'] == 7 && $this->roominfo['property'] == 3){//企业选课
				$data['crid'] = $this->roominfo['crid'];
				$data['classids'] = $parameters['classid'];
				$data['classid'] = $parameters['classid'];
				$itemlist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.classItemList')->addParams($data)->request();
				if(!empty($itemlist)){
					$data['uids'] = array($parameters['uid']);
					$data['itemlist'] = $itemlist;
					$this->apiServer->reSetting()->setService('Aroomv3.Schsource.addUserPermision')->addParams($data)->request();
				}
			}
            /**新增学生课程权限结束**/

            /**写日志开始**/
            $message = json_encode($parameters);
            Ebh::app()->lib('LogUtil')->add(
                array(
                    'toid'=>$parameters['crid'],
                    'message'=>$message,
                    'opid'=>1,
                    'type'=>'roomuser'
                )
            );
            /**写日志结束**/

            //调用SNS同步接口，类型为4用户网校操作
            $snslib->do_sync($uid, 4);

        }


    }

    public function del(){
        $parameters = array();
        $uid = intval($this->input->post('uid'));
        if($uid <= 0){
            $this->renderjson(1,'用户不存在');
        }
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['uid'] = $uid;

        $roomUserInfo  = $this->apiServer->reSetting()->setService('Aroomv3.Student.detail')->addParams($parameters)->request();

        $parameters['classid'] = intval($roomUserInfo['classid']);
        if($this->roominfo['stunum'] <= 1){
            $this->renderjson(1,'删除失败,最后一个学生不能删除');
        }
        $userinfo = array();
        $userinfo = $this->apiServer->reSetting()->setService('Aroomv3.Student.getRoomuser')->addParams($parameters)->request();

        $res = $this->apiServer->reSetting()->setService('Aroomv3.Student.del')->addParams($parameters)->request();

        if($res){
            //删除缓存
            $snslib = Ebh::app()->lib('Sns');
            $snslib->delClassUserCache(array('classid'=>$parameters['classid'],'uid'=>$parameters['uid']));
            $snslib->delRoomUserCache(array('crid'=>$parameters['crid'],'uid'=>$parameters['uid']));

            /**移除用户课程权限开始**/
            if($this->roominfo['isschool'] != 7){
                $userpermissionModel = $this->model('Userpermission');
                $userpermissionModel->removeStudentPermission(array(),array($parameters['uid']),2,$parameters['classid']);
            }
            /**移除用户课程权限结束**/

            $this->renderjson(0,'删除成功',array(),false);
        }else{
            $this->renderjson(1,'删除失败',array(),false);
        }

        fastcgi_finish_request();
        /**写日志开始**/
        $message = ' [ '.(empty($res)?'删除失败':'删除成功').' ] '.json_encode($parameters);
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$parameters['crid'],
                'message'=>$message,
                'opid'=>4,
                'type'=>'roomuser'
            )
        );
        /**写日志结束**/
        if($res){
            $userinfo['toid'] = $uid;
            Ebh::app()->lib('OperationLog')->addLog($userinfo,'delstudent');//操作成功记录到操作日志
            //调用SNS同步接口，类型为4用户网校操作
            $snslib->do_sync($parameters['uid'], 4);
            Ebh::app()->lib('xNums')->add('user',-1);
        }


    }

    /**
     * 读取学生列表
     */
    public function lists(){
        $parameters = array();
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $parameters['q'] = $this->input->get('q');
        $isenterprise = Ebh::app()->room->getRoomType() == 'com' ? 1 : 0;
        $parameters['isenterprise'] = intval($this->input->get('isenterprise')) == 1 ? 1 : $isenterprise;
        if ($this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $parameters['uid'] = $this->user['uid'];
        }
        $classid = intval($this->input->get('classid'));
        if($classid > 0){
            $parameters['classid'] = $classid;
        }
        if ($this->roominfo['domain'] == 'lcyhg') {
            $parameters['ismulclass'] = true;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Student.list')->addParams($parameters)->request();
        //print_r($result);exit;
        if ($parameters['isenterprise'] == 1 && !empty($result['list'])) {
            $parameters = array(
                'crid' => $this->roominfo['crid'],
                'crname' => $this->roominfo['crname']
            );
            if ($this->roominfo['uid'] != $this->user['uid']) {
                //非管理员用户,读取用户角色
                $parameters['uid'] = $this->user['uid'];
                $parameters['roomtype'] = 'com';
            }
            $depts = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.index')->addParams($parameters)->request();
            if (!empty($depts)) {
                array_walk($depts, function(&$dept, $classid, $parents) {
                    $parents = array_filter($parents, function($parent) use($dept) {
                        return $parent['lft'] < $dept['lft'] && $parent['rgt'] > $dept['rgt'];
                    });
                    if (empty($parents)) {
                        return;
                    }
                    $lfts = array_column($parents, 'lft');
                    array_multisort($lfts, SORT_ASC, SORT_NUMERIC, $parents);
                    $dept['paths'] = array_column($parents, 'classid');
                    $dept['paths'][] = $dept['classid'];
                }, $depts);
            }
            array_walk($result['list'], function(&$student, $k, $depts) {
                if (isset($student['path'])) {
                    $student['path'] = trim($student['path'], '/');
                    $student['path'] = substr(strstr($student['path'], '/'), 1);
                    $student['path'] = preg_replace('/\//', '>', $student['path']);
                    $student['path'] = urldecode($student['path']);
                } else {
                    $student['path'] = '';
                }

                if (isset($student['classid']) && isset($depts[$student['classid']])) {
                    $student['paths'] = isset($depts[$student['classid']]['paths']) ? $depts[$student['classid']]['paths'] : '';
                } else {
                    $student['paths'] = array($this->roominfo['crid']);
                }
            }, $depts);
        }

        $this->renderjson(0,'',$result);
    }

    /**
     * 学生身份进入
     */
    public function login(){
        $uid = $this->input->get('uid');

        if($uid <=0){
            exit;
        }
        $url  = '/aroom/umanager/student.html?s='.urlencode(authcode($uid,'ENCODE'));

        header("Location:".$url);exit;
    }
	
	/*
	 *按日期分布的每日新生人数列表
	 */
	public function newCountList(){
		$data['crid'] = $this->roominfo['crid'];
		$data['starttime'] = intval($this->input->get('starttime'));
		$data['endtime'] = intval($this->input->get('endtime'));
		//起始时间和结束时间在一天以内的，查询按小时
		if(!empty($data['endtime']) && !empty($data['starttime']) && $data['endtime'] - $data['starttime'] <=86400){
			$data['byhour'] = 1;
		}
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Student.newCountList')->addParams($data)->request();
		
		$countlist = array();
		// if(!empty($list)){
			if(empty($data['byhour'])){//按日期
				foreach($list as $count){
					$thatday = strtotime(date('Y-m-d', $count['cdateline']));
					$countlist[$thatday] = array('date'=>$thatday,'count'=>$count['count']);
				}
				if(!empty($data['starttime']) && !empty($data['endtime'])){//填入空缺日期
					$startdate = strtotime(date('Y-m-d', $data['starttime']));
					$enddate = strtotime(date('Y-m-d', $data['endtime']));
					while($startdate<=$enddate){
						if(!isset($countlist[$startdate])){
							$countlist[$startdate] = array('date'=>$startdate,'count'=>0);
						}
						$startdate += 86400;
					}
				}
			} else {//按小时
				foreach($list as $count){
					$thathour = strtotime(date('Y-m-d H:0', $count['cdateline']));
					$countlist[$thathour] = array('date'=>$thathour,'count'=>$count['count']);
				}
				if(!empty($data['starttime']) && !empty($data['endtime'])){//填入空缺小时
					$startdate = strtotime(date('Y-m-d', $data['starttime']));
					$enddate = $startdate+86400;
					while($startdate<=$enddate){
						if(!isset($countlist[$startdate])){
							$countlist[$startdate] = array('date'=>$startdate,'count'=>0);
						}
						$startdate += 3600;
					}
				}
			}
		// }
		ksort($countlist);
		$this->renderjson(0,'',array_values($countlist));
	}

    /**
     * 禁用/解禁用户
     */
	public function activate() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        if ($this->input->post('uid') === null) {
            $this->renderjson(1, '缺少参数');
        }
        $uid = intval($this->input->post('uid'));
        $status = intval($this->input->post('status')) == 1 ? 1 : 0;
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Student.activate')
            ->addParams(array(
                'crid' => $this->roominfo['crid'],
                'status' => $status,
                'uid' => $uid
            ))->request();

        if (!empty($ret)) {
            $this->renderjson(0,'操作成功',array(),false);
            fastcgi_finish_request();	//操作成功，则直接返回前端输出
            if(isset($status)){//0禁用,1解禁
                Ebh::app()->lib('OperationLog')->addLog(array('status' => $status,'toid' => $uid),(!empty($status)?'unlockstudent':'lockstudent'));//操作成功记录到操作日志
            }
        }
        $this->renderjson(1, '操作失败');
    }
    
 
    /**
     * 修改密码
     */
    public function editpass(){
        $param['uid'] = intval($this->input->post('uid'));
        $param['password'] = $this->input->post('password');
        $ret = $this->apiServer->reSetting()
                ->setService('Aroomv3.Student.editpwd')
                ->addParams($param)
                ->request();

        if (!empty($ret)) {
            $this->renderjson(0,'修改成功',array(),false);
        }else{
            $this->renderjson(1, '修改失败',array(),false);
        }
        /**写日志开始**/
        fastcgi_finish_request();
        if (!empty($ret)) {
            Ebh::app()->lib('OperationLog')->addLog(array('toid' => $param['uid'], 'password' => h($param['password'])), 'studentpass');//操作成功记录到操作日志
        }
        $message = json_encode($param);
        Ebh::app()->lib('LogUtil')->add(
            array(
                'toid'=>$param['uid'],
                'message'=>$message,
                'opid'=>2,
                'type'=>'member'
            )
        );
        /**写日志结束**/
    }

    /**
     * @describe:学生统计
     * @User:tzq
     * @Date:${DATE}
     */
    public function getCreditCount(){
        $start = microtime(true);
        //获取各类课程id
        $config = Ebh::app()->getConfig()->load('othersetting');


        $params['newlecture']     = $config['newlecture'];
        $params['newtransaction'] = $config['newtransaction'];
        $params['newregulations'] = $config['newregulations'];
        $params['communication']  = $config['newregulations'];
        $params['p']              = $this->input->request('p');
        $params['listRows']       = $this->input->request('listRows');
        //判断时间格式是否正确
        $year = $this->input->request('year');
        if (!preg_match('/^\d{4}$/', $year)) {
            $this->renderjson(1, '年份参数错误');
        }
        //判断季度类型
        $quarter = $this->input->request('quarter');

        if (!preg_match('/^\d{1}$/', $quarter)) {
            $this->renderjson(1, '季度参数错误');
        }
        //自然年且查询全部季度
        if ($quarter == 0 && $year == date('Y')) {
            $quarter = 5;
        }
        $params['crid'] = $this->roominfo['crid'];//校区id

        //计算时间
        switch ($quarter) {
            case 1:
                $beginTime = $year . '-01-01';
                $t         = date('t', strtotime($year . '-3'));
                $endTime   = $year . '-03-' . $t . ' 23:59:59';
                break;
            case 2:
                $beginTime = $year . '-04-01';
                $t         = date('t', strtotime($year . '-6'));
                $endTime   = $year . '-06-' . $t . ' 23:59:59';
                break;
            case 3:
                $beginTime = $year . '-07-01';
                $t         = date('t', strtotime($year . '-9'));
                $endTime   = $year . '-09-' . $t . ' 23:59:59';
                break;

            case 4:
                $beginTime = $year . '-10-01';
                $t         = date('t', strtotime($year . '-12'));
                $endTime   = $year . '-12-' . $t . ' 23:59:59';
                break;
            case 5:
                $beginTime = $year . '-01-01';
                $t         = date('t', strtotime($year . '-12'));
                $endTime   = date('Y-m-d') . ' 23:59:59';
                break;
            default:
                $beginTime = $year . '-01-01';
                $t         = date('t', strtotime($year . '-12'));
                $endTime   = $year . '-12-' . $t . ' 23:59:59';
                break;

        }
        $params['beginTime'] = strtotime($beginTime);
        $params['endTime']   = strtotime($endTime);
        $params['type']   = $this->input->request('type') or 1;
        $params['attach'] = $this->input->request('attach');
        $list             = $this->apiServer->reSetting()->setService('Aroomv3.Student.getCreditCount')->addParams($params)->request();
        if ($list == false) {
            $this->renderjson(1, '未知错误');
        } else {
            $end                      = microtime(true);
            if($params['type'] == 2){
                $param = [];
                $param['crid'] = $params['crid'];
                $uidArr        = array_keys($list['list']);
                $param['uids'] = implode(',',$uidArr);
                $creditList    = $this->apiServer->reSetting()->setService('Aroomv3.Student.getCreditList')->addParams($param)->request();//获取总学分

                if(!empty($creditList)){
                    foreach ($list['list'] as $uid=>&$item){
                        $item['countCredit'] = isset($creditList[$uid]['score'])&&$creditList[$uid]['score']>0?$creditList[$uid]['score']:0;
                    }
                }
            }
            $list['page']['execTime'] = $end - $start;
            $this->renderjson(0, '获取数据成功', $list);
        }

    }

    /**
     * @describe:导出学生统计数据
     * @User:tzq
     * @Date:${DATE}
     */
    public function outExclgetCreditCount(){
        $start = microtime(true);
        //获取各类课程id
        $config =  Ebh::app()->getConfig()->load('othersetting');


        $params['newlecture']           = $config['newlecture'];
        $params['newtransaction']       = $config['newtransaction'];
        $params['newregulations']       = $config['newregulations'];
        $params['communication']        = $config['newregulations'];
        //判断时间格式是否正确
        $year   = $this->input->request('year');
        if(!preg_match('/^\d{4}$/',$year)){
            echo '年份参数错误';
        }
        //判断季度类型
        $quarter = $this->input->request('quarter');

        if(!preg_match('/^\d{1}$/',$quarter)){
            echo '季度参数错误';
        }
        //自然年且查询全部季度
        if($quarter == 0 && $year == date('Y')){
            $quarter = 5;
        }
        $params['crid']    = $this->roominfo['crid'];//校区id


        //计算时间
        switch ($quarter){
            case 1:
                $beginTime = $year.'-01-01';
                $t         = date('t',strtotime($year.'-3'));
                $endTime   = $year.'-03-'.$t.' 23:59:59';
                break;
            case 2:
                $beginTime = $year.'-04-01';
                $t         = date('t',strtotime($year.'-6'));
                $endTime   = $year.'-06-'.$t.' 23:59:59';
                break;
            case 3:
                $beginTime = $year.'-07-01';
                $t         = date('t',strtotime($year.'-9'));
                $endTime   = $year.'-09-'.$t.' 23:59:59';
                break;

            case 4:
                $beginTime = $year.'-10-01';
                $t         = date('t',strtotime($year.'-12'));
                $endTime   = $year.'-12-'.$t.' 23:59:59';
                break;
            case 5:
                $beginTime = $year.'-01-01';
                $t         = date('t',strtotime($year.'-12'));
                $endTime   = date('Y-m-d').' 23:59:59';
                break;
            default:
                $beginTime = $year.'-01-01';
                $t         = date('t',strtotime($year.'-12'));
                $endTime   = $year.'-12-'.$t.' 23:59:59';
                break;

        }
        $params['beginTime']   =  strtotime($beginTime);
        $params['endTime']     =  strtotime($endTime);
        $list = $this->apiServer->reSetting()->setService('Aroomv3.Student.outExclgetCreditCount')->addParams($params)->request();
        //var_dump($list);
        if(!empty($list)){
            $param = [];
            $param['crid'] = $params['crid'];
            $uidArr        = array_keys($list);
            $param['uids'] = implode(',',$uidArr);
            $creditList = $this->apiServer->reSetting()->setService('Aroomv3.Student.getCreditList')->addParams($param)->request();//获取总学分

            foreach ($list as $uid=>&$item){

               $item['countCredit'] = isset($creditList[$uid]['score'])&&$creditList[$uid]['score']>0?$creditList[$uid]['score']:0;
            }
            //$this->outExecl($list,array(),$start);
            $this->outCsv($list);
        }else{
            echo '没有数据导出';
        }





    }

    /***
     * @describe:导出csv
     * @User:tzq
     * @Date:${DATE}
     * @param $data
     */
    public function outCsv($data){
       // log_message('开始导出：');
       // $start = microtime(true);
        $output = fopen('php://output', 'w') or die("can't open php://output");
//告诉浏览器这个是一个csv文件
        $filename = date('YmdHis');

        header("Content-Type: application/csv");
        header("Content-Disposition: attachment; filename=$filename.csv");
//输出表头
        $table_head = array('姓名', '所在班级','总学分', '期间学分', '讲座中心学分得分', '讲座中心评论得分', '业务纵览学习得分', '业务纵览评论得分', '政治法规学习得分'
        , '政治法规评论得分', '交流园地发文得分', '交流园地阅读得分', '评论总数', '得分评论数');
        $table_head = mb_convert_encoding(implode(',', $table_head), 'GBK', 'UTF-8');
        $table_head = explode(',', $table_head);
        // $table_head = explode(',',$table_head);

        fputcsv($output, $table_head);

//输出每一行数据到文件中
            foreach ($data as $e) {
//    unset($e['xx']);//若有多余字段可以使用unset去掉
//    $e['xx'] = isset($e['xxx']) ? "xx" : 'x'; //可以根据需要做相应处理
                //输出内容
                if (isset($e['path'])) {
                    $temp           = trim($e['path']);
                    $temp           = preg_replace('/\/.+\//U', '', $temp, 1);
                    $e['classname'] = $temp ? $temp : $e['classname'];
                    unset($e['path']);

                }
                if(isset($e['uid'])){
                    unset($e['uid']);
                }
                if(!empty($e['realname'])){
                    unset($e['username']);
                }else{
                    unset($e['realname']);
                }
                $e = mb_convert_encoding(implode(',', $e), 'GBK', 'UTF-8');
                $e = explode(',', $e);
                fputcsv($output, array_values($e));
            }

            fclose($output) or die("can't close php://output");
         //  $end = microtime(true);
         //  log_message('共消耗时间：'.($end-$start).'秒');
    }
        /***
         * 导出execl
         *
         * @param $header 头部数组A1=>value
         * @param $data   数组数据普通
         * @param $field  a=>字段名
         */
    public function outExecl($data=array(),$header=array(),$start){

        //log_message('查询数据耗时：'.(microtime(true)-$start).'秒');
        $start = microtime(true);
        $name        = date('YmdHis');
        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        $header      = array('学生账号', '所在班级', '学分'
        , array('讲座中心', array('学习得分', '评论得分'))
        , array('业务纵览', array('学习得分', '评论得分'))
        , array('政治法规', array('学习得分', '评论得分'))
        , array('交流园地', array('发文得分', '阅读得分'))
        , '评论总数'
        , '得分评论数'
        );
            //设置缓冲方式
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    //'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    'color' => array('argb' => '99999999'),
                ),
            ),
        );
        //$objWorksheet->getStyle('A5:N'.$n)->applyFromArray($styleArray);
            /*以下是一些设置 ，什么作者  标题啊之类的*/
            $objPHPExcel->getProperties()->setCreator("学生统计")
                ->setLastModifiedBy("")
                ->setTitle("")
                ->setSubject("")
                ->setDescription("")
                ->setKeywords("excel")
                ->setCategory("result file");
            /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
            if ($header) {
                $k = 'A';
                foreach ($header as $key => $value) {
                    if(is_string($value)){

                        $objPHPExcel->getActiveSheet()->getStyle($k . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->setActiveSheetIndex(0)
                            //Excel的第A列，uid是你查出数组的键值，下面以此类推
                            ->setCellValue($k . '1', $value);
                  

                        $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getFont()->setSize(14);
                        $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getFill()->getStartColor()->setARGB('CCCCCCCC');
                        $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(20);
                        $objPHPExcel->getActiveSheet()->mergeCells($k.'1:'.$k.'2');
                        $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    }else{
                        $objPHPExcel->getActiveSheet()->getStyle($k . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->setActiveSheetIndex(0)

                            //Excel的第A列，uid是你查出数组的键值，下面以此类推
                            ->setCellValue($k . '1', $value[0]);

                        $k1 = $k;
                        $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getFont()->setSize(14);
                        $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getFill()->getStartColor()->setARGB('CCCCCCCC');  $objPHPExcel->getActiveSheet()->getStyle($k.'2')->getFont()->setSize(14);
                        $objPHPExcel->getActiveSheet()->getStyle($k.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $objPHPExcel->getActiveSheet()->getStyle($k.'2')->getFill()->getStartColor()->setARGB('CCCCCCCC');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k.'2',$value[1][0]);
                        $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(20);
                        $k++;
                        $objPHPExcel->getActiveSheet()->mergeCells($k1.'1:'.$k.'1');
                        $objPHPExcel->getActiveSheet()->getStyle($k.'2')->getFont()->setSize(14);
                        $objPHPExcel->getActiveSheet()->getStyle($k.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $objPHPExcel->getActiveSheet()->getStyle($k.'2')->getFill()->getStartColor()->setARGB('CCCCCCCC');
                        $objPHPExcel->getActiveSheet()->getStyle($k.'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k.'2',$value[1][1]);
                        $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(20);

                    }

                    $k++;

                }
                $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($styleArray);

            }
//        $index = 1;
//        $num = !empty($header)?1:0;
//        for($i = 0;$i<4;$i++){
//
//            $data = [];
//            for($i = 0;$i<2000;$i++){
//                array_push($data,array('name'=>$i,'age'=>$i));
//            }
//
//
        $num = 2;

                foreach ($data as $key => $v) {
                    $num++;
                    $k = 'A';
                    foreach ($v as $kk => $vv) {
                        if ($kk == 'uid' || $kk == 'path') {
                            continue;
                        }
                        if ($kk == 'classname') {
                            if (empty($v['path'])) {
                                unset($v['path']);
                            } else {
                                $str = trim($v['path'], '/');
                                $vv  = preg_replace('/.+\//U', '', $str, 1);
                                unset($v['path']);
                            }
                        }
                        $objPHPExcel->setActiveSheetIndex(0)
                            //Excel的第A列，uid是你查出数组的键值，下面以此类推
                            ->setCellValue($k . $num, $vv)
                            ->getColumnDimension($k)->setwidth(20);
                        $objPHPExcel->getActiveSheet()->getStyle($k . $num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $k++;

                    }
                }

        ob_end_clean();
        $objPHPExcel->getActiveSheet()->setTitle('学生统计表单');
//    $objPHPExcel->setActiveSheetIndex(0);
        //$filename =  dirname(dirname(__DIR__)).'/logs/'.$name.'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        $time = microtime(true) - $start;
        //log_message('生成表格耗时：' . $time . '秒');
            //$objWriter->save($filename);
            exit;

        }


}