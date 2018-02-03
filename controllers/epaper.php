<?php
/**
 *前端精品题库控制器
 *@author zkq
*/
Class EpaperController extends PortalControl{
	/**
	 *精品题库首页视图
	*/
	public function index(){
		//获取所有题库分类列表
		$cachekey = $this->cache->getcachekey('resgroups',0);	//缓存的key值
		$allSchool = $this->cache->get($cachekey);
		if(empty($allSchool)) {
			$allSchool = $this->model('resgroups')->getListByGrade(0);
			$this->cache->set($cachekey,$allSchool,86400);
		}
		$primarySchool = array();
		$middleSchool = array();
		$highSchool = array();
		foreach($allSchool as $school) {
			if($school['grade'] == 1) {
				$primarySchool[] = $school;
			} else if($school['grade'] == 7) {
				$middleSchool[] = $school;
			} else if($school['grade'] == 10) {
				$highSchool[] = $school;
			}
		}
		
		//设置seo标题关键字描述
		$seoInfo['title'] = '试卷库 - e板会';
		$seoInfo['keyword'] = '试卷库,试卷浏览,试卷下载,免费资源';
		$seoInfo['description'] = 'e板会试卷库提供小学试卷、初中试卷 高中试卷等相关资源免费浏览下载。';
		$this->assign('seoInfo', $seoInfo);

		$this->assign('primarySchool',$primarySchool);
		$this->assign('middleSchool',$middleSchool);
		$this->assign('highSchool',$highSchool);
		
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->assign('subtitle','精品题库');
		$this->display('common/epaper_cover');
	}
	/**
	 *精品题库列表页视图
	*/
	public function eplist(){
		$attr = $this->uri->uri_attribarr();
		$uriPath = $this->uri->uri_path();
		$this->assign('uriPath',$uriPath);
		$grade = empty($attr[0])?"":intval($attr[0]);
		$gid = empty($attr[1])?0:intval($attr[1]);
		$param = parsequery();
		$param['q'] = $this->input->get('keyword');
		$param['q'] = h($param['q']);
		$param['q'] = htmlentities($param['q'], ENT_QUOTES, "UTF-8");
		$this->assign('keyword',$param['q']);
		$param['grade'] = $grade;
		$param['gid'] = $gid;
		$param['order'] = 'dateline desc,lid asc';
		$mygroup = $this->model('resgroups')->getGroupById($gid);
		$gradeName = empty($mygroup) ? '全题库' : $mygroup['groupname'];
		$this->assign('gradeName',$gradeName);
		$issearch = false;	//是否是搜索，如果搜索则不缓存
		if(!empty($param['q'])) {
			$issearch = true;
		}
		//加入缓存处理
		$cachekey = $this->cache->getcachekey('reslibs',$param);	//缓存的key值
		$reslist = $this->cache->get($cachekey);
		if(!empty($reslist)) {
			$epListArr = $reslist['list'];
			$epCount = $reslist['count'];
		} else {
			$epListArr = $this->model('reslibs')->getList($param);
			if(!empty($mygroup) && !$issearch) {
				$epCount = $mygroup['lnum'];
			} else {
				$epCount = $this->model('reslibs')->getListCount($param);
			}
			$reslist = array('list'=>$epListArr,'count'=>$epCount);
			if(!$issearch) {
				$this->cache->set($cachekey,$reslist,86400);
			}
		}
		
		if(empty($gid)||empty($grade)){
			$this->assign('positionTag',0);
		}else{
			$this->assign('positionTag',1);
		}
		
		//设置seo标题关键字描述
		$seoInfo['title'] = $gradeName . ' 试卷库 - e板会';
		$seoInfo['keyword'] = $gradeName . ',试卷浏览,试卷下载,免费资源';
		$seoInfo['description'] = 'e板会' . $gradeName . '试卷库提供试卷免费浏览下载。';
		$this->assign('seoInfo', $seoInfo);
		
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->assign('epList',$epListArr);
		$this->assign('epCount',$epCount);
		$this->assign('showpage',show_page($epCount));
		$this->assign('subtitle','题库列表-'.$gradeName);
		$this->display('common/epaper_list');

	}
	/**
	 *精品题库获取附件输出,供下载用
	*/
	public function attach(){
		$lid = intval($this->input->get('lid'));
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			$url = geturl('login').'?returnurl='.geturl('epaper/eplist');
			header("Location:".$url);
			return;
		}
		$this->model('reslibs')->_refresh($lid,1);
		$attchInfo = $this->model('reslibs')->getAttchByLid($lid);
		getfile('reslibs',$attchInfo['libpath'],$attchInfo['libname'].'.doc');
	}
	/**
	 *题库预览视图
	*/
	public function view(){
		$user = Ebh::app()->user->getloginuser();
		if($user==false){
			$url = geturl('login').'?returnurl='.geturl('epaper/eplist');
			header("Location:".$url);
		}
		$lid = $this->uri->itemid;
		$attchInfo = $this->model('reslibs')->getAttchByLid($lid);
		$title = $attchInfo['libname'];
		$this->assign('lid',$lid);
		$this->assign('attchInfo',$attchInfo);
		$this->assign('title',$title);
		$this->display('common/epaper_view');
	}
	/**
	 *获取预览题库附件,供题库预览使用
	*/
	public function outputSwf_view(){
		$lid = intval($this->uri->lastsegment());
		$attchInfo = $this->model('reslibs')->getAttchByLid($lid);
		$this->model('reslibs')->_refresh($lid,-1);
		$pos = strpos($attchInfo['libpath'],'.');
		$attchInfo['libpath'].='.swf';
		getfile('reslibs',$attchInfo['libpath'],$attchInfo['libpath']);
	}
}
?>