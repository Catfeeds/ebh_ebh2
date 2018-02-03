<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 13:13
 */
class FollowController extends SnsBaseController {
    /**
     * 我的关注
     */
    public function index() {
        $parsequery = parsequery();

        $parameters['uid'] = $this->user['uid'];
        $parameters['target'] = $this->user['uid'];
        $parameters['page'] = max(1, $parsequery['page']);
        $parameters['pagesize'] = 10;
        $result =  $this->apiServer->reSetting()->setService('Sns.Follow.follow')->addParams($parameters)->request();

        $pagebar = show_page($result['count'],10);
        $this->assign("pagebar", $pagebar);
        $this->assign("follows", $result['follows']);
        $this->display('sns/follow_my');
    }

    /**
     * 我的粉丝
     */
    public function fans(){
        $parsequery = parsequery();
        $parameters['uid'] = $this->user['uid'];
        $parameters['target'] = $this->user['uid'];
        $parameters['page'] = max(1, $parsequery['page']);
        $parameters['pagesize'] = 10;
        $result =  $this->apiServer->reSetting()->setService('Sns.Follow.fans')->addParams($parameters)->request();

        $pagebar = show_page($result['count'],10);
        $this->assign("pagebar", $pagebar);
        $this->assign("fans", $result['fans']);
        $this->display('sns/fans_my');
    }


    /**
     * 关注用户
     */
    public function follow(){
        $parameters['uid'] = $this->user['uid'];
        $parameters['fuid'] = intval($this->input->post('fuid'));
        if($parameters['fuid'] == $parameters['uid']){
            renderjson(1,'你不能关注自己');
        }
        if($parameters['fuid'] <= 0){
            renderjson(1,'参数错误');
        }

        $result =  $this->apiServer->reSetting()->setService('Sns.Follow.addFollow')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'关注成功');
    }

    /**
     * 取消关注
     */
    public function cancel(){
        $parameters['uid'] = $this->user['uid'];
        $parameters['fuid'] = intval($this->input->post('fuid'));
        if($parameters['fuid'] <= 0){
            renderjson(1,'参数错误');
        }
        $type = $this->input->post('type');

        if($type != 'follow' && $type != 'fans'){
            renderjson(1,'参数错误');
        }
        $parameters['type'] = $type;

        $result =  $this->apiServer->reSetting()->setService('Sns.Follow.cancel')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'取消成功');
    }
}