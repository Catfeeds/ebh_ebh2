<?php
/**
 *答疑短信提醒
 */
include_once "aliyun_dayu/TopSdk.php";
class SNotify{
    private $_param = array();
    public function __construct(){
         date_default_timezone_set('Asia/Shanghai'); 
         set_time_limit(0);

    }
    //name 网校名称 code 域名 ucode 注册人手机号
    public function run($param = array()){
        if( empty($param) || empty($param['name']) || empty($param['code']) || empty($param['ucode']) || empty($param['ucity']) ) {
            return;
        }
        $this->_param = $param;
        $snotify = EBH::app()->getConfig()->load('snotify');
        $mobiles = $snotify['mobiles'];
        if(!empty($mobiles) && !empty($snotify['sendmsg'])) {
            $mobiles = array_unique($mobiles);
            foreach ($mobiles as $mobile) {
                $this->_send_dayu($mobile);
            }
        }
        $emails = $snotify['emails'];
        if(!empty($emails) && !empty($snotify['sendemail'])) {
            $sendHelper = Ebh::app()->lib('EBHMailer');
            $subject = "新注册网校提醒";
            $emailmsg = sprintf('新注册网校提醒,网校 %s,域名 %s,注册人手机号 %s,IP %s,区域  %s, 教师名字 %s',$param['name'],$param['code'],$param['ucode'],$param['fromip'],$param['ucity'],$param['realname']);
            foreach ($emails as $emailinfo) {
                $sendHelper->sendMessage(array('email'=>$emailinfo['email'],'username'=>$emailinfo['username']), $subject, $emailmsg);
            }
        }
    }

    // --------------------------阿里大鱼开始-----------------------------
    private function _send_dayu($mobile,$sign = "e板会"){
        if(empty($mobile))
            return FALSE;
        $result = $this->_sendByMT3($mobile,$sign);
        if( !empty($result) && !empty($result->result) && ($result->result->err_code !== '0') ){
            //发送失败写日志
            log_message('result:'.var_export($result,true));
        }
    }

    private function _sendByMT3($mobile,$sign){
        $c = new TopClient;
        $c->format = 'json';
        $c->appkey = '23319024';
        $c->secretKey = 'abaaf4ec86ecd9e8d174ac866aa9c48e';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($sign);
        $req->setSmsParam("{\"name\":\"".$this->_param['name']."\",\"code\":\"".$this->_param['code']."\",\"ucode\":\"".$this->_param['ucode']."\",\"ucity\":\"".$this->_param['ucity']."\"}");
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode("SMS_25240003");
        return $c->execute($req);
    }
    // --------------------------阿里大鱼结束-----------------------------

}