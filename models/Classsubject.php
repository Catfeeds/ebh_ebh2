<?php
class Classsubject extends CModel {
    function getSubject() {
//        $sql = 'select *from tbl_course limit 10';
        $sql = 'select *from ebh_users limit 10';
        $row = $this->db->query($sql)->list_array();
        return $row;
    }
    function testinsert() {
        $param = array('title'=>"裝我'",'dateline'=>time(),'url'=>'http://www.sss.com/');
        $id = $this->db->insert('tbl_course',$param);
        if($id)
            echo 'insert success ,id is '.$id;
        else
            echo 'insert fail';
    }
    function testupdate() {
        $param = array('title'=>'吸納的ss1','dateline'=>1111,'url'=>'12sdffurl');
        $where = array('id'=>1);
        $af = $this->db->update('tbl_course',$param,$where);
        echo '<br />af row '.$af;
    }
    function tests() {
        $sql = 'select *from tbl_course';
        $rowlist = $this->db->query($sql)->list_array();
    }
    function testu() {
        
    }
    function del($id) {
        $arow = $this->db->delete('tbl_course',array('id'=>$id));
        return $arow;
    }
    function del5($id) {
        if(is_numeric($id)) {
            $where = 'id > '.$id;
            $arow = $this->db->delete('tbl_course',$where);
            return $arow;
        }
        return 0;
    }
    function testtrans() {
        $sql1 = "insert into tbl_course (title,url,dateline) values('title111','url111',11111)";
        $sql2 = "insert into tbl_course (id,title,url,dateline) values(2,'title2','url2',112221)";
        $this->db->begin_trans();
        $this->db->query($sql1);
        $this->db->query($sql2);
        if($this->db->trans_status()===FALSE) {
            echo 'trans fail';
            $this->db->rollback_trans();
        } else {
            echo 'trans success';
            $this->db->commit_trans();
        }
        $this->db->begin_trans();
        $sql3 = "insert into tbl_course (title,url,dateline) values('title3','url3',3)";
        $sql4 = "insert into tbl_course (title,url,dateline) values('title4','url4',4)";
        $this->db->query($sql3);
        $this->db->query($sql4);
        if($this->db->trans_status()===FALSE) {
            echo '2trans fail';
            $this->db->rollback_trans();
        } else {
            echo '2trans success';
            $this->db->commit_trans();
        }
    }
    function getcourse($id) {
        
    }
    function testupdate2() {
        $param = array('title'=>'1122112211','url'=>'12sdffurl');
        $where = array('id'=>1);
        $sparam = array('dateline'=>'dateline+1000');
        $af = $this->db->update('tbl_course',$param,$where,$sparam);
        echo '<br />af row '.$af;
    }
}
?>