<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 14:54
 * 动态控制器
 */
class FeedsController extends SnsBaseController{



    /**
     * 默认首页 跳转到自己的页面
     */
    public function index(){

        header("Location:/sns/feeds/my.html");
    }

    /**
     * 我的发表
     */
    public function mypublish(){
        $this->display('sns/mypublish');
    }

    /**
     * 我的页面
     */
    public function my(){
        $this->curUser = $this->user['uid'];
        $this->display('sns/feeds_my');
    }

    /**
     * 最新动态
     */
    public function newlists(){
        $firstfid = intval($this->input->post('firstfid'));
        $type= $this->input->post('t');
        $len = intval($this->input->post('len'));
        if(empty($type)){
            $type = 'myschool';
        }
        $format = $this->input->post('format');
        $parameters['uid'] = $this->user['uid'];
        $parameters['firstfid'] = $firstfid;
        $parameters['type'] = $type;
        $parameters['len'] = $len;
        if(!empty($format)){
            $parameters['format'] = $format;
        }

        $result =  $this->apiServer->reSetting()->setService('Sns.Feeds.getNewFeeds')->addParams($parameters)->request();


        renderjson(0,'',$result);
    }
    /**
     * 获取最新的动态推送
     */
    public function push(){
        $firstfid = intval($this->input->post('firstfid'));
        $type= $this->input->post('t');
        $newfidarr = $this->input->post("newfidarr");
        if(empty($type)){
            $type = 'myschool';
        }
        $parameters['uid'] = $this->user['uid'];
        $parameters['firstfid'] = $firstfid;
        $parameters['type'] = $type;
        if(!empty($newfidarr)){
            $parameters['newfidarr'] = $newfidarr;
        }


        $result =  $this->apiServer->reSetting()->setService('Sns.Feeds.pushCount')->addParams($parameters)->request();

        renderjson(0,'',$result);
    }

    /**
     * 获取列表异步数据
     */
    public function lists(){
        $lastFid = intval($this->input->post('lastfid'));
        $type = $this->input->post('type');
        if(!isset($lastFid)){
            $lastFid = 0;
        }
        if(empty($type)){
            $type = 'myschool';
        }
        $format = $this->input->post('format');
        $parameters['uid'] = $this->user['uid'];
        $parameters['lastfid'] = $lastFid;
        $parameters['type'] = $type;
        if(!empty($format)){
            $parameters['format'] = $format;
        }

        $result =  $this->apiServer->reSetting()->setService('Sns.Feeds.list')->addParams($parameters)->request();


        renderjson(0,'',$result);

    }

    /**
     * 获取他人列表
     */
    public function getonelists(){
        $lastFid = intval($this->input->post('lastfid'));
        $uid = intval($this->input->post('uid'));
        $format = $this->input->post('format');
        $parameters['uid'] = $uid;
        $parameters['lastfid'] = $lastFid;
        if(!empty($format)){
            $parameters['format'] = $format;
        }

        $result =  $this->apiServer->reSetting()->setService('Sns.Feeds.getOneFeeds')->addParams($parameters)->request();


        renderjson(0,'',$result);
    }

    /**
     * 动态页面
     */
    public function view(){
        if($this->curUser == $this->user['uid']){
            header("Location:/sns/feeds/my.html");
        }
        $this->display('sns/feeds_view');
    }



    /**********************************我的操作**********************/

    /**
     * 删除动态
     */
    public function del(){
        $fid = intval($this->input->post('fid'));
        if($fid<=0){
            renderjson(1,'请选择需要删除的动态');
        }

        $parameters['uid'] = $this->user['uid'];
        $parameters['fid'] = $fid;

        $result =  $this->apiServer->reSetting()->setService('Sns.Feeds.del')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'删除成功');
    }

}