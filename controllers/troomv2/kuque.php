<?php
/**
 * 新版作业控制器类Examv2Controller
 */
//EBH::app()->helper('examv2');
class KuqueController extends ApiControl {
	private $user = NULL;
	private $room = NULL;
	private $k = "";
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo '用户未登陆';
			exit;
		}
		$this->user = $user;
		$this->room = $room = Ebh::app()->room->getcurroom();
		$this->k = authcode(json_encode(array('uid'=>$user['uid'],'crid'=>$room['crid'],'t'=>SYSTIME)),'ENCODE');
		$this->assign('k',$this->k);
		$this->assign('crid',$room['crid']);
		$this->assign('uid',$user['uid']);
		$this->assign('room',$room);
		
		//获取modulename
		$method = $this->uri->uri_method();
		$needmnarr = array('index','schquestion','vFavquestion','kufenxi');
		if(in_array($method,$needmnarr)){
			$mnlib = Ebh::app()->lib('Modulename');
			$mnlib->getmodulename($this,array('modulecode'=>'kuque','tors'=>1,'crid'=>$this->room['crid']));
        }
    }

    /**
	 *添加作业时教师题库操作
	 */
	public function kulist() {
		$this->display('troomv2/exam2/teacher/kulist');
	}

    /*
     * 题库首页
     */
    public function index() {
		$this->display('troomv2/exam2/myquestion');
    }
	
	/**
	 *学校题库界面
	 */
	public function schQuestion() {
		$this->display('troomv2/exam2/schoolquestion');
	}

	/**
	 *题库收藏界面
	 */
	public function vFavQuestion() {
		$this->display('troomv2/exam2/favquestion');
	}

	/**
	 *题库分析界面
	 */
	public function kuFenxi() {
		$this->display('troomv2/exam2/analysisquestion');
	}

	/**
	 *教师录入题库操作
	 */
	public function entryTest() {
		$domain = $_SERVER['HTTP_HOST'];
		$this->assign('domain', $domain);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/entrytest');
	}

	/**
	 *教师录入题库操作
	 */
	public function addKuque() {
		$ques = $this->input->post('',FALSE);
		if (empty($ques))
			exit(0);
		$param = array(
			'k'=>$this->k
		);
		$param['exam']['data'] = $ques['data'];

		$url = '/ku/addtoku';
		echo $this->do_post($url,$param,FALSE);
	}

	/**
	 *教师编辑题库操作ku/kudetail/{kuqid}
	 */
	public function entrytestedit_view() {
		$kuqid = $this->uri->itemid;
		$domain = $_SERVER['HTTP_HOST'];
		if(empty($kuqid)) {
			echo "kuqid为空";
			exit;
		}
		$this->assign('kuqid',$kuqid);
		$this->assign('domain', $domain);
		$this->assign('user', $this->user);
		$this->display('troomv2/exam2/teacher/entrytestedit');
	}

	/**
	 *编辑题库
	 */
	public function editKuqueAjax() {
		$ques = $this->input->post('',FALSE);
		if (empty($ques))
			exit(0);
		$param = array(
			'k'=>$this->k
		);
		$param['kuQuestion'] = $ques['data']['kuQuestion'];
		$param['status'] = 1;

		$temp = json_decode($param['kuQuestion']['data'],1);
		$kuqid = $param['kuQuestion']['kuqid'];

		$addArr = array();//需要添加的知识点
		foreach ($temp['relationSet'] as $rvalue) {
			if ($rvalue['ttype'] != 'CHAPTER') {
				continue;
			}
			$addArr[$rvalue['tid']] = $rvalue;
			$addArr[$rvalue['tid']]['sourceid'] = $kuqid;
		}
		
		$delids = '';
		$qmodel = $this->model('Pubquestion');
		$chapters = $qmodel->getChapterBySourceid($kuqid);//取出原来的数据对比
		if ($chapters) {
			foreach ($chapters as $key=>$value) {
				if (isset($addArr[$value['chapterid']])) {
					unset($addArr[$value['chapterid']]);//剩余的要添加
				} else {
					$delids .= $value['id'].',';//删除的id
				}
			}
		}
		if ($delids) {
			$qmodel->delChapter(substr($delids, 0, -1));
		}
		if ($addArr) {
			$qmodel->addChapter($addArr);
		}
		
		//如果有标题的更新关联标题
		if ($ques['data']['qsubject']) {
			$setParam['sourceid'] = intval($ques['data']['kuQuestion']['kuqid']);
			$setParam['subject'] = $ques['data']['kuQuestion']['qsubject'];
			$qmodel->editQueSubject($setParam);
		}

		$url = '/ku/edit';
		echo $this->do_post($url,$param,FALSE);
	}

	/**
	 *教师题库题目详情数据
	 */
	public function kuQuedetail() {
		$kuqid = intval($this->input->post('kuqid'));
		if (empty($kuqid))
			exit(0);
		$param = array(
			'k'=>$this->k
		);

		$url = '/ku/kudetail/'.$kuqid;
		//单题
		$postRet = $this->do_post($url,$param);
		$kuque = $postRet->kuquestion;
		if ($kuque->uid !=$this->user['uid']) {
			exit(0);
		}
		$kuque->data = json_decode($kuque->data, TRUE);
		$kuque->extdata = json_decode($kuque->extdata, TRUE);
		/*foreach ($kuque->kuQuestionRelationSet as $value) {
			$qsortid[] = $rvalue->tid;
		}
		if (!empty($qsortid))
			array_multisort($qsortid, SORT_ASC, $kuque->kuQuestionRelationSet);*/
		foreach ($kuque->data['relationSet'] as $rvalue) {
			if ($rvalue['ttype'] == 'COURSE') {
				$kuque->ccwid = $rvalue->tid;
			} elseif ($rvalue['ttype'] == 'CHAPTER') {
				$kuque->chapters .= $rvalue['tid'].',';
				$chaptertid['tid'][] = $rvalue['tid'];//构建后面selhtml的tid用
				$chaptertid['path'][] = $rvalue['path'];//构建后面selhtml的path用
			} else {
				$kuque->foldername = $rvalue['relationname'];
				$kuque->folderid = $rvalue['tid'];//关联的课程
			}
		}
		
		$seq = 1;
		$kuque->ques[0] = $kuque->extdata;
		$kuque->ques[0]['subject'] = $kuque->qsubject;
		$kuque->ques[0]['questionid'] = $kuque->kuqid;
		$kuque->ques[0]['type'] = $kuque->queType;
		if ($kuque->queType == 'C') {
			$kuque->ques[0]['score'] = $kuque->quescore / count($kuque->extdata['options']);
		} else {
			$kuque->ques[0]['score'] = $kuque->quescore;
		}
		$kuque->ques[0]['dif'] = $kuque->level;//难度
		$kuque->ques[0]['resolve'] = isset($kuque->extdata['jx']) ? $kuque->extdata['jx'] : '';
		$kuque->ques[0]['dianpin'] = isset($kuque->extdata['dp']) ? $kuque->extdata['dp'] : '';
		$kuque->title = $kuque->qsubject;
		$kuque->qid = $kuque->kuqid;

		//构造selhtml
		//<li data="387"><span>人教版 &gt; 知识点304aaa &gt; 知识点815<a style="padding-left: 20px;" href="javascript:delselectedchapter(387,'treeDemo_2')">删除</a></span></li>
		//第一个li加个first控制样式
		if (!empty($kuque->ques[0]['chapters'])) {
			$i = 1;
			$kuque->ques[0]['selhtml'] = '';
			$text =  substr($kuque->extdata['chapterstxt'], 4, -5);
			$text = str_replace('&gt;', '>', $text);
			$text = str_replace('&lt;', '>', $text);
			$tempArr = explode('</li><li>', $text);//临时存的数组
			foreach ($tempArr as $tkey => $tvalue) {
				$liclass = $i == 1 ? "class='first'" : "";
				$kuque->ques[0]['selhtml'] .= '<li '.$liclass.' data="'.$chaptertid['tid'][$tkey] .'">'.$tvalue;
				$kuque->ques[0]['selhtml'] .= '<a chapterpath="'.$chaptertid['path'][$tkey] .'" style="padding-left: 20px;" href="javascript:delqueselectedchapter('.$seq.",".$chaptertid['tid'][$tkey].")\">删除</a></li>";
			}
		} else {
			$kuque->ques[0]['selhtml'] = '';
		}
		//$ques[$key]['folderid'] = $exam['folderid'];//关联的课程

		$datas = array(
			'kuque'=>$kuque
		);
		echo json_encode($datas);

	}

	//统计分析
	public function kufenxiAjax() {
		$url = "/ku/fenxi";
		$data = array(
			'k'=>$this->k,
		);
		echo  $this->do_post($url,$data,FALSE);
	}

	/**
	 *库列表
	 */
	public function kulistAjax() {
		$param = parsequery();
		$param['k'] = $this->k;
		unset($param['pagesize']);
		$param['crid'] = $this->room['crid'];
		$param['order'] = 'kuqid desc';
		$param['size'] = 10;
		$queType = $this->input->post('quetype');
		$isxuexiao = $this->input->post('isxuexiao');//有该字段就相当于学校题库
		if (empty($isxuexiao)) {
			$param['uid'] = $this->user['uid'];
		}

		//搜索关键字
		$key = $this->input->post('key');
		if (!empty($key)) {
			$param['q'] = $key;
		}
		$param['status'] = 1;
		$queType = $this->input->post('quetype');
		//$ttype = $this->input->post('ttype') ? $this->input->post('ttype') : 'CHAPTER';
		$topchapterid = intval($this->input->post('topchapterid'));
		$secchapterid = intval($this->input->post('secchapterid'));

		//构建tid
		//$param['ttype'] = $ttype;
		$tid = intval($this->input->post('chapterid'));//选择的最下级知识点
		if ($tid) {
			$param['tid'] = $tid;
			$param['ttype'] = 'CHAPTER';
		} else {
			if (!empty($topchapterid)) {//用path获取题库
				if ($secchapterid) {
					$param['path'] = $topchapterid.'/'.$secchapterid.'/';
				} else {
					$param['path'] = $topchapterid.'/';
				}
			}
		}
		if(!empty($queType)) {
			$param['queType'] = $queType;
		}
		$url = '/ku/kulist';
		$postRet = $this->do_post($url,$param);

		//列表
		if (empty($postRet->kuqlist)) {
			echo json_encode(array('list'=>array()));
			exit;
		}
		$kuqlist = $postRet->kuqlist;
		$seq = 0;
		$kuqids = '';//是否
		foreach ($kuqlist as $key => &$value) {
			$kuqids .= $value->kuqid.',';
			$value->data = json_decode($value->data, TRUE);
			$value->extdata = json_decode($value->extdata, TRUE);
			foreach ($value->data['relationSet'] as $rvalue) {
				if ($rvalue['ttype'] == 'COURSE') {
					$value->ccwid = empty($rvalue->tid)?0:$rvalue->tid;
				} elseif ($rvalue['ttype'] == 'CHAPTER') {
					$value->chapters .= $rvalue['tid'].',';
					$chaptertid[$key]['tid'][] = $rvalue['tid'];//构建后面selhtml的tid用
					$chaptertid[$key]['path'][] = $rvalue['path'];//构建后面selhtml的path用
				} else {
					$value->foldername = $rvalue['relationname'];
					$value->folderid = $rvalue['tid'];//关联的课程
				}
			}
			$value->ques[0] = $value->extdata;
			$value->ques[0]['subject'] = $value->qsubject;
			$value->ques[0]['questionid'] = $value->kuqid;
			$value->ques[0]['type'] = $value->queType;
			if ($value->queType == 'C') {
				$value->ques[0]['score'] = $value->quescore / count($value->extdata['options']);
			} else {
				$value->ques[0]['score'] = $value->quescore;
			}
			$value->ques[0]['dif'] = $value->level;//难度
			$value->ques[0]['resolve'] = isset($value->extdata['jx']) ? $value->extdata['jx'] : '';
			$value->ques[0]['dianpin'] = isset($value->extdata['dp']) ? $value->extdata['dp'] : '';
			$value->title = $value->qsubject;
			$value->qid = $value->kuqid;

			//构造selhtml
			//<li data="387"><span>人教版 &gt; 知识点304aaa &gt; 知识点815<a style="padding-left: 20px;" href="javascript:delselectedchapter(387,'treeDemo_2')">删除</a></span></li>
			//第一个li加个first控制样式
			if (!empty($value->ques[0]['chapters']) && !empty($chaptertid[$key])) {
				$i = 1;
				$value->ques[0]['selhtml'] = '';
				$text =  substr($value->extdata['chapterstxt'], 4, -5);
				$text = str_replace('&gt;', '>', $text);
				$text = str_replace('&lt;', '>', $text);
				$tempArr = explode('</li><li>', $text);//临时存的数组
				foreach ($tempArr as $tkey => $tvalue) {
					$liclass = $i == 1 ? "class='first'" : "";
					$value->ques[0]['selhtml'] .= '<li '.$liclass.' data="'.$chaptertid[$key]['tid'][$tkey] .'">'.$tvalue;
					$value->ques[0]['selhtml'] .= '<a chapterpath="'.$chaptertid[$key]['path'][$tkey] .'" style="padding-left: 20px;" href="javascript:delqueselectedchapter('.$seq.",".$chaptertid[$key]['tid'][$tkey].")\">删除</a></li>";
				}
			} else {
				$value->ques[0]['selhtml'] = '';
			}
			$seq++;
			//$ques[$key]['folderid'] = $exam['folderid'];//关联的课程
		}

		//是否收藏,学校题库才能收藏
		if (!empty($kuqids) && $isxuexiao) {
			$favids = $this->model('Pubquestion')->getFavidBySourceids($this->user['uid'],substr($kuqids, 0, -1));
			if ($favids) {
				foreach ($kuqlist as &$value) {
					if (in_array($value->kuqid, $favids)) {
						$value->fav = 1;
					}
				}
			}
		}

		//分页
		$pagestr = ajaxpage($postRet->pageInfo->totalElement,$postRet->pageInfo->size,$postRet->pageInfo->number);

		$datas = array(
			'list'=>$kuqlist,
			'multipage'=>$pagestr,
			'page'=>$param['page'],
			'size'=>$param['size']
		);
		echo json_encode($datas);
	}

	/**
	 **是否已经加入了试题库
	 */
	public function hasaddedAjax(){
		$md5code = $this->input->post('md5code',false);
		if(empty($md5code)) {
			$this->renderJson('100','md5code不能为空');
		}
		$param = array(
			'k'=>$this->k,
			'md5code'=>$md5code
		);
		$url = "/ku/ifinku";
		echo $this->do_post($url,$param,false);
	}

	/**
	 *将指定试题加入到试题库
	 */
	public function addFromQueAjax() {
		$qid = $this->input->post('qid');
		if(!is_numeric($qid) || $qid < 0) {
			$this->renderJson('100','qid不符合规范');
		}
		$param = array(
			'k'=>$this->k
		);
		$url = '/ku/addfromque/'.$qid;
		echo $this->do_post($url,$param,false);
	}

	/**
	 *根据kuqid删除试题
	 */
	public function deleteKuQueAjax(){
		$kuqid = $this->input->post('kuqid');
		if(!is_numeric($kuqid) || $kuqid < 0) {
			$this->renderJson('100','kuqid不符合规范');
		}
		$param = array(
			'k'=>$this->k
		);
		$url = '/ku/delete/'.$kuqid;
		echo $this->do_post($url,$param,false);
	}

	/*
	 * 获取收藏题库
	 */
	public function favQuestion() {
		$param = parsequery();
		$param['pagesize'] = 10;
		$aquestion = $this->model('Pubquestion');
		$param['subjectid'] = intval($this->input->post('subjectid'));
		$param['gradeid'] = intval($this->input->post('gradeid'));
		$param['chapterid'] = intval($this->input->post('chapterid'));
		$param['quetype'] = $this->input->post('quetype');
		$param['curuid'] = $this->user['uid'];
		$param['title'] = $this->input->post('key');

		//获取公共收藏题库
		$result = $aquestion->block_favorite($param);
		if (empty($result['datas'])) {
			$result['datas'] = array();
		} else {
			foreach($result['datas'] as $key=>&$val){
				$val['ques'] = base64str(unserialize($val['ques']));
			}
		}
		$multipage = isset($result['multipage']) ? $result['multipage'] : '';
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode ( 
			array('list'=>$result['datas'],
				'multipage'=>$multipage,
				'page'=>$param['page'],
				'size'=>$param['pagesize']
			) );
	}

	/*
	 * 获取收藏题库,之前的老版本公共题库的删了
	 */
	public function favQuestionv2() {
		$param = parsequery();
		$param['quetype'] = $this->input->post('quetype');
		$param['subject'] = $this->input->post('key');
		$param['pagesize'] = 10;
		$aquestion = $this->model('Pubquestion');
		$param['uid'] = $this->user['uid'];
		$param['crid'] = $this->room['crid'];

		//获取收藏的ids,和分页
		$topchapterid = intval($this->input->post('topchapterid'));
		$secchapterid = intval($this->input->post('secchapterid'));
		$tid = intval($this->input->post('chapterid'));//选择的最下级知识点
		if ($tid) {
			$param['chapterid'] = $tid;
		} else {
			if (!empty($topchapterid)) {//用path获取题库
				if ($secchapterid) {
					$param['path'] = $topchapterid.'/'.$secchapterid.'/';
				} else {
					$param['path'] = $topchapterid.'/';
				}
			}
		}
		$result = $aquestion->getFavoriteList($param);
		//print_r($result);exit;
		//从java获取数据
		if (!empty($result['data'])) {
			foreach ($result['data'] as $value) {
				$postParam['kuqids'][] = $value['sourceid'];
			}
			$postParam['k'] = $this->k;
			$postParam['crid'] = $this->room['crid'];
			$url = '/ku/kulist';
			$postRet = $this->do_post($url,$postParam);

			//列表
			if (empty($postRet->kuqlist)) {
				echo json_encode(array('list'=>array()));
				exit;
			}
			$kuqlist = $postRet->kuqlist;
			$seq = 0;
			foreach ($kuqlist as $key => &$value) {
				$value->data = json_decode($value->data, TRUE);
				$value->extdata = json_decode($value->extdata, TRUE);
				foreach ($value->data['relationSet'] as $rvalue) {
					if ($rvalue['ttype'] == 'COURSE') {
						$value->ccwid = $rvalue->tid;
					} elseif ($rvalue['ttype'] == 'CHAPTER') {
						$value->chapters .= $rvalue['tid'].',';
						$chaptertid[$key]['tid'][] = $rvalue['tid'];//构建后面selhtml的tid用
						$chaptertid[$key]['path'][] = $rvalue['path'];//构建后面selhtml的path用
					} else {
						$value->foldername = $rvalue['relationname'];
						$value->folderid = $rvalue['tid'];//关联的课程
					}
				}

				$value->ques[0] = $value->extdata;
				$value->ques[0]['subject'] = $value->qsubject;
				$value->ques[0]['questionid'] = $value->kuqid;
				$value->ques[0]['type'] = $value->queType;
				if ($value->queType == 'C') {
					$value->ques[0]['score'] = $value->quescore / count($value->extdata['options']);
				} else {
					$value->ques[0]['score'] = $value->quescore;
				}
				$value->ques[0]['dif'] = $value->level;//难度
				$value->ques[0]['resolve'] = isset($value->extdata['jx']) ? $value->extdata['jx'] : '';
				$value->ques[0]['dianpin'] = isset($value->extdata['dp']) ? $value->extdata['dp'] : '';
				$value->title = $value->qsubject;
				$value->qid = $value->kuqid;

				//构造selhtml
				//<li data="387"><span>人教版 &gt; 知识点304aaa &gt; 知识点815<a style="padding-left: 20px;" href="javascript:delselectedchapter(387,'treeDemo_2')">删除</a></span></li>
				//第一个li加个first控制样式
				if (!empty($value->ques[0]['chapters']) && !empty($chaptertid[$key])) {
					$i = 1;
					$value->ques[0]['selhtml'] = '';
					$text =  substr($value->extdata['chapterstxt'], 4, -5);
					$text = str_replace('&gt;', '>', $text);
					$text = str_replace('&lt;', '>', $text);
					$tempArr = explode('</li><li>', $text);//临时存的数组
					foreach ($tempArr as $tkey => $tvalue) {
						$liclass = $i == 1 ? "class='first'" : "";
						$value->ques[0]['selhtml'] .= '<li '.$liclass.' data="'.$chaptertid[$key]['tid'][$tkey] .'">'.$tvalue;
						$value->ques[0]['selhtml'] .= '<a chapterpath="'.$chaptertid[$key]['path'][$tkey] .'" style="padding-left: 20px;" href="javascript:delqueselectedchapter('.$seq.",".$chaptertid[$key]['tid'][$tkey].")\">删除</a></li>";
					}
				} else {
					$value->ques[0]['selhtml'] = '';
				}
				$seq++;
				//$ques[$key]['folderid'] = $exam['folderid'];//关联的课程
			}
		} else {
			echo json_encode(array('list'=>array()));
			exit;
		}
		$multipage = isset($result['multipage']) ? $result['multipage'] : '';
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode ( 
			array('list'=>$kuqlist,
				'multipage'=>$multipage,
				'page'=>$param['page'],
				'size'=>$param['pagesize']
			) );
	}

	/*
	 * 获取公共题库
	 */
	public function pubQuestion() {
		$param = parsequery();
		$aquestion = $this->model('Pubquestion');
		$param['subjectid'] = intval($this->input->post('subjectid'));
		$param['gradeid'] = intval($this->input->post('gradeid'));
		$param['chapterid'] = intval($this->input->post('chapterid'));
		$param['quetype'] = $this->input->post('quetype');
		$param['curuid'] = $this->user['uid'];
		$param['title'] = $this->input->post('key');
		$param['order'] = 'aqid asc'; 
		$param['pagesize'] = 10;
		
		//获取公共收藏题库
		$result = $aquestion->block($param);
		if (empty($result['datas'])) {
			$result['datas'] = array();
		} else {
			foreach($result['datas'] as &$val){
				$val['ques'] = base64str(unserialize($val['ques']));
			}
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode ( array('list'=>$result['datas'],
			'multipage'=>$result['multipage'],
			'size'=>$param['pagesize'],
			'page'=>$param['page'] ) );
	}


	/*
	 * 添加收藏题库
	 */
	public function addFavorite() {
		$relation = $this->input->post('relation');
		$aqid = intval($this->input->post('aqid'));
		$quetype = $this->input->post('quetype');
		$subject = $this->input->post('qsubject');

		if ( ! $aqid)
			exit();
		$aquestion = $this->model('Pubquestion');

		//存关联
		if ($relation) {
			foreach ($relation as $key=>$value) {
				if ($value['ttype'] != 'CHAPTER') {
					unset($relation[$key]);
				} else {
					$relation[$key]['sourceid'] = $aqid;
				}
			}
			if ($relation)
				$aquestion->addRelation($relation);
		}

		//存题目标题
		if ($subject) {
			$addParam['sourceid'] = $aqid;
			$addParam['subject'] = $subject;
			$aquestion->addQuesRelation($addParam);
		}

		$uid = $this->user['uid'];
		$crid = $this->room['crid'];

		$param = array('uid'=>$uid,'aqid'=>$aqid,'crid'=>$crid,'quetype'=>$quetype);
		$result = $aquestion->addfavorite($param);
		if($result)
			echo json_encode(array('status'=>1));
		else
			echo json_encode(array('status'=>0));
	}

	/*
	 *删除题库
	 */
	public function delFavorite() {
		$aquestion = $this->model('Pubquestion');
		$uid = $this->user['uid'];
		$aqid = intval($this->input->post('aqid'));
		if(!empty($aqid)) {
			$param = array('uid'=>$uid,'aqid'=>$aqid);
			$result = $aquestion->delfavorite($param);
			if($result)
				echo json_encode(array('status'=>1));
			else
				echo json_encode(array('status'=>0));
		}
	}

	/**
	 *获取年级
	 */
	public function getGrade() {
		$grade = $this->model('grade');
		$theblockarr = $grade->getgradelist(array('limit'=>'0,10000'));
		echo json_encode($theblockarr);
	}

	/**
	 *获取科目
	 */
	public function getSubject() {
		$subject = $this->model('subject');
		$theblockarr = $subject->getsubjectlist(array('limit'=>'0,10000'));
		echo json_encode($theblockarr);
	}

	/**
	 *知识点树
	 */
	public function getChapterTree() {
		$subjectid = intval($this->input->get('subjectid'));
		$gradeid = intval($this->input->get('gradeid'));
		//$pid = intval($this->input->get('pid'));
		$chapter = $this->model('chapter');
		$theblockarr = $chapter->getchapterlist(array('limit'=>'0,10000','subjectid'=>$subjectid,'gradeid'=>$gradeid));
		echo json_encode($theblockarr);
	}
	
	/*
	 **私有方法，提交数据到java后台返回json数据
	 */
	private function do_post($uri, $data, $check = true){
		$url = 'http://'.__SURL__.$uri;
		$ch = curl_init();
		$datastr = json_encode($data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($ch, CURLOPT_POST, TRUE); 
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$datastr);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($datastr))
		);
		curl_setopt($ch, CURLOPT_URL, $url);
		$ret = curl_exec($ch);
		curl_close($ch);
		if($check == true) {
			$ret = json_decode($ret);
			$this->apiResCheck($ret);
			return $ret->datas;
		}else {
			return $ret;
		}
	}	

	/*
	 **输出提示的信息
	 */
	private function echoMsg($msg){
	    header("Content-type: text/html; charset=utf-8");
	    echo '<span style="font-size:16px;font-weight:bold;color:#f00;">',$msg,'</span>';
	    echo '<a style="font-size:16px;font-weight:bold;" href="javascript:history.go(-1)">点我返回!</a>';
	    exit;
	}

	/*
	 **检查java服务器返回的数据
	 */
	private function apiResCheck($res,$ajax = false){
	    if(empty($res)) {
	        $this->echoMsg("服务器取数据失败");exit;
	    }
	    if($res->errCode != 0) {
	        log_message("code:".$res->errCode.'--msg:'.$res->errMsg);
	        $this->echoMsg($res->errMsg);exit;
	    }
	}

	/*
	 **按规定向前台传数据
	 */
 	private function renderJson($errCode = 0,$errMsg = "",$datas = array() ,$ifexit = true) {
        echo json_encode(array('errCode'=>$errCode,'errMsg'=>$errMsg,'datas'=>$datas));
        if($ifexit) {
            exit;
        }
    }

    /*
	 **把1000,转成A
	 **param $str string
	 */
 	private function numtostr($choicestr = '') {
 		if (!isset($choicestr))
 			return;
        $sstr = 'ABCDEFGHIJKLMNOPQ';
        $strArr = str_split($sstr);
        $returnStr = '';
        foreach ($strArr as $key => $value) {
        	if (substr($choicestr, $key, 1) && $value)
        		$returnStr .= $value;
        }
        return $returnStr;
    }

}//class end
