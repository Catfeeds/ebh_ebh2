<?php
/*
教室
*/
class ClassroomController extends AdminControl{

	public function index(){
		 
		// $this->getlist(1);
		$this->display('admin/classroom');
	}
	// public function getlist($init=0){
	// 	$classroom = $this->model('classroom');
	// 	$pagination = $this->input->get('param');
	// 	$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
	// 	$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
	// 	$pagination['total'] = $classroom -> getclassroomcount($pagination);
	// 	$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
	// 	$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
	// 	$classroomlist = $classroom -> getclassroomlist($pagination);
		
	// 	if(!$init){
	// 		$classroomlist[] = $pagination;
	// 		echo json_encode($classroomlist);
	// 	}
	// 	else{
	// 		$this->assign('classroomlist',json_encode($classroomlist));
	// 		$this->assign('pagination',$pagination);
	// 		$this->assign('ctrl','classroom');
	// 	}
	// }
	/**
	 *获取教室列表
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
			$CModel = $this->model('classroom');
			$total = $CModel->getclassroomcount($queryArr);
			$CList = $CModel->getclassroomlist($queryArr);
			array_unshift($CList,array('total'=>$total));
			echo json_encode($CList);
	}
	/*
	只包含crid、crname的列表
	*/
	public function getsimplelist(){
		$classroom = $this->model('classroom');
		$classroomlist = $classroom->getsimpleclassroomlist();
		echo json_encode($classroomlist);
	}
	/*
	添加
	*/
	public function add(){
		$classroom = $this->model('classroom');
		if($this->input->post()){
			$param = $this->input->post();
			$param['citycode'] = $this->input->post('address_qu')?$this->input->post('address_qu'):($this->input->post('address_shi')?$this->input->post('address_shi'):$this->input->post('address_sheng'));
			$this->check($param);
			$param['begindate'] = strtotime($param['begindate']);
			$param['enddate'] = strtotime($param['enddate']);
			$param['status'] = 1;
			if(!empty($param['modulepower']))
				$param['modulepower'] = implode(',',$param['modulepower']);
			if(!empty($param['stumodulepower']))
				$param['stumodulepower'] = implode(',',$param['stumodulepower']);
			
			if(!empty($param['cface'])){
				$param['cface'] = $param['cface']['upfilepath'];
			}
			if(!empty($param['banner'])){
				$param['banner'] = $param['banner']['upfilepath'];
			}
			if(!empty($param['profitratio'])){
				$param['profitratio'] = serialize($param['profitratio']);
			}
			unset($param['valuesubmit']);
			$res = $classroom->addclassroom($param);
			//设置教室和老师对应的表
			$ct = array(
				'crid'=>$res,
				'tid'=>$param['uid'],
				'status'=>1,
				'cdateline'=>time(),
				'role'=>2
				);
			$this->model('roomteacher')->insert($ct);
			if($res>0){
				$this->goback();
			}else{
				$this->goback('添加失败!');
			}
		}else{
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$crid = $this->input->get('crid');
			$this->assign('crid',$crid);
			$tpowerlist = $classroom->getroompowerlist(712);
			$stpowerlist = $classroom->getroompowerlist(242);
			$sharelist = $classroom->getsharelist();
			$this->assign('tpowerlist',$tpowerlist);
			$this->assign('stpowerlist',$stpowerlist);
			$this->assign('sharelist',$sharelist);
			if($crid){
				$classroomdetail = $classroom->getclassroomdetail($crid);
				$this->assign('classroomdetail',$classroomdetail);
			}
			$this->assign('formhash',formhash('add'));
			$this->assign('token',createToken());
			$this->display('admin/classroom_add');
		}
	}
	/*
	删除 ajax
	*/
	public function del(){
		$classroom = $this->model('classroom');
		$crid = $this->input->post('crid');
		echo json_encode(array('success'=>$classroom->deleteclassroom($crid)));
	}
	/*
	新页面修改
	*/
	public function edit(){
		$classroom = $this->model('classroom');
		if($this->input->post()){
			$param = $this->input->post();
			$param['citycode'] = $this->input->post('address_qu')?$this->input->post('address_qu'):($this->input->post('address_shi')?$this->input->post('address_shi'):$this->input->post('address_sheng'));
			$this->check($param);
			$param['begindate'] = strtotime($param['begindate']);
			$param['enddate'] = strtotime($param['enddate']);
			if(!empty($param['modulepower'])){
				$param['modulepower'] = implode(',',$param['modulepower']);
			}else{
				$param['modulepower'] = '';
			}
			if(!empty($param['stumodulepower'])){
				$param['stumodulepower'] = implode(',',$param['stumodulepower']);
			}else{
				$param['stumodulepower'] = '';
			}
			
			if(isset($param['cface'])){
				$param['cface'] = $param['cface']['upfilepath'];
			}
			if(isset($param['banner'])){
				$param['banner'] = $param['banner']['upfilepath'];
			}
			if(!empty($param['profitratio'])){
				$param['profitratio'] = serialize($param['profitratio']);
			}
			
			if($classroom->editclassroom($param)!==false){
			//设置教室和老师对应的表
				$ct = array(
				'crid'=>$param['crid'],
				'tid'=>$param['uid'],
				'status'=>1,
				'cdateline'=>time(),
				'role'=>2
				);
			//更换管理员，先将原管理员role置1，再尝试将所选教师置2（已经在此教室的教师），失败则插入一条新数据（不在此教师的教师）
				$this->model('roomteacher')->update(array('crid'=>$param['crid'],'role'=>2,'changerole'=>1));
				$tempu = $this->model('roomteacher')->update(array('crid'=>$param['crid'],'tid'=>$param['uid'],'changerole'=>2));
				if(!$tempu)
					$this->model('roomteacher')->insert($ct);
				
				//修改共享平台分配
				if(isset($param['roompermission']))
				{
					$classroom->editroompermission($param['roompermission'],$param['crid']);
				}
				
				
				
				$this->goback();
			}else{
				$this->goback('修改失败!');
			}
		}else{
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$crid = $this->input->get('crid');
			$classroomdetail = $classroom->getclassroomdetail($crid);
			$tpowerlist = $classroom->getroompowerlist(712);
			$stpowerlist = $classroom->getroompowerlist(242);
			$sharelist = $classroom->getsharelist();
			$permissionlist = $classroom->getroompermission($crid);
			$this->assign('permissionlist',$permissionlist);
			$this->assign('tpowerlist',$tpowerlist);
			$this->assign('stpowerlist',$stpowerlist);
			$this->assign('sharelist',$sharelist);
			$this->assign('c',$classroomdetail);
			$formhash_bt = 'edit'.$classroomdetail['crname'].$classroomdetail['domain'].$crid;
			$this->assign('formhash',formhash($formhash_bt));
			$this->assign('token',createToken());
			$this->display('admin/classroom_edit');
		}
	}
	/*
	修改 ajax
	*/
	public function editclassroom(){
		$classroom = $this->model('classroom');
		$param = $this->input->post();
		echo $classroom -> changeStatus($param);
	}
	/*
	新页面详情
	*/
	public function view(){
			$crid = intval($this->input->get('crid'));
			$classroom = $this->model('classroom');
			$classroomdetail = $classroom->getclassroomdetail($crid);
			$this->assign('c',$classroomdetail);
			$this->display('admin/classroom_view');
	}
	/*
	判断域名是否存在 ajax
	*/
	public function exists_domain(){
		$classroom = $this->model('classroom');
		$domain = $this->input->get('domain');
		if($classroom->exists_domain($domain))
			echo 1;
		else
			echo 0;
	}
	/*
	判断网校名是否存在 ajax
	*/
	public function exists_crname(){
		$classroom = $this->model('classroom');
		$crname = $this->input->get('crname');
		if($classroom->exists_crname($crname))
			echo 1;
		else
			echo 0;
	}
	
	/*
	教室权限列表
	public function getroompowerlist($upid){
		$classroom = $this->model('classroom');
		$classroom->getroompowerlist($upid);
		////////////////////////////////////////////
	}
	*/
	public function getCrList(){
		$postwhere = (array)json_decode($this->input->post('where'));
		$key = md5(serialize($this->input->post()));
		if($this->cache->get($key)){
			echo $this->cache->get($key);exit;
		}
		if(is_array($postwhere)&&count($postwhere)>0){
			$where = $postwhere;
		}else{
			$where = array('status'=>1,'order'=>'cr.crid desc','limit'=>'0,1000');
		}
		$classroom = $this->model('classroom')->getroomlist($where);
		$selected = $this->input->post('checked');
		$html='';
		foreach ($classroom as $value) {
			if((int)$value['crid']==$selected){
				$html.= '<option value="'.$value['crid'].'"'.' selected=selected >'.$value['crname'].'</option>';
			}else{
				$html.= '<option value="'.$value['crid'].'">'.$value['crname'].'</option>';
			}
		}
		$this->cache->set($key,$html,60);
		echo $html;
	}	
	public function goback($note='操作成功,跳转中...',$returnurl='/admin/classroom.html'){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
	/**
	 *安检方法,对新增后台教室和编辑教师页面提交过来的数据进行了非常安全的判断,目前确保绝对安全
	 *@author zkq
	 *@date 2014-04-28
	 */
	public function check($param = array()){
		if(checkToken($param['token'])===false){
			$this->goback('请勿重复提交!');
		}
		if(!in_array($param['op'],array('add','edit'))){
			$this->goback('操作数被篡改!');
		}
		if($param['op']=='add'){
			$formhash_bt = 'add';
		}
		if($param['op']=='edit'){
			$formhash_bt = 'edit'.$param['_crname'].$param['_domain'].$param['crid'];
		}
		if(formhash($formhash_bt)!=$param['formhash']){
			$this->goback('参数被篡改!');
		}

		$message = array();
		$message['code'] = true;
		//网校老师权限参数合法性判断
		$tpowerlist = $this->model('classroom')->getroompowerlist(712);
		$tpowerlistCrids = array();
		foreach ($tpowerlist as $sv) {
			$tpowerlistCrids[] = $sv['catid'];
		}
		if(!empty($param['modulepower'])){
			$intersect = array_intersect($param['modulepower'],$tpowerlistCrids);
			$diff = array_diff($param['modulepower'],$intersect);
			if(!empty($diff)){
				$message[] = '网校老师权限参数被篡改!';
				$message['code'] = false;
			}
		}
		//共享平台参数合法性判断
		$sharelist = $this->model('classroom')->getsharelist();
		$sharelistCrids = array();
		foreach ($sharelist as $sv) {
			$sharelistCrids[] = $sv['crid'];
		}
		if(!empty($param['roompermission'])){
			$intersect = array_intersect($param['roompermission'],$sharelistCrids);
			$diff = array_diff($param['roompermission'],$intersect);
			if(!empty($diff)){
				$message[] = '共享平台参数被篡改!';
				$message['code'] = false;
			}
		}
		//网校学生权限参数合法性判断
		$stpowerlist = $this->model('classroom')->getroompowerlist(242);
		$stpowerlistCrids = array();
		foreach ($stpowerlist as $sv) {
			$stpowerlistCrids[] = $sv['catid'];
		}
		if(!empty($param['stumodulepower'])){
			$intersect = array_intersect($param['stumodulepower'],$stpowerlistCrids);
			$diff = array_diff($param['stumodulepower'],$intersect);
			if(!empty($diff)){
				$message[] = '网校学生权限参数被篡改!';
				$message['code'] = false;
			}
		}
		if(!in_array($param['isschool'],array(0,1,2,3,4,5,6))){
			$message[] = '平台类型被篡改!';
			$message['code'] = false;
		}
		if(empty($param['crname'])){
			$message[] = '网校名为空';
			$message['code'] = false;
		}
		if(empty($param['domain'])){
			$message[] = '域名为空';
			$message['code'] = false;
		}
		if($param['op']=='add'){
			$domain = $this->model('classroom')->exists_domain($param['domain']);
			if(!empty($domain)){
				$message[] = '域名已存在';
				$message['code'] = false;
			}
			$crname = $this->model('classroom')->exists_crname($param['crname']);
			if(!empty($crname)){
				$message[] = '网校名称已存在';
				$message['code'] =false;
			}
		}elseif($param['op']=='edit'){
			if($param['_domain']!=$param['domain']){
				$domain = $this->model('classroom')->exists_domain($param['domain']);
				if(!empty($domain)){
					$message[] = '域名已存在';
					$message['code'] = false;
				}
			}
			if($param['_crname']!=$param['crname']){
				$crname = $this->model('classroom')->exists_crname($param['crname']);
				if(!empty($crname)){
					$message[] = '网校名称已存在';
					$message['code'] =false;
				}
			}
		}
		if(!in_array($param['maxnum'],array(50,100,150))){
			$message[] = '最大人数被篡改!';
			$message['code'] = false; 
		}
		if($this->model('teacher')->isExits(intval($param['uid']))===false){
			$message[] = '教师不存在,可能是教师参数被非法篡改!';
			$message['code'] = false;
		}
		if(!empty($param['citycode']) && $this->model('cities')->isExits(intval($param['citycode']))===false){
			$message[] = '城市不存在,可能是城市参数被非法篡改!';
			$message['code'] = false;
		}
		if(preg_match("/^[0-9]+(\.[0-9]{2})?$/",$param['crprice'])==0){
			$message[] = '开通此电子网校所需金额非法';
			$message['code'] = false;
		}
		if(empty($param['profitratio'])){
			$message[] = '分层不能为空!';
			$message[] = false;
		}else{
			foreach($param['profitratio'] as $pv) {
				if(!is_numeric($pv)){
					$message[] = '分层出现非数字参数';
					$message['code'] = false;
					break;
				}
			}
		}

		if(array_sum($param['profitratio'])!=100){
			$message[] = '分层参数不正确!';
			$message['code'] = false;
		}
		if(!empty($param['ispublic'])&&$param['ispublic']!=1){
			$message[] = '是否公开参数不正确!';
			$message['code'] = false;
		}
		if(!empty($param['isshare'])&&$param['isshare']!=1){
			$message[] = '是否共享平台参数不正确!';
			$message['code'] = false;
		}
		if(preg_match("/^[0-9]{1,}$/",$param['displayorder'])==0){
			$message[] = '排序参数不正确!';
			$message['code'] = false;
		}
		$tplPath = './views/shop/'.$param['template'];
		if(!is_dir($tplPath)){
			$message[] = '网校模板文件夹不存在或者参数被篡改!';
			$message['code'] = false;
		}

		//日期的验证
		if(empty($param['begindate'])||empty($param['enddate'])){
			$message[] = '网校开始时间或者网校结束时间为空';
			$message['code'] = false;
		}else{
			$begindate = strtotime($param['begindate']);
			$enddate = strtotime($param['enddate']);
			if($begindate === FALSE || $enddate === FALSE) {
				$message[] = '网校结束时间格式不对!';
				$message['code'] = false;
			} else if( $begindate > $enddate ) {
				$message[] = '网校开始时间不可以比结束时间晚!';
				$message['code'] = false;
			}
		}
		
		if($message['code']===false){
			$this->goback(implode('<br />',$message));
		}

	}
	/*
	搜索教室页面，用作弹出框
	*/
	public function search(){
		$this->display('admin/classroom_search');
	}
}
?>