<?php 
class Help {
		/**
		*获取帮助中心左侧信息
		**/
	public function getItems(){
		$roominfo = Ebh::app()->room->getcurroom();
	//帮助中心左侧菜单树状图 
		 $catmodel  = Ebh::app()->model('category');
         $catlist = $catmodel->getCatlistByUpid(789,0,NULL);
			$categorylist = array();
			foreach($catlist as $arr){
				$category = $catmodel->getCatlistByUpid($arr['catid'],0,NULL); 
				$catelist = array('catmodel'=>$arr,'category'=>$category);
				array_push($categorylist,$catelist);
			}
			return $categorylist;

	}
	public function getItemscenter(){
		$roominfo = Ebh::app()->room->getcurroom();
	//帮助中心左侧(中部)菜单树状图 
		 $catmodel  = Ebh::app()->model('category');
			$catlist2 = $catmodel->getCatlistByUpid(811,0,NULL);
			$categorylist2 = array();
			foreach($catlist2 as $arr){
				$category2 = $catmodel->getCatlistByUpid($arr['catid'],0,NULL); 
				$catelist2 = array('catmodel'=>$arr,'category'=>$category2);
				array_push($categorylist2,$catelist2);
			}
			return $categorylist2;
	}
	public function getItemslast(){
		$roominfo = Ebh::app()->room->getcurroom();
	//帮助中心左侧(下部)菜单树状图 
		 $catmodel  = Ebh::app()->model('category');
		$catlist3 = $catmodel->getCatlistByUpid(826,0,NULL);
			$categorylist3 = array();
			foreach($catlist3 as $arr){
				$category3 = $catmodel->getCatlistByUpid($arr['catid'],0,NULL); 
				$catelist3 = array('catmodel'=>$arr,'category'=>$category3);
				array_push($categorylist3,$catelist3);
			}
			return $categorylist3;
	}
} 

?>