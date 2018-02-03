<?php $this->display('troomv2/page_header');
$v = getv();?>
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
	<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/teacher.css?v=0826003" rel="stylesheet" />
	<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/webuploader/webuploader.css" />
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/webuploader.min.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/webuploader/uploadv2.min.js"></script>
	<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
	<script src="http://static.ebanhui.com/ebh/js/bubbletip/bubbletip_show.js<?=$v?>"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/aroomv2-style.css"/>
	<style type="text/css">
		.control .manage a.CP_a_fuc {
			background: #18a8f7;
			color: #ffffff;
			display:block;
			margin-right:4px;
			padding:4px 6px;
			margin-top:4px;
			float:left;
			line-height:normal;
		}
		.control .manage a.CP_a_fuc:hover {
			background: #0d9be9;
			color:#fff;
			text-decoration: none;
		}
		em{
			font-style:italic;
			font-weight:inherit;
		}
		strong{
			font-style:inherit;
			font-weight:bold;
		}
		#assistant{margin-top:0;}
		.lantewu span{cursor:pointer;font-size:1.2em;}
		.lantewu span.la{color:#3399ff;}
		.htit{
			text-align:left;
		}
		.lefrig {
			#height : 1250px;
		}
		#assistant_list{margin-top: 10px;}
		.add_btn{margin-bottom: 8px;}
		.botmer {margin-top:-20px;margin-left:43px;width:410px;margin-bottom:30px;height:72px;}
		.fakstbttn {
			line-height: 36px;
			height:36px;
			border:none;
			color:#fff;
			background: #5e96f5;
			border-radius:4px;
			font-size:16px;
		}
		.equipment{
			padding-top:11px;
		}
		.address_btn{
			width:100px;
			height:32px;
			color:#fff;
			background: #5cb85c;
			border-radius: 5px;
			border:0;
			margin-top:10px;
			display:inline-block;
			text-align: center;
			line-height: 32px;
			cursor: pointer;
		}
		.address_btn:hover{
			background: #40a640;
		}
		.create_btn{
			margin-right:40px;
		}

		.grades-box{zoom:1;display:none;}
		.grades-box:after{content:'\20';clear:both;display:block;height:0;visibility:hidden;line-height:0}
		.grades{width:700px;border:1px solid #999;float:left;padding:5px 10px;margin-right:10px;margin-bottom:10px;min-height:60px;}
		div.grades span{
			font-size:14px;
			margin-right: 5px;
			margin-bottom: 5px;
			padding:2px 5px;
			border-radius:4px;
			box-sizing:border-box;
			border:1px solid transparent;
			background-color:rgba(32,160,255,.1);
			border-color:rgba(32,160,255,.2);
			color:#20a0ff;
			display:inline-block;
		}
		div.grades span i{
			border-radius: 50%;
			text-align: center;
			position: relative;
			cursor: pointer;
			transform: scale(.75);
			height: 18px;
			width: 18px;
			line-height: 18px;
			vertical-align: middle;
			top: -1px;
			right: -2px;font-family: element-icons !important;
			font-style: normal;
			font-weight: 400;
			font-variant: normal;
			text-transform: none;
			display: inline-block;
		}

		div.grades span i:hover {
			background-color: #20a0ff;
			color: #fff;
		}
		.btn-choose-grades{float:left;width:32px;height:32px;cursor:pointer;background:url(http://static.ebh.net/ebh/images/add.png) center center no-repeat;}
		.classes-panel input.search{border:1px solid #f00;}
		div.set-view-power{font-family:tahoma;line-height:30px;vertical-align:middle;}
		div.set-view-power label,div.set-view-power input{vertical-align:middle;display:inline-block;}
		.control .manage input.CP_a_fuc5{
			display:block;
			float:left;
			margin-left:8px;
			width:40px;
			border: 1px solid #CBD1DB;
		    color: #999;
		    margin-top: 5px;
		    background: #fff;
		    text-align: center;
		}
		#categoryList li span.control .manage{
			width:155px;
		}
	</style>
	<div class="lefrig">
		<?php $this->display('troomv2/course_menu');?>
		<div id='adddiv' style="display: none;"></div>
		<div id='sectiondiv' style="display: none;"></div>

		<form id="courseform" name="form">
			<input type="hidden" name="isclass" value="1" />
			<input type="hidden" id="cwid"  name="cwid" value="<?= $course['cwid']?> "/>
			<input type="hidden" id="folderid" value="<?= $course['folderid'] ?>" />
			<input type="hidden" id="sfolderid" name="sfolderid"/>
			<input type="hidden" id="cwtype" name="cwtype" value="<?=$cwtype?>" />

			<table class="user_config_tab" width="100%">
				<tr>
					<th>&nbsp;</th>
					<td>
						<input class="uipt w340" id="title" maxlength="40" type="text" onblur="teacher(this,'课件标题','title','','n','','','控制在1-40个字之间',40)" name="title" value="<?= $course['title'] ?>" />
						<span class="ts2" id="title_msg">控制在1-40个字之间</span>
					</td>
				</tr>

				<tr id ="dnone">
					<th>&nbsp;</th>
					<td>
						<select name="sectionid" id="sectionid" onblur="teacher(this,'所属目录','sectionid','','n','','','所属目录不能为空')" value="<?= $course['sid']?>" style="width:470px;">
							<option value="">请选择</option>
						</select>
						<a id="addsection" class="addsection" onclick="return false;" href="javascript:void(0);"  style="color:#315aaa;font-size: 14px;">课程目录</a>
						<span class="ts2">如果目录为空请添加新目录。</span>
					</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>
						<input class="uipt w340" id="tag" type="text" name="tag" value="<?= $course['tag']?>" onblur="teacher(this,'所属标签','tag','','n','','','多个标签之间请用逗号隔开')" />
						<span class="ts2" id="tag_msg">多个标签之间请用逗号隔开。</span>
					</td>
				</tr>
				<tr>
					<th valign="top">&nbsp;</th>
					<td style="padding-top:15px">
						<textarea class="w545 txt" id="summary" style="resize:none;" onblur="teacher(this,'课件摘要','summary','','n',10,'','请输入课件的摘要信息，字数控制在10-280个字符之间。',280)" name="summary"><?= $course['summary']?></textarea>
						<p style="line-height:22px; color:#999999;" id="summary_msg">请输入课件的摘要信息，字数控制在10-280个字符之间。</p>
					</td>
				</tr>
				<?php if($cwtype != 'live') { ?>
					<tr>
						<td colspan="2">
							<div style="width:100%;padding-left:30px;margin-top:13px;">
								<?php $editor->xEditor('message','940px','600px',$course['message']);?>
							</div>
						</td>
					</tr>
				<?php } ?>

			</table>
			<table class="user_config_tab" width="100%" style="margin-top:10px;">
				<?php if($cwtype != 'live') {?>
				<tr style="<?=($cwtype=='live') ? "display:none" : ""?>">
					<th valign="top" style="width:90px;padding:21px 5px 15px 0">文件上传：</th>
					<td><br />
						<?php
							if(empty($course['sourceid']) || empty($course['checksum'])) {
								$filelist = array();
							} else {
								$filelist = array(array('sid' => $course['sourceid'], 'checksum' => $course['checksum'], 'filename' => $course['cwname'], 'filesize' => $course['cwsize']));
							}
							$limitSize = 2;//!empty($iszjdlr) ? 2 : 1;
							$limitB = $limitSize * 1073741824;
							Ebh::app()->lib('Webuploader')->renderHtml('up',false,$filelist, array('fileSizeLimit' => $limitB));
							?>
							<span class="ts2" style="padding-left:0;">请选择要上传的文件，文件大小不超过<?=$limitSize?>G。</span>
					</td>
				</tr>
				<?php } ?>

				<!-- 上传封面逻辑开始 -->
				<?php if(!empty($folder['coursewarelogo']) || !empty($roominfo['iscollege']) ){?>
					<tr style="display:none;">
						<th valign="top" style="width:90px;">上传封面：</th>
						<td>
							<?php
							$style = empty($course['logo'])?'style="display:none;"':'';
							?>
							<a href="javascript:void(0)" onclick="uploadlogo()">点我上传</a>
							<a id="showlogo" <?=$style?> href="javascript:void(0)" onclick="showlogo()">查看</a>
							<a id="dellogo" <?=$style?> href="javascript:void(0)" onclick="dellogo()">删除</a>
							<input type="hidden" value="<?=$course['logo']?>" name="logo" id="logo" />
						</td>
					</tr>
					<!-- 上传封面逻辑结束 -->
                    <?php if (!empty($isnewzjdlr) && $cwtype!='live') { ?>
                        <tr>
                            <th valign="top">阅读间隔：</th>
                            <td>
                                <label style="margin-right:10px;"><input value="<?=$course['delaytime']?>" name="delaytime" id="noopen_chatroom" value="0" style="text-align: center; width: 35px; margin-right: 6px; height: 20px;" type="text">秒</label>
                            </td>
                        </tr>
                    <?php } ?>
					<!-- 上传课程封面 -->
					<?php
					$style = !empty($course['logo'])?'style="background:url('.$course['logo'].');"':'';
					?>
					<tr>
						<th valign="top" style="width:90px;padding-top:22px;">课件封面：</th>
						<td>
							<?php if(empty($course['logo'])){?>
								<a title="点我上传课件封面" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey" <?=$style?>><img style="float:left;" id="showclog" width=178px height=103px src="http://static.ebanhui.com/ebh/tpl/default/images/lstyjast.jpg"/></a>
							<?php }else{?>
								<a title="点我重新上传课件封面" href="javascript:void(0)"  onclick="uploadlogo()" class="jnlihrey" <?=$style?>><img style="float:left;" id="showclog" width=178px height=103px src="<?=$course['logo']?>"/></a>
							<?php }?>
							<span class="ts2" style="float:left;clear:both;">限JPG、PNG、GIF格式，图片清晰，单张图片小于1M，尺寸178px*103px</span>
						</td>
					</tr>
				<?php }?>
				<?php if($cwtype == 'live') { ?>
					<tr>
						<th valign="top" style="width:90px;padding:21px 5px 15px 0;line-height:30px;">开课时间：</th>
						<td>
							<div style="margin-top:11px;">
								<div style="float:left; display:inline;"><input type="text" id="submitat" name="submitat" class="readonly" readonly="readonly" style="text-indent:15px;height:22px;line-height:22px;border:1px solid #B3DDF4;margin:5px;display:inline;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});" value="<?= Date('Y-m-d H:i',$course['submitat']) ?>" />&nbsp;&nbsp;&nbsp;&nbsp;</div>

								<div style="clear:both;"></div>
								<span class="ts2" style="float:left;">学生在此时间段内才能学习该课件，此设置只对视频和直播课件有效</span>
							</div>
						</td>
					</tr>
					<?php if($cwtype == 'live') { ?>
					<tr>
						<th valign="top" style="width:90px;padding-top:11px;">直播类型：</th>
						<td <?php if($course['live_type'] == 3){?>class="address equipment"<?php } else {?>class="address"<?php } ?>>
							<label style="margin-right:10px;"><input type="radio" name="live_type" id="software_live" value="1" <?php if($course['live_type'] == 1){?> checked="checked" <?php } ?> style="margin-right:3px;">软件直播</label>
							<label style="margin-right:10px;"><input type="radio" id="phone_live" name="live_type" value="2"  <?php if($course['live_type'] == 2){?> checked="checked" <?php } ?> style="margin-right:3px;">手机直播</label>
							<label style="margin-right:10px;"><input type="radio" id="equipment_live" name="live_type" value="3"  <?php if($course['live_type'] == 3){?> checked="checked" <?php } ?> style="margin-right:3px;">设备直播</label>
							<label><input type="radio" id="pseudo_live" name="live_type" value="4"  <?php if($course['live_type'] == 4){?> checked="checked" <?php } ?> style="margin-right:3px;">伪直播</label>
							<div class="live_address" style="overflow:hidden;margin-top: 20px;<?php if($course['live_type'] != 3){?>display:none;<?php } ?>">
								<div class="address_show">
									<span class="address_label">推流地址：</span>
									<input type="text" class="address_url" style="width:440px;height:30px;border:1px solid #ccc;padding:0 10px;" readonly="readonly" value="<?=str_replace('[liveid]',$liveInfo['liveid'].'s',$liveInfo['pushurl'])?>"/>
								</div>
								<p style="margin-left:100px;color:#999;margin-top: 10px;">请将此推流地址复制到硬件设备中</p>
								<div class="address_bottom" style="padding-left:63px;margin-bottom: 10px;">
									<div class="create_btn address_btn" disable="true">重新生成</div>
									<div class="copy_btn address_btn">复制地址</div>
								</div>
							</div>

						</td>
					</tr>
					<input type="hidden" name="liveInfo[liveid]" value="<?=$liveInfo['liveid']?>">
					<input type="hidden" name="liveInfo[httpPullUrl]" value="<?=$liveInfo['httppullurl']?>">
					<input type="hidden" name="liveInfo[hlsPullUrl]" value="<?=$liveInfo['hlspullurl']?>">
					<input type="hidden" name="liveInfo[rtmpPullUrl]" value="<?=$liveInfo['rtmppullurl']?>">
					<input type="hidden" name="liveInfo[pushUrl]" value="<?=$liveInfo['pushurl']?>">
				<?php }?>
					<?php if($cwtype == 'live') { ?>
						<tr class="continuous" <?php if($course['live_type'] == 3 || $course['live_type'] == 4){?> style="display:none;" <?php } ?> >
							<th valign="middle" style="width:90px;padding:0 5px 0 0;">持续时间：</th>
							<td valign="middle" style="height:40px;line-height:40px;">
								<select type="text"  maxlength="100" name="cwlength" value="">
									<option value="10" <?= ($course['cwlength'] / 60 == 10) ? 'selected="selected"' : ''?> >10分钟</option>
									<option value="20" <?= $course['cwlength'] / 60 == 20 ? 'selected="selected"' : ''?> >20分钟</option>
									<option value="30" <?= $course['cwlength'] / 60 == 30 ? 'selected="selected"' : ''?> >30分钟</option>
									<option value="40" <?= $course['cwlength'] / 60 == 40 ? 'selected="selected"' : ''?> >40分钟</option>
									<option value="45" <?= $course['cwlength'] / 60 == 45 ? 'selected="selected"' : ''?> >45分钟</option>
									<option value="50" <?= $course['cwlength'] / 60 == 50 ? 'selected="selected"' : ''?> >50分钟</option>
									<option value="60" <?= $course['cwlength'] / 60 == 60 ? 'selected="selected"' : ''?> >60分钟</option>
									<option value="80" <?= $course['cwlength'] / 60 == 80 ? 'selected="selected"' : ''?> >80分钟</option>
									<option value="90" <?= $course['cwlength'] / 60 == 90 ? 'selected="selected"' : ''?> >90分钟</option>
									<option value="100" <?= $course['cwlength'] / 60 == 100 ? 'selected="selected"' : ''?> >100分钟</option>
									<option value="120" <?= $course['cwlength'] / 60 == 120 ? 'selected="selected"' : ''?> >120分钟</option>
									<option value="150" <?= $course['cwlength'] / 60 == 150 ? 'selected="selected"' : ''?> >150分钟</option>
									<option value="180" <?= $course['cwlength'] / 60 == 180 ? 'selected="selected"' : ''?> >3小时</option>
									<option value="240" <?= $course['cwlength'] / 60 == 240 ? 'selected="selected"' : ''?> >4小时</option>
									<option value="300" <?= $course['cwlength'] / 60 == 300 ? 'selected="selected"' : ''?> >5小时</option>
									<option value="360" <?= $course['cwlength'] / 60 == 360 ? 'selected="selected"' : ''?> >6小时</option>
									<option value="480" <?= $course['cwlength'] / 60 == 480 ? 'selected="selected"' : ''?> >8小时</option>
									<option value="600" <?= $course['cwlength'] / 60 == 600 ? 'selected="selected"' : ''?> >10小时</option>
									<option value="720" <?= $course['cwlength'] / 60 == 720 ? 'selected="selected"' : ''?> >12小时</option>
								</select>
							</td>
						</tr>	
						<tr class="pseudo_upload" style="<?php if($course['live_type'] != 4){?>display:none;<?php } ?>">
							<th valign="top" style="width:90px;padding:21px 5px 15px 0">文件上传：</th>
							<td><br />
								<?php
									if(empty($course['sourceid']) || empty($course['checksum'])) {
										$filelist = array();
									} else {
										$filelist = array(array('sid' => $course['sourceid'], 'checksum' => $course['checksum'], 'filename' => $course['cwname'], 'filesize' => $course['cwsize']));
									}
									$limitSize = 2;//!empty($iszjdlr) ? 2 : 1;
									$limitB = $limitSize * 1073741824;
									Ebh::app()->lib('Webuploader')->renderHtml('up',false,$filelist, array('fileSizeLimit' => $limitB));
									?>
									<span class="ts2" style="padding-left:0;">请选择要上传的文件，文件大小不超过<?=$limitSize?>G。</span>
							</td>
						</tr>
						
						<tr class="playback">
							<th valign="middle" style="width:90px;padding:0 5px 15px 0;">允许回看：</th>
							 <td class="address" style="height:50px;padding-top:7px;">
							 	<div>
						        	<label style="margin:4px 40px 0 0;"><input type="radio" value="1" checked="checked" id="is_playback" name="review" style="margin-right:3px;" <?php if($liveInfo['review'] == 1){?> checked="checked" <?php } ?> /> 是</label>
						       		<label><input type="radio" value="0" id="no_playback" name="review" style="margin-right:3px;" <?php if($liveInfo['review'] == 0){?> checked="checked" <?php } ?> />  否</label>
						       	</div>
						        <div style="clear: both;color:#999;font-size:12px;">学生在直播结束之后是否能回看直播课</div>
						    </td>
						</tr>
						<tr class="playback_time" style="<?php if($liveInfo['review'] == 0){ ?>display:none;<?php } ?>">
							<th valign="top" style="width:90px;padding:21px 5px 15px 0;">回看时间：</th>
							<td>
								<div style="margin-top:11px;">
									<div style="float:left; display:inline;">
										<input type="text" id="review_start" name="review_start" class="readonly" readonly="readonly" placeholder="请选择开始时间" style="text-indent:15px;height:22px;line-height:22px;border:1px solid #ccc;margin:5px;display:inline;margin-left: 0;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});" value="<?= !empty($liveInfo['review_start']) ? Date('Y-m-d H:i',$liveInfo['review_start']) : '' ?>"/>
									</div>
									<div style="float:left; display:inline;">
										<input type="text" id="review_end" name="review_end" class="readonly" readonly="readonly" placeholder="请选择结束时间" style="text-indent:15px;height:22px;line-height:22px;border:1px solid #ccc;margin:5px;display:inline;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'submitat\',{H:1})||\'%y-%M-%d {%H+1}:%m:%s\'}'});" value="<?= !empty($liveInfo['review_end']) ? Date('Y-m-d H:i',$liveInfo['review_end'])  : '' ?>"/>
									</div>
								</div>
							</td>	
						</tr>		
					<?php } ?>
					<?php if($assistant_enabled === true) { ?>
					<style>
						.tlist{background-color: rgb(255, 166, 49);padding: 0 7px;float: left;margin-right: 16px;position: relative;margin-bottom: 14px;}
						.tlist span{font-size: 1.2em;color: #fff;}
						.add_assistant .add_btn{font-size: 1.2em;cursor: pointer;color: #3399ff;float: left;}
						.tlist .languan{cursor: pointer;font-size: 1.2em;    position: absolute;width: 17px; height: 17px;top: -8px;right: -8px;background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/hrsire.png) no-repeat;}
					</style>
					<tr>
						<th valign="top" style="width:90px;padding:0 5px 0 0;line-height:60px;">选择助教：</th>
						<td>
							<ul id="assistant_list">
								<?php if(count($course['assistant']) > 0){?>
								<?php foreach($course['assistant'] as $val){ ?>
								<li class="tlist"><span class="languan" style="">&nbsp;</span><span><?php echo empty($val['realname']) === false ? $val['realname'] : $val['username'] ?></span><input type="hidden" class="assistantid_input" name="assistantid[]" value="<?=$val['uid']?>"></li>
								<?php } } ?>
								<li class="add_assistant">
									<span id="add_assistant_btn" class="add_btn">添加</span>
								</li>
							</ul>
						</td>
					</tr>
				<?php }} ?>
				<?php if($folder['showmode'] != 3 && $cwtype != 'live'){?>
				<tr>
					<th valign="top">开启聊天室：</th>
					<td>
						<label style="margin-right:10px;"><input type="radio" name="open_chatroom" id="noopen_chatroom" value="0" style="margin-right:3px;" <?php if($course['open_chatroom'] == 0){ ?> checked="checked" <?php } ?>>不开启</label>
						<label style="margin-right:10px;"><input type="radio" id="open_chatroom" name="open_chatroom" value="1" style="margin-right:3px;" <?php if($course['open_chatroom'] == 1){ ?> checked="checked" <?php } ?>>开启</label>
						<label style=" "><input type="radio" id="open_chatroom" name="open_chatroom" value="2" style="margin-right:3px;" <?php if($course['open_chatroom'] == 2){ ?> checked="checked" <?php } ?>>仅开启私聊</label>
						<em style="color: #ADADAD"></em>
					</td>
				</tr>
				<?php } ?>
				
				<?php if( $cwtype == 'live'){?>
				<tr>
					<th valign="top">开启群聊：</th>
					<td>
						<label style="margin-right:10px;"><input type="radio" name="open_chatroom" id="noopen_chatroom" value="0" style="margin-right:3px;" <?php if($course['open_chatroom'] == 0){ ?> checked="checked" <?php } ?>>开启</label>
						<label style="margin-right:10px;"><input type="radio" id="open_chatroom" name="open_chatroom" value="1" style="margin-right:3px;" <?php if($course['open_chatroom'] == 1){ ?> checked="checked" <?php } ?>>不开启</label>
						
					</td>
				</tr>
				<?php } ?>
				<?php if($iszjdlr){?>
				<tr>
					<th valign="top">指定讲课人：</th>
					<td>
						<div class="eeret" id="ask-for-students" style="background:url(http://static.ebanhui.com/ebh/images/xuanter.jpg) no-repeat;width:130px;padding-left:8px;height:30px;line-height:30px;">
							<a class="ekiyt" href="javascript:void(0)"><span class="show_studentname"><?=empty($userinfo['realname'])?'无':$userinfo['realname']?></span></a>
							<input type="hidden" name="tid" value="<?=empty($userinfo['uid'])?'':$userinfo['uid']?>" />
						</div>
					</td>
				</tr>
				<?php }?>
				<?php if ($roomtype == 'edu') { ?>
				<tr>
					<th valign="top" style="padding-top:1px;padding-bottom:0;line-height:30px;">观看权限：</th>
					<td valign="top">
						<div class="set-view-power"><input type="radio" value="0" checked="checked" id="view-all" name="view_power" style="margin-right:3px;"<?php if (empty($course['classids'])) { ?> checked="checked"<?php } ?> /><label for="view-all" style="margin-right:10px;">全部</label>
						<input type="radio" value="1" id="view-grade" name="view_power" style="margin-right:3px;"<?php if (!empty($course['classids'])) { ?> checked="checked"<?php } ?> /><label for="view-grade">指定班级</label></div>
						<div class="grades-box" id="grades-box"<?php if (!empty($course['classids'])) { ?> style="display:block"<?php } ?>><div class="classes-panel">
							<div class="grades" id="choose-grades"><?php if (!empty($course['classids'])) {
                                    foreach ($course['classids'] as $classitem) { ?>
                                        <span data-id="<?=$classitem['classid']?>"><?=$classitem['classname']?><i>&#935;</i><input type="hidden" value="<?=$classitem['classid']?>" name="view_power_classes[]" /></span>
                                    <?php }
                                } ?></div>
							<div class="btn-choose-grades" id="btn-choose-grades"></div>
						</div>
						<div style="display:none" id="classes-panel" class="classes-panel">
							<div class="choosed"></div>
							<div class="search"><label>班级列表</label><input type="text" placeholder="请输入班级名称"><button type="button">搜索</button></div>
							<div class="candidate">
							<?php if (!empty($classes)) {
								foreach ($classes as $class) { ?>
								<label><input type="checkbox" value="<?=$class['classid']?>" title="<?=$class['classname']?>" /><span><?=$class['classname']?></span></label>
								<?php }
							} ?>
							</div></div>
						</div>
					</td>
				</tr>
				<?php } ?>
				<?php if($roominfo['template'] == 'plate' && !empty($cwpay)){?>
				<?php if($roominfo['domain'] != 'rzxy'){ ?>
				<tr>
				<th valign="top">单课收费：</th>
					<td>
						<div class="ewartre" style="margin-top:-5px;">
							<label class="lenwsie" style="margin-right:25px;font-size:12px;color:#333"><input class="cwpay" style="vertical-align:middle;margin-right:5px;" type="radio" name="cwpay" value="0" checked="checked"/>否</label>
							<label class="lenwsie" style="font-size:12px;color:#333"><input class="cwpay" style="vertical-align:middle;margin-right:5px;" type="radio" name="cwpay" value="1" />是</label><i class="wenrtsd aboutthis" style="margin-top:9px;" tipid="cwpaytip"></i>
						</div>
					</td>
				</tr>
				<tr id="priceblock" style="display:none">
				<th valign="top"></th>
				<td>
					<div class="ewartre" id="" style="">
						<div class="botmer">
							<div class="topmer"></div>
							<p class="huisrt"><span class="huisprt" style="color:#444;">课件价格：</span><input class="husrrt intinput" name="cprice" type="text" id="priceinput" value="<?=intval($course['cprice'])?>" maxlength="5" irequired="true"/>元</p>
							<p class="huisrt">(请输入非负整数)</p>
							<p class="huisrt">
								<label>
								<span class="huisprt" style="color:#444;">课件有效期：<input class="bywhich" style="vertical-align:middle;margin-right:5px;" type="radio" name="bywhich" value="0" checked="checked"/>按月：</span><input class="husrrt intinput" name="cmonth" type="text" id="bym_input" value="<?=empty($course['cmonth'])?'':$course['cmonth']?>" maxlength="3" irequired="true"/><span class="huisprt">个月</span>
								</label>
								<label>
								<span class="huisprt"><input class="bywhich" style="vertical-align:middle;margin-right:5px;margin-left:20px;" type="radio" name="bywhich" value="1" />按日：</span><input class="husrrt intinput" name="cday" type="text" id="byd_input" value="<?=empty($course['cday'])?'':$course['cday']?>" maxlength="3" readonly="readonly" style="background:#CCC"/>日
								</label>
							</p>
						</div>
					</div>
				</td>
				</tr>
				<?php } ?>
				<?php }?>
				<tr>
					<th style="padding-top:35px;"></th>
					<td><input class="fakstbttn" name="" type="button" value="发 布" onclick="course_submit()"/><input class="qeutbtn" name="" onclick="window.history.back(-1)" value="" type="button" /></td>
				</tr>
			</table>
		</form>
		<br /><br />
	</div>
	<?php if($assistant_enabled === true) { ?>
	<div id="wxDialog" class="taneret" style="display:none">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
		<style>
			.choose_user_list{
				background: #fff none repeat scroll 0 0;
				border-bottom: 0 none;
				height: 475px;
				overflow-y: auto;
				padding: 10px 0 0 10px;
			}
			.titkets {
				border-bottom: 1px solid #f5f5f5;
				margin: 0 10px;
				min-height: 86px;
				overflow-y: auto;
			}
			.leftkes {
				color: #666;
				float: left;
				font-weight: bold;
				padding: 10px 0 0 10px;
				width: 100px;
			}
			.rigleis {
				float: left;
				padding: 2px 0;
				width: 820px;
			}
			.etklys {
				float: left;
				padding: 5px;
				position: relative;
			}
			.etklys a.auttdss {
				color: #888;
				display: block;
				padding: 5px;
			}
			.etklys .check_icon{
				background-image: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/xzh.png);
				width: 15px;
				height: 15px;
				display: block;
				position: absolute;
				left: 59px;
				top: 0px;
			}
			.auttdss img{width:50px;height:50px;}
			.xuanz {
				background: #4fcffd none repeat scroll 0 0;
				color: #fff;
				float: left;
				height: 22px;
				line-height: 22px;
				margin-bottom: 8px;
				margin-right: 6px;
				padding: 0 7px;
			}
			.xuanz a{color:#fff}
			.wxselected{background-color: #4fcffd;}
			.atfwt{padding:0px; margin:0 5px 5px; display: block;}
			input.txtshout{color:#666;font-size:14px;}
			li.etklys{width:84px;margin:0;padding:0;}

		</style>
		<div class="rtyres">
			<div class="workmet">
				<ul>
					<li id="chooseTeacherTag" class="workrent">
						<a href="javascript:;">
							选择教师
						</a>
					</li>
				</ul>
				<div class="etshout">
					<input class="txtshout" name="textarea" type="text" id="a_title" placeholder="请输入关键字" />
					<a href="javascript:;" class="shoutbtn">搜 索</a>
				</div>
			</div>
			<div id="choose-teacher" class="choose_user_list">
				<?php
				$index = count($grouparray);
				foreach($grouparray as $group){
					$index--;
					if (!empty($group['teacherlist'])) {?>
						<div class="titkets"<?php if($index === 0) { ?> style="border:0 none;"<?php } ?>>
							<div class="leftkes"><?=$group['groupname']?>：</div>
							<div class="rigleis">
								<ul>
									<?php foreach($group['teacherlist'] as $teacher){
										if(empty($teacher['face'])){
											if($teacher['sex'] == 1) {
												$teacher['face'] = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
											} else {
												$teacher['face'] ='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
											}
										}
										$teacher['face'] = getthumb($teacher['face'],'50_50');
										$teacher['showname'] = empty($teacher['realname']) ? $teacher['username'] : $teacher['realname'];
										?>
										<li class="etklys" title="<?=htmlspecialchars($teacher['showname'], ENT_COMPAT)?>">
											<a id="face_<?=$teacher['uid']?>" class="auttdss" tid="<?=$teacher['uid']?>" tname="<?=$teacher['showname']?>" href="javascript:;"><img src="<?=$teacher['face']?>"></a>
											<a class="atfwt" tid="<?=$teacher['uid']?>" tname="<?=$teacher['showname']?>" href="javascript:;"><?=htmlspecialchars(shortstr($teacher['showname'], 8), ENT_NOQUOTES)?></a>
										</li>
									<?php }?>
								</ul>
							</div>
						</div>
					<?php    }
				}?>
			</div>
			<div id="buttonbar" style="margin-top:15px;">
				<input id="fstiewes" class="fstiewes _huangbtn" name="" type="button" value="确 认" />
				<input type="button" value="取 消" onclick=""  class="wrkrshui">
			</div>
			<script type="text/javascript">
				$('.wrkrshui').click(function(){
					parent.window.H.get('wxDialog').exec('close');
				});
				$('#fstiewes').click(function(){
					if($('.tlist').length > 0){
						$('.tlist').remove();
					}
					var htmlli = "";
					for(var i=0;i<$(parent.window.document.body).find('.auttdss').length;i++){
						if( $( $(parent.window.document.body).find('.auttdss')[i] ).parent().children(".check_icon").length > 0 ){
							htmlli+='<li class="tlist">'
								+'<span class="languan" style="">&nbsp;</span>'
								+'<span>'+$($(parent.window.document.body).find('.auttdss')[i]).attr("tname")+'</span>'
								+'<input type="hidden" class="assistantid_input" name="assistantid[]" value="'+$($(parent.window.document.body).find('.auttdss')[i]).attr("tid")+'">'
								+'</li>';
						}
					};
					$('.add_assistant').before(htmlli);
					parent.window.H.get('wxDialog').exec('close');
				});
			</script>
		</div>
	</div>
	<?php } ?>
	<?php if($iszjdlr){?>
	<div class="trekt" id="studentdiv" style="display:none">
		<div class="designatedstudent" style="padding:0 0 15px 15px;">
			<div class="designatedstudent-left">
				<?php if (!empty($classes)) { foreach ($classes as $index => $classitem) { ?>
					<a href="javascript:;" class="class-1<?php if($index == 0) { ?> on<?php } ?>"<?php if(strlen($classitem['classname']) > 14){ ?> title="<?=htmlspecialchars($classitem['classname'], ENT_COMPAT)?>"<?php } ?> cid="<?=$classitem['classid']?>"><?=htmlspecialchars(shortstr($classitem['classname'], 14), ENT_NOQUOTES)?></a>
				<?php }} ?>
			</div>
			<div class="designatedstudent-right">
				<div class="diles-1">
					<input class="newsou-1" placeholder="请输入学生姓名" style="color:#999;" type="text">
					<input class="soulico-1" value="" type="button">
				</div>
				<div class="clear"></div>
				<ul>
					<?php if (!empty($students)){ foreach ($students as $student) {
						$show_name = !empty($student['realname']) ? $student['realname'] : $student['username']; ?>
						<li uid="<?=$student['uid']?>" username="<?=htmlspecialchars($show_name, ENT_COMPAT)?>">
							<div><img class="designatedstudenthead" src="<?=getavater($student,'50_50')?>"></div>
							<p class="designatedstudentname"<?php if(strlen($show_name) > 6) { ?> title="<?=htmlspecialchars(shortstr($show_name, 8), ENT_COMPAT)?>"<?php } ?>><?=shortstr($show_name, 6)?></p>
						</li>
					<?php }} ?>
				</ul>
				<div class="clear"></div>
				<div class="loading-1" style="display:none">
					<div class="loadingson-1">
						<img src="http://static.ebanhui.com/ebh/tpl/2016/images/loading_i.gif">
						<span>正在加载</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
<div style="display:none" id="tips">
	<div id="cwpaytip" style="width:158px;height:63px">
		<p>设置课件的价格、有效期后，该课件将同步至网校首页进行单独销售</p>
	</div>
</div>
<?php
	$upconfig = Ebh::app()->getConfig()->load('upconfig');
	$baseurl = $upconfig['pic']['showpath'];
?>
	<script type="text/javascript">
		var imageServer = '<?=$baseurl?>';
		$(function(){
			initsearch("title","请输入课件标题");
			initsearch("tag","请输入标签");
			initsearch("summary","请输入摘要");
		});

		function course_submit() {
			if(teacher_submit('course',param='cdisplayorder')) {
				var cwtype = $('#cwtype').val();
				var uploadfile = document.getElementById("up[sid]");
				if (cwtype=='course' && (uploadfile == null || uploadfile.value == '' || uploadfile.value == null)) {
					top.dialog({
					title:"提示信息",
					content:"您还没有上传课件文件，确定要发布吗？",
					cancelValue:"取消",
					cancel:function () {
						this.close().remove();
					},
					okValue:"确定",
					ok:function(){
						course_submit2(cwtype);
						this.close().remove();
					}
					}).showModal();

				}else{
					course_submit2(cwtype);
				}

			}
			return false;
		}
		function course_submit2(cwtype) {
				if($("#submitat").val() == "") {
					dialog({
						title:"提示",
						content:"开课时间不能为空。",
						cancel:false,
						okValue:"确定",
						ok:function () {
							this.close().remove();
						}
					}).show();
					return false;
				}
				<?php if($iszjdlr){?>
					if($("input[name=tid]").val() == ''){
						var d = dialog({
							title: '提示信息',
							content: '请选择讲课人',
							okValue: '确定',
							cancel: false,
							ok: function () {}
						});
						d.showModal();
						$(".fakstbttn").attr('disabled',false);
						return false;
					}
					<?php if($isnewzjdlr){?>
						var delaytime = $("input[name='delaytime']").val();
						if (delaytime == '' || isNaN(delaytime) || delaytime < 0 || delaytime > 99) {
	                        var d = dialog({
	                            title: '提示信息',
	                            content: '时间间隔设置错误,有效值范围[0-99]',
	                            okValue: '确定',
	                            fixed: true,
	                            cancel: false,
	                            ok: function () {}
	                        });
	                        d.showModal();
	                        $(".fakstbttn").attr('disabled',false);
	                        return false;
	                    }
					<?php }?>
				<?php }?>
				$.ajax({
					url:"<?php if($iszjdlr){echo '/troomv2/classcourse/edit.html?toid='.$toid;}else{echo '/troomv2/classcourse/edit.html';} ?>",
					type: "POST",
					data:$("#courseform").serialize(),
					dataType:"json",
					success: function(data){
						if(data != null && data != undefined && data.status == 1) {
							dialog({
								skin:"ui-dialog2-tip",
								content:"<div class='TPic'></div><p>修改课件成功</p>",
								width:350,
								onshow:function () {
									var that=this;
									setTimeout(function () {
										document.location.href = "<?= geturl('troomv2/classsubject/'.$folder['folderid']) ?>?classid=<?=$this->input->get('classid')?>";
										that.close().remove();
									}, 2000);
								}
							}).show();
						} else {
							dialog({
								skin:"ui-dialog2-tip",
								content:"<div class='FPic'></div><p>"+(data.msg || "修改失败，请稍后再试或联系管理员。")+"</p>",
								width:350,
								onshow:function () {
									var that=this;
									setTimeout(function () {
										that.close().remove();
										$(".fakstbttn").attr('disabled',false);
									}, 2000);
								}
							}).show();
						}
					}
				});
		}
		$(function(){
			$(".dis").hide();
			$("#isfree").click(function(){
				$(".dis").show();
				top.resetmain();
			});
			$("#noisfree").click(function(){
				$(".dis").hide();
				top.resetmain();

			});
			H.create(new P({
				id:'sectiondiv',
				title:'课程目录',
				easy:true,
				padding:10,
				content:$("#sectiondiv")[0]
			}),'common');

			var fid = $('#folderid').val();
			section();
			$("#addsection").click(function(){
				updatesection();
			});

			//课程输入
			$(document).on("click",'#sname',function(){
				if($(this).val()=="请输入课程目录"){
					$(this).val('');
				}
				$(this).on("blur",function(){
					if($.trim($(this).val())==''){
						$(this).val('请输入课程目录');
					}
				})
			});
		});
		function section(){
			var folderid = $('#folderid').val();
			$.ajax({
				url:"<?= geturl('troomv2/section') ?>",
				type:'post',
				data:{'folderid':folderid},
				dataType:'json',
				success:function(data){
					$('#dnone').css('display',"");
					$('#sectionid').empty();
					if(data.length==0){
						$('#sectionid').append('<option value="">请选择</option>');
						$('#sectionid').css('color','#999999');
					}else{
						$('#sectionid').css('color','#3d3d3d');
					}
					$.each(data,function(key,value){
						$('#sectionid').append('<option value="'+value.sid+'">'+value.sname+'</option>');
					});
					if(flag){
						document.getElementById("sectionid").value="<?= $course['sid'] ?>";
						flag = false;
					}
					top.resetmain();
				}
			});
		}
		var flag = true;
		function edittitle(val){
			var title = $("#"+val+"name").val();
			var displayorder = $("#"+val+"displayorder").val();
			$('#tr'+val).html('<span class="htit" style="color:#000000; width:auto;"><input class="categoryName" type="text" id="'+val+'title" value="'+title+'" maxlength="50" style="height:22px;line-height:22px;width:220px;margin-top:2px;padding:0px;"></span><input type="button" onclick="saction(\''+val+'\',\''+displayorder+'\');" class="bcun" value="确定"  style="margin-top:4px;"/>&nbsp<input type="button" onclick="editclose(\''+title+'\',\''+val+'\',\''+displayorder+'\')" class="bcun" value="取消" /><div></div>');
		}

		function editclose(title,val,displayorder){
			$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+val+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+val+')"></a><input type="text" value="'+displayorder+'" id="'+val+'displayorder" onblur="editdisplayorder('+val+')" class="CP_a_fuc5"></input></div></span><div></div>');
		}
		function editdisplayorder(val){ //数字排序

			let displayorder = $("#"+val+"displayorder").val();
			console.log(displayorder)
			if(!displayorder){
				updatesection()
			}else{
				var reg = /^[1-9]\d*$/;
				if(!reg.test(displayorder)){
					updatesection()
				}else{
					$.ajax({
						url:"/troomv2/section/updateorder.html",
						type:'post',
						data:{'sid':val,'displayorder':displayorder},
						dataType:'json',
						success:function(data){
							updatesection()
						}
					});
				}
			}
		}
		//编辑章节
		function saction(val,displayorder){
			var title =$('#'+val+'title').val();
			$.ajax({
				url:"<?= geturl('troomv2/section/edit') ?>",
				type:'post',
				data:{'sid':val,'title':title},
				dataType:'json',
				success:function(data){
					$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+val+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+val+')"></a><input type="text" value="'+displayorder+'" onblur="editdisplayorder('+val+')" id="'+val+'displayorder" class="CP_a_fuc5"></input></div></span><div></div>');
					$("#sname").val("");
				}
			});
		}
		//删除目录
		function delsction(val){
			dialog({
				title:"提示信息",
				content:"确认要删除该目录？",
				ok:function () {
					$.ajax({
						url:"<?= geturl('troomv2/section/del') ?>",
						type:'post',
						data:{'sid':val},
						dataType:'json',
						success:function(data){
							if(data.status==1){
								$("#tr"+data.sid).html('');
								updatesection();
								$("#sname").val("");
								section()
							}
						}
					});
				},
				okValue:"确定",
				cancelValue:"取消"
			}).showModal();
		}
		//添加章节
		function addsction(val){
			var sname = $('#'+val).val();
			if(sname=='请输入课程目录'){
				$('#'+val).val('');
				$('#'+val).focus();
				return false;
			}
			
			if (sname.length>50 || sname.length<1) {
				$(".SG_txtc").html('<font color="red">1-50个字符，包括中文,字母,数字</font>');
				return false;
			};
		        var folderid = $("#folderid").val();
			$.ajax({
				url:"<?= geturl('troomv2/section/add') ?>",
				type:'post',
				data:{'sname':sname,'folderid':folderid},
				dataType:'json',
				success:function(data){
					if(data.status==1){
						$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+data.sid+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+data.sid+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+data.sid+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+data.sid+')"></a><input type="text" onblur="editdisplayorder('+data.sid+')" value="'+data.displayorder+'" id="'+data.sid+'displayorder" class="CP_a_fuc5"></input></div></span><div></div></li>');
						$("#sname").val("");
						section();
					}
				}
			});
		}
		function moveup(val){
			if($("#tr"+val).prev().size()==0){
				return;
			}
			$.ajax({
				url:"<?= geturl('troomv2/section/moveup') ?>",
				type:'post',
				data:{'sid':val},
				dataType:'json',
				success:function(data){
					if(data.status==1){
						updatesection();
						$("#sname").val("");
					}
				}
			});

		}

		function movedown(val){
			if($("#tr"+val).next().size()==0){
				return;
			}
			var folderid = $("#folderid").val();
			$.ajax({
				url:"<?= geturl('troomv2/section/movedown') ?>",
				type:'post',
				data:{'sid':val},
				dataType:'json',
				success:function(data){
					if(data.status==1){
						updatesection();
						$("#sname").val("");
					}
				}
			});

		}

		var updatesection = function(){
		    var folderid = $("#folderid").val();
			$.ajax({
				url:"<?= geturl('troomv2/section') ?>",
				type:'post',
				data:{'folderid':folderid},
				dataType:'json',
				success:function(data){
					var objhtml='<div style="width:550px;">'
						objhtml+='<div id="categoryBody" style="width:515px">'
						objhtml+='<div id="categoryHead">'
						objhtml+='<table>'
						objhtml+='<tbody>'
						objhtml+='<tr>'
						objhtml+='<td>'
						objhtml+='<input class="categoryName" value="请输入课程目录" type="text" name="sname" id="sname" maxlength="50">'
						objhtml+='</td>'
						objhtml+='<td width="80">'
						objhtml+='<a class="CJsub" href="javascript:void(0);" id="ctitle" onclick="addsction(\'sname\');">'
						objhtml+='<cite>创建目录</cite>'
						objhtml+='</a>'
						objhtml+='</td>'
						objhtml+='</tr>'
						objhtml+='<tr colspan="2">'
						objhtml+='<td>'
						objhtml+='<span class="SG_txtc" style="margin-left:5px;width:290px;display:block;color:#666; text-align:left;">输入1-50个中文、英文、数字字符！</span>'
						objhtml+='</td>'
						objhtml+='</tr>'
						objhtml+='</tbody>'
						objhtml+='</table>'
						objhtml+='<div id="errTips"></div>'
						objhtml+='</div>'
						objhtml+='<form name="form" method="post">'
						objhtml+='<div id="categoryList">'
						objhtml+='<ul class="clearfix" id="tsection">'
						$.each(data,function(k,v){
							objhtml+='<li id="tr'+v.sid+'">'
							objhtml+='<span class="htit" id="'+v.sid+'catitle" ><input type="hidden" id="'+v.sid+'name" value="'+v.sname+'" />'+v.sname+'</span>'
							objhtml+='<span class="control" STYLE="FLOAT:RIGHT">'
							objhtml+='<div class="manage">'
							objhtml+='<a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+v.sid+')">'
							objhtml+='编辑</a>'
							objhtml+='<a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+v.sid+')">'
							objhtml+='删除</a>'
							objhtml+='<a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+v.sid+')">'
							objhtml+='</a>'
							objhtml+='<a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+v.sid+')">'
							objhtml+='</a>'
							objhtml+='<input type="text" value="'+v.displayorder+'" id="'+v.sid+'displayorder" onblur="editdisplayorder('+v.sid+')"  class="CP_a_fuc5">'
							objhtml+='</input>'
							objhtml+='</div>'
							objhtml+='</span>'
							objhtml+='</li>'
						});
						objhtml+='</ul>'
						objhtml+='<div class="SG_j_linedot"></div>'
						objhtml+='</div>'
						objhtml+='</form>'
						objhtml+='</div>'
						objhtml+='</div>'
						$("#sectiondiv").html(objhtml);
						H.get('sectiondiv').exec('show');
					return;
				}
			});	
		}
		$(function(){
			parent.window.preparexMulPhoto("photouploader",callback, null, 'http://up.ebh.net/uploadimageandthumb.html', 178, 103);
		});
		function uploadlogo(){
			parent.window.xmulphoto.doShow();
		}
		//flash消息通知处理接口(处理此函数的执行环境是父级框架,也就是说this为 parent.window)
		function callback(res){
			res = $.parseJSON(res);
			document.getElementById('mainFrame').contentWindow.msghandle(res);
		};
		function msghandle(res){
			if(res && res.status == 0){
				$('#showclog').attr('src', imageServer+res.data.thumb);
				$('a.jnlihrey').attr('title','点我重新上传');
				$("#logo").val(imageServer+res.data.thumb);
				$("#showlogo,#dellogo").show();
			    dialog({
				skin:"ui-dialog2-tip",
				content:"<div class='TPic'></div><p>上传成功！</p>",
				width:350,
				onshow:function () {
					var that=this;
					setTimeout(function() {
						that.close().remove();
					}, 1000);
				}
				}).show();
			}else{
				dialog({
				skin:"ui-dialog2-tip",
				content:"<div class='FPic'></div><p>上传失败！</p>",
				width:350,
				onshow:function () {
					var that=this;
					setTimeout(function() {
						that.close().remove();
					}, 2000);
				}
				}).show();
			}
			parent.window.xmulphoto.doClose();
		}
		function showlogo(){
			var src = $("#logo").val();
			parent.window.HTools.hShow("<img src='"+src+"'>",true);
		}
		function dellogo(){
			$("#logo").val('');
			$("#showlogo,#dellogo").hide();
		}

		//flash上传处理 移到下面 eker 2016年1月28日17:24:53
		var uploadComplete = function(file){
			var showname = file['name'].replace(file['type'],'');
			var title = $('#title');
			if(title.length>0 && title.val()=='请输入课件标题'){
				title.val(showname);
			}
			top.resetmain();
		}

		var fileQueued = function(file){
			if(file['size'] > 1024*1024*500){
				var d = dialog({
					title: '上传课件',
					content: '上传失败，文件大小不能超过500M。',
					okValue: '确定',
					cancel: false,
					ok: function () {}
				});
				d.showModal();
				up_swfu.cancelUpload(file['id']);
			}
		}
		var fileQueueError = function(file,code,message){
			var d = dialog({
				title: '上传课件',
				content: '上传失败，文件大小不能超过500M。',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
		}
		<?php if($assistant_enabled === true) { ?>
			$('#assistant_list').on('click','.languan',function(){
				$(this).parent().remove();

			});
			//创建dialog
			$("#choose-teacher").bind('click', function(e) {
				var otarget = null;
				var teaarr = [];
				var nodeName = e.target.nodeName.toLowerCase();
				if (nodeName == 'a') {
					otarget = $(e.target);
				} else if(nodeName == 'img') {
					otarget = $(e.target).parent('a');
				}
				if (otarget) {
					if (otarget.hasClass('auttdss') || otarget.hasClass('atfwt')) {
						var minarr2 = [];
						var name = otarget.attr('tname');
						var tid = otarget.attr('tid');
						minarr2.push(name);
						minarr2.push(tid);
						if(!$(parent.window.document.body).find('.auttdss[tid='+tid+']').parent().children().is('.check_icon')){
							$(parent.window.document.body).find('.auttdss[tid='+tid+']').parent().append('<span class="check_icon"></span>');
						}else{
							$(parent.window.document.body).find('.auttdss[tid='+tid+']').parent().find('.check_icon').remove();
						}
						return false;
					}
				}
			});

			//搜索
			var wx = '';
			$(".shoutbtn").bind('click', function(){
				var uname = $("#a_title", parent.document).val().replace(/\s+/g,"");
				$('li.etklys', parent.document).show();
				$("div.titkets",parent.document).show();
				if(uname == wx){
					return;
				}
				var faceid = '';//第一个搜索到的名字
				$.each($(".atfwt",parent.document),function(idx,obj){
					if($(obj).html().replace(/\s+/g,"").indexOf(uname) == -1){
						/*if (faceid == '') faceid = "face_"+$(obj).attr("tid");
						$(obj).addClass('wxselected');*/
						$(obj).parent('li').hide();
					} else {
						if (faceid == '') {
							faceid = "face_" + $(obj).attr("tid");
						}
						$(obj).parent('li').show();
					}
				});
				$("div.titkets",parent.document).each(function() {
					var target = $(this);
					if(target.find('ul li:visible').size() == 0) {
						target.hide();
					} else {
						target.show();
					}
				});

				if (faceid != '') {
					parent.window.location.hash = faceid;//定位到第一个人的位置
				}
			});
			$("#a_title").bind('keypress', function(e) {
				if(e.keyCode == 13) {
					$(".shoutbtn", parent.document).trigger('click');
				}
			});
			parent.window.H.remove('wxDialog');
			$('#wxDialog',parent.window.document.body).remove();
			parent.window.H.create(new P({
				id:'wxDialog',
				title:'选择助教',
				easy:true,
				content:$("#wxDialog")[0]
			}),'common');
			//添加助教按钮
			$('#add_assistant_btn').click(function(){
				$(parent.window.document.body).find('.auttdss').parent().find('.check_icon').remove();
				var assistantidinput = $('.assistantid_input');
				if(assistantidinput.length > 0){
					for(var index=0;index < assistantidinput.length;index++){
						$(parent.window.document.body).find('.auttdss[tid='+$(assistantidinput[index]).val()+']').parent().append('<span class="check_icon"></span>');
						name = $(assistantidinput[index]).prev().innerHTML;
					}
				}
				parent.window.H.get('wxDialog').exec('show');
				$('li.etklys', parent.document).show();
				$("div.titkets",parent.document).show();
				$("#a_title", parent.document).val("");
			});
		<?php } ?>
				//向学生提问，选学生
(function($) {
	var chooseClasses = <?=empty($course['classids']) ? 'false' : 'true' ?>;
	var page = 1;
	var finished = false;
	var loading = false;
	function ajaxStudents(args, box) {
		if (args.page > 1) {
			loading = true;
		}
		$.ajax({
			url: '/troomv2/classcourse/ajax_students.html',
			data: args,
			dataType: 'json',
			type: 'get',
			cache: false,
			success: function(ret) {
				var ul = box.find('div.designatedstudent-right ul');
				if (ret) {
					var l = ret.length;
					var html = [];
					for(var i = 0; i < l; i++) {
						html[i] = '<li uid="' + ret[i].uid + '" username="' + ret[i].showname + '">'
							+ '	<div><img class="designatedstudenthead" src="' + ret[i].photo + '"></div>'
							+ '	<p class="designatedstudentname"'+ (ret[i].showname ? ' title="'+ ret[i].showname + '"' : '') + '>' + ret[i].shortname + '</p>'
							+ '</li>';
					}

					if (l < 35) {
						finished = true;
					}
					box.find('div.loading-1').hide();
					if (page == 1) {
						ul.html(html.join(''));
						return;
					}
					if (loading == false) {
						return;
					}
					loading = false;
					ul.append(html.join(''));
					return;
				}
				if (args.page == 1) {
					ul.empty();
				}
				box.find('div.loading-1').hide();
				ul.html('没有该学生！');
				finished = true;
			}
		});
	}
	$("#ask-for-students").bind('click', function() {
		finished = loading = false;
		page = 1;
		var studentDialog = dialog({
			id: 'student-dialog',
			title: '指定学生',
			content: $("#studentdiv").html(),
			fixed: true,
			padding: 0,
			onshow: function() {
				//绑定事件
				var that = this;
				var dia = $(this.node);
				finished = dia.find('div.designatedstudent-right ul li').size() < 35;
				dia.find("div.designatedstudent-right").scrollTop(0);
				dia.find("div.designatedstudent-left").scrollTop(0);
				dia.bind('click', function(e) {
					var t = $(e.target);
					//选择班级
					if (t.hasClass('class-1')) {
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						dia.find('.designatedstudent-left a.on').removeClass('on');
						t.addClass('on');
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						ajaxStudents({ 'cid': t.attr('cid'), 'page': page }, dia);
						return true;
					}
					//选择学生
					if (t.hasClass('designatedstudenthead') || t.hasClass('designatedstudentname')) {
						var li = t.parents('li');
						$("#ask-for-students span.show_studentname").html(li.attr('username').substring(0,8));
						$("#ask-for-students input[name='tid']").val(li.attr('uid'));
						that.close().remove();
						return true;
					}
					//点击搜索
					if (t.hasClass('soulico-1')) {
						//搜索学生
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						dia.find('.designatedstudent-left a.on').removeClass('on');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'page': page }, dia);
						return true;
					}
					return false;
				});
				//回车搜索
				dia.find('input.newsou-1').bind('keypress', function(e) {
					if (e.keyCode == 13) {
						dia.find("div.designatedstudent-right").animate({scrollTop:0}, 0);
						page = 1;
						finished = false;
						loading = false;
						dia.find('div.loading-1').hide();
						dia.find('.designatedstudent-left a.on').removeClass('on');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'page': page }, dia);
					};
				});
				//加载更多
				dia.find("div.designatedstudent-right").scroll(function(){
					if (finished || loading) {
						return;
					}
					dia.find('div.loading-1').show();
					var nScrollHight = $(this)[0].scrollHeight;
					var nScrollTop = $(this)[0].scrollTop;
					if(nScrollTop + $(this).height() >= nScrollHight)   {
						page++;
						var cid = dia.find('.designatedstudent-left a.on').attr('cid');
						ajaxStudents({ 'q': $.trim(dia.find('input.newsou-1').val()), 'cid': cid, 'page': page }, dia);
					}
				});
			}
		});
		studentDialog.showModal();
	});
	$(window).bind('load', function() {
		if (chooseClasses) {
			$("input[name='cwpay'][value='0']").trigger('click');
			$("input[name='cwpay']").attr('disabled', 'disabled');
			$("#view-grade").trigger("click");
		} else {
			$("#view-all").trigger("click");
		}

	});
	$("input[name='view_power']").bind('change', function() {
		var val = $(this).val();
		if (val == 1) {
			$("#grades-box").show();
			$("input[name='cwpay'][value='0']").trigger('click');
			$("input[name='cwpay']").attr('disabled', 'disabled');
		} else {
			$("#grades-box").hide();
			$("input[name='cwpay']").removeAttr('disabled');
		}
		parent.resetmain();
	});
	$("#btn-choose-grades").bind('click', function() {
		var chooseIds = [];
		$("#choose-grades span").each(function(){
			chooseIds.push($(this).data('id'));
		});
		top.dialog({
			title: '选择班级',
			height: 600,
			width: 700,
			content: $("#classes-panel").html(),
			onshow:function() {
				var node = $(this.node);
				//绑定事件
				node.find('.candidate').bind('click', function(e) {
					var nodeName = e.target.nodeName.toLowerCase();
					if (nodeName != 'span' && nodeName != 'label' && nodeName != 'input') {
						return false;
					}
					if (nodeName == 'input') {
						target = $(e.target);
						var classitem = node.find(".choosed span[data-id='"+target.val()+"']");
						if (classitem.size() == 0) {
							node.find('.choosed').append('<span data-id="'+target.val()+'">'+target.attr('title')+'<i>&#935;</i><input type="hidden" value="' + target.val() + '" name="view_power_classes[]" /></span>');
						} else {
							classitem.remove();
						}
					}

				});
				node.find('.choosed').bind('click', function(e) {
					if (e.target.nodeName.toLowerCase() != 'i') {
						return false;
					}
					$(e.target).parent().remove();
					var classid = $(e.target).parent().data('id');
					node.find(".candidate input[value='"+classid+"']").prop("checked", false);
				});
				node.find('.search button').bind('click', function() {
					var keyword = $.trim(node.find('.search input').val());
					if (keyword == '') {
						node.find('.candidate label').show();
						return;
					}
					node.find('.candidate label').each(function(){
						var classname = $(this).find('input').attr('title');
						if (classname.indexOf(keyword) > -1) {
							$(this).show();
						} else {
							$(this).hide();
						}
					});
				});
				//初始化状态
				var l = chooseIds.length;
				if (l == 0) {
					return;
				}
				var checkbox = null;
				for (var i = 0; i < l; i++) {
					checkbox = node.find(".candidate input[value='" + chooseIds[i] + "']");
					checkbox.prop('checked', true);
					node.find('.choosed').append('<span data-id="'+checkbox.val()+'">'+checkbox.attr('title')+'<i>&#935;</i><input type="hidden" value="' + checkbox.val() + '" name="view_power_classes[]" /></span>');
				}
			},
			cancelValue: '取消',
			cancel: function() {},
			okValue: '确定',
			ok: function () {
				var node = $(this.node);
				var html = node.find('.choosed').html();
				$("#choose-grades").html(html);
				parent.resetmain();
			}
		}).showModal();
	});
	$("#choose-grades").bind('click', function(e) {
		if (e.target.nodeName.toLowerCase() != 'i') {
			return false;
		}
		$($(e.target).parent()).remove();
		parent.resetmain();
		return false;
	});
})(jQuery);
	$(function(){
		var cwpay = <?=$course['cwpay']?>;
		$('.cwpay[value='+cwpay+']').trigger('click');
		var cday = <?=empty($course['cday'])?0:1?>;
		$('.bywhich[value='+cday+']').trigger('click');
	})

	$('.cwpay').click(function(){
		if($(this).val()==1){
			$('#priceblock').show();
			$('#priceinput').attr('irequired',true);
		}else{
			$('#priceblock').hide();
			$('#priceinput').attr('irequired',false);
		}
		top.resetmain();
	});

	$(document).on('keyup','.intinput',function(){
		$(this).val($(this).val().replace(/[^\d]/g,'').replace(/0*(\d+)/g,"$1"));

	}).on('keyup','#bym_input,#byd_input',function(){
		if($(this).val()==0)
			$(this).val('');
	}).on('keyup','#bym_input',function(){
		if($(this).val()>36)
			$(this).val(36);
	}).on('keyup','#priceinput',function(){
		if($(this).length>5)
			$(this).val($(this).val().substr(0,5));
	});

	$('.bywhich').click(function(){
		if($(this).val() == 0){
			$('#byd_input').attr('readonly','readonly').attr('irequired',false).css('background','#CCC');
			$('#bym_input').attr('irequired',true).removeAttr('readonly').css('background','#fff');
		}else{
			$('#bym_input').attr('readonly','readonly').attr('irequired',false).css('background','#CCC');
			$('#byd_input').attr('irequired',true).removeAttr('readonly').css('background','#fff');
		}
	});

	function checkirequired(){
		if($('#priceblock').css('display')=='none')
			return true;
		var elements = $('input[irequired=true],select[irequired=true],textarea[irequired=true]');
		var notfill;
		$.each(elements,function(k,v){
			if($.trim($(this).val())=='' || (v.tagName=='SELECT' && $(this).val() == 0)){

				notfill = $(this);
				return false;
			}
		});
		// c(notfill);
		if(notfill){
			notfill.focus();
			playnotice(notfill);
			return false;
		}
		return true;
	}
	$('input[irequired=true],textarea[irequired=true]').keyup(function(){
		if($.trim($(this).val()) != '')
			$(this).removeClass('borderred');
	})
	function playnotice(target){
		$('.borderred').removeClass('borderred');
		var times = 0;
		var itv = setInterval(function(){
			if(times<5){
				target.toggleClass('borderred');
				times++;
			}else{
				clearInterval(itv);
			}
		},200);
	}
	//直播视频类型选择
	$("input[name='live_type']").change(function(){
        var id = $("input[name='live_type']:checked").val();
        if(id == 3){    //设备直播
        	$(".live_address").fadeIn();
        	$(".address").addClass("equipment");
        	$(".continuous").hide();
        	$(".pseudo_upload").hide();
        }else
        if(id == 4){    //伪直播
        	$(".pseudo_upload").fadeIn();
        	$(".live_address").hide();
        	$(".continuous").show();
        	$(".continuous").hide();
        }else{
        	$(".address").removeClass("equipment");
        	$(".live_address").hide();
        	$(".pseudo_upload").hide();
        	$(".continuous").show();
        }
        parent.resetmain();
    });
    //是否允许回看选择
    $("input[name='review']").change(function(){
    	var id = $("input[name='review']:checked").val();
    	if(id == 1){
    		$(".playback_time").show();
    	}else{
    		$(".playback_time").hide();
    	}
    	parent.resetmain();
    });
	//生成推流地址
	$(".create_btn").on("click",function(){
		var that = this;
		if($(that).attr("disable") == "false"){
			return;
		}
		if($('#submitat').val() == ''){
			dialog({
				skin:"ui-dialog2-tip",
				content:"<div class='FPic'></div><p>请先输入开课时间</p >",
				width:350,
				onshow:function () {
					var that=this;
					setTimeout(function () {
						that.close().remove();
					}, 2000);
				}
			}).show();

			return;
		}
		$(that).attr("disable","false");
		$(that).css("background","#ccc");
		$.ajax({
			type:'POST',
			url:'/troomv2/classcourse/addLive.html',
			dataType:'json',
			data:{submitat:$('#submitat').val()},
			success:function(data){
				if(data.status == 1){
					$(that).html("重新生成");
					$('.address_url').val(data.data.pushUrl.replace('[liveid]',data.data.liveid) + 's');
					$("input[name='liveInfo[liveid]']").val(data.data.liveid);
					$("input[name='liveInfo[httpPullUrl]']").val(data.data.httpPullUrl);
					$("input[name='liveInfo[hlsPullUrl]']").val(data.data.hlsPullUrl);
					$("input[name='liveInfo[rtmpPullUrl]']").val(data.data.rtmpPullUrl);
					$("input[name='liveInfo[pushUrl]']").val(data.data.pushUrl);
					$(that).css("background","#5cb85c");
					$(that).attr("disable","true");
				}else{
					dialog({
						skin:"ui-dialog2-tip",
						content:"<div class='FPic'></div><p>"+data.msg+"</p >",
						width:350,
						onshow:function () {
							var that=this;
							setTimeout(function () {
								that.close().remove();
							}, 2000);
						}
					}).show();
				}
			}
		});

	});
	//复制地址
	$(".copy_btn").on("click",function(){
		$('.address_url').trigger('select');
  		document.execCommand('copy');
	});
	
	</script>
<?php $this->display('troomv2/page_footer'); ?>