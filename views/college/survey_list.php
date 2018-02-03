<?php $this->display('college/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151123001"/>
<style type="text/css">
	.questionnairename{
		font-size: 16px;
		color: #000000 !important;
		font-weight: bold;
	}
	.questypes{
		background: #FFFFFF;
		padding: 15px 15px 15px 0;
	}
	.questypes li{
		float: left;
		margin: 0 15px;
	}
	.questypes li a{
		padding: 5px 8px;
	}
	.selectqus{
		background: #5E96F5;
		color: #FFFFFF !important;
		border-radius: 3px;
	}
	.datatab{
		border:none;
	}
    .datatab tbody tr:first-child td{
        border-top: 0 none;
    }
    .datatab tbody tr:last-child td{
        border-bottom: 0 none;
    }
</style>

<?php if (empty($folder)){?>
<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
	<ul>
		<li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;"><span>调查问卷</span></a></li>
	</ul>
</div>
<?php }?>

<div class="lefrig clearfix" style="background:#fff;">
	<?php if(!empty($folder)){
		$this->assign('selidx', 6);
		$this->display('college/course_nav');
	}
	?>
	<?php if(empty($folder)){?>
	<ul class="questypes">
		<li><a class="selectqusbtn <?php if(empty($showlist)){echo 'selectqus';}?>" showlist="0" href="javascript:void(0)">全部</a></li>
		<li><a class="selectqusbtn <?php if(!empty($showlist) && $showlist == 1){echo 'selectqus';}?>" showlist="1" href="javascript:void(0)">未开始</a></li>
		<li><a class="selectqusbtn <?php if(!empty($showlist) && $showlist == 2){echo 'selectqus';}?>" showlist="2" href="javascript:void(0)">进行中</a></li>
		<li><a class="selectqusbtn <?php if(!empty($showlist) && $showlist == 3){echo 'selectqus';}?>" showlist="3" href="javascript:void(0)">已过期</a></li>
		<li style="float: right;margin-right: 50px;">
			<input style="font-size: 12px;color: rgb(50, 50, 50);"  name="txtname" class="newsou" id="searchqsurvey" value="<?= isset($q) ? $q : '';?>" type="text" />
			<input type="button" class="soulico" value="" id="ser1">
		</li>
	</ul>
	<?php }?>
	<?php if(!empty($surveylist)){?>
		<table class="datatab" width="100%">
			<tbody>
			<?php foreach($surveylist as $survey){?>
				<tr>
					<td width="450" style="word-break: break-all; word-wrap:break-word;padding-left: 80px;background: url(http://static.ebanhui.com/ebh/tpl/2016/images/questionnaire.png) no-repeat 25px 10px;">
						<?php if(empty($survey['aid']) && (empty($survey['startdate']) || $survey['startdate'] < SYSTIME) && (empty($survey['enddate']) || $survey['enddate'] > SYSTIME)){?>
							<a href="/college/survey/fill/<?=$survey['sid']?>.html" target="_blank" class="questionnairename">
						<?php }else{?>
							<a href="/college/survey/answer/<?=$survey['sid']?>.html" target="_blank" class="questionnairename">
						<?php }?>
								<?=strip_tags($survey['title'])?>
							</a>
						<p style="margin-top: 15px;font-size: 12px;">关联课件：
                            <?php if(!empty($survey['cwid']) && !empty($survey['cwname'])){?>
							    <a href="/myroom/mycourse/<?=$survey['cwid']?>.html" style="color: #6FACE8;" target="_blank"><?=$survey['cwname']?></a>
							<?php }else{?>
							    <span style="color: #999;">暂无课件</span>
                            <?php }?>
						</p>
					</td>
					<td width="341" style="font-size: 14px;">有效期：
						<?=empty($survey['startdate'])?'':date('Y-m-d H:i',$survey['startdate'])?>
						<?=empty($survey['enddate'])?'':' 至 '.date('Y-m-d H:i',$survey['enddate'])?>	
					</td>
					<td width="161" align="center" valign="middle">
						<?php if(empty($survey['aid']) && ($survey['startdate'] <= SYSTIME) && (($survey['enddate'] >= SYSTIME) || $survey['enddate']==0)){?>
							<a class="surveyBtn" href="/college/survey/fill/<?=$survey['sid']?>.html" target="_blank">参与调查</a>
						<?php }else{?>
							<a class="surveyBtn" href="/college/survey/answer/<?=$survey['sid']?>.html" target="_blank">查看详情</a>
						<?php }?>
					</td>
				
				</tr>
			<?php }?>
	
			</tbody>
		</table>
	<?php } else {?>
		<div class="nodata"></div>
	<?php }?>
	<?=$pagestr?>
</div>

<script type="text/javascript">
var searchtext = "请输入关键字";
$(function() {
	initsearch("title",searchtext);
	$("#ser").click(function(){
       var title = $("#title").val();
       var showlist = $(".selectqus").attr("showlist");
       if(title == searchtext){
       		title = "";
       }
       var url = '<?= geturl('college/survey/surveylist') ?>' + '?q='+title;
	   <?php if(!empty($folder)){
			$itemid = $this->input->get('itemid');?>
		url += '&folderid=<?=$folder['folderid']?>';
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
	   <?php }?>
	   url += '&showlist='+showlist+'';
	   window.location.href = url;
	});
	
	initsearch("searchqsurvey",searchtext);
	
	$("#ser1").click(function(){
       var searchqsurvey = $("#searchqsurvey").val();
       var showlist = $(".selectqus").attr("showlist");
       if(searchqsurvey == searchtext){
       		searchqsurvey = "";
       }
       var url = '<?= geturl('college/survey/surveylist') ?>' + '?q='+searchqsurvey;
	   <?php if(!empty($folder)){
			$itemid = $this->input->get('itemid');?>
		url += '&folderid=<?=$folder['folderid']?>';
		url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
	   <?php }?>
	   url += '&showlist='+showlist+'';
	   window.location.href = url;
	});
	
	
	
	
	$(".selectqusbtn").click(function(){
		var len = $(".selectqusbtn").length;
		for(var i=0;i<len;i++){
			$($(".selectqusbtn")[i]).removeClass("selectqus");
		}
		$(this).addClass("selectqus");
		var showlist = $(this).attr('showlist');
		var q = $("#searchqsurvey").val();
		if(q == "请输入关键字"){
			q = "";
		}
		showlist = '<?= geturl('college/survey/surveylist') ?>' + '?showlist='+showlist;
		showlist += '&q='+q+'';
		$(this).attr("href",showlist);
	});
	
	var haveselectqus;
	$(".selectqusbtn").hover(function(){
		if($(this).hasClass("selectqus")){
			haveselectqus = true;
		}else{
			haveselectqus = false;
		}
		$(this).addClass("selectqus");
	},function(){
		if(!haveselectqus){
			$(this).removeClass("selectqus");
		}
	});
	
});

</script>
<?php $this->display('myroom/page_footer'); ?>