<?php
/**
 * 原创空间列表页
 */
class SpacelistController extends PortalControl {
    public function index() {
//		exit();
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
        $this->_show_space();
    }
	function _show_space() {
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$uptype = 'space';
		$showpath = $_UP[$uptype]['imagepath'];
		$this->assign('showpath',$showpath);
		//推荐
		$spacemodel = $this->model('space');
		$param = array('ispublic'=>1,'displayorder'=>'best desc','limit'=>'0,10');
		$spacechachekey = $this->cache->getcachekey('space',$param);
		$bestlist = $this->cache->get($spacechachekey);
		if(empty($bestlist)) {
            $bestlist = $spacemodel->getuploadslist($param);
            $this->cache->set($spacechachekey,$bestlist,86400);
        }
        $this->assign('bestlist', $bestlist);

		//热评
        $param = array('ispublic'=>1,'displayorder'=>'reviewnum desc','limit'=>'0,10');
		$hotchachekey = $this->cache->getcachekey('space',$param);
		$hotlist = $this->cache->get($hotchachekey);
		if(empty($hotlist)) {
            $hotlist = $spacemodel->getuploadslist($param);
            $this->cache->set($hotchachekey,$hotlist,86400);
		}
        $this->assign('hotlist', $hotlist);

		//原创者个人资料
		$username = $this->input->get('key');
		if(empty($username))
			$pinfor = array();
		else {
			$usermodel = $this->model('user');
			$pinfor = $usermodel->selectedprofile($username);
		}
        $this->assign('pinfor', $pinfor);

		//查找原创空间
		$type = $this->uri->viewmode;
		if($type=='hot'){
			$ordertype='reviewnum desc';
		}elseif($type=='best'){
			$ordertype='best desc';
		}elseif($type=='spacedateline'){
			$ordertype='up.dateline desc';
		}else{
			$ordertype='up.dateline desc';
		}
		$param = parsequery();
		$param['ispublic'] = 1;
		$param['displayorder'] = $ordertype;
		$param['pagesize'] = 25;
		$param['q'] = $username;
		$spacekey = $this->cache->getcachekey('space',$param);
		$spacelists = $this->cache->get($spacekey);
		if(empty($spacelists)) {
			$lists = $spacemodel->getuploadslist($param);
			$count = $spacemodel->getuploadslistcount($param);
			$spacelists = array('list'=>$lists,'count'=>$count);
			$this->cache->set($spacekey,$spacelists,300);	//缓存5分钟
		}else{
			$lists = $spacelists['list'];
			$count = $spacelists['count'];
		}
		$pagestr = show_page($count);
		$this->assign('lists', $lists);
		$this->assign('pagestr', $pagestr);
		$this->display('common/spacelist');
	}
}
?>
