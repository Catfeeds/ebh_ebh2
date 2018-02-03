<?php $this->display('troomv2/room_header');?>
<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
.lefrigs{
	margin:0 auto;
	margin-top:10px;
	width:1000px;
}
.diles{
	top:10px;
}
</style>
<!--<div class="cmain_bottoms cmain_bottoms2 cmain_top_r " style="margin-bottom:5px;padding-bottom:0;">
<div class="esukangs">
<a class="subtop jiancha fl" target="mainFrame" href="/troomv2/tastulog.html" title="学生监察">学生监察</a>
 <a class="subtop tongji fl" target="mainFrame" href="#" title="教学统计">教学统计</a>
</div>
</div> -->
<div class="lefrigs"><div class="lefrig">
<?php 
$this->assign('data_index',7);
$this->display('troomv2/data_menu');
?>
<style type="text/css">
.card-body {width:900px;padding: 20px 30px 50px;; margin:0 auto;}
.essinfor_top{ height:27px; line-height:27px;width:900px;margin:0; border-bottom:1px solid #e1e1e1; padding-bottom:10px;}
.essinfor_top .title{ width:595px; padding:0 !important;}
.essinfor_top .title h3{ color:#333; background:url("http://static.ebanhui.com/ebh/tpl/2014/images/pico1.jpg") no-repeat left center; padding-left:30px; height:27px; font-size:14px; font-weight:bold;}
.essinfor_top a.hrelh {background:url("http://static.ebanhui.com/ebh/tpl/2014/images/xiudty.jpg") no-repeat left center;color: #2796f0;display: block;float: right;height: 24px;line-height: 24px;padding-left: 20px;text-align: center;text-decoration: none;width: 45px;}
.essinfor_bottom{ line-height:32px; font-size:14px; min-height:210px;}
.essinfor_bottom ul li{ width:360px; }
.essinfor_bottom .span1{ color:#333;margin-left:0px;font-family:"微软雅黑";}
.essinfor_bottom .span2{ color:#666;font-weight:normal;}
ul li.essinfor_bottoms{ width:684px; border:1px solid #e6e6e6; padding:10px 20px;}
.essinfor_tops{ height:27px; line-height:27px; padding-bottom:10px;margin:0px;width:900px;}
.essinfor_tops .title{ width:595px; padding:0 !important;}
.essinfor_tops .title h3{ font-size:14px; font-weight:bold;color:#333; background:url("http://static.ebanhui.com/ebh/tpl/2014/images/pico2.jpg") no-repeat left center; padding-left:30px; height:27px;}
.essinfor_tops a.hrelh {background:url("http://static.ebanhui.com/ebh/tpl/2014/images/xiudty.jpg") no-repeat left center;color: #2796f0;display: block;float: right;height: 24px;line-height: 24px;padding-left: 20px;text-align: center;text-decoration: none;width: 45px;}
.essinfor_bottoms .date{ font-weight:bold; font-size:14px; color:#333; display:block; padding-bottom:7px;}
.essinfor_bottoms .olddescription{ font-size:13px; color:#606060; word-wrap: break-word; width:696px;}
.essinfor_bottoms .action {display: none;}
.essinfor_bottoms .action .icons {background-color: #abc0e9;border-radius: 2px;color: #fff;cursor: pointer;font-size: 12px;line-height: 18px;margin-left: 10px;padding: 3px 7px;}
.essinfor_bottom .span1s{ position:relative; top:-50px;}
.essinfor_bottom textarea{ font-size:14px;  padding:10px; line-height:23px;letter-spacing: 2px;}
.card-body .essinfor input{ width:260px; border:1px solid #e1e1e1; height:24px; line-height:24px; padding-left:5px;}
.fkrer { display: inline;float: right; height: 50px;padding: 10px 0 0;}
.fkrer a.huibtn {border: none;color: #fff;cursor: pointer;display: block;float: left;font-size: 14px;height: 32px;line-height: 32px;text-align: center;text-decoration: none; width: 87px;}
.fkrer a.lanbtn {background: #18a8f7 ;border: medium none;color: #fff;cursor: pointer;display: block;float: left;font-size: 14px;font-weight: bold;height: 32px;line-height: 32px;text-align: center;text-decoration: none; width: 87px;}
.essinfor_bottoms{ font-size:14px; font-family:"微软雅黑";}
.neirongs{ border:1px solid #e1e1e1; width:684px; height:100px; padding:10px 20px; color:#666;}
 .span2s{ position:relative; top:-25px;}
 .xqah .essinfor_bottom ul li{ height:64px;}
.expedit{font-size: 13px;}
.expedit input{ width:240px; border:1px solid #e1e1e1; height:24px; line-height:24px; padding-left:5px;}
.xqahs .essinfor_bottom ul li{*margin-top:10px;}
.xqahs .essinfor_bottom ul li{ line-height:18px;}
</style>
<div class="clear"></div>
		<div class="card-body">
			<div class="essinfor">
		        <div class="jizl">
		            <div class="essinfor_top">
		                <div class="title fl"><h3>基本资料</h3></div>
		            </div>
		            <div class="clear"></div>
		            <div class="essinfor_bottom">
		                <ul>
							<li class="fl">
								<span class="span1">姓　　名：</span><span id="cnname_span" class="span2"><?=$memberdetail['realname'] ?></span><input type="text" style="display:none;" value="<?=$memberdetail['realname']?>" id="cnname" maxlength="18"/>
							</li>
							<li class="fl">
								<span class="span1">性　　别：</span><span id="sex_span" class="span2"><?= $memberdetail['sex'] == 1 ? '女' : '男' ?></span>
								<span id="sex" style="display:none;">
									<label>
										<input type="radio" value="0" name="sex" <?php if($memberdetail['sex'] == 0) echo 'checked="checked";'?> style="width:16px; position:relative;top:7px;*top:2px; border:none;" /><span class="span2">男</span>
									</label>&nbsp;
									<label>
										<input type="radio" value="1" name="sex" <?php if($memberdetail['sex'] == 1) echo 'checked="checked";'?> style="width:16px; position:relative;top:7px;*top:2px; border:none;" /><span class="span2">女</span>
									</label>
								</span>
							</li>
							<li class="fl"><span class="span1">昵　　称：</span><span id="nickname_span" class="span2"><?=$memberdetail['nickname'] ?></span><input type="text" style="display:none;" value="<?=$memberdetail['nickname']?>" id="nickname" maxlength="20"/></li>
		                    <li class="fl"><span class="span1">出生日期：</span><span  id="birthdate_span" class="span2"><?=$memberdetail['birthdate']?Date('Y-m-d',$memberdetail['birthdate']):''?></span><input id="birthdate" class="Wdate" style="display:none" type="text" value="<?=$memberdetail['birthdate']?Date('Y-m-d',$memberdetail['birthdate']):'1991-01-01'?>" onClick="WdatePicker()"></li>
							<li class="fl">
								<span class="span1">手机号码：</span><span id="mobile_span" class="span2"><?=$memberdetail['mobile']?></span><input type="text" style="display:none;" id="mobile" value="<?= $memberdetail['mobile'] ?>" />
							</li>
							<li class="fl">
								<span class="span1">电话号码：</span><span id="phone_span" class="span2"><?=$memberdetail['phone']?></span><input type="text" style="display:none;" id="phone" value="<?= $memberdetail['phone'] ?>" />
							</li>
							<li class="fl"><span class="span1">Q　　 Q：</span><span id="qq_span" class="span2"><?=$memberdetail['qq']?></span><input type="text" style="display:none;" id="qq" value="<?= $memberdetail['qq'] ?>" /></li>
							<li class="fl"><span class="span1">微信账号：</span><span id="msn_span" class="span2"><?=$memberdetail['msn']?></span><input type="text" style="display:none;" id="msn" value="<?= $memberdetail['msn'] ?>" /></li>
							<li class="fl"><span class="span1">联系邮箱：</span><span id="email_span" class="span2"><?=$memberdetail['email']?></span><input type="text" style="display:none;" id="email" value="<?= $memberdetail['email'] ?>" /></li>
							<li class="fl" style="width:715px;">
								<span class="span1" style="float:left;">现居住地：<input type="hidden" id="old_citycode" value="<?=$memberdetail['citycode']?>" /></span>
								<div>
									<span class="span2" id="citycode_span">
									<?php
									if(!empty($memberdetail['citycode']))
									{
									$this->widget('cities_widget',array('citycode'=>$memberdetail['citycode'],'getText'=>1,'tag'=>'zzz2'));
									}
									?>
									</span>
									<span class="span2" id="address_span"><?=$memberdetail['address']?></span>
									<div style="display:none;float:left;" id="citycode">
									<?php
									$this->widget('cities_widget',array('citycode'=>$memberdetail['citycode'],'tag'=>'zzz1'));
									?>
									</div>
								</div>
							</li>
							<li class="fl mt5" style="display:none;width:726px;" id="address_li">
								<span class="span1" id="address_title" style="float:left;">详细地址：</span>
								<div style="width:656px;float:left;">
									<textarea id="address" style="resize:none;width:605px; height:40px; border:1px solid #e1e1e1;"><?=$memberdetail['address']?></textarea>
								</div>
							</li>
							<li class="fl mt5" style="width:726px;">
								<span class="span1" style="float:left;">个人简介：</span>
								<div style="width:627px;float:left;">
									<span id="profile_span" class="span2" style="width:627px;"><?=$memberdetail['profile']?></span>
									<textarea id="profile" style="resize:none;display:none;width:605px; height:100px;border:1px solid #e1e1e1;"><?=$memberdetail['profile']?></textarea>
								</div>
							</li>
		                    <li class="fl mt10"><span class="span1">家长姓名：</span><span id="familyname_span" class="span2"><?=$memberdetail['familyname']?></span><input type="text" style="display:none;" id="familyname" value="<?= $memberdetail['familyname'] ?>" /></li>
		                    <li class="fl mt10"><span class="span1">家长电话：</span><span id="familyphone_span" class="span2"><?=$memberdetail['familyphone']?></span><input type="text" style="display:none;" id="familyphone" value="<?= $memberdetail['familyphone'] ?>" /></li>
		                    <li class="fl"><span class="span1">家长职业：</span><span id="familyjob_span" class="span2"><?=$memberdetail['familyjob']?></span><input type="text" style="display:none;" id="familyjob" value="<?= $memberdetail['familyjob'] ?>" /></li>
		                    <li class="fl"><span class="span1">家长邮箱：</span><span id="familyemail_span" class="span2"><?=$memberdetail['familyemail']?></span><input type="text" style="display:none;" id="familyemail" value="<?= $memberdetail['familyemail'] ?>" /></li>
		                </ul>
		            </div>
					<div class="fkrer" style="display:none" id="btn_info">
						<a href="javascript:;" class="huibtn" onclick="cancelinfo()" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
						<a href="javascript:;" class="lanbtn" onclick="saveinfo()">保 存</a>
					</div>
		        </div>
		        <div class="clear"></div>
		        <div class="xqahs mt40">
		            <div class="essinfor_top">
		                <div class="title fl"><h3>兴趣爱好</h3></div>
		            </div>
		            <div class="clear"></div>
		            <div class="essinfor_bottom mt10">
		                <ul>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">兴趣爱好：</span>
								<div style="width:645px;float:left;">
									<span id="hobbies_span" class="span2" style="width:645px;"><?=$memberdetail['hobbies']?></span>
									<textarea id="hobbies" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['hobbies']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">喜欢音乐：</span>
								<div style="width:645px;float:left;">
									<span id="lovemusic_span" class="span2" style="width:645px;"><?=$memberdetail['lovemusic']?></span>
									<textarea id="lovemusic" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovemusic']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px;">
								<span class="span1" style="float:left">喜欢电影：</span>
								<div style="width:645px;float:left;">
									<span id="lovemovies_span" class="span2" style="width:645px;"><?=$memberdetail['lovemovies']?></span>
									<textarea id="lovemovies" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovemovies']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">玩的游戏：</span>
								<div style="width:645px;float:left;">
									<span id="lovegames_span" class="span2" style="width:645px;"><?=$memberdetail['lovegames']?></span>
									<textarea id="lovegames" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovegames']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px;">
								<span class="span1" style="float:left">喜欢动漫：</span>
								<div style="width:645px;float:left;">
									<span id="lovecomics_span" class="span2" style="width:645px;"><?=$memberdetail['lovecomics']?></span>
									<textarea id="lovecomics" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovecomics']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">玩的运动：</span>
								<div style="width:645px;float:left;">
									<span id="lovesports_span" class="span2" style="width:645px;"><?=$memberdetail['lovesports']?></span>
									<textarea id="lovesports" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovesports']?></textarea>
								</div>
							</li>
							<li class="fl mt10" style="width:715px; ">
								<span class="span1" style="float:left">喜欢书籍：</span>
								<div style="width:645px;float:left;">
									<span id="lovebooks_span" class="span2" style="width:645px;"><?=$memberdetail['lovebooks']?></span>
									<textarea id="lovebooks" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovebooks']?></textarea>
								</div>
							</li>
		                </ul>
		            </div>
					<div class="fkrer" style="display:none" id="interest_info">
						<a href="javascript:;" class="huibtn" id="interest_cancel" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
						<a href="javascript:;" class="lanbtn" id="interest_save">保 存</a>
					</div>
		        </div>
		        <div class="clear"></div>
		        <div class="jinglis mt30">
		            <div class="essinfor_tops">
		                <div class="title fl"><h3>过往经历</h3></div>
		            </div>
					<!--expadd begin-->
					<div id="expadd_div" style="display:none;">
						<div class="essinfor_bottoms" style="border-top:1px solid #e1e1e1; padding-top:15px;">
							<div class="dates " >
								<div class="fl" ><span class="span1s">开始时间：</span><input type="text" value="" class="begindate" /></div>
								<div class="fl"><span class="span1s" style="padding-left:15px;">结束时间：</span><input type="text" value="" class="enddate" /></div>
							</div>
							<div class="clear"></div>
							<div class="neirong mt15">
								<div class="titless">描述过往经历（小于200字）：</div>
								<div class="mt10">
									<textarea class="neirongs" style="resize:none;"></textarea>
								</div>

							</div>

						</div>
						<div class="clear"></div>
						<div class="fkrer">
							<a href="javascript:;" class="huibtn" id="expadd_cancel" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
							<a href="javascript:;" class="lanbtn" id="expadd_save" >保 存</a>
						</div>
						<div class="clear"></div>

					</div>
					<!--expadd end-->
					<ul id="explist">
					<?php foreach($explist as $exp){?>
						<li class="essinfor_bottoms mt15" id="exp_<?=$exp['expid']?>">
							<div class="expshow">
								<div class="action fr"><span class="icons edit">编辑</span><span class="icons remove">删除</span></div>
								<div class="date"><span class="oldbegindate"><?=$exp['begindate']?></span> — <span class="oldenddate"><?=$exp['enddate']?></span></div>
								<div><p class="olddescription"><?=$exp['description']?></p></div>
							</div>

						</li>
					<?php } ?>
					</ul>
		        </div>

		    </div>
		</div>
		<div  class="clear"></div>
	</div>
	</div>
</body>
</html>