<?php
/**
 * 学校通知控制器类 NoticeController
 */
class NoticeController extends CControl{
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	/**
	* 我接收的通知列表
	*/
    public function index() {

		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		if(empty($myclass)) {
			$notices = array();
			$pagestr = '';
		} else {
			$noticemodel = $this->model('Notice');
			$param = parsequery();
			$param['crid'] = $roominfo['crid'];
			$param['ntype'] = '1,3,4,5';
			$param['classid'] = $myclass['classid'];
			$param['needgrade'] = true;
			$param['needdistrict'] = true;
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
		}
		
		$this->assign('notices',$notices);
		$this->assign('pagestr',$pagestr);
		$this->display('college/notice');
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
			//判断该条通知是否已读，未读则加入记录
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
            $conf = Ebh::app()->getConfig()->load('othersetting');
            $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
            $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
            $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
            $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
            $this->assign('iszjdlr',$is_zjdlr);
            $this->assign('isnewzjdlr',$is_newzjdlr);
			$this->assign('room',$roominfo);
			$this->assign('roominfo',$roominfo);
			$this->assign('user',$user);
			$this->assign('notice',$notice);
			$this->display('college/notice_view');
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
        $params['explains'] = trim($explains);
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
