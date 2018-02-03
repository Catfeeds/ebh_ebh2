<?php
	class ModuleModel extends CModel{
		/**
		 *@param bool $tree
		 *@return array(失败返回false)
		 *用法:传入$tree为true或者不传，返回module列表的树形结构,$tree传其它值表示直接返回module非树形列表
		 *树形结构：
		 * module
		 *┣━module1
		 *┣━┣━module2
		*/
		public function getList($tree=true){
			$sql = 'select m.* from ebh_modules m order by displayorder';
			$moduleList = $this->db->query($sql)->list_array();
			if($moduleList!==false){
				if($tree===true){
					return $this->getModuleTree($moduleList);
				}else{
					return $moduleList;
				}
			}else{
				return false;
			}
		}
		/**
		 * @param array $moduleList
		 * @param int $upid
		 * @return 树形结构的module列表
		 */
		private function getModuleTree($moduleList=array(),$upid=0,$index=0){
			$moduleListTree = array();
			foreach ($moduleList as $value) {
				if($value['upid']==$upid){
					$value['name'] = str_repeat('┣━',$index).$value['name'];
					$moduleListTree[]=$value;
					$moduleListTree=array_merge($moduleListTree,$this->getModuleTree($moduleList,$value['moduleid'],$index+1));
				}
			}
			return $moduleListTree;
		}

		//获取简单的module树形列表，用于小挂件
		public function getModuleSimpleList(){
			$sql = 'select m.moduleid,m.upid,m.name from ebh_modules m order by displayorder';
			$moduleList = $this->db->query($sql)->list_array();
			if($moduleList!==false){
				return $this->getModuleTree($moduleList);
			}
		}

		/**
		 *根据moduleid获取单个module信息
		 *@param int $moduleid
		 *@return array
		*/
		public function getModuleByModuleId($moduleid=null){
			if(is_null($moduleid)){
				return false;
			}else{
				$sql = 'select m.* from ebh_modules m where moduleid ='.intval($moduleid).' limit 1';
				return $this->db->query($sql)->row_array();
			}
		}

		/**
		 *根据moduleid返回子类moduleid,upid列表
		 *@param int $moduleid
		 *@return array
		*/
		private function getChlidrenListByModuleid($moduleid=null){
			$sql = 'select m.moduleid,m.upid from ebh_modules m where upid='.intval($moduleid);
			return $this->db->query($sql)->list_array();
		}
		/**
		 *module增加,编辑方法
		 *@param array $param
		 *@return bool
		 *$param['op'] 必须为add,edit其中的一个,add表示新增module,edit表示编辑module
		 */
		public function op($param=array()){
			if(count($param)==0||empty($param['op'])){
				return false;
			}
			if(!in_array($param['op'],array('add','edit'))){
				return false;
			}
			$param = safeHtml($param);
			$setArr = array();
			$setArr['upid'] = !empty($param['upid'])?$param['upid']:0;
			$setArr['name'] = !empty($param['name'])?$param['name']:'';
			$setArr['identifier'] = !empty($param['identifier'])?$param['identifier']:'';
			$setArr['description'] = !empty($param['description'])?$param['description']:'';
			$setArr['redir'] = !empty($param['redir'])?$param['redir']:'';
			$setArr['system'] = intval($param['system']);
			$setArr['visible'] = intval($param['visible']);
			$setArr['displayorder'] = !empty($param['displayorder'])?$param['displayorder']:0;
			$setArr['opvalue'] = !empty($param['opvalue'])?array_sum($param['opvalue']):0;
			if($param['op']=='add'){
				return $this->db->insert('ebh_modules',$setArr);
			}else{
				return $this->db->update('ebh_modules',$setArr,array('moduleid'=>$param['moduleid']));
			}
			
		}

		/**
		 * @param int $moduleid
		 * @param bool $ifforce
		 * @return bool
		 * 删除传入的moduleid分类以及其后代所有分类,如果传入$ifforce为true表示强制->
		 * 删除(存在系统目录也会删除);否则如果存在系统目录则回滚删除,返回false
		 */
		public function delHandle($moduleid=null,$ifforce=false){
			if(is_null($moduleid)){
				return false;
			}
			if(is_array($moduleid)){
				foreach ($moduleid as  $v) {
					$this->db->begin_trans();
					if($this->del(intval($v),$ifforce)===false){
						$this->db->rollback_trans();
						return '存在系统目录,无法删除!';
					}else{
						$this->db->commit_trans();
						return true;
					}					
				}
			}else{
				$this->db->begin_trans();
				if($this->del($moduleid,$ifforce)===false){
					$this->db->rollback_trans();
					return '存在系统目录,无法删除!';
				}else{
					$this->db->commit_trans();
					return true;
				}
			}
			
			
			
		}
		/**
		 *由该控制器的delHandle方法调用,
		 *参数和delHandle一样
		 */
		private function del($moduleid=null,$ifforce=false){
			$isok=true;
			if(is_null($moduleid)){
				return false;
			}
			$moduleinfo = $this->getModuleByModuleId($moduleid);
			if($moduleinfo==false){
				return false;
			}
			if(($moduleinfo['system']==1)&&($ifforce==1||$ifforce===false)){
				return false;
			}

			$chlidren = $this->getChlidrenListByModuleid($moduleid);
			if($chlidren!==false){
				foreach ($chlidren as $v) {
					if($this->del($v['moduleid'],$ifforce)===false){
						$isok=false;
					}
				}
			}
			if($this->db->delete('ebh_modules','moduleid='.$moduleid)==-1){
				$isok=false;
			}

			return $isok;

		}
		/**
		 * @param array $modules 
		 * @return bool
		 * 格式 : $modules = array(module1,module2,module2,...)
		 *
		 */
		public function hideAll($modules = array()){
			$isok = true;
			if(is_array($modules)&&count($modules)>0){
				foreach ($modules as $v) {
					if($this->db->update('ebh_modules',array('visible'=>0),array('moduleid'=>intval($v)))===false){
						$isok = false;
					}
				}
			}
			return $isok;
		}
		/**
		 * module批量排序
		 * @param array $modules 
		 * @return bool
		 * 格式 : $paramArr = array(
		 						array('moduleid1,displayorder1'),
								array('moduleid2,displayorder2'),
								array('moduleid3,displayorder3')
		 						);
		 *
		 */
		public function saveAll($paramArr=array()){
			$isok=true;
			if(is_array($paramArr)&&count($paramArr)>0){
				foreach ($paramArr as $v) {
					$info = explode(',',$v);
					if($this->db->update('ebh_modules',array('displayorder'=>intval($info[1])),array('moduleid'=>intval($info[0])))===false){
						$isok=false;
					}
				}
			}
			return $isok;
		}

		/**
		 * module批量移动到对应的module下
		 * @param array $dataArr 
		 * @param int $toWhere
		 * @return bool
		 * $dataArr = array(moduleid1,moduleid2,moduleid3.....);
		 */
		public function movecatAll($dataArr,$toWhere=null){
			$isok=true;
			if(is_array($dataArr)&&count($dataArr)>0&&!is_null($toWhere)){
				foreach ($dataArr as $v) {
					if($this->db->update('ebh_modules',array('upid'=>intval($toWhere)),array('moduleid'=>intval($v)))===false){
						$isok = false;
					}
				}
			}
			
			return $isok;
		}
		/**
		 * 修改传入的moduleid的排序为传入的order
		 * @param int $moduleid
		 * @param int $order
		 * @return bool
		 */
		public function moveorder($moduleid=null,$order=null){
			$isok=true;
			if(!is_null($moduleid)&&!is_null($order)){
				if($this->db->update('ebh_modules',array('displayorder'=>intval($order)),array('moduleid'=>intval($moduleid)))===false){
					$isok = false;
				}
			}
			return $isok;

		}
		/**
		 * 将传入的moduleid的对应的记录移动到前一条记录之前或者后一条记录之后(tag=1之后，tag=-1之前)
		 * @param int $moduleid
		 * @param int $tag
		 * @return bool
		*/
		//tag为-1表示上移，1表示下移
		public function moveupordown($moduleid=null,$tag=null){
			$isok = true;
			if(is_null($moduleid)||is_null($tag)){
				return false;
			}
			$moduleinfo = $this->getModuleByModuleId($moduleid);
			if($moduleinfo===false){
				die('该模块信息不存在!');
			}
			$moduleid = intval($moduleinfo['moduleid']);
			$upid = intval($moduleinfo['upid']);
			$displayorder = intval($moduleinfo['displayorder']);
			if($tag==-1){
				$sql = 'select m.moduleid,m.displayorder from ebh_modules m where m.upid ='.$upid.' and displayorder<'.$displayorder.' order by m.displayorder desc limit 0,1';
			}else{
				$sql = 'select m.moduleid,m.displayorder from ebh_modules m where m.upid ='.$upid.' and displayorder>'.$displayorder.' order by m.displayorder asc limit 0,1';
			}
			
			$targetInfo = $this->db->query($sql)->row_array();
			if($targetInfo==false){
				return false;
			}
			$targetModuleId =intval($targetInfo['moduleid']);
			$targetDisplayorder = intval($targetInfo['displayorder']);
			//交换displayorder
			if($this->db->update('ebh_modules',array('displayorder'=>$targetDisplayorder),array('moduleid'=>$moduleid))===false){
				$isok = false;
			}
			if($this->db->update('ebh_modules',array('displayorder'=>$displayorder),array('moduleid'=>$targetModuleId))===false){
				$isok = fasle;
			}
			return $isok;
		}

		
		
	}

?>