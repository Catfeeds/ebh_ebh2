<?php

/**
 * 帮助中心的常见问题列表页
 */

class FaqController extends CControl {
    public function index() {
        $this->_show_help();
    }
	function _show_help() {
		$helpmodel = $this->model('help');
		$q = $this->input->get('q');
		$queryparam = parsequery();
		$pagesize = $queryparam['pagesize'];
		$page = $queryparam['page'];
		$offset = max(0,($page-1)*$pagesize);
		$param['limit'] = $offset.','.$pagesize;
		$param['q']= $q;
		$param['catid'] = intval($this->uri->uri_attr(0));
		$itemlist = $helpmodel->gethelplist($param);
		$this->assign('itemlist', $itemlist);
		$count = $helpmodel->gethelpcount($param);
		$this->assign('page',show_page($count,$pagesize));
		$this->display('common/faq');
	}
	function view(){
		$param['catid'] = $this->uri->itemid;
		$helpmodel = Ebh::app()->model('help');
		$itemdetail = $helpmodel->getitembyid($param);
		$this->assign('itemdetail', $itemdetail);
		$this->display('common/faq_view');
	}

}
?>