<?php

/**
 * 直播类基类所有直播类库必须继承该类
 * Class LiveBase
 */
abstract class LiveBase{
    public $config = array();
    protected $err = '';
    /**
     * 创建直播
     * @param $submitat
     * @param $cwlength
     * @return mixed
     */
    abstract function createLive($submitat,$cwlength);
    public function __construct(){
        $liveConfig = Ebh::app()->getConfig()->load('live');
        if(isset($liveConfig[get_class($this)])){
            foreach($liveConfig[get_class($this)] as $key=>$config){
                $this->config[$key] = $config;
            }
        }
    }
    /**
     * POST请求
     * @param $url
     * @param $data
     * @param $headdata
     * @param bool $retJson
     * @return bool|mixed
     */
    public function doPostJson($url,$data,$headdata,$retJson = true){
        $headers = array('Content-type: application/json');
        foreach($headdata as $hkey=>$hvalue) {
            array_push($headers,"$hkey: $hvalue");
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); //设置超时
        if(0 === strpos(strtolower($url), 'https')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        }

        $result = curl_exec($ch);//CURLOPT_RETURNTRANSFER 不设置  curl_exec返回TRUE 设置  curl_exec返回json(此处) 失败都返回FALSE
        if (curl_errno($ch)) {
            $result = FALSE;
        }
        curl_close($ch);
        if ($result) {
            $result = json_decode($result,$retJson);
        }
        return $result;
    }

    public function setErr($msg){
        $this->err = $msg;
    }

    public function getErr(){
        return $this->err;
    }
}
