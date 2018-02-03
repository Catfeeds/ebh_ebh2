<?php
/**
 * 学生私信控制器
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

		$roominfo = Ebh::app()->room->getcurroom();
		$check = true;
		if ($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7)
		{
			$check = Ebh::app()->room->checkstudent(true);
		}
		else
		{
			Ebh::app()->room->checkstudent();
		}
		$this->check = $check;
		$this->assign('roominfo', $roominfo);
		$this->assign('check', $check);
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

		$this->assign('msglist', $msglist);
		$this->assign('pagestr', $pagestr);
		$this->display('college/msg_message');
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
		$queryarr['type'] = 2;//类型为回答
		$msglist = $this->model('message')->getMsgList($queryarr);
		$count = $this->model('message')->getMsgCount($queryarr);
		$pagestr = show_page($count);

		//批量更新为已读状态
		Ebh::app()->lib('EMessage')->resetMessageCount($queryarr['toid'],$roominfo['crid'], $queryarr['type']);

		$this->assign('msglist', $msglist);
		$this->assign('pagestr', $pagestr);
		$this->display('college/msg_answer');

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

		//判断是否是jsonp方式
		$callback = $this->input->get('callback');
		if (empty($callback))
		{
			echo json_encode($data);
		}
		else
		{
			//jsonp方式
			echo $callback.'('.json_encode($data).')';
		}
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
		$class = $this->model('classes')->getClassByUid($roominfo['crid'],$user['uid']);
		$classid = $class['classid'];
		if(!empty($classid))
			$teacheruids = $this->model('classes')->getClassTeacherByClassid($classid);
		$uidarr = array();
		if(!empty($teacheruids)){
			foreach($teacheruids as $teacher){
				$uidarr[]= $teacher['uid'];
			}
			// $uids = rtrim($uids,',');
			$teacherlist = $this->model('user')->getUserInfoByUid($uidarr);
		}else{
		    $teacherlist = array();
		}
	
	

		$this->assign('touser', $touser);
		$this->assign('user',$user);
		$this->assign('teacherlist',$teacherlist);
		$this->display('college/msg_send');
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
		$this->display('college/msg_sendlist');

	}
	
	
	/**
	 * ajax获取某个班级的学生
	 * @return [type] [description]
	 */
	public function getStudents()
	{
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$class = $this->model('classes')->getClassByUid($roominfo['crid'],$user['uid']);
		// $classid = $this->input->post('classid');
		// $classid = empty($classid) ? 0 : intval($classid);

		//验证classid是否在获取列表内
		// $verify = false;
		// foreach ($classlist as $tclass) {
			// if ($tclass['classid'] == $classid) {
				// $verify = true;
				// break;
			// }
		// }
		$classid = $class['classid'];
		$studentarray = array();
		if (!empty($classid))
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