<?php
/*
服务项
*/
class SpitemController extends AdminControl{
	public function index(){
		$this->display('admin/servicepack_itemlist');
	}
	
	public function getListAjax(){
		$queryArr['q'] = $this->input->post('query');
		$queryArr['pid'] = $this->input->post('pid');
		$queryArr['crid'] = $this->input->post('crid');
		$queryArr['tid'] = $this->input->post('tid');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$list = $this->model('Payitem')->getItemList($queryArr);
		$total = $this->model('Payitem')->getItemListCount($queryArr);
		$hasbuy = $this->input->post('hasbuy');
		$uid = $this->input->post('uid');
		if(!empty($hasbuy) && !empty($uid)){
			$list = $this->_insertIfHasBuyInfo($list,$uid);
		}
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	
	public function add(){
		if($this->input->post()){
			$param['crid'] = intval($this->input->post('crid'));
            $param['folderid'] = intval($this->input->post('folderid'));
            $pimodel = $this->model('Payitem');
			$param['sid'] = intval($this->input->post('sid'));
            $param['iname'] = $this->input->post('iname');
            $param['pid'] = intval($this->input->post('pid'));
            $param['iprice'] = $this->input->post('iprice');
            $param['isummary'] = $this->input->post('isummary');
			$param['providercrid'] = intval($this->input->post('providercrid'));
			$param['cannotpay'] = $this->input->post('cannotpay')?1:0;
			$param['comfee'] = $this->input->post('comfee');
			$param['roomfee'] = $this->input->post('roomfee');
			$param['providerfee'] = $this->input->post('providerfee');
			$longblockimg = $this->input->post('longblockimg');
			$param['longblockimg'] = $longblockimg['upfilepath'];
			$param['isyouhui'] = $this->input->post('isyouhui');
			$param['iprice_yh'] = $this->input->post('iprice_yh');
			$param['comfee_yh'] = $this->input->post('comfee_yh');
			$param['roomfee_yh'] = $this->input->post('roomfee_yh');
			$param['providerfee_yh'] = $this->input->post('providerfee_yh');
			$param['ptype'] = $this->input->post('ptype');
            $param['view_mode'] = max(intval($this->input->post('view_mode')), 0);
			$monthorday = array('imonth','iday');
			$bywhich = $this->input->post('bywhich');
			$param[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);



            //同步课程数据
            $fparam['isschoolfree'] = intval($this->input->post('isschoolfree'));
            $fparam['folderid'] = $param['folderid'];
            $fparam['fprice'] = $param['iprice'];
            $fparam['crid'] = $param['crid'];
            $fmodel = $this->model('Folder');

            $sort = $this->model('Paysort')->getSortdetail($param['sid']);
            if (empty($sort['showbysort'])) {
                $exits_single_item = $pimodel->isSingleExists($param['folderid'], $param['crid']);
                if ($exits_single_item === false || $exits_single_item > 0) {
                    $this->goback('课程已存在服务项，添加失败!', '/admin/spitem/add.html?crid='.$param['crid']);
                    exit();
                }
            }

            $renameable = true;
            if (!empty($sort['showbysort'])) {
                $renameable = false;
            }

			$fparam['foldername'] = $param['iname'];


            $db = Ebh::app()->getDb();
            $db->begin_trans();
			$res = $pimodel->add($param);
            if ($db->trans_status() === true) {
                $fmodel->editcourse($fparam);
            }
            if ($db->trans_status() === true) {
                $res = true;
                $db->commit_trans();
            } else {
                unset($res);
                $db->rollback_trans();
            }

			if(isset($res)){
				$note[] = '确定并关闭';
				$rurl[] = '/admin/spitem.html';
				$note[] = '继续添加';
				$rurl[] = '/admin/spitem/add.html?pid='.$param['pid'];
				$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
				//更新服务项后更新缓存
				updateRoomCache($param['crid'],'payitem');
			}
			else
				$this->goback('添加失败!', '/admin/spitem/add.html?crid='.$param['crid']);
			
		}else{
			$pid = $this->input->get('pid');
			if(!empty($pid)){
				$ppmodel = $this->model('Paypackage');
				$packdetail = $ppmodel->getPackByPid($pid);
				$this->assign('packdetail',$packdetail);
			}else{
				$crid = $this->input->get('crid');
				if(!empty($crid)){
					$crmodel = $this->model('classroom');
					$roomdetail = $crmodel->getclassroomdetail($crid);
					$this->assign('packdetail',$roomdetail);
				}
			}
			$this->display('admin/servicepack_itemadd');
		}
	}
	
	public function edit(){
		$pimodel = $this->model('Payitem');
		if($this->input->post()){
            $param['folderid'] = intval($this->input->post('folderid'));
			$param['itemid'] = intval($this->input->post('itemid'));
			$param['iname'] = $this->input->post('iname');
			$param['crid'] = intval($this->input->post('crid'));
			if(empty($param['crid']))
				$param['crid'] = intval($this->input->post('pcrid'));
			$param['pid'] = intval($this->input->post('pid'));
			$param['iprice'] = $this->input->post('iprice');
			$param['isummary'] = $this->input->post('isummary');
			$param['sid'] = intval($this->input->post('sid'));
			$param['providercrid'] = $this->input->post('providercrid');
			$param['comfee'] = $this->input->post('comfee');
			$param['roomfee'] = $this->input->post('roomfee');
			$param['providerfee'] = $this->input->post('providerfee');
			$param['cannotpay'] = $this->input->post('cannotpay')?1:0;
			$longblockimg = $this->input->post('longblockimg');
			$param['longblockimg'] = $longblockimg['upfilepath'];
			$param['isyouhui'] = $this->input->post('isyouhui')?1:0;
			$param['iprice_yh'] = $this->input->post('iprice_yh');
			$param['comfee_yh'] = $this->input->post('comfee_yh');
			$param['roomfee_yh'] = $this->input->post('roomfee_yh');
			$param['providerfee_yh'] = $this->input->post('providerfee_yh');
			$param['ptype'] = $this->input->post('ptype');
            $param['view_mode'] = intval($this->input->post('view_mode'));
			$monthorday = array('imonth','iday');
			$bywhich = $this->input->post('bywhich');
			$param[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);
            $returnurl = '/admin/spitem.html';
            //同步课程数据
            $fparam['isschoolfree'] = intval($this->input->post('isschoolfree'));
            $fparam['displayorder'] = max(intval($this->input->post('fdisplayorder')), 0);
            $fparam['folderid'] = $param['folderid'];
            $fparam['fprice'] = $param['iprice'];
            $fparam['crid'] = $param['crid'];
            $renameabled = true;
            $fmodel = $this->model('Folder');
            if ($param['sid'] > 0) {
                $sort = $this->model('Paysort')->getSortdetail($param['sid']);
                if (!empty($sort['showbysort'])) {
                    $renameabled = false;
                }
            }

			$fparam['foldername'] = $param['iname'];

			$pimodel = $this->model('Payitem');

			//先取出原服务项信息
			$payitem = $pimodel->getItemByItemid($param['itemid']);
            $db = Ebh::app()->getDb();
            $db->begin_trans();
			$res = $pimodel->edit($param);
            if ($db->trans_status() === true) {
                $fmodel->editcourse($fparam);
            }
            if ($db->trans_status() === true) {
                $res = true;
                $db->commit_trans();
            } else {
                unset($res);
                $db->rollback_trans();
            }


			if(isset($res)){
				$note[] = '确定并关闭';
				$rurl[] = '/admin/spitem.html';
				$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
				updateRoomCache($param['crid'],'payitem');
				$oldcrid = $payitem['crid'];
				if($oldcrid != $param['crid']) {	//如果服务项所属crid有变动，则将原有crid对应的缓存也更新
					updateRoomCache($oldcrid,'payitem');
				}
			}
			else
				$this->goback('添加失败!','/admin/spitem/edit.html?itemid='.$param['itemid']);
		}else{
			$itemid = $this->input->get('itemid');
			$itemdetail = $pimodel->getItemByItemid($itemid);
			if(!empty($itemdetail['providercrid'])){
				$crmodel = $this->model('classroom');
				$providerinfo = $crmodel->getdetailclassroom($itemdetail['providercrid']);
				$itemdetail['providercrname'] = $providerinfo['crname'];
			}
			$this->assign('itemdetail',$itemdetail);
			$this->display('admin/servicepack_itemedit');
		}
	}
	public function del(){
		$pimodel = $this->model('Payitem');
		$itemid = intval($this->input->post('itemid'));
		//先取出原服务项信息
		$payitem = $pimodel->getItemByItemid($itemid);
		//删除服务项前选判断关联的课程下有没课件，没有课件才允许删除
        $folderModel = $this->model('Folder');
        $hasCoureware = $folderModel->hasCourseware($payitem['folderid']);

		$result = $pimodel->deleteitem($itemid, $hasCoureware);
        if (!$result) {
            $msg = $hasCoureware ? '关联课程下包含课件，不允许删除' : '删除失败';
            echo json_encode(array($msg));
            exit();
        }
		echo json_encode(array('success'=>$result));
		if($result !== FALSE) {
			updateRoomCache($payitem['crid'],'payitem');
		}
	}
	
	public function view(){
		$pimodel = $this->model('Payitem');
		$itemid = $this->input->get('itemid');
		$itemdetail = $pimodel->getItemByItemid($itemid);
		$this->assign('itemdetail',$itemdetail);
		$this->display('admin/servicepack_itemview');
	}
	
	public function getroomfolders(){
		$crid = $this->input->post('crid');
		$fmodel = $this->model('folder');
		$folderlist = $fmodel->getfolderlist(array('crid'=>$crid,'nosubfolder'=>1,'limit'=>10000));
		echo json_encode($folderlist);
	}
	
	public function goback($note="操作成功,正在努力跳转中...",$returnurl="/admin/spitem.html"){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
	
	public function servicepack_itemsearch(){
		$this->display('admin/servicepack_itemsearch');
	}
	public function servicepack_itemsearch_formember(){
		$uid = $this->input->get('uid');
		$userinfo = $this->model('user')->getuserbyuid(intval($uid));
		$this->assign('userinfo',$userinfo);
		//获取学生所在学校的信息
		$crlist = $this->model('classroom')->getUserClassroom(intval($uid));
		$crname = "";
		$crid = 0;
		if(!empty($crlist)){
			$crname = $crlist[0]['crname'];
			$crid = $crlist[0]['crid'];
		}
		$this->assign('crid',$crid);
		$this->assign('crname',$crname);

		$this->display('admin/servicepack_itemsearch_formember');
	}

	/**
	 *将指定用户是否购买过该课程的信息注入到课程信息中去
	 */
	private function _insertIfHasBuyInfo($list,$uid){
		if(empty($list)){
			return array();
		}
		//第一步，获取当前数组中的所有itemid
		$itemidArr = array();
		foreach ($list as &$eachone) {
			$eachone['hasbuy'] = 0;
			array_push($itemidArr, $eachone['itemid']);
		}
		$itemidArr = array_unique($itemidArr);
		$orderlist = $this->model('payorder')->getOrdersByItemidsAndUid($itemidArr,$uid);

		$orderlistWithKey = array();
		if(!empty($orderlist)){
			foreach ($orderlist as $order) {
				$key = 'k_'.$order['itemid'];
				if(array_key_exists($key, $orderlistWithKey)){
					if($orderlistWithKey[$key]['paytime'] < $order){
						$orderlistWithKey[$key] = $order;
					}else{
						continue;
					}
				}
				$orderlistWithKey[$key] = $order;
			}
		}else{
			return $list;
		}
		foreach ($list as &$eachone) {
			$key = 'k_'.$eachone['itemid'];
			if(array_key_exists($key, $orderlistWithKey)){
				$eachone['hasbuy'] = 1;
				$eachone['payfrom'] = $orderlistWithKey[$key]['payfrom'];
				$eachone['paytime'] = date('Y-m-d H:i:s',$orderlistWithKey[$key]['paytime']);
			}
		}
		return $list;
	}
}