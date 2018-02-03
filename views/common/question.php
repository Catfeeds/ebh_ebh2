<?php
$this->display('common/header');
?>
<?php 
	$gradelist = !empty($gradelist)?$gradelist:array();
	$curchildcatlist = !empty($curchildcatlist)?$curchildcatlist:array();
	$keyword = $this->input->get('keyword');
	$attr0 = $this->uri->uri_attr(0);
	$attr1 = $this->uri->uri_attr(1);
	$attr2 = $this->uri->uri_attr(2);
	$sortmode = $this->uri->uri_sortmode();
	$viewmode = $this->uri->uri_viewmode();
	$user = Ebh::app()->user->getloginuser();
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/yinan.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
</head>
<body>
<div class="toptitnew"><a href="/yun1.html">云教学平台</a> > 互动答疑</div>
<div class="waimin">
	<div class="lefcaid">
		
		<h2 class="topfen">全部问题分类</h2>
		<ul>
		<?php
			foreach ($catlist as $ckey => $cat) {
				$catid=$cat['pcat']['catid'];
		?>
		<li class="dalihui">

			<h2 class="teach" ><a  href="<?= geturl('question-1-0-0-'.$catid.'-0')?>"><?= $cat['pcat']['name']?></a></h2>
				<?php foreach($cat['childlist'] as $child){ 
						if($child['catid']==$curcatid){ ?>	
							<a href="<?= geturl('question-1-0-0-'.$catid.'-'.$child['catid'])?>" class="xuanzhong"><?= $child['name']?></a>
						<?php }else{ ?>
							<a href="<?= geturl('question-1-0-0-'.$catid.'-'.$child['catid'])?>"><?= $child['name']?></a>
						<?php }?>
					|
				<?php } ?>
			</li>
			<?php } ?>
		</ul>

		<!-- 广告写死 -->
 		<div class="adlefot">
			<?php  if(!empty($user)){ ?>
			<a href="<?= geturl('member/myask/addquestion')?>"></a>
			<?php }else{ ?>
			<a class="dialogLogin" name='<?= geturl('member/myask/addquestion')?>' href="javascript:void(0);"></a>
			<?php } ?>
		</div>
						<!-- == -->
	<div class="xuere" style="float:left;width:218px;overflow:hidden;height:auto;border: 1px solid #e3e3e3;margin-top:18px;margin-bottom:6px;">
		<h2 class="htongtou" style="color:#797979">精品答疑</h2>
		<ul style="border:0">
		<?php foreach ($qWithBest as $qkey => $qvalue) {?>
			<li class="kaiptl" >
			  <span class="liebiao chengcolor"><?=(1+$qkey)?></span>
			  <a  target="_blank" title="<?=$qvalue['title']?>" href="/question/<?=$qvalue['qid']?>.html"><?=ssubstrch($qvalue['title'],0,25)?></a>
			</li>
		<?php }?>
		</ul>
	</div>
	<!-- === -->
		<!-- 广告后台可传 -->
		<?php if(!empty($leftAds)){?>
			<?php foreach ($leftAds as $adk => $adv) {?>
				<?php $leftadurl = empty($adv['linkurl'])?"#":$adv['linkurl'];?>
				<div style="width:220px;height:211px;float:left;margin-top:10px">
					<a href="<?=$leftadurl?>"><img width=218px height=211px src="<?=$adv['thumb']?>" alt=""></a>
				</div>
			<?php }?>
		<?php }?>

	</div>

	
<div class="wenquan" > 
	
		<?php if(!empty($curpcatid)) { ?>
		<div class="xuantiao" style="height:auto;border-bottom:0">
		<!-- <div class="xuantiao" id="dition"> -->
			<dt style="color:#999999;">按种类：</dt>
			<dd>
				<div class="categorycon">
					
					<?php if(!empty($curchildcatlist)) { ?>
						<?php foreach($curchildcatlist as $child) { ?>
						<div>
						
						<?php if($child['catid'] == $curcatid) { ?>
						<?php $curcatname = $child['name'];?>
						<a class="curr" href="javascript:void(0);"><?= $child['name'] ?></a>
					
						<?php } else { ?>
						<a href="<?= geturl('question-1-0-0-'.$curpcat['catid'].'-'.$child['catid']) ?>"><?= $child['name'] ?></a>
						
						<?php } ?>
						</div>
						<?php } ?>
					<?php } ?>
				</div>
			</dd>
			<div class="clear"></div>
		</div>
		<?php } ?>
		
		<?php if(!empty($gradelist)) { ?>
		<div class="xuantiao" style="height:auto;border-top:0;border-bottom:0">
			<dt style="color:#999999;">按级别：</dt>
			<dd>
			<div class="categorycon">
			
			<?php foreach($gradelist as $gradekey=>$grade) { ?>
			<div>
			<?php if($gradekey==$curgrade) { ?>
			<a class="curr" href="javascript:void(0)"><?= $grade ?></a>
			<?php } else { ?>
			<a href="<?= geturl('question-1-0-0-'.$curpcatid.'-'.$curcatid.'-'.$gradekey)?>"><?= $grade ?></a>
			<?php } ?>
			</div>
			<?php } ?>
			</div>
			</dd>
		<div class="clear"></div>
		</div>
		<?php } ?>

<div class="xuantiao" style="margin-bottom:15px;">
<dt>已选条件：</dt>
<dd>
<span class="heehz" style="text-align:center;">
<a href="/question.html" style="color:#18a8f7;">重置筛选条件</a>
</span>
<?php if(!empty($curcatname)){?>
<em class="termss">
<a href="question-1-<?=$sortmode?>-0-<?=$attr0?>-0-.html?keyword=<?=$keyword?>"><?=$curcatname?></a>
</em>
<?php }?>
<?php if(!empty($gradelist[$curgrade])){?>
<em class="termss">
<a href="question-1-<?=$sortmode?>-0-<?=$attr0?>-<?=$attr1?>-.html?keyword=<?=$keyword?>"><?=$gradelist[$curgrade]?></a>
</em>
<?php }?>
<?php if(!empty($keyword)){?>
<em class="termss">
<a href="question-1-<?=$sortmode?>-0-<?=$attr0?>-<?=$attr1?>-<?=$attr2?>.html"><?=$keyword?></a>
</em>
<?php }?>
</dd>
</div>

<div class="icategry" style="width:758px">
<div class="etryk" style="border-bottom:solid 1px #e3e3e3;border-top:none;width:758px;">
<dt style="line-height:30px;width:60px;padding-left:15px;">排序：</dt>
<dd style="margin-top: 3px;width:666px;">

<div class="tit_wenti">
<ul>
<li class="buty<?=$sortmode==0?' selectBtnd':''?>">
<a style="text-decoration:none;" href="/question-1-0-0-<?=$attr0?>-<?=$attr1?>-<?=$attr2?>.html?keyword=">所有问题</a>
</li>
<li class="buty<?=$sortmode==1?' selectBtnd':''?>">
<a style="text-decoration:none;" href="/question-1-1-0-<?=$attr0?>-<?=$attr1?>-<?=$attr2?>.html?keyword=">最新问题</a>
</li>
<li class="buty<?=$sortmode==2?' selectBtnd':''?>">
<a style="text-decoration:none;" href="/question-1-2-0-<?=$attr0?>-<?=$attr1?>-<?=$attr2?>.html?keyword=">答疑排行</a>
</li>
</ul>
<?php if(!empty($user)){
	if($user['groupid']!=5){ 
?>	
<a class="tijibtn dialogLogin" href="javascript:void(0);" name="<?= geturl('home/largedb/addquestion')?>">我要提问</a>
<?php }}else{?>
	<a class="tijibtn dialogLogin" href="javascript:void(0);" name="">我要提问</a>
<?php }?>
</div>

</dd>
</div>
<div class="ptjia" style="width: 740px;">
<p style="float:left;margin-top:6px;">问题索引（共有<span style="color:#398dcb;" id="count"><?= $count ?></span>个符合条件的答疑）</p>
<div style="float:right">
<input id="iptsou" class="iptsou" type="text" value="输入要搜索的内容" />
<a class="alinkbtn" href="javascript:void(0)" onclick="return listsearch('iptsou')">确 定</a>
</div>
</div>
</div>
</div>


	

	<div class="wenlieb">
		<div class="mainbghui" style="border:none;">
		
					<table  width="100%" class="datatab" style="width:760px;">							
							<tbody>							
							 <?php if(empty($questionlist)) { ?>
			  		<tr><td colspan="6" align="center">无符合条件的答疑</td></tr>
                                <?php } else { ?>
                       <?php foreach($questionlist as $avalue) { ?>
                                        
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
				 		<tr>
						<?php if($avalue['shield']==1){ ?>
							<td style="background-color:#e3e3e3;">
						<?php }else{ ?>
							<td>
						<?php } ?>

						<div style="float:left;margin-right:15px;"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>" src="<?=$face?>" /></div>
							<div style="float:left;width:670px;font-family:Microsoft YaHei;">
								<p style="width:550px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
									<a href="http://www.ebh.net/question/<?=$avalue['qid']?>.html" target="_blank" style="color:#777;font-weight:bold;">
										<?= $avalue['title'] ?>
									</a>
								</p>
								<span style="width:55px;text-align:center;float:right;line-height:2;background:url(http://static.ebanhui.com/ebh/tpl/default/images/modu.png) no-repeat 0px 28px;">回答数<br/><?= $avalue['answercount'] ?></span>
								<div style="float:left;width:550px;">
								<span style="width:150px;float:left;"><?= Date('Y-m-d H:i:s',$avalue['dateline']) ?></span>
								<span style="width:100px;float:left;background: url(http://static.ebanhui.com/ebh/tpl/default/images/rwuico0507.jpg) no-repeat scroll left center;padding-left: 20px;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
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
		
	</div>
</div>
	<?= $pagestr ?>

</div>
<div style="clear:both;"></div>
<script type="text/javascript">
// 我要提问 
$(".dialogLogin").click(function(){
	var attr_name = $(this).attr("name");
	if ($(this).attr("name")) {
		location.href=$(this).attr("name");
		// $.loginDialog($(this).attr("name"));
	}else{
		$.loginDialog();
	}
	
});


<!--
	function addfavorite(qid,flag) {
	var tips = "取消关注";
	if(flag == 1) {
		tips = "关注问题";
	}
	$.ajax({
		url:"<?= geturl('question/addfavorit')?>",
		type:'post',
		data:{'qid':qid,'op':'addfavorite','flag':flag,'inajax':1},
		dataType:'text',
		success:function(data){
			if(data=='success'){
				$.showmessage({
					img		 :'success',
					message  :tips+'成功',
					title    :tips
				});
				changefavorite(qid,flag);
			}else{
				$.showmessage({
					img		 :'error',
					message  :tips+'失败',
					title    :tips
				});
			}
		}
	});
}
	function changefavorite(qid,flag) {
		var html = "";
		if(flag == 1) {
			html = '<a href="javascript:addfavorite('+qid+',0)">取消关注</a>';	
		} else {
			html = '<a href="javascript:addfavorite('+qid+',1)">关注问题</a>';
		}
		$("#guanzhu"+qid).html(html);
	}
	
	function addthank(qid) {
		var tips = "感谢";
		$.ajax({
			url:"<?= geturl('question/addthank')?>",
			type:'post',
			data:{'qid':qid,'op':'addthank','inajax':1},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					var num = parseInt($("#qtknum"+qid).html());
					$("#qtknum"+qid).html(num+1);
					$.showmessage({
						img		 :'success',
						message  :tips+'成功',
						title    :tips
					});
					
				}else if(data == 'fail'){
					$.showmessage({
						img		 :'error',
						message  :tips+'失败',
						title    :tips
					});
				}else if(data == 'thatday'){
					$.showmessage({
						img		 :'error',
						message  :'您今天已经感谢过了！',
						title    :tips
					});
				}
			}
		});
	}

	 function listsearch(keyid){		 
		var keywords= $.trim($("#"+keyid).val()=='输入要搜索的内容'?'':$("#"+keyid).val());
		url = "<?= geturl('question-1-'.$sortmode.'-0-'.$curpcatid.'-'.$curcatid.'-'.$curgrade)?>?keyword="+keywords;
		window.location.href=url;
	}
//-->
$(function(){
	$("#iptsou")
	.blur(function(){
		$(this).val($.trim($(this).val()));
		if($(this).val()==""){
			$(this).val("输入要搜索的内容");
		}
	})
	.focus(function(){
		$(this).val($.trim($(this).val()));
		if($(this).val()=="输入要搜索的内容"){
			$(this).val("");
		}
	})
})
</script>
<?php $this->display('common/footer2');?>