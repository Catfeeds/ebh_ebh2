<?php
/**
 *学生互动课堂控制器
 */
class IacourseController extends CControl{
	public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->db = Ebh::app()->getDb();
		$this->assign('check',$check);
    }
    //默认方法
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$ics = $this->model('ics');
		$param = parsequery();
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$param['pagesize'] = 20;
		$q = $param['q'];
		$lists = $ics->getListByRoom($param);
		$total = $ics->getListCount($param);
		$upModel = $this->model('userpermission');
		foreach ($lists as &$list) {
			$param = array();
			$param['folderids'] = implode(',',json_decode($list['folderids']));
			$list['studentNums'] = $upModel->getFolderUserCount($param); //对于每一个互动获取其参与总数
			$list['hasJoined'] = $ics->checkIfJoined($user['uid'], $list['icid'],$roominfo['crid']); //根据用户id和互动id判断是否参与过该互动
			$list['title'] = shortstr($list['title'],60);
			$teacher = $this->model('user')->getuserbyuid($list['uid']);
			$list['teacher'] = $teacher['realname'] ? $teacher['realname']: $teacher['username'];
		}
		$paginate = show_page($total);
		$this->assign('q',$q);
		$this->assign('lists', $lists);
		$this->assign('roominfo', $roominfo);
		$this->assign('user', $user);
		$this->assign('paginate', $paginate);
		$this->display('college/iacourseindex');
	}
	//ajax 关键词搜索
	public function search(){
		$keywords = $this->input->post('keywords');
		$crid = $this->input->post('crid');
		$uid = $this->input->post('uid');
		$ics = $this->model('ics');
		$lists = $ics->getListByKeywords(array(
			'crid' => $crid,
			'keywords' => $keywords,
			'uid' => $uid
		));
		$upModel = $this->model('userpermission');
		foreach ($lists as &$list) {
			$param['folderids'] = implode(',',json_decode($list['folderids']));
			$list['studentNums'] =  $upModel->getFolderUserCount($param); //对于每一个互动获取其参与总数
			$list['hasJoined'] = $ics->checkIfJoined($uid, $list['icid'],$crid); //根据用户id和互动id判断是否参与过该互动
			$list['dateline'] = timetostr($list['dateline']);
			$list['title'] =  shortstr(strip_tags($list['title']),60);
			$teacher = $this->model('user')->getuserbyuid($list['uid']);
			$name = $teacher['realname'] ? $teacher['realname']: $teacher['username'];
			$list['teacher'] = shortstr($name,10);
		}
		$datas = array(
			'lists' => $lists,
		);
		echo json_encode($datas);
	}
	//参与互动
	public function answer(){

		$user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $icid = $this->input->get('icid');
        $icquestionsModel = $this->model('icquestions');
		$questions = $icquestionsModel->getListByIcid(array(
			'icid' => $icid
		));
		$roominfo = Ebh::app()->room->getcurroom();
		$ics = $this->model('ics')->getIcsById($icid);
		$this->assign('questions', $questions);
		$this->assign('ics', $ics);
        $this->assign('user', $user);
		$this->assign('roominfo', $roominfo);
		$this->assign('starttime', SYSTIME);
		$this->assign('room',$roominfo);
		$this->display('college/iacourseanswer');
	}
	//问题展示
	public function question(){
		$roominfo = Ebh::app()->room->getcurroom();
		$imgsrc = $this->input->get('imgsrc');
		$title = $this->input->get('title');
		$this->assign('title', $title);
		$this->assign('imgsrc', $imgsrc);
		$this->assign('room',$roominfo);
		$this->display('college/iacoursequestion');
	}
	
	//提交答卷
	public function save(){
		$answers = $this->input->post();
		$res = array_column($answers['answer'],'value');
		$flag = implode('', $res);
		if(empty($flag)){
			echo json_encode(array('status'=>1));exit;
		}
		$uid = $answers['uid'];
		$icid = $answers['icid'];
		$crid = $answers['crid'];
		$startTime = $answers['starttime'];
		//验证是否已经回答过
		$ics = $this->model('ics');
		if($ics->checkIfJoined($uid,$icid,$crid)){
			echo json_encode(array('status'=>0));return;
		}
		$data = array();
		$qids = array();
		foreach ($answers['answer'] as $answer) {
			if(!empty($answer['value'])){
				$pos1 = strpos($answer['name'], '_');
				$temp = explode('_', $answer['name']);
				$qid = (int)$temp[1];
				array_push($qids,$qid);
				$data[$qid][]=$answer['value'];
			}
  		}
  		//答案入库
  		// $this->db = Ebh::app()->getDb();
  		$icquestionsModel = $this->model('icquestions');
  		$chosen = array();
  		foreach ($data as $key => $item) {
  			$icquestion = $icquestionsModel->getQuestionDetailByIcqid($key);
  			if($icquestion['type'] == 0 || $icquestion['type'] == 1){//单选题或者多选题存json穿
  				$param = array(
  					'uid' => $uid,
  					'qid' => $key,
  					'icid' => $icid,
  					'crid' => $crid,
  					'dateline' => SYSTIME,
  					'totaltime' => SYSTIME-$startTime,
  					'answercontent' => json_encode($item)
  				);
  				$icquestionsModel->addAnswer($param);
  				$param['hasOptions'] = true;
  			}else{
  				$param = array(
  					'uid' => $uid,
  					'qid' => $key,
  					'icid' => $icid,
  					'crid' => $crid,
  					'dateline' => SYSTIME,
  					'totaltime' => SYSTIME-$startTime,
  					'answercontent' => $item[0]
  				);
  				$icquestionsModel->addAnswer($param);
  				$param['hasOptions'] = false;
  			}
  			array_push($chosen, $param);
  		}
  		//人数统计
  		$icsModel = $this->model('ics');
  		$redis = Ebh::app()->getCache('cache_redis');
  		$redis->set('ics_'.$icid,SYSTIME);
  		$icsModel->increaseTotaltime($icid, SYSTIME-$startTime);
  		$this->increaseNum($icid, $qids, $chosen);
  		echo json_encode(array('status'=>1));
	}

	//查看结果
	public function show(){
		$user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $icid = $this->input->get('icid');
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
        $icquestionsModel = $this->model('icquestions');
		$questions = $icquestionsModel->getListByIcid(array(
			'icid' => $icid
		));
		$param = array(
			'uid' => $user['uid'],
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
		$this->assign('questions', $questions);
		$this->assign('ics', $ics);
        $this->assign('user', $user);
		$this->assign('roominfo', $roominfo);
		$this->assign('room',$roominfo);
		$this->assign('answers', $answers);
		$this->display('college/iacourseshow');
	}

	//未参加的互动数量
	public function unfishCount(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$ics = $this->model('ics');
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		echo $ics->getUnJoinedNum($param);

	}
	//获取答题详情
	public function detail(){
		$post = $this->input->post();
		$roominfo = Ebh::app()->room->getcurroom();
		$answertime = empty($post['answertime']) ? 0 : $post['answertime'];
		if(empty($answertime) && !empty($post['icid'])){//第一次请求
			$redis = Ebh::app()->getCache("cache_redis");
			$timecache = time();
			// $redis->set('ics_'.$post['icid'],$timecache);
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
						$studentlist = $icqModel->getanswerStudent(array('icid'=>$post['icid'],'crid'=>$roominfo['crid'],'page'=>$page,'pagesize'=>18));
						$studentcount = $icqModel->getanswerStudentcount($post['icid'],$roominfo['crid']);
						$pagestr = ajaxpage($studentcount,18,$page);
						if(!empty($studentlist)){
							foreach ($studentlist as &$list) {
								$list['dateline'] = date('Y-m-d H:i:s',$list['dateline']);
								$list['realname'] = empty($list['realname'])?$list['username']:$list['realname'];
								$list['realname'] = shortstr($list['realname'],10);
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
								$li['realname'] = shortstr($li['realname'],10);
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
						$studentlist = $icqModel->getanswerStudent(array('icid'=>$post['icid'],'crid'=>$roominfo['crid'],'page'=>$page,'pagesize'=>18));
						$studentcount = $icqModel->getanswerStudentcount($post['icid'],$roominfo['crid']);
						$pagestr = ajaxpage($studentcount,18,$page);
						if(!empty($studentlist)){
							foreach ($studentlist as &$list) {
								$list['dateline'] = date('Y-m-d H:i:s',$list['dateline']);
								$list['realname'] = empty($list['realname'])?$list['username']:$list['realname'];
								$list['realname'] = shortstr($list['realname'],10);
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
								$li['realname'] = shortstr($li['realname'],10);
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
	//计数器
	//$icid 互动id $qids 问题id $chosen 答案
	private function increaseNum($icid,$qids,$chosen){
		//互动回答人数加1
		$this->model('ics')->increaseAnswercount($icid);
		//题目回答的人数加1 参数问题id数组
		$this->model('icquestions')->increaseCount($qids);
		//题目选项加1 参数
		$this->model('icquestions')->increaseCountOfOptions($chosen);
	}
}