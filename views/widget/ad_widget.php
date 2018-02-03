<script src="http://static.ebanhui.com/ebh/js/jquery.superslide.2.1.1.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/shouhui.css" />
<?php
$defaulturl = empty($property['default']) ? '' : $property['default'];
$width = empty($property['_width']) ? 500 : $property['_width'];
$height = empty($property['_height']) ? 200 : $property['_height'];
//$right = $property['_id']=='headf' ? '38%' : '44%';
if($property['_id']=='headf'){
	if(count($data)==2){
		$right = '42%';
	}else if(count($data)==3){
		$right = '38%';
	}else if(count($data)==4){
		$right = '34%';
	}else if(count($data)==5){
		$right = '31%';
	}else{
		$right = '0px';
	}
}elseif($property['_id']=='pagesmall'){
	if(count($data)==2){
		$right = '32%';
	}else if(count($data)==3){
		$right = '24%';
	}else if(count($data)==4){
		$right = '16%';
	}else if(count($data)==5){
		$right = '8%';
	}else{
		$right = '0px';
	}
}else{
	if(count($data)==2){
		$right = '46%';
	}else if(count($data)==3){
		$right = '44%';
	}else if(count($data)==4){
		$right = '42%';
	}else if(count($data)==5){
		$right = '40%';
	}else{
		$right = '0px';
	}
}
$id = empty($property['_id']) ? '' : $property['_id'];

if (count($data) == 0) {
    ?>
    <img  src="<?= $defaulturl ?>" style="width:<?= $width!='auto'?$width.'px':'auto' ?>;height:<?= $height!='auto'?$height.'px':'auto' ?>" >
    <?php
} else {
    ?>
<div class="buycom">
    <ul class="buypic"  id="<?= $id ?>" style="height:<?= $height ?>px;">
		<?php
        foreach ($data as $ks => $vi) {
            $showstyle = $ks == 0 ? '' : ' style="display:none"';
            $url = $vi['itemurl'] == '#' ? 'javascript:;' : $vi['itemurl'];
            ?>
        <li <?= $showstyle ?>>
			<a <?= $vi['itemurl'] == '#' ?'':' target="_blank"' ?> title="<?= $vi['subject'] ?>" href="<?= $url ?>" >
				<img style="width:<?= $width!='auto'?$width.'px':'auto' ?>;height:<?= $height!='auto'?$height.'px':'auto' ?>"  alt="<?= $vi['subject'] ?>" title="<?= $vi['subject'] ?>" src="<?= empty($vi['thumb'])?$defaulturl:$vi['thumb'] ?>"/>
			</a>
		</li>
		<?php } ?>
    </ul>
    <div class="num" style="right:<?= $right?>">
	<?php if(count($data)>1){ ?>
    	<ul></ul>
	<?php } ?>
    </div>
</div>
<?php } ?>
<script>

/*鼠标移过，左右按钮显示*/
$(".buycom").hover(function(){
	$(this).find(".prev,.next").fadeTo("show",0.2);
},function(){
	$(this).find(".prev,.next").hide();
})
/*鼠标移过某个按钮 高亮显示*/
$(".prev,.next").hover(function(){
	$(this).fadeTo("show",0.7);
},function(){
	$(this).fadeTo("show",0.2);
})
// $("#<?= $id ?> li img").bind('load',function(){
// 	$(".buypic li img").unbind('load');
// 	$(".buycom").slide({ titCell:".num ul" , mainCell:".buypic" , effect:"fold", autoPlay:true, delayTime:1200 , autoPage:true });
// });

;(function(){
	var task,
		$fimg;
	$fimg = $("#<?= $id ?> li img:first");
	$fimg.length > 0 && 
	(function check(){
		$fimg.height() > 50 && 
		(function(){
			$(".buycom").slide({ titCell:".num ul" , mainCell:".buypic" , effect:"fold", autoPlay:true, delayTime:1200 , autoPage:true });
			return true;
		})() || 
		(function(){
			task = setTimeout(function(){
				check();
			},100);
		})()
	})();
})();

</script>
<!-- 代码 结束 -->










