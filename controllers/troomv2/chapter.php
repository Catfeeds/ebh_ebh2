<?php
/**
 *知识点控制器
 */
class ChapterController extends CControl{
	public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
		$this->roominfo = Ebh::app()->room->getcurroom();
		$this->user = Ebh::app()->user->getloginuser();
    }
    /**
     * 知识点浏览
     */
	public function index(){
		$versionlist = $this->model('mychapter')->getversionlist($this->roominfo['crid']);
		$this->assign('versionlist', $versionlist);
		$this->display('troomv2/chapter');
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



    /*
	 *获取顶级知识点
     */
	public function gettopchapter(){
		$mychap = $this->model('Mychapter');
		$crid = $this->input->post('crid');
		$qid = $this->input->post('qid');
		$chapterids = $this->input->post('chapters');
		$chapters = $mychap->getchaptersbycrid($crid);
		if(empty($qid)){
			echo json_encode($chapters);
		}else{

			//$schquechapter = $this->model('Schquechapters');
			//$chapteridlist = $schquechapter->getlist(array('qid'=>$qid));
			$chapteridlist = explode(',', $chapterids);
			$chapteridsarr = array();
			$mychapteridpath = array();
			$treedata = array();
			$chapterversion = 0;
			$vername = '';
			
			if(!empty($chapteridlist[0])){
				//设置选择项
				$selectnodes = array();
				foreach ($chapteridlist as $item){
					$selectnodes[] = $item['chapterid'];
				}
				$mychaplist = $mychap->getmychapterlist(array('chapterids'=>$selectnodes,'crid'=>$crid));
				foreach ($mychaplist as $item){
					$chapterpath = $item['chapterpath'];
					$chapterpath = substr($chapterpath, 1);
					$chapterarr = explode('/', $chapterpath);
					$mychapteridpath[] = $chapterarr;
					$chapteridsarr = array_merge($chapterarr,$chapteridsarr);
				}	
				$chapteridsarr = array_unique($chapteridsarr);
				$chapterlist = $mychap->getmychapterlist(array('chapterids'=>$chapteridsarr));
				foreach ($chapterlist as $val){
					$chapternames[$val['chapterid']] = $val['chaptername'];
				}
				//路径格式化
				$htmlstr = '';
				foreach ($mychapteridpath as $path){
					$fullpathstr = '';
					$formatpath = '/';
					$mynodekey = count($path) - 1;
					$mynode = $path[$mynodekey];
					foreach ($path as $p){
						$fullpathstr .= $chapternames[$p] . ' > ';
						$formatpath .= $p .'/';
					}
					$formatpath = substr($formatpath, 0, strlen($formatpath) - 1);
					$fullpathstr = substr($fullpathstr, 0, strlen($fullpathstr) - 3);
					$htmlstr .= '<li data="'.$mynode.'">'.$fullpathstr;
					$htmlstr .= '<a chapterpath="'.$formatpath.'" style="padding-left: 20px;" href="javascript:delselectedchapter('.$mynode.",'treeDemo_0')\">删除</a></li>";
				}
				//默认知识树版本
				$version = $mychapteridpath[0][0];
				$vername = $chapternames[$version];
				if($version > 0){
					$chapterid = $version;
					$chapterss = $mychap->getnodelistv2($crid,$chapterid);
					if(!empty($chapteridlist) && !empty($chapterss)){
						//设置选择项
						foreach ($chapterss as $k=>$v){
							if(in_array($v['id'],$selectnodes)){
								$chapterss[$k]['checked'] = true;
							}
						}
					}
				}
			}

			$arr = array();
			$arr['version'] = isset($version) ? $version : '';
			$arr['vername'] = isset($vername) ? $vername : '';
			$arr['treedata'] = isset($chapterss) ? $chapterss : '';
			$arr['chapters'] = isset($chapters) ? $chapters : '';
			echo json_encode($arr);
		}
	}

	/*
	 *获取下级知识点
	 */
	public function getsecchapter() {
		$crid = $this->input->post('crid');
		$chapterid = $this->input->post('topid');
		$mychap = $this->model('Mychapter');
		$chapters = $mychap->getchaptersbytoppid($chapterid,$crid);
		echo json_encode($chapters);
	}

	/*
	 *获取知识点列表
	 */
	public function getlist() {
		$mychap = $this->model('Mychapter');
		$crid = $this->input->post('crid');
		if($crid >0){
			$folderid = $this->input->post('folderid');
			$chapterid = $this->input->post('chapterid');
			$qid = $this->input->post('qid');
			$topid = $this->input->post('topid');

			$folderid = intval($folderid);
			$chapterid = intval($chapterid);
			$qid = intval($qid);
			$topid = intval($topid);

			$versionid = $topid > 0 ? $topid .'/'. $chapterid : $chapterid;
			
			$chapters = $mychap->getnodelistv2($crid,$versionid);
			if($qid >0){
				$schquechapter = $this->model('Schquechapter');
				$chapteridlist = $schquechapter->getlist(array('qid'=>$qid));
				if(!empty($chapteridlist) && !empty($chapters)){
					//设置选择项
					$selectnodes = array();
					foreach ($chapteridlist as $item){
						$selectnodes[] = $item['chapterid'];
					}
					foreach ($chapters as $k=>$v){
						if(in_array($v['id'],$selectnodes)){
							$chapters[$k]['checked'] = true;
						}
					}
				}
			}
			echo json_encode($chapters);
			exit();
		}

		$folderid = $this->input->post('folderid');
		$chapterid = $this->input->post('chapterid');
		$folderid = intval($folderid);
		$chapterid = intval($chapterid);
		
		$param = array('folderid'=>$folderid,'pid'=>$chapterid);
		$chapters = $mychap->getchapterlist($param);
		echo json_encode($chapters);
	}
}