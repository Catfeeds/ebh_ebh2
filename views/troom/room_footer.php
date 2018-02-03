<?php
$icp = '<a href="http://www.miibeian.gov.cn/" style="color: #666666;" target="_blank">  浙B2-20160787</a> Copyright &copy; ebh.net All Rights Reserved';
if(!empty($room) && !empty($room['icp']))
	$icp = $room['icp'];
?>
<div class="foot">
<P style="color: #666666"><?=$icp?> <?= debug_info()?></P></div>
</body>
</html>
