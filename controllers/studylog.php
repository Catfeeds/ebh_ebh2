<?php
class StudylogController extends CControl{
	public function index(){
		set_time_limit(0);
		$roominfo = Ebh::app()->room->getcurroom();
		$smodel = $this->model('studylog');
		$datefrom = '1434729600';
		$dateto = '1434902400';
		// $studentlist = $smodel->getStudents(array('crid'=>$roominfo['crid']));
		// $schoolnames = $smodel->getSchools(array('crid'=>$roominfo['crid']));
		// var_dump($studentlist);
		$schoolArr = array(
			'丁桥镇初级中学'=>'海宁',
'上外附属宏达学校'=>'海宁',
'双山实验学校'=>'海宁',
'周王庙镇初级中学'=>'海宁',
'海宁市丁桥镇新仓初级中学'=>'海宁',
'海宁市南苑中学'=>'海宁',
'海宁市友谊学校'=>'海宁',
'海宁市培智学校'=>'海宁',
'海宁市安宁学校'=>'海宁',
'海宁市斜桥中学'=>'海宁',
'海宁市永宁学校'=>'海宁',
'海宁市狮岭学校'=>'海宁',
'海宁市盐官镇初级中学'=>'海宁',
'海宁市硖石中学'=>'海宁',
'海宁市第一初级中学'=>'海宁',
'海宁市第三中学'=>'海宁',
'海宁市第二中学'=>'海宁',
'海宁市紫微初级中学'=>'海宁',
'海宁市行知初级中学'=>'海宁',
'海宁市许村中学'=>'海宁',
'海宁市许村镇许巷初级中学'=>'海宁',
'海宁市长安镇初级中学'=>'海宁',
'海宁市长安镇盐仓学校'=>'海宁',
'海宁市马桥初级中学'=>'海宁',
'海宁市鹃湖学校'=>'海宁',
'许村镇沈士初级中学'=>'海宁',
'钱塘江学校'=>'海宁',
'海宁狮岭学校级中学'=>'海宁',
'海盐县通元中学'=>'海盐',
'海盐县广丰学校'=>'海盐',
'海盐县澉浦中学'=>'海盐',
'海盐县元通中学'=>'海盐',
'海盐县于城中学'=>'海盐',
'海盐县滨海中学'=>'海盐',
'海盐县秦山中学'=>'海盐',
'海盐县百步中学'=>'海盐',
'海盐县行知中学'=>'海盐',
'海盐县沈荡中学'=>'海盐',
'海盐县实验中学'=>'海盐',
'海盐县武原中学'=>'海盐',
'海盐县石泉中学'=>'海盐',
'海盐县博才实验学校'=>'海盐',
'海盐县育才学校'=>'海盐',
'嘉善县干窑中学'=>'嘉善',
'嘉善县陶庄中学'=>'嘉善',
'嘉善县丁栅中心学校'=>'嘉善',
'嘉善县第五中学'=>'嘉善',
'嘉善县第一中学'=>'嘉善',
'嘉善新世纪学校'=>'嘉善',
'浙江省嘉善县第四中学'=>'嘉善',
'嘉善县柳洲学校'=>'嘉善',
'嘉善县里泽中学'=>'嘉善',
'嘉善县实验中学'=>'嘉善',
'嘉善县泗洲中学'=>'嘉善',
'嘉善县大云中心学校'=>'嘉善',
'嘉善县第三中学'=>'嘉善',
'嘉善县天凝中学'=>'嘉善',
'嘉善县姚庄中学'=>'嘉善',
'嘉善县南暑中学'=>'嘉善',
'嘉兴市特殊教育学校'=>'嘉兴直属',
'东北师范大学南湖实验学校'=>'南湖',
'北京师范大学南湖附属学校'=>'南湖',
'南湖创业学校'=>'南湖',
'南湖区余新镇中学'=>'南湖',
'南湖区凤桥镇中学'=>'南湖',
'南湖区大桥镇中学'=>'南湖',
'南湖区新丰镇中学'=>'南湖',
'嘉兴一中实验学校'=>'南湖',
'嘉兴南湖国际实验中学'=>'南湖',
'嘉兴外国语学校'=>'南湖',
'嘉兴市三水湾中学'=>'南湖',
'嘉兴市二十一世纪外国语学校'=>'南湖',
'嘉兴市南湖区七星镇中学'=>'南湖',
'嘉兴市南湖区余新仁和学校'=>'南湖',
'嘉兴市南湖区百花育才学校'=>'南湖',
'嘉兴市南溪中学'=>'南湖',
'嘉兴市城南中学'=>'南湖',
'嘉兴市实验初级中学教育集团'=>'南湖',
'嘉兴市少年儿童体育学校'=>'南湖',
'嘉兴市清河中学'=>'南湖',
'嘉兴市蓝天学校'=>'南湖',
'嘉兴市蓝翔实验学校'=>'南湖',
'嘉兴市运河实验学校'=>'南湖',
'民丰蓝天学校'=>'南湖',
'秀州中学分校'=>'南湖',
'新仓中学'=>'平湖',
'平湖市南市中学'=>'平湖',
'平湖市全塘中学'=>'平湖',
'乍浦初级中学'=>'平湖',
'平湖市黄姑中学'=>'平湖',
'新埭中学'=>'平湖',
'平湖市福臻中学'=>'平湖',
'东湖中学'=>'平湖',
'平湖市林埭中学'=>'平湖',
'城关中学'=>'平湖',
'广陈中学'=>'平湖',
'平湖市行知中学'=>'平湖',
'平湖市稚川实验中学'=>'平湖',
'平湖市培智学校'=>'平湖',
'桐乡市第三中学'=>'桐乡',
'桐乡市东方学校'=>'桐乡',
'桐乡市邵逸夫中学'=>'桐乡',
'桐乡市崇德初级中学'=>'桐乡',
'桐乡市石门中学'=>'桐乡',
'高桥镇高桥初级中学'=>'桐乡',
'河山镇中心学校'=>'桐乡',
'桐乡市第六中学'=>'桐乡',
'桐乡市洲泉中学'=>'桐乡',
'桐乡市求是实验中学'=>'桐乡',
'桐乡市现代实验学校'=>'桐乡',
'桐乡市第七中学'=>'桐乡',
'凤鸣同福初级中学'=>'桐乡',
'桐乡市濮院桐星学校'=>'桐乡',
'桐乡市石门镇羔羊初级中学'=>'桐乡',
'桐乡市乌镇中学'=>'桐乡',
'桐乡市启新学校'=>'桐乡',
'桐乡市第九中学'=>'桐乡',
'桐乡市世纪路学校'=>'桐乡',
'桐乡市石门路学校'=>'桐乡',
'桐乡市实验中学'=>'桐乡',
'桐乡市濮院新星学校'=>'桐乡',
'桐乡市屠甸中学'=>'桐乡',
'桐乡市大麻镇中心学校'=>'桐乡',
'桐乡市第十中学'=>'桐乡',
'高桥新区中心学校'=>'桐乡',
'高桥镇骑塘中心学校'=>'桐乡',
'桐乡市特殊教育学校'=>'桐乡',
'嘉善高级中学'=>'秀洲',
'嘉兴市华林学校'=>'秀洲',
'嘉兴市精英学校'=>'秀洲',
'嘉兴市蓝天第二学校'=>'秀洲',
'嘉兴市蓝翔学校(泾桥)'=>'秀洲',
'嘉兴市利民学校'=>'秀洲',
'嘉兴市书阁学校'=>'秀洲',
'嘉兴市秀洲区高照实验学校（初中）'=>'秀洲',
'嘉兴市秀洲区洪合镇新民学校'=>'秀洲',
'嘉兴市秀洲区洪合镇中学'=>'秀洲',
'嘉兴市秀洲区洪兴实验学校'=>'秀洲',
'嘉兴市秀洲区塘汇实验学校'=>'秀洲',
'嘉兴市秀洲区王店镇春蕾学校'=>'秀洲',
'嘉兴市秀洲区王店镇建设中学'=>'秀洲',
'嘉兴市秀洲区王店镇中学'=>'秀洲',
'嘉兴市秀洲区王江泾精英学校'=>'秀洲',
'嘉兴市秀洲区王江泾镇实验学校（初中）'=>'秀洲',
'嘉兴市秀洲区王江泾镇中学'=>'秀洲',
'嘉兴市秀洲区新塍镇中学'=>'秀洲',
'嘉兴市秀洲区新光学校'=>'秀洲',
'嘉兴市秀洲区油车港镇陈家坝学校'=>'秀洲',
'嘉兴市秀洲区油车港镇中学'=>'秀洲',
'嘉兴市秀洲现代实验学校'=>'秀洲',
'上海外国语大学秀洲外国语学校'=>'秀洲',
'上海外国语大学秀洲外国语学校（北校区）（初中）'=>'秀洲',
'浙江师范大学附属秀洲实验学校'=>'秀洲'

		);
		$schoolArr2 = array(
			'宇宙学校'=>'宇宙的',
			'ss1'=>'宇宙的',
			'上市2'=>'fwefwe'
			// ''=>''
		);
		$flist = $smodel->getFolderlist(array('crid'=>$roominfo['crid']));
		$gnamearr = array(
		0=>'空年级',
		1=>'一年级',
		2=>'二年级',
		3=>'三年级',
		4=>'四年级',
		5=>'五年级',
		6=>'六年级',
		7=>'初一',
		8=>'初二',
		9=>'初三',
		10=>'高一',
		11=>'高二',
		12=>'高三'
		);
		$gradelist = array();
		foreach($flist as $k=>$folder){
			$folderid = $folder['folderid'];
			$cws = $smodel->getCW(array('folderids'=>$folderid));
			foreach($cws as $cw){
				if(empty($flist[$k]['cwids']))
					$flist[$k]['cwids'] = $cw['cwid'];
				else
					$flist[$k]['cwids'].= ','.$cw['cwid'];
			}
			$gradelist[$gnamearr[$folder['grade']]][] = $flist[$k];
		}
		// var_dump($gradelist);exit;
		// $titleArr = array('学校名');
		// foreach($flist as $k=>$folder){
			// array_push($titleArr,$folder['foldername']);
		// }
		$this->initexcel();
		$i = 0;
		// var_dump($gradelist);exit;
		//年级->课程列表
		foreach($gradelist as $grade=>$folderlist){
			$dataArr = array();
			$start = 2;
			$curdistcit = '海宁';
			$dcount = 0;
			$schoolgradestudents = array();
			//学校->区域列表
			foreach($schoolArr as $schoolname=>$district){
				
				$resArr = array('',$schoolname);
				// $i=0;
				$titleArr = array('','学校名');
				$widArr = array(20);
				
				foreach($folderlist as $k=>$folder){
					array_push($titleArr,$folder['foldername']);
					// var_dump($folder['grade']);
					if(empty($schoolgradestudents[$folder['grade']])){
						//学校的用户列表
						$studentlist = $smodel->getStudentsByschoolname(array('crid'=>$roominfo['crid'],'schoolname'=>$schoolname,'grade'=>$folder['grade']));
						// var_dump($studentlist);
						foreach($studentlist as $stu){
							if(empty($stuids))
								$stuids = $stu['uid'];
							else
								$stuids.= ','.$stu['uid'];
						}
						//
						$schoolgradestudents[$folder['grade']] = empty($stuids)?'':$stuids;
						$stuids = '';
					}
					$slog = array();
					$count = 0;
					$totalstu = 0;
					if(!empty($folder['cwids']) && !empty($schoolgradestudents[$folder['grade']]	)){
						$slog = $smodel->getStudylog(array('uids'=>$schoolgradestudents[$folder['grade']],'cwids'=>$folder['cwids'],'datefrom'=>$datefrom,'dateto'=>$dateto));
						// $totalstu = count(explode(',',$schoolgradestudents[$folder['grade']]));
					}
					
					if(!empty($slog))
						$count = $slog;
					array_push($resArr,$count);
					array_push($widArr,20);
					// $dataArr[] = array($folder['foldername'],$count,($totalstu-$count));
				}
				$dataArr[] = $resArr;
				// var_dump($schoolgradestudents);
				unset($schoolgradestudents);
			}
			// var_dump($titleArr);
			// exit;
			
			
			$objPHPExcel = Ebh::app()->lib('PHPExcel');
			if($i>0){
				$msgWorkSheet = new PHPExcel_Worksheet($objPHPExcel, $grade);
				$objPHPExcel->addSheet($msgWorkSheet); //插入工作表
				$objPHPExcel->setActiveSheetIndex($i); //设置第i个工作表为活动工作表
			}else
				$objPHPExcel->getActiveSheet()->setTitle($grade); //设置工作表名称
			// var_dump($districCountArr);exit;
			$this->_exportExcel($titleArr, $dataArr,"FFFFFFFF",$widArr);
			
			foreach($schoolArr as $schoolname=>$district){
				if($curdistcit == $district){
					$dcount++;
				}
				else{
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$start,$curdistcit);
					// log_message($dcount);
					$objPHPExcel->getActiveSheet()->mergeCells('A'.$start.':A'.($start+$dcount-1));
					$start = $start + $dcount;
					$dcount = 1;
					$curdistcit = $district;
				}
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$start,$curdistcit);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$start.':A'.($start+$dcount-1));
			// $objPHPExcel->getActiveSheet()->setCellValue('A3','ddd');
			// $objPHPExcel->getActiveSheet()->mergeCells('A2:A5');
			
			$i++;
		}
		// var_dump($dataArr);
		// exit;
		$filename = '1';
		$widtharr = array(20,15,15);
		
		
		
		$this->doexport();
		exit;
	}
	
	
	
	
	protected function initexcel(){
		$objPHPExcel = Ebh::app()->lib('PHPExcel');
		
		// 以下是一些设置 ，什么作者  标题啊之类的
		$objPHPExcel->getProperties()
					->setTitle("数据EXCEL导出")
					->setSubject("数据EXCEL导出")
					->setDescription("备份数据")
					->setKeywords("excel")
					->setCategory("result file");
	}
	
	protected  function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$manuallywidth=array()){
		
		$objPHPExcel = Ebh::app()->lib('PHPExcel');
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
						$pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);//设置单元格文本存储类型
						$pt->getColumnDimension($str)->setWidth(20);//设置单元格宽度
						$pt->setCellValue($p, $v[$kt]);//填充内容
					}else{
						$pt->setCellValue($p, $v[$kt]);
					}
						
					$str++;
				}
				
				// log_message($str.($k+1). '=SUM('.$str.'2:'.$str.$k.')');
				// $objPHPExcel->getActiveSheet()->setCellValue();
			}
			
		}
		if(!empty($manuallywidth)){
			$str = 'A';
			foreach($manuallywidth as $width){
				$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
				
				$str++;
				if($str != 'B')
				$objPHPExcel->getActiveSheet()->setCellValue($str.'155', '=SUM('.$str.'2:'.$str.'154)');
			}
		}
		
		//exit(0);
		// 输出下载文件 到浏览器
		
		
	}	
	
	protected function doexport(){
		$name = '111';
		$objPHPExcel = Ebh::app()->lib('PHPExcel');
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
?>