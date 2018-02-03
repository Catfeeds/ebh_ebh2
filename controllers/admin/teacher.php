<?php
/*
教师控制器
*/
class TeacherController extends AdminControl{
	
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			$this->display('admin/login');
			exit;
		}
		if(!$this->input->get('op')){
			// $this->getList(1);
			$this->display('admin/teacher');
		}
	}
	public function lite(){
		$this->display('admin/teacher_lite');
	}
	// /*
	// 教师列表
	// */
	// public function getList($init=0){
	// 	$teacher = $this->model('teacher');
		
	// 	$pagination = $this->input->get('param');
	// 	$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
	// 	$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
	// 	$pagination['total'] = $teacher -> getteachercount($pagination);
	// 	$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
	// 	$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
	// 	$teacherlist = $teacher -> getteacherlist($pagination);
		
	// 	if(!$init)
	// 	{
	// 		$teacherlist[] = $pagination;
	// 		echo json_encode($teacherlist);
	// 	}
	// 	else
	// 	{
	// 		$this->assign('teacherlist',json_encode($teacherlist));
	// 		$this->assign('pagination',$pagination);
	// 		$this->assign('ctrl','teacher');
	// 	}
	
	// }
	/**
	 *获取教师列表
	 *@author zkq
	 *@data 2014.04.22
	 *注:将ckx的getlist方法修改为此方法
	 */
	public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$TModel = $this->model('teacher');
			$total = $TModel->getteachercount($queryArr);
			$TList = $TModel->getteacherlist($queryArr);

			//组装教师的信息,主要是为了判断老师是否已网校
			if (!empty($TList)) {
				$uidArr = array_column($TList,'uid');
				$hasClassRoomInfos = $TModel->getRoomByUidArr($uidArr);
				if (!empty($hasClassRoomInfos)) {
					foreach ($hasClassRoomInfos as $key => $value) {
						$uidList[$value['uid']] = $value;
					}
					foreach ($TList as $key => &$value) {
						if (isset($uidList[$value['uid']])) {
							$value['hasschool'] = 1;
						} else {
							$value['hasschool'] = 0;
						}
					}
				}

			}
			array_unshift($TList,array('total'=>$total));
			echo json_encode($TList);
	}
	/*
	添加
	*/
	public function add(){
		$agentSelect = $this->model('agents')->getAgentsSelect('agentid','agentid');
		$this->assign('agentSelect',$agentSelect);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$Upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('Upcontrol',$Upcontrol);
		if($this->input->post()){
			$teacher = $this->model('teacher');
			$rec = safeHtml($this->input->post(),array('message'));
			$param['agentid'] = empty($rec['agentid'])?0:$rec['agentid'];
			$param['username'] = empty($rec['username'])?'':$rec['username'];
			$param['password'] = empty($rec['password'])?'':$rec['password'];
			$param['realname'] = empty($rec['realname'])?'':$rec['realname'];
			$param['nickname'] = empty($rec['nickname'])?'':$rec['nickname'];
			$param['sex'] = empty($rec['sex'])?0:(int)$rec['sex'];
			$param['dateline'] = time();
			$param['agency'] = empty($rec['agency'])?'':$rec['agency'];
			$param['mobile'] = empty($rec['mobile'])?'':$rec['mobile'];
			$param['phone'] = empty($rec['phone'])?'':$rec['phone'];
			$param['fax'] = empty($rec['fax'])?'':$rec['fax'];
			$param['profile'] = empty($rec['profile'])?'':$rec['profile'];
			$param['tag'] = empty($rec['tag'])?'':$rec['tag'];
			$param['schoolage'] = empty($rec['schoolage'])?'':$rec['schoolage'];
			$param['vitae'] = $rec['vitae'];
			$param['vitae']['avater'] = $rec['face']['upfilepath'];
			$param['vitae'] = serialize($param['vitae']);
			//$param['profitratio'] =empty($rec['profitratio'])?'':serialize($rec['profitratio']);
			$param['message']=empty($rec['message'])?'':$rec['message'];
			$param['citycode'] = $rec['address_qu']?$rec['address_qu']:($rec['address_shi']?$rec['address_shi']:$rec['address_sheng']);
			if(!empty($rec['bankname'])&&!empty($rec['bankcard'])){
				$param['bankcard'] = serialize(array('card'=>$rec['bankcard'],'bankname'=>$rec['bankname']));
			}
			$res = $teacher->addteacher($param);
			// if(isset($res))
			// 	echo '成功';
			// else
			// 	echo '失败';
            //将注册信息记录到日志
            if($res){
                $logdata = array();
                $logdata['uid']=$res;
                $logdata['logtype']=5;
                $roominfo = Ebh::app()->room->getcurroom();
                $logdata['crid']=isset($roominfo['crid'])?$roominfo['crid']:0;
                $registerloglib=Ebh::app()->lib('RegisterLog');
                $registerloglib->addOneRegisterLog($logdata);
            }
			if($res){
				Ebh::app()->lib('xNums')->add('user')->add('teacher');
				$this->goback();
			}else{
				$this->goback('操作失败!');
			}
		
		}
		else{
			$teacher = $this->model('teacher');
			$this->display('admin/teacher_add');
		}	
	}
	/*
	新页面查看详情
	*/
	public function view(){
		$teacher = $this->model('teacher');
		$uid = $this->input->get('uid');
		$teacherdetail = $teacher->getteacherdetail($uid);
		$teacherdetail['vitae'] = unserialize($teacherdetail['vitae']);
		$this->assign('teacherdetail',$teacherdetail);
		$this->display('admin/teacher_view');
	}
	/*
	新页面修改
	*/
	public function edit(){
		$teacher = $this->model('teacher');
		$rec = safeHtml($this->input->post(),array('message'));
		if($rec){
			$this->check($rec);
			$param = $rec;
			$param['citycode'] = $this->input->post('address_qu')?$this->input->post('address_qu'):($this->input->post('address_shi')?$this->input->post('address_shi'):$this->input->post('address_sheng'));
			$param['citycode'] = intval($param['citycode']);
			$param['vitae']['avater'] = $param['face']['upfilepath'];
			$param['vitae'] = serialize($param['vitae']);
			if(!empty($rec['bankname'])&&!empty($rec['bankcard'])){
				$param['bankcard'] = serialize(array('card'=>$rec['bankcard'],'bankname'=>$rec['bankname']));
			}
			//$param['profitratio'] = serialize($param['profitratio']);
			// echo $teacher->editteacher($param);
			if($teacher->editteacher($param)){
				$this->goback();
			}else{
				$this->goback('操作失败!');
			}
		}
		else{
			
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$uid = $this->input->get('uid');
			$teacherdetail = $teacher->getteacherdetail($uid);
			$agentSelect = $this->model('agents')->getAgentsSelect('agentid','agentid',$teacherdetail['agentid']);
			$this->assign('agentSelect',$agentSelect);
			$teacherdetail['vitae'] = unserialize($teacherdetail['vitae']);
			$teacherdetail['bankcard'] = unserialize($teacherdetail['bankcard']);
			//$teacherdetail['profitratio'] = unserialize($teacherdetail['profitratio']);
			$this->assign('token',createToken());
			$this->assign('formhash',formhash($teacherdetail['uid']));
			$this->assign('teacherdetail',$teacherdetail);
			$this->display('admin/teacher_edit');
		}
	}
	/*
	修改 ajax
	*/
	public function editteacher(){
		$teacher = $this->model('teacher');
		$param = $this->input->post();
		echo $teacher -> editteacher($param);
		
	}
	/*
	删除
	*/
	public function del(){
		$teacher = $this->model('teacher');
		$uid = $this->input->post('uid');
		echo json_encode(array('success'=>$teacher->deleteteacher($uid)));
		fastcgi_finish_request();
		Ebh::app()->lib('xNums')->add('user',-1)->add('teacher',-1);
	}
	/*
	搜索窗口 
	*/
	public function searchwindow(){
		$this->getlist(1);
		$this->display('admin/teacher_search');
	}
	/**
	 *操作跳转方法
	 */
	public function goback($note="操作成功,正在努力跳转中...",$returnurl="/admin/teacher.html"){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
	/**
	 *安检方法,对页面提交过来的数据进行安全检查
	 *@author zkq
	 *
	 */
	public function check($param=array()){
		if(checkToken($param['token'])===false){
			$this->goback('请勿重复提交!');
		}
		if(formhash($param['uid'])!=$param['formhash']){
			$this->goback('参数被篡改!');
		}
		$message = array();
		$message['code'] = true;
		//其它检测...预留
		if($message['code']===false){
			$this->goback(implode('<br />',$message));
		}
	}
}
?>