<?php 
Class Excel{
	private $_objPHPExcel;
	public function __construct($file) {
		if(empty($this->_objPHPExcel)){
				$type = strtolower(pathinfo($file, PATHINFO_EXTENSION)) == 'xls' ? 'Excel5' : 'Excel2007';
			    $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
			    $cacheSettings = array(' memoryCacheSize ' => '8MB');
			    PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			    $objReader = PHPExcel_IOFactory::createReader($type);
			    $this->_objPHPExcel = $objReader->load($file);
			
		}
    }
    /**
	 * 读取excel到数一个据组
	 * 优化过的PHPExcel可以读取大量excel数据的方法<br/>
	 * $file excel文件路径<br/>
	 * $maxColumnCount  要读取的最大列，默认是自动，如果列比较多，只读取前几列，可以节省内存消耗<br/>
	 *                  比如：1代表只读取到第一列，3代表只读取到第三列<br/>
	 * @return type
	 */
	function excel2array($maxColumnCount = null) {
	    $sheet = $this->_objPHPExcel->getActiveSheet();
	    if (!$sheet) {
	    	log_message("无法识别excel文件的内容");
	        $ex=new Exception('无法识别的文件',500);
	        throw $ex;
	    }
	    $sheet->garbageCollect();
	    $maxCol = $sheet->getHighestColumn();
	    $maxRow = $sheet->getHighestRow();
	    $maxCol = intval($maxColumnCount) ? chr(intval($maxColumnCount) - 1 + 65) : $maxCol;
	    try{
	    	$res = $sheet->rangeToArray('A1:' . $maxCol . $maxRow, '');
	    	return $res;
	    }catch(Exception $e){
	    	return false;
	    }
	    
	}


	function getdata() {
		set_time_limit ( 0 );	
		$sheet_count = $this->_objPHPExcel->getSheetCount ();
		for($s = 0; $s < $sheet_count; $s ++) {
			$currentSheet = $this->_objPHPExcel->getSheet ( $s ); // 当前页
			$row_num = $currentSheet->getHighestRow (); // 当前页行数
			$col_max = $currentSheet->getHighestColumn (); // 当前页最大列号
			                                              
			// 循环从第二行开始，第一行往往是表头
			for($i = 2; $i <= $row_num; $i ++) {
				for($j = 'A'; $j < $col_max; $j ++) {
					$address = $j . $i; // 单元格坐标
					$cell_values [] = $currentSheet->getCell ( $address )->getFormattedValue ();
				}
			}
		}
		
		return  $cell_values;
	}



	function getRows($sheet = array()) {
		set_time_limit (0);
		@ini_set('memory_limit','1024M');
		// 读取规则
		$sheet_read_arr = array ();
		if (empty ( $sheet )) {
			$sheet_read_arr ["sheet1"] = array (
					"A",
					"B",
					"C",
					"D",
					"E" 
			);
		} else {
			$sheet_read_arr ["sheet1"]= $sheet;
		}
		// 循环所有的页
		foreach ( $sheet_read_arr as $key => $val ) {
			$currentSheet = $this->_objPHPExcel->getSheetByName ( $key ); // 通过页名称取得当前页
			$row_num = $currentSheet->getHighestRow (); // 当前页行数
			                                            // 循环从第二行开始，第一行往往是表头
			for($i = 2; $i <= $row_num; $i ++) {
				$cell_str = '';
				foreach ( $val as $cell_val ) {
					$address = $cell_val . $i; // 单元格坐标
					$cell_str.='-';
					$cell_str.= $currentSheet->getCell ( $address )->getFormattedValue (); // 读取单元格内容
				}
				$cell_str = trim($cell_str,'-');
				$cell_values[] = $cell_str; 
			}
		}
		return $cell_values;
	}	
}

