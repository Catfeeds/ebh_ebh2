<?php
$this->display('aroomv2/page_header');
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
	}
	.lc_detail .agess1{
		float:left;
		border:0;
		margin: 0;
		border-bottom: 1px solid #eee;
	}
	.lc_detail .cuor{
		border: 0;
	}
</style>
<div class="topbaad">
<div class="user-main clearfix">
<div class="">
		<div class="ter_tit" style="margin-bottom:15px;">
		当前位置 > <a href="/aroomv2/asetting.html">网校概况</a> > 部分实例
		</div>
	<div class="lefrig" style="width:788px;float:left;">
	<?php
		if(empty($roomlist)){
	?>
		<div class="nojoin" style="border:1px solid #cdcdcd;background:#fff;width:786px;height:200px;">
			<p style="line-height:197px; text-align: center;padding-left:0px;">你还没有实例网校</p>
		</div>
	<?php
	}
		else{
			foreach($roomlist as $proom){
				if(strstr($_SERVER['HTTP_HOST'], '.ebh.net') == '.ebh.net'){
					$flg = '.ebh.net';
				}else{
					$flg = '.ebanhui.com';
				}
				$proom['murl'] = 'http://'.$proom['domain'].$flg;
				
	?>
		<div class="lc_detail">
			<ul>
				<li class="agess" onmouseover="this.className='agess1'" onmouseout="this.className='agess'">
				<div class="cuor">
				<a href="<?php echo $proom['murl']?>" target="_blank" class="tophref" title="<?php echo $proom['crname']?>">
				<?php $logo=empty($proom['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$proom['cface'];?>
				<img src="<?=$logo?>" width="100" height="100" style="margin-top:2px; margin-left:2px;"></a></div>
				<h2 class="courtit">
				<a href="<?php echo $proom['murl']?>"  target="_blank" class="tophref" title="<?php echo $proom['crname']?>"><?php echo $proom['crname']?></a>
				</h2>
				<p class="yunjsh " style="word-break:break-all;"><?php echo shortstr($proom['summary'],250,'...')?></p>
				<a target="_blank" class="add tophref" style=" color:#FFF;text-decoration: none;" href="<?php echo $proom['murl']?>">进  入</a>
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
