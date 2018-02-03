<?php
class FixpayController extends CControl{
	public function index(){
		set_time_limit(0);
		$db = Ebh::app()->getDb();
		$thesql = '';
		$sql = "select up.uid,up.folderid,count(*) as ucount from ebh_userpermisions up group by up.uid,up.folderid having ucount>1";
		$uplist = $db->query($sql)->list_array();
		$maxidlist = array();
		$delidlist = array();
		if(!empty($uplist)) {
			foreach($uplist as $myup) {
				$uid =$myup['uid'];
				$folderid = $myup['folderid'];
				$subsql = "select *from ebh_userpermisions up where up.uid=$uid and up.folderid=$folderid order by enddate desc";
				$sublist = $db->query($subsql)->list_array();
				if(!empty($sublist)) {
					$i = 0;
					foreach($sublist as $subup) {
						if($i == 0) {
							$maxidlist[$subup['pid']] = $subup;
							$i ++;
						} else {
							$delidlist[$subup['pid']] = $subup;
						}
					}
				}
			}
		}
		if(!empty($delidlist)) {
			$idarr = array_keys($delidlist);
			$idstr = implode(',',$idarr);
			$thesql = "delete from ebh_userpermisions where pid in (".$idstr.")";
		}
		echo 'sql is :'.$thesql;
	}
	
}
?>