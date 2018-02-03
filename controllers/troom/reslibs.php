<?php  
	/*
	*精品试题库控制器
	*/
	class ReslibsController extends CControl {
		/**
		 *精品题库首页视图
		*/
		public function index(){
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
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('roominfo',$roominfo);
			$this->assign('primarySchool',$primarySchool);
			$this->assign('middleSchool',$middleSchool);
			$this->assign('highSchool',$highSchool);
			
			$user = Ebh::app()->user->getloginuser();
			$this->assign('user',$user);
			$this->assign('subtitle','精品题库');
			$this->display('troom/reslibs');
		}
		/**
		 *精品题库列表页视图
		*/
		public function reslist(){
			$attr = $this->uri->uri_attribarr();
			$uriPath = $this->uri->uri_path();
			$this->assign('uriPath',$uriPath);
			$grade = empty($attr[0])?"":intval($attr[0]);
			$gid = empty($attr[1])?0:intval($attr[1]);
			$param = parsequery();
			$param['q'] = $this->input->get('keyword');
			$this->assign('keyword',$param['q']);
			$param['grade'] = $grade;
			$param['gid'] = $gid;
			$mygroup = $this->model('resgroups')->getGroupById($gid);
			$gradeName = empty($mygroup) ? '全题库' : $mygroup['groupname'];
			$this->assign('gradeName',$gradeName);
			$epListArr = $this->model('reslibs')->getList($param);
			if(!empty($mygroup)) {
				$epCount = $mygroup['lnum'];
			} else {
				$epCount = $this->model('reslibs')->getListCount($param);
			}
			if(empty($gid)||empty($grade)){
				$this->assign('positionTag',0);
			}else{
				$this->assign('positionTag',1);
			}
			$user = Ebh::app()->user->getloginuser();
			$this->assign('user',$user);
			$this->assign('epList',$epListArr);
			$this->assign('epCount',$epCount);
			$this->assign('showpage',show_page($epCount));
			$this->assign('subtitle','题库列表-'.$gradeName);
			$this->display('troom/reslist');

		}
	}
?>