<?php
/**
 * 原创空间列表页
 */
class SpaceController extends PortalControl {
    public function index() {
		exit();
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
        $this->_show_space();
    }
	function _show_space() {
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$uptype = 'space';
		$showpath = $_UP[$uptype]['imagepath'];
		$this->assign('showpath',$showpath);
		//最新原创列表
		$spacemodel = $this->model('space');
        $param = array('ispublic'=>1,'displayorder'=>'id desc','limit'=>'0,25');
		$uploadcachekey = $this->cache->getcachekey('space',$param);
        $uploadslist = $this->cache->get($uploadcachekey);
        if(empty($uploadslist)) {
            $uploadslist = $spacemodel->getuploadslist($param);
			$this->cache->set($uploadcachekey,$uploadslist,300);
        }
        $this->assign('uploadslist', $uploadslist);

		//原创排行榜列表
		$member = $this->model('member');
		$param = array('displayorder'=>'spacenum desc','limit'=>'0,16');
		$memberkey = $this->cache->getcachekey('member',$param);
        $memberlist = $this->cache->get($memberkey);
        if(empty($memberlist)) {
			$memberlist = $member->getmemberlist($param);
			$this->cache->set($memberkey,$memberlist,300);
        }
		$this->assign('memberlist',$memberlist);

		//原创空间热评原创
		
        $param = array('ispublic'=>1,'displayorder'=>'reviewnum desc,displayorder,up.dateline desc','limit'=>'0,24');
		$hotchachekey = $this->cache->getcachekey('space',$param);
		$hotlist = $this->cache->get($hotchachekey);
		if(empty($hotlist)) {
            $hotlist = $spacemodel->getuploadslist($param);
			$this->cache->set($hotchachekey,$hotlist,300);
		}
        $this->assign('hotlist', $hotlist);

		//原创空间精彩推荐
        $param = array('ispublic'=>1,'displayorder'=>'best desc,displayorder,up.dateline desc','limit'=>'0,24');
		$bestchachekey = $this->cache->getcachekey('space',$param);
		$bestlist = $this->cache->get($bestchachekey);
		if(empty($bestlist)) {
            $bestlist = $spacemodel->getuploadslist($param);
			$this->cache->set($bestchachekey,$bestlist,300);
		}
        $this->assign('bestlist', $bestlist);
		$subtitle = '原创空间';
		$this->assign('subtitle',$subtitle);
		$this->display('common/space');
	}
	//原创作品详细信息 
	public function view(){
		exit();
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$uptype = 'space';
		$showpath = $_UP[$uptype]['imagepath'];
		$this->assign('showpath',$showpath);
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$spmodel = $this->model('space');
		$id = $this->uri->itemid;
		$param = array('id'=>$id,'ispublic'=>1);
		$spacekey = $this->cache->getcachekey('space',$param);
		$infor = $this->cache->get($spacekey);
		if(empty($infor)) {
			$infor = $spmodel->getspacedetails($param);
			$this->cache->set($spacekey,$infor,300);
		}
		$this->assign('infor', $infor);

		//作品评论
		$reviewparam = parsequery();
		$reviewmodel = $this->model('review');
		$reviewparam['toid'] = $id;
		$reviewparam['opid'] = 8192;
		$reviewparam['order'] = 'r.logid desc';

		$reviews = $reviewmodel->getreviewlist($reviewparam);
		$count = $reviewmodel->getreviewcount($reviewparam);
		$pagestr = show_page($count);
		$this->assign('reviews', $reviews);
		$this->assign('pagestr',$pagestr);
		$this->display('common/space_view');
	}
	/**
	* 原创空间下载
	*/
	public function down() {
		$id = $this->input->get('id');
		if(is_numeric($id) && $id > 0) {
			$user = Ebh::app()->user->getloginuser();
			if(!empty($user)) {
				$spacemodel = $this->model('Space');
				$spacedetail = $spacemodel->getspacedetail($id);
				if(!empty($spacedetail) && $user['uid'] == $spacedetail['uid']) {
					$url = $spacedetail['data'];
					$filename = $spacedetail['title'].'.ebhf';
					getfile('space',$url,$filename);
				}
			}
		}
	}
	/**
	* 投票处理
	*/
	public function vote() {
		$id = $this->input->post('id');
		if(NULL === $id) {
			echo 'error';
			exit();
		}
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo 'nologin';
			exit();
		}
		$voteanswer = $this->input->post('voteanswer');
		if(empty($voteanswer)) {
			echo 'error';
			exit();
		}
		$spacemodel = $this->model('Space');
		$myspace = $spacemodel->getSimpleById($id);
		if(empty($myspace)) {
			echo 'error';
			exit();
		}
		$reviewmodel = $this->model('Review');
		$logparam = array('uid'=>$user['uid'],'opid'=>8192,'toid'=>$id,'type'=>'member','value'=>0);	//value 0为投票，不需要加入review表 1为评论 需要加入review表
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次投票
			echo 'thatday';
			exit();
		}
		$vote = 'good';
		$goodnum = $myspace['good'];
		$generalnum = $myspace['general'];
		$badnum = $myspace['bad'];
		if($voteanswer=='general'){
			$vote = 'general';
			$generalnum = $generalnum + 1;
		}elseif($voteanswer=='bad'){
			$vote = 'bad';
			$badnum = $badnum + 1;
		} else {
			$goodnum = $goodnum + 1;
		}
		//计算新增加的分值
		$addscore = $spacemodel->getNewAddScore($vote,$myspace['score']);
		$param = array('id'=>$id,'score'=>($addscore + $myspace['score']),'votenum'=>($myspace['votenum']+1),'general'=>$generalnum,'bad'=>$badnum,'good'=>$goodnum);
		$result = $spacemodel->editspace($param);
		if($result > 0) {
			//插入log日志
			$logparam['fromip'] = $this->input->getip();
			$reviewmodel->insertlog($logparam);
			echo 'success';
			exit();
		}
		echo 'error';
		exit();

	}
	/**
	*提交评论
	*/
	public function comment() {
		$id = $this->input->post('id');
		if(NULL === $id) {
			echo 'error';
			exit();
		}
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo 'nologin';
			exit();
		}
		$content = $this->input->post('content');
		$evaluate = $this->input->post('evaluate');
		if(empty($content) || empty($evaluate)) {
			echo 'error';
			exit();
		}
		$spacemodel = $this->model('Space');
		$myspace = $spacemodel->getSimpleById($id);
		if(empty($myspace)) {
			echo 'error';
			exit();
		}
		$reviewmodel = $this->model('Review');
		$logparam =  array('uid'=>$user['uid'],'toid'=>$id,'opid'=>8192,'type'=>'member','value'=>1,'dateline'=>time());//value 0为投票，不需要加入review表 1为评论 需要加入review表
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次投票
			echo 'thatday';
			exit();
		}
		$logparam['credit'] = 0;
		$logparam['subject'] = $content;
		if($evaluate =='best'){
			$logparam['good']=1;	
		}elseif($evaluate == 'bad'){
			$logparam['bad'] = 1;
		}
		$fromip = $this->input->getip();
		$logparam['fromip'] = $fromip;
		
		$logid = $reviewmodel->insert($logparam);
		$result = 0;
		if($logid > 0) {
			$param = array('id'=>$id,'reviewnum'=>($myspace['reviewnum']+1));
			$result = $spacemodel->editspace($param);
		}
		if($result > 0) {
			echo 'success';
			exit();
		}
		echo 'error';
		exit();
	}
}
?>
