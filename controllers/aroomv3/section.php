<?php
/*
课程章节
*/
class SectionController extends ARoomV3Controller{
	/*
	课程章节列表
	*/
	public function index(){
		$data['folderid'] = $this->input->get('folderid');
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Section.sectionList')->addParams($data)->request();
		$this->renderjson(0,'',$result);
		
	}
	
	/*
	编辑章节
	*/
	public function edit(){
		$data['sid'] = $this->input->post('sid');
		$data['sname'] = $this->input->post('sname');
		if(empty($data['sid']) || empty($data['sname']))
			$this->renderjson(1,'参数不正确','');
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Section.edit')->addParams($data)->request();
		if($result !== FALSE){
			$this->renderjson(0,'修改成功');
		} else {
			$this->renderjson(1,'修改失败');
		}
	}
	
	/*
	添加章节
	*/
	public function add(){
		$data['folderid'] = intval($this->input->post('folderid'));
		$data['sname'] = $this->input->post('sname');
		
		if(empty($data['folderid']) || empty($data['sname']))
			$this->renderjson(1,'参数不正确');
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Section.add')->addParams($data)->request();
		if($result > 0){
			$this->renderjson(0,'添加成功');
		} else {
			$this->renderjson(1,'添加失败');
		}
			
	}
	
	/*
	章节上下移动
	*/
	public function changeOrder(){
		$data['sid'] = intval($this->input->post('sid'));
		$data['isup'] = intval($this->input->post('isup'));
		$data['isup'] = $data['isup'] == 1?1:0;
		$data['crid'] = $this->roominfo['crid'];
		if(empty($data['sid'])) {
			$this->renderjson(1,'参数不正确');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Section.changeOrder')->addParams($data)->request();
		
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	 * 直接输入排序号修改
	*/
	public function updateOrder(){
		$data['sid'] = intval($this->input->post('sid'));
		$data['displayorder'] = intval($this->input->post('displayorder'));
		$data['crid'] = $this->roominfo['crid'];
		if(empty($data['sid']) || empty($data['displayorder']) || $data['displayorder']<0) {
			$this->renderjson(1,'参数不正确');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Section.updateOrder')->addParams($data)->request();
		
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	
	/*
	章节删除
	*/
	public function del(){
		$data['sid'] = intval($this->input->post('sid'));
		$data['crid'] = $this->roominfo['crid'];
		if(empty($data['sid'])) {
			$this->renderjson(1,'参数不正确');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Section.del')->addParams($data)->request();
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
}