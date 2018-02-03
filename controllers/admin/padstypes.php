<?php
class PadstypesController extends AdminControl{
	public function index(){
		$padstypesModel = $this->model('padstypes');
		$padstypesList = $padstypesModel->getList();
		$padstypesListTree = $padstypesModel->getTreeListByUpid($padstypesList);
		$this->assign('padstypes',$padstypesListTree);
		$pselect = $padstypesModel->getSelect('name=upid');
		$this->assign('pselect',$pselect);
		$this->display('admin/padstypes');
	}

	public function add(){
		$padstypesModel = $this->model('padstypes');
		if($this->input->post()){
			$rec = $this->input->post();
			$param = $this->getParam($rec);
			$res = $padstypesModel->_insert($param);
			if($res===false){
				$this->note('操作失败!');
			}else{
				$this->note();
			}
		}else{
			$upid = $this->input->get('tid');
			$upid = is_null($upid)?-1:intval($upid);
			$pselect = $padstypesModel->getSelect('name=upid',$upid,true,false,true);
			$this->assign('pselect',$pselect);
			$this->display('admin/padstypes_add');
		}
		
	}

	public function edit(){
		$padstypesModel = $this->model('padstypes');
		if($this->input->post()){
			$rec = $this->input->post();
			if(is_null($rec['tid'])){
				return false;
			}else{
				$where = array('tid'=>intval($rec['tid']));
			}
			$param = $this->getParam($rec);
			$res = $padstypesModel->_update($param,$where);
			if($res===false){
				$this->note('操作失败!');
			}else{
				$this->note();
			}
		}else{
			$upid = $this->input->get('upid');
			$upid = is_null($upid)?-1:intval($upid);
			$pselect = $padstypesModel->getSelect('name=upid',$upid,true,false,true);
			$this->assign('pselect',$pselect);
			$tid = $this->input->get('tid');
			$oneCateInfo = $padstypesModel->getOneBytid(intval($tid));
			$this->assign('typeinfo',$oneCateInfo);
			$this->display('admin/padstypes_edit');
		}
	}

	/**
	 *获取完全表单提交数据，该数据字段完全对应数据库字段
	 */
	private function getParam($param = array()){
		$param = safeHtml($param);
		if($this->check($param)===true){
			$returnParam = array();
			$returnParam['upid'] = intval($param['upid']);
			$returnParam['code'] = $param['code'];
			$returnParam['name'] = $param['name'];
			$returnParam['templet'] = empty($param['templet'])?'default':$param['templet'];
			$returnParam['description'] = empty($param['description'])?'':$param['description'];
			$returnParam['displayorder'] = empty($param['displayorder'])?0:intval($param['displayorder']);
			$returnParam['system'] = empty($param['system'])?1:intval($param['system']);
			$returnParam['visible'] = empty($param['visible'])?1:intval($param['visible']);
			return $returnParam;
		}else{
			return false;
		}
	}
	/**
	 *删除文章
	 *
	 *
	 */
	public function delete(){
		$tid = $this->input->post('tid');
		if(empty($tid)){
			$this->note('参数有误!');
		}
		$padstypesModel = $this->model('padstypes');
		if(is_scalar($tid)){
			$res = $padstypesModel->_delete($tid);
		}else{
			$res = 0;
		}
		if($res==1){
			$this->note('删除成功!');
		}else{
			$this->note('该分类或者其子分类下面含有系统分类,删除失败!');
		}
	}

	/**
	 *检测code是否存在
	 *
	 */
	public function checkRepeatCode(){
		$code = $this->input->post('code');
		echo $this->model('padstypes')->ifCodeExist($code)?1:0;
	}
	/**
	 *批量排序
	 *@array param = array('tid1',displayorder1;'tid2',displayorder2,.....);
	 */
	public function sortopAll(){
		$param = $this->input->post('param');
		$param = rtrim($param,';');
		$whenAndThen = str_replace(array(';',','),array(' WHEN ',' THEN '), $param);
		preg_match_all("/WHEN\s(\d+)\sTHEN/is",$whenAndThen,$tids);
		$tids = $tids[1];
		$in = '('.implode(',',$tids).')';
		$sql = 'UPDATE ebh_padstypes SET displayorder = CASE tid '.$whenAndThen.' END WHERE tid in '.$in;
		$res = $this->model('padstypes')->_query($sql);
		if($res==1){
			$this->note('排序操作成功!');
		}else{
			$this->note('排序操作失败!');
		}
	}
	/**
	 *移动函数
	 */
	public function moveAll(){
		$rec = $this->input->post();
		$tids = explode(';',$rec['param']);
		array_pop($tids);
		$totid = intval($rec['category']);
		$type=$rec['tag'];
		$res = $this->model('padstypes')->_move($tids,$totid,$type);
		if($res===true){
			$this->note();
		}else{
			$this->note('操作失败!');
		}
	}
	/**
	*安检函数
	*/
	private function check($param = array()){
		return true;
	}

	private function note($note='操作成功!',$returnurl='/admin/padstypes.html'){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
}