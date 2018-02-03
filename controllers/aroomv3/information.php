<?php
/**
 * 公告
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/3/21
 * Time: 16:39
 */
class InformationController extends ARoomV3Controller {
    /**
     * 发布公告
     */
    public function add() {
        if (!$this->isPost()) {
            if (!$this->isPost()) {
                $this->renderjson(1, '非法操作');
            }
        }
        $message = $this->input->post('message');
        if ($message === NULL) {
            $this->renderjson(1, '公告内容不能为空');
        }
        
        $params = array();
        $params['toid'] = $this->roominfo['crid'];
        $params['message'] = safefilter(trim($message));
        $params['ip'] = getip();
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Information.add')
            ->addParams($params)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '添加失败');
        }
        $room_cache = Ebh::app()->lib('Roomcache');
        $room_cache->removeCache($this->roominfo['crid'], 'sendinfo', 'plate-notice');
        $this->renderjson(0, '添加成功', $ret,false);

        fastcgi_finish_request();
        //发布公告操作成功后记录到操作日志
        if (!empty($ret) && is_numeric($ret)) {
            $logdata = array();
            $logdata['toid'] = $ret;                    //公告的id
            $logdata['title'] = mb_substr($params['message'],0,8);
            Ebh::app()->lib('OperationLog')->addLog($logdata,'editmessage');
        }
    }

    /**
     * 通知列表
     */
    public function notices() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $params['sortmode'] = intval($this->input->get('sortmode'));


        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Information.notices')
            ->addParams($params)
            ->request();
        $room_type = Ebh::app()->room->getRoomType();
        $room_type = $room_type == 'com' ? 1 : 0;
        //当前为企业版时替换数组中对应的名称
        if ($room_type===1){
            if(!empty($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='www.leblue.ebh.net'){
                array_walk($ret, function(&$notice, $k, $ntype) {
                    $notice['ntypeDescript'] = isset($ntype[$notice['ntype']]) ? $ntype[$notice['ntype']] : '';
                }, array(
                    1 => '全员',
                    2 => '全体讲师',
                    3 => '全体老人'
                ));
            }else{
                array_walk($ret, function(&$notice, $k, $ntype) {
                    $notice['ntypeDescript'] = isset($ntype[$notice['ntype']]) ? $ntype[$notice['ntype']] : '';
                }, array(
                    1 => '全公司',
                    2 => '全体讲师',
                    3 => '全体员工',
                    4 => '部门员工'
                ));
            }
        }else{
            array_walk($ret, function(&$notice, $k, $ntype) {
                $notice['ntypeDescript'] = isset($ntype[$notice['ntype']]) ? $ntype[$notice['ntype']] : '';
            }, array(
                1 => '全校师生',
                2 => '全校教师',
                3 => '全校学生',
                4 => '班级学生'
            ));
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 通知数量
     */
    public function noticeCount() {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Information.getNoticeCount')
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 删除通知
     */
    public function removeNotice() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $noticeid = intval($this->input->post('noticeid'));
        if ($noticeid < 1) {
            $this->renderjson(1, '参数错误');
        }
        //获取原通知消息信息（用于记录操作日志）
        $oldnotice = $this->apiServer->reSetting()->setService('Aroomv3.Information.getNotice')
            ->addParams('crid', $this->roominfo['crid'])->addParams('noticeid', $noticeid)->request();

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Information.removeNotice')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('noticeid', $noticeid)
            ->request();
        $this->renderjson(0, '', $ret,false);

        fastcgi_finish_request();
        //删除通知操作成功后记录到操作日志
        if (($ret !== false) && !empty($oldnotice['title'])) {
            $logdata = array();
            $logdata['toid'] = $noticeid;
            $logdata['title'] = h($oldnotice['title']);
            Ebh::app()->lib('OperationLog')->addLog($logdata,'delnotice');
        }
    }

    /**
     * 更新通知
     */
    public function updateNotice() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $noticeid = intval($this->input->post('noticeid'));
        if ($noticeid < 1) {
            $this->renderjson(1, '参数错误');
        }
        $params = array();
        if ($this->input->post('title') !== NULL) {
            $params['title'] = safefilter(trim($this->input->post('title')));
        }
        if ($this->input->post('message') !== NULL) {
            $params['message'] = safefilter(trim($this->input->post('message')));
        }
        if ($this->input->post('ntype') !== NULL) {
            $params['ntype'] = intval($this->input->post('ntype'));
        }
        if ($this->input->post('attid') !== NULL) {
            $params['attid'] = intval($this->input->post('attid'));
        }
        if ($this->input->post('remind') !== NULL) {
            $params['remind'] = intval($this->input->post('remind'));
        }
        if ($this->input->post('isreceipt') !== NULL) {
            $params['isreceipt'] = intval($this->input->post('isreceipt'));
        }
        if ($this->input->post('receipt') !== NULL) {
            $params['receipt'] = $this->input->post('receipt');
        }
        $attid = $this->input->post('attid');
        if ($attid !== NULL) {
            $params['attid'] = intval($attid);
        } else {
            $file_server = $this->input->post('file_server');
            $file_url = $this->input->post('file_url');
            $file_name = $this->input->post('file_name');
            $file_size = $this->input->post('file_size');
            $file_md5 = $this->input->post('file_md5');
            if ($file_server !== NULL && $file_url !== NULL && $file_name !== NULL && $file_size !== NULL) {
                $params['file_server'] = safefilter($file_server);
                $params['file_url'] = safefilter($file_url);
                $params['file_name'] = safefilter($file_name);
                $params['file_size'] = intval($file_size);
                $params['file_md5'] = safefilter($file_md5);
            }
        }
        if (empty($params)) {
            $this->renderjson(0, '修改成功', 0);
        }
        $params['crid'] = $this->roominfo['crid'];
        $params['uid'] = $this->roominfo['uid'];
        $params['noticeid'] = $noticeid;
        $params['ip'] = getip();
        //获取原通知消息信息（用于记录操作日志）
        $oldnotice = $this->apiServer->reSetting()->setService('Aroomv3.Information.getNotice')
            ->addParams('crid', $this->roominfo['crid'])->addParams('noticeid', $noticeid)->request();

        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Information.updateNotice')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret,false);

        fastcgi_finish_request();
        //编辑通知操作成功后记录到操作日志
        if (($ret !== false) && !empty($oldnotice['title']) && !empty($params['title'])) {
            $logdata = array();
            $logdata['toid'] = $noticeid;
            $logdata['oldtitle'] = h($oldnotice['title']);  //原通知名称
            $logdata['title'] = h($params['title']);        //新通知名称
            Ebh::app()->lib('OperationLog')->addLog($logdata,'editnotice');
        }
    }

    /**
     * 发布通知
     */
    public function addNotice() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $title = safefilter(trim($this->input->post('title')));
        $message = safefilter(trim($this->input->post('message')));
        if (empty($title) || empty($message)) {
            $this->renderjson(1, '通知标题内容不能为空');
        }
        $attid = intval($this->input->post('attid'));
        $remind = intval($this->input->post('remind'));
        $isreceipt = intval($this->input->post('isreceipt'));
        $receipt = $this->input->post('receipt');
        $params = array(
            'crid' => $this->roominfo['crid'],
            'uid' => $this->user['uid'],
            'type' => 0,
            'title' => $title,
            'message' => $message,
            'ntype' => intval($this->input->post('ntype')),
            'ip'=>getip(),
            'remind'=>$remind,
            'isreceipt'=>$isreceipt,
            'receipt'=>$receipt
        );
        if ($attid > 0) {
            $params['attid'] = intval($this->input->post('attid'));
        } else {
            $file_server = $this->input->post('file_server');
            $file_url = $this->input->post('file_url');
            $file_name = $this->input->post('file_name');
            $file_size = $this->input->post('file_size');
            $file_md5 = $this->input->post('file_md5');
            if ($file_server !== NULL && $file_url !== NULL && $file_name !== NULL && $file_size !== NULL) {
                $params['file_server'] = safefilter($file_server);
                $params['file_url'] = safefilter($file_url);
                $params['file_name'] = safefilter($file_name);
                $params['file_size'] = intval($file_size);
                $params['file_md5'] = safefilter($file_md5);
            }
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Information.addNotice')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret,false);

        fastcgi_finish_request();
        //发布通知操作成功后记录到操作日志
        if (!empty($params['title']) && !empty($ret) && is_numeric($ret)) {
            $logdata = array();
            $logdata['toid'] = $ret;                    //通知的id
            $logdata['title'] = h($params['title']);    //新通知名称
            Ebh::app()->lib('OperationLog')->addLog($logdata,'addnotice');
        }
    }

    /**
     * 通知详情
     */
    public function getNotice() {
        $noticeid = intval($this->input->get('noticeid'));
        if ($noticeid < 1) {
            $this->renderjson(1, '参数错误');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Information.getNotice')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('noticeid', $noticeid)
            ->request();
        if (!empty($ret)) {
            //$ret['dateline'] = date('Y-m-d H:i:s', $ret['dateline']);
            $ntype = array(
                1 => '全校师生',
                2 => '全校教师',
                3 => '全校学生',
                4 => '班级学生'
            );
            $ret['ntypeDescript'] = isset($ntype[$ret['ntype']]) ? $ntype[$ret['ntype']] : '';
            if (!empty($ret['attr'])) {
                $ret['attr']['url'] = $ret['attr']['source'].'attach.html?noticeid='.$ret['noticeid'];
            }
        }

        $this->renderjson(0, '', $ret);
    }

    /**
     * 获取当前公告
     */
    public function getSingleMessage() {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Information.getSingleMessage')
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 课程列表
     */
    public function getFolderList() {
        $data['page'] = 1;
        $data['pagesize'] = 200;
        $data['crid'] = $this->roominfo['crid'];
        $data['roominfo'] = $this->roominfo;
        $data['issimple'] = $this->input->get('issimple');
        $totalcourselist = $this->apiServer->reSetting()->setService('Aroomv3.Course.courseList')->addParams($data)->request();
        $courselist = $totalcourselist['courselist'];
        $folders = array_map(function($course) {
            return array(
                'foldername' => $course['foldername'],
                'folderid' => $course['folderid']
            );
        }, $courselist);
        $this->renderjson(0, '',$folders);
    }

    /**
     * 获取通知的回执的接口，包括已回执未回执，和导出的接口
     */
    public function getReceiptList() {

        $data['page'] = intval($this->input->get('page'));
        $data['pagesize'] = intval($this->input->get('pagesize'));
        if ($data['pagesize']<=0) {
            $data['pagesize'] = 200;
        }
        $data['crid'] = $this->roominfo['crid'];
        $data['noticeid'] = intval($this->input->get('noticeid'));
        if ($data['noticeid'] <= 0 ) {
            $this->renderjson(1, '查询失败');
        }

        $data['ntype'] = intval($this->input->get('ntype'));
        if ($data['ntype'] <= 0 ) {
            $this->renderjson(1, '查询失败');
        }

        $noviews = intval($this->input->get('noviews'));

        if ($noviews) {
            //没有回执人接口输出
            $url = 'College.NoticeReceipt.noviewslist';
            $data['export'] = intval($this->input->get('export'));//是否导出cvs文件
        } else {
            //有回执人接口输出
            $url = 'College.NoticeReceipt.list';
        }
        $res = $this->apiServer->reSetting()->setService($url)->addParams($data)->request();

        if (!empty($data['export'])) {//此处导出cvs文件
            //输出svg逻辑
            $room_type = Ebh::app()->room->getRoomType();
            $table_head = $room_type == 'com' ? array('账号','姓名', '所属部门', '是否查看', '选项', '说明'):
             array('账号','姓名', '所在班级', '是否查看', '选项', '说明')
             ;            
             if (!empty($res['list'])) {
                $this->outCsv($res['list'],$table_head,$data['ntype']);
             }
             
        } else {
            //输出
            if (!empty($res['list'])) {
                foreach ($res['list'] as &$v) {//$v是数组里的值

                    if (empty($v['realname']) && empty($v['username'])) {
                        $v['realname'] = empty($v['cnname'])?'':$v['cnname'];
                        $v['username'] = '';
                    }

                    if (empty($v['status'])) {
                        $v['status'] = '否';
                    } else {
                        $v['status'] = '是';
                    }

                    if (!isset($v['sex'])) {
                        $v['sex'] = 0;
                    }

                    if (!isset($v['realname'])) {
                        $v['realname'] = '';
                    }

                    if (!isset($v['username'])) {
                        $v['username'] = '';
                    }

                    if (!isset($v['face'])) {
                        $v['face'] = '';
                    }

                    if (empty($v['noticeid'])) {
                        $v['noticeid'] = 0;
                    }

                    if (empty($v['explains'])) {
                        $v['explains'] = '';
                    }

                    if (empty($v['dateline'])) {
                        $v['dateline'] = '';
                    }

                    if (isset($v['choice'])) {
                        $v['choice'] = $v['choice']==1?'是':'否';
                    } else {
                        $v['choice'] = '';
                    }
                }
             }
            $this->renderjson(0, '',$res);
        }
        
    }


    /***
     * @describe:导出csv
     * @User:tzq
     * @Date:${DATE}
     * @param $data
     */
    public function outCsv($data,$table_head,$type){
       // log_message('开始导出：');
       // $start = microtime(true);
        $output = fopen('php://output', 'w') or die("can't open php://output");
        //告诉浏览器这个是一个csv文件
        $filename = date('YmdHis');

        header("Content-Type: application/csv");
        header("Content-Disposition: attachment; filename=$filename.csv");
        //输出表头
       
        $table_head = mb_convert_encoding(implode(',', $table_head), 'GBK', 'UTF-8');
        $table_head = explode(',', $table_head);
        // $table_head = explode(',',$table_head);

        fputcsv($output, $table_head);

        //输出每一行数据到文件中
        if ($type==2) {
            foreach ($data as $v) {
                $e = array(empty($v['username'])?'':$this->charChange($v['username']),
                    empty($v['realname'])?(empty($v['username'])?(empty($v['cnname'])?'':$this->charChange($v['cnname'])):$this->charChange($v['username'])):$this->charChange($v['realname']),
                    $this->charChange('---'),
                    !empty($v['status'])?$this->charChange('是'):$this->charChange('否'),
                    isset($v['choice'])?($v['choice']==1?$this->charChange('是'):$this->charChange('否')):'',
                    !empty($v['explains'])?$this->charChange($v['explains']):'',
                );
                fputcsv($output,$e);
            }
        } else {
            foreach ($data as $v) {
                $e = array(empty($v['username'])?'':$this->charChange($v['username']),
                    empty($v['realname'])?(empty($v['username'])?(empty($v['cnname'])?'':$this->charChange($v['cnname'])):$this->charChange($v['username'])):$this->charChange($v['realname']),
                    $this->charChange($v['class']),
                    !empty($v['status'])?$this->charChange('是'):$this->charChange('否'),
                    isset($v['choice'])?($v['choice']==1?$this->charChange('是'):$this->charChange('否')):'',
                    !empty($v['explains'])?$this->charChange($v['explains']):'',
                );
                fputcsv($output,$e);
            }
        }
            

            fclose($output) or die("can't close php://output");
         //  $end = microtime(true);
         //  log_message('共消耗时间：'.($end-$start).'秒');
    }

    /**
     *转换编码
     */
    function charChange($char) {
        return mb_convert_encoding($char, 'GBK', 'UTF-8');
    }

}