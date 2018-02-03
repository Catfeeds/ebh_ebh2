<?php
$ht = $this->input->get('ht');
if ($ht == 1) {
	$this->display('homev2/header1');
} else {
	$this->display('homev2/header');
}
?>
<?php $this->display('homev2/top');?>
<?php 
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(!empty($roominfo['crid'])){
        	$appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']); 
        }else{
       	    $is_zjdlr = false;
            $is_newzjdlr = false;
        }
?>
<?php if($is_zjdlr){ ?>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/wangind.css?v=0525" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/myind.css?v=0520" />
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/dichrt.css?v=0808" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css"/>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/data.js"></script>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style type="text/css">
	.essinfor_bottom{
		min-height:inherit;
	}
	.sktdsw{ width:82px;}
	.hrthd{border:none; height:auto;}
	.zhonsr{ font-size:14px; padding-bottom:7px; font-family:微软雅黑;}
	.grjrlqt{
		width: 95px;
	}
	.retykgd{
		padding: 10px 15px;
	}
</style>
<?php }?>
<div class="divcontent">
	<div class="conentlft">
		<div class="topbaad">
			<div class="user-main clearfix">
				<div class="lefrig" style="background:#fff;margin-top:10px;width:1000px;">
					<?php $this->display('homev2/small_menu');?>
					<div class="card-body" <?php if($is_zjdlr){echo 'style="width:1000px;padding:0px;"';}?>>
						<div class="essinfor" <?php if($is_zjdlr){echo 'style="width:930px;padding:0px 35px;"';}?>>
							<div class="jizl">
								<?php if($is_zjdlr){ ?>
									<div class="basicdata_top">
									<div class="basicdatatitle fl">基本资料</div>
								<?php }else{?>
									<div class="essinfor_top">
									<div class="title fl"><h3>基本资料</h3></div>
								<?php }?>
									<div class="bianjis fr"><a href="javascript:;" id="btn_edit" class="hrelh" onclick="editinfo()">[修改]</a></div>
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
										<?php if(!$is_zjdlr){?>
										<li class="fl"><span class="span1">昵　　称：</span><span id="nickname_span" class="span2"><?=$memberdetail['nickname'] ?></span><input type="text" style="display:none;" value="<?=$memberdetail['nickname']?>" id="nickname" maxlength="20"/></li>
										<li class="fl"><span class="span1">出生日期：</span><span  id="birthdate_span" class="span2"><?=$memberdetail['birthdate']?Date('Y-m-d',$memberdetail['birthdate']):''?></span><input id="birthdate" class="Wdate" style="display:none" type="text" value="<?=$memberdetail['birthdate']?Date('Y-m-d',$memberdetail['birthdate']):'1991-01-01'?>" onClick="WdatePicker()"></li>
										<?php }?>
										<li class="fl">
											<span class="span1">手机号码：</span><span id="mobile_span" class="span2"><?php if(!empty($memberdetail['mobile'])){echo $memberdetail['mobile'];}else{echo $memberdetail['smobile'];}?></span><input type="text" readonly="readonly" style="display:none;" id="mobile" value="<?= $memberdetail['mobile'] ?>" />
										</li>                                                                           
										<li class="fl">
											<span class="span1">电话号码：</span><span id="phone_span" class="span2"><?=$memberdetail['phone']?></span><input type="text" style="display:none;" id="phone" value="<?= $memberdetail['phone'] ?>" />
										</li>
										<?php if(!$is_zjdlr){?>
										<li class="fl"><span class="span1">Q　　 Q：</span><span id="qq_span" class="span2"><?=$memberdetail['qq']?></span><input type="text" style="display:none;" id="qq" value="<?= $memberdetail['qq'] ?>" /></li>
										<li class="fl"><span class="span1">微信账号：</span><span id="msn_span" class="span2"><?=$memberdetail['msn']?></span><input type="text" style="display:none;" id="msn" value="<?= $memberdetail['msn'] ?>" /></li>
										<li class="fl"><span class="span1">联系邮箱：</span><span id="email_span" class="span2"><?=$memberdetail['email']?></span><input type="text" readonly="readonly" style="display:none;" id="email" value="<?= $memberdetail['email'] ?>" /></li>
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
										<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
										<?php $room_type = Ebh::app()->room->getRoomType();$room_type = ($room_type == 'com') ? 1 : 0;?>
											<?php if($room_type != 1){ ?>	
												<li class="fl mt10"><span class="span1">家长姓名：</span><span id="familyname_span" class="span2"><?=$memberdetail['familyname']?></span><input type="text" style="display:none;" id="familyname" value="<?= $memberdetail['familyname'] ?>" /></li>
												<li class="fl mt10"><span class="span1">家长电话：</span><span id="familyphone_span" class="span2"><?=$memberdetail['familyphone']?></span><input type="text" style="display:none;" id="familyphone" value="<?= $memberdetail['familyphone'] ?>" /></li>
												<li class="fl"><span class="span1">家长职业：</span><span id="familyjob_span" class="span2"><?=$memberdetail['familyjob']?></span><input type="text" style="display:none;" id="familyjob" value="<?= $memberdetail['familyjob'] ?>" /></li>
												<li class="fl"><span class="span1">家长邮箱：</span><span id="familyemail_span" class="span2"><?=$memberdetail['familyemail']?></span><input type="text" style="display:none;" id="familyemail" value="<?= $memberdetail['familyemail'] ?>" /></li>
											<?php }?>
										<?php }?>
									</ul>
								</div>
								<div class="fkrer" style="display:none" id="btn_info">
									<a href="javascript:;" class="huibtn" onclick="cancelinfo()" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
									<a href="javascript:;" class="lanbtn" onclick="saveinfo()">保 存</a>
								</div>
							</div>
							<div class="clear"></div>
							<?php if(!$is_zjdlr){?>
							<div class="xqahs mt40">
								<div id="QQsqm"></div>
								<div class="essinfor_top">
									<div class="title fl"><h3>兴趣爱好</h3></div>
									<div class="bianjis fr"><a href="javascript:;" id="interest_edit" class="hrelh">[修改]</a></div>
								</div>
								<div class="clear"></div>
								<div class="essinfor_bottom mt10">
									<ul>
										<li class="fl mt10" style="width:715px; ">
											<span class="span1" style="float:left">兴趣爱好：</span>
											<div style="width:645px;float:left;">
												<span id="hobbies_span" class="span2" style="width:645px;" title="<?=$memberdetail['hobbies']?>"><?=shortstr($memberdetail['hobbies'],80)?></span>
												<textarea id="hobbies" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['hobbies']?></textarea>
											</div>
										</li>
										<li class="fl mt10" style="width:715px; ">
											<span class="span1" style="float:left">喜欢音乐：</span>
											<div style="width:645px;float:left;">
												<span id="lovemusic_span" class="span2" style="width:645px;" title="<?=$memberdetail['lovemusic']?>"><?=shortstr($memberdetail['lovemusic'],80)?></span>
												<textarea id="lovemusic" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovemusic']?></textarea>
											</div>
										</li>
										<li class="fl mt10" style="width:715px;">
											<span class="span1" style="float:left">喜欢电影：</span>
											<div style="width:645px;float:left;">
												<span id="lovemovies_span" class="span2" style="width:645px;" title="<?=$memberdetail['lovemovies']?>"><?=shortstr($memberdetail['lovemovies'],80)?></span>
												<textarea id="lovemovies" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovemovies']?></textarea>
											</div>
										</li>
										<li class="fl mt10" style="width:715px; ">
											<span class="span1" style="float:left">玩的游戏：</span>
											<div style="width:645px;float:left;">
												<span id="lovegames_span" class="span2" style="width:645px;" title="<?=$memberdetail['lovegames']?>"><?=shortstr($memberdetail['lovegames'],80)?></span>
												<textarea id="lovegames" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovegames']?></textarea>
											</div>
										</li>
										<li class="fl mt10" style="width:715px;">
											<span class="span1" style="float:left">喜欢动漫：</span>
											<div style="width:645px;float:left;">
												<span id="lovecomics_span" class="span2" style="width:645px;" title="<?=$memberdetail['lovecomics']?>"><?=shortstr($memberdetail['lovecomics'],80)?></span>
												<textarea id="lovecomics" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovecomics']?></textarea>
											</div>
										</li>
										<li class="fl mt10" style="width:715px; ">
											<span class="span1" style="float:left">玩的运动：</span>
											<div style="width:645px;float:left;">
												<span id="lovesports_span" class="span2" style="width:645px;"  title="<?=$memberdetail['lovesports']?>"><?=shortstr($memberdetail['lovesports'],80)?></span>
												<textarea id="lovesports" maxlength="200" style="resize:none;display:none;width:623px;height:30px;border:1px solid #e1e1e1;"><?=$memberdetail['lovesports']?></textarea>
											</div>
										</li>
										<li class="fl mt10" style="width:715px; ">
											<span class="span1" style="float:left">喜欢书籍：</span>
											<div style="width:645px;float:left;">
												<span id="lovebooks_span" class="span2" style="width:645px;" title="<?=$memberdetail['lovebooks']?>"><?=shortstr($memberdetail['lovebooks'],80)?></span>
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
									<div class="title fl"><h3 style="background: url(http://static.ebanhui.com/ebh/tpl/2014/images/qq_code.png) no-repeat left center;">QQ授权代码</h3></div>
									<div class="bianjis fr"><a href="javascript:;" id="qqadd_add" class="hrelh">[修改]</a></div>
								</div>
									<!--expadd begin-->
								<div id="qqadd_div" style="display:none;">
									<div class="essinfor_bottoms" style="border-top:1px solid #e1e1e1; padding-top:15px;">
										<div class="dates " >
											<div class="fl" ><a target='_blank' href="/home/profile/step.html" style="color:#4c88ff;">如何获取QQ在线状态?</a></div>
											<div class="clear"></div>
											<div class="neirong mt15">
												<div class="titless">复制QQ授权代码并将其粘贴到此处</div>
												<div class="mt10" >
													<!-- <textarea class="neirongs" style="resize:none;" id="qq_href"></textarea> -->
													<input type="text"  id="qq_href" class="neirongs" style="width:100%">
												</div>
											</div>
											<div class="clear"></div>
											<div class="fkrer">
												<a href="javascript:;" class="huibtn" id="qq_cancel" style="background:#eee;color:#000;margin-right:10px;">取 消</a>
												<a href="javascript:;" class="lanbtn" id="qq_save" >保 存</a>
											</div>
											<div class="clear"></div>
										</div>
									</div>
								</div>
								<ul id="qqlist">
									<li class="essinfor_bottoms mt15"><div><p class="olddescription" style="width:100%"><div style="width:100%" id="qq_code"><?php if(!empty($qq_href)) echo $qq_href; else echo '你还没有添加QQ授权码'; ?></div></p></div></li>
								</ul>
							</div>
							<div class="clear"></div>
							<div class="jinglis mt30">
								<div class="essinfor_tops">
									<div class="title fl"><h3>过往经历</h3></div>
									<div class="bianjis fr"><a href="javascript:;" id="expadd_add" class="hrelh">[添加]</a></div>
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
												<div class="action fr"><span class="icons edit" >编辑</span><span class="icons remove" onclick=>删除</span></div>
												<div class="date"><span class="oldbegindate"><?=$exp['begindate']?></span> — <span class="oldenddate"><?=$exp['enddate']?></span></div>
												<div><p class="olddescription"><?=$exp['description']?></p></div>
											</div>

										</li>
									<?php } ?>
								</ul>
							</div>
							<?php }?>
						</div>
						<?php if($is_zjdlr){?>
						<!--学习记录-->
						<?php if(FALSE) { ?>
				    	<div class="basicdata">
				        	<div class="basicdata_top">
				                <div class="basicdatatitle studyrecordtitle fl">学习记录</div>
				            </div>
				            <div class="clear"></div>
			            	<div class="hrthd" style="width:930px; margin-top:10px">
								<ul>
									<li class="sktdsw">
									<p class="zhonsr"><?=$baseinfo['credit']?></p>
									<p style="font-size:12px; color:#999;">积分</p>
									</li>
									<li class="sktdsw">
									<p class="zhonsr"><?=$baseinfo['mystudycount']?></p>
									<p style="font-size:12px; color:#999;">学习</p>
									</li>
									<li class="sktdsw">
									<p class="zhonsr"><?=$baseinfo['myaskcount']?></p>
									<p style="font-size:12px; color:#999;">提问</p>
									</li>
									<li class="sktdsw">
									<p class="zhonsr"><?=$baseinfo['myanscount']?></p>
									<p style="font-size:12px; color:#999;">答疑</p>
									</li>
									<li class="sktdsw">
									<p class="zhonsr"><?=$baseinfo['myreviewcount']?></p>
									<p style="font-size:12px; color:#999;">评论</p>
									</li>
								</ul>
							</div>
							<div class="clear"></div>
							<div class="retykgd">
								<input name="" id="dayfrom" style="cursor:pointer" class="grjrlqt" type="text" readonly="readonly" value="<?=Date('Y-m-d',SYSTIME-86400*30)?>" onclick="WdatePicker({onpicking:getcreditstat,dateFmt:'yyyy-MM-dd',minDate:'<?=Date('Y-m-d',SYSTIME-86400*30)?>',maxDate:'#F{$dp.$D(\'dayto\',{d:-1})||\'<?=Date('Y-m-d',SYSTIME-86400*2)?>\'}'});"/>
								<span class="etgregd">至</span>
								<input name="" id="dayto" style="cursor:pointer" class="grjrlqt" type="text" readonly="readonly" value="<?=Date('Y-m-d',SYSTIME-86400)?>" onclick="WdatePicker({onpicking:getcreditstat,dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'dayfrom\',{d:1})||\'<?=Date('Y-m-d',SYSTIME-86400*29)?>\'}',maxDate:'<?=Date('Y-m-d',SYSTIME-86400)?>'});"/>
								<div class="wegkw"><span class="mydes"></span><span class="flost">我的</span>
								<span class="xiaodes"></span><span class="flost">全校平均</span><span class="xiaogao"></span><span class="flost">全校最高</span></div>
							</div>
							<div id="chartcontainer" class="chartcontainer" style="height: 198px;"></div>
				        </div>
						<?php } ?>
				        <div class="studyrecask">
				        	<!--学习记录2-->
				        	<div class="learningrecord">
				            	<div class="learningrecordtitle">
				                	<span class="fl">学习记录</span>
				                    <p class="fr studyrecord">
				                    	<a href="javascript:void(0)" class="studyrecaskpages on" page="<?=$spage-1?>">上一页</a>
				                        <a href="javascript:void(0)" class="studyrecaskpages <?php if(!$spageflag){echo 'on';}?>" page="<?=$spage+1?>">&nbsp;&nbsp;下一页</a>
				                    </p>
				                </div>
				                <div class="learncontent" id="studyrd">
				                	<?php if(!empty($studylist)){?>
				                	<div class="learncontentleft">
				                		<?php for($i=0;$i<count($studylist);$i++){?>
				                    		<div class="learncontentleft1"></div>
				                        <?php }?>
				                    </div>
				                    <div class="learncontentright">
				                    	<?php foreach ($studylist as $key => $slist) {?>
				                    	<div class="learncontentright1" <?php if($key==0){echo 'style="margin-top:9px;"';}?>>
				                        	<div class="learntime"><span><?=timetostr($slist['startdate'],'Y-m-d');?></span></div>
				                            <div class="learntimecontent"><a href="/myroom/mycourse/<?=$slist['cwid'];?>.html" target="_blank" title="<?=$slist['titleall']?>">完成 《<?=$slist['title']?>》</a></div>
				                        </div>
				                        <?php }?>
				                    </div>
				                    <?php }else{?>
				                    	<div style="min-height:100px;"></div>
				                    <?php }?>
				                </div>
				            </div>
				            <!--我的提问/解答-->
				            <div class="learningrecord myasked-1">
				            	<div class="learningrecordtitle">
				                	<span class="fl">我的提问/解答</span>
				                    <p class="fr question">
				                    	<a href="javascript:void(0)" class="studyrecaskpages on" page="<?=$qpage-1?>">上一页</a>
				                        <a href="javascript:void(0)" class="studyrecaskpages <?php if(!$qpageflag){echo 'on';}?>" page="<?=$qpage+1?>">&nbsp;&nbsp;下一页</a>
				                    </p>
				                </div>
				                <?php if(!empty($questionlist)){?>
				                <div class="learncontent">
				                	<div class="learncontentleft">
				                	<?php for($i=0;$i<count($questionlist);$i++){?>
				                    	<div class="learncontentleft1"></div>
				                    <?php }?>
				                    </div>
				                    <div class="learncontentright">
				                    <?php foreach ($questionlist as $key=>$qlist) { ?>
				                    	<div class="learncontentright1" <?php if($key ==0){echo 'style="margin-top:9px;"';}?>>
				                        	<div class="learntime"><span><?=timetostr($qlist['dateline'],'Y-m-d');?></span></div>
				                            <div class="learntimecontent"><a href="/college/myask/<?=$qlist['qid']?>.html" target="_blank" title="<?=$qlist['titleall'];?>"><?=$qlist['title'];?></a></div>
				                        </div>
				                    <?php }?>
				                    </div>
				                </div>
				                <?php }else{?>
				                    	<div style="min-height:100px;"></div>
				                    <?php }?>

				            </div>
				        </div>
				        <div class="clear"></div>
				        <div class="studyrecask">
				        	<!--我的评论-->
				        	<div class="learningrecord myviews-1">
				            	<div class="learningrecordtitle">
				                	<span class="fl">我的评论</span>
				                    <p class="fr review">
				                    	<a href="javascript:void(0)" class="studyrecaskpages on" page="<?=$rpage-1?>">上一页</a>
				                        <a href="javascript:void(0)" class="studyrecaskpages <?=empty($rpageflag) ? 'on':''; ?>" page="<?=$rpage+1?>">&nbsp;&nbsp;下一页</a>
				                    </p>
				                </div>
				                <?php if(!empty($reviewlist)){?>
				                <div class="learncontent">
				                	<div class="learncontentleft">
				                	<?php for($i=0;$i<count($reviewlist);$i++){?>
				                    	<div class="learncontentleft1"></div>
				                    <?php }?>
				                    </div>
				                    <div class="learncontentright">
				                    <?php foreach ($reviewlist as $key => $rlist) {?>
				                    	<div class="learncontentright1" <?php if($key == 0)echo 'style="margin-top:9px;"';?>>
				                        	<div class="learntime fl"><span><?=timetostr($rlist['dateline'],'Y-m-d');?></span></div>
				                            <span class="fl biaoti-1" title="<?=$rlist['titleall']?>">《<?=$rlist['title']?>》</span>
				                            <div class="clear"></div>
				                            <div class="learntimecontent"><a href="/myroom/mycourse/<?=$rlist['toid'];?>.html" target="_blank" title="<?=$rlist['subjectall']?>"><?=$rlist['subject'];?></a></div>
				                        </div>
				                    <?php }?>
				                    </div>
				                </div>
				                <?php }else{?>
				                    	<div style="min-height:100px;"></div>
				                    <?php }?>
				            </div>
				            <!--我的笔记-->
				            <div class="learningrecord mynotes-1">
				            	<div class="learningrecordtitle">
				                	<span class="fl">我的笔记</span>
				                    <p class="fr note">
				                    	<a href="javascript:void(0)" class="studyrecaskpages on" page="<?=$npage-1?>">上一页</a>
				                        <a href="javascript:void(0)" class="studyrecaskpages <?=empty($npageflag) ? 'on':''; ?>" page="<?=$npage+1?>">&nbsp;&nbsp;下一页</a>
				                    </p>
				                </div>
				                <?php if(!empty($notelist)){?>
				                <div class="learncontent">
				                	<div class="learncontentleft">
				                	<?php for ($i=0; $i < count($notelist); $i++) { ?>
				                    	<div class="learncontentleft1"></div>
				                    <?php }?>
				                    </div>
				                    <div class="learncontentright">
				                    <?php foreach ($notelist as $key => $nlist) {?>
				                    	<div class="learncontentright1" <?php if($key == 0){echo 'style="margin-top:9px;"';}?>>
				                        	<div class="learntime fl"><span><?=timetostr($nlist['fdateline'],'Y-m-d');?></span></div>
				                            <span class="fl biaoti-1" title="<?=$nlist['titleall']?>">《<?=$nlist['title']?>》</span>
				                            <div class="clear"></div>
				                            <div class="learntimecontent"><a href="/myroom/mycourse/<?=$nlist['cwid']?>.html#notes" target="_blank" title="<?=$nlist['ftextall']?>"><?=$nlist['ftext']?></a></div>
				                        </div>
				                    <?php }?>
				                    </div>
				                </div>
				                <?php }else{?>
				                    	<div style="min-height:100px;"></div>
				                    <?php }?>
				                <?php }?>
				            </div>
				        </div>
					</div>
					<div  class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	<!--<div class="cotentrgt">
    <img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
    </div>-->
</div>
<style>
	body{
		word-break: break-all;
		word-wrap: break-word;
	}
</style>
<script type="text/javascript">
<?php if(!$is_zjdlr){?>
	var fields = new Array('cnname', 'sex', 'nickname', 'birthdate', 'mobile', 'phone', 'qq', 'msn', 'email', 'citycode', 'address', 'profile', 'familyname', 'familyphone', 'familyjob', 'familyemail');
<?php }else{?>
	var fields = new Array('cnname','sex','mobile','phone');
<?php }?>
	var fields2 = new Array('hobbies', 'lovemusic', 'lovemovies', 'lovegames', 'lovecomics', 'lovesports', 'lovebooks');
	function editinfo() {
		var span;
		var id;
		if(mainFrame) {
			addHeight(218);
		}
		for(var i = 0; i < fields.length; i++) {
			id = fields[i];
			span = $("#"+id+"_span").html();
			//初始化赋值
			if(id == 'sex') {
				span = span == '女' ? 1 : 0;
				$('input[name="sex"]').eq(span).prop("checked",true);
			}
			else if(id == 'citycode') {//设置现居地初始值

				var old_citycode = $("#old_citycode").val();

				if(old_citycode == '')
				{
					$.ajax({
						type:'post',
						url:'/admin/cities/getCities.html',
						data:{'citycode':null,'type':5},
						dateType:"html",
						success:function(_html){
							$("#address_sheng").html(_html);
						}
					});
					$("#address_shi").html('<option value="">请选择</option>');
					$("#address_qu").html('<option value="">请选择</option>');
				}
				else
				{
					$.ajax({
						type:'post',
						url:'/admin/cities/getAddr.html',
						data:{'citycode':old_citycode,'type':5},
						dateType:"html",
						success:function(_html){
							$("#zzz1").html(_html);
						}
					});
				}

			}
			else {
				$("#"+id).val(span);
			}

			//显示输入框
			if(id == "address")
			{
				$("#address_span").hide();
				$("#address_li").show();
			}
			else if(id != 'cnname' || span == '') {//except this (id==cnname && span!='')
				$("#"+id+"_span").hide();
				$("#"+id).show();
			}
		}
		//显示隐藏按钮，重设窗口高

		$("#btn_info").show();
		$("#btn_edit").hide();
	}

	function cancelinfo() {
		if(mainFrame) {
			resetHeight(218);
		}
		var id;
		for(var i = 0; i < fields.length; i++) {
			id = fields[i];
			$("#"+id+"_span").show();
			if(id == "address")
			{
				$("#address_li").hide();
			}
			else
			{
				$("#"+id).hide();
			}
		}
		//显示隐藏按钮，重设窗口高
		$("#btn_edit").show();
		$("#btn_info").hide();

	}

	function saveinfo() {
		var id;
		var value;
		var data = {};
		for(var i = 0; i < fields.length; i++) {
			id = fields[i];
			value = $("#"+id).val();
			if(id=='cnname') {
				var oldcnname = $("#cnname_span").html();
				if(oldcnname != '') {
					value = '';
				}
			}
			else if(id=='sex'){
				value = $("input[name='sex']:checked").val() ;
			}
			if(id=='citycode'){

				var sheng = $("#address_sheng").val();
				var shi = $("#address_shi").val();
				var qu = $("#address_qu").val();

				if(qu!=''){
					value=qu;
				}else if(shi!=''){
					value=shi;
				}else if(sheng!=''){
					value=sheng;
				}else{
					value='';
				}

			}
			else if(id == 'address'){
				var address = $("#address").val();
				if (address != "") {
					if (address.length>100) {
						//alert("请输入正确的地址！不超过100个字!");
						var d = dialog({
							title: '信息提示',
							content: '请输入正确的地址！不超过100个字!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {
								$("#address").focus();
							}
						});
						d.showModal();
						return false;
					}
				}
			}
			if(id!='profile'){
				value = value.replace(/"|'/gm, '');
			}

			if(id=='mobile'){
				var mv = $("#mobile").val();
				var reg = /^1\d{10}$/;
				if(mv!='' && !reg.test(mv)){
					//alert("请输入正确的手机号码！");
					var d = dialog({
						title: '信息提示',
						content: '请输入正确的手机号码！',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#mobile").focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			if(id == 'phone'){
				var phone = $("#phone").val();
				var pattern =/^\d{3,4}-\d{7,8}$/;
				if(phone!='' && !pattern.test(phone)){
					//alert("请输入正确的电话号码！格式为:区号-号码。");
					var d = dialog({
						title: '信息提示',
						content: '请输入正确的电话号码！格式为:区号-号码。',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#phone").focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			if(id == 'qq'){
				var qq = $("#qq").val();
				var pattern = /^[1-9]*[1-9][0-9]*$/;
				if(qq!='' && !pattern.test(qq)){
					//alert("请输入正确的QQ号码！");
					var d = dialog({
						title: '信息提示',
						content: '请输入正确的QQ号码！',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#qq").focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			if(id == 'email'||id=='familyemail'){
				var email = $("#"+id).val();
				var pattern =/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
				if(email!='' && !pattern.test(email)){
					//alert("请输入正确的邮箱！");
					var d = dialog({
						title: '信息提示',
						content: '请输入正确的邮箱！',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#"+id).focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			if(id == 'msn'){
				var msn = $("#msn").val();
				var pattern =/^\w{5,}$/;
				if(msn!='' && !pattern.test(msn)){
					//alert("请输入正确的微信号！");
					var d = dialog({
						title: '信息提示',
						content: '请输入正确的微信号！',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#msn").focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			if(id == 'profile'){
				var profile = $("#profile").val();
				if (profile != "") {
					if (profile.length>250) {
						//alert("请输入0-250个字符!");
						var d = dialog({
							title: '信息提示',
							content: '请输入0-250个字符!！',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {
								$("#profile").focus();
							}
						});
						d.showModal();
						return false;
					}
				}
			}
			if(id=='familyphone'){
				var mv = $("#familyphone").val();
				var reg = /^[\s\-\d]{0,20}$/;
				if(mv!='' && !reg.test(mv)){
					//alert("请输入正确的电话号码！");
					var d = dialog({
						title: '信息提示',
						content: '请输入正确的电话号码！',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#familyphone").focus();
						}
					});
					d.showModal();
					return false;
				}
			}

			data[id] = filterXSS(value);
		}

		//ajax save
		$.ajax({
			url:"<?=geturl('home/profile/editmember')?>",
			type:'post',
			data:{'data':data},
			dataType:'json',
			success:function(data){
				if(data.code==1){
					for(var i = 0; i < fields.length; i++) {
						id = fields[i];
						$("#"+id+"_span").show();
						if(id=='address')
						{
							$("#"+id+"_li").hide();
						}
						else
						{
							$("#"+id).hide();
						}

						if(id=='citycode'){
							var sheng = $('#address_sheng')[0];
							var shi = $('#address_shi')[0];
							var qu = $('#address_qu')[0];
							sheng_text = sheng.options[sheng.selectedIndex].text;
							shi_text = shi.options[shi.selectedIndex].text;
							qu_text = qu.options[qu.selectedIndex].text;
							sheng_text=(sheng_text=="请选择")?'':sheng_text;
							shi_text=(shi_text=="请选择")?'':shi_text;
							qu_text=(qu_text=="请选择")?'':qu_text;
							value = sheng_text+' '+shi_text+' '+qu_text;
							$("#citycode_span").html(value);
							$("#old_citycode").val(data.value['citycode']);
						}
						else if(id != 'cnname' || data.value['cnname'] != '')
						{
							$("#"+id+"_span").html(data.value[id]);
						}
					}
					//显示隐藏按钮
					$("#btn_edit").show();
					$("#btn_info").hide();

					if(mainFrame) {
						resetHeight(218);
					}

					var d = dialog({
						title: '信息提示',
						content: '保存成功!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
						}
					});
					d.showModal();

				}
				else
				{
					var d = dialog({
						title: '信息提示',
						content: '保存失败或没有修改项!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
						}
					});
					d.showModal();
				}
			}
		});
	}

</script>

<script type="text/javascript">
	$(function(){
		//编辑兴趣爱好
		$("#interest_edit").click(function(){
			if(mainFrame) {
				addHeight(260);
			}
			var span;
			var id;
			for(var i = 0; i < fields2.length; i++) {
				id = fields2[i];
				span = $("#"+id+"_span").html();
				if(id != 'cnname' || span == '') {//except this (id==cnname && span!='')
					$("#"+id).val(span);
					$("#"+id+"_span").hide();
					$("#"+id).show();
				}
			}
			//显示隐藏按钮，重设窗口高
			$("#interest_info").show();
			$("#interest_edit").hide();
		});

		//取消编辑兴趣爱好
		$("#interest_cancel").click(function(){
			if(mainFrame) {
				resetHeight(260);
			}
			var id;
			for(var i = 0; i < fields2.length; i++) {
				id = fields2[i];
				$("#"+id+"_span").show();
				$("#"+id).hide();
			}
			//显示隐藏按钮，重设窗口高
			$("#interest_edit").show();
			$("#interest_info").hide();
		});

		//保存兴趣爱好
		$("#interest_save").click(function(){
			var id;
			var value;
			var data = {};
			for(var i = 0; i < fields2.length; i++) {
				id = fields2[i];
				value = $("#"+id).val();
				value = value.replace(/"|'/gm, '');

				if (value.length>200) {
					//alert("请输入0-200个字符!");
					var d = dialog({
						title: '信息提示',
						content: '请输入0-200个字符!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#"+id).focus();
						}
					});
					d.showModal();
					return false;
				}
				data[id] = filterXSS(value);
			}

			//ajax save
			$.ajax({
				url:"<?=geturl('home/profile/editmember')?>",
				type:'post',
				data:{'data':data},
				dataType:'json',
				success:function(data){
					if(data.code==1){
						for(var i = 0; i < fields2.length; i++) {
							id = fields2[i];
							$("#"+id+"_span").show();
							$("#"+id).hide();
							$("#"+id+"_span").html(data.value[id]);
						}
						if(mainFrame) {
							resetHeight(260);
						}
						//显示隐藏按钮
						$("#interest_edit").show();
						$("#interest_info").hide();

						var d = dialog({
							title: '信息提示',
							content: '保存成功!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {}
						});
						d.showModal();

					}
					else
					{
						var d = dialog({
							title: '信息提示',
							content: '保存失败没有修改项!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {}
						});
						d.showModal();
					}
				}
			});
		});

		//添加过往经历
		$("#expadd_add").click(function(){
			if(mainFrame) {
				addHeight(260);
			}
			$("#expadd_add").hide();
			$("#expadd_div").show();
			//重置输入
			$("#expadd_div .begindate").val("");
			$("#expadd_div .enddate").val("");
			$("#expadd_div textarea").val("");
		});
		$("#expadd_cancel").click(function(){
			if(mainFrame) {
				resetHeight(260);
			}
			$("#expadd_div").hide();
			$("#expadd_add").show();
		});
		$("#expadd_save").click(function(){
			var begindate = filterXSS($("#expadd_div .begindate").val());
			var enddate = filterXSS($("#expadd_div .enddate").val());
			var description = filterXSS($("#expadd_div textarea").val());
			if (begindate != "") {
				if (begindate.length>20) {
					//alert("请正确填写开始时间!");
					var d = dialog({
						title: '信息提示',
						content: '请正确填写开始时间!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#expadd_div .begindate").focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			else
			{
				//alert("请填写开始时间!");
				var d = dialog({
					title: '信息提示',
					content: '请填写开始时间!',
					cancel: false,
					width:350,
					okValue:'确定',
					ok: function () {
						$("#expadd_div .begindate").focus();
					}
				});
				d.showModal();
				return false;
			}
			if (enddate != "") {
				if (enddate.length>20) {
					//alert("请正确填写结束时间!");
					var d = dialog({
						title: '信息提示',
						content: '请正确填写结束时间!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#expadd_div .enddate").focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			else
			{
				//alert("请填写结束时间!");
				var d = dialog({
					title: '信息提示',
					content: '请填写结束时间!',
					cancel: false,
					width:350,
					okValue:'确定',
					ok: function () {
						$("#expadd_div .enddate").focus();
					}
				});
				d.showModal();
				return false;
			}
			if (description != "") {
				if (description.length>200) {
					//alert("请正确描述过往经历，不能超过200个字!");
					var d = dialog({
						title: '信息提示',
						content: '请正确描述过往经历，不能超过200个字!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#expadd_div textarea").focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			else
			{
				//alert("请填写过往经历描述!");
				var d = dialog({
					title: '信息提示',
					content: '请填写过往经历描述!',
					cancel: false,
					width:350,
					okValue:'确定',
					ok: function () {
						d.close().remove();
						$("#"+exp_li+" textarea").focus();
					}
				});
				d.showModal();
				return false;
			}

			$.ajax({
				type: "POST",
				url: "<?=geturl('home/profile/addexperience')?>",
				data: {begindate:begindate, enddate:enddate, description:description},
				dataType: "json",
				success: function(data){
					if(data.code==1){
						//增加li
						if(mainFrame) {
							$("#explist").prepend('<li class="essinfor_bottoms mt15" id="exp_'+data.expid+'"><div class="expshow"><div class="action fr"><span class="icons edit" onclick="addHeight(218)">编辑</span><span class="icons remove" ">删除</span></div><div class="date"><span class="oldbegindate">'+begindate+'</span> — <span class="oldenddate">'+enddate+'</span></div><div><p class="olddescription">'+description+'</p></div></div></li>');
						}else {
							$("#explist").prepend('<li class="essinfor_bottoms mt15" id="exp_'+data.expid+'"><div class="expshow"><div class="action fr"><span class="icons edit">编辑</span><span class="icons remove">删除</span></div><div class="date"><span class="oldbegindate">'+begindate+'</span> — <span class="oldenddate">'+enddate+'</span></div><div><p class="olddescription">'+description+'</p></div></div></li>');
						}

						$("#expadd_div").hide();
						$("#expadd_add").show();

						if(mainFrame) {
							resetHeight(260);
							addHeight(84);
						}
						var d = dialog({
							title: '信息提示',
							content: '添加成功!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {

							}
						});
						d.showModal();
					}
					else
					{
						if(mainFrame) {
							resetHeight(260);
							addHeight(84);
						}
						var d = dialog({
							title: '信息提示',
							content: '添加失败!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {

							}
						});
						d.showModal();
					}
				}
			});
		});

		//显示编辑、删除按钮
		$("#explist").delegate("li", 'mouseover', function(){
			$(this).find(".action").show();
		});
		$("#explist").delegate("li", 'mouseout', function(){
			$(this).find(".action").hide();
		});
		/*点击编辑按钮 11.29.2016*/
		$('#explist .edit').click(function() {
			// console.log('1');

			if(mainFrame) {
				addHeight(218);
			}
		})

		//点击编辑
		$("#explist").delegate(".edit", 'click', function(){
			var exp_li = $(this).closest('li').attr("id");
			var oldbegindate = $("#"+exp_li).find(".oldbegindate").html();
			var oldenddate = $("#"+exp_li).find(".oldenddate").html();
			var olddescription = $("#"+exp_li).find(".olddescription").html();
			var editdiv = '';
			editdiv += '<div class="expedit"><div class="dates" >';
			editdiv += '<div class="dates" ><div class="fl" ><span class="span1s">开始时间：</span><input type="text" value="'+oldbegindate+'" class="begindate" style="width:250px;" /></div><div class="fl"><span class="span1s" style="padding-left:15px;">结束时间：</span><input type="text" value="'+oldenddate+'" class="enddate" style="width:250px;" /></div></div>';
			editdiv += '<div class="clear"></div>';
			editdiv += '<div class="neirong mt15"><div class="titless">描述过往经历（小于200字）：</div>';
			editdiv += '<div class="mt10"><textarea class="neirongs" style="width:642px;resize:none;">'+olddescription+'</textarea></div></div>';
			editdiv += '<div class="fkrer"><a style="background:#eee;color:#000;margin-right:10px;" class="huibtn" href="javascript:;">取 消</a><a class="lanbtn" href="javascript:;">保 存</a></div><div class="clear"></div></div>';
			$("#"+exp_li).append(editdiv);
			$("#"+exp_li).children(".expshow").hide();
		});

		//删除经历
		$("#explist").delegate(".remove", 'click', function(){
			var exp_li = $(this).closest('li').attr("id");
			var expid = exp_li.substr(4);
			var d = dialog({
				title: '信息提示',
				content: '您确定要删除该经历吗？',
				width:350,
				cancel: false,
				okValue:'确定',
				ok: function () {
					$.ajax({
						type: 'POST',
						url: "<?=geturl('home/profile/delexperience')?>",
						data: {expid:expid},
						dataType: 'json',
						success: function(data){
							if(data.code==1){
								$("#"+exp_li).remove();
								var d = dialog({
									skin:"ui-dialog2-tip",
									width:350,
									content: "<div class='TPic'></div><p>删除成功！</p>",
									onshow:function(){
										var that=this;
										setTimeout(function() {
											if(mainFrame) {
											resetHeight(218);
											}
										}, 2500);

										setTimeout(function () {
											that.close().remove();
											location.reload();
										}, 1000);
									}
								});
								d.showModal();
							}
							else
							{
								var d = dialog({
									skin:"ui-dialog2-tip",
									width:350,
									content: "<div class='FPic'></div><p>删除失败！</p>",
									onshow:function(){
										var that=this;
										setTimeout(function () {
											that.close().remove();
											location.reload();
										}, 1000);
									}
								});
								d.showModal();
							}
						}
					});
				}
			});
			d.showModal();
		});

		//取消编辑
		$("#explist").delegate(".huibtn", 'click', function(){
			if(mainFrame) {
				resetHeight(218);
			}
			var exp_li = $(this).closest('li').attr("id");
			$("#"+exp_li).children(".expshow").show();
			$("#"+exp_li).children(".expedit").remove();
			$("#"+exp_li).find(".action").hide();
		});

		//保存编辑
		$("#explist").delegate(".lanbtn", 'click', function(){
			var exp_li = $(this).closest('li').attr("id");
			var begindate = filterXSS($("#"+exp_li).find(".begindate").val());
			var enddate = filterXSS($("#"+exp_li).find(".enddate").val());
			var description = filterXSS($("#"+exp_li).find("textarea").val());
			var expid = exp_li.substr(4);

			if (begindate != "") {
				if (begindate.length>20) {
					//alert("请正确填写开始时间!");
					var d = dialog({
						title: '信息提示',
						content: '请正确填写开始时间!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {

							$("#"+exp_li+" .begindate").focus();
						}
					});
					d.showModal();
					return false;
				};
			}
			else
			{
				//alert("请填写开始时间!");
				var d = dialog({
					title: '信息提示',
					content: '请填写开始时间!',
					cancel: false,
					width:350,
					okValue:'确定',
					ok: function () {

						$("#"+exp_li+" .begindate").focus();
					}
				});
				d.showModal();
				return false;
			}
			if (enddate != "") {
				if (enddate.length>20) {
					//alert("请正确填写结束时间!");
					var d = dialog({
						title: '信息提示',
						content: '请正确填写结束时间!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#"+exp_li+" .enddate").focus();
						}
					});
					d.showModal();
					return false;
				};
			}
			else
			{
				//alert("请填写结束时间!");
				var d = dialog({
					title: '信息提示',
					content: '请填写结束时间!',
					cancel: false,
					width:350,
					okValue:'确定',
					ok: function () {
						$("#"+exp_li+" .enddate").focus();
					}
				});
				d.showModal();
				return false;
			}
			if (description != "") {
				if (description.length>200) {
					//alert("请正确描述过往经历，不能超过200个字!");
					var d = dialog({
						title: '信息提示',
						content: '请正确描述过往经历，不能超过200个字!',
						cancel: false,
						width:350,
						okValue:'确定',
						ok: function () {
							$("#"+exp_li+" textarea").focus();
						}
					});
					d.showModal();
					return false;
				}
			}
			else
			{
				//alert("请填写过往经历描述!");
				var d = dialog({
					title: '信息提示',
					content: '请填写过往经历描述!',
					cancel: false,
					width:350,
					okValue:'确定',
					ok: function () {
						$("#"+exp_li+" textarea").focus();
					}
				});
				d.showModal();
				return false;
			}

			$.ajax({
				type: "POST",
				url: "<?=geturl('home/profile/editexperience')?>",
				data: {expid:expid, begindate:begindate, enddate:enddate, description:description},
				dataType: "json",
				success: function(data){
					if(data.code==1){
						$("#"+exp_li).find(".oldbegindate").html(begindate);
						$("#"+exp_li).find(".oldenddate").html(enddate);
						$("#"+exp_li).find(".olddescription").html(description);
						$("#"+exp_li).children(".expshow").show();
						$("#"+exp_li).children(".expedit").remove();
						$("#"+exp_li).find(".action").hide();

						var d = dialog({
							skin:"ui-dialog2-tip",
							width:350,
							content: "<div class='TPic'></div><p>编辑成功！</p>",
							onshow:function(){
								if(mainFrame) {
									resetHeight(218);
								}
								var that=this;
								setTimeout(function () {
									that.close().remove();
									location.reload();
								}, 1000);
							}
						});
						d.showModal();
					}
					else
					{
						var d = dialog({
							skin:"ui-dialog2-tip",
							width:350,
							content: "<div class='FPic'></div><p>编辑失败或没有修改项！</p>",
							onshow:function(){
								var that=this;
								setTimeout(function () {
									if(mainFrame) {
										resetHeight(218);
									}
									that.close().remove();
									location.reload();
								}, 1000);
							}
						});
						d.showModal();
					}
				}
			});
		});

	});

	//Create By Zcq 11.28.2016
	//iframe高度自适应问题
	//设置 当前页面高度
	var offHeight = document.body.scrollHeight;
	var mainFrame = parent.document.getElementById("mainFrame");
	// 点击增加父页面iframe高度
	function addHeight(addHei) {
		parent.document.getElementById("mainFrame").style.height=(offHeight + addHei) + 'px';
		offHeight += addHei;
	}
	//点击减少父页面iframe高度
	function resetHeight(decreaseHei) {
		parent.document.getElementById("mainFrame").style.height = (offHeight - decreaseHei) + 'px';
		offHeight -= decreaseHei;
	}

$(".sktdsw").last().css('border-right','none');
getcreditstat();
function getcreditstat(dp){
	if(dp){
		if(dp.srcEl.id=='dayfrom'){
			dayfromobj = dp.cal.newdate;
			var dayfrom = dayfromobj.y+'-'+dayfromobj.M+'-'+dayfromobj.d;
			var dayto = $('#dayto').val();
			if(!dayto)
				return;
		}else{
			daytoobj = dp.cal.newdate;
			var dayfrom = $('#dayfrom').val();
			var dayto = daytoobj.y+'-'+daytoobj.M+'-'+daytoobj.d;
			if(!dayfrom)
				return;
		}
		
	}
	else{
		var dayfrom = $('#dayfrom').val();
		var dayto = $('#dayto').val();
	}
//	$.getJSON('/myroom/ghrecord/creditStat.html?dayfrom='+dayfrom+'&dayto='+dayto+'&rnd='+Math.random(), function (csv) {
//    $('#chartcontainer').highcharts({
//        data: {
//            csv: csv
//        },
//		credits:{
//		     enabled:false // 禁用版权信息
//		},
//		navigation: {
//			buttonOptions: {
//				enabled: false
//			}
//		}
//        ,
//		title: {
//			text: null
//		},
//		legend: {
//			enabled: false
//		},
//		yAxis: {
//			floor: -1,
//			allowDecimals: false,
//			
//			title: {
//				text: null
//			}
//		},
//		xAxis: {
//			labels: {
//				x:-5,
//				step:2,
//				formatter: function() {
//					return  Highcharts.dateFormat('%m-%d', this.value);
//				}
//			}
//		},
//		tooltip: {
//			dateTimeLabelFormats:{
//				day:"%A, %m-%e"
//			}
//			
//		},
//		colors:['#aed1f4','#f5d86a','#87c502'],
//		plotOptions: {
//                series: {
//                    marker: {
//                        radius: 2,  
//                        symbol: 'diamond'
//                    }
//                }
//            }
//    });
//});
}
//学习记录分页
$(".studyrecord a").on('click',function(){
	var page = $(this).attr('page');
	if($(this).hasClass('on')){
		return false;
	}
	$.ajax({
		url:'/homev2/profile/getStudyRecord.html',
		dataType:'json',
		type:'post',
		data:{page:page},
		success:function(res){
			var html = '';
			$.each(res.studylist,function(k,v){
				html+='<div class="learncontentright1"';
					if(k == 0){
						html+='style="margin-top:9px;"';
					}
				html+='>'
				      +'<div class="learntime"><span>'+v.date+'</span></div>'
				      +'<div class="learntimecontent"><a href="/myroom/mycourse/'+v.cwid+'.html" target="_blank" title="'+v.titleall+'">'+v.title+'</a></div>'
				      +'</div>';
			});
			var phtml = '';
			for(i=0;i<res.studylist.length;i++){
				phtml+='<div class="learncontentleft1"></div>';
			}
			$(".studyrecord a").removeClass('on');
			if(res.page == 1){
				$(".studyrecord a").first().addClass('on');
			}
			if(res.pageflag == false){
				$(".studyrecord a").last().addClass('on');
			}
			$(".studyrecord a").first().attr('page',(res.page-1));
			$(".studyrecord a").last().attr('page',(parseInt(res.page)+1));
			$("#studyrd .learncontentleft").html(phtml);
			$("#studyrd .learncontentright").html(html);
		}
	})
})
//答疑记录分页
$(".question a").on('click',function(){
	var page = $(this).attr('page');
	if($(this).hasClass('on')){
		return false;
	}
	$.ajax({
		url:'/homev2/profile/getQuestionList.html',
		dataType:'json',
		type:'post',
		data:{page:page},
		success:function(res){
			var html = '';
			$.each(res.questionlist,function(k,v){
				html+='<div class="learncontentright1"';
					if(k == 0){
						html+='style="margin-top:9px;"';
					}
				html+='>'
				      +'<div class="learntime"><span>'+v.date+'</span></div>'
				      +'<div class="learntimecontent"><a href="/college/myask/'+v.qid+'.html" target="_blank" title="'+v.titleall+'">'+v.title+'</a></div>'
				      +'</div>';
			});
			var phtml = '';
			for(i=0;i<res.questionlist.length;i++){
				phtml+='<div class="learncontentleft1"></div>';
			}
			$(".question a").removeClass('on');
			if(res.page == 1){
				$(".question a").first().addClass('on');
			}
			if(res.pageflag == false){
				$(".question a").last().addClass('on');
			}
			$(".question a").first().attr('page',(res.page-1));
			$(".question a").last().attr('page',(parseInt(res.page)+1));
			$(".myasked-1 .learncontentleft").html(phtml);
			$(".myasked-1 .learncontentright").html(html);
		}
	})
})
//评论记录分页
$(".review a").on('click',function(){
	var page = $(this).attr('page');
	if($(this).hasClass('on')){
		return false;
	}
	$.ajax({
		url:'/homev2/profile/getReviewList.html',
		dataType:'json',
		type:'post',
		data:{page:page},
		success:function(res){
			var html = '';
			$.each(res.reviewlist,function(k,v){
				html+='<div class="learncontentright1" ';
				if(k == 0){
					html+='style="margin-top:9px;"';
				}
				html+='>'
					+'<div class="learntime fl"><span>'+v.date+'</span></div>'
                    +'<span class="fl biaoti-1" title="'+v.titleall+'">《'+v.title+'》</span>'
                    +'<div class="clear"></div>'
                    +'<div class="learntimecontent"><a href="/myroom/mycourse/'+v.toid+'.html" target="_blank" title="'+v.subjectall+'">'+v.subject+'</a></div>'
                +'</div>';
			});
			var phtml = '';
			for(i=0;i<res.reviewlist.length;i++){
				phtml+='<div class="learncontentleft1"></div>';
			}
			$(".review a").removeClass('on');
			if(res.page == 1){
				$(".review a").first().addClass('on');
			}
			if(res.pageflag == false){
				$(".review a").last().addClass('on');
			}
			$(".review a").first().attr('page',(res.page-1));
			$(".review a").last().attr('page',(parseInt(res.page)+1));
			$(".myviews-1 .learncontentleft").html(phtml);
			$(".myviews-1 .learncontentright").html(html);
		}
	})
})
//笔记记录分页
$(".note a").on('click',function(){
	var page = $(this).attr('page');
	if($(this).hasClass('on')){
		return false;
	}
	$.ajax({
		url:'/homev2/profile/getNoteList.html',
		dataType:'json',
		type:'post',
		data:{page:page},
		success:function(res){
			var html = '';
			$.each(res.notelist,function(k,v){
				html+='<div class="learncontentright1" ';
				if(k == 0){
					html+='style="margin-top:9px;"';
				}
				html+='>'
					+'<div class="learntime fl"><span>'+v.date+'</span></div>'
                    +'<span class="fl biaoti-1" title="'+v.titleall+'">《'+v.title+'》</span>'
                    +'<div class="clear"></div>'
                    +'<div class="learntimecontent"><a href="/myroom/mycourse/'+v.cwid+'.html#notes" target="_blank" title="'+v.ftextall+'">'+v.ftext+'</a></div>'
                +'</div>';
			});
			var phtml = '';
			for(i=0;i<res.notelist.length;i++){
				phtml+='<div class="learncontentleft1"></div>';
			}
			$(".note a").removeClass('on');
			if(res.page == 1){
				$(".note a").first().addClass('on');
			}
			if(res.pageflag == false){
				$(".note a").last().addClass('on');
			}
			$(".note a").first().attr('page',(res.page-1));
			$(".note a").last().attr('page',(parseInt(res.page)+1));
			$(".mynotes-1 .learncontentleft").html(phtml);
			$(".mynotes-1 .learncontentright").html(html);
		}
	})
})

</script>
<script type="text/javascript">
	function htmlspecialchars(str){            
          str = str.replace(/&/g, '&amp;');  
          str = str.replace(/</g, '&lt;');  
          str = str.replace(/>/g, '&gt;');  
          str = str.replace(/"/g, '&quot;');  
          str = str.replace(/'/g, '&#039;');  
          return str;  
	}  
	//添加qq在线状态
		$("#qqadd_add").click(function(){
			if(mainFrame) {
				addHeight(260);
			}
			$("#qqadd_add").hide();
			$("#qqadd_div").show();
			//重置输入
			$("#qqadd_div .begindate").val("");
			$("#qqadd_div .enddate").val("");
			html = $("#qq_code").html();
			$("#qqadd_div textarea").val(html);
			$('#qqlist').hide();
		});
		$("#qq_cancel").click(function(){
			if(mainFrame) {
				resetHeight(260);
			}
			$("#qqadd_div").hide();
			$("#qqadd_add").show();
			$('#qqlist').show();
		});
		$("#qq_save").click(function(){
			var html = $("#qq_href").val();
			html = htmlspecialchars(html);
			$.ajax({
				type: "POST",
				url: "<?=geturl('home/profile/addqqhref')?>",
				data: {href:html},
				dataType: "json",
				success: function(data){
					if(data.status){
						//增加li
						$("#qq_code").html(html);
					
						// $("#qqlist").css('display','block');
						$("#qqadd_div").hide();
						$("#qqadd_add").show();
						$('#qqlist').show();
						if(mainFrame) {
							resetHeight(260);
							addHeight(84);
						}
						var d = dialog({
							title: '信息提示',
							content: '添加成功!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {

							}
						});
						d.showModal();
					}
					else
					{
						if(mainFrame) {
							resetHeight(260);
							addHeight(84);
						}
						var d = dialog({
							title: '信息提示',
							content: '添加失败!',
							cancel: false,
							width:350,
							okValue:'确定',
							ok: function () {

							}
						});
						d.showModal();
					}
				}
			});
		});
		
</script>
<?php $this->display('homev2/footer');?>