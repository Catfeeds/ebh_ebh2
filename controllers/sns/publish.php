<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 15:53
 */
class PublishController extends SnsBaseController{


    /**
     * 发布操作
     */
    public function index(){
        $content = h(strip_tags(trim($this->input->post('content'))));
        $parameters['images'] = $this->input->post('imgids');
        //发表的字数限制2000字内
        if(strlen($content)>2000*3){
            renderjson(1,'已超过最大限制字数1000字',array(
               'html'   =>  '',
                'len'=>mb_strlen($content,'utf8')
            ));
        }
        if(count($parameters['images']) > 9){
            renderjson(1,'不能多于九张图片');
        }
        $this->checkSensitive($content);

        //存图片
        if(count($parameters['images'])){
            $this->apiServer->reSetting()->setService('Sns.Image.deal')->addParams(array('images'=>$parameters['images'],'uid'=>$this->user['uid']))->request();
        }

        if(!empty($parameters['images'])){
            $parameters['images'] = implode(',',$parameters['images']);
        }else{
            unset($parameters['images']);
        }

        $format = $this->input->post('format');
        if(!empty($format)){
            $parameters['format'] = $format;
        }
        $parameters['content'] = $content;
        $parameters['uid'] = $this->user['uid'];
        $parameters['ip'] = $this->input->getip();

        $result =  $this->apiServer->reSetting()->setService('Sns.Feeds.publish')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }

        renderjson(0,'发布成功',$result['data']);
    }


    /**
     * 上传图片
     */
    public function upload(){
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $url = $_UP['snspic']['server'][0];
        $savepath = $_UP['snspic']['savepath'];
        $showpath = $_UP['snspic']['showpath'];
        $data = $_POST;

        $result = do_post($url, $data);

        //返回的图片信息
        $imgarr = json_decode($result,1);
        $parameters['img'] = $imgarr;
        $parameters['uid'] = $this->user['uid'];
        $parameters['ip'] = $this->input->getip();
        $result =  $this->apiServer->reSetting()->setService('Sns.Image.add')->addParams($parameters)->request();
        echo json_encode($result);
    }

    /**
     * 删除图片
     */
    public function delimg(){
        $gid = intval($this->input->post('gid'));
        $parameters['gid'] = $gid;
        $parameters['uid'] = $this->user['uid'];
        $result =  $this->apiServer->reSetting()->setService('Sns.Image.del')->addParams($parameters)->request();

        if($result['success']){
            renderjson(0,'删除成功');
        }else{
            renderjson(1,'删除失败');
        }
    }


}