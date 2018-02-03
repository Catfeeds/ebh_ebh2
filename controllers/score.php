<?php

/**
 * 积分计划列表页
 */
class ScoreController extends CControl {
    public function index() {
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		//积分计划
        $productmodel = $this->model('product');
		$param = array('status'=>0,'limit'=>'0,16');
		$productchachekey = $this->cache->getcachekey('product',$param);
		$productlist = $this->cache->get($productchachekey);
		if(empty($productlist)) {
			$productlist = $productmodel->getList($param);
			$this->cache->set($productchachekey,$productlist,86400);
		}
        $this->assign('productlist', $productlist);
		$this->display('common/score');
	}
	public function view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
	    $productid = $this->uri->itemid;
		$productmodel = $this->model('product');
		$productvalue = $productmodel->getOneByProductID($productid);
        $this->assign('productvalue', $productvalue);
		$this->display('common/score_view');
	}
	//积分兑换方法
	public function submitorders(){
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$productid = $this->input->post('pid');
		if(!is_numeric($productid) || $productid < 0)	
			$productid = 0;
		// $opencount = $this->model('opencount');//插入支付记录
		$productmodel = $this->model('product');//更新库存
		$ordermodel = $this->model('order');
		$productvalue = $productmodel->getOneByProductID($productid);
		if(empty($productvalue)){
			echo json_encode(array('result'=>'error2','msg'=>'产品不存在！'));exit;
		}
		if($productvalue['stockqty']==0){
			echo json_encode(array('result'=>'error2','msg'=>'产品库存不足','pname'=>$productvalue['productname'],'sellqty'=>$productvalue['sellqty'],'stockqty'=>$productvalue['stockqty']));exit;
		}
		$pcredit = $productvalue['credit'];
		$productname = $productvalue['productname'];
		$uid = $user['uid'];
		$roomusermodel = $this->model('roomuser');
		// $crid = $productvalue['crid'];
		// $roomuservalue = $roomusermodel->getroomuserdetail($crid,$uid);
		$mcredit = $user['credit'];
		$creditmodel = $this->model('credit');
		if(!empty($productvalue)){
			if($productvalue['type']==1){//虚拟产品兑换
				if($mcredit>=$pcredit){
					$param = array('ruleid'=>16,'credit'=>$pcredit,'productid'=>$productid);
					$mset = $creditmodel->addCreditlog($param);//更新用户积分并写入日志
					$param = array('uid'=>$uid,'pid'=>$productid,'dateline'=>SYSTIME,'status'=>1,'type'=>$productvalue['type']);
					$oid=$ordermodel->insert($param);
					if($oid){
						$param = array('sellqty'=>$productvalue['sellqty']+1,'stockqty'=>$productvalue['stockqty']-1,'productid'=>$productid);
						$productmodel->_update($param);
						echo json_encode(array('result'=>'success','pname'=>$productname,'sellqty'=>$productvalue['sellqty']+1,'stockqty'=>$productvalue['stockqty']-1));
					}else{
						echo json_encode(array('result'=>'error','pname'=>$productname));
					}
				}
				else{
					$msg = '您的积分当前为'.$mcredit.'兑换需要积分'.$pcredit.'！';
					echo json_encode(array('result'=>'error2','msg'=>$msg,'pname'=>$productname,'sellqty'=>$productvalue['sellqty'],'stockqty'=>$productvalue['stockqty']));exit;
				}
			}else{//实物产品兑换
				$name = $this->input->post('name');
				$address = $this->input->post('address');
				$phone = $this->input->post('phone');
				$postcode = $this->input->post('postcode');
				if($mcredit>=$pcredit){
					$param = array('ruleid'=>16,'credit'=>$pcredit,'productid'=>$productid);
					$mresult = $creditmodel->addCreditlog($param);
					$res = $ordermodel->insert(array('uid'=>$uid,'name'=>$name,'address'=>$address,'postcode'=>$postcode,'pid'=>$productid,'dateline'=>SYSTIME,'status'=>1,'type'=>$productvalue['type'],'phone'=>$phone));
				}else{
					$msg = '您的积分当前为'.$mcredit.'兑换需要积分'.$pcredit.'！';
					echo json_encode(array('result'=>'error2','msg'=>$msg,'pname'=>$productname,'sellqty'=>$productvalue['sellqty'],'stockqty'=>$productvalue['stockqty']));exit;
				}
				if($res){
					$param = array('sellqty'=>$productvalue['sellqty']+1,'stockqty'=>$productvalue['stockqty']-1,'productid'=>$productid);
					$productmodel->_update($param);
					echo json_encode(array('result'=>'success','pname'=>$productname,'sellqty'=>$productvalue['sellqty']+1,'stockqty'=>$productvalue['stockqty']-1));
				}else{
					echo json_encode(array('result'=>'error','pname'=>$productname));
				}
			}
		}
	}
}
?>
