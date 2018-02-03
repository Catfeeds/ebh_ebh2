<?php
/**
 * 获取网校二维码图
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/12/22
 * Time: 17:04
 */
class Qcode {
    public function __construct()
    {

    }
    public function get_qcode() {
        //return "http://static.ebanhui.com/ebh/tpl/2016/images/wxxx.png";
        $db = Ebh::app()->getDb();
        $roominfo = Ebh::app()->room->getcurroom();
        $sql = "SELECT `image` FROM `ebh_component_item_options` WHERE `crid`={$roominfo['crid']} AND `mid`=13 AND `status`=0 ORDER BY `oid` DESC LIMIT 1";
        $qcode = $db->query($sql)->row_array();
        if (!empty($qcode)) {
            if (stripos($qcode['image'], 'http://') === false) {
                $upconfig = Ebh::app()->getConfig()->load('upconfig');
                $baseurl = $upconfig['hmodule']['showpath'];
                return $baseurl.$qcode['image'];
            }
            return $qcode['image'];
        }
        if (!empty($roominfo['wechatimg'])) {
            return $roominfo['wechatimg'];
        }
        return "http://static.ebanhui.com/ebh/tpl/newschoolindex/images/qcode.jpg";
    }
}