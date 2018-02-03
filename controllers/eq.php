<?php
/*
*eq
*/
	class EqController extends CControl{
		function index(){
			$this->assign('title', 'eq下载-e板会-开启云教学互动时代');
			$this->display('common/eq');
		}
	}
?>