<?php
/**
 * 学习记录
 */
class RecordController extends CControl {
	private $check = 1;
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			$this->check = $check;
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$loglist = $this->_getCourseRecord($roominfo['crid'],$user['uid']);
		$count = $this->_getCourseRecordCount($roominfo['crid'],$user['uid']);
		$pagestr = show_page($count);
		$other_config = Ebh::app()->getConfig()->load('othersetting');
		$other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
		$other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
		$is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
		$is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
		$this->assign('is_zjdlr',$is_zjdlr);
		$this->assign('is_newzjdlr',$is_newzjdlr);
		$this->assign('pagestr',$pagestr);
		$this->assign('loglist',$loglist);
		$this->display('college/record');
	}
	/**
	 * 获取该用户在本网校下的课件学习记录列表
	 */
	private function _getCourseRecord($crid,$uid) {
		$queryarr = parsequery();
		$queryarr['crid'] = $crid;
		$queryarr['uid'] = $uid;
		$pmodel = $this->model('progress');
		$loglist = $pmodel->getRoomStudyRecord($queryarr);
		$recordlist = array();
		$cwidlist = array();
		foreach($loglist as $log) {	//所有播放学习记录时间等信息直接从接口读取
			$cwidlist[] = $log['cwid'];
			$log['sumtime'] = $log['ltime'];
			$log['rcount'] = 1;
			$recordlist[$log['cwid']] = $log;
		}
		$apiServer = Ebh::app()->getApiServer('ebh');
		if (empty($queryarr['page']) || $queryarr['page'] == 1) {	//如果第一页，则附加用户最新的播放记录（可能是存在接口缓存中的）
			$newplayparam = array('uid'=>$uid,'crid'=>$crid);
			$newidlist = $apiServer->reSetting()->setService('Study.Log.newcourse')->addParams($newplayparam)->request();
			$newcwidlist = array();
			if (!empty($newidlist)) {
				foreach($newidlist as $newcwid) {
					if (isset($recordlist[$newcwid]))
						continue;
					$newcwidlist[] = $newcwid;
				}
			}
			if (!empty($newcwidlist)) {	//存在最新播放的课件编号，则从数据库中取
				$newrecordlist = array();
				$newcwids = implode(',',$newcwidlist);
				$newcwparam = array('crid'=>$crid,'cwids'=>$newcwids);
				$newrecordlist = $pmodel->getRoomCourseByIds($newcwparam);
				if (!empty($newrecordlist)) {
					foreach($newrecordlist as $newcourse) {	//存在的最新播放过的课件放到课件列表中
						$recordlist[$newcourse['cwid']] = $newcourse;
						$cwidlist[] = $newcourse['cwid'];
					}
				}
			}
		}
		
		$cwids = implode(',',$cwidlist);
		if (empty($cwids))
			return FALSE;
		
		$param = array('uid'=>$uid,'cwids'=>$cwids);
		//通过接口方式调用学习记录
		$loglist = $apiServer->reSetting()->setService('Study.Log.list')->addParams($param)->request();
		$resultlist = array();
		if(!empty($loglist)) {
			foreach($loglist as $cwid => $cwlog) {
				$recordlist[$cwid]['ltime'] = (!empty($recordlist[$cwid]['ltime'])&&($recordlist[$cwid]['ltime'] > $cwlog['ltime'])) ? $recordlist[$cwid]['ltime'] : $cwlog['ltime'];
				$recordlist[$cwid]['sumtime'] = (!empty($recordlist[$cwid]['sumtime'])&&($recordlist[$cwid]['sumtime'] > $cwlog['totalltime'])) ? $recordlist[$cwid]['sumtime'] : $cwlog['totalltime'];
				$recordlist[$cwid]['rcount'] = (!empty($recordlist[$cwid]['rcount'])&&($recordlist[$cwid]['rcount'] > $cwlog['playcount'])) ? $recordlist[$cwid]['rcount'] : $cwlog['playcount'];
				$recordlist[$cwid]['startdate'] = (!empty($recordlist[$cwid]['startdate'])&&($recordlist[$cwid]['startdate'] > $cwlog['startdate'])) ? $recordlist[$cwid]['startdate'] : $cwlog['startdate'];
				$resultlist[] = $recordlist[$cwid];
			}
		}
		return $resultlist;
	}
	/**
	 * 获取该用户在本网校下的课件学习记录列表记录数
	 */
	private function _getCourseRecordCount($crid,$uid) {
		$pmodel = $this->model('progress');
		$count = $pmodel->getRoomStudyCourseCount(array('crid'=>$crid,'uid'=>$uid));
		return $count;
	}
	/**
	 * 获取学生最新的播放的课件编号，由于这些可能还未加入到数据库，所以需要从接口直接取
	 * 避免最新播放的课件没有记录产生
	 */
	private function _getNewPlayCourse($crid,$uid) {
		$apiServer = Ebh::app()->getApiServer('ebh');
		$param = array('uid'=>$uid,'crid'=>$crid);
		//通过接口方式调用学习记录
		$cwidlist = $apiServer->reSetting()->setService('Study.Log.newcourse')->addParams($param)->request();
		return $cwidlist;
	}
}