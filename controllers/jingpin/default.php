<?php
class DefaultController extends CControl{
		public function __construct() {
			parent::__construct();
			$user = Ebh::app()->user->getloginuser();
			$this->assign('user', $user);
		}
		/**
		 * 网校运营须知
		 */
		public function roomoperate(){
			$this->display('common/yyxz');
		} 
		/**
		  * [index ]
		  * @return [type] [description]
		  */
		 public function index(){
		 	$page = ($this->uri->page >0 )?$this->uri->page:1;
		 	$id1 = is_numeric($this->input->get('bsid'))?intval($this->input->get('bsid')):null;
		 	$id2 = is_numeric($this->input->get('msid'))?intval($this->input->get('msid')):null;
		 	$id3 = is_numeric($this->input->get('ssid'))?intval($this->input->get('ssid')):null;
		    $order = $this->inject_check(safefilter($this->input->get('order')))?$this->errorecho():safefilter($this->input->get('order'));
		 	$price = $this->inject_check(safefilter($this->input->get('price')))?$this->errorecho():safefilter($this->input->get('price'));
			$sortsmodel = $this->model('Bestsorts');
			$search = $this->inject_check(safefilter($this->input->get('search')))?$this->errorecho():safefilter($this->input->get('search'));
			$sortsone = $sortsmodel->getSort();
			$this->assign('sortsone',$sortsone);	
		 	if(empty($id1)){	
		 		$id1 = $sortsone[0]['sid'];
		 		$this->assign('bsid',$id1);
		 	}		 	
		 	$label_filter = $this->inject_check(safefilter($this->input->get('label_filter')))?$this->errorecho():safefilter($this->input->get('label_filter'));
		 	$this->getSort($id1,$id2,$id3);
		 	$this->getBestItems($id1,$id2,$id3,$label_filter,$order,$price,$page,$search);
		 	$this->display('jingpin/index');
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
				if(!empty($nextsorts[3])){
					foreach ($nextsorts[3] as $key1 => $value1) {
							if(strstr($value1['spath'],$value['spath'])){
								$nextsorts[2][$key]['child'][] = $nextsorts[3][$key1];
							}
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
		public function getBestItems($id1,$id2,$id3,$label_filter,$order,$price,$page,$search){
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
			if(!empty($search)){
				$setarr['search'] = $search;
			}			
			$bestitems = $this->model('Bestsorts')->getBestItems($sorts,$sid,$setarr);
			//var_dump($bestitems);die;
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
					$itemlabel = $this->model('Bestsorts')->getBestItemsByItem($itemsidstr,$setarr);
				}
				$bestitems = $this->getSameArray($bestitems,$itemlabel);							
			}
			$items = array();
			$start = ($page - 1) * 16 + 1;
			$stop = ($page*16 > count($bestitems))?count($bestitems):($page*16);
			for($i=($start-1);$i<$stop;$i++){
				$items[] = $bestitems[$i];
			}
			$pagestr = show_page(count($bestitems),16);
			$this->assign('bestitems',$items);
			$this->assign('pagestr',$pagestr);
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
        /**
         * [inject_check 通过正则匹配字符串中是否存在sql关键字]
         * @param  [type] $sql_str [description]
         * @return [type]          [description]
         */
	    private function inject_check($sql_str){     
	    	return preg_match('/select|insert|and|or|update|delete|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/',$sql_str);
		}	
		/**
		 * [errorecho 输出错误提示，并返回上一页]
		 * @return [type] [description]
		 */
		private function errorecho(){
			header("Content-type:text/html;charset=utf-8");
			echo "<script>alert('提交非法的参数！！！');history.back(-1);</script>";
			exit;
		}

		private function str_check( $str ) { 
		    if(!get_magic_quotes_gpc()) { 
		        $str = addslashes($str); // 进行过滤 
		    } 
		    $str = str_replace("_", "\_", $str); 
		    $str = str_replace("%", "\%", $str); 
		     
		   return $str; 
		} 
        /**
         * [view 精品课程详情页的控制器]
         * @return [type] [description]
         */
        public function view(){
 			$user = Ebh::app()->user->getloginuser();
			$id = $this->uri->itemid;
			if(!is_numeric($id)){
				echo "<script>alert('提交非法的参数！！！');history.back(-1);</script>";
				exit;
			}
			if(!empty($user)){
 				$userpermision = $this->model('userpermission');
 				$check = $userpermision->checkStudentBestPermission($id,$user['uid']);
 				if(!empty($check) && $check[0]['enddate'] > SYSTIME){
 					$this->assign('check',1);
 				}
 			}
			$itemModel = $this->model('Bestitem');
			$item = $itemModel->getItemByItemid($id);
			$sidstr = $item['bsid'].','.$item['msid'].','.$item['ssid'];
			$sortsModel = $this->model('Bestsorts');
			$sorts = $sortsModel->getOneSort($sidstr);
			$sortslist = array();
			foreach ($sorts as $key => $value) {
				$sortslist[substr_count($value['spath'],'/')-1][]=$value;
			}
			$this->assign('user',$user);
			$this->assign('sorts',$sortslist);
			$this->assign('item',$item);
			$this->display('jingpin/jingpinitem');
		}
		/**
		 * [addPermission 免费精品课，则为学生添加权限]
		 */
		public function addPermission(){
			$itemid = $this->input->post('itemid');
			$crid = $this->input->post('crid');
			$folderid = $this->input->post('folderid');
			$uid = $this->input->post('uid');
			$omonth = $this->input->post('imonth');
			$oday = $this->input->post('iday');
			$roommodel = $this->model('Classroom');
			$roominfo = $roommodel->getRoomByCrid($crid);
			if(empty($roominfo))
				echo FALSE;
			$usermodel = $this->model('User');
			$user = $usermodel->getuserbyuid($uid);
			if(empty($user))
				echo FALSE;
			//获取用户是否在此平台
			$rumodel = $this->model('Roomuser');
			$ruser = $rumodel->getroomuserdetail($crid,$uid);
			$type = 0;
			if(empty($ruser)) {	//不存在 
				$enddate = 0;
				if(!empty($crid)) {
					if(!empty($omonth)) {
						$enddate = strtotime("+$omonth month");
					} else {
						$enddate = strtotime("+$oday day");
					}
				}
				$param = array('crid'=>$crid,'uid'=>$user['uid'],'begindate'=>SYSTIME,'enddate'=>$enddate,'cnname'=>$user['realname'],'sex'=>$user['sex']);
				$result = $rumodel->insert($param);
				$type = 1;

				if($result !== FALSE) {
					if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {	//如果是收费学校，则会将账号默认添加到学校的第一个班级中
						$this->setmyclass($crid,$user['uid'],$folderid);
					} else {
						//更新教室学生数
						$roommodel->addstunum($crid);
					}
					//记录需要更新缓存和SNS同步操作的学校项目
				}
			} else {	//已存在
				if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7){
					$this->setmyclass($roominfo['crid'],$user['uid'],$folderid);//防止中途改变学校类型,导致学生在学校里面但是不在班级里面(网校改成学校) zkq 2014.07.22
				}
				$enddate=$ruser['enddate'];
				$newenddate=0;
				if(!empty($crid)) {
					if(!empty($omonth)) {
						if(SYSTIME>$enddate){//已过期的处理
							$newenddate=strtotime("+$omonth month");
						}else{	//未过期，则直接在结束时间后加上此时间
							$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$omonth month");
						}
					}else {
						if(SYSTIME>$enddate){//已过期的处理
							$newenddate=strtotime("+$oday day");
						}else{	//未过期，则直接在结束时间后加上此时间
							$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$oday day");
						}
					}
				}
				$param = array('crid'=>$crid,'uid'=>$user['uid'],'enddate'=>$newenddate,'cstatus'=>1);
				$result = $rumodel->update($param);
				$type = 2;
			}
			//处理用户权限
			$userpmodel = $this->model('UserPermission');
			if(empty($folderid)) {
				$myperm = $userpmodel->getPermissionByItemId($itemid,$uid);
			} else {
				$myperm = $userpmodel->getPermissionByFolderId($folderid,$uid);
			}
			$startdate = 0;
			$enddate = 0;
			if(empty($myperm)) {	//不存在则添加权限，否则更新
				$startdate = SYSTIME;
				if(!empty($omonth)) {
					$enddate = strtotime("+$omonth month");
				} else {
					$enddate = strtotime("+$oday day");
				}
				$ptype = 0;
				if(!empty($folderid) || !empty($crid)) {
					$ptype = 1;
				}
				$perparam = array('itemid'=>$itemid,'type'=>$ptype,'uid'=>$uid,'crid'=>$crid,'folderid'=>$folderid,'startdate'=>$startdate,'enddate'=>$enddate);
				$result = $userpmodel->addPermission($perparam);
			} else {
				$enddate=$myperm['enddate'];
				$newenddate=0;
				if(!empty($omonth)) {
					if(SYSTIME>$enddate){//已过期的处理
						$newenddate=strtotime("+$omonth month");
					}else{	//未过期，则直接在结束时间后加上此时间
						$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$omonth month");
					}
				}else {
					if(SYSTIME>$enddate){//已过期的处理
						$newenddate=strtotime("+$oday day");
					}else{	//未过期，则直接在结束时间后加上此时间
						$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$oday day");
					}
				}
				$enddate = $newenddate;
				$myperm['enddate'] = $enddate;
				if(!empty($itemid)) {
					$myperm['itemid'] = $itemid;
				}
				$result = $userpmodel->updatePermission($myperm);
			}
			echo json_encode($result);
		}

	/**
	*设置用户的默认班级信息
	* 一般为收费学校用户开通学校服务时候处理，需要将学生加入到默认的班级中
	* 如果不存在新班级，则需要创建一个默认班级
	*/
	private function setmyclass($crid,$uid,$folderid) {
		$classmodel = $this->model('Classes');
		//先判断是否已经加入班级，已经加入则无需重新加入
		$myclass = $classmodel->getClassByUid($crid,$uid);
		if(empty($myclass)) {
			//获取课程对应的年级和地区信息
			$grade = 0;
			$district = 0;
			$folderInfo = $this->model('folder')->getfolderbyid($folderid);
			$classname = "默认班级";
			if(!empty($folderInfo)){
				$grade = $folderInfo['grade'];
				$district = $folderInfo['district'];
				$grademap = Ebh::app()->getConfig()->load('grademap');
				if(array_key_exists($grade, $grademap)){
					$classname = $grademap[$grade].'默认班级';
				}
			}
			$classid = 0;
			$defaultclass = $classmodel->getDefaultClass($crid,$grade,$district);
			if(empty($defaultclass)) {	//不存在默认班级，则创建默认班级
				$param = array('crid'=>$crid,'classname'=>$classname,'grade'=>$grade,'district'=>$district);
				$classid = $classmodel->addclass($param);
			} else {
				$classid = $defaultclass['classid'];
			}
			$param = array('crid'=>$crid,'classid'=>$classid,'uid'=>$uid);
			$classmodel->addclassstudent($param);

			//记录需要更新缓存的班级项目
		}
	}
		/**
		 * [study_cwlist_view 精品课程的课程目录控制器]
		 * @return [type] [description]
		 */
		public function study_cwlist_view(){
		//$roominfo = Ebh::app()->room->getcurroom();
		//$user = Ebh::app()->user->getloginuser();
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 300;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
		if(empty($folder['playmode']) || empty($queryarr['q'])){
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
		else{
			$searchedcwlist = $coursemodel->getfolderseccourselist($queryarr);
			unset($queryarr['q']);
			$cwlist = $coursemodel->getfolderseccourselist($queryarr);
		}
		
		if(!empty($cwlist)){
		
		$cwids = '';
		foreach($cwlist as $cw){
			$cwids.= $cw['cwid'].',';
		}
		$cwids = rtrim($cwids,',');
		$param['cwid'] = $cwids;
		$pmodel = $this->model('progress');
		$progresslist = $pmodel->getFolderProgressByCwid($param);
		
		foreach($progresslist as $k=>$p){
			if($p['percent']*100>=90){
				$cwprogress[$p['cwid']] = 100;
			}
			else{
				$cwprogress[$p['cwid']] = floor($p['percent']*100);
			}
		}
		foreach($cwlist as $k=>$cw){
			if(!empty($cwprogress[$cw['cwid']]))
				$cwlist[$k]['percent'] = $cwprogress[$cw['cwid']];
			else
				$cwlist[$k]['percent'] = 0;
		}
		// var_dump($cwlist);
		}
		
		//收藏信息
		// $favoritemodel = $this->model('Favorite');
		// $fparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'uid'=>$user['uid']);
		// $myfavorites = $favoritemodel->getfolderfavoritelist($fparam);
		// $myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		
		$sectionlist = array();
		$redis = Ebh::app()->getCache('cache_redis');
        foreach($cwlist as $k=>$course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
			if(($k-1)>=0 && $cwlist[$k-1]['sid'] == $course['sid']){
				if($cwlist[$k-1]['percent'] != 100 || !empty($cwlist[$k-1]['disabled'])){
					$cwlist[$k]['disabled'] = true;
					$course['disabled'] = true;
				}
				
			}
			$viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
			if(!empty($viewnum))
				$course['viewnum'] = $viewnum;
            $sectionlist[$course['sid']][] = $course;
        }
		foreach($sectionlist as $k=>$section){
			$queryarr['sid'] = $k;
			$sectioncount = $coursemodel->getfolderseccoursecount($queryarr);
			$sectionlist[$k][0]['sectioncount'] = $sectioncount;
		}
		
		
		if(!empty($q) && $folder['playmode']){//搜索时按序播放
			// $lastsid = 0;
			$resultSection = array();
			if(!empty($searchedcwlist)){//搜索结果不为空
				foreach($searchedcwlist as $cw){
					if(!empty($cw['sid']))
						$sid = $cw['sid'];
					else
						$sid = 0;
					$resultSection[] = $sid; 
					if(!isset($lastsid))
						$lastsid = $sid;
					if($lastsid != $sid){
						//删除上一个目录末尾多余的数据
						for($i=$sectionj[$lastsid];$i<$nsectioncount[$lastsid];$i++){
							unset($sectionlist[$lastsid][$i]);
						}
						$lastsid = $sid;
					}
					if(empty($nsectioncount[$sid]))
						$nsectioncount[$sid] = count($sectionlist[$sid]);
					// var_dump($nsectioncount);
					if(empty($sectionj[$sid]))
						$sectionj[$sid] = 0;
					
					// var_dump($sectionj[$sid]);
					
					for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
						//删除与搜索结果不符的内容
						if($cw['cwid'] != $sectionlist[$sid][$i]['cwid']){
							// echo $sectionlist[$sid][$i]['cwid'];
							unset($sectionlist[$sid][$i]);
						}else{
							$sectionj[$sid] = $i+1;
							break;
						}
					}
				}	
				for($i=$sectionj[$sid];$i<$nsectioncount[$sid];$i++){
					unset($sectionlist[$sid][$i]);
				}
				foreach($sectionlist as $k=>$section){
					if(!in_array($k,$resultSection)){
						unset($sectionlist[$k]);
					}
				}
			}else{
				$sectionlist = array();
			}
			// var_dump($searchedcwlist);
		}
		//服务包限制时间,用于判断往期课件
		/*$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$limitdate = $pmodel->getFirstLimitDate(array('folderid'=>$folderid,'uid'=>$user['uid']));
			$this->assign('limitdate',$limitdate['firstday']);
		}*/
		$this->assign('sectionlist',$sectionlist);
		//$this->assign('myfavorite',$myfavorite);
		$this->assign('q',$q);
		$this->assign('cwlist',$cwlist);
		//$this->_updateuserstate(6,$folderid);
		$this->display('jingpin/cwlist');
	}
	/**
	 * [study_introduce_undercourse_view 课程介绍的控制器]
	 * @return [type] [description]
	 */
	public function study_introduce_undercourse_view(){
		//$roominfo = Ebh::app()->room->getcurroom();
		//$user = Ebh::app()->user->getloginuser();
		$folderid = $this->uri->itemid;
		$coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 100;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		// $viewnumlib = Ebh::app()->lib('Viewnum');
		// $viewnumlib->addViewnum('folder',$folderid);
		if(!empty($folder['introduce']))
			$folder['introduce'] = unserialize($folder['introduce']);
		$this->assign('folder',$folder);
		$this->display('jingpin/cwlist_introduce');
	}
	/**
	 * [attachment 资料下载的控制器]
	 * @return [type] [description]
	 */
	public function attachment(){
		//$roominfo = Ebh::app()->room->getcurroom();
		//$user = Ebh::app()->user->getloginuser();
		$requireFolderid = $this->input->get('folderid');
		if(!is_numeric($requireFolderid) || $requireFolderid < 0){
			echo '课程不存在,请刷新页面重试';
            exit();
		}
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		$q = $this->input->get('q');
		$queryarr = parsequery();
		$queryarr['folderid'] = $folderid;
		$attmodel = $this->model('attachment');
		$attlist = $attmodel->getAttachByFolderid($queryarr);
		EBH::app()->helper('fileico');
		foreach ($attlist as $k=>$att) {
            $attlist[$k]['csize'] = $this->getsize($att['size']);
            $attlist[$k]['ico'] = format_ico($att['suffix']);
		}
		$this->assign('attlist',$attlist);
		$serverutil = Ebh::app()->lib('ServerUtil');
		$source = $serverutil->getCourseSource();
		$this->assign('source',$source);
        $this->assign('q', $q);
		/*if($folder['fprice'] > 0 && $roominfo['isschool'] == 7) {
			$perparam = array('crid'=>$roominfo['crid'],'folderid'=>$folder['folderid']);
			if($this->check == 1) {	//有学校权限，那就判断是否有课程权限
				$this->check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
				
			}
			$this->assign('check',$this->check);
		} */
		$this->display('jingpin/attachment');
	}

	private function getsize($bsize){
		$size = "0字节";
		if (!empty($bsize))
		{
			$gsize = $bsize / (1024 * 1024 * 1024);
			$msize = $bsize / (1024 * 1024);
			$ksize = $bsize / 1024;
			if ($gsize > 1)
			{
				$size = round($gsize,2) . "G";
			}
			else if($msize > 1)
			{
				$size = round($msize,2) . "M";
			}
			else if($ksize > 1)
			{

				$size = round($ksize,0) . "K";
			}
			else
			{
				$size = $bsize . "字节";
			}
		}
		return $size;
	}
	/**
	 * [surveylist 问卷调查的控制器]
	 * @return [type] [description]
	 */
	public function surveylist(){
		//$user = Ebh::app()->user->getloginuser();
		//$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['folderid'] = $this->input->get('folderid');
		$folder = $this->model('folder')->getfolderbyid($param['folderid']);
		$this->assign('folder',$folder);

		//$param['crid'] = $roominfo['crid'];
		$param['ispublish'] = 1;
		$param['answered'] = true;//是否已回答
		//$param['uid'] = $user['uid'];
		$surveylist = $this->model('survey')->getSurveyList($param);
		$surveycount = $this->model('survey')->getSurveyCount($param);
		$pagestr = show_page($surveycount);

		$this->assign('pagestr',$pagestr);
		$this->assign('surveylist',$surveylist);
		$this->display('jingpin/surveylist');
	}


}
?>