<?php
/**
 * 搜索网校课件页
 */
class SearchsController extends PortalControl {
	private $showtag;
    public function index() {
    	$this->_init_showtag();
    	if($this->_if_showall()){
    		$this->assign('showall',true);
    		$this->_search_course(8);
    		$this->_search_room(6);
    	}else{

    		if($this->_if_showcourse()){
    			$this->assign('showcourse',true);
    			$this->_search_course();
    		}
    		if($this->_if_showroom()){
    			$this->assign('showroom',true);
    			$this->_search_room();
    		}
    	}
		$this->display('common/search2');
    }

    //教室搜索
	function _search_room($pagesize=0) {
 
		$param = parsequery();
		if(!empty($pagesize)){
			$param['pagesize'] = $pagesize;
		}
		$param['status'] = 1;
		// $param['filterorder'] = 20000;
		$param['order'] = 'displayorder ASC,crid DESC';
        $roommodel  = $this->model('Classroom');
        $roomlist = $roommodel->getRoomListForSearch($param);
        $roomlistCount = $roommodel->getRoomListCountForSearch($param);
        $pagestr_room = show_page($roomlistCount,$param['pagesize']);
        $this->assign('roomlist',$roomlist);
        $this->assign('pagestr_room',$pagestr_room);
        $this->assign('hasmore_room',($roomlistCount > $param['pagesize']));
	}

	//课件搜索
	function _search_course($pagesize=0) {
		$coursewaremodel  = $this->model('courseware');
		$q = $this->input->get('q');
		$param = parsequery();
		if(!empty($pagesize)){
			$param['pagesize'] = $pagesize;
		}
		$param['status'] = 1;
		$param['q'] = $q;
		$param['displayorder'] = 'cw.cwid desc';
		
		$coursecount = $coursewaremodel->getcoursecounts($param);
		$courselist = $coursewaremodel->getcourselists($param);
		$this->assign('coursecount',$coursecount);
		$this->assign('courselist', $courselist);
		$pagestr_course = show_page($coursecount,$param['pagesize']);
		$this->assign('pagestr_course',$pagestr_course);
		$this->assign('hasmore_course',($coursecount > $param['pagesize']));
	}

	private function _init_showtag(){
		//显示课件 0001,显示教室 0010
		$showtag = $this->uri->uri_attr(0);
		if(empty($showtag)){
			$showtag = bindec('1111');
		}
		$showtag = bindec('0010');
		$this->showtag = $showtag;
	}

	private function _if_showcourse(){
		return (bindec('0001') & $this->showtag) ? true : false;
	}

	private function _if_showroom(){
		return (bindec('0010') & $this->showtag) ? true : false;
	}

	private function _if_showall(){
		return ($this->showtag == bindec('1111'));
	}
}
?>
