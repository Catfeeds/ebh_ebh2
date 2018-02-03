<?php
/**
 * 企业选课
 */
class SchsourceController extends CControl {
	public function __construct(){
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
	 * 选课列表
	 */
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['isschool'] != 7){
			exit;
		}
		$ssmodel = $this->model('Schsource');
		$selecteditems = $ssmodel->getselecteditems(array('crid'=>$roominfo['crid']));
		if(empty($selecteditems)){
			// echo json_encode(array());
			exit;
		}
		$user = Ebh::app()->user->getloginuser();
		$umodel = $this->model('Userpermission');
		$itemids = array_keys($selecteditems);
		$itemids = implode(',',$itemids);
		$itemparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'itemids'=>$itemids);
		$openids = $umodel->getPermissionByItemids($itemparam);//已开通的
		$openids = array_keys($openids);
		foreach($selecteditems as $k=>$sitem){
			if(in_array($sitem['itemid'],$openids)){//已开通
				$selecteditems[$k]['paid'] = TRUE;
			} elseif($sitem['del'] == 1){//没开通，又被删除的
				unset($selecteditems[$k]);
			}
		}
		if(empty($selecteditems)){
			// echo json_encode(array());
			exit;
		}
		$showitemids = array_column($selecteditems,'itemid');
		$showitemids = implode(',',$showitemids);
		$showitemlist = $ssmodel->getItemList(array('itemids'=>$showitemids));//需要显示的课程（开通，未开通）
		$openarr = array();
		$unopenarr = array();
		$sortarr = array();
		$sparr = array();
		
		$folderlist = $this->model('Payitem')->getFolderListByItemids($showitemids);
		foreach($showitemlist as $k=>$showitem){
			$itemid = $showitem['itemid'];
			$showitem['img'] = $folderlist[$itemid]['img'];
			$showitem['price'] = $selecteditems[$itemid]['price'];
			$showitem['sourceid'] = $selecteditems[$itemid]['sourceid'];
			$showitem['name'] = $selecteditems[$itemid]['name'];
			if(!empty($selecteditems[$itemid]['paid'])){//已开通课程
				$openarr[$showitem['sourceid']][] = $showitem;
			} else {//未开通课程
				if(!empty($folderlist[$itemid]) && $folderlist[$itemid]['del'] ==0){
					$unopenarr[$showitem['sourceid']][] = $showitem;
				}
			}
		}
		$this->assign('roominfo',$roominfo);
		$this->assign('openarr',$openarr);
		$this->assign('unopenarr',$unopenarr);
		$this->display('college/schsource');
	}
	
	/*
	获取课程信息
	*/
	public function getItem(){
		$itemid = $this->input->get('itemid');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['itemid'] = $itemid;
		$item = $this->model('Schsource')->getSelectedItems($param);
		if(!empty($item)){
			$itemid = array_keys($item);
			$itemid = $itemid[0];
			$folder = $this->model('Payitem')->getFolderListByItemids($itemid);
			$theitem = array_merge($item[$itemid],$folder[$itemid]);
			echo json_encode($theitem);
		}
	}
}