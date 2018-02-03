<?php
/**
 * 知识点管理
 */
class ChapterController extends CControl {
	private $tplchapters = array();//待复制的知识点模板
	private $newchapters = array();//新生成的知识点
	public function __construct() {
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->roominfo = Ebh::app()->room->getcurroom();
		$this->user = Ebh::app()->user->getloginuser();
	}

	/**
	 * 菜单
	 */
	public function index() {
		$this->display('aroomv2/chapter');
	}

	/**
	 * 版本管理
	 */
	public function versionlist() {
		$versionlist = $this->model('mychapter')->getversionlist($this->roominfo['crid']);
		$this->assign('versionlist', $versionlist);
		$this->display('aroomv2/versionlist');
	}

	/**
	 * 添加版本
	 */
	public function addversion() {
		$crid = $this->roominfo['crid'];
		$uid = $this->user['uid'];
		$chaptername = trim($this->input->post('chaptername'));
		if (!isset($chaptername)) {
			echo json_encode(array('code'=>0));
			exit;
		}
		if($this->model('mychapter')->chapter_exists($chaptername,$crid,0)) {
			echo json_encode(array('code'=>'-2'));
			exit;
		}
		$displayorder = 1;
		$maxdisplayorder = $this->model('mychapter')->getmaxdisplayorder(array('crid' => $crid, 'level' => 1));
		if (!empty($maxdisplayorder))
			$displayorder = $maxdisplayorder+1;//排序加1

		$param = array('pid'=>0,'chaptername'=>$chaptername,'crid'=>$crid,'displayorder'=>$displayorder,'uid'=>$uid,'level'=>1);
		$chapterid = $this->model('mychapter')->insert($param);
		if(empty($chapterid)) {
			echo json_encode(array('code'=>'0'));
			exit();
		}
		else
		{
			echo json_encode(array('code'=>'1'));
			exit();
		}
	}

	/**
	 * 编辑版本
	 */
	public function editversion() {
		$crid = $this->roominfo['crid'];
		$uid = $this->user['uid'];
		$chapterid	 = $this->input->post('chapterid');
		$chaptername = trim($this->input->post('chaptername'));
		if (empty($chapterid) || (!isset($chaptername))) {
			echo json_encode(array('code'=>0));
			exit;
		}
		if($this->model('mychapter')->chapter_exists($chaptername,$crid,0,$chapterid)) {
			echo json_encode(array('code'=>'-2'));
			exit;
		}
		$param = array('chaptername'=>$chaptername,'uid'=>$uid,'crid'=>$crid);
		$result = $this->model('mychapter')->update($param, $chapterid);
		if($result === FALSE) {
			echo json_encode(array('code'=>'0'));
			exit();
		}
		else
		{
			echo json_encode(array('code'=>'1'));
			exit();
		}

	}

	/**
	 * 知识点管理
	 */
	public function chapterlist() {
		$chaptertemplate = Ebh::app()->getConfig()->load('chaptertemplate');
		$tplcrid = $chaptertemplate['crid'];//模板的学校编号
		$tplversionlist = $this->model('mychapter')->getversionlist($tplcrid);

		$versionlist = $this->model('mychapter')->getversionlist($this->roominfo['crid']);
		$this->assign('versionlist', $versionlist);
		$this->assign('tplversionlist', $tplversionlist);
		$this->display('aroomv2/chapterlist');
	}

	/**
	 * AJAX获取知识点列表。
	 */
	public function getnodelist() {
		$result['chapterlist'] = array();
		$versionid = $this->input->post('versionid');
		$crid = $this->roominfo['crid'];
		if(empty($versionid)) {
			echo json_encode($result);
			exit;
		}
		if($crid>0) {
			$result['chapterlist']	= $this->model('mychapter')->getnodelist($crid, $versionid);
		}

		echo json_encode($result);
	}

	/**
	 * 添加或编辑节点
	 */
	public function savechapter(){
		$result = array();
		$pid = intval($this->input->post('pid'));
		$chapterid = intval($this->input->post('chapterid'));
		$level = intval($this->input->post('level'));
		$chaptername = trim($this->input->post('chaptername'));
		$crid = $this->roominfo['crid'];
		$displayorder = intval($this->input->post('displayorder'));
		$nextids = $this->input->post('nextids');
		if(!empty($nextids)){
			$nextids = explode(',', $nextids);
		}
		if(!isset($chaptername)) {
			$result = array('status'=>'-1','msg'=>'请填写知识点名称');
			echo json_encode($result);
			exit();
		}

		//设置从主数据库读取,防止主从服务器来不及同步的问题
		Ebh::app()->getDb()->set_con(0);

		$mychapterModel = $this->model('mychapter');
		$uid = $this->user['uid'];
		$param = array('pid'=>$pid,'chaptername'=>$chaptername,'crid'=>$crid,'displayorder'=>$displayorder,'uid'=>$uid,'level'=>$level);
		if($chapterid > 0) {
			//修改章节名称时，先判断章节名称是否重复
			if($mychapterModel->chapter_exists($chaptername,$crid,$pid,$chapterid)) {
				$result = array('status'=>'-2','msg'=>'保存失败，知识点名称已存在，请重新输入');
				echo json_encode($result);
				exit();
			}

			$upresult = $mychapterModel->update($param,$chapterid);
			if($nextids){
				$mychapterModel->incorder($nextids);
			}
			if($upresult === false)
				$chapterid = 0;
		} else {
			$chapterid = $mychapterModel->insert($param);
		}
		if(empty($chapterid)) {
			echo json_encode(array('status'=>'-3','msg'=>'保存失败，请联系系统管理员'));
			exit();
		}
		$chapteritem = $mychapterModel->getchapterbyid($chapterid);

		echo json_encode(array('status'=>'1','msg'=>'保存成功','chapterid'=>$chapterid,'chapter'=>$chapteritem));
		exit();
	}

	/**
	* 删除节点
	*/
	public function delchapter(){
		$chapterid = $this->input->post('chapterid');
		$mychapterModel = $this->model('mychapter');
		$result = $mychapterModel->delete_byid(intval($chapterid), $this->roominfo['crid']);
		if($result <= 0) {
			$msg = $result == -1?'删除失败，请先删除它下面的子知识点':'删除失败';
			echo json_encode(array('status'=>-1,'msg'=>$msg));
		} else
			echo json_encode(array('status'=>1));
		exit();
	}

	/**
	 * 上下移动版本号
	 * @return [type] [description]
	 */
	public function move(){
		$crid= $this->roominfo['crid'];
		$chapterid = $this->input->post('chapterid');
		$flag = $this->input->post('flag');
		if($flag == 1){//上移
			$res = $this->model('mychapter')->moveit(array('crid'=>$crid,'chapterid'=>$chapterid,'compare'=>'<','order'=>'displayorder desc,chapterid asc'));
		}else{//下移
			$res = $this->model('mychapter')->moveit(array('crid'=>$crid,'chapterid'=>$chapterid,'compare'=>'>','order'=>'displayorder asc,chapterid asc'));
		}

		if($res)
			echo 1;
		else
			echo 0;
	}

	/**
	 * 编辑知识点名称
	 */
	public function editname(){
		$result = array();
		$chapterid = intval($this->input->post('chapterid'));
		$chaptername = trim($this->input->post('chaptername'));
		$crid = $this->roominfo['crid'];
		if(empty($chaptername)) {
			$result = array('status'=>'-1','msg'=>'请填写知识点名称');
			echo json_encode($result);
			exit();
		}
		$mychapterModel = $this->model('mychapter');
		$uid = $this->user['uid'];
		$param = array('chaptername'=>$chaptername,'crid'=>$crid,'uid'=>$uid);
		if($chapterid > 0) {
			//修改知识点名称时，先判断知识点名称是否重复
			$chapteritem = $mychapterModel->getchapterbyid($chapterid);
			$pid = $chapteritem['pid'];
			if($mychapterModel->chapter_exists($chaptername,$crid,$pid,$chapterid)) {
				$result = array('status'=>'-2','msg'=>'保存失败，知识点名称已存在，请重新输入');
				echo json_encode($result);
				exit();
			}

			$upresult = $mychapterModel->editname($param,$chapterid);
			if($upresult !== FALSE) {
				echo json_encode(array('status'=>'1','msg'=>'保存成功','chapterid'=>$chapterid,'chapter'=>$chapteritem));
				exit();
			}
		}

	}

	/**
	 * AJAX获取模板知识点列表。
	 */
	public function gettplnodelist() {
		$chaptertemplate = Ebh::app()->getConfig()->load('chaptertemplate');
		$tplcrid = $chaptertemplate['crid'];//模板的学校编号

		$result['chapterlist'] = array();
		$versionid = $this->input->post('versionid');

		if(empty($versionid)) {
			echo json_encode($result);
			exit;
		}
		if($tplcrid>0) {
			$result['chapterlist']	= $this->model('mychapter')->getnodelist($tplcrid, $versionid);
		}

		echo json_encode($result);
	}


	//导入模板知识点
	public function choosetemplate() {
		$versionid = $this->input->post('versionid');
		$nodes = $this->input->post('nodes');
		$maxorder = $this->input->post('maxorder');
		if ($versionid == 0){
			$crid = $this->roominfo['crid'];
			$uid = $this->user['uid'];
			$chaptername = trim($this->input->post('chaptername'));
			if (!isset($chaptername)) {
				echo json_encode(array('status'=>'-1','msg'=>'添加版本失败，请稍后再试'));
				exit;
			}
			if($this->model('mychapter')->chapter_exists($chaptername,$crid,0)) {
				echo json_encode(array('status'=>'-2','msg'=>'添加版本失败，版本名称已存在，请重新选择'));
				exit;
			}
			$displayorder = 1;
			$maxdisplayorder = $this->model('mychapter')->getmaxdisplayorder(array('crid' => $crid, 'level' => 1));
			if (!empty($maxdisplayorder))
				$displayorder = $maxdisplayorder+1;//排序加1

			$param = array('pid'=>0,'chaptername'=>$chaptername,'crid'=>$crid,'displayorder'=>$displayorder,'uid'=>$uid,'level'=>1);
			$chapterid = $this->model('mychapter')->insert($param);
			if(empty($chapterid)) {
				echo json_encode(array('status'=>'0','msg'=>'添加版本失败，请稍后再试'));
				exit();
			}else{
				$versionid = $chapterid;
			}
		}
		if (empty($versionid)){
			$result = array('status'=>'-1','msg'=>'请先选择版本');
			echo json_encode($result);
			exit;
		}
		if (empty($nodes)) {
			$result = array('status'=>'-2','msg'=>'请选择知识点');
			echo json_encode($result);
			exit;
		}
		$tplchapters = array();
		if (!empty($nodes)) {
			foreach($nodes as $node){
				if($node['level'] == 2) {
					$tplchapters[$versionid][] = $node;
				}
				else {
					$tplchapters[$node['pid']][] = $node;
				}
			}
		}
		//设置从主数据库读取,防止主从服务器来不及同步的问题
		Ebh::app()->getDb()->set_con(0);

		$this->tplchapters = $tplchapters;
		$this->_copychapter($versionid, $versionid);
		$result = array('status'=>'1','chapterlist'=>$this->newchapters,'versionid'=>$versionid,'chaptername'=>$chaptername);
		echo json_encode($result);
		exit;
	}

	/**
	 * 复制知识点
	 * @param  integer $tplpid 原知识点父ID
	 * @param  integer $pid    新知识点父ID
	 */
	private function _copychapter($tplpid, $pid) {
		if (!empty($this->tplchapters[$tplpid])){
			foreach($this->tplchapters[$tplpid] as $value){
				//插入

				$chaptername = $value['chaptername'];
				//value['level'] == 2时判断是否存在同名知识点，如存在，修改名字后面加(1)(2)(3)。
				if ($value['level'] == 2) {
					$newtitlenum = 1;
					$orititle = $chaptername;
					while($this->model('mychapter')->chapter_exists($chaptername, $this->roominfo['crid'], $pid)){
						$chaptername = $orititle . '('.$newtitlenum.')';
						$newtitlenum++;
					}
				}
				$chapterid = $this->model('mychapter')->insert(array('pid'=>$pid,'chaptername'=>$chaptername,'crid'=>$this->roominfo['crid'],'displayorder'=>$value['displayorder'],'uid'=>$this->user['uid'],'level'=>$value['level']));
				if (!empty($chapterid)) {
					$this->newchapters[] = array('chapterid'=>$chapterid, 'pid'=>$pid,'chaptername'=>$chaptername,'displayorder'=>$value['displayorder']);
				}
				if (!empty($this->tplchapters[$value['chapterid']])){
					$this->_copychapter($value['chapterid'], $chapterid);
				}

			}
		}
	}
}