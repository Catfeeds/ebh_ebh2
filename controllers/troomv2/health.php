<?php
/**
 * 教师后台体质健康控制器
 */
class HealthController extends CControl {
	public function __construct(){
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
	public function index(){
		//获取网校下的所有班级
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$roominfo = Ebh::app()->room->getcurroom();
		$page = intval($this->uri->uri_page());
		$keyword = $this->input->get('keywords');
		if($keyword == '请输入班级名称'){
			$keyword = '';
		}
		$keyword = empty($keyword)?'':$keyword;
		$this->assign('keywords',$keyword);
		$pagesize = 20;
		$limit = max(0,($page - 1)) * $pagesize . ','.$pagesize;
		$classlist = $classes->getSchoolClassListByuid($roominfo['crid'],$user['uid'],$limit,$keyword);
		$classcount = $classes->getSchoolClassCountListByuid($roominfo['crid'],$user['uid'],$keyword);
		$constitutionModel = $this->model('Constitution');
		//获取班级的体测数据份数
		$lists = $constitutionModel->getClassConstitutionCount($roominfo['crid']);
		if(!empty($lists)){
			foreach ($lists as $l) {
				$list[] = $l['cid'];
			}
			$list = array_count_values($list);
		}
		if(!empty($list)){
			foreach ($classlist as &$clist) {
				foreach ($list as $k=>$l) {
					if($clist['classid'] == $k){
						$clist['count'] = $l;
					}
				}
			}
		}
		$pagestr = show_page($classcount['count'],$pagesize);
		$this->assign('classlist',$classlist);
		$this->assign('page',$pagestr);
		//获取modulename
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'health','tors'=>1,'crid'=>$roominfo['crid']));
		$this->display('troomv2/health');
	}
	/**
	 * 查看班级统计
	 */
	public function view(){
		$classid = $this->uri->itemid;
		$classid = intval($classid);
		if(!empty($classid)){
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getloginuser();
			$roommodel = $this->model('classroom');
			$roomlist = $roommodel->getroomlistbytid($user['uid']);
			$constitutionModel = $this->model('Constitution');
			$classModel = $this->model('classes');
			$classdetail = $classModel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
			$lists = $constitutionModel->getConstitutionList($classid,$roominfo['crid']);
			$classname = '';
			if(!empty($classdetail)){
				$classname = $classdetail['classname'];
			}
			$this->assign('room',$roominfo);
			$this->assign('roomlist',$roomlist);
			$this->assign('classname',$classname);
			$this->assign('user',$user);
			$this->assign('lists',$lists);
			$this->display('aroomv2/class_statistics');
		}
	}
	/**
	 * 查看学生
	 */
	public function student_view(){
		$classid = $this->uri->itemid;
		$classid = intval($classid);
		$this->assign('classid',$classid);
		if(!empty($classid)){
			$roominfo = Ebh::app()->room->getcurroom();
			$page = intval($this->uri->uri_page());
			if(empty($page)){
				$page = 1;
			}
			$keyword = $this->input->get('keywords');
			if($keyword == '请输入账号或姓名'){
				$keyword = '';
			}
			$keyword = $this->input->get('keywords');
			if($keyword == '请输入账号或姓名'){
				$keyword = '';
			}
			$keyword = empty($keyword)?'':$keyword;
			$this->assign('keywords',$keyword);
			$pagesize = 20;
			$limit = max(0,($page - 1)) * $pagesize . ','.$pagesize;
			$constitutionModel = $this->model('Constitution');
			$commentlist = $this->model('healthcomment');
			$studentList = $constitutionModel->getStudentDateBycid($classid,$roominfo['crid'],$keyword);
			$classmodel = $this->model('classes');
			$studentlistall = $classmodel->getClassStudentList(array('classid'=>$classid,'limit'=>9999,'q'=>$keyword));
			$studentcomment = $commentlist->getStudentCommentByclassid($classid,$roominfo['crid']);
			foreach ($studentlistall as &$all) {
				foreach ($studentList as $list) {
					if($list['uid'] == $all['uid']){
						$all['count'] = $list['count'];
						break;
					}else{
						$all['count'] = 0;
					}
				}
				foreach ($studentcomment as $comment) {
					if($all['uid'] == $comment['uid']){
						$all['commentcount'] = $comment['count'];
						break;
					}else{
						$all['commentcount'] = 0;
					}
				}
			}
			$studentlistall1 = array_chunk($studentlistall,20);
			$studentcount = $classmodel->getClassStudentCount(array('classid'=>$classid,'q'=>$keyword));
			$studentlist = empty($studentlistall1[$page-1])?array():$studentlistall1[$page-1];
			$pagestr = show_page($studentcount,$pagesize);
			$this->assign('pagestr',$pagestr);
			$this->assign('studentlist',$studentlist);
			$this->display('troomv2/student_health_view');
		}
	}
	/**
	 * 查看学生详情
	 */
	public function student_detail_view(){
		$uid = $this->uri->itemid;
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
			if(!empty($result)){
				foreach ($result as $key => $re) {
					$syidstr.=$key.',';
				}
				$syidstr = rtrim($syidstr,',');
				$syModel = $this->model('schoolyear');
				$sylist = $syModel->getSchoolYearListByStr($syidstr);
				krsort($sylist);
			}
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
			$this->display('aroomv2/student_detail_view');
		}
	}
	/**
	 * [student_comment_view 显示教师评价页面]
	 * @return [type] [description]
	 */
	public function student_comment_view(){
		$uid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(!empty($uid) && is_numeric($uid)){
			$commentModel = $this->model('healthcomment');
			$usermodel = $this->model('user');
			$userinfo = $usermodel->getuserbyuid($uid);
			$page = intval($this->uri->uri_page());
			$page = empty($page)?1:$page;
			$pagesize = 20;
			$commentList = $commentModel->getcommentlist($uid,$roominfo['crid'],$page);
			$commentcount = $commentModel->getcommentcount($uid,$roominfo['crid']);
			$pagestr = show_page($commentcount['count'],$pagesize);
			$username = empty($userinfo['realname'])?$userinfo['username']:$userinfo['realname'];
			$this->assign('username',$username);
			$this->assign('commentlist',$commentList);
			$this->assign('pagestr',$pagestr);
			$this->assign('room',$roominfo);
			$this->assign('roominfo',$roominfo);
			$this->assign('user',$user);
			$this->assign('studentid',$uid);
			$this->display('troomv2/student_health_comment');

		}
	}
	/*
	ajax添加评价
	 */
	public function comment_add(){
		$tid = (int)$this->input->post('tid');		
		$studentid = (int)$this->input->post('studentid');
		$type = (int)$this->input->post('type');
		$type = empty($type)?0:$type;
		$roominfo = Ebh::app()->room->getcurroom();
		$classModel = $this->model('Classes');
		if(!empty($roominfo['crid']) && !empty($studentid)){
			$classinfo = $classModel->getClassByUid($roominfo['crid'],$studentid);
			$classid = $classinfo['classid'];
		}
		if($type == 0){//直接录入
			$comment = $this->input->post('comment');
			$comment = trim($comment);
			$slen = mb_strlen($comment,'utf-8');
			if($slen > 800){
				echo json_encode(array('status'=>0,'msg'=>'点评字数超过800，请重试'));
			}
			$comment = strip_tags(h($comment));
			$commentModel = $this->model('healthcomment');
			$param = array();
			$param['teacherid'] = $tid;
			$param['studentid'] = $studentid;
			$param['type'] = $type;
			$param['comment'] = $comment;
			$param['dateline'] = SYSTIME;
			$param['classid'] = $classid;
			if(!empty($roominfo)){
				$param['crid'] = $roominfo['crid'];
			}
			$hid = $commentModel->addcomment($param);
			if(!empty($hid)){
				$user = Ebh::app()->user->getloginuser();
				$param['teachername'] = empty($user['realname'])?$user['username']:$user['realname'];
				$param['commentcheck'] = shortstr($param['comment'],800);
				$param['dateline'] = date('Y-m-d',$param['dateline']);
				$param['hid'] = $hid;
				echo json_encode(array('status'=>1,'data'=>$param));
				exit;
			}
		}
		if($type == 1){//导入文件
			$sid = (int)$this->input->post('sid');
			$filename = $this->input->post('filename');
			$commentModel = $this->model('healthcomment');
			$param = array();
			$param['teacherid'] = $tid;
			$param['studentid'] = $studentid;
			$param['type'] = $type;
			$param['filename'] = $filename;
			$param['sid'] = $sid;
			$param['dateline'] = SYSTIME;
			$param['classid'] = $classid;
			if(!empty($roominfo)){
				$param['crid'] = $roominfo['crid'];
			}
			$hid = $commentModel->addcomment($param);
			if(!empty($hid)){
				$user = Ebh::app()->user->getloginuser();
				$param['teachername'] = empty($user['realname'])?$user['username']:$user['realname'];
				$param['filename'] = $filename;
				$param['dateline'] = date('Y-m-d',$param['dateline']);
				$param['hid'] = $hid;
				$param['sid'] = $sid;
				echo json_encode(array('status'=>1,'data'=>$param));
				exit;
			}
		}
		echo json_encode(array('status'=>0,'msg'=>'添加失败！请重试'));
		exit;
	}
	/**
	 * 下载文件
	 */
	public function download_view(){
		$sid = (int)$this->uri->itemid;
		$SourceModel = $this->model('source');
		$source = $SourceModel->getFileBySid($sid);
		if(!empty($source)){
			echo getfile('attachment',$source['filepath'],$source['filename']);
		}
	}
}