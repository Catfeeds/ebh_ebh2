<?php
/**
 * plate模块配置数据
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/1/5
 * Time: 15:51
 */
class PlateSet
{
    /**
     * 获取头图
     * @param $crid
     * @return array
     */
    public function getHeaderLogo($crid) {
        $model = Ebh::app()->model('portfolio');
        $modules = $model->getPortfolioConfig($crid);
        foreach ($modules as $module) {
            if ($module['mid'] == 1) {
                $logo_module = $module;
                break;
            }
        }
        if (empty($logo_module['options'][0]['image'])) {
            return array(
                'img' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/module_header_logo.jpg',
                'bgcolor' => 'f7f7f7'
            );
        }
        $ret = array(
            'img' => $logo_module['options'][0]['image']
        );
        if (!empty($logo_module['bgcolor'])) {
            $ret['bgcolor'] = $logo_module['bgcolor'];
        }
        return $ret;
    }

    /**
     * 获取导航栏
     * @param $crid
     * @return bool
     */
    public function getNavigator($crid) {
        $room_cache = Ebh::app()->lib('Roomcache');
        $cache_set = array(
            'module' => 'navigator',
            'param' => 'plate-navigation',
            'expire' => 3600,//1小时
            'needupdate' => true
        );
        $navigatordata = $room_cache->getCache($crid, $cache_set['module'], $cache_set['param']);
        if (!empty($navigatordata)) {
            return $navigatordata;
        }
        $tourl = null;
        $model = Ebh::app()->model('portfolio');
        $navigatordata = $model->getNavigator($crid, $tourl);
        if (empty($navigatordata)){
            return false;
        }
        $room_cache->setCache($crid,
            $cache_set['module'],
            $cache_set['param'],
            $navigatordata,
            $cache_set['expire'],
            $cache_set['needupdate']);
        return $navigatordata;
    }
}