<?php
/**
 * 回答相关model类 AskanswersModel
 */
class AskanswersModel extends CModel{
	/**
	*求的答疑最新动态
	*/
	public function getaskanswers(){
		$sql = 'SELECT a.aid,a.qid,q.uid,u.username as qr,us.username as wr FROM ebh_askanswers a '
		.'left join ebh_askquestions q on (a.qid = q.qid) '
		.'left join ebh_users u on (q.uid = u.uid) '
		.'left join ebh_users us on (us.uid = a.uid) order by a.dateline desc LIMIT 0,5';
        return $this->db->query($sql)->list_array();
	}
}
?>