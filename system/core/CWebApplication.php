<?php

/**
 * Web应用类，从Web请求进来主要有此类负责调用相关程序
 */
class CWebApplication extends CApplication {

    /**
     * 处理应用请求
     */
    public function processRequest() {
        $router = $this->getRouter();
        $uri = $this->getUri();
        $router->setUri($uri);
        $router->parse();
        $controller = $router->createController();
        $method = $uri->uri_method();
        $control = $uri->uri_control();
        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            log_message("controller:$control OR action:$method,has not found! uri:{$_SERVER['REQUEST_URI']}");
            echo '';
        }
    }
	/**
	 * 加载特定的控制器
	 * @param $control string ，CONTROL_PATH开始的相对路径，不带后缀名，如要加载控制器 ebh/controllers/myroom/cloud.php ，则输入 myroom/cloud
	 * @param $method string 指定控制器要执行的方法
	 * @param $arg object 支持添加一个参数 
	 */
	public function processAction($control,$method = 'index',$arg = NULL) {
		$router = $this->getRouter();
        $controller = $router->createControllerByPath($control);
        if (method_exists($controller, $method)) {
            return $controller->$method($arg);
        }
		return FALSE;
	}

    /**
     * 注册核心组件类
     */
    protected function registerCoreComponents() {
        parent::registerCoreComponents();

        $components = array(
            'user' => 'CUser',
            'room' => 'CRoom'
        );

        $this->setComponents($components);
    }

}