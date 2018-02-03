<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 10:12
 */
/**
 * 回看回调入口 整个流程为
 * 回调入口：
 *          通过课件ID取得liveid后 向网易云接口请求视频列表
 *          如果视频列表只有单个视频 则直接下载 -》下载完成后进入下载完成后回调=>对视频进行转码=>更新课件信息
 *          如果视频列表有多个视频，排除合成视频后 执行网易云合成视频接口=》合成完成后回调录制完成接口=》进入下载=》下载完成后后调=》对视频进行转码=》更新课件信息
 */
$livereview['callback'] = 'http://www.ebh.net/im/review/callback.html';
//网易录制完成回调地址
$livereview['netease_callback'] = 'http://svn1.ebh.net:83/im/review/netease_cb.html';
//文件下载完成回调地址
$livereview['download_callback'] = 'http://www.ebh.net/im/review/download_cb.html';
//下载录制文件请求地址
$livereview['download_url'] = 'http://up.ebh.net/download.html';
