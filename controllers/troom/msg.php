<?php
/**
 * 教师私信控制器
 */
class MsgController extends CControl{
	private $check = NULL;
	public function __construct()
	{
		parent::__construct();
		//ajax获取私信前先判断是否登录
		$method = $this->uri->uri_method();//获取控制器方法
		if ($method == 'getcount'){
			$user = Ebh::app()->user->getloginuser();
			if(empty($user)){
				echo 'User login error.';
				exit;
			}
		}

		Ebh::app()->room->checkteacher();
	}

	/**
	 * 默认页面
	 */
	public function index()
	{
		$this->message();
	}

	/**
	 * 新私信
	 */
	public function message()
	{
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['toid'] = $user['uid'];
		$queryarr['typelist'] = '1,3';//类型为系统信息和私信
		$msglist = $this->model('message')->getMsgList($queryarr);
		$count = $this->model('message')->getMsgCount($queryarr);
		$pagestr = show_page($count);

		//批量更新为已读状态
		Ebh::app()->lib('EMessage')->resetMessageCount($queryarr['toid'],$roominfo['crid'], 1);//更新系统消息
		Ebh::app()->lib('EMessage')->resetMessageCount($queryarr['toid'],$roominfo['crid'], 3);//更新新私信
		Ebh::app()->lib('EMessage')->resetMessageCount($queryarr['toid'],$roominfo['crid'], 6);//更新打赏私信
		$this->assign('msglist', $msglist);
		$this->assign('pagestr', $pagestr);
		$this->display('troom/msg_message');
	}

	/**
	 * 新问题
	 */
	public function question()
	{
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['toid'] = $user['uid'];
		$queryarr['type'] = 5;//类型为新提问
		$msglist = $this->model('message')->getMsgList($queryarr);
		$count = $this->model('message')->getMsgCount($queryarr);
		$pagestr = show_page($count);

		//批量更新为已读状态
		Ebh::app()->lib('EMessage')->resetMessageCount($queryarr['toid'],$roominfo['crid'], $queryarr['type']);

		$this->assign('msglist', $msglist);
		$this->assign('pagestr', $pagestr);
		$this->display('troom/msg_question');

	}

	/**
	 * 新回答
	 */
	public function answer()
	{
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['toid'] = $user['uid'];
		$queryarr['type'] = 2;//类型为新回答
		$msglist = $this->model('message')->getMsgList($queryarr);
		$count = $this->model('message')->getMsgCount($queryarr);
		$pagestr = show_page($count);

		//批量更新为已读状态
		Ebh::app()->lib('EMessage')->resetMessageCount($queryarr['toid'],$roominfo['crid'], $queryarr['type']);

		$this->assign('msglist', $msglist);
		$this->assign('pagestr', $pagestr);
		$this->display('troom/msg_answer');

	}

	/**
	 * 新评论
	 */
	public function review()
	{
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['toid'] = $user['uid'];
		$queryarr['type'] = 4;//类型为新回答
		$msglist = $this->model('message')->getMsgList($queryarr);
		$count = $this->model('message')->getMsgCount($queryarr);
		$pagestr = show_page($count);

		//批量更新为已读状态
		Ebh::app()->lib('EMessage')->resetMessageCount($queryarr['toid'],$roominfo['crid'], $queryarr['type']);

		$this->assign('msglist', $msglist);
		$this->assign('pagestr', $pagestr);
		$this->display('troom/msg_review');

	}

	/**
	 * 已发私信列表
	 */
	public function sendlist()
	{
		$user = Ebh::app()->user->getloginuser();
		$queryarr = parsequery();
		$queryarr['fromid'] = $user['uid'];
		$queryarr['type'] = '3';//类型为系统信息和私信
		$msglist = $this->model('message')->getMsgList($queryarr);
		$count = $this->model('message')->getMsgCount($queryarr);
		$pagestr = show_page($count);

		$this->assign('msglist', $msglist);
		$this->assign('pagestr', $pagestr);
		$this->display('troom/msg_sendlist');

	}

	/**
	 * 发私信
	 */
	public function send()
	{
		$toid = $this->input->get('toid');
		$touser = array();
		if(!empty($toid)){
			$touser = $this->model('user')->getuserbyuid($toid);
			$touser['tname'] =empty($touser['realname']) ? $touser['username'] : $touser['realname'];
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();		
        $classlist = $this->model('classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$this->assign('classlist', $classlist);

		//获取教师列表
		$grouplist = $this->model('tgroups')->getList(array('crid' => $roominfo['crid']));
		$teachers = $this->model('teacher')->getroomteacherlist($roominfo['crid'],array(
			'schoolname'=>$user['schoolname'],
			'groupid' => true,
			'limit'=>1000
		));

		
		$grouparray = array();
		if (empty($grouplist))
		{
			//没有分组的情况下，增加一个所有教师的分组，并将教师分到该分组
			$grouparray['all'] = array('groupname' => '所有教师');
			$grouparray['all']['teacherlist'] = $teachers;
		}
		else
		{
			//格式化教师分组
			foreach ($grouplist as $value)
			{
				$grouparray[$value['groupid']] = $value;

			}			
			$grouparray['other'] = array('groupname' => '未分组');//增加一个教师组，名称为未分组
			//将教师分到对应分组中
			foreach ($teachers as $value)
			{
				//排除自己
				if ($value['uid'] == $user['uid'])
				{
					continue;
				}
				if (array_key_exists($value['groupid'], $grouparray))
				{
					$grouparray[$value['groupid']]['teacherlist'][] = $value;
				}
				else
				{
					$grouparray['other']['teacherlist'][] = $value;
				}

			}
		}

		//获取学生列表
/*		$students = array();
		if(!empty($myclass)) {
			$queryarr = parsequery();
			$queryarr['classid'] = $myclass['classid'];
			$queryarr['pagesize'] = 200;
			$students = $this->model('classes')->getClassStudentList($queryarr);
		}*/

		$this->assign('touser', $touser);
		$this->assign('user',$user);
		//$this->assign('students',$students);
		$this->assign('grouparray',$grouparray);
		$this->display('troom/msg_send');
	}

	/**
	 * ajax发私信
	 */
	public function do_send()
	{
		$toid = intval($this->input->post('tid'));
		$msg = h($this->input->post('msg'));
		$user = Ebh::app()->user->getloginuser();
		//内容不超过500个字符
		if(strlen($msg) <= 0 || mb_strlen($msg, 'UTF8') > 500)
		{
			echo '0';
			exit;
		}

		if($toid <= 0)
		{
			echo '0';
			exit;
		};

		//发送信息
		if (!empty($user))
		{
			$fromid = $user['uid'];
			$fromname = empty($user['realname']) ? $user['username'] : $user['realname'];
			if(Ebh::app()->lib('EMessage')->sendMessage($fromid,$fromname,$toid,0,3,$msg))
			{
				echo '1';
				exit;
			}
		}
		echo '0';
		exit;
	}


	/**
	 * ajax获取新私信数
	 */
	public function getcount()
	{
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($user) || empty($roominfo)) {
			echo json_encode(array('total'=>0));
			exit();
		}
		$unreadlist = Ebh::app()->lib('EMessage')->getUnReadCount($user['uid'],$roominfo['crid']);
		$data = array();
		$data['total'] = 0;
		if (!empty($unreadlist))
		{
			foreach ($unreadlist as $key => $value)
			{
				$data['type_' . $key] = intval($value);
				$data['total'] += $value;
			}
		}
		echo json_encode($data);
	}

	/**
	 * ajax获取某个班级的学生
	 * @return [type] [description]
	 */
	public function getStudents()
	{
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classlist = $this->model('classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classid = $this->input->post('classid');
		$classid = empty($classid) ? 0 : intval($classid);

		//验证classid是否在获取列表内
		$verify = false;
		foreach ($classlist as $tclass) {
			if ($tclass['classid'] == $classid) {
				$verify = true;
				break;
			}
		}

		$studentarray = array();
		if ($verify && !empty($classid))
		{
			$queryarr = array();
			$queryarr['classid'] = $classid;
			$queryarr['pagesize'] = 200;
			$studentlist = $this->model('classes')->getClassStudentList($queryarr);

			foreach ($studentlist as $key => $value) {
				$student = array();
				if(empty($value['face'])){
					if($value['sex'] == 1) {
						$value['face'] = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					} else {
						$value['face'] ='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					}
				}
					$student['uid'] = $value['uid'];
					$student['showname'] = empty($value['realname']) ? $value['username'] : $value['realname'];
					$student['face'] = getthumb($value['face'],'50_50');
					$studentarray[] = $student;
				}
			}


		echo json_encode($studentarray);
	}

}