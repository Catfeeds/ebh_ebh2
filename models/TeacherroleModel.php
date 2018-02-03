<?php
/**
 * 教师角色
 */
class TeacherroleModel extends CModel
{
    /**
     * 查询教师已分配的角色
     * @param $tid 教师ID
     * @param $crid 网校ID
     * @return int
     */
    public function getTeacherRole($tid, $crid) {
        $tid = intval($tid);
        $crid = intval($crid);
        $sql = 'SELECT `a`.`role`,`a`.`status`,IFNULL(`b`.`rid`,0) AS `rid`,`b`.`permissions`,`b`.`category` FROM `ebh_roomteachers` `a` LEFT JOIN `ebh_teacher_roles` `b` ON `b`.`rid`=`a`.`role` AND `b`.`crid`=`a`.`crid` WHERE `a`.`tid`='.$tid.' AND `a`.`crid`='.$crid;
        $ret = $this->db->query($sql)->row_array();
        if (empty($ret)) {
            return 0;
        }
        if (empty($ret['rid'])) {
            $role = intval($ret['role']);
            if (in_array($role, array(1, 2, 3))) {
                return $role;
            }
            return 1;
        }
        if (intval($ret['status']) != 1) {
            return 1;
        }
        return $ret;
    }
}
