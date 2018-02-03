<?php
	/**
	 *后台用户组权限中的操作管理模块控制器
	 *@author zkq
	 */
	class OperationController extends AdminControl{
		/**
		 *列表页视图
		 */
		public function index(){
			$OPList = $this->model('operation')->getList(); 
			$this->assign('opList',$OPList);
			$this->display('admin/operation');
		}
		/**
		 *新增页面,编辑页面视图
		 */
		public function add(){
			$opid = intval($this->input->get('opid'));
			$this->assign('token',createToken());
			if(!empty($opid)){
				$this->assign('op','edit');
				$oneinfo = $this->model('operation')->getOne($opid);
				$hashbt = $oneinfo['opid'].'edit';//用于生成hash值的种子
				$this->assign('formhash',formhash($hashbt));
				$this->assign('p',$oneinfo);
			}else{
				$this->assign('formhash',formhash('add'));
				$this->assign('op','add');
			}
			
			$this->display('admin/operation_add');
		}
		/**
		 *operation小挂件获取数据方法,返回数据供operation_widget挂件使用
		 *
		 */
		public function getOpSimpleList(){
			$in = $this->input->post('position');//'1,2'字符串格式
			$operationList = $this->model('operation')->getSimpleList($in);
			$opvalue = $this->input->post('opvalue');
			if(!is_array($operationList)){
				return false;
			}else{
				$res = '';
				foreach ($operationList as $v) {
					if($this->ispower($opvalue,$v['opid'])===true){
						$res.='<input type="checkbox" name="opvalue[]" checked=checked value="'.$v['opid'].'" ><span>'.$v['opid'].'</span>'.$v['opname'].'<br>';
					}else{
						$res.='<input type="checkbox" name="opvalue[]" value="'.$v['opid'].'" ><span>'.$v['opid'].'</span>'.$v['opname'].'<br>';
					}
					
				}
			}
		echo $res;
		}
		
		/**
		 *判断对应的opvalue是否有权限,operation小挂件辅助函数
		 */
		public 	function ispower($power,$right) {
			//权限比较时，进行与操作，得到0的话，表示没有权限
			if ((intval($power) & intval ( $right )) == 0)
				return false;
			return true;
		}
		/**
		 *新增操作,编辑操作处理函数
		 */
		public function handle(){
			$rec = safeHtml($this->input->post());
			$this->check($rec);
			$rec['position']=array_sum($rec['opvalue']);
			if($rec['op']=='edit'){
				if(formhash($rec['opid'].'edit')!=$rec['formhash']){
					$this->goback('参数被篡改!');
				}
				if($this->model('operation')->_update($rec,array('opid'=>intval($rec['opid'])))===false){
					$this->goback('修改失败!');
				}else{
					$this->goback();
				}
			}else{
				if($this->model('operation')->_insert($rec)===true){
					$this->goback();
				}else{
					$this->goback('eb_operation表中opid字段溢出,新增失败!');
				}
			}

		}
		/**
		 *操作成功或者失败时的跳转函数,美观
		 */
		public function goback($note='操作成功!',$returnurl='/admin/operation.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}
		/**
		 *编辑和新增操作时对前台页面传过来的值进行判断,确保用户提交的数据完全的安全
		 **/
		public function check($param = array()){
			if(checkToken($param['token'])===false){
				$this->goback('请勿重复提交!');
			}
			$message = array();
			$message['code'] = true;
			if(empty($param['opcode'])){
				$message[]='操作标识为空!';
				$message['code']=false;
			}else{
				if(preg_match("/^[a-zA-Z]{1,20}$/",$param['opcode'])==0){
					$message[]='操作标识必须为长度为1-20的英文!';
					$message['code']=false;
				}
			}
			if(empty($param['opname'])){
				$message[]='操作名称为空!';
				$message['code']=false;
			}else{
				if(strlen($param['opname'])<1||strlen($param['opname'])>20){
					$message[]='操作标识必须长度为1-20!';
					$message['code']=false;
				}
			}
			if(!isset($param['iscredit'])){
				$message[]='积分操作为空!';
				$message['code']=false;
			}
			if(!in_array($param['iscredit'],array(0,1,2))){
				$message[]='积分操作被篡改!';
				$message['code']=false;
			}
			$opvalueArr = array(1,2,4);
			if(!isset($param['opvalue'])||!is_array($param['opvalue'])){
				$message[]='适用位置为空!';
				$message['code']=false;
			}else{
				foreach ($param['opvalue'] as $ov) {
					if(!in_array($ov,$opvalueArr)){
						$message[]='适用位置被篡改!';
						$message['code']=false;
						break;					
					}
				}

			}

			if($message['code']===false){
				$this->goback(implode('<br />',$message));
			}
		}

	}
?>