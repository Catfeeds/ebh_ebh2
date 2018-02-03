<?php $this->display('shop/stores/stores_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/yinan.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/ask.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<?php $folderid = $this->input->get('folderid'); ?>
<?php $sortmode = $this->uri->sortmode; ?>

<?php $keyword= $this->input->get('q'); ?>
<div class="main">
<div class="dtzhix">
<div class="topkuang"></div>
<div class="zixun">
<div class="leflist">
	<h2 style="margin-bottom:10px;">所有课程</h2>
	<p style="margin-left:10px; font-weight:bold;">
	<a href="/askquestion.html">查看所有答疑 >></a>
	</p>
	<ul>
	<?php foreach($courqlist as $v){ ?>
		<?php if($v['count']!=0){?>
			<li class="lister">
			<a style="cursor:pointer;" href="/askquestion.html?folderid=<?= $v['folderid']?>">
			<p class="titming" <?= $folderid==$v['folderid'] ?'style="color: #838383;"':'style="color: #3D3D3D;"'?> ><?= shortstr($v['foldername'],24)?>
			<span style="color:#838383;font-weight:normal;margin-left: 5px;">(<?= $v['count']?>)</span>
			</p>
			</a>
			<p class="sizele"><?= shortstr($v['summary'],88)?></p>
			</li>
		<?php } ?>
	<?php } ?>
	</ul>
</div>
<div class="rigkus">
	<div class="rigtop">
	</div>
	<div class="rigmain">


		<div class="navers">
			<h2 class="titbgt">答题专区</h2>
		
				<div class="titwenlie">
					
					<ul>
						<li class="<?= empty($sortmode)?'selectbtn':'' ?> buts">
						<a href="<?= geturl('askquestion-1-0-0')?>"  style="text-decoration:none;">所有问题</a>
						</li>
						<li class="<?= $sortmode==1?'selectbtn':'' ?> buts">
						<a href="<?= geturl('askquestion-1-1-0')?>"  style="text-decoration:none;">最新问题</a>
						</li>
						<li class="<?= $sortmode==2?'selectbtn':'' ?> buts">
						<a href="<?= geturl('askquestion-1-2-0')?>"  style="text-decoration:none;">答疑排行</a>
						</li>
					</ul>
					<div class="waisou" style=" margin-left: 325px; margin-top: -25px;width: 365px;">
					  <input id="search" class="txtselo" name="textarea" type="text" value="<?= $keyword?str_replace('\'\'','\'',$keyword):'请输入问题关键词'?>" style="padding-left: 5px;color:#3D3D3D;" onblur="if($.trim(this.value).length==0){this.value='请输入问题关键词';}" onfocus="if(this.value=='请输入问题关键词')this.value='';"/>
					  <input class="btnselo" type="submit" name="Submit" value="" onclick="listsearch('search')"/>
					</div>
				</div>
				<p class="suoyin">问题索引（共有<span style="color:#398dcb;" id="count"><?= $askcount?></span>个符合条件的答疑）</p>
				<ul>
				
				<?php 
					if(!empty($asklist)){
					foreach($asklist as $values ){ ?>
					<li class="ruwenlie" style="margin:0px 0px 10px 10px;height:auto;display:inline;">
					<a href="<?= geturl('askquestion/'.$values['qid'])?>" style="text-decoration:none;cursor: pointer;">
						<h2 class="wentit" style=" float: left;"><?= shortstr($values['title'],70,'')?></h2>
					</a>
					<span style="float: left;margin-left: 25px;margin-top: 3px;color:#747474;"><?= $values['answercount']?>人已回答</span>
					<p class="pjianju" style="width: 630px;float:left;"><?= shortstr(filterhtml($values['message']),160)?></p>
					<p class="fotxiang"><span class="rennam"><?= !empty($values['realname'])?$values['realname']:$values['username']?></span><span class="fengex">|</span><span class="ttime"><?= date('Y-m-d',$values['dateline'])?></span><span class="fengex">|</span>
					<?php if(!empty($user)){ ?>
							<span class="guanzhuti" id="guanzhuti<?= $values['qid']?>" >
						<?php if(empty($values['aid'])){ ?>
							<a href="javascript:addfavorite(<?= $values['qid']?>,1)">关注问题</a>
						<?php }else{ ?>
							<a href="javascript:addfavorite(<?= $values['qid']?>,0)">取消关注</a>
						<?php } ?>
							</span>
					<?php }else{ ?>
						<span class="guanzhuti" id="guanzhuti<?= $values['qid']?>" >
						<a href="javascript:;" class="dialogLogin">关注问题</a>
						</span>
					<?php } ?>
					<span class="fengex">|</span>
					<?php if(!empty($user)){ ?>
					<a href="javascript:addthank(<?= $values['qid']?>)"><span class="thank">感谢</span>(<span  id="qtknum<?= $values['qid']?>"><?= $values['thankcount']?></span>)</a>
					<?php }else{ ?>
					<a href="javascript:;" class="dialogLogin"><span class="thank">感谢</span>(<span  id="qtknum<?= $values['qid']?>"><?= $values['thankcount']?></span>)</a>
					<?php } ?>
					</p>
						<div class="fenxiangwei">
							<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"  data="{'text':'<?= $values['title']?>-答疑专区-e板会','desc':'<?= shortstr(filterhtml($values['message']),160)?>'}">
							<span class="bds_more" >分享到：</span>
							<a class="bds_tsina"></a>
							<a class="bds_qzone"></a>
							<a class="bds_tqq"></a>
							<a class="bds_renren"></a>
							</div>
							<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6704542" ></script>
							<script type="text/javascript" id="bdshell_js"></script>
							<script type="text/javascript" >
							document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
							</script>

						</div>
					</li>
				<?php } ?>
				</ul>
					<?= $pagestr ?>
				<?php }else{ ?>
				<div class="zanwu">
					<img src="http://static.ebanhui.com/ebh/tpl/2012/images/zanwu0514.jpg">
					<p>
					如何提问：进入个人中心的“
					<a href="<?= geturl('member/myask')?>">我的答疑</a>
					”中提问。
					</p>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

</div>
<div class="fltkuang"> </div>
</div>
</div>

<div style="text-align:center;clear:both;">
<script type="text/javascript">
<!--
	
	$(".dialogLogin").click(function(){
	if ($(this).attr("name") != '') {
		$.loginDialog($(this).attr("name"));
	}else{
		$.loginDialog();
	}
	
	});

	function addfavorite(qid,flag) {
		var tips = "取消关注";
		if(flag == 1) {
			tips = "关注问题";
		}
		$.ajax({
			url:'<?= geturl('askquestion/addfavorit') ?>',
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
		$("#guanzhuti"+qid).html(html);
	}

	function addthank(qid) {
		var tips = "感谢";
		$.ajax({
			url:'<?= geturl('askquestion/addthank')?>',
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
		var keywords= encodeURIComponent($.trim($("#"+keyid).val()=='请输入问题关键词'?'':$("#"+keyid).val()));
		var url = '/askquestion.html?q=!search!';
		url = url.replace('!search!',keywords);
		window.location.href=url;
	}
//-->
</script>
<?php
	$this->display('common/footer');
?>