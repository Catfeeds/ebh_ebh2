<?php
/**
 * 提交域名保存的信息
 */

class DomaincheckModel extends CModel
{


    public function editdomain($param){
        /**
         * 保存域名的信息和提交时间
         */
        $param['crid'] = intval($param['crid']);
        $cridresult=$this->checkcrid($param['crid']);

        if(!empty($cridresult['crid'])){ //
            $setarr['fulldomain']=$param['fulldomain'];
            $setarr['domain_time'] = $param['domain_time'];
            if(isset($param[icp])){
                $setarr['icp']=$param['icp'];
            }
            $wherearr = array('crid'=>$param['crid']);
            $res = $this->db->update('ebh_domainchecks',$setarr,$wherearr);

        }else{
            if(!empty($param)){
                $setarr['crid'] = $param['crid'];
                $setarr['fulldomain'] = $param['fulldomain'];
                $setarr['domain_time'] = $param['domain_time'];
                $setarr['crname']=$param['crname'];
            }

            $res = $this->db->insert('ebh_domainchecks',$setarr);
        }

        return  $res;
    }
    public function checkcrid($crid){//检查是否已经存在该域名信息
        $sql='select crid from ebh_domainchecks where crid='.$crid;
        // print_r($sql);die;
        return    $this->db->query($sql)->row_array();

    }

    public function  getdomain($crid){//获取域名信息
        if(empty($crid)){
            return false;
        }else{
            $sql='select fulldomain from ebh_domainchecks where crid='.$crid;
            return $this->db->query($sql)->row_array();
        }
    }
    public function deldomain($param){//解除绑定后把域名和备案信息删除
        $param['crid'] = intval($param['crid']);
        if(empty($param['crid'])){
            return false;
        }else{
            $setarr['icp'] = $param['icp'];
            $setarr['fulldomain'] = $param['fulldomain'];
            $wherearr = array('crid'=>$param['crid']);
            //print_r($setarr);die;
            $res = $this->db->update('ebh_domainchecks',$setarr,$wherearr);
            return $res;
        }

    }



}