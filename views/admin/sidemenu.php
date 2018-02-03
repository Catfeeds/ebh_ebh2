<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sidemenu</title>

<link href="http://static.ebanhui.com/ebh/admin/skins/orange/images/style.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/admin/include/admin.js"></script>
<!--
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/include/easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/include/easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/include/easyui/demo/demo.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/include/easyui/jquery.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/include/easyui/jquery.easyui.min.js"></script>
-->
<base target="mainframe" />
<style type="text/css">
/*html {overflow-x:hidden;}*/
</style>
<script type="text/javascript">
$(function(){
treeView();
});
</script>
</head>

<body id="side">



<?php 
foreach($sidemenulist as $listitem){?>
<div id="<?php echo $listitem['identifier']?>" style="display: block; width: 162px;">
<h3><?php echo $listitem['name']?></h3>
	<ul>
		
			<?php 
			foreach($submenulist as $subitemarr){
				foreach($subitemarr as $subitem){
				if($subitem['upid'] == $listitem['moduleid']){
				$temparr = explode('&',$subitem['identifier']);  
				$controller = $temparr[0];
				$argstr = !empty($temparr[1])? $temparr[1] :'';
				$arg = (substr($argstr,0,2)=="op")?substr($argstr,3):substr($argstr,5);
				//var_dump($argstr);
				$arg = !empty($arg)? '/'.$arg :'';
				$temparr = explode('#',$controller);
				$controller = $temparr[0];
				$pos = !empty($temparr[1])? '#'.$temparr[1] :'';
				//$alink = empty($subitem['redir']) ? '/admin/'. $controller : $subitem['redir'];
				$alink = '/admin/'.$controller;
				$alink.= "$arg.html" . $pos;
			?>
			<li>
			<a href="<?php echo $alink;?>" id="<?=$controller.'_a'?>" target="mainframe" <?php if($subitemarr[0]==$subitem && $submenulist[0]==$subitemarr){echo 'class="current"';}?>><?php echo $subitem['name']?></a>
			</li>
			<?php }}}?>
		
	</ul>
</div>
<?php }?>


</body>
</html>