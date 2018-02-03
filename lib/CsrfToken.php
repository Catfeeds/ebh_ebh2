<?php
/**
 * token 组件安全类
 * 
 * token令牌使用方法<code>
 * 1. 在form下生产一个input隐藏域token 默认csrf_token
 *   	$csrfToken = Ebh::app()->lib('CsrfToken');
  		$input = $csrfToken->getTokenInput();
  		echo $input;
  		多个form 
  		可以类似
  		$csrfToken->getTokenInput('abc');
  		$csrfToken->getTokenInput('xxx');
  2.后台服务器验证处理
  		//验证token
		$csrfToken = Ebh::app()->lib('CsrfToken');
		$csrf_token = $this->input->post('csrf_token');
		if (true !== $csrfToken->validateToken($csrf_token, 'csrf_token')) {
			echo json_encode(array('code'=>false,'msg'=>'Sorry, CSRF verification failed,refresh to try again.'));
			exit(0);
		}
  3.处理完成 注销token
  		//操作成功 删除令牌
		$csrfToken->deleteToken('csrf_token');
 * </code>
 *
 * @author echo-huang
 * @package token
 * 
 */
include 'Cookie.php';

class CsrfToken {

	/**
	 * url token
	 *
	 * @var array
	 */
	protected $token = array();
	
	/**
	 * 获取当前tokenName保存的值,如果获取的值为空则代表token不存在,或者已经失效
	 *
	 * @param string $tokenName
	 */
	public function getToken($tokenName) {
		$tokenContainer = new Cookie();
		$tokenName = $this->getTokenName($tokenName);
		return $tokenContainer->get($tokenName);
	}

	/**
	 * 根据TokenName删除token值
	 *
	 * @param string $tokenName
	 */
	public function deleteToken($tokenName) {
		$tokenContainer = new Cookie();
		$tokenName = $this->getTokenName($tokenName);
		return $tokenContainer->delete($tokenName);
	}

	/**
	 * 保存token
	 * 
	 * @param string $tokenName token名称,默认名称为<i>_tokenAppName</i>
	 * @return string 返回token值
	 */
	public function saveToken($tokenName = '') {
		$tokenName = $this->getTokenName($tokenName);
		
		if (empty($this->token[$tokenName])) {
		
			$tokenContainer = new Cookie();
			
			
			if ($tokenContainer->exist($tokenName)) {
				$_token = $tokenContainer->get($tokenName);
			} else {
				$_token = self::generateGUID();
				$tokenContainer->set($tokenName, $_token, false, null, null, null, false, true);
			}
			$this->token[$tokenName] = $_token;
		}
		return $this->token[$tokenName];
	}

	/**
	 * 验证token的有效性
	 * 
	 * 验证token的有效性.<code>
	 * 当token有效时则返回true,同时删除token.
	 * 当token无效时则返回false.
	 * <code>
	 * @param string $token
	 * @param string $tokenName token名称
	 */
	public function validateToken($token, $tokenName = '',$delete=false) {

		$tokenContainer = new Cookie();
		$tokenName = $this->getTokenName($tokenName);
		$_token = $tokenContainer->get($tokenName);
		$check = ( $_token && $_token === $token );
		if($check==true&&$delete==true){
			$this->deleteToken($tokenName);
		}
		return $check;
		
	}
	
	/**
	 * 在FORM表单中统一加入Token,由后台进行统一提交验证
	 * 
	 * @return string
	 */
	public function getTokenInput($tokenName = 'csrf') {
		$tokenName = $this->getTokenName($tokenName);
		$tokenName.="_token";
		$_token = self::escapeHTML(self::saveToken($tokenName));
		$_content = '<input type="hidden" name="'.$tokenName.'" value="'.$_token.'" />';
		return $_content;
	}
	

	
	/**
	 * token名称处理
	 *
	 * @param string $tokenName
	 * @return string
	 */
	protected function getTokenName($tokenName) {
		$tokenName = !empty($tokenName) ? $tokenName : substr(md5('_token_csrf'.microtime()), -16);
		return $tokenName ;
	}

	/**
	 * 获取唯一标识符串,标识符串的长度为16个字节,128位.
	 * 根据当前时间与sessionID,混合生成一个唯一的串.
	 *
	 * @return string GUID串,16个字节
	 */
	public static function generateGUID() {
		return substr(md5(self::generateRandStr(8) . microtime()), -16);
	}
	
	/**
	 * 获得随机数字符串
	 *
	 * @param int $length
	 *        	随机数的长度
	 * @return string 随机获得的字串
	 */
	public static function generateRandStr($length) {
		$mt_string = 'AzBy0CxDwEv1FuGtHs2IrJqK3pLoM4nNmOlP5kQjRi6ShTgU7fVeW8dXcY9bZa';
		$randstr = '';
		for ($i = 0; $i < $length; $i++) {
			$randstr .= $mt_string[mt_rand(0, 61)];
		}
		return $randstr;
	}
	
	/**
	 * 转义输出字符串
	 *
	 * @param string $str 被转义的字符串
	 * @return string
	 */
	public static function escapeHTML($str, $charset = 'ISO-8859-1') {
		if (!is_string($str)) return $str;
		return htmlspecialchars($str, ENT_QUOTES, $charset);
	}
}

?>