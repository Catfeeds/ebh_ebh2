<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/editdata.css" rel="stylesheet" />
<style type="text/css">

.spfl{float:left;line-height: 2.2;}
</style>
<?php
$memberlib = Ebh::app()->lib('Member');
if($memberlib==null)
	$memberlib = Ebh::app()->member;
$menu = $memberlib->getsimplatemenu($type);
?>
<?php $roominfo = Ebh::app()->room->getcurroom();?>
<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
<?php
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(empty($roominfo['crid'])){
        	$is_zjdlr = false;
        	$is_newzjdlr = false;
        }else{
	        $appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);        	
        }
?>
<ul >
	<?php
		$codepath = $this->uri->codepath;
		$codepatharr = explode('/',$codepath);
		
		foreach($menu as $mn){
			// if($mn['code'] == 'largedb' && $roominfo['iscollege'] == 1)
				// continue;
			$workcurrent = '';
			$target = '';
			$mn['path'] = $codepatharr[0].'/'.$codepatharr[1].'/'.$mn['code'];
			//echo $codepath;
			//echo $mn['path'];
			if($codepath=='home/profile/avatarold'&&$mn['path']=='home/profile/avatar'){
				$workcurrent = '  class="workcurrent"';
			}elseif($codepath==$mn['path']){
				$workcurrent = '  class="workcurrent"';
			}
			if(!empty($mn['target']))
				$target = ' target="'.$mn['target'].'"';
		?>
		<?php if(!$is_zjdlr || ($mn['name'] != '积分兑换' && $mn['name'] != '兑换记录')){?>
		<li <?=$workcurrent?>><a <?=$target?> href="<?=geturl($mn['path'])?>"><span><?=$mn['name']?></span></a></li>
		<?php }?>
		<?php
		}
	?>
	
	</ul>
</div>






