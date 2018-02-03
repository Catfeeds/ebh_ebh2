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


		<div class="work_mes" style=" margin-bottom:10px;">
			<ul >
				<?php
					$codepath = $this->uri->codepath;
					$codepatharr = explode('/',$codepath);
					
					foreach($menu as $mn){
						$workcurrent = '';
						$target = '';
						$mn['path'] = $codepatharr[0].'/'.$codepatharr[1].'/'.$mn['code'];
						if($codepath==$mn['path'])
							$workcurrent = '  class="workcurrent"';
						if(!empty($mn['target']))
							$target = ' target="'.$mn['target'].'"';
					?>
					<li <?=$workcurrent?>><a <?=$target?> href="<?=geturl($mn['path'])?>"><span><?=$mn['name']?></span></a></li>
					<?php
					}
				?>
				
			</ul>
		</div>
		





