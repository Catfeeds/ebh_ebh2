<?php
/*常用工具控制器*/
class ToolsController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
	public function index(){
        $this->display('troom/tools');
	}
}
