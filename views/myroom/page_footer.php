<div style="clear:both;"></div>
<div style="text-align:center;">
<?php
debug_info();
?>
<!-- 统计代码开始 -->
<?php
$systemsetting = Ebh::app()->room->getSystemSetting();
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
    echo $systemsetting['analytics'];
} else {
    EBH::app()->lib('Analytics')->get('baidu');
}
?>
</div>
<!-- 统计代码结束 -->
</body>
</html>