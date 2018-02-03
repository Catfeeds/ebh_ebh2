<?php
/**
*验证码控制器
*/
class VerifyController extends CControl{
	public function __construct(){
		parent::__construct();
	}
	/**
	 *生成验证码
	 *
	*/
	public function getcode($key='verify'){
		$config = array(
				'fontSize' => 14, // 验证码字体大小
				'length' => 4, // 验证码位数
				'useNoise' => false, // 关闭验证码杂点,
				'useCurve'=> true,//混淆曲线
				'imageW'=>100,
				'imageH'=>30,
		);
		$verify = Ebh::app()->lib('Verify');
		$verify->init($config);
		$verify -> entry($key);
	}
	/**
	 *检查验证码
	 *
	*/
	public function checkcode($code=''){
		$verify = Ebh::app()->lib('Verify');
		$verify->init();
		if(empty($code)){
			$code = $this->input->get('code');
			if($verify -> check($code)==true){
				echo 1;
			}else{
				echo 0;
			}
			exit();
		}
		return $verify -> check($code);
	}
}
?>