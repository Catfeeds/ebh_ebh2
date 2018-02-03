<?php $this->display('troom/page_header'); ?>
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
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
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


</style>
<link type="text/css" href="/static/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
	<div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/statisticanalysis') ?>">统计分析</a> > <a href="<?= geturl('troom/tastulog') ?>">学生监察</a> > 答疑记录 > <?= $membername?>
		<div class="diles">
				<?php
					$q= empty($q)?'':$q;
					if(!empty($q)){
						$stylestr = 'style="color:#000"';
					}else{
						$stylestr = "";
					}
				?>
			<input name="search" <?=$stylestr?> class="newsou" id="search" value="<?= $q ?>" type="text" />
			<input id="searchbutton" name="searchbutton" type="button" class="soulico" value="">
		</div>
	</div>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">

		<div class="weaktil" style=" margin-bottom:10px;">
			<ul >
				<?php $uid=$this->uri->itemid; ?>
				<li ><a href="<?= geturl('troom/statisticanalysis/scorefind/'.$uid) ?>"><span>作业记录</span></a></li>
				<li ><a href="<?= geturl('troom/statisticanalysis/question/'.$uid) ?>"><span class="datek" >答疑记录</span></a></li>
				<li ><a href="<?= geturl('troom/statisticanalysis/studylogs/'.$uid) ?>"><span>学习记录</span></a></li>
				<li ><a href="<?= geturl('troom/statisticanalysis/errorlogs/'.$uid) ?>"><span>错题集</span></a></li>
			</ul>
		</div>

	<table  width="100%" class="datatab" style="border:none;">
			
			<tbody>

						<?php if(empty($asks)) { ?>
			<tr><div style="clear:both;padding-top:10px;text-align: center;">暂无问题记录</div></tr>
						<?php } else { ?>
		
				<?php foreach($asks as $akey=>$avalue) { ?>
				<tr>
				<?php if($akey == 0){ ?>
				<td style="border-top:0px;margin-top:0px;">
				<?php }else{ ?>
				<td>
				<?php } ?>
				<?php 
				//var_dump($avalue);
					if(!empty($avalue['face']))
						$face = getthumb($avalue['face'],'50_50');
					else{
						if($avalue['sex']==1){
							if($avalue['groupid']==5){
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
							}else{
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
							}
						}else{
							if($avalue['groupid']==5){
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
							}else{
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
							}
						}
					
						$face = getthumb($defaulturl,'50_50');
					} 
				?>	
				<?php $name=empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>
				<div style="float:left;margin-right:15px;"><a href="myask.html?aq=<?= $name?>"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>" src="<?=$face?>" /></a></div>
					<div style="float:left;width:670px;font-family:Microsoft YaHei;">
						<p style="width:550px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
							<?php if(!empty($requiredTeacher) && ($avalue['answered']==1) ){ ?>
								<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>
							<?php }else if(empty($requiredTeacher) && $avalue['status']==1){?>
								<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>
							<?php }?>
							<a  href="<?= geturl('troom/myask/'.$avalue['qid']) ?>" style="color:#777;font-weight:bold;"><?= $avalue['title'] ?></a>
						</p>
						<span style="width:55px;text-align:center;float:right;line-height:2;background:url(http://static.ebanhui.com/ebh/tpl/default/images/modu.png) no-repeat 0px 28px;">回答数<br/><?= $avalue['answercount'] ?></span>
						<div style="float:left;width:550px;">
						<span style="width:180px;float:left;"><?= Date('Y-m-d H:i:s',$avalue['dateline']) ?></span>
						<span class="huirenw" style="width:100px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
						<span style="width:200px;float:left;background:url(http://static.ebanhui.com/ebh/tpl/default/images/label.png) no-repeat;padding-left:24px;"><?= $avalue['foldername'] ?></span>
					</div>
				</div>

			</td>
				</tr>
					   <?php } ?>

						<?php } ?>

		</tbody>
		</table>
				
</div>
<?= $pagestr ?>
<script type="text/javascript">
var tip = '请输入答疑名称';
$(function(){
	initsearch('search',tip);
	$('#searchbutton').click(function(){
		if($("#search").val()=='请输入答疑名称'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
		if(searchvalue=='请输入答疑名称'){
			searchvalue='';
		}
		var href = '<?= geturl('troom/statisticanalysis/question/'.$uid)?>?q='+searchvalue;
		
		location.href = href ;
	});

});
</script>

<?php $this->display('troom/page_footer'); ?>