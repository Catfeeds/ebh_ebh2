<?php

/**
 * 教师控制权限Model类RoomcontrolModel
 */
class RoomcontrolModel extends CModel {

    /**
     * 添加教师在网校的操作权限 主要操作 ebh_roomcontrols表
     * @param type $param
     * @return boolean
     */
    public function insert($param) {
        $setarr = array();
        if (empty($param['rid']) || empty($param['tid']))
            return FALSE;
        $setarr['rid'] = $param['rid'];
        $setarr['tid'] = $param['tid'];
        if (!empty($param ['modulepower'])) {
            $setarr['modulepower'] = $param['modulepower'];
        }
        if (!empty($param ['folderpath'])) {
            $setarr['folderpath'] = $param['folderpath'];
        }
        if (!empty($param ['dateline'])) {
            $setarr['dateline'] = $param['dateline'];
        } else {
            $setarr['dateline'] = SYSTIME;
        }
        $result = $this->db->insert('ebh_roomcontrols', $setarr);
        return $result;
    }

    /**
     * 修改教师在网校的操作权限 主要操作 ebh_roomcontrols表
     * @param type $param
     * @return boolean
     */
    public function update($param) {
        $setarr = array();
        if (empty($param['rid']) || empty($param['tid']))
            return FALSE;
        $wherearr = array('rid' => $param['rid'], 'tid' => $param['tid']);
        if (!empty($param ['modulepower'])) {
            $setarr['modulepower'] = $param['modulepower'];
        }
        if (!empty($param ['folderpath'])) {
            $setarr['folderpath'] = $param['folderpath'];
        }
        if (empty($setarr))
            return FALSE;
        $result = $this->db->update('ebh_roomcontrols', $setarr, $wherearr);
        return $result;
    }

    /**
     * 删除教室内的教师并更新教室教师数
     * @param type $param
     * @return boolean
     */
    public function del($param) {
        if (empty($param['rid']) || empty($param['tid']))
            return FALSE;
        $wherearr = array('rid' => $param['rid'], 'tid' => $param['tid']);
        $afrows = $this->db->delete('ebh_roomteachers', $wherearr);
        return $afrows;
    }
    /**
     * 根据 rid和uid获取该教师在平台的权限。
     * @param type $param
     * @return boolean
     */
    public function getcontrol($param) {
        if (empty($param['rid']) || empty($param['tid']))
            return FALSE;
        $sql = 'select modulepower,folderpath from ebh_roomcontrols where rid='.$param['rid'].' and tid='.$param['tid'];
        return $this->db->query($sql)->row_array();
    }

}
