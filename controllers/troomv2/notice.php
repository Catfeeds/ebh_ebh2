<?php
/**
 * 学校通知控制器类 NoticeController
 */
class NoticeController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
	/**
	* 已接收通知列表
	*/
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$myclasslist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classlist = array();
		foreach($myclasslist as $myclass) {
			$classlist[$myclass['classid']] = $myclass;
		}
		$noticemodel = $this->model('Notice');
		$param = parsequery();
		$param['type'] = '0';
        $param['crid'] = $roominfo['crid'];
        $param['ntype'] = '1,2';
		$notices = $noticemodel->getnoticelist($param);
	    // 查询通知的阅读状态
        $idarr = array();
        $nidarr = array();
        $idarr = array_column($notices,'noticeid');
        $res=$noticemodel->getusernotice($user['uid'],$idarr);
        $nidarr=array_column($res,'noticeid');
        foreach ($notices as $key => $value) {
            if(in_array($value['noticeid'],$nidarr)){
                $notices[$key]['readed']=1;
            }else{
            	$notices[$key]['readed']=0;
            }
        }
		$count = $noticemodel->getnoticelistcount($param);
		$pagestr = show_page($count);

		$this->assign('classlist',$classlist);
		$this->assign('notices',$notices);
		$this->assign('pagestr',$pagestr);
        $this->display('troomv2/notice');
    }
	
	/**
	* 已发送通知列表
	*/
    public function sent() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$myclasslist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classlist = array();
		foreach($myclasslist as $myclass) {
			$classlist[$myclass['classid']] = $myclass;
		}
		$noticemodel = $this->model('Notice');
		$param = parsequery();
		$param['type'] = '1';
		$param['ntype'] = '4';
        $param['crid'] = $roominfo['crid'];
        $param['uid'] = $user['uid'];
		$notices = $noticemodel->getnoticelist($param);
		$count = $noticemodel->getnoticelistcount($param);
		$pagestr = show_page($count);
		$this->assign('classlist',$classlist);
		$this->assign('notices',$notices);
		$this->assign('pagestr',$pagestr);
        $this->display('troomv2/notice_sent');
    }
	/*通知详情*
	*
	*/
	public function view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$noticeid = $this->uri->itemid;
		$noticemodel = $this->model('Notice');
		$param = array('crid'=>$roominfo['crid'],'noticeid'=>$noticeid);
		$notice = $noticemodel->getNoticeDetail($param);
		if(!empty($notice)) {
			$noticemodel->addviewnum($noticeid);
           //判断该条通知是否已读，否则加入记录
			$readedlist = $noticemodel->getusernotice($user['uid'],$noticeid);
			if(!$readedlist){
				$noticemodel->adduserviewnum($user['uid'],$noticeid,$user['groupid']);
			}
			if(!empty($notice['attid'])){
				$attmodel = $this->model('attachment');
				$attfile = $attmodel->getAttachByIdForNotice($notice['attid']);
				$this->assign('attfile',$attfile);
			}
			//如果通知绑定回执了，需要判断用户是否已经填写了回执.获取回执的详情
			if (!empty($notice['isreceipt'])) {
				//回执说明
				$this->apiServer = Ebh::app()->getApiServer('ebh');
				$parameters['crid'] = $roominfo['crid'];
				$parameters['uid'] = $user['uid'];
				$parameters['noticeid'] = $noticeid;
				$explains = $this->apiServer->reSetting()->setService('College.NoticeReceipt.detail')->addParams($parameters)->request();
				if (!empty($explains)) {
					$notice['receiptInfo'] = $explains;
				}
			}
			$this->assign('roominfo',$roominfo);
			$this->assign('user',$user);
			$this->assign('room',$roominfo);
			$this->assign('notice',$notice);
			$this->display('troomv2/notice_view');
		}
	}

	/**
     * 发布回执
     */
    public function addReceipt() {
    	$user = Ebh::app()->user->getloginuser();
    	$roominfo = Ebh::app()->room->getcurroom();
        $explains = $this->input->post('explains');
        if ($explains === NULL) {
            $this->renderjson(1, '内容不能为空');
        }
        $noticeid = intval($this->input->post('noticeid'));
        if ($noticeid < 1) {
            $this->renderjson(1, 'param error');
        }
        $choice = intval($this->input->post('choice'));
        $params = array();
        $params['crid'] = $roominfo['crid'];
        $params['uid'] = $user['uid'];
        $params['explains'] = safefilter(trim($explains));
        $params['noticeid'] = $noticeid;
        $params['choice'] = $choice;
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        $ret = $this->apiServer->reSetting()
            ->setService('College.NoticeReceipt.add')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '添加失败');
        }
        $this->renderjson(0, '添加成功', $ret);
    }

	/**
	* 收到的通知
	*/
	public function receive() {
		$roominfo = Ebh::app()->room->getcurroom();
		$noticemodel = $this->model('Notice');
		$param = parsequery();
		$param['ntype'] = '1,2';
		$param['crid'] = $roominfo['crid'];
		$notices = $noticemodel->getnoticelist($param);
		$count = $noticemodel->getnoticelistcount($param);
		$pagestr = show_page($count);
		$this->assign('notices',$notices);
		$this->assign('pagestr',$pagestr);
		$this->display('troomv2/notice_receive');
	}
	/**
	*发送通知
	*/
	public function send() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$noticeto = $this->input->post('noticeto');
		$p = $this->input->post();
		if(NULL !== $noticeto) {	//处理表单
			$noticetitle = $this->input->post('noticetitle');
			$noticecontent = $this->input->post('noticecontent');
			if(empty($noticetitle) || empty($noticecontent) || !is_array($noticeto)) {
				echo 0;
				exit();
			}
			foreach($noticeto as $cid) {
				if(!is_numeric($cid) || $cid <= 0) {
					echo 0;
					exit();
				}
			}
			$cids = implode(',',$noticeto);
			$ip = getip();
			$param = array('ip'=>$ip,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'title'=>$noticetitle,'message'=>$noticecontent,'ntype'=>4,'cids'=>$cids,'type'=>1);
			$noticemodel = $this->model('Notice');
			$result = $noticemodel->addNotice($param);
			if($result > 0) {
				echo 1;

                fastcgi_finish_request();
                //发布通知操作成功后记录到操作日志
                if (!empty($param['title']) && is_numeric($result)) {
                    $logdata = array();
                    $logdata['toid'] = $result;                 //通知的id
                    $logdata['title'] = h($param['title']);    //新通知名称
                    Ebh::app()->lib('OperationLog')->addLog($logdata,'addnotice');
                }
			} else {
				echo 0;
			}
		} else {
			$editor = Ebh::app()->lib('UEditor');
			$classes = $this->model('classes');
			$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
			$this->assign('editor',$editor);
			$this->assign('classlist',$classlist);
			$this->display('troomv2/notice_send');
		}
	}
	/**
	*删除通知
	*/
	public function del() {
		$roominfo = Ebh::app()->room->getcurroom();
		$noticeid = $this->input->post('nid');
		if(!is_numeric($noticeid) || $noticeid <= 0) {
			echo 0;
			exit();
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'],'noticeid'=>$noticeid);
        //获取原通知消息信息（用于记录操作日志）
        $oldnotice = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Information.getNotice')
            ->addParams('crid', $roominfo['crid'])->addParams('noticeid', $noticeid)->request();

		$noticemodel = $this->model('Notice');
		$result = $noticemodel->deleteNotice($param);
		if($result > 0){
            echo 1;
            fastcgi_finish_request();
            //删除通知操作成功后记录到操作日志
            if (!empty($oldnotice['title'])) {
                $logdata = array();
                $logdata['toid'] = $noticeid;
                $logdata['title'] = h($oldnotice['title']);
                Ebh::app()->lib('OperationLog')->addLog($logdata,'delnotice');
            }
        }else{
            echo 0;
        }
	}
	public function edit_view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$noticeid = $this->uri->itemid;
		$noticemodel = $this->model('Notice');
		$param = array('crid'=>$roominfo['crid'],'noticeid'=>$noticeid);
		$notice = $noticemodel->getNoticeDetail($param);
		if(!empty($notice)) {
			$classes = $this->model('classes');
			$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
			$editor = Ebh::app()->lib('UEditor');
			$this->assign('editor',$editor);
			$this->assign('classlist',$classlist);
			$this->assign('notice',$notice);
			$this->display('troomv2/notice_edit');
		}
		
	}
	/**
	*编辑通知提交表单处理
	*/
	public function edit() {
		$noticeid = $this->input->post('noticeid');
		if(!is_numeric($noticeid) || $noticeid <= 0) {
			echo 0;
			exit();
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$noticeto = $this->input->post('noticeto');
		$noticetitle = $this->input->post('noticetitle');
		$noticecontent = $this->input->post('noticecontent');
		if(empty($noticetitle) || empty($noticecontent) || !is_array($noticeto)) {
			echo 0;
			exit();
		}
		foreach($noticeto as $cid) {
			if(!is_numeric($cid) || $cid <= 0) {
				echo 0;
				exit();
			}
		}
		$cids = implode(',',$noticeto);
		$param = array('noticeid'=>$noticeid,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'title'=>$noticetitle,'message'=>$noticecontent,'cids'=>$cids);
        //获取原通知消息信息（用于记录操作日志）
        $oldnotice = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Information.getNotice')
            ->addParams('crid', $roominfo['crid'])->addParams('noticeid', $noticeid)->request();

		$noticemodel = $this->model('Notice');
		$result = $noticemodel->updateNotice($param);
		if($result !== FALSE) {
			echo 1;
            fastcgi_finish_request();
            //编辑通知操作成功后记录到操作日志
            if (!empty($oldnotice['title']) && !empty($param['title'])) {
                $logdata = array();
                $logdata['toid'] = $noticeid;
                $logdata['oldtitle'] = h($oldnotice['title']);  //原通知名称
                $logdata['title'] = h($param['title']);         //新通知名称
                Ebh::app()->lib('OperationLog')->addLog($logdata,'editnotice');
            }
		} else {
			echo 0;
		}
	}

	/**
     * json格式输出
     * @param number $code 状态标识 0 成功 1 失败
     * @param string $msg 输出消息
     * @param array $data 数组参数数组
     * @param string $exit 是否结束退出
     */
    function renderjson($code=0,$msg="",$data=array(),$exit=true){
        $arr = array(
            'code'=>(intval($code) ===0) ? 0 : intval($code),
            'msg'=>$msg,
            'data'=>$data
        );
        //echo json_encode($arr,JSON_UNESCAPED_UNICODE);
        echo json_encode($arr);
        if($exit){
            exit();
        }
    }
	
}
