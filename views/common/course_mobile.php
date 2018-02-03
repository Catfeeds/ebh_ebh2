
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=1200, user-scalable=no" name="viewport"/>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?v=20170525001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery-browser.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/qqFace/js/jquery.qqFace.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css"/>
    <?php if (!empty($isplate)) { ?>
        <script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
        <script type="text/javascript" src="http://static.ebanhui.com/js/html5.hack.js"></script>
        <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20160614001"></script>
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/newindex.css?v=201705180001" />
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/module.css?v=201705180001" />
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/course_type_menu_theme.css?v=201705130001" />
        <script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/plate.js?v=201705130001"></script>
    <?php } ?>
<style>
.qqFace{margin-top:4px;background:#fff;padding:2px;border:1px #dfe6f6 solid;}
.qqFace table td{padding:0px;}
.qqFace table td img{cursor:pointer;border:1px #fff solid;}
.qqFace table td img:hover{border:1px #0066cc solid;}
	.workcurrent a span {background:none;padding:0;}
.workcurrent a {padding:0;background:url(http://static.ebanhui.com/ebh/tpl/default/images/intit_02.jpg) no-repeat;width:118px;height:33px;line-height:33px;text-align:center;}
.work_mes ul li{font-size:14px;}
.classbox h1.rygers {font-weight: bold; color:#666;margin-top:0px;height:36px;line-height:36px;font-size:20px;float:left;}
.classboxmore p {line-height:20px;}
.classboxmore {padding:0;width:860px;border:none;}
.classboxmore span{margin-left:0;}
.lefrig input.lanbtn{background:url("http://static.ebanhui.com/ebh/tpl/2014/images/shoucangico.jpg") no-repeat left center;color: #626262;font-family: "微软雅黑";font-size: 14px;padding-left: 20px;width:65px;}
.lefrig input.lanbtn:hover{background:url("http://static.ebanhui.com/ebh/tpl/2014/images/shoucangico.jpg") no-repeat left center;}
.classbox h1{ height:24px; line-height:32px;}
.introduce{ border:none;}
span.renming1 {
    font-family: 微软雅黑;
    font-size: 12px;
    color: #999;
	display:block;
	height:20px;
	overflow:hidden;
}
.userimg a{
	display:block;
}
.userimg a b{
	display:block;
	width:65px;
	font-family:微软雅黑;
	font-size:14px;
	color:#333;
	font-weight:normal;
	line-height:12px;
}
body{background:#8493af;}
.coursewareview {width: 940px;}
.inputrating {width:864px;}
.commentsright-top{width:810px;}
.commentsright{width:810px;}
.commentlistson{width:785px;}
.commentreply{width:785px;}
.commentreply .inputrating-reply{width:98%;}

.viedo_tit,.ter_rele,.kelist,.list_titles{font-weight:700;}
.imagemin {
	width:200px;
	height:123px;
}
img.scrimg {
	width:200px;
	height:123px;
}
a.play-courseware.playscal {
	width:200px;
	height:123px;
}
.coursename {
	height: 26px;
	font-size:14px;
	line-height: 26px;
}
a.play-courseware.playscal:hover {
    background: rgba(0, 0, 0, 0) url("http://static.ebanhui.com/ebh/tpl/2014/images/kustgd.png") no-repeat scroll center;
}
</style>


		<script type="text/javascript">
		function addfavorite(cwid,title,url){
			var purl = "<?= geturl('myroom/favorite/add')?>";
			$.ajax({
				type	:'POST',
				url		:purl,
				data	:{'cwid':cwid,'title':title,'url':url,'type':1},
				dataType:'text',
				success	:function(data){
					if(data=='success'){
						$("#favorite").val("已收藏");
						$("#favorite").unbind();
					}
				}
			});
		}
		$(function(){
		<?php if(empty($myfavorite)) { ?>
			$("#favorite").val("收藏");
			$("#favorite").unbind().click(function(){
				$("#favorite").removeAttr('onclick');
					addfavorite('<?= $course['cwid'] ?>','<?= str_replace('\'','',$course['title']) ?>',location.href);
			});
		<?php } else { ?>
			$("#favorite").val("已收藏");
		<?php } ?>
		});

		<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>
			$(function(){
				if(window != undefined) {
					showDivModel(".nelame");
				//	$(".nelame").css("left","100px");
				//	$(".nelame").css("top","100px");
				}
			});
		<?php }else{ ?>
					//flv播放
			$(function (){
				var cwid = <?= $course['cwid'] ?>;
				var isfree = <?= isset($isfree) ? $isfree : $course['isfree'] ?>;
				var num = 1;
				var cwname = '<?= $course['cwname'] ?>';
				var suffix = cwname.split('.');
				var lastsuffix = suffix[suffix.length-1];
				<?php if(!empty($type)){?>
				lastsuffix = '<?= $type ?>';
				<?php } ?>
				if(lastsuffix == 'flv'){
					//flv
					<?php
						if(!empty($course['m3u8url'])) {
						$autoplay = $this->input->get('autoplay');
						$autoplay = !empty($autoplay)?$autoplay:0;
					?>
						// var html = '<video id="_video" src="<?=$course['m3u8url']?>" poster="<?=$course['thumb']?>" width="940px" height="562px"  controls="controls">您的浏览器不支持播放该视频！</video>';
						// $("#flvcontrol").html(html);
						// alert($("#flvcontrol").html());
					<?php
						} else if(!empty($course['rtmpurl'])) {
					?>
					playrtmp('<?= $course['rtmpurl'] ?>',cwid,'',isfree,num,'562','940',0,'<?= $course['thumb'] ?>');
					<?php } else {?>
					playflv('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'562','940',0);
					<?php } ?>
				} else if(lastsuffix == 'mp3'){
					playaudio('<?= $course['cwsource'] ?>',cwid,'',isfree,num,'400','940',0);
				}
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
		$(function(){
			//分页开始加载
			var page = 1;
			var cwid = $("#cwid").attr("value");
			var url = "/course/getajaxpage.html";
			page_load(page,url);
		})
		</script>
		<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<style type="text/css">
.ermas {display:none;}
.viedo_erma:hover .ermas {display:block;}
</style>
<![endif]-->
</head>
<body>
<input type="hidden" value="<?=$course['cwid']?>" id="cwid" /><!--课件cwid-->
<input type="hidden" value="<?=$user['groupid']?>" id="groupid" /><!--用户groupid用于判断老师还是学生-->
<input type="hidden" value="<?=$course['uid']?>" id="courseuid" /><!--课件教师id-->
<input type="hidden" value="<?=$user['uid']?>" id="useruid" /><!--用户id-->
<?php if (!empty($top_components)) { ?>
    <div class="wraps">
        <?php foreach ($top_components as $mid => $top_component) {
            if ($mid == 1) {
                $this->partial('shop/plate/portfolio-logo', true, $top_component);
            } else if ($mid == 2) {
                $this->partial('shop/plate/portfolio-navigation', true, $top_component);
            }
        } ?>
    </div>


    <div id="window-login" style="display:none;">
        <div class="logDialog" >
            <div><input type="hidden" id="plate-login-arg" /></div>
            <div id="msg_log" style="display:none;position:absolute;z-index:12;margin-left:50px;top:24px;color:#c00;width:235px;">
                <div style="background:url(http://static.ebanhui.com/ebh/images/errorLayer_03.gif) no-repeat 0 0;height:2px;overflow:hidden;"></div>
                <div style="padding:10px 8px;background:url(http://static.ebanhui.com/ebh/images/errorLayer_14.gif) repeat;">
                    <div class="msg_close" style="float:left;position:absolute;top:0px;right:10px;cursor:pointer;color:#666;font-family:黑体;font-weight:bold;font-size:16px;">x</div>
                    <div><p id="msg_log_main" style="z-index:14px;background:url(http://static.ebanhui.com/ebh/images/tips_error.gif) no-repeat 0 0px;padding-left:20px;font-size:12px;font-weight:bold;">帐号不能为空</p></div>
                </div>
                <div style="background:url(http://static.ebanhui.com/ebh/images/errorLayer_16.gif) no-repeat;height:7px;"></div>
            </div>

            <form style="padding:0 13px;text-align:left;" id="form2" action="/login&amp;inajax=1" name="form2" method="post">
                <input value="df493206" name="formhash" type="hidden">
                <input value="1" name="loginsubmit" type="hidden">
                <input value="login" name="action" type="hidden">
                <p style="font-size:14px;color:#808080;line-height:40px;height:40px;">帐号：</p>
                <input style="height: 31px; line-height: 31px; border: medium none; font-size: 14px;  padding-left: 8px; padding-right: 20px; width: 223px; background: transparent url(&quot;http://static.ebanhui.com/ebh/images/zhanghtxt0218.jpg&quot;) repeat scroll 0% 0%; color: #000" id="uname" placeholder="请输入账号/手机号/邮箱" title="请输入账号/手机号/邮箱" tabindex="1" name="username" type="text">
                <p style="font-size:14px;color:#808080;line-height:40px;height:40px;">密码：</p>
                <input style="height:31px;line-height:31px;border:none;font-size:14px;color:#000;padding-left:8px;padding-right:20px;width:223px;background:url(http://static.ebanhui.com/ebh/images/passtxt0218.jpg);color:#000;" id="pword" class="txtpass" maxlength="20" value="" tabindex="1" name="password" type="password">
                <div style="margin:8px 0;"><input id="rememberme" style="float:left;height:20px;line-height:20px;margin:15px 2px 15px 20px;" value="checkbox" name="checkbox" type="checkbox"><span style="float:left;color:#888;margin:15px 0 15px 0;"><label for="rememberme">下次自动登录</label></span></div>
                <div style="clear:both"></div><input class="isubmit" style="background:url(http://static.ebanhui.com/ebh/images/logobtn0218.jpg) no-repeat;width:251px;height:32px;border:none;margin-bottom:10px;cursor:pointer;" value="" type="button">

                <?php 
	                //获取网校的配置
	                $systemsetting = Ebh::app()->room->getSystemSetting();
	                $isbanregister = empty($systemsetting['isbanregister']) ? 0 : 1;//1禁用注册
	                $isbanthirdlogin = empty($systemsetting['isbanthirdlogin']) ? 0 : 1;//禁用第三方登入
	            ?>
	            <?php if (!$isbanthirdlogin) { ?><div style="width:215px;margin:8px 0;"><span style="color:#000;">用其他账号登录：</span><a href="<?=getopenloginurl('qq', $currentdomain)?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg"></a><a href="<?=getopenloginurl('sina', $currentdomain)?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0925.jpg"></a><a href="<?=getopenloginurl('wx', $currentdomain)?>" style="margin-left:10px;height:20px;line-height20px;color:#808080; "><img src="https://open.weixin.qq.com/zh_CN/htmledition/res/assets/res-design-download/icon16_wx_logo.png"></a></div><?php } ?>
	            <div class="fotlogs" style="width:251px;border-top:1px solid #ccc;padding-top:12px;text-align:center;"><?php if(!$isbanregister) { ?><a style="margin-left:10px;height:20px;line-height20px;color:#808080; " href="javascript:void(0)" class="reginpage">用户注册</a><?php } ?><a style="margin-left:10px;height:20px;line-height20px;color:#808080; " href="http://www.ebh.net/forget.html">忘记密码？</a></div>

            </form>
        </div>
    </div>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/plate-login-window.js?v=20170119001"></script>
    <script type="text/javascript">
        $("a.reginpage").bind('click', function() {
            var ifheight;
            $.ajax({
                url: '/register/getbindstatus.html',
                async: false,
                dataType: 'json',
                type: 'get',
                success: function(data){
                    console.log(data);
                    if(data.error_code == 0){
                        if(data.data.mobile_register == 1){
                            ifheight = 650;
                        }else{
                            ifheight = 550;
                        }
                    }else{
                        console.log("接口错误")
                    }
                },
                error: function(data) {
                    ifheight = 550;
                    console.log(data);
                }
            });


            height = ifheight;
            width = 650;
            url = '/register/inpage.html';
            var html = '<iframe scrolling="no" marginheight="0" marginwidth="0" frameborder="0" width="'+width+'" height="'+height+'" src="'+url+'" style="border-radius:6px;"></iframe>';
            registerWindow = new dialog({
                id:'register-small-window',
                title:'用户注册',
                fixed:true,
                content:html
            });
            registerWindow.showModal();
        });
    </script>
<?php } ?>

<div style="width:1200px;margin:0 auto 0 auto;font-family:微软雅黑;">
	<div class="cright" style="display: block;margin: 0 auto;width:1200px;margin-bottom:20px; ">
		<?php $domain=$this->uri->uri_domain();
		 $roominfo = Ebh::app()->room->getcurroom();
		$cloudurl='http://'.$domain.'.ebh.net';?>

		<div class="lefrig" style="position:relative;;background:#fff;min-height:1651px;">
			<!--免费试听新添加右侧模块-->
			<div class="rigvideo">
				<div class="rigvideo_list content_2 content">
					<ul><?php if(!empty($freewarelist)) {
					    foreach ($freewarelist as $cwid => $freeware) {
					        if (empty($freeware['logo'])) {
					            $freeware['logo'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png';
                            }
					        ?>
                            <li class="list_li">
                                <a href="/course/<?=$freeware['cwid']?>.html">
                                    <img src="<?=$freeware['logo']?>" />
                                    <h3 class="list_title" title="<?=htmlspecialchars($freeware['title'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($freeware['title'], 22, ''), ENT_NOQUOTES)?></h3>
                                    <p class="list_ptd"><?=$freeware['viewnum']?>次学习</p>
                                </a>
                            </li>
                        <?php }
                        } ?>
					</ul>
				</div>
				<div class="rigvideo_ter">
					<div class="ter_rele">关联讲师</div>
					<div class="team_bk">
						<a href="javascript:;">
							<div class="team_hbj">
								<img src="<?=getavater($teacher)?>">
								<h3 class="team_h3" title="<?=htmlspecialchars(!empty($teacher['realname']) ? $teacher['realname'] : $teacher['username'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr(!empty($teacher['realname']) ? $teacher['realname'] : $teacher['username'], 20, ''), ENT_NOQUOTES)?></h3>
								<p class="team_p1" title="<?=htmlspecialchars($teacher['professionaltitle'], ENT_COMPAT)?>"><?=htmlspecialchars(!empty($teacher['professionaltitle']) ? shortstr($teacher['professionaltitle'], 30, '') : '暂无职称', ENT_COMPAT)?></p>
							</div>
							<p class="team_p2"><?=htmlspecialchars(shortstr($teacher['profile'], 60), ENT_NOQUOTES)?></p>
						</a>
					</div>
					<div class="kelist">课程列表</div>
					<div class="scole content_2 content" style="border:none;height:740px;background-color:#fff;">
						<ul>
							<?php if (!empty($folders)) {
							    foreach ($folders as $itemid => $folder) {
							        $url = '/courseinfo/'.$itemid.'.html';
							        $img = !empty($folder['img']) ? $folder['img'] : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg';
                                    $img = show_plate_course_cover($img);
                                    $img = show_thumb($img);
							        ?>
									<li class="keli_li">
										<div class="imagemin">
											<img class="scrimg" src="<?=$img?>">
											<a class="play-courseware playscal" href="<?=$url?>" target="_blank"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/kustgd2.png"></a>
										</div>
										<a href="<?=$url?>" target="_blank"><div class="coursename" title="123213213"><?=htmlspecialchars(shortstr($folder['foldername'], 22, ''), ENT_NOQUOTES)?></div></a>
									</li>
                                <?php }
                            } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php if($type == 'flv') { ?>
				<div style=" position: relative;height:562px;z-index:1;float:left;background:#000;">
				<div id="flvcontrol" style="width:940px;height:562px;">
					<?php if(!empty($course['m3u8url'])){?>
					<video id="_video" src="<?=$course['m3u8url']?>" poster="<?=$course['thumb']?>" width="940px" height="562px"  controls="controls">您的浏览器不支持播放该视频！</video>
					<?php }?>
				</div>
				</div>
			<?php } ?>

			<?php if($type == 'mp3') { ?>
				<div id="flvcontrol" style="width:940px;height:400px;"></div>
			<?php } ?>

				<div id='atsrc' style="display: none;"></div>
			<div style="float:left;width:940px;">
			<div class="ieyin" style="_display:block;"></div>

			</div>


			<?php if(!empty($examlist) && $roominfo['isschool'] == 2 && (!empty($roominfo['crid']))) { ?>
			<div class="work_menuss" style="width:940px;float:left;">
					<div class="intitle">
					<h2>在线测评</h2>
				</div>
			</div>
				<div class="incont" style="width:938px;">
						<table width="100%;" class="datatab" style="border:none;">
							<thead class="tabhead">
								<tr>
									<th>作业名称</th>
									<th>出题时间</th>
									<th>总分</th>
									<th>操作</th>
							 	</tr>
							  </thead>
								<tbody>


								 <?php foreach($examlist as $exam) { ?>
								  <tr>
									<td width="60%"><?= $exam['title'] ?></td>
									<td width="20%"><?= date('Y-m-d H:i:s',$exam['dateline'])?></td>
									<td width="5%"><?= $exam['score'] ?></td>
									<td width="15%">
											<a class="previewBtn" href="http://exam.ebanhui.com/freedo/<?= $exam['eid'] ?>.html" target="_blank"><span>答题</span></a>
									</td>
								  </tr>
								  <?php } ?>

							  </tbody>
						</table>

				</div>
			<?php } ?>

			<a name="fujian" href="javascript:void(0);"></a>

				<?php if ((!empty($roominfo['crid'])) && (!empty($attachments))) { ?>
				<div class="introduce" style="width:940px;">
					<div class="intitle" >
						<h2>附件下载</h2>
					</div>

					<div class="incont" style="width:938px;">
							<table width="100%;" class="datatab" style="border:none;">
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
												<input class="previewBtn" onclick="location.href = '<?= (empty($source) ?$atta['source']:$source) . 'attach.html?attid=' . $atta['attid'] ?>'" name="" value="下载" type="button" />
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
				<!--免费视频操作选项-->
				<div class="mf_viedo">
					<div class="viedo_tit" title="<?= $course['title']?>"><?= shortstr($course['title'], 30)?><span class="huicolor"><?= $course['viewnum']?>次学习</span></div>
					<a class="viedo_zan<?=$praised ? ' viedo_zans' : '' ?>" href="javascript:;"><?=$course['zannum']?></a><!--点赞成功添加样式viedo_zans-->
					<span class="bdsharebuttonbox"><a class="viedo_share" href="javascript:;" class="bds_more" data-cmd="more">分享</a></span>
					<div class="viedo_erma">二维码
						<div class="ermas">
							<img id="qcode" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_appcode.jpg" />
							<p class="text-sm">
							扫二维码继续学习
							<br>
							二维码时效为半小时
							</p>
						</div>
					</div>
				</div>
			<?php if(!empty($course['message'])){ ?>
			<div class="introduce" style="padding-top:0px;width:940px;">
				<div class="intitle">
					<h2>课件介绍</h2>
				</div>
			  	<div class="incont" style="width:928px;overflow: hidden;">
					<?= $course['message'] ?>
				</div>
			</div>
			<?php } ?>
            <script type="text/javascript">
                (function($) {
                    var cwid = <?=$course['cwid']?>;
                    var logined = <?=empty($logined) ? 'false' : 'true'?>;
                    $("a.viedo_zan").bind('click', function() {
                        var t = $(this);
                        if (t.hasClass('viedo_zans')) {
                            return false;
                        }
                        if (!logined) {
                            $.loginByWindow('');
                            return false;
                        }
                        $.ajax({
                            'url': '/course/ajax_addzan.html',
                            'type': 'post',
                            'data': {'cwid':cwid},
                            'dataType': 'json',
                            'success': function(ret) {
                                if (ret && ret.status == 1) {
                                    t.html(parseInt(t.html()) + 1);
                                    t.addClass('viedo_zans');
                                }
                            }
                        });
                    });
                    window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{bdCustomStyle:'http://static.ebanhui.com/ebh/tpl/newschoolindex/css/newindex.css'}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
                    $("#qcode").attr('src', 'http://up.ebh.net/qrcode.html?content='+encodeURI(document.location.href)+'&show=1')
                })(jQuery);
            </script>
			<?php if($roominfo['crid'] != 10420){ ?>
				<div class="introduce" style="width:940px;">
					<div class="intitle" style="width:938px;"><h2><a id="rid">课件评论 (<font color="red" id="reviewcount"><?=$reviewcount?></font>)</a></h2></div>
					  	<!--新评论开始-->
						<div class="coursewareview">
							<?php if(!empty($user)){ ?>
				   			<?php if(!empty($roominfo['crid'])){ ?>
							<div class="satisfaction">
						    	<span class="span1s">满意度：</span>
						    			<input id="mark_score" name="mark" type="hidden" value="0">
						        <span class="span2s" onmouseover="chose_star(this,event)">

						        	<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="1" title="很烂">
						            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="2" title="一般">
						            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="3" title="还好">
						            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="4" title="较好">
						            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="5" title="很好">
						        </span>
						    </div>
						    <textarea class="inputrating" id="comment-input">请输入你的评论。。。。</textarea>
						    <div class="facecomments">
						    	<a href="javascript:;" class="face face-comment"></a>
						        <div class="qqface1" style="display:none;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/qqbq.jpg" /></div>
						        <a href="javascript:;" onclick="comment();" class="reviews">评&nbsp;论</a>
						        <p class="inputprompt inputprompt-bottom">你还可以输入<span>100</span>字</p>
						    </div>
						    <div class="clear"></div>
						    <?php } ?>
							<?php } ?>
						    <div class="allcomments">

						    </div>
						</div>
						<?= $pagestr ?>
						<!--新评论结束-->


	</div>
			</div>
		<?php }else { ?>
				<?php if($roominfo['isschool']!= 3){ ?>
				<div class="introduce">
					<div class="intitle" style="width:940px;"><h2><a id="rid">课件评论 (<font color="red" id="reviewcount"><?=$reviewcount?></font>)</a></h2></div>

				   <!--新评论开始-->
						<div class="coursewareview">
							<?php if(!empty($user)){ ?>
				   			<?php if(!empty($roominfo['crid'])){ ?>
							<div class="satisfaction">
						    	<span class="span1s">满意度：</span>
						    			<input id="mark_score" name="mark" type="hidden" value="0">
						        <span class="span2s" onmouseover="chose_star(this,event)">

						        	<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="1" title="很烂">
						            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="2" title="一般">
						            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="3" title="还好">
						            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="4" title="较好">
						            <img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png" score="5" title="很好">
						        </span>
						    </div>
						    <textarea class="inputrating" id="comment-input">请输入你的评论。。。。</textarea>
						    <div class="facecomments">
						    	<a href="javascript:;" class="face face-comment"></a>
						        <div class="qqface1" style="display:none;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/qqbq.jpg" /></div>
						        <a href="javascript:;" onclick="comment();" class="reviews">评&nbsp;论</a>
						        <p class="inputprompt inputprompt-bottom">你还可以输入<span>100</span>字</p>
						    </div>
						    <div class="clear"></div>
						    <?php } ?>
							<?php } ?>
						    <div class="allcomments">

						    </div>
						</div>
						<?= $pagestr ?>
						<!--新评论结束-->

				  </div>

			</div>
			<?php } ?>
		<?php } ?>

<?php if(preg_match("/.*(\.ebhp)$/",$course['cwurl'])){?>
	<?php $this->display('common/player'); ?>
<?php }else{ ?>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/play.js?version=20150528001"></script>
<?php } ?>
    <?php if (!empty($isplate)) { ?>
    <div class="wrap_footer">
        <div class="wrap_footerson">
            <div class="footersonleft">
                <div class="leftimages"><img width="120" height="120" src="<?=!empty($global_qcode) ? $global_qcode : 'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/weixin.jpg'?>"/></div>
                <p class="p2s">微信学习</p>
            </div>
            <div class="footersonright">
                <div class="address">联系地址：<?=!empty($roomdetail['craddress']) ? $roomdetail['craddress']:'暂无'?></div>
                <div class="address hotline">电话：<?=!empty($roomdetail['crphone']) ? $roomdetail['crphone']:'暂无'?></div>
                <div class="address home">主页：<?=$currentdomain?></div>
            </div>
        </div>
        <div class="clear"></div>

<?php
$room = Ebh::app()->room->getcurroom();
$icp = sprintf('浙B2-20160787&nbsp;&nbsp;Copyright &copy; 2011-%d ebh.net All Rights Reserved', date('Y'));
if(!empty($room) && !empty($room['icp'])) {
    $icp = $room['icp'];
}
if (empty($global_qcode) && !empty($roomdetail)) {
    $global_qcode = $roomdetail['wechatimg'];
}
?>
        <p class="p1s"><?=$icp?></p>
    </div>
    <?php } ?>
<?php $this->display('myroom/page_footer'); ?>
<script defer="defer" type="text/javascript">

var _xform = new xForm({
		domid:'rev',
		errorcss:'cuotic',
		okcss:'zhengtic',
		showokmsg:false
	});

    //-->
    </script>

<!--新评论JS-->
<script type="text/javascript">

	<?php
		if(empty($user)){
			$user['uid'] = 0;
			$user['avatar'] = '';
		}
	?>
	$('#mark_score').val(0);
	//播放结束弹窗
	//用于记录回复记录
	var reply_log = new Object();

	//删除评论
	function del_comment(log_id,obj){
		var d = dialog({
			title: '删除评论',
			content: '您确定要删除该评论吗？删除后不可查看该评论!',
			okValue: '确定',
			ok: function () {
				<?php if(!empty($user['groupid']) && $user['groupid'] == 5){?>
				var url = "<?= geturl('troomv2/review/del')?>";
				<?php }else{?>
				var url = "<?= geturl('myroom/review/del')?>";
				<?php } ?>
				$.ajax({
					url:url,
					type:'post',
					data:{'logid':log_id,'cwid':'<?= $course['cwid'] ?>'},
					dataType:'json',
					success:function(result){
						if(result.status == '1'){

							//$('#comment_'+log_id).remove();
							var url = "/course/getajaxpage.html";
							var $curr_page_a = $('#reviewdiv .pages .listPage a.none');

							if($curr_page_a.html() == undefined){
								page_load(1,url);
							}else{
								if($curr_page_a.length == 1){
									page = $curr_page_a.html()?$curr_page_a.html():1;
								}else{
									page = 1;
								}
								var count = $("#reviewcount").html();
								if((count-1) <= 10){
									page = 1;
								}
								page_load(page,url,true);
							}

						}else{
							alert(result.msg);
						}
					}
				});

			},
			cancelValue: '取消',
			cancel: function () {}
		});
		d.showModal();
	}


	$('#comment-input').bind('keyup', function() {
		if(100-$('#comment-input').val().length <= 0){
			$('#comment-input').val($('#comment-input').val().substring(0,100));
		}
		$('.inputprompt-bottom span').html(100-$('#comment-input').val().length);
	})

	function get_now_tiem(){
		var unixTimestamp = new Date().getTime();

		return get_time(unixTimestamp/1000);
	}
	function replace_em(str){
		var emo = (str.match(/\[emo(\S{1,2})\]/g));
		var emo2 = str.match(/\[em_(\S{1,2})\]/g);
		if(emo != null){
			$.each(emo, function(i,item){
				var temp = emo[i].replace('[emo','');
				temp = temp.replace(']','');

				str2 = '<img src="http://static.ebanhui.com/ebh/tpl/default/images/'+temp+'.gif">';
				str = str.replace(emo[i],str2);
			});
		}

		if(emo2 != null){
			$.each(emo2, function(i,item){
				var temp = emo2[i].replace('[em_','');
				temp = temp.replace(']','');

				str2 = '<img src="http://static.ebanhui.com/ebh/js/qqFace/arclist/'+temp+'.gif">';
				str = str.replace(emo2[i],str2);
			});
		}
		return str;
	}
	//发表评论
	function comment(){
		var msg = $.trim($("#comment-input").val());
		var mark = $("#mark_score").val();
		if(msg=='' || msg=='请输入你的评论。。。。'){
			var d = dialog({
		    title: '提示',
		    content: '发表内容不能为空。',
		    cancel: false,
			okValue: '确定',
		    ok: function () {}
			});
			d.showModal();
			$("#comment-input").focus();
			return false;

		}else if($.trim($('#comment-input').val().replace(/<[^>]*>/g,'')).length>100){
			var d = dialog({
				title: '提示',
				content: '发表内容不能大于100字',
				cancel: false,
				okValue: '确定',
				ok: function () {}
			});
			d.showModal();
			$("#comment-input").focus();
			return false;
		}
		<?php if(!empty($user['groupid']) && $user['groupid'] == 5){?>
			var url = "<?= geturl('troomv2/review/add')?>";
		<?php }else{?>
			var url = "<?= geturl('myroom/review/add')?>";
		<?php } ?>
		var domain = "<?=$domain?>";
		$.ajax({
			url:url,
			type:'post',
			data:{'msg':msg,'cwid':'<?= $course['cwid'] ?>','mark':mark,'type':'courseware'},
			dataType:'json',
			success:function(result){
				if(result.status == '1'){
					$("#comment-input").val('');
					$('.inputprompt-bottom span').html(100);
					$('#reviewcount').html(parseInt($('#reviewcount').html())+1);
					page_load(1,"/course/getajaxpage.html");
				}else if(result.status == -1){
					var str = '';
                    $.each(result.Sensitive,function(name,value){
                    	str+=value+'&nbsp;';
                    });
                    var d = dialog({
						title: '提示',
						content: '评论包含敏感词汇'+str+'！请修改后重试...',
						cancel: false,
						okValue: '确定',
						ok: function () {
						}
					});
					d.showModal();
				}else{
					alert(result.msg);
				}
			}
		})
	}

	 //满意度单选点击事件

    $('.cstar').click(function(){

    	$('#mark_score').val($(this).attr('score'));
    })
	function chose_star(obj,oEvent){
		var imgSrc = 'http://static.ebanhui.com/ebh/tpl/2016/images/stars.png';
    	var imgSrc_2 = 'http://static.ebanhui.com/ebh/tpl/2016/images/stars1.png';
    	if(obj.rateFlag) return;
    	var e = oEvent || window.event;
	    var target = e.target || e.srcElement;
	    var imgArray = obj.getElementsByTagName("img");
	    for(var i=0;i<imgArray.length;i++){
	       imgArray[i]._num = i;
	       imgArray[i].onclick=function(){
	        if(obj.rateFlag) return;
	        var inputid=this.parentNode.previousSibling
	        inputid.value=this._num+1;
	       }
	    }
	    if(target.tagName=="IMG"){
	       for(var j=0;j<imgArray.length;j++){
	        if(j<=target._num){
	         imgArray[j].src=imgSrc_2;
	        } else {
	         imgArray[j].src=imgSrc;
	        }
	        target.parentNode.onmouseout=function(){
	        var imgnum=parseInt(target.parentNode.previousSibling.value);
	            for(n=0;n<imgArray.length;n++){
	                imgArray[n].src=imgSrc;
	            }
	            for(n=0;n<imgnum;n++){
	                imgArray[n].src=imgSrc_2;
	            }
	        }
	       }
	    } else {
	         return false;
	    }
	}
	<?php if($user['uid'] != 0){ ?>
	$('.face-comment').qqFace({
		id : 'facebox',
		assign:'comment-input',
		top:'-160px',
		path:'http://static.ebanhui.com/ebh/js/qqFace/arclist/'	//表情存放的路径
	});
	<?php }?>

	$('.face-comment').click(function(){
		if($('#comment-input').val() == '请输入你的评论。。。。'){
			$(this).css('color','#000');
			$('#comment-input').val('');
		}

	});

	$('#comment-input').focus(function(){
		if($(this).val() == '请输入你的评论。。。。'){
			$(this).css('color','#000');
			$(this).val('');
		}
	});
	$('#comment-input').blur(function(){
		if($(this).val() == ''){
			$(this).css('color','#999');
			$(this).val('请输入你的评论。。。。');
		}
	});
	//格式化时间
	function get_time(timestamp){
		var time = new Date(parseInt(timestamp) * 1000);
		var timestr = time.getFullYear()+"-"+
					(frontzero(time.getMonth()+1))+"-"+
					frontzero(time.getDate())+" "+
					frontzero(time.getHours())+":"+
					frontzero(time.getMinutes())+":"+
					frontzero(time.getSeconds());
		return timestr;
	}
	//显示所有三级评价
	function show_all(obj){
		$(obj).parent().siblings('ul').find('.replycommentli1').show();
		$(obj).parent().hide();
	}
	//获取头像
	function get_avatar(obj){
		var defaulturl = '';
		var face = '';
		if (obj.sex == 1){
			if(obj.groupid == 5){
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
			}else{
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
			}
		}else{
			if(obj.groupid == 5){
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
			}else{
				defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
			}
		}

		face = obj.face=='' ? defaulturl : obj.face;

		var path = face.substring(0,face.lastIndexOf('.'));
		var ext = face.substring(face.lastIndexOf('.'));
		return path+'_50_50'+ext;

	}
	//打开二级回复
	function open_reply_dialog(obj){
		//$('.commentlistsonbottom').show();
		$(obj).parent().parent().siblings('.commentlistsonbottom').show();
		$(obj).parent().hide();
		$(obj).parent().siblings('.close-reply-btn').show();
		//修复IE下重绘延迟
		$('.ul1').css('visibility','visible');

	}
	//关闭二级回复
	function close_reply_dialog(obj){
		$(obj).parent().parent().siblings('.commentlistsonbottom').hide();
		$(obj).parent().hide();
		$(obj).parent().siblings('.open-reply-btn').show();
		//修复IE下重绘延迟
		$('.ul1').css('visibility','inherit');
	}

	function make_reply_dialog(upid,toid,obj){
		if($(obj).parent().parent().find('.commentreply').html() == undefined){
			$('.commentreply').remove();
			var html = '';
			html+='<div class="commentreply">';
	        html+='<div class="restore_arrow1 restore_arrow1tea" style="right:10px;"></div>';
	        html+='<textarea id="inputrating" class="inputrating inputrating-reply" tips="'+$(obj).attr('tips')+'">'+$(obj).attr('tips')+'</textarea>'
	        html+='<a href="javascript:;" class="face rate-face"></a>';
			html+='<a href="javascript:;" onclick="reply_review('+upid+','+toid+',this);" class="reviews publish" type="'+$(obj).attr('type')+'">发&nbsp;布</a>';
	        html+='</div>';
	        html+='<div class="clear"></div>';

	        $(obj).parents('.commentsright-bottom').after(html);
	        $('.inputrating-reply').focus(function(){
				if($(this).val() == $(this).attr('tips')){
					$(this).css('color','#000');
					$(this).val('');
				}
			});
			$('.inputrating-reply').blur(function(){
				if($(this).val() == ''){
					$(this).css('color','#999');
					$(this).val($(this).attr('tips'));
				}
			});

			$('.rate-face').qqFace({
				id : 'facebox',
				assign:'inputrating',
				top:'-100px',
				path:'http://static.ebanhui.com/ebh/js/qqFace/arclist/'	//表情存放的路径
			});

			$('.rate-face').click(function(){
				if($('.inputrating-reply').val() == $('.inputrating-reply').attr('tips')){
					$('.inputrating-reply').val('');
				}

			})
			//修复IE下重绘延迟
			$('.commentsright').css('visibility','visible');
		}else{

			$('.commentreply').remove();
			//修复IE下重绘延迟
			$('.commentsright').css('visibility','inherit');
		}


	}

	<?php if(!empty($user['uid'])){?>
	//回复评论
	function reply_review(upid,toid,objx){
		var msg = $(objx).siblings('.inputrating').val()
		if(msg == '' || msg == $(objx).siblings('.inputrating').attr('tips')){
			var d = dialog({
			    title: '提示',
			    content: '回复内容不能为空。',
			    cancel: false,
				okValue: '确定',
			    ok: function () {}
			});
			d.showModal();
			$(objx).siblings('.inputrating').focus();
			return false;
		}else if(msg.replace(/<[^>]*>/g,'').length>100){
			var d = dialog({
				title: '提示',
				content: '回复内容不能大于100字',
				cancel: false,
				okValue: '确定',
				ok: function () {}
			});
			d.showModal();
			$(objx).siblings('.inputrating').focus();
			return false;
		}

		<?php if(!empty($user['groupid']) && $user['groupid'] == 5){?>
			var url = "<?= geturl('troomv2/review/reply')?>";
		<?php }else{?>
			var url = "<?= geturl('myroom/review/reply')?>";
		<?php } ?>
		var type = $(objx).attr('type');
		$.ajax({
			url:url,
			type:'post',
			data:{'msg':msg,'upid':upid,'toid':toid,'type':type},
			dataType:'json',
			success:function(result){
				if(result.status == 1){
					var avatar_src = '<?=getavater($user,'50_50')?>';
					if(type == 'courseware_reply'){
						if($(objx).parent().siblings('.commentlist').html() == undefined){
							reply_log[upid] = {
								<?=$user['uid']?>:{
									avatar : avatar_src
								},
								count:1
							}

							var html = '';
							html+= '<div class="commentlist">';
							html+='<div class="restore_arrow2"></div>';
							html+='<div class="commentlistson">';
							html+='<div class="commentlistsontop">';
							html+='<div class="peoplereplied"><span class="reply_count">1</span>个人回复：</div>';
							html+='<ul>';
							html+='<li><img src="'+avatar_src+'" class="circular"></li>';
							html+='</ul>';
							html+='<div style="display:none;"  class="open-reply-btn"><a href="javascript:;" onclick="open_reply_dialog(this)" class="studentname open">展开&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/zhankai.png" class="openico"></a></div>';
							html+='<div class="close-reply-btn"><a href="javascript:;" onclick="close_reply_dialog(this)" class="studentname open">收起&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/shouqi.png" class="openico"></a></div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='<div class="commentlistsonbottom"">';
							html+='<ul>';
							html+='<li>';
							html+='<div class="replycomment">';
							html+='<ul>';
							html+='<li class="replycommentli last" id="comment_'+result.logid+'">';
							html+='<div class="replycommentliright">';
							html+='<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?=$user['username']?>（<?=$user['realname']?>）</a>';
							html+='<span class="totalscore">'+get_now_tiem()+'</span>';
							html+='<div class="commentsright-center">';
							html+=replace_em(msg);
							html+='</div>';
							html+='<div class="commentsright-bottom">';
							html+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>';
							html+='</div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='</li></ul></div></li></ul></div></div></div>';
							$(objx).parent().next().after(html);
						}else{
							if(reply_log[upid][<?=$user['uid']?>] == undefined){
								reply_log[upid][<?=$user['uid']?>] = {
									avatar : avatar_src
								}
								reply_log[upid].count++;

								if(reply_log[upid].count <= 9){
									$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsontop').children('ul').append('<li><img src="'+avatar_src+'" class="circular" /></li>')
								}


							}

							var html='';
							html+='<li class="replycommentli last" id="comment_'+result.logid+'">';
							html+='<div class="replycommentliright">';
							html+='<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?=$user['username']?>（<?=$user['realname']?>）</a>';
							html+='<span class="totalscore">'+get_now_tiem()+'</span>';
							html+='<div class="commentsright-center">';
							html+=replace_em(msg);
							html+='</div>';
							html+='<div class="commentsright-bottom">';
							html+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>';
							html+='</div>';
							html+='</div>';
							html+='<div class="clear"></div>';
							html+='</li>';
							$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsonbottom').find('.replycomment').children('ul').append(html);



							$(objx).parent().siblings('.commentlist').children('.commentlistson').children('.commentlistsontop').children('.peoplereplied').children('.reply_count').html(reply_log[upid].count);


							$('#comment_'+result.logid).prev().removeClass('last');

						}
					}else{

						var toname = $(objx).parent().siblings('.studentname').html();
						if($(objx).parents('.replycommentli').find('.replycommentson').html() == undefined){
							var html = '';
							html = '<div class="replycommentson">'
							+'<ul>'
							+'<li class="replycommentli1 first" id="comment_'+result.logid+'">'
							+'<div class="replycommentliright">'
							+'<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?= $user['username'] ?>（<?= $user['realname']?>）</a>'
							+'<span class="comment">回复</span>'
							+'<a href="http://sns.ebh.net/'+toid+'/main.html" target="_blank" class="studentname">'+toname+'</a>'
							+' <span class="totalscore">'+get_now_tiem()+'</span>'
							+'<div class="commentsright-center">'
							+replace_em(msg)
							+'</div>'
							+'<div class="commentsright-bottom">'
							+'<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>'
							+'</div></div></li></ul></div>'
							$(objx).parents('.replycommentli').append(html);
						}else{
							var html = '';

							html = '<li class="replycommentli1 first" id="comment_'+result.logid+'">'
							+'<div class="replycommentliright">'
							+'<a href="http://sns.ebh.net/'+<?=$user['uid']?>+'/main.html" target="_blank" class="studentname"><?= $user['username'] ?>（<?= $user['realname']?>）</a>'
							+'<span class="comment">回复</span>'
							+'<a href="http://sns.ebh.net/'+toid+'/main.html" target="_blank" class="studentname">'+toname+'</a>'
							+' <span class="totalscore">'+get_now_tiem()+'</span>'
							+'<div class="commentsright-center">'
							+replace_em(msg)
							+'</div>'
							+'<div class="commentsright-bottom">'
							+'<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+result.logid+',this);">删除</a>'
							+'</div></div></li>'
							$(objx).parents('.replycommentli').find('.replycommentson>ul').append(html);
						}
					}
					$('.commentsright').css('visibility','inherit');
					//回复完成后移除回复窗口
					$('.commentreply').remove();
				}else if(result.status == -1){
				var str = '';
                    $.each(result.Sensitive,function(name,value){
                    	str+=value+'&nbsp;';
                    });
                    var d = dialog({
						title: '提示',
						content: '评论包含敏感词汇'+str+'！请修改后重试...',
						cancel: false,
						okValue: '确定',
						ok: function () {
						}
					});
					d.showModal();
				}
				else
				{
					alert(result.msg);
				}
			}
		});

	}
	<?php }?>

	//课件评论异步加载
	function page_load(pagetxt,url){
		var cwid = $("#cwid").val();//课件id
        var pagetext = pagetxt;//分页按钮txt文本
        var page = 1;
        var groupid = $("#groupid").val();//用于判断是老师还是学生
        var curdomain = $("#domain").val();
        var cache = arguments[2]?1:0;
        //检查文本格式 *数字 * 上一页 * 下一页 * 跳转
        if(!isNaN(pagetext)){
                page = pagetext;
       	}else if(pagetext=='下一页&gt;&gt;'){
            lastp = parseInt($(".none").html());
            page = lastp+1;
        }else if(pagetext=='&lt;&lt;上一页'){
            lastp = parseInt($(".none").html());
            var np = lastp-1;
            page = ((np)<=0)?1:np;
        }else if(pagetext=='跳转'){
            page = $("#gopage").attr("value");
        }
        /**ajax后台读取json数据*/
        $.post(url,{'cwid':cwid,'page':page,'flushcache':cache},function(data){
        	var demohtml = '';
        	var json = data.reviews;
        	var domaina = window.location.href;
            var domain = domaina.replace("http://", "");
            var maina = domain.split('/');
            maina.splice(0, 1);
            maina.splice(maina.length - 1, 1);
            var last = maina.join("/");

            if(json!=''){
            	demohtml += '<div class="allcomments">'
            		+'<div class="alltitle">全部评论</div>'
            		+'<div class="allcommentslist">'
            		+'<ul class="ul1">';
            	//$('.allcomments').html('');

 				for (var i=0;i<json.length;i++){
 					if(i==(json.length-1)){
 						demohtml+='<li id="comment_'+json[i].logid+'" class="last">';
 					}else{
 						demohtml+='<li id="comment_'+json[i].logid+'">';
 					}

            		demohtml+='<div class="avatar-1"><img src="'+get_avatar(json[i])+'" class="circular" title="'+json[i].fromip+'('+json[i].ipaddress+')" /></div>'
            		+'<div class="commentsright">'
            		+'<div class="commentsright-top">'
            		+'<a href="http://sns.ebh.net/'+json[i].uid+'/main.html" target="_blank" class="studentname" title="'+json[i].fromip+'('+json[i].ipaddress+')" >'+json[i].username+'（'+json[i].realname+'）</a>';


            		demohtml+=getstar_new(json[i].score);
            		demohtml+='<span class="totalscore time">'+get_time(json[i].dateline)+'</span>'
            		+'</div>'
            		+'<div class="commentsright-center">'
            		+replace_em(json[i].subject)
            		+'</div>'
            		+'<div class="commentsright-bottom">';
            		<?php if($user['uid'] != 0) {?>
            		if(json[i].uid != <?=$user['uid']?>){
            			demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].logid+','+json[i].uid+',this)" tips="回复给'+json[i].realname+'：" type="courseware_reply">回复</a>'
            		}
            		<?php } ?>
            		if(json[i].uid == <?=$user['uid']?>){
            			demohtml+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+json[i].logid+',this);">删除</a>';

            		}
            		demohtml+='</div>';
            		//评论回复开始
            		if(json[i].children.length > 0){
            			demohtml+='<div class="commentlist">'
            			+'<div class="restore_arrow2"></div>'
            			+'<div class="commentlistson">'
            			+'<div class="commentlistsontop">';
            			var reply_arr = {count:0};
            			for (var second=0;second<json[i].children.length;second++){
            				if(typeof(reply_arr[json[i].children[second].uid]) == 'undefined'){
            					reply_arr[json[i].children[second].uid] = {
	            					avatar:get_avatar(json[i].children[second])
	            				}
	            				reply_arr.count++
            				}
            			}
            			reply_log[json[i].logid] = reply_arr;
            			demohtml+='<div class="peoplereplied"><span class="reply_count">'+reply_arr.count+'</span>个人回复：</div>'
            			+'<ul>';
            			var round = 0;
            			$.each(reply_arr,function(i,n){
            				if(i != 'count'){

            					demohtml+='<li><img src="'+n.avatar+'" class="circular" /></li>'

            					if(round == 9){
            						demohtml+=' <li><img src="http://static.ebanhui.com/ebh/tpl/2016/images/more.png" class="circular" /></li>';
            						return false;
            					}
            					round++;
            				}
            			});
            			demohtml+='</ul>'
            			+'<div  class="open-reply-btn"><a href="javascript:;" onclick="open_reply_dialog(this)" class="studentname open">展开&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/zhankai.png" class="openico" /></a></div>'
            			+' <div style="display:none;" class="close-reply-btn"><a href="javascript:;" onclick="close_reply_dialog(this)" class="studentname open">收起&nbsp;<img src="http://static.ebanhui.com/ebh/tpl/2016/images/shouqi.png" class="openico" /></a></div>'
            			+'</div>'
            			+'<div class="clear"></div>'
            			+'<div class="commentlistsonbottom" style="display:none;" >'
            			+'<ul><li><div class="replycomment"><ul>';
            			//二级评论开始
            			//for(var second in json[i].children){
            			for (var second=0;second<json[i].children.length;second++){
            				if(second == (json[i].children.length-1)){
            					demohtml+='<li class="replycommentli last" id="comment_'+json[i].children[second].logid+'">';
            				}else{
            					demohtml+='<li class="replycommentli" id="comment_'+json[i].children[second].logid+'">';
            				}

            				demohtml+='<div class="replycommentliright">'
            				+'<a href="http://sns.ebh.net/'+json[i].children[second].uid+'/main.html" target="_blank" class="studentname">'+json[i].children[second].username+'（'+json[i].children[second].realname+'）</a>'
            				+'<span class="totalscore">'+get_time(json[i].children[second].dateline)+'</span>'
            				+'<div class="commentsright-center">'
            				+replace_em(json[i].children[second].subject)
            				+'</div>'
            				+'<div class="commentsright-bottom ">';
            				<?php if($user['uid'] != 0) {?>
            				if(<?=$user['uid']?> == json[i].children[second].toid){
            					demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].children[second].logid+','+json[i].children[second].uid+',this)" tips="回复给'+json[i].children[second].realname+'：" type="courseware_reply_son">回复</a>'
		            		}
		            		<?php } ?>
		            		if(json[i].children[second].uid == <?=$user['uid']?>){
		            			demohtml+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+json[i].children[second].logid+',this);">删除</a>';

		            		}
		            		demohtml+='</div></div><div class="clear"></div>';
		            		//三级评论开始
		            		if(json[i].children[second].children.length > 0){
		            			demohtml+='<div class="replycommentson">'
		            			+'<ul>';
		            			//for(var third in json[i].children[second].children){
		            			for (var third=0;third<json[i].children[second].children.length;third++){
		            				if(third > 2){
		            					demohtml+='<li class="replycommentli1 first" style="display:none;" id="comment_'+json[i].children[second].children[third].logid+'" >';
		            				}else{
		            					demohtml+='<li class="replycommentli1 first" id="comment_'+json[i].children[second].children[third].logid+'" >';
		            				}
		            				demohtml+='<div class="replycommentliright">'
		            				+'<a href="http://sns.ebh.net/'+json[i].children[second].children[third].uid+'/main.html" target="_blank"  class="studentname">'+json[i].children[second].children[third].username+'（'+json[i].children[second].children[third].realname+'）</a>'
		            				+'<span class="comment">回复</span>'
		            				+'<a href="http://sns.ebh.net/'+json[i].children[second].children[third].toid+'/main.html" target="_blank" class="studentname">'+json[i].children[second].children[third].tousername+'（'+json[i].children[second].children[third].torealname+'）</a>'
		            				+'<span class="totalscore">'+get_time(json[i].children[second].children[third].dateline)+'</span>'
		            				+'<div class="commentsright-center">'
		            				+replace_em(json[i].children[second].children[third].subject)
		            				+'</div>'
		            				+'<div class="commentsright-bottom">';
		            				<?php if($user['uid'] != 0) {?>
		            				if(<?=$user['uid']?> == json[i].children[second].children[third].toid){
		            					demohtml+='<a href="javascript:;" class="studentname" onclick="make_reply_dialog('+json[i].children[second].logid+','+json[i].children[second].children[third].uid+',this)" tips="回复给'+json[i].children[second].children[third].realname+'：" type="courseware_reply_son">回复</a>'
				            		}
				            		<?php } ?>
				            		if(json[i].children[second].children[third].uid == <?=$user['uid']?>){
				            			demohtml+='<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+json[i].children[second].children[third].logid+',this);">删除</a>';

				            		}
				            		demohtml+='</div>'
				            		+'</div>'
				            		+'</li>';

		            			}
		            			demohtml+='</ul>';
		            			if(json[i].children[second].children.length > 3){
		            				demohtml+='<div class="viewall"><a href="javascript:;"  onclick="show_all(this)">点击查看全部</a></div>';
		            			}


		            			demohtml+='</div>';
		            		}
		            		//三级评论结束
		            		demohtml+='</li>';


            			}
            			//二级评论结束
		            	demohtml+='</ul></div></li> </ul> </div></div> </div>'
            		}
            		//评论回复结束
            		demohtml+='</div></li>';



            	}
            	demohtml+='</ul></div></div>';

            }
            $('.allcomments').html(demohtml);
            $('.allcomments').css('visibility','visible');
            $('#reviewcount').html(data.count);
            //分页处理
            $(".pages").html(data.pagestr);
            $(".pages a").unbind();

            $(".pages a").each(function(){
                $(this).removeAttr("href");
                $(this).css("cursor",'pointer');
                $(this).bind("click",function(){var pagetxt = $(this).html();page_load(pagetxt,url)});
                    //显示当前页
                var ptxt =$(this).html();
                if(!isNaN(ptxt) && ptxt == page){
                    $(this).addClass("none");
                }else{
                    $(this).removeClass("none");
                }
            })

        },'json')
	}

	//取星星
    function getstar_new(num)
    {
        var starword='';
        num=parseInt(num);
        if(num>5)
        {
            num=5;
        }
        for(i =0;i<num;i++)
        {
            starword+='<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars1.png">';
        }
        if(5-num>0)
        {
            for(j =0;j<5-num;j++)
            {
                starword+='<img class="cstar" src="http://static.ebanhui.com/ebh/tpl/2016/images/stars.png">';
            }
        }
        return starword;
    }

   	function getformatdate(timestamp)
	{
		var time = new Date(parseInt(timestamp) * 1000);
		var timestr = time.getFullYear()+"-"+
					(frontzero(time.getMonth()+1))+"-"+
					frontzero(time.getDate())+" "+
					frontzero(time.getHours())+":"+
					frontzero(time.getMinutes())+":"+
					frontzero(time.getSeconds());
		return timestr;
	}
	function frontzero(str)
	{
		str = str.toString();
		str.length==1?str="0"+str:str;
		return str;
	}


    	//分页开始加载
			var page = 1;
			var cwid = $("#cwid").attr("value");
			var url = "/course/getajaxpage.html";
			page_load(page,url);
</script>
<!--新评论JS结束-->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/tpl/default/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
/*自定义滚动条*/
(function($){

	$(window).load(function(){

		/* custom scrollbar fn call */

		$(".content_2").mCustomScrollbar({

			scrollInertia:150

		});

	});
})(jQuery);
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
</div>
</div>
<?php if (($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) && $check != 1) { ?>

	<style type="text/css">
.waigme {
	width:550px;
	height:290px;
	background-color:gray;
	border-radius:10px;
	display:none;
}
.nelame {
	width:530px;
	height:270px;
	margin:10px;
	float:left;
	display:inline;
	border: 8px solid rgba(255, 255, 255, 0.2);
	border-radius: 8px;
	box-shadow: 0 0 20px #333333;
	opacity: 1;
}
.nelame .leficos {
	width:125px;
	height:265px;
	float:left;
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/kaitongico0104.jpg) no-repeat 30px 32px;
}
.nelame .rigsize {
	width:375px;
	float:left;
	margin-top:25px;
}
.rigsize .tishitit {
	font-size:14px;
	color:#d31124;
	font-weight:bold;
	line-height:30px;
}
.rigsize .phuilin {
	line-height:2;
	color:#6f6f6f;
}
.nelame a.kaitongbtn {
	display:block;
	width:147px;
	height:50px;
	line-height:50px;
	background-color:#ff9c00;
	color:#fff;
	text-decoration:none;
	text-align:center;
	font-size:20px;
	float:left;
	font-family:"微软雅黑";
	font-weight:bold;
	margin-top:20px;
	border-radius:5px;
}
.nelame a.guanbibtn {
	float:left;
	color:#939393;
	font-size:14px;
	margin:40px 0 0 12px;
}
.video-play {margin-top:5px;}
</style>

<script type="text/javascript">
function openonline() {
	if($("#agreement").is(':checked') !=true) {
		alert("请先阅读并同意《e板会用户支付协议》。");
		return;
	}
	var url = "<?= empty($checkurl) ? 'http://'.$roominfo['domain'].'.ebh.net/classactive.html' : $checkurl ?>";
	document.location.href = url;
}
function closeWindows() {
         var browserName = navigator.appName;
         var browserVer = parseInt(navigator.appVersion);
         if(browserName == "Microsoft Internet Explorer"){
             var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;
             if (ie7)
             {
               window.open('','_parent','');
               window.close();
             }
            else
             {
               this.focus();
               self.opener = this;
               self.close();
             }
        }else{
            try{
                this.focus();
                self.opener = this;
                self.close();
            }
            catch(e){

            }

            try{
                window.open('','_self','');
                window.close();
            }
            catch(e){

            }
        }
    }

</script>
<div class="nelame" style="display:none;">
	<div style="width:530px;height:270px;background:#fff;">
		<div class="leficos">
		</div>
		<div class="rigsize">
		<h2 class="tishitit">对不起，您还未开通 <?= empty($payitem) ? '学习和作业功能' : $payitem['iname'] ?> 或服务已到期。</h2>
		<p style="font-weight:bold;">开通后您可以在学习课程和我的作业里进行在线学习和作业。</p>
		<p class="phuilin">在云教学网校，您可以随时随地在线学习、预习新课，复习旧知、记录和向老师提交笔记、在线做作业、在错题集里巩固错题、在线答疑、查看学习表、与老师，同学互动交流等。</p>
			<div class="czxy" style="padding-left:0px;padding-top:10px;">
				<input name="agreement" id="agreement" type="checkbox" value="1" checked="checked" />
				<label for="agreement" style="font-weight:bold;">我已阅读并同意《<a href="<?= geturl('agreement/payment') ?>" target="_blank" style="color:#00AEE7;">e板会用户支付协议</a>》
				</label>
			 </div>
		</div>

		<a href="javascript:openonline();" class="kaitongbtn">在线开通</a>
		<a href="<?= geturl('myroom') ?>" class="guanbibtn">返回首页</a>
	</div>
</div>
<?php } ?>
