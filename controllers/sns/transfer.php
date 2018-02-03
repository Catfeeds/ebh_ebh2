<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 12:01
 */
class TransferController extends SnsBaseController{


    /**
     * 转发动态接口
     */
    public function feeds(){
        $fid = intval($this->input->post('pfid'));

        if($fid <= 0){
            renderjson(1,'请选择需要转发的内容');
        }
        $content = h(strip_tags(trim($this->input->post('content'))));
        //检查字数
        if(strlen($content)>500*3){
            renderjson(1,'已超过最大限制500字',array('html'=>'','len'=>mb_strlen($content,'utf8')));
        }

        $this->checkSensitive($content);
        $parameters['content'] = $content;
        $parameters['uid'] = $this->user['uid'];
        $parameters['ip'] = $this->input->getip();
        $parameters['fid'] = $fid;
        $format = $this->input->post('format');
        if(!empty($format)){
            $parameters['format'] = $format;
        }

        $result =  $this->apiServer->reSetting()->setService('Sns.Feeds.transfer')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }

        renderjson(0,'发布成功',$result['data']);
    }

    /**
     * 转载日志
     */
    public function blog(){
        $bid = intval($this->input->post('bid'));
        $cate =  intval($this->input->post('cate'));
        $permission =  intval($this->input->post('permission'));
        if($bid <= 0){
            renderjson(1,'请选择需要转载的日志');
        }
        $parameters['uid'] = $this->user['uid'];
        $parameters['bid'] = $bid;
        $parameters['cate'] = $cate;
        $parameters['permission'] = $permission;
        $parameters['ip'] = $this->input->getip();
        $result =  $this->apiServer->reSetting()->setService('Sns.Blog.transfer')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }

        renderjson(0,'转载成功');
    }
}