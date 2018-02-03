<?php
/**
 * 我的进度
 */
class ProgressController extends CControl {
    public function __construct() {
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
	
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$foldermodel = $this->model('Folder');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		
		$pagestr = '';
		if($roominfo['isschool'] == 7){
			$spmodel = $this->model('PayPackage');
			$thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
			$splist = array();
			$spidlist = '';
			//将结果数组以pid为下标排列,并记录pid合集字符串
			foreach($thelist as $mysp) {
				$splist[$mysp['pid']] = $mysp;
				$splist[$mysp['pid']]['itemlist'] = array();
				if(empty($spidlist)) {
					$spidlist = $mysp['pid'];
				} else {
					$spidlist .= ','.$mysp['pid'];
				}
			}
			///////开通的课程
			if(!empty($spidlist)) {
				$pitemmodel = $this->model('PayItem');
				$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>0);
				$itemlist = $pitemmodel->getItemFolderList($itemparam);
				// var_dump($itemlist);exit;
				if(!empty($itemlist)) {
					foreach($itemlist as $myitem) {
						// if(isset($folders[$myitem['pid']])) {
							// $folders[$myitem['pid']]['itemlist'][] = $myitem;
						// }
						$folders[$myitem['folderid']] = $myitem;
					}
				}
			}
			$mylist = array();
			if(!empty($user) && $user['groupid'] == 6) {
				$userpermodel = $this->model('Userpermission');
				$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
				$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
				foreach($myfolderlist as $myfolder) {
					$mylist[$myfolder['folderid']] = $myfolder;
				}
			}
			foreach($folders as $k=>$folder){
				$showpack = false;
				if($folder['fprice']==0 || isset($mylist[$folder['folderid']]))
					;
				else
					unset($folders[$k]);
				
			}
		}else{
			if(!empty($myclass['classid']))
				$queryarr['classid'] = $myclass['classid'];
			
			if(!empty($myclass['grade']))
				$queryarr['grade'] = $myclass['grade'];
			$queryarr['pagesize'] = 15;
			
			//课程列表
			if(!empty($myclass['classid'])){
				$folders = $foldermodel->getClassFolder($queryarr);
				// var_dump($folders);
				$count = $foldermodel->getClassFolderCount($queryarr);
			}else{
				$queryarr['nosubfolder'] = 1;
				$folders = $foldermodel->getfolderlist($queryarr);
				$count = $foldermodel->getcount($queryarr);
			}
			$pagestr = show_page($count,15);
		}
		$folderids = '';
		if(!empty($folders)){
			foreach($folders as $folder){
				$folderids.= $folder['folderid'].',';
			}
			//folderid集合字符串
			$folderids = rtrim($folderids,',');
			$pmodel = $this->model('progress');
			$param['folderid'] = $folderids;
			
			//课程集合下的视频课件
			$param['limit'] = 10000;
			$coursewarelist = $pmodel->getCWByFolderid($param);
			
			$cwids = '';
			
			//cwid=>folderid对应数组
			$cwidfolderidlist =array();
			if(!empty($coursewarelist)){
				$countlist = $pmodel->getFolderProgressCountByFolderid($param);
				foreach($countlist as $f){
					$foldercwcount[$f['folderid']] = $f['count'];
				}
				foreach($coursewarelist as $cw){
					$cwids.= $cw['cwid'].',';
					$cwidfolderidlist[$cw['cwid']] = $cw['folderid'];
				}
				// var_dump($cwidfolderidlist);
				$cwids = rtrim($cwids,',');
				$param['cwid'] = $cwids;
				$param['uid'] = $user['uid'];
				
				//根据cwid获取进度,添加到对应 课程进度 数组中
				$folderprogress = array();
				$progresslist = $pmodel->getFolderProgressByCwid($param);
				foreach($progresslist as $p){
					$folderid = $cwidfolderidlist[$p['cwid']];
					if($p['percent']*100>100)
						$folderprogress[$folderid][] = 100;
					else
						$folderprogress[$folderid][] = $p['percent']*100;
				}
				// var_dump($folderprogress);
				// exit;
				
				//课程进度数组计算结果记录到课程列表的进度字段
				
				foreach($folders as $k=>$folder){
					$folderid = $folder['folderid'];
					if(!empty($folderprogress[$folderid])){
						$folders[$k]['percent'] = floor(array_sum($folderprogress[$folderid])/$foldercwcount[$folderid]);
						// var_dump($folderprogress[$folderid]);
					}
					else{
						$folders[$k]['percent'] = 0;
					}
					if(!empty($foldercwcount[$folderid]))
						$folders[$k]['coursewarenum'] = $foldercwcount[$folderid];
					else
						$folders[$k]['coursewarenum'] = 0;
				}
				
			}
		}
		
		$this->assign('pagestr',$pagestr);
		$this->assign('folders',$folders);
		$this->display('myroom/progress_courselist');
	}
	
	public function view(){
		$user = Ebh::app()->user->getloginuser();
		$folderid = $this->uri->itemid;
		$pmodel = $this->model('progress');
		$param = parsequery();
		$param['uid'] = $user['uid'];
		// $param['pagesize'] = 30;
		$param['folderid'] = $folderid;
		$param['limit'] = 10000;
		$cwids = '';
		$coursewarelist = $pmodel->getCWByFolderid($param);
		$percentavg = 0;
		$progresscount = 0;
		if(!empty($coursewarelist)){
			foreach($coursewarelist as $cw){
				$cwids.= $cw['cwid'].',';
			}
			$cwids = rtrim($cwids,',');
			$param['cwid'] = $cwids;
			
			$progresslist = $pmodel->getFolderProgressByCwid($param);
			// var_dump($progresslist);exit;
			
			$countlist = $pmodel->getFolderProgressCountByFolderid($param);
			$progresscount = $countlist[0]['count'];
			
			$coursewarelisttotal = $pmodel->getCWByFolderid($param);
			$cwids2 = '';
			foreach($coursewarelisttotal as $cw){
				$cwids2.= $cw['cwid'].',';
			}
			$cwids2 = rtrim($cwids2,',');
			$param['cwid'] = $cwids2;
			$progresslisttotal = $pmodel->getFolderProgressByCwid($param);
			
			// var_dump($progresslist);
			$percentsum = 0;
			foreach($progresslist as $k=>$p){
				if($p['percent']*100>100){
					$cwprogress[$p['cwid']] = 100;
					// $progresslist[$k]['percent'] = 100;
				}
				else{
					$cwprogress[$p['cwid']] = floor($p['percent']*100);
					// $progresslist[$k]['percent'] = floor($p['percent']*100);
				}
			}
			foreach($coursewarelist as $k=>$cw){
				if(!empty($cwprogress[$cw['cwid']]))
					$coursewarelist[$k]['percent'] = $cwprogress[$cw['cwid']];
				else
					$coursewarelist[$k]['percent'] = 0;
			}
			// var_dump($coursewarelist);exit;
			// var_dump($progresslisttotal);
			foreach($progresslisttotal as $k=>$p){
				if($p['percent']*100>100){
					$progresslisttotal[$k]['percent'] = 100;
					$percentsum += 100;
				}
				else{
					$progresslisttotal[$k]['percent'] = floor($p['percent']*100);
					$percentsum += $p['percent']*100;
				}
			}
			
			if($progresscount != 0)
				$percentavg = floor($percentsum/$progresscount);
			// var_dump($percentsum);
			
			$sectionmodel = $this->model('section');
			$sectionlist = $sectionmodel->getsections(array('folderid'=>$folderid));
			// var_dump(array_values($sectionlist));
			// var_dump($coursewarelist);
			$slistbysid = array();
			foreach($sectionlist as $section){
				$slistbysid[$section['sid']]['name'] = $section['sname'];
			}
			$slistbysid['other']['name'] = '其他';
			foreach($coursewarelist as $cw){
				$sid = $cw['sid'];
				if(!empty($sid) && !empty($slistbysid[$cw['sid']]))
					$slistbysid[$sid][] = $cw;
				else
					$slistbysid['other'][] = $cw;
			}
			// var_dump($slistbysid);
			$this->assign('coursewarelist',$coursewarelist);
			$this->assign('sectionlist',$slistbysid);
		}
		// $pagestr = show_page($progresscount,30);
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
		$this->assign('percentavg',$percentavg);
		// $this->assign('pagestr',$pagestr);
		$this->display('myroom/progress_detail');
	}
}
