<?php
/**
 *用户登录日志 
 */
class LoginlogModel extends CModel {
	/*
	添加日志
	@param array $param
	@return int
	*/
	public function addLog($param){
		if(empty($param['uid']) || empty($param['crid'])){
			return FALSE;
		}
		$sql = 'select dateline,browser,system from ebh_loginlogs where uid='.$param['uid'].' and crid='.$param['crid'];
		$sql.= ' order by logid desc limit 1';
		$log = $this->db->query($sql)->row_array();
		if(!empty($log) && $log['dateline'] >= SYSTIME-1 && $log['system'] == $param['system'] && $log['browser'] == $param['browser']){//间隔太短的不计
			return FALSE;
		}
			
		$setarr = array();
		if(!empty($param['ip']))
			$setarr['ip'] = $param['ip'];
		if(!empty($param['system']))
			$setarr['system'] = $param['system'];
		if(!empty($param['systemversion']))
			$setarr['systemversion'] = $param['systemversion'];
		if(!empty($param['browser']))
			$setarr['browser'] = $param['browser'];
		if(!empty($param['broversion']))
			$setarr['broversion'] = $param['broversion'];
		if(!empty($param['screen']))
			$setarr['screen'] = $param['screen'];
		if(!empty($param['citycode']))
			$setarr['citycode'] = $param['citycode'];
		if(!empty($param['parentcode']))
			$setarr['parentcode'] = $param['parentcode'];
		if(!empty($param['ismobile']))
			$setarr['ismobile'] = $param['ismobile'];
		if(!empty($param['isp']))
			$setarr['isp'] = $param['isp'];
		$setarr['dateline'] = SYSTIME;
		$setarr['crid'] = $param['crid'];
		$setarr['uid'] = $param['uid'];
		$logid = $this->db->insert('ebh_loginlogs',$setarr);
		return $logid;
	}

    /*
    添加注册日志
    @param array $param
    @return int
    */
    public function addOneRegisterLog($param){
        if(empty($param['uid'])){
            return FALSE;
        }
        $sql = 'select logid,uid from ebh_loginlogs where uid='.$param['uid'];
        $log = $this->db->query($sql)->row_array();
        if(!empty($log)){//注册记录已经存在则不记录
            return FALSE;
        }

        $setarr = array();
        if(!empty($param['ip']))
            $setarr['ip'] = $param['ip'];
        if(!empty($param['system']))
            $setarr['system'] = $param['system'];
        if(!empty($param['systemversion']))
            $setarr['systemversion'] = $param['systemversion'];
        if(!empty($param['browser']))
            $setarr['browser'] = $param['browser'];
        if(!empty($param['broversion']))
            $setarr['broversion'] = $param['broversion'];
        if(!empty($param['screen']))
            $setarr['screen'] = $param['screen'];
        if(!empty($param['citycode']))
            $setarr['citycode'] = $param['citycode'];
        if(!empty($param['parentcode']))
            $setarr['parentcode'] = $param['parentcode'];
        if(!empty($param['ismobile']))
            $setarr['ismobile'] = $param['ismobile'];
        if(!empty($param['isp']))
            $setarr['isp'] = $param['isp'];
        if(!empty($param['logtype']))
            $setarr['logtype'] = $param['logtype'];
        if(!empty($param['othertype']))
            $setarr['othertype'] = $param['othertype'];
        if(!empty($param['crid']))
            $setarr['crid'] = $param['crid'];
        $setarr['dateline'] = SYSTIME;
        $setarr['uid'] = $param['uid'];
        $logid = $this->db->insert('ebh_loginlogs',$setarr);
        return $logid;
    }
    /**
    *一次添加多行注册日志
     *@param array $param
     *@param array $logarr 批量注册用户信息
     *@return boolean
    */
    public function addMultipleRegisterLog($param,$logarr){
        $uid=0;
        $crid=0;
        $dateline=0;
        $ip='';
        $ismobile=0;
        $system='';
        $systemversion='';
        $browser='';
        $broversion='';
        $screen='';
        $citycode=0;
        $parentcode=0;
        $isp=0;
        $logtype=0;
        $othertype=0;

        if(!empty($param['ip']))
            $ip = $param['ip'];
        if(!empty($param['system']))
            $system = $param['system'];
        if(!empty($param['systemversion']))
            $systemversion = $param['systemversion'];
        if(!empty($param['browser']))
            $browser = $param['browser'];
        if(!empty($param['broversion']))
            $broversion = $param['broversion'];
        if(!empty($param['screen']))
            $screen = $param['screen'];
        if(!empty($param['citycode']))
            $citycode = $param['citycode'];
        if(!empty($param['parentcode']))
            $parentcode = $param['parentcode'];
        if(!empty($param['ismobile']))
            $ismobile = $param['ismobile'];
        if(!empty($param['isp']))
            $isp = $param['isp'];
        $dateline = SYSTIME;

        $sql='insert into ebh_loginlogs (uid,crid,dateline,ip,ismobile,system,systemversion,browser,broversion,screen,citycode,parentcode,isp,logtype,othertype) values ';
        foreach ($logarr as $logs){
            if(!empty($logs['uid'])){
                $uid = $logs['uid'];
                if(!empty($logs['logtype']))
                    $logtype = $logs['logtype'];
                if(!empty($logs['othertype']))
                    $othertype = $logs['othertype'];
                if(!empty($logs['crid']))
                    $crid = $logs['crid'];
                $sql.= "('$uid','$crid','$dateline','$ip','$ismobile','$system','$systemversion','$browser','$broversion','$screen','$citycode','$parentcode','$isp','$logtype','$othertype'),";
            }else{
                continue;
            }
        }
        $sql = rtrim($sql,',');
        return $this->db->query($sql);
    }
	/*
	根据区域名称查询信息
	*/
	public function getCityByName($cityname){
		if(empty($cityname)){
			return FALSE;
		}
		$sql = 'select citycode from ebh_cities where cityname like \''.$cityname.'%\'';
		return $this->db->query($sql)->row_array();
	}

    /**
     * [查询用户指定日期的登录信息]
     * @param   $uid  用户id
     * @param   $date 日期时间戳    
     * @return  返回记录信息 
     */
    public function getUserDayLoginNum($uid,$date){
        if(empty($uid) || empty($date)){
            return FALSE;
        }
        $startdate=strtotime(date('Y-m-d 00:00:00',intval($date)));
        $enddate=$startdate+86400;
        $sql="select count(*) as count from ebh_loginlogs where dateline between {$startdate} and {$enddate} and uid={$uid}";
        $row=$this->db->query($sql)->row_array();
        if(!empty($row)){
            $count = $row['count'];
        }
        return $count;
    }


    
}
