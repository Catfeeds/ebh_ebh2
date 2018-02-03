<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 10:10
 */
class AppsliderController extends ARoomV3Controller {
    public function add(){
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['name'] = $this->input->post('name');
        $parameters['image_url'] = $this->input->post('image_url');
        $parameters['type'] = $this->input->post('type');
        $parameters['link_value'] = $this->input->post('link_value');
        if(empty($parameters['link_value'])){
            $parameters['link_value'] = array();
        }
        $parameters['displayorder'] = $this->input->post('displayorder');


        if(empty($parameters['name'])){
            $this->renderjson(1, '轮播图名称必须填写');
        }
        if(empty($parameters['image_url'])){
            $this->renderjson(1, '请上传你的图片');
        }
        if(empty($parameters['type'])){
            $this->renderjson(1, '请选择你的链接类型');
        }
        if($parameters['type'] != 'none' && empty($parameters['link_value'])){
            $this->renderjson(1, '请选择你的链接地址');
        }

        $result =  $this->apiServer->reSetting()->setService('App.Slider.add')->addParams($parameters)->request();
        if($result['status'] == 0){
            $this->renderjson(1,$result['msg']);
        }

        $this->renderjson(0,'添加成功',array('id'=>$result['data']['id']));

    }

    /**
     * 编辑
     */
    public function edit(){
        $parameters['crid'] = $this->roominfo['crid'];
        $id = intval($this->input->post('id'));
        if($id <= 0){
            $this->renderjson(1, '参数错误');
        }

        $parameters['id'] = $id;
        $name = $this->input->post('name');
        if(!empty($name)){
            $parameters['name'] = $name;
        }

        $image_url = $this->input->post('image_url');
        if(!empty($image_url)){
            $parameters['image_url'] = $image_url;
        }

        $type = $this->input->post('type');
        if(!empty($type)){
            $parameters['type'] = $type;
        }

        $link_value = $this->input->post('link_value');
        if(!empty($link_value)){
            $parameters['link_value'] = $link_value;
        }

        $displayorder = $this->input->post('displayorder');
        if(!isset($displayorder)){
            $parameters['displayorder'] = $displayorder;
        }

        $result =  $this->apiServer->reSetting()->setService('App.Slider.edit')->addParams($parameters)->request();
        if($result['status'] == 0){
            $this->renderjson(1,$result['msg']);
        }

          $this->renderjson(0,'编辑成功');

    }

    /**
     * 读取列表
     */
    public function lists(){
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $result = $this->apiServer->reSetting()->setService('App.Slider.list')->addParams($parameters)->request();
        $this->renderjson(0,'',$result);
    }


    /**
     * 删除
     */
    public function del(){
        $id = intval($this->input->post('id'));
        if($id <= 0){
            $this->renderjson(1, '请选择要删除的轮播图');
        }
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['id'] = $id;

        $result =  $this->apiServer->reSetting()->setService('App.Slider.del')->addParams($parameters)->request();
        if($result['status'] == 0){
            $this->renderjson(1,$result['msg']);
        }

        $this->renderjson(0,'删除成功');
    }


}