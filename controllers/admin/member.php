<?php
/*
会员
*/
class MemberController extends AdminControl{
	
	public function index(){
		if(!$this->input->get('op')){
			$this->display('admin/member');
		}
	}
	/**
	 *获取会员列表
	 *@author zkq
	 *@data 2014.04.23
	 *注:将ckx的getlist方法修改为此方法
	 */
	public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$queryArr['showregip'] = TRUE;
			$MModel = $this->model('member');
			$total = $MModel->getmembercount($queryArr);
			$MList = $MModel->getmemberlist($queryArr);
			array_unshift($MList,array('total'=>$total));
			echo json_encode($MList);
	}
	/*
	添加会员
	*/
	public function add(){
		$rec = safeHtml($this->input->post());
		if($rec){
			$member = $this->model('member');
			$param['username'] = $rec['username'];
			$param['password'] = $rec['password'];
			$param['realname'] = $rec['realname'];
			$param['nickname'] = $rec['nickname'];
			$param['sex'] = (int)$rec['sex'];
			$param['dateline'] = time();
			if(!empty($rec['birthdate'])){
				$param['birthdate'] = strtotime($rec['birthdate']);
			}
			$param['phone'] = $rec['phone'];
			$param['mobile'] = $rec['mobile'];
			$param['email'] = $rec['email'];
			$param['qq'] = $rec['qq'];
			$param['msn'] = $rec['msn'];
			$param['native'] = $rec['native'];
			$param['citycode'] = $rec['address_qu']?$rec['address_qu']:($rec['address_shi']?$rec['address_shi']:$rec['address_sheng']);
			$param['address'] = $rec['address'];
			$param['face'] = $rec['face']['upfilepath'];
			$param['profile'] = $rec['profile'];
			$res = $member->addmember($param);
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
			$this->model('credit')->addCreditlog(array('uid'=>$res,'ruleid'=>1));
			$returnurl = !empty($rec['nextsubmit'])?'/admin/member/add.html':'/admin/member.html';
			if(isset($res)){
				Ebh::app()->lib('xNums')->add('user');
				$this->goback('添加成功!',$returnurl);
			}
			else
				$this->goback('添加失败!',$returnurl);
		
		}
		else{
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->display('admin/member_add');
		}
	}
	/*
	新页面浏览详情
	*/
	public function view(){
		
		$member = $this->model('member');
		$uid = $this->input->get('uid');
		$memberdetail = $member->getmemberdetail($uid);
		$this->assign('memberdetail',$memberdetail);
		$this->display('admin/member_view');
		
	}
	/*
	新页面编辑会员
	*/
	public function edit(){
		$member = $this->model('member');
		if($this->input->post()){
			$param = safeHtml($this->input->post());
			$this->check($param);
			if(!empty($param['birthdate'])){
				$param['birthdate'] = strtotime($param['birthdate']);
			}
			$param['face'] = $param['face']['upfilepath'];
			$param['citycode'] = $this->input->post('address_qu')?$this->input->post('address_qu'):($this->input->post('address_shi')?$this->input->post('address_shi'):$this->input->post('address_sheng'));
			$param['citycode']=intval($param['citycode']);
			if($member->editmember($param)>0){
				$this->goback();
			}else{
				$this->goback('修改失败');
			}
		}
		else{
			$uid = $this->input->get('uid');
			$this->assign('token',createToken());
			$this->assign('formhash',formhash($uid));
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$memberdetail = $member->getmemberdetail($uid);
			$this->assign('memberdetail',$memberdetail);
			$this->display('admin/member_edit');
		}
	}
	/*
	页面内查看详情
	*/
	public function detail(){
		$member = $this->model('member');
		$uid = $this->input->get('uid');
		$memberdetail = $member->getmemberdetail($uid);

		$this->assign('memberdetail',$memberdetail);
		$this->display('admin/member_detail');
	}
	/*
	修改会员 ajax
	*/
	public function editmember(){
		$member = $this->model('member');
		$param = $this->input->post();
		
		echo $member -> editmember($param);
	}
	/*
	删除会员 ajax
	*/
	public function del(){
		$member = $this->model('member');
		$uid = $this->input->post('uid');
		Ebh::app()->lib('xNums')->add('user',-1);
		echo json_encode(array('success'=>$member->deletemember($uid)));
		
	}
	/**
	 *操作跳转方法
	 */
	public function goback($note="操作成功,正在努力跳转中...",$returnurl="/admin/member.html"){
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