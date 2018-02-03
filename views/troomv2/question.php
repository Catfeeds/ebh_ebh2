<?php $this->display('troomv2/room_header'); ?>
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
.lefrigs{
	margin:0 auto;
	margin-top:10px;
	width:1000px;
}
.diles{
	top:10px;
}
</style>
<!-- <div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">
<div class="esukangs">
<a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="学生监察">学生监察</a>
<a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a>
</div>
</div> -->
	<div class="lefrigs"><div class="lefrig">
<?php 
$this->assign('data_index',2);
$this->display('troomv2/data_menu');
?>

	<table  width="100%" class="datatab" style="border:none;">
			
			<tbody>

						<?php if(empty($asks)) { ?>
			<tr><div class="weusaz"><img style="float:left;" src="http://static.ebanhui.com/ebh/tpl/troomv2/images/wureazar.jpg" /><span class="lisretdfe">暂无问题记录...</span></div></tr>
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
				<div style="float:left;margin-right:15px;width:50px;height:50px;"><a href="myask.html?aq=<?= $name?>"><img class="imgyuan" title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>" src="<?=$face?>" /></a></div>
					<div style="float:left;width:870px;font-family:Microsoft YaHei;">
						<p style="width:750px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
							<?php if(!empty($requiredTeacher) && ($avalue['answered']==1) ){ ?>
								<img src="http:/    /static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>
							<?php }else if(empty($requiredTeacher) && $avalue['status']==1){?>
								<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>
							<?php }?>
							<a href="/troomv2/myask/<?php echo $avalue['qid']?>.html" style="color:#777;font-weight:bold;" target="_blank"><?= $avalue['title'] ?></a>
						</p>
						<span style="width:55px;text-align:center;float:right;line-height:2;">回答数<br/><?= $avalue['answercount'] ?>/<?=$avalue['viewnum']?></span>
						<div style="float:left;width:750px;">
						<span style="width:180px;float:left;"><?= Date('Y-m-d H:i:s',$avalue['dateline']) ?></span>
						<span class="huirenw" style="width:200px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
						<span style="width:300px;float:left;background:url(http://static.ebanhui.com/ebh/tpl/default/images/label.png) no-repeat;padding-left:24px;"><?= $avalue['foldername'] ?></span>
					</div>
				</div>

			</td>
				</tr>
					   <?php } ?>

						<?php } ?>

		</tbody>
		</table>
		<?= $pagestr ?>		
</div>
</div>
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
		var href = '<?= geturl('troomv2/statisticanalysis/question/'.$uid)?>?q='+searchvalue;
		
		location.href = href ;
	});

});
$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>

<?php $this->display('troomv2/page_footer'); ?>