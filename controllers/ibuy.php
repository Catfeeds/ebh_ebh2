<?php
/**
 * 服务产品开通和充值控制器
 */
class IbuyController extends CControl {
	//需要更新缓存和SNS同步操作的学校
	private $sync_crlist = array();
	//需要更新缓存的班级
	private $sync_classlist = array();
	//通知第三方服务器数据包
	private $rsync_data = array();
	public $user = null;

    private $apiServer = null;

    public function __construct(){
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
    }

    public function index() {
        $user = Ebh::app()->user->getloginuser();
        if (empty($user)) {
            $url = geturl('login').'?returnurl='.urlencode($_SERVER['REQUEST_URI']);
            header('Location:'.$url);
            exit();
        }
        if ($user['groupid'] != 6) {
            //非学生用户转到主页
            header('Location:/');
            exit();
        }

        //判断禁用其他网校的人购买，是的话判断是否该网校的用户
        $this->checkRoomUser();
        
        //判断是否需要先做问卷才能开通服务
        $this->_check_for_survey($user['uid']);

		$itemid = intval($this->input->get('itemid'));	//服务项编号
		$sid = intval($this->input->get('sid'));	//服务包分类编号
		$cwid = intval($this->input->get('cwid'));//单课
        $bid = intval($this->input->get('bid'));//课程包
		$from = $this->input->get('from');//开通来源

		//收藏课程/打折购买支付
        if (!empty($from) && ($from=='discount')) {
            $this->second();
            exit();
        }

		if($itemid < 1 && $cwid < 1 && $bid < 1 && $sid < 1) {
			header('Location: /');
			exit();
		}

        $this->second();
    }
	/**
	*开通第一步，未登录时需要处理登录信息
	*/
	private function first() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
        $this->assign('user', $user);
		$this->display('common/ibuy');
	}

    /**
     * 开通第二步，登录后的界面处理
     */
	private function second() {
		$itemid = intval($this->input->get('itemid'));
		$sid = intval($this->input->get('sid'));
		$bid = intval($this->input->get('bid'));
		$cwid = intval($this->input->get('cwid'));
		$from = $this->input->get('from');//开通来源
		if(!empty($from) && $from =='discount'){//打折购买
		    $this->_discountPaySecond();
		}

        $roominfo = Ebh::app()->room->getcurroom();
		if($this->isWeixin() || $this->isMobile()){
            if(!empty($itemid) || !empty($sid)) {
                if (!empty($sid)) {
                    header('Location: http://wap.ebh.net/ibuy/'.$itemid.'.html?client=1&sid='.$sid.'&crid='.$roominfo['crid']);
                } else {
                    header('Location: http://wap.ebh.net/ibuy/'.$itemid.'.html?client=1&crid='.$roominfo['crid']);
                }
                return ;
            }
            if (!empty($bid)) {
                header('Location: http://wap.ebh.net/ibuy/'.$bid.'.html?client=1&bundled=1&crid='.$roominfo['crid']);
                return;
            }
		}
        $user = Ebh::app()->user->getloginuser();
		$param = array();
		if($sid > 0) {
            $param['sid'] = $sid;
            $param['crid'] = $roominfo['crid'];
        } else if($itemid > 0) {
            $param['itemid'] = $itemid;
        }
        //是否可以兑换码开通
        if ($itemid > 0) {
        	$rmodel = $this->model('Redeem');
			$lotInfo = $rmodel->getRedeemByitemid($itemid);
			if (!empty($lotInfo)) {
				$this->assign('redeemBuy', 1);
			} else {
				$this->assign('redeemBuy', 0);
			}
        }
        if (!empty($param)) {
            $pitemmodel = $this->model('PayItem');
		    $itemlist = $pitemmodel->getItemBySidOrItemid($param);
        }
        if (!empty($itemlist)) {
            $firstItem = reset($itemlist);
            if ($firstItem['crid'] == $roominfo['crid']) {
                $sid = $firstItem['sid'];
                if ($sid > 0) {
                    $sortmodel = $this->model('paysort');
                    $sortdetail = $sortmodel->getSortdetail($sid);
                    $this->assign('sortdetail',$sortdetail);
                }
                unset($firstItem);
            }
        }
        if (!empty($firstItem)) {
		    //企业选课，价格重置，企业选课只支持单课程购买
            $ssmodel = $this->model('Schsource');
            $schsourceitem = $ssmodel->getSelectedItems(array('crid'=>$roominfo['crid'],'itemid'=>$firstItem['itemid']));
            if(!empty($schsourceitem)){
                foreach($schsourceitem as $si){
                    $itemlist[0]['iprice'] = $si['price'];
                    $itemlist[0]['imonth'] = $si['month'];
                    $itemlist[0]['crid'] = $si['crid'];
                    $itemlist[0]['cannotpay'] = 0;
                }
            }
            $sid = 0;
        }

        $listSorts = Ebh::app()->getConfig()->load('othersetting');
		//本校课程，捆绑销售的课程或某些网校的课程读取分类下的所有课程
        if (!empty($itemlist) && $sid > 0 && (!empty($sortdetail['showbysort']) || !empty($listSorts['list_sorts']) && in_array($roominfo['crid'], $listSorts['list_sorts']))) {
		    $param = array('sid' => $sid);
            $itemlist = $pitemmodel->getItemBySidOrItemid($param);
        } elseif(!empty($itemlist) && count($itemlist) == 1 && $itemid>0) {//单课程报名
			//课程设置了限制报名时,查询开通人数
			if(!empty($itemlist[0]['islimit']) && $itemlist[0]['limitnum']>0){
				$openlimit = Ebh::app()->lib('OpenLimit');
				$openstatus = $openlimit->checkStatus($itemlist[0]);
				if(!$openstatus){//状态设置为无法报名
					header('Location: /courseinfo/'.$itemid.'.html');
				}
			}
		}

        if (empty($itemlist) && $bid > 0) {
            //课程包
            $api = Ebh::app()->getApiServer('ebh');
            $bundle = $api->reSetting()
                ->setService('CourseService.Bundle.detail')
                ->addParams('bid', $bid)
                ->addParams('crid', $roominfo['crid'])
                ->request();
            if (empty($bundle) || !empty($bundle['cannotpay'])) {
                header('Location:/');
                exit();
            }
            if (!empty($roominfo) && $roominfo['crid'] != $bundle['crid']) {
                header('Location:/');
                exit();
            }
			//课程包设置了限制报名时,查询开通人数
			if(!empty($bundle['islimit']) && $bundle['limitnum']>0){
				$openlimit = Ebh::app()->lib('OpenLimit');
				$openstatus = $openlimit->checkStatus($bundle);
				
				if(!$openstatus){//状态设置为无法报名
					header('Location: /room/portfolio/tagged/'.$bid.'.html');
				}
			}
            $itemlist = $bundle['courses'];
            $this->assign('bprice', $bundle['bprice']);
            $this->assign('bid', $bid);
        }
        $userpermissionModel = $this->model('Userpermission');
        if (!empty($itemlist)) {
		    $folderids = array_column($itemlist, 'folderid');
            $mylist = $userpermissionModel->getUserPayFolderList(array(
                'uid' => $user['uid'],
                'crid' => $roominfo['crid'],
                'folderid' => $folderids
            ), true);
        }
        if (empty($itemlist) && $cwid > 0) {
            $cwdetail = $this->model('courseware')->getcwpay($cwid);
            $cwdetail['itemid'] = $cwdetail['cwid'];
            $cwdetail['iname'] = $cwdetail['title'];
            $cwdetail['imonth'] = $cwdetail['cmonth'];
            $cwdetail['iday'] = $cwdetail['cday'];
            $cwdetail['iprice'] = $cwdetail['cprice'];
            $itemlist[0] = $cwdetail;
            $this->assign('cwid',$cwid);
        }
		$this->assign('sid',$sid);
		$this->assign('itemid',$itemid);
		$this->assign('itemlist',$itemlist);
		if (!empty($mylist)) {
            $this->assign('mylist',$mylist);
        }
        $this->assign('user', $user);
        $this->assign('roominfo', $roominfo);
		$this->display('common/ibuy_second');
	}

	/**
	*充值或开通成功后显示页面
	*/
	public function success() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		//取优惠码
		$couponsModel = $this->model('Coupons');
		$coupon = $couponsModel->getOne(array('uid'=>$user['uid']));
		//获取网校
		if (!empty($coupon)){
			$roominfo = $this->model('classroom')->getclassroomdetail($coupon['crid']);
			$coupon['crname'] = !empty($roominfo) ? $roominfo['crname'] : 'e板会';
		}else{
		    $coupon = array(
		       'crname'=>'e板会',
		        'code'=>'0000'
		    );
		}
		$this->assign('coupon',$coupon);
		$this->display('common/classactive_success');
	}
	/**
	*生成订单信息
	*@param $payfrom 来源
	*@param $couponcode 优惠码
	*@param $redeemprice 兑换码单价，用户通过兑换码购买时，数据库读出的单价，仅当payfrom=10,有效
	*/
	private function buildOrder($payfrom = 0, $couponcode = '', $redeemprice=0) {
		header('content-type:text/html;charset=utf-8');
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
            return FALSE;
        }
        $roomModel = $this->model('Classroom');
        $crid = intval($this->input->post('crid'));
		if ($crid > 0) {
		    $roominfo = $roomModel->getclassroomdetail($crid);
        }
        if (empty($roominfo)) {
            $roominfo = Ebh::app()->room->getcurroom();
        }

		$cwid = $this->input->post('cwid');
		if(!empty($cwid)){
			return $this->buildOrder_cw($payfrom,$cwid);
		}
		$bid = intval($this->input->post('bid'));
		if ($bid > 0) {
		    //生成课程包订单
            return $this->buildOrder_bundle($payfrom, $bid, $roominfo);
        }
        $sid = intval($this->input->post('sid'));
        $pitemmodel = $this->model('PayItem');
		if ($sid > 0) {
		    //打包课程
            $sort = $this->model('Paysort')->getSortdetail($sid);
            if (!empty($sort['showbysort'])) {
                $crid = empty($roominfo) ? 0 : $roominfo['crid'];
                $items = $pitemmodel->getSortCourseList($sort['sid'], $crid);
                if (empty($items)) {
                    return false;
                }
                $itemidlist = array_keys($items);
            }
        }
        if (empty($itemidlist)) {
            $itemidlist = $this->input->post('itemid');
        }

		if(empty($itemidlist)) {
            return FALSE;
        }
		foreach($itemidlist as $itemid) {	//详情编号必须都为正整数
			if(!is_numeric($itemid) || $itemid <= 0)
				return FALSE;
		}
		$itemidstr = implode(',',$itemidlist);

		$itemparam = array('itemidlist'=>$itemidstr);
		$itemlist = $pitemmodel->getItemList($itemparam);
		//兑换码订单价格单独处理
		if ($redeemprice && $payfrom == 10) {
			foreach ($itemlist as &$ivalue) {
				$ivalue['comfee'] = ($ivalue['comfee']/$ivalue['iprice'])*$redeemprice;
                $ivalue['roomfee'] = ($ivalue['roomfee']/$ivalue['iprice'])*$redeemprice;
                $ivalue['providerfee'] = ($ivalue['providerfee']/$ivalue['iprice'])*$redeemprice;;
				$ivalue['iprice'] = $redeemprice;
			}
		}

		if(empty($itemlist)) {
            return FALSE;
        }
        ///////////////////////////////////////////////////////////////////
        if (!empty($roominfo) && $roominfo['crid'] == $itemlist[0]['crid']) {
            //当本校免费课程时用户是本校学生，价格置0
            $roomusermodel = $this->model('Roomuser');
            $room = Ebh::app()->room->getcurroom();
            $is_alumni = $roomusermodel->isAlumni($room['crid'], $user['uid']);
            if ($is_alumni) {
                $folderid_arr = array_column($itemlist, 'folderid');
                $folderid_arr = array_unique($folderid_arr);
                $folder_module = $this->model('Folder');
                $folder_arr = $folder_module->getSchoolFreeFolderidList($folderid_arr);
            }
        }

        ////////////////////////////////////////////////////////////////////

		$payordermodel = $this->model('PayOrder');
		$orderparam = array();
		
		$orderparam['dateline'] = SYSTIME;
		$orderparam['ip'] = $this->input->getip();
		$orderparam['uid'] = $user['uid'];
		$orderparam['payfrom'] = $payfrom;
		$orderparam['couponcode'] = !empty($couponcode) ? $couponcode : ''; //优惠码
		$ordername = '';	//订单名称
		$remark = '';		//订单备注
		$totalfee = 0;	//订单总额
		$comfee = 0;	//公司分到总额
		$roomfee = 0;	//平台分到总额
		$providerfee = 0;	//内容提供商分到总额
		$flodernum = count($itemlist);                        //获取订单课程数量

		if ($redeemprice && $payfrom == 10) {//兑换码的不能打折
			$discount = 1;
		} else {
			$discount = $this->getDiscountByFolderNum($flodernum);//根据课程数量获取折扣//
		}
		for($i = 0; $i < count($itemlist); $i ++) {
            if (!empty($folder_arr) && in_array($itemlist[$i]['folderid'], $folder_arr)) {
                $itemlist[$i]['iprice'] = 0;
                $itemlist[$i]['comfee'] = 0;
                $itemlist[$i]['roomfee'] = 0;
                $itemlist[$i]['providerfee'] = 0;
                $itemlist[$i]['iprice_yh'] = 0;
                $itemlist[$i]['comfee_yh'] = 0;
                $itemlist[$i]['roomfee_yh'] = 0;
                $itemlist[$i]['providerfee_yh'] = 0;
            }
			$itemlist[$i]['fee'] = $itemlist[$i]['iprice']*$discount;
			$itemlist[$i]['oname'] = $itemlist[$i]['iname'];
			$itemlist[$i]['omonth'] = $itemlist[$i]['imonth'];
			$itemlist[$i]['oday'] = $itemlist[$i]['iday'];
			$itemlist[$i]['osummary'] = $itemlist[$i]['isummary'];
			$itemlist[$i]['uid'] = $user['uid'];
			$itemlist[$i]['pid'] = $itemlist[$i]['pid'];
			$pid = $itemlist[$i]['pid'];
			$itemlist[$i]['rname'] = $itemlist[$i]['crname'];
			//如果该课程参加了优惠并且使用优惠券处理
			if($itemlist[$i]['isyouhui'] && !empty($couponcode)){
				$itemlist[$i]['fee'] = $itemlist[$i]['iprice_yh'];
				$itemlist[$i]['comfee'] = $itemlist[$i]['comfee_yh'];
				$itemlist[$i]['roomfee'] = $itemlist[$i]['roomfee_yh'];
				$itemlist[$i]['providerfee'] = $itemlist[$i]['providerfee_yh'];
				$totalfee += $itemlist[$i]['iprice_yh'];
			}else{
				$itemlist[$i]['comfee'] = $itemlist[$i]['comfee']*$discount;
				$itemlist[$i]['roomfee'] = $itemlist[$i]['roomfee']*$discount;
				$itemlist[$i]['providerfee'] = $itemlist[$i]['providerfee']*$discount;//*****订单详情，每个商品都变成折后价*******
				$totalfee += $itemlist[$i]['iprice'];
			}
			$comfee += $itemlist[$i]['comfee'];
			$roomfee += $itemlist[$i]['roomfee'];
			$providerfee += $itemlist[$i]['providerfee'];
			if(empty($ordername)) {
                $ordername = $itemlist[$i]['oname'];
            } else {
                $ordername .= ','.$itemlist[$i]['oname'];
            }
			$theremark = $itemlist[$i]['iname'].'_'.(empty($itemlist[$i]['omonth']) ? $itemlist[$i]['oday'].' 天 _':$itemlist[$i]['omonth'].' 月 _').$itemlist[$i]['fee'].' 元';
			if(empty($remark)) {
				$remark = $theremark;
			} else {
				$remark .= '/'.$theremark;
			}
			$providercrid = $itemlist[$i]['providercrid'];
		}

		$orderparam['crid'] = $itemlist[0]['crid'];
		$orderparam['providercrid'] = $itemlist[0]['providercrid'];	//来源平台crid
		$orderparam['pid'] = $pid;
		$orderparam['itemlist'] = $itemlist;
		$orderparam['totalfee'] = $totalfee*$discount;//**折后价**
		$orderparam['comfee'] = $comfee;
		$orderparam['roomfee'] = $roomfee;
		$orderparam['providerfee'] = $providerfee;
		$orderparam['ordername'] = '开通 '.$ordername.' 服务';
		$orderparam['remark'] = $remark;

		if(!empty($roominfo) && !empty($itemid)){//查看企业选课,是则替换价格和期限
			$ssmodel = $this->model('Schsource');
			$schsourceitem = $ssmodel->getSelectedItems(array('crid'=>$roominfo['crid'],'itemid'=>$itemid));
			if(!empty($schsourceitem)){
				if (empty($schsourceitem[$itemid]['compercent']) && empty($schsourceitem[$itemid]['roompercent']) && empty($schsourceitem[$itemid]['providerpercent'])) {
		        	if (empty($schsourceitem[$itemid]['scompercent']) && empty($schsourceitem[$itemid]['sroompercent']) && empty($schsourceitem[$itemid]['sproviderpercent'])) {
		        		$roomdetail = $this->model('Classroom')->getclassroomdetail($roominfo['crid']);
			    		$profitratio = unserialize($roomdetail['profitratio']);
		        	} else {
		        		$profitratio['company'] = $schsourceitem[$itemid]['scompercent'];
		        		$profitratio['teacher'] = $schsourceitem[$itemid]['sroompercent'];
		        		$profitratio['agent'] = $schsourceitem[$itemid]['sproviderpercent'];
		        	}
		            
		            
	        	} else {
	        		$profitratio['company'] = $schsourceitem[$itemid]['compercent'];
	        		$profitratio['teacher'] = $schsourceitem[$itemid]['roompercent'];
	        		$profitratio['agent'] = $schsourceitem[$itemid]['providerpercent'];
	        	}
			    
			    $pre = $profitratio['company'] + $profitratio['agent'] + $profitratio['teacher'];
				foreach($schsourceitem as $si){
					$orderparam['totalfee'] = $si['price']*$discount;
					$orderparam['omonth'] = $si['month'];
					$orderparam['crid'] = $si['crid'];
					$orderparam['providercrid'] = $si['sourcecrid'];
					$orderparam['isschsource'] = 1;
					$orderparam['comfee'] = sprintf('%.2f', $si['price'] * $profitratio['company'] / $pre*$discount);
					$orderparam['roomfee'] = sprintf('%.2f', $si['price'] * $profitratio['teacher'] / $pre*$discount);
					$orderparam['providerfee'] = $orderparam['totalfee'] - $orderparam['comfee'] - $orderparam['roomfee'];
					$orderparam['itemlist'][0]['comfee'] = $orderparam['comfee'];
                    $orderparam['itemlist'][0]['roomfee'] = $orderparam['roomfee'];
                    $orderparam['itemlist'][0]['providerfee'] = $orderparam['providerfee'];
                    $orderparam['itemlist'][0]['omonth'] = $si['month'];
                    $orderparam['itemlist'][0]['crid'] = $si['crid'];
                    $orderparam['remark'] = $si['name'].'_'.($si['month'].' 月 _').$si['price'].' 元';
				}
			} else {//非企业选课的，查看开通限制
				if(count($itemlist) == 1 && !empty($itemlist[0]['islimit']) && $itemlist[0]['limitnum']>0){
					$openlimit = Ebh::app()->lib('OpenLimit');
					$openstatus = $openlimit->checkStatus($itemlist[0]);
					if(!$openstatus){//状态设置为无法报名
						return FALSE;
					}
				}
				
			}
		}

		//分销信息,目前只支持不捆绑销售的课程
        $sharekey = $this->input->post('sharekey');
        if (!empty($sharekey)) {
        	$shareInfo = $this->parse_sharekey($sharekey);
        }
        //判断是否分销，获取分销比例
		if (!empty($shareInfo[6]) && !empty($shareInfo[3]) && count($itemlist)==1 && $shareInfo[6]!=$user['uid']) {
			if ($shareInfo[1] != $itemlist[0]['itemid'] && $shareInfo[0]!='school') {
				exit;
			}
			$schoolShareInfo = $this->model('Classroom')->getShareInfo($shareInfo[3]);
			if (!empty($schoolShareInfo['isshare'])) {//开启的逻辑
				$userShare = $this->model('Share')->getUserSharePre($shareInfo[6],$shareInfo[3]);//比例
				$shareuid = $shareInfo[6];
				if (empty($userShare)) {//没有，用默认
					$sharepre = $schoolShareInfo['sharepercent'];
				} else {
					$sharepre = $userShare['percent'];
				}
			}
			
		}
		if (!empty($shareuid) && !empty($sharepre)) {
			$orderparam['isshare'] = 1;
			$orderparam['shareuid'] = $shareuid;
			$orderparam['sharefee'] = sprintf('%.2f',$orderparam['roomfee']*$sharepre/100);
			$orderparam['roomfee'] = sprintf('%.2f',$orderparam['roomfee']*(100-$sharepre)/100);
			foreach ($orderparam['itemlist'] as &$lvalue) {
				$lvalue['isshare'] = 1;
				$lvalue['shareuid'] = $shareuid;
				$lvalue['sharefee'] = sprintf('%.2f',$lvalue['roomfee']*$sharepre/100);
				$lvalue['roomfee'] = sprintf('%.2f',$lvalue['roomfee']*(100-$sharepre)/100);
			}
		}

		$orderid = $payordermodel->addOrder($orderparam);
		if($orderid > 0) {
			$orderparam['orderid'] = $orderid;
			return $orderparam;
		}
		return $orderparam;
	}
	/**
	*支付成功后的订单处理
	*/
	private function notifyOrder($param) {
		$this->sync_crlist = array();//初始化同步学校列表
		$this->sync_classlist = array();//初始化同步班级列表
		$this->rsync_data = array(); //初始化即将发送给第三方服务器的数据包
		
		//商户订单号
		$orderid = $param['orderid'];
		//交易号
		$ordernumber = $param['ordernumber'];
		$buyer_id = empty($param['buyer_id'])?'':$param['buyer_id'];
		$buyer_info = empty($param['buyer_info'])?'':$param['buyer_info'];
		$pordermodel = $this->model('PayOrder');
		Ebh::app()->getDb()->set_con(0);
		$myorder = $pordermodel->getOrderById($orderid);
		if(empty($myorder)) {//订单不存在
			log_message('订单不存在');
			return FALSE;
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			return $myorder;
		}

		//处理订单详情中的内容
		if(empty($myorder['detaillist'])) {
			return FALSE;
		}
		$providercrids = array();	//订单下内容提供商的crid列表，如果大于1，需要拆分订单
		foreach($myorder['detaillist'] as $detail) {
			$detail['uid'] = $myorder['uid'];
			$this->doOrderItem($detail);
			$detailprovidercrid = $detail['providercrid'];
			if(!isset($providercrids[$detailprovidercrid]))
				$providercrids[$detailprovidercrid] = $detailprovidercrid;
		}
		//更新订单状态
		$myorder['status'] = 1;
		$myorder['payip'] = getip();
		$myorder['paytime'] = SYSTIME;
		$myorder['ordernumber'] = $ordernumber;
		$myorder['buyer_id'] = $buyer_id;
		$myorder['buyer_info'] = $buyer_info;
		//拆分订单处理，当订单明细的提供商crid不同时，则将订单改成每个订单明细对应一个订单。
		$providercount = count($providercrids);
		if($providercount > 1) {
			for ($i = 0; $i < count($myorder['detaillist']); $i ++) {
				if($i == 0) {
					$myorder['providercrid'] = $myorder['detaillist'][$i]['providercrid'];
					$myorder['totalfee'] = $myorder['detaillist'][$i]['fee'];
					$myorder['comfee'] = $myorder['detaillist'][$i]['comfee'];
					$myorder['roomfee'] = $myorder['detaillist'][$i]['roomfee'];
					$myorder['providerfee'] = $myorder['detaillist'][$i]['providerfee'];
					$myorder['ordername'] = '开通 '.$myorder['detaillist'][$i]['oname'].' 服务';
					$myorder['remark'] = $myorder['detaillist'][$i]['oname'].'_'.(empty($myorder['detaillist'][$i]['omonth']) ? $myorder['detaillist'][$i]['oday'].' 天 _':$myorder['detaillist'][$i]['omonth'].' 月 _').$myorder['detaillist'][$i]['fee'].' 元';
				} else {
					$neworder = $myorder;
					$neworder['providercrid'] = $myorder['detaillist'][$i]['providercrid'];
					$neworder['totalfee'] = $myorder['detaillist'][$i]['fee'];
					$neworder['comfee'] = $myorder['detaillist'][$i]['comfee'];
					$neworder['roomfee'] = $myorder['detaillist'][$i]['roomfee'];
					$neworder['providerfee'] = $myorder['detaillist'][$i]['providerfee'];
					$neworder['ordername'] = '开通 '.$myorder['detaillist'][$i]['oname'].' 服务';
					$neworder['remark'] = $myorder['detaillist'][$i]['oname'].'_'.(empty($myorder['detaillist'][$i]['omonth']) ? $myorder['detaillist'][$i]['oday'].' 天 _':$myorder['detaillist'][$i]['omonth'].' 月 _').$myorder['detaillist'][$i]['fee'].' 元';
					$neworderid = $pordermodel->addOrder($neworder,TRUE);
					$myorder['detaillist'][$i]['orderid'] = $neworderid;
				}
			}
		}

		$myorder['itemlist'] = $myorder['detaillist'];
		$pordermodel->updateOrder($myorder);

		//更新学校学生缓存和同步SNS数据
		if (!empty($this->sync_crlist))
		{
			foreach ($this->sync_crlist as $crid) {
				//更新学校学生缓存
				Ebh::app()->lib('Sns')->updateRoomUserCache(array('crid'=>$crid,'uid'=>$myorder['uid']));
				//同步SNS数据(网校操作)
				Ebh::app()->lib('Sns')->do_sync($myorder['uid'], 4);
			}
		}
		//更新班级学生缓存
		if (!empty($this->sync_classlist))
		{
			foreach ($this->sync_classlist as $classid)
			{
				//更新班级学生缓存
				Ebh::app()->lib('Sns')->updateClassUserCache(array('classid'=>$classid,'uid'=>$myorder['uid']));
			}
		}
		//使用优惠券后返利处理
		$userModel = $this->model('User');  
		$tmpuser = $userModel->getUserInfoByUid($myorder['uid']);
		if(empty($tmpuser)){
			log_message('订单关联用户uid:'.$myorder['uid'].'获取失败');	
		}
		$user = $tmpuser[0];
		$couponModel = $this->model('Coupons');
		if(!empty($myorder['couponcode'])){
			$reward = 0;
			$ip = getip();
			$cashbackModel = $this->model('Cashback');
			$coupon = $couponModel->getOne(array('code'=>$myorder['couponcode']));
			//优惠码可用
			if(!empty($coupon) && $coupon['uid'] != $user['uid']){
				foreach ($myorder['itemlist'] as $item){
					$reward = $item['fee'] - $item['comfee'] - $item['roomfee'] - $item['providerfee'];
					if($reward<=0){
						continue;
					}
					$cparam['uid'] = $coupon['uid'];
					$cparam['fromcrid'] = $item['crid'];
					$cparam['crname'] = $item['rname'];
					$cparam['fromuid'] = $user['uid'];
					$cparam['fromname'] = !empty($user['realname']) ? $user['realname'] : $user['username'];
					$cparam['servicestxt'] = '开通&nbsp;'.$item['oname'];
					$cparam['reward'] = $reward;
					$cparam['fromip'] = $ip;
					$cparam['time'] = SYSTIME;
					//依次加入记录至返现记录表
					$ret = $cashbackModel->add($cparam);
					if(!$ret){
						log_message('开通&nbsp;'.$item['oname'].'&nbsp;&nbsp;返利失败,关联uid:'.$cparam['uid']);
					}
				}
			}
		}
		//生成属于自己的优惠码
		$mycoupon = $couponModel->getOne(array('uid'=>$user['uid']));
		if(empty($mycoupon)){
			$couponarr['uid'] = $user['uid'];
			$couponarr['code'] = $this->getcouponcode();
			$couponarr['createtime'] = SYSTIME;
			$couponarr['orderid'] = $orderid;
			$couponarr['crid'] = $myorder['crid'];
			$myret = $couponModel->add($couponarr);
			if(!$myret){
				log_message('生成优惠码失败,关联uid:'.$couponarr['uid']);
			}
		}		

		//通知第三方
		if(!empty($this->rsync_data)){
			foreach ($this->rsync_data as $data) {
				rsapi_call($data['crid'],'folder_buyed',$data);
			}
		}

		//处理分销返利情况
		if (!empty($myorder['isshare']) && !empty($myorder['sharefee']) && !empty($myorder['shareuid'])) {
			$myorder['sharedetail'] = empty($user['realname'])?$user['username']:$user['realname'].' '.$myorder['ordername'].'  价格: <em>'.$myorder['totalfee'].'</em>';
			$res = $this->model('Share')->addCharge($myorder);
			if (empty($res)) {
				log_message('分销失败,关联uid:'.$myorder['shareuid']);
			}
		}

		return $myorder;
	}
	/**
	*支付成功后处理订单详情（主要为生成权限）
	*/
	private function doOrderItem($orderdetail) {
		$crid = $orderdetail['crid'];
		$folderid = $orderdetail['folderid'];
		$uid = $orderdetail['uid'];
		$omonth= $orderdetail['omonth']; 
		$oday= $orderdetail['oday']; 
		$cwid = empty($orderdetail['cwid'])?0:$orderdetail['cwid'];
		$roommodel = $this->model('Classroom');
		$roominfo = $roommodel->getRoomByCrid($crid);
		if(empty($roominfo))
			return FALSE;
		$usermodel = $this->model('User');
		$user = $usermodel->getuserbyuid($uid);
		if(empty($user))
			return FALSE;
		//获取用户是否在此平台
		$rumodel = $this->model('Roomuser');
		$ruser = $rumodel->getroomuserdetail($crid,$uid);
		$type = 0;
		if(empty($ruser)) {	//不存在 
			$enddate = 0;
			if(!empty($crid)) {
				if(!empty($omonth)) {
					$enddate = strtotime("+$omonth month");
				} else {
					$enddate = strtotime("+$oday day");
				}
			}
			$param = array('crid'=>$crid,'uid'=>$user['uid'],'begindate'=>SYSTIME,'enddate'=>$enddate,'cnname'=>$user['realname'],'sex'=>$user['sex']);
			$result = $rumodel->insert($param);
			$type = 1;

			if($result !== FALSE) {
				if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {	//如果是收费学校，则会将账号默认添加到学校的第一个班级中
					$this->setmyclass($crid,$user['uid'],$folderid);
				} else {
					//更新教室学生数
					$roommodel->addstunum($crid);
				}
				//记录需要更新缓存和SNS同步操作的学校项目
				$this->sync_crlist[] = $crid;
			}
		} else {	//已存在
			if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7){
				$this->setmyclass($roominfo['crid'],$user['uid'],$folderid);//防止中途改变学校类型,导致学生在学校里面但是不在班级里面(网校改成学校) zkq 2014.07.22
			}
			$enddate=$ruser['enddate'];
			$newenddate=0;
			if(!empty($crid)) {
				if(!empty($omonth)) {
					if(SYSTIME>$enddate){//已过期的处理
						$newenddate=strtotime("+$omonth month");
					}else{	//未过期，则直接在结束时间后加上此时间
						$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$omonth month");
					}
				}else {
					if(SYSTIME>$enddate){//已过期的处理
						$newenddate=strtotime("+$oday day");
					}else{	//未过期，则直接在结束时间后加上此时间
						$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$oday day");
					}
				}
			}
			$param = array('crid'=>$crid,'uid'=>$user['uid'],'enddate'=>$newenddate,'cstatus'=>1);
			$result = $rumodel->update($param);
			$type = 2;
		}
		//处理用户权限
		$userpmodel = $this->model('UserPermission');
		if(!empty($orderdetail['cwid'])){//单课收费
			$myperm = $userpmodel->getPermissionByCwId($orderdetail['cwid'],$uid);
		}elseif(empty($orderdetail['folderid'])) {
			$myperm = $userpmodel->getPermissionByItemId($orderdetail['itemid'],$uid);
		} else {
			$myperm = $userpmodel->getPermissionByFolderId($orderdetail['folderid'],$uid,$crid);
		}
		$startdate = 0;
		$enddate = 0;
		if(empty($myperm)) {	//不存在则添加权限，否则更新
			$startdate = SYSTIME;
			if(!empty($omonth)) {
				$enddate = strtotime("+$omonth month");
			} else {
				$enddate = strtotime("+$oday day");
			}
			$ptype = 0;
			if(!empty($folderid) || !empty($crid)) {
				$ptype = 1;
			}
			$perparam = array('itemid'=>$orderdetail['itemid'],'type'=>$ptype,'uid'=>$uid,'crid'=>$crid,'folderid'=>$folderid,'cwid'=>$cwid,'startdate'=>$startdate,'enddate'=>$enddate);
			$result = $userpmodel->addPermission($perparam);
		} else {
			$enddate=$myperm['enddate'];
			$newenddate=0;
			if(!empty($omonth)) {
				if(SYSTIME>$enddate){//已过期的处理
					$newenddate=strtotime("+$omonth month");
				}else{	//未过期，则直接在结束时间后加上此时间
					$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$omonth month");
				}
			}else {
				if(SYSTIME>$enddate){//已过期的处理
                    $newenddate=strtotime("+$oday day");
                }else{	//未过期，则直接在结束时间后加上此时间
                    $newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$oday day");
                }
			}
			$enddate = $newenddate;
			$myperm['enddate'] = $enddate;
			if(!empty($orderdetail['itemid'])) {
				$myperm['itemid'] = $orderdetail['itemid'];
			}
			$result = $userpmodel->updatePermission($myperm);
		}
		$this->rsync_data[] = array('crid'=>$crid,'uid'=>$uid,'fid'=>$folderid);
		//用户平台信息更新成功则生成记录并更新年卡信息
		
		//删除订单收藏
		$this->model('collect')->del($uid,$crid,$folderid);
		
		return $result;
	}
	/**
	*选择支付宝充值操作
	*/
	public function alipay() {
	    //将原有的支付转移到ebhservice 统一处理
        $user = Ebh::app()->user->getloginuser();
        $roomModel = $this->model('Classroom');
        $crid = intval($this->input->post('crid'));
        if ($crid > 0) {
            $roominfo = $roomModel->getclassroomdetail($crid);
        }
        if (empty($roominfo)) {
            $roominfo = Ebh::app()->room->getcurroom();
        }

        $parameters['crid'] = $roominfo['crid'];
        $parameters['uid'] = $user['uid'];
        $parameters['itemid']  = $this->input->post('itemid');
        $parameters['cwid']  = $this->input->post('cwid');
        $parameters['bid']  = $this->input->post('bid');
        $parameters['sid']  = $this->input->post('sid');
        $parameters['couponcode'] = $this->input->post('couponcode');
        $parameters['ip'] = getip();
        $parameters['paytype'] = 'alipay';
        $sharekey = $this->input->post('sharekey');
        $parameters['sharekey'] = $sharekey;
        $parameters['parameters']['curdomain'] = $this->uri->curdomain;
        if($this->isMobile()){
            $parameters['parameters']['fromwap'] = true;
        }
        $result = $this->apiServer->reSetting()
            ->setService('Transaction.Trade.buildOrder')
            ->addParams($parameters)
            ->request();

        if($result['status'] == 0){
            echo $result['msg'] != '' ? $result['msg'] : $this->apiServer->getErrMsg();exit;
        }
        echo $result['data']['pay_data'];

	}
	/**
	*alipay支付接口通知
	*/
	public function alinotify() {
		$get = $this->input->get();
		$alilib = Ebh::app()->lib('Alipay');
		$verify_result = $alilib->checknotify();
		if(!$verify_result) {	//验证不通过
			echo "fail";
		}
		//商户订单号
		$orderid = $this->input->post('out_trade_no');
		//支付宝交易号
		$ordernumber = $this->input->post('trade_no');
		$buyer_id = $this->input->post('buyer_id');
		$buyer_info = $this->input->post('buyer_email');
		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$alilib->notify(FALSE);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$alilib->notify(TRUE);
			exit();
		}
		$alilib->notify(FALSE);
	}
	/**
	*成功返回页面
	*/
	public function alireturn() {
		$alilib = Ebh::app()->lib('Alipay');
		$get = $this->input->get();
		$_GET = $get;
		$verify_result = $alilib->checknotify();
		$successurl = geturl('ibuy/success');
		header("Location: $successurl");
	}

	/**
	*农行支付请求
	*/
	public function abcpay() {
		$user = Ebh::app()->user->getloginuser();
		//优惠券处理
		$isusecoupon = intval($this->input->post('isusecoupon'));
		$couponcode = trim($this->input->post('couponcode'));
		//是否使用优惠券
		$iscoupon = false;
		if($isusecoupon){
			$couponModel = $this->model('Coupons');
			$coupon = $couponModel->getOne(array('code'=>$couponcode));
			if(!empty($coupon) && $coupon['uid'] != $user['uid']){
				$iscoupon = true;
			}
		}
		$couponcode = $iscoupon ? $couponcode : '';
		$param = $this->doAbcRequest(1,$couponcode);
		//生成支付请求对象并提交abc服务器
		$Abcpay = Ebh::app()->lib('Abcpayv2');
		$result = $Abcpay->payTo($param);
	}
	/**
	*农行支付请求
	*/
	public function abcallpay() {
		$user = Ebh::app()->user->getloginuser();
		//优惠券处理
		$isusecoupon = intval($this->input->post('isusecoupon'));
		$couponcode = trim($this->input->post('couponcode'));
		//是否使用优惠券
		$iscoupon = false;
		if($isusecoupon){
			$couponModel = $this->model('Coupons');
			$coupon = $couponModel->getOne(array('code'=>$couponcode));
			if(!empty($coupon) && $coupon['uid'] != $user['uid']){
				$iscoupon = true;
			}
		}
		$couponcode = $iscoupon ? $couponcode : '';
		$payparam = array();
		$param = $this->doAbcRequest(6,$couponcode);
		//生成支付请求对象并提交abc服务器
		$Abcpay = Ebh::app()->lib('Abcpayv2');
		$result = $Abcpay->payTo($param);
	}
	/**
	*处理消费者农行和农行网银支付请求
	*通过前台消费者提交的充值信息，生成农行需要的接口请求
	*@param int $PaymentType （支付类型）1为农行卡 6为银联跨行支付
	*@param string $couponcode ($couponcode为空则不生效)
	*@return array $param 农行 RequestOrder 参数对象
	*/
	private function doAbcRequest($paymentType = 1,$couponcode = '') {
		$payfrom = 6;	//农行直接支付
		if($paymentType == 6)
			$payfrom = 7;	//农行银联支付
		$myorder = $this->buildOrder($payfrom,$couponcode);
		if(empty($myorder) && empty($myorder['orderid'])) {
			echo 'error';
			exit();
		}
		$domain = $myorder['itemlist'][0]['domain'];
		$isthird = FALSE;
		if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
			$isthird = TRUE;
		}
		if($isthird) {
			$notify_url = 'http://'.$this->uri->curdomain.'/ibuy/abcnotify.html?orderid='.$myorder['orderid'];
		} else {
			$notify_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/ibuy/abcnotify.html?orderid='.$myorder['orderid'];
		}
        //页面跳转同步通知页面路径
     //   $return_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/ibuy/alireturn.html?orderid='.$myorder['orderid'];

        //必填
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = $myorder['ordername'];
		$total_fee = $myorder['totalfee'];
        //必填
        //付款金额
        
        //必填
        //订单描述
        $body = $myorder['remark'];
		
		//1、取得支付请求所需要的信息
		$tOrderNo = $myorder['orderid'];
		$tExpiredDate = 10;	//订单过期时间 10天
		$tOrderDesc = $subject;	//产品描述
		$tOrderDate = date('Y/m/d',SYSTIME);	//订单日期 YYYY/MM/DD
		$tOrderTime = date('H:i:s',SYSTIME);		//订单时间 HH:MM:SS
		$tOrderAmountStr = $total_fee;				//支付金额
		$tOrderURL = 'http://'.$domain.'.'.$this->uri->curdomain.'/';			//订单查询地址
		$tBuyIP = $this->input->getip();	//买方ip地址
		
		$tProductType = 1;	//产品类型（必要信息）1：非实体商品 2：实体商品  
		$tPaymentType = $paymentType;	//支付类型（必要信息）1：农行借记卡支付 3：农行贷记卡支付  6: 银联跨行支付
		$tNotifyType = 1;	//设定支付结果通知方式（必要信息，0：URL 页面通知  1：服务器通知）  
		$tResultNotifyURL = $notify_url;	
														//支付结果地址（必要信息）  
														//注意：  
														//如果支付结果通知方式选择了页面通知，此处填写就是支付结果回传网址；  
														//如果支付结果通知方式选择了服务器通知，此处填写的就是接收支付平台服务器发送响应信息的地址。  
		$tMerchantRemarks = $body;	//商户备注信息 
		$tPaymentLinkType = 1;	//接入方式       （必要信息）1：internet 网络接入 2：手机网络接入 3:数字电视网络接入 4:智能客户端   
		if($this->isMobile()){
			$tPaymentLinkType = 2;
		}
		//生成支付请求对象并提交abc服务器
		$param = array('OrderNo'=>$tOrderNo,'ExpiredDate'=>$tExpiredDate,'OrderDesc'=>$tOrderDesc,'OrderDate'=>$tOrderDate,'OrderTime'=>$tOrderTime,'OrderAmountStr'=>$tOrderAmountStr,'OrderURL'=>$tOrderURL,'BuyIP'=>$tBuyIP,'ProductType'=>$tProductType,'PaymentType'=>$tPaymentType,'NotifyType'=>$tNotifyType,'ResultNotifyURL'=>$tResultNotifyURL,'MerchantRemarks'=>$tMerchantRemarks,'PaymentLinkType'=>$tPaymentLinkType,'itemlist'=>$myorder['itemlist']);
		return $param;
	}
	/**
	*农行支付请求结果响应
	*/
	public function abcnotify() {
		$abclib = Ebh::app()->lib('Abcpayv2');
		$verify_result = $abclib->getnotify();
		$roominfo = Ebh::app()->room->getcurroom();
		$isthird = FALSE;
		if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
			$isthird = TRUE;
		}
		if($isthird) {
			$successurl = 'http://'.$this->uri->curdomain.'/ibuy/success.html';	
			$failurl = 'http://'.$this->uri->curdomain.'/ibuy/fail.html';	
		} else {
			$successurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy/success.html';	
			$failurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy/fail.html';
		}
		if(empty($verify_result)) {	//支付失败
			$abclib->notify($failurl);
		}
		$orderid = $verify_result['OrderNo'];
		//农行交易号
		$ordernumber = $verify_result['VoucherNo'];

		//商户订单号
		$buyer_id = $verify_result['VoucherNo'];	//交易凭证号，用于对账时使用
		$buyer_info = $verify_result['TrnxNo'];		//
		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$abclib->notify($failurl);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$abclib->notify($successurl);
			exit();
		}
		$abclib->notify($failurl);
	}
	/**
	*设置用户的默认班级信息
	* 一般为收费学校用户开通学校服务时候处理，需要将学生加入到默认的班级中
	* 如果不存在新班级，则需要创建一个默认班级
	*/
	private function setmyclass($crid,$uid,$folderid) {
		$classmodel = $this->model('Classes');
		//先判断是否已经加入班级，已经加入则无需重新加入
		$myclass = $classmodel->getClassByUid($crid,$uid);
		if(empty($myclass)) {
			//获取课程对应的年级和地区信息
			$grade = 0;
			$district = 0;
			$folderInfo = $this->model('folder')->getfolderbyid($folderid);
			$classname = "默认班级";
			if(!empty($folderInfo)){
				$grade = $folderInfo['grade'];
				$district = $folderInfo['district'];
				$grademap = Ebh::app()->getConfig()->load('grademap');
				if(array_key_exists($grade, $grademap)){
					$classname = $grademap[$grade].'默认班级';
				}
			}

			$classid = 0;
			$defaultclass = $classmodel->getDefaultClass($crid,$grade,$district);
			if(empty($defaultclass)) {	//不存在默认班级，则创建默认班级
				$param = array('crid'=>$crid,'classname'=>$classname,'grade'=>$grade,'district'=>$district);
				$classid = $classmodel->addclass($param);
			} else {
				$classid = $defaultclass['classid'];
			}
			$param = array('crid'=>$crid,'classid'=>$classid,'uid'=>$uid);
			$classmodel->addclassstudent($param);

			//记录需要更新缓存的班级项目
			$this->sync_classlist[] = $classid;
		}
	}
	public function bank() {
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
		$this->display('common/classactive_bank');
	}
	/**
	*通过账户余额支付
	*/
	public function bpay() {
        $roominfo = Ebh::app()->room->getcurroom();
		//判断禁用其他网校的人购买，是的话判断是否该网校的用户,该处主要是防止免费课程开通
		$systemsetting = Ebh::app()->room->getSystemSetting();
	    $isbanbuy = empty($systemsetting['isbanbuy']) ? 0 : 1;
	    //1禁用其他网校的人购买
        if ($isbanbuy) {
        	$check = Ebh::app()->room->checkstudent(TRUE);
	        if ($check < 1) {
	        	$result['status'] = 0;
	        	$result['msg'] = '非网校学员不能购买';
				echo json_encode($result);
				exit();
	        }
        	
        }
		
		$result = array('status'=>0);
		$user = Ebh::app()->user->getloginuser();
		$totalfee = intval($this->input->post('totalfee'));
		if($user['balance'] < $totalfee) {	//对生成订单前做一次余额是否充足判断
			$result['msg'] = '余额不足';
			echo json_encode($result);
			exit();
		}


        $parameters['crid'] = $roominfo['crid'];
        $parameters['uid'] = $user['uid'];
        $parameters['itemid']  = $this->input->post('itemid');
        $parameters['cwid']  = $this->input->post('cwid');
        $parameters['bid']  = $this->input->post('bid');
        $parameters['sid']  = $this->input->post('sid');
        $parameters['couponcode'] = $this->input->post('couponcode');
        $parameters['ip'] = getip();
        $parameters['paytype'] = 'balance';
        $sharekey = $this->input->post('sharekey');
        $parameters['sharekey'] = $sharekey;
        $res = $this->apiServer->reSetting()
            ->setService('Transaction.Trade.buildOrder')
            ->addParams($parameters)
            ->request();

        if($res['status'] == 0){

            $result['msg'] = $res['msg'] != '' ? $res['msg'] : $this->apiServer->getErrMsg();
            echo json_encode($result);
            exit();
        }

        if($res['data']['pay_data']['success'] == 'ok'){
            $result['status'] = 1;
            $result['msg'] = '开通成功';
            echo json_encode($result);
            exit();
        }else{
            $result['msg'] = '开通失败';
            echo json_encode($result);
            exit();
        }
    }
    /**
	*微信接口通知
	*/
	public function weixinnotify() {
		$weixinlib = Ebh::app()->lib('Weixinpay');
		$verify_result = $weixinlib->checknotify();
		if(empty($verify_result)) {	//验证不通过
			$weixinlib->notify(FALSE);
			exit();
		}
		if($verify_result['result_code'] == 'FAIL'){//支付失败啦,这里可以做删除订单处理
			$weixinlib->notify(TRUE);
			exit();
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';

		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$weixinlib->notify(FALSE);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$weixinlib->notify(TRUE);
			exit();
		}
		$weixinlib->notify(FALSE);
	}

	/**
	*微信公众账号支付接口通知
	*/
	public function wxpublicnotify() {
		$weixinlib = Ebh::app()->lib('WxPublicPay');
		$verify_result = $weixinlib->checknotify();
		if(empty($verify_result)) {	//验证不通过
			$weixinlib->notify(FALSE);
			exit();
		}
		if($verify_result['result_code'] == 'FAIL'){//支付失败啦,这里可以做删除订单处理
			$weixinlib->notify(TRUE);
			exit();
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		if(!is_numeric($orderid)){
			$weixinlib->notify(TRUE);//如果orderid不是数字则表示是之前的测试订单过来的回调，直接忽视
			exit;
		}
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';

		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$weixinlib->notify(FALSE);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$weixinlib->notify(TRUE);
			exit();
		}
		$weixinlib->notify(FALSE);
	}


	/**
	*alipaywap支付接口通知
	*/
	public function aliwapnotify() {
		$get = $this->input->get();
		$alilib = Ebh::app()->lib('Alipaywap');
		$verify_result = $alilib->checknotify();
		if(!$verify_result) {	//验证不通过
			$alilib->notify(FALSE);exit;
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		//支付宝交易号
		$ordernumber = $verify_result['trade_no'];
		$buyer_id = $verify_result['buyer_id'];
		$buyer_info = $verify_result['buyer_info'];

		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$alilib->notify(FALSE);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$alilib->notify(TRUE);
			exit();
		}
		$alilib->notify(FALSE);
	}

	/**
	*成功返回页面
	*/
	public function aliwapreturn() {
		$alilib = Ebh::app()->lib('Alipaywap');
		$get = $this->input->get();
		$_GET = $get;
		$verify_result = $alilib->checknotify();
		header("Location: http://wap.ebh.net");
	}

	/**
	*alipayApp支付接口通知
	*/
	public function aliappnotify() {
		$alilib = Ebh::app()->lib('AlipayForApp');
		$verify_result = $alilib->checknotify();
		if(!$verify_result) {	//验证不通过
			$alilib->notify(FALSE);exit;
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		//支付宝交易号
		$ordernumber = $verify_result['trade_no'];
		$buyer_id = $verify_result['buyer_id'];
		$buyer_info = $verify_result['buyer_info'];

		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$alilib->notify(FALSE);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$alilib->notify(TRUE);
			exit();
		}
		$alilib->notify(FALSE);
	}

	/**
	*通过激活卡支付
	*/
	public function scardpay() {
		$result = array('status'=>0);
		$itemidlist = $this->input->post('itemid');
		$allowlist = $this->input->post('allowlist');//亚投可以激活多个课程
		if(empty($itemidlist) || (count($itemidlist)!=1 && !$allowlist)){
			$result['msg'] = '单张激活卡只能开通一门课程';
			echo json_encode($result);
			exit;
		}
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($user)){
			$result['msg'] = '用户未登录';
			echo json_encode($result);
			exit;
		}
		if($user['groupid'] == 5){
			$result['msg'] = '教师账号不能开通';
			echo json_encode($result);
			exit;
		}
		if(empty($roominfo)){
			$result['msg'] = '当前学校信息无法获取';
			echo json_encode($result);
			exit;
		}
		//获取学校卡号
		$yearcardmodel = $this->model('yearcard');
		$cardnumber = $this->input->post('cardnumber');
		if(empty($cardnumber)){
			$result['msg'] = '激活码不能为空';
			echo json_encode($result);
			exit;
		}
		$cardnumber = strtoupper($cardnumber);
		$cardinfo = $yearcardmodel->getYearcardByCardnumber($cardnumber,$roominfo['crid']);
		if( empty($cardinfo) ){
			$result['msg'] = '激活码不正确，开通失败';
			echo json_encode($result);
			exit;
		}else if( $cardinfo['status'] == 1 ){
			$result['msg'] = '激活码已被使用，开通失败';
			echo json_encode($result);
			exit;
		}

		$myorder = $this->buildOrder(1);	//生成订单，激活卡当做年卡使
		
		if(empty($myorder) && empty($myorder['orderid'])) {	//订单生成失败
			$result['msg'] = '订单生成失败';
			echo json_encode($result);
			exit();
		}
		$cardpass = $cardinfo['cardpass'];
		$myorder['ordernumber'] = $cardpass;
		//处理权限
		$doresult = $this->notifyOrder($myorder);
		if(empty($doresult)) {
			$result['msg'] = '开通失败';
			echo json_encode($result);
			exit();
		}
		//开通成功，则进行销卡操作
		$uparam = array(
			'cardid'=>$cardinfo['cardid'],
			'status'=>1,
			'activedate'=>SYSTIME
		);
		$uresult = $yearcardmodel->update($uparam);
		$result['status'] = 1;
		$credit = $this->model('credit');
		$credit->addCreditlog(array('ruleid'=>23,'detail'=>$myorder['itemlist'][0]['oname']));
		echo json_encode($result);
	}

	/**
	*通过兑换码支付
	*/
	public function redeempay() {
		//设置主库读表数据
		Ebh::app()->getDb()->set_con(0);
		$result = array('status'=>0);
		$itemidlist = $this->input->post('itemid');
		$itemid = $itemidlist[0];
		$allowlist = $this->input->post('allowlist');//亚投可以激活多个课程
		if(empty($itemidlist) || (count($itemidlist)!=1 && !$allowlist)){
			$result['msg'] = '单张卡只能开通一门课程';
			echo json_encode($result);
			exit;
		}
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($user)){
			$result['msg'] = '用户未登录';
			echo json_encode($result);
			exit;
		}
		if($user['groupid'] == 5){
			$result['msg'] = '教师账号不能开通';
			echo json_encode($result);
			exit;
		}
		if(empty($roominfo)){
			$result['msg'] = '当前学校信息无法获取';
			echo json_encode($result);
			exit;
		}
		//获取兑换码
		$rmodel = $this->model('Redeem');
		$dhmnumber = $this->input->post('dhmnumber');
		if(empty($dhmnumber)){
			$result['msg'] = '兑换码不能为空';
			echo json_encode($result);
			exit;
		}
		$dhmnumber = strtoupper($dhmnumber);
		$cardinfo = $rmodel->getReedeemCard($dhmnumber,$roominfo['crid']);
		if( empty($cardinfo) ){
			$result['msg'] = '兑换码不正确，开通失败';
			echo json_encode($result);
			exit;
		}else if( $cardinfo['status'] == 1 ){
			$result['msg'] = '兑换码已被使用，开通失败';
			echo json_encode($result);
			exit;
		}else if($cardinfo['itemid']!=$itemid){
			$result['msg'] = '兑换码只能开通固定的课程，开通失败';
			echo json_encode($result);
			exit;
		}else if($cardinfo['effecttime']>time()){
			$result['msg'] = '兑换码生效时间没到';
			echo json_encode($result);
			exit;
		}

		$myorder = $this->buildOrder(10,'',$cardinfo['price']);	//生成订单，通过兑换码
		
		if(empty($myorder) && empty($myorder['orderid'])) {	//订单生成失败
			$result['msg'] = '订单生成失败';
			echo json_encode($result);
			exit();
		}
		$cardpass = $dhmnumber;
		$myorder['ordernumber'] = $cardpass;
		//处理权限
		$doresult = $this->notifyOrder($myorder);
		if(empty($doresult)) {
			$result['msg'] = '开通失败';
			echo json_encode($result);
			exit();
		}
		//开通成功，则进行撤销兑换码操作
		$uparam = array(
			'cardid'=>$cardinfo['cardid'],
			'uid'=>$user['uid'],
			'lotid'=>$cardinfo['lotid'],
			'effectnumber'=>$cardinfo['effectnumber']
		);
		$uresult = $rmodel->update($uparam);
		$result['status'] = 1;
		$credit = $this->model('credit');
		$credit->addCreditlog(array('ruleid'=>23,'detail'=>$myorder['itemlist'][0]['oname']));
		echo json_encode($result);
	}

	/***微信扫码支付逻辑开始***/
	//微信扫码订单生成
	public function wxnativepay(){
		/*$user = $this->user;
		//优惠券处理
		$isusecoupon = intval($this->input->post('isusecoupon'));
		$couponcode = trim($this->input->post('couponcode'));
		//是否使用优惠券
		$iscoupon = false;
		if($isusecoupon){
			$couponModel = $this->model('Coupons');
			$coupon = $couponModel->getOne(array('code'=>$couponcode));
			if(!empty($coupon) && $coupon['uid'] != $user['uid']){
				$iscoupon = true;
			}
		}
		$couponcode = $iscoupon ? $couponcode : '';
		$myorder = $this->buildOrder(9,$couponcode);
		if(empty($myorder) && empty($myorder['orderid'])) {
			json_encode(array('status'=>-1,'msg'=>'网站订单生成失败！'));
			exit();
		}
		$attach = md5($user['uid'].'_'.$myorder['orderid']);
        //商户订单号
        $out_trade_no = $myorder['orderid'];
        //订单名称
        $subject = $myorder['ordername'];
        $subject = shortstr($subject,80,'');
        //付款金额
		$total_fee = $myorder['totalfee']*100;
        //订单描述
        $body = $myorder['remark'];
        $body = shortstr($body,80,'');
        $notify_url = 'http://www.ebh.net/ibuy/wxnativenotify.html';//用户扫码通知接口
		$param = array('out_trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'notify_url'=>$notify_url,'attach'=>$attach);
		$weixinlib = Ebh::app()->lib('WxNativePay');
		$res = $weixinlib->alipayTo($param);//生成二维码图片
		if(!empty($res)){
			$res['orderid'] = $out_trade_no;
			$res['cachekey'] = $attach;
		}else{
			$res['orderid'] = 0;
			$res['cachekey'] = '';
		}
		if( !empty($res) && ($res['status'] == 0) ){
			$ret['status'] = 0;
			$ret['msg'] = '请求成功';
			$ret['url'] = 'http://paysdk.weixin.qq.com/example/qrcode.php?data='.$res['url'];
			$ret['cachekey'] = $res['cachekey'];
			$ret['successurl'] = geturl('ibuy/success');
		}
		echo json_encode($ret);*/


        header('content-type:text/html;charset=utf-8');
        $user = Ebh::app()->user->getloginuser();
        if(empty($user)) {
            return FALSE;
        }
        $roomModel = $this->model('Classroom');
        $crid = intval($this->input->post('crid'));
        if ($crid > 0) {
            $roominfo = $roomModel->getclassroomdetail($crid);
        }
        if (empty($roominfo)) {
            $roominfo = Ebh::app()->room->getcurroom();
        }

        $parameters['crid'] = $roominfo['crid'];
        $parameters['uid'] = $user['uid'];
        $parameters['itemid']  = $this->input->post('itemid');
        $parameters['cwid']  = $this->input->post('cwid');
        $parameters['bid']  = $this->input->post('bid');
        $parameters['sid']  = $this->input->post('sid');
        $parameters['couponcode'] = $this->input->post('couponcode');
        $parameters['ip'] = getip();
        $parameters['paytype'] = 'wxpayqrcode';
        $sharekey = $this->input->post('sharekey');
        $parameters['sharekey'] = $sharekey;

        $result = $this->apiServer->reSetting()
            ->setService('Transaction.Trade.buildOrder')
            ->addParams($parameters)
            ->request();

        if($result['status'] == 0){
            $res['status']  = 1;
            $res['orderid'] = 0;
            $res['cachekey'] = '';
        }else{

            $res = $result['data']['pay_data'];
            $res['status'] = 0;
            $res['successurl'] = geturl('ibuy/success');
        }

        echo json_encode($res);
	}
	/**
	*微信扫码支付接口通知
	*/
	public function wxnativenotify(){
		$weixinlib = Ebh::app()->lib('WxNativePay');
		$weixinlib->checknotify($this);
	}
	/**
	 *微信扫码支付接口通知LIB验证时的回调
	 */
	public function _wxnativenotify($verify_result) {
		if(empty($verify_result)) {
			return false;
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		if(!is_numeric($orderid)){
			return true;
		}
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';

		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			return false;
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			//写缓存用于前端验证刷新
			$attach = $verify_result['attach'];
			//$this->cache->set($attach,1,60);//支付成功标志
            $redis = Ebh::app()->getCache('cache_redis');
            $redis->set($attach,1,60);
			return true;
		}
		return false;
	}

	//客户端校验支付结果(扫码)
	public function checkweixinbuy(){
		$cachekey = $this->input->post('cachekey');
		$ret = array('status'=>1,'msg'=>'还没有支付');
		if(empty($cachekey)){
			echo json_encode($ret);
			exit();
		}
		$redis = Ebh::app()->getCache('cache_redis');
		$res = $redis->get($cachekey);//支付成功标志
		if(!empty($res)){
			$ret['status'] = 0;
			$ret['msg'] = '支付成功';
			$ret['method'] = 'tvpayover';
		}
		echo json_encode($ret);
	}
	/***微信扫码支付逻辑结束***/
	
	//验证优惠码
	public function verifycoupon(){
		$user = Ebh::app()->user->getloginuser();
		$couponcode = $this->input->post('code');
		if(empty($user)){
			echo json_encode(array('code'=>-1,'msg'=>'没有登录,请登录后重试'));
			exit;
		}
		if(empty($couponcode)){
			echo json_encode(array('code'=>-1,'msg'=>'优惠码不能为空'));
			exit;
		}
		if(!preg_match("/^[a-zA-Z\d]{6}$/",$couponcode)){
			echo json_encode(array('code'=>-1,'msg'=>'优惠码必须是字母、数字或其组合且长度为6位'));
			exit;
		}
		$model = $this->model('Coupons');
		$row = $model->getOne(array('code'=>$couponcode));
		if(empty($row)){
			echo json_encode(array('code'=>-1,'msg'=>'验证失败'));
			exit;
		}else{
			if($user['uid'] == $row['uid']){
				echo json_encode(array('code'=>-2,'msg'=>'您不能使用自己的优惠码'));
			}else{
				echo json_encode(array('code'=>0));
			}
		}
	}
	//新增优惠码
	public function addcoupon(){
		$user = Ebh::app()->user->getloginuser();
		$couponcode = $this->getcouponcode();
		echo $couponcode;
	}
	//生成优惠码
	private function getcouponcode(){
		$couponcode = $this->generatestr();
		//检测是否重复
		$model = $this->model('Coupons');
		$ck = $model->checkcoupon($couponcode);
		if($ck){
			$couponcode = $this->getcouponcode();
		}
		return $couponcode;
	}
	/**
	 * 生成随机数
	 * @param number $length
	 * @return string
	 */
	protected function generatestr( $length = 6 ){
		// 密码字符集，可任意添加你需要的字符
		$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$password = '';
		for ( $i = 0; $i < $length; $i++ )
		{
			// 这里提供两种字符获取方式
			// 第一种是使用 substr 截取$chars中的任意一位字符；
			// 第二种是取字符数组 $chars 的任意元素
			// $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		return $password;
	}
	
	/*
	单课收费的订单
	*/
	private function buildOrder_cw($payfrom,$cwid){
		$user = Ebh::app()->user->getloginuser();
		$cwdetail = $this->model('courseware')->getcwpay($cwid);
		if(empty($cwdetail))
			return false;
		$payordermodel = $this->model('PayOrder');
		$orderparam = array();
		
		$orderparam['dateline'] = SYSTIME;
		$orderparam['ip'] = $this->input->getip();
		$orderparam['uid'] = $user['uid'];
		$orderparam['payfrom'] = $payfrom;
		$orderparam['couponcode'] = ''; //优惠码
		$ordername = '';	//订单名称
		$remark = '';		//订单备注
		$totalfee = 0;	//订单总额
		$comfee = 0;	//公司分到总额
		$roomfee = 0;	//平台分到总额
		$providerfee = 0;	//内容提供商分到总额
		
		$cw['fee'] = $cwdetail['cprice'];
		$cw['comfee'] = $cwdetail['comfee'];
		$cw['roomfee'] = $cwdetail['roomfee'];
		$cw['oname'] = $cwdetail['title'];
		$cw['omonth'] = $cwdetail['cmonth'];
		$cw['oday'] = $cwdetail['cday'];
		$cw['osummary'] = $cwdetail['summary'];
		$cw['uid'] = $user['uid'];
		$cw['rname'] = $cwdetail['crname'];
		$cw['folderid'] = $cwdetail['folderid'];
		$cw['crid'] = $cwdetail['crid'];
		$cw['cwid'] = $cwdetail['cwid'];
		$cw['domain'] = $cwdetail['domain'];
		$remark = $cw['oname'].'_'.(empty($cw['omonth']) ? $cw['oday'].' 天 _':$cw['omonth'].' 月 _').$cw['fee'].' 元';
		
		$itemlist = array($cw);
		$orderparam['crid'] = $cw['crid'];
		$orderparam['cwid'] = $cw['cwid'];
		// $orderparam['providercrid'] = $itemlist[0]['providercrid'];	//来源平台crid
		// $orderparam['pid'] = $pid;
		$orderparam['itemlist'] = $itemlist;
		$orderparam['totalfee'] = $cw['fee'];	//订单总额
		$orderparam['comfee'] = $cw['comfee'];	//公司分到总额
		$orderparam['roomfee'] = $cw['roomfee'];	//平台分到总额
		// $orderparam['providerfee'] = $providerfee;
		$orderparam['ordername'] = '开通 '.$cw['oname'].' 服务';
		$orderparam['remark'] = $remark;
		
		
		$orderid = $payordermodel->addOrder($orderparam);
		if($orderid > 0) {
			$orderparam['orderid'] = $orderid;
			return $orderparam;
		}	
		return $orderparam;
	}

    /**
     * 生成课程包订单
     * @param $payfrom 支付来源
     * @param $bid 课程包ID
     * @param $roominfo 当前网校信息
     * @return array
     */
	private function buildOrder_bundle($payfrom, $bid, $roominfo) {
        $user = Ebh::app()->user->getloginuser();
        if (empty($user)) {
            return false;
        }

        $api = Ebh::app()->getApiServer('ebh');
        $bundle = $api->reSetting()
            ->setService('CourseService.Bundle.detail')
            ->addParams('bid', $bid)
            ->request();
		//课程包设置了限制报名时,查询开通人数
		if(!empty($bundle['islimit']) && $bundle['limitnum']>0){
			$openlimit = Ebh::app()->lib('OpenLimit');
			$openstatus = $openlimit->checkStatus($bundle);
			
			if(!$openstatus){//状态设置为无法报名
				return FALSE;
			}
		}
        if (empty($bundle) || empty($roominfo) || !empty($bundle['cannotpay']) || $bundle['crid'] != $roominfo['crid']) {
            //只能生成本网校的课程包订单
            return false;
        }
        $roominfo = $this->model('Classroom')->getclassroomdetail($bundle['crid']);
        $profitratio = unserialize($roominfo['profitratio']);
        $payordermodel = $this->model('PayOrder');
        $orderparam = array();
		$orderparam['bid'] = $bid;
        $orderparam['dateline'] = SYSTIME;
        $orderparam['ip'] = $this->input->getip();
        $orderparam['uid'] = $user['uid'];
        $orderparam['payfrom'] = $payfrom;
        $orderparam['couponcode'] = ''; //优惠码
        $orderparam['ordername'] = '开通'.$bundle['name'].'服务';	//订单名称
        $orderparam['remark'] = $bundle['name'].'课程包，价格：'.$bundle['bprice'].'元';		//订单备注
        $orderparam['totalfee'] = $bundle['bprice'];	//订单总额
        if (!empty($profitratio)) {
            $profitratio['baseTotal'] = $baseTotal = array_sum($profitratio);
            $orderparam['comfee'] = round($bundle['bprice'] * $profitratio['company'] / $baseTotal, 2);
            $orderparam['providerfee'] = round($bundle['bprice'] * $profitratio['agent'] / $baseTotal, 2);
            $orderparam['roomfee'] = $bundle['bprice'] - $orderparam['comfee'] - $orderparam['providerfee'];
        }

        $orderparam['crid'] = $roominfo['crid'];
        $orderparam['cwid'] = 0;
        $orderparam['providercrid'] = $bundle['crid'];	//来源平台crid
        $orderparam['pid'] = $bundle['pid'];
        $orderparam['itemlist'] = array_map(function($course) {
            return array(
                'itemid' => $course['itemid'],
                'cwid' => 0,
                'pid' =>$course['pid'],
                'folderid' => $course['folderid'],
                'omonth' => $course['imonth'],
                'oday' => $course['iday'],
                'oname' => $course['iname'],
                'iprice' => $course['iprice']
            );
        }, $bundle['courses']);
        $iprices = array_column($bundle['courses'], 'iprice');
        $acount = array_sum($iprices);
        unset($iprices);
        //包中课程的价格按比例重新换算
        array_walk($orderparam['itemlist'], function(&$item, $k, $args) {
            $item['uid'] = $args['uid'];
            $item['rname'] = $args['roominfo']['crname'];
            $item['osummary'] = $args['bundlename'].'-'.$item['oname'].(!empty($item['omonth']) ? $item['omonth'].'月' : $item['oday'].'天');
            $item['fee'] = round($item['iprice'] * $args['bprice'] / $args['acount'], 2);
            $item['comfee'] = round($item['fee'] * $args['profitratio']['company'] / $args['profitratio']['baseTotal'], 2);
            $item['providerfee'] = round($item['fee'] * $args['profitratio']['agent'] / $args['profitratio']['baseTotal'], 2);
            $item['roomfee'] = $item['fee'] - $item['comfee'] - $item['providerfee'];
            $item['domain'] = $args['roominfo']['domain'];
        }, array(
            'uid' => $user['uid'],
            'roominfo' => $roominfo,
            'bundlename' => $bundle['name'],
            'acount' => $acount,
            'bprice' => $bundle['bprice'],
            'profitratio' => $profitratio
        ));
        $orderid = $payordermodel->addOrder($orderparam, true);
        if($orderid > 0) {
            $orderparam['orderid'] = $orderid;
            return $orderparam;
        }
        return $orderparam;
    }
	/*
	是否手机登录
	*/
	function isMobile(){ 
		$useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''; 
		$useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';    
		function CheckSubstrs($substrs,$text){ 
		foreach($substrs as $substr) 
			if(false!==strpos($text,$substr)){ 
			return true; 
			} 
			return false; 
		}
		$mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
		$mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod'); 
			
		$found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) || 
			CheckSubstrs($mobile_token_list,$useragent); 
			
		if ($found_mobile){ 
			return true; 
		}else{ 
			return false; 
		} 
	}
	/*
	是否微信登录
	*/
	private function isWeixin(){
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) { 
			return true; 
		} 
		return false; 
	}
    /**
	 * 判断开通服务前是否需要填写问卷，未填写的直接引导到问卷页面
	 * 前提：网校必需在othersetting注册ID，当前学生未答卷
     * @param int $uid 学生ID
     */
	private function _check_for_survey($uid) {
        $roominfo = Ebh::app()->room->getcurroom();
        $otherconfig = Ebh::app()->getConfig()->load('othersetting');
        if (empty($otherconfig['survey_crids']) || !is_array($otherconfig['survey_crids'])) {
            return;
        }
        $surveyCrids = array_flip($otherconfig['survey_crids']);
        if (!isset($surveyCrids[$roominfo['crid']])) {
            return;
        }
        $survey_model = $this->model('Survey');
        $survey_id = $survey_model->getSurveyIdBeforeBuy($roominfo['crid']);
        if (empty($survey_id)) {
            return;
        }
        $answered = $survey_model->answered($survey_id, $uid);
        if (!$answered) {
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $survey_url = "/survey/{$survey_id}.html?return={$return_url}";
            header("Location:$survey_url");
            exit();
        }
	}
	
	
	
	/*****************************************打折购买处理逻辑 start**********************************************************/
	/**
	 * 收藏课程支付
	 * 读取收藏列表
	 */
	private function _discountPaySecond(){
	    $roominfo = Ebh::app()->room->getcurroom();
	    $systeminfo = Ebh::app()->room->getSystemSetting();
	    $crid = $roominfo['crid'];
	    $mylist = array();
	    $user = Ebh::app()->user->getloginuser();
	    $uid = $user['uid'];
	    $itemarr = $this->model('Collect')->getCollectItemidByUid($uid,$crid);//一维数组
	    if(!empty($itemarr) && ($systeminfo['iscollect']==1)){
	        $limit = count($itemarr);
	        $itemarr = implode(',',$itemarr);//变成1,2形式
	        $param['limit'] = $limit;
	        $param['itemidlist'] = $itemarr;
	        $itemlist = $this->model('PayItem')->getItemFolderList($param);
	        $this->assign('itemid',0);
	        $this->assign('itemlist',$itemlist);
	        $this->assign('mylist',$mylist);
	        $this->assign('user', $user);
	        $this->assign('roominfo', $roominfo);
	        $this->display('common/ibuy_second');
	    }else{
	        header("Location:/");
	    }

	    exit();
	}
	
	
	/**
     * 结算列表展示时使用，根据数量查询网校设置的折扣率
     * 说明：获取折扣率
     *  1.获取设置折扣的最大数量$nummax
     *  2.若$nummax<$num即按照最低折扣计算
     *  3.若$num为设置的某个折扣数量，则按照设置的折扣计算
     *  4.若$nummin<=$num && $nummax >= $num需确保取得合适的折扣区间
     *  5.若$nummin>$num，则无折扣
     * @param  $num  
     * @return $discount
     */
    public function getDiscountByNum(){   
        $room = Ebh::app()->room->getcurroom();
        $crid = $room['crid'];	             			
        $systeminfo = Ebh::app()->room->getSystemSetting();	
        if(!empty($systeminfo['iscollect']) && ($systeminfo['iscollect']==1) && !empty($systeminfo['discounts'])){							//开关开启
	        $num = intval($this->input->get('num')); 		 	//课程数量	
	        $disarr = json_decode($systeminfo['discounts']);    //折扣列表(数组)
	        array_multisort($disarr,SORT_ASC);
	        $count = count($disarr);
	        if($count){      //判断是否设置折扣
		        $nummax = $disarr[$count-1][0];
		        $nummin = $disarr[0][0];
		        if($nummax < $num){								
		            $discount = $disarr[$count-1][1];
		        }
		        if($nummin<=$num && $nummax >= $num){
		            $count = 0;
		            foreach($disarr as $v){
		                $count++;
		                if($v[0] > $num){
		                    $discount = $disarr[$count-2][1];
		                    break;
			            }
		                if($v[0] == $num){
		                    $discount = $disarr[$count-1][1];
		                    break;  
		            	}  
		            }
		        }
		        if($nummin > $num){
		        	$discount = 1;
		        }
		    }else{	//未设置折扣
		    	$discount = 1;
		    }
	    }else{
	    	$discount = 1;
	    }                
        echo json_encode(array('discount' => $discount,'crid'=>$crid));
    }

	/**
	 * 生成订单时使用，根据订单包含课程数查询折扣
	 * @param  		  $foldernum 
	 * @return        $discount
	 * 
	 */
    public function getDiscountByFolderNum($foldernum){
        //计算折扣率
        $room = Ebh::app()->room->getcurroom();
        $crid = $room['crid'];
        $systeminfo = Ebh::app()->room->getSystemSetting();	
        if(!empty($systeminfo['iscollect']) && ($systeminfo['iscollect']==1) && !empty($systeminfo['discounts'])){//开关开启
	        $num = $foldernum;      //课程数量
	        $disarr = json_decode($systeminfo['discounts']);         //折扣列表(数组)
	        array_multisort($disarr,SORT_ASC);
	        $count = count($disarr);
	        if($count){         //判断是否设置折扣
		        $nummax = $disarr[$count-1][0];
		        $nummin = $disarr[0][0];
		        if($nummax < $num){
		            $discount = $disarr[$count-1][1];
		        }
		        if($nummin<=$num && $nummax >= $num){
		            $count = 0;
		            foreach($disarr as $v){
		                $count++;
		                if($v[0] > $num){
		                    $discount = $disarr[$count-2][1];
		                    break;
			            }
		                if($v[0] == $num){
		                    $discount = $disarr[$count-1][1];
		                    break;  
		            	}  
		            }
		        }
		        if($nummin > $num){
		        	$discount = 1;
		        }
		    }else{	//未设置折扣
		    	$discount = 1;
		    }
	    }else{	//开关关闭
	    	$discount = 1;
	    }               
        return $discount;
    }

    /******************************打折购买处理逻辑 end***********************************************************/

 /******************************支付宝扫一扫 支付逻辑，只适合单个课件开通**************************************************/
    /**
	 * 支付宝生成订单
	 */
	public function alipayOrder(){
		$post = $this->input->post();
		$myorder = $this->buildOrder(3);
		if(empty($myorder) && empty($myorder['orderid'])) {
			echo json_encode(array('status'=>-1,'msg'=>'网站订单生成失败！'));
			exit();
		}
		if(!empty($post['money'])){
			$money = floatval($post['money']);
		}
		if(!empty($post['cwid'])){
			$cwid = intval($post['cwid']);
		}
		//检验通过，生成订单
		$param['cwid'] = $cwid;
		$param['totalfee'] = $money;
		$param['dateline'] = SYSTIME;
		$param['ip'] = getip();
		$ordinfo['ordernum'] = $myorder['orderid'];
		$ordinfo['ordername'] = $myorder['ordername'];
		$ordinfo['money'] = $money;
		$ordinfo['status'] = 1;
		if(!empty($ordinfo)){
			echo json_encode($ordinfo);
			exit();
		}
	}
	/**
	 * [alipayQRDate 生成支付宝支付二维码]
	 * @return [type] [description]
	 */
	public function alipayQRDate(){
		$get = $this->input->get();
		if(!empty($get['ordernum'])){
			$ordernum = $get['ordernum'];
		}
		if(!empty($get['ordername'])){
			$ordername = $get['ordername'];
		}
		if (empty($get['cwid']) || !isset($get['money'])) {
		    return false;
        }
		$cwid = intval($get['cwid']);
		$cw = $this->model('courseware')->getcwpay($cwid);
		if(empty($cw))
			return false;
        $money = floatval($get['money']);

        $width = !empty($get['w'])?$get['w']:0;
		if(!empty($ordernum) && is_numeric($ordernum)){
			$domain = getdomain();
			$notify_url = $domain.'/ibuy/alipay_notify.html';
			//页面跳转同步通知页面路径
			//$return_url = 'http://www.ebh.net/demo/alipay_return.html';
			$return_url  = "";
			//商品展示地址
			$show_url = "http://www.ebh.net";
			//必填
			//商户订单号
			$out_trade_no = strval($ordernum);
			//商户网站订单系统中唯一订单号，必填
			//订单名称
			$subject = shortstr($ordername,80,'');			
			//必填
			//付款金额
			$total_fee = $cw['cprice'];
			//订单描述
			$body = $cw['title'].'_'.(empty($cw['cmonth']) ? $cw['cday'].' 天 _':$cw['cmonth'].' 月 _').$cw['cprice'].' 元';
			$param = array('notify_url'=>$notify_url,'return_url'=>$return_url,'trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'show_url'=>$show_url,'width'=>$width);
			//提交支付宝			
			$Alipay = Ebh::app()->lib('Alipay');
			$Alipay->alipayToQR($param);
		}
	}
	/**
	 * 支付状态通知页
	 */
	public function  alipay_notify(){
		$alilib = Ebh::app()->lib('Alipay');
		$verify_result = $alilib->checknotify();
		if(!$verify_result) {	//验证不通过
			echo "fail";
		}
		//商户订单号
		$orderid = $this->input->post('out_trade_no');
		//支付宝交易号
		$ordernumber = $this->input->post('trade_no');
		$buyer_id = $this->input->post('buyer_id');
		$buyer_info = $this->input->post('buyer_email');
		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			log_message('订单不存在');
			$alilib->notify(FALSE);
			exit();
		}
		$redis = Ebh::app()->getCache("cache_redis");
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$ordernumKey = md5($orderid);
			$redis->set($ordernumKey,1);
			log_message("支付宝支付成功:".$orderid);
			$alilib->notify(TRUE);
			exit();
		}
		$ordernumKey = md5($orderid);
		$redis->set($ordernumKey,1);
		echo 'success';
		log_message("支付宝支付成功:".$orderid);
		$alilib->notify(FALSE);
	}

	/**
	* 返回支付状态
	*/
	public function  getpaystatus(){
		$redis = Ebh::app()->getCache("cache_redis");
		$post = $this->input->post();
		if(!empty($post['ordernum'])){
			$ordernum = $post['ordernum'];
			$ordernumKey = md5($ordernum);			
			$ck = $redis->get($ordernumKey);			
			if($ck){
				echo json_encode(array('code'=>1));
				fastcgi_finish_request();
				$redis->remove($ordernumKey);
			}else{
				echo json_encode(array('code'=>0));
			}
		}else{
			echo json_encode(array('code'=>0));
		}
	}

	/**
	 * [checkWallet 检验我的钱包内的钱 是否大于 需要支付的钱]
	 * @return [type] [description]
	 */
	public function checkWallet(){
		$money = $this->input->post('money');
		$money = floatval($money);
		$user = Ebh::app()->user->getloginuser();
		if (!$user) {
			echo json_encode(array('status'=>0));
		}
		echo json_encode(array('status'=>1,'balance'=>$user['balance']));
	}

 /******************************支付宝扫一扫 支付逻辑**************************************************/

 	/**
 	 * 对分销的参数解析
 	 */
    function parse_sharekey($sharekey) {
    	//有激活码的情况，分销不成立
    	$cardnumber = $this->input->post('cardnumber');
    	if (!empty($cardnumber)) {
    		return false;
    	}
        if (empty($sharekey)) {
            return false;
        }
        $sharekey = str_replace(' ', '+', $sharekey);
        $sharekey = explode('%',authcode($sharekey, 'DECODE'));
        return $sharekey;
    }


    /**
     *判断禁用其他网校的人购买，是的话判断是否该网校的用户
     */
    public function checkRoomUser() {
    	//网校配置
        $systemsetting = Ebh::app()->room->getSystemSetting();
	    $isbanbuy = empty($systemsetting['isbanbuy']) ? 0 : 1;
	    //1禁用其他网校的人购买
        if ($isbanbuy) {
        	$check = Ebh::app()->room->checkstudent(TRUE);
	        if ($check < 1) {
	        	header("Content-type: text/html; charset=utf-8");
	        	$url  =  '/';
				echo '<script language = "javascript" type = "text/javascript" >'; 
				echo 'alert("非网校学员不能购买");window.location.href = "'.$url.'"';  
				echo '</script>';
	        	exit();
	        }
        }
    }
}