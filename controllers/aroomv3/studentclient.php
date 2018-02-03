<?php
/**
 * 课程包
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/11/29
 * Time: 13:33
 */
class studentclientController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 头部链接列表
     */
    public function getClientLinks()
    {
        $ret = $this->apiServer->reSetting()
            ->setService('College.ClientLink.index')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('foradmin', 1)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '未知错误');
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 编辑头部链接
     */
    public function editClientLink() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        $lid = intval($this->input->post('lid'));
        $name = $this->input->post('name');
        $href = $this->input->post('href');
        $target = $this->input->post('target');
        $label = $this->input->post('label');
        $enabled = $this->input->post('enabled');
        $zindex = $this->input->post('zindex');
        $category = $this->input->post('category');
        $params = array(
            'lid' => $lid,
            'crid' => $this->roominfo['crid']
        );
        if ($name !== null) {
            $params['name'] = trim($name);
        }
        if ($href !== null) {
            $params['href'] = trim($href);
        }
        if ($label !== null) {
            $params['label'] = trim($label);
        }
        if ($target !== null) {
            $params['target'] = min(2, max(0, intval($target)));
        }
        if ($enabled !== null) {
            $params['enabled'] = min(1, max(0, intval($enabled)));
        }
        if ($zindex !== null) {
            $params['zindex'] = intval($zindex);
        }
        if ($category !== null) {
            $params['category'] = intval($category);
        }
        $ret = $this->apiServer->reSetting()
            ->setService('College.ClientLink.edit')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(3, '编辑失败');
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 删除头部链接
     */
    public function removeClientLink() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $lid = intval($this->input->post('lid'));
        if ($lid < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('College.ClientLink.delete')
            ->addParams('lid', $lid)
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '头部链接删除失败');
        }
        $this->renderjson(0, '头部链接删除成功');
    }


    /**
     * 移动排序头部链接
     */
    public function sortClientLink() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        $params = array(
            'crid' => $this->roominfo['crid'],
            'lid' => intval($this->input->post('lid')),
            'forword' => min(1, max(0, intval($this->input->post('forword'))))
        );
        if ($params['lid'] < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('College.ClientLink.sort')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret);
    }
}
