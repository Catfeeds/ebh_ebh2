<?php
/**
 *教室信息拷贝
 * usage:
 * $lib = Ebh::app()->lib('RoomCpy');
 *  	$param = array(
 * 		'scrid'=>'10440',
 *		'dcrid'=>'10563',
 *		'uid'=>'381742'
 *	);
 *	$lib->config($param)->docopy();
 */
class RoomCpy{
	private $scrid = 0; //源学校
	private $dcrid = 0; //目标学校
	private $uid = 0; //目标用户uid
	private $db = NULL;
	private $folderids_map = array(); //新旧课程id映射
	private $classids_map = array(); //新旧班级id映射
	private $eids_map = array(); //新旧作业id映射
	private $cwids_map = array(); //新旧课件id映射
	private $sids_map = array(); //新就sid映射
	private $scwids = array(); //源课件id集合
    private $modules = array(); //模块集
    private $now; //当前时间
    private $new_memeber_id = 0;//默认学生ID
    private $default_class_id = 0; //默认网校ID
    private $room_type = 'edu';//网校类型
    private $crname = '';//新网校名称
	//参数配置
	public function config($params = array()){
		foreach ($params as $pkey => $pvalue) {
			$this->$pkey = $pvalue;
		}
        $this->now = SYSTIME;
		return $this;
	}
	//初始化
	private function _init(){
		$this->db = Ebh::app()->getDb();
		if ($this->scrid > 0) {
		    $roominfo = $this->db->query(
		        'SELECT `property`,`isschool` FROM `ebh_classrooms` WHERE `crid`='.$this->dcrid)
                ->row_array();
		    if (!empty($roominfo) && $roominfo['isschool'] == 7 && $roominfo['property'] == 3) {
		        $this->room_type = 'com';
            }
        }
        if ($this->dcrid > 0) {
		    $room = $this->db->query('SELECT `crname` FROM `ebh_classrooms` WHERE `crid`='.$this->dcrid)
                ->row_array();
		    if (!empty($room)) {
		        $this->crname = $room['crname'];
            }
        }
	}
	//执行拷贝
	public function docopy($copy_modules = false){
		set_time_limit(0);
		if(!$this->_check()){
			return false;
		}
		//以下方法不能分开执行，顺序不能颠倒
		//执行初始化
        $this->_init();

        /*$this->_cp_homework();
        exit;*/

        //拷贝班级信息
        $this->_dclass_cpy($copy_modules);

		//拷贝课程信息
		$this->_folder_cpy();
		//拷贝section信息
		$this->_section_cpy();
		//拷贝课件信息
		$this->_courseware_cpy();
		//拷贝附件信息
		$this->_attachment_cpy();
		$exam_num = 0;
        if (!$copy_modules) {
            //拷贝作业信息
            $exam_num = $this->_exam_cpy();
        } else {
            //拷贝新版作业
            $exam_num = $this->_cp_homework();
        }

		//更新教室信息
		$this->_room_update($exam_num);

        if ($copy_modules === true) {
            //拷贝模板布局
            if (!$this->_cp_modules_set($this->room_type) || empty($this->modules)) {
                log_message('同步模块失败，终止后续操作');
                return false;
            }
            foreach ($this->modules as $module) {
                switch ($module) {
                    case 2:
                        $this->_cp_navigation();
                        break;
                    case 4:
                        $this->_cp_notice();
                        break;
                    case 5:
                        $this->_cp_about();
                        break;
                    case 8:
                        $this->_cp_news();
                        break;
                    case 10:
                        $this->_cp_survey();
                        break;
                    case 12:
                        $this->_cp_app();
                        break;
                }
            }
        }

        //拷贝服务包信息,默认学生课程权限
        if ($copy_modules && !empty($this->folderids_map)) {
            $this->_cp_pay_service($this->folderids_map);
            $this->_cp_userpermisions();
        }
	}
	
	private function _check(){
		if(empty($this->scrid) || empty($this->dcrid) || empty($this->uid)){
			log_message('缺少拷贝参数');
			return false;
		}else{
			return true;
		}
	}
	//班级拷贝
	private function _dclass_cpy($sign = false){
		//查找目标班级信息
		$scrid = $this->scrid;
		$dcrid = $this->dcrid;
		$uid = $this->uid;
		$sclasses = $this->_getClasses($scrid);
		if(empty($sclasses)){
			$classids_map = array();
			$classids = array();
			$param = array();
			log_message('源班级为空');
			//源班级为空时，创建一个默认班级
			if(!empty($dcrid)){
				$param['classname'] = $this->room_type == 'edu' ? '默认班级' : $this->crname;
				$param['crid'] = $dcrid;
				$param['stunum'] = 0;
				$param['dateline'] = SYSTIME;
				if ($this->room_type == 'com') {
				    $param['category'] = 1;
				    $param['lft'] = 1;
				    $param['rgt'] = 2;
				    $param['path'] = '/'.$this->crname;
                }
				$classid = $this->_createClass($param);
				if(!empty($classid)){
                    $this->default_class_id = $classid;
                    if ($this->room_type == 'edu') {
                        $res = $this->_defaultStudent($dcrid,$classid);
                    }
					$classids[] = $classid;
				}
			}
			$this->_classteacher_add($classids,$uid);
			$this->classids_map = $classids_map;
		}else{
			$classids = array();
			$classids_map = array();
			$default = 0;
			$param = array();
			if ($this->room_type == 'edu') {
                foreach ($sclasses as $sclass) {
                    $sclassid = $sclass['classid'];
                    unset($sclass['classid']);
                    $sclass['crid'] = $dcrid;
                    $sclass['stunum'] = 0;
                    $sclass['dateline'] = SYSTIME;
                    $defaultClass = false;
                    if ($sclass['classname'] == '默认班级') {
                        $defaultClass = true;
                    }
                    $classid = $this->_createClass($sclass);
                    if($defaultClass){
                        $default = $classid;
                        $this->default_class_id = $classid;
                    }
                    if(empty($classid)){
                        log_message('拷贝班级信息出错:'.var_export($sclass,true));
                        exit;
                    }
                    $classids[] = $classid;
                    $classids_map['c_'.$sclassid] = $classid;
                }
            }

			if(!empty($default)){
			    if ($this->room_type == 'edu') {
                    $this->_defaultStudent($dcrid,$default);
                }

			}else{
				$param['classname'] = $this->room_type == 'edu' ? '默认班级' : $this->crname;
				$param['crid'] = $dcrid;
				$param['stunum'] = 0;
				$param['dateline'] = SYSTIME;
				if ($this->room_type == 'com') {
				    $param['stunum'] = 0;
				    $param['grade'] = 0;
				    $param['category'] = 1;
				    $param['superior'] = 0;
				    $param['code'] = 0;
				    $param['lft'] = 1;
				    $param['rgt'] = 2;
				    $param['path'] = '/'.$this->crname;
                }
				$classiddefault = $this->_createClass($param);
				if (!empty($classiddefault)) {
                    $classids[] = $classiddefault;
                }
				if(!empty($classiddefault) && $this->room_type == 'edu'){
                    $this->default_class_id = $classiddefault;
                    $res = $this->_defaultStudent($dcrid,$classiddefault);
				}
			}
			$this->_classteacher_add($classids,$uid);
			$this->classids_map = $classids_map;
		}
		
	}
	//课程拷贝
	private function _folder_cpy(){
		//查找目标课程信息
		$scrid = $this->scrid;
		$dcrid = $this->dcrid;
		$uid = $this->uid;
		$sfolders = $this->_getFolders($scrid);
		if(empty($sfolders)){
			log_message('源课程为空');
			return;
		}
		$folderids = array();
		$folderids_map = array(); //课程映射
		foreach ($sfolders as $sfolder) {
			$sfolderid = $sfolder['folderid'];
			unset($sfolder['folderid']);
			$sfolder['uid'] = $uid;
			$sfolder['crid'] = $dcrid;
			$sfolder['upid'] = 0;
			$sfolder['speaker'] = '';
			$folderid = $this->_createFolder($sfolder);
			if(empty($folderid)){
				log_message('拷贝课程信息出错:'.var_export($sfolder,true));
				exit;
			}
			$folderids[] = $folderid;
			$folderids_map['f_'.$sfolderid] = $folderid;
		}
		$this->_folderteacher_add($folderids,$uid,$dcrid);
		$this->folderids_map = $folderids_map;
	}
	//section拷贝
	private function _section_cpy(){
		$scrid = $this->scrid;
		$dcrid = $this->dcrid;
		$uid = $this->uid;
		$ssections = $this->_getSections($scrid);
		if(empty($ssections)){
			log_message('源Sections为空');
			return;
		}
		$sids_map = array();
		foreach ($ssections as $ssection) {
			$ssid = $ssection['sid'];
			$sfolderid = $ssection['folderid'];
			$fkey = 'f_'.$sfolderid;
			$ssection['folderid'] = array_key_exists($fkey, $this->folderids_map)?$this->folderids_map[$fkey]:0;
			if(empty($ssection['folderid'])){
				continue;
			}
			$ssection['crid'] = $dcrid;
			$ssection['dateline'] = SYSTIME;
			unset($ssection['sid']);
			$sid = $this->db->insert('ebh_sections',$ssection);
			if(empty($sid)){
				log_message('section拷贝失败'.var_export($sid,true));
			}else{
				$sids_map['s_'.$ssid] = $sid;
			}
		}
		$this->sids_map = $sids_map;
	}
	//作业拷贝
	private function _exam_cpy(){
		$scrid = $this->scrid;
		$dcrid = $this->dcrid;
		$uid = $this->uid;
		$sexams = $this->_getExams($scrid);
		if(empty($sexams)){
			log_message('源作业为空');
			return;
		}
		$eids = array();
		$eids_map = array();
		foreach ($sexams as $sexam) {
			$seid = $sexam['eid'];
			unset($sexam['eid']);
			$ckey = 'c_'.$sexam['classid'];
			$fkey = 'f_'.$sexam['folderid'];
			$wkey = 'w_'.$sexam['cwid'];
			if(!empty($sexam['classid'])){
				if(!array_key_exists($ckey, $this->classids_map)){
					continue;
				}else{
					$sexam['classid'] = $this->classids_map[$ckey];
				}
			}

			if(!empty($sexam['folderid'])){
				if(!array_key_exists($fkey, $this->folderids_map)){
					continue;
				}else{
					$sexam['folderid'] = $this->folderids_map[$fkey];
				}
			}

			if(!empty($sexam['cwid'])){
				if(!array_key_exists($wkey, $this->cwids_map)){
					continue;
				}else{
					$sexam['cwid'] = $this->cwids_map[$wkey];
				}
			}

			$sexam['uid'] = $uid;
			$sexam['crid'] = $dcrid;
			$sexam['chapterid'] = 0;//不考虑知识点
			$eid = $this->_createExam($sexam);
			if(empty($eid)){
				log_message('拷贝作业信息出错:'.var_export($sexam,true));
				exit;
			}
			$eids[] = $eid;
			$eids_map['e_'.$seid] = $eid;
		}
		$this->eids_map = $eids_map;
		return count($sexams);
	}
	//课件拷贝
	private function _courseware_cpy(){
		$scrid = $this->scrid;
		$dcrid = $this->dcrid;
		$uid = $this->uid;
		$scoursewares = $this->_getCousesWares($scrid);
		if(empty($scoursewares)){
			log_message('源课件为空');
			return;
		}
		$cwids = array();
		$cwids_map = array();
		$scwids = array();
		$roomcourses_params = array();
		foreach ($scoursewares as $scourseware) {
			$scwid = $scourseware['cwid'];
			$sfolderid = $scourseware['folderid'];
			$scdisplayorder = $scourseware['cdisplayorder'];
			$sisfree = $scourseware['isfree'];
			$ssid = $scourseware['sid'];
			unset($scourseware['cwid']);
			unset($scourseware['folderid']);
			unset($scourseware['isfree']);
			unset($scourseware['cdisplayorder']);
			unset($scourseware['sid']);
			$scourseware['uid'] = $uid;
			$scourseware['catid'] = 0;
			$scourseware['reviewnum'] = 0;
			$cwid = $this->_createCousesWare($scourseware);
			if(empty($cwid)){
				log_message('拷贝课件出错:'.var_export($scourseware,true));
				exit;
			}

			$scwids[] = $scwid;
			$cwids[] = $cwid;
			$cwids_map['w_'.$scwid] = $cwid;
			$fkey = 'f_'.$sfolderid;
			$folderid = array_key_exists($fkey, $this->folderids_map)?$this->folderids_map[$fkey]:0;
			if(empty($folderid)){
				continue;
			}
			$skey = 's_'.$ssid;
			$ssid = array_key_exists($skey, $this->sids_map)?$this->sids_map[$skey]:0;
			$roomcourses_params[] = array(
				'crid'=>$dcrid,
				'cwid'=>$cwid,
				'folderid'=>$folderid,
				'cdisplayorder'=>$scdisplayorder,
				'isfree'=>$sisfree,
				'sid'=>$ssid
			);
		}
		$this->cwids_map = $cwids_map;
		$this->scwids = $scwids;
		$this->_roomcourse_add($roomcourses_params);
	}
	//附件
	private function _attachment_cpy(){
		$scrid = $this->scrid;
		$dcrid = $this->dcrid;
		$uid = $this->uid;
		$sattachments = $this->_getAttachments($scrid);
		if(empty($sattachments)){
			log_message('源附件为空');
			return;
		}
		foreach ($sattachments as $sattachment) {
			unset($sattachment['attid']);
			$sattachment['uid'] = $uid;
			$sattachment['crid'] = $dcrid;
			$wkey = 'w_'.$sattachment['cwid'];
			$sattachment['cwid'] = array_key_exists($wkey, $this->cwids_map)?$this->cwids_map[$wkey]:'';
			if(empty($sattachment)){
				continue;
			}
			$this->db->insert('ebh_attachments',$sattachment);
		}
	}

	//获取班级信息
	private function _getClasses($crid = 0){
		$sql = 'select * from ebh_classes where crid = '.$crid;
		return $this->db->query($sql)->list_array();
	}

	//创建班级
	private function _createClass($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->insert('ebh_classes',$param);
	}
	//教师添加到班级
	private function _classteacher_add($classids = array(),$uid = 0){
		if(empty($classids)){
			log_message('教师添加到班级出错');
			return;
		}
		$sql = 'INSERT INTO ebh_classteachers(uid,classid) VALUES ';
		$valuesArr = array();
		foreach ($classids as $classid) {
			$valuesArr[] = '('.$uid.','.$classid.')';
		}
		$sql .= implode(',', $valuesArr);
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	//获取课程信息
	private function _getFolders($crid = 0){
		$sql = 'select * from ebh_folders where folderlevel = 2 AND crid = '.$crid;
		return $this->db->query($sql)->list_array();
	}
	private function _createFolder($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->insert('ebh_folders',$param);
	}
	//教师关联课程
	private function _folderteacher_add($folderids = array(),$tid = 0,$crid = 0){
		if(empty($folderids)){
			log_message('教师添加到课程出错');
			return;
		}
		$sql = 'INSERT INTO ebh_teacherfolders(crid,tid,folderid) VALUES ';
		$valuesArr = array();
		foreach ($folderids as $folderid) {
			$valuesArr[] = '('.$crid.','.$tid.','.$folderid.')';
		}
		$sql .= implode(',', $valuesArr);
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	//获取作业信息
	private function _getExams($crid = 0){
		$sql = 'select * from ebh_schexams where crid = '.$crid;
		return $this->db->query($sql)->list_array();
	}
	//添加作业
	private function _createExam($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->insert('ebh_schexams',$param);
	}

	//获取课件信息(课件在课程里的,课程如果被删除则课件不复制)
	private function _getCousesWares($crid = 0){
		$sql = 'select rc.folderid,rc.cdisplayorder,rc.isfree,rc.sid,cw.* from ebh_roomcourses rc join ebh_folders f on rc.folderid = f.folderid join ebh_coursewares cw on rc.cwid = cw.cwid where rc.crid = '.$crid . ' and `cw`.`status`=1';
		return $this->db->query($sql)->list_array();
	}
	//添加课件
	private function _createCousesWare($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->insert('ebh_coursewares',$param);
	}
	//课程课件教室关联
	private function _roomcourse_add($params = array()){
		if(empty($params)){
			log_message('课件关联失败');
			return;
		}
		$sql = 'INSERT INTO ebh_roomcourses(crid,cwid,folderid,cdisplayorder,isfree,sid) VALUES ';
		$valuesArr = array();
		foreach ($params as $param) {
			$valuesArr[] = '('.$param['crid'].','.$param['cwid'].','.$param['folderid'].','.$param['cdisplayorder'].','.$param['isfree'].','.$param['sid'].')';
		}
		$sql .= implode(',', $valuesArr);
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	//获取课件附件信息
	private function _getAttachments($crid = 0){
		$scwids = $this->scwids;
		if(empty($scwids)){
			return array();
		}
		$sql = 'select * from ebh_attachments where cwid in ('.implode(',', $scwids).') AND crid = '.$crid;
		return $this->db->query($sql)->list_array();
	}
	//获取Section信息(对应课程存在的)
	private function _getSections($crid = 0){
		$sql = 'select s.* from ebh_sections  s join ebh_folders f on s.folderid = f.folderid where s.crid = '.$crid;
		return $this->db->query($sql)->list_array();
	}

	//升级教室信息
	private function _room_update($exam_num){
		$crid = $this->dcrid;
		if(empty($crid)){
			return;
		}
		//作业数
		/*$sql_exam = 'select count(1) as count from ebh_schexams where crid = '.$crid.' AND status = 1';
		$res = $this->db->query($sql_exam)->row_array();
		$examcount = $res['count'];*/
		$examcount = $exam_num;

		//课件数
		$sql_coursewares = 'select count(1) as count,rc.folderid from ebh_coursewares cw join ebh_roomcourses rc on cw.cwid = rc.cwid where cw.status = 1 AND  rc.crid = '.$crid.' GROUP BY rc.folderid';
		$res = $this->db->query($sql_coursewares)->list_array('folderid');
        $coursenum = 0;
		if (!empty($res)) {
		    foreach ($res as $fid => $citem) {
		        $coursenum += intval($citem['count']);
                //更新课程课件数
                $this->db->update('ebh_folders', array('coursewarenum' => intval($citem['count'])), array(
                    'folderid' => intval($fid),
                    'crid' => $crid
                ));
            }
        }


		$param = array(
			'examcount'=>$examcount,
			'coursenum'=>$coursenum
		);
		$where = array(
			'crid'=>$crid
		);
		$this->db->update('ebh_classrooms',$param,$where);
	}

	//默认添加一个学生
	private function _defaultStudent($crid,$classid){
		if(!empty($crid) && !empty($classid)){
			$username = $this->_createDefaultStudentUsername($crid,true);
			//先添加学生账号
			$member = Ebh::app()->model('member');
			$param['username'] = $username;
			$param['password'] = '123456';
			$param['realname'] = '默认学生';
			$param['dateline'] = SYSTIME;
			$uid = $member->addmember($param);
            $this->new_memeber_id = $uid;
			Ebh::app()->model('credit')->addCreditlog(array('uid'=>$uid,'ruleid'=>1));
			$roomuser = Ebh::app()->model('roomuser');
			$param['crid'] = $crid;
			$param['uid'] = $uid;
			$param['cnname'] = '默认学生';
			$roomuser->insert($param);
			$param['classid'] = $classid;
			$classes = Ebh::app()->model('classes');
			$classes->addclassstudent($param);
			
            //默认学生注册时时记录信息到日志
            if($uid){
                $logdata = array();
                $logdata['uid']=$uid;
                $logdata['crid']=$crid;
                $logdata['logtype'] = 4;
                $registerloglib=Ebh::app()->lib('RegisterLog');
                $registerloglib->addOneRegisterLog($logdata);
            }
			Ebh::app()->lib('xNums')->add('user');
			//更新SNS的学校学生、班级学生缓存
			$snslib = Ebh::app()->lib('Sns');
			$snslib->updateClassUserCache(array('classid'=>$param['classid'],'uid'=>$uid));
			$snslib->updateRoomUserCache(array('crid'=>$param['crid'],'uid'=>$uid));			

			//调用SNS同步接口，类型为4用户网校操作
			$snslib->do_sync($uid, 4);
			return true;
		}
	}
	//生成一个默认的学生账号
	private function _createDefaultStudentUsername($crid,$random = false){
		//根据crid获取域名
		if(!empty($crid)){
			$domain = '';
			$crmodel = Ebh::app()->model('classroom');
			$domain = $crmodel->getdomainByCrid($crid);
			$userModel = Ebh::app()->model('User');
			$username = $domain['domain'].'_student';
			if($random){
				$username = $username.mt_rand(100,999);
			}
			$check = $userModel->exists($username);
			if($check){
				$this->_createDefaultStudentUsername($crid,true);
			}
			return $username;
		}
		
	}


    /**
     * 拷贝服务包、服务包分类、服务项，返回服务项ID映射
     * @param $folder_maps
     * @return array|bool
     */
    private function _cp_pay_service($folder_maps) {
        //return json_decode('{"379":452,"377":453,"378":454,"383":455,"384":456,"376":457,"380":458,"381":459,"382":460,"374":461,"375":462,"405":463,"385":464}', true);
        if (empty($folder_maps)) {
            return false;
        }
        $sql = "SELECT `pid`,`pname`,`summary`,`displayorder`,`itype` FROM `ebh_pay_packages` WHERE `crid`={$this->scrid} AND `status`=1";
        $pay_services = $this->db->query($sql)->list_array('pid');
        if (empty($pay_services)) {
            return array();
        }
        $pid_arr = array_keys($pay_services);
        $pid_arr_str = implode(',', $pid_arr);
        $pid_arr = array_flip($pid_arr);
        $sql = "SELECT `sid`,`pid`,`sname`,`content`,`sdisplayorder`,`showbysort`,`imgurl`,`ishide`,`showaslongblock` 
                FROM `ebh_pay_sorts` WHERE `pid` IN($pid_arr_str)";
        $pay_sorts = $this->db->query($sql)->list_array('sid');
        $sql = "SELECT `itemid`,`pid`,`iname`,`isummary`,`providercrid`,`folderid`,`sid`,`iprice`,`comfee`,`roomfee`,`providerfee`,`imonth`,`iday`,`grade`,`cannotpay`,`longblockimg`,`isyouhui`,`iprice_yh`,`comfee_yh`,`roomfee_yh`,`providerfee_yh`,`itype`,`ptype`,`view_mode`,`defind_course` 
                FROM `ebh_pay_items` WHERE `pid` IN($pid_arr_str) AND `crid`={$this->scrid}";
        $pay_items = $this->db->query($sql)->list_array('itemid');
        $this->db->begin_trans();
        foreach ($pay_services as $pay_service) {
            $service_id = array_shift($pay_service);
            $pay_service['crid'] = $this->dcrid;
            $pay_service['status'] = 1;
            $pay_service['uid'] = $this->uid;
            $pay_service['dateline'] = SYSTIME;
            $pay_service['limitdate'] = 0;
            $pid_arr[$service_id] = $this->db->insert('ebh_pay_packages', $pay_service);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->pid_maps = $pid_arr;
        $sid_arr = array();
        foreach ($pay_sorts as $pay_sort) {
            $sid = array_shift($pay_sort);
            if (empty($pid_arr[$pay_sort['pid']])) {
                continue;
            }
            $pay_sort['pid'] = $pid_arr[$pay_sort['pid']];
            $sid_arr[$sid] = $this->db->insert('ebh_pay_sorts', $pay_sort);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $itemid_arr = array();
        foreach ($pay_items as $pay_item) {
            $itemid = array_shift($pay_item);
            if (empty($pid_arr[$pay_item['pid']])) {
                continue;
            }
            $pay_item['pid'] = $pid_arr[$pay_item['pid']];
            if (isset($sid_arr[$pay_item['sid']])) {
                $pay_item['sid'] = $sid_arr[$pay_item['sid']];
            } else {
                $pay_item['sid'] = 0;
            }
            $pay_item['crid'] = $this->dcrid;
            if (array_key_exists('f_'.$pay_item['folderid'], $folder_maps)) {
                $pay_item['folderid'] = $folder_maps['f_'.$pay_item['folderid']];
            } else {
                continue;
            }
            $pay_item['dateline'] = SYSTIME;
            $itemid_arr[$itemid] = $this->db->insert('ebh_pay_items', $pay_item);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();

        return $itemid_arr;
    }

    //step1:模块配置
    private function _cp_modules_set($room_type) {
        $category = $room_type == 'com' ? 1 : 0;
        $exists = $this->db->query(
            "SELECT `crid` FROM `ebh_component_schools` WHERE `crid`={$this->dcrid} AND `category`=$category")
            ->row_array();
        if (!empty($exists)) {
            return true;
        }
        /*$roominfo = $this->db->query('SELECT `property` FROM `ebh_classrooms` WHERE `crid`='.$this->dcrid)->row_array();
        if (!empty($roominfo) && $roominfo['property'] == 3) {
            //企业版不拷贝模板
            return true;
        }*/
        $items = $this->db->query(
            "SELECT `eid`,`mid`,`ititle`,`columns`,`rows`,`max_rows`,`tx`,`ty`,`width`,`height`,`position_x`,`position_y`,`zindex`,`background_color`
             FROM `ebh_component_items` WHERE `crid`={$this->scrid} AND `status`=0")->list_array('eid');
        if (empty($items)) {
            return false;
        }
        $this->modules = array_column($items, 'mid');
        $this->modules = array_filter($this->modules, function($module) {
            return !in_array($module, array(1,3,6,9,13,18,20));
        });
        $options = $this->db->query(
            "SELECT `eid`,`mid`,`image`,`href`,`zindex`,`label`,`bgcolor` 
              FROM `ebh_component_item_options` WHERE `crid`={$this->scrid} AND `status`=0")->list_array();
        $richtexts = $this->db->query(
            "SELECT `eid`,`richtext` FROM `ebh_component_richtexts` 
              WHERE `crid`={$this->scrid} AND `status`=1")->list_array();
        $this->db->begin_trans();
        $newid = $this->db->insert('ebh_component_schools', array('crid' => $this->dcrid, 'category' => $category));
        if (empty($newid)) {
            $this->db->rollback_trans();
            return false;
        }
        $items_map = array();
        foreach ($items as $item) {
            $item['crid'] = $this->dcrid;
            $item['tmpid'] = $newid;
            $eid = array_shift($item);
            $items_map[$eid] = $this->db->insert('ebh_component_items', $item);
            if (empty($items_map[$eid])) {
                $this->db->rollback_trans();
                return false;
            }
        }
        if (!empty($options)) {
            foreach ($options as $option) {
                if (empty($items_map[$option['eid']])) {
                    continue;
                }
                $option['eid'] = $items_map[$option['eid']];
                $option['crid'] = $this->dcrid;
                $newid = $this->db->insert('ebh_component_item_options', $option);
                if (empty($newid)) {
                    $this->db->rollback_trans();
                    return false;
                }
            }
        }
        if (!empty($richtexts)) {
            foreach ($richtexts as $richtext) {
                if (!isset($items_map[$richtext['eid']])) {
                    continue;
                }
                $richtext['eid'] = $items_map[$richtext['eid']];
                $richtext['crid'] = $this->dcrid;
                $this->db->insert('ebh_component_richtexts', $richtext);
                if ($this->db->trans_status() === false) {
                    $this->db->rollback_trans();
                    return false;
                }
            }
        }
        $this->db->commit_trans();
        return true;
    }
    //step2:选项卡(头部菜单)
    private function _cp_navigation() {
        $sql = "SELECT `navigator` FROM `ebh_classrooms` WHERE `crid`={$this->scrid}";
        $res = $this->db->query($sql)->row_array();
        if (empty($res)) {
            return;
        }
        $navigator = unserialize($res['navigator']);
        if (empty($navigator['navarr'])) {
            return;
        }

        $main_menu_arr = array();
        $sub_menu_arr = array();

        foreach ($navigator['navarr'] as &$menu) {
            if (!preg_match('/^n(\d+)$/', $menu['code'], $match)) {
                continue;
            }
            $main_menu_arr[] = 'n'.$match[1];
            if (empty($menu['subnav']) || !is_array($menu['subnav'])) {
                continue;
            }

            $sub_menu_arr_tmp = array_column($menu['subnav'], 'subcode');
            $sub_menu_arr = array_merge($sub_menu_arr, $sub_menu_arr_tmp);
        }

        $serialize = serialize($navigator);
        $navigator_sql = "UPDATE `ebh_classrooms` SET `navigator`='$serialize' WHERE `crid`={$this->dcrid}";
        if (!empty($main_menu_arr)) {
            $main_menu_arr = array_map(function($m) {
                return "'$m'";
            }, $main_menu_arr);
            $main_menu_arr_str = implode(',', $main_menu_arr);
            unset($main_menu_arr);
            $ebh_custommessages_sql = "INSERT INTO `ebh_custommessages`(`crid`,`index`,`custommessage`) 
                  SELECT {$this->dcrid},`index`,`custommessage` FROM `ebh_custommessages` 
                  WHERE `crid`={$this->scrid} AND `index` IN($main_menu_arr_str)";
        }

        if (!empty($sub_menu_arr)) {
            $sub_menu_arr = array_map(function($m) {
                return "'$m'";
            }, $sub_menu_arr);
            $sub_menu_arr_str = implode(',', $sub_menu_arr);
            unset($sub_menu_arr);
            $news_sql = "INSERT INTO `ebh_news`(`navcode`,`subject`,`message`,`note`,`thumb`,`crid`,`uid`,`viewnum`,`dateline`,`displayorder`) 
                          SELECT `navcode`,`subject`,`message`,`note`,`thumb`,{$this->dcrid},{$this->uid},`viewnum`,`dateline`,`displayorder` 
                          FROM `ebh_news` WHERE `crid`={$this->scrid} AND `navcode` IN($sub_menu_arr_str) AND `status`=1";
        }
        $this->db->begin_trans();
        $this->db->query($navigator_sql);
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return;
        }
        if (!empty($ebh_custommessages_sql)) {
            $this->db->query($ebh_custommessages_sql);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return;
            }
        }
        if (!empty($news_sql)) {
            $this->db->query($news_sql);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return;
            }
        }
        $this->db->commit_trans();
        $this->_clear_cache('navigator', 'data');
        //更新导航成功后刷新导航相关缓存
        updateRoomCache($this->dcrid,'navigator');
    }
    //step3:滚动通知
    private function _cp_notice() {
        $sql = "INSERT INTO `ebh_sendinfo`(`toid`,`type`,`status`,`dateline`,`message`) 
                  SELECT {$this->dcrid},`type`,`status`,{$this->now},`message` 
                  FROM `ebh_sendinfo` WHERE `toid`={$this->scrid} AND `status`=0 AND `type`='announcement'";
        $this->db->query($sql);
        $this->_clear_cache('sendinfo', 'plate-notice');
    }
    //step4:网校简介与热门标签
    private function _cp_about() {
        $summary = $this->db->query(
            "SELECT `summary`,`cface`,`crlabel`,`message`,`craddress`,`crphone`,`kefu`,`kefuqq` FROM `ebh_classrooms` WHERE `crid`={$this->scrid}")->row_array();
        if (empty($summary)) {
            return;
        }
        $this->db->query(
            "UPDATE `ebh_classrooms` SET `summary`={$this->db->escape($summary['summary'])},
              `crlabel`={$this->db->escape($summary['crlabel'])},
              `message`={$this->db->escape($summary['message'])},
              `craddress`={$this->db->escape($summary['craddress'])},
              `crphone`={$this->db->escape($summary['crphone'])},
              `kefu`={$this->db->escape($summary['kefu'])},
              `kefuqq`={$this->db->escape($summary['kefuqq'])}
              WHERE `crid`={$this->dcrid}");
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        $this->_clear_cache('roominfo', $domain, 0);
    }
    //新闻资讯
    private function _cp_news() {
        $sql = "INSERT INTO `ebh_news`(`crid`,`subject`,`note`,`message`,`dateline`,`thumb`,`viewnum`,`navcode`,`displayorder`,`status`)
                SELECT {$this->dcrid},`subject`,`note`,`message`,{$this->now},`thumb`,`viewnum`,'news',`displayorder`,1
                FROM `ebh_news` WHERE `crid`={$this->scrid} AND `navcode`='news' AND `status`=1";
        $this->db->query($sql);
        $this->_clear_cache('news', 'plate-news');
    }
    //调查问卷
    private function _cp_survey() {
        $sql = "SELECT `sid`,`type`,`folderid`,`cwid`,`title`,`content`,`istemplate`,`allowview`,`allowanonymous`,`cid`,`startdate`,`enddate`,`ispublish`
                FROM `ebh_surveys` 
                WHERE `crid`={$this->scrid} AND `isdelete`=0 AND `ispublish`=1";
        $surveys = $this->db->query($sql)->list_array('sid');
        if (empty($surveys)) {
            return;
        }
        $sid_arr = array_keys($surveys);
        $sid_arr_str = implode(',', $sid_arr);
        $sid_arr = array_flip($sid_arr);
        $survey_questions = $this->db->query(
            "SELECT `qid`,`sid`,`type`,`title`,`displayorder` FROM `ebh_surveyquestions` WHERE `sid` IN($sid_arr_str)")
            ->list_array(`qid`);
        $question_id_maps = array_keys($survey_questions);
        $question_id_maps = array_flip($question_id_maps);
        $survey_options = $this->db->query(
            "SELECT `qid`,`sid`,`content`,`displayorder` FROM `ebh_surveyoptions` WHERE `sid` IN($sid_arr_str)")
            ->list_array();
        $this->db->begin_trans();
        foreach ($surveys as $survey) {
            $sid = array_shift($survey);
            $survey['crid'] = $this->dcrid;
            $survey['ispublish'] = 1;
            $survey['uid'] = $this->uid;

            if (!empty($this->folderids_map['f_' . $survey['folderid']])) {
                $survey['folderid'] = $this->folderids_map['f_' . $survey['folderid']];
            } else {
                $survey['folderid'] = 0;
            }

            if (!empty($this->cwids_map['w_' . $survey['cwid']])) {
                $survey['cwid'] = $this->cwids_map['w_' . $survey['cwid']];
            } else {
                $survey['cwid'] = 0;
            }

            if ($survey['enddate'] > 0) {
                $survey['enddate'] = $survey['enddate'] - $survey['startdate'] + $this->now;
            }
            $survey['dateline'] = $this->now;
            $survey['startdate'] = $this->now;
            $sid_arr[$sid] = $this->db->insert('ebh_surveys', $survey);
            if (empty($sid_arr[$sid])) {
                $this->db->rollback_trans();
                return;
            }
        }
        foreach ($survey_questions as $question) {
            $questionid = array_shift($question);
            $sid = array_shift($question);
            $question['sid'] = $sid_arr[$sid];
            $question_id_maps[$questionid] = $this->db->insert('ebh_surveyquestions', $question);
            if (empty($question_id_maps[$questionid])) {
                $this->db->rollback_trans();
                return;
            }
        }
        foreach ($survey_options as $option) {
            $qid = array_shift($option);
            $sid = array_shift($option);
            $option['qid'] = $question_id_maps[$qid];
            $option['sid'] = $sid_arr[$sid];
            $ret = $this->db->insert('ebh_surveyoptions', $option);
            if (empty($ret)) {
                $this->db->rollback_trans();
                return;
            }
        }
        $this->db->commit_trans();
        $this->_clear_cache('survey', 'plate-survey');
    }
    //应用
    private function _cp_app() {
        $sql = "SELECT `appstr` FROM `ebh_custommessages` WHERE `crid`={$this->scrid} AND `index`='1' ORDER BY `cid` DESC LIMIT 1";
        $appstr = $this->db->query($sql)->row_array();
        if (empty($appstr)) {
            return;
        }
        $exits = $this->db->query("SELECT `appstr` FROM `ebh_custommessages` WHERE `crid`={$this->dcrid} AND `index`='1' ORDER BY `cid` DESC LIMIT 1")->row_array();
        if (!empty($exits)) {
            $sql = "UPDATE `ebh_custommessages` SET `appstr`='{$appstr['appstr']}' WHERE `crid`={$this->dcrid} AND `index`='1'";
        } else {
            $sql = "INSERT INTO `ebh_custommessages`(`crid`,`index`,`custommessage`,`appstr`) VALUES({$this->dcrid},'1','','{$appstr['appstr']}')";
        }

        $this->db->query($sql);
        $this->_clear_cache('custommessage', 'plate-app');
    }
    //课程权限
    private function _cp_userpermisions() {
        //为默认学生生成课程权限
        if (!empty($this->new_memeber_id)) {
            $max_enddate = SYSTIME;
            $sql = "SELECT `itemid`,`pid`,`iname`,`folderid`,`imonth`,`iday` FROM `ebh_pay_items` WHERE `crid`={$this->dcrid}";
            $cp_items = $this->db->query($sql)->list_array();
            if (empty($cp_items)) {
                return;
            }
            foreach ($cp_items as $cp_item) {
                $omonth = $cp_item['imonth'];
                if(!empty($omonth)) {
                    $enddate = strtotime("+$omonth month");
                } else {
                    $oday = $cp_item['iday'];
                    $enddate = strtotime("+$oday day");
                }
                $max_enddate = max($max_enddate, $enddate);

                $userpermisions_params = array(
                    'itemid' => $cp_item['itemid'],
                    'type' => 1,
                    'powerid' => 0,
                    'uid' => $this->new_memeber_id,
                    'crid' => $this->dcrid,
                    'classid' => $this->default_class_id,
                    'folderid' => $cp_item['folderid'],
                    'cwid' => 0,
                    'startdate' => SYSTIME,
                    'dateline' => SYSTIME,
                    'enddate' => $enddate
                );
                $this->db->insert('ebh_userpermisions', $userpermisions_params);
            }
            $upparas = array(
                'begindate' => SYSTIME,
                'enddate' => $max_enddate
            );
            $this->db->update('ebh_roomusers', $upparas, "`uid`={$this->new_memeber_id} AND `crid`={$this->dcrid}");
        }
    }
    //拷贝新版作业
    private function _cp_homework() {
        //$this->folderids_map = json_decode('{"f_3950":4377,"f_3957":4378,"f_3958":4379,"f_3959":4380,"f_3960":4381,"f_3961":4382,"f_3962":4383,"f_3963":4384,"f_3964":4385,"f_4275":4386}', true);
        if (empty($this->folderids_map)) {
            return 0;
        }

        //print_r($this->folderids_map);exit;
        $dataserver = EBH::app()->getConfig('dataserver')->load('dataserver');
        $servers = $dataserver['servers'];
        //随机抽取一台服务器
        $target_server = $servers[array_rand($servers,1)];
        defined('__SURL__') or define('__SURL__', $target_server);

        $source = $this->db->query("SELECT `uid` FROM `ebh_classrooms` WHERE `crid`={$this->scrid}")->row_array();
        $uid = $source['uid'];
        $url = "/exam/getlist";
        $param['status'] = 1;
        $param['crid'] = $this->scrid;
        $param['k'] = authcode(json_encode(array('uid'=>$uid, 'crid'=>$this->scrid,'t'=>SYSTIME)),'ENCODE');
        $copyParam['k'] = authcode(json_encode(array('uid'=>$this->uid, 'crid'=>$this->dcrid,'t'=>SYSTIME)),'ENCODE');
        $postRet = $this->do_post($url,$param);

        if (!empty($postRet->pageInfo->totalElement)) {
            $param['size'] = 50;//单次拷贝50条
            for ($page=0; $page < $postRet->pageInfo->number; $page++) { //拷贝开始
                $param['page'] = $page;
                $results = $this->do_post($url,$param);
                if (!empty($results->examList)) {//作业列表
                    $examList = $results->examList;

                    foreach ($examList as $key => $exam) {
                        if ($exam->etype != 'COMMON') {
                            continue;
                        }
                        $exam->uid = $this->uid;
                        $exam->crid = $this->dcrid;
                        unset($exam->eid);
                        $exam->estype = '';

                        $ques = json_decode($exam->data);
                        foreach ($ques->relationSet as $qrkey=>$qrvalue) {//题目知识点先不删
                            if ($qrvalue->ttype == 'FOLDER') {
                                if (!empty($this->folderids_map['f_'.$qrvalue->tid])) {
                                    $qrvalue->tid = $this->folderids_map['f_'.$qrvalue->tid];
                                }

                                break;
                            }
                        }
                        $exam->data = json_encode($ques);
                        $copyParam['exam'] = $exam;
                        //print_r($copyParam);exit;
                        $this->do_post('/exam/save',$copyParam);//这个一份一份作业保存
                    }
                }
            }
        }
        $Res=isset($postRet->pageInfo->totalElement)?($postRet->pageInfo->totalElement):0;
        return intval($Res);
    }
    //清空缓存
    private function _clear_cache($module, $params, $crid = -1) {
        if ($crid == -1) {
            $crid = $this->dcrid;
        }
        $roomcache = Ebh::app()->lib('Roomcache');
        $roomcache->removeCache($crid, $module, $params);
    }

    /*
	 **私有方法，提交数据到java后台返回json数据
	 */
    private function do_post($uri, $data, $check = TRUE){
        $url = 'http://'.__SURL__.$uri;
        $ch = curl_init();
        $datastr = json_encode($data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$datastr);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($datastr))
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret = curl_exec($ch);
        curl_close($ch);
        if($check == TRUE) {
            $ret = json_decode($ret);
            $this->apiResCheck($ret);
            return $ret->datas;
        }else {
            return $ret;
        }
    }
    /*
	 **检查java服务器返回的数据
	 */
    private function apiResCheck($res,$ajax = FALSE){
        if(empty($res)) {
            //$this->echoMsg("服务器取数据失败");exit;
        }
        if($res->errCode != 0) {
            log_message("code:".$res->errCode.'--msg:'.$res->errMsg);
            //$this->echoMsg($res->errMsg);exit;
        }
    }
}