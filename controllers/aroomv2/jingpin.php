<?php
/**
 * 精品课
 */
class JingpinController extends CControl{
	public function __construct(){
		parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$systemModel = $this->model('Systemsetting');
		$sys = $systemModel->getSetting($roominfo['crid']);
		Ebh::app()->room->checkRoomControl();
		if(empty($sys) || $sys['service'] == 0){
			echo 'you have not permission to access!';
			exit;		
		}
	}
	/**
	 * 已选择精品课程
	 */
	public function index(){
		//一些查询
		$selectModel = $this->model('Select');
		$pid = intval($this->input->get('pid'));
		$sid = intval($this->input->get('sid'));
		$page = $this->uri->page >0 ? $this->uri->page : 1;
		$roominfo = Ebh::app()->room->getcurroom();
		$pagesize = 18;
		$param['crid'] = $roominfo['crid'];
		$param['pid'] = $pid;
		$param['sid'] = $sid;
		$param['limit'] = (max(0,($page - 1)) * $pagesize).','.$pagesize;
		$itemids = array();
		$count = $selectModel->getCoursesCount($param);
		$tmpitems = $selectModel->getCourses($param);
		if(!empty($tmpitems)){
			foreach ($tmpitems as $sitem){
				$itemids[$sitem['itemid']] = array(
						'iskk'=>$sitem['iskk'],
						'pid'=>$sitem['pid'],
						'sid'=>$sitem['sid'],
						'topayitemid'=>$sitem['topayitemid']
				);
			}
		}
		$bestlist = array();
		if(!empty($itemids)){
			$bestsortsModel = $this->model('Bestsorts');
			$itemidarr = array_keys($itemids);
			$itemstr = implode(',', $itemidarr);
			$bestlist = $bestsortsModel->getBestItemsByItem($itemstr);
		}
		$this->fetchcate();
		$pagestr = show_page($count,$pagesize);
		$this->assign('pid',$pid);
		$this->assign('sid',$sid);
		$this->assign('pagestr',$pagestr);
		$this->assign('itemids',$itemids);
		$this->assign('courses',$bestlist);
		$this->display('aroomv2/pubcourse');
	}
	/**
	 * ajax方式获取已选择课程
	 */
	public function getajaxcourses(){
		//一些查询
		$selectModel = $this->model('Select');
		$pid = intval($this->input->post('pid'));
		$sid = intval($this->input->post('sid'));
		$page = $this->uri->page >0 ? $this->uri->page : 1;
		$pagesize = 18;
		$param['pid'] = $pid;
		$param['sid'] = $sid;
		$param['limit'] = (max(0,($page - 1)) * $pagesize).','.$pagesize;
		$itemids = array();
		$count = $selectModel->getCoursesCount($param);
		$tmpitems = $selectModel->getCourses($param);
		if(!empty($tmpitems)){
			foreach ($tmpitems as $sitem){
				$itemids[$sitem['itemid']] = array(
												'iskk'=>$sitem['iskk'],
												'pid'=>$sitem['pid'],
												'sid'=>$sitem['sid'],
												'topayitemid'=>$sitem['topayitemid']
				);
			}	
		}
		$bestlist = array();
		if(!empty($itemids)){
			$bestsortsModel = $this->model('Bestsorts');
			$itemidarr = array_keys($itemids);
			$itemstr = implode(',', $itemidarr);
			$bestlist = $bestsortsModel->getBestItemsByItem($itemstr);
		}
		$bestlist = array_merge($bestlist,$bestlist,$bestlist,$bestlist,$bestlist,$bestlist,$bestlist);
		$html = $this->coursetmpl($bestlist,$itemids);
		//如果为空则显示暂无课程
		if($page == 1 && empty($html)){
			$html = '<li style="text-align:center">暂无课程</li>';	
		}
		$pagestr = ajaxpage($count,$pagesize,$page);
		echo json_encode(array('html'=>$html,'pagestr'=>$pagestr,'size'=>count($bestlist)));
	}
	
	/*
	 * 分类设置
	*/
	public function cateset(){
		$this->fetchcate();
		$this->display('aroomv2/cateset');
	}
	/**
	 * 获取课程列表模板
	 */
	private function coursetmpl($courses,$itemids){	
		$html = '';
		foreach ($courses as $citem){
			$viewurl = $itemids[$citem['itemid']]['iskk'] == 1 ? '/courseinfo/'.$itemids[$citem['itemid']]['topayitemid'].'.html' : '/ke/'.$citem['itemid'].'.html?from=aroom';
			$thumb = empty($citem['longblockimg']) ? "http://static.ebanhui.com/ebh/tpl/courses/images/shtisut.jpg" : $citem['longblockimg'];
			$html .= '<li class="iuhni dkmars">
				 <a target="_blank" class="kuetgf" href="'.$viewurl.'">
				 	<img width="230px" height="136px" src="'.$thumb.'">
				 </a>
				 <span class="wrnssrs">共'.$citem['coursewarenum'].'课时</span>
				 <h2 class="klejts"><a title="'.$citem['iname'].'" target="_blank" href="'.$viewurl.'">'.shortstr($citem['iname'],40).'</a></h2>
				 <span class="renares">'.$citem['viewnum'].'</span>
				 <span class="euitsd">'.shortstr($citem['crname'],24).'</span>';
				 if($itemids[$citem['itemid']]['iskk'] == 0){
				 	if($citem['iprice'] == 0){
				 		$html .= '<p class="lbsrver">免费</p>';
				 	}else{
				 		$html .= '<p class="lsirse">￥'.$citem['iprice'].'</p>';
				 	}
				 	$html .= '<div class="egbdet">
				 				<a href="javascript:;" class="hissre" data-itemid="'.$citem['itemid'].'">删除</a>
								<a href="javascript:;" class="buewers" data-sid="'.$itemids[$citem['itemid']]['sid'].'" data-pid="'.$itemids[$citem['itemid']]['pid'].'" data-itemid="'.$citem['itemid'].'">分类</a>';
				 	$html .= '<a href="javascript:;" data-itemid="'.$citem['itemid'].'" class="hwufhd">开课</a>';
				 }else{
				 	if($citem['iprice'] == 0){
				 		$html .= '<p class="lbsrver" style="width:78px">免费</p>';
				 	}else{
				 		$html .= '<p class="lsirse" style="width:78px">￥'.$citem['iprice'].'</p>';
				 	}
				 	$html .= '<div class="egbdet" style="width:152px">
				 				<a href="javascript:;" class="hissre" data-itemid="'.$citem['itemid'].'">删除</a>
								<a href="javascript:;" class="buewers iopen" style="background:#e5e5e5;color:#999;" data-sid="'.$itemids[$citem['itemid']]['sid'].'" data-pid="'.$itemids[$citem['itemid']]['pid'].'" data-itemid="'.$citem['itemid'].'">分类</a>';
				 	$html .= '<a href="javascript:;" class="husiret">已开课</a>';
				 }
				 $html .= '</div></li>';
		}
		return $html;
	} 
	
	/**
	 * 获取主分类与子分类
	 */
	private function fetchcate(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$marr['crid'] = $roominfo['crid'];
		$marr['itype'] = 1;
		$marr['uid'] = $user['uid'];
		$marr['limit'] = 100;
		$jModel = $this->model('Jingpin');
		$mlist = $jModel->getMainType($marr);
		$pids = $slist = array();
		if(!empty($mlist)){
			foreach ($mlist as $row){
				$pids[] = $row['pid'];
			}
		}
		$tslist = array(); //pid关联子类数组
		if(!empty($pids)){
			$slist = $jModel->getSubType(array('pids'=>implode(',',$pids)));
			if(!empty($slist)){
				foreach ($slist as $item){
					if(isset($tslist[$item['pid']])){
						$tslist[$item['pid']][] = array('sid'=>$item['sid'],'sname'=>$item['sname']);
					}else{
						$tslist[$item['pid']] = array(array('sid'=>$item['sid'],'sname'=>$item['sname']));
					}
				}
			}
		}
		$this->assign('mlist',$mlist);
		$this->assign('tslist',$tslist);
	}
	/*
	 * 选课中心
	 */
	public function selcourses(){
		$page = $this->uri->page >0 ? $this->uri->page : 1;
		$id1 = $this->input->get('bsid') ? intval($this->input->get('bsid')) : 0;
		$id2 = $this->input->get('msid') ? intval($this->input->get('msid')) : 0;
		$id3 = $this->input->get('ssid') ? intval($this->input->get('ssid')) : 0;
		$order = $this->input->get('order') ? $this->input->get('order') : '';
		$price = $this->input->get('price') ? $this->input->get('price') : '';
		$request = $this->input->get();
		$sortsmodel = $this->model('Bestsorts');
		$sortsone = $sortsmodel->getSort();
		$this->assign('sortsone',$sortsone);
		$baseurl = '/aroomv2/jingpin/selcourses.html?bsid='.$id1.'&msid='.$id2.'&ssid='.$id3;
		if(empty($order)){
			$request['order'] = '';
		}
		if(empty($price)){
			$request['price'] = '';
		}
		if(empty($id1)){
			$request['bsid'] = 0;
		}
		if(empty($id2)){
			$request['msid'] = 0;
		}
		if(empty($id3)){
			$request['ssid'] = 0;	
		}
		$tags = $this->input->get('tag');
		$label_filter = '';
		if(!empty($tags)){
			$label_filter = implode(',', $tags);
			$baseurl .= '&tag[]='.implode('&tag[]=', $tags);
		}else{
			$request['tag'] = array();
		}
		$this->getSort($id1,$id2,$id3);
		$this->assign('request',$request);
		$this->assign('baseurl',$baseurl);
		$this->getBestItems($id1,$id2,$id3,$label_filter,$order,$price,$page);
		$this->fetchcate();
		$this->display('aroomv2/selcourses');
	}
	/**
	 * 选课操作
	 */
	public function dosel(){
		$itemid = intval($this->input->post('itemid'));
		$pid = intval($this->input->post('pid'));
		$sid = intval($this->input->post('sid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//参数校验
		if($itemid<=0 || $pid<=0 || $sid<0){
			$retarr['code'] = -4;
			$retarr['msg'] = $pid == 0 ? '必须选择一个分类' : '参数错误';
			echo json_encode($retarr);
			exit; 
		}
		$jinpinModel = $this->model('Jingpin');
		$selectModel = $this->model('Select');
		//检测是否已选择
		$param['crid'] = $roominfo['crid'];
		$param['itemid'] = $itemid;
		$selected = $jinpinModel->isSelectedCourse($param);
		if($selected){
			echo json_encode(array('code'=>-1,'msg'=>'已选择该精品课'));
			exit;
		}
		$course = $jinpinModel->getOneCourse($itemid);
		if(empty($course)){
			echo json_encode(array('code'=>-2,'msg'=>'该精品课不存在'));
			exit;
		}
		$setarr['crid'] = $roominfo['crid'];
		$setarr['pid'] = $pid;
		$setarr['sid'] = $sid;
		$setarr['dateline'] = SYSTIME;
		$setarr['uid'] = $user['uid'];
		$setarr['itemid'] = $course['itemid'];
		$ret = $selectModel->addCourse($setarr);
		$retarr['code'] = $ret > 0 ? 0 : -3;
		$retarr['msg'] = $retarr['code'] == 0 ? '选课成功' : '选课失败';
		echo json_encode($retarr);
	}
	/**
	 * 移动操作
	 */
	public function domove(){
		$itemid = intval($this->input->post('itemid'));
		$pid = intval($this->input->post('pid'));
		$sid = intval($this->input->post('sid'));
		//参数校验
		if($itemid<=0 || $pid<=0 || $sid<0){
			echo json_encode(array('code'=>-2,'msg'=>'参数错误'));
			exit;	
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$selectModel = $this->model('Select');
		$setarr['pid'] = $pid;
		$setarr['sid'] = $sid;
		$setarr['dateline'] = SYSTIME;
		$ret = $selectModel->updateCourse($setarr,array('crid'=>$roominfo['crid'],'itemid'=>$itemid));
		$retarr['code'] = $ret > 0 ? 0 : -1;
		$retarr['msg'] = $retarr['code'] == 0 ? '移动成功' : '移动失败';
		echo json_encode($retarr);
	}
	/**
	 * 删除操作
	 */
	public function dodelete(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$itemid = intval($this->input->post('itemid'));
		$course = $this->model('Select')->getOneCourse(array('crid'=>$roominfo['crid'],'itemid'=>$itemid));
		if(empty($course)){
			echo json_encode(array('code'=>-1,'msg'=>'参数错误'));
			exit;
		}
		//直接删除		
		$ret = $this->model('Select')->deleteLocalCourse(array('crid'=>$roominfo['crid'],'itemid'=>$itemid,'iskk'=>$course['iskk'],'pid'=>$course['pid'],'uid'=>$user['uid'],'sid'=>$course['sid']));
		$retarr['code'] = $ret > 0 ? 0 : $ret;
		if($retarr['code'] == -2){
			$retarr['msg'] = '参数错误';
		}else if($retarr['code'] == -3){
			$retarr['msg'] = '已有学生报名该课程不能删除';
		}else if($retarr['code'] == 0){
			$retarr['msg'] = '删除成功';
		}else{
			$retarr['msg'] = '删除失败';
		}
		echo json_encode($retarr);
	}
	/**
	 * 开课操作 
	 */
	public function dokk(){
		$roominfo = Ebh::app()->room->getcurroom();
		$itemid = intval($this->input->post('itemid'));
		$selectModel = $this->model('Select');
		$course = $selectModel->getOneCourse(array('crid'=>$roominfo['crid'],'itemid'=>$itemid));
		if(empty($course)){
			echo json_encode(array('code'=>-1,'msg'=>'选择的精品课不存在'));
			exit;
		}
		if($course['iskk'] == 1){
			echo json_encode(array('code'=>-2,'msg'=>'已开课，不必重复开课'));
			exit;
		}
		$bestitem = $selectModel->getDetailCourse($itemid);
		if(empty($bestitem)){
			echo json_encode(array('code'=>-3,'msg'=>'精品课不存在'));
			exit;
		}
		//添加服务项
		$jingpinModel = $this->model('Jingpin');
		$param['iname'] = $bestitem['iname'];
		$param['crid'] = $roominfo['crid'];
		$param['pid'] = $course['pid'];
		$param['iprice'] = $bestitem['iprice'];
		$param['isummary'] = $bestitem['isummary'];
		$param['folderid'] = $bestitem['folderid'];
		$param['sid'] = $course['sid'];
		$param['providercrid'] = $bestitem['providercrid'];
		$param['comfee'] = $bestitem['comfee'];
		$param['roomfee'] = $bestitem['roomfee'];
		$param['providerfee'] = $bestitem['providerfee'];
		$param['longblockimg'] = $bestitem['longblockimg'];
		$param['isyouhui'] = $bestitem['isyouhui'];
		$param['iprice_yh'] = $bestitem['iprice_yh'];
		$param['comfee_yh'] = $bestitem['comfee_yh'];
		$param['roomfee_yh'] = $bestitem['roomfee_yh'];
		$param['providerfee_yh'] = $bestitem['providerfee_yh'];
		$param['imonth'] = $bestitem['imonth'];
		$param['iday'] = $bestitem['iday'];
		$param['cannotpay'] = $bestitem['cannotpay'];
		$param['dateline'] = SYSTIME;
		$param['itemid'] = $itemid;
		$res = $jingpinModel->selectCourse($param);
		$resarr['code'] = $res ? 0 : -4;
		$resarr['msg'] = $resarr['code'] == 0 ? '开课成功' : '开课失败';
		echo json_encode($resarr);
	}
	
	/**
	 * [getSort 根据url传递的参数进行分类以及标签的读取]
	 * @param  [type] $id1 [大分类的id]
	 * @param  [type] $id2 [中分类的id]
	 * @param  [type] $id3 [小分类的id]
	 * @return [type]      [description]
	 */
	public function getSort($id1,$id2,$id3){
		$path = "/$id1/";
		$sortsModel = $this->model('Bestsorts');
		$next = $sortsModel->getNextSort($path);
		$nextsorts = array();
		foreach ($next as $key => $value) {
		$nextsorts[substr_count($value['spath'],'/')][]=$value;
		}
		if(!empty($nextsorts[2])){
			foreach ($nextsorts[2] as $key => $value) {
			foreach ($nextsorts[3] as $key1 => $value1) {
			if(strstr($value1['spath'],$value['spath'])){
			$nextsorts[2][$key]['child'][] = $nextsorts[3][$key1];
			}
			}
			}
		}
		$this->assign('nextsorts',$nextsorts);
		if(!empty($id3)){
				$sid = $id3;
		$label = $sortsModel->getLabelBySid($sid);
		if(!empty($label))
			$this->assign('label',$label);
		}
	}
	/**
	 * [getBestItems 根据url传递的参数 读取符合条件的精品课程]
	 * @param  [type] $id1          [大分类的id]
	 * @param  [type] $id2          [中分类的id]
	 * @param  [type] $id3          [小分类的id]
	 * @param  [type] $label_filter [description]
	 * @return [type]               [description]
	 */
	public function getBestItems($id1,$id2,$id3,$label_filter,$order,$price,$page){
		$bestitems = array();
		if(!empty($id3)){
			$sorts = 'ssid';
			$sid = $id3;
		}elseif(!empty($id2)){
			$sorts = 'msid';
			$sid = $id2;
		}elseif(!empty($id1)){
			$sorts = 'bsid';
			$sid = $id1;
		}else{
			$sorts = '';
			$sid = '';
		}
		$setarr = array();
		if(!empty($order)){
			$setarr[$order] = $order;
		}
		if(!empty($price)){
			$setarr['price'] = $price;
		}
		//加上过滤条件
		$filter['itemids'] = array();
		$roominfo = Ebh::app()->room->getcurroom();
		$filterarr = $this->model('Select')->getCourses(array('crid'=>$roominfo['crid']));
		if(!empty($filterarr)){
			foreach ($filterarr as $farr){
				$filter['itemids'][] = $farr['itemid'];
			}
		}
		//sid = -100猜你喜欢类型，单独过滤
		if($sid == -100){
			$user = Ebh::app()->user->getloginuser();
			$redis = Ebh::app()->getCache('cache_redis');
			$guess = unserialize($redis->hget('bestguess',$user['uid']));
			if(is_array($guess) === true){
				$itemsidstr = implode(',', $guess);
				$bestitems = $this->model('bestitem')->getItemList(array('itemidlist'=>$itemsidstr,'nolimit'=>1));
				$setarr = array();
				if(!empty($bestitems)){
					foreach ($bestitems as $key => $value) {
						$setarr[] = $value['ssid'];
					}
					$setarr = array_unique($setarr);
					$setarrs['ssid'] = implode($setarr,',');
					if(!empty($price)){
						$setarrs['price'] = $price;
					}
					$count = $this->model('bestitem')->getItemcount($setarrs);
					$setarrs['page'] = $page;
					$setarrs['pagesize'] = 18;
					if(!empty($order)){
						$setarrs[$order] = $order;
					}
					if(!empty($price)){
						$setarrs['price'] = $price;
					}
					$bestitems = $this->model('bestitem')->getItemList($setarrs);
					$pagestr = show_page($count[0]['count(*)'],18);
					$this->assign('pagestr',$pagestr);
				}
			}
		}else{
			$bestitems = $this->model('Bestsorts')->getBestItems($sorts,$sid,$setarr,$filter);
		}
		$label = array();
		$labelstr = '';
		if(!empty($label_filter)){
			$label = explode(',',$label_filter);
			foreach ($label as $key => $value) {
				$labelstr.= '\''.$value.'\',';
			}
			$labelstr = rtrim($labelstr,',');
			$itemsid = $this->model('Bestsorts')->getSortByLabels($labelstr);
			$itemsid = $this->assoc_unique($itemsid,'itemid');
			if($itemsid){
				$itemsidstr = '';
				foreach ($itemsid as $key => $value) {
					$itemsidstr.= $value['itemid'].',';
				}
				$itemsidstr = rtrim($itemsidstr,',');
				$itemlabel = $this->model('Bestsorts')->getBestItemsByItem($itemsidstr);
			}
			$bestitems = $this->getSameArray($bestitems,$itemlabel);
		}
		$items = array();
		$start = ($page - 1) * 18 + 1;
		$stop = ($page*18 > count($bestitems))?count($bestitems):($page*18);
		for($i=($start-1);$i<$stop;$i++){
			$items[] = $bestitems[$i];
		}
		$pagestr = show_page(count($bestitems),18);
		$this->assign('bestitems',$items);
		$this->assign('pagestr',$pagestr);
	}
	/**
	 * 保存课程主类别
	 */
	public function savemaintype(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$pid  = intval($this->input->post('pid'));
		$jModel = $this->model('Jingpin');
		$pname = trim($this->input->post('str'));
		if($pid == 0){
			$param['uid'] = $user['uid'];
			$param['crid'] = $roominfo['crid'];
			$param['pname'] = $pname;
			$param['dateline'] = SYSTIME;
			$param['summary'] = '';
			$param['itype'] = 1;
			$param['displayorder'] = 0;
			$param['limitdate'] = 0;
			$pid = $jModel->addMainType($param);
			$result = $pid;
		}else{
			$param['pname'] = $pname;
			$wharr['uid'] = $user['uid'];
			$wharr['crid'] = $roominfo['crid'];
			$wharr['pid'] = $pid;
			$result = $jModel->updateMainType($param,$wharr);
		}
		$retarr['code'] = $result > 0 ? 0 : -1;
		$retarr['id'] = $pid;
		echo json_encode($retarr);
	}
	/**
	 * 删除课程主类别
	 */
	public function delmaintype(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$pid = intval($this->input->post('pid'));
		$jModel = $this->model('Jingpin');
		$param['pid'] = $pid;
		$param['sid'] = 0;
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$jModel = $this->model('Jingpin');
		$result = $jModel->deleteLocalType($param);
		if($result){
			$retarr['code'] = 0;
			$retarr['msg'] = '删除成功';
		}else if($result == -2){
			$retarr['code'] = -2;
			$retarr['msg'] = '已有学生报名该课程类别下的课程，不能删除';
		}else{
			$retarr['code'] = -1;
			$retarr['msg'] = '删除失败';
		}
		echo json_encode($retarr);
	}
	/**
	 * 删除课程子类别
	 */
	public function delsubtype(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$pid = intval($this->input->post('pid'));
		$sid = intval($this->input->post('sid'));
		$param['pid'] = $pid;
		$param['sid'] = $sid;
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$jModel = $this->model('Jingpin');
		$ret = $jModel->deleteLocalType($param);
		$retarr['code'] = $ret > 0 ? 0 : $ret;
		if($retarr['code'] == 0){
			$retarr['msg'] = '删除成功';
		}else if($retarr['code'] == -2){
			$retarr['msg'] = '已有学生报名该课程类别下的课程，不能删除';
		}else{
			$retarr['msg'] = '删除失败';
		}
		echo json_encode($retarr);
	}
	/*
	 * 保存课程子类别
	*/
	public function savesubtype(){
		$roominfo = Ebh::app()->room->getcurroom();
		$sid  = intval($this->input->post('sid'));
		$pid = intval($this->input->post('pid'));
		$jModel = $this->model('Jingpin');
		$sname = trim($this->input->post('str'));
		if($sid == 0){
			$param['sname'] = $sname;
			$param['content'] = '';
			$param['pid'] = $pid;
			$sid = $jModel->addSubType($param);
			$result = $sid;
		}else{
			$param['sname'] = $sname;
			$wharr['sid'] = $sid;
			$wharr['pid'] = $pid;
			$result = $jModel->updateSubType($param,$wharr);
		}
		$retarr['code'] = $result > 0 ? 0 : -1;
		$retarr['sid'] = $sid;
		echo json_encode($retarr);
	}
	/**
	 * [assoc_unique 去掉两个数组中重复的部分]
	 * @param  [type] $arr [description]
	 * @param  [type] $key [description]
	 * @return [type]      [description]
	 */
	private function assoc_unique($arr, $key){
		$tmp_arr = array();
		foreach($arr as $k => $v){
			if(in_array($v[$key], $tmp_arr)){
				unset($arr[$k]);
			}else {
				$tmp_arr[] = $v[$key];
			}
		}
		sort($arr); //sort函数对数组进行排序
		return $arr;
	}
	/**
	 * [getSameArray 获得两个二维数组的交集]
	 * @param  [type] $arr1 [description]
	 * @param  [type] $arr2 [description]
	 * @return [type]       [description]
	 */
	private function getSameArray($arr1,$arr2){
		$nearr = array();
		foreach ($arr1 as $value){
			foreach ($arr2 as $val){
				if($value==$val){
					$nearr[]=$value;
				}
			}
		}
		return $nearr;
	}
}