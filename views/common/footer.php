<!--尾部!-->
<?php
$room = Ebh::app()->room->getcurroom();
$icp = '浙B2-20160787&nbsp;&nbsp;Copyright &copy; 2011-'.date('Y').' ebh.net All Rights Reserved';
if(!empty($room) && !empty($room['icp']))
	$icp = $room['icp'];
?>
<div style="clear:both;"></div>
<div class="fldty">
<div style="text-align:center">
  <span style="color:#666"><?= $icp ?></span>&nbsp;&nbsp;    <br>
    <br>
</div>
</div>
<?php debug_info();?>
<!-- 统计代码开始 -->
<?php
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
	echo $systemsetting['analytics'];
} else {
	EBH::app()->lib('Analytics')->get('baidu');
}
?>
<!-- 统计代码结束 -->
</body>
</html>
