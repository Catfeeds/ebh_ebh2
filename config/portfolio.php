<?php
/**
 * 网校门户模块
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/10/9
 * Time: 17:40
 */
$portfolio = array(
    /*
     * 默认配置
     */
    'default' => '[{"eid":"0","mid":"1","ititle":"\u9875\u5934","columns":"4","rows":"1","max_data_count":"1","left":"0","top":"0","width":"1200","height":"140","background_color":"","code":"logo","show_type":"1","editable":"1","area_sign":[4],"custom_data":[],"ctitle":"\u9875\u5934"},{"eid":"0","mid":"5","ititle":"\u7f51\u6821\u7b80\u4ecb","columns":"3","rows":"1","max_data_count":"1","left":"0","top":"0","width":"915","height":"320","background_color":"","code":"about","show_type":"2","editable":"0","area_sign":[4,3,2,1],"ctitle":"\u7f51\u6821\u7b80\u4ecb"},{"eid":"0","mid":"6","ititle":"\u7528\u6237\u767b\u5f55","columns":"1","rows":"1","max_data_count":"1","left":"915","top":"0","width":"305","height":"330","background_color":"","code":"login","show_type":"2","editable":"0","area_sign":[1],"ctitle":"\u7528\u6237\u767b\u5f55"},{"eid":"0","mid":"2","ititle":"\u9009\u9879\u5361","columns":"4","rows":"1","max_data_count":"1","left":"0","top":"140","width":"1200","height":"50","background_color":"","code":"navigation","show_type":"1","editable":"0","area_sign":[4],"ctitle":"\u9009\u9879\u5361"},{"eid":"0","mid":"3","ititle":"\u8f6e\u64ad\u5927\u56fe","columns":"4","rows":"1","max_data_count":"1","left":"0","top":"190","width":"1200","height":"436","background_color":"","code":"slide","show_type":"1","editable":"1","area_sign":[4],"custom_data":[],"ctitle":"\u8f6e\u64ad\u5927\u56fe"},{"eid":"0","mid":"11","ititle":"\u8bfe\u7a0b\u5217\u8868","columns":"3","rows":"3","max_data_count":"1","left":"0","top":"330","width":"915","height":"990","background_color":"","code":"courselist","show_type":"3","editable":"0","area_sign":[4,3],"ctitle":"\u8bfe\u7a0b\u5217\u8868"},{"eid":"0","mid":"13","ititle":"\u5fae\u4fe1\u516c\u4f17\u53f7","columns":"1","rows":"1","max_data_count":"1","left":"915","top":"330","width":"305","height":"330","background_color":"","code":"official","show_type":"2","editable":"1","area_sign":[1],"custom_data":[],"ctitle":"\u5fae\u4fe1\u516c\u4f17\u53f7"},{"eid":"0","mid":"8","ititle":"\u65b0\u95fb\u8d44\u8baf","columns":"1","rows":"1","max_data_count":"1","left":"915","top":"660","width":"305","height":"330","background_color":"","code":"news","show_type":"2","editable":"0","area_sign":[4,3,2,1],"ctitle":"\u65b0\u95fb\u8d44\u8baf"},{"eid":"0","mid":"12","ititle":"\u5e94\u7528","columns":"1","rows":"1","max_data_count":"6","left":"915","top":"990","width":"305","height":"330","background_color":"","code":"app","show_type":"2","editable":"0","area_sign":[1],"ctitle":"\u5e94\u7528"}]',
    /**
     * 默认头部
     */
    'default-header' => array(
        'background-color' => '#fff',
        //'image' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/scyt.png'
        'image' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/module_header_logo.jpg'
    ),
    /**
     * 默认轮播图
     */
    'default-slide' => array(
        'bgcolor' => '#0a96ed',
        'options' => array(
            array('showurl' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/slide_banner1.jpg'),
            array('showurl' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/slide_banner2.jpg'),
            array('showurl' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/slide_banner3.jpg'),
        )
    ),
    /**
     * 默认校徵
     */
    'default-levy' => 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg',
    /**
     * 默认二维码
     */
    'qcode' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/qcode.jpg',
    /**
     * 广告一占位
     */
    'default-ad-1' => array (
        array('showurl' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/ad_1.jpg')
    ),
    /**
     * 广告二占位
     */
    'default-ad-2' => array (
        array('showurl' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/ad_2.jpg')
    ),
    /**
     * 广告三占位
     */
    'default-ad-3' => array (
        array('showurl' => 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/ad_3.jpg')
    )
);