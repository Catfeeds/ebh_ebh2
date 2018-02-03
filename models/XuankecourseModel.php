<?php
/**
 * 选课
 * Created by PhpStorm.
 * User: app
 * Date: 2016/7/18
 * Time: 15:09
 */
class XuankecourseModel extends CModel {
    public function add($param) {
        return $this->db->insert('ebh_xk_courses', $param);
    }
}