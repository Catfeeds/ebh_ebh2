<?php

/**
 * 兑换model
 */
class RedeemModel extends CModel{

    /**
     *获取批次号
     */
    public function update($param) {
        if (empty($param['lotid']) || empty($param['cardid']) || !is_numeric($param['effectnumber'])) {
            return array();
        }
        $this->db->begin_trans();
        $res = $this->db->query('update ebh_redeem_cards set usetime='.time().',status=1,uid='.$param['uid'] .' where cardid='.$param['cardid']);
        $setarr['effectnumber'] = $param['effectnumber']+1;
        $this->db->update('ebh_redeem_lots',$setarr,array('lotid'=>$param['lotid']));
        if($this->db->trans_status() === FALSE){
            $this->db->rollback_trans();
            return false;
        }else{
            $this->db->commit_trans();
            return true;
        }  

    }

	/**
	 *获取批次号
	 */
	public function getRedeem($id=0) {
		if (!$id) {
			return array();
		}
		$sql = 'select r.lotid,r.name,r.lotcode,i.iprice as fprice,r.price,r.number,f.foldername from ebh_redeem_lots r left join ebh_folders f using(folderid) left join ebh_pay_items i using(itemid) where r.lotid='.$id;
		$res = $this->db->query($sql)->row_array();
        return $res;
	}
    /**
     *获取兑换码
     */
    public function getReedeemCard($card=0,$crid=0) {
        if (!$card) {
            return array();
        }
        $sql = 'select c.status,l.lotcode,l.effectnumber,l.price,l.folderid,l.itemid,l.effecttime,c.cardid,l.lotid from ebh_redeem_cards c left join ebh_redeem_lots l on l.lotid=c.redeemid where c.status=0 and c.redeemnumber=\''.$this->db->escape_str($card).'\' and c.crid='.$crid;
        $res = $this->db->query($sql)->row_array();
        return $res;
    }

    /**
     *根据itemid获取批次号
     */
    public function getRedeemByitemid($id=0) {
        if (!$id) {
            return array();
        }
        $sql = 'select r.lotid,r.name,r.lotcode from ebh_redeem_lots r where r.status=2 and r.itemid='.$id;
        $res = $this->db->query($sql)->row_array();
        return $res;
    }

    /**
	 * 支付成功，更新数据库
	 */
	public function updateRedeem($param = array()){
		if(empty($param['lotid'])){
			return false;
		}
		$setarr = array();
		if(!empty($param['name'])){
			$setarr['name'] = $param['name'];
		}
		if(isset($param['status'])){
			$setarr['status'] = $param['status'];
		}
        $res = $this->db->update('ebh_redeem_lots',$setarr,array('lotid'=>$param['lotid']));//更新
        return $res;
	}

    //获取课程
    public function getFoldersByFolderid($folderid){
        if(empty($folderid)){
            return false;
        }
        $sql = " select foldername,folderid from  ebh_folders where folderid in ( "."'" . implode("','", $folderid) . "'"." )";
        $row = $this->db->query($sql)->list_array();
        return $row;

    }
}