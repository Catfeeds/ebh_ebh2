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