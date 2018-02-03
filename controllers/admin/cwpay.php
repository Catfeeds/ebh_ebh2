<?php
/*
服务项
*/
class CwpayController extends AdminControl{
	public function index(){
		$this->display('admin/cwpay');
	}
	
	public function getListAjax(){
		$queryArr['q'] = $this->input->post('query');
		$queryArr['pid'] = $this->input->post('pid');
		$queryArr['itemid'] = $this->input->post('itemid');
		$queryArr['crid'] = $this->input->post('crid');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$cwmodel = $this->model('courseware');
		$spmodel = $this->model('paypackage');
		if(!empty($queryArr['pid']) || !empty($queryArr['itemid'])){//筛选服务包/服务项时,先查folderid,再查课件
			$splist = $spmodel->getPackageFolders($queryArr);
			$folderids = array_column($splist,'folderid');
			$folderids = implode(',',$folderids);
			$queryArr['folderids'] = $folderids;
			$list = $cwmodel->getcwpaylist($queryArr);
			$total = $cwmodel->getcwpaycount($queryArr);
		}else{//不筛选服务包/服务项时,先查课件,再查服务包/服务项
			$list = $cwmodel->getcwpaylist($queryArr);
			$total = $cwmodel->getcwpaycount($queryArr);
			$folderids = array_column($list,'folderid');
			$folderids = implode(',',$folderids);
			$splist = $spmodel->getPackByFolderid(array('folderids'=>$folderids));
		}
		$sparr = array();
		foreach($splist as $sp){
			$sparr[$sp['folderid']] = $sp;
		}
		foreach($list as &$cw){
			$cw['iname'] = $sparr[$cw['folderid']]['iname'];
			$cw['pname'] = $sparr[$cw['folderid']]['pname'];
			$cw['pid'] = $sparr[$cw['folderid']]['pid'];
			$cw['itemid'] = $sparr[$cw['folderid']]['itemid'];
			
		}
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	
	
	public function edit(){
		if($this->input->post()){
            $where['cwid'] = $this->input->post('cwid');
            $where['crid'] = $this->input->post('crid');
            $param['cprice'] = $this->input->post('cprice');
            $param['title'] = $this->input->post('title');
            $monthorday = array('cmonth','cday');
			$bywhich = $this->input->post('bywhich');
			$param[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);
			$param[$monthorday[1-$bywhich]] = 0;
			$param['comfee'] = $this->input->post('comfee');
			$param['roomfee'] = $this->input->post('roomfee');
			$this->model('courseware')->update($param,$where);
			$note[] = '确定并关闭';
			$rurl[] = '/admin/cwpay.html';
			$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl,'message'=>'操作成功'));
		}else{
			$cwid = $this->input->get('cwid');
			$cw = $this->model('courseware')->getcwpay($cwid);
			$this->assign('cw',$cw);
			$this->display('admin/cwpay_edit');
		}
	}
	public function del(){
		$pimodel = $this->model('Payitem');
		$itemid = intval($this->input->post('itemid'));
		//先取出原服务项信息
		$payitem = $pimodel->getItemByItemid($itemid);
		$result = $pimodel->deleteitem($itemid);
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
	
	public function goback($note="操作成功,正在努力跳转中...",$returnurl="/admin/cwpay.html"){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
	

}