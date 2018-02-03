<?php
/*
企业选课
*/
class SchsourceController extends ARoomV3Controller{
	/*
	企业选课列表
	*/
	public function index(){
		if($this->roominfo['isschool'] != 7){
			$this->renderjson(0,'',array());
		}
		$data['crid'] = $this->roominfo['crid'];
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.schsourceList')->addParams($data)->request();
		foreach($list as $k=>$source){
			if($source['coursecount'] == 0){
				unset($list[$k]);
			}
		}
		$list = array_values($list);
		$this->renderjson(0,'',$list);
	}
	
	/*
	课程列表
	*/
	public function itemList(){
		$data['crid'] = $this->roominfo['crid'];
		$data['sourceid'] = $this->input->get('sourceid');
		$data['pid'] = $this->input->get('pid');
		$data['sid'] = $this->input->get('sid');
		$page = $this->input->get('page');
		$pagesize = $this->input->get('pagesize');
		$q = $this->input->get('q');
		// $data['page'] = empty($page)?0:$page;
		// $data['pagesize'] = empty($pagesize)?20:$pagesize;
		$data['q'] = empty($q)?'':htmlspecialchars($q);
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.itemList')->addParams($data)->request();
		
		$splist = array();
		if(!empty($list)){
			$folderids = array_column($list,'folderid');
			$folderids = implode(',',$folderids);
			//课件数量
			$datacw['crid'] = $list[0]['crid'];
			$datacw['folderid'] = $folderids;
			$datacw['needgroup'] = 1;
			$cwcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwCount')->addParams($datacw)->request();
			
			//学习数量
			$dataf['folderids'] = $folderids;
			$dataf['crid'] = $this->roominfo['crid'];
			$studylist = $this->apiServer->reSetting()->setService('Aroomv3.Course.studyList')->addParams($dataf)->request();
			
		}
		foreach($list as $k=>$item){
			$pid = $item['pid'];
			$sid = $item['sid'];
			if(empty($splist[$pid])){
				$splist[$pid] = array('pid'=>$pid,'pname'=>$item['pname']);
			} 
			if(empty($splist[$pid]['sorts'][$sid]) && $sid !=0){
				$splist[$pid]['sorts'][$sid] = array('sid'=>$sid,'sname'=>$item['sname']);
			}
			// $splist[$pid][$sid][] = $item;
			if($item['pid'] != $data['pid'] && !empty($data['pid'])){
				unset($list[$k]);
				continue;
			}
			if($item['pid'] == $data['pid'] && $item['sid'] != $data['sid'] && !empty($data['sid'])){
				unset($list[$k]);
				continue;
			}
			if($data['q'] != '' && strpos($item['iname'],$data['q']) === FALSE){
				unset($list[$k]);
				continue;
			}
			$folderid = $item['folderid'];
			$list[$k]['studynum'] = !empty($studylist[$folderid])?$studylist[$folderid]['count']:0;
			$list[$k]['cwnum'] = !empty($cwcountlist[$folderid])?$cwcountlist[$folderid]['count']:0;
			if($this->roominfo['template'] == 'plate'){
				$list[$k]['img'] = show_plate_course_cover($item['img']);
			}
		}
		foreach($splist as $k=>$sp){
			$splist[$k]['sorts'] = empty($sp['sorts'])?array():array_values($sp['sorts']);
		}
		$splist = array_values($splist);
		$list = array_values($list);
		$this->renderjson(0,'',array('splist'=>$splist,'itemlist'=>$list));
	}
	
	/*
	企业版,选课,新的逻辑
	*/
	public function itemListNew(){
		$crid = $this->roominfo['crid'];
		$data['crid'] = $crid;
		
		$itemlist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.itemList')->addParams($data)->request();
		//本校分类
		$spdata['crid'] = $this->roominfo['crid'];
		$spdata['issimple'] = 1;//简单数据
		$selfsplist = $this->apiServer->reSetting()->setService('Aroomv3.CourseSort.spList')->addParams($spdata)->request();
		// var_dump($selfsplist);
		//第三方列表
		$schlist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.schsourceList')->addParams($data)->request();
		//初始化加上本校
		$schsourcelist = array($crid=>array('crid'=>$crid,'name'=>$this->roominfo['crname'],'children'=>array_values($selfsplist)));
		foreach($schlist as $k=>$source){
			if($source['coursecount'] != 0){
				$tsource = array('crid'=>$source['sourcecrid'],'name'=>$source['name']);
				$schsourcelist[$source['sourcecrid']] = $tsource;
			}
		}
		//本校课程
		$pids = array_keys($selfsplist);
		$spdata['pids'] = implode(',',$pids);
		$spdata['crid'] = $this->roominfo['crid'];
		$courselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.itemList')->addParams($spdata)->request();
		if(!empty($courselist)){
			$itemlist = array_merge($itemlist,$courselist);
		}
		$splist = array();
		//第三方课程
		foreach($itemlist as $k=>$item){
			$pid = $item['pid'];
			$sid = $item['sid'];
			if(empty($splist[$pid]) && $item['crid'] != $this->roominfo['crid']){
				$splist[$pid] = array('pid'=>$pid,'pname'=>$item['pname'],'crid'=>$item['crid']);
				$schsourcelist[$item['crid']]['children'][] = $splist[$pid];
			} 
			if($this->roominfo['template'] == 'plate'){
				$itemlist[$k]['img'] = show_plate_course_cover($item['img']);
			}
		}
		
		$this->renderjson(0,'',array('schsourcelist'=>array_values($schsourcelist),'itemlist'=>array_values($itemlist)));
	}
}