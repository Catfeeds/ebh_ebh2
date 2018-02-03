<?php
/**
 * 组卷model类PaperModel
 */
class PaperModel extends CModel{
    public function getPaper($pid) {
        $sql = 'select p.pid,p.title,p.crid,p.totalscore,p.dateline,p.uid from ebh_exampapers p where p.pid='.$pid;
        return $this->db->query($sql)->row_array();
    }
    public function delPaper($pid) {
        return $this->db->delete('ebh_exampapers',array('pid'=>$pid));
    }
    public function getPaperList($queryarr) {
        if(empty($queryarr['crid']))
            return FALSE;
        if(empty($queryarr['page']) || $queryarr['page'] < 1)
            $page = 1;
        else
            $page = $queryarr['page'];
        $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
        $start = ($page - 1) * $pagesize ;
        $sql = 'select p.pid,p.title,p.crid,p.totalscore,p.qtnums,p.dateline from ebh_exampapers p ';
        $wherearr = array();
        $wherearr[] = 'p.crid='.$queryarr['crid'];
        if(!empty($queryarr['uid']))
            $wherearr[] = 'p.uid='.$queryarr['uid'];
        if(!empty($wherearr))
            $sql .= ' WHERE '.implode (' AND ', $wherearr);
        if(!empty($queryarr['order']))
            $sql .= ' order by '.$queryarr['order'];
        else
            $sql .= ' order by p.pid desc ';
        $sql .= 'limit '.$start.','.$pagesize;
        return $this->db->query($sql)->list_array();
    }
    public function getPaperCount($queryarr) {
        if(empty($queryarr['crid']))
            return 0;
        $count = 0;
        $sql = 'select count(*) count from ebh_exampapers p ';
        $wherearr = array();
        $wherearr[] = 'p.crid='.$queryarr['crid'];
        if(!empty($queryarr['uid']))
            $wherearr[] = 'p.uid='.$queryarr['uid'];
        if(!empty($wherearr))
            $sql .= ' WHERE '.implode (' AND ', $wherearr);
        $countrow = $this->db->query($sql)->row_array();
        if(!empty($countrow))
            $count = $countrow['count'];
        return $count;
    }
}
