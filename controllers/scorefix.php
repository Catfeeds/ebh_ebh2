<?php
/**
 *试题分数修复 (修复ebh_schexamquestions 中分数为0 的试题)
 */
class ScorefixController extends CControl{
	public function __construct(){
		parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			echo 'user not login in  , fix  fail !';
			exit;
		}
		if($user['groupid'] !=5){
			echo 'permission deney  , fix  fail !';
			exit;
		}else{
			echo 'fix start !<br />';
		}
		set_time_limit(0);
		$this->db = Ebh::app()->getDb();
		$this->_init();
	}

	public function _init(){
		$this->fixed = 0;
		$this->pagesize = 10;
		$this->curpage = 1;
		$this->count = $this->_getcount();
		$this->totoalpage = ceil( $this->count / $this->pagesize );
		echo 'fix in background ...';
		fastcgi_finish_request();
		$this->_dofix();
		log_message('fixed :'.$this->fixed);
	}


	//获取下一页数据
	private function _nextpage(){
		$limitstr = $this->_getlimit();
		if($limitstr == false){
			return array();
		}
		$sql = 'select qid,ques from ebh_schquestions where score = 0  order by qid desc '.$limitstr;
		return $this->db->query($sql)->list_array();
	}

	//获取limit
	private function _getlimit(){
		if($this->curpage > $this->totoalpage){
			return false;
		}
		$start = ( ($this->curpage - 1) * $this->pagesize );
		$limitstr = ' limit '.$start.','.$this->pagesize;
		$this->curpage++;
		return $limitstr;
	}

	private function _getcount(){
		$sql = 'select count(1)  as count from ebh_schquestions where score = 0';
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}

	private function _base64str($str,$t = false){
		if(is_array($str)){
			foreach($str as $key=>$val ){
				$str[$key]=base64str($val,$t);
			}
		}else{
			if($t){//编码
				$str=base64_encode($str);
			}else{//解码
				$str=base64_decode($str);
			}
		}
		return $str;
	}

	private function _mb_unserialize($out) {
		$out = preg_replace_callback('/s:(\d+):"(.*?)";/s', function($matches){
			return "s:".strlen($matches[2]).':"'.$matches[2].'";';
		}, $out );
		return unserialize($out);
	}

	private function _getScore($ques){
		$ques = $this->_base64str($this->_mb_unserialize($ques));
		if(!empty($ques) && !empty($ques[0])){
			return $ques[0]['score'];
		}else{
			return 0;
		}
	}

	private function _updateque($score = 0,$qid = 0){
		if(empty($score) || empty($qid)){
			return 0;
		}
		$setarr = array(
			'score'=>$score
		);

		$where = array(
			'qid'=>$qid
		);
		return $this->db->update('ebh_schquestions',$setarr,$where);
	}

	private function _dofix(){
		while(true){
			$qs = $this->_nextpage();
			if(empty($qs)){
				break;
			}
			foreach ($qs as $q) {
				$score = $this->_getScore($q['ques']);
				$qid = $q['qid'];
				$score = intval($score);
				if(!empty($score) && !empty($qid)){
					$ret = $this->_updateque($score,$qid);
					if($ret > 0){
						$this->fixed += 1;
					}
				}
			}
		}
	}
}
