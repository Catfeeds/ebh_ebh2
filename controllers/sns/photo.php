<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 14:51
 */
class PhotoController extends SnsBaseController{

    /**
     * 我的照片
     */
    public function index(){
        $this->display('sns/photo_my');
    }

    /**
     * 他人照片页面
     */
    public function view(){
        if($this->curUser == $this->user['uid']){
            header("Location:/sns/photo.html");
        }
        $this->display('sns/photo_view');
    }

    /**
     * 获取照片数据
     */
    public function lists(){
        $uid = intval($this->input->post('uid'));
        if($uid == 0){
            $uid = $this->user['uid'];
        }
        $parameters['uid'] = $uid;
        $page = max(1,intval($this->input->post('page')));
        $format = $this->input->post('format');
        if(!empty($format)){
            $parameters['format'] = $format;
        }

        $parameters['page'] = $page;

        $result =  $this->apiServer->reSetting()->setService('Sns.Photo.list')->addParams($parameters)->request();


        renderjson(0,'',$result);

    }
}