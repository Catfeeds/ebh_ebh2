<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=20151118001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript">
		
	
		<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
			$(function(){
				if(window != undefined) {
					showDivModel(".nelame");
				//	$(".nelame").css("left","100px");
					$(".nelame").css("top","300px");
				}
			});
		<?php }else{ ?>
			//flv播放
			$(function (){
				var cwid = <?= $course['cwid'] ?>;
				var isfree = <?= isset($isfree) ? $isfree : $course['isfree'] ?>;;
				var num = 1;//教室内
				var cwname = '<?= $course['cwname'] ?>';
				var suffix = cwname.split('.');
				var lastsuffix = suffix[suffix.length-1];
					//flv

					<?php 
						if(!empty($course['m3u8url'])) {
					?>
					playmu('<?= $course['m3u8url'] ?>',cwid,'',isfree,num,'562','978',1,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>);
					<?php 
						} else if(!empty($course['rtmpurl'])) {
					?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','978',1,'<?= $course['thumb'] ?>');
					<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','978',1);
					<?php } ?>
			});
		<?php } ?>

		//听课完成回调
		function messfun(ctime,ltime,finished,plid){
			var cwid = <?= $course['cwid'] ?>;
			var res = studyfinish(cwid,ctime,ltime,finished,plid);
			if(finished==1){
				showHomeWork();
			}
			return res;
		}

		</script>
		<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>

</head>
<body>
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<div style="width:980px;margin: 0 auto;"> 
<div class="cright" style="float:left;display: block;margin: 0 auto;width:980px;margin-bottom:20px;">
		<?php $domain=$this->uri->uri_domain();
		$cloudurl='http://'.$domain.'.ebanhui.com';?>
		<?php if($domain == 'www'){ ?>
			<div class="ter_tit">
				>
				<a href="<?= $cloudurl?>" title="<?= $coursedetail['crname']?>"><?= $coursedetail['crname']?></a>
				>
				<span style="color:#3D3D3D;"><?= $coursedetail['foldername']?></span>
				> <?= $coursedetail['title']?>
			</div>
		<?php }else{ ?>
			<div class="ter_tit">
			当前位置 > 所有课程 > <?= $course['foldername'] ?> > <?= $course['title']?>
			</div>
		<?php } ?>
<div class="lefrig" style="margin-top:10px;float:none;">
			<div style="width:978px;background: #FFF;border:solid 1px #cdcdcd;float:left;padding-bottom:10px;">
			<div class="classbox" style="width:978px;background: #FFF;border:#FFF;">
				<h1><?= $course['title']?></h1>
				<div class="classboxmore" style="width:946px;">
						
					<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span><span>人气：<?= $course['viewnum']?></span></p>
					<p>摘要：<?= $course['summary'] ?></p>
					<p style="padding:10px;float:left;margin-left:-10px;">
					<?php if(preg_match('/.*(\.ebh|\.ebhp)$/',$course['cwurl'])) {?>
						<?php if(empty($hasnobtn) || $hasnobtn != TRUE ) { ?>
							<?php if($course['isfree']==1){ ?>
							<input class="huangbtn marrig" value="开始听课" type="button"  onclick="freeplay('<?= $course['cwsource']?>','<?= $course['cwid']?>','<?php str_replace("'"," ",$course['title'])?>',1,0,showdialogs)"/>
							<?php }else{ ?>
							<input name="" onclick="freeplay('<?= $course['cwsource'] ?>',<?= $course['cwid'] ?>,'<?= str_replace("\""," ",str_replace("'"," ",$course['title']))?>')" class="huangbtn marrig" value="开始听课" type="button" />
							<?php } ?>
						<?php } ?>
					
					<?php } elseif (!empty($course['cwurl']) && !preg_match('/.*(\.flv)$/',$course['cwurl'])) { ?>
						<a href="<?= $course['cwsource'].'attach.html?cwid='.$course['cwid']?>" class="huangbtn marrig">下载文件</a>
					<?php } ?>

					
					</p>
					<!-- Baidu Button BEGIN -->
					<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="float:left;margin-top:10px;">
					<span class="bds_more">分享到：</span>
					<a class="bds_tsina"></a>
					<a class="bds_qzone"></a>
					<a class="bds_tqq"></a>
					<a class="shareCount"></a>
					</div>
					<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6704542" ></script>
					<script type="text/javascript" id="bdshell_js"></script>
					<script type="text/javascript">
					document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
					</script>
					<!-- Baidu Button END -->
					<?php if(!empty($course['rtmpurl'])) { ?>
					<div style="float:right;">
					<span style="float:left;margin:16px 10px 0 20px;">如您无法正常播放，也可以 <a href="<?= geturl('myroom/stusubjectcc/course/'.$course['cwid']).'?type=1' ?>" style="color:blue">点击这里</a></span>
					
					</div>
					<?php } ?>
				</div>
			</div>


			<?php if(preg_match("/.*(\.flv)$/",$course['cwurl'])) { ?>
				<div style=" position: relative;height:560px;z-index:601;float:left;background:#fff;width:968px;padding-left:10px;">
				<div id="flvcontrol" style="width:700px;height:400px;"></div>
				</div>
			<?php } ?>
			</div>
				<div id='atsrc' style="display: none;"></div>
			<div style="float:left;width:978px;margin-top:30px;margin-bottom: 10px;"> 
			
			<?php
				$this->assign('domain',$domain);
				$this->assign('cwid',$course['cwid']);
				$this->display('myroom/flashnote');
			?>
				<div class="introduce" style="width:978px;">
				<div class="intitle">
					<h2>课件介绍</h2>
				</div>
			  	<div class="inconts" style="width:928px;">
					<?= $course['message'] ?>
				</div>
			</div>

			

			<a name="fujian" href="javascript:void(0);"></a>

				<?php if (($domain!='www') && (!empty($attachments))) { ?>
				<div class="introduce" style="width:978px;">
					<div class="intitle">
						<h2>附件下载</h2>
					</div>
							
					<div class="incont" style="width:960px;">
							<table width="978px;" class="datatab">
								<thead class="tabhead">
									<tr>
										<th>附件名称</th>
										<th>上传时间</th>
										<th>附件大小</th>
										<th>操作</th>
									</tr>
								  </thead>
									<tbody>
									 <?php foreach ($attachments as $atta) { ?>
									  <tr>
									  
									  
									<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
											<td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
										<?php } else { ?>
											<td width="55%"><span style="width:400px;word-wrap: break-word;float:left;"><a href="javascript:void(0);" class="atfalsh" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" ><?= $atta['title'] . '.' . $atta['suffix'] ?></a></span></td>
										<?php } ?>
									<?php } ?>
										<td><?= date('Y-m-d H:i', $atta['dateline']) ?></td>
										<td></td>
										<?php if ($atta['suffix'] != 'ebh' || $atta['suffix'] != 'ebhp') { ?>
										<td>
											<?php if ($atta['suffix'] != 'swf' && $atta['suffix'] != 'mp3' && $atta['suffix'] != 'flv') { ?>
												<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载附件" type="button" />
												<?php if($atta['ispreview']) { ?>
												<a  class="previewBtn" href = "<?= (empty($source) ?$atta['source']:$source).'preview/att/'.$atta['attid'].'.html' ?>" target="_blank">预览</a>
												<?php } ?>
											<?php } else { ?>
												<a class="atfalsh" href="javascript:void(0);" source="<?= (empty($source) ?$atta['source']:$source) ?>" title="<?= $atta['title']?>" suffix="<?= $atta['suffix'] ?>" cwid="<?= $course['cwid'] ?>" aid="<?= $atta['attid'] ?>" >播放</a>
											<?php } ?>
										</td>
										<?php } ?>
									  </tr>
									  <?php } ?>
								  </tbody>
							</table>
					</div>
				</div>
				<?php } ?>
			
			

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play2.js?v=2"></script>
<?php $this->display('myroom/page_footer'); ?>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
	
	</div>
