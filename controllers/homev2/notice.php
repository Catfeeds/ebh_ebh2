<?php
/**
 * 消息通知
 */
class NoticeController extends CControl {
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		Ebh::app()->user->checkUserLogin($this->user ,true);
		$this->assign('user',$this->user);
		$this->getassigintop();
	}

	/**
	 * 我的通知
	 */
	public function index(){
		$user = $this->user;
		//网校列表
		if($user['groupid']=='5'){//老师
			$roommodel = $this->model('Classroom');
			$roomlist = $roommodel->getroomlistbytid($this->user['uid']);
		}elseif($user['groupid']=='6'){
			$roomlist = $this->model('classroom')->getroomlistbyuid($this->user['uid']);
		}

		if (empty($roomlist)){
			$notices = array();
			$pagestr = '';
		} else {
			$crids = array();
			foreach ($roomlist as $room){
				$crids[] = $room['crid'];
			}

			$noticemodel = $this->model('Notice');
			$param = parsequery();
			$param['crids'] = $crids;
			$param['uid'] = $this->user['uid'];
			$param['ntype'] = '1,3,4,5';
			$param['needgrade'] = true;
			$param['needdistrict'] = true;
			$notices = $noticemodel->getallnoticelist($param);
           // 查询通知的阅读状态
			foreach ($notices as $key => $val) {
				if($noticemodel->getusernotice($user['uid'],$val['noticeid'])){
					$notices[$key]['readed']=1;
				}else{
					$notices[$key]['readed']=0;
				}
			}
			
			$count = $noticemodel->getallnoticecount($param);
			$pagestr = show_page($count);
		}

		
		$this->assign('notices',$notices);
		$this->assign('pagestr',$pagestr);
		$this->display('homev2/notice');
	}

	/*通知详情*
	*
	*/
	public function view() {
		$noticeid = $this->uri->itemid;
		$noticemodel = $this->model('Notice');
		$notice = $noticemodel->getNoticeByNoticeid($noticeid );

		if (empty($notice)){
			$this->assign('notice',$notice);
			$this->display('homev2/notice_view');
		}
		//检查用户是否在该网校内
		$user = Ebh::app()->user->getloginuser();
		$crmodel = $this->model('classroom');
		if($user['groupid']==6)
			$roomuser = $crmodel->checkstudent($user['uid'],$notice['crid']);
		else
			$roomteacher = $crmodel->checkteacher($user['uid'],$notice['crid']);
		if((!empty($roomuser)&&$roomuser==1) || (!empty($roomteacher)&&$roomteacher==1)){
			$noticemodel->addviewnum($noticeid);
		//判断该条通知是否已读，否则加入记录
		$readedlist = $noticemodel->getusernotice($user['uid'],$noticeid);
		if(!$readedlist){
			$noticemodel->adduserviewnum($user['uid'],$noticeid);
		}		
		if(!empty($notice['attid'])){
			$attmodel = $this->model('attachment');
			$attfile = $attmodel->getAttachByIdForNotice($notice['attid']);
			$this->assign('attfile',$attfile);
		}
		$this->assign('notice',$notice);
		$this->display('homev2/notice_view');
		}
	}

    /**
     * 获取top信息
     */
    public function getassigintop(){
    	$user = $this->user;
    	//uri
    	$this->assign('controller',$this->uri->uri_control());
    	$this->assign('action',$this->uri->uri_method());
        $clinfo = array();
        $clinfo['title']='';
    	if($user['groupid']==5){//老师
    		//积分等级
    		$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
    		foreach($clconfig as $clevel){
    			if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
    				$clinfo['title'] = $clevel['title'];
    				if($user['credit']<=500){
    					$clinfo['percent'] = 50*intval($user['credit'])/500;
    				}elseif($user['credit']<=3000){
    					$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
    				}elseif($user['credit']<=10000){
    					$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
    				}else{
    					$clinfo['percent'] = 100;
    				}
    				break;
    			}
    		}
    	}elseif($user['groupid']==6){//学生
    		//积分等级
    		$clconfig = Ebh::app()->getConfig()->load('creditlevel');
    		foreach($clconfig as $clevel){
    			if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
    				$clinfo['title'] = $clevel['title'];
    				if($user['credit']<=500){
    					$clinfo['percent'] = 50*intval($user['credit'])/500;
    				}elseif($user['credit']<=3000){
    					$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
    				}elseif($user['credit']<=10000){
    					$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
    				}else{
    					$clinfo['percent'] = 100;
    				}
    				break;
    			}
    		}
    	}
    	$this->assign('clinfo',$clinfo);
    	//完成度百分比
    	$percent = Ebh::app()->user->getpercent($this->user);
    	$this->assign('percent',$percent);
    	
    	//粉丝
    	$snsmodel = $this->model('Snsbase');
    	$mybaseinfo = $snsmodel->getbaseinfo($this->user['uid']);
    	$myfanscount = max(0,$mybaseinfo['fansnum']);
    	//关注
    	$myfavoritcount = max(0,$mybaseinfo['followsnum']);
    	$this->assign('myfanscount',$myfanscount);
    	$this->assign('myfavoritcount',$myfavoritcount);
    }
}