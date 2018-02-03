<?php
/*
章节
*/
class ChapterModel extends CModel{
	/*
	获取章节列表
	*/
	public function getchapterlist($param){
		$sql = 'SELECT c.*,g.gradename,s.subjectname FROM ebh_chapters c JOIN ebh_grades g ON c.gradeid = g.gradeid JOIN ebh_subjects s ON c.subjectid = s.subjectid ';
		$wherearr = array();
		if(!empty($param['subjectid']))
			$wherearr[] = ' c.subjectid = '.$param['subjectid'];
		if(!empty($param['gradeid']))
			$wherearr[] = ' c.gradeid = '.$param['gradeid'];
		if(!empty($wherearr))
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' order by c.displayorder,c.chapterid '; 
		$resarr = $this->db->query($sql)->list_array();
		$chapterlist = array();
		foreach($resarr as $ra){
			$chapterlist[$ra['chapterid']] = $ra;
		}
		return $this->getchaptertrees($chapterlist);
	}
	//获取树
	function getTree($arr = array(),$pid=0,$index=0){
		$tree = array();
		foreach ($arr as $value) {

			if($value['pid']==$pid){
				$value['chaptername'] = str_repeat('┣━ ', $index).$value['chaptername'];
				$tree[] = $value;
				$tree = array_merge($tree,$this->getTree($arr,$value['chapterid'],$index+1));
			}
		}
		 return $tree;
	}
	//获取树 2
	function getchaptertrees($chapterlist) {
		$chapterarr = array();
		$chaptertree = array();
		foreach($chapterlist as $chapter) {
			if (empty($chapter['pid']))
				$chaptertree[0][] = $chapter['chapterid'];
			else {
				$chaptertree[$chapter['pid']][] = $chapter['chapterid'];
			}
		}
		$pid = 0;
		$this->getchapterarray($chapterlist,$chaptertree,$chapterarr,$pid);
		return $chapterarr;
	}
	function getchapterarray($chapterlist,$chaptertree,&$chapterarr,$pid) {
		if(isset($chaptertree[$pid])) {
			foreach($chaptertree[$pid] as $childchapter) {
				$chapterarr[$childchapter] = $chapterlist[$childchapter];
				$this->getchapterarray($chapterlist,$chaptertree,$chapterarr,$childchapter);
			}
		}
	}
	
	/*
	添加章节
	*/
	public function insert($param){
		$carr['pid'] = $param['pid'];
		$carr['chaptername'] = $param['chaptername'];
		$carr['gradeid'] = $param['gradeid'];
		$carr['subjectid'] = $param['subjectid'];
		$carr['displayorder'] = $param['displayorder'];
		
		$this->db->begin_trans();
		
		$chapterid = $this->db->insert('ebh_chapters',$carr);
		if($carr['pid']!=0){
			$sql = 'select level,chapterpath from ebh_chapters where chapterid='.$carr['pid'];
			$p = $this->db->query($sql)->row_array();
			$uparr['level'] = $p['level']+1;
			$uparr['chapterpath'] = $p['chapterpath'].'/'.$chapterid;
		}else{
			$uparr['level'] = 1;
			$uparr['chapterpath'] = '/'.$chapterid;
		}
		$this->db->update('ebh_chapters',$uparr,'chapterid='.$chapterid);
		
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}
	
	/*
	删除章节
	*/
	public function delete($chapterid){
		return $this->db->delete('ebh_chapters','chapterid='.$chapterid);
	}
	/*
	编辑章节
	*/
	public function update($param){
		if(empty($param['chapterid']))
			return false;
		$setarr['chaptername'] = $param['chaptername'];
		$setarr['displayorder'] = $param['displayorder'];
		return $this->db->update('ebh_chapters',$setarr,'chapterid='.$param['chapterid']);
	}
	
	/**
	 * 获取知识点列表，只用于获取ebh_schchapters的内容
	 */
	function getmychapterlist($param = array()) {
		$sql = 'select c.chapterid, c.chaptername from `ebh_schchapters` c';
		$wherearr = array();
		if(!empty($param['crid'])){
			$wherearr[] = 'c.crid='.$param['crid'];
		}
		if(!empty($param['chapterids'])){
			$wherearr[] = 'c.chapterid in ('.implode(',', $param['chapterids']).')';
		}
		if(!empty($wherearr))
			$sql .= ' where '.implode(' AND ',$wherearr);
		$sql .= ' order by c.pid,c.displayorder,c.chapterid';
		$theblockarr = $this->db->query($sql)->list_array();
		return $theblockarr;
	}
	
	/*
	 *获取知识点详细路径名称html 
	 */
	public function getchapterpathstr($chapters){
		$htmlstr = '';
		$mychapteridpath = array();
		if(empty($chapters)){
			return $htmlstr;
		}else{
			$chapteridsarr = $chapters;
		}
		$mychapteridpath = array();
		$sql = "select chapterid, chaptername, chapterpath from `ebh_schchapters` where chapterid in (".implode(',', $chapters).')';
		$retarr = $this->db->query($sql)->list_array();
		if(!empty($retarr)){
			foreach ($retarr as $item){
				$chapterpath = $item['chapterpath'];
				$chapterpath = substr($chapterpath, 1);
				$chapterarr = explode('/', $chapterpath);
				$mychapteridpath[] = $chapterarr;
				$chapteridsarr = array_merge($chapterarr,$chapteridsarr);
			}
			//去重
			$chapteridsarr = array_unique($chapteridsarr);
			$chapterlist = $this->getmychapterlist(array('chapterids'=>$chapteridsarr));
			foreach ($chapterlist as $val){
				$chapternames[$val['chapterid']] = $val['chaptername'];
			}
			//路径格式化
			foreach ($mychapteridpath as $path){
				$fullpathstr = '';
				$mynodekey = count($path) - 1;
				$mynode = $path[$mynodekey];
				foreach ($path as $p){
					$fullpathstr .= $chapternames[$p] . ' > ';
				}
				$fullpathstr = substr($fullpathstr, 0, strlen($fullpathstr) - 3);
				$htmlstr .= '<li data="'.$mynode.'">'.$fullpathstr.'</li>';
			}
		}
		return $htmlstr;
	}
}
?>