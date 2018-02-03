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
		$this->display('myroom/msg_message');
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
		$this->display('myroom/msg_answer');

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

}