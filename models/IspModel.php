<?php
/**
 * 网络提供商
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/5/2
 * Time: 11:13
 */
class IspModel extends CModel{
    /**
     * 获取网络提供商类型号
     * @param $ip
     * @return int
     */
    public function getIspType($ip) {
        if (is_numeric($ip)) {
            $ip = intval($ip);
        } else if(preg_match('/\d{1,3}(?:\.\d{1,3}){3}/', $ip)) {
            $ip = ip2long($ip);
        } else {
            return 0;
        }
        $sql = 'SELECT `isp` FROM `ebh_isps` WHERE `startiplong`=`masklong` & '.$ip.' LIMIT 1';
        $ret = $this->db->query($sql)->row_array();
        if (!empty($ret)) {
            return intval($ret['isp']);
        }
        return 0;
    }
    /**
     * 获取网络提供商ID
     * @param $ip
     * @return int
     */
    public function getIspId($ip) {
        if (is_numeric($ip)) {
            $ip = intval($ip);
        } else if(preg_match('/\d{1,3}(?:\.\d{1,3}){3}/', $ip)) {
            $ip = ip2long($ip);
        } else {
            return 0;
        }
        $sql = 'SELECT `id` FROM `ebh_isps` WHERE `startiplong`=`masklong` & '.$ip.' LIMIT 1';
        $ret = $this->db->query($sql)->row_array();
        if (!empty($ret)) {
            return intval($ret['id']);
        }
        return 0;
    }
}