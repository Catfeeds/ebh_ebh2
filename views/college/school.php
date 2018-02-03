<?php
$this->display('home/page_header');
?>

<link href="http://static.ebanhui.com/ebh/tpl/2012/css/join.css" rel="stylesheet" type="text/css" />
<style>
	.lc_detail ul{
	}
	.lc_detail .agess{
		float:left;
		border:0;
		margin: 0;
		border-bottom: 1px solid #eee;
		width:786px;
	}
	.lc_detail .agess1{
		float:left;
		border:0;
		margin: 0;
		border-bottom: 1px solid #eee;
		width:786px;
	}
	.lc_detail .cuor{
		border: 0;
	}

</style>
<div class="topbaad">
<div class="user-main clearfix">
<div class="">
	
	<div class="lefrig" style="width:786px;float:left;  padding-bottom:0;">
	<?php
		if(count($roomlist)==0){
	?>
		<div class="nojoin" style="border:1px solid #cdcdcd;background:#fff;width:786px;height:200px;">
			<p style="line-height:197px; text-align: center;padding-left:0px;">你还没有加入网校</p>
		</div>
	<?php
	}
		else{
			foreach($roomlist as $room){
				if(strstr($_SERVER['HTTP_HOST'], '.ebh.net') == '.ebh.net'){
					$flg = '.ebh.net';
				}else{
					$flg = '.ebanhui.com';
				}
				$room['murl'] = 'http://'.$room['domain'].$flg.'/myroom.html';
				
	?>
		<div class="lc_detail">
			<ul>
				<li class="agess" onmouseover="this.className='agess1'" onmouseout="this.className='agess'">
				<div class="cuor">
				<a href="javascript:void(0);" reffer="<?php echo $room['murl']?>" class="tophref" title="<?php echo $room['crname']?>">
				<?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface'];?>
				<img src="<?=$logo?>" width="100" height="100" style="margin-top:2px; margin-left:2px;"></a></div>
				<h2 class="courtit">
				<a href="javascript:void(0);" reffer="<?php echo $room['murl']?>" class="tophref" title="<?php echo $room['crname']?>"><?php echo $room['crname']?></a>
				</h2>
				<p class="yunjsh " style="word-break:break-all;"><?php echo shortstr($room['summary'],250,'...')?></p>
				<a class="add tophref" style=" color:#FFF;text-decoration: none;" href="javascript:void(0);" reffer="<?php echo $room['murl']?>" >进  入</a>
				<p class="due">有效期：<span style="color:#1061a7; font-weight:bold; margin-right:20px;"><?php echo empty($room['enddate'])?'无限制':Date('Y-m-d',$room['enddate'])?></span></p>
				</li>
			
			</ul>
		</div>
	<?php
		}
	}
	?>
	</div>
</div>
</div>
</div>
<script>
$(function(){
	$('.tophref').click(function(){
			var href = $(this).attr("reffer");
			top.location.href = href;
			return false;
		});
	
})
</script>