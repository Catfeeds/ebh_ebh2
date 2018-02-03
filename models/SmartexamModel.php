<?php
class SmartexamModel extends CModel{
	/**
	 *获取学生自己布置的作业的详情
	 */
	public function getSmartExamDetail($eid = 0,$uid = 0){
		$sql = 'select e.* from ebh_smartexams e where e.eid = '.$eid.' AND e.uid = '.$uid;
		return $this->db->query($sql)->row_array();
	}
	/**
	 *获取学生自己布置的智能试卷列表
	 */
	public function getList($param = array(),$fieldstr = '*'){
		$sql = 'select '.$fieldstr.' from ebh_smartexams as se';
		$wherearr = array();
		if(!empty($param['uid'])){
			$wherearr[] = 'se.uid='.$param['uid'];
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'se.crid='.$param['crid'];
		}
		if(!empty($param['status']) && is_numeric($param['status'])){
			$wherearr[] = 'se.status='.$param['status'];
		}
		if(!empty($param['q'])){
			$wherearr[] = 'se.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by se.eid desc ';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}

	/**
	 *获取学生自己布置的智能试卷列表数量
	 */
	public function getListCount($param = array()){
		$sql = 'select count(1) as count from ebh_smartexams as se';
		$wherearr = array();
		if(!empty($param['uid'])){
			$wherearr[] = 'se.uid='.$param['uid'];
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'se.crid='.$param['crid'];
		}
		if(!empty($param['status']) && is_numeric($param['status'])){
			$wherearr[] = 'se.status='.$param['status'];
		}
		if(!empty($param['q'])){
			$wherearr[] = 'se.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}


	/**
	 *获取学生智能作业答题列表
	 */
	public function getAnswerList($param = array()){
		$sql = 'select * from ebh_smartexams se join ebh_smartexamanswers sea on se.eid = sea.eid';
		$wherearr = array();
		if(!empty($param['eid'])){
			$wherearr[] = 'se.eid='.$param['eid'];
		}
		if(!empty($param['uid'])){
			$wherearr[] = 'se.uid='.$param['uid'];
			$wherearr[] = 'sea.uid='.$param['uid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by sea.aid desc ';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}

	
	/**
	 *获取学生智能作业答题列表
	 */
	public function getAnswerListCount($param = array()){
		$sql = 'select count(1) as count from ebh_smartexams se join ebh_smartexamanswers sea on se.eid = sea.eid';
		$wherearr = array();
		if(!empty($param['eid'])){
			$wherearr[] = 'se.eid='.$param['eid'];
		}
		if(!empty($param['uid'])){
			$wherearr[] = 'se.uid='.$param['uid'];
			$wherearr[] = 'sea.uid='.$param['uid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by se.eid desc ';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}

	public function delexam($eid = 0,$uid = 0){
		$where = array(
			'eid'=>$eid,
			'uid'=>$uid
		);
		$this->db->begin_trans();
		$affected_rows = $this->db->delete('ebh_smartexams',$where);
		$this->db->delete('ebh_smartexamanswers',$where);
		if($affected_rows >0){
			$this->db->commit_trans();
			return true;
		}else{
			$this->db->rollback_trans();
			return false;
		}
	}

	//获取作业列表对应的答题记录
	public function getExamsAnswerList($param = array()){
		$sql = 'select sea.* from ebh_smartexamanswers sea';
		if(!empty($param['eid'])){
			$wherearr[] = 'sea.eid='.$param['eid'];
		}
		if(!empty($param['eid_in'])){
			$wherearr[] = 'sea.eid in ('.implode(',',$param['eid_in']).')';
		}
		if(!empty($param['uid'])){
			$wherearr[] = 'sea.uid='.$param['uid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by sea.aid asc,sea.status asc';
		return $this->db->query($sql)->list_array();
	}


	//单次答题记录错题分析
	public function answerFenxi($aid = 0){
		$sql = 'select sea.aid,sea.eid,sea.answers,sea.scores,sea.totalscore,sea.iques as ques,sea.score,sea.truenum,sea.falsenum,sea.quecount,sea.dateline from ebh_smartexamanswers sea where aid = '.$aid;
		$adetail = $this->db->query($sql)->row_array();
		if(empty($adetail) || empty($adetail['answers']) || empty($adetail['ques']) ){
			return array();
		}

		$scores = $this->mb_unserialize($adetail['scores']);
		if(empty($scores)){
			return array();
		}
		$ques = $this->base64str($this->mb_unserialize($adetail['ques']));
		if(empty($ques)){
			return array();
		}
		$datapackage = array();
		foreach ($ques as $qkey => $que) {
			$ckey = 'chapterid_'.$que['chapterid'];
			$tkey =  trim($que['type']);
			if(!array_key_exists($ckey,$datapackage)){
				$datapackage[$ckey] = array(
					'chapterid'=>$que['chapterid'],
					'chaptername'=>$this->getChapterName($que['chapterid']),
					'datas'=>array(),
				);
			}
			if(!array_key_exists($tkey,$datapackage[$ckey]['datas'])){
				$datapackage[$ckey]['datas'][$tkey] = array(
					'totalnum'=>0,
					'falsenum'=>0,
					'truenum'=>0,
				);
			}
			if(isset($scores[$qkey]) && isset($scores[$qkey]['score'])){
				if($scores[$qkey]['type'] == 'C'){
					$truescore = intval($que['score']) * count($que['options']);
				}else{
					$truescore = intval($que['score']);
				}
				$myscore = intval($scores[$qkey]['score']);
			}else{
				$myscore = 0;
				$truescore = intval($que['score']);
			}
			
			if($myscore >= $truescore){
				$datapackage[$ckey]['datas'][$tkey]['totalnum']++;
				$datapackage[$ckey]['datas'][$tkey]['truenum']++;
			}else{
				$datapackage[$ckey]['datas'][$tkey]['totalnum']++;
				$datapackage[$ckey]['datas'][$tkey]['falsenum']++;
			}

		}
		return array_values($datapackage);
	}

	private function base64str($str,$t=false){
		if(is_array($str)){
			foreach($str as $key=>$val ){
				$str[$key]=$this->base64str($val,$t);
			}
		}else{
			if($t){//编码
				$str=base64_encode($str);
			}else{//解码
				$str=base64_decode($str);
			}
		}
		return $str;
	}

	private function mb_unserialize($out) {
		$out = preg_replace_callback('/s:(\d+):"(.*?)";/s', function($matches){
			return "s:".strlen($matches[2]).':"'.$matches[2].'";';
		}, $out );
		return unserialize($out);
	}

	//根据知识点id获取知识点名称
	private function getChapterName($chapterid = 0){
		$sql = 'select chaptername from ebh_schchapters where chapterid = '.$chapterid;
		$res = $this->db->query($sql)->row_array();
		if(!empty($res)){
			return $res['chaptername'];
		}else{
			return "未知知识点";
		}
	}
}