<?php 
/**
 * @author eker 2016年12月5日20:25:18
 * 修改版本号 更新图片/样式/js缓存
 * 1.将common.php下的getv()函数搬到这里
 * 2.增加一个检测是否更新功能
 * 3.设置版本号过期30天
 * 4.逻辑是,a).缓存超过30天的 更新版本 b).该文件有修改(获取文件修改时间戳) 更新版本
 */
// $v  = '20170104113330';

/**
 * 获取版本号
 */
if(function_exists('getv') === false) {
	function getv(){
		//增加一个缓存
		static $cache = array();
		if(isset($cache['version'])){
			return $cache['version'];
		}else{
			$v  = '20170427160033';//版本格式:YYYY年MM月DD日HH时MM分XX(两位随机整数)
			$vtime = strtotime(substr($v, 0,12));//手动写入版本号时间
			$filetime= getFileTime();//文件修改时间
			$nowtime = SYSTIME;//当前程序时间
			$expire = 30*24*3600;//缓存30天
			if(($vtime+$expire)<$nowtime){//过期
				//写入文件 覆盖版本号
				updateVersion($v = getNum());
			}else{//未过期
				/*
				log_message(formateDate($vtime));
				log_message(formateDate($filetime));
				*/
				//文件是否修改了
				if($vtime < strtotime(date("Y-m-d H:i",$filetime))){
					//写入文件 覆盖版本号
					updateVersion($v = getNum());
				}
			}
			$cache['version'] = '?v='.$v;
			
			return $cache['version'];
		}
	}
}

/**
 * 获取文件修改时间戳
 */
if(function_exists('getNum') === false) {
	function getNum(){
		$mtime=getFileTime();
		$numStr = date("YmdHi",$mtime).rand(0, 99);
		return $numStr;
	}
}

/**
 * 获取文件最新修改时间
 */
if(function_exists('getFileTime') === false){
	function getFileTime() {
		//增加一个缓存
		static $caches = array();
		if(isset($caches['mtime'])){
			return $caches['mtime'];
		}
		$mtime=filemtime(__FILE__);
		//把结果记录到缓存中
		$caches['mtime'] = $mtime;
		return $caches['mtime'];
	}
}


/**
 * 时间格式化
 * @param unknown $time
 * @param string $formate
 */
if(function_exists('formateDate') === false){
	function formateDate($time,$format="Y-m-d H:i:s"){
		$retStr = '-/-/-';
		if(!empty($time)){
			if(is_numeric($time) && ($time>0)){//时间戳
				$retStr = date($format,$time);
			}else{
				if(strtotime($time)!=FALSE){
					$retStr = date($format,strtotime($time));
				}
			}
		}
	
		return $retStr;
	}
}


/**
 * 写入版本号
 */
if(function_exists('updateVersion') === false){
	function updateVersion($version=''){
	    //先把写文件注释掉 @eker-huang 2017年1月19日14:26:22
	    return true;
	    
		//读文件
		//$filestr = file_get_contents(__FILE__);
		//替换版本号
		//$filestr = preg_replace("/\\\$v\s*=\s*[\'|\"](\d+)[\'|\"]\s*;/i","\$v  = '{$version}';",$filestr);
		//log_message($version);
		//log_message($filestr);
		//file_put_contents(__FILE__, $filestr);
		//return true;
	}
}


?>
