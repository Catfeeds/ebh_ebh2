<?php
/*
课件控制器
*/
class CoursewareController extends AdminControl{

	public function index(){
		$this->display('admin/courseware');
	}
	// public function getlist($init=0){
	// 	$courseware = $this->model('courseware');
	// 	$pagination = $this->input->get('param');
	// 	$pagination['pagesize'] = $pagination['pagesize']?$pagination['pagesize']:20;
	// 	$pagination['pagenumber'] = $pagination['pagenumber']?$pagination['pagenumber']:1 ;
	// 	$pagination['total'] = $courseware -> getcoursewarecount($pagination);
	// 	$pagination['pages'] = ceil($pagination['total']/$pagination['pagesize']);
	// 	$pagination['limit'] = ($pagination['pagenumber']-1)*$pagination['pagesize'].','.$pagination['pagesize'];
	// 	$coursewarelist = $courseware -> getcoursewarelist($pagination);
		
	// 	if(!$init)
	// 	{
	// 		$coursewarelist[] = $pagination;
	// 		echo json_encode($coursewarelist);
	// 	}
	// 	else
	// 	{
	// 		$this->assign('coursewarelist',json_encode($coursewarelist));
	// 		$this->assign('pagination',$pagination);
	// 		$this->assign('ctrl','courseware');
	// 	}
		
	// }
	/**
	 *获课件列表,不解释
	 *@author zkq
	 */
	public function getListAjax(){
		$param = $this->input->post();
		$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
		$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
		$offset = max(0,($pageNumber-1)*$pageSize);
		parse_str($param['query'],$queryArr);
		if(!empty($queryArr['catid'])){
			$catidsArr = $this->model('category')->getOffspringCatid(intval($queryArr['catid']));
			$catidsArr[] = intval($queryArr['catid']);
		    $queryArr['in'] = '('.implode(',',$catidsArr).')';
		}
		$queryArr['limit'] = $offset.','.$pageSize;
		$CModel = $this->model('courseware');
		$total = $CModel->getcoursewarecount($queryArr);
		$CList = $CModel->getcoursewarelist($queryArr);
		array_unshift($CList,array('total'=>$total));
		echo json_encode($CList);
	}
	/*
	*添加课件
	* modified by zkq in 2014-04-25
	*/
	public function add(){
		if($this->input->post()){
			$courseware = $this->model('courseware');
			$param = safeHtml($this->input->post(),array('message','upfilepath'));
			$this->check($param);
			//原作者字段,备用
			// $authorInfo = Ebh::app()->user->getloginuser();
			// $param['author'] = $authorInfo['uid'];
			if(!empty($param['logo'])){
				$param['logo'] = $param['logo']['upfilepath'];
			}
			$image1='';
			if(!empty($param['update9090'])){
				$image1 = $param['update9090']['upfilepath'];
			}
			$image2='';
			if(!empty($param['update194194'])){
				$image2 = $param['update194194']['upfilepath'];
			}
			$image = array('image9090'=>$image1,'image194194'=>$image2);
			$param['images'] = serialize($image);
			if(!empty($param['cwurl'])){
				$cw = $param['cwurl'];
				$cwpath = explode(',',$cw['upfilepath']);
				$param['cwsource'] = $cwpath[0];
				$param['cwurl'] = $cwpath[1];
				$param['cwsize'] = $cw['upfilesize'];
				$param['cwname'] = $cw['upfilename'];
			}
			$res = $courseware->addcourseware($param);
			if($res>0){
				$this->goback();
			}else{
				$this->goback('操作失败!');
			}
		}
		else{
			$this->assign('token',createToken());
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$teacherSelect = $this->model('teacher')->getTeacherSelect();
			$this->assign('teacherSelect',$teacherSelect);
			$this->display('admin/courseware_add');
		}
	}
	/*
	删除 ajax
	*/
	public function del(){
		$courseware = $this->model('courseware');
		$cwid = $this->input->post('cwid');
		$course = $courseware->getcoursedetail($cwid);
		if($course['status']!=-3){
			$foldermodel = $this->model('Folder');
			$folderid = $course['folderid'];
			$folder = $foldermodel->getfolderbyid($folderid);
			$folderlevel = $folder['folderlevel'];
			while($folderlevel>1){
				$foldermodel->addcoursenum($folderid,-1);//课程对应课件数
				$folder = $foldermodel->getfolderbyid($folder['upid']);
				$folderlevel = $folder['folderlevel'];
				$folderid = $folder['folderid'];
			}
            $roommodel = $this->model('Classroom');
            $roommodel->addcoursenum($course['crid'],-1);//教室对应课件数
            $teachermodel = $this->model('Teacher');
            $teachermodel->addcoursenum($course['uid'],-1);//教师课件数
		}
		echo json_encode(array('success'=>$courseware->deletecourseware($cwid)));

	}
	/*
	页内编辑 ajax
	*/
	public function editcourseware(){
		$courseware = $this->model('courseware');
		$param = $this->input->post();
		echo $courseware -> editcourseware($param);
		
	}
	/*
	新页面编辑
	*/
	public function edit(){
		$courseware = $this->model('courseware');
		$param = safeHtml($this->input->post(),array('message','upfilepath'));
		if($param){
			$this->check($param);
			if(!empty($param['logo'])){
				$param['logo'] = $param['logo']['upfilepath'];
			}
			$image1='';
			if(!empty($param['update9090'])){
				$image1 = $param['update9090']['upfilepath'];
			}
			$image2='';
			if(!empty($param['update194194'])){
				$image2 = $param['update194194']['upfilepath'];
			}
			$image = array('image9090'=>$image1,'image194194'=>$image2);
			$param['images'] = serialize($image);
			if(!empty($param['cwurl'])){
				$cw = $param['cwurl'];
				$cwpath = explode(',',$cw['upfilepath']);
				$param['cwsource'] = $cwpath[0];
				$param['cwurl'] = $cwpath[1];
				$param['cwsize'] = $cw['upfilesize'];
				$param['cwname'] = $cw['upfilename'];
			}
			$res = $courseware->editcourseware($param);
			if($res>0){
				$this->goback();
			}else{
				$this->goback('操作失败!');
			}
		}else{
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$crid = $this->input->get('crid');
			$this->assign('token',createToken());
			$coursewaredetail = $courseware->getcoursewaredetail(intval($crid));
			$this->assign('formhash',formhash($coursewaredetail['crid'].$coursewaredetail['cwid']));
			$teacherSelect = $this->model('teacher')->getTeacherSelect('uid','uid',$coursewaredetail['uid']);
			$this->assign('teacherSelect',$teacherSelect);
			$coursewaredetail['images'] = unserialize($coursewaredetail['images']);
			$this->assign('c',$coursewaredetail);
			$this->display('admin/courseware_edit');
			
		}
	}
	/*
	新页面详情
	*/
	public function view(){
		$courseware = $this->model('courseware');
		$crid = $this->input->get('crid');
			$coursewaredetail = $courseware->getcoursewaredetail($crid);
			$this->assign('c',$coursewaredetail);
			$this->display('admin/courseware_view');
	}
	/**
	 *操作成功或者失败之后的跳转方法
	 *@author zkq
	 */
	private function goback($note='操作成功',$returnurl='/admin/courseware.html'){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}
	/**
	 *安检函数
	 *@param array $param
	 *
	 */
	private function check($param = array()){
		if(checkToken($param['token'])===false){
			$this->goback('请勿重复提交!');
		}
		if(!in_array($param['op'],array('add','edit'))){
			$this->goback('操作数错误!');
		}
		if($param['op']=='edit'){
			if(formhash($param['crid'].$param['cwid'])!=$param['formhash']){
				$this->goback('参数被篡改!');
			}
		}
		
		$message = array();
		$message['code']=true;
		if($this->model('teacher')->isExits($param['uid'])===false){
			$message['code'] = false;
			$message[] = '教师信息被篡改!';
		}
		//===其它检测预留======

		if($message['code']===false){
			$this->goback(implode('<br />',$message));
		}

	}

	public function copy(){
		$this->display('admin/courseware_copy');
	}
	public function roomselect(){
		$type = $this->input->get('type');
		$isschool = intval($this->input->get('isschool'));
		$this->assign('isschool',$isschool);
		$this->assign('type',$type);
		$this->display('admin/classroom_dialog');
	}

	//获取学校课程
	public function getSchoolFolder(){
		$crid = intval($this->input->post('crid'));
		$ret = $this->model('folder')->getSchoolFolder($crid);
		echo json_encode($ret);
	}

	//获取课件章节
	public function getSections(){
		$folderid = intval($this->input->post('folderid'));
		$param = array(
			'folderid'=>$folderid
		);
		$ret = $this->model('section')->getsections($param);
		echo json_encode($ret);
	}

	//获取课程的老师
	public function getFolderTeacher(){
		$folderid = intval($this->input->post('folderid'));
		if(empty($folderid)){
			echo json_encode(array());
			exit;
		}
		$ret = $this->model('folder')->getFolderTeacher($folderid);
		if(!empty($ret)){
			$ret = EBH::app()->lib('UserUtil')->init($ret,array('tid'),true);
		}
		echo json_encode($ret);
	}
	/*
	 *获课件列表
	 */
	public function getCoursewareListAjax(){
		$param = $this->input->post();
		$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
		$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
		$offset = max(0,($pageNumber-1)*$pageSize);
		parse_str($param['query'],$queryArr);
		$queryArr['limit'] = $offset.','.$pageSize;
		$queryArr['status'] = 1;
		$CModel = $this->model('courseware');
		$total = $CModel->getcoursecounts($queryArr);
		$CList = $CModel->getcourselists($queryArr);
		array_unshift($CList,array('total'=>$total));
		echo json_encode($CList);
	}

	/**
	*处理课程对应关系(课程到课程)
	*/
	private function docourse($cridlist) {
		foreach($cridlist as $mycrid) {
			$count = 0;
			$sourcecrid = $mycrid['crid'];
			$sourcefolderid = $mycrid['folderid'];
			$destarr = $mycrid['toarray'];
			$destcrid = $destarr['crid'];
			$destfolderid = $destarr['folderid'];
			$tid = $destarr['tid'];
			// $  = $destarr['itemid'];
			$destsid = $olddestsid = empty($destarr['sid']) ? 0 : $destarr['sid'];	//章节编号
			
			if(!empty($this->acwids)){
				$courselistsql = 'select *from ebh_coursewares where status= 1 AND cwid in ('.implode(',', $this->acwids).')';
			}else{
				$courselistsql = "select *from ebh_coursewares where status= 1 AND cwid in (select cwid from ebh_roomcourses where crid=$sourcecrid and folderid=$sourcefolderid)";
			}
			
			$sourcecwlist = $this->db->query($courselistsql)->list_array();
			if(!empty($sourcecwlist)) {
				foreach($sourcecwlist as $courseparam) {
					$sourcecwid = $courseparam['cwid'];
					$courseparam['sourcecwid'] = $courseparam['cwid'];
					unset($courseparam['cwid']);

					$courseparam['reviewnum'] = 0;
					$courseparam['attachmentnum'] = 0;
                    $courseparam['assistantid'] = '';
					$courseparam['uid'] = $tid;

					if($courseparam['islive'] == 1){
                        $liveConfig = Ebh::app()->getConfig()->load('live');

                        $rtmpServer = isset($liveConfig[$destcrid]) ? $liveConfig[$destcrid] : $liveConfig['default'];

                        $liveLib = Ebh::app()->lib($rtmpServer,'Live');
                        $liveinfoData = $liveLib->createLive($courseparam['submitat'],$courseparam['cwlength']);
                        if(!$liveinfoData){
                            $this->msg[] = "create liveinfo error error:sourcwcwid:$sourcecwid ";
                            return FALSE;
                        }
                        $courseparam['liveid'] = $liveinfoData['liveid'];
                    }
					$destcwid = $this->db->insert('ebh_coursewares',$courseparam);	//复制课件表
					if(empty($destcwid)) {
						$this->msg[] = "insert ebh_coursewares error:sourcwcwid:$sourcecwid";
						return FALSE;
					}
					// $roomcoursesql = "select *from ebh_roomcourses where cwid=$sourcecwid and crid=$sourcecrid and folderid=$sourcefolderid";
					$roomcoursesql = "select *from ebh_roomcourses where cwid=$sourcecwid";
					$rcitem = $this->db->query($roomcoursesql)->row_array();
					if(empty($rcitem)) {
						// $this->msg[] = "no ebh_roomcourses error:sourcwcwid:$sourcecwid crid:$sourcecrid folderid:$sourcefolderid";
						$this->msg[] = "no ebh_roomcourses error:sourcwcwid:$sourcecwid ";
						return FALSE;
					}
					if(!empty($this->desctionArr['copysname']) && empty($olddestsid)){
						$destsid = $this->createSection($rcitem['sid'],$destfolderid,$destcrid);
					}
					$rcitem['crid'] = $destcrid;
					$rcitem['folderid'] = $destfolderid;
					$rcitem['cwid'] = $destcwid;
					$rcitem['sid'] = $destsid;
                    $rcitem['classids'] = '';
					$rcresult = $this->db->insert('ebh_roomcourses',$rcitem);	//复制课件学校关联表
					if($rcresult === FALSE) {
						$this->msg[] = "insert ebh_coursewares error:sourcwcwid:$sourcecwid destcwid:$destcwid destfolderid:$destfolderid destcrid:$destcrid";
						return FALSE;
					}
                    //如果是直播课件 复制liveinfo信息
                    if($courseparam['islive'] == 1){
                        $liveinfoData['type'] = $rtmpServer;
                        $liveinfoSql = 'select * from ebh_course_liveinfos where cwid='.$sourcecwid;
                        $liveinfo = $this->db->query($liveinfoSql)->row_array();
                        $liveinfoData['cwid'] = $destcwid;
                        $liveinfoData['review'] = $liveinfo['review'];
                        $liveinfoData['review_start'] = $liveinfo['review_start'];
                        $liveinfoData['review_end'] = $liveinfo['review_end'];
                        $liveinfoData['camera_sourceid'] = $liveinfo['camera_sourceid'];
                        $liveinfoData['video_sourceid'] = $liveinfo['video_sourceid'];
                        $liveinforesult = $this->db->insert('ebh_course_liveinfos',$liveinfoData);	//复制课件直播信息 并且创建liveif
                        if($liveinforesult === false){
                            $this->msg[] = "insert ebh_course_liveinfos error:sourcwcwid:$sourcecwid destcwid:$destcwid destfolderid:$destfolderid destcrid:$destcrid";
                            return FALSE;
                        }
                    }
					$count ++;
				}
			}
			$this->msg[] = "crid:$sourcecrid course allcount:$count";

			//课程课件数增加
			$where = 'folderid='.$destfolderid;
			$setarr = array('coursewarenum'=>'coursewarenum+'.$count);
			$this->db->update('ebh_folders',array(),$where,$setarr);

			//学校课件数增加
			$where = 'crid='.$destcrid;
			$setarr = array('coursenum'=>'coursenum+'.$count);
			$this->db->update('ebh_classrooms',array(),$where,$setarr);
		}
		return TRUE;
	}

	private $db = NULL;
	private $msg = array();

    public function docopy() {
    	$cridlist = array();
    	$source = $this->input->post('source');
    	$desction = $this->input->post('desction');
    	$scwids = $this->input->post('scwids');
    	if(!empty($scwids)){
    		$this->acwids = $acwids = explode(',', $scwids);
    	}
    	parse_str($source,$sourceArr);
    	parse_str($desction,$desctionArr);
   		$this->sourceArr = $sourceArr;
   		$this->desctionArr = $desctionArr;
		$cridlist[] = array('crid'=>intval($sourceArr['crid']),'folderid'=>intval($sourceArr['folderid']),'toarray'=>array('crid'=>intval($desctionArr['crid']),'folderid'=>intval($desctionArr['folderid']),'sid'=>intval($desctionArr['sid']),'tid'=>intval($desctionArr['tid'])));
		set_time_limit(0);
		$this->db = Ebh::app()->getDb();
		$this->db->begin_trans(); //开启事物
		//$result = $this->doall($cridlist);	//处理所有
		$result = $this->docourse($cridlist);
		//$result = FALSE;

		//$result = $this->dothecourse($cridlist);

		//$result = $this->dothecourse($cridlist);



		//$result = $this->dopreviewbydest();	//单独处理评论
		if ($this->db->trans_status() === false) {//检测 事物状态
			$this->db->rollback_trans();//错误 回滚
			echo 'fail';
		} else {
			if($result) {
				$this->db->commit_trans();//事物提交
				echo 'success';
			} else {
				$this->db->rollback_trans();//错误 回滚
				echo 'fail';
			}
		} 
		
		// print_r($this->msg);
		// log_message(print_r($this->msg,true));
    }

    private $sid_map = array();
    //创建章节(不会重复创建)，返回章节号sid
    private function createSection($sid = 0,$folderid = 0,$crid = 0){
    	if(empty($sid)){
    		return 0;
    	}
    	$skey = 's_'.$sid;
    	if(array_key_exists($skey, $this->sid_map)){
    		return $this->sid_map[$skey];
    	}
    	//1.检测是否有同名的分类
    	$sql_for_s_section = 'select sname,displayorder,dateline from ebh_sections where sid = '.$sid;
    	$s_section = $this->db->query($sql_for_s_section)->row_array();
    	if(empty($s_section)){
    		return 0;
    	}
    	$s_section_name = $s_section['sname'];
    	$s_section_dateline = $s_section['dateline'];
    	$s_section_displayorder = intval($s_section['displayorder']);

    	$sql_for_d_section = 'select sid from ebh_sections where folderid = '.$folderid.' AND crid = '.$crid.' AND sname = \''.$this->db->escape_str($s_section_name).'\'';
    	$d_section = $this->db->query($sql_for_d_section)->row_array();
    	if(!empty($d_section)){
    		return $this->sid_map[$skey] = $d_section['sid'];
    	}
    	//2.不存在则创建分类
    	$param_for_create = array(
    		'folderid'=>$folderid,
    		'crid'=>$crid,
    		'displayorder'=>$s_section_displayorder,
    		'dateline'=>$s_section_dateline,
    		'coursewarecount'=>0,
    		'sname'=>$this->db->escape_str($s_section_name)
    	);
    	$res = $this->db->insert('ebh_sections',$param_for_create);
    	if($res === FALSE) {
    		return 0;
    	}else{
    		return $this->sid_map[$skey] = $res;
    	}
    }
}
?>