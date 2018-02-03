<div class="list_foot">
	<div class="list_bot">
	<?php
	$catlib = Ebh::app()->lib('Category');
	if(empty($room))
	$room = Ebh::app()->room->getcurroom();
//	$roominfo = Ebh::app()->room->getcurroom();
	$cats = $catlib->getCateByPos(2);
	?>
		<p>
	<?php foreach($cats as $key=>$cat) { ?>
  	<?= $key != 0 ? ' | ':'' ?>
  	<a href="<?php if(empty($cat['caturl'])){?><?= $cat['code']?>.html<?php }else{ ?><?= $cat['caturl']?><?php }?>" title="<?= $cat['name']?>"><?= $cat['name']?></a>
	<?php } ?>
  	</p>
		<P style="color: #666666"><a href="http://www.miibeian.gov.cn/" style="color: #666666;" target="_blank">  浙B2-20160787</a> Copyright &copy; ebh.net All Rights Reserved </P>
		
	</div>
	
</div>
</body>
</html>