<?php
/**
 *新闻动态控制器
 */
class ArticlesearchController extends PortalControl{
	public function index(){
		$param = parsequery();
		$param['pagesize'] = 5;
		$param['q'] = h($param['q']);
		$param['q'] = htmlentities($param['q'], ENT_QUOTES, "UTF-8");
		$offset = max(0,($param['page']-1)*$param['pagesize']);
		$param['limit'] = $offset.','.$param['pagesize'];
		$pitemsModel = $this->model('pitems');
		$articleList = $pitemsModel->getList($param);
		$count = $pitemsModel->getListCount($param);
		$pageStr = show_page($count,$param['pagesize']);
		$this->assign('upcode','news');
		$this->assign('catid',45);
		$this->assign('pageStr',$pageStr);
		$this->assign('q',$param['q']);
		$this->assign('articleList',$articleList);
		$this->getAllAds();
		$this->getVRList();
		$this->display('portal/article_search');
	}
	/**
	 *获取广告
	 */
	public function getAllAds(){
		$ads_nav = $this->getAds(45,'nav',1);
		//获取列表页右侧上方广告
		$ads_list_youshang_45 = $this->getAds(45,'list_youshang',1);
		//获取列表页右侧下方广告
		$ads_list_youxia_45 = $this->getAds(45,'list_youxia',1);
		$this->assign('ads_nav',$ads_nav);
		$this->assign('ads_list_youshang_45',$ads_list_youshang_45);
		$this->assign('ads_list_youxia_45',$ads_list_youxia_45);
	}
	/**
	 *获取阅读和推荐排行
	 */
	public function getVRList(){
		$vtop6 = $this->getArticleByViewNum(6);
		$rtop6 = $this->getArticleByRecommend(6);
		$this->assign('vtop6',$vtop6);
		$this->assign('top6',$rtop6);
	}
	/**
   	 *获取广告通用方法
   	 *
   	 */
   	private function getAds($catid = 45,$code = 'nav',$num,$upid=0){
   		$padsModel = $this->model('pads');
   		$ads = $padsModel->getCateAds($catid,$code,$num,$upid);
   		if(empty($ads)){
   			$ads = array(array('linkurl'=>'','thumb'=>''));
   		}
   		//catid=45的栏目为顶层栏目,是所有顶级分类的父级,广告投放在45栏目则所有栏目均会获取到信息
   		return $ads;
   		
   	}

	/**
	 *阅读排行获取(当前栏目(如果当前栏目为顶级栏目则获取下面所有子分类的文章,否则只获取当前栏目文章))
	 */
	private function getArticleByViewNum($num=6){
		$param = parsequery();
		$param['q'] = '';
		$param['catid'] = 0;
		$param['order'] = 'i.viewnum desc';
		$param['limit'] = $num;
		$pitemsModel = $this->model('pitems');
		$vtop6 = $pitemsModel->getList($param);
		return $vtop6;
	}

	/**
	 *推荐排行获取(当前栏目(如果当前栏目为顶级栏目则获取下面所有子分类的文章,否则只获取当前栏目文章))
	 */
	private function getArticleByRecommend($num=10){
		$param = parsequery();
		$param['q'] = '';
		$param['catid'] = 0;
		$param['order'] = 'i.top,i.hot,i.best desc';
		$param['limit'] = $num;
		$pitemsModel = $this->model('pitems');
		$rtop6 = $pitemsModel->getList($param);
		return $rtop6;
	}

}