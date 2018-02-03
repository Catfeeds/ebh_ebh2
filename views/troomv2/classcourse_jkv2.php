<?php $this->display('troomv2/room_header');?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/troomv2.js"></script>
<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
.tabhead th{
	color:#333;
	height:25px;
	padding-top:20px;
	border-bottom:1px solid #fff;
}
.lefrig{
	float:none;
	margin-top:10px;
}
.yixuexifa{
	height:85px;
	border-bottom:none;
}
.pjxxsc{
	height:60px;
}
a.mulubgbtns{
	margin-top:0px;
}
</style>
<div class="lefrig">
	<h1 class="tkfktitle"><?=$course['title']?></h1>
	<div class="classboxmore" style="border-bottom:none; height:80px;">
		<div class="touxiangxmfa">
			<div class="touxiangxm">
                <?php
                if($course['sex'] == 1)
                    $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                else
                    $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                $face = empty($course['face']) ? $defaulturl:$course['face'];
                $face = str_replace('.jpg','_50_50.jpg',$face);
				$cwlength = ceil($course['cwlength']/60);
                ?>
				<img class="images" src="<?php echo $face?>">
				<span class=""><?= empty($course['realname'])?$course['username']:$course['realname'] ?></span>
			</div>
			<div>
			<p class="lsfbsj">
			<span class="fbsj fbsj1s" style="<?=(!empty($course['truedateline']) || !empty($course['endat']))?'':'line-height:50px'?>">上传时间：<?=date("Y-m-d H:i",$course['dateline'])?></span>
			<span class="fbsj"> <span class="fbsj2"></span><?= $course['viewnum']?></span>
			<span class="fbsj">时长:<?=$cwlength?>分钟</span>
			</p>
			
			<p class="kkjssj">
			<?=!empty($course['truedateline'])?'开课：'.date('Y-m-d H:i',$course['truedateline']):''?> <?=!empty($course['truedateline'])&&!empty($course['endat'])?'&nbsp;':''?> <?=!empty($course['endat'])?'结束：'.date('Y-m-d H:i',$course['endat']):''?>
			</p>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div class="yixuexifa">
			<p class="sexqueue0" style="margin-left:130px;margin-right:15px;">
				<span class="sexqueuefull0" style="width:<?=empty($countset['userscount'])?0:ceil($countset['studycount']/$countset['userscount']*100)?>%;"></span>
			</p>
			<div style="float:left; display:inline;">
				<p class="yixuexi">已学<?=$countset['studycount']?>/<?=$countset['userscount']?></p>
				<p class="yjxxbfb"><?=empty($countset['userscount'])?0:ceil($countset['studycount']/$countset['userscount']*100)?>%</p>
			</div>
			<div class="pjxxsc">
				<p class="yixuexi">平均学习时长</p>
				<p class="yjxxbfb"><?=$countset['ltimeavg']?><span style="font-size:14px;">分钟</span></p>
			</div>
		</div>
	</div>	
	<div  style="clear:both;"></div>
	<div class="waitite1s">
		<div class="work_mes" >
			<ul style="width:555px; float:left">
<!--				<li class="workcurrent"><a href="javascript:;">全部</a></li>-->
				<li class="<?php if($type==0){echo 'workcurrent';} ?>"  value="<?php echo !empty($type)?$type:0?>"><a href="/troomv2/classcourse/jkv2-0-0-0-<?php echo $cwid ?>.html?type=0<?php if(!empty($get['classid'])){echo '&classid='.intval($get['classid']);}?>">已学习</a></li>
				<li class="<?php if($type==1){echo 'workcurrent';} ?>"  value="<?php echo !empty($type)?$type:0?>"><a href="/troomv2/classcourse/jkv2-0-0-0-<?php echo $cwid ?>.html?type=1<?php if(!empty($get['classid'])){echo '&classid='.intval($get['classid']);}?>">未学习</a></li>
			</ul>
			<!--<a class="mulubgbtns" href="javascript:;" onclick="location.reload()" style="margin-top:6px;">刷新</a>-->
<!--			<a class="mulubgbtns" target="_blank" href="/troomv2/classcourse/jkexcel-0-0-0---><?//= $course['cwid'];?><!--.html" style="margin-top:6px;">导出</a>-->
		</div>
		<div class="diles" style="width:440px">
				<?php
					$q= empty($q)?'':$q;
					if(!empty($q)){
						$stylestr = 'style="color:#000"';
					}else{
						$stylestr = "";
					}
				?>
			<a href="/troomv2/classcourse/jkexcel-0-0-0-<?= $course['cwid'];?>.html" class="mulubgbtns" target="_blank">导 出</a>
			<a href="javascript:location.reload();" class="mulubgbtns">刷 新</a>
			<input name="search" <?=$stylestr?> class="newsou" id="search" value="<?= $q ?>" type="text" />
			<input id="searchbutton" name="searchbutton" type="button" class="soulico" value="">
		</div>
	</div>
		

<table class="datatab" width="100%" style="border:none;">
<thead class="tabhead">
<tr>

<th style="text-align:left;padding-left:60px;">个人信息</th>
<th>首次学习</th>
<th>最后学习</th>
<th>学习次数<!-- <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xjico.png" style="padding-left:3px;"/> --></th>
<th>平均时长<!-- <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/ssico.png" style="padding-left:3px;"/> --></th>
<th>累计时长<!-- <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/ssico.png" style="padding-left:3px;"/> --></th>
</tr>
</thead>
<tbody>
	
		
	<?php if(!empty($myuserlist)) { ?>
		<?php foreach($myuserlist as $k=>$myuser){
			if(!isset($myuser['username'])){
				continue;
			}?>
		<tr>
			<td width="28%">
				<div style="float:left;margin-right:15px;">
					<a href="javascript:;"><img src="<?=getavater($myuser,'50_50')?>" title="<?=$myuser['realname']?>" style="width:40px;height:40px; border-radius:20px;"></a>
				</div>
				<div style="width:180px;float:left;">
					<span class="renming"><?=$myuser['realname']?></span>
					<span class="<?=($myuser['sex']==1)?"xingbie":"xingbie1"?>"></span>
					<div style="clear:both;"></div>
					<span class="renming1"><?=$myuser['username']?></span>
				</div>
			</td>
			<td style="text-align: center;" width="15%"><?= !empty($myuser['startdate'])?date('Y-m-d H:i:s',$myuser['startdate']):'--' ?></td>
			<td style="text-align: center;" width="15%"><?= !empty($myuser['lastdate'])?date('Y-m-d H:i:s',$myuser['lastdate']):'--' ?></td>
			<td width="14%" style="text-align:center;"><?= !empty($myuser['sumtimes'])?$myuser['sumtimes']:'--' ?></td>
			<td width="14%" style="text-align:center;"><?= !empty($myuser['sumltimes'])?secondToStr($myuser['sumltimes']/$myuser['sumtimes']):'--'?></td>
			<td width="14%" style="text-align:center;"><?= !empty($myuser['sumltimes'])?secondToStr($myuser['sumltimes']):'--'?></td>
		</tr>
		<?php } ?>
		
	<?php } else { ?>
		<tr><td colspan="6" align="center" style="border-bottom:none;"><div class="nodata"></div></td></tr>
	<?php } ?>
</tbody>
</table>
</div>

</body>
</html>
<script type="text/javascript">
var tip='请输入学生姓名';
$(function(){
	initsearch('search',tip);
    var type = $('.workcurrent').val()
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troomv2/classcourse/jkv2-0-0-0-'.$cwid) ?>?type='+type+'<?php if(!empty($get['classid'])){echo '&classid='.intval($get['classid']);}?>';
		if($("#search").val()=='请输入学生姓名'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入学生姓名'){
			searchvalue='';
		}

		location.href = href+"&q="+searchvalue;
	});

});
$(function(){
    $('.datatab tr:last td').css('border-bottom','none');
});

</script>
