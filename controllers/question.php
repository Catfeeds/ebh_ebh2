<?php

/**
 * 答疑专区列表页
 */
class QuestionController extends PortalControl {
    public function index() {
    	error_reporting(E_ALL);
        $this->_show_question();
    }
	function _show_question() {
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		//全部问题分类
        $curpcatid = $this->uri->uri_attr(0);	//当前选择的大分类
		$curcatid = $this->uri->uri_attr(1);		//当前选择的小分类
		$curgrade = $this->uri->uri_attr(2);		//年级
		$curcat = '';	//当前的子分类信息
		
		//非法的分类处理
		if(!is_numeric($curpcatid) || $curpcatid < 0)	
			$curpcatid = 0;
		if(!is_numeric($curcatid) || $curcatid < 0)
			$curcatid = 0;
		if(!is_numeric($curgrade) || $curgrade < 0)
			$curgrade = 0;

		$catmodel  = $this->model('Category');
		$folderModel = $this->model('Folder'); 
		//获取答疑父分类
		$pcatkey = $this->cache->getcachekey('category',array(0,5));
		$pcatlist = $this->cache->get($pcatkey);
		if(empty($pcatlist)) {
			$pcatlist = $catmodel->getCatlistByUpid(0,5,NULL);
			$this->cache->set($pcatkey,$pcatlist,30);
		}
		$catidlist = '';	//子分类的id组合，如1,2,3等方式
		$curpcat = '';	//当前的大分类信息
		$curchildcatlist = '';	//当前大分类下的子分类列表
		
		$catcachekey = $this->cache->getcachekey('category','askallcatelist');	//缓存所有的子分类key
		$catlist = $this->cache->get($catcachekey);
		if(empty($catlist)) {
			//循环获取子分类
			foreach($pcatlist as $pcat){
				$childlist = $catmodel->getCatlistByUpid($pcat['catid'],5,NULL);
				$catlist[] = array('pcat'=>$pcat,'childlist'=>$childlist);
			}
			$this->cache->set($catcachekey,$catlist,30);	//缓存30分钟
		}
		if($curpcatid > 0) {	//根据已取得的所有分类获取当前选择的大分类和小分类值
			foreach($catlist as $cat) {
				if($cat['pcat']['catid'] == $curpcatid) {
					$curpcat = $cat['pcat'];
					$curchildcatlist = $cat['childlist'];
					if($curcatid > 0) {
						foreach($cat['childlist'] as $child) {
							if($child['catid'] == $curcatid) {
								$curcat = $child;
								break;
							}
						}
					}
					break;
				}
			}
		}

		
		//设置年级信息
		$gradelist = '';	//分类对应的年级列表
		if(!empty($curpcat)) {	//存在大分类，则获取大分类对应的年级列表
			$askgrade = Ebh::app()->getConfig()->load('askgrade');
			if(isset($askgrade[$curpcat['keyword']]))	//用答疑分类的关键字 keyword来标示 表示年段对应的编号，如1为小学 2为初中 3为高中
				$gradelist = $askgrade[$curpcat['keyword']];
		}

		$curgradename = '';
		if($curgrade > 0 && !empty($gradelist)) {
			if(isset($gradelist[$curgrade]))
				$curgradename = $gradelist[$curgrade];
		}

		//获取答疑列表
		$keyword = $this->input->get('keyword');	//搜索关键字，此处会与头部搜索冲突，所以改成keyword
		$sortmode = $this->uri->sortmode;	//排序方式 0 所有问题（默认） 1 最新问题（时间） 2答疑排行（回答数）

		$param = parsequery();
		//答疑列表
		$questmodel = $this->model('askquestion');
		if($sortmode == 2){
			$param['order'] = 'q.answercount desc';
		}
		if(!empty($curcatid)) {	//选择子分类，则只取子分类下的答疑
			$param['catid'] = $curcatid;
		} else if(!empty($catidlist)){	//获取大分类对应的答疑和大分类下子分类对应的所有答疑
			$param['catidlist'] = $curpcatid.','.$catidlist;
		}
		$param['grade'] = $curgrade;
		$param['q'] = $keyword;
		$questionkey = $this->cache->getcachekey('askquestion',$param);
		$questions = $this->cache->get($questionkey);
		if(empty($questions)) {
			if(!empty($user)){
				$param['auid'] = $user['uid'];
				$param['shield'] = 0;
				$questionlist = $questmodel->getasklistwithfavorite($param);
				$count = $questmodel->getasklistcountbycatid($param);
			}else{
				$param['shield'] = 0;
				$questionlist = $questmodel->getaskquestionlist($param);
				$count = $questmodel->getasklistcountbycatid($param);
			}
 			foreach($questionlist as &$question){
				$folder = $folderModel->getfolderbyid($question['folderid']);
				$question['foldername'] = $folder['foldername'];
			} 
			$questions =  array('list'=>$questionlist,'count'=>$count);	//一般的列表数组，带分页的，将以这种形式存放， list 为列表数据，count 为总数
			$this->cache->set($questionkey,$questions,30);	//缓存
		}  else {
			$questionlist = $questions['list'];
			$count = $questions['count'];
		}
		$pagestr = show_page($count);
		//$abc=$this->cache->set('questionlist',$questionlist,30);
		//获取左侧广告
		$leftAds = $this->getLeftAds('question_left',2);
		//获取有最佳答案的十条列表
		$qWithBest = $this->getListWithBest(10);
		$this->assign('qWithBest',$qWithBest);
		$this->assign('leftAds',$leftAds);
		$this->assign('catlist', $catlist);
		$this->assign('sortmode',$sortmode);
		$this->assign('curpcatid',$curpcatid);
		$this->assign('curcatid',$curcatid);
		$this->assign('curcat',$curcat);
		$this->assign('curpcat',$curpcat);
		$this->assign('keyword',$keyword);
		$this->assign('curchildcatlist',$curchildcatlist);
		$this->assign('curgrade',$curgrade);
		$this->assign('curgradename',$curgradename);
		$this->assign('questionlist',$questionlist);
		$this->assign('gradelist',$gradelist);
		$this->assign('pagestr',$pagestr);
		$this->assign('count',$count);
		$this->assign('subtitle','答疑专区');
		$this->display('common/question');
	}
	function view() {	//答疑详情
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
        $this->assign('user', $user);
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//答疑详情
		$qid = $this->uri->itemid;
		$param['qid'] = $qid;
		$param['pagesize'] = 10;
		$askmodel = $this->model('askquestion');
		$qdetail = $askmodel->getdetailaskbyqid($qid,$user['uid']);
		if($qdetail['shield']==1){//屏蔽
			show_404();
			exit;
		}
		$askmodel->addviewnum($qid);
		
		$this->assign('qdetail', $qdetail);
		//回答答疑列表
		$askanswers = $askmodel->getdetailanswersbyqid($param);
		$this->assign('askanswers', $askanswers);
		//答题动态
		//$askanswer = $askmodel->getaskanswers();
		//$this->assign('askanswer', $askanswer);
		//热门问题
		$param = array('order'=>'answercount desc','limit'=>'0,5');
		$askquestion = $askmodel->getquestionhot($param);
		$this->assign('askquestion', $askquestion);
		$subtitle = '答疑专区';
		if(!empty($qdetail))
			$subtitle = $qdetail['title']. '-答疑专区';
		$this->assign('subtitle',$subtitle);
		$this->display('common/question_view');
	}
	/**
     * 添加感谢
     */
	public function addthank(){
		$qid = $this->input->post('qid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
		$reviewmodel = $this->model('Review');
		$logparam =  array('uid'=>$user['uid'],'toid'=>$qid,'opid'=>1,'type'=>'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次投票
			echo 'thatday';
			exit();
		}
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addthank($qid);
        if ($result > 0) {
			$logparam['message'] = '回答感谢';
			$logparam['fromip'] = $this->input->getip();
			$reviewmodel->insertlog($logparam);
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
	}
	/**
     * 添加回答的感谢
     */
	public function addthankanswer() {
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$reviewmodel = $this->model('Review');
		$logparam =  array('uid'=>$user['uid'],'toid'=>$aid,'opid'=>1,'type'=>'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次投票
			echo 'thatday';
			exit();
		}
        $param = array('qid' => $qid, 'aid' => $aid);
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addthankanswer($param);
        if ($result > 0) {
			$logparam['message'] = '回答感谢';
			$logparam['fromip'] = $this->input->getip();
			$reviewmodel->insertlog($logparam);
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }
	/**
     * 关注或取消关注问题
     */
    public function addfavorit() {
        $qid = $this->input->post('qid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $flag = $this->input->post('flag');
        $param = array('uid' => $user['uid'], 'qid' => $qid);
        $askmodel = $this->model('Askquestion');
        if ($flag == 1) {
            $result = $askmodel->addfavorit($param);
        } else {
            $result = $askmodel->delfavorit($param);
        }
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }
	/**
     * 添加回答
     */
    public function addanswer() {
		echo 'fail';	//屏蔽网站外的回答
            exit();
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $param = array();
        $param['qid'] = $qid;
        $param['uid'] = $user['uid'];
        $param['message'] = $this->input->post('message');
        $param['audiosrc'] = $this->input->post('audio');
        $param['audioname'] = substr( $param['audiosrc'] , strrpos($param['audiosrc'] , '/')+1 );
        $param['imagename'] = $this->input->post('imagename');
        $param['imagesrc'] = $this->input->post('imagesrc');
        $param['attname'] = $this->input->post('attname');
        $param['attsrc'] = $this->input->post('attsrc');
        $param['lastansweruid'] = $user['uid'];
		if(!isset($param['message']))
				return false;
		else{
			$param['message'] = h($param['message']);
		}
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addanswer($param);
        $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
        $upparam = array(
        	'qid'=>$qid,
        	'uid'=>$ask['uid'],
        	'lastansweruid'=>$user['uid']
        );
        $askmodel->update($upparam);
        if ($result > 0) {
            echo 'success';
            fastcgi_finish_request();
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>21,'qid'=>$param['qid']));
            if($ask['tid'] == $user['uid']){
               $askmodel->setAnswered($qid,1);
               //短信发送
               EBH::app()->lib('SMS')->run($qid,$user['uid'],2);
            }
            exit();
        }
        echo 'fail';
        exit();
    }
	/**
     * 删除我的提问
     */
    public function delask() {
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        //$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $ask = $askmodel->getaskbyqid($qid);
        if (empty($ask) || $ask['uid'] != $user['uid']) {
            echo 'fail';
            exit();
        }
        //删除回答对应的文件
//        $answerlist = $askmodel->getanswersbyqid($qid);
//        foreach($answerlist as $myanswer) {
//            
//        }
        $result = $askmodel->delask($qid);
        if ($result) {
            echo 'success';
            exit();
        } else {
            echo 'fail';
            exit();
        }
    }
	/*
	设置最佳答案
	*/
	public function setbest(){
		$qid = $this->input->post('qid');
		$aid = $this->input->post('aid');
        $user = Ebh::app()->user->getloginuser();
		if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$param = array('uid' => $user['uid'], 'qid' => $qid, 'aid'=>$aid);
		$askmodel = $this->model('Askquestion');
		$result = $askmodel->setbest($param);
		if ($result) {
            echo 'success';
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>14,'aid'=>$aid));
            exit();
        } else {
            echo 'fail';
            exit();
        }
	}

	//获取互动答疑左侧广告广告
	public function getLeftAds($code ='question_left',$num = 2){
		$adsModel = $this->model('pads');
		$leftAds = $adsModel->getAdsByCode('question_left',$num);
		return $leftAds;
	}
	//获取已有最佳答案的问题列表
	public function getListWithBest($num){
		return $this->model('askquestion')->getQuestionWithBest($num);
	}
}
?>
