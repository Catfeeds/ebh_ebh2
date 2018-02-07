<?php
/**
 * 新版作业控制器类Examv2Controller
 */
//EBH::app()->helper('examv2');
class Examv2Controller extends ApiControl {
	private $user = NULL;
	private $room = NULL;
	private $k = "";
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo '用户未登陆';
			exit;
		}
		$this->user = $user;
		$this->room = $room = Ebh::app()->room->getcurroom();
		$this->k = authcode(json_encode(array('uid'=>$user['uid'],'crid'=>$room['crid'],'t'=>SYSTIME)),'ENCODE');
		//$this->k1 = authcode(json_encode(array('uid'=>75214,'crid'=>10398,'t'=>SYSTIME)),'ENCODE');
		//print_r($this->k1);
		$this->assign('k',$this->k);
		$this->assign('crid',$room['crid']);
		$this->assign('uid',$user['uid']);
		$this->assign('room',$room);
        
    }

    public function index() {
		//获取modulename
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'exam','tors'=>1,'crid'=>$this->room['crid']));
		$this->display('troomv2/exam2/classexam');
    }
	
	//新版添加作业的方法
	public function add() {
		//检验是否管理员管理员可以添加作业分类
		$power = $this->model('roomteacher')->checkTeacher($this->room['crid'],$this->user['uid']);
		$this->assign('power', $power);
		$domain = $_SERVER['HTTP_HOST'];
		$this->assign('user', $this->user);
		$this->assign('domain', $domain);
		$this->display('troomv2/exam2/teacher/examadd2');
	}

	//通过课件布置作业
	public function addexambycw() {
		//检验是否管理员管理员可以添加作业分类
		$power = $this->model('roomteacher')->checkTeacher($this->room['crid'],$this->user['uid']);
		$this->assign('power', $power);
		$domain = $_SERVER['HTTP_HOST'];
		$cwid = $this->uri->uri_attr(1);
		$folderid = $this->uri->uri_attr(0);
		$cwtitle = urldecode($this->input->get('cwtitle'));
		$this->assign('cwid', $cwid);
		$this->assign('cwtitle', $cwtitle);
		$this->assign('folderid', $folderid);
		$this->assign('user', $this->user);
		$this->assign('domain', $domain);
		$this->display('troomv2/exam2/teacher/examadd2');
	}

	//新版作业删除的方法
	public function del() {
		$param['k'] = $this->k;
		$param['eid'] = intval($this->input->post('eid'));
		$url = "/exam/delete/".$param['eid'];
		if (!empty($param['eid'])) {
			$postRet = $this->do_post($url,$param);
		}
		if (!empty($postRet)) {
			echo 1;//删除成功
			$url = '/exam/detail/foredit/'.$param['eid'];
			$data = $this->do_post($url,$param,FALSE);
			$data = json_decode($data, 1);
			if (!empty($data['datas']['exam']['status'])) {
				$sql = 'update ebh_classrooms set examcount=examcount-1 where crid='.$this->room['crid'];
	       		Ebh::app()->getdb()->query($sql);
			}

            //删除作业操作成功后记录到操作日志
            if ((!empty($data['datas']['exam']['eid'])) && (!empty($data['datas']['exam']['esubject']))) {
                $logdata = array();
                $logdata['toid'] = intval($data['datas']['exam']['eid']);
                $logdata['title'] = h($data['datas']['exam']['esubject']);
                Ebh::app()->lib('OperationLog')->addLog($logdata, 'delexam');
            }
		} else {
			echo 2;
		}

	}

	//获取主观题详情 此接口还需完善
	public function getSubjective() {
		$schcourseware = $this->model('Schcourseware');
		$cwid = intval($this->input->get('cwid'));
		//$aid = intval($this->input->get('aid'));
		$qid = intval($this->input->get('qid'));
		$suid = intval($this->input->get('suid'));
		$result = $schcourseware->getcourselist(array('cwid'=>$cwid));
		if($result){
			$result = $result[0];
			if($result['cwname']){
				list($name,$suffix) = explode('.',$result['cwname']);
				$remark = '';
				$voices = '';
				$notes = NULL;
				$images = NULL;
				if($qid){
					$notes = $schcourseware->getcoursenote(array('cwid'=>$cwid,'qid'=>$qid,'uid'=>$suid));
					if($notes){
						if(!empty($notes['remark']))
							$remark = $notes['remark'];
						if(!empty($notes['images']))
							$images = $notes['images'];
						if(!empty($notes['voices']))
							$voices = $notes['voices'];
					}
				}
				$type = $result['type'];

				//获取主观题缩略图需要秘钥
				$clientip = $this->input->getip();
				$skey = $cwid.'\t'.$clientip;
				if (!empty($notes['qid']))
					$skey .= '\t'.$notes['qid'];
				$key = authcode($skey, 'ENCODE');

				$result = array('suffix'=>strtolower($suffix),'remark'=>$remark,'images'=>$images,'voices'=>$voices,'note'=>$notes,'type'=>$type,'key'=>$key);
			}
		}
		$status = empty ( $result ) ? array('result'=>0) : $result;
		echo json_encode ( $status );
	}

	//智能添加作业的方法preview
	public function addsmart() {
		$power = $this->model('roomteacher')->checkTeacher($this->room['crid'],$this->user['uid']);
		$this->assign('power', $power);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/addsmart');
	}

	//智能作业作业预览，同时生成一份智能作业题目
	public function getSmartAjax() {
		$eid = $this->input->post('eid');
		$url = "/exam/simpleinfo/".$eid;
		$postRet = $this->do_post($url,array('k'=>$this->k));
		if (empty($postRet->info)) {
			$this->renderJson("2000","作业不存在");
		}
		$etype = $postRet->info->etype;

		$param = array(
			'k'=>$this->k
		);
		if ($etype == 'TSMART') {
			$param['uid'] = $postRet->info->uid;
			$param['forexam'] = 'teacher';//学生生成一份相同的智能作业
			$url = '/exam/getsmart/'.$eid;
		} else {
			$this->renderJson("0","etype err",'1');
		}
		
		$postRet = $this->do_post($url,$param);
		$exam = $postRet->exam;
		$questionList = $postRet->questionList;
		foreach ($postRet->questionList as $question) {
			foreach ($question->blanks as $blank) {
				unset($blank->isanswer);
				unset($blank->score);
			}
			
			if ($question->question->quetype == 'H') {//主观题
				$extdata = json_decode($question->question->extdata);
				$question->question->schcwid = $extdata->schcwid;
			}
		}
		$datas = array(
			'exam'=>$exam,
			'questionList'=>$questionList
		);
		if (!empty($postRet->userAnswer)) {
			$postRet->userAnswer->data = json_decode($postRet->userAnswer->data);
			$datas['userAnswer'] = $postRet->userAnswer;
		}
		$this->renderJson("0","",$datas);
	}

	//预览普通作业
	public function preview() {
		$cachekey = $this->input->get('res');
		$this->assign('user', $this->user);
		$this->assign('cachekey', $cachekey);
		$this->display('troomv2/exam2/teacher/preview');
	}

	//预览课件的作业
	public function courseExam_view() {
		$eid = $this->uri->itemid;
		$this->assign('eid',$eid);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/jobview');
	}

	//编辑时,预览智能作业
	public function previewsmart() {
		$this->assign('user', $this->user);
		$eid = intval($this->input->get('eid'));
		$this->assign('eid', $eid);
		$this->display('troomv2/exam2/teacher/previewsmart');
	}

	/**
	*教师作业布置作业页面作业列表
	*/
	public function elist() {
		$this->display('troomv2/exam2/teacher/examlist');
	}

	public function elistAjax() {
		$param = parsequery();
		$param['k'] = $this->k;
		$etype = $this->input->post('etype');
		$estype = $this->input->post('estype');
		$folderid = intval($this->input->post('folderid'));
        $action = $this->input->post('action');
		$cwid = intval($this->input->post('cwid'));
		if ($folderid) {
			$param['ttype'] = 'FOLDER';
			$param['tid'] = $folderid;
		}
		$uid = $this->user['uid'];
		if ($cwid) {
			$recuid = intval($this->input->post('recuid'));
			if ($recuid) {//获取其他老师的作业
				$uid = $recuid;
                $room = Ebh::app()->room->getcurroom();
				$param['k'] = authcode(json_encode(array('uid'=>$recuid,'crid'=>$room['crid'],'t'=>SYSTIME)),'ENCODE');
			}
			if(!empty($action)  && $action == 1){
                $param['action'] = 1;
            }

			$param['size'] = 100;
			$param['ttype'] = 'COURSE';
			$param['tid'] = $cwid;
		}
		/*$estypeMap = array('CLASSWORK','HOMEWORK','EXAMINATION');
		if (in_array($estype, $estypeMap)) {//作业类型过滤
			$param['estype'] = $estype;
		}*/
		if ($estype)
			$param['estype'] = $estype;
		if (!empty($etype)) {
			$param['etype'] = $etype;
		}
		$status = $this->input->post('status');
		if (is_numeric($status)) {
			$param['status'] = $status;
		}

		//$action = $this->input->post('action');
		$param['q'] = $this->input->post('q');
		$param['order'] = 'eid desc';

		$url = "/exam/telist";
		//print_r($param);exit;
		$postRet = $this->do_post($url,$param);
		//print_r($postRet);exit;
		//作业列表
		$examList = $postRet->examList;
		$estypeIds = '';
		$classid = array();
		if (!empty($examList)) {
			foreach ($examList as $key => $exam) {
				if ($exam->etype == 'SSMART') {
					unset($examList[$key]);
					continue;
				}
				//$exam->uid = $uid;
				if ($exam->estype)
					$estypeIds .= intval($exam->estype).',';
				$exam->sesubject = shortstr($exam->esubject,50,'...');//截取标题
				$exam->datelineStr = timetostr($exam->dateline);
				if (!empty($exam->relationSet)) {//'FOLDER','COURSE','CHAPTER'
					foreach ($exam->relationSet as $rvalue) {
						if ($rvalue->ttype == 'FOLDER') {
							$folderids[] = $rvalue->tid;
						} else if($rvalue->ttype == 'CLASS') {
							$classid[] = $rvalue->classid;
							$classArr[$key][] = $rvalue->classid;
						}
					}
				}
			}
		} else {
			$this->renderJson('133','作业不存在');
		}
		$ids = implode(',', array_unique($folderids));
		if (!empty($classid)) {
			$classidStr = implode(',', array_unique($classid));
		}
		$userpermission = $this->model('Userpermission');

		//获得个作业对应的分类名称
		if (!empty($estypeIds)) {
			$estypeList = $this->model('schestype')->getEstypeByIds(substr($estypeIds, 0, -1));//类型名字
			if ($estypeList) {
				foreach ($estypeList as $value) {
					$estypeNames[$value['id']] = $value;
				}
			}
		}

		//获取各个班级对应的开通对应的folderid的人数
		if (!empty($classidStr)) {
			$classFolderCount = $userpermission->getUserCountByFolderAndClass($ids,$classidStr);
			if ($classFolderCount) {
				foreach ($classFolderCount as $value) {
					$classExamCountArr[$value['folderid'].'_'.$value['classid']] = $value['count'];
				}
			}
		}
		//获得各个folderid对应的人数
		$total = $userpermission->getUserCountByFolder($ids);
		if (!empty($estypeNames)) {
			foreach ($examList as $examkey => $exam) {//把数量的分配到对应的作业
				if (isset($estypeNames[$exam->estype])) {
					$exam->estype = $estypeNames[$exam->estype]['estype'];//作业类型名字赋值
				}
				if (isset($classArr[$examkey])) {//关联班级后的总数
					foreach ($classArr[$examkey] as $key => $class) {
						if (isset($exam->count)) {
							if (isset($classExamCountArr[$folderids[$examkey].'_'.$class]))
								$exam->count += $classExamCountArr[$folderids[$examkey].'_'.$class];
						} else {
						 	if (isset($classExamCountArr[$folderids[$examkey].'_'.$class])) {
								$exam->count = $classExamCountArr[$folderids[$examkey].'_'.$class];
						 	} else {
						 		$exam->count = 0;
						 	}
						}
					}
				} else if(empty($exam->stucount)){//没有关联班级的总数
					foreach ($total as $value) {
						if ($value['folderid'] == $folderids[$examkey]) {
							$exam->count = $value['count'];
							break;
						}
					}
				} else {
					$exam->count = $exam->stucount;
				}
			}
		} else {
			foreach ($examList as $examkey => $exam) {//把数量的分配到对应的作业
				if (isset($classArr[$examkey])) {//关联班级后的总数
					foreach ($classArr[$examkey] as $key => $class) {
						if (isset($exam->count)) {
							if (isset($classExamCountArr[$folderids[$examkey].'_'.$class]))
								$exam->count += $classExamCountArr[$folderids[$examkey].'_'.$class];
						} else {
						 	if (isset($classExamCountArr[$folderids[$examkey].'_'.$class])) {
								$exam->count = $classExamCountArr[$folderids[$examkey].'_'.$class];
						 	} else {
						 		$exam->count = 0;
						 	}
						}
					}
				} else if(empty($exam->stucount)){//没有关联班级的总数
					foreach ($total as $value) {
						if ($value['folderid'] == $folderids[$examkey]) {
							$exam->count = $value['count'];
							break;
						}
					}
				} else {
					$exam->count = $exam->stucount;
				}
			}
		}
		
		//计算人数结束

		//分页
		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);

		$datas = array(
			'examList'=>array_values($examList),
			'pagestr'=>$pagestr
		);
		$this->renderJson('0','',$datas);
	}

	/**
	 *获取历史作业接口
	 */
	public function getHistroyExam() {
		$param = parsequery();
		$param['k'] = $this->k;
		$uid = $this->user['uid'];
		$etype = $this->input->post('etype');

		if (!empty($etype) && in_array($etype, array('COMMON','TSMART'))) {
			$param['etype'] = $etype;
		}
		$param['q'] = $this->input->post('q');
		$param['order'] = 'eid desc';

		$url = "/exam/telist";
		$postRet = $this->do_post($url,$param);
		//作业列表
		$estypeIds = '';
		$examList = $postRet->examList;
		if (!empty($examList)) {
			foreach ($examList as $key => $exam) {
				if ($exam->etype == 'SSMART') {
					unset($examList[$key]);
					continue;
				}
				$exam->uid = $uid;
				$exam->sesubject = shortstr($exam->esubject,50,'...');//截取标题
				$exam->datelineStr = timetostr($exam->dateline);
			}
		} else {
			$this->renderJson('133','作业不存在');
		}

		//分页
		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);

		$datas = array(
			'examList'=>array_values($examList),
			'pagestr'=>$pagestr
		);
		$this->renderJson('0','',$datas);
	}

	/*
	 *按要求拷贝作业,被动主动，这里是拷贝别人
	 */
	/*public function copyElistAjax() {
		//拷贝参数
		$copyParam['k'] = $this->k;
		$copyParam['crid'] = $this->room['crid'];
		$crid = intval($this->input->post('crid'));//被拷贝的学校
		$folderid = intval($this->input->post('folderid'));;
		if (!$folderid)
			$this->renderJson('0','','no folderid');

		//原来数据获取参数
		$param = parsequery();
		$param['k'] = authcode(json_encode(array('uid'=>$this->user['uid'],'crid'=>$crid,'t'=>SYSTIME)),'ENCODE');
		$param['crid'] = $crid;
		$param['status'] = 1;

		$url = "/exam/getlist";
		$postRet = $this->do_post($url,$param);
		//print_r($postRet);exit;
		//作业列表,循环拷贝
		if (!empty($postRet->pageInfo->totalElement)) {
			$param['size'] = 50;//单次拷贝50条
			for ($page=0; $page <= $postRet->pageInfo->number; $page++) { //拷贝开始
				$param['page'] = $page;
				$results = $this->do_post($url,$param);
				if (!empty($results->examList)) {//作业列表
					$examList = $results->examList;
					foreach ($examList as $key => $exam) {
						if ($exam->etype != 'COMMON') {
							continue;
						}
						$exam->uid = $this->user['uid'];
						$exam->crid = $this->room['crid'];
						unset($exam->eid); 
						$exam->estype = '';
						$ques = json_decode($exam->data);
						foreach ($ques->relationSet as $qrkey=>$qrvalue) {//作业知识点先不删
							if ($qrvalue->ttype == 'FOLDER') {
								$qrvalue->tid = $folderid;
								//$qrvalue->relationname = $relationname;
								break;
							}
						}
						$exam->data = json_encode($ques);
						$copyParam['exam'] = $exam;
						$this->do_post('/exam/save',$copyParam);//这个一份一份作业保存
					}
				}
			}
		} else {
			$this->renderJson('0','','no datas');
		}
		$this->renderJson('1','','ok');
	}*/


	/**
	 *编辑作业页面(手动组装作业)
	 */
	public function edit_view(){
		$domain = $_SERVER['HTTP_HOST'];
		$eid = $this->uri->itemid;
		if(empty($eid)) {
			echoMsg("eid为空");
		}
		$power = $this->model('roomteacher')->checkTeacher($this->room['crid'],$this->user['uid']);
		$this->assign('power', $power);
		$this->assign('eid',$eid);
		$this->assign('domain', $domain);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/examedit2');
	}

	/**
	 *编辑智能作业页面(手动组装作业)
	 */
	public function editSamrt_view(){
		$eid = $this->uri->itemid;
		if(empty($eid)) {
			echoMsg("eid为空");
		}
		$power = $this->model('roomteacher')->checkTeacher($this->room['crid'],$this->user['uid']);
		$this->assign('power', $power);
		$this->assign('eid',$eid);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/smartexamedit');
	}

	/**
	 *请求作业分析,错题统计的头部数据
	 */
	public function getExamSummaryAjax(){
		$eid = $this->input->post('eid');
		$k = $this->input->post('k');
		$param = array(
			'k'=>$k,
			'eid'=>$eid
		);
		$url = '/exam/efenxi/summary';

		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classidArr && $classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$param['uids'][] = $uid['uid'];
				}
			}
			$param['classidList'] = $classidArr;
		}

		$res = $this->do_post($url,$param,FALSE);
		$datas = json_decode($res, 1);
		if (!empty($datas['errCode']) OR !$datas)
			exit(0);
		$folderid = $datas['datas']['efenxisummary']['tid'];
		$datas['datas']['efenxisummary']['dateline'] = timetostr($datas['datas']['efenxisummary']['dateline']);
		if (empty($datas['datas']['efenxisummary']['dateline'])) {
			$datas['datas']['efenxisummary']['dateline'] = '刚刚';
		}

		//关联学生的总人数修改
		if (!empty($datas['datas']['efenxisummary']['stucount'])) {
			$datas['datas']['alluserscount'] = $datas['datas']['efenxisummary']['stucount'];
		} else {
			if ($classidArr && $classid) {//关联班级的总人数
				if (empty($param['uids'])) {
					$alluserscount[0]['count'] = 0;
					$datas['datas']['efenxisummary']['submitcount'] = 0;
					$datas['datas']['efenxisummary']['avgusedtime'] = 0;
				} else {
					$alluserscount = $this->model('userpermission')->getUserCountByFolder($folderid,$classidArr);//总人数
				}
			} else {
				$alluserscount = $this->model('userpermission')->getUserCountByFolder($folderid);
			}
			$datas['datas']['alluserscount'] = empty($alluserscount[0]['count']) ? 0 : $alluserscount[0]['count'];
		}
		echo json_encode($datas);
	}

	/**
	 *请求服务器接口获取作业信息(教师修改)
	 */
	public function getExamAjax(){//此接口可以修改
		$eid = $this->input->post('eid');
		$k = $this->input->post('k');

		$param = array(
			'k'=>$k,
			'eid'=>$eid
		);

		$url = '/exam/detail/foredit/'.$eid;
		$data = $this->do_post($url,$param,FALSE);
		$data = json_decode($data, 1);
		$data['datas']['examdata'] = json_decode($data['datas']['examdata'], 1);
		$exam = $data['datas']['exam'];
		$uidstr = '';
		//构建作业关联学生uid和教师uid的信息
		if (!empty($data['datas']['examTeacherList'])) {
			foreach ($data['datas']['examTeacherList'] as $teach) {
				$uidstr .= $teach.',';
			}

			
		}
		if (!empty($data['datas']['examUserList'])) {
			foreach ($data['datas']['examUserList'] as $user) {
				$uidstr .= $user.',';
			}
		}
		if ($uidstr!= '') {
			$userlist = $this->model('User')->getUserInfoByUid(substr($uidstr, 0,-1));
			if (!empty($userlist)) {
				foreach ($userlist as $userinfo) {
					$user_map[$userinfo['uid']] = $userinfo;
				}
				//教师信息
				if (!empty($data['datas']['examTeacherList'])) {
					foreach ($data['datas']['examTeacherList'] as $teach) {
						if (isset($user_map[$teach])) {
							$exam['tuids'][] = $user_map[$teach];
						}
					}

					
				}
				//学生信息构建
				if (!empty($data['datas']['examUserList'])) {
					foreach ($data['datas']['examUserList'] as $user) {
						if (isset($user_map[$user])) {
							$exam['uids'][] = $user_map[$user];
						}
					}
				}
			}
		}
		if (empty($exam))
			exit('作业不存在');
		if (!empty($data['datas']['examdata']['questionList']))
			$exam['ques'] = $data['datas']['examdata']['questionList'];//默认为普通作业

		if ($data['errCode'] == 0) {
			$exam['answercount'] = 0;//已答题人数
			$exam['subcount'] = 0;//主观题数目
			$exam['targeteid'] = 0;//目标考试id
			$exam['classid'] = 0;//班级
			$exam['grade'] = 0;//年级
			$exam['html'] = '';//模板
			$exam['district'] = 0;//校区
			$exam['cwsourse'] = '';
			$exam['cwtitle'] = NULL;
			$exam['cwurl'] = '';
			$exam['eclass'] = array();//班级
			$exam['title'] = $exam['esubject'];//标题
			unset($exam['esubject']);
			if ($exam['etype'] == 'COMMON') {
				$exam['quescount'] = count($exam['ques']);//试题数目
				$exam['type'] = 0;//种类
			} else {
				$exam['type'] = 2;
			}
			unset($exam['etype']);
			$exam['score'] = $exam['examtotalscore'];//分数
			$exam['dateline'] = date("Y-m-d h:i", $exam['dateline']);
			unset($exam['examtotalscore']);

			//构造folderid,cwid,chapterid
			foreach ($data['datas']['examdata']['relationSet'] as $key => $value) {
				if ($value['ttype'] == "FOLDER") {
					$exam['folderid'] = $value['tid'];//关联的课程
				} elseif ($value['ttype'] == "COURSE") {
					$exam['cwid'] = $value['tid'];//关联课件
					$exam['cwtitle'] = $value['relationname'];//课件名
				} elseif ($value['ttype'] == "CHAPTER") {
					$exam['chapterid'] = $value['tid'];//关联的知识点，这里有多个知识点，待整合
				} elseif ($value['ttype'] == "CLASS") {
					$exam['eclass'][] = $value;
				}
			}

			//构造ques,如果是随机作业，不存在ques
			$seq = 1;
			if (empty($exam['ques'])) {
				//构建智能作业
				$exam['ques'] = $data['datas']['examdata']['conditionList'];
				foreach ($exam['ques'] as &$value) {
					$value['chapterid'] = $value['tid'];
					$value['dif'] = $value['level'];
					$value['quenum'] = $value['quecount'];
					$value['score'] = $value['quescore'];
					$value['selhtml'] = '';
					/*unset($value['tid']);
					unset($value['level']);
					unset($value['quecount']);
					unset($value['quescore']);
					unset($value['path']);
					unset($value['ttype']);*/
				}
			} else {//构建普通作业试题
				
				//构建作业关联的知识点
				if (!empty($data['datas']['relationSet'])) {
					foreach ($data['datas']['relationSet'] as $evalue) {
						if ($evalue['ttype'] == 'CHAPTER') {
							$evalue['relationname'] = str_replace(',', '>', $evalue['relationname']);
							unset($evalue['remark']);
							unset($evalue['extdata']);
							$exam['echapter'][] = $evalue;
						}
					}
				}
				
				foreach ($exam['ques'] as $key => $value) {
					$ques[$key]['chapters'] = '';
					$value['data'] = json_decode($value['data'],TRUE);
					$value['extdata'] = json_decode($value['extdata'],TRUE);
					$ques[$key]['chapterid'] = 0;
					foreach ($value['data']['relationSet'] as $rvalue) {
						if ($rvalue['ttype'] == 'COURSE') {
							$ques[$key]['ccwid'] = $rvalue['tid'];
						} elseif ($rvalue['ttype'] == 'CHAPTER') {
							$ques[$key]['chapters'] .= $rvalue['tid'].',';
							$chaptertid[$key]['tid'][] = $rvalue['tid'];//构建后面selhtml的tid用
							$chaptertid[$key]['path'][] = $rvalue['path'];//构建后面selhtml的path用
						} else {
							$ques[$key]['folderid'] = $rvalue['tid'];
						}
					}
					$ques[$key] = $value['extdata'];//总体赋值
					$ques[$key]['subject'] = $value['qsubject'];
					$ques[$key]['questionid'] = empty($value['qid']) ? '' : $value['qid'];
					$ques[$key]['type'] = $value['queType'];
					$ques[$key]['score'] = $value['quescore'];
					$ques[$key]['dif'] = $value['level'];//难度
					$ques[$key]['resolve'] = empty($value['extdata']['jx']) ? '' : $value['extdata']['jx'];
					$ques[$key]['dianpin'] = empty($value['extdata']['dp']) ? '' : $value['extdata']['dp'];
					if ($ques[$key]['type'] == 'C') {//兼容填空题的总分
						if (!empty($ques[$key]['options'])) {
							$ques[$key]['score'] = $value['quescore']/count($ques[$key]['options']);
						} else {
							$ques[$key]['score'] = $value['quescore'];
						}
					} else {
						$ques[$key]['score'] = $value['quescore'];
					}
					unset($ques[$key]['dp']);
					unset($ques[$key]['jx']);
					unset($ques[$key]['qid']);
					$ques[$key]['folderid'] = $exam['folderid'];//关联的课程
					
					//构造selhtml
					//<li data="387"><span>人教版 &gt; 知识点304aaa &gt; 知识点815<a style="padding-left: 20px;" href="javascript:delselectedchapter(387,'treeDemo_2')">删除</a></span></li>
					//第一个li加个first控制样式
					if (!empty($ques[$key]['chapters'])) {
						$i = 1;
						$ques[$key]['selhtml'] = '';

						$text =  substr($value['extdata']['chapterstxt'], 4, -5);
						$text = str_replace('&gt;', '>', $text);
						$tempArr = explode('</li><li>', $text);//临时存的数组
						foreach ($tempArr as $tkey => $tvalue) {
							$liclass = $i == 1 ? "class='first'" : "";
							$ques[$key]['selhtml'] .= '<li '.$liclass.' data="'.$chaptertid[$key]['tid'][$tkey] .'">'.$tvalue;
							$ques[$key]['selhtml'] .= '<a chapterpath="'.$chaptertid[$key]['path'][$tkey] .'" style="padding-left: 20px;" href="javascript:delqueselectedchapter('.$seq.",".$chaptertid[$key]['tid'][$tkey].")\">删除</a></li>";
						}
					} else {
						$ques[$key]['selhtml'] = '';
					}
					$seq++;
				}
				$exam['ques'] = $ques;
			}
			echo json_encode($exam);
		} else {
			echo "出错啦";
		}
		
	}

	/**
	 *请求服务器接口获取作业信息
	 */
	public function getExamForShowAjax(){
		$eid = $this->input->post('eid');
		$param = array(
			'forcorrect'=>1,
			'k'=>$this->k,
			'eid'=>$eid
		);
		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$param['uids'][] = $uid['uid'];
				}
			}
		}

		$url = '/exam/detail/forshow/'.$eid;
		$postRet = $this->do_post($url,$param,FALSE);
		//print_r($postRet);exit;
		$res = json_decode($postRet,1);
		if (empty($res['datas']['questionList']))
			exit(0);

		//构建批改进度
		foreach ($res['datas']['correctrat'] as $value) {
			$correctrat[$value['qid']] = $value;
		}
		$queMap = array('A','B','D','G','Z');//不批改的试题
		$i = 0;
		foreach ($res['datas']['questionList'] as $key => $value) {
			if (isX($value['question']['quetype'])) {
				$xQues = json_decode($value['question']['extdata'],1);
				if ($this->checkCorrect($xQues)) { //是否要批阅
					$quesinfo[$i] = $value['question'];
				} else {
					continue;
				}
			}
			if (in_array($value['question']['quetype'], $queMap)) {
				continue;
			}
			$quesinfo[$i] = $value['question'];//构建试题信息
			$quesinfo[$i]['correctrat'] = $correctrat[$value['question']['qid']];
			$i++;
		}
		
		//构建试题列表
		$score = 0;
		if (empty($quesinfo)) {
			exit(0);
		}
		$ques = $this->rankQue($quesinfo, $score, 1);
		echo json_encode($ques);
	}

	/*
	 **计算当天已布置作业的数量
	 */
	public function getEaxmCount(){
		$k = $this->input->post('k');
		$param = array(
			'k'=>$k,
			'crid'
		);
		$url = '/exam/texamcount/';
		$res = json_decode($this->do_post($url,$param,FALSE),1);
		$res['return']['examscount'] = empty($res['datas']['count']) ? 0 : $res['datas']['count'];
		$res['return']['courseWareName'] = NULL;
		echo json_encode($res['return']);
	}

	/**
	 *向服务器接口提交数据,保存作业
	 */
	public function addExamAjax(){
		$exam = $this->input->post('exam',FALSE);
		//答案显示和答题时间
		$exam['ansstarttime'] = ! strtotime($exam['ansstarttime']) ? 0 : strtotime($exam['ansstarttime']);
		$exam['examendtime'] = ! strtotime($exam['examendtime']) ? 0 : strtotime($exam['examendtime']);
		$exam['examstarttime'] = ! strtotime($exam['examstarttime']) ? 0 : strtotime($exam['examstarttime']);

		//时间段过滤
		if ($exam['examendtime'] OR $exam['examstarttime']) {
			if ($exam['examendtime'] <= time() && $exam['examstarttime'] > 0)
				$this->renderJson('123','作业结束时间设置出错');
			if ( ! $exam['examstarttime'])
				$this->renderJson('124','作业开始时间未设置');
		}

		$k = $this->input->post('k');
		$uids = $this->input->post('uids');
		$tuids = $this->input->post('tuids');
		$callurl = $this->input->post('callurl');
		$orgparam = $this->input->post('orgparam');
		$param = array(
			'k'=>$k,
			'uids'=>$uids,
			'tuids'=>$tuids,
			'exam'=>$exam,
			'callurl'=>$callurl,
			'orgparam'=>$orgparam
		);
		$url = '/exam/save';
		$res = $this->do_post($url,$param,FALSE);
		$checkRes = json_decode($res,true);
		if ($checkRes['errCode'] == 0 && $exam['status'] == 1) {
			$sql = 'update ebh_classrooms set examcount=examcount+1 where crid='.$this->room['crid'];
       		Ebh::app()->getdb()->query($sql);
		}
		echo $res;
        //发布作业操作成功后记录到操作日志
        if (($checkRes['errCode'] == 0) && (!empty($checkRes['datas']['exam']['eid'])) && (!empty($checkRes['datas']['exam']['esubject']))) {
            $logdata = array();
            $logdata['toid'] = intval($checkRes['datas']['exam']['eid']);
            $logdata['title'] = h($checkRes['datas']['exam']['esubject']);
            Ebh::app()->lib('OperationLog')->addLog($logdata,'addexam');
        }
	}

	/**
	 *作业布置完成之后，微调作业(不影响作业结构的前提，只能修改标量)
	 * ansstarttime  ansendtime examstarttime examendtime canpusherror canreexam limittime stucancorrect esubject
	 */ 
	public function oedite() {
		$postDatas = $this->input->post('',FALSE);
		$post = $postDatas['exam'];
		$eid = $post['eid'];
		if (!is_numeric($eid) || $eid < 0) {
			$this->renderJson('1201','eid不符合要求');
		}

		$param = array();
		$param['k'] = $this->k;

		$uids = $this->input->post('uids');
		if (!empty($uids)) {
			$param['uids'] = $uids;
		}
		$tuids = $this->input->post('tuids');
		if (!empty($tuids)) {
			$param['tuids'] = $tuids;
		}
		
		$ansstarttime = $post['ansstarttime'];
		if (isset($ansstarttime)) {
			$param['ansstarttime'] = strtotime($ansstarttime) ? strtotime($ansstarttime) : 0;
		}

		$examstarttime = $post['examstarttime'];
		if (isset($examstarttime)) {
			$param['examstarttime'] = strtotime($examstarttime) ? strtotime($examstarttime) : 0;
		}

		$examendtime = $post['examendtime'];
		if (isset($examendtime)) {
			$param['examendtime'] = strtotime($examendtime) ? strtotime($examendtime) : 0;
		}

		//时间段过滤
		if ($examendtime OR $examstarttime) {
			if ($param['examendtime'] <= time() && $param['examstarttime'] > 0)
				$this->renderJson('123','作业结束时间设置出错');
			if ( ! $param['examstarttime'])
				$this->renderJson('124','作业开始时间未设置');
		}

		$canpusherror = $post['canpusherror'];
		if (is_numeric($canpusherror)) {
			$param['canpusherror'] = $canpusherror;
		}

		$estype = $post['estype'];
		if ($estype) {
			$param['estype'] = $estype;
		} else {
			$param['estype'] = '';
		}

		$canreexam = $post['canreexam'];
		if (is_numeric($canreexam)) {
			$param['canreexam'] = $canreexam;
		}

		$isclass = $post['isclass'];
		if (is_numeric($isclass)) {
			$param['isclass'] = $isclass;
		}

		$limittime = $post['limittime'];
		if (is_numeric($limittime)) {
			$param['limittime'] = $limittime;
		}

		if (isset($post['showtype'])) {
			$param['showtype'] = intval($post['showtype']);
		}

		$stucancorrect = $post['stucancorrect'];
		if (is_numeric($stucancorrect)) {
			$param['stucancorrect'] = $stucancorrect;
		}

		$esubject = $post['esubject'];
		if (!empty($esubject)) {
			$param['esubject'] = $esubject;
		}

		$data = $post['data'];
		if (!empty($esubject)) {
			$param['data'] = $data;
		}
		$url = '/exam/oedite/'.$eid;
		//print_r($param);exit;
        $res = $this->do_post($url,$param,false);
		echo $res;
        //发布作业操作成功后记录到操作日志
        if(!empty($res)){
            $checkRes = json_decode($res,true);
            if (isset($checkRes['errCode']) && ($checkRes['errCode'] == 0)) {
                $logdata = array();
                $logdata['toid'] = intval($eid);
                $logdata['title'] = h($param['esubject']);
                Ebh::app()->lib('OperationLog')->addLog($logdata,'editexam');
            }
        }
	}

	/**
	 *作业布置完成之后，微调试题(不影响作业结构的前提，只能修改标量)
	 * qsubject level extdata
	 */ 
	public function oeditq() {
		$qid = $this->input->post('qid');
		if (!is_numeric($qid) || $qid < 0) {
			$this->renderJson('120','qid不符合要求');
		}

		$param = array(
			'k'=>$this->k
		);

		$level = $this->input->post('level');
		if (is_numeric($level)) {
			$param['level'] = $level;
		}

		$qsubject = $this->input->post('qsubject');
		if (!empty($qsubject)) {
			$param['qsubject'] = $qsubject;
		}

		$extdata = $this->input->post('extdata');
		if (!empty($extdata)) {
			$param['extdata'] = $extdata;
		}

		$url = '/question/oeditq/'.$qid;
		echo $this->do_post($url,$param,false);
	}

	/**
	 *判断是否能生成智能作业
	 */
	public function canSmart() {
		$conditionList = $this->input->post('conditionList');
		$crid = $this->input->post('crid');
		$k = $this->input->post('k');
		if (empty($conditionList) || empty($crid)) {
			echo '参数不全';exit;
		}
		$param = array(
			'k'=>$k,
			'crid'=>$crid,
			'conditionList'=>$conditionList
		);
		$url = '/exam/cansmart/';
		$res = $this->do_post($url,$param,TRUE);
		if ($res->cansmart) {
			$return['isok'] = TRUE;
			echo json_encode($return);exit;
		}
		$return['isok'] = FALSE;
		echo json_encode($return);
	}

	/*
	 * 从智能作业少题目的情况下布置作业
	 */
	public function checkExam() {
		$questions = $this->input->post('questions');
		$smartexam = $this->input->post('exam',FALSE);
		$examrelation = $this->input->post('examrelation');
		$conditionList = $this->input->post('conditionList',FALSE);
		$param = array(
			'k'=>$this->k,
			'examrelation'=>$examrelation,
			'questions'=>$questions,
			'exam'=>$smartexam,
			'conditionList'=>$conditionList
		);
		$url = '/exam/checkexam/';
		echo $this->do_post($url,$param,FALSE);
	}


	/**
	 *批改作业页面
	 */
	public function forcorrect_view() {
		$eid = $this->uri->itemid;
		$this->assign('eid',$eid);
		$this->display('troomv2/exam2/teacher/exam_forcorrect');
	}

	//批改单条试题
	public function correctq_view() {
		$qid = $this->uri->itemid;
		$this->assign('qid',$qid);
		$this->display('troomv2/exam2/teacher/answer_forcorrect');
	}

	//获取指定试题下所有的答题记录
	public function getQuesAnswersAjax() {
		$param['page'] = intval($this->input->post('page'));
		$param['size'] = 1;
		$qid = $this->input->post('qid');
		if(!is_numeric($qid) || $qid < 0) {
			$this->renderJson('没有检测到合法的试题qid');
		}
		$param['k'] = $this->k;
		$param['qid'] = $qid;

		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$param['uids'][] = $uid['uid'];
				}
			}
		}
		//$param['status'] = 0;
		$url = '/question/aqd/'.$qid;
		//返回单题答题信息
		$postRet = $this->do_post($url,$param,FALSE);
		$res = json_decode($postRet,1);
		$question = $res['datas']['question'];//单个试题

		//合并题目额外信息
		$question = array_merge($question, json_decode($res['datas']['question']['extdata'],1));
		unset($question['extdata']);
		$aqdList = $res['datas']['aqdList'];

		//构建用户答案,以及用户的得分
		foreach ($aqdList as $key => $value) {
			$ques[$key] = $question;
			$ques[$key]['aid'] = $value['aid'];
			$ques[$key]['questionid'] = $value['qid'];
			$ques[$key]['dateline'] = $value['ansdateline'];
			$ques[$key]['usedtime'] = $value['usedtime'];
			$ques[$key]['remark'] = $value['remark'];
			$userinfo = $this->model('user')->getUserInfoByUid($value['uid']);
			$ques[$key]['userinfo'] = $userinfo[0];
			$scoreArr[$key]['type'] = $question['quetype'];//得分题型
			$ques[$key]['type'] = $question['quetype'];
			$ques[$key]['subject'] = $question['qsubject'];
			$ques[$key]['dqid'] = $value['dqid'];//每题的答题记录id
			$Ztype = array('A', 'B', 'D', 'H');
			if (in_array($question['quetype'], $Ztype)) {
				$ques[$key]['aques'] = $question['answers'];
				if ($question['quetype'] == 'D') {//判断题的处理
					$ques[$key]['answers'] = substr($value['choicestr'], 0, 1);
				} else {
					$ques[$key]['answers'] = $this->_numtostr($value['choicestr']);
				}
				$scoreArr[$key]['showtype'] = $value['allright'];
				$scoreArr[$key]['score'] = $value['totalscore'];
			} elseif ($question['quetype'] == 'C') {//填空题
				$ques[$key]['aques'] = $ques[$key]['options'];
				if (!empty($value['answerBlankDetails'])) {
					//空格排序
					foreach ($value['answerBlankDetails'] as $abvalue) {
						$abids[$key][] = $abvalue['bid'];
					}
					array_multisort($abids[$key], SORT_ASC, $value['answerBlankDetails']);
					$ques[$key]['score'] = $question['quescore']/count($value['answerBlankDetails']);
					foreach ($value['answerBlankDetails'] as $akey => $avalue) {
						$ques[$key]['answers'][] = $avalue['content'];//用户答题内容
						$ques[$key]['dbid'][] = $avalue['dbid'];//每个空的记录id
						$scoreArr[$key]['info'][$akey]['score'] = $avalue['score'];//构建分数
						$scoreArr[$key]['info'][$akey]['showtype'] = !empty($avalue['score']) ? 1 : 0;//构建showtype
					}
				}
			} elseif (isX($question['quetype'])) {
				$this->parseWordQue($ques[$key], $value, 1);//解析学生得分
				if (isset($value['data']['score'])) {//老师的批阅分覆盖自动批阅分
					insertWordQueScore($ques[$key], $value['data']);
				}
			} else {//对文字题处理，只有一个blanklist
				$ques[$key]['aques'] = $ques[$key]['answers'];
				if (!empty($value['answerBlankDetails'])) {
					foreach ($value['answerBlankDetails'] as $akey => $avalue) {
						$ques[$key]['answers'] = $avalue['content'];//用户答题内容
						$ques[$key]['dbid'][] = $avalue['dbid'];//每个空的记录id
						$scoreArr[$key]['score'] = $avalue['score'];//构建分数
						$scoreArr[$key]['showtype'] = !empty($avalue['score']) ? 1 : 0;//构建showtype
					}
				}
			}
		}
		$datas = array(
			'answercounts'=>$res['datas']['pageInfo']['totalPages'],
			'count'=>$res['datas']['correctcounts'],
			'ques'=>$ques,
			'scoreArr'=>$scoreArr,
			'page'=>$res['datas']['pageInfo']['number']
		);

		$this->renderJson('0','',$datas);
	}

	public function stusmartlist_view() {
		$eid = $this->uri->itemid;
		$this->assign('eid',$eid);
		$this->display('troomv2/exam2/teacher/stu_smartexamlist');
	}

	/**
	 * 获取教师智能作业下学生生成的作业列表
	 */
	public function allSmartExamAjax() {
		$eid = $this->input->post('eid');
		$param = parsequery();
		$param['k'] = $this->k;
		$url = '/exam/allsmartexam/list/'.$eid;
		$postRet = $this->do_post($url,$param);

		//作业列表
		$examList = $postRet->examList;

		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);
		$datas = array(
			'examList'=>$examList,
			'pagestr'=>$pagestr
		);
		$this->renderJson('0','',$datas);
	}

	/**
	 *教师查看操作
	 *
	 */

	/**
	 *答案列表显示页面
	 */
	public function alist_view() {
		$eid = $this->uri->itemid;
		$classid = $this->input->get('classid');
		$this->assign('classid',$classid);
		$this->assign('eid',$eid);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/alist');
	}

	/**
	 *智能作业答案列表显示页面
	 */
	public function smartalist_view() {
		$eid = $this->uri->itemid;
		$classid = $this->input->get('classid');
		$this->assign('classid',$classid);
		$this->assign('eid',$eid);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/alist');
	}

	/*
	 *通过学生名查看学生答题情况，兼容以后的免费课有权限表
	 */
	public function alistAjaxbyname() {
		$sstatus = intval($this->input->post('sstatus'));
		$eid = intval($this->input->post('eid'));
		$classid = intval($this->input->post('classid'));
		if (empty($eid)) {
			$this->renderJson('0','missing eid',0);
		} 
		$realname = trim($this->input->post('realname'));
		if (empty($realname) && $realname != '0') {
			$this->renderJson('0','missing realname',0);
		} 
		$users = $this->model('user')->getUserinfoByname($realname, $this->room['crid']);//用户组
		$param['k'] = $this->k;
		$param['crid'] = $this->room['crid'];
		$param['eid'] = $eid;
		$param['status'] = 1;

		//如果没有用户则返回
		if (!empty($users)) {
			foreach ($users as $key => $value) {
				$param['uids'][] = $value['uid'];
			}
		} else {
			$this->renderJson('0','no people exit',1);
		}

		$url = '/useranswer/alist/'. $eid;
		$postRet = $this->do_post($url,$param,FALSE);
		$res = json_decode($postRet,1);
		if (empty($res['datas']['tid']))
			$this->renderJson('5','missing folderid',1);
		$checkparam['uids'] = 1;
		$checkparam['uidstr'] = implode(',', $param['uids']);
		$checkparam['fidstr'] = $res['datas']['tid'];
		$permissionRes = $this->model('userpermission')->permissionAdded($checkparam);//查看是否开通此课程,并且还有权限
		foreach ($users as $key => $value) {//最多也就10个人重名
			if (isset($permissionRes[$value['uid']])) {
				$userAnswerList[$key]['uid'] = $value['uid'];
				$userAnswerList[$key]['username'] = $value['username'];
				$userAnswerList[$key]['realname'] = $value['realname'];
				$userAnswerList[$key]['sex'] = $value['sex'];
				$userAnswerList[$key]['face'] = $value['face'];
			}
		}
		if (empty($userAnswerList) && empty($res['datas']['userAnswerList'])) {//有答题记录，不管是免不免费就都算有权限，主要针对免费课不需开通权限便可以答题，只要答题就能搜到该人的答题记录
			$this->renderJson('0','has no permission',2);
		}
		if (!empty($res['datas']['userAnswerList'])) {//此处对有答题记录的人
			$answereds = $res['datas']['userAnswerList'];
			foreach ($answereds as $value) {//已答题学生的信息
				$myanswereds[$value['uid']] = $value;
			}
			if (!empty($userAnswerList)) {//有答题记录，有权限的人输出
				foreach ($userAnswerList as &$value) {
					if (isset($myanswereds[$value['uid']])) {
						$value['ansdateline'] = $myanswereds[$value['uid']]['ansdateline'];
						$value['anstotalscore'] = $myanswereds[$value['uid']]['anstotalscore'];
						$value['correctrat'] = $myanswereds[$value['uid']]['correctrat'];
						$value['remark'] = $myanswereds[$value['uid']]['remark'];
						$value['aid'] = $myanswereds[$value['uid']]['aid'];
						$value['usedtime'] = $myanswereds[$value['uid']]['usedtime'];
						$value['status'] = $myanswereds[$value['uid']]['status'];
					}
				}
			} else {//有答题记录，没权限的人输出
				foreach ($users as $key => $value) {
					if (isset($myanswereds[$value['uid']])) {
						$userAnswerList[$key]['uid'] = $value['uid'];
						$userAnswerList[$key]['username'] = $value['username'];
						$userAnswerList[$key]['realname'] = $value['realname'];
						$userAnswerList[$key]['sex'] = $value['sex'];
						$userAnswerList[$key]['face'] = $value['face'];
						$userAnswerList[$key]['ansdateline'] = $myanswereds[$value['uid']]['ansdateline'];
						$userAnswerList[$key]['anstotalscore'] = $myanswereds[$value['uid']]['anstotalscore'];
						$userAnswerList[$key]['correctrat'] = $myanswereds[$value['uid']]['correctrat'];
						$userAnswerList[$key]['remark'] = $myanswereds[$value['uid']]['remark'];
						$userAnswerList[$key]['aid'] = $myanswereds[$value['uid']]['aid'];
						$userAnswerList[$key]['usedtime'] = $myanswereds[$value['uid']]['usedtime'];
						$userAnswerList[$key]['status'] = $myanswereds[$value['uid']]['status'];
					}
				}
			}
		}
		$sort_scorearr = array();
		foreach($userAnswerList as $k=>$ua){
			//根据已做，未作筛选
			if($sstatus == 1 && !isset($ua['anstotalscore']) || $sstatus == 2 && isset($ua['anstotalscore'])){
				unset($userAnswerList[$k]);
				continue;
			}
			$sort_scorearr[] = isset($ua['anstotalscore'])?$ua['anstotalscore']:-1;
		}
		array_multisort($userAnswerList , SORT_DESC ,$sort_scorearr);
		$this->getClassName($userAnswerList,null,$classid);
		$datas = array(
			'userAnswerList'=>array_values($userAnswerList),
			'pagestr'=>''
		);
		$this->renderJson('0','',$datas);
	}

	/**
	 *Ajax获取指定普通作业下面的答案
	 */
	public function alistAjax() {
		$sstatus = intval($this->input->post('sstatus'));
		$eid = intval($this->input->post('eid'));
		$order = intval($this->input->post('order'));
		if(!is_numeric($eid) || $eid < 0 ) {
			$this->renderJson('120','eid不符合要求');
		}
		$param = parsequery();
		if ($order == 1) {//排序
			$param['order'] = 'anstotalscore asc';
		} elseif ($order == 2) {
			$param['order'] = 'usedtime asc';
		} elseif ($order == 3) {
			$param['order'] = 'usedtime desc';
		} else {
			$param['order'] = 'anstotalscore desc';
		}

		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$param['uids'][] = $uid['uid'];//作业关联班级后，班级的学生id
				}
			}
			if (empty($param['uids'])) {
				$datas = array(
					'userAnswerList'=>array(),
					'pagestr'=>''
				);
				$this->renderJson('0','',$datas);
			}

		}
		//$param['q'] = '';
		$param['size'] = 20;
		$param['k'] = $this->k;
		$param['crid'] = $this->room['crid'];
		$param['eid'] = $eid;
		$param['status'] = 1;

		$url = '/useranswer/alist/'. $eid;
		$postRet = $this->do_post($url,$param,FALSE);
		$res = json_decode($postRet,1);
		if (!empty($res['errCode']))
			$this->renderJson('12011','数据错误');
		if ($res['datas']['dtag'] == 1 || $res['datas']['status'] == 0)
			$this->renderJson('12012','作业无权限');
		
		//构建数据
		$folderid = $res['datas']['tid'];
		
		if (!empty($res['datas']['examUserList'])) {//作业关联学生了之后总的学生
			foreach ($res['datas']['examUserList'] as $uid) {
				if($classid && in_array($uid,$param['uids']) || empty($classid)){
					$alluserids[] = $uid;
				}
				
			}
		} else {//这里取开通课程总人数
			$isDistinctUid=TRUE;
			$allusers = $this->model('userpermission')->getUserIdListByFolder($folderid,$isDistinctUid);//总人数
			$alluserids = array();//所有人的id
			if (!empty($param['uids'])) {
				if (!empty($allusers)) {
					foreach ($allusers as $value) {
						if (in_array($value['uid'], $param['uids']))
							$alluserids[] = $value['uid'];
					}
				}
			} else {
				if ($classid) {//有关联班级，没人开通课程初始化
					$alluserids = array();
				} else {
					if (!empty($allusers)) {
						foreach ($allusers as $value) {
							$alluserids[] = $value['uid'];
						}
					}
				}
			}
		}

		$userAnswerList = $res['datas']['userAnswerList'];//分页获取的已经答题列表
		$pagecount = count($userAnswerList);//分页记录数量
		$allAnsweruids = $res['datas']['uids'];//所有的答题的uid
		$noanswseruids = array_diff($alluserids, $allAnsweruids);//所有未答题的uid
		//$totalElement = $res['datas']['pageInfo']['totalElement'];//所有已答题的人数
		$pagesize = $res['datas']['pageInfo']['size'];//分页规格
		$page = empty($param['page']) ? 1 : $param['page'];//当前页

		//构建分页数据开始
		if ($sstatus == 0) {//全部人数
			$total = array_merge_recursive($allAnsweruids, $noanswseruids);//总数据uids
			if (!empty($userAnswerList)) {
				foreach ($userAnswerList as $value) {//分页已答题uid
					$uids[] = $value['uid'];
				}
				if (!empty($uids))
					$userinfos = $this->model('user')->getUserInfoByUid($uids);
				if (!empty($userinfos)) {
					foreach ($userinfos as $key => $value) {
						foreach ($userAnswerList as $ukey => $uvalue) {
							if ($value['uid'] == $uvalue['uid']) {//把用户信息追加
								$userAnswerList[$ukey]['username'] = $value['username'];
								$userAnswerList[$ukey]['realname'] = $value['realname'];
								$userAnswerList[$ukey]['sex'] = $value['sex'];
								$userAnswerList[$ukey]['face'] = $value['face'];
							}
						}
					}
				}
				if ($pagesize > $pagecount) {//pagesize=20,返回14条数据
					$noanswsercount = $pagesize - $pagecount;//需要加上的未答题人数
					if (!empty($noanswseruids)) {//还有未答题人数
						$noids = array_slice($noanswseruids, 0, $noanswsercount);//分页返回的未答题人数id
						$noanwseruserinfos = $this->model('user')->getUserInfoByUid($noids);
						if (!empty($noanwseruserinfos))
							$userAnswerList = array_merge_recursive($userAnswerList,$noanwseruserinfos);
					}
				}
			} else {//java服务器答题人数页数已过或者是没人答题，无返回数据
				$start = ($page-1) * $pagesize;
				//$total = array_merge_recursive($allAnsweruids, $noanswseruids);//总数据uids
				$noids = array_slice($total, $start, $pagesize);
				if (!empty($noids)) {
					$noanwseruserinfos = $this->model('user')->getUserInfoByUid($noids);
				} else {
					$noanwseruserinfos = '';
				}
				$userAnswerList = $noanwseruserinfos;
			}
			$pagestr = ajaxpage(count($total), $param['size'], $page);
		} elseif ($sstatus == 1) {//已答题人数
			if (!empty($userAnswerList)) {
				foreach ($userAnswerList as $value) {//分页已答题uid
					$uids[] = $value['uid'];
				}
				if (!empty($uids))
					$userinfos = $this->model('user')->getUserInfoByUid($uids);
				if (!empty($userinfos)) {
					foreach ($userinfos as $key => $value) {
						foreach ($userAnswerList as $ukey => $uvalue) {
							if ($value['uid'] == $uvalue['uid']) {//把用户信息追加
								$userAnswerList[$ukey]['username'] = $value['username'];
								$userAnswerList[$ukey]['realname'] = $value['realname'];
								$userAnswerList[$ukey]['sex'] = $value['sex'];
								$userAnswerList[$ukey]['face'] = $value['face'];
							}
						}
					}
				}
			}
			$pagestr = ajaxpage(count($allAnsweruids), $param['size'], $page);
		} else {//未答题人数
			$start = ($page-1) * $pagesize;
			$noids = array_slice($noanswseruids, $start, $pagesize);
			if (!empty($noids))
				$noanwseruserinfos = $this->model('user')->getUserInfoByUid($noids);
			$userAnswerList = empty($noanwseruserinfos) ? '' : $noanwseruserinfos;
			$pagestr = ajaxpage(count($noanswseruids), $param['size'], $page);
		}
		$classes = $this->getClassName($userAnswerList,$alluserids);
		$datas = array(
			'classes' => $classes,
			'userAnswerList'=>$userAnswerList,
			'pagestr'=>$pagestr
		);
		$this->renderJson('0','',$datas);
	}

	/*
	 * 新版作业成绩导出
	 */
	public function scexcelv2(){
		$eid = intval($this->input->get('eid'));
		//$eid = 3907;
		$param = parsequery();
		$param['order'] = 'anstotalscore desc';
		$param['size'] = 50;
		$param['k'] = $this->k;
		$param['crid'] = $this->room['crid'];
		$param['eid'] = $eid;
		$param['status'] = 1;

		$url = '/useranswer/alist/'. $eid;
		$postRet = $this->do_post($url,$param,FALSE);
		$res = json_decode($postRet,1);
		if (!empty($res['errCode']))
			$this->renderJson('12011','数据错误');
		if ($res['datas']['dtag'] == 1 || $res['datas']['status'] == 0)
			$this->renderJson('12012','作业无权限');

		//构建数据
		$folderid = $res['datas']['tid'];
		$isDistinctUid=TRUE;
		$allusers = $this->model('userpermission')->getUserIdListByFolder($folderid,$isDistinctUid);//总人数
		$alluserids = array();//所有人的id
		if (!empty($allusers)) {
			foreach ($allusers as $value) {
				$alluserids[] = $value['uid'];
			}
		}
		$userAnswerList = $res['datas']['userAnswerList'];//分页获取的已经答题列表

		//判断一次是否能获取全部数据，否则的话循环，防止直接取全部数据java挂了
		$totalPages = $res['datas']['pageInfo']['totalPages'];
		$param['page'] = 1;
		if ($totalPages > 1) {
			for ($i=0;$i<=$totalPages;$i++) {
				$param['page']++;
				$postRet = $this->do_post($url,$param,FALSE);
				$temp = json_decode($postRet,1);
				foreach ($temp['datas']['userAnswerList'] as $value) {
					array_push($userAnswerList,$value);
				}
			}
		}
		
		$allAnsweruids = $res['datas']['uids'];//所有的答题的uid
		$noanswseruids = array_diff($alluserids, $allAnsweruids);//所有未答题的uid
		$noanwseruserinfos = array();

		//构建数据开始
		$total = array_merge_recursive($allAnsweruids, $noanswseruids);//总数据uids
		if (!empty($userAnswerList)) {
			foreach ($userAnswerList as $value) {//分页已答题uid
				$uids[] = $value['uid'];
			}
			if (!empty($uids)) {
				$userinfos = $this->model('user')->getUserInfoByUid($uids);
			}
			if (!empty($userinfos)) {
				foreach ($userinfos as $value) {
					$myuids[$value['uid']] = $value;
				}
				foreach ($userAnswerList as $ukey => $uvalue) {
					if (isset($myuids[$uvalue['uid']])) {//把用户信息追加
						$userAnswerList[$ukey]['username'] = $myuids[$uvalue['uid']]['username'];
						$userAnswerList[$ukey]['realname'] = $myuids[$uvalue['uid']]['realname'];
					}
				}
			}
			if (!empty($noanswseruids)) {//还有未答题人数
				$noanwseruserinfos = $this->model('user')->getUserInfoByUid($noanswseruids);
				if (!empty($noanwseruserinfos))
					$userAnswerList = array_merge_recursive($userAnswerList,$noanwseruserinfos);
			}
		} else {//java服务器答题人数页数已过或者是没人答题，无返回数据
			if (!empty($noanswseruids)) {
				$noanwseruserinfos = $this->model('user')->getUserInfoByUid($noanswseruids);
			}
			$userAnswerList = $noanwseruserinfos;
		}

		if (empty($userAnswerList))
			$this->renderJson('1','没人答题','');

		$filename = '学生成绩';
		$titleArr = array('学生账号','姓名','得分');
		$dataArr = array();
		foreach ($userAnswerList as $answer) {
			if ( ! isset($answer['anstotalscore'])) {
				$answer['anstotalscore'] = '';
			}
			array_push($dataArr,array($answer['username'],$answer['realname'],$answer['anstotalscore']));
		}
		$widtharr = array(20,20,20);
		$this->_exportExcel($titleArr,$dataArr,'FFFFFFFF',$filename,$widtharr);
	}

	/**
	 *整卷批改页面
	 */
	public function papercorrect_view() {
		$eid = $this->input->get('eid');
		$m =  $this->input->get('m');//锚点id记录批改到哪题
		if (empty($eid)) {
			$eid = $this->input->post('eid');
		}
		if(!is_numeric($eid) || $eid < 0 ) {
			$this->renderJson('120','eid不符合要求');
		}

		$aid = $this->uri->itemid;
		if(!is_numeric($aid) || $aid < 0 ) {
			$this->renderJson('120','aid不符合要求');
		}

		$this->assign('eid',$eid);
		$this->assign('aid',$aid);
		$this->assign('m',$m);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/onepaper_correct');
	}

	/**
	 *整卷批改页面数据
	 */
	public function paperCorrectAjax() {
		$aid = $this->input->post('aid');
		$eid = $this->input->post('eid');
		if(!is_numeric($eid) || $eid < 0 ) {
			$this->renderJson('120','eid不符合要求');
		}
		if(!is_numeric($aid) || $aid < 0 ) {
			$this->renderJson('120','aid不符合要求');
		}
		$param = array(
			'k'=>$this->k,
			'eid'=>$eid
		);

		//试题和答题信息
		$url = '/useranswer/getbyaid/'.$aid;
		$postRet = $this->do_post($url,$param,FALSE);//获取试题信息
		$res = json_decode($postRet,1);
		/*if ($res['datas']['exam']['uid'] != $this->user['uid']) {
			$this->renderJson('1200','不能批改其他老师的作业');
		}*/
		if (empty($res['datas']['questionList']))
			exit('试题列表不存在');
		foreach ($res['datas']['questionList'] as $key => $value) {
			$ques[] = $value['question'];//构建试题信息
			if ($value['question']['quetype'] == 'Z' OR $value['question']['quetype'] == 'G') {//兼容文本行没答题记录,音频题也没有答题记录的
				$pushAnswer['qid'] = $value['question']['qid'];
				$pushAnswer['type'] = $value['question']['quetype'];
				$pushAnswer['status'] = 1;
				$pushAnswer['subject'] = $value['question']['qsubject'];
				array_push($res['datas']['userAnswer']['answerQueDetails'], $pushAnswer);
			}
		}
		$examinfo = $res['datas']['exam'];
		if (!empty($res['errCode']))
			exit('学生答题信息出错');
		$answeruid = $res['datas']['userAnswer']['uid'];//学生id
		$userinfo = $this->model('user')->getuserbyuid($answeruid);//学生详情

		//构建试题信息，统计总分
		$score = 0;
		$ques = $this->rankQue($ques, $score);

		//答题排序
		foreach ($res['datas']['userAnswer']['answerQueDetails'] as $value) {
			$qids[] = $value['qid'];
			//$bids[] = empty($value['dqid'])? 0 : $value['dqid'];
		}
		array_multisort($qids, SORT_ASC, $res['datas']['userAnswer']['answerQueDetails']);

		//构建用户答案,以及用户的得分
		$tmark = 0;//是否能重新批改字段
		foreach ($res['datas']['userAnswer']['answerQueDetails'] as $key => $value) {
			$ques[$key]['status'] = $value['status'];//该题批改状态,兼容单题批改
			$scoreArr[$key]['type'] = $ques[$key]['type'];//得分题型
			$ques[$key]['dqid'] = empty($value['dqid']) ? 0 : $value['dqid'];//每题的答题记录id
			$Ztype = array('A', 'B', 'D', 'H');
			if (in_array($ques[$key]['type'], $Ztype)) {
				if ($ques[$key]['type'] == 'H')
					$tmark++;
				$ques[$key]['aques'] = $ques[$key]['answers'];
				if ($ques[$key]['type'] == 'D') {//判断题的处理
					if ($value['choicestr'] != '00') {
						$ques[$key]['answers'] = explode(',',$value['data']);
					} else {
						$ques[$key]['answers'] = '00';
					}
				} else {
					$ques[$key]['answers'] = $this->_numtostr($value['choicestr']);
				}
				$scoreArr[$key]['showtype'] = $value['allright'];
				$scoreArr[$key]['score'] = $value['totalscore'];
			} elseif ($ques[$key]['type'] == 'Z' OR $ques[$key]['type'] == 'G') {
				continue;
			} elseif ($ques[$key]['type'] == 'C') {//填空题
				$tmark++;
				$ques[$key]['aques'] = $ques[$key]['options'];
				if (!empty($value['answerBlankDetails'])) {
					$i = 0;
					//空格排序
					foreach ($value['answerBlankDetails'] as $abvalue) {
						$abids[$key][] = $abvalue['bid'];
					}
					array_multisort($abids[$key], SORT_ASC, $value['answerBlankDetails']);
					foreach ($value['answerBlankDetails'] as $akey => $avalue) {
						$ques[$key]['answers'][$i] = $avalue['content'];//用户答题内容
						$ques[$key]['dbid'][$i] = $avalue['dbid'];//每个空的记录id
						$scoreArr[$key]['info'][$akey]['score'] = $avalue['score'];//构建分数
						$scoreArr[$key]['info'][$akey]['showtype'] = ($avalue['score'] == $ques[$key]['score']) ? 1 : 0;//构建showtype
						$i++;
					}
				}
			} elseif (isX($ques[$key]['type'])) {
				$tmark++;
				$this->parseWordQue($ques[$key], $value, 1);//解析学生得分
				if (isset($value['data']['score'])) {//老师的批阅分覆盖自动批阅分
					insertWordQueScore($ques[$key], $value['data']);
				}

			} else {//对文字题处理，只有一个blanklist
				$tmark++;
				$ques[$key]['aques'] = $ques[$key]['answers'];
				if (!empty($value['answerBlankDetails'])) {
					foreach ($value['answerBlankDetails'] as $akey => $avalue) {
						$ques[$key]['answers'] = $avalue['content'];//用户答题内容
						$ques[$key]['dbid'][] = $avalue['dbid'];//每个空的记录id
						$scoreArr[$key]['score'] = $avalue['score'];//构建分数
						$scoreArr[$key]['showtype'] = ($avalue['score'] == $ques[$key]['score']) ? 1 : 0;//构建showtype
					}
				}
			}
		}
	
		//构建输出数据
		$ajaxdata['aid'] = $aid;
		$ajaxdata['correctrat'] = $res['datas']['userAnswer']['correctrat'];
		$ajaxdata['uid'] = $res['datas']['userAnswer']['uid'];
		$ajaxdata['tmark'] = $tmark;//是否可以重新批改
		$ajaxdata['completetime'] = $res['datas']['userAnswer']['usedtime'];
		$ajaxdata['crid'] = $this->room['crid'];
		$ajaxdata['dateline'] = $examinfo['dateline'];//这个作业信息没返回来
		$ajaxdata['eid'] = $examinfo['eid'];
		$ajaxdata['limitedtime'] = $examinfo['limittime'];
		$ajaxdata['remark'] = $res['datas']['userAnswer']['remark'];
		$ajaxdata['sdateline'] = $res['datas']['userAnswer']['ansdateline'];
		$ajaxdata['title'] = $examinfo['esubject'];
		$ajaxdata['totalscore'] = $res['datas']['userAnswer']['anstotalscore'];
		$ajaxdata['trealname'] = $this->user['realname'];
		$ajaxdata['tusername'] = $this->user['username'];
		$ajaxdata['username'] = $userinfo['username'];//学生账号
		$ajaxdata['realname'] = $userinfo['realname'];
		$ajaxdata['score'] = $score;
		$ajaxdata['ques'] = $ques;
		$ajaxdata['scoreArr'] = $scoreArr;

		echo json_encode($ajaxdata);
	}

	/**
	 *整卷批改上传批阅结果
	 */
	public function upOnePagerAjax() {
		$url = "/correct/all/";
		$param = array(
			'k'=>$this->k,
			'status'=>1
		);
		$maodianid = 0;//锚点
		$uid = intval($this->input->post('uid'));
		$userAnswer = $this->input->post('userAnswer',FALSE);
		$correctList = $userAnswer['data'];
		if (empty($correctList)) {
			$this->renderJson('120','无法检测到correctList');
		}
		$aid = intval($this->input->post('aid'));

		$schcwidlist = '';
		$unsetQuetypes = array('A','B','D','G','Z');//过滤的题型
		foreach ($correctList['answerqueDetailList'] as $key => &$val) {
			if ($val['type'] == 'H') {//主观题得分的cwids
				$maodianid = $key;
				$schcwidlist .= $val['schcwid'].',';
			} elseif ($val['type'] == 'C') {//填空题
				$maodianid = $key;
			} elseif (in_array($val['type'], $unsetQuetypes)) {
				unset($correctList['answerqueDetailList'][$key]);
				continue;
			}
			if (!empty($val['data']))
				$val['data'] = json_encode($val['data']);
		}
		//获取主观题得分
		if (!empty($schcwidlist)) {
			$schcwidlist = substr($schcwidlist, 0, strlen($schcwidlist)-1);
			$noteparam = array(
				'uid'=>$uid,
				//'aid' => $aid,
				'cwids' => $schcwidlist	
			);
			$notelist = $this->model('schcourseware')->getCoursenoteBycwids($noteparam);
		}

		//构建数据符合java端json的解析
		$i = 0;
		foreach ($correctList['answerqueDetailList'] as $value) {
			if ($value['type'] == 'H') {//主观题分数赋值
				unset($value['type']);
				$param['userAnswer']['data']['answerqueDetailList'][$i]['remark'] = empty($value['remark']) ?'':$value['remark'];
				$param['userAnswer']['data']['answerqueDetailList'][$i]['dqid'] = $value['dqid'];
				foreach ($notelist as $nkey => $nvalue) {
					if ($nvalue['cwid'] == $value['schcwid'] && $nvalue['qid'] == $value['qid']) {
						$param['userAnswer']['data']['answerqueDetailList'][$i]['totalscore'] = $nvalue['score'];
						if ($value['score'] <= $nvalue['score']) {
							$param['userAnswer']['data']['answerqueDetailList'][$i]['allright'] = 1;//是否全对
							$param['userAnswer']['data']['answerqueDetailList'][$i]['totalscore'] = $value['score'];
						}
					}
				}
			} else {
				unset($value['type']);
				$param['userAnswer']['data']['answerqueDetailList'][$i] = $value;
				//$param['userAnswer']['data']['answerqueDetailList'][$i]['allright'] = 1;
			}
			$i++;
		}

		$param['eid'] = intval($this->input->post('eid'));
		$param['userAnswer']['aid'] = $aid;
		$anremark = $this->input->post('remark');
		if (!empty($anremark))
			$param['remark'] = h($anremark);
		$param['userAnswer']['data'] = json_encode($param['userAnswer']['data']);
		//print_r($param);exit;
		$result = $this->do_post($url, $param, 1);
		//$status = !empty($result->nextAid) ? 1 : 0;
		$nextAid = empty($result->nextAid) ? NULL : $result->nextAid;
		$status = 1;
		$res = array(
	    	'status'=>$status,
	    	'datapackage'=>array(
	    		'curaid'=>$aid,
	    		'nextaid'=>$nextAid,
	    		'maodianid'=>$maodianid
	    	)
    	);
		echo json_encode($res);
	}

	/*
	 *作业批改后预览页面
	 */
	public function eview_view() {
		$aid = $this->uri->itemid;
		$eid = intval($this->input->get('eid'));
		$this->assign('aid', $aid);
		$this->assign('eid', $eid);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/eview');
	}
	
	//统计页面
	public function efenxi_view() {
		$eid = $this->uri->itemid;
		$this->assign('eid',$eid);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/analysis_exam');
	}

	//统计分析
	public function efenxiAjax() {
		$url = "/exam/efenxi";
		$eid = $this->input->post('eid');
		$bytype = $this->input->post('bytype'); //que,level,relationship,quetype
		//$uids = $this->input->post('uids');
		//if (empty($uids)) {
			//$uids = array();
		//}
		$data = array(
			'k'=>$this->k,
			'eid'=>$eid,
			'bytype'=>$bytype,
			'action'=>'teacher'
			//'uids'=>$uids
		);
		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classid) {
			$data['classid'] = $classid;
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$data['uids'][] = $uid['uid'];
				}
			} else {
				$this->renderJson(0, '', array('efenxi'=>array()));
			}
		}
		//当为优秀率分析的时候，需要算出总人数
		/*if ($bytype == 'level') {
			$leveldatas = $this->do_post($url,$data,FALSE);
			$leveldatas = json_decode($leveldatas,1);
			if (!empty($leveldatas['datas'])) {
				$totalcount = 0;
				foreach ($leveldatas['datas']['efenxi'] as  $value) {
					$totalcount += $value['count'];
				}
			}
			$leveldatas['datas']['totalcount'] = $totalcount;
			$this->renderJson(0, '', $leveldatas['datas']);
		}*/
		echo  $this->do_post($url,$data,FALSE);
	}

	//作业概要
	public function examSummaryAjax() {
		$eid = $this->input->post('eid');
		$url = "/exam/summary/".$eid;
		$uids = $this->input->post('uids');
		if(empty($uids)) {
			$uids = array();
		}
		$data = array(
			'k'=>$this->k,
			'uids'=>$uids
		);
		echo  $this->do_post($url,$data,FALSE);
	}

	/*
	 *错题集
	 */
	public function errors() {
		$this->display('troomv2/exam2/teacher/errorlist');
	}

	/*
	 *获取错题集列表
	 */
	public function errlistAjax(){
		$param = parsequery();
		$param['k'] = $this->k;
		$param['crid'] = $this->room['crid'];

		$quetype = $this->input->post('queType');
		$param['quetype'] = $quetype;

		$ttype = $this->input->post('ttype');//错题关联类型
		$tid = $this->input->post("tid");//关联id
		$eid = intval($this->input->post("eid"));//作业id
		$style = $this->input->post("style");//style
		if (isset($style)) {
			$param['style'] = intval($style);
		}
		if (!empty($ttype)) {
			$param['ttype'] = $ttype;
			if (is_array($tid)) {//全部课程
				foreach ($tid as $value) {
					if (!is_numeric($value)) {
						$this->renderJson('0','tid非法',array());
					}
				}
				$param['tids'] = $tid;
			} else if (is_numeric($tid)) {//单个课程
				$param['tid'] = $tid;
			} else {
				$this->renderJson('0','tid非法',array());
			}
		}
		if (!empty($eid))
			$param['eid'] = $eid;

		/*if (1) {
			$param['uid'] = $this->user['uid'];
			$param['forexam'] = 'teacher';//学生生成一份相同的智能作业
			$url = '/exam/getsmart/'.$eid;
		} else {
			$this->renderJson("0","etype err",'1');
		}
		$postRet = $this->do_post($url,$param);
		$exam = $postRet->exam;
		$param['eid'] = $exam->eid;*/

		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		//print_r($classidArr);exit;
		if ($classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					if ($uid['uid'])
						$param['uids'][] = $uid['uid'];
				}
			} else {
				$this->renderJson('1200001','无错题',array('errList'=>array()));
			}
		}
		//$param['teacherid'] = $this->user['uid'];
		$param['forwho'] = 'teacher';
		$q = $this->input->post('q');
		if (!empty($q)) {
			$param['q'] = $q;
		}
		//print_r($param);exit;
		$url = "/errorbook/errlist";
		$postRet = $this->do_post($url,$param);
		if (!empty($postRet->errList)) {//转换答案
			foreach ($postRet->errList as $key => $value) {
				if ($value->question->queType == 'D') {
					$value->question->choicestr = substr($value->question->choicestr, 0, 1);
				} else if ($value->question->queType == 'A' || $value->question->queType == 'B'){
					$value->question->choicestr = $this->_numtostr($value->question->choicestr);
				} else if (isX($value->question->queType) OR $value->question->queType == 'H') {
					unset($postRet->errList[$key]);
				}
			}
		} else {
			$this->renderJson('1200001','无错题',array('errList'=>array()));
		}
		
		//作业列表
		$errList = $postRet->errList;
		//分页
		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);
		$datas = array(
			'errList'=>array_values($errList),
			'page'=>$postRet->pageInfo->number,
			'pagestr'=>$pagestr
		);
		if (!empty($postRet->answercounts))
			$datas['answercounts'] = $postRet->answercounts;
		$this->renderJson('0','',$datas);
	}

	//试题错题统计
	public function answerCount() {
		$qid = intval($this->input->post('qid'));
		$eid = intval($this->input->post('eid'));
		$quetype = $this->input->post('quetype');
		$choicestr = $this->input->post('choicestr');//正确答案
		//$queMap = array('A','B','D');//题型
		$datas = array();
		if (empty($qid) && empty($eid))
			$this->renderJson('0','参数非法',$datas);
		if ($eid) {
			$url = "/errorbook/answercounts/".$eid;
		} else {
			$url = "/errorbook/answercount/".$qid;
		}
		$param = array(
			'k'=>$this->k,
			'quetype'=>$quetype
		);
		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$param['uids'][] = $uid['uid'];
				}
			}
		}

		$res = $this->do_post($url,$param,1);
		$res->quetype = $quetype;

		//统计列表
		if (!empty($res->answerDetaillist)) {
			/*if ($quetype == 'D') {
				foreach ($res->answerDetaillist as $value) {
					$value->choiceOriStr = $value->choiceStr;//原始的0001
					$value->choiceStr = substr($value->choiceStr, 0, 1) ? '对' : '错';//转换01
				}
				$res->choicestr = substr($choicestr, 0, 1) ? '对' : '错';//转换01
			} else*/ 
			if ($quetype == 'A' /*|| $quetype == 'B'*/){//单选多选
				foreach ($res->answerDetaillist as $value) {
					$choice[] = (int)$value->choiceStr;
					$value->choiceOriStr = $value->choiceStr;//原始的0001
					$value->choiceStr = $this->_numtostr($value->choiceStr);//转换0001
				}
				array_multisort($choice, SORT_DESC, $res->answerDetaillist);
				$res->choicestr = $choicestr;
			}

			//解析单题
			$que = $res->simpleQue;
			$que->extdata = json_decode($res->simpleQue->extdata);
			$res->simpleQue = $que->extdata;//整体赋值
			$res->simpleQue->subject = $que->qsubject;
			$res->simpleQue->questionid= $que->qid;
			$res->simpleQue->type = $que->quetype;
			$res->simpleQue->score = $que->quescore;
			$res->simpleQue->dif = $que->level;//难度
			$res->simpleQue->resolve = empty($que->extdata->jx) ? '' : $que->extdata->jx;
			$res->simpleQue->dianpin = empty($que->extdata->dp) ? '' : $que->extdata->dp;
			unset($res->simpleQue->dp);
			unset($res->simpleQue->jx);
			unset($res->simpleQue->qid);
		} else {
			$this->renderJson('0','暂无数据',$res);
		}
		$this->renderJson('0','请求成功',$res);
	}

	//错题排名页面
	public function errorRanking_view() {
		$eid = $this->uri->itemid;
		$this->assign('eid',$eid);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/error_ranking');
	}

	//通过qid,choicestr获取答题的学生列表
	public function getanswersbyChoice() {
		$qid = intval($this->input->post('qid'));
		$choicestr = $this->input->post('choicestr');
		$choicestr = $choicestr ? $choicestr : 0;
		$param = parsequery();
		$param['size'] = 100;
		$param['k'] = $this->k;
		$param['choicestr'] = $choicestr;
		if (empty($qid)) {
			$this->renderJson('0','缺少参数',$res);
		}
		$param['qid'] = $qid;
		
		//班级
		$classid = $this->input->post('classid');
		$classidArr = explode(',', $classid);
		if ($classid) {
			$stUids = $this->model('classes')->getStudentUidByClassid($classidArr);
			if ($stUids) {
				foreach ($stUids as $uid) {
					$param['uids'][] = $uid['uid'];
				}
			}
		}

		$url = "/errorbook/getanswersbychoice/";
		$res = $this->do_post($url, $param);

		//分页
		$pagestr = ajaxpage($res->pageinfo->totalElement,$res->pageinfo->size,$res->pageinfo->number);
		$res->pagestr = $pagestr;

		//构建学生信息
		if (!empty($res->answerList)) {
			foreach ($res->answerList as $value) {
				$uidsArr[] = $value->uid;
			}
		}
		if (!empty($uidsArr))
			$userinfos = $this->model('user')->getUserInfoByUid($uidsArr);
		foreach ($res->answerList as $value) {
			foreach ($userinfos as $uvalue) {
				if ($value->uid == $uvalue['uid']) {
					$value->username = $uvalue['username'];
					$value->realname = $uvalue['realname'];
					$value->face = $uvalue['face'];
					$value->sex = $uvalue['sex'];
				}
			}
		}
		echo json_encode($res);
	}

	/*
	 * 删除学生答题记录
	 */
	public function delUserAnswer() {
		$aid = intval($this->input->post('aid'));
		if ($aid && 1) {
			$param['k'] = $this->k;
			$url = "/errorbook/getanswersbychoice/".$aid;
			echo $this->do_post($url, $param);
		} else {
			$this->renderJson('10000123','删除失败',$datas);
		}
		
	}

	//根据课件布置作业所对应的作业数量
	public function newExamWithcwid() {
		$crid = $this->room['crid'];
		$folderid = intval($this->input->post('folderid'));
		$cwid = intval($this->input->post('cwid'));
		$param['k'] = $this->k;
		if ($cwid) {
			$recuid = intval($this->input->post('recuid'));
			$param['size'] = 1;
			$param['ttype'] = 'COURSE';
			$param['tid'] = $cwid;
		}

		$url = "/exam/telist";
		$postRet = $this->do_post($url,$param);
		$excount = $postRet->pageInfo->totalElement; 
		echo json_encode ($array=array('examscount'=>$excount));
	}

	/*
     **ajax获取课件作业列表 
     */
	public function getStuExamsAjax() {
		$param = parsequery();
		$uid = intval($this->input->post('uid'));
		$param['k'] =  authcode(json_encode(array('uid'=>$uid,'crid'=>$this->room['crid'],'t'=>SYSTIME)),'ENCODE');
		$page = intval($this->input->post('page'));
		if ($page) {
			$param['page'] = $page;
		}
		$q = $this->input->post('q');
		if ($q) {
			$param['q'] = $q;
		}
		$param['size'] = 20;
		$param['action'] = 'hasdo';
		$param['status'] = 1;
		$param['order'] = 'eid desc';
		$param['ttype'] = 'FOLDER';
		$param['crid'] = $this->room['crid'];
		$param['tids'] = array();

		$url = "/exam/selist";
		$postRet = $this->do_post($url,$param);
		//作业列表
		$examList = $postRet->examList;
		if (empty($examList)) {
			$this->renderJson('1111','no homework','');
		}
		$uidarr = array();
		$estypeIds = '';//作业类型id
		foreach ($examList as $examinfo) {
			if ($examinfo->exam->estype)
				$estypeIds .= intval($examinfo->exam->estype).',';
			foreach ($examinfo->exam->relationSet as $rvalue) {
				if ($rvalue->ttype == 'FOLDER') {
					$folderids[] = $rvalue->tid;
					break;
				} 
			}
			$examinfo->exam->datelineStr = timetostr($examinfo->exam->dateline);
			$uidarr[]= $examinfo->exam->uid;
		}
		$ids = implode(',', array_unique($folderids));
		$userpermission = $this->model('Userpermission');

		//获得个作业对应的分类名称
		if (!empty($estypeIds)) {
			$estypeList = $this->model('schestype')->getEstypeByIds(substr($estypeIds, 0, -1));//类型名字
			if ($estypeList) {
				foreach ($estypeList as $value) {
					$estypeNames[$value['id']] = $value;
				}
			}
		}

		//获得各个folderid对应的人数
		$total = $userpermission->getUserCountByFolder($ids);
		//插入老师数据
		if (!empty($estypeNames)) {
			if(!empty($uidarr)){
				$userarr = $this->model('user')->getUserArray($uidarr);
				foreach ($examList as $examinfo) {
					if (isset($estypeNames[$examinfo->exam->estype])) {
						$examinfo->exam->estype = $estypeNames[$examinfo->exam->estype]['estype'];//作业类型名字赋值
					}
					//追加作业总人数
					foreach ($examinfo->exam->relationSet as $rvalue) {
						if ($rvalue->ttype == 'FOLDER') {
							foreach ($total as $value) {
								if ($value['folderid'] == $rvalue->tid) {
									$examinfo->exam->count = $value['count'];
									break;
								}
							}
						} 
					}
					$examinfo->exam->realname = shortstr($userarr[$examinfo->exam->uid]['realname'],8);
					$examinfo->exam->realnametitle = $userarr[$examinfo->exam->uid]['realname'];
				}
			}
		} else {
			if(!empty($uidarr)){
				$userarr = $this->model('user')->getUserArray($uidarr);
				foreach ($examList as $examinfo) {
					$examinfo->exam->realname = shortstr($userarr[$examinfo->exam->uid]['realname'],8);
					$examinfo->exam->realnametitle = $userarr[$examinfo->exam->uid]['realname'];
					//追加作业总人数
					foreach ($examinfo->exam->relationSet as $rvalue) {
						if ($rvalue->ttype == 'FOLDER') {
							foreach ($total as $value) {
								if ($value['folderid'] == $rvalue->tid) {
									$examinfo->exam->count = $value['count'];
									break;
								}
							}
						} 
					}
				}
			}
		}
		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);
		$datas = array(
			'examList'=>$examList,
			'pagestr'=>$pagestr
		);
		$this->renderJson('0','',$datas);
	}

	//教师获取学生错题集列表
	public function getStuErrlistAjax(){
		$param = parsequery();
		$uid = intval($this->input->post('uid'));
		$param['k'] =  authcode(json_encode(array('uid'=>$uid,'crid'=>$this->room['crid'],'t'=>SYSTIME)),'ENCODE');
		$param['crid'] = $this->room['crid'];
		$quetype = $this->input->post('quetype');
		// $folderid = $this->input->post('folderid');
		$chapterid = $this->input->post('chapterid');
		$topchapterid = $this->input->post('topchapterid');
		$secchapterid = $this->input->post('secchapterid');
		$path = $this->input->post('path');
		$eid = $this->input->post('eid');
		if(!empty($quetype)) {
			$param['quetype'] = $quetype;
		}

		$ttype = $this->input->post('ttype');
		$tid = $this->input->post("tid");
		
		$param['ttype'] = empty($ttype)?'':$ttype;
		
		if(is_numeric($tid)) {
			$param['tid'] = $tid;
		}

		$q = $this->input->post('q');
		if(!empty($q)) {
			$param['q'] = $q;
		}
		// $param['folderid'] = $folderid;
		$param['forwho'] = 'student';
		$param['chapterid'] = $chapterid;
		$param['topchapterid'] = $topchapterid;
		$param['secchapterid'] = $secchapterid;
		$param['path'] = $path;
		$param['eid'] = $eid;
		$param['order'] = 'errorid desc';
		if(!empty($eid))
			$param['style'] = 0;
		$url = "/errorbook/errlist";
// var_dump($param);
		$postRet = $this->do_post($url,$param);
		//作业列表
		$errList = $postRet->errList;
		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);

		$datas = array(
			'errList'=>$errList,
			'pagestr'=>$pagestr,
			'page'=>empty($param['page'])?1:$param['page']
		);
		$this->renderJson('0','',$datas);
	}

	/**
	 *分析作业的得分率最大和最小值
	 */
	public function analysis() {
		$param['k'] = $this->k;
		$param['tid'] = intval($this->input->post('folderid'));
		$param['ttype'] = 'FOLDER';
		$url = "/exam/tfenxi";
		echo $this->do_post($url,$param,FALSE);
	}

	/**
	 *获取课程下的作业平均得分率的统计
	 */
	public function avgscorerat() {
		$param = parsequery();
		$param['size'] = 15;
		$param['page'] = intval($this->input->post('page'));
		$param['ttype'] = 'FOLDER';
		$param['tid'] = intval($this->input->post('folderid'));
		$param['k'] = $this->k;
		$url = "/exam/avgscorerat";
		echo $this->do_post($url,$param,FALSE);
	}

	/**
	 * 获取老师班级信息
	 * return array
	 */
	public function getTeacherClasses() {
		$uid = $this->user['uid'];
		$crid = $this->room['crid'];
		$result = $this->model('teacher')->getTeacherClasses($uid,$crid);
		if (empty($result)) {
			echo json_encode($result);exit;
		}
		$folderid = intval($this->input->post('folderid'));
		if ($folderid && $this->room['isschool'] == 7) {
			$classid = '';
			foreach ($result as $value) {
				$classid .= $value['classid'].',';
			}
			$res = $this->model('Userpermission')->getUserCountByFolderAndClass($folderid,substr($classid, 0,-1));
			if (!empty($res)) {
				$hasPerClassArr = array();
				$classArr = array();
				$noclassArr = array();
				foreach ($res as $value) {
					if ($value['count'] > 0) {
						$hasPerClassArr[] = $value['classid'];
					}
				}
				foreach ($result as &$value) {
					if (in_array($value['classid'], $hasPerClassArr)) {
						$value['hasperson'] = 1;
						$classArr[] = $value;
					} else {
						$value['hasperson'] = 0;
						$noclassArr[] = $value;
					}
				}
				$result = array_merge($classArr,$noclassArr);
			} else {
				foreach ($result as &$value) {
					$value['hasperson'] = 0;
				}
			}
		} else {
			foreach ($result as &$value) {
				$value['hasperson'] = 1;
			}
		}
		echo json_encode($result);
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
	 **输出提示的信息
	 */
	private function echoMsg($msg){
	    header("Content-type: text/html; charset=utf-8");
	    echo '<span style="font-size:16px;font-weight:bold;color:#f00;">',$msg,'</span>';
	    echo '<a style="font-size:16px;font-weight:bold;" href="javascript:history.go(-1)">点我返回!</a>';
	    exit;
	}

	/*
	 **检查java服务器返回的数据
	 */
	private function apiResCheck($res,$ajax = FALSE){
	    if(empty($res)) {
	        $this->echoMsg("服务器取数据失败");exit;
	    }
	    if($res->errCode != 0) {
	        log_message("code:".$res->errCode.'--msg:'.$res->errMsg);
	        $this->echoMsg($res->errMsg);exit;
	    }
	}

	/*
	 **按规定向前台传数据
	 */
 	private function renderJson($errCode = 0,$errMsg = "",$datas = array() ,$ifexit = TRUE) {
        echo json_encode(array('errCode'=>$errCode,'errMsg'=>$errMsg,'datas'=>$datas));
        if($ifexit) {
            exit;
        }
    }

    /*
	 **把1000,转成A
	 **param $str string
	 */
 	private function _numtostr($choicestr = '') {
 		if (!isset($choicestr))
 			return;
        $sstr = 'ABCDEFGHIJKLMNOPQ';
        $strArr = str_split($sstr);
        $returnStr = '';
        foreach ($strArr as $key => $value) {
        	if (substr($choicestr, $key, 1) && $value)
        		$returnStr .= $value;
        }
        return $returnStr;
    }

    /*
	 *解析X类型题目
	 *$quevalue 教师原题
	 *$uquevalue 学生答案
	 *$tag 0 隐藏教师答案 
	*/
	public function parseWordQue(&$quevalue,&$uquevalue,$tag = 0){
		if(empty($quevalue)){
			return;
		}
		$ans = $uquevalue['data'];
		$adatapackage = json_decode($ans, 1);
		$uquevalue['data'] = $adatapackage;
		foreach ($quevalue['datapackage']['data'] as $itemskey=>&$items) {
			foreach ($items['detail'] as $itemkey => &$item) {
				if(empty($tag)){
					$item['t']['r'] = array_pad(array(),count($item['t']['r']),'');
				}
				if(!empty($ans)){
					$item['u'] = $adatapackage['data'][$itemskey]['detail'][$itemkey]['u'];
				}	
			}
		}
		$quevalue['datapackage'] = json_encode($quevalue['datapackage']);
	}

	 /*
	 *解析X类型题目
	 *$quevalue 教师原题
	 *查看答题卡，是否需要批改
	 *return bool
	*/
	public function checkCorrect($quevalue){
		if (empty($quevalue))
			return FALSE;
		foreach ($quevalue['datapackage']['data'] as $value) {
			if ($value['head']['type'] == 'xd') {
				foreach ($value['detail'] as $dvalue) {
					if (empty($dvalue['t']['isonly'])) {
						return TRUE;
					}
				}
			} elseif ($value['head']['type'] == 'xe') {
				return TRUE;
			}
		}
		return FALSE;
	}

	/*
	 *构建试题信息，同时计算试题总分数(和批阅有关)
	 *$type string 
	 */
	public function rankQue($quesinfo=array(), &$score=0, $correctrat=0) {
		//构建试题信息，别忘了统计总分
		foreach ($quesinfo as $key => $value) {
			/*if ($value['quetype'] == 'Z') {
				continue;
			}*/
			$score = $score + $value['quescore'];
			if (isset($value['data']))
			 	$value['data'] = json_decode($value['data'],TRUE);
			$value['extdata'] = json_decode($value['extdata'],TRUE);
			$ques[$key] =  $value['extdata'];//总体赋值
			$ques[$key]['chapterid'] = 0;
			foreach ($value['relationSet'] as $rvalue) {
				if ($rvalue['ttype'] == 'COURSE') {
					$ques[$key]['ccwid'] = $rvalue['tid'];
				} elseif ($rvalue['ttype'] == 'CHAPTER') {
					$ques[$key]['chapters'] .= $rvalue['tid'].',';
				} else {
					$ques[$key]['foldername'] = $rvalue['relationname'];
					$ques[$key]['folderid'] = $rvalue['tid'];//关联的课程
				}
			}
			if (!empty($correctrat))
				$ques[$key]['correctrat'] = $value['correctrat'];
			$ques[$key]['subject'] = $value['qsubject'];
			$ques[$key]['questionid'] = $value['qid'];
			$ques[$key]['type'] = $value['quetype'];
			if ($ques[$key]['type'] == 'C') {//兼容填空题的总分
				$ques[$key]['score'] = $value['quescore']/count($ques[$key]['options']);
			} else {
				$ques[$key]['score'] = $value['quescore'];
			}
			$ques[$key]['dif'] = $value['level'];//难度
			$ques[$key]['resolve'] = empty($value['extdata']['jx']) ? '' : $value['extdata']['jx'];
			$ques[$key]['dianpin'] = empty($value['extdata']['dp']) ? '' : $value['extdata']['dp'];
			unset($ques[$key]['dp']);
			unset($ques[$key]['jx']);
			unset($ques[$key]['qid']);
			//$ques[$key]['folderid'] = $exam['folderid'];//关联的课程
		}
		return $ques;
	}

	private function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$name,$manuallywidth=array()){
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

	//同步更新数据库作业
	function updateExamCount() {
		header("Content-type: text/html; charset=utf-8");
		$param['k'] = $this->k;
		$url = "/exam/allexamnum";
		$postRet = $this->do_post($url,$param);
		if (!empty($postRet->examMapList)) {
			foreach ($postRet->examMapList as $value) {
				$updateArr[$value->crid] = $value->count;
			}
		}
		if (!empty($updateArr)) {
			$ids = implode(',', array_keys($updateArr));
            $sql = '';
            $commonSet = "UPDATE ebh_classrooms SET examcount = CASE crid ";
            foreach ($updateArr as $id => $ordinal) {
                $commonSet .= sprintf("WHEN %.2f THEN %.2f ", $id, $ordinal);
            }
            $sql .= $commonSet;
            $sql .= " END WHERE crid IN ($ids)";
            $res = Ebh::app()->getdb()->query($sql);
           
            if ($res) {
            	echo '执行成功';
            } else {
            	echo '执行失败';
            }
		} else {
			echo '执行成功';
		}
	}

	//iframe弹窗地址
	public function classmateStuAdd() {
		$this->display('troomv2/exam2/teacher/classmatestu_add');
	}

	/**
     * 获取接口分页信息
     */
    public function getPageInfo(){
        //$query['pagesize'] = $this->input->
        $page = $this->input->get('pagenum') != null ? $this->input->get('pagenum') : $this->input->post('pagenum');
        $pagesize = $this->input->get('pagesize') != null ? $this->input->get('pagesize') : $this->input->post('pagesize');

        if(intval($page) <= 0){
            $page = 1;
        }

        if($pagesize == null){
            $pagesize = 20;
        }

        $query['pagenum'] = $page;
        $query['pagesize'] = $pagesize;
        return $query;

    }

	/**
     * 读取学生列表
     */
    public function studentlist(){
        $param = array();
        $param['crid'] = $this->room['crid'];
        if(empty($param['crid'])){
            $this->renderjson(1,'参数错误');
        }
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        $pageArr = $this->getPageInfo();
        $param['pagesize'] = !empty($pageArr['pagesize']) ? intval($pageArr['pagesize']) : 50;
        $param['page'] = !empty($pageArr['pagenum']) ? intval($pageArr['pagenum']) : 0;
        $q = $this->input->get('q');
        if(isset($q)){
            $param['q'] = $q;
        }
        $classid = intval($this->input->get('classid'));
        if($classid > 0){
            $param['classid'] = $classid;
        }
        $folderid = intval($this->input->get('folderid'));
        if ($folderid > 0) {
        	$param['fidstr'] = $folderid;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Student.list')->addParams($param)->request();
        if (!empty($result['list'])) {
        	//分成网校开通课程的权限判断
        	if ($folderid && $this->room['isschool'] == 7) {
	        	$uids = '';
	        	foreach ($result['list'] as $value) {
	        		$uids .= $value['uid'].',';
	        	}
	        	$param['uids'] = $uids;
	        	$param['uidstr'] = substr($uids, 0, -1);
	        	unset($param['classid']);
	        	//获取开通课程的学生
        		$permissionList = $this->model('Userpermission')->permissionAdded($param);
	        	if (!empty($permissionList)) {
	        		$hasPerList = array();
	        		$noPerList = array();
	        		foreach ($result['list'] as $value) {
	        			if (isset($permissionList[$value['uid']])) {
	        				$value['permission'] = 1;
	        				$hasPerList[] = $value;//有权限
	        			} else {
	        				$value['permission'] = 0;
	        				$noPerList[] = $value;//无权限的
	        			}
	        		}
	        		$result['list'] = array_merge($hasPerList,$noPerList);
	        	} else {
	        		foreach ($result['list'] as &$value) {
	        			$value['permission'] = 0;
	        		}
	        	}
	        } else {//非分成网校算是都有权限
	        	foreach ($result['list'] as &$value) {
        			$value['permission'] = 1;
        		}
	        }
        	
        }
        $this->renderjson(0,'',$result);
    }

     /**
     * 读取教师列表
     */
    public function teacherlist(){
        $param = array();
        $param['crid'] = $this->room['crid'];
        if(empty($param['crid'])){
            $this->renderjson(1,'参数错误');
        }
        $q = $this->input->get('q');
        if(isset($q)){
            $param['q'] = $q;
        }
        $folderid = $this->input->get('folderid');
        if(!empty($folderid)){
            $param['folderid'] = $folderid;
        }
        $classid = $this->input->get('classid');
        if(!empty($classid)){
        	$param['classids'] = '';
        	foreach ($classid as $value) {
        		$param['classids'] .= intval($value).',';
        	}
        	$param['classids'] = substr($param['classids'], 0, -1);
        }
        $teacher = $this->model('Teacher')->getClassFolderTeacherlist($param);
        if (!empty($teacher)) {
        	//不包含自己
        	foreach ($teacher as $key=>$value) {
        		if ($value['uid'] == $this->user['uid']) {
        			unset($teacher[$key]);
        		}
        	}
        } else {
        	$teacher = array();
        }
        $teacher = !empty($teacher) ? $teacher : array();
        $this->renderjson(0,'',array_values($teacher));
    }
	
	/*
	获取班级名称
	*/
	private function getClassName(&$users,$alluserids=null,$classid=null){
		if(empty($users)){
			return array();
		}
		if(empty($alluserids)){
			$alluserids = array_column($users,'uid');
		}
		$classArr = array();
		$classes = $this->model('classes')->getClassInfoByCrid($this->room['crid'],$alluserids);
		
		
		$userClassArr = array();
		if(!empty($classes)){
			foreach($classes as $class){
				if(!empty($classid) && $classid != $class['classid']){
					continue;
				}
				if(!isset($classArr[$class['classid']])){
					$classArr[$class['classid']] = $class['classname'];
				}
				$userClassArr[$class['uid']] = $class['classname'];
			}
		}
		//当前页用户班级名称
		foreach($users as $k=>&$user){
			$uid = $user['uid'];
			if(!empty($classid) && empty($userClassArr[$uid])){
				unset($users[$k]);
			}
			$user['classname'] = !empty($userClassArr[$uid])?$userClassArr[$uid]:'';
		}
		return $classArr;
		// var_dump($classes);
	}

}
