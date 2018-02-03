<?php
/**
 * 分类model类
 */
class LabelModel extends CModel{
    /**
     * 获取label列表(用于网校列表左侧)
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