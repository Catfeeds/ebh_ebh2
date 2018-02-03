<?php
/**
 * 调查问卷
 */
class MoreController extends CControl{
	public function __construct(){
		parent::__construct();
        Ebh::app()->room->checkRoomControl();
	}
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
        $appmoduleModel = $this->model('Appmodule');
        //系统模块
        $modules = $appmoduleModel->getmodulelist(array('system' => 1, 'showmode' => 0, 'limit' => 200), true);
        //自定义模块
        $roomModules = $appmoduleModel->getRoomSet(array('crid' => $roominfo['crid'], 'limit' => 200), true);
        if (!empty($roomModules)) {
            //合并有效模块
            foreach ($roomModules as $moduleid => $roomModule) {
                $modules[$moduleid] = $roomModule;
            }
            unset($roomModules);
        }
        $moduleyunpan = $modulexuanke = $modulehealth = $moduleforum = $moduleactivity = $moduleeth = $moduleselectcourse = false;
        if (!empty($modules)) {
            foreach ($modules as $module) {
                /*if (empty($module['available'])) {
                    continue;
                }*/
                switch ($module['modulecode']) {
                    case 'kpan':
                        $moduleyunpan = $module;
                        break;
                    case 'xuanke':
                        $modulexuanke = $module;
                        break;
                    case 'health':
                        $modulehealth = $module;
                        break;
                    case 'forum':
                        $moduleforum = $module;
                        break;
                    case 'activity':
                        $moduleactivity = $module;
                        break;
                    case 'weixin':
                        $moduleeth = $module;
                        break;
                    case 'selectcourse':
                        $moduleselectcourse = $module;
                        break;
                }
            }
            unset($modules);
        }
        //是否开启云盘模块
        /*$moduleyunpan = $this->model('appmodule')->getstudentmodule(array('crid'=>$roominfo['crid'],'available'=>1,'modulecode'=>'yunpan','order'=>'displayorder','limit'=>1));
        $modulexuanke = $this->model('appmodule')->getstudentmodule(array('crid'=>$roominfo['crid'],'available'=>1,'modulecode'=>'xuanke','order'=>'displayorder','limit'=>1));
        $modulehealth = $this->model('appmodule')->getstudentmodule(array('crid'=>$roominfo['crid'],'available'=>1,'modulecode'=>'health','order'=>'displayorder','limit'=>1));
        $moduleforum = $this->model('appmodule')->getstudentmodule(array('crid'=>$roominfo['crid'],'available'=>1,'modulecode'=>'forum','order'=>'displayorder','limit'=>1));*/

        $this->assign('moduleforum',$moduleforum);
		$this->assign('moduleyunpan', $moduleyunpan);
        $this->assign('modulexuanke',$modulexuanke);
        $this->assign('modulehealth',$modulehealth);
        $this->assign('moduleactivity', $moduleactivity);
        $this->assign('moduleeth', $moduleeth);
        $this->assign('moduleselectcourse', $moduleselectcourse);
		$this->assign('room',$roominfo);
		$this->display('aroomv2/more');
	}
	
	public function survey(){
		
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
        $param['untype'] = 3;
		$surveylist = $this->model('survey')->getSurveyList($param);
		$surveycount = $this->model('survey')->getSurveyCount($param);
		//取关联课程名称
		$folderids = array();
		if(!empty($surveylist)){
			foreach ($surveylist as $item){
				if($item['folderid'] >0){
					$folderids[] = $item['folderid'];
				}
			}
			if(!empty($folderids)){
				$param['folderids'] = implode(',', $folderids);
				$foldermodel = $this->model('folder');
				$folders = $foldermodel->getfolderlist($param);
				foreach ($folders as $v){
					$farr[$v['folderid']] = $v['foldername'];
				}
			}	
		}
		$pagestr = show_page($surveycount);
		$this->assign('typearr', array(0=>'网校主页',1=>'学生学习主页',2=>'相关课件页',3=>'选课问卷',4=>'开通服务问卷',5=>'登录前问卷',7=>'无物理位置'));
		$this->assign('fnames', !empty($farr) ? $farr : array());
		$this->assign('pagestr',$pagestr);
		$this->assign('surveylist',$surveylist);
		$this->display('aroomv2/more_survey');
	}

	public function add(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$sid = $this->model('survey')->add(array('crid'=>$roominfo['crid'],'title'=>'请输入标题','uid'=>$user['uid']));
		$url = geturl('aroomv2/survey/edit/'.$sid);
		header("Location: $url");
		exit;
	}
	/**
	 * 保存问卷
	 */
	public function save(){
		$param['sid'] = $this->input->post('sid');
		$param['etype'] = $this->input->post('etype');
		$param['eid'] = $this->input->post('eid');
		$param['content'] = $this->input->post('content');
		//保存前先检查权限(管理员是否对该问卷所属学校有权限)
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->save($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1, 'content' => $param['content']));
			updateRoomCache($roominfo['crid'],'survey');
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}
	}

	public function publish(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['sid'] = $this->input->post('sid');
		$param['type'] = $this->input->post('relatetype');
		$param['allowview'] = $this->input->post('allowview');
		$param['allowanonymous'] = $this->input->post('allowanonymous');
		$param['crid'] = $roominfo['crid'];
		$param['ispublish'] = 1;
		$param['folderid'] = 0;
		$param['cwid'] = 0;
		if($param['type'] == 2){
			$param['folderid'] = $this->input->post('folderid');
			$param['cwid'] = $this->input->post('cwid');
			$survey = $this->model('survey')->getSurveyByCwid($param['cwid'],0);
			if(!empty($survey) && $survey['sid'] != $param['sid']){
				echo '该课下已有问卷,不能继续添加';
				exit;
			}
		}
		$res = $this->model('survey')->edit($param);
		if(false !== $res){
			echo 1;
		}
		else
			echo '发布失败';
	}

	/**
	 * 编辑
	 */
	public function edit_view(){
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);
		//判读改问卷是否是属于当前用户
		if (empty($survey)){
			exit;
		}
		//如果有回答的，删除所有回答,并且重置所有选项计数
		if (!empty($survey['answernum']))
		{
			$this->model('survey')->delanswers(array('sid'=>$survey['sid']));
			$this->model('survey')->resetOptionCount(array('sid'=>$survey['sid']));
		}
		//编辑前将发布状态改为0,回答数改为0
		$this->model('survey')->edit(array('sid'=>$sid,'crid'=>$roominfo['crid'],'ispublish'=>0,'answernum'=>0));

		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($survey['folderid']);
			$relateinfo['folderid'] = $folder['folderid'];
			$relateinfo['foldername'] = $folder['foldername'];

			$cwmodel = $this->model('courseware');
			$cw = $cwmodel->getSimplecourseByCwid($survey['cwid']);
			$relateinfo['cwid'] = $cw['cwid'];
			$relateinfo['title'] = $cw['title'];
		}

		//课程列表
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$param['limit'] = 1000;
		$courselist = $this->model('folder')->getfolderlist($param);

		//编辑器
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor', $editor);

		$this->assign('courselist',$courselist);
		$this->assign('relateinfo',$relateinfo);
		$this->assign('survey', $survey);
		$this->display('aroomv2/survey_edit');
	}

	/**
	 * 预览问卷
	 */
	public function preview_view(){
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);
		$this->assign('survey', $survey);
		$this->display('aroomv2/survey_preview');
	}

	/**
	 * 添加问题
	 */
	public function addquestion(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['sid'] = $this->input->post('sid');
		$param['type'] = $this->input->post('type');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$this->_checkprivilege($param['sid']);
		$new_question = $this->model('survey')->addQuestion($param);
		if ($new_question !== FALSE)
		{
			//添加两个选项
			$new_optionlist = array();
			for ($i=0; $i <2 ; $i++) {
				$new_option = $this->model('survey')->addOption(array('sid' => $new_question['sid'], 'qid' => $new_question['qid']));
				if (!empty($new_option))
				{
					$new_optionlist[] = $new_option;
				}
			}

			echo json_encode(array('status' => 1, 'question' => $new_question, 'optionlist' => $new_optionlist));
			updateRoomCache($roominfo['crid'],'survey');
			exit;
		}

		echo json_encode(array('status' => 0));
		exit;
	}

	public function deletequestion(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['qid'] = $this->input->post('qid');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$question = $this->model('survey')->getOneQuestion($param['qid']);
		$param['sid'] = $question['sid'];
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->deleteQuestion($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			updateRoomCache($roominfo['crid'],'survey');
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 移动问题
	 */
	public function movequestion(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['qid'] = $this->input->post('qid');
		$param['direction'] = $this->input->post('direction');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$question = $this->model('survey')->getOneQuestion($param['qid']);
		$param['sid'] = $question['sid'];
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->moveQuestion($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			updateRoomCache($roominfo['crid'],'survey');
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 添加选项
	 */
	public function addoption(){
		$param['qid'] = $this->input->post('qid');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$question = $this->model('survey')->getOneQuestion($param['qid']);
		$param['sid'] = $question['sid'];
		$this->_checkprivilege($param['sid']);
		$new_option = $this->model('survey')->addOption($param);
		if ($new_option !== FALSE)
		{
			$new_option['type'] = $question['type'];
			echo json_encode(array('status' => 1, 'option' => $new_option));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 删除选项
	 */
	public function deleteoption(){
		$param['sid'] = $this->input->post('sid');
		$param['opid'] = $this->input->post('opid');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->deleteOption($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 移动选项
	 */
	public function moveoption(){
		$param['sid'] = $this->input->post('sid');
		$param['opid'] = $this->input->post('opid');
		$param['direction'] = $this->input->post('direction');
		//添加前先检查权限(管理员是否对该问卷所属学校有权限)
		$this->_checkprivilege($param['sid']);
		$result = $this->model('survey')->moveOption($param);
		if ($result !== FALSE)
		{
			echo json_encode(array('status' => 1));
			exit;
		}
		else
		{
			echo json_encode(array('status' => 0));
			exit;
		}

	}

	/**
	 * 获得问卷回答数
	 */
	function getanswernum(){
		$param['sid'] = $this->input->post('sid');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$survey = $this->model('survey')->getSurveyDetail($param);
		echo empty($survey['answernum']) ? 0 : $survey['answernum'];
	}
	/**
	 * 检查权限(管理员是否对该问卷所属学校是否有权限)
	 * @param  integer $sid 问卷编号
	 */
	public function _checkprivilege($sid) {
		$roominfo = Ebh::app()->room->getcurroom();
		$check = $this->model('survey')->checkEdit(array('sid' => $sid, 'crid' => $roominfo['crid']));
		if ( ! $check)
		{
			echo json_encode(array('status' => 0));
			exit;
		}
	}

	public function delete(){
		$sid = $this->input->post('sid');
		if(!is_numeric($sid))
			return false;
		$roominfo = Ebh::app()->room->getcurroom();
		$smodel = $this->model('survey');
		$res = $smodel->delete(array('sid'=>$sid,'crid'=>$roominfo['crid']));
		if(false != $res) {
			updateRoomCache($roominfo['crid'],'survey');
			echo 1;
		} else
			echo 0;
	}
	
	/*
	选择课件
	*/
	public function box_cw_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		if(in_array($roominfo['crid'],$cridarr['noteacher']))
			$this->assign('needsubfolder',false);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		$queryarr['status'] = 1;
		// $queryarr['uid'] = $user['uid'];
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
        $this->assign('sectionlist', $sectionlist);
        $this->assign('from',1);
        $this->assign('pagestr', $pagestr);
        //分配folderid
        $this->assign('folderid',$folderid);
        //分配教室信息
        $this->assign('roominfo',$roominfo);
        
        $this->display('aroomv2/survey_cwbox');
	}
	
	/*
	统计
	*/
	public function stat_view(){
		$sid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$survey = $this->model('survey')->getOne($sid, $roominfo['crid']);

		//关联信息
		$relateinfo = array();
		if($survey['type'] == 2){
			$cwmodel = $this->model('courseware');
			$cw = $cwmodel->getSimplecourseByCwid($survey['cwid']);
			$relateinfo = array('type'=>'课件','title'=>$cw['title']);
		}

		$this->assign('survey',$survey);
		$this->assign('relateinfo', $relateinfo);
		$this->display('aroomv2/survey_stat');
	}

	//上传图片页面
	public function uploadimage() {
		$upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('upcontrol', $upcontrol);
		$this->display('aroomv2/survey_uploadimage');
	}

    /**
     * 导出问卷调查
     */
    public function export() {
	    $sid = intval($this->input->get('sid'));
	    if ($sid < 1) {
            if(empty($survey)) {
                echo '参数错误';
                exit;
            }
        }
        $roominfo = Ebh::app()->room->getcurroom();
	    $model = $this->model('survey');
        $survey = $model->getOne($sid, $roominfo['crid']);
        if(empty($survey)) {
            echo '导出失败';
            exit;
        }
		if ($survey['type'] == 5) {
			$answerArr = $model->getAnswerWithUserClassInfo($sid, $survey['crid']);
		} else {
			$answerArr = $model->getAnswerWithUserName($sid);
		}
        $optionArr = array();
        $otherOptionArr = array();
        $sumArr = array();

        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            '学生帐号',
            '学生姓名'
        );
		if ($survey['type'] == 5) {
			$titleArr[] = '学生班级';
		}
        foreach ($survey['questionlist'] as $question) {
            $titleArr[$question['qid']] = filterhtml($question['title']);
            if (!isset($question['optionlist'])) {
                continue;
            }
            foreach ($question['optionlist'] as $option) {
                if (!isset($sumArr[$option['qid']])) {
                    $sumArr[$option['qid']] = array(
                        0 => 0,
                        'type' => $question['type']
                    );
                }
                $sumArr[$option['qid']][0] += $option['count'];
                $label = '';
                if (preg_match('/^[A-Z]\./', $option['content'], $m)) {
                    $label = reset($m);
                } else {
                    $label = $option['content'];
                }
                $sumArr[$option['qid']][$label] = $option['count'];
                $option['type'] = $question['type'];
                $optionArr[$option['opid']] = $option;

                if ($question['type'] == 11) {
                    $otherOptionArr[$question['qid']][$option['opid']] = $option['content'];
                }
            }
        }
        array_walk($otherOptionArr, function(&$v) {
            foreach ($v as $opid => $item) {
                if (preg_match('/^[A-Z]\.$/', $item)) {
                    $v = array($opid => $item);
                    break;
                }
            }
        });
        $options_count = count($titleArr) - 1;
        $name = $survey['title'];
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $startW = 'A';
        for($i = 0; $i < $options_count; $i++) {
            $startW++;
            $objPHPExcel->getActiveSheet()->getColumnDimension($startW)->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->mergeCells("A1:{$startW}1");


        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);

        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';//列A1,B1,C1,D1
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);

                //$pt->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置列填充模式 solid
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                //$pt->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//设置列边宽
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }
        //传值
        if(is_array($answerArr)){
            foreach ($answerArr as $index => $row) {
                $answer = unserialize($row['answers']);
                if ($answer === false) {
                    continue;
                }
                $str = "A";
                foreach ($titleArr as $column_index => $column) {
                    $p = $str . ($index + 3);
                    if ($column_index == 0) {
                        //$objPHPExcel->getActiveSheet()->setCellValue($p, $row['username']);
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit($p, $row['username'], PHPExcel_Cell_DataType::TYPE_STRING);
                        $str++;
                        continue;
                    }
                    if ($column_index == 1) {
                        $objPHPExcel->getActiveSheet()->setCellValueExplicit($p, $row['realname'], PHPExcel_Cell_DataType::TYPE_STRING);
                        $str++;
                        continue;
                    }
					if ($column_index == 2 && $survey['type'] == 5) {
						$objPHPExcel->getActiveSheet()->setCellValueExplicit($p, $row['classname'], PHPExcel_Cell_DataType::TYPE_STRING);
						$str++;
						continue;
					} 
                    //$objPHPExcel->getActiveSheet()->setCellValue($p, $answer[$column_index]);
                    $questionAnswer = $answer[$column_index];
                    if (!is_array($questionAnswer)) {
                        if (isset($otherOptionArr[$column_index])) {
                            $ov = reset($otherOptionArr[$column_index]);
                            $a = $ov . '其他 '. $questionAnswer;
                        } else {
                            $a = $questionAnswer;
                        }

                    } else {
                        $a = '';
                        foreach ($questionAnswer as $qitem) {
                            $a .= $optionArr[$qitem]['content'];
                        }
                    }
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit($p, $a, PHPExcel_Cell_DataType::TYPE_STRING);
                    $str++;
                }
            }
            $index++;
            $str = "A";
            foreach ($titleArr as $column_index => $column) {
                $p = $str . ($index + 3);
                if ($column_index == 0) {
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit($p, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $str++;
                    continue;
                }
                if ($column_index == 1) {
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit($p, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $str++;
                    continue;
                }
                if (isset($sumArr[$column_index]['type'])) {
                    if ($sumArr[$column_index]['type'] != 3 && $sumArr[$column_index]['type'] != 113) {
                        $arr = array();
                        $sp = 0;
                        $lk = '';
                        foreach ($sumArr[$column_index] as $sk => $sumItem) {
                            if ($sk === 0 || $sk == 'type') {
                                continue;
                            }
                            $percentage = $sumItem == 0 ? 0 : round($sumItem / $sumArr[$column_index][0], 2) * 100;
                            $percentage = intval($percentage);
                            $sp += $percentage;
                            if ($percentage > 0) {
                                $lk = $sk;
                            }
                            $arr[$sk] = $percentage;
                        }
                        $arr[$lk] = 100 - $sp + $arr[$lk];
                        $subIndex = 0;
                        foreach ($arr as $ak => $ar) {
                            $p = $str . ($index + $subIndex + 3);
                            $objPHPExcel->getActiveSheet()->setCellValueExplicit($p, $ar.'% - '.$ak, PHPExcel_Cell_DataType::TYPE_STRING);
                            $objPHPExcel->getActiveSheet()->getStyle($p)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle($p)->getFill()->getStartColor()->setARGB('FFCAE8EA');
                            $subIndex++;
                        }
                    }
                }
                $str++;
            }
        }
        //print_r($sumArr);exit;
        // 输出下载文件 到浏览器
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }
}
