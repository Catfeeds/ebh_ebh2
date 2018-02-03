<?php
/**
 * 自我测评相关的 都合并在该model类下
 */
class EvaluateModel extends CModel{
	
	/**************************************evaluates******************************************************/
	/**
	 * 获取量表列表
	 * @param unknown $param
	 */
    public function getevaluatelist($param = array()) {
        $sql = 'select e.eid,e.title,e.tutor,e.descr,e.logo,e.nums,e.total,e.itemstr from ebh_evaluates e ';
        $wherearr = array();
		if(!empty($param['q'])){
			$wherearr[] = " e.title like '%".$this->db->escape_str($param['q'])."%'";
		}
		if(!empty($param['eid'])){
			$wherearr[] = "e.eid = {$param['eid']}";
		}
		if(isset($param['del'])){
			$wherearr[] = "e.del = {$param['del']}";
		}
        if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }

        if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
       // echo $sql;
        return $this->db->query($sql)->list_array();
    }
    
    /**
     * 获取量表数量
     * @param unknown $param
     */
   public function getevaluatecount($param = array()){
	   	$sql = 'select count(*) as count  from ebh_evaluates e ';
	   	$wherearr = array();
	   	if(!empty($param['q'])){
	   		$wherearr[] = " e.title like '%".$this->db->escape_str($param['q'])."%'";
	   	}
	   	if(!empty($wherearr)) {
	   		$sql .= ' WHERE '.implode(' AND ',$wherearr);
	   	}
	   	
	   	$row = $this->db->query($sql)->row_array();
	   	if(empty($row)){
	   		$row['count'] = 0;
	   	}
	   	return  $row['count'];
   } 
   
   /**
    * 量表添加
    * @param unknown $param
    */
   public function addevaluate($param){
	   	$setarr = array();
	   	if(!empty($param['title'])){
	   		$setarr['title'] = $this->db->escape_str($param['title']);
	   	}
	   	if(!empty($param['tutor'])){
	   		$setarr['tutor'] = $this->db->escape_str($param['tutor']);
	   	}
	   	if(!empty($param['descr'])){
	   		$setarr['descr'] = $this->db->escape_str($param['descr']);
	   	}
	   	if(!empty($param['nums'])){
	   		$setarr['nums'] = $this->db->escape_str($param['nums']);
	   	}
	   	if(!empty($param['total'])){
	   		$setarr['total'] = $this->db->escape_str($param['total']);
	   	}
	   	if(!empty($param['logo'])){
	   		$setarr['logo'] = $this->db->escape_str($param['logo']);
	   	}
	
	   	if(!empty($param['itemstr'])){
	   		$setarr['itemstr'] = $param['itemstr'];
	   	}
	   	
	   	return  $this->db->insert("ebh_evaluates",$setarr);
   }
   

   /**
    * 量表修改
    * @param unknown $param
    * @param unknown $eid
    */
   public function editevaluate($param,$eid){
	   	$setarr = array();
	   	if(!empty($param['title'])){
	   		$setarr['title'] = $this->db->escape_str($param['title']);
	   	}
	   	if(!empty($param['tutor'])){
	   		$setarr['tutor'] = $this->db->escape_str($param['tutor']);
	   	}
	   	if(!empty($param['descr'])){
	   		$setarr['descr'] = $this->db->escape_str($param['descr']);
	   	}
	   	if(!empty($param['nums'])){
	   		$setarr['nums'] = $this->db->escape_str($param['nums']);
	   	}
	   	if(!empty($param['total'])){
	   		$setarr['total'] = $this->db->escape_str($param['total']);
	   	}
	   	if(!empty($param['logo'])){
	   		$setarr['logo'] = $this->db->escape_str($param['logo']);
	   	}
	   	if(isset($param['del'])){
	   		$setarr['del'] = intval($param['del']);
	   	}
	   	if(!empty($param['itemstr'])){
	   		$setarr['itemstr'] = $param['itemstr'];
	   	}
	   	
	   	return  $this->db->update("ebh_evaluates",$setarr,array('eid'=>$eid));
   }
   
   //获取所有量表 供用户选择
   public function getallevaluates(){
   		$sql = "select eid,title from ebh_evaluates where del = 0";
   		return $this->db->query($sql)->list_array();
   }
   
   
   /**
    * 检测该量表,某用户是否已测试过
    * @param unknown $eid
    * @param unknown $uid
    */
   public function checktested($eid,$uid){
   		$sql = "select count(*) as count from ebh_evaluate_answers where eid = $eid and uid = $uid";
   		$row = $this->db->query($sql)->row_array();
   		if(!empty($row['count'])){
   			return true;
   		}else{
   			return false;
   		}
   }
   /********************************questions****************************************************/
   
   /**
    * 获取问卷的所有问题
    * @param unknown $eid
    */
   public function  getquestionsbyeid($eid){
   		$sql = "select qid,qtitle,qitemstr,eid,qlogo,sort,score from ebh_evaluate_questions where eid = {$eid} order by sort";
   		return $this->db->query($sql)->list_array();
   }
   
   /**
    * 问卷问题添加--添加一条
    */
   public function addquestion($param){
   		$setarr = array();
   		if(!empty($param['qtitle'])){
   			$setarr['qtitle'] = $param['qtitle'];
   		}
   		if(!empty($param['qitemstr'])){
   			$setarr['qitemstr'] = $param['qitemstr'];
   		}
   		if(!empty($param['eid'])){
   			$setarr['eid'] = $param['eid'];
   		}
   		if(!empty($param['qlogo'])){
   			$setarr['qlogo'] = $param['qlogo'];
   		}
   		if(!empty($param['sort'])){
   			$setarr['sort'] = $param['sort'];
   		}
   		if(!empty($param['score'])){
   			$setarr['score'] = $param['score'];
   		}
   		
   		return $this->db->insert("ebh_evaluate_questions",$setarr);
   }
   /*
    * 问题修改 --修改一条
    */
   public function editquestion($param,$qid){
	   	$setarr = array();
	   	if(!empty($param['qtitle'])){
	   		$setarr['qtitle'] = $param['qtitle'];
	   	}
	   	if(!empty($param['qitemstr'])){
	   		$setarr['qitemstr'] = $param['qitemstr'];
	   	}
	   	if(!empty($param['eid'])){
	   		$setarr['eid'] = $param['eid'];
	   	}
	   	if(!empty($param['qlogo'])){
	   		$setarr['qlogo'] = $param['qlogo'];
	   	}
	   	if(!empty($param['sort'])){
	   		$setarr['sort'] = $param['sort'];
	   	}
	   	if(!empty($param['score'])){
	   		$setarr['score'] = $param['score'];
	   	}
	   	 
	   	return $this->db->update("ebh_evaluate_questions",$setarr,array('qid'=>$qid));
   }
   
   /**
    * 问卷问题添加--一次批量添加多个问题
    */
   public function addbatchquestions($params){
   		$sql = "insert into ebh_evaluate_questions(`qtitle`,`qitemstr`,`eid`,`qlogo`,`sort`,`score`)values( ";
   		$sqltxt = ' ';
   		foreach($params as $param){
   			$sqltxt.=" ( '{$param['qtitle']}' ,'{$param['qitemstr']}','{$param['eid']}','{$param['qlogo']}','{$param['sort']}','{$param['score']}')";
   		}
   		$sql.=$sqltxt;
   		return $this->db->simple_query($sql);
   		
   } 
   
   /**
    * 删除一条问题
    */
   public function delquestion($qid){
   		return $this->db->delete("ebh_evaluate_questions",array("qid"=>$qid));
   }
   /****************************answers*************************************************************/
   /**
    * 添加测评结果
    */
   public function addanswer($param){
   		$setarr = array();
   		if(!empty($param['uid'])){
   			$setarr['uid'] = $param['uid'];
   		}
   		if(!empty($param['answerstr'])){
   			$setarr['answerstr'] = $param['answerstr'];
   		}
   		if(!empty($param['eid'])){
   			$setarr['eid'] = $param['eid'];
   		}
   		if(!empty($param['result'])){
   			$setarr['result'] = $param['result'];
   		}
   		if(!empty($param['dateline'])){
   			$setarr['dateline'] = $param['dateline'];
   		}
   		if(!empty($param['score'])){
   			$setarr['score'] = $param['score'];
   		}
   		if(!empty($param['keystr'])){
   			$setarr['keystr'] = $param['keystr'];
   		}
   		
   		return $this->db->insert("ebh_evaluate_answers",$setarr);
   }
   /**
    * 查找某个用户的某张量表的测评结果
    */
   public function getanswer($eid,$uid){
   		$sql = "select aid,uid,answerstr,eid,result,dateline,score,keystr from ebh_evaluate_answers where uid = {$uid} and eid = {$eid} ";
   		return $this->db->query($sql)->row_array();
   }
   
   /**
    * 检测某个用户关于某张量表是否测试过
    * 测试过 返回true 反之 false
    */
   public function checkanswered($eid,$uid){
   		$ret = false;
   		$sql = " select count(*) as count from ebh_evaluate_answers where uid = {$uid} and eid = {$eid}"; 
   		$row = $this->db->query($sql)->row_array();
   		if(!empty($row)&&$row['count']>0){
   			$ret = true; 
   		}else{
   			$ret = false;
   		}
   		
   		return $ret;
   }
   
   
   /****************************refers**********************************************************/
   
   //获取评语
   public function getreferrow($param){
   		$wherearr = array();
   		$sql = "select  rid,eid,startscore,endscore,keystr,keyitemstr,remarks from ebh_evaluate_refers";
   		if(!empty($param['eid'])){
   			$wherearr[] = " eid = {$param['eid']}";
   		}
   		if(!empty($param['rid'])){
   			$wherearr[] = " rid = {$param['rid']}";
   		}
   		if(isset($param['score'])){
   			$wherearr[] = " startscore >= {$param['score']} && {$param['score']}<=endscore";
   		}
   		if(!empty($param['keystr'])){
   			$wherearr[] = " keystr = {$param['keystr']} ";
   		}
   		$sql.=" where ".implode(" AND ", $wherearr) ;
   		//var_dump($param);
   		//echo $sql;
   		return $this->db->query($sql)->row_array();
   }
   
   //获取量表的所有评语
   public function getrefersbyeid($eid){
   		$sql = "select rid,eid,startscore,endscore,keystr,keyitemstr,remarks from ebh_evaluate_refers where eid = $eid ";
   		return $this->db->query($sql)->list_array();
   }
   
  	// 添加评语
  	public function addrefer($param){
  		$setarr = array();
  		if(!empty($param['eid'])){
  			$setarr['eid'] = $param['eid'];
  		}
  		if(isset($param['startscore'])){
  			$setarr['startscore'] = $param['startscore'];
  		}
  		if(isset($param['endscore'])){
  			$setarr['endscore'] = $param['endscore'];
  		}
  		if(!empty($param['keystr'])){
  			$setarr['keystr'] = $param['keystr'];
  		}
  		if(!empty($param['keyitemstr'])){
  			$setarr['keyitemstr'] = $param['keyitemstr'];
  		}
  		if(!empty($param['remarks'])){
  			$setarr['remarks'] = $param['remarks'];
  		}
		
  		return $this->db->insert('ebh_evaluate_refers',$setarr);
  	}
  	
  	//修改评语
  	public function editrefer($param,$rid){
  		$setarr = array();
  		if(!empty($param['eid'])){
  			$setarr['eid'] = $param['eid'];
  		}
  		if(isset($param['startscore'])){
  			$setarr['startscore'] = $param['startscore'];
  		}
  		if(isset($param['endscore'])){
  			$setarr['endscore'] = $param['endscore'];
  		}
  		if(!empty($param['keystr'])){
  			$setarr['keystr'] = $param['keystr'];
  		}
  		if(!empty($param['keyitemstr'])){
  			$setarr['keyitemstr'] = $param['keyitemstr'];
  		}
  		if(!empty($param['remarks'])){
  			$setarr['remarks'] = $param['remarks'];
  		}
  		
  		return $this->db->update('ebh_evaluate_refers',$setarr,array('rid'=>$rid));
  	}
  	
  	/**
  	 * 删除一条问题
  	 */
  	public function delrefer($rid){
  		return $this->db->delete("ebh_evaluate_refers",array("rid"=>$rid));
  	}
}
