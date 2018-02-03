<?php
/**
 * 企业版相关内容
 */
class EnterpriseController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
		$this->roominfo = Ebh::app()->room->getcurroom();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
    }
	
    /**
     * 部门
     */
    public function department() {
		$param['crid'] = $this->roominfo['crid'];
		$param['crname'] = $this->roominfo['crname'];
		//所有部门
        $list = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.index')->addParams($param)->request();
		//讲师所在部门
		$user = Ebh::app()->user->getloginuser();
		$param['uid'] = $user['uid'];
		$tdlist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.teacherDepts')->addParams($param)->request();
		if (!empty($tdlist) && !empty($list)) {
		    $list = array_filter($list, function($dept) use($tdlist) {
		        if (isset($tdlist[$dept['classid']])) {
		            //直接具有权限的部门
		            return true;
                }
                foreach ($tdlist as $item) {
		            //权限部门的上级
                    if ($item['lft'] > $dept['lft'] && $item['rgt'] < $dept['rgt']) {
                        return true;
                    }
		            //权限部门的下级
                    if ($item['lft'] < $dept['lft'] && $item['rgt'] > $dept['rgt']) {
                        return true;
                    }
                }
                return false;
            });
            array_walk($list, function(&$dept, $i, $tdlist) {
                if (isset($tdlist[$dept['classid']])) {
                    //直接具有权限的部门
                    $dept['haspower'] = true;
                    return;
                }
                //权限部门的下级部门，继承权限
                foreach ($tdlist as $item) {
                    if ($item['lft'] < $dept['lft'] && $item['rgt'] > $dept['rgt']) {
                        $dept['haspower'] = true;
                        return;
                    }
                }
            }, $tdlist);
            $list = array_combine(array_column($list, 'classid'), $list);
        }
		$mylist = array();
		if (!empty($list)) {
		    $mylist = $list;
        }
		// var_dump($tdlist);
		//所在部门及其上下级
		/*foreach($tdlist as $classid=>$class){
			$curclassid = $classid;
			//下级
			$this->getChildren($list,$curclassid,$mylist);
			//上级
			while(!empty($list[$curclassid])){
				if(!isset($mylist[$curclassid])){
					$mylist[$curclassid] = $list[$curclassid];
				}
				$curclassid = $list[$curclassid]['superior'];
			}
			// var_dump($curclassid);
			if(!empty($mylist[$classid])){
				$mylist[$classid]['haspower'] = 1;
			}
		}*/
		//我有权限的
		if(!empty($mylist)){
			$classidarr = array();
			foreach($mylist as $classid=>$class){
				if(!empty($class['haspower'])){
					$classidarr[] = $classid;
				}
			}
			$classids = implode(',',$classidarr);
			$staff = $this->input->get('staff');
			$bind = $this->input->get('bind');
			if(!empty($staff)){//查询员工
				$countlist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.deptUserCount')->addParams(array('classids'=>$classids,'crid'=>$this->roominfo['crid']))->request();
				foreach($mylist as $classid=>$class){
					$mylist[$classid]['usercount'] = !empty($countlist[$classid])?$countlist[$classid]['count']:0;
				}
			} elseif(!empty($bind)){//查询微校通绑定
				//bind,1绑定，2未绑定
				$countlist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.bindCount')->addParams(array('classids'=>$classids,'crid'=>$this->roominfo['crid'],'bind'=>$bind))->request();
				// var_dump($countlist);
				foreach($mylist as $classid=>$class){
					$mylist[$classid]['usercount'] = !empty($countlist[$classid])?$countlist[$classid]['count']:0;
				}
			} else {//没传staff,没传bind，查询课程
				$sourceid = $this->input->get('sourceid');			
				if(empty($sourceid)){//本校课程
					$countlist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.classCourseCount')->addParams(array('classids'=>$classids,'crid'=>$this->roominfo['crid']))->request();
				} else {//第三方课程
					$crinfo = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.crinfo')->addParams(array('sourceid'=>$sourceid))->request();
					if(!empty($crinfo) && $crinfo['crid'] == $this->roominfo['crid']){
						$countlist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.classItemCount')->addParams(array('classids'=>$classids,'crid'=>$this->roominfo['crid'],'sourcecrid'=>$crinfo['sourcecrid']))->request();
						// var_dump($countlist);
					}
				}
				foreach($mylist as $classid=>$class){
					$mylist[$classid]['coursecount'] = !empty($countlist[$classid])?$countlist[$classid]['count']:0;
				}
			}
		}
		// var_dump($classidarr);
		$this->renderjson(0,'',array_values($mylist));
    }
	
	//所在部门下级
	private $childrensearched = array();
	private function getChildren(&$list,$curclassid,&$mylist){
		if(isset($this->childrensearched[$curclassid])){
			return;
		}
		$this->childrensearched[$curclassid] = 1;
		foreach($list as $classid=>$class){
			if($class['superior'] == $curclassid){
				$list[$classid]['haspower'] = 1;
				if(!isset($mylist[$classid])){
					$mylist[$classid] = $list[$classid];
				}
				$this->getChildren($list,$classid,$mylist);
			}
		}
	}
	
	/*
	 *绑定的员工列表
	*/
	public function bindUser(){
		$param['crid'] = $this->roominfo['crid'];
		$param['bind'] = $this->input->get('bind');
		$param['classid'] = $this->input->get('classid');
		$param['pagesize'] = $this->input->get('pagesize');
		$param['page'] = $this->input->get('page');
		$userlist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.bindUser')->addParams($param)->request();
		$this->renderjson(0,'',$userlist);
	}
	
	/*
	部门课程
	*/
	public function deptCourse(){
		$param['classid'] = $this->input->get('classid');
		$param['crid'] = $this->roominfo['crid'];
		$detail = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.detail')->addParams($param)->request();
		if(empty($detail)){
			$this->renderjson(0,'',array());
		}
		$user = Ebh::app()->user->getloginuser();
		$tdparam['uid'] = $user['uid'];
		$tdparam['crid'] = $param['crid'];
		$tdlist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.teacherDepts')->addParams($tdparam)->request();
		$allow = FALSE;
		foreach($tdlist as $department){//该部门 选择了该老师或者是所选部门的子部门
			if($department['classid'] == $detail['classid'] || ($detail['lft']>$department['lft'] && $detail['rgt']<$department['rgt'])){
				$allow = TRUE;
				break;
			}
		}
		if(!$allow){
			$this->renderjson(0,'',array());
		}
		// var_dump($detail);
		
		$itemlist = array();
		$sourceid = $this->input->get('sourceid');
		if(!empty($sourceid)){
			$crinfo = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.crinfo')->addParams(array('sourceid'=>$sourceid))->request();
		}
		if(!empty($crinfo) && $crinfo['crid'] == $this->roominfo['crid']){//外校课程
			$classids = $detail['classid'];
			$courselist = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.classItemList')->addParams(array('crid'=>$this->roominfo['crid'],'classids'=>$classids))->request();
		} else {
			$courselist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.deptCourse')->addParams($param)->request();
		}
		
		if(!empty($courselist)){
			if(empty($sourceid)){//本校
				$param['roominfo'] = $this->roominfo;
				$folderids = array_column($courselist,'folderid');
				$param['folderids'] = implode(',',$folderids);
			} else {//第三方
				$param['crid'] = $crinfo['sourcecrid'];
				$param['roominfo'] = array('isschool'=>7,'crid'=>$crinfo['sourcecrid']);
				$itemids = array_column($courselist,'itemid');
				$param['itemids'] = implode(',',$itemids);
                $folderids = array_column($courselist,'folderid');
                $param['folderids'] = implode(',',$folderids);
			}
			$param['pagesize'] = $this->input->get('pagesize');
			$param['page'] = $this->input->get('page');
			// var_dump($param);
			$itemlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseList')->addParams($param)->request();
		}
		
		if(!empty($itemlist)){
			//课件数量
			$datacw['crid'] = $this->roominfo['crid'];
			$datacw['folderid'] = $param['folderids'];
			$datacw['needgroup'] = 1;
			$cwcountlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.cwCount')->addParams($datacw)->request();
			
			foreach($itemlist['courselist'] as $k=>$item){
				$folderid = $item['folderid'];
				if(!empty($cwcountlist[$folderid])){
					$itemlist['courselist'][$k]['coursewarenum'] = !empty($cwcountlist[$folderid])?$cwcountlist[$folderid]['count']:0;
				}
				if($this->roominfo['template'] == 'plate'){
					$itemlist['courselist'][$k]['img'] = show_plate_course_cover($item['img']);
				}
			}
		}
		$this->renderjson(0,'',$itemlist);
	}
	
	/*
	 *第三方企业列表
	*/
	public function schsource(){
		$data['crid'] = $this->roominfo['crid'];
		$list = $this->apiServer->reSetting()->setService('Aroomv3.Schsource.schsourceList')->addParams($data)->request();
		foreach($list as $k=>$source){
			if($source['coursecount'] == 0){
				unset($list[$k]);
			}
		}
		$this->renderjson(0,'',array_values($list));
	}
	
	/*
	教师课程
	*/
	public function teacherCourse(){
		$user = Ebh::app()->user->getloginuser();
		$data['uid'] = $user['uid'];
		$data['crid'] = $this->roominfo['crid'];
		$courselist = $this->apiServer->reSetting()->setService('Aroomv3.Enterprise.teacherCourse')->addParams($data)->request();
		
		$folderids = array_column($courselist,'folderid');
		$param['folderids'] = implode(',',$folderids);
		$param['crid'] = $this->roominfo['crid'];
		$param['roominfo'] = $this->roominfo;
		$param['pagesize'] = 200;
		
		$itemlist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseList')->addParams($param)->request();
		$this->renderjson(0,'',$itemlist);
	}
	
	/**
     * json格式输出
     * @param number $code 状态标识 0 成功 1 失败
     * @param string $msg 输出消息
     * @param array $data 数组参数数组
     * @param string $exit 是否结束退出
     */
    private function renderjson($code=0,$msg="",$data=array(),$exit=true){
        $arr = array(
            'code'=>(intval($code) ===0) ? 0 : intval($code),
            'msg'=>$msg,
            'data'=>$data
        );
        echo json_encode($arr);
        if($exit){
            exit();
        }
    }
}
