<?php
/**
 *广告控制器
 *
 */
class PadsController extends AdminControl{
	public function index(){
		$pcategoriesModel = $this->model('pcategories');
		$padstypesModel = $this->model('padstypes');
		$pselect = $pcategoriesModel->getSelect('name = catid');
		$pselect2 = $padstypesModel->getSelect('name = tid',-1);
		$pselect3 = $pcategoriesModel->getSelect('name = catid',-1,false,false);
		$this->assign('pselect3',$pselect3);
		$this->assign('pselect2',$pselect2);
		$this->assign('pselect',$pselect);
		$this->display('admin/pads');
	}

	public function add(){
		if($this->input->post()){
			$rec = $this->input->post();
			$param = $this->getParam($rec);
			if($param===false){
				$this->note('操作失败!');
			}
			$res = $this->model('pads')->_insert($param);
			if($res>0){
				$this->note();
			}else{
				$this->note('操作失败!');
			}
		}else{
			$pcategoriesModel = $this->model('pcategories');
			$pcateselect = $pcategoriesModel->getSelect('name = catid',-1,false);
			$this->assign('pcateselect',$pcateselect);
			$padstypesModel = $this->model('padstypes');
			$ptypeselect = $padstypesModel->getSelect('name = tid',-1,false);
			$this->assign('ptypeselect',$ptypeselect);
			$editor = Ebh::app()->lib('UMEditor');
		    $this->assign('editor',$editor);
		    $Upcontrol = Ebh::app()->lib('UpcontrolLib');
		    $this->assign('Upcontrol',$Upcontrol);
			$this->display('admin/pads_add');
		}
		
	}

	public function edit(){
		if($this->input->post()){
			$rec = $this->input->post();
			$param = $this->getParam($rec);
			$where = array('aid'=>intval($rec['aid']));
			$res = $this->model('pads')->_update($param,$where);
			if($res>0){
				$this->note('修改成功!');
			}else{
				$this->note('修改失败!');
			}
		}else{
			$aid = $this->input->get('aid');
			$padsModel = $this->model('pads');
			$ad = $padsModel->getOneByaid($aid);
			$this->assign('ad',$ad);
			$pcategoriesModel = $this->model('pcategories');
			$pcateselect = $pcategoriesModel->getSelect('name = catid',$ad['catid'],false);
			$this->assign('pcateselect',$pcateselect);
			$padstypesModel = $this->model('padstypes');
			$ptypeselect = $padstypesModel->getSelect('name = tid',$ad['tid'],false);
			$this->assign('ptypeselect',$ptypeselect);
			$editor = Ebh::app()->lib('UMEditor');
		    $this->assign('editor',$editor);
		    $Upcontrol = Ebh::app()->lib('UpcontrolLib');
		    $this->assign('Upcontrol',$Upcontrol);
			$this->display('admin/pads_edit');
		}
		
	}


	public function getListAjax(){
		$param = $this->input->post();
		$pageSize = $param['pageSize'];
		$pageNumber = $param['pageNumber'];
		$offset = max(0,($pageNumber-1)*$pageSize);
		$limit = $offset.','.$pageSize;
		parse_str($param['query'],$param);
		if(!empty($param['catid'])){
			$pcategoriesModel = $this->model('pcategories');
			$param['in_catid'] = array_merge(array(intval($param['catid'])),$pcategoriesModel->getPosterity(intval($param['catid'])));
			unset($param['catid']);
		}
		if(!empty($param['tid'])){
			$padtypesModel = $this->model('padstypes');
			$param['in_tid'] = array_merge(array(intval($param['tid'])),$padtypesModel->getPosterity(intval($param['tid'])));
			unset($param['tid']);
		}
		$param['limit'] = $limit;
		$padsModel = $this->model('pads');
		$resList = $padsModel->getList($param);
		$pads = $this->insertRelationCate($resList);
		$total = $padsModel->getListCount($param);
	    array_unshift($pads, array('total'=>$total));
	    echo json_encode($pads);
	}
	/**
	 *获取完全表单提交数据，该数据字段完全对应数据库字段
	 */
	private function getParam($param = array()){
		$param = safeHtml($param,array('message'));
		if($this->check($param)===true){
			$returnParam = array();
			$returnParam['catid'] = intval($param['catid']);
			$returnParam['tid'] = intval($param['tid']);
			$returnParam['subject'] = empty($param['subject'])?'':$param['subject'];
			$returnParam['message'] = empty($param['message'])?'':$param['message'];
			$returnParam['linkurl'] = empty($param['linkurl'])?'':$param['linkurl'];
			$returnParam['thumb'] = empty($param['thumb']['upfilepath'])?'':$param['thumb']['upfilepath'];
			$userinfo = EBH::app()->user->getloginuser();
			$returnParam['uid'] = intval($userinfo['uid']);
			$returnParam['openuser'] = empty($param['openuser'])?'神秘人':$param['openuser'];
			$returnParam['dateline'] = time();
			$returnParam['lastpost'] = time();
			$returnParam['begintime'] = strtotime($param['begintime']);
			$returnParam['endtime'] = strtotime($param['endtime']);
			$param['status'] = empty($param['status'])?2:$param['status'];
			$returnParam['status'] = intval($param['status']);
			$param['displayorder'] = empty($param['displayorder'])?0:$param['displayorder'];
			$returnParam['displayorder'] = intval($param['displayorder']);
			return $returnParam;
		}else{
			return false;
		}
	}

	/**
	 *删除一条记录
	 *
	 */
	public function delete(){
		$ajaxReturn = array();
		$aid = $this->input->post('aid');
		$res = $this->model('pads')->_delete(intval($aid));
		if($res>0){
			echo 1;
		}else{
			echo 0;
		}
	}

	/**
	 *批量删除
	 *
	 */
	public function deleteAll(){
		$rec = $this->input->post();
		$param = $rec['param'];
		$padsModel = $this->model('pads');
		$param = ltrim($param,';');
		$in = '('.str_replace(';',',',$param).')';
		echo $padsModel->_delete($in);
		
	}

	
	/**
	 *批量改变状态
	 */
	public function changeStatus(){
		$rec = $this->input->post();
		$status = intval($rec['status']);
		if(!in_array($status,array(1,2))){
			echo 0;exit;
		}
		$ads = str_replace(';',',',ltrim($rec['param'],';'));
		$in = '('.$ads.')';
		$param = array('status'=>$status,'lastpost'=>time());
		$where = ' aid in '.$in;
		echo $this->model('pads')->_update($param,$where);
	}
	/**
	 *批量移动文章到指定的栏目下面
	 *
	 */
	public function movecategoryAll(){
		$rec = $this->input->post();
		$ads = str_replace(';',',',ltrim($rec['param'],';'));
		$in = '('.$ads.')';
		$targetCate = intval($rec['targetCate']);
		$param = array('catid'=>$targetCate,'lastpost'=>time());
		$where = ' aid in '.$in;
		echo $this->model('pads')->_update($param,$where);
	}

	/**
	 *批量排序
	 *@array param = array('catid1',displayorder1;'catid2',displayorder2,.....);
	 */
	public function sortopAll(){
		$param = $this->input->post('param');
		$param = rtrim($param,';');
		$whenAndThen = str_replace(array(';',','),array(' WHEN ',' THEN '), $param);
		preg_match_all("/WHEN\s(\d+)\sTHEN/is",$whenAndThen,$aids);
		$aids = $aids[1];
		$in = '('.implode(',',$aids).')';
		$sql = 'UPDATE ebh_pads SET lastpost = '.time().', displayorder = CASE aid '.$whenAndThen.' END WHERE aid in '.$in;
		echo $this->model('pads')->_query($sql);
	}

	private function insertRelationCate($ads = array()){
		$newAds = array();
		$pcategoriesModel = $this->model('pcategories');
		$cates = $pcategoriesModel->getSimpleList();
		foreach ($ads as $ad) {
			$AncestorChain = $this->getRelationCate($ad['catid'],$ad['cateupid'],$cates,$pcategoriesModel,$ad['catename']);
			$ad['catename'] = $AncestorChain;
			$newAds[] = $ad;
		}
		return $newAds;
	}
	/**
	 *获取分类关联树目录
	 *类似于 栏目1>>栏目2>>栏目3 结构
	 *
	 */
	private function getRelationCate($catid,$upid,$cates,$pcategoriesModel,$name){
		$ancestorChain = $pcategoriesModel->getAncestorChain($catid,$cates,$upid,$name,'>>');
		return $ancestorChain;
	}

	/**
	*安检函数
	*/
	private function check($param = array()){
		$info = array();
		$info['status'] = true;
		$pcategoriesModel = $this->model('pcategories');
		$catidInfo = $pcategoriesModel->getOneByCatid($param['catid']);
		if(!$catidInfo){
			$info[] = '栏目不存在!';
			$info['status'] = false;
		}
		$subjectlength = mb_strlen($param['subject'],'UTF8');
		if(($subjectlength >200)||($subjectlength <4)){
			$info[] = '标题长度不对!';
			$info['status'] = false;
		}
		/***其它验证待增加***/
		if($info['status']===true){
			return true;
		}else{
			$message = implode('<br />', $info);
			$this->note($message);
		}
		

	}

	private function note($note='操作成功!',$returnurl='/admin/pads.html'){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
}