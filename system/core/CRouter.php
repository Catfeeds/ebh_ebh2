<?php

/**
 * Web路由类
 */
class CRouter {
    private $controllers;
    private $action;
    private $module;
    private $uri;
    public function __construct() {
        
    }
    public function parse() {    
        if(empty($this->uri)) {
            $this->uri = Ebh::app()->getApp();
        }
        $this->uri->parse_uri();
    }
    public function setUri($uri) {
        $this->uri = $uri;
    }
    /**
     * 创建控制器
     * @return object 控制器对象
     */
    public  function createController() {
        $control = $this->uri->uri_control();
        if(empty($control)) {
            show_404();
        }
        $directory = $this->uri->uri_directory();
        if(!empty($directory)) {
            $controlpath = CONTROL_PATH.$directory.'/'.$control.'.php';
        } else {
            $controlpath = CONTROL_PATH.$control.'.php';
        }
        if(!file_exists($controlpath)) {
            show_404();
            return false;
        }
        $controlname = ucfirst($control).'Controller';
        require $controlpath;
        if(class_exists($controlname)) {
            $controller = new $controlname;
        }
        return $controller;
    }
	/**
     * 根据给定的控制器创建控制器
	 * @param $path string 控制器路径，CONTROL_PATH开始的相对路径，不带后缀名，如要加载控制器 ebh/controllers/myroom/cloud.php ，则输入 myroom/cloud
     * @return object 控制器对象
     */
    public  function createControllerByPath($path) {
        if(empty($path)) {
            show_404();
        }
        $controlpath = CONTROL_PATH.$path.'.php';
        if(!file_exists($controlpath)) {
            show_404();
            return false;
        }
		$ipos = strpos($path,'/');
		if ($ipos !== FALSE) {
			$control = substr($path,$ipos+1);
		} else {
			$control = $path;
		}
        $controlname = ucfirst($control).'Controller';
		if(!class_exists($controlname)) {
			require $controlpath;
		}
        if(class_exists($controlname)) {
            $controller = new $controlname;
        }
        return $controller;
    }
    
}