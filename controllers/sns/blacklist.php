<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 14:07
 */
class BlacklistController extends SnsBaseController{
    /**
     * 我的黑名单
     */
    public function index(){
        $parsequery = parsequery();
        $parameters['uid'] = $this->user['uid'];
        $parameters['target'] = $this->user['uid'];
        $parameters['page'] = max(1, $parsequery['page']);
        $parameters['pagesize'] = 10;
        $result =  $this->apiServer->reSetting()->setService('Sns.BlackList.list')->addParams($parameters)->request();

        $pagebar = show_page($result['count'],10);
        $this->assign('total',$result['total']);
        $this->assign("pagebar", $pagebar);
        $this->assign("blacklists", $result['blacklists']);
        $this->display('sns/blacklist_my');
    }

    /**
     * 添加黑名单
     */
    public function add(){
        $parameters['uid'] = $this->user['uid'];
        $parameters['fuid'] = intval($this->input->post('fuid'));
        if($parameters['fuid'] == $parameters['uid']){
            renderjson(1,'你不能把自己加入黑名单');
        }
        if($parameters['fuid'] <= 0){
            renderjson(1,'参数错误');
        }

        $result =  $this->apiServer->reSetting()->setService('Sns.BlackList.add')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'添加成功');
    }

    /**
     * 解除黑名单
     */
    public function cancel(){
        $parameters['uid'] = $this->user['uid'];
        $parameters['fuid'] = intval($this->input->post('fuid'));
        if($parameters['fuid'] <= 0){
            renderjson(1,'参数错误');
        }

        $result =  $this->apiServer->reSetting()->setService('Sns.BlackList.cancel')->addParams($parameters)->request();

        if($result['status'] == 0){
            renderjson(1,$result['msg']);
        }
        renderjson(0,'解除成功');
    }
}