  <script type="text/javascript">

	function refresh(current){
		$(".menulist .current").removeClass("current");
		$(".extendlist .current").removeClass("current");
		$("#li"+current).addClass('current');
	}
  	
	$(function(){
<?php if($room['domain'] == 'zjgxedu') {?>
		refresh('classsubject');
<?php }else if($room['domain'] == 'lcyhg'){ ?>
		refresh('classexam');
<?php }else {?>
		if($("#lisetting").length>0){
			refresh('mysetting');
		}else {
			refresh('mysetting');
		}
<?php } ?>
		$(".extendlist li").click(function(){$(".menulist .current").removeClass("current");$(this).addClass("current");});
		
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
					url:"<?=geturl('teacher/setting/editmysign')?>",
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
		float:left;
		width:188px;
		background:#fff;
		border-bottom: 1px solid #f1f1f1;
	}
	.leftu {
		float:left;
		margin:10px 10px 0 10px;
		display:inline;
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
.menulist {
	float:left;
	width:188px;
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
}
.ejiants {
	float:left;
	height:25px;
	width:165px;
	margin-left:15px;
	display:inline;
	padding-top:10px;
}
.kewate {
	height:17px;
	float:left;
	margin-right:10px;
	padding:1px;
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
.authement{
	margin-top:4px;
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/authement.png") no-repeat;
	}
.menubox .menulist a:hover{ background:#e1f2ff;}
.current{background: #e1f2ff; border-top:1px solid #b8e1ff; border-bottom:1px solid #b8e1ff;}
  </style>
<?php $hszcrid = 10420; ?>	

<div class="cleft">
	<div class="leku"></div>
	<div class="menubox">
			<?php if($hszcrid != $room['crid']) { ?>
			<div class="stuxinx">
				<div class="leftu">
					<?php 
						if($user['sex'] == 1)
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
						else
							$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
						$face = empty($user['face']) ? $defaulturl:$user['face'];
						$face = str_replace('.jpg','_78_78.jpg',$face);
					?>
					<a href="<?= geturl('teacher/setting/avatar') ?>" title="修改头像" target="mainFrame"><img style="width:78px;height:78px;" src="<?=$face?>" /></a>
				</div>
				<div class="rigpxiang">
				<?php
						$name = empty($user['realname'])?$user['username']:$user['realname'];
						$name = shortstr($name,12,'');
						?>
					<p style="color:#5a83a9;" title="<?=$user['username']?>" ><?=$name?></p>
					<p><a href="<?= geturl('teacher/setting/rprofile') ?>" target="mainFrame">个人信息</a></p>
					<p class="jifenico"><a href="<?=geturl('home/score')?>" target="mainFrame" title="积分" style="color:#9e9ea0"><?=$user['credit']?></a></p>
				</div>
				<div class="ejiants">
				<div class="kewate">
				<span style="width:<?=$percent?>%;"><?=$percent?>%</span>
				</div>
				<a href="<?= geturl('teacher/setting/rprofile')?>" target="mainFrame" style="color:#315aaa;">完善资料 ></a>
				</div>				
                <div class="eskthf">
                    <span id="mysign_span" style="display:block;width:152px;cursor:text;" title="<?=empty($user['mysign']) ? '点击修改签名' : $user['mysign']?>"><?=empty($user['mysign']) ? '暂无签名' : shortstr($user['mysign'])?></span>
                    <input type="text" maxlength="140" id="mysign" style="display:none;width:150px;border:1px solid #9eb7cb;height:20px;line-height:20px;padding:0 5px;">
                </div>
			</div>
		<?php } ?>
		<ul class="menulist">

                        <?php
                        $lcyhgarr = array('classsubject','classexam','myask','statisticanalysis','teaexam');//lcyhgarr只保留如上四项 
						$zjgxeduarr = array('mysetting','classexam','classpaper','statisticanalysis','teaexam');
						foreach($modulelist as $catitem) { 
							if($room['domain'] == 'zjgxedu' && in_array($catitem['code'],$zjgxeduarr))
								continue;
							if($room['domain'] == 'zjgxedu' && $catitem['code'] == 'myask')
								$catitem['name'] = '讨论专区';
							if($room['domain'] == 'lcyhg' && !in_array($catitem['code'],$lcyhgarr)){
								continue;
							}
						?>
					<li id="li<?= $catitem['code'] ?>" class="li<?= $catitem['code'] ?>">
						<a href="<?= geturl('troomv2/'.$catitem['code']) ?>" onclick="refresh('<?= $catitem['code']?>')" target="mainFrame"><i class="ui_ico <?= $catitem['code']?>suffix"></i><?= ($room['crid']==10412&&$catitem['code']=='classsubject')?'校本资源库':$catitem['name']?></a>
					</li>
                        <?php } ?>

        <?php $selectcourse = Ebh::app()->getConfig()->load('selectcourse');
		if (in_array($room['crid'], $selectcourse['crids'])) {?>
			<li id="liselectcourse" class="liselectcourse"><a href="<?=geturl('troomv2/selectcourse/courselist')?>" onclick="refresh('selectcourse')" target="mainFrame"><i class="ui_ico selectcoursesuffix"></i>选课管理</a></li>
		<?php }?>
        <?php $examapply = Ebh::app()->getConfig()->load('examapply');
		if (in_array($room['crid'], $examapply['crids'])) {?>
			<li id="liexamapply" class="liexamapply">
				<a href="<?=geturl('troomv2/examapply')?>" onclick="refresh('examapply')" target="mainFrame"><i class="ui_ico authement"></i>认证管理</a>
		<?php }?>
			</li>
                <?php foreach($roompers as $per) { ?>
			<li id="li<?= $per['crid']?>" class="lifullcourse">
				<a href="<?= geturl('troomv2/fullcourse-0-0-0-'.$per['crid'])?>" onclick="refresh('<?= $per['crid']?>')" target="mainFrame"><i class="ui_ico fullcoursesuffix"></i><?= $per['crname']?></a>
			</li>
                <?php } ?>
                <?php if(0 && ($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7 && $room['domain'] != 'jx')) { ?>
		<li id="li<?= $helpcrid ?>" class="lihelpsuffix">
				<a href="<?= geturl('troomv2/fullcourse/lists-1-0-0-'.$helpcrid.'-'.$helpcid)?>" onclick="refresh('<?= $helpcrid ?>')" target="mainFrame"><i class="ui_ico helpsuffix"></i>帮助中心</a>
			</li>
                <?php } ?>
				
				<?php if($room['domain'] != 'lcyhg'){ ?><!--lcyhg暂时隐藏此链接 -->
					<li class="lihome" id="lihome">
							<a target="_blank"  href="http://sns.ebh.net"><i class="ui_ico myhome"></i>我的空间</a>
					</li>
				<?php } ?>
		<?php if(!empty($moduleyunpan)){?>
			<li class="liyunpan" id="liyunpan">
				<a target="_blank"  href="<?=$moduleyunpan['url']?>"><i class="ui_ico yunpansuffix"></i>我的<?=empty($moduleyunpan['nickname'])?$moduleyunpan['modulename']:$moduleyunpan['nickname']?></a>
			</li>
		<?php }?>
		</ul>
		
	</div>

    <!-- 我的空间 start-->
   <!-- <div class="menubox" style="margin-top:10px;">
        <ul class="menulist">
            <li class="lihome" id="lihome">
                <a target="_blank"  href="http://sns.ebh.net"><i class="ui_ico myhome"></i>我的空间</a>
            </li>
         </ul>
    </div>-->
     <!-- 我的空间 end-->

        <?php if($room['isschool'] == 2 || $room['isschool'] == 4) { ?>
	<div class="extendbox">
		<ul class="extendlist">
			<li><a target="mainFrame" href="<?= geturl('troomv2/tplsetting') ?>"><i class="ui_ico tplsettingssuffix"></i>模板设置</a></li>
		</ul>
	</div>
        <?php } ?>
		<?php if(($hszcrid != $room['crid'])&&(!empty($room['cremail']) || !empty($room['crphone']) || !empty($room['crqq']))) { ?>
	<div class="touch">
		<ul>
			<?php if(!empty($room['cremail'])){ ?>
			<?php $cremail = str_replace('http://','',$room['cremail']);?>
			<li class="email"><a target="_blank;" title="http://<?= $cremail ?>" href="http://<?= $cremail ?>" style="width:100px;word-wrap: break-word;"><?= $cremail ?></a></li>
			<?php } ?>
			<?php if(!empty($room['crphone'])){ ?>
			<li class="phone"><?= $room['crphone'] ?></li>
			<?php } ?>
			<?php if(!empty($room['crqq'])){ ?>
            <li class="qq"><?php if(!empty($room['crqq'])) { ?><a title="QQ联系" target="_blank;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?= $room['crqq'] ?>&amp;site=qq&amp;menu=yes"><?= $room['crqq'] ?></a><?php } ?></li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
</div>
