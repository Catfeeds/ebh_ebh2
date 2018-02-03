<?php
/**
 * 课程目录
 */
class CatalogController extends CControl {
	public function __construct() {
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->roominfo = Ebh::app()->room->getcurroom();
		$this->user = Ebh::app()->user->getloginuser();
	}

	/**
	 * 默认页面
	 */
	public function index() {
		$param['crid'] = $this->roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$param['order'] = 'displayorder asc,folderid desc';
		$param['limit'] = 1000;//暂定1000
		$courselist = $this->model('folder')->getfolderlist($param);

		$this->assign('courselist', $courselist);
		$this->display('aroomv2/catalog');
	}

	/**
	 * AJAX获取节点列表，包含目录和目录下的课程。
	 */
	public function getnodelist() {
		$result = array();
		$crid = $this->roominfo['crid'];
		if($crid>0) {
			$result['cataloglist']	= $this->model('schcatalog')->getList($crid);
			$result['courselist']	= $this->model('schcatalog')->getcatalogcourses(array('crid' => $crid));
		}

		echo json_encode($result);
	}

	/**
	 * 添加或编辑节点
	 */
	public function savecatalog(){
		$result = array();
		$pid = intval($this->input->post('pid'));
		$catalogid = intval($this->input->post('catalogid'));
		$level = intval($this->input->post('level'));
		$catalogname = trim($this->input->post('catalogname'));
		$crid = $this->roominfo['crid'];
		$displayorder = intval($this->input->post('displayorder'));
		$nextids = $this->input->post('nextids');
		if(!empty($nextids)){
			$nextids = explode(',', $nextids);
		}
		if(empty($catalogname)) {
			$result = array('status'=>'-1','msg'=>'请填写目录名称');
			echo json_encode($result);
			exit();
		}

		//设置从主数据库读取,防止主从服务器来不及同步的问题
		Ebh::app()->getDb()->set_con(0);

		$mycatalogModel = $this->model('schcatalog');
		$uid = $this->user['uid'];
		$param = array('pid'=>$pid,'catalogname'=>$catalogname,'crid'=>$crid,'displayorder'=>$displayorder,'uid'=>$uid,'level'=>$level);
		if($catalogid > 0) {
			//修改章节名称时，先判断章节名称是否重复
			if($mycatalogModel->catalog_exists($catalogname,$crid,$pid,$catalogid)) {
				$result = array('status'=>'-2','msg'=>'保存失败，目录名称已存在，请重新输入');
				echo json_encode($result);
				exit();
			}

			$upresult = $mycatalogModel->update($param,$catalogid);
			if($nextids){
				$mycatalogModel->incorder($nextids);
			}
			if($upresult === false)
				$catalogid = 0;
		} else {
			$catalogid = $mycatalogModel->insert($param);
		}
		if(empty($catalogid)) {
			echo json_encode(array('status'=>'-3','msg'=>'保存失败，请联系系统管理员'));
			exit();
		}
		$catalogitem = $mycatalogModel->getcatalogbyid($catalogid);

		echo json_encode(array('status'=>'1','msg'=>'保存成功','catalogid'=>$catalogid,'catalog'=>$catalogitem));
		exit();
	}

	/**
	* 删除节点
	*/
	public function delcatalog(){
		$catalogid = $this->input->post('catalogid');
		$mycatalogModel = $this->model('schcatalog');
		$result = $mycatalogModel->delete_byid(intval($catalogid));
		if($result <= 0) {
			$msg = $result == -1?'删除失败，要删除该目录，请先删除它下面的子目录':'删除失败';
			echo json_encode(array('status'=>-1,'msg'=>$msg));
		} else
			echo json_encode(array('status'=>1));
		exit();
	}

	/**
	 * 删除关联课程
	 */
	public function delcourse(){
		$courseid = $this->input->post('courseid');
		list($catalogid, $folderid) = explode('_', $courseid);
		$this->model('schcatalog')->delcourse($catalogid, $folderid);
		echo 1;
		exit;
	}

	//保存目录相关课程
	public function choosecourse(){
		$param['catalogid'] = $this->input->post('catalogid');
		$param['folderids'] = $this->input->post('folderids');
		$param['crid'] = $this->roominfo['crid'];

		$this->model('schcatalog')->choosecourse($param);
		echo 1;
	}

	//ajax获取目录关联的课程
	public function getcatalogcourses(){
		$courselist = array();
		$catalogid = $this->input->post('catalogid');
		if (!empty($catalogid))
		{
			$param['catalogid'] = $catalogid;
		}
		$param['crid'] = $this->roominfo['crid'];
		$courselist = $this->model('schcatalog')->getcatalogcourses($param);
		echo json_encode($courselist);
	}

	//ajax查询该学校下的所有课程
	public function getcourselist(){
		$param['q'] = $this->input->get('q');
		$param['crid'] = $this->roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$param['order'] = 'displayorder asc,folderid desc';
		$param['limit'] = 1000;//暂定1000
		$courselist = $this->model('folder')->getfolderlist($param);

		echo json_encode($courselist);
	}

	/**
	 * 编辑知识点名称
	 */
	public function editname(){
		$result = array();
		$catalogid = intval($this->input->post('catalogid'));
		$catalogname = trim($this->input->post('catalogname'));
		$crid = $this->roominfo['crid'];
		if(empty($catalogname)) {
			$result = array('status'=>'-1','msg'=>'请填写目录名称');
			echo json_encode($result);
			exit();
		}
		$mycatalogModel = $this->model('schcatalog');
		$uid = $this->user['uid'];
		$param = array('catalogname'=>$catalogname,'crid'=>$crid,'uid'=>$uid);
		if($catalogid > 0) {
			//修改目录名称时，先判断目录名称是否重复
			$catalogitem = $mycatalogModel->getcatalogbyid($catalogid);
			$pid = $catalogitem['pid'];
			if($mycatalogModel->catalog_exists($catalogname,$crid,$pid,$catalogid)) {
				$result = array('status'=>'-2','msg'=>'保存失败，目录名称已存在，请重新输入');
				echo json_encode($result);
				exit();
			}

			$upresult = $mycatalogModel->editname($param,$catalogid);
			if($upresult !== FALSE) {
				echo json_encode(array('status'=>'1','msg'=>'保存成功','catalogid'=>$catalogid,'catalog'=>$catalogitem));
				exit();
			}
		}

	}
}
?>