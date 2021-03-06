<?php
/**
 *新闻动态控制器
 */
class NewsController extends PortalControl{

	public $catinfo = array();
	public $parentinfo = array();
	public $itemM = null;
	public $cateM = null;
	public $data = null;
	public $sortmode = null;
	public function __construct(){
		EBH::app()->helper('portal');
		parent::__construct();
		$this->itemM = $this->model('pitems');
		$this->cateM = $this->model('pcategories');
		$catid = intval($this->uri->uri_attr(0));
		if(!empty($catid)){
			$this->cateInfo = $this->cateM->getOneByCatid($catid);
			if(empty($this->cateInfo)){
				show_404();exit;
			} 
		}else{
			$code = 'news';
			$this->cateInfo = $this->cateM->getcateInfoByCode($code);
		}
		if(!$this->cateM->isTopCate($this->cateInfo['catid'])){
				$this->parentInfo = $this->cateM->getOneByCatid($this->cateInfo['upid']);

		}
		$this->getUpCode();
		//获取文章排序方式
		$sortmode = $this->uri->uri_sortmode();
		//根据排序方式解析排序字段
		switch ($sortmode) {
			case 1:
				$this->order = 'i.viewnum desc';//阅读次数排行
				break;
			case 2:
				$this->order = 'i.sharenum desc';//分享次数排行
				break;
			case 3:
				$this->order = 'i.reviewnum desc';//评论次数排行
				break;
			case 4:
				$this->order = 'i.top desc';//置顶级数排行
				break;
			case 5:
				$this->order = 'i.hot desc';//热门级数排行
				break;
			case 6:
				$this->order = 'i.best desc';//精华级数排行
				break;
			default:
				$this->order = 'i.itemid desc';//默认排行
				break;
		}

		$this->assign('catid',$this->cateInfo['catid']);
	}

	public function index(){
		$catid = intval($this->uri->uri_attr(0));
		if($catid>0){
			$this->_show_list();
		}else{
			$this->_home();
		}
	}

	private function _home(){
		$this->getBTH('top',1,5);
		// $this->getBTH('top',3,1);
		$this->getBTH('top',2,2);
		$this->getCateTreeWithChildren_Articles();
		$this->getAds($this->cateInfo['catid'],'nav',4);
		//获取新闻动态home页底部通栏广告左上广告320*240
		$this->getAds($this->cateInfo['catid'],'news_bottomnavzuoshang',1);
		//获取新闻动态home页底部通栏广告右下广告320*240
		$this->getAds($this->cateInfo['catid'],'news_bottomnavyouxia',1);
		$this->getNews(5);
		//=====
		$this->getAds($this->cateInfo['catid'],'lfk_left',2);
		$this->getAds($this->cateInfo['catid'],'free',2);
		$this->_getAllList();
		$this->getArticleByViewNum(10);
		$this->getHotKeywords();
		//改版之后新加开始
		//新闻左上角4个文章
		$this->getImportantNews(4);
		//获取重要的E板资讯 (3级置顶)
		$this->getImportantENews(3);
		$this->getBTH('hot',1,6);
		//改版之后新加结束
		//=====
		$this->_assignAll();
		$this->display('portal/home_news');
		
	}

	private function _show_list(){
		$this->_list();
		$this->getArticleByViewNum(6);
		$this->getArticleByRecommend(6);
		$this->getAds($this->cateInfo['catid'],'nav',1);
		//获取列表页右侧上方广告
		$this->getAds($this->cateInfo['catid'],'list_youshang',1);
		//获取列表页右侧下方广告
		$this->getAds($this->cateInfo['catid'],'list_youxia',1);
		$this->_assignAll();
		$this->display('portal/list');
	}

	public function view(){
		$this->getAds($this->cateInfo['catid'],'nav',2);
		$this->itemid = $this->uri->itemid;
		$this->_detail();
		$this->assign('isdetail',true);
		$this->_assignAll();
		$this->display('portal/detail');
	}



	private function getUpCode(){
		if(!empty($this->parentInfo)){
			$this->data['upcode'] = $this->parentInfo['code'];
		}else{
			$this->data['upcode'] = 'news';
		}
	}

	/**
	 *分配包含文章的分类树
	 */
	private function getCateTreeWithChildren_Articles(){
		$cateTreeWithChildren = $this->model('pcategories')->getCateTreeWithChildren($this->cateInfo['catid']);
		$cateTreeWithArticles = $this->itemM->getEachFiveInfoByCateTree($cateTreeWithChildren);
		array_walk_recursive($cateTreeWithArticles,'_strip_tags');
		$this->data['cateTree'] = $cateTreeWithArticles;
	}

	 /**
     *按照best,top,hot等级查找文章并且分配
     *
     */
    private function getBTH($name,$level,$num){
    	$catid = $this->cateInfo['catid'];
    	$param = array();
    	if($this->cateInfo['upid']==0){
    		$cateids = $this->cateM->getPosterity($this->cateInfo['catid']);
			$param['in'] = $cateids;
    	}else{
    		$param['catid'] = $catid;
    	}
    	$param[$name] = $level;
    	$param['order'] = 'i.lastpost desc,i.dateline desc';
    	$param['limit'] = $num;
    	$bth = $this->itemM->getList($param);
    	if(empty($bth)){
    		$bth = array(array('itemid'=>0,'catid'=>'','upid'=>'','subject'=>'','note'=>'','message'=>'','thumb'=>''));
    	}
    	$this->data[$name.$level.'_'.$num] = $bth;
    }

	/**
	 *获取带图的最新文章(当前栏目(如果当前栏目为顶级栏目则获取下面所有子分类的文章,否则只获取当前栏目文章))
	 *
	 */
	private function getArticleListWithThumb($num = 4){
		$param = array();
		$param['thumb'] = true;
		if(!empty($this->parentInfo)){
			$param['catid'] = $this->cateInfo['catid'];
		}else{
			$cateids = $this->cateM->getPosterity($this->cateInfo['catid']);
			$param['in'] = $cateids;
		}
		$param['limit'] = $num;
		$res = $this->itemM->getList($param);
		$this->data['articleWithThumb_'.$num] = $res;
	}
   
   	/**
   	 *获取广告通用方法
   	 *
   	 */
   	private function getAds($catid,$code,$num,$upid=0){
   		$padsModel = $this->model('pads');
   		if(!empty($this->parentInfo)){
   			$upid = $this->parentInfo['catid'];
   		}
   		$ads = $padsModel->getCateAds($catid,$code,$num,$upid);
   		if(empty($ads)){
   			$ads = array(array('linkurl'=>'','thumb'=>''));
   		}
   		//catid=45的栏目为顶层栏目,是所有顶级分类的父级,广告投放在45栏目则所有栏目均会获取到信息
   		if($code!='nav'){
   			if($code=='free'){
   				$this->data['ads_free']= $ads;
   			}else{
   				$this->data['ads_'.$code.'_'.$catid]= $ads;
   			}
   		}else{
   			$this->data['ads_nav']= $ads;
   		}
   		
   	}

   	/**
	 *获取指定栏目下面的文章列表
	 */
	private function getArticleList($catid){
		$param = parsequery();
		$param['catid'] = $catid;
		$param['pagesize'] = 5;
		$offset = max(0,$param['pagesize']*($param['page']-1));
		$param['limit'] = $offset.','.$param['pagesize'];
		$param['order'] = $this->order;
		$pitemsModel = $this->model('pitems');
		$res = $pitemsModel->getList($param);
		if(!empty($res)){
			foreach ($res as &$item) {
				$viewnum = Ebh::app()->lib('Viewnum')->getViewnum('pitems',$item['itemid']);
				if(!empty($viewnum)){
					$item['viewnum'] = $viewnum;
				}
			}
		}
		array_walk_recursive($res,'_strip_tags');
		return $res;
	}
   	/**
	 *分配子栏目的文章信息以及分类
	 */
	private function _list(){
		$catid = $this->cateInfo['catid'];
		if($this->cateInfo['upid']==0){
			$this->_getAllList();return;
		}
		$parentInfo = $this->parentInfo;
		$articleList = $this->getArticleList($catid);
		$pageStr = $this->getPage($catid);
		$this->data['catid'] = $catid;
		$this->data['articleList'] = $articleList;
		$this->data['pageStr'] = $pageStr;
	}
	/**
	 *分配顶级栏目下面的所有文章
	 *
	 */
	private function _getAllList(){
		$cateids = $this->cateM->getPosterity($this->cateInfo['catid']);
		$cateInfo = $this->cateM->getOneByCatid($this->cateInfo['catid']);
		$param = parsequery();
		$param['pagesize'] = 5;
		$offset = max(0,$param['pagesize']*($param['page']-1));
		$param['limit'] = $offset.','.$param['pagesize'];
		$param['in'] = $cateids;
		$param['order'] = $this->order;
		$articleList = $this->itemM->getList($param);
		$pageStr = $this->getPageWithIn($cateids);
		$this->data['pageStr'] = $pageStr;
		$this->data['articleList'] = $articleList;
		$this->data['catid'] = $this->cateInfo['catid'];
	}

	/**
	 *获取分页(单独使用,传入单一catid)
	 */
	private function getPage($catid){
		$param = parsequery();
		$param['catid'] = $catid;
		$pitemsModel = $this->model('pitems');
		$count = $pitemsModel->getListCount($param);
		return  show_page($count,5);
	}
	/**
	 *获取分页(单独使用,传入catid的集合数组)
	 */
	private function getPageWithIn($catid){
		$param = parsequery();
		$param['in'] = $catid;
		$pitemsModel = $this->model('pitems');
		$count = $pitemsModel->getListCount($param);
		return  show_page($count,5);
	}

	/**
	 *阅读排行获取(当前栏目(如果当前栏目为顶级栏目则获取下面所有子分类的文章,否则只获取当前栏目文章))
	 */
	private function getArticleByViewNum($num=6){
		$param = parsequery();
		$param['q'] = '';
		if(!empty($this->parentInfo)){
			$param['catid'] = $this->cateInfo['catid'];
		}else{
			$cateids = $this->cateM->getPosterity($this->cateInfo['catid']);
			$param['in'] = $cateids;
		}
		$param['order'] = 'i.viewnum desc';
		$param['limit'] = $num;
		$pitemsModel = $this->model('pitems');
		$vtop6 = $pitemsModel->getList($param);
		$this->data['vtop'.$num] = $vtop6;
	}

	/**
	 *推荐排行获取(当前栏目(如果当前栏目为顶级栏目则获取下面所有子分类的文章,否则只获取当前栏目文章))
	 */
	private function getArticleByRecommend($num=10){
		$param = parsequery();
		$param['q'] = '';
		if(!empty($this->parentInfo)){
			$param['catid'] = $this->cateInfo['catid'];
		}else{
			$cateids = $this->cateM->getPosterity($this->cateInfo['catid']);
			$param['in'] = $cateids;
		}
		$param['order'] = 'i.top,i.hot,i.best desc';
		$param['limit'] = $num;
		$pitemsModel = $this->model('pitems');
		$vtop6 = $pitemsModel->getList($param);
		$this->data['top'.$num] = $vtop6;
	}

	/**
	 *详情detail页面数据分发器
	 */
	private function _detail(){
		$itemid = $this->itemid;
		$article = $this->itemM->getOneByItemid(intval($itemid));
		if(empty($article)){
			show_404();
			exit;
		}
		//浏览数加一
		Ebh::app()->lib('Viewnum')->addViewnum('pitems',$itemid);
		$viewnum = Ebh::app()->lib('Viewnum')->getViewnum('pitems',$itemid);
		if(!empty($viewnum)){
			$article['viewnum'] = $viewnum;
		}
		$reviews = $this->getReviews(array('itemid'=>$itemid,'limit'=>5,'status'=>1));
		$nav = $this->getNav($article['catid']);
		$this->data['nav'] = $nav;
		$this->data['reviews'] = $reviews;
		$this->data['token'] = createToken();
		$this->data['article'] = $article;
		$keyword = empty($article['tag'])?$article['subject']:$article['tag'];
		$description = $article['note'];
		$title = $article['subject'];
		$seoInfo = array('keyword'=>$keyword,'description'=>$description,'title'=>$title);
		$this->data['seoInfo'] = $seoInfo;
	}

	/**
	 *根据参数获取相关评论
	 */
	private function getReviews($param = array()){
		$previewsModel = $this->model('previews');
		$reviews = $previewsModel->getList($param);
		$uidArr = array();
		foreach ($reviews as  $review) {
			$uidArr[] = $review['uid'];
		}
		if(!empty($uidArr)){
			$userModel = $this->model('user');
			$userinfo = $userModel->getUserInfoByUid($uidArr);
			return visualLink(array($reviews,$userinfo),array('uid','uid'));
		}
		return array();
	}
	/**
	 *获取栏目的导航条条
	 */
	private function getNav($catid){
		$pcategoriesModel = $this->model('pcategories');
		$ancestorChain = $pcategoriesModel->getAncestorChain($catid,array(),false,'',' > ',true);
		return $ancestorChain.' > 正文';
	}
	/**
     *获取E板资讯
     */
    private function getNews($num = 5){
        $param = array('code'=>'ebhintro','limit'=>$num,'top'=>1,'order'=>'itemid desc');
        $pitemsM = $this->model('pitems');
        $newslist = $pitemsM->getList($param);
        $this->data['newslist'] = $newslist;
    }
	/**
     *获取重要的E板资讯
     */
    private function getImportantENews($num = 3){
        $param = array('code'=>'ebhintro','limit'=>$num,'top'=>3,'order'=>'lastpost desc');
        $pitemsM = $this->model('pitems');
        $newslist = $pitemsM->getList($param);
        $this->data['importantEnews'] = $newslist;
    }
    /**
     *获取重要的新闻
     */
    private function getImportantNews($num = 4){
    	$catids = $this->model('pcategories')->getPosterity(8);
     	$param = array('in'=>$catids,'limit'=>$num,'top'=>3,'order'=>'lastpost desc');
    	$pitemsM = $this->model('pitems');
    	$importantNews = $pitemsM->getList($param);
    	$this->data['importantnews'] = $importantNews;
    }

}