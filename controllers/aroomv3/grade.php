<?php
/**
 * 年级列表
 * Created by ycq.
 * User: ycq
 * Date: 2018/3/5
 * Time: 13:33
 */
class GradeController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 年级列表
     */
    public function classlist() {
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Classes.getRoomList')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('hasGrade', 0)
            ->request();
        switch($this->roominfo['grade']) {
            case 1:
                $list = array(
                    1 => array('grade' => '一年级', 'gid' => 1, 'classlist' => array()),
                    2 => array('grade' => '二年级', 'gid' => 2, 'classlist' => array()),
                    3 => array('grade' => '三年级', 'gid' => 3, 'classlist' => array()),
                    4 => array('grade' => '四年级', 'gid' => 4, 'classlist' => array()),
                    5 => array('grade' => '五年级', 'gid' => 5, 'classlist' => array()),
                    6 => array('grade' => '六年级', 'gid' => 6, 'classlist' => array())
                );
                break;
            case 7:
                $list = array(
                    7 => array('grade' => '初一', 'gid' => 7, 'classlist' => array()),
                    8 => array('grade' => '初二', 'gid' => 8, 'classlist' => array()),
                    9 => array('grade' => '初三', 'gid' => 9, 'classlist' => array())
                );
                break;
            case 9:
                $list = array(
                    1 => array('grade' => '一年级', 'gid' => 1, 'classlist' => array()),
                    2 => array('grade' => '二年级', 'gid' => 2, 'classlist' => array()),
                    3 => array('grade' => '三年级', 'gid' => 3, 'classlist' => array()),
                    4 => array('grade' => '四年级', 'gid' => 4, 'classlist' => array()),
                    5 => array('grade' => '五年级', 'gid' => 5, 'classlist' => array()),
                    6 => array('grade' => '六年级', 'gid' => 6, 'classlist' => array()),
                    7 => array('grade' => '初一', 'gid' => 7, 'classlist' => array()),
                    8 => array('grade' => '初二', 'gid' => 8, 'classlist' => array()),
                    9 => array('grade' => '初三', 'gid' => 9, 'classlist' => array())
                );
                break;
            case 10:
                $list = array(
                    10 => array('grade' => '高一', 'gid' => 10, 'classlist' => array()),
                    11 => array('grade' => '高二', 'gid' => 11, 'classlist' => array()),
                    12 => array('grade' => '高三', 'gid' => 12, 'classlist' => array())
                );
                break;
        }
        $list[0] = array('grade' => '其他', 'gid' => 0, 'classlist' => array());
        if (!empty($ret)) {
            foreach ($ret as $item) {
                $index = isset($list[$item['grade']]) ? $item['grade'] : 0;
                $list[$index]['classlist'][] = array(
                    'classid' => $item['classid'],
                    'classname' => $item['classname']
                );
            }
            $list = array_filter($list, function($item) {
               return !empty($item['classlist']);
            });
            $list = array_values($list);
        }
        $this->renderjson(0, '', $list);
    }
}