<?php
class StudycardController extends CControl{
	private $db = NULL;
	private $total = 0;
	private $crid = 0;
	public function __construct(){
		parent::__construct();
		set_time_limit(0);
		$this->_checkuser();
		$this->_config();
		$this->_init();
		$this->_run();
		echo 'ok';
	}
	private function _checkuser(){
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			echo 'user is not correct';
			exit;
		}
		if($user['groupid'] != 5){
			echo 'user deny';
			exit;
		}
	}
	private function _init(){
		$this->db = Ebh::app()->getDb();
	}
	private function _config(){
		$this->total = 5000;
		$this->crid = 10631;
		$this->startno = 800025001;
	}
	private function _exist_in_db($cardnumber = ""){
		
	}
	private function _run(){
		$cardnos = array();    
		$total = $this->total;
		$index = 0;
		while( $total > $index ){
			$tmpno = strtoupper($this->random1(12));
			if( !in_array($tmpno, $cardnos) && (substr($tmpno, 0,1)!=0) ){
				$cardnos[] = $tmpno;
				$index++;
			}
		}
		$this->_insertData($cardnos);
	}
	private function _insertData(&$cardnos){
		$crid = $this->crid;
		$cardpass = $this->startno;
		$dateline = SYSTIME;
		$sql = 'insert into ebh_yearcards (cardnumber,cardpass,dateline,status,crid,period) VALUES';
		$valueArr = array();
		foreach ($cardnos as $cardno) {
			$valueArr[] = '("'.$cardno.'","'.$cardpass.'",'.$dateline.',0,'.$crid.','.SYSTIME.')';
			$cardpass ++;
		}
		$sql.= implode(',', $valueArr);
		$this->db->query($sql);
	}
	//生成随机字符串或数字
	private function random1($length, $numeric = 0) {
		PHP_VERSION < '4.2.0' ? mt_srand((double) microtime() * 1000000) : mt_srand();
		$seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
		$noarr = array('0','1','o','i','O','I','l','L');	//过滤容易看错的字符
		$seed = str_replace($noarr,'',$seed);
		$hash = '';
		$max = strlen($seed) - 1;
		for ($i = 0; $i < $length; $i++) {
			$hash .= $seed[mt_rand(0, $max)];
		}
		return $hash;
	}
}