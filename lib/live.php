<?php
class live {
	private $testcridarr = array(10600);
	/** sataCDN
	*/
	private $testconfig = array(
        'siteKey'=>'6a7d7d3db6a8ac01c9f64568a7dad692',
        'sitePwd'=>'e10adc3949ba59abbe56e057f20f883e',
        'siteUrl'=>'http://chat81.ebh.net/common/webService/service.php?WSDL',
        'clientUrl'=>'http://chat81.ebh.net/common/activeX/',
		'CDNPublishURL'=>'rtmp://ebhrtmppub.satacdn.com/ebhlive/',
        'defaultPwd'=>'1983938'
	);
	/** dnionCDN
	*/
//	private $testconfig = array(
//        'siteKey'=>'6a7d7d3db6a8ac01c9f64568a7dad692',
//        'sitePwd'=>'e10adc3949ba59abbe56e057f20f883e',
//        'siteUrl'=>'http://chat81.ebh.net/common/webService/service.php?WSDL',
//        'clientUrl'=>'http://chat81.ebh.net/common/activeX/',
//		'CDNPublishURL'=>'rtmp://tangqiaortmppublish.dnion.com/tangqiao/',
//        'defaultPwd'=>'1983938'
//	);


    /**
     * 创建liveid
     * @param $submitat
     * @param $cwlength
     * @return string
     */
    public function createLiveId($submitat,$cwlength){
        $endtime = $submitat + $cwlength;
        $nowtime = time();
        $array = str_split($endtime,1);
        $rndArray = array_rand($array,5);
        $rndStr = implode($rndArray,'');

        return $nowtime.$rndStr;
    }
    /**
    *教师创建直播课
    * @param $username string 用户账号 
    * @param $realname string 用户真实姓名
    * @param $title string 直播课程主题
    * @param $startdate int 开始时间时间戳
    * @param $duration int 持续时间（秒）
    */
    public function createLive($username,$realname,$title,$startdate,$duration) {
		$roominfo = Ebh::app()->room->getcurroom();
		if(!empty($roominfo) && in_array($roominfo['crid'],$this->testcridarr)) {	//连接直播测试环境
			return $this->createLive2($username,$realname,$title,$startdate,$duration);
		}
		log_message("createLive");
        $result = FALSE;
        $liveapi = Ebh::app()->getConfig()->load('liveapi');
        $siteKey = $liveapi['siteKey'];
        $sitePwd = $liveapi['sitePwd'];
        $siteUrl = $liveapi['siteUrl'];
        $meetingPwd = $liveapi['defaultPwd'];
		log_message("siteurl:$siteUrl");
        $client = new SoapClient($siteUrl);
        $optionarr = array();
        $optionarr['meetingStartTime'] = $startdate;
        $optionarr['meetingDuration'] = $duration;
        $optionarr['userType'] = 0;
        $optionarr['scheduledAllowStartTime'] = SYSTIME;
        $optionarr['scheduledStartTime'] = $startdate;
        $optionarr['scheduledEndTime'] = $startdate + $duration; //安排的结束时间
        $optionarr['scheduledAlertTime'] = $startdate + $duration + 3600 - 900;	//延时45分钟时提示
        $optionarr['scheduledForceEndTime'] = $startdate + $duration + 3600;	//延时60分钟强制关闭
        $option = json_encode($optionarr);
        log_message($option);
        $clientresult = $client->createConference($siteKey,$sitePwd,$username,$realname,$title,$meetingPwd,$option);
        $xml = simplexml_load_string($clientresult);
        log_message(print_r($xml,true));
        if(!empty($xml) && $xml->result == '0' && !empty($xml->meetingId)) {
            $result = ''.$xml->meetingId;
        }
        return $result;
    }
    /**
    *加入直播
    * @param $username string 用户账号 
    * @param $realname string 用户真实姓名
    * @param $title string 直播课程主题
    * @param $liveid string 直播会议ID
    * @param $isClientJump int 是否以客户端方式打开，1表示客户端打开
    */
    public function joinLive($username,$realname,$title,$liveid,$isClientJump = 0,$assistant = FALSE) {
		$roominfo = Ebh::app()->room->getcurroom();
		if(!empty($roominfo) && in_array($roominfo['crid'],$this->testcridarr)) {	//连接直播测试环境
			return $this->joinLive2($username,$realname,$title,$liveid,$isClientJump,$assistant);
		}
        $result = FALSE;
        $liveapi = Ebh::app()->getConfig()->load('liveapi');
        $siteKey = $liveapi['siteKey'];
        $sitePwd = $liveapi['sitePwd'];
        $siteUrl = $liveapi['siteUrl'];
        $clientUrl = $liveapi['clientUrl'];
        $meetingPwd = $liveapi['defaultPwd'];
		$CDNPublishURL = $liveapi['CDNPublishURL'];
        $client = new SoapClient($siteUrl);
        $optionarr = array('isClientJump'=>$isClientJump,'CDNPublishURL'=>$CDNPublishURL);
		if($assistant) {	//是助教则传usertype=3
			$optionarr['userType'] = 3;
		}
        $option = json_encode($optionarr);
        $clientresult = $client->joinConference($siteKey,$sitePwd,$liveid,$meetingPwd,$username,$realname,$option);
		log_message(var_export ($clientresult,true));
        $xml = simplexml_load_string($clientresult);
        $url = '';
        // var_dump($xml);
        if(!empty($xml) && !empty($xml->activeXUrl)) {
            $activeXUrl = $xml->activeXUrl;
            $activeXUrl = htmlspecialchars_decode($activeXUrl);
            $url = $clientUrl.$activeXUrl;
        }
        return $url;

    }

	//###test start //用于连接直播测试环境
	/**
    *教师创建直播课
    * @param $username string 用户账号 
    * @param $realname string 用户真实姓名
    * @param $title string 直播课程主题
    * @param $startdate int 开始时间时间戳
    * @param $duration int 持续时间（秒）
    */
    public function createLive2($username,$realname,$title,$startdate,$duration) {
        $result = FALSE;
        $liveapi = $this->testconfig;
        $siteKey = $liveapi['siteKey'];
        $sitePwd = $liveapi['sitePwd'];
        $siteUrl = $liveapi['siteUrl'];
        $meetingPwd = $liveapi['defaultPwd'];
		log_message("siteurl:$siteUrl");
        $client = new SoapClient($siteUrl);
        $optionarr = array();
        $optionarr['meetingStartTime'] = $startdate;
        $optionarr['meetingDuration'] = $duration;
        $optionarr['userType'] = 0;
        $optionarr['scheduledAllowStartTime'] = SYSTIME;
        $optionarr['scheduledStartTime'] = $startdate;
        $optionarr['scheduledEndTime'] = $startdate + $duration; //安排的结束时间
        $optionarr['scheduledAlertTime'] = $startdate + $duration + 3600 - 900;	//延时45分钟时提示
        $optionarr['scheduledForceEndTime'] = $startdate + $duration + 3600;	//延时60分钟强制关闭
        $option = json_encode($optionarr);
        log_message($option);
        $clientresult = $client->createConference($siteKey,$sitePwd,$username,$realname,$title,$meetingPwd,$option);
        $xml = simplexml_load_string($clientresult);
        log_message(print_r($xml,true));
        if(!empty($xml) && $xml->result == '0' && !empty($xml->meetingId)) {
            $result = ''.$xml->meetingId;
        }
        return $result;
    }
    /**
    *加入直播
    * @param $username string 用户账号 
    * @param $realname string 用户真实姓名
    * @param $title string 直播课程主题
    * @param $liveid string 直播会议ID
    * @param $isClientJump int 是否以客户端方式打开，1表示客户端打开
    */
    public function joinLive2($username,$realname,$title,$liveid,$isClientJump = 0,$assistant = FALSE) {
        $result = FALSE;
        $liveapi = $this->testconfig;
        $siteKey = $liveapi['siteKey'];
        $sitePwd = $liveapi['sitePwd'];
        $siteUrl = $liveapi['siteUrl'];
        $clientUrl = $liveapi['clientUrl'];
        $meetingPwd = $liveapi['defaultPwd'];
		$CDNPublishURL = $liveapi['CDNPublishURL'];
        $client = new SoapClient($siteUrl);
		log_message("client = new SoapClient($siteUrl);");
        $optionarr = array('isClientJump'=>$isClientJump,'CDNPublishURL'=>$CDNPublishURL);
		if($assistant) {	//是助教则传usertype=3
			$optionarr['userType'] = 3;
		}
        $option = json_encode($optionarr);
		log_message("option:$option");
        $clientresult = $client->joinConference($siteKey,$sitePwd,$liveid,$meetingPwd,$username,$realname,$option);
		log_message("clientresult = client->joinConference($siteKey,$sitePwd,$liveid,$meetingPwd,$username,$realname,$option);");
		log_message(var_export ($clientresult,true));
        $xml = simplexml_load_string($clientresult);
        $url = '';
        // var_dump($xml);
        if(!empty($xml) && !empty($xml->activeXUrl)) {
            $activeXUrl = $xml->activeXUrl;
            $activeXUrl = htmlspecialchars_decode($activeXUrl);
            $url = $clientUrl.$activeXUrl;
        }
        return $url;

    }
	//###test end
}