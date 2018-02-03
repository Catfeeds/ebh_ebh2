<?php
	/* 	银行挂件，用于银行下拉列表
	 *	返回格式 例：$this->widget('bank_widget',array('bankname'=>'4'));
	 *	<option value="0">选择归属银行</option>
	 *	<option value="1">中国银行</option>
	 *	<option value="2">农业银行</option>
	 *	<option value="3">建设银行</option>
	 *	<option value="4" selected=selected>招商银行</option>
	 *	<option value="5">交通银行</option>
	 *	<option value="6">工商银行</option>
	 *	<option value="7">东亚银行</option>
	 *	<option value="8">华夏银行</option>
	 *	<option value="9">中信实业银行</option>
	 *	<option value="10">深圳发展银行</option>
	 *	<option value="11">中国平安银行</option>
	 *	<option value="12">上海浦发银行</option>
	 *	<option value="13">中国民生银行</option>
	 *	<option value="14">香港汇丰银行</option>
	 *	<option value="15">中国光大银行</option>
	 *	<option value="16">中国邮政储蓄银行</option>
	****/
	$bankList = array(
		'0'=>'选择归属银行',
		'1'=>'中国银行',
		'2'=>'农业银行',
		'3'=>'建设银行',
		'4'=>'招商银行',
		'5'=>'交通银行',
		'6'=>'工商银行',
		'7'=>'东亚银行',
		'8'=>'华夏银行',
		'9'=>'中信实业银行',
		'10'=>'深圳发展银行',
		'11'=>'中国平安银行',
		'12'=>'上海浦发银行',
		'13'=>'中国民生银行',
		'14'=>'香港汇丰银行',
		'15'=>'中国光大银行',
		'16'=>'中国邮政储蓄银行',
		);
	$bankOptions = '';
	foreach ($bankList as $bk => $bv) {
		if($bk==$data['bankname']){
			$bankOptions.='<option value="'.$bk.' "selected=selected">'.$bv.'</option>';
		}else{
			$bankOptions.='<option value="'.$bk.'">'.$bv.'</option>';
		}
	}
	echo $bankOptions;
?>