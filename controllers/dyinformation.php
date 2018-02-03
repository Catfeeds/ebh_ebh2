<?php
/*
*动态资讯
*/
class DyinformationController extends CControl {
	private $templatearr = array('zwx','stores','mainschool','scb','hnm','qjb','one','zhh','zho','zjdf','drag');
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
		}
		if ($roominfo['template'] == 'plate') {
			Ebh::app()->runAction('room/portfolio', 'dyinformation');
			return;
		}
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
		if(in_array($roominfo['template'],$this->templatearr))
			$this->showfunc($roominfo['template']);
		
    }
	function view() {
		//广告
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
		}
		if ($roominfo['template'] == 'plate') {
			Ebh::app()->runAction('room/portfolio', 'dyinformation');
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
		$this->assign('room', $roominfo);
		//资讯详情
		$itemid = $this->uri->itemid;
		$newsmodel = $this->model('news');
		$itemview = $newsmodel->getNewsDetail(array('crid'=>$roominfo['crid'],'itemid'=>$itemid));
		$this->assign('itemview', $itemview);
		//添加资讯查看数
		$newsmodel->addviewnum($itemid);
		
		if(in_array($roominfo['template'],$this->templatearr))
			$this->display('shop/'.$roominfo['template'].'/dyinformation_view');
			
	}
	
	/*
	新闻动态(旧数据页面)
	*/
	public function o_view(){
		//广告
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
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
		$this->assign('room', $roominfo);
		//资讯详情
		$itemid = $this->uri->itemid;
		$mmodel = $this->model('item');
		$itemview = $mmodel->getitemdetail($itemid);
		$this->assign('itemview', $itemview);
		//添加资讯查看数
		$mmodel->addviewnum($itemid);
		
		if(in_array($roominfo['template'],$this->templatearr))
			$this->display('shop/'.$roominfo['template'].'/dyinformation_view');
	}
	
	private function showfunc($template){
		//广告
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
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
		//动态资讯
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		
		$newsmodel = $this->model('news');
		$params = parsequery();
		$params['crid'] = $crid;
		$params['status'] = 1;
		$params['navcode'] = 'news';
		
		$mitemlist = $newsmodel->getnewslist($params);
		if (!empty($mitemlist)) {
			$upconfig = Ebh::app()->getConfig()->load('upconfig');
			$baseurl = $upconfig['pic']['showpath'];
			foreach ($mitemlist as &$newitem) {
				if (empty($newitem['thumb'])) {
					continue;
				}
				$newitem['thumb'] = $this->_format_img_path($newitem['thumb'], $baseurl);
			}
		}
		$count = $newsmodel->getnewscount($params);
		
		$pagestr = show_page($count);
		$this->assign('pagestr',$pagestr);
		$this->assign('mitemlist', $mitemlist);
		$this->display('shop/'.$template.'/dyinformation');
	}

	/**
	 * 将相对路径转换为绝对路径
	 * @param $url 图片位置
	 * @param $baseurl 图片服务器根路径
	 * @return bool|string
	 */
	private function _format_img_path($url, $baseurl) {
		if (empty($url)) {
			return false;
		}
		if (stripos($url, 'http://') === false) {
			$filename = explode('.', $url);
			return sprintf('%s%s_th.%s', $baseurl, $filename[0], $filename[1]);
		}
		return $url;
	}
}
?>
