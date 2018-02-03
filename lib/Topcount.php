<?php 
class Topcount {
	/*
	老师后台多个页面顶部使用的已学统计
	*/
	public function getTopcount($cwid,$t){
		$userscount = 0;
		$studycount = 0;
		$roominfo = Ebh::app()->room->getcurroom();
		
		$rcmodel = $t->model('roomcourse');
		$coursemodel = $t->model('Courseware');
		$folder = $rcmodel->getFolderByCwid($cwid,$roominfo['crid']);
        $cwdetail = $coursemodel->getcoursedetail($cwid);
		$redis = Ebh::app()->getCache('cache_redis');
        $viewnum = $redis->hget('coursewareviewnum',$cwdetail['cwid']);
        if(!empty($viewnum)){
            $cwdetail['viewnum'] = $viewnum;
        }
		$t->assign('cwdetail',$cwdetail);
		
		$foldermodel = $t->model('Folder');
		$myfolder = $foldermodel->getfolderbyid($folder['folderid']);
		$classid = Ebh::app()->getInput()->get('classid');
		$q = Ebh::app()->getInput()->get('q');
		if($roominfo['isschool'] == 7 && $roominfo['domain'] != 'khzx' && ($roominfo['property'] != 3 || $roominfo['property'] ==3 && empty($classid))){//如果分成学校，则获取已开通的学生
			$uidstr = '';
			if($myfolder['isschoolfree']==1 || $myfolder['fprice'] == 0){//免费
				if(empty($myfolder['grade'])){
					$grade = -1;
				}else{
					$grade = $myfolder['grade'];
				}
				$classmodel = $t->model('Classes');
				$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade,$q);
				if(!empty($userlist)){
					foreach($userlist as $uiditem) {
						if(empty($uidstr)) {
							$uidstr = $uiditem['uid'];
						} else {
							$uidstr .= ','.$uiditem['uid'];
						}
					}
					$userscount = count($userlist);//总人数
				}
			}else{
				$upmodel = $t->model('Userpermission');
				$uidlist = $upmodel->getUserIdListByFolder($folder['folderid']);
				if(!empty($uidlist)) {
					foreach($uidlist as $uiditem) {
						if(empty($uidstr)) {
							$uidstr = $uiditem['uid'];
						} else {
							$uidstr .= ','.$uiditem['uid'];
						}
					}
					$userlist = $upmodel->getUserAndClassListByUidStr($roominfo['crid'],$folder['folderid'],$uidstr,$q);
					$userscount = count($userlist);
				}
			}
		} elseif($roominfo['property'] == 3){//企业，按部门查询
			$param['classid'] = $classid;
			$param['crid'] = $roominfo['crid'];
			$param['q'] = $q;
			$list = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Enterprise.subDepartment')->addParams($param)->request();
			if($list !== FALSE){
				$classidarr = array_column($list,'classid');
				$classidarr[] = $classid;//加上本部门
				$classids = implode(',',$classidarr);
				$param['classids'] = $classids;
				$userlist = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Enterprise.subDeptUsers')->addParams($param)->request();
				$uidstr = implode(',',array_column($userlist,'uid'));
				$userscount = count($userlist);
			}
		} else {//否则获取课程对应年级的学生
			$grade = $myfolder['grade'];
			$classmodel = $t->model('Classes');
			if(!empty($grade)) {//按年级
				$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade,$q);
					
			}else{//按班级
				$classlist = $classmodel->getTeacherClassList($roominfo['crid'],$myfolder['uid']);
				$classids = '';
				foreach ($classlist as $c) {
					$classids .= $c['classid'].',';
				}
				$classids = rtrim($classids,',');
				$userlist = $classmodel->getClassStudentList(array('classidlist'=>$classids,'limit'=>1000,'q'=>$q));
			
			}
			if(!empty($userlist)){
				foreach($userlist as $uiditem) {
					if(empty($uidstr)) {
						$uidstr = $uiditem['uid'];
					} else {
						$uidstr .= ','.$uiditem['uid'];
					}
				}
			}
			$userscount = count($userlist);
		}
		
		
		$ltimemax=0;$ltimemin=0;$ltimeavg=0;
		if(!empty($cwid) && !empty($uidstr)){
			$plmodel = $t->model('Playlog');
			$playloglist = $plmodel->getCWStudynumByUidStr(array('cwids'=>$cwid,'uids'=>$uidstr));
			$playlogarr = array();
			$studycount = empty($playloglist[0]['count'])?0:$playloglist[0]['count'];
			
			
			//累计时长
			$sumlist = $plmodel->getCWSumltimeList(array('cwid'=>$cwid,'uids'=>$uidstr));
			//最长,最短,平均
			if(!empty($sumlist)){
				$ltimemax=0;
				$ltimemin=999999;
				$sum=0;
				foreach($sumlist as $sl){
					$sumltime = $sl['sumltime'];
					$ltimemax = max($sumltime,$ltimemax);
					$ltimemin = min($sumltime,$ltimemin);
					$sum += $sumltime;
					
					//时长分布
					$distrpart = ceil(round($sumltime/60)/10);
					$distrpart = $distrpart>7?7:(empty($distrpart)?1:$distrpart);
					
					$distrarr[$distrpart] = empty($distrarr[$distrpart])?1:++$distrarr[$distrpart];
				}
				$sumlistcount = count($sumlist);
				$ltimeavg = $sum/$sumlistcount;
				//时长分布处理
				for($i=1;$i<=7;$i++){
					$distrlist[$i] = round((empty($distrarr[$i])?0:$distrarr[$i])/$sumlistcount*100,1);
				}
			}
			// $s=601;
			// var_dump(ceil(round($s/60)/10));

			if(empty($distrlist))
				$distrlist = array(0,0,0,0,0,0,0);
		
			$t->assign('distrlist',$distrlist);
			
		}
		
		$t->assign('countset',array('studycount'=>$studycount,
										'userscount'=>$userscount,
										'ltimemax'=>round($ltimemax/60),
										'ltimemin'=>round($ltimemin/60),
										'ltimeavg'=>round($ltimeavg/60)
										));
		if(!empty($userlist)) {
			$userlistarr = array();
			foreach($userlist as $myuser) {
				if (!isset($userlistarr[$myuser['uid']])) {
					$userlistarr[$myuser['uid']] = $myuser;
				}
			}
			$t->userlist = $userlistarr;
		}
		return $uidstr;
	}
}
?>