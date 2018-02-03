<?php
/**
 * 流量分析
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/4/25
 * Time: 13:10
 */
class flowrateController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
        //是否导出
        $import = intval($this->input->get('import')) == 1 ? true : false;
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
        if ($import) {
            if ($ret['unit'] == 'hour') {
                $title = '从今天凌晨到现在的流量分析';
            } else {
                $startStr = !empty($starttime) ? date('Y-m-d', $starttime) : date('Y-m-d');
                $endStr = !empty($endtime) ? date('Y-m-d', $endtime) : '现在';
                $title = sprintf('从%s到%s的流量分析', $startStr, $endStr);
            }
            $this->import($ret, $title);
            exit();
        }
        //print_r($ret);exit;
        $this->renderjson(0, '', $ret);
    }

    /**
     * 分析导出
     * @param $data 分析数据
     * @param string $title 标题
     */
    private function import($data, $title = '') {
        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("流量分析EXCEL导出")
            ->setSubject("流量分析EXCEL导出")
            ->setDescription("流量分析")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            '时间',
            '登录次数',
            '登录IP数',
            '签到次数'
        );
        $name = empty($title) ? "流量分析" : $title;
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);


        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }

        $column_count = count($titleArr);

        //传值
        if(is_array($data['list'])){
            foreach ($data['list'] as $index => $row) {
                $str = "A";
                for($i = 0; $i < $column_count; $i++) {
                    $p = $str . ($index + 3);
                    if ($str == 'A') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['date']);
                        $str++;
                        continue;
                    }
                    if ($str == 'B') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['users']);
                        $str++;
                        continue;
                    }
                    if ($str == 'C') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['ips']);
                        $str++;
                        continue;
                    }
                    if ($str == 'D') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['signs']);
                        $str++;
                        continue;
                    }
                }
            }
            $str = "A";
            $index = 3 + count($data['list']);
            for($i = 0; $i < $column_count; $i++) {
                $p = $str . $index;
                $objPHPExcel->getActiveSheet()->getStyle($p)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle($p)->getFill()->getStartColor()->setARGB('FFCAE8EA');
                if ($str == 'A') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, '');
                    $str++;
                    continue;
                }
                if ($str == 'B') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $data['userCount']);
                    $str++;
                    continue;
                }
                if ($str == 'C') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $data['ipCount']);
                    $str++;
                    continue;
                }
                if ($str == 'D') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $data['signCount']);
                    $str++;
                    continue;
                }
            }
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);


        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }

    /**
     * 屏幕分辨率分析
     */
    public function screen() {
        $starttime = $this->input->get('starttime');
        $endtime = $this->input->get('endtime');
        //是否导出
        $import = intval($this->input->get('import')) == 1 ? true : false;
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
        //按分比例降序排列
        if (empty($ret)) {
            $ret = array();
        }
        $counts = array_column($ret, 'count');
        array_multisort($counts, SORT_DESC, SORT_NUMERIC, $ret);
        if ($import) {
            unset($ret['']);
            $startStr = !empty($starttime) ? date('Y-m-d', $starttime) : date('Y-m-d');
            $endStr = !empty($endtime) ? date('Y-m-d', $endtime) : '现在';
            $title = sprintf('从%s到%s的终端分辨率分析', $startStr, $endStr);
            $this->importScreen($ret, $title);
            exit();
        }
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
                $max = 8;
                if (empty($import) && $len > $max) {
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
        //是否导出
        $import = intval($this->input->get('import')) == 1 ? true : false;
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
        if ($import) {
            $startStr = !empty($starttime) ? date('Y-m-d', $starttime) : date('Y-m-d');
            $endStr = !empty($endtime) ? date('Y-m-d', $endtime) : '现在';
            $title = sprintf('从%s到%s的设备分析', $startStr, $endStr);
            $this->importOs($ret, $title);
            exit();
        }
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
        //是否导出
        $import = intval($this->input->get('import')) == 1 ? true : false;
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

        if ($import) {
            $startStr = !empty($starttime) ? date('Y-m-d', $starttime) : date('Y-m-d');
            $endStr = !empty($endtime) ? date('Y-m-d', $endtime) : '现在';
            $title = sprintf('从%s到%s的终端浏览器分析', $startStr, $endStr);
            $this->importBrowser($ret, $title);
            exit();
        }
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
        //是否导出
        $import = intval($this->input->get('import')) == 1 ? true : false;
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
        if ($import) {
            $startStr = !empty($starttime) ? date('Y-m-d', $starttime) : date('Y-m-d');
            $endStr = !empty($endtime) ? date('Y-m-d', $endtime) : '现在';
            $title = sprintf('从%s到%s的网络提供商分析', $startStr, $endStr);
            $this->importIsp($ret, $title);
            exit();
        }
        if (!empty($ret)) {
            $len = count($ret);
            if ($len == 1) {
                $ret = array_values($ret);
                $ret[0]['scale'] = 100;
            } else {
                $max = 8;
                if (empty($import) && $len > $max) {
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
        $sortParams = $unknows = array();
        foreach ($data as $item) {
            $sortParams[] = $item['count'];
            $unknows[] = empty($item[$param]) ? 1 : 0;
        }
        array_multisort($unknows, SORT_ASC, SORT_NUMERIC,
            $sortParams, SORT_DESC, SORT_NUMERIC, $data);
        $pcSum = array_sum($sortParams);
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
        $lastItem['scale'] = max(1, round(100 - $scales, 1));
        $data[] = $lastItem;
        array_walk($data, function(&$v) {
           $v['scale'] = sprintf('%01.1f', $v['scale']);
        });
        return $data;
    }

    /**
     * 导出设备分析
     * @param $data
     * @param $title
     */
    private function importOs($data, $title) {
        $pc = $mobile = array();
        $pcCount = $mobileCount = 0;
        foreach ($data as $item) {
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
        $pc = $this->setScale($pc, -1, 'system');
        $mobile = $this->setScale($mobile, -1, 'system');
        //排序
        $pcCounts = array_column($pc, 'count');
        $pcSales = array_column($pc, 'scale');
        $mobileCounts = array_column($mobile, 'count');
        $mobileSales = array_column($mobile, 'scale');
        array_multisort($pcCounts, SORT_DESC, SORT_NUMERIC,
            $pcSales, SORT_DESC, SORT_NUMERIC, $pc);
        array_multisort($mobileCounts, SORT_DESC, SORT_NUMERIC,
            $mobileSales, SORT_DESC, SORT_NUMERIC, $mobile);
        unset($pcCounts, $mobileCounts, $pcScales, $mobileSales);
        $pcScale = round($pcCount / ($pcCount + $mobileCount), 3);

        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("终端浏览器EXCEL导出")
            ->setSubject("终端浏览器EXCEL导出")
            ->setDescription("终端浏览器")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            'PC端系统',
            '数量',
            '占比',
            '',
            '移动端系统',
            '数量',
            '占比'
        );
        $name = empty($title) ? "终端浏览器分析" : $title;
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(16);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:G1");
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);


        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';
                //$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }

        $column_count = count($titleArr);
        foreach ($pc as $index => $row) {
            $str = "A";
            for($i = 0; $i < $column_count; $i++) {
                $p = $str . ($index + 3);
                if ($str == 'A') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['system']);
                    $str++;
                    continue;
                }
                if ($str == 'B') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['count']);
                    $str++;
                    continue;
                }
                if ($str == 'C') {
                    $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['scale'] / 100);
                    $str++;
                    continue;
                }
            }
        }
        foreach ($mobile as $index => $row) {
            $str = "E";
            for($i = 0; $i < $column_count; $i++) {
                $p = $str . ($index + 3);
                if ($str == 'E') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['system']);
                    $str++;
                    continue;
                }
                if ($str == 'F') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['count']);
                    $str++;
                    continue;
                }
                if ($str == 'G') {
                    $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['scale'] / 100);
                    $str++;
                    continue;
                }
            }
        }
        $bottomIndex = max(count($pc), count($mobile));
        $str = "A";
        $index = 3 + $bottomIndex;
        for($i = 0; $i < $column_count; $i++) {
            $p = $str . $index;
            $objPHPExcel->getActiveSheet()->getStyle($p)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle($p)->getFill()->getStartColor()->setARGB('FFCAE8EA');
            if ($str == 'B') {
                $objPHPExcel->getActiveSheet()->setCellValue($p, $pcCount);
                $str++;
                continue;
            }
            if ($str == 'C') {
                $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                $objPHPExcel->getActiveSheet()->setCellValue($p, $pcScale);
                $str++;
                continue;
            }
            if ($str == 'F') {
                $objPHPExcel->getActiveSheet()->setCellValue($p, $mobileCount);
                $str++;
                continue;
            }
            if ($str == 'G') {
                $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                $objPHPExcel->getActiveSheet()->setCellValue($p, 1 - $pcScale);
                $str++;
                continue;
            }
            $str++;
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }

    /**
     * 导出浏览器分析数据
     * @param $data
     * @param $title
     */
    private function importBrowser($data, $title) {
        $pc = $mobile = array();
        $pcCount = $mobileCount = 0;
        foreach ($data as $item) {
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

        $pc = $this->setScale($pc, -1, 'browser', array('broversion'));
        $mobile = $this->setScale($mobile, -1, 'browser', array('broversion'));
        //排序
        $pcCounts = array_column($pc, 'count');
        $pcScales = array_column($pc, 'scale');
        $mobileCounts = array_column($mobile, 'count');
        $mobileScales = array_column($mobile, 'scale');
        array_multisort($pcCounts, SORT_DESC, SORT_NUMERIC,
            $pcScales, SORT_DESC, SORT_NUMERIC, $pc);
        array_multisort($mobileCounts, SORT_DESC, SORT_NUMERIC,
            $mobileScales, SORT_DESC, SORT_NUMERIC, $mobile);
        unset($pcCounts, $mobileCounts, $mobileScales, $pcScales);
        $pcScale = round($pcCount / ($pcCount + $mobileCount), 3);

        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("终端浏览器EXCEL导出")
            ->setSubject("终端浏览器EXCEL导出")
            ->setDescription("终端浏览器")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            'PC端设备类型',
            '版本',
            '数量',
            '占比',
            '',
            '移动端设备类型',
            '版本',
            '数量',
            '占比'
        );
        $name = empty($title) ? "终端浏览器分析" : $title;
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(16);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:I1");
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);


        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';
                //$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }

        $column_count = count($titleArr);
        foreach ($pc as $index => $row) {
            $str = "A";
            for($i = 0; $i < $column_count; $i++) {
                $p = $str . ($index + 3);
                if ($str == 'A') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['browser']);
                    $str++;
                    continue;
                }
                if ($str == 'B') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['broversion']);
                    $str++;
                    continue;
                }
                if ($str == 'C') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['count']);
                    $str++;
                    continue;
                }
                if ($str == 'D') {
                    $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['scale'] / 100);
                    $str++;
                    continue;
                }
            }
        }
        foreach ($mobile as $index => $row) {
            $str = "F";
            for($i = 0; $i < $column_count; $i++) {
                $p = $str . ($index + 3);
                if ($str == 'F') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['browser']);
                    $str++;
                    continue;
                }
                if ($str == 'G') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['broversion']);
                    $str++;
                    continue;
                }
                if ($str == 'H') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['count']);
                    $str++;
                    continue;
                }
                if ($str == 'I') {
                    $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['scale'] / 100);
                    $str++;
                    continue;
                }
            }
        }
        $bottomIndex = max(count($pc), count($mobile));
        $str = "A";
        $index = 3 + $bottomIndex;
        for($i = 0; $i < $column_count; $i++) {
            $p = $str . $index;
            $objPHPExcel->getActiveSheet()->getStyle($p)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle($p)->getFill()->getStartColor()->setARGB('FFCAE8EA');
            if ($str == 'C') {
                $objPHPExcel->getActiveSheet()->setCellValue($p, $pcCount);
                $str++;
                continue;
            }
            if ($str == 'D') {
                $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                $objPHPExcel->getActiveSheet()->setCellValue($p, $pcScale);
                $str++;
                continue;
            }
            if ($str == 'H') {
                $objPHPExcel->getActiveSheet()->setCellValue($p, $mobileCount);
                $str++;
                continue;
            }
            if ($str == 'I') {
                $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                $objPHPExcel->getActiveSheet()->setCellValue($p, 1 - $pcScale);
                $str++;
                continue;
            }
            $str++;
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }

    /**
     * 导出分辨率分析数据
     * @param $data
     * @param $title
     */
    private function importScreen($data, $title) {
        if (!empty($data)) {
            $data = array_values($data);
            $counts = array_column($data, 'count');
            $sum = array_sum($counts);
            array_multisort($counts, SORT_DESC, SORT_NUMERIC, $data);
            unset($counts);
            $lastItem = array_pop($data);
            array_walk($data, function(&$item, $k, $sum) {
                $item['scale'] = round($item['count'] / $sum,3);
            }, $sum);
            $scales = array_column($data, 'scale');
            $scales = array_sum($scales);
            $lastItem['scale'] = round(1 - $scales, 3);
            $data[] = $lastItem;
            array_walk($data, function(&$item) {
                if ($item['scale'] < 0) {
                    $item['scale'] = 0;
                    return;
                }
            });
            $counts = array_column($data, 'count');
            $scales = array_column($data, 'scale');
            array_multisort($counts, SORT_DESC, SORT_NUMERIC,
                $scales, SORT_DESC, SORT_NUMERIC, $data);
            unset($counts, $scales);
        }


        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("终端浏览器EXCEL导出")
            ->setSubject("终端浏览器EXCEL导出")
            ->setDescription("终端浏览器")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            '排名',
            '分辨率',
            '登录人数',
            '登录占比'
        );
        $name = empty($title) ? "终端浏览器分析" : $title;
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(16);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);


        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';
                //$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }

        $column_count = count($titleArr);
        foreach ($data as $index => $row) {
            $str = "A";
            for($i = 0; $i < $column_count; $i++) {
                $p = $str . ($index + 3);
                if ($str == 'A') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $index + 1);
                    $str++;
                    continue;
                }
                if ($str == 'B') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['screen']);
                    $str++;
                    continue;
                }
                if ($str == 'C') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['count']);
                    $str++;
                    continue;
                }
                if ($str == 'D') {
                    $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['scale']);
                    $str++;
                    continue;
                }
            }
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }

    /**
     * 导出网络提供商分析数据
     * @param $data
     * @param $title
     */
    private function importIsp($data, $title) {
        if (count($data) > 0) {
            $counts = array_column($data, 'count');
            $sum = array_sum($counts);
            //排序
            array_multisort($counts, SORT_DESC, SORT_NUMERIC, $data);
            array_walk($data, function(&$item, $k, $sum) {
                $item['scale'] = round($item['count'] / $sum,1);
            }, $sum);
            unset($counts);
            $lastItem = array_pop($data);
            $scales = array_column($data, 'scale');
            $scales = array_sum($scales);
            $lastItem['scale'] = round(1 - $scales, 1);
            $data[] = $lastItem;
            array_walk($data, function(&$v) {
                if ($v['scale'] < 0) {
                    $v['scale'] = 0;
                }
            });
            $counts = array_column($data, 'count');
            $scales = array_column($data, 'scale');
            array_multisort($counts, SORT_DESC, SORT_NUMERIC,
                $scales, SORT_DESC, SORT_NUMERIC, $data);
            unset($counts, $scales);
        }
        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("网络提供商EXCEL导出")
            ->setSubject("网络提供商EXCEL导出")
            ->setDescription("网络提供商")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            '排名',
            '网络提供商',
            '登录人数',
            '登录占比'
        );
        $name = empty($title) ? "网络提供商分析" : $title;
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(16);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);


        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';
                //$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }

        $column_count = count($titleArr);
        foreach ($data as $index => $row) {
            $str = "A";
            for($i = 0; $i < $column_count; $i++) {
                $p = $str . ($index + 3);
                if ($str == 'A') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $index + 1);
                    $str++;
                    continue;
                }
                if ($str == 'B') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['isp']);
                    $str++;
                    continue;
                }
                if ($str == 'C') {
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['count']);
                    $str++;
                    continue;
                }
                if ($str == 'D') {
                    $objPHPExcel->getActiveSheet()->getStyle($p)->getNumberFormat()->setFormatCode('0.0%');
                    $objPHPExcel->getActiveSheet()->setCellValue($p, $row['scale']);
                    $str++;
                    continue;
                }
            }
        }

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }

    private function getScale($double) {
        $double = $double * 100;
    }
}