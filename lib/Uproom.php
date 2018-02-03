<?php
/*
子站顶部"返回主站"链接
*/
class Uproom{
	public function getUproom($afterchar=''){
		$crmodel = Ebh::app()->model('classroom');
		$domain = Ebh::app()->getUri()->uri_domain();
		$curdomain = Ebh::app()->getUri()->curdomain;
		$uproom = $crmodel->getUproom($domain);
		if(empty($uproom))
			return '';
		else{
			$mainurl = empty($uproom['fulldomain']) ? $uproom['domain'].'.ebh.net' : $uproom['fulldomain'];
			$linkstr = '<a href="http://'. $mainurl .'" title="'.$uproom['crname'].'">返回主站</a>';

			if(!empty($afterchar))
				$linkstr.= $afterchar;
			return $linkstr;
		}
	}
}
?>