<?php
class CourseinfoController extends CControl{
	public function view(){
        $room = Ebh::app()->room->getcurroom();
        $itemid = $this->uri->itemid;
        if ($room['template'] == 'plate') {
            Ebh::app()->runAction('room/portfolio', 'courseinfo');
            return;
        }

		if(empty($itemid) || !is_numeric($itemid))
			exit;
		$itemdetail = $this->model('Payitem')->getItemByItemid($itemid);
		if(empty($itemdetail))
			exit;
		$user = Ebh::app()->user->getloginuser();

		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $itemdetail['folderid'];
		$queryarr['pagesize'] = 1000;
		$queryarr['status'] = 1;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        // $count = $coursemodel->getfolderseccoursecount($queryarr);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		$param = array('crid'=>$room['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		$this->assign('user',$user);
		$this->assign('room',$room);
		$this->assign('itemdetail',$itemdetail);
		$this->assign('sectionlist',$sectionlist);
		
		if($room['template'] == 'drag')
			$this->display('shop/drag/courseinfo');
		else
			$this->display('shop/one/courseinfo');
	}
	
	public function zhh_view(){
		$room = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getFolderByid($folderid);
		$queryarr['folderid'] = $folderid;
		$queryarr['pagesize'] = 1000;
		$queryarr['status'] = 1;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
		$sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		
		$param = array('crid'=>$room['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		$this->assign('room',$room);
		$this->assign('folder',$folder);
		$this->assign('sectionlist',$sectionlist);
		$this->display('shop/zhh/courseinfo');
	}
	
	/*
	大学生后台，未开通服务项查看
	*/
	public function college_view(){
		$itemid = $this->uri->itemid;
		if(empty($itemid) || !is_numeric($itemid))
			exit;
		$itemdetail = $this->model('Payitem')->getItemByItemid($itemid);
		if(empty($itemdetail))
			exit;
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $itemdetail['folderid'];
		$queryarr['pagesize'] = 1000;
		$queryarr['status'] = 1;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        // $count = $coursemodel->getfolderseccoursecount($queryarr);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		$param = array('crid'=>$room['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		if (!empty($user)) {
            $itemdetail['js_item'] = $this->_sort_detail($itemdetail, $user, $room);
        }

        //print_r($itemdetail);exit;
		$this->assign('adlist', $adlist);
		$this->assign('user',$user);
		$this->assign('room',$room);
		$this->assign('itemdetail',$itemdetail);
		$this->assign('sectionlist',$sectionlist);
		$this->display('common/courseinfo');
		
	}
	
	
	/*
	课程介绍与课件列表
	*/
	public function new_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 300;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
		
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('folder',$folderid);
		if(!empty($folder['introduce']))
			$folder['introduce'] = unserialize($folder['introduce']);
		$this->assign('folder',$folder);
		
		
		if(empty($folder['playmode']) || empty($queryarr['q'])){
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
			$cwcount = $coursemodel->getfolderseccoursecount($queryarr);
			$this->assign('cwcount',$cwcount);
		}
		else{
			$searchedcwlist = $coursemodel->getfolderseccourselist($queryarr);
			unset($queryarr['q']);
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
	
		
		if(!empty($cwlist)){
		
		$cwids = '';
		foreach($cwlist as $cw){
			$cwids.= $cw['cwid'].',';
		}
		$cwids = rtrim($cwids,',');
		$param['cwid'] = $cwids;
		$param['uid'] = $user['uid'];
		/*
		$pmodel = $this->model('progress');
		$progresslist = $pmodel->getFolderProgressByCwid($param);
		
		foreach($progresslist as $k=>$p){
			if($p['percent']*100>=90){
				$cwprogress[$p['cwid']] = 100;
			}
			else{
				$cwprogress[$p['cwid']] = floor($p['percent']*100);
			}
		}
		foreach($cwlist as $k=>$cw){
			if(!empty($cwprogress[$cw['cwid']]))
				$cwlist[$k]['percent'] = $cwprogress[$cw['cwid']];
			else
				$cwlist[$k]['percent'] = 0;
		}*/
		// var_dump($cwlist);
		}
		
		//收藏信息
		/*
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getfolderfavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		*/
		$sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($cwlist as $k=>$course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			if(($k-1)>=0 && $cwlist[$k-1]['sid'] == $course['sid']){
				if($cwlist[$k-1]['percent'] != 100 || !empty($cwlist[$k-1]['disabled'])){
					$cwlist[$k]['disabled'] = true;
					$course['disabled'] = true;
				}
				
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
		
		
		if(!empty($q) && $folder['playmode']){//搜索时按序播放
			// $lastsid = 0;
			$resultSection = array();
			if(!empty($searchedcwlist)){//搜索结果不为空
				foreach($searchedcwlist as $cw){
					if(!empty($cw['sid']))
						$sid = $cw['sid'];
					else
						$sid = 0;
					$resultSection[] = $sid; 
					if(!isset($lastsid))
						$lastsid = $sid;
					if($lastsid != $sid){
						//删除上一个目录末尾多余的数据
						for($i=$sectionj[$lastsid];$i<$nsectioncount[$lastsid];$i++){
							unset($sectionlist[$lastsid][$i]);
						}
						$lastsid = $sid;
					}
					if(empty($nsectioncount[$sid]))
						$nsectioncount[$sid] = count($sectionlist[$sid]);
					// var_dump($nsectioncount);
					if(empty($sectionj[$sid]))
						$sectionj[$sid] = 0;
					
					// var_dump($sectionj[$sid]);
					
					for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
						//删除与搜索结果不符的内容
						if($cw['cwid'] != $sectionlist[$sid][$i]['cwid']){
							// echo $sectionlist[$sid][$i]['cwid'];
							unset($sectionlist[$sid][$i]);
						}else{
							$sectionj[$sid] = $i+1;
							break;
						}
					}
					
				}
				
				for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
					unset($sectionlist[$sid][$i]);
				}
				foreach($sectionlist as $k=>$section){
					if(!in_array($k,$resultSection)){
						unset($sectionlist[$k]);
					}
				}
			}else{
				$sectionlist = array();
			}
			// var_dump($searchedcwlist);
		}
		//服务包限制时间,用于判断往期课件
		/*
		$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$limitdate = $pmodel->getFirstLimitDate(array('folderid'=>$folderid,'uid'=>$user['uid']));
			$this->assign('limitdate',$limitdate['firstday']);
		}*/
		$this->assign('sectionlist',$sectionlist);
		// $this->assign('myfavorite',$myfavorite);
		$this->assign('q',$q);
		$this->assign('cwlist',$cwlist);
		// $this->_updateuserstate(6,$folderid);
		$this->assign('roominfo',$roominfo);
		$this->display('college/cwlist_introduce');
	}

    /**
     * 判断用户课程权限，设置下一步操作链接地址、服务项课程信息、课程封面图
     * 第一步：满足免费开通的初步条件(如果服务项价格为0或则课程是全校免费用户是当前网校学生，并且服务项可支付)
     * 第二步：满足第一步条件就检查捆绑销售的服务项
     */
	public function ajax_checkuserpermisions() {
        $user = Ebh::app()->user->getloginuser();
        if (empty($user)) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '未登录'
            ));
            exit();
        }
        if ($user['groupid'] != 6) {
            echo json_encode(array(
                'errno' => 100,
                'msg' => '此帐号不允许操作'
            ));
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        if (empty($roominfo)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '错误访问'
            ));
            exit();
        }
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '非法操作'
            ));
            exit();
        }
        $folderid = intval($this->input->post('folderid'));
        $itemid = intval($this->input->post('itemid'));
        if ($folderid < 1 || $itemid < 1) {
            echo json_encode(array(
                'errno' => 4,
                'msg' => '参数错误'
            ));
            exit();
        }
        $itemdetail = $this->model('Payitem')->getItemByItemid($itemid);
        if(empty($itemdetail)) {
            echo json_encode(array(
                'errno' => 4,
                'msg' => '参数错误'
            ));
            exit();
        }

        $ret_data = $this->_sort_detail($itemdetail, $user, $roominfo);
        echo json_encode(array(
            'errno' => 0,
            'data' => $ret_data
        ));
        exit();
    }

    /**
     * 服务分类下服务项信息
     * @param $pay_item
     * @param $user
     * @param $roominfo
     * @return array
     */
    private function _sort_detail($pay_item, $user, $roominfo) {
        $userpermision = $this->model('Userpermission')->checkUserPermision($user['uid'], array(
            'powerid' => 0,
            'folderid' => $pay_item['folderid'],
            'crid' => $roominfo['crid']
        ));

        //学生用户具有课程权限，返回课程列表链接
        if (empty($roominfo['iscollege'])) {
            $nexturl = sprintf('/myroom/stusubject/%s.html', $pay_item['folderid']);
        } elseif ($pay_item['showmode'] == 3) {
            $nexturl = sprintf('/myroom/college/study/introduce/%s.html', $pay_item['folderid']);
        } else {
            $nexturl = sprintf('/myroom.html?url=/myroom/college/study/cwlist/%s.html', $pay_item['folderid']);
        }
        if ($userpermision == 1) {
            return array(
                'permission' => 1,
                'nexturl' => $nexturl
            );
        }
        //学生不具有课程权限
        if (!empty($user)) {
            $is_alumni = $this->model('Roomuser')->isAlumni($roominfo['crid'], $user['uid']);
        } else {
            $is_alumni = false;
        }

        //课程服务项价格为0或全校免费，并且可支付
        $free = ($pay_item['iprice'] == 0 || $pay_item['isschoolfree'] == 1 && $is_alumni) && empty($pay_item['cannotpay']);

        $member = array();
        if ($free && $pay_item['sid'] > 0) {
            //判断同分类下其它服务项是否可免费开通
            $paysort_prices = $this->model('Paysort')->sortsCountPrice(array($pay_item['sid']));
            if (!empty($paysort_prices)) {
                $all_price = 0;
                foreach ($paysort_prices as $paysort_price) {
                    if (empty($paysort_price['showbysort'])) {
                        //非捆绑销售分类，结束判断
                        break;
                    }
                    if ($paysort_price['cannotpay'] == 1) {
                        //捆绑销售分类下包含不能支付的服务项，结束判断
                        $free = false;
                        break;
                    }
                    if ($paysort_price['isschoolfree'] == 0 || !$is_alumni) {
                        //统计捆绑销售分类下的服务项总价格（全校免费的服务项不计算）
                        $all_price += $paysort_price['iprice'];
                    }
                    //记录捆绑销售分类下的成员服务项
                    $member[] = array(
                        'itemid' => $paysort_price['itemid'],
                        'iprice' => $pay_item['iprice']
                    );
                }
                if ($all_price > 0) {
                    //捆绑销售分类下的服务项总价格,不能直接开通课程
                    $free = false;
                }
            }
        }

        $data = array(
            'permission' => intval($userpermision),
            'free' => intval($free)
        );

        if ($free) {
            //服务项可直接开通，获取服务项的信息供弹窗开通显示
            $showimg = $pay_item['img'];
            if (empty($showimg)) {
                $showimg = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg';
            }
            $img = show_plate_course_cover($showimg);
            $img = show_thumb($img);

            $data['item'] = array(
                'itemid' => $pay_item['itemid'],
                'crname' => $pay_item['crname'],
                'iname' => $pay_item['iname'],
                'summary' => $pay_item['summary'],
                'showimg' => $img
            );
            if (!empty($member)) {
                //服务分类下的成员项，提供直接开通时需要的服务项ID集
                $data['item']['group_members'] = $member;
            }
            //直接开通成功后进入的课程列表链接
            $data['nexturl'] = $nexturl;
        } else if($pay_item['iprice'] > 0 || $pay_item['fprice'] > 0) {
            $data['nexturl'] = '/ibuy.html?itemid='.$pay_item['itemid'];
        } else if($pay_item['fpice'] == 0) {
            $data['nexturl'] = '/myroom/stusubject/'.$pay_item['folderid'].'.html';
        } else {
            $data['nexturl'] = '/ibuy.html?itemid='.$pay_item['itemid'];
        }

        return $data;
    }

    /**
     * 打包支付服务项
     */
    public function bundle_view() {
        $room = Ebh::app()->room->getcurroom();
        if ($room['template'] == 'plate') {
            Ebh::app()->runAction('room/portfolio', 'bundle');
            return;
        }
    }
}