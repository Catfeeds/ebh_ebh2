<?php $id = $this->uri->itemid;?>
<?php $menuactiveid=3 ?>
<?php
$this->display('common/header');
?>
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/fanart.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>

<div class="toptitnew"><a href="/">首页</a> > <a href="/space.html">原创空间</a> > 作品详情</div>
<div class="main" style="margin-top:10px;">
<div class="deta">
<div class="diek">

<div class="lefzuop">
<ul class="align_box"> 
<li> 
<div class="detatu">
<a href="<?= $showpath.$infor['image']?>" >
<img class="show_img" src="<?= getthumb($showpath.$infor['image'],'126_126')?>" /> 
<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif"/> 
</a>
</div>
</li>
</ul>
<div style="float:left;width:240px;">
<div class="zuopin">

<h2>
	<span id="sh1"><a  href="<?= $showpath.$infor['image']?>" title="<?= $infor['title']?>" id="linka"><?= ssubstrch($infor['title'],0,60)?></a></span>
	<span id="sh2" style="display:none;" >
		<input id="showtextbox"  style="height:17px;width:130px;" value="<?= ssubstrch($infor['title'],0,60)?>" onblur="changeTextBox1(<?= $infor['id']?>)" maxlength='30' >
	</span>
</h2>
<p>创建时间：<span><?= date('Y-m-d',$infor['dateline'])?></span></p>
<a href="<?= $showpath.$infor['image']?>" class="lookbig">查看大图</a>
</div>
<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="{'pic':'<?= $showpath.$infor['image']?>'}" style="margin-top: 15px;width:200px;">
 <span class="bds_more">分享到：</span>
	 <a class="bds_qzone"></a>
	 <a class="bds_tsina"></a>
	 <a class="bds_tqq"></a>
	 <a class="bds_renren"></a>
	 <a class="shareCount"></a>
</div>
</div>
<div class="namx">
<?php
if($infor['sex']==1)
	$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
else
	$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
$face = empty($infor['face']) ? $defaulturl : $infor['face'];
$face = getthumb($face,'50_50');
?>
<div class="rttu"><a href="<?= geturl('spacelist').'?key='.$infor['username'] ?>" title="点击查看该作者所有作品"><img src="<?= $face ?>"  width="78px" height="78px" /></a></div>
<p>原创者账号：<span><a href="<?= geturl('spacelist').'?key='.$infor['username'] ?>" style="color:#3095c6"><?= $infor['username']?></a></span></p>
<p>原创者姓名：<span><?= $infor['realname']?></span></p>
<p><span><a href="<?= geturl('spacelist').'?key='.$infor['username'] ?>" style="color:#3095c6">查看该作者所有作品</a></span></p>
<input type="hidden" id="voteid" value="<?= $id ?>" />
</div>

</div>
<?php $scarr=explode(".",$infor['score'])?>
<div class="vote">
<div class="fenshu">
<span class="score">
<strong><?= $scarr[0]?></strong>.<?= substr($scarr[1],0,1)?>
</span>
<p style="margin-top:10px;"><?= $infor['votenum']?>人参与评分</p>
<p style="color:#999;">(满分10分)</p>
</div>
<?php $infor['good']?>
<?php
	if($infor['votenum']!=0){
		$bgood = sprintf("%01.0f", $infor['good']/$infor['votenum']*100);
		$bgeneral = sprintf("%01.0f", $infor['general']/$infor['votenum']*100);
		$bbad = sprintf("%01.0f", $infor['bad']/$infor['votenum']*100);
		$rvalue = $bgood+$bgeneral+$bbad;
		if(($rvalue>0)&&($rvalue<100)){
			$bgood+=100-$rvalue;
		}elseif($rvalue>100){
			$bgood-=$rvalue-100;
		}
	}
?>

<div class="dc">
	<p>你觉得该原创作品怎么样?</p>
	<ul>
		<li>
		<div class="best">
			<?php if($infor['votenum']!=0){?>
			<span style="width: <?= $bgood.'%'?>;">
				<em><?= $bgood.'%'?></em>
			</span>
			<?php }?>
		</div>
		<input id="answer" type="radio" checked="checked" value="good" name="answer">
		很好
		</li>
		<li>
			<div class="good">
			<?php if($infor['votenum']!=0){?>
				<span style="width: <?= $bgeneral.'%'?>;">
					<em><?= $bgeneral.'%'?></em>
				</span>
			<?php } ?>
			</div>
			<input id="answer" type="radio" value="general" name="answer">
			一般
		</li>
		<li>
			<div class="bad">
			<?php if($infor['votenum']!=0){?>
				<span style="width: <?= $bbad.'%'?>;">
					<em><?= $bbad.'%'?></em>
				</span>
			<?php } ?>
			</div>
			<input id="answer" type="radio" value="bad" name="answer">
			很差
		</li>
	</ul>
	<p class="r">
		<a href="javascript:;" onclick="submitvote(<?= empty($user)?0:$user['uid']?>)">投票</a>
	</p>
</div>
</div>
</div>
</div>
<div class="review">
<div class="sdpot">
<div class="topissue">
	<h2 class="titreview"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/reviewtit0713.jpg" /></h2>
	<div id="post_form" class="commentOn" style="">
		<textarea rows="1" cols="" id="content" name="content" > </textarea>
		<p>
			<span id="post_msg_tips" style="color:red;">发表对这个原创作品的看法(150字以内)</span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选择评价类型 [必选]:
			<label>
				<input id="rev" class="selected" type="radio" value="best" name="rev">
				好评
			</label>
			<label>
				<input id="rev" class="selected" type="radio" value="good" name="rev">
				中评
			</label>
			<label>
				<input id="rev" class="selected" type="radio" value="bad" name="rev">
				差评
			</label>
		</p>
			<a class="faping" href="javascript:;" id="submitcontentbtn" idattr="<?= $id?>">发表评论</a>

	</div>
</div>

<div class="fotissue">
<h3 class="titnew1">
  <i class="tittu1"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/daid0713.jpg" /></i></h3>
  <?php if(!empty($reviews)){ ?>
  <ul>
<?php foreach($reviews as $review){ 

		$sex = empty($review['sex']) ? 'man' : 'woman';
		$type = $review['groupid'] == 5 ? 't' : 'm';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
		$face = empty($review['face']) ? $defaulturl : $review['face'];
		$facethumb = getthumb($face,'50_50');
?>    
	  <li>
		  <div class="tuxiang"><img src="<?= $facethumb?>" width="50px" height="50px" /></div>
		  <div class="pust">
			  <h2 style="color:#2b9bcd;"><?= $review['username']?></h2>
			  <p style="height:50px;"><?= $review['subject']?></p>
			  <p style="color:#999999;"><?= date('Y-m-d H:i:s',$review['dateline'])?></p>  
		  </div>
		  <?php if(!empty($review['good'])){?>
		  	<span class="ping"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/good0713.jpg" /></span>
		  <?php }elseif(!empty($review['bad'])){?>
		  	<span class="ping"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/bad0713.jpg" /></span>
		  <?php }else{?>
		  	<span class="ping"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/naka0713.jpg" /></span>
		  <?php } ?>
	  </li>
<?php } ?>
  </ul>
  <?php }else{ ?>
 <div style="margin-top: 10px; margin-left: 430px;">暂 无 任 何 评 论</div>
  <?php } ?>
  <?= $pagestr ?>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript">
$(function() {
	$('.detatu a').lightBox();
	$('.zuopin a').lightBox();
});
</script>

<script type="text/javascript">
	function submitvote(uid){
		if (uid==0) {
			$.loginDialog(dovote);return;
		} else {
			dovote();
		}
	}
	function dovote() {
		var id = $("#voteid").val();
		var voteanswer = $("input[name='answer']:checked").val();
		if(voteanswer!=''){
			$.ajax({
				url:"<?= geturl('space/vote')?>",
				type:'post',
				data:{'id':id,'voteanswer':voteanswer},
				dataType:'text',
				success:function(data){
					data = $.trim(data);
					if(data=='success'){
						alert('投票成功');
						location.reload();
					}else if(data=='thatday'){
						alert('您今天已经投过票了！(每个账号一天只能投票一次)');
					}else if(data=='nologin'){
						//弹出登录提示框
						$.loginDialog();
					}else{
						alert('投票失败！');
					}
				}
			});
		}else{
			alert('请选择评分！');
		}
	}
	var submitcomment =  function(){
		var id = $("#submitcontentbtn").attr("idattr");
		var content = $.trim($("#content").val());
		var evaluate = $("input[name='rev']:checked").val();

		if(content==''){
			alert("请输入评论内容！");
			$("#content").focus();
			return;
		}else if($(".selected:checked").length==0){ 
			alert("请选择评价类型！"); 
			return;
		}else{

			$.ajax({
				url:"<?= geturl('space/comment')?>",
				type:'post',
				data:{'content':content,'id':id,'op':'submitcomment','evaluate':evaluate,'inajax':1},
				dataType:'text',
				success:function(data){
					data = $.trim(data);
					if(data=='success'){
						$.showmessage({
							img		 : 'success',
							message  :  ' 评论提交成功',
							title    :      '提交评论',
							callback :    function(){
								location.reload();
							}
						});
					}else if(data=='thatday'){
						$.showmessage({
							img		 : 'error',
							message  :  ' 您今天已经评论过了！(每个账号一天只能评论一次)',
							title    :      '提交评论',
							callback :    function(){

							}
						});
					}else if(data=='nolongin'){
						$.loginDialog();
					}else{
						$.showmessage({
							img		 : 'error',
							message  :  '评论提交失败！',
							title    :      '提交评论',
							callback :    function(){

							}
						});
					}
					$("#content").val("");
					$("input[name='rev']:checked").removeAttr("checked");
				}
			});
		}
	}
	$("#submitcontentbtn").click(function(){
		var uid = <?= empty($user) ? 0 : $user['uid']?>;
		var content = $.trim($("#content").val());
		var evaluate = $("input[name='rev']:checked").val();
		if(content==''){
			alert("请输入评论内容！");
			$("#content").focus();
			return;
		}else if($(".selected:checked").length==0){ 
			alert("请选择评价类型！"); 
			return;
		}
		if (uid == 0) {
			$.loginDialog(submitcomment);

		}else{
			submitcomment();
		}
	});


	$(function(){
	    window.onload = function() {
	        document.getElementById("content").onkeyup = function() {
	            var len = this.value.length;
	            var tmp = 150 - len;
	            if (tmp <= 0) {
	                this.value = this.value.substring(0, 150);
	                document.getElementById("post_msg_tips").innerHTML = "您还可以输入 0 个字符";
	            } else {
	                document.getElementById("post_msg_tips").innerHTML = "您还可以输入 " + tmp + " 个字符";
	            }
	        }
	    }
	});
</script>
<script type="text/javascript">
	<!--
		var surl = "$searchurl";
	function deletespace(id,title) {
		var result = confirm("您确定要删除您的作品 "+title+" 吗?");
		if (result) {
			var aurl = "<?= geturl('space')?>";
			$.post(aurl,{"op":"delete","id":id},function(result){
				if (result.status == 1) {
					alert(result.msg);
					document.location.href = "/space.html";
				} else {
					alert(result.msg);
				}
			});
		}
	}
	//-->
</script>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6704542" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById('bdshell_js').src = "http://share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;"></div>
<?php
    $this->display('common/footer');
?>