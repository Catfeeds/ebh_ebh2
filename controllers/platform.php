<?php
/*
*平台简介
*/
class PlatformController extends CControl {
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		if ($roominfo['template'] == 'plate') {
			Ebh::app()->runAction('room/portfolio', 'platform');
			return;
		}
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
        //客服浮窗
        $kefu=array();
        if($roominfo['kefuqq']!=0){
            $kefu['kefu'] = explode(',',$roominfo['kefu']);
            $kefu['kefuqq'] = explode(',',$roominfo['kefuqq']);
        }
        if(!empty($roominfo['crphone'])){
            $phone = array();
            $phone = explode(',',$roominfo['crphone']);
            $this->assign('phone',$phone);
        }

        $this->assign('kefu',$kefu);
		if($roominfo['template']=='zwx'){
			$this->_show_zwx();
		}else if($roominfo['template']=='stores'){
			$this->_show_stores();
		}else if($roominfo['template']=='mainschool'){
			$this->_show_mainschool();
		}else if($roominfo['template']=='scb'){
			$this->_show_scb();
		}else if($roominfo['template']=='hnm'){
			$this->_show_hnm();
		}else if($roominfo['template']=='qjb'){
			$this->_show_qjb();
		}else if($roominfo['template']=='one'){
			$this->_show_one();
		}else if($roominfo['template']=='drag'){
			$this->_show_drag();
		}
    }
	function _show_zwx() {
		//广告
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc');
		$zwxlist = $classroommodel->getzwxlist($param);

		$count = $classroommodel->getzwxcount($crid);

		$this->assign('count',$count);
		$param['pagesize'] = 9;
		$this->assign('pagesize',$param['pagesize']);

	//	$this->cache->set('zwxlist',$zwxlist,300);
		$this->assign('zwxlist', $zwxlist);

		$roomu = $this->model('Roomuser');
		$rmuser = $roomu->getroomuser($crid);
	//	$this->cache->set('rmuser',$rmuser,300);
		$this->assign('rmuser', $rmuser);
		$this->display('shop/zwx/platform');
	}
	function _show_scb() {
		//广告
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc');
		$zwxlist = $classroommodel->getzwxlist($param);

		$count = $classroommodel->getzwxcount($crid);

		$this->assign('count',$count);
		$param['pagesize'] = 9;
		$this->assign('pagesize',$param['pagesize']);

	//	$this->cache->set('zwxlist',$zwxlist,300);
		$this->assign('zwxlist', $zwxlist);

		$roomu = $this->model('Roomuser');
		$rmuser = $roomu->getroomuser($crid);
	//	$this->cache->set('rmuser',$rmuser,300);
		$this->assign('rmuser', $rmuser);
		$this->display('shop/scb/platform');
	}
	function _show_qjb() {
		//广告
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc');
		$zwxlist = $classroommodel->getzwxlist($param);

		$count = $classroommodel->getzwxcount($crid);

		$this->assign('count',$count);
		$param['pagesize'] = 9;
		$this->assign('pagesize',$param['pagesize']);

	//	$this->cache->set('zwxlist',$zwxlist,300);
		$this->assign('zwxlist', $zwxlist);

		$roomu = $this->model('Roomuser');
		$rmuser = $roomu->getroomuser($crid);
	//	$this->cache->set('rmuser',$rmuser,300);
		$this->assign('rmuser', $rmuser);
		$this->display('shop/qjb/platform');
	}
		function _show_one() {
		//广告
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		$crid = $roominfo['crid'];
		
		$spmodel = $this->model('PayPackage');
		$thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
		$splist = array();
		$spidlist = '';
		foreach($thelist as $mysp) {
			$splist[$mysp['pid']] = $mysp;
			$splist[$mysp['pid']]['itemlist'] = array();
			if(empty($spidlist)) {
				$spidlist = $mysp['pid'];
			} else {
				$spidlist .= ','.$mysp['pid'];
			}
		}
		if(!empty($spidlist)) {
			$pitemmodel = $this->model('PayItem');
			$power = 0;
			$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>$power);
			$itemlist = $pitemmodel->getItemFolderList($itemparam);
			if(!empty($itemlist)) {
				foreach($itemlist as $myitem) {
					if(isset($splist[$myitem['pid']])) {
						$splist[$myitem['pid']]['itemlist'][] = $myitem;
					}
				}
			}
		}

		$this->assign('splist',$splist);
		$this->assign('user',$user);
		$this->display('shop/one/platform');
	}
	function _show_hnm() {
		//广告
		$roominfo = Ebh::app()->room->getcurroom();
		// $param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		// $roomadkey = $this->cache->getcachekey('ad',$param);
		// $adlist = $this->cache->get($roomadkey);
		// if(empty($adlist)) {
			// $admodel = $this->model('Ad');        
			// $adlist = $admodel->getAdList($param);
			// $this->cache->set($roomadkey,$adlist,600);
		// }
		// $this->assign('adlist', $adlist);
		$param = parsequery();
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		// $param = array('crid'=>$crid,'order'=>'displayorder,dateline desc');
		$param['crid'] = $crid;
		$param['order'] = 'displayorder,dateline desc';
		$zwxlist = $classroommodel->getzwxlist($param);

		$count = $classroommodel->getzwxcount($crid);

		$this->assign('count',$count);
		$this->assign('pagesize',$param['pagesize']);

	//	$this->cache->set('zwxlist',$zwxlist,300);
		$this->assign('zwxlist', $zwxlist);

		$roomu = $this->model('Roomuser');
		$rmuser = $roomu->getroomuser($crid);
	//	$this->cache->set('rmuser',$rmuser,300);
		$this->assign('rmuser', $rmuser);
		$this->assign('q',$param['q']);
		$this->display('shop/hnm/platform');
	}
	function _show_stores(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		//stores的详情介绍
		$classroom = $this->model('classroom');
		$classroomchachekey = $this->cache->getcachekey('classroom',$crid);
		$classroommess = $this->cache->get($classroomchachekey);
		if(empty($classroommess)) {
			$classroommess = $classroom->getdetailclassroom($crid);
			$this->cache->set($classroomchachekey,$classroommess,300);
		}
		$this->assign('classroommess', $classroommess);
		$this->display('shop/stores/platform');
	}
	function _show_mainschool() {//广告
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);

		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc','limit'=>'0,10');
		$zwxlist = $classroommodel->getzwxlist($param);

		$count = $classroommodel->getzwxcount($crid);
		$this->assign('count',$count);
		$param['pagesize'] = 10;
		$this->assign('pagesize',$param['pagesize']);
		$this->assign('zwxlist', $zwxlist);

		$roomu = $this->model('Roomuser');
		$rmuser = $roomu->getroomuser($crid);
		$this->assign('rmuser', $rmuser);

		$this->display('shop/mainschool/platform');
	}
	//滚动显示子网校
	public function scrolllist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$page = $this->input->post('page');
//echo $page.'||||'.$nums;
		$pagesize = 9;
		$classroommodel = $this->model('classroom');
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc','pagesize'=>$pagesize,'page'=>$page);
		$scrollarr = $classroommodel->getzwxlist($param);
		echo json_encode($scrollarr);
		exit();
	}
	
	
	function _show_drag() {
		//广告
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		$crid = $roominfo['crid'];
		
		$spmodel = $this->model('PayPackage');
		$thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
		$splist = array();
		$spidlist = '';
		foreach($thelist as $mysp) {
			$splist[$mysp['pid']] = $mysp;
			$splist[$mysp['pid']]['itemlist'] = array();
			if(empty($spidlist)) {
				$spidlist = $mysp['pid'];
			} else {
				$spidlist .= ','.$mysp['pid'];
			}
		}
		if(!empty($spidlist)) {
			$pitemmodel = $this->model('PayItem');
			$power = '0';
			$itemparam = array('limit'=>1000,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>$power);
			$itemlist = $pitemmodel->getItemFolderList($itemparam);
			if(!empty($itemlist)) {
				foreach($itemlist as $myitem) {
					if($myitem['ishide'] == 1) {	//如果分类设置隐藏则不显示
						continue;
					}
					if(isset($splist[$myitem['pid']])) {
						$splist[$myitem['pid']]['itemlist'][] = $myitem;
					}
					if(!empty($myitem['sid'])) {
						if(!isset($sortlist[$myitem['sid']]) && $myitem['fprice'] > 0 && $myitem['iprice'] > 0) {
							$sortlist[$myitem['sid']] = 1;
						}
					}
				}
			}
		}
		//已开通课程列表
		$mylist = array();
		if(!empty($user) && $user['groupid'] == 6) {
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			foreach($myfolderlist as $myfolder) {
				$mylist[$myfolder['folderid']] = $myfolder;
			}
		}

        //客服浮窗
        $kefu=array();
        if($roominfo['kefuqq']!=0){
            $kefu['kefu'] = explode(',',$roominfo['kefu']);
            $kefu['kefuqq'] = explode(',',$roominfo['kefuqq']);
        }
        if(!empty($roominfo['crphone'])){
            $phone = array();
            $phone = explode(',',$roominfo['crphone']);
            $this->assign('phone',$phone);
        }

        $this->assign('kefu',$kefu);
		$this->assign('mylist',$mylist);
		$this->assign('splist',$splist);
		$this->assign('user',$user);
		$this->display('shop/drag/platform');
	}
}
?>
