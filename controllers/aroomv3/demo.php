<?php
/**
 * ebh2.
 * Author: jw
 * Email: 345468755@qq.com
 */
class DemoController extends ARoomV3Controller{
    public function index(){
        $roominfo = Ebh::app()->room->getcurroom();
        $data['crid'] = $roominfo['crid'];
        $data['uid'] = $this->user['uid'];
        $data['p'] = 1;
        $result = $this->apiServer->reSetting()->setService('Forums.Forums.frontAllForumList')->addParams($data)->request();

        $this->renderjson(0,'',$result);
    }
}