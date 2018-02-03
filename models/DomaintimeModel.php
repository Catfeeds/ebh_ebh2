<?php
/**
* 域名提交时间
*/
    class DomaintimeModel extends CModel
    {


    public function editdomaintime($tparam){
        /**
         * 添加域名提交时间
         */
        $tparam['crid'] = intval($tparam['crid']);
        $cridresult=$this->checkcrid($tparam['crid']);
        if(!empty($cridresult['crid'])){ //
            $setarr['crid'] = $tparam['crid'];
            $setarr['domain_time'] = $tparam['domain_time'];
            $wherearr = array('crid'=>$tparam['crid']);
            //print_r($setarr);die;
            $res = $this->db->update('ebh_domain_time',$setarr,$wherearr);

        }else{
            $setarr['crid'] = $tparam['crid'];
            if(!empty($tparam['domain_time']))
                $setarr['domain_time'] = $tparam['domain_time'];
            $res = $this->db->insert('ebh_domain_time',$setarr);
        }

        return  $res;
    }
    public function checkcrid($crid){
     $sql='select crid from ebh_domain_time where crid='.$crid;
       // print_r($sql);die;
     return    $this->db->query($sql)->row_array();

    }

    }