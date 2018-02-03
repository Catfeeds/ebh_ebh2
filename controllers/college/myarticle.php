<?php
/**
 * 原创文章接口
 */
class MyarticleController extends CControl {
	public $fromAdmin='';
    public function __construct() {
        parent::__construct();
		$this->roominfo = $roominfo = Ebh::app()->room->getcurroom();
		$this->user = $user = Ebh::app()->user->getloginuser();
		$this->fromAdmin = $this->input->get('seg');//后台管理员审核学生的文章，可以点击文章详情
		if ($this->fromAdmin) {
            $verifyCode = 0;
			$checkRoom = Ebh::app()->room->checkRoomControlV3($verifyCode);
			if (!$checkRoom) {
				header("Content-type: text/html; charset=utf-8");
				echo '没有权限';exit;
			}
			$this->assign('seg',1);
		} else if(empty($this->uri->itemid)) {//非详情页面需要检查权限
			if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
				$check = Ebh::app()->room->checkstudent(TRUE);
				$this->assign('check',$check);
			} else {
				Ebh::app()->room->checkstudent();
			}
		}
		$q = $this->input->get('q');
		$this->assign('q',$q);
		$this->assign('uid',$user['uid']);
		$this->apiServer = Ebh::app()->getApiServer('ebh');
    }

	public function index(){//所有原创文章
		$get = $this->input->get();
		if (!empty($get['q'])) {
			$parameters['q'] = $get['q'];
		}
		$parameters = parsequery();
		$parameters['crid'] = $this->roominfo['crid'];
		$parameters['status'] = 1;
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.list')->addParams($parameters)->request();
		if (!empty($result)) {
			if (!empty($result['list'])) {
				foreach ($result['list'] as &$value) {
					$value['subject'] = shortstr($value['subject'],100,'...');
					$value['message'] =  shortstr(strip_tags($value['message']),200,'......');
				}
			}
			$pagestr = show_page($result['totalpage'],20);
			$this->assign('list',$result['list']);
			$this->assign('pagestr',$pagestr);
		}
		$this->assign('method','index');
		$this->display('college/myarticle');
	}

	/**
	 * 上传页面
	 */
	public function uploadArticle() {
		$editor = Ebh::app()->lib('UEditor');
		$this->assign('editor', $editor);
		$this->display('college/article_upload');
	}

	/**
	 * 上传接口
	 */
	public function addArticle(){
		$post = $this->input->post('',FALSE);
		$title = $post['title'];
		$message = $post['message'];
		if (!$title || !$message) {
			$this->renderjson(-1,'参数为空');
		}
		if (mb_strlen($title,'utf8')>30) {
			$this->renderjson(-1,'标题太长');
		}
		$parameters['title'] = $title;
		$parameters['message'] = $message;
		$parameters['uid'] = $this->user['uid'];
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.add')->addParams($parameters)->request();
		if ($result) {
			//学分增加
			$param['uid'] = $this->user['uid'];
	        $param['crid'] = $this->roominfo['crid'];
	        $param['type'] = 2;//原创文章
	        $param['fromip'] = getip();
	        $param['articleid'] = $result;
	        $this->apiServer->reSetting()->setService('Classroom.Score.addOneScore')->addParams($param)->request();
			$this->renderjson(1,'添加成功');
		} else {
			$this->renderjson(0,'添加失败');
		}
	}

	/**
	 * 评论接口
	 */
	public function addReview(){
		$post = $this->input->post();
		$articleid = intval($post['articleid']);
		$message = $post['message'];
		if (!$articleid || !$message) {
			$this->renderjson(-1,'参数为空');
		}
		if (mb_strlen($message,'utf8') > 1000) {
			$this->renderjson(-1,'评论文字太多了');
		}
		$parameters['articleid'] = $articleid;
		$parameters['message'] = $message;
		$parameters['uid'] = $this->user['uid'];
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.addReview')->addParams($parameters)->request();
		if ($result) {
			$this->renderjson(1,'添加成功');
		} else {
			$this->renderjson(0,'添加失败');
		}
	}

	/**
	 * 修改文章，只用于删除
	 */
	public function updateArticle(){
		$post = $this->input->post();
		$itemid = intval($post['itemid']);
		if (!empty($post['message']))
			$parameters['message'] = $post['message'];
		if (isset($post['status']))
			$parameters['status'] = intval($post['status']);
		if (!$itemid) {
			$this->renderjson(-1,'参数为空');
		}
		$parameters['itemid'] = $itemid;
		$parameters['uid'] = $this->user['uid'];
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.update')->addParams($parameters)->request();
		if ($result) {
            //用户原创文章被删除则同时删除对应学分记录
            $res = '';
            $res = $this->afterDeleteArticle($itemid);
			$this->renderjson(1,'原创文章删除成功'.$res);
		} else {
			$this->renderjson(0,'原创文章删除失败');
		}
	}
    /**
     * 用户原创文章被删除则同时删除对应学分记录
     */
    public function afterDeleteArticle($itemid){
        $reviewparam = array();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $reviewparam['type'] = 2;
        $reviewparam['itemid'] = intval($itemid);
        $reviewparam['crid'] = $roominfo['crid'];
        $reviewparam['uid'] = $user['uid'];
        $res = $this->apiServer->reSetting()->setService('Classroom.Score.deleteScore')->addParams($reviewparam)->request();
        if(isset($res['status'])){
//            if($res['status']==1){
//                $ret = $this->apiServer->reSetting()->setService('Classroom.Score.doOneScoreSync')->addParams($reviewparam)->request();
//                if($ret){ return ','.$res['msg'].',该用户发表原创文章学分同步成功!'; }
//            }
            return ','.$res['msg'];
        }
    }

	/**
	 * 修改评论接口
	 */
	public function updateReview(){
		$post = $this->input->post();
		$itemid = intval($post['itemid']);
		if (!empty($post['message']))
			$parameters['message'] = $post['message'];
		if (isset($post['status']))
			$parameters['status'] = intval($post['status']);
		if (isset($post['del']))
			$parameters['del'] = intval($post['del']);
		if (!$itemid) {
			$this->renderjson(-1,'参数为空');
		}
		$parameters['itemid'] = $itemid;
		$parameters['uid'] = $this->user['uid'];
		$parameters['crid'] = $this->roominfo['crid'];
		//print_r($parameters);exit;
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.updateReview')->addParams($parameters)->request();
		if ($result) {
			$this->renderjson(1,'删除成功');
		} else {
			$this->renderjson(0,'删除失败');
		}
	}

	/**
	 *获取我的原创文章列表页面
	 */
	public function my() {
		$get = $this->input->get();
		if (!empty($get['q'])) {
			$parameters['q'] = $get['q'];
		}
		$parameters = parsequery();
		$parameters['uid'] = $this->user['uid'];
		//$parameters['status'] = 1;
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.list')->addParams($parameters)->request();
		if (!empty($result)) {
			if (!empty($result['list'])) {
				foreach ($result['list'] as &$value) {
					$value['subject'] = shortstr($value['subject'],100,'...');
					$value['message'] = shortstr(strip_tags($value['message']),200,'...');
				}
			}
			$pagestr = show_page($result['totalpage'],20);
			$this->assign('list',$result['list']);
			$this->assign('pagestr',$pagestr);
		}
		$this->assign('method','my');
		$this->display('college/myarticle');
	}

	/**
	 *获取原创文章详情,包括评论
	 */
	public function articleDetail_view() {
		$itemid = $this->uri->itemid;
		$parameters['itemid'] = $this->uri->itemid;
		
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.detail')->addParams($parameters)->request();
		if (isset($result['detail']['status']) && !$this->fromAdmin) {
			if ($result['detail']['status'] == -1) {
				header("Content-type: text/html; charset=utf-8");
				echo '该文章已删除，不能观看';exit;
			} else if (($result['detail']['status']==2 || $result['detail']['status']==0)&& $this->user['uid']!= $result['detail']['uid']) {
				header("Content-type: text/html; charset=utf-8");
				echo '该文章审核未通过，请联系管理员后台审核';exit;
			}
		}
		$hcachekey = 'first_create_article';//原创文章缓存
		$redis = Ebh::app()->getCache('cache_redis');
		$viewnumCache = $redis->hget($hcachekey,$itemid);
		if (!$viewnumCache && $result['viewnum'] > 0) {//丢失的情况下，重新设置
			$redis->hset($hcachekey,$itemid,$result['viewnum']);
		} else {
			$viewnumCache = !$viewnumCache ? 0 : $viewnumCache; 
			$viewnumCache++;
			$redis->hset($hcachekey,$itemid,$viewnumCache);
			$result['detail']['viewnum'] = $viewnumCache;
			if ($viewnumCache % 5 == 0) {//每5次提交一次数据库
				$parameters['viewnum'] = $viewnumCache;
				$parameters['crid'] = $this->roominfo['crid'];
				$this->apiServer->reSetting()->setService('College.Myarticle.update')->addParams($parameters)->request();
			}
		}
		$editor = Ebh::app()->lib('UEditor');
		$this->assign('roominfo', $this->roominfo);
		$this->assign('uid', $this->user['uid']);
		$this->assign('editor', $editor);
		$this->assign('info', $result);
		$this->display('college/article_detail');
	}

	/**
	 *获取我的评论列表或者是详情页面，底下评论数据
	 */
	public function reviews() {
		$get = $this->input->get();
		if (!empty($get['q'])) {
			$parameters['q'] = $get['q'];
		}
		$parameters = parsequery();
		$articleid = intval($get['articleid']);
		//有文章id,用id
		if ($articleid) {
			$parameters['articleid'] = $articleid;
			$parameters['count'] = 0;//且不需要统计出文章浏览和总的评论量
		} else {
			$parameters['uid'] = $this->user['uid'];
			$displayUrl = 'college/article_reviews';
		}
		$parameters['status'] = 1;
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.getReviews')->addParams($parameters)->request();
		if (!empty($result)) {
			if (!empty($result['list'])) {
				foreach ($result['list'] as &$value) {
					$value['comment'] = shortstr($value['comment'],200,'...');
					$value['subject'] = shortstr($value['subject'],100,'...');
				}
			}
			$pagestr = show_page($result['totalpage'],20);
			$this->assign('list',$result['list']);
			$this->assign('pagestr',$pagestr);
		}
		$this->assign('method','reviews');
		$this->display($displayUrl);
	}

	/**
	 *ajax 获取评论列表
	 */
	public function getReviewsAjax() {
		$post = $this->input->post();
		if (!empty($post['q'])) {
			$parameters['q'] = $post['q'];
		}
		$parameters = parsequery();
		$articleid = intval($post['itemid']);
		if (!$articleid) {
			$this->renderjson('-1','获取数据失败',array());
		}
		//有文章id,用id
		$parameters['articleid'] = $articleid;
		$parameters['status'] = 1;
		$parameters['count'] = 0;//且不需要统计出文章浏览和总的评论量
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.getReviews')->addParams($parameters)->request();
		if (!empty($result)) {
			$pagestr = ajaxpage($result['totalpage'],20,$parameters['page']);
			if (!empty($result['list'])) {
				foreach ($result['list'] as &$value) {
					$value['dateline'] = timetostr($value['rdateline']);
					$value['face'] = empty($value['face'])?getavater($value):$value['face'];
				}
			}
			$datas = array(
				'list'=>$result['list'],
				'pagestr'=>$pagestr
			);
			$this->renderjson('0','',$datas);
		}
		$this->renderjson('-1','获取数据失败',array());
	}

	/**
     * json格式输出
     * @param number $code 状态标识 0 成功 1 失败
     * @param string $msg 输出消息
     * @param array $data 数组参数数组
     * @param string $exit 是否结束退出
     */
    function renderjson($code=0,$msg="",$data=array(),$exit=true){
        $arr = array(
            'code'=>(intval($code) ===0) ? 0 : intval($code),
            'msg'=>$msg,
            'data'=>$data
        );
        echo json_encode($arr);
        if($exit){
            exit();
        }
    }
}
