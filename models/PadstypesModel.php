<?php
/**
 *广告类型模型
 */
class PadstypesModel extends CPortalModel{
	/**
	 *获取类型列表
	 *@param array $param 
	 *@return array
	 */
	public function getList($param = array()){
		$sql = 'select * from ebh_padstypes ';
		if(empty($param['order'])){
			$sql.=' order by displayorder asc,tid asc';
		}else{
			$sql.=' order by '.$this->portaldb->escape_str($param['order']);
		}
		if(empty($param['limit'])){
			$sql.=' limit 200 ';
		}else{
			$sql.=' limit '.$param['limit'];
		}
		return $this->portaldb->query($sql)->list_array();
	}

	/**
	 *根据tid获取分类信息
	 *@param int $tid
	 *@return array
	 */
	public function getOneBytid($tid = -1){
		$sql = 'select c.* from ebh_padstypes c where c.tid = '.$tid.' limit 1';
		return $this->portaldb->query($sql)->row_array();
	}
	/**
	 *获取树形列表结构
	 *@param array $clists (分类数组)
	 *@param int upid
	 *@return array
	 */
	public function getTreeListByUpid($clists = array(),$upid = 0){
		return $this->getTree($clists,$upid);
	}

	/**
	 *获取树形列表结构辅助函数
	 *@param array $clists
	 *@param int upid
	 *@param int index
	 *@return array
	 */
	private function getTree($clists = array(),$upid = 0,$index = 0){
		$treeList = array();
		foreach ($clists as $clist) {
			if($clist['upid'] == $upid){
				$clist['name'] = str_repeat('┣━', $index).$clist['name'];
				$treeList[] = $clist;
				$treeList = array_merge($treeList,$this->getTree($clists,$clist['tid'],$index+1));
			}
		}
		return $treeList;
	}
	/**
	 *获取分类简单列表
	 *@param null
	 *@return array
	 */
	public function getSimpleList(){
		$sql = 'select c.tid,c.upid,c.name from ebh_padstypes c order by displayorder,tid';
		return $this->portaldb->query($sql)->list_array();
	}
	/**
	 *获取树形select控件
	 *@param String $attrs 自定义属性,如 'class=cs1 id=ddd'
	 *@param int $selected 默认选中项
	 *@param boolean $hasRootadstype 是否包含顶级目录
	 *@param boolean $topadstypeDisabled 顶层栏目是否禁用
	 *@return String
	 */
	public function getSelect($attrs='',$selected = -1,$hasRootadstype= true,$topadstypeDisabled=false,$onlyTopType=false){
		$res = $this->getSimpleList();
		$res = $this->getTreeListByUpid($res);
		$pselect = '<select '.$attrs.'>';
		if($hasRootadstype){
			$pselect.='<option value=0>|-所有类型-|</option>';
		}
		foreach ($res as $v) {
			if(($onlyTopType===true)&&($v['upid'])!=0){
				continue;
			}
			if($v['tid']==$selected){
				if(($topadstypeDisabled)&&($v['upid']==0)){
					$pselect.='<option value="'.$v['tid'].'" disabled=disabled>'.$v['name'].'</option>';
				}else{
					$pselect.='<option value="'.$v['tid'].'" selected=selected>'.$v['name'].'</option>';
				}
				
			}else{
				if(($topadstypeDisabled)&&($v['upid']==0)){
					$pselect.='<option disabled=disabled value="'.$v['tid'].'">'.$v['name'].'</option>';
				}else{
					$pselect.='<option value="'.$v['tid'].'">'.$v['name'].'</option>';
				}
			}
		}
		$pselect.='</select>';
		return $pselect;
	}

	/**
	 *新增一条数据
	 *
	 */
	public function _insert($param = array()){
		if(empty($param)){
			return 0;
		}
		$param = $this->portaldb->escape_str($param);
		return $this->portaldb->insert('ebh_padstypes',$param);
	}

	/**
	 *修改一条记录
	 *
	 */
	public function _update($param = array(),$where = array()){
		if(empty($param)||empty($where)){
			return 0;
		}
		$param = $this->portaldb->escape_str($param);
		$where = $this->portaldb->escape_str($where);
		return $this->portaldb->update('ebh_padstypes',$param,$where);
	}

	/**
	 *删除一个分类(连同它的后代分类)
	 *@param int $tid
	 *@param boolean $isforce
	 *@return int 成功返回1失败返回0
	 */
	public function _delete($tid = -1,$isforce = false){
		$alladstypegoriesWillBeDeleted =  $this->getPosterity($tid);
		array_push($alladstypegoriesWillBeDeleted, $tid);
		$in = '('.implode(',', $alladstypegoriesWillBeDeleted).')';
		if($isforce===false){
			$ifExitsSystem = $this->ifExitsSystem($alladstypegoriesWillBeDeleted);
			if($ifExitsSystem===true){
				return 0;
			}
		}
		$sql = 'delete from ebh_padstypes where tid in '.$in;
		return $this->portaldb->query($sql)?1:0;
	}

	/**
	 *获取指定分类下面的所有后代分类tid集合
	 */
	public function getPosterity($tid = 0){
		$sql = 'select tid,upid from ebh_padstypes';
		$adstypes = $this->portaldb->query($sql)->list_array();
		return $this->_getPosterity($adstypes,$tid);

	}
	/**
	 *根据tid获取upid
	 *
	 */
	public function getUpidBytid($tid=0){
		$sql = 'select upid from ebh_padstypes where tid = '.intval($tid).' limit 1';
		$res = $this->portaldb->query($sql)->row_array();
		return isset($res['upid'])?$res['upid']:false;
	}
	/**
	 *根据子tid获取整个层级链条
	 *
	 */
	public function getAncestorChain($tid,$adstypes = array(),$upid=false,$adstypeName=false,$glue='>>'){
		if(empty($adstypes)){
			$adstypes = $this->getSimpleList();
		}
		if($upid===false){
			$upid = $this->getUpidBytid(intval($tid));
		}
		if($adstypeName==false){
			$adstypeInfo = $this->getOneBytid($tid);
		}else{
			$adstypeInfo['name'] = $adstypeName;
		}
		$res = $this->_getAncestorChain($adstypes,$upid);
		$res[] = $adstypeInfo['name'];
		return implode($glue,$res);
	}
	public function _getAncestorChain($adstypes,$upid=0){
		$returnArr = array();
		foreach ($adstypes as $adstype) {
			if($adstype['tid']==$upid){
				$returnArr[]=$adstype['name'];
				if($adstype['upid']!=0){
					$returnArr = array_merge($this->_getAncestorChain($adstypes,$adstype['upid']),$returnArr);
				}
				break;
			}
		}
		return $returnArr;
	}
	/**
	 *获取指定分类下面的所有后代分类tid集合函数的辅助函数
	 */
	private function _getPosterity($adstypes = array(),$upid = 0){
		$returnArr = array();
		foreach ($adstypes as $adstype) {
			if($adstype['upid']==$upid){
				$returnArr[] = intval($adstype['tid']);
				$teturnArr = array_merge($returnArr,$this->_getPosterity($adstypes,$adstype['tid']));
			}
		}
		return $returnArr;
	}

	public function _query($sql){
		return $this->portaldb->query($sql)?1:0;
	}

	/**
	 *栏目移动函数type=1移动到目标栏目之前,type=2移动到目标栏目里面,type=3移动到目标栏目之后
	 *
	 *
	 */
	public function _move($tid,$totid,$type){
		if(empty($tid)){
			return false;
		}
		if(!in_array($type,array(1,2,3))){
			return false;
		}
		$tidArr = array();
		if(is_scalar($tid)){
			$tidArr[] = $tid;
		}else{
			$tidArr = $tid;
		}
		$typeReflection = array('1'=>'moveBefore','2'=>'moveTo','3'=>'moveAfter');
		$callFuncName = $typeReflection[$type];
		$tag = true;
		$this->portaldb->begin_trans();
		foreach ($tidArr as $v) {
			$tag=$tag&&call_user_func_array(array($this,$callFuncName),array(intval($v),$totid));
			if($tag===false){
				$this->portaldb->rollback_trans();
				return false;
			}
		}
		$this->portaldb->commit_trans();
		return true;
	}

	/**
	 *移动某个栏目到另一个栏目里面
	 *
	 */
	private function moveTo($tid,$totid){
		if($tid==$totid){
			return false;
		}
		$res = $this->portaldb->update('ebh_padstypes',array('upid'=>$totid),array('tid'=>$tid));
		if($res===false){
			return false;
		}else{
			return true;
		}
	}
	/**
	 *移动某个栏目到另一个栏目前面
	 *
	 */
	private function moveBefore($tid,$totid){
		if($tid==$totid){
			return false;
		}
		$adstypeInfo = $this->getOneBytid($tid);
		$toadstypeInfo = $this->getOneBytid($totid);
		$param1 = array('upid'=>$toadstypeInfo['upid'],'displayorder'=>max(0,$toadstypeInfo['displayorder']-1));
		$where1 = array('tid'=>$tid);
		$res1 = $res2 = $this->portaldb->update('ebh_padstypes',$param1,$where1);
		if($toadstypeInfo['displayorder']==0){
			$param2 = array('displayorder'=>(1+$toadstypeInfo['displayorder']));
			$where2 = array('tid'=>$totid);
			$res2 = $this->portaldb->update('ebh_padstypes',$param2,$where2);
		}
		if(($res1===false)||($res2===false)){
			return false;
		}else{
			return true;
		}
	}

	/**
	 *移动某个栏目到另一个栏目后面
	 *
	 *
	 */
	private function moveAfter($tid,$totid){
		if($tid==$totid){
			return false;
		}
		$adstypeInfo = $this->getOneBytid($tid);
		$toadstypeInfo = $this->getOneBytid($totid);
		$param = array('upid'=>$toadstypeInfo['upid'],'displayorder'=>$toadstypeInfo['displayorder']+1);
		$where = array('tid'=>$tid);
		$res = $this->portaldb->update('ebh_padstypes',$param,$where);
		if($res===false){
			return false;
		}else{
			return true;
		}
	}

	/**
	 *判断传入的栏目是否含有系统目录
	 *
	 */
	public function ifExitsSystem($tid){
		if(is_scalar($tid)){
			$sql = 'select count(c.tid) count from ebh_padstypes c where c.system = 1 AND c.tid = '.$this->portaldb->escape_str($tid);
		}else{
			$in = '('.implode(',', $tid).')';
			$sql = 'select count(c.tid) count from ebh_padstypes c where c.tid in '.$in.' AND c.system = 1';
		}
		$adstypes = $this->portaldb->query($sql)->row_array();
		return $adstypes['count']>0?true:false;
	}

	/**
	 *判断code是否已经存在
	 *
	 */
	public function ifCodeExist($code = ''){
		if(empty($code)){
			return false;
		}
		$sql = 'select count(tid) count from ebh_padstypes where code =\''.$this->portaldb->escape_str($code).'\' limit 1';
		$res = $this->portaldb->query($sql)->row_array();
		return $res['count']==1?true:false;
	}
}