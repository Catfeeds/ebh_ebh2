<?php
/*
*学习大纲
*/
class OnlinexamController extends CControl {
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$this->_show_stores();
    }
	function _show_stores(){
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//学习大纲左侧菜单列表
		$folder = $this->model('folder');
		$param = array('crid'=>$crid,'upid'=>1,'examnum'=>1,'limit'=>'0,1000');
		$folderlist = $folder->getfolderlist($param);
		foreach($folderlist as &$arr){
			$roomusermodel = $this->model('courseware');
			$folderid = $arr['folderid'];
			$param = array('folderid'=>$folderid,'examnum'=>1,'crid'=>$crid);
			$arr['count'] = $roomusermodel->getexamcounts($param); 
		}
		$this->assign('folderlist', $folderlist);
		//学习大纲作业列表显示
		$courseware = $this->model('courseware');
		$itemid = $this->uri->itemid;
		$params = parsequery();
		if(!empty($itemid)){
			$params['crid'] = $crid;
			$params['folderid'] = $itemid;
			$params['examnum'] = 1;
			$params['displayorder'] = 'rc.cdisplayorder,cwid desc';
			$params['pagesize'] = 20;
		}else{
			$params['crid'] = $crid;
			$params['examnum'] = 1;
			$params['displayorder'] = 'rc.cdisplayorder,cwid desc';
			$params['pagesize'] = 20;
		}
		$courselist = $courseware->getstudylist($params);
		foreach($courselist as &$arr){
			$exam = $this->model('exam');
			$param = array('cwid'=>$arr['cwid'],'order'=>'e.dateline desc','limit'=>'0,1000');
			$arr['examlist'] = $exam->getexamlistbycwid($param);
		}
		$this->assign('courselist',$courselist);
		//作业数量
		$examcount = $courseware->getexamcounts($params);
		$this->assign('examcount', $examcount);
		//分页
		$coursecount = $courseware->getstudycount($params);
		$pagestr = show_page($coursecount,$params['pagesize']);
		$this->assign('coursecount', $coursecount);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->display('shop/stores/onlinexam');
	}
	function view(){
		$this->_show_stores();
	}
}
?>
