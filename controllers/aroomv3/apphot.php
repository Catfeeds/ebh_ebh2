<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 10:21
 */
class ApphotController extends ARoomV3Controller {
    /**
     * 获取热门课程列表
     */
    public function folders(){
        $parameters['uid'] = 0;
        $parameters['crid'] = $this->roominfo['crid'];
        $q = $this->input->post('q');
        $parameters['q'] = !empty($q) ? h($this->input->post('q')) : '';
        $pid = $this->input->post('pid');
        $sid = $this->input->post('sid');
        if(!empty($pid)){
            $parameters['pid'] = intval($pid);
        }
        if(!empty($sid)){
            $parameters['sid'] = intval($sid);
        }
        $parameters['num'] = -1;
        $parameters['onlylist'] = 1;
        $result =  $this->apiServer->reSetting()->setService('Classroom.Folder.hot')->addParams($parameters)->request();

        $this->renderjson(0,'',$result);
    }

    /**
     * 设置课程人气
     */
    public function setview(){
        $parameters['crid'] = $this->roominfo['crid'];
        $parameters['folderid'] = intval($this->input->post('folderid'));
        $parameters['viewnum'] = intval($this->input->post('viewnum'));
        $result =  $this->apiServer->reSetting()->setService('App.Hot.setFolderViewNum')->addParams($parameters)->request();
        if($result['status'] == 0){
            $this->renderjson(1,$result['msg']);
        }
        $this->renderjson(0,'设置成功');
    }
}