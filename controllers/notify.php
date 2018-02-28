<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 17:10
 */

class NotifyController extends CControl {


    public function test(){

        echo "test";
    }

    /**
     *根据notify结果 处理notify输出notify页面
     * 如果输出fail 则支付宝会以一定策略重发
     */
    public function doNotify($returnurl) {

        $result = '<HTML>'.
            '<HEAD>'.
            '<meta http-equiv="refresh" content="0; url='.$returnurl.'">'.
            '</HEAD>'.
            '</HTML>';
        echo $result;
        exit();
    }

    /**
     * 农行回调
     */
    public function abcpay(){
        log_message(var_export($_POST,true));

        $url = 'http://service.ebh.net/Transaction/Trade/notify?paytype=abcpay';
        $res = $this->http_post($url,$_POST);

        $roominfo = Ebh::app()->room->getcurroom();
        $isthird = FALSE;
        if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
            $isthird = TRUE;
        }
        if($isthird) {
            $successurl = 'http://'.$this->uri->curdomain.'/ibuy/success.html';
            $failurl = 'http://'.$this->uri->curdomain.'/ibuy/fail.html';
        } else {
            $successurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy/success.html';
            $failurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy/fail.html';
        }

        if($res == 'success'){
            $this->doNotify($successurl);
        }else{
            $this->doNotify($failurl);
        }
    }

    /**
     * 支付宝二维码支付回调
     */
    public function alipayqrcode(){
        $url = 'http://service.ebh.net/Transaction/Trade/notify?paytype=alipayqrcode';
        $res = $this->http_post($url,$_POST);
        echo $res;
        exit;
    }
    /**
     * 支付宝外部回调地址
     */
    public function alipay(){
        $url = 'http://service.ebh.net/Transaction/Trade/notify?paytype=alipay';
        $res = $this->http_post($url,$_POST);
        echo $res;
        exit;
    }
    /**
     * 课程购买
     * 微信小程序面向外部的支付回调
     */
    public function wxapppay(){
        $url = 'http://service.ebh.net/Transaction/Trade/notify?paytype=wxapppay';
        //向ebhservice发送支付回调信息
        //对于转发到ebhservice的数据。。可以在ebhservice自定义处理转发后的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $res = $this->postXmlCurl($xml,$url);
        echo $res;
        exit;
    }

    /**
     * 课程购买
     * 微信二维码支付回调
     */
    public function wxpayqrcode(){
        $url = 'http://service.ebh.net/Transaction/Trade/notify?paytype=wxpayqrcode';
        //向ebhservice发送支付回调信息
        //对于转发到ebhservice的数据。。可以在ebhservice自定义处理转发后的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $res = $this->postXmlCurl($xml,$url);
        echo $res;
        exit;
    }

    /**
     * 课程购买
     * 微信二维码支付回调
     */
    public function wxpublicpay(){
        $url = 'http://service.ebh.net/Transaction/Trade/notify?paytype=wxpublicpay';
        //向ebhservice发送支付回调信息
        //对于转发到ebhservice的数据。。可以在ebhservice自定义处理转发后的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $res = $this->postXmlCurl($xml,$url);
        echo $res;
        exit;
    }

    /**
     * 课程购买
     * 微信h5支付回调
     */
    public function wxh5pay(){
        $url = 'http://service.ebh.net/Transaction/Trade/notify?paytype=wxh5pay';
        //向ebhservice发送支付回调信息
        //对于转发到ebhservice的数据。。可以在ebhservice自定义处理转发后的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $res = $this->postXmlCurl($xml,$url);
        echo $res;
        exit;
    }

    /**
     * 以post方式提交xml到对应的接口url
     * @param $xml
     * @param $url
     * @param int $second
     */
    private function postXmlCurl($xml, $url){
        $header[]="Content-Type: text/xml; charset=utf-8";
        $header[]="Content-Length: ".strlen($xml);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    private function http_post($url,$data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            return FALSE;
        }
        curl_close($curl);
        return $result;
    }

}