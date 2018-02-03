<?php
/*
教室课件
*/
class classroomcourseController extends AdminControl{

	public function index(){
		// 获取教室select控件
		$crlistSelect = EBH::app()->lib('SelectUtil')->getCrSelect('name=crid');
		$this->assign('crSelect',$crlistSelect);
		// $this->getlist(1);
		$this->display('admin/classroomcourse');
	}
	
	/**
	 *获取教室课件列表
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
			$CRModel = $this->model('classroomcourse');
			$total = $CRModel->getclassroomcoursecount($queryArr);
			$CRList = $CRModel->getclassroomcourselist($queryArr);
			array_unshift($CRList,array('total'=>$total));
			echo json_encode($CRList);
	}
	
	/*
	删除 ajax
	*/
	public function del(){
		
		$cwid = $this->input->post('cwid');
		$this->deleteHelper($cwid);
		
	}
	/*
	修改 ajax
	*/
	public function editclassroomcourse(){
		$classroomcourse = $this->model('classroomcourse');
		$param = $this->input->post();
		echo $classroomcourse -> editclassroomcourse($param);
	}
	/**
	 *获取课件对应的信息
	 *
	 */
	public function getDetail($cwid){
		$cwinfo = $this->model('courseware')->getcoursedetail($cwid);
		return $cwinfo;
	}
	/**
	 *课件删除助手(删除对应的课件,删除对应的附件,更新对ebh_folders课件数,更新coursewares对应的附件数)
	 *
	 */
	public function deleteHelper($cwid){
		$cwinfo = $this->getDetail($cwid);
		$classroomcourse = $this->model('classroomcourse');
		$res = $classroomcourse->deleteclassroomcourse($cwid);
		if($res){
			//删除课件附件
			$attaches = $this->model('attachment')->getAttachmentListByCwid(array('cwid'=>$cwid));
			$this->model('attachment')->deletebycwid($cwid);
			foreach ($attaches as $att) {
				delfile('attachment',$att['url']);
			}
			$folderid = $cwinfo['folderid'];
			//删除课件文件
			$cwurl = $cwinfo['cwurl'];
			delfile('course',$cwurl);
			$foldermodel = $this->model('Folder');
			$folder = $foldermodel->getfolderbyid($folderid);
			$folderlevel = $folder['folderlevel'];
			while($folderlevel>1){
				$foldermodel->addcoursenum($folderid,-1);
				$folder = $foldermodel->getfolderbyid($folder['upid']);
				if(!$folder){
					break;
				}
				$folderlevel = $folder['folderlevel'];
				$folderid = $folder['folderid'];
					
			}
			$roommodel = $this->model('Classroom');
	        $roommodel->addcoursenum($cwinfo['crid'],-1);
	        $teachermodel = $this->model('Teacher');
	        $teachermodel->addcoursenum($cwinfo['uid'],-1);
		}
		echo json_encode(array('success'=>$res));
	}
}
?>