<?php
/**
 * 流量分析
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/4/25
 * Time: 13:10
 */
class flowrateController extends CControl
{
	private $apiServer;
	private $roominfo;
	
    public function __construct()
    {
        parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo '用户未登陆';
			exit;
		}
		$this->apiServer = Ebh::app()->getApiServer('ebh');
		$this->roominfo = Ebh::app()->room->getcurroom();
    }
	/*
	学习环境
	*/
	public function view(){
		$this->display('college/systemenvironment');
	}
    public function index() {
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
		
        if ($starttime !== NULL) {
            $starttime = is_numeric($starttime) ? max(0, intval($starttime)) : strtotime($starttime);
            $starttime = strtotime(date('Y-m-d', $starttime));
        }
        if ($endtime !== NULL) {
            $endtime = is_numeric($endtime) ? max(0, intval($endtime)) : strtotime($endtime);
            $endtime = strtotime(date('Y-m-d 23:59:59', $endtime));
        }
        if (!empty($endtime) && !empty($starttime) && $starttime > $endtime) {
            $this->renderjson(0, '', array());
        }
        $params = array('crid' => $this->roominfo['crid']);
        if (!empty($starttime)) {
            $params['starttime'] = $starttime;
            //echo date('Y-m-d H:i:s', $starttime)."\n";
        }
        if (!empty($endtime)) {
            $params['endtime'] = $endtime;
            //echo date('Y-m-d H:i:s', $endtime)."\n";
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.FlowRate.index')
            ->addParams($params)
            ->request();
        
		
        //print_r($ret);exit;
        $this->renderjson(0, '', $ret);
    }

    
    /**
     * 屏幕分辨率分析
     */
    public function screen() {
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
		
        if ($starttime !== NULL) {
            $starttime = is_numeric($starttime) ? max(0, intval($starttime)) : strtotime($starttime);
            $starttime = strtotime(date('Y-m-d', $starttime));
        }
        if ($endtime !== NULL) {
            $endtime = is_numeric($endtime) ? max(0, intval($endtime)) : strtotime($endtime);
            $endtime = strtotime(date('Y-m-d 23:59:59', $endtime));
        }
        if (!empty($endtime) && !empty($starttime) && $starttime > $endtime) {
            $this->renderjson(0, '', array());
        }
        $params = array('crid' => $this->roominfo['crid']);
        if (!empty($starttime)) {
            $params['starttime'] = $starttime;
            //echo date('Y-m-d H:i:s', $starttime)."\n";
        }
        if (!empty($endtime)) {
            $params['endtime'] = $endtime;
            //echo date('Y-m-d H:i:s', $endtime)."\n";
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.FlowRate.screen')
            ->addParams($params)
            ->request();
        
        if (!empty($ret)) {
            unset($ret['']);
            if (empty($ret)) {
                $this->renderjson(0, '', array());
            }
            $len = count($ret);
            if ($len == 1) {
                $ret = array_values($ret);
                $ret[0]['scale'] = 100;
            } else {
                //按分辨率降序排列
                /*$orderParams = array_map(function($screen) {
                    list($width, $height) = explode('x', $screen['screen']);
                    return intval($width) * intval($height);
                }, $ret);*/

                $max = 8;
                if ($len > $max) {
                    $tmp = array_slice($ret, --$max);
                    $ret = array_slice($ret, 0, $max);
                    $counts = array_column($tmp, 'count');
                    $ret[] = array(
                        'screen' => '其他',
                        'count' => array_sum($counts)
                    );
                    unset($tmp, $counts);
                }
                $counts = array_column($ret, 'count');
                $sum = array_sum($counts);
                $lastItem = array_pop($ret);
                array_walk($ret, function(&$item, $k, $sum) {
                    $item['scale'] = round($item['count'] * 100 / $sum,1);
                }, $sum);
                $scales = array_column($ret, 'scale');
                $scales = array_sum($scales);
                $lastItem['scale'] = round(100 - $scales, 1);
                $ret[] = $lastItem;
                $counts = array_column($ret, 'scale');
                array_multisort($counts, SORT_DESC, SORT_NUMERIC, $ret);
                unset($counts);
                array_walk($ret, function(&$item) {
                    $item['scale'] = sprintf('%01.1f', $item['scale']);
                });
            }
        }
        $ret = array_values($ret);
        $this->renderjson(0, '', $ret);
    }

    /**
     * 网络设备分析
     */
    public function os() {
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
		
        if ($starttime !== NULL) {
            $starttime = is_numeric($starttime) ? max(0, intval($starttime)) : strtotime($starttime);
            $starttime = strtotime(date('Y-m-d', $starttime));
        }

        if ($endtime !== NULL) {
            $endtime = is_numeric($endtime) ? max(0, intval($endtime)) : strtotime($endtime);
            $endtime = strtotime(date('Y-m-d 23:59:59', $endtime));
        }
        if (!empty($endtime) && !empty($starttime) && $starttime > $endtime) {
            $this->renderjson(0, '', array());
        }
        $params = array('crid' => $this->roominfo['crid']);
        if (!empty($starttime)) {
            $params['starttime'] = $starttime;
            //echo date('Y-m-d H:i:s', $starttime)."\n";
        }
        if (!empty($endtime)) {
            $params['endtime'] = $endtime;
            //echo date('Y-m-d H:i:s', $endtime)."\n";
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.FlowRate.os')
            ->addParams($params)
            ->request();
        
		
        $max = 5;
        if (!empty($ret)) {
            $pc = $mobile = array();
            $pcCount = $mobileCount = 0;
            foreach ($ret as $item) {
                if (!empty($item['ismobile'])) {
                    unset($item['ismobile']);
                    $mobile[] = $item;
                    $mobileCount += $item['count'];
                    continue;
                }
                unset($item['ismobile']);
                $pc[] = $item;
                $pcCount += $item['count'];
            }
            $pc = $this->setScale($pc, $max, 'system');
            $mobile = $this->setScale($mobile, $max, 'system');
            $pcScale = round($pcCount * 100 / ($pcCount + $mobileCount), 1);

            //排序
            $pcCounts = array_column($pc, 'scale');
            $mobileCounts = array_column($mobile, 'scale');
            array_multisort($pcCounts, SORT_DESC, SORT_NUMERIC, $pc);
            array_multisort($mobileCounts, SORT_DESC, SORT_NUMERIC, $mobile);
            unset($pcCounts, $mobileCounts);

            $ret = array(
                'pcCount' => $pcCount,
                'pc' => $pc,
                'pcScale' => sprintf('%01.1f', $pcScale),
                'mobileCount' => $mobileCount,
                'mobile' => $mobile,
                'mobileScale' => sprintf('%01.1f', 100 - $pcScale)
            );
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 浏览器分析
     */
    public function browser() {
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
		
        if ($starttime !== NULL) {
            $starttime = is_numeric($starttime) ? max(0, intval($starttime)) : strtotime($starttime);
            $starttime = strtotime(date('Y-m-d', $starttime));
        }

        if ($endtime !== NULL) {
            $endtime = is_numeric($endtime) ? max(0, intval($endtime)) : strtotime($endtime);
            $endtime = strtotime(date('Y-m-d 23:59:59', $endtime));
        }
        if (!empty($endtime) && !empty($starttime) && $starttime > $endtime) {
            $this->renderjson(0, '', array());
        }
        $params = array('crid' => $this->roominfo['crid']);
        if (!empty($starttime)) {
            $params['starttime'] = $starttime;
            //echo date('Y-m-d H:i:s', $starttime)."\n";
        }
        if (!empty($endtime)) {
            $params['endtime'] = $endtime;
            //echo date('Y-m-d H:i:s', $endtime)."\n";
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.FlowRate.browser')
            ->addParams($params)
            ->request();

        
        $max = 5;
        if (!empty($ret)) {
            $pc = $mobile = array();
            $pcCount = $mobileCount = 0;
            foreach ($ret as $item) {
                if ($item['browser'] != 'IE') {
                    $item['broversion'] = '';
                }
                if ($item['browser'] == 'IE') {
                    $item['browser'] = $item['browser'].$item['broversion'];
                }
                if (!empty($item['ismobile'])) {
                    unset($item['ismobile'], $item['browser2']);
                    $mobile[] = $item;
                    $mobileCount += $item['count'];
                    continue;
                }
                unset($item['ismobile'], $item['browser2']);
                $pc[] = $item;
                $pcCount += $item['count'];
            }

            $pc = $this->setScale($pc, $max, 'browser', array('broversion'));
            $mobile = $this->setScale($mobile, $max, 'browser', array('broversion'));
            //排序
            $pcCounts = array_column($pc, 'scale');
            $mobileCounts = array_column($mobile, 'scale');
            array_multisort($pcCounts, SORT_DESC, SORT_NUMERIC, $pc);
            array_multisort($mobileCounts, SORT_DESC, SORT_NUMERIC, $mobile);
            unset($pcCounts, $mobileCounts);
            $pcScale = round($pcCount * 100 / ($pcCount + $mobileCount), 1);
            $ret = array(
                'pcCount' => $pcCount,
                'pc' => $pc,
                'pcScale' => sprintf('%01.1f', $pcScale),
                'mobileCount' => $mobileCount,
                'mobile' => $mobile,
                'mobileScale' => sprintf('%01.1f', 100 - $pcScale)
            );
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 网络服务商分析
     */
    public function isp() {
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
		
        if ($starttime !== NULL) {
            $starttime = is_numeric($starttime) ? max(0, intval($starttime)) : strtotime($starttime);
            $starttime = strtotime(date('Y-m-d', $starttime));
        }
        if ($endtime !== NULL) {
            $endtime = is_numeric($endtime) ? max(0, intval($endtime)) : strtotime($endtime);
            $endtime = strtotime(date('Y-m-d 23:59:59', $endtime));
        }
        if (!empty($endtime) && !empty($starttime) && $starttime > $endtime) {
            $this->renderjson(0, '', array());
        }
        $params = array('crid' => $this->roominfo['crid']);
        if (!empty($starttime)) {
            $params['starttime'] = $starttime;
            //echo date('Y-m-d H:i:s', $starttime)."\n";
        }
        if (!empty($endtime)) {
            $params['endtime'] = $endtime;
            //echo date('Y-m-d H:i:s', $endtime)."\n";
        }

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.FlowRate.isp')
            ->addParams($params)
            ->request();
        
        if (!empty($ret)) {
            $len = count($ret);
            if ($len == 1) {
                $ret = array_values($ret);
                $ret[0]['scale'] = 100;
            } else {
                $max = 8;
                if ($len > $max) {
                    $tmp = array_slice($ret, --$max);
                    $ret = array_slice($ret, 0, $max);
                    $counts = array_column($tmp, 'count');
                    $ret[] = array(
                        'isp' => '其他',
                        'count' => array_sum($counts)
                    );
                    unset($tmp, $counts);
                }
                $counts = array_column($ret, 'count');
                $sum = array_sum($counts);
                unset($counts);
                $lastItem = array_pop($ret);
                array_walk($ret, function(&$item, $k, $sum) {
                    $item['scale'] = round($item['count'] * 100 / $sum,1);
                }, $sum);
                $scales = array_column($ret, 'scale');
                $scales = array_sum($scales);
                $lastItem['scale'] = round(100 - $scales, 1);
                $ret[] = $lastItem;
                //排序
                $counts = array_column($ret, 'scale');
                array_multisort($counts, SORT_DESC, SORT_NUMERIC, $ret);
                unset($counts);
                array_walk($ret, function(&$v) {
                   $v['scale'] = sprintf('%01.1f', $v['scale']);
                });
            }
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 统计数据，设置比例
     * @param $data 数据
     * @param $groupNum 最大分组数
     * @param $param 其他字段名称
     * @param string $fillparams 置空的字段集
     * @return array
     */
    private function setScale($data, $groupNum, $param, $fillparams = '') {
        if (empty($data)) {
            return array();
        }
        $count = count($data);
        if ($count == 1) {
            $data[0]['scale'] = 100;
            return $data;
        }
        $sortParams = array_column($data, 'count');
        $pcSum = array_sum($sortParams);
        array_multisort($sortParams, SORT_DESC, SORT_NUMERIC, $data);
        if ($groupNum > 0 && $count > $groupNum) {
            $tmp = array_slice($data, $groupNum - 1);
            $data = array_slice($data, 0, $groupNum - 1);
            $tmp = array_column($tmp, 'count');
            $other = array(
                $param => '其他',
                'count' => array_sum($tmp)
            );
            if (!empty($fillparams)) {
                if (is_array($fillparams)) {
                    foreach($fillparams as $fillparam) {
                        $other[$fillparam] = '';
                    }
                } else {
                    $other[strval($fillparams)] = '';
                }
            }
            $data[] = $other;
            unset($tmp);
        }
        $lastItem = array_pop($data);
        array_walk($data, function(&$v, $k, $sum) {
            $v['scale'] = round($v['count'] * 100 / $sum, 1);
        }, $pcSum);
        $scales = array_column($data, 'scale');
        $scales = array_sum($scales);
        $lastItem['scale'] = round(100 - $scales, 1);
        $data[] = $lastItem;
        array_walk($data, function(&$v) {
           $v['scale'] = sprintf('%01.1f', $v['scale']);
        });
        return $data;
    }
	
	/**
     * json格式输出
     * @param number $code 状态标识 0 成功 1 失败
     * @param string $msg 输出消息
     * @param array $data 数组参数数组
     * @param string $exit 是否结束退出
     */
    function renderjson($code=0,$msg="",$data=array(),$exit=true){
        $arr = array(
            'code'=>(intval($code) ===0) ? 0 : intval($code),
            'msg'=>$msg,
            'data'=>$data
        );
        echo json_encode($arr);
        if($exit){
            exit();
        }
    }

}