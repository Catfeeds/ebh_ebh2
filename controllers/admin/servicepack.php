<?php
/*
服务包控制器
*/
class ServicepackController extends AdminControl{

	public function index(){
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->display('admin/servicepack_list');
	}
	
	
	public function getListAjax(){
		$query = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		
		$queryArr['crid'] = $this->input->post('crid');
		$queryArr['q'] = $query;
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$list = $this->model('Paypackage')->getsplist($queryArr);
		foreach($list as $k=>$cr){
			$feearr = unserialize($cr['profitratio']);
			$list[$k]['comfeepercent'] = $feearr['company'];
			$list[$k]['roomfeepercent'] = $feearr['teacher'];
			$list[$k]['providerfeepercent'] = $feearr['agent'];
		}
		$total = $this->model('Paypackage')->getspcount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	public function del(){
		$ppmodel = $this->model('Paypackage');
		$pid = intval($this->input->post('pid'));
		$package = $ppmodel->getPackByPid($pid);
		if(empty($package)) {
			echo json_encode(array('success'=>false));
			exit();
		}
        $delarr = array('crid'=>$package['crid'],'pid'=> $pid);
        $res = $ppmodel->hasCheck($delarr);
        $result = true;
        if(empty($res['pid'])){
            echo json_encode('删除失败,该分类已不存在');
            exit();
        }elseif($res['itemcount']>0){
            echo json_encode('该分类下还有课程,不能删除');
            exit();
        }else{
            $db = Ebh::app()->getDb();
            $db->begin_trans();
            $ppmodel->deletepack($pid);
            $result = $db->trans_status();
            if ($result === true) {
                $result = $ppmodel->deletesort($pid);
            }
            if ($result !== FALSE) {	//删除服务包后更新缓存
                $db->commit_trans();
                updateRoomCache($package['crid'],'paypackage');
            } else {
                $db->rollback_trans();
            }
        }


		echo json_encode(array('success'=>$result));
	}
	
	public function add(){
		if($this->input->post()){
			$user = Ebh::app()->user->getloginuser();
			$param['pname'] = $this->input->post('pname');
			$param['crid'] = intval($this->input->post('crid'));
			$param['summary'] = $this->input->post('summary');
			
			$param['uid'] = $user['uid'];
			$param['displayorder'] = $this->input->post('displayorder');
			$limitchecked = $this->input->post('limitchecked');
			$limitdate = $this->input->post('limitdate');
			if(!empty($limitchecked))
				$param['limitdate'] = strtotime($limitdate);
			else
				$param['limitdate'] = 0;
			$ppmodel = $this->model('Paypackage');
			$res = $ppmodel->add($param);

			if(isset($res)){
				$note[] = '确定并关闭';
				$rurl[] = '/admin/servicepack.html';
				$note[] = '继续添加';
				$rurl[] = '/admin/servicepack/add.html';
				$note[] = '添加服务项到该服务包下';
				$rurl[] = '/admin/spitem/add.html?pid='.$res;
				$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
				//更新服务包后更新缓存
				updateRoomCache($param['crid'],'paypackage');
			}
			else
				$this->goback('添加失败!',$returnurl);
		}else{
			$tid = $this->input->get('tid');
			if(!empty($tid)){
				$termdetail = $this->model('Payterm')->getTermByTid($tid);
				$this->assign('termdetail',$termdetail);
			}else{
				$crid = $this->input->get('crid');
				if(!empty($crid)){
					$crmodel = $this->model('classroom');
					$roomdetail = $crmodel->getclassroomdetail($crid);
					$this->assign('termdetail',$roomdetail);
				}
			}
			$this->display('admin/servicepack_add');
		}
	}
	/**
	*更新服务包
	*/
	public function edit(){
		$ppmodel = $this->model('Paypackage');
		if($this->input->post()){
			$user = Ebh::app()->user->getloginuser();
			$param['pid'] = intval($this->input->post('pid'));
			$param['pname'] = $this->input->post('pname');
			$param['crid'] = intval($this->input->post('crid'));
			$param['summary'] = $this->input->post('summary');
			
			$param['uid'] = $user['uid'];
			$param['displayorder'] = $this->input->post('displayorder');
			$limitchecked = $this->input->post('limitchecked');
			$limitdate = $this->input->post('limitdate');
			if(!empty($limitchecked))
				$param['limitdate'] = strtotime($limitdate);
			else
				$param['limitdate'] = 0;
			//更新对应缓存
			$packdetail = $ppmodel->getPackByPid($param['pid']);	//先取出原有数据，主要取出crid
			$res = $ppmodel->edit($param);
			$returnurl = '/admin/servicepack.html';
			if(isset($res)){
				$note[] = '确定并关闭';
				$rurl[] = '/admin/servicepack.html';
				$this->widget('sp_widget',array('note'=>$note,'returnurl'=>$rurl));
				//更新缓存
				$oldcrid = $packdetail['crid'];
				updateRoomCache($param['crid'],'paypackage');
				if($oldcrid != $param['crid']) {	//如果原始crid跟新的crid不同，则还需要更新原始的crid对应的缓存
					updateRoomCache($oldcrid,'paypackage');
				}
			}
			else
				$this->goback('添加失败!',$returnurl);
		}else{
			$pid = $this->input->get('pid');
			$packdetail = $ppmodel->getPackByPid($pid);
			$this->assign('packdetail',$packdetail);
			$this->display('admin/servicepack_edit');
		}
	}
	/*
	详情
	*/
	public function view(){
		$ppmodel = $this->model('Paypackage');
		$pid = $this->input->get('pid');
		$packdetail = $ppmodel->getPackByPid($pid);
		$this->assign('packdetail',$packdetail);
		$this->display('admin/servicepack_view');
	}
	
	public function changestatus(){
		$param['pid'] = $this->input->post('pid');
		$param['status']= $this->input->post('status');
		$pmodel = $this->model('paypackage');
		$result = $pmodel->edit($param);
		$crid = $this->input->post('crid');
		updateRoomCache($crid,'paypackage');
		if($result != false)
			echo 1;
	}
	
	/*
	搜索服务包页面
	*/
	public function servicepack_search(){
		$crid = $this->input->get('crid');
		$this->assign('currentcrid',$crid);
		$this->display('admin/servicepack_search');
	}
	
	
	public function goback($note="操作成功,正在努力跳转中...",$returnurl="/admin/servicepack.html"){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
}
?>