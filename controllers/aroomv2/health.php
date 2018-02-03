<?php
/**
 * 体质健康控制器
 */
class HealthController extends CControl{
	public function __construct(){
        parent::__construct();
        Ebh::app()->room->checkRoomControl();
    }
	/**
	 * 管理员体质健康首页方法
	 */
	public function index(){
		//获取网校下的所有班级
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
		$classlist = $classes->getSchoolClassList($roominfo['crid'],$limit,$keyword);
		$classcount = $classes->getSchoolClassCount($roominfo['crid'],$limit,$keyword);
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
		$this->display('aroomv2/health');
	}
	/**
	 * 添加学年
	 */
	public function addschoolyear(){
		$schoolyear = intval($this->input->post('schoolyear'));
		if(empty($schoolyear)){
			echo json_encode(array('status'=>0,'msg'=>'学年不能为空！'));
		}
		if(!is_numeric($schoolyear)){
			echo json_encode(array('status'=>0,'msg'=>'学年只能为数字！'));
		}
		$roominfo = Ebh::app()->room->getcurroom();
		if(!empty($roominfo)){
			//检查学年是否已经存在
			$syModel = $this->model('Schoolyear');
			$check = $syModel->checkSchoolYear($roominfo['crid'],$schoolyear);
			if($check){
				echo json_encode(array('status'=>0,'msg'=>'学年已存在！请更换...'));
				exit;
			}
			$syid = $syModel->addSchoolYear($roominfo['crid'],$schoolyear);
			if($syid){
				echo json_encode(array('status'=>1,'id'=>$syid));
				exit;
			}
		}
		echo json_encode(array('status'=>0,'msg'=>'学年添加失败！请重试...'));
	}
	/**
	 * 学生名单的导入
	 */
	public function input(){
		if($this->input->post()){
			$msg = $this->input->post();
			$errormsg = '';
			$errorarr =array();
			$inputresult = array('errormsg'=>$errormsg);
			$schoolyearModel = $this->model('schoolyear');
			if(!empty($msg['select'])){
				$status = $schoolyearModel->checkStatusBySyid($msg['select']);
			}
			if(empty($msg['image']['upfilepath']) || empty($msg['select'])) {
				$errormsg = '错误：请选择要上传的文件或学年为空';
			}else if(empty($status) || $status['status'] == 1){
				$errormsg = '错误：该学年已经被锁定';
			} else {
					$excelModel = $this->model('Excelsources');
					$fid = $msg['image']['upfilepath'];
					$excel = $excelModel->getExcelByFid($msg['image']['upfilepath']);
					if(!empty($excel)){
						$excelpath = $excel['filepath'];
						$roominfo = Ebh::app()->room->getcurroom();
						$iresult = $this->inputstudent($excelpath,$roominfo['crid'],$msg['select'],$fid);
						if($iresult['status'] != 'success') {	//导入不成功
							switch ($iresult['status']) {
								case 'wrong':
									$errormsg = '文件内容不正确，请按照系统提供的导入模板格式进行上传。';
									break;
								case 'notInRoom'://平台上没有导入的学生信息
									$errorarr = $iresult['data'];
									$errormsg = 3; 
									break;
								case 'repeat'://导入的信息有重复
									$data = array();
									if(!empty($iresult)){
										$data = array_count_values($iresult['data']);
									}
									$errorarr = $data;
									$errormsg = 2;
									break;
								case 'studentNotinRoom' :
									$errorarr = $iresult['data'];
									$errormsg = 1;
									break;
								case 'error' :
									$errormsg = '导入失败，请检查excel格式，内容是否正确...';
									break;
								case 'nostudent':
									$errormsg = '平台上没有学生，请先进行添加!';
									break;
								case 'empty':
									$errorarr = $iresult['data'];
									$errormsg = 4;
									break;
							}
						}else{//把学年锁定
							$schoolyearModel = $this->model('schoolyear');
							$res = $schoolyearModel->changeStatusBySyid($msg['select']);
							$this->assign('success',$iresult);
						}
					}
					
			}
			$inputresult['errormsg'] = $errormsg;
			if(!empty($errorarr)){
				$inputresult['errorarr'] = $errorarr;
			}
			$this->assign('inputresult',$inputresult);
			$roominfo = Ebh::app()->room->getcurroom();
			$syModel = $this->model('Schoolyear');
			$sylist = $syModel->getSchoolYearList($roominfo['crid']);
			$sylist = empty($sylist)?array():$sylist;
			$this->assign('sylist',$sylist);
		}else{
			$roominfo = Ebh::app()->room->getcurroom();
			$syModel = $this->model('Schoolyear');
			$sylist = $syModel->getSchoolYearList($roominfo['crid']);
			$sylist = empty($sylist)?array():$sylist;
			$this->assign('sylist',$sylist);
		}
		$upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('upcontrol',$upcontrol);
		$this->display('aroomv2/adddata');
	}
	
	/**
	 * excel文件读取操作
	 */
	public function getexcelfile($fid){
	    $data = false;
	    $upconfig = Ebh::app()->getConfig()->load('upconfig');
	    $downurl = $upconfig['health']['down'];
	    $key = authcode($fid, 'ENCODE');
	    $body = file_get_contents($downurl.'?key='.urlencode($key));
	    if(!empty($body)){
	        $file = $upconfig['health']['savepath'].'/' .$fid.'.xls';
	        if(file_put_contents($file, $body)){
	            require_once(LIB_PATH.'PHPExcel.php');
	            Ebh::app()->helper('excel');
	            $excel = new excel($file);
	            $data = $excel->excel2array();
	        }
	    }
	    return $data;
	}
	
	/**
	 * [inputstudent 导入学生体质数据]
	 * @param  [type] $filepath [description]
	 * @param  [type] $crid     [description]
	 * @param  [type] $syid     [description]
	 * @return [type]           [description]
	 */
	function inputstudent($filepath,$crid,$syid,$fid){
	    $upconfig = Ebh::app()->getConfig()->load('upconfig');
	    //先读取文件
	    $data= $this->getexcelfile($fid);
		//excel
		if(false == $data){
			return array('status'=>'error');
		}
		if(!empty($data)){
			if(!empty($data)){
				array_shift($data);//去掉第一项列表名
			}
		}
		$repeatarr = array();
		$empty = array();
		$repeat = '';
		foreach ($data as $key => $da) {
			$repeat = trim($da[2]).'-'.trim($da[5]);
			if($repeat != trim($repeat,'-')){
				$empty[$key+2] = $repeat;
			}
			$repeatarr[] = $repeat;
		}
		//检验是否存在班级或姓名为空的
		if(!empty($empty)){
			return array('status'=>'empty','data'=>$empty);
		}
		//检验是否存在同班级中相同名字
		$unique_arr = array_unique($repeatarr);
		$arr = array_diff_assoc($repeatarr,$unique_arr);
		if(!empty($arr)){//若在同个班级中存在相同的名字，则返回
			return array('status'=>'repeat','data'=>$arr);
		}
		
		//检查班级信息
		foreach ($unique_arr as &$u_arr) {
			$u_arr = explode('-',$u_arr);
		}//key = 0 班级名 key = 1 学生名字
		$classList = $this->model('classes')->getroomClassList($crid);
		$classlistarr = array();
		$findarr = array();
		if(!empty($classList)){
			foreach ($classList as $clist) {
				$classlistarr[$clist['classid']] = $clist['classname'];
				$classlistarr1 = array_flip($classlistarr);
				foreach ($unique_arr as $un_arr) {
					if($un_arr[0] == $clist['classname']){
						$findarr[$clist['classid']][] = $un_arr[1];
					}
				}
			}
		}
		$classarr = array();
		foreach ($classList as $clist) {
			array_push($classarr,$clist['classname']);
		}
		$notInRoom = array();//平台上没有的班级列表
		foreach ($unique_arr as $unique) {
			if(!in_array($unique[0],$classarr)){
				array_push($notInRoom,$unique[0]);
				$notInRoom = array_unique($notInRoom);	
			}
		}
		if(!empty($notInRoom)){//如果有班级不存在平台上，则返回
			return array('status'=>'notInRoom','data'=>$notInRoom);
		}
		$memberModel = $this->model('Member');
		$notatroom = array();
		$userlist = array();
		foreach ($findarr as $k => $find) {//按班级查询
			$realnamestr = '';
			foreach ($find as $fd) {
				$realnamestr.= '\''.$fd.'\',';
			}
			$realnamestr = rtrim($realnamestr,',');
			$checkarr = $memberModel->getStudentInfoByClassid($k,$realnamestr);
			$checkcount = count($checkarr);
			if($checkcount != count($findarr[$k])){//若人数不相同则说明数据表中有学生不在班级中
				$inarr = array();
				foreach ($checkarr as $carr) {
					$array = array();
					array_push($inarr,$carr['realname']);
				}
				$array = array_diff($find,$inarr);
				$notatroom[$k][] = $array;
			}else{
				$userlist[$k] = $checkarr;
			}	
		}
		if(!empty($notatroom)){//若有学生不在班级中则返回
			$notroomarr = array();
			foreach ($notatroom as $key => $room) {
				$notroomarr[$classlistarr[$key]] = $room;
			}
			return array('status'=>'studentNotinRoom','data'=>$notroomarr);
		}
		//开始构建导入的数据数组		
		$titlearr =array(
			'gradeid','classid','classname','studentcode','nationalcode','studentname','sex','birthdate','address','height','weight','weight_score','weight_grade','vitalcapacity','vitalcapacity_score','vitalcapacity_grade','running50','running50_score','running50_grade','sit_and_reach','sit_and_reach_score','sit_and_reach_grade','running50_8','running50_8_score','running50_8_grade','situp','situp_score','situp_grade','situp_extras','jump','jump_score','jump_grade','jump_extras','standard','extras','total','total_grade'
		);//键名组数
		$datacomp = array();
		foreach ($data as &$dt) {
			$dt = array_combine($titlearr,$dt);
			$dt['gradeid'] = empty($dt['gradeid'])?0:trim($dt['gradeid']);
			$dt['classid'] = empty($dt['classid'])?0:trim($dt['classid']);
			$dt['classname'] = empty($dt['classname'])?'':trim($dt['classname']);
			$dt['studentcode'] = empty($dt['studentcode'])?'':trim($dt['studentcode']);
			$dt['nationalcode'] = empty($dt['nationalcode'])?0:trim($dt['nationalcode']);
			$dt['studentname'] = empty($dt['studentname'])?'':trim($dt['studentname']);
			if(!empty($dt['sex'])){
				if($dt['sex'] == 1){
					$dt['sex'] = 0;
				}else{
					$dt['sex'] = 1;
				}
			}else{
				$dt['sex'] = 0;//默认为男性
			}
			$dt['birthdate'] = empty($dt['birthdate'])?'':trim($dt['birthdate']);
			$dt['birthdate'] = str_replace('/','-',$dt['birthdate']);
			$dt['address'] = empty($dt['address'])?'':trim($dt['address']);
			$dt['height'] = empty($dt['height'])?0:trim($dt['height']);
			$dt['weight'] = empty($dt['weight'])?0:trim($dt['weight']);
			$dt['weight_score'] = empty($dt['weight_score'])?0:trim($dt['weight_score']);
			$dt['weight_grade'] = empty($dt['weight_grade'])?'':trim($dt['weight_grade']);
			if(!empty($dt['weight_grade'])){
				$dt['weight_grade'] = $this->_changeScore($dt['weight_grade'],array('正常'=>'a','超重'=>'b','低体重'=>'c','肥胖'=>'d'));
			}
			if(!empty($running50_8)){
				$running50_8 = $this->exchange50_8($running50_8);
			}
			$dt['vitalcapacity'] = empty($dt['vitalcapacity'])?0:trim($dt['vitalcapacity']);
			$dt['vitalcapacity_score'] = empty($dt['vitalcapacity_score'])?0:trim($dt['vitalcapacity_score']);
			$dt['vitalcapacity_grade'] = empty($dt['vitalcapacity_grade'])?'':trim($dt['vitalcapacity_grade']);
			if(!empty($dt['vitalcapacity_grade'])){
				$dt['vitalcapacity_grade'] = $this->_changeScore($dt['vitalcapacity_grade'],array('优秀'=>'a','良好'=>'b','及格'=>'c','不及格'=>'d'));
			}
			$dt['running50'] = empty($dt['running50'])?0:trim($dt['running50']);
			$dt['running50_score'] = empty($dt['running50_score'])?0:trim($dt['running50_score']);
			$dt['running50_grade'] = empty($dt['running50_grade'])?'':trim($dt['running50_grade']);
			if(!empty($dt['running50_grade'])){
				$dt['running50_grade'] = $this->_changeScore($dt['running50_grade'],array('优秀'=>'a','良好'=>'b','及格'=>'c','不及格'=>'d'));
			}
			$dt['sit_and_reach'] = empty($dt['sit_and_reach'])?0:trim($dt['sit_and_reach']);
			$dt['sit_and_reach_score'] = empty($dt['sit_and_reach_score'])?0:trim($dt['sit_and_reach_score']);
			$dt['sit_and_reach_grade'] = empty($dt['sit_and_reach_grade'])?'':trim($dt['sit_and_reach_grade']);
			if(!empty($dt['sit_and_reach_grade'])){
				$dt['sit_and_reach_grade'] = $this->_changeScore($dt['sit_and_reach_grade'],array('优秀'=>'a','良好'=>'b','及格'=>'c','不及格'=>'d'));
			}
			$dt['running50_8'] = empty($dt['running50_8'])?0:trim($dt['running50_8']);
			$dt['running50_8'] = $this->exchange50_8($dt['running50_8']);
			$dt['running50_8_score'] = empty($dt['running50_8_score'])?0:trim($dt['running50_8_score']);
			$dt['running50_8_grade'] = empty($dt['running50_8_grade'])?'':trim($dt['running50_8_grade']);
			if(!empty($dt['running50_8_grade'])){
				$dt['running50_8_grade'] = $this->_changeScore($dt['running50_8_grade'],array('优秀'=>'a','良好'=>'b','及格'=>'c','不及格'=>'d'));
			}
			$dt['situp'] = empty($dt['situp'])?0:trim($dt['situp']);
			$dt['situp_score'] = empty($dt['situp_score'])?0:trim($dt['situp_score']);
			$dt['situp_grade'] = empty($dt['situp_grade'])?'':trim($dt['situp_grade']);
			if(!empty($dt['situp_grade'])){
				$dt['situp_grade'] = $this->_changeScore($dt['situp_grade'],array('优秀'=>'a','良好'=>'b','及格'=>'c','不及格'=>'d'));
			}
			$dt['situp_extras'] = empty($dt['situp_extras'])?0:trim($dt['situp_extras']);
			$dt['jump'] = empty($dt['jump'])?0:trim($dt['jump']);
			$dt['jump_score'] = empty($dt['jump_score'])?0:trim($dt['jump_score']);
			$dt['jump_grade'] = empty($dt['jump_grade'])?'':trim($dt['jump_grade']);
			if(!empty($dt['jump_grade'])){
				$dt['jump_grade'] = $this->_changeScore($dt['jump_grade'],array('优秀'=>'a','良好'=>'b','及格'=>'c','不及格'=>'d'));
			}
			$dt['jump_extras'] = empty($dt['jump_extras'])?0:trim($dt['jump_extras']);
			$dt['standard'] = empty($dt['standard'])?0:trim($dt['standard']);
			$dt['extras'] = empty($dt['extras'])?0:trim($dt['extras']);
			$dt['total'] = empty($dt['total'])?0:trim($dt['total']);
			$dt['total_grade'] = empty($dt['total_grade'])?'':trim($dt['total_grade']);
			if(!empty($dt['total_grade'])){
				$dt['total_grade'] = $this->_changeScore($dt['total_grade'],array('优秀'=>'a','良好'=>'b','及格'=>'c','不及格'=>'d'));
			}
			$dt['syid'] = $syid;
			$dt['crid'] = $crid;
			foreach ($userlist[$classlistarr1[$dt['classname']]] as &$ulist) {
				if($dt['studentname'] == $ulist['realname']){
					$dt['uid'] = $ulist['memberid'];
					$dt['cid'] = $ulist['classid'];
					unset($ulist);
					break;
				}
			}
		}
		//p($data);die;
		//写入数据
		$constitutionModel = $this->model('Constitution');
		$res = $constitutionModel->addMultipleConstitution($data,$fid);
		if($res){
			return array('status'=>'success','data'=>count($data));
		}else{
			return array('status'=>'error');
		}
	}
	/**
	 * 将成绩转换成a b c 形式
	 */
	private function _changeScore($change,$setarr){
		if(empty($change) || empty($setarr)){
			return false;
		}
		if(isset($setarr[$change]))
			return $setarr[$change];
		else
			return false;
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
			$lists = $constitutionModel->getConstitutionList($classid,$roominfo['crid']);
			$classname = '';
			$classModel = $this->model('classes');
			$classdetail = $classModel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
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
			$this->display('aroomv2/student_view');
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
			if(!empty($sylist)){
				foreach ($sylist as $value) {//对数组进行取前六个的排序
					foreach ($result as $key => $res) {
						if($key == $value['syid']){
							$res['syname'] = $value['syname'];
							$resarr[] = $res;
							$xAxis.= '\''.$value['syname'].'\',';
						}
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
	 * 班级的分析统计图
	 */
	public function getClassStatisticsByajax(){
		$cid = $this->input->post('cid');
		$syid = $this->input->post('syid');
		$type= $this->input->post('type');
		$field = $this->input->post('field');
		$type = empty($type)?'grade':$type;
		$field = empty($field)?'total':$field;
		$param['type'] = $type;
		$param['field'] = $field;
		//获取学年信息
		$syModel = $this->model('Schoolyear');
		$syinfo = $syModel->getSchoolYearInfoBySyid($syid);

		$constitutionModel = $this->model('constitution');
		$data = $constitutionModel->getClassData($cid,$syid,$param);
		$field1 = '';
		if($param['field'] == 'height'){
			$field1 = $param['field'];
		}else{
			$field1 = $param['field'].'_'.$param['type'];
		}
		if($param['field'] == 'total' && $param['type'] == 'score'){
			$field1 = $param['field'];
		}
		$res = array();
		$a = 0;
		$b = 0;
		$c = 0;
		$d = 0; 
		if(!empty($data) && $field1 != 'height' && $param['type'] == 'grade'){
			foreach ($data as $dt) {
				if($dt[$field1] == 'a'){
					$a++;
				}else if($dt[$field1] == 'b'){
					$b++;
				}else if($dt[$field1] == 'c'){
					$c++;
				}else if($dt[$field1] == 'd'){
					$d++;
				}
			}
			echo json_encode(array('a'=>$a,'b'=>$b,'c'=>$c,'d'=>$d));
			exit();
		}
		if(!empty($data) && $param['type'] == 'score'){
			foreach ($data as $key => &$value) {
				if($value['face'] == ''){//默认头像
					if($value['sex'] == 0){
						$value['face'] = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg';
					}else{
						$value['face'] = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg';
					}
				}
			}
			echo json_encode($data);
			exit();
		}
		
	}
	/**
	 * 导出excel
	 */
	public function outputExcel(){
		$cid = intval($this->input->get('cid'));
		$syid = intval($this->input->get('syid'));
        if($syid <= 0 || $cid <= 0) {
            echo '导出失败';
            exit;
        }
        $classModel = $this->model('Classes');
        $classinfo = $classModel->getClassInfo($cid);
        $constitutionModel = $this->model('constitution');
		$condata = $constitutionModel->getListBycid($cid,$syid);
		$syModel = $this->model('Schoolyear');
		$syinfo = $syModel->getSchoolYearInfoBySyid($syid);
		if($condata == false){
			echo '导出失败';
            exit;
		}
        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            '年级编号',
            '班级编号',
            '班级名称',
            '学籍号',
            '民族代码',
            '姓名',
            '性别',
            '出生日期',
            '家庭住址',
            '身高',
            '体重',
            '体重评分',
            '体重等级',
            '肺活量',
            '肺活量评分',
            '肺活量等级',
            '50米跑',
            '50米跑评分',
            '50米跑等级',
            '坐位体前屈',
            '坐位体前屈评分',
            '坐位体前屈等级',
            '50米×8往返跑',
            '50米×8往返跑评分',
            '50米×8往返跑等级',
            '一分钟仰卧起坐',
            '一分钟仰卧起坐评分',
            '一分钟仰卧起坐等级',
            '一分钟仰卧起坐附加分',
            '一分钟跳绳',
            '一分钟跳绳评分',
            '一分钟跳绳等级',
            '一分钟跳绳附加分',
            '标准分',
            '附加分',
            '总分',
            '总分等级'
        );
        $roominfo = Ebh::app()->room->getcurroom();
        $name = '学生体测数据表';
        if(!empty($classinfo) && !empty($roominfo)){
        	$name = $roominfo['crname'].$classinfo['classname'] .$syinfo['syname']. "学年学生体测数据表";
        }
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("V")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("W")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("X")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("Y")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("Z")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AA")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AB")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AC")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AD")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AE")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AF")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AG")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AH")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AI")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AJ")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("AK")->setAutoSize(true);
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);
        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'1';//列A1,B1,C1,D1
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }

        
        $column_count = count($titleArr);

        //传值
        if(is_array($condata)){
            foreach ($condata as $index => $row) {
                $str = "A";
                for($i = 0; $i < $column_count; $i++) {
                    $p = $str . ($index + 2);
                    if ($str == 'A') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['gradeid']);
                        $str++;
                        continue;
                    }
                    if ($str == 'B') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['classid']);
                        $str++;
                        continue;
                    }
                    if ($str == 'C') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['classname']);
                        $str++;
                        continue;
                    }
                    if ($str == 'D') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['studentcode']);
                        $str++;
                        continue;
                    }
                    if ($str == 'E') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['nationalcode']);
                        $str++;
                        continue;
                    }
                    if ($str == 'F') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['studentname']);
                        $str++;
                        continue;
                    }
                    if ($str == 'G') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['sex']);
                        $str++;
                        continue;
                    }
                    if ($str == 'H') {
                    	if(!empty($row['birthdate'])){
                    		$row['birthdate'] = str_replace('-','/',$row['birthdate']);
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['birthdate']);
                        $str++;
                        continue;
                    }
                    if ($str == 'I') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['address']);
                        $str++;
                        continue;
                    }
                    if ($str == 'J') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['height']);
                        $str++;
                        continue;
                    }
                    if ($str == 'K') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['weight']);
                        $str++;
                        continue;
                    }
                    if ($str == 'L') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['weight_score']);
                        $str++;
                        continue;
                    }
                    if ($str == 'M') {
                    	if(!empty($row['weight_grade'])){
                    		$row['weight_grade'] = $this->_changeScore($row['weight_grade'],array('a'=>'正常','b'=>'超重','c'=>'低体重','d'=>'肥胖'));
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['weight_grade']);
                        $str++;
                        continue;
                    }
                    if ($str == 'N') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['vitalcapacity']);
                        $str++;
                        continue;
                    }
                    if ($str == 'O') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['vitalcapacity_score']);
                        $str++;
                        continue;
                    }
                    if ($str == 'P') {
                    	if(!empty($row['vitalcapacity_grade'])){
                    		$row['vitalcapacity_grade'] = $this->_changeScore($row['vitalcapacity_grade'],array('a'=>'优秀','b'=>'良好','c'=>'及格','d'=>'不及格'));
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['vitalcapacity_grade']);
                        $str++;
                        continue;
                    }
                    if ($str == 'Q') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['running50']);
                        $str++;
                        continue;
                    }
                    if ($str == 'R') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['running50_score']);
                        $str++;
                        continue;
                    }
                    if ($str == 'S') {
                    	if(!empty($row['running50_grade'])){
                    		$row['running50_grade'] = $this->_changeScore($row['running50_grade'],array('a'=>'优秀','b'=>'良好','c'=>'及格','d'=>'不及格'));
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['running50_grade']);
                        $str++;
                        continue;
                    }
                    if ($str == 'T') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['sit_and_reach']);
                        $str++;
                        continue;
                    }
                    if ($str == 'U') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['sit_and_reach_score']);
                        $str++;
                        continue;
                    }
                    if ($str == 'V') {
                    	if(!empty($row['sit_and_reach_grade'])){
                    		$row['sit_and_reach_grade'] = $this->_changeScore($row['sit_and_reach_grade'],array('a'=>'优秀','b'=>'良好','c'=>'及格','d'=>'不及格'));
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['sit_and_reach_grade']);
                        $str++;
                        continue;
                    }
                    if ($str == 'W') {
                    	if(!empty($row['running50_8'])){
                    		$row['running50_8'] = $this->exchange50_8_to($row['running50_8']);
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['running50_8']);
                        $str++;
                        continue;
                    }
                    if ($str == 'X') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['running50_8_score']);
                        $str++;
                        continue;
                    }
                    if ($str == 'Y') {
                    	if(!empty($row['running50_8_grade'])){
                    		$row['running50_8_grade'] = $this->_changeScore($row['running50_8_grade'],array('a'=>'优秀','b'=>'良好','c'=>'及格','d'=>'不及格'));
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['running50_8_grade']);
                        $str++;
                        continue;
                    }
                    if ($str == 'Z') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['situp']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AA') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['situp_score']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AB') {
                    	if(!empty($row['situp_grade'])){
                    		$row['situp_grade'] = $this->_changeScore($row['situp_grade'],array('a'=>'优秀','b'=>'良好','c'=>'及格','d'=>'不及格'));
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['situp_grade']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AC') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['situp_extras']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AD') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['jump']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AE') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['jump_score']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AF') {
                    	if(!empty($row['jump_grade'])){
                    		$row['jump_grade'] = $this->_changeScore($row['jump_grade'],array('a'=>'优秀','b'=>'良好','c'=>'及格','d'=>'不及格'));
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['jump_grade']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AG') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['jump_extras']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AH') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['standard']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AI') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['extras']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AJ') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['total']);
                        $str++;
                        continue;
                    }
                    if ($str == 'AK') {
                    	if(!empty($row['total_grade'])){
                    		$row['total_grade'] = $this->_changeScore($row['total_grade'],array('a'=>'优秀','b'=>'良好','c'=>'及格','d'=>'不及格'));
                    	}
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['total_grade']);
                        $str++;
                        continue;
                    }
                }
            }
        }
        // 输出下载文件 到浏览器
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }
        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
	}
	/**
	 * 导出班级分析排名
	 */
	public function outputRank(){
		$cid = intval($this->input->get('cid'));
		$syid = intval($this->input->get('syid'));
		$field = $this->input->get('field');
		$syModel = $this->model('Schoolyear');
		$param['type'] = 'score';
		$param['field'] = $field;
		$syinfo = $syModel->getSchoolYearInfoBySyid($syid);
		$constitutionModel = $this->model('constitution');
		$data = $constitutionModel->getClassData($cid,$syid,$param);
		$classModel = $this->model('Classes');
        $classinfo = $classModel->getClassInfo($cid);
		$objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            '学生姓名',
            '排名',
            '成绩'
        );
        $name = '';
        $fieldname = '';
        switch ($field) {
        	case 'total':
        		$fieldname = '总分';
        		break;
        	case 'height':
        		$fieldname = '身高';
        		break;
        	case 'weight':
        		$fieldname = '体重';
        		break;
        	case 'vitalcapacity':
        		$fieldname = '肺活量';
        		break;
        	case 'running50':
        		$fieldname = '50米跑';
        		break;
        	case 'running50_8':
        		$fieldname = '50米×8往返跑';
        		break;
        	case 'sit_and_reach':
        		$fieldname = '坐位体前屈';
        		break;
        	case 'situp':
        		$fieldname = '一分钟仰卧起坐';
        		break;
        	case 'jump':
        		$fieldname = '一分钟跳绳';
        		break;
        }
        if(!empty($syinfo) && !empty($classinfo)){
        	$name = $syinfo['syname'] .'年度'. $classinfo['classname'].$fieldname.'排名统计';
        }
        
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:C1");
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);
        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';//列A1,B1,C1,D1
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);

                //$pt->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置列填充模式 solid
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                //$pt->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//设置列边宽
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }
        $column_count = count($titleArr);

        //传值
        if(is_array($data)){
            foreach ($data as $index => $row) {
                $str = "A";
                for($i = 0; $i < $column_count; $i++) {
                    $p = $str . ($index + 3);
                    if ($str == 'A') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['studentname']);
                        $str++;
                        continue;
                    }
                    if ($str == 'B') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $index+1);
                        $str++;
                        continue;
                    }
                    if ($str == 'C') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['data']);
                        $str++;
                        continue;
                    }
                }
            }
        }
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);


        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
	}
	/**
	 * 将50*8的成绩1′57 转换成60+57=117的形式
	 */
	private function exchange50_8($running50_8){
		if(empty($running50_8))
			return 0;
		$runningarr = array();
		$runningarr = explode('′',$running50_8);
		if(!empty($runningarr)){
			$second = $runningarr[0] * 60 + $runningarr[1];
			return $second;
		}
		return 0;
	}
	/**
	 * 将50*8的成绩60+57=117 转换成 1′57 的形式
	 */
	private function exchange50_8_to($running50_8){
		if(empty($running50_8)){
			return 0;
		}
		$min = 0;
		$second = 0;
		$min = floor($running50_8 / 60);
		$second = $running50_8 - (60 * $min);
		return  $min .'′'.$second;
	}
	/**
	 * 显示学生的评语页面
	 */
	public function student_comment_view(){
		$uid = $this->uri->itemid;
		$roommodel = $this->model('classroom');		
		$user = Ebh::app()->user->getloginuser();
		$roomlist = $roommodel->getroomlistbytid($user['uid']);
		$roominfo = Ebh::app()->room->getcurroom();
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
			$this->assign('roominfo',$roominfo);
			$this->assign('room',$roominfo);
			$this->assign('roomlist',$roomlist);
			$this->assign('user',$user);
			$this->assign('studentid',$uid);
			$this->display('aroomv2/student_health_comment');
		}
	}
}