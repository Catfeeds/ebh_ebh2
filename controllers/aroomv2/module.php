<?php 
class ModuleController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	
	public function index(){
        $roominfo = Ebh::app()->room->getcurroom();
        if ($roominfo['template'] == 'plate') {
            $this->assign('plate', true);
        }
		$this->display('aroomv2/module');
	}
	
	public function manage(){
		$roominfo = Ebh::app()->room->getcurroom();
		
		
		$ammodel = $this->model('appmodule');
		
		//本网校可选的模块
		
		$tors = $this->input->get('tors')?1:0;
		$roommodulelist = $ammodel->getroommodulelist(array('crid'=>$roominfo['crid'],'order'=>'displayorder','tors'=>$tors));
		// var_dump($roommodulelist);
		$param = array();
		if(empty($roommodulelist))
			$param['system'] = 1;
		$param['limit'] = 100;
		$this->assign('tors',$tors);
		$param['tors'] = $tors .',2';
		$param['showmode'] = 0;
		//所有可选的模块
		// var_dump($param);
		$modulelist = $ammodel->getmodulelist($param);
		
		// var_dump($modulelist);
		$modulekvlist = array();
		
		foreach($modulelist as $module){
			$modulekvlist[$module['moduleid']] = $module;
		}
		// var_dump($modulekvlist);
		if(!empty($roommodulelist)){//设置过模块的
			$modulelist = array();
			$morelist = array();
			foreach($roommodulelist as $roommodule){
				// var_dump($roommodule);
				if(in_array($roommodule['moduleid'],array_keys($modulekvlist))){
					$temp = $modulekvlist[$roommodule['moduleid']];
					$temp['available'] = $roommodule['available'];
					$temp['nickname'] = $roommodule['nickname'];
					$temp['ismore'] = $roommodule['ismore'];
					if($temp['ismore']){
						$morelist[] = $temp;
					}
					else{
						$modulelist[] = $temp;
					}
				}
			}
		}else{//从未设置过模块的
			foreach($modulelist as $k=>$module){
				if($module['ismore']){
					$morelist[] = $module;
					unset($modulelist[$k]);
				}
			}
		}
		if($tors == 0){
			foreach($modulelist as $k=>$m){//更多放到最后
				if($m['modulecode'] == 'more'){
					$more = $m;
					unset($modulelist[$k]);
					break;
				}
			}
			$modulelist[] = $more;
		}
		// var_dump($modulelist);
		if(!empty($morelist))
			$this->assign('morelist',$morelist);
		$this->assign('modulelist',$modulelist);
		//只有系统模块(未曾有过数据的)
		$this->assign('onlysystem',empty($param['system'])?0:$param['system']);
		$this->display('aroomv2/module_manage');
	}
	
	/*
	myroom,troomv2模块
	*/
	public function savemodule(){
		$roominfo = Ebh::app()->room->getcurroom();
		$namearr = $this->input->post('modulename');
		$codearr = $this->input->post('modulecode');
		$nicknamearr = $this->input->post('nickname');
		$availablearr = $this->input->post('available');
		$moduleidarr = $this->input->post('moduleid');
		$ismorearr = $this->input->post('ismore');
		if(count($namearr) == count($codearr) && count($namearr) == count($availablearr) && count($namearr) == count($nicknamearr) && count($namearr) == count($ismorearr)){
			// var_dump(1111);
			foreach($namearr as $k=>$name){
				$setarr[$k]['modulename'] = $name;
				$setarr[$k]['modulecode'] = $codearr[$k];
				$setarr[$k]['nickname'] = $nicknamearr[$k];
				$setarr[$k]['available'] = $availablearr[$k];
				$setarr[$k]['moduleid'] = $moduleidarr[$k];
				$setarr[$k]['ismore'] = $ismorearr[$k];
				
			}
			$param['crid'] = $roominfo['crid'];
			$param['tors'] = $this->input->get('tors');
			$param['modulearr'] = $setarr;
			$ammodel = $this->model('appmodule');
			$res = $ammodel->savemodule($param);
			/*
			$param['myroomleft'] = serialize($setarr);
			$crmodel = $this->model('classroom');
			$res = $crmodel->editclassroom($param);*/
			if($res !== false)
				echo 1;
			
		}
	}
	
	/*
	首页模块
	*/
	public function saveindexmodule(){
		$roominfo = Ebh::app()->room->getcurroom();
		$mArr['mlv1'] = $this->input->post('mlv1');
		$mArr['mleft'] = $this->input->post('mleft');
		$mArr['mcenter'] = $this->input->post('mcenter');
		$mArr['mright'] = $this->input->post('mright');
		$mArr['mdeleted'] = $this->input->post('mdeleted');
		// var_dump($mArr);
		$mStr = serialize($mArr);
		$param['crid'] = $roominfo['crid'];
		$param['custommodule'] = $mStr;
		$amodel = $this->model('classroom');
		$amodel->editclassroom($param);
		//更新网校域名相关缓存
		$roomcache = Ebh::app()->lib('Roomcache');
		$roomcache->removeCache(0,'roominfo',$roominfo['domain']);	//清空roominfo缓存
		$roomcache->removeCache($param['crid'],'roominfo','detail');	//清空roominfo roomdetail缓存
	}
	
	public function custommodule(){
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
	
		//开通的学生列表
		$ordermodel = $this->model('Payorder');
		$opencountlist = $ordermodel->getOrderDetailList(array('crid'=>$roominfo['crid'],'status'=>1,'limit'=>'0,7'));
		
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
		$mmodel = $this->model('news');
		$params = array('navcode'=>'news','crid'=>$roominfo['crid'],'status'=>1,'limit'=>'0,6');
		$mitemlist = $mmodel->getnewslist($params);
		$this->assign('mitemlist', $mitemlist);
		
		$this->assign('announcementlist',$announcementlist);
		$this->assign('opencountlist',$opencountlist);
		
		//积分排名
		$creditmodel = $this->model('credit');
		$creditlist = $creditmodel->getRankList(array('crid'=>$roominfo['crid'],'limit'=>15));
		$this->assign('creditlist',$creditlist);
		
		//学员动态
		$plmodel = $this->model('playlog');
		$param = array('crid'=>$roominfo['crid'],'limit'=>'5');
		$studylist = $plmodel->getRoomRecentLog($param);
		$this->assign('studylist', $studylist);
		//课件排行
		$rcmodel = $this->model('roomcourse');
		$courseranklist = $rcmodel->getRoomCourseRankList(array('crid'=>$roominfo['crid'],'limit'=>10,'order'=>'viewnum desc'));
		$this->assign('courseranklist',$courseranklist);
		//获取新闻资讯记录
		$nitemparam = array('best'=>1,'catid'=>686,'type'=>'news','limit'=>'0,6','displayorder'=>'displayorder,itemid desc');
		$itemmodel  = $this->model('Item');
		$newslist = $itemmodel->getitemlist($nitemparam);
        $this->assign('newslist', $newslist);
		//头部广告
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		//橱窗广告
		$admodel = $this->model('Ad');
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'centersponsor','folder'=>2,'limit'=>'0,5');
		$headadkey = $this->cache->getcachekey('ad',$param);
        $adlistm = $this->cache->get($headadkey);
        if(empty($adlistm)) {
            $adlistm = $admodel->getAdList($param);
            $this->cache->set($headadkey,$adlistm,600);
        }
		$this->assign('adlistm',$adlistm);
		//自定义富文本
		$custommessage = $roommodel->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>1));
		$this->assign('custommessage',$custommessage);
		
		//APP
		$app = $roommodel->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>1));
		if(!empty($app[0])){
			$appstr = $app[0];
			$applist = unserialize($appstr['appstr']);
			$this->assign('applist',$applist);
		}
		
		//免费试看片
		$cwmodel = $this->model('courseware');
		$freelist = $cwmodel->getfolderseccourselist(array('crid'=>$roominfo['crid'],'status'=>1,'isfree'=>1,'limit'=>100,'freeorder'=>'f.displayorder,f.folderid DESC,sdisplayorder ASC,s.sid ASC,r.cdisplayorder ASC,cw.displayorder ASC,cw.cwid DESC'));
		$this->assign('freelist',$freelist);
		
		//调查问卷
		$surveylist = $this->model('survey')->getSurveyList(array('crid' => $roominfo['crid'],'type' => 0,'ispublish' => 1,'limit' => 6));
		$this->assign('surveylist', $surveylist);
		
		//页面动态广告
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'pagesmall','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlistp = $this->cache->get($roomadkey);
		if(empty($adlistp)) {
			$admodel = $this->model('Ad');        
			$adlistp = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlistp,600);
		}
		$this->assign('adlistp', $adlistp);
		
		//自定义富文本(大)
		$custommessagebb = $roommodel->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>2));
		$this->assign('custommessagebb',$custommessagebb);
		
		//初始化
		$init = $this->input->get('init');
		if($init)
			$mArr = array();
		else{
			$mstr = $roomdetail['custommodule'];
			$mArr = unserialize($mstr);
		}
		$this->assign('mArr',$mArr);
		
		
		$this->display('shop/drag/index_edit');
	}

	/*
	微信二维码图片保存
	*/
	public function savewechat(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uploadarr = $this->input->post('wechatimg');
		$wechatimg = $uploadarr['upfilepath'];
		$crmodel = $this->model('classroom');
		$crmodel->editclassroom(array('crid'=>$roominfo['crid'],'wechatimg'=>$wechatimg));
		
	}
	
	/*
	自定义富文本保存
	*/
	public function savecustommessage(){
		$roominfo = Ebh::app()->room->getcurroom();
		$custommessage = $this->input->post('custommessage');
		$index = $this->input->post('index');
		if(!is_numeric($index) && !is_numeric(ltrim($index,'n')))
			exit;
		$crmodel = $this->model('classroom');
		$param['crid'] = $roominfo['crid'];
		$param['custommessage'] = $custommessage;
		if(isset($index))
			$param['index'] = '\''.$index.'\'';
		$crmodel->editcustommessage($param);
		updateRoomCache($roominfo['crid'],'custommessage');
	}
	
	/*
	免费试看片课程
	*/
	public function freecourse(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$foldermodel = $this->model('folder');
		$page = $this->uri->page;
		$folderlist = $foldermodel->getfolderlist(array('crid'=>$roominfo['crid'],'nosubfolder'=>1,'limit'=>1000), true);
		$this->assign('folderlist', $folderlist);
		$folderids = '';
		$folderlistByFolderid = array();
		foreach($folderlist as $folder){
			$folder['pname'] = '其他课程';
			$folderlistByFolderid[$folder['folderid']] = $folder;
			$folderids.= $folder['folderid'].',';
		}
		$folderids = rtrim($folderids,',');
		$folderByPid = array();
		if(!empty($folderids) && $roominfo['isschool'] == 7){
			$packagemodel = $this->model('Paypackage');
			$packages = $packagemodel->getPackByFolderid(array('folderids'=>$folderids,'crid'=>$roominfo['crid']));
			// var_dump($packages);
			foreach($packages as $package){
				if(empty($folderByPid[$package['pid']]))
					$folderByPid[$package['pid']] = array($package);
				else
					$folderByPid[$package['pid']][] = $package;
				unset($folderlistByFolderid[$package['folderid']]);
			}
			sort($folderlistByFolderid);
			$folderByPid[0] = $folderlistByFolderid;
		}
		// var_dump($folderByPid);
		$this->assign('roominfo',$roominfo);
		$this->assign('folderbypid',$folderByPid);
		$this->display('shop/drag/courselist');
	}
	
	/*
	免费试看片课件
	*/
	public function freecourse_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		if(!in_array($folder['power'],array(0,1))){
			show_404();
			exit;
		}
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		if(in_array($roominfo['crid'],$cridarr['noteacher']))
			$this->assign('needsubfolder',false);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		// if(empty($roominfo['checktype'])){
			$queryarr['status'] = '1';
		// }else{
			// $queryarr['status'] = '0,1,-2';
		// }
		$queryarr['limit'] = 100;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        // $count = $coursemodel->getfolderseccoursecount($queryarr);
        // $pagestr = show_page($count);
        $pagestr = '';
        $sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			$viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
			if(!empty($viewnum))
				$course['viewnum'] = $viewnum;
            $sectionlist[$course['sid']][] = $course;
        }
		foreach($sectionlist as $k=>$section){
			$queryarr['sid'] = $k;
			$sectioncount = $coursemodel->getfolderseccoursecount($queryarr);
			$sectionlist[$k][0]['sectioncount'] = $sectioncount;
		}
        $this->assign('sectionlist', $sectionlist);
        $this->assign('pagestr', $pagestr);
        $this->assign('folderid',$folderid);
        $this->assign('roominfo',$roominfo);
        
        $this->display('shop/drag/cwlist');
	}
	
	/*
	保存免费试看片
	*/
	public function savefreecourse(){
		$checkarr = $this->input->post('checkarr');
		$roominfo = Ebh::app()->room->getcurroom();
		$rcmodel = $this->model('roomcourse');
		if(!empty($checkarr)){
			$rcmodel->updatefreecourse(array('crid'=>$roominfo['crid'],'checkarr'=>$checkarr));
		}
	}
	/*
	获取免费课件列表
	*/
	public function getfreecourse(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cwmodel = $this->model('courseware');
		$freelist = $cwmodel->getfolderseccourselist(array('crid'=>$roominfo['crid'],'status'=>1,'isfree'=>1,'limit'=>100,'freeorder'=>'f.displayorder,f.folderid DESC,sdisplayorder ASC,s.sid ASC,r.cdisplayorder ASC,cw.displayorder ASC,cw.cwid DESC'));
		echo json_encode($freelist);
	}
	
	//drag模板首页导航
	public function navigator(){
		
		$roominfo = Ebh::app()->room->getcurroom();
		$navigatorlist = Ebh::app()->getConfig()->load('roomnav');
		$defaultnav = array_keys($navigatorlist);
		$crmodel = $this->model('classroom');
		$roomnav = $crmodel->getNavigator($roominfo['crid']);
		
		if(!empty($roomnav)){
			$navigatordata = unserialize($roomnav);
			// var_dump($navigatordata);
			$navigatorarr = $navigatordata['navarr'];
			krsort($navigatorarr);
			$indexstr = '';
			foreach($navigatorarr as $nav){
				$temp = $nav;
				if(!empty($navigatorlist[$nav['code']])){
					unset($navigatorlist[$nav['code']]);
				}else{
					$indexstr .= '\''.$nav['code'].'\',';
				}
				if($temp['code'] != 'index')
					array_unshift($navigatorlist,$temp);
				else
					$navindex = $temp;
			}
			if (!empty($navindex)) {
                array_unshift($navigatorlist,$navindex);
            }
			
		}
		foreach($navigatorlist as $k=>$nav){
			if($nav['code'] == 'fineware' && $roominfo['template'] != 'plate'){//不是plate模板的，不显示精品课件
				unset($navigatorlist[$nav['code']]);
			}
			if($nav['code'] == 'shop')//商城的，设定为系统
				$defaultnav[] = 'shop';
		}
	
		$this->assign('defaultnav',$defaultnav);
		$this->assign('navigatorlist',$navigatorlist);
		$this->display('aroomv2/module_navigator');
	}
	
	/*
	保存导航
	*/
	public function savenavigator(){
		$roominfo = Ebh::app()->room->getcurroom();
		$namearr = $this->input->post('name');
		$codearr = $this->input->post('code');
		$nicknamearr = $this->input->post('nickname');
		$availablearr = $this->input->post('available');
		$urlarr = $this->input->post('url');
		$targetarr = $this->input->post('target');
		// $custommessagearr = $this->input->post('custommessage');
		$navigatorlist = Ebh::app()->getConfig()->load('roomnav');
		$defaultnav = array_keys($navigatorlist);
		// var_dump($availablearr);
		
		$submitarr = array('name','code','nickname','available','url','target');
		$submitcount = 0;
		foreach($submitarr as $code){
			$thearr = $code.'arr';
			if(empty($submitcount)){
				$submitcount = count($$thearr);
			}elseif(count($$thearr) != $submitcount){
				return false;
			}
		}
		if(1){
			$parentindexarr = $this->input->post('parentindex');
			$lastparent = '';
			$subarr = array();
            if (!empty($parentindexarr)) {
                foreach($parentindexarr as $parentindex){
                    if($lastparent != $parentindex){
                        $subcodevar = $parentindex.'subcodearr';
                        $subnicknamevar = $parentindex.'subnicknamearr';
                        $subavailablevar = $parentindex.'subavailablearr';
                        // $$subcodevar = $this->input->post($parentindex.'subcode');
                        // $$subnicknamevar = $this->input->post($parentindex.'subnickname');
                        // $$subavailablevar = $this->input->post($parentindex.'subavailable');
                        $subcodearr = $this->input->post($parentindex.'subcode');
                        $subnicknamearr = $this->input->post($parentindex.'subnickname');
                        $subavailablearr = $this->input->post($parentindex.'subavailable');
                        // var_dump($$subcodevar);
                        // var_dump($$subnicknamevar);
                        $lastparent = $parentindex;
                        foreach($subcodearr as $k=>$subcode){
                            $subarr[$parentindex][$k]['subcode'] = $subcode;
                            $subarr[$parentindex][$k]['subnickname'] = $subnicknamearr[$k];
                            $subarr[$parentindex][$k]['subavailable'] = $subavailablearr[$k];

                        }
                    }

                }
            }

			// var_dump($subarr);
			foreach($namearr as $k=>$name){
				$setarr['navarr'][$k]['name'] = $name;
				$setarr['navarr'][$k]['code'] = $codearr[$k];
				$setarr['navarr'][$k]['nickname'] = $nicknamearr[$k];
				$setarr['navarr'][$k]['available'] = $availablearr[$k];
				$setarr['navarr'][$k]['url'] = $urlarr[$k];
				$setarr['navarr'][$k]['target'] = $targetarr[$k];
				$code = $codearr[$k];
				if(!in_array($code,$defaultnav) && !empty($subarr[$code]))
					$setarr['navarr'][$k]['subnav'] = $subarr[$code];
					// $cmlist[$codearr[$k]] = $custommessagearr[$k];
			}
			// foreach()
			// var_dump($setarr);
			$param['crid'] = $roominfo['crid'];
			$param['navigator'] = serialize($setarr);
			if(mb_strlen($param['navigator'],'UTF-8')>5000){
				echo 0;
				exit;
			}
			$crmodel = $this->model('classroom');
			$res = $crmodel->editclassroom($param);
            $roomcache = Ebh::app()->lib('Roomcache');
            $roomcache->removeCache($roominfo['crid'],'navigator','plate-navigation');
			if($res !== false) {
				echo 1;
				
				//更新导航成功后刷新导航相关缓存
				updateRoomCache($roominfo['crid'],'navigator');
			}
			// if(!empty($cmlist))
				// $crmodel->editcms(array('crid'=>$roominfo['crid'],'cmlist'=>$cmlist));
		}
	}
	
	/*
	获取导航的自定义文本
	*/
	public function getnavcm(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crmodel = $this->model('classroom');
		$index = $this->input->get('index');
		$custommessage = $crmodel->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>'\''.$index.'\''));
		if(!empty($custommessage))
			echo $custommessage[0]['custommessage'];
	}
	
	/*
	编辑自定义文本
	*/
	public function navcm(){
		$index = $this->input->get('index');
		if(!is_numeric($index) && !is_numeric(ltrim($index,'n')))
			exit;
		$roominfo = Ebh::app()->room->getcurroom();
		$crmodel = $this->model('classroom');
		$custommessage = $crmodel->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>'\''.$index.'\''));
		$cm = '';
		if(!empty($custommessage))
			$cm = $custommessage[0]['custommessage'];
		$this->assign('custommessage',$cm);
		$this->display('aroomv2/module_navcm');
	}
	
	/*
	删除自定义文本
	*/
	public function delcm(){
		$roominfo = Ebh::app()->room->getcurroom();
		$index = $this->input->post('index');
		if(!is_numeric($index) && !is_numeric(ltrim($index,'n')) && !is_numeric(preg_replace('/n\d+s/','',$index)))
			exit;
		
		$crmodel = $this->model('classroom');
		$crmodel->delcustommessage(array('crid'=>$roominfo['crid'],'index'=>$index));
		$newsmodel = $this->model('news');
		$newsmodel->_update(array('status'=>0,'navcode'=>'deleted'),array('crid'=>$roominfo['crid'],'navcode'=>$index));
		updateRoomCache($roominfo['crid'],'custommessage');
	}
	
}
?>