<?php
/**
 * Description of setting
 *
 * @author Administrator
 */
class SettingController extends CControl {
	private $user = NULL;
	private $degreearr = array(
    	1 => '高中',
    	2 => '中专',
    	3 => '大专',
    	4 => '本科',
    	5 => '硕士',
    	6 => '博士'
    );
    public function __construct() {
        parent::__construct();
        $user = Ebh::app()->user->getloginuser();
        if(empty($user) || $user['groupid'] != 5) {
            $url = geturl('login').'?returnurl='.  geturl('troom');
            header("Location: $url");
            exit();
        }
		$this->user = $user;
    }
    public function index() {
        
    }
    public function profile() {
        
    }
    /*
     * 教师基本信息显示
     */
    public function rprofile() {
        $teachermodel = $this->model('Teacher');
        $teacher = $teachermodel->getteacherdetail($this->user['uid']);
        $teacher['bankcard'] = unserialize($teacher['bankcard']);
        $editor = Ebh::app()->lib('UMEditor');
        $explist = $this->model('experiences')->getList($this->user['uid']);
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->assign('teacher', $teacher);
        $this->assign('editor', $editor);
        $this->assign('degreearr', $this->degreearr);
        $this->assign('explist', $explist);
        $this->display('teacher/rprofile');
    }

    /**
     * 管理员编辑教师基本信息
     */
	public function rprofile_view() {
		$uid = $this->uri->itemid;
		//检查权限
		if ($this->_checkprivilege($uid) === FALSE)
		{
			show_404();
			exit;
		}
        $this->assign('is_admin_edit', TRUE);//是管理员编辑本页面，而不是教师自己编辑。

        $teachermodel = $this->model('Teacher');
        $teacher = $teachermodel->getteacherdetail($uid);
        $teacher['bankcard'] = unserialize($teacher['bankcard']);
        $editor = Ebh::app()->lib('UMEditor');
        $explist = $this->model('experiences')->getList($uid);
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->assign('teacher', $teacher);
        $this->assign('editor', $editor);
        $this->assign('degreearr', $this->degreearr);
        $this->assign('explist', $explist);
        $this->display('teacher/rprofile');
    }
    /**
     * 更新教师基本信息
     */
    public function updateinfo() {
		$param = $this->input->post('data');
		$param = array_map(function(&$v){return h($v);}, $param);
		if (empty($param['uid']))
		{
			echo json_encode(array('code' => 2, 'message'=> '保存失败'));
			exit;
		}

		//不是本人编辑的，判断管理员编辑权限。
		if ($this->user['uid'] != $param['uid'])
		{
			if ($this->_checkprivilege($param['uid']) === FALSE)
			{
				echo json_encode(array('code' => 2, 'message'=> '没有权限'));
				exit;
			}
		}
		else
		{
			//教师编辑只在姓名为空时允许修改
			if(!empty($param['realname'])){
				$memberdetail = $this->model('teacher')->getteacherdetail($param['uid']);
				if(!empty($memberdetail['realname'])){
					log_message('illegal realname change!');
					exit;
				}
			}
			else
			{
				unset($param['realname']);
			}
		}
		if(isset($param['birthdate']))
		{
			$param['birthdate'] = strtotime($param['birthdate']);
		}
		$param['message'] = $param['vitae_message'];
		$res =  $this->model('teacher')->editteacher($param);
		if($res){
			unset($param['uid']);
			unset($param['message']);
			if(!isset($param['realname']))
			{
				$param['realname'] = '';
			}
			if(isset($param['sex']))
			{
				$param['sex'] = $param['sex'] == 1 ? '女' : '男';
			}
			if(isset($param['birthdate']))
			{
				$param['birthdate'] = date('Y-m-d', $param['birthdate']);
			}
			if(!empty($param['degree']) && array_key_exists($param['degree'], $this->degreearr))
			{
				$param['degree'] = $this->degreearr[$param['degree']];
			}
			else
			{
				$param['degree'] = '';
			}
			echo json_encode(array('code' => 1, 'value' => $param, 'message' => '保存成功'));
			
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>3));
		}
		else
		{
			echo json_encode(array('code' => 2, 'message'=> '保存失败或没有修改项'));
		}
	}
    /**
     * 修改头像
     */
    public function avatar() {
        $user = Ebh::app()->user->getloginuser();
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$avatar = $_UP['avatar']['server'];
	  	$scount = count($_UP['avatar']['server']);
        $spos = rand(0, $scount - 1);
        $uploadurl = $_UP['avatar']['server'][$spos];
        $picurl = $uploadurl.'?uid='.$this->user['uid'];
        $this->assign('picurl',$picurl);
        $this->assign('user', $user);
        $this->display('teacher/avatar');
    }
    
	/**
	*修改密码
	*/
	public function pass() {
		$this->display('teacher/pass');
	}
	/*
	旧密码确认
	*/
	public function checkoldpassword(){
		$user = Ebh::app()->user->getloginuser();
		if($user['password']!=md5($this->input->post('oldpwd')))
			echo 0;
		else echo 1;
	}
	/*
	旧密码确认
	*/
	public function checknewpassword(){
		$user = Ebh::app()->user->getloginuser();
		if($user['password']==md5($this->input->post('newpwd')))
			echo 1;
		else echo 0;
	}
	/*
	修改密码操作
	*/
	public function updatepass(){
		$user = Ebh::app()->user->getloginuser();
		$teacher = $this->model('Teacher');
		if($user['password']==md5($this->input->post('oldpwd'))){
			$param['password'] = $this->input->post('newpwd');
			$param['uid'] = $user['uid'];
			$result = $teacher->editteacher($param);
			if($result !== FALSE) {
				echo 1;
				exit;
			}
		} 
		echo 0;
	}
	
	public function avatarold(){
		$user = Ebh::app()->user->getloginuser();
		$teachermodel = $this->model('Teacher');
        $teacher = $teachermodel->getteacherdetail($user['uid']);
		$this->assign('sourcepath',$teacher['face']);
		$this->display('teacher/avatar_old');
	}
	
	public function eqprofile(){
		$editor = Ebh::app()->lib('UMEditor');
		$user = Ebh::app()->user->getloginuser();
		$teachermodel = $this->model('Teacher');
		$teacher = $teachermodel->getteacherdetail($user['uid']);
		$this->assign('editor',$editor);
		$this->assign('teacher',$teacher);
		$this->display('teacher/eqprofile');
	}
	
	public function eqavatar(){
		$this->assign('user',$this->user);
		$this->display('teacher/eqavatar');
	}

	/**
	 * ajax修改签名
	 */
	public function editmysign(){
		$mysign = h($this->input->post('mysign'));
		$uid = $this->user['uid'];
		$data['code'] = 0;//修改成功标志，1表示成功，0表示失败
		$data['mysign'] = '';//返回的已截取的字符串
		if (mb_strlen($mysign, 'UTF8') <= 140)
		{
			if ($this->model('user')->update(array('mysign' => $mysign), $uid))
			{
				$data['code'] = 1;
				if (empty($mysign))
				{
					$data['mysign'] = '暂无签名';
				}
				else
				{
					$data['mysign'] = shortstr($mysign,20);
				}
			}
		}
		echo json_encode($data);
	}

	/**
	 * 添加过往经历
	 */
	public function addexperience(){
		$param['begindate'] = h($this->input->post('begindate'));
		$param['enddate'] = h($this->input->post('enddate'));
		$param['description'] = h($this->input->post('description'));
		$param['uid'] = intval($this->input->post('uid'));

		//不是本人编辑的，判断管理员编辑权限。
		if ($this->user['uid'] != $param['uid'])
		{
			if ($this->_checkprivilege($param['uid']) === FALSE)
			{
				echo json_encode(array('code' => 2, 'message'=> '没有权限'));
				exit;
			}
		}

		$res = $this->model('experiences')->addExperience($param);
		if($res)
		{
			echo json_encode(array('code' => 1, 'message' => '添加成功', 'expid' => $res));
		}
		else
		{
			echo json_encode(array('code' => 2, 'message'=> '添加失败'));
		}
	}

	/**
	 * 编辑过往经历
	 */
	public function editexperience(){
		$param['expid'] = intval($this->input->post('expid'));
		$param['begindate'] = h($this->input->post('begindate'));
		$param['enddate'] = h($this->input->post('enddate'));
		$param['description'] = h($this->input->post('description'));
		$param['uid'] = intval($this->input->post('uid'));

		//不是本人编辑的，判断管理员编辑权限。
		if ($this->user['uid'] != $param['uid'])
		{
			if ($this->_checkprivilege($param['uid']) === FALSE)
			{
				echo json_encode(array('code' => 2, 'message'=> '没有权限'));
				exit;
			}
		}

		//判断该条经历是否属于当前用户
		$experience = $this->model('experiences')->getOne($param['expid']);
		if ($param['uid'] != $experience['uid'])
		{
			log_message('非法编辑不属于自己的过往经历!');
			exit;
		}

		//保存
		$res = $this->model('experiences')->editExperience($param);
		if($res)
		{
			echo json_encode(array('code' => 1, 'message' => '编辑成功'));
		}
		else
		{
			echo json_encode(array('code' => 2, 'message'=> '编辑失败或没有修改项'));
		}
	}

	/**
	 * 删除过往经历
	 */
	public function delexperience(){
		$expid = intval($this->input->post('expid'));
		$uid = intval($this->input->post('uid'));

		//不是本人编辑的，判断管理员编辑权限。
		if ($this->user['uid'] != $uid)
		{
			if ($this->_checkprivilege($uid) === FALSE)
			{
				echo json_encode(array('code' => 2, 'message'=> '没有权限'));
				exit;
			}
		}

		//判断该条经历是否属于当前用户
		$experience = $this->model('experiences')->getOne($expid);
		if ($uid != $experience['uid'])
		{
			log_message('非法删除不属于自己的过往经历!');
			exit;
		}

		//保存
		$res = $this->model('experiences')->delExperience($expid);
		if($res)
		{
			echo json_encode(array('code' => 1, 'message' => '删除成功'));
		}
		else
		{
			echo json_encode(array('code' => 2, 'message'=> '删除失败'));
		}
	}

	/**
	 * 检查管理员权限和该教师是否是本网校的
	 * @param  integer $uid 教师编号
	 * @return boolean      true有权限false无权限
	 */
	public function _checkprivilege($uid) {
		//检查管理员权限
		$haspower = Ebh::app()->room->checkRoomControl();
		if ($haspower != 1)
		{
			return FALSE;
		}

		$roominfo = Ebh::app()->room->getcurroom();
		$roommodel = $this->model('Classroom');

		//检查该教师是否是本网校的
        $check = $roommodel->checkteacher($uid, $roominfo['crid']);
        if ($check == -1)
        {
            return FALSE;
        }
        return TRUE;
	}

}
