<?php
/**
 * Created by PhpStorm.
 * User: tangzuqiang
 * Date: 2017/10/19
 * Time: 17:04
 */
class IndexController extends  CControl {
   
    public function index()
    {
      $res=@file_get_contents('http://ip.chinaz.com/getip.aspx');
      $ip=explode("'",$res)[1];
      $obj=Ebh::app()->lib('IPaddress');
      $ret = $obj ->find($ip);
      $city=$ret[2];
      echo $city;
    }

    public function index1()
    {
        $aaaModel = $this->model('Aaa');
        $data = $aaaModel->getLists();
        $this->assign('list',$data);
        $this->display('demo/index');
    }

    public function index3()
    {
        $parameters['crid'] = $this->roominfo['crid'];

        $parameters['pagesize'] = 1;
        $parameters['p'] = 1;

        $result =   $ret = $this->apiServer->reSetting()
            ->setService('Demo.Index.index1')
            ->addParams('crid', $this->roominfo['crid'])->request();
        var_dump($result);
    }
}