<?php
/**
 * 文件图标样式名函数
 */


/**
 * 格式化文件图标样式名
 * @param  string $suffix 文件后缀
 * @return string         图标样式名
 */
function format_ico($suffix){
	$ico = '';
	$suffix = strtolower($suffix);
	$icoarr = array(
		'ppt'	=> 'ico-ppt',
		'pptx'	=> 'ico-ppt',
		'pptm'	=> 'ico-ppt',
		'potx'	=> 'ico-ppt',
		'pot'	=> 'ico-ppt',
		'potm'	=> 'ico-ppt',
		'mp3'	=> 'ico-mp3',
		'doc'	=> 'ico-doc',
		'docx'	=> 'ico-doc',
		'docm'	=> 'ico-doc',
		'dotx'	=> 'ico-doc',
		'dotm'	=> 'ico-doc',
		'dot'	=> 'ico-doc',
		'rtf'	=> 'ico-doc',
		'zip'	=> 'ico-zip',
		'swf'	=> 'ico-swf',
		'xlsx'	=> 'ico-xls',
		'xls'	=> 'ico-xls',
		'csv'	=> 'ico-xls',
		'xlsm'	=> 'ico-xls',
		'xlsb'	=> 'ico-xls',
		'html'	=> 'ico-html',
		'txt'	=> 'ico-txt',
		'avi'	=> 'ico-avi',
		'jpg'	=> 'ico-jpg',
		'jpeg'	=> 'ico-jpeg',
		'gif'	=> 'ico-gif',
		'bmp'	=> 'ico-bmp',
		'png'	=> 'ico-png',
		'flv'	=> 'ico-flv',
		'mp4'	=> 'ico-mp4',
		'mpg'	=> 'ico-mpg',
		'rmvb'	=> 'ico-rmvb',
		'wmv'	=> 'ico-wmv',
		'rar'	=> 'ico-rar',
		'torrent'=> 'ico-bt',
		'pdf'	=> 'ico-pdf',
		'fdf'	=> 'ico-pdf',
		'mov'	=> 'ico-mov'
	);
	if (array_key_exists($suffix, $icoarr))
		$ico = $icoarr[$suffix];
	else
		$ico = 'ico-file';

	return $ico;
}