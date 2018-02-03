<?php
EBH::app()->helper('portal');
class Yun1Controller extends PortalControl{
    public $data = array();
	function index() {
        //获取课件学习记录,热门课件记录
       
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
        $portalkey = $this->cache->getcachekey('portal','yun1');
        $portallist = $this->cache->get($portalkey);
        if(empty($portallist)){
		    $this->getStudyLog()->getHotCourse()->getNewRooms(11)->getTags()->getNews()->getAds()->getRooms('allschool',64)->getAllSchool()->getNavAds()->getTkInfo()->getNavScrollAds();
            $this->cache->set($portalkey,$this->data,360000);
        }else{
            $this->data = array_merge($this->data,$portallist);
        }
        $this->_assignAll();
        $this->display('portal/yun1');
    }

    private function getStudyLog(){
    	//获取课件学习记录
		$studyparam = array('limit'=>'0,8');
		$studylogkey = $this->cache->getcachekey('study',$studyparam);
        $studyloglist = $this->cache->get($studylogkey);
        if(empty($studyloglist)) {
            $studymodel  = $this->model('Study');
            $studyloglist = $studymodel->getloglist($studyparam);
            $this->cache->set($studylogkey,$studyloglist,3600);
        }
        $this->data['studyloglist'] = $studyloglist;
        return $this;
    }

    private function getHotCourse(){
    	//获取热门课件记录
		$courseparam = array('isfree'=>1,'hot'=>1,'limit'=>'0,6','order'=>'displayorder asc,cwid desc');
		$hotcoursekey = $this->cache->getcachekey('courseware',$courseparam);
        $hotcourselist = $this->cache->get($hotcoursekey);
        if(empty($hotcourselist)) {
            $coursemodel  = $this->model('Courseware');
            
            $hotcourselist = $coursemodel->getcourselist($courseparam);
            $this->cache->set($hotcoursekey,$hotcourselist,86400);
        }
        $this->data['hotcourselist'] = $hotcourselist;
        return $this;
    }

    private function getAds(){
    	//获取焦点广告列表
        $admodel = $this->model('Ad');
		$param = array('code'=>'headfocus','channel'=>'index','folder'=>2,'limit'=>'0,5');
		$headadkey = $this->cache->getcachekey('ad',$param);
        $adlist = $this->cache->get($headadkey);
        if(empty($adlist)) {
            $adlist = $admodel->getAdList($param);
            $this->cache->set($headadkey,$adlist,86400);
        }
		$adkeys = $this->cache->get('ad');
		$catkeys = $this->cache->get('category');
        $this->data['adlist'] = $adlist;
        return $this;
    }

    private function getAllRoom(){
    	//获取所有网校
		$roomparam = array('status'=>1,'filterorder'=>20000,'limit'=>'0,250','order'=>'crid DESC');
		$allroomkey = $this->cache->getcachekey('portal',$roomparam);
        $allroomlist = $this->cache->get($allroomkey);
        if(!empty($allroomlist)) {
            $roomselect = 'crname,domain';
            $allroomlist = $roommodel->getroomlist($roomparam,$roomselect);
            $this->cache->set($allroomkey,$allroomlist,86400);
        }
        $this->data['allroomlist'] = $allroomlist;
        return $this;
    }

    private function getTags(){
    	//获取标签
		$param = array('displayorder'=>'browsenumber desc','limit'=>'0,15');
		$labelkey = $this->cache->getcachekey('label',$param);
		$labellist = $this->cache->get($labelkey);
		if(empty($labellist)) {
			$labelmodel  = $this->model('Label');
			$labellist = $labelmodel->getLabelList($param);
			$this->cache->set($labelkey,$labellist,86400);
		}
        $this->data['labellist'] = $labellist;
		return $this;
    }

    private function getCenterAd(){
    	//获取通栏广告列表
		$param = array('code'=>'centerbanner','channel'=>'index','folder'=>2,'limit'=>'0,2');
		$centeradkey = $this->cache->getcachekey('ad',$param);
        $centeradlist = $this->cache->get($centeradkey);
        if(empty($centeradlist)) {
            
            $centeradlist = $admodel->getAdList($param);
            $this->cache->set($centeradkey,$centeradlist,86400);
        }
        $this->data['centeradlist'] = $centeradlist;
        return $this;
    }

    private function getNewRooms($num=8){
    	//获取最新开通平台
		$roomparam = array('status'=>1,'upid'=>0,'limit'=>'0,'.$num,'filterorder'=>20000,'order'=>'crid DESC');
		$newroomkey = $this->cache->getcachekey('classroom',$roomparam);
        $newroomlist = $this->cache->get($newroomkey);
        $roommodel  = $this->model('Classroom');
        if(empty($newroomlist)) {
            $roomselect = 'crname,domain,cface';
            $newroomlist = $roommodel->getroomlist($roomparam,$roomselect);
            $this->cache->set($newroomkey,$newroomlist,86400);
        }
        $this->data['newroomlist'] = $newroomlist;
        return $this;
    }
    private function getRooms($type,$num=32){
    	switch ($type) {
    		case 'agentschool':
    			$property = 3;
    			break;
    		case 'chargeschool':
    			$property = 1;
    			break;
    		case 'netschool':
    			$property = 2;
    			break;
    		default:
    			$property = array(0,1,2,3);
    			break;
    	}
        if($type=='agentschool'){
            $roomparam = array('status'=>1,'filterorder'=>20000,'property'=>$property,'limit'=>'0,'.$num,'order'=>'displayorder ASC,crid DESC');
        }else{
            $roomparam = array('status'=>1,'filterorder'=>20000,'upid'=>0,'property'=>$property,'limit'=>'0,'.$num,'order'=>'displayorder ASC,crid DESC');
        }
        $newroomkey = $this->cache->getcachekey('classroom',$roomparam);
        // $newroomlist = $this->cache->get($newroomkey);
        $roommodel  = $this->model('Classroom');
        // if(empty($newroomlist)) {
            $roomselect = 'crname,domain,cface,summary';
            $newroomlist = $roommodel->getroomlist($roomparam,$roomselect);
            // $this->cache->set($newroomkey,$newroomlist,86400);
        // }
        $this->data[$type.'list'] = $newroomlist;
        return $this;
    }
    private function getNews2(){
    	//获取新闻资讯记录
		$itemparam = array('best'=>1,'catid'=>686,'type'=>'news','limit'=>'0,1','displayorder'=>'displayorder,itemid desc');
		$newskey1 = $this->cache->getcachekey('item',$itemparam);
        $itemmodel  = $this->model('Item');
        $newslist1 = $this->cache->get($newskey1);
        if(empty($newslist1)) {
            
            $newslists1 = $itemmodel->getitemlist($itemparam);
            if(count($newslists1) > 0)
                $newslist1 = $newslists1[0];
            $this->cache->set($newskey1,$newslist1,86400);
        }
 
        $this->data['newslist1'] = $newslist1;

        $itemparam = array('best'=>2,'catid'=>686,'type'=>'news','limit'=>'0,12','displayorder'=>'displayorder,itemid desc');
		$newskey2 = $this->cache->getcachekey('item',$itemparam);
        $newslist2 = $this->cache->get($newskey2);
        if(empty($newslist2)) {
            
            $newslist2 = $itemmodel->getitemlist($itemparam);
            $this->cache->set($newskey2,$newslist2,86400);
        }
        $this->data['newslist2'] = $newslist2;
        return $this;
    }

    private function getNews(){
        $param1 = array('code'=>'yunintro','limit'=>'1','top'=>3,'order'=>'i.lastpost desc');
        $param2 = array('code'=>'yunintro','limit'=>'12','top'=>1,'order'=>'i.lastpost desc');
        $pitemsM = $this->model('pitems');
        $newslist1 = $pitemsM->getList($param1);
        $newslist2 = $pitemsM->getList($param2);
        $this->data['newslist1'] = $newslist1;
        $this->data['newslist2'] = $newslist2;
        return $this;
    }

    private function getCates(){
    	//获取分类列表
		$catkey = $this->cache->getcachekey('category',array(0,1,NULL,1,'0,8'));
        $catlist = $this->cache->get($catkey);
        if(empty($catlist)) {
            $catmodel  = $this->model('Category');
            $catlist = $catmodel->getCatlistByUpid(0,1,NULL,1,'0,8');
            $this->cache->set($catkey,$catlist,86400);
        }
        $this->data['catlist'] = $catlist;
        return $this;
    }

    private function getAllSchool(){
        //获取所有网校
        $roomparam = array('status'=>1,'filterorder'=>20000,'limit'=>'0,250','order'=>'crid DESC');
        $allroomkey = $this->cache->getcachekey('classroom',$roomparam);
        $allroomlist = $this->cache->get($allroomkey);
        $roommodel  = $this->model('Classroom');
        if(empty($allroomlist)) {
            
            $roomselect = 'crname,domain';
            $allroomlist = $roommodel->getroomlist($roomparam,$roomselect);
            $this->cache->set($allroomkey,$allroomlist,86400);
        }
        $this->data['allroomlist'] = $allroomlist;
        return $this;
    }

    /**
     *获取通栏广告通用方法
     *
     */
    public function getNavAds($catid=1,$code = 'nav',$num = 1,$upid=0){
        $padsModel = $this->model('pads');
        $ads = $padsModel->getCateAds($catid,$code,$num,$upid);
        if(empty($ads)){
            $ads = array(array('linkurl'=>'','thumb'=>''));
        }
        $this->data['ads_nav'] = $ads;
        return $this;
    }

    public function view(){
        $this->_detail();
        $this->getNav();
        $this->assign('isdetail',true);
        $this->display('portal/detail');
    }

    /**
     *获取栏目的导航条条
     */
    private function getNav(){
        $nav = '<a href="/yun1.html">云教学平台</a> > 正文';
        $this->assign('nav',$nav);
    }

    /**
     *详情detail页面数据分发器
     */
    private function _detail(){
        $itemid = $this->uri->itemid;
        $itemM = $this->model('pitems');
        $article = $itemM->getOneByItemid(intval($itemid));
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
        $this->assign('reviews',$reviews);
        $this->assign('token',createToken());
        $this->assign('article',$article);
        $keyword = empty($article['tag'])?$article['subject']:$article['tag'];
        $description = $article['note'];
        $title = $article['subject'];
        $seoInfo = array('keyword'=>$keyword,'description'=>$description,'title'=>$title);
        $this->assign('seoInfo',$seoInfo);
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

    public function getTkInfo(){
        //获取所有题库分类列表!
        $cachekey = $this->cache->getcachekey('resgroups',0);   //缓存的key值
        $allSchool = $this->cache->get($cachekey);
        if(empty($allSchool)) {
            $allSchool = $this->model('resgroups')->getListByGrade(0);
            $this->cache->set($cachekey,$allSchool,86400);
        }
        
        $this->data['free'] = $allSchool;
        return $this;
    }

    /**
     *
     */
    public function getQuestion(){
        
    }
    /**
     *获取顶部滚动大横幅广告
     *
     */
    public function getNavScrollAds(){
        $padsModel = $this->model('pads');
        $ads = $padsModel->getCateAds(0,'portal_navscroll',6,45);
        $this->assign('ads_portal_navscroll',$ads);
        return $this;
    }
}