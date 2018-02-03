<?php

/**
 * 支付model类PaymentModel
 * 主要用于学员开通(支付)服务等数据处理
 */
class PaymentModel extends CModel {

    /**
     * 根据教室编号获取学员开通记录列表
     * @param type $param
     */
    public function getopenlistbycrid($param) {
        if (empty($param['crid']))
            return FALSE;
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'SELECT t.stid,t.username,t.realname,t.dateline,t.money,t.ordernumber,t.addtime,t.paytime,t.payfrom,t.type,t.payfrom,t.paycode,t.dateline FROM ebh_tempstudents t ';
        $wherearr = array();
        $wherearr[] = 't.crid=' . $param['crid'];
        if (!empty($param ['stardateline'])) {
            $wherearr[] = 't.paytime >= ' . $param['stardateline'];
        }
        if (!empty($param ['enddateline'])) {
            $wherearr[] = 't.paytime <= ' . $param['enddateline'];
        }
        if (!empty($param ['payfrom'])) {
            $wherearr[] = 't.payfrom = ' . $param['payfrom'];
        }
        $wherearr[] = 't.status=1';
        if (!empty($param ['ordernumber'])) {
            $wherearr[] = '( t.ordernumber LIKE \'%' . $this->db->escape_str($param['ordernumber']) . '%\' ) ';
        }
        if (!empty($param['q'])) {
            $wherearr [] = ' ( t.username LIKE \'%' .  $this->db->escape_str($param ['q']) . '%\' or t.ordernumber LIKE \'%' .  $this->db->escape_str($param ['q']) . '%\') ';
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['order']))
            $sql .= ' ORDER BY '.$param['order'];
        else
            $sql .= ' ORDER BY t.stid DESC ';
        $sql .= 'limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据教室编号获取学员开通记录数
     * @param type $param
     */
    public function getopenlistcountbycrid($param) {
        $count = 0;
        if (empty($param['crid']))
            return $count;
       
        $sql = 'SELECT count(*) count FROM ebh_tempstudents t ';
        $wherearr = array();
        $wherearr[] = 't.crid=' . $param['crid'];
        if (!empty($param ['stardateline'])) {
            $wherearr[] = 't.paytime >= ' . $param['stardateline'];
        }
        if (!empty($param ['enddateline'])) {
            $wherearr[] = 't.paytime <= ' . $param['enddateline'];
        }
        if (!empty($param ['payfrom'])) {
            $wherearr[] = 't.payfrom = ' . $param['payfrom'];
        }
        $wherearr[] = 't.status=1';
        if (!empty($param ['ordernumber'])) {
            $wherearr[] = '( t.ordernumber LIKE \'%' . $this->db->escape_str($param['ordernumber']) . '%\' ) ';
        }
        if (!empty($param['keyword'])) {
            $wherearr [] = ' ( t.username LIKE \'%' .  $this->db->escape_str($param ['keyword']) . '%\' or t.ordernumber LIKE \'%' .  $this->db->escape_str($param ['keyword']) . '%\') ';
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
            $count = $row['count'];
        return $count;
    }
}
