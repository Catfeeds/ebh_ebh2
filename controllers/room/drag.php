<?php
/**
 * 网校 drag魔板控制器
 *
 */
class DragController extends CControl{
    public function index() {
		//获取当前域名
		$currentdomain = getdomain();
		$this->assign('currentdomain', $currentdomain);
        $roominfo = Ebh::app()->room->getcurroom();
		$this->_show_drag();
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
		//如果是网校管理员，则特殊处理。
		$ak = $this->input->cookie('ak');
		if(empty($ak)) {
			$user = Ebh::app()->user->getloginuser();
		} else {
			$user = Ebh::app()->user->getAdminLoginUser();
		}
        $this->assign('user', $user);
		//教室首页广告获取
		$roomcache = Ebh::app()->lib('Roomcache');
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
//				$roomadkey = $this->cache->getcachekey('ad',$param);
//                $adlist = $this->cache->get($roomadkey);
		$adlist = $roomcache->getCache($roominfo['crid'],'item',$param);
        if($adlist === FALSE) {
			$admodel = $this->model('Ad');        
            $adlist = $admodel->getAdList($param);
//                    $this->cache->set($roomadkey,$adlist,600);
			$roomcache->setCache($roominfo['crid'],'item',$param,$adlist,0,TRUE);
        }
        $this->assign('adlist', $adlist);

        $systemsetting = Ebh::app()->room->getSystemSetting();
        $this->assign('systemsetting', $systemsetting);
        $this->display('shop/drag/index');
    }

    /**
     * 处理drag模板核心数据
     */
	function _show_drag(){
		$roominfo = Ebh::app()->room->getcurroom();
		$roommodel = $this->model('classroom');
		$roomcache = Ebh::app()->lib('Roomcache');
		$roomnav = $roomcache->getCache($roominfo['crid'],'navigator','');
		if(empty($roomnav)) {
			$roomnav = $roommodel->getNavigator($roominfo['crid']);
			$roomcache->setCache($roominfo['crid'],'navigator','',$roomnav,0,TRUE);
		}
		// var_dump($roomnav);
		if(!empty($roomnav)){
			$navigatordata = unserialize($roomnav);
			$navigatorarr = $navigatordata['navarr'];
			$navigatorlist = Ebh::app()->getConfig()->load('roomnav');
			foreach($navigatorarr as $nav){
				if($nav['code'] == 'index' && !empty($nav['available'])){
					$hasindex = true;
					break;
				}
			}
			if(empty($hasindex)){
				foreach($navigatorarr as $nav){
					if(empty($nav['available']))
						continue;
					else{
						if($nav['code'] == 'index')
							;
						elseif(in_array($nav['code'],array_keys($navigatorlist),true)){
							header('Location: '.$navigatorlist[$nav['code']]['url'].'.html');
							exit;
						}else{
							// echo $nav['code'];
							// var_dump(($navigatorlist));
							header('Location: /navcm/'.ltrim($nav['code'],'n').'.html');
						}
						
						break;
					}
						// header('Location: '.$navigatorlist[$nav['code']]['url'].'.html');
				}
			}
			// var_dump($navigatorlist[$navigatorarr[0]['code']]);
		}
		$user = Ebh::app()->user->getloginuser();

		//获取详情,供浮动广告
		$roomdetail = $roomcache->getCache($roominfo['crid'],'roominfo','detail');
		if($roomdetail === FALSE) {
			$roomdetail = $roommodel->getclassroomdetail($roominfo['crid']);
			$roomcache->setCache($roominfo['crid'],'roominfo','detail',$roomdetail,0,TRUE);	//后台自动更新还待观察
		}
		$this->assign('roomdetail',$roomdetail);
		
		$mstr = $roomdetail['custommodule'];
		$mArr = unserialize($mstr);
		$this->assign('mArr',$mArr);
		
		$modulearr = array('mitemstr'=>0,'newsstr'=>1,'adstr'=>2,'roomstr'=>3,'loginstr'=>4,'getusernamestr'=>5,'hotlabelstr'=>6,'opencountstr'=>7,'studystr'=>8,'creditstr'=>9,'cwrankstr'=>10,'spstr'=>11,'thespacexxx'=>12,'wechatstr'=>13,'custommessagestr'=>14,'appstr'=>15,'freeviewstr'=>16,'surveystr'=>17,'adpstr'=>18,'custommessagebbstr'=>19);
		
		//未设置模块时，显示部分
		if(empty($mstr)){
			// foreach($modulearr as $k=>$m){
				// $modulearr[$k] = 0;
			// }
			$mArr = array('mlv1'=>'12',
							'mleft'=>'0',
							'mcenter'=>'3',
							'mright'=>'4',
							'mdeleted'=>'2,1,14,16,11,13,18,15,5,17,6,7,8,9,10,19'
						);
		}
		
		$mleft = explode(',',$mArr['mleft']);
		$mcenter = explode(',',$mArr['mcenter']);
		$mlv1 = explode(',',$mArr['mlv1']);
		$mright = explode(',',$mArr['mright']);
		$mdeleted = explode(',',$mArr['mdeleted']);
		if(in_array($modulearr['spstr'],$mlv1)){
			//获取服务包
			// $param = array('crid'=>$roominfo['crid']);
			// $roomadkey = $this->cache->getcachekey('splist',$param);
			// $splist = $this->cache->get($roomadkey);
			if(empty($splist)){
				$spparam = array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'itype asc,displayorder asc,pid desc','limit'=>1000);
				$thelist = $roomcache->getCache($roominfo['crid'],'paypackage',$spparam);
				if($thelist === FALSE) {
					$spmodel = $this->model('PayPackage');
					$thelist = $spmodel->getsplist($spparam);
					$roomcache->setCache($roominfo['crid'],'paypackage',$spparam,$thelist,0,TRUE);
				}
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
				$sortlist = array();	//服务分类数组，用于存放包含收费服务项的分类
				$spsort = array(); //服务项分类,array('sid'=>array(itemid,itemid,itemid))
				//根据pid合集获取服务项
				if(!empty($spidlist)) {
					$pitemmodel = $this->model('PayItem');
					$power = '0';
					$itemparam = array('limit'=>1000,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>$power);
					$itemlist = $roomcache->getCache($roominfo['crid'],'payitem',$itemparam);
					if($itemlist === FALSE) {
						$itemlist = $pitemmodel->getItemFolderList($itemparam);
						$roomcache->setCache($roominfo['crid'],'payitem',$itemparam,$itemlist,120);	//服务项缓存120秒
					}
					if(!empty($itemlist)) {
						foreach($itemlist as $myitem) {
							if($myitem['ishide'] == 1) {	//如果分类设置隐藏则不显示
								continue;
							}
							if(isset($splist[$myitem['pid']])) {
								$splist[$myitem['pid']]['itemlist'][] = $myitem;
							}
							if(!isset($splist[$myitem['pid']]['sids'][$myitem['sid']])){
								$splist[$myitem['pid']]['sids'][$myitem['sid']] = $myitem['sname'];
							}
							if(!empty($myitem['sid'])) {
								if(!isset($sortlist[$myitem['sid']]) && $myitem['fprice'] > 0 && $myitem['iprice'] > 0) {
									$sortlist[$myitem['sid']] = 1;
								}
							}
						}
					}
				}
			
				// $this->cache->set($roomadkey,$splist,60);
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
			$this->assign('splist',$splist);
			$this->assign('sortlist',$sortlist);
			$this->assign('mylist',$mylist);
			$this->assign('spstr_s',true);
		}
		$this->assign('user',$user);
	
		//开通的学生列表
		if($roominfo['isschool'] == 7 && (in_array($modulearr['opencountstr'],$mleft) || in_array($modulearr['opencountstr'],$mright))){
			$param = array('crid'=>$roominfo['crid'],'status'=>1,'limit'=>'0,7');
			$roomadkey = $this->cache->getcachekey('opencount',$param);
			$opencountlist = $this->cache->get($roomadkey);
			if(empty($opencountlist)){
				$ordermodel = $this->model('Payorder');
				$opencountlist = $ordermodel->getOrderDetailList($param);
				$this->cache->set($roomadkey,$opencountlist,3600);
			}
//			var_dump($opencountlist);exit();
			$this->assign('opencountlist',$opencountlist);
			$this->assign('opencountstr_s',true);
		}
		//获取公告
		$annparam['crid'] = $roominfo['crid'];
		$annparam['limit'] = 3;
		$announcementlist = $roomcache->getCache($roominfo['crid'],'sendinfo',$annparam);
		if($announcementlist === FALSE) {
			$announcement = $this->model('sendinfo');
			$announcementlist = $announcement->getSendList($annparam);
			$roomcache->setCache($roominfo['crid'],'sendinfo',$annparam,$announcementlist,0,TRUE);
		}
		$this->assign('announcementlist',$announcementlist);
		
		//动态资讯
		if(in_array($modulearr['mitemstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['mitemstr'],$mright)){
			$params = array('navcode'=>'news','crid'=>$roominfo['crid'],'status'=>1,'limit'=>'0,6');
			$mitemlist = $roomcache->getCache($roominfo['crid'],'news',$params);
			if($mitemlist === FALSE) {
				$mmodel = $this->model('news');
				$mitemlist = $mmodel->getnewslist($params);
				$roomcache->setCache($roominfo['crid'],'news',$params,$mitemlist,0,TRUE);
			}
			$this->assign('mitemlist', $mitemlist);
			$this->assign('mitemstr_s', true);
		}
		
		//积分排名
		if(in_array($modulearr['creditstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['creditstr'],$mright)){
			$param = array('crid'=>$roominfo['crid'],'limit'=>15);
			$roomadkey = $this->cache->getcachekey('creditrank',$param);
			$creditlist = $this->cache->get($roomadkey);
			if(empty($creditlist)){
				$creditmodel = $this->model('credit');
				$creditlist = $creditmodel->getRankList($param);
				$this->cache->set($roomadkey,$creditlist,3600);
			}
			
			$this->assign('creditlist',$creditlist);
			$this->assign('creditstr_s',true);
		}
		//学员动态
		if(in_array($modulearr['studystr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['studystr'],$mright)){
			$param = array('crid'=>$roominfo['crid'],'limit'=>'5');
			$studylist = $roomcache->getCache($roominfo['crid'],'playlog',$param);
			if($studylist === FALSE) {
				$plmodel = $this->model('playlog');
				$studylist = $plmodel->getRoomRecentLog($param);
				$roomcache->setCache($roominfo['crid'],'playlog',$param,$studylist,300);
			}
			$this->assign('studylist', $studylist);
			$this->assign('studystr_s', true);
		}
		//课件排行
		if(in_array($modulearr['cwrankstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['cwrankstr'],$mright)){
			$param = array('crid'=>$roominfo['crid'],'limit'=>10,'order'=>'viewnum desc');
			$roomadkey = $this->cache->getcachekey('courserank',$param);
			$courseranklist = $this->cache->get($roomadkey);
			if(empty($courseranklist)){
				$rcmodel = $this->model('roomcourse');
				$courseranklist = $rcmodel->getRoomCourseRankList($param);
				$this->cache->set($roomadkey,$courseranklist,3600);
			}
			
			$this->assign('courseranklist',$courseranklist);
			$this->assign('cwrankstr_s',true);
		}
		//获取新闻资讯记录
		if(in_array($modulearr['newsstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['newsstr'],$mright)){
			$nitemparam = array('best'=>1,'catid'=>686,'type'=>'news','limit'=>'0,6','displayorder'=>'displayorder,itemid desc');
			$newslist = $roomcache->getCache(0,'item',$nitemparam);
			if($newslist === FALSE) {
				$itemmodel  = $this->model('Item');
				$newslist = $itemmodel->getitemlist($nitemparam);
				$roomcache->setCache(0,'item',$nitemparam,$newslist,300);
			}
			$this->assign('newslist', $newslist);
			$this->assign('newsstr_s', true);
		}
		
		//橱窗广告
		if(in_array($modulearr['adstr'],$mcenter) && !in_array(12,$mdeleted)){
			$admodel = $this->model('Ad');
			$param = array('crid'=>$roominfo['crid'] ,'code'=>'centersponsor','folder'=>2,'limit'=>'0,5');
//			$roomadkey = $this->cache->getcachekey('ad',$param);
//			$adlistm = $this->cache->get($roomadkey);
			$adlistm = $roomcache->getCache($roominfo['crid'],'item',$param);
			if($adlistm === FALSE) {
				$admodel = $this->model('Ad');        
				$adlistm = $admodel->getAdList($param);
				$roomcache->setCache($roominfo['crid'],'item',$param,$adlistm,0,TRUE);
//				$this->cache->set($roomadkey,$adlistm,600);
			}
			$this->assign('adlistm', $adlistm);
			$this->assign('adstr_s', true);
		}
		//自定义富文本
		if(in_array($modulearr['custommessagestr'],$mlv1)){
			$custparam = array('crid'=>$roominfo['crid'],'index'=>1);
			$custommessage = $roomcache->getCache($roominfo['crid'],'custommessage',$custparam);
			if($custommessage === FALSE) {
				$custommessage = $roommodel->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>1));
				$roomcache->setCache($roominfo['crid'],'custommessage',$custparam,$custommessage,0,TRUE);
			}
			$this->assign('custommessage',$custommessage);
			$this->assign('custommessagestr_s',true);
		}
		//学校介绍
		if(in_array($modulearr['roomstr'],$mcenter) && !in_array(12,$mdeleted)){
			$this->assign('roomstr_s',true);
		}
		//登录
		if(in_array($modulearr['loginstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['loginstr'],$mright)){
			$this->assign('loginstr_s',true);
		}
		//获取用户名
		if(in_array($modulearr['getusernamestr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['getusernamestr'],$mright)){
			$this->assign('getusernamestr_s',true);
		}
		//热门标签
		if(in_array($modulearr['hotlabelstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['hotlabelstr'],$mright)){
			$this->assign('hotlabelstr_s',true);
		}
		//微信二维码
		if(in_array($modulearr['wechatstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['wechatstr'],$mright)){
			$this->assign('wechatstr_s',true);
		}
		//app
		if(in_array($modulearr['appstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['appstr'],$mright)){
			$param = array('crid'=>$roominfo['crid'],'index'=>1);
			$roomadkey = $this->cache->getcachekey('roomapp',$param);
			$applist = $this->cache->get($roomadkey);
			if(empty($applist)){
				$app = $roommodel->getcustommessage($param);
				if(!empty($app[0])){
					$appstr = $app[0];
					$applist = unserialize($appstr['appstr']);
					$this->cache->set($roomadkey,$applist,600);
				}

			}
			
			$this->assign('applist',$applist);
			$this->assign('appstr_s',true);
		}
		//免费试看片
		if(in_array($modulearr['freeviewstr'],$mlv1)){
			$freeparam = array('crid'=>$roominfo['crid'],'status'=>1,'isfree'=>1,'limit'=>100,'freeorder'=>'f.displayorder,f.folderid DESC,sdisplayorder ASC,s.sid ASC,r.cdisplayorder ASC,cw.displayorder ASC,cw.cwid DESC');
			$freelist = $roomcache->getCache($roominfo['crid'],'courseware',$freeparam);
			if($freelist === FALSE) {
				$cwmodel = $this->model('courseware');
				$freelist = $cwmodel->getfolderseccourselist($freeparam);
				$roomcache->setCache($roominfo['crid'],'courseware',$freeparam,$freelist,30);
			}
			$this->assign('freelist',$freelist);
			$this->assign('freeviewstr_s',true);
		}
		
		//调查问卷
		if(in_array($modulearr['surveystr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['surveystr'],$mright)){
			$surveyparam = array('crid' => $roominfo['crid'],'type' => 0,'ispublish' => 1,'isopening' => 1,'limit' => 6);
			$surveylist = $roomcache->getCache($roominfo['crid'],'survey',$surveyparam);
			if($surveylist === FALSE) {
				$surveylist = $this->model('survey')->getSurveyList($surveyparam);
				$roomcache->setCache($roominfo['crid'],'survey',$surveyparam,$surveylist,0,TRUE);
			}
			$this->assign('surveylist', $surveylist);
			$this->assign('surveystr_s', true);
		}
		
		
		//页面动态广告
		if(in_array($modulearr['adpstr'],$mleft) && !in_array(12,$mdeleted) || in_array($modulearr['adpstr'],$mright)){
			$param = array('crid'=>$roominfo['crid'] ,'code'=>'pagesmall','folder'=>2,'limit'=>'0,5');
//			$roomadkey = $this->cache->getcachekey('ad',$param);
//			$adlistp = $this->cache->get($roomadkey);
			$adlistp = $roomcache->getCache($roominfo['crid'],'item',$param);
			if($adlistp === FALSE) {
				$admodel = $this->model('Ad');        
				$adlistp = $admodel->getAdList($param);
				$roomcache->setCache($roominfo['crid'],'item',$param,$adlistp,0,TRUE);
//				$this->cache->set($roomadkey,$adlistp,600);
			}
			$this->assign('adlistp', $adlistp);
			$this->assign('adpstr_s', true);
		}
		
		//自定义富文本(大)
		if(in_array($modulearr['custommessagebbstr'],$mlv1)){
			$bigcustmsgparam= array('crid'=>$roominfo['crid'],'index'=>2);
			$custommessagebb = $roomcache->getCache($roominfo['crid'],'custommessage',$bigcustmsgparam);
			if($custommessagebb === FALSE) {
				$custommessagebb = $roommodel->getcustommessage($bigcustmsgparam);
				$roomcache->setCache($roominfo['crid'],'custommessage',$bigcustmsgparam,$custommessagebb,0,TRUE);
			}
			$this->assign('custommessagebb',$custommessagebb);
			$this->assign('custommessagebbstr_s',true);
		}
	}
}
