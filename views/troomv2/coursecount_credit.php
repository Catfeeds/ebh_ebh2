<?php $this->display('troomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<style>
.ymlist{
	z-index:1000;
}
a.noreach{
	display:none;
}
.dytjzxtson table {
    width: 400px;
}
.dytjzxtson tr.topsbt {
    background: #f9f9f9 none repeat scroll 0 0;
    border: 1px solid #e7e7e7;
    color: #333;
    font-size: 14px;
}
.dytjzxtson td {
    border: 1px solid #efefef;
    padding: 10px 6px;
    text-align: center;
}
.contents {
	margin-left:25px;
	float:left;
	width:250px;
}
.content-img {
	float:left;
	width:40px;
	height:40px;
	border-radius:100%;
}
.right-box {
	float:left;
	margin-left:5px;				
	width:200px;
}
.lfname {
	float:left;
	width:200px;
}
.spname {
	float:left;
	margin-right:5px;
	color:#444;
	font-size:15px;
}
.content-nv {
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png) no-repeat bottom center;
	width: 16px;
	height: 16px;
	float: left;
	display: block;
	margin-top:3px;
}
.content-nan {
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png) no-repeat bottom center;
	width:16px;
	height:16px;
	float:left;
	display: block;
	margin-top:3px;
}
.content-user {
	color:#999;
	float:left;
	width:200px;
	font-size:13px;
	text-align: left;
}
</style>
<div class="lefrig" style="padding-bottom:120px;">
	<?php $this->assign('index',8);
	$this->display('troomv2/course_menu');
	$this->assign('currentindex',3);
	$this->display('troomv2/coursecount_menu');?>
	<div class="clear"></div>
	<div class="kejianzs mt20">
		<div class="nnbl">整体情况</div>
		<div class="ljzsbtfa mt25">
			<div class="ljzsbt ljzsbt1s"><span class="span1s">部门人数：<?=$userscount?>人</span></div>
		</div>
		<div class="ljzsbtfa mt25">
			<div class="ljzsbt ljzsbt1s"><span class="span1s">课程学分：<?=$folder['credit']?>分</span></div>
		</div>
		<div class="ljzsbtfa mt25">
			<div class="ljzsbt ljzsbt1s"><span class="span1s">总学分完成度：<?=$totalcredit?>/<?=$userscount*$folder['credit']?></span></div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="qzsjlb mt25" style="padding-left:40px;">
		<div class="zhqks ">
			<div class="dytjzxt">
				<div class="nnbl fl">个人统计</div>
				<div class="dytjzxtson fl mt20" style="width:100%;">
					<div class="clear"></div>
						<table cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr class="topsbt">
									<td style="text-align:left;text-indent:25px;">员工账号</td>
									<td>获得学分</td>
								</tr>
								<?php if(!empty($userlist)){
									foreach($userlist as $user){?>
								<tr>
									<td>
										<div class="contents">
											<img class="content-img" src="<?=getavater($user,'40_40')?>" />
											<div class="right-box">
												<p class="lfname"><span class="spname"><?=empty($user['realname'])?'':$user['realname']?></span><i class="content-<?=empty($user['sex'])?'nan':'nv'?>"></i></p>
												<p class="content-user"><?=$user['username']?></p>
											</div>
										</div>
									</td>
									<td><?=$user['foldercredit']?></td>
								</tr>
								<?php }
								}?>
							</tbody>
						</table>
					</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
