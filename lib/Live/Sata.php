<?php
/**
 * 沙塔使用类
 */
require_once "LiveBase.php";
class Sata extends  LiveBase{


    private $url = array(

    );
    /**
     * 创建一个liveId
     * @param $submitat
     * @param $cwlength
     * @return string
     */
    public function createLive($submitat,$cwlength){
        $endtime = $submitat + $cwlength;
        $nowtime = time();
        $array = str_split($endtime,1);
        $rndArray = array_rand($array,5);
        $rndStr = implode($rndArray,'');
        $liveid = $nowtime.$rndStr;


        $ret = array(
            'liveid'    =>  $liveid,
            'httpPullUrl'   =>  '',
            'hlsPullUrl'    =>  $this->config['hlsPurllUrl'],
            'rtmpPullUrl'   =>  $this->config['rtmpPullUrl'],
            'pushUrl'       =>  $this->config['pushUrl'],
        );

        return $ret;
    }
}