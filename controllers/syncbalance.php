<?php
/**
 * 批量同步用户账户余额
 */
class SyncbalanceController extends CControl {
	public function index() {
		echo 'usage:/syncbalance/initbalance.html';
	}
	/**
	 * 同步处理
	 */
	public function initbalance(){
		$page = 1;
		$pagesize = 1000;
		$cashbackModel = $this->model('Cashback');
		$nowtime = SYSTIME;
		$difftime = 15 * 24 * 3600;
		while(1){
			$cparam['difftime'] = $difftime;
			$cparam['nowtime'] = $nowtime;
			$cparam['limit'] = ($page - 1) * $pagesize.', '.$pagesize;
			$cashbacklist = $cashbackModel->getunrecorded($cparam);
			if(empty($cashbacklist)){
				echo 'sync end...';
				exit;
			}
			foreach ($cashbacklist as $item){
				$param['id'] = $item['id'];
				$param['uid'] = $item['uid'];
				$param['money'] = $item['totalreward'];
				$param['status'] = 1;
				$param['synctime'] = $nowtime;
				$result = $cashbackModel->updatestate($param);
				if(!$result){
					log_message('uid:'.$param['uid'].'，同步入账失败，入账金额：'.$param['money']);
				}
			}
			$page++;
		}
	}
}