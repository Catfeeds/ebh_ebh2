<?php
	class SpecialController extends AdminControl{
		public function index(){
			$this->display('admin/special');
		}

		public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?1:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit']=$offset.','.$pageSize;
			$SpecialModel = $this->model('special');
			$total = $SpecialModel->getCount($queryArr);
			$SpecialList = $SpecialModel->getList($queryArr);
			array_unshift($SpecialList,array('total'=>intval($total)));
			echo json_encode($SpecialList);
		}
		//增加，编辑视图
		public function add(){
			if($this->input->get('op')=='edit'){
				$this->assign('op','edit');
				$oneSpecial = $this->model('special')->getOneSpecialBySid($this->input->get('sid'));
				$this->assign('s',$oneSpecial);
			}else{
				$this->assign('op','add');
			}
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->assign('token',createToken());
			$this->display('admin/special_add');
		}
		public function op(){
			$param = safeHtml($this->input->post());
			if($this->chekParam($param)!==true){
				exit();
			}
			if(!in_array($param['op'],array('add','edit'))){
				$this->widget('note_widget',array('note'=>'操作数错误!','returnurl'=>'/admin/special/add.html'));
				exit();
			}
			if($this->model('special')->op($param)!==false){
				if(isset($param['nextsubmit'])){
					$this->widget('note_widget',array('note'=>'操作成功!','returnurl'=>'/admin/special/add.html'));
					exit();
				}else{
					$this->widget('note_widget',array('note'=>'操作成功!','returnurl'=>'/admin/special.html'));
					exit();
				}
			}
		}
		public function del(){
			$sid = intval($this->input->post('sid'));
			if($this->model('special')->del($sid)!==false){
				echo 1;
			}else{
				echo 0;
			}
		}
		public function detail(){
			$sid = intval($this->input->get('sid'));
			if($sid<0){
				$this->widget('note_widget',array('note'=>'参数有误!','returnurl'=>'/admin/special.html'));
					exit();
			}else{
				$oneSpecial = $this->model('special')->getOneSpecialBySid($sid);
				$this->assign('s',$oneSpecial);
				$this->display('admin/special_detail');
			}
		}
		private function chekParam($param){
			$message = array();
			$message['code'] = true;
			if(checkToken($param['token'])===false){
				$message[] = '请勿重复提交!';
				$message['code'] = false;
			}
			if(empty($param['catid'])){
				$message[] = '专题分类为空!';
				$message['code'] = false;
			}else{
				if($this->model('category')->existCat(intval($param['catid']))===false){
					$message[]='专题分类不存在,非法操作!';
					$message['code'] = false;
				}
			}
			if(empty($param['title'])){
				$message[] = '专题标题为空!';
				$message['code'] = false;
			}
			if(strlen($param['urlrule'])<2||strlen($param['urlrule'])>50){
				$message[] = '专题长度不对!';
				$message['code'] = false;
			}

			if($message['code']===false){
				$info = implode('<br />',$message);
				$this->widget('note_widget',array('note'=>$info,'returnurl'=>'/admin/special.html'));
				exit;
			}else{
				return true;
			}

		}
	}