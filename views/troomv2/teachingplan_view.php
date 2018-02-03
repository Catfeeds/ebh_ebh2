<?php $this->display('troomv2/page_header'); ?>
<style>
.topname {
	-width:430px;
	border:none;
	-border-bottom:solid 1px #666;
	height:40px;
	color:#666;
	line-height:40px;
	font-size:16px;
	font-weight:bold;
	text-align:center;
	margin:5px 0 5px 300px;
}
.duantxt {
	width:130px;
	border:none;
	-border-bottom:solid 1px #666;
	color:#666;
	height:30px;
	line-height:30px;
	text-align:center;
	margin:5px 0;
	float:left;
}
.lefbian {
	width:70px;
	float:left;
	color:#666;
	margin:5px 0;
	height:30px;
	line-height:30px;
	text-align:right;
}
.zhumai{
	border-top:1px solid #ddd;
	border-bottom:1px solid #ddd;
	padding-top:10px;
	padding-left:10px;
}
</style>

<div class="ter_tit">
当前位置 > <a href="<?=geturl('troomv2/teachingplan')?>">电子教案</a> > <a href="<?=geturl('troomv2/teachingplan/manage')?>">教案管理</a> > 教案详情
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:786px;">
	<span class="topname" id="title" type="text" ><?=$tplandetail['title']?></span>
  <br />
  <span class="lefbian" style="margin-left:150px;">编写时间：</span><span id="dateline" type="text" class="duantxt"><?=Date('Y-m-d H:i:s',$tplandetail['dateline'])?></span>
  <span class="lefbian">编写人：</span><span id="username" type="text" class="duantxt" ><?=$tplandetail['realname']?></span>
		<br/><br/><br/>
	<div class="zhumai">
		<!-- /////////////htmlspecialchars_decode() -->
		<?=$tplandetail['content']?>
		
	</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>