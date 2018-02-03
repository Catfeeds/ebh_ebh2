<?php

/**
 * 应用类基类，集成此类的有 CWebApplication和CConsoleApplication等
 */
abstract class CApplication {

    /**
     * 处理请求抽象方法
     */
    abstract public function processRequest();
	/**
	*运行访问控制器
	* @param $control string 控制器
	* @param $action string 控制器方法
	*/
	abstract function processAction($control,$action = 'index',$arg = null);

    private $_helpers = array();    //已加载辅助方法库
    private $_classes = array();    //已加载class类
    private $_components = array(); //已加载组件类
    private $_models = array();     //已加载model类

    public function __construct($config = NULL) {
        Ebh::setApplication($this);
        if (is_string($config)) {
            $config = require($config);
        }
        $this->configure($config);
        $this->init();
    }

    /**
     * 启动应用程序
     */
    public function run() {
        $this->processRequest();
    }
	/**
	 * 启动特定控制器与对应方法
	 * @param $control string 控制器路径，CONTROL_PATH开始的相对路径，不带后缀名，如要加载控制器 ebh/controllers/myroom/cloud.php ，则输入 myroom/cloud
	 * @param $action string 指定控制器要执行的方法
	 */
	public function runAction($control,$action = 'index',$arg = null) {
		return $this->processAction($control,$action,$arg);
	}
    /**
     * 将配置数组分解成key value形式
     * @param array $config 配置数组
     */
    public function configure($config) {
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * 初始化应用
     */
    public function init() {

        //加载helper
        foreach ($this->auto_helper as $helper) {
            $this->helper($helper);
        }
        //加载数据库应用
        if ($this->db['autoload']) {
            $this->getDb();
        }
        $this->registerCoreComponents();
    }
	

    /**
     * 加载辅助方法
     * @param string $helpername 辅助方法库方法
     */
    public function helper($helpername) {
        if (!isset($this->_helpers[$helpername])) {
            require (HELPER_PATH . $helpername . '.php');
            $this->_helpers[$helpername] = TRUE;
        }
    }

    /**
     * 加载类库
     * @param string $libname
     *
     * jw 修改加载lib文件添加path用于加载lib目录中指定路径的类文件
     * 如果需要加载lib下Live目录下的文件则使用 Ebh::app()->lib('Sata','Live');
     *
     * 实际加载路径为 lib/Live/Sata.php
     */
    public function lib($libname,$path = '') {
        if (!isset($this->_classes[$libname])) {
            if($path != ''){
                $path = $path.'/'.$libname;
            }else{
                $path = $libname;
            }
            $libpath = LIB_PATH . $path . '.php';
            if (!file_exists($libpath)) {
                
            }
            require ($libpath);
            if (!class_exists($libname)) {
                echo "$libname class not exists";
            }
            $this->$libname = new $libname;
            $this->_classes[$libname] = $this->$libname;
            return $this->$libname;
        }
		return $this->$libname;
    }

    /**
     * 返回CRouter路由类
     * @return object 
     */
    public function getRouter() {
        if (isset($this->_classes['CRouter'])) {
            return $this->_classes['CRouter'];
        }
        $router = new CRouter();
        $this->_classes['CRouter'] = $router;
        return $router;
    }

    /**
     * 返回CUri类
     * @return object 
     */
    public function getUri() {
        if (isset($this->_classes['CUri'])) {
            return $this->_classes['CUri'];
        }
        $uri = new CUri();
        $this->_classes['CUri'] = $uri;
        return $uri;
    }

    /**
     * 返回DB类
     */
    public function getDb() {
        if (isset($this->_classes['db'])) {
            return $this->_classes['db'];
        }
        $db = new CDb($this->db);
        $this->_classes['db'] = $db;
        return $db;
    }
	/**
     * 返回其他DB类，$name为config文件的其他段配置
     */
    public function getOtherDb($name) {
        if (isset($this->_classes[$name])) {
            return $this->_classes[$name];
        }
        $db = new CDb($this->$name);
        $this->_classes[$name] = $db;
        return $db;
    }

    /**
     * 返回日志类
     */
    public function getLog() {
        if (isset($this->_classes['log'])) {
            return $this->_classes['log'];
        }
        $clog = new CLog($this->log);
        $this->_classes['log'] = $clog;
        return $clog;
    }

    /**
     * 返回缓存类
     */
    public function getCache($cachetype=null) {
        if (isset($this->_classes['cache']) && empty($cachetype)) {
            return $this->_classes['cache'];
        }
		if(isset($this->_classes['cache_redis'])){
			return $this->_classes['cache_redis'];
		}
		if(!empty($cachetype)){
			$ccache = new CCache($this->$cachetype);
			$this->_classes['cache_redis'] = $ccache;
		}
		else{
			$ccache = new CCache($this->cache);
			$this->_classes['cache'] = $ccache;
		}
        
        return $ccache;
    }
    
    /**
     * 返回CConfig配置类
     */
    public function getConfig() {
        if (isset($this->_classes['config'])) {
            return $this->_classes['config'];
        }
        $cconfig = new CConfig();
        $this->_classes['config'] = $cconfig;
        return $cconfig;
    }

    /**
     * 返回CInput输入类
     */
    public function getInput() {
        if (isset($this->_classes['input'])) {
            return $this->_classes['input'];
        }
        $cinput = new CInput($this->cookie);
        $this->_classes['input'] = $cinput;
        return $cinput;
    }

    /**
     * 获取Api服务实例
     * @param $name
     * @return mixed
     */
    public function getApiServer($name){
        if(isset($this->_classes['apiserver_'.$name])){
            return $this->_classes['apiserver_'.$name];
        }
        $apiserver = Ebh::app()->getConfig()->load('apiserver');
        if(isset($apiserver[$name]) && !empty($apiserver[$name])){
            $ebhClient = Ebh::app()->lib('EbhClient');

            $ebhClient->init($apiserver[$name]['appid'],$apiserver[$name]['appsecret']);

            $ebhClient->setHost($apiserver[$name]['host'])->setFilter(new FilterDemo($apiserver[$name]['appsecret']))->setParser(new ParserDemo());
            $this->_classes['apiserver_'.$name] = $ebhClient;
            return $this->_classes['apiserver_'.$name];
        }

    }

    public function setComponents($components) {
        foreach ($components as $key => $component) {
            $this->setComponent($key, $component);
        }
    }

    public function setComponent($key, $component) {
        if (isset($this->_components[$key]))
            return $this->_components[$key];
        $componentpath = COMPONENT_PATH . $component . '.php';
        if (!file_exists($componentpath)) {
            echo 'component ' . $component . ' is not exists';
            exit();
        }
        require $componentpath;
        $this->_components[$key] = new $component;
        return $this->_components[$key];
    }

    /**
     * 注册核心组件类
     */
    protected function registerCoreComponents() {
        $components = array(
        );

        $this->setComponents($components);
    }
    public function __get($name) {
        if(isset($this->_components[$name]))
            return $this->_components[$name];
        return FALSE;
    }
    
    /**
     * 加载model类
     * @param string $modelname 模板名称
     * @return object model对象
     */
    public function model($modelname) {
        $modelname = ucfirst(strtolower($modelname));
        if(isset($this->_models[$modelname])) {
            return $this->_models[$modelname];
        }
        $modelclass = $modelname.'Model';
        $modelpath = MODEL_PATH.$modelclass.'.php';
    	if(!file_exists($modelpath)) {
                echo 'error:model file not exists:'.$modelpath;
            }
    	require $modelpath;
    	$this->_models[$modelname] = new $modelclass;
    	return $this->_models[$modelname];
    }

    
    /**
     * 加载一个普通lib文件
     */
    public function load($file,$path = ''){
        if($path != ''){
            $path = $path.'/'.$file;
        }else{
            $path = LIB_PATH . $file;
        }
        $filepath = $path . '.php';
        if(file_exists($filepath)){
            require_once($filepath);
        }else{
            echo 'file '.$filepath.'not found!';
        }
    }
}