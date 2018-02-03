<?php
/**
 * 网校装扮
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/12/04
 * Time: 13:33
 */
class designController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取网校装扮
     */
    public function index()
    {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Design.getDesignList')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('roomtype', Ebh::app()->room->getRoomType())
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 删除网校装扮
     */
    public function delete() {
        if (!$this->isPost()) {
            renderjson(1, '非法访问');
        }
        $did = intval($this->input->post('did'));
        if (empty($did) || ($did < 1)) {
            renderjson(1, '参数错误');
        }
        //获取原首页装扮信息
        $designinfo = $this->apiServer->reSetting()->setService('Aroomv3.Design.getDesignByDid')->addparams(array('did'=>$did))->request();

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Design.deleteDesign')
            ->addparams('did', $did)
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('roomtype', Ebh::app()->room->getRoomType())
            ->request();
        if ($ret === false) {
            renderjson(2, '删除失败');
        }
        renderjson(0, '', $ret,false);

        fastcgi_finish_request();
        //删除装扮操作成功后记录到操作日志
        if (!empty($did) && !empty($designinfo['name']) && isset($designinfo['client_type'])) {
            $logdata = array();
            $logdata['toid'] = $did;
            $logdata['title'] = h($designinfo['name']);
            $logdata['clientType'] = ($designinfo['client_type'] == 1) ? '手机' : '电脑';
            Ebh::app()->lib('OperationLog')->addLog($logdata,'deldesign');
        }
    }

    /**
     * 编辑网校装扮
     */
    public function edit() {
        if (!$this->isPost()) {
            renderjson(1, '非法访问');
        }
        $did = intval($this->input->post('did'));
        $params = array(
            'name' => trim($this->input->post('name')),
            'remark' => trim($this->input->post('remark')),
            'crid' => $this->roominfo['crid'],
            'roomtype' => Ebh::app()->room->getRoomType(),
            'clientType' => intval($this->input->post('client_type'))
        );
        if ($did > 0) {
            $params['did'] = $did;
            //获取原首页装扮信息
            $designinfo = $this->apiServer->reSetting()->setService('Aroomv3.Design.getDesignByDid')->addparams(array('did'=>$did))->request();
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Design.editDesign')
            ->addparams($params)
            ->request();
        if ($ret === false) {
            renderjson(2, $did > 1 ? '修改失败' : '新建失败');
        }
        renderjson(0, '', $ret,false);

        fastcgi_finish_request();
        if (!empty($did) && ($did > 0)) {
            //编辑装扮操作成功后记录到操作日志
            if (!empty($params['name']) && !empty($designinfo['name']) && isset($designinfo['client_type'])) {
                $logdata = array();
                $logdata['toid'] = $did;
                $logdata['oldtitle'] = h($designinfo['name']);//原装扮名称
                $logdata['title'] = h($params['name']);       //新装扮名称
                $logdata['clientType'] = ($designinfo['client_type'] == 1) ? '手机' : '电脑';
                Ebh::app()->lib('OperationLog')->addLog($logdata,'editdesign');
            }
        }else{
            //添加装扮操作成功后记录到操作日志
            if (!empty($ret) && !empty($params['name']) && isset($params['clientType'])) {
                $logdata = array();
                $logdata['toid'] = intval($ret);
                $logdata['title'] = h($params['name']);
                $logdata['clientType'] = ($params['clientType'] == 1) ? '手机' : '电脑';
                Ebh::app()->lib('OperationLog')->addLog($logdata,'adddesign');
            }
        }
    }

    /**
     * 选择装扮
     */
    public function choose() {
        if (!$this->isPost()) {
            renderjson(1, '非法访问');
        }
        $did = intval($this->input->post('did'));
        if ($did < 0) {
            renderjson(2, '参数错误');
        }
        $checked = $this->input->post('checked');
        $params = array(
            'did' => $did,
            'crid' => $this->roominfo['crid'],
            'roomtype' => Ebh::app()->room->getRoomType(),
            'clientType' => min(1, max(0, intval($this->input->post('client_type')))),
            'checked' => $checked === null ? true : $checked > 0
        );
        if ($did > 0) {
            $params['did'] = $did;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Design.chooseDesign')
            ->addparams($params)
            ->request();
        if ($ret === false) {
            renderjson(3, '选择失败');
        }
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        $roomcache = Ebh::app()->lib('Roomcache');
        $roomcache->removeCache(0, 'roominfo', $domain);
        renderjson(0, '',array(),false);

        //启用装扮操作成功后记录到操作日志
        fastcgi_finish_request();
        //获取原首页装扮信息
        $logdata = array();
        if(isset($did) && ($did==0)){       //启用默认版首页装扮时获取参数
            $logdata['toid'] = $this->roominfo['crid'];
            $logdata['title'] = '老板首页装扮';
        }else{      //启用自定义首页装扮时获取参数
            $designinfo = $this->apiServer->reSetting()->setService('Aroomv3.Design.getDesignByDid')->addparams(array('did'=>$did))->request();
            if (!empty($designinfo['name'])) {
                $logdata['toid'] = $did;
                $logdata['title'] = h($designinfo['name']);
            }
        }
        if (!empty($logdata['title']) && !empty($logdata['toid']) && isset($params['clientType'])) {
            $logdata['clientType'] = ($params['clientType'] == 1) ? '手机' : '电脑';
            $operation = empty($params['checked']) ? 'canceldesign' : 'choosedesign';//取消和启用装扮
            Ebh::app()->lib('OperationLog')->addLog($logdata,$operation);
        }
    }
}