  <script type="text/javascript">
  <!--

	function loadReady() {
		var h = demoIframe.contents().find("body").height();
		if (h < 600) h = 600;
		demoIframe.height(h);
	}

	function refresh(current){
		$(".menulist .current").removeClass("current");
		$("#li"+current).addClass('current');
	}
	


	$(function(){
		if($("#limyroom").length>0){
			refresh('setting');
		}else {
			refresh('mysetting');
		}
		
		
		//修改签名
		$("#mysign_span").click(function(){
			var mytitle = $("#mysign_span").attr("title");
			if (mytitle == '点击修改签名') mytitle = '';
			//显示输入框
			$("#mysign_span").hide();
			$("#mysign").show();
			$("#mysign").focus();
			$("#mysign").val(mytitle);
		});
		
		$("#mysign").blur(function(){
			var mysign = $("#mysign").val();
			var mytitle = $("#mysign_span").attr("title");
			if (mytitle == '点击修改签名') mytitle = '';
			//判断长度小于140字符
			if (mysign.length>140) {
				alert("签名请不要超过140个字");
				$("#mysign").focus();
				return false;
			};
			//有修改时保存
			if (mysign != mytitle)
			{
				//ajax保存
				$.ajax({
					url:"<?=geturl('home/profile/editmysign')?>",
					type:"post",
					data:{mysign:mysign},
					dataType:"json",
					success: function(data){
						if(data.code == 1){
							$("#mysign_span").html(data.mysign);
							if (mysign == '') mysign = '点击修改签名';
							$("#mysign_span").attr("title", mysign);
							$("#mysign").hide();
							$("#mysign_span").show();
						}
						else if(data.code == -1){
							alert(111);
							var str = '';
	                    	$.each(data.Sensitive,function(name,value){
	                    		str+=value+'&nbsp;';
	                    	});
	                    	alert('签名包含敏感词汇'+str+'！请修改后重试...');
							d.showModal();
							$("#mysign").hide();
							$("#mysign_span").show();
						}
						else
						{
							$("#mysign").hide();
							$("#mysign_span").show();
						}
					}
				});
			}
			else
			{
				//显示签名
				$("#mysign").hide();
				$("#mysign_span").show();
			}
		});	
	});


<?php $hszcrid = 10420; ?>	
  //-->
  </script>
  <style type="text/css">
	.examinationsuffix{
		background: url("http://static.ebanhui.com/ebh/tpl/default/images/icoce.png") no-repeat ;
	}
	.yunjiaoyu{
		background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -33px transparent;
	}	

	.score{
		background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon.png) no-repeat scroll 0 -531px transparent;
	}

	.gobuy {
		background: url(http://static.ebanhui.com/ebh/tpl/2012/images/clefticon0702.png) no-repeat scroll 0 -183px transparent;
	}
	.stuxinx {
		height:150px;
		background:#fff;
		float:left;
		width:186px;
		border-bottom: 1px solid #cecece;
	}
	.leftu {
		float:left;
		margin:10px 10px 0 10px;
		display:inline;
	}
	.menulist {
		width:188px;
		float:left;
	}
.menubox .menulist .stuxinx a {
    display: inline;
    font-size:12px;
    height:auto;
    line-height:normal;
    padding:0;
}
.menubox .menulist .stuxinx a:hover {
	background:none;
}
.rigpxiang {
	color:#9e9ea0;
	float:left;
	margin-top:10px;
}
.rigpxiang p {
	line-height:25px;
	word-wrap: break-word;
}
.rigpxiang p.jifenico {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/jifenico.jpg) no-repeat left center;
	padding-left:20px;
	margin-top:10px;
	height:15px;
	line-height:15px;
}
.touch li{
	padding-left:25px;
	display:inline;
}
.ejiants {
	float:left;
	height:25px;
	width:168px;
	margin-left:15px;
	display:inline;
	padding-top:10px;
}
.kewate {
	height:17px;
	float:left;
	margin-right:10px;
	padding:1px;
	display:inline;
	width:82px;
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/tuiwaibg.jpg) no-repeat;
}
.kewate span {
	 float: left;
    height: 17px;
    line-height: 13px;
	color:#315aaa;
	text-align:center;
	background:url(http://static.ebanhui.com/ebh/tpl/2014/images/tiaolibg.png)  repeat-x;
}
.evaluatesuffix {
	margin-top:4px;
	background: url("http://static.ebanhui.com/edu/images/evaluate.png") no-repeat;
}
.myhome{
	margin-top:4px;
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/myhome.png") no-repeat;
}
.eskthf {
	width: 168px;
	margin-left: 15px;
	display: inline;
	float: left;
	color:#999;
}
  </style>
		<div class="cleft">
			<div class="menubox">
			<div class="stuxinx">
						<div class="leftu">
							<?php 
								if($user['sex'] == 1)
									$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
								else
									$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
								$face = empty($user['face']) ? $defaulturl:$user['face'];
								$face = str_replace('.jpg','_78_78.jpg',$face);
							?>
							<a href="<?= geturl('home/profile/avatar') ?>" title="修改头像" target="mainFrame"><img style="width:78px;height:78px;" src="<?=$face?>" /></a>
						</div>
						<div class="rigpxiang">
											<?php
						$name = empty($user['realname'])?$user['username']:$user['realname'];
						$name = shortstr($name,12,'');
						?>
					<p style="color:#5a83a9;" title="<?=$user['username']?>" ><?=$name?></p>
							<p><a href="<?= geturl('home/profile') ?>" target="mainFrame">个人信息</a></p>
							<p class="jifenico"><a href="<?=geturl('home/score')?>" target="mainFrame" title="积分" style="color:#9e9ea0"><?=$user['credit']?></a></p>
						</div>
						<div class="ejiants">
						<div class="kewate">
						<span style="width:<?=$percent?>%;"><?=$percent?>%</span>
						</div>
						<a href="<?= geturl('home/profile')?>" target="mainFrame" style="color:#315aaa;">完善资料 ></a>
						</div>
						<div class="eskthf">
                        	<span id="mysign_span" style="display:block;width:152px;cursor:text;" title="<?=empty($user['mysign']) ? '点击修改签名' : $user['mysign']?>"><?=empty($user['mysign']) ? '暂无签名' : shortstr($user['mysign'])?></span>
                            <input type="text" maxlength="140" id="mysign" style="display:none;width:150px;border:1px solid #9eb7cb;height:20px;line-height:20px;padding:0 5px;">
                        </div>
					</div>
				<ul class="menulist">
					
				<?php
					if($room['domain']=='szzhzx'){
						$filter = array('mysetting','myask','review');
					}else{
						$filter = array();
					}
					
				?>
				<?php foreach ($modulelist as $module) { ?>
					<?php if(in_array($module['code'],$filter))continue;?>
                    <li id="li<?= $module['code']?>" class="li<?= $module['code']?>">
						<a href="<?= geturl('myroom/'.$module['code']) ?>" onclick="refresh('<?= $module['code']?>')" target="mainFrame"><i class="ui_ico <?= $module['code']?>suffix"></i><?= empty($module['nickname'])?$module['name']:$module['nickname']?></a>
					</li>
					
					<?php $gkccconfig = Ebh::app()->getConfig()->load('gkccconfig');
					if($module['code'] == 'stusubject' && in_array($room['crid'],$gkccconfig['parent'])){?>
					<li id="li<?= $module['code']?>cc" class="li<?= $module['code']?>">
						<a href="<?= geturl('myroom/'.$module['code'].'cc') ?>" onclick="refresh('<?= $module['code']?>cc')" target="mainFrame"><i class="ui_ico <?= $module['code']?>suffix"></i><?= $module['name']?>(高考冲刺)</a>
					</li>
					<?php }?>
                 <?php } ?>

				<?php $selectcourse = Ebh::app()->getConfig()->load('selectcourse');
				if (in_array($room['crid'], $selectcourse['crids'])) {?>
					<li id="liselectcourse" class="liclasssubject">
						<a href="<?= geturl('myroom/selectcourse') ?>" onclick="refresh('selectcourse')" target="mainFrame"><i class="ui_ico selectcoursesuffix"></i>在线选课</a>
					</li>
				<?php }?>
					<li id="lisurvey" class="lisurvey">
						<a href="<?= geturl('myroom/survey/surveylist') ?>" onclick="refresh('survey')" target="mainFrame"><i class="ui_ico surveysuffix"></i>调查问卷</a>
					</li>
				<?php foreach($roompers as $per) { ?>
					<li id="li<?= $per['crid'] ?>" class="lifullcourse">
						<a href="<?= geturl('myroom/fullcourse-0-0-0-'.$per['crid']) ?>" onclick="refresh('<?= $per['crid'] ?>')" target="mainFrame"><i class="ui_ico fullcoursesuffix"></i><?= $per['crname'] ?></a>
					</li>
				<?php } ?>

                                <?php if(($room['isschool']==3 || $room['isschool']==6) && $room['domain'] != 'jx') { ?>
                                	<?php if($room['domain']!='szzhzx'){?>
					<li id="li<?= $helpcrid?>" class="lihelpsuffix">
						<a href="<?= geturl('myroom/fullcourse/lists-1-0-0-'.$helpcrid.'-'.$helpcid)?>" onclick="refresh('<?= $helpcrid ?>')" target="mainFrame"><i class="ui_ico helpsuffix"></i>帮助中心</a>
					</li>
									<?php }?>
                                <?php } ?>
				</ul>
			</div>
                        <?php if($room['isschool'] == 4) { ?>
				<div class="touchs">
					<ul>
						<li class="yues">
							<i class="ui_ico xuedianyue"></i>学点余额：<span style="font-weight:bold;"></span>点
						</li>
						<li class="xuedian">
							马上在线&nbsp;<a href="/sitecp.php?action=classrbalance" style="color:#0099cc;font-weight:bold;" target="_blank">购买学点</a>
						</li>
					</ul>
				</div>
                        <?php } ?>
			<!-- =================== -->
			<?php if(($room['isschool']==7)){?>
			<?php
				$memberlib = Ebh::app()->lib('Member');
				if($memberlib==null)
					$memberlib = Ebh::app()->member;
				$leftinfo = $memberlib->getleftinfo($user['uid']);
				$menuid = empty($menuid)?0:$menuid;
				$currmenu = array('','','','','','');
				$currmenu[$menuid]=' current';
				if(!empty($user['face']))
					$face = $user['face'];
				elseif($user['sex'] == 0)
					$face = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_120_120.jpg';
				else
					$face = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_120_120.jpg';
			?>

			<?php }?>
			
			<!-- 个人中心 start-->
			<div class="menubox" style="margin-top:10px;">
				<ul class="menulist">
					<li class="liprofile" id="liprofile">
						<a target="mainFrame" onclick="refresh('profile')" href="/home/profile.html"><i class="ui_ico myprofile"></i>个人信息</a>
					</li>
					<li class="liinfocenter" id="liinfocenter" style="display:none">
						<a target="mainFrame" onclick="refresh('infocenter')" href="/home/infocenter.html"><i class="ui_ico myinfocenter"></i>学习空间</a>
					</li>
					<!--<li class="lilargedb" id="lilargedb">
						<a target="mainFrame" onclick="refresh('largedb')" href="/home/largedb.html"><i class="ui_ico mylargedb"></i>历史数据</a>
					</li>-->
					<li class="liscore" id="liscore">
						<a target="mainFrame" onclick="refresh('score')" href="/home/score.html"><i class="ui_ico myscore"></i>积分计划</a>
					</li>
					<li class="lischool" id="lischool">
						<a target="mainFrame" onclick="refresh('school')" href="/home/school.html"><i class="ui_ico myschool"></i>我的网校</a>
						<?php if($roomcount>0){ ?><span><?= $roomcount;?></span><?php } ?>
					</li>
					<li class="lihome" id="lihome">
                        <a target="_blank"  href="http://sns.ebh.net"><i class="ui_ico myhome"></i>我的空间</a>
                    </li>
	             </ul>
			</div>
			<!-- 个人中心 end -->
            
            <!-- 我的空间 start-->
			<!--<div class="menubox" style="margin-top:10px;">
				<ul class="menulist">
                    <li class="lihome" id="lihome">
                        <a target="_blank"  href="http://sns.ebh.net"><i class="ui_ico myhome"></i>我的空间</a>
                    </li>
	             </ul>
			</div>-->
			 <!-- 我的空间 end-->
			
			<!-- ====================== -->
			<?php if(($room['crid'] != $hszcrid) && (!empty($room['cremail']) || !empty($room['crphone']) || !empty($room['crqq']))) {?>
			<?php
				$cremail = str_replace('http://','',$room['cremail']);
			?>
			<div class="touch">
				<ul>
					<?php if(!empty($cremail)){ ?>
					<li class="email"><a target="_blank;" title="http://<?= $cremail?>" href="http://<?=$cremail?>" style="width:100px;word-wrap: break-word;"><?= $cremail ?></a></li>
					<?php } ?>
					<?php if(!empty($room['crphone'])){ ?>
					<li class="phone"><?= $room['crphone'] ?></li>
					<?php } ?>
					<?php if(!empty($room['crqq'])){ ?>
					<li class="qq"><a style="float:left;" target="_blank;" title="QQ联系" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq']?>&amp;site=qq&amp;menu=yes"><?= $room['crqq']?></a></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
		</div>
