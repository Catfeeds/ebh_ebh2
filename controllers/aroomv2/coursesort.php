<?php 
/*
课程服务包,分类
*/
class CoursesortController extends CControl{
	
	public function __construct(){
		parent::__construct();
        Ebh::app()->room->checkRoomControl();
	}
	
	public function index(){
		$this->display('aroomv2/course_sort');
	}
	
	public function getSplist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$spmodel = $this->model('Paypackage');
		$sortmodel = $this->model('Paysort');
		$load_unsorted = intval($this->input->get('loadu'));
		$splist = $spmodel->getsimplesplist(array('crid'=>$roominfo['crid'],'limit'=>1000,'status'=>1,'displayorder'=>'itype asc,displayorder asc,pid desc'));
		$pids = implode(',',array_column($splist,'pid'));
		// var_dump($pids);
		$showbysort = $this->input->post('showbysort');
		$sortparam = array('pids'=>$pids,'order'=>'sdisplayorder asc');
		if($showbysort != NULL)
			$sortparam['showbysort'] = $showbysort;
		$sortlist = $sortmodel->getSortsByPids($sortparam);
		if (!empty($load_unsorted)) {
            $other_sortlist = $this->model('Payitem')->getNoSortItemIdArr($roominfo['crid']);
            if (!empty($other_sortlist)) {
                $sortlist = array_merge($sortlist, $other_sortlist);
            }
        }
		echo json_encode(array('splist'=>$splist,'sortlist'=>$sortlist));
	}
	
	/*
	保存服务包,分类的名称
	*/
	public function savename(){
		$param = $this->input->post();
		$this->checkpost($param,array('type','value','pid','name'));
		$roominfo = Ebh::app()->room->getcurroom();
		if($param['type'] == 'sp'){
			$this->model('Paypackage')->edit(array('pid'=>$param['pid'],'pname'=>$param['name']));
			updateRoomCache($roominfo['crid'],'paypackage');
		}elseif($param['type'] == 'sort'){
			$this->model('Paysort')->edit(array('pid'=>$param['pid'],'sname'=>$param['name'],'sid'=>$param['value']));
		}
	}
	
	/*
	添加
	*/
	public function additem(){
		$param = $this->input->post();
		$this->checkpost($param,array('type','pid','name'),array('pid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getLoginuser();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		if($param['type'] == 'sp')
			$id = $this->addsp($param);
		elseif($param['type'] == 'sort')
			$id = $this->addsort($param);
		if(!empty($id))
			echo json_encode(array('success'=>true,'id'=>$id));
	}
	
	/*
	添加分类
	*/
	private function addsort($param){
		$sarr['pid'] = $param['pid'];
		$sarr['sname'] = $param['name'];
		$sortmodel = $this->model('Paysort');
		$sdisplayorder = $sortmodel->getCurdisplayorder(array('crid'=>$param['crid'],'pid'=>$param['pid']));
		$sarr['sdisplayorder'] = $sdisplayorder == NULL ? 0 : $sdisplayorder+1;
		$sid = $sortmodel->add($sarr);
		return $sid;
	}
	
	/*
	添加服务包
	*/
	private function addsp($param){
		$sparr['pname'] = $param['name'];
		$sparr['crid'] = $param['crid'];
		$sparr['uid'] = $param['uid'];
		$sparr['displayorder'] = SYSTIME;
		$spmodel = $this->model('Paypackage');
		$displayorder = $spmodel->getCurdisplayorder(array('crid'=>$param['crid']));
		
		$sparr['displayorder'] = $displayorder == NULL ? 0 : $displayorder+1;
		
		$pid = $spmodel->add($sparr);
		updateRoomCache($param['crid'],'paypackage');
		return $pid;
	}
	
	/*
	删除服务包，分类
	*/
	public function deleteitem(){
		$param = $this->input->post();
		$this->checkpost($param,array('type','value','pid'));
		$roominfo = Ebh::app()->room->getcurroom();
		if($param['type'] == 'sp'){//删除服务包
			$spmodel = $this->model('Paypackage');
			$delarr = array('crid'=>$roominfo['crid'],'pid'=>$param['pid']);
			$res = $spmodel->hasCheck($delarr);
			if(empty($res['pid'])){
				$msg = '删除失败,该分类已不存在';
				$status = false;
			}elseif($res['itemcount']>0){
				$msg = '该分类下还有课程,不能删除';
				$status = false;
			}else{
				$spmodel->deletepack($param['pid']);
				updateRoomCache($roominfo['crid'],'paypackage');
				$spmodel->deletesort($param['pid']);
				$msg = '删除成功';
				$status = true;
			}
		}elseif($param['type'] == 'sort'){//删除分类
			$sortmodel = $this->model('Paysort');
			$delarr = array('crid'=>$roominfo['crid'],'pid'=>$param['pid'],'sid'=>$param['value']);
			$res = $sortmodel->hasCheck($delarr);
			if(empty($res)){
				$msg = '删除失败,该分类已不存在';
				$status = false;
			}else{
				$sortmodel->del($param['value']);
				$sortmodel->setItemSidToZero($param['value']);
				$msg = '删除成功';
				$status = true;
			}
		}
		
		echo json_encode(array('success'=>$status,'msg'=>$msg));
		
	}
	
	public function checksort(){
		$sid = $this->input->post('sid');
		$delarr = array('sid'=>$sid);
		$count = $this->model('Paysort')->getItemCount($delarr);
		echo $count;
	}
	
	private function checkpost($param,$needarr,$except = array()){
		// $needarr = array('type','value','pid','name');
		foreach($param as $k=>$pvalue){
			if((empty($pvalue) || !in_array($k,$needarr)) && !(!empty($except) && in_array($k,$except))){
				echo '操作失败,参数不正确';
				exit;
			}
		}
	}
	/**
     * 更改服务包的排序
     */
	public function ajax_change_package_order() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $pid = intval($this->input->post('pid'));
        $is_increase = intval($this->input->post('is_increase'));
        $ret = $this->model('Paypackage')->changeOrder($pid, $roominfo['crid'], $is_increase);
        if ($ret) {
            echo json_encode(array(
                'errno' => 0
            ));
            exit();
        }

        echo json_encode(array(
            'errno' => 100,
            'msg' => '操作失败或未操作'
        ));
        exit();
    }

    /**
     * 更改服务包下分类的排序
     */
    public function ajax_change_sort_order() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $pid = intval($this->input->post('pid'));
        $sid = intval($this->input->post('sid'));
        $is_increase = intval($this->input->post('is_increase'));
        $ret = $this->model('Paysort')->changeOrder($sid, $pid, $is_increase);
        if ($ret) {
            echo json_encode(array(
                'errno' => 0
            ));
            exit();
        }

        echo json_encode(array(
            'errno' => 100,
            'msg' => '操作失败或未操作'
        ));
        exit();
    }
}
	