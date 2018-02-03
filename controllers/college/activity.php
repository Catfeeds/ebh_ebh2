<?php
/**
 * 活动控制器
 */
class ActivityController extends CControl {
	public function __construct(){
		parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
	}
	
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(!empty($user) && !empty($roominfo)){
			$classModel = $this->model('classes');
			$classids = $classModel->getClassidsByUid($roominfo['crid'],$user['uid']);//学生对应的classid
			if($roominfo['isschool'] == 7){
				$foldModel = $this->model('folder');
				$freefold = $foldModel->getfreefolderList($roominfo['crid']);//免费课的folderid
				$permModel = $this->model('Userpermission');
				$perfold = $permModel->getfolderListByUid($roominfo['crid'],$user['uid']);
				$folderlist = array_merge($freefold,$perfold);
			}else{
				if(!empty($classids)){
					$classidstr = implode(',',$classids);
				}
				$classroom = $classModel->getclassroombyclassid($roominfo['crid'],$classidstr);
					if(!empty($classroom)){
						$grade = '';
						foreach ($classroom as $class) {
							if(!empty($class['grade'])){
								$grade.=$class['grade'].',';
							}
						}
						if(!empty($grade)){
							$grade = rtrim($grade,',');
						}
						$foldlist1 = array();
						$foldlist2 = array();
						if(!empty($grade)){
							$foldModel = $this->model('folder');
							$foldlist1 = $foldModel->getfolderListByGrade($roominfo['crid'],$grade);//根据年级获取folderid
						}else{
							$classModel = $this->model('classes');
							$teacherid = $classModel->getteacheridByclassid($classidstr);
							$teacheridstr = '';
							if(!empty($teacherid)){
								foreach ($teacherid as $key => $value) {
								$teacheridstr.=$value['uid'].',';
								}
								$teacheridstr = rtrim($teacheridstr,',');
							}
							$foldModel = $this->model('folder');
							$foldlist2 = $foldModel->getfolderListByuid($roominfo['crid'],$teacheridstr);
						}
				}
				$folderlist = array_merge($foldlist1,$foldlist2);
			}	
		}
		$acmodel = $this->model('activity');
		$param = parsequery();
		$page = !empty($param['page'])?$param['page']:1;
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$param['order'] = SYSTIME.'<endtime+86400 desc,pdateline is not null desc,date desc';
		$aclist = $acmodel->getStudentActivity($param);
		foreach ($aclist as $key =>$ac) {
			if($ac['type'] == 1){
				$cla = explode(',',$ac['tidstr']);
				$list = $this->getSameArray($cla,$classids);
				if(empty($list)){
					unset($aclist[$key]);
				}
			}
			if($ac['type'] == 2){
				$fld = explode(',',$ac['tidstr']);
				if(!empty($fld)){
					foreach ($fld as $k => $value) {
						$fld1[$k] = array('folderid'=>$value);
					}
					$list = $this->getSameArray($fld1,$folderlist);
					if(empty($list)){	
						unset($aclist[$key]);
					}
				}
			}
		}
		$aclist1 = array();
		$aclist2 = array();
		foreach ($aclist as $key => $value) {
			$aclist1[] = $value; 
		}
		for($i=($page-1)*20;$i<=20*$page-1;$i++){
			if(!empty($aclist1[$i]))
			$aclist2[] = $aclist1[$i];
		}
		//$actcount = $acmodel->getCount($roominfo['crid']);
		$actcount['count'] = count($aclist);
		$this->assign('pagestr',show_page($actcount['count']));
		$this->assign('aclist',$aclist2);
		$this->display('college/activity');
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

	/*
	说明
	*/
	public function description(){
		$this->display('college/activity_description');
	}
	
	/*
	介绍,报名页面
	*/
	public function intro_view(){
		$aid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$acmodel = $this->model('activity');
		//报名信息
		$param['aid'] = $aid;
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$actdetail = $acmodel->getStudentActivity($param);
		
		//评论
		$paramreview = parsequery();
		$paramreview['pagesize'] = 10;
		$paramreview['aid'] = $aid;
		$paramreview['crid'] = $roominfo['crid'];
		$areviewlist = $acmodel->getReview($paramreview);
		$areviewcount = $acmodel->getReviewCount($aid);
		$pagestr = show_page($areviewcount['count'],$paramreview['pagesize']);
		$this->assign('pagestr',$pagestr);
		$upstr = '';
		//引用评论
		foreach($areviewlist as $review){
			if(!empty($review['upid'])){
				// $uparr[$review['upid']] = $review['upid'];
				$upstr .= $review['upid'].',';
			}
		}
		if(!empty($upstr)){
			$upstr = rtrim($upstr,',');
			$upreviewlist = $acmodel->getReviewByCid(array('cid'=>$upstr,'aid'=>$aid));
			foreach($upreviewlist as $upreview){
				$upreviewarr[$upreview['cid']] = $upreview;
			}
			// var_dump($upreviewarr);
			$this->assign('upreviewarr',$upreviewarr);
		}
		
		//报名人员
		$param['pagesize'] = 36;
		$parterlist = $acmodel->getParterList($param);
		$this->assign('parterlist',$parterlist);
		$this->assign('actdetail',$actdetail);
		$this->assign('areviewlist',$areviewlist);
		$page = empty($paramreview['page'])?1:$paramreview['page'];
		$this->assign('page',$page);
		$this->display('college/activity_intro');
		$acmodel->addviewnum($param['aid']);
	}
	
	/*
	报名情况
	*/
	public function parter_view(){
		$param['aid'] = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$acmodel = $this->model('activity');
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		
		$actdetail = $acmodel->getStudentActivity($param);
		$param['limit'] = 1000;
		$acmodel = $this->model('activity');
		$parterlist = $acmodel->getParterList($param);
		$this->assign('parterlist',$parterlist);
		$this->assign('actdetail',$actdetail);
		$this->display('college/activity_parter');
	}
	
	/*
	报名
	*/
	public function joinin(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$acmodel = $this->model('activity');
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$param['aid'] = $this->input->post('aid');
		$res = $acmodel->addStudentActivity($param);
	}
	
	/*
	表情
	*/
	public function getemotion(){
		$emotion = Ebh::app()->getConfig()->load('emotion');
		foreach ($emotion as $key=>$val){
			$tmp['tit'] = $key;
			$tmp['url'] = $val;
			$emotionarr[] = $tmp; 
		}
		echo json_encode($emotionarr);
	}
	
	/*
	发表评论
	*/
	public function review_publish(){
		$user = Ebh::app()->user->getloginuser();
		$param['aid'] = $this->input->post('aid');
		$param['uid'] = $user['uid'];
		$param['upid'] = $this->input->post('upid');
		$param['review'] = $this->input->post('content');
		$acmodel = $this->model('activity');
		if(!empty($param['review'])){
			$this->checkSensitive($param['review']);
		}
		$res = $acmodel->addReview($param);
		if($res){
			$floor = $acmodel->getFloor(array('aid'=>$param['aid'],'cid'=>$res));
			echo json_encode(array('success'=>1,'floor'=>$floor));
		}else{
			echo json_encode(array('success'=>0,'message'=>'发送失败,可能是字数过多,请删减后再试'));
		}
	}
	/*
	删除评论
	*/
	public function review_del(){
		$user = Ebh::app()->user->getloginuser();
		$cid = $this->input->post('cid');
		$acmodel = $this->model('activity');
		$res = $acmodel->delReview($cid);
		if($res){
			echo json_encode(array('success'=>1));
		}else{
			echo json_encode(array('success'=>0,'message'=>'删除失败'));
		}
	}
	
	/*
	排名
	*/
	public function rank_view(){
		$aid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$acmodel = $this->model('activity');
		//报名信息
		$param['aid'] = $aid;
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$actdetail = $acmodel->getStudentActivity($param);
		$this->assign('actdetail',$actdetail);
		//报名人员
		$param = parsequery();
		$param['aid'] = $aid;
		// $param['pagesize'] = 10;
		$param['order'] = 'credit desc,pdateline asc';
		$parterlist = $acmodel->getParterList($param);
		$this->assign('parterlist',$parterlist);
		$page = empty($param['page'])?1:$param['page'];
		$this->assign('page',$page);
		$pagestr = show_page($parterlist['count'],$param['pagesize']);
		$this->assign('pagestr',$pagestr);
		//我的排名
		if(!empty($actdetail['credit'])){
			$myrank = $acmodel->getRank(array('aid'=>$aid,'credit'=>$actdetail['credit'],'pdateline'=>$actdetail['pdateline']));
			$this->assign('myrank',$myrank);
		}
		$this->assign('user',$user);
		$this->display('college/activity_rank');
	}
	
	/*
	积分明细
	*/
	public function credit_view(){
		$aid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$acmodel = $this->model('activity');
		
		$param['aid'] = $aid;
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$actdetail = $acmodel->getStudentActivity($param);
		if(!empty($actdetail)){
			$actdetail['truetime'] = empty($actdetail['pdateline'])?0:max($actdetail['starttime'],$actdetail['pdateline']);
		}
		$this->assign('actdetail',$actdetail);
		$this->assign('aid',$aid);
		$creditmodel = $this->model('credit');
		$param = parsequery();
		$param['toid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$param['isact'] = 1;
		$param['datefrom'] = empty($actdetail['truetime'])?9999999999:$actdetail['truetime'];
		$param['dateto'] = empty($actdetail['endtime'])?0:($actdetail['endtime']+86400);
		$creditlist = $creditmodel->getcreditlist($param);
		$creditcount = $creditmodel->getusercreditcount($param);
		$this->assign('creditlist',$creditlist);
		$this->assign('pagestr',show_page($creditcount));
		
		$this->display('college/activity_credit');
	}
	
	/*
	活动中的说明
	*/
	public function descriptioninact_view(){
		$aid = $this->uri->itemid;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$acmodel = $this->model('activity');
		
		$param['aid'] = $aid;
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$actdetail = $acmodel->getStudentActivity($param);
		$this->assign('actdetail',$actdetail);
		$this->assign('aid',$aid);
		$this->display('college/activity_description_inact');
	}
	/**
     * 对添加或编辑的问题的标题和内容进行敏感词验证
     */
    public function checkSensitive($title){
    	//获取国土的网校配置,如果是国土，不进行验证
        $roominfo = Ebh::app()->room->getcurroom();
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $appsetting['zjdlsensitive'] =  !empty($appsetting['zjdlsensitive'])? 1 : 0;//浙江国土是否开通关键字过滤
        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);
        if (($is_zjdlr || $is_newzjdlr) && !$appsetting['zjdlsensitive']) {//国土网校则执行
            return '';
        }

        require(LIB_PATH."SimpleDict.php");
        if(!file_exists(LIB_PATH."sensitive.cache")){
			SimpleDict::make(LIB_PATH."sensitive.dat",LIB_PATH."sensitive.cache");
        } 
        $dict = new SimpleDict(LIB_PATH."sensitive.cache");
        $title =  preg_replace("/\s/","",$title);
        $result = $dict->search($title);
        $resultarr= array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $resultarr[] =  $value['value'];
            }
            echo json_encode(array('success'=>-1,'Sensitive'=>$resultarr));
            exit;
        }
    }
	
}