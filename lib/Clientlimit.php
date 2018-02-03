<?php
/**
* 客户端限制验证库
*/
class Clientlimit{
	public function checkClient($redirect = TRUE,$redirecturl = NULL,$crid = NULL) {
		if(!isset($crid)) {
			$roominfo = Ebh::app()->room->getcurroom();
			if(!empty($roominfo['crid']))
				$crid = $roominfo['crid'];
			else
				$crid = 0;
		}
		if(empty($crid))	//不对非网校进行限制
			return TRUE;
		$limitclient = TRUE;    //限制用户登录设备数

		$systemsetting = Ebh::app()->room->getSystemSetting();
		$limitnum = isset($systemsetting['limitnum']) ? $systemsetting['limitnum'] : 0;
		$extlimitnum = 2;   //允许不同浏览器的多余限制次数 即 达到 $limitnum 后允许的重复浏览器次数
		if($limitclient) {
			$checkresult = $this->check($limitnum,$extlimitnum,$crid);
			if(!$checkresult) {
				if($redirect) {
					if(!empty($redirecturl)) {
						header("Location: $redirecturl");
					} else {
						header("Location: /safe.html");
					}
					exit(0);
				} else {
					return $checkresult;
				}
			}
		}
		return TRUE;
		
	}
	/**
    *验证客户信息是否合法
	* @param $redirect boolean 
    */
    private function check($limitnum,$extlimitnum,$crid = 0) {
		$input = Ebh::app()->getInput();
        $result = FALSE;
        if($limitnum == 0)
            return TRUE;
        $client = $input->getClient();
        if(empty($client))  //非法客户端直接剔除
            return FALSE;
        $screen = '';
        if(NULL !== $input->cookie('sc'))
            $screen = $input->cookie('sc');
        $client['screen'] = $screen;
        $ucmodel = Ebh::app()->model('Userclient');
        $user = Ebh::app()->user->getloginuser();

        $clients = $ucmodel->getClientsByUid($user['uid'],$crid);
        $ismobile = in_array($client['system'], array('iPad','iPhone','Android')) ? 1 : 0;
        $client['ismobile'] = $ismobile;
        $ltkey = 'lt_vt_'.md5($user['uid'].'000');  
        $curtime = microtime(TRUE);
        $client['dateline'] = intval($curtime);
        $client['lasttime'] = $curtime;
        $client['uid'] = $user['uid'];
        $client['crid'] = $crid;
        if(empty($clients)) {   //还未做任何绑定，则直接生成绑定信息
            $this->saveClient($client);
            return TRUE;
        } else {    //如果存在绑定过 则循环判断
            $lttimestr = NULL !== $input->cookie($ltkey) ? $input->cookie($ltkey) : '';
            $lttime = intval($lttimestr);
            $flag = 0;  //0表示系统或屏幕不一致 1表示 系统屏幕一致
      
            $sameclient = '';
            $clientlist = array();
            $extclientlist = array();
            foreach ($clients as $c) {
                if($c['ismobile'] == $client['ismobile'] && $c['system'] == $client['system'] && 
                    $c['screen'] == $client['screen']) {
                    $flag = 1;
                }  
                if($lttimestr == $c['lasttime']) {  //将时间微秒级别的值相同的提取 做比对
                    $sameclient = $c['clientid'];
				}
                if($c['isext'] == 1) {
                    $extclientlist[$c['clientid']] = $c;
                } else {
                    $clientlist[$c['clientid']] = $c;
                }
            }
            //存在相同时间 则浏览器和系统相同则表示同一设备
            if(!empty($sameclient) && $flag == 1) {
                return TRUE;
            }
            if(count($clientlist) < $limitnum ) {
                $this->saveClient($client);
                return TRUE;
            }
            if($flag == 0) {    //系统不一致情况，则超过绑定数量即不能访问
                return FALSE;
            }
            if($flag == 1) { //1表示系统和screen一致情况
                if(count($clients) < ($limitnum + $extlimitnum )) {
                    $client['isext'] = count($clients) >= $limitnum ? 1 : 0;
                    $this->saveClient($client);
                    return TRUE;
                }
                if(empty($lttime)) {    //如果客户无保存时间信息，则踢掉相同条件的最早绑定时间记录
                    $mintime = 0;
                    $minclientid = 0;
                    foreach ($clients as $c) {
                        $isbg = $this->compare($client['broversion'],$c['broversion']);     //客户端浏览器版本号大于等于登记的记录 才允许处理
                        if($c['ismobile'] == $client['ismobile'] && $c['system'] == $client['system'] && $c['browser'] == $client['browser'] && 
                            $isbg >= 0 && $c['screen'] == $client['screen']) {
                            if($mintime == 0 || $c['dateline'] < $mintime) {
                                $mintime = $c['dateline'];
                                $minclientid = $c['clientid'];
                            }
                        } 
                    }
                    if(!empty($minclientid)) {
                        $client['clientid'] = $minclientid;
                        $this->saveClient($client,TRUE);
                        $result = TRUE;
                    }
                } else {    //存在保存时间 则踢掉
                    return FALSE;
                }

            }
        }
        return $result;
    }
    /**
    * 比较版本号函数 
	* $ver1>$ver2 返回1 $ver1<$ver2 返回-1 $ver1=$ver2 返回0
    * 如 ver1 = '49.0.2623.12' ver2 = '49.0.2623.110' 则 compare($ver1,$ver2) 返回 -1
    */
    private function compare($ver1,$ver2) {
        if($ver1 == $ver2)
            return 0;
        $verarr1 = explode('.',$ver1);
        $verarr2 = explode('.',$ver2);
        foreach($verarr1 as $sver=>$svalue) {
            if(!isset($verarr2[$sver]))
                return 1;
            $ver1 = intval($svalue);
            $ver2 = intval($verarr2[$sver]);
            if($ver1 > $ver2)
                return 1;
            else if($ver1 < $ver2)
                return -1;
        }
        return 0;
    }
    /**
    *保存用户设备登录信息
    */
    private function saveClient($client,$isupdate = FALSE) {
		$ucmodel = Ebh::app()->model('Userclient');
        if($isupdate) {
            $addresult = $ucmodel->update($client);
        } else {
            $addresult = $ucmodel->add($client);
        }
        if($addresult !== FALSE) {
            $cookietime = 31536000; //保存绑定时间 1年
            $ltkey = 'lt_vt_'.md5($client['uid'].'000');
            Ebh::app()->getInput()->setcookie($ltkey, $client['lasttime'], $cookietime);
        }
    }
}
?>