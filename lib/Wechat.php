<?php
/**
  * 微信扩展类
  * @author eker
  * @time 2016年6月21日14:07:56
  * @emai qq704855854@126.com
  */
class Wechat
{
	private $_token = NULL;		//微信接口token
	private $_appID = NULL;		//微信接口appID 
	private $_appsecret = NULL; //微信接口appsecret
	private $_access_token = NULL;	//微信接口公众号的全局唯一票据，为了避免每次从微信接口取数据，设置此变量
	private $_ebhcode = NULL; //网校唯一标识码
	private $_domain = NULL;//微信授权域
	
	public function __construct() {
		$this->init();
	}
	
	/**
	 * 重新加载配置信息
	 * @param unknown $config
	 */
	public function init($config=array()){
		if(!empty($config)){
			$this->_token 	= $config['token'];
			$this->_appID 	= $config['appID'];
			$this->_appsecret 	= $config['appsecret'];
			$this->_template = $config['template'];
			$this->_ebhcode = $config['ebhcode'];
			$domain = !empty($config['domain']) ? $config['domain'] : "eth.ebh.net";
			$this->_domain = "http://".$domain;
		}else{
			$config = Ebh::app()->getConfig()->load('wxt');
			$this->init($config);
		}
	}
	
	/**
	 * 获取授权domain
	 */
	public function getDomain(){
		return $this->_domain;
	}
	/**
	*根据客户端code获取对应的openid，
	*主要用户微信菜单上的网页授权
	*微信点击菜单会传递code参数
	*@param string $code 网页授权code，每次点击菜单会传递此参数，且每次都会不同
	*@return string 返回 openid
	*/
	public function getopenidbycode($code) {
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->_appID.'&secret='.$this->_appsecret.'&code='.$code.'&grant_type=authorization_code';
		$tokenjson = $this->getHttpResponseGET($url);
		$tokenarr = json_decode($tokenjson);
		if(empty($tokenarr) || !empty($tokenarr->errcode) || empty($tokenarr->openid))
			return FALSE;
		$openid = $tokenarr->openid;
		return $openid;
	}

	/**
	 * 返回消息
	 */
    public function responseMsg(){
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
		if (!empty($postStr)){

              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
	/**
	*验证微信接口发送过来的消息是否合法
	*/
	public function checkSignature(){
		if(empty($_GET["signature"]) || empty($_GET["timestamp"]))
			return FALSE;
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];

        $nonce = $_GET["nonce"];
		$tmpArr = array($this->_token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	/**
	*解析微信客户端提交的数据
	*/
	public function parsedata() {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			return $postObj;
		}
		return FALSE;
	}

 


	/**
	 * 获取用户信息
	 * @param unknown $openid
	 * @param string $reget
	 * @return mixed
	 */
	public function getuserinfo($openid,$reget=false) {
		$access_token = $this->getAccess_token($reget);
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$userjson = $this->getHttpResponseGET($url);
		$userarr = json_decode($userjson);
		if(!empty($userarr->userrcode)){
			$userarr = $this->getuserinfo($openid,true);
		}
		return $userarr;
	}
	 
	
	/**
	 * 重新授权
	 */
	public function auth(){
		$redirect_uri = $this->_domain."/wxt.html";
		$ebhcode = $this->_ebhcode;
		if(!empty($ebhcode)) $redirect_uri.="?ebhcode=".$ebhcode;
		//$auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->_appID.'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
		//换成下面这种 弹出授权页 手动授权  --eker @2017年7月14日10:08:55
		$auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->_appID.'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
		header("Location:$auth_url");
	}
	
	/**
	*创建菜单
	*/
	public function cretemenu() {
		$access_token = $this->getAccess_token();
		//echo $access_token;exit;
		$redirect_uri = $this->_domain."/wxt.html";
		$ebhcode = $this->_ebhcode;
		if(!empty($ebhcode)) $redirect_uri.="?ebhcode=".$ebhcode;

		$menu = '{
			    "button": [
			        {
			            "type": "view",
			            "name": "大黄的公众号",
			            "url":'.$this->_domain.'
			        },
			        {
			            "type": "view",
			            "name": "微校通",
			            "url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->_appID.'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=123#wechat_redirect"
			        }
			    ]
			}';
		
		$url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
		$ret = $this->getHttpResponsePOST($url,$menu);
		var_dump($ret);
	}

	/**
	 * 给微信客户端发消息
	 */
	public function sendmessagebyopenid($openid,$content,$resend = FALSE) {
		$access_token = $this->getAccess_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
		$msg = '{
			"touser":"'.$openid.'",
			"msgtype":"text",
			"text":
			{
				 "content":"'.$content.'"
			}
		}';
		$result = $this->https_post($url,$msg);
		if(!empty($result)) {
			$returnarr = json_decode($result);
			if(!empty($returnarr) && !empty($returnarr->errcode) && $returnarr->errcode == '40001') {
				$access_token = $this->getAccess_token(TRUE);
				if(!$resend) {
					return $this->sendmessagebyopenid($openid,$content,TRUE);
				}
				return FALSE;
			}
		}
		return TRUE;
	}
 

	/**
	 * 发起post请求
	 * @param unknown $url
	 * @param unknown $data
	 * @return mixed
	 */
	function getHttpResponsePOST($url, $data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	
	/**
	 * 发起post请求
	 *
	 */
	function dopost($url,$data) {
		$header[]="Content-Type: text/xml; charset=utf-8";
		$header[]="Accept: text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2";
		$header[]="Connection: keep-alive";
		$header[]="Content-Length: ".strlen($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$res = curl_exec($ch);
		curl_close($ch);
	}

	/**
	 * 发起post请求
	 * @param unknown $url
	 * @param unknown $data
	 * @return boolean|mixed
	 */
	function https_post($url,$data)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		if (curl_errno($curl)) {
		   return FALSE;
		}
		curl_close($curl);
		return $result;
	}


	/**
	 * 发起GET请求
	 * @param unknown $url
	 * @return mixed
	 */
	function getHttpResponseGET($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result =  curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	/**
	 * 获取微信接口全局 access_token
	 * @param string $fresh 是否直接从微信服务端重新取值
	 * @return unknown
	 */
	public function getAccess_token($fresh = FALSE){
		$cache = Ebh::app()->getCache();
		$cache_key = $this->_appID.'_access_token'; 
		if(!$fresh) {	//默认不刷新，则从缓存中取
			if(isset($this->_access_token))	
				return $this->_access_token;
			//从缓存中取
			$access_token = $cache->get($cache_key);
			if(!empty($access_token)) {
				$this->_access_token = $access_token;
				return $access_token;
			}else{
				return $this->getAccess_token(true);
			}
		}
		//从微信服务接口中取
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->_appID."&secret=".$this->_appsecret;
		$tokenjson = $this->getHttpResponseGET($url);
		$tokenarr = json_decode($tokenjson);
		$expire_time = $tokenarr->expires_in;
		$expire_time = intval($expire_time) - 1000;
		if($expire_time <= 0)
			$expire_time = 1000;
		$access_token = $tokenarr->access_token;
		$cache->set($cache_key,$access_token,$expire_time);
		$this->_access_token = $access_token;
		return $access_token;
	}
	
	/**
	 * 给客户端发微信
	 * @param unknown $openid
	 * @param unknown $data
	 * @param string $resend
	 * @param number $template_id
	 * @return boolean
	 */
	public function sendMessageByOpenidWithTpl($openid,$data,$resend = FALSE) {
		$access_token = $this->getAccess_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
		
		if(empty($this->_template['tempid'])){
			log_message('模板id配置错误');
			return FALSE;
		}
		$header = array(
			"touser"=>$openid,
			"template_id"=>$this->_template['tempid'],
			"topcolor"=>"#FF0000"
		);
		$msg = array_merge($header,$data);
		$msg = json_encode($msg);
		$result = $this->https_post($url,$msg);
		//log_message(var_export($header,true));
		if(!empty($result)) {
			$returnarr = json_decode($result);
			if(!empty($returnarr) && !empty($returnarr->errcode) && $returnarr->errcode == '40001') {
				$access_token = $this->getAccess_token(TRUE);
				if(!$resend) {
					return $this->sendMessageByOpenidWithTpl($openid,$data,TRUE);
				}
				return FALSE;
			}
		}
		return TRUE;
	}
}

?>