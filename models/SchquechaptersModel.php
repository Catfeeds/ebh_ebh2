<?php
/**
 * 题目知识点关联类
 */
class SchquechaptersModel extends CModel {
	/**
	 *获取知识点关联qid
	 */
	public function getchapterqids($param){
		$sql = "select distinct qid from `ebh_schquechapters` q left join `ebh_schchapters` c on q.chapterid = c.chapterid";
		if(!empty($param['verpath'])){
			$or[] = 'c.chapterpath like '.'\''.$param['verpath'].'%\'';
		}
		if(!empty($param['chapterid'])){
			$or[] = 'q.chapterid = '.$param['chapterid'];
		}
		if(!empty($param['crid'])){
			$where[] = 'c.crid = '.$param['crid'];
		}
		if(!empty($or)){
			$where[] = '('.implode(' OR ',$or).')';
		}
		if(!empty($where)){
			$sql .= ' WHERE '.implode(' AND ',$where);
		}
		$list = $this->db->query($sql)->list_array();
		return $list;
	}
	/**
	 * 获取指定chapterid下的所有子知识点
	 */
	public function getcnodesbychapterid($chapterid){
		$ret = array();
		if(empty($chapterid) || $chapterid <=0){
			return $ret;
		}
		$sql = 'select chapterid,chaptername,chapterpath from `ebh_schchapters` WHERE chapterid = '.$chapterid.' LIMIT 1';
		$chapter =  $this->db->query($sql)->row_array();
		if(empty($chapter)){
			return $ret;
		}
		$root_path = $chapter['chapterpath'];
		$sql = 'select chapterid from `ebh_schchapters` WHERE chapterpath like \''.$root_path.'%\'';
		$chapters = $this->db->query($sql)->list_array();
		return $chapters ? $chapters : $ret;
	}
	/**
	 * 获取知识点相关联的题目
	 */
	public function getlist($param){
		$sql = 'select c.chapterid,c.qid from `ebh_schquechapters` c';
		if(!empty($param['qid'])){
			$wherearr[] = ' c.qid = '.$param['qid'];
		}
		if(!empty($param['chapterid'])){
			$wherearr[] = ' c.chapterid = '.$param['chapterid'];
		}
		if(!empty($param['chapterids'])){
			$wherearr[] = ' c.chapterid in ('.implode(',',$param['chapterids']).')';
		}
		if(!empty($wherearr))
			$sql .= ' where '.implode(' and ',$wherearr);
		$sql .= ' order by c.qid,c.chapterid';
		$retarr = $this->db->query($sql)->list_array();
		return $retarr ? $retarr : array();
	}
	/**
	 * 获取指定chapterid下的所有对应的folderid
	 */
	public function getfolderbychapterid($chapterid, $crid){
		$ret = array();
		if(empty($chapterid) || empty($crid)){
			return $ret;
		}
		$sql = 'select folderid,chapterid from `ebh_schchapters` WHERE chapterid in ('.$chapterid.') AND crid='.$crid;
		$chapter =  $this->db->query($sql)->list_array();
		if(empty($chapter)){
			return $ret;
		}
		return $chapter;
	}
}