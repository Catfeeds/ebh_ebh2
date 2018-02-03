<?php
use \Workerman\Autoloader;
use \GatewayWorker\Lib\Db;
require_once __DIR__ . '/../Workerman/Autoloader.php';
function getloginuser($auth) {
    if(isset($_SESSION['user'])){
        return $_SESSION['user'];
    }
    if (!empty($auth)) {
        @list($password, $uid) = explode("\t", authcode($auth, 'DECODE'));
        $uid = intval($uid);
        if ($uid <= 0) {
            return FALSE;
        }

        $sql = "select u.uid, u.username,u.realname,u.sex,u.email,u.face, u.groupid, u.credit,u.logincount,u.dateline,u.lastlogintime,u.password,u.balance,u.lastloginip,u.status,u.allowip,u.schoolname,u.mysign from ebh_users u where u.uid=$uid";
        $user = Db::instance('db1')->query($sql);
        $user = $user[0];
        if(empty($user) || $user['password'] != $password || $user['status'] == 0) {
            return false;
        }
        $_SESSION['user'] = $user;
        return $user;

    }
    return false;

}



function authcode($string, $operation, $key = '', $expiry = 0) {
    $authkey = 'SFDSEFDSDF';
    $ckey_length = 4; // 随机密钥长度 取值 0-32;
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥

    $key = md5($key ? $key : $authkey);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

function getavater($user,$size='120_120'){
    $defaulturl = "http://static.ebanhui.com/ebh/tpl/default/images/";
    $face = "";
    if(!empty($user['face'])){
        $ext = substr($user['face'], strrpos($user['face'], '.'));
        $face = str_replace($ext,'_'.$size.$ext,$user['face']);
    }else{
        if(isset($user['sex'])){
            if($user['sex']==1){//女
                $face = $user['groupid'] == 5 ? $defaulturl."t_woman.jpg" : $defaulturl."m_woman.jpg";
                $face = str_replace('.jpg','_'.$size.'.jpg',$face);
            }else{//男
                $face = $user['groupid'] == 5 ? $defaulturl."t_man.jpg" : $defaulturl.'m_man.jpg';
                $face = str_replace('.jpg','_'.$size.'.jpg',$face);
            }
        }else{
            $face = $defaulturl.'m_man.jpg';
            $face = str_replace('.jpg','_'.$size.'.jpg',$face);
        }
    }
    return $face;
}