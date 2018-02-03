<?php
/*
公共题库
*/
class PubquestionModel extends CModel{
	/*
	问题列表
	@param array $param
	@return array
	*/
	public function getpubquestionlist($param){
		$sql = 'select a.aqid,a.title,a.dateline,g.gradename,s.subjectname,c.chaptername from ebh_aquestions a left join ebh_grades g on a.gradeid=g.gradeid left join ebh_subjects s on a.subjectid=s.subjectid left join ebh_chapters c on a.chapterid=c.chapterid';
		if(isset($param['q']))
			$wherearr[] = '  a.title like \'%'. $this->db->escape_str($param['q']) .'%\'';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.=' order by a.displayorder ,a.gradeid desc';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
	}
	/*
	问题数量
	@param array $param
	@return int
	*/
	public function getpubquestioncount($param){
		$sql = 'select count(*) count from ebh_aquestions a ';
		if(isset($param['q']))
			$wherearr[] = '  a.title like \'%'. $this->db->escape_str($param['q']) .'%\'';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
			
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	删除问题
	@param int $aqid
	@return bool
	*/
	public function deletepubquestion($aqid){
		$sql = 'delete a.* from ebh_aquestions a where aqid='.$aqid;
		return $this->db->simple_query($sql);
	}

	/**
	 *
	 *
	 */
	public function getCount($param=array()){
		$sql = 'select count(*) count from ebh_aquestions aq left join ebh_grades g on aq.gradeid = g.gradeid left join ebh_subjects s on aq.subjectid = s.subjectid';
		$whereArr = array();
		if(!empty($param['in'])){
			$whereArr = 'g.subject in '.$param['in'];
		}
		if(!empty($whereArr)){
			$sql.=implode(' AND ',$whereArr);
		}
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}

	/**
	*获取收藏的试题列表
	*/
	function block_favorite($paramarr = array()){
		$sqlarr = $wherearr = array();
		$sqlarr ['select'] ='SELECT aq.*';
		$sqlarr ['from'] = ' FROM ebh_aquestions aq join ebh_favorites f on aq.aqid = f.sourceid ';
		//where
		if(isset( $paramarr['aqid'])){
			$paramarr['aqid'] = (int)$paramarr ['aqid'];
			if($paramarr['qid']){
				$wherearr[] = 'aqid IN ('.$paramarr['aqid'].')';
			}
		}
		if(!empty($paramarr ['title'])){
			$wherearr[] = 'aq.title like \'%'.$paramarr['title'].'%\'';
		}
		if(!empty($paramarr ['gradeid'])){
			$wherearr[] = 'aq.gradeid = '.$paramarr['gradeid'];
		}
		if(!empty($paramarr ['uid'])){
			$wherearr[] = 'aq.uid = '.$paramarr['uid'];
		}
		if(!empty($paramarr ['subjectid'])){
			$wherearr[] = 'aq.subjectid = '.$paramarr['subjectid'];
		}
		if (!empty($paramarr['chapterid'])) {
			$chapterid = intval($paramarr['chapterid']);
			$chapterpath = $this->getchapterpath($chapterid);
			if(!empty($chapterpath)) {
				$wherearr [] = '(aq.chapterid='.$chapterid.' or aq.chapterpath like  \'' . $chapterpath . '/%\')';
			} else {
				$wherearr [] = 'aq.chapterid='.$chapterid;
			}
		}
		if (! empty ( $paramarr ['keyname'] ) && trim($paramarr ['keyname']) != '') {
			$paramarr ['keyname'] = str_replace('%','\\%',$paramarr ['keyname']);
			$wherearr [] = ' ( title LIKE \'%' . trim($paramarr ['keyname']) . '%\' ) ';
		}

		if(isset($paramarr ['difficulty'])){
			$wherearr[] = 'aq.difficulty = '.$paramarr['difficulty'];
		}
		if(isset($paramarr ['falsenum'])){
			$wherearr[] = 'aq.falsenum = '.$paramarr['falsenum'];
		}
		if(isset($paramarr ['truenum'])){
			$wherearr[] = 'aq.truenum = '.$paramarr['truenum'];
		}
		if(isset($paramarr ['relationid'])){
			$wherearr[] = 'aq.relationid = '.$paramarr['relationid'];
		}
		if(!empty($paramarr ['quetype']) && $paramarr ['quetype']!="0"){
			$wherearr['quetype'] = 'aq.quetype = \''.$paramarr['quetype'].'\'';
		}
		if(!empty($paramarr ['curuid'])){
			$wherearr[] = 'f.uid = '.intval($paramarr['curuid']);
		}
		if(!empty($paramarr ['type'])){
			$wherearr[] = 'f.type = '.intval($paramarr['type']);
		} else {
			$wherearr[] = 'f.type = 4';	//默认为收藏的题库 
		}
		if(!empty($wherearr)){$sqlarr ['where'] = ' WHERE ' . implode ( ' AND ', $wherearr );}
		//order
		$sqlarr ['order'] = 'ORDER BY ' . (!empty($paramarr ['order'])?$paramarr['order'] : 'f.fid desc ');
		//pagesize
		if(!empty($paramarr['pagesize'])){
			$paramarr['pagesize'] = intval($paramarr['pagesize']);
			if (intval($paramarr['page'])<= 0){$paramarr['page'] = 1;}
			$start = ($paramarr['page'] - 1) * $paramarr['pagesize'];
			$sqlarr['limit'] = 'LIMIT ' . $start . ',' . $paramarr ['pagesize'];
		}else{
			if (empty($paramarr ['limit'])){
				$sqlarr['limit'] = 'LIMIT 0,1';
			}
		}
		$sqlstring = implode (' ',$sqlarr);
		//multi
		$listcount = 1;
		if (!empty($paramarr['pagesize'])){
			$temparr = $this->db->query('SELECT COUNT(*) count  ' . $sqlarr ['from'] . $sqlarr ['where'])->row_array();
			$listcount = $temparr ['count'];
			if($listcount){
				$theblockarr['multipage'] = ajaxpage($listcount,$paramarr['pagesize'],$paramarr['page']);
			} else {
				$theblockarr['multipage'] = '';
			}
		}
		if($listcount){
			$theblockarr['datas'] = $this->db->query($sqlstring)->list_array();
		}
		return $theblockarr;
	}

	/**
	 *获取公共的试题列表
	 */
	function block($paramarr = array()){
		$sqlarr = $wherearr = array();
		$sqlarr ['select'] ='SELECT aq.*';
		$sqlarr ['from'] = ' FROM ebh_aquestions aq ';
		//where
		if(isset( $paramarr['aqid'])){
			$paramarr['aqid'] = (int)$paramarr ['aqid'];
			if($paramarr['qid']){
				$wherearr[] = 'aqid IN ('.$paramarr['aqid'].')';
			}
		}
		if(!empty($paramarr ['title'])){
			$wherearr[] = 'aq.title like \'%'.$paramarr['title'].'%\'';
		}
		if(!empty($paramarr ['gradeid']) && $paramarr ['gradeid']!="0"){
			$wherearr[] = 'aq.gradeid = '.$paramarr['gradeid'];
		}
		if(!empty($paramarr ['uid'])){
			$wherearr[] = 'aq.uid = '.$paramarr['uid'];
		}
		if(!empty($paramarr ['subjectid']) && $paramarr ['subjectid']!="0"){
			$wherearr[] = 'aq.subjectid = '.$paramarr['subjectid'];
		}
		if (!empty($paramarr['chapterid']) && $paramarr ['chapterid']!="0") {
			$chapterid = intval($paramarr['chapterid']);
			$chapterpath = $this->getchapterpath($chapterid);
			if(!empty($chapterpath)) {
				$wherearr [] = '(aq.chapterid='.$chapterid.' or aq.chapterpath like  \'' . $chapterpath . '/%\')';
			} else {
				$wherearr [] = 'aq.chapterid='.$chapterid;
			}
		}
		if (! empty ( $paramarr ['keyname'] ) && trim($paramarr ['keyname']) != '') {
			$paramarr ['keyname'] = str_replace('%','\\%',$paramarr ['keyname']);
			$wherearr [] = ' ( title LIKE \'%' . trim($paramarr ['keyname']) . '%\' ) ';
		}

		if(isset($paramarr ['difficulty'])){
			$wherearr[] = 'aq.difficulty = '.$paramarr['difficulty'];
		}
		if(isset($paramarr ['falsenum'])){
			$wherearr[] = 'aq.falsenum = '.$paramarr['falsenum'];
		}
		if(isset($paramarr ['truenum'])){
			$wherearr[] = 'aq.truenum = '.$paramarr['truenum'];
		}
		if(isset($paramarr ['relationid'])){
			$wherearr[] = 'aq.relationid = '.$paramarr['relationid'];
		}
		if(!empty($paramarr ['quetype']) && $paramarr ['quetype']!="0"){
			$wherearr['quetype'] = 'aq.quetype = \''.$paramarr['quetype'].'\'';
		}
		if(!empty($wherearr)){$sqlarr ['where'] = ' WHERE ' . implode ( ' AND ', $wherearr );}
		//order
		$sqlarr ['order'] = 'ORDER BY ' . (!empty($paramarr ['order'])?$paramarr['order'] : 'aqid desc ');
		//pagesize
		if(!empty($paramarr['pagesize'])){
			$paramarr['pagesize'] = intval($paramarr['pagesize']);
			if (empty($paramarr ['pagesize'])){$paramarr ['pagesize'] = 20;}
			if (intval($paramarr['page'])<= 0){$paramarr['page'] = 1;}
			$start = ($paramarr['page'] - 1) * $paramarr['pagesize'];
			$sqlarr['limit'] = 'LIMIT ' . $start . ',' . $paramarr ['pagesize'];
		}else{
			if (empty($paramarr ['limit'])){
				$sqlarr['limit'] = 'LIMIT 0,1';
			}
		}
		$sqlstring = implode (' ',$sqlarr);
		//multi
		$listcount = 1;
		if (!empty($paramarr['pagesize'])){
			if (empty($sqlarr ['where'])) {
				$sqlarr ['where'] = '';
			}
			$temparr = $this->db->query('SELECT COUNT(*) count  ' . $sqlarr ['from'] . $sqlarr ['where'])->row_array();
			$listcount = $temparr ['count'];
			if($listcount){
				$theblockarr['multipage'] = ajaxpage($listcount,$paramarr['pagesize'],$paramarr['page']);
			} else {
				$theblockarr['multipage'] = '';
			}
		}
		if($listcount){
			$theblockarr['datas'] = $this->db->query($sqlstring)->list_array();
			foreach ($theblockarr['datas'] as $value) {
				$aqidlist[] = $value['aqid'];
			}
			if(!empty($aqidlist) && !empty($paramarr ['curuid'])) {	//当前用户,判断收藏列表
				$aqids = implode(',',$aqidlist);
				$curuid = intval($paramarr ['curuid']);
				$favsql = 'select sourceid from ebh_favorites where uid='.$curuid.' and type=4 and sourceid in('. $aqids .')';
				$list = $this->db->query($favsql)->list_array();//获取收藏列表
				foreach ($list as $value) {
					$favlist[] = $value['sourceid'];//构造收藏列表id
				}
				if(!empty($favlist)) {
					foreach ($theblockarr['datas'] as &$value) {
						if (in_array($value['aqid'], $favlist)) {
							$value['fav'] = 1;
						}
					}
				}
			}
		}
		return $theblockarr;
	}

	/**
	*添加收藏
	*/
	function addfavorite($param = array()) {
		if (empty($param['uid']) || empty($param['aqid'])) {
			return false;
		}
		$uid = intval($param['uid']);
		$aqid = intval($param['aqid']);
		$quetype = $param['quetype'];
		$crid = empty($param['crid']) ? 0 : intval($param['crid']);
		$setarr = array('uid'=>$uid,'crid'=>$crid,'sourceid'=>$aqid,'type'=>5, 'title'=>$quetype);
		$setarr['dateline'] = time();
		$fid = $this->db->insert('ebh_favorites', $setarr);
		if($fid){
			return $fid;
		}
		else{
			return 0;
		}
	}

	/*
	 *多条插入
	 */
	public function addRelation($param = array()) {
		//先判断关联关系是否存在数据库
		if ( ! empty($param[0]['sourceid'])) {
			$res = $this->db->query("select id from ebh_favchapters where sourceid={$param[0]['sourceid']}")->list_array();
			if ($res) {
				return FALSE;
			}
		}

		$sql= "insert into ebh_favchapters (chapterid,sourceid,path) values";
		foreach ($param as $value) {
			$sql .= sprintf("('%d','%d', '%s'),", $value['tid'], $value['sourceid'], $this->db->escape_str($value['path']));
		}
		$sql = substr($sql, 0, -1);
		return $this->db->query($sql);
	}

	/*
	 *把收藏题目标题存入数据库用于，key搜索关键字连表查询
	 */
	public function addQuesRelation($param = array()) {
		//先判断关联关系是否存在数据库
		if ( ! empty($param['sourceid'])) {
			$res = $this->db->query("select id from ebh_exam_favsubjects where sourceid={$param['sourceid']}")->list_array();
			if ($res) {
				return FALSE;
			}
		}
		$sql = "insert into ebh_exam_favsubjects (sourceid,subject) values ('{$param['sourceid']}','{$param['subject']}')";
		return $this->db->query($sql);
	}

	/*
	 *更新收藏题目
	 */
	public function editQueSubject($param) {
		if (empty($param['subject']) OR empty($param['sourceid'])) {
			return FALSE;
		}
		$wherearr['sourceid'] = $param['sourceid'];
		$setarr['subject'] = $this->db->escape_str($param['subject']);
		return $this->db->update('ebh_exam_favsubjects',$setarr,$wherearr);
	}


	/*
	 * 返回收藏的ids
	 */
	function getFavidBySourceids($uid, $kuqids) {
		if (empty($kuqids) OR empty($uid)) {
			return false;
		}
		$sql = 'select sourceid from ebh_favorites where uid='.$uid.' and type=5 and sourceid in('. $kuqids .')';
		$list = $this->db->query($sql)->list_array();//获取收藏列表
		$favlist = array();
		foreach ($list as $value) {
			$favlist[] = $value['sourceid'];//构造收藏列表id
		}
		return $favlist;
	}

	/**
	 * 新版作业获取收藏的id分页
	 */
	function getFavoriteList($param=array()) {
		if (empty($param['uid'])) {
			return false;
		}
		if (!empty($param['pagesize'])){
			if ($param['page'] <= 0) {
				$param['page'] = 1;
			}
			$limit = ($param['page']-1)*$param['pagesize'].', '.$param['pagesize'];
			$quetype = '';
			$from = 'select distinct f.sourceid from ebh_favorites f';
			$sql = '';
			if (!empty($param['quetype'])) {
				$quetype .= ' and f.title=\''.$param['quetype'].'\'';
			}
			if (!empty($param['subject'])) {//题目名字关联查询
				$sql .= ' left join ebh_exam_favsubjects s on (f.sourceid=s.sourceid)';
			}
			if (!empty($param['chapterid'])) {
				$sql .= ' left join ebh_favchapters c on (c.sourceid=f.sourceid) where c.chapterid='.$param['chapterid'].' and';
			} else if (!empty($param['path'])) {
				$sql .= ' left join ebh_favchapters c on (c.sourceid=f.sourceid) where c.path like \''.$param['path'].'%\' and';
			} else { //没有关联
				$sql .= ' where ';
			}
			if (!empty($param['subject'])) {
				$sql .= ' s.subject like '.'\'%'.trim($param['subject']).'%\' and ';
			} 
			//计算总数
			$last = ' f.uid='.$param['uid'].' and f.type=5 and f.crid='.$param['crid'].$quetype.' order by f.dateline desc ';
			$countSql = 'select count(distinct f.sourceid) count from ebh_favorites f'.$sql.$last;
			$temparr = $this->db->query($countSql)->row_array();
			$listcount = $temparr ['count'];
			if ($listcount) {
				$theblockarr['multipage'] = ajaxpage($listcount,$param['pagesize'],$param['page']);
			} else {
				$theblockarr['multipage'] = '';
			}
		}
		if ($listcount) {
			$sql = $from.$sql.$last.'limit '.$limit;
			$theblockarr['data'] = $this->db->query($sql)->list_array();
			if (empty($theblockarr['data']))
				return false;
		}

		return $theblockarr;
	}

	/*
	 * 通过sourceid取关联知识点
	 */
	public function getChapterBySourceid($sourceid) {
		if (!$sourceid) {
			return FALSE;
		}
		$sql = 'select id,chapterid,path from ebh_favchapters where sourceid='.$sourceid;
		return $this->db->query($sql)->list_array();
	}

	/*
	 * 删除关联知识点
	 */
	public function delChapter($ids) {
		if (!$ids) {
			return FALSE;
		}
		$sql = 'delete from ebh_favchapters where id in ('.$ids.')';
		return $this->db->query($sql);
	}

	/*
	 * 删除关联知识点
	 */
	public function addChapter($param) {
		if (!$param) {
			return FALSE;
		}
		$sql= "insert into ebh_favchapters (chapterid,sourceid,path) values";
		foreach ($param as $value) {
			$sql .= sprintf("('%d','%d', '%s'),", $value['tid'], $value['sourceid'], $this->db->escape_str($value['path']));
		}
		$sql = substr($sql, 0, -1);
		return $this->db->query($sql);
	}

	/**
	*删除收藏
	*/
	function delfavorite($param = array()) {
		if(empty($param['aqid']) || empty($param['uid']))
			return false;
		$aqid = intval($param['aqid']);
		$uid = intval($param['uid']);
		$wherearr = array('sourceid'=>$aqid,'uid'=>$uid);
		return $this->db->delete('ebh_favorites', $wherearr);
	}

	/**
	*根据章节编号获取章节路径
	*/
	function getchapterpath($chapterid) {
		if(empty($chapterid))
			return '';
		$sql = 'select c.chapterpath from ebh_chapters c where c.chapterid='.intval($chapterid);
		$item =  $this->db->query($sql)->row_array();
		$path = '';
		if(!empty($item))
			$path = $item['chapterpath'];
		return $path;
	}
}

?>