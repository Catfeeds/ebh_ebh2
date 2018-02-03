<?php

/**
 * Index应用类，适用于不需要控制器的场景
 * 一些直接直接调用的php接口，如http://www.ebanhui.com/ask.php 则会跳过index.php 不会有Uri和控制器的处理
 * 一般可直接调用model类来处理此类请求
 */
class CIndexApplication extends CApplication {

    /**
     * 处理应用请求
     */
    public function processRequest() {

    }

    /**
     *运行访问控制器
     * @param $control string 控制器
     * @param $action string 控制器方法
     */
    public function processAction($control,$action = 'index',$arg = null){
        
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
