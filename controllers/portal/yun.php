<?php
class YunController extends PortalControl{
	function index() {
        //获取课件学习记录,热门课件记录
       
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		//数据分配
		$this->getStudyLog()->getHotCourse()->getNewRooms(11)->getTags()->getNews()->getAds()->getRooms('agentschool',8)->getRooms('chargeschool',24)->getRooms('netschool');
        $this->display('portal/yun');
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
        $this->assign('studyloglist', $studyloglist);
        return $this;
    }

    private function getHotCourse(){
    	//获取热门课件记录
		$courseparam = array('isfree'=>1,'hot'=>1,'limit'=>'0,9','order'=>'displayorder asc,cwid desc');
		$hotcoursekey = $this->cache->getcachekey('courseware',$courseparam);
        $hotcourselist = $this->cache->get($hotcoursekey);
        if(empty($hotcourselist)) {
            $coursemodel  = $this->model('Courseware');
            
            $hotcourselist = $coursemodel->getcourselist($courseparam);
            $this->cache->set($hotcoursekey,$hotcourselist,86400);
        }
        $this->assign('hotcourselist', $hotcourselist);
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
        $this->assign('adlist', $adlist);
        return $this;
    }

    private function getAllRoom(){
    	//获取所有网校
		$roomparam = array('status'=>1,'filterorder'=>10000,'limit'=>'0,250','order'=>'crid DESC');
		$allroomkey = $this->cache->getcachekey('classroom',$roomparam);
        $allroomlist = $this->cache->get($allroomkey);
        if(empty($allroomlist)) {
            
            $roomselect = 'crname,domain';
            $allroomlist = $roommodel->getroomlist($roomparam,$roomselect);
            $this->cache->set($allroomkey,$allroomlist,86400);
        }
        $this->assign('allroomlist', $allroomlist);
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
		$this->assign('labellist',$labellist);
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
        $this->assign('centeradlist', $centeradlist);
        return $this;
    }

    private function getNewRooms($num=8){
    	//获取最新开通平台
		$roomparam = array('status'=>1,'upid'=>0,'limit'=>'0,'.$num,'order'=>'displayorder ASC,crid DESC');
		$newroomkey = $this->cache->getcachekey('classroom',$roomparam);
        $newroomlist = $this->cache->get($newroomkey);
        $roommodel  = $this->model('Classroom');
        if(empty($newroomlist)) {
            $roomselect = 'crname,domain,cface';
            $newroomlist = $roommodel->getroomlist($roomparam,$roomselect);
            $this->cache->set($newroomkey,$newroomlist,86400);
        }
        $this->assign('newroomlist', $newroomlist);
        return $this;
    }
    private function getRooms($type,$num=32){
    	switch ($type) {
    		case 'agentschool':
    			$isschool = 0;
    			break;
    		case 'chargeschool':
    			$isschool = array(3,6);
    			break;
    		case 'netschool':
    			$isschool = 2;
    			break;
    		default:
    			$isschool = array(0,3,2,6);
    			break;
    	}
    	//获取最新开通平台
		$roomparam = array('status'=>1,'upid'=>0,'isschool'=>$isschool,'limit'=>'0,'.$num,'order'=>'displayorder ASC,crid DESC');
		$newroomkey = $this->cache->getcachekey('classroom',$roomparam);
        $newroomlist = $this->cache->get($newroomkey);
        $roommodel  = $this->model('Classroom');
        if(empty($newroomlist)) {
            $roomselect = 'crname,domain,cface,summary';
            $newroomlist = $roommodel->getroomlist($roomparam,$roomselect);
            $this->cache->set($newroomkey,$newroomlist,86400);
        }
        $this->assign($type.'list', $newroomlist);
        return $this;
    }
    private function getNews(){
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
 
        $this->assign('newslist1', $newslist1);

        $itemparam = array('best'=>2,'catid'=>686,'type'=>'news','limit'=>'0,12','displayorder'=>'displayorder,itemid desc');
		$newskey2 = $this->cache->getcachekey('item',$itemparam);
        $newslist2 = $this->cache->get($newskey2);
        if(empty($newslist2)) {
            
            $newslist2 = $itemmodel->getitemlist($itemparam);
            $this->cache->set($newskey2,$newslist2,86400);
        }
        $this->assign('newslist2', $newslist2);
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
        $this->assign('catlist', $catlist);
        return $this;
    }
}