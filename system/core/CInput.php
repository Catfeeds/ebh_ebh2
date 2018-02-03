<?php

/**
 * CInput输入类，主要针对$_GET（QUERY_STRING）和$_POST的包装
 */
class CInput {

    var $gets = NULL;
    private $prefix = 'ebh_';
    private $domain = '.ebanhui.com';
    private $path = '/';
	private $alldomain = 0;
    var $user_agent = FALSE;    //客户端浏览器USER_AGENT信息
    var $ip_address = FALSE;    //客户端地址

    public function __construct($config = array()) {
        $this->uri = Ebh::app()->getUri();
        if (isset($config['prefix'])) {
            $this->prefix = $config['prefix'];
        }
        if (isset($config['domain'])) {
            $this->domain = $config['domain'];
        }
        if (isset($config['path'])) {
            $this->path = $config['path'];
        }
		if (isset($config['path'])) {
            $this->path = $config['path'];
        }
		if (isset($config['alldomain'])) {
            $this->alldomain = $config['alldomain'];
        }
    }

    /**
     * 获取get对应值
     * @param string $key get对应的key，为NULL时则获取整个get数组
     * @param boolean $xss 是否进行xss过滤
     * @return string 返回get值
     */
    public function get($key = NULL, $xss = TRUE) {
        if (!isset($this->gets)) {
            $query_string = $this->uri->uri_query_string();
            if (!empty($query_string)) {
                parse_str($query_string, $this->gets);
            }
        }
        if ($key == NULL && $this->gets != NULL){
            $value = $this->gets;
            if ($xss) {  //过滤处理，预留
                $value = safefilter($value);
            }
            return $value;
        }
        if ($this->gets === NULL || !isset($this->gets[$key]))
            return NULL;
        $value = $this->gets[$key];
        if ($xss) {  //过滤处理，预留
            $value = safefilter($value);
        }
        return $value;
    }

    /**
     * 获取post对应值
     * @param string $key post对应的key，为NULL时则获取整个post数组
     * @param boolean $xss 是否进行xss过滤
     * @return string 返回post值
     */
    public function post($key = NULL, $xss = TRUE) {
        if ($key == NULL){
            $value = $_POST;
            if ($xss) {  //过滤处理，预留
                $value = safefilter($value);
            }
            return $value;
        }
        if (!isset($_POST[$key])) {
            return NULL;
        }
        $value = $_POST[$key];
        if ($xss) {  //过滤处理，预留
            $value = safefilter($value);
        }
        return $value;
    }

    /**
     * 合并post,get
     * @param string $key request对应的key，为NULL时则获取整个request数组
     * @param boolean $xss 是否进行xss过滤
     * @return array
     */
    public function request($key = NULL,$xss = TRUE){
        //返回的存储数组
        $param = array();
        $_post =  $this->post();
        $_get = $this->get();
        //合并get/post
        if(!empty($_get) && !empty($_post)){
            $param = array_merge($_get,$_post);
        }elseif(!empty($_get) && empty($_post)){
            $param = $_get;
        }elseif(empty($_get) && !empty($_post)){
            $param = $_post;
        }
        
        if ($key == NULL) {
            return ($xss==TRUE) ? safefilter($param) : $param;
        }
        if (!isset($param[$key])) {
            return FALSE;
        }
        $value = $param[$key];
        if ($xss) {  //过滤处理，预留
            $value = safefilter($value);
        }
        return $value;
    }
    
    /**
     * 获取cookie对应值
     * @param string $key post对应的key，为NULL时则获取整个cookie数组
     * @param boolean $xss 是否进行xss过滤
     * @return string 返回cookie值
     */
    public function cookie($key = NULL, $xss = TRUE) {
        if ($key == NULL)
            return $_COOKIE;
        $key = $this->prefix . $key;
        if (!isset($_COOKIE[$key])) {
            return FALSE;
        }
        $value = $_COOKIE[$key];
        if ($xss) {  //过滤处理，预留
            $value = safefilter($value);
        }
        return $value;
    }

    /**
     * 设置cookie值
     * @param string $key cookie key
     * @param string $value cookie value
     * @param int $life cookie有效期，以秒为单位
     * @return boolean 返回是否设置成功
     */
    public function setcookie($key, $value, $life = 0) {
        if (empty($key))
            return FALSE;
        $key = $this->prefix . $key;
        $expire = 0;
        if(!empty($life)) {
            $expire = SYSTIME + $life;
        }
		$domain = $this->domain;
		if(!empty($this->alldomain)) {	//如果设置alldomain值，则默认去当前主域名左右cookie域
			$uri = Ebh::app()->getUri();
			$domain = $uri->curdomain;
		}
        $_COOKIE[$key] = $value;
        setcookie($key, $value, $expire, $this->path, $domain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
        return TRUE;
    }

    /**
     * 获取客户端浏览器user_agent信息
     * @return string 返回user_agent信息
     */
    public function user_agent() {
        if ($this->user_agent !== FALSE) {
            return $this->user_agent;
        }
        $this->user_agent = (!isset($_SERVER['HTTP_USER_AGENT'])) ? FALSE : $_SERVER['HTTP_USER_AGENT'];
        return $this->user_agent;
    }
    /**
     * 获取客户端IP地址
     * @return string IP_ADDRESS
     */
    public function getip() {
        if ($this->ip_address !== FALSE)
            return $this->ip_address;
        if (!empty($_SERVER["HTTP_CLIENT_IP"]))
            $this->ip_address = $_SERVER["HTTP_CLIENT_IP"];
        else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
            $this->ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if (!empty($_SERVER["REMOTE_ADDR"]))
            $this->ip_address = $_SERVER["REMOTE_ADDR"];
        else
            $this->ip_address = "127.0.0.1";
		$this->ip_address = preg_match('/[\d\.]{7,15}/', $this->ip_address, $matches) ? $matches[0] : '';
        return $this->ip_address;
    }
	/**
	*获取客户端信息
	*/
	public function getClient() {
		$userAgent = $this->user_agent();
		if(empty($userAgent))
			return FALSE;
		$userAgent = strtolower($userAgent);
		//处理系统信息
		$sys = 'other';
		$sysversion = '';
        $vendor = '';
		if(strpos($userAgent,'ipad') !== FALSE) {
			$sys = 'iPad';
			if(preg_match('/cpu os ([\d_]+)/',$userAgent,$matchs)){
				$sysversion = $matchs[1];
			}
		} else if(strpos($userAgent,'iphone') !== FALSE) {
			$sys = 'iPhone';
			if(preg_match('/iphone os ([\d_]+)/',$userAgent,$matchs)){
				$sysversion = $matchs[1];
			}
		} else if(strpos($userAgent,'android') !== FALSE) {
			$sys = 'Android';
			if(preg_match('/android ([\d.]+)/',$userAgent,$matchs)){
				$sysversion = $matchs[1];
			}
		} else if(strpos($userAgent,'linux') !== FALSE) {
			$sys = 'Linux';
		} else if(strpos($userAgent,'windows mobile') !== FALSE || strpos($userAgent,'windows ce') !== FALSE ) {
			$sys = 'Windows Mobile';
		} else if(strpos($userAgent,'windows') !== FALSE) {	//windows 则设置版本
			if(strpos($userAgent,'windows nt 5.0') !== FALSE || strpos($userAgent,'windows 2000') !== FALSE) {
				$sys = 'Win2000';
			} else if(strpos($userAgent,'windows nt 5.1') !== FALSE || strpos($userAgent,'windows xp') !== FALSE) {
				$sys = 'WinXP';
			} else if(strpos($userAgent,'windows nt 5.2') !== FALSE || strpos($userAgent,'windows 2003') !== FALSE) {
				$sys = 'Win2003';
			} else if(strpos($userAgent,'windows nt 6.0') !== FALSE || strpos($userAgent,'windows Vista') !== FALSE) {
				$sys = 'WinVista';
			} else if(strpos($userAgent,'windows nt 6.1') !== FALSE || strpos($userAgent,'windows 7') !== FALSE) {
				$sys = 'Win7';
			} else if(strpos($userAgent,'windows nt 6.2') !== FALSE || strpos($userAgent,'windows 8') !== FALSE) {
				$sys = 'Win8';
			} else if(strpos($userAgent,'windows nt 6.3') !== FALSE || strpos($userAgent,'windows 8.1') !== FALSE) {
				$sys = 'Win8.1';
			} else if(strpos($userAgent,'windows nt 10') !== FALSE || strpos($userAgent,'windows 10') !== FALSE) {
				$sys = 'Win10';
			}    
		} else if(strpos($userAgent,'mac') !== FALSE) {
			$sys = 'Mac';
		} else if(strpos($userAgent,'X11') !== FALSE) {
			$sys = 'Unix';
		}
        //处理浏览器厂家
        if(strpos($userAgent,'ebhbrowser') !== FALSE) {
            $vendor = '直播客户端';
        } else if(strpos($userAgent,'micromessenger') !== FALSE) {
            $vendor = '微信';
        } else if(strpos($userAgent,'maxthon') !== FALSE) {
            $vendor = '遨游';
        } else if(strpos($userAgent,'qqbrowser') !== FALSE) {
            $vendor = 'QQ';
        } else if(strpos($userAgent,'metasr') !== FALSE) {
            $vendor = '搜狗';
        } else if(strpos($userAgent,'lbbrowser') !== FALSE) {
            $vendor = '猎豹';
        } else if(strpos($userAgent,'opr') !== FALSE || strpos($userAgent,'opera') !== FALSE) {
            $vendor = '欧朋';
        } else if(strpos($userAgent,'edge') !== FALSE) {
            $vendor = 'Edge';
        } else if(strpos($userAgent,'bidubrowser') !== FALSE) {
            $vendor = '百度';
        } else if(strpos($userAgent,'juzibrowser') !== FALSE) {
            $vendor = '桔子';
        } else if(strpos($userAgent,'theworld') !== FALSE) {	
            $vendor = '世界之窗';
        } else if(strpos($userAgent,'firefox') !== FALSE) {
            $vendor = '火狐';
        } else if(strpos($userAgent,'ubrowser') !== FALSE) {
            $vendor = 'UC';
        } else if(strpos($userAgent,'chrome') !== FALSE) {
            $vendor = '谷歌';
        }//chrome放在最后
		//处理浏览器和版本信息
		$browser = '';
		$broversion = 0;
		if(preg_match('/ebhbrowser\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'ebhBrowser';
		} else if(preg_match('/bidubrowser\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'BIDUBrowser';
		} else if(preg_match('/juzibrowser\/([\d.]+)/',$userAgent,$matchs)) {//没有版本,ie
			$broversion = $matchs[1];
			$browser = 'juzibrowser';
		} else if(preg_match('/lbbrowser\/([\d.]+)/',$userAgent,$matchs)) {//没有版本,chrome
			$broversion = $matchs[1];
			$browser = 'lbbrowser';
		} else if(preg_match('/ubrowser\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'ubrowser';
		} else if(preg_match('/theworld ([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'theworld';
		} else if(preg_match('/micromessenger\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'micromessenger';
		} else if(preg_match('/edge\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'Edge';
		} else if(preg_match('/maxthon\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'maxthon';
		} else if(preg_match('/qqbrowser\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'qqbrowser';
		} else if(preg_match('/metasr ([\d.]+)/',$userAgent,$matchs)) {//版本与关于里不太符合,1.0
			$broversion = $matchs[1];
			$browser = 'metasr';
		} else if(preg_match('/trident\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = intval($matchs[1]);
			$browser = 'IE';
			$broversion = $broversion + 4;
		} else if(preg_match('/rv:([\d.]+)\) like gecko/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'IE';
		} else if(preg_match('/msie ([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'IE';
		} else if(preg_match('/firefox\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'Firefox';
		} else if(preg_match('/opera.([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'Opera';
		} else if(preg_match('/opr\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'Opera';
		} else if(preg_match('/chrome\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'Chrome';
		} else if(preg_match('/safari\/([\d.]+)/',$userAgent,$matchs)) {
			$broversion = $matchs[1];
			$browser = 'Safari';
		} 
        $ip = $this->getip();

		$client = array('system'=>$sys,'systemversion'=>$sysversion,'browser'=>$browser,'broversion'=>$broversion,'vendor'=>$vendor,'ip'=>$ip);
		return $client;
	}
}