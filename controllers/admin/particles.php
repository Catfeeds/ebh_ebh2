<?php
/**
 *文章控制器
 *
 */
class ParticlesController extends AdminControl{
	public function index(){
		$pcategoriesModel = $this->model('pcategories');
		$pselect = $pcategoriesModel->getSelect('name = catid');
		$pselect2 = $pcategoriesModel->getSelect('name = catid',-1,false,true);
		$this->assign('pselect2',$pselect2);
		$this->assign('pselect',$pselect);
		$this->display('admin/particles');
	}

	public function add(){
		if($this->input->post()){
			$rec = $this->input->post();
			$param = $this->getParam($rec);
			if($param===false){
				$this->note('操作失败!');
			}
			$res = $this->model('pitems')->_insert($param);
			if($res>0){
				$this->note();
			}else{
				$this->note('操作失败!');
			}
		}else{
			$pcategoriesModel = $this->model('pcategories');
			$pselect = $pcategoriesModel->getSelect('name = catid',-1,false,true);
			$this->assign('pselect',$pselect);
			$editor = Ebh::app()->lib('UMEditor');
		    $this->assign('editor',$editor);
		    $Upcontrol = Ebh::app()->lib('UpcontrolLib');
		    $this->assign('Upcontrol',$Upcontrol);
			$this->display('admin/particles_add');
		}
		
	}

	public function edit(){
		if($this->input->post()){
			$rec = $this->input->post();
			$param = $this->getParam($rec);
			$where = array('itemid'=>intval($rec['itemid']));
			$res = $this->model('pitems')->_update($param,$where);
			if($res>0){
				$this->note('修改成功!');
			}else{
				$this->note('修改失败!');
			}
		}else{
			$itemid = $this->input->get('itemid');
			$pitemsModel = $this->model('pitems');
			$item = $pitemsModel->getOneByItemid($itemid);
			$this->assign('item',$item);
			$pcategoriesModel = $this->model('pcategories');
			$pselect = $pcategoriesModel->getSelect('name = catid',$item['catid'],false,true);
			$this->assign('pselect',$pselect);
			$editor = Ebh::app()->lib('UMEditor');
		    $this->assign('editor',$editor);
		    $Upcontrol = Ebh::app()->lib('UpcontrolLib');
		    $this->assign('Upcontrol',$Upcontrol);
			$this->display('admin/particles_edit');
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
			$param['in'] = array_merge(array(intval($param['catid'])),$pcategoriesModel->getPosterity(intval($param['catid'])));
			unset($param['catid']);
		}
		$param['limit'] = $limit;
		$pitemsModel = $this->model('pitems');
		$resList = $pitemsModel->getList($param);
		$pitems = $this->insertRelationCate($resList);
		$total = $pitemsModel->getListCount($param);
	    array_unshift($pitems, array('total'=>$total));
	    echo json_encode($pitems);
	}
	/**
	 *获取完全表单提交数据，该数据字段完全对应数据库字段
	 */
	private function getParam($param = array()){
		$param = safeHtml($param,array('message'));
		if($this->check($param)===true){
			$returnParam = array();
			$returnParam['catid'] = intval($param['catid']);
			$returnParam['subject'] = empty($param['subject'])?'':$param['subject'];
			$returnParam['note'] = empty($param['note'])?'':$param['note'];
			$returnParam['message'] = empty($param['message'])?'':$param['message'];
			$returnParam['source'] = empty($param['source'])?'':$param['source'];
			$returnParam['itemurl'] = empty($param['itemurl'])?'':$param['itemurl'];
			$returnParam['thumb'] = empty($param['thumb']['upfilepath'])?'':$param['thumb']['upfilepath'];
			$userinfo = EBH::app()->user->getloginuser();
			$returnParam['uid'] = intval($userinfo['uid']);
			$returnParam['author'] = empty($param['author'])?'神秘人':$param['author'];
			$param['dateline'] = empty($param['dateline'])?time():$param['dateline'];
			$returnParam['dateline'] = strtotime($param['dateline']);
			$returnParam['lastpost'] = time();
			$returnParam['tag'] = empty($param['tag'])?'':$param['tag'];
			// $returnParam['viewnum'] = intval($param['viewnum']);
			// $returnParam['sharenum'] = intval($param['sharenum']);
			$param['top'] = empty($param['top'])?0:$param['top'];
			$param['hot'] = empty($param['hot'])?0:$param['hot'];
			$param['best'] = empty($param['best'])?0:$param['best'];
			$returnParam['top'] = intval($param['top']);
			$returnParam['hot'] = intval($param['hot']);
			$returnParam['best'] = intval($param['best']);
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
		$itemid = $this->input->post('itemid');
		$res = $this->model('pitems')->_delete(intval($itemid));
		if($res>0){
			$ajaxReturn['success'] = true; 
		}else{
			$ajaxReturn['success'] = false;
		}
		echo json_encode($ajaxReturn);
	}

	/**
	 *批量删除
	 *
	 */
	public function deleteAll(){
		$rec = $this->input->post();
		$param = $rec['param'];
		$pitemsModel = $this->model('pitems');
		$param = ltrim($param,';');
		$in = '('.str_replace(';',',',$param).')';
		$res = $pitemsModel->_delete($in);
		if($res>0){
			echo 1;
		}else{
			echo 0;
		}
			
	}

	/**
	 *改变best,top,hot的级别
	 *
	 */
	public function bth(){
		$rec = $this->input->post();
		$bth = $rec['bth'];
		if(!in_array($bth,array('best','top','hot'))){
			echo 0;exit;
		}
		$items = str_replace(';',',',ltrim($rec['param'],';'));
		$in = '('.$items.')';
		$level = intval($rec['level']);
		$param = array($bth=>$level,'lastpost'=>time());
		$where = ' itemid in '.$in;
		echo $this->model('pitems')->_update($param,$where);
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
		$items = str_replace(';',',',ltrim($rec['param'],';'));
		$in = '('.$items.')';
		$param = array('status'=>$status,'lastpost'=>time());
		$where = ' itemid in '.$in;
		echo $this->model('pitems')->_update($param,$where);
	}
	/**
	 *批量移动文章到指定的栏目下面
	 *
	 */
	public function movecategoryAll(){
		$rec = $this->input->post();
		$items = str_replace(';',',',ltrim($rec['param'],';'));
		$in = '('.$items.')';
		$targetCate = intval($rec['targetCate']);
		$param = array('catid'=>$targetCate,'lastpost'=>time());
		$where = ' itemid in '.$in;
		echo $this->model('pitems')->_update($param,$where);
	}

	/**
	 *批量排序
	 *@array param = array('catid1',displayorder1;'catid2',displayorder2,.....);
	 */
	public function sortopAll(){
		$param = $this->input->post('param');
		$param = rtrim($param,';');
		$whenAndThen = str_replace(array(';',','),array(' WHEN ',' THEN '), $param);
		preg_match_all("/WHEN\s(\d+)\sTHEN/is",$whenAndThen,$itemids);
		$itemids = $itemids[1];
		$in = '('.implode(',',$itemids).')';
		$sql = 'UPDATE ebh_pitems SET lastpost = '.time().', displayorder = CASE itemid '.$whenAndThen.' END WHERE itemid in '.$in;
		echo $this->model('pitems')->_query($sql);
	}

	private function insertRelationCate($items = array()){
		$newItems = array();
		$pcategoriesModel = $this->model('pcategories');
		$cates = $pcategoriesModel->getSimpleList();
		foreach ($items as $item) {
			$AncestorChain = $this->getRelationCate($item['catid'],$item['upid'],$cates,$pcategoriesModel,$item['name']);
			$item['name'] = $AncestorChain;
			$newItems[] = $item;
		}
		return $newItems;
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
		if($catidInfo){
			if($catidInfo['upid']==0){
				$info[] = '不能选择顶级栏目!';
				$info['status'] = false;
			}
		}else{
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

	private function note($note='操作成功!',$returnurl='/admin/particles.html'){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}

	public function push(){
		$rec = $this->input->post();
		$itemid = intval($rec['itemid']);
		$pitemsModel = $this->model('pitems');
		$itemsModel = $this->model('item');
		$article  =  $pitemsModel->getOneByItemid($itemid);
		if(empty($article)){
			echo 0;exit;
		}
		$crids = trim($rec['crids'],';');
		$cridArr = explode(';',$crids);
		$param = array();
		$param['subject'] = $article['subject'];
		$param['note'] = $article['note'];
		$param['message'] = stripslashes($article['message']);
		$param['thumb'] = $article['thumb'];
		$param['catid'] = 686;
		$param['dateline'] = time();
		$param['lastpost'] = time();
		$param['folder'] = 1;
		$param['crid'] = "";
		foreach ($cridArr as $ckey => $cvalue) {
			$param['crid'] = intval($cvalue);
			$itemsModel->addone($param);
		}
		echo 1;
	}
}