<?php
/**
 * 学生后台体质健康控制器
 */
class HealthController extends CControl {
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$uid = $user['uid'];
		$roominfo = Ebh::app()->room->getcurroom();
		if(!empty($uid)){
			$usermodel = $this->model('user');
			$userinfo = $usermodel->getuserbyuid($uid);
			$classmodel = $this->model('classes');
			$classinfo = $classmodel->getClassByUid($roominfo['crid'],$uid);
			$constitutionModel = $this->model('constitution');
			$fieldord = $param['field'] = $this->input->get('field');
			$fieldord = empty($param['field'])?'total':$param['field'];
			$param['field'] = empty($param['field'])?'total':$param['field'];
			$param['by'] = $this->input->get('by');
			$by = '';
			$by = $param['by'] = empty($param['by'])?'':$param['by'];
			$this->assign('by',$param['by']);
			if($param['field'] == 'total' ||$param['field'] == 'height'){//total和height 没有评分选项

			}else{
				if($param['by'] == 'score'){
					$param['field'] = $param['field'].'_'.$param['by'];
				}
			}
			$data = $constitutionModel->getStudentRank($classinfo['classid'],$uid,$param);//获取班级中所有学生的各年信息
			if(!empty($data)){
				$dataarr = array();
				foreach ($data as $dt) {
					$dataarr[$dt['syid']][$dt['uid']] = $dt[$param['field']];
				}
				foreach ($dataarr as $k => $dta) {
					if($param['field'] == 'running50' || $param['field']=='running50_8'){//跑步时间越长排越后面
						asort($dta);
					}else{
						arsort($dta);
					}
					$i = 0;
					if($param['field'] == 'total' || $param['field'] == 'height'){
						foreach ($dta as $kuid => $res) {
							$i++;
							if($kuid == $uid){
								$result[$k][$param['field']] = $res;
								$result[$k]['rank'] = $i;
								$result[$k]['uid'] = $uid;
							}	
						}
					}else{
						if(strstr($param['field'],'_score')){
							$field = strstr($param['field'],'_score',true);
						}else{
							$field = $param['field'].'_score';
						}
						foreach ($dta as $kuid => $res) {
							$i++;
							if($kuid == $uid){
								$result[$k][$param['field']] = $res;
								$result[$k]['rank'] = $i;
								$result[$k]['uid'] = $uid;
							}	
						}
						foreach ($data as $k1 => $v1) {
							foreach ($result as $k2 => $v2) {
								if($v2['uid'] == $v1['uid'] && $v1['syid'] == $k2){
									$result[$k2][$field] = $v1[$field];
								}
							}
						}
					}
				}
			}
			$syidstr = '';
			$resarr = array();
			$xAxis = '';
			if(!empty($result)){
				foreach ($result as $key => $re) {
					$syidstr.=$key.',';
				}
				$syidstr = rtrim($syidstr,',');
				$syModel = $this->model('schoolyear');
				$sylist = $syModel->getSchoolYearListByStr($syidstr);
				krsort($sylist);
				$resarr = array();//最后展现的结果
				$xAxis = '';
				foreach ($sylist as $value) {//对数组进行取前六个的排序
					foreach ($result as $key => $res) {
						if($key == $value['syid']){
							$res['syname'] = $value['syname'];
							$resarr[] = $res;
							$xAxis.= '\''.$value['syname'].'\',';
						}
					}
				}
				if(!empty($xAxis)){
					$xAxis = rtrim($xAxis,',');
				}
			}
			$this->assign('result',$resarr);
			$this->assign('xAxis',$xAxis);
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getloginuser();
			$roommodel = $this->model('classroom');
			$roomlist = $roommodel->getroomlistbytid($user['uid']);
			$this->assign('field',$param['field']);
			$this->assign('fieldord',$fieldord);
			$this->assign('room',$roominfo);
			$this->assign('roomlist',$roomlist);
			$this->assign('user',$user);
			$this->assign('student',$userinfo);
			$this->display('college/health_analysis');
		}
	}
}