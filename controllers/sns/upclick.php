<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 13:14
 */
class UpclickController extends SnsBaseController{
    /**
     * 动态点赞接口
     */
    public function feeds(){
        $uid = $this->user['uid'];
        $fid = intval($this->input->post('fid'));
        if($fid<=0){
            renderjson(1,'请选择要点赞的动态');
        }
        $parameters['uid'] = $uid;
        $parameters['fid'] = $fid;

        $result =  $this->apiServer->reSetting()->setService('Sns.Feeds.upclick')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }

        renderjson(0,'点赞成功');
    }

    /**
     * 日志点赞
     */
    public function blog(){
        $uid = $this->user['uid'];
        $bid = intval($this->input->post('bid'));
        if($bid<=0){
            renderjson(1,'请选择点赞的日志');
        }
        $parameters['uid'] = $uid;
        $parameters['bid'] = $bid;

        $result =  $this->apiServer->reSetting()->setService('Sns.Blog.upclick')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }

        renderjson(0,'点赞成功');
    }
}