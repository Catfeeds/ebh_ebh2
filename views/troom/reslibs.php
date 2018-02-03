<?php $this->display('troom/page_header'); ?>
<style>
.myxuan {
	margin-top:15px;
}
.myxuan li {
	width:229px;
	height:229px;
	float:left;
	margin-bottom:20px;

}
.myxuan li a {
	width:227px;
	height:227px;
	display:block;
	border:dashed 1px #d8d8d8;
}
.myxuan a.mytiku {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/xiaoxue.jpg) no-repeat center;
}
.myxuan a.mytiku:hover {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/xiaoxue1.jpg) no-repeat center;
	border: 1px dashed #00b6ee;
}
.myxuan a.comtiku{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/chuzhong.jpg) no-repeat center;
}
.myxuan a.myxuex{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/gaozhong.jpg) no-repeat center;
}
.myxuan a.comtiku:hover {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/chuzhong1.jpg) no-repeat center;
	border: 1px dashed #00b6ee;
}
.myxuan a.myxuex:hover {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/gaozhong1.jpg) no-repeat center;
	border: 1px dashed #00b6ee;
}
.fotwaim {
	background:#fff;
	padding-top:25px;
	width:788px;
	float:left;
}
.fotwaim li.kemule {
	width:157px;
	height:160px;
	float:left;
}
.fotwaim li.kemule img {
	float:left;
	margin-left:15px;
	display:inline;
}
.fotwaim li.kemule span {
	width:148px;
	float:left;
	text-align:center;
	font-size:14px;
	color:#414141;
	margin-top:10px;
}
.reblue{
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/xiaoxue1.jpg) no-repeat center;
	border: 1px dashed #00b6ee;
}
.zhongblue {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/chuzhong1.jpg) no-repeat center;
	border: 1px dashed #00b6ee;
}
.gaoblue {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/gaozhong1.jpg) no-repeat center;
	border: 1px dashed #00b6ee;
}
.work_menuss{background:url(http://static.ebanhui.com/ebh/tpl/default/images/workmenubg_003.jpg); margin-top:0; padding-top:0;}
</style>
<div class="ter_tit">
	当前位置 > 精品试题库
</div>
	<div class="lefrig" style="height:850px;">
		<div class="workol" style=" margin-top:15px;">
	<?php if($roominfo['grade'] == 1){ ?>
		<div class="fotwaim" id="div1">
			<ul>
			<?php foreach($primarySchool as $primary){ ?>
				<li class="kemule">
					<a href="<?= geturl('troom/reslibs/reslist-0-0-0-1-'.$primary['gid'])?>" style="cursor:pointer;display: block; height: 120px;width: 148px;text-decoration:none;">
					<?php $photo1=empty($primary['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/zonghe.jpg':$primary['img'] ?>
					<img src="http://static.ebanhui.com/ebh<?= $photo1?>" />
					<span><?= $primary['groupname']?>(<?= $primary['lnum']?>)</span>
					</a>
				</li>
			<?php } ?>
			</ul>
		</div>
	<?php }elseif($roominfo['grade'] == 7){ ?>
		<div class="fotwaim" id="div2">
			<ul>
			<?php foreach($middleSchool as $middle){ ?>
				<li class="kemule">
					<a href="<?= geturl('troom/reslibs/reslist-0-0-0-7-'.$middle['gid'])?>" style="cursor:pointer;display: block; height: 120px;width: 148px;text-decoration:none;">
					<?php $photo2=empty($middle['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/zonghe.jpg':$middle['img']?>
					<img src="http://static.ebanhui.com/ebh<?= $photo2?>" />
					<span><?= $middle['groupname']?>(<?= $middle['lnum']?>)</span>
					</a>
				</li>
			<?php } ?>
			</ul>
		</div>
	<?php }elseif($roominfo['grade'] == 10){ ?>
		<div class="fotwaim" id="div3">
			<ul>
			<?php foreach($highSchool as $high){ ?>
				<li class="kemule">
					<a href="<?= geturl('troom/reslibs/reslist-0-0-0-10-'.$high['gid'])?>" style="cursor:pointer;display: block; height: 120px;width: 148px;text-decoration:none;">
					<?php $photo3=empty($high['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/zonghe.jpg':$high['img']?>
					<img src="http://static.ebanhui.com/ebh<?= $photo3?>" />
					<span><?= $high['groupname']?>(<?= $high['lnum']?>)</span>
					</a>
				</li>
			<?php } ?>
			</ul>
		</div>
	<?php }else{ ?>
			<div class="work_menuss" style="border:0px;">
				<ul>
					<li class="workcurrent" style=" cursor: pointer;"><a ><span>小学题库</span></a></li>
					<li style=" cursor: pointer;"><a ><span>中学题库</span></a></li>
					<li style=" cursor: pointer;"><a ><span>高中题库</span></a></li>
				</ul>
			</div>

			<div class="fotwaim" id="div1">
				<ul>
				<?php foreach($primarySchool as $primary){ ?>
					<li class="kemule">
						<a href="<?= geturl('troom/reslibs/reslist-0-0-0-1-'.$primary['gid'])?>" style="cursor:pointer;display: block; height: 120px;width: 148px;text-decoration:none;">
						<?php $photo1=empty($primary['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/zonghe.jpg':$primary['img'] ?>
						<img src="http://static.ebanhui.com/ebh<?= $photo1?>" />
						<span><?= $primary['groupname']?>(<?= $primary['lnum']?>)</span>
						</a>
					</li>
				<?php } ?>
				</ul>
			</div>
			<div class="fotwaim" id="div2" style="display:none;">
				<ul>
				<?php foreach($middleSchool as $middle){ ?>
					<li class="kemule">
						<a href="<?= geturl('troom/reslibs/reslist-0-0-0-7-'.$middle['gid'])?>" style="cursor:pointer;display: block; height: 120px;width: 148px;text-decoration:none;">
						<?php $photo2=empty($middle['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/zonghe.jpg':$middle['img']?>
						<img src="http://static.ebanhui.com/ebh<?= $photo2?>" />
						<span><?= $middle['groupname']?>(<?= $middle['lnum']?>)</span>
						</a>
					</li>
				<?php } ?>
				</ul>
			</div>
			<div class="fotwaim" id="div3" style="display:none;">
				<ul>
				<?php foreach($highSchool as $high){ ?>
					<li class="kemule">
						<a href="<?= geturl('troom/reslibs/reslist-0-0-0-10-'.$high['gid'])?>" style="cursor:pointer;display: block; height: 120px;width: 148px;text-decoration:none;">
						<?php $photo3=empty($high['img'])?'http://static.ebanhui.com/ebh/tpl/default/images/zonghe.jpg':$high['img']?>
						<img src="http://static.ebanhui.com/ebh<?= $photo3?>" />
						<span><?= $high['groupname']?>(<?= $high['lnum']?>)</span>
						</a>
					</li>
				<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>
</div>

<script type="text/javascript">
<!--
    $(".work_menuss li").each(function(i) {
        $(this).click(function () {		 
            $(".work_menuss li").removeClass("workcurrent");
            $(this).addClass("workcurrent");
            $("#div1").hide();
            $("#div2").hide();
            $("#div3").hide();
            $("#div"+(i+1)).show();
        })
    });	 
//-->
</script>

<?php $this->display('troom/page_footer'); ?>