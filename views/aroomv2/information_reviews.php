<?php $this->display('aroomv2/page_header')?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css">
<style>
	.shrtke {
		width:460px;
		font-family:微软雅黑;
	}
	.tistse {
		color:#555;
		width:100%;
		margin-bottom:5px;
		font-size:14px;
		text-align:left;
	}
	.sfter {
		border:solid 1px #e3e3e3;
		width:440px;
		height:90px;
		padding:5px 10px;
		line-height:1.8;
		font-size:13px;
		color:#666;
		text-align:left;
		overflow:auto;
	}
	.nistdrt {
		margin:10px 0 0 70px;
		font-size:13px;
		text-align:left;
	}
	.nistdrt input {
		vertical-align: middle;
		margin:0 5px 0 60px;
		cursor:pointer;
	}
	.nistdrt label {
		cursor:pointer;
	}
	a.tsrdebtn {
		height:32px;
		line-height:32px;
		width:112px;
		display:block;
		background:#5794ff;
		color:#fff;
		text-align:center;
		font-size:14px;
		border-radius:3px;
		float:left;
		margin:0 25px 0 105px;
	}
	a.nisrbtn {
		float:left;
		height:30px;
		line-height:32px;
		width:110px;
		border:solid 1px #e3e3e3;
		display:block;
		background:#f1f1f1;
		color:#999;
		text-align:center;
		font-size:14px;
		border-radius:3px;
	}
	.hoverds:hover {
		color:#467ae7;
		cursor:default;
	}
</style>


<body>
<div >
	<div class="ter_tit">
        当前位置 > <a href="/aroomv2/information.html">信息管理</a> > 评论管理
    </div>
    <div class="pingluns mt10">
    	<div class="pingluns_top">
            <div class="clear"></div>
        	<div class="pingluns_top_l fl" style="width:440px;">
            	<div class="fl">
                    <span style="font-size:14px; color:#333;">时间段：</span>
                    <input id="startdate" class="inp" type="text" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$startdate?>" />
                    <span style="font-size:14px; color:#333;">到</span>
                    <input id="enddate" class="inp" readonly="readonly " type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$enddate?>" />
					<input id="q" type="text" style="display:none" value="<?= $q?>"/ >
                </div>
                <div class="fl ml10" ><a href="javascript:;" onclick="searchbydate()" class="workBtns workBtns-1">确 定</a></div>
            </div>
            <div class="pingluns_top_r fl ml25" style="line-height:32px;">
            	<ul><?php $q = $this->input->get('q'); ?>
                	<li class="fl"><b>评论状态>>&nbsp;&nbsp;</b></li>
                    <li class="fl" id="noq"><a href="/aroomv2/information/review.html?sdate=<?= $startdate?>&edate=<?=$enddate?>" class="<?= ($q=='')? 'select':''?>" >全部</a></li>
					<li class="fl" id="noq1"><a href="/aroomv2/information/review.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&q=0" class="<?= ($q=='0')? 'select':''?>" >待审核</a></li>
                    <li class="fl" id="noq1"><a href="/aroomv2/information/review.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&q=1" class="<?= ($q=='1')? 'select':''?>" >审核通过</a></li>
                    <li class="fl" id="noq2"><a href="/aroomv2/information/review.html?sdate=<?= $startdate?>&edate=<?=$enddate?>&q=2" class="<?= ($q=='2')? 'select':''?>" >审核不通过</a></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
        <div class="reviewview">
            <table cellpadding="0" cellspacing="0" class="tables">
                <tr class="first">
                    <td width="150">评论人</td>
                    <td width="174">评论对象</td>
                    <td width="192">评论内容</td>
                    <td width="114">时间</td>
					<td width="114">状态</td>
                    <td width="96">操作</td>
                </tr>
				<?php if(!empty($reviews)){
					foreach($reviews as $k=>$rl){
				?>
                <tr>
				<?php $arr = explode('.',$rl['cwurl']);
					$type = $arr[count($arr)-1]; 
					if($type != 'flv' && $rl['ism3u8'] == 1)
						$type = 'flv';
					if($type == 'mp3')
						$type = 'flv';
					if(!empty($rl['face']))
						$face = getthumb($rl['face'],'50_50');
					else{
						if($rl['sex']==1){
							if($rl['groupid']==5){
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
							}else{
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
							}
						}else{
							if($rl['groupid']==5){
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
							}else{
								$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
							}
						}
					
						$face = getthumb($defaulturl,'50_50');
					} 
				?>
                    <td width="190">
						<?php
							$avater['face'] = $rl['face'];
							$avater['sex'] = $rl['sex'];
							$face = getavater($avater);
						?>
						<a href="javascript:;" class="fl" style="cursor:context-menu"><img style="width:50px;height:50px;border-radius:25px;" src="<?= $face ?>" /></a>
						<p class="p2s" style="width:95px !important;">
								<?php
									$usernameLong = !empty($rl['realname'])?$rl['realname']:$rl['username'];
								    $length = mb_strlen($usernameLong, 'utf-8');
								    if ($length > 6) {
										$username =  mb_substr($usernameLong, 0, 5, 'utf-8').'...';
									}else {
										$username = $usernameLong;
									}
								?>
								<span title="<?= $usernameLong ?>" style="color:black"><?= $username ?></span>
								<?= $rl['sex']==1?'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png">':'<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png">'?>
							<br />
							<?php
								$usernameLong = $rl['username'];
								$length = mb_strlen($usernameLong, 'utf-8');
								if ($length > 6) {
									$username =  mb_substr($usernameLong, 0, 5, 'utf-8').'...';
								} else {
									$username =  $usernameLong;
								}
							?>
							<span title="<?= $usernameLong ?>" style="color:black"><?= $username ?></span>
						</p>
					</td>
                    <td width="144">
						<!-- <a class="hoverds" href="/troomv2/course/<?= $rl['cwid'] ?>.html" target="_blank"> -->
						<a class="hoverds" href="javascript:void(0)">
							<?php
								$length = mb_strlen($rl['title'], 'utf-8');
								if ($length > 19) {
									$title =  mb_substr($rl['title'], 0, 18, 'utf-8').'...';
								} else {
									$title =  $rl['title'];
								}
							?>
							<p style="width:130px;word-wrap: break-word;float:left;color:black" title="<?= $rl['title'] ?>">
								<?= $title ?>
							</p>
						</a>
					</td>
                    <td width="182" style="postion:relative">
					<?php 
						$osubject = preg_replace('/\'/','&#39;',$orireviews[$k]['subject']);
						$datainfo = preg_replace('/\'/','&#39;',$rl['subject']);
					?>
						<p id="logid<?=$rl['logid']?>" style="width:175px;word-wrap: break-word;float:left;"  title='<?= $osubject ?>' data-info='<?= $datainfo ?>'>
							<?php
								$subject = preg_replace('/<([^i][^m][^g])/','&lt;\1',$rl['subject']);
								preg_match_all('/(<img.*?>)/', $subject, $imgArr);
							    if (!empty($imgArr[0])) {
									foreach($imgArr[0] as $v) {
										$subject = str_replace($v,'@',$subject);
									}
								}

								$subjectStr  = '';
								$length =  mb_strlen($subject, 'UTF8');
								if($length > 22){
									$subject =  mb_substr($subject,0,21,'utf-8').'...';
									$subjectArr = explode('@',$subject);
									$subjectArrLen = count($subjectArr);
									foreach ($subjectArr as $k=>$v) {
										if (($k+1) < $subjectArrLen) {
											$subjectStr .= $v.$imgArr[0][$k];
										} else {
											$subjectStr .= $v;
										}
									}
								} else {
									$subjectArr = explode('@',$subject);
									$subjectArrLen = count($subjectArr);
									foreach ($subjectArr as $k=>$v) {
										if (($k+1) < $subjectArrLen) {
											$subjectStr .= $v.$imgArr[0][$k];
										} else {
											$subjectStr .= $v;
										}
									}
								}
								echo $subjectStr;
							?>
						<p>
					</td>
                    <td width="114" style="text-align:center"><?=Date('Y-m-d H:i',$rl['dateline'])?></td>
					<td width="114" style="text-align:center">
						<?php
							if($rl['audit'] == 0) echo '待审核';
							elseif($rl['audit'] == 1) echo '审核通过';
							elseif($rl['audit'] == 2) echo '<span color="red">审核不通过</span>';
						?>
					</td>
					<?php if($rl['audit']==0){ ?>
						<td width="96"  style="text-align:center"><a href="javascript:showaudit(<?= $rl['logid']?>, <?= $rl['audit']?>)">审核</a></td>
					<?php }else{ ?>
						<td width="96"  style="text-align:center"><a href="javascript:showaudit(<?= $rl['logid']?>, <?= $rl['audit']?>)">重新审核</a></td>
					<?php } ?>
                </tr>
				<?php }} ?>
            </table>
			<?php if(empty($reviews)){ ?>

					<div class="nonejunr nodata">
					</div>


			<?php } ?>
		</div>
    <?=show_page($reviewcount)?>
	</div>
</div>

<input type="hidden" name="logid" id="logid" value="" />

<script type="text/javascript">
<!--
	function searchbydate(){
	var sdate = $('#startdate').val();
	var edate = $('#enddate').val();
	var q = $('#q').val();
	if(q=='')
		var href='/aroomv2/information/review.html?sdate='+sdate+'&edate='+edate;
	else
		var href='/aroomv2/information/review.html?sdate='+sdate+'&edate='+edate+'&q='+q;
	location.href = href;
}

//屏蔽评论
	function shield(cwid,logid){
		$.ajax({

			type:'post',
			url:'<?= geturl('aroomv2/information/shield')?>',
			dataType:'json',
			data:{'cwid':cwid,'logid':logid},
			success:function(data){
				if(data != undefined && data.status != undefined && data.status == 1) {
					alert("屏蔽评论成功");
					location.reload(true);
				}else{
					alert("屏蔽评论失败");
				}
			},
			error:function(){
				alert("屏蔽评论失败，请稍后再试。");
			}
		});	
	}
//取消屏蔽评论
	function cancel(cwid,logid){
		$.ajax({
			type:'post',
			url:'<?= geturl('aroomv2/information/cancleshield')?>',
			dataType:'json',
			data:{'cwid':cwid,'logid':logid},
			success:function(data){
				if(data != undefined && data.status != undefined && data.status == 1) {
					alert("取消屏蔽成功");
					location.reload(true);
				}else{
					alert("取消屏蔽失败");
				}
			},
			error:function(){
				alert("取消屏蔽失败，请稍后再试。");
			}
		});	
	}
//-->

    // 对应评论内容载入到弹框
    function showaudit(logid, audit) {
		var title = $('#logid'+logid).data('info');
		title = title.replace(/<([^i][^m][^g])/g,'&lt;$1');
		$('#logid').val(logid);
		if (audit == 2) {
			var htmlStr = '<div class="shrtke"><h2 class="tistse">评论内容：</h2><div class="sfter">'+title+'</div><div class="nistdrt"><input type="radio" name="radio" id="radio1" value="1"/><label for="radio1"  onclick="tochecked(1)">审核通过</label><input name="radio" type="radio" id="radio2" value="2"  checked="checked" /><label for="radio2"  onclick="tochecked(2)">审核不通过</label></div></div>';
		} else {
			var htmlStr = '<div class="shrtke"><h2 class="tistse">评论内容：</h2><div class="sfter">'+title+'</div><div class="nistdrt"><input type="radio" name="radio" id="radio1" value="1" checked="checked" /><label for="radio1"  onclick="tochecked(1)">审核通过</label><input name="radio" type="radio" id="radio2" value="2" /><label for="radio2"  onclick="tochecked(2)">审核不通过</label></div></div>';
		}

		dialog({
			id: "parent", //可选
			title: "审核",
			content: htmlStr,
			okValue: "确定",
			ok: function() {
				var logid = $('#logid').val();
				var audit = $("input[name='radio']:checked").val();
				if (!logid || !audit) {
					return false;
				} else {
					var url = "<?= geturl('aroomv2/information/manageraudit')?>";
					$.post(url, {logid:logid, audit:audit}, function(msg){
						var res= eval('(' + msg + ')');
						if (res.status == 1) {
							location.reload(true);
						} else {
							location.reload(true);
						}
					})
				}
			},
			cancelValue: "取消",
			cancel: function() {

			}
		}).showModal(); //show:无遮罩层,showModal:有遮罩层，需要全屏显示请在dialog前加上top,例：top.dialog({....}).showModal()
	}

	function tochecked(num){
		$("#radio"+num).attr("checked","checked");
	}

	function alertResult(){
		dialog({
			id: "abc", //可选
			skin: "ui-dialog2-tip",//想要调用图片这个是必须的
			content: "<div class='TPic'></div><p>内容</p>", //三种图片，TPic:勾,FPic:叉,PPic:感叹号
			width: 350,
			onshow: function() { //此事件在弹层显示后执行
				var that = this;
				setTimeout(function() {
					that.close().remove();
				}, 1000);
			}
		}).show();
	}
</script>
<?php $this->display('aroomv2/page_footer')?>

