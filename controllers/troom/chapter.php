<?php
/**
 *知识点控制器
 */
class ChapterController extends CControl{
	public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
		$this->roominfo = Ebh::app()->room->getcurroom();
		$this->user = Ebh::app()->user->getloginuser();
    }
    /**
     * 知识点浏览
     */
	public function index(){
		$versionlist = $this->model('mychapter')->getversionlist($this->roominfo['crid']);
		$this->assign('versionlist', $versionlist);
		$this->display('troom/chapter');
	}

	/**
	 * AJAX获取知识点列表。
	 */
	public function getnodelist() {
		$result['chapterlist'] = array();
		$versionid = $this->input->post('versionid');
		$crid = $this->roominfo['crid'];
		if(empty($versionid)) {
			echo json_encode($result);
			exit;
		}
		if($crid>0) {
			$result['chapterlist']	= $this->model('mychapter')->getnodelist($crid, $versionid);
		}

		echo json_encode($result);
	}
}