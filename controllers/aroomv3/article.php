<?php
/**
 * 原创文章接口
 */
class ArticleController extends ARoomV3Controller {

	/**
	 *原创文章列表的
	 */
	public function getArticleList(){
		$post = $this->input->post();
		$parameters = $this->getPageInfo();
		$parameters['page'] = $parameters['pagenum'];
		if (!empty($post['q'])) {
			$parameters['q'] = $post['q'];
		}
		if (isset($post['status']) && $post['status'] != '') {
			$parameters['status'] = intval($post['status']);
		}
		if (!empty($post['starttime'])) {
			$starttime = $post['starttime'];
	        if ($starttime !== NULL && preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', trim($starttime), $match)) {
	            if (checkdate($match[2], $match[3], $match[1])) {
	                $parameters['early'] = strtotime($starttime);
	            }
	        }
		}

		if (!empty($post['endtime'])) {
			$endtime = $post['endtime'];
	        if ($endtime !== NULL && preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', trim($endtime), $match)) {
	            if (checkdate($match[2], $match[3], $match[1])) {
	                $parameters['latest'] = strtotime($endtime.' 23:59:59');
	            }
	        }
		}
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $iszjdlr = isset($appsetting['zjdlr']) && $appsetting['zjdlr'] == $this->roominfo['crid'] || isset($appsetting['newzjdlr']) && in_array($this->roominfo['crid'], $appsetting['newzjdlr']);
        $parameters['roomtype'] = $iszjdlr ? 'com' : Ebh::app()->room->getRoomType();
        if ($iszjdlr && $this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $parameters['adminuid'] = $this->user['uid'];
        }
        $classid = intval($this->input->post('classid'));
        if ($classid > 0) {
            $parameters['classid'] = $classid;
        }
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.list')->addParams($parameters)->request();
		if (!empty($result)) {
			if (!empty($result['list'])) {
				foreach ($result['list'] as &$value) {
					$value['message'] =  shortstr(strip_tags($value['message']),250,'......');
					$value['face'] =  empty($value['face'])?getavater($value):$value['face'];
				}
			}	
		}
		$this->renderjson('0','',$result);
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
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.update')->addParams($parameters)->request();
		if ($result) {
			$this->renderjson(0,'审核成功');
		} else {
			$this->renderjson(-1,'删除失败');
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
		if (isset($post['status']) && $post['status'] != '' )
			$parameters['status'] = intval($post['status']);
		if (!$itemid) {
			$this->renderjson(-1,'参数为空');
		}
		$parameters['itemid'] = $itemid;
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.updateReview')->addParams($parameters)->request();
		if ($result) {
			$this->renderjson(0,'审核成功');
		} else {
			$this->renderjson(-1,'删除失败');
		}
	}

	/**
	 *获取我的评论列表或者是详情页面，底下评论数据
	 */
	public function getReviews() {
		$post = $this->input->post();
		$parameters = $this->getPageInfo();
		$parameters['page'] = $parameters['pagenum'];
		if (!empty($post['q'])) {
			$parameters['q'] = $post['q'];
		}
		if (isset($post['status'])  && $post['status'] != '' ) {
			$parameters['status'] = intval($post['status']);
		}
		$starttime = isset($post['starttime']) ? $post['starttime'] : '';
        if ($starttime !== NULL && preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', trim($starttime), $match)) {
            if (checkdate($match[2], $match[3], $match[1])) {
                $parameters['early'] = strtotime($starttime);
            }
        }
        $endtime = isset($post['endtime']) ? $post['endtime'] : '';
        if ($endtime !== NULL && preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', trim($endtime), $match)) {
            if (checkdate($match[2], $match[3], $match[1])) {
                $parameters['latest'] = strtotime($endtime.' 23:59:59');
            }
        }
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $iszjdlr = isset($appsetting['zjdlr']) && $appsetting['zjdlr'] == $this->roominfo['crid'] || isset($appsetting['newzjdlr']) && in_array($this->roominfo['crid'], $appsetting['newzjdlr']);
        $parameters['roomtype'] = $iszjdlr ? 'com' : Ebh::app()->room->getRoomType();
        if ($iszjdlr && $this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $parameters['adminuid'] = $this->user['uid'];
        }
        $classid = intval($this->input->post('classid'));
        if ($classid > 0) {
            $parameters['classid'] = $classid;
        }
		$parameters['allreviews'] = 1;//文章所有的评论，关联
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('College.Myarticle.getReviews')->addParams($parameters)->request();
		if (!empty($result)) {
			if (!empty($result['list'])) {
				foreach ($result['list'] as &$value) {
					$value['comment'] =  shortstr($value['comment'],250,'......');
					$value['face'] =  empty($value['face'])?getavater($value):$value['face'];
				}
			}	
		}
		$this->renderjson('0','',$result);
	}
}
