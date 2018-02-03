<?php
/**
 * Created by PhpStorm.
 * User: Yun
 * Date: 2017/6/13
 * Time: 17:49
 * 记录用户注册信息
 */
class RegisterLog{
    //记录一个用户注册日志
    public function addOneRegisterLog($logdata){
        if(empty($logdata['uid'])){
            return FALSE;
        }
        $llmodel = Ebh::app()->model('Loginlog');
        $client = array();
        $client = $this->getSystemInfo();
        $client['uid'] = $logdata['uid'];
        if(isset($logdata['logtype']) && !empty($logdata['logtype'])){
            $client['logtype'] = $logdata['logtype'];
        }
        if(isset($logdata['othertype']) && !empty($logdata['othertype'])){
            $client['othertype'] = $logdata['othertype'];
        }
        if(isset($logdata['crid']) && !empty($logdata['crid'])){
            $client['crid'] = $logdata['crid'];
        }
        return $llmodel->addOneRegisterLog($client);
    }

    //一次记录多个用户注册信息
    public function addMultipleRegisterLog($logdatas){
        if(!isset($logdatas) || empty($logdatas)){
            return FALSE;
        }
        $client = array();
        $llmodel = Ebh::app()->model('Loginlog');
        $client = $this->getsysteminfo();
        return $llmodel->addMultipleRegisterLog($client,$logdatas);
    }

    //获取当前用户系统信息
    public function getSystemInfo(){
        $input = Ebh::app()->getInput();
        $client = $input->getClient();
        if(empty($client)){
            $client = array();
        }
        $screen = '';
        if(NULL !== $input->cookie('sc')){
            $screen = $input->cookie('sc');
        }
        $client['screen'] = $screen;
        if(strtolower($client['browser']) == 'ie'){
            if(!empty($client['vendor'])){//ie内核的其他浏览器不记版本
                $client['broversion'] = '';
            }
            $client['browser'] = $client['browser'].$client['broversion'];
        }
        if(!empty($client['vendor'])){
            if(strtolower($client['browser']) == 'chrome'){//chrome内核的其他浏览器不记版本
                $client['broversion'] = '';
            }
            $client['browser'] = $client['vendor'];
        }
        $client['ismobile'] = in_array($client['system'], array('iPad','iPhone','Android')) ? 1 : 0;

        //查询citycode
        $iplib = Ebh::app()->lib('IPaddress');
        $address = $iplib->find($client['ip']);//101.69.252.186
        $llmodel = Ebh::app()->model('Loginlog');
        if(!empty($address) && $address[0] == '中国'){
            $cityname = empty($address[2])?$address[1]:$address[2];
            $city = $llmodel->getCityByName($cityname);
            if(!empty($city)){
                $spcityarr = array('11','12','31','50');
                if(in_array($city['citycode'],$spcityarr)){//直辖市,编号加01
                    $city['citycode'] = $city['citycode'].'01';
                }
                //同时记录省市编号
                $client['citycode'] = $city['citycode'];
                $client['parentcode'] = substr($city['citycode'],0,2);
            }
            $ispModel = Ebh::app()->model('Isp');//查询网络提供商
            $ispType = $ispModel->getIspType($client['ip']);
            $client['isp'] = $ispType;
        }

        return $client;
    }
}