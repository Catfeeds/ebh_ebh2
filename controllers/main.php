<?php

/**
 * 免费超市列表页
 */
class MainController extends PortalControl {
    public function index() {
        //暂时不用的程序 先跳转到404
        show_404();
        exit;
        
        $this->_show_main();
    }
	function _show_main() {
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		//免费超市列表	
		$coursewaremodel  = $this->model('courseware');
		$sortmode = $this->uri->sortmode;
		$q = $this->input->get('q');
		if($sortmode==1){
			$orderarr = 'cr.displayorder asc,r.crid';
		}elseif($sortmode==2){
			$orderarr = 'c.viewnum desc';
		}elseif($sortmode==3){
			$orderarr = 'c.dateline desc';
		}else{
			$orderarr = 'c.cwid desc';
		}
		$pageinfo = parsequery();
		$pagesize = $pageinfo['pagesize'];
		$page = $pageinfo['page'];
		$offset = max(($page-1)*$pagesize,0);
		$limit = $offset.','.$pagesize;
		$param = array('sortmode'=>$sortmode,'status'=>1,'keyname'=>$q,'displayorder'=>$orderarr,'limit'=>$limit);
		$courschachekey = $this->cache->getcachekey('courseware',$param);
		$param2 = array('sortmode'=>$sortmode,'status'=>1,'keyname'=>$q);
		$ccountcachekey = $this->cache->getcachekey('courseware',$param2);
		$courselistCount = $this->cache->get($ccountcachekey);
		$courselist = $this->cache->get($courschachekey);
		if(empty($courselist)) {
			$courselist = $coursewaremodel->getallcourseware($param);
			$this->cache->set($courschachekey,$courselist,86400);
		}
		if(empty($courselistCount)) {
			$courselistCount = $coursewaremodel->getallcoursewareCount($param2);
			$this->cache->set($ccountcachekey,$courselistCount,86400);
		}
		$this->assign('showpage',show_page($courselistCount));
		$this->getLatestCourseware();
        $this->assign('courselist', $courselist);
        $this->assign('courselistCount',$courselistCount);
		$this->display('common/main');
	}
	/**
	 *获取最新的十条课件
	 */
	private function getLatestCourseware(){
		//免费超市列表	
		$coursewaremodel  = $this->model('courseware');
		$status = 1;
		$isfree = 1;
		$orderarr = 'c.dateline desc';
		$limit = '0,10';
		$param = array('status'=>1,'isfree'=>1,'displayorder'=>$orderarr,'limit'=>$limit);
		$courschachekey = $this->cache->getcachekey('courseware',$param);
		$latestlist = $this->cache->get($courschachekey);
		if(empty($courselist)) {
			$latestlist = $coursewaremodel->getallcourseware($param);
			$this->cache->set($courschachekey,$latestlist,86400);
		}
        $this->assign('latestlist', $latestlist);
	}
}
?>
