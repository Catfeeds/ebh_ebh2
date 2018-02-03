<?php
/**
 * 兑换码接口
 */
class RedeemController extends ARoomV3Controller {

	/**
	 *兑换码列表
	 */
	public function getRedeemCardList(){
		$get = $this->input->get();
		$parameters = $this->getPageInfo();
		$parameters['page'] = $parameters['pagenum'];
		if (!empty($get['q'])) {
			$parameters['q'] = $get['q'];
		}
		if (!empty($get['folderid'])) {
			$parameters['folderid'] = $get['folderid'];
		}
		if (!empty($get['cardid'])) {
			$parameters['cardid'] = $get['cardid'];
		}
		if (!empty($get['foldername'])) {
			$parameters['foldername'] = $get['foldername'];
		}
		if (!empty($get['name'])) {
			$parameters['name'] = $get['name'];
		}
		if (!empty($get['redeemnumber'])) {
			$parameters['redeemnumber'] = $get['redeemnumber'];
		}
		$export = intval($this->input->get('export'));
        if($export > 0){
            $parameters['pagesize'] = 100000;
        }
		if (!empty($get['lot'])) {
			$parameters['lot'] = $get['lot'];
		}
		if (isset($get['status']) && $get['status'] != '') {
			$parameters['status'] = intval($get['status']);
		}
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Redeem.list')->addParams($parameters)->request();
		if($export > 0 && !empty($result['list'])){
            $titleData = array('序号','兑换码号','名称','课程','开始生效时间','课程原价','兑换码价格','状态','使用者','交易时间');
            $exportData = array();
            foreach($result['list'] as $key=>$list){
                $exportData[] = array(
                    $key+1,
                    $list['redeemnumber'],
                    $list['name'],
                    $list['foldername'],
                    date('Y-m-d  H:i:s', $list['effecttime']),
                    $list['fprice'],
                    $list['price'],
                    $list['rstatus']==1?'已使用':($list['rstatus']==-1?'已退换':'未使用'),
                    !empty($list['realname'])?$list['realname']:'--',
                    !empty($list['usetime'])?date('y-m-d  H:i:s', $list['usetime']):'--'
                );
            }
            $filename = '兑换码信息';
            $widtharr = array(15,30,30,30,30,30,30,30,30,30,30);
            $this->_exportExcel($titleData,$exportData,'FFFFFFFF',$filename,$widtharr);

            exit;
        }
		$this->renderjson('0','',$result);
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

	/**
	 * 新增兑换批次
	 */
	public function addRedeem(){
		$post = $this->input->post();
		$number = intval($post['number']);
		$folderid = intval($post['folderid']);
		$itemid = intval($post['itemid']);
		if (!empty($post['name']))
			$parameters['name'] = $post['name'];
		if (isset($post['price']))
			$parameters['price'] = $post['price'];
		if (!$number || !$folderid) {
			$this->renderjson(-1,'参数为空');
		}
		$parameters['folderid'] = $folderid;
		$parameters['itemid'] = $itemid;
		$parameters['effecttime'] = intval($post['effecttime']);
		$parameters['number'] = $number;
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Redeem.add')->addParams($parameters)->request();
		if ($result) {
			$this->renderjson(0,'添加成功',$result);
		} else {
			$this->renderjson(-1,'添加失败');
		}
	}

	/**
	 * 修改文章，只用于删除
	 */
	public function update(){
		$post = $this->input->post();
		$lotid = intval($post['lotid']);
		if (!empty($post['name']))
			$parameters['name'] = $post['name'];
		if (!empty($post['effecttime']))
			$parameters['effecttime'] = $post['effecttime'];
		if (isset($post['status']))
			$parameters['status'] = intval($post['status']);
		if (!$lotid) {
			$this->renderjson(-1,'参数为空');
		}
		$parameters['lotid'] = $lotid;
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Redeem.update')->addParams($parameters)->request();
		if ($result) {
			$this->renderjson(0,'成功');
		} else {
			$this->renderjson(-1,'失败');
		}
	}

	/**
	 * 退款
	 */
	public function refund(){
		$post = $this->input->post();
		if (!empty($post['cardid']))
			$parameters['cardid'] = intval($post['cardid']);
		if (!empty($post['lotid']))
			$parameters['lotid'] = intval($post['lotid']);
		if (!empty($post['cardidstr']))
			$parameters['cardidstr'] = $post['cardidstr'];
		$parameters['crid'] = $this->roominfo['crid'];
		$result = $this->apiServer->reSetting()->setService('Aroomv3.Redeem.refund')->addParams($parameters)->request();
		if ($result) {
			$this->renderjson(0,'成功');
		} else {
			$this->renderjson(-1,'删除');
		}
	}
}
