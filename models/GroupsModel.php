<?php
/**
 *group类，针对ebh_gourps表
 */
	class GroupsModel extends CModel{
		public function __construct(){
			parent::__construct();
			$this->cache = Ebh::app()->getCache();
		}
		/**
		 *根据groupid获取单条group信息
		 *@author zkq
		 *@param  int $groupid
		 *@return (失败bool false),(成功array)
		 */

		public function getInfoByGroupid($groupid = null){
			if(is_null($groupid)){
				return false;
			}else{
				$sql = 'select g.* from ebh_groups g where g.groupid = '.intval($groupid). ' limit 1';
				return $this->db->query($sql)->row_array();
			}
		}
		/**
		 *获取所有组信息列表
		 *@author zkq
		 *@param null
		 *@return array
		 */
		public function getList(){
			$sql = 'select g.* from ebh_groups g order by g.type desc';
			return $this->db->query($sql)->list_array();
		}

		/**
		 *获所有的组信息,将其组的groupname处理成┣━格式
		 *@author zkq
		 *@param int $upid (父groupid)
		 *@param int $index ($index表示子集初始时的┣━个数)
		 *@return array
		 */
		public function getTree($upid=0,$index=0){
			$cahceKey_group = '_group_';
			if($this->cache->get($cahceKey_group)){
				$groups = unserialize($this->cache->get($cahceKey_group));
			}else{
				$groups = $this->getList();
				$this->cache->set($cahceKey_group,serialize($groups),3600*24);
			}
			$treeList = $this->_getTree($groups,$upid,$index);
			return $treeList;
		}
		/**
		 *获取组的树形结构的<select><option>1</option></select>格式的数据
		 *@author zkq
		 *@param (null is ok) String $name
		 *@param (null is ok) String $id
		 *@param (null is ok) String $upid
		 *@return text/html
		 *其中$name表示<select>的name树形,id表示其id,$upid表示顶级组的groupid
		 *如传入的upid为1表示获取所有groupid为$upid的组以及其下的所有后代的<select>控件,$select为默认选中的组的groupid
		 */
		public function getGroupsSelect($name='toid',$id='toid',$select=0,$upid=0){
			$cahceKey_group_select = '_group_'.$name.$id.$select;
			if($this->cache->get($cahceKey_group_select)){
				return $this->cache->get($cahceKey_group_select);
			}
			$s = '<select name='.$name.' id='.$id.'>';
			$s.='<option value="0">所有用户组</option>';
			$treeList = $this->getTree($upid);
			foreach ($treeList as $tv) {
				if($tv['groupid']==$select){
					$s.='<option value="'.$tv['groupid'].'" selected=selected>'.$tv['groupname'].'</option>';
				}else{
					$s.='<option value="'.$tv['groupid'].'">'.$tv['groupname'].'</option>';
				}
			}
			$s.='</select>';
			$this->cache->set($cahceKey_group_select,$s,3600*24);
			return $s;
		}

		/**
		 *根据组列表处理出相关的树形结构,本方法由$this->getTree()调用,禁止单独调用,参数列表参见$this->getTree()
		 *@author zkq
		 */
		private function _getTree($gList,$upid=0,$index=0){
			$treeArr = array();
			foreach ($gList as $gv) {
				if($gv['upid']==$upid){
					$gv['groupname'] = str_repeat('┣━',$index).$gv['groupname'];
					$treeArr[] = $gv;
					$treeArr = array_merge($treeArr,$this->_getTree($gList,$gv['groupid'],$index+1));
				}
			}
			return $treeArr;
		}
	}
?>