<?php
/**
 * 域名审核
 */
class DomainModel extends CModel
{
    /**
     * 获取审核后的域名信息
     */
    public function getDomainInfo($crid,$type)
    {
        $sql = 'select c.crid,c.fulldomain,c.crname,ck.admin_status,ck.teach_status,ck.del,ck.admin_uid from ebh_classrooms c left join ebh_billchecks ck on ck.toid = c.crid where c.crid='.$crid.' AND type=.$type';
        $row = $this->db->query($sql)->row_array();
        //print_r($sql);die;
        return $row;
    }

}