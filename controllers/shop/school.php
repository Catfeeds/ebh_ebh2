<?php
/**
 * 学校课程列表控制器
 */
class SchoolController extends CControl {
    /**
     * 名师团队列表
     */
    public function masterlist() {
        $this->room = $roominfo = Ebh::app()->room->getcurroom();
        $this->user = Ebh::app()->user->getloginuser();
        if (empty($roominfo)) {
            header('location:/');
            exit();
        }
        $page = intval($this->input->get('page'));
        $page = max(1, $page);
        $pagesize = intval($this->input->get('pagesize'));
        $pagesize = max(20, $pagesize);
        $isAjax = $this->input->get('isAjax');

        $model = $this->model('Master');
        $crid = $roominfo['crid'];
        $limit = array(
            'pagesize' => $pagesize,
            'page' => $page
        );
        $masters = $model->getList($crid, $limit);
        if ($isAjax) {
            foreach ($masters as $master) {
                $master['face'] = getavater((array) $master, '120_120');
            }
            echo json_encode($masters);
            exit();
        }
        $pfmodel = $this->model('portfolio');
        $room_type = Ebh::app()->room->getRoomType();
        $modules = $pfmodel->getPortfolioConfig($crid, $room_type ? 1 : 0);
        $top_modules = array_filter($modules, function($e) {
            return $e['show_type'] == 1;
        });

        $this->assign('top_modules', $top_modules);
        $this->assign('roomdetail', $roominfo);
        $this->assign('masters', $masters);
        $this->getHeaderAndFooter();
        $this->display('shop/plate/master_mobile');
    }

    /**
     *获取共用的头部和尾部数据
     */
    public function getHeaderAndFooter($roomdetail=NULL) {
        $model = $this->model('portfolio');
        if (!empty($this->user)) {
            $this->user['isadmin'] = $this->user['groupid'] == 5;
            $this->user['showname'] = !empty($this->user['realname']) ? $this->user['realname'] : $this->user['username'];
            $this->user['face'] = getavater($this->user, '120_120');
            $user = array(
                'showname' => $this->user['showname'],
                'groupid' => $this->user['groupid'],
                'isadmin' => $this->user['isadmin'],
                'face' => $this->user['face'],
                'lastlogtime' => $this->user['lastlogintime']
            );
            $this->assign('plateUser', $user);
        }
        if (!empty($this->room)) {
            $room = array(
                'crname' => $this->room['crname'],
                'crphone' => $this->room['crphone'],
                'kefuqq' => $this->room['kefuqq'],
                'summary' => $this->room['summary'],
                'wechatimg' => $this->room['wechatimg'],
                'cface' => $this->room['cface'],
                'lat' => $this->room['lat'],
                'lng' => $this->room['lng'],
                'craddress' => $this->room['craddress']
            );
            $this->assign('plateRoom', $room);
        }
        $this->assign('user', $this->user);
        $this->assign('roominfo', $this->room);
        if (empty($roomdetail)) {
            $roomdetail = $model->getClassroomDetail($this->room['crid']);
        }
        if (!empty($roomdetail['isdesign'])) {
            $room_type = Ebh::app()->room->getRoomType();
            $apiServer = Ebh::app()->getApiServer('ebh');
            $roomtype = Ebh::app()->room->getRoomType();
            $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.getdesign')
                ->addParams('crid', $roomdetail['crid'])
                ->addParams('roomtype', $room_type)
                ->addParams('clientType', is_mobile())
                ->request();
            if (!empty($ret['status'])) {
                $this->assign('head', str_replace('\"', '"', $ret['data']['head']));
                $this->assign('foot', str_replace('\"', '"', $ret['data']['foot']));
                $settings = str_replace('\"', '"', $ret['data']['settings']);
                $settings = json_decode($settings, true);
                $this->assign('settings', $settings);
            }
        }
    }

}
