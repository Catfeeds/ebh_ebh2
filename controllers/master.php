<?php
/**
 * 名师团队
 * 只支持plate模板
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/5/10
 * Time: 17:37
 */
class MasterController extends CControl
{
    public function index()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        if (empty($roominfo)) {
            header("Location: http://www.ebh.net");
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
        $param = array('crid' => $roominfo['crid'], 'code' => 'headfocus', 'folder' => 2, 'limit' => '0,5');
        $roomadkey = $this->cache->getcachekey('ad', $param);
        $adlist = $this->cache->get($roomadkey);

        //客服浮窗
        $kefu = array();
        if ($roominfo['kefuqq'] != 0) {
            $kefu['kefu'] = explode(',', $roominfo['kefu']);
            $kefu['kefuqq'] = explode(',', $roominfo['kefuqq']);
        }
        if (!empty($roominfo['crphone'])) {
            $phone = array();
            $phone = explode(',', $roominfo['crphone']);
            $this->assign('phone', $phone);
        }

        $this->assign('kefu', $kefu);
        if (empty($adlist)) {
            $admodel = $this->model('Ad');
            $adlist = $admodel->getAdList($param);
            $this->cache->set($roomadkey, $adlist, 600);
        }
        $this->assign('adlist', $adlist);
        if ($roominfo['template'] == 'plate') {
            Ebh::app()->runAction('room/portfolio', 'master');
        } else {
            header('Location: /');
        }
    }

    public function view() {
        $roominfo = Ebh::app()->room->getcurroom();
        if (empty($roominfo)) {
            header("Location: http://www.ebh.net");
            exit();
        }
        $tearcherid = $this->uri->itemid;
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
        $param = array('crid' => $roominfo['crid'], 'code' => 'headfocus', 'folder' => 2, 'limit' => '0,5');
        $roomadkey = $this->cache->getcachekey('ad', $param);
        $adlist = $this->cache->get($roomadkey);

        //客服浮窗
        $kefu = array();
        if ($roominfo['kefuqq'] != 0) {
            $kefu['kefu'] = explode(',', $roominfo['kefu']);
            $kefu['kefuqq'] = explode(',', $roominfo['kefuqq']);
        }
        if (!empty($roominfo['crphone'])) {
            $phone = array();
            $phone = explode(',', $roominfo['crphone']);
            $this->assign('phone', $phone);
        }

        $this->assign('kefu', $kefu);
        if (empty($adlist)) {
            $admodel = $this->model('Ad');
            $adlist = $admodel->getAdList($param);
            $this->cache->set($roomadkey, $adlist, 600);
        }
        $this->assign('adlist', $adlist);
        if ($roominfo['template'] == 'plate') {
            Ebh::app()->runAction('room/portfolio', 'master_detail', $tearcherid);
        } else {
            header('Location: /');
        }
    }
}