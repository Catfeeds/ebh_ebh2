<?php

/**
 * Class IcsModel
 * 互动课堂互动表model
 */
class IcsModel extends CModel{
    /**
     * 学生互动课堂互动表
     */
    public function getListByRoom(array $param){
        if(empty($param['crid']) || empty($param['uid'])){
            return false;
        }
        $sql = 'select s.* from ebh_ics as s join ebh_icfolders as f on s.icid=f.icid join ebh_userpermisions as u on u.folderid = f.folderid';
        $where = ' where s.crid = '.$param['crid']. ' and u.uid ='.$param['uid'].' and s.status = 1';
        $sql .= $where;
        if(!empty($param['q'])){
            $sql .= ' and s.titlenotag like \'%'.$param['q'].'%\'';
        }
        $sql .= ' group by s.icid  order by s.dateline desc';
        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
            if (empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
        return $this->db->query($sql)->list_array();
    }
    /**
     * 搜索学生互动课堂互动表
     */
    public function getListByKeywords(array $parm){
        if(empty($parm['crid']) || empty($parm['uid'])){
            return false;
        }
        $sql = 'select s.* from ebh_ics as s join ebh_icfolders as f on s.icid=f.icid join ebh_userpermisions as u on u.folderid = f.folderid';
        $where = ' where s.crid = '.$parm['crid']. ' and s.status = 1 and u.uid ='.$parm['uid'].' and s.titlenotag like \'%'.$parm['keywords'].'%\'';
        $sql .= $where;
        $sql .= ' group by s.icid  order by dateline desc';
        return $this->db->query($sql)->list_array();
    }
    //参数: ids 课程id json格式的
    public function getStudentNumByFolderIds($ids){
        return 100;
    }

    //作用：判断用户是否参与过该互动
    //参数： uid 用户id icid 互动id crid 网校id
    public function checkIfJoined($uid ,$icid,$crid){
        if(!$uid || !$icid || !$crid){
            return false;
        }
        //如果答题表里面有uid 和 icid 则参加过该互动
        $sql = 'select * from ebh_icanswers where uid = '.$uid.' and icid = '.$icid.' and crid = '.$crid;
        $res = $this->db->query($sql)->list_array();
        return  empty($res) ? 0 : 1; 
    }

    //作用获取互动信息
    //参数：icid 互动id
    public function getIcsById($icid){
        if(!$icid){
            return false;
        }
         $sql = 'select * from ebh_ics where icid = '.$icid.' and status = 1';
         return $this->db->query($sql)->row_array();
    }

    //作用：相应互动 回答人数+1 
    //icid 互动id
    public function increaseAnswercount($icid){
        if(!$icid){
            return false;
        }
        $sql = 'update ebh_ics set answercount = answercount + 1 where icid = '.$icid;
        $this->db->query($sql);
    }
    //作用 累加回答总时间
    public function increaseTotaltime($icid,$time){
        if(!$icid || !$time){
            return false;
        }
         $sql = 'update ebh_ics set totaltime = totaltime + '.$time.' where icid = '.$icid;
        $this->db->query($sql);
    }
    public function getListCount($param){
        //  if(empty($param['crid']) || empty($param['uid'])){
        //     return false;
        // }
        // $sql = 'select count(*) as count from ebh_ics as s join ebh_icfolders as f on s.icid=f.icid join ebh_userpermisions as u on u.folderid = f.folderid';
        // $where = ' where s.crid = '.$param['crid']. ' and u.uid ='.$param['uid'].' and s.status = 1';
        // $sql .= $where;
        // if(!empty($param['q'])){
        //     $sql.= ' and titlenotag like \'%'.$param['q'].'%\'';
        // }
        // $count = $this->db->query($sql)->list_array();
        // return $count['count'];
        if(empty($param['crid']) || empty($param['uid'])){
            return false;
        }
        $sql = 'select s.* from ebh_ics as s join ebh_icfolders as f on s.icid=f.icid join ebh_userpermisions as u on u.folderid = f.folderid';
        $where = ' where s.crid = '.$param['crid']. ' and u.uid ='.$param['uid'].' and s.status = 1';
        $sql .= $where;
        if(!empty($param['q'])){
            $sql .= ' and s.titlenotag like \'%'.$param['q'].'%\'';
        }
        $sql .= ' group by s.icid  order by s.dateline desc';
        return count($this->db->query($sql)->list_array());
    }
    
    //获取未参加的互动数
    //$uid 用户id crid 网校id
    public function getUnJoinedNum($param){
        if(empty($param['crid']) || empty($param['uid'])){
            return false;
        }
        $sql = 'select s.* from ebh_ics as s join ebh_icfolders as f on s.icid=f.icid join ebh_userpermisions as u on u.folderid = f.folderid';
        $where = ' where s.crid = '.$param['crid']. ' and u.uid ='.$param['uid'].' and s.status = 1';
        $sql .= $where;
        $sql .= ' group by s.icid  order by s.dateline desc';
        $lists = $this->db->query($sql)->list_array();
        $unFinishedCnt = 0;
        foreach ($lists as $item) {
            if(!$this->checkIfJoined($param['uid'], $item['icid'], $param['crid'])){
                $unFinishedCnt++;
            }
        }
        return $unFinishedCnt;
    }
}
?>