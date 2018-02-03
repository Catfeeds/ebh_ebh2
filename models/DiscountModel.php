<?php
/**
 * 折扣Model类
 * Author: songpeng
 * Date: 2017/04/28
 */
class DiscountModel extends CModel {
     /**
      *添加折扣
      */
     public function add($crid,$num,$discount){
           $sql = "insert into ebh_discounts (crid,num,discount) values ($crid,$num,$discount) ";
           return $this->db->query($sql);
     }
     /**
      *删除折扣
      */  
     public function del($crid,$num){
           $sql = "delete from ebh_discounts where crid=$crid and num=$num ";
           return $this->db->query($sql);
     }
     /**
      *更新折扣
      */ 
     public function update($crid,$num,$discount){
          $sql = "UPDATE ebh_discounts SET discount = $discount WHERE crid = $crid AND num = $num ";
          return $this->db->query($sql);

     }
     /**
      *根据网校id、数量获得折扣率
      * 
      */
     public function get($crid,$num){

          $sql = "select discount from ebh_discounts where crid=$crid and num=$num ";
          return $this->db->query($sql)->row_array(); 
     }

     /**
      *根据网校id获取折扣列表
      */ 
     public function getlist($crid){

          $sql = "select num,discount from ebh_discounts where crid=$crid"; 
          return $this->db->query($sql)->list_array();
     }

     
}

