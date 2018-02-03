<?php
/*
首页导航
*/
class Navigator{
	public function getnavigator(){
		$navigatorlist = Ebh::app()->getConfig()->load('roomnav');
		$defaultnav = array_keys($navigatorlist);
		$roommodel = Ebh::app()->model('classroom');
		$roominfo = Ebh::app()->room->getcurroom();
		$roomnav = $roommodel->getNavigator($roominfo['crid']);
		$navon = TRUE;
		if(!empty($roomnav)){
			$navigatordata = unserialize($roomnav);
			$navigatorarr = $navigatordata['navarr'];
			krsort($navigatorarr);
			$hasindex = false;
			foreach($navigatorarr as $nav){
				$temp = $nav;
				if(!empty($navigatorlist[$nav['code']]))
					$temp['url'] = $navigatorlist[$nav['code']]['url'];
				if(!empty($navigatorlist[$nav['code']])){
					unset($navigatorlist[$nav['code']]);
				}
				if($nav['available'] && $nav['code'] != 'index'){
					array_unshift($navigatorlist,$temp);
				}elseif($nav['available'] && $nav['code'] == 'index'){
					$navindex = $temp;
					$hasindex = true;
				}
			}
			if($hasindex)
				array_unshift($navigatorlist,$navindex);
			foreach($navigatorlist as $k=>$nav){
				if(!is_numeric($k) || ($nav['code']=='fineware' && $roominfo['template']!='plate'))
					unset($navigatorlist[$k]);
			}
		}
		echo '<div style="width:960px;margin:0 auto;">
			<div class="navlist">';
		if($navon){
			echo '
			
			<div class="navlist_son fl">
			<ul>';
			
			if(!empty($navigatorlist)){
				$uri = Ebh::app()->getUri();
				
				$cururl = '/'.$uri->codepath;
				if(!empty($uri->itemid))
					$cururl.= '/'.$uri->itemid;
				foreach($navigatorlist as $k=>$nav){
					// $k==0?$mlclass='':$mlclass='ml20';
					$curclass = '';
					$targetstr = '';
					if($nav['code']=='index')
						$nurl = '/';
					elseif(in_array($nav['code'],$defaultnav))
						$nurl = $nav['url'].'.html';
					elseif(!empty($nav['url'])){
						$nurl = $nav['url'];
						if(!empty($nav['target']))
							$targetstr = 'target="'.$nav['target'].'"';
					}
					else
						$nurl = '/navcm/'.ltrim($nav['code'],'n').'.html';
					if($cururl == str_replace('.html','',$nurl)){
						$curclass = 'navcur';
						if(!in_array($nav['code'],$defaultnav)){
							echo '<script>document.title="'.(empty($nav['nickname'])?$nav['name']:$nav['nickname']).'";</script>';
						}
					}
					echo '<li class="fl '.$curclass.'"><a href="'.$nurl.'" '.$targetstr.'>'.(empty($nav['nickname'])?$nav['name']:$nav['nickname']).'</a></li>';
				}
			}
			echo '</ul>
		</div>';
		}
		if(!$navon || empty($navigatorlist)){
			echo '<style>
			.navlist{
				display:none;
			}
			</style>';
		}
		echo '<style>.sousuo {display:none}
		.navcur{background:#e3e3e3;color:#333;text-decoration:none;font-weight:bold}
		</style>';
		echo '	<div class="sousuo fr">
					<input class="fl"/>
					<div class="sousuoson fr"></div>
				</div>
			</div>
		</div>';
		return $navigatorlist;
	}
}
?>