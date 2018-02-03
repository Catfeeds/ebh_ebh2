<?php
/**
 * ebh2.
 * User: tyt
 * Email: 345468755@qq.com
 * Time: 9:40
 * 课程打包详情页面
 */
class BundleController extends CControl{
    public function __construct() {
        parent::__construct();
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        $this->user = Ebh::app()->user->getloginuser();
        $this->room = Ebh::app()->room->getcurroom();
    }
    public function view(){
        $user =  $this->user;
        if(!$user){
            $uid = 0;
        }else{
            $uid = $user['uid'];
        }
        $roomInfo = $this->room;
        if (empty($roomInfo)) {
            header('Location:/');
        }
        $bid = intval($this->uri->itemid);
        $uid = empty($this->user) || $this->user['uid'] == 5 ? 0 : $this->user['uid'];
        $bundle = $this->apiServer->reSetting()
            ->setService('CourseService.Bundle.detail')
            ->addParams('bid', $bid)
            ->addParams('crid', $this->room['crid'])
            ->addParams('uid', $uid)
            ->request();
        if (empty($bundle)) {
            header('Location:/');
            exit();
        }

        //课程包设置了限制报名时,查询开通人数
        if(!empty($bundle['islimit']) && $bundle['limitnum']>0){
            $openlimit = Ebh::app()->lib('OpenLimit');
            $openstatus = $openlimit->checkStatus($bundle);
            $this->assign('openstatus',$openstatus);
        }

        $bundle['views'] = 0;
        $bundle['coursecount'] = 0;
        if (!empty($bundle['courses'])) {
            foreach ($bundle['courses'] as $value) {
                $bundle['coursecount'] += $value['coursewarenum'];
                $bundle['views'] += $value['viewnum'];
            }
        }
        if (empty($bundle['cover']) || strpos($bundle['cover'], '/ebh/tpl/default/images/folderimgs/course_cover_default') !== false) {
            $bundle['cover'] = 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/course_cover_default.png';
        } else {
            $bundle['cover'] = preg_replace_callback('/_\d+_\d+/', function($matches) {
                return '';
            }, $bundle['cover']);
        }
        $bundle['permission'] = $bundle['hasPower'];

        $this->assign('data',$bundle);
        $this->assign('user',$user);
        $this->assign('itemid',$bid);
        $this->assign('roomInfo',$roomInfo);
        $this->getHeaderAndFooter();
        $this->display('shop/plate/course_bundle_info');
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