<?php
/**
 *自定义文本，首页导航处
 */
class NavcmController extends CControl {
	public function index() {
		
	}
	public function view(){
		$roominfo = Ebh::app()->room->getcurroom();
        if (empty($roominfo)) {
            header("Location: http://www.ebh.net");
            exit();
        }
        if ($roominfo['template'] == 'plate') {
            Ebh::app()->runAction('room/portfolio', 'navcm');
            return;
        }
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
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

		$this->assign('room', $roominfo);
		$itemid = $this->uri->itemid;
		$roommodel = $this->model('classroom');
		//富文本
		$custommessage = $roommodel->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>'\'n'.$itemid.'\''));
		$this->assign('custommessage',$custommessage);
		// var_dump($custommessage);
		//资讯列表
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['navcode'] = 'n'.$itemid.'';
		$param['status'] = 1;
		$newsmodel = $this->model('news');
		$newslist = $newsmodel->getnewslist($param);
		//二级菜单
		$s = $this->input->get('s');
		$roomnav = $roommodel->getNavigator($roominfo['crid']);
		if(!empty($roomnav)){
			$navigatordata = unserialize($roomnav);
			$navigatorarr = $navigatordata['navarr'];
			$s = (is_numeric($s)&&$s)?$s:'';
			$subcode = '';
			$firstsub = '';
			foreach($navigatorarr as $nav){
				if($nav['code'] == $param['navcode']){
					if(!empty($nav['subnav'])){
						foreach($nav['subnav'] as $k=>$subnav){
							if(!$subnav['subavailable']){
								continue;
							}
							if(empty($firstsub))
								$firstsub = $subnav['subcode'];
							// var_dump($firstsub);
							$scode = 'n'.$itemid.'s'.$s;
							if($scode == $subnav['subcode']){
								$subcode = $subnav['subcode'];
							}
							
						}
					}
					break;
				}
			}
			$subcode = empty($subcode)?$firstsub:$subcode;
			if(!empty($subcode)){
				$s = preg_replace('/n\d+s/','',$subcode);
				$this->assign('s',$s);
				
				$paramsub = parsequery();
				$paramsub['crid'] = $roominfo['crid'];
				$paramsub['navcode'] = $subcode;
				$paramsub['status'] = 1;
				$newsmodel = $this->model('news');
				$newslistsub = $newsmodel->getnewslist($paramsub);
				if(count($newslistsub) == 1){
					$this->assign('itemview',$newslistsub[0]);
					$newsmodel->addviewnum($newslistsub[0]['itemid']);
					
				}else{
					$this->assign('navcode',$paramsub['navcode']);
					// var_dump($newslistsub);
					$this->assign('newslistsub',$newslistsub);
					
				}
			}
		}
		
		$this->assign('itemid',$itemid);
		$this->assign('navcode',$param['navcode']);
		$this->assign('newslist',$newslist);
		$this->display('shop/drag/custommessage');
	}
	
	public function s_view(){
		$roominfo = Ebh::app()->room->getcurroom();
        if (empty($roominfo)) {
            header("Location: http://www.ebh.net");
            exit();
        }
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$itemid = $this->uri->itemid;
		// var_dump($itemid);
		$ncode = intval(substr($itemid,0,2));
		$scode = intval(substr($itemid,2,2));
		// var_dump($ncode);
		// var_dump($scode);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['navcode'] = 'n'.$ncode.'s'.$scode;
		$param['status'] = 1;
		$newsmodel = $this->model('news');
		$newslist = $newsmodel->getnewslist($param);
		if(count($newslist) == 1){
			$this->assign('itemview',$newslist[0]);
			$newsmodel->addviewnum($newslist[0]['itemid']);
			$this->display('shop/drag/dyinformation_view_sub');
		}else{
			$this->assign('navcode',$param['navcode']);
			$this->assign('newslist',$newslist);
			$this->display('shop/drag/custommessage_sub');
		}
	}
}
