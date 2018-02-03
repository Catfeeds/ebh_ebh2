<?php
/**
 *新版互动课堂
 */
class IacourseController extends CControl{
	//首页列表页
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(!empty($roominfo) && !empty($user)){
			$q = $this->input->get('q');
			$param = parsequery();
			$param['uid'] = $user['uid'];
			$param['crid'] = $roominfo['crid'];
			$param['pagesize'] = 20;
			$param['q'] = $q;
			$iacourselist = array(); 
			$iacourseModel = $this->model('iacourse');
			$iacourselist = $iacourseModel->geticList($param);
			if(!empty($iacourselist)){
				foreach ($iacourselist as &$list) {
					$folderid = json_decode($list['folderids'],false);
					$setarr['folderids'] = implode(',',$folderid);
					$permModel = $this->model('Userpermission');
					$totalcount = $permModel->getFolderUserCount($setarr);
					$list['totalcount'] = $totalcount;
				}
			}
			$iacount = $iacourseModel->geticListCount($param);
			$pagestr = show_page($iacount,$param['pagesize']);
			$this->assign('q',$q);
			$this->assign('pagestr',$pagestr);
			$this->assign('lists',$iacourselist);
		}
		//获取modulename
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'iacourse','tors'=>1,'crid'=>$roominfo['crid']));
		$this->display('troomv2/iacourse');
	}
	//添加发布互动
	public function add(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$post = $this->input->post();
		if(empty($post)){//展示添加页面
			$this->_getFolderList();
			$this->display('troomv2/iacourse_add');	
		}else{
			if(!empty($roominfo) && !empty($user)){
				$folderidarr = array();//关联课程id数组
				$foldernamearr = array();//关联课程name数组
				$icsparam = array();
				if(!empty($post['quesnum'])){//题目数量
					$icsparam['questioncount'] = intval($post['quesnum']);
				}
				if(!empty($post['folderid'])){//关联的课程
					foreach ($post['folderid'] as $fold) {
						$folderidarr[] = $fold[0];
						$foldernamearr[] = $fold[1];
					}
				}
				if(!empty($post['title'])){//互动标题
					$icsparam['title'] = $post['title'];
					$icsparam['crid'] = $roominfo['crid'];
					$icsparam['uid'] = $user['uid'];
					$icsparam['folderids'] = json_encode($folderidarr);
					$icsparam['foldernames'] = json_encode($foldernamearr);
					$icsparam['editdateline'] = SYSTIME;
					$iacourseModel = $this->model('iacourse');
					$icid = $iacourseModel->add($icsparam);
				}
				$qusetionarr = array();
				if(!empty($folderidarr) && !empty($icid)){
					$result = $iacourseModel->addIcFolders($icid,$folderidarr);
				}
				if(!empty($post['content']) && !empty($icid)){
					foreach ($post['content'] as $k => $conent) {//题目
						if(isset($conent['item'])){
							$qusetionarr[] = array(
									'order'=>($k+1),
									'title'=>$conent['title'],
									'type'=>($conent['type']-1),
									'crid'=>$roominfo['crid'],
									'icid'=>$icid,
									'item'=>$conent['item']
								);
						}else{
							$qusetionarr[] = array(
									'order'=>($k+1),
									'title'=>$conent['title'],
									'type'=>($conent['type']-1),
									'crid'=>$roominfo['crid'],
									'icid'=>$icid
								);
						}
					}
					$icquestionModel = $this->model('Icquestions');
					$res = $icquestionModel->addQuestion($qusetionarr);
				}
				if($result && $res){
					echo 1;
					exit;
				}else{
					echo 0;
					exit;
				}
			}
		}
	}
	//编辑互动页面
	public function edit_view(){
		$post = $this->input->post();
		if(!empty($post)){
			$icid = $this->uri->itemid;
			$roominfo = Ebh::app()->room->getcurroom();
			if(!empty($roominfo)){
				$folderidarr = array();//关联课程id数组
				$foldernamearr = array();//关联课程name数组
				$icsparam = array();
				if(!empty($post['quesnum'])){//题目数量
					$icsparam['questioncount'] = intval($post['quesnum']);
				}
				if(!empty($post['folderid'])){//关联的课程
					foreach ($post['folderid'] as $fold) {
						$folderidarr[] = $fold[0];
						$foldernamearr[] = $fold[1];
					}
				}
				if(!empty($post['title'])){//互动标题
					$icsparam['title'] = $post['title'];
					$icsparam['folderids'] = json_encode($folderidarr);
					$icsparam['foldernames'] = json_encode($foldernamearr);
					$icsparam['editdateline'] = SYSTIME;
					$iacourseModel = $this->model('iacourse');
					$res = $iacourseModel->updateIacouse($icsparam,$icid);
				}
				$qusetionarr = array();
				if(!empty($post['content']) && !empty($icid) && !empty($folderidarr)){
					foreach ($post['content'] as $k => $conent) {//题目
						if(isset($conent['item'])){
							$qusetionarr[] = array(
									'order'=>($k+1),
									'title'=>$conent['title'],
									'type'=>($conent['type']-1),
									'crid'=>$roominfo['crid'],
									'icid'=>$icid,
									'item'=>$conent['item']
								);
						}else{
							$qusetionarr[] = array(
									'order'=>($k+1),
									'title'=>$conent['title'],
									'type'=>($conent['type']-1),
									'crid'=>$roominfo['crid'],
									'icid'=>$icid
								);
						}
					}
					$icquestionModel = $this->model('Icquestions');
					//p($qusetionarr);die;
					$result = $icquestionModel->editIcquestion($qusetionarr,$icid,$folderidarr);
				}

				if($result){
					echo 1;
					exit;
				}else{
					echo 0;
					exit;
				}
			}
		}else{
			$icid = $this->uri->itemid;
			if(!empty($icid)){
				$iacourseModel = $this->model('iacourse');
				$iainfo = $iacourseModel->geticInfo($icid);//试卷信息
				$iaquestionModel = $this->model('icquestions');
				$icqinfo = $iaquestionModel->getquestionInfo($icid);
				//p($icqinfo);die;
				$question = array();
				if(!empty($icqinfo)){
					foreach ($icqinfo as $qinfo) {
						if($qinfo['type'] != 3){
							$question[$qinfo['order']][] = array('type'=>$qinfo['type'],'title'=>$qinfo['title'],'order'=>$qinfo['order'],'qid'=>$qinfo['qid'],'urlpath'=>$qinfo['urlpath'],'content'=>$qinfo['content']);
						}else{
							$question[$qinfo['order']][] = array('type'=>$qinfo['type'],'title'=>$qinfo['title'],'order'=>$qinfo['order']);
						}
					}
				}
				ksort($question);
				$this->_getFolderList();
				$this->assign('icid',$icid);
				$this->assign('iainfo',$iainfo);
				$this->assign('question',$question);
				$this->display('troomv2/icedit_view');
			}
		}
	}

	//获取我网校folderlist
	private function _getFolderList(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(!empty($roominfo) && !empty($user)){
			$Folderlist = array();
			$FolderModel = $this->model('Folder');
			$Folderlist = $FolderModel->getSchoolFolder($roominfo['crid']);
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			if($roominfo['isschool'] == 7){
				//收费分成学校
				$PaypackageModel = $this->model('Paypackage');
				$Paypackagelist = $PaypackageModel->getPackageFolders(array('crid'=>$roominfo['crid']));
				$packege = array();//服务包
				$folderids = array();//服务包中已经有的课程
				$folderidsall = array();//网校下所有课程
				$difffolder = array();//没有服务包的课程
				if(!empty($Paypackagelist) && !empty($Folderlist)){
					foreach ($Paypackagelist as $plist) {
						foreach ($Folderlist as $flist) {
							if(!in_array($flist['folderid'],$folderidsall)){
								$folderidsall[] = $flist['folderid'];
							}
							if($flist['folderid'] == $plist['folderid']){
								$plist['foldername'] = $flist['foldername'];
							}
						}
						$packege[$plist['pname']][] = $plist;
						if(!in_array($plist['folderid'],$folderids)){
							$folderids[] = $plist['folderid'];
						}
					}
					if(!empty($folderids) && !empty($folderidsall)){
						$difffolder = array_diff($folderidsall, $folderids);
						if(!empty($difffolder) && !empty($Folderlist)){
							foreach ($difffolder as $dlist) {
								foreach ($Folderlist as $fdlist) {
									if($fdlist['folderid'] == $dlist){
										$packege['其他'][] = array('folderid'=>$dlist,'foldername'=>$fdlist['foldername']);
									}
								}
							}
						}
					}
				}
				$this->assign('packege',$packege);
			}else{
				$this->assign('folders',$Folderlist);
			}
			$this->assign('roominfo',$roominfo);
		}
	}
	/**
	 * 发布互动
	 */
	public function publish(){
		$icid = intval($this->input->post('icid'));
		$user = Ebh::app()->user->getloginuser();
		if(!empty($icid) && !empty($user)){
			$iacourseModel = $this->model('iacourse');
			$res = $iacourseModel->publish($icid,$user['uid']);
			if($res){
				echo 1;
				exit;
			}else{
				echo 0;
				exit;
			}
		}
	}
	/**
	 * 删除互动
	 */
	public function del(){
		$icid = intval($this->input->post('icid'));
		$user = Ebh::app()->user->getloginuser();
		if(!empty($icid) && !empty($user)){
			$iacourseModel = $this->model('iacourse');
			$res = $iacourseModel->del($icid,$user['uid']);
			if($res){
				echo 1;
				exit;
			}else{
				echo 0;
				exit;
			}
		}
	}
	/**
	 * 分析页面
	 */
	public function view(){
		$icid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$icinfo = $this->model('iacourse')->geticInfo($icid);
		if(!empty($icid)){
			$icqModel = $this->model('iacourse');
			$check = $icqModel->checkexist($icid);
			if(empty($check)){
				header("Content-type: text/html; charset=utf-8");
				echo '该互动不存在！';
				exit;
			}
		}else{
			exit;
		}
		//p($icinfo);die;
		$this->assign('icid',$icid);
		$this->assign('user', $user);
		$this->assign('roominfo', $roominfo);
		$this->assign('room', $roominfo);
		$this->assign('icinfo',$icinfo);
		$this->display('troomv2/iacourse_view');
	}
	/**
	 * 获取详情页的实时数据
	 */
	public function detail(){
		$post = $this->input->post();
		$roominfo = Ebh::app()->room->getcurroom();
		$answertime = empty($post['answertime']) ? 0 : $post['answertime'];
		if(empty($answertime) && !empty($post['icid'])){//第一次请求
			$redis = Ebh::app()->getCache("cache_redis");
			$timecache = time();
			$redis->set('ics_'.$post['icid'],$timecache);
			if(!empty($post['icid'])){
					$type = empty($post['type'])?'analyze':$post['type'];
					if($type == 'analyze'){
						$icqModel = $this->model('icquestions');
						$icqdetail = $icqModel->getquestionInfo($post['icid']);
						$question = array();
						$iacourseModel = $this->model('iacourse');
						$icinfo = $iacourseModel->geticInfo($post['icid']);
						$folderid = json_decode($icinfo['folderids'],true);
						$param['folderids'] = implode(',',$folderid);
						$permModel = $this->model('Userpermission');
						$totalcount = $permModel->getFolderUserCount($param);
						if(!empty($icqdetail)){
							foreach ($icqdetail as &$detail) {
								if(isset($detail['title'])){
									$detail['title'] = strip_tags($detail['title']);
								}
								if(isset($detail['content'])){
									$detail['content'] = strip_tags($detail['content']);
								}
								$question[$detail['icqid']][] = $detail;
							}
							echo json_encode(array('status'=>1,'data'=>$question,'totalcount'=>$totalcount,'timecache'=>$timecache));
							exit;
						}
					}
					if($type == 'have'){
						$uri = Ebh::app()->getUri();
						$page = $uri->page;
						$icqModel = $this->model('icquestions');
						$studentlist = $icqModel->getanswerStudent(array('icid'=>$post['icid'],'crid'=>$roominfo['crid'],'page'=>$page,'pagesize'=>50));
						$studentcount = $icqModel->getanswerStudentcount($post['icid'],$roominfo['crid']);
						$pagestr = ajaxpage($studentcount,50,$page);
						if(!empty($studentlist)){
							foreach ($studentlist as &$list) {
								$list['dateline'] = date('Y-m-d H:i:s',$list['dateline']);
								$list['realname'] = empty($list['realname'])?$list['username']:$list['realname'];
								$list['realnameshort'] = shortstr($list['realname'],6);
								$list['usernameshort'] = shortstr($list['username'],6);
								$list['face'] = getavater($list);
								$list['totaltime'] = ceil($list['totaltime']/60);
							}
							echo json_encode(array('status'=>1,'pagestr'=>$pagestr,'list'=>$studentlist,'timecache'=>$timecache));
							exit;
						}else{
							echo json_encode(array('status'=>0));
							exit;
						}
					}
					if($type == 'nohave'){
						$uri = Ebh::app()->getUri();
						$page = $uri->page;
						if(empty($page)){
							$page = 1;
						}
						$icqModel = $this->model('icquestions');
						$iacourseModel = $this->model('iacourse');
						$permModel = $this->model('Userpermission');
						$havestudent = $icqModel->getanswerStudentuid($post['icid']);//读取已回答的学生列表
						$icinfo = $iacourseModel->geticInfo($post['icid']);
						$folderid = json_decode($icinfo['folderids'],true);
						$param = array();
		 				if(!empty($havestudent)){
		 					$param['filteruser'] = '';
		 					foreach ($havestudent as $student) {
		 						$param['filteruser'].= $student['uid'].',';
		 					}
		 					$param['filteruser'] = rtrim($param['filteruser'],',');
						}
						$param['folderids'] = implode(',',$folderid);
						$userlist = $permModel->getFolderUserList($param);
						if(!empty($userlist)){
							$pagestr = ajaxpage(count($userlist),60,$page);
							$list = array_chunk($userlist, 60);
							$studentlist = array();
							foreach ($list[$page-1] as $li) {
								$li['realname'] = empty($li['realname'])?$li['username']:$li['realname'];
								$li['realnameshort'] = shortstr($li['realname'],6);
								$li['usernameshort'] = shortstr($li['username'],6);
								if(empty($li['face'])){
									$li['face'] = empty($li['sex']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg' : 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_120_120.jpg';
								}
								$studentlist[] = $li;
							}
							if(!empty($studentlist)){
								echo json_encode(array('status'=>1,'pagestr'=>$pagestr,'list'=>$studentlist,'timecache'=>$timecache));
								exit;
							}else{
								echo json_encode(array('status'=>0));
								exit;
							}
						}else{
							echo json_encode(array('status'=>0));
								exit;
						}
					}
				}
		}else{
			$redis = Ebh::app()->getCache("cache_redis");
			$timecache = $redis->get('ics_'.$post['icid']);
			if($answertime != $timecache){
				if(!empty($post['icid'])){
					$type = empty($post['type'])?'analyze':$post['type'];
					if($type == 'analyze'){
						$icqModel = $this->model('icquestions');
						$icqdetail = $icqModel->getquestionInfo($post['icid']);
						$question = array();
						$iacourseModel = $this->model('iacourse');
						$icinfo = $iacourseModel->geticInfo($post['icid']);
						$folderid = json_decode($icinfo['folderids'],true);
						$param['folderids'] = implode(',',$folderid);
						$permModel = $this->model('Userpermission');
						$totalcount = $permModel->getFolderUserCount($param);
						if(!empty($icqdetail)){
							foreach ($icqdetail as &$detail) {
								if(isset($detail['title'])){
									$detail['title'] = strip_tags($detail['title']);
								}
								if(isset($detail['content'])){
									$detail['content'] = strip_tags($detail['content']);
								}
								$question[$detail['icqid']][] = $detail;
							}
							echo json_encode(array('status'=>1,'data'=>$question,'totalcount'=>$totalcount,'timecache'=>$timecache));
							exit;
						}
					}
					if($type == 'have'){
						$uri = Ebh::app()->getUri();
						$page = $uri->page;
						$icqModel = $this->model('icquestions');
						$studentlist = $icqModel->getanswerStudent(array('icid'=>$post['icid'],'crid'=>$roominfo['crid'],'page'=>$page,'pagesize'=>50));
						$studentcount = $icqModel->getanswerStudentcount($post['icid'],$roominfo['crid']);
						$pagestr = ajaxpage($studentcount,50,$page);
						if(!empty($studentlist)){
							foreach ($studentlist as &$list) {
								$list['dateline'] = date('Y-m-d H:i:s',$list['dateline']);
								$list['realname'] = empty($list['realname'])?$list['username']:$list['realname'];
								$list['realnameshort'] = shortstr($list['realname'],6);
								$list['usernameshort'] = shortstr($list['username'],6);
								$list['face'] = getavater($list);
								$list['totaltime'] = ceil($list['totaltime']/60);
							}
							echo json_encode(array('status'=>1,'pagestr'=>$pagestr,'list'=>$studentlist,'timecache'=>$timecache));
							exit;
						}else{
							echo json_encode(array('status'=>0));
							exit;
						}
					}
					if($type == 'nohave'){
						$uri = Ebh::app()->getUri();
						$page = $uri->page;
						if(empty($page)){
							$page = 1;
						}
						$icqModel = $this->model('icquestions');
						$iacourseModel = $this->model('iacourse');
						$permModel = $this->model('Userpermission');
						$havestudent = $icqModel->getanswerStudentuid($post['icid']);//读取已回答的学生列表
						$icinfo = $iacourseModel->geticInfo($post['icid']);
						$folderid = json_decode($icinfo['folderids'],true);
						$param = array();
		 				if(!empty($havestudent)){
		 					$param['filteruser'] = '';
		 					foreach ($havestudent as $student) {
		 						$param['filteruser'].= $student['uid'].',';
		 					}
		 					$param['filteruser'] = rtrim($param['filteruser'],',');
						}
						$param['folderids'] = implode(',',$folderid);
						$userlist = $permModel->getFolderUserList($param);
						if(!empty($userlist)){
							$pagestr = ajaxpage(count($userlist),60,$page);
							$list = array_chunk($userlist, 60);
							$studentlist = array();
							foreach ($list[$page-1] as $li) {
								$li['realname'] = empty($li['realname'])?$li['username']:$li['realname'];
								$li['realnameshort'] = shortstr($li['realname'],6);
								$li['usernameshort'] = shortstr($li['username'],6);
								if(empty($li['face'])){
									$li['face'] = empty($li['sex']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg' : 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_120_120.jpg';
								}
								$studentlist[] = $li;
							}
							if(!empty($studentlist)){
								echo json_encode(array('status'=>1,'pagestr'=>$pagestr,'list'=>$studentlist,'timecache'=>$timecache));
								exit;
							}else{
								echo json_encode(array('status'=>0));
								exit;
							}
						}else{
							echo json_encode(array('status'=>0));
								exit;
						}
					}
				}
			}else{
				echo json_encode(array('status'=>-1));
			}
		}
		
	}
	/**
	 * 互动题目详情
	 */
	public function detail_view(){
		$post = $this->input->post();
		if(empty($post)){
			$icqid = $this->uri->itemid;
			$type = $this->input->get('type');
			$param = parsequery();
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getloginuser();
			$iaquestionModel = $this->model('icquestions');
			$question = $iaquestionModel->getQuestionDetail($icqid);
			$param['icqid'] = $icqid;
			$param['pagesize'] = 18;
			$answerlist = $iaquestionModel->getAnswers($param);
			$answerscount = $iaquestionModel->getAnswersCount($icqid);
			$pagestr = show_page($answerscount,$param['pagesize']);
			$iacourseModel = $this->model('iacourse');
			$icinfo = $iacourseModel->geticInfo($question['icid']);
			$folderid = json_decode($icinfo['folderids'],true);
			$param['folderids'] = implode(',',$folderid);
			$permModel = $this->model('Userpermission');
			$totalcount = $permModel->getFolderUserCount($param);
			if($totalcount == 0){
				$totalcount = $question['count'];
			}
			$page = empty($param['page']) ? 1 : $param['page'];
			$this->assign('page',$page);
			$this->assign('totalcount',$totalcount);
			$this->assign('question',$question);
			$this->assign('answerlist',$answerlist);
			$this->assign('icqid',$icqid);
			$this->assign('pagestr',$pagestr);
			$this->assign('user', $user);
			$this->assign('roominfo', $roominfo);
			$this->assign('room', $roominfo);
			if($type == 2){
				$this->display('troomv2/iacourse_question_one');
			}else{
				$this->display('troomv2/iacourse_question_two');
			}
		}else{
			$icqid = $this->uri->itemid;
			$type = $this->input->get('type');
			$param = parsequery();
			$iaquestionModel = $this->model('icquestions');
			$question = $iaquestionModel->getQuestionDetail($icqid);
			$param['icqid'] = $icqid;
			$param['pagesize'] = 18;
			$answerlist = $iaquestionModel->getAnswers($param);
			$answerscount = $iaquestionModel->getAnswersCount($icqid);
			$pagestr = show_page($answerscount,$param['pagesize']);
			$iacourseModel = $this->model('iacourse');
			$icinfo = $iacourseModel->geticInfo($question['icid']);
			$folderid = json_decode($icinfo['folderids'],true);
			$param['folderids'] = implode(',',$folderid);
			$permModel = $this->model('Userpermission');
			$totalcount = $permModel->getFolderUserCount($param);
			if($totalcount == 0){
				$totalcount = $question['count'];
			}
			if(!empty($answerlist)){
				foreach ($answerlist as &$list) {
					if($type == 3){
						$list['answercontentshort'] = shortstr($list['answercontent'],220);
					}
					$list['realname'] = getusername($list,10);
					$list['dateline'] = date('Y-m-d H:i:s',$list['dateline']);
					if(empty($list['face'])){
						if(empty($list['sex'])){
							$list['face'] = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg';
						}else{
							$list['face'] = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_120_120.jpg';
						}
					}
				}
				if($totalcount == 0){
					$persent = 0;
				}else{
					$persent = ceil($answerscount/$totalcount*100);
				}
				$page = empty($param['page']) ? 1 : $param['page'];
				echo json_encode(array('status'=>1,'answerlist'=>$answerlist,'answerscount'=>$answerscount,'totalcount'=>$totalcount,'pagestr'=>$pagestr,'persent'=>$persent,'page'=>$page));
				exit();
			}else{
				echo json_encode(array('status'=>0));
				exit();
			}
		}
		
	}
	/**
	 * 实时获取互动回答人数和时间
	 */
	public function getalreadyStudent(){
		$post = $this->input->post();
		if(!empty($post['icid'])){
			$icid = $post['icid'];
			//已回答的人数
			$iacourseModel = $this->model('iacourse');
			$icinfo = $iacourseModel->geticInfo($icid);
			if(!empty($icinfo)){
				$folderid = json_decode($icinfo['folderids'],true);
				$param['folderids'] = implode(',',$folderid);
				$permModel = $this->model('Userpermission');
				$totalcount = $permModel->getFolderUserCount($param);
				if(!empty($totalcount)){
					if($totalcount == 0){
						$persent = 0;
					}else{
						$persent = ceil($icinfo['answercount']/$totalcount*100);
					}
					if($icinfo['answercount'] == 0){
						$time = 0;
					}else{
						$time = ceil($icinfo['totaltime']/60/$icinfo['answercount']);
					}
					echo json_encode(array('status'=>1,'totalcount'=>$totalcount,'answercount'=>$icinfo['answercount'],'time'=>$time,'persent'=>$persent));
					exit;
				}else{
					$persent = 100;
					if($icinfo['answercount'] == 0){
						$time = 0;
						$persent = 0;
					}else{
						$time = ceil($icinfo['totaltime']/60/$icinfo['answercount']);
					}
					echo json_encode(array('status'=>1,'totalcount'=>$icinfo['answercount'],'answercount'=>$icinfo['answercount'],'time'=>$time,'persent'=>$persent));
					exit;
				}
			}
		}
	}
	//查看学生结果
	public function student_show_view(){
		$studentuid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $icid = $this->input->get('icid');
        $icquestionsModel = $this->model('icquestions');
		$questions = $icquestionsModel->getListByIcid(array(
			'icid' => $icid
		));
		$param = array(
			'uid' => $studentuid,
			'icid' => $icid,
			'crid' => $roominfo['crid']
		);
		$answers =  $this->model('icanswers')->getAnswers($param);
		$data = array();
		foreach ($answers as $answer) {//以题号作为键名
			$data[$answer['qid']] = $answer;
		}
		$answers = $data;
		$ics = $this->model('ics')->getIcsById($icid);
		//p($ics);die;
		$this->assign('questions', $questions);
		$this->assign('ics', $ics);
        $this->assign('user', $user);
		$this->assign('roominfo', $roominfo);
		$this->assign('room',$roominfo);
		$this->assign('answers', $answers);
		$this->display('troomv2/iacourseshow');
	}
	//上传图片页面
	public function uploadimage() {
		$upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('upcontrol', $upcontrol);
		$this->display('troomv2/iacourse_uploadimage');
	}
}