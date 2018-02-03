<?php $this->display('myroom/page_header'); ?>
<div class="ter_tit">
	当前位置 > 我的教室
</div>
<div class="lefrig">

<div class="annuato">
		<span style="float:left;height:22px;line-height:22px;">关键字：</span>
		<input name="searchfvalue" id="searchfvalue" type="text" value="请输入您要搜索的课程名称" style="width:350px;height:20px; float:left;line-height:22px; font-size:14px;padding-left: 5px;color:#CDCDCD;border:solid 1px #cdcdcd;">&nbsp;
		<input class="souhuang" style="*margin-top:-18px;" type="button" name="searchbutton" id="searchfname" value="搜索" />
</div>
	<SCRIPT LANGUAGE="JavaScript">
<!--
var tips = '请输入您要搜索的课程名称';
	$(function(){
		initsearch('searchfvalue',tips);

		$('#searchfname').click(function(){
			var href = '<?= geturl('myroom/subject') ?>';
			var searchvalue = $("#searchfvalue").val();
			if(searchvalue=='请输入您要搜索的课件名称'){
				searchvalue='';
			}
			location.href = href+"?q="+searchvalue;
		});
		
	});
//-->
</SCRIPT>
<style type="text/css">
.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover { background-color:#0087B2;}
.hover img { border:1px solid #0087B2;}
.hover{border: 1px solid #0099cc;}
</style>

				<script type="text/javascript">
				function tofolder(fid){
					var theurl = '<!--{eval echo geturl("myroom/coursewarelist-1-0-0-".$crid."-'+fid+'")}-->';
					location.href=encodeURI(theurl);
				}
				$(function(){
				    var stu_courseware_li =$(".stu_courseware_list li");
				    stu_courseware_li.hover(function(){
						$(this).addClass("stu_current");
					},function(){
						$(this).removeClass("stu_current");
					})
					
					$(".room_other_list img").each(function(){
						$(this).mouseover(function(){
							$(".room_other_list img").stop().animate({opacity: 1.0}, "slow");
							$(this).stop().animate({opacity: 0.6}, "slow");
						}).mouseout(function(){
							$(".room_other_list img").stop().animate({opacity: 1.0}, "slow");
						});
					});

				    $(function(){
				    	$("#freeul li").hover(function(){
				    		$(this).addClass("hover-trigger");
				    		$(this).siblings().find("img").stop().animate({opacity:'0.3'},1000);
				    	},
				    	function(){
				    		$(this).removeClass("hover-trigger");
				    		$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
				    	});
				    });
				})

				</script>
				
				<div class="school">
					<div class="othe_tit">
					<h2>(<?= $roominfo['crname'] ?>)<span style="font-weight:normal; color:#000;font-size:12px;"><?= $roominfo['coursenum'] ?>课时</span></h2>
					<a class="lanbtn100" href="<?= geturl('myroom/subject') ?>" style="color:#fff;left: 615px;position: absolute;top:-52px;">开始学习</a>
					</div>
					<div class="s_content">
						<div class="portraits">
							<a class="portrait" href="<?= geturl('myroom/subject/choose') ?>">
								<img src="<?= empty($roominfo['cface']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/face/4.jpg' : $roominfo['cface'] ?>" /></a></div>
								<div class="shuom">
									<p>
										服务到期时间：
										<em style=" color:#014fb0; font-weight:bold; padding-right:10px;"><?= !empty($userdetail['enddate'])?date('Y-m-d',$userdetail['enddate']):'无限制' ?></em>
										上次登录时间：
										<em style="padding-right:10px;"><?= $user['lastlogintime'] ?></em>
										上次登录IP：
										<em><?= $user['lastlogintime'] ?></em>
									</p>
								</div>
								<div class="rig_info">
									<p><?= shortstr($roominfo['summary'],400) ?></p>
								</div>
							
					</div>
				</div>
				
			
		            <div class="othe">
							<div class="work_menuss" style="margin-bottom:0;">
							<ul>
							<li class="workcurrent"><a style="font-size:12px;"><span><?= $haschoose == 1 ? '我已选择的课程' : '推荐的课程'?></span></a></li>
							</ul>
							<a class="lanbtn100" href="<?= geturl('myroom/subject/choose') ?>" style="color:#fff;float:right;margin-right:10px;">我要选课</a>
						</div>
						
						<div class="s_content" style="border:solid 1px #d9d9d9;border-top:none;overflow:none;height:800px;">
							<div class="s_content_list">
								<ul class="clearfix" id="freeul" style="width:750px;">
								
								<?php foreach($folders as $folder) { ?>
						                <li>
						                  <a class="img-shadow" href="<?= geturl('myroom/subject/'.$folder['folderid']) ?>">
						                  	<img src="<?= empty($folder['img'])?'http://static.ebanhui.com/ebh/images/nopic.jpg':$folder['img'] ?>"  width="114" height="159"/>
						                  </a>  
						                  <h4 class="wsize">
						                  	<a href="<?= geturl('myroom/subject/'.$folder['folderid']) ?>"><?= $folder['foldername'].'('.$folder['coursewarenum'].')' ?></a>
						                  </h4>
						                </li>
								<?php } ?>
								</ul>
							</div>
						</div>
					</div>
            </div>
<?php $this->display('myroom/page_footer'); ?>