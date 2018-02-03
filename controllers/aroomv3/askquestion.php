<?php

/**
 * 答疑
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/3/23
 * Time: 16:47
 */
class AskquestionController extends ARoomV3Controller {
    /**
     * 问题列表
     */
    public function askQuestionList() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $iszjdlr = isset($appsetting['zjdlr']) && $appsetting['zjdlr'] == $this->roominfo['crid'] || isset($appsetting['newzjdlr']) && in_array($this->roominfo['crid'], $appsetting['newzjdlr']);
        $params['roomtype'] = $iszjdlr ? 'com' : Ebh::app()->room->getRoomType();
        if ($iszjdlr && $this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $params['uid'] = $this->user['uid'];
        }
        $sourcecrid = $this->input->get('sourcecrid');
        if(!empty($sourcecrid) && $sourcecrid > 0){
            $params['crid'] = intval($sourcecrid);
        }
        $pageinfo = $this->getPageInfo();
        $params['pagesize'] = $pageinfo['pagesize'];
        $params['pagenum'] = $pageinfo['pagenum'];
        $folderid = $this->input->get('folderid');
        if ($folderid !== NULL && $folderid != '') {
            $params['folderid'] = intval($folderid);
        }
        $shield = $this->input->get('shield');
        if ($shield !== NULL && $shield != '') {
            $params['shield'] = intval($shield);
        }
        $start = $this->input->get('starttime');
        if ($start !== NULL && $start != '') {
            $start = safefilter(trim($start));
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', $start, $match)) {
                if (checkdate($match[2], $match[3], $match[1])) {
                    $params['early'] = strtotime($start);
                }
            }
        }
        $endtime = $this->input->get('endtime');
        if ($endtime !== NULL && $endtime != '') {
            $endtime = safefilter(trim($endtime));
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', $endtime, $match)) {
                if (checkdate($match[2], $match[3], $match[1])) {
                    $params['latest'] = strtotime($endtime.' 23:59:59');
                }
            }
        }
        $k = safefilter(trim($this->input->get('k')));
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $params['classid'] = intval($this->input->get('classid'));
        if ($iszjdlr) {
            $ret = $this->apiServer->reSetting()
                ->setService('Aroomv3.Zjdlr.askQuestionList')
                ->addParams($params)
                ->request();
        } else {
            $ret = $this->apiServer->reSetting()
                ->setService('Aroomv3.AskQuestion.askQuestionList')
                ->addParams($params)
                ->request();
        }
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        if (isset($_UP['ask']['showpath'])) {
            array_walk($ret, function(&$v, $k, $path) {
                $v['message'] = html_entity_decode(strip_tags($v['message']));
                $v['user']['avatar'] = getavater($v['user']);
                if (!empty($v['images'])) {
                    if (count($v['images']) > 4) {
                        $v['images'] = array_slice($v['images'], 0, 4);
                    }
                    foreach ($v['images'] as $k => $img) {
                        if (stripos($img['src'], 'http://') === 0) {
                            continue;
                        }
                        $v['images'][$k]['src'] = $path.'/'.ltrim($v['images'][$k]['src'], '/');
                    }
                }
            }, rtrim($_UP['ask']['showpath'],'/'));
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 问题统计
     */
    public function askQuestionCount() {
        $params = array(
            'crid' => $this->roominfo['crid']
        );
        $appsetting = Ebh::app()->getConfig()->load('othersetting');
        $iszjdlr = isset($appsetting['zjdlr']) && $appsetting['zjdlr'] == $this->roominfo['crid'] || isset($appsetting['newzjdlr']) && in_array($this->roominfo['crid'], $appsetting['newzjdlr']);
        $params['roomtype'] = $iszjdlr ? 'com' : Ebh::app()->room->getRoomType();
        if ($iszjdlr && $this->roominfo['uid'] != $this->user['uid']) {
            //非管理员用户,读取用户角色
            $params['uid'] = $this->user['uid'];
        }
        $sourcecrid = $this->input->get('sourcecrid');
        if(!empty($sourcecrid) && $sourcecrid > 0){
            $params['crid'] = intval($sourcecrid);
        }
        $folderid = $this->input->get('folderid');
        if ($folderid !== NULL && $folderid != '') {
            $params['folderid'] = intval($folderid);
        }
        $shield = $this->input->get('shield');
        if ($shield !== NULL && $shield != '') {
            $params['shield'] = intval($shield);
        }
        $starttime = $this->input->get('starttime');
        if ($starttime !== NULL && $starttime != '') {
            $starttime = safefilter(trim($starttime));
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', $starttime, $match)) {
                if (checkdate($match[2], $match[3], $match[1])) {
                    $params['early'] = strtotime($starttime);
                }
            }
        }
        $endtime = $this->input->get('endtime');
        if ($endtime !== NULL && $endtime != '') {
            $endtime = safefilter(trim($endtime));
            if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/i', $endtime, $match)) {
                if (checkdate($match[2], $match[3], $match[1])) {
                    $params['latest'] = strtotime($endtime.' 23:59:59');
                }
            }
        }
        $k = safefilter(trim($this->input->get('k')));
        if (!empty($k)) {
            $params['k'] = $k;
        }
        $params['classid'] = intval($this->input->get('classid'));
        if ($iszjdlr) {
            $ret = $this->apiServer->reSetting()
                ->setService('Aroomv3.Zjdlr.askQuestionCount')
                ->addParams($params)
                ->request();
        } else {
            $ret = $this->apiServer->reSetting()
                ->setService('Aroomv3.AskQuestion.askQuestionCount')
                ->addParams($params)
                ->request();
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 设置屏蔽状态
     */
    public function setShield() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法操作');
        }
        $qid = intval($this->input->post('qid'));
        $shield = intval($this->input->post('shield'));
        $params = array(
            'crid' => $this->roominfo['crid'],
            'qid' => $qid,
            'shield' => $shield
        );
        $sourcecrid = $this->input->post('sourcecrid');
        if(!empty($sourcecrid) && $sourcecrid > 0){
            $params['crid'] = intval($sourcecrid);
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.AskQuestion.setShield')
            ->addParams($params)
            ->request();
        $this->renderjson(0, '', $ret,false);

        //屏蔽（取消屏蔽）操作成功后记录到操作日志
        if (($ret !== false) && !empty($qid) && isset($shield)) {
            $logdata = array();
            $operation = ($shield==1) ? 'shieldask' : 'unshieldask';
            $logdata['toid'] = $qid;                    //问题的id
            //根据问题编号获取问题信息
            $askdetail = $this->apiServer->reSetting()->setService('Aroomv3.AskQuestion.getAskByQid')->addParams(array('qid'=>$qid))->request();
            if(!empty($askdetail['title'])){
                $logdata['title'] = $askdetail['title'];
                Ebh::app()->lib('OperationLog')->addLog($logdata,$operation);
            }
        }
    }
}