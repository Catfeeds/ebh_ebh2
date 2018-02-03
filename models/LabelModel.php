<?php
/**
 * ����model��
 */
class LabelModel extends CModel{
    /**
     * ��ȡlabel�б�(������У�б����)
     */
    public function getLabelList($param = array()) {
        $sql = 'SELECT labelid,title FROM ebh_labels';
         if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY displayorder';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
    }
}
?>