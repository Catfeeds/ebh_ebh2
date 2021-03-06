<?php
/**
*e板会私信类库
*/
class EMessage {
	/**
	*发送私信
	*@param int $fromid 发送人编号
	*@param string $fromname发送人姓名
	*@param int $toid 收件人编号
	*@param string $sourceid 关联原始编号，如提问，则为提问ask qid
	*@param int type 发信类型 类型 1系统消息 2新回答 3新私信 4新评论(此类型对教师有效) 5新提问(针对老师)
	*@param string $msg 发送内容
	*@
	*/
	public function sendMessage($fromid,$fromname,$toid,$sourceid,$type,$msg) {
		$msgmodel = Ebh::app()->model('Message');
		$ulist = $fromid.'='.$fromname;
		$roominfo = Ebh::app()->room->getcurroom();
		
		$param = array('fromid'=>$fromid,'toid'=>$toid,'sourceid'=>$sourceid,'type'=>$type,'ulist'=>$ulist,'message'=>$msg,'isread'=>0,'crid'=>$roominfo['crid']);
		$mid = $msgmodel->insert($param);
		if(empty($mid)) {
			return FALSE;
        }
		//插入数据库成功，则更新只读和未读数据
		$redis = Ebh::app()->getCache('cache_redis');
		//每个用户一个hash，格式为 hash表明为m_uid hash key为 对应type
		$redis->hIncrBy('msg_'.$toid.'_'.$roominfo['crid'],$type);
		return true;
	}
	/**
	*获取我的私信数，以数组方式返回，每种类型一个值
	*@param int $toid 收件人编号
	*@param int $crid 教室id
	*/
	public function getUnReadCount($toid,$crid) {
		$redis = Ebh::app()->getCache('cache_redis');
		$hkey = 'msg_'.$toid.'_'.$crid;
		 //$redis->del($hkey);
		$harray = $redis->hget($hkey);
		if(empty($harray)) {
			$roominfo = Ebh::app()->room->getcurroom();
			$msgmodel = Ebh::app()->model('Message');
			$unreadlist = $msgmodel->getUnReadCount($toid,$roominfo['crid']);
			if(!empty($unreadlist)) {
				$harray = $unreadlist;
				$redis->hMset($hkey,$unreadlist);
			}
		}
		return $harray;
	}
	/**
	*获取同种消息未读记录
	*@param int $toid
	*@param int $sourceid
	*@param int $type
	*/
	public function getLastUnReadMessage($toid,$sourceid,$type) {
		$msgmodel = Ebh::app()->model('Message');
		$msg = $msgmodel->getLastUnReadMessage($toid,$sourceid,$type);
		return $msg;
	}
	/**
	*更新私信消息
	*/
	public function updateMessage($param) {
		$msgmodel = Ebh::app()->model('Message');
		return $msgmodel->updateMessage($param);
	}
	/**
	*根据toid和type类型批量更新已读状态
	*/
	public function resetMessageCount($toid,$crid,$type) {
		$msgmodel = Ebh::app()->model('Message');
		$upresult = $msgmodel->resetMessageCount($toid,$crid,$type);
		if(!empty($upresult)) {	//有更新数据 则更新redis缓存
			$redis = Ebh::app()->getCache('cache_redis');
			$redis->hset('msg_'.$toid.'_'.$crid,$type,0);
		}
		return TRUE;
	}
}
?>