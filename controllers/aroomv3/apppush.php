<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 14:42
 */
class ApppushController extends ARoomV3Controller {

    /**
     * 添加推送消息
     */
    public function add(){
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['message'] = $this->input->post('message');
        $parameters['link_value'] = $this->input->post('link_value');
        $parameters['type'] = $this->input->post('type');
        if(empty($parameters['link_value'])){
            $parameters['link_value'] = array();
        }
        $parameters['pushtime'] = $this->input->post('pushtime');


        if(empty($parameters['message'])){
            $this->renderjson(1, '推送消息必须填写');
        }
        if(empty($parameters['pushtime'])){
            $this->renderjson(1, '推送时间必须选择');
        }
        if(empty($parameters['type'])){
            $this->renderjson(1, '请选择你的链接类型');
        }
        if($parameters['type'] != 'none' && empty($parameters['link_value'])){
            $this->renderjson(1, '请选择你的链接地址');
        }

        $result =  $this->apiServer->reSetting()->setService('App.Push.add')->addParams($parameters)->request();
        if($result['status'] == 0){
            $this->renderjson(1,$result['msg']);
        }

        $this->renderjson(0,'添加成功',array('id'=>$result['data']['pid']));

    }


    /**
     * 读取列表
     */
    public function lists(){
        $status = $this->input->post('status');

        if($status !== null){
            $parameters['status'] = $status;
        }
        $parameters['crid'] = $this->roominfo['crid'];
        $pageArr = $this->getPageInfo();
        $parameters['pagesize'] = $pageArr['pagesize'];
        $parameters['p'] = $pageArr['pagenum'];
        $result = $this->apiServer->reSetting()->setService('App.Push.list')->addParams($parameters)->request();
        $this->renderjson(0,'',$result);
    }


    /**
     * 删除
     */
    public function del(){
        $pid = intval($this->input->post('pid'));
        if($pid <= 0){
            $this->renderjson(1, '请选择要删除的推送内容');
        }
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['pid'] = $pid;

        $result =  $this->apiServer->reSetting()->setService('App.Push.del')->addParams($parameters)->request();
        if($result['status'] == 0){
            $this->renderjson(1,$result['msg']);
        }

        $this->renderjson(0,'删除成功');
    }
}