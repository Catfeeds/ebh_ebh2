<?php
/*
精品课堂
*/
class JingpinController extends AdminControl{
	/*
	显示列表首页
	*/
	public function index(){
		$this->display('admin/bests_itemlist');
	}
	
	/*
	ajax获取精品课堂列表
	*/
	public function getListAjax(){
		$queryArr['q'] = $this->inject_check($this->input->post('query'));
		$queryArr['providercrid'] = intval($this->input->post('providercrid'));
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$list = $this->model('bestitem')->getItemList($queryArr);
		$total = $this->model('bestitem')->getItemListCount($queryArr);
		$hasbuy = $this->input->post('hasbuy');
		$uid = $this->input->post('uid');
		if(!empty($hasbuy) && !empty($uid)){
			$list = $this->_insertIfHasBuyInfo($list,$uid);
		}
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	/*
	添加精品课堂
	*/
	public function add(){
		if($this->input->post()){
			$param['iname'] = $this->input->post('iname');
			$param['iprice'] = $this->input->post('iprice');
			$param['isummary'] = $this->input->post('isummary');
			$param['folderid'] = $this->input->post('folderid');
			$param['bsid'] = $this->input->post('bsid');
			$param['msid'] = $this->input->post('msid');
			$param['ssid'] = $this->input->post('ssid');
			$param['label'] = $this->input->post('label');
			$param['labelname'] = $this->input->post('labelname');
			if ($param['label'])
			$param['labelids'] = implode(',', $param['label']);
			$param['providercrid'] = $this->input->post('providercrid');
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
			$monthorday = array('imonth','iday');
			$bywhich = $this->input->post('bywhich');
			$param[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);
			$pimodel = $this->model('bestitem');
			$res = $pimodel->add($param);
			//print_r($param['labelname']);exit;
			$otherparam['itemid'] = $res;
			$bestlabels = $this->model('bestlabels');
			if ($param['labelname']) {
				foreach ($param['labelname'] as $key => $value) {
					$otherparam['label'] = $this->inject_check($value);
					$bestlabels->additemlabel($otherparam);
				}
			}
			if(isset($res)){
				$note[] = '确定并关闭';
				$rurl[] = '/admin/jingpin.html';
				$note[] = '继续添加';
				$rurl[] = '/admin/jingpin/add.html';
				$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
			}
			else
				echo "添加失败";exit;
			
		}else{
			$this->display('admin/bests_itemadd');
		}
	}
	
	/*
	编辑精品课堂
	*/
	public function edit(){
		$pimodel = $this->model('bestitem');
		if($this->input->post()){
			$param['itemid'] = $this->input->post('itemid');
			$param['iname'] = $this->input->post('iname');
			$param['iprice'] = $this->input->post('iprice');
			$param['isummary'] = $this->input->post('isummary');
			$param['folderid'] = $this->input->post('folderid');
			$param['bsid'] = $this->input->post('bsid');
			$param['msid'] = $this->input->post('msid');
			$param['ssid'] = $this->input->post('ssid');
			$param['label'] = $this->input->post('label');
			if ($param['label'])
				$param['labelids'] = implode(',', $param['label']);
			$param['providercrid'] = $this->input->post('providercrid');
			$param['comfee'] = $this->input->post('comfee');
			$param['roomfee'] = $this->input->post('roomfee');
			$param['providerfee'] = $this->input->post('providerfee');
			$longblockimg = $this->input->post('longblockimg');
			$param['longblockimg'] = $longblockimg['upfilepath'];
			$param['cannotpay'] = $this->input->post('cannotpay')?1:0;
			$param['isyouhui'] = $this->input->post('isyouhui')?1:0;
			$param['iprice_yh'] = $this->input->post('iprice_yh');
			$param['comfee_yh'] = $this->input->post('comfee_yh');
			$param['roomfee_yh'] = $this->input->post('roomfee_yh');
			$param['providerfee_yh'] = $this->input->post('providerfee_yh');
			$monthorday = array('imonth','iday');
			$bywhich = $this->input->post('bywhich');
			$param[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);
			$pimodel = $this->model('bestitem');
			$res = $pimodel->edit($param);

			if ($this->input->post('labelname')) {
				$param['labelname'] = $this->input->post('labelname');
				$otherparam['itemid'] = $param['itemid'];
				$bestlabels = $this->model('bestlabels');
				foreach ($param['labelname'] as $key => $value) {
					$otherparam['label'] = $this->inject_check($value);
					$bestlabels->additemlabel($otherparam);
				}
			}

			if ($this->input->post('dellabelname')) {
				$param['labelname'] = $this->input->post('dellabelname');
				$otherparam['itemid'] = $param['itemid'];
				$bestlabels = $this->model('bestlabels');
				foreach ($param['labelname'] as $key => $value) {
					$otherparam['label'] = $this->inject_check($value);
					$bestlabels->delitemlabel($otherparam);
				}
			}

			$returnurl = '/admin/jingpin.html';
			if(isset($res)){
				$note[] = '确定并关闭';
				$rurl[] = '/admin/jingpin.html';
				$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
			}
			else
				echo "添加失败";exit;
		}else{
			$itemid = intval($this->input->get('itemid'));
			$itemdetail = $pimodel->getItemByItemid($itemid);
			if(!empty($itemdetail['providercrid'])){
				$crmodel = $this->model('classroom');
				$providerinfo = $crmodel->getdetailclassroom($itemdetail['providercrid']);
				$itemdetail['providercrname'] = $providerinfo['crname'];
			}
			$this->assign('itemdetail',$itemdetail);
			$this->display('admin/bests_itemedit');
		}
	}
	public function del(){
		$pimodel = $this->model('bestitem');
		$itemid = intval($this->input->post('itemid'));
		
		echo json_encode(array('success'=>$pimodel->deleteitem($itemid)));
		
	}
	
	/*
	浏览详细信息
	*/
	public function view(){
		$pimodel = $this->model('bestitem');
		$itemid = intval($this->input->get('itemid'));
		$itemdetail = $pimodel->getItemByItemid($itemid);
		$this->assign('itemdetail',$itemdetail);
		$this->display('admin/bests_itemview');
	}
	
	/*
	*获取可以添加的课堂，除去已经添加
	*/
	public function getroomfolders(){
		$crid = intval($this->input->post('crid'));
		$queryArr['providercrid'] = intval($this->input->post('crid'));
		$queryArr['nolimit'] = 1;
		$fmodel = $this->model('folder');
		$bmodel = $this->model('bestitem');
		$folderlist = $fmodel->getfolderlist(array('crid'=>$crid,'nosubfolder'=>1,'limit'=>10000));
		$folderaddedlist = $bmodel->getItemList($queryArr);
		if ($this->input->post('ifshowself')) {//需要显示本身的课程
			$showkey = $this->input->post('ifshowself');
			foreach ($folderaddedlist as $addkey => $addvalue) {
				foreach ($folderlist as $key => $value) {
					if ($addvalue['folderid'] == $value['folderid'] && $addvalue['folderid'] != $showkey)
						unset($folderlist[$key]);
				}
			}
			echo json_encode($folderlist);exit;
		}
		foreach ($folderaddedlist as $addkey => $addvalue) {
			foreach ($folderlist as $key => $value) {
				if ($addvalue['folderid'] == $value['folderid'])
					unset($folderlist[$key]);
			}
		}
		echo json_encode($folderlist);
	}
	
	
	/*
	删除无精品课程的标签
	*/
	public function delNoitemsLabel() {
		$id = intval($this->input->post('id'));
		$labelsModel = $this->model('bestlabels');
		$mes['id'] = $labelsModel->dellabel($id);
		$mes['success'] = '删除成功';
		echo json_encode($mes);exit;
	}

	/*
	编辑标签，其中包括删除标签
	*/
	public function editlabel() {
		if ($this->input->post('id')) {
			$id = intval($this->input->post('id'));
			$sid = intval($this->input->post('sid'));
			$labelsModel = $this->model('bestlabels');
			$param['label'] = $this->inject_check($this->input->post('label'));
			if ($param['label'] == '') {//删除工作
				//删除标签
				$mes['id'] = $labelsModel->dellabel($id);

				//更新精品课程的labelids字段数据
				$bestitem = $this->model('bestitem');
				$rows = $bestitem->getItemListByssid($sid);
				if ($rows) {
					foreach ($rows as $key => $value) {
						if (strpos($value['labelids'], ','.$id.',') !== false) {
							$value['labelids'] = str_replace(','.$id.',', ',', $value['labelids']);
							$updates[$value['itemid']] = $value['labelids'];continue;
						} else {//考虑到标签id刚好在首或尾如111,2,333
							if (substr($value['labelids'], 0, strpos($value['labelids'], ',')) == $id) {
								$value['labelids'] = substr($value['labelids'], strpos($value['labelids'], ',')+1);
								$updates[$value['itemid']] = $value['labelids'];continue;
							} elseif (substr($value['labelids'], strrpos($value['labelids'], ',')-strlen($value['labelids'])+1) == $id) {
								$value['labelids'] = substr($value['labelids'], 0, strrpos($value['labelids'],','));
								$updates[$value['itemid']] = $value['labelids'];continue;
							} else {//有些ids比如1
								$updates[$value['itemid']] = $value['labelids'];continue;
							}
						}	
					}
				}
				$ids = implode(',', array_keys($updates));
				$bestitem->updateItemlabelids($updates, $ids);	

				//删除标签与课程关联表信息
				$labelname = $this->inject_check($this->input->post('labelname'));
				$labelsModel->delLabelItems($labelname, $ids);

				$mes['success'] = '删除成功';
				echo json_encode($mes);exit;
			}
			$named = $labelsModel->check($sid, $param['label']);
			if ($named) {
				echo 0;exit;
			}
			$mes['id'] = $labelsModel->updatelabel($param, $id);
			$mes['success'] = '修改成功';
			$mes['msg'] = $param['label'];
			echo json_encode($mes);exit;
		}
		$sortsModel = $this->model('bestsorts');
		$bsid = $sortsModel->getSort();
		$this->assign('bsid',$bsid);
		$this->display('admin/bests_labelsedit');

	}

	/*
	编辑分类，其中包括删除分类
	*/
	public function editsort() {	
		$id = intval($this->input->post('id'));
		$sortsModel = $this->model('bestsorts');
		$param['sname'] = $this->inject_check($this->input->post('label'));//前端用的是同一个ajax
		if ($param['sname'] == '') {//删除操作，同时删除对应第三分类下的标签和课堂，还有标签和课堂的对
			//删除分类
			$level = $this->input->post('level') . 'sid';
			$sort = $sortsModel->getSortBysid($id);
			$path = $sort['spath'];
			$bsidpath = '';
			if ($level == 'bsid') {
				$bsidpath = $path;
				$path .= '/';
			}
			$childsort = $sortsModel->getNextSort($path);
			$sortsModel->delSortByPath($path, $bsidpath);

			if ($childsort) {
				$bestitem = $this->model('bestitem');
				//删除标签与精品课堂的对应表
				$items = $bestitem->getitemBySidLevel($level, $id);
				$delitems = '';
				foreach ($items as $key => $value) {
					$delitems .= $value['itemid'] . ',';
				}
				$delitems = substr($delitems, 0, strlen($delitems)-1);
				if ($delitems)
					$bestitem->delLabelByitemid($delitems);

				//删除精品课堂
				$rows = $bestitem->deleteitemBySid($level, $id);

				//删除标签
				$ssid = '';
				foreach ($childsort as $key => $value) {
					if (substr_count($value['spath'], '/' ) == 3) {
						$ssid .= $value['sid'] . ',';
					}
				}
				$ssid = substr($ssid, 0, strlen($ssid)-1);
				if ($ssid)
					$sortsModel->delLabelBysid($ssid);

				$mes['success'] = '删除成功';
				echo json_encode($mes);exit;
			}

			$mes['success'] = '删除失败';
			echo json_encode($mes);exit;
		}
		$named = $sortsModel->check($param['sname']);
		if ($named) {
			echo 0;exit;
		}
		$mes['id'] = $sortsModel->updatesort($param, $id);
		$mes['success'] = '修改成功';
		$mes['msg'] = $param['sname'];
		echo json_encode($mes);exit;
	}

	/*
	ajax添加分类
	*/
	public function addsort(){
		$sortsModel = $this->model('bestsorts');
		$bsid = $sortsModel->getSort();
		$this->assign('bsid',$bsid);
		$this->display('admin/bests_sortsadd');
	}

	/*
	ajax获取分类
	*/
	public function getsortAjax(){
		$sid = intval($this->input->post('sid'));
		$sorttype = $this->input->post('sorttype');
		$sortsModel = $this->model('bestsorts');
		$sid = $sortsModel->getSort($sid);
		echo json_encode($sid);
	}

	/*
	ajax获取标签
	*/
	public function getLabelAjax(){
		$sid = intval($this->input->post('sid'));
		$labelsModel = $this->model('bestlabels');
		$label = $labelsModel->getLabelBySid($sid);
		echo json_encode($label);
	}

	/*
	ajax添加标签
	*/
	public function addlabelAjax(){
		$sid = intval($this->input->post('sid'));
		$label = $this->inject_check($this->input->post('label'));
		$labelsModel = $this->model('bestlabels');
		$named = $labelsModel->check($sid, $label);
		if ($named) {
			echo 0;exit;
		}
		$param['sid'] = $sid;
		$param['label'] = $label;
		$id = $labelsModel->addlabel($param);
		echo json_encode($id);
	}

	/*
	ajax添加分类
	*/
	public function addsortAjax(){
		$psid = intval($this->input->post('psid'));
		$sname = $this->inject_check($this->input->post('sname'));
		$path = $this->inject_check($this->input->post('path'));
		$sortsModel = $this->model('bestsorts');
		$named = $sortsModel->check($sname);
		if ($named) {
			echo 0;exit;
		}
		$param['psid'] = $psid;
		$param['sname'] = $sname;
		$param['path'] = $path;
		$id = $sortsModel->addsort($param);
		$sortadded['sid'] = $id;
		$sortadded['sname'] = $sname;
		$sortadded['psid'] = $psid;
		$sortadded['path'] = $path . '/' . $id;
		$sortsModel->updatesort($sortadded,$sortadded['sid']);
		echo json_encode($sortadded);
	}

	/*
	通过sname检测是否存在分类名称
	*/
	public function checksortAjax(){
		$sname = $this->inject_check($this->input->post('sname'));
		$sortsModel = $this->model('bestsorts');
		$sort = $sortsModel->check($sname);
		if($sort){
			echo false;
		}else{
			echo true;
		}
	}

	/*
	通过itemid检测是否添加到后台服务项
	*/
	public function checkHasBuy() {
		$bestitem = $this->model('bestitem');
		$param['itemid'] = intval($this->input->post('itemid'));
		if ($bestitem->checkHasBuy($param)) {
				$param['hasbuy'] = 1; 
				echo json_encode($param);
			} else {
				$param['nobuy'] = 1; 
				echo json_encode($param);
		}
	}

	/*
	通过sid或者label检测是否存在精品课堂项目
	*/
	public function checkHasItem() {
		$sid = intval($this->input->post('sid'));
		$bestitem = $this->model('bestitem');
		if ($this->input->post('label')) {
			$label = $this->inject_check($this->input->post('label'));
			$id = intval($this->input->post('id'));
			$rows = $bestitem->getItemListByssid($sid);
			$count = 0;
			if ($rows) {
				foreach ($rows as $key => $value) {
					if ($id == $value['labelids']) {
						$count++;break;
					}
					if (strpos($value['labelids'], ','.$id.',') !== false) {
							$count++;break;
					} else {//考虑到标签id刚好在首或尾如1,2,333
						if (substr($value['labelids'], 0, strpos($value['labelids'], ',')) == $id) {
							$count++;break;
						} elseif (substr($value['labelids'], strrpos($value['labelids'], ',')-strlen($value['labelids'])+1) == $id) {
							$count++;break;
						} 
					}
				}
			}
			if ($count) { 
				echo 1;exit; 
			} else {
				echo 0;exit;
			}
		}
		$level = $this->inject_check($this->input->post('level'));
		$level = $level . 'sid';
		$rows = $bestitem->getitemBySidLevel($level, $sid);
		if ($rows) {
			$param['itemidlist'] = '';
			foreach ($rows as $key => $value) {
					$param['itemidlist'] .= $value['itemid'] . ',';	
			}
			$param['itemidlist'] = substr($param['itemidlist'], 0, strlen($param['itemidlist'])-1);
			if ($bestitem->checkHasBuy($param)) {
				$param['hasbuy'] = 1; 
				echo json_encode($param);
			} else {
				$param['nobuy'] = 1; 
				echo json_encode($param);
			}
		} else {
			echo 0;exit;
		}
	}

	/**
     * [inject_check 通过正则匹配字符串中是否存在sql关键字]
     * @param  [type] $sql_str [description]
     * @return [type]          [description]
     */
    private function inject_check($sql_str){     
    	if(!preg_match('/select|insert|and|or|update|delete|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/',$sql_str)) {
    		return $sql_str;
    	} else {
    		echo '出现非法字符';exit;
    	}
	}	
}
?>