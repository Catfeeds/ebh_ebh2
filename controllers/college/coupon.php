<?php
/**
 * 优惠码控制器
 */
class CouponController extends CControl {
	private $user = NULL;
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		$user = Ebh::app()->user->getloginuser();
		$this->user = $user;
		if($this->user['groupid']==6){
			if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
				$check = Ebh::app()->room->checkstudent(TRUE);
			} else {
				Ebh::app()->room->checkstudent();
			}
			$this->assign('check',$check);
		}else{//老师 默认生成一张优惠码
			
		}
    }
    public function index() {
    	$user = $this->user;
		$mycoupon = $this->model('coupons')->getOne(array('uid'=>$user['uid']));
		$mycoupon = empty($mycoupon['code']) ? '' : $mycoupon['code'];
		
		if(($user['groupid']==5) && empty($mycoupon)){//如果是老师 默认创建优惠码
			$mycoupon = $this->create($user);
		}
		$this->assign('mycoupon', $mycoupon);
    	$this->display('college/coupon');
    }
    
    /**
     * 生成优惠码
     * @param unknown $user
     */
    private function create($user){
    	$couponarr = array();
    	$couponarr['uid'] = $user['uid'];
    	$couponarr['code'] = $this->getcouponcode();
    	$couponarr['createtime'] = SYSTIME;
    	$couponarr['fromtype'] = 1;
    	$couponsModel = $this->model('Coupons');
    	$myret = $couponsModel->add($couponarr);
    	if(!empty($myret)){
    		return 	$couponarr['code'];
    	}else{
    		return false;
    	}
    }
    
    //生成优惠码
    private function getcouponcode(){
    	$couponcode = $this->generatestr();
    	//检测是否重复
    	$model = $this->model('Coupons');
    	$ck = $model->checkcoupon($couponcode);
    	if($ck){
    		$couponcode = $this->getcouponcode();
    	}
    	return $couponcode;
    }
    /**
     * 生成随机数
     * @param number $length
     * @return string
     */
    private function generatestr( $length = 6 ){
    	// 密码字符集，可任意添加你需要的字符
    	$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$password = '';
    	for ( $i = 0; $i < $length; $i++ )
    	{
    		$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    	}
    	return $password;
    }
}