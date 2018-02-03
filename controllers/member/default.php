<?php
class DefaultController extends CControl{
	
	/**
	 * 所有到member的url跳转到home下面,兼容以前的
	 */
	public function __construct(){
		parent::__construct();
		header('Location:/homev2.html');
	}
	
	public function index(){
		header('Location:/homev2.html');
	}
	
	
}
?>