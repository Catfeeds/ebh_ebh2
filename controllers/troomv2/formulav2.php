<?php
/**
*生成公式对应图片
*/
class Formulav2Controller extends CControl{

	public function index() {
		/**
		*生成公式对应图片
		*/
		$result = array();
		$data = $this->input->post('data');
		$callback = $this->input->get('callback');
		$thumb_size = $this->input->post('thumb_size');
		if(empty($data)) {
			$result['error'] = 'empty';
			echo json_encode($result);
			exit();
		}
		$url = 'http://up.ebh.net/formulav2.html';
		$data = array(
			'data'=>$data,
		    'thumb_size'=>empty($thumb_size)?'':$thumb_size
		);
		$result = $this->do_post($url,$data,false);
		if(empty($callback))
			echo json_encode($result);
		else
			echo $callback.'('.json_encode($result).')';
	}

	public function do_post($url, $data , $retJson = true){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
	    curl_setopt($ch, CURLOPT_POST, TRUE); 
	    curl_setopt($ch, CURLOPT_HEADER, FALSE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	    curl_setopt($ch, CURLOPT_URL, $url);
	    // curl_setopt($ch, CURLOPT_COOKIE, 'ebh_auth='.urlencode($auth).';);
	    $ret = curl_exec($ch);
	    curl_close($ch);
	    if($retJson == false){
	        $ret = json_decode($ret);
	    }
	    	return $ret;
		}

}