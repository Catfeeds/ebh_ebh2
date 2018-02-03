<?php	
class ReviewsController extends PortalControl{
	public function addOneReview(){
		$rec = $this->input->post();
		$param = $this->_getPram($rec);
		if(is_array($param)){
			$res1 = $this->model('previews')->_insert($param);
			$res2 = $this->model('pitems')->incReviewNum($param['itemid']);
			if(($res1>0)&&($res2>0)){
				echo 1;
			}else{
				echo '评论失败!';
			}
		}else{
			echo $param;
		}
	}

	private function _getPram($param = array()){
		$param = safeHtml($param);
		$returnParam = array();
		$user = Ebh::app()->user->getloginuser();
		$returnParam['itemid'] = !empty($param['itemid'])?$param['itemid']:0;
		$returnParam['uid'] = $user['uid'];
		$returnParam['subject'] = !empty($param['subject'])?$param['subject']:'';
		$returnParam['dateline'] = time();
		$returnParam['fromip'] = $this->input->getip();
		$returnParam['status'] = 1;
		$formhash = empty($param['formhash'])?'':$param['formhash'];
		$token = empty($param['token'])?'':$param['token'];
		$checkRes = $this->_check($returnParam,$formhash,$token);
		if($checkRes!==true){
			return $checkRes;
		}
		return $returnParam;
	}

	private function _check($param = array(),$formhash,$token){
		if(checkToken($token)==false){
			return '请勿多次提交!';
		}
		$rightHashCode = $this->getHashCode($param['itemid']);
		if($rightHashCode!=$formhash)
			return '表单参数被篡改,或者用户没有登录!';
		$slength = mb_strlen($param['subject'],'UTF8');
		if($slength>150||$slength<1){
			return '评论长度不对!';
		}
		return true;
	}

	public function getHashCode($itemid=0){
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			return 0;
		}else{
			$itemid = intval($itemid);
			$hashCodeBT = $user['uid'].$itemid.$user['username'];
			return formhash($hashCodeBT);
		}
	}

	public function getHashCodeAjax(){
		$itemid = intval($this->input->post('itemid'));
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			echo 0;
		}else{
			$hashCodeBT = $user['uid'].$itemid.$user['username'];
			echo formhash($hashCodeBT);
		}
	}

	public function checkHashCode(){

	}
}