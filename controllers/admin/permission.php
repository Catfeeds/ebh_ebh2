<?php
class PermissionController extends AdminControl{
	
	public function index(){
		$this->getlist(1);
		$this->display('admin/permission');
	}
	public function getlist($init=0){
		$permission = $this->model('permission');
		$pagination = $this->input->get('param');
		$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
		$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
		$pagination['total'] = $permission -> getgroupcount($pagination);
		$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
		$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
		$grouplist = $permission -> getgrouplist($pagination);
		
		if(!$init){
			$grouplist[] = $pagination;
			echo json_encode($grouplist);
		}
		else{
			$this->assign('grouplist',json_encode($grouplist));
			$this->assign('pagination',$pagination);
			$this->assign('ctrl','permission');
		}
	}
	/*
	添加组
	*/
	public function addgroup(){
		$permission = $this->model('permission');
		$param = $this->input->post();
		$res = $permission->addgroup($param);
		if($res)
		echo 1;
	}
	/*
	编辑组
	*/
	public function editgroup(){
		$permission = $this->model('permission');
		$param = $this->input->post();
		echo $permission->editgroup($param);
		
	}
	/*
	删除组
	*/
	public function deletegroup(){
		$permission = $this->model('permission');
		$groupid = $this->input->post('groupid');
		echo json_encode(array('success'=>$permission->deletegroup($groupid)));
	}
	
	public function edit(){
		$permission = $this->model('permission');
		if($this->input->post()){
			$param = $this->input->post('opvalue');
			$groupid = $this->input->post('groupid');
			echo $permission->editpermission($param,$groupid);
		}
		else{
			$groupid = $this->input->get('groupid');
			$this->assign('groupid',$groupid);
			$type = $permission->getgrouptype($groupid);
			// if ($type == 'staff') {
				// $opflag = '_editsys';
			// } else {
				// $opflag = '_edituser';
			// }
			$param['type'] = $type;
			$param['groupid'] = $groupid;
			$operationlist = $permission->getoperationlist($type);
			$permissionlist = $permission->getpermissionlist($param);
			
			$this->assign('operationlist',$operationlist);
			$this->assign('permissionlist',$permissionlist);
			$this->display('admin/permission_edit');
		}
	}
}
?>