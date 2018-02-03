<?php
class WebUtil{
	/**
	*提交文件到指定URL并返回结果
	*/
	public function postfile($filepath,$url) {
		$curl = curl_init();
		$fields = array('file'=>'@'.$filepath);
		curl_setopt($curl, CURLOPT_URL, $url );
		curl_setopt($curl, CURLOPT_POST, 1 );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);    // 5.6 给改成 true了, 弄回去
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields );
		$rtn= curl_getinfo($curl,CURLINFO_HTTP_CODE);
		$result = curl_exec( $curl );
		if ($error = curl_error($curl) ) {
			   return 'error';
		}
		curl_close($curl);
		return $result;
	}
	/**
	*返回get请求
	*/
	function getfile($url)
	{
		if (ini_get("allow_url_fopen") == "1")
			return file_get_contents($url);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result =  curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}
?>