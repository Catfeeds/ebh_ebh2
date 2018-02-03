<?php
/**
 * 免费资源控制器
 */
class DefaultController extends CControl{
    public function __construct() {
        parent::__construct();
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user',$user);        
    }
    //免费资源首页
    public function index() {
		//获取试卷库信息
		$cachekey = $this->cache->getcachekey('resgroups',0);
		$allSchool = $this->cache->get($cachekey);
		if (empty($allSchool)) {
			$allSchool = $this->model('resgroups')->getListByGrade(0);
			$this->cache->set($cachekey,$allSchool,86400);
		}
		
		//试卷库总数 0小学，1初中，2高中
		$papersCount = array(
			'0' => 0,
			'1' => 0,
			'2' => 0		
		);
		foreach ($allSchool as $school) {
			if($school['grade'] == 1) {
				$papersCount[0] += $school['lnum'];
			} else if($school['grade'] == 7) {
				$papersCount[1] += $school['lnum'];
			} else if($school['grade'] == 10) {
				$papersCount[2] += $school['lnum'];
			}
		}		
		
		//获取资源版本列表
		$this->assign('resourceVersionList', $this->model('resource')->getVersionList());
		//获取年级类型和年级信息
		$grade_type_list = $this->model('question')->getGradeTypeList();
		foreach ($grade_type_list as $key => $value)
		{
			$grade_type_list[$key]['child'] = $this->model('question')->getGradeList($key);
		}
		
		//设置seo标题关键字描述
		$seoInfo['title'] = '免费资源 - e板会';
		$seoInfo['keyword'] = '免费资源,资源库,题库,试卷库,免费网校';
		$seoInfo['description'] = 'e板会是全球领先的网络在线资源有偿分享增值服务平台，免费资源频道提供免费网校、试卷、题目等相关学习资源，为您提供愉悦的网上学习体验。';
		$this->assign('seoInfo', $seoInfo);
		
		$this->assign('papersCount', $papersCount);
		$this->assign('gradeTypeList', $grade_type_list);		
		$this->display('freeresource/default_index');		
	}
	
}
