<?php
/**
 * Description of default
 *
 * @author Administrator
 */
class DefaultController extends CControl{
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		if(!empty($user)){
			$thistime = $this->input->cookie('thistime');
			$today = strtotime(Date('Y-m-d'));
			if($thistime<$today){
				$cookietime = 31536000;
				$this->input->setcookie('lasttime', $thistime, $cookietime);
				$this->input->setcookie('thistime', SYSTIME, $cookietime);
				$usermodel = $this->model('user');
				$userparam = array('lastlogintime'=>SYSTIME);
				if($user['groupid'] == 6 && empty($user['allowip'])) {
					$clientip = $this->input->getip();
					$userparam['allowip'] = $clientip;
				}
				$usermodel->update($userparam,$user['uid']);
			}
		}
		//获取当前域名
		$currentdomain = getdomain();
		$this->assign('currentdomain', $currentdomain);
        $domain = $this->uri->uri_domain();
        if ($domain == '') {
			$this->_redirect_index();
        } else if ($domain != 'www') {
            $roominfo = Ebh::app()->room->getcurroom();
            //验证平台是否关闭
            if(empty($roominfo) || (isset($roominfo['status']) && $roominfo['status']==0)){
                $this->_redirect_index();
            }else {

				if($domain == 'www.leblue'){
					//老年大学首页处理，模板定义为aged，其他页面使用可能为plate
					$roominfo['template'] = 'aged';
				}
                $folder = 'shop';
				if($roominfo['template']=='fssq'){
					$this->_show_fssq();
				}elseif($roominfo['template']=='hz'){
					$this->_show_hz();
				}elseif($roominfo['template']=='school'){
					$this->_show_school();
				}elseif($roominfo['template']=='zwx' || $roominfo['template']=='mainschool'){
					$this->_show_zwx();
				}elseif($roominfo['template']=='stores'){
					$this->_show_stores();
				}
				elseif($roominfo['template']=='introduc'){
					$this->_show_introduc();
				}
				elseif($roominfo['template']=='sf'){
					$this->_show_sf();
				}
				elseif($roominfo['template']=='default'){
					$this->_show_default();
				}
				elseif($roominfo['template']=='hzxx'){
					$this->_show_hzxx();
				}
				elseif($roominfo['template']=='ddm'){
					$this->_show_ddm();
				}elseif($roominfo['template']=='scb'){
					$this->_show_scb();
				}elseif($roominfo['template']=='payschool'){
					$this->_show_payschool();
				}elseif($roominfo['template']=='hnm'){
					$this->_show_hnm();
				}elseif($roominfo['template']=='qjb'){
					$this->_show_qjb();
				}elseif($roominfo['template']=='qyy'){
					$this->_show_qyy();
				}elseif($roominfo['template']=='one'){
					$this->_show_one();
				}elseif($roominfo['template']=='zhh'){
					$this->_show_zhh();
				}elseif($roominfo['template']=='hsz'){
					$this->_show_hsz();
				}elseif($roominfo['template']=='hz2z'){
					$this->_show_hz2z();
				}elseif($roominfo['template']=='zho'){
					$this->_show_zho();
				}elseif($roominfo['template']=='zjdf'){
					$this->_show_zjdf();
				}elseif($roominfo['template']=='drag'){
                    //直接调用 room/drag 控制器，避免default控制器书写过多代码
                    return Ebh::app()->runAction('room/drag');
				}elseif($roominfo['template']=='zjg'){
					$this->_show_zjg();
				} elseif ($roominfo['template'] == 'plate') {

					//某些网校分销分享到首页，设置网校sharekeycookie,过期一年
			        $sharekey = $this->input->get('sharekey');
			        if (!empty($sharekey)) {
			        	//判断是否开启分享到首页的网校列表
			        	$othersetting = Ebh::app()->getConfig()->load('othersetting');
            			if (!empty($othersetting['shareToIndex']) && in_array($roominfo['crid'], $othersetting['shareToIndex'])) {
            				$lifetime = 8640000;
			            	EBH::app()->getInput()->setcookie('sharekey',$sharekey,$lifetime);
            			}
			            
			        }

                    if(!empty($roominfo['isdesign'])){
                        //自定义首页 --赵建生新版本
                        Ebh::app()->runAction('room/design', 'home');
                    }else{
                        //自定义模板 -- 颜才强老版本
                        /*if ($roominfo['crid'] == 10622) {
                            Ebh::app()->runAction('room/plate', 'home');
                            exit();
                        }*/
                        Ebh::app()->runAction('room/portfolio', 'home');

                    }
                    exit();
                }
                if(empty($roominfo['isschool'])){
                    $folder = 'room';
					$roominfo['template'] = 'default';
                }else if($roominfo['isschool'] == 1){
                    $folder = 'city';
					if($roominfo['template']=='jinhua'){
						$this->_show_jinhua();
					}elseif($roominfo['template']=='math'){
						$this->_show_math();
					}
//					elseif($roominfo['template']=='ddm'){
//						$this->_show_ddm();
//					}
					elseif($roominfo['template']=='hh'){
						$this->_show_hh();
					}elseif($roominfo['template']=='cq'){
						$this->_show_cq();
					}elseif($roominfo['template']=='fssq'){
						$this->_show_fssq();
					}
                }
				$folder .= '/'.$roominfo['template'];
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
                $this->display($folder.'/index');
            }
                
        } else {
            $this->_show_index();
        }
		
    }

    /**
     * 显示主站index模板
     */
    function _show_index() {
    	//转向门户首页(主要为了不动原网站代码实行访问www.ebanhui.com时显示www.ebanhui.com/portal.html的内容而浏览器网址显示www.ebanhui.com);
    }
	function _show_ddm() {
		//动动漫大纲导航
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$this->assign('room', $roominfo);
		$coursemodel  = $this->model('folder');
		$param = array('crid'=>$crid,'limit'=>'0,9');
		$freecourselist = $coursemodel->getfolderlist($param);
        $this->assign('freecourselist', $freecourselist);
	}

	function _show_introduc(){
        $conf = Ebh::app()->getConfig()->load('othersetting');
        $this->assign('cwinfo',$conf['indexlog']);
	}
	//金华平台
	function _show_jinhua(){
		//学员动态
		$studymodel = $this->model('study');
		$param = array('isclass'=>1,'displayorder'=>'s.dateline desc','limit'=>'0,12');
		$studylist = $studymodel->studyfor($param);
		$this->assign('studylist', $studylist);
		$itemsmodel = $this->model('item');
		$roominfo = Ebh::app()->room->getcurroom();
//		$param = array('catid'=>686,'crid'=>$roominfo['crid']);
//		$citycode = $itemsmodel->citycode($param);
		$params = array('catid'=>686,'hot'=>2, 'citycode'=>$citycode,'displayorder'=>'displayorder desc','limit'=>'0,16');
		$itemlist = $itemsmodel->gethotnews($params);
		$this->assign('itemlist', $itemlist);
		//免费试听
		$crid = $roominfo['crid'];
		$freemodel = $this->model('classroom');
		$para = array('crid'=>$crid,'status'=>1,'isfree'=>1,'displayorder'=>'sdisplayorder ASC,r.cdisplayorder ASC,cw.displayorder ASC,cw.dateline DESC','limit'=>'0,4');
		$freelist = $freemodel->getfreecourse($para);
		$this->assign('freelist', $freelist);
	}
	//企业云
	function _show_qyy(){
		$roominfo = Ebh::app()->room->getcurroom();
		$roommodel = $this->model('classroom');
		$roomdetail = $roommodel->getclassroomdetail($roominfo['crid']);
		$this->assign('roomdetail',$roomdetail);
	}
	//数学
	function _show_math(){
	//常见问题解答
//		$mitemmodel = $this->model('item');
//		$param = array('catid'=>691,'ischild'=>1,'limit'=>'0,19','displayorder'=>'displayorder,itemid desc');
//		$mitemlist = $mitemmodel->getitemmath($param);
//		$this->assign('mitemlist', $mitemlist);
	//高数
	}
	function _show_cq(){
		//免费试听
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		$para = array('crid'=>$crid,'status'=>1,'isfree'=>1,'displayorder'=>'sdisplayorder ASC,r.cdisplayorder ASC,cw.displayorder ASC,cw.dateline DESC','limit'=>'0,200');
		$freelist = $classroommodel->getfreecourse($para);
		$this->assign('freelist', $freelist);
		//学习大纲
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'displayorder'=>'displayorder asc','filternum'=>1,'limit'=>'0,33');
		$folderlist = $foldermodel->getfolderlist($param);
		$this->assign('folderlist', $folderlist);
	}
	function _show_hh(){
	//大纲导航
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'displayorder'=>'displayorder asc','filternum'=>1,'limit'=>'0,11');
		$folderlist = $foldermodel->getfolderlist($param);
		$this->assign('folderlist', $folderlist);
	}
	function _show_fssq(){
	//大纲导航
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$foldermodel = $this->model('classroom');
		$param = array('status'=>1,'isfree'=>1,'crid'=>$crid,'displayorder'=>'sdisplayorder ASC,r.cdisplayorder ASC,cw.displayorder ASC,cw.dateline DESC ','limit'=>'0,4');
		$folderlist = $foldermodel->getfreecourse($param);
		$this->assign('folderlist', $folderlist);
	}
	function _show_hz(){
	//大纲导航
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'displayorder'=>'displayorder asc','coursewarenum '=>1,'upid'=>0,'limit'=>'0,12');
		$folderslist = $foldermodel->getfolderlist($param);

		$courselist = array();
		foreach($folderslist as $arr){
			$coursewaremodel = $this->model('courseware');
			$courseware = $coursewaremodel->getfoldercourse($arr['folderid'],$crid);
			$courlist = array('foldermodel'=>$arr,'courseware'=>$courseware);
			array_push($courselist,$courlist);
		}
		$this->assign('folderslist', $courselist);
	
		$classmodel = $this->model('classroom');
		$para = array('status'=>1,'isfree'=>1,'crid'=>$crid,'displayorder'=>'cdisplayorder ASC','limit'=>'0,100');
		$classlist = $classmodel->getfreecourse($para);
		$this->assign('classlist', $classlist);
	}
	function _show_school(){
		//公告
		$roominfo = Ebh::app()->room->getcurroom();
		$toid = $roominfo['crid'];
		$type = 'announcement';
		$sendinfomodel = $this->model('sendinfo');
		$send = $sendinfomodel->getsend($toid,$type);
		$this->assign('send', $send);
	}
	function _show_payschool(){
		//公告
		$roominfo = Ebh::app()->room->getcurroom();
		$toid = $roominfo['crid'];
		$type = 'announcement';
		$sendinfomodel = $this->model('sendinfo');
		$send = $sendinfomodel->getsend($toid,$type);
		$this->assign('send', $send);
		$this->assign('roominfo', $roominfo);
	}
	function _show_zwx(){
		
		//教师名字
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $roominfo['uid'];
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getteachername($uid);
		$this->assign('teacher', $teacher);
		//子网校数量
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		$zwxcount = $classroommodel->getzwxcount($crid);
		$this->assign('zwxcount', $zwxcount);
		//学习子站
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc','limit'=>'0,9');
		$zwxlist = $classroommodel->getzwxlist($param);
		$this->assign('zwxlist', $zwxlist);
		//
		$mmodel = $this->model('item');
		$params = array('catid'=>686,'crid'=>$crid,'folder'=>2,'limit'=>'0,15','displayorder'=>'displayorder,itemid desc');
		$mitemlist = $mmodel->getitemzwx($params);

		$this->assign('mitemlist', $mitemlist);
	}
	function _show_scb(){
		
		//教师名字
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $roominfo['uid'];
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getteachername($uid);
		$this->assign('teacher', $teacher);
		//子网校数量
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		$zwxcount = $classroommodel->getzwxcount($crid);
		$this->assign('zwxcount', $zwxcount);
		//学习子站
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc','limit'=>'0,100');
		$zwxlist = $classroommodel->getzwxlist($param);
		$this->assign('zwxlist', $zwxlist);
		//
		$mmodel = $this->model('item');
		$params = array('catid'=>686,'crid'=>$crid,'folder'=>2,'limit'=>'0,15','displayorder'=>'displayorder,itemid desc');
		$mitemlist = $mmodel->getitemzwx($params);

		$this->assign('mitemlist', $mitemlist);
		
		$opcmodel = $this->model('opencount');
		$opencountlist = $opcmodel->getopencountlist(array('crid'=>$roominfo['crid'],'upid'=>$roominfo['crid'],'limit'=>'0,500'));
		$this->assign('opencountlist',$opencountlist);
	}
	/**
	*秋季班等收费学校模板处理
	*/
	function _show_qjb(){
		
		//教师名字
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $roominfo['uid'];
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getteachername($uid);
		$this->assign('teacher', $teacher);

		$spmodel = $this->model('PayPackage');
		$thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid']));
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
			$itemparam = array('limit'=>100,'pidlist'=>$spidlist);
			$itemlist = $pitemmodel->getItemList($itemparam);
			if(!empty($itemlist)) {
				foreach($itemlist as $myitem) {
					if(isset($splist[$myitem['pid']])) {
						$splist[$myitem['pid']]['itemlist'][] = $myitem;
					}
				}
			}
		}

		$this->assign('splist',$splist);
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);

		$mmodel = $this->model('item');
		$params = array('catid'=>686,'crid'=>$roominfo['crid'],'folder'=>2,'limit'=>'0,15','displayorder'=>'displayorder,itemid desc');
		$mitemlist = $mmodel->getitemzwx($params);

		$this->assign('mitemlist', $mitemlist);
		
		$opcmodel = $this->model('opencount');
		$opencountlist = $opcmodel->getopencountlist(array('crid'=>$roominfo['crid'],'upid'=>$roominfo['crid'],'limit'=>'0,500'));
		$this->assign('opencountlist',$opencountlist);
	}
	/**
	*上虞衔接课堂秋季班
	*/
	function _show_one(){
		$domain = $this->uri->uri_domain();
		$user = Ebh::app()->user->getloginuser();
		//教师名字
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $roominfo['uid'];
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getteachername($uid);
		$this->assign('teacher', $teacher);
		//获取服务包
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
		$sortlist = array();	//服务分类数组，用于存放包含收费服务项的分类
		//根据pid合集获取服务项
		if(!empty($spidlist)) {
			$pitemmodel = $this->model('PayItem');
			$power = '0';
			$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>$power);
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
		$this->assign('splist',$splist);
		$this->assign('sortlist',$sortlist);
		$this->assign('mylist',$mylist);
		$this->assign('user',$user);

		$ordermodel = $this->model('Payorder');
		$opencountlist = $ordermodel->getOrderDetailList(array('crid'=>$roominfo['crid'],'status'=>1,'limit'=>'0,100'));
		//new
		if($domain == 'jx') {
			$opencountlist = array();
		}
		//获取公告
		$announcement = $this->model('sendinfo');
		$annparam['crid'] = $roominfo['crid'];
		$annparam['limit'] = 3;
		$announcementlist = $announcement->getSendList($annparam);
		//获取详情,供浮动广告
		$roommodel = $this->model('classroom');
		$roomdetail = $roommodel->getclassroomdetail($roominfo['crid']);
		$this->assign('roomdetail',$roomdetail);
		//动态资讯
		$crid = $roominfo['crid'];
		$mmodel = $this->model('item');
		$params = array('catid'=>686,'crid'=>$crid,'folder'=>1,'limit'=>'0,6','order'=>'i.lastpost desc');
		$mitemlist = $mmodel->getitemzwx($params);
		$this->assign('mitemlist', $mitemlist);
		
		$this->assign('announcementlist',$announcementlist);
		$this->assign('opencountlist',$opencountlist);
	}
	function _show_hnm(){
		
		//教师名字
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $roominfo['uid'];
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getteachername($uid);
		$this->assign('teacher', $teacher);
		//子网校数量
		
		$crid = $roominfo['crid'];
		$classroommodel = $this->model('classroom');
		$zwxcount = $classroommodel->getzwxcount($crid);
		$this->assign('zwxcount', $zwxcount);
		//学习子站
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc','limit'=>'0,100');
		$zwxlist = $classroommodel->getzwxlist($param);
		$this->assign('zwxlist', $zwxlist);
		//
		$mmodel = $this->model('item');
		$params = array('catid'=>686,'crid'=>$crid,'folder'=>2,'limit'=>'0,15','displayorder'=>'displayorder,itemid desc');
		$mitemlist = $mmodel->getitemzwx($params);

		$this->assign('mitemlist', $mitemlist);
		
		
		$courseparam = array('crid'=>$roominfo['crid'],'limit'=>'0,8','order'=>'c.viewnum desc,c.displayorder asc');
        $coursemodel  = $this->model('Courseware');
        $hotcourselist = $coursemodel->getCWlistForPlatform($courseparam);
        $this->assign('hotcourselist', $hotcourselist);
		
		$newsparam['crid'] = $roominfo['crid'];
		$newsparam['catid'] = 686;
		$newsparam['limit'] = '0,8';
		$newslist = $this->model('item')->getSimpleList($newsparam);
		$this->assign('newslist',$newslist);
		
		$midadparam['crid'] = $roominfo['crid'];
		$midadparam['catid'] = 256;
		$midadparam['limit'] = '0,3';
		$midadlist = $this->model('item')->getSimpleList($midadparam);
		$this->assign('midadlist',$midadlist);
	}
	function _show_stores(){
		$roominfo = Ebh::app()->room->getcurroom();
		$toid = $roominfo['crid'];
		$type = 'announcement';
		$sendinfomodel = $this->model('sendinfo');
		$roominfolist = $sendinfomodel->getsend($toid,$type);
		$this->assign('roominfolist', $roominfolist);
		//网校信息
		$classroommodel = $this->model('classroom');
		$crid = $toid;
		$roomlist = $classroommodel->getdetailclassroom($crid);
		$this->assign('roomlist', $roomlist);

		//大纲导航
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'displayorder'=>'f.displayorder','coursewarenum'=>1,'limit'=>'0,6');
		$folderchachekey = $this->cache->getcachekey('folder',$param);
		$folderlist = $this->cache->get($folderchachekey);
		if(empty($folderlist)) {
			$folderlist = $foldermodel->getfolderlist($param);
			$this->cache->set($folderchachekey,$folderlist,300);
		}
		$this->assign('folderlist', $folderlist);
		$para = array('crid'=>$crid);
		$foldercountkey = $this->cache->getcachekey('folder',$para);
		$foldercount = $this->cache->get($foldercountkey);
		if(empty($foldercount)) {
			$foldercount = $foldermodel->getcount($para);
			$this->cache->set($foldercountkey,$foldercount,300);
		}
		$this->assign('foldercount', $foldercount);

	}
	function _show_hzxx(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'displayorder'=>'f.displayorder','coursewarenum '=>1,'upid'=>0,'limit'=>'0,12');
		$folderlist = $foldermodel->getfolderlist($param);
		$this->assign('folderlist', $folderlist);

		$classroommodel = $this->model('classroom');
		$para = array('status'=>1,'isfree'=>1,'crid'=>$crid,'displayorder'=>'cdisplayorder ASC','limit'=>'0,100');
		$classlist = $classroommodel->getfreecourse($para);
		$this->assign('classlist', $classlist);
	}
	
	/*
	*/
	function _show_zhh(){
		
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $roominfo['uid'];
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getteachername($uid);
		$this->assign('teacher', $teacher);
		$crid = $roominfo['crid'];
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'displayorder'=>'displayorder asc','limit'=>'0,100');
		$folderslist = $foldermodel->getfolderlist($param);

		$this->assign('folderslist', $folderslist);
	
	}
//	function _show_sf(){
//	//大纲导航
//		$roominfo = Ebh::app()->room->getcurroom();
//		$crid = $roominfo['crid'];
//		$foldermodel = $this->model('folder');
//		$param = array('crid'=>$crid,'folderlevel'=>1,'displayorder'=>'displayorder asc','coursewarenum'=>1,'limit'=>'0,9');
//		$folderlist = $foldermodel->getfolderlist($param);
//		$this->assign('folderlist', $folderlist);
//	}
	//默认模版
	function _show_default() {
		//大纲导航
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'folderlevel'=>1,'coursewarenum'=>0,'displayorder'=>'displayorder asc','limit'=>'0,12');
		$folderlist = $foldermodel->getfolderlist($param);
		$this->assign('folderlist', $folderlist);
		//免费试听
		$classroommodel = $this->model('classroom');
		$para = array('crid'=>$crid,'status'=>1,'isfree'=>1,'displayorder'=>'r.cdisplayorder ASC,cw.displayorder ASC,cw.dateline DESC','limit'=>'0,12');
		$classroomlist = $classroommodel->getfreecourse($para);
		$this->assign('classroomlist', $classroomlist);
	 }
	 /**
	 *页面跳转到总站主页方法
	 */
	 private function _redirect_index() {
        $url = 'http://www.ebh.net/';
        header("Location: $url");
        exit;
	 }
	 /**
	 *杭四中(hsz)模板
	 */
	 function _show_hsz(){
		//公告
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$showtype = intval($this->uri->uri_attr(1));
		$frompage = intval($this->uri->uri_attr(2));
		if(empty($showtype)){
			if(empty($frompage)){
				$showtype = 1;
			}else{
				$showtype = 0;
			}
		}
		if(!in_array($showtype, array(0,1,2,3))){
			$showtype = 1;
		}
		$this->assign('showtype',$showtype);

		//获取学校所有课程
		$folderParam = array(
			'crid'=>$roominfo['crid'],
			'folderlevel'=>1,
			'nosubfolder'=>1,
			'limit'=>10000
		);
		$folders = $this->model('folder')->getfolderlist($folderParam);
		$this->assign('folders',$folders);

		//判断用户是否在该学校里面
		$inRoom = true;
		if(!empty($user) && !empty($roominfo)){
			$roommodel = $this->model('Classroom');
			if($user['groupid'] == 6){//学生
				$check = $roommodel->checkstudent($user['uid'], $roominfo['crid']);
			}else if($user['groupid'] == 5){//老师
				$check = $roommodel->checkteacher($user['uid'], $roominfo['crid']);
			}
			if($check == -1){
				$inRoom = false;
			}
		}else{
			$inRoom = false;
		}
		$this->assign('inRoom',$inRoom);
		if($inRoom && $user['groupid'] == 6){
			//获取学生在该校的信息
			$classesModel = $this->model('classes');
			$classInfo = $classesModel->getClassByUid($roominfo['crid'],$user['uid']);
			if(!empty($classInfo)){
				$mygrade = $classInfo['grade'];
			}else{
				$mygrade = 0;
			}
			$this->assign('mygrade',$mygrade);

			//获取我的年级的课程folderid
			$folderid_in = array();
			foreach ($folders as $folder) {
				if($folder['grade'] == $mygrade){
					$folderid_in[] = $folder['folderid'];
				}
			}
		}else if($inRoom && $user['groupid'] == 5){
			//获取老师所教课程信息
			$t_param = array(
				'uid'=>$user['uid'],
				'crid'=>$roominfo['crid']
			);
			$t_folderlist = $this->model('folder')->getTeacherFolderList($t_param);
			$folderid_in = array();
			if(!empty($t_folderlist[$user['uid']])){
				foreach ($t_folderlist[$user['uid']]['folder'] as $folder) {
					$folderid_in[] = $folder['folderid'];
				}
			}
		}
		$toid = $roominfo['crid'];
		$type = 'announcement';
		$sendinfomodel = $this->model('sendinfo');
		$send = $sendinfomodel->getsend($toid,$type);
		$this->assign('send', $send);
		

		
		//获取答疑
		$askquestionModel = $this->model('askquestion');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['shield'] = 0;
		
		//我的问题参数设置
		if(!empty($user)){
			if($user['groupid'] == 6 && ($showtype == 1 || $showtype == 3) ){
				$param['uid'] = $user['uid'];
			}else if($user['groupid'] == 5 && ($showtype == 1) || $showtype == 3){
				$param['tid'] = $user['uid'];
			}
		}
		//课程问题
		$folderid = 0;
		if( !empty($folderid_in) && ($showtype  == 2 || $showtype == 3) ){
			$param['folderid_in'] = '('.implode(',', $folderid_in).')';
		}
		$folderid = $param['folderid'] = intval($this->uri->uri_attr(0));
		// var_dump($param);
		$askList = $askquestionModel->getRequiredAnswers($param);
		//数据中用户信息填充
		$askList = EBH::app()->lib('UserUtil')->init($askList,array('uid','tid','lastansweruid'),true);
		$askListCount = $askquestionModel->getRequiredAnswersCount($param);
		$pageStr = show_page($askListCount,$param['pagesize']);
		$this->assign('askList',$askList);
		$this->assign('pageStr',$pageStr);

		//获取关联问题信息
		$reqids = array();
		if(!empty($askList)){
			foreach ($askList as $ask) {
				if($ask['reqid']>0)
				$reqids[] = $ask['reqid'];
			}
		}
		$reqs = $askquestionModel->getReQuestionList($reqids);
		$reqsWithKey = array();
		if(!empty($reqs)){
			foreach ($reqs as  $req) {
				$key = 'req_'.$req['qid'];
				if($req['shield'] == 1) continue;
				$reqsWithKey[$key] = $req;
			}
		}
		$this->assign('reqsDb',$reqsWithKey);
		$this->assign('q',$param['q']);

		$checkedFolder = $this->model('folder')->getfolderbyid($folderid);
		$this->assign('checkedFolder',$checkedFolder);
	
	}
	
	function _show_hz2z() {
		//大纲导航
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$announcement = $this->model('sendinfo');
		$annparam['crid'] = $roominfo['crid'];
		$annparam['limit'] = 1;
		$announcementlist = $announcement->getSendList($annparam);
		$this->assign('announcementlist',$announcementlist);
		
	 }
	 
	 
	function _show_zho(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取服务包
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
		$sortlist = array();	//服务分类数组，用于存放包含收费服务项的分类
		//根据pid合集获取服务项
		if(!empty($spidlist)) {
			$pitemmodel = $this->model('PayItem');
			$power = '0';
			$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','needsid'=>true,'power'=>$power);
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
		
		//动态资讯
		$crid = $roominfo['crid'];
		$mmodel = $this->model('item');
		$params = array('catid'=>686,'crid'=>$crid,'folder'=>1,'limit'=>'0,4','order'=>'i.lastpost desc');
		$mitemlist = $mmodel->getitemzwx($params);
		$this->assign('mitemlist', $mitemlist);
		
		//开通学生列表
		$ordermodel = $this->model('Payorder');
		$opencountlist = $ordermodel->getOrderDetailList(array('crid'=>$roominfo['crid'],'status'=>1,'limit'=>'0,100'));
		$this->assign('opencountlist',$opencountlist);
		$this->assign('splist',$splist);
		$this->assign('sortlist',$sortlist);
		$this->assign('mylist',$mylist);
		$this->assign('user',$user);

	}
	
	
	/**
	*浙江东方
	*/
	function _show_zjdf(){
		$domain = $this->uri->uri_domain();
		$user = Ebh::app()->user->getloginuser();
		//教师名字
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $roominfo['uid'];
		$teachermodel = $this->model('teacher');
		$teacher = $teachermodel->getteachername($uid);
		$this->assign('teacher', $teacher);
		//获取服务包
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
		$sortlist = array();	//服务分类数组，用于存放包含收费服务项的分类
		//根据pid合集获取服务项
		if(!empty($spidlist)) {
			$pitemmodel = $this->model('PayItem');
			$power = '0';
			$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>$power);
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
		$this->assign('splist',$splist);
		$this->assign('sortlist',$sortlist);
		$this->assign('mylist',$mylist);
		$this->assign('user',$user);

		//new
		//获取公告
		$announcement = $this->model('sendinfo');
		$annparam['crid'] = $roominfo['crid'];
		$annparam['limit'] = 3;
		$announcementlist = $announcement->getSendList($annparam);
		//获取详情,供浮动广告
		$roommodel = $this->model('classroom');
		$roomdetail = $roommodel->getclassroomdetail($roominfo['crid']);
		$this->assign('roomdetail',$roomdetail);
		//动态资讯
		$crid = $roominfo['crid'];
		$mmodel = $this->model('item');
		$params = array('catid'=>686,'crid'=>$crid,'folder'=>1,'limit'=>'0,2','order'=>'i.lastpost desc');
		$mitemlist = $mmodel->getitemzwx($params);
		$this->assign('mitemlist', $mitemlist);
		
		$this->assign('announcementlist',$announcementlist);
		
		$classroom = $this->model('classroom');
		$classroomchachekey = $this->cache->getcachekey('classroom',$crid);
		$classroommess = $this->cache->get($classroomchachekey);
		if(empty($classroommess)) {
			$classroommess = $classroom->getdetailclassroom($crid);
			$this->cache->set($classroomchachekey,$classroommess,300);
		}
		$this->assign('classroommess', $classroommess);
	}
	
	/*
	浙江高校教师专业发展网校
	*/
	public function _show_zjg(){
		$roominfo = Ebh::app()->room->getcurroom();
		$toid = $roominfo['crid'];
		$type = 'announcement';
		$sendinfomodel = $this->model('sendinfo');
		$send = $sendinfomodel->getsend($toid,$type);
		$this->assign('send', $send);
	}
}
