<?php
/**
 * 原创空间列表页
 */
class Space1Controller extends PortalControl {
    public function index() {
		exit();
		echo 11;
		$user = Ebh::app()->user->getloginuser();
		echo 22;
        $this->assign('user', $user);
		echo 33;
        //$this->_show_space();
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
}
?>
