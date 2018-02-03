<?php
/*
分销管理
*/
class ShareController extends ARoomV3Controller{
	/*
	通用设置
	*/
	public function setting(){
	    $param = array();
		$post = $this->input->post();
		if(isset($post['isshare'])){
			$param['isshare'] = $post['isshare'];
		}
		if(isset($post['sharepercent'])){
			$param['sharepercent'] = $post['sharepercent'];
		}
		if(!isset($param)){
			$this->renderjson(1,'参数错误');
		}
		$param['crid'] = $this->roominfo['crid'];
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Share.upSettings')->addParams($param)->request();
		if($res !== FALSE){
			$logarr['toid'] = $param['crid'];
			if(isset($param['isshare'])){
				$logarr['changestatus'] = $param['isshare'] == 0?'关闭':'开启';
				Ebh::app()->lib('OperationLog')->addLog($logarr,'changeisshare');//操作成功记录到操作日志
			} elseif(isset($param['sharepercent'])){
				$logarr['sharepercent'] = $param['sharepercent'];
				Ebh::app()->lib('OperationLog')->addLog($logarr,'setsharepercent');//操作成功记录到操作日志
			}
			$this->renderjson(0,'成功');
		} else {
			$this->renderjson(1,'失败');
		}
	}

    /*
    获取通用设置
    */
    public function getSetting(){
        $param = array();
        $param['crid'] = $this->roominfo['crid'];
        if(empty($param['crid'])){
            $this->renderjson(1,'参数错误');
        }
        $res = $this->apiServer->reSetting()->setService('Aroomv3.Share.getSettings')->addParams($param)->request();
        $this->renderjson(0,'',$res);
    }

	/*
	添加用户设置,多人
	*/
	public function addUserSetting(){
        $param = array();
		$uids = $this->input->post('uids');
		$param['crid'] = $this->roominfo['crid'];
		$param['percent'] = $this->input->post('percent');
		if(!empty($uids) && is_array($uids)){
			foreach($uids as $uid){
				if(!is_numeric($uid)){
					$this->renderjson(1,'参数错误');
				}
			}
			$param['uids'] = $uids;
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Share.addUserPercent')->addParams($param)->request();
			if($res != FALSE){
                $this->renderjson(0,'成功',array(),false);
                fastcgi_finish_request();	//操作成功，则直接返回前端输出
                $logarr = array();
                $lastuid = end($uids);
                $logarr['toid'] = intval($lastuid);
                $logarr['uids'] = $uids;
                $logarr['count'] = $res;
                $logarr['percent'] = intval($param['percent']);
                if(isset($logarr['percent']) && !empty($logarr['toid'])){
                    Ebh::app()->lib('OperationLog')->addLog($logarr,'addusershare');//操作成功记录到操作日志
                }
            } else {
				$this->renderjson(1,'失败');
			}
		} else {
			$this->renderjson(1,'参数错误');
		}
	}
	
	/*
	编辑用户设置,单人
	*/
	public function editUserSetting(){
        $param = array();
        $did = $this->input->post('did');
		$param['percent'] = $this->input->post('percent');
		if(!empty($did) && isset($param['percent'])){
			if(!is_numeric($did)){
				$this->renderjson(1,'参数错误');
			}
			$param['did'] = $did;
            $userpencent = $this->getusersetting($did);
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Share.editUserPercent')->addParams($param)->request();
			if($res !== FALSE){
                $this->renderjson(0,'成功',array(),false);
                fastcgi_finish_request();	//操作成功，则直接返回前端输出
                $logarr = array();
                $logarr['newpercent'] = $param['percent'];
                if(isset($userpencent['percent']) && !empty($userpencent['uid'])){
                    $logarr['oldpercent'] = $userpencent['percent'];
                    $logarr['toid'] = $userpencent['uid'];
                }
                if(isset($logarr['newpercent']) && isset($logarr['oldpercent'])){
                    Ebh::app()->lib('OperationLog')->addLog($logarr,'editusershare');//操作成功记录到操作日志
                }
			} else {
				$this->renderjson(1,'失败');
			}
		} 
	}
	/**
	*删除用户设置,单人
	*/
	public function delusersetting(){
        $param = array();
		$did = $this->input->post('did');
		if(!empty($did)){
			if(!is_numeric($did)){
				$this->renderjson(1,'参数错误');
			}
			$param['did'] = $did;
            $userpencent = $this->getusersetting($did);
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Share.delUserPercent')->addParams($param)->request();
			if($res !== FALSE){
                $this->renderjson(0,'删除成功',array(),false);
                fastcgi_finish_request();	//操作成功，则直接返回前端输出
                if(isset($userpencent['percent']) && !empty($userpencent['uid'])){
                    $logarr = array();
                    $logarr['toid'] = $userpencent['uid'];
                    $logarr['percent'] = $userpencent['percent'];
                    Ebh::app()->lib('OperationLog')->addLog($logarr,'delusershare');//操作成功记录到操作日志
                }
			} else {
				$this->renderjson(1,'删除失败');
			}
		}
	}

    /**
     *获取网校用户分销比列表
     */
	public function getpercentlist(){
	    $param =array();
	    $get = $this->input->get();
        $param['crid'] = $this->roominfo['crid'];
        if(empty($param['crid'])){
            $this->renderjson(1,'参数错误');
        }
        $param['pagesize'] = !empty($get['pagesize']) ? intval($get['pagesize']) :20;
        $param['page'] = !empty($get['page']) ? intval($get['page']) :0;
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Share.getPercentList')->addParams($param)->request();
		$this->renderjson(0,'',$res);
	}

    /**
     *获取用户设置,单人
     */
    private function getusersetting($did){
        if(empty($did) && !is_numeric($did)){
            $this->renderjson(1,'参数错误');
        }
        return $this->apiServer->reSetting()->setService('Aroomv3.Share.getOnePercent')->addParams(array('did'=>$did))->request();
    }

    /**
     * 读取教师列表
     */
    public function teacherlists(){
        $param = array();
        $param['crid'] = $this->roominfo['crid'];
        if(empty($param['crid'])){
            $this->renderjson(1,'参数错误');
        }
        $pageArr = $this->getPageInfo();
        $param['pagesize'] = !empty($pageArr['pagesize']) ? intval($pageArr['pagesize']) : 50;
        $param['page'] = !empty($pageArr['pagenum']) ? intval($pageArr['pagenum']) : 0;
        $q = $this->input->get('q');
        if(isset($q)){
            $param['q'] = $q;
        }
        $teacher = $this->apiServer->reSetting()->setService('Aroomv3.Teacher.list')->addParams($param)->request();
        $percent = $this->apiServer->reSetting()->setService('Aroomv3.Share.getPercentList')
            ->addParams(array('crid'=>$param['crid'],'page'=>$param['page'],'pagesize'=>$param['pagesize']))
            ->request();
        $uids = array();
        if(!empty($percent['percentlist']) && is_array($percent['percentlist'])){
            $uids = array_column($percent['percentlist'],'uid');
        }
        if(!empty($teacher['list']) && is_array($teacher['list'])){
            foreach ($teacher['list'] as &$tearr){
                if(!empty($uids) && is_array($uids) && in_array($tearr['uid'],$uids)){
                    $tearr['selected'] = 1;
                }else{
                    $tearr['selected'] = 0;
                }
                if(!empty($this->roominfo['uid']) && ($this->roominfo['uid']==$tearr['uid'])){
                    $tearr['selected'] = 2;//网校管理员
                }
            }
        }
        $teacher = !empty($teacher) ? $teacher : array();
        $this->renderjson(0,'',$teacher);
    }
    /**
     * 读取学生列表
     */
    public function studentlists(){
        $param = array();
        $param['crid'] = $this->roominfo['crid'];
        if(empty($param['crid'])){
            $this->renderjson(1,'参数错误');
        }
        $pageArr = $this->getPageInfo();
        $param['pagesize'] = !empty($pageArr['pagesize']) ? intval($pageArr['pagesize']) : 50;
        $param['page'] = !empty($pageArr['pagenum']) ? intval($pageArr['pagenum']) : 0;
        $q = $this->input->get('q');
        if(isset($q)){
            $param['q'] = $q;
        }
        $classid = intval($this->input->get('classid'));
        if($classid > 0){
            $param['classid'] = $classid;
        }
        $result = $this->apiServer->reSetting()->setService('Aroomv3.Student.list')->addParams($param)->request();
        $percent = $this->apiServer->reSetting()->setService('Aroomv3.Share.getPercentList')
            ->addParams(array('crid'=>$param['crid'],'page'=>$param['page'],'pagesize'=>$param['pagesize']))
            ->request();
        $uids = array();
        if(!empty($percent['percentlist']) && is_array($percent['percentlist'])){
            $uids = array_column($percent['percentlist'],'uid');
        }
        if(!empty($result['list']) && is_array($result['list'])){
            foreach ($result['list'] as &$starr){
                if(!empty($uids) && is_array($uids) && in_array($starr['uid'],$uids)){
                    $starr['selected'] = 1;
                }else{
                    $starr['selected'] = 0;
                }
            }
        }
        $selectedsum = 0;
        $roomcount = 0;
        $roomstudent = $this->apiServer->reSetting()->setService('Aroomv3.Share.roomStrudentSum')->addParams($param)->request();
        if(!empty($roomstudent) && is_array($roomstudent)){
            $roomcount = count($roomstudent);
            foreach ($roomstudent as $rstarr) {
                if (!empty($uids) && is_array($uids) && in_array($rstarr['uid'], $uids)) {
                    $selectedsum++;
                }
            }
        }
        if($roomcount >=$selectedsum){
            $roomcount = $roomcount-$selectedsum;
        }
        $result['roomcount'] = $roomcount;//当前班级未设置分成比例的学生总数
        $result = !empty($result) ? $result : array();
        $this->renderjson(0,'',$result);
    }

    /**
     *获取网校用户分销返现列表
     */
    public function sharelists(){
        $param = array();
        $param['crid'] = $this->roominfo['crid'];
        if(empty($param['crid'])){
            $this->renderjson(1,'参数错误');
        }
        $get = $this->input->get();
        if(!empty($get['starttime'])){
            $param['starttime'] = intval($get['starttime']);
        }
        if(!empty($get['endtime'])){
            $param['endtime'] = intval($get['endtime']);
        }
        if(isset($get['q'])){
            $param['q'] = h($get['q']);
        }
        $param['pagesize'] = !empty($get['pagesize']) ? intval($get['pagesize']) : 50;
        $param['page'] = !empty($get['page']) ? intval($get['page']) : 0;
        if($get['providercrid'] !== NULL && $get['providercrid'] !== ''){
            $param['providercrid'] = intval($get['providercrid']);
        }
        $res = $this->apiServer->reSetting()->setService('Aroomv3.Share.shareList')->addParams($param)->request();
        if(!empty($res['sharelist']) && is_array($res['sharelist'])){
            foreach ($res['sharelist'] as &$sharelist){
                if(isset($sharelist['providercrid']) && ($sharelist['providercrid']==0)){
                    $sharelist['crname'] = '本校课程';
                }
            }
        }
        $this->renderjson(0,'',$res);
    }

    /**
     *获取分销返现来源网校列表
     */
    public function sourcelists(){
        $param = array();
        $param['crid'] = $this->roominfo['crid'];
        if (empty($param['crid'])) {
            $this->renderjson(1, '参数错误');
        }
        $res = $this->apiServer->reSetting()->setService('Aroomv3.Share.sourceLists')->addParams($param)->request();
        if(!empty($res) && is_array($res)){
            foreach ($res as $key => &$source){
                if(isset($source['providercrid']) && ($source['providercrid'] ==0)){
                    $source['crname'] = '本校课程';
                }
            }
        }
        $this->renderjson(0,'',$res);
    }

    /**
     * 导出分销返现列表
    */
    public function sharereport(){
        $param = array();
        $param['crid'] = $this->roominfo['crid'];
        if(empty($param['crid'])){
            $this->renderjson(1,'参数错误');
        }
        $get = $this->input->get();
        if(!empty($get['starttime'])){
            $param['starttime'] = intval($get['starttime']);
        }
        if(!empty($get['endtime'])){
            $param['endtime'] = intval($get['endtime']);
        }
        if(isset($get['q'])){
            $param['q'] = h($get['q']);
        }
        $param['pagesize'] = !empty($get['pagesize']) ? intval($get['pagesize']) : 50;
        $param['page'] = !empty($get['page']) ? intval($get['page']) : 0;
        if($get['providercrid'] !== NULL && $get['providercrid'] !== ''){
            $param['providercrid'] = intval($get['providercrid']);
        }
        $res = $this->apiServer->reSetting()->setService('Aroomv3.Share.shareList')->addParams($param)->request();
        if(!empty($res['sharelist']) && is_array($res['sharelist'])){
            foreach ($res['sharelist'] as &$sharelist){
                if(isset($sharelist['providercrid']) && ($sharelist['providercrid']==0)){
                    $sharelist['crname'] = '本校课程';
                }
            }
        }
        $titleData = array('分享人账号','分享人姓名','购买人账号','购买人姓名','购买时间','课程来源','课程名称','课程价格','分成金额');
        foreach($res['sharelist'] as $share){
            $exportData[] = array(
                $share['shareusername'],
                $share['sharerealname'],
                $share['buyusername'],
                $share['buyrealname'],
                Date('Y-m-d H:i:s',$share['paytime']),
                $share['crname'],
                $share['oname'],
                $share['fee'],
                $share['sharefee']
            );
        }
        $filename = '分销列表';
        $widtharr = array(15,15,15,15,15,15,15,15,15);
        $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);
    }


    /**
     * 导出excel
     * @param Array array("编号",'用户名','性别'....)
     * @param Array array('1','李华','男'...)
     * @param String rgbColor
     * @param String execl文件名称
     *
     */
    protected  function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$name,$manuallywidth=array()){

        set_time_limit(0);
        $objPHPExcel = Ebh::app()->lib('PHPExcel');

        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'1';//列A1,B1,C1,D1
                if(empty($manuallywidth))
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
        if(is_array($dataArr)){
            foreach ($dataArr as $k=>$v) {
                $str = "A";
                foreach($titleArr as $kt=>$vt){
                    $p = $str.($k+2);//从第二列填充内容 A22,B22...A33 B33
                    $pt = $objPHPExcel->getActiveSheet();
                    if(empty($manuallywidth))
                        $pt->getColumnDimension($str)->setAutoSize(true);//单元格每项内容自适应
                    if(is_numeric($v[$kt])){
                        if(empty($manuallywidth))
                            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);//A列头标题自适应
                        $pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
                        $pt->getColumnDimension($str)->setWidth(20);//设置单元格宽度
                        $pt->setCellValue($p, $v[$kt].' ');//填充内容
                    }else{
                        $pt->setCellValue($p, ' '.$v[$kt]);
                    }

                    $str++;
                }
            }
        }
        if(!empty($manuallywidth)){
            $str = 'A';
            foreach($manuallywidth as $width){
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
                $str++;
            }
        }
        //exit(0);
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