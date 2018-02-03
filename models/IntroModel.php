<?php

/*
 * 课程开场内容model类
 */

class IntroModel extends CModel {
    /**
     * 获取课程开场内容
     * @param $folderid
     * @return mixed
     */
    public function getDetail($folderid) {
        $folderid = intval($folderid);
        $sql = 'SELECT `attid`,`slides`,`introtype` FROM `ebh_folder_intros` WHERE `folderid`='.$folderid.' AND `status`=0';
        return $this->db->query($sql)->row_array();
    }
}
