<?php
class SpaceController extends CControl{
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		if(empty($this->user)){
			header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
			exit;
		}
		$this->assign('user',$this->user);
	}
	public function index(){
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$uptype = 'space';
		$showpath = $_UP[$uptype]['imagepath'];
		$space = $this->model('space');
		$param['q'] = urldecode($this->uri->uri_attr(0));
		$param['uid'] = $this->user['uid'];
		$pagesize = 15;
		$page = $this->uri->page?$this->uri->page-1:0;
		$param['limit'] = $pagesize*$page.','.$pagesize;
		$spacecount = $space->getspacecount($param);
		$spacelist = $space->getspacelist($param);
		$this->assign('spacecount',$spacecount);
		$this->assign('spacelist',$spacelist);
		$this->assign('pagesize',$pagesize);
		$this->assign('q',$param['q']);
		$this->assign('showpath',$showpath);
		$this->display('member/space');
	}
	/*
	查看作品
	*/
	public function view(){
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$uptype = 'space';
		$showpath = $_UP[$uptype]['imagepath'];
		$space = $this->model('space');
		$id = $this->uri->itemid;
		$spacedetail = $space->getspacedetail($id);
		$imgurl = $showpath.$spacedetail['image'];
		$this->assign('item',$spacedetail);
		$this->assign('showpath',$showpath);
		$this->assign('imgurl',$imgurl);
		$this->display('member/space_view');
	}
	/*
	删除作品
	*/
	public function del(){
		$space = $this->model('space');
		$param['id'] = $this->input->post('id');
		$param['uid'] = $this->user['uid'];
		$row = $space->deletespaceitem($param);
		if($row>0)
			echo 1;
		else
			echo 0;
	}
	/*
	修改标题
	*/
	public function edittitle(){
		$space = $this->model('space');
		$param = $this->input->post();
		//$param['title'] = $this->input->post('title');
		echo $space->editspace($param);
	}
}

?>