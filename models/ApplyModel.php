<?php

/**
 * 学生申请加入教室留言model类ApplyModel
 */
class ApplyModel extends CModel {

    /**
     * 根据applyid 或者 applyid列表 更新信息
     * @param type $param
     * @return boolean
     */
    public function update($param) {
        if (empty($param['applyid']) && empty($param['applyids']))
            return FALSE;
        if (!empty($param['applyid'])) {
            $wherearr = array('applyid', $param['applyid']);
            if(!empty($param['crid'])) {
                $wherearr['crid'] = $param['crid'];
            }
        }
        if (!empty($param['applyids'])) {
            if(!empty($param['crid'])) {
                $wherearr = '(applyid in (' . $param['applyids'] . ') and crid='.$param['crid'].')';
            } else {
                $wherearr = 'applyid in (' . $param['applyids'] . ')';
            }
        }
        $setarr = array();
        if (!empty($param ['realname'])) {
            $setarr['realname'] = $param['realname'];
        }
        if (!empty($param ['email'])) {
            $setarr['email'] = $param['email'];
        }
        if (!empty($param ['phone'])) {
            $setarr['phone'] = $param['phone'];
        }
        if (!empty($param ['qq'])) {
            $setarr['qq'] = $param['qq'];
        }
        if (!empty($param ['message'])) {
            $setarr['message'] = $param['message'];
        }
        if (!empty($param ['status'])) {
            $setarr['status'] = $param['status'];
        }
        if (!empty($param ['applydateline'])) {
            $setarr['applydateline'] = $param['applydateline'];
        }
        if (!empty($param ['verifydateline'])) {
            $setarr['verifydateline'] = $param['verifydateline'];
        }
        if (!empty($setarr))
            return $this->db->update('ebh_applys', $setarr, $wherearr);
        else
            return FALSE;
    }

    /**
     * 根据教室编号获取待审核列表
     * @param type $param
     * @return boolean
     */
    public function getapplylist($param) {
        if (empty($param['crid']))
            return FALSE;
        $sql = 'select a.applyid,a.memberid,a.realname,a.email,a.phone,a.qq,a.message,a.`status`,a.applydateline,a.verifydateline from ebh_applys a';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'a.crid=' . $param['crid'];
        if (isset($param['status']))
            $wherearr[] = 'a.status=' . $param['status'];
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY a.applyid DESC ';
        if (!empty($param['limit']))
            $sql .= ' LIMIT ' . $param['limit'];
        else {
            if (empty($queryarr['page']) || $queryarr['page'] < 1)
                $page = 1;
            else
                $page = $queryarr['page'];
            $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= 'limit ' . $start . ',' . $pagesize;
        }
        return $this->db->query($sql)->list_array();
    }

    /**
     * 根据教室编号获取待审核记录数
     * @param type $param
     * @return int
     */
    public function getapplycount($param) {
        $count = 0;
        if (empty($param['crid']))
            return $count;
        $sql = 'select count(*) count from ebh_applys a';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'a.crid=' . $param['crid'];
        if (isset($param['status']))
            $wherearr[] = 'a.status=' . $param['status'];
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
    }

    /**
     * 根据applyids获取待审核列表
     * @param string $applyids
     * @return list
     */
    public function getapplysbyids($param) {
        if (empty($param['crid']) || empty($param['applyids']))
            return FALSE;
        $sql = 'select a.applyid,a.memberid,a.realname,a.email,a.phone,a.qq,a.message,a.`status`,a.applydateline,a.verifydateline from ebh_applys a';
        $wherearr = array();
        $wherearr[] = 'a.crid=' . $param['crid'];
        $wherearr[] = 'a.applyid in (' . $param['applyids'] . ')';
        if (isset($param['status']))
            $wherearr[] = 'a.status=' . $param['status'];
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        return $this->db->query($sql)->list_array();
    }

}
