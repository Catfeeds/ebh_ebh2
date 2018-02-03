<?php
/*
获取用户名
*/
class GetusernameController extends CControl{
	public function index(){
		$classroom = $this->model('classroom');
		$roominfo = Ebh::app()->room->getcurroom();
		if($this->input->post()!=null){
			$param['crname'] = $this->input->post('crname');
			$param['crid'] = $roominfo['crid'];
			$param['realname'] = str_replace(' ','',$this->input->post('realname'));
			// $param['sex'] = intval($this->input->post('sex'));
			// var_dump($param);exit;
			$res = $classroom->getUsernameByRealname($param);
			if($res == false || empty($res)){
				echo 0;
			}else{
				echo json_encode($res);
			}
		}else{
			
			$crlist = $classroom->getSearchableClassrooms($roominfo['crid']);
			$roomdetail = $classroom->getclassroomdetail($roominfo['crid']);
			$this->assign('roomdetail',$roomdetail);
			$this->assign('crlist',$crlist);
			$this->assign('room',$roominfo);
			$this->display('common/getusername');
		}
	}

	/**
	 * 获取可供查询的学校列表和默认密码
	 */
	public function getinfo()
	{
		$classroom = $this->model('classroom');
		$roominfo = Ebh::app()->room->getcurroom();

		$crlist = array();
		$defaultpass = '123456';//默认密码

		$tempcrlist = $classroom->getSearchableClassrooms($roominfo['crid']);
		foreach ($tempcrlist as $value)
		{
			$crlist[] = $value['crname'];
		}

		$roomdetail = $classroom->getclassroomdetail($roominfo['crid']);
		if ( ! empty($roomdetail['defaultpass']))
		{
			$defaultpass = $roomdetail['defaultpass'];
		}
		echo json_encode(array('crlist' => $crlist, 'defaultpass' => $defaultpass));
	}
}
?>