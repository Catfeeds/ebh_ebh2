<div style="clear:both"></div>
<?php $get = Ebh::app()->getInput()->get();?>
<?php if(!((isApp()==true) || !empty($get['ht'])&&($get['ht']==1))){?>
<?php
$room = Ebh::app()->room->getcurroom();
$icp = '<a href="http://www.miibeian.gov.cn/" style="color: #666666;" target="_blank">  浙B2-20160787</a> Copyright &copy; 2011-' . date('Y') . ' ebh.net All Rights Reserved';
if (!empty($room) && !empty($room['icp']))
    $icp = $room['icp'];
?>
<div class="foot">
    <P style="color: #666666"></P><?= $icp ?></P></div>
<?php }?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
</body>
</html>