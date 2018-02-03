<?php $this->display('shop/zwx/header'); ?>
<style type="text/css">
.lefzong .rigsize {
    float: left;
    margin-top: 20px;
    width: 450px;
}
.lefzong .lefke {
	border: 1px solid #cdcdcd;
    float: left;
    height: 159px;
    margin: 16px 20px 0 15px;
    width: 114px;
}
.lefzong .zizhans {
	height:199px;
}
.lefzong .zizhans .neiku {
	height:192px;
}
.lefzong .zizhans .lanku {
    height:192px;
}
.append_new{
	float:left;
}
</style>
<div class="dhtop">
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('cloud')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('platform')?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhzizhan0411.jpg" /></a></li>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
</div>
<div style="clear:both"></div>
<div class="zzind">
<div class="fontxian">
<div class="lefzong">
	<div class="fewof">
	<ul>
		<?php 
		$i = 0;
		foreach($splist as $spkey=>$sp) { 
			if(!empty($sp['itemlist'])) {
			?>
			<li>
			<div id="sp_<?= $sp['pid'] ?>" class="sp_div <?= $i == 0 ?'leraten':''?>">
				<a href="#"><?= $sp['pname'] ?></a>
			</div>
			</li>
		<?php 
			}
		$i ++;
		} ?>
		</ul>
	</div>


<?php $crid = $room['crid']?>

<?php if(!empty($splist)){?>
<?php 
	$i = 0;
	foreach($splist as $spkey=>$sp) { 
		if(empty($sp['itemlist']))
			continue;
		?>
	<div id="itempid_<?= $sp['pid'] ?>" class="append_new " <?= $i == 0? '' : 'style="display:none;"' ?> >
		<?php foreach($sp['itemlist'] as $item) { 
		$furl = '';
		if($item['fprice'] == 0) {
			$furl = '/myroom/stusubject/'.$item['folderid'].'.html';
		} else {
			$furl = '/ibuy.html?itemid='.$item['itemid'];
			if(!empty($item['sid']))
				$furl = $furl.'&sid='.$item['sid'];
		}
		if($room['domain'] == 'yxwl') {	//易学yxwl
			$furl = '/classactive/bank.html';
		}
		$logo=empty($item['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$item['img'];
		?>
		<div class="zizhans">
			<div class="neiku" onmouseout="this.className='neiku'" onmouseover="this.className='lanku'">
			<?php if(empty($user)) { ?>
				<div class="lefke">
					<a href="javascript:void(0);" class="dologin" name="<?= $furl?>"><img src="<?= $logo?>" ></a>
				</div>
				<div class="rigsize">
					<a style="cursor: pointer;"  class="dologin" href="javascript:void(0);" name="<?= $furl?>">
						<span class="titke"><?= $item['iname']?></span>
					</a>

					<p class="kuanpa"><?= ssubstrch($item['isummary'],0,270) ?></p>

				</div>
				<?php if($item['fprice'] == 0) { ?>
				<a target="_blank">
				<input class="kaitongbtn dologin" type="submit" value="试听课程" name="<?= $furl?>">
				</a>
				<?php } else { ?>
				<a target="_blank">
				<input class="xuexionebtn dologin" type="submit" value="报名付费" name="<?= $furl?>">
				</a>
				<?php } ?>
			<?php } else { 
			?>
				<div class="lefke">
					<a href="<?= $furl?>"><img src="<?= $logo?>" ></a>
				</div>
				<div class="rigsize">
					<a style="cursor: pointer;" href="<?= $furl?>" >
						<span class="titke"><?= $item['iname']?></span>
					</a>

					<p class="kuanpa"><?= ssubstrch($item['isummary'],0,270) ?></p>

				</div>
				<?php if($user['groupid'] != 6){?>
					<?php if($item['fprice'] == 0) { ?>
					<a target="_blank">
					<input class="kaitongbtn" onclick="javascript:alert('对不起，您是教师账号，不允许进行此操作。');" type="submit" value="试听课程">
					</a>
					<?php } else { ?>
					<a target="_blank">
					<input class="xuexionebtn" onclick="javascript:alert('对不起，您是教师账号，不允许进行此操作。');" type="submit" value="报名付费">
					</a>
					<?php } ?>
				<?php } else { ?>
					<?php if($item['fprice'] == 0) { ?>
					<a target="_blank">
					<input class="kaitongbtn" onclick="location.href='<?= $furl?>'" type="submit" value="试听课程" name="<?= $furl?>">
					</a>
					<?php } else { ?>
					<a target="_blank">
					<input class="xuexionebtn" onclick="location.href='<?= $furl?>'" type="submit" value="报名付费" name="<?= $furl?>">
					</a>
					<?php } ?>

				<? } ?>

			<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
<?php 
	$i ++;
			}
}else{ ?>
<img src="http://static.ebanhui.com/ebh/tpl/default/images/wuzizhan.jpg" />
<?php } ?>

</div>
<div class="lefadlo">
<div class="sanad">
<img src="http://static.ebanhui.com/ebh/tpl/default/images/ad010411.jpg" />
</div>
</div>
</div>
</div>
<div style="clear: both"></div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript">
<!--
var curid = 0;
$(function(){
	$(".dologin").click(function(){
		if ($(this).attr("name") != '') {
			$.loginDialog($(this).attr("name"));
		}else{
			$.loginDialog();
		}
	});
	$(".sp_div").click(function(){
				var sp_id = $(this).attr("id");
				if(sp_id != "" && sp_id != undefined) {
					sp_id = sp_id.substring(3);
					if(sp_id != curid) {
						$(".sp_div").removeClass("leraten");
						$(this).addClass("leraten");
						$(".append_new").hide();
						$("#itempid_" + sp_id).show();
						curid = sp_id;
					}
				}
			});
});
//-->
</script>
<?php
    $this->display('common/footer');
?>