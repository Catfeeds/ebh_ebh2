<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 10:16
 */
class CommentController extends SnsBaseController{
    /**
     * 动态评论
     */
    public function feeds(){
        $uid = $this->user['uid'];
        $fid = intval($this->input->post('fid'));
        $content = h(strip_tags($this->input->post('content')));

        $touid = intval($this->input->post('touid'));
        $pcid = intval($this->input->post('pcid'));
        $touid = $touid>0?$touid:$uid;
        $pcid = $pcid>0?$pcid:0;


        if($fid<=0){
            renderjson(1,'回复的动态不存在');
        }
        //检查字数
        if(strlen($content)>500*3){
            renderjson(1,'已超过最大限制500字',array('len'=>mb_strlen($content,'utf8'),'html'=>''));
        }
        $this->checkSensitive($content);
        $format = $this->input->post('format');
        if(!empty($format)){
            $parameters['format'] = $format;
        }
        $parameters['uid'] = $uid;
        $parameters['fid'] = $fid;
        $parameters['content'] = $content;
        $parameters['touid'] = $touid;
        $parameters['pcid'] = $pcid;
        $parameters['ip'] = $this->input->getip();
        $parameters['format'] = $format;

        $result =  $this->apiServer->reSetting()->setService('Sns.Comment.feeds')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }

        renderjson(0,'',$result['data']);
    }

    /**
     * 删除动态评论
     */
    public function delfeeds(){
        $cid = intval($this->input->post('cid'));
        if($cid<=0){
            renderjson(1,'请选择需要删除的评论');
        }

        $parameters['uid'] = $this->user['uid'];
        $parameters['cid'] = $cid;

        $result =  $this->apiServer->reSetting()->setService('Sns.Comment.delFeeds')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'删除成功');
    }

    /**
     * 获取动态评论列表
     */
    public function feedslist(){
        $fid = intval($this->input->post('fid'));
        $lastcid = intval($this->input->post('lastcid'));
        $uid = $this->user['uid'];
        if($fid<=0){
            renderjson(1,'参数错误');
        }
        $parameters['uid'] = $uid;
        $parameters['fid'] = $fid;
        $parameters['lastcid'] = $lastcid;
        $format = $this->input->post('format');
        if(!empty($format)){
            $parameters['format'] = $format;
        }
        $result =  $this->apiServer->reSetting()->setService('Sns.Comment.getFeedsList')->addParams($parameters)->request();

        renderjson(0,'',$result);
    }

    /**
     * 获取日志评论立碑奥
     */
    public function bloglist(){
        $bid = intval($this->input->post('bid'));
        $lastcid = intval($this->input->post('lastcid'));
        $uid = $this->user['uid'];
        if($bid<=0){
            renderjson(1,'参数错误');
        }
        $parameters['uid'] = $uid;
        $parameters['bid'] = $bid;
        $parameters['lastcid'] = $lastcid;
        $format = $this->input->post('format');
        if(!empty($format)){
            $parameters['format'] = $format;
        }
        $result =  $this->apiServer->reSetting()->setService('Sns.Comment.getBlogList')->addParams($parameters)->request();

        renderjson(0,'',$result);
    }
    /**
     * 日志评论
     */
    public function blog(){
        $uid = $this->user['uid'];
        $bid = intval($this->input->post('bid'));
        $content = h(strip_tags($this->input->post('content')));

        $touid = intval($this->input->post('touid'));
        $pcid = intval($this->input->post('pcid'));
        $touid = $touid>0?$touid:$uid;
        $pcid = $pcid>0?$pcid:0;


        if($bid<=0){
            renderjson(1,'回复的日志不存在');
        }
        //检查字数
        if(strlen($content)>500*3){
            renderjson(1,'已超过最大限制500字',array('len'=>mb_strlen($content,'utf8'),'html'=>''));
        }
        $this->checkSensitive($content);
        $format = $this->input->post('format');
        if(!empty($format)){
            $parameters['format'] = $format;
        }
        $parameters['uid'] = $uid;
        $parameters['bid'] = $bid;
        $parameters['content'] = $content;
        $parameters['touid'] = $touid;
        $parameters['pcid'] = $pcid;
        $parameters['ip'] = $this->input->getip();
        $parameters['format'] = $format;

        $result =  $this->apiServer->reSetting()->setService('Sns.Comment.blog')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }

        renderjson(0,'',$result['data']);
    }

    /**
     * 删除日志评论
     */
    public function delblog(){
        $cid = intval($this->input->post('cid'));
        if($cid<=0){
            renderjson(1,'请选择需要删除的评论');
        }

        $parameters['uid'] = $this->user['uid'];
        $parameters['cid'] = $cid;

        $result =  $this->apiServer->reSetting()->setService('Sns.Comment.delBlog')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'删除成功');
    }



}