<?php
/**
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/3/20
 * Time: 14:17
 */
class NewsController extends ARoomV3Controller {
    /**
     * 新闻列表
     */
    public function index() {
        $params = array();
        $categorys = array();//资讯分类
        $navcategory = array();
        $params['crid'] = $this->roominfo['crid'];
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $navcode = safefilter(trim($this->input->get('navcode')));
        //获取当前资讯分类及其子分类的navcode
        if (!empty($navcode) && !empty($params['crid'])) {
            $categorys = $this->apiServer->reSetting()->setService('Aroomv3.News.newsCategoryMenu')->addParams('crid', $params['crid'])->request();
            if ($categorys === false) {
                $this->renderjson(1, '分类信息错误');
            }
            $categorys = array_values($categorys);
            if(!empty($categorys) && is_array($categorys)){
                foreach ($categorys as $category){
                    if(!empty($category['code']) && ($category['code']==$navcode)){
                        $navcategory = $category;
                    }
                }
                //当前资讯分类有子集时获取并组合子集的分类code
                if(!empty($navcategory) && !empty($navcategory['subnav']) && is_array($navcategory['subnav'])){
                    $params['navcode'] = $navcode.','.implode(',',array_column($navcategory['subnav'],'code'));
                    $params['ranktype'] = 'prank';
                }else{
                    $params['navcode'] = $navcode;
                    $params['ranktype'] = 'rank';
                }
            }
        }
        $starttime = $this->input->get('starttime');
        if ($starttime !== NULL && preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', trim($starttime), $match)) {
            if (checkdate($match[2], $match[3], $match[1])) {
                $params['early'] = strtotime($starttime);
            }
        }
        $endtime = $this->input->get('endtime');
        if ($endtime !== NULL && preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', trim($endtime), $match)) {
            if (checkdate($match[2], $match[3], $match[1])) {
                $params['latest'] = strtotime($endtime.' 23:59:59');
            }
        }
        //查询
        $q = trim($this->input->get('q'));
        if ($q != '') {
            $params['q'] = $q;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.News.index')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '未知错误');
        }

        /*$_PLACEHOLDER = Ebh::app()->getConfig()->load('imagePlaceholder');
        if ($this->roominfo['isschool'] == 7) {
            $imagePlaceHolder = isset($_PLACEHOLDER['news_v3']) ? $_PLACEHOLDER['news_v3'] : '';
        } else {
            $imagePlaceHolder = isset($_PLACEHOLDER['news']) ? $_PLACEHOLDER['news'] : '';
        }*/
        //新闻资讯图片路径处理
        /*array_walk($ret, function(&$v, $k, $config) {
            if (empty($v['thumb'])) {
                $v['thumb'] = $config['placeholder'];
            }
        }, array(
            'placeholder' => $imagePlaceHolder
        ));*/

        $this->renderjson(0, '', $ret);
    }

    /**
     * 统计新闻
     */
    public function getCount() {
        $navcode = $this->input->get('navcode');
        $params = array();
        $params['crid'] = safefilter(trim($this->roominfo['crid']));
        //获取当前资讯分类及其子分类的navcode
        if (!empty($navcode) && !empty($params['crid'])) {
            $categorys = $this->apiServer->reSetting()->setService('Aroomv3.News.newsCategoryMenu')->addParams('crid', $params['crid'])->request();
            if ($categorys === false) {
                $this->renderjson(1, '分类信息错误');
            }
            $categorys = array_values($categorys);
            if(!empty($categorys) && is_array($categorys)){
                foreach ($categorys as $category){
                    if(!empty($category['code']) && ($category['code']==$navcode)){
                        $navcategory = $category;
                    }
                }
                //当前资讯分类有子集时获取并组合子集的分类code
                if(!empty($navcategory) && !empty($navcategory['subnav']) && is_array($navcategory['subnav'])){
                    $params['navcode'] = $navcode.','.implode(',',array_column($navcategory['subnav'],'code'));
                }else{
                    $params['navcode'] = $navcode;
                }
            }
        }
        $starttime = $this->input->get('starttime');
        if ($starttime !== NULL && preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', trim($starttime), $match)) {
            if (checkdate($match[2], $match[3], $match[1])) {
                $params['early'] = strtotime($starttime);
            }
        }
        $endtime = $this->input->get('endtime');
        if ($endtime !== NULL && preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', trim($endtime), $match)) {
            if (checkdate($match[2], $match[3], $match[1])) {
                $params['latest'] = strtotime($endtime.' 23:59:59');
            }
        }
        //查询
        $q = trim($this->input->get('q'));
        if (!empty($q)) {
            $params['q'] = $q;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.News.count')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '未知错误');
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 资讯分类
     */
    public function getNewsCategorys() {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.News.newsCategory')
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '未知错误');
        }
        $ret = array_values($ret);
        $this->renderjson(0, '', $ret);
    }

    /**
     * 新闻资讯详情
     */
    public function view() {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.News.detail')
            ->addParams('itemid', $this->uri->itemid)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '未知错误');
        }
        $_PLACEHOLDER = Ebh::app()->getConfig()->load('imagePlaceholder');
        if ($this->roominfo['isschool'] == 7) {
            $imagePlaceHolder = isset($_PLACEHOLDER['news_v3']) ? $_PLACEHOLDER['news_v3'] : '';
        } else {
            $imagePlaceHolder = isset($_PLACEHOLDER['news']) ? $_PLACEHOLDER['news'] : '';
        }
        if (empty($ret['thumb'])) {
            $ret['thumb_holder'] = $imagePlaceHolder;
        }

        $this->renderjson(0, '', $ret);
    }

    /**
     * 发布资讯
     */
    public function add() {
        if (!$this->isPost()) {
            if (!$this->isPost()) {
                $this->renderjson(1, '非法操作');
            }
        }
        $navcode = trim($this->input->post('navcode'));
        $subject = trim($this->input->post('subject'));
        $message = trim($this->input->post('message'));
        $note = trim($this->input->post('note'));
        if (empty($navcode) || empty($subject) || empty($message) || empty($note)) {
            if (!$this->isPost()) {
                $this->renderjson(1, '关键数据不能为空');
            }
        }
        $params = array();
        $params['crid'] = $this->roominfo['crid'];
        $params['uid'] = $this->user['uid'];
        $params['navcode'] = $navcode;
        $params['subject'] = $subject;
        $params['message'] = $message;
        $params['note'] = $note;
        $params['ip'] = getip();
        if ($this->input->post('thumb') !== NULL) {
            $params['thumb'] = trim($this->input->post('thumb'));
        }
		if ($this->input->post('thumb_mobile') !== NULL) {
            $params['thumb_mobile'] = trim($this->input->post('thumb_mobile'));
        }
        if ($this->input->post('viewnum') !== NULL) {
            $params['viewnum'] = intval($this->input->post('viewnum'));
        }
        if ($this->input->post('displayorder') !== NULL) {
            $params['displayorder'] = intval($this->input->post('displayorder'));
        }
        if ($this->input->post('status') !== NULL) {
            $params['status'] = intval($this->input->post('status'));
        }
		if ($this->input->post('isinternal') !== NULL) {
            $params['isinternal'] = intval($this->input->post('isinternal'));
        }
		//附件信息
		$attid = $this->input->post('attid');
        if ($attid !== NULL && is_array($attid)) {
			$params['attid'] = $this->getAttid($attid);
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.News.add')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '添加失败');
        }
        $this->renderjson(0, '添加成功', $ret,false);

        fastcgi_finish_request();
        //发布资讯操作成功后记录到操作日志
        if (!empty($params['subject']) && !empty($ret) && is_numeric($ret)) {
            $logdata = array();
            $logdata['toid'] = $ret;                    //资讯的id
            $logdata['title'] = h($params['subject']);  //新资讯名称
            Ebh::app()->lib('OperationLog')->addLog($logdata,'addnews');
        }
    }

    /**
     * 更新资讯
     */
    public function update() {
        if (!$this->isPost()) {
            if (!$this->isPost()) {
                $this->renderjson(1, '非法操作');
            }
        }
        $itemid = $this->input->post('itemid');
        if ($itemid === NULL) {
            if (!$this->isPost()) {
                $this->renderjson(1, '参数错误');
            }
        }
        $params = array();
        if ($this->input->post('navcode') !== NULL) {
            $params['navcode'] = trim($this->input->post('navcode'));
        }
        if ($this->input->post('subject') !== NULL) {
            $params['subject'] = trim($this->input->post('subject'));
        }
        if ($this->input->post('message') !== NULL) {
            $params['message'] = trim($this->input->post('message'));
        }
        if ($this->input->post('note') !== NULL) {
            $params['note'] = trim($this->input->post('note'));
        }
        if ($this->input->post('thumb') !== NULL) {
            $params['thumb'] = trim($this->input->post('thumb'));
        }
		if ($this->input->post('thumb_mobile') !== NULL) {
            $params['thumb_mobile'] = trim($this->input->post('thumb_mobile'));
        }
        if ($this->input->post('viewnum') !== NULL) {
            $params['viewnum'] = intval($this->input->post('viewnum'));
        }
        if ($this->input->post('displayorder') !== NULL) {
            $params['displayorder'] = intval($this->input->post('displayorder'));
        }
        if ($this->input->post('status') !== NULL) {
            $params['status'] = intval($this->input->post('status'));
        }
        if ($this->input->post('isinternal') !== NULL) {
            $params['isinternal'] = intval($this->input->post('isinternal'));
        }
		
        if (empty($params)) {
            $this->renderjson(0, '没有更新', 0);
        }
        $params['crid'] = $this->roominfo['crid'];
        $params['itemid'] = intval($itemid);
        $params['ip'] = getip();
		
		//附件信息
		$attid = $this->input->post('attid');
        if ($attid !== NULL && is_array($attid)) {
			$params['attid'] = $this->getAttid($attid);
        }
		
        //获取原资讯信息（用于记录操作日志）
        $oldnews = $this->apiServer->reSetting()->setService('Aroomv3.News.detail')->addParams('itemid', $itemid)->request();

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.News.update')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '修改失败');
        }
        $this->renderjson(0, '修改成功',array(),false);

        fastcgi_finish_request();
        //编辑资讯操作成功后记录到操作日志
        if (!empty($oldnews['subject']) && !empty($params['subject'])) {
            $logdata = array();
            $logdata['toid'] = $itemid;
            $logdata['oldtitle'] = h($oldnews['subject']);  //原资讯名称
            $logdata['title'] = h($params['subject']);      //新资讯名称
            Ebh::app()->lib('OperationLog')->addLog($logdata,'editnews');
        }
    }

    /**
     * 删除新闻资讯
     */
    public function remove() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $itemid = intval($this->input->post('itemid'));
        if ($itemid < 1) {
            $this->renderjson(1, '参数错误');
        }
        //获取原资讯信息（用于记录操作日志）
        $oldnews = $this->apiServer->reSetting()->setService('Aroomv3.News.detail')->addParams('itemid', $itemid)->request();

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.News.remove')
            ->addParams('itemid', $itemid)
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '删除失败');
        }
        $this->renderjson(0, '删除成功',array(),false);

        fastcgi_finish_request();
        //删除资讯操作成功后记录到操作日志
        if (!empty($oldnews['subject'])) {
            $logdata = array();
            $logdata['toid'] = $itemid;
            $logdata['title'] = h($oldnews['subject']);
            Ebh::app()->lib('OperationLog')->addLog($logdata,'delnews');
        }
    }

    /**
     * 新闻分层分类集
     */
    public function newsCategory() {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.News.newsCategoryMenu')
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '未知错误');
        }
        $ret = array_values($ret);
        $this->renderjson(0, '', $ret);
    }
    /**
     * 新闻列表
     */
    public function getnewslists() {
        $params = array();
        $result = array();
        $categorys = array();//资讯分类
        $navcategory = array();
        $params['ranktype'] = '';//排序类型,prank主类中资讯的排序,rank子类中资讯的排序(没有子类的资讯分类均为rank)
        $post = $this->input->post();
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            echo json_encode(array('code'=>1,'msg'=>'用户未登录'));
            return ;
        }
        $params['crid'] = $this->roominfo['crid'];
        $params['begin'] = !empty($post['begin']) ? intval($post['begin'])-1 : 0;
        $params['last'] = (!empty($post['last']) && ($post['last']>=$params['begin'])) ? (intval($post['last']) - $params['begin']): 0;
        $navcode = safefilter(trim($this->input->post('navcode')));
        //获取当前资讯分类及其子分类的navcode
        if (!empty($navcode) && !empty($params['crid'])) {
            $categorys = $this->apiServer->reSetting()->setService('Aroomv3.News.newsCategoryMenu')->addParams('crid', $params['crid'])->request();
            if ($categorys === false) {
                $this->renderjson(1, '分类信息错误');
            }
            $categorys = array_values($categorys);
            if(!empty($categorys) && is_array($categorys)){
                foreach ($categorys as $category){
                    if(!empty($category['code']) && ($category['code']==$navcode)){
                        $navcategory = $category;
                    }
                }
                //当前资讯分类有子集时获取并组合子集的分类code
                if(!empty($navcategory) && !empty($navcategory['subnav']) && is_array($navcategory['subnav'])){
                    $params['navcode'] = $navcode.','.implode(',',array_column($navcategory['subnav'],'code'));
                    $params['ranktype'] = 'prank';
                }else{
                    $params['navcode'] = $navcode;
                    $params['ranktype'] = 'rank';
                }
            }
        }
        if(!isset($params['begin']) || empty($params['last']) || empty($params['navcode']) || empty($params['ranktype'])){
            $this->renderjson(1, '参数错误');
        }
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.News.getNewsLists')->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '未知错误');
        }
        if(!empty($ret) && is_array($ret)){
            $result = $ret;
        }
        $this->renderjson(0, '查询结果', $result);
    }

	/*
	 *添加附件处理attid参数
	*/
	private function getAttid($attid){
		$attidarr = array();
		$attcount = 0;
		foreach($attid as $k=>$id){
			if(is_numeric($id)){
				$attidarr[]= $id;
				$attcount ++;
				if($attcount>=5){//5个附件限制
					break;
				}
			}
		}
		return implode(',',$attidarr);
	}

    /**
     * 资讯移动
     */
    public function ranknews() {
        $params = array();
        $categorys = array();//资讯分类
        $navcategory = array();
        $post = $this->input->post();
        $uid = !empty($this->user['uid']) ? $this->user['uid'] : 0;
        if(empty($uid)){
            echo json_encode(array('code'=>1,'msg'=>'用户未登录'));
            return ;
        }
        $params['crid'] = $this->roominfo['crid'];
        $navcode = safefilter($post['navcode']);//资讯分类的集合
        $params['ranktype'] = '';//排序类型,prank主类中资讯的排序,rank子类中资讯的排序(没有子类的资讯分类均为rank)
        //获取当前资讯分类及其子分类的navcode
        if (!empty($navcode) && !empty($params['crid'])) {
            $categorys = $this->apiServer->reSetting()->setService('Aroomv3.News.newsCategoryMenu')->addParams('crid', $params['crid'])->request();
            if ($categorys === false) {
                $this->renderjson(1, '分类信息错误');
            }
            $categorys = array_values($categorys);
            if(!empty($categorys) && is_array($categorys)){
                foreach ($categorys as $category){
                    if(!empty($category['code']) && ($category['code']==$navcode)){
                        $navcategory = $category;
                    }
                }
                //当前资讯分类有子集时获取并组合子集的分类code
                if(!empty($navcategory) && !empty($navcategory['subnav']) && is_array($navcategory['subnav'])){
                    $params['navcode'] = $navcode.','.implode(',',array_column($navcategory['subnav'],'code'));
                    $params['ranktype'] = 'prank';
                }else{
                    $params['navcode'] = $navcode;
                    $params['ranktype'] = 'rank';
                }
            }
        }
        $params['itemid'] = intval($post['itemid']);//资讯id
        $params['step'] = intval($post['step']);    //资讯移动,1下移,-1上移
        if (empty($params['itemid']) || empty($params['step']) || empty($params['ranktype']) || empty($params['navcode']) || !in_array($params['step'],array(1,-1))) {
            $this->renderjson(1, '参数错误');
        }
        $ret = $this->apiServer->reSetting()->setService('Aroomv3.News.rankNews')->addParams($params)->request();
        if ($ret === false) {
            $this->renderjson(1, '移动失败');
        }
        $this->renderjson(0, '移动成功');
    }
}