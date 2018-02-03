<?php
/**
 * 直播课服务器地址
 * 需要替换[liveid]为当前课的liveid
 */
$hlsservers = array();
$hlsservers['hlfplayurl'] = 'http://ebhhlsplay.satacdn.com/ebhlive/[liveid]/index.m3u8';
$hlsservers['teacherdoc'] = 'http://ebhhlsplay.satacdn.com/ebhlive/[liveid]s/index.m3u8';	//教师画板
$hlsservers['teachercamera'] = 'http://ebhhlsplay.satacdn.com/ebhlive/[liveid]c/index.m3u8';	//教师摄像头