<?php
/**
 * 分类model类
 */
class Category extends CModel{
    /**
     * 根据父ID等信息获取分类列表
     * @param type $upid
     * @param type $position
     * @param type $system
     * @param type $visible
     * @return type
     */
    public function getCatlistByUpid($upid = 0,$position = 0,$system = 1,$visible = 1) {
        $sql = 'SELECT c.catid,c.upid,c.code,c.name,c.keyword FROM ebh_categories c';
        $wherearr = array();
        if($upid !== NULL) {
            $wherearr[] = 'c.upid='.$upid;
        }
        if($position !== NULL) {
            $wherearr[] = 'c.position='.$position;
        }
        if($system !== NULL) {
            $wherearr[] = 'c.system='.$system;
        }
        if($visible !== NULL) {
            $wherearr[] = 'c.visible='.$visible;
        }
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ', $wherearr);
        }
        $sql .= ' order by c.displayorder asc';
        return $this->db->query($sql)->list_array();
    }
}
