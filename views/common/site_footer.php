<?php if(isApp()==false){?>
<?php
$icp = '<a href="http://www.miibeian.gov.cn/" style="color: #666666;" target="_blank">  浙B2-20160787</a> Copyright &copy; 2011-' . date('Y') . ' ebh.net All Rights Reserved';
if (!empty($room) && !empty($room['icp']))
    $icp = $room['icp'];
?>
<div class="foot">
    <P style="color: #666666"></P><?= $icp ?></P></div>
<?php }?>
<style>
.foot{
	background:url("http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg") repeat;
}
</style>
</body>
</html>