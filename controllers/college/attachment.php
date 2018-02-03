<?php

/**
 * 资料下载
 */
class AttachmentController extends CControl {
	private $check = 1;
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->check = $check;
        $this->assign('roominfo',$roominfo);
		$this->assign('check',$check);
    }
	
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$requireFolderid = $this->input->get('folderid');
		if(!is_numeric($requireFolderid) || $requireFolderid < 0){
			echo '课程不存在,请刷新页面重试';
            exit();
		}
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		$q = $this->input->get('q');
        $itemid = intval($this->input->get('itemid'));
		$queryarr = parsequery();
		$queryarr['folderid'] = $folderid;
		$attmodel = $this->model('attachment');
		$attlist = $attmodel->getAttachByFolderid($queryarr);
		EBH::app()->helper('fileico');
		foreach ($attlist as $k=>$att) {
            $attlist[$k]['csize'] = $this->getsize($att['size']);
            $attlist[$k]['ico'] = format_ico($att['suffix']);
		}
		$this->assign('attlist',$attlist);
		
		$serverutil = Ebh::app()->lib('ServerUtil');
		$source = $serverutil->getCourseSource();
		$this->assign('source',$source);
		
        $this->assign('q', $q);
		
		
		if($folder['fprice'] > 0 && $roominfo['isschool'] == 7) {
			$perparam = array('crid'=>$roominfo['crid'],'folderid'=>$folder['folderid']);
			if($this->check == 1) {	//有学校权限，那就判断是否有课程权限
				$this->check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
				
			}
			$this->assign('check',$this->check);
		}
		$free = !empty($folder['isschoolfree']);
		if ($itemid > 0 && ($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $this->check != 1) {
            $pitemmodel = $this->model('Payitem');
            $itemdetail = $pitemmodel->geSimpletItemByItemid($itemid);
            $sid = 0;
            if (!empty($itemdetail['sid'])) {
                $sid = $itemdetail['sid'];
            }
            if (!empty($itemdetail) && $itemdetail['iprice'] == 0 && $itemdetail['cannotpay'] == 0) {
                $free = true;
            }
            if ($free && $sid > 0) {
                $paysort_prices = $this->model('Paysort')->sortsCountPrice(array($sid));
                if (!empty($paysort_prices)) {
                    $all_price = 0;
                    foreach ($paysort_prices as $paysort_price) {
                        if ($paysort_price['cannotpay'] == 1) {
                            $free = false;
                            break;
                        }
                        if ($paysort_price['isschoolfree'] == 0) {
                            $all_price += $paysort_price['iprice'];
                        }
                    }
                    if ($all_price > 0) {
                        $free = false;
                    }
                }
            }
        }
        $this->assign('free', $free);
		$this->display('college/attachment');
	}
	
	private function getsize($bsize){
		$size = "0字节";
		if (!empty($bsize))
		{
			$gsize = $bsize / (1024 * 1024 * 1024);
			$msize = $bsize / (1024 * 1024);
			$ksize = $bsize / 1024;
			if ($gsize > 1)
			{
				$size = round($gsize,2) . "G";
			}
			else if($msize > 1)
			{
				$size = round($msize,2) . "M";
			}
			else if($ksize > 1)
			{

				$size = round($ksize,0) . "K";
			}
			else
			{
				$size = $bsize . "字节";
			}
		}
		return $size;
	}
}