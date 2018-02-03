<?php
/**
 * 广告model类
 */
class AdModel extends CModel{
    public function getAdList($param = array()) {
        $sql = 'SELECT i.itemid,i.catid,i.subject,i.thumb,i.dateline,i.fromurl,i.itemurl,i.displayorder from ebh_items i '.
                'join ebh_ads a on (i.itemid = a.itemid) '.
                'join ebh_categories c on (c.catid = i.catid) ';
        $wherearr = array();
        $wherearr[] = 'c.type=\'ad\'';
        if(!empty($param['code'])) {
            $wherearr[] = 'c.code=\''.$param['code'].'\'';
        }
        if(!empty($param['channel'])) {
            $wherearr[] = 'i.channel=\''.$param['channel'].'\'';
        }
        if(!empty($param['folder'])) {
            $wherearr[] = 'i.folder='.$param['folder'];
        }
        if(!empty($param['citycode'])) {
            $wherearr[] = 'i.citycode=\''.$param['citycode'].'\'';
        }
        if(!empty($param['crid'])) {
            $wherearr[] = 'i.crid='.$param['crid'];
        }
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY i.displayorder';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
        return $this->db->query($sql)->list_array();
    }
    
}
