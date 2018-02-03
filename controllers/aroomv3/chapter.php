<?php
/*
课程
*/
class ChapterController extends ARoomV3Controller{
	/*
	知识点列表
	*/
	public function chapterList(){	
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['vid'] = $this->input->get('vid');
		$istpl = $this->input->get('istpl');
		$istree = $this->input->get('istree');
		if(!empty($istpl)){
			$chaptertemplate = Ebh::app()->getConfig()->load('chaptertemplate');
			$data['crid'] = $chaptertemplate['crid'];//模板的学校编号
			if(empty($data['crid'])){
				$this->renderjson(0,'',array());
			}
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.chapterList')->addParams($data)->request();
		// if(empty($result) && $data['vid'] === '0'){//没有版本时，添加默认版本
			// $adddata = array('pid'=>0,'chaptername'=>'默认版本','displayorder'=>100,'crid'=>$data['crid'],'uid'=>$data['uid']);
			// $this->apiServer->reSetting()->setService('Aroomv3.Chapter.addChapter')->addParams($adddata)->request();
			// $result = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.chapterList')->addParams($data)->request();
		// }
		
		if(!empty($istree)){
			$result = $this->getTree($result,$data['vid']);
		}
		
		$this->renderjson(0,'',$result);
	}
	
	/*
	获取树结构
	*/
	private function getTree(&$nodes,$pid){
		$tree = array();
		foreach($nodes as $node){
			$tnode = $node;
			if($node['pid'] == $pid){
				$tnode['children'] = $this->getTree($nodes,$node['chapterid']);
				$tree[]= $tnode;
			}
		}
		return $tree;
	}
	
	/*
	课程选择知识点
	*/
	public function selectChapter(){
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['chapterid'] = $this->input->post('chapterid');
		$data['folderid'] = $this->input->post('folderid');
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.selectChapter')->addParams($data)->request();
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	保存知识点
	*/
	public function saveChapter(){
		$data['crid'] = $this->roominfo['crid'];
		$data['uid'] = $this->user['uid'];
		$data['pid'] = $this->input->post('pid');
		$data['chaptername'] = trim($this->input->post('chaptername'));
		$data['displayorder'] = intval($this->input->post('displayorder'));
		$data['chapterid'] = intval($this->input->post('chapterid'));
		
		if(empty($data['chaptername'])){
			$this->renderjson(1,'知识点名称不能为空');
		}
		$isexists = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.isExists')->addParams($data)->request();
		if($isexists){
			$this->renderjson(1,'知识点重名');
		}
		if(empty($data['chapterid'])){//添加
			$chapterid = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.addChapter')->addParams($data)->request();
		} else {//编辑
			$chapterid = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.editChapter')->addParams($data)->request();
			if($chapterid !== FALSE){
				$chapterid = $data['chapterid'];
				//同级后面的知识点排序+1
				$nextids = $this->input->post('nextids');
				$validid = TRUE;
				if(!empty($nextids)){
					$nextids = explode(',', $nextids);
					//判断id是否合法
					foreach($nextids as $id){
						if(!is_numeric($id)){
							$validid = FALSE;
							break;
						}
					}
				}
				
				if(!empty($nextids) && $validid){
					$this->apiServer->reSetting()->setService('Aroomv3.Chapter.increaseOrder')->addParams($data)->request();
				}
			}
		}
		
		if(is_numeric($chapterid) && $chapterid>0){
			$this->renderjson(0,'操作成功',array('chapterid'=>$chapterid));
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	删除知识点
	*/
	public function del(){
		$data['crid'] = $this->roominfo['crid'];
		$data['chapterid'] = $this->input->post('chapterid');
		$children = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.getChildren')->addParams($data)->request();
		if(!empty($children)){
			$this->renderjson(1,'有子知识点,不能删除');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.del')->addParams($data)->request();
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
	}
	
	/*
	版本上下移动
	*/
	public function changeChapterOrder(){
		$data['crid']= $this->roominfo['crid'];
		$data['chapterid'] = $this->input->post('chapterid');
		$data['isup'] = $this->input->post('isup');
		if(empty($data['chapterid'])){
			$this->renderjson(1,'参数错误');
		}
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.changeChapterOrder')->addParams($data)->request();
		if($result !== FALSE){
			$this->renderjson(0,'操作成功');
		} else {
			$this->renderjson(1,'操作失败');
		}
		

	}
	
	//导入模板知识点
	public function chooseTemplate() {
		$versionid = $this->input->post('vid');
		$chapterlist = $this->input->post('chapterlist');
		if ($versionid == 0){
			$crid = $this->roominfo['crid'];
			$uid = $this->user['uid'];
			$chaptername = trim($this->input->post('chaptername'));
			if (!isset($chaptername)) {
				$this->renderjson(1,'版本名称不能为空');
			}
			$dataexists['chaptername'] = $chaptername;
			$dataexists['crid'] = $crid;
			$isexists = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.isExists')->addParams($dataexists)->request();
			if($isexists) {
				$this->renderjson(1,'版本名称已存在，请重新选择');
			}
			$displayorder = 1;
			$maxdisplayorder = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.maxOrder')->addParams($dataexists)->request();
			
			if (!empty($maxdisplayorder))
				$displayorder = $maxdisplayorder+1;//排序加1

			$param = array('pid'=>0,'chaptername'=>$chaptername,'crid'=>$crid,'displayorder'=>$displayorder,'uid'=>$uid);
			$chapterid = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.addChapter')->addParams($param)->request();
			if(empty($chapterid)) {
				$this->renderjson(1,'添加版本失败，请稍后再试');
			}else{
				$versionid = $chapterid;
			}
		}
		if (empty($versionid)){
			$this->renderjson(1,'请先选择版本');
		}
		if (empty($chapterlist)) {
			$this->renderjson(1,'请选择知识点');
		}
		$tplchapters = array();
		if (!empty($chapterlist)) {
			foreach($chapterlist as $chapter){
				if($chapter['level'] == 2) {
					$tplchapters[$versionid][] = $chapter;
				}
				else {
					$tplchapters[$chapter['pid']][] = $chapter;
				}
			}
		}
		//设置从主数据库读取,防止主从服务器来不及同步的问题
		// Ebh::app()->getDb()->set_con(0);

		$this->tplchapters = $tplchapters;
		$this->copyChapter($versionid, $versionid);
		// $result = array('status'=>'1','chapterlist'=>$this->newchapters,'versionid'=>$versionid,'chaptername'=>$chaptername);
		$this->renderjson(0,'操作成功');
	}

	/**
	 * 复制知识点
	 * @param  integer $tplpid 原知识点父ID
	 * @param  integer $pid    新知识点父ID
	 */
	private function copyChapter($tplpid, $pid) {
		if (!empty($this->tplchapters[$tplpid])){
			foreach($this->tplchapters[$tplpid] as $value){
				//插入

				$chaptername = $value['chaptername'];
				//value['level'] == 2时判断是否存在同名知识点，如存在，修改名字后面加(1)(2)(3)。
				if ($value['level'] == 2) {
					$newtitlenum = 1;
					$orititle = $chaptername;
					while($this->apiServer->reSetting()->setService('Aroomv3.Chapter.isExists')->addParams($dataexists)->request(array('chaptername'=>$chaptername,'crid'=>$this->roominfo['crid'],'chapterid'=>$pid))){
						$chaptername = $orititle . '('.$newtitlenum.')';
						$newtitlenum++;
					}
				}
				$param = array('pid'=>$pid,'chaptername'=>$chaptername,'crid'=>$this->roominfo['crid'],'displayorder'=>$value['displayorder'],'uid'=>$this->user['uid']);
				$chapterid = $this->apiServer->reSetting()->setService('Aroomv3.Chapter.addChapter')->addParams($param)->request();
				
				if (!empty($chapterid)) {
					$this->newchapters[] = array('chapterid'=>$chapterid, 'pid'=>$pid,'chaptername'=>$chaptername,'displayorder'=>$value['displayorder']);
				}
				if (!empty($this->tplchapters[$value['chapterid']])){
					$this->copyChapter($value['chapterid'], $chapterid);
				}

			}
		}
	}
}