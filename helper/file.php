<?php
if (!function_exists('mkfolder')) {
	/**
	*创建文件夹（递归）
	*/
	function mkfolder($path) {
		if(file_exists($path))
			return TRUE;
		return mkdir($path,0777,true);
	}
}