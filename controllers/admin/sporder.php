<?php
/*
服务订单
*/
class SporderController extends AdminControl{

	public function index(){
		$this->display('admin/servicepack_orderlist');
	}
	
	
	public function getListAjax(){
		$query = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$queryArr['q'] = $query;
		$status = $this->input->post('status');
		if($status!='')
			$queryArr['status'] = $this->input->post('status');
		$payfrom = $this->input->post('payfrom');
		if($payfrom!='')
			$queryArr['payfrom'] = $this->input->post('payfrom');
		$crid = $this->input->post('crid');
		if($crid!='')
			$queryArr['crid'] = $this->input->post('crid');
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$needtype = $this->input->post('needtype');
		$queryArr['needtype'] = empty($needtype)?0:$needtype;
		$list = $this->model('Payorder')->getOrderList($queryArr);
		$total = $this->model('Payorder')->getOrderCount($queryArr);
		if (!empty($list)) {
			$today = strtotime('today')+86400;
			$cridstr = '';
			foreach ($list as $value) {
				$cridArr[$value['crid']] = 1;
			}
			$cridstr = implode(',', array_unique(array_keys($cridArr)));
			//获取冻结的天数
            $freezeDayInfos = Ebh::app()->getDb()->query('SELECT crid,fund_freezn FROM ebh_freezn_times WHERE crid IN('.$cridstr.') ORDER BY fid ASC')->list_array();
            if (!empty($freezeDayInfos)) {
                foreach ($freezeDayInfos as $fvalue) {
                    $freeze_crid[$fvalue['crid']] = $fvalue['fund_freezn'];
                }
            }

            //获取时间符合有需要解冻的用户
            foreach ($list as &$avalue) {
                $frozeDay = empty($freeze_crid[$avalue['crid']])?15:$freeze_crid[$avalue['crid']];//某用户的冻结天数
                if (($today - $frozeDay*86400) > $avalue['paytime']) {//解冻了15天后
                    $avalue['refund'] = 1;//不能退了
                } else {
                	$avalue['refund'] = 0;
                }
            }
		}
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	
	public function del(){
		// $ppmodel = $this->model('PayPackage');
		// $pid = $this->input->post('pid');
		// echo json_encode(array('success'=>$ppmodel->deletepack($pid)));
	}
	
	public function add(){
		if($this->input->post()){
			
		}else{
			$this->display('admin/servicepack_orderadd');
		}
	}
	
	public function edit(){
		$pomodel = $this->model('Payorder');
		if($this->input->post()){
			$user = Ebh::app()->user->getloginuser();
			$param['pid'] = $this->input->post('pid');
			$param['pname'] = $this->input->post('pname');
			$param['crid'] = $this->input->post('crid');
			$param['summary'] = $this->input->post('summary');
			$param['uid'] = $user['uid'];
			$res = $pomodel->edit($param);
			$returnurl = '/admin/servicepack.html';
			if(isset($res))
				$this->goback('修改成功!',$returnurl);
			else
				$this->goback('修改失败!',$returnurl);
		}else{
			$orderid = $this->input->get('orderid');
			$orderdetail = $pomodel->getOrderByOrderid($orderid);
			$this->assign('orderdetail',$orderdetail);
			$this->display('admin/servicepack_orderedit');
		}
	}
	
	public function getServicePackList(){
		$param = $this->input->post();
		$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
		$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
		$offset = max(0,($pageNumber-1)*$pageSize);
		parse_str($param['query'],$queryArr);
		$queryArr['limit'] = $offset.','.$pageSize;
		$ppmodel = $this->model('PayPackage');
		$total = $ppmodel->getspcount($queryArr);
		$spList = $ppmodel->getsplist($queryArr);
		array_unshift($spList,array('total'=>$total));
		echo json_encode($spList);
	}
	
	public function goback($note="操作成功,正在努力跳转中...",$returnurl="/admin/servicepack.html"){
		$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
		exit;
	}

	/**
	 * 订单详情
	 * 
	 */
	public function view(){
		$orderid = $this->uri->itemid;
		if($orderid<=0||!is_numeric($orderid)){
			exit();
		}
		$payorderModel = $this->model('payorder');
		$order = $payorderModel->getOrderDetailById($orderid);
		$this->assign("order",$order);
		$this->display('admin/orderview');
	}
	/**
	*批量开通
	*/
	public function input(){
	
	if($this->input->post()){
			set_time_limit(0);
			ini_set('memory_limit', '200M');
			Ebh::app()->getDb()->set_con(0);
		$errormsg = '';
		$inputresult = array('result'=>false,'hasresult'=>false,'errormsg'=>$errormsg);
		$crid = intval($this->input->post('crid'));
		$payfrom = intval($this->input->post('payfrom'));
		$roommodel = $this->model('Classroom');
		$roominfo = $roommodel->getdetailclassroom($crid);
		if(empty($roominfo) || $crid <= 0 || $payfrom <= 0) {
			$errormsg = '错误：请选择所属网校和开通方式';
		} else if(empty($_FILES) || empty($_FILES['inputfile']) || empty($_FILES['inputfile']['tmp_name'])) {
			$errormsg = '错误：请选择要上传的文件';
		} else if(is_uploaded_file($_FILES['inputfile']['tmp_name']) && $this->checkupload($_FILES['inputfile'])) {
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$up_type = 'temp';
			$destination_folder="/uploads/";
			if(!empty($_UP[$up_type]['savepath'])){
				$destination_folder = $_UP[$up_type]['savepath'];
			}
			$dest_path  = $this->getdirurl($destination_folder);	
			$path_info = pathinfo($_FILES['inputfile']['name']);
			$file_extension = $path_info["extension"];
			$tmpname = time().'_'.mt_rand().'.'.$file_extension;
			$filesavepath = $destination_folder.$dest_path.$tmpname;
			if(move_uploaded_file($_FILES['inputfile']["tmp_name"], $filesavepath)) {
				$iresult = $this->inputBatch($filesavepath,$roominfo['crid'],$payfrom);
				if(!empty($iresult['errormsg']) || !empty($iresult['erroritems'])) {	//导入不成功
					$inputresult['result'] = false;
					$inputresult['hasresult'] = true;
					$errormsg = empty($iresult['errormsg'])?'':$iresult['errormsg'];
					$inputresult['erroritems'] = empty($iresult['erroritems'])?'':$iresult['erroritems'];
				} else {
					$inputresult['result'] = true;
					$inputresult['hasresult'] = true;
					$inputresult['rowcount'] = $iresult['rowcount'];
				}
			}
		} else {
			$errormsg = '错误：只允许上传xls格式文件，且文件小于5M';
		}
		// $_SGLOBAL['tpl_folder'] = 'aroom';
		$inputresult['errormsg'] = $errormsg;

		/**写日志开始**/

		$message = '批量开通：'.json_encode($inputresult);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$roominfo['crid'],
				'message'=>$message,
				'opid'=>1,
				'type'=>'open'
				)
		);
		/**写日志结束**/

		$this->assign('inputresult',$inputresult);
		}
		$this->display('admin/batch_open');
	}
	private function inputBatch($filepath,$crid,$payfrom) {
//		$crid = 10194;	//需要导入的crid
//		$filepath = '/data0/uploads/1.xls';	//需要处理的excel
		$result = array('result'=>false);
		
		$reader = Ebh::app()->lib('PhpExcelReader');
		
		$reader->setOutputEncoding('UTF-8');
		$r = $reader->read($filepath);
		if($r === false) {	//不支持的文件格式
			$result['errormsg'] = '不支持的文件格式';
			return $result;
		}
		$rowcount = 0;	//导入行数
		$titlerownum = 0;
	//	姓名	登录账号	性别	班级 开通至需要登录账号和开通课程字段
		//$realnamecol = 0;
		$usernamecol = 0;
		$foldercol = 0;
		//$sexcol = 0;
		//$classcol = 0;
		for ($i = 1; $i <= $reader->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $reader->sheets[0]['numCols']; $j++) {	//找到标题行
				$colval = trim($reader->sheets[0]['cells'][$i][$j]);
				$colval = str_replace(' ','',$colval);
				if($colval == '登录账号') {
					$usernamecol = $j;
				} else if($colval == '开通课程') {
					$foldercol = $j;
				}
			}
			if(!empty($usernamecol) && !empty($foldercol)) {	//找到标题行
				$titlerownum = $i;
				break;
			}
		}
		if($titlerownum == 0) {
			$result['errormsg'] = '文件内容不正确，请按照系统提供的导入模板格式进行上传。必须包含带有 登录账号/开通课程 字段的标题行。';
			return $result;
		}
		$classes = $this->model('classes');
		$classlist = $classes->getRoomClassList($crid);
		if(empty($classlist)) {
			$result['errormsg'] = '您还没有创建任何班级，请先添加班级。';
			return $result;
		}
		$classnamelist = array();
		$userlist = array();
		foreach($classlist as $myclass) {
			$classnamelist[$myclass['classname']] = $myclass;
		}
		$usernameinlist = '';
		
		if($usernamecol == 0)
			$usernamecol_err = 1;
		if($foldercol == 0)
			$foldercol_err = 1;
		for ($i = $titlerownum + 1; $i <= $reader->sheets[0]['numRows']; $i++) {
		    if (empty($reader->sheets[0]['cells'][$i][$usernamecol]) && empty($reader->sheets[0]['cells'][$i][$foldercol])) {
		        continue;
            }
			$username = empty($usernamecol_err)?$reader->sheets[0]['cells'][$i][$usernamecol]:'';
			$username = trim($username);
			$folders = empty($foldercol_err)?$reader->sheets[0]['cells'][$i][$foldercol]:'';
			$folders = trim($folders);
			if(empty($username) && empty($folders)) {	//这些字段为空 则认为是空行
				continue;
			}
			if(empty($username) || empty($folders)) {
				$result['errormsg'] = '第 '.$i.' 行 内容不完整，登录账号、开通课程不能为空，请修改文件后重新上传';
				break;
			}
			if(strlen($username) > 20) {
				$result['errormsg'] = '第 '.$i.' 行 登录账号太长，请调整。';
				break;
			}
			if(!preg_match('/^[a-z0-9A-Z_]{6,20}$/',$username)) {
				$result['errormsg'] = '第 '.$i.' 行登录账号格式不正确，登录账号只能为6-20位英文、数字的组合字符，请调整。';
				break;
			}
			$username = str_replace('\'','',$username);
			if (isset($userlist[$username])) {
				$preuser = $userlist[$username];
				$prerow = $preuser['rownum'];
				$result['errormsg'] = '第 '.$prerow.' 与 '.$i.' 行 登录账号重复，请调整。';
				break;
			}
			if(empty($usernameinlist))
				$usernameinlist = '\''.$username.'\'';
			else
				$usernameinlist .= ','. '\''.$username.'\'';
			$userlist[$username] = array('rownum'=>$i,'username'=>$username,'folders'=>$folders);
			$rowcount ++;
		}
		if (!empty($result['errormsg'])) {
			return $result;
		}
		if (empty($usernameinlist)) {
			$result['errormsg'] = '读取文件过程出错，若文件记录数过大，您可以将文件分拆后再上传。';
			return $result;
		}
		$user = $this->model('user');
		$usernamearr = $user->getuserlistbyusername($usernameinlist);
		//将数据库中查出来的uid放到excel对应的用户中 用于验证excel的用户是否已经导入到系统中
		foreach($usernamearr as $uname) {	
			if(isset($userlist[$uname['username']])) {
//				$nameitem = $userlist[$uname['username']];
//				$nameitem['uid'] = $uname['uid'];
				$userlist[$uname['username']]['uid'] = $uname['uid'];
			}
		}
		//如果excel用户列表中不存在uid 则表示excel中有用户不存在
		$hasnouser = false;
		$foldernamelist = array();	//开通的课程名称数组（去重）
		
		foreach($userlist as $uname) {
			if(empty($uname['uid'])) {
				$result['erroritems'][] = '第 '.$userlist[$uname['username']]['rownum'].' 行 账号 '.$uname['username'].' 不存在';
				$hasnouser = true;
			}
			//将所有开通的课程数据去重后放到 $foldernamelist 数组
			$foldernamestr = $uname['folders'];
			$foldernamearr = explode(',',$foldernamestr);
			foreach($foldernamearr as $fname) {
				if(!isset($foldernamelist[$fname]))
					$foldernamelist[$fname] = array('foldername'=>$fname);
			}
		}
		if($hasnouser) {
			return $result;
		}
		
//		if(!empty($usernamearr)) {	//重复账号判断
//			$result['erroritems'] = array();
//			foreach($usernamearr as $uname) {
//				if(isset($userlist[$uname['username']])) {
//					$result['erroritems'][] = '第 '.$userlist[$uname['username']]['rownum'].' 行 账号 '.$uname['username'].' 已存在';
//				}
//			}
//			return $result;
//		}
		//判断开通课程是否都已在服务项中
		$foldernameinstr = '';
		foreach($foldernamelist as $foldername) {
			if(empty($foldernameinstr)) {
				$foldernameinstr = '\''.$foldername['foldername'].'\'';
			} else {
				$foldernameinstr .= ',\''.$foldername['foldername'].'\'';
			}
		}
		$pitemmodel = $this->model('Payitem');
		$folderparam = array('crid'=>$crid,'folders'=>$foldernameinstr,'cannotpay'=>0);
		$itemlist = $pitemmodel->getItemListByFoldernames($folderparam);
		if(empty($itemlist)) {	//课程都未开设
			$result['errormsg'] = '请确认开通的课程都已经开设并且设置了服务项。';
			return $result;
		}
		foreach($itemlist as $item) {
			if(isset($foldernamelist[$item['iname']])) {
				$foldernamelist[$item['iname']] = $item;
			}
		}
		//有部分课程未开通判断
		$hasnofolder = false;
		$result['erroritems'] = array();
		foreach($foldernamelist as $myfolder) {
			if(empty($myfolder['itemid'])) {
				$result['erroritems'][] = '课程：'.$myfolder['foldername'].' 还未开设课程或服务项';
				$hasnofolder = true;
			}
		}
		if($hasnofolder) {
			return $result;
		}

		//生成所有开通信息
		$orderlist = array();	//一个用户每条excel行一个订单，如果里面包含多个课程，则作为订单明细处理
		foreach($userlist as $myuser) {
			$order = array('uid'=>$myuser['uid'],'payfrom'=>$payfrom,'type'=>$payfrom,'itemidlist'=>array());
			$folders = $myuser['folders'];
			$folderlist = explode(',',$folders);
			foreach($folderlist as $folder) {
				if(isset($foldernamelist[$folder])) {
					$order['itemidlist'][] = $foldernamelist[$folder]['itemid'];
				}
			}
			$orderlist[] = $order;
		}
//		var_dump($orderlist);
		//处理所有开通信息
		Ebh::app()->getDb()->set_con(0);	//设置读写都为主数据库服务器
		//开启事务
		$db = Ebh::app()->getDb();
		$db->begin_trans();
		$haserror = FALSE;
		foreach($orderlist as $myorder) {
			$openresult = Ebh::app()->runAction('admin/ibuy','input',$myorder);
			if(empty($openresult)) {
				$haserror = TRUE;
				break;
			}
		}
		if ($db->trans_status() === FALSE || $haserror) {
            $db->rollback_trans();
            $result['errormsg'] = '批量开通时出错，请联系管理员。';
			return $result;
        } else {
            $db->commit_trans();
        }
		$result['rowcount'] = $rowcount;
		//生成数据
		return $result;
	}
	/**
	*检测导入的excel文件内容是否合法
	*/
	function checkupload($up) {
		$MAX_FILENAME_LENGTH = 260;
		$max_file_size_in_bytes = 5242880;				// 5M
		$allow_extensions = array('xls'); //only allow excel file extension
		$valid_chars_regex = '.A-Z0-9_-';				// file name allow characters
		
		if (empty($up)) {
			return false;
		} else if (isset($up["error"]) && $up["error"] != 0) {
			return false;
		} else if (!isset($up["tmp_name"]) || !@is_uploaded_file($up["tmp_name"])) {
			return false;
		} else if (!isset($up['name'])) {
			return false;
		}
		$file_size = @filesize($up["tmp_name"]);
		if (!$file_size)
			$file_size = 128;
		if (!$file_size || $file_size > $max_file_size_in_bytes) {
			return false;
		}
		if ($file_size <= 0) {
			return false;
		}
		$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($up['name']));
		if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
			return false;
		}
		$path_info = pathinfo($up['name']);
		$file_extension = $path_info["extension"];
		if(!in_array($file_extension,$allow_extensions))
			return false;
		return true;
	}
	/*
	 * 获取存储附件路径
	 */
	function getdirurl($dest_folder = '') {
		$timestamp=time();
		$destination_folder=empty($dest_folder)?("/uploads/"):$dest_folder;
	//以天存档
		$yearpath=Date('Y', $timestamp)."/";
		$monthpath=$yearpath.Date('m', $timestamp)."/";
		$dayspath = $monthpath.Date('d', $timestamp)."/";
		if(!file_exists($destination_folder))
		mkdir($destination_folder);
		if(!file_exists($destination_folder.$yearpath))
		mkdir($destination_folder.$yearpath);
		if(!file_exists($destination_folder.$monthpath))
		mkdir($destination_folder.$monthpath);
		if(!file_exists($destination_folder.$dayspath))
		mkdir($destination_folder.$dayspath);
		return  ltrim($dayspath,'.');
		
	}

    /**
     * 批量删除
     */
	function btachremove() {
	    if ($this->input->post()) {
            set_time_limit(0);
            ini_set('memory_limit', '200M');
	        $crid = intval($this->input->post('crid'));
	        $msgs = array();
	        if ($crid < 1) {
                $msgs[] = '请选择所属网校';
            }
            if (empty($_FILES) || empty($_FILES['inputfile']) || empty($_FILES['inputfile']['tmp_name']) || $_FILES['inputfile']['error'] > 0) {
                $msgs[] = '请选择要上传的文件';
            }

	        if (empty($msgs)) {
	            $datas = $this->getDataFromExcel($_FILES['inputfile']['tmp_name'], array('登录账号' => 0, '删除课程' => 1));
	            if (is_scalar($datas)) {
                    $inputresult['errormsg'] = '错误：'.$datas;
                } else {
                    $inputresult = $this->removePermisions($datas, $crid);
                }
            } else {
                $inputresult['errormsg'] = '错误：'.implode('；', $msgs);
            }
            $this->assign('inputresult',$inputresult);
        }
        $this->display('admin/batch_remove');
    }

    /**
     * @param string $filepath 文件路径
     * @param array $templates 导入模块格式，例子：
     * array(
        字段 => 返回数组数据中的索引
     * )
     * @return array|string
     */
    private function getDataFromExcel($filepath, $templates) {
        $reader = Ebh::app()->lib('PhpExcelReader');
        $reader->setOutputEncoding('UTF-8');
        $r = $reader->read($filepath);
        if($r === false) {	//不支持的文件格式
            return '不支持的文件格式';
        }
        $rowNumber = isset($reader->sheets[0]['numRows']) ? $reader->sheets[0]['numRows'] : 0;
        $colNumber = isset($reader->sheets[0]['numCols']) ? $reader->sheets[0]['numCols'] : 0;
        if ($rowNumber == 0 || $colNumber == 0) {
            return '文件为空或文件不支持';
        }
        $start = 0;
        $templates = array_map(function($template) {
            return array(
                'index' => $template,
                'colIndex' => 0
            );
        }, $templates);
        for ($rowIndex = 1; $rowIndex <= $rowNumber; $rowIndex++) {
            $titles = $templates;
            for ($colIndex = 1; $colIndex <= $colNumber; $colIndex++) {
                if (!isset($reader->sheets[0]['cells'][$rowIndex][$colIndex])) {
                    break;
                }
                $cellValue = preg_replace('/[\s　]/', '', $reader->sheets[0]['cells'][$rowIndex][$colIndex]);
                if (isset($titles[$cellValue])) {
                    $titles[$cellValue]['colIndex'] = $colIndex;
                }
            }
            $notitles = array_filter($titles, function($title) {
                return $title['colIndex'] == 0;
            });
            if (empty($notitles)) {
                $start = $rowIndex + 1;
                break;
            }
        }
        if ($start == 0) {
            return '文件不合规格';
        }
        for ($rowIndex = $start; $rowIndex <= $rowNumber; $rowIndex++) {
            $row = array();
            foreach ($titles as $title => $col) {
                $colIndex = $col['colIndex'];
                if (!isset($reader->sheets[0]['cells'][$rowIndex][$colIndex])) {
                    $row[$title] = '';
                    continue;
                }
                $cellValue = preg_replace('/\s/', '', $reader->sheets[0]['cells'][$rowIndex][$colIndex]);
                $row[$title] = $cellValue;
            }
            $notemptys = array_filter($row, function($rowitem) {
               return $rowitem != '';
            });
            if (!empty($notemptys)) {
                $row['rowIndex'] = $rowIndex;
                $result[] = $row;
            }
        }
        return $result;
    }

    /**
     * 删除学生课程权限，增加删除订单记录
     * @param array $datas 导入数据
     * @param int $crid 网校ID
     * @return array
     */
    private function removePermisions($datas, $crid) {
        $inputresult = array();
        $repeats = array();
	    foreach ($datas as $index => $data) {
	        if ($data['登录账号'] == '') {
                $inputresult['erroritems'][] = '第'.$data['rowIndex'].'行“登录账号”为空';
            }
            if ($data['删除课程'] == '') {
                $inputresult['erroritems'][] = '第'.$data['rowIndex'].'行“开通课程”为空';
            }
            $datas[$index]['删除课程'] = str_replace('，', ',', $data['删除课程']);
            $repeats[$data['登录账号']][] = $data['rowIndex'];
            continue;
        }
        $repeats = array_filter($repeats, function($repeat) {
            return count($repeat) > 1;
        });
	    if (!empty($repeats)) {
            foreach ($repeats as $repeat) {
                $inputresult['erroritems'][] = '第'.implode(',', $repeat).'行登录帐号重复';
            }
        }
        if (!empty($inputresult['erroritems'])) {
            $inputresult['errormsg'] = '导入数据错误';
            $inputresult['hasresult'] = true;
            return $inputresult;
        }
        $courses = array_column($datas, '删除课程');
	    $courses = implode(',', $courses);
	    $courses = explode(',', $courses);
	    $courses = array_unique($courses);
	    $courses = array_filter($courses, function($course) {
	       return !empty($course);
        });
	    $usernames = array_column($datas, '登录账号');
	    $usernames = array_unique($usernames);
        Ebh::app()->getDb()->set_con(0);
        $folderModel = $this->model('folder');
        $roomUserModel = $this->model('roomuser');
        $userPermissionModel = $this->model('userpermission');
        $classroomModel = $this->model('classroom');
        $payOrderModel = $this->model('payorder');
        $classroom = $classroomModel->getdetailclassroommulti($crid);
        $classroom = reset($classroom);
        $folders = $folderModel->getFoldersForNames($courses, $crid);
        $foldernames = array_column($folders, 'foldername');
        $courses = array_diff($courses, $foldernames);
        if (!empty($courses)) {
            $inputresult['errormsg'] = '导入数据错误';
            $inputresult['hasresult'] = true;
            foreach ($courses as $course) {
                $inputresult['erroritems'][] = '课程“'.$course.'”不存在';
            }
        }
        $users = $roomUserModel->getUsersFromNames($usernames, $crid);
        $usernames = array_diff($usernames, array_column($users, 'username'));

        if (!empty($usernames)) {
            $inputresult['errormsg'] = '导入数据错误';
            $inputresult['hasresult'] = true;
            foreach ($usernames as $username) {
                $inputresult['erroritems'][] = '用户“'.$username.'”不存在';
            }
        }
        if (!empty($inputresult)) {
            return $inputresult;
        }
        $folders = array_combine(array_column($folders, 'foldername'), $folders);
        $users = array_combine(array_column($users, 'username'), $users);
        array_walk($datas, function(&$data, $index, $args) {
            $data['uid'] = $args['users'][$data['登录账号']]['uid'];
            $courses = explode(',', $data['删除课程']);
            $data['folderids'] = array();
            foreach ($courses as $course) {
                if (isset($args['folders'][$course])) {
                    $data['folderids'][] = $args['folders'][$course]['folderid'];
                }
            }
        }, array(
            'users' => $users,
            'folders' => $folders
        ));
        $now = SYSTIME;
        $ip = $this->input->getip();
        $crname = $classroom['crname'];
        $orders = array_map(function($data) use($crid, $now, $ip, $crname) {
            $ret = array(
                'ordername' => '删除“'.$data['登录账号'].'”在“'.$crname.'”网校的服务',
                'crid' => $crid,
                'uid' => $data['uid'],
                'dateline' => $now,
                'paytime' => $now,
                'payfrom' => 11,
                'ip' => $ip,
                'payip' => $ip,
                'buyer_info' => $data['登录账号'],
                'status' => 1,
                'itemlist' => array()
            );
            $folders = explode(',', $data['删除课程']);
            foreach ($data['folderids'] as $idx => $folderid) {
                $ret['itemlist'][] = array(
                    'folderid' => $folderid,
                    'crid' => $crid,
                    'uid' => $data['uid'],
                    'oname' => $folders[$idx],
                    'osummary' => '删除“'.$data['登录账号'].'”在“'.$crname.'”网校的“'.$folders[$idx].'”课程权限',
                    'dstatus' => 1
                );
            }
            return $ret;
        }, $datas);
        //生成删除记录
        $rowcount = 0;
        foreach ($orders as &$order) {
            $detailCount = 0;
            foreach ($order['itemlist'] as $indx => $detail) {
                $d = $userPermissionModel->deletePermissionByFolderidsForUsers(array($detail['folderid']), array($order['uid']), $crid);
                if ($d > 0) {
                    $detailCount++;
                } else {
                    unset($order['itemlist'][$indx]);
                }
            }
            if ($detailCount > 0) {
                $foldernames = array_column($order['itemlist'], 'oname');
                $foldernames = implode('，', $foldernames);
                $order['remark'] = '删除“'.$order['buyer_info'].'”在“'.$crname.'”网校的“'.$foldernames.'”课程权限';
                $payOrderModel->addOrder($order);
                $rowcount++;
            }
        }
        $inputresult['result'] = true;
        $inputresult['hasresult'] = true;
        $inputresult['rowcount'] = intval($rowcount);
        return $inputresult;
    }
}