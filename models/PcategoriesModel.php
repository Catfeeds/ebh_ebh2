<?php
class PcategoriesModel extends CPortalModel{
	/**
	 *获取栏目列表
	 *@param array $param 
	 *@return array
	 */
	public function getList($param = array()){
		$sql = 'select * from ebh_pcategories ';
		if(empty($param['order'])){
			$sql.=' order by displayorder asc,catid asc';
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
	 *根据catid获取分类信息
	 *
	 */
	public function getOneByCatid($catid = -1){
		$catid = intval($catid);
		if($catid <= 0)
			return FALSE;
		$sql = 'select c.* from ebh_pcategories c where c.catid = '.$catid.' limit 1';
		return $this->portaldb->query($sql)->row_array();
	}
	/**
	 *获取分类简单列表
	 *@param null
	 *@return array
	 */
	public function getTreeListByUpid($clists = array(),$upid = 0){
		return $this->getTree($clists,$upid);
	}

	/**
	 *获取树形列表结构辅助函数
	 *
	 */
	private function getTree($clists = array(),$upid = 0,$index = 0){
		$treeList = array();
		foreach ($clists as $clist) {
			if($clist['upid'] == $upid){
				$clist['name'] = str_repeat('┣━', $index).$clist['name'];
				$treeList[] = $clist;
				$treeList = array_merge($treeList,$this->getTree($clists,$clist['catid'],$index+1));
			}
		}
		return $treeList;
	}
	/**
	 *获取分类简单列表
	 *
	 */
	public function getSimpleList($ifHasLinkurl = false){
		$sql = 'select c.catid,c.upid,c.name,c.code from ebh_pcategories c order by displayorder,catid';
		if($ifHasLinkurl===true){
			$sql = 'select c.catid,c.upid,c.name,c.code from ebh_pcategories c where c.caturl= \'\' order by displayorder,catid';
		}
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
	public function getSelect($attrs='',$selected = -1,$hasRootCate= true,$topCateDisabled=false){
		$res = $this->getSimpleList();
		$res = $this->getTreeListByUpid($res);
		$pselect = '<select '.$attrs.'>';
		if($hasRootCate){
			$pselect.='<option value=0>|-顶级栏目-|</option>';
		}
		foreach ($res as $v) {
			if($v['catid']==$selected){
				if(($topCateDisabled)&&($v['upid']==0)){
					$pselect.='<option value="'.$v['catid'].'" disabled=disabled>'.$v['name'].'</option>';
				}else{
					$pselect.='<option value="'.$v['catid'].'" selected=selected>'.$v['name'].'</option>';
				}
				
			}else{
				if(($topCateDisabled)&&($v['upid']==0)){
					$pselect.='<option disabled=disabled value="'.$v['catid'].'">'.$v['name'].'</option>';
				}else{
					$pselect.='<option value="'.$v['catid'].'">'.$v['name'].'</option>';
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
		return $this->portaldb->insert('ebh_pcategories',$param);
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
		return $this->portaldb->update('ebh_pcategories',$param,$where);
	}

	/**
	 *删除一个分类(连同它的后代分类)
	 *
	 */
	public function _delete($catid = -1,$isforce = false){
		$allCategoriesWillBeDeleted =  $this->getPosterity($catid);
		array_push($allCategoriesWillBeDeleted, $catid);
		$in = '('.implode(',', $allCategoriesWillBeDeleted).')';
		if($isforce===false){
			$ifExitsSystem = $this->ifExitsSystem($allCategoriesWillBeDeleted);
			if($ifExitsSystem===true){
				return 0;
			}
		}
		$sql = 'delete from ebh_pcategories where catid in '.$in;
		return $this->portaldb->query($sql)?1:0;
	}

	/**
	 *获取指定分类下面的所有后代分类catid集合
	 */
	public function getPosterity($catid = 0){
		$sql = 'select catid,upid from ebh_pcategories';
		$cates = $this->portaldb->query($sql)->list_array();
		return $this->_getPosterity($cates,$catid);

	}
	/**
	 *根据catid获取upid
	 *
	 */
	public function getUpidByCatid($catid=0){
		$sql = 'select upid from ebh_pcategories where catid = '.intval($catid).' limit 1';
		$res = $this->portaldb->query($sql)->row_array();
		return isset($res['upid'])?$res['upid']:false;
	}
	/**
	 *根据catid获取父级信息
	 *
	 */
	public function getUpInfoByCatid($catid=0){
		$sql = 'select catid,code from ebh_pcategories where catid = '.intval($catid).' limit 1';
		return $this->portaldb->query($sql)->row_array();
	}
	/**
	 *根据子cateid获取整个层级链条
	 *
	 */
	public function getAncestorChain($catid,$cates = array(),$upid=false,$cateName=false,$glue='>>',$ifLinkMode=false){
		if(empty($cates)){
			$cates = $this->getSimpleList(true);
		}
		if($upid===false){
			$upid = $this->getUpidByCatid(intval($catid));
		}
		$upInfo = $this->getUpInfoByCatid($upid);
		$upcode = $upInfo['code'];
		if($cateName==false){
			$cateInfo = $this->getOneByCatid($catid);
		}else{
			$cateInfo['name'] = $cateName;
		}
		$res = $this->_getAncestorChain($cates,$upid,$ifLinkMode);
		if($ifLinkMode===false){
			$res[] = $cateInfo['name'];
		}else{
			$res[]='<a href="/'.$upcode.'-1-0-0-'.$catid.'.html">'.$cateInfo['name'].'</a>';
		}
		
		return implode($glue,$res);
	}
	public function _getAncestorChain($cates,$upid=0,$ifLinkMode,$upcode=''){
		$returnArr = array();
		foreach ($cates as $cate) {
			if($cate['catid']==$upid){
				if($ifLinkMode===false){
					$returnArr[]=$cate['name'];
				}else{
					$returnArr[]='<a href="/'.$cate['code'].'-1-0-0-'.$cate['catid'].'.html">'.$cate['name'].'</a>';
				}
				if($cate['upid']!=0){
					$returnArr = array_merge($this->_getAncestorChain($cates,$cate['upid']),$returnArr,$ifLinkMode);
				}
				break;
			}
		}
		return $returnArr;
	}
	/**
	 *获取指定分类下面的所有后代分类catid集合函数的辅助函数
	 */
	private function _getPosterity($cates = array(),$upid = 0){
		$returnArr = array();
		foreach ($cates as $cate) {
			if($cate['upid']==$upid){
				$returnArr[] = intval($cate['catid']);
				$teturnArr = array_merge($returnArr,$this->_getPosterity($cates,$cate['catid']));
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
	public function _move($catid,$toCatid,$type){
		if(empty($catid)){
			return false;
		}
		if(!in_array($type,array(1,2,3))){
			return false;
		}
		$catidArr = array();
		if(is_scalar($catid)){
			$catidArr[] = $catid;
		}else{
			$catidArr = $catid;
		}
		$typeReflection = array('1'=>'moveBefore','2'=>'moveTo','3'=>'moveAfter');
		$callFuncName = $typeReflection[$type];
		$tag = true;
		$this->portaldb->begin_trans();
		foreach ($catidArr as $v) {
			$tag=$tag&&call_user_func_array(array($this,$callFuncName),array(intval($v),$toCatid));
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
	private function moveTo($catid,$toCatid){
		if($catid==$toCatid){
			return false;
		}
		$res = $this->portaldb->update('ebh_pcategories',array('upid'=>$toCatid),array('catid'=>$catid));
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
	private function moveBefore($catid,$toCatid){
		if($catid==$toCatid){
			return false;
		}
		$cateInfo = $this->getOneByCatid($catid);
		$tocateInfo = $this->getOneByCatid($toCatid);
		$param1 = array('upid'=>$tocateInfo['upid'],'displayorder'=>max(0,$tocateInfo['displayorder']-1));
		$where1 = array('catid'=>$catid);
		$res1 = $res2 = $this->portaldb->update('ebh_pcategories',$param1,$where1);
		if($tocateInfo['displayorder']==0){
			$param2 = array('displayorder'=>(1+$tocateInfo['displayorder']));
			$where2 = array('catid'=>$toCatid);
			$res2 = $this->portaldb->update('ebh_pcategories',$param2,$where2);
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

	private function moveAfter($catid,$toCatid){
		if($catid==$toCatid){
			return false;
		}
		$cateInfo = $this->getOneByCatid($catid);
		$tocateInfo = $this->getOneByCatid($toCatid);
		$param = array('upid'=>$tocateInfo['upid'],'displayorder'=>$tocateInfo['displayorder']+1);
		$where = array('catid'=>$catid);
		$res = $this->portaldb->update('ebh_pcategories',$param,$where);
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
	public function ifExitsSystem($catid){
		if(is_scalar($catid)){
			$sql = 'select count(c.catid) count from ebh_pcategories c where c.system = 1 AND c.catid = '.$this->portaldb->escape_str($catid);
		}else{
			$in = '('.implode(',', $catid).')';
			$sql = 'select count(c.catid) count from ebh_pcategories c where c.catid in '.$in.' AND c.system = 1';
		}
		$cates = $this->portaldb->query($sql)->row_array();
		return $cates['count']>0?true:false;
	}

	/**
	 *判断code是否已经存在
	 *
	 */
	public function ifCodeExist($code = ''){
		if(empty($code)){
			return false;
		}
		$sql = 'select count(catid) count from ebh_pcategories where code =\''.$this->portaldb->escape_str($code).'\' limit 1';
		$res = $this->portaldb->query($sql)->row_array();
		return $res['count']==1?true:false;
	}


	/**
	 *获取所有顶级分类(upid=0)
	 *
	 */
	public function getTopCates(){
		$sql = 'select c.catid,c.upid,c.code,c.name from ebh_pcategories c where c.upid = 0';
		return $this->portaldb->query($sql)->list_array();
	}

	/**
	 *获取分类树
	 *
	 *
	 */
	public function getCateTreeWithChildren($catids){
		if(empty($catids)){
			$cates = $this->getTopCates();
		}else{
			if(is_scalar($catids)){
				$cates = array($this->getOneByCatid($catids));
			}
		}
		
		$allCates = $newCates = $this->getSimpleList();
		$returnArr = array();
		foreach ($cates as $cate) {
			$cate['children'] = $this->getChildren($cate['catid'],$allCates);
			$returnArr[] = $cate;
		}
		return $returnArr;

	}

	private function getChildren($catid,$allCates){
		$children = array();
		foreach ($allCates as $oneCate) {
			if($oneCate['upid']==$catid){
				$children[] = $oneCate;
			}
		}
		return $children;
	}

	/**
	 *根据catid判断该栏目是不是顶级栏目,是返回该栏目信息,不是则返回false
	 *
	 */
	public function isTopCate($catid = 0){
		$sql ='select catid,upid,name,code from ebh_pcategories where catid='.intval($catid);
		$res = $this->portaldb->query($sql)->row_array();
		if(empty($res['upid'])){
			return $res;
		}else{
			return false;
		}
	}

	/**
	 *根据catid获取父类相关信息
	 *
	 */
	public function getParentInfo($catid = 0){
		$upid = $this->getUpidByCatid($catid);
		return $this->getOneByCatid($upid);
	}
	/**
	 *根据父级catid获取父级和一层子代栏目信息
	 *
	 */
	public function getFamilyCates($catid){
		$catid = intval($catid);
		if($catid==0)return array();
		$father = $this->getOneByCatid($catid);
		$father = array($father);
		$sql='select catid,upid,name from ebh_pcategories where upid='.intval($catid);
		$children = $this->portaldb->query($sql)->list_array();
		return array_merge($father,$children);
	}
	/**
	 *根据父级catid获取一层子代栏目信息
	 *
	 */
	public function getChildrenCates($catid,$includeEmptyCaturl = true){
		$catid = intval($catid);
		if($catid==0)return array();
		if($includeEmptyCaturl===false){
			$sql='select catid,upid,name from ebh_pcategories where caturl=\'\' AND upid='.intval($catid);
		}else{
			$sql='select catid,upid,name from ebh_pcategories where upid='.intval($catid);
		}
		$children = $this->portaldb->query($sql)->list_array();
		return array_merge($children);
	}

	/**
	 *获取非隐藏分类列表
	 *
	 */
	public function getVisibleList(){
		$sql = 'select c.catid,c.upid,c.name,c.code,c.caturl,c.target from ebh_pcategories c where c.visible=1 order by displayorder,catid ';
		return $this->portaldb->query($sql)->list_array();
	}
	/**
	 *根据code获取栏目信息
	 */
	public function getCateInfoByCode($code = ''){
		$sql = 'select c.* from ebh_pcategories c where c.code = \''.$this->portaldb->escape_str($code).'\' limit 1';
		return $this->portaldb->query($sql)->row_array();
	}


}