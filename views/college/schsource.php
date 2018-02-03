<style>
.schsourcecur a {
    border-bottom: solid 2px #5f8ef5;
    display: block;
    height: 43px;
}
.schsourcecur a span {
    color: #4c88ff;
    display: block;
}

.plabels ,.slabels{
    width: 100%;
    height: auto;
    background: #F6F6F6;
    float: left;
    display: block;
	margin-bottom:20px;
	line-height:40px;
}
.itempackage ,.itemsort {
    font-size: 15px;
    color: #666;
    margin: 0 15px;
    display: inline-block;
	float:left;
}
.itempackage:hover,.itemsort:hover,.pcur,.scur{
	color:#338bff;
}
.schitems{
	padding: 20px;
    width: 960px;
    height: auto;
    background-color: #fff;
}
.items .danke {
    width: 146px;
    float: left;
    position: relative;
    margin-top: 8px;
    display: inline;
}
.items .danke span{
	text-align:center;
	width:128px;
	display:block;
	line-height: 30px;
	margin-left: 10px;
}
</style>
<div class="kejian unopen" style="margin-top:0px; width:1000px; border:none;<?=empty($unopenarr)?'display:none':''?>">
	<div class="track_schsource">
		<div class="inner">
			<div class="view-port">
				<div class="ssslider-container slider-container" id="">
				<?php
					$idx = 0;
					$curp = 0;
					foreach($unopenarr as $sourceid=>$source){
				?>
					<div class="<?=($idx==0)?'schsourcecur':''?> schsourcetab item" sourceid="<?=$sourceid?>"><a href="javascript:void(0)"><span><?=$source[0]['name']?></span></a></div>


				<?php
						$idx++;
					}
				?>
				</div>
			</div>
		</div>

		<div class="pagination">
			<a href="#" class="prev disabled"></a>
			<a href="#" class="next disabled"></a>
		</div>
	</div>
	<div class="schitems">
		<div class="plabels"></div>
		<div class="slabels"></div>
		<div class="items"><ul></ul></div>
	</div>
	<div id="tempblocks" style="display:none">
	<?php
	$parr = array();
	$sarr = array();
	foreach($unopenarr as $sourceid=>$source){?>
		<a class="itempackage" sourceid="<?=$sourceid?>" pid="0">全部</a>
		<a class="itemsort" sourceid="<?=$sourceid?>" pid="0" sid="0">全部</a>
	<?php
		foreach($source as $item){
			$sid = $item['sid']?$item['sid']:0;
			$pid = $item['pid'];
			$buyfreeimg = $item['price']==0?'http://static.ebanhui.com/ebh/tpl/default/images/free-btn.png':'http://static.ebanhui.com/ebh/tpl/default/images/buy-btn.png';
			if(empty($parr[$pid])){
				$parr[$pid] = 1;
				?>
			<a class="itempackage" sourceid="<?=$sourceid?>" pid="<?=$pid?>"><?=$item['pname']?></a>
			<a class="itemsort" sourceid="<?=$sourceid?>" pid="<?=$pid?>" sid="0">全部</a>
			<?php
			}
			if(empty($sarr[$pid][$sid]) && $sid!=0){
				$sarr[$pid][$sid] = 1;
				?>
			<a class="itemsort" sourceid="<?=$sourceid?>" pid="<?=$pid?>" sid="<?=$sid?>"><?=$item['sname']?></a>
	<?php
			}?>

			<?php if($roominfo['template'] == 'plate'){//plate 未开通
					$img = empty($item['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg':$item['img'];
					$img = show_plate_course_cover($img);
			?>
			<li class="fl li1 sitem" sourceid="<?=$sourceid?>" pid="<?=$pid?>" sid="<?=$sid?>" style="margin-left:0px">
				<div class=" danke2s-1s">
					<a href="/courseinfo/<?=$item['itemid']?>.html" target="_blank" title="<?=$item['iname']?>" class="coursrtitle-1"><?=$item['iname']?></a>
					<div style="clear:both;"></div>
					<div class="showimg">
						<img src="<?=$img?>" width="212" height="125" border="0">
					</div>

					<div class="piaoyin" style="position:relative;top:1px;*top:30px;background:url(http://static.ebanhui.com/ebh/tpl/default/images/buy-black.png) right bottom no-repeat;">
						<a href="/courseinfo/<?=$item['itemid']?>.html" target="_blank" title="点击立即开通" class="tuslick"></a>
						<a class="btnxlick btn" href="javascript:void(0);" onclick="schpay(<?=$item['itemid']?>)" title="点击立即开通" itemid="<?=$item['itemid']?>"><img width="70" height="70" src="<?=$buyfreeimg?>"></a>
					</div>
				</div>
			</li>
			<?php } else {//其他,未开通
				$img = empty($item['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$item['img'];
			?>
			<li class="danke sitem" sourceid="<?=$sourceid?>" pid="<?=$pid?>" sid="<?=$sid?>" style="margin-left:11px; _margin-left:2px;height:225px;margin-right:9px;">
				<div class="danke2s"><span class="spne" style="height:25px;font-size:14px"><a href="/courseinfo/<?=$item['itemid']?>.html" target="_blank" title="<?=$item['iname']?>"><?=$item['iname']?></a></span>
				<div style="clear:both;"></div>
					<div class="showimg">
						<a href="/courseinfo/<?=$item['itemid']?>.html" target="_blank" title="点击立即开通"><img src="<?=$img?>" width="114" height="159" border="0"></a>
					</div>
					<div class="piaoyin" style="*top:30px;background:url(http://static.ebanhui.com/ebh/tpl/default/images/buy-black2.png)">
						<a href="/courseinfo/<?=$item['itemid']?>.html" target="_blank" title="点击立即开通" class="tuslick"></a>
						<a class="btnxlick btn" href="javascript:void(0);" onclick="schpay(<?=$item['itemid']?>)" title="点击立即开通" itemid="<?=$item['itemid']?>"><img width="70" height="70" src="<?=$buyfreeimg?>"></a>

					</div>
				</div>
			</li>
			<?php }?>
	<?php
		}
	}
	?>

	<?php
	if($roominfo['template'] == 'plate'){//plate已开通
		foreach($openarr as $sp){?>
		<div class="studycourse studycourse-2 sourceopenitem" style="margin-top:0px; width:1000px; border:none;">
			<div class="other_room_tit"><h2><?=$sp[0]['name']?></h2></div>
				<ul class="">
					<?php foreach($sp as $folder){
						$img = empty($folder['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg':$folder['img'];
						$img = show_plate_course_cover($img);
						?>
					<li class="fl" style="height:180px;">
						<div class=" danke2s-1s">
							<a href="/myroom/college/study/cwlist/<?=$folder['folderid']?>.html" title="<?=$folder['iname']?>" class="coursrtitle-1"><?=$folder['iname']?>
								<div class="bordershadow"></div></a>
							<a href="/myroom/college/study/cwlist/<?=$folder['folderid']?>.html" title="<?=$folder['iname']?>"><img src="<?=$img?>" width="212" height="125" border="0"></a>

						</div>
					</li>
					<?php }?>
				</ul>
		</div>
	<?php	}
	} else {	//其他已开通
        foreach($openarr as $sp){
            ?>
            <div class="kejian sourceopenitem" style="margin-top:0px; width:1000px; border:none;">
                <div class="other_room_tit"><h2><?=$sp[0]['name']?></h2></div>
                <ul class="liss">
                    <?php foreach($sp as $folder){
                        $img = empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img'];
                        ?>
                        <li class="danke" style="margin-left:11px; _margin-left:2px;height:255px;*height:250px; text-align:left;margin-right:9px;">
                            <div class="danke2s" style="height:auto;"><span class="spne" style="height:25px;font-size:14px; line-height:30px;"><a href="/myroom/college/study/cwlist/<?=$folder['folderid']?>.html" title="<?=$folder['iname']?>"><?=$folder['iname']?></a></span>
                                <div class="clear"></div>
                                <div class="showimg"><a href="/myroom/college/study/cwlist/<?=$folder['folderid']?>.html" title="<?=$folder['iname']?>"><img src="<?=$img?>" width="114" height="159" border="0"></a></div>
                                <div style="clear:both;"></div>

                            </div>

                        </li>
                    <?php }?>
                </ul>
            </div>
            <?php
        }
	}
	?>
	</div>
</div>
<script>
var sstrack = $(".ssslider-container").silverTrack();
var thessparent = sstrack.container.parents(".track_schsource");

// 左右箭头
sstrack.install(new SilverTrack.Plugins.Navigator({
  prev: $("a.prev", thessparent),
  next: $("a.next", thessparent)
}));
sstrack.start();
$('.schsourcetab').click(function(){
	$('.schsourcecur').removeClass('schsourcecur');
	$(this).addClass('schsourcecur');
	var sourceid = $(this).attr('sourceid');
	showsp(sourceid);
	//判断是否为函数
    try {
        if(typeof resetheight === "function") {
        	resetheight();
        } else { //不是函数
        	top.resetmain();
        }
    } catch(e) {}

});
$('.itempackage').click(function(){
	var sourceid = $(this).attr('sourceid');
	var pid = $(this).attr('pid');
	showsort(sourceid,pid);
})
$('.itemsort').click(function(){
	var sourceid = $(this).attr('sourceid');
	var pid = $(this).attr('pid');
	var sid = $(this).attr('sid');
	showitem(sourceid,pid,sid);
})
$(function(){
	$('.itempackage').appendTo($('.plabels'));
	$('.itemsort').appendTo($('.slabels'));
	$('.sitem').appendTo($('.items ul'));
	<?php if($roominfo['template'] == 'plate'){?>
	$('.study .studycourse:last').after($('.sourceopenitem'));
	// $('.sourceopenitem').appendTo($('.studycourse:first'));
	<?php }else {?>
	$('.sourceopenitem').appendTo($('.study_bottom'));
	<?php }?>
	var sourceid = $('.schsourcecur').attr('sourceid');
	showsp(sourceid);
});
function showsp(sourceid){
	$('.itempackage').hide();
	$('.itempackage[sourceid='+sourceid+']').show();

	var pid = $('.itempackage:visible:first').attr('pid');
	showsort(sourceid,pid);

}
function showsort(sourceid,pid){
	$('.pcur').removeClass('pcur');
	$('.itempackage[pid='+pid+']').addClass('pcur');

	if(pid == 0){
		$('.itemsort').hide();
		$('.itemsort[sourceid='+sourceid+'][sid!=0]').show();
		$('.itemsort[sourceid='+sourceid+'][sid=0][pid=0]').show();
	} else {
		$('.itemsort').hide();
		$('.itemsort[pid='+pid+']').show();
	}
	var sid = $('.itemsort:visible:first').attr('sid');
	showitem(sourceid,pid,sid);
}
function showitem(sourceid,pid,sid){
	$('.scur').removeClass('scur');
	$('.itemsort[pid='+pid+'][sid='+sid+']').addClass('scur');
	$('.sitem').hide();
	var pstr = pid==0?'':('[pid='+pid+']');
	var sstr = sid==0?'':('[sid='+sid+']');
	$('.sitem[sourceid='+sourceid+']'+pstr+sstr).show();
 
	//判断是否为函数
    try {
        if(typeof resetheight === "function") {
        	resetheight();
        } else { //不是函数
        	top.resetmain();
        }
    } catch(e) {}
	
}
function schpay(itemid){
	var payurl = '/ibuy.html?itemid='+itemid;
	var price;
	var item;
	$.ajax({
		url:'/college/schsource/getitem.html',
		data:{'itemid':itemid},
		dataType:'json',
		async:false,
		success:function(data){
			if(data){
				item = data;
				price = item.price;
				item.showimg = item.img;
				<?php if($roominfo['template'] == 'plate'){?>
				if(!item.img){
					item.showimg = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg';
				} else {
					item.showimg = item.img.replace(/folderimg(\/\d{1,2}\.jpg)/,'folderimgs/$1');
					item.showimg = item.showimg.replace('folderimg/guwen.jpg','folderimgs/guwen.jpg');
				}
				<?php } else {?>
				if(!item.img){
					item.img = 'http://static.ebanhui.com/ebh/images/nopic.jpg';
				}
				<?php }?>
			}
		}
	})
	if(item){
		if(price == 0)
			buyFreeItem(item);
		else
			window.open(payurl);
	}
}
</script>