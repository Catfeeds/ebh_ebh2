<?php $this->display('forum/head');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/common.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/lookup.css?v=20171120001" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/page.css" />
<style type="text/css">
	.postmessage{
		display: none;
	    width: 84px;
	    height: 35px;
	    background: #999;
	    border-radius: 5px;
	    color: #fff!important;
	    font-size: 17px;
	    line-height: 35px;
	    position: absolute;
	    right: 35px;
	    top: 60px;
	    text-decoration: none!important;
	    padding-left: 6px;
	    outline: none;
	    text-align: center;
	}
</style>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
		<div class="lookup">
			<div class="postedtop">
				<img src="<?=$forum['image']?$forum['image']:'http://static.ebanhui.com/forum/img/community1.jpg'?>" class="postedtopimg" />
                <div class="postedson">
                	<h2 class="posttitle"><?=$forum['name']?></h2>
                    <p class="joinposted joinedbtn" data-fid="<?=$forum['fid']?>" <?php if(!$joininfo){?>style="display:none;" <?php }?>>
                        <span class="joinpostedson">已加入</span>
                        <span class="canceled">取消</span>
                    </p>
                    <p class="post_join joinbtn" data-fid="<?=$forum['fid']?>" <?php if($joininfo){?>style="display:none;" <?php }?>>
                    	<span class="join_img"></span>
       					加入
                    </p>
                    <p class="attentionpost">
                        <span class="attention">关注：</span>
                        <span class="attentionnum"><?=$forum['follow_count']?></span>
                        <span class="attention">帖子：</span>
                        <span class="attentionnum"><?=$forum['subject_count']?></span>
                    </p>
                    <p class="communitybrief">社区简介：<?=$forum['notice']?></p>
                    <p class="moderator">版主：<?php if(isset($forum['manager_name'])){echo implode(',', $forum['manager_name']);}?></p>
                </div>
                <div class="type_list">
                	<ul>
                		<li><a href="/forum.html?fid=<?=$this->input->get('fid')?>&cate_id=<?php if(isset($category['cate_id'])){echo $category['cate_id'];}?>" <?php if($cate_id == 0){ ?>class="clicked"<?php } ?>>全部<span class="sype_img"></span></a></li>
                		<?php foreach($categorys as $category){?>
                		<li><a href="/forum.html?fid=<?=$this->input->get('fid')?>&cate_id=<?=$category['cate_id']?>" <?php if($cate_id == $category['cate_id']){ ?>class="clicked"<?php }?> ><?=$category['category_name']?>(<?=$category['subject_count']?>)<span class="sype_img"></span></a></li>
                		<?php }?>
                	</ul>
                </div>
                
                <button id="postmessage1" class="post_btn" <?php if($user && $joininfo){?> onClick="Send(<?=$this->input->get('fid')?>)" style="background:#20A0FF;" <?php }else{ ?> style="background:#ccc;" <?php } ?>>
                   	<span class="btn_img"></span>
                                                   发 帖
                </button>
                <span class="postmessage" id="postmessage0">发帖 <span id="tienum"></span>s</span>
			</div>
			<div class="lookup_content">
				<div class="default_img">
					<img src="http://static.ebanhui.com/forum/img/nodata.png" />
				</div>
				<?php foreach($list as $subject){?>
				<?php
					$userData['face'] = $subject['face'];
					$userData['sex'] = $subject['sex'];
					$userData['groupid'] = $subject['groupid'];
					$avatar = getavater($userData);
				?>
				<div class="single" sid="<?=$subject['sid']?>" is_top="<?=$subject['is_top']?>" is_hot="<?=$subject['is_hot']?>">
					<img class="single_img" src="<?=$avatar?>" alt="" />
					<div class="content_txt">
						<p class="single_source"><a href="javascript:;" onclick="Open(<?=$subject['sid']?>);"><span class="single_title <?php if($subject['is_top'] == 1){?>hasstick<?php } ?>">【<?=$subject['category_name']?>】<?=$subject['title']?></span><span class="stick" style="display:<?php if($subject['is_top'] == 1){ ?>block<?php }else{ ?>none<?php } ?>">置顶</span><span class="hot" style="display:<?php if($subject['is_hot'] == 1){ ?>block<?php }else{ ?>none<?php } ?>"></span></a></p>
						<p class="single_txt"><span class="<?php if($subject['imgs'] != ''){?>mix<?php }else{ ?>text<?php } ?>"><?=shortstr(strip_tags($subject['content']),45)?></span>
							<?php if($subject['imgs'] != ''){
								$imgArr = explode('|', $subject['imgs']);
								$index = 0;
								foreach ($imgArr as $img) {
								if($index > 2){
									break;
								}
								
							?>
							<img src="<?=$img?>" alt="">
							<?php $index++; } } ?>
						</p>
						
						<p class="single_labe"><span class="txt_name"><?=$subject['realname']?$subject['realname']:$subject['username']?></span><span class="txt_time"><?=date('Y-m-d H:i:s',$subject['dateline'])?></span>
						<?php if($subject['last_reply_name'] != '' && $subject['last_reply_time'] > 0){ ?><span class="laster">最后回复 : <?=$subject['last_reply_name']?></span><span class="laster_time"><?=timetostr($subject['last_reply_time'])?></span><?php } ?></p>
					</div>
					<?php if(!$is_manager && $subject['uid'] == $user['uid']){?>
					<div class="self_delete">删除</div>
					<?php } ?>
					<?php if($is_manager){?>
					<div class="operate">
						更多操作
						<span class="operate_img"></span>
						<div class="operate_list">
							<ul>
								<li class="close_stick"><?php if($subject['is_top']){ ?>取消置顶<?php }else{ ?>置顶<?php }?></li>
								<li class="delete">删除</li>
								<li class="add_hot"><?php if($subject['is_hot']){ ?>取消热帖<?php }else{ ?>设为热帖<?php } ?></li>
							</ul>	
						</div>
					</div>
					<?php } ?>
					<div class="protion">
						<span class="num_left"><?=$subject['reply_count']?></span>
						<span class="num_cont"></span>
						<span class="num_right"><?=$subject['view_count']?></span>
					</div>
				</div>
				<?php }?>

			</div>
		<?=$pagestr?>
		</div>
		<!--删除提示-->
		<div id="delete_tips" style="display:none;">是否删除此贴</div>
		<!--取消置顶提示-->
		<div id="close_stick_tips" style="display:none;">是否取消此贴置顶设置</div>
		<!--设置热帖提示-->
		<div id="add_hot_tips" style="display:none;">是否将此贴设置为热帖</div>
		<!--加入社区-->
		<div id="join_tips">是否要加入该社区</div>
		<!--取消加入-->
		<div id="canceled_tips">是否要退出该社区</div>
	</body>
	<script type="text/javascript" src="http://static.ebanhui.com/forum/js/lookup.js?v=20170525001"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/forum/js/front.js?v=20170407002"></script>
	<script type="text/javascript">
		var $postmessage0 = $("#postmessage0");
		var $tienum = $("#tienum");
		var $postmessage1 = $("#postmessage1");
		
		var endtimefatie = getCookie("timefatie");
		var nowtimefatie = Date.parse(new Date())/1000;
		var resttimefatie = endtimefatie - nowtimefatie;
		
		if(endtimefatie == null){
			$postmessage0.css("display","none");
			$postmessage1.css("display","block");
		}else{
			if(resttimefatie <= 0){
				$postmessage0.css("display","none");
				$postmessage1.css("display","block");
			}else{
				$postmessage0.css("display","block");
				$postmessage1.css("display","none");
				$tienum.html(resttimefatie);
				var timebackfatie = setInterval(function(){
					nowtimefatie = Date.parse(new Date())/1000;
					resttimefatie = endtimefatie - nowtimefatie;
					$tienum.html(resttimefatie);
					if(resttimefatie <= 0){
						clearInterval(timebackfatie); //清除计时器
						delCookie('timefatie');//删除cookie
						$postmessage0.css("display","none");
						$postmessage1.css("display","block");
					}
				},1000);
			}
		}
			
		
		//读取cookies
		function getCookie(name){
		    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
		    if(arr=document.cookie.match(reg))
		        return (arr[2]);
		    else
		        return null;
		}
		
		//删除cookies
		function delCookie(name){
		    var exp = new Date();
		    exp.setTime(exp.getTime() - 1);
		    var cval=getCookie(name);
		    if(cval!=null)
		        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
		}
	</script>
	
</html>
