<?php

/*
 * 通用方法
 */


function do_post1($url, $data , $retJson = true ,$setHeader = false){
    $auth = Ebh::app()->getInput()->cookie('auth');
    $uri = Ebh::app()->getUri();
    $domain = $uri->uri_domain();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    if ($setHeader) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
    }
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    }
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIE, 'ebh_auth='.urlencode($auth).';ebh_domain='.$domain);
    $ret = curl_exec($ch);
    curl_close($ch);
    if($retJson == false){
        $ret = json_decode($ret);
    }
    return $ret;
}

if (!function_exists('curl_file_create')) {
    function curl_file_create($filename, $mimetype = '', $postname = '') {
        return "@$filename;filename="
            . ($postname ?: basename($filename))
            . ($mimetype ? ";type=$mimetype" : '');
    }
}

//获取资源MIME信息
function getMime1($ext = ''){
    if(empty($ext)){
       return 'application/octet-stream';
    }
    $mimes = Ebh::app()->getConfig()->load('mimes');
    if(array_key_exists($ext, $mimes)){
        return $mimes[$ext];
    }else{
        return 'application/octet-stream';
    }
}

//数据安全过滤
function safefilter1($datas){
    if(empty($datas)){
        return $datas;
    }
    if(is_array($datas)){
        foreach ($datas as &$data) {
            $data = safefilter($data);
        }
    }else{
        $datas = h($datas);
    }
    return $datas;
}


/**
 * 验证是不是微信浏览器
 * 访问
 * @return boolean
 */
function is_weixin1(){
    if(!empty($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) ){
        return true;
    }else{
        return false;
    }
}

