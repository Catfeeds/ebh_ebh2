<?php
	class PcategoriesController extends AdminControl{
		public function index(){
			$pcategoriesModel = $this->model('pcategories');
			$pcategoriesList = $pcategoriesModel->getList();
			$pcategoriesListTree = $pcategoriesModel->getTreeListByUpid($pcategoriesList);
			$this->assign('pcategoriesList',$pcategoriesListTree);
			$pselect = $pcategoriesModel->getSelect('name=upid');
			$this->assign('pselect',$pselect);
			$this->display('admin/pcategories');
		}

		public function add(){
			$pcategoriesModel = $this->model('pcategories');
			if($this->input->post()){
				$rec = $this->input->post();
				$param = $this->getParam($rec);
				$res = $pcategoriesModel->_insert($param);
				if($res===false){
					$this->note('操作失败!');
				}else{
					$this->note();
				}
			}else{
				$upid = $this->input->get('catid');
				$upid = is_null($upid)?-1:intval($upid);
				$pselect = $pcategoriesModel->getSelect('name=upid',$upid);
				$this->assign('pselect',$pselect);
				$this->display('admin/pcategories_add');
			}
			
		}

		public function edit(){
			$pcategoriesModel = $this->model('pcategories');
			if($this->input->post()){
				$rec = $this->input->post();
				if(is_null($rec['catid'])){
					return false;
				}else{
					$where = array('catid'=>intval($rec['catid']));
				}
				$param = $this->getParam($rec);
				$res = $pcategoriesModel->_update($param,$where);
				if($res===false){
					$this->note('操作失败!');
				}else{
					$this->note();
				}
			}else{
				$upid = $this->input->get('upid');
				$upid = is_null($upid)?-1:intval($upid);
				$pselect = $pcategoriesModel->getSelect('name=upid',$upid);
				$this->assign('pselect',$pselect);
				$catid = $this->input->get('catid');
				$oneCateInfo = $pcategoriesModel->getOneByCatid(intval($catid));
				$this->assign('catinfo',$oneCateInfo);
				$this->display('admin/pcategories_edit');
			}
		}

		/**
		 *获取完全表单提交数据，该数据字段完全对应数据库字段
		 */
		private function getParam($param = array()){
			if($this->check($param)===true){
				$returnParam = array();
				$returnParam['upid'] = $param['upid'];
				$returnParam['code'] = $param['code'];
				$returnParam['name'] = $param['name'];
				$returnParam['keyword'] = $param['keyword'];
				$returnParam['description'] = $param['description'];
				$returnParam['displayorder'] = $param['displayorder'];
				$returnParam['caturl'] = $param['caturl'];
				$returnParam['target'] = $param['target'];
				$returnParam['system'] = $param['system'];
				$returnParam['visible'] = $param['visible'];
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
			$catid = $this->input->post('catid');
			if(empty($catid)){
				$this->note('参数有误!');
			}
			$pcategoriesModel = $this->model('pcategories');
			if(is_scalar($catid)){
				$res = $pcategoriesModel->_delete($catid);
			}else{
				$res = 0;
			}
			if($res==1){
				$this->note('删除成功!');
			}else{
				$this->note('删除失败!');
			}
		}

		/**
		 *检测code是否存在
		 *
		 */
		public function checkRepeatCode(){
			$code = $this->input->post('code');
			echo $this->model('pcategories')->ifCodeExist($code)?1:0;
		}
		/**
		 *批量排序
		 *@array param = array('catid1',displayorder1;'catid2',displayorder2,.....);
		 */
		public function sortopAll(){
			$param = $this->input->post('param');
			$param = rtrim($param,';');
			$whenAndThen = str_replace(array(';',','),array(' WHEN ',' THEN '), $param);
			preg_match_all("/WHEN\s(\d+)\sTHEN/is",$whenAndThen,$catids);
			$catids = $catids[1];
			$in = '('.implode(',',$catids).')';
			$sql = 'UPDATE ebh_pcategories SET displayorder = CASE catid '.$whenAndThen.' END WHERE catid in '.$in;
			$res = $this->model('pcategories')->_query($sql);
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
			$catids = explode(';',$rec['param']);
			array_pop($catids);
			$tocatid = intval($rec['category']);
			$type=$rec['tag'];
			$res = $this->model('pcategories')->_move($catids,$tocatid,$type);
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

		private function note($note='操作成功!',$returnurl='/admin/pcategories.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}
	}